<?php

namespace App\Http\Controllers\usuarios;

use App\Http\Controllers\clases\archivos;
use App\Http\Controllers\Controller;
use App\Http\Controllers\clases\catalogos;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Http\Controllers\clases\export;
use Session;

class usuariosController extends Controller
{
  public function consulta_usuarios(Request $request){
      try {
        $id_usuario = Session::get('usuario_id');

        $response = $request
        ->clienteWS_penal
        ->request('get', 'obtener_acciones_vista'."/".$id_usuario."/21",[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ]

        ]);
        $acciones = json_decode($response->getBody(),true);
        $accion = $acciones['response'];
        $response = $request
        ->clienteWS_penal
        ->request('POST', 'ver_ugas',[
            "json"=>[
                "datos"=>[
                    "tipo"=>'5'
                ]
            ]
        ]);

        $response = json_decode($response->getBody(),true);
        $unidades = $response['response'];
        $response = $request
        ->clienteWS_penal
        ->request('POST', 'tipo_usuario');
        $response = json_decode($response->getBody(),true);
        $tipos_usuario = $response['response'];

        $elementos=["entorno"=>$request->entorno,
                    "request"=>$request,
                    "sesion"=>Session::all(),
                    "menu_general"=>$request->menu_general,
                    "tipos_usuario"=> $tipos_usuario,
                    "unidades"=> $unidades,
                    "acciones"=>$accion
                    ];
        return view('usuarios.usuarios', $elementos);
      } catch (\Exception $e) {
          return response()->json(['status' => 0, 'data' => $e->getMessage()]);
      }
  }

  public function exportar_busqueda_usuarios(Request $request){
        $file = new export();
        $out = isset($request->out) ? $request->out : 'B64';
        $respuesta = $this->consulta_usuarios_filtros($request);

        if($respuesta['status'] == 100){
            $data = $respuesta['response'];
        }else{
            //return $respuesta;
            $data = [[
                "usuario" => 'Sin datos' ,
                "nombres" => 'Sin datos' ,
                "nombre_unidad" => 'Sin datos' ,
                "descripcion" => 'Sin datos' ,
                "correo" => 'Sin datos' ,
                "cve_juez" => 'Sin datos' ,
                "origen" => 'Sin datos' ,
                ]];
        }

        $header = [];
        if( isset($request->orden_columnas) && !empty($request->orden_columnas) ){
            foreach($request->orden_columnas as $c){
                $header[$c['campo']]=$c['titulo'];
            }
            if( true ){ $header['origen']= "Origen"; }
        }else{
            $header = [
                "id_usuario" => "ID Usuario" ,
                "usuario" =>  "Usuario" ,
                "nombres" =>  "Nombre" ,
                "nombre_unidad" =>  "Unidad" ,
                "descripcion" =>  "Tipo" ,
                "correo" =>  "Correo" ,
                "cve_juez" =>  "Clave" ,
                "origen" =>  "Origen" ,
            ];
        }

        $file->set_tema('sigj_penal');
        $file->set_report_title('Usuarios');
        $file->set_sheet_title('Hoja 1');
        $file->set_header($header );
        $file->set_data($data);
        $file->set_position_sheet('horizontal');
        return $file->get_file($request->extension, $out);
        //dd('llegaste');
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

  public function consulta_usuarios_filtros(Request $request){
      try {
                $response = $request
                ->clienteWS_penal
                ->request('POST', 'consulta_usuarios',[
                    "headers" => [
                        "sesion-id"     => $request->session()->get("sesion-id"),
                        "cadena-sesion" => $request->session()->get("cadena-sesion"),
                        "usuario-id"    => $request->session()->get("usuario-id"),
                        "Content-Type"  => "application/json"
                    ],
                    "json"=>[
                        "datos"=>[
                            "id_tipo_usuario"   => $request->id_tipo_usuario,
                            "id_unidad_gestion" => $request->id_unidad_gestion,
                            "usuario"           => $request->usuario,
                            "nombre_busqueda"   => $request->nombre_busqueda
                         ], "paginacion" =>[
                            "registros_por_pagina" => $request->registros_por_pagina,
                            "pagina" => $request->pagina]
                    ]
                ]);
                $response = json_decode($response->getBody(),true) ;

      return $response;
      } catch (\Exception $e) {
          return response()->json(['status' => 0, 'data' => $e->getMessage()]);
      }
  }

  public function guardar_usuario(Request $request){
      try {
        $id_usuario_sesion = Session::get('usuario_id');

                $ids_tipo_usuario = $request->id_tipo_usuario;

                $response = $request
                ->clienteWS_penal
                ->request('POST', 'crear_usuario',[
                    "headers" => [
                        "sesion-id" => $request->session()->get("sesion-id"),
                        "cadena-sesion" => $request->session()->get("cadena-sesion"),
                        "usuario-id" => $request->session()->get("usuario-id"),
                        "Content-Type" => "application/json"
                    ],
                    "json"=>[
                        "datos"=>[
                            "id_usuario_sesion"=> $id_usuario_sesion,
                            "id_tipo_usuario"=>$ids_tipo_usuario,
                            "id_unidad_gestion"=>$request->id_unidad_gestion,
                            "usuario"=>$request->usuario,
                            "password"=>$request->password,
                            "nombres"=>$request->nombres,
                            "apellido_paterno"=>$request->apellido_paterno,
                            "apellido_materno"=>$request->apellido_materno,
                            "correo"=>$request->correo,
                            "titulo"=>$request->titulo,
                            "m_genero"=>$request->m_genero,
                            "celular"=>$request->celular,
                            "notificacion_telegram"=>$request->notificacion_telegram,
                            "sistema_origen"=>$request->sistema_origen,
                            "cve_juez" => $request->cve_juez,
                        ]
                       ]
                     ]);

                $response = json_decode($response->getBody(),true) ;
                return $response;
           }
      catch (\Exception $e) {
          return response()->json(['status' => 0, 'data' => $e->getMessage()]);
      }
  }

  public function tipo(Request $request){
      try {
                $response = $request
                ->clienteWS_penal
                ->request('POST', 'ver_ugas',[
                    "headers" => [
                        "sesion-id" => $request->session()->get("sesion-id"),
                        "cadena-sesion" => $request->session()->get("cadena-sesion"),
                        "usuario-id" => $request->session()->get("usuario-id"),
                        "Content-Type" => "application/json"
                    ],
                    "json"=>[
                        "datos"=>[
                            "tipo"=> $request->tipo
                        ]
                    ]
                ]);

                $response = json_decode($response->getBody(),true) ;
                return $response;

      } catch (\Exception $e) {
          return response()->json(['status' => 0, 'data' => $e->getMessage()]);
      }
  }

  public function guardar_cambios(Request $request){
   try {

        $id_usuario_sesion = Session::get('usuario_id');
                $response = $request
                ->clienteWS_penal
                ->request('POST', 'modificar_datos_usuario',[
                    "headers" => [
                        "sesion-id" => $request->session()->get("sesion-id"),
                        "cadena-sesion" => $request->session()->get("cadena-sesion"),
                        "usuario-id" => $request->session()->get("usuario-id"),
                        "Content-Type" => "application/json"
                    ],
                    "json"=>[
                        "datos"=>[
                            "id_usuario_sesion"=> $id_usuario_sesion,
                            "id_usuario" =>$request->id_usuario,
                            "id_tipo_usuario"   =>$request->id_tipo_usuario,
                            "id_unidad_gestion" =>$request->id_unidad_gestion,
                            "password"=>$request->password,
                            "nombres" =>$request->nombres,
                            "apellido_paterno"=>$request->apellido_paterno,
                            "apellido_materno"=>$request->apellido_materno,
                            "correo"     =>$request->correo,
                            "titulo"     =>$request->titulo,
                            "estatus"    =>$request->estatus,
                            "reset_pass" =>$request->reset_pass,
                            "cve_juez"   =>$request->cve_juez,
                        ]
                    ]
                ]);
                $response = json_decode($response->getBody(),true) ;

      return $response;
      } catch (\Exception $e) {
          return response()->json(['status' => 0, 'data' => $e->getMessage()]);
      }
  }

  public function ver_usuario(Request $request){
      try {

        $id_usuario_sesion = Session::get('usuario_id');

                $response = $request
                ->clienteWS_penal
                ->request('POST', 'consulta_usuario_id',[
                    "headers" => [
                        "sesion-id" => $request->session()->get("sesion-id"),
                        "cadena-sesion" => $request->session()->get("cadena-sesion"),
                        "usuario-id" => $request->session()->get("usuario-id"),
                        "Content-Type" => "application/json"
                    ],
                    "json"=>[
                        "datos"=>[
                            "id_usuario"=> $request->id_usuario
                        ]
                    ]
                ]);
                $response = json_decode($response->getBody(),true) ;

      return $response;
      } catch (\Exception $e) {
          return response()->json(['status' => 0, 'data' => $e->getMessage()]);
      }
  }

  public function generar_usuarios(Request $request){
      try {
                $response = $request
                ->clienteWS_penal
                ->request('POST', 'generar_nombre_usuario',[
                    "headers" => [
                        "sesion-id" => $request->session()->get("sesion-id"),
                        "cadena-sesion" => $request->session()->get("cadena-sesion"),
                        "usuario-id" => $request->session()->get("usuario-id"),
                        "Content-Type" => "application/json"
                    ],
                    "json"=>[
                        "datos"=>[
                            "nombres"=> $request->nombres,
                            "apellido_paterno"=> $request->apellido_paterno,
                            "apellido_materno"=> $request->apellido_materno
                        ]
                    ]
                ]);
                $response = json_decode($response->getBody(),true) ;

      return $response;
      } catch (\Exception $e) {
          return response()->json(['status' => 0, 'data' => $e->getMessage()]);
      }
  }

  public function cambio_adscripcion(Request $request){
      try {
                $response = $request
                ->clienteWS_penal
                ->request('POST', 'cambio_adscripcion',[
                    "headers" => [
                        "sesion-id" => $request->session()->get("sesion-id"),
                        "cadena-sesion" => $request->session()->get("cadena-sesion"),
                        "usuario-id" => $request->session()->get("usuario-id"),
                        "Content-Type" => "application/json"
                    ],
                    "json"=>[
                        "datos"=>[
                            "id_usuario_sesion"=> $request->session()->get("usuario-id"),
                            "id_usuario"=> $request->id_usuario,
                            "id_unidad_gestion"=> $request->id_unidad_gestion,
                            "id_tipo_usuario"=> $request->id_tipo_usuario

                        ]
                    ]
                ]);
                $response = json_decode($response->getBody(),true) ;

      return $response;
      } catch (\Exception $e) {
          return response()->json(['status' => 0, 'data' => $e->getMessage()]);
      }
  }

  public function consulta_tipos_audiencia(Request $request){

    $elementos=["entorno"=>$request->entorno,
                "request"=>$request,
                "sesion"=>Session::all(),
                "menu_general"=>$request->menu_general
                ];

    return view('usuarios.tipos_audiencia',$elementos);

  }

  public function consulta_tas( Request $request ){

      $response = $request
      ->clienteWS_penal
      ->request('POST', 'consulta_ta',[
          "headers" => [
              "sesion-id" => $request->session()->get("sesion-id"),
              "cadena-sesion" => $request->session()->get("cadena-sesion"),
              "usuario-id" => $request->session()->get("usuario-id"),
              "Content-Type" => "application/json"
          ],
          "json"=>[
              "datos"=>[
                  "tipo_atencion"=>$request->tipo_atencion,
                  "tipo_audiencia"=>$request->tipo_audiencia,
                  "codigo"=>$request->codigo
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

}
