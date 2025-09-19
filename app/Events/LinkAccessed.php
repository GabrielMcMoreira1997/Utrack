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
use App\Models\Link;

class LinkAccessed implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $data;

    public function __construct(Link $link, $location, $device, $agent)
    {
        $this->data = [
            'short_code' => $link->short_code,
            'original_url' => $link->original_url,
            'time' => now()->format('H:i:s'),
            'city' => $location->cityName ?? null,
            'region' => $location->regionName ?? null,
            'country' => $location->countryName ?? null,
            'device' => $device,
            'os' => $agent->platform(),
            'os_version' => $agent->version($agent->platform()),
            'browser' => $agent->browser(),
            'browser_version' => $agent->version($agent->browser()),
            'ip' => request()->ip(),
            'referrer' => request()->server('HTTP_REFERER'),
        ];
    }

    public function broadcastOn()
    {
        return new Channel('links-log');
    }

    public function broadcastWith(): array
    {
        return [
            'data' => $this->data
        ];
    }
}
