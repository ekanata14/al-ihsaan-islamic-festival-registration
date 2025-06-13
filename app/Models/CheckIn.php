<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheckIn extends Model
{
    protected $fillable = [
        'participant_number',
        'pic_id',
        'participant_id',
        'registration_id',
        'competition_id',
    ];

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }

    public function pic()
    {
        return $this->belongsTo(User::class, 'pic_id');
    }
}
