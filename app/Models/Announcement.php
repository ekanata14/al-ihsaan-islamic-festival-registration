<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    public const TARGETS = [
        'all' => 'Semua Pengguna',
        'user' => 'Wali (Peserta Lomba)',
        'khitan' => 'Peserta Khitan',
        'admin' => 'Admin / Panitia',
    ];

    protected $fillable = [
        'title',
        'body',
        'target',
        'is_published',
        'published_at',
        'created_by',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function targetLabel(): string
    {
        return self::TARGETS[$this->target] ?? $this->target;
    }
}
