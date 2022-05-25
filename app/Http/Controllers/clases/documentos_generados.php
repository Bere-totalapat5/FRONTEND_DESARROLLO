<?php
namespace App\Http\Controllers\clases;

use Illuminate\Http\Request;
use App;

class documentos_generados{

  public static function obtener_documentos(Request $request, $param){
    $filtro = [
      "id_documento" => isset($param["id_documento"])?$param["id_documento"]:'-',
      "id_tipo_documento" => isset($param["id_tipo_documento"])?$param["id_tipo_documento"]:'-',
      "nombre_archivo" => isset($param["nombre_archivo"])?$param["nombre_archivo"]:'-',
      "estatus" => isset($param["estatus"])?$param["estatus"]:'-',
      "id_carpeta_judicial" => isset($param["id_carpeta_judicial"])?$param["id_carpeta_judicial"]:'-',
      "pagina"=>isset( $param["pagina"] )?$param["pagina"]:null, 
      "registros_por_pagina"=>isset( $param["registros_por_pagina"] )?$param["registros_por_pagina"]:null, 
      "unidad_gestion" => isset($param["unidad_gestion"]) ? $param["unidad_gestion"] : '-',
      "carpeta_judicial" => isset($param["carpeta_judicial"]) ? $param["carpeta_judicial"] : '-',
      "estatus_proceso" => isset($param["estatus_proceso"]) ? $param["estatus_proceso"] : '-',
      "bandera_ws_usmeca" => isset($param["bandera_ws_usmeca"]) ? $param["bandera_ws_usmeca"] : '-',
      "estatus_respuesta_usmc" => isset($param["estatus_respuesta_usmc"]) ? $param["estatus_respuesta_usmc"] : '-',
      "folio_usmc" => isset($param["folio_usmc"]) ? $param["folio_usmc"] : '-',
      "fecha_desde" => isset($param["fecha_desde"]) ? $param["fecha_desde"] : '-',
      "fecha_hasta" => isset($param["fecha_hasta"]) ? $param["fecha_hasta"] : '-',
    ];
    
    $response = $request
    ->clienteWS_penal
    ->request('GET', 'obtener_oficios/',[ 
        "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
        ],
        "query"=>[
            "datos"=>[
              "id_documento" => $filtro["id_documento"],
              "id_tipo_documento" => $filtro["id_tipo_documento"],
              "nombre_archivo" => $filtro["nombre_archivo"],
              "estatus" => $filtro["estatus"],
              "id_carpeta_judicial" => $filtro["id_carpeta_judicial"],
              "unidad_gestion" => $filtro["unidad_gestion"],
              "carpeta_judicial" => $filtro["carpeta_judicial"],
              "estatus_proceso" => $filtro["estatus_proceso"],
              "bandera_ws_usmeca" => $filtro["bandera_ws_usmeca"],
              "estatus_respuesta_usmc" => $filtro["estatus_respuesta_usmc"],
              "folio_usmc" => $filtro["folio_usmc"],
              "fecha_desde" => $filtro["fecha_desde"],
              "fecha_hasta" => $filtro["fecha_hasta"],
              
            ],
            "paginacion"=>[
              "pagina" => $filtro["pagina"],
              "registros_por_pagina" => $filtro["registros_por_pagina"],
            ]
        ]
    ]); 
    
