@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-10">
                <form action="{{ route('admin.dashboard.competition.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Name --}}
                        <div>
                            <label for="name"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-input"
                                placeholder="Enter competition name" required>
                            @error('name')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Type --}}
                        <div>
                            <label for="type"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Type</label>
                            <select name="type" id="type" required class="form-select w-full">
                                <option value="">-- Select Type --</option>
                                <option value="single" {{ old('type') == 'single' ? 'selected' : '' }}>Single</option>
                                <option value="team" {{ old('type') == 'team' ? 'selected' : '' }}>Team</option>
                            </select>
                            @error('type')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Category --}}
                        <div>
                            <label for="category_id"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category</label>
                            <select name="category_id" id="category_id" required class="form-select w-full">
                                <option value="">-- Select Category --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div>
                            <label for="status"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                            <select name="status" id="status" required class="form-select w-full">
                                <option value="Open" {{ old('status') == '1' ? 'selected' : '' }}>Open</option>
                                <option value="Close" {{ old('status') == '0' ? 'selected' : '' }}>Close</option>
                            </select>
                            @error('status')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Registration Start --}}
                        <div>
                            <label for="registration_start"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Registration
                                Start</label>
                            <input type="date" id="registration_start" name="registration_start"
                                value="{{ old('registration_start') }}" class="form-input w-full" required>
                            @error('registration_start')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Registration End --}}
                        <div>
                            <label for="registration_end"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Registration
                                End</label>
                            <input type="date" id="registration_end" name="registration_end"
                                value="{{ old('registration_end') }}" class="form-input w-full" required>
                            @error('registration_end')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Description (full width) --}}
                        <div class="md:col-span-2">
                            <label for="description"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                            <textarea id="description" name="description" class="form-textarea w-full h-32 resize-none">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Image URL --}}
                        <div class="md:col-span-2">
                            <label for="image_url"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Competition Image</label>
                            <input type="file" id="image_url" name="image_url" accept="image/*" class="form-input w-full">
                            @error('image_url')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="flex justify-end mt-8">
                        <button type="submit"
                            class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-6 py-2.5 text-center dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800">
                            Add Competition
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
