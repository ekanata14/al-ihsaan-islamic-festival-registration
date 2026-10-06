<?php

namespace App\Notifications;

use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class RegistrationCreatedNotification extends Notification
{
    use Queueable;

    public function __construct(public Registration $registration, public int $participantCount)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $competition = $this->registration->competition->name ?? '-';

        return [
            'title' => 'Pendaftaran Berhasil',
            'message' => 'Pendaftaran lomba ' . $competition . ' untuk ' . $this->participantCount . ' peserta berhasil disimpan.',
            'url' => route('user.participants'),
            'icon' => 'clipboard',
        ];
    }
}
