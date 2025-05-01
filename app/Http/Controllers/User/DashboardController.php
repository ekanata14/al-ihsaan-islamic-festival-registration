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
            "competitions" => Competition::latest()->get(),
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
        $competitions = Competition::where('category_id', $id)->latest()->get();
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
        $viewData = [
            "title" => "Competition Detail",
            "data" => $competition,
            'categories' => Category::latest()->get(),
            'participants' => Participant::where('competition_id', $id)->latest()->get(),
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
        $validatedData = $request->validate([
            'competition_id' => 'required|exists:competitions,id',
            'participants' => 'required|array',
            'participants.*.name' => 'required|string',
            'participants.*.age' => 'required|integer|min:1',
            'participants.*.nik' => 'required|string|unique:participants,nik',
            'participants.*.certificate_url' => 'required|file|mimes:jpeg,png,pdf|max:2048',
        ]);

        try {
            // Create registration number
            $registrationNumber = 'AIIF-' . now()->format('dmY') . '-' . Str::random(6);
            // Create the registration
            $registration = Registration::create([
                'registration_number' => $registrationNumber,
                'pic_id' => auth()->user()->id,
                'competition_id' => $validatedData['competition_id'],
                'group_id' => auth()->user()->group_id,
                'status' => 'registered',
            ]);

            // Loop through participants and save them
            foreach ($validatedData['participants'] as $participantData) {
                // Handle file upload for certificate_url
                $certificatePath = $participantData['certificate_url']->store('certificates', 'public');

                Participant::create([
                    'registration_id' => $registration->id,
                    'name' => $participantData['name'],
                    'age' => $participantData['age'],
                    'nik' => $participantData['nik'],
                    'certificate_url' => $certificatePath,
                ]);
            }

            return redirect()->route('user.dashboard')->with('success', 'Registration and participants saved successfully.');
        } catch (\Exception $e) {
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
