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
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex gap-2">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ $title }}
                </h2>
            </div>
        </header>

        <!-- Page Content -->
        <main>
            @yield('content')
            <div class="mb-20"></div>
            @if (auth()->user()->role == 'user')
                <div class="fixed bottom-0 left-0 w-full bg-white dark:bg-gray-800 shadow-lg flex justify-around py-4">
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

                        <span class="text-sm {{ request()->routeIs('user.dashboard') ? 'text-blue-500' : '' }}">Daftar
                            Lomba</span>
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
                            class="text-sm {{ request()->routeIs('user.participants') ? 'text-red-500' : '' }}">Peserta
                            Anda</span>
                    </a>
                    <button id="contactPerson"
                        class="flex flex-col items-center text-gray-700 dark:text-gray-200 hover:text-green-500">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path d="M16 10c0-.55228-.4477-1-1-1h-3v2h3c.5523 0 1-.4477 1-1Z" />
                            <path
                                d="M13 15v-2h2c1.6569 0 3-1.3431 3-3 0-1.65685-1.3431-3-3-3h-2.256c.1658-.46917.256-.97405.256-1.5 0-.51464-.0864-1.0091-.2454-1.46967C12.8331 4.01052 12.9153 4 13 4h7c.5523 0 1 .44772 1 1v9c0 .5523-.4477 1-1 1h-2.5l1.9231 4.6154c.2124.5098-.0287 1.0953-.5385 1.3077-.5098.2124-1.0953-.0287-1.3077-.5385L15.75 16l-1.827 4.3846c-.1825.438-.6403.6776-1.0889.6018.1075-.3089.1659-.6408.1659-.9864v-2.6002L14 15h-1ZM6 5.5C6 4.11929 7.11929 3 8.5 3S11 4.11929 11 5.5 9.88071 8 8.5 8 6 6.88071 6 5.5Z" />
                            <path
                                d="M15 11h-4v9c0 .5523-.4477 1-1 1-.55228 0-1-.4477-1-1v-4H8v4c0 .5523-.44772 1-1 1s-1-.4477-1-1v-6.6973l-1.16797 1.752c-.30635.4595-.92722.5837-1.38675.2773-.45952-.3063-.5837-.9272-.27735-1.3867l2.99228-4.48843c.09402-.14507.2246-.26423.37869-.34445.11427-.05949.24148-.09755.3763-.10887.03364-.00289.06747-.00408.10134-.00355H15c.5523 0 1 .44772 1 1 0 .5523-.4477 1-1 1Z" />
                        </svg>
                        <span class="text-sm">Contact Person</span>
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
                    timer: 3000
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
                    timer: 3000
                });
            </script>
        @endif
    </div>
</body>

</html>
