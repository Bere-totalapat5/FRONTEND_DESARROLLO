<?php
namespace App\Http\Controllers\clases;

use Illuminate\Http\Request;
use App\Http\Controllers\clases\utilidades;

class boletin{

    public static function alta_registro_boletin(Request $request, $datos){
       
        //se obtiene la lista de archivos
        $response = $request
        ->clienteWS
        ->request('POST', 'alta_registro_boletin',[
            "json" => [
                "datos" => [
                    "numero" => $datos['numero'],
                    "fecha_publicacion" => $datos['fecha_publicacion']
                    ]
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


    public static function obtener_registro_boletin(Request $request, $datos){

        //se obtiene la lista de archivos
        $response = $request
        ->clienteWS
        ->request('GET', 'obtener_registro_boletin',[
            "query" => [
                "datos" => [
                    "numero" => $datos['numero'],
                    "fecha_publicacion" => $datos['fecha_publicacion'],
                    "rel_organo" => $datos['rel_organo'],
                    "rel_materia" => $datos['rel_materia']
                ]
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

    public static function modificar_registro_boletin(Request $request, $datos){

        //se obtiene la lista de archivos
        $response = $request
        ->clienteWS
        ->request('PATCH', 'modificar_registro_boletin',[
            "json" => [
                "datos" => [
                    "boletin_numero" => $datos['boletin_numero'],
                    "boletin_fecha_publicacion" => $datos['boletin_fecha_publicacion'],
                    "boletin_ruta_pdf" => $datos['boletin_ruta_pdf']
                ]
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


    public static function alta_registro_boletin_temporal(Request $request, $datos){

        //se obtiene la lista de archivos
        $response = $request
        ->clienteWS
        ->request('POST', 'alta_registro_boletin_temporal',[
            "json" => [
                "datos" => [
                    "id_boletin_registro" => $datos['id_boletin_registro'],
                    "codigo_organo" => $datos['codigo_organo'],
                    "texto" => $datos['texto']
                ]
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


    public static function obtener_registro_boletin_temporal(Request $request, $datos){

        //se obtiene la lista de archivos
        $response = $request
        ->clienteWS
        ->request('GET', 'obtener_registro_boletin_temporal',[
            "query" => [
                "datos" => [
                    "id_boletin_registro" => $datos['id_boletin_registro'],
                    "codigo_organo" => $datos['codigo_organo']
                ]
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


    public static function modificar_registro_boletin_temporal(Request $request, $datos){

        //se obtiene la lista de archivos
        $response = $request
        ->clienteWS
        ->request('PATCH', 'modificar_registro_boletin_temporal',[
            "json" => [
                "datos" => [
                    "id_boletin_registro" => $datos['id_boletin_registro'],
                    "codigo_organo" => $datos['codigo_organo'],
                    "boletin_temporal_texto" => $datos['boletin_temporal_texto']
                ]
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


    public static function generarNumericoPDF(Request $request, $numero){

        ob_start();
        ?>
        <!DOCTYPE html>
        <html>
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
            </head>
            <body style="font-size: 15px;">
                <div style="text-align:center; font-size: 12px;"><?php print($numero); ?></div>
                
            </body>
        </html>

        <?php

        $html = ob_get_contents();
        ob_end_clean();
 
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8', 
            'format' => 'Legal'
        ]);
        $mpdf->WriteHTML($html);
        $mpdf->Output('/san/www/html/sicor_extendido_80/public/temporales/numero_'.$numero.'.pdf', \Mpdf\Output\Destination::FILE);

    }


    public static function generarBoeltinMateriasPDF(Request $request, $texto, $numero){

        ob_start();
        ?>
        <!DOCTYPE html>
        <html>
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
            </head>
            <body style="font-size: 15px;">
                <div style="text-align:center; font-size: 12px;"><?php print($texto); ?></div>
                
            </body>
        </html>

        <?php

        $html = ob_get_contents();
        ob_end_clean();
 
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8', 
            'format' => 'Legal'
        ]);
        $mpdf->WriteHTML($html);
        $mpdf->Output('/san/www/html/sicor_extendido_80/public/temporales/numero_'.$numero.'.pdf', \Mpdf\Output\Destination::FILE);

    }

}