<?php

namespace App\Http\Controllers\expediente_buscar;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\clases\bandejas;
use SoapClient;

class control_plugin_buscar_expediente extends Controller
{
    public function action_obtener_anios( Request $request )
    {
        $anio_inicio = $request->entorno["variables_entorno"]["ANIO_INICIO"];
        $anio_fin = $request->entorno["variables_entorno"]["ANIO_FIN"];

        return json_encode( array(  'status'=>100,
                                    'response'=>[   'anio_inicio'=>$anio_inicio,
                                                    'anio_fin'=>$anio_fin]), JSON_UNESCAPED_UNICODE );
    }

    public function action_buscar( Request $request )
    {
        $response = $request
                        ->clienteWS
                        ->request('get', 'buscarArchivo',[
                            "query" => [
                                "datos"=>[
                                    "toca" => $request->toca,
                                    "anio_toca" => $request->anio_toca,
                                    "asunto_toca" => $request->asunto_toca,
                                    "por_turnar" => $request->por_turnar,
                                    "expediente" => $request->expediente,
                                    "expediente_anio" => $request->expediente_anio,
                                    "involucrado" => $request->involucrado,
                                    "registrado_desde" => $request->registrado_desde,
                                    "registrado_hasta" => $request->registrado_hasta
                                ]
                            ],
                            "headers" => [
                                "sesion-id" => $request->sesion_id,
                                "cadena-sesion" => $request->cadena_sesion,
                                "usuario-id" => $request->usuario_id
                            ]
                        ]);

        $responseBody = json_decode($response->getBody(),true) ;
        
        return $responseBody;
    }

    public function action_obtener_toca( Request $request )
    {
        $ruta = "buscarToca/" . $request->id_toca;

        $response = $request
                        ->clienteWS
                        ->request('get', $ruta,
                        [
                            "headers" => [
                                "sesion-id" => $request->sesion_id,
                                "cadena-sesion" => $request->cadena_sesion,
                                "usuario-id" => $request->usuario_id
                            ]
                        ]);

        $responseBody = json_decode($response->getBody(),true) ;

        return $responseBody;
    }

    public function action_obtener_resoluciones( Request $request )
    {
        $ruta = "consultaAcuerdos/" . $request->id_toca;

        $response = $request
                        ->clienteWS
                        ->request('get', $ruta,
                        [
                            "headers" => [
                                "sesion-id" => $request->sesion_id,
                                "cadena-sesion" => $request->cadena_sesion,
                                "usuario-id" => $request->usuario_id
                            ]
                        ]);

        $responseBody = json_decode($response->getBody(),true) ;

        return $responseBody;
    }

    public function action_obtener_tipos_firmas( Request $request )
    {
        $response = $request
                        ->clienteWS
                        ->request('get', 'obtenerTiposFirma',
                        [
                            "headers" => [
                                "sesion-id" => $request->sesion_id,
                                "cadena-sesion" => $request->cadena_sesion,
                                "usuario-id" => $request->usuario_id
                            ]
                        ]);

        $responseBody = json_decode($response->getBody(),true) ;

        return $responseBody;
    }

    public function action_subir_acuerdo( Request $request )
    {
        $ruta = "altaAcuerdo/" . $request->id_toca;

        $response = $request
                        ->clienteWS
                        ->request('post', $ruta,
                        [
                            "json" => [
                                "datos"=>[
                                    "id_tipo_firma" => $request->id_tipo_firma,
                                    "acuerdo" => $request->acuerdo,
                                    "resolvio" => $request->resolvio,
                                    "fecha" => $request->fecha,
                                    "publicar" => $request->publicar,
                                    "permiso_parte1" => $request->permiso_parte1,
                                    "permiso_parte2" => $request->permiso_parte2,
                                    "permiso_parte3" => $request->permiso_parte3,
                                    "especial" => $request->especial,
                                    "fecha_especial" => $request->fecha_especial,
                                    "visibilidad" => $request->visibilidad,
                                    "extension" => $request->extension,
                                    "extension_original" => $request->extension_original,
                                    "tipo" => $request->tipo,
                                    "publicar_en" => $request->publicar_en,
                                    "conciliador" => $request->conciliador,
                                    "concepto" => $request->concepto,
                                    "anotacion" => $request->anotacion,
                                    "id_propietario" => $request->id_propietario,
                                    "id_ultima_edicion" => $request->id_ultima_edicion,
                                    "es_edicto" => $request->es_edicto,
                                    "archivo64" => $request->archivo64,
                                    "nombre_archivo" => $request->nombre_archivo,
                                    "extension_archivo" => $request->extension_archivo,
                                    "tipo_firma_publicacion" => $request->tipo_firma_publicacion,
                                    "con_excusa" => $request->acuerdo_excusa,
                                ]
                            ],

                            "headers" => [
                                "sesion-id" => $request->sesion_id,
                                "cadena-sesion" => $request->cadena_sesion,
                                "usuario-id" => $request->usuario_id
                            ]
                        ]);

        $responseBody = json_decode($response->getBody(),true) ;

        return $responseBody;
    }

