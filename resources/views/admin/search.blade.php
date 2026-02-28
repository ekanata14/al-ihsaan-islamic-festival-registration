@extends('layouts.app')

@section('content')
    <div class="py-8 max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8">

        <x-breadcrumb :links="['Hasil Pencarian' => '#']" />

        <div
            class="bg-gradient-to-r from-[#1D6594] to-[#154d73] rounded-3xl p-6 sm:p-8 mb-8 text-white shadow-md relative overflow-hidden flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
            <div class="relative z-10">
                <h2 class="text-2xl font-extrabold">Hasil Pencarian: <span class="text-[#E9AA14]">"{{ $search }}"</span>
                </h2>
                <p class="text-blue-100 mt-1 text-sm">
                    Sistem menemukan
                    <strong class="text-white bg-white/20 px-2 py-0.5 rounded-md">{{ $lombaDatas->count() }} Pendaftar
                        Lomba</strong> dan
                    <strong class="text-white bg-white/20 px-2 py-0.5 rounded-md">{{ $khitanDatas->count() }} Pendaftar
                        Khitan</strong>.
                </p>
            </div>
            <a href="{{ url()->previous() }}"
                class="relative z-10 shrink-0 px-5 py-2.5 bg-white/10 hover:bg-white/20 border border-white/20 text-white font-bold rounded-xl transition-all flex items-center gap-2 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>

        <div class="mb-8">
            <h3 class="text-lg font-extrabold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-[#1D6594]" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                </svg>
                Data Pendaftaran Lomba ({{ $lombaDatas->count() }})
            </h3>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto custom-scrollbar">
                    <table class="w-full text-sm text-left text-gray-600 whitespace-nowrap">
                        <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-bold text-center w-16">No</th>
                                <th scope="col" class="px-6 py-4 font-bold">No. Reg</th>
                                <th scope="col" class="px-6 py-4 font-bold">Info PIC (Wali)</th>
                                <th scope="col" class="px-6 py-4 font-bold">Nama Peserta</th>
                                <th scope="col" class="px-6 py-4 font-bold">Lomba & Grup</th>
                                <th scope="col" class="px-6 py-4 font-bold text-center">Status</th>
                                <th scope="col" class="px-6 py-4 font-bold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($lombaDatas as $item)
                                <tr class="bg-white hover:bg-blue-50/30 transition-colors">
                                    <td class="px-6 py-4 font-medium text-gray-900 text-center">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 font-extrabold text-[#1D6594]">{{ $item->registration_number }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="flex flex-col">
                                                <span class="font-bold text-gray-800">{{ $item->pic->name ?? '-' }}</span>
                                                <span
                                                    class="text-xs font-medium text-gray-500">{{ $item->pic->phone_number ?? '-' }}</span>
                                            </div>
                                            @if (!empty($item->pic->phone_number))
                                                <a href="https://wa.me/{{ $item->pic->phone_number }}" target="_blank"
                                                    class="p-1.5 bg-green-50 text-green-600 rounded-xl hover:bg-green-500 hover:text-white transition-all tooltip shadow-sm"
                                                    title="Chat WA">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                        <path
                                                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 14c-2.21 0-4-1.79-4-4h2c0 1.1.9 2 2 2s2-.9 2-2-.9-2-2-2v-2c2.21 0 4 1.79 4 4s-1.79 4-4 4z">
                                                        </path>
                                                    </svg>
                                                </a>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 font-bold text-gray-900">{{ $item->participants[0]->name ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex flex-col gap-1">
                                            <span
                                                class="font-bold text-gray-800">{{ $item->competition->name ?? '-' }}</span>
                                            <span
                                                class="text-xs font-semibold text-gray-500">{{ $item->group->name ?? '-' }}</span>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        @if (strtolower($item->status) == 'checkin')
                                            <span
                                                class="inline-flex items-center px-2.5 py-1 text-xs font-bold rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                CHECK-IN
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2.5 py-1 text-xs font-bold rounded-full bg-amber-50 text-amber-700 border border-amber-200">
                                                {{ strtoupper($item->status) }}
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('admin.dashboard.registration.detail.person', $item->id) }}"
                                            class="inline-block p-2 text-blue-600 bg-blue-50 hover:bg-blue-600 hover:text-white rounded-lg transition-colors tooltip"
                                            title="Lihat Detail">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="px-6 py-12 text-center text-gray-400" colspan="7">
                                        <p class="font-medium text-gray-500">Tidak ada pendaftaran lomba untuk kata kunci
                                            "{{ $search }}".</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div>
            <h3 class="text-lg font-extrabold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                </svg>
                Data Pendaftaran Khitan ({{ $khitanDatas->count() }})
            </h3>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto custom-scrollbar">
                    <table class="w-full text-sm text-left text-gray-600 whitespace-nowrap">
                        <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-bold text-center w-16">No</th>
                                <th scope="col" class="px-6 py-4 font-bold">No. Reg</th>
                                <th scope="col" class="px-6 py-4 font-bold">Nama Anak</th>
                                <th scope="col" class="px-6 py-4 font-bold">Info Wali / Ortu</th>
                                <th scope="col" class="px-6 py-4 font-bold">Domisili</th>
                                <th scope="col" class="px-6 py-4 font-bold text-center">Cek Berkas</th>
                                <th scope="col" class="px-6 py-4 font-bold text-center">Status</th>
                                <th scope="col" class="px-6 py-4 font-bold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($khitanDatas as $item)
                                <tr class="bg-white hover:bg-emerald-50/30 transition-colors">
                                    <td class="px-6 py-4 font-medium text-gray-900 text-center">{{ $loop->iteration }}
                                    </td>
                                    <td class="px-6 py-4 font-extrabold text-emerald-700">{{ $item->registration_number }}
                                    </td>
                                    <td class="px-6 py-4 font-bold text-gray-900">{{ $item->name ?? '-' }}</td>

                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="flex flex-col">
                                                <span class="font-bold text-gray-800">{{ $item->pic->name ?? '-' }}</span>
                                                <span
                                                    class="text-xs font-medium text-gray-500">{{ $item->pic->phone_number ?? '-' }}</span>
                                            </div>
                                            @if (!empty($item->pic->phone_number))
                                                <a href="https://wa.me/{{ $item->pic->phone_number }}" target="_blank"
                                                    class="p-1.5 bg-green-50 text-green-600 rounded-xl hover:bg-green-500 hover:text-white transition-all tooltip shadow-sm"
                                                    title="Chat Wali">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                        <path
                                                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 14c-2.21 0-4-1.79-4-4h2c0 1.1.9 2 2 2s2-.9 2-2-.9-2-2-2v-2c2.21 0 4 1.79 4 4s-1.79 4-4 4z">
                                                        </path>
                                                    </svg>
                                                </a>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex flex-col items-start gap-1">
                                            <span class="text-sm text-gray-700">{{ $item->domicile }}</span>
                                            @if ($item->is_sanur)
                                                <span
                                                    class="px-2 py-0.5 text-[10px] font-bold bg-blue-100 text-blue-700 rounded-md uppercase tracking-wider">Warga
                                                    Sanur</span>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-1.5">
                                            @if (!empty($item->familyCard) && !empty($item->familyCard->family_card_url))
                                                <button type="button"
                                                    onclick="openModal('{{ asset('storage/' . $item->familyCard->family_card_url) }}', 'Kartu Keluarga - {{ $item->name }}')"
                                                    class="p-1.5 bg-gray-100 text-gray-600 rounded-lg hover:bg-emerald-600 hover:text-white transition-colors tooltip"
                                                    title="Lihat KK">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                                        </path>
                                                    </svg>
                                                </button>
                                            @endif
                                            @if ($item->certificate_url)
                                                <button type="button"
                                                    onclick="openModal('{{ asset('storage/' . $item->certificate_url) }}', 'Akta Kelahiran - {{ $item->name }}')"
                                                    class="p-1.5 bg-gray-100 text-gray-600 rounded-lg hover:bg-emerald-600 hover:text-white transition-colors tooltip"
                                                    title="Lihat Akta">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                        </path>
                                                    </svg>
                                                </button>
                                            @endif
                                            @if ($item->photo_url)
                                                <button type="button"
                                                    onclick="openModal('{{ asset('storage/' . $item->photo_url) }}', 'Foto Anak - {{ $item->name }}')"
                                                    class="p-1.5 bg-gray-100 text-gray-600 rounded-lg hover:bg-emerald-600 hover:text-white transition-colors tooltip"
                                                    title="Lihat Foto">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                        </path>
                                                    </svg>
                                                </button>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        @if (strtolower($item->status) == 'checkin')
                                            <span
                                                class="inline-flex items-center px-2.5 py-1 text-xs font-bold rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">CHECK-IN</span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2.5 py-1 text-xs font-bold rounded-full bg-blue-50 text-blue-700 border border-blue-200">REGISTERED</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('admin.dashboard.khitan-registration.edit', $item->id) }}"
                                                class="p-2 text-blue-600 bg-blue-50 hover:bg-blue-600 hover:text-white rounded-lg transition-colors tooltip"
                                                title="Detail / Edit">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                            </a>
                                            <form action="{{ route('admin.dashboard.khitan-registration.destroy') }}"
                                                method="POST" class="delete-form m-0">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <button type="submit"
                                                    class="p-2 text-rose-500 bg-rose-50 hover:bg-rose-500 hover:text-white rounded-lg transition-colors tooltip"
                                                    title="Hapus">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="px-6 py-12 text-center text-gray-400" colspan="8">
                                        <p class="font-medium text-gray-500">Tidak ada pendaftaran khitan untuk kata kunci
                                            "{{ $search }}".</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <div id="imageModal"
        class="fixed inset-0 z-[100] hidden bg-gray-900/80 backdrop-blur-sm flex items-center justify-center transition-opacity duration-300 opacity-0"
        aria-modal="true" role="dialog">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden w-full max-w-3xl transform scale-95 transition-transform duration-300"
            id="imageModalContent">
            <div class="flex justify-between items-center p-5 border-b border-gray-100 bg-gray-50">
                <h3 id="modalTitle" class="text-lg font-bold text-gray-800">Preview Berkas</h3>
                <button type="button" onclick="closeModal()"
                    class="text-gray-400 hover:text-rose-500 hover:bg-rose-50 p-2 rounded-lg transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="p-4 bg-gray-800 flex justify-center items-center min-h-[50vh] max-h-[75vh] overflow-y-auto">
                <img id="modalImage" src="" alt="Preview Berkas"
                    class="max-w-full h-auto object-contain rounded shadow-sm">
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            // Logic Animasi Modal Gambar
            function openModal(imageUrl, title) {
                const modal = document.getElementById('imageModal');
                const content = document.getElementById('imageModalContent');

                document.getElementById('modalImage').src = imageUrl;
                document.getElementById('modalTitle').textContent = title;

                modal.classList.remove('hidden');
                setTimeout(() => {
                    modal.classList.remove('opacity-0');
                    content.classList.remove('scale-95');
                }, 10);
            }

            function closeModal() {
                const modal = document.getElementById('imageModal');
                const content = document.getElementById('imageModalContent');

                modal.classList.add('opacity-0');
                content.classList.add('scale-95');

                setTimeout(() => {
                    modal.classList.add('hidden');
                    document.getElementById('modalImage').src = '';
                }, 300);
            }

            // Logic SweetAlert untuk Hapus Data (Digunakan di Tabel Khitan)
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.delete-form').forEach(form => {
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();
                        Swal.fire({
                            title: 'Hapus Data Pendaftar?',
                            text: "Data ini akan dihapus secara permanen dari sistem!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#1D6594',
                            confirmButtonText: 'Ya, Hapus!',
                            cancelButtonText: 'Batal',
                            reverseButtons: true,
                            customClass: {
                                popup: 'rounded-3xl'
                            }
                        }).then((result) => {
                            if (result.isConfirmed) form.submit();
                        });
                    });
                });
            });
        </script>
    @endpush
@endsection
