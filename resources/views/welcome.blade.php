@extends('layouts.landing')
@section('content')
    {{-- hero-section-start --}}
    <div class="grid grid-cols-1 md:grid-cols-2 justify-center items-center gap-4 px-4 h-screen"
        data-aos="fade-up" data-aos-duration="1000">
        <div class="flex flex-col justify-end md:justify-center items-center md:items-center gap-3 h-full" data-aos="fade-up"
            data-aos-easing="ease-out-cubic" data-aos-duration="2000">
            {{-- <img src="{{ asset('assets/images/logo.png') }}" alt="logo" class="h-48 md:h-fit w-full md:w-fit"
                data-aos="fade-up" data-aos-duration="1000"> --}}
            <img src="{{ asset('assets/images/logo.png') }}" alt="logo"
                class="h-48 md:h-fit w-full md:w-fit object-contain" data-aos="fade-up" data-aos-duration="1000">
        </div>
        <div class="flex flex-col justify-center items-center md:items-start gap-3 text-right" data-aos="fade-up"
            data-aos-duration="1000" data-aos-delay="1000">
            <h1 class="text-2xl md:text-4xl font-bold text-center md:text-left" data-aos="fade-up" data-aos-duration="1000">
                Merajut Ukhuwah, Menggapai Berkah
            </h1>
            <p class="text-center md:text-justify">Al Ihsaan Islamic Festival hadir dengan lomba-lomba Islami seru, sunatan
                massal, dan
                donor darah penuh berkah!
                Gabung sekarang dan jadi bagian dari generasi muda yang berprestasi, berakhlak, dan peduli sesama! 🌟</p>
            <p class="text-center text-red-500 md:text-justify font-bold">*Peserta khusus TPQ Domisili Denpasar</p>
            <div class="grid grid-cols-2 justify-center md:justify-start gap-2">
                @if (auth()->check())
                    @if (auth()->user()->role == 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="btn-primary flex justify-center items-center">
                            Dashboard
                        </a>
                    @elseif(auth()->user()->role == 'user')
                        <a href="{{ route('user.dashboard') }}" class="btn-primary flex justify-center items-center">
                            Dashboard
                        </a>
                    @endif
                @else
                    <a href="{{ route('register') }}" class="btn-primary flex justify-center items-center">
                        Daftar Lomba!
                        <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M8 7V2.221a2 2 0 0 0-.5.365L3.586 6.5a2 2 0 0 0-.365.5H8Zm2 0V2h7a2 2 0 0 1 2 2v.126a5.087 5.087 0 0 0-4.74 1.368v.001l-6.642 6.642a3 3 0 0 0-.82 1.532l-.74 3.692a3 3 0 0 0 3.53 3.53l3.694-.738a3 3 0 0 0 1.532-.82L19 15.149V20a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9h5a2 2 0 0 0 2-2Z"
                                clip-rule="evenodd" />
                            <path fill-rule="evenodd"
                                d="M17.447 8.08a1.087 1.087 0 0 1 1.187.238l.002.001a1.088 1.088 0 0 1 0 1.539l-.377.377-1.54-1.542.373-.374.002-.001c.1-.102.22-.182.353-.237Zm-2.143 2.027-4.644 4.644-.385 1.924 1.925-.385 4.644-4.642-1.54-1.54Zm2.56-4.11a3.087 3.087 0 0 0-2.187.909l-6.645 6.645a1 1 0 0 0-.274.51l-.739 3.693a1 1 0 0 0 1.177 1.176l3.693-.738a1 1 0 0 0 .51-.274l6.65-6.646a3.088 3.088 0 0 0-2.185-5.275Z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="{{ route('khitan.registration') }}" class="btn-green flex justify-center items-center">
                        Daftar Khitan!
                        <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M8 7V2.221a2 2 0 0 0-.5.365L3.586 6.5a2 2 0 0 0-.365.5H8Zm2 0V2h7a2 2 0 0 1 2 2v.126a5.087 5.087 0 0 0-4.74 1.368v.001l-6.642 6.642a3 3 0 0 0-.82 1.532l-.74 3.692a3 3 0 0 0 3.53 3.53l3.694-.738a3 3 0 0 0 1.532-.82L19 15.149V20a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9h5a2 2 0 0 0 2-2Z"
                                clip-rule="evenodd" />
                            <path fill-rule="evenodd"
                                d="M17.447 8.08a1.087 1.087 0 0 1 1.187.238l.002.001a1.088 1.088 0 0 1 0 1.539l-.377.377-1.54-1.542.373-.374.002-.001c.1-.102.22-.182.353-.237Zm-2.143 2.027-4.644 4.644-.385 1.924 1.925-.385 4.644-4.642-1.54-1.54Zm2.56-4.11a3.087 3.087 0 0 0-2.187.909l-6.645 6.645a1 1 0 0 0-.274.51l-.739 3.693a1 1 0 0 0 1.177 1.176l3.693-.738a1 1 0 0 0 .51-.274l6.65-6.646a3.088 3.088 0 0 0-2.185-5.275Z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                @endif
                <a href="https://drive.google.com/file/d/18RWfMVRad5v5P-Opfdzsy3eAmircjtI7/view?usp=sharing"
                    class="btn-yellow flex justify-center items-center">
                    Guidebook
                    <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 19V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v13H7a2 2 0 0 0-2 2Zm0 0a2 2 0 0 0 2 2h12M9 3v14m7 0v4" />
                    </svg>
                </a>
                <a href="https://drive.google.com/drive/folders/1Ct5P53QnEDxNWS4Rj2QNLCIMDIQJY8Mr?usp=drive_link"
                    class="btn-red flex justify-center items-center">
                    Tutorial Pendaftaran
                    </svg>
                </a>
            </div>
        </div>
    </div>
    {{-- hero-section-end --}}
    {{-- lomba-section-start --}}
    <div class="flex flex-col justify-start items-center gap-4 px-4 h-full mb-20" data-aos="fade-up"
        data-aos-duration="1000" id="lomba">
        <h2 class="text-3xl font-bold text-center md:text-right">Lomba-Lomba
        </h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-right">
            @forelse ($competitions->unique('name') as $item)
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                    <a href="#">
                        {{-- <img class="rounded-t-lg" src="{{ asset('storage/' . $item->image_url) }}" alt="" /> --}}
                        <img class="rounded-t-lg" src="{{ asset('assets/images/logo_only.png') }}"
                            alt="{{ $item->name }}" />
                    </a>
                    <div class="p-5 flex flex-col gap-4">
                        <a href="#">
                            <h5 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                {{ $item->name }}</h5>
                        </a>
                        <a href="{{ route('register') }}" class="btn-primary flex justify-center items-center">
                            Daftar!
                            <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M1 5h12m0 0L9 1m4 4L9 9" />
                            </svg>
                        </a>
                    </div>
                </div>
            @empty
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                    <div class="p-5">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">No Competition
                            Available</h5>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
    {{-- lomba-section-end --}}
    {{-- sponsorship-section-start --}}
    <div class="flex flex-col justify-start items-center gap-4 px-4 h-full mb-10" data-aos="fade-up"
        data-aos-duration="1000" id="sponsorship">
        <h2 class="text-3xl font-bold text-center md:text-right mb-10">Sponsorship
        </h2>
        <div
            class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-6 justify-center items-center h-full gap-2 md:gap-4">
            @foreach ($sponsors as $sponsor)
                <img src="{{ asset($sponsor->img_url) }}" alt="{{ $sponsor->name }}" class="h-32 w-32 object-contain">
            @endforeach
        </div>

        <p class="text-center font-bold text-blue-500">Tertarik untuk menjadi sponsor acara ini? Silahkan Hubungi Kontak di
            bawah ini:</p>
        <a href="https://wa.me/+6282340786912" target="_blank"
            class="flex items-center gap-2 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-center">
            <img src="{{ asset('assets/icons/whatsapp.png') }}" alt="WhatsApp Logo" class="h-5 w-5">
            Rayyan
        </a>

    </div>
    {{-- sponsorship-section-end --}}
    {{-- contact-us-section-start --}}
    <div class="flex flex-col justify-start items-center gap-4 px-4 mt-20" style="height: calc(100vh - 200px);"
        data-aos="fade-up" data-aos-duration="1000" id="contact-us">
        <h2 class="text-3xl font-bold text-center md:text-right">Contact Us
        </h2>
        {{-- <div class="flex justify-center items-center h-full">
            <a href="{{ route('register') }}" class="btn-green">Daftar Sekarang!!!</a>
        </div> --}}
        <p class="text-center text-gray-700">Hubungi kontak di bawah untuk informasi acara dan lomba:</p>
        <ul class="mt-4 w-full max-w-md flex flex-col md:flex-row justify-center items-center gap-4">
            <li class="flex flex-col items-center">
                <a href="https://wa.me/+6281952476416" target="_blank"
                    class="flex items-center gap-2 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-center">
                    <img src="{{ asset('assets/icons/whatsapp.png') }}" alt="WhatsApp Logo" class="h-5 w-5">
                    Fauzan
                </a>
            </li>
            <li class="flex flex-col items-center">
                <a href="https://wa.me/+6287858741020" target="_blank"
                    class="flex items-center gap-2 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-center">
                    <img src="{{ asset('assets/icons/whatsapp.png') }}" alt="WhatsApp Logo" class="h-5 w-5">
                    Atha
                </a>
            </li>
            <li class="flex flex-col items-center">
                <a href="https://wa.me/+6281237495718" target="_blank"
                    class="flex items-center gap-2 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-center">
                    <img src="{{ asset('assets/icons/whatsapp.png') }}" alt="WhatsApp Logo" class="h-5 w-5">
                    Syawala
                </a>
            </li>
        </ul>
    </div>
    {{-- contact-us-section-end --}}
    {{-- khitanan-massal-section-start --}}
    <div class="flex flex-col justify-start items-center gap-4 px-4" style="height: calc(100vh - 200px);"
        data-aos="fade-up" data-aos-duration="1000" id="khitanan-massal">
        <h2 class="text-3xl font-bold text-center md:text-right">Khitanan Massal
        </h2>
        <div class="flex justify-center items-center h-full">
            <h3 class="text-xl font-bold text-center md:text-right">Informasi segera menyusul, tunggu yak!
            </h3>
        </div>
    </div>
    {{-- khitanan-massal-section-end --}}
    {{-- donor-darah-section-start --}}
    <div class="flex flex-col justify-start items-center gap-4 px-4" style="height: calc(100vh - 200px);"
        data-aos="fade-up" data-aos-duration="1000" id="donor-darah">
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
@endsection