    public function action_obtener_flujos( Request $request )
    {
        $ponencia = ( strlen( trim($request->ponencia) ) > 0) ? "/". $request->ponencia : "/0";
        $tipo_calidad = ( strlen( trim($request->tipo_calidad) ) > 0) ? "/". $request->tipo_calidad : "/nada";

        $ruta = "obtenerFlujoDefault/" . $request->id_tipo_firma . $ponencia . $tipo_calidad . "/1";

        $response = $request
                        ->clienteWS
                        ->request('get', $ruta,
                        [
                            "headers" => [
                                "sesion-id" => $request->sesion_id,
                                "cadena-sesion" => $request->cadena_sesion,
                                "usuario-id" => $request->usuario_id
                            ]
                        ]);

        $responseBody = json_decode($response->getBody(),true) ;

        return $responseBody;
    }

    public function action_obtener_personal( Request $request )
    {        
        $acuerdo_excusa = ($request->acuerdo_excusa == 1) ? 1 : "";

        $ruta = "obtenerParticipantesParaFlujo/" . $acuerdo_excusa;

        $response = $request
                        ->clienteWS
                        ->request('get', $ruta,
                        [
                            "headers" => [
                                "sesion-id" => $request->sesion_id,
                                "cadena-sesion" => $request->cadena_sesion,
                                "usuario-id" => $request->usuario_id
                            ]
                        ]);

        $responseBody = json_decode($response->getBody(),true) ;

        return $responseBody;
    }

    public function action_registrar_flujo( Request $request )
    {
        $data = json_encode($request->datos, JSON_UNESCAPED_UNICODE);
        $data = json_decode($data, true);
        
        $datos_sesion = json_decode($data[0], true);
        $datos_creacion = json_decode($data[1], true);
        $datos_revisores = json_decode($data[2], true);
        $datos_firmantes = json_decode($data[3], true);

        $ruta = "registrarFlujo/" . $data[4];

        $response = $request
                        ->clienteWS
                        ->request('post', $ruta,
                        [
                            "headers" => [
                                "sesion-id" => $datos_sesion["sesion_id"],
                                "cadena-sesion" => $datos_sesion["cadena_sesion"],
                                "usuario-id" => $datos_sesion["usuario_id"]
                            ],

                            "json" => [
                                "datos"=>[
                                    "creador"=>$datos_creacion,
                                    "revisores"=>$datos_revisores,
                                    "firmas"=>$datos_firmantes,
                                ]
                            ]
                        ]);

        $responseBody = json_decode($response->getBody(),true) ;

        return $responseBody;
    }

    public function action_consultar_flujo( Request $request )
    {
        $ruta = "consultarFlujo/" . $request->id_acuerdo;

        $response = $request
                        ->clienteWS
                        ->request('get', $ruta,
                        [
                            "headers" => [
                                "sesion-id" => $request->sesion_id,
                                "cadena-sesion" => $request->cadena_sesion,
                                "usuario-id" => $request->usuario_id,
                            ]
                        ]
                    );

        $responseBody = json_decode($response->getBody(), true);

        return $responseBody;
    }

    public function action_consultar_flujo_sinse( Request $request, $id_acuerdo, $juzgado )
    {
        $ruta = "consultarFlujo/" . $id_acuerdo . "/" . $juzgado . "/no";

        $response = $request
                        ->clienteWS
                        ->request('get', $ruta,
                        [
                            "headers" => [
                                "sesion-id" => $request->sesion_id,
                                "cadena-sesion" => $request->cadena_sesion,
                                "usuario-id" => $request->usuario_id,
                            ]
                        ]
                    );

        $responseBody = json_decode($response->getBody(), true);

        return $responseBody;
    }

    public function action_modificar_flujo( Request $request )
    {
        $data = json_encode($request->datos, JSON_UNESCAPED_UNICODE);
        $data = json_decode($data, true);
        
        $datos_sesion = json_decode($data[0], true);        
        $datos_revisores = json_decode($data[1], true);
        $datos_firmantes = json_decode($data[2], true);

        $ruta = "modificarFlujo/" . $data[3];

        $response = $request
                        ->clienteWS
                        ->request('patch', $ruta,
                        [
                            "headers" => [
                                "sesion-id" => $datos_sesion["sesion_id"],
                                "cadena-sesion" => $datos_sesion["cadena_sesion"],
                                "usuario-id" => $datos_sesion["usuario_id"]
                            ],

                            "json" => [
                                "datos"=>[
                                    "revisores"=>$datos_revisores,
                                    "firmas"=>$datos_firmantes,
                                ]
                            ]
                        ]);

        $responseBody = json_decode($response->getBody(),true) ;

        return $responseBody;
    }

    public function action_obtener_notificaciones( Request $request )
    {
        $response = $request
                        ->clienteWS
                        ->request('get', 'obtenerNotificacionesBandejas',
                        [
                            "headers" => [
                                "sesion-id" => $request->sesion_id,
                                "cadena-sesion" => $request->cadena_sesion,
                                "usuario-id" => $request->usuario_id
                            ]
                        ]);
        $responseBody = json_decode($response->getBody(), true);

        return $responseBody;
    }

