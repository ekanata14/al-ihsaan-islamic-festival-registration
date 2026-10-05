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
        return ['mail'];
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
