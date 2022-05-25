<?php

namespace App\Http\Controllers\apelaciones;

use App\Http\Controllers\Controller;
use App\Http\Controllers\clases\catalogos;
use Illuminate\Http\Request;
use Session;

class ApelacionesController extends Controller
{
    public function index_apelacion( Request $request ) {

        $jueces = catalogos::obtener_jueces( $request, '' , [5] );
        $cat_calidad_juridica=catalogos::calidad_juridica($request)['response'];
        $estados = catalogos::estados($request);
        $nacionalidades = catalogos::nacionalidades($request);
        $actos_reclamacion = catalogos::obtener_actos_reclamacion($request);
        
        $elementos=["entorno"=>$request->entorno,
                    "request"=>$request,
                    "sesion"=>Session::all(),
                    "menu_general"=>$request->menu_general,
                    "jueces" => $jueces,
                    "cat_calidad_juridica" => $cat_calidad_juridica,
                    "estados" => $estados,
                    "nacionalidades" => $nacionalidades,
                    "actos_reclamacion" => $actos_reclamacion,
                    ];

        return view('apelaciones.index_apelaciones', $elementos);
    }

    public function enviar_apelacion( Request $request ) {
        

        $documentos = json_decode( $request->documento_apelacion, true );

        $arr_docs = [];

        foreach ($documentos as $doc ) {
            $arr_docs[] = [
                "nombre" => str_replace($doc["extension_archivo"],'',$doc["nombre_archivo"]),
                "tamanio" => $doc["tamanio_archivo"],
                "extension" => str_replace('.','',$doc["extension_archivo"]),
                "b64_doc" => base64_encode(file_get_contents($request->entorno['variables_entorno']['ruta_storage'].'app'.$doc['url']))
            ];
        }

        
        $datos = [
            "solicitud" => [
                "tipo_solicitud_" => "INICIAL_APEL",
                "id_unidad_registro" => Session::get('id_unidad_gestion'),
                "fecha_recepcion" => date('Y-m-d'),
                "hora_recepcion" => date('H:i:s'),
                "extension_doc" => "-",
                "b64_doc" => "-"
            ],
            "solicitud_apelacion" => [
                "id_carpeta_referida" => $request->id_carpeta_referida,
                "id_figura_juridica" => $request->figura_juridica,
                "id_persona_apelante" => $request->apelante,
                "resolucion_impugnada" => $request->resolucion_impugnada,
                "id_audiencia"=> $request->id_audiencia,
                "nombre_resolucion" => $request->nombre_resolucion,
                "fecha_emision" => date('Y-m-d H:i:s', strtotime($request->fecha_emision)), //
                "juez" => $request->juez, //
                "agravios_orales" => $request->agravios_orales,
                "no_oficio" => $request->oficio_DEGJ,
                "notificaciones_tribunal_alzada" => $request->senala_domicilio
            ],
            "personas" => [],
            "archivos_promujer" => $arr_docs
        ];
        
        $response = $request
        ->clienteWS_penal
        ->request('post', 'registrar_solicitud_apelacion_interface/'.Session::get('usuario_id'),[
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

    public function obtener_apelaciones( Request $request ) {

        
        $datos = [
            "id_unidad" => $request->id_unidad ?? Session::get('id_unidad_gestion'),
            "id_solicitud_amparo" => "",
            "tipo_amparo" => "",
            "categoria_aparo" => "",
            "fecha_min" => $request->fecha_min,
            "fecha_max" => $request->fecha_max,
        ];

        // return $datos;
        $response = $request
        ->clienteWS_penal
        ->request('get', 'obtener_solicitudes_apelacion',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>$datos,
                "paginacion" => [
                    "registros_por_pagina" => 10,
                    "pagina" => $request->pagina
                ]
            ]
        ]);

        $response = json_decode($response->getBody(),true) ;

        return $response;
    }
}
