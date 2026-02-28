{{-- Custom Style untuk Animasi Navbar --}}
<style>
    /* Animasi garis bawah pada link desktop */
    .nav-link {
        position: relative;
        color: #4b5563;
        /* text-gray-600 */
        font-weight: 600;
        transition: color 0.3s ease;
    }

    .nav-link:hover {
        color: #1D6594;
    }

    .nav-link::after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        bottom: -4px;
        left: 50%;
        background-color: #E9AA14;
        transition: all 0.3s ease-in-out;
        transform: translateX(-50%);
        border-radius: 2px;
    }

    .nav-link:hover::after {
        width: 100%;
    }

    /* Styling link menu mobile */
    .mobile-nav-link {
        display: block;
        padding: 0.75rem 1rem;
        color: #4b5563;
        font-weight: 600;
        border-radius: 0.5rem;
        transition: all 0.2s ease;
    }

    .mobile-nav-link:hover {
        background-color: #f3f4f6;
        /* bg-gray-100 */
        color: #1D6594;
        padding-left: 1.5rem;
        /* Efek geser ke kanan sedikit saat dihover */
    }
</style>

{{-- ==============================
         NAVBAR SECTION
       ============================== --}}
<nav id="main-nav"
    class="fixed w-full z-50 top-0 left-0 transition-all duration-300 bg-white/90 backdrop-blur-md shadow-sm border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center transition-all duration-300 h-20" id="nav-container">

            <a href="/" class="flex items-center gap-2 group">
                <img src="{{ asset('assets/images/logo_only.png') }}"
                    class="h-12 md:h-14 object-contain transition-transform duration-300 group-hover:scale-105"
                    alt="Al Ihsaan Logo" />
            </a>

            <div class="hidden md:flex items-center space-x-8">
                <a href="/" class="nav-link">Home</a>
                <a href="#lomba" class="nav-link">Lomba</a>
                <a href="#khitanan-massal" class="nav-link">Khitanan Massal</a>
                <a href="#sponsorship" class="nav-link">Sponsorship</a>
                <a href="#contact-us" class="nav-link">Contact Us</a>
            </div>

            <div class="hidden md:flex items-center space-x-4">
                @if (auth()->check())
                    <a href="{{ auth()->user()->role == 'admin' ? route('admin.dashboard') : route('user.dashboard') }}"
                        class="px-5 py-2 text-[#1D6594] border-2 border-[#1D6594] font-bold rounded-full hover:bg-blue-50 transition-colors">
                        Dashboard
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit"
                            class="px-5 py-2.5 bg-red-500 text-white font-bold rounded-full hover:bg-red-600 shadow-md hover:shadow-lg transition-all hover:-translate-y-0.5">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                        class="text-[#1D6594] font-bold hover:text-[#154d73] transition-colors">
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                        class="px-6 py-2.5 bg-[#1D6594] text-white font-bold rounded-full hover:bg-[#154d73] shadow-md hover:shadow-lg transition-all hover:-translate-y-0.5">
                        Daftar
                    </a>
                @endif
            </div>

            <div class="md:hidden flex items-center">
                <button id="mobile-menu-btn"
                    class="text-gray-600 hover:text-[#1D6594] focus:outline-none p-2 relative w-10 h-10">
                    <span class="sr-only">Open main menu</span>
                    <div class="block w-6 absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2">
                        <span aria-hidden="true"
                            class="block absolute h-0.5 w-6 bg-current transform transition duration-300 ease-in-out -translate-y-2"
                            id="line-1"></span>
                        <span aria-hidden="true"
                            class="block absolute h-0.5 w-6 bg-current transform transition duration-300 ease-in-out"
                            id="line-2"></span>
                        <span aria-hidden="true"
                            class="block absolute h-0.5 w-6 bg-current transform transition duration-300 ease-in-out translate-y-2"
                            id="line-3"></span>
                    </div>
                </button>
            </div>

        </div>
    </div>

    <div id="mobile-menu"
        class="md:hidden overflow-hidden transition-all duration-300 ease-in-out max-h-0 opacity-0 bg-white border-t border-gray-100 shadow-xl">
        <div class="px-4 pt-2 pb-6 flex flex-col space-y-1">
            <a href="/" class="mobile-nav-link">Home</a>
            <a href="#lomba" class="mobile-nav-link">Lomba</a>
            <a href="#khitanan-massal" class="mobile-nav-link">Khitanan Massal</a>
            <a href="#donor-darah" class="mobile-nav-link">Donor Darah</a>
            <a href="#sponsorship" class="mobile-nav-link">Sponsorship</a>
            <a href="#contact-us" class="mobile-nav-link">Contact Us</a>

            <div class="border-t border-gray-100 pt-4 mt-2 flex flex-col gap-3">
                @if (auth()->check())
                    <a href="{{ auth()->user()->role == 'admin' ? route('admin.dashboard') : route('user.dashboard') }}"
                        class="w-full text-center border-2 border-[#1D6594] text-[#1D6594] font-bold py-2.5 rounded-full">
                        Dashboard
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="m-0 w-full">
                        @csrf
                        <button type="submit"
                            class="w-full text-center bg-red-500 text-white font-bold py-2.5 rounded-full shadow-md">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                        class="w-full text-center border-2 border-[#1D6594] text-[#1D6594] font-bold py-2.5 rounded-full hover:bg-blue-50 transition-colors">
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                        class="w-full text-center bg-[#1D6594] text-white font-bold py-2.5 rounded-full shadow-md hover:bg-[#154d73] transition-colors">
                        Daftar Sekarang
                    </a>
                @endif
            </div>
        </div>
    </div>
