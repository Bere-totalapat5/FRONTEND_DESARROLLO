<?php

namespace App\Http\Controllers\sustituciones;


use App\Http\Controllers\Controller;
use App\Http\Controllers\clases\catalogos;
use App\Http\Controllers\clases\export;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Session;

class SustitucionesController_h extends Controller
{                           //VISTAS VISTAS VISTAS VISTAS

    public function ver_sustituciones(Request $request){

        $arr_unidades=catalogos::obtener_ugas_exhorto($request, $request->unidades);
       $unidades=Arr::sort($arr_unidades, 'id_unidad_gestion');

          $sustituciones = $this->obtener_sustituciones($request);
          $sustituciones_jueces=[];

            if(isset($sustituciones['response'])){
                foreach($sustituciones['response'] as $sustitucion){

                    $datos_sustitucion=[
                        "id"=> strval($sustitucion['id_sustitucion']),
                        "start_date"=>$sustitucion['fecha_inicio'],
                        "end_date"=>$sustitucion['fecha_fin'],
                        "text"=>"(".$sustitucion['usuario_titular'].") ".$sustitucion['nombre_usuario_titular']." es sustituido por (".$sustitucion['usuario_sustituye'].") ".$sustitucion['nombre_usuario_sustituye'],
                        "descripcion"=>$sustitucion['descripcion'],
                        "unidad"=>$sustitucion['nombre_unidad'],
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
            ];

      $elementos=["entorno"=>$request->entorno,
                  "request"=>$request,
                  "sesion"=>Session::all(),
                  "menu_general"=>$request->menu_general,
                  "unidades"=>$unidades,
                  "sustituciones"=>$datos,

                  ];
      return view('sustituciones.sustituciones', $elementos);

    }


    public function obtener_sustituciones( Request $request){



        $response = $request
        ->clienteWS_penal
        ->request('POST', 'consulta_sustituciones',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[]
            ]
        ]);
        $response = json_decode($response->getBody(),true) ;

        return $response;
    }



    public function registrar_sustitucion( Request $request){



         $response = $request
        ->clienteWS_penal
        ->request('POST', 'inserta_sustitucion',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[
                    "id_usuario_titular" => $request->id_usuario_titular,
                    "id_usuario_sustituye" => $request->id_usuario_sustituye,
                    "id_unidad_gestion" => $request->id_unidad_gestion,
                    "fecha_ini" => $request->fecha_ini,
                    "fecha_fin" => $request->fecha_fin,
                    "descripcion" => $request->descripcion,
                    "id_usuario_sesion" => $request->session()->get("usuario-id"),
                ]
            ]
        ]);
        $response = json_decode($response->getBody(),true) ;

        return $response;

    }


    public static function usuarios_sustitucion(Request $request){

        $response = $request
        ->clienteWS_penal
        ->request('post', 'consulta_usuarios',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[
                    "id_unidad_gestion" => $request->id_unidad_gestion,
                   // "tipo" => [5,14,35],
                ],
            ]
        ]);
        $response = json_decode($response->getBody(),true) ;

        return $response;
    }



    public function modifica_agenda_sustitucion( Request $request){

        $datos = [
            "id_usuario_sesion" => $request->session()->get("usuario-id"),
            "id_sustitucion" => $request->id_sustitucion,
            "id_usuario_titular" => $request->id_usuario_titular,
            "id_usuario_sustituye" => $request->id_usuario_sustituye,
            "fecha_ini" => $request->fecha_ini,
            "fecha_fin" => $request->fecha_fin,
            "estatus" => $request->estatus,
        ];

        // return $datos;

        $response = $request
       ->clienteWS_penal
       ->request('POST', 'modifica_sustitucion',[
           "headers" => [
               "sesion-id" => $request->session()->get("sesion-id"),
               "cadena-sesion" => $request->session()->get("cadena-sesion"),
               "usuario-id" => $request->session()->get("usuario-id"),
               "Content-Type" => "application/json"
           ],
           "json"=>[
               "datos" => $datos
           ]
       ]);
       $response = json_decode($response->getBody(),true) ;

       return $response;

  }





}
