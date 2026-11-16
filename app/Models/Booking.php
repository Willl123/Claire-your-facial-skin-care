<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'gender',
        'treatment',
        'phone',
        'booking_date',
        'booking_time',
        'address',
        'notes',
        'status',
        'is_hidden'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}