@extends('layouts.landing')

@section('content')
    {{-- Custom Style Tambahan untuk Efek Fancy --}}
    <style>
        /* Sembunyikan elemen sebelum GSAP load untuk mencegah efek berkedip (FOUC) */
        .gsap-hidden { opacity: 0; visibility: hidden; }

        /* Aksen Blob Background */
        .bg-blob {
            position: absolute;
            filter: blur(80px);
            z-index: 1;
            opacity: 0.6;
        }

        /* Hero Background Overlay */
        .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to right, rgba(255,255,255,0.95) 0%, rgba(255,255,255,0.85) 50%, rgba(255,255,255,0.4) 100%);
            z-index: 0;
        }

        @media (max-width: 768px) {
            .hero-overlay {
                background: linear-gradient(to bottom, rgba(255,255,255,0.9) 0%, rgba(255,255,255,0.95) 100%);
            }
        }
    </style>

    {{-- ==============================
         1. HERO SECTION
       ============================== --}}
    <div class="relative min-h-screen flex items-center justify-center overflow-hidden px-4 pt-20 pb-12" id="hero">

        <div class="absolute inset-0 z-[-1]">
            <img src="https://images.unsplash.com/photo-1519818178122-1d579241517a?q=80&w=2070&auto=format&fit=crop"
                 alt="Islamic Festival Background"
                 class="w-full h-full object-cover object-center opacity-80">
        </div>

        <div class="hero-overlay"></div>

        <div class="bg-blob bg-[#E9AA14] w-72 h-72 rounded-full top-20 left-10"></div>
        <div class="bg-blob bg-[#1D6594] w-96 h-96 rounded-full bottom-10 right-10"></div>

        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-10 items-center w-full z-10 relative">
            <div class="flex flex-col justify-center items-center md:items-start gap-5 text-center md:text-left order-2 md:order-1">
                <span class="hero-elem px-4 py-1.5 rounded-full text-sm font-semibold bg-white/80 backdrop-blur-sm text-[#1D6594] border border-[#1D6594]/30 shadow-sm">
                    ✨ Selamat Datang di Al Ihsaan Islamic Festival
                </span>

                <h1 class="hero-elem text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight text-gray-900 drop-shadow-sm">
                    Merajut Ukhuwah, <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#1D6594] to-[#E9AA14]">
                        Menggapai Berkah
                    </span>
                </h1>

                <p class="hero-elem text-base md:text-lg text-gray-700 font-medium max-w-lg leading-relaxed drop-shadow-sm">
                    Al Ihsaan Islamic Festival hadir dengan lomba-lomba Islami seru, sunatan massal, dan donor darah penuh berkah! Gabung sekarang dan jadilah bagian dari generasi muda yang berprestasi, berakhlak, dan peduli sesama! 🌟
                </p>

                <div class="hero-elem bg-white/90 backdrop-blur-md border-l-4 border-red-500 p-4 rounded-r-lg max-w-lg shadow-md">
                    <p class="text-xs md:text-sm text-red-700 font-semibold text-left">
                        *<strong class="font-bold">Perhatian:</strong> Peserta lomba dibatasi hanya untuk TPQ se-Denpasar. Sementara itu, kegiatan sunat massal dan donor darah dapat diikuti oleh masyarakat umum.
                    </p>
                </div>

                <div class="hero-elem flex flex-wrap justify-center md:justify-start gap-4 mt-4">
                    @if (auth()->check())
                        <a href="{{ auth()->user()->role == 'admin' ? route('admin.dashboard') : route('user.dashboard') }}"
                           class="flex items-center gap-2 px-8 py-3.5 bg-[#1D6594] text-white font-bold rounded-full shadow-lg hover:shadow-xl hover:bg-[#154d73] hover:-translate-y-1 transition-all duration-300">
                            Masuk Dashboard
                        </a>
                    @else
                        <a href="{{ route('register') }}"
                           class="flex items-center gap-2 px-8 py-3.5 bg-[#1D6594] text-white font-bold rounded-full shadow-lg hover:shadow-xl hover:bg-[#154d73] hover:-translate-y-1 transition-all duration-300">
                            Daftar Lomba!
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                        </a>
                        <a href="{{ route('khitan.registration') }}"
                           class="flex items-center gap-2 px-8 py-3.5 bg-emerald-500 text-white font-bold rounded-full shadow-lg hover:shadow-xl hover:bg-emerald-600 hover:-translate-y-1 transition-all duration-300">
                            Daftar Khitan!
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path></svg>
                        </a>
                    @endif
                </div>

                <div class="hero-elem flex flex-wrap justify-center md:justify-start gap-3 mt-2">
                    <a href="https://drive.google.com/file/d/1ajDBWL_DAIumTEOYH-y14BM6e_PAsibM/view?usp=sharing" target="_blank"
                       class="flex items-center gap-2 px-6 py-2.5 bg-white/90 backdrop-blur-sm text-[#1D6594] border-2 border-[#1D6594] font-semibold rounded-full shadow-sm hover:bg-blue-50 transition-colors duration-300 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        Guidebook
                    </a>
                    <a href="https://drive.google.com/drive/folders/1Ct5P53QnEDxNWS4Rj2QNLCIMDIQJY8Mr?usp=drive_link" target="_blank"
                       class="flex items-center gap-2 px-6 py-2.5 bg-white/90 backdrop-blur-sm text-rose-500 border-2 border-rose-500 font-semibold rounded-full shadow-sm hover:bg-rose-50 transition-colors duration-300 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Tutorial Daftar
                    </a>
                </div>
            </div>

            <div class="hero-elem flex justify-center items-center order-1 md:order-2 bg-white/40 p-10 rounded-3xl backdrop-blur-sm shadow-2xl border border-white/50">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Al Ihsaan Islamic Festival Logo"
                     class="h-48 md:h-80 w-auto object-contain drop-shadow-2xl hover:scale-105 transition-transform duration-500">
            </div>
        </div>
    </div>

    {{-- ==============================
         2. INFORMASI ACARA (Poster)
       ============================== --}}
    <div class="py-24 bg-[#1D6594] relative overflow-hidden" id="info-acara">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full transform translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-[#E9AA14] opacity-10 rounded-full transform -translate-x-1/3 translate-y-1/3"></div>

        <div class="max-w-7xl mx-auto px-4 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

                <div class="gsap-poster flex justify-center order-2 lg:order-1">
                    <div class="relative group w-full max-w-md">
                        <div class="absolute -inset-1 bg-gradient-to-r from-[#E9AA14] to-blue-400 rounded-2xl blur opacity-30 group-hover:opacity-60 transition duration-1000 group-hover:duration-200"></div>
                        <div class="relative bg-white p-2 rounded-2xl shadow-2xl transform transition-transform duration-500 group-hover:-translate-y-2 group-hover:scale-[1.02]">
                            <img src="{{ asset('assets/images/donor_khitan_compressed.jpg') }}" alt="Poster Resmi Acara" class="w-full h-auto rounded-xl object-cover border border-gray-100">
                        </div>
                    </div>
                </div>

                <div class="gsap-info text-white order-1 lg:order-2 flex flex-col justify-center">
                    <span class="text-[#E9AA14] font-bold tracking-wider uppercase text-sm mb-2">Informasi Utama</span>
                    <h2 class="text-3xl md:text-5xl font-extrabold mb-6 leading-tight">Rangkaian Acara Penuh Berkah</h2>
                    <p class="text-blue-100 text-lg mb-8 leading-relaxed">
                        Kami mengundang seluruh elemen masyarakat untuk hadir dan berpartisipasi dalam rangkaian kegiatan Al Ihsaan Islamic Festival. Jadikan momen ini sebagai ladang amal dan silaturahmi.
                    </p>

                    <div class="space-y-6">
                        <div class="flex items-start gap-4 bg-white/10 p-5 rounded-2xl backdrop-blur-sm border border-white/10 hover:bg-white/20 transition-colors">
                            <div class="bg-[#E9AA14] p-3 rounded-xl shadow-inner">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-xl text-white">Waktu Pelaksanaan</h4>
                                <p class="text-blue-100 mt-1">Minggu, 15 Juni 2025<br>07.00 - 12.00 WITA</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 bg-white/10 p-5 rounded-2xl backdrop-blur-sm border border-white/10 hover:bg-white/20 transition-colors">
                            <div class="bg-[#E9AA14] p-3 rounded-xl shadow-inner">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-xl text-white">Lokasi Acara</h4>
                                <p class="text-blue-100 mt-1">Masjid Al Ihsaan Sanur<br>Jl. Hang Tuah, Sanur, Denpasar</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 bg-white/10 p-5 rounded-2xl backdrop-blur-sm border border-white/10 hover:bg-white/20 transition-colors">
                            <div class="bg-[#E9AA14] p-3 rounded-xl shadow-inner">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-xl text-white">Periode Pendaftaran</h4>
                                <p class="text-blue-100 mt-1 font-semibold text-[#E9AA14]">05 Mei – 07 Juni 2025</p>
                                <p class="text-sm text-blue-200 mt-1">*Kuota terbatas, segera daftarkan diri Anda!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ==============================
         3. LOMBA SECTION
       ============================== --}}
    <div class="py-20 bg-gray-50" id="lomba">
        <div class="max-w-7xl mx-auto px-4">
            <div class="section-header text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-extrabold text-[#1D6594] mb-3">Kategori Perlombaan</h2>
                <div class="w-20 h-1.5 bg-[#E9AA14] mx-auto rounded-full"></div>
            </div>

            <div class="lomba-container grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse ($competitions->unique('name') as $item)
                    <div class="gsap-card bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 border border-gray-100 flex flex-col overflow-hidden group">
                        <div class="relative overflow-hidden bg-gray-100 flex justify-center items-center h-48 p-4">
                            <img class="w-full h-full object-contain transform group-hover:scale-110 transition-transform duration-500"
                                 src="{{ asset('assets/images/logo_only.png') }}" alt="{{ $item->name }}" />
                            <div class="absolute inset-0 bg-gradient-to-t from-[#1D6594]/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </div>
                        <div class="p-6 flex flex-col flex-grow justify-between gap-4">
                            <h5 class="text-xl font-bold text-gray-800 group-hover:text-[#1D6594] transition-colors line-clamp-2">
                                {{ $item->name }}
                            </h5>
                            <a href="{{ route('register') }}" class="w-full text-center py-2.5 rounded-xl bg-[#E9AA14] text-white font-bold shadow hover:bg-[#c9920f] hover:shadow-md transition-all duration-300 flex justify-center items-center gap-2">
                                Daftar Sekarang
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white border border-gray-200 rounded-2xl shadow-sm p-8 text-center">
                        <h5 class="text-xl font-bold text-gray-500">Belum ada perlombaan yang tersedia saat ini.</h5>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- ==============================
         4. SPONSORSHIP SECTION
       ============================== --}}
    <div class="py-20 bg-white" id="sponsorship">
        <div class="max-w-7xl mx-auto px-4">
            <div class="section-header text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-extrabold text-[#1D6594] mb-3">Sponsorship</h2>
                <div class="w-20 h-1.5 bg-[#E9AA14] mx-auto rounded-full mb-6"></div>
                <p class="text-gray-600 max-w-2xl mx-auto">Terima kasih kepada para sponsor yang telah mendukung terselenggaranya Al Ihsaan Islamic Festival.</p>
            </div>

            <div class="sponsor-container grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6 md:gap-8 justify-items-center mb-12">
                @foreach ($sponsors as $sponsor)
                    <div class="gsap-sponsor p-4 grayscale hover:grayscale-0 hover:scale-110 transition-all duration-300 flex justify-center items-center w-full h-24">
                        <img src="{{ asset($sponsor->img_url) }}" alt="{{ $sponsor->name }}" class="max-h-full max-w-full object-contain">
                    </div>
                @endforeach
            </div>

            <div class="gsap-contact-sponsor bg-[#f8fbff] border border-[#e0f0ff] rounded-2xl p-8 max-w-3xl mx-auto text-center shadow-sm">
                <h4 class="text-xl font-bold text-gray-800 mb-2">Tertarik Menjadi Sponsor?</h4>
                <p class="text-gray-600 mb-6">Dukung syiar Islam dan dapatkan eksposur eksklusif untuk brand Anda di acara kami.</p>
                <a href="https://wa.me/+6282340786912" target="_blank"
                   class="inline-flex items-center gap-3 bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-8 rounded-full shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <img src="{{ asset('assets/icons/whatsapp.png') }}" alt="WhatsApp" class="h-6 w-6 brightness-0 invert">
                    Hubungi Rayyan
                </a>
            </div>
        </div>
    </div>

    {{-- ==============================
         5. CONTACT US SECTION
       ============================== --}}
    <div class="py-20 bg-gray-50 border-t border-gray-100" id="contact-us">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <div class="section-header mb-10">
                <h2 class="text-3xl md:text-4xl font-extrabold text-[#1D6594] mb-3">Hubungi Kami</h2>
                <div class="w-20 h-1.5 bg-[#E9AA14] mx-auto rounded-full mb-6"></div>
                <p class="text-gray-600">Punya pertanyaan seputar acara, lomba, atau teknis pendaftaran? Silakan hubungi narahubung kami di bawah ini atau bergabung ke dalam grup WhatsApp resmi.</p>
            </div>

            <div class="contact-container flex flex-wrap justify-center gap-4 mb-10">
                <a href="https://wa.me/+6281952476416" target="_blank" class="gsap-contact w-full sm:w-auto flex items-center justify-center gap-3 bg-white hover:bg-green-50 border border-gray-200 hover:border-green-500 text-gray-700 hover:text-green-700 font-bold py-3 px-6 rounded-2xl transition-all duration-300 group shadow-sm hover:shadow-md">
                    <img src="{{ asset('assets/icons/whatsapp.png') }}" alt="WA" class="h-6 w-6 group-hover:scale-110 transition-transform"> Fauzan
                </a>
                <a href="https://wa.me/+6287858741020" target="_blank" class="gsap-contact w-full sm:w-auto flex items-center justify-center gap-3 bg-white hover:bg-green-50 border border-gray-200 hover:border-green-500 text-gray-700 hover:text-green-700 font-bold py-3 px-6 rounded-2xl transition-all duration-300 group shadow-sm hover:shadow-md">
                    <img src="{{ asset('assets/icons/whatsapp.png') }}" alt="WA" class="h-6 w-6 group-hover:scale-110 transition-transform"> Atha
                </a>
                <a href="https://wa.me/+6281237495718" target="_blank" class="gsap-contact w-full sm:w-auto flex items-center justify-center gap-3 bg-white hover:bg-green-50 border border-gray-200 hover:border-green-500 text-gray-700 hover:text-green-700 font-bold py-3 px-6 rounded-2xl transition-all duration-300 group shadow-sm hover:shadow-md">
                    <img src="{{ asset('assets/icons/whatsapp.png') }}" alt="WA" class="h-6 w-6 group-hover:scale-110 transition-transform"> Syawala
                </a>
            </div>

            <div class="flex flex-wrap justify-center gap-4 pt-4">
                <a href="https://chat.whatsapp.com/Hi9IYZYEknYCMpF5mXayuN" target="_blank" class="gsap-contact flex items-center justify-center w-full sm:w-auto gap-2 px-8 py-3.5 bg-[#1D6594] text-white font-bold rounded-full shadow-md hover:shadow-lg hover:bg-[#154d73] hover:-translate-y-1 transition-all duration-300">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 14c-2.21 0-4-1.79-4-4h2c0 1.1.9 2 2 2s2-.9 2-2-.9-2-2-2v-2c2.21 0 4 1.79 4 4s-1.79 4-4 4z"></path></svg>
                    Grup WA Lomba
                </a>
                <a href="https://chat.whatsapp.com/By2POmbv4pzGFrgm304VSj" target="_blank" class="gsap-contact flex items-center justify-center w-full sm:w-auto gap-2 px-8 py-3.5 bg-[#E9AA14] text-white font-bold rounded-full shadow-md hover:shadow-lg hover:bg-[#d89c0f] hover:-translate-y-1 transition-all duration-300">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 14c-2.21 0-4-1.79-4-4h2c0 1.1.9 2 2 2s2-.9 2-2-.9-2-2-2v-2c2.21 0 4 1.79 4 4s-1.79 4-4 4z"></path></svg>
                    Grup WA Khitan
                </a>
            </div>
        </div>
    </div>
