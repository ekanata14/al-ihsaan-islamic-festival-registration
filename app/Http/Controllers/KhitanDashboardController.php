<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

// Models
use App\Models\KhitanRegistration;
use App\Models\KhitanFamilyCard;

class KhitanDashboardController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Pastikan hanya memanggil data milik PIC (User) yang sedang login
        $query = KhitanRegistration::where('pic_id', auth()->user()->id);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('registration_number', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('domicile', 'like', "%{$search}%");
            });
        }

        $viewData = [
            'title' => 'Khitan Dashboard',
            'datas' => $query->latest()->paginate(10)->appends(['search' => $search]),
            'search' => $search
        ];

        return view('user.khitan.dashboard', $viewData);
    }

    public function registration()
    {
        $viewData = [
            'title' => 'Pendaftaran Khitan',
        ];

        return view('auth.khitan-register', $viewData);
    }

    public function registerPerson()
    {
        $viewData = [
            'title' => 'Form Pendaftaran Khitan',
        ];

        return view('user.khitan.registration', $viewData);
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
            'photo_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'certificate_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'family_card_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Generate Registration Number
        $registrationNumber = 'AIIF-KHITAN-' . now()->format('dmY') . '-' . strtoupper(Str::random(6));

        $validatedData['pic_id'] = auth()->user()->id;
        $validatedData['registration_number'] = $registrationNumber;
        $validatedData['status'] = 'registered';

        try {
            // Handle file uploads
            if ($request->hasFile('photo_url')) {
                $validatedData['photo_url'] = $request->file('photo_url')->store('khitan-photos', 'public');
            }
            if ($request->hasFile('certificate_url')) {
                $validatedData['certificate_url'] = $request->file('certificate_url')->store('khitan-certificates', 'public');
            }
            if ($request->hasFile('family_card_url')) {
                $validatedData['family_card_url'] = $request->file('family_card_url')->store('khitan-family-cards', 'public');
            }

            // Create Registration
            $khitanRegistration = KhitanRegistration::create($validatedData);

            // Create Family Card Record
            KhitanFamilyCard::create([
                'khitan_registration_id' => $khitanRegistration->id,
                'family_card_url' => $validatedData['family_card_url'],
            ]);

            return redirect()->route('khitan.dashboard')->with('success', 'Pendaftaran Khitan Berhasil!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
