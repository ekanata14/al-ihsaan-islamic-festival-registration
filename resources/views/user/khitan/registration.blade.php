@extends('layouts.app')

@section('content')
    <style>
        input[type="file"]::file-selector-button {
            background-color: #f3f4f6;
            color: #047857;
            /* Emerald-700 */
            border: 0;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-weight: 600;
            margin-right: 1rem;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
        }

        input[type="file"]::file-selector-button:hover {
            background-color: #e5e7eb;
        }
    </style>

    <section class="min-h-screen bg-gray-50 flex justify-center items-start pt-8 pb-16">
        <div class="container mx-auto px-4 max-w-3xl">

            <div class="mb-4">
                <a href="javascript:history.back()"
                    class="inline-flex items-center text-sm font-semibold text-gray-500 hover:text-emerald-700 transition-colors">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Batal & Kembali
                </a>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">

                <div class="bg-emerald-700 p-8 text-center text-white relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-32 h-32 bg-white opacity-10 rounded-full"></div>
                    <div class="absolute -left-4 -bottom-4 w-20 h-20 bg-emerald-400 opacity-20 rounded-full"></div>

                    <h3 class="text-3xl font-extrabold relative z-10 mb-2">Data Anak Sunat 👦</h3>
                    <p class="text-emerald-100 text-sm max-w-md mx-auto relative z-10">Lengkapi profil data diri anak yang
                        akan dikhitan beserta unggahan berkas persyaratannya.</p>
                </div>

                <form method="POST" action="{{ route('khitan.registration.person.store') }}" enctype="multipart/form-data"
                    class="p-6 sm:p-10 space-y-8">
                    @csrf
                    <input type="hidden" name="role" value="khitan">
                    <input type="hidden" id="group_id" name="group_id" value="0">

                    <div class="space-y-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                            <div class="sm:col-span-2">
                                <x-input-label for="name" :value="__('Nama Lengkap Anak')"
                                    class="text-gray-700 font-bold mb-1.5 block" />
                                <x-text-input id="name"
                                    class="block w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 transition-colors bg-gray-50 focus:bg-white"
                                    type="text" name="name" :value="old('name')" required autofocus
                                    placeholder="Masukkan nama lengkap anak..." />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="birth_place" :value="__('Tempat Lahir')"
                                    class="text-gray-700 font-bold mb-1.5 block" />
                                <x-text-input id="birth_place"
                                    class="block w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 transition-colors bg-gray-50 focus:bg-white"
                                    type="text" name="birth_place" :value="old('birth_place')" required
                                    placeholder="Cth: Denpasar" />
                                <x-input-error :messages="$errors->get('birth_place')" class="mt-2" />
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <x-input-label for="birth_date" :value="__('Tgl Lahir')"
                                        class="text-gray-700 font-bold mb-1.5 block text-sm" />
                                    <x-text-input id="birth_date"
                                        class="block w-full px-3 py-3 rounded-xl border border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 transition-colors text-sm bg-gray-50 focus:bg-white"
                                        type="date" name="birth_date" :value="old('birth_date')" required />
                                    <x-input-error :messages="$errors->get('birth_date')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="age" :value="__('Umur (Thn)')"
                                        class="text-gray-700 font-bold mb-1.5 block text-sm" />
                                    <x-text-input id="age"
                                        class="block w-full px-3 py-3 rounded-xl border border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 transition-colors text-sm bg-gray-50 focus:bg-white"
                                        type="number" name="age" :value="old('age')" required placeholder="Cth: 10" />
                                    <x-input-error :messages="$errors->get('age')" class="mt-2" />
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <x-input-label for="nik" :value="__('Pekerjaan Orang Tua')"
                                    class="text-gray-700 font-bold mb-1.5 block" />
                                <x-text-input id="nik"
                                    class="block w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 transition-colors bg-gray-50 focus:bg-white"
                                    type="text" name="nik" :value="old('nik')" required
                                    placeholder="Cth: Wiraswasta / Pegawai Swasta" />
                                <x-input-error :messages="$errors->get('nik')" class="mt-2" />
                            </div>

                            <div class="sm:col-span-2">
                                <x-input-label for="domicile" :value="__('Alamat Domisili Lengkap')"
                                    class="text-gray-700 font-bold mb-1.5 block" />
                                <x-text-input id="domicile"
                                    class="block w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 transition-colors bg-gray-50 focus:bg-white"
                                    type="text" name="domicile" :value="old('domicile')" required
                                    placeholder="Jalan, RT/RW, Desa/Kelurahan..." />
                                <x-input-error :messages="$errors->get('domicile')" class="mt-2" />
                            </div>

                            <div class="sm:col-span-2 bg-emerald-50 border border-emerald-100 p-5 rounded-xl">
                                <x-input-label for="is_sanur" :value="__('Apakah Berdomisili di Sanur?')"
                                    class="text-gray-800 font-bold mb-3 block" />
                                <div class="flex gap-8">
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input id="is_sanur_yes" type="radio" name="is_sanur" value="1"
                                            {{ old('is_sanur') == '1' ? 'checked' : '' }}
                                            class="w-5 h-5 text-emerald-600 border-gray-300 focus:ring-emerald-500 cursor-pointer">
                                        <span
                                            class="text-gray-700 font-medium group-hover:text-emerald-700 transition-colors">Ya,
                                            Warga Sanur</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input id="is_sanur_no" type="radio" name="is_sanur" value="0"
                                            {{ old('is_sanur') == '0' ? 'checked' : '' }}
                                            class="w-5 h-5 text-emerald-600 border-gray-300 focus:ring-emerald-500 cursor-pointer">
                                        <span
                                            class="text-gray-700 font-medium group-hover:text-emerald-700 transition-colors">Bukan
                                            Warga Sanur</span>
                                    </label>
                                </div>
                                <x-input-error :messages="$errors->get('is_sanur')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6 pt-8 border-t border-gray-100">
                        <div class="mb-4">
                            <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor"
                                    stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13">
                                    </path>
                                </svg>
                                Unggah Berkas Persyaratan
                            </h3>
                            <p class="text-sm text-gray-500 mt-1">Pastikan foto jelas terbaca. Maksimal 2MB per file
                                (JPG/PNG).</p>
                        </div>

                        <div class="space-y-5">
                            <div>
                                <x-input-label for="photo_url" :value="__('1. Foto Anak (Setengah Badan)')"
                                    class="text-gray-700 font-bold mb-1.5 block text-sm" />
                                <input id="photo_url" type="file" name="photo_url" accept="image/*" required
                                    class="block w-full text-sm text-gray-600 border border-gray-300 rounded-xl cursor-pointer bg-gray-50 hover:bg-white transition-colors" />
                                <x-input-error :messages="$errors->get('photo_url')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="certificate_url" :value="__('2. Akta Kelahiran')"
                                    class="text-gray-700 font-bold mb-1.5 block text-sm" />
                                <input id="certificate_url" type="file" name="certificate_url" accept="image/*"
                                    required
                                    class="block w-full text-sm text-gray-600 border border-gray-300 rounded-xl cursor-pointer bg-gray-50 hover:bg-white transition-colors" />
                                <x-input-error :messages="$errors->get('certificate_url')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="family_card_url" :value="__('3. Kartu Keluarga (KK)')"
                                    class="text-gray-700 font-bold mb-1.5 block text-sm" />
                                <input id="family_card_url" type="file" name="family_card_url" accept="image/*"
                                    required
                                    class="block w-full text-sm text-gray-600 border border-gray-300 rounded-xl cursor-pointer bg-gray-50 hover:bg-white transition-colors" />
                                <x-input-error :messages="$errors->get('family_card_url')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div class="pt-8 border-t border-gray-100">
                        <button type="submit"
                            class="w-full flex justify-center py-4 px-4 border border-transparent rounded-xl shadow-lg text-lg font-bold text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all duration-300 hover:-translate-y-1">
                            Selesaikan Pendaftaran Khitan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </section>
@endsection
