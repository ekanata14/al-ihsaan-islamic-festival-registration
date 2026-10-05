<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Events\AdminDataChanged;
use App\Events\RegistrationCreated;
use App\Events\UserDataChanged;
use App\Support\ActivityLogger;
use App\Support\PaymentService;
use App\Support\RegistrationRules;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode as QRCode;

// Models
use App\Models\Competition;
use App\Models\Category;
use App\Models\Registration;
use App\Models\Participant;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Mulai query dasar (hanya ambil yang open)
        $query = Competition::where('status', 'open')->latest();

        // Jika ada input pencarian, filter berdasarkan nama lomba
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $viewData = [
            "title" => "User Dashboard",
            "competitions" => $query->get(), // Eksekusi query
            'category_id' => '0',
            'categories' => Category::latest()->get(),
        ];

        return view("user.dashboard", $viewData);
    }


    public function registeredParticipants(Request $request)
    {
        $search = $request->input('search');

        // Pastikan hanya mengambil data milik user yang sedang login
        $query = Registration::where('pic_id', auth()->user()->id);

        if ($search) {
            $query->where(function ($q) use ($search) {
                // Cari dari Nomor Registrasi
                $q->where('registration_number', 'like', "%{$search}%")
                    // Cari dari Nama Peserta
                    ->orWhereHas('participants', function ($partQuery) use ($search) {
                        $partQuery->where('name', 'like', "%{$search}%");
                    })
                    // Cari dari Nama Lomba / Kategori
                    ->orWhereHas('competition', function ($compQuery) use ($search) {
                        $compQuery->where('name', 'like', "%{$search}%")
                            ->orWhereHas('category', function ($catQuery) use ($search) {
                                $catQuery->where('name', 'like', "%{$search}%");
                            });
                    });
            });
        }

        $registrations = $query->latest()->paginate(10)->appends(['search' => $search]);

        $viewData = [
            "title" => "My Registrations",
            "datas" => $registrations,
            "search" => $search // Kirim keyword search ke view
        ];

        return view("user.competition-registration-datas", $viewData);
    }

    public function getCompetitionByCategory(string $id)
    {
        $competitions = Competition::where('category_id', $id)->where('status', 'open')->latest()->get();
        $viewData = [
            "title" => "Competitions",
            "competitions" => $competitions,
            'category_id' => $id,
            'categories' => Category::latest()->get(),
        ];

        return view("user.dashboard", $viewData);
    }

    public function competitionDetail(string $id)
    {
        $competition = Competition::findOrFail($id);
        $participants = Registration::where('pic_id', auth()->user()->id)
            ->where('competition_id', $id)
            ->with('participants') // Eager load participants
            ->get()
            ->pluck('participants') // Extract participants from the registrations
            ->flatten(); // Flatten the collection to get a single list of participants
        $viewData = [
            "title" => "Competition Detail",
            "data" => $competition,
            'categories' => Category::latest()->get(),
            'participants' => $participants,
        ];

        return view("user.competition-detail", $viewData);
    }

    public function competitionRegistration(string $id)
    {
        $competition = Competition::findOrFail($id);
        $viewData = [
            "title" => "Competition Registration",
            "data" => $competition,
            'categories' => Category::latest()->get(),
            'participants' => [],
        ];

        return view("user.competition-registration", $viewData);
    }

    public function competitionRegistrationStore(Request $request, RegistrationRules $rules)
    {
        $validatedData = $request->validate([
            'competition_id' => 'required|exists:competitions,id',
            'total_participants' => 'required|integer',
            'participants' => 'required|array',
            'participants.*.name' => 'required|string',
            'participants.*.age' => 'required|integer|min:1',
            'participants.*.nik' => 'required|string',
            'participants.*.birth_place' => 'required|string',
            'participants.*.birth_date' => 'required|date',
            'participants.*.photo_url' => 'required|file|mimes:jpeg,png,pdf',
            'participants.*.certificate_url' => 'required|file|mimes:jpeg,png,pdf',
        ]);

        $competition = Competition::findOrFail($validatedData['competition_id']);
        $pic = $request->user();

        // Aturan bisnis: maksimal 2 lomba/anak, bentrok jadwal, ganda, batas umur.
        $rules->validate($pic, $competition, $validatedData['participants']);

        try {
            DB::beginTransaction();
            // Create registration number
            $registrationNumber = 'AIIF-' . now()->format('dmY') . '-' . Str::random(6);
            // Create the registration
            $registration = Registration::create([
                'registration_number' => $registrationNumber,
                'pic_id' => $pic->id,
                'competition_id' => $validatedData['competition_id'],
                'total_participants' => $validatedData['total_participants'],
                'group_id' => $pic->group_id,
                'status' => 'registered',
            ]);

            // Loop through participants and save them
            foreach ($validatedData['participants'] as $participantData) {
                // Resolve identitas anak (unik per PIC berdasarkan NIK)
                $child = $rules->resolveChild($pic, $participantData);

                // Handle file upload for certificate_url
                $certificatePath = $participantData['certificate_url']->store('certificates', 'public');
                $photoPath = $participantData['photo_url']->store('participants', 'public');

                Participant::create([
                    'registration_id' => $registration->id,
                    'child_id' => $child->id,
                    'name' => $participantData['name'],
                    'age' => $participantData['age'],
                    'birth_place' => $participantData['birth_place'],
                    'birth_date' => $participantData['birth_date'],
                    'nik' => $participantData['nik'],
                    'photo_url' => $photoPath,
                    'certificate_url' => $certificatePath,
                ]);
            }
            DB::commit();

            // Hitung ulang tagihan bila PIC sudah punya tagihan.
            app(PaymentService::class)->syncIfExists($pic);

            $competitionName = $competition->name ?? '-';
            $participantCount = count($validatedData['participants']);

            ActivityLogger::log(
                'registration.created',
                'Pendaftaran lomba baru: ' . $competitionName . ' (' . $participantCount . ' peserta)',
                $registration
            );

            event(new RegistrationCreated(
                $registration->registration_number,
                $competitionName,
                $pic->name,
                $participantCount
            ));
            event(new AdminDataChanged('registration', 'created', $registration->id));
            event(new UserDataChanged($pic->id, 'registration', 'created', $registration->id));

            return redirect()->route('user.participants')->with('success', 'Registration and participants saved successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function competitionRegistrationDetail(string $id)
    {
        // Batasi hanya data milik PIC yang sedang login (cegah akses lewat ID).
        $registration = Registration::where('pic_id', auth()->id())->findOrFail($id);
        $viewData = [
            'title' => 'Registration Detail',
            'data' => $registration,
        ];

        return view('user.competition-registration-detail', $viewData);
    }

    public function competitionRegistrationQR(string $id)
    {
        // Batasi hanya data milik PIC yang sedang login (cegah akses lewat ID).
        $registration = Registration::where('pic_id', auth()->id())->findOrFail($id);

        // Generate QR code based on the registration ID
        $qrCode = QRCode::size(200)->generate($registration->registration_number);

        $viewData = [
            'title' => 'Registration QR Code',
            'data' => $registration,
            'qrCode' => $qrCode,
        ];

        return view('user.competition-registration-qr', $viewData);
    }
}
