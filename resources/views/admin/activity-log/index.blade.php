@extends('layouts.app')

@section('content')
    <div class="py-8 max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8">

        <x-breadcrumb :links="['Activity Log' => '#']" />

        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-6 gap-4">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-900">Activity Log</h2>
                <p class="text-sm text-gray-500 mt-1">Pantau aktivitas login, pendaftaran, check-in, dan perubahan data
                    oleh pengguna.</p>
            </div>

            <span id="activity-live-badge"
                class="inline-flex items-center gap-2 px-3 py-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full text-xs font-bold">
                <span class="relative flex h-2.5 w-2.5">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                </span>
                LIVE
            </span>
        </div>

        <form action="{{ route('admin.dashboard.activity-log') }}" method="GET"
            class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-6 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-3">
            <div class="xl:col-span-2">
                <input type="search" name="search" value="{{ request('search') }}"
                    class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border border-gray-200 rounded-xl focus:ring-[#1D6594] focus:border-[#1D6594] shadow-sm transition-all"
                    placeholder="Cari deskripsi atau nama pengguna...">
            </div>

            <select name="role"
                class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border border-gray-200 rounded-xl focus:ring-[#1D6594] focus:border-[#1D6594] shadow-sm transition-all">
                <option value="">Semua Role</option>
                @foreach (['admin', 'user', 'khitan'] as $roleOption)
                    <option value="{{ $roleOption }}" {{ ($role ?? '') === $roleOption ? 'selected' : '' }}>
                        {{ strtoupper($roleOption) }}</option>
                @endforeach
            </select>

            <select name="action"
                class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border border-gray-200 rounded-xl focus:ring-[#1D6594] focus:border-[#1D6594] shadow-sm transition-all">
                <option value="">Semua Aksi</option>
                @foreach ($actions as $actionOption)
                    <option value="{{ $actionOption }}" {{ ($action ?? '') === $actionOption ? 'selected' : '' }}>
                        {{ $actionOption }}</option>
                @endforeach
            </select>

            <div class="grid grid-cols-2 gap-3">
                <input type="date" name="start_date" value="{{ request('start_date') }}"
                    class="block w-full px-3 py-2.5 text-sm text-gray-900 bg-white border border-gray-200 rounded-xl focus:ring-[#1D6594] focus:border-[#1D6594] shadow-sm transition-all">
                <input type="date" name="end_date" value="{{ request('end_date') }}"
                    class="block w-full px-3 py-2.5 text-sm text-gray-900 bg-white border border-gray-200 rounded-xl focus:ring-[#1D6594] focus:border-[#1D6594] shadow-sm transition-all">
            </div>

            <div class="xl:col-span-5 flex justify-end gap-3">
                <a href="{{ route('admin.dashboard.activity-log') }}"
                    class="px-5 py-2.5 text-gray-600 font-bold rounded-xl hover:bg-gray-50 transition-all">Reset</a>
                <button type="submit"
                    class="px-6 py-2.5 bg-[#1D6594] text-white font-bold rounded-xl hover:bg-[#154d73] transition-all shadow-sm">
                    Filter
                </button>
            </div>
        </form>

        <div id="realtime-activity-log" data-realtime="activity-log"
            class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden transition-colors duration-500">
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-bold w-40">Waktu</th>
                            <th scope="col" class="px-6 py-4 font-bold">Pengguna</th>
                            <th scope="col" class="px-6 py-4 font-bold">Aksi</th>
                            <th scope="col" class="px-6 py-4 font-bold">Deskripsi</th>
                            <th scope="col" class="px-6 py-4 font-bold">IP</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($datas as $item)
                            <tr class="bg-white hover:bg-blue-50/30 transition-colors">
                                <td class="px-6 py-4 text-gray-500 whitespace-nowrap">
                                    {{ $item->created_at?->format('d M Y H:i:s') }}
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex flex-col gap-1">
                                        <span class="font-bold text-gray-800">{{ $item->user_name ?? 'Guest' }}</span>
                                        <span
                                            class="px-2 py-0.5 text-[10px] font-bold rounded-full border w-fit whitespace-nowrap
                                            {{ $item->role === 'admin' ? 'bg-blue-50 text-blue-700 border-blue-200' : '' }}
                                            {{ $item->role === 'khitan' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : '' }}
                                            {{ $item->role === 'user' ? 'bg-amber-50 text-amber-700 border-amber-200' : '' }}
                                            {{ !$item->role ? 'bg-gray-100 text-gray-500 border-gray-200' : '' }}">
                                            {{ strtoupper($item->role ?? 'GUEST') }}
                                        </span>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <span
                                        class="px-2.5 py-1 text-xs font-bold rounded-lg bg-gray-100 text-gray-700 border border-gray-200 whitespace-nowrap">{{ $item->action }}</span>
                                </td>

                                <td class="px-6 py-4 text-gray-700">{{ $item->description }}</td>

                                <td class="px-6 py-4 text-xs text-gray-400 font-mono">{{ $item->ip_address ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-6 py-12 text-center text-gray-400" colspan="5">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor"
                                            stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <p class="font-medium text-gray-500">Belum ada aktivitas tercatat.</p>
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
