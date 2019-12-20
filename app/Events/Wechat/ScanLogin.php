<?php

namespace App\Events\Wechat;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ScanLogin implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function broadcastOn()
    {
        return new Channel('scan-login');
    }

    // public function broadcastWith()
    // {
    //     return [
    //         'data' => 'key'

    //     ];
    // }

    public function broadcastAs()
    {
        return 'wechat.scaned';
    }
}
