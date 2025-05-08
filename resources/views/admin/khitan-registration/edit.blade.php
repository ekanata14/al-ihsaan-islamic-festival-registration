@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 p-6 gap-8">
            <form action="{{ route('admin.dashboard.khitan-registration.update', $data->id) }}" method="POST"
                enctype="multipart/form-data" class="mx-auto max-w-xl">
                @csrf
                @method('PUT')

                <h3 class="text-lg font-bold mb-4 text-center">Edit Registration - {{ $data->registration_number }}</h3>

                <div class="mb-4">
                    @if (isset($qrCode))
                        <div class="text-center flex flex-col justify-center items-center">
                            {{ $qrCode }}
                        </div>
                    @endif
                </div>

                <!-- PIC -->
                <div class="mb-4">
                    <label for="pic_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Wali</label>
                    <input type="text" name="pic_id" class="form-input w-full"
                        value="{{ old('pic_id', $data->pic->name ?? '-') }}" readonly>
                </div>

                <!-- Name -->
                <div class="mb-4">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama
                        Lengkap</label>
                    <input type="text" name="name" class="form-input w-full" value="{{ old('name', $data->name) }}"
                        required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Age -->
                <div class="mb-4">
                    <label for="age" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Umur</label>
                    <input type="number" name="age" class="form-input w-full" value="{{ old('age', $data->age) }}"
                        required>
                    @error('age')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Birth Place -->
                <div class="mb-4">
                    <label for="birth_place" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tempat
                        Lahir</label>
                    <input type="text" name="birth_place" class="form-input w-full"
                        value="{{ old('birth_place', $data->birth_place) }}" required>
                    @error('birth_place')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Birth Date -->
                <div class="mb-4">
                    <label for="birth_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal
                        Lahir</label>
                    <input type="date" name="birth_date" class="form-input w-full"
                        value="{{ old('birth_date', $data->birth_date) }}" required>
                    @error('birth_date')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- NIK -->
                <div class="mb-4">
                    <label for="nik" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIK</label>
                    <input type="text" name="nik" class="form-input w-full" value="{{ old('nik', $data->nik) }}"
                        required>
                    @error('nik')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Domicile -->
                <div class="mb-4">
                    <label for="domicile"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Domisili</label>
                    <input type="text" name="domicile" class="form-input w-full"
                        value="{{ old('domicile', $data->domicile) }}" required>
                    @error('domicile')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Is Sanur -->
                <div class="mb-4">
                    <label for="is_sanur"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sanur?</label>
                    <select name="is_sanur" id="is_sanur" class="form-input w-full" required>
                        <option value="1" {{ old('is_sanur', $data->is_sanur) == 1 ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ old('is_sanur', $data->is_sanur) == 0 ? 'selected' : '' }}>No</option>
                    </select>
                    @error('is_sanur')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Photo -->
                <div class="mb-4">
                    <label for="photo_url" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Foto
                        Peserta</label>
                    @if ($data->photo_url)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $data->photo_url) }}" alt="Photo" class="w-1/2">
                        </div>
                    @endif
                    <input type="file" name="photo_url" class="form-input w-full mt-2" accept="image/*">
                    @error('photo_url')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Certificate -->
                <div class="mb-4">
                    <label for="certificate_url" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Akta
                        Kelahiran/KTP/KTA</label>
                    @if ($data->certificate_url)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $data->certificate_url) }}" alt="Certificate" class="w-1/2">
                        </div>
                    @endif
                    <input type="file" name="certificate_url" class="form-input w-full mt-2" accept="image/*">
                    @error('certificate_url')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div class="mb-4">
                    <label for="status"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                    <select name="status" id="status" class="form-input w-full" required>
                        <option value="registered" {{ old('status', $data->status) == 'registered' ? 'selected' : '' }}>
                            Registered</option>
                        <option value="checkin" {{ old('status', $data->status) == 'checkin' ? 'selected' : '' }}>
                            Checkin</option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="mt-6">
                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
