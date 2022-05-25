<?php

namespace App\Http\Controllers\pruebas_websockets;

use App\Http\Controllers\Controller;
use App\Message;
use Illuminate\Http\Request;
use Session;
use App\Events\NuevoMensaje;

class WebsocketController extends Controller
{

  public function vista_websockets(Request $request){
      $elementos=["entorno"=>$request->entorno,
      "request"=>$request,
      "sesion"=>Session::all(),
      "menu_general"=>$request->menu_general
      ];

    return view('prueba_websocket.prueba_message', $elementos);
  }

  public function enviar_notificacion(Request $request){

    $users = $request->datos;

    $ids_users = explode(',',$users['ids_user']);
    $mensaje = $users['mensaje'];
    $clave = $users['clave'];
    $id = $users['id'];
    
    $array_users = [];

    foreach($ids_users as $user){
      array_push($array_users, array("id_user"=>$user, "mensaje"=>$mensaje, "clave"=>$clave, "id"=>$id));
    }

    foreach($array_users as $notification){
      $success = event(new NuevoMensaje($notification));
    }

    $response = $request
    ->clienteWS_penal
    ->request('POST', 'guardar_alerta_sockets',[
        "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
        ],
        "json"=>[
          "notificacion"=>$array_users
        ]
    ]);

    //return $array_users;
    
    return $success;
  }

}