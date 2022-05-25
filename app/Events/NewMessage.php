<?php

namespace App\Events;

use App\Http\Controllers\clases\session;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Http\Request;

class NewMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $canales;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($message, $canales="")
    {
        $this->message = $message;
        $this->canales = $canales;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        $canales_chanel=array();

        //for($i=0; $i<1; $i++){
            $canales_chanel[]=new Channel('1371823772323');
            $canales_chanel[]=new Channel('1371823772324');
        //}
        return $canales_chanel;
    }
}
