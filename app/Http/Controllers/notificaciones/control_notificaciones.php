<?php

namespace App\Http\Controllers\notificaciones;

use App\Http\Controllers\clases\acuerdos;
use App\Http\Controllers\clases\bandejas;
use App\Http\Controllers\clases\litigantes;
use App\Http\Controllers\clases\notificaciones;
use App\Http\Controllers\clases\archivos;
use App\Http\Controllers\clases\utilidades;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\clases\humanRelativeDate;
use App\Http\Controllers\clases\DocxConversion;
use Storage;
 
class control_notificaciones extends Controller
{ 
    public function inicio( Request $request, $bandeja ){

        if($bandeja=="notificado" or $bandeja=="sin_notificar"){
            $lista=notificaciones::obtener_notificaciones_acuerdo($request, $bandeja);
            //dd($lista);
        }
        else if($bandeja=="revision_info" or $bandeja=="informacion_partes"){
            if($bandeja=="revision_info"){
                $lista=notificaciones::obtener_notificacion_electronica_correcciones($request, "sa");
                //dd($lista);
            }
            else{
                $lista=notificaciones::obtener_notificacion_electronica_correcciones($request, "actuario");
            }

        }
        else{
            if($bandeja=="fisicas_notificados"){
                $lista=notificaciones::obtener_notificaciones_electronicas($request, "notificado");
                //dd($lista);
            }
            else{
                $lista=notificaciones::obtener_notificaciones_electronicas($request, "sin_notificar");
                //dd($lista);
            }
        }
        
        return view( "notificaciones.notificaciones",
                        ["entorno"=>$request->entorno, 
                        "request"=>$request,
                        "sesion"=>$request->session()->all(),  
                        "menu_general"=>$request->menu_general,
                        "lista"=>$lista,
                        "bandeja"=>$bandeja,
                        ] 
                    );
    }

    public function notificar_acuerdo_resumen(Request $request ){
        $input = $request->all();

        $lista=notificaciones::acuerdo_notificaciones_detalles($request, $input['id']);

        $plantilla_archivo_body=print_r($lista, true);
        $plantilla_archivo_header='';

        include "plantilla_notificacion_resumen.php";
        return response()->json(['plantilla_archivo_header'=>$plantilla_archivo_header, 'plantilla_archivo_body'=>$plantilla_archivo_body]);

    }
   
    public function mostrar_partes( Request $request ){

        $input = $request->all();
        $juicio_id=$input['id'];

        

        $lista_archivos=archivos::obtener_archivo_sinse($request, $input['id'], $input['usuario-juzgado']);
        $plantilla_archivo_body=print_r($lista_archivos, true);
        $plantilla_archivo_header='';

        include "plantilla_info_notificacion.php";
        return response()->json(['plantilla_archivo_header'=>$plantilla_archivo_header, 'plantilla_archivo_body'=>$plantilla_archivo_body]);
    }


    public function consultar_estatus_error_parte( Request $request ){

        $boton_guardar=1;
        $input = $request->all();
        $juicio_id=$input['id_juicio'];
        

        $lista_archivos=archivos::obtener_archivo($request, $input['id_juicio']);
        $plantilla_archivo_body=print_r($lista_archivos, true);
        $plantilla_archivo_header='';

        include "plantilla_info_notificacion.php";
        return response()->json(['plantilla_archivo_header'=>$plantilla_archivo_header, 'plantilla_archivo_body'=>$plantilla_archivo_body]);
    }


    public function cargar_step( Request $request){

        $input = $request->all();

        $lista_archivos=archivos::obtener_archivo($request, $input['id_juicio']);
        $bandera_firmado=0;

        if(isset($lista_archivos['response']['partes']['partes']['actor'])){
            for($i=0; $i<count($lista_archivos['response']['partes']['partes']['actor']); $i++){
                $datos_usuario=[];
                if($lista_archivos['response']['partes']['partes']['actor'][$i]['notificacion']=="si"){
                    $datos_usuario['nombre']=$lista_archivos['response']['partes']['partes']['actor'][$i]['nombre'];
                    $datos_usuario['correo']=$lista_archivos['response']['partes']['partes']['actor'][$i]['correo'];
                    $datos_usuario['tipo']='Actor';
                    
                    //se gurada en local
                    $url_local='/san/www/html/sicor_extendido_80/storage/app/documentos/tmp/'.$input['notificacion_id'].'_'.$lista_archivos['response']['partes']['partes']['actor'][$i]['id'].'_1.pdf';
                    $datos_usuario['url']=$url_local;
                    if(file_exists($url_local)){
                        $bandera_firmado=1;
                        copy($url_local, '/var/www/html/sicor_extendido_80/public/temporales/'.$input['notificacion_id'].'_'.$lista_archivos['response']['partes']['partes']['actor'][$i]['id'].'_1.pdf');
                        $datos_usuario['url']='/temporales/'.$input['notificacion_id'].'_'.$lista_archivos['response']['partes']['partes']['actor'][$i]['id'].'_1.pdf';
                    }
                    $datos_finales[]=$datos_usuario;
                }
            }
        }

        if(isset($lista_archivos['response']['partes']['partes']['demandado'][0]['nombre'])){
            for($i=0; $i<count($lista_archivos['response']['partes']['partes']['demandado']); $i++){

                $datos_usuario=[];
                if($lista_archivos['response']['partes']['partes']['demandado'][$i]['notificacion']=="si"){
                    $datos_usuario['nombre']=$lista_archivos['response']['partes']['partes']['demandado'][$i]['nombre'];
                    $datos_usuario['correo']=$lista_archivos['response']['partes']['partes']['demandado'][$i]['correo'];
                    $datos_usuario['tipo']='Demandado';

                    //se gurada en local
                    $url_local='/san/www/html/sicor_extendido_80/storage/app/documentos/tmp/'.$input['notificacion_id'].'_'.$lista_archivos['response']['partes']['partes']['demandado'][$i]['id'].'_1.pdf';
                    if(file_exists($url_local)){
                        $bandera_firmado=1;
                        copy($url_local, '/var/www/html/sicor_extendido_80/public/temporales/'.$input['notificacion_id'].'_'.$lista_archivos['response']['partes']['partes']['demandado'][$i]['id'].'_1.pdf');
                        $datos_usuario['url']='/temporales/'.$input['notificacion_id'].'_'.$lista_archivos['response']['partes']['partes']['demandado'][$i]['id'].'_1.pdf';
                    }

                    $datos_finales[]=$datos_usuario;
                }
            }
        }

        $return=[];

        if($bandera_firmado==1){
            $return[]=1;
            $return[]=$datos_finales;
            return $return;
        }
        else{
            $return[]=0;
            return $return;
        }
    }

