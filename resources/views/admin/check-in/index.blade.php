@extends('layouts.app')

@section('content')
    <div class="py-8 max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8">

        <x-breadcrumb :links="['Menu Check-In' => '#']" />

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-900">Validasi Kehadiran (Check-In)</h2>
                <p class="text-sm text-gray-500 mt-1">Pilih perlombaan di bawah ini untuk mengelola daftar hadir.</p>
            </div>

            <form action="{{ route('admin.dashboard.check-in') }}" method="GET" class="relative group w-full md:w-80">
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

                    <div class="p-6 border-b border-gray-100 bg-gray-50 relative overflow-hidden">
                        <div class="absolute -right-6 -top-6 w-24 h-24 bg-white rounded-full opacity-50"></div>

                        <div class="relative z-10">
                            <span
                                class="inline-block px-3 py-1 bg-white text-xs font-bold rounded-full mb-3 shadow-sm border border-gray-100 text-gray-600">
                                {{ $item->category->name ?? 'Umum' }} • {{ ucfirst($item->type) }}
                            </span>
                            <h3 class="text-xl font-extrabold text-gray-800 leading-tight line-clamp-1">{{ $item->name }}
                            </h3>

                            <div class="mt-3 flex items-center gap-2">
                                <span class="relative flex h-2.5 w-2.5">
                                    @if ($item->status == 'Open')
                                        <span
                                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                                    @else
                                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-red-500"></span>
                                    @endif
                                </span>
                                <span
                                    class="text-xs font-semibold {{ $item->status == 'Open' ? 'text-emerald-600' : 'text-red-500' }}">
                                    Registrasi {{ $item->status }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 flex flex-col flex-grow justify-between gap-6 bg-white">
                        <div
                            class="bg-emerald-50/50 rounded-2xl p-4 border border-emerald-100 flex items-center justify-between">
                            <div>
                                <p class="text-xs font-bold text-emerald-800 uppercase tracking-wider mb-1">Sudah Hadir</p>
                                <p class="text-3xl font-black text-emerald-600">
                                    {{ $item->checkins_count ?? '0' }} <span
                                        class="text-sm font-medium text-emerald-600/70">Peserta</span>
                                </p>
                            </div>
                            <div
                                class="w-12 h-12 bg-emerald-100 text-emerald-500 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>

                        <a href="{{ route('admin.dashboard.check-in.detail', $item->id) }}"
                            class="w-full py-3 bg-gray-50 hover:bg-[#1D6594] text-gray-700 hover:text-white font-bold rounded-xl text-center transition-colors flex justify-center items-center gap-2 border border-gray-200 hover:border-transparent">
                            Lihat Daftar Peserta Hadir
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
                    <p class="text-gray-500 max-w-md">Lomba atau kategori dengan nama "{{ request('search') }}" tidak
                        ditemukan.</p>
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
