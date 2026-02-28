@extends('layouts.app')

@section('content')
    <div class="py-8 max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8">

        <x-breadcrumb :links="['Pilih Lomba' => '#']" />

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-900">Manajemen Registrasi</h2>
                <p class="text-sm text-gray-500 mt-1">Pilih perlombaan di bawah ini untuk melihat daftar dan mengedit detail
                    pendaftar.</p>
            </div>

            <form action="{{ route('admin.dashboard.registration') }}" method="GET" class="relative group w-full md:w-80">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400 group-focus-within:text-[#1D6594]" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="search" name="search" value="{{ request('search') }}"
                    class="block w-full pl-10 py-2.5 text-sm text-gray-900 bg-white border border-gray-200 rounded-xl focus:ring-[#1D6594] focus:border-[#1D6594] transition-all shadow-sm"
                    placeholder="Cari nama lomba atau kategori...">
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @forelse ($datas as $item)
                <div
                    class="bg-white rounded-3xl shadow-sm hover:shadow-xl border border-gray-100 overflow-hidden flex flex-col group transition-all duration-300">

                    <div class="relative h-48 bg-gray-100 overflow-hidden">
                        <span
                            class="absolute top-4 right-4 z-10 text-[10px] font-extrabold px-3 py-1.5 rounded-full shadow-md uppercase tracking-wider bg-white text-gray-800">
                            {{ $item->category->name ?? 'Umum' }}
                        </span>

                        @if ($item->image_url)
                            <img class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500"
                                src="{{ asset('storage/' . $item->image_url) }}" alt="{{ $item->name }}" />
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-200 text-gray-400">
                                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 to-transparent opacity-80"></div>

                        <div class="absolute bottom-4 left-4 right-4">
                            <h3 class="text-xl font-extrabold text-white leading-tight line-clamp-1">{{ $item->name }}
                            </h3>
                            <p class="text-xs text-gray-300 mt-1 capitalize">
                                {{ $item->type == 'single' ? 'Individu' : 'Grup/Tim' }}</p>
                        </div>
                    </div>

                    <div class="p-6 flex flex-col flex-grow justify-between gap-5 bg-white">
                        <div class="bg-blue-50/50 rounded-2xl p-4 border border-blue-100 flex items-center justify-between">
                            <div>
                                <p class="text-xs font-bold text-[#1D6594] uppercase tracking-wider mb-1">Total Pendaftar
                                </p>
                                <p class="text-3xl font-black text-[#1D6594]">
                                    {{ $item->registrations->count() ?? '0' }} <span
                                        class="text-sm font-medium text-blue-500/70">Registrasi</span>
                                </p>
                            </div>
                        </div>

                        <a href="{{ route('admin.dashboard.registration.detail', $item->id) }}"
                            class="w-full py-3 bg-gray-50 hover:bg-[#1D6594] text-gray-700 hover:text-white font-bold rounded-xl text-center transition-colors flex justify-center items-center gap-2 border border-gray-200 hover:border-transparent">
                            Kelola Pendaftar
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            @empty
                <div
                    class="col-span-full bg-white border border-gray-200 rounded-3xl shadow-sm p-16 flex flex-col items-center justify-center text-center">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-5">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <h5 class="text-2xl font-bold text-gray-800 mb-2">Tidak Ditemukan</h5>
                    <p class="text-gray-500 max-w-md">Data perlombaan dengan kata kunci tersebut belum tersedia.</p>
                </div>
            @endforelse
        </div>

        @if ($datas->hasPages())
            <div class="mt-8 flex justify-center">
                {{ $datas->links('pagination::tailwind') }}
            </div>
        @endif

    </div>
@endsection
