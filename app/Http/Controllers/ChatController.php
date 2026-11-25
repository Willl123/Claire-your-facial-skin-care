<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingAssignment;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Events\ChatMessageSent;

class ChatController extends Controller
{
    // Membuka atau membuat ruang chat
    public function open($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        $user = Auth::user();

        // Cari penugasan yang sudah disetujui Admin
        $assignment = BookingAssignment::where('booking_id', $booking->id)
            ->where('status', 'accepted')
            ->where('admin_status', 'approved')
            ->latest('id')
            ->firstOrFail();

        // Hanya Customer pemilik booking dan Worker yang ditugaskan
        if (
            $user->id !== $booking->user_id &&
            $user->id !== $assignment->therapist_id
        ) {
            abort(403, 'Kamu tidak memiliki akses ke chat ini.');
        }

        // Chat hanya boleh dibuka setelah booking disetujui
        if (!in_array($booking->status, ['approved', 'completed'])) {
            abort(403, 'Chat belum dapat digunakan.');
        }

        // Buat ruang chat jika belum tersedia
        $chat = Chat::firstOrCreate(
            [
                'booking_assignment_id' => $assignment->id,
            ],
            [
                'booking_id' => $booking->id,
                'customer_id' => $booking->user_id,
                'therapist_id' => $assignment->therapist_id,
            ]
        );

        // Periksa masa aktif chat
        if (
            $chat->expires_at &&
            now()->greaterThanOrEqualTo($chat->expires_at)
        ) {
            abort(403, 'Masa aktif chat sudah berakhir.');
        }

        $chat->load([
            'customer:id,name',
            'therapist:id,name',
        ]);

        return view('chat-show', compact('chat'));
    }

    // Mengambil pesan chat
    public function messages(Chat $chat)
    {
        $this->checkParticipant($chat);

        if (
            $chat->expires_at &&
            now()->greaterThanOrEqualTo($chat->expires_at)
        ) {
            abort(403, 'Masa aktif chat sudah berakhir.');
        }

        $messages = $chat->messages()
            ->with('sender:id,name')
            ->oldest()
            ->get();

        return response()->json($messages);
    }

    // Mengirim pesan
    public function send(Request $request, Chat $chat)
    {
        $this->checkParticipant($chat);

        if (
            $chat->expires_at &&
            now()->greaterThanOrEqualTo($chat->expires_at)
        ) {
            abort(403, 'Masa aktif chat sudah berakhir.');
        }

        $validated = $request->validate([
            'message' => 'required|string|max:5000',
        ]);

        $message = $chat->messages()->create([
            'sender_id' => Auth::id(),
            'message' => $validated['message'],
        ]);

        $message->load('sender:id,name');

        // Kirim pesan ke Customer dan Worker secara real-time
        broadcast(new ChatMessageSent($message))->toOthers();

        return response()->json([
            'success' => true,
            'message' => $message,
        ], 201);
    }

    // Memastikan pengguna merupakan Customer atau Worker terkait
    private function checkParticipant(Chat $chat): void
    {
        if (
            Auth::id() !== $chat->customer_id &&
            Auth::id() !== $chat->therapist_id
        ) {
            abort(403, 'Kamu tidak memiliki akses ke chat ini.');
        }
    }
}
