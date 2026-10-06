<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Pesan Validasi
    |--------------------------------------------------------------------------
    */

    'accepted' => ':attribute harus disetujui.',
    'accepted_if' => ':attribute harus disetujui ketika :other berisi :value.',
    'active_url' => ':attribute bukan URL yang valid.',
    'after' => ':attribute harus berisi tanggal setelah :date.',
    'after_or_equal' => ':attribute harus berisi tanggal setelah atau sama dengan :date.',
    'alpha' => ':attribute hanya boleh berisi huruf.',
    'alpha_dash' => ':attribute hanya boleh berisi huruf, angka, strip, dan garis bawah.',
    'alpha_num' => ':attribute hanya boleh berisi huruf dan angka.',
    'array' => ':attribute harus berupa daftar (array).',
    'ascii' => ':attribute hanya boleh berisi karakter alfanumerik dan simbol satu byte.',
    'before' => ':attribute harus berisi tanggal sebelum :date.',
    'before_or_equal' => ':attribute harus berisi tanggal sebelum atau sama dengan :date.',
    'between' => [
        'array' => ':attribute harus memiliki antara :min sampai :max item.',
        'file' => ':attribute harus berukuran antara :min sampai :max kilobyte.',
        'numeric' => ':attribute harus bernilai antara :min sampai :max.',
        'string' => ':attribute harus berisi antara :min sampai :max karakter.',
    ],
    'boolean' => ':attribute harus bernilai benar atau salah.',
    'can' => ':attribute berisi nilai yang tidak diizinkan.',
    'confirmed' => 'Konfirmasi :attribute tidak cocok.',
    'contains' => ':attribute harus memuat nilai yang wajib diisi.',
    'current_password' => 'Kata sandi salah.',
    'date' => ':attribute bukan tanggal yang valid.',
    'date_equals' => ':attribute harus berisi tanggal yang sama dengan :date.',
    'date_format' => ':attribute tidak sesuai format :format.',
    'decimal' => ':attribute harus memiliki :decimal angka desimal.',
    'declined' => ':attribute harus ditolak.',
    'declined_if' => ':attribute harus ditolak ketika :other berisi :value.',
    'different' => ':attribute dan :other harus berbeda.',
    'digits' => ':attribute harus terdiri dari :digits angka.',
    'digits_between' => ':attribute harus terdiri antara :min sampai :max angka.',
    'dimensions' => ':attribute memiliki dimensi gambar yang tidak sesuai.',
    'distinct' => ':attribute memiliki nilai yang duplikat.',
    'doesnt_end_with' => ':attribute tidak boleh diakhiri dengan salah satu dari: :values.',
    'doesnt_start_with' => ':attribute tidak boleh diawali dengan salah satu dari: :values.',
    'email' => ':attribute harus berupa alamat email yang valid.',
    'ends_with' => ':attribute harus diakhiri dengan salah satu dari: :values.',
    'enum' => ':attribute yang dipilih tidak valid.',
    'exists' => ':attribute yang dipilih tidak valid.',
    'extensions' => ':attribute harus memiliki ekstensi: :values.',
    'file' => ':attribute harus berupa berkas.',
    'filled' => ':attribute wajib diisi.',
    'gt' => [
        'array' => ':attribute harus memiliki lebih dari :value item.',
        'file' => ':attribute harus berukuran lebih dari :value kilobyte.',
        'numeric' => ':attribute harus lebih besar dari :value.',
        'string' => ':attribute harus lebih dari :value karakter.',
    ],
    'gte' => [
        'array' => ':attribute harus memiliki :value item atau lebih.',
        'file' => ':attribute harus berukuran minimal :value kilobyte.',
        'numeric' => ':attribute harus lebih besar dari atau sama dengan :value.',
        'string' => ':attribute harus minimal :value karakter.',
    ],
    'image' => ':attribute harus berupa gambar.',
    'in' => ':attribute yang dipilih tidak valid.',
    'in_array' => ':attribute tidak ada di dalam :other.',
    'integer' => ':attribute harus berupa bilangan bulat.',
    'ip' => ':attribute harus berupa alamat IP yang valid.',
    'ipv4' => ':attribute harus berupa alamat IPv4 yang valid.',
    'ipv6' => ':attribute harus berupa alamat IPv6 yang valid.',
    'json' => ':attribute harus berupa teks JSON yang valid.',
    'lowercase' => ':attribute harus berupa huruf kecil.',
    'lt' => [
        'array' => ':attribute harus memiliki kurang dari :value item.',
        'file' => ':attribute harus berukuran kurang dari :value kilobyte.',
        'numeric' => ':attribute harus kurang dari :value.',
        'string' => ':attribute harus kurang dari :value karakter.',
    ],
    'lte' => [
        'array' => ':attribute tidak boleh lebih dari :value item.',
        'file' => ':attribute harus berukuran maksimal :value kilobyte.',
        'numeric' => ':attribute harus kurang dari atau sama dengan :value.',
        'string' => ':attribute harus maksimal :value karakter.',
    ],
    'mac_address' => ':attribute harus berupa alamat MAC yang valid.',
    'max' => [
        'array' => ':attribute tidak boleh lebih dari :max item.',
        'file' => 'Ukuran :attribute tidak boleh lebih dari :max kilobyte.',
        'numeric' => ':attribute tidak boleh lebih besar dari :max.',
        'string' => ':attribute tidak boleh lebih dari :max karakter.',
    ],
    'max_digits' => ':attribute tidak boleh lebih dari :max angka.',
    'mimes' => ':attribute harus berupa berkas dengan tipe: :values.',
    'mimetypes' => ':attribute harus berupa berkas dengan tipe: :values.',
    'min' => [
        'array' => ':attribute harus memiliki minimal :min item.',
        'file' => ':attribute harus berukuran minimal :min kilobyte.',
        'numeric' => ':attribute harus minimal :min.',
        'string' => ':attribute harus minimal :min karakter.',
    ],
    'min_digits' => ':attribute harus memiliki minimal :min angka.',
    'missing' => ':attribute harus kosong.',
    'missing_if' => ':attribute harus kosong ketika :other berisi :value.',
    'missing_unless' => ':attribute harus kosong kecuali :other berisi :value.',
    'missing_with' => ':attribute harus kosong ketika :values ada.',
    'missing_with_all' => ':attribute harus kosong ketika :values ada.',
    'multiple_of' => ':attribute harus merupakan kelipatan dari :value.',
    'not_in' => ':attribute yang dipilih tidak valid.',
    'not_regex' => 'Format :attribute tidak valid.',
    'numeric' => ':attribute harus berupa angka.',
    'password' => [
        'letters' => ':attribute harus mengandung minimal satu huruf.',
        'mixed' => ':attribute harus mengandung minimal satu huruf besar dan satu huruf kecil.',
        'numbers' => ':attribute harus mengandung minimal satu angka.',
        'symbols' => ':attribute harus mengandung minimal satu simbol.',
        'uncompromised' => ':attribute yang diberikan pernah bocor dalam kebocoran data. Silakan pilih :attribute lain.',
    ],
    'present' => ':attribute wajib ada.',
    'present_if' => ':attribute wajib ada ketika :other berisi :value.',
    'present_unless' => ':attribute wajib ada kecuali :other berisi :value.',
    'present_with' => ':attribute wajib ada ketika :values ada.',
    'present_with_all' => ':attribute wajib ada ketika :values ada.',
    'prohibited' => ':attribute tidak boleh diisi.',
    'prohibited_if' => ':attribute tidak boleh diisi ketika :other berisi :value.',
    'prohibited_unless' => ':attribute tidak boleh diisi kecuali :other berisi :values.',
    'prohibits' => ':attribute melarang :other untuk diisi.',
    'regex' => 'Format :attribute tidak valid.',
    'required' => ':attribute wajib diisi.',
    'required_array_keys' => ':attribute harus berisi entri untuk: :values.',
    'required_if' => ':attribute wajib diisi ketika :other berisi :value.',
    'required_if_accepted' => ':attribute wajib diisi ketika :other disetujui.',
    'required_unless' => ':attribute wajib diisi kecuali :other berisi :values.',
    'required_with' => ':attribute wajib diisi ketika :values ada.',
    'required_with_all' => ':attribute wajib diisi ketika :values ada.',
    'required_without' => ':attribute wajib diisi ketika :values tidak ada.',
    'required_without_all' => ':attribute wajib diisi ketika tidak ada satu pun dari :values.',
    'same' => ':attribute dan :other harus sama.',
    'size' => [
        'array' => ':attribute harus berisi :size item.',
        'file' => ':attribute harus berukuran :size kilobyte.',
        'numeric' => ':attribute harus bernilai :size.',
        'string' => ':attribute harus berisi :size karakter.',
    ],
    'starts_with' => ':attribute harus diawali dengan salah satu dari: :values.',
    'string' => ':attribute harus berupa teks.',
    'timezone' => ':attribute harus berupa zona waktu yang valid.',
    'unique' => ':attribute sudah terdaftar.',
    'uploaded' => ':attribute gagal diunggah. Pastikan ukuran berkas tidak melebihi batas server.',
    'uppercase' => ':attribute harus berupa huruf besar.',
    'url' => ':attribute harus berupa URL yang valid.',
    'ulid' => ':attribute harus berupa ULID yang valid.',
    'uuid' => ':attribute harus berupa UUID yang valid.',

    /*
    |--------------------------------------------------------------------------
    | Pesan Validasi Kustom
    |--------------------------------------------------------------------------
    */

    'custom' => [
        'password' => [
            'confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Nama Atribut
    |--------------------------------------------------------------------------
    |
    | Label ramah untuk setiap field, sehingga pengguna melihat "Foto peserta"
    | alih-alih "participants.0.photo_url".
    |
    */

    'attributes' => [
        // Akun & autentikasi
        'name' => 'nama',
        'email' => 'email',
        'password' => 'kata sandi',
        'password_confirmation' => 'konfirmasi kata sandi',
        'current_password' => 'kata sandi saat ini',
        'phone_number' => 'nomor telepon',
        'group' => 'kelompok',
        'group_id' => 'kelompok',
        'role' => 'peran',
        'token' => 'token',
        'remember' => 'ingat saya',
        'terms' => 'syarat & ketentuan',

        // Pendaftaran lomba
        'competition_id' => 'lomba',
        'total_participants' => 'jumlah peserta',
        'participants' => 'peserta',
        'participants.*.name' => 'nama peserta',
        'participants.*.age' => 'umur peserta',
        'participants.*.nik' => 'NIK peserta',
        'participants.*.birth_place' => 'tempat lahir peserta',
        'participants.*.birth_date' => 'tanggal lahir peserta',
        'participants.*.photo_url' => 'foto peserta',
        'participants.*.certificate_url' => 'akta kelahiran / KTP / KTA',

        // Pendaftaran khitan
        'nik' => 'NIK',
        'age' => 'umur',
        'birth_place' => 'tempat lahir',
        'birth_date' => 'tanggal lahir',
        'domicile' => 'domisili',
        'is_sanur' => 'status domisili Sanur',
        'photo_url' => 'foto',
        'certificate_url' => 'akta kelahiran / KTP / KTA',
        'family_card_url' => 'kartu keluarga',

        // Pembayaran
        'sender_name' => 'nama pengirim',
        'transfer_date' => 'tanggal transfer',
        'claimed_amount' => 'nominal yang ditransfer',
        'proof' => 'bukti pembayaran',
        'reason' => 'alasan',
        'payment_ids' => 'data pembayaran',
        'status' => 'status',

        // Lomba (admin)
        'description' => 'deskripsi',
        'image_url' => 'gambar',
        'type' => 'jenis',
        'category_id' => 'kategori',
        'min_age' => 'umur minimum',
        'max_age' => 'umur maksimum',
        'time_slot' => 'jadwal',
        'registration_start' => 'tanggal mulai pendaftaran',
        'registration_end' => 'tanggal selesai pendaftaran',

        // Sponsor & kontak
        'img_url' => 'logo',
        'nominal' => 'nominal',
        'website_url' => 'tautan website',
        'sort_order' => 'urutan',
        'is_active' => 'status aktif',
        'label' => 'label',
        'whatsapp' => 'nomor WhatsApp',

        // Landing page
        'site_name' => 'nama situs',
        'meta_title' => 'judul tab browser',
        'meta_description' => 'deskripsi situs',
        'primary_color' => 'warna utama',
        'accent_color' => 'warna aksen',
        'event_date' => 'tanggal acara',
        'footer_about' => 'tentang',
        'footer_address' => 'alamat',
        'footer_email' => 'email footer',
        'footer_phone' => 'telepon footer',
        'footer_copyright' => 'teks copyright',
        'file.logo' => 'logo',
        'file.favicon' => 'favicon',
        'file.background' => 'gambar latar',
        'file.poster' => 'poster',

        // Pengumuman
        'title' => 'judul',
        'body' => 'isi pengumuman',
        'target' => 'sasaran',
        'published_at' => 'waktu terbit',
    ],

];
