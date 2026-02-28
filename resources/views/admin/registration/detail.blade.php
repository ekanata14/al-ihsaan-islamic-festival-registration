@extends('layouts.app')

@section('content')
    <div class="py-8 max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8">

        <x-breadcrumb :links="['Manajemen Registrasi' => route('admin.dashboard.registration'), 'Daftar Pendaftar' => '#']" />

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-900">Peserta Terdaftar</h2>
                <p class="text-sm text-gray-500 mt-1">Daftar pendaftar untuk perlombaan <strong
                        class="text-[#1D6594]">{{ $competition->name ?? 'Terpilih' }}</strong>.</p>
            </div>

            <div class="flex items-center gap-3 w-full md:w-auto">
                <form action="{{ route('admin.dashboard.registration.detail', $competition->id) }}" method="GET"
                    class="relative group w-full md:w-80">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400 group-focus-within:text-[#1D6594]" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="search" name="search" value="{{ request('search') }}"
                        class="block w-full pl-10 py-2.5 text-sm text-gray-900 bg-white border border-gray-200 rounded-xl focus:ring-[#1D6594] focus:border-[#1D6594] transition-all shadow-sm"
                        placeholder="Cari nama, wali, atau TPQ...">
                </form>

                <a href="{{ route('admin.dashboard.registration') }}"
                    class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition-all shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-sm text-left text-gray-600 whitespace-nowrap">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-bold text-center w-16">No</th>
                            <th scope="col" class="px-6 py-4 font-bold">No. Reg</th>
                            <th scope="col" class="px-6 py-4 font-bold">Info PIC (Wali)</th>
                            <th scope="col" class="px-6 py-4 font-bold">Nama Peserta / Tim</th>
                            <th scope="col" class="px-6 py-4 font-bold">Asal TPQ / Grup</th>
                            @if (($competition->name ?? '') === 'Hadrah')
                                <th scope="col" class="px-6 py-4 font-bold text-center">Jml Anggota</th>
                            @endif
                            <th scope="col" class="px-6 py-4 font-bold text-center">Status</th>
                            <th scope="col" class="px-6 py-4 font-bold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($datas as $item)
                            <tr class="bg-white hover:bg-blue-50/30 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-900 text-center">
                                    {{ $loop->iteration + ($datas->currentPage() - 1) * $datas->perPage() }}
                                </td>

                                <td class="px-6 py-4 font-extrabold text-[#1D6594]">
                                    {{ $item->registration_number }}
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-gray-800">{{ $item->pic->name ?? '-' }}</span>
                                            <span
                                                class="text-xs text-gray-500 font-medium">{{ $item->pic->phone_number ?? '-' }}</span>
                                        </div>
                                        @if (!empty($item->pic->phone_number))
                                            <a href="https://wa.me/{{ $item->pic->phone_number }}" target="_blank"
                                                class="p-1.5 bg-green-50 text-green-600 rounded-xl hover:bg-green-500 hover:text-white transition-all tooltip shadow-sm"
                                                title="Chat WA">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                    <path
                                                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 14c-2.21 0-4-1.79-4-4h2c0 1.1.9 2 2 2s2-.9 2-2-.9-2-2-2v-2c2.21 0 4 1.79 4 4s-1.79 4-4 4z">
                                                    </path>
                                                </svg>
                                            </a>
                                        @endif
                                    </div>
                                </td>

                                <td class="px-6 py-4 font-bold text-gray-900">
                                    {{ $item->participants[0]->name ?? '-' }}
                                    @if (count($item->participants) > 1)
                                        <span class="block text-[10px] text-gray-400 font-normal italic mt-0.5">+
                                            {{ count($item->participants) - 1 }} anggota lain</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 font-medium text-gray-700">
                                    {{ $item->group->name ?? '-' }}
                                </td>

                                @if (($competition->name ?? '') === 'Hadrah')
                                    <td class="px-6 py-4 text-center font-bold text-amber-700 bg-amber-50/50">
                                        {{ $item->total_participants ?? '-' }} Org
                                    </td>
                                @endif

                                <td class="px-6 py-4 text-center">
                                    @if (strtolower($item->status) == 'checkin')
                                        <span
                                            class="inline-flex items-center px-3 py-1.5 text-xs font-bold rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 shadow-sm">
                                            <span
                                                class="w-1.5 h-1.5 me-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                                            CHECK-IN
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-3 py-1.5 text-xs font-bold rounded-full bg-amber-50 text-amber-700 border border-amber-200 shadow-sm">
                                            <span class="w-1.5 h-1.5 me-1.5 bg-amber-500 rounded-full"></span> PENDING
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.dashboard.registration.detail.person', $item->id) }}"
                                            class="p-2.5 text-blue-600 bg-blue-50 hover:bg-blue-600 hover:text-white rounded-xl transition-all hover:-translate-y-0.5 tooltip shadow-sm"
                                            title="Edit / Lihat Detail Peserta">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-6 py-16 text-center text-gray-400"
                                    colspan="{{ ($competition->name ?? '') === 'Hadrah' ? '8' : '7' }}">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-16 h-16 mb-4 text-gray-300" fill="none" stroke="currentColor"
                                            stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                            </path>
                                        </svg>
                                        <p class="font-medium text-gray-500">Tidak ada pendaftar yang cocok dengan
                                            pencarian.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($datas->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                    {{ $datas->links('pagination::tailwind') }}
                </div>
            @endif
        </div>
    </div>
@endsection
