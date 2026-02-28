@extends('layouts.app')

@section('content')
    <div class="py-8 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <x-breadcrumb :links="['Manajemen User' => route('admin.dashboard.user'), 'Edit Data User' => '#']" />

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gray-50 p-6 sm:px-8 border-b border-gray-100 flex justify-between items-center">
                <div>
                    <h3 class="text-xl font-extrabold text-gray-800">Edit Data User</h3>
                    <p class="text-sm text-gray-500">Perbarui informasi untuk akun: <span
                            class="font-bold">{{ $user->name }}</span></p>
                </div>
            </div>

            <form action="{{ route('admin.dashboard.user.update') }}" method="POST" class="p-6 sm:p-8 space-y-6">
                @csrf
                @method('PUT') <input type="hidden" name="id" value="{{ $user->id }}">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="sm:col-span-2">
                        <x-input-label for="name" :value="__('Nama Lengkap')" class="font-bold text-gray-700 mb-1.5 block" />
                        <x-text-input id="name" type="text" name="name" :value="old('name', $user->name)" required
                            class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-[#1D6594] focus:ring-[#1D6594] bg-gray-50 focus:bg-white transition-colors" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('Email')" class="font-bold text-gray-700 mb-1.5 block" />
                        <x-text-input id="email" type="email" name="email" :value="old('email', $user->email)" required
                            class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-[#1D6594] focus:ring-[#1D6594] bg-gray-50 focus:bg-white transition-colors" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="phone_number" :value="__('No. WhatsApp')" class="font-bold text-gray-700 mb-1.5 block" />
                        <x-text-input id="phone_number" type="text" name="phone_number" :value="old('phone_number', $user->phone_number)" required
                            class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-[#1D6594] focus:ring-[#1D6594] bg-gray-50 focus:bg-white transition-colors" />
                        <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="role" :value="__('Role/Akses')" class="font-bold text-gray-700 mb-1.5 block" />
                        <select name="role" id="role" required
                            class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-[#1D6594] focus:ring-[#1D6594] bg-gray-50 focus:bg-white transition-colors">
                            <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User (PIC
                                Lomba)</option>
                            <option value="khitan" {{ old('role', $user->role) == 'khitan' ? 'selected' : '' }}>Khitan
                                (Pendaftar Khitan)</option>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin
                            </option>
                        </select>
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="group_id" :value="__('Asal TPQ / Grup')" class="font-bold text-gray-700 mb-1.5 block" />
                        <select name="group_id" id="group_id" required
                            class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-[#1D6594] focus:ring-[#1D6594] bg-gray-50 focus:bg-white transition-colors">
                            @foreach ($groups as $group)
                                <option value="{{ $group->id }}"
                                    {{ old('group_id', $user->group_id) == $group->id ? 'selected' : '' }}>
                                    {{ $group->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('group_id')" class="mt-2" />
                    </div>
                </div>

                <div class="bg-amber-50 border border-amber-100 p-5 rounded-xl mt-6">
                    <p class="text-sm font-bold text-amber-800 mb-2">Ubah Password (Opsional)</p>
                    <p class="text-xs text-amber-700 mb-4">Biarkan kosong jika Anda tidak ingin merubah password user ini.
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="password" :value="__('Password Baru')" class="font-bold text-gray-700 mb-1.5 block" />
                            <x-text-input id="password" type="password" name="password" autocomplete="new-password"
                                class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-[#1D6594] focus:ring-[#1D6594] bg-white transition-colors"
                                placeholder="Ketik sandi baru..." />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')"
                                class="font-bold text-gray-700 mb-1.5 block" />
                            <x-text-input id="password_confirmation" type="password" name="password_confirmation"
                                class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-[#1D6594] focus:ring-[#1D6594] bg-white transition-colors"
                                placeholder="Ulangi sandi..." />
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-100 mt-6">
                    <a href="{{ route('admin.dashboard.user') }}"
                        class="px-6 py-3 text-gray-600 font-bold hover:bg-gray-100 rounded-xl transition-colors">Batal</a>
                    <button type="submit"
                        class="px-8 py-3 bg-amber-500 text-white font-bold rounded-xl shadow-md hover:shadow-lg hover:bg-amber-600 hover:-translate-y-0.5 transition-all">
                        Perbarui Data
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
