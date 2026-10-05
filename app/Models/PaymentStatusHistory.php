<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentStatusHistory extends Model
{
    protected $fillable = [
        'payment_id',
        'status',
        'reason',
        'changed_by',
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
