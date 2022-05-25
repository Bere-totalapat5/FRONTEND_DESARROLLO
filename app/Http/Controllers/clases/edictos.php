<?php
namespace App\Http\Controllers\clases;

use Illuminate\Http\Request;

class edictos{
 
    public static function listar_edictos(Request $request, $datos, $usuario=""){
       
        if($usuario==1){
            $usuario=$request->session()->get("usuario-id");
        }

        //se obtiene la lista de archivos
        $response = $request
        ->clienteWS
        ->request('get', 'listar_edictos/'.$request->session()->get('usuario_juzgado'),[
            "query" => [
                "datos" => [
                    "modo" => $datos['modo'],
                    "fecha_publicacion_edicto" => $datos['fecha_publicacion_edicto'],
                    "edicto_estatus" => $datos['edicto_estatus'],
                    "modo_acuerdo" => $datos['modo_acuerdo'],
                    "num_expediente" => $datos['num_expediente'],
                    "anio_expediente" => $datos['anio_expediente'],
                    "id_edicto" => $datos['id_edicto']
                ]
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ]
        ]);
        $lista = json_decode($response->getBody(),true);
        return $lista;
    }

    public static function acuerdo_como_edicto(Request $request, $id_acuerdo, $datos){
       
        //se obtiene la lista de archivos
        $response = $request
        ->clienteWS
        ->request('POST', 'acuerdo_como_edicto/'.$request->session()->get('usuario_juzgado')."/".$id_acuerdo,[
            "json" => [
                "datos" => [
                    "num_palabras" => $datos['num_palabras'],
                    "costo" => $datos['costo'],
                    "fecha_publicacion_inicio" => $datos['fecha_publicacion_inicio'],
                    "num_publicaciones" => $datos['num_publicaciones'],
                    "num_dias_intervalo" => $datos['num_dias_intervalo'],
                    "estatus" => $datos['estatus'],
                    "archivo_extension" => $datos['archivo_extension'],
                    "archivo_b64" => $datos['archivo_b64'],
                    "archivo_pdf_b64" => $datos['archivo_pdf_b64'],
                ]
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ]
        ]);
        $lista = json_decode($response->getBody(),true);
        return $lista;
    }

    public static function edicto_bandejas(Request $request, $datos){
       
        //se obtiene la lista de archivos
        $response = $request
        ->clienteWS
        ->request('get', 'edicto_bandejas/'.$request->session()->get('usuario_id')."/".$request->session()->get('usuario_juzgado'),[
            "query" => [
                "datos" => [
                    "modo" => $datos['modo'],
                    "id_edicto" => $datos['id_edicto']
                ]
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ]
        ]);
        $lista = json_decode($response->getBody(),true);
        return $lista;
    }

    public static function edicto_agregar_firmantes(Request $request, $id_edicto, $id_acuerdo, $flujo){
       
        //se obtiene la lista de archivos
        $response = $request
        ->clienteWS
        ->request('POST', 'edicto_agregar_firmantes/'.$id_edicto."/".$id_acuerdo."/".$request->session()->get('usuario_juzgado'),[
            "json" => [
                "datos" => [
                    "creador" =>$flujo['datos']['creador'],
                    "revisores" => $flujo['datos']['revisores'],
                    "firmas"=> $flujo['datos']['firmas']
                ]
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ]
        ]);
        $lista = json_decode($response->getBody(),true);
        return $lista;
    }

    public static function edicto_documento(Request $request, $id_edicto, $datos){
       
        //se obtiene la lista de archivos
        $response = $request
        ->clienteWS
        ->request('PATCH', 'edicto_documento/'.$request->session()->get('usuario_juzgado')."/".$id_edicto,[
            "json" => [
                "datos" => [
                    "modo" =>$datos['modo'],
                    "extension_archivo_obtener" => $datos['extension_archivo_obtener'],
                    "archivo_64"=> $datos['archivo_64'],
                    "archivo_pdf_b64"=> $datos['archivo_pdf_b64']
                ]
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ]
        ]);
        $lista = json_decode($response->getBody(),true);
        return $lista;
    }

    public static function editar_edicto(Request $request, $id_edicto, $datos){
       
        //se obtiene la lista de archivos
        $response = $request
        ->clienteWS
        ->request('PATCH', 'editar_edicto/'.$id_edicto."/".$datos['id_acuerdo']."/".$request->session()->get('usuario_juzgado'),[
            "json" => [
                "datos" => [
                    "edicto_num_palabras" =>$datos['edicto_num_palabras'],
                    "edicto_costo" => $datos['edicto_costo'],
                    "edicto_publicacion_inicio"=> $datos['edicto_publicacion_inicio'],
                    "edicto_num_publicacion"=> $datos['edicto_num_publicacion'],
                    "edicto_num_intervalo"=> $datos['edicto_num_intervalo'],
                    "edicto_estatus"=> $datos['edicto_estatus']
                ]
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ]
        ]);
        $lista = json_decode($response->getBody(),true);
        return $lista;
    }

    public static function fimar_edicto(Request $request, $id_edicto){
       
        //se obtiene la lista de archivos
        $response = $request
        ->clienteWS
        ->request('GET', 'edicto_bandejas/'.$request->session()->get('usuario-id')."/".$request->session()->get('usuario_juzgado'),[
            "query" => [
                "datos" => [
                    "id_edicto" =>$id_edicto,
                    "modo" => "firmar"
                ]
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ]
        ]);
        $lista = json_decode($response->getBody(),true);
        return $lista;
    }
    
}