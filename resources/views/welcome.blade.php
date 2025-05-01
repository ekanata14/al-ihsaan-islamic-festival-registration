@extends('layouts.landing')
@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 justify-center items-center gap-4 px-4" style="height: calc(100vh - 200px);"
        data-aos="fade-left" data-aos-duration="1000">
        <div class="flex flex-col justify-center items-center gap-3 h-full" data-aos="flip-left"
            data-aos-easing="ease-out-cubic" data-aos-duration="2000">
            <img src="{{ asset('assets/images/logo.png') }}" alt="logo" class="h-48 md:h-fit w-full md:w-full"
                data-aos="fade-up" data-aos-duration="1000">
        </div>
        <div class="flex flex-col justify-center items-center gap-3 text-right" data-aos="fade-up" data-aos-duration="1000"
            data-aos-delay="1000">
            <h1 class="text-4xl font-bold text-right" data-aos="fade-up" data-aos-duration="1000">Merajut Ukhuwah, Menggapai Berkah
            </h1>
        <p class="text-justify">Al Ihsaan Islamic Festival hadir dengan lomba-lomba Islami seru, sunatan massal, dan
                donor darah penuh berkah!
            Gabung sekarang dan jadi bagian dari generasi muda yang berprestasi, berakhlak, dan peduli sesama! 🌟</p>
            <p class="font-bold">Pendaftaran akan dibuka Senin, 5 Mei 2025, Stay Tune!!!</p>
        </div>
    </div>
@endsection
