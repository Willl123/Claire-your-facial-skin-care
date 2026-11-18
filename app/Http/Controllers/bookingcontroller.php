<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use App\Models\BookingAssignment;
use Illuminate\Support\Facades\DB;


class BookingController extends Controller
{
    // Menyimpan booking customer
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

        // Validasi tanggal dan waktu berdasarkan zona waktu aplikasi
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

        // Harga treatment ditentukan oleh server
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
        $totalPrice = $price + $serviceFee;

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
            'total_price' => $totalPrice,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);

        return redirect('/dashboard')
            ->with('success', 'Booking berhasil dibuat.');
    }

    // Admin menyetujui booking
    public function approve($id)
    {
        $booking = Booking::findOrFail($id);

        $booking->status = 'approved';
        $booking->save();

        return back()->with('success', 'Booking berhasil disetujui.');
    }

    // Admin menolak booking
    public function reject($id)
    {
        $booking = Booking::findOrFail($id);

        $booking->status = 'rejected';
        $booking->save();

        return back()->with('success', 'Booking berhasil ditolak.');
    }

    // Menandai booking selesai
    public function complete($id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->status !== 'approved') {
            return back()->with('error', 'Booking harus disetujui terlebih dahulu.');
        }

        $booking->status = 'completed';
        $booking->save();

        return back()->with('success', 'Booking berhasil diselesaikan.');
    }

    // Menampilkan booking milik customer
    public function index()
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard', compact('bookings'));
    }

    // Menampilkan notifikasi customer
    public function notifications()
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->where('is_hidden', false)
            ->latest()
            ->get();

        return view('notifications', compact('bookings'));
    }

    // Menyembunyikan notifikasi
    public function hide($id)
    {
        $booking = Booking::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $booking->update([
            'is_hidden' => true,
        ]);

        return back()->with('success', 'Notifikasi berhasil disembunyikan.');
    }

    // Admin menugaskan terapis aktif

    public function assignTherapist(Request $request, $id)
    {
        $request->validate([
            'therapist_id' => 'required|exists:users,id',
        ]);

        DB::transaction(function () use ($request, $id) {

            // Mengunci data booking agar tidak diproses bersamaan
            $booking = Booking::where('id', $id)
                ->lockForUpdate()
                ->firstOrFail();

            // Mengunci data terapis untuk mencegah penugasan bersamaan
            $therapist = User::where('id', $request->therapist_id)
                ->where('role', 'therapist')
                ->lockForUpdate()
                ->first();

            if (!$therapist || !$therapist->is_available) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'therapist_id' => 'Terapis tidak tersedia atau sedang nonaktif.',
                ]);
            }

            // Mencegah penugasan aktif yang sama dibuat berulang
            $sameAssignment = BookingAssignment::where('booking_id', $booking->id)
                ->where('therapist_id', $therapist->id)
                ->whereIn('status', ['pending', 'accepted'])
                ->exists();

            if ($sameAssignment) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'therapist_id' => 'Pekerjaan ini sudah ditugaskan kepada terapis tersebut.',
                ]);
            }

            // Menghitung waktu pekerjaan baru: 2 jam
            $newStart = Carbon::parse(
                $booking->booking_date . ' ' . $booking->booking_time
            );

            $newEnd = $newStart->copy()->addHours(2);

            // Mengambil penugasan aktif terapis pada tanggal yang sama
            $existingAssignments = BookingAssignment::with('booking')
                ->where('therapist_id', $therapist->id)
                ->whereIn('status', ['pending', 'accepted'])
                ->whereHas('booking', function ($query) use ($booking) {
                    $query->whereDate('booking_date', $booking->booking_date);
                })
                ->lockForUpdate()
                ->get();

            // Memeriksa apakah jadwal bertabrakan
            foreach ($existingAssignments as $assignment) {

                // Booking yang sedang ditugaskan tidak dihitung sebagai bentrok
                if ($assignment->booking_id == $booking->id) {
                    continue;
                }

                $existingStart = Carbon::parse(
                    $assignment->booking->booking_date . ' ' .
                        $assignment->booking->booking_time
                );

                $existingEnd = $existingStart->copy()->addHours(2);

                // Memeriksa tabrakan waktu
                if ($newStart->lt($existingEnd) && $existingStart->lt($newEnd)) {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'therapist_id' =>
                        'Terapis sudah memiliki jadwal pada waktu tersebut. Silakan pilih terapis lain atau jam berbeda.',
                    ]);
                }
            }

            // Menandai penugasan aktif sebelumnya sebagai digantikan
            BookingAssignment::where('booking_id', $booking->id)
                ->whereIn('status', ['pending', 'accepted'])
                ->update([
                    'status' => 'reassigned',
                    'updated_at' => now(),
                ]);

            // Membuat riwayat penugasan baru
            BookingAssignment::create([
                'booking_id' => $booking->id,
                'therapist_id' => $therapist->id,
                'status' => 'pending',
            ]);

            // Mempertahankan relasi therapist_id pada tabel bookings
            $booking->update([
                'therapist_id' => $therapist->id,
            ]);
        });

        return back()->with(
            'success',
            'Pekerjaan berhasil diberikan kepada terapis. Menunggu konfirmasi terapis.'
        );
    }
}
