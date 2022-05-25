<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NuevoMensaje implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user)
    {   
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {   
        return ['user_'.$this->user['id_user']];
        //return new PrivateChannel('user'.$this->user['id_user']);
        //return new PresenceChannel('user.'.$this->user['id_user']);
    }

    public function broadcastAs()
    {
        return 'user-event';
    }

    public function broadcastWith()
    {
        return ['mensaje'=> $this->user['mensaje'], 'clave'=> $this->user['clave'],'identificador'=>$this->user['identificador'], 'id'=>$this->user['id'], 'id_user'=>$this->user['id_user']];
    }
}
