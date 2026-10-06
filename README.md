<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

## Fitur Biaya Pendaftaran & Pembayaran Transfer Bank (AIIF)

Pendaftaran lomba berbayar dengan pembayaran via transfer bank dan unggah bukti bayar.
Satu **wali/koordinator (PIC)** menghasilkan **satu tagihan**; bukti bayar diunggah sekali
untuk semua anak di dalamnya.

### Konfigurasi (`.env`)

Semua parameter bisnis diatur lewat environment / `config/festival.php` (bukan hard-code):

| Variabel | Default | Keterangan |
|---|---|---|
| `APP_TIMEZONE` | `Asia/Makassar` | Zona waktu WITA untuk semua tanggal |
| `FESTIVAL_FEE_ENABLED` | `true` | Aktif/nonaktif fitur biaya |
| `FESTIVAL_FEE_AMOUNT` | `10000` | Nominal biaya per unit (Rp) |
| `FESTIVAL_FEE_MODE` | `per_anak` | `per_anak` atau `per_lomba` |
| `FESTIVAL_BANK_NAME` | - | Nama bank tujuan |
| `FESTIVAL_BANK_NUMBER` | - | Nomor rekening tujuan |
| `FESTIVAL_BANK_HOLDER` | - | Nama pemilik rekening |
| `FESTIVAL_PROOF_MAX_KB` | `3072` | Batas ukuran bukti bayar (KB, ~3 MB) |
| `FESTIVAL_MAX_LOMBA_PER_ANAK` | `2` | Maksimal lomba per anak |
| `FESTIVAL_COUPON_PER_CHILD` | `1` | Jumlah kupon makan per anak |
| `FESTIVAL_PAYMENT_NOTIFY` | `false` | Notifikasi email saat status berubah (opsional) |

Perhitungan: `total = jumlah unit × FESTIVAL_FEE_AMOUNT`, di mana unit = jumlah **anak unik**
(`per_anak`) atau jumlah **pendaftaran lomba** (`per_lomba`). Total **selalu dihitung ulang di
server**.

### Migrasi

```bash
php artisan migrate
php artisan config:clear
```

Migrasi bersifat aditif dan menyertakan *backfill* untuk data lama:
- Membuat tabel `children` dan menautkan `participants.child_id` dari data lama (per PIC + NIK).
- Membuat satu tagihan berstatus `belum_bayar` untuk setiap PIC yang sudah punya pendaftaran.

Aman dijalankan pada database yang sudah berisi data pendaftar.

### Alur status

`belum_bayar` → `menunggu_verifikasi` → `terverifikasi` / `ditolak` (dengan alasan).
Jika `ditolak`, wali dapat mengunggah ulang. Riwayat perubahan dicatat di
`payment_status_histories`. Jika jumlah anak berubah setelah verifikasi, selisih
(kurang/lebih bayar) ditampilkan tanpa menimpa nominal terverifikasi.

### Halaman & endpoint

- Wali/koordinator: `/user-dashboard/payment` (ringkasan, rekening, unggah bukti, status, cetak bukti).
- Admin/panitia: `/admin-dashboard/payment` (filter, pencarian, verifikasi, verifikasi massal, ekspor Excel).
- Bukti bayar disimpan **privat** di `storage/app/private/payment-proofs` dengan nama file UUID,
  hanya diakses lewat endpoint ber-otorisasi (bukan `storage:link`).

### Menjalankan tes

```bash
php artisan test
```

Tes menggunakan **SQLite in-memory** (`phpunit.xml`). Jangan arahkan tes ke database MySQL —
`RefreshDatabase` akan menghapus data. `tests/TestCase.php` memasang pengaman yang menolak
berjalan bila `DB_CONNECTION` bukan `sqlite`.

---

## Landing Page CMS (Konten, Layout, Sponsor, Kontak, Footer)

Konten landing page (`/`) dikelola dari admin melalui menu **Landing Page** di sidebar, dengan
pendekatan *block builder* (mirip WordPress): blok dapat ditambah, digeser urutannya, dan
disembunyikan tanpa mengubah kode.

### Konsep

