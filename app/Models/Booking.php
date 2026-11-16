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
        'address',
        'notes',
        'status',
        'is_hidden',
    ];

    // Relasi dengan customer
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi dengan terapis
    public function therapist(): BelongsTo
    {
        return $this->belongsTo(User::class, 'therapist_id');
    }

    
}
