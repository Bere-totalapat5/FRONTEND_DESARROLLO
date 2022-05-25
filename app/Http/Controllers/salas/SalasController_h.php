<?php

namespace App\Http\Controllers\salas;


use App\Http\Controllers\Controller;
use App\Http\Controllers\clases\catalogos;
use App\Http\Controllers\clases\export;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Session;

class SalasController_h extends Controller
{

    public function activacion_salas(Request $request){

            $arr_unidades=catalogos::obtener_ugas_exhorto($request, $request->unidades);
            $inmuebles=catalogos::inmuebles($request);

            $unidades=Arr::sort($arr_unidades, 'id_unidad_gestion');


            $elementos=["entorno"=>$request->entorno,
                        "request"=>$request,
                        "sesion"=>Session::all(),
                        "menu_general"=>$request->menu_general,
                        "unidades"=>$unidades,
                        "inmuebles"=>$inmuebles,
                    ];
        return view('salas.activacion_salas', $elementos);

    }

    public function incidencias_de_salas(Request $request){

            $arr_unidades=catalogos::obtener_ugas_incidencias_salas($request, $request->unidades);
            $unidades=Arr::sort($arr_unidades, 'id_unidad_gestion');

            $arr_salas=$this->obtener_todas_salas($request);
            $salas=Arr::sort($arr_salas, 'id_sala');


            $elementos=["entorno"=>$request->entorno,
                        "request"=>$request,
                        "sesion"=>Session::all(),
                        "menu_general"=>$request->menu_general,
                        "unidades"=>$unidades,
                        "salas"=>$salas,
                      ];
              return view('salas.incidencias_salas', $elementos);
    }

    public function salas_unidad_inmueble( Request $request ){

        $response = $request
        ->clienteWS_penal
        ->request('POST', 'unidades_salas',[
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

    public function obtener_todas_salas( Request $request ){

        $response = $request
        ->clienteWS_penal
        ->request('POST', 'salas',[
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

    //##### INCIDENCIAS DE SALA

    public function obtener_incidencias_sala( Request $request ){

        $response = $request
        ->clienteWS_penal
        ->request('POST', 'consulta_incidencia_sala',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[
                    "motivo"=>$request->motivo,
                    "fecha_desde"=>$request->fecha_ini,
                    "fecha_hasta"=>$request->fecha_fin,
                ], "paginacion"=>[
                    "registros_por_pagina"=>$request->registros_por_pagina,
                    "pagina"=>$request->pagina]
            ]
        ]);
        $response = json_decode($response->getBody(),true) ;
        return $response;
    }

    public function registrar_incidencia_sala( Request $request ){

        $response = $request
        ->clienteWS_penal
        ->request('POST', 'incidencia_sala',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[
                    "fecha_desde"=>$request->fecha_desde,
                    "fecha_hasta"=>$request->fecha_hasta,
                    "aplica_unidades"=>$request->aplica_unidades,
                    "tipo"=>$request->tipo,
                    "motivo"=>$request->motivo,
                    "comentarios"=>$request->comentarios,
                    "ids_unidad_gestion"=>$request->ids_unidad_gestion,
                    "id_usuario_sesion"=>$request->session()->get("usuario-id"),
                    "salas"=> $request->salas
                ],
            ]
        ]);
        $response = json_decode($response->getBody(),true) ;
        return $response;
    }

    public function eliminar_incidencia( Request $request ){

        $response = $request
        ->clienteWS_penal
        ->request('POST', 'eliminar_incidencia',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[
                    "id_incidencia_sala"=>$request->id_incidencia_sala,
                ],
            ]
        ]);
        $response = json_decode($response->getBody(),true) ;
        return $response;
    }

