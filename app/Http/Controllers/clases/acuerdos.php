<?php
namespace App\Http\Controllers\clases; 

use Illuminate\Http\Request;

class acuerdos{

    public static function obtener_archivo_acuerdos(Request $request, $archivo_id){
       

        //se obtiene la lista de archivos
        $response = $request
        ->clienteWS
        ->request('get', 'consultaAcuerdos/'.$archivo_id,[
            "query" => [
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

    public static function obtener_archivo_acuerdos_paginacion(Request $request, $archivo_id, $pagina, $registros){
       
        
        //se obtiene la lista de archivos
        $response = $request
        ->clienteWS
        ->request('get', 'consultaAcuerdos/'.$archivo_id,[
            "query" => [

                "paginacion" => [
                    "pagina" => $pagina,
                    "registros_por_pagina" => $registros
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

    public static function obtener_archivo_acuerdo(Request $request, $archivo_id, $acuerdo_id){
       
        //se obtiene la lista de archivos
        $response = $request
        ->clienteWS
        ->request('get', 'buscarAcuerdo/'.$archivo_id.'/'.$acuerdo_id,[
            "json" => [
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

    public static function obtener_archivo_acuerdo_sinse(Request $request, $archivo_id, $acuerdo_id, $juzgado){
       
        //se obtiene la lista de archivos
        $response = $request
        ->clienteWS
        ->request('get', 'buscarAcuerdo_sinse/'.$archivo_id.'/'.$acuerdo_id.'/'.$juzgado,[
            "json" => [
            ],
            "headers" => [
                "Content-Type" => "application/json"
            ]
        ]);
        
        $lista = json_decode($response->getBody(),true);

        return $lista;
    }

    public static function guardar_acuerdo($datos, Request $request){

        if(!isset($datos['version_sello'])){
            $datos['version_sello']=0;
        }
        
        $response_guardar = $request
        ->clienteWS
        ->request('post', 'altaAcuerdo/'.$datos['id_juicio'],[
            "json" => [
                "datos" => [
                    "id_tipo_firma" => $datos['tipo_flujo'],
                    "acuerdo" => $datos['juicio'].'-'.$datos['acuerdo'],
                    "resolvio"=> $datos['resuelve'],
                    "fecha"=>$datos['fecha'],
                    "permiso_parte1"=>$datos['permiso_parte1'],
                    "permiso_parte2"=>$datos['permiso_parte2'],
                    "permiso_parte3"=>$datos['permiso_parte3'],
                    "especial"=>$datos['especial'],
                    "fecha_especial"=>$datos['fecha_especial'],
                    "visibilidad"=>$datos['visibilidad'],
                    "extension"=>".".$datos['extension'],
                    "extension_original"=>".".$datos['extension_original'],
                    "tipo"=>$datos['tipo_acuerdo'],
                    "acuerdo_subtipo"=>$datos['acuerdo_subtipo'],
                    "tipo_firma"=>$datos['tipo_firma'],
                    "publicar_en"=>$datos['publicar_en_slct'],
                    "conciliador"=>'N',
                    "concepto"=>$datos['concepto'],
                    "anotacion"=>$datos['anotacion'],
                    "id_propietario"=>$request->session()->get("usuario_id"),
                    "id_ultima_edicion"=>$request->session()->get("usuario_id"),
                    "es_edicto"=>'F',
                    "archivo64"=>$datos['archivo64'],
                    "nombre_archivo"=>'--',
                    "extension_archivo"=>$datos['extension'],
                    "tipo_firma_publicacion"=>$datos['tipo_firma_publicacion'],
                    "con_excusa"=>$datos['con_excusa'],
                    "ponencia"=>$datos['ponencia'],
                    "en_calidad"=>$datos['en_calidad'],
                    "publicar"=>$datos['fecha_publicacion'],
                    "fecha_publicacion_temp"=>$datos['fecha_publicacion_temp'],
                    "mide"=>$datos['mide'],
                    "tipo_noti_elect"=>$datos['tipo_noti_elect'],
                    "bandera_noti_elect"=>$datos['bandera_noti_elect'],
                    "etapa_procesal"=>$datos['etapa_procesal'],
                    "es_edicto"=>$datos['es_edicto'],
                    "version_sello"=>$datos['version_sello'],
                    "tipo_audiencia"=>$datos['tipo_audiencia'],
                    "ids_firmas"=>$datos['ids_firmas']
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

    public static function guardar_acuerdo_min($datos, Request $request){

        $response_guardar = $request
        ->clienteWS
        ->request('PATCH', 'modificarAcuerdo/'.$datos['acuerdo_id'],[
            "json" => [
                "datos" => [
                    "resolvio"=> $datos['resolvio'],
                    "especial"=>$datos['especial'],
                    "fecha_especial"=>$datos['fecha_especial'],
                    "anotacion"=>$datos['anotacion']
                ]
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "autorizacion" => "minutmanQAEtHReI"
            ]
        ]);

        $lista = json_decode($response_guardar->getBody(),true);
        return $lista;
    }

    public static function guardar_acuerdo_firma_tsj($datos, Request $request){

        $response_guardar = $request
        ->clienteWS
        ->request('PATCH', 'modificarAcuerdo/'.$datos['acuerdo_id'],[
            "json" => [
                "datos" => [
                    "llaves_documento_firma"=> $datos['llaves_documento_firma']
                ]
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "autorizacion" => "minutmanQAEtHReI"
            ]
        ]);

        $lista = json_decode($response_guardar->getBody(),true);
        return $lista;
    }

    public static function guardar_acuerdo_notificacion($datos, Request $request){

        $response_guardar = $request
        ->clienteWS
        ->request('PATCH', 'modificarAcuerdo/'.$datos['acuerdo_id'],[
            "json" => [
                "datos" => [
                    "acuerdo_tipo_noti_elect"=> $datos['tipo_noti_elect'],
                    "acuerdo_noti_elect_band"=>$datos['bandera_noti_elect'],
                    "visibilidad"=>$datos['estatus']
                ]
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "autorizacion" => "minutmanQAEtHReI"
            ] 
        ]);

        $lista = json_decode($response_guardar->getBody(),true);
        return $lista;
    }

    public static function guardar_acuerdo_permisos($acuerdo_id, $key, $permiso, Request $request){

        $response_guardar = $request
        ->clienteWS
        ->request('PATCH', 'modificarAcuerdo/'.$acuerdo_id,[
            "json" => [
                "datos" => [
                    $key=> $permiso
                ]
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "autorizacion" => "minutmanQAEtHReI"
            ]
        ]);

        $lista = json_decode($response_guardar->getBody(),true);
        return $lista;
    }

    public static function eliminarAcuerdo(Request $request, $acuerdo_id){
        $response_guardar = $request
        ->clienteWS
        ->request('DELETE', 'eliminarAcuerdo/'.$acuerdo_id,[
            "json" => [

            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "autorizacion" => "minutmanQAEtHReI"
            ]
        ]);

        $lista = json_decode($response_guardar->getBody(),true);
        return $lista;
    }
     
    public static function cancelar_publicacion(Request $request, $acuerdo_id ){
        
        //se obtiene la lista de archivos
        $response = $request
        ->clienteWS
        ->request('DELETE', 'cancelar_publicacion/'.$acuerdo_id,[
            "json" => [
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

    public static function obtener_flujo_juzgados(Request $request, $conciliador, $secretaria){

        try{
            $response = $request
            ->clienteWS
            ->request('get', 'obtenerFlujoDefault/1',[
                "query" => [
                    "datos" => [
                        "conciliador"=> $conciliador,
                        "secretaria"=> $secretaria
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
        catch (\Exception $e) { 
            $lista['status']=0;
            $lista['message']="Error - sin secretario de acuerdos definido para juzgado";
            return $lista;
        }

    }

    public static function obtener_flujo(Request $request, $flujo_id, $acu_ponencia, $acu_en_calidad){
       /*
        if($acu_ponencia==""){
            $acu_ponencia=0;
            $acu_en_calidad="nada";
        }
        */
       //dd('obtenerFlujoDefault/'.$flujo_id.'/'.$acu_ponencia.'/'.$acu_en_calidad.'/1');

        $response = $request
        ->clienteWS
        //->request('get', 'obtenerFlujoDefault/'.$flujo_id.'/'.$acu_ponencia.'/'.$acu_en_calidad.'/1',[
        ->request('get', 'obtenerFlujoDefault/'.$flujo_id.'/'.$acu_ponencia.'/'.$acu_en_calidad.'/',[
            "json" => [
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

    public static function flujo_participantes_detalle(Request $request, $excusa=""){
       
        //se obtiene la lista de archivos
        $response = $request
        ->clienteWS
        ->request('get', 'obtenerParticipantesParaFlujo/'.$excusa,[
            "json" => [
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

    public static function guardar_flujo($datos, Request $request, $acuerdo_id){
        $response_guardar = $request
        ->clienteWS
        ->request('post', 'registrarFlujo/'.$acuerdo_id,[
            "json" => [
                "datos" => [
                    "creador" =>$datos['datos']['creador'],
                    "revisores" => $datos['datos']['revisores'],
                    "firmas"=> $datos['datos']['firmas']
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

    public static function editar_flujo($datos, Request $request, $acuerdo_id){
        
        /*
        $datos['creador']= $datos['datos']['creador'];
        $datos['revisores']= $datos['datos']['revisores'];
        $datos['firmas']= $datos['datos']['firmas'];

        print(json_encode($datos));


        dd(json_encode($datos));
        */
        $response_guardar = $request
        ->clienteWS
        ->request('PATCH', 'modificarFlujo/'.$acuerdo_id,[
            "json" => [
                "datos" => [
                    "creador" =>$datos['datos']['creador'],
                    "revisores" => $datos['datos']['revisores'],
                    "firmas"=> $datos['datos']['firmas']
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

    public static function consulta_flujo_detalles(Request $request, $acuerdo_id){
        $response_guardar = $request
        ->clienteWS
        ->request('get', 'consultarFlujo/'.$acuerdo_id,[
            "query" => [
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
        utilidades::guardarLog($request, 'return_clases', $request->session()->get("sesion-id"), 2,  "Método: consultarFlujo Juzgado: " . $request->session()->get('usuario_juzgado') . " Usuario: " . $request->session()->get('usuario_nombre') ."\n". str_replace( "\n", '', print_r($lista, true))."\n\n");
        return $lista;
    }

    public static function consulta_flujo_detalles_estadistica(Request $request, $acuerdo_id, $juzgado){
        $response_guardar = $request
        ->clienteWS
        ->request('get', 'consultarFlujo_sinse/'.$acuerdo_id.'/'.$juzgado.'/no',[
            "query" => [
                "datos" => [
                ]
            ],
            "headers" => [
                "autorizacion" => "minutmanQAEtHReI"
            ]
        ]);
 
        $lista = json_decode($response_guardar->getBody(),true);
        //utilidades::guardarLog($request, 'return_clases', $request->session()->get("sesion-id"), 2,  "Método: consultarFlujo Juzgado: " . $request->session()->get('usuario_juzgado') . " Usuario: " . $request->session()->get('usuario_nombre') ."\n". str_replace( "\n", '', print_r($lista, true))."\n\n");
        return $lista;
    }
    
    public static function consultaBandejas(Request $request){
        $response_guardar = $request
        ->clienteWS
        ->request('post', 'registrarFlujo/',[
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

    public static function obtener_actuarios(Request $request){
       
        $response_guardar = $request
        ->clienteWS
        ->request('get', 'obtener_actuarios/'.$request->session()->get("usuario_juzgado").'/'.$request->session()->get("grupo_trabajo_identificar_area"),[
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

    public static function actuarios_notificadores(Request $request){
       
        $response = $request
        ->clienteWS
        ->request('get', 'actuarios_notificadores',[
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

        $lista = json_decode($response->getBody(),true);
        return $lista;
    }

    public static function modificar_notificacion_acuerdo(Request $request, $notificacion_id, $usuario_id){
       
        $response = $request
        ->clienteWS
        ->request('PATCH', 'modificar_notificacion_acuerdo/'.$notificacion_id,[
            "json" => [
                "datos" => [
                    "id_actuario"=>$usuario_id
                ]
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id")
            ]
        ]);

        $lista = json_decode($response->getBody(),true);
        return $lista;
    }

    public static function obtener_notificaciones_electronicas(Request $request, $bandeja){
        $response_guardar = $request
        ->clienteWS
        ->request('GET', 'obtener_notificaciones_electronicas/'.$bandeja,[
            "query" => [
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

    public static function obtener_representantes_juzgado(Request $request){
        $response_guardar = $request
        ->clienteWS
        ->request('GET', 'obtener_representantes_juzgado/'.$request->session()->get('usuario_juzgado'),[
            "query" => [
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

    public static function obtener_representantes_juzgado_sinse(Request $request, $juzgado){
        $response_guardar = $request
        ->clienteWS
        ->request('GET', 'obtener_representantes_juzgado/'.$juzgado,[
            "query" => [
                "datos" => [
                ]
            ]
        ]);

        $lista = json_decode($response_guardar->getBody(),true);
        return $lista;
    }

    public static function obtener_ultima_version_acuerdo(Request $request, $id_acuerdo){
        $response_guardar = $request
        ->clienteWS
        ->request('GET', 'obtener_ultima_version_acuerdo/'.$id_acuerdo,[
            "query" => [
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

    public static function obtener_ultima_version_acuerdo_sinse(Request $request, $id_acuerdo, $juzgado){
        $response_guardar = $request
        ->clienteWS
        ->request('GET', 'obtener_ultima_version_acuerdo_sinse/'.$id_acuerdo.'/'.$juzgado,[
            "query" => [
                "datos" => [
                ]
            ],
            "headers" => [
            ]
        ]);

        $lista = json_decode($response_guardar->getBody(),true);
        return $lista;
    }

    public static function generarPDFBlanco_mpdf(Request $request, $archivo, $texto){

        ob_start();
        ?>
        <!DOCTYPE html>
        <html>
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
            </head>
            <body style="font-size: 15px;">
                <?php print($texto); ?>
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
        $mpdf->Output($archivo, \Mpdf\Output\Destination::FILE);

    }
    
}