    public function mostrar_editor_html( Request $request){
         
        $input = $request->all();

        //se pone la plantilla
        $plantilla_archivo_body="";
        $plantilla_archivo_header='';
        $contenido="";
        $texto=$input["texto"];

        $lista_archivos=archivos::obtener_archivo_sinse($request, $input['id'], $input['usuario-juzgado']);
        $plantilla_archivo_body=print_r($lista_archivos, true);

 
        if($input["texto"]==1){

            $exists = Storage::exists('documentos/tmp/'.$input['notificacion_id'].'_1.html');
            if($exists){
                unlink('/san/www/html/sicor_extendido_80/storage/app/documentos/tmp/'.$input['notificacion_id'].'_1.html'); 
            }

            
            Storage::copy('documentos/formato_cedula_notificacion.html', 'documentos/tmp/'.$input['notificacion_id'].'_1.html');
            
            $contenido = Storage::get('documentos/tmp/'.$input['notificacion_id'].'_1.html');
        }
        else if($input["texto"]==2){

            $exists = Storage::exists('documentos/tmp/'.$input['notificacion_id'].'_2.html');

            if($exists){
                unlink('/san/www/html/sicor_extendido_80/storage/app/documentos/tmp/'.$input['notificacion_id'].'_2.html'); 
            }

            
            Storage::copy('documentos/formato_notificacion_firma.html', 'documentos/tmp/'.$input['notificacion_id'].'_2.html');
            
            $contenido = Storage::get('documentos/tmp/'.$input['notificacion_id'].'_2.html');
        }

      
        $actor="";
        if(isset($lista_archivos['response']['partes']['partes']['actor'])){
            for($i=0; $i<count($lista_archivos['response']['partes']['partes']['actor']); $i++){
                if($i==0){
                    $actor.=$lista_archivos['response']['partes']['partes']['actor'][$i]['nombre'];
                }
                else{
                    $actor.=', ' . $lista_archivos['response']['partes']['partes']['actor'][$i]['nombre'];
                }
            }
        }
        $demandado="";
        if(isset($lista_archivos['response']['partes']['partes']['demandado'][0]['nombre'])){
            for($i=0; $i<count($lista_archivos['response']['partes']['partes']['demandado']); $i++){
                if($i==0){
                    $demandado.=$lista_archivos['response']['partes']['partes']['demandado'][$i]['nombre'];
                }
                else{
                    $demandado.=', ' . $lista_archivos['response']['partes']['partes']['demandado'][$i]['nombre'];
                }
            }
        }
        $contenido=str_replace('[%TIPO_JUICIO%]', $lista_archivos['response']['datos_toca'][0]['juicio'], $contenido);
        $contenido=str_replace('[%PARTE_ACTOR%]', $actor, $contenido);
        $contenido=str_replace('[%PARTE_DEMANDADO%]', $demandado, $contenido);
        $contenido=str_replace('[%NUM_EXPEDIENTE%]', $lista_archivos['response']['datos_toca'][0]['expediente']."/".$lista_archivos['response']['datos_toca'][0]['anio'], $contenido);
        $contenido=str_replace('[%JUZGADO%]', $lista_archivos['response']['juzgado'][0]['nombre'], $contenido);


        include "plantilla_notificador_html.php";
        return response()->json(['plantilla_archivo_header'=>$plantilla_archivo_header, 'plantilla_archivo_body'=>$plantilla_archivo_body]);
    }

