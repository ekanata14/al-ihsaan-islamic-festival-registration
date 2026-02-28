@extends('layouts.app')

@section('content')
    <div class="py-8 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        <x-breadcrumb :links="['Manajemen Grup' => route('admin.dashboard.group'), 'Edit Data' => '#']" />

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gray-50 p-6 sm:px-8 border-b border-gray-100">
                <h3 class="text-xl font-extrabold text-gray-800">Edit Data Grup / TPQ</h3>
                <p class="text-sm text-gray-500 mt-1">Lakukan perubahan pada nama instansi atau kontingen jika ada kesalahan ketik.</p>
            </div>

            <form action="{{ route('admin.dashboard.group.update', $data->id) }}" method="POST" class="p-6 sm:p-8">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{ $data->id }}">

                <div class="mb-6">
                    <x-input-label for="name" :value="__('Nama Grup / TPQ')" class="font-bold text-gray-700 mb-2 block" />
                    <x-text-input type="text" id="name" name="name"
                        class="block w-full px-4 py-3.5 rounded-xl border-gray-300 focus:border-amber-500 focus:ring-amber-500 bg-gray-50 focus:bg-white transition-colors"
                        value="{{ old('name', $data->name) }}" placeholder="Contoh: TPQ Al-Hidayah Denpasar" required autofocus />
                    @error('name')
                        <p class="text-rose-500 text-sm mt-2 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-100 mt-8">
                    <a href="{{ route('admin.dashboard.group') }}" class="px-6 py-3 text-gray-600 font-bold hover:bg-gray-100 rounded-xl transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="px-8 py-3 bg-amber-500 text-white font-bold rounded-xl shadow-md hover:shadow-lg hover:bg-amber-600 hover:-translate-y-0.5 transition-all">
                        Perbarui Data
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
