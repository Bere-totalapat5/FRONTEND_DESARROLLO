<?php
namespace App\Http\Controllers\clases;

use Illuminate\Http\Request;
use DB;

class elementos_front{

    public static function obtener_menu_general(Request $request){

        $response = $request
        ->clienteWS_penal
        ->request('get', 'obtener_menus',[
            "form_params" => [
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id")
            ]
        ]);
        
        $response_menu = json_decode($response->getBody(),true) ;

        return $response_menu;
    }

    public static function obtener_notificacion_bandejas(Request $request){

        $response = $request
        ->clienteWS
        ->request('get', 'obtenerNotificacionesBandejas',[
            "form_params" => [
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id")
            ]
        ]);
        
        $response_menu = json_decode($response->getBody(),true) ;
        return $response_menu;
    }

    public static function obtener_dias_inhabiles(Request $request){

        $response = $request
        ->clienteWS_penal
        ->request('get', 'consultar_dias',[
            "form_params" => [
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "autorizacion" => "minutmanQAEtHReI"
            ],
            "json"=>[
                "datos"=>[
                    "anios"=>""
                ]
            ]
        ]);
        
        $response_dias = json_decode($response->getBody(),true) ;
        return $response_dias;
    }


    public static function obtener_notificacion_promociones(Request $request, $organo){

        $response = $request
        ->clienteWS
        ->request('get', 'demanprom_contadores_sin_procesar/'.$organo,[
            "form_params" => [
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "autorizacion" => "minutmanQAEtHReI"
            ]
        ]);
        
        $response_dias = json_decode($response->getBody(),true) ;
        return $response_dias;
    }


    public static function obtener_dia_habil_publicacion(Request $request){

        $response = $request
        ->clienteWS
        ->request('get', 'obtener_dia_habil_publicacion/',[
            "form_params" => [
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "autorizacion" => "minutmanQAEtHReI"
            ]
        ]);
        
        $response_dias = json_decode($response->getBody(),true) ;
        return $response_dias;
    } 


    public static function reseteo_pass(Request $request, $datos){

        $response = $request
        ->clienteWS
        ->request('PATCH', 'reseteo_pass/'.$request->session()->get("usuario-id"),[
            "json" => [
                "datos" => [
                    "pass" => $datos['pass']
                ]
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "autorizacion" => "minutmanQAEtHReI"
            ]
        ]);
        
        $response = json_decode($response->getBody(),true) ;
        return $response;
    } 
 
    public static function contadorSolicitudesSicor(Request $request){

        if(DB::connection()->getDatabaseName()){

            $juicio_sicor = DB::table('usuario_juicio AS uj')
            ->leftJoin('juicio AS j', 'j.id_juicio', '=', 'uj.id_juicio')
            ->leftJoin('juicio_partes AS jp', 'jp.id_juicio', '=', 'uj.id_juicio')
            ->leftJoin('informacionpersonal AS ip', 'ip.id_usuario', '=', 'uj.id_usuario')
            ->leftJoin('parte AS p1', 'p1.id_parte', '=', 'jp.id_parte1')
            ->leftJoin('parte AS p2', 'p2.id_parte', '=', 'jp.id_parte2')
            ->leftJoin('parte AS p3', 'p3.id_parte', '=', 'jp.id_parte3')
            ->leftJoin('juzgado AS jz', 'jz.codigo', '=', 'j.juzgado')
            ->where('j.juzgado', $request->session()->get("usuario_juzgado"))
            ->where('uj.estatus', 'like', 'por revisar')
            ->count();
    
            return $juicio_sicor;
        }
        return 0;   
    }

}