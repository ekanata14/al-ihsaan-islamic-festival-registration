<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CheckInRecorded implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public int $competitionId,
        public string $competitionName,
        public string $participantName,
        public int $participantNumber,
    ) {
    }

    public function broadcastOn(): array
    {
        return [new PrivateChannel('admin')];
    }

    public function broadcastAs(): string
    {
        return 'checkin.recorded';
    }

    public function broadcastWith(): array
    {
        return [
            'competition_id' => $this->competitionId,
            'competition_name' => $this->competitionName,
            'participant_name' => $this->participantName,
            'participant_number' => $this->participantNumber,
            'message' => "Check-in: {$this->participantName} ({$this->competitionName})",
        ];
    }
}
