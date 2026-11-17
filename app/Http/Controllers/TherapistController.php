<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TherapistController extends Controller
{
    /**
     * Dashboard dan kalender booking terapis
     */
    public function index(Request $request)
    {
        // ID terapis yang sedang login
        $therapistId = Auth::id();

        // Mengambil bulan dari URL, contoh: ?month=2026-11
        $month = $request->query('month', now()->format('Y-m'));

        // Memastikan format bulan benar
        if (
            !preg_match('/^\d{4}-\d{2}$/', $month) ||
            !checkdate(
                (int) substr($month, 5, 2),
                1,
                (int) substr($month, 0, 4)
            )
        ) {
            $month = now()->format('Y-m');
        }

        // Menentukan bulan kalender
        $currentMonth = Carbon::createFromFormat('!Y-m', $month);

        // Awal dan akhir kalender (Senin sampai Minggu)
        $calendarStart = $currentMonth->copy()
            ->startOfWeek(Carbon::MONDAY);

        $calendarEnd = $currentMonth->copy()
            ->endOfMonth()
            ->endOfWeek(Carbon::SUNDAY);

        /*
        |--------------------------------------------------------------------------
        | Mengambil booking milik terapis yang sedang login
        |--------------------------------------------------------------------------
        */

        $therapistBookings = Booking::with('user')
            ->where('therapist_id', $therapistId)
            ->whereBetween('booking_date', [
                $calendarStart->toDateString(),
                $calendarEnd->toDateString()
            ])
            ->orderBy('booking_date', 'asc')
            ->orderBy('booking_time', 'asc')
            ->get();

        // Mengelompokkan booking berdasarkan tanggal
        $bookings = $therapistBookings->groupBy(function ($booking) {
            return Carbon::parse($booking->booking_date)->format('Y-m-d');
        });

        /*
        |--------------------------------------------------------------------------
        | Menghitung statistik seluruh booking milik terapis
        |--------------------------------------------------------------------------
        */

        $totalBooking = Booking::where('therapist_id', $therapistId)
            ->count();

        $pendingBooking = Booking::where('therapist_id', $therapistId)
            ->where('status', 'pending')
            ->count();

        $approvedBooking = Booking::where('therapist_id', $therapistId)
            ->where('status', 'approved')
            ->count();

        $completedBooking = Booking::where('therapist_id', $therapistId)
            ->where('status', 'completed')
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Membuat tanggal-tanggal kalender
        |--------------------------------------------------------------------------
        */

        $calendarDays = [];

        $date = $calendarStart->copy();

        while ($date->lte($calendarEnd)) {
            $calendarDays[] = $date->copy();

            $date->addDay();
        }

        /*
        |--------------------------------------------------------------------------
        | Navigasi bulan sebelumnya dan berikutnya
        |--------------------------------------------------------------------------
        */

        $previousMonth = $currentMonth->copy()
            ->subMonth()
            ->format('Y-m');

        $nextMonth = $currentMonth->copy()
            ->addMonth()
            ->format('Y-m');

        // Mengirim data ke halaman therapist.blade.php
        return view('therapist', compact(
            'bookings',
            'totalBooking',
            'pendingBooking',
            'approvedBooking',
            'completedBooking',
            'calendarDays',
            'currentMonth',
            'previousMonth',
            'nextMonth'
        ));
    }


    /**
     * Menandai booking sebagai selesai
     */
    public function complete($id)
    {
        // Memastikan booking memang ditugaskan kepada terapis login
        $booking = Booking::where('therapist_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        // Booking harus berstatus approved
        if ($booking->status !== 'approved') {
            return back()->with(
                'error',
                'Booking harus disetujui terlebih dahulu sebelum ditandai selesai.'
            );
        }

        // Mengubah status booking menjadi completed
        $booking->update([
            'status' => 'completed'
        ]);

        return back()->with(
            'success',
            'Treatment berhasil ditandai selesai.'
        );
    }


    /**
     * Mengubah status ketersediaan terapis
     */
    public function toggleAvailability()
    {
        /** @var \App\Models\User $therapist */
        $therapist = Auth::user();

        if (!$therapist || $therapist->role !== 'therapist') {
            abort(403, 'Akses hanya untuk terapis.');
        }

        $therapist->is_available = !$therapist->is_available;

        $therapist->save();

        return back()->with(
            'success',
            $therapist->is_available
                ? 'Status berhasil diubah menjadi Aktif.'
                : 'Status berhasil diubah menjadi Nonaktif.'
        );
    }
}
