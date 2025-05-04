<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Al Ihsaan Islamic Festival</title>

    <!-- Fonts -->
    <link rel="icon" href="{{ asset('assets/images/logo_only.png') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>

<body class="font-sans antialiased">
    <nav class="bg-white border-gray-200 dark:bg-gray-900 fixed w-full z-20 top-0 left-0 border-b dark:border-gray-600">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="https://flowbite.com/" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="{{ asset('assets/images/logo_only.png') }}" class="h-20" alt="Flowbite Logo" />
            </a>
            <button data-collapse-toggle="navbar-default" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                aria-controls="navbar-default" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>
            <div class="hidden w-full md:block md:w-auto" id="navbar-default">
                <ul
                    class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700 justify-center items-center">
                    <li>
                        <a href="/"
                            class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Home</a>
                    </li>
                    <li>
                        <a href="#lomba"
                            class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Lomba</a>
                    </li>
                    <li>
                        <a href="#khitanan-massal"
                            class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Khitanan
                            Massal</a>
                    </li>
                    <li>
                        <a href="#donor-darah"
                            class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Donor
                            Darah</a>
                    </li>
                    <li>
                        <a href="#sponsorship"
                            class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Sponsorship</a>
                    </li>
                    <li>
                        <a href="#contact-us"
                            class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Contact
                            Us</a>
                    </li>
                    <li class="flex gap-2">
                        @if (auth()->user())
                            @if (auth()->user()->role == 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="btn-primary">Dashboard</a>
                            @else
                                <a href="{{ route('user.dashboard') }}" class="btn-primary">Dashboard</a>
                            @endif
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-red">Logout</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="btn-primary">Login</a>
                            <a href="{{ route('register') }}" class="btn-green">Daftar</a>
                        @endif
                    </li>
                </ul>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const toggleButton = document.querySelector('[data-collapse-toggle]');
                    const navbar = document.getElementById('navbar-default');
                    const body = document.body;

                    // Toggle navbar visibility
                    toggleButton.addEventListener('click', function(event) {
                        navbar.classList.toggle('hidden');
                        navbar.classList.toggle('animate-slide-down');
                    });

                    // Close navbar when clicking outside
                    body.addEventListener('click', function(event) {
                        if (!navbar.contains(event.target) && !toggleButton.contains(event.target)) {
                            if (!navbar.classList.contains('hidden')) {
                                navbar.classList.add('animate-fade-out');
                                setTimeout(() => {
                                    navbar.classList.add('hidden');
                                    navbar.classList.remove('animate-fade-out');
                                }, 300); // Match the animation duration
                            }
                        }
                    });
                });

                // Add animation styles
                const style = document.createElement('style');
                style.innerHTML = `
        @keyframes slide-down {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @keyframes fade-out {
            from {
                opacity: 1;
            }
            to {
                opacity: 0;
            }
        }
        .animate-slide-down {
            animation: slide-down 0.3s ease-out;
        }
        .animate-fade-out {
            animation: fade-out 0.3s ease-out;
        }
    `;
                document.head.appendChild(style);
            </script>
        </div>
    </nav>
    <main>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                @yield('content')
            </div>
        </div>
    </main>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 2000
            });
        });
    </script>
</body>

</html>
