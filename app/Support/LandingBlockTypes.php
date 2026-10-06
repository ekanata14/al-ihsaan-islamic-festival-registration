<?php

namespace App\Support;

/**
 * Registry tipe blok landing page.
 *
 * Satu sumber kebenaran untuk:
 * - label & ikon blok di admin
 * - skema field yang dirender pada form admin (dinamis)
 * - konten default saat blok baru dibuat
 * - aturan validasi saat menyimpan
 *
 * Menambah tipe blok baru = tambah entri di sini + satu partial
 * resources/views/landing/blocks/{type}.blade.php
 */
class LandingBlockTypes
{
    /**
     * Tipe field yang menampung berkas unggahan.
     */
    public const IMAGE_TYPES = ['image'];

    public static function all(): array
    {
        return [
            'hero' => [
                'label' => 'Hero / Banner',
                'icon' => 'sparkles',
                'description' => 'Bagian paling atas halaman (mendukung mode Coming Soon + hitung mundur).',
                'fields' => [
                    [
                        'name' => 'mode',
                        'label' => 'Mode Tampilan',
                        'type' => 'select',
                        'default' => 'coming_soon',
                        'options' => [
                            'coming_soon' => 'Coming Soon (hitung mundur)',
                            'normal' => 'Normal (banner penuh)',
                        ],
                        'help' => 'Coming Soon menyembunyikan tombol pendaftaran dan menampilkan hitung mundur.',
                    ],
                    ['name' => 'badge', 'label' => 'Badge / Label Atas', 'type' => 'text', 'default' => '✨ Selamat Datang di Al Ihsaan Islamic Festival'],
                    ['name' => 'title', 'label' => 'Judul Utama', 'type' => 'text', 'default' => 'Merajut Ukhuwah, Menggapai Berkah'],
                    ['name' => 'subtitle', 'label' => 'Deskripsi', 'type' => 'textarea', 'default' => 'Al Ihsaan Islamic Festival hadir dengan lomba-lomba Islami seru, sunatan massal, dan donor darah penuh berkah! Gabung sekarang dan jadilah bagian dari generasi muda yang berprestasi, berakhlak, dan peduli sesama! 🌟'],
                    [
                        'name' => 'coming_soon_message',
                        'label' => 'Pesan Coming Soon',
                        'type' => 'text',
                        'default' => 'Segera Hadir',
                        'help' => 'Ditampilkan sebagai penanda saat mode Coming Soon aktif.',
                    ],
                    [
                        'name' => 'countdown_target',
                        'label' => 'Target Hitung Mundur',
                        'type' => 'datetime',
                        'default' => '2025-06-15T07:00',
                        'help' => 'Tanggal & jam acara (waktu lokal) untuk hitung mundur.',
                    ],
                    ['name' => 'background', 'label' => 'Gambar Latar', 'type' => 'image', 'default' => 'https://images.unsplash.com/photo-1519818178122-1d579241517a?q=80&w=2070&auto=format&fit=crop', 'help' => 'Boleh unggah gambar atau tempel URL.'],
                    ['name' => 'logo', 'label' => 'Gambar Logo', 'type' => 'image', 'default' => '', 'help' => 'Kosongkan untuk memakai logo default.'],
                    [
                        'name' => 'buttons',
                        'label' => 'Tombol Aksi',
                        'type' => 'repeater',
                        'default' => [
                            ['label' => 'Daftar Lomba!', 'url' => '/register', 'style' => 'primary'],
                            ['label' => 'Daftar Khitan!', 'url' => '/register/khitan', 'style' => 'accent'],
                        ],
                        'subfields' => [
                            ['name' => 'label', 'label' => 'Teks Tombol', 'type' => 'text'],
                            ['name' => 'url', 'label' => 'Tautan', 'type' => 'text'],
                            [
                                'name' => 'style',
                                'label' => 'Warna',
                                'type' => 'select',
                                'options' => ['primary' => 'Biru', 'accent' => 'Kuning', 'outline' => 'Garis'],
                            ],
                        ],
                    ],
                    [
                        'name' => 'resources',
                        'label' => 'Tautan Bantuan (Guidebook, dll)',
                        'type' => 'repeater',
                        'default' => [
                            ['label' => 'Guidebook', 'url' => ''],
                            ['label' => 'Tutorial Daftar', 'url' => ''],
                        ],
                        'subfields' => [
                            ['name' => 'label', 'label' => 'Teks', 'type' => 'text'],
                            ['name' => 'url', 'label' => 'Tautan', 'type' => 'text'],
                        ],
                    ],
                ],
            ],

            'info_acara' => [
                'label' => 'Informasi Acara',
                'icon' => 'calendar',
                'description' => 'Poster + kartu informasi waktu, lokasi, dan periode pendaftaran.',
                'fields' => [
                    ['name' => 'eyebrow', 'label' => 'Label Kecil', 'type' => 'text', 'default' => 'Informasi Utama'],
                    ['name' => 'title', 'label' => 'Judul', 'type' => 'text', 'default' => 'Rangkaian Acara Penuh Berkah'],
                    ['name' => 'subtitle', 'label' => 'Deskripsi', 'type' => 'textarea', 'default' => 'Kami mengundang seluruh elemen masyarakat untuk hadir dan berpartisipasi dalam rangkaian kegiatan Al Ihsaan Islamic Festival. Jadikan momen ini sebagai ladang amal dan silaturahmi.'],
                    ['name' => 'poster', 'label' => 'Gambar Poster', 'type' => 'image', 'default' => ''],
                    [
                        'name' => 'cards',
                        'label' => 'Kartu Informasi',
                        'type' => 'repeater',
                        'default' => [
                            ['icon' => 'calendar', 'title' => 'Waktu Pelaksanaan', 'lines' => "Minggu, 15 Juni 2025\n07.00 - 12.00 WITA"],
                            ['icon' => 'map', 'title' => 'Lokasi Acara', 'lines' => "Masjid Al Ihsaan Sanur\nJl. Hang Tuah, Sanur, Denpasar"],
                            ['icon' => 'clipboard', 'title' => 'Periode Pendaftaran', 'lines' => '05 Mei – 07 Juni 2025'],
                        ],
                        'subfields' => [
                            [
                                'name' => 'icon',
                                'label' => 'Ikon',
                                'type' => 'select',
                                'options' => [
                                    'calendar' => 'Kalender',
                                    'map' => 'Lokasi',
                                    'clipboard' => 'Catatan',
                                    'clock' => 'Jam',
                                    'ticket' => 'Tiket',
                                    'star' => 'Bintang',
                                ],
                            ],
                            ['name' => 'title', 'label' => 'Judul Kartu', 'type' => 'text'],
                            ['name' => 'lines', 'label' => 'Isi (satu baris per baris)', 'type' => 'textarea'],
                        ],
                    ],
                    ['name' => 'note', 'label' => 'Catatan Kaki', 'type' => 'text', 'default' => '*Kuota terbatas, segera daftarkan diri Anda!'],
                ],
            ],

            'competitions' => [
                'label' => 'Daftar Lomba',
                'icon' => 'trophy',
                'description' => 'Menampilkan perlombaan berstatus "open" dari database.',
                'fields' => [
                    ['name' => 'title', 'label' => 'Judul', 'type' => 'text', 'default' => 'Kategori Perlombaan'],
                    ['name' => 'subtitle', 'label' => 'Deskripsi', 'type' => 'textarea', 'default' => ''],
                    ['name' => 'limit', 'label' => 'Jumlah Maksimal', 'type' => 'number', 'default' => 8],
                    ['name' => 'empty_text', 'label' => 'Teks Saat Kosong', 'type' => 'text', 'default' => 'Belum ada perlombaan yang tersedia saat ini.'],
                    ['name' => 'show_button', 'label' => 'Tampilkan Tombol Daftar', 'type' => 'checkbox', 'default' => 1],
                ],
            ],

            'sponsors' => [
                'label' => 'Sponsor',
                'icon' => 'handshake',
                'description' => 'Menampilkan logo sponsor aktif + ajakan menjadi sponsor.',
                'fields' => [
                    ['name' => 'title', 'label' => 'Judul', 'type' => 'text', 'default' => 'Sponsorship'],
                    ['name' => 'subtitle', 'label' => 'Deskripsi', 'type' => 'textarea', 'default' => 'Terima kasih kepada para sponsor yang telah mendukung terselenggaranya Al Ihsaan Islamic Festival.'],
                    ['name' => 'cta_title', 'label' => 'Judul Ajakan', 'type' => 'text', 'default' => 'Tertarik Menjadi Sponsor?'],
                    ['name' => 'cta_text', 'label' => 'Deskripsi Ajakan', 'type' => 'textarea', 'default' => 'Dukung syiar Islam dan dapatkan eksposur eksklusif untuk brand Anda di acara kami.'],
                    ['name' => 'cta_label', 'label' => 'Teks Tombol', 'type' => 'text', 'default' => 'Hubungi Rayyan'],
                    ['name' => 'cta_url', 'label' => 'Tautan Tombol', 'type' => 'text', 'default' => 'https://wa.me/+6282340786912'],
                ],
            ],

            'contact' => [
                'label' => 'Kontak Person',
                'icon' => 'phone',
                'description' => 'Menampilkan narahubung aktif + tombol grup WhatsApp.',
                'fields' => [
                    ['name' => 'title', 'label' => 'Judul', 'type' => 'text', 'default' => 'Hubungi Kami'],
                    ['name' => 'subtitle', 'label' => 'Deskripsi', 'type' => 'textarea', 'default' => 'Punya pertanyaan seputar acara, lomba, atau teknis pendaftaran? Silakan hubungi narahubung kami di bawah ini atau bergabung ke dalam grup WhatsApp resmi.'],
                    [
                        'name' => 'groups',
                        'label' => 'Grup WhatsApp',
                        'type' => 'repeater',
                        'default' => [],
                        'subfields' => [
                            ['name' => 'label', 'label' => 'Teks Tombol', 'type' => 'text'],
                            ['name' => 'url', 'label' => 'Tautan Grup', 'type' => 'text'],
                            [
                                'name' => 'style',
                                'label' => 'Warna',
                                'type' => 'select',
                                'options' => ['primary' => 'Biru', 'accent' => 'Kuning'],
                            ],
                        ],
                    ],
                ],
            ],

            'rich_text' => [
                'label' => 'Teks / HTML Bebas',
                'icon' => 'document',
                'description' => 'Blok konten bebas berupa teks atau HTML.',
                'fields' => [
                    ['name' => 'title', 'label' => 'Judul (opsional)', 'type' => 'text', 'default' => ''],
                    ['name' => 'body', 'label' => 'Isi Konten (mendukung HTML)', 'type' => 'html', 'default' => '<p>Tulis konten di sini...</p>'],
                    [
                        'name' => 'background',
                        'label' => 'Latar',
                        'type' => 'select',
                        'default' => 'white',
                        'options' => ['white' => 'Putih', 'gray' => 'Abu-abu', 'primary' => 'Biru'],
                    ],
                ],
            ],
        ];
    }

