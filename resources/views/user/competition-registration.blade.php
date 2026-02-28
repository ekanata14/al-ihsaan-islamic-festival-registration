@extends('layouts.app')

@section('content')
    <style>
        input[type="file"]::file-selector-button {
            background-color: #f3f4f6;
            color: #1D6594;
            border: 0;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-weight: 600;
            margin-right: 1rem;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
        }
        input[type="file"]::file-selector-button:hover { background-color: #e5e7eb; }
    </style>

    <section class="min-h-screen bg-gray-50 flex justify-center items-start pt-8 pb-16">
        <div class="container mx-auto px-4 max-w-3xl">

            <div class="mb-4">
                <a href="{{ route('user.dashboard.competitions.detail', $data->id) }}" class="inline-flex items-center text-sm font-semibold text-gray-500 hover:text-[#1D6594] transition-colors">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path></svg>
                    Batal & Kembali
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                <div class="bg-[#1D6594] p-6 text-center text-white relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-white opacity-10 rounded-full"></div>
                    <div class="absolute -left-4 -bottom-4 w-16 h-16 bg-[#E9AA14] opacity-20 rounded-full"></div>

                    <h2 class="text-xs font-bold tracking-widest uppercase mb-1 opacity-80">Formulir Pendaftaran</h2>
                    <h3 class="text-2xl sm:text-3xl font-extrabold relative z-10">{{ $data->name }}</h3>
                    <span class="inline-block mt-2 px-3 py-1 bg-white text-[#1D6594] text-xs font-bold rounded-full shadow-sm relative z-10">
                        {{ $data->category->name }}
                    </span>
                </div>

                <form action="{{ route('user.dashboard.competitions.registration.store') }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-6">
                    @csrf
                    <input type="hidden" name="competition_id" value="{{ $data->id }}">

                    @php
                        $participantCount = 1;
                        // Set participant count
                        if ($data->name === 'Cerdas Cermat') {
                            $participantCount = 3;
                        } elseif ($data->name == 'Hadrah') {
                            $participantCount = 1;
                        }
                    @endphp

                    @if ($data->name === 'Hadrah')
                        <div class="bg-blue-50 border border-blue-100 p-5 rounded-xl">
                            <x-input-label for="total_participants" :value="__('Total Anggota Grup/Tim')" class="text-gray-800 font-bold mb-1.5 block" />
                            <x-text-input type="number" name="total_participants" class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-[#1D6594] focus:ring-[#1D6594] transition-colors bg-white" placeholder="Masukkan jumlah peserta dalam grup" required />
                            <p class="text-xs text-blue-600 mt-2">*Ketikkan total anggota yang akan ikut tampil (Cth: 10).</p>
                            @error("total_participants") <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                    @else
                        <input type="hidden" name="total_participants" value="{{ $data->name === 'Cerdas Cermat' ? 3 : 1 }}">
                    @endif

                    <div id="participants-container" class="space-y-8">
                        @for ($i = 0; $i < $participantCount; $i++)

                            <div class="bg-white border border-gray-200 rounded-xl p-5 relative shadow-sm hover:shadow-md transition-shadow">
                                <div class="absolute -top-3 left-4 bg-[#E9AA14] text-white text-xs font-bold px-3 py-1 rounded-full shadow-sm">
                                    Peserta {{ $i + 1 }}
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mt-2">

                                    <div class="sm:col-span-2">
                                        <x-input-label for="participants[{{ $i }}][name]" :value="__('Nama Lengkap')" class="text-gray-700 font-semibold mb-1 block" />
                                        <x-text-input type="text" name="participants[{{ $i }}][name]" class="block w-full px-4 py-2.5 rounded-xl border-gray-300 focus:border-[#1D6594] focus:ring-[#1D6594] transition-colors bg-gray-50 focus:bg-white" placeholder="Nama lengkap peserta..." required />
                                        @error("participants.{$i}.name") <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                                    </div>

                                    <div>
                                        <x-input-label for="participants[{{ $i }}][age]" :value="__('Umur (Tahun)')" class="text-gray-700 font-semibold mb-1 block" />
                                        <x-text-input type="number" name="participants[{{ $i }}][age]" class="block w-full px-4 py-2.5 rounded-xl border-gray-300 focus:border-[#1D6594] focus:ring-[#1D6594] transition-colors bg-gray-50 focus:bg-white" placeholder="Cth: 12" required />
                                        @error("participants.{$i}.age") <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                                    </div>

                                    <div>
                                        <x-input-label for="participants[{{ $i }}][nik]" :value="__('NIK Peserta')" class="text-gray-700 font-semibold mb-1 block" />
                                        <x-text-input type="number" name="participants[{{ $i }}][nik]" class="block w-full px-4 py-2.5 rounded-xl border-gray-300 focus:border-[#1D6594] focus:ring-[#1D6594] transition-colors bg-gray-50 focus:bg-white" placeholder="16 digit NIK..." required />
                                        @error("participants.{$i}.nik") <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                                    </div>

                                    <div>
                                        <x-input-label for="participants[{{ $i }}][birth_place]" :value="__('Tempat Lahir')" class="text-gray-700 font-semibold mb-1 block" />
                                        <x-text-input type="text" name="participants[{{ $i }}][birth_place]" class="block w-full px-4 py-2.5 rounded-xl border-gray-300 focus:border-[#1D6594] focus:ring-[#1D6594] transition-colors bg-gray-50 focus:bg-white" placeholder="Kota kelahiran..." required />
                                        @error("participants.{$i}.birth_place") <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                                    </div>

                                    <div>
                                        <x-input-label for="participants[{{ $i }}][birth_date]" :value="__('Tanggal Lahir')" class="text-gray-700 font-semibold mb-1 block" />
                                        <x-text-input type="date" name="participants[{{ $i }}][birth_date]" class="block w-full px-4 py-2.5 rounded-xl border-gray-300 focus:border-[#1D6594] focus:ring-[#1D6594] transition-colors bg-gray-50 focus:bg-white text-sm" required />
                                        @error("participants.{$i}.birth_date") <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                                    </div>

                                    <div class="sm:col-span-2 pt-2 border-t border-gray-100 mt-2">
                                        <x-input-label for="participants[{{ $i }}][photo_url]" :value="__('Foto Peserta')" class="text-gray-700 font-semibold mb-1 block" />
                                        <input type="file" name="participants[{{ $i }}][photo_url]" class="block w-full text-sm text-gray-500 border border-gray-300 rounded-xl cursor-pointer bg-gray-50" accept="image/*" required>
                                        <p class="text-gray-400 text-xs mt-1">*Maks. ukuran 2 MB</p>
                                        @error("participants.{$i}.photo_url") <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                                    </div>

                                    <div class="sm:col-span-2">
                                        <x-input-label for="participants[{{ $i }}][certificate_url]" :value="__('Akta Kelahiran / KTP / KTA')" class="text-gray-700 font-semibold mb-1 block" />
                                        <input type="file" name="participants[{{ $i }}][certificate_url]" class="block w-full text-sm text-gray-500 border border-gray-300 rounded-xl cursor-pointer bg-gray-50" accept="image/*,application/pdf" required>
                                        <p class="text-gray-400 text-xs mt-1">*Maks. ukuran 2 MB</p>
                                        @error("participants.{$i}.certificate_url") <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                                    </div>

                                </div>
                            </div>
                        @endfor
                    </div>

                    <div class="pt-6 border-t border-gray-100">
                        <button type="button" id="submit-button" class="w-full flex justify-center items-center gap-2 py-3.5 px-4 border border-transparent rounded-xl shadow-md text-lg font-bold text-white bg-[#1D6594] hover:bg-[#154d73] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1D6594] transition-all duration-300 hover:-translate-y-1">
                            Daftarkan Peserta Sekarang
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </section>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('submit-button').addEventListener('click', function() {
                    const form = this.closest('form');

                    // Basic HTML5 validation check before triggering SweetAlert
                    if (!form.checkValidity()) {
                        form.reportValidity(); // This will show the browser's default validation tooltips
                        return;
                    }

                    Swal.fire({
                        title: 'Konfirmasi Pendaftaran',
                        text: "Pastikan semua data dan berkas yang diunggah sudah benar. Lanjutkan mendaftar?",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#1D6594', // Warna utama biru
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Daftar Gasss! 🚀',
                        cancelButtonText: 'Batal',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Show loading state on button
                            const btn = document.getElementById('submit-button');
                            btn.innerHTML = '<svg class="animate-spin h-5 w-5 mr-3 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg> Memproses Data...';
                            btn.disabled = true;
                            btn.classList.add('cursor-wait', 'opacity-80');

                            form.submit();
                        }
                    });
                });
            });
        </script>
    @endpush

@endsection
