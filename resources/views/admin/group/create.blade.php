@extends('layouts.app')

@section('content')
    <div class="py-8 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        <x-breadcrumb :links="['Manajemen Grup' => route('admin.dashboard.group'), 'Tambah Baru' => '#']" />

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gray-50 p-6 sm:px-8 border-b border-gray-100">
                <h3 class="text-xl font-extrabold text-gray-800">Tambah Grup / TPQ Baru</h3>
                <p class="text-sm text-gray-500 mt-1">Tambahkan nama instansi, kontingen, atau TPQ peserta ke dalam sistem.
                </p>
            </div>

            <form action="{{ route('admin.dashboard.group.store') }}" method="POST" class="p-6 sm:p-8">
                @csrf

                <div class="mb-6">
                    <x-input-label for="name" :value="__('Nama Grup / TPQ')" class="font-bold text-gray-700 mb-2 block" />
                    <x-text-input type="text" id="name" name="name"
                        class="block w-full px-4 py-3.5 rounded-xl border-gray-300 focus:border-[#1D6594] focus:ring-[#1D6594] bg-gray-50 focus:bg-white transition-colors"
                        placeholder="Contoh: TPQ Al-Hidayah Denpasar" value="{{ old('name') }}" required autofocus />
                    @error('name')
                        <p class="text-rose-500 text-sm mt-2 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-100 mt-8">
                    <a href="{{ route('admin.dashboard.group') }}"
                        class="px-6 py-3 text-gray-600 font-bold hover:bg-gray-100 rounded-xl transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-8 py-3 bg-[#1D6594] text-white font-bold rounded-xl shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all">
                        Simpan Grup
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
