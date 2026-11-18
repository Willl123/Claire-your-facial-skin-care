<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'email', 'password', 'role', 'photo'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'photo',
    ];

    // Booking yang dibuat oleh customer
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'user_id');
    }

    // Booking yang ditugaskan kepada terapis
    public function assignedBookings()
    {
        return $this->hasMany(Booking::class, 'therapist_id');
    }

    public function bookingAssignments(): HasMany
    {
        return $this->hasMany(BookingAssignment::class, 'therapist_id');
    }
}
