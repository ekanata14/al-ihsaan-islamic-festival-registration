<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $role = $request->input('role');
        $action = $request->input('action');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = ActivityLog::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                    ->orWhere('user_name', 'like', "%{$search}%");
            });
        }

        if ($role) {
            $query->where('role', $role);
        }

        if ($action) {
            $query->where('action', $action);
        }

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        $viewData = [
            'title' => 'Activity Log',
            'datas' => $query->latest()->paginate(15)->appends($request->all()),
            'search' => $search,
            'role' => $role,
            'action' => $action,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'actions' => ActivityLog::query()->distinct()->orderBy('action')->pluck('action'),
        ];

        return view('admin.activity-log.index', $viewData);
    }
}
