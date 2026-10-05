@extends('layouts.app')

@section('content')
    <div class="py-8 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <x-breadcrumb :links="[
            'Pendaftaran Khitan' => route('admin.dashboard.khitan-registration'),
            'Tambah Khitan' => '#',
        ]" />

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">

            <div class="bg-gradient-to-r from-[#1D6594] to-[#154d73] p-6 sm:px-8 text-white relative overflow-hidden">
                <div class="absolute -left-10 -bottom-10 w-32 h-32 bg-white/10 rounded-full"></div>
                <div class="relative z-10">
                    <span
                        class="inline-block px-3 py-1 bg-white/20 text-xs font-bold rounded-full mb-2 uppercase tracking-widest border border-white/30 shadow-inner">
                        Registrasi Khitan
                    </span>
                    <h3 class="text-2xl font-extrabold">Tambah Pendaftaran Khitan</h3>
                </div>
            </div>

            <form action="{{ route('admin.dashboard.khitan-registration.store') }}" method="POST"
                enctype="multipart/form-data" class="p-6 sm:p-8 space-y-8 bg-gray-50/50">
                @csrf

                <div>
                    <h4
                        class="text-sm font-extrabold text-gray-800 uppercase tracking-wider mb-4 border-b border-gray-200 pb-2">
                        Identitas Anak</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <x-input-label for="name" :value="__('Nama Lengkap Anak')" class="font-bold text-gray-700 mb-1.5 block" />
                            <x-text-input type="text" name="name"
                                class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-[#1D6594] transition-colors bg-white"
                                value="{{ old('name') }}" required />
                            @error('name')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-input-label for="age" :value="__('Umur (Tahun)')" class="font-bold text-gray-700 mb-1.5 block" />
                            <x-text-input type="number" name="age"
                                class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-[#1D6594] transition-colors bg-white"
                                value="{{ old('age') }}" required />
                            @error('age')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-input-label for="nik" :value="__('NIK Anak')" class="font-bold text-gray-700 mb-1.5 block" />
                            <x-text-input type="text" name="nik"
                                class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-[#1D6594] transition-colors bg-white"
                                value="{{ old('nik') }}" required />
                            @error('nik')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-input-label for="birth_place" :value="__('Tempat Lahir')"
                                class="font-bold text-gray-700 mb-1.5 block" />
                            <x-text-input type="text" name="birth_place"
                                class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-[#1D6594] transition-colors bg-white"
                                value="{{ old('birth_place') }}" required />
                            @error('birth_place')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-input-label for="birth_date" :value="__('Tanggal Lahir')"
                                class="font-bold text-gray-700 mb-1.5 block" />
                            <x-text-input type="date" name="birth_date"
                                class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-[#1D6594] transition-colors bg-white"
                                value="{{ old('birth_date') }}" required />
                            @error('birth_date')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-input-label for="domicile" :value="__('Domisili / Alamat')" class="font-bold text-gray-700 mb-1.5 block" />
                            <x-text-input type="text" name="domicile"
                                class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-[#1D6594] transition-colors bg-white"
                                value="{{ old('domicile') }}" required />
                            @error('domicile')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-input-label for="is_sanur" :value="__('Apakah Warga Sanur?')" class="font-bold text-gray-700 mb-1.5 block" />
                            <select name="is_sanur" id="is_sanur"
                                class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-[#1D6594] transition-colors bg-white"
                                required>
                                <option value="1" {{ old('is_sanur') == 1 ? 'selected' : '' }}>Ya, Warga Sanur</option>
                                <option value="0" {{ old('is_sanur') == 0 ? 'selected' : '' }}>Bukan Warga Sanur</option>
                            </select>
                            @error('is_sanur')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div>
                    <h4
                        class="text-sm font-extrabold text-gray-800 uppercase tracking-wider mb-4 border-b border-gray-200 pb-2">
                        Dokumen & Berkas</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <x-input-label for="photo_url" :value="__('Foto Anak')" class="font-bold text-gray-700 mb-1.5 block" />
                            <input type="file" name="photo_url" accept="image/*" required
                                class="block w-full text-sm text-gray-600 border border-gray-300 rounded-lg cursor-pointer bg-white" />
                            @error('photo_url')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-input-label for="certificate_url" :value="__('Akta Kelahiran')"
                                class="font-bold text-gray-700 mb-1.5 block" />
                            <input type="file" name="certificate_url" accept="image/*" required
                                class="block w-full text-sm text-gray-600 border border-gray-300 rounded-lg cursor-pointer bg-white" />
                            @error('certificate_url')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-input-label for="family_card_url" :value="__('Kartu Keluarga (Opsional)')"
                                class="font-bold text-gray-700 mb-1.5 block" />
                            <input type="file" name="family_card_url" accept="image/*"
                                class="block w-full text-sm text-gray-600 border border-gray-300 rounded-lg cursor-pointer bg-white" />
                            @error('family_card_url')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('admin.dashboard.khitan-registration') }}"
                        class="px-6 py-3.5 text-gray-600 font-bold hover:bg-white rounded-xl transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-8 py-3.5 bg-[#1D6594] text-white font-bold rounded-xl shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all">
                        Simpan Pendaftaran
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
