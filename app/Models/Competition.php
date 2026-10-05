<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image_url',
        'type',
        'category_id',
        'min_age',
        'max_age',
        'time_slot',
        'registration_start',
        'registration_end',
        'status',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class, 'competition_id');
    }

    public function checkins()
    {
        return $this->hasMany(CheckIn::class, 'competition_id');
    }
}
