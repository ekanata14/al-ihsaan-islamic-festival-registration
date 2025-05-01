<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image_url',
        'type',
        'category_id',
        'registration_start',
        'registration_end',
        'status',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
