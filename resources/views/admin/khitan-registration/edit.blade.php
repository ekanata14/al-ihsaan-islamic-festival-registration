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

    <div class="py-8 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <x-breadcrumb :links="[
            'Pendaftaran Khitan' => route('admin.dashboard.khitan-registration'),
            'Edit / Detail Khitan' => '#',
        ]" />

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">

            <div
                class="bg-gradient-to-r from-[#1D6594] to-[#154d73] p-6 sm:px-8 text-white relative overflow-hidden flex flex-col sm:flex-row justify-between items-center gap-6">
                <div class="absolute -left-10 -bottom-10 w-32 h-32 bg-white/10 rounded-full"></div>

                <div class="relative z-10 w-full sm:w-auto text-center sm:text-left">
                    <span
                        class="inline-block px-3 py-1 bg-white/20 text-xs font-bold rounded-full mb-2 uppercase tracking-widest border border-white/30 shadow-inner">
                        Registrasi Khitan
                    </span>
                    <h3 class="text-2xl font-extrabold">{{ $data->registration_number }}</h3>
                    <p class="text-blue-100 text-sm mt-1">Status saat ini: <span
                            class="font-bold text-white uppercase">{{ $data->status }}</span></p>
                </div>

                @if (isset($qrCode))
                    <div class="relative z-10 shrink-0 bg-white p-2 rounded-xl shadow-lg">
                        {!! $qrCode !!}
                    </div>
                @endif
            </div>

            <form action="{{ route('admin.dashboard.khitan-registration.update', $data->id) }}" method="POST"
                enctype="multipart/form-data" class="p-6 sm:p-8 space-y-8 bg-gray-50/50">
                @csrf
                @method('PUT')

                <div class="bg-gray-100/80 p-5 rounded-2xl border border-gray-200">
                    <h4 class="text-sm font-extrabold text-gray-500 uppercase tracking-wider mb-4">Informasi Wali / PIC</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="pic_name" :value="__('Nama Wali')"
                                class="font-bold text-gray-700 mb-1 block text-xs" />
                            <x-text-input type="text" id="pic_name"
                                class="block w-full px-4 py-2.5 rounded-xl border-transparent bg-gray-200 text-gray-600 cursor-not-allowed"
                                value="{{ $data->pic->name ?? '-' }}" readonly />
                        </div>
                        <div>
                            <x-input-label for="pic_phone" :value="__('Nomor WA Wali')"
                                class="font-bold text-gray-700 mb-1 block text-xs" />
                            <x-text-input type="text" id="pic_phone"
                                class="block w-full px-4 py-2.5 rounded-xl border-transparent bg-gray-200 text-gray-600 cursor-not-allowed"
                                value="{{ $data->pic->phone_number ?? '-' }}" readonly />
                        </div>
                    </div>
                </div>

                <div>
                    <h4
                        class="text-sm font-extrabold text-gray-800 uppercase tracking-wider mb-4 border-b border-gray-200 pb-2">
                        Identitas Anak</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <x-input-label for="name" :value="__('Nama Lengkap Anak')" class="font-bold text-gray-700 mb-1.5 block" />
                            <x-text-input type="text" name="name"
                                class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-[#1D6594] transition-colors bg-white"
                                value="{{ old('name', $data->name) }}" required />
                            @error('name')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-input-label for="age" :value="__('Umur (Tahun)')" class="font-bold text-gray-700 mb-1.5 block" />
                            <x-text-input type="number" name="age"
                                class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-[#1D6594] transition-colors bg-white"
                                value="{{ old('age', $data->age) }}" required />
                            @error('age')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-input-label for="nik" :value="__('NIK Anak')" class="font-bold text-gray-700 mb-1.5 block" />
                            <x-text-input type="text" name="nik"
                                class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-[#1D6594] transition-colors bg-white"
                                value="{{ old('nik', $data->nik) }}" required />
                            @error('nik')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-input-label for="birth_place" :value="__('Tempat Lahir')"
                                class="font-bold text-gray-700 mb-1.5 block" />
                            <x-text-input type="text" name="birth_place"
                                class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-[#1D6594] transition-colors bg-white"
                                value="{{ old('birth_place', $data->birth_place) }}" required />
                            @error('birth_place')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-input-label for="birth_date" :value="__('Tanggal Lahir')"
                                class="font-bold text-gray-700 mb-1.5 block" />
                            <x-text-input type="date" name="birth_date"
                                class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-[#1D6594] transition-colors bg-white"
                                value="{{ old('birth_date', $data->birth_date) }}" required />
                            @error('birth_date')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-input-label for="domicile" :value="__('Domisili / Alamat')" class="font-bold text-gray-700 mb-1.5 block" />
                            <x-text-input type="text" name="domicile"
                                class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-[#1D6594] transition-colors bg-white"
                                value="{{ old('domicile', $data->domicile) }}" required />
                            @error('domicile')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-input-label for="is_sanur" :value="__('Apakah Warga Sanur?')" class="font-bold text-gray-700 mb-1.5 block" />
                            <select name="is_sanur" id="is_sanur"
                                class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-[#1D6594] transition-colors bg-white"
                                required>
                                <option value="1" {{ old('is_sanur', $data->is_sanur) == 1 ? 'selected' : '' }}>Ya,
                                    Warga Sanur</option>
                                <option value="0" {{ old('is_sanur', $data->is_sanur) == 0 ? 'selected' : '' }}>Bukan
                                    Warga Sanur</option>
                            </select>
                            @error('is_sanur')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div>
                    <h4
                        class="text-sm font-extrabold text-gray-800 uppercase tracking-wider mb-4 border-b border-gray-200 pb-2">
                        Dokumen & Berkas</h4>
                    <div class="space-y-4">

                        <div
                            class="p-4 bg-white border border-gray-200 rounded-2xl flex flex-col sm:flex-row gap-5 items-start sm:items-center">
                            @if (!empty($data->familyCard) && !empty($data->familyCard->family_card_url))
                                <a href="{{ asset('storage/' . $data->familyCard->family_card_url) }}" target="_blank"
                                    class="shrink-0 block w-24 h-24 bg-gray-100 rounded-xl overflow-hidden border border-gray-200 hover:opacity-80 transition-opacity">
                                    <img src="{{ asset('storage/' . $data->familyCard->family_card_url) }}" alt="KK"
                                        class="w-full h-full object-cover">
                                </a>
                            @else
                                <div
                                    class="shrink-0 w-24 h-24 bg-gray-50 rounded-xl border border-dashed border-gray-300 flex items-center justify-center text-gray-400 text-xs text-center p-2">
                                    Tidak Ada KK</div>
                            @endif
                            <div class="flex-1 w-full">
                                <x-input-label for="certificate_url" :value="__('Update Kartu Keluarga (KK)')"
                                    class="font-bold text-gray-800 mb-1 block" />
                                <input type="file" name="certificate_url"
                                    class="block w-full text-sm text-gray-600 border border-gray-300 rounded-lg cursor-pointer bg-gray-50"
                                    accept="image/*">
                                @error('certificate_url')
                                    <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div
                            class="p-4 bg-white border border-gray-200 rounded-2xl flex flex-col sm:flex-row gap-5 items-start sm:items-center">
                            @if ($data->certificate_url)
                                <a href="{{ asset('storage/' . $data->certificate_url) }}" target="_blank"
                                    class="shrink-0 block w-24 h-24 bg-gray-100 rounded-xl overflow-hidden border border-gray-200 hover:opacity-80 transition-opacity">
                                    <img src="{{ asset('storage/' . $data->certificate_url) }}" alt="Akta"
                                        class="w-full h-full object-cover">
                                </a>
                            @else
                                <div
                                    class="shrink-0 w-24 h-24 bg-gray-50 rounded-xl border border-dashed border-gray-300 flex items-center justify-center text-gray-400 text-xs text-center p-2">
                                    Tidak Ada Akta</div>
                            @endif
                            <div class="flex-1 w-full">
                                <x-input-label for="certificate_url" :value="__('Update Akta Kelahiran')"
                                    class="font-bold text-gray-800 mb-1 block" />
                                <input type="file" name="certificate_url"
                                    class="block w-full text-sm text-gray-600 border border-gray-300 rounded-lg cursor-pointer bg-gray-50"
                                    accept="image/*">
                                @error('certificate_url')
                                    <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div
                            class="p-4 bg-white border border-gray-200 rounded-2xl flex flex-col sm:flex-row gap-5 items-start sm:items-center">
                            @if ($data->photo_url)
                                <a href="{{ asset('storage/' . $data->photo_url) }}" target="_blank"
                                    class="shrink-0 block w-24 h-24 bg-gray-100 rounded-xl overflow-hidden border border-gray-200 hover:opacity-80 transition-opacity">
                                    <img src="{{ asset('storage/' . $data->photo_url) }}" alt="Foto"
                                        class="w-full h-full object-cover">
                                </a>
                            @else
                                <div
                                    class="shrink-0 w-24 h-24 bg-gray-50 rounded-xl border border-dashed border-gray-300 flex items-center justify-center text-gray-400 text-xs text-center p-2">
                                    Tidak Ada Foto</div>
                            @endif
                            <div class="flex-1 w-full">
                                <x-input-label for="photo_url" :value="__('Update Foto Anak')"
                                    class="font-bold text-gray-800 mb-1 block" />
                                <input type="file" name="photo_url"
                                    class="block w-full text-sm text-gray-600 border border-gray-300 rounded-lg cursor-pointer bg-gray-50"
                                    accept="image/*">
                                @error('photo_url')
                                    <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                    </div>
                </div>

                <div
                    class="bg-blue-50/50 p-5 rounded-2xl border border-blue-100 flex flex-col sm:flex-row items-center justify-between gap-6 mt-6">
                    <div class="w-full sm:w-1/2">
                        <x-input-label for="status" :value="__('Status Kehadiran / Pendaftaran')" class="font-bold text-gray-800 mb-1.5 block" />
                        <select name="status" id="status"
                            class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-[#1D6594] transition-colors bg-white font-bold"
                            required>
                            <option value="registered"
                                {{ old('status', $data->status) == 'registered' ? 'selected' : '' }}>Registered (Terdaftar)
                            </option>
                            <option value="checkin" {{ old('status', $data->status) == 'checkin' ? 'selected' : '' }}>
                                Check-In (Hadir)</option>
                        </select>
                    </div>

                    <div class="w-full sm:w-auto flex justify-end gap-3 mt-4 sm:mt-0">
                        <a href="{{ route('admin.dashboard.khitan-registration') }}"
                            class="px-6 py-3.5 text-gray-600 font-bold hover:bg-white rounded-xl transition-colors">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-8 py-3.5 bg-[#1D6594] text-white font-bold rounded-xl shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection
