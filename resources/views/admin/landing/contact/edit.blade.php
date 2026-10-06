@extends('layouts.app')

@section('content')
    @php $inputClass = 'block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-[#1D6594] focus:ring-[#1D6594] bg-gray-50 focus:bg-white transition-colors text-sm'; @endphp

    <div class="py-8 max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

        <x-breadcrumb :links="[
            'Kontak Person' => route('admin.dashboard.landing.contact'),
            'Edit' => '#',
        ]" />

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gray-50 p-6 sm:px-8 border-b border-gray-100">
                <h3 class="text-xl font-extrabold text-gray-800">Edit Kontak Person</h3>
                <p class="text-sm text-gray-500 mt-1">Perbarui data narahubung.</p>
            </div>

            <form action="{{ route('admin.dashboard.landing.contact.update') }}" method="POST" class="p-6 sm:p-8">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{ $data->id }}">

                <div class="mb-6">
                    <label class="font-bold text-gray-700 mb-2 block text-sm">Nama</label>
                    <input type="text" name="name" value="{{ old('name', $data->name) }}" class="{{ $inputClass }}" required autofocus>
                    @error('name')<p class="text-rose-500 text-sm mt-2 font-medium">{{ $message }}</p>@enderror
                </div>

                <div class="mb-6">
                    <label class="font-bold text-gray-700 mb-2 block text-sm">Label (opsional)</label>
                    <input type="text" name="label" value="{{ old('label', $data->label) }}" class="{{ $inputClass }}">
                    @error('label')<p class="text-rose-500 text-sm mt-2 font-medium">{{ $message }}</p>@enderror
                </div>

                <div class="mb-6">
                    <label class="font-bold text-gray-700 mb-2 block text-sm">Nomor WhatsApp</label>
                    <input type="text" name="whatsapp" value="{{ old('whatsapp', $data->whatsapp) }}" class="{{ $inputClass }}" required>
                    @error('whatsapp')<p class="text-rose-500 text-sm mt-2 font-medium">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="font-bold text-gray-700 mb-2 block text-sm">Urutan</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', $data->sort_order) }}" min="0" class="{{ $inputClass }}">
                    </div>
                    <div class="flex items-end pb-3">
                        <label class="inline-flex items-center gap-2 cursor-pointer">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $data->is_active) ? 'checked' : '' }}
                                class="rounded border-gray-300 text-[#1D6594] focus:ring-[#1D6594]">
                            <span class="text-sm font-medium text-gray-600">Aktif</span>
                        </label>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-100 mt-8">
                    <a href="{{ route('admin.dashboard.landing.contact') }}"
                        class="px-6 py-3 text-gray-600 font-bold hover:bg-gray-100 rounded-xl transition-colors">Batal</a>
                    <button type="submit"
                        class="px-8 py-3 bg-amber-500 text-white font-bold rounded-xl shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
