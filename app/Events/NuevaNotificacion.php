<?php

namespace App\Events;

use BeyondCode\LaravelWebSockets\WebSockets\Channels\PrivateChannel as ChannelsPrivateChannel;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NuevaNotificacion implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data;

    public function __construct($data){
        $this->data = $data;
    }

    public function broadcastOn()
    {
        return new Channel('canal.'.$this->data->id_user);
    }
    
    public function broadcastAs()
    {
        return 'event-pusher';
    }

}