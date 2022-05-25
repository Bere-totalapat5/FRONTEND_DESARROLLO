<?php

namespace App\Http\Middleware\custom;

use Closure;
use App\Http\Controllers\clases\elementos_front;

class middle_elementos_front_estadistica
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
        }

        //dd($request->menu_general);

        //si todo esta bien, se carga todo el contenido de la pagina web
        $request->dias_inhabiles=elementos_front::obtener_dias_inhabiles($request);

        //arreglo simple días inhabiles
        $dias_festivos_arr=array();
        for ($i=0; $i < count($request->dias_inhabiles["response"]) ; $i++) { 
            $dias_festivos_arr[$i]=$request->dias_inhabiles["response"][$i]['dia_no_laboral_fecha'];
        }
        //cerrar el fin de semana
        $day = date('N');
        if($day==6 or $day==7){
            $dias_festivos_arr[$i]=date('Y-m-d');
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
        

        return $next($request);
        
    }
}

