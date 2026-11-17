<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'therapist_id',
        'gender',
        'treatment',
        'phone',
        'booking_date',
        'booking_time',
        'place',
        'address',
        'payment_method',
        'price',
        'service_fee',
        'total_price',
        'notes',
        'status',
        'is_hidden',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function therapist(): BelongsTo
    {
        return $this->belongsTo(User::class, 'therapist_id');
    }
}
