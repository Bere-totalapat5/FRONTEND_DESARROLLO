<?php
namespace App\Http\Controllers\clases;

use Illuminate\Http\Request;
use App;
use App\Http\Controllers\clases\bandejas;

class carpeta_judicial{

  public static function obtener_carpetas(Request $request, $param){
    $fecha_min='';
    $fecha_max='';
    $fecha_apelacion='';


    if(isset($param["fecha_asignacion_min"])){
        $f=explode('-',$param["fecha_asignacion_min"]);
        $fecha_min="$f[2]-$f[1]-$f[0] 00:00:00";
    }

    if(isset($param["fecha_asignacion_max"])){
        $f=explode('-',$param["fecha_asignacion_max"]);
        $fecha_max="$f[2]-$f[1]-$f[0] 23:59:59";
    }
  
    $filtro = [
      "modo"=> isset($param["modo"])?$param["modo"]:'-',
      "id_unidad"=> isset($param["id_unidad"])?$param["id_unidad"]:'-',
      "fecha_asignacion_min"=> isset($param["fecha_asignacion_min"])?$param["fecha_asignacion_min"]:'-',
      "fecha_asignacion_max"=> isset($param["fecha_asignacion_max"])?$param["fecha_asignacion_max"]:'-',
      "folio_carpeta"=> isset($param["folio_carpeta"])?$param["folio_carpeta"]:'-',
      "id_carpeta_judicial"=> isset($param["id_carpeta_judicial"])?$param["id_carpeta_judicial"]:'-',
      "id_tipo_carpeta"=> isset($param["id_tipo_carpeta"])?$param["id_tipo_carpeta"]:'-', 
      "persona_nom"=> isset($param["persona_nom"])?$param["persona_nom"]:'-',
      "persona_ap"=> isset($param["persona_ap"])?$param["persona_ap"]:'-',
      "persona_am"=> isset($param["persona_am"])?$param["persona_am"]:'-',
      "carpeta_investigacion"=> isset($param["carpeta_investigacion"])?$param["carpeta_investigacion"]:'-',
      "registros_por_pagina"=> isset($param["registros_por_pagina"])?$param["registros_por_pagina"]:10,
      "pagina"=> isset($param["pagina"])?$param["pagina"]:1,
    ];
      
    $response = $request
    ->clienteWS_penal
    ->request('get', 'consultar_carpetas_judiciales',[
      "headers" => [
        "sesion-id" => $request->session()->get("sesion-id"),
        "cadena-sesion" => $request->session()->get("cadena-sesion"),
        "usuario-id" => $request->session()->get("usuario-id"),
        "Content-Type" => "application/json"
      ],
      "json"=>[
        "datos"=>[
          "modo"=>$filtro["modo"],
          "id_unidad"=>$filtro["id_unidad"],
          "fecha_asignacion_min"=>$filtro["fecha_asignacion_min"],
          "fecha_asignacion_max"=>$filtro["fecha_asignacion_max"],
          "folio_carpeta"=>$filtro["folio_carpeta"],
          "id_carpeta_judicial"=>$filtro["id_carpeta_judicial"],
          "id_tipo_carpeta"=>$filtro["id_tipo_carpeta"],
          "persona_nom"=>$filtro["persona_nom"],
          "persona_ap"=>$filtro["persona_ap"],
          "persona_am"=>$filtro["persona_am"],
          "carpeta_investigacion"=>$filtro["carpeta_investigacion"],
        ],
        "paginacion"=>[
          "registros_por_pagina"=>$filtro["registros_por_pagina"],
          "pagina"=>$filtro["pagina"],
        ]
      ]
    ]);
    return json_decode($response->getBody(),true) ;

  }

  public static function borrar_carpeta( Request $request , $param ){

    $response = $request
    ->clienteWS_penal
    ->request('delete', 'eliminacion_carpeta/'.$request->session()->get("usuario-id").'/'.$param['carpeta'],[
        "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
        ],
        "json" => [
            "datos" =>[
                "comentarios_del" => $param['motivo_redireccion'],
                "modo" => $param['modo'],
                "id_inmueble" => $param['id_inmueble_redireccion'],
                "id_unidad" => $param['id_unidad_redireccion'],
            ],
        ],
    ]);
    $response = json_decode($response->getBody(),true) ;

