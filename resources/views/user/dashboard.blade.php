@extends('layouts.app')
@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"> --}}
            {{-- </div> --}}
            <div class="py-4 px-4 sm:px-0 overflow-x-auto">
                <div class="inline-flex gap-2">
                    <a href="{{ route('user.dashboard') }}" class="{{ $category_id == 0 ? 'btn-primary' : 'btn-secondary' }}">Semua Kategori</a>
                    @forelse ($categories as $item)
                        <a href="{{ route('user.dashboard.competitions.category', $item->id) }}"
                            class="{{ $item->id == $category_id ? 'btn-primary whitespace-nowrap' : 'btn-secondary whitespace-nowrap' }} text-xs">
                            {{ $item->name }}
                        </a>
                    @empty
                    @endforelse
                </div>
            </div>

            <div class="grid xs:grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 px-4 sm:px-0">
                @forelse ($competitions as $item)
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                        <a href="#">
                            {{-- <img class="rounded-t-lg" src="{{ asset('storage/' . $item->image_url) }}" alt="" /> --}}
                <img class="rounded-t-lg" src="{{ asset('assets/images/logo_only.png') }}" alt="{{ $item->name }}" />
                        </a>
                        <div class="p-5 flex flex-col gap-4">
                            <a href="#">
                                <h5 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                    {{ $item->name }}</h5>
                                <h6 class="text-md font-medium tracking-tight text-gray-900 dark:text-white mt-1">
                                    Total Peserta: {{ $item->registrations->count() }}</h6>
                            </a>
                            <span
                                class="w-fit text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm 
                                {{ $item->category->id == 1 ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' : '' }}
                                {{ $item->category->id == 2 ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300' : '' }}
                                {{ $item->category->id == 3 ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : '' }}
                                {{ $item->category->id == 4 ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' : '' }}
                                {{ $item->category->id == 5 ? 'bg-black text-white dark:bg-gray-800 dark:text-gray-300' : '' }}">
                                {{ $item->category->name }}
                            </span>
                            <a href="{{ route('user.dashboard.competitions.detail', $item->id) }}" class="btn-primary flex justify-center items-center">
                                Daftar
                                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                </svg>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                        <div class="p-5">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">No Competition
                                Available</h5>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
