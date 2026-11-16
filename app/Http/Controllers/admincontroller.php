<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        // Mengambil semua data booking
        $bookings = Booking::with('user')
            ->latest()
            ->get();

        // Mengambil semua akun yang memiliki role therapist
        $therapists = User::where('role', 'therapist')
            ->get();

        return view('admin', compact('bookings', 'therapists'));
    }
}
