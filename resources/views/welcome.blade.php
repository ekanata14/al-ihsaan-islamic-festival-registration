@extends('layouts.landing')
@section('content')
    {{-- hero-section-start --}}
    <div class="grid grid-cols-1 md:grid-cols-2 justify-center items-center gap-4 px-4" style="height: calc(100vh - 200px);"
        data-aos="fade-left" data-aos-duration="1000">
        <div class="flex flex-col justify-end md:justify-center items-center md:items-center gap-3 h-full"
            data-aos="flip-left" data-aos-easing="ease-out-cubic" data-aos-duration="2000">
            {{-- <img src="{{ asset('assets/images/logo.png') }}" alt="logo" class="h-48 md:h-fit w-full md:w-fit"
                data-aos="fade-up" data-aos-duration="1000"> --}}
            <img src="{{ asset('assets/images/logo.png') }}" alt="logo"
                class="h-48 md:h-fit w-full md:w-fit object-contain" data-aos="fade-up" data-aos-duration="1000">
        </div>
        <div class="flex flex-col justify-center items-center gap-3 text-right" data-aos="fade-up" data-aos-duration="1000"
            data-aos-delay="1000">
            <h1 class="text-2xl md:text-4xl font-bold text-center md:text-right" data-aos="fade-up"
                data-aos-duration="1000">Merajut Ukhuwah, Menggapai Berkah
            </h1>
            <p class="text-center md:text-justify">Al Ihsaan Islamic Festival hadir dengan lomba-lomba Islami seru, sunatan
                massal, dan
                donor darah penuh berkah!
                Gabung sekarang dan jadi bagian dari generasi muda yang berprestasi, berakhlak, dan peduli sesama! 🌟</p>
            <p class="font-bold text-center md:text-right text-red-500">Pendaftaran akan dibuka Senin, 5 Mei 2025, Stay Tuned!!!</p>
        </div>
    </div>
    {{-- hero-section-end --}}
    {{-- lomba-section-start --}}
    <div class="flex flex-col justify-start items-center gap-4 px-4" style="height: calc(100vh - 200px);" data-aos="fade-up"
        data-aos-duration="1000" id="lomba">
        <h2 class="text-3xl font-bold text-center md:text-right">Lomba-Lomba
        </h2>
        {{-- <div class="grid grid-cols-4 gap-3 text-right">
        </div> --}}
        <div class="flex justify-center items-center h-full">
            <h3 class="text-xl font-bold text-center md:text-right">Informasi segera menyusul, tunggu yak!
            </h3>
        </div>
    </div>
    {{-- lomba-section-end --}}
    {{-- khitanan-massal-section-start --}}
    <div class="flex flex-col justify-start items-center gap-4 px-4" style="height: calc(100vh - 200px);" data-aos="fade-up"
        data-aos-duration="1000" id="khitanan-massal">
        <h2 class="text-3xl font-bold text-center md:text-right">Khitanan Massal
        </h2>
        {{-- <div class="grid grid-cols-4 gap-3 text-right">
        </div> --}}
        <div class="flex justify-center items-center h-full">
            <h3 class="text-xl font-bold text-center md:text-right">Informasi segera menyusul, tunggu yak!
            </h3>
        </div>
    </div>
    {{-- khitanan-massal-section-end --}}
    {{-- donor-darah-section-start --}}
    <div class="flex flex-col justify-start items-center gap-4 px-4" style="height: calc(100vh - 200px);" data-aos="fade-up"
        data-aos-duration="1000" id="donor-darah">
        <h2 class="text-3xl font-bold text-center md:text-right">Donor Darah
        </h2>
        {{-- <div class="grid grid-cols-4 gap-3 text-right">
        </div> --}}
        <div class="flex justify-center items-center h-full">
            <h3 class="text-xl font-bold text-center md:text-right">Informasi segera menyusul, tunggu yak!
            </h3>
        </div>
    </div>
    {{-- donor-darah-section-end --}}
    {{-- sponsorship-section-start --}}
    <div class="flex flex-col justify-start items-center gap-4 px-4" style="height: calc(100vh - 200px);" data-aos="fade-up"
        data-aos-duration="1000" id="sponsorship">
        <h2 class="text-3xl font-bold text-center md:text-right">Sponsorship
        </h2>
        <div class="flex justify-center items-center h-full">
            <h3 class="text-xl font-bold text-center md:text-right">Informasi segera menyusul, tunggu yak!
            </h3>
        </div>
        {{-- <div class="grid grid-cols-4 gap-3 text-right">
        </div> --}}
    </div>
    {{-- sponsorship-section-end --}}
    {{-- contact-us-section-start --}}
    <div class="flex flex-col justify-start items-center gap-4 px-4" style="height: calc(100vh - 200px);" data-aos="fade-up"
        data-aos-duration="1000" id="contact-us">
        <h2 class="text-3xl font-bold text-center md:text-right">Contact Us
        </h2>
        {{-- <div class="flex justify-center items-center h-full">
            <a href="{{ route('register') }}" class="btn-green">Daftar Sekarang!!!</a>
        </div> --}}
        <p class="text-center text-gray-700">Hubungi kontak di bawah untuk informasi lebih lanjut:</p>
        <ul class="mt-4 space-y-4 w-full max-w-md">
            <li class="flex flex-col items-center">
                <p class="font-semibold">Fauzan</p>
                <a href="https://wa.me/+6281952476416" target="_blank"
                    class="flex items-center gap-2 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-center">
                    <img src="{{ asset('assets/icons/whatsapp.png') }}" alt="WhatsApp Logo" class="h-5 w-5">
                    Chat on WhatsApp
                </a>
            </li>
            <li class="flex flex-col items-center">
                <p class="font-semibold">Atha</p>
                <a href="https://wa.me/+6287858741020" target="_blank"
                    class="flex items-center gap-2 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-center">
                    <img src="{{ asset('assets/icons/whatsapp.png') }}" alt="WhatsApp Logo" class="h-5 w-5">
                    Chat on WhatsApp
                </a>
            </li>
            <li class="flex flex-col items-center">
                <p class="font-semibold">Syawala</p>
                <a href="https://wa.me/+6281237495718" target="_blank"
                    class="flex items-center gap-2 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-center">
                    <img src="{{ asset('assets/icons/whatsapp.png') }}" alt="WhatsApp Logo" class="h-5 w-5">
                    Chat on WhatsApp
                </a>
            </li>
        </ul>
    </div>
    {{-- contact-us-section-end --}}
@endsection
