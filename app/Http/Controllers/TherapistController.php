<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TherapistController extends Controller
{
    // =========================================
    // DASHBOARD TERAPIS
    // =========================================

    public function index(Request $request)
    {
        $therapistId = Auth::id();

        $month = $request->query('month', now()->format('Y-m'));

        if (!preg_match('/^\d{4}-(0[1-9]|1[0-2])$/', $month)) {
            $month = now()->format('Y-m');
        }

        $currentMonth = Carbon::createFromFormat('Y-m', $month)->startOfMonth();

        $calendarStart = $currentMonth->copy()->startOfWeek(Carbon::MONDAY);
        $calendarEnd = $currentMonth->copy()->endOfMonth()->endOfWeek(Carbon::SUNDAY);

        // Penugasan yang menunggu respons terapis.
        $incomingAssignments = BookingAssignment::with(['booking.user'])
            ->where('therapist_id', $therapistId)
            ->where('status', 'pending')
            ->whereHas('booking')
            ->latest()
            ->get();

        // Riwayat penugasan untuk kalender.
        // Termasuk tugas yang diterima, selesai, dan ditolak admin.
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
                return Carbon::parse(
                    $assignment->booking->booking_date
                )->format('Y-m-d');
            });

        $calendarDays = collect();

        $totalDays = $calendarStart->diffInDays($calendarEnd) + 1;

        for ($i = 0; $i < $totalDays; $i++) {
            $calendarDays->push($calendarStart->copy()->addDays($i));
        }

        // Statistik penugasan.
        $totalBooking = BookingAssignment::where('therapist_id', $therapistId)
            ->whereIn('status', ['pending', 'accepted', 'completed', 'rejected'])
            ->count();

        $pendingBooking = BookingAssignment::where('therapist_id', $therapistId)
            ->where('status', 'pending')
            ->count();

        // Sudah diterima terapis, menunggu persetujuan admin.
        $waitingAdmin = BookingAssignment::where('therapist_id', $therapistId)
            ->where('status', 'accepted')
            ->where('admin_status', 'pending')
            ->count();

        // Sudah disetujui admin.
        $approvedBooking = BookingAssignment::where('therapist_id', $therapistId)
            ->where('status', 'accepted')
            ->where('admin_status', 'approved')
            ->count();

        $completedBooking = BookingAssignment::where('therapist_id', $therapistId)
            ->where('status', 'completed')
            ->count();

        $rejectedByAdmin = BookingAssignment::where('therapist_id', $therapistId)
            ->where('status', 'accepted')
            ->where('admin_status', 'rejected')
            ->count();

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
            'waitingAdmin',
            'approvedBooking',
            'completedBooking',
            'rejectedByAdmin'
        ));
    }


    // =========================================
    // TERAPIS MENYELESAIKAN TREATMENT
    // =========================================

    public function complete($id)
    {
        DB::transaction(function () use ($id) {

            $assignment = BookingAssignment::where('id', $id)
                ->where('therapist_id', Auth::id())
                ->lockForUpdate()
                ->firstOrFail();

            // Hanya tugas yang diterima terapis dan disetujui admin
            // yang boleh diselesaikan.
            if (
                $assignment->status !== 'accepted' ||
                $assignment->admin_status !== 'approved'
            ) {
                abort(403, 'Treatment belum mendapatkan persetujuan admin.');
            }

            $booking = Booking::where('id', $assignment->booking_id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($booking->status !== 'approved') {
                abort(403, 'Booking belum disetujui admin.');
            }

            $assignment->update([
                'status' => 'completed',
                'responded_at' => now(),
            ]);

            $booking->update([
                'status' => 'completed',
            ]);
        });

        return back()->with(
            'success',
            'Treatment berhasil ditandai selesai.'
        );
    }


    // =========================================
    // TERAPIS MENGUBAH STATUS KETERSEDIAAN
    // =========================================

    public function toggleAvailability()
    {
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


    // =========================================
    // TERAPIS MENERIMA PENUGASAN
    // =========================================

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
                'admin_status' => 'pending',
                'admin_responded_at' => null,
            ]);
        });

        return back()->with(
            'success',
            'Pekerjaan berhasil diterima. Menunggu persetujuan admin.'
        );
    }


    // =========================================
    // TERAPIS MENOLAK PENUGASAN
    // =========================================

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

            $booking = Booking::where('id', $assignment->booking_id)
                ->lockForUpdate()
                ->firstOrFail();

            // Lepaskan terapis dari booking.
            // Status customer tetap pending.
            if ($booking->therapist_id == Auth::id()) {
                $booking->update([
                    'therapist_id' => null,
                ]);
            }
        });

        return back()->with(
            'success',
            'Pekerjaan berhasil ditolak. Admin dapat memilih terapis lain.'
        );
    }
}
