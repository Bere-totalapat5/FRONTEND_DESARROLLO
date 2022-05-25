<?php
namespace App\Http\Controllers\clases;

use Illuminate\Http\Request;

class notificaciones{

    public static function envio_correos(Request $request, $datos){

        $response = $request
        ->clienteWS
        ->request('POST', 'registra_correo',[
            "json" => [
                "datos" => [
                    "correos"=>$datos
                ]
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id")
            ]
        ]);
        
        $response_menu = json_decode($response->getBody(),true);
        return $response_menu;
    }

    /*
    *   APP NORIFICACIONES
    */
 
    //resumen
    public static function acuerdo_notificaciones_detalles(Request $request, $id){
       
        $response_guardar = $request
        ->clienteWS
        ->request('GET', 'acuerdo_notificaciones_detalles/'.$id,[
            "json" => [
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id")
            ]
        ]);

        $lista = json_decode($response_guardar->getBody(),true);
        return $lista;
    }

    public static function obtener_notificacion_electronica_correcciones(Request $request, $bandeja){
       
        $response_guardar = $request
        ->clienteWS
        ->request('GET', 'obtener_notificacion_electronica_correcciones/'.$bandeja,[
            "json" => [
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id")
            ]
        ]);

        $lista = json_decode($response_guardar->getBody(),true);
        return $lista;
    }
 
    //PRIMERA TABLA
    public static function registrar_notificacion_acuerdo(Request $request, $datos){
       
        $response_guardar = $request
        ->clienteWS
        ->request('POST', 'registrar_notificacion_acuerdo',[
            "json" => [
                "datos" => [
                    "id_acuerdo" =>$datos['id_acuerdo'],
                    "organo" => $datos['organo'],
                    "id_juicio" => $datos['id_juicio'],
                    "id_actuario"=> $datos['id_actuario']
                ]
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id")
            ]
        ]);

        $lista = json_decode($response_guardar->getBody(),true);
        return $lista;
    }

    public static function eliminar_notificacion_acuerdo(Request $request, $datos){
       
        $response_guardar = $request
        ->clienteWS
        ->request('DELETE', 'eliminar_notificacion_acuerdo/'.$datos['id_acuerdo'].'/'.$datos['organo'],[
            "json" => [
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id")
            ]
        ]);

        $lista = json_decode($response_guardar->getBody(),true);
        return $lista;
    }

    public static function eliminar_notificacion_electronica(Request $request, $id_not){
        $response_guardar = $request
        ->clienteWS
        ->request('DELETE', 'eliminar_notificacion_electronica/'.$id_not,[
            "json" => [
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id")
            ]
        ]);

        $lista = json_decode($response_guardar->getBody(),true);
        return $lista;
    }

    public static function contadores_notificacion_acuerdo(Request $request){
       
        $response_guardar = $request
        ->clienteWS
        ->request('GET', 'contadores_notificacion_acuerdo',[
            "json" => [
                "datos" => [
                ]
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id")
            ]
        ]);

        $lista = json_decode($response_guardar->getBody(),true);
        return $lista;
    }

    public static function obtener_notificaciones_acuerdo(Request $request, $bandera, $juzgado="" ){
       
        $response_guardar = $request
        ->clienteWS
        ->request('GET', 'obtener_notificaciones_acuerdo/'.$bandera.'/'.$juzgado,[
            "json" => [
                "datos" => [
                ]
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id")
            ]
        ]);

        $lista = json_decode($response_guardar->getBody(),true);
        return $lista;
    }

