@extends('layouts.app')

@section('content')
    <style>
        input[type="file"]::file-selector-button {
            background-color: #f3f4f6;
            color: #1D6594;
            border: 0;
            padding: 0.6rem 1.2rem;
            border-radius: 0.5rem;
            font-weight: 600;
            margin-right: 1rem;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
        }

        input[type="file"]::file-selector-button:hover {
            background-color: #e5e7eb;
        }
    </style>

    <div class="py-8 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        <x-breadcrumb :links="['Manajemen Sponsor' => route('admin.dashboard.sponsor'), 'Tambah Sponsor' => '#']" />

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gray-50 p-6 sm:px-8 border-b border-gray-100">
                <h3 class="text-xl font-extrabold text-gray-800">Tambah Sponsor Baru 🤝</h3>
                <p class="text-sm text-gray-500 mt-1">Masukkan informasi pendukung/sponsor acara ke dalam sistem.</p>
            </div>

            <form action="{{ route('admin.dashboard.sponsor.store') }}" method="POST" enctype="multipart/form-data"
                class="p-6 sm:p-8 space-y-6">
                @csrf

                <div>
                    <x-input-label for="name" :value="__('Nama Perusahaan / Instansi Sponsor')" class="font-bold text-gray-700 mb-1.5 block" />
                    <x-text-input type="text" id="name" name="name" value="{{ old('name') }}" required
                        autofocus
                        class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-[#1D6594] transition-colors bg-gray-50 focus:bg-white"
                        placeholder="Contoh: Bank Syariah Indonesia" />
                    @error('name')
                        <p class="text-rose-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <x-input-label for="nominal" :value="__('Nominal Pendanaan (Rp)')" class="font-bold text-gray-700 mb-1.5 block" />
                    <x-text-input type="number" id="nominal" name="nominal" value="{{ old('nominal', 0) }}" required
                        class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-[#1D6594] transition-colors bg-gray-50 focus:bg-white"
                        placeholder="Masukkan angka tanpa titik/koma" />
                    <p class="text-xs text-gray-400 mt-1">*Hanya angka. Contoh: 5000000 untuk 5 Juta.</p>
                    @error('nominal')
                        <p class="text-rose-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="p-5 bg-gray-50 border border-gray-200 border-dashed rounded-xl">
                    <x-input-label for="img_url" :value="__('Logo / Gambar Sponsor')" class="font-bold text-gray-700 mb-1.5 block" />
                    <input type="file" id="img_url" name="img_url" accept="image/*" required
                        class="block w-full text-sm text-gray-600 cursor-pointer bg-white border border-gray-200 rounded-lg">
                    <p class="text-xs text-gray-400 mt-2">*Format yang disarankan PNG transparan atau JPG, rasio 1:1.</p>
                    @error('img_url')
                        <p class="text-rose-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="website_url" :value="__('Website (opsional)')" class="font-bold text-gray-700 mb-1.5 block" />
                        <x-text-input type="text" id="website_url" name="website_url" value="{{ old('website_url') }}"
                            class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-[#1D6594] transition-colors bg-gray-50 focus:bg-white"
                            placeholder="https://..." />
                    </div>
                    <div>
                        <x-input-label for="sort_order" :value="__('Urutan Tampil')" class="font-bold text-gray-700 mb-1.5 block" />
                        <x-text-input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0"
                            class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-[#1D6594] transition-colors bg-gray-50 focus:bg-white" />
                    </div>
                </div>

                <label class="inline-flex items-center gap-2 cursor-pointer">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                        class="rounded border-gray-300 text-[#1D6594] focus:ring-[#1D6594]">
                    <span class="text-sm font-medium text-gray-600">Tampilkan sponsor ini di landing page</span>
                </label>

                <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-100 mt-8">
                    <a href="{{ route('admin.dashboard.sponsor') }}"
                        class="px-6 py-3 text-gray-600 font-bold hover:bg-gray-100 rounded-xl transition-colors">Batal</a>
                    <button type="submit"
                        class="px-8 py-3 bg-[#1D6594] text-white font-bold rounded-xl shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all flex items-center gap-2">
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
