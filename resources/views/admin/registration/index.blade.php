@extends('layouts.app')

@section('content')
    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <x-breadcrumb :links="['Pilih Lomba' => '#']" />

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-900">Validasi & Check-In Peserta</h2>
                <p class="text-sm text-gray-500 mt-1">Pilih perlombaan di bawah ini untuk melihat daftar peserta yang
                    mendaftar dan melakukan proses check-in.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($datas as $item)
                <div
                    class="bg-white rounded-3xl shadow-sm hover:shadow-xl border border-gray-100 overflow-hidden flex flex-col group transition-all duration-300">

                    <div class="relative h-48 bg-gray-100 overflow-hidden">
                        <span
                            class="absolute top-4 right-4 z-10 text-[10px] font-extrabold px-3 py-1.5 rounded-full shadow-md uppercase tracking-wider
                            {{ ($item->category->id ?? 0) == 1 ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ ($item->category->id ?? 0) == 2 ? 'bg-blue-100 text-blue-800' : '' }}
                            {{ ($item->category->id ?? 0) == 3 ? 'bg-green-100 text-green-800' : '' }}
                            {{ ($item->category->id ?? 0) == 4 ? 'bg-rose-100 text-rose-800' : '' }}
                            {{ ($item->category->id ?? 0) >= 5 ? 'bg-gray-800 text-white' : 'bg-white text-gray-800' }}">
                            {{ $item->category->name ?? 'Umum' }}
                        </span>

                        @if ($item->image_url)
                            <img class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500"
                                src="{{ asset('storage/' . $item->image_url) }}" alt="{{ $item->name }}" />
                        @else
                            <div
                                class="w-full h-full flex items-center justify-center bg-gray-200 text-gray-400 group-hover:scale-110 transition-transform duration-500">
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

                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-blue-50/50 rounded-xl p-3 border border-blue-50">
                                <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wide">Total Pendaftar</p>
                                <p class="text-2xl font-black text-[#1D6594] mt-0.5">
                                    {{ $item->registrations_count ?? ($item->registrations ? $item->registrations->count() : '0') }}
                                </p>
                            </div>

                            <div class="bg-emerald-50/50 rounded-xl p-3 border border-emerald-50">
                                <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wide">Sudah Check-In</p>
                                <p class="text-2xl font-black text-emerald-600 mt-0.5">
                                    {{ $item->checked_in_count ?? '0' }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-2 pt-4 border-t border-gray-100">
                            <div class="flex items-center gap-2">
                                <span class="relative flex h-3 w-3">
                                    @if ($item->status == 'Open')
                                        <span
                                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                                    @else
                                        <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                                    @endif
                                </span>
                                <span
                                    class="text-xs font-bold {{ $item->status == 'Open' ? 'text-emerald-600' : 'text-red-500' }}">
                                    Pendaftaran {{ $item->status }}
                                </span>
                            </div>

                            <a href="{{ route('admin.dashboard.registration.detail', $item->id) }}"
                                class="inline-flex items-center gap-2 text-sm font-bold text-[#1D6594] hover:text-[#154d73] bg-blue-50 hover:bg-blue-100 px-4 py-2 rounded-lg transition-colors">
                                Lihat Data
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div
                    class="col-span-full bg-white border border-gray-200 rounded-3xl shadow-sm p-12 flex flex-col items-center justify-center text-center">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                    </div>
                    <h5 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Kompetisi</h5>
                    <p class="text-gray-500 max-w-md">Data perlombaan belum tersedia atau belum ditambahkan oleh Admin.</p>
                </div>
            @endforelse
        </div>

        @if ($datas->hasPages())
            <div class="mt-8">
                {{ $datas->links('pagination::tailwind') }}
            </div>
        @endif

    </div>
@endsection