    return $response;
    
  }

  public static function obtener_partes_procesales(Request $request,$id_capeta){
    $response = $request
    ->clienteWS_penal
    ->request('get', 'consultar_partes_carpeta/'.$request->session()->get("usuario-id").'/'.$id_capeta,[
        "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
        ]
    ]);
    $response = json_decode($response->getBody(),true) ;

    return $response;
  }

  public static function obtener_carpetas_acumuladas( Request $request, $id_carpeta_base ){
    $response = $request
    ->clienteWS_penal
    ->request('get', 'consultar_carpetas_acumuladas/',[
      "headers" => [
        "sesion-id" => $request->session()->get("sesion-id"),
        "cadena-sesion" => $request->session()->get("cadena-sesion"),
        "usuario-id" => $request->session()->get("usuario-id"),
        "Content-Type" => "application/json"
      ],
      "json" => [
        "datos" => [
          "id_carpeta_judicial" => $id_carpeta_base,
        ],
      ]
    ]);
    $response = json_decode($response->getBody(),true) ;

    return $response;
  }

  public static function obtener_pdf_solicitud(Request $request, $id_solicitud, $version=''){

    $response = $request
    ->clienteWS_penal
    ->request('get', 'consultar_pdf_solicitud/'.$id_solicitud.'/'.$version,[
        "headers" => [
          "sesion-id" => $request->session()->get("sesion-id"),
          "cadena-sesion" => $request->session()->get("cadena-sesion"),
          "usuario-id" => $request->session()->get("usuario-id"),
          "Content-Type" => "application/json"
        ]
    ]);
    
    $response = json_decode($response->getBody(),true);
    //dd($response, isset($response['status']), $version, isset($response[0]['url']));
    
    if( !isset($response['status']) && $version!='todas' && isset($response[0]['url']) ){

      $explode=explode('.',$response[0]['url']);

      $extension=end($explode);

      $nombre_doc = rand().'-'.$id_solicitud.'-'.rand();

      $url_local= base_path().'/storage/pdf_solicitudes/'.$nombre_doc.'.'.$extension;

      $documento_pdf=$response[0]['url'];

      copy($documento_pdf, $url_local);

      return [
        "status"=>100,
        "response"=>"/documento_solicitud/$nombre_doc.$extension",
        "ruta_local"=>$url_local,
        "extension"=>$extension,
      ];

    }else{
      //dd($response, 'else');
      return $response;
    }
  }

  public static function obtener_ultima_version_acuerdo(Request $request, $id_unidad, $id_acuerdo, $tipo){

    $response = $request
    ->clienteWS_penal
    ->request('get', 'obtener_ultima_version_acuerdo/'.$request->session()->get("usuario-id").'/'.$id_unidad.'/'.$id_acuerdo.'/'.$tipo,[
        "headers" => [
          "sesion-id" => $request->session()->get("sesion-id"),
          "cadena-sesion" => $request->session()->get("cadena-sesion"),
          "usuario-id" => $request->session()->get("usuario-id"),
          "Content-Type" => "application/json"
        ]
    ]);

    $response = json_decode($response->getBody(),true);
    if($response['status']==100){

      $url=$response['response'];

      $expl=explode('.',$url);

      $extension=end($expl);

      $url_local= base_path().'/storage/acuerdos/'.$id_acuerdo.'.'.$extension;

      $documento_pdf=$response['response'];

      copy($documento_pdf, $url_local);

      $respuesta=[
          "status"=>100,
          "response"=>"/acuerdos/$id_acuerdo.$extension",
          "ruta_local"=>$url_local,
          "extension"=>$extension,
      ];

      if($extension=='html' || $extension=='text'){
          $respuesta['contenido']=file_get_contents($url_local);
      }

      return $respuesta;
    }else{
      return $response;
    }

  }

  public static function obtener_pdf_promocion(Request $request, $id_promocion){

    $response = $request->clienteWS_penal->request('GET', 'consultar_pdf_promocion/' . $id_promocion, [
        "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json",
        ],
        "json" => [
            "datos" => [],
        ],
    ]);
    $response = json_decode($response->getBody(), true);
    
    if (!isset($response['status']) and isset($response[0]['url'])) {

        $nombre_doc = rand().'-'.$id_promocion.'-'.rand();

        $url_local = base_path().'/public/pdf_promocion/' . $nombre_doc . '.pdf';

        $documento_pdf = $response[0]['url'];
        copy($documento_pdf, $url_local);

        return [
            "status" => 100,
            "response" => "/pdf_promocion/$id_promocion.pdf",
            "ruta_local"=>$url_local,
            "extension"=>'pdf',
        ];
    } else {
        return $response;
    }
  }

  public static function obtener_documento_asociado($request, $id_carpeta, $id_documento){
    $response = $request
      ->clienteWS_penal
      ->request('POST', 'documento_carpeta_judicial/'.$request->session()->get('usuario_id').'/'.$id_carpeta.'/'.$id_documento.'/ARCHIVO',[
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
    //dd($response); 

    if( isset($response['url']) ){
      $explode_url=explode('/',$response['url']);
      //dd($explode_url);
      $explode_url=end($explode_url);
      $random=(explode('.',$explode_url))[0];
      $ext=(explode('.',$explode_url))[1];

      $nom_doc = $random.'.'.$ext; 
      
      if(isset($response['is_oficio']) && $response['is_oficio']==1) $nom_doc = str_replace('.'.$ext,'.pdf',$nom_doc); 

      $url_local= base_path().'/storage/pdf_solicitudes/'.$nom_doc;

      $documento_pdf=$response['url'];
      copy($documento_pdf, $url_local);

      return ["status"=>100,"response"=>"/pdf_solicitud/$nom_doc", "ruta_local" => $url_local];
    }else{
        return $response;
    }
  }

  public static function coser_documentos_pdf($array_files_paths, $file_path_out=null){
    $random = date('YmdHis').rand();

    if($file_path_out==null) $file_path_out= base_path().'/storage/pdf_solicitudes/unidos-'.$random.'.pdf';

    $arr_files= implode(' ',$array_files_paths);

    $comando = "pdftk $arr_files cat output $file_path_out";

    $datos['exec']=$comando;
    $datos['return'] = exec($comando);
    $datos['ruta_local'] = $file_path_out;
    $datos['response']= '/documento_solicitud/unidos-'.$random.'.pdf';
    if(file_exists($file_path_out)) $datos['status'] = 100;
    else{
      $datos['status'] = 0;
      $datos['message'] = 'No se logró unir los archivos';
    }
    return $datos;
  }

  public static function sincronizacion_carpeta( Request $request, $id_solicitud ){
    $response = $request
    ->clienteWS_penal
    ->request('get', 'sincronizacion_carpetas/',[
        "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
        ],
        "json" => [ 
          "datos" => [
            "id_solicitud" => $id_solicitud,
          ]  
        ]
    ]);
    $response = json_decode($response->getBody(),true) ;

    return $response;
  }

  public static function obtener_audiencias_viejo_penal( Request $request, $id_carpeta_judicial){
    $response = $request
    ->clienteWS_penal
    ->request('get', 'obtener_audiencias_viejo_penal/'.$id_carpeta_judicial,[
        "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
        ],
    ]);
    $response = json_decode($response->getBody(),true) ;

    return $response;
  }

  public static function word_a_pdf ( Request $request, $archivo_doc,$nombre_archivo_salida=null){
    //dd($archivo_doc);
    $url_file=$archivo_doc->store('porfirmar');

    $extension_word = pathinfo(storage_path($url_file), PATHINFO_EXTENSION);
    $datos_archvios[]=base_path().'/storage/app/'.$url_file;
    //$nombre_archivo_salida = $nombre_archivo_salida == null ? 'conversion-'.date('YmdHis').'-'.rand().'.pdf' : $nombre_archivo_salida.'.pdf';
    $doc_arr=bandejas::documento_convertir_pdf($datos_archvios); //, $nombre_archivo_salida);
    //dd( $doc_arr );
    $doc_arr['url_pdf']="vistaprevia/".$doc_arr['filename'];
    $doc_arr['word_ruta_local'] = $datos_archvios[0];
    return $doc_arr;
  }

  
  // Notificaciones
  public static function obtener_notificaciones( Request $request , $param ){
    
    $response = $request
    ->clienteWS_penal
    ->request('get', 'obtener_notificaciones',[
      "headers" => [
        "sesion-id" => $request->session()->get("sesion-id"),
        "cadena-sesion" => $request->session()->get("cadena-sesion"),
        "usuario-id" => $request->session()->get("usuario-id"),
        "Content-Type" => "application/json"
      ],
      "json"=>[
        "datos"=>[
          "id_notificacion" => isset($param["id_notificacion"]) ? $param["id_notificacion"] : "-" ,
          "id_carpeta_judicial" => isset($param["id_carpeta_judicial"]) ? $param["id_carpeta_judicial"] : "-" ,
          "fecha_programada" => isset($param["fecha_programada"]) ? $param["fecha_programada"] : "-" ,
          "fecha_programada_desde" => isset($param["fecha_programada_desde"]) ? $param["fecha_programada_desde"] : "-" ,
          "fecha_programada_hasta" => isset($param["fecha_programada_hasta"]) ? $param["fecha_programada_hasta"] : "-" ,
          "texto_notificacion" => isset($param["texto_notificacion"]) ? $param["texto_notificacion"] : "-" ,
          "tipo_notificacion" => isset($param["tipo_notificacion"]) ? $param["tipo_notificacion"] : "-" ,
          "estatus_actual" => isset($param["estatus_actual"]) ? $param["estatus_actual"] : "-" ,
          "estatus" => isset($param["estatus"]) ? $param["estatus"] : "-" ,
        ],
        "paginacion"=>[
          "pagina"=>isset($param["pagina"]) ? $param["pagina"] : 1,
          "registros_por_pagina"=>isset($param["registros_por_pagina"]) ? $param["registros_por_pagina"] : 10,
        ]
      ]
    ]);
    return json_decode($response->getBody(),true) ;

  }

  public static function nueva_notificacion( Request $request , $param ){
    
    $response = $request
    ->clienteWS_penal
    ->request('post', 'nueva_notificacion/'.$request->session()->get("usuario-id").'/'.$param["id_carpeta_judicial"],[
      "headers" => [
        "sesion-id" => $request->session()->get("sesion-id"),
        "cadena-sesion" => $request->session()->get("cadena-sesion"),
        "usuario-id" => $request->session()->get("usuario-id"),
        "Content-Type" => "application/json"
      ],
      "json"=>[
        "datos"=>[
          "fecha_programada" => isset($param["fecha_programada"]) ? $param["fecha_programada"] : "-" ,
          "texto_notificacion" => isset($param["texto_notificacion"]) ? $param["texto_notificacion"] : "-" ,
          "tipo_notificacion" => isset($param["tipo_notificacion"]) ? $param["tipo_notificacion"] : "-" ,
          "id_unidad" => isset($param["id_unidad"]) ? $param["id_unidad"] : "-" ,
        ],
      ]
    ]);
    return json_decode($response->getBody(),true) ;

  }

  public static function editar_notificacion( Request $request , $param ){
    
    $response = $request
    ->clienteWS_penal
    ->request('patch', 'editar_notificacion/'.$request->session()->get("usuario-id").'/'.$param["id_carpeta_judicial"].'/'.$param["id_notificacion"],[
      "headers" => [
        "sesion-id" => $request->session()->get("sesion-id"),
        "cadena-sesion" => $request->session()->get("cadena-sesion"),
        "usuario-id" => $request->session()->get("usuario-id"),
        "Content-Type" => "application/json"
      ],
      "json"=>[
        "datos"=>[
          "fecha_programada" => isset($param["fecha_programada"]) ? $param["fecha_programada"] : "-" ,
          "texto_notificacion" => isset($param["texto_notificacion"]) ? $param["texto_notificacion"] : "-" ,
          "tipo_notificacion" => isset($param["tipo_notificacion"]) ? $param["tipo_notificacion"] : "-" ,
          "estatus_actual" => isset($param["estatus_actual"]) ? $param["estatus_actual"] : "-" ,
          "estatus" => isset($param["estatus"]) ? $param["estatus"] : "-" ,
        ],
      ]
    ]);
    return json_decode($response->getBody(),true) ;
  }
  /* obsoileto */

  public static function asociar_delito_estadistico_persona( Request $request , $param ){
    $response = $request
    ->clienteWS_penal
    ->request('post', 'asociar_delito_estadistico_persona',[
      "headers" => [
        "sesion-id" => $request->session()->get("sesion-id"),
        "cadena-sesion" => $request->session()->get("cadena-sesion"),
        "usuario-id" => $request->session()->get("usuario-id"),
        "Content-Type" => "application/json"
      ],
      "json"=>[
        "datos"=>[
          "ids_persona" => isset($param["ids_persona"]) ? $param["ids_persona"] : "-",
          "id_delito" => isset($param["id_delito"]) ? $param["id_delito"] : "-",
          "id_desagregado" => isset($param["id_desagregado"]) ? $param["id_desagregado"] : "-",
        ],
      ]
    ]);
    return json_decode($response->getBody(),true) ;
  }
 
  public static function asignar_delito_estadistico_persona( Request $request , $param ){
    
    $response = $request
    ->clienteWS_penal
    ->request('post', 'asignar_delito_estadistico_persona',[
      "headers" => [
        "sesion-id" => $request->session()->get("sesion-id"),
        "cadena-sesion" => $request->session()->get("cadena-sesion"),
        "usuario-id" => $request->session()->get("usuario-id"),
        "Content-Type" => "application/json"
      ],
      "json"=>[
        "datos"=>[
          "id_persona_delito" => isset($param["id_persona_delito"]) ? $param["id_persona_delito"] : "-" ,
          "tipo_delictivo" => isset($param["tipo_delictivo"]) ? $param["tipo_delictivo"] : "-" ,
          "desagregado_n1" => isset($param["desagregado_n1"]) ? $param["desagregado_n1"] : "-" ,
          "desagregado_n2" => isset($param["desagregado_n2"]) ? $param["desagregado_n2"] : "-" ,
          "desagregado_n3" => isset($param["desagregado_n3"]) ? $param["desagregado_n3"] : "-" ,
          "desagregado_n4" => isset($param["desagregado_n4"]) ? $param["desagregado_n4"] : "-" ,
          "otro" => isset($param["otro"]) ? $param["otro"] : "-" ,
          "id_solicitud" => isset($param["id_solicitud"]) ? $param["id_solicitud"] : "-" ,
          "id_persona" => isset($param["id_persona"]) ? $param["id_persona"] : "-" ,
        ],
      ]
    ]);

    return json_decode($response->getBody(),true) ;

  }
  

}