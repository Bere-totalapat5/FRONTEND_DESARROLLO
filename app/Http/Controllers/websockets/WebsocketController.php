<?php

namespace App\Http\Controllers\websockets;

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

    if(isset($users['ids_user']) && $users['ids_user'] == '-') return ['status'=>0, 'message'=>'Debe indicar al menos un id de usuario'];
    if(isset($users['clave']) && $users['clave'] == '-') return ['status'=>0, 'message'=>'Es necesario indicar el tipo de notificacion [carpeta o tarea]'];
    if($users['clave'] == 'carpeta'){
      if(isset($users['id']) && $users['id'] == '-') return ['status'=>0, 'message'=>'Debe indicar el id de la carpeta'];
    }else{
      if(isset($users['id']) && $users['id'] == '-') return ['status'=>0, 'message'=>'Debe indicar el id de la tarea'];
    }
    
    $ids_users = explode(',',$users['ids_user']);
    $mensaje = $users['mensaje'];
    $clave = $users['clave'];
    $identificador = $users['identificador'] != '-' ? $users['identificador']: null;
    $id = $users['id'];
    
    $array_users = [];

    foreach($ids_users as $user){
      array_push($array_users, array("id_user"=>$user, "mensaje"=>$mensaje, "clave"=>$clave, "identificador"=>$identificador, "id"=>$id));
    }
  
    foreach($array_users as $notification){
      //dd(new NuevoMensaje($notification));
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
    
    return ['status'=>100, 'response'=>'Mensaje Enviado'];
  }

  public function obtener_alertas(Request $request){
    $response = $request
    ->clienteWS_penal
    ->request('POST', 'obtener_alertas',[
        "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
        ],
        "json"=>[
          "datos"=>[
            "id_usuario"=>$request->id_usuario
          ]
        ]
    ]);
    $response = json_decode($response->getBody(),true) ;
    return $response;
  }

  public function actualizar_visto(Request $request){
    $response = $request
    ->clienteWS_penal
    ->request('POST', 'actualizar_visto',[
        "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
        ],
        "json"=>[
          "datos"=>[
            "id_notificacion"=>$request->id_notificacion
          ]
        ]
    ]);
    $response = json_decode($response->getBody(),true) ;
    return $response;
  }

}