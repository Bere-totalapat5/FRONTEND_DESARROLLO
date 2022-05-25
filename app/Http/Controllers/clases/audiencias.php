<?php
namespace App\Http\Controllers\clases;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Http\Controllers\clases\entorno;

class audiencias{

  public static function obtener_audiencias(Request $request, $param){
    $filtro=[
      "id_audiencia"=> isset($param["id_audiencia"])?$param["id_audiencia"]:"-",
      "id_cj"=> isset($param["id_cj"])?$param["id_cj"]:"-",
      "id_unidad"=> isset($param["id_unidad"])?$param["id_unidad"]:"-",
      "id_inmueble"=> isset($param["id_inmueble"])?$param["id_inmueble"]:"-",
      "id_sala"=> isset($param["id_sala"])?$param["id_sala"]:"-",
      "id_juez"=> isset($param["id_juez"])?$param["id_juez"]:"-",
      "fecha_min"=> isset($param["fecha_min"])?$param["fecha_min"]:"-",
      "fecha_max"=> isset($param["fecha_max"])?$param["fecha_max"]:"-",
      "pagina"=>isset($param["pagina"])?$param["pagina"]:1,
      "registros_por_pagina"=>isset($param["registros_por_pagina"])?$request->registros_por_pagina:10,
    ];

    $response = $request
      ->clienteWS_penal
      ->request('GET', 'obtener_audiencias/',[
          "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
          ],
          "query" => [
            "datos"=>[
              "id_audiencia"=>$filtro["id_audiencia"],
              "id_cj"=>$filtro["id_cj"],
              "id_unidad"=>$filtro["id_unidad"],
              "id_inmueble"=>$filtro["id_inmueble"],
              "id_sala"=>$filtro["id_sala"],
              "id_juez"=>$filtro["id_juez"],
              "fecha_min"=>$filtro["fecha_min"],
              "fecha_max"=>$filtro["fecha_max"]
            ],
            "paginacion"=>[
              "pagina"=>$filtro["pagina"],
              "registros_por_pagina"=>$filtro["registros_por_pagina"]
            ]
          ],
      ]);
      