    public function action_obtener_acuerdos_para( Request $request )
    {
        $involucrados = json_decode($request->datos[1]["involucrado"], true);

        $ruta = 'obtenerAcuerdosPara/' . $request->datos[0]["tipo_accion"];
        
        $response = $request
                        ->clienteWS
                        ->request('get', $ruta,
                        [
                            "headers" => [
                                "sesion-id" => $request->datos[0]["sesion_id"],
                                "cadena-sesion" => $request->datos[0]["cadena_sesion"],
                                "usuario-id" => $request->datos[0]["usuario_id"]
                            ],

                            "query" => [
                                "datos" => [
                                    "toca" => $request->datos[1]["toca"],
                                    "anio" => $request->datos[1]["anio"],
                                    "asunto" => $request->datos[1]["asunto"],
                                    "expediente_num" => $request->datos[1]["expediente_num"],
                                    "expediente_anio" => $request->datos[1]["expediente_anio"],
                                    "involucrado" => [
                                        "nombres" => $involucrados["nombres"],
                                        "apellido_paterno" => $involucrados["apellido_paterno"],
                                        "apellido_materno" => $involucrados["apellido_materno"]
                                    ],
                                    "tipo_acuerdo" => $request->datos[1]["tipo_acuerdo"],
                                    "origen_acuerdo" => $request->datos[1]["origen_acuerdo"],
                                    "registrado_desde" => $request->datos[1]["registrado_desde"],
                                    "registrado_hasta" => $request->datos[1]["registrado_hasta"],
                                ]
                            ]
                        ]);
        $responseBody = json_decode($response->getBody(), true);

        return $responseBody;
    }

    public function action_obtener_acuerdo( Request $request )
    {
        //id_toca es igual al id_juicio
        $ruta = 'buscarAcuerdo/' . $request->id_toca . "/" . $request->id_acuerdo;
        
        $response = $request
                        ->clienteWS
                        ->request('get', $ruta,
                        [
                            "headers" => [
                                "sesion-id" => $request->sesion_id,
                                "cadena-sesion" => $request->cadena_sesion,
                                "usuario-id" => $request->usuario_id
                            ],
                        ]);

        $responseBody = json_decode($response->getBody(), true);

        return $responseBody;
    }

    public function action_modificar_casillas_acuerdo(  Request $request )
    {
        $datos_sesion = json_decode($request->datos[0], true);
        $datos_acuerdo = json_decode($request->datos[1], true);

        $ruta_modificacion = 'modificarAcuerdo/' . $datos_sesion["id_acuerdo"];

        $array_datos_acuerdo = array(   'id_tipo_firma'=>$datos_acuerdo["id_tipo_firma"],
                                        'tipo_firma'=>$datos_acuerdo["tipo_firma_estatus"],
                                        'acuerdo'=>$datos_acuerdo["acuerdo"],
                                        'resolvio'=>$datos_acuerdo["resolvio"],
                                        'fecha'=>$datos_acuerdo["fecha"],
                                        'fecha_a_publicar'=>$datos_acuerdo["publicar"],
                                        'activacion'=>$datos_acuerdo["activacion"],
                                        'activo'=>$datos_acuerdo["activo"],
                                        'apelacion'=>$datos_acuerdo["apelacion"],
                                        'conciliador'=>$datos_acuerdo["conciliador"],
                                        'permiso_parte1'=>$datos_acuerdo["permiso_parte1"],
                                        'permiso_parte2'=>$datos_acuerdo["permiso_parte2"],
                                        'permiso_parte3'=>$datos_acuerdo["permiso_parte3"],
                                        'estatus'=>$datos_acuerdo["estatus"],
                                        'tipo'=>$datos_acuerdo["tipo"],
                                        'especial'=>$datos_acuerdo["especial"],
                                        'fecha_especial'=>$datos_acuerdo["fecha_especial"],
                                        'anotacion'=>$datos_acuerdo["anotacion"],
                                        'visibilidad'=>$datos_acuerdo["visibilidad"],
                                        'publicar_en'=>$datos_acuerdo["publicar_en"],
                                        'concepto'=>$datos_acuerdo["concepto"],
                                        'voto_particular'=>$datos_acuerdo["voto_particular"],
                                        'fecha_voto'=>$datos_acuerdo["fecha_voto"],
                                        'comentario'=>$datos_acuerdo["comentario"],
                                        'es_edicto'=>$datos_acuerdo["es_edicto"]);

        $response_modificacion = $request
                                    ->clienteWS
                                    ->request('patch', $ruta_modificacion,
                                    [
                                        "headers" => [
                                            "sesion-id" => $datos_sesion["sesion_id"],
                                            "cadena-sesion" => $datos_sesion["cadena_sesion"],
                                            "usuario-id" => $datos_sesion["usuario_id"]
                                        ],

                                        "json" => [
                                            "datos" => $array_datos_acuerdo
                                            ],
                                    ]);
        $json_response = json_decode($response_modificacion->getBody(), true);
        
        return $json_response;
    }

