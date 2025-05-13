<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode as QRCode;

// Models
use App\Models\KhitanRegistration;
use App\Models\KhitanFamilyCard;

class KhitanDashboardController extends Controller
{
    public function index()
    {
        $viewData = [
            'title' => 'Khitan Dashboard',
            'datas' => KhitanRegistration::where('pic_id', auth()->user()->id)->latest()->paginate(10)
        ];

        return view('khitan.dashboard', $viewData);
    }

    public function registration()
    {
        $viewData = [
            'title' => 'Khitan Registration',
        ];

        return view('auth.khitan-register', $viewData);
    }

    public function registerPerson()
    {
        $viewData = [
            'title' => 'Khitan Registration Person',
        ];

        return view('auth.khitan-register-person', $viewData);
    }

    public function registerPersonStore(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'nik' => 'required|string',
            'age' => 'required|integer',
            'birth_date' => 'required|date',
            'birth_place' => 'required|string',
            'domicile' => 'required|string',
            'is_sanur' => 'required|boolean',
            'photo_url' => 'required|image|mimes:jpeg,png,jpg,gif',
            'certificate_url' => 'required|image|mimes:jpeg,png,jpg,gif',
            'family_card_url' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);
        // Create registration number
        $registrationNumber = 'AIIF-KHITAN-' . now()->format('dmY') . '-' . Str::random(6);
        $validatedData['pic_id'] = auth()->user()->id;
        $validatedData['registration_number'] = $registrationNumber;
        $validatedData['status'] = 'registered';

        try {
            // Handle file upload for photo_url
            if ($request->hasFile('photo_url')) {
                $validatedData['photo_url'] = $request->file('photo_url')->store('khitan-photos', 'public');
            }

            // Handle file upload for certificate_url
            if ($request->hasFile('certificate_url')) {
                $validatedData['certificate_url'] = $request->file('certificate_url')->store('khitan-certificates', 'public');
            }

            // Handle file upload for family_card_url
            if ($request->hasFile('family_card_url')) {
                $validatedData['family_card_url'] = $request->file('family_card_url')->store('khitan-family-cards', 'public');
            }

            $khitanRegistration = KhitanRegistration::create($validatedData);

            // Create family card record
            KhitanFamilyCard::create([
                'khitan_registration_id' => $khitanRegistration->id,
                'family_card_url' => $validatedData['family_card_url'],
            ]);

            if (auth()->user()->role == 'khitan') {
                return redirect()->route('khitan.dashboard')->with('success', 'Registration successful!');
            } else {
                return redirect()->route('khitan.dashboard')->with('success', 'Registration successful!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function khitanRegistrationQR(string $id)
    {
        $registration = KhitanRegistration::findOrFail($id);

        // Generate QR code based on the registration ID
        $qrCode = QRCode::size(200)->generate($registration->registration_number);

        $viewData = [
            'title' => 'Registration QR Code',
            'data' => $registration,
            'qrCode' => $qrCode,
        ];

        return view('khitan.khitan-registration-qr', $viewData);
    }
}
