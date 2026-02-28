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
        input[type="file"]::file-selector-button:hover { background-color: #e5e7eb; }
    </style>

    <div class="py-8 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <x-breadcrumb :links="['Manajemen Lomba' => route('admin.dashboard.competition'), 'Tambah Lomba' => '#']" />

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gray-50 p-6 sm:px-8 border-b border-gray-100">
                <h3 class="text-xl font-extrabold text-gray-800">Tambah Lomba Baru 🏆</h3>
                <p class="text-sm text-gray-500 mt-1">Lengkapi informasi perlombaan untuk menampilkannya di halaman pendaftaran peserta.</p>
            </div>

            <form action="{{ route('admin.dashboard.competition.store') }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div class="md:col-span-2">
                        <x-input-label for="name" :value="__('Nama Lomba')" class="font-bold text-gray-700 mb-1.5 block" />
                        <x-text-input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                            class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-[#1D6594] focus:ring-[#1D6594] bg-gray-50 focus:bg-white transition-colors"
                            placeholder="Contoh: Lomba Mewarnai Kaligrafi" />
                        @error('name') <p class="text-rose-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <x-input-label for="category_id" :value="__('Kategori Umur/Kelas')" class="font-bold text-gray-700 mb-1.5 block" />
                        <select name="category_id" id="category_id" required class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-[#1D6594] focus:ring-[#1D6594] bg-gray-50 focus:bg-white transition-colors">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="text-rose-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <x-input-label for="type" :value="__('Tipe Peserta')" class="font-bold text-gray-700 mb-1.5 block" />
                        <select name="type" id="type" required class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-[#1D6594] focus:ring-[#1D6594] bg-gray-50 focus:bg-white transition-colors">
                            <option value="">-- Pilih Tipe --</option>
                            <option value="single" {{ old('type') == 'single' ? 'selected' : '' }}>Individu (Single)</option>
                            <option value="team" {{ old('type') == 'team' ? 'selected' : '' }}>Grup (Team)</option>
                        </select>
                        @error('type') <p class="text-rose-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <x-input-label for="registration_start" :value="__('Tanggal Mulai Pendaftaran')" class="font-bold text-gray-700 mb-1.5 block" />
                        <x-text-input type="date" id="registration_start" name="registration_start" value="{{ old('registration_start') }}" required
                            class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-[#1D6594] focus:ring-[#1D6594] bg-gray-50 focus:bg-white transition-colors" />
                        @error('registration_start') <p class="text-rose-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <x-input-label for="registration_end" :value="__('Tanggal Tutup Pendaftaran')" class="font-bold text-gray-700 mb-1.5 block" />
                        <x-text-input type="date" id="registration_end" name="registration_end" value="{{ old('registration_end') }}" required
                            class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-[#1D6594] focus:ring-[#1D6594] bg-gray-50 focus:bg-white transition-colors" />
                        @error('registration_end') <p class="text-rose-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <x-input-label for="status" :value="__('Status Pendaftaran Sekarang')" class="font-bold text-gray-700 mb-1.5 block" />
                        <select name="status" id="status" required class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-[#1D6594] focus:ring-[#1D6594] bg-gray-50 focus:bg-white transition-colors">
                            <option value="Open" {{ old('status') == 'Open' ? 'selected' : '' }}>Open (Buka)</option>
                            <option value="Close" {{ old('status') == 'Close' ? 'selected' : '' }}>Close (Tutup)</option>
                        </select>
                        <p class="text-xs text-gray-500 mt-1">*Jika "Close", user tidak bisa menambah peserta baru ke lomba ini.</p>
                        @error('status') <p class="text-rose-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <x-input-label for="description" :value="__('Deskripsi Singkat')" class="font-bold text-gray-700 mb-1.5 block" />
                        <textarea id="description" name="description" class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-[#1D6594] focus:ring-[#1D6594] bg-gray-50 focus:bg-white transition-colors form-textarea h-24 resize-none" placeholder="Tuliskan info singkat mengenai lomba ini (opsional)...">{{ old('description') }}</textarea>
                        @error('description') <p class="text-rose-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2 p-5 bg-gray-50 border border-gray-200 border-dashed rounded-xl">
                        <x-input-label for="image_url" :value="__('Gambar / Poster Lomba (Opsional)')" class="font-bold text-gray-700 mb-1.5 block" />
                        <input type="file" id="image_url" name="image_url" accept="image/*" class="block w-full text-sm text-gray-600 cursor-pointer">
                        <p class="text-xs text-gray-500 mt-2">Disarankan ukuran persegi (1:1) maksimal 2MB.</p>
                        @error('image_url') <p class="text-rose-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                </div>

                <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-100 mt-8">
                    <a href="{{ route('admin.dashboard.competition') }}" class="px-6 py-3 text-gray-600 font-bold hover:bg-gray-100 rounded-xl transition-colors">Batal</a>
                    <button type="submit" class="px-8 py-3 bg-[#1D6594] text-white font-bold rounded-xl shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all">
                        Simpan Lomba
                    </button>
                </div>

            </form>
        </div>
    </div>
@endsection