    public function action_avance_flujo( Request $request )
    {
        $ruta = 'avanzar/' . $request->id_acuerdo . '/' . $request->tipo_accion;

        $response = $request
                        ->clienteWS
                        ->request('put', $ruta,
                        [
                            "headers" => [
                                "sesion-id" => $request->sesion_id,
                                "cadena-sesion" => $request->cadena_sesion,
                                "usuario-id" => $request->usuario_id
                            ]
                        ]);
        $responseBody = json_decode($response->getBody(), true);

        return $responseBody;
    }

    public function action_descargar_archivo( Request $request )
    {
        $ruta = 'obtenerArchivo/' . $request->id_acuerdo . '/' . $request->organo_pertenece . '/' . $request->version . '/' . $request->tipo_accion;

        $response = $request
                        ->clienteWS
                        ->request('get', $ruta,
                        [
                            "headers" => [
                                "sesion-id" => $request->sesion_id,
                                "cadena-sesion" => $request->cadena_sesion,
                                "usuario-id" => $request->usuario_id
                            ]
                        ]);
        $responseBody = json_decode($response->getBody(), true);

        return $responseBody;
    }

    public function action_subir_archivo( Request $request )
    {
        $datos = json_encode($request->datos, JSON_UNESCAPED_UNICODE);
        
        $datos = json_decode($datos, true);
        
        $datos_sesion = json_decode($datos[0], true);
        $word_b64 = ($datos[1] == "") ? "-" : $datos[1];
        $pdf_b64 = ($datos[2] == "") ? "-" : $datos[2];
        $extencion_word = ($datos[3] == "") ? "-" : $datos[3];

        $id_participnate_flujo = $datos_sesion["id_toca"];
        $id_acuerdo = $datos_sesion["id_acuerdo"];
        $organo_pertenece = $datos_sesion["organo_pertenece"];

        $tipo_accion = ($datos_sesion["tipo_accion"] == "") ? "" : "/" . $datos_sesion["tipo_accion"];

        $ruta = "subirDocumentosAcuerdo/" . $id_acuerdo . "/" . $organo_pertenece . "/" . $id_participnate_flujo . $tipo_accion;
        
        $response = $request
                        ->clienteWS
                        ->request('post', $ruta,
                        [
                            "headers" => [
                                "sesion-id" => $datos_sesion["sesion_id"],
                                "cadena-sesion" => $datos_sesion["cadena_sesion"],
                                "usuario-id" => $datos_sesion["usuario_id"],
                            ],

                            "json" => [
                                "datos"=>[
                                    "extension_word"=>$extencion_word,
                                    "b64_word"=>$word_b64,
                                    "b64_pdf"=>$pdf_b64,
                                ]
                            ]
                        ]);

        $responseBody = json_decode($response->getBody(),true) ;

        return $responseBody;
    }

    public function action_firmar_archivo_sicor( Request $request )
    {
        $datos = json_encode($request->datos, JSON_UNESCAPED_UNICODE);
        
        $datos = json_decode($datos, true);
        
        $datos_sesion = json_decode($datos[0], true);

        $word_b64 = ($datos[1] == "") ? "-" : $datos[1];
        $pdf_b64 = ($datos[2] == "") ? "-" : $datos[2];
        $extencion_word = ($datos[3] == "") ? "-" : $datos[3];

        $id_participnate_flujo = $datos_sesion["id_toca"];
        $id_acuerdo = $datos_sesion["id_acuerdo"];
        $organo_pertenece = $datos_sesion["organo_pertenece"];

        $tipo_accion = ($datos_sesion["tipo_accion"] == "") ? "" : "/" . $datos_sesion["tipo_accion"];

        $ruta = "subirDocumentosAcuerdo/" . $id_acuerdo . "/" . $organo_pertenece . "/" . $id_participnate_flujo . $tipo_accion;
        
        $bandejas = new bandejas();
        $pdf_b64 = $bandejas->documento_firmar_base64_ivn($request, $datos_sesion, $word_b64, $extencion_word, $id_acuerdo, $organo_pertenece);
        
        if($pdf_b64[0] == 100)
        {
            $word_b64 = "";

            for($i = 0; $i< 102; $i++)
            {
                $word_b64 .= "-";
            }
    
            $response = $request
                            ->clienteWS
                            ->request('post', $ruta,
                            [
                                "headers" => [
                                    "sesion-id" => $datos_sesion["sesion_id"],
                                    "cadena-sesion" => $datos_sesion["cadena_sesion"],
                                    "usuario-id" => $datos_sesion["usuario_id"],
                                ],
    
                                "json" => [
                                    "datos"=>[
                                        "extension_word"=>$extencion_word,
                                        "b64_word"=>$word_b64,
                                        "b64_pdf"=>$pdf_b64[1],
                                    ]
                                ]
                            ]);
    
            $responseBody = json_decode($response->getBody(),true);
        }

        else
        {
            $json = array(  "status" =>0,
                            "message"=>"No se pudo firmar este documento, intentelo mas tarde");

            $responseBody = $json;
        }

        return $responseBody;
    }

