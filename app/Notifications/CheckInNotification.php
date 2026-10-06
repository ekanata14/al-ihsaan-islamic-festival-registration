<?php

namespace App\Notifications;

use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CheckInNotification extends Notification
{
    use Queueable;

    public function __construct(public Registration $registration, public int $participantNumber)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $competition = $this->registration->competition->name ?? '-';
        $participant = $this->registration->participants[0]->name ?? 'Peserta';

        return [
            'title' => 'Check-In Berhasil',
            'message' => $participant . ' telah check-in untuk lomba ' . $competition . ' dengan nomor urut ' . $this->participantNumber . '.',
            'url' => route('user.participants'),
            'icon' => 'check',
        ];
    }
}
