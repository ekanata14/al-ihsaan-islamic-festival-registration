<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Support\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function __construct(private PaymentService $payments)
    {
    }

    /**
     * Halaman ringkasan pembayaran untuk wali/koordinator yang sedang login.
     */
    public function show(Request $request)
    {
        $pic = $request->user();

        $payment = $this->payments->getOrCreateFor($pic);
        $payment->load(['proofs' => fn ($q) => $q->latest(), 'histories.changedBy']);

        $children = $pic->children()
            ->with(['participants.registration.competition'])
            ->get();

        $viewData = [
            'title' => 'Pembayaran Pendaftaran',
            'payment' => $payment,
            'children' => $children,
            'bank' => config('festival.bank'),
            'fee' => config('festival.fee'),
        ];

        return view('user.payment', $viewData);
    }

    /**
     * Unggah bukti pembayaran (validasi tipe & ukuran di server).
     */
    public function uploadProof(Request $request)
    {
        $proofConfig = config('festival.proof');

        $validated = $request->validate([
            'sender_name' => 'required|string|max:255',
            'transfer_date' => 'required|date',
            'claimed_amount' => 'nullable|integer|min:0',
            'proof' => 'required|file|mimes:' . implode(',', $proofConfig['mimes']) . '|max:' . $proofConfig['max_kb'],
        ]);

        $pic = $request->user();
        $payment = $this->payments->getOrCreateFor($pic);
        $this->payments->submitProof($payment, $pic, $validated, $request->file('proof'));

        return redirect()->route('user.payment')
            ->with('success', 'Bukti pembayaran berhasil diunggah. Menunggu verifikasi panitia.');
    }

    /**
     * Sajikan bukti pembayaran milik PIC (akses privat, cek kepemilikan).
     */
    public function proof(Request $request)
    {
        $payment = Payment::where('pic_id', $request->user()->id)->firstOrFail();
        $proof = $payment->proofs()->latest()->first();

        abort_if(! $proof, 404, 'Belum ada bukti pembayaran.');

        $disk = config('festival.proof.disk', 'local');

        abort_unless(Storage::disk($disk)->exists($proof->file_path), 404, 'Berkas tidak ditemukan.');

        return Storage::disk($disk)->response($proof->file_path, null, [
            'Content-Type' => $proof->mime_type,
        ]);
    }

    /**
     * Bukti pendaftaran siap cetak, hanya untuk tagihan yang terverifikasi.
     */
    public function receipt(Request $request)
    {
        $pic = $request->user();
        $payment = Payment::where('pic_id', $pic->id)->firstOrFail();
        $this->payments->sync($payment);

        abort_unless($payment->isTerverifikasi(), 403, 'Bukti pendaftaran tersedia setelah pembayaran diverifikasi.');

        $children = $pic->children()
            ->with(['participants.registration.competition'])
            ->get();

        $viewData = [
            'title' => 'Bukti Pendaftaran',
            'payment' => $payment,
            'children' => $children,
        ];

        return view('user.payment-receipt', $viewData);
    }
}
