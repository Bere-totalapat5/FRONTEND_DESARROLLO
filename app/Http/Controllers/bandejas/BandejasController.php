<?php

namespace App\Http\Controllers\bandejas;

use App\Http\Controllers\clases\catalogos;
use App\Http\Controllers\clases\utilidades;
use App\Http\Controllers\clases\bandejas;
use App\Http\Controllers\clases\archivos;
use App\Http\Controllers\clases\documentos_generados;
use App\Http\Controllers\clases\documentos_asociados;
use App\Http\Controllers\clases\carpeta_judicial;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App;
 

class BandejasController extends Controller
{
    public function obtener_bandeja( Request $request ){
        
        switch($request->tipo){
            case 'notificaciones':
                $accion_vista=41;
                $vista=28;
                break;
            case 'tareas':
                $accion_vista=42;
                $vista=29;
                break;
            case 'firmas':
                $accion_vista=43;
                $vista=30;
                break;
            default:
                $accion_vista='';
        }

        $usuario='-';
        if($request->modo=='lista'){
            if(Session::get('id_unidad_gestion')!=0){
                $usuario=Session::get('usuario_id');
            }
        }

        if( $request->modo == 'contador' ) $usuario = Session::get('usuario_id');

        if(isset($request->usuario) && utilidades::obtener_acciones_vista($request,Session::get('usuario_id'),$vista,$accion_vista))$usuario=$request->usuario;

        $unidad='-';
        if(isset($request->uga) && utilidades::obtener_acciones_vista($request,Session::get('usuario_id'),$vista,$accion_vista))$unidad=$request->uga;

        // $estatus_bandeja='espera';
        // if( isset($request->estatus) )$estatus_bandeja=$request->estatus;

        $desde='-';
        if(isset($request->desde)){
            $exp_desde=explode('-', $request->desde);
            $desde="$exp_desde[2]-$exp_desde[1]-$exp_desde[0]";
        }

        $hasta='-';
        if(isset($request->hasta)){
            $exp_hasta=explode('-', $request->hasta);
            $hasta="$exp_hasta[2]-$exp_hasta[1]-$exp_hasta[0]";
        }

        if( $request->modo == "contador" )
            $datos = [
                "modo" => "contador",
                "id_usuario" => $usuario,
                "id_unidad" => $unidad,
                "estatus_bandeja" => "espera",
                "tipo_bandeja" => $request->tipo,
            ];
        else
            $datos=[
                "modo"=>$request->modo,
                "id_usuario"=>$usuario,
                "id_unidad"=>$unidad,
                "tipo_bandeja"=>$request->tipo ,
                "estatus_bandeja" => $request->estatus,
                "creacion_bandeja_min"=>$desde,
                "creacion_bandeja_max"=>$hasta,
                "id_tarea"=>$request->folio,
                "carpeta_investigacion"=>$request->carpeta_inv,
                "nombres_persona"=>$request->nombre_persona,
                "ap_persona"=>$request->ap_paterno_persona,
                "am_persona"=>$request->ap_materno_persona,
                "clave_bandeja" => $request->clave_bandeja,
                "folio_carpeta" => $request->folio_carpeta,
            ];

        $paginacion=[];
        if(isset($request->pagina)) $paginacion=["pagina"=>$request->pagina, "registros_por_pagina"=>10];
        // return $datos;
        $response = $request
        ->clienteWS_penal
        ->request('get', 'obtener_bandejas',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>$datos,
                "paginacion"=>$paginacion
            ]
        ]);

        $response = json_decode($response->getBody(),true) ;

        return $response;
    }

    public function notificaciones( Request $request ){
        $ugas=catalogos::obtener_ugas($request);
        $elementos=["entorno"=>$request->entorno,
                    "request"=>$request,
                    "sesion"=>Session::all(),
                    "menu_general"=>$request->menu_general,
                    "ugas"=>$ugas['response'],
                    ];

        return view('bandejas.notificaciones', $elementos);
    }

    public function tareas( Request $request ){
        
        if(!utilidades::buscarPermisoMenu($request->menu_general['response'], 29, 0))
            return redirect()->route('consultar_valores');

        $jueces=[];

        if( Session::get('id_unidad_gestion') != null && Session::get('id_tipo_usuario') != 25 ){
            
            $consulta_jueces=catalogos::obtener_jueces($request, Session::get('id_unidad_gestion'),[5,2]);

            if( $consulta_jueces['status']==100 )
                $jueces=$consulta_jueces['response'];
                
        }

        $ugas = catalogos::obtener_ugas($request);
        $fracciones = catalogos::obtener_catalogo_fracciones($request);
        $acciones=utilidades::obtener_acciones_vista($request,Session::get('usuario_id'), 29);
        $fiscalias=catalogos::fiscalias($request)['response'];
        $tipos_documento_carpeta=catalogos::tipos_documento_carpeta($request);
        $penas = catalogos::ver_tipo_pena($request);
        $centros_detencion = catalogos::obtener_centros_detencion($request);
        $nacionalidades=catalogos::nacionalidades($request);
        $estado_civil=catalogos::estado_civil($request);
        $unidades_ejecucion = $request->entorno['unidades_ejecucion']['ids'];
        $tipos_audiencia=catalogos::tipos_audiencia( $request, 1 )['response'];
        $anio_judicial = date('Y');
        $datos_leyenda = catalogos::ver_leyenda( $request, $anio_judicial );
        $reclusorios = catalogos::ver_reclusorios( $request )['message'];
        
        if( $datos_leyenda['status'] == 100 )
            $leyenda = $datos_leyenda['response'][0]['leyenda'];
        else    
            $leyenda = '';
        
        $elementos = [
            "entorno"=>$request->entorno,
            "request"=>$request,
            "sesion"=>Session::all(),
            "menu_general"=>$request->menu_general,
            "ugas"=>$ugas['response'],
            "acciones"=>$acciones['response'],
            "jueces"=>$jueces,
            "leyenda" => $leyenda,
            "fracciones" => $fracciones,
            "fiscalias" => $fiscalias,
            "tipos_documento_carpeta" => $tipos_documento_carpeta,
            "penas" => $penas['message'],
            "centros_detencion" => $centros_detencion['message'],
            "nacionalidades"=>$nacionalidades['response'],
            "estado_civil"=>$estado_civil['response'],
            "tipos_audiencia"=>$tipos_audiencia,
            "unidades_ejecucion" => $unidades_ejecucion,
            "reclusorios" => $reclusorios
        ];

        return view('bandejas.tareas', $elementos);
    }

    public function documentos( Request $request ){
        $juds_at=catalogos::obtener_usuarios_tipo($request, Session::get('id_unidad_gestion'),7);
        $arr_juds_at=[];
        if($juds_at['status']==100)$arr_juds_at=$juds_at['response'];
        $ugas=catalogos::obtener_ugas($request);
        $elementos=["entorno"=>$request->entorno,
                    "request"=>$request,
                    "sesion"=>Session::all(),
                    "menu_general"=>$request->menu_general,
                    "ugas"=>$ugas['response'],
                    "juds_at"=>$arr_juds_at,
                    ];

        return view('bandejas.documentos', $elementos);
    }

    public function firmar_documento( Request $request){
        // return $request->all();
        $return = [];
        $input = $request->all();
        $return[] = $input;
        $id_usuario_destino=Session::get('usuario_id');
        $nombre_archivo='-';
        $tamanio_archivo='-';
        $extension='-';
        $comentarios='-';
        $bandera=1;
        $url_key='';

        $proceso = rand(100, 999);

        

        //se obtiene la ultima version del pdf
        if( $input['tipo_firma_firel'] == 'firel_tsj' || $input['tipo_firma_firel'] == 'fiel_tsj') {
            
            if( $input['tipo_doc']== 'acuerdos' ) {

                $archivo = archivos::obtener_ultima_version_acuerdo($request, $input['modal_id_acuerdo'], "archivo");
                if( $archivo['status'] == 0 ) return $archivo;
                
                $pdf = archivos::obtener_ultima_version_acuerdo($request, $input['modal_id_acuerdo'], "pdf");
                if( $pdf['status'] == 0 ) return $pdf;

            }elseif( $input['tipo_doc'] == 'carpetas_judiciales_documentos' ) {

                $archivo = documentos_generados::obtener_ultima_version($request, $request->carpeta_judicial ,$request->documento, "archivo");
                if( $archivo['status'] == 0 ) return $archivo;

                $pdf = documentos_generados::obtener_ultima_version($request, $request->carpeta_judicial ,$request->documento, "pdf");
                if( $pdf['status'] == 0 ) return $pdf;
            }

            if( $input['tipo_firma_firel'] == 'firel_tsj' ) {
                
                if(!isset($request->archivo_pfx)) return [ "status" => 0, "message" => "El archivo PFX es obligatorio."];
                
                if($request->archivo_pfx->isValid()){
                    $url_cer=  base_path().'/storage/app/'.$request->archivo_pfx->store('private');
                    $bandera=1;
                }

            }else if($input['tipo_firma_firel']=='fiel_tsj'){

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
                    $url_cer=base_path().'/storage/app/'.$request->archivo_cer->store('private');
                    $bandera=1;
                }
                else{
                    $bandera=0;
                }

            }
        }else if($input['tipo_firma_firel']=='firma_autografa'){

            $b64_archivo=$input['bDoc'];
            $b64_pdf=$input['bDoc'];
            $tamanio_archivo=$input['tamanio_archivo'];
            $extension="pdf";
            $pdf = [];

            $datos=[
                "tipo_avance"=>$input['modal_tipo_avance'],
                "id_usuario_destino"=>$id_usuario_destino,
                "nombre_archivo"=>$nombre_archivo,
                "comentarios"=>$comentarios,
                "tamanio_archivo"=>$tamanio_archivo,
                "extension_archivo"=>$extension,
                "b64_archivo"=>$b64_archivo,
                "b64_pdf"=>$b64_pdf
            ];

            $ruta_local = base_path().'/storage/temp_exportaciones/';
            $random = date('YmdHisu').rand();
            $pdf['ruta_local'] = $ruta_local.'firmado_autografamente_'.$random.'.pdf';
            file_put_contents( $pdf['ruta_local'] , base64_decode($input['bDoc']) );

            $bandera=1;
        }

        

        if($bandera==1){
            
            //se manda a firmar
            if($input['tipo_firma_firel']=='firel_tsj' || $input['tipo_firma_firel']=='fiel_tsj'){
                $pdf_firmado=bandejas::obtener_firma_tsjcdmx_acuerdo($request, $pdf['ruta_local'], $url_cer, $url_key, $input['password']);
                // return var_dump($pdf_firmado);
                if($pdf_firmado['resultado'] != 1){
                   
                   $message = mb_convert_encoding($pdf_firmado['msj'], 'UTF-8', 'UTF-8');
                   return [ "status" => 0 , "message" => str_replace('contrase?a', 'contraseña' ,$message) ];
                    // return $pdf_firmado['msj'];
                }


                $b64_archivo=base64_encode(file_get_contents($archivo['ruta_local']));
                $b64_pdf=$pdf_firmado['documento'];
                $extension=$archivo['extension'];
                $tamanio_archivo=filesize($archivo['ruta_local']);


                $datos=[
                    "tipo_avance"=>$input['modal_tipo_avance'],
                    "id_usuario_destino"=>$id_usuario_destino,
                    "nombre_archivo"=>$nombre_archivo,
                    "comentarios"=>$comentarios,
                    "tamanio_archivo"=>$tamanio_archivo,
                    "extension_archivo"=>$extension,
                    "b64_archivo"=>$b64_archivo,
                    "b64_pdf"=>$b64_pdf
                ];
            }

            if($input['tipo_doc']=='acuerdos'){

                $response = $request
                ->clienteWS_penal
                ->request('post', 'avanzar/'.Session::get('usuario_id').'/'.Session::get('id_unidad_gestion').'/'.$input['modal_id_acuerdo'],[
                    "headers" => [
                        "sesion-id" => $request->session()->get("sesion-id"),
                        "cadena-sesion" => $request->session()->get("cadena-sesion"),
                        "usuario-id" => $request->session()->get("usuario-id"),
                        "Content-Type" => "application/json"
                    ],
                    "json"=>[
                        "datos"=>$datos,
                    ]
                ]);
                $response = json_decode($response->getBody(),true) ;

            }else if( $input['tipo_doc'] == 'carpetas_judiciales_documentos' ){
                //dd($request);

                if( 1 == 0) {

                    $data_usmeca=json_decode($request->request_usmeca);
                    $data_usmeca=json_decode($data_usmeca,true);
                    $documentos_por_unir = [ $pdf['ruta_local'] ];

                    $anexos = [];


                    // Anexos Borrados
                    if( isset($input['arrAnexosBorrados']) ){
                        $data_anexos = json_decode($input['arrAnexosBorrados'],true);
                        foreach( $data_anexos as $d ){
                            $documento = [];
                            $documento["carpeta"] = $input['carpeta_judicial'] ;
                            $documento["id_documento"] = $d["id_documento"] ;
                            $documento["estatus"] = 0 ;
                            $anx_borrado = documentos_asociados::actualizar_documento( $request, $documento);
                        }
                    }

                    // Anexos adjuntados y ya guardados
                    if( isset($input['arrAnexos']) ){
                        $data_anexos = json_decode($input['arrAnexos'],true);
                        foreach( $data_anexos as $d ){
                            
                            $anx = carpeta_judicial::obtener_documento_asociado($request, $input['carpeta_judicial'], $d["id_documento"]);
                            if( $anx['status'] == 100 ){
                                if( file_exists($anx['ruta_local']) && is_file($anx['ruta_local']) ) $documentos_por_unir[] = $anx['ruta_local'];
                            }else continue;

                        }
                    }

                    // anexos recien adjuntados no guardados
                    if( isset($input['arrAnexosNuevos']) ){
                        $data_anexos = json_decode($input['arrAnexosNuevos'],true);
                        foreach( $data_anexos as $d ){
                            $ruta_local = base_path().'/storage/temp_exportaciones_CJ/';
                            $random = date('YmdHis').rand();
                            $ruta_ar_local = $ruta_local.$d['nombre_archivo'].'-'.$random.'.pdf';
                            
                            file_put_contents($ruta_ar_local, base64_decode($d['b64']) );
            
                            if( file_exists($ruta_ar_local) && is_file($ruta_ar_local) ) $documentos_por_unir[] = $ruta_ar_local;
            
                            $anexos[]=[
                                "carpeta" => $input['carpeta_judicial'], //$d['carpeta'],
                                "id_tipo_archivo"=> 61,
                                "nombre_archivo" => $d['nombre_archivo'],
                                "extension_archivo" => $d['extension_archivo'],
                                "tamanio_archivo"=> $d['tamanio_archivo'],
                                "estatus"=> 1,
                                "b64"=> $d['b64'],
                                "motivos"=>"-",
                                "anexos" => [],
                            ];
                        }
                    
                        $ruta_ar_unido = $ruta_local.'oficio-firmado-anexos'.'-'.date('YmdHis').rand().'.pdf';
                        $unidos = carpeta_judicial::coser_documentos_pdf($documentos_por_unir, $ruta_ar_unido);
                        
                        if($unidos['status']==100) $data_usmeca['solicitud']['documento']['data'] = base64_encode( file_get_contents( $unidos['ruta_local'] ) );
                        
                    }
                }
                    $datos['request_usmeca'] =[];
                    $datos['anexos'] = [];  
                
                $response = $request
                ->clienteWS_penal
                ->request('post', 'avance_documento/'.Session::get('usuario_id').'/'.Session::get('id_unidad_gestion').'/'.$input['documento'].'/'.$input['carpeta_judicial'],[
                    "headers" => [
                        "sesion-id" => $request->session()->get("sesion-id"),
                        "cadena-sesion" => $request->session()->get("cadena-sesion"),
                        "usuario-id" => $request->session()->get("usuario-id"),
                        "Content-Type" => "application/json"
                    ],
                    "json"=>[
                        "datos"=>$datos,
                    ]
                ]);

                $response = json_decode($response->getBody(),true) ;

            }

            return $response;
        }

    }

    public function resolver_tarea_solicitud( Request $request){
        
        // return $request->archivo_doc;
        $b64_archivo="-";
        $b64_pdf="-";
        $nombre_archivo='-';
        $tamanio_archivo='-';
        $extension='-';
        $tipo_archivo='-';

        if($request->extension=='.doc' || $request->extension=='.docx' || $request->extension=='.pdf'){
            
            $url_file=$request->archivo_doc->store('porfirmar');

            $extension_word = pathinfo(storage_path($url_file), PATHINFO_EXTENSION);
            $datos_archvios[]=base_path().'/storage/app/'.$url_file;
            $doc_arr=bandejas::documento_convertir_pdf($datos_archvios);
            // return $doc_arr;
            $b64_archivo=base64_encode(file_get_contents($request->archivo_doc));
            $b64_pdf=base64_encode(file_get_contents($doc_arr['file']));
            $nombre_archivo=str_replace($extension_word,'',$request->nombre_archivo);
            $extension=str_replace('.','',$request->extension);
            $tamanio_archivo=$request->tamanio_archivo;
            $tipo_archivo=$request->tipo_archivo;


        }elseif($request->extension=='html'){

            $rand=rand(1000,9999);
            $archivo=base_path()."/storage/acuerdos/$rand.html";
            $fo=fopen($archivo,'w+');
            fwrite($fo,$request->archivo_doc);

            // $pdf = App::make('dompdf.wrapper');
            // $pdf->loadHTML($request->archivo_doc);
            // $output        = $pdf->output();

            $archivo_pdf=base_path()."/storage/acuerdos/_v2_$rand.pdf";
            $mpdf = new \Mpdf\Mpdf();
            $mpdf->WriteHTML($request->archivo_doc);
            $output=$mpdf->Output($archivo_pdf);



            $b64_archivo=base64_encode(file_get_contents($archivo));
            $extension='html';
            $b64_pdf = base64_encode(file_get_contents($archivo_pdf));
            $nombre_archivo=$rand;
            $tamanio_archivo=filesize($archivo);
            $tipo_archivo=$request->tipo_archivo;
        }
        // return [["status" => 0, "message" => "en pruebas"], ["b64"=>  $b64_pdf]];
        $data_audiencia=[];

        if( $request->tipo_resolucion=='audiencia' ){
            $data_audiencia = [
                "id_inmueble" => $request->id_inmueble,
                "id_sala" => $request->id_sala,
                "id_juez" => $request->id_juez ?? $request->id_juez_ejecucion,
                "cve_juez"=>$request->cve_juez ?? $request->cve_juez_ejecucion,
                "fecha_audiencia"=>$request->fecha_audiencia,
                "hora_inicio_audiencia"=>$request->hora_inicio_audiencia,
                "hora_fin_audiencia"=>$request->hora_fin_audiencia,
                "bandera_juez_excusa"=>$request->bandera_juez_excusa,
                "bandera_juez_tramite"=>$request->bandera_juez_tramite,
                "comentarios_excusa"=>$request->comentarios_excusa,
                "comentarios"=>$request->comentarios,
                "recursos"=>json_decode($request->recursos_arr),
                "id_tipo_audiencia" => $request->id_tipo_audiencia ?? $request->id_tipo_audiencia_select,
            ];
        }
        //    return [$data_audiencia, $request->solicitud];
        $fracciones = [];
     

        if( isset($request['fracciones']) ){
            foreach(json_decode($request['fracciones'], true) as $fraccion ){
                $fracciones = array_merge($fracciones, $fraccion) ;
            }
        }

        $datos=[
            "tipo_resolucion"=>$request->tipo_resolucion,
            "id_usuario_delegado"=>$request->usuario_delegado,
            "comentarios"=>$request->comentarios,
            "extension_archivo"=>$extension,
            "nombre_archivo"=>$nombre_archivo,
            "tamanio_archivo"=>$tamanio_archivo,
            "b64_archivo"=>$b64_archivo,
            "b64_pdf"=>$b64_pdf,
            "tipo_documento"=>$tipo_archivo,
            "data_audiencia"=>$data_audiencia,
            "fracciones_acuerdo" => $fracciones
        ];
        // return $datos;
        $unidad_gestion=Session::get('id_unidad_gestion');
        
        if( $unidad_gestion == '' || $unidad_gestion == null )
            $unidad_gestion = $request->unidad_gestion;
        
        $response = $request
        ->clienteWS_penal
        ->request('post', 'resolucion_solicitud/'.Session::get('usuario_id').'/'.$unidad_gestion.'/'.$request->solicitud,[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>$datos,
            ]
        ]);

        $response = json_decode($response->getBody(),true) ;
                
        return [$response, $datos];

    }

    public function resolver_tarea_promocion( Request $request){
        // return $request->archivo_doc;
        $b64_archivo="-";
        $b64_pdf="-";
        $nombre_archivo='-';
        $tamanio_archivo='-';
        $extension='-';
        $tipo_archivo='-';

        if($request->extension=='.doc' || $request->extension=='.docx'){

            $url_file=$request->archivo_doc->store('porfirmar');

            $extension_word = pathinfo(storage_path($url_file), PATHINFO_EXTENSION);
            $datos_archvios[]=base_path().'/storage/app/'.$url_file;
            $doc_arr=bandejas::documento_convertir_pdf($datos_archvios);
            // return $doc_arr;
            $b64_archivo=base64_encode(file_get_contents($request->archivo_doc));
            $b64_pdf=base64_encode(file_get_contents($doc_arr['file']));
            $nombre_archivo=str_replace($extension_word,'',$request->nombre_archivo);
            $extension=str_replace('.','',$request->extension);
            $tamanio_archivo=$request->tamanio_archivo;
            $tipo_archivo=$request->tipo_archivo;


        }elseif($request->extension=='html'){

            $rand=rand(1000,9999);
            $archivo=base_path()."/storage/acuerdos/$rand.html";
            $fo=fopen($archivo,'w+');
            fwrite($fo,$request->archivo_doc);

            $pdf = App::make('dompdf.wrapper');
            $pdf->loadHTML($request->archivo_doc);
            $output        = $pdf->output();

            $b64_archivo=base64_encode(file_get_contents($archivo));
            $extension='html';
            $b64_pdf = base64_encode($output);
            $nombre_archivo=$rand;
            $tamanio_archivo=filesize($archivo);
            $tipo_archivo=$request->tipo_archivo;
        }

        $data_audiencia=[];

        if($request->tipo_resolucion=='audiencia'){
            $data_audiencia=[
                "id_inmueble"=>$request->id_inmueble,
                "id_sala"=>$request->id_sala,
                "id_juez" => $request->id_juez ?? $request->id_juez_ejecucion,
                "cve_juez"=>$request->cve_juez ?? $request->cve_juez_ejecucion,
                "fecha_audiencia"=>$request->fecha_audiencia,
                "hora_inicio_audiencia"=>$request->hora_inicio_audiencia,
                "hora_fin_audiencia"=>$request->hora_fin_audiencia,
                "bandera_juez_excusa"=>$request->bandera_juez_excusa,
                "bandera_juez_tramite"=>$request->bandera_juez_tramite,
                "comentarios_excusa"=>$request->comentarios_excusa,
                "comentarios"=>$request->comentarios,
                "recursos"=>json_decode($request->recursos_arr),
                "id_tipo_audiencia" => $request->id_tipo_audiencia ?? $request->id_tipo_audiencia_select,
            ];
        //    return $data_audiencia;
        }

        $datos=[
            "tipo_resolucion"=>$request->tipo_resolucion,
            "id_usuario_delegado"=>$request->usuario_delegado,
            "comentarios"=>$request->comentarios,
            "extension_archivo"=>$extension,
            "nombre_archivo"=>$nombre_archivo,
            "tamanio_archivo"=>$tamanio_archivo,
            "b64_archivo"=>$b64_archivo,
            "b64_pdf"=>$b64_pdf,
            "tipo_documento"=>$tipo_archivo,
            "data_audiencia"=>$data_audiencia,
            "id_tipo_audiencia" => $request->id_tipo_audiencia ?? $request->id_tipo_audiencia_select,
        ];
        // return $datos;

        $unidad_gestion=Session::get('id_unidad_gestion');

        // if( $unidad_gestion == '' || $unidad_gestion == null ); 
        //     $unidad_gestion = $request->unidad_tarea;

          
        $response = $request
        ->clienteWS_penal
        ->request('post', 'resolucion_promocion/'.Session::get('usuario_id').'/'.$unidad_gestion.'/'.$request->promocion,[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>$datos,
            ]
        ]);

        $response = json_decode($response->getBody(),true) ;

        return [$response, $datos];

    }

    public function avanzar_acuerdo( Request $request ){

        $b64_archivo="asd";
        $b64_pdf="asd";
        $nombre_archivo='-';
        $tamanio_archivo='0';
        $extension='html';
        $tipo_archivo='-';
        $id_usuario_destino='0';

        if(isset($request->usuario_destino)){
            $id_usuario_destino=$request->usuario_destino;
        }
        //  return $request->datausu;
        if(!($request->datausu)){
            if($request->extension=='.doc' || $request->extension=='.docx' || $request->extension=='.pdf'){

                $url_file=$request->archivo_doc->store('porfirmar');
                $extension_word = pathinfo(storage_path($url_file), PATHINFO_EXTENSION);
                $datos_archvios[]=base_path().'/storage/app/'.$url_file;
                $doc_arr=bandejas::documento_convertir_pdf($datos_archvios);

                $b64_archivo=base64_encode(file_get_contents($request->archivo_doc));
                $b64_pdf=chunk_split(base64_encode(file_get_contents($doc_arr['file'])));
                $nombre_archivo=str_replace($extension_word,'',$request->nombre_archivo);
                $extension=str_replace('.','',$request->extension);
                $tamanio_archivo=$request->tamanio_archivo;
                $tipo_archivo=$request->tipo_archivo;

            }elseif($request->extension=='html'){


                $rand=rand(1000,9999);
                $archivo=base_path()."/storage/acuerdos/$rand.html";
                $fo=fopen($archivo,'w+');
                fwrite($fo,$request->archivo_doc);

                $archivo_pdf = base_path()."/storage/acuerdos/_v2_$rand.pdf";
                $mpdf = new \Mpdf\Mpdf();
                $mpdf->WriteHTML($request->archivo_doc);
                $output=$mpdf->Output($archivo_pdf);

                $b64_archivo=base64_encode(file_get_contents($archivo));
                $extension='html';
                $b64_pdf = base64_encode(file_get_contents($archivo_pdf));
                $nombre_archivo=$request->solicitud;
                $tamanio_archivo=filesize($archivo);
                $tipo_archivo=$request->tipo_archivo;

            }else if( isset($request->acuerdo) ){

                $archivo=archivos::obtener_ultima_version_acuerdo($request, $request->acuerdo, "archivo");

                if( !isset($archivo['status']) || $archivo['status'] != 100 )
                    return ["status" => 0, "message" => "No se encontró el archivo del acuerdo"];

                $pdf=archivos::obtener_ultima_version_acuerdo($request, $request->acuerdo, "pdf");

                if( !isset($pdf['status']) || $pdf['status'] != 100 )
                    return ["status" => 0, "message" => "No se encontró el pdf del acuerdo"];

                $b64_archivo=base64_encode(file_get_contents($archivo['ruta_local']));
                $b64_pdf=chunk_split(base64_encode(file_get_contents($pdf['ruta_local'])));
                $extension=$archivo['extension'];
                $tamanio_archivo=filesize($archivo['ruta_local']);

            }
        }

        $datos=[
            "tipo_avance"=>$request->accion,
            "id_usuario_destino"=>$id_usuario_destino,
            "nombre_archivo"=>$nombre_archivo,
            "comentarios"=>$request->comentarios,
            "tamanio_archivo"=>$tamanio_archivo,
            "extension_archivo"=>$extension,
            "b64_archivo"=>$b64_archivo,
            "b64_pdf"=>$b64_pdf
        ];

        // return $datos;

        $response = $request
        ->clienteWS_penal
        ->request('post', 'avanzar/'.Session::get('usuario_id').'/'.Session::get('id_unidad_gestion').'/'.$request->acuerdo.$request->datausu,[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>$datos,
            ]
        ]);

        $response = json_decode($response->getBody(),true) ;

        return $response;

    }

    public function avanzar_documento( Request $request ){
        $tipo_avance = "avance";
        $id_usuario_destino = "-";
        $tamanio_archivo = "-";
        $extension_archivo = "-";
        $b64_archivo = "-";
        $b64_pdf = "-";
        $nombre_archivo = null;
        $id_carpeta_judicial = $request->id_carpeta;
        $id_documento = $request->id_documento;
        $request_usmeca = "-";
        $anexos = "-";

        if(isset($request->id_usuario_destino)){
            $id_usuario_destino=$request->id_usuario_destino;
        }

        if(!($request->datausu)){
            $archivo=documentos_generados::obtener_ultima_version( $request, $id_carpeta_judicial, $id_documento,"pdf" );
            $request_usmeca = $archivo["request_usmeca"];
            $anexos = $archivo["documentos_anexados"];


            if($request->extension=='doc' || $request->extension=='docx'){

                $url_file=$request->archivo_doc->store('porfirmar');
                $extension_word = pathinfo(storage_path($url_file), PATHINFO_EXTENSION);
                $datos_archvios[]=base_path().'/storage/app/'.$url_file;
                $doc_arr=bandejas::documento_convertir_pdf($datos_archvios);

                $b64_archivo=base64_encode(file_get_contents($request->archivo_doc));
                $b64_pdf=chunk_split(base64_encode(file_get_contents($doc_arr['file'])));
                $nombre_archivo=str_replace($extension_word,'',$request->nombre_archivo);
                $extension_archivo=str_replace('.','',$request->extension);
                $tamanio_archivo=$request->tamanio_archivo;

            }elseif($request->extension=='html'){

                // if(isset($request->archivo_doc)){
                $rand=rand(1000,9999);
                $archivo=base_path()."/storage/acuerdos/$rand.html";
                $fo=fopen($archivo,'w+');
                fwrite($fo,$request->archivo_doc);

                // $pdf = App::make('dompdf.wrapper');s
                // $pdf->loadHTML($request->archivo_doc);
                // $output        = $pdf->output();

                $archivo_pdf = base_path()."/storage/acuerdos/_v2_$rand.pdf";
                $mpdf = new \Mpdf\Mpdf();
                $mpdf->WriteHTML($request->archivo_doc);
                $output=$mpdf->Output($archivo_pdf);

                $b64_archivo=base64_encode(file_get_contents($archivo));
                $extension_archivo='html';
                $b64_pdf = base64_encode(file_get_contents($archivo_pdf));
                //$nombre_archivo= rand(0,999) . '-'. $request->solicitud . '-' . rand(999, 999999) ;
                $tamanio_archivo=filesize($archivo);
                // }
            }else{
                // return $request->all();
                $archivo=documentos_generados::obtener_ultima_version( $request, $id_carpeta_judicial, $id_documento,"archivo" );
                $pdf=documentos_generados::obtener_ultima_version( $request, $id_carpeta_judicial, $id_documento,"pdf" );
                $b64_archivo=base64_encode(file_get_contents($archivo['ruta_local']));
                $b64_pdf=chunk_split(base64_encode(file_get_contents($pdf['ruta_local'])));
                $extension_archivo=$archivo['extension'];
                $tamanio_archivo=filesize($archivo['ruta_local']);
            }
        }else $tipo_avance = 'datausu';

        $parametros=[
            "id_unidad_gestion"=> isset($request->id_unidad) ? $request->id_unidad : $request->session()->get("id_unidad_gestion"),
            "id_documento"=>$id_documento,
            "id_carpeta_judicial"=>$id_carpeta_judicial,

            "tipo_avance"=>$request->accion,
            "id_usuario_destino"=>$id_usuario_destino,
            //"nombre_archivo"=>$nombre_archivo,
            "comentarios"=>$request->comentarios,
            "tamanio_archivo"=>$tamanio_archivo,
            "extension_archivo"=>$extension_archivo,
            "b64_archivo"=>$b64_archivo,
            "b64_pdf"=>$b64_pdf,
            "request_usmeca" => $request_usmeca,
            "anexos" => $anexos,
            "comentarios" => isset($request->comentarios) ? $request->comentarios : null,
        ];

        // return $parametros;

        $response = documentos_generados::flujo_documento( $request, $parametros , $tipo_avance );

        return $response;

    }

    public function asignar_clave_ugjems( Request $request ) {

        $response = $request
        ->clienteWS_penal
        ->request('post', 'asignar_subclave_ugjems/'.Session::get('usuario_id').'/'.$request->remision.'/'.$request->subclave,[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ]
        ]);

        $response = json_decode($response->getBody(),true) ;

        return $response;
    }

    public function obtener_medidas_proteccion( Request $request ) {

        $response = $request
        ->clienteWS_penal
        ->request('get', 'obtener_formato_medidas_proteccion/'.$request->tipo.'/'.$request->id_documento.'/'.$request->persona,[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ]
        ]);

        $response = json_decode($response->getBody(),true) ;

        return $response;

    }

    public function modificar_medidas_proteccion_persona( Request $request ) {
        // return $request;
        $medidas = [];
        foreach( $request->medidasPersona as $medida ) {
             $medidas[] = [
                "fraccion_descripcion_otros" => $medida['fraccion_descripcion_otros'],
                "fraccion_valor" => $medida['fraccion_valor'],
                "id_cat" => $medida['id_cat'],
                "id_fraccion_valor" => (string)($medida['id_fraccion_valor'])
             ];
        }
        // return $medidas;
        $response = $request
        ->clienteWS_penal
        ->request('patch', 'modificar_formato_medidas_proteccion/'.$request->tipo.'/'.$request->id_documento.'/'.$request->persona,[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json" => [
                "datos" => [
                    "valores" => $medidas
                ]
            ]
        ]);

        $response = json_decode($response->getBody(),true) ;

        return $response;

    }

    
    public function blade_prueba( Request $request ){
        $ugas=catalogos::obtener_ugas($request);
        $elementos=["entorno"=>$request->entorno,
                    "request"=>$request,
                    "sesion"=>Session::all(),
                    "menu_general"=>$request->menu_general,
                    "ugas"=>$ugas['response'],
                    ];

        return view('bandejas.blade_prueba', $elementos);
        // return view("bandejas.blade_prueba");
    }

    public function marcar_tareas( Request $request ){

        if( !isset( $request->tareas) || $request->tareas == null || $request->tareas == '' ) 
            return [ "status" => 0 , "message" => "No seleccionó ninguna tarea para marcarla como atendida"];
        
        if( !isset( $request->estatus) || $request->estatus == null || $request->estatus == '' ) 
        return [ "status" => 0 , "message" => "ERROR - estatus"];

        $estatus_a_cambiar = "atendida";

        if($request->estatus == 0){
            $estatus_a_cambiar = "espera";
        }

        $datos = [
            "estatus_a_cambiar" => $estatus_a_cambiar,
            "ids_bandejas" => $request->tareas,
            "id_usuario_responsable" => $request->session()->get("usuario-id")
        ];

        $response = $request
        ->clienteWS_penal
        ->request('patch', 'marcar_tareas',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json" => [
                "datos" => $datos
            ]
        ]);

        $response = json_decode($response->getBody(),true) ;

        return $response;
    }
}

