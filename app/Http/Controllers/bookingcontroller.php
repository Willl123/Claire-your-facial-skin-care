<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class BookingController extends Controller
{
    // =========================
    // CUSTOMER: CREATE BOOKING
    // =========================
    public function store(Request $request)
    {


    $request->validate([
        'booking_date' => 'required|date|after_or_equal:today',
    ]);

        Booking::create([
            'user_id' => Auth::id(),
            'gender' => $request->gender, 
            'treatment' => $request->treatment,
            'phone' => $request->phone,
            'booking_date' => $request->booking_date,
            'booking_time' => $request->booking_time,
            'address' => $request->address ?? 'Klinik',
            'notes' => $request->notes,
            'status' => 'pending'
        ]);

        return redirect('/dashboard')->with('success', 'Booking berhasil dibuat');
    }

    // =========================
    // ADMIN: APPROVE
    // =========================
    public function approve($id)
    {
        $booking = Booking::findOrFail($id);

        $booking->status = 'approved';
        $booking->save();

        return back()->with('success', 'Booking di-approve');
    }

    // =========================
    // ADMIN: REJECT
    // =========================
    public function reject($id)
    {
        $booking = Booking::findOrFail($id);

        $booking->status = 'rejected';
        $booking->save();

        return back()->with('success', 'Booking di-reject');
    }

    // =========================
    // ADMIN: COMPLETE
    // =========================
    public function complete($id)
    {
        $booking = Booking::findOrFail($id);

        // hanya bisa completed kalau sudah approved
        if ($booking->status !== 'approved') {
            return back()->with('error', 'Booking harus approved dulu');
        }

        $booking->status = 'completed';
        $booking->save();

        return back()->with('success', 'Booking selesai');
    }

    // =========================
    // CUSTOMER: DASHBOARD DATA
    // =========================
    public function index()
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard', compact('bookings'));
    }


    
public function notifications()
{
    $bookings = Booking::where('user_id', Auth::id())
        ->where('is_hidden', false)
        ->latest()
        ->get();

    return view('notifications', compact('bookings'));
}

public function hide($id)
{
    $booking = Booking::where('id', $id)
        ->where('user_id', Auth::id())
        ->firstOrFail();

    $booking->update([
        'is_hidden' => true
    ]);

    return back()->with('success', 'Notifikasi berhasil disembunyikan.');
}

    


            // ADMIN: ASSIGN THERAPIST
    public function assignTherapist(Request $request, $id)
    {
        $request->validate([
            'therapist_id' => 'required|exists:users,id',
        ]);

        // Pastikan akun yang dipilih benar-benar terapis
        $therapist = User::where('id', $request->therapist_id)
            ->where('role', 'therapist')
            ->firstOrFail();

        $booking = Booking::findOrFail($id);

        $booking->therapist_id = $therapist->id;
        $booking->save();

        return back()->with('success', 'Terapis berhasil ditugaskan.');
    }



}