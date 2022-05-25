<?php

namespace App\Http\Controllers\documentos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\clases\archivos;
use App\Http\Controllers\clases\bandejas;
use App\Http\Controllers\clases\documentos_generados;
use App\Http\Controllers\clases\carpeta_judicial;
use App;
use MrStacy\Html2Mht\Html2Mht;
use GuzzleHttp\Client;
use Session;
use App\Http\Controllers\clases\catalogos;
// use Mpdf;

class DocumentosController extends Controller
{
    public function obtener_pdf_solicitud( Request $reques ){

        $docuento=archivos::obtener_pdf_solicitud($reques, $id_solicitud);

        return $documentos;
    }
 
    public function obtener_ultima_version_acuerdo( Request $request ){

        if(isset($request->id_acuerdo)){

            $documento=archivos::obtener_ultima_version_acuerdo( $request, $request->id_acuerdo, "pdf");
            // return $documento;
            //dd($documento);
            if(!isset($documento['response'])){
                return '<br><br><h3 class="tx-danger"><center>'.$documento['message'].'</center></h3>';
            }
            return redirect($documento['response']);
        }

        $archivo=archivos::obtener_ultima_version_acuerdo( $request, $request->acuerdo, $request->tipo);

        return $archivo;

    }

    public function vista_previa( Request $request){
       
        try {
            if( isset($request->origen) && $request->origen == 'b64' ){
                $tipo_documento = $request->tipo_documento;

                if ( $tipo_documento == 'copia_certificada_sentencia' )
                    $doc = $request->copia_certificada_sentencia;

                else if ( $tipo_documento == 'copia_certificada_auto' )
                    $doc = $request->copia_certificada_auto;

                else if ( $tipo_documento == 'acta_minima' )
                    $doc = $request->acta_minima;

                else if ( isset($request->documento_remision))
                    $doc = $request->documento_remision;
                else
                    $doc = $request->documento_adjunto;

                $rand = md5(date('YmdHis').rand(0,9999)).'_'.date('H');
                $ruta_publica = '/temporales/'.$rand.$request->ext;
                $ruta_local = $request->entorno['variables_entorno']['ruta_storage'].'app/temporales/'.$rand.$request->ext;

                copy( $doc , $ruta_local);
                link($ruta_local, base_path().'/public/temporales/'.$rand.$request->ext);

                return $ruta_publica;

            }else{
                
                $exp = explode( ".", $request->nombre_doc );
                $ext = ".".end( $exp );
                $rand = md5( date('YmdHis').rand(0,9999) ).'_'.date('H');
                $url_local=base_path().'/storage/app/porfirmar/'.$rand.$ext;
                copy($request->archivo_doc,$url_local);
                $datos_archvios[]=$url_local;
                $doc_arr=bandejas::documento_convertir_pdf($datos_archvios);
                $pdf="vistaprevia/".$doc_arr['filename'];
                
                return $pdf;

            }

        }catch( \Exception $e ) {

            if( !isset($doc_arr['filename']) ) {

                foreach( [821848281, 1427955010] as $chat_id) {//rulo, lucho
                    $client = new Client( ['base_uri' => $request->entorno['telegram']['uri_telegram'] ] );

                    $response = $client->request('POST','enviar_mensaje', [
                        "json" => [
                            "chat_id" => $chat_id,
                            "mensaje" => "Error en impresora PRODUCCIÓN 2 ❗️❗️: ". $e->getMessage(),
                            "documentos" => [],
                        ]
                        ]
                    );

                    $response = json_decode( $response->getBody(), true );
                }

                return ["estatus" => 0, "mensaje" => "Error al generar archivo PDF", "MSJ" => $response];
            }
        }
        
    }

