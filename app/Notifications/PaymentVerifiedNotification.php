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
        $channels = ['database'];

        if (config('festival.notify.enabled')) {
            $channels[] = 'mail';
        }

        return $channels;
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Pembayaran Terverifikasi',
            'message' => 'Pembayaran tagihan ' . $this->payment->invoice_number . ' telah diverifikasi panitia. Pendaftaran Anda berstatus LUNAS.',
            'url' => route('user.payment'),
            'icon' => 'check',
        ];
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
