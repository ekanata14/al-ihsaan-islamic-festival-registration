@extends('layouts.app')
@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">No</th>
                                    <th scope="col" class="px-6 py-3">Actions</th>
                                    <th scope="col" class="px-6 py-3">Registration Number</th>
                                    <th scope="col" class="px-6 py-3">Wali</th>
                                    <th scope="col" class="px-6 py-3">Domisili & Tempat Tinggal</th>
                                    <th scope="col" class="px-6 py-3">Sanur?</th>
                                    <th scope="col" class="px-6 py-3">Akta</th>
                                    <th scope="col" class="px-6 py-3">Foto</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($datas as $item)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $loop->iteration }}
                                        </th>
                                        <td class="px-6 py-4 grid place-items-center p-0Dem">
                                            <a href="{{ route('khitan.registration.qr-code', $item->id) }}"
                                                class="btn-green">
                                                <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 4h6v6H4V4Zm10 10h6v6h-6v-6Zm0-10h6v6h-6V4Zm-4 10h.01v.01H10V14Zm0 4h.01v.01H10V18Zm-3 2h.01v.01H7V20Zm0-4h.01v.01H7V16Zm-3 2h.01v.01H4V18Zm0-4h.01v.01H4V14Z" />
                                                    <path stroke="currentColor" stroke-linejoin="round" stroke-width="2"
                                                        d="M7 7h.01v.01H7V7Zm10 10h.01v.01H17V17Z" />
                                                </svg>
                                            </a>
                                        </td>
                                        <td class="px-6 py-4">{{ $item->registration_number }}</td>
                                        <td class="px-6 py-4">{{ $item->pic->name ?? '-' }}</td>
                                        <td class="px-6 py-4">{{ $item->domicile }}</td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="px-2 py-1 text-xs font-semibold rounded {{ $item->is_sanur ? 'bg-green-200 text-green-800' : 'bg-blue-200 text-blue-800' }}">
                                                {{ $item->is_sanur ? 'YES' : 'NO' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <button type="button" class="btn-primary"
                                                onclick="openModal('{{ asset('storage/' . $item->certificate_url) }}', 'Certificate')">
                                                View Certificate
                                            </button>
                                        </td>
                                        <td class="px-6 py-4">
                                            <button type="button" class="btn-primary"
                                                onclick="openModal('{{ asset('storage/' . $item->photo_url) }}', 'Photo')">
                                                View Photo
                                            </button>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="px-2 py-1 text-xs font-semibold rounded {{ $item->status == 'checkin' ? 'bg-green-200 text-green-800' : 'bg-blue-200 text-blue-800' }}">
                                                {{ strtoupper($item->status) }}
                                            </span>
                                        </td>
                                        {{-- <td class="px-6 py-4 flex gap-2">
                                            <a href="{{ route('admin.dashboard.registration.edit', $item->id) }}"
                                                class="btn-primary">Detail</a>
                                        </td> --}}
                                    </tr>
                                @empty
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                        <td class="px-6 py-4 text-center" colspan="7">
                                            No data available
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="mt-4">
                            {{ $datas->links('pagination::tailwind') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="photoModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
            <div class="p-4">
                <h2 id="modalTitle" class="text-lg font-bold mb-4"></h2>
                <img id="modalImage" src="" alt="Image" class="max-w-full max-h-[80vh]">
            </div>
            <div class="flex justify-end p-4">
                <button type="button" class="btn-secondary" onclick="closeModal()">Close</button>
            </div>
        </div>
    </div>

    <script>
        function openModal(imageUrl, title) {
            const modal = document.getElementById('photoModal');
            const modalImage = document.getElementById('modalImage');
            const modalTitle = document.getElementById('modalTitle');
            modalImage.src = imageUrl;
            modalTitle.textContent = title;
            modal.classList.remove('hidden');
        }

        function closeModal() {
            const modal = document.getElementById('photoModal');
            modal.classList.add('hidden');
        }
    </script>
@endsection
