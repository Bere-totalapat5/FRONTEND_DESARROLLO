<?php
namespace App\Http\Controllers\clases;

use Illuminate\Http\Request;

class anales{

    public static function calcular_dias(Request $request, $datos){

        $response = $request
        ->clienteWS
        ->request('get', 'calcular_dias',[
            "query" => [
                "datos" => [
                    "fecha"=>$datos['fecha'],
                    "num_dias"=>$datos['num_dias'],
                    "atras"=>$datos['atras']
                ]
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

    public static function obtenerTiposJuzgado(Request $request, $tipo=''){

        $response = $request
        ->clienteWS
        ->request('get', 'obtenerTiposJuzgado/'.$tipo,[
            "query" => [
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json",
                "autorizacion" => "minutmanQAEtHReI"
            ]
        ]);
        
        $response = json_decode($response->getBody(),true) ;
        //dd($response);
        return $response;
    }

    public static function obtenerJuzgadoTipo(Request $request, $subtipo){

        $response = $request
        ->clienteWS
        ->request('get', 'obtenerJuzgadoTipo/'.$subtipo,[
            "query" => [
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json",
                "autorizacion" => "minutmanQAEtHReI"
            ]
        ]);
        
        $response = json_decode($response->getBody(),true) ;
        return $response;
    }

    /*
    *   BOLETIN
    */
    public static function calculo_numero_boletin(Request $request, $datos){

        $response = $request
        ->clienteWS
        ->request('get', 'calculo_numero_boletin',[
            "query" => [
                "datos" => [
                    "fecha"=>$datos['fecha'],
                    "reporte"=>$datos['reporte']
                ]
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

    public static function alta_registro_boletin(Request $request, $datos){

        $response = $request
        ->clienteWS
        ->request('POST', 'alta_registro_boletin',[
            "json" => [
                "datos" => [
                    "numero"=>$datos['numero'],
                    "fecha_publicacion"=>$datos['fecha_publicacion']
                ]
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

    public static function obtener_registro_boletin(Request $request, $datos){

        $response = $request
        ->clienteWS
        ->request('GET', 'obtener_registro_boletin',[
            "query" => [
                "datos" => [
                    "numero"=>$datos['numero'],
                    "fecha_publicacion"=>$datos['fecha_publicacion'],
                    "rel_organo"=>$datos['rel_organo'],
                    "rel_materia"=>$datos['rel_materia'],
                    "bandera_temporales"=>$datos['bandera_temporales']
                ]
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

    public static function obtener_registro_boletin_temporal(Request $request, $datos){

        $response = $request
        ->clienteWS
        ->request('GET', 'obtener_registro_boletin_temporal',[
            "query" => [
                "datos" => [
                    "id_boletin_registro"=>$datos['id_boletin_registro'],
                    "codigo_organo"=>$datos['codigo_organo']
                ]
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

    public static function alta_registro_boletin_temporal(Request $request, $datos){

        $response = $request
        ->clienteWS
        ->request('POST', 'alta_registro_boletin_temporal',[
            "json" => [
                "datos" => [
                    "id_boletin_registro"=>$datos['id_boletin_registro'],
                    "codigo_organo"=>$datos['codigo_organo'],
                    "texto"=>$datos['texto']
                ]
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

    public static function modificar_registro_boletin_temporal(Request $request, $datos){

        $response = $request
        ->clienteWS
        ->request('PATCH', 'modificar_registro_boletin_temporal',[
            "json" => [
                "datos" => [
                    "id_boletin_registro"=>$datos['id_boletin_registro'],
                    "codigo_organo"=>$datos['codigo_organo'],
                    "boletin_temporal_texto"=>$datos['boletin_temporal_texto']
                ]
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

}