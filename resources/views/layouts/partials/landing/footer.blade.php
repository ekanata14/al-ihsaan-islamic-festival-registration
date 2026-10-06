@php
    use App\Support\LandingImage;

    $showFooter = ($settings['footer_show'] ?? '1') !== '0';
    $quickLinks = collect(json_decode($settings['footer_quick_links'] ?? '[]', true) ?: [])
        ->filter(fn ($l) => !empty($l['label']));
    $socials = collect(json_decode($settings['footer_socials'] ?? '[]', true) ?: [])
        ->filter(fn ($s) => !empty($s['label']));
    $footerLogo = LandingImage::url($settings['logo'] ?? null, 'assets/images/logo_only.png');
@endphp

@if ($showFooter)
    <footer class="lp-bg text-white w-full">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
                <div class="lg:col-span-2">
                    <div class="flex items-center gap-3 mb-4">
                        <img src="{{ $footerLogo }}" alt="{{ $settings['site_name'] ?? 'Logo' }}" class="h-12 object-contain bg-white/90 rounded-xl p-1">
                        <span class="font-extrabold text-lg">{{ $settings['site_name'] ?? 'Al Ihsaan Islamic Festival' }}</span>
                    </div>
                    @if (!empty($settings['footer_about']))
                        <p class="text-sm text-white/80 leading-relaxed max-w-md">{{ $settings['footer_about'] }}</p>
                    @endif

                    @if ($socials->isNotEmpty())
                        <div class="flex flex-wrap gap-3 mt-5">
                            @foreach ($socials as $social)
                                @if (!empty($social['url']))
                                    <a href="{{ $social['url'] }}" target="_blank"
                                        class="px-4 py-2 rounded-full bg-white/10 hover:bg-white/20 border border-white/15 text-sm font-semibold transition-colors">
                                        {{ $social['label'] }}
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>

                <div>
                    <h4 class="font-bold uppercase tracking-wider text-sm mb-4 la-text">Tautan Cepat</h4>
                    <ul class="space-y-2 text-sm">
                        @foreach ($quickLinks as $link)
                            <li>
                                <a href="{{ $link['url'] ?? '#' }}" class="text-white/80 hover:text-white transition-colors">
                                    {{ $link['label'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold uppercase tracking-wider text-sm mb-4 la-text">Kontak</h4>
                    <ul class="space-y-3 text-sm text-white/80">
                        @if (!empty($settings['footer_address']))
                            <li class="flex items-start gap-2">
                                <x-landing-icon name="map" class="w-5 h-5 shrink-0 mt-0.5 la-text" />
                                <span>{{ $settings['footer_address'] }}</span>
                            </li>
                        @endif
                        @if (!empty($settings['footer_phone']))
                            <li class="flex items-start gap-2">
                                <x-landing-icon name="phone" class="w-5 h-5 shrink-0 mt-0.5 la-text" />
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['footer_phone']) }}" target="_blank" class="hover:text-white transition-colors">
                                    {{ $settings['footer_phone'] }}
                                </a>
                            </li>
                        @endif
                        @if (!empty($settings['footer_email']))
                            <li class="flex items-start gap-2">
                                <x-landing-icon name="document" class="w-5 h-5 shrink-0 mt-0.5 la-text" />
                                <a href="mailto:{{ $settings['footer_email'] }}" class="hover:text-white transition-colors">
                                    {{ $settings['footer_email'] }}
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>

            <div class="border-t border-white/15 mt-10 pt-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-sm text-white/70">
                <p>&copy; {{ date('Y') }} {{ $settings['footer_copyright'] ?? ($settings['site_name'] ?? 'Al Ihsaan Islamic Festival') }}</p>
                <p>Merajut Ukhuwah, Menggapai Berkah.</p>
            </div>
        </div>
    </footer>
@endif
