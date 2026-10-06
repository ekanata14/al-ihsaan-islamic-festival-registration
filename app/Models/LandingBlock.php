<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class LandingBlock extends Model
{
    protected $fillable = [
        'type',
        'name',
        'content',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'content' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public const CACHE_KEY = 'landing.blocks';

    /**
     * Urutan default: blok paling atas di halaman.
     */
    public static function activeOrdered()
    {
        return Cache::rememberForever(self::CACHE_KEY, function () {
            return static::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get();
        });
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
