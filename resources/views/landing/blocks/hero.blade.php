@php
    use App\Support\LandingImage;

    $mode = $content['mode'] ?? 'normal';
    $isComingSoon = $mode === 'coming_soon';
    $background = LandingImage::url($content['background'] ?? null);
    $logo = LandingImage::url($content['logo'] ?? null, 'assets/images/logo.png');
    $target = $content['countdown_target'] ?? '';
    $buttons = collect($content['buttons'] ?? [])->filter(fn ($b) => !empty($b['label']));
    $resources = collect($content['resources'] ?? [])->filter(fn ($r) => !empty($r['url']));
    $buttonStyles = [
        'primary' => 'lp-bg text-white hover:opacity-90',
        'accent' => 'la-bg text-white hover:opacity-90',
        'outline' => 'bg-white text-gray-800 border-2 border-gray-200 hover:border-gray-300',
    ];
@endphp

<div class="relative min-h-screen flex items-center justify-center overflow-hidden px-4 pt-24 pb-12 w-full" id="hero">
    @if ($background)
        <div class="absolute inset-0 z-[-1]">
            <img src="{{ $background }}" alt="Latar Belakang" class="w-full h-full object-cover object-center opacity-80">
        </div>
    @endif

    <div class="hero-overlay"></div>

    <div class="bg-blob la-bg w-72 h-72 rounded-full top-20 left-10"></div>
    <div class="bg-blob lp-bg w-96 h-96 rounded-full bottom-10 right-10"></div>

    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-10 items-center w-full z-10 relative">
        <div class="flex flex-col justify-center items-center lg:items-start gap-5 text-center lg:text-left order-2 lg:order-1">
            @if (!empty($content['badge']))
                <span class="hero-elem px-4 py-1.5 rounded-full text-sm font-semibold bg-white/80 backdrop-blur-sm lp-text border lp-border shadow-sm">
                    {{ $content['badge'] }}
                </span>
            @endif

            @if ($isComingSoon)
                <span class="hero-elem px-5 py-2 rounded-full text-sm font-extrabold uppercase tracking-widest la-bg text-white shadow-md">
                    {{ $content['coming_soon_message'] ?: 'Segera Hadir' }}
                </span>
            @endif

            @if (!empty($content['title']))
                <h1 class="hero-elem text-4xl md:text-5xl xl:text-6xl font-extrabold leading-tight text-gray-900 drop-shadow-sm">
                    <span class="text-transparent bg-clip-text" style="background-image: linear-gradient(to right, var(--lp), var(--la));">
                        {{ $content['title'] }}
                    </span>
                </h1>
            @endif

            @if (!empty($content['subtitle']))
                <p class="hero-elem text-base md:text-lg text-gray-700 font-medium max-w-xl leading-relaxed drop-shadow-sm">
                    {{ $content['subtitle'] }}
                </p>
            @endif

            @if ($isComingSoon && $target)
                @php
                    $targetValue = str_replace(' ', 'T', trim($target));
                @endphp
                <div class="hero-elem w-full" x-data="{
                        target: new Date('{{ $targetValue }}').getTime(),
                        now: Date.now(),
                        init() { setInterval(() => this.now = Date.now(), 1000); },
                        get diff() { return Math.max(0, this.target - this.now); },
                        get days() { return Math.floor(this.diff / 86400000); },
                        get hours() { return Math.floor((this.diff % 86400000) / 3600000); },
                        get minutes() { return Math.floor((this.diff % 3600000) / 60000); },
                        get seconds() { return Math.floor((this.diff % 60000) / 1000); },
                        pad(n) { return String(n).padStart(2, '0'); }
                    }">
                    <div class="flex flex-wrap justify-center lg:justify-start gap-3 mt-2">
                        <template x-for="unit in [{v: days, l: 'Hari'}, {v: hours, l: 'Jam'}, {v: minutes, l: 'Menit'}, {v: seconds, l: 'Detik'}]" :key="unit.l">
                            <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-lg border border-white/60 px-5 py-3 min-w-[80px] text-center">
                                <div class="text-2xl md:text-3xl font-extrabold lp-text" x-text="pad(unit.v)"></div>
                                <div class="text-xs font-bold text-gray-500 uppercase tracking-wide" x-text="unit.l"></div>
                            </div>
                        </template>
                    </div>
                </div>
            @endif

            @unless ($isComingSoon)
                <div class="hero-elem flex flex-wrap justify-center lg:justify-start gap-4 mt-4 w-full">
                    @auth
                        <a href="{{ auth()->user()->role == 'admin' ? route('admin.dashboard') : route('user.dashboard') }}"
                            class="flex items-center gap-2 px-8 py-3.5 lp-bg text-white font-bold rounded-full shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                            Masuk Dashboard
                        </a>
                    @else
                        @foreach ($buttons as $button)
                            <a href="{{ $button['url'] ?? '#' }}"
                                class="flex items-center gap-2 px-8 py-3.5 font-bold rounded-full shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 {{ $buttonStyles[$button['style'] ?? 'primary'] ?? $buttonStyles['primary'] }}">
                                {{ $button['label'] }}
                                <x-landing-icon name="arrow-right" class="w-5 h-5" />
                            </a>
                        @endforeach
                    @endauth
                </div>
            @endunless

            @if ($resources->isNotEmpty())
                <div class="hero-elem flex flex-wrap justify-center lg:justify-start gap-3 mt-2 w-full">
                    @foreach ($resources as $resource)
                        <a href="{{ $resource['url'] }}" target="_blank"
                            class="flex items-center gap-2 px-6 py-2.5 bg-white/90 backdrop-blur-sm lp-text border-2 lp-border font-semibold rounded-full shadow-sm hover:bg-blue-50 transition-colors duration-300 text-sm">
                            <x-landing-icon name="play" class="w-4 h-4" />
                            {{ $resource['label'] ?? 'Buka' }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="hero-elem flex justify-center items-center order-1 lg:order-2 w-full">
            <div class="bg-white/60 p-6 md:p-12 rounded-3xl backdrop-blur-md shadow-2xl border border-white/50 w-full flex justify-center items-center">
                <img src="{{ $logo }}" alt="{{ $settings['site_name'] ?? 'Logo' }}"
                    class="w-full h-auto max-w-full object-contain drop-shadow-xl hover:scale-105 transition-transform duration-500">
            </div>
        </div>
    </div>
</div>
