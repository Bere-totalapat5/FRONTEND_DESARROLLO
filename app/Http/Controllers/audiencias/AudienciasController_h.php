<?php

namespace App\Http\Controllers\audiencias;

use App\Http\Controllers\clases\configuracion;
use App\Http\Controllers\Controller;
use App\Http\Controllers\clases\catalogos;
use App\Http\Controllers\clases\export;
use App\Http\Controllers\clases\audiencias;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Session;

class AudienciasController_h extends Controller
{

    //VISTAS VISTAS VISTAS VISTAS VISTAS

    public function consulta_audiencias(Request $request){

        $arr_unidades=catalogos::obtener_ugas($request,3)['response'];
        $unidades=Arr::sort($arr_unidades, 'id_unidad_gestion');

        $inmuebles = catalogos::inmuebles($request)['response'];
        $tipos_audiencia = catalogos::tipos_audiencia($request)['response'];
        $recursos_audiencia = catalogos::obtener_ver_tipos_recursos($request)['response'];
        $tipos_audiencia = catalogos::tipos_audiencia($request)['response'];

        $permisos = configuracion::obtener_permisos_ventana( $request, $request->session()->get("usuario-id"), 47 );
        if( $permisos["status"] == 100 ){
            $permisos_tratados = [];
            foreach($permisos["response"] as $idx => $p){
                $permisos_tratados[ $p["id_vista_accion"] ] = $p["valor"];
            }
            $permisos = $permisos_tratados;
        }else $permisos = [];

      $elementos=["entorno"=>$request->entorno,
                  "request"=>$request,
                  "sesion"=>Session::all(),
                  "menu_general"=>$request->menu_general,
                  "unidades"=>$unidades,
                  "inmuebles"=>$inmuebles,
                  "tipos_audiencia"=>$tipos_audiencia,
                  "recursos_audiencia" => $recursos_audiencia,
                  "tipos_audiencia"=>$tipos_audiencia,
                  "permisos"=>$permisos

                  ];
      return view('audiencias.consulta_audiencias', $elementos);

    }

