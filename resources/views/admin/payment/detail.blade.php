@extends('layouts.app')

@section('content')
    @php
        $statusMap = [
            'belum_bayar' => ['label' => 'Belum Bayar', 'class' => 'bg-gray-100 text-gray-700 border-gray-200', 'dot' => 'bg-gray-400'],
            'menunggu_verifikasi' => ['label' => 'Menunggu Verifikasi', 'class' => 'bg-amber-50 text-amber-700 border-amber-200', 'dot' => 'bg-amber-500'],
            'terverifikasi' => ['label' => 'Terverifikasi', 'class' => 'bg-emerald-50 text-emerald-700 border-emerald-200', 'dot' => 'bg-emerald-500'],
            'ditolak' => ['label' => 'Ditolak', 'class' => 'bg-rose-50 text-rose-700 border-rose-200', 'dot' => 'bg-rose-500'],
        ];
        $badge = $statusMap[$payment->status] ?? $statusMap['belum_bayar'];
        $proof = $payment->latestProof;
        $children = $payment->pic?->children ?? collect();
    @endphp

    <div class="py-8 max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8">
        <x-breadcrumb :links="['Manajemen Pembayaran' => route('admin.dashboard.payment'), 'Detail' => '#']" />

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-900">Detail Pembayaran</h2>
                <p class="text-sm text-gray-500 mt-1">No. Tagihan <span class="font-bold text-[#1D6594]">{{ $payment->invoice_number }}</span></p>
            </div>
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center px-4 py-2 text-sm font-bold rounded-full border shadow-sm {{ $badge['class'] }}">
                    <span class="w-2 h-2 me-2 rounded-full {{ $badge['dot'] }}"></span>
                    {{ $badge['label'] }}
                </span>
                <a href="{{ route('admin.dashboard.payment') }}" class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition-colors">Kembali</a>
            </div>
        </div>

        @if ($payment->needsAdjustment())
            <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5 mb-6">
                <p class="font-bold text-amber-700 text-sm">Selisih terdeteksi ({{ $payment->difference() > 0 ? 'Kurang Bayar' : 'Lebih Bayar' }}): Rp {{ number_format(abs($payment->difference()), 0, ',', '.') }}</p>
                <p class="text-amber-600 text-xs mt-1">Terverifikasi: Rp {{ number_format($payment->verified_amount, 0, ',', '.') }} &middot; Tagihan saat ini: Rp {{ number_format($payment->total_amount, 0, ',', '.') }}. Verifikasi ulang untuk memperbarui nominal.</p>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 sm:p-8">
                    <h3 class="text-lg font-extrabold text-gray-800 mb-4">Ringkasan Tagihan</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-4">
                        <div class="bg-gray-50 rounded-2xl p-4">
                            <p class="text-xs text-gray-500 font-bold uppercase">Wali / PIC</p>
                            <p class="font-bold text-gray-800">{{ $payment->pic?->name ?? '-' }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-2xl p-4">
                            <p class="text-xs text-gray-500 font-bold uppercase">TPG / Asal</p>
                            <p class="font-bold text-gray-800">{{ $payment->pic?->group?->name ?? '-' }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-2xl p-4">
                            <p class="text-xs text-gray-500 font-bold uppercase">Jumlah Anak</p>
                            <p class="font-bold text-gray-800">{{ $payment->child_count }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-2xl p-4">
                            <p class="text-xs text-gray-500 font-bold uppercase">Lomba</p>
                            <p class="font-bold text-gray-800">{{ $payment->lomba_count }}</p>
                        </div>
                    </div>
                    <div class="border-t border-dashed border-gray-200 pt-4 flex justify-between items-center">
                        <span class="text-sm text-gray-500">Tagihan ({{ $payment->mode === 'per_lomba' ? 'per lomba' : 'per anak' }} @ Rp {{ number_format($payment->unit_amount, 0, ',', '.') }})</span>
                        <span class="text-2xl font-extrabold text-[#1D6594]">Rp {{ number_format($payment->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 sm:p-8">
                        <h3 class="text-lg font-extrabold text-gray-800 mb-4">Daftar Anak & Lomba</h3>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-600">
                                <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-y border-gray-100">
                                    <tr>
                                        <th class="px-4 py-3 font-bold text-center w-12">No</th>
                                        <th class="px-4 py-3 font-bold">Nama Anak</th>
                                        <th class="px-4 py-3 font-bold">NIK</th>
                                        <th class="px-4 py-3 font-bold">Lomba</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @forelse ($children as $child)
                                        <tr>
                                            <td class="px-4 py-3 text-center">{{ $loop->iteration }}</td>
                                            <td class="px-4 py-3 font-bold text-gray-800">{{ $child->name }}</td>
                                            <td class="px-4 py-3">{{ $child->nik }}</td>
                                            <td class="px-4 py-3">
                                                {{ $child->participants->map(fn ($p) => $p->registration?->competition?->name)->filter()->unique()->implode(', ') ?: '-' }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="px-4 py-8 text-center text-gray-400">Tidak ada data anak.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 sm:p-8">
                    <h3 class="text-lg font-extrabold text-gray-800 mb-4">Riwayat Status</h3>
                    @forelse ($payment->histories as $history)
                        <div class="flex items-start gap-3 text-sm py-2 border-b border-gray-50 last:border-0">
                            <span class="w-2 h-2 rounded-full mt-1.5 {{ $statusMap[$history->status]['dot'] ?? 'bg-gray-400' }}"></span>
                            <div>
                                <p class="font-bold text-gray-700">{{ $statusMap[$history->status]['label'] ?? $history->status }}</p>
                                <p class="text-xs text-gray-400">{{ $history->created_at?->translatedFormat('d M Y H:i') }} WITA
                                    @if ($history->changedBy) &middot; oleh {{ $history->changedBy->name }} @endif
                                </p>
                                @if ($history->reason)<p class="text-xs text-rose-500 mt-0.5">Alasan: {{ $history->reason }}</p>@endif
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400">Belum ada riwayat.</p>
                    @endforelse
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-extrabold text-gray-800 mb-4">Bukti Bayar</h3>

                    @if ($proof)
                        @if ($proof->isImage())
                            <img src="{{ route('admin.dashboard.payment.proof', $payment->id) }}" alt="Bukti bayar" class="w-full rounded-xl border border-gray-200">
                        @else
                            <iframe src="{{ route('admin.dashboard.payment.proof', $payment->id) }}" class="w-full h-80 rounded-xl border border-gray-200"></iframe>
                            <a href="{{ route('admin.dashboard.payment.proof', $payment->id) }}" target="_blank" class="inline-block mt-2 text-sm font-bold text-[#1D6594] hover:underline">Buka PDF</a>
                        @endif

                        <div class="mt-4 space-y-2 text-sm">
                            <div class="flex justify-between"><span class="text-gray-500">Nama Pengirim</span><span class="font-bold text-gray-800">{{ $proof->sender_name }}</span></div>
                            <div class="flex justify-between"><span class="text-gray-500">Tanggal Transfer</span><span class="font-bold text-gray-800">{{ $proof->transfer_date?->translatedFormat('d M Y') }}</span></div>
                            <div class="flex justify-between"><span class="text-gray-500">Nominal Diisi Wali</span><span class="font-bold text-gray-800">Rp {{ number_format($proof->claimed_amount ?? 0, 0, ',', '.') }}</span></div>
                            <div class="flex justify-between border-t border-gray-100 pt-2"><span class="text-gray-500">Total Tagihan</span><span class="font-extrabold text-[#1D6594]">Rp {{ number_format($payment->total_amount, 0, ',', '.') }}</span></div>
                        </div>

                        @if ($proof->claimed_amount !== null && (int) $proof->claimed_amount !== (int) $payment->total_amount)
                            <p class="mt-2 text-xs font-bold text-amber-600">Nominal yang diisi wali berbeda dengan total tagihan.</p>
                        @endif
                    @else
                        <p class="text-sm text-gray-400">Belum ada bukti pembayaran diunggah.</p>
                    @endif
                </div>

                @if ($payment->isMenungguVerifikasi())
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 space-y-3">
                        <h3 class="text-lg font-extrabold text-gray-800">Aksi Verifikasi</h3>
                        <form action="{{ route('admin.dashboard.payment.verify', $payment->id) }}" method="POST" id="verify-form">
                            @csrf
                            <button type="submit" class="w-full py-3 bg-emerald-500 text-white font-bold rounded-xl hover:bg-emerald-600 transition-all">Verifikasi Pembayaran</button>
                        </form>
                        <button type="button" onclick="document.getElementById('reject-modal').classList.remove('hidden')"
                            class="w-full py-3 bg-white border border-rose-300 text-rose-600 font-bold rounded-xl hover:bg-rose-50 transition-all">Tolak Pembayaran</button>
                    </div>
                @elseif ($payment->isTerverifikasi())
                    <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-5 text-sm">
                        <p class="font-bold text-emerald-700">Pembayaran terverifikasi</p>
                        <p class="text-emerald-600 mt-1">oleh {{ $payment->verifier?->name ?? '-' }} pada {{ $payment->verified_at?->translatedFormat('d M Y H:i') }} WITA.</p>
                    </div>
                @elseif ($payment->isDitolak())
                    <div class="bg-rose-50 border border-rose-200 rounded-2xl p-5 text-sm">
                        <p class="font-bold text-rose-700">Pembayaran ditolak</p>
                        <p class="text-rose-600 mt-1">Alasan: {{ $payment->rejection_reason }}</p>
                        <p class="text-rose-500 mt-1">Menunggu wali mengunggah ulang bukti.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div id="reject-modal" class="hidden fixed inset-0 z-[100] bg-gray-900/70 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden">
            <div class="bg-rose-500 p-5 text-white flex justify-between items-center">
                <h2 class="text-lg font-bold">Tolak Pembayaran</h2>
                <button type="button" onclick="document.getElementById('reject-modal').classList.add('hidden')" class="text-white/80 hover:text-white">&times;</button>
            </div>
            <form action="{{ route('admin.dashboard.payment.reject', $payment->id) }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div>
                    <label for="reason" class="block text-sm font-bold text-gray-700 mb-1">Alasan Penolakan <span class="text-rose-500">*</span></label>
                    <textarea id="reason" name="reason" rows="4" required
                        class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-rose-500 focus:ring-rose-500 bg-gray-50 focus:bg-white form-textarea"
                        placeholder="Contoh: Nominal transfer tidak sesuai dengan total tagihan.">{{ old('reason') }}</textarea>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('reject-modal').classList.add('hidden')"
                        class="px-5 py-2.5 text-gray-600 font-bold rounded-xl hover:bg-gray-100 transition-colors">Batal</button>
                    <button type="submit" class="px-6 py-2.5 bg-rose-500 text-white font-bold rounded-xl hover:bg-rose-600 transition-colors">Tolak</button>
                </div>
            </form>
        </div>
    </div>
@endsection
