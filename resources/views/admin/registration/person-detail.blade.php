@extends('layouts.app')

@section('content')
    <div class="py-8 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <x-breadcrumb :links="['Data Registrasi' => route('admin.dashboard.registration'), 'Detail Registrasi' => '#']" />

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">

            <div class="bg-gradient-to-r from-[#1D6594] to-[#154d73] p-6 sm:px-8 text-white relative overflow-hidden">
                <div class="absolute -right-10 -top-10 w-32 h-32 bg-white/10 rounded-full"></div>

                <div class="relative z-10 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <span
                            class="inline-block px-3 py-1 bg-white/20 text-xs font-bold rounded-full mb-2 uppercase tracking-widest border border-white/30">
                            No. Reg: {{ $data->registration_number }}
                        </span>
                        <h3 class="text-2xl font-extrabold leading-tight">
                            {{ $data->competition?->name ?? 'Lomba Tidak Ditemukan' }}</h3>
                        <p class="text-blue-100 text-sm mt-1">
                            PIC: <span class="font-bold text-white">{{ $data->pic?->name ?? '-' }}</span>
                            <span class="opacity-75">({{ $data->group?->name ?? 'Individu / Umum' }})</span>
                        </p>
                    </div>

                    @if (strtolower($data->status) == 'checkin')
                        <span
                            class="bg-emerald-500 text-white px-5 py-2.5 rounded-xl font-bold text-sm shadow-md flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Checked In
                        </span>
                    @else
                        <span
                            class="bg-amber-500 text-white px-5 py-2.5 rounded-xl font-bold text-sm shadow-md flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Menunggu / Pending
                        </span>
                    @endif
                </div>
            </div>

            <form action="{{ route('admin.dashboard.registration.update') }}" method="POST" enctype="multipart/form-data"
                class="p-6 sm:p-8 bg-gray-50/50">
                @csrf
                @method('PUT')
                <input type="hidden" name="competition_id" value="{{ $data->competition_id }}">
                <input type="hidden" name="id" value="{{ $data->id }}">

                @if (strcasecmp($data->competition?->name ?? '', 'Hadrah') === 0)
                    <div
                        class="bg-white p-5 rounded-2xl border border-blue-100 mb-6 shadow-sm flex flex-col sm:flex-row sm:items-center gap-4">
                        <div class="flex-1">
                            <label for="total_participants" class="font-bold text-gray-800 mb-1 block">Jumlah Anggota
                                Tim</label>
                            <p class="text-xs text-gray-500">Update total anggota yang akan ikut tampil di atas panggung.
                            </p>
                        </div>
                        <div class="w-full sm:w-48">
                            <input type="number" name="total_participants" id="total_participants"
                                class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-[#1D6594] focus:ring focus:ring-[#1D6594]/20 transition-colors bg-blue-50/30"
                                value="{{ old('total_participants', $data->total_participants) }}" required />
                            @error('total_participants')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                @else
                    <input type="hidden" name="total_participants"
                        value="{{ strcasecmp($data->competition?->name ?? '', 'Cerdas Cermat') === 0 ? 3 : 1 }}">
                @endif

                <div class="space-y-8">
                    @forelse ($data->participants ?? [] as $i => $participant)
                        <div class="bg-white rounded-2xl border border-gray-200 p-6 sm:p-8 shadow-sm relative mt-4">
                            <div
                                class="absolute -top-4 left-6 bg-[#E9AA14] text-white text-xs font-extrabold px-5 py-1.5 rounded-full shadow-md uppercase tracking-wider border-2 border-white">
                                Peserta {{ $i + 1 }}
                            </div>

                            <input type="hidden" name="participants[{{ $i }}][id]"
                                value="{{ old("participants.$i.id", $participant->id) }}" required>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-2">

                                <div class="space-y-5">
                                    <div>
                                        <label for="participants_{{ $i }}_name"
                                            class="font-bold text-gray-700 mb-1.5 block text-sm">Nama Lengkap</label>
                                        <input type="text" id="participants_{{ $i }}_name"
                                            name="participants[{{ $i }}][name]"
                                            class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-[#1D6594] focus:ring focus:ring-[#1D6594]/20 transition-colors bg-gray-50 focus:bg-white"
                                            value="{{ old("participants.$i.name", $participant->name) }}" required />
                                        @error("participants.{$i}.name")
                                            <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label for="participants_{{ $i }}_age"
                                                class="font-bold text-gray-700 mb-1.5 block text-sm">Umur (Thn)</label>
                                            <input type="number" id="participants_{{ $i }}_age"
                                                name="participants[{{ $i }}][age]"
                                                class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-[#1D6594] focus:ring focus:ring-[#1D6594]/20 transition-colors bg-gray-50 focus:bg-white"
                                                value="{{ old("participants.$i.age", $participant->age) }}" required />
                                            @error("participants.{$i}.age")
                                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="participants_{{ $i }}_nik"
                                                class="font-bold text-gray-700 mb-1.5 block text-sm">NIK</label>
                                            <input type="text" id="participants_{{ $i }}_nik"
                                                name="participants[{{ $i }}][nik]"
                                                class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-[#1D6594] focus:ring focus:ring-[#1D6594]/20 transition-colors bg-gray-50 focus:bg-white text-sm"
                                                value="{{ old("participants.$i.nik", $participant->nik) }}" required />
                                            @error("participants.{$i}.nik")
                                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4 p-4 bg-gray-50 rounded-xl border border-gray-100">
                                        <div>
                                            <label class="font-bold text-gray-500 mb-1 block text-xs">Tempat Lahir</label>
                                            <input type="text" name="participants[{{ $i }}][birth_place]"
                                                class="block w-full px-3 py-2 rounded-lg border-transparent bg-gray-100 text-gray-500 text-sm cursor-not-allowed shadow-inner"
                                                value="{{ old("participants.$i.birth_place", $participant->birth_place) }}"
                                                required readonly title="Data dari pendaftar (readonly)" />
                                        </div>
                                        <div>
                                            <label class="font-bold text-gray-500 mb-1 block text-xs">Tgl Lahir</label>
                                            <input type="date" name="participants[{{ $i }}][birth_date]"
                                                class="block w-full px-3 py-2 rounded-lg border-transparent bg-gray-100 text-gray-500 text-sm cursor-not-allowed shadow-inner"
                                                value="{{ old("participants.$i.birth_date", $participant->birth_date) }}"
                                                required readonly title="Data dari pendaftar (readonly)" />
                                        </div>
                                    </div>
                                </div>

                                <div class="space-y-5">
                                    <div
                                        class="p-4 rounded-xl border border-gray-200 bg-white shadow-sm flex flex-col sm:flex-row items-start sm:items-center gap-4 hover:border-blue-200 transition-colors">
                                        @if ($participant->photo_url)
                                            <div class="shrink-0 group relative overflow-hidden rounded-lg border border-gray-200 w-24 h-24 bg-gray-50 cursor-pointer"
                                                onclick="openPhotoModal('{{ asset('storage/' . $participant->photo_url) }}', 'Foto Peserta - {{ $participant->name }}')">
                                                <img src="{{ asset('storage/' . $participant->photo_url) }}"
                                                    alt="Foto" class="w-full h-full object-cover">
                                                <div
                                                    class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 flex justify-center items-center transition-opacity text-white text-[10px] font-bold">
                                                    Perbesar</div>
                                            </div>
                                        @else
                                            <div
                                                class="shrink-0 w-24 h-24 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400 border border-dashed border-gray-300 text-xs">
                                                Kosong
                                            </div>
                                        @endif

                                        <div class="flex-1 w-full">
                                            <label for="participants_{{ $i }}_photo"
                                                class="font-bold text-gray-800 mb-1 block text-sm">Foto Anak</label>
                                            <p class="text-xs text-gray-500 mb-2">Pastikan wajah peserta terlihat jelas.
                                            </p>

                                            <input type="file" id="participants_{{ $i }}_photo"
                                                name="participants[{{ $i }}][photo_url]"
                                                class="block w-full text-xs text-gray-600 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none file:mr-3 file:py-2 file:px-3 file:rounded-l-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                                accept="image/*">
                                            @error("participants.{$i}.photo_url")
                                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div
                                        class="p-4 rounded-xl border border-gray-200 bg-white shadow-sm flex flex-col sm:flex-row items-start sm:items-center gap-4 hover:border-blue-200 transition-colors">
                                        @if ($participant->certificate_url)
                                            <div class="shrink-0 group relative overflow-hidden rounded-lg border border-gray-200 w-24 h-24 bg-gray-50 cursor-pointer"
                                                onclick="openPhotoModal('{{ asset('storage/' . $participant->certificate_url) }}', 'Akta/KTP - {{ $participant->name }}')">
                                                <img src="{{ asset('storage/' . $participant->certificate_url) }}"
                                                    alt="Akta" class="w-full h-full object-cover">
                                                <div
                                                    class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 flex justify-center items-center transition-opacity text-white text-[10px] font-bold">
                                                    Perbesar</div>
                                            </div>
                                        @else
                                            <div
                                                class="shrink-0 w-24 h-24 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400 border border-dashed border-gray-300 text-xs">
                                                Kosong
                                            </div>
                                        @endif

                                        <div class="flex-1 w-full">
                                            <label for="participants_{{ $i }}_cert"
                                                class="font-bold text-gray-800 mb-1 block text-sm">Akta Kelahiran /
                                                KTP</label>
                                            <p class="text-xs text-gray-500 mb-2">Dokumen identitas resmi peserta.</p>

                                            <input type="file" id="participants_{{ $i }}_cert"
                                                name="participants[{{ $i }}][certificate_url]"
                                                class="block w-full text-xs text-gray-600 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none file:mr-3 file:py-2 file:px-3 file:rounded-l-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                                accept="image/*,application/pdf">
                                            @error("participants.{$i}.certificate_url")
                                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center bg-white rounded-2xl border border-gray-200 shadow-sm">
                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            <p class="text-gray-600 font-medium">Belum ada data peserta yang ditambahkan pada registrasi
                                ini.</p>
                        </div>
                    @endforelse
                </div>

                <div
                    class="bg-blue-50/50 p-5 rounded-2xl border border-blue-100 flex flex-col sm:flex-row items-center justify-between gap-6 mt-6 shadow-sm">
                    <div class="w-full sm:w-1/2">
                        <label for="status" class="font-bold text-gray-800 mb-1.5 block">Status Kehadiran /
                            Pendaftaran</label>
                        <select name="status" id="status"
                            class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-[#1D6594] focus:ring focus:ring-[#1D6594]/20 transition-colors bg-white font-bold text-gray-700"
                            required>
                            <option value="registered"
                                {{ old('status', $data->status) == 'registered' ? 'selected' : '' }}>Registered (Terdaftar)
                            </option>
                            <option value="checkin" {{ old('status', $data->status) == 'checkin' ? 'selected' : '' }}>
                                Check-In (Hadir)</option>
                        </select>
                        @error('status')
                            <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="w-full sm:w-auto flex justify-end gap-3 mt-4 sm:mt-0">
                        <a href="javascript:history.back()"
                            class="px-6 py-3.5 text-gray-600 font-bold hover:bg-white rounded-xl border border-transparent hover:border-gray-200 transition-colors">
                            Kembali
                        </a>
                        <button type="submit"
                            class="px-8 py-3.5 bg-[#1D6594] text-white font-bold rounded-xl shadow-md hover:shadow-lg hover:bg-[#154d73] hover:-translate-y-0.5 transition-all flex items-center gap-2">
                            Perbarui Data
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <div id="imagePreviewModal"
        class="fixed inset-0 z-[100] hidden bg-gray-900/80 backdrop-blur-sm flex items-center justify-center transition-opacity duration-300 opacity-0"
        aria-modal="true" role="dialog">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden w-full max-w-3xl transform scale-95 transition-transform duration-300 mx-4"
            id="imagePreviewContent">
            <div class="flex justify-between items-center p-5 border-b border-gray-100 bg-gray-50">
                <h2 id="previewTitle" class="text-lg font-bold text-gray-800">Preview Dokumen</h2>
                <button type="button" onclick="closePhotoModal()"
                    class="text-gray-400 hover:text-rose-500 hover:bg-rose-50 p-2 rounded-lg transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="p-4 bg-gray-800 flex justify-center items-center min-h-[50vh] max-h-[75vh] overflow-y-auto">
                <img id="previewImage" src="" alt="Berkas Preview"
                    class="max-w-full h-auto object-contain rounded shadow-sm">
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Logika Animasi Modal
            function openPhotoModal(imageUrl, title) {
                const modal = document.getElementById('imagePreviewModal');
                const content = document.getElementById('imagePreviewContent');

                document.getElementById('previewImage').src = imageUrl;
                document.getElementById('previewTitle').textContent = title;

                modal.classList.remove('hidden');
                setTimeout(() => {
                    modal.classList.remove('opacity-0');
                    content.classList.remove('scale-95');
                }, 10);
            }

            function closePhotoModal() {
                const modal = document.getElementById('imagePreviewModal');
                const content = document.getElementById('imagePreviewContent');

                modal.classList.add('opacity-0');
                content.classList.add('scale-95');

                setTimeout(() => {
                    modal.classList.add('hidden');
                    document.getElementById('previewImage').src = '';
                }, 300);
            }
        </script>
    @endpush
@endsection
