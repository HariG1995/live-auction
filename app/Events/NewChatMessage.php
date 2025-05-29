<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Models\ChatMessage;

class NewChatMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $chatMessage;

    public function __construct(ChatMessage $chatMessage)
    {
        $this->chatMessage = $chatMessage->load('sender');
    }

    public function broadcastOn()
    {
        // return [
        //     new PrivateChannel('chat.user.'.$this->chatMessage->sender_id),
        //     new PrivateChannel('chat.user.'.$this->chatMessage->receiver_id)
        // ];

        return new Channel('chat.'.$this->chatMessage->receiver_id);
    }

    public function broadcastWith()
    {
        return [
            'message' => $this->chatMessage,
            'sender' => $this->chatMessage->sender,
            'receiver_id' => $this->chatMessage->receiver_id
        ];
    }

    public function broadcastAs()
    {
        return 'new-message';
    }
}