@endsection

{{-- ==============================
     GSAP SCRIPTS
   ============================== --}}
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            gsap.registerPlugin(ScrollTrigger);

            // 1. Animasi Hero Section
            gsap.fromTo(".hero-elem",
                { y: 50, opacity: 0, visibility: 'visible' },
                { y: 0, opacity: 1, duration: 1, stagger: 0.15, ease: "power3.out" }
            );

            // 2. Animasi Judul Section
            gsap.utils.toArray('.section-header').forEach(header => {
                gsap.fromTo(header,
                    { y: 30, opacity: 0 },
                    {
                        scrollTrigger: { trigger: header, start: "top 85%" },
                        y: 0, opacity: 1, duration: 0.8, ease: "power2.out"
                    }
                );
            });

            // 3. Animasi Poster Info Acara
            gsap.fromTo(".gsap-poster",
                { x: -50, opacity: 0, rotationY: -15 },
                {
                    scrollTrigger: { trigger: "#info-acara", start: "top 70%" },
                    x: 0, opacity: 1, rotationY: 0, duration: 1.2, ease: "power3.out"
                }
            );

            gsap.fromTo(".gsap-info > *",
                { x: 50, opacity: 0 },
                {
                    scrollTrigger: { trigger: "#info-acara", start: "top 70%" },
                    x: 0, opacity: 1, duration: 0.8, stagger: 0.15, ease: "power2.out"
                }
            );

            // 4. Animasi Card Lomba
            gsap.fromTo(".gsap-card",
                { y: 50, opacity: 0 },
                {
                    scrollTrigger: { trigger: ".lomba-container", start: "top 80%" },
                    y: 0, opacity: 1, duration: 0.6, stagger: 0.1, ease: "back.out(1.2)"
                }
            );

            // 5. Animasi Sponsor Logos & Box
            gsap.fromTo(".gsap-sponsor",
                { scale: 0.8, opacity: 0 },
                {
                    scrollTrigger: { trigger: ".sponsor-container", start: "top 85%" },
                    scale: 1, opacity: 1, duration: 0.5, stagger: 0.05, ease: "back.out(1.5)"
                }
            );

            gsap.fromTo(".gsap-contact-sponsor",
                { y: 30, opacity: 0 },
                {
                    scrollTrigger: { trigger: ".gsap-contact-sponsor", start: "top 90%" },
                    y: 0, opacity: 1, duration: 0.8, ease: "power2.out"
                }
            );

            // 6. Animasi Tombol Contact Us
            gsap.fromTo(".gsap-contact",
                { y: 20, opacity: 0 },
                {
                    scrollTrigger: { trigger: ".contact-container", start: "top 90%" },
                    y: 0, opacity: 1, duration: 0.5, stagger: 0.1, ease: "power2.out"
                }
            );
        });
    </script>
@endpush
