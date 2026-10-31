<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderPlaced implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public string $nomor,
        public string $kasir,
        public float $total
    ) {}

    public function broadcastOn(): array
    {
        return [
            new Channel('demo-orders'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'order.placed';
    }
}
