<?php
namespace App\Http\Controllers\descarga_reportes;


use App\Http\Controllers\Controller;
use App\Http\Controllers\clases\catalogos;
use App\Http\Controllers\clases\export;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Session;

class DescargaReportesController extends Controller
{
  public function vista_descarga_reportes(Request $request){
    $arr_unidades=catalogos::obtener_ugas($request,3)['response'];
    $unidades=Arr::sort($arr_unidades, 'id_unidad_gestion');
    $arr_jueces = catalogos::obtener_jueces( $request, Session::get('id_unidad_gestion') , [5,15] )['response'];
    $jueces = Arr::sort($arr_jueces, 'cve_juez');
    $inmuebles = catalogos::inmuebles($request)['response'];

    $elementos=["entorno"=>$request->entorno,
    "request"=>$request,
    "sesion"=>Session::all(),
    "menu_general"=>$request->menu_general,
    "unidades"=>$unidades,
    "jueces" => $jueces,
    "inmuebles" => $inmuebles
    ];
    // Aqui la demas logica
    return view('descarga_reportes.consulta_reportes', $elementos); 
  }

  public function vista_reporte_libertades(Request $request){
    $elementos=["entorno"=>$request->entorno,
    "request"=>$request,
    "sesion"=>Session::all(),
    "menu_general"=>$request->menu_general,

    ];
    // Aqui la demas logica
    return view('reporte_libertades.reporte_libertades', $elementos); 
  }

  public function reenvio (Request $request){
    $reporte = $request->reporte_tipo;
    
    if($reporte == 'audiencias'){
      $response = $request
      ->clienteWS_penal
      ->request('POST', 'audiencia_programada',[
          "headers" => [
              "sesion-id" => $request->session()->get("sesion-id"),
              "cadena-sesion" => $request->session()->get("cadena-sesion"),
              "usuario-id" => $request->session()->get("usuario-id"),
              "Content-Type" => "application/json"
          ],
          "json"=>[
            "datos" => [
              "bandera_creacion"=> '-'
            ]
          ]
      ]);
      $response = json_decode($response->getBody(),true) ;
      return $response;

    }else if($reporte == 'delitos'){
      $diaAnterior = date('Y-m-d', strtotime('-1 day')) ;
      $hoy = date('Y-m-d');

      $response = $request
      ->clienteWS_penal
      ->request('POST', 'reporte_delitos',[
          "headers" => [
              "sesion-id" => $request->session()->get("sesion-id"),
              "cadena-sesion" => $request->session()->get("cadena-sesion"),
              "usuario-id" => $request->session()->get("usuario-id"),
              "Content-Type" => "application/json"
          ],
          "json"=>[
            "datos" => [
              "fecha_inicio" => $diaAnterior." 18:00:00",
              "fecha_final" => $hoy." 18:00:00",
              "bandera_creacion"=> '-',
            ]
          ]
      ]);
      $response = json_decode($response->getBody(),true) ;
      return $response;

    }else if($reporte == 'libertades'){
      $diaAnterior = date('Y-m-d', strtotime('-1 day')) ;
      $hoy = date('Y-m-d');

      $response = $request
      ->clienteWS_penal
      ->request('POST', 'enviar_reporte_libertades',[
          "headers" => [
              "sesion-id" => $request->session()->get("sesion-id"),
              "cadena-sesion" => $request->session()->get("cadena-sesion"),
              "usuario-id" => $request->session()->get("usuario-id"),
              "Content-Type" => "application/json"
          ],
          "json"=>[
            "datos" => [
              "fecha_inicio" => $diaAnterior,
              "fecha_final" => $hoy,
              "bandera_creacion"=> '-',
              "bandera"=> 'descarga'
            ]
          ]
      ]);
      $response = json_decode($response->getBody(),true) ;
      return $response;
    }

  }

  public function validacion_password(Request $request){
    
    $pass = $request->entorno_privado["password_reenvio_correos"]["password"];
    $password = trim($pass);

    //return ['status'=>0, 'response'=>'Contraseña incorrecta', 'pass'=>$password];
    if($password == trim($request->pass_correo)){
      return ['status'=>100, 'response'=>'password correcta','pass'=>$password];
    }else{
      return ['status'=>0, 'response'=>'Contraseña incorrecta', 'pass'=>$password];
    }

    /*
      $response = $request
      ->clienteWS_penal
      ->request('POST', 'validacion_password',[
          "headers" => [
              "sesion-id" => $request->session()->get("sesion-id"),
              "cadena-sesion" => $request->session()->get("cadena-sesion"),
              "usuario-id" => $request->session()->get("usuario-id"),
              "Content-Type" => "application/json"
          ],
          "json"=>[
            "datos"=>[
              "pass_correo"=>$request->pass_correo,
            ]
          ]
      ]);
      $response = json_decode($response->getBody(),true) ;
      return $response;
    */
  }

  //###################################################################

  public function descargar_reporte_delitos(Request $request){
    $ruta_base_local = $request->entorno_privado["servidor_local"]["uri_local_proyecto"];

    $response = $request
    ->clienteWS_penal
    ->request('POST', 'descargar_reporte_delitos',[
        "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
        ],
        "json"=>[
          "datos"=>[
            "fecha_inicio"=>$request->fecha_inicio,
            "fecha_final"=>$request->fecha_final
          ]
        ]
    ]);
    $response = json_decode($response->getBody(),true) ;
    
