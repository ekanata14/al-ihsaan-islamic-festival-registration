<x-guest-layout>
    <div class="fixed inset-0 z-50 flex min-h-screen bg-white">

        <div class="hidden lg:flex lg:w-5/12 xl:w-1/2 relative bg-[#1D6594] items-center justify-center overflow-hidden">
            <div class="absolute inset-0">
                <img src="https://images.unsplash.com/photo-1519818178122-1d579241517a?q=80&w=2070&auto=format&fit=crop"
                    class="w-full h-full object-cover object-center opacity-30" alt="Islamic Festival">
                <div class="absolute inset-0 bg-gradient-to-t from-[#1D6594] via-[#1D6594]/80 to-transparent opacity-90">
                </div>
            </div>

            <div class="relative z-10 p-12 text-center flex flex-col items-center">
                <img src="{{ asset('assets/images/logo_only.png') }}"
                    class="h-28 mb-8 drop-shadow-2xl hover:scale-110 transition-transform duration-500"
                    alt="Logo Festival">
                <h2 class="text-4xl font-extrabold text-white mb-4 drop-shadow-md">Pendaftaran Akun Lomba</h2>
                <p class="text-lg text-blue-100 max-w-md leading-relaxed">
                    Buat akun sebagai PIC/Wali TPQ untuk mulai mendaftarkan santri-santri terbaik Anda di ajang Al
                    Ihsaan Islamic Festival.
                </p>
            </div>
        </div>

        <div
            class="w-full lg:w-7/12 xl:w-1/2 flex items-start justify-center p-6 sm:p-10 lg:p-12 overflow-y-auto custom-scrollbar">
            <div class="w-full max-w-lg my-auto py-8">

                <div class="text-center mb-6 lg:hidden">
                    <img src="{{ asset('assets/images/logo.png') }}" class="h-20 mx-auto mb-4 object-contain"
                        alt="Logo">
                </div>

                <div class="mb-8 text-center lg:text-left">
                    <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Buat Akun Baru 📝</h2>
                    <p class="text-gray-500 text-sm">Lengkapi data diri Anda di bawah ini dengan benar.</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <div>
                        <x-input-label for="name" :value="__('Nama Lengkap (PIC/Wali)')"
                            class="text-gray-700 font-semibold mb-1 block" />
                        <x-text-input id="name"
                            class="block w-full px-4 py-3 rounded-xl border border-gray-300 shadow-sm focus:border-[#1D6594] focus:ring-[#1D6594] transition-colors"
                            type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                            placeholder="Masukkan nama lengkap Anda" />
                        <x-input-error :messages="$errors->get('name')" class="mt-1" />
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('Email Aktif')"
                            class="text-gray-700 font-semibold mb-1 block" />
                        <x-text-input id="email"
                            class="block w-full px-4 py-3 rounded-xl border border-gray-300 shadow-sm focus:border-[#1D6594] focus:ring-[#1D6594] transition-colors"
                            type="email" name="email" :value="old('email')" required autocomplete="username"
                            placeholder="contoh@email.com" />
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    <div>
                        <x-input-label for="phone_number" :value="__('No. WhatsApp')"
                            class="text-gray-700 font-semibold mb-1 block" />
                        <x-text-input id="phone_number"
                            class="block w-full px-4 py-3 rounded-xl border border-gray-300 shadow-sm focus:border-[#1D6594] focus:ring-[#1D6594] transition-colors"
                            type="text" name="phone_number" :value="old('phone_number', '+62')" required autocomplete="phone_number" />
                        <span class="text-gray-500 text-xs mt-1 block">💡 Gunakan format internasional: <span
                                class="font-bold text-gray-700">+628123...</span></span>
                        <x-input-error :messages="$errors->get('phone_number')" class="mt-1" />
                    </div>

                    <div class="relative">
                        <x-input-label for="group" :value="__('Asal TPQ / Kontingen')"
                            class="text-gray-700 font-semibold mb-1 block" />
                        <x-text-input id="group"
                            class="block w-full px-4 py-3 rounded-xl border border-gray-300 shadow-sm focus:border-[#1D6594] focus:ring-[#1D6594] transition-colors bg-white"
                            type="text" name="group" :value="old('group')" required autocomplete="off"
                            placeholder="Pilih atau ketik nama TPQ" />

                        <x-input-error :messages="$errors->get('group')" class="mt-1" />
                        <span class="text-gray-500 text-xs mt-1 block">💡 Jika nama TPQ tidak ada dalam daftar, sistem
                            akan menambahkannya otomatis.</span>

                        <ul id="group-suggestions"
                            class="absolute z-20 bg-white border border-gray-200 mt-1 rounded-xl shadow-lg hidden w-full max-h-48 overflow-y-auto">
                        </ul>
                    </div>

                    <input type="hidden" id="group_id" name="group_id" />

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <x-input-label for="password" :value="__('Password')"
                                class="text-gray-700 font-semibold mb-1 block" />
                            <x-text-input id="password"
                                class="block w-full px-4 py-3 rounded-xl border border-gray-300 shadow-sm focus:border-[#1D6594] focus:ring-[#1D6594] transition-colors"
                                type="password" name="password" required autocomplete="new-password"
                                placeholder="Minimal 8 karakter" />
                            <x-input-error :messages="$errors->get('password')" class="mt-1" />
                        </div>

                        <div>
                            <x-input-label for="password_confirmation" :value="__('Ulangi Password')"
                                class="text-gray-700 font-semibold mb-1 block" />
                            <x-text-input id="password_confirmation"
                                class="block w-full px-4 py-3 rounded-xl border border-gray-300 shadow-sm focus:border-[#1D6594] focus:ring-[#1D6594] transition-colors"
                                type="password" name="password_confirmation" required autocomplete="new-password"
                                placeholder="Ulangi password" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100">
                        <button type="submit"
                            class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-md text-base font-bold text-white bg-[#1D6594] hover:bg-[#154d73] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1D6594] transition-all duration-300 hover:-translate-y-1 mb-4">
                            Buat Akun Sekarang
                        </button>

                        <a href="{{ route('khitan.registration') }}"
                            class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-emerald-500 hover:bg-emerald-600 transition-all duration-300 mb-6">
                            Ingin Daftar Khitan Saja? Klik di Sini
                        </a>

                        <p class="text-center text-sm text-gray-600">
                            Sudah memiliki akun?
                            <a href="{{ route('login') }}"
                                class="font-bold text-[#1D6594] hover:text-[#E9AA14] transition-colors">
                                Masuk di sini
                            </a>
                        </p>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const groupInput = document.getElementById('group');
            const suggestionsList = document.getElementById('group-suggestions');
            const groupIdInput = document.getElementById('group_id');

            // Saat input diklik
            groupInput.addEventListener('click', async function() {
                try {
                    const response = await fetch(`{{ route('group.getAllGroups') }}`);
                    const data = await response.json();

                    suggestionsList.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(group => {
                            const listItem = document.createElement('li');
                            listItem.textContent = group.name;
                            listItem.className =
                                'px-4 py-3 cursor-pointer text-gray-700 hover:bg-blue-50 hover:text-[#1D6594] border-b border-gray-50 last:border-0 transition-colors';

                            listItem.addEventListener('click', function() {
                                groupInput.value = group.name;
                                groupIdInput.value = group.id;
                                suggestionsList.classList.add('hidden');
                            });
                            suggestionsList.appendChild(listItem);
                        });
                        suggestionsList.classList.remove('hidden');
                    } else {
                        suggestionsList.classList.add('hidden');
                    }
                } catch (error) {
                    console.error('Error fetching group suggestions:', error);
                }
            });

            // Tutup dropdown saat klik di luar
            document.addEventListener('click', function(event) {
                if (!suggestionsList.contains(event.target) && event.target !== groupInput) {
                    suggestionsList.classList.add('hidden');
                }
            });

            // Saring dropdown berdasarkan ketikan (Fitur Tambahan Opsional untuk UI lebih baik)
            groupInput.addEventListener('input', function() {
                const filterText = this.value.toLowerCase();
                const listItems = suggestionsList.querySelectorAll('li');
                let hasVisibleItem = false;

                listItems.forEach(item => {
                    if (item.textContent.toLowerCase().includes(filterText)) {
                        item.style.display = 'block';
                        hasVisibleItem = true;
                    } else {
                        item.style.display = 'none';
                    }
                });

                if (filterText.length > 0 && hasVisibleItem) {
                    suggestionsList.classList.remove('hidden');
                }
            });
        });
    </script>
</x-guest-layout>
