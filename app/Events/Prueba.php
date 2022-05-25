<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Prueba implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data;

    public function __construct($data){
        $this->data = $data;
    }

    public function broadcastOn()
    {
        return ['chanel-charly'];
    }
    
    public function broadcastAs()
    {
        return 'user-event';
    }

    /*
        public $user;
        public $message;


         * Create a new event instance.
         *
         * @return void

        public function __construct($user, $message)
        {
            $this->user = $user;
            $this->message = $message;
        }

        public function broadcastWith()
        {
            echo 'hola Ivan';
            // This must always be an array. Since it will be parsed with json_encode()
            return [
                'user' => 'Nombre de algo: ' . $this->user,
                'message' => 'este es el menaje' . $this->message,
            ];
        }


        Get the channels the event should broadcast on.
     
        @return \Illuminate\Broadcasting\Channel|array
     
        public function broadcastOn()
        {

            //return new Channel('pruebas_lokas');
            //return ['pruebas_lokas'];
            //return new Channel('home');
            return new Channel('messages');
        }
    */
}