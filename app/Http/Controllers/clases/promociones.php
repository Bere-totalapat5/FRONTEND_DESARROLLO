<?php
namespace App\Http\Controllers\clases;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class promociones{ 
 
    public static function guardar_promocion(Request $request, $datos){ 

        if(!isset($datos["tipo_recepcion"])){
            $datos["tipo_recepcion"]="";
        }
        if(!isset($datos["comentario"])){
            $datos["comentario"]="";
        }

        //se obtiene la lista de archivos
        $response = $request
        ->clienteWS 
        ->request('POST', 'demanprom_alta_registro',[
            "json" => [
                "datos" => [
                    "origen" =>$datos['origen'],
                    "id_documento" =>$datos['idDocumento'],
                    "juzgado_opc" => $datos['juzgado'],
                    "id_materia" => $datos['idMateria'],
                    "num_expediente" => $datos['noExpediente'],
                    "anio_expediente" => $datos['anioExpediente'],
                    "fecha_recepcion"=> $datos['fechaRecepcion'],
                    "fecha_registro" => date('Y-m-d H:i:s'),
                    "id_tipo_juicio"=> $datos['tipoJuicio'],
                    "id_expediente_opc"=> $datos['idExpediente'],
                    "tipo_documento"=> $datos['tipoDocumento'],
                    "id_gestor"=> $datos['idGestor'],
                    "partes"=> $datos['partes'],
                    "adjuntos"=> $datos['adjuntos'],
                    "juzgado_sicor"=> $datos['juzgado_sicor'],
                    "id_juicio" => $datos['id_juicio'],
                    "estatus_traslado" => $datos['estatus_traslado'],
                    "fecha_pago_traslado" => $datos['fecha_pago_traslado'],
                    "num_transaccion_traslado" => $datos['num_transaccion_traslado'],
                    "nombre_capturista" => $datos['opc_promocion_nombreCapturista'],
                    "email_capturista" => $datos['opc_promocion_emailCapturista'],
                    "tel_capturista" => $datos['opc_promocion_telefonoCapturista'],
                    "bandera_tramite_divorcio" => $datos['bandera_tramite_divorcio'],
                    "opc_promocion_bandera_mensaje" => $datos['opc_promocion_bandera_mensaje'],
                    "tipo_recepcion" => $datos["tipo_recepcion"],
                    "comentario" => $datos["comentario"]
                ]
            ],
            "headers" => [
                "Content-Type" => "application/json",
                "autorizacion" => "minutmanQAEtHReI"
            ]
        ]);
        
        $lista = json_decode($response->getBody(),true) ;
        return $lista;
    }

    public static function obtener_caratulas( Request $request, $datos ){

        $response = $request
        ->clienteWS
        ->request('GET', 'obtener_caratulas',[
            "query" => [
                "datos" => [
                    "expediente" => $datos['expediente'],
                    "expediente_anio" => $datos['expediente_anio'],
                    "id_promocion" => $datos['id_promocion'],
                    "origen" => $datos['origen'],
                    "juzgado" => $datos['juzgado'],
                    "fecha_menor" => $datos['fecha_menor'],
                    "fecha_mayor" => $datos['fecha_mayor'],
                    "fecha_simple" => $datos['fecha_simple'],
                    "sincronizados" => $datos['sincronizados']
                ],
                "paginacion" => [
                    "pagina" => $datos['pagina'],
                    "registros_por_pagina" => $datos['registros_por_pagina']
                ]
            ], 
            "headers" => [
                "autorizacion" => "minutmanQAEtHReI"
            ]
        ]);
        
        $lista = json_decode($response->getBody(),true) ;
        return $lista;
    }

    public static function obtener_caratulas_batch( Request $request, $datos ){

        $response = $request
        ->clienteWS
        ->request('POST', 'obtener_caratulas_batch',[
            "json" => [
                "datos" => [
                    "juicios" => $datos
                ]
            ], 
            "headers" => [
                "autorizacion" => "minutmanQAEtHReI"
            ]
        ]);
        
        $lista = json_decode($response->getBody(),true) ;
        return $lista;
    }

    public static function alta_adjunto_promocion(Request $request, $id_documento, $datos){
        $response = $request
        ->clienteWS
        ->request('POST', 'alta_adjunto_promocion/'.$id_documento,[
            "json" => [
                "datos" => $datos
            ],
            "headers" => [
                "Content-Type" => "application/json",
                "autorizacion" => "minutmanQAEtHReI"
            ]
        ]);
        
        $lista = json_decode($response->getBody(),true) ;
        return $lista;
    }

    public static function editar_promocion_asignacion(Request $request, $id_promocion, $id_juicio){
        $response = $request
        ->clienteWS
        ->request('PATCH', 'demanprom_modificar/'.$id_promocion,[
            "json" => [
                "datos" => [
                    "id_juicio" =>$id_juicio,
                    "juzgado_sicor" => $request->session()->get('usuario_juzgado')
                ]
            ],
            "headers" => [
                "Content-Type" => "application/json",
                "autorizacion" => "minutmanQAEtHReI"
            ]
        ]);
        
        $lista = json_decode($response->getBody(),true) ;
        return $lista;
    }

