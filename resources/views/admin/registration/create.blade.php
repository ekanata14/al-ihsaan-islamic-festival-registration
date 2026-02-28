@extends('layouts.app')

@section('content')
    <div class="py-8 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <x-breadcrumb :links="['Data Registrasi' => route('admin.dashboard.registration'), 'Registrasi Manual' => '#']" />

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gray-50 p-6 sm:px-8 border-b border-gray-100">
                <h3 class="text-xl font-extrabold text-gray-800">Registrasi Peserta Manual 📝</h3>
                <p class="text-sm text-gray-500 mt-1">Gunakan form ini untuk mendaftarkan peserta secara manual dari jalur
                    Admin.</p>
            </div>

            <form action="{{ route('admin.dashboard.registration.store') }}" method="POST" enctype="multipart/form-data"
                class="p-6 sm:p-8 space-y-6">
                @csrf

                <div class="bg-blue-50/50 p-5 rounded-2xl border border-blue-100">
                    <x-input-label for="competition_id" :value="__('Pilih Kompetisi / Lomba')" class="font-bold text-gray-800 mb-1.5 block" />
                    <select name="competition_id" id="competition_id" required
                        class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-[#1D6594] transition-colors bg-white">
                        <option value="">-- Pilih Lomba --</option>
                        @foreach ($competitions ?? [] as $comp)
                            <option value="{{ $comp->id }}">{{ $comp->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <x-input-label for="name" :value="__('Nama Lengkap Peserta')" class="font-bold text-gray-700 mb-1.5 block" />
                        <x-text-input type="text" id="name" name="name" value="{{ old('name') }}" required
                            autofocus
                            class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-[#1D6594] transition-colors bg-gray-50 focus:bg-white"
                            placeholder="Contoh: Ahmad Syauqi" />
                    </div>

                    <div>
                        <x-input-label for="age" :value="__('Umur (Tahun)')" class="font-bold text-gray-700 mb-1.5 block" />
                        <x-text-input type="number" id="age" name="age" value="{{ old('age') }}" required
                            class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-[#1D6594] transition-colors bg-gray-50 focus:bg-white"
                            placeholder="12" />
                    </div>

                    <div>
                        <x-input-label for="nik" :value="__('NIK Peserta')" class="font-bold text-gray-700 mb-1.5 block" />
                        <x-text-input type="number" id="nik" name="nik" value="{{ old('nik') }}" required
                            class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-[#1D6594] transition-colors bg-gray-50 focus:bg-white"
                            placeholder="16 Digit NIK" />
                    </div>

                    <div>
                        <x-input-label for="birth_place" :value="__('Tempat Lahir')" class="font-bold text-gray-700 mb-1.5 block" />
                        <x-text-input type="text" id="birth_place" name="birth_place" value="{{ old('birth_place') }}"
                            required
                            class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-[#1D6594] transition-colors bg-gray-50 focus:bg-white"
                            placeholder="Kota" />
                    </div>

                    <div>
                        <x-input-label for="birth_date" :value="__('Tanggal Lahir')" class="font-bold text-gray-700 mb-1.5 block" />
                        <x-text-input type="date" id="birth_date" name="birth_date" value="{{ old('birth_date') }}"
                            required
                            class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-[#1D6594] transition-colors bg-gray-50 focus:bg-white" />
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-100 mt-8">
                    <a href="{{ route('admin.dashboard.registration') }}"
                        class="px-6 py-3 text-gray-600 font-bold hover:bg-gray-100 rounded-xl transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-8 py-3 bg-[#1D6594] text-white font-bold rounded-xl shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all">
                        Simpan Registrasi
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