- **Blok (`landing_blocks`)** — section halaman. Tiap blok punya `type`, `content` (JSON),
  `sort_order`, `is_active`. Tipe awal: `hero`, `info_acara`, `competitions`, `sponsors`,
  `contact`, `rich_text`. Form admin dirender dinamis dari registry
  `app/Support/LandingBlockTypes.php` (menambah tipe baru = tambah entri registry + satu partial
  `resources/views/landing/blocks/{type}.blade.php`).
- **Pengaturan (`landing_settings`)** — key-value global: nama situs, meta, warna tema
  (`primary_color`/`accent_color`), link navbar, isi footer, dan tanggal acara (target hitung mundur).
- **Kontak Person (`contact_persons`)** — daftar narahubung (CRUD sendiri).
- **Sponsor (`sponsors`)** — ditambah field `sort_order`, `is_active`, `website_url`.

### Menu admin

- **Konten & Layout** (`/admin-dashboard/landing/content`) — susun blok (drag untuk urut, toggle aktif).
- **Pengaturan** (`/admin-dashboard/landing/settings`) — tab Umum, Tema, Navbar, Footer, Acara.
- **Kontak Person** (`/admin-dashboard/landing/contact`).
- **Sponsor** tetap di menu Sponsor, kini dengan urutan & status aktif.

### Hero Coming Soon

Blok `hero` punya mode `coming_soon` (default) yang menampilkan **hitung mundur** ke
`countdown_target` dan menyembunyikan tombol pendaftaran, atau `normal` untuk banner penuh.

### Seeder & aset

```bash
php artisan migrate
php artisan storage:link          # gambar unggahan (landing & sponsor)
php artisan db:seed --class=LandingSeeder   # memindahkan konten lama ke DB (idempotent)
```

`LandingSeeder` sudah dipanggil dari `DatabaseSeeder` untuk instalasi baru. Halaman publik
di-cache (`landing.blocks`, `landing.settings`) dan cache otomatis dibersihkan saat admin menyimpan.

### Tes

```bash
php artisan test --filter=LandingTest
```

---

## Pengalaman Wali, Notifikasi & Pengumuman

### Pesan error Bahasa Indonesia

Semua pesan validasi memakai Bahasa Indonesia lewat `lang/id/validation.php`, `lang/id/auth.php`,
dan `lang/id/passwords.php`, dengan label ramah (mis. `participants.*.photo_url` → "Foto peserta").
Aktifkan dengan `APP_LOCALE=id` di `.env`.

### Batas ukuran upload

Semua unggahan berkas dibatasi **maksimal 20 MB** (favicon tetap 2 MB). Untuk bukti bayar diatur lewat
`FESTIVAL_PROOF_MAX_KB` (default `20480`).

> ⚠️ Wajib disetel di server/hosting: `upload_max_filesize` dan `post_max_size` minimal `24M`.
> Tanpa itu, berkas >2 MB akan gagal sebelum validasi berjalan.

### Keranjang & peserta belum bayar

Wali melihat daftar peserta yang **belum dibayar** di dashboard, plus widget **keranjang** melayang di
pojok kanan bawah (daftar anak + total tagihan + tombol ke halaman Pembayaran). Keranjang otomatis
hilang saat status pembayaran sudah menunggu verifikasi/lunas.

### Mobile bottom navbar

Bar navigasi bawah (`layouts/partials/app/bottom-nav.blade.php`) tampil di layar kecil untuk semua role:
- **Wali/khitan**: Dashboard, Pembayaran, Peserta, Akun.
- **Admin**: Dashboard, Registrasi, Pembayaran, Akun.

### Notifikasi & Pengumuman

- Notifikasi in-app (tabel `notifications`) untuk: pendaftaran lomba, unggah bukti bayar, verifikasi/penolakan
  pembayaran, dan check-in (scan QR). Lonceng notifikasi ada di header semua halaman (`/notifications`).
- Admin dapat membuat **Pengumuman** (`/admin-dashboard/announcement`). Saat dikirim, pengumuman masuk ke
  notifikasi in-app **dan email** pengguna sesuai sasaran.
- Email memakai `MAIL_*` di `.env` (default `log`). Isi konfigurasi SMTP agar email benar-benar terkirim.
- Realtime opsional via Pusher (`PUSHER_*`); jumlah notifikasi tetap diperbarui lewat polling ringan.

### Perintah

```bash
php artisan migrate
php artisan config:clear
npm run build
```



