<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AssignmentCreated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public array $assignment) {}

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel(
                'worker.assignments.' . $this->assignment['therapist_id']
            ),
        ];
    }

    public function broadcastAs(): string
    {
        return 'assignment.created';
    }

    public function broadcastWith(): array
    {
        return [
            'assignment' => $this->assignment,
        ];
    }
}
