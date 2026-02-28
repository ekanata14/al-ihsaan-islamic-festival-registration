@extends('layouts.app')

@section('content')
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div
                class="bg-gradient-to-r from-emerald-700 to-emerald-600 rounded-2xl shadow-md overflow-hidden flex flex-col md:flex-row items-center justify-between p-6 sm:p-8 relative">
                <div class="absolute -right-10 -top-10 w-48 h-48 bg-white opacity-10 rounded-full"></div>
                <div class="absolute left-1/2 bottom-0 w-24 h-24 bg-emerald-400 opacity-20 rounded-full blur-xl"></div>

                <div class="relative z-10 text-center md:text-left mb-6 md:mb-0">
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-white mb-2">Program Khitanan Massal</h2>
                    <p class="text-emerald-100 text-sm max-w-lg">Daftarkan anak, saudara, atau kerabat Anda untuk mengikuti
                        program Khitan Massal gratis dari Al Ihsaan Islamic Festival.</p>
                </div>

                <div class="relative z-10 w-full md:w-auto flex-shrink-0">
                    <a href="{{ route('khitan.registration.person') }}"
                        class="w-full md:w-auto flex items-center justify-center gap-2 px-8 py-3.5 bg-white text-emerald-700 font-bold rounded-xl shadow-lg hover:shadow-xl hover:bg-emerald-50 transition-all hover:-translate-y-1">
                        Daftar Peserta Baru
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                <div
                    class="p-6 border-b border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Daftar Peserta Khitan Anda</h3>
                        <span
                            class="inline-block mt-2 bg-emerald-50 text-emerald-700 border border-emerald-100 px-3 py-1 rounded-full text-xs font-bold tracking-wide">
                            Total: {{ $datas->total() }} Peserta
                        </span>
                    </div>

                    <form action="{{ route('khitan.dashboard') }}" method="GET" class="relative w-full md:w-80 group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400 group-focus-within:text-emerald-600 transition-colors"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="search" name="search" value="{{ request('search') }}"
                            class="block w-full pl-10 py-2.5 text-sm text-gray-900 bg-white border border-gray-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 transition-all shadow-sm"
                            placeholder="Cari nama, no reg, domisili...">
                    </form>
                </div>

                <div class="overflow-x-auto custom-scrollbar">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-bold text-center w-16">No</th>
                                <th scope="col" class="px-6 py-4 font-bold text-center">QR Code</th>
                                <th scope="col" class="px-6 py-4 font-bold">No. Registrasi</th>
                                <th scope="col" class="px-6 py-4 font-bold">Nama Anak</th>
                                <th scope="col" class="px-6 py-4 font-bold">Nama Orang Tua</th>
                                <th scope="col" class="px-6 py-4 font-bold">Domisili</th>
                                <th scope="col" class="px-6 py-4 font-bold">Berkas (Lihat)</th>
                                <th scope="col" class="px-6 py-4 font-bold">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($datas as $item)
                                <tr class="bg-white hover:bg-emerald-50/30 transition-colors">
                                    <td class="px-6 py-4 font-medium text-gray-900 text-center">
                                        {{ $loop->iteration + ($datas->currentPage() - 1) * $datas->perPage() }}
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('khitan.registration.qr-code', $item->id) }}"
                                            class="inline-flex p-2 text-emerald-600 bg-emerald-50 hover:bg-emerald-600 hover:text-white rounded-lg transition-colors tooltip shadow-sm"
                                            title="Lihat Tiket QR">
                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M4 4h6v6H4V4Zm10 10h6v6h-6v-6Zm0-10h6v6h-6V4Zm-4 10h.01v.01H10V14Zm0 4h.01v.01H10V18Zm-3 2h.01v.01H7V20Zm0-4h.01v.01H7V16Zm-3 2h.01v.01H4V18Zm0-4h.01v.01H4V14Zm3-7h.01v.01H7V7Zm10 10h.01v.01H17V17Z">
                                                </path>
                                            </svg>
                                        </a>
                                    </td>

                                    <td class="px-6 py-4 font-bold text-emerald-700 whitespace-nowrap">
                                        {{ $item->registration_number }}
                                    </td>

                                    <td class="px-6 py-4 font-bold text-gray-800">
                                        {{ $item->name ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4 font-medium text-gray-600">
                                        {{ $item->pic->name ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex flex-col gap-1">
                                            <span class="text-gray-700 truncate max-w-[150px]"
                                                title="{{ $item->domicile }}">{{ $item->domicile }}</span>
                                            <span
                                                class="w-fit px-2 py-0.5 text-[10px] font-bold rounded-full {{ $item->is_sanur ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                                {{ $item->is_sanur ? 'WARGA SANUR' : 'NON-SANUR' }}
                                            </span>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex flex-col gap-2">
                                            <button type="button"
                                                onclick="openModal('{{ asset('storage/' . $item->photo_url) }}', 'Foto Anak - {{ $item->name }}')"
                                                class="text-xs font-semibold text-blue-600 hover:text-blue-800 hover:underline text-left transition-colors">📸
                                                Foto Anak</button>

                                            <button type="button"
                                                onclick="openModal('{{ asset('storage/' . $item->certificate_url) }}', 'Akta Kelahiran - {{ $item->name }}')"
                                                class="text-xs font-semibold text-blue-600 hover:text-blue-800 hover:underline text-left transition-colors">📄
                                                Akta Kelahiran</button>

                                            @if (!empty($item->familyCard) && !empty($item->familyCard->family_card_url))
                                                <button type="button"
                                                    onclick="openModal('{{ asset('storage/' . $item->familyCard->family_card_url) }}', 'Kartu Keluarga - {{ $item->name }}')"
                                                    class="text-xs font-semibold text-blue-600 hover:text-blue-800 hover:underline text-left transition-colors">👥
                                                    Kartu Keluarga</button>
                                            @else
                                                <span class="text-xs text-rose-500 italic">⚠️ KK Kosong</span>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 text-xs font-bold rounded-full border whitespace-nowrap
                                            {{ strtolower($item->status) == 'checkin' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-amber-50 text-amber-700 border-amber-200' }}">
                                            @if (strtolower($item->status) == 'checkin')
                                                <span
                                                    class="w-1.5 h-1.5 me-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                                            @else
                                                <span class="w-1.5 h-1.5 me-1.5 bg-amber-500 rounded-full"></span>
                                            @endif
                                            {{ strtoupper($item->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="px-6 py-12 text-center text-gray-400" colspan="8">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor"
                                                stroke-width="1.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                            </svg>
                                            @if (request('search'))
                                                <p class="font-medium text-gray-500">Pencarian "{{ request('search') }}"
                                                    tidak ditemukan.</p>
                                            @else
                                                <p class="font-medium text-gray-500">Anda belum mendaftarkan peserta
                                                    khitan.</p>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($datas->hasPages())
                    <div class="p-4 border-t border-gray-100 bg-gray-50/50">
                        {{ $datas->links('pagination::tailwind') }}
                    </div>
                @endif
            </div>

        </div>
    </div>

    <div id="photoModal"
        class="fixed inset-0 z-[100] hidden bg-gray-900/80 backdrop-blur-sm flex items-center justify-center transition-opacity duration-300 opacity-0"
        aria-modal="true" role="dialog">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden w-full max-w-2xl transform scale-95 transition-transform duration-300"
            id="photoModalContent">

            <div class="flex justify-between items-center p-5 border-b border-gray-100 bg-gray-50">
                <h2 id="modalTitle" class="text-xl font-bold text-gray-800">Preview Berkas</h2>
                <button type="button" onclick="closeModal()"
                    class="text-gray-400 hover:text-rose-500 hover:bg-rose-50 p-2 rounded-lg transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="p-4 bg-gray-200 flex justify-center items-center"
                style="min-h: 40vh; max-h: 70vh; overflow-y: auto;">
                <img id="modalImage" src="" alt="Berkas Preview"
                    class="max-w-full h-auto object-contain rounded shadow-sm border border-white">
            </div>

            <div class="flex justify-end p-4 border-t border-gray-100 bg-white">
                <button type="button"
                    class="px-6 py-2 bg-gray-800 hover:bg-gray-900 text-white font-bold rounded-xl shadow transition-colors"
                    onclick="closeModal()">Tutup</button>
            </div>
        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            height: 8px;
            width: 8px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f8fafc;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>

    <script>
        function openModal(imageUrl, title) {
            const modal = document.getElementById('photoModal');
            const modalContent = document.getElementById('photoModalContent');

            document.getElementById('modalImage').src = imageUrl;
            document.getElementById('modalTitle').textContent = title;

            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modal.classList.add('opacity-100');
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100');
            }, 10);
        }

        function closeModal() {
            const modal = document.getElementById('photoModal');
            const modalContent = document.getElementById('photoModalContent');

            modal.classList.remove('opacity-100');
            modal.classList.add('opacity-0');
            modalContent.classList.remove('scale-100');
            modalContent.classList.add('scale-95');

            setTimeout(() => {
                modal.classList.add('hidden');
                document.getElementById('modalImage').src = '';
            }, 300);
        }
    </script>
@endsection
