<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Events\AdminDataChanged;
use App\Models\Payment;
use App\Support\ActivityLogger;
use App\Support\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class PaymentController extends Controller
{
    public function __construct(private PaymentService $payments)
    {
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $sort = $request->input('sort', 'latest');

        $query = Payment::with(['pic.group', 'latestProof']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                    ->orWhereHas('pic', function ($picQuery) use ($search) {
                        $picQuery->where('name', 'like', "%{$search}%")
                            ->orWhereHas('group', function ($groupQuery) use ($search) {
                                $groupQuery->where('name', 'like', "%{$search}%");
                            });
                    })
                    ->orWhereHas('pic.children', function ($childQuery) use ($search) {
                        $childQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('nik', 'like', "%{$search}%");
                    });
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        match ($sort) {
            'oldest' => $query->oldest(),
            'amount_desc' => $query->orderByDesc('total_amount'),
            'amount_asc' => $query->orderBy('total_amount'),
            default => $query->latest(),
        };

        $summary = [
            'total_children' => (int) DB::table('children')
                ->whereExists(function ($q) {
                    $q->select(DB::raw(1))
                        ->from('participants')
                        ->whereColumn('participants.child_id', 'children.id');
                })
                ->count(),
            'lunas' => (int) Payment::where('status', Payment::STATUS_TERVERIFIKASI)->count(),
            'belum_lunas' => (int) Payment::where('status', '!=', Payment::STATUS_TERVERIFIKASI)->count(),
            'total_verified_money' => (int) Payment::where('status', Payment::STATUS_TERVERIFIKASI)->sum('verified_amount'),
        ];

        $viewData = [
            'title' => 'Manajemen Pembayaran',
            'datas' => $query->paginate(10)->appends($request->all()),
            'search' => $search,
            'status' => $status,
            'sort' => $sort,
            'summary' => $summary,
        ];

        return view('admin.payment.index', $viewData);
    }

    public function detail(string $id)
    {
        $payment = Payment::with([
            'pic.group',
            'pic.children.participants.registration.competition',
            'proofs.uploader',
            'histories.changedBy',
        ])->findOrFail($id);
        $this->payments->sync($payment);
        $payment->refresh();

        $viewData = [
            'title' => 'Detail Pembayaran',
            'payment' => $payment,
        ];

        return view('admin.payment.detail', $viewData);
    }

    public function proof(string $id)
    {
        $payment = Payment::findOrFail($id);
        $proof = $payment->proofs()->latest()->first();

        abort_if(! $proof, 404, 'Belum ada bukti pembayaran.');

        $disk = config('festival.proof.disk', 'local');

        abort_unless(Storage::disk($disk)->exists($proof->file_path), 404, 'Berkas tidak ditemukan.');

        return Storage::disk($disk)->response($proof->file_path, null, [
            'Content-Type' => $proof->mime_type,
        ]);
    }

    public function verify(string $id)
    {
        $payment = Payment::findOrFail($id);

        try {
            $this->payments->verify($payment, auth()->user());
        } catch (ValidationException $e) {
            return back()->with('error', collect($e->errors())->flatten()->first());
        }

        return back()->with('success', 'Pembayaran ' . $payment->invoice_number . ' berhasil diverifikasi.');
    }

    public function reject(Request $request, string $id)
    {
        $validated = $request->validate([
            'reason' => 'required|string|max:1000',
        ]);

        $payment = Payment::findOrFail($id);

        try {
            $this->payments->reject($payment, auth()->user(), $validated['reason']);
        } catch (ValidationException $e) {
            return back()->with('error', collect($e->errors())->flatten()->first());
        }

        return back()->with('success', 'Pembayaran ' . $payment->invoice_number . ' ditolak.');
    }

    public function bulkVerify(Request $request)
    {
        $validated = $request->validate([
            'payment_ids' => 'required|array',
            'payment_ids.*' => 'integer|exists:payments,id',
        ]);

        $payments = Payment::whereIn('id', $validated['payment_ids'])
            ->where('status', Payment::STATUS_MENUNGGU_VERIFIKASI)
            ->get();

        $verified = 0;

        foreach ($payments as $payment) {
            try {
                $this->payments->verify($payment, auth()->user());
                $verified++;
            } catch (\Throwable $e) {
                // Lewati yang gagal, lanjutkan sisanya.
                report($e);
            }
        }

        if ($verified === 0) {
            return back()->with('error', 'Tidak ada pembayaran yang dapat diverifikasi.');
        }

        ActivityLogger::log('payment.bulk_verified', "Verifikasi massal {$verified} pembayaran.");
        event(new AdminDataChanged('payment', 'bulk-verified'));

        return back()->with('success', $verified . ' pembayaran berhasil diverifikasi.');
    }
}
