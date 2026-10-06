@php
    use App\Support\LandingImage;

    $poster = LandingImage::url($content['poster'] ?? null, 'assets/images/donor_khitan_compressed.jpg');
    $cards = collect($content['cards'] ?? []);
@endphp

<div class="py-24 lp-bg relative overflow-hidden w-full" id="info-acara">
    <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full transform translate-x-1/2 -translate-y-1/2"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 la-bg opacity-10 rounded-full transform -translate-x-1/3 translate-y-1/3"></div>

    <div class="max-w-7xl mx-auto px-4 relative z-10 w-full">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center w-full">
            @if (!empty($content['poster']) || true)
                <div class="gsap-poster flex justify-center order-2 lg:order-1 w-full">
                    <div class="relative group w-full max-w-lg">
                        <div class="absolute -inset-1 bg-gradient-to-r from-[#E9AA14] to-blue-400 rounded-2xl blur opacity-30 group-hover:opacity-60 transition duration-1000 group-hover:duration-200"></div>
                        <div class="relative bg-white p-2 rounded-2xl shadow-2xl transform transition-transform duration-500 group-hover:-translate-y-2 group-hover:scale-[1.02] w-full">
                            <img src="{{ $poster }}" alt="Poster Resmi Acara" class="w-full h-auto rounded-xl object-contain border border-gray-100">
                        </div>
                    </div>
                </div>
            @endif

            <div class="gsap-info text-white order-1 lg:order-2 flex flex-col justify-center w-full">
                @if (!empty($content['eyebrow']))
                    <span class="la-text font-bold tracking-wider uppercase text-sm mb-2">{{ $content['eyebrow'] }}</span>
                @endif
                @if (!empty($content['title']))
                    <h2 class="text-3xl md:text-5xl font-extrabold mb-6 leading-tight">{{ $content['title'] }}</h2>
                @endif
                @if (!empty($content['subtitle']))
                    <p class="text-blue-100 text-lg mb-8 leading-relaxed">{{ $content['subtitle'] }}</p>
                @endif

                <div class="space-y-6 w-full">
                    @foreach ($cards as $card)
                        <div class="flex items-start gap-4 bg-white/10 p-5 rounded-2xl backdrop-blur-sm border border-white/10 hover:bg-white/20 transition-colors">
                            <div class="la-bg p-3 rounded-xl shadow-inner shrink-0">
                                <x-landing-icon :name="$card['icon'] ?? 'star'" class="w-6 h-6 text-white" />
                            </div>
                            <div>
                                <h4 class="font-bold text-xl text-white">{{ $card['title'] ?? '' }}</h4>
                                <p class="text-blue-100 mt-1">{!! nl2br(e($card['lines'] ?? '')) !!}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if (!empty($content['note']))
                    <p class="text-sm text-blue-200 mt-4">{{ $content['note'] }}</p>
                @endif
            </div>
        </div>
    </div>
</div>
