<?php

namespace App\Http\Middleware\custom;

use Closure;
use App\Http\Controllers\clases\elementos_front;
use App\Http\Controllers\clases\procesos_trabajo;
use App\Http\Controllers\clases\notificaciones;
use App\Http\Controllers\clases\edictos;
use App\Http\Controllers\clases\avisos;

class middle_elementos_front
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request 
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) 
    {
        //se carga el menu de opciones
        try{
            $request->menu_general=elementos_front::obtener_menu_general($request);
        }
        catch (\Exception $e) { 

        }
       
        //se revisa la sesion, si es -1 se manada al login
        //dd($request->menu_general);
        if($request->menu_general==null){
            $request->session()->flush();
            return back()->with('error', "Error en asignación de juzgado.");

        }
        else if($request->menu_general['status']==-1){
            $request->session()->flush();
            $uri = $request->path();
            if($uri!='/'){
                if(!isset($_GET['next'])){
                    return redirect('/?next='.$request->path());
                }
            }
            else{
                return redirect('/');
            }
        }else if(!isset($request->menu_general['response'])){
            return redirect('/menu_permisos');
        }
  

        //dd($request->menu_general); 

        //si todo esta bien, se carga todo el contenido de la pagina web
        // $request->notificaciones_bandeja=elementos_front::obtener_notificacion_bandejas($request);
        // $request->notificacion_promociones=elementos_front::obtener_notificacion_promociones($request, $request->session()->get('usuario_juzgado') ); activo en sigj 
        $request->dias_inhabiles=elementos_front::obtener_dias_inhabiles($request);
        // $request->proxima_publicacion=elementos_front::obtener_dia_habil_publicacion($request);
        // $request->solicitudes_count=procesos_trabajo::obtener_solicitudes_count($request);
        // $request->electronicas_count=notificaciones::contadores_notificacion_acuerdo($request);
        // $request->electronicas_fisicas_count=notificaciones::contadores_notificacion_electronica($request);
        // $request->avisos=avisos::obtener_avisos_juz($request, $request->session()->get('juzgado_tipo'), $request->session()->get('usuario_juzgado')); activo en sigj
        $request->num_solicitudes_sicor="N"; 

        if($request->session()->get('sesion_tipo')=='soporte'){
            //dd($request->avisos);
        }
        //$request->num_solicitudes_sicor=elementos_front::contadorSolicitudesSicor($request);
        //Archivo Judicial
        /*  
        unset($datos);
        $datos['modo']='contador';
        $datos['pagina']='1';
        $datos['registros_por_pagina']='1000';
        $request->archivoJudicial_count=archivo_judicial::juicios_para_archivo_judicial($request, $datos);
        */

        //edictos
        unset($datos_edicto);
        $datos_edicto['modo']='contador';
        $datos_edicto['fecha_publicacion_edicto']='';
        $datos_edicto['edicto_estatus']='nuevo';
        $datos_edicto['modo_acuerdo']='con_fecha';
        $datos_edicto['num_expediente']='';
        $datos_edicto['anio_expediente']='';
        $datos_edicto['id_edicto']='';
        // $request->edictos_nuevo_count=edictos::listar_edictos($request, $datos_edicto); activo en sigj
        $datos_edicto['modo_acuerdo']='';
        $datos_edicto['edicto_estatus']='aprobado';
        // $request->edictos_aprobado_count=edictos::listar_edictos($request, $datos_edicto); activo sigj
        $datos_edicto['edicto_estatus']='por pagar';
        // $request->edictos_por_pagar_count=edictos::listar_edictos($request, $datos_edicto); activo sigj
        $datos_edicto['edicto_estatus']='publicado';
        // $request->edictos_publicado_count=edictos::listar_edictos($request, $datos_edicto);

        unset($datos_edicto);
        $datos_edicto['modo']='contador';
        $datos_edicto['id_edicto']='';
        // $request->edictos_por_revisar_count=edictos::edicto_bandejas($request, $datos_edicto);


        //$request->electronicas_fisicas_correcion_count=notificaciones::contadores_notificacion_electronica_correcciones($request);
        
        //dd($request->electronicas_fisicas_correcion_count);
        //$request->electronicas_fisica_count=litigantes::obtener_notificaciones_fisicas($request);
        

        //dd($request->electronicas_fisica_count);
        //dd(elementos_front::obtener_menu_general($request));

        //arreglo simple días inhabiles
        $dias_festivos_arr=array();
        if(isset($request->dias_inhabiles["response"])){
            for ($i=0; $i < count($request->dias_inhabiles["response"]) ; $i++) { 
                $dias_festivos_arr[$i]=$request->dias_inhabiles["response"][$i]['fecha'];
            }
        }
        //cerrar el fin de semana
        $day = date('N');
        if($day==6 or $day==7){
            // $dias_festivos_arr[$i]=date('Y-m-d');
        }

        $request->dias_festivos_arr=$dias_festivos_arr;

        //se prepara la fecha front
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $meses_min = array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
        $fecha = date('Y-m-d');
        $fecha_arr=explode('-', $fecha);

        $mes = $meses[$fecha_arr[1]-1];
        $fecha_desktop=$mes . ' ' . $fecha_arr[2] . ' de ' . $fecha_arr[0];
        $fecha_movil=$fecha_arr[2].'-'.$meses_min[$fecha_arr[1]-1].'-'.$fecha_arr[0];

        //se envian las fechas al front
        $request->fecha_desktop=$fecha_desktop;
        $request->fecha_movil=$fecha_movil;
        $request->$fecha=$fecha;
        
        //se carga la librería para el idioma
        // include('lang/'.$request->session()->get('juzgado_tipo').'.php'); activo sigj
        // $request->lang=$lang; activo sigj

        return $next($request);
        
    }
}

