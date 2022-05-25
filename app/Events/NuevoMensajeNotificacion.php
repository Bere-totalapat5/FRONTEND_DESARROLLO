<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Mail\Message;

class NuevoMensajeNotificacion implements ShouldBroadcastNow
{
    use SerializesModels;

    public $message;

    public function __construct(Message $message){
        $this->message = $message;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('User: '. $this->message->user);
    }
    
}