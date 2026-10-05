@extends('layouts.app')

@section('content')
    @php
        $statusMap = [
            'belum_bayar' => ['label' => 'Belum Bayar', 'class' => 'bg-gray-100 text-gray-700 border-gray-200', 'dot' => 'bg-gray-400'],
            'menunggu_verifikasi' => ['label' => 'Menunggu Verifikasi', 'class' => 'bg-amber-50 text-amber-700 border-amber-200', 'dot' => 'bg-amber-500'],
            'terverifikasi' => ['label' => 'Terverifikasi (Lunas)', 'class' => 'bg-emerald-50 text-emerald-700 border-emerald-200', 'dot' => 'bg-emerald-500'],
            'ditolak' => ['label' => 'Ditolak', 'class' => 'bg-rose-50 text-rose-700 border-rose-200', 'dot' => 'bg-rose-500'],
        ];
        $badge = $statusMap[$payment->status] ?? $statusMap['belum_bayar'];
        $latestProof = $payment->latestProof;
        $canUpload = in_array($payment->status, ['belum_bayar', 'ditolak'], true);
    @endphp

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <x-breadcrumb />

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 sm:p-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h2 class="text-2xl font-extrabold text-gray-900">Pembayaran Pendaftaran</h2>
                        <p class="text-sm text-gray-500 mt-1">No. Tagihan: <span class="font-bold text-[#1D6594]">{{ $payment->invoice_number }}</span></p>
                    </div>
                    <span class="inline-flex items-center px-4 py-2 text-sm font-bold rounded-full border shadow-sm {{ $badge['class'] }}">
                        <span class="w-2 h-2 me-2 rounded-full {{ $badge['dot'] }}"></span>
                        {{ $badge['label'] }}
                    </span>
                </div>
            </div>

            @if ($payment->isDitolak() && $payment->rejection_reason)
                <div class="bg-rose-50 border border-rose-200 rounded-2xl p-5">
                    <p class="font-bold text-rose-700 text-sm">Bukti pembayaran ditolak</p>
                    <p class="text-rose-600 text-sm mt-1">Alasan: {{ $payment->rejection_reason }}</p>
                    <p class="text-rose-500 text-xs mt-2">Silakan unggah ulang bukti pembayaran yang benar di bawah.</p>
                </div>
            @endif

            @if ($payment->needsAdjustment())
                <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5">
                    <p class="font-bold text-amber-700 text-sm">
                        {{ $payment->difference() > 0 ? 'Kurang Bayar' : 'Lebih Bayar' }}:
                        Rp {{ number_format(abs($payment->difference()), 0, ',', '.') }}
                    </p>
                    <p class="text-amber-600 text-xs mt-1">
                        Jumlah anak berubah setelah pembayaran diverifikasi (terverifikasi: Rp {{ number_format($payment->verified_amount, 0, ',', '.') }},
                        tagihan saat ini: Rp {{ number_format($payment->total_amount, 0, ',', '.') }}). Mohon konfirmasi ke panitia.
                    </p>
                </div>
            @endif

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 sm:p-8">
                    <h3 class="text-lg font-extrabold text-gray-800 mb-4">Ringkasan Tagihan</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-gray-50 rounded-2xl p-4">
                            <p class="text-xs text-gray-500 font-bold uppercase">Jumlah Anak</p>
                            <p class="text-2xl font-extrabold text-gray-800">{{ $payment->child_count }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-2xl p-4">
                            <p class="text-xs text-gray-500 font-bold uppercase">Jumlah Lomba</p>
                            <p class="text-2xl font-extrabold text-gray-800">{{ $payment->lomba_count }}</p>
                        </div>
                    </div>
                    <div class="mt-4 border-t border-dashed border-gray-200 pt-4">
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Biaya ({{ $payment->mode === 'per_lomba' ? 'per lomba' : 'per anak' }})</span>
                            <span>Rp {{ number_format($payment->unit_amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center mt-2">
                            <span class="font-bold text-gray-700">Total Tagihan</span>
                            <span class="text-2xl font-extrabold text-[#1D6594]">Rp {{ number_format($payment->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    @if ($payment->isTerverifikasi())
                        <div class="mt-4">
                            <a href="{{ route('user.payment.receipt') }}" target="_blank"
                                class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-500 text-white font-bold rounded-xl hover:bg-emerald-600 transition-all shadow-sm">
                                Cetak Bukti Pendaftaran
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 sm:p-8">
                    <h3 class="text-lg font-extrabold text-gray-800 mb-4">Daftar Anak Terdaftar</h3>
                    @forelse ($children as $child)
                        <div class="flex items-start justify-between gap-4 py-3 border-b border-gray-100 last:border-0">
                            <div>
                                <p class="font-bold text-gray-800">{{ $child->name }}</p>
                                <p class="text-xs text-gray-500">NIK: {{ $child->nik }}</p>
                            </div>
                            <div class="text-right">
                                @foreach ($child->participants as $participant)
                                    <span class="inline-block px-2 py-0.5 bg-blue-50 text-blue-700 text-[10px] font-bold rounded-md uppercase">{{ $participant->registration?->competition?->name ?? '-' }}</span>
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">Belum ada anak terdaftar.</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 sm:p-8">
                    <h3 class="text-lg font-extrabold text-gray-800 mb-4">Rekening Tujuan Transfer</h3>
                    <div class="bg-blue-50 border border-blue-100 rounded-2xl p-5 space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Bank</span>
                            <span class="font-bold text-gray-800">{{ $bank['name'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Nomor Rekening</span>
                            <span class="flex items-center gap-2">
                                <span id="rekening-number" class="font-extrabold text-[#1D6594] tracking-wider">{{ $bank['account_number'] }}</span>
                                <button type="button" onclick="copyRekening()" class="px-3 py-1.5 bg-white border border-blue-200 text-[#1D6594] text-xs font-bold rounded-lg hover:bg-blue-100 transition-colors">
                                    Salin
                                </button>
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Atas Nama</span>
                            <span class="font-bold text-gray-800">{{ $bank['account_holder'] }}</span>
                        </div>
                        <div class="flex justify-between border-t border-blue-100 pt-3">
                            <span class="text-sm text-gray-500">Nominal Transfer</span>
                            <span class="text-lg font-extrabold text-emerald-600">Rp {{ number_format($payment->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            @if ($canUpload)
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 sm:p-8">
                        <h3 class="text-lg font-extrabold text-gray-800 mb-1">
                            {{ $payment->isDitolak() ? 'Unggah Ulang Bukti Bayar' : 'Unggah Bukti Bayar' }}
                        </h3>
                        <p class="text-sm text-gray-500 mb-5">Format JPG, PNG, atau PDF. Maksimal {{ number_format(config('festival.proof.max_kb') / 1024, 0) }} MB.</p>

                        <form action="{{ route('user.payment.proof.store') }}" method="POST" enctype="multipart/form-data" id="proof-form" class="space-y-5">
                            @csrf
                            <div>
                                <x-input-label for="sender_name" :value="__('Nama Pengirim')" class="text-gray-700 font-semibold mb-1 block" />
                                <x-text-input type="text" id="sender_name" name="sender_name" value="{{ old('sender_name') }}" required
                                    class="block w-full px-4 py-2.5 rounded-xl border-gray-300 focus:border-[#1D6594] focus:ring-[#1D6594] bg-gray-50 focus:bg-white" placeholder="Nama pemilik rekening pengirim" />
                                @error('sender_name') <p class="text-rose-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <x-input-label for="transfer_date" :value="__('Tanggal Transfer')" class="text-gray-700 font-semibold mb-1 block" />
                                    <x-text-input type="date" id="transfer_date" name="transfer_date" value="{{ old('transfer_date', now()->format('Y-m-d')) }}" required
                                        class="block w-full px-4 py-2.5 rounded-xl border-gray-300 focus:border-[#1D6594] focus:ring-[#1D6594] bg-gray-50 focus:bg-white" />
                                    @error('transfer_date') <p class="text-rose-500 text-sm mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <x-input-label for="claimed_amount" :value="__('Nominal Transfer (Rp)')" class="text-gray-700 font-semibold mb-1 block" />
                                    <x-text-input type="number" id="claimed_amount" name="claimed_amount" value="{{ old('claimed_amount', $payment->total_amount) }}" min="0"
                                        class="block w-full px-4 py-2.5 rounded-xl border-gray-300 focus:border-[#1D6594] focus:ring-[#1D6594] bg-gray-50 focus:bg-white" placeholder="Contoh: 20000" />
                                    <p class="text-xs text-gray-400 mt-1">*Nominal ini hanya pembanding, validasi tetap oleh panitia.</p>
                                    @error('claimed_amount') <p class="text-rose-500 text-sm mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div>
                                <x-input-label for="proof" :value="__('Bukti Transfer')" class="text-gray-700 font-semibold mb-1 block" />
                                <input type="file" id="proof" name="proof" accept="image/*,application/pdf" required
                                    class="block w-full text-sm text-gray-500 border border-gray-300 rounded-xl cursor-pointer bg-gray-50 p-2">
                                @error('proof') <p class="text-rose-500 text-sm mt-1">{{ $message }}</p> @enderror
                                <div id="proof-preview" class="mt-3 hidden">
                                    <img id="proof-preview-img" class="max-h-64 rounded-xl border border-gray-200" alt="Pratinjau bukti">
                                </div>
                            </div>

                            <div class="pt-4 border-t border-gray-100">
                                <button type="submit" id="proof-submit"
                                    class="w-full flex justify-center items-center gap-2 py-3.5 px-4 rounded-xl shadow-md text-lg font-bold text-white bg-[#1D6594] hover:bg-[#154d73] transition-all disabled:opacity-70 disabled:cursor-wait">
                                    Kirim Bukti Bayar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @elseif ($payment->isMenungguVerifikasi())
                <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5">
                    <p class="font-bold text-amber-700 text-sm">Bukti bayar sedang diperiksa panitia.</p>
                    <p class="text-amber-600 text-xs mt-1">Anda akan melihat perubahan status di halaman ini setelah diverifikasi.</p>
                    @if ($latestProof)
                        <a href="{{ route('user.payment.proof.show') }}" target="_blank" class="inline-block mt-3 text-sm font-bold text-[#1D6594] hover:underline">Lihat bukti yang diunggah</a>
                    @endif
                </div>
            @endif

            @if ($payment->histories->isNotEmpty())
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 sm:p-8">
                        <h3 class="text-lg font-extrabold text-gray-800 mb-4">Riwayat Status</h3>
                        <div class="space-y-3">
                            @foreach ($payment->histories as $history)
                                <div class="flex items-start gap-3 text-sm">
                                    <span class="w-2 h-2 rounded-full mt-1.5 {{ $statusMap[$history->status]['dot'] ?? 'bg-gray-400' }}"></span>
                                    <div>
                                        <p class="font-bold text-gray-700">{{ $statusMap[$history->status]['label'] ?? $history->status }}</p>
                                        <p class="text-xs text-gray-400">{{ $history->created_at?->translatedFormat('d M Y H:i') }} WITA
                                            @if ($history->changedBy) &middot; oleh {{ $history->changedBy->name }} @endif
                                        </p>
                                        @if ($history->reason)
                                            <p class="text-xs text-rose-500 mt-0.5">Alasan: {{ $history->reason }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function copyRekening() {
            const value = document.getElementById('rekening-number').textContent.trim();
            const done = () => Swal.fire({ icon: 'success', title: 'Tersalin!', text: value, timer: 1500, showConfirmButton: false, customClass: { popup: 'rounded-3xl' } });
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(value).then(done).catch(done);
            } else {
                const el = document.createElement('textarea');
                el.value = value;
                document.body.appendChild(el);
                el.select();
                document.execCommand('copy');
                document.body.removeChild(el);
                done();
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const input = document.getElementById('proof');
            const preview = document.getElementById('proof-preview');
            const previewImg = document.getElementById('proof-preview-img');
            const form = document.getElementById('proof-form');
            const submit = document.getElementById('proof-submit');
            if (!input) return;

            const maxBytes = {{ (int) config('festival.proof.max_kb') }} * 1024;

            // Kompres gambar di sisi klien (banyak orang tua unggah foto dari HP).
            function compressImage(file) {
                return new Promise((resolve) => {
                    if (!file.type.startsWith('image/')) return resolve(file);
                    const img = new Image();
                    const reader = new FileReader();
                    reader.onload = (e) => { img.src = e.target.result; };
                    img.onload = () => {
                        const maxDim = 1600;
                        let { width, height } = img;
                        if (width > maxDim || height > maxDim) {
                            const scale = Math.min(maxDim / width, maxDim / height);
                            width = Math.round(width * scale);
                            height = Math.round(height * scale);
                        }
                        const canvas = document.createElement('canvas');
                        canvas.width = width;
                        canvas.height = height;
                        canvas.getContext('2d').drawImage(img, 0, 0, width, height);
                        canvas.toBlob((blob) => {
                            if (!blob || blob.size >= file.size) return resolve(file);
                            resolve(new File([blob], 'bukti.jpg', { type: 'image/jpeg' }));
                        }, 'image/jpeg', 0.75);
                    };
                    img.onerror = () => resolve(file);
                    reader.readAsDataURL(file);
                });
            }

            input.addEventListener('change', async function () {
                let file = this.files[0];
                if (!file) return;

                if (file.type.startsWith('image/')) {
                    file = await compressImage(file);
                    if (!file.name || file.name === '') file = new File([file], 'bukti.jpg', { type: 'image/jpeg' });
                    try {
                        const dt = new DataTransfer();
                        dt.items.add(file);
                        this.files = dt.files;
                    } catch (e) { /* browser lama: abaikan */ }
                }

                if (file.size > maxBytes) {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: 'Ukuran berkas melebihi batas maksimal.', confirmButtonColor: '#d33', customClass: { popup: 'rounded-3xl' } });
                    this.value = '';
                    preview.classList.add('hidden');
                    return;
                }

                if (file.type.startsWith('image/')) {
                    const url = URL.createObjectURL(file);
                    previewImg.src = url;
                    preview.classList.remove('hidden');
                } else {
                    preview.classList.add('hidden');
                }
            });

            form.addEventListener('submit', function () {
                submit.disabled = true;
                submit.innerHTML = 'Mengirim...';
            });
        });
    </script>
@endpush
