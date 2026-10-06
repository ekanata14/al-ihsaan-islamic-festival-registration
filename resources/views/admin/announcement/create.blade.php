@extends('layouts.app')

@section('content')
    @php $inputClass = 'block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-[#1D6594] focus:ring-[#1D6594] bg-gray-50 focus:bg-white transition-colors text-sm'; @endphp

    <div class="py-8 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        <x-breadcrumb :links="['Pengumuman' => route('admin.dashboard.announcement'), 'Buat Baru' => '#']" />

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gray-50 p-6 sm:px-8 border-b border-gray-100">
                <h3 class="text-xl font-extrabold text-gray-800">Buat Pengumuman</h3>
                <p class="text-sm text-gray-500 mt-1">Pengumuman yang dikirim akan masuk ke notifikasi & email pengguna.</p>
            </div>

            <form action="{{ route('admin.dashboard.announcement.store') }}" method="POST" class="p-6 sm:p-8">
                @csrf

                <div class="mb-6">
                    <label class="font-bold text-gray-700 mb-2 block text-sm">Judul</label>
                    <input type="text" name="title" value="{{ old('title') }}" class="{{ $inputClass }}" required autofocus
                        placeholder="Contoh: Pengumuman Jadwal Perlombaan">
                    @error('title')<p class="text-rose-500 text-sm mt-2 font-medium">{{ $message }}</p>@enderror
                </div>

                <div class="mb-6">
                    <label class="font-bold text-gray-700 mb-2 block text-sm">Isi Pengumuman</label>
                    <textarea name="body" rows="6" class="{{ $inputClass }}" required placeholder="Tulis isi pengumuman...">{{ old('body') }}</textarea>
                    @error('body')<p class="text-rose-500 text-sm mt-2 font-medium">{{ $message }}</p>@enderror
                </div>

                <div class="mb-6">
                    <label class="font-bold text-gray-700 mb-2 block text-sm">Sasaran</label>
                    <select name="target" class="{{ $inputClass }}">
                        @foreach ($targets as $value => $label)
                            <option value="{{ $value }}" {{ old('target') == $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('target')<p class="text-rose-500 text-sm mt-2 font-medium">{{ $message }}</p>@enderror
                </div>

                <label class="inline-flex items-center gap-2 cursor-pointer">
                    <input type="hidden" name="is_published" value="0">
                    <input type="checkbox" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}
                        class="rounded border-gray-300 text-[#1D6594] focus:ring-[#1D6594]">
                    <span class="text-sm font-medium text-gray-600">Kirim sekarang (jika tidak dicentang, disimpan sebagai draf)</span>
                </label>

                <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-100 mt-8">
                    <a href="{{ route('admin.dashboard.announcement') }}"
                        class="px-6 py-3 text-gray-600 font-bold hover:bg-gray-100 rounded-xl transition-colors">Batal</a>
                    <button type="submit"
                        class="px-8 py-3 bg-[#1D6594] text-white font-bold rounded-xl shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
