<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    public const STATUS_BELUM_BAYAR = 'belum_bayar';
    public const STATUS_MENUNGGU_VERIFIKASI = 'menunggu_verifikasi';
    public const STATUS_TERVERIFIKASI = 'terverifikasi';
    public const STATUS_DITOLAK = 'ditolak';

    protected $fillable = [
        'pic_id',
        'invoice_number',
        'mode',
        'unit_amount',
        'child_count',
        'lomba_count',
        'total_amount',
        'verified_amount',
        'status',
        'verified_by',
        'verified_at',
        'rejection_reason',
    ];

    protected function casts(): array
    {
        return [
            'verified_at' => 'datetime',
        ];
    }

    public function pic()
    {
        return $this->belongsTo(User::class, 'pic_id');
    }

    public function proofs()
    {
        return $this->hasMany(PaymentProof::class);
    }

    public function latestProof()
    {
        return $this->hasOne(PaymentProof::class)->latestOfMany();
    }

    public function histories()
    {
        return $this->hasMany(PaymentStatusHistory::class)->latest();
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function isBelumBayar(): bool
    {
        return $this->status === self::STATUS_BELUM_BAYAR;
    }

    public function isMenungguVerifikasi(): bool
    {
        return $this->status === self::STATUS_MENUNGGU_VERIFIKASI;
    }

    public function isTerverifikasi(): bool
    {
        return $this->status === self::STATUS_TERVERIFIKASI;
    }

    public function isDitolak(): bool
    {
        return $this->status === self::STATUS_DITOLAK;
    }

    /**
     * Selisih total saat ini terhadap nominal yang sudah diverifikasi.
     * Positif = kurang bayar, negatif = lebih bayar.
     */
    public function difference(): int
    {
        return (int) $this->total_amount - (int) ($this->verified_amount ?? 0);
    }

    public function needsAdjustment(): bool
    {
        return $this->isTerverifikasi()
            && $this->verified_amount !== null
            && $this->difference() !== 0;
    }

    public function couponCount(): int
    {
        return (int) $this->child_count * (int) config('festival.coupon_per_child', 1);
    }
}
