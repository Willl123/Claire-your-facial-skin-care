<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use App\Models\BookingAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class BookingController extends Controller
{
    // =========================================
    // CUSTOMER MEMBUAT BOOKING
    // =========================================

    public function store(Request $request)
    {
        $request->validate([
            'gender' => 'required|in:Male,Female',
            'treatment' => 'required|in:Deep Cleansing Facial,Acne Facial,Brightening Facial,Hydrafacial,Anti Aging Treatment,Premium Glow Facial',
            'phone' => 'required|string|max:20',
            'booking_date' => 'required|date|after_or_equal:today',
            'booking_time' => 'required|date_format:H:i',
            'place' => 'required|in:clinic,home',
            'address' => 'required_if:place,home|nullable|string|max:1000',
            'payment_method' => 'required|in:Bank Transfer,E-Wallet,QRIS,Cash',
            'notes' => 'nullable|string|max:2000',
        ]);

        $bookingDateTime = Carbon::createFromFormat(
            'Y-m-d H:i',
            $request->booking_date . ' ' . $request->booking_time,
            config('app.timezone')
        );

        if ($bookingDateTime->lessThanOrEqualTo(now())) {
            throw ValidationException::withMessages([
                'booking_time' => 'Jam booking sudah lewat. Silakan pilih waktu lain.',
            ]);
        }

        $treatmentPrices = [
            'Deep Cleansing Facial' => 150000,
            'Acne Facial' => 200000,
            'Brightening Facial' => 250000,
            'Hydrafacial' => 300000,
            'Anti Aging Treatment' => 350000,
            'Premium Glow Facial' => 400000,
        ];

        $price = $treatmentPrices[$request->treatment];
        $serviceFee = 10000;

        Booking::create([
            'user_id' => Auth::id(),
            'gender' => $request->gender,
            'treatment' => $request->treatment,
            'phone' => $request->phone,
            'booking_date' => $request->booking_date,
            'booking_time' => $request->booking_time,
            'place' => $request->place,
            'address' => $request->place === 'home'
                ? $request->address
                : 'Klinik',
            'payment_method' => $request->payment_method,
            'price' => $price,
            'service_fee' => $serviceFee,
            'total_price' => $price + $serviceFee,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);

        return redirect('/dashboard')
            ->with('success', 'Booking berhasil dibuat.');
    }


    // =========================================
    // ADMIN MENYETUJUI PENUGASAN TERAPIS
    // =========================================

    public function approve($id)
    {
        DB::transaction(function () use ($id) {

            $booking = Booking::where('id', $id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($booking->status !== 'pending') {
                throw ValidationException::withMessages([
                    'booking' => 'Pesanan ini tidak lagi menunggu persetujuan.',
                ]);
            }

            $assignment = BookingAssignment::where('booking_id', $booking->id)
                ->where('status', 'accepted')
                ->where('admin_status', 'pending')
                ->lockForUpdate()
                ->latest('id')
                ->first();

            if (!$assignment) {
                throw ValidationException::withMessages([
                    'booking' => 'Terapis belum menerima tugas atau penugasan tidak tersedia.',
                ]);
            }

            $assignment->update([
                'admin_status' => 'approved',
                'admin_responded_at' => now(),
            ]);

            $booking->update([
                'status' => 'approved',
            ]);
        });

        return back()->with(
            'success',
            'Penugasan terapis berhasil disetujui. Customer dapat melihat pesanan Disetujui.'
        );
    }


    // =========================================
    // ADMIN MENOLAK PENUGASAN TERAPIS
    // =========================================

    public function rejectAssignment($id)
    {
        DB::transaction(function () use ($id) {

            $booking = Booking::where('id', $id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($booking->status !== 'pending') {
                throw ValidationException::withMessages([
                    'booking' => 'Pesanan ini tidak dapat diproses lagi.',
                ]);
            }

            $assignment = BookingAssignment::where('booking_id', $booking->id)
                ->where('status', 'accepted')
                ->where('admin_status', 'pending')
                ->lockForUpdate()
                ->latest('id')
                ->first();

            if (!$assignment) {
                throw ValidationException::withMessages([
                    'booking' => 'Tidak ada penugasan yang menunggu persetujuan admin.',
                ]);
            }

            $assignment->update([
                'admin_status' => 'rejected',
                'admin_responded_at' => now(),
            ]);

            // Lepaskan terapis dari booking agar dapat ditugaskan ulang.
            $booking->update([
                'therapist_id' => null,
            ]);
        });

        return back()->with(
            'success',
            'Penugasan terapis ditolak. Silakan pilih terapis lain.'
        );
    }


    // =========================================
    // ADMIN MENOLAK PESANAN CUSTOMER
    // =========================================

    public function reject($id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->status !== 'pending') {
            return back()->with(
                'error',
                'Pesanan ini tidak lagi menunggu persetujuan.'
            );
        }

        $booking->update([
            'status' => 'rejected',
        ]);

        return back()->with(
            'success',
            'Pesanan customer berhasil ditolak.'
        );
    }


    // =========================================
    // ADMIN MENYELESAIKAN BOOKING (JIKA MASIH DIPAKAI)
    // =========================================

    public function complete($id)
    {
        return back()->with(
            'error',
            'Penyelesaian treatment dilakukan oleh terapis yang ditugaskan.'
        );
    }


    // =========================================
    // CUSTOMER MELIHAT BOOKING
    // =========================================

    public function index()
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard', compact('bookings'));
    }


    // =========================================
    // NOTIFIKASI CUSTOMER
    // =========================================

    public function notifications()
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->where('is_hidden', false)
            ->latest()
            ->get();

        return view('notifications', compact('bookings'));
    }


    // =========================================
    // MENYEMBUNYIKAN NOTIFIKASI
    // =========================================

    public function hide($id)
    {
        $booking = Booking::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $booking->update([
            'is_hidden' => true,
        ]);

        return back()->with(
            'success',
            'Notifikasi berhasil disembunyikan.'
        );
    }


    // =========================================
    // ADMIN MENUGASKAN TERAPIS
    // =========================================

    public function assignTherapist(Request $request, $id)
    {
        $request->validate([
            'therapist_id' => 'required|exists:users,id',
        ]);

        DB::transaction(function () use ($request, $id) {

            $booking = Booking::where('id', $id)
                ->lockForUpdate()
                ->firstOrFail();

            // Pesanan yang sudah ditolak atau selesai tidak dapat ditugaskan.
            if (in_array($booking->status, ['rejected', 'completed'])) {
                throw ValidationException::withMessages([
                    'therapist_id' => 'Pesanan ini tidak dapat ditugaskan.',
                ]);
            }

            $therapist = User::where('id', $request->therapist_id)
                ->where('role', 'therapist')
                ->lockForUpdate()
                ->first();

            if (!$therapist || !$therapist->is_available) {
                throw ValidationException::withMessages([
                    'therapist_id' => 'Terapis tidak tersedia atau sedang nonaktif.',
                ]);
            }

            // Cegah penugasan aktif ganda kepada terapis yang sama.
            $sameAssignment = BookingAssignment::where('booking_id', $booking->id)
                ->where('therapist_id', $therapist->id)
                ->whereIn('status', ['pending', 'accepted'])
                ->where(function ($query) {
                    $query->where('status', 'pending')
                        ->orWhere('admin_status', 'approved')
                        ->orWhere(function ($subQuery) {
                            $subQuery->where('status', 'accepted')
                                ->where('admin_status', 'pending');
                        });
                })
                ->exists();

            if ($sameAssignment) {
                throw ValidationException::withMessages([
                    'therapist_id' => 'Pekerjaan ini sudah ditugaskan kepada terapis tersebut.',
                ]);
            }

            $newStart = Carbon::parse(
                $booking->booking_date . ' ' . $booking->booking_time
            );

            $newEnd = $newStart->copy()->addHours(2);

            // Hanya pending dan accepted yang belum ditolak admin,
            // atau sudah disetujui admin, dianggap jadwal aktif.
            $existingAssignments = BookingAssignment::with('booking')
                ->where('therapist_id', $therapist->id)
                ->whereIn('status', ['pending', 'accepted'])
                ->where(function ($query) {
                    $query->where('status', 'pending')
                        ->orWhere('admin_status', 'approved')
                        ->orWhere(function ($subQuery) {
                            $subQuery->where('status', 'accepted')
                                ->where('admin_status', 'pending');
                        });
                })
                ->whereHas('booking', function ($query) use ($booking) {
                    $query->whereDate('booking_date', $booking->booking_date);
                })
                ->lockForUpdate()
                ->get();

            foreach ($existingAssignments as $assignment) {

                if ($assignment->booking_id == $booking->id) {
                    continue;
                }

                $existingStart = Carbon::parse(
                    $assignment->booking->booking_date . ' ' .
                        $assignment->booking->booking_time
                );

                $existingEnd = $existingStart->copy()->addHours(2);

                if ($newStart->lt($existingEnd) && $existingStart->lt($newEnd)) {
                    throw ValidationException::withMessages([
                        'therapist_id' =>
                        'Terapis sudah memiliki jadwal pada waktu tersebut. Silakan pilih terapis lain atau jam berbeda.',
                    ]);
                }
            }

            // Tandai penugasan aktif sebelumnya sebagai digantikan.
            BookingAssignment::where('booking_id', $booking->id)
                ->where(function ($query) {
                    $query->where('status', 'pending')
                        ->orWhere(function ($subQuery) {
                            $subQuery->where('status', 'accepted')
                                ->where('admin_status', 'pending');
                        })
                        ->orWhere(function ($subQuery) {
                            $subQuery->where('status', 'accepted')
                                ->where('admin_status', 'approved');
                        });
                })
                ->update([
                    'status' => 'reassigned',
                    'updated_at' => now(),
                ]);

            // Buat penugasan baru.
            BookingAssignment::create([
                'booking_id' => $booking->id,
                'therapist_id' => $therapist->id,
                'status' => 'pending',
                'admin_status' => 'pending',
            ]);

            $booking->update([
                'therapist_id' => $therapist->id,
                'status' => 'pending',
            ]);
        });

        return back()->with(
            'success',
            'Pekerjaan berhasil diberikan kepada terapis. Menunggu konfirmasi terapis.'
        );
    }
}
