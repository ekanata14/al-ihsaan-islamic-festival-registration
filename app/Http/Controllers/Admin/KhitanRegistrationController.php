<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Events\AdminDataChanged;
use App\Events\UserDataChanged;
use App\Support\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode as QRCode;

// Models
use App\Models\KhitanRegistration;
use App\Models\KhitanFamilyCard;
class KhitanRegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vieData = [
            'title' => 'Khitan Registration',
            'datas' => KhitanRegistration::latest()->paginate(10)
        ];
        return view('admin.khitan-registration.index', $vieData);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $viewData = [
            'title' => 'Create Khitan Registration',
        ];
        return view('admin.khitan-registration.create', $viewData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'age' => 'required|integer',
            'nik' => 'required|string',
            'birth_date' => 'required|date',
            'birth_place' => 'required|string',
            'domicile' => 'required|string',
            'is_sanur' => 'required|boolean',
            'photo_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:20480',
            'certificate_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:20480',
            'family_card_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20480',
        ]);

        try {
            DB::beginTransaction();

            $validatedData['registration_number'] = 'AIIF-KHITAN-' . now()->format('dmY') . '-' . strtoupper(Str::random(6));
            $validatedData['pic_id'] = auth()->id();
            $validatedData['status'] = 'registered';

            // Handle file upload for photo_url
            if ($request->hasFile('photo_url')) {
                $validatedData['photo_url'] = $request->file('photo_url')->store('khitan-photos', 'public');
            }

            // Handle file upload for certificate_url
            if ($request->hasFile('certificate_url')) {
                $validatedData['certificate_url'] = $request->file('certificate_url')->store('khitan-certificates', 'public');
            }

            // Handle optional family card upload
            $familyCardPath = null;
            if ($request->hasFile('family_card_url')) {
                $familyCardPath = $request->file('family_card_url')->store('khitan-family-cards', 'public');
            }

            // Create a new registration
            $khitanRegistration = KhitanRegistration::create($validatedData);

            if ($familyCardPath) {
                KhitanFamilyCard::create([
                    'khitan_registration_id' => $khitanRegistration->id,
                    'family_card_url' => $familyCardPath,
                ]);
            }

            DB::commit();

            ActivityLogger::log('admin.khitan-registration.created', 'Menambah pendaftaran khitan: ' . $khitanRegistration->name, $khitanRegistration);
            event(new AdminDataChanged('khitan-registration', 'created', $khitanRegistration->id));

            return redirect()->route('admin.dashboard.khitan-registration')->with('success', 'Pendaftaran khitan berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Gagal menambahkan pendaftaran: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(KhitanRegistration $khitanRegistration)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $khitanRegistration = KhitanRegistration::findOrFail($id);
        // Generate QR code based on the registration ID
        $qrCode = QRCode::size(200)->generate($khitanRegistration->registration_number);
        $viewData = [
            'title' => 'Edit Khitan Registration',
            'data' => $khitanRegistration,
            'qrCode' => $qrCode,
        ];
        return view('admin.khitan-registration.edit', $viewData);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $khitanRegistration = KhitanRegistration::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string',
            'age' => 'required|integer',
            'nik' => 'required|string',
            'birth_date' => 'required|date',
            'birth_place' => 'required|string',
            'domicile' => 'required|string',
            'is_sanur' => 'required|boolean',
            'status' => 'required|string',
            'photo_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20480',
            'certificate_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20480',
            'family_card_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20480',
        ]);

        unset($validatedData['family_card_url']);

        try {
            DB::beginTransaction();

            // Handle file upload for photo_url
            if ($request->hasFile('photo_url')) {
                $validatedData['photo_url'] = $request->file('photo_url')->store('khitan-photos', 'public');
            }

            // Handle file upload for certificate_url
            if ($request->hasFile('certificate_url')) {
                $validatedData['certificate_url'] = $request->file('certificate_url')->store('khitan-certificates', 'public');
            }

            // Update the existing registration
            $khitanRegistration->update($validatedData);

            // Handle optional family card upload
            if ($request->hasFile('family_card_url')) {
                $familyCardPath = $request->file('family_card_url')->store('khitan-family-cards', 'public');
                $khitanRegistration->familyCard()->updateOrCreate(
                    ['khitan_registration_id' => $khitanRegistration->id],
                    ['family_card_url' => $familyCardPath]
                );
            }

            DB::commit();

            ActivityLogger::log('admin.khitan-registration.updated', 'Mengubah pendaftaran khitan: ' . $khitanRegistration->name, $khitanRegistration);
            event(new AdminDataChanged('khitan-registration', 'updated', $khitanRegistration->id));
            event(new UserDataChanged($khitanRegistration->pic_id, 'khitan-registration', 'updated', $khitanRegistration->id));

            return redirect()->route('admin.dashboard.khitan-registration')->with('success', 'Pendaftaran khitan berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Gagal memperbarui pendaftaran: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            DB::beginTransaction();
            $khitanRegistration = KhitanRegistration::findOrFail($request->id);
            $khitanId = $khitanRegistration->id;
            $khitanName = $khitanRegistration->name;
            $khitanRegistration->delete();
            DB::commit();

            ActivityLogger::log('admin.khitan-registration.deleted', 'Menghapus pendaftaran khitan: ' . $khitanName);
            event(new AdminDataChanged('khitan-registration', 'deleted', $khitanId));

            return redirect()->route('admin.dashboard.khitan-registration')->with('success', 'Pendaftaran khitan berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Gagal menghapus pendaftaran: ' . $e->getMessage()]);
        }
    }
}
