<?php

namespace App\Http\Controllers;

use App\Models\Booking;

class AdminController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('user')
            ->latest()
            ->get(); // TANPA is_hidden
    
        return view('admin', compact('bookings'));
    }

    
}