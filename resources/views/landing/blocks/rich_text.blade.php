@php
    $backgrounds = [
        'white' => 'bg-white',
        'gray' => 'bg-gray-50',
        'primary' => 'lp-bg text-white',
    ];
    $bgClass = $backgrounds[$content['background'] ?? 'white'] ?? 'bg-white';
@endphp

<div class="py-16 w-full {{ $bgClass }}">
    <div class="max-w-4xl mx-auto px-4 w-full">
        @if (!empty($content['title']))
            <div class="section-header text-center mb-8">
                <h2 class="text-3xl md:text-4xl font-extrabold lp-text mb-3">{{ $content['title'] }}</h2>
                <div class="w-20 h-1.5 la-bg mx-auto rounded-full"></div>
            </div>
        @endif

        <div class="prose max-w-none text-gray-700 leading-relaxed">
            {!! $content['body'] ?? '' !!}
        </div>
    </div>
</div>
