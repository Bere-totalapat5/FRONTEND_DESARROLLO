<?php
namespace App\Http\Controllers\clases;

use Illuminate\Http\Request;
use App;

class documentos_asociados{

  public static function obtener_documentos($request, $param){
    $filtro = [
      "carpeta" => isset($param["carpeta"]) ? $param["carpeta"] : '-',
      "tipo_documento" => isset($param["tipo_documento"]) ? $param["tipo_documento"] : '-',
      "nombre_documento" => isset($param["nombre_documento"]) ? $param["nombre_documento"] : '-',
      "extension_documento" => isset($param["extension_documento"]) ? $param["extension_documento"] : '-',
      "origen_documento" => isset($param["origen_documento"]) ? $param["origen_documento"] : '-',
      "pagina" => isset($param["pagina"]) ? $param["pagina"] : '-',
      "registros_por_pagina" => isset($param["registros_por_pagina"]) ? $param["registros_por_pagina"] : 10,
    ];
    //dd($filtro, $param);
    $response = $request
    ->clienteWS_penal
    ->request('GET', 'consultar_documentos_carpeta/'.$request->session()->get("usuario-id").'/'.$filtro["carpeta"],[
      "headers" => [
        "sesion-id" => $request->session()->get("sesion-id"),
        "cadena-sesion" => $request->session()->get("cadena-sesion"),
        "usuario-id" => $request->session()->get("usuario-id"),
        "Content-Type" => "application/json"
      ],
      "json" => [
        "datos" => [
          "tipo_documento" => $filtro["tipo_documento"],
          "nombre_documento" => $filtro["nombre_documento"],
          "extension_documento" => $filtro["extension_documento"],
          "origen_documento" => $filtro["origen_documento"],
        ],
        "paginacion" => [
          "pagina"=> $filtro["pagina"],
          "registros_por_pagina"=> $filtro["registros_por_pagina"],
        ],
      ]
    ]);
    return json_decode($response->getBody(),true);
  }

  public static function actualizar_documento( $request , $documento ){
    $response = $request
    ->clienteWS_penal
    ->request('POST', 'documento_carpeta_judicial/'.$request->session()->get("usuario-id").'/'.$documento["carpeta"].'/'.$documento['id_documento'],[
        "headers" => [
          "sesion-id" => $request->session()->get("sesion-id"),
          "cadena-sesion" => $request->session()->get("cadena-sesion"),
          "usuario-id" => $request->session()->get("usuario-id"),
          "Content-Type" => "application/json"
        ],
        "json"=>[
          "datos"=>[
            "tipo_documento"=>isset($documento['id_tipo_archivo']) ? $documento['id_tipo_archivo'] : '-',
            "nombre"=>isset($documento['nombre_archivo']) ? $documento['nombre_archivo'] : '-',
            "extension"=>isset($documento['extension_archivo']) ? $documento['extension_archivo'] : '-',
            "tamanio"=>isset($documento['tamanio_archivo']) ? $documento['tamanio_archivo'] : '-',
            "estatus"=>isset($documento['estatus']) ? $documento['estatus'] : '-',
            "b64_doc"=>isset($documento['b64']) ? $documento['b64'] : '-',
            "motivos"=>isset($documento['motivos']) ? $documento['motivos'] : '-' ,
          ]
        ]
    ]);

    return $response = json_decode($response->getBody(),true);
  }
}