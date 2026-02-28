<x-guest-layout>
    <div class="fixed inset-0 z-50 flex min-h-screen bg-white">

        <div class="hidden lg:flex lg:w-1/2 relative bg-[#1D6594] items-center justify-center overflow-hidden">
            <div class="absolute inset-0">
                <img src="https://images.unsplash.com/photo-1519818178122-1d579241517a?q=80&w=2070&auto=format&fit=crop"
                    class="w-full h-full object-cover object-center opacity-30" alt="Islamic Festival">
                <div class="absolute inset-0 bg-gradient-to-t from-[#1D6594] via-[#1D6594]/80 to-transparent opacity-90">
                </div>
            </div>

            <div class="relative z-10 p-12 text-center flex flex-col items-center">
                <img src="{{ asset('assets/images/logo_only.png') }}"
                    class="h-32 mb-8 drop-shadow-2xl hover:scale-110 transition-transform duration-500"
                    alt="Logo Festival">
                <h2 class="text-4xl font-extrabold text-white mb-4 drop-shadow-md">Al Ihsaan Islamic Festival</h2>
                <p class="text-lg text-blue-100 max-w-md leading-relaxed">
                    Merajut Ukhuwah, Menggapai Berkah. Mari bersama membangun generasi muda yang berprestasi dan
                    berakhlak mulia.
                </p>
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 overflow-y-auto">
            <div class="w-full max-w-md">

                <div class="text-center mb-8 lg:hidden">
                    <img src="{{ asset('assets/images/logo.png') }}" class="h-20 mx-auto mb-4 object-contain"
                        alt="Logo">
                </div>

                <div class="mb-8 text-center lg:text-left">
                    <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Selamat Datang! 👋</h2>
                    <p class="text-gray-500">Silakan masuk menggunakan akun yang telah terdaftar.</p>
                </div>

                <x-auth-session-status class="mb-4 p-4 bg-green-50 text-green-700 rounded-xl" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="email" :value="__('Email Address')"
                            class="text-gray-700 font-semibold mb-1 block" />
                        <x-text-input id="email"
                            class="block w-full px-4 py-3 rounded-xl border border-gray-300 shadow-sm focus:border-[#1D6594] focus:ring-[#1D6594] transition-colors"
                            type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                            placeholder="Masukkan email Anda" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-semibold block" />
                            @if (Route::has('password.request'))
                                <a class="text-sm font-bold text-[#1D6594] hover:text-[#E9AA14] transition-colors"
                                    href="{{ route('password.request') }}">
                                    Lupa Password?
                                </a>
                            @endif
                        </div>
                        <x-text-input id="password"
                            class="block w-full px-4 py-3 rounded-xl border border-gray-300 shadow-sm focus:border-[#1D6594] focus:ring-[#1D6594] transition-colors"
                            type="password" name="password" required autocomplete="current-password"
                            placeholder="••••••••" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <button type="submit"
                        class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-md text-base font-bold text-white bg-[#1D6594] hover:bg-[#154d73] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1D6594] transition-all duration-300 hover:-translate-y-1">
                        Masuk Dashboard
                    </button>

                    <div class="relative flex items-center py-2">
                        <div class="flex-grow border-t border-gray-200"></div>
                        <span class="flex-shrink-0 mx-4 text-gray-400 text-sm font-medium">Atau pendaftaran baru</span>
                        <div class="flex-grow border-t border-gray-200"></div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <a href="{{ route('register') }}"
                            class="w-full flex justify-center items-center py-3 px-4 border-2 border-[#1D6594] rounded-xl shadow-sm text-sm font-bold text-[#1D6594] bg-white hover:bg-[#f0f7fb] hover:-translate-y-0.5 transition-all duration-300">
                            Daftar Lomba
                        </a>
                        <a href="{{ route('khitan.registration') }}"
                            class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-emerald-500 hover:bg-emerald-600 hover:-translate-y-0.5 transition-all duration-300">
                            Daftar Khitan
                        </a>
                    </div>
                </form>

            </div>
        </div>

    </div>
</x-guest-layout>
