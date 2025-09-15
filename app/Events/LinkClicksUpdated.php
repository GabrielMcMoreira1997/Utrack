<?php

namespace App\Events;

use App\Models\Link;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class LinkClicksUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    // Você não precisa mais das propriedades públicas.
    // O broadcastWith() cuidará disso.

    public function __construct()
    {
        // Construtor pode ser vazio ou ter a lógica que você precisar.
    }

    public function broadcastOn()
    {
        return new Channel('links');
    }

    /**
     * Get the data to broadcast.
     *
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        $links = Link::select('short_code', 'clicks')->get();

        return [
            'labels' => $links->pluck('short_code')->toArray(),
            'data' => $links->pluck('clicks')->toArray(),
        ];
    }
}
