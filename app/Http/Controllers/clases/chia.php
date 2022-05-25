<?php
namespace App\Http\Controllers\clases;

use Illuminate\Http\Request;
use Session;

class chia{
  
  public static function obtener_valores( Request $request, $cve_materia='', $folio='' ) {
      
    $datos = [
      "folio" => mb_strtoupper($request->folio, 'UTF-8'),
      "tipo_valor" => $request->tipo_valor,
      "fecha_expedicion" => $request->fecha_expedicion,
      "fecha_exhibicion" => $request->fecha_exhibicion,
      "expediente" => $request->expediente,
    ];
    
    if( $folio != '' )
      $datos = ["folio" => mb_strtoupper($folio, 'UTF-8')];

    $response = $request
      ->clienteWS_penal
      ->request('get', 'obtener_valores_chia/'.$cve_materia,[
          "headers" => [
              "sesion-id" => Session::get("sesion-id"),
              "cadena-sesion" => Session::get("cadena-sesion"),
              "usuario-id" => Session::get("usuario-id"),
              "Content-Type" => "application/json"
          ],
          "query" =>[
            "paginacion" => [
              "pagina" => $request->pagina,
              "registros_por_pagina" => $request->registros,
            ],
            "datos" => $datos
          ]
      ]);
     
    $valores = json_decode($response->getBody(),true) ;
      
    if( $valores['status'] == 100 ) {

      foreach ( $valores['response'] as  $key => $valor ) {

        foreach( $valor as $key_dato => $dato ) {

          if( $key_dato == 'Depositor' )
            $valores['response'][$key][$key_dato] = html_entity_decode( strtolower( $dato ) ) ;

        }
      }

    }

    return $valores;
  }
}