    public function action_firmar_archivo_firel( Request $request )
    {
        $datos = json_encode($request->datos, JSON_UNESCAPED_UNICODE);
        
        $datos = json_decode($datos, true);
        
        $responseBody = array("status"=>0, "message"=>"Ocurrio un error");

        $datos_sesion = json_decode($datos[0], true);

        $datos_firma = Json_decode($datos[1], true);

        $archivo_b64 = $datos[2];
        
        $client = new SoapClient("http://189.240.30.58:829/firmaDocumentos.asmx?WSDL");
        $response_firma_firel = $client->firmaDocumento(array("tipoCertificado" =>$datos_firma["tipoCertificado"],
                                                "documentoDestino"=>$datos_firma["documentoDestino"],
                                                "contenidoDocument"=>$archivo_b64,
                                                "contenidoCer"=> $datos_firma["contenidoCer"],
                                                "contenidoKey"=>$datos_firma["contenidoKey"],
                                                "passwd"=>$datos_firma["passwd"],
                                                "llaveFirmado"=>'35E4AF850A7764E78878227FFA88193F8BBE1592'

                ));

        $response_firma_firel= json_encode($response_firma_firel, JSON_UNESCAPED_UNICODE);

        $response_firma_firel = json_decode($response_firma_firel, true);

        $response_firel = json_decode($response_firma_firel["firmaDocumentoResult"], true);
       
        if($response_firel["resultado"] == 1)
        {
            $ruta = 'avanzar/' . $datos_sesion["id_acuerdo"] . '/avance';

            $response = $request
                            ->clienteWS
                            ->request('put', $ruta,
                            [
                                "headers" => [
                                    "sesion-id" => $datos_sesion["sesion_id"],
                                    "cadena-sesion" => $datos_sesion["cadena_sesion"],
                                    "usuario-id" => $datos_sesion["usuario_id"],
                                ]
                            ]);
            $responseBody = json_decode($response->getBody(), true);
                    return $responseBody;    
            if($responseBody["status"] == 100)
            {
                $id_flujo_participante = $responseBody["response"]["id_flujo_participante"];

                $ruta = "subirDocumentosAcuerdo/" . $datos_sesion["id_acuerdo"] . "/" . $datos_sesion["organo_pertenece"] . "/" . $id_flujo_participante;
    
                $word_b64 = "";
    
                for($i = 0; $i< 102; $i++)
                {
                    $word_b64 .= "-";
                }

                $response = $request
                                ->clienteWS
                                ->request('post', $ruta,
                                [
                                    "headers" => [
                                        "sesion-id" => $datos_sesion["sesion_id"],
                                        "cadena-sesion" => $datos_sesion["cadena_sesion"],
                                        "usuario-id" => $datos_sesion["usuario_id"],
                                    ],

                                    "json" => [
                                        "datos"=>[
                                        "extension_word"=>"doc",
                                        "b64_word"=>$word_b64,
                                        "b64_pdf"=>$response_firel["documento"],
                                    ]
                                ]
                            ]);

                $responseBody = json_decode($response->getBody(),true) ;
            }


            // $tipo_accion = ($datos_sesion["tipo_accion"] == "") ? "":"/" . $datos_sesion["tipo_accion"];

            // $ruta = "subirDocumentosAcuerdo/" . $datos_sesion["id_acuerdo"] . "/" . $datos_sesion["organo_pertenece"] . "/" . $datos_sesion["id_toca"] . $tipo_accion;
    
            // $word_b64 = "";
    
            // for($i = 0; $i< 102; $i++)
            // {
            //     $word_b64 .= "-";
            // }
    
            // Storage::put("private/mi_pdf.pdf", $archivo);
    
            // Storage::delete("private/mi_pdf.pdf");
    
            // //se obtiene la lista de archivos

            // $response = $request
            //                 ->clienteWS
            //                 ->request('post', $ruta,
            //                 [
            //                     "headers" => [
            //                         "sesion-id" => $datos_sesion["sesion_id"],
            //                         "cadena-sesion" => $datos_sesion["cadena_sesion"],
            //                         "usuario-id" => $datos_sesion["usuario_id"],
            //                     ],

            //                     "json" => [
            //                         "datos"=>[
            //                             "extension_word"=>"doc",
            //                             "b64_word"=>$word_b64,
            //                             "b64_pdf"=>$response_firel["documento"],
            //                         ]
            //                     ]
            //                 ]);

            // $responseBody = json_decode($response->getBody(),true) ;
        }

        else
        {
            $responseBody = array("status"=>0, "message"=>"No se pudo firmar");
        }

        return $responseBody;
    }

    public function action_proximas_publicaciones( Request $request )
    {
        //$request->por_turnar es igual a un "si" o ""
        $ruta = 'proximasPublicaciones/' . $request->por_turnar;

        $response = $request
                        ->clienteWS
                        ->request('get', $ruta,
                        [
                            "headers" => [
                                "sesion-id" => $request->sesion_id,
                                "cadena-sesion" => $request->cadena_sesion,
                                "usuario-id" => $request->usuario_id
                            ],

                            "query" => [
                                "datos"=>[
                                    "toca"=>$request->toca,
                                    "anio"=>$request->anio_toca,
                                    "asunto"=>$request->asunto_toca,
                                    "desde"=>$request->registrado_desde,
                                    "hasta"=>$request->registrado_hasta,
                                ]
                            ]
                        ]);

        $responseBody = json_decode($response->getBody(), true);

        return $responseBody;
    }

