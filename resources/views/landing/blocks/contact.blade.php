@php
    $groups = collect($content['groups'] ?? [])->filter(fn ($g) => !empty($g['url']));
    $groupStyles = [
        'primary' => 'lp-bg text-white hover:opacity-90',
        'accent' => 'la-bg text-white hover:opacity-90',
    ];
@endphp

<div class="py-20 bg-gray-50 border-t border-gray-100 w-full" id="contact-us">
    <div class="max-w-4xl mx-auto px-4 text-center w-full">
        <div class="section-header mb-10">
            <h2 class="text-3xl md:text-4xl font-extrabold lp-text mb-3">{{ $content['title'] ?? '' }}</h2>
            <div class="w-20 h-1.5 la-bg mx-auto rounded-full mb-6"></div>
            @if (!empty($content['subtitle']))
                <p class="text-gray-600">{{ $content['subtitle'] }}</p>
            @endif
        </div>

        <div class="contact-container flex flex-wrap justify-center gap-4 mb-10 w-full">
            @foreach ($contacts as $contact)
                <a href="{{ $contact->whatsappUrl() }}" target="_blank"
                    class="gsap-contact w-full sm:w-auto flex items-center justify-center gap-3 bg-white hover:bg-green-50 border border-gray-200 hover:border-green-500 text-gray-700 hover:text-green-700 font-bold py-3 px-6 rounded-2xl transition-all duration-300 group shadow-sm hover:shadow-md">
                    <img src="{{ asset('assets/icons/whatsapp.png') }}" alt="WA" class="h-6 w-6 group-hover:scale-110 transition-transform">
                    {{ $contact->name }}
                    @if (!empty($contact->label))
                        <span class="text-xs font-medium text-gray-400">({{ $contact->label }})</span>
                    @endif
                </a>
            @endforeach
        </div>

        @if ($groups->isNotEmpty())
            <div class="flex flex-wrap justify-center gap-4 pt-4 w-full">
                @foreach ($groups as $group)
                    <a href="{{ $group['url'] }}" target="_blank"
                        class="gsap-contact flex items-center justify-center w-full sm:w-auto gap-2 px-8 py-3.5 font-bold rounded-full shadow-md hover:shadow-lg hover:-translate-y-1 transition-all duration-300 {{ $groupStyles[$group['style'] ?? 'primary'] ?? $groupStyles['primary'] }}">
                        <x-landing-icon name="phone" class="w-5 h-5" />
                        {{ $group['label'] ?? 'Grup WhatsApp' }}
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</div>
