<?php

namespace App\Notifications;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentRejectedNotification extends Notification
{
    use Queueable;

    public function __construct(public Payment $payment, public string $reason)
    {
    }

    public function via(object $notifiable): array
    {
        $channels = ['database'];

        if (config('festival.notify.enabled')) {
            $channels[] = 'mail';
        }

        return $channels;
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Pembayaran Ditolak',
            'message' => 'Bukti pembayaran tagihan ' . $this->payment->invoice_number . ' ditolak. Alasan: ' . $this->reason,
            'url' => route('user.payment'),
            'icon' => 'warning',
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Pembayaran Ditolak - ' . config('app.name'))
            ->greeting('Assalamualaikum ' . $notifiable->name)
            ->line('Bukti pembayaran untuk tagihan ' . $this->payment->invoice_number . ' ditolak.')
            ->line('Alasan: ' . $this->reason)
            ->line('Silakan unggah ulang bukti pembayaran yang benar melalui halaman Pembayaran.');
    }
}
