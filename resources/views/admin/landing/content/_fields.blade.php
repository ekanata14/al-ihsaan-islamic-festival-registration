@php
    use App\Support\LandingImage;
    use Illuminate\Support\Js;
@endphp

@foreach ($schema['fields'] as $field)
    @php
        $name = $field['name'];
        $type = $field['type'];
        $value = old("content.$name", $content[$name] ?? ($field['default'] ?? ''));
        $inputClass = 'block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-[#1D6594] focus:ring-[#1D6594] bg-gray-50 focus:bg-white transition-colors text-sm';
    @endphp

    <div class="mb-6">
        <label class="font-bold text-gray-700 mb-2 block text-sm">
            {{ $field['label'] }}
        </label>

        @switch($type)
            @case('text')
                <input type="text" name="content[{{ $name }}]" value="{{ $value }}"
                    placeholder="{{ $field['placeholder'] ?? '' }}" class="{{ $inputClass }}">
            @break

            @case('number')
                <input type="number" name="content[{{ $name }}]" value="{{ $value }}" class="{{ $inputClass }}">
            @break

            @case('datetime')
                @php $dtValue = $value ? str_replace(' ', 'T', substr($value, 0, 16)) : ''; @endphp
                <input type="datetime-local" name="content[{{ $name }}]" value="{{ $dtValue }}" class="{{ $inputClass }}">
            @break

            @case('textarea')
                <textarea name="content[{{ $name }}]" rows="3" class="{{ $inputClass }}">{{ $value }}</textarea>
            @break

            @case('html')
                <textarea name="content[{{ $name }}]" rows="8"
                    class="{{ $inputClass }} font-mono text-xs">{{ $value }}</textarea>
            @break

            @case('select')
                <select name="content[{{ $name }}]" class="{{ $inputClass }}">
                    @foreach ($field['options'] ?? [] as $optionValue => $optionLabel)
                        <option value="{{ $optionValue }}" {{ (string) $value === (string) $optionValue ? 'selected' : '' }}>
                            {{ $optionLabel }}
                        </option>
                    @endforeach
                </select>
            @break

            @case('checkbox')
                <input type="hidden" name="content[{{ $name }}]" value="0">
                <label class="inline-flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="content[{{ $name }}]" value="1"
                        {{ $value ? 'checked' : '' }}
                        class="rounded border-gray-300 text-[#1D6594] focus:ring-[#1D6594]">
                    <span class="text-sm text-gray-600">{{ $field['help'] ?? 'Aktifkan' }}</span>
                </label>
            @break

            @case('image')
                @php $previewUrl = LandingImage::url($value); @endphp
                <div x-data="{ preview: {{ Js::from($previewUrl) }} }" class="flex items-center gap-4">
                    <template x-if="preview">
                        <img :src="preview" class="h-20 w-20 object-contain rounded-xl border border-gray-200 bg-gray-50 p-1">
                    </template>
                    <template x-if="!preview">
                        <div class="h-20 w-20 rounded-xl border border-dashed border-gray-300 bg-gray-50 flex items-center justify-center text-gray-300">
                            <x-landing-icon name="document" class="w-6 h-6" />
                        </div>
                    </template>
                    <div class="flex-1">
                        <input type="file" name="file[{{ $name }}]" accept="image/*"
                            @change="preview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : preview"
                            class="w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-blue-50 file:text-[#1D6594] hover:file:bg-blue-100">
                        <input type="hidden" name="content[{{ $name }}]" value="{{ $value }}">
                        <p class="text-xs text-gray-400 mt-1">{{ $field['help'] ?? 'Unggah gambar atau biarkan kosong.' }}</p>
                    </div>
                </div>
            @break

            @case('repeater')
                @php
                    $rows = $value;
                    if (!is_array($rows)) {
                        $rows = [];
                    }
                    $rows = array_values($rows);
                    $blank = [];
                    foreach ($field['subfields'] ?? [] as $sub) {
                        $blank[$sub['name']] = $sub['type'] === 'select' ? array_key_first($sub['options'] ?? ['']) : '';
                    }
                @endphp
                <div x-data='{ items: {{ Js::from($rows) }}, blank: {{ Js::from($blank) }}, add() { this.items.push({ ...this.blank }) }, remove(i) { this.items.splice(i, 1) } }'
                    class="space-y-3">
                    <template x-for="(item, index) in items" :key="index">
                        <div class="bg-gray-50 border border-gray-200 rounded-xl p-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach ($field['subfields'] ?? [] as $sub)
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 mb-1">{{ $sub['label'] }}</label>
                                        @if ($sub['type'] === 'select')
                                            <select :name="`content[{{ $name }}][${index}][{{ $sub['name'] }}]`"
                                                x-model="item.{{ $sub['name'] }}"
                                                class="block w-full px-3 py-2 text-sm rounded-lg border-gray-300 focus:border-[#1D6594] focus:ring-[#1D6594] bg-white">
                                                @foreach ($sub['options'] ?? [] as $optionValue => $optionLabel)
                                                    <option value="{{ $optionValue }}">{{ $optionLabel }}</option>
                                                @endforeach
                                            </select>
                                        @elseif ($sub['type'] === 'textarea')
                                            <textarea :name="`content[{{ $name }}][${index}][{{ $sub['name'] }}]`"
                                                x-model="item.{{ $sub['name'] }}" rows="2"
                                                class="block w-full px-3 py-2 text-sm rounded-lg border-gray-300 focus:border-[#1D6594] focus:ring-[#1D6594] bg-white"></textarea>
                                        @else
                                            <input type="text" :name="`content[{{ $name }}][${index}][{{ $sub['name'] }}]`"
                                                x-model="item.{{ $sub['name'] }}"
                                                class="block w-full px-3 py-2 text-sm rounded-lg border-gray-300 focus:border-[#1D6594] focus:ring-[#1D6594] bg-white">
                                        @endif
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
                        <p class="text-sm text-gray-400 italic">Belum ada data. Klik "Tambah Baris" untuk menambahkan.</p>
                    </template>

                    <button type="button" @click="add()"
                        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-bold text-[#1D6594] bg-blue-50 hover:bg-blue-100 rounded-xl transition-colors">
                        <x-landing-icon name="plus" class="w-4 h-4" />
                        Tambah Baris
                    </button>
                </div>
            @break

            @default
                <input type="text" name="content[{{ $name }}]" value="{{ $value }}" class="{{ $inputClass }}">
        @endswitch

        @if (!empty($field['help']) && $type !== 'checkbox' && $type !== 'image')
            <p class="text-xs text-gray-400 mt-1">{{ $field['help'] }}</p>
        @endif

        @error("content.$name")
            <p class="text-rose-500 text-sm mt-2 font-medium">{{ $message }}</p>
        @enderror
    </div>
@endforeach
