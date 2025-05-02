@extends('layouts.app')
@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-4">
                        <a href="{{ route('admin.dashboard.competition.create') }}" class="btn-primary">Add Competition</a>
                    </div>
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">No</th>
                                    <th scope="col" class="px-6 py-3">Name</th>
                                    <th scope="col" class="px-6 py-3">Description</th>
                                    <th scope="col" class="px-6 py-3">Type</th>
                                    <th scope="col" class="px-6 py-3">Category</th>
                                    <th scope="col" class="px-6 py-3">Image</th>
                                    <th scope="col" class="px-6 py-3">Registration Start</th>
                                    <th scope="col" class="px-6 py-3">Registration End</th>
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
                                        <td class="px-6 py-4">{{ $item->name }}</td>
                                        <td class="px-6 py-4">{{ $item->description }}</td>
                                        <td class="px-6 py-4 capitalize">{{ $item->type }}</td>
                                        <td class="px-6 py-4">{{ $item->category->name ?? '-' }}</td>
                                        <td class="px-6 py-4">
                                                <img src="{{ asset('storage/' . $item->image_url) }}" alt="{{ $item->name }}" class="h-16 w-16 object-cover">
                                        </td>
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
                                        <td class="px-6 py-4 flex gap-2">
                                            <a href="{{ route('admin.dashboard.competition.edit', $item->id) }}"
                                                class="btn-yellow">Edit</a>

                                            <form action="{{ route('admin.dashboard.competition.destroy') }}"
                                                method="POST" class="inline-block" onsubmit="return confirmDelete(event)">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <button type="submit" class="btn-red">Delete</button>
                                            </form>
                                            <script>
                                                function confirmDelete(event) {
                                                    event.preventDefault();
                                                    Swal.fire({
                                                        title: 'Are you sure?',
                                                        text: "You won't be able to revert this!",
                                                        icon: 'warning',
                                                        showCancelButton: true,
                                                        confirmButtonColor: '#d33',
                                                        cancelButtonColor: '#3085d6',
                                                        confirmButtonText: 'Yes, delete it!'
                                                    }).then((result) => {
                                                        if (result.isConfirmed) {
                                                            event.target.submit();
                                                        }
                                                    });
                                                }
                                            </script>
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
