<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KhitanFamilyCard extends Model
{
    protected $fillable = [
        'khitan_registration_id',
        'family_card_url',
    ];

    public function khitanRegistration()
    {
        return $this->belongsTo(KhitanRegistration::class);
    }
}
