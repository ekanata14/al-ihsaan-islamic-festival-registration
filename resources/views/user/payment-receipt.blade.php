@extends('layouts.app')

@section('content')
    <style>
        @media print {
            body > aside,
            header,
            #contactModal,
            .no-print {
                display: none !important;
            }
            .lg\:ml-64 {
                margin-left: 0 !important;
            }
            main {
                background: #ffffff !important;
            }
        }
    </style>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <div class="no-print flex justify-between items-center">
                <a href="{{ route('user.payment') }}" class="inline-flex items-center text-sm font-semibold text-gray-500 hover:text-[#1D6594]">
                    &larr; Kembali ke Pembayaran
                </a>
                <button type="button" onclick="window.print()"
                    class="px-5 py-2.5 bg-[#1D6594] text-white font-bold rounded-xl hover:bg-[#154d73] transition-all shadow-sm">
                    Cetak / Simpan PDF
                </button>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-[#1D6594] p-6 sm:p-8 text-white">
                    <p class="text-xs font-bold uppercase tracking-widest opacity-80">Al Ihsaan Islamic Festival 2026</p>
                    <h2 class="text-2xl font-extrabold mt-1">Bukti Pendaftaran</h2>
                    <p class="text-sm opacity-90 mt-1">Tunjukkan bukti ini saat registrasi ulang untuk mengambil pin dan kupon makan.</p>
                </div>

                <div class="p-6 sm:p-8">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                        <div>
                            <p class="text-xs text-gray-500 font-bold uppercase">No. Tagihan</p>
                            <p class="font-bold text-gray-800">{{ $payment->invoice_number }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-bold uppercase">Tanggal Verifikasi</p>
                            <p class="font-bold text-gray-800">{{ $payment->verified_at?->translatedFormat('d F Y H:i') ?? '-' }} WITA</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-bold uppercase">Wali / PIC</p>
                            <p class="font-bold text-gray-800">{{ $payment->pic?->name ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-bold uppercase">TPG / Asal</p>
                            <p class="font-bold text-gray-800">{{ $payment->pic?->group?->name ?? '-' }}</p>
                        </div>
                    </div>

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
                                @foreach ($children as $child)
                                    <tr>
                                        <td class="px-4 py-3 text-center">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3 font-bold text-gray-800">{{ $child->name }}</td>
                                        <td class="px-4 py-3">{{ $child->nik }}</td>
                                        <td class="px-4 py-3">
                                            {{ $child->participants->map(fn ($p) => $p->registration?->competition?->name)->filter()->unique()->implode(', ') ?: '-' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="bg-emerald-50 border border-emerald-100 rounded-2xl p-4">
                            <p class="text-xs text-emerald-600 font-bold uppercase">Status</p>
                            <p class="text-lg font-extrabold text-emerald-700">LUNAS</p>
                        </div>
                        <div class="bg-gray-50 border border-gray-100 rounded-2xl p-4">
                            <p class="text-xs text-gray-500 font-bold uppercase">Total Dibayar</p>
                            <p class="text-lg font-extrabold text-gray-800">Rp {{ number_format($payment->verified_amount ?? $payment->total_amount, 0, ',', '.') }}</p>
                        </div>
                        <div class="bg-amber-50 border border-amber-100 rounded-2xl p-4">
                            <p class="text-xs text-amber-600 font-bold uppercase">Kupon Makan</p>
                            <p class="text-lg font-extrabold text-amber-700">{{ $payment->couponCount() }} kupon</p>
                        </div>
                    </div>

                    <p class="text-xs text-gray-400 mt-6">Dokumen ini dihasilkan otomatis oleh sistem pendaftaran AIIF 2026.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
