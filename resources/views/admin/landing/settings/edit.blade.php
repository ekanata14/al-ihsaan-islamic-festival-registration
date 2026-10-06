@extends('layouts.app')

@section('content')
    @php
        use App\Support\LandingImage;

        $v = fn ($key, $default = '') => old($key, $settings[$key] ?? $default);
        $navbarRows = old('navbar_links', json_decode($settings['navbar_links'] ?? '[]', true) ?: []);
        $quickLinkRows = old('footer_quick_links', json_decode($settings['footer_quick_links'] ?? '[]', true) ?: []);
        $socialRows = old('footer_socials', json_decode($settings['footer_socials'] ?? '[]', true) ?: []);
        $eventDate = $v('event_date') ? str_replace(' ', 'T', substr($v('event_date'), 0, 16)) : '';
        $inputClass = 'block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-[#1D6594] focus:ring-[#1D6594] bg-gray-50 focus:bg-white transition-colors text-sm';
        $labelClass = 'font-bold text-gray-700 mb-2 block text-sm';
    @endphp

    <div class="py-8 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8" x-data="{ tab: 'umum' }">

        <x-breadcrumb :links="[
            'Konten Landing' => route('admin.dashboard.landing.content'),
            'Pengaturan' => '#',
        ]" />

        <div class="mb-6">
            <h2 class="text-2xl font-extrabold text-gray-900">Pengaturan Landing Page</h2>
            <p class="text-sm text-gray-500 mt-1">Atur identitas, tema warna, menu navbar, dan isi footer.</p>
        </div>

        <div class="flex flex-wrap gap-2 mb-4">
            @foreach (['umum' => 'Umum', 'tema' => 'Tema', 'navbar' => 'Navbar', 'footer' => 'Footer', 'acara' => 'Acara'] as $key => $label)
                <button type="button" @click="tab = '{{ $key }}'"
                    :class="tab === '{{ $key }}' ? 'bg-[#1D6594] text-white shadow-md' : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200'"
                    class="px-5 py-2.5 rounded-xl font-bold text-sm transition-all">
                    {{ $label }}
                </button>
            @endforeach
        </div>

        <form action="{{ route('admin.dashboard.landing.settings.update') }}" method="POST"
            enctype="multipart/form-data" class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 sm:p-8">
            @csrf
            @method('PUT')

            {{-- TAB UMUM --}}
            <div x-show="tab === 'umum'" class="space-y-6">
                <div>
                    <label class="{{ $labelClass }}">Nama Situs</label>
                    <input type="text" name="site_name" value="{{ $v('site_name') }}" class="{{ $inputClass }}">
                </div>
                <div>
                    <label class="{{ $labelClass }}">Judul Tab Browser (Meta Title)</label>
                    <input type="text" name="meta_title" value="{{ $v('meta_title') }}" class="{{ $inputClass }}">
                </div>
                <div>
                    <label class="{{ $labelClass }}">Deskripsi Situs (Meta Description)</label>
                    <textarea name="meta_description" rows="2" class="{{ $inputClass }}">{{ $v('meta_description') }}</textarea>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    @foreach (['logo' => 'Logo', 'favicon' => 'Favicon'] as $key => $label)
                        <div x-data="{ preview: {{ \Illuminate\Support\Js::from(LandingImage::url($v($key))) }} }">
                            <label class="{{ $labelClass }}">{{ $label }}</label>
                            <div class="flex items-center gap-3">
                                <template x-if="preview">
                                    <img :src="preview" class="h-14 w-14 object-contain rounded-xl border border-gray-200 bg-gray-50 p-1">
                                </template>
                                <input type="file" name="file[{{ $key }}]" accept="image/*"
                                    @change="preview = URL.createObjectURL($event.target.files[0])"
                                    class="flex-1 text-xs text-gray-500 file:mr-2 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-[#1D6594]">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- TAB TEMA --}}
            <div x-show="tab === 'tema'" x-cloak class="space-y-6">
                <p class="text-sm text-gray-500">Warna ini dipakai pada Heading, tombol, dan aksen halaman.</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6" x-data="{ p: '{{ $v('primary_color', '#1D6594') }}', a: '{{ $v('accent_color', '#E9AA14') }}' }">
                    <div>
                        <label class="{{ $labelClass }}">Warna Utama</label>
                        <div class="flex items-center gap-3">
                            <input type="color" name="primary_color" x-model="p" value="{{ $v('primary_color', '#1D6594') }}"
                                class="h-12 w-16 rounded-lg border border-gray-200 bg-white cursor-pointer">
                            <span class="text-sm font-mono text-gray-500" x-text="p"></span>
                        </div>
                    </div>
                    <div>
                        <label class="{{ $labelClass }}">Warna Aksen</label>
                        <div class="flex items-center gap-3">
                            <input type="color" name="accent_color" x-model="a" value="{{ $v('accent_color', '#E9AA14') }}"
                                class="h-12 w-16 rounded-lg border border-gray-200 bg-white cursor-pointer">
                            <span class="text-sm font-mono text-gray-500" x-text="a"></span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TAB NAVBAR --}}
            <div x-show="tab === 'navbar'" x-cloak class="space-y-4">
                <p class="text-sm text-gray-500">Atur tautan menu di navbar (berlaku desktop & mobile).</p>
                @include('admin.landing.settings._repeater', [
                    'name' => 'navbar_links',
                    'rows' => $navbarRows,
                    'colLabels' => ['label' => 'Label', 'url' => 'Tautan (mis. #lomba)'],
                ])
            </div>

            {{-- TAB FOOTER --}}
            <div x-show="tab === 'footer'" x-cloak class="space-y-6">
                <label class="inline-flex items-center gap-2 cursor-pointer">
                    <input type="hidden" name="footer_show" value="0">
                    <input type="checkbox" name="footer_show" value="1"
                        {{ $v('footer_show', '1') == '1' ? 'checked' : '' }}
                        class="rounded border-gray-300 text-[#1D6594] focus:ring-[#1D6594]">
                    <span class="text-sm font-medium text-gray-600">Tampilkan footer di halaman</span>
                </label>

                <div>
                    <label class="{{ $labelClass }}">Tentang (About)</label>
                    <textarea name="footer_about" rows="3" class="{{ $inputClass }}">{{ $v('footer_about') }}</textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="{{ $labelClass }}">Alamat</label>
                        <input type="text" name="footer_address" value="{{ $v('footer_address') }}" class="{{ $inputClass }}">
                    </div>
                    <div>
                        <label class="{{ $labelClass }}">Telepon / WhatsApp</label>
                        <input type="text" name="footer_phone" value="{{ $v('footer_phone') }}" class="{{ $inputClass }}">
                    </div>
                    <div>
                        <label class="{{ $labelClass }}">Email</label>
                        <input type="email" name="footer_email" value="{{ $v('footer_email') }}" class="{{ $inputClass }}">
                    </div>
                    <div>
                        <label class="{{ $labelClass }}">Teks Copyright</label>
                        <input type="text" name="footer_copyright" value="{{ $v('footer_copyright') }}" class="{{ $inputClass }}">
                    </div>
                </div>

                <div>
                    <label class="{{ $labelClass }}">Tautan Cepat</label>
                    @include('admin.landing.settings._repeater', [
                        'name' => 'footer_quick_links',
                        'rows' => $quickLinkRows,
                        'colLabels' => ['label' => 'Label', 'url' => 'Tautan'],
                    ])
                </div>

                <div>
                    <label class="{{ $labelClass }}">Media Sosial</label>
                    @include('admin.landing.settings._repeater', [
                        'name' => 'footer_socials',
                        'rows' => $socialRows,
                        'colLabels' => ['label' => 'Nama', 'url' => 'Tautan'],
                    ])
                </div>
            </div>

            {{-- TAB ACARA --}}
            <div x-show="tab === 'acara'" x-cloak class="space-y-6">
                <div>
                    <label class="{{ $labelClass }}">Tanggal & Jam Acara</label>
                    <input type="datetime-local" name="event_date" value="{{ $eventDate }}" class="{{ $inputClass }}">
                    <p class="text-xs text-gray-400 mt-1">Dipakai sebagai target hitung mundur default.</p>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-100 mt-8">
                <a href="{{ route('admin.dashboard.landing.content') }}"
                    class="px-6 py-3 text-gray-600 font-bold hover:bg-gray-100 rounded-xl transition-colors">Batal</a>
                <button type="submit"
                    class="px-8 py-3 bg-[#1D6594] text-white font-bold rounded-xl shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all">
                    Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>
@endsection
