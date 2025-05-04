<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $fillable = [
        'registration_number',
        'pic_id',
        'competition_id',
        'total_participants',
        'group_id',
        'status',
    ];

    public function pic()
    {
        return $this->belongsTo(User::class, 'pic_id');
    }
    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function participants()
    {
        return $this->hasMany(Participant::class);
    }
}