    if($response['status'] == 0){
      return $response;
    }else{

      $files = glob($ruta_base_local.'public/delitos_xlsx/*'); //obtenemos todos los nombres de los ficheros
      foreach($files as $file){
          if(is_file($file))
          unlink($file); //elimino ficheros
      }
      $url_local=$ruta_base_local.'public/delitos_xlsx/'.$response['nombre'].'.xlsx';

      $documento_xlsx=$response['response'];
      copy($documento_xlsx, $url_local);

      return [
          "status"=>100,
          "response"=>"http://".$_SERVER['HTTP_HOST']."/delitos_xlsx/".$response['nombre'].".xlsx",
      ];
      // return $response;
    }

  }

  public function descargar_reporte_libertades(Request $request){
    $ruta_base_local = $request->entorno_privado["servidor_local"]["uri_local_proyecto"];

    if(!isset($request->unidad_gestion)){
      $unidad = "-";
    }else{
      if(is_null($request->unidad_gestion)){
        $unidad = "-";
      }else{
        $unidad = $request->unidad_gestion == 0 ? "-": $request->unidad_gestion;
      }
    }

    $response = $request
    ->clienteWS_penal
    ->request('POST', 'descargar_reporte_libertades',[
        "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
        ],
        "json"=>[
          "datos"=>[
            "fecha_inicio"=> is_null($request->fecha_ini) ? date('Y-m-d') : $request->fecha_ini,
            "fecha_final"=> is_null($request->fecha_fin) ? date('Y-m-d') : $request->fecha_fin,
            "id_unidad"=>$unidad,
            "cj"=> "-",
            "id_audiencia"=>"-",
            "id_juez"=>"-",
            "tipo_usuario_juez"=>"-",
            "tipo_audiencia"=>"-",
            "bandera"=>"descarga"
          ]
        ]
    ]);
    $response = json_decode($response->getBody(),true) ;

    if($response['status'] == 0){
      return $response;
    }else{

      $files = glob($ruta_base_local.'public/libertades_xlsx/*'); //obtenemos todos los nombres de los ficheros
      foreach($files as $file){
          if(is_file($file))
          unlink($file); //elimino ficheros
      }
      $url_local=$ruta_base_local.'public/libertades_xlsx/'.$response['nombre'].'.xlsx';

      $documento_xlsx=$response['response'];
      copy($documento_xlsx, $url_local);

      return [
          "status"=>100,
          "response"=>"http://".$_SERVER['HTTP_HOST']."/libertades_xlsx/".$response['nombre'].".xlsx",
      ];
      // return $response;
    }

  }

  public function descargar_reporte_resolutivos_audiencia(Request $request){
    $ruta_base_local = $request->entorno_privado["servidor_local"]["uri_local_proyecto"];

    $response = $request
    ->clienteWS_penal
    ->request('GET', 'reporte_captura_resolutivos',[
        "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
        ],
        "json"=>[
          "datos"=>[
            "fecha_inicio"=>$request->fecha_inicio,
            "fecha_final"=>$request->fecha_final
            //"id_unidad"=> $request->id_unidad
          ]
        ]
    ]);
    $response = json_decode($response->getBody(),true) ;

    if($response['status'] == 0){
      return $response;
    }else{

      $files = glob($ruta_base_local.'public/xlsx/*'); //obtenemos todos los nombres de los ficheros
      foreach($files as $file){
          if(is_file($file))
          unlink($file); //elimino ficheros
      }
      $url_local=$ruta_base_local.'public/xlsx/'.$response['nombre'].'.xlsx';

      $documento_xlsx=$response['response'];
      copy($documento_xlsx, $url_local);

      return [
          "status"=>100,
          "response"=>"http://".$_SERVER['HTTP_HOST']."/xlsx/".$response['nombre'].".xlsx",
      ];

    }

  }

  public function descargar_reporte_desempeno_juez(Request $request){
    $ruta_base_local = $request->entorno_privado["servidor_local"]["uri_local_proyecto"];

    $response = $request
    ->clienteWS_penal
    ->request('GET', 'reporte_desempenio_juez',[
        "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
        ],
        "json"=>[
          "datos"=>[
            "fecha_inicio"=> $request->fecha_inicio,
            "fecha_final"=>  $request->fecha_final,
            "id_juez"=> $request->id_juez
          ]
        ]
    ]);
    $response = json_decode($response->getBody(),true) ;

    if($response['status'] == 0){
      return $response;
    }else{

      $files = glob($ruta_base_local.'public/xlsx/*'); //obtenemos todos los nombres de los ficheros
      foreach($files as $file){
          if(is_file($file))
          unlink($file); //elimino ficheros
      }
      $url_local=$ruta_base_local.'public/xlsx/'.$response['nombre'].'.xlsx';

      $documento_xlsx=$response['response'];
      copy($documento_xlsx, $url_local);

      return [
          "status"=>100,
          "response"=>"http://".$_SERVER['HTTP_HOST']."/xlsx/".$response['nombre'].".xlsx",
      ];
      // return $response;
    }

  }

  public function descargar_reporte_cj_recibidas(Request $request){
    $ruta_base_local = $request->entorno_privado["servidor_local"]["uri_local_proyecto"];

    $response = $request
    ->clienteWS_penal
    ->request('GET', 'reporte_carpetas_recibidas',[
        "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
        ],
        "json"=>[
          "datos"=>[
            "fecha_inicio"=> $request->fecha_inicio,
            "fecha_final"=>  $request->fecha_final,
            "id_unidad"=> $request->id_unidad,
            "tipo_carpeta"=> $request->tipo_carpeta
          ]
        ]
    ]);
    $response = json_decode($response->getBody(),true) ;

    if($response['status'] == 0){
      return $response;
    }else{

      $files = glob($ruta_base_local.'public/xlsx/*'); //obtenemos todos los nombres de los ficheros
      foreach($files as $file){
          if(is_file($file))
          unlink($file); //elimino ficheros
      }
      $url_local=$ruta_base_local.'public/xlsx/'.$response['nombre'].'.xlsx';

      $documento_xlsx=$response['response'];
      copy($documento_xlsx, $url_local);

      return [
          "status"=>100,
          "response"=>"http://".$_SERVER['HTTP_HOST']."/xlsx/".$response['nombre'].".xlsx",
      ];
      // return $response;
    }

  }

  public function descargar_reporte_r_audiencias(Request $request){
    $ruta_base_local = $request->entorno_privado["servidor_local"]["uri_local_proyecto"];

    $response = $request
    ->clienteWS_penal
    ->request('GET', 'reporte_informe_audiencias',[
        "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
        ],
        "json"=>[
          "datos"=>[
            "fecha_inicio"=> $request->fecha_inicio,
            "fecha_final"=>  $request->fecha_final,
            "id_juez"=> $request->id_juez
          ]
        ]
    ]);
    $response = json_decode($response->getBody(),true) ;

    if($response['status'] == 0){
      return $response;
    }else{

      $files = glob($ruta_base_local.'public/xlsx/*'); //obtenemos todos los nombres de los ficheros
      foreach($files as $file){
          if(is_file($file))
          unlink($file); //elimino ficheros
      }
      $url_local=$ruta_base_local.'public/xlsx/'.$response['nombre'].'.xlsx';

      $documento_xlsx=$response['response'];
      copy($documento_xlsx, $url_local);

      return [
          "status"=>100,
          "response"=>"http://".$_SERVER['HTTP_HOST']."/xlsx/".$response['nombre'].".xlsx",
      ];
      // return $response;
    }

  }

  public function descargar_reporte_sol_recibidas_td(Request $request){
    $ruta_base_local = $request->entorno_privado["servidor_local"]["uri_local_proyecto"];

    $response = $request
    ->clienteWS_penal
    ->request('GET', 'reporte_solicitudes_recibidas_td',[
        "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
        ],
        "json"=>[
          "datos"=>[
            "fecha_inicio"=> $request->fecha_inicio,
            "fecha_final"=>  $request->fecha_final,
            "id_juez"=> $request->id_juez
          ]
        ]
    ]);
    $response = json_decode($response->getBody(),true) ;

    if($response['status'] == 0){
      return $response;
    }else{

      $files = glob($ruta_base_local.'public/xlsx/*'); //obtenemos todos los nombres de los ficheros
      foreach($files as $file){
          if(is_file($file))
          unlink($file); //elimino ficheros
      }
      $url_local=$ruta_base_local.'public/xlsx/'.$response['nombre'].'.xlsx';

      $documento_xlsx=$response['response'];
      copy($documento_xlsx, $url_local);

      return [
          "status"=>100,
          "response"=>"http://".$_SERVER['HTTP_HOST']."/xlsx/".$response['nombre'].".xlsx",
      ];
      // return $response;
    }

  }

  public function descargar_reporte_resolutivos_por_audiencia(Request $request){
    $ruta_base_local = $request->entorno_privado["servidor_local"]["uri_local_proyecto"];

    $response = $request
    ->clienteWS_penal
    ->request('GET', 'reporte_captura_resolutivos_por_audiencia',[
        "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
        ],
        "json"=>[
          "datos"=>[
            "fecha_inicio"=>$request->fecha_inicio,
            "fecha_final"=>$request->fecha_final,
            "id_unidad"=> $request->id_unidad
          ]
        ]
    ]);
    $response = json_decode($response->getBody(),true) ;

    if($response['status'] == 0){
      return $response;
    }else{

      $files = glob($ruta_base_local.'public/xlsx/*'); //obtenemos todos los nombres de los ficheros
      foreach($files as $file){
          if(is_file($file))
          unlink($file); //elimino ficheros
      }
      $url_local=$ruta_base_local.'public/xlsx/'.$response['nombre'].'.xlsx';

      $documento_xlsx=$response['response'];
      copy($documento_xlsx, $url_local);

      return [
          "status"=>100,
          "response"=>"http://".$_SERVER['HTTP_HOST']."/xlsx/".$response['nombre'].".xlsx",
      ];

    }

  }

  public function descargar_reporte_medidas_Rati_LAMV(Request $request){
    $ruta_base_local = $request->entorno_privado["servidor_local"]["uri_local_proyecto"];

    $response = $request
    ->clienteWS_penal
    ->request('GET', 'informeMedidasProteccion',[
        "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
        ],
        "json"=>[
          "datos"=>[
            "fecha_inicio"=>$request->fecha_inicio,
            "fecha_final"=>$request->fecha_final
          ]
        ]
    ]);
    $response = json_decode($response->getBody(),true) ;

    if($response['status'] == 0){
      return $response;
    }else{

      $files = glob($ruta_base_local.'public/xlsx/*'); //obtenemos todos los nombres de los ficheros
      foreach($files as $file){
          if(is_file($file))
          unlink($file); //elimino ficheros
      }
      $url_local=$ruta_base_local.'public/xlsx/'.$response['nombre'].'.xlsx';

      $documento_xlsx=$response['response'];
      copy($documento_xlsx, $url_local);

      return [
          "status"=>100,
          "response"=>"http://".$_SERVER['HTTP_HOST']."/xlsx/".$response['nombre'].".xlsx",
      ];

    }

  }

  public function descargar_reporte_contadores_audiencias(Request $request){
    $ruta_base_local = $request->entorno_privado["servidor_local"]["uri_local_proyecto"];

    $response = $request
    ->clienteWS_penal
    ->request('GET', 'informe_audiencias_contadores',[
        "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
        ],
        "json"=>[
          "datos"=>[
            "fecha_inicio"=>$request->fecha_inicio,
            "fecha_final"=>$request->fecha_final
          ]
        ]
    ]);
    $response = json_decode($response->getBody(),true) ;

    if($response['status'] == 0){
      return $response;
    }else{

      $files = glob($ruta_base_local.'public/xlsx/*'); //obtenemos todos los nombres de los ficheros
      foreach($files as $file){
          if(is_file($file))
          unlink($file); //elimino ficheros
      }
      $url_local=$ruta_base_local.'public/xlsx/'.$response['nombre'].'.xlsx';

      $documento_xlsx=$response['response'];
      copy($documento_xlsx, $url_local);

      return [
          "status"=>100,
          "response"=>"http://".$_SERVER['HTTP_HOST']."/xlsx/".$response['nombre'].".xlsx",
      ];

    }

  }

  public function descargar_reporte_prom_tipos_audiencia(Request $request){
    $ruta_base_local = $request->entorno_privado["servidor_local"]["uri_local_proyecto"];

    $response = $request
    ->clienteWS_penal
    ->request('GET', 'reporte_promedios_tipos_audiencia',[
        "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
        ],
        "json"=>[
          "datos"=>[
            "fecha_inicio"=>$request->fecha_inicio,
            "fecha_final"=>$request->fecha_final
          ]
        ]
    ]);
    $response = json_decode($response->getBody(),true) ;

    if($response['status'] == 0){
      return $response;
    }else{

      $files = glob($ruta_base_local.'public/xlsx/*'); //obtenemos todos los nombres de los ficheros
      foreach($files as $file){
          if(is_file($file))
          unlink($file); //elimino ficheros
      }
      $url_local=$ruta_base_local.'public/xlsx/'.$response['nombre'].'.xlsx';

      $documento_xlsx=$response['response'];
      copy($documento_xlsx, $url_local);

      return [
          "status"=>100,
          "response"=>"http://".$_SERVER['HTTP_HOST']."/xlsx/".$response['nombre'].".xlsx",
      ];

    }
  }

  public function descargar_reporte_suspension_condicional(Request $request){
    $ruta_base_local = $request->entorno_privado["servidor_local"]["uri_local_proyecto"];

    $response = $request
    ->clienteWS_penal
    ->request('GET', 'reporte_suspension_condicional',[
        "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
        ],
        "json"=>[
          "datos"=>[
            "fecha_inicio"=>$request->fecha_inicio,
            "fecha_final"=>$request->fecha_final,
            "id_unidad"=> $request->id_unidad
          ]
        ]
    ]);
    $response = json_decode($response->getBody(),true) ;

    if($response['status'] == 0){
      return $response;
    }else{

      $files = glob($ruta_base_local.'public/xlsx/*'); //obtenemos todos los nombres de los ficheros
      foreach($files as $file){
          if(is_file($file))
          unlink($file); //elimino ficheros
      }
      $url_local=$ruta_base_local.'public/xlsx/'.$response['nombre'].'.xlsx';

      $documento_xlsx=$response['response'];
      copy($documento_xlsx, $url_local);

      return [
          "status"=>100,
          "response"=>"http://".$_SERVER['HTTP_HOST']."/xlsx/".$response['nombre'].".xlsx",
      ];

    }

  }
  
  public function descargar_reporte_remisiones_incompetencia(Request $request){
    $ruta_base_local = $request->entorno_privado["servidor_local"]["uri_local_proyecto"];

    $response = $request
    ->clienteWS_penal
    ->request('GET', 'reporte_remisiones_incompetencia',[
        "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
        ],
        "json"=>[
          "datos"=>[
            "fecha_inicio"=>$request->fecha_inicio,
            "fecha_final"=>$request->fecha_final
          ]
        ]
    ]);
    $response = json_decode($response->getBody(),true) ;

    if($response['status'] == 0){
      return $response;
    }else{

      $files = glob($ruta_base_local.'public/xlsx/*'); //obtenemos todos los nombres de los ficheros
      foreach($files as $file){
          if(is_file($file))
          unlink($file); //elimino ficheros
      }
      $url_local=$ruta_base_local.'public/xlsx/'.$response['nombre'].'.xlsx';

      $documento_xlsx=$response['response'];
      copy($documento_xlsx, $url_local);

      return [
          "status"=>100,
          "response"=>"http://".$_SERVER['HTTP_HOST']."/xlsx/".$response['nombre'].".xlsx",
      ];

    }

  }
  // ############# Libertades #####################

  public function ver_reporte_libertades(Request $request){

    // return ['response'=>$request->searhfor, 'status'=>100];

    $response = $request
    ->clienteWS_penal
    ->request('POST', 'ver_reporte_libertades',[
        "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
        ],
        "json"=>[
          "datos"=>[
            "fecha_inicio"=> is_null($request->fecha_ini) ? date('Y-m-d') : $request->fecha_ini,
            "fecha_final"=> is_null($request->fecha_fin) ? date('Y-m-d') : $request->fecha_fin,
            "id_unidad"=>$request->id_unidad_gestion == 0 ? '-':  $request->id_unidad_gestion,
            "cj"=> $request->searhfor != '' ? $request->searhfor : '-',
            "id_audiencia"=>"-",
            "id_juez"=>"-",
            "tipo_usuario_juez"=>"-",
            "tipo_audiencia"=>"-",
            "bandera"=>"-"
          ], 
          "paginacion"=>[
            "registros_por_pagina"=>$request->registros_por_pagina,
            "pagina"=>$request->pagina
          ]
        ]
    ]);
    $response = json_decode($response->getBody(),true);
    return $response;
  }

  public function eliminarMotivoResumen(Request $request){
    //return ['status'=>100, 'response'=>'Resumen y motivos removidos correctamente'];
    //return ['status'=>0, 'response'=>'Lo sentimos - ocurrio un error al remover el motivo y resumen'];
    $response = $request
    ->clienteWS_penal
    ->request('POST', 'eliminarMotivoResumen',[
        "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
        ],
        "json"=>[
          "datos"=>[
            "id_persona"=>$request->id_persona
          ]
        ]
    ]);
    $response = json_decode($response->getBody(),true) ;
    return $response;
  }

  public function guardarMotivoResumen(Request $request){

    //return ['status'=>100, 'response'=>'Datos actualizados correctamente', 'datos'=>$request->persona];
    //return ['status'=>0, 'response'=>'Lo sentimos - ocurrio un error al actualizar'];

    $response = $request
    ->clienteWS_penal
    ->request('POST', 'guardarMotivoResumen',[
        "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
        ],
        "json"=>[
          "datos"=>[
            "personas"=>$request->persona
          ]
        ]
    ]);
    $response = json_decode($response->getBody(),true) ;
    return $response;
  }


  //################################################
  public function obtener_contactos(Request $request){
    $response = $request
    ->clienteWS_penal
    ->request('POST', 'obtener_contactos',[
        "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
        ],
        "json"=>[
          "datos"=>[
          ]
        ]
    ]);
    return $response = json_decode($response->getBody(),true) ;
  }

  public function guardar_contacto(Request $request){
    $response = $request
    ->clienteWS_penal
    ->request('POST', 'guardar_contacto',[
        "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
        ],
        "json"=>[
          "datos"=>[
            "nombre"=>$request->nombre,
            "apaterno"=>$request->apaterno,
            "amaterno"=>$request->amaterno,
            "correo"=>$request->correo,
            "reporte"=>$request->reporte,
            "usuario_responsable"=>$request->session()->get("usuario-id")
          ],
          "colores"=>[
            "background"=>$request->background,
            "color"=>$request->color
          ]
        ]
    ]);
    return $response = json_decode($response->getBody(),true) ;
  }

  public function actualizar_contacto(Request $request){
    $response = $request
    ->clienteWS_penal
    ->request('POST', 'actualizar_contacto',[
        "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
        ],
        "json"=>[
          "datos"=>[
            "id"=>$request->id,
            "nombre"=>$request->nombre,
            "apaterno"=>$request->apaterno,
            "amaterno"=>$request->amaterno,
            "correo"=>$request->correo,
            "usuario_responsable"=>$request->session()->get("usuario-id")
          ],
          "colores"=>[
            "background"=>$request->background,
            "color"=>$request->color
          ]
        ]
    ]);
    return $response = json_decode($response->getBody(),true) ;
  }
  
  public function eliminar_contacto(Request $request){
    $response = $request
    ->clienteWS_penal
    ->request('POST', 'eliminar_contacto',[
        "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
        ],
        "json"=>[
          "datos"=>[
            "id"=>$request->id,
            "nombre"=>$request->nombre,
            "apellido"=>$request->apellido,
            "status"=>0,
          ]
        ]
    ]);
    return $response = json_decode($response->getBody(),true) ;
  }

  public function obtener_reportes_programados(Request $request){
    $response = $request
    ->clienteWS_penal
    ->request('POST', 'obtener_reportes_programados',[
        "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
        ],
        "json"=>[
          "datos"=>[
          ]
        ]
    ]);
    return $response = json_decode($response->getBody(),true) ;
  }

  public function guardar_reporte_programado(Request $request){
    $response = $request
    ->clienteWS_penal
    ->request('POST', 'guardar_reporte_programado',[
        "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
        ],
        "json"=>[
          "datos"=>[
            "titulo"=>$request->titulo,
            "remitente"=>$request->remitente,
            "nombre_remitente"=>$request->nombre_remitente,
            "usuario_responsable"=>$request->session()->get("usuario-id")
          ]
        ]
    ]);
    return $response = json_decode($response->getBody(),true) ;
  }

  public function actualizar_reporte_programado(Request $request){
    $response = $request
    ->clienteWS_penal
    ->request('POST', 'actualizar_reporte_programado',[
        "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
        ],
        "json"=>[
          "datos"=>[
            "id"=>$request->id,
            "titulo"=>$request->titulo,
            "remitente"=>$request->remitente,
            "nombre_remitente"=>$request->nombre_remitente,
            "usuario_responsable"=>$request->session()->get("usuario-id")
          ]
        ]
    ]);
    return $response = json_decode($response->getBody(),true) ;
  }

  public function removerContacto(Request $request){
    $response = $request
    ->clienteWS_penal
    ->request('POST', 'removerContacto',[
        "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
        ],
        "json"=>[
          "datos"=>[
            "id_reporte"=>$request->id_reporte,
            "id_contacto"=>$request->id_contacto,
            "nombre"=>$request->nombre_completo,
            "status"=>0,
          ]
        ]
    ]);
    return $response = json_decode($response->getBody(),true) ;
  }

  public function asignar_contacto(Request $request){
    $response = $request
    ->clienteWS_penal
    ->request('POST', 'asignar_contacto',[
        "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
        ],
        "json"=>[
          "datos"=>[
            "id_contacto"=>$request->id_contacto,
            "asignados"=>$request->asignados,
            "usuario_responsable"=>$request->session()->get("usuario-id")
          ]
        ]
    ]);
    return $response = json_decode($response->getBody(),true) ;
  }

  //Nuevas Libertades -----------------------------------------

  public function ObtenerCarpetaSeleccionada(Request $request){
    $response = $request
    ->clienteWS_penal
    ->request('POST', 'ObtenerCarpetaSeleccionada',[
        "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
        ],
        "json"=>[
          "datos"=>[
            "unidad"=>$request->unidad,
            "carpeta"=>$request->carpeta,
          ]
        ]
    ]);
    return $response = json_decode($response->getBody(),true) ;
  }

  public function guardar_info_addi(Request $request){
    $response = $request
    ->clienteWS_penal
    ->request('POST', 'guardar_info_addi',[
        "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
        ],
        "json"=>[
          "datos"=>[
            "usuario_responsable"=>$request->session()->get("usuario-id"),
            "libertades_add"=>$request->objeto_datos
          ]
        ]
    ]);
    return $response = json_decode($response->getBody(),true) ;
  }

  public function ObtenerLibertadesRegistradas(Request $request){
    $response = $request
    ->clienteWS_penal
    ->request('POST', 'ObtenerLibertadesRegistradas',[
        "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
        ],
        "json"=>[
          "datos"=>[
          ]
        ]
    ]);
    return $response = json_decode($response->getBody(),true) ;
  }

  public function borra_libertad_adicional(Request $request){
    $response = $request
    ->clienteWS_penal
    ->request('POST', 'borra_libertades_adicionales',[
        "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
        ],
        "json"=>[
          "datos"=>[
            "id_reg" => $request->id_reg
          ]
        ]
    ]);
    return $response = json_decode($response->getBody(),true) ;
  }


  // ######## Informes de desempeño DEGJ #########################  un no esta en prod
  
  public function vista_informes(Request $request){
    $arr_unidades=catalogos::obtener_ugas($request,3)['response'];
    $unidades=Arr::sort($arr_unidades, 'id_unidad_gestion');
    $jueces = catalogos::obtener_jueces( $request, Session::get('id_unidad_gestion') , [5,15] );
    $inmuebles = catalogos::inmuebles($request)['response'];

    $elementos=["entorno"=>$request->entorno,
    "request"=>$request,
    "sesion"=>Session::all(),
    "menu_general"=>$request->menu_general,
    "unidades"=>$unidades,
    "jueces" => $jueces,
    "inmuebles" => $inmuebles
    ];
    
    return view('informes.informes', $elementos); 
  }

  public function consulta_informes_c(Request $request){
    return ["status"=>100, "response"=>"halooo"];
  }


  // Busqueda de personas Global
  public function personasGlobal(Request $request){
    $arr_unidades=catalogos::obtener_ugas($request, $request->unidades)['response'];
    $unidades=Arr::sort($arr_unidades, 'id_unidad_gestion');
    $calidad_juridica=catalogos::calidad_juridica($request);
    $ugas=catalogos::obtener_ugas($request);
    $calidad_juridica=catalogos::calidad_juridica($request);
    $nacionalidades=catalogos::nacionalidades($request);
    $estado_civil=catalogos::estado_civil($request);
    $estados=catalogos::estados($request);
    $ocupaciones=catalogos::obtener_ocupaciones($request);
    $escolaridades=catalogos::obtener_escolaridades($request);
    $religiones=catalogos::obtener_religiones($request);
    $grupos_etnicos=catalogos::obtener_grupos_etnicos($request);
    $lenguas=catalogos::obtener_lenguas($request);
    $poblaciones_lgbttti =catalogos::obtener_poblaciones_lgbttti($request);
    $idiomas=catalogos::obtener_idiomas($request);
    $tipos_documento_carpeta=catalogos::tipos_documento_carpeta($request);
    $arr_fiscalias=catalogos::fiscalias($request)['response'];
    $calificativos = catalogos::calificativos($request);
    $delitos = catalogos::delitos($request)['response'];
    $fiscalias=Arr::sort($arr_fiscalias, 'fiscalia');
    $tipos_documentos_generados = catalogos::obtener_tipos_documentos_plantillas($request);
    $suspension_condicional = catalogos::obtener_suspencion_condicional($request);
    $inmuebles = catalogos::inmuebles($request)['response'];
    $tipos_audiencia = catalogos::tipos_audiencia($request)['response'];
    $recursos_audiencia = catalogos::obtener_ver_tipos_recursos($request)['response'];
    $arr_unidades=catalogos::obtener_ugas($request, $request->unidades)['response'];
    $unidades=Arr::sort($arr_unidades, 'id_unidad_gestion');
    $penas = catalogos::ver_tipo_pena($request);
    $centros_detencion = catalogos::obtener_centros_detencion($request);
    $identificaciones = catalogos::identificaciones( $request );

    $delitos_estadisticos = catalogos::obtener_catalogo_tipo_delictivo($request)['response'];
    $desagregados_estadisticos = catalogos::obtener_desagregado_delito_estadistico($request)['response'];

    $paises=catalogos::paises($request);
    $discapacidades = catalogos::discapacidades($request);
    $condicion_migratoria = catalogos::condicion_migratoria($request);
    $lengua_extranjera = catalogos::lengua_extranjera($request);
    $relacion_imputado = catalogos::relacion_imputado($request);
    $actos_investigacion = catalogos::actos_investigacion($request);
    $tipo_solucion_alterna = catalogos::tipo_solucion_alterna($request);
    $tipo_sobreseimiento = catalogos::tipo_sobreseimiento($request);
    $tipo_reparacion_danio = catalogos::tipo_reparacion_danio($request);
    $reparacion_danio = catalogos::reparacion_danio($request);
    $modalidad_reparacion_danio = catalogos::modalidad_reparacion_danio($request);
    $catalogo_comision = catalogos::catalogo_comision($request);
    $catalogo_modalidad_agresion = catalogos::catalogo_modalidad_agresion($request);

    $elementos=["entorno"=>$request->entorno,
        "request"=>$request,
        "sesion"=>Session::all(),
        "menu_general"=>$request->menu_general,
        "ugas"=>$ugas['response'],
        "calidad_juridica"=>$calidad_juridica['response'],
        "nacionalidades"=>$nacionalidades['response'],
        "estado_civil"=>$estado_civil['response'],
        "estados"=>$estados['response'],
        "ocupaciones"=>$ocupaciones['response'],
        "escolaridades"=>$escolaridades['response'],
        "religiones"=>$religiones['response'],
        "grupos_etnicos"=>$grupos_etnicos['response'],
        "lenguas"=>$lenguas['response'],
        "poblaciones_lgbttti"=>$poblaciones_lgbttti['response'],
        "idiomas"=>$idiomas['response'],
        "calificativos" => $calificativos['response'],
        "delitos" => $delitos,
        "tipos_documento_carpeta"=>$tipos_documento_carpeta['response'],
        "tipos_documentos_generados"=>$tipos_documentos_generados['message'],
        "fiscalias"=>$fiscalias,
        "suspension_condicional"=>$suspension_condicional['response'],
        "inmuebles"=>$inmuebles,
        "tipos_audiencia"=>$tipos_audiencia,
        "recursos_audiencia" => $recursos_audiencia,
        "penas" => $penas['message'],
        "centros_detencion" => $centros_detencion['message'],
        "delitos_estadisticos" => $delitos_estadisticos,
        "unidades" => $unidades,
        "identificaciones" => $identificaciones['response'],
        "paises"=>$paises['response'],
        "discapacidades"=>$discapacidades['response'],
        "condicion_migratoria"=> $condicion_migratoria['response'],
        "lengua_extranjera"=> $lengua_extranjera['response'],
        "relacion_imputado" => $relacion_imputado['response'],
        "actos_investigacion" => $actos_investigacion['response'],
        "tipo_solucion_alterna" => $tipo_solucion_alterna['response'],
        "tipo_sobreseimiento" => $tipo_sobreseimiento['response'],
        "tipo_reparacion_danio" => $tipo_reparacion_danio['response'],
        "reparacion_danio" => $reparacion_danio['response'],
        "modalidad_reparacion_danio" => $modalidad_reparacion_danio['response'],
        "elementos_comision" => $catalogo_comision['response'],
        "modalidad_agresion"=> $catalogo_modalidad_agresion['response'],
        "desagregados_estadisticos" => $desagregados_estadisticos,
    ];

    return view('personas.personas', $elementos);
  }

  public function buscar_personas_global(Request $request){
    $response = $request
    ->clienteWS_penal
    ->request('GET', 'buscar_parte',[
        "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
        ],
        "json"=>[
          "datos"=>[
            "nombre"=>$request->nombre,
            "id_calidad_juridica"=>$request->calidad_juridica,
            "id_tipo_carpeta"=>$request->tipo_carpeta,
            "id_unidad"=>$request->id_unidad
          ],
          "paginacion"=>[
            "pagina"=>$request->pagina,
            "registros_por_pagina"=>$request->registros_por_pagina
          ]
        ]
    ]);
    return $response = json_decode($response->getBody(),true) ;
  }

  public function exportar_constancia_busqueda(Request $request){
    $ruta_base_local = $request->entorno_privado["servidor_local"]["uri_local_proyecto"];

    $response = $request
    ->clienteWS_penal
    ->request('POST', 'exportar_constancia_busqueda',[
        "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
        ],
        "json"=>[
          "datos"=>[
            "datos_constancia"=>$request->datos_constancia
          ]
        ]
    ]);
    $response = json_decode($response->getBody(),true) ;

    
    if($response['status'] == 0){
      return $response;
    }else{

      $files = glob($ruta_base_local.'public/xlsx/*'); //obtenemos todos los nombres de los ficheros
      foreach($files as $file){
          if(is_file($file))
          unlink($file); //elimino ficheros
      }
      $url_local=$ruta_base_local.'public/xlsx/'.$response['nombre'].'.pdf';

      $documento_xlsx=$response['response'];
      copy($documento_xlsx, $url_local);

      return [
          "status"=>100,
          "response"=>"http://".$_SERVER['HTTP_HOST']."/xlsx/".$response['nombre'].".pdf",
      ];

    }
  }


  // ##########  Reporte de acuerdos Reparatorios ################
  public function vista_acuerdos_reparatorios(Request $request){
    $arr_unidades=catalogos::obtener_ugas($request,3)['response'];
    $unidades=Arr::sort($arr_unidades, 'id_unidad_gestion');

    $inmuebles = catalogos::inmuebles($request)['response'];

    $elementos=["entorno"=>$request->entorno,
    "request"=>$request,
    "sesion"=>Session::all(),
    "menu_general"=>$request->menu_general,
    "unidades"=>$unidades,
    "inmuebles" => $inmuebles
    ];

    return view('descarga_reportes.consulta_acuerdos_reparatorios', $elementos); 
  }

  public function buscar_acuerdos_reparatorios(Request $request){
    $response = $request
    ->clienteWS_penal
    ->request('GET', 'buscar_acuerdos_reparatorios',[
        "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
        ],
        "json"=>[
          "datos"=>[
            "nombre"=>$request->nombre,
            "id_calidad_juridica"=>$request->calidad_juridica,
            "id_tipo_carpeta"=>$request->tipo_carpeta,
            "id_unidad"=>$request->id_unidad
          ],
          "paginacion"=>[
            "pagina"=>$request->pagina,
            "registros_por_pagina"=>$request->registros_por_pagina
          ]
        ]
    ]);
    return $response = json_decode($response->getBody(),true) ;
  }

  public function informe_existencia_acuerdo(Request $request){
    $response = $request
    ->clienteWS_penal
    ->request('POST', 'informe_existencia_acuerdo',[
        "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
        ],
        "json"=>[
          "datos"=>[
            "existencia"=>$request->existencia,
            "nombre"=>$request->nombre,
            "ids_acuerdos"=> $request->ids_acuerdos,
          ]
        ]
    ]);

    return $response = json_decode($response->getBody(),true);
  }

  // ######## obtener documento solicitud TEJEC
  public function obtener_documento_solicitud_TEJEC(Request $request){ 
    $response = $request
    ->clienteWS_penal
    ->request('POST', 'obtener_documento_solicitud_TEJEC/'.$request->id_solicitud,[
        "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
        ],
        "json"=>[
            "datos"=>[
            ]
        ]
    ]);
    //dd($request);
    $response = json_decode($response->getBody(),true) ;
    
    if(isset($response['doc']['status']) && $response['doc']['status'] == 100){

        $ruta_publica_doc = "/temporales/".md5( date("YmdHis").rand(100,499) ).'_'.date('H').'.pdf';
        $url_doc = $request->entorno['variables_entorno']['ruta_storage'].'app'.$ruta_publica_doc;

        copy( $response['doc']['response'], $url_doc );
        link($url_doc, base_path()."/public".$ruta_publica_doc);
        $response['doc']['response'] = $ruta_publica_doc;
        $response['status']= 100; 

    }else{
        $response['status']= 0;  
    }

    return $response;
  }

  /// ###### obtener IP del cliente #############
  public function obtener_IP(Request $request){
    $ipAdress = null;

    if (!empty($_SERVER['HTTP_CLIENT_IP'])){ // Recogemos la IP 
      $ipAdress = $_SERVER['HTTP_CLIENT_IP'];
    }elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){ // Caso en que la IP llega a través de un Proxy
      $ipAdress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
      $ipAdress = $_SERVER['REMOTE_ADDR'];
    }

    if ($ipAdress==null){
      return ["status"=>0,"IP"=>null];
    }

    return ["status"=>100,"IP"=>$ipAdress];
  }

}