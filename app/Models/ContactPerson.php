<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactPerson extends Model
{
    protected $table = 'contact_persons';

    protected $fillable = [
        'name',
        'label',
        'whatsapp',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    /**
     * Bangun tautan wa.me dari nomor yang diisi admin.
     */
    public function whatsappUrl(): string
    {
        $number = preg_replace('/[^0-9]/', '', (string) $this->whatsapp);

        return 'https://wa.me/' . $number;
    }
}
