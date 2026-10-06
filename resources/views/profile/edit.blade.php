@extends('layouts.app')

@section('content')
    @php
        $inputClass = 'block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-[#1D6594] focus:ring-[#1D6594] bg-gray-50 focus:bg-white transition-colors text-sm';
        $labelClass = 'font-bold text-gray-700 mb-2 block text-sm';
    @endphp

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <x-breadcrumb :links="['Pengaturan Akun' => '#']" />

            {{-- Kartu identitas --}}
            <div class="bg-gradient-to-r from-[#1D6594] to-[#154d73] rounded-2xl p-6 text-white shadow-lg flex items-center gap-4 relative overflow-hidden">
                <div class="absolute -right-6 -top-6 w-28 h-28 bg-white/5 rounded-full"></div>
                <div class="w-16 h-16 rounded-full bg-white/15 flex items-center justify-center text-2xl font-extrabold shrink-0">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div class="min-w-0 relative z-10">
                    <h2 class="text-xl font-extrabold truncate">{{ $user->name }}</h2>
                    <p class="text-blue-100 text-sm truncate">{{ $user->email }}</p>
                    <span class="inline-block mt-1 text-[11px] font-bold uppercase bg-white/15 rounded-full px-3 py-0.5">
                        {{ $user->role }}
                    </span>
                </div>
            </div>

            {{-- Informasi profil --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8">
                <div class="flex items-center gap-3 mb-6">
                    <span class="w-10 h-10 rounded-xl bg-blue-50 text-[#1D6594] flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </span>
                    <div>
                        <h3 class="text-lg font-extrabold text-gray-800">Informasi Profil</h3>
                        <p class="text-sm text-gray-500">Perbarui nama, email, dan nomor telepon akun Anda.</p>
                    </div>
                </div>

                <form method="post" action="{{ route('profile.update') }}" class="space-y-5">
                    @csrf
                    @method('patch')

                    <div>
                        <label for="name" class="{{ $labelClass }}">Nama Lengkap</label>
                        <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}"
                            class="{{ $inputClass }}" required autofocus autocomplete="name">
                        @error('name')<p class="text-rose-500 text-sm mt-2 font-medium">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="phone_number" class="{{ $labelClass }}">Nomor Telepon</label>
                        <input id="phone_number" name="phone_number" type="text"
                            value="{{ old('phone_number', $user->phone_number) }}" class="{{ $inputClass }}"
                            placeholder="08xxxxxxxxxx" autocomplete="tel">
                        @error('phone_number')<p class="text-rose-500 text-sm mt-2 font-medium">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="email" class="{{ $labelClass }}">Alamat Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}"
                            class="{{ $inputClass }}" required autocomplete="username">
                        @error('email')<p class="text-rose-500 text-sm mt-2 font-medium">{{ $message }}</p>@enderror
                    </div>

                    <div class="flex items-center gap-3 pt-2">
                        <button type="submit"
                            class="px-6 py-3 bg-[#1D6594] text-white font-bold rounded-xl shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all">
                            Simpan Perubahan
                        </button>
                        @if (session('status') === 'profile-updated')
                            <span class="text-sm font-bold text-emerald-600">Tersimpan.</span>
                        @endif
                    </div>
                </form>
            </div>

            {{-- Ubah kata sandi --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8">
                <div class="flex items-center gap-3 mb-6">
                    <span class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </span>
                    <div>
                        <h3 class="text-lg font-extrabold text-gray-800">Ubah Kata Sandi</h3>
                        <p class="text-sm text-gray-500">Gunakan kata sandi yang panjang dan acak agar akun tetap aman.</p>
                    </div>
                </div>

                <form method="post" action="{{ route('password.update') }}" class="space-y-5">
                    @csrf
                    @method('put')

                    <div>
                        <label for="current_password" class="{{ $labelClass }}">Kata Sandi Saat Ini</label>
                        <input id="current_password" name="current_password" type="password" class="{{ $inputClass }}"
                            autocomplete="current-password">
                        @error('current_password', 'updatePassword')
                            <p class="text-rose-500 text-sm mt-2 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="{{ $labelClass }}">Kata Sandi Baru</label>
                        <input id="password" name="password" type="password" class="{{ $inputClass }}"
                            autocomplete="new-password">
                        @error('password', 'updatePassword')
                            <p class="text-rose-500 text-sm mt-2 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="{{ $labelClass }}">Konfirmasi Kata Sandi Baru</label>
                        <input id="password_confirmation" name="password_confirmation" type="password"
                            class="{{ $inputClass }}" autocomplete="new-password">
                        @error('password_confirmation', 'updatePassword')
                            <p class="text-rose-500 text-sm mt-2 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-3 pt-2">
                        <button type="submit"
                            class="px-6 py-3 bg-amber-500 text-white font-bold rounded-xl shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all">
                            Ubah Kata Sandi
                        </button>
                        @if (session('status') === 'password-updated')
                            <span class="text-sm font-bold text-emerald-600">Kata sandi diperbarui.</span>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
