<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AssignmentResponded implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public array $assignment)
    {
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('admin.assignments'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'assignment.responded';
    }

    public function broadcastWith(): array
    {
        return [
            'assignment' => $this->assignment,
        ];
    }
}
