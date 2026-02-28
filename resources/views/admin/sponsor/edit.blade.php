@extends('layouts.app')

@section('content')
    <style>
        input[type="file"]::file-selector-button {
            background-color: #fffbeb;
            color: #d97706;
            border: 1px solid #fcd34d;
            padding: 0.6rem 1.2rem;
            border-radius: 0.5rem;
            font-weight: 600;
            margin-right: 1rem;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
        }

        input[type="file"]::file-selector-button:hover {
            background-color: #fef3c7;
        }
    </style>

    <div class="py-8 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        <x-breadcrumb :links="['Manajemen Sponsor' => route('admin.dashboard.sponsor'), 'Edit Sponsor' => '#']" />

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gray-50 p-6 sm:px-8 border-b border-gray-100">
                <h3 class="text-xl font-extrabold text-gray-800">Edit Data Sponsor</h3>
                <p class="text-sm text-gray-500 mt-1">Lakukan perubahan pada data perusahaan <span
                        class="font-bold">{{ $data->name }}</span>.</p>
            </div>

            <form action="{{ route('admin.dashboard.sponsor.update') }}" method="POST" enctype="multipart/form-data"
                class="p-6 sm:p-8 space-y-6">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{ $data->id }}">

                <div>
                    <x-input-label for="name" :value="__('Nama Perusahaan / Instansi')" class="font-bold text-gray-700 mb-1.5 block" />
                    <x-text-input type="text" id="name" name="name" value="{{ old('name', $data->name) }}"
                        required autofocus
                        class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-amber-500 focus:ring-amber-500 transition-colors bg-gray-50 focus:bg-white" />
                    @error('name')
                        <p class="text-rose-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <x-input-label for="nominal" :value="__('Nominal Pendanaan (Rp)')" class="font-bold text-gray-700 mb-1.5 block" />
                    <x-text-input type="number" id="nominal" name="nominal" value="{{ old('nominal', $data->nominal) }}"
                        required
                        class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-amber-500 focus:ring-amber-500 transition-colors bg-gray-50 focus:bg-white" />
                    <p class="text-xs text-gray-400 mt-1">*Hanya angka tanpa titik/koma.</p>
                    @error('nominal')
                        <p class="text-rose-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="p-5 bg-amber-50/50 border border-amber-200 border-dashed rounded-xl">
                    <div class="flex flex-col sm:flex-row gap-6 items-start sm:items-center">
                        @if ($data->img_url)
                            <div class="shrink-0 p-2 bg-white rounded-xl shadow-sm border border-gray-100">
                                <img src="{{ asset($data->img_url) }}" alt="Current Logo"
                                    class="w-20 h-20 object-contain rounded-lg">
                            </div>
                        @endif
                        <div class="flex-1 w-full">
                            <x-input-label for="img_url" :value="__('Ganti Logo (Opsional)')" class="font-bold text-gray-700 mb-2 block" />
                            <input type="file" id="img_url" name="img_url" accept="image/*"
                                class="block w-full text-sm text-gray-600 cursor-pointer bg-white border border-gray-200 rounded-lg">
                            <p class="text-xs text-gray-400 mt-2">*Biarkan kosong jika tidak ingin mengganti logo.</p>
                            @error('img_url')
                                <p class="text-rose-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-100 mt-8">
                    <a href="{{ route('admin.dashboard.sponsor') }}"
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
