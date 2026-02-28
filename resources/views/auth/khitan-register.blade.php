<x-guest-layout>
    <style>
        .custom-scrollbar::-webkit-scrollbar {
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

    <div class="fixed inset-0 z-50 flex min-h-screen bg-white">

        <div
            class="hidden lg:flex lg:w-5/12 xl:w-1/2 relative bg-emerald-800 items-center justify-center overflow-hidden">
            <div class="absolute inset-0">
                <img src="https://images.unsplash.com/photo-1519818178122-1d579241517a?q=80&w=2070&auto=format&fit=crop"
                    class="w-full h-full object-cover object-center opacity-30" alt="Islamic Festival">
                <div
                    class="absolute inset-0 bg-gradient-to-t from-emerald-900 via-emerald-800/90 to-transparent opacity-90">
                </div>
            </div>

            <div class="relative z-10 p-12 text-center flex flex-col items-center">
                <img src="{{ asset('assets/images/logo_only.png') }}"
                    class="h-28 mb-8 drop-shadow-2xl hover:scale-110 transition-transform duration-500 brightness-0 invert"
                    alt="Logo Festival">
                <h2 class="text-4xl xl:text-5xl font-extrabold text-white mb-4 drop-shadow-md leading-tight">Pendaftaran
                    <br>Khitan Massal</h2>
                <div class="w-20 h-1.5 bg-emerald-400 rounded-full mb-6"></div>
                <p class="text-lg text-emerald-100 max-w-md leading-relaxed">
                    Langkah 1: Silakan buat akun Orang Tua / Wali terlebih dahulu sebelum mengisi data anak yang akan
                    dikhitan.
                </p>
            </div>
        </div>

        <div
            class="w-full lg:w-7/12 xl:w-1/2 flex items-start justify-center p-6 sm:p-10 lg:p-12 overflow-y-auto custom-scrollbar bg-gray-50/50">
            <div class="w-full max-w-xl my-auto py-8">

                <div class="text-center mb-8 lg:hidden">
                    <img src="{{ asset('assets/images/logo.png') }}" class="h-20 mx-auto mb-4 object-contain"
                        alt="Logo">
                </div>

                <div class="mb-10 text-center lg:text-left">
                    <span
                        class="inline-block py-1 px-3 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold tracking-widest mb-3 uppercase">Langkah
                        1 dari 2</span>
                    <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Data Orang Tua / Wali 📝</h2>
                    <p class="text-gray-500 text-sm">Buat akun untuk mengelola pendaftaran khitan anak Anda.</p>
                </div>

                <form method="POST" action="{{ route('register') }}"
                    class="space-y-6 bg-white p-6 sm:p-8 rounded-2xl border border-gray-100 shadow-sm">
                    @csrf

                    <input type="hidden" name="role" value="khitan">
                    <input type="hidden" id="group_id" name="group_id" value="">

                    <div>
                        <x-input-label for="name" :value="__('Nama Lengkap Orang Tua')" class="text-gray-700 font-bold mb-1.5 block" />
                        <x-text-input id="name"
                            class="block w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 transition-colors bg-gray-50 focus:bg-white"
                            type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                            placeholder="Masukkan nama Anda..." />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="email" :value="__('Email Aktif')"
                                class="text-gray-700 font-bold mb-1.5 block" />
                            <x-text-input id="email"
                                class="block w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 transition-colors bg-gray-50 focus:bg-white"
                                type="email" name="email" :value="old('email')" required autocomplete="username"
                                placeholder="email@contoh.com" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="phone_number" :value="__('No. WhatsApp')"
                                class="text-gray-700 font-bold mb-1.5 block" />
                            <x-text-input id="phone_number"
                                class="block w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 transition-colors bg-gray-50 focus:bg-white"
                                type="text" name="phone_number" :value="old('phone_number', '+62')" required
                                autocomplete="phone_number" />
                            <span class="text-gray-400 text-xs mt-1 block font-medium">Format: +628123...</span>
                            <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="password" :value="__('Buat Password')"
                                class="text-gray-700 font-bold mb-1.5 block" />
                            <x-text-input id="password"
                                class="block w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 transition-colors bg-gray-50 focus:bg-white"
                                type="password" name="password" required autocomplete="new-password"
                                placeholder="Minimal 8 karakter" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="password_confirmation" :value="__('Ulangi Password')"
                                class="text-gray-700 font-bold mb-1.5 block" />
                            <x-text-input id="password_confirmation"
                                class="block w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 transition-colors bg-gray-50 focus:bg-white"
                                type="password" name="password_confirmation" required autocomplete="new-password"
                                placeholder="Ulangi password" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>
                    </div>

                    <div class="pt-6 mt-4 border-t border-gray-100 flex flex-col gap-4">
                        <button type="submit"
                            class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-md text-base font-bold text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all duration-300 hover:-translate-y-1">
                            Daftar Akun & Lanjut ke Data Anak
                        </button>

                        <div class="flex flex-col sm:flex-row gap-3">
                            <a href="{{ route('register') }}"
                                class="w-full flex justify-center items-center py-3 border-2 border-gray-200 rounded-xl text-sm font-bold text-gray-600 hover:bg-gray-50 hover:border-gray-300 transition-all duration-300">
                                Ingin Daftar Lomba Saja?
                            </a>
                        </div>

                        <p class="text-center text-sm text-gray-500 mt-2">
                            Sudah memiliki akun?
                            <a class="font-bold text-emerald-600 hover:text-emerald-800 transition-colors"
                                href="{{ route('login') }}">
                                {{ __('Masuk di sini') }}
                            </a>
                        </p>
                    </div>
                </form>

            </div>
        </div>

    </div>
</x-guest-layout>
