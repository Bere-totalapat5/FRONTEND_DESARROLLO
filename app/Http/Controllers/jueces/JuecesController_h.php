<?php

namespace App\Http\Controllers\jueces;


use App\Http\Controllers\Controller;
use App\Http\Controllers\clases\catalogos;
use App\Http\Controllers\clases\export;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Session;

class JuecesController_h extends Controller
{                           //VISTAS VISTAS VISTAS VISTAS

    public function ver_admon_jueces(Request $request){

       $arr_unidades=catalogos::obtener_ugas_exhorto($request, $request->unidades);
       $unidades=Arr::sort($arr_unidades, 'id_unidad_gestion');


      /*  $arr_jueces=catalogos::jueces_sustitucion($request, $request->unidades);
       $jueces=Arr::sort($arr_jueces, 'id_usuario'); */


          /* $sustituciones = $this->obtener_sustituciones($request);
          $sustituciones_jueces=[];

            if(isset($sustituciones['response'])){
                foreach($sustituciones['response'] as $sustitucion){

                    $datos_sustitucion=[
                        "id"=> strval($sustitucion['id_sustitucion']),
                        "start_date"=>$sustitucion['fecha_inicio'],
                        "end_date"=>$sustitucion['fecha_fin'],
                        "text"=>$sustitucion['descripcion'],
                    ];
                    array_push($sustituciones_jueces, $datos_sustitucion);
                }
            }else{$datos_sustitucion=[
                        "title"=>"error",
                        "start_date"=>"error",
                        "end_date"=>"error",
                        "text"=>"error",
                    ];
                    array_push($sustituciones_jueces, $datos_sustitucion);
            }

            $datos=[

                "data"=>$sustituciones_jueces,
            ]; */

      $elementos=["entorno"=>$request->entorno,
                  "request"=>$request,
                  "sesion"=>Session::all(),
                  "menu_general"=>$request->menu_general,
                  "unidades"=>$unidades,
                //  "sustituciones"=>$datos,
                //  "jueces"=>$jueces,
                  ];
      return view('jueces.administracion_jueces', $elementos);

    }

