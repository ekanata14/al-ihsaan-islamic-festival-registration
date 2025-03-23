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

<body class="font-sans antialiased h-screen w-screen flex justify-center items-center container mx-auto">
    <div class="flex flex-col justify-center items-center gap-4 px-4" data-aos="fade-up" data-aos-duration="1000">
        <div class="w-full h-full md:w-1/2 flex flex-col justify-center items-center gap-3" data-aos="flip-left" data-aos-easing="ease-out-cubic" data-aos-duration="2000">
            <img src="{{ asset('assets/images/logo.png') }}" alt="logo" class="h-48 md:h-fit w-full md:w-full" data-aos="fade-up" data-aos-duration="1000">
        </div>
        <div class="w-w-full md:w-1/2 flex flex-col justify-center items-center gap-3 text-center" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="1000">
            <h1 class="text-4xl font-bold" data-aos="fade-up" data-aos-duration="1000">Coming Soon!</h1>
            <p class="text-xl" data-aos="fade-up" data-aos-duration="1000">Pendaftaran dan informasi lomba akan segera diumumin nih, terus pantengin website kita
                yak!</p>
            <a href="https://instagram.com/hrm_sanur" target="_blank" data-aos="fade-up" data-aos-duration="1000">
                <div class="flex items-center gap-1" data-aos="fade-up" data-aos-duration="1000">
                    <svg class="w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24" data-aos="fade-up" data-aos-duration="1000">
                        <path fill="currentColor" fill-rule="evenodd"
                            d="M3 8a5 5 0 0 1 5-5h8a5 5 0 0 1 5 5v8a5 5 0 0 1-5 5H8a5 5 0 0 1-5-5V8Zm5-3a3 3 0 0 0-3 3v8a3 3 0 0 0 3 3h8a3 3 0 0 0 3-3V8a3 3 0 0 0-3-3H8Zm7.597 2.214a1 1 0 0 1 1-1h.01a1 1 0 1 1 0 2h-.01a1 1 0 0 1-1-1ZM12 9a3 3 0 1 0 0 6 3 3 0 0 0 0-6Zm-5 3a5 5 0 1 1 10 0 5 5 0 0 1-10 0Z"
                            clip-rule="evenodd" />
                    </svg>
                    <p class="text-md font-bold">@hrm_sanur</p>
                </div>
            </a>

            <p class="text-md" data-aos="fade-up" data-aos-duration="1000">Pantengin instagram kita juga yak!</p>
        </div>
    </div>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            AOS.init({
                duration: 2000
            });
        });
    </script>
</body>

</html>
