<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $settings['meta_title'] ?? ($settings['site_name'] ?? 'Al Ihsaan Islamic Festival') }}</title>
    @if (!empty($settings['meta_description']))
        <meta name="description" content="{{ $settings['meta_description'] }}">
    @endif

    <!-- Tema (dapat diubah dari admin) -->
    <style>
        :root {
            --lp: {{ $settings['primary_color'] ?? '#1D6594' }};
            --la: {{ $settings['accent_color'] ?? '#E9AA14' }};
        }

        .lp-text {
            color: var(--lp);
        }

        .lp-bg {
            background-color: var(--lp);
        }

        .lp-border {
            border-color: var(--lp);
        }

        .la-text {
            color: var(--la);
        }

        .la-bg {
            background-color: var(--la);
        }

        .la-border {
            border-color: var(--la);
        }
    </style>

    <!-- Fonts -->
    <link rel="icon" href="{{ \App\Support\LandingImage::url($settings['favicon'] ?? null, 'assets/images/logo_only.png') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>

<body class="font-sans antialiased">
    @include('layouts.partials.landing.navbar')
    <main>
        <div class="py-12">
            @yield('content')
        </div>
    </main>

    @include('layouts.partials.landing.footer')

    @stack('scripts')
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 2000
            });
        });
    </script>
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
</body>

</html>
