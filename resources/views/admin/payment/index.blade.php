@extends('layouts.app')

@section('content')
    @php
        $statusMap = [
            'belum_bayar' => ['label' => 'Belum Bayar', 'class' => 'bg-gray-100 text-gray-700 border-gray-200', 'dot' => 'bg-gray-400'],
            'menunggu_verifikasi' => ['label' => 'Menunggu Verifikasi', 'class' => 'bg-amber-50 text-amber-700 border-amber-200', 'dot' => 'bg-amber-500'],
            'terverifikasi' => ['label' => 'Terverifikasi', 'class' => 'bg-emerald-50 text-emerald-700 border-emerald-200', 'dot' => 'bg-emerald-500'],
            'ditolak' => ['label' => 'Ditolak', 'class' => 'bg-rose-50 text-rose-700 border-rose-200', 'dot' => 'bg-rose-500'],
        ];
    @endphp

    <div class="py-8 max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8">
        <x-breadcrumb />

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-900">Manajemen Pembayaran</h2>
                <p class="text-sm text-gray-500 mt-1">Verifikasi bukti transfer pendaftaran dan pantau status pembayaran peserta.</p>
            </div>
            <a href="{{ route('verified-participants.export') }}"
                class="inline-flex w-full sm:w-auto items-center justify-center px-5 py-2.5 bg-emerald-500 text-white font-bold rounded-xl hover:bg-emerald-600 transition-all shadow-sm hover:shadow-md hover:-translate-y-0.5 gap-2 whitespace-nowrap">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path></svg>
                Export Excel
            </a>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <p class="text-xs text-gray-500 font-bold uppercase">Total Anak Terdaftar</p>
                <p class="text-3xl font-extrabold text-gray-800 mt-1">{{ number_format($summary['total_children'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <p class="text-xs text-emerald-600 font-bold uppercase">Tagihan Lunas</p>
                <p class="text-3xl font-extrabold text-emerald-600 mt-1">{{ number_format($summary['lunas'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <p class="text-xs text-amber-600 font-bold uppercase">Tagihan Belum Lunas</p>
                <p class="text-3xl font-extrabold text-amber-600 mt-1">{{ number_format($summary['belum_lunas'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <p class="text-xs text-[#1D6594] font-bold uppercase">Total Uang Terverifikasi</p>
                <p class="text-2xl font-extrabold text-[#1D6594] mt-1">Rp {{ number_format($summary['total_verified_money'], 0, ',', '.') }}</p>
            </div>
        </div>

        <form action="{{ route('admin.dashboard.payment') }}" method="GET"
            class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-6 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-3">
            <input type="search" name="search" value="{{ request('search') }}"
                class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-[#1D6594] focus:border-[#1D6594]"
                placeholder="Cari invoice, nama wali, anak, atau TPQ...">

            <select name="status" class="block w-full px-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-[#1D6594] focus:border-[#1D6594]">
                <option value="">Semua Status</option>
                @foreach (['belum_bayar' => 'Belum Bayar', 'menunggu_verifikasi' => 'Menunggu Verifikasi', 'terverifikasi' => 'Terverifikasi', 'ditolak' => 'Ditolak'] as $value => $label)
                    <option value="{{ $value }}" {{ ($status ?? '') === $value ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>

            <select name="sort" class="block w-full px-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-[#1D6594] focus:border-[#1D6594]">
                @foreach (['latest' => 'Terbaru', 'oldest' => 'Terlama', 'amount_desc' => 'Nominal Terbesar', 'amount_asc' => 'Nominal Terkecil'] as $value => $label)
                    <option value="{{ $value }}" {{ ($sort ?? 'latest') === $value ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>

            <div class="flex gap-3 justify-end">
                <a href="{{ route('admin.dashboard.payment') }}" class="px-5 py-2.5 text-gray-600 font-bold rounded-xl hover:bg-gray-50 transition-colors">Reset</a>
                <button type="submit" class="px-6 py-2.5 bg-[#1D6594] text-white font-bold rounded-xl hover:bg-[#154d73] transition-colors">Filter</button>
            </div>
        </form>

        <div id="realtime-payment-list" data-realtime="payment" class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden transition-colors duration-500">
            <form action="{{ route('admin.dashboard.payment.bulk-verify') }}" method="POST" id="bulk-form">
                @csrf
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                    <p class="text-sm text-gray-500"><span id="selected-count">0</span> tagihan dipilih</p>
                    <button type="submit" id="bulk-button" disabled
                        class="inline-flex items-center justify-center px-5 py-2 bg-emerald-500 text-white font-bold rounded-xl hover:bg-emerald-600 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                        Verifikasi Massal
                    </button>
                </div>

                <div class="overflow-x-auto custom-scrollbar">
                    <table class="w-full text-sm text-left text-gray-600 whitespace-nowrap">
                        <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-4 py-4 w-10 text-center">
                                    <input type="checkbox" id="select-all" class="rounded border-gray-300 text-[#1D6594] focus:ring-[#1D6594]">
                                </th>
                                <th class="px-4 py-4 font-bold text-center w-12">No</th>
                                <th class="px-4 py-4 font-bold">No. Tagihan</th>
                                <th class="px-4 py-4 font-bold">Wali / PIC</th>
                                <th class="px-4 py-4 font-bold">TPG / Asal</th>
                                <th class="px-4 py-4 font-bold text-center">Anak</th>
                                <th class="px-4 py-4 font-bold text-right">Total</th>
                                <th class="px-4 py-4 font-bold text-center">Status</th>
                                <th class="px-4 py-4 font-bold text-center w-20">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($datas as $item)
                                @php $badge = $statusMap[$item->status] ?? $statusMap['belum_bayar']; @endphp
                                <tr class="bg-white hover:bg-blue-50/30 transition-colors">
                                    <td class="px-4 py-4 text-center">
                                        @if ($item->status === 'menunggu_verifikasi')
                                            <input type="checkbox" name="payment_ids[]" value="{{ $item->id }}"
                                                class="bulk-checkbox rounded border-gray-300 text-[#1D6594] focus:ring-[#1D6594]">
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 text-center">{{ $loop->iteration + ($datas->currentPage() - 1) * $datas->perPage() }}</td>
                                    <td class="px-4 py-4 font-bold text-[#1D6594]">{{ $item->invoice_number }}</td>
                                    <td class="px-4 py-4">
                                        <p class="font-bold text-gray-800">{{ $item->pic?->name ?? '-' }}</p>
                                        <p class="text-xs text-gray-400">{{ $item->pic?->phone_number }}</p>
                                    </td>
                                    <td class="px-4 py-4">{{ $item->pic?->group?->name ?? '-' }}</td>
                                    <td class="px-4 py-4 text-center font-bold text-gray-800">{{ $item->child_count }}</td>
                                    <td class="px-4 py-4 text-right font-bold text-gray-800">Rp {{ number_format($item->total_amount, 0, ',', '.') }}</td>
                                    <td class="px-4 py-4 text-center">
                                        <span class="inline-flex items-center px-3 py-1 text-xs font-bold rounded-full border {{ $badge['class'] }}">
                                            <span class="w-1.5 h-1.5 me-1.5 rounded-full {{ $badge['dot'] }}"></span>
                                            {{ $badge['label'] }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <a href="{{ route('admin.dashboard.payment.detail', $item->id) }}"
                                            class="inline-flex p-2 text-blue-600 bg-blue-50 hover:bg-blue-600 hover:text-white rounded-xl transition-all" title="Detail">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="px-4 py-16 text-center text-gray-400" colspan="9">
                                        <p class="text-lg font-medium text-gray-500">Belum ada data pembayaran.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </form>

            @if ($datas->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                    {{ $datas->links('pagination::tailwind') }}
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectAll = document.getElementById('select-all');
            const boxes = document.querySelectorAll('.bulk-checkbox');
            const countEl = document.getElementById('selected-count');
            const button = document.getElementById('bulk-button');
            const form = document.getElementById('bulk-form');

            function refresh() {
                const checked = document.querySelectorAll('.bulk-checkbox:checked').length;
                countEl.textContent = checked;
                button.disabled = checked === 0;
            }

            if (selectAll) {
                selectAll.addEventListener('change', function () {
                    boxes.forEach(b => b.checked = selectAll.checked);
                    refresh();
                });
            }

            boxes.forEach(b => b.addEventListener('change', refresh));

            form.addEventListener('submit', function (e) {
                e.preventDefault();
                const checked = document.querySelectorAll('.bulk-checkbox:checked').length;
                if (checked === 0) return;
                Swal.fire({
                    title: 'Verifikasi Massal',
                    text: `Verifikasi ${checked} pembayaran terpilih sekaligus?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#059669',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Verifikasi',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    customClass: { popup: 'rounded-3xl' }
                }).then((result) => {
                    if (result.isConfirmed) {
                        button.disabled = true;
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush
