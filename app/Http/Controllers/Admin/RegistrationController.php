<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

// Models
use App\Models\Registration;
use App\Models\Participant;
use App\Models\Competition;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the competitions (Index Registrasi).
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Competition::query();

        // Fitur Pencarian untuk Lomba
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('type', 'like', "%{$search}%")
                  ->orWhereHas('category', function($catQuery) use ($search) {
                      $catQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $viewData = [
            'title' => 'Data Registrasi Lomba',
            'datas' => $query->latest()->paginate(10)->appends(['search' => $search]),
            'search' => $search
        ];

        return view('admin.registration.index', $viewData);
    }

    /**
     * Display registrations for a specific competition.
     */
    public function detail(Request $request, string $id)
    {
        $search = $request->input('search');
        $competition = Competition::findOrFail($id);

        $query = Registration::where('competition_id', $id);

        // Fitur Pencarian untuk Detail Peserta
        if ($search) {
            $query->where(function($q) use ($search) {
                // Cari berdasarkan No Registrasi
                $q->where('registration_number', 'like', "%{$search}%")
                  // Cari berdasarkan Nama PIC (Wali) atau Grup/TPQ
                  ->orWhereHas('pic', function($picQuery) use ($search) {
                      $picQuery->where('name', 'like', "%{$search}%")
                               ->orWhere('phone_number', 'like', "%{$search}%")
                               ->orWhereHas('group', function($groupQuery) use ($search) {
                                   $groupQuery->where('name', 'like', "%{$search}%");
                               });
                  })
                  // Cari berdasarkan Nama Peserta (Anak)
                  ->orWhereHas('participants', function($partQuery) use ($search) {
                      $partQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('nik', 'like', "%{$search}%");
                  });
            });
        }

        $viewData = [
            'title' => 'Detail Registrasi - ' . $competition->name . ' ' . ($competition->category->name ?? ''),
            'datas' => $query->latest()->paginate(10)->appends(['search' => $search]),
            'competition' => $competition,
            'search' => $search
        ];

        return view('admin.registration.detail', $viewData);
    }

    public function create() { /* ... */ }
    public function store(Request $request) { /* ... */ }
    public function show(string $id) { /* ... */ }

    public function edit(string $id)
    {
        $registration = Registration::findOrFail($id);
        $viewData = [
            'title' => 'Registration Detail',
            'data' => $registration,
        ];

        return view('admin.registration.person-detail', $viewData);
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'participants' => 'required|array',
            'participants.*.name' => 'required|string',
            'participants.*.age' => 'required|integer|min:1',
            'participants.*.nik' => 'required|string',
            'participants.*.certificate_url' => 'nullable|file|mimes:jpeg,png,pdf',
        ]);

        try {
            DB::beginTransaction();
            $registration = Registration::findOrFail($request->id);

            foreach ($validatedData['participants'] as $participantData) {
                $participant = $registration->participants()->where('nik', $participantData['nik'])->first();

                if ($participant) {
                    if (isset($participantData['certificate_url'])) {
                        if ($participant->certificate_url && Storage::disk('public')->exists($participant->certificate_url)) {
                            Storage::disk('public')->delete($participant->certificate_url);
                        }
                        $certificatePath = $participantData['certificate_url']->store('certificates', 'public');
                        $participantData['certificate_url'] = $certificatePath;
                    } else {
                        $participantData['certificate_url'] = $participant->certificate_url;
                    }
                    $participant->update($participantData);
                } else {
                    if (isset($participantData['certificate_url'])) {
                        $certificatePath = $participantData['certificate_url']->store('certificates', 'public');
                        $participantData['certificate_url'] = $certificatePath;
                    }
                    $registration->participants()->create($participantData);
                }
            }

            DB::commit();
            return redirect()->route('admin.dashboard.registration.detail.person', ['id' => $registration->id])->with('success', 'Registration and participants updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function destroy(Registration $registration) { /* ... */ }
}
