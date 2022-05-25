<?php

namespace App\Http\Controllers\procesosTrabajo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\clases\procesos_trabajo;
use App\Http\Controllers\clases\acuerdos;

class control_ministerioLey extends Controller
{
    public function inicio_ministerioLey( Request $request ){

        $lista=procesos_trabajo::obtener_ministerioLey_lista($request);
        if(!isset($lista['response'][0]['id_ministerio'])){
            $lista=array();
            $id_ministerio=0;
        }
        else{
            $id_ministerio=$lista['response'][0]['id_ministerio'];
        }

        return view(    "procesosTrabajo.ministerioLey",
                        ["entorno"=>$request->entorno, 
                        "request"=>$request,
                        "sesion"=>$request->session()->all(),
                        "menu_general"=>$request->menu_general,
                        "lista"=>$lista,
                        "id_ministerio"=>$id_ministerio
                        ]
                    );

    }

    public function cargar_ministerioLey_ajax( Request $request ){
        $input = $request->all();

        //se obtiene la info del ministerio
        $id_ministerio=$input['id_ministerio'];
        if(isset($input['id_usuario'])){
            $id_usuario=$input['id_usuario'];
        }
        else{
            $id_usuario=0;
        }

        if(isset($input['estatus'])){
            $estatus=$input['estatus'];
        }
        else{
            $estatus=0;
        }

        $lista=procesos_trabajo::obtener_ministerio_lista($request);

        $plantilla_archivo_body=print_r($lista, true);
        $plantilla_archivo_header='';
        include "plantilla_agregar_usuario_ministerioLey.php";

        return response()->json(['plantilla_archivo_header'=>$plantilla_archivo_header, 'plantilla_archivo_body'=>$plantilla_archivo_body]);
    }


    public function guardar_ministerioLey( Request $request ){
        $input = $request->all();
        //se edita
        if($input['id_ministerio']!=0){

            unset($datos);
            $datos['sustituyente']=$input['por_id'];
            $datos['fecha_inicio']=$input['fecha_inicial'];
            $datos['fecha_termino']=$input['fecha_hasta'];
            $datos['activo']=(isset($input['activo'])) ? $input['activo'] : '0';

            if(isset($input['migracion']) and $datos['activo']==0){
                procesos_trabajo::ministerio_regresar_firmas($request, $request->session()->get('usuario_id'), $input['por_id']); 
            }
            
            $lista=procesos_trabajo::editar_ministerioLey($request, $input['id_ministerio'], $datos); 

            //se migran los acuerdos por firmar
            if(isset($input['migracion']) and $datos['activo']==1){
                procesos_trabajo::ministerio_migrar_firmas($request, $request->session()->get('usuario_id'), $input['por_id']); 
            }
            

            //se rompe la sesion
            $response = $request
                        ->clienteWS
                        ->request('DELETE', 'logout',[
                            "query" => [ 
                            ],
                            "headers" => [
                                "sesion-id" => $request->session()->get("sesion-id"),
                                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                                "usuario-id" => $request->session()->get("usuario-id")
                            ]
                        ]);
            $response = json_decode($response->getBody(),true) ;

            $request->session()->flush();
            return back();
        } 
        else{
        
            $datos['id_titular']=$request->session()->get('usuario_id');
            $datos['id_sustituyente']=$input['por_id'];
            $datos['fecha_inicio']=$input['fecha_inicial'];
            $datos['fecha_termino']=$input['fecha_hasta'];
            $datos['activo']=(isset($input['activo'])) ? $input['activo'] : '0';
            
            if(isset($input['migracion']) and $datos['activo']==0){
                procesos_trabajo::ministerio_regresar_firmas($request, $request->session()->get('usuario_id'), $input['por_id']); 
            }

            $lista=procesos_trabajo::agregar_ministerioLey($request, $datos);

            //se migran los acuerdos por firmar
            if(isset($input['migracion']) and $datos['activo']==1){
                procesos_trabajo::ministerio_migrar_firmas($request, $request->session()->get('usuario_id'), $input['por_id']); 
            }
            


            //se rompe la sesion
            $response = $request
                        ->clienteWS
                        ->request('DELETE', 'logout',[
                            "query" => [ 
                            ],
                            "headers" => [
                                "sesion-id" => $request->session()->get("sesion-id"),
                                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                                "usuario-id" => $request->session()->get("usuario-id")
                            ]
                        ]);
            $response = json_decode($response->getBody(),true) ;

            $request->session()->flush();
            return back();
        }

    }

    public function solicitudes_cabiar_estatus( Request $request ){
        $input = $request->all();
        $id=$input['id'];
        $estatus=$input['estatus'];

        $lista=procesos_trabajo::cambiar_solicitudes_estatus($request, $id, $estatus);
        return response()->json([$lista]);
    }
    
} 