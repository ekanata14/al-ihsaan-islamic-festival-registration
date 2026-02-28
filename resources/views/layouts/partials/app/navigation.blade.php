<div x-cloak x-show="sidebarOpen" x-transition.opacity.duration.300ms
    class="fixed inset-0 z-40 bg-gray-900/60 backdrop-blur-sm lg:hidden" @click="sidebarOpen = false"
    style="display: none;">
</div>

<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-100 shadow-lg lg:shadow-none flex flex-col transition-transform duration-300 ease-in-out -translate-x-full lg:translate-x-0">

    <div class="flex items-center justify-center h-16 border-b border-gray-100 px-4 shrink-0">
        <a href="{{ auth()->user()->role == 'admin' ? route('admin.dashboard') : route('user.dashboard') }}"
            class="flex items-center gap-3 group">
            <img src="{{ asset('assets/images/logo_only.png') }}" class="h-8 transition-transform group-hover:scale-110"
                alt="Logo">
            <span class="font-bold text-[#1D6594] text-lg tracking-tight">Al Ihsaan Fest</span>
        </a>
    </div>

    <div class="flex-1 overflow-y-auto py-6 px-4 space-y-1 custom-scrollbar">
        <p class="px-3 text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Menu Utama</p>

        @if (auth()->user()->role == 'admin')
            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors w-full {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-[#1D6594]' : 'text-gray-600 hover:bg-gray-50' }}">
                <span class="font-medium text-sm">Dashboard</span>
            </x-nav-link>
            <x-nav-link :href="route('admin.dashboard.user')" :active="request()->routeIs('admin.dashboard.user*')"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors w-full {{ request()->routeIs('admin.dashboard.user*') ? 'bg-blue-50 text-[#1D6594]' : 'text-gray-600 hover:bg-gray-50' }}">
                <span class="font-medium text-sm">User</span>
            </x-nav-link>
            <x-nav-link :href="route('admin.dashboard.group')" :active="request()->routeIs('admin.dashboard.group*')"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors w-full {{ request()->routeIs('admin.dashboard.group*') ? 'bg-blue-50 text-[#1D6594]' : 'text-gray-600 hover:bg-gray-50' }}">
                <span class="font-medium text-sm">Group</span>
            </x-nav-link>
            <x-nav-link :href="route('admin.dashboard.category')" :active="request()->routeIs('admin.dashboard.category*')"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors w-full {{ request()->routeIs('admin.dashboard.category*') ? 'bg-blue-50 text-[#1D6594]' : 'text-gray-600 hover:bg-gray-50' }}">
                <span class="font-medium text-sm">Category</span>
            </x-nav-link>
            <x-nav-link :href="route('admin.dashboard.competition')" :active="request()->routeIs('admin.dashboard.competition*')"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors w-full {{ request()->routeIs('admin.dashboard.competition*') ? 'bg-blue-50 text-[#1D6594]' : 'text-gray-600 hover:bg-gray-50' }}">
                <span class="font-medium text-sm">Competition</span>
            </x-nav-link>
            <x-nav-link :href="route('admin.dashboard.registration')" :active="request()->routeIs('admin.dashboard.registration*')"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors w-full {{ request()->routeIs('admin.dashboard.registration*') ? 'bg-blue-50 text-[#1D6594]' : 'text-gray-600 hover:bg-gray-50' }}">
                <span class="font-medium text-sm">Registration</span>
            </x-nav-link>
            <x-nav-link :href="route('admin.dashboard.check-in')" :active="request()->routeIs('admin.dashboard.check-in*')"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors w-full {{ request()->routeIs('admin.dashboard.check-in*') ? 'bg-blue-50 text-[#1D6594]' : 'text-gray-600 hover:bg-gray-50' }}">
                <span class="font-medium text-sm">Check In</span>
            </x-nav-link>
            <x-nav-link :href="route('admin.dashboard.sponsor')" :active="request()->routeIs('admin.dashboard.sponsor*')"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors w-full {{ request()->routeIs('admin.dashboard.sponsor*') ? 'bg-blue-50 text-[#1D6594]' : 'text-gray-600 hover:bg-gray-50' }}">
                <span class="font-medium text-sm">Sponsor</span>
            </x-nav-link>
            <x-nav-link :href="route('admin.dashboard.khitan-registration')" :active="request()->routeIs('admin.dashboard.khitan-registration*')"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors w-full {{ request()->routeIs('admin.dashboard.khitan-registration*') ? 'bg-emerald-50 text-emerald-700' : 'text-gray-600 hover:bg-gray-50' }}">
                <span class="font-medium text-sm">Data Khitan</span>
            </x-nav-link>
        @else
            <x-nav-link :href="route('user.dashboard')" :active="request()->routeIs('user.dashboard*')"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors w-full {{ request()->routeIs('user.dashboard*') ? 'bg-blue-50 text-[#1D6594]' : 'text-gray-600 hover:bg-gray-50' }}">
                <span class="font-medium text-sm">Daftar Lomba</span>
            </x-nav-link>
            <x-nav-link :href="route('user.participants')" :active="request()->routeIs('user.participants*')"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors w-full {{ request()->routeIs('user.participants*') ? 'bg-amber-50 text-amber-700' : 'text-gray-600 hover:bg-gray-50' }}">
                <span class="font-medium text-sm">Peserta Saya</span>
            </x-nav-link>
            <x-nav-link :href="route('khitan.dashboard')" :active="request()->routeIs('khitan.dashboard*')"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors w-full {{ request()->routeIs('khitan.dashboard*') ? 'bg-emerald-50 text-emerald-700' : 'text-gray-600 hover:bg-gray-50' }}">
                <span class="font-medium text-sm">Pendaftaran Khitan</span>
            </x-nav-link>
        @endif

        <div class="pt-8">
            <p class="px-3 text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Bantuan & Info</p>
            <a href="https://chat.whatsapp.com/Hi9IYZYEknYCMpF5mXayuN" target="_blank"
                class="flex items-center gap-3 px-3 py-2.5 text-gray-600 hover:bg-green-50 hover:text-green-700 rounded-xl transition-colors w-full">
                <span class="font-medium text-sm">Grup WA Lomba</span>
            </a>
            <a href="https://chat.whatsapp.com/By2POmbv4pzGFrgm304VSj" target="_blank"
                class="flex items-center gap-3 px-3 py-2.5 text-gray-600 hover:bg-green-50 hover:text-green-700 rounded-xl transition-colors w-full">
                <span class="font-medium text-sm">Grup WA Khitan</span>
            </a>
            <button type="button" onclick="document.getElementById('contactModal').classList.remove('hidden')"
                class="flex items-center gap-3 px-3 py-2.5 text-gray-600 hover:bg-rose-50 hover:text-rose-600 rounded-xl transition-colors w-full text-left">
                <span class="font-medium text-sm">Hubungi Panitia</span>
            </button>
        </div>
    </div>

    <div class="border-t border-gray-100 p-4 shrink-0 bg-gray-50/50">
        <div class="flex items-center gap-3 mb-4 px-2">
            <div
                class="w-10 h-10 rounded-full bg-[#1D6594] text-white flex items-center justify-center font-bold text-lg">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div class="overflow-hidden">
                <p class="text-sm font-bold text-gray-800 truncate">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
            </div>
        </div>

        <form method="POST" action="{{ route('logout') }}" class="w-full">
            @csrf
            <button type="submit"
                class="w-full py-2.5 px-4 bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-xl hover:bg-red-50 hover:text-red-600 hover:border-red-200 transition-all text-center shadow-sm flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                    </path>
                </svg>
                Keluar Akun
            </button>
        </form>
    </div>
</aside>
