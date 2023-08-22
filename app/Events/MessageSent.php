<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\Conversation;
use App\Models\Message;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $conversation;
    public $recevier;
    public $user;

    /**
     * Create a new event instance.
     */
    public function __construct(User $user,Message $message,conversation $conversation,User $recevier)
    {
       $this->user         = $user;
       $this->message      = $message;
       $this->conversation = $conversation;
       $this->recevier  = $recevier; 
    }

    public function broadcastWith()
    {
         return [
            'user_id'        =>$this->user->id,
            'message'        =>$this->message->id,
            'conversation_id'=>$this->conversation->id,
            'recevier_id'    =>$this->recevier->id
          ];

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {  
        error_log($this->user);
        error_log($this->recevier);
        return [
            new PrivateChannel('chat.'.$this->recevier->id),
        ];
    }
}
