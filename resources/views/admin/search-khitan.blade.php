@extends('layouts.app')
@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-4">
                        <a href="{{ route('khitan-registrations.export') }}"
                            class="inline-block bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded">
                            Export Excel
                        </a>
                    </div>
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">No</th>
                                    <th scope="col" class="px-6 py-3">Registration Number</th>
                                    <th scope="col" class="px-6 py-3">Wali</th>
                                    <th scope="col" class="px-6 py-3">Nomor Wali</th>
                                    <th scope="col" class="px-6 py-3">Nama Anak</th>
                                    <th scope="col" class="px-6 py-3">Domisili & Tempat Tinggal</th>
                                    <th scope="col" class="px-6 py-3">Sanur?</th>
                                    <th scope="col" class="px-6 py-3">Kartu Keluarga</th>
                                    <th scope="col" class="px-6 py-3">Akta</th>
                                    <th scope="col" class="px-6 py-3">Foto</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    <th scope="col" class="px-6 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($datas as $item)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $loop->iteration }}
                                        </th>
                                        <td class="px-6 py-4">{{ $item->registration_number }}</td>
                                        <td class="px-6 py-4">{{ $item->pic->name ?? '-' }}</td>
                                        <td class="px-6 py-4">{{ $item->pic->phone_number ?? '-' }}</td>
                                        <td class="px-6 py-4">{{ $item->name ?? '-' }}</td>
                                        <td class="px-6 py-4">{{ $item->domicile }}</td>
                                        <td class="px-6 py-4">{{ $item->is_sanur ? 'Yes' : 'No' }}</td>
                                        <td class="px-6 py-4">
                                            @if (!empty($item->familyCard) && !empty($item->familyCard->family_card_url))
                                                <button type="button" class="btn-primary"
                                                    onclick="openModal('{{ asset('storage/' . $item->familyCard->family_card_url) }}', 'Family Card')">
                                                    View Family Card
                                                </button>
                                            @else
                                                <span class="text-gray-400">Not available</span>
                                            @endif
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
                                        <script>
                                            function openModal(imageUrl, title) {
                                                document.getElementById('modalImage').src = imageUrl;
                                                document.getElementById('modalTitle').textContent = title;
                                                document.getElementById('imageModal').classList.remove('hidden');
                                            }

                                            function closeModal() {
                                                document.getElementById('imageModal').classList.add('hidden');
                                                document.getElementById('modalImage').src = '';
                                            }
                                        </script>
                                        <td class="px-6 py-4">
                                            <span
                                                class="px-2 py-1 text-xs font-semibold rounded {{ $item->status == 'checkin' ? 'bg-green-200 text-green-800' : 'bg-blue-200 text-blue-800' }}">
                                                {{ strtoupper($item->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 flex gap-2">
                                            <a href="{{ route('admin.dashboard.khitan-registration.edit', $item->id) }}"
                                                class="btn-primary">Detail</a>

                                            <form action="{{ route('admin.dashboard.khitan-registration.destroy') }}"
                                                method="POST" class="inline-block delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <button type="submit" class="btn-red">Delete</button>
                                            </form>
                                        </td>

                                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                        <script>
                                            // Add SweetAlert confirmation for delete forms
                                            document.querySelectorAll('.delete-form').forEach(form => {
                                                form.addEventListener('submit', function(e) {
                                                    e.preventDefault(); // Prevent form submission

                                                    Swal.fire({
                                                        title: 'Are you sure?',
                                                        text: "This action cannot be undone!",
                                                        icon: 'warning',
                                                        showCancelButton: true,
                                                        confirmButtonColor: '#d33',
                                                        cancelButtonColor: '#3085d6',
                                                        confirmButtonText: 'Yes, delete it!',
                                                        cancelButtonText: 'Cancel',
                                                        reverseButtons: true
                                                    }).then((result) => {
                                                        if (result.isConfirmed) {
                                                            form.submit(); // Proceed with form submission
                                                        }
                                                    });
                                                });
                                            });
                                        </script>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div id="imageModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
        <div class="bg-white rounded-lg shadow-lg max-w-2xl w-full relative">
            <div class="flex justify-between items-center p-4 border-b">
                <h3 id="modalTitle" class="text-lg font-semibold">Photos</h3>
                <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700 text-xl">&times;</button>
            </div>
            <div class="p-4 flex justify-center">
                <img id="modalImage" src="" alt="Preview" class="w-1/2 max-h-[75vh] object-contain">
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        // Seleksi semua form delete
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault(); // Stop form submit

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This action cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Lanjut submit
                    }
                });
            });
        });
    </script>
@endpush
