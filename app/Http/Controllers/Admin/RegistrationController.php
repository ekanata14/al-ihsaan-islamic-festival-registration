<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

// Models
use App\Models\Registration;
use App\Models\Participant;
use App\Models\Competition;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $viewData = [
            'title' => 'Competitions',
            'datas' => Competition::latest()->paginate(10)
        ];

        return view('admin.registration.index', $viewData);
    }

    public function detail(string $id)
    {
        $viewData = [
            'title' => 'Khitan Registrations',
            'datas' => Registration::where('competition_id', $id)->paginate(10),
            'competition' => Competition::findOrFail($id),
        ];

        return view('admin.registration.detail', $viewData);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Registration $registration)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $registration = Registration::findOrFail($id);
        $viewData = [
            'title' => 'Registration Detail',
            'data' => $registration,
        ];

        return view('admin.registration.edit', $viewData);
    }

    /**
     * Update the specified resource in storage.
     */
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
            $registration = Registration::findOrFail($request->id);

            foreach ($validatedData['participants'] as $participantData) {
                $participant = $registration->participants()->where('nik', $participantData['nik'])->first();

                if ($participant) {
                    // Update existing participant
                    if (isset($participantData['certificate_url'])) {
                        // Remove old file if a new one is uploaded
                        if ($participant->certificate_url && Storage::disk('public')->exists($participant->certificate_url)) {
                            Storage::disk('public')->delete($participant->certificate_url);
                        }

                        // Store new file
                        $certificatePath = $participantData['certificate_url']->store('certificates', 'public');
                        $participantData['certificate_url'] = $certificatePath;
                    } else {
                        // Keep the old certificate_url if not changed
                        $participantData['certificate_url'] = $participant->certificate_url;
                    }

                    $participant->update($participantData);
                } else {
                    // Create new participant if not exists
                    if (isset($participantData['certificate_url'])) {
                        $certificatePath = $participantData['certificate_url']->store('certificates', 'public');
                        $participantData['certificate_url'] = $certificatePath;
                    }

                    $registration->participants()->create($participantData);
                }
            }

            return redirect()->route('admin.registration.index')->with('success', 'Registration and participants updated successfully.');
        } catch (\Exception $e) {
            return $e->getMessage();
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Registration $registration)
    {
        //
    }
}
