<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = [
        'name', 'type', 'image_url', 'daily_price',
        'fine_pct_per_hour', 'seats', 'status',
    ];
}