    public static function editar_promocion(Request $request, $id_promocion, $datos){
        $response = $request
        ->clienteWS
        ->request('PATCH', 'demanprom_modificar/'.$id_promocion,[
            "json" => [
                "datos" => [
                    "origen" =>$datos['origen'],
                    "id_documento" =>$datos['idDocumento'],
                    "juzgado_opc" => $datos['juzgado'],
                    "id_materia" => $datos['idMateria'],
                    "num_expediente" => $datos['noExpediente'],
                    "anio_expediente" => $datos['anioExpediente'],
                    "fecha_recepcion"=> $datos['fechaRecepcion'],
                    "fecha_registro" => date('Y-m-d H:i:s'),
                    "id_tipo_juicio"=> $datos['tipoJuicio'],
                    "id_expediente_opc"=> $datos['idExpediente'],
                    "tipo_documento"=> $datos['tipoDocumento'],
                    "id_gestor"=> $datos['idGestor'],
                    "partes"=> $datos['partes'],
                    "juzgado_sicor"=> $datos['juzgado_sicor'],
                    "estatus_traslado" => $datos['estatus_traslado'],
                    "fecha_pago_traslado" => $datos['fecha_pago_traslado'],
                    "num_transaccion_traslado" => $datos['num_transaccion_traslado'],
                    "nombre_capturista" => $datos['opc_promocion_nombreCapturista'],
                    "email_capturista" => $datos['opc_promocion_emailCapturista'],
                    "tel_capturista" => $datos['opc_promocion_telefonoCapturista'],
                    "bandera_tramite_divorcio" => $datos['bandera_tramite_divorcio']
                ]
            ],
            "headers" => [
                "Content-Type" => "application/json",
                "autorizacion" => "minutmanQAEtHReI"
            ]
        ]);
        
        $lista = json_decode($response->getBody(),true) ;
        return $lista;
    }

    public static function editar_promocion_min(Request $request, $id_promocion, $datos){

        
        $datos2 = array(
            "tipo_documento"=> $datos['tipoDocumento'],
            "opc_promocion_nombreCapturista"=> $datos['opc_promocion_nombreCapturista']
        ,
        "adjuntos"=> array (
                [
                    "data_json"=> $datos['json_file'] 
                ]
            )
        );

        $response = $request
        ->clienteWS
        ->request('PATCH', 'demanprom_modificar/'.$id_promocion,[
            "json" => [
                "datos" => $datos2
            ],
            "headers" => [
                "Content-Type" => "application/json",
                "autorizacion" => "minutmanQAEtHReI"
            ]
        ]);
        
        $lista = json_decode($response->getBody(),true) ;
        return $lista; 
    }

    public static function editar_promocion_metadatos(Request $request, $id_promocion, $datos){


        $datos2 = array(
            "tipo_documento"=> $datos['tipoDocumento'],
            "opc_promocion_metadata"=> $datos['opc_promocion_metadata'],
            "opc_promocion_nombreCapturista"=> $datos['opc_promocion_nombreCapturista']
        );


        $response = $request
        ->clienteWS
        ->request('PATCH', 'demanprom_modificar/'.$id_promocion,[
            "json" => [
                "datos" => $datos2
            ],
            "headers" => [
                "Content-Type" => "application/json",
                "autorizacion" => "minutmanQAEtHReI"
            ]
        ]);

        //$this->consultarPromociones($request, $id_juicio);
        
        
        $lista = json_decode($response->getBody(),true) ;
        return $lista; 
    }

    public static function editar_promocion_adjunto_visor(Request $request, $id_promocion, $id_ajunto, $status){

        $response = $request
        ->clienteWS
        ->request('PATCH', 'modificar_adjunto/'.$id_promocion.'/'.$id_ajunto,[
            "json" => [
                "datos" => [
                    "promocion_adjunto_visibilidad" =>$status
                ]
            ],
            "headers" => [
                "Content-Type" => "application/json",
                "autorizacion" => "minutmanQAEtHReI"
            ]
        ]);
        
        $lista = json_decode($response->getBody(),true) ;
        return $lista;

    }

    public static function eliminacion_promocion(Request $request, $id_promocion){

        $response = $request
        ->clienteWS
        ->request('DELETE', 'eliminacion_promocion/'.$id_promocion.'/eliminacion',[
            "json" => [
            ],
            "headers" => [
                "Content-Type" => "application/json",
                "autorizacion" => "minutmanQAEtHReI"
            ]
        ]);
        
        
        $lista = json_decode($response->getBody(),true) ;
        return $lista; 
    }

