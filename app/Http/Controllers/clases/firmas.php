<?php
namespace App\Http\Controllers\clases;

use Illuminate\Http\Request;

class firmas{

    public static function obtener_tipos_firma(Request $request){
       
        //se obtiene la lista de archivos
        $response = $request
        ->clienteWS
        ->request('get', 'obtenerTiposFirma',[
            "query" => [
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ]
        ]);
        $lista = json_decode($response->getBody(),true);
        return $lista;
    }


    public static function obtener_tipos_firma_exucsa(Request $request){
       
        //se obtiene la lista de archivos
        $response = $request
        ->clienteWS
        ->request('get', 'obtenerTiposFirma/con_excusa',[
            "query" => [
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ]
        ]);
        $lista = json_decode($response->getBody(),true);
        return $lista;
    }

}