    public function convertToPDF( Request $request ){

        $rand = md5(date('YmdHis').rand(100,999)).'_'.date('H');
        
        try{
            if( !isset($request->b64_doc) )
                return ["estatus" => 0, "mensaje" => "Falta b64 del archivo word"];

            if( !isset($request->ext) )
                return ["estatus" => 0, "mensaje" => "Falta extensión del archivo"];

            if( $request->ext == 'doc' || $request->ext == 'docx' ){
                
                $url_local=base_path().'/storage/app/porfirmar/'.$rand.".".$request->ext;
                file_put_contents($url_local,base64_decode($request->b64_doc));
                $datos_archvios[]=$url_local;
                $doc_arr=bandejas::documento_convertir_pdf($datos_archvios);
                // return $doc_arr;
                
                    
                    
                $pdf=$request->entorno['variables_entorno']['uri']."vistaprevia/".$doc_arr['filename'];

            }else if( $request->ext == "html" ){

                $archivo = str_replace(["&iuml;&iquest;&frac12;","&Atilde;&plusmn;"],"ñ",base64_decode($request->b64_doc));
                $archivo = str_replace('<td style="text-align: center;">', '<td style="text-align: justify;">', $archivo);
                
                $inicio = strpos($archivo, '<table border="0" cellpadding="1" cellspacing="1" style="width:620px'); 
                $final = strpos($archivo, '<div class="cwjdsjcs_editable"');

                $parte1 = substr($archivo, 0,$inicio);
                $parte2 = substr($archivo, $final);

                $inicio2= strpos($parte2,"</td>");
                $final2 = strpos($parte2, "</table>");

                $parte3 = substr($parte2,0,$inicio2);
                $parte4 = substr($parte2, $final2+8);
                $archivo = $parte1.$parte3.$parte4;
                
                $url_local=base_path().'/storage/app/porfirmar/'.$rand.".".$request->ext;
                file_put_contents($url_local,base64_decode($request->b64_doc));
                $url_pdf=base_path().'/storage/app/porfirmar/'.$rand.".pdf";
                $mpdf = new \Mpdf\Mpdf();
                $mpdf->WriteHTML($archivo);
                $output=$mpdf->Output($url_pdf);
                $pdf=$request->entorno['variables_entorno']['uri']."vistaprevia/".$rand.".pdf";

            }

        }catch( \Exception $e ) {

            if( !isset($doc_arr['filename']) ) {

                foreach( [821848281, 1427955010] as $chat_id) {//rulo, lucho
                    $client = new Client( ['base_uri' => $request->entorno['telegram']['uri_telegram'] ] );

                    $response = $client->request('POST','enviar_mensaje', [
                        "json" => [
                            "chat_id" => $chat_id,
                            "mensaje" => "Error en impresora PRODUCCIÓN ❗️❗️: ". $e->getMessage(),
                            "documentos" => [],
                        ]
                        ]
                    );

                    $response = json_decode( $response->getBody(), true );
                }

                return ["estatus" => 0, "mensaje" => "Error al generar archivo PDF", "MSJ" => $response];
            }
        }

        return $pdf;
    }

    public function convertToPDFPruebas( Request $request ){
        $rand=md5(date('YmdHis').rand(0,9999));
        
        if( !isset($request->b64_doc) )
            return ["estatus" => 0, "mensaje" => "Falta b64 del archivo word"];

        if( !isset($request->ext) )
            return ["estatus" => 0, "mensaje" => "Falta extensión del archivo"];

        if( $request->ext == 'doc' || $request->ext == 'docx' ){
            
            $url_local=base_path().'/storage/app/porfirmar/'.$rand.".".$request->ext;
            file_put_contents($url_local,base64_decode($request->b64_doc));
            $datos_archvios[]=$url_local;
            $doc_arr=bandejas::documento_convertir_pdf($datos_archvios);
            // return $doc_arr;
            if( !isset($doc_arr['filename']) )
                return ["estatus" => 0, "mensaje" => "Error al generar archivo PDF"];
                
            $pdf=$request->entorno['variables_entorno']['uri']."vistaprevia/".$doc_arr['filename'];

        }else if( $request->ext == "html" ){

            $archivo = str_replace(["&iuml;&iquest;&frac12;","&Atilde;&plusmn;"],"ñ",base64_decode($request->b64_doc));
            $archivo = str_replace('<td style="text-align: center;">', '<td style="text-align: justify;">', $archivo);
            
            $inicio = strpos($archivo, '<table border="0" cellpadding="1" cellspacing="1" style="width:620px'); 
            $final = strpos($archivo, '<div class="cwjdsjcs_editable"');

            $parte1 = substr($archivo, 0,$inicio);
            $parte2 = substr($archivo, $final);

            $inicio2= strpos($parte2,"</td>");
            $final2 = strpos($parte2, "</table>");

            $parte3 = substr($parte2,0,$inicio2);
            $parte4 = substr($parte2, $final2+8);
            $archivo = $parte1.$parte3.$parte4;
            
            $url_local=base_path().'/storage/app/porfirmar/'.$rand.".".$request->ext;
            file_put_contents($url_local,base64_decode($request->b64_doc));
            $url_pdf=base_path().'/storage/app/porfirmar/'.$rand.".pdf";
            $mpdf = new \Mpdf\Mpdf();
            $mpdf->WriteHTML($archivo);
            $output=$mpdf->Output($url_pdf);
            $pdf=$request->entorno['variables_entorno']['uri']."vistaprevia/".$rand.".pdf";

        }
        
        return $pdf;
    }

