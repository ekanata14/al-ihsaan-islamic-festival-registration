<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Models
use App\Models\User;
use App\Models\Competition;
use App\Models\Group;
use App\Models\KhitanRegistration;
use App\Models\Participant;
use App\Models\Registration;

class DashboardController extends Controller
{
    public function index()
    {
        $viewData = [
            "title" => "Admin Dashboard",
            'totalPicTpq' => User::where('role', 'user')->count(),
            'totalCompetitions' => Competition::count(),
            'totalGroups' => Group::count(),
            'totalRegistrations' => Registration::count(),
            'totalRegistrationKhitans' => KhitanRegistration::count(),
        ];

        return view("admin.dashboard", $viewData);
    }

    public function search()
    {
        $search = request('search');

        // search registrations by registration_number, status, or related pic's name, or participant's name/nik/phone
        $registrations = KhitanRegistration::where('registration_number', 'like', '%' . $search . '%')
            ->orWhere('status', 'like', '%' . $search . '%')
            ->orWhereHas('pic', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->orWhereHas('participants', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->get();

        $viewData = [
            "title" => "Admin Dashboard | Search: {$search}",
            "datas" => $registrations,
        ];

        return view('admin.search', $viewData);
    }
}
