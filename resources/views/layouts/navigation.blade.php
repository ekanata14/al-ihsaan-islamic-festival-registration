<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-center md:justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('admin.dashboard') }}">
                        <img src="{{ asset('assets/images/logo_only.png') }}" class="w-10" alt="logo">
                    </a>
                </div>
                @if (auth()->user()->role == 'admin')
                    <!-- Navigation Links -->
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.dashboard.user')" :active="request()->routeIs('admin.dashboard.user*')">
                            {{ __('User') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.dashboard.group')" :active="request()->routeIs('admin.dashboard.group*')">
                            {{ __('Group') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.dashboard.category')" :active="request()->routeIs('admin.dashboard.category*')">
                            {{ __('Category') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.dashboard.competition')" :active="request()->routeIs('admin.dashboard.competition*')">
                            {{ __('Competition') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.dashboard.registration')" :active="request()->routeIs('admin.dashboard.registration*')">
                            {{ __('Registration') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.dashboard.check-in')" :active="request()->routeIs('admin.dashboard.check-in*')">
                            {{ __('Check In') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.dashboard.sponsor')" :active="request()->routeIs('admin.dashboard.sponsor*')">
                            {{ __('Sponsor') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.dashboard.khitan-registration')" :active="request()->routeIs('admin.dashboard.khitan-registration*')">
                            {{ __('Khitan') }}
                        </x-nav-link>
                    </div>
                    <!-- Bottom Navbar for Mobile -->
                    <div
                        class="fixed bottom-0 left-0 right-0 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 sm:hidden py-4 box-border z-50">
                        <div class="flex justify-around py-2">
                            <a href="{{ route('admin.dashboard') }}"
                                class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 {{ request()->routeIs('admin.dashboard') ? 'text-blue-500' : '' }} flex flex-col justify-start items-center">
                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M11.293 3.293a1 1 0 0 1 1.414 0l6 6 2 2a1 1 0 0 1-1.414 1.414L19 12.414V19a2 2 0 0 1-2 2h-3a1 1 0 0 1-1-1v-3h-2v3a1 1 0 0 1-1 1H7a2 2 0 0 1-2-2v-6.586l-.293.293a1 1 0 0 1-1.414-1.414l2-2 6-6Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                            <div class="relative">
                                <button id="manageMenuButton"
                                    class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none flex justify-center items-center">
                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-width="2"
                                            d="M7 17v1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </button>
                                <div id="manageMenu"
                                    class="absolute left-2 mt-2 w-40 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-md shadow-lg hidden bottom-10">
                                    <a href="{{ route('admin.dashboard.user') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-900 {{ request()->routeIs('admin.dashboard.user*') ? 'bg-gray-100 dark:bg-gray-900' : '' }}">
                                        {{ __('User') }}
                                    </a>
                                    <a href="{{ route('admin.dashboard.group') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-900 {{ request()->routeIs('admin.dashboard.group*') ? 'bg-gray-100 dark:bg-gray-900' : '' }}">
                                        {{ __('Group') }}
                                    </a>
                                    <a href="{{ route('admin.dashboard.category') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-900 {{ request()->routeIs('admin.dashboard.category*') ? 'bg-gray-100 dark:bg-gray-900' : '' }}">
                                        {{ __('Category') }}
                                    </a>
                                </div>
                            </div>
                            <script>
                                const manageMenuButton = document.getElementById('manageMenuButton');
                                const manageMenu = document.getElementById('manageMenu');

                                manageMenuButton.addEventListener('click', () => {
                                    manageMenu.classList.toggle('hidden');
                                });

                                document.addEventListener('click', (event) => {
                                    if (!manageMenu.contains(event.target) && !manageMenuButton.contains(event.target)) {
                                        manageMenu.classList.add('hidden');
                                    }
                                });
                            </script>
                            <a href="#" id="scanQrCode"
                                class="bg-blue-500 text-white hover:bg-blue-600 rounded-full p-2 flex flex-col justify-center items-center">
                                <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4h6v6H4V4Zm10 10h6v6h-6v-6Zm0-10h6v6h-6V4Zm-4 10h.01v.01H10V14Zm0 4h.01v.01H10V18Zm-3 2h.01v.01H7V20Zm0-4h.01v.01H7V16Zm-3 2h.01v.01H4V18Zm0-4h.01v.01H4V14Z" />
                                    <path stroke="currentColor" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h.01v.01H7V7Zm10 10h.01v.01H17V17Z" />
                                </svg>
                            </a>

                            <!-- Modal -->
                            <div id="qrModal"
                                class="hidden fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50">
                                <div class="bg-white rounded-lg shadow-lg p-4 w-full max-w-md">
                                    <div class="flex justify-between items-center mb-4">
                                        <h2 class="text-lg font-semibold">Scan QR Code</h2>
                                        <button id="closeQrModal"
                                            class="text-gray-500 hover:text-gray-700">&times;</button>
                                    </div>
                                    <div id="loadingSpinner" class="flex justify-center items-center mb-4">
                                        <svg class="animate-spin h-8 w-8 text-gray-500"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z">
                                            </path>
                                        </svg>
                                    </div>
                                    <video id="qrVideo" class="w-full border border-gray-300 rounded hidden"></video>
                                </div>
                            </div>

                            <script>
                                const scanQrCodeButton = document.getElementById('scanQrCode');
                                const qrModal = document.getElementById('qrModal');
                                const closeQrModalButton = document.getElementById('closeQrModal');
                                const video = document.getElementById('qrVideo');
                                const loadingSpinner = document.getElementById('loadingSpinner');
                                let qrScanner;

                                scanQrCodeButton.addEventListener('click', async () => {
                                    qrModal.classList.remove('hidden');
                                    loadingSpinner.classList.remove('hidden');
                                    video.classList.add('hidden');

                                    if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            text: 'Camera access is not supported by your browser.',
                                            showConfirmButton: true
                                        });
                                        return;
                                    }

                                    try {
                                        const stream = await navigator.mediaDevices.getUserMedia({
                                            video: {
                                                facingMode: 'environment'
                                            }
                                        });
                                        video.srcObject = stream;
                                        video.setAttribute('playsinline', true); // Required for iOS
                                        video.play();

                                        video.addEventListener('loadeddata', () => {
                                            loadingSpinner.classList.add('hidden');
                                            video.classList.remove('hidden');
                                        });

                                        qrScanner = new QrScanner(video, async result => {
                                            // Swal.fire({
                                            //     icon: 'success',
                                            //     title: 'QR Code Scanned',
                                            //     text: `QR Code Data: ${result}`,
                                            //     showConfirmButton: true
                                            // });

                                            try {
                                                const response = await fetch(
                                                    '{{ route('admin.dashboard.check-in.store.qr') }}', {
                                                        method: 'POST',
                                                        headers: {
                                                            'Content-Type': 'application/json',
                                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                        },
                                                        body: JSON.stringify({
                                                            registration_number: result
                                                        })
                                                    });

                                                const data = await response.json();

                                                if (data.success) {
                                                    Swal.fire({
                                                        icon: 'success',
                                                        title: 'Success',
                                                        text: data.message,
                                                        showConfirmButton: false,
                                                        timer: 2000,,
                                                    });
                                                    setTimeout(() => {
                                                        window.location.href = data.redirect;
                                                    }, 2000);
                                                } else {
                                                    Swal.fire({
                                                        icon: 'error',
                                                        title: 'Error',
                                                        text: data.message || 'An error occurred.',
                                                        showConfirmButton: true
                                                    });
                                                }
                                            } catch (error) {
                                                console.error('Error processing QR code:', error);
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Error',
                                                    text: 'An error occurred while processing the QR code.',
                                                    showConfirmButton: true
                                                });
                                            }

                                            qrScanner.stop();
                                            video.srcObject.getTracks().forEach(track => track.stop());
                                            qrModal.classList.add('hidden');
                                        });
                                        qrScanner.start();
                                    } catch (error) {
                                        console.error('Error accessing camera:', error);
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            text: 'Unable to access the camera.',
                                            showConfirmButton: true
                                        });
                                    }
                                });

                                closeQrModalButton.addEventListener('click', () => {
                                    if (qrScanner) {
                                        qrScanner.stop();
                                    }
                                    if (video.srcObject) {
                                        video.srcObject.getTracks().forEach(track => track.stop());
                                    }
                                    qrModal.classList.add('hidden');
                                });

                                class QrScanner {
                                    constructor(video, onDecode) {
                                        this.video = video;
                                        this.onDecode = onDecode;
                                        this.canvas = document.createElement('canvas');
                                        this.context = this.canvas.getContext('2d');
                                        this.active = false;
                                    }

                                    start() {
                                        this.active = true;
                                        this.scan();
                                    }

                                    stop() {
                                        this.active = false;
                                        const stream = this.video.srcObject;
                                        if (stream) {
                                            stream.getTracks().forEach(track => track.stop());
                                        }
                                        this.video.srcObject = null;
                                    }

                                    scan() {
                                        if (!this.active) return;

                                        if (this.video.readyState === this.video.HAVE_ENOUGH_DATA) {
                                            this.canvas.width = this.video.videoWidth;
                                            this.canvas.height = this.video.videoHeight;
                                            this.context.drawImage(this.video, 0, 0, this.canvas.width, this.canvas.height);

                                            const imageData = this.context.getImageData(0, 0, this.canvas.width, this.canvas.height);
                                            const code = jsQR(imageData.data, imageData.width, imageData.height);

                                            if (code) {
                                                this.onDecode(code.data);
                                                return;
                                            }
                                        }

                                        requestAnimationFrame(() => this.scan());
                                    }
                                }
                            </script>
                            <script src="https://cdn.jsdelivr.net/npm/jsqr/dist/jsQR.min.js"></script>
                            <a href="{{ route('admin.dashboard.competition') }}"
                                class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 {{ request()->routeIs('admin.dashboard.competition*') ? 'text-blue-500' : '' }}">
                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="m7.171 12.906-2.153 6.411 2.672-.89 1.568 2.34 1.825-5.183m5.73-2.678 2.154 6.411-2.673-.89-1.568 2.34-1.825-5.183M9.165 4.3c.58.068 1.153-.17 1.515-.628a1.681 1.681 0 0 1 2.64 0 1.68 1.68 0 0 0 1.515.628 1.681 1.681 0 0 1 1.866 1.866c-.068.58.17 1.154.628 1.516a1.681 1.681 0 0 1 0 2.639 1.682 1.682 0 0 0-.628 1.515 1.681 1.681 0 0 1-1.866 1.866 1.681 1.681 0 0 0-1.516.628 1.681 1.681 0 0 1-2.639 0 1.681 1.681 0 0 0-1.515-.628 1.681 1.681 0 0 1-1.867-1.866 1.681 1.681 0 0 0-.627-1.515 1.681 1.681 0 0 1 0-2.64c.458-.361.696-.935.627-1.515A1.681 1.681 0 0 1 9.165 4.3ZM14 9a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z" />
                                </svg>
                            </a>
                            <div class="relative">
                                <button id="manageMenuButtonRegister"
                                    class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none flex justify-center items-center">
                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M18 5V4a1 1 0 0 0-1-1H8.914a1 1 0 0 0-.707.293L4.293 7.207A1 1 0 0 0 4 7.914V20a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-5M9 3v4a1 1 0 0 1-1 1H4m11.383.772 2.745 2.746m1.215-3.906a2.089 2.089 0 0 1 0 2.953l-6.65 6.646L9 17.95l.739-3.692 6.646-6.646a2.087 2.087 0 0 1 2.958 0Z" />
                                    </svg>
                                </button>
                                <div id="manageMenuRegister"
                                    class="absolute right-1 mt-2 w-40 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-md shadow-lg hidden bottom-14">
                                    <a href="{{ route('admin.dashboard.registration') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-900 {{ request()->routeIs('admin.dashboard.user*') ? 'bg-gray-100 dark:bg-gray-900' : '' }}">
                                        {{ __('Lomba') }}
                                    </a>
                                    <a href="{{ route('admin.dashboard.khitan-registration') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-900 {{ request()->routeIs('admin.dashboard.group*') ? 'bg-gray-100 dark:bg-gray-900' : '' }}">
                                        {{ __('Khitan') }}
                                    </a>
                                </div>
                            </div>
                            <script>
                                const manageMenuButtonRegister = document.getElementById('manageMenuButtonRegister');
                                const manageMenuRegister = document.getElementById('manageMenuRegister');

                                manageMenuButtonRegister.addEventListener('click', () => {
                                    manageMenuRegister.classList.toggle('hidden');
                                });

                                document.addEventListener('click', (event) => {
                                    if (!manageMenuRegister.contains(event.target) && !manageMenuButtonRegister.contains(event.target)) {
                                        manageMenuRegister.classList.add('hidden');
                                    }
                                });
                            </script>
                        </div>
                    </div>
                @endif

                @if (auth()->user()->role == 'user')
                    <!-- Navigation Links -->
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <x-nav-link :href="route('user.dashboard')" :active="request()->routeIs('user.dashboard*')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('user.participants')" :active="request()->routeIs('user.participants*')">
                            {{ __('Data Registrasi') }}
                        </x-nav-link>
                        <x-nav-link :href="route('khitan.dashboard')" :active="request()->routeIs('khitan.dashboard*')">
                            {{ __('Khitan') }}
                        </x-nav-link>
                    </div>
                @endif
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            {{-- <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div> --}}
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @if (auth()->user()->role == 'admin')
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
            @endif
            @if (auth()->user()->role == 'user')
                <x-responsive-nav-link :href="route('user.dashboard')" :active="request()->routeIs('user.dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('user.participants')" :active="request()->routeIs('user.participants*')">
                    {{ __('Data Registrasi') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
