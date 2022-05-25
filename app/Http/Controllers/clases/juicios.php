<?php
namespace App\Http\Controllers\clases; 

use Illuminate\Http\Request;
use Session;

class juicio{

    public static function buscar_expediente($datos,Request $request){

        $respuestaA =$request
        ->clienteWS->request('get', 'buscar_expediente/'. Session::get('usuario_juzgado'), [
                "headers"     => [
                    "usuario-id"    => Session::get("usuario-id"),
                    "cadena-sesion" => Session::get("cadena-sesion"),
                    "sesion-id"     => Session::get("sesion-id"),
                ],
                "query" => [
                    "datos" => $datos,
                ],
            ]);

        $respuesta = json_decode($respuestaA->getBody(), true);

        return $respuesta;
    }

}