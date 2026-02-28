@extends('layouts.app')

@section('content')
    <div class="py-8 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <x-breadcrumb :links="['Manajemen User' => route('admin.dashboard.user'), 'Tambah User Baru' => '#']" />

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gray-50 p-6 sm:px-8 border-b border-gray-100">
                <h3 class="text-xl font-extrabold text-gray-800">Tambah Data User</h3>
                <p class="text-sm text-gray-500">Isi formulir di bawah untuk menambahkan pengguna baru.</p>
            </div>

            <form action="{{ route('admin.dashboard.user.store') }}" method="POST" class="p-6 sm:p-8 space-y-6">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="sm:col-span-2">
                        <x-input-label for="name" :value="__('Nama Lengkap')" class="font-bold text-gray-700 mb-1.5 block" />
                        <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus
                            class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-[#1D6594] focus:ring-[#1D6594] bg-gray-50 focus:bg-white transition-colors"
                            placeholder="Masukkan nama user..." />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('Email')" class="font-bold text-gray-700 mb-1.5 block" />
                        <x-text-input id="email" type="email" name="email" :value="old('email')" required
                            class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-[#1D6594] focus:ring-[#1D6594] bg-gray-50 focus:bg-white transition-colors"
                            placeholder="email@contoh.com" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="phone_number" :value="__('No. WhatsApp')" class="font-bold text-gray-700 mb-1.5 block" />
                        <x-text-input id="phone_number" type="text" name="phone_number" :value="old('phone_number')" required
                            class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-[#1D6594] focus:ring-[#1D6594] bg-gray-50 focus:bg-white transition-colors"
                            placeholder="+628123..." />
                        <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="role" :value="__('Role/Akses')" class="font-bold text-gray-700 mb-1.5 block" />
                        <select name="role" id="role" required
                            class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-[#1D6594] focus:ring-[#1D6594] bg-gray-50 focus:bg-white transition-colors">
                            <option value="">-- Pilih Role --</option>
                            <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User (PIC Lomba)</option>
                            <option value="khitan" {{ old('role') == 'khitan' ? 'selected' : '' }}>Khitan (Pendaftar Khitan)
                            </option>
                        </select>
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="group_id" :value="__('Asal TPQ / Grup')" class="font-bold text-gray-700 mb-1.5 block" />
                        <select name="group_id" id="group_id" required
                            class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-[#1D6594] focus:ring-[#1D6594] bg-gray-50 focus:bg-white transition-colors">
                            <option value="">-- Pilih TPQ/Grup --</option>
                            @foreach ($groups as $group)
                                <option value="{{ $group->id }}" {{ old('group_id') == $group->id ? 'selected' : '' }}>
                                    {{ $group->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('group_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="password" :value="__('Password')" class="font-bold text-gray-700 mb-1.5 block" />
                        <x-text-input id="password" type="password" name="password" required autocomplete="new-password"
                            class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-[#1D6594] focus:ring-[#1D6594] bg-gray-50 focus:bg-white transition-colors"
                            placeholder="Minimal 8 karakter" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="password_confirmation" :value="__('Ulangi Password')"
                            class="font-bold text-gray-700 mb-1.5 block" />
                        <x-text-input id="password_confirmation" type="password" name="password_confirmation" required
                            class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-[#1D6594] focus:ring-[#1D6594] bg-gray-50 focus:bg-white transition-colors"
                            placeholder="Ulangi password" />
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-100 mt-8">
                    <a href="{{ route('admin.dashboard.user') }}"
                        class="px-6 py-3 text-gray-600 font-bold hover:bg-gray-100 rounded-xl transition-colors">Batal</a>
                    <button type="submit"
                        class="px-8 py-3 bg-[#1D6594] text-white font-bold rounded-xl shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all">
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
