<?php
namespace App\Http\Controllers\clases;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class incidencias{

  public static function obtener_incidencias_sala(Request $request, $param){

    $response = $request
      ->clienteWS_penal
      ->request('POST', 'consulta_incidencia_sala',[
          "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
          ],
          "query" => [
            "datos"=>[
              "fecha_desde"=> isset($param["fecha_desde"])?$param["fecha_desde"]:"-",
              "fecha_hasta"=> isset($param["fecha_hasta"])?$param["fecha_hasta"]:"-",
              "tipo"=> isset($param["tipo"])?$param["tipo"]:"-",
              "id_sala"=> isset($param["id_sala"])?$param["id_sala"]:"-",
              "etapa"=> isset($param["etapa"])?$param["etapa"]:"-",
            ],
            "paginacion"=>[
              "pagina"=>isset($param["pagina"])?$param["pagina"]:1,
              "registros_por_pagina"=>isset($param["registros_por_pagina"])?$param["registros_por_pagina"]:10
            ]
          ],
      ]);
      
    return json_decode($response->getBody(),true);
  }

}