    public function action_imprimir_acuerdos_seleccionados( Request $request )
    {
        $datos_sesion = json_decode($request->datos[0], true);
        $datos_acuerdos = json_decode($request->datos[1], true);

        $mensaje = "";
        $mensaje_guardado = "";
        $array_url = array();
        $array_nombres = array();
        $array_rutas_local = array();

        $url_base = '/san/www/html/sicor_extendido/storage/app/porfirmar/';

        $url_descarga = "http://216.144.236.27:8080";

        foreach($datos_acuerdos as $valor)
        {
            //$valor["descripcion"] es igual al id_acuerdo
            //$valor["id"] es igual a ultima_version
            $ruta = 'obtenerArchivo/' . $valor["descripcion"] . '/' . $datos_sesion["organo_pertenece"] . '/' . $valor["id"] . '/pdf';

            $response = $request
                            ->clienteWS
                            ->request('get', $ruta,
                            [
                                "headers" => [
                                    "sesion-id" => $datos_sesion["sesion_id"],
                                    "cadena-sesion" => $datos_sesion["cadena_sesion"],
                                    "usuario-id" => $datos_sesion["usuario_id"]
                                ]
                            ]);

            $responseBody = json_decode($response->getBody(), true);

            if($responseBody["status"] == "100")
            {
                array_push($array_url, $responseBody["response"]);
                array_push($array_nombres, $valor["descripcion"] . '.pdf');
            }

            else if($responseBody["status"] == "0")
            {
                $mensaje .= $responseBody["message"] . "\n";
            }

            else
            {
                $mensaje .= "Ocurrio un error" . "\n";
            }
        }

        if(empty($mensaje) || count($array_url) > 0)
        {
            $return = json_encode(array("status" => 100,
                                        "message" => $mensaje,
                                        "response" => $array_url), JSON_UNESCAPED_UNICODE);

            foreach($array_url as $indice => $url)
            {
                $url_firma= $url_base . $array_nombres[$indice];

                $source = file_get_contents($url);
                file_put_contents($url_firma, $source);

                if(file_exists($url_firma))
                {
                    array_push($array_rutas_local, $url_firma);
                }

                else
                {
                    $mensaje_guardado .= "No se pudo guardar el archivo " . $array_nombres[$indice] . "\n";
                }
            }

            if(empty($mensaje_guardado) || count($array_rutas_local) > 0)
            {
                $response_coser = bandejas::documento_coser_pdf($array_rutas_local);

                if(!empty($response_coser["file"]))
                {
                    $return = json_encode(array("status" => 100,
                                                "message" => $mensaje . $mensaje_guardado,
                                                "response" => $url_descarga . $response_coser["file"]), JSON_UNESCAPED_UNICODE);
                    return $return;
                }

                else
                {
                    $return = json_encode(array("status" => 200,
                                                "message" => $mensaje . $mensaje_guardado . "No se pudo coser el PDF, posible error al coser",
                                                "response" => ""), JSON_UNESCAPED_UNICODE);
                    return $return; 
                }
            }
            else
            {
                $return = json_encode(array("status" => 200,
                                            "message" => $mensaje . $mensaje_guardado,
                                            "response" => ""), JSON_UNESCAPED_UNICODE);
                return $return;    
            }
        }

        else
        {
            $return = json_encode(array("status" => 200,
                                        "message" => $mensaje,
                                        "response" => ""), JSON_UNESCAPED_UNICODE);
            return $return;
        }
    }

