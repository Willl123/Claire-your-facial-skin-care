<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\BookingAssignment;

class AdminController extends Controller
{

    public function index()
    {
        $bookings = Booking::with([
            'user',
            'therapist',
            'assignments.therapist'
        ])
            ->latest()
            ->get();

        // Mengambil semua terapis, baik ON maupun OFF
        $therapists = User::where('role', 'therapist')
            ->get();

        return view('admin', compact('bookings', 'therapists'));
    }



    public function therapistSchedules(Request $request)
    {
        // Validasi bulan
        $validated = $request->validate([
            'month' => 'nullable|date_format:Y-m',
        ]);

        // Bulan yang ditampilkan
        $currentMonth = Carbon::createFromFormat(
            'Y-m',
            $validated['month'] ?? now()->format('Y-m')
        )->startOfMonth();

        // Rentang kalender
        $calendarStart = $currentMonth->copy()
            ->startOfWeek(Carbon::MONDAY);

        $calendarEnd = $currentMonth->copy()
            ->endOfMonth()
            ->endOfWeek(Carbon::SUNDAY);

        // Mengambil semua terapis, baik ON maupun OFF
        $therapists = User::where('role', 'therapist')
            ->orderBy('name')
            ->get();

        // Mengambil pekerjaan yang sudah diterima atau selesai
        $assignments = BookingAssignment::with([
            'booking.user',
            'therapist'
        ])
            ->whereIn('status', ['accepted', 'completed'])
            ->whereHas('booking', function ($query) use ($calendarStart, $calendarEnd) {
                $query->whereBetween('booking_date', [
                    $calendarStart->toDateString(),
                    $calendarEnd->toDateString(),
                ]);
            })
            ->get()
            // Urutkan berdasarkan tanggal dan jam
            ->sortBy(function ($assignment) {
                return $assignment->booking->booking_date . ' ' .
                    $assignment->booking->booking_time;
            })
            ->groupBy(function ($assignment) {
                return Carbon::parse(
                    $assignment->booking->booking_date
                )->format('Y-m-d');
            });

        // Membuat daftar tanggal kalender
        $calendarDays = collect();

        $date = $calendarStart->copy();

        while ($date->lte($calendarEnd)) {
            $calendarDays->push($date->copy());
            $date->addDay();
        }

        // Navigasi bulan
        $previousMonth = $currentMonth->copy()
            ->subMonth()
            ->format('Y-m');

        $nextMonth = $currentMonth->copy()
            ->addMonth()
            ->format('Y-m');

        return view('therapist-schedules', compact(
            'therapists',
            'assignments',
            'calendarDays',
            'currentMonth',
            'previousMonth',
            'nextMonth'
        ));
    }


    public function bookingRow(Booking $booking)
    {
        $booking->load([
            'user',
            'therapist',
            'assignments.therapist'
        ]);

        $therapists = User::where('role', 'therapist')->get();

        $html = view('partials-booking-row', [
            'booking' => $booking,
            'therapists' => $therapists
        ])->render();

        return response()->json([
            'html' => $html,
            'totalBookings' => Booking::count(),
            'pendingBookings' => Booking::where('status', 'pending')->count(),
            'completedBookings' => Booking::where('status', 'completed')->count(),
        ]);
    }
}
