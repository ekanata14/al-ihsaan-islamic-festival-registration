<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    use HasFactory;

    protected $fillable = [
        'pic_id',
        'name',
        'age',
        'birth_place',
        'birth_date',
        'nik',
    ];

    public function pic()
    {
        return $this->belongsTo(User::class, 'pic_id');
    }

    public function participants()
    {
        return $this->hasMany(Participant::class);
    }
}
