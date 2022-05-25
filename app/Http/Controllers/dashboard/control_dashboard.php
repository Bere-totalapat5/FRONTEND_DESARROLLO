<?php

namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\clases\archivos;
use App\Http\Controllers\clases\litigantes;
use App\Http\Controllers\clases\humanRelativeDate;
use App\Http\Controllers\clases\utilidades;
use App\Http\Controllers\clases\procesos_trabajo;
use Illuminate\Support\Facades\Session;
 
class control_dashboard extends Controller
{
    public function inicio( Request $request ){

        return redirect('/tareas');
        
        $lista_archivos=[];

        if($request->session()->get('tipo_usuario_descripcion')=='actuario'){
            return redirect('/notificaciones/sin_notificar/');
        }

        if($request->session()->get('juzgado_tipo')=='sala'){
            $datos['por_turnar']="";
            $datos['toca']="";
            $datos['anio_toca']="";
            $datos['asunto_toca']="";
            $datos['expediente']="";
            $datos['expediente_anio']="";
            $datos['involucrados_nombre']="";
            $datos['involucrados_apellido_paterno']="";
            $datos['involucrados_apellido_materno']="";
            $datos['registrado_desde']="";
            $datos['registrado_hasta']="";
            $datos['pagina']='1';
            $datos['registros_por_pagina']='10';
    
            //se carga el permiso de fecha de publicacion
            $bandera_modificar_toca=procesos_trabajo::obtener_valor_permiso_accion($request, 5);
            $bandera_turnar_toca=procesos_trabajo::obtener_valor_permiso_accion($request, 7);

            //$lista_archivos=archivos::obtener_listado_archivos($request, $datos);
            return view("dashboard.dashboard",
                    ["entorno"=>$request->entorno, 
                    "request"=>$request,
                    "sesion"=>$request->session()->all(),
                    "lista_archivos"=>$lista_archivos,
                    "bandera_modificar_toca"=>$bandera_modificar_toca,
                    "bandera_turnar_toca"=>$bandera_turnar_toca,
                    "ponencia"=>$request->session()->get('grupo_trabajo_identificar_area')
                    ]
                );
        }
        else{
            
            $datos['id_expediente']="";
            $datos['expediente']="";
            $datos['expediente_anio']="2020";
            $datos['involucrados_nombre']="";
            $datos['involucrados_apellido_paterno']="";
            $datos['involucrados_apellido_materno']="";
            $datos['registrado_desde']="";
            $datos['registrado_hasta']="";
            $datos['expediente_bis']='';
            $datos['pagina']='1';
            $datos['registros_por_pagina']='10'; 
    
            //$lista_archivos=archivos::obtener_listado_archivos_juzgados($request, $datos);
            $lista_archivos=[];
            
            return view("dashboard.dashboard_juzgado",
                    ["entorno"=>$request->entorno, 
                    "request"=>$request,
                    "sesion"=>$request->session()->all(),
                    "lista_archivos"=>$lista_archivos,
                    "ponencia"=>$request->session()->get('grupo_trabajo_identificar_area')
                    ]
                );
        }
    }
 
