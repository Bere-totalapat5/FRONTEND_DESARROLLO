<?php

namespace App\Http\Controllers\exhortos;


use App\Http\Controllers\Controller;
use App\Http\Controllers\clases\catalogos;
use App\Http\Controllers\clases\archivos;
use App\Http\Controllers\clases\export;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Session;
use App;

class ExhortosController_h extends Controller
{                           //VISTAS VISTAS VISTAS VISTAS

    public function ver_exhortos(Request $request)
    {

        $arr_unidades = catalogos::obtener_ugas($request, $request->unidades);

        $unidades = Arr::sort($arr_unidades, 'id_unidad_gestion');

        $elementos = [
            "entorno" => $request->entorno,
            "request" => $request,
            "sesion" => Session::all(),
            "menu_general" => $request->menu_general,
            "unidades" => $unidades,
            /*  "solicitudes"=>$solicitudes */

        ];
        return view('exhortos.consulta_exhortos', $elementos);
    }

    public function registro_exhortos(Request $request)
    {

        $arr_unidades = catalogos::obtener_ugas_exhorto($request, $request->unidades);
        $arr_delitos = catalogos::delitos($request)['response'];
        $arr_calidad_juridica = catalogos::calidad_juridica($request)['response'];
        $arr_nacionalidades = catalogos::nacionalidades($request)['response'];
        $arr_calificativos = catalogos::calificativos($request)['response'];


        $unidades = Arr::sort($arr_unidades, 'id_unidad_gestion');
        $delitos = Arr::sort($arr_delitos, 'delito');
        $calida_juridica = Arr::sort($arr_calidad_juridica, 'calidad_juridica');
        $nacionalidades = Arr::sort($arr_nacionalidades, 'nacionalidad');
        $estados = catalogos::estados($request)['response'];
        $calificativos = Arr::sort($arr_calificativos, 'calificativo');


        $estados = catalogos::estados($request)['response'];
        $elementos = [
            "entorno" => $request->entorno,
            "request" => $request,
            "sesion" => Session::all(),
            "menu_general" => $request->menu_general,
            "unidades" => $unidades,
            "estados" => $estados,
            "delitos" => $delitos,
            "calidad_juridica" => $calida_juridica,
            "nacionalidades" => $nacionalidades,
            "estados" => $estados,
            "calificativos" => $calificativos,

        ];
        return view('exhortos.alta_exhorto', $elementos);
    }


    //DATOS


    public function delitos(Request $request)
    {

        $arr_delitos = catalogos::delitos($request)['response'];
        $delitos = Arr::sort($arr_delitos, 'delito');

        $response = $delitos;


        return $response;
    }

