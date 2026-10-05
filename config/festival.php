<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Biaya Pendaftaran
    |--------------------------------------------------------------------------
    |
    | Nominal biaya dan mode perhitungan disimpan di konfigurasi agar mudah
    | diubah panitia tanpa mengubah kode. Mode yang didukung:
    | - per_anak : total = jumlah anak unik milik PIC x amount (default)
    | - per_lomba: total = jumlah pendaftaran lomba (baris registrations) x amount
    |
    */

    'fee' => [
        'enabled' => env('FESTIVAL_FEE_ENABLED', true),
        'amount' => (int) env('FESTIVAL_FEE_AMOUNT', 10000),
        'mode' => env('FESTIVAL_FEE_MODE', 'per_anak'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Rekening Tujuan Transfer
    |--------------------------------------------------------------------------
    */

    'bank' => [
        'name' => env('FESTIVAL_BANK_NAME', 'Bank (belum diatur)'),
        'account_number' => env('FESTIVAL_BANK_NUMBER', '0000000000'),
        'account_holder' => env('FESTIVAL_BANK_HOLDER', 'Panitia AIIF 2026'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Unggah Bukti Bayar
    |--------------------------------------------------------------------------
    |
    | Bukti bayar disimpan pada disk privat (bukan folder publik) dan hanya
    | dapat diakses melalui endpoint yang memeriksa hak akses.
    |
    */

    'proof' => [
        'disk' => 'local',
        'dir' => 'payment-proofs',
        'max_kb' => (int) env('FESTIVAL_PROOF_MAX_KB', 3072),
        'mimes' => ['jpg', 'jpeg', 'png', 'pdf'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Aturan Bisnis Pendaftaran
    |--------------------------------------------------------------------------
    */

    'max_competitions_per_child' => (int) env('FESTIVAL_MAX_LOMBA_PER_ANAK', 2),
    'coupon_per_child' => (int) env('FESTIVAL_COUPON_PER_CHILD', 1),

    /*
    |--------------------------------------------------------------------------
    | Notifikasi Perubahan Status Pembayaran (opsional)
    |--------------------------------------------------------------------------
    */

    'notify' => [
        'enabled' => env('FESTIVAL_PAYMENT_NOTIFY', false),
    ],

];