    //return response()->json(['success'=>'Got Simple Ajax Request.']);
    public function buscar_archivo_ajax( Request $request ){

        $input = $request->all();
        //return response()->json($input);
        unset($datos);
        if(isset($input['expediente'])){
            if($request->session()->get('juzgado_tipo')=='sala'){
                    
                ($input['toca']=="-") ? $datos['toca']="" : $datos['toca']=$input['toca'];
                ($input['anio_toca']=="0") ? $datos['anio_toca']="" : $datos['anio_toca']=$input['anio_toca'];
                ($input['asunto_toca']=="-") ? $datos['asunto_toca']="" : $datos['asunto_toca']=$input['asunto_toca'];
                $datos['por_turnar']=$input['bandera_toca_turnado'];
                ($input['expediente']=="-") ? $datos['expediente']="" : $datos['expediente']=$input['expediente'];
                ($input['anio_expediente']=="0") ? $datos['expediente_anio']="" : $datos['expediente_anio']=$input['anio_expediente'];
                ($input['involucrados_nombre']=="-") ? $datos['involucrados_nombre']="" : $datos['involucrados_nombre']=$input['involucrados_nombre'];
                ($input['involucrados_apellido_paterno']=="-") ? $datos['involucrados_apellido_paterno']="" : $datos['involucrados_apellido_paterno']=$input['involucrados_apellido_paterno'];
                ($input['involucrados_apellido_materno']=="-") ? $datos['involucrados_apellido_materno']="" : $datos['involucrados_apellido_materno']=$input['involucrados_apellido_materno'];
                ($input['fecha_desde']=="-") ? $datos['registrado_desde']="" : $datos['registrado_desde']=$input['fecha_desde'];
                ($input['fecha_hasta']=="-") ? $datos['registrado_hasta']="" : $datos['registrado_hasta']=$input['fecha_hasta'];
                ($input['pagina']=="-") ? $datos['pagina']="1" : $datos['pagina']=$input['pagina'];
                ($input['registros_por_pagina']=="-") ? $datos['registros_por_pagina']="10" : $datos['registros_por_pagina']=$input['registros_por_pagina'];

                $lista_archivos=archivos::obtener_listado_archivos($request, $datos);
                
                $humanRelativeDate = new humanRelativeDate();
                if(isset($lista_archivos['response'][0]['fecha_ingreso'])){
                    for($i=0; $i<count($lista_archivos['response']); $i++){

                        $fechaCreacion=$humanRelativeDate->getTextForSQLDate($lista_archivos['response'][$i]['fecha_ingreso']);
                        $lista_archivos['response'][$i]['fecha_humana']=$fechaCreacion;
                        $lista_archivos['response'][$i]['fecha_1']=utilidades::acomodarFechaMin($lista_archivos['response'][$i]['fecha_ingreso']);
                    }
                }
            }
            else{

                ($input['expediente']=="-") ? $datos['expediente']="" : $datos['expediente']=$input['expediente']; 
                ($input['anio_expediente']=="0") ? $datos['expediente_anio']="" : $datos['expediente_anio']=$input['anio_expediente'];
                ($input['involucrados_nombre']=="-") ? $datos['involucrados_nombre']="" : $datos['involucrados_nombre']=$input['involucrados_nombre'];
                ($input['involucrados_apellido_paterno']=="-") ? $datos['involucrados_apellido_paterno']="" : $datos['involucrados_apellido_paterno']=$input['involucrados_apellido_paterno'];
                ($input['involucrados_apellido_materno']=="-") ? $datos['involucrados_apellido_materno']="" : $datos['involucrados_apellido_materno']=$input['involucrados_apellido_materno'];
                ($input['fecha_desde']=="-") ? $datos['registrado_desde']="" : $datos['registrado_desde']=$input['fecha_desde'];
                ($input['fecha_hasta']=="-") ? $datos['registrado_hasta']="" : $datos['registrado_hasta']=$input['fecha_hasta'];
                $datos['id_expediente']="";
                $datos['expediente_bis']='';
                ($input['pagina']=="-") ? $datos['pagina']="1" : $datos['pagina']=$input['pagina'];
                ($input['registros_por_pagina']=="-") ? $datos['registros_por_pagina']="10" : $datos['registros_por_pagina']=$input['registros_por_pagina'];


                $lista_archivos=archivos::obtener_listado_archivos_juzgados($request, $datos);
                
                $humanRelativeDate = new humanRelativeDate();
                if(isset($lista_archivos['response'][0]['datos_archivo']['id_juicio'])){
                    for($i=0; $i<count($lista_archivos['response']); $i++){

                        $fechaCreacion=$humanRelativeDate->getTextForSQLDate($lista_archivos['response'][$i]['datos_archivo']['fecha_publicacion']);
                        $lista_archivos['response'][$i]['datos_archivo']['fecha_humana']=$fechaCreacion;
                        $lista_archivos['response'][$i]['datos_archivo']['fecha_1']=utilidades::acomodarFechaMin($lista_archivos['response'][$i]['datos_archivo']['fecha_publicacion']);
                    }
                }
            }
        }
        else{
            $lista_archivos=[];
        }
        //$lista_archivos=[];
        return response()->json($lista_archivos);
    }

