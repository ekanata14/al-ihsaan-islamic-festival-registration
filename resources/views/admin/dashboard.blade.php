@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <div class="py-12">
        <div class="max-w-7xl px-4 mx-auto sm:px-6 lg:px-8 space-y-6">

            <div
                class="flex flex-col md:flex-row justify-between items-center bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm">
                <div class="mb-4 md:mb-0">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Dashboard Overview</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Menampilkan data dari <span
                            class="font-bold">{{ $startDateInput }}</span> hingga <span
                            class="font-bold">{{ $endDateInput }}</span>.</p>
                </div>

                <form method="GET" action="{{ route('admin.dashboard') }}"
                    class="flex flex-col sm:flex-row items-center space-y-3 sm:space-y-0 sm:space-x-3 w-full md:w-auto">
                    <div class="flex items-center space-x-2 w-full sm:w-auto">
                        <label for="start_date"
                            class="text-sm font-medium text-gray-700 dark:text-gray-300 whitespace-nowrap">Mulai:</label>
                        <input type="text" name="start_date" id="start_date" value="{{ $startDateInput }}"
                            class="datepicker bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full sm:w-32 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="DD-MM-YYYY" readonly>
                    </div>

                    <div class="flex items-center space-x-2 w-full sm:w-auto">
                        <label for="end_date"
                            class="text-sm font-medium text-gray-700 dark:text-gray-300 whitespace-nowrap">Sampai:</label>
                        <input type="text" name="end_date" id="end_date" value="{{ $endDateInput }}"
                            class="datepicker bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full sm:w-32 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="DD-MM-YYYY" readonly>
                    </div>

                    <button type="submit"
                        class="w-full sm:w-auto px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800 transition-colors">
                        Filter
                    </button>
                </form>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                @php
                    $statCards = [
                        [
                            'title' => 'Total PIC TPQ',
                            'value' => $totalPicTpq,
                            'route' => route('admin.dashboard.user'),
                            'color' => 'text-blue-600',
                        ],
                        [
                            'title' => 'Total Lomba',
                            'value' => $totalCompetitions,
                            'route' => route('admin.dashboard.competition'),
                            'color' => 'text-indigo-600',
                        ],
                        [
                            'title' => 'Total TPQ',
                            'value' => $totalGroups,
                            'route' => route('admin.dashboard.group'),
                            'color' => 'text-purple-600',
                        ],
                        [
                            'title' => 'Daftar Lomba',
                            'value' => $totalRegistrations,
                            'route' => route('admin.dashboard.registration'),
                            'color' => 'text-emerald-600',
                        ],
                        [
                            'title' => 'Daftar Khitan',
                            'value' => $totalRegistrationKhitans,
                            'route' => route('admin.dashboard.khitan-registration'),
                            'color' => 'text-rose-600',
                        ],
                    ];
                @endphp

                @foreach ($statCards as $card)
                    <div
                        class="bg-white border border-gray-200 rounded-lg shadow-sm p-5 flex flex-col justify-between dark:bg-gray-800 dark:border-gray-700 hover:shadow-md transition-shadow">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">{{ $card['title'] }}
                            </p>
                            <h5 class="mt-1 text-3xl font-bold {{ $card['color'] }} dark:text-white">{{ $card['value'] }}
                            </h5>
                        </div>
                        <a href="{{ $card['route'] }}"
                            class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 mt-4">
                            Detail <svg class="rtl:rotate-180 w-3 h-3 ms-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M1 5h12m0 0L9 1m4 4L9 9" />
                            </svg>
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6 text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Daftar Lomba (Detail)</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Statistik dan daftar lengkap perlombaan yang
                                tersedia.</p>
                        </div>
                        <a href="{{ route('admin.dashboard.competition.create') }}"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600">
                            Add Competition
                        </a>
                    </div>

                    <div class="relative h-80 mb-8 border-b border-gray-100 dark:border-gray-700 pb-8">
                        <canvas id="daftarLombaChart"></canvas>
                    </div>

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
                                    <th scope="col" class="px-6 py-3">Total Registration</th>
                                    <th scope="col" class="px-6 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($competitionsData as $item)
                                    <tr
                                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $loop->iteration + ($competitionsData->currentPage() - 1) * $competitionsData->perPage() }}
                                        </th>
                                        <td class="px-6 py-4 font-semibold">{{ $item->name }}</td>
                                        <td class="px-6 py-4 capitalize">{{ $item->type }}</td>
                                        <td class="px-6 py-4">{{ $item->category->name ?? '-' }}</td>
                                        <td class="px-6 py-4">
                                            {{ \Carbon\Carbon::parse($item->registration_start)->format('d M Y') }}</td>
                                        <td class="px-6 py-4">
                                            {{ \Carbon\Carbon::parse($item->registration_end)->format('d M Y') }}</td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="px-2 py-1 text-xs font-semibold rounded {{ $item->status == 'Open' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' }}">
                                                {{ $item->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center font-bold text-gray-700 dark:text-gray-300">
                                            {{ $item->registrations->count() ?? '-' }}</td>
                                        <td class="px-6 py-4 flex gap-2">
                                            <a href="{{ route('admin.dashboard.registration.detail', $item->id) }}"
                                                class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Detail</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                        <td class="px-6 py-4 text-center" colspan="9">No data available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="mt-4">
                            {{ $competitionsData->links('pagination::tailwind') }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Initialize Datepicker
            flatpickr(".datepicker", {
                dateFormat: "d-m-Y",
                allowInput: false
            });

            // 2. SweetAlert2 Logic
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
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
                        if (result.isConfirmed) form.submit();
                    });
                });
            });

            // 3. Daftar Lomba Specific Chart (Horizontal Bar)
            // Extracting data dynamically from the paginated $competitionsData directly in Blade
            const dlLabels = {!! json_encode(
                collect($competitionsData->items())->map(function ($c) {
                    return $c->name . ' (' . ($c->category->name ?? 'Umum') . ')';
                }),
            ) !!};
            const dlData = {!! json_encode(
                collect($competitionsData->items())->map(function ($c) {
                    return $c->registrations->count();
                }),
            ) !!};
            const dlColors = {!! json_encode(
                collect($competitionsData->items())->map(function ($c) {
                    return $c->status == 'Open' ? 'rgba(16, 185, 129, 0.8)' : 'rgba(239, 68, 68, 0.8)';
                }),
            ) !!};

            new Chart(document.getElementById('daftarLombaChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: dlLabels,
                    datasets: [{
                        label: 'Jumlah Pendaftar',
                        data: dlData,
                        backgroundColor: dlColors,
                        borderWidth: 0,
                        borderRadius: 4
                    }]
                },
                options: {
                    indexAxis: 'y', // Makes it a horizontal bar chart
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                afterLabel: function(context) {
                                    const rawColors = context.dataset.backgroundColor;
                                    const color = rawColors[context.dataIndex];
                                    return color === 'rgba(16, 185, 129, 0.8)' ? 'Status: Open' :
                                        'Status: Closed';
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush
