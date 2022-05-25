<?php
namespace App\Http\Controllers\clases;

use Illuminate\Http\Request;

class menu_web{

    public static function obtener_menu(Request $request){

        //dd($request);


        $response = $request
        ->clienteWS
        ->request('get', 'menus',[
            "query" => [
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id")
            ]
        ]);
        
        $response_menu = json_decode($response->getBody(),true) ;
        //dd($request->session()->all());
        //dd($response_menu);
        return $response_menu;
    }
}