    public function consulta_agenda_administracion( Request $request){



        $response = $request
        ->clienteWS_penal
        ->request('POST', 'consulta_agenda_jueces',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[
                    "id_unidad_gestion" => $request->id_unidad_gestion,
                    "tipo" => $request->tipo,
                    "fecha_desde" => isset($request->fecha_desde) ? $request->fecha_desde : null,
                    "fecha_hasta" => isset($request->fecha_hasta) ? $request->fecha_hasta : null,
                ]
            ]
        ]);
        $response = json_decode($response->getBody(),true) ;

        return $response;
    }

    public function inserta_agenda_administracion( Request $request){
        //Actualizacion
        if(strlen($request->id_evento) < 12){

            $response = $request
            ->clienteWS_penal
            ->request('POST', 'modifica_agenda_jueces',[
                "headers" => [
                    "sesion-id" => $request->session()->get("sesion-id"),
                    "cadena-sesion" => $request->session()->get("cadena-sesion"),
                    "usuario-id" => $request->session()->get("usuario-id"),
                    "Content-Type" => "application/json"
                ],
                "json"=>[
                    "datos"=>[
                        "id_evento"=>$request->id_evento,
                        "id_juez" => $request->id_juez,
                        "tipo" => $request->tipo,
                        "id_unidad_gestion" => $request->id_unidad_gestion,
                        "fecha_desde" => $request->fecha_ini,
                        "fecha_hasta" => $request->fecha_fin,
                        "comentarios_adicionales" => $request->descripcion,
                        "id_usuario_sesion" => $request->session()->get("usuario-id"),
                        "tipo_incidencia" => $request->tipo_incidencia,
                    ]
                ]
            ]);
            $response = json_decode($response->getBody(),true) ;

            return $response;

        }

        //Insertar
        else{
            $response = $request
            ->clienteWS_penal
            ->request('POST', 'inserta_agenda_jueces',[
                "headers" => [
                    "sesion-id" => $request->session()->get("sesion-id"),
                    "cadena-sesion" => $request->session()->get("cadena-sesion"),
                    "usuario-id" => $request->session()->get("usuario-id"),
                    "Content-Type" => "application/json"
                ],
                "json"=>[
                    "datos"=>[
                        "id_unidad_gestion" => $request->id_unidad_gestion,
                        "id_usuario_sesion" => $request->session()->get("usuario-id"),
                        "tipo" => $request->tipo,
                        "fecha_desde" => $request->fecha_ini,
                        "fecha_hasta" => $request->fecha_fin,
                        "id_juez" => $request->id_juez,
                        "tipo_incidencia" => $request->tipo_incidencia,
                        "comentarios_adicionales" => $request->descripcion,
                    ]
                ]
            ]);
            $response = json_decode($response->getBody(),true) ;

            return $response;
        }

    }

    public static function obtener_jueces_administracion(Request $request){

        $response = $request
        ->clienteWS_penal
        ->request('post', 'consulta_jueces',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[
                    "id_unidad_gestion" => $request->id_unidad_gestion,
                    "tipo"=>[5,14,15,35,92,93,94],
                ]
            ]
        ]);
        $jueces = json_decode($response->getBody(),true) ;

        return $jueces;
    }

    public function obtener_ugas_jueces(Request $request){
        $arr_unidades=catalogos::obtener_ugas_exhorto($request, $request->unidades);
        $unidades=Arr::sort($arr_unidades, 'id_unidad_gestion');

        return ['status'=>100, 'unidades'=>$unidades];
    }

    public function elimina_agenda_administracion( Request $request){

         $response = $request
        ->clienteWS_penal
        ->request('POST', 'elimina_agenda_jueces',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[
                    "id_agenda" => $request->id_agenda,
                    "estatus" => $request->estatus,
                ]
            ]
        ]);
        $response = json_decode($response->getBody(),true) ;

        return $response;

    }

    public function ver_recursos_adicionales(Request $request){

        $elementos=["entorno"=>$request->entorno,
                    "request"=>$request,
                    "sesion"=>Session::all(),
                    "menu_general"=>$request->menu_general,

                    ];
        // Aqui la demas logica
        return view('jueces.recursos_adicionales', $elementos);
    }

    public function consulta_grupos_jueces(Request $request){
        $arr_unidades=catalogos::obtener_ugas_exhorto($request, '8');
        $unidades=Arr::sort($arr_unidades, 'id_unidad_gestion');

        $elementos=["entorno"=>$request->entorno,
        "request"=>$request,
        "sesion"=>Session::all(),
        "menu_general"=>$request->menu_general,
        "unidades"=>$unidades,
        ];
        return view('jueces.grupos_jueces', $elementos);
    }


    ///Grupo de Jueces

    public  function consulta_jueces_administracion(Request $request){

        $response = $request
        ->clienteWS_penal
        ->request('post', 'consulta_jueces',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[
                    "id_unidad_gestion" => $request->id_unidad_gestion,
                    "tipo"=>[15],
                ]
            ]
        ]);
        $jueces = json_decode($response->getBody(),true) ;

        return $jueces;
    }

    public function consulta_unidades_gestion(Request $request){
        $response = $request
        ->clienteWS_penal
        ->request('post', 'ver_ugas',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[
                    "tipo"=>"8",
                ]
            ]
        ]);
        $response = json_decode($response->getBody(),true) ;
        return $response;
    }

    public function consulta_usuarios_administracion(Request $request){
        $response = $request
        ->clienteWS_penal
        ->request('post', 'consulta_jueces',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[
                    "id_unidad_gestion" => $request->id_unidad_gestion
                ]
            ]
        ]);
        $jueces = json_decode($response->getBody(),true) ;
        //dd($jueces);

        return $jueces;
    }



    public function agregar_usuario_jueces(Request $request){
        $response = $request
        ->clienteWS_penal
        ->request('post', 'inserta_grupos_jueces',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[
                    "grupo_juez"=>$request->grupo_juez,
                    "id_usuario_sesion"=>$request->session()->get("usuario-id"),
                ]
            ]
        ]);
        $jueces = json_decode($response->getBody(),true) ;

        return $jueces;
    }

    public function consulta_usuarios_x_juez(Request $request){
        $response = $request
        ->clienteWS_penal
        ->request('post', 'consulta_grupos_jueces',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[
                    "id_usuario_juez" => $request->id_juez
                ]
            ]
        ]);
        $jueces = json_decode($response->getBody(),true) ;

        return $jueces;
    }

    public function actualizar_usuarios_grupos_jueces(Request $request){
        $response = $request
        ->clienteWS_penal
        ->request('POST', 'actualizar_usuarios_grupos_jueces',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[
                    "id_grupo" => $request->id_grupo,
                    "id_usuario" => $request->id_usuario,
                ]
            ]
        ]);
        $response = json_decode($response->getBody(),true) ;

        return $response;
    }

    public function ver_grupos_jueces(Request $request){
        $response = $request
        ->clienteWS_penal
        ->request('GET', 'ver_grupos_jueces',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[
                    "id_unidad_gestion" => $request->id_unidad_gestion,
                ],
                "paginacion"=>[
                    "pagina"=>$request->pagina,
                    "registros_por_pagina"=>$request->registros_por_pagina
                ]
            ]
        ]);
        $jueces = json_decode($response->getBody(),true) ;

        return $jueces;
    }

    public function eliminarGrupo(Request $request){
        $response = $request
        ->clienteWS_penal
        ->request('POST', 'eliminarGrupo',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[
                    "id_grupo" => $request->id_grupo,
                ]
            ]
        ]);
        $response = json_decode($response->getBody(),true) ;

        return $response;
    }

}
