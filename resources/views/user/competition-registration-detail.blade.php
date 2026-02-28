@extends('layouts.app')

@section('content')
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <x-breadcrumb :links="['Daftar Registrasi' => route('user.participants'), 'Detail' => '#']" />

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">

                <div class="bg-gradient-to-r from-[#1D6594] to-[#154d73] p-6 sm:p-10 text-white relative overflow-hidden">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/5 rounded-full blur-2xl"></div>

                    <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-8">
                        <div class="text-center md:text-left space-y-2">
                            <span
                                class="inline-block px-3 py-1 bg-white/20 text-[10px] font-bold rounded-full uppercase tracking-widest border border-white/30 mb-2">
                                Data Registrasi Resmi
                            </span>
                            <h2 class="text-3xl font-black tracking-tight">{{ $data->registration_number }}</h2>
                            <p class="text-blue-100 font-medium">
                                {{ $data->competition->name }} — <span
                                    class="text-white">{{ $data->competition->category->name }}</span>
                            </p>
                            <div class="flex flex-wrap justify-center md:justify-start gap-3 mt-4">
                                <span class="px-3 py-1 bg-white/10 rounded-lg text-xs font-bold border border-white/20">
                                    Status: {{ strtoupper($data->status) }}
                                </span>
                                <span class="px-3 py-1 bg-white/10 rounded-lg text-xs font-bold border border-white/20">
                                    PIC: {{ $data->pic->name }}
                                </span>
                            </div>
                        </div>

                        <div
                            class="shrink-0 bg-white p-4 rounded-2xl shadow-2xl flex flex-col items-center gap-2 border-4 border-white/20">
                            <div id="qrcode" class="p-1 bg-white rounded-lg"></div>
                            <span class="text-[10px] font-bold text-gray-400 mt-1 uppercase tracking-tighter">Scan to
                                Check-In</span>
                        </div>
                    </div>
                </div>

                <div class="p-6 sm:p-10 bg-white space-y-10">

                    @if ($data->competition->name === 'Hadrah')
                        <div class="flex items-center gap-4 p-4 bg-amber-50 rounded-2xl border border-amber-100">
                            <div
                                class="w-12 h-12 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-amber-800 uppercase tracking-wide">Jumlah Peserta Tim</p>
                                <p class="text-lg font-black text-amber-900">{{ $data->total_participants }} Orang</p>
                            </div>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 gap-8">
                        @foreach ($data->participants as $i => $participant)
                            <div class="relative p-6 rounded-2xl border border-gray-100 bg-gray-50/50">
                                <div
                                    class="absolute -top-3 left-6 bg-[#E9AA14] text-white text-[10px] font-black px-4 py-1 rounded-full uppercase shadow-sm border-2 border-white">
                                    Data Peserta #{{ $i + 1 }}
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-12 gap-8 pt-2">
                                    <div class="md:col-span-3 flex flex-col items-center gap-3">
                                        <div
                                            class="w-32 h-32 rounded-2xl border-4 border-white shadow-md overflow-hidden bg-gray-200">
                                            @if ($participant->photo_url)
                                                <img src="{{ asset('storage/' . $participant->photo_url) }}"
                                                    class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                    <svg class="w-12 h-12" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="1.5"
                                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                        </path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <p class="text-center font-bold text-gray-800 text-sm leading-tight">
                                            {{ $participant->name }}</p>
                                    </div>

                                    <div class="md:col-span-9 grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-12">
                                        <div class="space-y-1">
                                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Nomor
                                                Induk (NIK)</p>
                                            <p class="text-sm font-bold text-gray-700">{{ $participant->nik ?? '-' }}</p>
                                        </div>
                                        <div class="space-y-1">
                                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Umur
                                            </p>
                                            <p class="text-sm font-bold text-gray-700">{{ $participant->age }} Tahun</p>
                                        </div>
                                        <div class="space-y-1">
                                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Tempat,
                                                Tgl Lahir</p>
                                            <p class="text-sm font-bold text-gray-700">
                                                {{ $participant->birth_place }},
                                                {{ \Carbon\Carbon::parse($participant->birth_date)->format('d F Y') }}
                                            </p>
                                        </div>
                                        <div class="space-y-1">
                                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Dokumen
                                                Akta</p>
                                            @if ($participant->certificate_url)
                                                <button type="button"
                                                    onclick="openPhotoModal('{{ asset('storage/' . $participant->certificate_url) }}', 'Akta Kelahiran - {{ $participant->name }}')"
                                                    class="text-xs font-bold text-[#1D6594] hover:underline flex items-center gap-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                        </path>
                                                    </svg>
                                                    Lihat Berkas
                                                </button>
                                            @else
                                                <p class="text-xs text-gray-400 italic">Tidak tersedia</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div
                        class="pt-10 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <a href="{{ route('user.participants') }}"
                            class="w-full sm:w-auto px-8 py-3 bg-gray-100 text-gray-600 font-bold rounded-xl hover:bg-gray-200 transition-colors text-center">
                            Kembali ke Daftar
                        </a>

                        <div class="flex gap-3 w-full sm:w-auto">
                            <button type="button" onclick="window.print()"
                                class="flex-1 sm:flex-none px-6 py-3 bg-white border border-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition-all flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                                    </path>
                                </svg>
                                Cetak
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="imagePreviewModal"
        class="fixed inset-0 z-[100] hidden bg-gray-900/80 backdrop-blur-sm flex items-center justify-center transition-opacity duration-300 opacity-0 p-4">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden w-full max-w-2xl transform scale-95 transition-transform duration-300"
            id="imagePreviewContent">
            <div class="flex justify-between items-center p-5 border-b border-gray-100 bg-gray-50">
                <h3 id="previewTitle" class="font-bold text-gray-800">Preview Dokumen</h3>
                <button type="button" onclick="closePhotoModal()"
                    class="text-gray-400 hover:text-rose-500 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="p-2 bg-gray-800 flex justify-center items-center overflow-hidden">
                <img id="previewImage" src="" class="max-w-full max-h-[70vh] object-contain shadow-lg rounded">
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

    <script>
        // Generate QR Code on Page Load
        document.addEventListener('DOMContentLoaded', function() {
            new QRCode(document.getElementById("qrcode"), {
                text: "{{ $data->registration_number }}",
                width: 120,
                height: 120,
                colorDark: "#1D6594",
                colorLight: "#ffffff",
                correctLevel: QRCode.CorrectLevel.H
            });
        });

        // Image Modal Logic
        function openPhotoModal(imageUrl, title) {
            const modal = document.getElementById('imagePreviewModal');
            const content = document.getElementById('imagePreviewContent');
            document.getElementById('previewImage').src = imageUrl;
            document.getElementById('previewTitle').textContent = title;
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                content.classList.remove('scale-95');
            }, 10);
        }

        function closePhotoModal() {
            const modal = document.getElementById('imagePreviewModal');
            const content = document.getElementById('imagePreviewContent');
            modal.classList.add('opacity-0');
            content.classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }
    </script>
@endpush
