@extends('layouts.app')

@section('content')
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <x-breadcrumb />

            <div
                class="flex flex-col md:flex-row justify-between items-start md:items-center bg-white p-6 rounded-2xl shadow-sm border border-gray-100 gap-4">
                <div>
                    <h2 class="text-2xl font-extrabold text-gray-900">Daftar Registrasi Peserta</h2>
                    <p class="text-sm text-gray-500 mt-1">Kelola dan pantau seluruh peserta yang telah didaftarkan dari TPQ
                        Anda.</p>
                </div>

                <div class="w-full md:w-auto">
                    <form action="{{ route('user.participants') }}" method="GET" class="relative group w-full sm:w-80">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400 group-focus-within:text-[#1D6594]" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="search" name="search" value="{{ request('search') }}"
                            class="block w-full pl-10 py-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-[#1D6594] focus:border-[#1D6594] transition-all shadow-sm"
                            placeholder="Cari no reg, peserta, atau lomba...">
                    </form>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto custom-scrollbar">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="text-xs text-gray-500 uppercase bg-gray-50/80 border-b border-gray-100">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-bold text-center w-16">No</th>
                                <th scope="col" class="px-6 py-4 font-bold">No. Registrasi</th>
                                <th scope="col" class="px-6 py-4 font-bold">Nama Peserta</th>
                                <th scope="col" class="px-6 py-4 font-bold">Lomba & Kategori</th>
                                <th scope="col" class="px-6 py-4 font-bold text-center">Status</th>
                                <th scope="col" class="px-6 py-4 font-bold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($datas as $item)
                                <tr class="bg-white hover:bg-blue-50/30 transition-colors group">
                                    <td class="px-6 py-4 font-medium text-gray-900 text-center">
                                        {{ $loop->iteration + ($datas->currentPage() - 1) * $datas->perPage() }}
                                    </td>

                                    <td
                                        class="px-6 py-4 font-bold text-[#1D6594] whitespace-nowrap uppercase tracking-wider">
                                        {{ $item->registration_number }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="font-bold text-gray-800">
                                            {{ $item->participants[0]->name ?? 'Nama Tidak Tersedia' }}
                                        </div>
                                        @if (count($item->participants) > 1)
                                            <span class="text-[10px] text-gray-400 italic">+
                                                {{ count($item->participants) - 1 }} anggota lainnya</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex flex-col gap-1">
                                            <span
                                                class="font-bold text-gray-800">{{ $item->competition->name ?? '-' }}</span>
                                            <span
                                                class="px-2 py-0.5 bg-blue-50 text-blue-700 text-[10px] font-bold rounded-md w-fit uppercase">{{ $item->competition->category->name ?? '-' }}</span>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        @if (strtolower($item->status) == 'checkin')
                                            <span
                                                class="inline-flex items-center px-3 py-1 text-xs font-bold rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                <span
                                                    class="w-1.5 h-1.5 me-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                                                CHECK-IN
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-3 py-1 text-xs font-bold rounded-full bg-amber-50 text-amber-700 border border-amber-200">
                                                <span class="w-1.5 h-1.5 me-1.5 bg-amber-500 rounded-full"></span> PENDING
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('user.participants.detail', $item->id) }}"
                                                class="p-2 text-blue-600 bg-blue-50 hover:bg-blue-600 hover:text-white rounded-xl transition-all tooltip"
                                                title="Detail">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                    </path>
                                                </svg>
                                            </a>

                                            <button type="button" onclick="showQrModal('{{ $item->registration_number }}')"
                                                class="p-2.5 text-emerald-600 bg-emerald-50 hover:bg-emerald-600 hover:text-white rounded-xl transition-all tooltip"
                                                title="QR Check-In">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                    <path
                                                        d="M4 4h6v6H4V4Zm10 10h6v6h-6v-6Zm0-10h6v6h-6V4Zm-4 10h.01v.01H10V14Zm0 4h.01v.01H10V18Zm-3 2h.01v.01H7V20Zm0-4h.01v.01H7V16Zm-3 2h.01v.01H4V18Zm0-4h.01v.01H4V14Zm3-7h.01v.01H7V7Zm10 10h.01v.01H17V17Z">
                                                    </path>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="px-6 py-16 text-center text-gray-400" colspan="6">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-16 h-16 mb-4 text-gray-300" fill="none" stroke="currentColor"
                                                stroke-width="1.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                                </path>
                                            </svg>
                                            @if (request('search'))
                                                <p class="text-lg font-medium text-gray-500">Pencarian
                                                    "{{ request('search') }}" tidak ditemukan.</p>
                                            @else
                                                <p class="text-lg font-medium text-gray-500">Belum ada peserta terdaftar.
                                                </p>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($datas->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                        {{ $datas->links('pagination::tailwind') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div id="qrModal"
        class="fixed inset-0 z-[100] hidden bg-gray-900/70 backdrop-blur-sm flex items-center justify-center transition-all duration-300 opacity-0 p-4">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden w-full max-w-sm transform scale-95 transition-all duration-300"
            id="qrModalContent">
            <div class="bg-[#1D6594] p-5 text-white flex justify-between items-center relative overflow-hidden">
                <div class="absolute -right-4 -top-4 w-16 h-16 bg-white/10 rounded-full"></div>
                <h2 class="text-lg font-bold relative z-10">QR Code Registrasi</h2>
                <button type="button" onclick="closeQrModal()" class="relative z-10 text-white/70 hover:text-white p-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="p-8 flex flex-col items-center">
                <p id="qrRegNumber"
                    class="text-sm font-black text-[#1D6594] bg-blue-50 px-4 py-1 rounded-full mb-6 uppercase border border-blue-100">
                </p>

                <div id="qrcode" class="p-4 bg-white border border-gray-100 shadow-inner rounded-2xl"></div>

                <div class="mt-8 text-center text-[11px] text-gray-400">
                    Tunjukkan QR Code ini kepada panitia untuk validasi kehadiran.
                </div>
            </div>

            <div class="bg-gray-50 p-4 border-t border-gray-100 text-center">
                <button type="button" onclick="closeQrModal()"
                    class="w-full py-3 bg-white border border-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-100 transition-colors shadow-sm">
                    Tutup
                </button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

    <script>
        function showQrModal(regNumber) {
            const modal = document.getElementById('qrModal');
            const content = document.getElementById('qrModalContent');
            const regText = document.getElementById('qrRegNumber');
            const qrContainer = document.getElementById('qrcode');

            regText.textContent = regNumber;
            qrContainer.innerHTML = ''; // Clear prev QR

            new QRCode(qrContainer, {
                text: regNumber,
                width: 200,
                height: 200,
                colorDark: "#1D6594",
                colorLight: "#ffffff",
                correctLevel: QRCode.CorrectLevel.H
            });

            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                content.classList.remove('scale-95');
            }, 10);
        }

        function closeQrModal() {
            const modal = document.getElementById('qrModal');
            const content = document.getElementById('qrModalContent');

            modal.classList.add('opacity-0');
            content.classList.add('scale-95');

            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }
    </script>
@endpush
