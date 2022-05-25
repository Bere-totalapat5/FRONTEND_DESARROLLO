<?php
namespace App\Http\Controllers\clases;

use Illuminate\Http\Request;

class configuracion{

    public static function obtener_permisos_menu(Request $request, $usuario_id){

        $response = $request
        ->clienteWS_penal
        ->request('get', 'obtener_menus_permisos/'.$usuario_id,[
            "query" => [
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id")
            ]
        ]);
        
        $response = json_decode($response->getBody(),true) ;
        return $response;
    }

    public static function generar_permisos_menu(Request $request, $usuario_id){

        $response = $request
        ->clienteWS_penal
        ->request('post', 'generar_permisos/'.$usuario_id,[
            "form_params" => [
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id")
            ]
        ]);
        
        $response = json_decode($response->getBody(),true) ;
        return $response;
    }

    public static function gestionar_permisos_menu(Request $request, $datos){

        $response = $request
        ->clienteWS
        ->request('patch', 'gestionarPermisos',[
            "json" => [
                "datos" => $datos
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id")
            ]
        ]);
        
        $response = json_decode($response->getBody(),true) ;
        return $response;
    }


    public static function modificar_acciones(Request $request, $datos){

        $response = $request
        ->clienteWS
        ->request('patch', 'modificar_acciones',[
            "json" => [
                "datos" => $datos
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id")
            ]
        ]);
        
        $response = json_decode($response->getBody(),true) ;
        return $response;
    }

    public static function obtener_permisos_ventana(Request $request, $id_usuario, $id_vista ){
        $response = $request
        ->clienteWS_penal
        ->request('get', "obtener_acciones_vista/$id_usuario/$id_vista",[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ]

        ]);

        return json_decode($response->getBody(),true);
    }


}