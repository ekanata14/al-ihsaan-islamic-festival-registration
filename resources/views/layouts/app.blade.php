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
            @if (auth()->user()->role == 'user')
                <button id="contactPerson"
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded fixed bottom-8 right-8 shadow-lg">
                    Contact Person
                </button>

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
            @if (auth()->user()->role == 'admin')
                <button id="scanQrCode"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded fixed bottom-8 right-8 shadow-lg">
                    Scan QR Code
                </button>

                <!-- Modal -->
                <div id="qrModal"
                    class="hidden fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50">
                    <div class="bg-white rounded-lg shadow-lg p-4 w-full max-w-md">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-lg font-semibold">Scan QR Code</h2>
                            <button id="closeQrModal" class="text-gray-500 hover:text-gray-700">&times;</button>
                        </div>
                        <video id="qrVideo" class="w-full border border-gray-300 rounded"></video>
                    </div>
                </div>

                <script>
                    const scanQrCodeButton = document.getElementById('scanQrCode');
                    const qrModal = document.getElementById('qrModal');
                    const closeQrModalButton = document.getElementById('closeQrModal');
                    const video = document.getElementById('qrVideo');
                    let qrScanner;

                    scanQrCodeButton.addEventListener('click', async () => {
                        qrModal.classList.remove('hidden');

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

                            qrScanner = new QrScanner(video, async result => {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'QR Code Scanned',
                                    text: `QR Code Data: ${result}`,
                                    showConfirmButton: true
                                });

                                try {
                                    const response = await fetch(
                                        '{{ route('admin.dashboard.check-in.store') }}', {
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
                                            showConfirmButton: true
                                        }).then(() => {
                                            location.reload();
                                        });
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
