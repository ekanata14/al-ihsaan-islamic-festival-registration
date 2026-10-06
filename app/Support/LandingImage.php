<?php

namespace App\Support;

class LandingImage
{
    /**
     * Ubah nilai gambar dari admin menjadi URL yang bisa dirender.
     * Mendukung: URL eksternal, path aset publik (assets/...), dan path storage (storage/...).
     */
    public static function url(?string $path, ?string $fallback = null): string
    {
        $path = $path ?: $fallback;

        if (! $path) {
            return '';
        }

        if (preg_match('/^https?:\/\//i', $path)) {
            return $path;
        }

        return asset(ltrim($path, '/'));
    }
}
