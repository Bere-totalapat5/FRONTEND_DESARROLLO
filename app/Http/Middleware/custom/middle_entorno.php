<?php

namespace App\Http\Middleware\custom;

use Closure;
use App\Http\Controllers\clases\entorno;

class middle_entorno
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

        if( !entorno::validacion() ){
            return response("500 - Error en archivo de entornos",500);
        } else {
            $request->entorno = entorno::obtener_valores();
            $request->entorno_privado = entorno::obtener_valores_privados();
            
            return $next($request);
        }
    }
}