    return json_decode($response->getBody(),true);
  }

  public static function guardar_documento(Request $request, $documento){
    
    $response = $request
    ->clienteWS_penal
    ->request('POST', 'documento_carpeta_judicial/'.$request->session()->get("usuario-id").'/'.$documento["carpeta"],[
        "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
        ],
        "json"=>[
            "datos"=>[
                "tipo_documento"=>$documento['id_tipo_archivo'],
                "id_tipo_documento_plantilla"=> isset($documento['id_tipo_plantilla'])?$documento['id_tipo_plantilla']:null,
                "nombre"=>$documento['nombre_archivo'],
                "extension"=>$documento['extension_archivo'],
                "tamanio"=>$documento['tamanio_archivo'],
                "estatus"=>$documento['estatus'],
                "b64_doc"=>$documento['b64'],
                "motivos"=>isset($documento['motivos']) ? $documento['motivos'] : '-' ,
                "oficio"=>isset($documento['oficio']) ? $documento['oficio'] : null ,
                "bandera_consumir_ws_usmeca"=>isset($documento['bandera_consumir_ws_usmeca']) ? $documento['bandera_consumir_ws_usmeca'] : null ,
                "request_usmeca"=>isset($documento['request_usmeca']) ? $documento['request_usmeca'] : null ,
                "anexos"=>isset($documento['anexos']) ? $documento['anexos'] : null ,
            ]
        ]
    ]); 
    
    return json_decode($response->getBody(),true);
  }

  public static function actualizar_documento(Request $request, $documento){
    //dd($documento);
    $response = $request
    ->clienteWS_penal
    ->request('POST', 'actualizar_oficio/'.$request->session()->get("usuario-id").'/'.$documento["carpeta"].'/'.$documento["id_documento"],[
      "headers" => [
        "sesion-id" => $request->session()->get("sesion-id"),
        "cadena-sesion" => $request->session()->get("cadena-sesion"),
        "usuario-id" => $request->session()->get("usuario-id"),
        "Content-Type" => "application/json"
      ],
      "json"=>[
        "datos"=>[
          "nombre"=>isset($documento['nombre']) ? $documento['nombre'] : '-',
          "extension"=>isset($documento['extension']) ? $documento['extension'] : '-',
          "tamanio"=>isset($documento['tamanio']) ? $documento['tamanio'] : '-',
          "b64_doc"=>isset($documento['b64_doc']) ? $documento['b64_doc'] : '-',
          "b64_pdf"=>isset($documento['b64_pdf']) ? $documento['b64_pdf'] : '-',
          "request_usmeca"=>isset($documento['request_usmeca']) ? $documento['request_usmeca'] : '-',
          "estatus"=>isset($documento['estatus'])?$documento['estatus']:1,
        ]
      ]
    ]); 
    
    return json_decode($response->getBody(),true);
  }

  public static function flujo_documento(Request $request, $param, $tipo='avance'){
    
    $response = $request
    ->clienteWS_penal
    ->request('POST', 'avance_documento/'.$request->session()->get("usuario-id").'/'.$param['id_unidad_gestion'].'/'.$param["id_documento"].'/'.$param["id_carpeta_judicial"].'/'.$tipo,[
        "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
        ],
        "json"=>[ 
            "datos"=>[
                "tipo_avance"=>$param['tipo_avance'],
                "id_usuario_destino"=>$param['id_usuario_destino'],
                "tamanio_archivo"=>$param['tamanio_archivo'],
                "extension_archivo"=>$param['extension_archivo'],
                "b64_archivo"=>$param['b64_archivo'],
                "b64_pdf"=>$param['b64_pdf'],
                "request_usmeca"=>isset($param['request_usmeca']) ? $param['request_usmeca'] : null,
                "anexos"=>isset($param['anexos']) ? $param['anexos'] : null,
            ],
            "datos_sesion"=>[
                "usuario_nombre" =>$request->session()->get('usuario'),
            ]
        ]
    ]);

    return json_decode($response->getBody(),true);
  }
 
  public static function html_to_pdf($html){
    $pdf = App::make('dompdf.wrapper');
    $pdf->loadHTML( $html );
    return $pdf->output();
  }

  public static function save_html_to_pdf($html,$url_local){
    $pdf = App::make('dompdf.wrapper');
    $pdf->loadHTML( $html );
    $pdf->save($url_local);
    if(file_exists($url_local)) return true;
    return false;
  }

  public static function docx_to_pdf($path_docx,$url_local){
    // ° doc_para_coser.py3 -> doc_para_coser_V7.py3
    $datos['exec']='sudo -u www-data HOME=/var/www /usr/bin/python3 "'.base_path().'/scripts/firmas/doc_para_coser.py3" '.$path_docx.' "'.$url_local.'"';
    $datos['return'] = exec('sudo -u www-data HOME=/var/www /usr/bin/python3 "'.base_path().'/scripts/firmas/doc_para_coser.py3" '.$path_docx.' "'.$url_local.'"');

    $datos_arr=explode(' ', $datos['return']);
    dd($datos, $datos_arr);

    return $datos;
  }

  public static function firmar_documento_firma_judicial($request, $url_documento_pdf, $url_certificado, $url_key, $password){

    $name_file = basename($url_documento_pdf);
    $b64_pdf=  base64_encode( file_get_contents($url_documento_pdf) );
    $pfx=  base64_encode( file_get_contents($url_certificado) );
    $b64_cer= base64_encode( file_get_contents($url_certificado) );
    $tipo_cer=1;
    $b64_key='';
    $arr_json=null;

    if($url_key!=''){
        $b64_key= base64_encode( file_get_contents($url_key));
        $tipo_cer=2;
    }

    try{

        $firma_arr = array("archivoOriginal"=>$b64_pdf
            ,"nombreArchivo"=> $name_file
            ,"tipo" =>$tipo_cer
            ,"pfx"=> $pfx
            ,"certificado"=> $b64_cer
            ,"llavePrivada"=> $b64_key
            ,"contrasena"=>$password
            ,"referencia"=>'vacio'
        );

        if($request->entorno["variables_entorno"]["MIFIRMA_PRODUCCION"]==1){
            $url_mifirma=$request->entorno["variables_entorno"]["MIFIRMA_PROD_URL"];
        }
        else{
            $url_mifirma=$request->entorno["variables_entorno"]["MIFIRMA_DESA_URL"];
        }

        $client = new \nusoap_client($url_mifirma, true);
        $client->soap_defencoding = 'UTF-8';
        $client->decode_utf8 = TRUE;
        $client->response_timeout = 180;

        $wsr = $client->call("firmaPFX", $firma_arr);
    }
    catch (\Exception $e) {
        $arr_json['wsr']=$wsr;
        $arr_json['estatus']=0;
        $arr_json['resultado']=0;
        $arr_json['msj']="Error - Servicio Mi Firma no disponible";
        return $arr_json;
    }

    if($wsr['firmaPFXResult']['estado']==0){
        $arr_json['resultado']=1;
        $arr_json['documento']=$wsr['firmaPFXResult']['pdfEvidencia'];
    }else{
        //$arr_json['wsr']=$wsr;
        $arr_json['estatus']=0;
        $arr_json['resultado']=0;
        $arr_json['msj']=utf8_encode("Error - Servicio Mi Firma => [ ".$wsr['firmaPFXResult']['estado']." : ".$wsr['firmaPFXResult']['descripcion']." ]");
    }

    return $arr_json;
  }

  public static function obtener_leyenda( Request $request,$anio ){
    $response = $request
    ->clienteWS_penal
    ->request('POST', 'ver_leyenda_doc',[
        "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
        ],
        "json"=>[
            "datos"=>[
                "anio"=>$anio,
            ]
        ]
    ]);
    return json_decode($response->getBody(),true) ;
  }

  public static function obtener_usuarios( Request $request, $param ){
    $filtro = [
      "id_tipo_usuario"=>isset($param["id_tipo_usuario"])?$param["id_tipo_usuario"]:null,
      "id_unidad_gestion"=>isset($param["id_unidad_gestion"])?$param["id_unidad_gestion"]:null,
      "usuario"=>isset($param["usuario"])?$param["usuario"]:null,
      "registros_por_pagina"=>isset($param["registros_por_pagina"])?$param["registros_por_pagina"]:10,
      "pagina"=>isset($param["pagina"])?$param["pagina"]:1,
    ];

    try {
      $response = $request
      ->clienteWS_penal
      ->request('POST', 'consulta_usuarios',[
        "headers" => [
        "sesion-id" => $request->session()->get("sesion-id"),
        "cadena-sesion" => $request->session()->get("cadena-sesion"),
        "usuario-id" => $request->session()->get("usuario-id"),
        "Content-Type" => "application/json"
      ],
        "json"=>[
            "datos"=>[
              "id_tipo_usuario"=>$filtro["id_tipo_usuario"],
              "id_unidad_gestion"=>$filtro["id_unidad_gestion"],
              "usuario"=>$filtro["usuario"]
            ], 
            "paginacion"=>[
              "registros_por_pagina"=>$filtro["registros_por_pagina"],
              "pagina"=>$filtro["pagina"]
            ]
        ]
      ]);
      return json_decode($response->getBody(),true);
    } catch (\Exception $e) {
      return response()->json(['status' => 0, 'data' => $e->getMessage()]);
    }
    
  }

  public static function obtener_ultima_version( Request $request, $id_carpeta_judicial, $id_documento, $modo = "pdf" ){
    $response = $request
    ->clienteWS_penal
    ->request('GET', 'obtener_ultima_version_oficio/'.$request->session()->get("usuario-id").'/'.$id_carpeta_judicial.'/'.$id_documento.'/'.$modo,[
        "headers" => [
          "sesion-id" => $request->session()->get("sesion-id"),
          "cadena-sesion" => $request->session()->get("cadena-sesion"),
          "usuario-id" => $request->session()->get("usuario-id"),
          "Content-Type" => "application/json"
        ],
        "json" => [
          "datos" => [],
        ]
    ]);
    $response = json_decode($response->getBody(),true);

    if($response['status']==100){

      $url=$response['response'];

      $expl=explode('.',$url);
      $explode=explode('/',$expl[0]);

      $nombre_doc=end($explode).rand();
      $extension=end($expl);

      //  $url_local='/var/www/html/sigj_penal/storage/acuerdos/'.$nombre_doc.'.'.$extension;
      $url_local= base_path().'/storage/acuerdos/'.$nombre_doc.'.'.$extension;

      copy($url, $url_local);

      $respuesta=[
        "status"=>100,
        "response"=>"/acuerdos/$nombre_doc.$extension",
        "ruta_local"=>$url_local,
        "extension"=>$extension,
        "request_usmeca" => $response['request_usmeca'],
        "documentos_anexados" => $response['documentos_anexados'],
      ];

      if( $extension=='html' || $extension=='text' ){
        $respuesta['contenido']=file_get_contents($url_local);
      }

      return $respuesta;
    }else{
      return $response;
    }
  }

  public static function enviar_solicitud_usmeca( Request $request, $id_documento, $request_usmeca, $id_bandeja = null ){
    $response = $request
    ->clienteWS_penal
    ->request('POST', 'enviar_solicitud_usmeca',[
        "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
        ],
        "json"=>[
            "datos"=>[
                "id_documento"=>$id_documento,
                "request_usmeca"=>$request_usmeca,
                "id_bandeja"=>$id_bandeja,
            ]
        ]
    ]);
    return json_decode($response->getBody(),true) ;
  }
}
 