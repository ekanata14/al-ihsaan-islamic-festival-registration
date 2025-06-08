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
                                    <th scope="col" class="px-6 py-3">PIC</th>
                                    <th scope="col" class="px-6 py-3">PIC Phone Number</th>
                                    <th scope="col" class="px-6 py-3">Name</th>
                                    <th scope="col" class="px-6 py-3">Competition</th>
                                    <th scope="col" class="px-6 py-3">Group</th>
                                    @if ($competition->name === 'Hadrah')
                                        <th scope="col" class="px-6 py-3">Jumlah Peserta</th>
                                    @endif
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
                                        <td class="px-6 py-4">
                                            <a href="https://wa.me/{{ $item->pic->phone_number ?? '-' }}"><img
                                                    src="{{ asset('assets/icons/whatsapp.png') }}" alt="whatsapp"
                                                    width="40">
                                        </td>
                                        <td class="px-6 py-4">{{ $item->participants[0]->name ?? '-' }}</td>
                                        <td class="px-6 py-4">{{ $item->competition->name ?? '-' }}</td>
                                        <td class="px-6 py-4">{{ $item->group->name ?? '-' }}</td>
                                        @if ($competition->name === 'Hadrah')
                                            <td class="px-6 py-4">{{ $item->total_participants ?? '-' }}</td>
                                        @endif
                                        <td class="px-6 py-4">
                                            <span
                                                class="px-2 py-1 text-xs font-semibold rounded {{ $item->status == 'checkin' ? 'bg-green-200 text-green-800' : 'bg-blue-200 text-blue-800' }}">
                                                {{ strtoupper($item->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 flex gap-2">
                                            <a href="{{ route('admin.dashboard.registration.edit', $item->id) }}"
                                                class="btn-primary">Detail</a>

                                            {{-- <form action="{{ route('admin.dashboard.registration.destroy') }}"
                                                method="POST" class="inline-block" onsubmit="return confirmDelete(event)">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <button type="submit" class="btn-red">Delete</button>
                                            </form> --}}
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