    public function archivo_detalles_ajax( Request $request, $id ){

        if($request->session()->get('juzgado_tipo')=='sala'){
            $lista_archivos=archivos::obtener_archivo($request, $id);
            include "plantilla_archivo.php";
            return response()->json(['plantilla_archivo_header'=>$plantilla_archivo_header, 'plantilla_archivo_body'=>$plantilla_archivo_body]);
        }
        else{


            unset($datos);
            $datos['id_expediente']=$id;
            $datos['expediente']="";
            $datos['expediente_anio']="";
            $datos['expediente_bis']='';
            $datos['involucrados_nombre']="";
            $datos['involucrados_apellido_paterno']="";
            $datos['involucrados_apellido_materno']="";
            $datos['registrado_desde']="";
            $datos['registrado_hasta']="";
    
            $lista_archivos=archivos::obtener_listado_archivos_juzgados($request, $datos);
            $plantilla_archivo_body=print_r($lista_archivos, true);
            $plantilla_archivo_header="";

            include "plantilla_archivo_juzgado.php";
            return response()->json(['plantilla_archivo_header'=>$plantilla_archivo_header, 'plantilla_archivo_body'=>$plantilla_archivo_body]);
        }
    }

    public function notificacion_partes_ajax( Request $request ){

        $input = $request->all();
        $juicio_id=$input['id'];

        $lista_archivos=archivos::obtener_archivo($request, $input['id']);
        $plantilla_archivo_body=print_r($lista_archivos, true);
        $plantilla_archivo_header='';

        include "plantilla_info_notificacion.php";
        return response()->json(['plantilla_archivo_header'=>$plantilla_archivo_header, 'plantilla_archivo_body'=>$plantilla_archivo_body]);
    }

    public function notificacion_guardar_partes_ajax( Request $request ){
        $input = $request->all();

        unset($info);
        $info['tipo_expediente']=!is_null($input['tipo_expediente']) ? $input['tipo_expediente'] : '-' ;
        $info['toca']=!is_null($input['toca']) ? $input['toca'] : '-' ;
        $info['anio_toca']=!is_null($input['anio_toca']) ? $input['anio_toca'] : '-' ;
        $info['asunto_toca']=!is_null($input['asunto_toca']) ? $input['asunto_toca'] : '-' ;
        $info['expediente']=!is_null($input['expediente']) ? $input['expediente'] : '-' ;
        $info['anio']=!is_null($input['anio']) ? $input['anio'] : '-' ;
        $info['bis']=!is_null($input['bis']) ? $input['bis'] : '-' ;
        
        $partes=array();
        if(isset($input['arr_partes']['actor']) and count($input['arr_partes']['actor'])){
            if(count($input['arr_partes']['actor'])){
                for($i=0; $i<count($input['arr_partes']['actor']); $i++){
                    array_push($partes, $input['arr_partes']['actor'][$i]);
                }
            }
        }


        if(isset($input['arr_partes']['demandado']) and count($input['arr_partes']['demandado'])){
            for($i=0; $i<count($input['arr_partes']['demandado']); $i++){
                array_push($partes, $input['arr_partes']['demandado'][$i]);
            }
        }

        if(isset($input['arr_partes']['tercero']) and count($input['arr_partes']['tercero'])){
            for($i=0; $i<count($input['arr_partes']['tercero']); $i++){
                array_push($partes, $input['arr_partes']['tercero'][$i]);
            }
        }
        

        if($request->session()->get('juzgado_tipo')=='sala'){
            $lista=archivos::modificar_archivo($request, $input['juicio_id'], $info, $partes);
        }
        else{
            $lista=archivos::modificar_archivo_juzgado($request, $input['juicio_id'], $info, $partes);
        }
        return response()->json($lista);
    }

    public function turnar_toca_info_ajax( Request $request ){
        $input = $request->all();
        
        $plantilla_archivo_body=print_r($input, true);
        $plantilla_archivo_header='';

        include "plantilla_turnar_toca.php";

        return response()->json(['plantilla_archivo_header'=>$plantilla_archivo_header, 'plantilla_archivo_body'=>$plantilla_archivo_body]);
    }

    public function turnar_toca_guardar( Request $request ){
        $input = $request->all();
        $lista=archivos::turnar_toca($request, $input['expediente_id'], $input['ponencia'], '-');
        return response()->json($lista);
        
    }

    public function validar_litigante( Request $request ){
        $input = $request->all();
        $lista=litigantes::validarLitigante($request, $input['correo']);
        return response()->json($lista);
    }

    public function aviso_sesion( Request $request ){
        Session::put("bandera_avisos","0");
        return 1;
    }

}