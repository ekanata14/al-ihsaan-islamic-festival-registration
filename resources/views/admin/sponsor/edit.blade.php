@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <form action="{{ route('admin.dashboard.sponsor.update') }}" method="POST" enctype="multipart/form-data"
                    class="max-w-sm mx-auto py-12">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $data->id }}">

                    <div class="mb-5">
                        <label for="name"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                        <input type="text" id="name" name="name"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="{{ old('name', $data->name) }}" placeholder="Enter group name" required />

                        @error('name')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="img_url"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Image</label>
                        <input type="file" id="img_url" name="img_url"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />

                        @if ($data->img_url)
                            <div class="mt-4">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Current Image:</p>
                                <img src="{{ asset($data->img_url) }}" alt="Current Image"
                                    class="w-32 h-32 object-cover rounded">
                            </div>
                        @endif

                        @error('img_url')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="nominal"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nominal</label>
                        <input type="number" id="nominal" name="nominal"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Enter nominal value" value="{{ old('nominal', $data->nominal) }}" required />

                        @error('nominal')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="btn-yellow">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
