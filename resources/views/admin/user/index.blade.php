@extends('layouts.app')

@section('content')
    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <x-breadcrumb />

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-900">Manajemen User</h2>
                <p class="text-sm text-gray-500 mt-1">Kelola data akun PIC Lomba dan pendaftar Khitan.</p>
            </div>

            <a href="{{ route('admin.dashboard.user.create') }}"
                class="inline-flex items-center justify-center px-5 py-2.5 bg-[#1D6594] text-white font-bold rounded-xl hover:bg-[#154d73] transition-all shadow-sm hover:shadow-md hover:-translate-y-0.5 gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah User
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-bold text-center w-16">No</th>
                            <th scope="col" class="px-6 py-4 font-bold">Nama Lengkap</th>
                            <th scope="col" class="px-6 py-4 font-bold">Kontak Info</th>
                            <th scope="col" class="px-6 py-4 font-bold">Asal TPQ / Grup</th>
                            <th scope="col" class="px-6 py-4 font-bold">Role</th>
                            <th scope="col" class="px-6 py-4 font-bold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($datas as $item)
                            <tr class="bg-white hover:bg-blue-50/30 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-900 text-center">
                                    {{ $loop->iteration + ($datas->currentPage() - 1) * $datas->perPage() }}
                                </td>

                                <td class="px-6 py-4 font-bold text-gray-800">
                                    {{ $item->name }}
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex flex-col gap-1">
                                        <span class="text-gray-900 font-medium">{{ $item->email }}</span>
                                        <span class="text-xs text-gray-500">{{ $item->phone_number ?? '-' }}</span>
                                    </div>
                                </td>

                                <td class="px-6 py-4 font-medium text-[#1D6594]">
                                    {{ $item->group->name ?? '-' }}
                                </td>

                                <td class="px-6 py-4">
                                    <span
                                        class="px-2.5 py-1 text-xs font-bold rounded-full border whitespace-nowrap
                                        {{ strtolower($item->role) == 'khitan' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-blue-50 text-blue-700 border-blue-200' }}">
                                        {{ strtoupper($item->role) }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.dashboard.user.edit', $item->id) }}"
                                            class="p-2 text-amber-500 bg-amber-50 hover:bg-amber-500 hover:text-white rounded-lg transition-colors tooltip"
                                            title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </a>

                                        <form action="{{ route('admin.dashboard.user.destroy', $item->id) }}" method="POST"
                                            class="delete-form m-0">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="id" value="{{ $item->id }}">
                                            <button type="submit"
                                                class="p-2 text-rose-500 bg-rose-50 hover:bg-rose-500 hover:text-white rounded-lg transition-colors tooltip"
                                                title="Hapus">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-6 py-12 text-center text-gray-400" colspan="6">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor"
                                            stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                            </path>
                                        </svg>
                                        <p class="font-medium text-gray-500">Belum ada data user.</p>
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

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.delete-form').forEach(form => {
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();
                        Swal.fire({
                            title: 'Hapus User?',
                            text: "Data user yang dihapus tidak bisa dikembalikan!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#1D6594',
                            confirmButtonText: 'Ya, Hapus!',
                            cancelButtonText: 'Batal',
                            reverseButtons: true
                        }).then((result) => {
                            if (result.isConfirmed) form.submit();
                        });
                    });
                });
            });
        </script>
    @endpush
@endsection
