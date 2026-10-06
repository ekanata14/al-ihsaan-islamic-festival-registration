@php
    use App\Support\LandingImage;
@endphp

<div class="py-20 bg-white w-full" id="sponsorship">
    <div class="max-w-7xl mx-auto px-4 w-full">
        <div class="section-header text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-extrabold lp-text mb-3">{{ $content['title'] ?? '' }}</h2>
            <div class="w-20 h-1.5 la-bg mx-auto rounded-full mb-6"></div>
            @if (!empty($content['subtitle']))
                <p class="text-gray-600 max-w-2xl mx-auto">{{ $content['subtitle'] }}</p>
            @endif
        </div>

        <div class="sponsor-container grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6 md:gap-8 justify-items-center mb-12 w-full">
            @foreach ($sponsors as $sponsor)
                <div class="gsap-sponsor p-4 grayscale hover:grayscale-0 hover:scale-110 transition-all duration-300 flex justify-center items-center w-full h-24">
                    <img src="{{ LandingImage::url($sponsor->img_url) }}" alt="{{ $sponsor->name }}" class="max-h-full max-w-full object-contain">
                </div>
            @endforeach
        </div>

        @if (!empty($content['cta_title']) || !empty($content['cta_url']))
            <div class="gsap-contact-sponsor bg-[#f8fbff] border border-[#e0f0ff] rounded-2xl p-8 max-w-3xl mx-auto text-center shadow-sm w-full">
                @if (!empty($content['cta_title']))
                    <h4 class="text-xl font-bold text-gray-800 mb-2">{{ $content['cta_title'] }}</h4>
                @endif
                @if (!empty($content['cta_text']))
                    <p class="text-gray-600 mb-6">{{ $content['cta_text'] }}</p>
                @endif
                @if (!empty($content['cta_url']))
                    <a href="{{ $content['cta_url'] }}" target="_blank"
                        class="inline-flex items-center gap-3 bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-8 rounded-full shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <img src="{{ asset('assets/icons/whatsapp.png') }}" alt="WA" class="h-6 w-6">
                        {{ $content['cta_label'] ?? 'Hubungi Kami' }}
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>
