<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SubEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct($app_id, $device_id, $event)
    {
        $this->app_id = $app_id;
        $this->device_id = $device_id;
        $this->event = $event;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
