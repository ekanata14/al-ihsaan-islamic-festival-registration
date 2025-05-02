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
                                    <th scope="col" class="px-6 py-3">Registration Number</th>
                                    <th scope="col" class="px-6 py-3">Actions</th>
                                    <th scope="col" class="px-6 py-3">PIC</th>
                                    <th scope="col" class="px-6 py-3">Peserta</th>
                                    <th scope="col" class="px-6 py-3">Competition</th>
                                    <th scope="col" class="px-6 py-3">Group</th>
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
                                        <td class="px-6 py-4">{{ $item->registration_number }}</td>
                                        <td class="px-6 py-4 flex gap-2">
                                            <a href="{{ route('user.participants.detail', $item->id) }}"
                                                class="btn-primary">Detail</a>
                                            <a href="{{ route('user.participants.qr-code', $item->id) }}" class="btn-green">
                                                <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 4h6v6H4V4Zm10 10h6v6h-6v-6Zm0-10h6v6h-6V4Zm-4 10h.01v.01H10V14Zm0 4h.01v.01H10V18Zm-3 2h.01v.01H7V20Zm0-4h.01v.01H7V16Zm-3 2h.01v.01H4V18Zm0-4h.01v.01H4V14Z" />
                                                    <path stroke="currentColor" stroke-linejoin="round" stroke-width="2"
                                                        d="M7 7h.01v.01H7V7Zm10 10h.01v.01H17V17Z" />
                                                </svg>
                                            </a>

                                            {{-- <form action="{{ route('admin.dashboard.registration.destroy') }}"
                                                method="POST" class="inline-block" onsubmit="return confirmDelete(event)">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <button type="submit" class="btn-red">Delete</button>
                                            </form> --}}
                                        </td>
                                        <td class="px-6 py-4">{{ $item->pic->name ?? '-' }}</td>
                                        <td class="px-6 py-4">
                                            @foreach ($item->participants as $participant)
                                                <div>{{ $loop->iteration }}. {{ $participant->name }}</div>
                                            @endforeach
                                        </td>
                                        <td class="px-6 py-4">{{ $item->competition->name ?? '-' }}</td>
                                        <td class="px-6 py-4">{{ $item->group->name ?? '-' }}</td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="px-2 py-1 text-xs font-semibold rounded {{ $item->status == 'checkin' ? 'bg-green-200 text-green-800' : 'bg-blue-200 text-blue-800' }}">
                                                {{ strtoupper($item->status) }}
                                            </span>
                                        </td>
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
