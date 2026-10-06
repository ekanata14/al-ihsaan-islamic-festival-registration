<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_id',
        'child_id',
        'name',
        'age',
        'birth_place',
        'birth_date',
        'nik',
        'photo_url',
        'certificate_url',
    ];

    // Define relationship with Registration
    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    public function child()
    {
        return $this->belongsTo(Child::class);
    }

    public function checkIn()
    {
        return $this->hasOne(CheckIn::class, 'participant_id');
    }
}
