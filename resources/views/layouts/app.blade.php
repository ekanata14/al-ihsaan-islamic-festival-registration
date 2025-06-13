<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="{{ asset('assets/images/logo_only.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        @include('layouts.navigation')

        <!-- Page Heading -->
        <header class="bg-white dark:bg-gray-800 shadow">
            <div
                class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ $title }}
                </h2>
                @if (auth()->user()->role == 'admin')
                    <form class="w-full md:w-96" method="GET" action="{{ route('admin.dashboard.search') }}">
                        <label for="default-search"
                            class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                </svg>
                            </div>
                            <input type="search" id="default-search"
                                class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Search Participants" required name="search"
                                value="{{ old('search', request('search')) }}" />
                            <button type="submit"
                                class="text-white absolute right-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
                        </div>
                    </form>
                @endif
            </div>
        </header>

        <!-- Page Content -->
        <main>
            @yield('content')
            @if (auth()->user()->role == 'user')
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        if (!localStorage.getItem('whatsappModalShown')) {
                            setTimeout(() => {
                                Swal.fire({
                                    title: 'Bergabung dengan Grup WhatsApp Kami',
                                    text: 'Klik tombol di bawah ini untuk bergabung dengan grup WhatsApp kami dan dapatkan informasi serta pembaruan terkini.',
                                    icon: 'info',
                                    showCancelButton: true,
                                    confirmButtonText: 'Grup Lomba',
                                    cancelButtonText: 'Close',
                                    customClass: {
                                        confirmButton: 'bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded',
                                        cancelButton: 'bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded'
                                    }
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.open('https://chat.whatsapp.com/Hi9IYZYEknYCMpF5mXayuN',
                                            '_blank');
                                    }
                                });
                                localStorage.setItem('whatsappModalShown', 'true');
                            }, 0); // Show modal immediately
                        }
                    });
                </script>
            @endif
            <div class="mb-20"></div>
            @if (auth()->user()->role == 'user' || auth()->user()->role == 'khitan')
                <div
                    class="fixed bottom-0 left-0 w-full bg-white dark:bg-gray-800 shadow-lg flex justify-around py-4 text-sm">
                    @if (auth()->user()->role == 'user')
                        <a href="{{ route('user.dashboard') }}"
                            class="flex flex-col items-center text-gray-700 dark:text-gray-200 hover:text-blue-500 {{ request()->routeIs('user.dashboard*') ? 'text-blue-500' : '' }}">
                            <svg class="w-6 h-6 {{ request()->routeIs('user.dashboard') ? 'text-blue-500' : 'text-gray-800 dark:text-white' }}"
                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                fill="currentColor" viewBox="0 0 24 24">
                                <path d="M11 9a1 1 0 1 1 2 0 1 1 0 0 1-2 0Z" />
                                <path fill-rule="evenodd"
                                    d="M9.896 3.051a2.681 2.681 0 0 1 4.208 0c.147.186.38.282.615.255a2.681 2.681 0 0 1 2.976 2.975.681.681 0 0 0 .254.615 2.681 2.681 0 0 1 0 4.208.682.682 0 0 0-.254.615 2.681 2.681 0 0 1-2.976 2.976.681.681 0 0 0-.615.254 2.682 2.682 0 0 1-4.208 0 .681.681 0 0 0-.614-.255 2.681 2.681 0 0 1-2.976-2.975.681.681 0 0 0-.255-.615 2.681 2.681 0 0 1 0-4.208.681.681 0 0 0 .255-.615 2.681 2.681 0 0 1 2.976-2.975.681.681 0 0 0 .614-.255ZM12 6a3 3 0 1 0 0 6 3 3 0 0 0 0-6Z"
                                    clip-rule="evenodd" />
                                <path
                                    d="M5.395 15.055 4.07 19a1 1 0 0 0 1.264 1.267l1.95-.65 1.144 1.707A1 1 0 0 0 10.2 21.1l1.12-3.18a4.641 4.641 0 0 1-2.515-1.208 4.667 4.667 0 0 1-3.411-1.656Zm7.269 2.867 1.12 3.177a1 1 0 0 0 1.773.224l1.144-1.707 1.95.65A1 1 0 0 0 19.915 19l-1.32-3.93a4.667 4.667 0 0 1-3.4 1.642 4.643 4.643 0 0 1-2.53 1.21Z" />
                            </svg>

                            <span
                                class="text-sm {{ request()->routeIs('user.dashboard') ? 'text-blue-500' : '' }}">Lomba</span>
                        </a>
                        <a href="{{ route('user.participants') }}"
                            class="flex flex-col items-center text-gray-700 dark:text-gray-200 hover:text-red-500 {{ request()->routeIs('user.participants*') ? 'text-red-500' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6 {{ request()->routeIs('user.participants') ? 'text-red-500' : '' }}"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M5.121 17.804A3.5 3.5 0 018.5 16h7a3.5 3.5 0 013.379 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11V9a3 3 0 00-6 0v2" />
                            </svg>
                            <span
                                class="text-sm {{ request()->routeIs('user.participants') ? 'text-red-500' : '' }}">Peserta</span>
                        </a>
                    @endif
                    <a href="{{ route('khitan.dashboard') }}"
                        class="flex flex-col items-center text-gray-700 dark:text-gray-200 hover:text-red-500 {{ request()->routeIs('khitan.dashboard*') ? 'text-red-500' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6 {{ request()->routeIs('khitan.dashboard*') ? 'text-red-500' : '' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M5.121 17.804A3.5 3.5 0 018.5 16h7a3.5 3.5 0 013.379 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11V9a3 3 0 00-6 0v2" />
                        </svg>
                        <span
                            class="text-sm {{ request()->routeIs('khitan.dashboard*') ? 'text-red-500' : '' }}">Khitan</span>
                    </a>
                    <button type="button" id="dropdownMenuButton" data-dropdown-toggle="dropdownMenu"
                        class="flex flex-col items-center text-gray-700 dark:text-gray-200 hover:text-green-500 cursor-pointer">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                d="M12 0C5.372 0 0 5.373 0 12c0 2.123.553 4.193 1.6 6.033L0 24l6.15-1.567C8.007 23.448 10.003 24 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm6.16 17.19c-.25.7-1.45 1.34-2.01 1.43-.53.08-1.17.12-1.89-.12-.44-.15-1.01-.33-1.74-.65-3.07-1.33-5.07-4.42-5.23-4.63-.15-.2-1.25-1.66-1.25-3.17 0-1.5.79-2.24 1.07-2.55.28-.31.62-.39.83-.39.2 0 .42.01.6.01.19 0 .45-.07.7.54.25.61.85 2.1.92 2.25.07.15.12.33.02.53-.1.2-.15.32-.3.5-.15.18-.31.4-.45.54-.15.15-.3.31-.13.6.17.3.76 1.25 1.63 2.02 1.12.99 2.06 1.3 2.36 1.45.3.15.47.13.65-.08.18-.2.75-.87.95-1.17.2-.3.4-.25.68-.15.28.1 1.77.84 2.08.99.31.15.52.23.6.36.08.13.08.74-.18 1.44z" />
                        </svg>
                        <span class="text-sm">Grup</span>
                    </button>

                    <!-- Dropdown Menu -->
                    <div id="dropdownMenu"
                        class="hidden absolute bg-white dark:bg-gray-800 shadow-lg rounded-lg py-2 w-48 z-50 bottom-16">
                        <a href="https://chat.whatsapp.com/Hi9IYZYEknYCMpF5mXayuN" target="_blank"
                            class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                            Grup Lomba
                        </a>
                        <a href="https://chat.whatsapp.com/Hi9IYZYEknYCMpF5mXayuN" target="_blank"
                            class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                            Grup Khitan
                        </a>
                    </div>

                    <!-- Dropdown Script -->
                    <script>
                        const dropdownButton = document.getElementById('dropdownMenuButton');
                        const dropdownMenu = document.getElementById('dropdownMenu');

                        dropdownButton.addEventListener('click', () => {
                            dropdownMenu.classList.toggle('hidden');
                        });

                        document.addEventListener('click', (event) => {
                            if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                                dropdownMenu.classList.add('hidden');
                            }
                        });
                    </script>
                    <button id="contactPerson"
                        class="flex flex-col items-center text-gray-700 dark:text-gray-200 hover:text-green-500">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                d="M12 0C5.372 0 0 5.373 0 12c0 2.123.553 4.193 1.6 6.033L0 24l6.15-1.567C8.007 23.448 10.003 24 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm6.16 17.19c-.25.7-1.45 1.34-2.01 1.43-.53.08-1.17.12-1.89-.12-.44-.15-1.01-.33-1.74-.65-3.07-1.33-5.07-4.42-5.23-4.63-.15-.2-1.25-1.66-1.25-3.17 0-1.5.79-2.24 1.07-2.55.28-.31.62-.39.83-.39.2 0 .42.01.6.01.19 0 .45-.07.7.54.25.61.85 2.1.92 2.25.07.15.12.33.02.53-.1.2-.15.32-.3.5-.15.18-.31.4-.45.54-.15.15-.3.31-.13.6.17.3.76 1.25 1.63 2.02 1.12.99 2.06 1.3 2.36 1.45.3.15.47.13.65-.08.18-.2.75-.87.95-1.17.2-.3.4-.25.68-.15.28.1 1.77.84 2.08.99.31.15.52.23.6.36.08.13.08.74-.18 1.44z" />
                        </svg>
                        <span class="text-sm">Panitia</span>
                    </button>
                </div>
                <!-- Modal -->
                <div id="contactModal"
                    class="hidden fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50">
                    <div class="bg-white rounded-lg shadow-lg p-4 w-full max-w-md">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-lg font-semibold">Contact Persons</h2>
                            <button id="closeContactModal" class="text-gray-500 hover:text-gray-700">&times;</button>
                        </div>
                        <p class="text-gray-700">Hubungi kontak di bawah untuk informasi lebih lanjut</p>
                        <ul class="mt-4 space-y-4">
                            <li>
                                <p class="font-semibold">Fauzan</p>
                                <a href="https://wa.me/+6281952476416" target="_blank"
                                    class="block bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-center">
                                    Chat on WhatsApp
                                </a>
                            </li>
                            <li>
                                <p class="font-semibold">Atha</p>
                                <a href="https://wa.me/+6287858741020" target="_blank"
                                    class="block bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-center">
                                    Chat on WhatsApp
                                </a>
                            </li>
                            <li>
                                <p class="font-semibold">Syawala</p>
                                <a href="https://wa.me/+6281237495718" target="_blank"
                                    class="block bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-center">
                                    Chat on WhatsApp
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <script>
                    const contactPersonButton = document.getElementById('contactPerson');
                    const contactModal = document.getElementById('contactModal');
                    const closeContactModalButton = document.getElementById('closeContactModal');

                    contactPersonButton.addEventListener('click', () => {
                        contactModal.classList.remove('hidden');
                    });

                    closeContactModalButton.addEventListener('click', () => {
                        contactModal.classList.add('hidden');
                    });
                </script>
            @endif
        </main>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('success') }}',
                    showConfirmButton: true,
                });
            </script>
        @endif

        @if (session('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session('error') }}',
                    showConfirmButton: true,
                });
            </script>
        @endif
    </div>
</body>

</html>
