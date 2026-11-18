<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingAssignment extends Model
{
    protected $fillable = [
        'booking_id',
        'therapist_id',
        'status',
        'admin_status',
        'rejection_reason',
        'responded_at',
        'admin_responded_at',
    ];

    protected $casts = [
        'responded_at' => 'datetime',
        'admin_responded_at' => 'datetime',
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function therapist(): BelongsTo
    {
        return $this->belongsTo(User::class, 'therapist_id');
    }
}
