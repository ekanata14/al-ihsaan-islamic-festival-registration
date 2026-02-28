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
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Competition::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhereHas('category', function ($catQuery) use ($search) {
                        $catQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $viewData = [
            'title' => 'Menu Check-In',
            'datas' => $query->withCount('checkins')->latest()->paginate(10)->appends(['search' => $search]),
            'search' => $search
        ];

        return view("admin.check-in.index", $viewData);
    }

    // UPDATE METHOD INI
    public function detail(Request $request, string $id)
    {
        $search = $request->input('search');
        $competition = Competition::findOrFail($id);

        $query = Checkin::where('competition_id', $id);

        if ($search) {
            $query->where(function ($q) use ($search) {
                // Cari berdasarkan Nomor Registrasi (relasi registration)
                $q->whereHas('registration', function ($reg) use ($search) {
                    $reg->where('registration_number', 'like', "%{$search}%");
                })
                    // Cari berdasarkan Nama Peserta (relasi participant)
                    ->orWhereHas('participant', function ($part) use ($search) {
                        $part->where('name', 'like', "%{$search}%");
                    })
                    // Cari berdasarkan Nama Wali atau Asal TPQ (relasi pic & group)
                    ->orWhereHas('pic', function ($pic) use ($search) {
                        $pic->where('name', 'like', "%{$search}%")
                            ->orWhereHas('group', function ($group) use ($search) {
                                $group->where('name', 'like', "%{$search}%");
                            });
                    });
            });
        }

        $viewData = [
            'title' => 'Daftar Hadir | ' . $competition->name,
            'datas' => $query->latest()->paginate(10)->appends(['search' => $search]),
            'competition' => $competition,
            'search' => $search
        ];

        return view('admin.check-in.detail', $viewData);
    }

    public function checkin(Request $request)
    {
        try {
            DB::beginTransaction();

            $registration = Registration::where('registration_number', $request->registration_number)->first();

            if (!$registration) {
                return redirect()->back()->with('error', 'Data pendaftaran tidak ditemukan.');
            }

            if ($registration->status === 'checkin') {
                return redirect()->back()->with('error', 'Peserta ini sudah melakukan check-in sebelumnya.');
            }

            $registration->status = 'checkin';
            $registration->save();

            $participantNumber = Checkin::where('competition_id', $registration->competition_id)->count() + 1;

            CheckIn::create([
                'registration_id' => $registration->id,
                'competition_id' => $registration->competition_id,
                'participant_number' => $participantNumber,
                'pic_id' => $registration->pic_id,
                'participant_id' => $registration->participants[0]->id,
            ]);

            DB::commit();

            return redirect()->route('admin.dashboard.check-in.detail', $registration->competition_id)
                ->with('success', 'Check-in berhasil! Nomor Urut: ' . $participantNumber);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
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
                    'message' => 'QR Code tidak valid! Peserta tidak terdaftar.',
                ], 404);
            }

            if ($registration->status === 'checkin' || CheckIn::where('registration_id', $registration->id)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Peserta ini sudah melakukan Check-In sebelumnya.',
                ], 400);
            }

            $registration->status = 'checkin';
            $registration->save();

            $participantNumber = Checkin::where('competition_id', $registration->competition_id)->count() + 1;

            CheckIn::create([
                'registration_id' => $registration->id,
                'competition_id' => $registration->competition_id,
                'participant_number' => $participantNumber,
                'pic_id' => $registration->pic_id,
                'participant_id' => $registration->participants[0]->id,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Check-In Berhasil! Nomor Urut: ' . $participantNumber,
                'redirect' => route('admin.dashboard.check-in.detail', $registration->competition_id),
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Kesalahan sistem: ' . $e->getMessage(),
            ], 500);
        }
    }
}
