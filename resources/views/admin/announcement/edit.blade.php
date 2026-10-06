@extends('layouts.app')

@section('content')
    @php $inputClass = 'block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-amber-500 focus:ring-amber-500 bg-gray-50 focus:bg-white transition-colors text-sm'; @endphp

    <div class="py-8 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        <x-breadcrumb :links="['Pengumuman' => route('admin.dashboard.announcement'), 'Edit' => '#']" />

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gray-50 p-6 sm:px-8 border-b border-gray-100 flex items-center justify-between gap-3">
                <div>
                    <h3 class="text-xl font-extrabold text-gray-800">Edit Pengumuman</h3>
                    <p class="text-sm text-gray-500 mt-1">Perbarui isi atau target pengumuman.</p>
                </div>
                @if ($data->is_published)
                    <span class="px-3 py-1 text-xs font-bold rounded-lg bg-emerald-50 text-emerald-600 whitespace-nowrap">Sudah Terkirim</span>
                @else
                    <span class="px-3 py-1 text-xs font-bold rounded-lg bg-gray-100 text-gray-500 whitespace-nowrap">Draf</span>
                @endif
            </div>

            <form action="{{ route('admin.dashboard.announcement.update') }}" method="POST" class="p-6 sm:p-8">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{ $data->id }}">

                <div class="mb-6">
                    <label class="font-bold text-gray-700 mb-2 block text-sm">Judul</label>
                    <input type="text" name="title" value="{{ old('title', $data->title) }}" class="{{ $inputClass }}" required autofocus>
                    @error('title')<p class="text-rose-500 text-sm mt-2 font-medium">{{ $message }}</p>@enderror
                </div>

                <div class="mb-6">
                    <label class="font-bold text-gray-700 mb-2 block text-sm">Isi Pengumuman</label>
                    <textarea name="body" rows="6" class="{{ $inputClass }}" required>{{ old('body', $data->body) }}</textarea>
                    @error('body')<p class="text-rose-500 text-sm mt-2 font-medium">{{ $message }}</p>@enderror
                </div>

                <div class="mb-6">
                    <label class="font-bold text-gray-700 mb-2 block text-sm">Sasaran</label>
                    <select name="target" class="{{ $inputClass }}">
                        @foreach ($targets as $value => $label)
                            <option value="{{ $value }}" {{ old('target', $data->target) == $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('target')<p class="text-rose-500 text-sm mt-2 font-medium">{{ $message }}</p>@enderror
                </div>

                <label class="inline-flex items-center gap-2 cursor-pointer">
                    <input type="hidden" name="is_published" value="0">
                    <input type="checkbox" name="is_published" value="1"
                        {{ old('is_published', $data->is_published) ? 'checked' : '' }}
                        {{ $data->is_published ? 'disabled' : '' }}
                        class="rounded border-gray-300 text-[#1D6594] focus:ring-[#1D6594] disabled:opacity-50">
                    <span class="text-sm font-medium text-gray-600">
                        {{ $data->is_published ? 'Pengumuman sudah terkirim' : 'Kirim sekarang (jika tidak dicentang, tetap sebagai draf)' }}
                    </span>
                </label>

                <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-100 mt-8">
                    <a href="{{ route('admin.dashboard.announcement') }}"
                        class="px-6 py-3 text-gray-600 font-bold hover:bg-gray-100 rounded-xl transition-colors">Batal</a>
                    <button type="submit"
                        class="px-8 py-3 bg-amber-500 text-white font-bold rounded-xl shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
