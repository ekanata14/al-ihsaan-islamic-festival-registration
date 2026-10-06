@php
    $bellUser = auth()->user();
    $bellUnread = $bellUser->unreadNotifications()->count();
    $bellItems = $bellUser->notifications()->latest()->limit(8)->get();
@endphp

<div x-data="{ open: false }" class="relative">
    <button type="button" @click="open = !open"
        class="relative flex items-center justify-center p-2.5 text-gray-500 hover:text-[#1D6594] hover:bg-gray-100 rounded-full transition-colors"
        title="Notifikasi">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
        </svg>
        <span data-notification-count
            class="absolute -top-0.5 -right-0.5 min-w-[18px] h-[18px] px-1 items-center justify-center rounded-full bg-rose-500 text-white text-[10px] font-extrabold border-2 border-white {{ $bellUnread > 0 ? 'flex' : 'hidden' }}">
            {{ $bellUnread }}
        </span>
    </button>

    <div x-show="open" x-cloak @click.outside="open = false" x-transition.origin.top.right
        class="absolute right-0 mt-2 w-80 max-w-[calc(100vw-2rem)] bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden z-50"
        style="display: none;">
        <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100">
            <h3 class="font-extrabold text-gray-800 text-sm">Notifikasi</h3>
            @if ($bellUnread > 0)
                <form action="{{ route('notifications.read-all') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="text-xs font-bold text-[#1D6594] hover:underline">Tandai semua dibaca</button>
                </form>
            @endif
        </div>

        <div class="max-h-80 overflow-y-auto custom-scrollbar divide-y divide-gray-50">
            @forelse ($bellItems as $item)
                <form action="{{ route('notifications.read', $item->id) }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-3 hover:bg-gray-50 transition-colors {{ $item->read_at ? '' : 'bg-blue-50/40' }}">
                        <div class="flex items-start gap-2">
                            @unless ($item->read_at)
                                <span class="mt-1.5 w-2 h-2 rounded-full bg-[#1D6594] shrink-0"></span>
                            @endunless
                            <div class="min-w-0">
                                <p class="text-sm {{ $item->read_at ? 'font-medium text-gray-700' : 'font-bold text-gray-900' }}">
                                    {{ $item->data['title'] ?? 'Notifikasi' }}
                                </p>
                                <p class="text-xs text-gray-500 mt-0.5 leading-snug">{{ $item->data['message'] ?? '' }}</p>
                                <p class="text-[10px] text-gray-400 mt-1">{{ $item->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </button>
                </form>
            @empty
                <div class="px-4 py-8 text-center text-sm text-gray-400">
                    Belum ada notifikasi.
                </div>
            @endforelse
        </div>

        <a href="{{ route('notifications.index') }}"
            class="block text-center px-4 py-3 text-sm font-bold text-[#1D6594] hover:bg-blue-50 transition-colors border-t border-gray-100">
            Lihat semua notifikasi
        </a>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const url = '{{ route('notifications.unread-count') }}';
            const refresh = async () => {
                try {
                    const res = await fetch(url, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
                        credentials: 'same-origin',
                    });
                    if (!res.ok) return;
                    const data = await res.json();
                    document.querySelectorAll('[data-notification-count]').forEach(el => {
                        el.textContent = data.count;
                        el.classList.toggle('hidden', data.count <= 0);
                        el.classList.toggle('flex', data.count > 0);
                    });
                } catch (e) { /* diamkan */ }
            };
            setInterval(refresh, 60000);
        });
    </script>
@endpush
