<x-guest-layout>
    <style>
        input[type="file"]::file-selector-button {
            background-color: #f3f4f6;
            color: #047857; /* Emerald-700 */
            border: 0;
            padding: 0.6rem 1.2rem;
            border-radius: 0.5rem;
            font-weight: 600;
            margin-right: 1rem;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
        }

        input[type="file"]::file-selector-button:hover {
            background-color: #e5e7eb;
            color: #065f46;
        }

        .custom-scrollbar::-webkit-scrollbar { width: 8px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f8fafc; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>

    <div class="fixed inset-0 z-50 flex min-h-screen bg-white">

        <div class="hidden lg:flex lg:w-5/12 xl:w-1/2 relative bg-emerald-800 items-center justify-center overflow-hidden">
            <div class="absolute inset-0">
                <img src="https://images.unsplash.com/photo-1519818178122-1d579241517a?q=80&w=2070&auto=format&fit=crop"
                    class="w-full h-full object-cover object-center opacity-30" alt="Islamic Festival">
                <div class="absolute inset-0 bg-gradient-to-t from-emerald-900 via-emerald-800/90 to-transparent opacity-90"></div>
            </div>

            <div class="relative z-10 p-12 text-center flex flex-col items-center">
                <img src="{{ asset('assets/images/logo_only.png') }}"
                    class="h-28 mb-8 drop-shadow-2xl hover:scale-110 transition-transform duration-500 brightness-0 invert"
                    alt="Logo Festival">
                <h2 class="text-4xl xl:text-5xl font-extrabold text-white mb-4 drop-shadow-md leading-tight">Pendaftaran <br>Khitan Massal</h2>
                <div class="w-20 h-1.5 bg-emerald-400 rounded-full mb-6"></div>
                <p class="text-lg text-emerald-100 max-w-md leading-relaxed">
                    Langkah 2: Lengkapi profil data diri anak yang akan dikhitan beserta unggahan berkas persyaratannya.
                </p>
            </div>
        </div>

        <div class="w-full lg:w-7/12 xl:w-1/2 flex items-start justify-center p-6 sm:p-10 lg:p-12 overflow-y-auto custom-scrollbar bg-gray-50/50">
            <div class="w-full max-w-2xl my-auto py-8">

                <div class="text-center mb-8 lg:hidden">
                    <img src="{{ asset('assets/images/logo.png') }}" class="h-20 mx-auto mb-4 object-contain" alt="Logo">
                </div>

                <div class="mb-8 text-center lg:text-left">
                    <span class="inline-block py-1 px-3 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold tracking-widest mb-3 uppercase">Langkah 2 dari 2</span>
                    <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Data Anak Sunat 👦</h2>
                    <p class="text-gray-500 text-sm">Harap pastikan identitas dan berkas anak sudah benar sebelum mendaftar.</p>
                </div>

                <form method="POST" action="{{ route('khitan.registration.person.store') }}" enctype="multipart/form-data" class="space-y-6 bg-white p-6 sm:p-8 rounded-2xl border border-gray-100 shadow-sm">
                    @csrf

                    <input type="hidden" name="role" value="khitan">

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="sm:col-span-2">
                            <x-input-label for="name" :value="__('Nama Lengkap Anak')" class="text-gray-700 font-bold mb-1.5 block" />
                            <x-text-input id="name"
                                class="block w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 transition-colors bg-gray-50 focus:bg-white"
                                type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Nama lengkap anak..." />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="birth_place" :value="__('Tempat Lahir')" class="text-gray-700 font-bold mb-1.5 block" />
                            <x-text-input id="birth_place"
                                class="block w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 transition-colors bg-gray-50 focus:bg-white"
                                type="text" name="birth_place" :value="old('birth_place')" required placeholder="Cth: Denpasar" />
                            <x-input-error :messages="$errors->get('birth_place')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <x-input-label for="birth_date" :value="__('Tgl Lahir')" class="text-gray-700 font-bold mb-1.5 block text-sm" />
                                <x-text-input id="birth_date"
                                    class="block w-full px-3 py-3 rounded-xl border border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 transition-colors text-sm bg-gray-50 focus:bg-white"
                                    type="date" name="birth_date" :value="old('birth_date')" required />
                                <x-input-error :messages="$errors->get('birth_date')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="age" :value="__('Umur (Thn)')" class="text-gray-700 font-bold mb-1.5 block text-sm" />
                                <x-text-input id="age"
                                    class="block w-full px-3 py-3 rounded-xl border border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 transition-colors text-sm bg-gray-50 focus:bg-white"
                                    type="number" name="age" :value="old('age')" required placeholder="Cth: 10" />
                                <x-input-error :messages="$errors->get('age')" class="mt-2" />
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <x-input-label for="nik" :value="__('Pekerjaan Orang Tua')" class="text-gray-700 font-bold mb-1.5 block" />
                            <x-text-input id="nik"
                                class="block w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 transition-colors bg-gray-50 focus:bg-white"
                                type="text" name="nik" :value="old('nik')" required placeholder="Cth: Wiraswasta" />
                            <x-input-error :messages="$errors->get('nik')" class="mt-2" />
                        </div>

                        <div class="sm:col-span-2">
                            <x-input-label for="domicile" :value="__('Alamat Domisili Lengkap')" class="text-gray-700 font-bold mb-1.5 block" />
                            <x-text-input id="domicile"
                                class="block w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 transition-colors bg-gray-50 focus:bg-white"
                                type="text" name="domicile" :value="old('domicile')" required placeholder="Jalan, RT/RW, Desa/Kelurahan..." />
                            <x-input-error :messages="$errors->get('domicile')" class="mt-2" />
                        </div>

                        <div class="sm:col-span-2 bg-emerald-50/50 p-4 rounded-xl border border-emerald-100">
                            <x-input-label for="is_sanur" :value="__('Apakah Berdomisili di Sanur?')" class="text-gray-800 font-bold mb-3 block" />
                            <div class="flex gap-8">
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input id="is_sanur_yes" type="radio" name="is_sanur" value="1" {{ old('is_sanur') == '1' ? 'checked' : '' }}
                                        class="w-5 h-5 text-emerald-600 border-gray-300 focus:ring-emerald-500 cursor-pointer">
                                    <span class="text-gray-700 font-medium group-hover:text-emerald-700 transition-colors">Ya, Warga Sanur</span>
                                </label>
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input id="is_sanur_no" type="radio" name="is_sanur" value="0" {{ old('is_sanur') == '0' ? 'checked' : '' }}
                                        class="w-5 h-5 text-emerald-600 border-gray-300 focus:ring-emerald-500 cursor-pointer">
                                    <span class="text-gray-700 font-medium group-hover:text-emerald-700 transition-colors">Bukan Warga Sanur</span>
                                </label>
                            </div>
                            <x-input-error :messages="$errors->get('is_sanur')" class="mt-2" />
                        </div>
                    </div>

                    <div class="space-y-5 pt-6 border-t border-gray-100 mt-2">
                        <div class="mb-2">
                            <h3 class="font-bold text-gray-800">Unggah Berkas Persyaratan</h3>
                            <p class="text-xs text-gray-500">Maks. 2MB per file (Format: JPG/PNG/JPEG)</p>
                        </div>

                        <div>
                            <x-input-label for="photo_url" :value="__('1. Foto Anak (Setengah Badan)')" class="text-gray-700 font-bold mb-1.5 block text-sm" />
                            <input id="photo_url" type="file" name="photo_url" accept="image/*" required
                                class="block w-full text-sm text-gray-600 border border-gray-300 rounded-xl cursor-pointer bg-gray-50 hover:bg-white transition-colors" />
                            <x-input-error :messages="$errors->get('photo_url')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="certificate_url" :value="__('2. Akta Kelahiran')" class="text-gray-700 font-bold mb-1.5 block text-sm" />
                            <input id="certificate_url" type="file" name="certificate_url" accept="image/*" required
                                class="block w-full text-sm text-gray-600 border border-gray-300 rounded-xl cursor-pointer bg-gray-50 hover:bg-white transition-colors" />
                            <x-input-error :messages="$errors->get('certificate_url')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="family_card_url" :value="__('3. Kartu Keluarga (KK)')" class="text-gray-700 font-bold mb-1.5 block text-sm" />
                            <input id="family_card_url" type="file" name="family_card_url" accept="image/*" required
                                class="block w-full text-sm text-gray-600 border border-gray-300 rounded-xl cursor-pointer bg-gray-50 hover:bg-white transition-colors" />
                            <x-input-error :messages="$errors->get('family_card_url')" class="mt-2" />
                        </div>
                    </div>

                    <div class="pt-6 mt-4 border-t border-gray-100 flex flex-col gap-4">
                        <button type="submit"
                            class="w-full flex justify-center py-4 px-4 border border-transparent rounded-xl shadow-lg text-lg font-bold text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all duration-300 hover:-translate-y-1">
                            Selesaikan Pendaftaran Khitan
                        </button>

                        <p class="text-center text-sm text-gray-500 mt-2">
                            Ingin mendaftarkan sesuatu yang lain?
                            <a class="font-bold text-[#1D6594] hover:underline transition-colors" href="{{ route('login') }}">
                                Kembali ke Beranda
                            </a>
                        </p>
                    </div>

                </form>
            </div>
        </div>

    </div>
</x-guest-layout>
