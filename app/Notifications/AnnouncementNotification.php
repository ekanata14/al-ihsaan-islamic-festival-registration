<?php

namespace App\Notifications;

use App\Models\Announcement;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class AnnouncementNotification extends Notification
{
    use Queueable;

    public function __construct(public Announcement $announcement)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Pengumuman: ' . $this->announcement->title,
            'message' => Str::limit(trim(strip_tags($this->announcement->body)), 140),
            'url' => route('notifications.index'),
            'icon' => 'megaphone',
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Pengumuman: ' . $this->announcement->title . ' - ' . config('app.name'))
            ->greeting('Assalamualaikum ' . $notifiable->name)
            ->line($this->announcement->title)
            ->line(Str::limit(trim(strip_tags($this->announcement->body)), 800));
    }
}