    return json_decode($response->getBody(),true);
  }

  public static function modificar_estatus_audiencia( Request $request, $id_usuario, $id_unidad, $id_audiencia, $estatus, $motivos, $bandera_adjuntar_documento = 0 , $param_doc = []){

    $response = $request
      ->clienteWS_penal
      ->request('PATCH', "modificacion_estatus_audiencia/$id_usuario/$id_unidad/$id_audiencia/$estatus/$bandera_adjuntar_documento",[
          "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
          ],
          "json" => [
            "datos" => [
              "comentarios_cancelacion" => strlen($motivos) ? $motivos : '-',
              "nombre_documento" => isset($param_doc["nombre"]) ? $param_doc["nombre"] : '-',
              "extension_documento" => isset($param_doc["extension"]) ? $param_doc["extension"] : '-',
              "tamanio_documento" => isset($param_doc["tamanio"]) ? $param_doc["tamanio"] : '-',
              "b64_documento" => isset($param_doc["b64"]) ? $param_doc["b64"] : '-',
            ]
          ]
      ]);
      
    return json_decode($response->getBody(),true);
  }

  public static function modificar_audiencia( Request $request, $id_usuario, $id_unidad, $id_audiencia, $audiencia){
    $response = $request
      ->clienteWS_penal
      ->request('PATCH', "modificacion_audiencia/$id_usuario/$id_unidad/$id_audiencia",[
          "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
          ],
          "json" => [
            "datos" => $audiencia,
          ]
      ]
    );

    return json_decode($response->getBody(), true);

  }

  public static function estatusRecurso_logic(Request $request, $id_recurso, $id_audiencia, $estatus){
    $response = $request
      ->clienteWS_penal
      ->request('POST', "estatusRecurso_logic",[
          "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
          ],
          "json" => [
            "datos" => [
              "id_recurso"=> $id_recurso,
              "id_audiencia"=> $id_audiencia,
              "estatus"=> $estatus
            ]
          ]
     ]
    );

    return json_decode($response->getBody(), true);
  }

  public static function creacion_audiencia_interfaz( Request $request,$id_usuario, $id_unidad, $id_carpeta, $audiencia ){
    $response = $request
      ->clienteWS_penal
      ->request('POST', "creacion_audiencia_interfaz/$id_usuario/$id_unidad/$id_carpeta",[
        "headers" => [
          "sesion-id" => $request->session()->get("sesion-id"),
          "cadena-sesion" => $request->session()->get("cadena-sesion"),
          "usuario-id" => $request->session()->get("usuario-id"),
          "Content-Type" => "application/json"
        ],
        "json" => [
          "datos" => $audiencia,
        ]
      ]
    );

    return json_decode($response->getBody(), true);
  }


  public static function actualizar_estatus_audiencia_ws( $body ) {
    
    if( !entorno::validacion() ) {
      return true;
  } else {
    $entorno_privado = entorno::obtener_valores_privados(); 
    $base_uri= $entorno_privado['ws_uri_backend']['uri_penal'];
  }

    $client= new Client;
    $response = $client
        ->request('post', $base_uri.'actualizarStatusAudiencia',[
            "headers" => [
                "Content-Type" => "text/xml; charset=UTF8"
            ],
            "body"=>$body
        ]);

    return $response->getBody();

  }

  public static function notificar_video_evento_audiencia_MAJO( $body ) {
    
    if( !entorno::validacion() ) {
      return true;
    } else {
      $entorno_privado = entorno::obtener_valores_privados(); 
      $base_uri= $entorno_privado['ws_uri_backend']['uri_penal'];
    }

    $client= new Client;
    $response = $client
        ->request('post', $base_uri.'notificar_video_audiencia_MAJO',[
            "headers" => [
                "Content-Type" => "text/xml; charset=UTF8"
            ],
            "body"=>$body
        ]);

    return $response->getBody();
    
  }

  public static function notificar_video_audiencia_ws( $body ) {
    
    if( !entorno::validacion() ) {
      return true;
    } else {
      $entorno_privado = entorno::obtener_valores_privados(); 
      $base_uri= $entorno_privado['ws_uri_backend']['uri_penal'];
    }

    $client= new Client;
    $response = $client
        ->request('post', $base_uri.'notificarInformacionAudiencia',[
            "headers" => [
                "Content-Type" => "text/xml; charset=UTF8"
            ],
            "body"=>$body
        ]);

    return $response->getBody();

  }

  public static function asociar_acta_minima_audiencia( Request $request, $id_audiencia, $id_documento ){
    
    $response = $request
      ->clienteWS_penal
      ->request('PATCH', "asociar_acta_minima_audiencia/$id_audiencia/$id_documento",[
          "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
          ],
      ]
    );

    return json_decode($response->getBody(), true);
  }
  
  public static function quitar_acta_minima_audiencia( Request $request, $id_audiencia ){
    
    $response = $request
      ->clienteWS_penal
      ->request('PATCH', "asociar_acta_minima_audiencia/$id_audiencia/0",[
          "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
          ],
      ]
    );

    return json_decode($response->getBody(), true);
  }

  public static function consultar_documento_cancelacion_audiencia( Request $request, $id_audiencia ){
    $response = $request
      ->clienteWS_penal
      ->request('GET', "obtener_documento_cancelacion_auciencia/$id_audiencia",[
          "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
          ],
      ]);
      
    $response = json_decode($response->getBody(),true);
    
    if( $response["status"] == 100){
      $nombre=explode('.',$response['nombre']);

      $extension=end($nombre);

      $nombre_doc = rand(0,999).'-'.$nombre[0].'-'.rand(999,1000000);

      $url_local= base_path().'/storage/pdf_solicitudes/'.$nombre_doc.'.'.$extension;

      $documento_pdf=$response['response'];

      copy($documento_pdf, $url_local);

      return [
        "status"=>100,
        "response"=>"/documento_solicitud/$nombre_doc.$extension",
        "ruta_local"=>$url_local,
        "extension"=>$extension,
        "nombre"=>$response['nombre'],
      ];
    }else return $response;

  }

}
