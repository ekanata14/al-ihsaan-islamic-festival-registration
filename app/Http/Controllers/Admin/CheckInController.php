<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Models
use App\Models\Registration;

class CheckInController extends Controller
{
    public function index(){
        $checkins = Registration::where('status', 'checkin')->latest()->paginate(10);
        $viewData = [
            "title" => "Check In",
            "datas" => $checkins,
        ];

        return view("admin.check-in.index", $viewData);
    }

    public function checkin(Request $request){
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

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Check In Berhasil',
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
