@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl px-4 mx-auto sm:px-6 lg:px-8 space-y-8">

            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Hasil Pencarian: <span
                        class="text-blue-600">"{{ $search }}"</span></h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Ditemukan <b>{{ $lombaDatas->count() }}</b> data Pendaftaran Lomba dan
                    <b>{{ $khitanDatas->count() }}</b> data Pendaftaran Khitan.
                </p>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 border-b pb-2">Data Pendaftaran Lomba
                        ({{ $lombaDatas->count() }})</h3>
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">No</th>
                                    <th scope="col" class="px-6 py-3">Reg Number</th>
                                    <th scope="col" class="px-6 py-3">Nama Peserta</th>
                                    <th scope="col" class="px-6 py-3">PIC (Wali)</th>
                                    <th scope="col" class="px-6 py-3">No HP PIC</th>
                                    <th scope="col" class="px-6 py-3">Lomba</th>
                                    <th scope="col" class="px-6 py-3">TPQ/Group</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    <th scope="col" class="px-6 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($lombaDatas as $item)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $loop->iteration }}</th>
                                        <td class="px-6 py-4 font-semibold text-blue-600">{{ $item->registration_number }}
                                        </td>
                                        <td class="px-6 py-4">{{ $item->participants[0]->name ?? '-' }}</td>
                                        <td class="px-6 py-4">{{ $item->pic->name ?? '-' }}</td>
                                        <td class="px-6 py-4">
                                            @if ($item->pic && $item->pic->phone_number)
                                                <a href="https://wa.me/{{ $item->pic->phone_number }}" target="_blank"
                                                    class="flex items-center gap-1 text-green-600 hover:underline">
                                                    <img src="{{ asset('assets/icons/whatsapp.png') }}" alt="wa"
                                                        width="20"> {{ $item->pic->phone_number }}
                                                </a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">{{ $item->competition->name ?? '-' }}</td>
                                        <td class="px-6 py-4">{{ $item->group->name ?? '-' }}</td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="px-2 py-1 text-xs font-semibold rounded {{ $item->status == 'checkin' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                                {{ strtoupper($item->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 flex gap-2">
                                            <a href="{{ route('admin.dashboard.registration.edit', $item->id) }}"
                                                class="px-3 py-1 text-sm font-medium text-white bg-blue-600 rounded hover:bg-blue-700">Detail</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="px-6 py-8 text-center text-gray-500" colspan="9">Tidak ada data
                                            pendaftaran lomba yang sesuai dengan kata kunci "{{ $search }}".</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 border-b pb-2">Data Pendaftaran
                        Khitan ({{ $khitanDatas->count() }})</h3>
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">No</th>
                                    <th scope="col" class="px-6 py-3">Reg Number</th>
                                    <th scope="col" class="px-6 py-3">Nama Anak</th>
                                    <th scope="col" class="px-6 py-3">Wali (PIC)</th>
                                    <th scope="col" class="px-6 py-3">No HP Wali</th>
                                    <th scope="col" class="px-6 py-3">Domisili</th>
                                    <th scope="col" class="px-6 py-3">Sanur?</th>
                                    <th scope="col" class="px-6 py-3">Berkas</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    <th scope="col" class="px-6 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($khitanDatas as $item)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $loop->iteration }}</th>
                                        <td class="px-6 py-4 font-semibold text-blue-600">{{ $item->registration_number }}
                                        </td>
                                        <td class="px-6 py-4">{{ $item->name ?? '-' }}</td>
                                        <td class="px-6 py-4">{{ $item->pic->name ?? '-' }}</td>
                                        <td class="px-6 py-4">
                                            @if ($item->pic && $item->pic->phone_number)
                                                <a href="https://wa.me/{{ $item->pic->phone_number }}" target="_blank"
                                                    class="flex items-center gap-1 text-green-600 hover:underline">
                                                    <img src="{{ asset('assets/icons/whatsapp.png') }}" alt="wa"
                                                        width="20"> {{ $item->pic->phone_number }}
                                                </a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">{{ $item->domicile }}</td>
                                        <td
                                            class="px-6 py-4 font-bold {{ $item->is_sanur ? 'text-green-600' : 'text-gray-500' }}">
                                            {{ $item->is_sanur ? 'Yes' : 'No' }}</td>
                                        <td class="px-6 py-4 space-y-1">
                                            @if (!empty($item->familyCard) && !empty($item->familyCard->family_card_url))
                                                <button
                                                    onclick="openModal('{{ asset('storage/' . $item->familyCard->family_card_url) }}', 'Kartu Keluarga')"
                                                    class="block text-xs text-blue-600 hover:underline">Lihat KK</button>
                                            @endif
                                            @if (!empty($item->certificate_url))
                                                <button
                                                    onclick="openModal('{{ asset('storage/' . $item->certificate_url) }}', 'Akta Kelahiran')"
                                                    class="block text-xs text-blue-600 hover:underline">Lihat Akta</button>
                                            @endif
                                            @if (!empty($item->photo_url))
                                                <button
                                                    onclick="openModal('{{ asset('storage/' . $item->photo_url) }}', 'Foto Anak')"
                                                    class="block text-xs text-blue-600 hover:underline">Lihat Foto</button>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="px-2 py-1 text-xs font-semibold rounded {{ $item->status == 'checkin' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                                {{ strtoupper($item->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 flex gap-2">
                                            <a href="{{ route('admin.dashboard.khitan-registration.edit', $item->id) }}"
                                                class="px-3 py-1 text-sm font-medium text-white bg-blue-600 rounded hover:bg-blue-700">Detail</a>

                                            <form action="{{ route('admin.dashboard.khitan-registration.destroy') }}"
                                                method="POST" class="inline-block delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <button type="submit"
                                                    class="px-3 py-1 text-sm font-medium text-white bg-red-600 rounded hover:bg-red-700">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="px-6 py-8 text-center text-gray-500" colspan="10">Tidak ada data
                                            pendaftaran khitan yang sesuai dengan kata kunci "{{ $search }}".</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div id="imageModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-75 hidden z-50">
        <div class="bg-white rounded-lg shadow-lg max-w-2xl w-full relative">
            <div class="flex justify-between items-center p-4 border-b">
                <h3 id="modalTitle" class="text-lg font-semibold text-gray-800">Preview</h3>
                <button onclick="closeModal()"
                    class="text-gray-500 hover:text-red-500 text-2xl font-bold">&times;</button>
            </div>
            <div class="p-4 flex justify-center">
                <img id="modalImage" src="" alt="Preview" class="w-full max-h-[75vh] object-contain rounded">
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Script Modal
        function openModal(imageUrl, title) {
            document.getElementById('modalImage').src = imageUrl;
            document.getElementById('modalTitle').textContent = title;
            document.getElementById('imageModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('imageModal').classList.add('hidden');
            document.getElementById('modalImage').src = '';
        }

        // Script Delete Form Khitan
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Hapus Data?',
                        text: "Data yang dihapus tidak dapat dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endpush
