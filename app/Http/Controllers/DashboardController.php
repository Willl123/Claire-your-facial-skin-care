<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // untuk admin / dashboard utama
        $bookings = Booking::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        // untuk sidebar notifikasi
        $notifications = Booking::where('user_id', Auth::id())
            ->where('is_hidden', 0)
            ->latest()
            ->get();

        return view('welcome', [
            'bookings' => $bookings,
            'notifications' => $notifications
        ]);
    }
}