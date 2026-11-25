<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BookingCreated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public array $booking
    ) {}

    /**
     * Channel tujuan event.
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('admin.bookings'),
        ];
    }

    /**
     * Nama event yang diterima Laravel Echo.
     */
    public function broadcastAs(): string
    {
        return 'booking.created';
    }

    /**
     * Data yang dikirim ke dashboard admin.
     */
    public function broadcastWith(): array
    {
        return [
            'booking' => $this->booking,
        ];
    }
}