</nav>

{{-- Script Interaktif Navbar --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');
        const line1 = document.getElementById('line-1');
        const line2 = document.getElementById('line-2');
        const line3 = document.getElementById('line-3');

        const navContainer = document.getElementById('nav-container');
        const mainNav = document.getElementById('main-nav');

        let isMenuOpen = false;

        // 1. Toggle Mobile Menu & Hamburger Animation
        btn.addEventListener('click', function() {
            isMenuOpen = !isMenuOpen;

            if (isMenuOpen) {
                // Buka Menu
                menu.classList.remove('max-h-0', 'opacity-0');
                menu.classList.add('max-h-[500px]',
                'opacity-100'); // max-h harus lebih besar dari tinggi konten

                // Animasi Icon jadi 'X'
                line1.classList.add('rotate-45', 'translate-y-0');
                line1.classList.remove('-translate-y-2');
                line2.classList.add('opacity-0');
                line3.classList.add('-rotate-45', 'translate-y-0');
                line3.classList.remove('translate-y-2');
            } else {
                // Tutup Menu
                menu.classList.remove('max-h-[500px]', 'opacity-100');
                menu.classList.add('max-h-0', 'opacity-0');

                // Animasi Icon kembali ke Hamburger
                line1.classList.remove('rotate-45', 'translate-y-0');
                line1.classList.add('-translate-y-2');
                line2.classList.remove('opacity-0');
                line3.classList.remove('-rotate-45', 'translate-y-0');
                line3.classList.add('translate-y-2');
            }
        });

        // Tutup menu saat link di klik (untuk HP)
        const mobileLinks = document.querySelectorAll('.mobile-nav-link');
        mobileLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (isMenuOpen) btn.click();
            });
        });

        // 2. Efek Navbar mengecil saat di-scroll
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                // Saat discroll ke bawah
                navContainer.classList.remove('h-20');
                navContainer.classList.add('h-16');
                mainNav.classList.add('shadow-md');
            } else {
                // Saat di paling atas
                navContainer.classList.add('h-20');
                navContainer.classList.remove('h-16');
                mainNav.classList.remove('shadow-md');
            }
        });
    });
</script>
