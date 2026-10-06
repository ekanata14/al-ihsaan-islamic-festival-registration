@extends('layouts.app')

@section('content')
    <div class="py-8 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        <x-breadcrumb :links="[
            'Konten Landing' => route('admin.dashboard.landing.content'),
            'Tambah ' . $schema['label'] => '#',
        ]" />

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gray-50 p-6 sm:px-8 border-b border-gray-100 flex items-center gap-3">
                <span class="w-11 h-11 rounded-xl bg-blue-50 text-[#1D6594] flex items-center justify-center">
                    <x-landing-icon :name="$schema['icon'] ?? 'document'" class="w-6 h-6" />
                </span>
                <div>
                    <h3 class="text-xl font-extrabold text-gray-800">Tambah Blok: {{ $schema['label'] }}</h3>
                    <p class="text-sm text-gray-500 mt-0.5">{{ $schema['description'] ?? '' }}</p>
                </div>
            </div>

            <form action="{{ route('admin.dashboard.landing.content.store') }}" method="POST"
                enctype="multipart/form-data" class="p-6 sm:p-8">
                @csrf
                <input type="hidden" name="type" value="{{ $type }}">

                <div class="mb-6">
                    <label class="font-bold text-gray-700 mb-2 block text-sm">Nama Blok (untuk admin)</label>
                    <input type="text" name="name" value="{{ old('name', $schema['label']) }}"
                        class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-[#1D6594] focus:ring-[#1D6594] bg-gray-50 focus:bg-white transition-colors text-sm">
                </div>

                <label class="inline-flex items-center gap-2 cursor-pointer mb-8">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                        class="rounded border-gray-300 text-[#1D6594] focus:ring-[#1D6594]">
                    <span class="text-sm font-medium text-gray-600">Tampilkan blok ini di halaman</span>
                </label>

                <div class="border-t border-gray-100 pt-8">
                    @include('admin.landing.content._fields', ['schema' => $schema, 'content' => $content, 'data' => null])
                </div>

                <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-100 mt-8">
                    <a href="{{ route('admin.dashboard.landing.content') }}"
                        class="px-6 py-3 text-gray-600 font-bold hover:bg-gray-100 rounded-xl transition-colors">Batal</a>
                    <button type="submit"
                        class="px-8 py-3 bg-[#1D6594] text-white font-bold rounded-xl shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all">
                        Simpan Blok
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
