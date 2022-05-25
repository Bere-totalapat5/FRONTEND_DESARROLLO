<?php
namespace App\Http\Controllers\clases;

use Illuminate\Http\Request;

class libros_front{

    public static function guardarLibroPromocionesJFO(Request $request, $datos){

        $response = $request
        ->clienteWS
        ->request('GET', 'promocion_externa',[
            "query" => [ 
                "datos" => [
                    "juzgado_subtipo"=>$datos['juzgado_subtipo'],
                    "juzgado_tipo"=>$datos['juzgado_tipo'],
                    "usuario_juzgado"=>$datos['usuario_juzgado'],
                    "usuario_id"=>$datos['usuario_id'],
                    "id_juzgado"=>$datos['id_juzgado'],
                    "expediente"=>$datos['expediente'],
                    "anio"=>$datos['anio'],
                    "bis"=>$datos['bis'],
                    "fecha_recepcion"=>$datos['fecha_recepcion'],
                    "hora_recepcion"=>$datos['hora_recepcion'],
                    "info_anexos"=>$datos['info_anexos']

                    

                    /*
                    "anio_judicial"=>$datos['anio_judicial']
                    "promovente"=>$datos['promovente'],
                    "paterno_fisica"=>$datos['paterno_fisica'],
                    "materno_fisica"=>$datos['materno_fisica'],
                    "nombre_fisica"=>$datos['nombre_fisica'],
                    "razon_social"=>$datos['razon_social'],
                    "observaciones"=>$datos['observaciones']
                    */
                ]
            ]
        ]);
        
        $response_menu = json_decode($response->getBody(),true);
        return $response_menu;
    }

    
}