<?php

namespace App\Notifications;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentVerifiedNotification extends Notification
{
    use Queueable;

    public function __construct(public Payment $payment)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Pembayaran Terverifikasi - ' . config('app.name'))
            ->greeting('Assalamualaikum ' . $notifiable->name)
            ->line('Pembayaran untuk tagihan ' . $this->payment->invoice_number . ' telah diverifikasi panitia.')
            ->line('Total: Rp ' . number_format($this->payment->verified_amount ?? $this->payment->total_amount, 0, ',', '.'))
            ->line('Pendaftaran Anda kini berstatus LUNAS. Terima kasih.');
    }
}