    public function obtener_documentos_promocion( Request $request ){

        if(isset($request->id_promocion)){
            $documento=archivos::obtener_documentos_promocion($request, $request->id_promocion, $request->version);

            return redirect($documento['response']);
        }

        $docuento=archivos::obtener_documentos_promocion($request, $request->promocion, $request->version);

        return $docuento;
    }

    public function obtener_ultima_version_oficio( Request $request ){
        //dd( $request->all());
        $modo = isset($request->modo) ? $request->modo : 'pdf';
        if(isset($request->id_oficio)){

            $documento=documentos_generados::obtener_ultima_version( $request, $request->id_carpeta_judicial ,$request->id_oficio, $modo);
            // return $documento;
            //dd($documento);
            if(!isset($documento['response'])){
                return '<br><br><h3 class="tx-danger"><center>'.$documento['message'].'</center></h3>';
            }

            return redirect($documento['response']);
        }

        $archivo=documentos_generados::obtener_ultima_version( $request, $request->id_carpeta_judicial, $request->documento, $modo);
        unset($archivo['ruta_local']);

        return $archivo;
 
    }

    public function obtener_anexo( Request $request ){
        $response = carpeta_judicial::obtener_documento_asociado($request, $request->id_carpeta_judicial, $request->documento);
        if( $response['status'] == 100 ) unset( $response['ruta_local'] );

        return $response;
    }

    public function prueba_firma_electronica( Request $request ){

        $anio_judicial = date('Y');
        $datos_leyenda = catalogos::ver_leyenda( $request, $anio_judicial );
        
        if( $datos_leyenda['status'] == 100 )
            $leyenda = $datos_leyenda['response'][0]['leyenda'];
        else    
            $leyenda = '';

        $elementos = [
            "entorno" => $request->entorno,
            "request" => $request,
            "sesion" => Session::all(),
            "menu_general" => $request->menu_general,
            "leyenda" => $leyenda
        ];

        return view('documentos.prueba_firma_electronica', $elementos);
    }

    public function prueba_firma( Request $request ) {
        // return $request->ext;
        if( $request->extension == "html" ){
            // return $request->archivo_html;
            $rand = md5(date('YmdHis').rand(0,9999)).'_'.date('H');
            $nombre = $rand.".pdf";
            $archivo_pdf=base_path()."/storage/temporales/$rand.pdf";
            $mpdf = new \Mpdf\Mpdf();
            $mpdf->WriteHTML($request->archivo_html);
            $output=$mpdf->Output($archivo_pdf);

            $url_local = $archivo_pdf;

        }else {

            $pdf = $request->ruta_pdf;
            $nombre = str_replace('vistaprevia/','',$pdf);
            $url_local = base_path().'/storage/app/porfirmar/'.$nombre;

        }

        $url_key='';
        if( $request->tipo_firma_firel == 'firel_tsj' ) {
                
            if(!isset($request->archivo_pfx)) return [ "status" => 0, "message" => "El archivo PFX es obligatorio."];
            
            if($request->archivo_pfx->isValid()){
                $url_cer=  base_path().'/storage/app/'.$request->archivo_pfx->store('private');
                $bandera=1;
            }

        }else if( $request->tipo_firma_firel == 'fiel_tsj'){

            if(!isset($request->archivo_key)) return [ "status" => 0 , "message" => "El archivo KEY es obligatorio." ];
            
            if(!isset($request->archivo_cer)) return [ "status" => 0 , "message" => "El archivo CER es obligatorio."];
            /*
            *   SE GUARDAN LOS ARCHIVOS
            */
            if($request->archivo_key->isValid()){
                $url_key=base_path().'/storage/app/'.$request->archivo_key->store('private');
                $bandera=1;
            }else{
                $bandera=0;
            }
            
            if($request->archivo_cer->isValid()){
                $url_cer = base_path().'/storage/app/'.$request->archivo_cer->store('private');
                $bandera=1;
            }
            else{
                $bandera=0;
            }

        }

        $pdf_firmado=bandejas::obtener_firma_tsjcdmx_acuerdo($request, $url_local, $url_cer, $url_key, $request->password);
        
        if( $pdf_firmado['resultado'] == 1 ) {
            
            $ruta_publica = '/temporales/'.date('YmdHis').$nombre;
            $ruta_local = $request->entorno['variables_entorno']['ruta_storage'].'/temporales/'.$nombre;
            file_put_contents( $ruta_local, base64_decode($pdf_firmado['documento']));
            link( $ruta_local, base_path().'/public'.$ruta_publica);

            return [ 'status' => 100, 'response' => $ruta_publica ];

        } else {
            return [ 'status' => 0, 'message' => utf8_encode($pdf_firmado["msj"])];
        }
        
    }
}
