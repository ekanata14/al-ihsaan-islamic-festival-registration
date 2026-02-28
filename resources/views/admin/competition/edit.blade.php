@extends('layouts.app')

@section('content')
    <style>
        input[type="file"]::file-selector-button {
            background-color: #fffbeb;
            /* amber-50 */
            color: #d97706;
            /* amber-600 */
            border: 1px solid #fcd34d;
            /* amber-300 */
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

    <div class="py-8 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <x-breadcrumb :links="['Manajemen Lomba' => route('admin.dashboard.competition'), 'Edit Lomba' => '#']" />

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gray-50 p-6 sm:px-8 border-b border-gray-100">
                <h3 class="text-xl font-extrabold text-gray-800">Edit Data Lomba</h3>
                <p class="text-sm text-gray-500 mt-1">Lakukan perubahan pada detail informasi lomba <span
                        class="font-bold text-[#1D6594]">{{ $data->name }}</span>.</p>
            </div>

            <form action="{{ route('admin.dashboard.competition.update') }}" method="POST" enctype="multipart/form-data"
                class="p-6 sm:p-8 space-y-6">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{ $data->id }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div class="md:col-span-2">
                        <x-input-label for="name" :value="__('Nama Lomba')" class="font-bold text-gray-700 mb-1.5 block" />
                        <x-text-input type="text" id="name" name="name" value="{{ old('name', $data->name) }}"
                            required autofocus
                            class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-amber-500 focus:ring-amber-500 bg-gray-50 focus:bg-white transition-colors" />
                        @error('name')
                            <p class="text-rose-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <x-input-label for="category_id" :value="__('Kategori Umur/Kelas')" class="font-bold text-gray-700 mb-1.5 block" />
                        <select name="category_id" id="category_id" required
                            class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-amber-500 focus:ring-amber-500 bg-gray-50 focus:bg-white transition-colors">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $data->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-rose-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <x-input-label for="type" :value="__('Tipe Peserta')" class="font-bold text-gray-700 mb-1.5 block" />
                        <select name="type" id="type" required
                            class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-amber-500 focus:ring-amber-500 bg-gray-50 focus:bg-white transition-colors">
                            <option value="single" {{ old('type', $data->type) == 'single' ? 'selected' : '' }}>Individu
                                (Single)</option>
                            <option value="team" {{ old('type', $data->type) == 'team' ? 'selected' : '' }}>Grup (Team)
                            </option>
                        </select>
                        @error('type')
                            <p class="text-rose-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <x-input-label for="registration_start" :value="__('Tanggal Mulai Pendaftaran')"
                            class="font-bold text-gray-700 mb-1.5 block" />
                        <x-text-input type="date" id="registration_start" name="registration_start"
                            value="{{ old('registration_start', $data->registration_start) }}" required
                            class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-amber-500 focus:ring-amber-500 bg-gray-50 focus:bg-white transition-colors" />
                        @error('registration_start')
                            <p class="text-rose-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <x-input-label for="registration_end" :value="__('Tanggal Tutup Pendaftaran')"
                            class="font-bold text-gray-700 mb-1.5 block" />
                        <x-text-input type="date" id="registration_end" name="registration_end"
                            value="{{ old('registration_end', $data->registration_end) }}" required
                            class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-amber-500 focus:ring-amber-500 bg-gray-50 focus:bg-white transition-colors" />
                        @error('registration_end')
                            <p class="text-rose-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <x-input-label for="status" :value="__('Status Pendaftaran')" class="font-bold text-gray-700 mb-1.5 block" />
                        <select name="status" id="status" required
                            class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-amber-500 focus:ring-amber-500 bg-gray-50 focus:bg-white transition-colors">
                            <option value="Open"
