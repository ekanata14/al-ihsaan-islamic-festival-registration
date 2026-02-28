<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

// Models
use App\Models\User;
use App\Models\Competition;
use App\Models\Group;
use App\Models\KhitanRegistration;
use App\Models\Participant;
use App\Models\Registration;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // 1. Setup Date Filter (Default: start of current month to today)
        $startDateInput = $request->input('start_date', Carbon::now()->startOfMonth()->format('d-m-Y'));
        $endDateInput = $request->input('end_date', Carbon::now()->format('d-m-Y'));

        try {
            $startDate = Carbon::createFromFormat('d-m-Y', $startDateInput)->startOfDay();
            $endDate = Carbon::createFromFormat('d-m-Y', $endDateInput)->endOfDay();
        } catch (\Exception $e) {
            $startDate = Carbon::now()->startOfMonth()->startOfDay();
            $endDate = Carbon::now()->endOfDay();
        }

        // 2. Fetch Stat Counts
        $totalPicTpq = User::where('role', 'user')->count();
        $totalCompetitions = Competition::count();
        $totalGroups = Group::count();
        $totalRegistrations = Registration::whereBetween('created_at', [$startDate, $endDate])->count();
        $totalRegistrationKhitans = KhitanRegistration::whereBetween('created_at', [$startDate, $endDate])->count();

        // 3. Chart Data
        $statusChartData = Registration::whereBetween('created_at', [$startDate, $endDate])
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $competitionChartData = Registration::whereBetween('registrations.created_at', [$startDate, $endDate])
            ->join('competitions', 'registrations.competition_id', '=', 'competitions.id')
            ->select('competitions.name', DB::raw('count(registrations.id) as total'))
            ->groupBy('competitions.name')
            ->pluck('total', 'name');

        // 4. Fetch Competitions Table Data (Paginated)
        $competitionsData = Competition::with(['category', 'registrations'])
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->appends($request->all()); // Keeps date filters active on page 2, 3, etc.

        $viewData = [
            "title" => "Admin Dashboard",
            "startDateInput" => $startDateInput,
            "endDateInput" => $endDateInput,
            'totalPicTpq' => $totalPicTpq,
            'totalCompetitions' => $totalCompetitions,
            'totalGroups' => $totalGroups,
            'totalRegistrations' => $totalRegistrations,
            'totalRegistrationKhitans' => $totalRegistrationKhitans,
            'statusChartLabels' => $statusChartData->keys(),
            'statusChartValues' => $statusChartData->values(),
            'competitionChartLabels' => $competitionChartData->keys(),
            'competitionChartValues' => $competitionChartData->values(),
            'competitionsData' => $competitionsData, // Passed to view
        ];

        return view("admin.dashboard", $viewData);
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        // Jika pencarian kosong, kembalikan kembali ke halaman sebelumnya
        if (empty($search)) {
            return back()->with('error', 'Masukkan kata kunci pencarian.');
        }

        // 1. Pencarian Data Lomba (Registrations) yang lebih detail
        $lombaResults = Registration::with(['pic', 'participants', 'competition', 'group'])
            ->where(function ($query) use ($search) {
                $query->where('registration_number', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhereHas('pic', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('phone_number', 'like', "%{$search}%");
                    })
                    ->orWhereHas('participants', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('nik', 'like', "%{$search}%");
                    })
                    ->orWhereHas('competition', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('group', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->get();

        // 2. Pencarian Data Khitan (KhitanRegistrations) yang lebih detail
        $khitanResults = KhitanRegistration::with(['pic', 'familyCard'])
            ->where(function ($query) use ($search) {
                $query->where('registration_number', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%") // Nama Anak
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhere('domicile', 'like', "%{$search}%")
                    ->orWhereHas('pic', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('phone_number', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->get();

        $viewData = [
            "title" => "Hasil Pencarian: {$search}",
            "search" => $search,
            "lombaDatas" => $lombaResults,
            "khitanDatas" => $khitanResults,
        ];

        // Buat file view baru bernama 'admin.search-unified'
        return view('admin.search', $viewData);
    }

    public function searchKhitan()
    {
        $search = request('search');

        // search registrations by registration_number, status, or related pic's name, or participant's name/nik/phone
        $registrations = KhitanRegistration::where('registration_number', 'like', '%' . $search . '%')
            ->orWhere('name', 'like', '%' . $search . '%')
            ->orWhere('status', 'like', '%' . $search . '%')
            ->orWhereHas('pic', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->get();

        $viewData = [
            "title" => "Admin Dashboard | Search: {$search}",
            "datas" => $registrations,
        ];

        return view('admin.search-khitan', $viewData);
    }
}
