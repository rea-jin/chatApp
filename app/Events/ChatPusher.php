<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatPusher implements ShouldBroadcast // 追加
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message; // 追加

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($message) 
    {
        //ShouldBroadcastインターフェースを継承し、Pusherに渡す情報を public $message で設定しています
        $this->message = $message; // 追加8-5
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // return new PrivateChannel('channel-name');
        return new Channel('ChatRoomChannel');
    }
}