    public function guardar_notificion_correo_actuario( Request $request ){
        $proceso = rand(100, 999);

        //se convierten los dos documentos
        $input = $request->all();
        $documento_html="";
        $response=[];
       
        $bandera=0;
        $url_pfx=$url_cer=$url_key="";

        if($input['tipo_firma_firel']=='firel'){
            if($request->archivo_pfx->isValid()){
                $url_pfx=$request->archivo_pfx->store('private');
                $bandera=1;
            }
        }
        else if($input['tipo_firma_firel']=='fiel'){
            if($request->archivo_key->isValid()){
                $url_key=$request->archivo_key->store('private');
                $bandera=1;
            }
            else{
                $bandera=0;
            }
            if($request->archivo_cer->isValid()){
                $url_cer=$request->archivo_cer->store('private');
                $bandera=1;
            }
            else{
                $bandera=0;
            }
        }
        else if($input['tipo_firma_firel']=='firel_tsj'){
            if($request->archivo_pfx->isValid()){
                $url_pfx=$request->archivo_pfx->store('private');
                $bandera=1;
            }
        }
        else if($input['tipo_firma_firel']=='fiel_tsj'){
            if($request->archivo_key->isValid()){
                $url_key=$request->archivo_key->store('private');
                $bandera=1;
            }
            else{
                $bandera=0;
            }
            if($request->archivo_cer->isValid()){
                $url_cer=$request->archivo_cer->store('private');
                $bandera=1;
            }
            else{
                $bandera=0;
            }
        }

        if($bandera==1){

            $lista_archivos=archivos::obtener_archivo_sinse($request, $input['modal_correo_id_juicio'], $input['modal_correo_codigo_organo']);

            $return=[];
            $file_historico=[];
            $file_historico_txt = "";
            $return[]=$input;
            $return[]=$lista_archivos;
            $texto_nuevo="";

            //se guarda el juzgado
            Storage::put('firmados/juzgado_nombre.txt', ucwords(strtolower($lista_archivos['response']['juzgado'][0]['nombre'])));


            

            //se pide el acuerdo
            $lista_flujo=acuerdos::obtener_ultima_version_acuerdo_sinse($request, $input['modal_correo_id_acuerdo'], $input['modal_correo_codigo_organo']);
            $return[]=$lista_flujo;
            $ultima_version=$lista_flujo['response'];

            $return[]=$lista_documento=bandejas::documento_descargar($request, $input['modal_correo_id_acuerdo'], $input['modal_correo_codigo_organo'], $ultima_version, 'word');
            

            $texto_nuevo_inicial="";
            $extension=pathinfo($lista_documento['response'], PATHINFO_EXTENSION);
            if($extension=='html'){
                $texto_nuevo_inicial = file_get_contents($lista_documento['response']);
                
            }
            else{
                $source=$lista_documento['response'];
                $doc_url= public_path('temporales')."/doc_notificado_".$proceso."_".$input['modal_correo_notificacion_id'].".".$extension;
                copy($lista_documento['response'], $doc_url);
                $docObj = new DocxConversion($doc_url);
                $docText= $docObj->convertToText();
                $texto_nuevo_inicial = nl2br($docText);
            }

            
            $datos_finales=[];

            
            if(isset($lista_archivos['response']['partes']['partes']['actor'])){
                for($i=0; $i<count($lista_archivos['response']['partes']['partes']['actor']); $i++){
                    $datos_usuario=[];
                    if($lista_archivos['response']['partes']['partes']['actor'][$i]['notificacion']=="2"){
                        $return[]=$i;

                        $file_historico_txt="";
                        $arr_acuerdos_historico=explode(',', $lista_archivos['response']['partes']['partes']['actor'][$i]['extras']);
                        for($j=0; $j<count($arr_acuerdos_historico); $j++){
                            if($arr_acuerdos_historico[$j]!=""){
                                //se pide el acuerdo
                                $lista_flujo=acuerdos::obtener_ultima_version_acuerdo_sinse($request, $arr_acuerdos_historico[$j], $input['modal_correo_codigo_organo']);
                                $return[]=$lista_flujo;
                                $ultima_version=$lista_flujo['response'];
                                $return[]=$lista_documento=bandejas::documento_descargar($request, $arr_acuerdos_historico[$j], $input['modal_correo_codigo_organo'], $ultima_version, 'word');
                                

                                $extension=pathinfo($lista_documento['response'], PATHINFO_EXTENSION);
                                if($extension=='html'){ 
                                    $texto_nuevo = file_get_contents($lista_documento['response']);
                                    $return[] = $file_historico_txt .= '<hr>' . $texto_nuevo;
                                }
                                else{ 
                                    $source=$lista_documento['response'];
                                    $doc_url= public_path('temporales')."/doc_notificado_".$proceso."_".$input['modal_correo_notificacion_id'].'_'.$lista_archivos['response']['partes']['partes']['actor'][$i]['id'].".".$extension;
                                    copy($lista_documento['response'], $doc_url);
                                    $docObj = new DocxConversion($doc_url);
                                    $docText= $docObj->convertToText();
                                    $file_historico_txt .= '<hr>' .nl2br($docText);
                                }
                            }
                        }

                        $file_historico_txt = $texto_nuevo_inicial . $file_historico_txt;

                        $return[]=$file_historico_txt;


                        $datos_usuario['nombre']=$lista_archivos['response']['partes']['partes']['actor'][$i]['nombre'];
                        $datos_usuario['correo']=$lista_archivos['response']['partes']['partes']['actor'][$i]['correo'];
                        $datos_usuario['id_parte']=$lista_archivos['response']['partes']['partes']['actor'][$i]['id'];
                        $datos_usuario['tipo']='Actor';

                        //se personaliza el texto
                        $contenido = $input['modal_correo_texto1'];
                        $contenido=str_replace('[%PARTE_NOMBRE%]', $datos_usuario['nombre'], $contenido);
                        
                        //se gurada en local
                        $url_local='/san/www/html/sicor_extendido_80/storage/app/documentos/tmp/'.$proceso.'_'.$input['modal_correo_notificacion_id'].'_'.$lista_archivos['response']['partes']['partes']['actor'][$i]['id'].'_1';
                        $file = fopen($url_local.'.html', "w");
                        fwrite($file, '<body>'.$contenido.$file_historico_txt.$input['modal_correo_texto2'].'</body>');
                        fclose($file);


                        //se manda a convertir a pdf
                        $datos_archvios=[];
                        $datos_archvios[]=$url_local.'.html';
                        $return[]=$doc_arr_1=bandejas::documento_convertir_html_pdf($datos_archvios);
                        

                        //se obtiene el numero de hojas
                        $output = shell_exec("pdfinfo ".$doc_arr_1['file']);
                        preg_match('/Pages:\s+([0-9]+)/', $output, $pagecountmatches);
                        $pagecount = $pagecountmatches[1];

                        //se divide el documento
                        $url_separados=public_path('temporales')."/doc_notificado_".$proceso."_".$input['modal_correo_notificacion_id'].'_'.$lista_archivos['response']['partes']['partes']['actor'][$i]['id']."_";
                        $url_separados_comodin=public_path('temporales')."/doc_notificado_".$proceso."_".$input['modal_correo_notificacion_id'].'_'.$lista_archivos['response']['partes']['partes']['actor'][$i]['id']."_%04d.pdf";

                        $shell_burst="pdftk ".$doc_arr_1['file']." burst output ".$url_separados_comodin;
                        $output = shell_exec($shell_burst);
                        
                        //se firma
                        $docuemntoPDF=$url_separados.(utilidades::acomodarCeros($pagecount, 4)).".pdf";

                        if($input['tipo_firma_firel']=='firel'){
                            $documentoCER='/san/www/html/sicor_extendido_80/storage/app/'.$url_pfx;
                            $return[]=$pdfFirmado=bandejas::obtener_firma_firel_acuerdo($docuemntoPDF, $documentoCER, "", $input['password']);
                        }
                        else if($input['tipo_firma_firel']=='fiel'){
                            $documentoCER='/san/www/html/sicor_extendido_80/storage/app/'.$url_cer;
                            $documentoKEY='/san/www/html/sicor_extendido_80/storage/app/'.$url_key;
                            $return[]=$pdfFirmado=bandejas::obtener_firma_firel_acuerdo($docuemntoPDF, $documentoCER, $documentoKEY, $input['password']);
                        }

                        else if($input['tipo_firma_firel']=='firel_tsj'){
                            $documentoCER='/san/www/html/sicor_extendido_80/storage/app/'.$url_pfx;
                            $return[]=$pdfFirmado=bandejas::obtener_firma_tsjcdmx_acuerdo($request, $docuemntoPDF, $documentoCER, "", $input['password']);
                        }
                        else if($input['tipo_firma_firel']=='fiel_tsj'){
                            $documentoCER='/san/www/html/sicor_extendido_80/storage/app/'.$url_cer;
                            $documentoKEY='/san/www/html/sicor_extendido_80/storage/app/'.$url_key;
                            $return[]=$pdfFirmado=bandejas::obtener_firma_tsjcdmx_acuerdo($request, $docuemntoPDF, $documentoCER, $documentoKEY, $input['password']);
                        }

                        //se guarda el documento de la firel
                        $url='/san/www/html/sicor_extendido_80/storage/app/documentos/tmp/'.$proceso."_".$input['modal_correo_notificacion_id'].'_'.$lista_archivos['response']['partes']['partes']['actor'][$i]['id'].'_firmado.pdf';
                        $pdf_decoded = base64_decode ($pdfFirmado['documento']);
                        $pdf = fopen ($url,'w');
                        fwrite ($pdf,$pdf_decoded);
                        //close output file
                        fclose ($pdf);

                         //se copia para hacer el sellado
                        copy($url, $docuemntoPDF);

                        $shell_cat="pdftk $url_separados*.pdf cat output ".$doc_arr_1['file'];
                        //print($shell_cat.'<br>');
                        $output = shell_exec($shell_cat);

                        

                        //return $arr_coser;
                        //se copia en la carpeta
                        copy($doc_arr_1['file'], $url_local.'.pdf');

                        $datos_usuario['url']=$doc_arr_1['url'];

                        $datos_finales[]=$datos_usuario;


                        //se agreega a la notificaicon
                        $datos_ligitantes=[];
                        $datos_ligitantes['id_juicio']=$input['modal_correo_id_juicio'];
                        $datos_ligitantes['id_acuerdo']=$input['modal_correo_id_acuerdo'];
                        $datos_ligitantes['id_parte']=$lista_archivos['response']['partes']['partes']['actor'][$i]['id'];
                        //litigantes::agregar_notificacion_enviada($request, $datos_ligitantes);

                    }
                }
            }

            if(isset($lista_archivos['response']['partes']['partes']['demandado'][0]['nombre'])){
                for($i=0; $i<count($lista_archivos['response']['partes']['partes']['demandado']); $i++){

                    $datos_usuario=[];
                    if($lista_archivos['response']['partes']['partes']['demandado'][$i]['notificacion']=="2"){
                        $return[]=$i;

                        $file_historico_txt="";
                        $arr_acuerdos_historico=explode(',', $lista_archivos['response']['partes']['partes']['demandado'][$i]['extras']);
                        for($j=0; $j<count($arr_acuerdos_historico); $j++){
                            if($arr_acuerdos_historico[$j]!=""){
                                //se pide el acuerdo
                                $lista_flujo=acuerdos::obtener_ultima_version_acuerdo_sinse($request, $arr_acuerdos_historico[$j], $input['modal_correo_codigo_organo']);
                                $return[]=$lista_flujo;
                                $ultima_version=$lista_flujo['response'];
                                $return[]=$lista_documento=bandejas::documento_descargar($request, $arr_acuerdos_historico[$j], $input['modal_correo_codigo_organo'], $ultima_version, 'word');
                                

                                $extension=pathinfo($lista_documento['response'], PATHINFO_EXTENSION);
                                if($extension=='html'){ 
                                    $texto_nuevo = file_get_contents($lista_documento['response']);
                                    $return[] = $file_historico_txt .= '<hr>' . $texto_nuevo;
                                }
                                else{ 
                                    $source=$lista_documento['response'];
                                    $doc_url= public_path('temporales')."/doc_notificado_".$proceso."_".$input['modal_correo_notificacion_id'].'_'.$lista_archivos['response']['partes']['partes']['demandado'][$i]['id'].".".$extension;
                                    copy($lista_documento['response'], $doc_url);
                                    $docObj = new DocxConversion($doc_url);
                                    $docText= $docObj->convertToText();
                                    $file_historico_txt .= '<hr>' .nl2br($docText);
                                }
                            }
                        }

                        $file_historico_txt = $texto_nuevo_inicial . $file_historico_txt;

                        $return[]=$file_historico_txt;


                        $datos_usuario['nombre']=$lista_archivos['response']['partes']['partes']['demandado'][$i]['nombre'];
                        $datos_usuario['correo']=$lista_archivos['response']['partes']['partes']['demandado'][$i]['correo'];
                        $datos_usuario['id_parte']=$lista_archivos['response']['partes']['partes']['demandado'][$i]['id'];
                        $datos_usuario['tipo']='Demandado';

                        //se personaliza el texto
                        $contenido = $input['modal_correo_texto1'];
                        $contenido=str_replace('[%PARTE_NOMBRE%]', $datos_usuario['nombre'], $contenido);
                        
                        //se gurada en local
                        $url_local='/san/www/html/sicor_extendido_80/storage/app/documentos/tmp/'.$proceso.'_'.$input['modal_correo_notificacion_id'].'_'.$lista_archivos['response']['partes']['partes']['demandado'][$i]['id'].'_1';
                        $file = fopen($url_local.'.html', "w");
                        fwrite($file, '<body>'.$contenido.$file_historico_txt.$input['modal_correo_texto2'].'</body>');
                        fclose($file);

                        //se guarda el juzgado
                        //Storage::put('firmados/juzgado_nombre.txt', ucwords(strtolower($request->session()->get('juzgado_nombre_largo'))));

                        //se manda a convertir a pdf
                        $datos_archvios=[];
                        $datos_archvios[]=$url_local.'.html';
                        $return[]=$doc_arr_1=bandejas::documento_convertir_html_pdf($datos_archvios);

                        
                        



                        //se obtiene el numero de hojas
                        $output = shell_exec("pdfinfo ".$doc_arr_1['file']);
                        preg_match('/Pages:\s+([0-9]+)/', $output, $pagecountmatches);
                        $pagecount = $pagecountmatches[1];

                        //se divide el documento
                        $url_separados=public_path('temporales')."/doc_notificado_".$proceso."_".$input['modal_correo_notificacion_id'].'_'.$lista_archivos['response']['partes']['partes']['demandado'][$i]['id']."_";
                        $url_separados_comodin=public_path('temporales')."/doc_notificado_".$proceso."_".$input['modal_correo_notificacion_id'].'_'.$lista_archivos['response']['partes']['partes']['demandado'][$i]['id']."_%04d.pdf";

                        $shell_burst="pdftk ".$doc_arr_1['file']." burst output ".$url_separados_comodin;
                        $output = shell_exec($shell_burst);
                        
                        //se firma
                        $docuemntoPDF=$url_separados.(utilidades::acomodarCeros($pagecount, 4)).".pdf";

                        if($input['tipo_firma_firel']=='firel'){
                            $documentoCER='/san/www/html/sicor_extendido_80/storage/app/'.$url_pfx;
                            $return[]=$pdfFirmado=bandejas::obtener_firma_firel_acuerdo($docuemntoPDF, $documentoCER, "", $input['password']);
                        }
                        else if($input['tipo_firma_firel']=='fiel'){
                            $documentoCER='/san/www/html/sicor_extendido_80/storage/app/'.$url_cer;
                            $documentoKEY='/san/www/html/sicor_extendido_80/storage/app/'.$url_key;
                            $return[]=$pdfFirmado=bandejas::obtener_firma_firel_acuerdo($docuemntoPDF, $documentoCER, $documentoKEY, $input['password']);
                        }

                        //se guarda el documento de la firel
                        $url='/san/www/html/sicor_extendido_80/storage/app/documentos/tmp/'.$proceso."_".$input['modal_correo_notificacion_id'].'_'.$lista_archivos['response']['partes']['partes']['demandado'][$i]['id'].'_firmado.pdf';
                        $pdf_decoded = base64_decode ($pdfFirmado['documento']);
                        $pdf = fopen ($url,'w');
                        fwrite ($pdf,$pdf_decoded);
                        //close output file
                        fclose ($pdf);

                         //se copia para hacer el sellado
                        copy($url, $docuemntoPDF);

                        $shell_cat="pdftk $url_separados*.pdf cat output ".$doc_arr_1['file'];
                        //print($shell_cat.'<br>');
                        $output = shell_exec($shell_cat);

                        

                        //return $arr_coser;
                        //se copia en la carpeta
                        copy($doc_arr_1['file'], $url_local.'.pdf');

                        $datos_usuario['url']=$doc_arr_1['url'];

                        $datos_finales[]=$datos_usuario;


                        //se agreega a la notificaicon
                        $datos_ligitantes=[];
                        $datos_ligitantes['id_juicio']=$input['modal_correo_id_juicio'];
                        $datos_ligitantes['id_acuerdo']=$input['modal_correo_id_acuerdo'];
                        $datos_ligitantes['id_parte']=$lista_archivos['response']['partes']['partes']['demandado'][$i]['id'];
                        //litigantes::agregar_notificacion_enviada($request, $datos_ligitantes);
                    
                    }
                }
            }
            

            $response[]=$datos_finales;
            $response[]=$return;
            /*

                //se converte a pdf los dos pdfs
                //se manda a convertir a PDF
                $datos_archvios[]='/san/www/html/sicor_extendido_80/storage/app/documentos/tmp/'.$input['modal_correo_notificacion_id'].'_1.html';
                $return[]=$doc_arr_1=bandejas::documento_convertir_html_pdf_blank($datos_archvios);

                //se cose
                $arr_coser=[];
                $arr_coser[]=$doc_arr_1['file'];
                $arr_coser[]=$lista_documento['response'];
                $arr_coser[]=$url;
                $return[]=bandejas::documento_coser_pdf($arr_coser);

            //}
            */
            
             
        }
        else{
            $error['error']=1;
            $error['mensaje']='El certificado no se cargo exitosamente.';
            return response()->json($error);
        }

        return $response;
    }

