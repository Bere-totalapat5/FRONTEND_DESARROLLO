<?php

namespace App\Http\Controllers\remisiones;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Http\Controllers\clases\archivos;

class RemisionesController extends Controller
{
    public function obtener_unidad_destino_remision( Request $request){
        $datos=[
            "tipo_delito"=>$request->tipo_unidad,
            "id_inmueble"=>$request->edificio_receptor
        ];
        // return $datos;
        $response = $request
        ->clienteWS_penal
        ->request('get', 'calcular_unidad_destino',[
            "headers" => [
                "sesion-id" => Session::get("sesion-id"),
                "cadena-sesion" => Session::get("cadena-sesion"),
                "usuario-id" => Session::get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>$datos,
            ]
        ]);

        $response = json_decode($response->getBody(),true) ;

        return $response;
    }

    public function obtener_inmueble_fiscalia( Request $request ) {

        $datos=[
            "id_fiscalia"=>$request->fiscalia,
        ];
        // return $datos;
        $response = $request
        ->clienteWS_penal
        ->request('get', 'obtener_inmueble_ficalia',[
            "headers" => [
                "sesion-id" => Session::get("sesion-id"),
                "cadena-sesion" => Session::get("cadena-sesion"),
                "usuario-id" => Session::get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>$datos,
            ]
        ]);

        $response = json_decode($response->getBody(),true) ;

        return $response;
    }

    public function enviar_remision( Request $request ){ 
        $ruta = $request->entorno['variables_entorno']['ruta_logs'];
        $log = fopen($ruta. 'remisiones_ue/log_'.Session::get("usuario-id").'_'.$request->remision_in.".txt", "a");
        fwrite($log, "\n* * * * *  Registro de remisión  * * * * *\n");
        fwrite($log,"Tipo de remisión: ".$request->tipo_remision."\n");
        fwrite($log, "inicia: ".date('Y-m-d H:i:s')."\n");
      
        try{
            if( isset($request->fecha_causa_ejecutoria )) $fecha_causa_ejecutoria = date('Y-m-d', strtotime($request->fecha_causa_ejecutoria));
            else $fecha_causa_ejecutoria = '-';
            
            $documentos = [];
            if(  isset($request->dataDoc) ){

                $data_doc = json_decode($request->dataDoc, true);

                if( $request->tipo_remision == 'unidad_ejecucion' )
                    $url_doc = $request->entorno['variables_entorno']['ruta_storage']."app".$data_doc[0]['url'];
                else
                    $url_doc = $request->entorno['variables_entorno']['ruta_storage']."app".$data_doc['url'];

                $documentos=[
                    [
                    "b64"=>base64_encode(file_get_contents( $url_doc )),
                    "extension"=>"pdf",
                    "id_tipo_archivo"=>"0",
                    "nombre_archivo"=>"remision_".str_replace('/','_',$request->carpeta_a_remitir),
                    "tamanio"=>$request->tamanio_archivo,
                    ]
                ];
            }

            if( isset($request->regresar_remision) && $request->regresar_remision == 'si' )
                $datos = [
                    "tipo_remision" => $request->tipo_remision,
                    "remision_regreso" => $request->regresar_remision,
                    "comentarios" => $request->comentarios_adicionales,
                    "documentos"=>$documentos,
                    "fecha_registro" => date("Y-m-d H:i:s"),
                ];
            else
                $datos = [
                    "tipo_remision" => $request->tipo_remision,
                    "fecha_registro" => date("Y-m-d H:i:s"),
                    "motivo_incompetencia" => $request->motivo_incompetencia,
                    "motivo_incompetencia_otro" => $request->motivo_incompetencia_otro,
                    "materia_destino" => $request->materia_destino,
                    "id_fiscalia" => $request->fiscalia,
                    "tipo_unidad_destino" => $request->tipo_unidad_destino,
                    "imputado_privado_libertad" => $request->privado_libertad,
                    "edificio_reclusorio" => $request->edificio_receptor,
                    "unidad_destino" => $request->unidades,
                    "id_personas_remitidas" => $request->personas_remitidas,
                    "comentarios" => $request->comentarios_adicionales,
                    "lugar_internamiento" => $request->lugar_internamiento == null ? 0 : $request->lugar_internamiento,
                    "TE_id_audiencia" => $request->id_audiencia_TE == null ? '-' : $request->id_audiencia_TE,
                    "TE_fecha_audiencia" => $request->fecha_audiencia_TE == null ? '-' : $request->fecha_audiencia,
                    "TE_id_juez_audiencia" => $request->juez_audiencia_TE == null ? '-' : $request->juez_audiencia,
                    "EJEC_id_audiencia" => $request->fecha_audiencia_sentencia,
                    "EJEC_fecha_audiencia" => $request->fecha_audiencia,
                    "EJEC_id_juez_sentencia" => $request->juez,
                    "EJEC_fecha_ejecutoria" => $fecha_causa_ejecutoria,
                    "EJEC_nom_juez_sentencia" => $request->juez_dicto_sentencia,
                    "LN_vinculacion_proceso" => $request->LN_vinculacion_proceso,
                    "LN_fecha_audiencia" => $request->LN_fecha_audiencia,
                    "LN_id_audiencia" => $request->LN_id_audiencia,
                    "LN_id_juez_audiencia" => $request->LN_id_juez_audiencia,
                    "LN_nom_juez_audiencia" => $request->LN_nomjuez_audiencia,
                    "documentos"=>$documentos
                ];

            if( Session::get('id_tipo_usuario') == 1 ) $unidad=$request->unidad_carpeta;
            else $unidad=Session::get('id_unidad_gestion');
            
            fwrite($log, "Datos enviados :".json_encode($datos)."\n");

            $response = $request
            ->clienteWS_penal
            ->request('post', 'registrar_remision/'.Session::get("usuario-id").'/'.$unidad.'/'.$request->carpeta,[
                "headers" => [
                    "sesion-id" => Session::get("sesion-id"),
                    "cadena-sesion" => Session::get("cadena-sesion"),
                    "usuario-id" => Session::get("usuario-id"),
                    "Content-Type" => "application/json"
                ],
                "json"=>[
                    "datos"=>$datos,
                ]
            ]);

            $response = json_decode($response->getBody(),true) ;
            fwrite($log, "Respuesta back :".json_encode($response)."\n");
            return $response;

        }catch(\Exception $e){
            fwrite($log,"Error: ".$e->getMessage()." ".$e->getFile()." line".$e->getLine()."\n");
            return ['status' => 0, "message" => "Ocurrió un error, inténte más tarde.\n Si el problema persiste repórtelo a sistemas."];
        }
    }

