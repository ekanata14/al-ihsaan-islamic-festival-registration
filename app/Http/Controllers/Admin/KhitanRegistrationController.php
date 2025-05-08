<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;

// Models
use App\Models\KhitanRegistration;
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
            'nik' => 'required|string',
            'birth_date' => 'required|date',
            'birth_place' => 'required|string',
            'domicile' => 'required|string',
            'is_sanur' => 'required|boolean',
            'photo_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'certificate_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            DB::beginTransaction();
            // Handle file upload for photo_url
            if ($request->hasFile('photo_url')) {
                $validatedData['photo_url'] = $request->file('photo_url')->store('khitan-photos');
            }

            // Handle file upload for certificate_url
            if ($request->hasFile('certificate_url')) {
                $validatedData['certificate_url'] = $request->file('certificate_url')->store('khitan-certificates');
            }

            // Create a new registration
            KhitanRegistration::create($validatedData);
            DB::commit();

            return redirect()->route('khitan-registration.index')->with('success', 'Registration created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Failed to create registration: ' . $e->getMessage()]);
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
        $viewData = [
            'title' => 'Edit Khitan Registration',
            'data' => $khitanRegistration,
        ];
        return view('admin.khitan-registration.edit', $viewData);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|string',
            'nik' => 'required|string',
            'birth_date' => 'required|date',
            'birth_place' => 'required|string',
            'domicile' => 'required|string',
            'is_sanur' => 'required|boolean',
            'photo_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'certificate_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            DB::beginTransaction();
            // Handle file upload for photo_url
            if ($request->hasFile('photo_url')) {
                $validatedData['photo_url'] = $request->file('photo_url')->store('khitan-photos');
            }

            // Handle file upload for certificate_url
            if ($request->hasFile('certificate_url')) {
                $validatedData['certificate_url'] = $request->file('certificate_url')->store('khitan-certificates');
            }

            // Create a new registration
            KhitanRegistration::create($validatedData);
            DB::commit();

            return redirect()->route('khitan-registration.index')->with('success', 'Registration created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Failed to create registration: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|integer|exists:khitan_registrations,id',
        ]);

        try {
            DB::beginTransaction();
            $khitanRegistration = KhitanRegistration::findOrFail($validatedData['id']);
            $khitanRegistration->delete();
            DB::commit();

            return redirect()->route('khitan-registration.index')->with('success', 'Registration deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Failed to delete registration: ' . $e->getMessage()]);
        }
    }
}
