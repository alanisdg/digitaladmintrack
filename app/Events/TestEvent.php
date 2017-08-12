<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TestEvent
{
    use InteractsWithSockets, SerializesModels;

    public $time;

    public function __construct()
    {
        // $this->$time = microtime()
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return ['service'];
    }

    public function broadcastWith(){
        return[
            'time' => microtime(),
            'version' => 0.1
        ];
    }

    public function broadcastAd(){
        return 'microtime';
    }
}