    public function activar_incidencia( Request $request ){

        $response = $request
        ->clienteWS_penal
        ->request('POST', 'activar_incidencia',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[
                    "id_incidencia_sala"=>$request->id_incidencia_sala,
                    "etapa"=>$request->etapa
                ],
            ]
        ]);
        $response = json_decode($response->getBody(),true) ;
        return $response;
    }

    public function actualizar_incidencia( Request $request ){

        $response = $request
        ->clienteWS_penal
        ->request('POST', 'actualizar_incidencia',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[
                    "id_incidencia_sala"=> $request->id_incidencia_sala,
                    "fecha_desde"=>$request->fecha_desde,
                    "fecha_hasta"=>$request->fecha_hasta,
                    "aplica_unidades"=>$request->aplica_unidades,
                    "tipo"=>$request->tipo,
                    "motivo"=>$request->motivo,
                    "comentarios"=>$request->comentarios,
                    "ids_unidad_gestion"=>$request->ids_unidad_gestion,
                    "id_usuario_sesion"=>$request->session()->get("usuario-id"),
                    "salas"=> $request->salas
                ],
            ]
        ]);
        $response = json_decode($response->getBody(),true) ;
        return $response;
    }

    

    

    public function guardar_configuracion_unidades_salas( Request $request ){


        $response = $request
        ->clienteWS_penal
        ->request('post', 'modifica_unidades_salas',[
            "headers" => [
                "sesion-id" => Session::get("sesion-id"),
                "cadena-sesion" => Session::get("cadena-sesion"),
                "id" => Session::get("usuario-id")
            ],
            "json"=>[
                "salas"=>$request->salas,

            ]
        ]);

        $response = json_decode($response->getBody(),true) ;
        return  $response;


      /*   $response_acciones = json_decode($response_acciones->getBody(),true) ;

        if($response_permisos["status"]==100 || $response_acciones['status']==100){
            return ["status"=>100];
        }else{
            return ["message"=>"Menús: ".explode('-',$response_permisos['message'])[1]." - Acciones: ".explode('-',$response_acciones['message'])[1]];
        } */

    }

    public function exportar_busqueda_incidencias(Request $request){
        $file = new export();
        //dd('llegaste');
        //dd($this->obtener_solicitudes);
        $out = isset($request->out) ? $request->out : 'B64';

        $respuesta = $this->obtener_incidencias_sala($request);


        if($respuesta['status'] == 100){
            $data = $respuesta['response'];
        }else{
            //return $respuesta;
            $data = [[
                "id_incidencia_sala" =>"cSin datos",
                "motivo" => "Sin datos" ,
                "fecha_desde" => "Sin datos" ,
                "fecha_hasta"=> "Sin datos"  ,
                "id_sala"=> "Sin datos"  ,
                "tipo"=> "Sin datos"  ,
                "tipo"=> "Sin datos"  ,
                "unidades"=> "Sin datos"  ,
                "tipo"=> "Sin datos" ,
                "comentarios"=> "Sin datos" ,
                "comentarios"=> "Sin datos" ,
                ]];
        }

        $header = [];
        if( isset($request->orden_columnas) && !empty($request->orden_columnas) ){
            foreach($request->orden_columnas as $c){
                $header[$c['campo']]=$c['titulo'];
            }
        }else{
            $header = [
                "id_incidencia_sala" =>"id_incidencia_sala",
                "motivo" => "motivo" ,
                "fecha_desde" => "fecha_desde" ,
                "fecha_hasta"=> "fecha_hasta"  ,
                "id_sala"=> "id_sala"  ,
                "tipo"=> "tipo"  ,
                "tipo"=> "tipo"  ,
                "unidades"=> "unidades"  ,
                "tipo"=> "tipo" ,
                "comentarios"=> "comentarios" ,
                "comentarios"=> "comentarios" ,
            ];
        }

        $file->set_report_title('Incidencias de sala');
        $file->set_sheet_title('Incidencias de sala');
        $file->set_header($header );
        $file->set_data($data);
        $file->set_position_sheet('horizontal');
        return $file->get_file($request->extension, $out);
    }

    public function consulta_sala( Request $request ){
        
        $response = $request
        ->clienteWS_penal
        ->request('get', 'consulta_sala/'.$request->id_sala,[
            "headers" => [
                "sesion-id" => Session::get("sesion-id"),
                "cadena-sesion" => Session::get("cadena-sesion"),
                "id" => Session::get("usuario-id")
            ],
        ]);

        $response = json_decode($response->getBody(),true) ;
        return  $response;

    }

    public function nueva_sala( Request $request ){
        
        $response = $request
        ->clienteWS_penal
        ->request('post', 'inserta_sala',[
            "headers" => [
                "sesion-id" => Session::get("sesion-id"),
                "cadena-sesion" => Session::get("cadena-sesion"),
                "id" => Session::get("usuario-id")
            ],
            "json"=>[
                "datos" => [
                    "inmueble" => isset($request->inmueble) ? $request->inmueble : "-" ,
                    "codigo" => isset($request->codigo) ? $request->codigo : "-" ,
                    "clave_sala" => isset($request->clave_sala) ? $request->clave_sala : "-" ,
                    "nombre_sala" => isset($request->nombre_sala) ? $request->nombre_sala : "-" ,
                    "url_rtmp" => isset($request->url_rtmp) ? $request->url_rtmp : "-" ,
                    "url_ws" => isset($request->url_ws) ? $request->url_ws : "-" ,
                ]

            ]
        ]);

        $response = json_decode($response->getBody(),true) ;
        return  $response;

    }

    public function actualiza_sala( Request $request ){
        
        $response = $request
        ->clienteWS_penal
        ->request('post', 'actualiza_sala',[
            "headers" => [
                "sesion-id" => Session::get("sesion-id"),
                "cadena-sesion" => Session::get("cadena-sesion"),
                "id" => Session::get("usuario-id")
            ],
            "json"=>[
                "datos" => [
                    "id_sala" => isset($request->id_sala) ? $request->id_sala : "-" ,
                    "inmueble" => isset($request->inmueble) ? $request->inmueble : "-" ,
                    "codigo" => isset($request->codigo) ? $request->codigo : "-" ,
                    "clave_sala" => isset($request->clave_sala) ? $request->clave_sala : "-" ,
                    "nombre_sala" => isset($request->nombre_sala) ? $request->nombre_sala : "-" ,
                    "url_rtmp" => isset($request->url_rtmp) ? $request->url_rtmp : "-" ,
                    "url_ws" => isset($request->url_ws) ? $request->url_ws : "-" ,
                    "estatus" => isset($request->estatus) ? $request->estatus : "-" ,
                ]

            ]
        ]);

        $response = json_decode($response->getBody(),true) ;
        return  $response;
    }
}
