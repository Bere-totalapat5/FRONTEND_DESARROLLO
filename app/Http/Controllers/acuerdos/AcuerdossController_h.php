<?php

namespace App\Http\Controllers\acuerdos;


use App\Http\Controllers\Controller;
use App\Http\Controllers\clases\catalogos;
use App\Http\Controllers\clases\export;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Session;

class AcuerdosController_h extends Controller
{

  
 


                                    //VISTAS
    

    public function consulta_acuerdos(Request $request){

         $elementos=["entorno"=>$request->entorno,
                     "request"=>$request,
                     "sesion"=>Session::all(),
                     "menu_general"=>$request->menu_general,
                    /*  "solicitudes"=>$solicitudes */

                     ];
         return view('acuerdos.consulta_acuerdos', $elementos);

       }


    public function obtener_carga( Request $request ){


        $response = $request
        ->clienteWS_penal
        ->request('POST', 'consulta_cargat',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[
                    // "modo"=>$request->modo,
                    "id_unidad_gestion"=>$request->id_unidad_gestion,
                    "id_juez"=>$request->id_juez,
                    "fecha_ini"=>$request->fecha_ini,
                    "fecha_fin"=>$request->fecha_fin,
                    "tipo_carga"=>$request->tipo_carga,

                ], "paginacion"=>[
                    "registros_por_pagina"=>$request->registros_por_pagina,
                    "pagina"=>$request->pagina]
            ]
        ]);
        $response = json_decode($response->getBody(),true) ;
        return $response;
    }

    public function obtener_bitacora( Request $request ){


        $response = $request
        ->clienteWS_penal
        ->request('POST', 'bitacora',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[
                    // "modo"=>$request->modo,
                     "id_usuario"=>$request->id_usuario,
                     "id_unidad_gestion"=>$request->id_unidad_gestion,

                    "fecha_ini"=>$request->fecha_ini,
                    "fecha_fin"=>$request->fecha_fin,
                    "tipo"=>$request->tipo,

                ], "paginacion"=>[
                    "registros_por_pagina"=>$request->registros_por_pagina,
                    "pagina"=>$request->pagina]
            ]
        ]);
        $response = json_decode($response->getBody(),true) ;
        return $response;
    }



    public function exportar_carga(Request $request){
        $file = new export();
        //dd($this->obtener_solicitudes);
        $out = isset($request->out) ? $request->out : 'B64';

        $respuesta = $this->obtener_carga($request);


        if($respuesta['status'] == 100){
            $data = $respuesta['response'];
        }else{
            //return $respuesta;
            $data = [[
                'id_unidad_gestion'=> 'Sin datos' ,
                'fecha_ini'=> 'Sin datos' ,
                'fecha_fin'=> 'Sin datos' ,
                'tipo_carga'=> 'Sin datos' ,
                ]];
        }

        $header = [];
        if( isset($request->orden_columnas) && !empty($request->orden_columnas) ){
            foreach($request->orden_columnas as $c){
                $header[$c['campo']]=$c['titulo'];
            }
        }else{
            $header = [
                'id_unidad_gestion'=> 'ID Acuse' ,
                'fecha_ini'=> 'Fecha/hora de registro',
                'fecha_fin'=> 'Carpeta administrativa',
                'tipo_carga'=> 'Carpeta administrativa',

            ];
        } 
        
        $file->set_tema('sigj_penal');
        $file->set_report_title('Cargas');
        $file->set_sheet_title('Hoja 1');
        $file->set_header($header );
        $file->set_data($data);
        $file->set_position_sheet('horizontal');
        return $file->get_file($request->extension, $out);
        //dd('llegaste');
    }

    public function exportar_busqueda_bitacora(Request $request){
        $file = new export();
        //dd('llegaste');
        //dd($this->obtener_solicitudes);
        $out = isset($request->out) ? $request->out : 'B64';

        $respuesta = $this->obtener_bitacora($request);


        if($respuesta['status'] == 100){
            $data = $respuesta['response'];
        }else{
            //return $respuesta;
            $data = [[
                "creacion" =>"cSin datos",
                "id_usuario" => "Sin datos" ,
                "usuario_responsable" => "Sin datos" ,
                "nombre_responsable"=> "Sin datos"  ,
                "puesto_responsable"=> "Sin datos"  ,
                "nombre_unidad"=> "Sin datos"  ,
                "modulo"=> "Sin datos"  ,
                "tipo"=> "Sin datos"  ,
                "tabla"=> "Sin datos" ,
                ]];
        }

        $header = [];
        if( isset($request->orden_columnas) && !empty($request->orden_columnas) ){
            foreach($request->orden_columnas as $c){
                $header[$c['campo']]=$c['titulo'];
            }
        }else{
            $header = [
                "creacion" =>"creacion",
                "id_usuario" => "id_usuario" ,
                "usuario_responsable" => "usuario_responsable" ,
                "nombre_responsable"=> "nombre_responsable"  ,
                "puesto_responsable"=> "puesto_responsable"  ,
                "nombre_unidad"=> "nombre_unidad"  ,
                "modulo"=> "modulo"  ,
                "tipo"=> "tipo"  ,
                "tabla"=> "tabla" ,
            ];
        } 
        
        $file->set_tema('sigj_penal');
        $file->set_report_title('Bitacoras');
        $file->set_sheet_title('Hoja 1');
        $file->set_header($header );
        $file->set_data($data);
        $file->set_position_sheet('horizontal');
        return $file->get_file($request->extension, $out);
    }



    public function obtener_jueces( Request $request ){


        $response = $request
        ->clienteWS_penal
        ->request('POST', 'consulta_jueces',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[
                    // "modo"=>$request->modo,
                    "id_unidad_gestion"=>$request->id_unidad_gestion,
                    "tipo"=>'5',
                ]
            ]
        ]);
        $response = json_decode($response->getBody(),true) ;
        return $response;
    }


    public function obtener_usuarios( Request $request ){


        $response = $request
        ->clienteWS_penal
        ->request('POST', 'consulta_usuario',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[
                    // "modo"=>$request->modo,
                    "id_unidad_gestion"=>$request->id_unidad_gestion,
                ]
            ]
        ]);
        $response = json_decode($response->getBody(),true) ;
        return $response;
    }


    //configuracion default usuarios
    public function obtener_tipos_usuarios( Request $request ){


        $response = $request
        ->clienteWS_penal
        ->request('POST', 'tipo_usuario',[
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

    public function ver_configuracion_usuario( Request $request ){


        $response = $request
        ->clienteWS_penal
        ->request('POST', 'ver_configuracion_usuario',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[
                    "id_tipo_usuario"=>$request->id_tipo_usuario,
                ]
            ]
        ]);
        $response = json_decode($response->getBody(),true) ;
        return $response;
    }



    public function obtener_unidades( Request $request ){


        $response = $request
        ->clienteWS_penal
        ->request('POST', 'ver_ugas',[
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


    public function turnar_carpeta( Request $request,$id_solicitud){


        $response = $request
        ->clienteWS_penal
        ->request('PUT', 'turnado_urgente/5/'.$id_solicitud,[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[]
            ]
        ]); $response = json_decode($response->getBody(),true);

            return $response;
    }


    public function consulta_promujer(Request $request){

        /*    $arr_solicitudes=catalogos::solicitudes($request);
           $solicitudes=Arr::sort($arr_solicitudes, 'solicitudes'); */


         $elementos=["entorno"=>$request->entorno,
                     "request"=>$request,
                     "sesion"=>Session::all(),
                     "menu_general"=>$request->menu_general,
                    /*  "solicitudes"=>$solicitudes */

                     ];
         return view('promujer.consulta_promujer', $elementos);

       }

       public function obtener_solicitudes_promujer( Request $request ){


        $response = $request
        ->clienteWS_penal
        ->request('GET', 'consultar_solicitudes',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[
                    "id_solicitud"=>$request->id_solicitud,
                    "folio_solicitud"=>$request->folio_solicitud,
                    "folio_carpeta"=>$request->folio_carpeta,
                   /*  "modo"=>$request->modo,
                    "id_solicitud"=>$request->id_solicitud,
                    "folio_solicitud"=>$request->folio_solicitud,
                    "folio_carpeta"=>$request->folio_carpeta,
                    "carpeta_investigacion"=>$request->carpeta_investigacion,
                    "fecha_solicitud_min"=>$request->fecha_recepcion,
                    "fecha_solicitud_max"=>$request->fecha_recepcionh,
                    "estatus_actual"=>$request->estatus_flujo_actual,
                    "estatus_urgente"=>$request->estatus_urgente,
                    "materia_destino"=>$request->materia_destino, */

                    "modo"=>$request->modo,
                    "tipo_solicitud"=>"PRO-MUJER",


                ], "paginacion"=>[
                    "registros_por_pagina"=>$request->registros_por_pagina,
                    "pagina"=>$request->pagina]
            ]
        ]);
        $response = json_decode($response->getBody(),true) ;
        return $response;
    }
    public function ver_documentos(Request $request,$id_solicitud,$valor){

      $response = $request
      ->clienteWS_penal
      ->request('GET', 'consultar_pdf_solicitud/'.$id_solicitud.'/'.$valor,[
          "headers" => [
              "sesion-id" => $request->session()->get("sesion-id"),
              "cadena-sesion" => $request->session()->get("cadena-sesion"),
              "usuario-id" => $request->session()->get("usuario-id"),
              "Content-Type" => "application/json"
          ],
          "json" => [
              "datos" => [],
              "status" => 100
          ]
      ]);
       $response = json_decode($response->getBody(),true);

       if(isset($response[0]['url'])){
         $url = $response[0]['url'];
         $porciones = explode(".", $url);
         $tipo = $porciones[4];



         $url_local= base_path()."/public/temporal.".$tipo;
         $documento_pdf=$url;
         copy($documento_pdf, $url_local);

         $response = ["url" => $url_local,"extension" => $tipo];

       }
       return $response;
    }
    public function ver_flujo(Request $request,$id_solicitud){


      $response = $request
      ->clienteWS_penal
      ->request('GET', 'consultar_flujo_solicitud/'.$id_solicitud,[
          "headers" => [
              "sesion-id" => $request->session()->get("sesion-id"),
              "cadena-sesion" => $request->session()->get("cadena-sesion"),
              "usuario-id" => $request->session()->get("usuario-id"),
              "Content-Type" => "application/json"
          ],
          "json" => [
              "paginacion"=>[
              "registros_por_pagina"=>$request->registros_por_pagina,
              "pagina"=>$request->pagina]
                   ]
      ]);

      return $response = json_decode($response->getBody(),true);
    }

    public function ver_log(Request $request,$id_solicitud){

      $response = $request
      ->clienteWS_penal
      ->request('GET', 'consultar_log/'.$id_solicitud,[
          "headers" => [
              "sesion-id" => $request->session()->get("sesion-id"),
              "cadena-sesion" => $request->session()->get("cadena-sesion"),
              "usuario-id" => $request->session()->get("usuario-id"),
              "Content-Type" => "application/json"
          ],
          "json" => [
              "datos" => [],
              "status" => 100
          ]
      ]);
      $response = json_decode($response->getBody(),true);
      $b64 = $response['response']['b64'];
      $route = base_path()."/public/archivo.log";
      if (file_exists($route)) {
        unlink($route);
       }
      $log = fopen($route,"a");
      fwrite(	$log, base64_decode($b64)."\n\n");
      fclose( $log );

      return 1;
    }

    public function guardar_configuracion_default_tipo_usuario( Request $request ){


        $response_permisos = $request
        ->clienteWS_penal
        ->request('post', 'modifica_configuracion_usuario',[
            "headers" => [
                "sesion-id" => Session::get("sesion-id"),
                "cadena-sesion" => Session::get("cadena-sesion"),
                "id" => Session::get("usuario-id")
            ],
            "json"=>[
                "permisos"=>$request->permisos,
                "id_usuario_sesion" => Session::get("usuario-id")
            ]
        ]);

        return  $response_permisos = json_decode($response_permisos->getBody(),true) ;



      /*   $response_acciones = json_decode($response_acciones->getBody(),true) ;

        if($response_permisos["status"]==100 || $response_acciones['status']==100){
            return ["status"=>100];
        }else{
            return ["message"=>"Menús: ".explode('-',$response_permisos['message'])[1]." - Acciones: ".explode('-',$response_acciones['message'])[1]];
        } */

    }









}
