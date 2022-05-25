<?php

namespace App\Http\Middleware\custom;
use Closure;
use App\Http\Controllers\clases\utilidades;

class middle_sesion
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
        $uri = $request->path();
        $url = $request->fullUrl();
        // dd($uri);
        
       //dd($request->path());
       //dd(url()->full());

        if (!$request->session()->has('usuario_id')) {

            if($uri!='/'){
                if(!isset($_GET['next'])){
                    return redirect('/?next='.$request->path());
                }
                else{
                    return $next($request); 
                }
            }
            else{
                return $next($request);
            }
            
        } else {
           
            $input = $request->all(); 
            //utilidades::guardarLog($request, 'navegacion/'.$request->session()->get('usuario_id'), '0', 0, $url."\t\n".print_r($input, true), 0);
            //dd($uri);
            //dd($request);
            //se revisa la sesion con el back
            if($uri!='/'){
                return $next($request);
            } 
            else{
                if($request->session()->get('tipo_usuario_descripcion')=="oralidad"){
                    return redirect("/oralidad/calendario/");
                }
                else if($request->session()->get('tipo_usuario_descripcion')=="estadistica"){
                    return redirect("/estadistica");
                }
                else if($request->session()->get('tipo_usuario_descripcion')=="anales"){
                    return redirect("/anales");
                }
                else{
                    return redirect('/home');
                    
                }
            }
        }
    }
}
