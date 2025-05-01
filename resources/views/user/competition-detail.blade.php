@extends('layouts.app')

@section('content')
    <section class="h-full flex justify-center items-start">
        <div class="container mx-auto px-4 py-8">
            <div
                class="bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
                <img class="rounded-t-lg" src="{{ asset('storage/' . $data->image_url) }}" alt="{{ $data->name }}" />
                <div class="flex flex-col justify-between gap-4">
                    <div class="flex flex-col gap-4">
                        <h1 class="text-3xl font-bold">{{ $data->name }}</h1>
                        <span
                            class="w-fit bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-yellow-900 dark:text-yellow-300">{{ $data->category->name }}</span>
                        {{-- <h2 class="text-md">IDR. {{ number_format($product->harga, 0, ',', '.') }}</h2> --}}
                        <p>{{ $data->description }}</p>
                    </div>
                    <h3 class="text-xl font-bold text-center">Peserta Anda</h3>
                    <div class="overflow-y-auto" style="max-height: 200px">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">No</th>
                                    <th scope="col" class="px-6 py-3">Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($participants as $item)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $loop->iteration }}
                                        </th>
                                        {{-- <td class="px-6 py-4">{{ $item->name }}</td> --}}
                                    </tr>
                                @empty
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                        <td class="px-6 py-4 text-center" colspan="2">
                                            Tidak ada Data
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-1">
                        <a href="{{ route('user.dashboard.competitions.registration', $data->id) }}" class="btn-primary text-center flex items-center justify-center gap-2">
                            Tambah Peserta
                            <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 12h4m-2 2v-4M4 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </a>
                        <a href="#" class="btn-red text-center flex items-center justify-center gap-2">
                            Download Modul Umum
                            <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M13 11.15V4a1 1 0 1 0-2 0v7.15L8.78 8.374a1 1 0 1 0-1.56 1.25l4 5a1 1 0 0 0 1.56 0l4-5a1 1 0 1 0-1.56-1.25L13 11.15Z"
                                    clip-rule="evenodd" />
                                <path fill-rule="evenodd"
                                    d="M9.657 15.874 7.358 13H5a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2h-2.358l-2.3 2.874a3 3 0 0 1-4.685 0ZM17 16a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2H17Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                    <a href="{{ route('user.dashboard') }}" class="btn-green text-center">Kembali</a>
                </div>
            </div>
        </div>
    </section>
@endsection
