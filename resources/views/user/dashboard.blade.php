@extends('layouts.app')

@section('content')
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 px-4 sm:px-0">
                <div
                    class="lg:col-span-2 bg-gradient-to-r from-[#1D6594] to-[#154d73] rounded-2xl p-8 text-white shadow-lg relative overflow-hidden flex flex-col justify-center">
                    <div
                        class="absolute top-0 right-0 w-48 h-48 bg-white opacity-5 rounded-full transform translate-x-1/3 -translate-y-1/3">
                    </div>
                    <div
                        class="absolute bottom-0 right-10 w-32 h-32 bg-[#E9AA14] opacity-10 rounded-full transform translate-y-1/2">
                    </div>
                    <div class="relative z-10">
                        <h2 class="text-3xl font-extrabold mb-2">Ahlan wa Sahlan,
                            {{ explode(' ', auth()->user()->name)[0] }}! 👋</h2>
                        <p class="text-blue-100 max-w-lg">Pilih dan daftarkan kontingen terbaik dari TPQ Anda untuk mengikuti
                            berbagai perlombaan di Al Ihsaan Islamic Festival.</p>
                    </div>
                </div>

                <div
                    class="bg-white rounded-2xl p-6 border border-emerald-100 shadow-md flex flex-col justify-between relative overflow-hidden group">
                    <div
                        class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-50 rounded-full group-hover:scale-150 transition-transform duration-500 z-0">
                    </div>
                    <div class="relative z-10">
                        <div
                            class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center mb-4 shadow-inner">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-1">Khitanan Massal</h3>
                        <p class="text-sm text-gray-500 mb-6">Daftarkan anak, keluarga, atau kerabat Anda untuk khitan
                            gratis.</p>
                    </div>
                    <a href="{{ route('khitan.registration.person') }}"
                        class="relative z-10 w-full py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-xl text-center shadow-md hover:shadow-lg transition-all hover:-translate-y-0.5 flex justify-center items-center gap-2">
                        Daftar Khitan
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <div class="px-4 sm:px-0">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-5 gap-4">
                    <h3 class="text-2xl font-extrabold text-gray-800">Daftar Lomba</h3>

                    <form action="{{ route('user.dashboard') }}" method="GET" class="w-full sm:w-80 relative group">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400 group-focus-within:text-[#1D6594] transition-colors"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="search" name="search" value="{{ request('search') }}"
                            class="block w-full pl-10 pr-20 py-2.5 text-sm text-gray-900 bg-white border border-gray-200 rounded-full focus:border-[#1D6594] focus:ring-2 focus:ring-[#1D6594]/20 transition-all shadow-sm placeholder-gray-400"
                            placeholder="Cari perlombaan..." />
                        <button type="submit"
                            class="absolute right-1.5 top-1.5 bottom-1.5 bg-[#1D6594] hover:bg-[#154d73] text-white text-xs font-bold px-4 rounded-full transition-colors shadow-sm">
                            Cari
                        </button>
                    </form>
                </div>

                <div class="flex gap-3 overflow-x-auto pb-4 custom-scrollbar snap-x">
                    <a href="{{ route('user.dashboard') }}"
                        class="shrink-0 snap-start px-5 py-2 rounded-full font-semibold text-sm transition-colors {{ $category_id == 0 ? 'bg-[#1D6594] text-white shadow-md' : 'bg-white text-gray-600 border border-gray-200 hover:bg-blue-50 hover:text-[#1D6594]' }}">
                        Semua Kategori
                    </a>

                    @foreach ($categories as $item)
                        <a href="{{ route('user.dashboard.competitions.category', $item->id) }}"
                            class="shrink-0 snap-start px-5 py-2 rounded-full font-semibold text-sm transition-colors {{ $item->id == $category_id ? 'bg-[#1D6594] text-white shadow-md' : 'bg-white text-gray-600 border border-gray-200 hover:bg-blue-50 hover:text-[#1D6594]' }}">
                            {{ $item->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 px-4 sm:px-0 pb-10">
                @forelse ($competitions as $item)
                    <div
                        class="bg-white rounded-2xl shadow-sm hover:shadow-xl border border-gray-100 overflow-hidden flex flex-col group transition-shadow duration-300">
                        <div class="relative h-48 bg-gray-100 overflow-hidden flex justify-center items-center">
                            <span
                                class="absolute top-3 right-3 z-10 text-xs font-bold px-3 py-1 rounded-full shadow-sm
                                {{ $item->category->id == 1 ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $item->category->id == 2 ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $item->category->id == 3 ? 'bg-green-100 text-green-800' : '' }}
                                {{ $item->category->id == 4 ? 'bg-rose-100 text-rose-800' : '' }}
                                {{ $item->category->id == 5 ? 'bg-gray-800 text-white' : '' }}">
                                {{ $item->category->name }}
                            </span>
                            <img class="w-full h-full object-contain p-4 transform group-hover:scale-110 transition-transform duration-500"
                                src="{{ asset('assets/images/logo_only.png') }}" alt="{{ $item->name }}" />
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                        </div>

                        <div class="p-5 flex flex-col flex-grow justify-between gap-4">
                            <div>
                                <h5
                                    class="text-xl font-extrabold text-gray-900 group-hover:text-[#1D6594] transition-colors line-clamp-2 leading-tight">
                                    {{ $item->name }}
                                </h5>
                                <p class="text-sm font-medium text-gray-500 mt-2 flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-[#E9AA14]" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                                        </path>
                                    </svg>
                                    Total Peserta: <span
                                        class="text-gray-800 font-bold">{{ $item->registrations->count() }}</span>
                                </p>
                            </div>
                            <a href="{{ route('user.dashboard.competitions.detail', $item->id) }}"
                                class="w-full py-2.5 bg-[#1D6594] hover:bg-[#154d73] text-white font-bold rounded-xl text-center shadow-md transition-all hover:-translate-y-0.5 flex justify-center items-center gap-2">
                                Daftarkan Peserta
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3">
                                    </path>
                                </svg>
                            </a>
                        </div>
                    </div>
                @empty
                    <div
                        class="col-span-full bg-white border border-gray-200 rounded-2xl shadow-sm p-10 flex flex-col items-center justify-center text-center">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <h5 class="text-xl font-bold text-gray-800 mb-1">
                            {{ request('search') ? 'Pencarian Tidak Ditemukan' : 'Belum Ada Perlombaan' }}
                        </h5>
                        <p class="text-gray-500">
                            {{ request('search') ? 'Coba gunakan kata kunci lain untuk mencari perlombaan.' : 'Tidak ada lomba yang tersedia saat ini.' }}
                        </p>
                        @if (request('search'))
                            <a href="{{ route('user.dashboard') }}"
                                class="mt-4 px-5 py-2 text-sm font-bold text-[#1D6594] bg-blue-50 rounded-full hover:bg-blue-100 transition-colors">
                                Reset Pencarian
                            </a>
                        @endif
                    </div>
                @endforelse
            </div>

        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .custom-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
@endsection
