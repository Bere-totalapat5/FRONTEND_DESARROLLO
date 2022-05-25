<?php

namespace App\Http\Controllers\leyendas;


use App\Http\Controllers\Controller;
use App\Http\Controllers\clases\catalogos;
use App\Http\Controllers\clases\export;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Session;

class LeyendasController_h extends Controller
{



    //PDF
     public function descargar_pdf_promocion( Request $request,$id_promocion ){


        $response = $request
        ->clienteWS_penal
        ->request('GET', 'consultar_pdf_promocion/'.$id_promocion,[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[]
            ]
        ]);
        $response = json_decode($response->getBody(),true);


        if(!isset($response['status'])){

            $url_local='/var/www/html/sigj_penal/storage/pdf_solicitudes/'.$id_promocion.'.pdf';

            $documento_pdf=$response[0]['url'];
            copy($documento_pdf, $url_local);

            return [
                "status"=>100,
                "response"=>"/pdf_solicitud/$id_promocion.pdf"
            ];
        }else{
            return $response;
        }
    }

    public function descargar_xml_promocion( Request $request,$id_solicitud){


        $response = $request
        ->clienteWS_penal
        ->request('GET', 'consultar_xml_promocion/'.$id_solicitud,[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[]
            ]
        ]); $response = json_decode($response->getBody(),true);

        if(!isset($response['status'])){

            $url_local='/var/www/html/sigj_penal/storage/xml_solicitudes/'.$id_solicitud.'.xml';

            $documento_xml=$response[0]['url'];
            copy($documento_xml, $url_local);

            return [
                "status"=>100,
                "response"=>"/xml_solicitud/$id_solicitud.xml"
            ];
        }else{
            return $response;
        }




    }


//VISTAS

public function consulta_leyendas(Request $request){



         $elementos=["entorno"=>$request->entorno,
                     "request"=>$request,
                     "sesion"=>Session::all(),
                     "menu_general"=>$request->menu_general,
                    /*  "solicitudes"=>$solicitudes */

                     ];
         return view('leyendas.consulta_leyendas', $elementos);

       }

       public function reenvio_carpetas(Request $request){

        $elementos=["entorno"=>$request->entorno,
                    "request"=>$request,
                    "sesion"=>Session::all(),
                    "menu_general"=>$request->menu_general,
                   /*  "solicitudes"=>$solicitudes */

                    ];
        return view('promociones.reenvio_carpetas', $elementos);

      }

      public function reenvio_carpeta(Request $request){


        $arr_unidades=catalogos::obtener_ugas($request, $request->unidades);

        $unidades=Arr::sort($arr_unidades, 'id_unidad_gestion');


        $elementos=["entorno"=>$request->entorno,
                    "request"=>$request,
                    "sesion"=>Session::all(),
                    "menu_general"=>$request->menu_general,
                   /*  "solicitudes"=>$solicitudes */
                   "unidades"=>$unidades,
                    ];
        return view('promociones.alta_remision', $elementos);

      }

      public function alta_promocion(Request $request){

        $arr_calidad_juridica=catalogos::calidad_juridica($request)['response'];
        $arr_tipos_audiencia=catalogos::tipos_audiencia($request)['response'];




        $calida_juridica=Arr::sort($arr_calidad_juridica, 'calidad_juridica');
        $tipos_audiencia=Arr::sort($arr_tipos_audiencia, 'tipo_audiencia');


        $elementos=["entorno"=>$request->entorno,
                    "request"=>$request,
                    "sesion"=>Session::all(),
                    "menu_general"=>$request->menu_general,
                   /*  "solicitudes"=>$solicitudes */
                   "calidad_juridica"=>$calida_juridica,
                   "tipos_audiencia"=>$tipos_audiencia
                    ];
        return view('promociones.alta_promocion', $elementos);

      }



public function obtener_leyendas( Request $request ){

    $response = $request
    ->clienteWS_penal
    ->request('POST', 'ver_leyenda_doc',[
        "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
        ],
        "json"=>[
            "datos"=>[
                "anio"=>$request->anio,

               /*  "folio_solicitud"=>$request->folio_solicitud,
                "folio_carpeta"=>$request->folio_carpeta,
                "carpeta_investigacion"=>$request->carpeta_investigacion, */


            ]/* , "paginacion"=>[
                "registros_por_pagina"=>$request->registros_por_pagina,
                "pagina"=>$request->pagina] */
        ]
    ]);
    $response = json_decode($response->getBody(),true) ;
    return $response;
}