    public function autorizacion_remision(Request $request){
        
        $datos=[
            "autorizacion"=>$request->autorizacion,
            "comentarios"=>$request->comentarios,
        ];

        $response = $request
        ->clienteWS_penal
        ->request('post', 'autorizacion_remision/'.Session::get('usuario_id').'/'.Session::get('id_unidad_gestion').'/'.$request->solicitud,[
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

    public function obtener_datos_remision( Request $request ){

        // $tipo_solicitud=$request->tipo;
        $datos=[
            "modo" => $request->modo == null ? 'completo' : $request->modo,
            "id_remision" => $request->remision==null?'-':$request->remision,
            "carpeta_judicial" => $request->carpeta==null?'-':$request->carpeta,
            "folio_carpeta_rem" => $request->folio_carpeta==null?'-':$request->folio_carpeta,
            "tipo_remision" => $request->tipo_remision==null?'-':$request->tipo_remision,
            "folio" => $request->folio==null?'-':$request->folio,
            "fecha_registro_min" => $request->fecha_min==null?'-':$request->fecha_min,
            "fecha_registro_max" => $request->fecha_max==null?'-':$request->fecha_max,
            "autorizacion" => $request->autorizacion==null?'-':$request->autorizacion,
            "id_carpeta_judicial" => $request->carpeta_judicial_id==null?'-':$request->carpeta_judicial_id,
            "id_carpeta_judicial_rem" => $request->carpeta_juidicial_rem_id==null?'-':$request->carpeta_juidicial_rem_id,
        ];


        $response = $request
        ->clienteWS_penal
        ->request('get', 'consultar_remisiones',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>$datos
            ]
        ]);
        $response = json_decode($response->getBody(),true) ;

        return $response;

    }

    public function obtener_documentos_remision( Request $request ){
        
        if(isset($request->id_remision)) return redirect(archivos::obtener_documentos_remision($request, $request->id_remision, $request->version)['response']);
        
        return archivos::obtener_documentos_remision($request, $request->remision, $request->version);

    }

    public function obtener_fechas_aud_sent( Request $request ){


        $datos=[
            "id_audiencia"=>"-",
            "id_cj"=>$request->carpeta_judicial,
            "id_unidad"=>"-",
            "id_inmueble"=>"-",
            "id_sala"=>"-",
            "id_juez"=>"-",
            "fecha_min"=>"-",
            "fecha_max"=>"-"
        ];
        $paginacion=[
            "pagina"=>1,
            "registros_por_pagina"=>200
        ];

        $response = $request
        ->clienteWS_penal
        ->request('get', 'obtener_audiencias',[
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

    public function consultar_remisiones_carpeta( Request $request ){


        $datos=[
            "id_carpeta_judicial"=>$request->carpeta_judicial,
            ];
        $paginacion=[
            "pagina"=>1,
            "registros_por_pagina"=>200
        ];

        $response = $request
        ->clienteWS_penal
        ->request('get', 'consultar_remisiones',[
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

    public function registrar_personas_remision( Request $request ){
        
        $ruta = $request->entorno['variables_entorno']['ruta_logs'];
        $log = fopen($ruta. 'remisiones_ue/log_'.Session::get("usuario-id").'_'.$request->remision_in.".txt", "a");
        fwrite($log, "\n* * * * *  Registro de personas  * * * * *\n");
        fwrite($log, "inicia: ".date('Y-m-d H:i:s')."\n");
        // return $request;
        try{
            $datos = [];
            if( $request->seccion == 'sentenciados' ) {

                $sentenciados=[];
                foreach( json_decode($request->data,true) as $sentenciado ){
                
                    $penas = [];
                    foreach( $sentenciado['penas'] as $pena ){
                        
                        $ids_delitos = '';
                        foreach( $pena['delitos'] as $key_delito => $delito ){
                            if( $key_delito == 0 ){
                                $ids_delitos.= $delito['id_delito'];
                            }else{
                                $ids_delitos.= ",".$delito['id_delito'];
                            }
                        }

                        $abonos = [];
                        if( isset($pena['abonos']) ){
                            foreach( $pena['abonos'] as $abono ){
                                $abonos[] = [
                                    "periodo_anios" => $abono['anios_abono'],
                                    "periodo_meses" => $abono['meses_abono'],
                                    "periodo_dias" => $abono['dias_abono'],
                                    "id_centro_detencion" => $abono['centro_detencion'],
                                    "otro" => $abono['centro_detencion_otro'],
                                ];
                            }
                        }

                        $sustitutivos = [];
                        if( isset($pena['sustitutivos']) ){
                            foreach( $pena['sustitutivos'] as $sustitutivo ){
                                $sustitutivos[] = [
                                    "id_sustitutivo" => $sustitutivo['sustitutivo'],
                                    "monto" => str_replace(['$',','], '', $sustitutivo['monto']),
                                    "acoge_sustitutivo" => $sustitutivo['acoge_sustitutivo'],
                                    "detalles" => $sustitutivo['detalles_adicionales'],
                                ];
                            }
                        }

                        $penas[] = [
                            "id_tipo_pena" => $pena['tipo_pena'],
                            "id_pena_impuesta" => $pena['pena_impuesta'],
                            "id_sub_pena_impuesta" => $pena['detalle_pena'],
                            "id_centro_detencion" => $pena['centro_detencion_pena'],
                            "periodo_anios" => $pena['periodo_anios'],
                            "periodo_meses" => $pena['periodo_mese'],
                            "periodo_dias" => $pena['periodo_dias'],
                            "monto_garantia" => "-",
                            "decomiso_instrumento" => $pena['decomiso_instrumento']=='true'?1:0,
                            "decomiso_objetos" => $pena['decomiso_objetos']=='true'?1:0,
                            "decomiso_productos_delito" => $pena['decomiso_productos_delito']=='true'?1:0,
                            "sustitutivo_pena" => $pena['sustitutivo_pena'],
                            "detalles_adicionales" => $pena['detalles_adicionales_pena'],
                            "suspension_condicional" =>  $sentenciado['suspension_ejecucion'] == 'no' ? '0' : $pena['suspension_condicional'],
                            "ids_delitos" => $ids_delitos,
                            "abonos" => $abonos,
                            "sustitutivos" => $sustitutivos
                        ];
                    }

                    $sentenciados[] = [
                        "id_persona" => $sentenciado['sentenciado'],
                        "en_libertad" => $sentenciado['sentenciado_libertad'],
                        "id_unidad_centro_detencion" => $sentenciado['centro_detencion'],
                        "suspension_condicional"=> $sentenciado['suspension_ejecucion'],
                        "monto_garantia" => $sentenciado['suspension_ejecucion'] == 'si' ? (str_replace(['$',','], '', $sentenciado['monto_garantia'])) : '-',
                        "penas" => $penas
                    ];
                }

                $datos = [
                    "sentenciados" => $sentenciados,
                ];
                // return $datos;
            }elseif( $request->seccion == 'defensores' ) {
                
                $defensores = [];
                foreach( json_decode($request->data,true) as $defensor ){
                    $defensores[] = [
                        "id_persona" => $defensor['persona'],
                        "tipo_defensor" => $defensor['tipo_defensor'],
                        "ids_sentenciados_defendidos" => $defensor['ids_sentenciados_defendidos'],
                    ];
                }

                $datos = [
                    "defensores" => $defensores
                ];
            }elseif( $request->seccion == 'victimas' ) {
                $victimas = [];
                
                foreach( json_decode($request->data,true) as $victima ){
                    $victimas[] = [
                        "id_persona" => $victima['victima'],
                    ];
                }

                $datos = [
                    "victimas" => $victimas,
                ];

            }elseif( $request->seccion == 'asesores_juridicos' ) {
                $asesores = [];
                
                foreach( json_decode($request->data,true) as $asesor ){
                    $asesores[] = [
                        "id_persona" => $asesor['asesor'],
                        "ids_victimas_asesorados" => $asesor['ids_victimas_asesorados'],
                    ];
                }

                $datos = [
                    "asesores_juridicos" => $asesores,
                ];

            }elseif( $request->seccion == 'ministerio_publico' ) {
                $ministerio_publico = [];
                
                foreach( json_decode($request->data,true) as $ministerio ){
                    $ministerio_publico[] = [
                        "id_persona" => $ministerio['ministerio_publico'],
                    ];
                }

                $datos = [
                    "ministerio_publico" => $ministerio_publico,
                ];

            }elseif( $request->seccion == 'informacion_complementaria' ) {

                $data = json_decode($request->data,true);
                $ids_audiencias = '';

                foreach ( $data['audiencias'] as $key => $audiencia ) {
                    if ( $key != 0 )
                        $ids_audiencias .= ','.$audiencia['id'];
                    else
                        $ids_audiencias .= $audiencia['id'];
                }

                $billetes = [];

                foreach ( $data['billetes'] as $billete ) {
                    $billetes[] = [
                        "numero_billete" => $billete['numero_billete'],
                        "monto" => str_replace(['$',','], '', $billete['monto']),
                    ];
                }
                
                $informacion_complementaria = [
                    "b64_pdf_cop_cer_sentencia" => base64_encode(file_get_contents($request->entorno['variables_entorno']['ruta_storage'].'app'.$data['copia_certificada_sentencia']['url'])),
                    "b64_pdf_cop_cer_auto" => base64_encode(file_get_contents($request->entorno['variables_entorno']['ruta_storage'].'app'.$data['copia_certificada_auto']['url'])),
                    "b64_pdf_act_mini_audiencia" => base64_encode(file_get_contents($request->entorno['variables_entorno']['ruta_storage'].'app'.$data['acta_minima']['url'])),
                    "numero_dvds" => $data['numero_dvds'],
                    "ids_audiencias_remitidas" => $ids_audiencias,
                    "billetes_deposito" => $billetes,
                    "objetos_asegurados" => $data['objetos_asegurados'],
                ];
                
                $datos = [
                    "informacion_complementaria" => $informacion_complementaria,
                ];

            }elseif( $request->seccion == 'adjuntos' ) {
                
                $data = json_decode($request->data,true);

                $adjuntos = [];

                foreach ( $data as $adjunto ) {

                    $adjuntos[] = [
                        "b64" => base64_encode(file_get_contents($request->entorno['variables_entorno']['ruta_storage'].'app'.$adjunto['url'])),
                        "id_tipo_archivo" => $adjunto['tipo_documento'],
                        "nombre_archivo" => $adjunto['nombre_archivo'],
                        "extension" => str_replace('.','',$adjunto['extension_archivo']),
                        "tamanio_archivo" => $adjunto['tamanio_archivo'] 
                    ];
                }

                $datos = [
                    "adjuntos" => $adjuntos,
                ];

                return $datos;
            }
            
            fwrite($log,"Datos enviados: ".json_encode($datos)."\n");
            // return $datos;
            $response = $request
            ->clienteWS_penal
            ->request('post', 'remision_ejec_personas/'.Session::get("usuario-id").'/'.$request->remision_in.'/'.$request->seccion,[
                "headers" => [
                    "sesion-id" => Session::get("sesion-id"),
                    "cadena-sesion" => Session::get("cadena-sesion"),
                    "usuario-id" => Session::get("usuario-id"),
                    "Content-Type" => "application/json"
                ],
                "json"=>[
                    "datos"=>$datos,
                ]
            ]);

            $response = json_decode($response->getBody(),true) ;
            fwrite($log,"Respuesta back: ".json_encode($response)."\n");
            return $response;

        }catch( \Exception $e ){
            fwrite($log,"Error: ".$e->getMessage()." ".$e->getFile()." line".$e->getLine()."\n");
            return ['status' => 0, "message" => "Ocurrió un error, inténte más tarde.\n Si el problema persiste repórtelo a sistemas."];
        }        
        
        
    }

    public function obtener_personas_remision( Request $request ){
        
        $response = $request
        ->clienteWS_penal
        ->request('get', 'obtener_remision_ejec_personas/'.$request->remision,[
            "headers" => [
                "sesion-id" => Session::get("sesion-id"),
                "cadena-sesion" => Session::get("cadena-sesion"),
                "usuario-id" => Session::get("usuario-id"),
                "Content-Type" => "application/json"
            ]
        ]);

        $response = json_decode($response->getBody(),true) ;

        return $response;
    }

    public function actualizar_personas_remision( Request $request ){
        $ruta = $request->entorno['variables_entorno']['ruta_logs'];
        $log = fopen($ruta. 'remisiones_ue/log_'.Session::get("usuario-id").'_'.$request->remision_in.".txt", "a");
        fwrite($log, "\n* * * * *  Actualización de personas  * * * * *\n");
        fwrite($log, "inicia: ".date('Y-m-d H:i:s')."\n");
        
        try{
            if( $request-> seccion == 'inicial' ){
                return json_encode($request->dataDoc,true);
                $datos_inicial = [
                    "EJEC_fecha_ejecutoria" => date('Y-m-d',strtotime($request->fecha_causa_ejecutoria)),
                    "EJEC_id_audiencia" =>  $request->fecha_audiencia_sentencia,
                    "EJEC_fecha_audiencia" => $request->fecha_audiencia,
                    "EJEC_id_juez_sentencia" => $request->juez,
                    "EJEC_nom_juez_sentencia" => $request->juez_dicto_sentencia
                ];
                
                $datos = [
                    "inicial" => $datos_inicial,
                ];
            }elseif( $request->seccion == 'sentenciados' ){

                $sentenciados=[];
                foreach( json_decode($request->data,true) as $sentenciado ){
                
                    $penas = [];
                    foreach( $sentenciado['penas'] as $pena ){
                        
                        $ids_delitos = '';
                        foreach( $pena['delitos'] as $key_delito => $delito ){
                            if( $delito['estatus'] == 1 ){
                                if( $key_delito == 0 ){
                                    $ids_delitos.= $delito['id_delito'];
                                }else{
                                    $ids_delitos.= ",".$delito['id_delito'];
                                }
                            }
                        }

                        $abonos = [];
                        if( isset($pena['abonos']) ){
                            foreach( $pena['abonos'] as $abono ){
                                $abonos[] = [
                                    "id" => (string)$abono['id']=='-'?'0':$abono['id'],
                                    "estatus" => $abono['estatus'],
                                    "periodo_anios" => $abono['anios_abono'],
                                    "periodo_meses" => $abono['meses_abono'],
                                    "periodo_dias" => $abono['dias_abono'],
                                    "id_centro_detencion" => $abono['centro_detencion'],
                                    "otro" => $abono['centro_detencion_otro'],
                                ];
                            }
                        }

                        $sustitutivos = [];
                        if( isset($pena['sustitutivos']) ){
                            foreach( $pena['sustitutivos'] as $sustitutivo ){
                                $sustitutivos[] = [
                                    "id" => (string)$sustitutivo['id']=='-'?'0':$sustitutivo['id'],
                                    "estatus" => $sustitutivo['estatus'],
                                    "id_sustitutivo" => $sustitutivo['sustitutivo'],
                                    "monto" => str_replace(['$',','], '', $sustitutivo['monto']) ,
                                    "acoge_sustitutivo" => $sustitutivo['acoge_sustitutivo'],
                                    "detalles" => $sustitutivo['detalles_adicionales'],
                                ];
                            }
                        }
                        

                        $penas[] = [
                            "id" => (string)$pena['id']=='-'?'0':$pena['id'],
                            "estatus" => $pena['estatus'],
                            "id_tipo_pena" => $pena['tipo_pena'],
                            "id_pena_impuesta" => $pena['pena_impuesta'],
                            "id_sub_pena_impuesta" => $pena['detalle_pena'],
                            "id_centro_detencion" => $pena['centro_detencion_pena'],
                            "periodo_anios" => $pena['periodo_anios'],
                            "periodo_meses" => $pena['periodo_mese'],
                            "periodo_dias" => $pena['periodo_dias'],
                            "monto_garantia" => "-",
                            "decomiso_instrumento" => $pena['decomiso_instrumento']=='true'?1:0,
                            "decomiso_objetos" => $pena['decomiso_objetos']=='true'?1:0,
                            "decomiso_productos_delito" => $pena['decomiso_productos_delito']=='true'?1:0,
                            "sustitutivo_pena" => $pena['sustitutivo_pena'],
                            "detalles_adicionales" => $pena['detalles_adicionales_pena'],
                            "suspension_condicional" => $sentenciado['suspension_ejecucion'] == 'no' ? '0' : $pena['suspension_condicional'],
                            "ids_delitos" => $ids_delitos,
                            "abonos" => $abonos,
                            "sustitutivos" => $sustitutivos
                        ];
                    }

                    $sentenciados[] = [
                        "id" => (string)$sentenciado['id']=='-'?'0':$sentenciado['id'],
                        "estatus" => (string)($sentenciado['estatus']),
                        "id_persona" => $sentenciado['sentenciado'],
                        "en_libertad" => $sentenciado['sentenciado_libertad'],
                        "id_unidad_centro_detencion" => $sentenciado['centro_detencion'],
                        "suspension_condicional"=> $sentenciado['suspension_ejecucion'],
                        "monto_garantia" => $sentenciado['suspension_ejecucion'] == 'si' ? (str_replace(['$',','], '', $sentenciado['monto_garantia'])) : '-',
                        "penas" => $penas
                    ];
                }

                $datos = [
                    "sentenciados" => $sentenciados,
                ];
              
            }elseif( $request->seccion == 'defensores' ){
                
                $defensores = [];
                foreach( json_decode($request->data,true) as $defensor ){
                    $defensores[] = [
                        "id" => (string)$defensor['id'],
                        "estatus" => $defensor['estatus'],
                        "id_persona" => $defensor['persona'],
                        "tipo_defensor" => $defensor['tipo_defensor'],
                        "ids_sentenciados_defendidos" => $defensor['ids_sentenciados_defendidos'],
                    ];
                }

                $datos = [
                    "defensores" => $defensores
                ];
            }elseif( $request->seccion == 'victimas' ){
                $victimas = [];
                
                foreach( json_decode($request->data,true) as $victima ){
                    $victimas[] = [
                        "id_persona" => $victima['victima'],
                        "id" => (string)$victima['id'],
                        "estatus" => $victima['estatus']
                    ];
                }

                $datos = [
                    "victimas" => $victimas,
                ];

            }elseif( $request->seccion == 'asesores_juridicos' ){
                $asesores = [];
                
                foreach( json_decode($request->data,true) as $asesor ){
                    $asesores[] = [
                        "id_persona" => $asesor['asesor'],
                        "id" => (string)$asesor['id'],
                        "estatus" => $asesor['estatus'],
                        "ids_victimas_asesorados" => $asesor['ids_victimas_asesorados'],
                    ];
                }

                $datos = [
                    "asesores_juridicos" => $asesores,
                ];

            }elseif( $request->seccion == 'ministerio_publico' ){
                $ministerio_publico = [];
                
                foreach( json_decode($request->data,true) as $ministerio ){
                    $ministerio_publico[] = [
                        "id_persona" => $ministerio['ministerio_publico'],
                        "id" => (string)$ministerio['id'],
                        "estatus" => $ministerio['estatus'],
                    ];
                }

                $datos = [
                    "ministerio_publico" => $ministerio_publico,
                ];

            }elseif( $request->seccion == 'informacion_complementaria' ){

                $data = json_decode($request->data,true);
                $ids_audiencias = '';
                // return $data;
                foreach ( $data['audiencias'] as $key => $audiencia ) {
                    if ( $key != 0 )
                        $ids_audiencias .= ','.$audiencia['id'];
                    else
                        $ids_audiencias .= $audiencia['id'];
                }

                $billetes = [];

                foreach ( $data['billetes'] as $billete ) {
                    $billete_remision = [
                        "numero_billete" => $billete['numero_billete'],
                        "monto" => str_replace(['$',','], '', $billete['monto']),
                        "id" => (string)$billete['id'],
                    ];

                    if( $request->billete_remision == 'si' )
                        $billete_remision["estatus"] = (string)$billete['estatus'];
                    else
                        $billete_remision["estatus"] = "0";

                    $billetes[] = $billete_remision;
                }

                $objetos_asegurados = [];

                foreach( $data['objetos_asegurados'] as $objeto ) {
                    $objeto_remision = [
                        "id" => (string)$objeto['id'],
                        "objeto_descripcion" => $objeto['objeto_descripcion'],
                        "objeto_ubicacion" => $objeto['objeto_descripcion']
                    ];

                    if( $request->objeto_asegurado == 'si' )
                        $objeto_remision['estatus'] =  (string)$objeto['estatus'];
                    else
                        $objeto_remision['estatus'] = "0";

                    $objetos_asegurados[] = $objeto_remision;
                }

                $informacion_complementaria = [
                    "id" => (string)$data['id'],
                    "numero_dvds" => $data['numero_dvds'],
                    "ids_audiencias_remitidas" => $ids_audiencias,
                    "billetes_deposito" => $billetes,
                    "objetos_asegurados" => $objetos_asegurados,
                ];

                if( $data['copia_certificada_sentencia']['estatus'] == 1 ) {
                    $informacion_complementaria['b64_pdf_cop_cer_sentencia'] = base64_encode(file_get_contents($request->entorno['variables_entorno']['ruta_storage'].'app'.$data['copia_certificada_sentencia']['url']));
                    $informacion_complementaria['id_doc_sentencia'] = (string)$data['copia_certificada_sentencia']['id_documento'];
                }else 
                    $informacion_complementaria['b64_pdf_cop_cer_sentencia'] = "-";
                
                if( $data['copia_certificada_auto']['estatus'] == 1 ){
                    $informacion_complementaria['b64_pdf_cop_cer_auto'] = base64_encode(file_get_contents($request->entorno['variables_entorno']['ruta_storage'].'app'.$data['copia_certificada_auto']['url']));
                    $informacion_complementaria['id_doc_auto'] = (string)$data['copia_certificada_auto']['id_documento'];
                }else
                    $informacion_complementaria['b64_pdf_cop_cer_auto'] = "-";
                
                if( $data['acta_minima']['estatus'] == 1 ){
                    $informacion_complementaria['b64_pdf_act_mini_audiencia'] = base64_encode(file_get_contents($request->entorno['variables_entorno']['ruta_storage'].'app'.$data['acta_minima']['url']));
                    $informacion_complementaria['id_doc_audiencia'] = (string)$data['acta_minima']['id_documento'];
                }else
                    $informacion_complementaria['b64_pdf_act_mini_audiencia'] = "-";
                
                
                $datos = [
                    "informacion_complementaria" => $informacion_complementaria,
                ];
                
                // return $datos;;
            }elseif( $request->seccion == 'adjuntos' ) {
                
                $data = json_decode($request->data,true);
               
                $adjuntos = [];

                foreach ( $data as $adjunto ) {

                    $adjuntos[] = [
                        "b64" => base64_encode(file_get_contents($request->entorno['variables_entorno']['ruta_storage'].'app'.$adjunto['url'])),
                        "id_tipo_archivo" => $adjunto['tipo_documento'],
                        "nombre_archivo" => $adjunto['nombre_archivo'],
                        "extension" => str_replace('.','',$adjunto['extension_archivo']),
                        "tamanio_archivo" => $adjunto['tamanio_archivo'],
                        "id" => (string)$adjunto['id_documento'],
                        "estatus" => (string)$adjunto['estatus'],
                    ];
                }

                $datos = [
                    "adjuntos" => $adjuntos,
                ];
                // return $datos;
            }
            
            fwrite($log,"Datos enviados: ".json_encode($datos)."\n");
            // return $datos;
            $response = $request
            ->clienteWS_penal
            ->request('patch', 'remision_ejec_modificacion/'.Session::get("usuario-id").'/'.$request->remision_in.'/'.$request->seccion,[
                "headers" => [
                    "sesion-id" => Session::get("sesion-id"),
                    "cadena-sesion" => Session::get("cadena-sesion"),
                    "usuario-id" => Session::get("usuario-id"),
                    "Content-Type" => "application/json"
                ],
                "json"=>[
                    "datos"=>$datos,
                ]
            ]);

            $response = json_decode($response->getBody(),true) ;
            fwrite($log,"Respuesta back: ".json_encode($response)."\n");
            return $response;
        }catch( \Exception $e ){
            fwrite($log,"Error: ".$e->getMessage()." ".$e->getFile()." line ".$e->getLine()."\n");
            return ['status' => 0, "message" => "Ocurrió un error, inténte más tarde.<br> Si el problema persiste repórtelo a sistemas."];
        }        
        
    }

    public function obtener_documentos_inf_comp( Request $request ) {
        
        $response = $request
            ->clienteWS_penal
            ->request('get', 'consultar_documentos_remision/'.$request->remision.'/'.$request->documento,[
                "headers" => [
                    "sesion-id" => Session::get("sesion-id"),
                    "cadena-sesion" => Session::get("cadena-sesion"),
                    "usuario-id" => Session::get("usuario-id"),
                    "Content-Type" => "application/json"
                ],
            ]);

        $response = json_decode($response->getBody(),true) ;

        if( $request->documento !=  "" && $response['status'] == 100 ) {

            $rand=md5(date('YmdHis').rand(0,9999)).'_'.date('H');
            $ruta_publica = '/temporales/'.$rand.".pdf";
            $ruta_local = $request->entorno['variables_entorno']['ruta_storage'].'app/temporales/'.$rand.".pdf";

            copy( $response['response'] , $ruta_local);
            link($ruta_local, base_path().'/public/temporales/'.$rand.".pdf");
            // return $response;
            return ["status" => 100, "url" => $ruta_publica, "tipo_archivo" => $response['id_tipo_archivo']];

        }
            

        return $response;
    }

    public function remision_eje_autorizacion( Request $request ) {

        $response = $request
            ->clienteWS_penal
            ->request('post', 'remision_ejec_autorizacion/'.Session::get('usuario-id').'/'.$request->remision_in,[
                "headers" => [
                    "sesion-id" => Session::get("sesion-id"),
                    "cadena-sesion" => Session::get("cadena-sesion"),
                    "usuario-id" => Session::get("usuario-id"),
                    "Content-Type" => "application/json"
                ],
            ]);

        $response = json_decode($response->getBody(),true) ;

        return $response;
    }

    public function modificar_remision( Request $request) {

        $documentos = [];
        // return json_decode($request->dataDoc,true);
        if( isset( $request->dataDoc ) ) {  
            foreach( json_decode($request->dataDoc,true) as $documento ) {
                if( $documento['id_documento'] != 0 )
                    $documentos[] = [
                        "id" => $documento['id_documento'],
                        "estatus" => $documento['estatus']
                    ];
                else if ( $documento['estatus'] != 0 )
                    $documentos[] = [
                        "id" => $documento['id_documento'],
                        "estatus" => $documento['estatus'],
                        "b64" => base64_encode(file_get_contents($request->entorno['variables_entorno']['ruta_storage'].'app'.$documento['url'])),
                        "extension" => str_replace(".","",$documento['extension_archivo']),
                        "id_tipo_archivo" => 0,
                        "nombre_archivo" => $documento['nombre_archivo'],
                        "tamanio" => $documento['tamanio_archivo'],
                    ];
            }
        }
        
        $datos = [
            "autorizacion" => $request->autorizacion == null ? 'si' : $request->autorizacion,
            "motivo_incompetencia" => $request->motivo_incompetencia,
            "motivo_incompetencia_otro" => $request->motivo_incompetencia_otro,
            "materia_destino" => $request->materia_destino,
            "id_fiscalia" => $request->fiscalia,
            "tipo_unidad_destino" => $request->tipo_unidad_destino,
            "imputado_privado_libertad" => $request->privado_libertad,
            "edificio_reclusorio" => $request->edificio_receptor,
            "unidad_destino" => $request->unidades,
            "id_personas_remitidas" => $request->personas_remitidas,
            "comentarios" => $request->comentarios,
            "lugar_internamiento" => $request->lugar_internamiento == null ? 0 : $request->lugar_internamiento,
            "TE_id_audiencia" => $request->id_audiencia_TE == null ? '-' : $request->id_audiencia_TE,
            "TE_fecha_audiencia" => $request->fecha_audiencia_TE == null ? '-' : $request->fecha_audiencia,
            "TE_id_juez_audiencia" => $request->juez_audiencia_TE == null ? '-' : $request->juez_audiencia,
            "EJEC_id_audiencia" => $request->fecha_audiencia_sentencia == null ? '-' : $request->fecha_audiencia_sentencia,
            "EJEC_fecha_audiencia" => $request->fecha_audiencia == null ? '-' : $request->fecha_audiencia,
            "EJEC_id_juez_sentencia" => $request->juez == null ? '-' : $request->juez,
            "EJEC_fecha_ejecutoria" => $request->fecha_causa_ejecutoria == null ? '-' : date("Y-m-d H:i:s", strtotime($request->fecha_causa_ejecutoria)),
            "EJEC_nom_juez_sentencia" => $request->juez_dicto_sentencia == null ? '-' : $request->juez_dicto_sentencia,
            "LN_vinculacion_proceso" => $request->LN_vinculacion_proceso,
            "LN_fecha_audiencia" => $request->LN_fecha_audiencia,
            "LN_id_audiencia" => $request->LN_id_audiencia,
            "LN_id_juez_audiencia" => $request->LN_id_juez_audiencia,
            "LN_nom_juez_audiencia" => $request->LN_nomjuez_audiencia,
            "documentos"=>$documentos
        ];

        // return $datos;
        $response = $request
            ->clienteWS_penal
            ->request('patch', 'modificacion_remision/'.Session::get('usuario-id').'/'.Session::get('id_unidad_gestion').'/'.$request->remision,[
                "headers" => [
                    "sesion-id" => Session::get("sesion-id"),
                    "cadena-sesion" => Session::get("cadena-sesion"),
                    "usuario-id" => Session::get("usuario-id"),
                    "Content-Type" => "application/json"
                ],
                "json" => [
                    "datos" => $datos
                    ]
            ]);

        $response = json_decode($response->getBody(),true) ;

        return $response;
    }

    public function valida_historial_carpeta_remision( Request $request ) {
        
        $response = $request
            ->clienteWS_penal
            ->request('get', 'validacion_remision_regreso/'.$request->carpeta,[
                "headers" => [
                    "sesion-id" => Session::get("sesion-id"),
                    "cadena-sesion" => Session::get("cadena-sesion"),
                    "usuario-id" => Session::get("usuario-id"),
                    "Content-Type" => "application/json"
                ]
            ]);

        $response = json_decode($response->getBody(),true) ;

        return $response;

    }

}
