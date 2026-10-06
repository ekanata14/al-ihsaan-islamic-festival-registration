@php
    use Illuminate\Support\Js;

    $rows = array_values(is_array($rows ?? null) ? $rows : []);
    $colLabels = $colLabels ?? ['label' => 'Teks', 'url' => 'Tautan'];
    $blank = [];
    foreach (array_keys($colLabels) as $key) {
        $blank[$key] = '';
    }
@endphp

<div x-data='{ items: {{ Js::from($rows) }}, blank: {{ Js::from($blank) }}, add() { this.items.push({ ...this.blank }) }, remove(i) { this.items.splice(i, 1) } }'
    class="space-y-3">
    <template x-for="(item, index) in items" :key="index">
        <div class="bg-gray-50 border border-gray-200 rounded-xl p-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                @foreach ($colLabels as $key => $label)
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-1">{{ $label }}</label>
                        <input type="text" :name="`{{ $name }}[${index}][{{ $key }}]`" x-model="item.{{ $key }}"
                            class="block w-full px-3 py-2 text-sm rounded-lg border-gray-300 focus:border-[#1D6594] focus:ring-[#1D6594] bg-white">
                    </div>
                @endforeach
            </div>
            <div class="text-right mt-3">
                <button type="button" @click="remove(index)"
                    class="text-xs font-bold text-rose-500 hover:text-rose-700">Hapus baris</button>
            </div>
        </div>
    </template>

    <template x-if="items.length === 0">
        <p class="text-sm text-gray-400 italic">Belum ada data.</p>
    </template>

    <button type="button" @click="add()"
        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-bold text-[#1D6594] bg-blue-50 hover:bg-blue-100 rounded-xl transition-colors">
        <x-landing-icon name="plus" class="w-4 h-4" />
        Tambah Baris
    </button>
</div>
