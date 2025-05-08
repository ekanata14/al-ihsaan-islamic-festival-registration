<x-guest-layout>
    <form method="POST" action="{{ route('khitan.registration.person.store') }}" enctype="multipart/form-data">
        @csrf

        <h1 class="text-2xl text-center font-bold">Data Anak Sunat</h1>
        <input type="hidden" name="role" value="khitan">

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Age -->
        <div class="mt-4">
            <x-input-label for="age" :value="__('Age')" />
            <x-text-input id="age" class="block mt-1 w-full" type="number" name="age" :value="old('age')"
                required />
            <x-input-error :messages="$errors->get('age')" class="mt-2" />
        </div>

        <!-- Birth Place -->
        <div class="mt-4">
            <x-input-label for="birth_place" :value="__('Birth Place')" />
            <x-text-input id="birth_place" class="block mt-1 w-full" type="text" name="birth_place" :value="old('birth_place')"
                required />
            <x-input-error :messages="$errors->get('birth_place')" class="mt-2" />
        </div>

        <!-- Birth Date -->
        <div class="mt-4">
            <x-input-label for="birth_date" :value="__('Birth Date')" />
            <x-text-input id="birth_date" class="block mt-1 w-full" type="date" name="birth_date" :value="old('birth_date')"
                required />
            <x-input-error :messages="$errors->get('birth_date')" class="mt-2" />
        </div>

        <!-- NIK -->
        <div class="mt-4">
            <x-input-label for="nik" :value="__('NIK')" />
            <x-text-input id="nik" class="block mt-1 w-full" type="text" name="nik" :value="old('nik')"
                required />
            <x-input-error :messages="$errors->get('nik')" class="mt-2" />
        </div>

        <!-- Domicile -->
        <div class="mt-4">
            <x-input-label for="domicile" :value="__('Alamat')" />
            <x-text-input id="domicile" class="block mt-1 w-full" type="text" name="domicile" :value="old('domicile')"
                required />
            <x-input-error :messages="$errors->get('domicile')" class="mt-2" />
        </div>

        <!-- Is Sanur -->
        <div class="mt-4">
            <x-input-label for="is_sanur" :value="__('Domisili Sanur?')" />
            <div class="flex items-center gap-2">
                <input id="is_sanur" type="radio" name="is_sanur" value="1"
                    {{ old('is_sanur') == '1' ? 'checked' : '' }}
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                <label for="is_sanur" class="text-sm text-gray-600 dark:text-gray-400">Yes</label>
                <input id="is_sanur" type="radio" name="is_sanur" value="0"
                    {{ old('is_sanur') == '1' ? 'checked' : '' }}
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                <label for="is_sanur" class="text-sm text-gray-600 dark:text-gray-400">No</label>
            </div>
            <x-input-error :messages="$errors->get('is_sanur')" class="mt-2" />
        </div>

        <!-- Photo URL -->
        <div class="mt-4">
            <x-input-label for="photo_url" :value="__('Photo')" />
            <input id="photo_url" class="block mt-1 w-full" type="file" name="photo_url" accept="image/*" required />
            <x-input-error :messages="$errors->get('photo_url')" class="mt-2" />
        </div>

        <!-- Certificate URL -->
        <div class="mt-4">
            <x-input-label for="certificate_url" :value="__('Certificate')" />
            <input id="certificate_url" class="block mt-1 w-full" type="file" name="certificate_url" accept="image/*"
                required />
            <x-input-error :messages="$errors->get('certificate_url')" class="mt-2" />
        </div>

        <div class="flex items-center flex-col mt-4">
            <div class="flex flex-col justify-center w-full text-center gap-2">
                <button type="submit" class="btn-primary w-full">Daftar</button>
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                    href="{{ route('login') }}">
                    {{ __('Sudah Terdaftar?') }}
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>
