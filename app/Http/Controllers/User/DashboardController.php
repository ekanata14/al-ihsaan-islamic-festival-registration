<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
    public function index()
    {
        $viewData = [
            "title" => "User Dashboard",
            "competitions" => Competition::where('status', 'open')->latest()->get(),
            'category_id' => '0',
            'categories' => Category::latest()->get(),
        ];

        return view("user.dashboard", $viewData);
    }

    public function registeredParticipants()
    {
        $registrations = Registration::where('pic_id', auth()->user()->id)->latest()->paginate(10);
        $viewData = [
            "title" => "My Registrations",
            "datas" => $registrations,
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

    public function competitionRegistrationStore(Request $request)
    {
        $startTogetherCompetitionId = [1, 2, 3, 4, 5, 11, 13];
        $niks = collect($request->participants)->pluck('nik');
        $competitionId = Participant::whereIn('nik', $niks)->first();

        // Ambil competition yang sedang ingin didaftarkan
        $competitionBeingRegistered = $request->competition_id;

        if ($competitionId != null) {
            $registeredCompetitionId = $competitionId->registration->competition_id;

            // Jika sama-sama startTogether dan competition ID-nya sama → error
            if (
                in_array($competitionBeingRegistered, $startTogetherCompetitionId) &&
                in_array($registeredCompetitionId, $startTogetherCompetitionId) &&
                $competitionBeingRegistered == $registeredCompetitionId
            ) {
                $competition = Competition::findOrFail($registeredCompetitionId);
                return redirect()->back()->with('error', "Peserta dengan NIK {$competitionId->nik} sudah terdaftar pada lomba yang sama: {$competition->name} ({$competition->category->name}).");
            }

            // Cek apakah peserta sudah terdaftar di lomba manapun
            $alreadyRegistered = DB::table('participants')
                ->whereIn('nik', $niks)
                ->get();

            if ($alreadyRegistered->isNotEmpty()) {
                // Ambil detail lomba yang berjalan bersamaan
                $conflictRegistrations = DB::table('participants')
                    ->join('registrations', 'participants.registration_id', '=', 'registrations.id')
                    ->join('competitions', 'registrations.competition_id', '=', 'competitions.id')
                    ->whereIn('participants.nik', $niks)
                    ->whereNotIn('registrations.competition_id', $startTogetherCompetitionId)
                    ->where('registrations.status', 'registered')
                    ->select('participants.nik', 'competitions.name as competition_name')
                    ->get();

                if ($conflictRegistrations->isNotEmpty()) {
                    $messages = $conflictRegistrations->map(function ($row) {
                        return "NIK {$row->nik} sudah terdaftar di lomba '{$row->competition_name}'";
                    })->implode(', ');

                    return redirect()->back()->with('error', "Peserta Anda terdaftar di lomba yang berjalan bersamaan: $messages. Untuk perubahan silahkan hubungi panitia.");
                }

                // Kalau tidak bentrok, tetap beri tahu bahwa peserta sudah pernah mendaftar
                $nikList = $alreadyRegistered->pluck('nik')->implode(', ');
                $competition = Competition::findOrFail($registeredCompetitionId);
                return redirect()->back()->with('error', "Peserta dengan NIK berikut sudah terdaftar: $nikList pada Lomba {$competition->name} ({$competition->category->name}). Silakan gunakan NIK lain atau hubungi panitia.");
            }
        }


        $validatedData = $request->validate([
            'competition_id' => 'required|exists:competitions,id',
            'total_participants' => 'required|integer',
            'participants' => 'required|array',
            'participants.*.name' => 'required|string',
            'participants.*.age' => 'required|integer|min:1',
            'participants.*.nik' => 'required|string|unique:participants,nik',
            'participants.*.birth_place' => 'required|string',
            'participants.*.birth_date' => 'required|date',
            'participants.*.photo_url' => 'required|file|mimes:jpeg,png,pdf|max:2048',
            'participants.*.certificate_url' => 'required|file|mimes:jpeg,png,pdf|max:2048',
        ]);


        try {
            DB::beginTransaction();
            // Create registration number
            $registrationNumber = 'AIIF-' . now()->format('dmY') . '-' . Str::random(6);
            // Create the registration
            $registration = Registration::create([
                'registration_number' => $registrationNumber,
                'pic_id' => auth()->user()->id,
                'competition_id' => $validatedData['competition_id'],
                'total_participants' => $validatedData['total_participants'],
                'group_id' => auth()->user()->group_id,
                'status' => 'registered',
            ]);

            // Loop through participants and save them
            foreach ($validatedData['participants'] as $participantData) {
                // Handle file upload for certificate_url
                $certificatePath = $participantData['certificate_url']->store('certificates', 'public');
                $photoPath = $participantData['photo_url']->store('participants', 'public');

                Participant::create([
                    'registration_id' => $registration->id,
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

            return redirect()->route('user.participants')->with('success', 'Registration and participants saved successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function competitionRegistrationDetail(string $id)
    {
        $registration = Registration::findOrFail($id);
        $viewData = [
            'title' => 'Registration Detail',
            'data' => $registration,
        ];

        return view('user.competition-registration-detail', $viewData);
    }

    public function competitionRegistrationQR(string $id)
    {
        $registration = Registration::findOrFail($id);

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