    public function action_imprimir_acuerdos_todos( Request $request )
    {
        $ruta = "consultaAcuerdos/" . $request->id_toca;

        $response = $request
                        ->clienteWS
                        ->request('get', $ruta,
                        [
                            "headers" => [
                                "sesion-id" => $request->sesion_id,
                                "cadena-sesion" => $request->cadena_sesion,
                                "usuario-id" => $request->usuario_id
                            ]
                        ]);

        $responseBody = json_decode($response->getBody(),true) ;

        if($responseBody["status"] == "100")
        {
            $mensaje = "";
            $mensaje_guardado = "";
            $array_url = array();
            $array_nombres = array();
            $array_rutas_local = array();
    
            $url_base = '/san/www/html/sicor_extendido/storage/app/porfirmar/';
    
            $url_descarga = "http://216.144.236.27:8080";

            if(count($responseBody["response"]) > 0)
            {
                foreach($responseBody["response"] as $valor)
                {
                    $ruta = 'obtenerArchivo/' . $valor["id_acuerdo"] . '/' . $request->organo_pertenece . '/' . $valor["ultima_version"] . '/pdf';

                    $response = $request
                                    ->clienteWS
                                    ->request('get', $ruta,
                                    [
                                        "headers" => [
                                            "sesion-id" => $request->sesion_id,
                                            "cadena-sesion" => $request->cadena_sesion,
                                            "usuario-id" => $request->usuario_id
                                        ]
                                    ]);
        
                    $responseBody = json_decode($response->getBody(), true);
        
                    if($responseBody["status"] == "100")
                    {
                        array_push($array_url, $responseBody["response"]);
                        array_push($array_nombres, $valor["id_acuerdo"] . '.pdf');
                    }
        
                    else if($responseBody["status"] == "0")
                    {
                        $mensaje .= $responseBody["message"] . "\n";
                    }
        
                    else
                    {
                        $mensaje .= "Ocurrio un error" . "\n";
                    }
                }

                if(empty($mensaje) || count($array_url) > 0)
                {
                    $return = json_encode(array("status" => 100,
                                                "message" => $mensaje,
                                                "response" => $array_url), JSON_UNESCAPED_UNICODE);
        
                    foreach($array_url as $indice => $url)
                    {
                        $url_firma= $url_base . $array_nombres[$indice];
        
                        $source = file_get_contents($url);
                        file_put_contents($url_firma, $source);
        
                        if(file_exists($url_firma))
                        {
                            array_push($array_rutas_local, $url_firma);
                        }
        
                        else
                        {
                            $mensaje_guardado .= "No se pudo guardar el archivo " . $array_nombres[$indice] . "\n";
                        }
                    }
        
                    if(empty($mensaje_guardado) || count($array_rutas_local) > 0)
                    {
                        $response_coser = bandejas::documento_coser_pdf($array_rutas_local);
        
                        if(!empty($response_coser["file"]))
                        {
                            return json_encode(array("status" => 100,
                                                        "message" => $mensaje . $mensaje_guardado,
                                                        "response" => $url_descarga . $response_coser["file"]), JSON_UNESCAPED_UNICODE);
                        }
        
                        else
                        {
                            return json_encode(array("status" => 200,
                                                        "message" => $mensaje . $mensaje_guardado . "No se pudo coser el PDF, posible error al coser",
                                                        "response" => ""), JSON_UNESCAPED_UNICODE);
                        }
                    }
                    else
                    {
                        return json_encode(array("status" => 200,
                                                    "message" => $mensaje . $mensaje_guardado,
                                                    "response" => ""), JSON_UNESCAPED_UNICODE);
                    }
                }
        
                else
                {
                    return json_encode(array("status" => 200,
                                                "message" => $mensaje,
                                                "response" => ""), JSON_UNESCAPED_UNICODE);
                }
            }

            else
            {
                return json_encode(array("status" => 200,
                                        "message" => "No tiene Resoluciones en su poder",
                                        "response" => ""), JSON_UNESCAPED_UNICODE);
            }
        }

        else
        {
            return json_encode(array("status" => 200,
                                    "message" => "No tiene Resoluciones en su poder",
                                    "response" => ""), JSON_UNESCAPED_UNICODE);
        }
    }

    public function action_imprimir_proximos_todos( Request $request )
    {
        $response = $this->action_proximas_publicaciones( $request );


        if($response["status"] == "100")
        {
            if(count($response["response"]) > 0)
            {
                $mensaje = "";
                $mensaje_guardado = "";
                $array_url = array();
                $array_nombres = array();
                $array_rutas_local = array();
        
                $url_base = '/san/www/html/sicor_extendido/storage/app/porfirmar/';
        
                $url_descarga = "http://216.144.236.27:8080";

                foreach($response["response"] as $valor)
                {
                    $ruta = 'obtenerArchivo/' . $valor["id_acuerdo"] . '/' . $valor["id_organo"] . '/' . $valor["ultima_version"] . '/pdf';

                    $response = $request
                                    ->clienteWS
                                    ->request('get', $ruta,
                                    [
                                        "headers" => [
                                            "sesion-id" => $request->sesion_id,
                                            "cadena-sesion" => $request->cadena_sesion,
                                            "usuario-id" => $request->usuario_id
                                        ]
                                    ]);
        
                    $responseBody = json_decode($response->getBody(), true);
        
                    if($responseBody["status"] == "100")
                    {
                        array_push($array_url, $responseBody["response"]);
                        array_push($array_nombres, $valor["id_acuerdo"] . '.pdf');
                    }
        
                    else if($responseBody["status"] == "0")
                    {
                        $mensaje .= $responseBody["message"] . "\n";
                    }
        
                    else
                    {
                        $mensaje .= "Ocurrio un error" . "\n";
                    }
                }

                if(empty($mensaje) || count($array_url) > 0)
                {
                    $return = json_encode(array("status" => 100,
                                                "message" => $mensaje,
                                                "response" => $array_url), JSON_UNESCAPED_UNICODE);
        
                    foreach($array_url as $indice => $url)
                    {
                        $url_firma= $url_base . $array_nombres[$indice];
        
                        $source = file_get_contents($url);
                        file_put_contents($url_firma, $source);
        
                        if(file_exists($url_firma))
                        {
                            array_push($array_rutas_local, $url_firma);
                        }
        
                        else
                        {
                            $mensaje_guardado .= "No se pudo guardar el archivo " . $array_nombres[$indice] . "\n";
                        }
                    }
        
                    if(empty($mensaje_guardado) || count($array_rutas_local) > 0)
                    {
                        $response_coser = bandejas::documento_coser_pdf($array_rutas_local);
        
                        if(!empty($response_coser["file"]))
                        {
                            return json_encode(array("status" => 100,
                                                        "message" => $mensaje . $mensaje_guardado,
                                                        "response" => $url_descarga . $response_coser["file"]), JSON_UNESCAPED_UNICODE);
                        }
        
                        else
                        {
                            return json_encode(array("status" => 200,
                                                        "message" => $mensaje . $mensaje_guardado . "No se pudo coser el PDF, posible error al coser",
                                                        "response" => ""), JSON_UNESCAPED_UNICODE);
                        }
                    }
                    else
                    {
                        return json_encode(array("status" => 200,
                                                    "message" => $mensaje . $mensaje_guardado,
                                                    "response" => ""), JSON_UNESCAPED_UNICODE);
                    }
                }
        
                else
                {
                    return json_encode(array("status" => 200,
                                                "message" => $mensaje,
                                                "response" => ""), JSON_UNESCAPED_UNICODE);
                }
            }

            else
            {
                return json_encode(array(   "status" => 200,
                                            "message" => "No tiene Publicaciones para imprimir",
                                            "response" => 0), JSON_UNESCAPED_UNICODE);
            }
        }

        else
        {
            return $response;
        }
    }