    public function enviar_exhorto(Request $request)
    {

      
            $personas = [];
            $delitos = [];
            $contactos = [];
            $alias = [];

            if( isset( $request->sujetos_procesales ) ) {

                foreach ( $request->sujetos_procesales as $sujeto ) {

                    if (isset($sujeto['delitos'])) {
                        foreach ($sujeto['delitos'] as $delito) {
                            $delitos[] = [
                                "id_delito" => $delito['id_delito'],
                                "otro_delito" => $delito['otro_delito']
                            ];
                            
                        }
                    }
    
                    if (isset($sujeto['correos'])) {
                        foreach ($sujeto['correos'] as $correo) {
                            $datos_correo = [
                                "contacto" => $correo['correo'],
                                "tipo" => "correo electronico",
                                "extension" => ''
                            ];
                            array_push($contactos, $datos_correo);
                        }
                    }
    
                    if (isset($sujeto['telefonos'])) {
                        foreach ($sujeto['telefonos'] as $telefono) {
                            $datos_telefono = [
                                "contacto" => $telefono['numero'],
                                "tipo" => $telefono['tipo'],
                                "extension" => $telefono['extension']
                            ];
                            array_push($contactos, $datos_telefono);
                        }
                    }
                    
                    if (isset($sujeto['alias'])) {
                        foreach ($sujeto['alias'] as $alias_sujeto) {
                            $datos_alias = [
                                "descripcion" => $alias_sujeto['descripcion'],
                            ];
                            array_push($alias, $datos_alias);
                        }
                    }
    
                    if ($sujeto['fecha_nacimiento']) {
                        $fecha_n = explode("-", $sujeto['fecha_nacimiento']);
                        $fecha_nacimiento = "$fecha_n[2]-$fecha_n[1]-$fecha_n[0]";
                    } else {
                        $fecha_nacimiento = "-";
                    }
                    // return $alias;
    
                    $persona = [
                        "id_calidad_juridica" => $sujeto['tipo_parte'],
                        "tipo_defensor" => "-",
                        "tipo_persona" => $sujeto['tipo_persona'],
                        "es_mexicano" => $sujeto['tipo_parte'] == 'mexicana' ? 'si' : 'no',
                        "id_nacionalidad" => $sujeto['otra_nacionalidad'],
                        "otra_nacionalidad" => $sujeto['otra_nacionalidad'],
                        "nombre" => $sujeto['nombre'],
                        "apellido_paterno" => $sujeto['apellido_paterno'],
                        "apellido_materno" => $sujeto['apellido_materno'],
                        "genero" => $sujeto['genero'],
                        "edad" => $sujeto['edad'],
                        "fecha_nacimiento" => $fecha_nacimiento,
                        "id_tipo_identificacion" => '-',
                        "folio_identificacion" => '-',
                        "otra_identificacion" => '-',
                        "curp" => $sujeto['curp'],
                        "rfc_empresa" => $sujeto['rfc'],
                        "razon_social" => $sujeto['razon_social'],
                        "datos" => [
                            "id_nivel_escolaridad" => "-",
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
                            "poblacion_callejera" => "-"
                        ],
                        "direccion" => [
                            "id_municipio" => $sujeto['municipio'],
                            "municipio_importacion" => "-",
                            "entidad_federativa" => $sujeto['estado'],
                            "localidad" => $sujeto['localidad'],
                            "colonia" => $sujeto['colonia'],
                            "calle" => $sujeto['calle'],
                            "entre_calles" => $sujeto['entre_calle'],
                            "referencias" => $sujeto['otra_referencia'],
                            "codigo_postal" => $sujeto['codigo_postal'],
                            "no_exterior" => $sujeto['numero_exterior'],
                            "no_interior" => $sujeto['numero_exterior']
                        ],
                        "alias" => $alias,
                        "delitos" => $delitos,
    
                        "contactos" => $contactos,
    
                    ];
                    array_push($personas, $persona);
                }
            }
            
            $documentos = [];

            if( isset( $request->documentos ) ) {
                
                foreach( $request->documentos as $doc ) {

                    $documentos[] = [
                        "b64_doc" => base64_encode( file_get_contents( $request->entorno["variables_entorno"]["ruta_storage"].'app'.$doc["url_doc"] ) ),
                        "extension" => $doc["extension"],
                        "tamanio" => $doc["tamanio"],
                        "tipo_data" => $doc["tipo_data"],
                        "nombre" => $doc["nombre"],
                    ];

                }

            }
                // $documentos = $request->documentos;
            

            $datos = [
                "fecha_recepcion" => $request->fecha_recepcion,
                "hora_recepcion" => $request->hora_recepcion . ":00",
                "entidad_federativa" => $request->entidad_federativa,
                "juzgado_exhortante" => $request->juzgado_exhortante,
                "nombre_juez" => $request->nombre_juez,
                "expediente_origen" => $request->expediente_origen,
                "no_oficio" => $request->no_oficio,
                "medio_recepcion" => $request->medio_recepcion,
                "resumen" => $request->resumen,
                "delegacion" => $request->delegacion,
                "materia_destino" => $request->materia_destino,
                "tipo_unidad" => $request->tipo_unidad,
                "unidad_especifica" => $request->unidad_especifica,
                "tipo_delito" => $request->tipo_delito,
                "personas" => $personas,
                "archivos" => $documentos,
                "bandera_turnado" => $request->bandera_turnado,
            ];
           

            $response = $request
                ->clienteWS_penal
                ->request('post', 'registrar_exhorto/' . Session::get('usuario_id') . '/' . Session::get('usuario_id'), [
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
            $response = json_decode($response->getBody(), true);

            if( $response['status'] == 100 && $request->bandera_turnado == 1 ) {

                $unidad = catalogos::obtener_ugas_por_id($request, [$response['response_carpeta']['response']['id_unidad']] );
                $unidad_gestion = $unidad['response'][0]['nombre_unidad'];

                $id_acuse = $response['response']['id_acuse'];
                $fecha_asignacion = date('d-m-Y H:i:s' , strtotime($response['response_carpeta']['response']['fecha_asignacion']));

                $datos_exhorto = [
                    "id_acuse" => $id_acuse,
                    "folio" => $response['response']['folio'],
                    "folio_carpeta_judicial" => $response['response_carpeta']['response']['folio_carpeta'],
                    "unidad_gestion" => $unidad['response'][0]['nombre_unidad'],
                    "fecha_asignacion" => $fecha_asignacion
                ];

                $request->id_exhorto =  $response['response']['id_acuse'];

                $pdf_acuse = $this->obtener_acuse_exhorto( $request );
                
                $b64_pdf = base64_encode( file_get_contents($request->entorno['variables_entorno']['ruta_storage'].$pdf_acuse['response']) );
                
                $response_acuse = $request
                    ->clienteWS_penal
                    ->request('POST', 'guardar_acuse_exhorto/' . $id_acuse, [
                        "headers" => [
                            "sesion-id" => $request->session()->get("sesion-id"),
                            "cadena-sesion" => $request->session()->get("cadena-sesion"),
                            "usuario-id" => $request->session()->get("usuario-id"),
                            "Content-Type" => "application/json"
                        ],
                        "json" => [
                            "datos" => [
                                // "modo"=>$request->modo,
                                "b64_pdf" => $b64_pdf,
                            ]
                        ]
                    ]);

                $response_acuse = json_decode($response_acuse->getBody(), true);
        
                if( $response_acuse['status'] == 100 ) {
                    // $documento = '/temporales/'.md5(date('YmdHis').rand(0,9999)).'_'.date('H').'.pdf';
                    // $ruta_local = $request->entorno['variables_entorno']['ruta_storage'].'app/'.$documento;
                    // file_put_contents( $ruta_local, base64_decode($b64_pdf));
                    // link($ruta_local, base_path().'/public'.$documento);
                    $response['ruta_documento'] = $pdf_acuse['response'];
                }
                
                $response_acuse['url_pdf'] = $pdf_acuse['response'];
                $response_acuse['response'] = $response['response'];
                $response_acuse['nombre_unidad'] = $unidad_gestion;
                $response_acuse['response_carpeta'] = $response['response_carpeta'];
                $response_acuse['response_carpeta']['response']['fecha_asignacion'] = $fecha_asignacion;

                return $response_acuse;

            } else {
                return $response;
            }
        
    }


    public static function delegaciones(Request $request)
    {

        $response = $request
            ->clienteWS_penal
            ->request('post', 'ver_municipios', [
                "headers" => [
                    "sesion-id" => $request->session()->get("sesion-id"),
                    "cadena-sesion" => $request->session()->get("cadena-sesion"),
                    "usuario-id" => $request->session()->get("usuario-id"),
                    "Content-Type" => "application/json"
                ],
                "json" => [
                    "datos" => [
                        "cve_estado" => $request->estado,
                    ]
                ]
            ]);
        $municipios = json_decode($response->getBody(), true);

        return $municipios;
    }


    public function obtener_carpetas_judiciales_exhortos(Request $request)
    {
        
      
        $datos = [
            //   "modo"=>$request->modo,
            //    "id_unidad"=>Session::get('id_unidad_gestion'),
            "modo" => "completo",
            "tipo_solicitud" => "EXHORTO",
            "folio_solicitud" => $request->folio_solicitud,
            "folio_carpeta" => $request->folio_carpeta,
            "fecha_desde" => $request->fecha_recepcion,
            "fecha_hasta" => $request->fecha_recepcionh,
            "medio_recepcion" => $request->medio_recepcion,
            "id_unidad_gestion" => $request->unidad_asignada,
            "estatus_flujo_actual" => $request->estatus_flujo_actual,
            "estatus_color" => $request->estatus_color,
            "exhorto_entidad_federativa" => $request->exhorto_entidad_federativa,
            "exhorto_expediente_origen" => $request->exhorto_expediente_origen,
            "exhorto_num_folio" => $request->exhorto_num_folio,
            "id_solicitud" => $request->id_solicitud
        ];
        // return $datos;
        $paginacion = [
            "registros_por_pagina" => "10",
            "pagina" => $request->pagina
        ];

        $response = $request
            ->clienteWS_penal
            ->request('get', 'consultar_solicitudes', [
                "headers" => [
                    "sesion-id" => $request->session()->get("sesion-id"),
                    "cadena-sesion" => $request->session()->get("cadena-sesion"),
                    "usuario-id" => $request->session()->get("usuario-id"),
                    "Content-Type" => "application/json"
                ],
                "json" => [
                    "datos" => $datos,
                    "paginacion" => $paginacion
                ]
            ]);
        
        $response = json_decode($response->getBody(), true);

        $exhortos = [];

        if( $response['status'] == 100 ) {

            foreach( $response['response'] as $exhorto ) {
                // return  catalogos::estados( $request, $exhorto['exhorto_entidad_federativa'] );

                $estado = catalogos::estados( $request, $exhorto['exhorto_entidad_federativa'] );
                
                if( $estado['status'] == 100 ) 
                    $exhorto['estado_exhorto'] = $estado['response'][0]['estado'];    
                else
                    $exhorto['estado_exhorto'] = '-';

                $uga = catalogos::obtener_ugas_por_id($request, $exhorto['id_unidad_gestion'] );

                if( $uga['status'] == 100 )
                    $exhorto['nombre_unidad'] = $uga['response'][0]['nombre_unidad'];
                else
                    $exhorto['nombre_unidad'] = '-';

                $usuario = catalogos::consulta_usuario_id( $request, $exhorto['id_usuario'] );
                // return $usuario;
                try{

                    if( $usuario['status'] == 100 ) {

                        $datos_usuario = $usuario['response'][0];
    
                        $nombre_usuario = $datos_usuario['nombres'] ?? '';
                        $paterno_usuario = ' '.$datos_usuario['apellido_paterno'] ?? '';
                        $materno_usuario = ' '.$datos_usuario['apellido_materno'] ?? '';
                        $exhorto['responsable_registro'] = $nombre_usuario.$paterno_usuario.$materno_usuario;
                    } else {
                        $exhorto['responsable_registro'] = '';
                    }

                    $exhortos[] = $exhorto;

                }catch( \Exception $e){}
                    
                
            }

            $response['response'] = $exhortos;
        }

        return $response;
    }

    public function obtener_carpetas_judiciales_exhortos_completo(Request $request)
    {


        $datos = [

            "modo" => "completo",
            "tipo_solicitud" => "EXHORTO",
            "folio_solicitud" => $request->folio_solicitud,
            "id_solicitud" => $request->id_solicitud,
        ];

        $paginacion = [
            "registros_por_pagina" => "10",
            "pagina" => $request->pagina
        ];

        $response = $request
            ->clienteWS_penal
            ->request('get', 'consultar_solicitudes', [
                "headers" => [
                    "sesion-id" => $request->session()->get("sesion-id"),
                    "cadena-sesion" => $request->session()->get("cadena-sesion"),
                    "usuario-id" => $request->session()->get("usuario-id"),
                    "Content-Type" => "application/json"
                ],
                "json" => [
                    "datos" => $datos,
                    "paginacion" => $paginacion
                ]
            ]);
        $response = json_decode($response->getBody(), true);

        return $response;
    }



    public function guardar_acuse_exhorto(Request $request)
    {
        $solicitud = $request->id_solicitud;
        $b64_pdf = str_replace('data:application/pdf;base64,', '', $request->b64_pdf);

        $response = $request
            ->clienteWS_penal
            ->request('POST', 'guardar_acuse_exhorto/' . $solicitud, [
                "headers" => [
                    "sesion-id" => $request->session()->get("sesion-id"),
                    "cadena-sesion" => $request->session()->get("cadena-sesion"),
                    "usuario-id" => $request->session()->get("usuario-id"),
                    "Content-Type" => "application/json"
                ],
                "json" => [
                    "datos" => [
                        // "modo"=>$request->modo,
                        "b64_pdf" => $b64_pdf,
                    ]
                ]
            ]);
        $response = json_decode($response->getBody(), true);

        if( $response['status'] == 100 ) {
            $documento = '/temporales/'.md5(date('YmdHis').rand(0,9999)).'_'.date('H').'.pdf';
            $ruta_local = $request->entorno['variables_entorno']['ruta_storage'].'app/'.$documento;
            file_put_contents( $ruta_local, base64_decode($b64_pdf));
            link($ruta_local, base_path().'/public'.$documento);
            $response['ruta_documento'] = $documento;
        }
            

        return $response;
    }



    public function editar_solicitud_exhorto(Request $request)
    {
        
        Session::flash('id_exhorto', $request->id_exhorto);

        return redirect()->route('alta_exhorto');
        
        // return $request->id_solicitud;
        if (!$request->id_exhorto) return redirect('home');

        $response = $this->obtener_carpetas_judiciales_exhortos_completo($request);

        if ($response['status'] == 100) {
            $arr_tipos_audiencia = catalogos::tipos_audiencia($request)['response'];
            $arr_delitos = catalogos::delitos($request);
            $arr_calidad_juridica = catalogos::calidad_juridica($request)['response'];
            $arr_nacionalidades = catalogos::nacionalidades($request)['response'];
            $arr_estado_civil = catalogos::estado_civil($request)['response'];
            $arr_fiscalias = catalogos::fiscalias($request)['response'];
            $arr_calificativos = catalogos::calificativos($request)['response'];
            $arr_unidades_investigacion = catalogos::unidades_investigacion($request)['response'];
            $arr_ocupaciones = catalogos::obtener_ocupaciones($request)['response'];
            $arr_delegaciones = catalogos::delegacionesCDMX($request)['response'];

            //  delegacionesCDMX


            $tipos_audiencia = Arr::sort($arr_tipos_audiencia, 'tipo_audiencia');
            $calida_juridica = Arr::sort($arr_calidad_juridica, 'calidad_juridica');
            $nacionalidades = Arr::sort($arr_nacionalidades, 'nacionalidad');
            $estado_civil = Arr::sort($arr_estado_civil, 'estado_civil');
            $fiscalias = Arr::sort($arr_fiscalias, 'fiscalia');
            $unidades_investigacion = Arr::sort($arr_unidades_investigacion, 'unidad_investigacion');
            $estados = catalogos::estados($request);
            $escolaridades = catalogos::obtener_escolaridades($request)['response'];
            $calificativos = Arr::sort($arr_calificativos, 'calificativo');
            $ocupaciones = Arr::sort($arr_ocupaciones, 'nombre_ocupacion');
            $religiones = catalogos::obtener_religiones($request)['response'];
            $grupos_etnicos = catalogos::obtener_grupos_etnicos($request)['response'];
            $lenguas = catalogos::obtener_lenguas($request)['response'];
            $poblaciones_lgbttti = catalogos::obtener_poblaciones_lgbttti($request)['response'];
            $idiomas = catalogos::obtener_idiomas($request)['response'];
            $delegaciones = Arr::sort($arr_delegaciones, 'tipo_audiencia');

            /* $response=$this->obtener_datos_solicitud($request);

    if($response['status']==100){
        $arr_tipos_audiencia=catalogos::tipos_audiencia($request)['response'];
        $arr_delitos=catalogos::delitos($request);
        $arr_calidad_juridica=catalogos::calidad_juridica($request)['response'];
        $arr_nacionalidades=catalogos::nacionalidades($request)['response'];
        $arr_estado_civil=catalogos::estado_civil($request)['response'];
        $arr_fiscalias=catalogos::fiscalias($request)['response'];
        $arr_calificativos=catalogos::calificativos($request)['response'];
        $arr_unidades_investigacion=catalogos::unidades_investigacion($request)['response'];
        $arr_ocupaciones=catalogos::obtener_ocupaciones($request)['response'];


        $tipos_audiencia=Arr::sort($arr_tipos_audiencia, 'tipo_audiencia');
        $calida_juridica=Arr::sort($arr_calidad_juridica, 'calidad_juridica');
        $nacionalidades=Arr::sort($arr_nacionalidades, 'nacionalidad');
        $estado_civil=Arr::sort($arr_estado_civil, 'estado_civil');
        $fiscalias=Arr::sort($arr_fiscalias, 'fiscalia');
        $unidades_investigacion=Arr::sort($arr_unidades_investigacion, 'unidad_investigacion');
        $estados=catalogos::estados($request);
        $escolaridades=catalogos::obtener_escolaridades($request)['response'];
        $calificativos=Arr::sort($arr_calificativos, 'calificativo');
        $ocupaciones=Arr::sort($arr_ocupaciones, 'nombre_ocupacion');
        $religiones=catalogos::obtener_religiones($request)['response'];
        $grupos_etnicos=catalogos::obtener_grupos_etnicos($request)['response'];
        $lenguas=catalogos::obtener_lenguas($request)['response'];
        $poblaciones_lgbttti=catalogos::obtener_poblaciones_lgbttti($request)['response'];
        $idiomas=catalogos::obtener_idiomas($request)['response']; */

            //  $documento=archivos::obtener_pdf_solicitud($request, $request->id_solicitud);


            $elementos = [
                "entorno" => $request->entorno,
                "request" => $request,
                "sesion" => Session::all(),
                "menu_general" => $request->menu_general,
                "tipos_audiencia" => $tipos_audiencia,
                "delitos" => $arr_delitos,
                "calidad_juridica" => $calida_juridica,
                "nacionalidades" => $nacionalidades,
                "estado_civil" => $estado_civil,
                "fiscalias" => $fiscalias,
                "calificativos" => $calificativos,
                "estados" => $estados,
                "unidades_investigacion" => $unidades_investigacion,
                "solicitud" => $response['response'][0], //SOLICITUD
                //  "documento"=>$documento['response'],
                "escolaridades" => $escolaridades,
                "ocupaciones" => $ocupaciones,
                "religiones" => $religiones,
                "delegaciones" => $delegaciones,
                "grupos_etnicos" => $grupos_etnicos,
                "lenguas" => $lenguas,
                "poblaciones_lgbttti" => $poblaciones_lgbttti,
                "idiomas" => $idiomas

            ];

            return view('exhortos.editar_exhorto', $elementos);
        } else {
            return redirect('home');
        }
    }

    public function obtener_datos_exhorto(Request $request)
    {

        $tipo_solicitud = $request->tipo;

        $response = $request
            ->clienteWS_penal
            ->request('get', 'consultar_promociones', [
                "headers" => [
                    "sesion-id" => $request->session()->get("sesion-id"),
                    "cadena-sesion" => $request->session()->get("cadena-sesion"),
                    "usuario-id" => $request->session()->get("usuario-id"),
                    "Content-Type" => "application/json"
                ],
                "json" => [
                    "datos" => [
                        // "modo"=>"completo",
                        "id_promocion" => $request->id_promocion,

                        // "tipo_solicitud"=>$tipo_solicitud
                    ]
                ]
            ]);
        $response = json_decode($response->getBody(), true);

        return $response;
    }


    public function exportar_busqueda_exhortos(Request $request)
    {
        $file = new export();
        //dd('llegaste');
        //dd($this->obtener_solicitudes);
        $out = isset($request->out) ? $request->out : 'B64';

        $respuesta = $this->obtener_carpetas_judiciales_exhortos($request);


        if ($respuesta['status'] == 100) {
            $data = $respuesta['response'];
        } else {
            //return $respuesta;
            $data = [[
                "id_solicitud" => "cSin datos",
                "folio_carpeta" => "Sin datos",
                "fecha_recepcion" => "Sin datos",
                "fecha_recepcion" => "Sin datos",
                "medio_recepcion" => "Sin datos",
                "unidad_asignada" => "Sin datos",
                "estatus_flujo" => "Sin datos",
                "estatus_color" => "Sin datos",
            ]];
        }

        $header = [];
        if (isset($request->orden_columnas) && !empty($request->orden_columnas)) {
            foreach ($request->orden_columnas as $c) {
                $header[$c['campo']] = $c['titulo'];
            }
        } else {
            $header = [
                "id_solicitud" => "id_solicitud",
                "folio_carpeta" => "folio_carpeta",
                "fecha_recepcion" => "fecha_recepcion",
                "fecha_recepcion" => "fecha_recepcionh",
                "exhorto_medio_recepcion" => "medio_recepcion",
                "id_unidad" => "id_unidad",
                "estatus_flujo_actual" => "estatus_flujo_actual",
                "estatus_flujo_actual" => "estatus_flujo_actual",
            ];
        }

        $file->set_tema('sigj_penal');
        $file->set_report_title('Exhortos');
        $file->set_sheet_title('Hoja 1');
        $file->set_header($header);
        $file->set_data($data);
        $file->set_position_sheet('horizontal');
        return $file->get_file($request->extension, $out);
    }




    public function descargar_pdf_exhorto(Request $request)
    {

        $version = 'todas';

        if( isset($request->version) )
            $version = $request->version;

        $response = $request
            ->clienteWS_penal
            ->request('GET', 'consultar_pdf_solicitud/' . $request->id_solicitud . '/' . $version, [
                "headers" => [
                    "sesion-id" => $request->session()->get("sesion-id"),
                    "cadena-sesion" => $request->session()->get("cadena-sesion"),
                    "usuario-id" => $request->session()->get("usuario-id"),
                    "Content-Type" => "application/json"
                ],
            ]);

        $response = json_decode($response->getBody(), true);

        if( $version == 'todas' )
            return $response;

        if ( !isset( $response['status'] ) ) {

            $nombre_documento = '/temporales/'.md5(date('YmdHis').rand(100,999)).'_'.date('H').'.pdf';
            $url_local = $request->entorno['variables_entorno']['ruta_storage'].'app/'.$nombre_documento;
            $documento = $response[0]['url'];
            copy($documento, $url_local);
            link($url_local, base_path().'/public'.$nombre_documento);

            return [ "status" => 100, "response" => $nombre_documento, "tamanio_archivo" => filesize($url_local), "extension" => "pdf" ];

        } else {

            return $response;

        }
    }

    public function obtener_acuse_exhorto( Request $request ) {
        
        $datos = [
            "modo" => "completo",
            "tipo_solicitud" => "EXHORTO",
            "id_solicitud" => $request->id_exhorto
        ];
        
        $paginacion = [
            "registros_por_pagina" => "10",
            "pagina" => 1
        ];

        $response = $request
            ->clienteWS_penal
            ->request('get', 'consultar_solicitudes', [
                "headers" => [
                    "sesion-id" => $request->session()->get("sesion-id"),
                    "cadena-sesion" => $request->session()->get("cadena-sesion"),
                    "usuario-id" => $request->session()->get("usuario-id"),
                    "Content-Type" => "application/json"
                ],
                "json" => [
                    "datos" => $datos,
                    "paginacion" => $paginacion
                ]
            ]);
        
        $response = json_decode($response->getBody(), true);

        if( $response['status'] == 100 ) {
            
            $datos = $response['response'][0];

            if( $datos['id_solicitud'] != $request->id_exhorto )
                return ['status' => 0, 'message' => 'Error al consultar datos del exhorto'];


            $unidad = catalogos::obtener_ugas_por_id($request, $datos['id_unidad'] );
            $unidad_gestion = $unidad['response'][0]['nombre_unidad'];

            $id_acuse = $datos['id_solicitud'];
            $fecha_asignacion = date('d-m-Y H:i:s' , strtotime($datos['fecha_asignacion']));

            $datos_exhorto = [
                "id_acuse" => $id_acuse,
                "folio" => $datos['folio_solicitud'],
                "folio_carpeta_judicial" => $datos['folio_carpeta'],
                "unidad_gestion" => $unidad_gestion,
                "fecha_asignacion" => $fecha_asignacion,
                "exhorto_nombre_juez" => $datos['exhorto_nombre_juez'],
                "exhorto_juzgado" =>$datos['exhorto_juzgado'],
                "estado" =>$datos['estado'],
                "exhorto_expediente_origen" => $datos['exhorto_expediente_origen'],
                "exhorto_num_folio" =>$datos['exhorto_num_folio']
            ];


            $pdf_acuse = archivos::genera_doc_exhorto( $request, $datos_exhorto );
            // $b64_pdf = base64_encode( file_get_contents($pdf_acuse['ruta_local']) );
            
            return ['status' => 100, 'response' => $pdf_acuse['ruta_publica']];
        }

        
        return $response;
    }
}
