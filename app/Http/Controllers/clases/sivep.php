<?php
namespace App\Http\Controllers\clases;

use Illuminate\Http\Request;
use DB;

class sivep{

    public static function mover_sivep(Request $request, $id_acuerdo){

        $response = $request
        ->clienteWS
        ->request('POST', 'mover_sivep',[
            "json" => [
                "datos" => [
                    "id_sentencia"=>$id_acuerdo,
                    "usuario_juzgado"=>$request->session()->get('usuario_juzgado')
                ]
            ],
            "headers" => [
                "Content-Type" => "application/json",
                "autorizacion" => "minutmanQAEtHReI",
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
            ]
        ]); 
        
        $response_menu = json_decode($response->getBody(),true) ;

        return $response_menu; 
    }

    public static function bandeja_sivep(Request $request, $estado){

        $response = $request
        ->clienteWS
        ->request('POST', 'bandeja_sivep',[
            "json" => [
                "datos" => [
                    "estado"=>$estado,
                    "usuario_juzgado"=>$request->session()->get('usuario_juzgado'),
                    "secretaria"=>$request->session()->get('usuario_secretaria')
                ]
            ],
            "headers" => [
                "Content-Type" => "application/json",
                "autorizacion" => "minutmanQAEtHReI",
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
            ]
        ]);
        
        $response_menu = json_decode($response->getBody(),true) ;
        return $response_menu;
    }

    public static function insertar_sicor_sivep(Request $request, $id_juicio, $id_acuerdo){

        $id_usuario=$request->session()->get("usuario-id");

        DB::table('acuerdo_datos_personales')->insert(
            ['id_juicio' => $id_juicio, 
            'id_acuerdo' => $id_acuerdo, 
            'id_usuario' => $id_usuario,
            'datos_personales_bandera' => 0,
            'create_date' => date('Y-m-d H:i:s')
            ]
        );


    }
    
}