<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Models
use App\Models\Competition;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index(){
        $viewData = [
            "title" => "User Dashboard",
            "competitions" => Competition::latest()->get(),
            'category_id' => '0',
            'categories' => Category::latest()->get(),
        ];

        return view("user.dashboard", $viewData);
    }

    public function getCompetitionByCategory(string $id)
    {
        $competitions = Competition::where('category_id', $id)->latest()->get();
        $viewData = [
            "title" => "Competitions",
            "competitions" => $competitions,
            'category_id' => $id,
            'categories' => Category::latest()->get(),
        ];

        return view("user.dashboard", $viewData);
    }

    public function competitionDetail(string $id)
    {
        $competition = Competition::findOrFail($id);
        $viewData = [
            "title" => "Competition Detail",
            "data" => $competition,
            'categories' => Category::latest()->get(),
            'participants' => [],
        ];

        return view("user.competition-detail", $viewData);
    }
}