    public function notificar_acuerdo_correo( Request $request ){
        $input = $request->all();

        if(!isset($input['noti_elect_estatus_correccion']) or $input['noti_elect_estatus_correccion']==0){
            unset($datos);
            $datos['id_acuerdo_notificacion']=$input['id_acuerdo_notificacion'];
            $datos['codigo_organo']=$request->session()->get('usuario_juzgado');
            $datos['id_parte']=$input['id_parte'];
            $datos['parte_correo']=$input['parte_correo'];
            $datos['tipo_notificacion']=$input['tipo_notificacion'];
            if($input['tipo_notificacion']==3){
                $datos['noti_elect_estatus_envio']="sin notificar";
            }
            else{
                $datos['noti_elect_estatus_envio']="notificado";
            }
            $datos['noti_elect_comentario_correccion']='-';
            $datos['noti_elect_estatus_correccion']="";
        }
        else{
            unset($datos);
            $datos['id_acuerdo_notificacion']=$input['id_acuerdo_notificacion'];
            $datos['codigo_organo']=$request->session()->get('usuario_juzgado');
            $datos['id_parte']=$input['id_parte'];
            $datos['parte_correo']=$input['parte_correo'];
            $datos['tipo_notificacion']=$input['tipo_notificacion'];
            $datos['noti_elect_estatus_envio']="sin notificar";
            $datos['noti_elect_comentario_correccion']=$input['noti_elect_comentario_correccion'];
            $datos['noti_elect_estatus_correccion']="corregir_dato_sa";
        }

        $lista=notificaciones::registrar_notificacion_electronica($request, $datos);
        return response()->json($lista);       
    }

