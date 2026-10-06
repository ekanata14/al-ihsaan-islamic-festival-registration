@extends('layouts.app')

@section('content')
    <div class="py-8 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        <x-breadcrumb :links="['Notifikasi' => '#']" />

        <div class="flex items-center justify-between mb-6 gap-4">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-900">Notifikasi</h2>
                <p class="text-sm text-gray-500 mt-1">Pemberitahuan transaksi, check-in, dan pengumuman dari panitia.</p>
            </div>
            @if ($notifications->contains(fn ($n) => is_null($n->read_at)))
                <form action="{{ route('notifications.read-all') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit"
                        class="px-4 py-2.5 bg-white border border-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition-all text-sm whitespace-nowrap">
                        Tandai semua dibaca
                    </button>
                </form>
            @endif
        </div>

        <div class="space-y-3">
            @forelse ($notifications as $item)
                <form action="{{ route('notifications.read', $item->id) }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit"
                        class="w-full text-left bg-white rounded-2xl border shadow-sm p-5 transition-all hover:shadow-md {{ $item->read_at ? 'border-gray-100' : 'border-[#1D6594]/30 bg-blue-50/30' }}">
                        <div class="flex items-start gap-3">
                            @unless ($item->read_at)
                                <span class="mt-1.5 w-2.5 h-2.5 rounded-full bg-[#1D6594] shrink-0"></span>
                            @endunless
                            <div class="min-w-0 flex-1">
                                <div class="flex items-start justify-between gap-3">
                                    <p class="{{ $item->read_at ? 'font-bold text-gray-700' : 'font-extrabold text-gray-900' }}">
                                        {{ $item->data['title'] ?? 'Notifikasi' }}
                                    </p>
                                    <span class="text-xs text-gray-400 whitespace-nowrap">{{ $item->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-sm text-gray-600 mt-1 leading-relaxed">{{ $item->data['message'] ?? '' }}</p>
                            </div>
                        </div>
                    </button>
                </form>
            @empty
                <div class="bg-white rounded-2xl border border-dashed border-gray-200 p-12 text-center">
                    <p class="text-lg font-bold text-gray-500">Belum ada notifikasi</p>
                    <p class="text-sm text-gray-400 mt-1">Semua pemberitahuan akan tampil di sini.</p>
                </div>
            @endforelse
        </div>

        @if ($notifications->hasPages())
            <div class="mt-6">
                {{ $notifications->links('pagination::tailwind') }}
            </div>
        @endif
    </div>
@endsection