    public function action_imprimir_seleccionados( Request $request )
    {
        $datos_sesion = json_decode($request->datos[0], true);
        $datos_acuerdos = json_decode($request->datos[1], true);

        if(count($datos_acuerdos) > 0)
        {
            $mensaje = "";
            $mensaje_guardado = "";
            $array_url = array();
            $array_nombres = array();
            $array_rutas_local = array();
    
            $url_base = '/san/www/html/sicor_extendido/storage/app/porfirmar/';
    
            $url_descarga = "http://216.144.236.27:8080";

            foreach($datos_acuerdos as $valor)
            {
                $ruta = 'obtenerArchivo/' . $valor["id_acuerdo"] . '/' . $valor["codigo_organo"] . '/' . $valor["ultima_version"] . '/pdf';
    
                $response = $request
                                ->clienteWS
                                ->request('get', $ruta,
                                [
                                    "headers" => [
                                        "sesion-id" => $datos_sesion["sesion_id"],
                                        "cadena-sesion" => $datos_sesion["cadena_sesion"],
                                        "usuario-id" => $datos_sesion["usuario_id"]
                                    ]
                                ]);
    
                $responseBody = json_decode($response->getBody(), true);
    
                if($responseBody["status"] == "100")
                {
                    array_push($array_url, $responseBody["response"]);
                    array_push($array_nombres, $valor["id_acuerdo"] . '.pdf');
                }
    
                else if($responseBody["status"] == "0")
                {
                    $mensaje .= $responseBody["message"] . "\n";
                }
    
                else
                {
                    $mensaje .= "Ocurrio un error" . "\n";
                }
            }
    
            if(empty($mensaje) || count($array_url) > 0)
            {
                $return = json_encode(array("status" => 100,
                                            "message" => $mensaje,
                                            "response" => $array_url), JSON_UNESCAPED_UNICODE);
    
                foreach($array_url as $indice => $url)
                {
                    $url_firma= $url_base . $array_nombres[$indice];
    
                    $source = file_get_contents($url);
                    file_put_contents($url_firma, $source);
    
                    if(file_exists($url_firma))
                    {
                        array_push($array_rutas_local, $url_firma);
                    }
    
                    else
                    {
                        $mensaje_guardado .= "No se pudo guardar el archivo " . $array_nombres[$indice] . "\n";
                    }
                }
    
                if(empty($mensaje_guardado) || count($array_rutas_local) > 0)
                {
                    $response_coser = bandejas::documento_coser_pdf($array_rutas_local);
    
                    if(!empty($response_coser["file"]))
                    {
                        $return = json_encode(array("status" => 100,
                                                    "message" => $mensaje . $mensaje_guardado,
                                                    "response" => $url_descarga . $response_coser["file"]), JSON_UNESCAPED_UNICODE);
                        return $return;
                    }
    
                    else
                    {
                        $return = json_encode(array("status" => 200,
                                                    "message" => $mensaje . $mensaje_guardado . "No se pudo coser el PDF, posible error al coser",
                                                    "response" => ""), JSON_UNESCAPED_UNICODE);
                        return $return; 
                    }
                }
                else
                {
                    $return = json_encode(array("status" => 200,
                                                "message" => $mensaje . $mensaje_guardado,
                                                "response" => ""), JSON_UNESCAPED_UNICODE);
                    return $return;    
                }
            }
    
            else
            {
                $return = json_encode(array("status" => 200,
                                            "message" => $mensaje,
                                            "response" => ""), JSON_UNESCAPED_UNICODE);
                return $return;
            }
        }

        else 
        {
            return json_encode(array("status" => 200,
                                    "message" => "No existen elementos seleccionados",
                                    "response" => ""), JSON_UNESCAPED_UNICODE);
        }
    }
}