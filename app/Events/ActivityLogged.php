<?php

namespace App\Events;

use App\Models\ActivityLog;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ActivityLogged implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels;

    public function __construct(public ActivityLog $log)
    {
    }

    public function broadcastOn(): array
    {
        return [new PrivateChannel('admin')];
    }

    public function broadcastAs(): string
    {
        return 'activity.logged';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->log->id,
            'action' => $this->log->action,
            'description' => $this->log->description,
            'user_name' => $this->log->user_name,
            'role' => $this->log->role,
            'created_at' => $this->log->created_at?->toDateTimeString(),
            'message' => "Aktivitas: {$this->log->description}",
        ];
    }
}
