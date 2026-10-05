<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class KhitanRegistrationCreated implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public string $registrationNumber,
        public string $name,
        public string $domicile,
    ) {
    }

    public function broadcastOn(): array
    {
        return [new PrivateChannel('admin')];
    }

    public function broadcastAs(): string
    {
        return 'khitan.registration.created';
    }

    public function broadcastWith(): array
    {
        return [
            'registration_number' => $this->registrationNumber,
            'name' => $this->name,
            'domicile' => $this->domicile,
            'message' => "Pendaftaran khitan baru: {$this->name}",
        ];
    }
}
