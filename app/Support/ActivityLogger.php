<?php

namespace App\Support;

use App\Events\ActivityLogged;
use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    /**
     * Catat satu aktivitas pengguna dan broadcast ke channel admin.
     */
    public static function log(
        string $action,
        string $description,
        ?Model $subject = null,
        array $properties = [],
    ): ActivityLog {
        $user = Auth::user();
        $request = request();

        $log = ActivityLog::create([
            'user_id' => $user?->id,
            'user_name' => $user?->name,
            'role' => $user?->role,
            'action' => $action,
            'description' => $description,
            'subject_type' => $subject?->getMorphClass(),
            'subject_id' => $subject?->getKey(),
            'properties' => $properties ?: null,
            'ip_address' => $request?->ip(),
            'user_agent' => $request?->userAgent(),
        ]);

        event(new ActivityLogged($log));

        return $log;
    }
}
