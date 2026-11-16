<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class TherapistController extends Controller
{
    public function index()
    {
        // Mengambil ID terapis yang sedang login
        $therapistId = Auth::id();

        // Mengambil booking yang ditugaskan kepada terapis tersebut
        $bookings = Booking::with('user')
            ->where('therapist_id', $therapistId)
            ->orderBy('booking_date', 'asc')
            ->orderBy('booking_time', 'asc')
            ->get();

        // Menghitung jumlah booking
        $totalBooking = $bookings->count();

        $pendingBooking = $bookings
            ->where('status', 'pending')
            ->count();

        $approvedBooking = $bookings
            ->where('status', 'approved')
            ->count();

        $completedBooking = $bookings
            ->where('status', 'completed')
            ->count();

        return view('therapist', compact(
            'bookings',
            'totalBooking',
            'pendingBooking',
            'approvedBooking',
            'completedBooking'
        ));
    }
}
