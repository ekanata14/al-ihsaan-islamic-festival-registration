<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $fillable = [
        'registration_id',
        'name',
        'age',
        'nik',
        'certificate_url',
    ];

    // Define relationship with Registration
    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }
}
