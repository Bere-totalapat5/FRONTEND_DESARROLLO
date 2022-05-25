<?php

namespace App\Http\Controllers\amparos;

use App\Http\Controllers\Controller;
use App\Http\Controllers\clases\catalogos;
use Illuminate\Http\Request;
use Session;

class AmparosController extends Controller
{
    public function index_amparos( Request $request ) {

        $jueces = catalogos::obtener_jueces( $request, Session::get('id_unidad_gestion') , [5] );
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

        return view('amparos.index_amparos', $elementos);
    }

    public function enviar_amparo( Request $request ) {
        
        $documentos = json_decode( $request->documentos_amparo, true );
        $carpeta_referida = json_decode( $request->carpeta_referida, true );
        $jueces_referidos = json_decode( $request->jueces_referidos, true );
        $quejosos = json_decode( $request->quejosos, true );
        $actos_reclamados = json_decode( $request->actos_reclamados, true );

        $arr_quejosos = [];
        $arr_personas = [];
        $arr_documentos = [];

        foreach( $documentos as $documento ) {

            $arr_documentos[] = [
                "nombre" => str_replace($documento['extension_archivo'],'',$documento['nombre_archivo']),
                "tamanio" => $documento['tamanio_archivo'],
                "extension" => str_replace('.','',$documento['extension_archivo']),
                "b64_doc" => base64_encode(file_get_contents($request->entorno['variables_entorno']['ruta_storage'].'app'.$documento['url'])),
            ];
        }

        
        foreach ( $quejosos as $quejoso ) {
            if( $quejoso['id_quejoso'] != 0 ) {
                $arr_quejosos[] = [
                    'id_persona' => $quejoso['id_quejoso'],
                ];
            } else {

                $arr_alias = [];

                foreach( $quejoso['alias'] as $alias ) {
                    $arr_alias[] = [
                        "descripcion" => $alias['alias'],
                    ];
                }

                $arr_contactos = [];

                foreach( $quejoso['correo'] as $correo ) {
                    $arr_contactos[] = [
                        "contacto" => $correo['correo'],
                        "tipo" => "correo electronico",
                        "extension" => ""
                    ];
                }

                foreach( $quejoso['telefonos'] as $telefono ) {
                    $arr_contactos[] = [
                        "contacto" => $telefono['lada'].$telefono['numero'],
                        "tipo" => $telefono['tipo'],
                        "extension" => $telefono['extension'],
                    ];
                }
               
                $arr_personas[] = [
                    "id_calidad_juridica" => $quejoso['calidad_juridica'],
                    "tipo_defensor" => $quejoso['tipo_defensor'] ?? '-',
                    "tipo_persona" => $quejoso['tipo_persona'] ?? '-',
                    "es_mexicano" => $quejoso['nacionalidad'] == "mexicana" ? "si" : "no",
                    "id_nacionalidad" => $quejoso['otra_nacionalidad'] ?? '-',
                    "otra_nacionalidad" => "-",
                    "nombre" => $quejoso['nombres'] ?? '-',
                    "apellido_paterno" => $quejoso['apellido_parteno'] ?? '-',
                    "apellido_materno" => $quejoso['apellido_materno'] ?? '-',
                    "genero" => $quejoso['genero'] ?? '-',
                    "edad" => "-",
                    "fecha_nacimiento" => "-",
                    "id_tipo_identificacion" => "-",
                    "folio_identificacion" => "-",
                    "otra_identificacion" => "-",
                    "curp" => "-",
                    "rfc_empresa" => "-",
                    "cedula_profesional" => "-",
                    "datos" => [
                        "id_nivel_escolaridad"=> "-",
                        "id_lengua" => "-",
                        "id_religion" => "-",
                        "id_lgbttti" => "-",
                        "id_grupo_etnico" => "-",
                        "tipo_ocupacion" => "-",
                        "otra_escolaridad" => "-",
                        "otra_ocupacion" => "-",
                        "otra_religion" => "-",
                        "otro_grupo_etnico" => "-",
                        "otro_idioma_traductor" => "-",
                        "requiere_traductor" => "-",
                        "idioma_traductor" => "-",
                        "requiere_interprete" => "-",
                        "tipo_interprete" => "-",
                        "capacidades_diferentes" => "-",
                        "capacidad_diferente" => "-",
                        "poblacion" => "-",
                        "otra_poblacion" => "-",
                        "pertenece_grupo_etnico" => "-",
                        "entiende_idioma_espanol" => "-",
                        "descripcion_discapacidad" => "-",
                        "sabe_leer_escribir" => "-",
                        "poblacion_callejera" =>"-"
                    ],
                    "direccion" => [
                        "id_municipio" => $quejoso['id_municipio'] ?? '-',
                        "municipio_importacion" => $quejoso['municipio_importacion'] ?? '-',
                        "entidad_federativa" => $quejoso['entidad_federativa'] ?? '-',
                        "localidad" => $quejoso['localidad'] ?? '-',
                        "colonia" => $quejoso['colonia'] ?? '-',
                        "calle" => $quejoso['calle'] ?? '-',
                        "entre_calles" => $quejoso['entre_calles'] ?? '-',
                        "referencias" => $quejoso['referencias'] ?? '-',
                        "codigo_postal" => $quejoso['codigo_postal'] ?? '-',
                        "no_exterior" => $quejoso['no_exterior'] ?? '-',
                        "no_interior" => $quejoso['no_interior'] ?? '-',
                    ],
                    "alias" => $arr_alias,
                    "delitos" => [],
                    "contactos" => $arr_contactos 
                
                ];
            }
        }

        $datos = [
            "solicitud" => [
                "tipo_solicitud_" => "INICIAL_AMP",
                "id_unidad_registro" => Session::get('id_unidad_gestion'),
                "fecha_recepcion" => date("Y-m-d", strtotime($request->fecha_recepcion)),
                "hora_recepcion" => $request->hora_recepcion . ":00",
                "extension_doc" => $documento['extension_archivo'],
                "b64_doc" => base64_encode(file_get_contents($request->entorno['variables_entorno']['ruta_storage'].'app'.$documento['url'])),
                "carpeta_investigacion" => '',
                "nombre_archivo_b64" => str_replace($documento['extension_archivo'],'',$documento['nombre_archivo']),
                "tamanio_archivo_b64" => $documento['tamanio_archivo'],
            ],
            "solicitud_amparo" => [
                "id_carpeta_referida" => isset($carpeta_referida['id_carpeta_judicial']) ? $carpeta_referida['id_carpeta_judicial'] : '',
                "id_unidad" => Session::get('id_unidad_gestion'),
                "no_juicio_amparo" => $request->no_juicio_amparo,
                "no_oficio_federal" => $request->no_oficio,
                "tipo_amparo" => $request->tipo_amparo,
                "categoria_amparo" => $request->categoria_amparo,
                "entidad_federativa" => $request->entidad_federativa,
                "autoridad_control" => $request->autoridad_control,
                "tipo_promocion" => $request->tipo_audiencia,
                "especificacion" => $request->especificacion,
                "fundamento" => $request->fundamento,
                "termino_fecha" => $request->fecha_termino == null ? '' : date("Y-m-d", strtotime($request->fecha_termino)),
                "termino_hora" => $request->hora_termino,
                "plazo_dias" => $request->dias,
                "plazo_horas" => $request->horas,
                "comentarios" => $request->comentarios_adicionales,
            ],
            "jueces_referidos" => $jueces_referidos,
            "personas" => $arr_personas,
            "quejosos" => $arr_quejosos,
            "acto_reclamado" => $actos_reclamados,
            "archivos_promujer" => $arr_documentos,
        ];
        // return $datos;
        $response = $request
        ->clienteWS_penal
        ->request('post', 'registrar_solicitud_amparo_interface/'.Session::get('usuario_id'),[
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

    public function obtener_amparos( Request $request ) {


        $datos = [
           "id_unidad" => $request->id_unidad ?? (Session::get('id_unidad_gestion') == 0 ? '' : Session::get('id_unidad_gestion')),
            // "id_unidad" => '32',
            "id_solicitud_amparo" => "",
            "tipo_amparo" => $request->tipo_amparo ?? '-',
            "categoria_aparo" => $request->categoria_aparo ?? '-',
            "fecha_min" => $request->fecha_min ?? '-',
            "fecha_max" => $request->fecha_max ?? '-',
        ];

        // return $datos;
        $response = $request
        ->clienteWS_penal
        ->request('get', 'obtener_solicitudes_amparo',[
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

    public function cancelar_carpeta_amparo( Request $request ){
        $datos = [
            "id_solicitud" => $request->id_solicitud,
            "situacion" => $request->situacion,
         ];
 
         // return $datos;
         $response = $request
         ->clienteWS_penal
         ->request('post', 'cancelar_carpeta_amparo',[
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
}
