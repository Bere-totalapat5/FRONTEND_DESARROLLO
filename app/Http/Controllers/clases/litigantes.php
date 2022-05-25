<?php
namespace App\Http\Controllers\clases;

use Illuminate\Http\Request;

class litigantes{

    public static function validarLitigante(Request $request, $correo){

        $response = $request
        ->clienteWS
        ->request('GET', 'validacionLitigante/'.$correo,[
            "query" => [

            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id")
            ]
        ]);
        
        $response = json_decode($response->getBody(),true);
        return $response;
    }


    public static function agregar_notificacion_enviada(Request $request, $datos){

        $response = $request
        ->clienteWS
        ->request('POST', 'agregar_notificacion_enviada',[
            "json" => [
                "datos" => [
                    "id_juicio" =>$datos['id_juicio'],
                    "codigo_organo" => $request->session()->get("usuario_juzgado"),
                    "id_acuerdo" => $datos['id_acuerdo'],
                    "id_parte"=> $datos['id_parte']
                ]
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ]
        ]);
        
        $response = json_decode($response->getBody(),true);
        return $response;
    }


    public static function obtener_notificaciones_fisicas(Request $request, $bandeja=""){

        $response = $request
        ->clienteWS
        ->request('GET', 'obtener_notificaciones_fisicas/'.$bandeja,[
            "query" => [
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ]
        ]);
        
        $response = json_decode($response->getBody(),true);
        return $response;
    }

}