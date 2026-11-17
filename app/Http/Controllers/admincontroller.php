<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Mengambil semua data booking
        $bookings = Booking::with(['user', 'therapist'])
            ->latest()
            ->get();

        // Dropdown penugasan hanya menampilkan terapis Aktif
        $therapists = User::where('role', 'therapist')
            ->where('is_available', true)
            ->get();

        return view('admin', compact('bookings', 'therapists'));
    }

    public function therapistSchedules(Request $request)
    {
        // Validasi format bulan, misalnya 2026-11
        $validated = $request->validate([
            'month' => 'nullable|date_format:Y-m',
        ]);

        // Bulan yang sedang ditampilkan
        $currentMonth = Carbon::createFromFormat(
            'Y-m',
            $validated['month'] ?? now()->format('Y-m')
        )->startOfMonth();

        // Rentang tanggal kalender, termasuk tanggal bulan sebelumnya/berikutnya
        $calendarStart = $currentMonth->copy()
            ->startOfWeek(Carbon::MONDAY);

        $calendarEnd = $currentMonth->copy()
            ->endOfMonth()
            ->endOfWeek(Carbon::SUNDAY);

        // Ambil semua terapis, termasuk yang Nonaktif
        $therapists = User::where('role', 'therapist')
            ->orderBy('name')
            ->get();

        // Ambil booking yang sudah memiliki terapis pada rentang kalender
        $bookings = Booking::with(['user', 'therapist'])
            ->whereNotNull('therapist_id')
            ->whereBetween('booking_date', [
                $calendarStart->toDateString(),
                $calendarEnd->toDateString(),
            ])
            ->orderBy('booking_time')
            ->get()
            ->groupBy(function ($booking) {
                return Carbon::parse($booking->booking_date)->format('Y-m-d');
            });

        // Membuat daftar tanggal untuk ditampilkan pada kalender
        $calendarDays = collect();

        $date = $calendarStart->copy();

        while ($date->lte($calendarEnd)) {
            $calendarDays->push($date->copy());
            $date->addDay();
        }

        $previousMonth = $currentMonth->copy()
            ->subMonth()
            ->format('Y-m');

        $nextMonth = $currentMonth->copy()
            ->addMonth()
            ->format('Y-m');

        return view('therapist-schedules', compact(
            'therapists',
            'bookings',
            'calendarDays',
            'currentMonth',
            'previousMonth',
            'nextMonth'
        ));
    }
}