    public function notificar_acuerdo_bandera_fisica( Request $request ){
        $input = $request->all();
        $id_noti_elect=$input['id_noti_elect'];
        $fecha=$input['fecha'];

        $lista=notificaciones::modificar_notificacion_electronica($request, $id_noti_elect, $fecha);

    }

    public function notificar_estatus_error_parte( Request $request ){
        $input = $request->all();
        $id_noti_elect=$input['id_noti_elect'];
        $bandera=$input['bandera'];
        $comentarios=$input['comentarios'];

        $lista=notificaciones::modificar_notificacion_electronica_revision($request, $id_noti_elect, $bandera, $comentarios);

    }

    public function modificar_notificacion_acuerdo( Request $request ){
        $input = $request->all();
        unset($datos);
        $lista=notificaciones::modificar_notificacion_acuerdo($request, $input['id_acuerdo_notificacion']);
        return response()->json($lista);
    }


    public function notificar_acuerdo_not_fisica( Request $request ){
        //se convierten los dos documentos
        $input = $request->all();
       

    

        $lista_archivos=archivos::obtener_archivo($request, $input['modal_correo_id_juicio']);

        $return=[];
        $return[]=$input;
        $return[]=$lista_archivos;
        
        $input['direccion'] = str_replace(array("\r\n", "\n\r", "\r", "\n"), "<br />", $input['direccion']);


        



        $texto="<html><body><br><p align='left'>C. [%PARTE_NOMBRE%]<br><br>
       DOMICILIO:<br> ".$input['direccion']."</p><br>
         
            <p align='justify'>En los autos del juicio [%TIPO_JUICIO%] promovido por [%PARTE_ACTOR%] en contra de [%PARTE_DEMANDADO%], bajo el número de expediente [%NUM_EXPEDIENTE%], el C. Juez dictó el siguiente proveído:</p><br><br>
        
            <br><p align='center'><strong>EXPEDIENTE: [%NUM_EXPEDIENTE%]</strong></p><br><br>
        
        
            <p align='justify'>Dejo la presente cédula de notificación a ________________________________________________________________________________________________________________________________________________________________<br>
            Siendo las _________ horas con ____________ minutos, del día ___________ del mes de ________________ del ".date('Y').".</p><br><br><br><br>
        
            <table width='100%'>
                <tr>
                    <td width='10%'></td>
                    <td width='35%'>____________________</td>
                    <td width='10%'></td>
                    <td width='35%'>____________________</td>
                    <td width='10%'></td>
                </tr>
                <tr>
                    <td width='10%'></td>
                    <td width='30%'>Persona que recibe</td>
                    <td width='20%'></td>
                    <td width='30%'>C. Notificador</td>
                    <td width='10%'></td>
                </tr>
                </table>
       
                                                      </body></html>";


        //se pide el acuerdo
        $ultima_version=$input['modal_correo_ultima_version'];
        $return[]=$lista_documento=bandejas::documento_descargar($request, $input['modal_correo_id_acuerdo'], $input['modal_correo_codigo_organo'], $ultima_version, 'pdf');


        $datos_finales=[];

        
        $actor="";
        $nombre_parte="";
        if(isset($lista_archivos['response']['partes']['partes']['actor'])){
            for($i=0; $i<count($lista_archivos['response']['partes']['partes']['actor']); $i++){
                if($i==0){
                    $actor.=$lista_archivos['response']['partes']['partes']['actor'][$i]['nombre'];
                }
                else{
                    $actor.=', ' . $lista_archivos['response']['partes']['partes']['actor'][$i]['nombre'];
                }
                if($input['id_parte']==$lista_archivos['response']['partes']['partes']['actor'][$i]['id']){
                    $nombre_parte=$lista_archivos['response']['partes']['partes']['actor'][$i]['nombre'];
                }
            }
        }
        $demandado="";
        if(isset($lista_archivos['response']['partes']['partes']['demandado'][0]['nombre'])){
            for($i=0; $i<count($lista_archivos['response']['partes']['partes']['demandado']); $i++){
                if($i==0){
                    $demandado.=$lista_archivos['response']['partes']['partes']['demandado'][$i]['nombre'];
                }
                else{
                    $demandado.=', ' . $lista_archivos['response']['partes']['partes']['demandado'][$i]['nombre'];
                }
                if($input['id_parte']==$lista_archivos['response']['partes']['partes']['demandado'][$i]['id']){
                    $nombre_parte=$lista_archivos['response']['partes']['partes']['demandado'][$i]['nombre'];
                }
            }
        }
        
               
        $contenido=str_replace('[%TIPO_JUICIO%]', $lista_archivos['response']['datos_toca'][0]['juicio'], $texto);
        $contenido=str_replace('[%PARTE_ACTOR%]', $actor, $contenido);
        $contenido=str_replace('[%PARTE_DEMANDADO%]', $demandado, $contenido);
        $contenido=str_replace('[%NUM_EXPEDIENTE%]', $lista_archivos['response']['datos_toca'][0]['expediente']."/".$lista_archivos['response']['datos_toca'][0]['anio'], $contenido);
        $contenido=str_replace('[%JUZGADO%]', $request->session()->get("juzgado_nombre_largo"), $contenido);
        $contenido=str_replace('[%PARTE_NOMBRE%]', $nombre_parte, $contenido);



        //se gurada en local
        $url_local='/san/www/html/sicor_extendido_80/storage/app/documentos/tmp/'.$input['modal_correo_id_acuerdo'].'_'.$input['id_parte'].'_3'; 
        $file = fopen($url_local.'.html', "w");
        fwrite($file, $contenido);
        fclose($file);

        //se guarda el juzgado
        Storage::put('firmados/juzgado_nombre.txt', ucwords(strtolower($request->session()->get('juzgado_nombre_largo'))));

        //se manda a convertir a pdf
        $datos_archvios=[];
        $datos_archvios[]=$url_local.'.html';
        $return[]=$doc_arr_1=bandejas::documento_convertir_html_pdf($datos_archvios);

        //se cose
        $arr_coser=[];
        $arr_coser[]=$doc_arr_1['file'];
        $arr_coser[]=$lista_documento['response'];
        $return[]=$final=bandejas::documento_coser_pdf($arr_coser);

        //se copia en la carpeta
        copy('/var/www/html/sicor_extendido_80/public'.$final['file'], $url_local.'.pdf');
        copy('/var/www/html/sicor_extendido_80/public'.$final['file'], '/var/www/html/sicor_extendido_80/public/notificacion/'.$input['modal_correo_id_acuerdo'].'_'.$input['id_parte'].'_3'.'.pdf');

        $datos_usuario['url']=$final['file'];

        $datos_finales[]=$datos_usuario;





        

        $response=[];
        $response[]=$datos_finales;
        $response[]=$return;
        /*

            //se converte a pdf los dos pdfs
            //se manda a convertir a PDF
            $datos_archvios[]='/san/www/html/sicor_extendido_80/storage/app/documentos/tmp/'.$input['modal_correo_notificacion_id'].'_1.html';
            $return[]=$doc_arr_1=bandejas::documento_convertir_html_pdf_blank($datos_archvios);

            //se cose
            $arr_coser=[];
            $arr_coser[]=$doc_arr_1['file'];
            $arr_coser[]=$lista_documento['response'];
            $arr_coser[]=$url;
            $return[]=bandejas::documento_coser_pdf($arr_coser);

        //}
        */
        

        return $response;
    }

