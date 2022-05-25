<?php
namespace App\Http\Controllers\clases;

use Illuminate\Http\Request;
 
class estadisticas{

    public static function deman_prom_estadisticas(Request $request, $datos ){
       
        $response = $request
        ->clienteWS
        ->request('get', 'deman_prom_estadisticas/',[
            "query" => [
                "datos" => [
                    "modo" => $datos['modo'],
                    "fecha_desde" => $datos['fecha_desde'],
                    "fecha_hasta"=> $datos['fecha_hasta'],
                    "origen"=> $datos['origen'],
                    "juzgado"=> $datos['juzgado'],
                ]
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ]
        ]);
        $lista = json_decode($response->getBody(),true) ;
        return $lista;
    }
}