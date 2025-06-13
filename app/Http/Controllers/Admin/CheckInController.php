<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Models
use App\Models\Registration;
use App\Models\Competition;
use App\Models\CheckIn;

class CheckInController extends Controller
{
    public function index()
    {
        // $checkins = Registration::where('status', 'checkin')->latest()->paginate(10);
        $viewData = [
            'title' => 'Competitions',
            'datas' => Competition::latest()->paginate(10)
        ];

        return view("admin.check-in.index", $viewData);
    }

    public function detail(string $id)
    {
        $competition = Competition::findOrFail($id);
        $viewData = [
            'title' => 'Registrations | ' . $competition->name . ' ' .  $competition->category->name,
            'datas' => Checkin::where('competition_id', $id)->latest()->get(),
            'competition' => $competition,
        ];

        return view('admin.check-in.detail', $viewData);
    }

    public function checkin(Request $request)
    {
        try {
            DB::beginTransaction();

            $registration = Registration::where('registration_number', $request->registration_number)->first();

            if (!$registration) {
                return response()->json([
                    'success' => false,
                    'message' => 'Registration not found',
                ], 404);
            }

            $registration->status = 'checkin';
            $registration->save();
            $participantNumber = Checkin::where('competition_id', $registration->competition_id)->count() + 1;
            $checkIn = CheckIn::create([
                'registration_id' => $registration->id,
                'competition_id' => $registration->competition_id,
                'participant_number' => $participantNumber,
                'pic_id' => $registration->pic_id,
                'participant_id' => $registration->participant->id,
            ]);

            DB::commit();

            return redirect()->route('admin.dashboard.check-in.detail', $registration->competition_id)->with('success', 'Check-in successful, Nomor Urut Peserta: ' . $participantNumber);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function checkinQR(Request $request)
    {
        try {
            DB::beginTransaction();

            $registration = Registration::where('registration_number', $request->registration_number)->first();

            if (!$registration) {
                return response()->json([
                    'success' => false,
                    'message' => 'Registration not found',
                ], 404);
            }

            $registration->status = 'checkin';
            $registration->save();
            $participantNumber = Checkin::where('competition_id', $registration->competition_id)->count() + 1;
            $checkIn = CheckIn::create([
                'registration_id' => $registration->id,
                'competition_id' => $registration->competition_id,
                'participant_number' => $participantNumber,
                'pic_id' => $registration->pic_id,
                'participant_id' => $registration->participant->id,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Check In Berhasil',
                'redirect' => route('admin.dashboard.check-in.detail', $registration->competition_id),
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }
}