    public function obtener_audiencias( Request $request ){

        $response = $request
        ->clienteWS_penal
        ->request('GET', 'obtener_audiencias',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[
                    //"modo"=>$request->modo,
                   //  "id_usuario"=>$request->id_usuario,
                    "id_unidad"=>$request->id_unidad_gestion,
                    "id_audiencia"=>$request->id_audiencia,
                    "fecha_min"=>$request->fecha_ini,
                    "fecha_max"=>$request->fecha_fin,
                    "cj"=>$request->cj,
                    "tipo_usuario_juez"=>$request->tipo_juezSearch,
                    "id_juez"=>$request->juezSearch,
                    "tipo_audiencia" =>$request->tipo_audiencia,
                    "id_inmueble"=>$request->id_inmueble,
                    "id_sala"=>$request->id_sala,
                    "situacion"=>$request->situacion,
                    "ordenamiento"=>$request->orden
                ], 
                "paginacion"=>[
                    "registros_por_pagina"=>$request->registros_por_pagina,
                    "pagina"=>$request->pagina
                ]
            ]
        ]);
        $response = json_decode($response->getBody(),true) ;
        return $response;
    }

    public function exportar_busqueda_audiencias(Request $request){
        $ruta_base_local = $request->entorno_privado["servidor_local"]["uri_local_proyecto"];

        $ordenamiento = [];
        if(!is_array($request->orden)){
                $ordenamiento = [
                    [
                        "campo"=>"fecha_audiencia",
                        "sentido"=>"ASC"
                    ],
                    [
                        "campo"=>"hora_inicio_audiencia",
                        "sentido"=>"ASC"
                    ]
                ];
        }else{
            $ordenamiento = $request->orden;
        }
    
        $response = $request
        ->clienteWS_penal
        ->request('POST', 'obtener_audiencias_Exportacion',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[
                    "id_unidad"=>$request->id_unidad_gestion,
                    "id_audiencia"=>$request->id_audiencia,
                    "fecha_min"=>$request->fecha_ini,
                    "fecha_max"=>$request->fecha_fin,
                    "cj"=>$request->cj,
                    "tipo_usuario_juez"=>$request->tipo_juezSearch,
                    "id_juez"=>$request->juezSearch,
                    "tipo_audiencia" =>$request->tipo_audiencia,
                    "id_inmueble"=>$request->id_inmueble,
                    "id_sala"=>$request->id_sala,
                    "situacion"=>$request->situacion,
                    "ordenamiento"=> $ordenamiento
                ], 
                "paginacion"=>[
                    "registros_por_pagina"=>$request->registros_por_pagina,
                    "pagina"=>$request->pagina
                ]
            ]
        ]);
        $response = json_decode($response->getBody(),true) ;
    
        if($response['status'] == 0){
          return $response;
        }else{
    
          $files = glob($ruta_base_local.'public/audiencias_xlsx/*'); //obtenemos todos los nombres de los ficheros
          foreach($files as $file){
              if(is_file($file))
              unlink($file); //elimino ficheros
          }
          $url_local=$ruta_base_local.'public/audiencias_xlsx/'.$response['nombre'].'.xlsx';
    
          $documento_xlsx=$response['response'];
          copy($documento_xlsx, $url_local);
    
          return [
              "status"=>100,
              "response"=>"http://".$_SERVER['HTTP_HOST']."/audiencias_xlsx/".$response['nombre'].".xlsx",
          ];
          // return $response;
        }
    }

    public static function obtener_inmueble_salas_audiencia(Request $request){

        $response = $request
        ->clienteWS_penal
        ->request('post', 'inmueble_salas',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos" => [
                    "id_inmueble" =>$request->id_inmueble,
                    "id_unidad_gestion" => $request->session()->get("id_unidad_gestion"),

                ]
             ]
        ]);
        $response = json_decode($response->getBody(),true) ;

        return $response;
    }
    public function bitacora_streaming(Request $request){

        $response = $request
        ->clienteWS_penal
        ->request('post', 'bitacora_streaming',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos" => [
                    "id_audiencia" => $request->id_audiencia,
                    "id_usuario" => $request->session()->get("usuario-id"),
                    "respuesta" => "VISTO - ".$request->respuesta 
                ]
             ]
        ]);
        $response = json_decode($response->getBody(),true) ;

        return $response;
    }

    public function ws_salas(Request $request){
        $response = $request
        ->clienteWS_penal
        ->request('POST', 'ws_salas',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[
                    "id_sala"=>$request->id_sala,
                    "id_inmueble"=>$request->id_inmueble
                ]
            ]
        ]);
        $response = json_decode($response->getBody(),true) ;
        return $response;
    }

    //###########3 Fracciones ###########
    public function catalogo_fracciones_solicitud(Request $request){

        $id_S_A = $request->id_solicitud == '' ?  $request->id_audiencia : $request->id_solicitud;
        $id_persona = $request->id_persona;
        $accion = $request->id_solicitud == '' ?  'audiencia' : 'solicitud';

        $response = $request
        ->clienteWS_penal
        ->request('GET', 'obtener_formato_medidas_proteccion/'.$accion.'/'.$id_S_A.'/'.$id_persona,[
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
        return $response;
    }

    public function guardar_fracciones_audiencia(Request $request){
        $id_audiencia = $request->id_audiencia;
        $tipo = $request->tipo;
        $response = '';
        $id_persona = isset($request->id_persona) ? $request->id_persona : '';

        if($tipo == 'solicitud'){
            $response = $request
            ->clienteWS_penal
            ->request('POST', 'creacion_formato_medidas_proteccion/audiencia/'.$id_audiencia,[
                "headers" => [
                    "sesion-id" => $request->session()->get("sesion-id"),
                    "cadena-sesion" => $request->session()->get("cadena-sesion"),
                    "usuario-id" => $request->session()->get("usuario-id"),
                    "Content-Type" => "application/json"
                ],
                "json"=>[
                    "datos"=>[
                        "fracciones_audiencia"=>$request->fracciones
                    ]
                ]
            ]);
            //dd($request);
            $response = json_decode($response->getBody(),true) ;
            
        }else if($tipo == 'audiencia'){
            $response = $request
            ->clienteWS_penal
            ->request('PATCH', 'modificar_formato_medidas_proteccion/audiencia/'.$id_audiencia.'/'.$id_persona,[
                "headers" => [
                    "sesion-id" => $request->session()->get("sesion-id"),
                    "cadena-sesion" => $request->session()->get("cadena-sesion"),
                    "usuario-id" => $request->session()->get("usuario-id"),
                    "Content-Type" => "application/json"
                ],
                "json"=>[
                    "datos"=>[
                        "valores"=>$request->fracciones
                    ]
                ]
            ]);
            //dd($request);
            $response = json_decode($response->getBody(),true) ;
        }else{
            $response = $request
            ->clienteWS_penal
            ->request('PATCH', 'modificar_formato_medidas_proteccion/acuerdo/'.$id_audiencia.'/'.$id_persona,[
                "headers" => [
                    "sesion-id" => $request->session()->get("sesion-id"),
                    "cadena-sesion" => $request->session()->get("cadena-sesion"),
                    "usuario-id" => $request->session()->get("usuario-id"),
                    "Content-Type" => "application/json"
                ],
                "json"=>[
                    "datos"=>[
                        "valores"=>$request->fracciones
                    ]
                ]
            ]);
            //dd($request);
            $response = json_decode($response->getBody(),true) ;
        }

        return $response;
    }

    public function guardarFechas_rat(Request $request){

        $response = $request
        ->clienteWS_penal
        ->request('POST', 'modificar_fecha_acuerdo',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[
                    "tipo_resolucion"=> $request->tipo_resolucion,
                    "fecha_inicio"=> $request->fecha_inicio,
                    "cantidad_dias"=>$request->cantidad_dias,
                    "fecha_fin"=> $request->fecha_fin,
                    "id_acuerdo_audiencia"=> $request->id_acuerdo_audiencia,
                    "resolucion_solicitud_medidad"=>$request->resolucion_solicitud_medidad
                ]
            ]
        ]);

        return $response = json_decode($response->getBody(),true) ;
    }

    public function catalogo_fracciones_solicitud_acuerdo(Request $request){

        $id_S_A = isset($request->id_acuerdo) ?  $request->id_acuerdo : '';
        $id_persona = $request->id_persona;

        $response = $request
        ->clienteWS_penal
        ->request('GET', 'obtener_formato_medidas_proteccion/acuerdo/'.$id_S_A.'/'.$id_persona,[
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
        return $response;
    }

    public function obtener_fecha_acuerdo(Request $request){

        $response = $request
        ->clienteWS_penal
        ->request('GET', 'obtener_fecha_acuerdo',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[
                    "id_solicitud"=> $request->id_solicitud,
                    "id_audiencia"=> $request->id_audiencia,
                ]
            ]
        ]);
        //dd($request);
        $response = json_decode($response->getBody(),true) ;
        return $response;
    }

    //Acuse de audiencia
    public function obtener_acuse_audiencia(Request $request){
        $response = $request
        ->clienteWS_penal
        ->request('POST', 'obtener_acuse_audiencia/'.$request->id_audiencia,[
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
        
        if(isset($response['acuse']['status']) && $response['acuse']['status'] == 100){

            $ruta_publica_acuse = "/temporales/".md5( date("YmdHis").rand(100,499) ).'_'.date('H').'.pdf';
            $url_acuse = $request->entorno['variables_entorno']['ruta_storage'].'app'.$ruta_publica_acuse;

            copy( $response['acuse']['response'], $url_acuse );
            link($url_acuse, base_path()."/public".$ruta_publica_acuse);
            $response['acuse']['response'] = $ruta_publica_acuse;
            $response['status']= 100; 

            $ruta_publica_formato = "/temporales/".md5( date("YmdHis").rand(500,999) ).'_'.date('H').'.pdf';
            $url_formato = $request->entorno['variables_entorno']['ruta_storage'].'app'.$ruta_publica_formato;

            copy( $response['formato']['response'], $url_formato );
            link($url_formato, base_path()."/public".$ruta_publica_formato);
            $response['formato']['response'] = $ruta_publica_formato;
            $response['status']= 100; 

        }else{
            $response['status']= 0;  
        }

        return $response;
    }

    //catalogo de tipos de usuaurio
    public function ver_catalogo_tipos_usuario(Request $request){
        $response = $request
        ->clienteWS_penal
        ->request('GET', 'ver_catalogo_tipos_usuario',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[
                    "palabra_clave"=>$request->palabra_clave
                ]
            ]
        ]);

        $response = json_decode($response->getBody(),true) ;
        return $response;
    }

    public function juezxtipo_juez(Request $request){
        $response = $request
        ->clienteWS_penal
        ->request('GET', 'juezxtipo_juez',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[
                    "id_tipo_juez"=>$request->id_tipo_juez,
                    "id_unidad_gestion"=>$request->id_unidad_gestion == 0 ? '-': $request->id_unidad_gestion
                ]
            ]
        ]);

        $response = json_decode($response->getBody(),true) ;
        return $response;
    }

    //#################################

    //NOTIFICACION CON MAJO Y SIAJOP
    public function renotificar_audiencia_MAJO_SIAJOP(Request $request){
        if($request->id_audiencia == null){
            return ['status'=>0, 'response'=>'Error - el id audiencia es nulo'];
        }else{
            $id_audiencia = $request->id_audiencia;
        }

        $response = $request
        ->clienteWS_penal
        ->request('POST', 'renotificar_audiencia_MAJO_SIAJOP/'.$id_audiencia,[
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

        $response = json_decode($response->getBody(),true) ;
        return $response;
    }
    
    public function audiencias_programadas( Request $request ) {

        $ugas = catalogos::obtener_ugas($request);
        
        $elementos=["entorno" => $request->entorno,
                    "request" => $request,
                    "sesion" => Session::all(),
                    "menu_general" => $request->menu_general,
                    "ugas" => $ugas['response']
                    ];

        return view('audiencias.audiencias_programadas', $elementos);

    }
    
    public function audiencia_carpeta_judicial( Request $request ) {

        if( isset( $request->id_carpeta_judicial) ) 
            Session::flash( 'id_carpeta_judicial', $request->id_carpeta_judicial );

        return redirect()->route('carpetas_judiciales');
    }
}
