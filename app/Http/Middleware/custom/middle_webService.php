<?php

namespace App\Http\Middleware\custom;

use Closure;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;

class middle_webService
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

        $cliente = new Client([
            "base_uri" => $request->entorno_privado["ws_uri_backend"]["uri"] 
        ]);
        $request->clienteWS = $cliente;

        $cliente_penal = new Client([
            "base_uri" => $request->entorno_privado["ws_uri_backend"]["uri_penal"] 
        ]);
        $request->clienteWS_penal = $cliente_penal;

        return $next($request);
        
    }
}