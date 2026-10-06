<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class LandingSetting extends Model
{
    protected $fillable = [
        'key',
        'value',
    ];

    public const CACHE_KEY = 'landing.settings';

    /**
     * Semua setting sebagai array key => value (string mentah).
     */
    public static function allCached(): array
    {
        try {
            return Cache::rememberForever(self::CACHE_KEY, function () {
                return static::query()->pluck('value', 'key')->toArray();
            });
        } catch (\Throwable $e) {
            return [];
        }
    }

    public static function get(string $key, $default = null)
    {
        return static::allCached()[$key] ?? $default;
    }

    /**
     * Ambil setting yang disimpan sebagai JSON (array/repeater).
     */
    public static function getJson(string $key, array $default = []): array
    {
        $value = static::get($key);

        if ($value === null || $value === '') {
            return $default;
        }

        $decoded = json_decode($value, true);

        return is_array($decoded) ? $decoded : $default;
    }

    public static function put(string $key, $value): void
    {
        if (is_array($value)) {
            $value = json_encode($value);
        }

        static::updateOrCreate(['key' => $key], ['value' => $value]);
        static::flushCache();
    }

    public static function flushCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    protected static function booted(): void
    {
        static::saved(fn () => self::flushCache());
        static::deleted(fn () => self::flushCache());
    }
}