public function guardar_nueva_leyenda( Request $request ){

    $response = $request
    ->clienteWS_penal
    ->request('POST', 'inserta_leyenda_doc',[
        "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
        ],
        "json"=>[
            "datos"=>[
                "anio"=>$request->anio,
                "leyenda"=>$request->leyenda,
                "id_usuario_sesion" => Session::get("usuario-id"),


            ]
        ]
    ]);
    $response = json_decode($response->getBody(),true) ;
    return $response;
}

public function guardar_cambios_leyenda( Request $request ){

    $response = $request
    ->clienteWS_penal
    ->request('POST', 'modifica_leyenda_doc',[
    "headers" => [
        "sesion-id" => $request->session()->get("sesion-id"),
        "cadena-sesion" => $request->session()->get("cadena-sesion"),
        "usuario-id" => $request->session()->get("usuario-id"),
        "Content-Type" => "application/json"
    ],
    "json"=>[
        "datos"=>[
            "anio"=>$request->anio,
            "leyenda"=>$request->leyenda,
            "estatus"=>$request->estatus,
            "id_usuario_sesion" => Session::get("usuario-id"),


        ]
    ]
]);
$response = json_decode($response->getBody(),true) ;
return $response;
}


    public function obtener_reenvios( Request $request ){


        /*  $response = $request
         ->clienteWS_penal
         ->request('GET', 'consultar_solicitudes',[
             "headers" => [
                 "sesion-id" => $request->session()->get("sesion-id"),
                 "cadena-sesion" => $request->session()->get("cadena-sesion"),
                 "usuario-id" => $request->session()->get("usuario-id"),
                 "Content-Type" => "application/json"
             ],
             "json"=>[
                 "datos"=>[
                     "id_solicitud"=>$request->id_solicitud,
                     "folio_solicitud"=>$request->folio_solicitud,
                     "folio_carpeta"=>$request->folio_carpeta,

                     "modo"=>$request->modo,
                     "tipo_solicitud"=>"PROMOCION",


                 ], "paginacion"=>[
                     "registros_por_pagina"=>$request->registros_por_pagina,
                     "pagina"=>$request->pagina]
             ]
         ]);
         $response = json_decode($response->getBody(),true) ; */

         $response = "yeah";
         return $response;
     }



     public function carpetas_asociadas( Request $request ){


        $response = $request
        ->clienteWS_penal
        ->request('POST', 'ver_carpetas_unidad',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[
                    // "modo"=>$request->modo,
                    "busqueda"=>$request->carpetaAsociada,

                ]
            ]
        ]);
        $response = json_decode($response->getBody(),true) ;
        return $response;
    }




    public function buscar_partes( Request $request ){


        $response = $request
        ->clienteWS_penal
        ->request('POST', 'consulta_partes_carpeta',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[
                    // "modo"=>$request->modo,
                    "id_calidad_juridica"=>$request->figura,
                    "folio_carpeta"=>$request->folio_carpeta,
                ]
            ]
        ]);
        $response = json_decode($response->getBody(),true) ;
        return $response;
    }





    public function registrar_promocion( Request $request ){


        $response = $request
        ->clienteWS_penal
        ->request('post', 'registrar_promocion_interface/'.Session::get('usuario_id'),[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[

                    "id_carpeta_judicial"=>$request->id_carpeta,
                    "folio_carpeta"=>$request->folio_carpeta,
                    "fecha_recepcion"=>$request->fecha_recepcion,
                    "hora_recepcion"=>$request->hora_recepcion,
                    "id_calidad_juridica"=>$request->id_calidad_juridica,
                    "id_persona"=>$request->id_persona,
                    "tipo_promocion"=>$request->tipo_promocion,
                    "nombres"=>$request->nombres,
                    "apellido_paterno"=>$request->apellido_paterno,
                    "apellido_materno"=>$request->apellido_materno,

                    "id_tipo_requerimiento"=>$request->id_tipo_requerimiento,
                    "tipo_requerimiento"=>$request->tipo_requerimiento,
                    "id_ta"=>$request->tipoAudiencia,
                    "resumen"=>$request->resumen,

                    "extension_doc"=>$request->extension_doc,
                    "tamanio_archivo_b64"=>$request->tamanio_archivo_b64,
                    "b64_doc"=>$request->b64_doc,
                    "personas"=>$request->personas,

                ]
            ]
        ]);
        $response = json_decode($response->getBody(),true) ;
        return $response;
    }



    public function editar_solicitud_promocion(Request $request){
        // return $request->id_solicitud;
        if(!$request->id_promocion) return redirect('home');


        $response=$this->obtener_datos_solicitud($request);

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
            $idiomas=catalogos::obtener_idiomas($request)['response'];

          //  $documento=archivos::obtener_pdf_solicitud($request, $request->id_solicitud);


            $elementos=["entorno"=>$request->entorno,
                        "request"=>$request,
                        "sesion"=>Session::all(),
                        "menu_general"=>$request->menu_general,
                        "tipos_audiencia"=>$tipos_audiencia,
                        "delitos"=>$arr_delitos,
                        "calidad_juridica"=>$calida_juridica,
                        "nacionalidades"=>$nacionalidades,
                        "estado_civil"=>$estado_civil,
                        "fiscalias"=>$fiscalias,
                        "calificativos"=>$calificativos,
                        "estados"=>$estados,
                        "unidades_investigacion"=>$unidades_investigacion,
                        "solicitud"=>$response['response'][0],//SOLICITUD
                       // "documento"=>$documento['response'],
                        "escolaridades"=>$escolaridades,
                        "ocupaciones"=>$ocupaciones,
                        "religiones"=>$religiones,
                        "grupos_etnicos"=>$grupos_etnicos,
                        "lenguas"=>$lenguas,
                        "poblaciones_lgbttti"=>$poblaciones_lgbttti,
                        "idiomas"=>$idiomas
                        ];

            return view('promociones.editar_solicitud_promocion', $elementos);
        }else{
            return redirect('home');
        }
    }

    public function obtener_datos_solicitud( Request $request){

        $tipo_solicitud=$request->tipo;

        $response = $request
        ->clienteWS_penal
        ->request('get', 'consultar_promociones',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[
                   // "modo"=>"completo",
                   "id_promocion"=>$request->id_promocion,

                   // "tipo_solicitud"=>$tipo_solicitud
                ]
            ]
        ]);
        $response = json_decode($response->getBody(),true) ;

        return $response;
    }




    public function enviar_promocion_editada(Request $request){

        // return $datos;
        $response = $request
        ->clienteWS_penal
        ->request('put', 'modificar_promocion/'.Session::get('usuario_id').'/'.$request->solicitud,[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[

                    "id_carpeta_judicial"=>$request->id_carpeta,
                    "folio_carpeta"=>$request->folio_carpeta,
                    "fecha_recepcion"=>$request->fecha_recepcion,
                    "hora_recepcion"=>$request->hora_recepcion,
                    "id_calidad_juridica"=>$request->id_calidad_juridica,
                    "id_persona"=>$request->id_persona,
                    "tipo_promocion"=>$request->tipo_promocion,
                    "nombres"=>$request->nombres,
                    "apellido_paterno"=>$request->apellido_paterno,
                    "apellido_materno"=>$request->apellido_materno,

                    "id_tipo_requerimiento"=>$request->id_tipo_requerimiento,
                    "tipo_requerimiento"=>$request->tipo_requerimiento,
                    "id_ta"=>$request->tipoAudiencia,
                    "resumen"=>$request->resumen,

                    "extension_doc"=>$request->extension_doc,
                    "tamanio_archivo_b64"=>$request->tamanio_archivo_b64,
                    "b64_doc"=>$request->b64_doc,
                   // "personas"=>["personas"=>$request->personas]

                ]
            ]
        ]);
        $response = json_decode($response->getBody(),true) ;

        return $response;

    }

    public function ver_flujo_promocion(Request $request,$id_solicitud){


        $response = $request
        ->clienteWS_penal
        ->request('GET', 'consultar_flujo_promocion/'.$id_solicitud,[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json" => [
                "paginacion"=>[
                "registros_por_pagina"=>$request->registros_por_pagina,
                "pagina"=>$request->pagina]
                     ]
        ]);

        return $response = json_decode($response->getBody(),true);
      }


      public function ver_log_promocion(Request $request,$id_solicitud){

        $response = $request
        ->clienteWS_penal
        ->request('GET', 'consultar_log_promocion/'.$id_solicitud,[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json" => [
                "datos" => [],
                "status" => 100
            ]
        ]);
        $response = json_decode($response->getBody(),true);
        $b64 = $response['response']['b64'];
        $route = "/san/www/html/sigj_penal/public/archivo.log";
        if (file_exists($route)) {
          unlink($route);
         }
        $log = fopen($route,"a");
        fwrite(	$log, base64_decode($b64)."\n\n");
        fclose( $log );

        return $response;
      }



}
