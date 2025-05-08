<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Models
use App\Models\User;
use App\Models\Competition;
use App\Models\Group;
use App\Models\Registration;
use App\Models\KhitanRegistration;

class DashboardController extends Controller
{
    public function index(){
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
}
