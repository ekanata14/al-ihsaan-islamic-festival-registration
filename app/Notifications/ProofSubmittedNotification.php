<?php

namespace App\Notifications;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProofSubmittedNotification extends Notification
{
    use Queueable;

    public function __construct(public Payment $payment)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Bukti Pembayaran Diterima',
            'message' => 'Bukti pembayaran tagihan ' . $this->payment->invoice_number . ' sudah kami terima dan sedang menunggu verifikasi panitia.',
            'url' => route('user.payment'),
            'icon' => 'card',
        ];
    }
}
