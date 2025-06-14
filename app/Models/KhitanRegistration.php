<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KhitanRegistration extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'registration_number',
        'pic_id',
        'name',
        'age',
        'birth_place',
        'birth_date',
        'nik',
        'domicile',
        'is_sanur',
        'photo_url',
        'certificate_url',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_sanur' => 'boolean',
        'birth_date' => 'date',
    ];

    /**
     * Get the user associated with this registration.
     */
    public function pic()
    {
        return $this->belongsTo(User::class, 'pic_id');
    }

    public function familyCard()
    {
        return $this->hasOne(KhitanFamilyCard::class);
    }
}
