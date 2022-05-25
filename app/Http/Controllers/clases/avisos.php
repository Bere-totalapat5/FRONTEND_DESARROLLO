<?php
namespace App\Http\Controllers\clases;
use Illuminate\Http\Request;

class avisos{

    public static function obtener_avisos_juz( Request $request, $tipo, $juzgado ){

         //se obtiene la lista de archivos
         $response = $request
         ->clienteWS
         ->request('get', 'obtener_avisos_juz/'.$tipo.'/'.$juzgado,[
             "query" => [

             ],
             "headers" => [
                 "sesion-id" => $request->session()->get("sesion-id"),
                 "cadena-sesion" => $request->session()->get("cadena-sesion"),
                 "usuario-id" => $request->session()->get("usuario-id"),
                 "Content-Type" => "application/json"
             ]
         ]);
         $lista = json_decode($response->getBody(),true) ;
         return $lista;

    }

}