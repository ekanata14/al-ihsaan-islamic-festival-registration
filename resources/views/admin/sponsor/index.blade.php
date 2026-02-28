@extends('layouts.app')

@section('content')
    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <x-breadcrumb :links="['Manajemen Sponsor' => '#']" />

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-900">Data Sponsor</h2>
                <p class="text-sm text-gray-500 mt-1">Kelola data instansi atau perusahaan yang menjadi sponsor acara.</p>
            </div>

            <a href="{{ route('admin.dashboard.sponsor.create') }}"
                class="inline-flex items-center justify-center px-5 py-2.5 bg-[#1D6594] text-white font-bold rounded-xl hover:bg-[#154d73] transition-all shadow-sm hover:shadow-md hover:-translate-y-0.5 gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Sponsor
            </a>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-sm text-left text-gray-600 whitespace-nowrap">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-bold text-center w-16">No</th>
                            <th scope="col" class="px-6 py-4 font-bold text-center">Logo / Gambar</th>
                            <th scope="col" class="px-6 py-4 font-bold">Nama Sponsor</th>
                            <th scope="col" class="px-6 py-4 font-bold">Nominal Pendanaan</th>
                            <th scope="col" class="px-6 py-4 font-bold text-center w-32">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($datas as $item)
                            <tr class="bg-white hover:bg-blue-50/30 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-900 text-center">
                                    {{ $loop->iteration + ($datas->currentPage() - 1) * $datas->perPage() }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <div
                                        class="inline-flex items-center justify-center w-16 h-16 rounded-xl bg-gray-50 border border-gray-200 overflow-hidden p-1 shadow-sm">
                                        @if ($item->img_url)
                                            <img src="{{ asset($item->img_url) }}" alt="{{ $item->name }}"
                                                class="w-full h-full object-contain rounded-lg">
                                        @else
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                        @endif
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <span class="font-bold text-gray-900 text-base">{{ $item->name }}</span>
                                </td>

                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-3 py-1 text-sm font-bold text-emerald-700 bg-emerald-50 border border-emerald-100 rounded-lg">
                                        Rp {{ number_format($item->nominal, 0, ',', '.') }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.dashboard.sponsor.edit', $item->id) }}"
                                            class="p-2 text-amber-500 bg-amber-50 hover:bg-amber-500 hover:text-white rounded-lg transition-colors tooltip"
                                            title="Edit Sponsor">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </a>

                                        <form action="{{ route('admin.dashboard.sponsor.destroy') }}" method="POST"
                                            class="delete-form m-0">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="id" value="{{ $item->id }}">
                                            <button type="submit"
                                                class="p-2 text-rose-500 bg-rose-50 hover:bg-rose-500 hover:text-white rounded-lg transition-colors tooltip"
                                                title="Hapus Sponsor">
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
                                <td class="px-6 py-12 text-center text-gray-400" colspan="5">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor"
                                            stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                        <p class="font-medium text-gray-500">Belum ada data sponsor yang ditambahkan.</p>
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
                            title: 'Hapus Sponsor?',
                            text: "Data sponsor ini akan dihapus permanen dari sistem!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#1D6594',
                            confirmButtonText: 'Ya, Hapus!',
                            cancelButtonText: 'Batal',
                            reverseButtons: true,
                            customClass: {
                                popup: 'rounded-3xl'
                            }
                        }).then((result) => {
                            if (result.isConfirmed) form.submit();
                        });
                    });
                });
            });
        </script>
    @endpush
@endsection
