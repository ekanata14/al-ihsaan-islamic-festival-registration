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
use App\Models\CheckIn;

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
            "title" => "Dashboard",
            "competitions" => $query->get(), // Eksekusi query
            'category_id' => '0',
            'categories' => Category::latest()->get(),
            'unpaid' => app(PaymentService::class)->unpaidFor($request->user()),
            'competitionProgress' => $this->competitionProgressFor($request->user()),
        ];

        return view("user.dashboard", $viewData);
    }

    /**
     * Progres antrian tiap lomba yang diikuti PIC: nomor urut terakhir dipanggil,
     * jumlah check-in, total peserta, dan nomor urut milik PIC.
     */
    private function competitionProgressFor($pic)
    {
        $registrations = Registration::where('pic_id', $pic->id)
            ->with(['competition.category', 'participants.checkIn'])
            ->get();

        $competitionIds = $registrations->pluck('competition_id')->unique()->filter()->values();

        if ($competitionIds->isEmpty()) {
            return collect();
        }

        $progress = CheckIn::whereIn('competition_id', $competitionIds)
            ->selectRaw('competition_id, MAX(participant_number) as current_number, COUNT(*) as checked_in')
            ->groupBy('competition_id')
            ->get()
            ->keyBy('competition_id');

        $totals = Participant::query()
            ->join('registrations', 'participants.registration_id', '=', 'registrations.id')
            ->whereIn('registrations.competition_id', $competitionIds)
            ->selectRaw('registrations.competition_id as competition_id, COUNT(*) as total')
            ->groupBy('registrations.competition_id')
            ->pluck('total', 'competition_id');

        return $registrations->groupBy('competition_id')->map(function ($regs, $competitionId) use ($progress, $totals) {
            $competition = optional($regs->first())->competition;

            if (! $competition) {
                return null;
            }

            $item = $progress->get($competitionId);
            $myNumbers = $regs
                ->flatMap(fn ($r) => $r->participants->pluck('checkIn')->filter()->pluck('participant_number'))
                ->filter()
                ->values();

            return [
                'competition' => $competition,
                'current_number' => (int) ($item->current_number ?? 0),
                'checked_in' => (int) ($item->checked_in ?? 0),
                'total' => (int) ($totals[$competitionId] ?? 0),
                'my_numbers' => $myNumbers,
            ];
        })->filter()->sortByDesc('checked_in')->values();
    }


    public function registeredParticipants(Request $request)
    {
        $search = $request->input('search');

        // Pastikan hanya mengambil data milik user yang sedang login
        $query = Registration::where('pic_id', auth()->user()->id);
        $query->with(['checkIn', 'competition.category', 'participants']);

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
            "title" => "Peserta Saya",
            "datas" => $registrations,
            "search" => $search // Kirim keyword search ke view
        ];

        return view("user.competition-registration-datas", $viewData);
    }

    public function getCompetitionByCategory(string $id)
    {
        $competitions = Competition::where('category_id', $id)->where('status', 'open')->latest()->get();
        $viewData = [
            "title" => "Daftar Lomba",
            "competitions" => $competitions,
            'category_id' => $id,
            'categories' => Category::latest()->get(),
            'unpaid' => app(PaymentService::class)->unpaidFor(request()->user()),
            'competitionProgress' => $this->competitionProgressFor(request()->user()),
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
            "title" => "Detail Lomba",
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
            "title" => "Pendaftaran Lomba",
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
            'participants.*.photo_url' => 'required|file|mimes:jpeg,png,jpg,pdf|max:20480',
            'participants.*.certificate_url' => 'required|file|mimes:jpeg,png,jpg,pdf|max:20480',
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

            // Buat/sinkronkan tagihan PIC agar peserta masuk daftar "belum dibayar".
            app(PaymentService::class)->getOrCreateFor($pic);

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

            try {
                $pic->notify(new \App\Notifications\RegistrationCreatedNotification($registration, $participantCount));
            } catch (\Throwable $e) {
                report($e);
            }

            return redirect()->route('user.participants')->with('success', 'Alhamdulillah, pendaftaran berhasil! Data peserta sudah kami simpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Maaf, pendaftaran gagal diproses. Silakan coba lagi. (' . $e->getMessage() . ')');
        }
    }

    public function competitionRegistrationDetail(string $id)
    {
        // Batasi hanya data milik PIC yang sedang login (cegah akses lewat ID).
        $registration = Registration::where('pic_id', auth()->id())->findOrFail($id);
        $registration->load(['checkIn', 'participants.checkIn', 'competition.category']);
        $viewData = [
            'title' => 'Detail Pendaftaran',
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
            'title' => 'QR Code Pendaftaran',
            'data' => $registration,
            'qrCode' => $qrCode,
        ];

        return view('user.competition-registration-qr', $viewData);
    }
}
