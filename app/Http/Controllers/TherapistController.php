<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\BookingAssignment;
use Illuminate\Support\Facades\DB;


class TherapistController extends Controller
{
    /**
     * Dashboard dan kalender booking terapis
     */

    public function index(Request $request)
    {
        $therapistId = Auth::id();

        // Mengatur bulan kalender
        $month = $request->query('month', now()->format('Y-m'));

        if (!preg_match('/^\d{4}-(0[1-9]|1[0-2])$/', $month)) {
            $month = now()->format('Y-m');
        }

        $currentMonth = Carbon::createFromFormat('Y-m', $month)->startOfMonth();

        // Rentang kalender dari Senin sampai Minggu
        $calendarStart = $currentMonth->copy()->startOfWeek(Carbon::MONDAY);
        $calendarEnd = $currentMonth->copy()->endOfMonth()->endOfWeek(Carbon::SUNDAY);

        // Pekerjaan masuk: menunggu respons dan riwayat penolakan
        $incomingAssignments = BookingAssignment::with(['booking.user'])
            ->where('therapist_id', $therapistId)
            ->whereIn('status', ['pending', 'rejected'])
            ->whereHas('booking')
            ->latest()
            ->get();

        // Jadwal kalender: hanya pekerjaan yang diterima atau selesai
        $calendarAssignments = BookingAssignment::with(['booking.user'])
            ->where('therapist_id', $therapistId)
            ->whereIn('status', ['accepted', 'completed'])
            ->whereHas('booking', function ($query) use ($calendarStart, $calendarEnd) {
                $query->whereBetween('booking_date', [
                    $calendarStart->toDateString(),
                    $calendarEnd->toDateString(),
                ]);
            })
            ->get()
            ->groupBy(function ($assignment) {
                return Carbon::parse($assignment->booking->booking_date)->format('Y-m-d');
            });

        // Membuat daftar tanggal kalender
        $calendarDays = collect();

        $totalDays = $calendarStart->diffInDays($calendarEnd) + 1;

        for ($i = 0; $i < $totalDays; $i++) {
            $calendarDays->push($calendarStart->copy()->addDays($i));
        }

        // Statistik penugasan terapis
        $totalBooking = BookingAssignment::where('therapist_id', $therapistId)
            ->whereIn('status', ['pending', 'accepted', 'completed', 'rejected'])
            ->count();

        $pendingBooking = BookingAssignment::where('therapist_id', $therapistId)
            ->where('status', 'pending')
            ->count();

        $approvedBooking = BookingAssignment::where('therapist_id', $therapistId)
            ->where('status', 'accepted')
            ->count();

        $completedBooking = BookingAssignment::where('therapist_id', $therapistId)
            ->where('status', 'completed')
            ->count();

        // Navigasi kalender
        $previousMonth = $currentMonth->copy()->subMonth()->format('Y-m');
        $nextMonth = $currentMonth->copy()->addMonth()->format('Y-m');

        return view('therapist', compact(
            'incomingAssignments',
            'calendarAssignments',
            'calendarDays',
            'currentMonth',
            'previousMonth',
            'nextMonth',
            'totalBooking',
            'pendingBooking',
            'approvedBooking',
            'completedBooking'
        ));
    }




    /**
     * Menandai booking sebagai selesai
     */
    public function complete($id)
    {
        DB::transaction(function () use ($id) {

            // Memastikan booking ditugaskan kepada terapis yang login
            $booking = Booking::where('therapist_id', Auth::id())
                ->where('id', $id)
                ->lockForUpdate()
                ->firstOrFail();

            // Memastikan penugasan berstatus accepted
            $assignment = BookingAssignment::where('booking_id', $booking->id)
                ->where('therapist_id', Auth::id())
                ->where('status', 'accepted')
                ->lockForUpdate()
                ->firstOrFail();

            // Mengubah status penugasan menjadi completed
            $assignment->update([
                'status' => 'completed',
                'responded_at' => now(),
            ]);

            // Mengubah status booking menjadi completed
            $booking->update([
                'status' => 'completed',
            ]);
        });

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


    public function acceptAssignment($id)
    {
        DB::transaction(function () use ($id) {

            $assignment = BookingAssignment::where('id', $id)
                ->where('therapist_id', Auth::id())
                ->lockForUpdate()
                ->firstOrFail();

            if ($assignment->status !== 'pending') {
                abort(403, 'Pekerjaan ini sudah tidak menunggu respons.');
            }

            $assignment->update([
                'status' => 'accepted',
                'responded_at' => now(),
            ]);
        });

        return back()->with(
            'success',
            'Pekerjaan berhasil diterima dan masuk ke jadwal kamu.'
        );
    }

    public function rejectAssignment(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        DB::transaction(function () use ($request, $id) {

            $assignment = BookingAssignment::where('id', $id)
                ->where('therapist_id', Auth::id())
                ->lockForUpdate()
                ->firstOrFail();

            if ($assignment->status !== 'pending') {
                abort(403, 'Pekerjaan ini sudah tidak menunggu respons.');
            }

            $assignment->update([
                'status' => 'rejected',
                'rejection_reason' => $request->rejection_reason,
                'responded_at' => now(),
            ]);

            // Lepaskan terapis dari booking agar admin bisa menugaskan ulang
            $assignment->booking->update([
                'therapist_id' => null,
            ]);
        });

        return back()->with(
            'success',
            'Pekerjaan berhasil ditolak. Admin akan menerima informasi penolakan.'
        );
    }
}
