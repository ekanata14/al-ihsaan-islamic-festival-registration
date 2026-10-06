@extends('layouts.landing')

@section('content')
    {{-- Custom Style Tambahan untuk Efek Fancy --}}
    <style>
        /* Sembunyikan elemen sebelum GSAP load untuk mencegah efek berkedip (FOUC) */
        .gsap-hidden {
            opacity: 0;
            visibility: hidden;
        }

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
            background: linear-gradient(to right, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.85) 50%, rgba(255, 255, 255, 0.4) 100%);
            z-index: 0;
        }

        @media (max-width: 768px) {
            .hero-overlay {
                background: linear-gradient(to bottom, rgba(255, 255, 255, 0.9) 0%, rgba(255, 255, 255, 0.95) 100%);
            }
        }
    </style>

    @foreach ($blocks as $block)
        @includeIf("landing.blocks.{$block->type}", ['content' => $block->content ?? [], 'block' => $block])
    @endforeach
@endsection

{{-- ==============================
     GSAP SCRIPTS
   ============================== --}}
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof gsap === 'undefined') return;
            gsap.registerPlugin(ScrollTrigger);

            gsap.fromTo(".hero-elem", {
                y: 50,
                opacity: 0,
                visibility: 'visible'
            }, {
                y: 0,
                opacity: 1,
                duration: 1,
                stagger: 0.15,
                ease: "power3.out"
            });

            gsap.utils.toArray('.section-header').forEach(header => {
                gsap.fromTo(header, {
                    y: 30,
                    opacity: 0
                }, {
                    scrollTrigger: {
                        trigger: header,
                        start: "top 85%"
                    },
                    y: 0,
                    opacity: 1,
                    duration: 0.8,
                    ease: "power2.out"
                });
            });

            gsap.fromTo(".gsap-poster", {
                x: -50,
                opacity: 0,
                rotationY: -15
            }, {
                scrollTrigger: {
                    trigger: "#info-acara",
                    start: "top 70%"
                },
                x: 0,
                opacity: 1,
                rotationY: 0,
                duration: 1.2,
                ease: "power3.out"
            });

            gsap.fromTo(".gsap-info > *", {
                x: 50,
                opacity: 0
            }, {
                scrollTrigger: {
                    trigger: "#info-acara",
                    start: "top 70%"
                },
                x: 0,
                opacity: 1,
                duration: 0.8,
                stagger: 0.15,
                ease: "power2.out"
            });

            gsap.fromTo(".gsap-card", {
                y: 50,
                opacity: 0
            }, {
                scrollTrigger: {
                    trigger: ".lomba-container",
                    start: "top 80%"
                },
                y: 0,
                opacity: 1,
                duration: 0.6,
                stagger: 0.1,
                ease: "back.out(1.2)"
            });

            gsap.fromTo(".gsap-sponsor", {
                scale: 0.8,
                opacity: 0
            }, {
                scrollTrigger: {
                    trigger: ".sponsor-container",
                    start: "top 85%"
                },
                scale: 1,
                opacity: 1,
                duration: 0.5,
                stagger: 0.05,
                ease: "back.out(1.5)"
            });

            gsap.fromTo(".gsap-contact-sponsor", {
                y: 30,
                opacity: 0
            }, {
                scrollTrigger: {
                    trigger: ".gsap-contact-sponsor",
                    start: "top 90%"
                },
                y: 0,
                opacity: 1,
                duration: 0.8,
                ease: "power2.out"
            });

            gsap.fromTo(".gsap-contact", {
                y: 20,
                opacity: 0
            }, {
                scrollTrigger: {
                    trigger: ".contact-container",
                    start: "top 90%"
                },
                y: 0,
                opacity: 1,
                duration: 0.5,
                stagger: 0.1,
                ease: "power2.out"
            });
        });
    </script>
@endpush
