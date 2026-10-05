<?php

namespace App\Support;

use App\Events\AdminDataChanged;
use App\Events\UserDataChanged;
use App\Models\Payment;
use App\Models\PaymentProof;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PaymentService
{
    public function __construct(private FeeCalculator $fees)
    {
    }

    /**
     * Ambil atau buat tagihan milik PIC, lalu sinkronkan nominalnya.
     */
    public function getOrCreateFor(User $pic): Payment
    {
        $payment = Payment::firstOrCreate(
            ['pic_id' => $pic->id],
            [
                'invoice_number' => $this->generateInvoiceNumber(),
                'mode' => $this->fees->mode(),
                'unit_amount' => $this->fees->unitAmount(),
                'status' => Payment::STATUS_BELUM_BAYAR,
            ]
        );

        return $this->sync($payment);
    }

    /**
     * Sinkronkan tagihan bila PIC sudah punya satu (tidak membuat baru).
     */
    public function syncIfExists(User $pic): ?Payment
    {
        $payment = Payment::where('pic_id', $pic->id)->first();

        return $payment ? $this->sync($payment) : null;
    }

    /**
     * Hitung ulang total di server. Nominal terverifikasi tidak pernah
     * ditimpa diam-diam; selisih ditampilkan lewat model.
     */
    public function sync(Payment $payment): Payment
    {
        $pic = $payment->pic;

        if ($pic) {
            $summary = $this->fees->forPic($pic);

            $payment->mode = $summary['mode'];
            $payment->unit_amount = $summary['unit_amount'];
            $payment->child_count = $summary['child_count'];
            $payment->lomba_count = $summary['lomba_count'];
            $payment->total_amount = $summary['total'];
        }

        if ($payment->isDirty()) {
            $payment->save();
        }

        return $payment;
    }

    /**
     * Simpan bukti bayar (disk privat, nama UUID) dan set menunggu verifikasi.
     */
    public function submitProof(Payment $payment, User $user, array $data, UploadedFile $file): PaymentProof
    {
        return DB::transaction(function () use ($payment, $user, $data, $file) {
            $this->sync($payment);

            $disk = config('festival.proof.disk', 'local');
            $dir = config('festival.proof.dir', 'payment-proofs');

            $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension());
            $filename = (string) Str::uuid() . ($extension ? '.' . $extension : '');
            $path = $file->storeAs($dir, $filename, $disk);

            $proof = $payment->proofs()->create([
                'file_path' => $path,
                'mime_type' => $file->getMimeType(),
                'file_size' => (int) $file->getSize(),
                'sender_name' => $data['sender_name'],
                'transfer_date' => $data['transfer_date'],
                'claimed_amount' => $data['claimed_amount'] ?? null,
                'uploaded_by' => $user->id,
            ]);

            $payment->status = Payment::STATUS_MENUNGGU_VERIFIKASI;
            $payment->rejection_reason = null;
            $payment->save();

            $this->recordHistory($payment, Payment::STATUS_MENUNGGU_VERIFIKASI, null, $user->id);

            event(new AdminDataChanged('payment', 'submitted', $payment->id));
            event(new UserDataChanged($payment->pic_id, 'payment', 'submitted', $payment->id));

            return $proof;
        });
    }

    public function verify(Payment $payment, User $admin): Payment
    {
        if (! $payment->isMenungguVerifikasi()) {
            throw ValidationException::withMessages([
                'status' => 'Pembayaran hanya dapat diverifikasi saat berstatus menunggu verifikasi.',
            ]);
        }

        return DB::transaction(function () use ($payment, $admin) {
            $this->sync($payment);

            $payment->status = Payment::STATUS_TERVERIFIKASI;
            $payment->verified_by = $admin->id;
            $payment->verified_at = now();
            $payment->verified_amount = $payment->total_amount;
            $payment->rejection_reason = null;
            $payment->save();

            $this->recordHistory($payment, Payment::STATUS_TERVERIFIKASI, null, $admin->id);

            ActivityLogger::log('payment.verified', 'Memverifikasi pembayaran ' . $payment->invoice_number, $payment);
            event(new AdminDataChanged('payment', 'verified', $payment->id));
            event(new UserDataChanged($payment->pic_id, 'payment', 'verified', $payment->id));

            $this->notify($payment, 'verified');

            return $payment;
        });
    }

    public function reject(Payment $payment, User $admin, ?string $reason): Payment
    {
        if (! $payment->isMenungguVerifikasi()) {
            throw ValidationException::withMessages([
                'status' => 'Pembayaran hanya dapat ditolak saat berstatus menunggu verifikasi.',
            ]);
        }

        if (trim((string) $reason) === '') {
            throw ValidationException::withMessages([
                'reason' => 'Alasan penolakan wajib diisi.',
            ]);
        }

        return DB::transaction(function () use ($payment, $admin, $reason) {
            $payment->status = Payment::STATUS_DITOLAK;
            $payment->rejection_reason = $reason;
            $payment->save();

            $this->recordHistory($payment, Payment::STATUS_DITOLAK, $reason, $admin->id);

            ActivityLogger::log('payment.rejected', 'Menolak pembayaran ' . $payment->invoice_number . ': ' . $reason, $payment);
            event(new AdminDataChanged('payment', 'rejected', $payment->id));
            event(new UserDataChanged($payment->pic_id, 'payment', 'rejected', $payment->id));

            $this->notify($payment, 'rejected', $reason);

            return $payment;
        });
    }

    protected function recordHistory(Payment $payment, string $status, ?string $reason, ?int $changedBy): void
    {
        $payment->histories()->create([
            'status' => $status,
            'reason' => $reason,
            'changed_by' => $changedBy,
        ]);
    }

    protected function notify(Payment $payment, string $event, ?string $reason = null): void
    {
        if (! config('festival.notify.enabled')) {
            return;
        }

        $pic = $payment->pic;

        if (! $pic) {
            return;
        }

        try {
            if ($event === 'verified') {
                $pic->notify(new \App\Notifications\PaymentVerifiedNotification($payment));
            } else {
                $pic->notify(new \App\Notifications\PaymentRejectedNotification($payment, (string) $reason));
            }
        } catch (\Throwable $e) {
            // Notifikasi opsional: jangan sampai menggagalkan alur pembayaran.
            report($e);
        }
    }

    protected function generateInvoiceNumber(): string
    {
        do {
            $number = 'INV-AIIF-' . now()->format('dmY') . '-' . strtoupper(Str::random(6));
        } while (Payment::where('invoice_number', $number)->exists());

        return $number;
    }
}
