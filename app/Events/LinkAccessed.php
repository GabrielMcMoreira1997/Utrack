<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Carbon\Carbon;

class LinkAccessed implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $short_code;
    public $original_url;
    public $time;

    public function __construct($short_code, $original_url)
    {
        $this->short_code = $short_code;
        $this->original_url = $original_url;
        $this->time = Carbon::now()->format('H:i:s');
    }

    public function broadcastOn()
    {
        // Canal dedicado para o log de acessos
        return new Channel('links-log');
    }
}