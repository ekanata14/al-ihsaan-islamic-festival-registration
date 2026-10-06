@php
    $role = auth()->user()->role ?? 'user';

    if ($role === 'admin') {
        $navItems = [
            ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'active' => 'admin.dashboard', 'icon' => 'home'],
            ['label' => 'Registrasi', 'route' => 'admin.dashboard.registration', 'active' => 'admin.dashboard.registration*', 'icon' => 'clipboard'],
            ['label' => 'Pembayaran', 'route' => 'admin.dashboard.payment', 'active' => 'admin.dashboard.payment*', 'icon' => 'card'],
            ['label' => 'Akun', 'route' => 'profile.edit', 'active' => 'profile.*', 'icon' => 'cog'],
        ];
    } else {
        $navItems = [
            ['label' => 'Dashboard', 'route' => 'user.dashboard', 'active' => 'user.dashboard*', 'icon' => 'home'],
            ['label' => 'Pembayaran', 'route' => 'user.payment', 'active' => 'user.payment*', 'icon' => 'card'],
            ['label' => 'Peserta', 'route' => 'user.participants', 'active' => 'user.participants*', 'icon' => 'users'],
            ['label' => 'Akun', 'route' => 'profile.edit', 'active' => 'profile.*', 'icon' => 'cog'],
        ];
    }

    $icons = [
        'home' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h4v-6h4v6h4a1 1 0 001-1V10"/>',
        'card' => '<rect x="3" y="5" width="18" height="14" rx="2" stroke-linecap="round" stroke-linejoin="round"/><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h2"/>',
        'users' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>',
        'cog' => '<path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><circle cx="12" cy="12" r="3" stroke-linecap="round" stroke-linejoin="round"/>',
    ];
@endphp

<nav class="lg:hidden fixed inset-x-0 bottom-0 z-30 bg-white border-t border-gray-100 shadow-[0_-2px_10px_rgba(0,0,0,0.06)] print:hidden"
    style="padding-bottom: env(safe-area-inset-bottom);">
    <div class="grid grid-cols-4">
        @foreach ($navItems as $item)
            @php $isActive = request()->routeIs($item['active']); @endphp
            <a href="{{ route($item['route']) }}"
                class="flex flex-col items-center justify-center gap-1 py-2.5 transition-colors {{ $isActive ? 'text-[#1D6594]' : 'text-gray-400 hover:text-[#1D6594]' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="{{ $isActive ? 2.2 : 1.8 }}"
                    viewBox="0 0 24 24">
                    {!! $icons[$item['icon']] ?? '' !!}
                </svg>
                <span class="text-[11px] font-bold {{ $isActive ? '' : 'font-medium' }}">{{ $item['label'] }}</span>
                <span class="h-1 w-1 rounded-full {{ $isActive ? 'bg-[#1D6594]' : 'bg-transparent' }}"></span>
            </a>
        @endforeach
    </div>
</nav>