    public static function modificar_notificacion_acuerdo(Request $request, $notificacion ){
       
        $response_guardar = $request
        ->clienteWS
        ->request('PATCH', 'modificar_notificacion_acuerdo/'.$notificacion,[
            "json" => [
                "datos" => [
                    "bandera"=>"notificado"
                ]
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id")
            ]
        ]);

        $lista = json_decode($response_guardar->getBody(),true);
        return $lista;
    }



    
    //SEGUNDA TABLA
    public static function obtener_notificaciones_electronicas(Request $request, $bandera ){
       
        $response_guardar = $request
        ->clienteWS
        ->request('GET', 'obtener_notificaciones_electronicas/'.$bandera,[
            "json" => [
                "datos" => [
                ]
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id")
            ]
        ]);

        $lista = json_decode($response_guardar->getBody(),true);
        
        return $lista;
    }

    public static function modificar_notificacion_electronica(Request $request, $notificacion_id, $fecha){
        $response_guardar = $request
        ->clienteWS
        ->request('PATCH', 'modificar_notificacion_electronica/'.$notificacion_id,[
            "json" => [
                "datos" => [
                    "noti_elect_estatus_envio"=>"notificado",
                    "noti_elect_modificacion"=>$fecha
                ]
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id")
            ]
        ]);

        $lista = json_decode($response_guardar->getBody(),true);
        return $lista;
    }

    public static function modificar_notificacion_electronica_revision(Request $request, $notificacion_id, $bandera, $comentarios){
        $response_guardar = $request
        ->clienteWS
        ->request('PATCH', 'modificar_notificacion_electronica/'.$notificacion_id,[
            "json" => [
                "datos" => [
                    "noti_elect_estatus_correccion"=>$bandera,
                    "noti_elect_comentario_correccion"=>$comentarios
                ]
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id")
            ]
        ]);

        $lista = json_decode($response_guardar->getBody(),true);
        return $lista;
    }

    public static function modificar_notificacion_electronica_actuario(Request $request, $notificacion_id, $actuario_id, $estatus){
        $response_guardar = $request
        ->clienteWS
        ->request('PATCH', 'modificar_notificacion_electronica/'.$notificacion_id,[
            "json" => [
                "datos" => [
                    "id_usuario_actuario"=>$actuario_id,
                    "noti_elect_estatus"=>$estatus
                ]
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id")
            ]
        ]);

        $lista = json_decode($response_guardar->getBody(),true);
        return $lista;
    }

    public static function contadores_notificacion_electronica(Request $request){
        $response_guardar = $request
        ->clienteWS
        ->request('GET', 'contadores_notificacion_electronica/',[
            "json" => [
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id")
            ]
        ]);
        $lista = json_decode($response_guardar->getBody(),true);
        return $lista;
    }

    public static function contadores_notificacion_electronica_correcciones(Request $request){
        $response_guardar = $request
        ->clienteWS
        ->request('GET', 'contadores_notificacion_electronica_correcciones/',[
            "json" => [
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id")
            ]
        ]);
        $lista = json_decode($response_guardar->getBody(),true);
        return $lista;
    }

    //utilizada
    public static function registrar_notificacion_electronica(Request $request, $datos){
       
        if(!isset($datos['noti_elect_comentario_correccion'])){
            $datos['noti_elect_comentario_correccion']="";
        }
        if(!isset($datos['noti_elect_estatus_correccion'])){
            $datos['noti_elect_estatus_correccion']="";
        }


        $response_guardar = $request
        ->clienteWS
        ->request('POST', 'registrar_notificacion_electronica',[
            "json" => [
                "datos" => [
                    "id_acuerdo_notificacion" =>$datos['id_acuerdo_notificacion'],
                    "codigo_organo" => $datos['codigo_organo'],
                    "id_parte"=> $datos['id_parte'],
                    "parte_correo"=> $datos['parte_correo'],
                    "tipo_notificacion"=> $datos['tipo_notificacion'],
                    "estatus_envio"=> $datos['noti_elect_estatus_envio'],
                    "noti_elect_comentario_correccion"=> $datos['noti_elect_comentario_correccion'],
                    "noti_elect_estatus_correccion"=> $datos['noti_elect_estatus_correccion']
                ]
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id")
            ]
        ]);

        $lista = json_decode($response_guardar->getBody(),true);
        return $lista;
    }

}