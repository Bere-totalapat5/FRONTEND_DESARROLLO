<?php
namespace App\Http\Controllers\configuracion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\clases\configuracion;
use Session;

class control_configuracion extends Controller
{

    public function cargar_permisos_menu( Request $request, $error="" ){

        $id_usuario=Session::get('usuario_id');

        if(isset($request->id_usuario)){
            $id_usuario=$request->id_usuario;
        }
        // return $id_usuario;
        
        $lista=configuracion::generar_permisos_menu($request, $id_usuario);
        // return $lista;
        $lista_permisos_menu=configuracion::obtener_permisos_menu($request, $id_usuario);
        // return $lista_permisos_menu;


        return view(    "configuracion.permisos_menu",
                        ["entorno"=>$request->entorno, 
                        "request"=>$request,
                        "sesion"=>Session::all(),
                        "menu_general"=>$request->menu_general,
                        "lista_permisos_menu"=>$lista_permisos_menu,
                        "error"=>$error,
                        "id_usuario"=>$id_usuario
                        ]
                    );
    }

    public function guardar_permisos( Request $request ){
        // return $request->usuario;
        $datos_permisos=[
            "modo"=>"menus",
            "permisos"=>$request->permisos,
        ];

        $datos_acciones=[
            "modo"=>"acciones",
            "permisos"=>$request->acciones,
        ];
        
        $response_permisos = $request
        ->clienteWS_penal
        ->request('put', 'modificar_permisos/'.($request->usuario==null?'':$request->usuario),[
            "headers" => [
                "sesion-id" => Session::get("sesion-id"),
                "cadena-sesion" => Session::get("cadena-sesion"),
                "usuario-id" => Session::get("usuario-id")
            ],
            "json"=>[
                "datos"=>$datos_permisos
            ]
        ]);

       
        $response_permisos = json_decode($response_permisos->getBody(),true) ;

        $response_acciones = $request
        ->clienteWS_penal
        ->request('put', 'modificar_permisos/'.($request->usuario==null?'':$request->usuario),[
            "headers" => [
                "sesion-id" => Session::get("sesion-id"),
                "cadena-sesion" => Session::get("cadena-sesion"),
                "usuario-id" => Session::get("usuario-id")
            ],
            "json"=>[
                "datos"=>$datos_acciones
            ]
        ]);
        
        $response_acciones = json_decode($response_acciones->getBody(),true) ;
        
        if($response_permisos["status"]==100 || $response_acciones['status']==100){
            return ["status"=>100];
        }else{
            return ["message"=>"Menús: ".explode('-',$response_permisos['message'])[1]." - Acciones: ".explode('-',$response_acciones['message'])[1]];
        }
        
    }
}