<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use App\Models\ContactPerson;
use App\Models\LandingBlock;
use App\Models\LandingSetting;
use App\Models\Sponsor;

class LandingController extends Controller
{
    public function index()
    {
        $viewData = [
            'title' => LandingSetting::get('site_name', 'Al Ihsaan Islamic Festival'),
            'settings' => LandingSetting::allCached(),
            'blocks' => LandingBlock::activeOrdered(),
            'competitions' => Competition::whereRaw('LOWER(status) = ?', ['open'])->latest()->get(),
            'sponsors' => Sponsor::active()->ordered()->get(),
            'contacts' => ContactPerson::active()->ordered()->get(),
        ];

        return view('welcome', $viewData);
    }
}
