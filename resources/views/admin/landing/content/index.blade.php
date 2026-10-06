@extends('layouts.app')

@section('content')
    <div class="py-8 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <x-breadcrumb :links="['Konten Landing' => '#']" />

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-900">Konten & Layout Landing Page</h2>
                <p class="text-sm text-gray-500 mt-1">Susun blok halaman dengan menambah, mengurutkan (geser), atau
                    menyembunyikan blok.</p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.dashboard.landing.settings') }}"
                    class="inline-flex items-center justify-center px-5 py-2.5 bg-white border border-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition-all gap-2">
                    Pengaturan
                </a>
                <button type="button" onclick="document.getElementById('addBlockModal').classList.remove('hidden')"
                    class="inline-flex items-center justify-center px-5 py-2.5 bg-[#1D6594] text-white font-bold rounded-xl hover:bg-[#154d73] transition-all shadow-sm hover:shadow-md gap-2">
                    <x-landing-icon name="plus" class="w-5 h-5" />
                    Tambah Blok
                </button>
            </div>
        </div>

        @if (session('error'))
            <div class="mb-4 px-4 py-3 rounded-xl bg-rose-50 border border-rose-200 text-rose-600 text-sm font-medium">
                {{ session('error') }}
            </div>
        @endif

        <p class="text-xs text-gray-400 mb-3">
            Urutan blok sesuai tampilan di halaman. Tahan ikon <span class="font-bold">⠿</span> lalu geser untuk
            mengubah urutan.
        </p>

        <div id="block-list" class="space-y-3">
            @forelse ($blocks as $block)
                @php $type = $types[$block->type] ?? null; @endphp
                <div class="block-item bg-white rounded-2xl border border-gray-100 shadow-sm p-4 flex items-center gap-4 cursor-grab active:cursor-grabbing transition-shadow hover:shadow-md"
                    draggable="true" data-id="{{ $block->id }}">
                    <div class="text-gray-300 shrink-0">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M7 4a1 1 0 11-2 0 1 1 0 012 0zm0 6a1 1 0 11-2 0 1 1 0 012 0zm0 6a1 1 0 11-2 0 1 1 0 012 0zm8-12a1 1 0 11-2 0 1 1 0 012 0zm0 6a1 1 0 11-2 0 1 1 0 012 0zm0 6a1 1 0 11-2 0 1 1 0 012 0z"/>
                        </svg>
                    </div>

                    <div class="w-11 h-11 rounded-xl bg-blue-50 text-[#1D6594] flex items-center justify-center shrink-0">
                        <x-landing-icon :name="$type['icon'] ?? 'document'" class="w-6 h-6" />
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2">
                            <p class="font-bold text-gray-800 truncate">{{ $block->name }}</p>
                            @if (!$block->is_active)
                                <span class="px-2 py-0.5 text-[10px] font-bold uppercase rounded-full bg-gray-100 text-gray-400">Nonaktif</span>
                            @else
                                <span class="px-2 py-0.5 text-[10px] font-bold uppercase rounded-full bg-emerald-50 text-emerald-600">Aktif</span>
                            @endif
                        </div>
                        <p class="text-xs text-gray-400">{{ $type['label'] ?? $block->type }}</p>
                    </div>

                    <div class="flex items-center gap-2 shrink-0">
                        <form action="{{ route('admin.dashboard.landing.content.toggle') }}" method="POST" class="m-0">
                            @csrf
                            <input type="hidden" name="id" value="{{ $block->id }}">
                            <button type="submit" title="{{ $block->is_active ? 'Sembunyikan' : 'Tampilkan' }}"
                                class="p-2 rounded-lg transition-colors {{ $block->is_active ? 'text-emerald-600 bg-emerald-50 hover:bg-emerald-100' : 'text-gray-400 bg-gray-50 hover:bg-gray-100' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    @if ($block->is_active)
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>
                                    @endif
                                </svg>
                            </button>
                        </form>

                        <a href="{{ route('admin.dashboard.landing.content.edit', $block->id) }}" title="Edit"
                            class="p-2 text-amber-500 bg-amber-50 hover:bg-amber-500 hover:text-white rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </a>

                        <form action="{{ route('admin.dashboard.landing.content.destroy') }}" method="POST"
                            class="delete-form m-0">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" value="{{ $block->id }}">
                            <button type="submit" title="Hapus"
                                class="p-2 text-rose-500 bg-rose-50 hover:bg-rose-500 hover:text-white rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl border border-dashed border-gray-200 p-12 text-center">
                    <p class="text-lg font-bold text-gray-500">Belum ada blok.</p>
                    <p class="text-sm text-gray-400 mt-1">Klik "Tambah Blok" untuk mulai menyusun halaman.</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Modal pilih tipe blok --}}
    <div id="addBlockModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" onclick="document.getElementById('addBlockModal').classList.add('hidden')"></div>
        <div class="relative bg-white w-full max-w-3xl rounded-3xl shadow-2xl max-h-[85vh] overflow-y-auto custom-scrollbar">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 sticky top-0 bg-white z-10">
                <h3 class="text-lg font-extrabold text-gray-800">Pilih Tipe Blok</h3>
                <button type="button" onclick="document.getElementById('addBlockModal').classList.add('hidden')"
                    class="p-2 text-gray-400 hover:text-gray-700 rounded-lg hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach ($types as $key => $type)
                    <a href="{{ route('admin.dashboard.landing.content.create', ['type' => $key]) }}"
                        class="flex items-start gap-3 p-4 rounded-2xl border border-gray-100 hover:border-[#1D6594] hover:bg-blue-50/40 transition-colors group">
                        <span class="w-11 h-11 rounded-xl bg-blue-50 text-[#1D6594] flex items-center justify-center shrink-0">
                            <x-landing-icon :name="$type['icon'] ?? 'document'" class="w-6 h-6" />
                        </span>
                        <div>
                            <p class="font-bold text-gray-800 group-hover:text-[#1D6594]">{{ $type['label'] }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">{{ $type['description'] }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const list = document.getElementById('block-list');
                const csrf = '{{ csrf_token() }}';
                const reorderUrl = '{{ route('admin.dashboard.landing.content.reorder') }}';
                let dragged = null;

                if (list) {
                    list.addEventListener('dragstart', function(e) {
                        const item = e.target.closest('.block-item');
                        if (!item) return;
                        dragged = item;
                        item.classList.add('opacity-40');
                    });

                    list.addEventListener('dragend', function() {
                        if (dragged) dragged.classList.remove('opacity-40');
                        if (!dragged) return;
                        dragged = null;
                        persistOrder();
                    });

                    list.addEventListener('dragover', function(e) {
                        e.preventDefault();
                        if (!dragged) return;
                        const after = getDragAfterElement(list, e.clientY);
                        if (after == null) {
                            list.appendChild(dragged);
                        } else {
                            list.insertBefore(dragged, after);
                        }
                    });

                    list.addEventListener('drop', function(e) {
                        e.preventDefault();
                    });
                }

                function getDragAfterElement(container, y) {
                    const items = [...container.querySelectorAll('.block-item:not(.opacity-40)')];
                    return items.reduce((closest, child) => {
                        const box = child.getBoundingClientRect();
                        const offset = y - box.top - box.height / 2;
                        if (offset < 0 && offset > closest.offset) {
                            return { offset: offset, element: child };
                        }
                        return closest;
                    }, { offset: Number.NEGATIVE_INFINITY, element: null }).element;
                }

                function persistOrder() {
                    const order = [...list.querySelectorAll('.block-item')].map(el => el.dataset.id);
                    fetch(reorderUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrf,
                        },
                        body: JSON.stringify({ order: order }),
                    }).then(r => {
                        if (r.ok) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Urutan disimpan',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    }).catch(() => {});
                }

                document.querySelectorAll('.delete-form').forEach(form => {
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();
                        Swal.fire({
                            title: 'Hapus Blok?',
                            text: "Blok ini akan dihapus dari halaman.",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#1D6594',
                            confirmButtonText: 'Ya, Hapus!',
                            cancelButtonText: 'Batal',
                            reverseButtons: true,
                            customClass: { popup: 'rounded-3xl' }
                        }).then((result) => {
                            if (result.isConfirmed) form.submit();
                        });
                    });
                });
            });
        </script>
    @endpush
@endsection
