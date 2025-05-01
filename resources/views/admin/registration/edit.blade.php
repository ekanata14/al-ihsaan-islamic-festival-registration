@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 p-6 gap-8">
            <form action="{{ route('admin.dashboard.registration.update') }}" method="POST" enctype="multipart/form-data"
                class="mx-auto max-w-xl">
                @csrf
                @method('PUT')

                <input type="hidden" name="competition_id" value="{{ $data->competition_id }}">

                <div id="participants-container">
                    <h3 class="text-lg font-bold mb-4 text-center">Registration Detail - {{ $data->registration_number }}</h3>

                    @foreach ($data->participants as $i => $participant)
                        <div class="participant mb-6 border-b pb-4">
                                <input type="hidden" name="participants[{{ $i }}][id]"
                                    class="form-input w-full" placeholder="Enter participant name"
                                    value="{{ old("participants.$i.id", $participant->id) }}" required>
                            <div class="mb-4">
                                <label for="participants[{{ $i }}][name]"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama
                                    Lengkap</label>
                                <input type="text" name="participants[{{ $i }}][name]"
                                    class="form-input w-full" placeholder="Enter participant name"
                                    value="{{ old("participants.$i.name", $participant->name) }}" required>
                                @error("participants.{$i}.name")
                                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="participants[{{ $i }}][age]"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Umur</label>
                                <input type="number" name="participants[{{ $i }}][age]"
                                    class="form-input w-full" placeholder="Enter participant age"
                                    value="{{ old("participants.$i.age", $participant->age) }}" required>
                                @error("participants.{$i}.age")
                                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="participants[{{ $i }}][nik]"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIK</label>
                                <input type="text" name="participants[{{ $i }}][nik]"
                                    class="form-input w-full" placeholder="Enter participant NIK"
                                    value="{{ old("participants.$i.nik", $participant->nik) }}" required>
                                @error("participants.{$i}.nik")
                                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="participants[{{ $i }}][certificate_url]"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Akta
                                    Kelahiran/KTP/KTA</label>
                                {{-- <input type="file" name="participants[{{ $i }}][certificate_url]"
                                    class="form-input w-full" accept="image/*,application/pdf"> --}}
                                @if ($participant->certificate_url)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $participant->certificate_url) }}" alt="image"
                                            class="w-1/2">
                                    </div>
                                @endif
                                @error("participants.{$i}.certificate_url")
                                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- <!-- Submit Button -->
                <div class="mt-6">
                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Update
                    </button>
                </div> --}}
            </form>
        </div>
    </div>
@endsection
