@extends('layouts.app')

@section('content')
    <section class="min-h-screen bg-gray-50 flex justify-center items-start pt-8 pb-16">
        <div class="container mx-auto px-4 max-w-5xl">

            <div class="mb-4">
                <a href="{{ route('user.dashboard') }}"
                    class="inline-flex items-center text-sm font-semibold text-gray-500 hover:text-[#1D6594] transition-colors">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Kembali ke Dashboard
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col md:flex-row">

                <div
                    class="md:w-5/12 bg-gray-100 relative flex justify-center items-center p-8 border-b md:border-b-0 md:border-r border-gray-100">
                    <span
                        class="absolute top-4 left-4 z-10 px-3 py-1 text-xs font-bold rounded-full shadow-sm
                        {{ $data->category->id == 1 ? 'bg-yellow-100 text-yellow-800' : '' }}
                        {{ $data->category->id == 2 ? 'bg-blue-100 text-blue-800' : '' }}
                        {{ $data->category->id == 3 ? 'bg-green-100 text-green-800' : '' }}
                        {{ $data->category->id == 4 ? 'bg-rose-100 text-rose-800' : '' }}
                        {{ $data->category->id == 5 ? 'bg-gray-800 text-white' : '' }}">
                        Kategori: {{ $data->category->name }}
                    </span>

                    <img class="w-full h-auto object-contain hover:scale-105 transition-transform duration-500"
                        src="{{ asset('assets/images/logo_only.png') }}" alt="{{ $data->name }}" />
                </div>

                <div class="md:w-7/12 p-6 sm:p-8 flex flex-col justify-between">

                    <div class="mb-6">
                        <div class="flex justify-between items-start mb-2">
                            <h1 class="text-3xl font-extrabold text-gray-900 leading-tight">{{ $data->name }}</h1>
                            <span
                                class="px-3 py-1 text-xs font-bold rounded-full border {{ $data->status == 'Open' ? 'bg-green-50 text-green-600 border-green-200' : 'bg-red-50 text-red-600 border-red-200' }}">
                                {{ $data->status == 'Open' ? 'Pendaftaran Buka' : 'Ditutup' }}
                            </span>
                        </div>
                        <p class="text-gray-600 text-sm leading-relaxed mb-4">
                            {{ $data->description ?? 'Deskripsi lomba tidak tersedia. Silakan baca guidebook untuk informasi lebih detail.' }}
                        </p>

                        <div
                            class="flex items-center gap-2 text-sm font-semibold text-gray-700 bg-gray-50 px-4 py-2 rounded-lg w-fit">
                            <svg class="w-5 h-5 text-[#E9AA14]" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                                </path>
                            </svg>
                            Total Peserta (Keseluruhan): <span
                                class="text-[#1D6594] text-lg">{{ $data->registrations->count() }}</span>
                        </div>
                    </div>

                    <div class="bg-rose-50 border border-rose-100 p-4 rounded-xl mb-6">
                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-rose-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                </path>
                            </svg>
                            <div>
                                <h4 class="text-sm font-bold text-rose-800 mb-1">Perhatian!</h4>
                                <p class="text-xs text-rose-600 mb-2">Lomba ini akan berjalan secara bersamaan dengan
                                    lomba-lomba berikut:</p>
                                <ul
                                    class="list-disc pl-4 text-xs text-rose-600 font-medium grid grid-cols-2 gap-x-2 gap-y-1">
                                    <li>Doa Harian</li>
                                    <li>Hafalan Juz 30</li>
                                    <li>Mewarnai</li>
                                    <li>Adzan</li>
                                </ul>
                                <p class="text-xs text-rose-600 mt-2 italic">*Mohon atur jadwal kontingen Anda dengan bijak.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-base font-bold text-gray-800 mb-3 flex items-center gap-2">
                            Daftar Peserta (TPQ Anda)
                        </h3>

                        <div class="overflow-y-auto custom-scrollbar border border-gray-200 rounded-xl"
                            style="max-height: 180px;">
                            <table class="w-full text-sm text-left text-gray-600">
                                <thead class="text-xs text-gray-500 uppercase bg-gray-50 sticky top-0">
                                    <tr>
                                        <th scope="col" class="px-4 py-3 font-semibold w-16 text-center">No</th>
                                        <th scope="col" class="px-4 py-3 font-semibold">Nama Peserta</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($participants as $item)
                                        <tr
                                            class="bg-white border-b border-gray-100 last:border-0 hover:bg-gray-50 transition-colors">
                                            <th scope="row" class="px-4 py-3 font-medium text-gray-900 text-center">
                                                {{ $loop->iteration }}
                                            </th>
                                            <td class="px-4 py-3 font-medium">{{ $item->name }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="px-4 py-8 text-center text-gray-400 italic" colspan="2">
                                                Belum ada peserta yang didaftarkan.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-4 border-t border-gray-100">
                        @if ($data->status == 'Open')
                            <a href="{{ route('user.dashboard.competitions.registration', $data->id) }}"
                                class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-xl shadow-md text-sm font-bold text-white bg-[#1D6594] hover:bg-[#154d73] transition-all hover:-translate-y-0.5 gap-2">
                                Tambah Peserta
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </a>
                        @else
                            <button disabled
                                class="w-full flex justify-center items-center py-3 px-4 rounded-xl shadow-sm text-sm font-bold text-gray-500 bg-gray-200 cursor-not-allowed gap-2">
                                Pendaftaran Ditutup
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                            </button>
                        @endif

                        <a href="https://drive.google.com/file/d/1ajDBWL_DAIumTEOYH-y14BM6e_PAsibM/view?usp=sharing"
                            target="_blank"
                            class="w-full flex justify-center items-center py-3 px-4 border border-rose-200 rounded-xl shadow-sm text-sm font-bold text-rose-600 bg-rose-50 hover:bg-rose-100 transition-all hover:-translate-y-0.5 gap-2">
                            Unduh Guidebook
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                        </a>
                    </div>

                </div>
            </div>
        </div>

        <style>
            .custom-scrollbar::-webkit-scrollbar {
                width: 6px;
            }

            .custom-scrollbar::-webkit-scrollbar-track {
                background: #f8fafc;
                border-radius: 8px;
            }

            .custom-scrollbar::-webkit-scrollbar-thumb {
                background: #cbd5e1;
                border-radius: 8px;
            }

            .custom-scrollbar::-webkit-scrollbar-thumb:hover {
                background: #94a3b8;
            }
        </style>
    </section>
@endsection
