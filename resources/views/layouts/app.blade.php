<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Al Ihsaan Festival') }}</title>
    <link rel="icon" href="{{ asset('assets/images/logo_only.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>

<body class="font-sans antialiased text-gray-900 bg-gray-50 overflow-x-hidden" x-data="{ sidebarOpen: false }">

    @include('layouts.partials.app.navigation')

    <div class="flex-1 flex flex-col min-h-screen transition-all duration-300 lg:ml-64">

        <header
            class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-4 sm:px-6 lg:px-8 sticky top-0 z-30 shadow-sm">

            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = !sidebarOpen"
                    class="lg:hidden text-gray-500 hover:text-[#1D6594] focus:outline-none p-2 rounded-lg bg-gray-50">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <h2 class="font-bold text-lg sm:text-xl text-gray-800 leading-tight truncate">
                    {{ $title ?? 'Dashboard' }}
                </h2>
            </div>

            <div class="flex items-center gap-3">
                @if (auth()->user()->role == 'admin')
                    <form class="hidden sm:block relative group w-64 md:w-80" method="GET"
                        action="{{ route('admin.dashboard.search') }}">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400 group-focus-within:text-[#1D6594]" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="search" name="search"
                            class="block w-full pl-10 py-2 text-sm text-gray-900 bg-gray-50 border border-gray-200 rounded-full focus:bg-white focus:border-[#1D6594] focus:ring-1 focus:ring-[#1D6594] transition-all"
                            placeholder="Cari No. Registrasi..." value="{{ old('search', request('search')) }}" />
                    </form>

                    <button id="scanQrCode"
                        class="flex items-center justify-center p-2.5 bg-emerald-100 text-emerald-700 hover:bg-emerald-600 hover:text-white rounded-full transition-colors tooltip"
                        title="Scan QR Code">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z">
                            </path>
                        </svg>
                    </button>
                @endif
            </div>
        </header>

        <main class="flex-1 w-full bg-gray-50">
            @yield('content')
        </main>
    </div>

    <div id="contactModal"
        class="hidden fixed inset-0 bg-gray-900/60 backdrop-blur-sm flex items-center justify-center z-[100] p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-sm overflow-hidden">
            <div class="bg-gradient-to-r from-[#1D6594] to-[#154d73] p-5 text-white flex justify-between items-center">
                <h2 class="text-lg font-bold">Hubungi Panitia</h2>
                <button onclick="document.getElementById('contactModal').classList.add('hidden')"
                    class="text-white/70 hover:text-white p-1">&times;</button>
            </div>
            <div class="p-6 space-y-3">
                <a href="https://wa.me/+6281952476416" target="_blank"
                    class="flex items-center gap-3 p-3 bg-gray-50 hover:bg-green-50 border border-gray-100 rounded-2xl transition-colors">
                    <div class="w-10 h-10 bg-green-100 text-green-600 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 14c-2.21 0-4-1.79-4-4h2c0 1.1.9 2 2 2s2-.9 2-2-.9-2-2-2v-2c2.21 0 4 1.79 4 4s-1.79 4-4 4z">
                            </path>
                        </svg>
                    </div>
                    <span class="font-bold text-gray-800">Fauzan</span>
                </a>
                <a href="https://wa.me/+6287858741020" target="_blank"
                    class="flex items-center gap-3 p-3 bg-gray-50 hover:bg-green-50 border border-gray-100 rounded-2xl transition-colors">
                    <div class="w-10 h-10 bg-green-100 text-green-600 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 14c-2.21 0-4-1.79-4-4h2c0 1.1.9 2 2 2s2-.9 2-2-.9-2-2-2v-2c2.21 0 4 1.79 4 4s-1.79 4-4 4z">
                            </path>
                        </svg>
                    </div>
                    <span class="font-bold text-gray-800">Atha</span>
                </a>
                <a href="https://wa.me/+6281237495718" target="_blank"
                    class="flex items-center gap-3 p-3 bg-gray-50 hover:bg-green-50 border border-gray-100 rounded-2xl transition-colors">
                    <div class="w-10 h-10 bg-green-100 text-green-600 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 14c-2.21 0-4-1.79-4-4h2c0 1.1.9 2 2 2s2-.9 2-2-.9-2-2-2v-2c2.21 0 4 1.79 4 4s-1.79 4-4 4z">
                            </path>
                        </svg>
                    </div>
                    <span class="font-bold text-gray-800">Syawala</span>
                </a>
            </div>
        </div>
    </div>

    @if (auth()->user()->role == 'admin')
        <div id="qrModal"
            class="hidden fixed inset-0 bg-gray-900/80 backdrop-blur-sm flex items-center justify-center z-[100] p-4">
            <div class="bg-white rounded-3xl shadow-2xl p-5 w-full max-w-sm">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-bold text-gray-800">Scan QR Code Peserta</h2>
                    <button id="closeQrModal"
                        class="text-gray-400 hover:text-red-500 bg-gray-100 p-2 rounded-lg">&times;</button>
                </div>
                <div id="loadingSpinner" class="flex justify-center py-10">
                    <svg class="animate-spin h-8 w-8 text-[#1D6594]" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                    </svg>
                </div>
                <video id="qrVideo" class="w-full rounded-2xl bg-black hidden object-cover aspect-square"></video>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/jsqr/dist/jsQR.min.js"></script>
        <script>
            // Logika QR Scanner (Sama persis dengan kode Anda, hanya target elemen disesuaikan)
            const scanBtn = document.getElementById('scanQrCode');
            const qrModal = document.getElementById('qrModal');
            const closeQr = document.getElementById('closeQrModal');
            const video = document.getElementById('qrVideo');
            const spinner = document.getElementById('loadingSpinner');
            let qrScanner;

            if (scanBtn) {
                scanBtn.addEventListener('click', async () => {
                    qrModal.classList.remove('hidden');
                    spinner.classList.remove('hidden');
                    video.classList.add('hidden');

                    if (!navigator.mediaDevices) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Kamera tidak didukung browser ini.'
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
                        video.setAttribute('playsinline', true);
                        video.play();
                        video.addEventListener('loadeddata', () => {
                            spinner.classList.add('hidden');
                            video.classList.remove('hidden');
                        });

                        // Scanner Logic
                        qrScanner = {
                            active: true,
                            scan: function() {
                                if (!this.active) return;
                                if (video.readyState === video.HAVE_ENOUGH_DATA) {
                                    const canvas = document.createElement('canvas');
                                    canvas.width = video.videoWidth;
                                    canvas.height = video.videoHeight;
                                    const ctx = canvas.getContext('2d');
                                    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
                                    const code = jsQR(ctx.getImageData(0, 0, canvas.width, canvas.height)
                                        .data, canvas.width, canvas.height);
                                    if (code) {
                                        this.stop();
                                        fetch('{{ route('admin.dashboard.check-in.store.qr') }}', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                            },
                                            body: JSON.stringify({
                                                registration_number: code.data
                                            })
                                        }).then(res => res.json()).then(data => {
                                            if (data.success) {
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'Berhasil',
                                                    text: data.message,
                                                    timer: 2000,
                                                    showConfirmButton: false
                                                });
                                                setTimeout(() => window.location.href = data
                                                    .redirect, 2000);
                                            } else {
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Gagal',
                                                    text: data.message
                                                });
                                            }
                                            qrModal.classList.add('hidden');
                                        });
                                        return;
                                    }
                                }
                                requestAnimationFrame(() => this.scan());
                            },
                            stop: function() {
                                this.active = false;
                                if (video.srcObject) video.srcObject.getTracks().forEach(t => t.stop());
                                video.srcObject = null;
                            }
                        };
                        qrScanner.start();
                    } catch (err) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Tidak dapat mengakses kamera.'
                        });
                    }
                });

                closeQr.addEventListener('click', () => {
                    if (qrScanner) qrScanner.stop();
                    qrModal.classList.add('hidden');
                });
            }
        </script>
    @endif

    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (auth()->check() && auth()->user()->role == 'user')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                if (!localStorage.getItem('whatsappModalShown')) {
                    setTimeout(() => {
                        Swal.fire({
                            title: 'Gabung Grup WhatsApp 📱',
                            text: 'Segera bergabung dengan grup WhatsApp kami untuk mendapatkan info perlombaan terkini.',
                            icon: 'info',
                            showCancelButton: true,
                            confirmButtonText: 'Grup Lomba',
                            cancelButtonText: 'Tutup',
                            confirmButtonColor: '#1D6594',
                            cancelButtonColor: '#9ca3af',
                            reverseButtons: true,
                            customClass: {
                                popup: 'rounded-3xl'
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.open('https://chat.whatsapp.com/Hi9IYZYEknYCMpF5mXayuN',
                                    '_blank');
                            }
                        });
                        localStorage.setItem('whatsappModalShown', 'true');
                    }, 1000);
                }
            });
        </script>
    @endif

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2500,
                customClass: {
                    popup: 'rounded-3xl'
                }
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: '{{ session('error') }}',
                confirmButtonColor: '#d33',
                customClass: {
                    popup: 'rounded-3xl'
                }
            });
        </script>
    @endif

</body>

</html>