    public function notificar_acuerdo_111( Request $request ){
        $input = $request->all();
        $return = [];
        $bandera=1;
        $url_pfx=$url_cer=$url_key="";
        
        /*
        if($input['tipo_firma_firel']=='firel'){
            if($request->archivo_pfx->isValid()){
                $url_pfx=$request->archivo_pfx->store('private');
                $bandera=1;
            }
        }
        else if($input['tipo_firma_firel']=='fiel'){
            if($request->archivo_key->isValid()){
                $url_key=$request->archivo_key->store('private');
                $bandera=1;
            }
            else{
                $bandera=0;
            }
            if($request->archivo_cer->isValid()){
                $url_cer=$request->archivo_cer->store('private');
                $bandera=1;
            }
            else{
                $bandera=0;
            }
        }
        */

        if($bandera==1){
            /*
            $docuemntoPDF=$input['modal_notificaicon_url'];

            if($input['tipo_firma_firel']=='firel'){
                $documentoCER='/san/www/html/sicor_extendido_80/storage/app/'.$url_pfx;
                $pdfFirmado=bandejas::obtener_firma_firel_acuerdo($docuemntoPDF, $documentoCER, "", $input['password']);
            }
            else if($input['tipo_firma_firel']=='fiel'){
                $documentoCER='/san/www/html/sicor_extendido_80/storage/app/'.$url_cer;
                $documentoKEY='/san/www/html/sicor_extendido_80/storage/app/'.$url_key;
                $pdfFirmado=bandejas::obtener_firma_firel_acuerdo($docuemntoPDF, $documentoCER, $documentoKEY, $input['password']);
            }


            //se envia al storage
            $b64Doc='-';
            for($i=0; $i<110; $i++){
                $b64Doc.='-';
            }

            $b64Doc = $b64Doc;
            $b64PDF = $pdfFirmado['documento'];
            $extension_word = 'docx';
            bandejas::subir_documento_notificacion($request, $input['modal_id_juicio'], $input['modal_id_acuerdo'], $b64PDF);
            */


            
            $datos['modal_id_acuerdo']=$input['modal_id_acuerdo'];
            $datos['id_juicio']=$input['modal_id_juicio'];


            

            
            //$docuemntoPDF= chunk_split(base64_encode(file_get_contents($datos['modal_notificaicon_url'])));
            $lista_archivos=archivos::obtener_archivo_sinse($request, $datos['id_juicio'], $input['modal_correo_codigo_organo']);
            $return[]=$lista_archivos;


            $cuerpo_notificacion='<strong>CÉDULA DE NOTIFICACIÓN TSJCDMX</strong><br><br>
            Mediante el presente, hago de su conocimiento la dirección electrónica que más adelante se proporciona, 
            la cual le permitirá el acceso a la página electrónica del Tribunal, para la consulta de la resolución  
            dictada en los autos del expediente [%NUM_EXPEDIENTE%], relativo al [%TIPO_JUICIO%], 
            promovido por [%PARTE_ACTOR%] en contra de [%PARTE_DEMANDADO%],  en [%JUZGADO%], donde 
            autorizó que las notificaciones personales dictadas en el mismo, se realicen por este medio, lo anterior lo anterior 
            en términos de los párrafos cuarto y quinto, del artículo 113 del Código de Procedimientos Civiles para la Ciudad de México.<br><br><br>

            Dirección electrónica para acceso al sistema y consulta de acuerdo <a href="http://notificacionespj.poderjudicialcdmx.gob.mx" target="_blank">http://notificacionespj.poderjudicialcdmx.gob.mx/</a><br><br><br>

            A T E N T A M E N T E. <br><br><br><br>
            C. Notificador';
            $texto_sms_notificacion='Un Organo Jurisdiccional del PJCDMX determino realizarle una notificacion personal, favor de revisar sus correo para mas informacion';
            $titulo_correo_notificacion='Notificacion electronica: '.$lista_archivos['response']['juzgado'][0]['nombre'];


            $cuerpo_invitacion='<strong>CÉDULA DE NOTIFICACIÓN TSJCDMX</strong><br><br>
            Dando seguimito a su solicitud ante un Órgano Jurisdiccional del Poder Judicial de la CDMX de recibir notificaciones electrónicas, le informamos que es necesario crear una cuenta en el Sistema Integral de Gestión Judicial<br><br> 
            Le hacemos la cordial invitación de ingresar a la siguiente dirección electrónica y registrarse para poder ver el contenido de sus notificaciones <br><br>
            <a href="http://notificacionespj.poderjudicialcdmx.gob.mx/" target="_blank">http://notificacionespj.poderjudicialcdmx.gob.mx/</a><br><br><br>
            <strong>Nota: es importante que al momento del registro utilice el mismo correo que proporciono en el Órgano Jurisdiccional</strong><br>';
            $texto_sms_invitacion='Favor de revisar tu correo electronico para dar seguimineto a su Notificacion Electronica';
            $titulo_correo_invitacion='Seguimiento a la Notificación Electrónica';



            

            $actor="";
            if(isset($lista_archivos['response']['partes']['partes']['actor'])){
                for($i=0; $i<count($lista_archivos['response']['partes']['partes']['actor']); $i++){
                    if($i==0){
                        $actor.=$lista_archivos['response']['partes']['partes']['actor'][$i]['nombre'];
                    }
                    else{
                        $actor.=', ' . $lista_archivos['response']['partes']['partes']['actor'][$i]['nombre'];
                    }
                }
            }
            $demandado="";
            if(isset($lista_archivos['response']['partes']['partes']['demandado'][0]['nombre'])){
                for($i=0; $i<count($lista_archivos['response']['partes']['partes']['demandado']); $i++){
                    if($i==0){
                        $demandado.=$lista_archivos['response']['partes']['partes']['demandado'][$i]['nombre'];
                    }
                    else{
                        $demandado.=', ' . $lista_archivos['response']['partes']['partes']['demandado'][$i]['nombre'];
                    }
                }
            }
            $cuerpo_notificacion=str_replace('[%TIPO_JUICIO%]', $lista_archivos['response']['datos_toca'][0]['juicio'], $cuerpo_notificacion);
            $cuerpo_notificacion=str_replace('[%PARTE_ACTOR%]', $actor, $cuerpo_notificacion);
            $cuerpo_notificacion=str_replace('[%PARTE_DEMANDADO%]', $demandado, $cuerpo_notificacion);
            $cuerpo_notificacion=str_replace('[%NUM_EXPEDIENTE%]', $lista_archivos['response']['datos_toca'][0]['expediente']."/".$lista_archivos['response']['datos_toca'][0]['anio'], $cuerpo_notificacion);
            $cuerpo_notificacion=str_replace('[%JUZGADO%]', $lista_archivos['response']['juzgado'][0]['nombre'], $cuerpo_notificacion);
    





            //se obtienen a los correos
            $datos_finales= [];
            $datos_correo_inv = [];
            
            for($i=0; $i<count($lista_archivos['response']['partes']['partes']['actor']); $i++){
                
                if($lista_archivos['response']['partes']['partes']['actor'][$i]['notificacion']==1 and $lista_archivos['response']['partes']['partes']['actor'][$i]['id']==$input['id_parte']){
                    $bandera1=1;
                    $bandera0=1;
                    if($lista_archivos['response']['partes']['partes']['actor'][$i]['correo']!="" and $lista_archivos['response']['partes']['partes']['actor'][$i]['correo']!="-"){
                        $datos_correo['correo_destinatario']=$lista_archivos['response']['partes']['partes']['actor'][$i]['correo'];
                        $datos_correo_inv['correo_destinatario']=$lista_archivos['response']['partes']['partes']['actor'][$i]['correo'];
                    }
                    else{
                        $datos_correo['correo_destinatario']="";
                        $datos_correo_inv['correo_destinatario']="";
                        $bandera0=0;
                    }
        
                    if($lista_archivos['response']['partes']['partes']['actor'][$i]['telefono']!="" and $lista_archivos['response']['partes']['partes']['actor'][$i]['telefono']!="-"){
                        $datos_correo['telefonos']=$lista_archivos['response']['partes']['partes']['actor'][$i]['telefono'];
                        $datos_correo_inv['telefonos']=$lista_archivos['response']['partes']['partes']['actor'][$i]['telefono'];
                    }
                    else{
                        $datos_correo['telefonos']="";
                        $datos_correo_inv['telefonos']="";
                        $bandera1=0;
                    }
                    
                    $datos_correo['fecha_programacion']=date('Y-m-d H:i:s');
                    $datos_correo['correo_remitente']='sigj@tsjcdmx.gob.mx';
                    $datos_correo['nombre_destinatario']=$lista_archivos['response']['partes']['partes']['actor'][$i]['nombre'];
                    $datos_correo['nombre_remitente']='TSJCDMX';
                    $datos_correo['correo_titulo']=$titulo_correo_notificacion;
                    $datos_correo['mensaje_sms']=$texto_sms_notificacion;
                    $datos_correo['correo_cuerpo']=$cuerpo_notificacion;
                    $datos_correo['id_parte']=$lista_archivos['response']['partes']['partes']['actor'][$i]['id'];
                    $datos_correo['juzgado']=$request->session()->get('usuario_juzgado');
                    $datos_correo['id_acuerdo']=$datos['modal_id_acuerdo'];
                    $datos_correo['cc']=[];
                    $datos_correo['archivos']=[];
                    //$datos_correo['archivos'][0]['url_public']=$docuemntoPDF;

                    

                    if(!isset($lista_archivos['response']['partes']['partes']['actor'][$i]['datos_usuario'][0]['correo']) and $lista_archivos['response']['partes']['partes']['actor'][$i]['notificacion']=="1" ){
                        

                        $datos_correo_inv['fecha_programacion']=date('Y-m-d H:i:s');
                        $datos_correo_inv['correo_remitente']='sigj@tsjcdmx.gob.mx';
                        $datos_correo_inv['nombre_destinatario']=$lista_archivos['response']['partes']['partes']['actor'][$i]['nombre'];
                        $datos_correo_inv['nombre_remitente']='TSJCDMX';
                        $datos_correo_inv['correo_titulo']=$titulo_correo_invitacion;
                        $datos_correo_inv['mensaje_sms']=$texto_sms_invitacion;
                        $datos_correo_inv['correo_cuerpo']=$cuerpo_invitacion;
                        $datos_correo_inv['id_parte']=$lista_archivos['response']['partes']['partes']['actor'][$i]['id'];
                        $datos_correo_inv['juzgado']=$request->session()->get('usuario_juzgado');
                        $datos_correo_inv['id_acuerdo']=$datos['modal_id_acuerdo'];
                        $datos_correo_inv['cc']=[];
                        $datos_correo_inv['archivos']=[];
                        //dd($datos_correo_inv);
                        //$datos_correo_inv_arr[] = $datos_correo_inv;
                        //notificaciones::envio_correos($request, $datos_correo_inv_arr);
                    }

                    if($bandera0==1 ){
                        $datos_finales[] = $datos_correo;

                        //se agreega a la notificaicon
                        $datos_ligitantes['id_juicio']=$datos['id_juicio'];
                        $datos_ligitantes['id_acuerdo']=$datos['modal_id_acuerdo'];
                        $datos_ligitantes['id_parte']=(isset($lista_archivos['response']['partes']['partes']['actor'][$i]['id']))?$lista_archivos['response']['partes']['partes']['actor'][$i]['id']:0;
                        //dd($datos_ligitantes);
                        //$parte=litigantes::agregar_notificacion_enviada($request, $datos_ligitantes);
                        //$return[]=$parte;
                        //$return[]=$datos_ligitantes;

                    }

                    

                }

            }

            if(isset($lista_archivos['response']['partes']['partes']['demandado'][0]['correo'])){
                $datos_correo_inv=[];
                $datos_correo=[];

                for($i=0; $i<count($lista_archivos['response']['partes']['partes']['demandado']); $i++){

                    if($lista_archivos['response']['partes']['partes']['demandado'][$i]['notificacion']==1 and $lista_archivos['response']['partes']['partes']['demandado'][$i]['id']==$input['id_parte']){
        
                        $bandera1=1;
                        $bandera0=1;
                        if($lista_archivos['response']['partes']['partes']['demandado'][$i]['correo']!="" and $lista_archivos['response']['partes']['partes']['demandado'][$i]['correo']!="-"){
                            $datos_correo['correo_destinatario']=$lista_archivos['response']['partes']['partes']['demandado'][$i]['correo'];
                            $datos_correo_inv['correo_destinatario']=$lista_archivos['response']['partes']['partes']['demandado'][$i]['correo'];
                        }
                        else{
                            $datos_correo['correo_destinatario']="";
                            $datos_correo_inv['correo_destinatario']="";
                            $bandera0=0;
                        }
            
                        if($lista_archivos['response']['partes']['partes']['demandado'][$i]['telefono']!="" and $lista_archivos['response']['partes']['partes']['demandado'][$i]['telefono']!="-"){
                            $datos_correo['telefonos']=$lista_archivos['response']['partes']['partes']['demandado'][$i]['telefono'];
                            $datos_correo_inv['telefonos']=$lista_archivos['response']['partes']['partes']['demandado'][$i]['telefono'];
                        }
                        else{
                            $datos_correo['telefonos']="";
                            $datos_correo_inv['telefonos']="";
                            $bandera1=0;
                        }
                        

                        $datos_correo['fecha_programacion']=date('Y-m-d H:i:s');
                        $datos_correo['correo_remitente']='sigj@tsjcdmx.gob.mx';
                        $datos_correo['nombre_destinatario']=$lista_archivos['response']['partes']['partes']['demandado'][$i]['nombre'];
                        $datos_correo['nombre_remitente']='TSJCDMX';
                        $datos_correo['correo_titulo']=$titulo_correo_notificacion;
                        $datos_correo['mensaje_sms']=$texto_sms_notificacion;
                        $datos_correo['correo_cuerpo']=$cuerpo_notificacion;
                        $datos_correo['id_parte']=$lista_archivos['response']['partes']['partes']['demandado'][$i]['id'];
                        $datos_correo['juzgado']=$request->session()->get('usuario_juzgado');
                        $datos_correo['id_acuerdo']=$datos['modal_id_acuerdo'];
                        $datos_correo['cc']=[];
                        $datos_correo['archivos']=[];
                        //$datos_correo['archivos'][0]['url_public']=$docuemntoPDF;


                        //se envia corre de invitación
                        if(!isset($lista_archivos['response']['partes']['partes']['demandado'][$i]['datos_usuario'][0]['correo']) and $lista_archivos['response']['partes']['partes']['demandado'][$i]['notificacion']=="1" ){
                            
                            
                            $datos_correo_inv['fecha_programacion']=date('Y-m-d H:i:s');
                            $datos_correo_inv['correo_remitente']='sigj@tsjcdmx.gob.mx';
                            $datos_correo_inv['nombre_destinatario']=$lista_archivos['response']['partes']['partes']['demandado'][$i]['nombre'];
                            $datos_correo_inv['nombre_remitente']='TSJCDMX';
                            $datos_correo_inv['correo_titulo']=$titulo_correo_invitacion;
                            $datos_correo_inv['mensaje_sms']=$texto_sms_invitacion;
                            $datos_correo_inv['correo_cuerpo']=$cuerpo_invitacion;
                            $datos_correo_inv['id_parte']=$lista_archivos['response']['partes']['partes']['demandado'][$i]['id'];
                            $datos_correo_inv['juzgado']=$request->session()->get('usuario_juzgado');
                            $datos_correo_inv['id_acuerdo']=$datos['modal_id_acuerdo'];
                            $datos_correo_inv['cc']=[];
                            $datos_correo_inv['archivos']=[];
                            //dd($datos_correo_inv);
                            //$datos_correo_inv_arr[] = $datos_correo_inv;
                            //notificaciones::envio_correos($request, $datos_correo_inv_arr);
                        }


                        if($bandera0==1 ){
                            $datos_finales[] = $datos_correo;

                            //se agreega a la notificaicon
                            $datos_ligitantes=[];
                            $datos_ligitantes['id_juicio']=$datos['id_juicio'];
                            $datos_ligitantes['id_acuerdo']=$datos['modal_id_acuerdo'];
                            $datos_ligitantes['id_parte']=(isset($lista_archivos['response']['partes']['partes']['demandado'][$i]['id']))?$lista_archivos['response']['partes']['partes']['demandado'][$i]['id']:0;
                            //$parte=litigantes::agregar_notificacion_enviada($request, $datos_ligitantes);
                            //$return[]=$parte;
                            //$return[]=$datos_ligitantes;
                        }


                        


                    }
                }
            }

            /*
            if(isset($lista_archivos['response']['partes']['partes']['tercero'][0]['correo'])){
                $datos_correo_inv=[];
                $datos_correo=[];

                for($i=0; $i<count($lista_archivos['response']['partes']['partes']['tercero']); $i++){

                    if($lista_archivos['response']['partes']['partes']['tercero'][$i]['notificacion']=="si"){

                        $bandera1=1;
                        $bandera0=1;
                        if($lista_archivos['response']['partes']['partes']['tercero'][$i]['correo']!="" and $lista_archivos['response']['partes']['partes']['tercero'][$i]['correo']!="-"){
                            $datos_correo['correo_destinatario']=$lista_archivos['response']['partes']['partes']['tercero'][$i]['correo'];
                        }
                        else{
                            $datos_correo['correo_destinatario']="";
                            $bandera0=0;
                        }
            
                        if($lista_archivos['response']['partes']['partes']['tercero'][$i]['telefono']!="" and $lista_archivos['response']['partes']['partes']['tercero'][$i]['telefono']!="-"){
                            $datos_correo['telefonos']=$lista_archivos['response']['partes']['partes']['tercero'][$i]['telefono'];
                        }
                        else{
                            $datos_correo['telefonos']="";
                            $bandera1=0;
                        }
                        
                        $datos_correo['fecha_programacion']=date('Y-m-d H:i:s');
                        $datos_correo['correo_remitente']='sigj@tsjcdmx.gob.mx';
                        $datos_correo['nombre_destinatario']=$lista_archivos['response']['partes']['partes']['tercero'][$i]['nombre'];
                        $datos_correo['nombre_remitente']='TSJCDMX';
                        $datos_correo['correo_titulo']=$titulo_correo_notificacion;
                        $datos_correo['mensaje_sms']=$texto_sms_notificacion;
                        $datos_correo['correo_cuerpo']=$cuerpo_notificacion;
                        $datos_correo['id_parte']=$lista_archivos['response']['partes']['partes']['tercero'][$i]['id'];
                        $datos_correo['juzgado']=$request->session()->get('usuario_juzgado');
                        $datos_correo['id_acuerdo']=$datos['modal_id_acuerdo'];
                        $datos_correo['cc']=[];
                        $datos_correo['archivos']=[];
                        //$datos_correo['archivos'][0]['url_public']=$docuemntoPDF;

                        if($bandera0==1){
                            $datos_finales[] = $datos_correo;
                        }

                        //se agreega a la notificaicon
                        $datos_ligitantes['id_juicio']=$datos['id_juicio'];
                        $datos_ligitantes['id_acuerdo']=$datos['modal_id_acuerdo'];
                        $datos_ligitantes['id_parte']=$lista_archivos['response']['partes']['partes']['tercero'][$i]['id'];
                        litigantes::agregar_notificacion_enviada($request, $datos_ligitantes);

                    }
                }
            }
            */

            notificaciones::envio_correos($request, $datos_finales);
            //$lista=acuerdos::modificar_notificacion_electronica($request, $input['modal_notificacion_id']);

            $return[]=$datos_finales;
            //$return[]=$lista;

            return response()->json($return);
        }
        else{
            $error['error']=1;
            $error['mensaje']='El certificado no se cargo exitosamente.';
            return response()->json($error);
        }
    }

}