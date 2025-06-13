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
                                    <th scope="col" class="px-6 py-3">Name</th>
                                    <th scope="col" class="px-6 py-3">Type</th>
                                    <th scope="col" class="px-6 py-3">Category</th>
                                    <th scope="col" class="px-6 py-3">Registration Start</th>
                                    <th scope="col" class="px-6 py-3">Registration End</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    <th scope="col" class="px-6 py-3">Total Checkin</th>
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
                                        <td class="px-6 py-4">{{ $item->name }}</td>
                                        <td class="px-6 py-4 capitalize">{{ $item->type }}</td>
                                        <td class="px-6 py-4">{{ $item->category->name ?? '-' }}</td>
                                        <td class="px-6 py-4">
                                            {{ \Carbon\Carbon::parse($item->registration_start)->format('d M Y') }}</td>
                                        <td class="px-6 py-4">
                                            {{ \Carbon\Carbon::parse($item->registration_end)->format('d M Y') }}</td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="px-2 py-1 text-xs font-semibold rounded {{ $item->status == 'Open' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                                                {{ $item->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">{{ $item->checkins->count() ?? '-' }}</td>
                                        <td class="px-6 py-4 flex gap-2">
                                            <a href="{{ route('admin.dashboard.check-in.detail', $item->id) }}"
                                                class="btn-primary">Detail</a>
                                            @if ($item->status !== 'checkin')
                                                <form action="{{ route('admin.dashboard.check-in.store') }}" method="POST"
                                                    class="checkin-form inline-block">
                                                    @csrf
                                                    <input type="hidden" name="registration_number"
                                                        value="{{ $item->registration_number }}">
                                                    <button type="submit" class="btn-green sweet-checkin-btn"
                                                        data-registration="{{ $item->participants[0]->name }}">
                                                        CheckIn
                                                    </button>
                                                </form>
                                                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                                <script>
                                                    document.addEventListener('DOMContentLoaded', function() {
                                                        const checkinButtons = document.querySelectorAll('.sweet-checkin-btn');

                                                        checkinButtons.forEach(button => {
                                                            button.addEventListener('click', function(e) {
                                                                e.preventDefault(); // cegah submit langsung

                                                                const form = this.closest('form');
                                                                const regNumber = this.dataset.registration;

                                                                Swal.fire({
                                                                    title: 'Konfirmasi Check-In',
                                                                    text: `Apakah kamu yakin ingin check-in ${regNumber}?`,
                                                                    icon: 'question',
                                                                    showCancelButton: true,
                                                                    confirmButtonColor: '#3085d6',
                                                                    cancelButtonColor: '#d33',
                                                                    confirmButtonText: 'Ya, Check-In!',
                                                                    cancelButtonText: 'Batal'
                                                                }).then((result) => {
                                                                    if (result.isConfirmed) {
                                                                        form.submit(); // submit jika user konfirmasi
                                                                    }
                                                                });
                                                            });
                                                        });
                                                    });
                                                </script>
                                            @else
                                                <span class="text-green-600 font-semibold">Already Checked In</span>
                                            @endif


                                        </td>
                                    </tr>
                                @empty
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                        <td class="px-6 py-4 text-center" colspan="9">
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