    public static function exists(string $type): bool
    {
        return array_key_exists($type, static::all());
    }

    public static function get(string $type): ?array
    {
        return static::all()[$type] ?? null;
    }

    public static function label(string $type): string
    {
        return static::get($type)['label'] ?? ucwords(str_replace('_', ' ', $type));
    }

    public static function icon(string $type): string
    {
        return static::get($type)['icon'] ?? 'document';
    }

    public static function description(string $type): string
    {
        return static::get($type)['description'] ?? '';
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public static function fields(string $type): array
    {
        return static::get($type)['fields'] ?? [];
    }

    public static function defaultContent(string $type): array
    {
        $content = [];

        foreach (static::fields($type) as $field) {
            $content[$field['name']] = $field['default'] ?? ($field['type'] === 'repeater' ? [] : '');
        }

        return $content;
    }

    public static function isImageField(array $field): bool
    {
        return in_array($field['type'], self::IMAGE_TYPES, true);
    }

    public static function isFileField(array $field): bool
    {
        return static::isImageField($field);
    }

    /**
     * Aturan validasi untuk field bertipe berkas (upload).
     */
    public static function fileRules(string $type): array
    {
        $rules = [];

        foreach (static::fields($type) as $field) {
            if (static::isFileField($field)) {
                $rules['file.' . $field['name']] = 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:20480';
            }
        }

        return $rules;
    }

    /**
     * Aturan validasi untuk isi konten (JSON) berdasarkan skema field.
     */
    public static function contentRules(string $type): array
    {
        $rules = [];

        foreach (static::fields($type) as $field) {
            $key = 'content.' . $field['name'];

            switch ($field['type']) {
                case 'checkbox':
                    $rules[$key] = 'nullable|boolean';
                    break;
                case 'number':
                    $rules[$key] = 'nullable|integer';
                    break;
                case 'datetime':
                    $rules[$key] = 'nullable|string|max:32';
                    break;
                case 'repeater':
                    $rules[$key] = 'nullable|array';
                    foreach ($field['subfields'] ?? [] as $sub) {
                        $rules[$key . '.*.' . $sub['name']] = 'nullable|string|max:2000';
                    }
                    break;
                case 'image':
                    // Nilai disimpan sebagai path/URL, divalidasi lewat fileRules bila diunggah.
                    $rules[$key] = 'nullable|string|max:2048';
                    break;
                default:
                    $rules[$key] = 'nullable|string|max:5000';
            }
        }

        return $rules;
    }
}
