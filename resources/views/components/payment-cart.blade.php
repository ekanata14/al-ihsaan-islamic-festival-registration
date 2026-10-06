@php
    $cartUser = auth()->user();
    $cartShow = false;
    $cartPayment = null;
    $cartChildren = collect();

    if ($cartUser && in_array($cartUser->role, ['user', 'khitan'], true)) {
        $cartSummary = app(\App\Support\PaymentService::class)->unpaidFor($cartUser);
        $cartShow = $cartSummary['has_unpaid'];
        $cartPayment = $cartSummary['payment'];
        $cartChildren = $cartSummary['children'];
    }
@endphp

@if ($cartShow)
    <div x-data="{ open: false }" x-cloak class="fixed right-4 lg:right-6 bottom-24 lg:bottom-6 z-40 print:hidden">
        {{-- Panel --}}
        <div x-show="open" x-transition.origin.bottom.right
            class="absolute bottom-full right-0 mb-3 w-80 max-w-[calc(100vw-2rem)] bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden"
            style="display: none;">
            <div class="bg-rose-50 px-5 py-4 border-b border-rose-100">
                <div class="flex items-center justify-between">
                    <h3 class="font-extrabold text-rose-700 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Belum Dibayar
                    </h3>
                    <span class="text-xs font-bold text-rose-600 bg-white rounded-full px-2.5 py-1 border border-rose-100">{{ $cartChildren->count() }} anak</span>
                </div>
                <p class="text-xs text-rose-600/80 mt-1">Peserta berikut masih menunggu pembayaran.</p>
            </div>

            <div class="max-h-64 overflow-y-auto custom-scrollbar divide-y divide-gray-100">
                @foreach ($cartChildren as $child)
                    <div class="px-5 py-3">
                        <p class="font-bold text-sm text-gray-800">{{ $child->name }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">
                            {{ $child->participants->map(fn ($p) => $p->registration?->competition?->name)->filter()->unique()->implode(', ') ?: 'Belum terdaftar lomba' }}
                        </p>
                    </div>
                @endforeach
            </div>

            <div class="px-5 py-4 bg-gray-50 border-t border-gray-100">
                @if ($cartPayment)
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-sm text-gray-500">Total Tagihan</span>
                        <span class="text-lg font-extrabold text-[#1D6594]">Rp {{ number_format($cartPayment->total_amount, 0, ',', '.') }}</span>
                    </div>
                @endif
                <a href="{{ route('user.payment') }}"
                    class="block w-full text-center py-2.5 bg-[#1D6594] hover:bg-[#154d73] text-white font-bold rounded-xl shadow-md transition-all">
                    Bayar Sekarang
                </a>
            </div>
        </div>

        {{-- Tombol --}}
        <button type="button" @click="open = !open"
            class="relative flex items-center justify-center w-14 h-14 rounded-full bg-rose-500 hover:bg-rose-600 text-white shadow-xl hover:shadow-2xl transition-all hover:-translate-y-0.5">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            <span class="absolute -top-1 -right-1 min-w-[22px] h-[22px] px-1 flex items-center justify-center rounded-full bg-[#E9AA14] text-white text-xs font-extrabold border-2 border-white">
                {{ $cartChildren->count() }}
            </span>
        </button>
    </div>
@endif
