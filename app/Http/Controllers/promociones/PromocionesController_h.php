<?php

namespace App\Http\Controllers\promociones;

use App\Http\Controllers\clases\configuracion;
use App\Http\Controllers\Controller;
use App\Http\Controllers\clases\catalogos;
use App\Http\Controllers\clases\export;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Session;

class PromocionesController_h extends Controller
{
    public function descargar_xml_promocion(Request $request, $id_solicitud)
    {
        $response = $request->clienteWS_penal->request('GET', 'consultar_xml_promocion/' . $id_solicitud, [
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json",
            ],
            "json" => [
                "datos" => [],
            ],
        ]);
        $response = json_decode($response->getBody(), true);

        if (!isset($response['status'])) {
            $url_local = '/san/www/html/front_penal_desarrollo/storage/xml_solicitudes/' . $id_solicitud . '.xml';

            $documento_xml = $response[0]['url'];
            copy($documento_xml, $url_local);

            return [
                "status" => 100,
                "response" => "/xml_solicitud/$id_solicitud.xml",
            ];
        } else {
            return $response;
        }
    }

    //VISTAS

    public function consulta_promociones(Request $request)
    {
        $permisos = configuracion::obtener_permisos_ventana( $request, $request->session()->get("usuario-id"), 25 );
        if( $permisos["status"] == 100 ){
            $permisos_tratados = [];
            foreach($permisos["response"] as $idx => $p){
                $permisos_tratados[ $p["id_vista_accion"] ] = $p["valor"];
            }
            $permisos = $permisos_tratados;
        }else $permisos = [];

        $elementos = [
            "entorno" => $request->entorno,
            "request" => $request,
            "sesion" => Session::all(),
            "menu_general" => $request->menu_general,
            "permisos"=>$permisos
        ];
        return view('promociones.consulta_promociones', $elementos);
    }

    public function consulta_aclaratorios(Request $request)
    {
        $arr_tipos_documento = catalogos::obtener_tipos_documentos($request);
        $tipos_documentos = Arr::sort($arr_tipos_documento, 'id_tipo_documento');

        $elementos = [
            "entorno" => $request->entorno,
            "request" => $request,
            "sesion" => Session::all(),
            "menu_general" => $request->menu_general,
            "tipos_documentos" => $tipos_documentos,
            /*  "solicitudes"=>$solicitudes */
        ];
        return view('promociones.consulta_aclaratorios', $elementos);
    }

    public function consulta_remisiones(Request $request)
    {
        $elementos = [
            "entorno" => $request->entorno,
            "request" => $request,
            "sesion" => Session::all(),
            "menu_general" => $request->menu_general,
            /*  "solicitudes"=>$solicitudes */
        ];
        return view('promociones.consulta_remisiones', $elementos);
    }

    public function reenvio_carpeta(Request $request)
    {
        $arr_unidades = catalogos::obtener_ugas($request, $request->unidades);
        $unidades = Arr::sort($arr_unidades, 'id_unidad_gestion');

        $elementos = [
            "entorno" => $request->entorno,
            "request" => $request,
            "sesion" => Session::all(),
            "menu_general" => $request->menu_general,
            /*  "solicitudes"=>$solicitudes */
            "unidades" => $unidades,
        ];
        return view('promociones.alta_remision', $elementos);
    }

    public function alta_promocion(Request $request)
    {
        //$arr_calidad_juridica = catalogos::calidad_juridica_promociones($request)['response'];
        $arr_calidad_juridica = catalogos::calidad_juridica($request)['response'];
        $arr_tipos_audiencia = catalogos::tipos_audiencia($request)['response'];

        $calida_juridica = Arr::sort($arr_calidad_juridica, 'calidad_juridica');
        $tipos_audiencia = Arr::sort($arr_tipos_audiencia, 'tipo_audiencia');

        $elementos = [
            "entorno" => $request->entorno,
            "request" => $request,
            "sesion" => Session::all(),
            "menu_general" => $request->menu_general,
            "calidad_juridica" => $calida_juridica,
            "tipos_audiencia" => $tipos_audiencia,
        ];
        return view('promociones.alta_promocion', $elementos);
    }

    //api
    public function obtener_promociones(Request $request)
    {
        $response = $request->clienteWS_penal->request('GET', 'consultar_promociones', [
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json",
            ],
            "json" => [
                "datos" => [
                    "id_promocion" => $request->id_promocion,
                    "folio_promocion" => $request->folio_promocion,
                    "folio_carpeta" => $request->folio_carpeta,
                    "estatus_semaforo" => $request->estatus_semaforo,
                    "fecha_desde" => $request->fecha_recepcion,
                    "fecha_hasta" => $request->fecha_recepcionh,
                    "estatus_flujo_actual" => $request->estatus_flujo_actual,
                    "cambio_estatus" => $request->cambio_estatus,
                    "id_usuario_sesion" => $request->usuario ?? $request->session()->get("usuario-id"),
                    "estatus_registro" => $request->estatus_registro,
                    "tipo_consulta" => "",
                ],
                "paginacion" => [
                    "registros_por_pagina" => $request->registros_por_pagina,
                    "pagina" => $request->pagina,
                ],
            ],
        ]);
        $response = json_decode($response->getBody(), true);
        return $response;
    }

    public function obtener_remisiones(Request $request)
    {
        $response = $request->clienteWS_penal->request('GET', 'consultar_remisiones', [
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json",
            ],
            "json" => [
                "datos" => [
                    "modo" => $request->modo,
                    "id_remision" => $request->id_remision,
                    "carpeta_judicial" => $request->carpeta_judicial,
                    "folio_carpeta_rem" => $request->folio_carpeta_remitida,
                    "tipo_remision" => $request->tipo_remision,
                    "fecha_registro_min" => $request->fecha_recepcion,
                    "fecha_registro_max" => $request->fecha_recepcionh,
                    "autorizacion" => $request->autorizacion,
                    "id_carpeta_judicial" => $request->id_carpeta_judicial,
                    "id_carpeta_judicial_rem" => $request->id_carpeta_judicial_remitida,
                    // "id_usuario_sesion"=>$request->session()->get("usuario-id"),
                ],
                "paginacion" => [
                    "registros_por_pagina" => $request->registros_por_pagina,
                    "pagina" => $request->pagina,
                ],
            ],
        ]);
        $response = json_decode($response->getBody(), true);
        return $response;
    }

    public function obtener_aclaratorios(Request $request)
    {
      $response = $request->clienteWS_penal->request('GET', 'consultar_promociones', [
          "headers" => [
              "sesion-id" => $request->session()->get("sesion-id"),
              "cadena-sesion" => $request->session()->get("cadena-sesion"),
              "usuario-id" => $request->session()->get("usuario-id"),
              "Content-Type" => "application/json",
          ],
          "json" => [
              "datos" => [
                  "id_promocion" => $request->id_promocion,
                  "folio_promocion" => $request->folio_promocion,
                  "folio_carpeta" => $request->folio_carpeta,
                  "estatus_semaforo" => $request->estatus_semaforo,
                  "fecha_desde" => $request->fecha_recepcion,
                  "fecha_hasta" => $request->fecha_recepcionh,
                  "estatus_flujo_actual" => $request->estatus_flujo_actual,
                  "cambio_estatus" => $request->cambio_estatus,
                  "id_usuario_sesion" => $request->session()->get("usuario-id"),
                  "tipo_consulta" => "ACLARATORIO",
              ],
              "paginacion" => [
                  "registros_por_pagina" => $request->registros_por_pagina,
                  "pagina" => $request->pagina,
              ],
          ],
      ]);
      $response = json_decode($response->getBody(), true);
      return $response;
    }

    public function carpetas_referidas(Request $request)
    {
        $response = $request->clienteWS_penal->request('POST', 'ver_carpetas_unidad', [
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json",
            ],
            "json" => [
                "datos" => [
                    "busqueda" => $request->carpetaAsociada
                ],
            ],
        ]);
        $response = json_decode($response->getBody(), true);
        return $response;
    }
    public function carpetas_asociadas(Request $request)
    {

        $response = $request->clienteWS_penal->request('POST', 'ver_carpetas_unidad', [
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json",
            ],
            "json" => [
                "datos" => [
                    "busqueda" => (string)$request->carpetaAsociada,
                    "id_unidad" => $request->session()->get("id_unidad_gestion")
                ],
            ],
        ]);
        $response = json_decode($response->getBody(), true);
        return $response;
    }

    public function buscar_partes(Request $request)
    {
        $response = $request->clienteWS_penal->request('POST', 'consulta_partes_carpeta', [
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json",
            ],
            "json" => [
                "datos" => [
                    // "modo"=>$request->modo,
                    "id_calidad_juridica" => $request->figura,
                    "id_carpeta_judicial" => $request->id_carpeta_judicial,
                ],
            ],
        ]);
        $response = json_decode($response->getBody(), true);
        return $response;
    }
    public function registrar_promocion(Request $request)
    {


        $response = $request->clienteWS_penal->request('post', 'registrar_promocion_interface/' . Session::get('usuario_id'), [
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json",
            ],
            "json" => [
                "datos" => [
                    "id_carpeta_judicial" => $request->id_carpeta,
                    "folio_carpeta" => $request->folio_carpeta,
                    "fecha_recepcion" => $request->fecha_recepcion,
                    "hora_recepcion" => $request->hora_recepcion,
                    "id_calidad_juridica" => $request->id_calidad_juridica,
                    "id_persona" => $request->id_persona,
                    "tipo_promocion" => $request->tipo_promocion,
                    "nombres" => $request->nombres,
                    "apellido_paterno" => $request->apellido_paterno,
                    "apellido_materno" => $request->apellido_materno,

                    "id_tipo_requerimiento" => $request->id_tipo_requerimiento,
                    "tipo_requerimiento" => $request->tipo_requerimiento,
                    "id_ta" => $request->tipoAudiencia,
                    "resumen" => $request->resumen,

                    "nombre_documento" => $request->nombre_documento,
                    "extension_doc" => $request->extension_doc,
                    "tamanio_archivo_b64" => $request->tamanio_archivo_b64,
                    "b64_doc" => $request->b64_doc,
                    "personas" => $request->personas,
                    "id_usuario_sesion" => $request->session()->get("usuario-id"),
                    "estatus_registro" => $request->estatus_registro
                ],
            ],
        ]);

        $response = json_decode($response->getBody(), true);
        return $response;
    }

    public function editar_solicitud_promocion(Request $request,$id_promocion)
    {
        if (!$id_promocion) {
            return redirect('home');
        }

        $response = $this->obtener_datos_promocion($request,$id_promocion);


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

            $tipos_audiencia = Arr::sort($arr_tipos_audiencia, 'tipo_audiencia');
            $calida_juridica = Arr::sort($arr_calidad_juridica, 'calidad_juridica');

            $documento = $this->descargar_pdf_promocion($request, $id_promocion);

            $documento_adjunto = "";

            if($documento['status'] == 100){
              $documento_adjunto = $documento['response'];
            }
            //dd($documento_adjunto);

            $elementos = [
                "entorno" => $request->entorno,
                "request" => $request,
                "sesion" => Session::all(),
                "menu_general" => $request->menu_general,
                "tipos_audiencia" => $tipos_audiencia,
                "calidad_juridica" => $calida_juridica,
                "solicitud" => $response['response'][0],
                "documento" => $documento_adjunto,
            ];

            return view('promociones.editar_solicitud_promocion', $elementos);

        } else {
            return redirect('home');
        }
    }

    public function obtener_datos_promocion(Request $request,$id_promocion)
    {
        $response = $request->clienteWS_penal->request('get', 'consultar_promociones', [
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json",
            ],
            "json" => [
                "datos" => [
                    "id_promocion" => $id_promocion,
                    "id_usuario_sesion" => $request->session()->get("usuario-id")
                ],
            ],
        ]);
        $response = json_decode($response->getBody(), true);

        return $response;
    }

    public function enviar_promocion_editada(Request $request)
    {

        $extension_doc = "-";
        $tamanio_archivo_b64 = "-";
        $b64_doc = "-";

        if( $request->bandera_actualizar_documento ){
            $extension_doc = $request->extension_doc;
            $tamanio_archivo_b64 = $request->tamanio_archivo_b64;
            $b64_doc = $request->b64_doc;
        }

        $response = $request->clienteWS_penal->request('put', 'modificar_promocion/' . Session::get('usuario_id') . '/' . $request->id_promocion, [
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json",
            ],
            "json" => [
                "datos" => [
                    "id_carpeta_judicial" => $request->id_carpeta,
                    "folio_carpeta" => $request->folio_carpeta,
                    "fecha_recepcion" => $request->fecha_recepcion,
                    "hora_recepcion" => $request->hora_recepcion,
                    "id_calidad_juridica" => $request->id_calidad_juridica,
                    "id_persona" => $request->id_persona,
                    "tipo_promocion" => $request->tipo_promocion,
                    "nombres" => $request->nombres,
                    "apellido_paterno" => $request->apellido_paterno,
                    "apellido_materno" => $request->apellido_materno,
                    "id_tipo_requerimiento" => $request->id_tipo_requerimiento,
                    "id_ta" => $request->tipoAudiencia,
                    "resumen" => $request->resumen,
                    "bandera_actualizar_documento" => $request->bandera_actualizar_documento,
                    "extension_doc" => $extension_doc,
                    "tamanio_archivo_b64" => $tamanio_archivo_b64,
                    "b64_doc" => $b64_doc,
                    "personas" => $request->personas,
                    "estatus_registro" => $request->estatus_registro

                ],
            ],
        ]);
        $response = json_decode($response->getBody(), true);

        return $response;
    }

    public function ver_flujo_promocion(Request $request, $id_solicitud)
    {
        $response = $request->clienteWS_penal->request('GET', 'consultar_flujo_promocion/' . $id_solicitud, [
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json",
            ],
            "json" => [
                "paginacion" => [
                    "registros_por_pagina" => $request->registros_por_pagina,
                    "pagina" => $request->pagina,
                ],
            ],
        ]);

        return $response = json_decode($response->getBody(), true);
    }

    public function ver_log_promocion(Request $request, $id_promocion)
    {
        $response = $request->clienteWS_penal->request('GET', 'consultar_log_promocion/' . $id_promocion, [
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json",
            ],
            "json" => [
                "datos" => [],
                "status" => 100,
            ],
        ]);
        $response = json_decode($response->getBody(), true);
        $b64 = $response['response']['b64'];
        $route = base_path()."/public/archivo.log";
        if (file_exists($route)) {
            unlink($route);
        }
        $log = fopen($route, "a");
        fwrite($log, base64_decode($b64) . "\n\n");
        fclose($log);

        return $response;
    }

    public function cambio_carpeta_promocion(Request $request)
    {
        $response = $request->clienteWS_penal->request('POST', 'cambio_carpeta_promocion', [
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json",
            ],
            "json" => [
                "datos" => [
                    "id_promocion" => $request->id_promocion,
                    "id_carpeta_judicial" => $request->id_carpeta_judicial,
                    "folio_carpeta" => "-",
                    "id_usuario_responsable" => $request->session()->get("usuario-id")
                ],
            ],
        ]);
        $response = json_decode($response->getBody(), true);
       
        return $response;
    }
    //PDF
    public function descargar_pdf_promocion(Request $request, $id_promocion)
    {
        $response = $request->clienteWS_penal->request('GET', 'consultar_pdf_promocion/' . $id_promocion, [
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json",
            ],
            "json" => [
                "datos" => [],
            ],
        ]);
        $response = json_decode($response->getBody(), true);

        if (!isset($response['status'])) {
            $files = glob( base_path().'/pdf_promocion/*'); //obtenemos todos los nombres de los ficheros
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                } //elimino ficheros
            }
            $url_local =  base_path().'/public/pdf_promocion/' . $id_promocion . '.pdf';

            $documento_pdf = $response[0]['url'];
            copy($documento_pdf, $url_local);

            return [
                "status" => 100,
                "response" => "/pdf_promocion/$id_promocion.pdf",
                "ruta_local" => $url_local,
            ];
        } else {
            return $response;
        }
    }

    public function descargar_docs_remisiones(Request $request, $id_remision)
    {
        $response = $request->clienteWS_penal->request('GET', 'consultar_documentos_remision/' . $id_remision, [
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json",
            ],
            "json" => [
                "datos" => [],
            ],
        ]);
        $response = json_decode($response->getBody(), true);
        return $response;
    }

    public function descargar_documento_remision(Request $request, $id_remision, $id_documento)
    {
        $response = $request->clienteWS_penal->request('GET', 'consultar_documentos_remision/' . $id_remision . '/' . $id_documento, [
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json",
            ],
            "json" => [
                "datos" => [],
            ],
        ]);
        $response = json_decode($response->getBody(), true);
        return $response;
    }

    public function exportar_busqueda_aclaratorios(Request $request)
    {
        $file = new export();
        //dd($this->obtener_solicitudes);
        $out = isset($request->out) ? $request->out : 'B64';

        $respuesta = $this->obtener_aclaratorios($request);

        if ($respuesta['status'] == 100) {
            $data = $respuesta['response'];
        } else {
            //return $respuesta;
            $data = [
                [
                    'folio_promocion' => 'Sin datos',
                    'fecha' => 'Sin datos',
                    'folio_carpeta' => 'Sin datos',
                    'tipo_promocion' => 'Sin datos',
                    'estatus_flujo_actual' => 'Sin datos',
                ],
            ];
        }

        $header = [];
        if (isset($request->orden_columnas) && !empty($request->orden_columnas)) {
            foreach ($request->orden_columnas as $c) {
                $header[$c['campo']] = $c['titulo'];
            }
        } else {
            $header = [
                'folio_promocion' => 'folio_promocion',
                'fecha' => 'fecha',
                'folio_carpeta' => 'folio_carpeta',
                'tipo_promocion' => 'tipo_promocion',
                'estatus_flujo_actual' => 'estatus_flujo_actual',
            ];
        }

        $file->set_tema('sigj_penal');
        $file->set_report_title('Consulta de Aclaratorios');
        $file->set_sheet_title('Hoja 1');
        $file->set_header($header);
        $file->set_data($data);
        $file->set_position_sheet('horizontal');
        return $file->get_file($request->extension, $out);
        //dd('llegaste');
    }
}