    public static function consultarPromociones(Request $request, $datos){
        if(!isset($datos['bandera_sigj_web'])){
            $datos['bandera_sigj_web']=0;
        }

        if(!isset($datos['pagina'])){
            $datos['pagina']=1;
            $datos['registros_por_pagina']=10;
        }

        if(!isset($datos['origen'])){
            $datos['origen']='-';
        }

        if(!isset($datos['tipo_documento'])){
            $datos['tipo_documento']='-';
        }

        $response = $request
        ->clienteWS
        ->request('GET', 'demanprom_consulta/',[
            "query" => [
                "datos" => [
                    "fecha" =>$datos['fecha'],
                    "tipo_documento" =>$datos['tipo_documento'],
                    "confirmados" => $datos['confirmados'],
                    "no_confirmados" => $datos['no_confirmados'],
                    "id_juicio" => $datos['id_juicio'], 
                    "juzgado_sicor" => $datos['juzgado_sicor'],
                    "bandera_sigj_web" => $datos['bandera_sigj_web'],
                    "origen" => $datos['origen']
                ],
                "paginacion" => [
                    "pagina" => $datos['pagina'],
                    "registros_por_pagina" => $datos['registros_por_pagina']
                ]
            ], 
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "autorizacion" => "minutmanQAEtHReI"
            ]
        ]);
        
        $lista = json_decode($response->getBody(),true) ;
        
        $lista['datos']['fecha']=$datos['fecha'];
        $lista['datos']['tipo_documento']=$datos['tipo_documento'];
        $lista['datos']['confirmados']=$datos['confirmados'];
        $lista['datos']['no_confirmados']=$datos['no_confirmados'];
        $lista['datos']['id_juicio']=$datos['id_juicio'];
        $lista['datos']['juzgado_sicor']=$datos['juzgado_sicor'];
        $lista['datos']['bandera_sigj_web']=$datos['bandera_sigj_web'];

        return $lista;
    }

    public static function consultarCaratulasPendientes(Request $request, $datos){
       
        if(!isset($datos['todos'])){
            $datos['todos']=0;
        }

        $response = $request
        ->clienteWS
        ->request('GET', 'obtener_promociones_scanner',[
            "query" => [
                "datos" => [
                    "fecha" =>$datos['fecha'],
                    "tipo_documento" =>$datos['tipo_documento'],
                    "confirmados" => $datos['confirmados'],
                    "no_confirmados" => $datos['no_confirmados'],
                    "id_juicio" => $datos['id_juicio'], 
                    "juzgado_sicor" => $datos['juzgado_sicor'],
                    "id_promocion" => $datos['id_promocion'],
                    "todos" => $datos['todos'],
                ]
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "autorizacion" => "minutmanQAEtHReI"
            ]
        ]);
        
        $lista = json_decode($response->getBody(),true) ;
        return $lista;
    }

    public static function eliminar_corelacion_acuerdos_demanprom(Request $request, $datos){
       
        $response = $request
        ->clienteWS
        ->request('DELETE', 'eliminar_corelacion_acuerdos_demanprom',[
            "query" => [
                "datos" => [
                    "juzgado" =>$datos['juzgado'],
                    "id_acuerdo" =>$datos['id_acuerdo'],
                    "id_opc_promocion" => $datos['id_opc_promocion'] 
                ]
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "autorizacion" => "minutmanQAEtHReI"
            ]
        ]);
        
        $lista = json_decode($response->getBody(),true) ;
        return $lista;
    }

    public static function corelacion_acuerdos_demanprom(Request $request, $datos){
       
        $response = $request
        ->clienteWS
        ->request('POST', 'corelacion_acuerdos_demanprom',[
            "query" => [
                "datos" => [
                    "juzgado" =>$datos['juzgado'],
                    "id_acuerdo" =>$datos['id_acuerdo'],
                    "id_opc_promocion" => $datos['id_opc_promocion'] 
                ]
            ], 
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "autorizacion" => "minutmanQAEtHReI"
            ]
        ]);
        
        $lista = json_decode($response->getBody(),true) ;
        return $lista;
    }

    public static function corelacion_acuerdos_demanprom_sinse(Request $request, $datos){
       
        $response = $request
        ->clienteWS
        ->request('POST', 'corelacion_acuerdos_demanprom',[
            "query" => [
                "datos" => [
                    "juzgado" =>$datos['juzgado'],
                    "id_acuerdo" =>$datos['id_acuerdo'],
                    "id_opc_promocion" => $datos['id_opc_promocion']
                ]
            ], 
            "headers" => [
                "autorizacion" => "minutmanQAEtHReI"
            ]
        ]);
        
        $lista = json_decode($response->getBody(),true) ;
        return $lista;
    }

    public static function enviar_promocion_xml( $body ){
        return 1;

        $base_uri="http://172.19.223.68:8081/sigjp/";

        $client= new Client;
        $response =  $client
        ->request('post', $base_uri.'registrar_promocion/',[
            "headers" => [
                "Content-Type" => "text/xml; charset=UTF8"
            ],
            "body"=>$body
        ]);

        return $response->getBody();

    }
    
}