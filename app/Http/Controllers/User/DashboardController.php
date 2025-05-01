<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Models
use App\Models\Competition;

class DashboardController extends Controller
{
    public function index(){
        $viewData = [
            "title" => "User Dashboard",
            "competitions" => Competition::latest()->get()
        ];

        return view("user.dashboard", $viewData);
    }
}
