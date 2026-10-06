@php
    $limit = (int) ($content['limit'] ?? 8);
    $items = $competitions->unique('name')->take($limit > 0 ? $limit : null);
    $showButton = !isset($content['show_button']) || (bool) $content['show_button'];
@endphp

<div class="py-20 bg-gray-50 w-full" id="lomba">
    <div class="max-w-7xl mx-auto px-4 w-full">
        <div class="section-header text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-extrabold lp-text mb-3">{{ $content['title'] ?? '' }}</h2>
            <div class="w-20 h-1.5 la-bg mx-auto rounded-full"></div>
            @if (!empty($content['subtitle']))
                <p class="text-gray-600 max-w-2xl mx-auto mt-6">{{ $content['subtitle'] }}</p>
            @endif
        </div>

        <div class="lomba-container grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 w-full">
            @forelse ($items as $item)
                <div class="gsap-card bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 border border-gray-100 flex flex-col overflow-hidden group">
                    <div class="relative overflow-hidden bg-gray-100 flex justify-center items-center h-48 p-4 w-full">
                        <img class="w-full h-full object-contain transform group-hover:scale-110 transition-transform duration-500"
                            src="{{ asset('assets/images/logo_only.png') }}" alt="{{ $item->name }}" />
                        <div class="absolute inset-0 lp-bg opacity-0 group-hover:opacity-60 transition-opacity duration-300"></div>
                    </div>
                    <div class="p-6 flex flex-col flex-grow justify-between gap-4">
                        <h5 class="text-xl font-bold text-gray-800 transition-colors line-clamp-2">
                            {{ $item->name }}
                        </h5>
                        @if ($showButton)
                            <a href="{{ route('register') }}"
                                class="w-full text-center py-2.5 rounded-xl la-bg text-white font-bold shadow hover:opacity-90 hover:shadow-md transition-all duration-300 flex justify-center items-center gap-2">
                                Daftar Sekarang
                                <x-landing-icon name="arrow-right" class="w-4 h-4" />
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white border border-gray-200 rounded-2xl shadow-sm p-8 text-center w-full">
                    <h5 class="text-xl font-bold text-gray-500">{{ $content['empty_text'] ?? 'Belum ada perlombaan yang tersedia saat ini.' }}</h5>
                </div>
            @endforelse
        </div>
    </div>
</div>
