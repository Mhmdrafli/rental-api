<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'booking_id',
        'method',
        'amount',
        'proof_url',
        'status',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}