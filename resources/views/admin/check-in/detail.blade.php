@extends('layouts.app')

@section('content')
    <div class="py-8 max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8">

        <x-breadcrumb :links="['Menu Check-In' => route('admin.dashboard.check-in'), 'Daftar Hadir Lomba' => '#']" />

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-900">Daftar Kehadiran Peserta</h2>
                <p class="text-sm text-gray-500 mt-1">Daftar peserta yang sudah berstatus <span
                        class="font-bold text-emerald-600">CHECKED IN</span> pada lomba <strong
                        class="text-[#1D6594]">{{ $competition->name ?? 'Terpilih' }}</strong>.</p>
            </div>

            <div class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto">
                <form action="{{ route('admin.dashboard.check-in.detail', $competition->id) }}" method="GET"
                    class="relative group w-full sm:w-80">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400 group-focus-within:text-[#1D6594]" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="search" name="search" value="{{ request('search') }}"
                        class="block w-full pl-10 py-2.5 text-sm text-gray-900 bg-white border border-gray-200 rounded-xl focus:ring-[#1D6594] focus:border-[#1D6594] transition-all shadow-sm"
                        placeholder="Cari nama, wali, no reg, TPQ...">
                </form>

                <a href="{{ route('admin.dashboard.check-in') }}"
                    class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-2.5 bg-white border border-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition-all shadow-sm gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
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
                            <th scope="col" class="px-6 py-4 font-bold text-center">No. Urut</th>
                            <th scope="col" class="px-6 py-4 font-bold">No. Registrasi</th>
                            <th scope="col" class="px-6 py-4 font-bold">Nama Peserta / Tim</th>
                            <th scope="col" class="px-6 py-4 font-bold">Asal TPQ / Grup</th>
                            <th scope="col" class="px-6 py-4 font-bold">Info PIC (Wali)</th>
                            @if (($competition->name ?? '') === 'Hadrah')
                                <th scope="col" class="px-6 py-4 font-bold text-center">Jml Anggota</th>
                            @endif
                            <th scope="col" class="px-6 py-4 font-bold text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($datas as $item)
                            <tr class="bg-white hover:bg-emerald-50/20 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-900 text-center">
                                    {{ $loop->iteration + ($datas->currentPage() - 1) * $datas->perPage() }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-[#1D6594] text-white font-bold shadow-sm">
                                        {{ $item->participant_number ?? '-' }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 font-bold text-gray-600">
                                    {{ $item->registration_number ?? ($item->registration->registration_number ?? '-') }}
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span
                                            class="font-bold text-gray-900 text-base leading-tight">{{ $item->participant->name ?? '-' }}</span>
                                        <span
                                            class="text-xs font-semibold text-[#1D6594] bg-blue-50 w-fit px-2 py-0.5 rounded mt-1">{{ $item->competition->category->name ?? '-' }}</span>
                                    </div>
                                </td>

                                <td class="px-6 py-4 font-medium text-gray-700">
                                    {{ $item->pic->group->name ?? '-' }}
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
                                                class="p-1.5 bg-green-50 text-green-600 rounded-full hover:bg-green-500 hover:text-white transition-all tooltip shadow-sm"
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

                                @if (($competition->name ?? '') === 'Hadrah')
                                    <td class="px-6 py-4 text-center">
                                        <span
                                            class="text-xs font-bold text-amber-700 bg-amber-50 px-3 py-1 rounded-md border border-amber-100">
                                            {{ $item->registration->total_participants ?? '-' }} Org
                                        </span>
                                    </td>
                                @endif

                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="inline-flex items-center px-3 py-1.5 text-xs font-bold rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 shadow-sm">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" stroke-width="3"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        CHECK-IN
                                    </span>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td class="px-6 py-16 text-center text-gray-400"
                                    colspan="{{ ($competition->name ?? '') === 'Hadrah' ? '8' : '7' }}">
                                    <div class="flex flex-col items-center justify-center">
                                        <div
                                            class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4 border border-gray-100">
                                            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor"
                                                stroke-width="1.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                            </svg>
                                        </div>
                                        @if (request('search'))
                                            <p class="font-bold text-gray-600 text-lg">Pencarian Tidak Ditemukan</p>
                                            <p class="text-sm text-gray-400 mt-1">Tidak ada peserta yang cocok dengan kata
                                                kunci "{{ request('search') }}".</p>
                                        @else
                                            <p class="font-bold text-gray-600 text-lg">Belum Ada Kehadiran</p>
                                            <p class="text-sm text-gray-400 mt-1">Belum ada peserta yang melakukan check-in
                                                pada lomba ini.</p>
                                        @endif
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
