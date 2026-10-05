<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RegistrationCreated implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public string $registrationNumber,
        public string $competitionName,
        public string $picName,
        public int $participantCount,
    ) {
    }

    public function broadcastOn(): array
    {
        return [new PrivateChannel('admin')];
    }

    public function broadcastAs(): string
    {
        return 'registration.created';
    }

    public function broadcastWith(): array
    {
        return [
            'registration_number' => $this->registrationNumber,
            'competition_name' => $this->competitionName,
            'pic_name' => $this->picName,
            'participant_count' => $this->participantCount,
            'message' => "Pendaftaran baru: {$this->competitionName} oleh {$this->picName}",
        ];
    }
}
