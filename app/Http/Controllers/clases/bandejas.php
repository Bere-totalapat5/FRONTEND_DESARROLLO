<?php
namespace App\Http\Controllers\clases;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\clases\utilidades;
use SoapClient;
use File;

class bandejas{

    public static function obtener_listado_bandejas(Request $request, $bandeja, $datos){

        //se obtiene la lista de archivos
        $response = $request
        ->clienteWS
        ->request('get', 'obtenerAcuerdosPara/'.$bandeja,[
            "query" => [
                "datos" => [
                    "toca" => $datos['toca'],
                    "anio" => $datos['anio_toca'],
                    "asunto"=> $datos['asunto_toca'],
                    "expediente_num"=> $datos['expediente'],
                    "expediente_anio"=> $datos['expediente_anio'],
                    "involucrado"=>[
                        "nombres"=>$datos['involucrados_nombre'],
                        "apellido_paterno"=>$datos['involucrados_apellido_paterno'],
                        "apellido_materno"=>$datos['involucrados_apellido_materno']
                    ],
                    "tipo_acuerdo"=>$datos['tipo_acuerdo'],
                    "origen_acuerdo"=>$datos['origen_acuerdo'],
                    "registrado_desde"=>$datos['registrado_desde'],
                    "registrado_hasta"=>$datos['registrado_hasta']
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

    public static function obtener_listado_proxima_publicacion(Request $request, $datos, $bandera){
        //se obtiene la lista de archivos
        $response = $request
        ->clienteWS
        ->request('get', 'proximasPublicaciones/'.$bandera,[
            "query" => [
                "datos" => [
                    "toca" => $datos['toca'],
                    "anio" => $datos['anio_toca'],
                    "asunto"=> $datos['asunto_toca'],
                    "desde"=> $datos['registrado_desde'],
                    "hasta"=> $datos['registrado_hasta']
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

    public static function bandeja_avanzar_revision(Request $request, $acuerdo_id){

        //se obtiene la lista de archivos
        $response = $request
        ->clienteWS
        ->request('PUT', 'avanzar/'.$acuerdo_id.'/avance',[
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

    public static function acuerdo_mala_publicacion(Request $request, $id_juicio, $id_acuerdo, $comentarios){

        //se obtiene la lista de archivos
        $response = $request
        ->clienteWS
        ->request('POST', 'acuerdo_mala_publicacion/'.$id_juicio.'/'.$id_acuerdo,[
            "json" => [
                "datos" => [
                    "comentario_mala_publicacion" => $comentarios
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

    public static function bandeja_avanzar_revision_juzgado(Request $request, $acuerdo_id, $accion, $firma='', $id_proceso_firmado=0){

        //se obtiene la lista de archivos
        $response = $request
        ->clienteWS
        ->request('PUT', 'avanzar/'.$acuerdo_id.'/'.$accion,[
            "json" => [
                "datos"=>[
                    "tipo_firma"=>$firma,
                    "llave_firmante"=>$id_proceso_firmado
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

    public static function bandeja_retroceso_revision(Request $request, $acuerdo_id){

        //se obtiene la lista de archivos
        $response = $request
        ->clienteWS
        ->request('PUT', 'avanzar/'.$acuerdo_id.'/retroceso',[
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

    public static function bandeja_retroceso_revision_juzgado(Request $request, $acuerdo_id){

        //se obtiene la lista de archivos
        $response = $request
        ->clienteWS
        ->request('PUT', 'avanzar/'.$acuerdo_id.'/revision',[
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

    public static function subir_documentos_flujo(Request $request, $acuerdo_id, $organo_acuerdo, $flujo_id, $wordBase64, $extension_word, $pdfBase64, $firmados='no'){

        //print('subirDocumentosAcuerdo/'.$acuerdo_id.'/'.$organo_acuerdo.'/'.$flujo_id);
        //se obtiene la lista de archivos
        $response = $request
        ->clienteWS
        ->request('POST', 'subirDocumentosAcuerdo/'.$acuerdo_id.'/'.$organo_acuerdo.'/'.$flujo_id,[
            "json" => [
                "datos" => [
                    "extension_word" =>$extension_word,
                    "b64_word" => $wordBase64,
                    "b64_pdf"=> $pdfBase64
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


    public static function subir_documentos_flujo_firma(Request $request, $acuerdo_id, $organo_acuerdo, $flujo_id, $wordBase64, $extension_word, $pdfBase64, $firmados='no'){

        //print('subirDocumentosAcuerdo/'.$acuerdo_id.'/'.$organo_acuerdo.'/'.$flujo_id);
        //se obtiene la lista de archivos
        $response = $request
        ->clienteWS
        ->request('POST', 'subirDocumentosAcuerdo/'.$acuerdo_id.'/'.$organo_acuerdo.'/'.$flujo_id.'/con_archivo/si/'.$firmados,[
            "json" => [
                "datos" => [
                    "extension_word" =>$extension_word,
                    "b64_word" => $wordBase64,
                    "b64_pdf"=> $pdfBase64
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

    public static function subir_documentos_flujo_sinse(Request $request, $acuerdo_id, $organo_acuerdo, $flujo_id, $wordBase64, $extension_word, $pdfBase64, $id_usuario_creador){

        //print('subirDocumentosAcuerdo/'.$acuerdo_id.'/'.$organo_acuerdo.'/'.$flujo_id);
        //se obtiene la lista de archivos
        $response = $request
        ->clienteWS
        ->request('POST', 'subirDocumentosAcuerdo_sinse/'.$acuerdo_id.'/'.$organo_acuerdo.'/'.$flujo_id.'/con_archivo/'.$id_usuario_creador,[
            "json" => [
                "datos" => [
                    "extension_word" =>$extension_word,
                    "b64_word" => $wordBase64,
                    "b64_pdf"=> $pdfBase64
                ]
            ],
            "headers" => [
                "Content-Type" => "application/json"
            ]
        ]);

        $lista = json_decode($response->getBody(),true) ;
        return $lista;
    }

    public static function subir_documento_notificacion(Request $request, $juicio_id, $acuerdo_id, $pdfBase64){

        //print('subirDocumentosAcuerdo/'.$acuerdo_id.'/'.$organo_acuerdo.'/'.$flujo_id);
        //se obtiene la lista de archivos
        $response = $request
        ->clienteWS
        ->request('PUT', 'subir_docuemnto_notificacion/'.$juicio_id.'/'.$acuerdo_id,[
            "json" => [
                "datos" => [
                    "extension" => 'pdf',
                    "b64"=> $pdfBase64
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

    public static function documento_descargar(Request $request, $acuerdo_id, $organo_acuerdo, $id_documento, $tipo_documento, $firma=""){

        try{
            //se obtiene la lista de archivos
            $response = $request
            ->clienteWS
            ->request('POST', 'obtenerArchivo/'.$acuerdo_id.'/'.$organo_acuerdo.'/'.$id_documento.'/'.$tipo_documento.'/'.$firma,[
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
        }
        catch (\Exception $e) {
            $lista['status']=0;
            $lista['message']="Sin documento PDF";
        }

        //se realiza la copia a local y se reemplza la liga
        if(isset($lista['status']) and $lista['status']==100){

            //se hace la copia
            $dominios = array($request->entorno["variables_entorno"]["files_ip_publica"].'/share/', $request->entorno["variables_entorno"]["files_ip_privada"].'/share/');
            $dominio_aux=str_replace($dominios, $request->entorno["variables_entorno"]["dominio"]."/temporales/", $lista['response']);
            $ruta_aux=str_replace($dominios, "/san/www/html/sicor_extendido_80/public/temporales/", $lista['response']);

            copy($lista['response'], $ruta_aux);

            $lista['response']=$dominio_aux;
        }

        $lista['type']='POST';
        return $lista;
    }

    public static function documento_descargar_batch(Request $request, $acuerdo_id, $organo_acuerdo, $id_documento, $tipo_documento, $documentos_arr_final){

        //se obtiene la lista de archivos
        $response = $request
        ->clienteWS
        ->request('POST', 'obtenerArchivo/'.$acuerdo_id.'/'.$organo_acuerdo.'/'.$id_documento.'/'.$tipo_documento,[
            "json" => [
                "datos" => [
                    "archivos" =>$documentos_arr_final
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
        $lista['type']='POST';
        return $lista;
    }

    public static function documento_descargar_litigante(Request $request, $acuerdo_id, $organo_acuerdo, $id_documento, $tipo_documento, $sesion_id, $cadena_sesion, $usuario_id){

        try{
            //se obtiene la lista de archivos
            $response = $request
            ->clienteWS
            ->request('POST', 'obtenerArchivo/'.$acuerdo_id.'/'.$organo_acuerdo.'/'.$id_documento.'/'.$tipo_documento,[
                "json" => [
                ],
                "headers" => [
                    "sesion-id" => $sesion_id,
                    "cadena-sesion" => $cadena_sesion,
                    "usuario-id" => $usuario_id,
                    "Content-Type" => "application/json"
                ]
            ]);

            $lista = json_decode($response->getBody(),true) ;
        }
        catch (\Exception $e) {
            $lista['status']=0;
            $lista['message']="Sin documento PDF";
        }
        return $lista;
    }


    public static function documento_descargar_sinse(Request $request, $acuerdo_id, $organo_acuerdo, $id_documento, $tipo_documento, $firma=""){

        try{
            //se obtiene la lista de archivos
            $response = $request
            ->clienteWS
            ->request('POST', 'obtenerArchivo_sinse/'.$acuerdo_id.'/'.$organo_acuerdo.'/'.$id_documento.'/'.$tipo_documento.'/0/0/'.$firma,[
                "json" => [
                ],
                "headers" => [
                    "Content-Type" => "application/json"
                ]
            ]);

            $lista = json_decode($response->getBody(),true) ;
        }
        catch (\Exception $e) {
            $lista['status']=0;
            $lista['message']="Sin documento PDF";
        }
        return $lista;
    }

    public static function documento_descargar_sicor(Request $request, $acuerdo_id, $organo_acuerdo, $id_documento, $tipo_documento){

        try{
            //se obtiene la lista de archivos
            $response = $request
            ->clienteWS
            ->request('POST', 'obtenerArchivo_sinse/'.$acuerdo_id.'/'.$organo_acuerdo.'/'.$id_documento.'/'.$tipo_documento.'/0/0',[
                "json" => [
                ],
                "headers" => [
                    "Content-Type" => "application/json"
                ]
            ]);

            $lista = json_decode($response->getBody(),true) ;
        }
        catch (\Exception $e) {
            $lista['status']=0;
            $lista['message']="Sin documento PDF";
        }
        return $lista;
    }

    public static function documento_descargar_ligitante_batch(Request $request, $acuerdo_id, $organo_acuerdo, $id_documento, $tipo_documento, $documentos_arr_final, $sesion_id, $cadena_sesion, $usuario_id ){

        //se obtiene la lista de archivos
        $response = $request
        ->clienteWS
        ->request('GET', 'obtenerArchivo/'.$acuerdo_id.'/'.$organo_acuerdo.'/'.$id_documento.'/'.$tipo_documento,[
            "query" => [
                "datos" => [
                    "archivos" =>$documentos_arr_final
                ]
            ],
            "headers" => [
                "sesion-id" => $sesion_id,
                "cadena-sesion" => $cadena_sesion,
                "usuario-id" => $usuario_id,
                "Content-Type" => "application/json"
            ]
        ]);

        $lista = json_decode($response->getBody(),true) ;
        return $lista;
    }

    public static function documento_limpiar_txt($datos_archvios){

        $arr_files='"'.$datos_archvios[0].'" "'.$datos_archvios[1].'"';

        $datos['exec']='sudo -u www-data HOME=/var/www /usr/bin/python2 "/var/www/html/sicor_extendido_80/scripts/firmas_html/filtro.py" '.$arr_files.'';
        $datos['return'] = exec('sudo -u www-data HOME=/var/www /usr/bin/python2 "/var/www/html/sicor_extendido_80/scripts/firmas_html/filtro.py" '.$arr_files.'');

        return $datos;
    }

    public static function documento_convertir_html_pdf($datos_archvios){
        $arr_files='';
        for($i=0;$i<count($datos_archvios); $i++){
            $arr_files.='"'.$datos_archvios[$i].'" ';
        }
        $arr_files=trim($arr_files);


        $datos['exec']='sudo -u www-data HOME=/var/www /usr/bin/python3 "/var/www/html/sicor_extendido_80/scripts/firmas_html/doc_para_coser.py" '.$arr_files.'';
        $datos['return'] = exec('sudo -u www-data HOME=/var/www /usr/bin/python3 "/var/www/html/sicor_extendido_80/scripts/firmas_html/doc_para_coser.py" '.$arr_files.'');


        $datos_arr=explode(' ', $datos['return']);
        if(!isset($datos_arr[1])){
            $datos['file']=0;
            $datos['return']=0;
        }
        else if($datos_arr[1]=='OK'){
            $datos['file']=str_replace("file://", "", $datos_arr[2]);
            $datos['url']=str_replace("file:///san/www/html/sicor_extendido_80/public", "", $datos_arr[2]);
        }
        else{
            $datos['file']=str_replace("file://", "", $datos_arr[1]);
            $datos['url']=str_replace("file:///san/www/html/sicor_extendido_80/public", "", $datos_arr[1]);
        }
        return $datos;
    }

    public static function documento_convertir_html_pdf_blank($datos_archvios){
        $arr_files='';
        for($i=0;$i<count($datos_archvios); $i++){
            $arr_files.='"'.$datos_archvios[$i].'" ';
        }
        $arr_files=trim($arr_files);


        $datos['exec']='sudo -u www-data HOME=/var/www /usr/bin/python3 "/var/www/html/sicor_extendido_80/scripts/firmas_html_blank/doc_para_coser.py" '.$arr_files.'';
        $datos['return'] = exec('sudo -u www-data HOME=/var/www /usr/bin/python3 "/var/www/html/sicor_extendido_80/scripts/firmas_html_blank/doc_para_coser.py" '.$arr_files.'');


        $datos_arr=explode(' ', $datos['return']);
        if(!isset($datos_arr[1])){
            $datos['file']=0;
            $datos['return']=0;
        }
        else if($datos_arr[1]=='OK'){
            $datos['file']=str_replace("file://", "", $datos_arr[2]);
            $datos['url']=str_replace("file:///san/www/html/sicor_extendido_80/public", "", $datos_arr[2]);
        }
        else{
            $datos['file']=str_replace("file://", "", $datos_arr[1]);
            $datos['url']=str_replace("file:///san/www/html/sicor_extendido_80/public", "", $datos_arr[1]);
        }
        return $datos;
    }

    public static function documento_convertir_pdf($datos_archvios, $filename="", $request="", $proceso=""){

        $arr_files='';
        for($i=0;$i<count($datos_archvios); $i++){
            $arr_files.='"'.$datos_archvios[$i].'" ';
        }
        $arr_files=trim($arr_files);

        $datos['exec']='sudo -u www-data HOME=/var/www /usr/bin/python3 "/var/www/html/front_penal_desarrollo/scripts/firmas/doc_para_coser.py3" '.$arr_files.' "'.$filename.'"';
        $datos['return'] = exec('sudo -u www-data HOME=/var/www /usr/bin/python3 "/var/www/html/front_penal_desarrollo/scripts/firmas/doc_para_coser.py3" '.$arr_files.' "'.$filename.'"');

        if($proceso!=""){
            utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "Return sello sigj " . json_encode($datos));
        }

        //return $datos;
        $datos_arr=explode(' ', $datos['return']);


        if(!isset($datos_arr[1])){
            $datos['return_error']=$datos['return'];
            $datos['file']="0";
            $datos['return']="0";

        }
        else if($datos_arr[0]=='Error'){
            $datos['return_error']=$datos['return'];
            $datos['file']="0";
            $datos['return']="0";
        }
        else if($datos_arr[1]=='Error'){
            $datos['return_error']=$datos['return'];
            $datos['file']="0";
            $datos['return']="0";
        }
        else if(isset($datos_arr[2]) and $datos_arr[2]=='Error'){
            $datos['return_error']=$datos['return'];
            $datos['file']="0";
            $datos['return']="0";
        }
        else if($datos_arr[1]=='OK' and $datos_arr[2]!="Error"){
            $datos['file']=$datos_arr[2];

            $arr_file = pathinfo($datos_arr[2]);
            $url='/san/www/html/front_penal_desarrollo/storage/app/porfirmar/'.$arr_file['filename'].'.pdf';
            File::copy($datos['file'], $url);
            $datos['url']='/temporales/'.$arr_file['filename'].'.pdf';
            $datos['filename']=$arr_file['filename'].'.pdf';

        }
        else{
            $datos['return_error']=$datos['return'];
            $datos['file']="0";
            $datos['return']="0";

            /*
            $datos['file']=$datos_arr[1];

            $arr_file = pathinfo($datos_arr[1]);
            $url='/san/www/html/sicor_extendido_80/public/temporales/'.$arr_file['filename'].'.pdf';
            File::copy($datos['file'], $url);
            $datos['url']='/temporales/'.$arr_file['filename'].'.pdf';
            */

        }
        return $datos;
    }

    public static function documento_firmar_base64(Request $request, $word_base64, $extension_word, $acuerdo_id, $organo_acuerdo){
        $b64Doc='error';
        $arr_files='/san/www/html/sicor_extendido_80/storage/app/firmados/documento.'.$extension_word;
        //guardo docx para firma
        $data = base64_decode($word_base64);
        file_put_contents($arr_files,$data);

        //se obtiene la firma
        $lista_txt_firma=bandejas::obtener_firma_sicor_acuerdo($request, $acuerdo_id, $organo_acuerdo);
        $file = fopen("/san/www/html/sicor_extendido_80/storage/app/firmados/documento.txt", "r");
        fwrite($file, $lista_txt_firma['response'] . PHP_EOL);
        fclose($file);

        //lo mando a imprimir
        $datos['exec']='sudo -u www-data HOME=/var/www /usr/bin/python3 "/var/www/html/sicor_extendido_80/scripts/firmas/doc_para_coser.py3" '.$arr_files.'';
        $datos['return'] = exec('sudo -u www-data HOME=/var/www /usr/bin/python3 "/var/www/html/sicor_extendido_80/scripts/firmas/doc_para_coser.py3" '.$arr_files.'');

        $datos_arr=explode(' ', $datos['return']);
        if($datos_arr[1]=='OK'){
            $datos['file']=$datos_arr[2];
        }
        else{
            //se regresa el documento en base64
            $datos['file']=$datos_arr[1];
            $b64Doc = chunk_split(base64_encode(file_get_contents($datos_arr[1])));
        }
        return $b64Doc;
    }

    public static function obtener_firma_sicor_acuerdo(Request $request, $acuerdo_id, $organo_acuerdo){

        //se obtiene la lista de archivos
        $response = $request
        ->clienteWS
        ->request('GET', 'obtenerCadenaFirmas/'.$acuerdo_id.'/'.$organo_acuerdo,[
            "query" => [
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

    public static function obtener_firma_sicor_acuerdo_sinse(Request $request, $acuerdo_id, $organo_acuerdo){

        //se obtiene la lista de archivos
        $response = $request
        ->clienteWS
        ->request('GET', 'obtenerCadenaFirmas_sinse/'.$acuerdo_id.'/'.$organo_acuerdo.'/no',[
            "query" => [
            ],
            "headers" => [
                "Content-Type" => "application/json"
            ]
        ]);

        $lista = json_decode($response->getBody(),true) ;
        return $lista;
    }

    public static function voto_particular(Request $request, $juicio_id, $acuerdo_id, $accion, $pdfBase64, $b64Doc){

        //se obtiene la lista de archivos
        $response = $request
        ->clienteWS
        ->request('POST', 'agregar_voto_particular/'.$juicio_id.'/'.$acuerdo_id.'/'.$accion,[
            "json" => [
                "datos" => [
                    "extension" => "pdf",
                    "b64_word" => $b64Doc,
                    "b64_pdf" => $pdfBase64
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

    public static function voto_particular_descarga(Request $request, $juicio_id, $acuerdo_id, $accion){

        //se obtiene la lista de archivos
        $response = $request
        ->clienteWS
        ->request('POST', 'agregar_voto_particular/'.$juicio_id.'/'.$acuerdo_id.'/'.$accion,[
            "json" => [
                "datos" => [
                    "extension" => "pdf",
                    "b64_word" => "-",
                    "b64_pdf" => "-"
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

    // ESTA ES LA FIRMA DEL CONSEJO 
    public static function obtener_firma_firel_acuerdo(Request $request, $url_documento_pdf, $url_certificado, $url_key, $password){

        $name_file = basename($url_documento_pdf);
       
        $b64_pdf=chunk_split( base64_encode( file_get_contents($url_documento_pdf) ), 76, "\r\n");
        $b64_cer=chunk_split( base64_encode( file_get_contents($url_certificado) ), 76, "\r\n");
        $tipo_cer=2;
        $b64_key='';
        if($url_key!=''){
            $b64_key=chunk_split( base64_encode( file_get_contents($url_key)), 76, "\r\n");
            $tipo_cer=1;
        }

        try{

            $url_firel_csj = '';
            $llave_firmado = '';
            
            if($request->entorno["variables_entorno"]["FIREL_CONSEJO_PRODUCCION"]==1){
                $url_firel_csj=$request->entorno["variables_entorno"]["FIREL_CONSEJO_PRODUCCION_URL"];
                $llave_firmado = $request->entorno["variables_entorno"]["FIREL_CONSEJO_PRODUCCION_LLAVE_CIFRADO"];
            }
            else{
                $url_firel_csj=$request->entorno["variables_entorno"]["FIREL_CONSEJO_DESARROLLO_URL"];
                $llave_firmado = $request->entorno["variables_entorno"]["FIREL_CONSEJO_DESARROLLO_LLAVE_CIFRADO"];
            }
            
            $client = new SoapClient($url_firel_csj);
            $wsr= $client->firmaDocumento(array("tipoCertificado" =>$tipo_cer
                                                    ,"documentoDestino"=> $name_file
                                                    ,"contenidoDocument"=>$b64_pdf
                                                    ,"contenidoCer"=> $b64_cer
                                                    ,"contenidoKey"=>$b64_key
                                                    ,"passwd"=>$password
                                                    ,"llaveFirmado"=>$llave_firmado

                    ));

            $results = (array) $wsr;
            $string = $results['firmaDocumentoResult'];

        }
        catch (\Exception $e) {
            $arr_json['estatus']=0;
            $arr_json['resultado']=0;
            $arr_json['msj']="Error - Servicio firel no disponible";
            return $arr_json;
        }

        $arrayjson = json_decode($string,true);
        if( $arrayjson['resultado'] != 1 ){
            $arrayjson['mensaje'] = utf8_encode("Error - Servicio firel => [ ".$arrayjson['resultado'].' : ' .base64_decode( $arrayjson['mensaje']." ] ") );
        }
        return $arrayjson;
        
    }


    public static function subir_documento_firma_tsjcdmx($request, $url_documento_pdf, $referencia){

        $name_file = basename($url_documento_pdf);
        //return $url_documento_pdf;
        $b64_pdf= chunk_split( base64_encode( file_get_contents($url_documento_pdf) ), 76, "\r\n");

        try{
            $firma_arr = array("archivo"=>$b64_pdf
                ,"referencia"=>$referencia
            );

            if($request->entorno["variables_entorno"]["MIFIRMA_PRODUCCION"]==1){
                $url_mifirma=$request->entorno["variables_entorno"]["MIFIRMA_PROD_URL"];
            }
            else{
                $url_mifirma=$request->entorno["variables_entorno"]["MIFIRMA_DESA_URL"];
            }

            $client = new \nusoap_client($url_mifirma, true);
            $client->soap_defencoding = 'UTF-8';
            $client->decode_utf8 = FALSE;

            $wsr = $client->call("subirArchivo", $firma_arr);

        }
        catch (\Exception $e) {
            $arr_json['estatus']=0;
            $arr_json['resultado']=0;
            $arr_json['msj']="Error - Servicio firel no disponible";
            return $arr_json;
        }
        return $wsr;
    }


    public static function crear_participante_firma_tsjcdmx($request, $identificador, $url_certificado, $url_key, $password){

        $b64_cer=chunk_split( base64_encode( file_get_contents($url_certificado) ), 76, "\r\n");
        $tipo_cer=1;
        $b64_key='';
        if($url_key!=''){
            $b64_key=chunk_split( base64_encode( file_get_contents($url_key)), 76, "\r\n");
            $tipo_cer=2;
        }

        try{
            $firma_arr = array("identificadorDocumento"=>$identificador
                ,"tipo"=>$tipo_cer
                ,"certificado"=>$b64_cer
                ,"llavePrivada"=>$b64_key
                ,"pfx"=>$b64_cer
                ,"contrasena"=>$password
                ,"referencia"=>"vacio"
            );

            if($request->entorno["variables_entorno"]["MIFIRMA_PRODUCCION"]==1){
                $url_mifirma=$request->entorno["variables_entorno"]["MIFIRMA_PROD_URL"];
            }
            else{
                $url_mifirma=$request->entorno["variables_entorno"]["MIFIRMA_DESA_URL"];
            }

            $client = new \nusoap_client($url_mifirma, true);
            $client->soap_defencoding = 'UTF-8';
            $client->decode_utf8 = FALSE;

            $wsr = $client->call("firmaAchivo", $firma_arr);

        }
        catch (\Exception $e) {
            $arr_json['estatus']=0;
            $arr_json['resultado']=0;
            $arr_json['msj']="Error - Servicio firel no disponible";
            return $arr_json;
        }
        return $wsr;
    }


    public static function cerrar_firma_tsjcdmx($request, $identificador, $nombre_documento, $arr_participantes){

        try{
            $firma_arr = array("identificadorDocumento"=>$identificador
                ,"nombreDocumento"=>$nombre_documento
                ,"transferencias"=>$arr_participantes
                ,"referencia"=>"vacio"
            );

            if($request->entorno["variables_entorno"]["MIFIRMA_PRODUCCION"]==1){
                $url_mifirma=$request->entorno["variables_entorno"]["MIFIRMA_PROD_URL"];
            }
            else{
                $url_mifirma=$request->entorno["variables_entorno"]["MIFIRMA_DESA_URL"];
            }

            $client = new \nusoap_client($url_mifirma, true);
            $client->soap_defencoding = 'UTF-8';
            $client->decode_utf8 = FALSE;

            $wsr = $client->call("generaPDF", $firma_arr);

        }
        catch (\Exception $e) {
            $arr_json['estatus']=0;
            $arr_json['resultado']=0;
            $arr_json['msj']="Error - Servicio firel no disponible";
            return $arr_json;
        }
        return $wsr;
    }


    public static function obtener_firma_tsjcdmx_acuerdo($request, $url_documento_pdf, $url_certificado, $url_key, $password){


        //$url_documento_pdf='/san/www/html/sicor_extendido/storage/app/public/123.pdf';
        $name_file = basename($url_documento_pdf);
        //return $url_documento_pdf;
        $b64_pdf=  base64_encode( file_get_contents($url_documento_pdf) );
        $pfx=  base64_encode( file_get_contents($url_certificado) );
        $b64_cer= base64_encode( file_get_contents($url_certificado) );
        $tipo_cer=1;
        $b64_key='';
        if($url_key!=''){
            $b64_key= base64_encode( file_get_contents($url_key));
            $tipo_cer=2;
        }

        try{

            $firma_arr = array("archivoOriginal"=>$b64_pdf
                ,"nombreArchivo"=> $name_file
                ,"tipo" =>$tipo_cer
                ,"pfx"=> $pfx
                ,"certificado"=> $b64_cer
                ,"llavePrivada"=> $b64_key
                ,"contrasena"=>$password
                ,"referencia"=>'vacio'
            );
           
            if($request->entorno["variables_entorno"]["MIFIRMA_PRODUCCION"]==1){
                $url_mifirma=$request->entorno["variables_entorno"]["MIFIRMA_PROD_URL"];
            }
            else{
                $url_mifirma=$request->entorno["variables_entorno"]["MIFIRMA_DESA_URL"];
            }

            $client = new \nusoap_client($url_mifirma, true);
            $client->soap_defencoding = 'UTF-8';
            $client->decode_utf8 = TRUE;
            $client->response_timeout = 180;

            $wsr = $client->call("firmaPFX", $firma_arr);
            
        }
        catch (\Exception $e) {
            
            $arr_json['wsr']=$wsr;
            $arr_json['estatus']=0;
            $arr_json['resultado']=0;
            $arr_json['msj']="Error - Servicio firel no disponible";
            return $arr_json;
            
        }

        if($wsr['firmaPFXResult']['estado'] == 0){

            $arr_json['resultado'] = 1;
            $arr_json['documento'] = $wsr['firmaPFXResult']['pdfEvidencia'];

        }else {
            $arr_json['resultado'] = 0;
            $arr_json['msj'] = $wsr['firmaPFXResult']['descripcion'];
        }
        return $arr_json;
    }

    public static function documento_coser_pdf($datos_archvios){

        //return $datos_archvios;
        $proceso = rand(100, 999);

        $arr_files='';
        for($i=0;$i<count($datos_archvios); $i++){

            $nombre_documento = pathinfo(storage_path($datos_archvios[$i]), PATHINFO_FILENAME);
            $url_firma='/san/www/html/sicor_extendido_80/storage/app/porfirmar/'.bin2hex(random_bytes(8)).$nombre_documento;
            //se copian las ligas en la carpeta
            $source = file_get_contents($datos_archvios[$i]);
            file_put_contents($url_firma, $source);
            $arr_files.='"'.$url_firma.'" ';
        }
        $arr_files=trim($arr_files);

        $datos['exec']='sudo -u www-data HOME=/var/www /usr/bin/python3 "/var/www/html/sicor_extendido_80/scripts/firmas/doc_para_coser.py3" --coser '.$arr_files.'';
        $datos['return'] = exec('sudo -u www-data HOME=/var/www /usr/bin/python3 "/var/www/html/sicor_extendido_80/scripts/firmas/doc_para_coser.py3" --coser '.$arr_files.'');

        $datos_arr=explode(' ', $datos['return']);

        utilidades::guardarLog("", 'coser_pdf', $proceso, 2, json_encode($datos_arr) );


        if(isset($datos_arr[1]) and $datos_arr[1]=='OK'){
            $datos['file']=$datos_arr[2];
        }
        else if(isset($datos_arr[1])){
            $datos['file']=$datos_arr[1];
        }
        else {
            $datos['file']=$datos_arr[0];
        }
        return $datos;
    }

    /*
    *   SE BLOQUEA EL ARCHIVO
    */
    public static function candado_firmado(Request $request, $acuerdo_id, $bandera){
        //se obtiene la lista de archivos
        $response = $request
        ->clienteWS
        ->request('POST', 'registro_prefirmado/'.$acuerdo_id.'/'.$bandera,[
            "query" => [
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id")
            ]
        ]);

        $lista = json_decode($response->getBody(),true) ;
        return $lista;
    }

    /*
    *   METODOS PLUGIN
    */
    public static function documento_firmar_base64_ivn(Request $request, $sesion, $word_base64, $extension_word, $acuerdo_id, $organo_acuerdo){
        $response = array();
        $b64Doc='error';
        $arr_files='/san/www/html/sicor_extendido_80/storage/app/firmados/documento.'.$extension_word;
        //guardo docx para firma
        $data = base64_decode($word_base64);
        file_put_contents($arr_files,$data);

        //se obtiene la firma
        $lista_txt_firma=bandejas::obtener_firma_sicor_acuerdo_ivn($request, $sesion, $acuerdo_id, $organo_acuerdo);
        Storage::put('firmados/firma.txt', utf8_decode($lista_txt_firma["response"]));

        //lo mando a imprimir
        $datos['exec']='sudo -u www-data HOME=/var/www /usr/bin/python3 "/var/www/html/sicor_extendido_80/scripts/firmas/doc_para_coser.py3" '.$arr_files.'';
        $datos['return'] = exec('sudo -u www-data HOME=/var/www /usr/bin/python3 "/var/www/html/sicor_extendido_80/scripts/firmas/doc_para_coser.py3" '.$arr_files.'');

        $datos_arr=explode(' ', $datos['return']);
        if($datos_arr[1]=='OK'){
            $datos['file']=$datos_arr[2];
            $b64Doc = chunk_split(base64_encode(file_get_contents($datos_arr[2])));
            array_push($response, 100, $b64Doc, $lista_txt_firma["response"]);
        }
        else{
            //se regresa el documento en base64
            $datos['file']=$datos_arr[1];
            array_push($response, 200, "", "");
        }

        return $response;
    }

    public static function obtener_firma_sicor_acuerdo_ivn(Request $request, $sesion, $acuerdo_id, $organo_acuerdo){

        //se obtiene la lista de archivos
        $response = $request
        ->clienteWS
        ->request('GET', 'obtenerCadenaFirmas/'.$acuerdo_id.'/'.$organo_acuerdo,[
            "query" => [
            ],
            "headers" => [
                "sesion-id" => $sesion["sesion_id"],
                "cadena-sesion" => $sesion["cadena_sesion"],
                "usuario-id" => $sesion["usuario_id"],
                "Content-Type" => "application/json"
            ]
        ]);

        $lista = json_decode($response->getBody(),true) ;
        return $lista;
    }

    // 
    // AGREGAR QR MIDE A DOCUMENTOS
    // 
    
	public static function obtener_QR(Request $request, $param){
		//$param['documento_nombre_publico']
        //$param['documento_url_local']
        //$param['area_firmante']
        //$param['nombre_firmante']

        if($request->entorno["variables_entorno"]["MIDE_ACTIVO"]==1){

            $url_mide = '';
            $token_mide = '';
            
            if($request->entorno["variables_entorno"]["MIDE_PRODUCCION"]==1){
                $url_mide=$request->entorno["variables_entorno"]["MIDE_PRODUCCION_URL"];
                $token_mide = $request->entorno["variables_entorno"]["MIDE_TOKEN_PRODUCCION"];
            }
            else{
                $url_mide=$request->entorno["variables_entorno"]["MIDE_DESARROLLO_URL"];
                $token_mide = $request->entorno["variables_entorno"]["MIDE_TOKEN_DESARROLLO"];
            }

		
            $qr_request = array(
                        'datos_documento_entrada' => [
                        'token' => $token_mide
                        , 't_documento' => $param['documento_nombre_publico'].'.pdf'
                        , 'fecha_documento' => date('Y-m-d')
                        , 'ecc' => 'H'
                        , 'size' => '2'
                        , 'publico' => 1
                        , 'documento' => base64_encode( file_get_contents($param['documento_url_local']) )
                        , 'areaEmite' => 'SISTEMA PENAL'//$param['area_firmante']
                        , 'usuarioEmite' => 'PENAL'//$param['nombre_firmante']
                        , 'CoordX' => '175'
                        , 'CoordY' => '260'
                        //, 'UUID' => $token_mide 
                        ]
                    );
            
            
            try {
                
                $client = new \nusoap_client( $url_mide, true );
                $client->soap_defencoding = 'UTF-8';
                $client->decode_utf8 = TRUE;
                $client->response_timeout = 180;

                $qr_response = $client->call("getQR", $qr_request);
                //dd($qr_response);
                $response = array('status'  => $qr_response['estatus'], 'message' =>'Mide: '.$qr_response['mensaje'] , 'documento_sellado_b64' => $qr_response['pdfSellado']);

            } catch ( \Exception $e) {
                return array('estatus' => 0, 'message' => 'Error Exception - Mide :'.$e->getMessage());
            }
    
            if ($response['status']) {
                
                $nombre_archivo = rand().'-'.$param['documento_nombre_publico'].'-'.rand().'.pdf';
                $ruta_archivo_local = base_path().'/storage/temp_qr/'.$nombre_archivo;

                if ( file_exists($ruta_archivo_local) ){
                    unlink ( $ruta_archivo_local );
                }

                file_put_contents($ruta_archivo_local, base64_decode($response['documento_sellado_b64']));
                return array('status' => 100, 'message' => 'QR SUCCESS', 'response'=>'/archivos_qr/'.$nombre_archivo, 'url_local' =>$ruta_archivo_local );
            }else{
                return $response;
            }
        }
        else{
            $nombre_archivo = rand().'-'.$param['documento_nombre_publico'].'-'.rand().'.pdf';
            $ruta_archivo_local = base_path().'/storage/temp_qr/'.$nombre_archivo;
            copy( $param['documento_url_local'] , $ruta_archivo_local  );
            return array('status' => 100, 'message' => 'QR DISABLED', 'response'=>'/archivos_qr/'.$nombre_archivo, 'url_local' =>$ruta_archivo_local );
        }
	}
    

}
