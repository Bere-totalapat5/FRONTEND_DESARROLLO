<?php

namespace App\Http\Controllers\promujer;

use App\Http\Controllers\clases\archivos;
use App\Http\Controllers\Controller;
use App\Http\Controllers\clases\export;
use App\Http\Controllers\clases\catalogos;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Session;


class promujerController extends Controller
{
    public function index ( Request $request ){

        return view('promujer.index',["entorno" => $request->entorno]);

    }

    public function exportar_busqueda_promujer(Request $request){
        $ruta_base_local = $request->entorno_privado["servidor_local"]["uri_local_proyecto"];

        $response = $request
        ->clienteWS_penal
        ->request('GET', 'exportar_busqueda_promujer',[
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
                    "fecha_solicitud_min" =>  is_null($request->fecha_recepcion_min) ? date('Y-m-d') : $request->fecha_recepcion_min,
                    "fecha_solicitud_max" => is_null($request->fecha_recepcion_max) ? date('Y-m-d') : $request->fecha_recepcion_max,
                    "modo"=>$request->modo,
                    "tipo_solicitud"=>"PRO-MUJER",
                    "color"=>$request->estatus_semaforo,

                ], "paginacion"=>[
                    "registros_por_pagina"=>$request->registros_por_pagina,
                    "pagina"=>$request->pagina]
            ]
        ]);
        $response = json_decode($response->getBody(),true) ;

        if($response['status'] == 0){
            return $response;
        }else{
      
            $files = glob($ruta_base_local.'public/xlsx/*'); //obtenemos todos los nombres de los ficheros
            foreach($files as $file){
                if(is_file($file))
                unlink($file); //elimino ficheros
            }
            $url_local=$ruta_base_local.'public/xlsx/'.$response['nombre'].'.xlsx';
      
            $documento_xlsx=$response['response'];
            copy($documento_xlsx, $url_local);
      
            return [
                "status"=>100,
                "response"=>"http://".$_SERVER['HTTP_HOST']."/xlsx/".$response['nombre'].".xlsx",
            ];
            // return $response;
        }
    }

    public function alta_solicitud ( Request $request ){

        //dd($request);

        $arr_tipos_audiencia=catalogos::tipos_audiencia($request)['response'];
        $arr_delitos=catalogos::delitos($request)['response'];
        $arr_calidad_juridica=catalogos::calidad_juridica($request)['response'];
        $arr_nacionalidades=catalogos::nacionalidades($request)['response'];
        $arr_estado_civil=catalogos::estado_civil($request)['response'];
        $arr_fiscalias=catalogos::fiscalias($request)['response'];
        $arr_calificativos=catalogos::calificativos($request)['response'];
        $arr_unidades_investigacion=catalogos::unidades_investigacion($request)['response'];

        $tipos_audiencia=Arr::sort($arr_tipos_audiencia, 'tipo_audiencia');
        $delitos=Arr::sort($arr_delitos, 'delito');
        $calida_juridica=Arr::sort($arr_calidad_juridica, 'calidad_juridica');
        $calidad_juridica_filtrada = [];
        foreach($calida_juridica as $cj){
            if (
                ($cj['id_calidad_juridica'] == 29) || //Abogado defensor
                ($cj['id_calidad_juridica'] == 46) || // Imputado
                ($cj['id_calidad_juridica'] == 3)  || // Testigo(s)
                ($cj['id_calidad_juridica'] == 33) || // Acompañante
                ($cj['id_calidad_juridica'] == 2)  || // Victima
                ($cj['id_calidad_juridica'] == 53)    // Acusado
             ){
                $calidad_juridica_filtrada[]=$cj;
             }

        }

        $nacionalidades=Arr::sort($arr_nacionalidades, 'nacionalidad');
        $estado_civil=Arr::sort($arr_estado_civil, 'estado_civil');
        $fiscalias=Arr::sort($arr_fiscalias, 'fiscalia');
        $unidades_investigacion=Arr::sort($arr_unidades_investigacion, 'unidad_investigacion');
        $estados=catalogos::estados($request)['response'];

        $calificativos=Arr::sort($arr_calificativos, 'calificativo');


        $elementos=["entorno"=>$request->entorno,
                    "request"=>$request,
                    "sesion"=>Session::all(),
                    "menu_general"=>$request->menu_general,
                    "tipos_audiencia"=>$tipos_audiencia,
                    "delitos"=>$delitos,
                    "calidad_juridica"=>$calidad_juridica_filtrada,
                    "nacionalidades"=>$nacionalidades,
                    "estado_civil"=>$estado_civil,
                    "fiscalias"=>$fiscalias,
                    "calificativos"=>$calificativos,
                    "estados"=>$estados,
                    "unidades_investigacion"=>$unidades_investigacion
                    ];

        return view('promujer.alta_solicitud', $elementos);

    }

    public function enviar_solicitud(Request $request){
        //dd($request['sujetos_procesales']);
        $solicitud = [
            "tipo_solicitud_"=>"PRO-MUJER",
            "fecha_recepcion"=>$request->fecha_recepcion,
            "hora_recepcion"=> $request->hora_recepcion ,
            "descripcion_hechos" => $request->relato_hechos,
            "materia_destino"=>"-",
            "estatus_urgente"=>"-",
            "estatus_delito_grave"=>"-",
            "carpeta_investigacion"=>"-",
            "fecha_fenece"=>"-",
            "id_tipo_solicitud_audiencia"=>"-",
            "id_audiencia"=>"-",
            "duracion_aproximada"=>"-",
            "estatus_telepresencia"=>"-",
            "estatus_area_resguardo"=>"-",
            "estatus_mod_testigo_protegido"=>"-",
            "estatus_mesa_evidencia"=>"-",
            "id_fiscalia"=>"-",
            "id_agencia"=>"-",
            "unidad_id_fis"=>"-",
            "cordinacion_territorial"=>"-",
            "correo_mp"=>"-",
            "curp_mp"=>"-",
            "mp_nombres"=>"-",
            "mp_apellido_paterno"=>"-",
            "mp_apellido_materno"=>"-",
            "extension_doc"=>"-",
            "b64_doc"=> "-"
        ];
        $personas=[];
        foreach($request['sujetos_procesales'] as $sujeto){
            $contactos=[];

            if(isset($sujeto['correos'])){
                foreach($sujeto['correos'] as $correo){
                    $datos_correo=[
                        "contacto"=>$correo['correo'],
                        "tipo"=>"correo electronico",
                        "extension"=>''
                    ];
                    array_push($contactos, $datos_correo);
                }
            }
            if(isset($sujeto['telefonos'])){
                foreach($sujeto['telefonos'] as $telefono){
                    $datos_telefono=[
                        "contacto"=>$telefono['numero'],
                        "tipo"=>$telefono['tipo'],
                        "extension"=>$telefono['extension']
                    ];
                    array_push($contactos, $datos_telefono);
                }
            }
            $alias=[];
            if(isset($sujeto['alias'])){
                foreach($sujeto['alias'] as $alias_sujeto){
                    $datos_alias=[
                        "descripcion"=>$alias_sujeto['descripcion'],
                    ];
                    array_push($alias, $datos_alias);
                }
            }

            if($sujeto['fecha_nacimiento']){
                $fecha_n=explode("-",$sujeto['fecha_nacimiento']);
                $fecha_nacimiento="$fecha_n[2]-$fecha_n[1]-$fecha_n[0]";
            }else{
                $fecha_nacimiento="-";
            }

            if( $sujeto['municipio'] ){
                $direccion_sujeto = [
                "id_municipio"=>$sujeto['municipio'],
                "municipio_importacion"=>"-",
                "entidad_federativa"=>$sujeto['estado'],
                "localidad"=>$sujeto['localidad'],
                "colonia"=>$sujeto['colonia'],
                "calle"=>$sujeto['calle'],
                "entre_calles"=>$sujeto['entre_calle'],
                //"y_calles"=>$sujeto['y_calle'],
                "referencias"=>$sujeto['otra_referencia'],
                "codigo_postal"=>$sujeto['codigo_postal'],
                "no_exterior"=>$sujeto['numero_exterior'],
                "no_interior"=>$sujeto['numero_interior']
                ];
            }else{
                $direccion_sujeto = [];
            }

            $persona=[
                "id_calidad_juridica"=>$sujeto['tipo_parte'],
                "tipo_defensor"=>"-",
                "tipo_persona"=>$sujeto['tipo_persona'],
                "es_mexicano"=>$sujeto['nacionalidad']=='mexicana'?'si':'no',
                "id_nacionalidad"=>$sujeto['otra_nacionalidad'],
                "otra_nacionalidad"=>$sujeto['otra_nacionalidad'],
                "nombre"=>$sujeto['nombre'],
                "apellido_paterno"=>$sujeto['apellido_paterno'],
                "apellido_materno"=>$sujeto['apellido_materno'],
                "genero"=>$sujeto['genero'],
                "edad"=>$sujeto['edad'],
                "fecha_nacimiento"=> $fecha_nacimiento,
                "id_tipo_identificacion"=>'-',
                "folio_identificacion"=>'-',
                "otra_identificacion"=>'-',
                "curp"=>$sujeto['curp'],
                "rfc_empresa"=>$sujeto['rfc'],
                "cedula_profesional"=>$sujeto['cedula_profesional'],
                "razon_social"=>$sujeto['razon_social'],
                "id_estado_civil"=>$sujeto['estado_civil'],
                "datos"=>[
                    "id_nivel_escolaridad"=>"9",
                    "id_lengua"=>"888",
                    "id_religion"=>"33",
                    "id_lgbttti"=>"0",
                    "id_grupo_etnico"=>"888",
                    "tipo_ocupacion"=>"0",
                    "otra_escolaridad"=>"-",
                    "otra_ocupacion"=>"-",
                    "otra_religion"=>"-",
                    "otro_grupo_etnico"=>"-",
                    "otro_idioma_traductor"=>"-",
                    "requiere_traductor"=>"no",
                    "idioma_traductor"=>"-",
                    "requiere_interprete"=>"no",
                    "tipo_interprete"=>"-",
                    "capacidades_diferentes"=>"no",
                    "capacidad_diferente"=>"-",
                    "poblacion"=>"no se",
                    "otra_poblacion"=>"-",
                    "pertenece_grupo_etnico"=>"no",
                    "entiende_idioma_espanol"=>"si",
                    "descripcion_discapacidad"=>"-",
                    "sabe_leer_escribir"=>"si",
                    "poblacion_callejera"=>"no"
                ],
                "direccion"=> $direccion_sujeto,
                "alias"=>$alias,
                "delitos"=>[],
                "contactos"=>$contactos,
            ];
            array_push($personas, $persona);

        }

        $archivos =[];
        foreach($request['documentos'] as $documento){
            $archivo = [
                "b64_doc" => $documento['b64'],
                "extension" => $documento['extension'],
                "nombre" => preg_replace('([^A-Za-z0-9-_-])', '', $documento['nombre_documento']),
                "tamanio" => $documento['tamanio'],
            ];
            array_push($archivos, $archivo);
        }
        //dd($archivos);
        $datos=[
            "solicitud"=>$solicitud,
            "personas"=>$personas,
            "archivos_promujer" => $archivos,
        ];
        //dd($datos);
        $response = $request
        ->clienteWS_penal
        ->request('post', 'registrar_solicitud_interface/'.Session::get('usuario_id'),[
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

    public function edita_solicitud ( Request $request, $id_solicitud ){

        $response = $request
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
                    "id_solicitud"=>$id_solicitud,
                    //"folio_solicitud"=>$request->folio_solicitud,
                    //"folio_carpeta"=>$request->folio_carpeta,
                    "modo"=>'completo',
                    "tipo_solicitud"=>"PRO-MUJER",
                ],
                "paginacion"=>[
                    "registros_por_pagina"=>10,
                    "pagina"=>1]
            ]
        ]);

        $response = json_decode($response->getBody(),true) ;
        //dd($response);
        if($response['status'] != 100){
            return 'false';
        }

        $solicitud = $response['response'][0];

        unset($response);

        $response = $request
        ->clienteWS_penal
        ->request('GET', 'consultar_pdf_solicitud/'.$id_solicitud.'/todas',[
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
        //dd($response);
        $documentos = $response;
        unset($response);
        //dd($documentos);
        //$documentos=[$documentos[1]];
        foreach($documentos as $index => $doc){
            $explode = explode('.', $doc['nombre_archivo']);
            $extension = $explode[ count($explode) -1 ];
            $tipo_data = '';
            if( $extension == 'pdf' || $extension == 'PDF' ) $tipo_data = 'data:application/pdf;base64,';
            if( $extension == 'jpg' || $extension == 'JPG' ) $tipo_data = 'data:image/jpeg;base64,';
            if( $extension == 'png' || $extension == 'PNG' ) $tipo_data = 'data:image/png;base64,';
            if( $extension == 'doc' || $extension == 'DOC' ) $tipo_data = '';
            if( $extension == 'docx' || $extension == 'DOCX' ) $tipo_data = '';

            $documentos[$index]['nombre_archivo'] = $explode[0];
            $documentos[$index]['extension'] = $extension;
            $documentos[$index]['tipo_data'] = $tipo_data;
            $documentos[$index]['estatus'] = 1;

            // $doc['b64']= base64_encode( file_get_contents( $doc['url']) );

            $response = $request
            ->clienteWS_penal
            ->request('GET', 'consultar_pdf_solicitud/'.$id_solicitud.'/'.$doc['id_version'],[
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
            //dd($response);
            $documentos[$index]['b64']= base64_encode( file_get_contents( $response[0]['url'] ) );

            unset($response);

            //dd($response);
        }

        //dd($solicitud,$documentos);

        $arr_calidad_juridica=catalogos::calidad_juridica($request)['response'];
        $arr_nacionalidades=catalogos::nacionalidades($request)['response'];
        $arr_estado_civil=catalogos::estado_civil($request)['response'];
        $arr_fiscalias=catalogos::fiscalias($request)['response'];
        $arr_calificativos=catalogos::calificativos($request)['response'];
        $arr_unidades_investigacion=catalogos::unidades_investigacion($request)['response'];
        $arr_ocupaciones=catalogos::obtener_ocupaciones($request)['response'];

        $calida_juridica=Arr::sort($arr_calidad_juridica, 'calidad_juridica');
        $nacionalidades=Arr::sort($arr_nacionalidades, 'nacionalidad');
        $estado_civil=Arr::sort($arr_estado_civil, 'estado_civil');
        $estados=catalogos::estados($request);
        $escolaridades=catalogos::obtener_escolaridades($request)['response'];
        $ocupaciones=Arr::sort($arr_ocupaciones, 'nombre_ocupacion');
        $religiones=catalogos::obtener_religiones($request)['response'];
        $grupos_etnicos=catalogos::obtener_grupos_etnicos($request)['response'];
        $lenguas=catalogos::obtener_lenguas($request)['response'];
        $poblaciones_lgbttti=catalogos::obtener_poblaciones_lgbttti($request)['response'];
        $idiomas=catalogos::obtener_idiomas($request)['response'];

        $calidad_juridica_filtrada = [];
        foreach($calida_juridica as $cj){
            if (
                ($cj['id_calidad_juridica'] == 29) || //Abogado defensor
                ($cj['id_calidad_juridica'] == 46) || // Imputado
                ($cj['id_calidad_juridica'] == 3)  || // Testigo(s)
                ($cj['id_calidad_juridica'] == 33) || // Acompañante
                ($cj['id_calidad_juridica'] == 2)  || // Victima
                ($cj['id_calidad_juridica'] == 53)    // Acusado
             ){
                $calidad_juridica_filtrada[]=$cj;
             }
        }

        $unidad_investigacion= explode('/',$solicitud['folio_carpeta'])[0];

        $nacionalidades=Arr::sort($arr_nacionalidades, 'nacionalidad');
        $estado_civil=Arr::sort($arr_estado_civil, 'estado_civil');
        $fiscalias=Arr::sort($arr_fiscalias, 'fiscalia');
        $unidades_investigacion=Arr::sort($arr_unidades_investigacion, 'unidad_investigacion');
        $estados=catalogos::estados($request)['response'];

        $calificativos=Arr::sort($arr_calificativos, 'calificativo');

        Session::put("horario_cierre","16:00:00");

        $elementos=["entorno"=>$request->entorno,
                    "request"=>$request,
                    "sesion"=>Session::all(),
                    "menu_general"=>$request->menu_general,
                    "solicitud"=>$solicitud,
                    "documentos"=>$documentos,
                    "calidad_juridica"=>$calidad_juridica_filtrada,
                    "nacionalidades"=>$nacionalidades,
                    "estado_civil"=>$estado_civil,
                    "estados"=>$estados,
                    "unidad_investigacion"=>$unidad_investigacion,
                    "escolaridades"=>$escolaridades,
                    "ocupaciones"=>$ocupaciones,
                    "religiones"=>$religiones,
                    "grupos_etnicos"=>$grupos_etnicos,
                    "lenguas"=>$lenguas,
                    "poblaciones_lgbttti"=>$poblaciones_lgbttti,
                    "idiomas"=>$idiomas,
                    "id_solicitud" => $id_solicitud,
                    ];

        //dd($elementos);
        return view('promujer.edita_solicitud', $elementos);
    }




    public function actualiza_solicitud(Request $request){
        //dd($request);
        $personas=[];
        foreach($request['sujetos_procesales'] as $sujeto){
            $contactos=[];

            if(isset($sujeto['correos'])){
                foreach($sujeto['correos'] as $correo){
                    $datos_correo=[
                        "id_contacto"=>isset($correo['id']) ? $correo['id'] : '-',
                        "estatus"=>$correo['estatus'],
                        "contacto"=>$correo['correo'],
                        "tipo_contacto"=>"correo electronico",
                        "extension"=>''
                    ];
                    array_push($contactos, $datos_correo);
                }
            }
            if(isset($sujeto['telefonos'])){
                foreach($sujeto['telefonos'] as $telefono){
                    $datos_telefono=[
                        "id_contacto"=>isset($telefono['id']) ? $telefono['id'] : '-',
                        "estatus"=>$telefono['estatus'],
                        "contacto"=>$telefono['numero'],
                        "tipo_contacto"=>$telefono['tipo'],
                        "extension"=>$telefono['extension']
                    ];
                    array_push($contactos, $datos_telefono);
                }
            }
            $alias=[];
            if(isset($sujeto['alias'])){
                foreach($sujeto['alias'] as $alias_sujeto){
                    $datos_alias=[
                        "id_alias"=> isset($alias_sujeto['id']) ? $alias_sujeto['id'] : '-',
                        "estatus"=>$alias_sujeto['estatus'],
                        "alias"=> isset($alias_sujeto['alias']) ? $alias_sujeto['alias'] : $alias_sujeto['descripcion'],
                    ];
                    array_push($alias, $datos_alias);
                }
            }

            if($sujeto['fecha_nacimiento']){
                $fecha_n=explode("-",$sujeto['fecha_nacimiento']);
                $fecha_nacimiento="$fecha_n[2]-$fecha_n[1]-$fecha_n[0]";
            }else{
                $fecha_nacimiento="-";
            }

            $info_principal=[
                "id_calidad_juridica"=>$sujeto['tipo_parte'],
                "tipo_defensor"=>"-",
                "tipo_persona"=>$sujeto['tipo_persona'],
                "es_mexicano"=>$sujeto['nacionalidad']=='mexicana'?'si':'no',
                "id_nacionalidad"=>$sujeto['otra_nacionalidad'],
                "otra_nacionalidad"=>$sujeto['otra_nacionalidad'],
                "nombre"=>$sujeto['nombre'],
                "apellido_paterno"=>$sujeto['apellido_paterno'],
                "apellido_materno"=>$sujeto['apellido_materno'],
                "genero"=>$sujeto['genero'],
                "edad"=>$sujeto['edad'],
                "fecha_nacimiento"=> $fecha_nacimiento,
                "id_tipo_identificacion"=>'-',
                "folio_identificacion"=>'-',
                "otra_identificacion"=>'-',
                "curp"=>$sujeto['curp'],
                "rfc_empresa"=>$sujeto['rfc'],
                "cedula_profesional"=>$sujeto['cedula_profesional'],
                "razon_social"=>$sujeto['razon_social'],
                "id_estado_civil"=>$sujeto['estado_civil'],
            ];

            $datos=[];

            $direcciones=[];
            if(isset($sujeto['direcciones'])){
                foreach($sujeto['direcciones'] as $direccion_sujeto){
                    $datos_direccion=[
                        "id_direccion"=>isset($direccion_sujeto['id'])?$direccion_sujeto['id']:'-',
                        "estatus"=>$direccion_sujeto['estatus'],
                        "id_municipio"=>$direccion_sujeto['municipio'],
                        "municipio_importacion"=>"-",
                        "entidad_federativa"=>$direccion_sujeto['estado'],
                        "localidad"=>$direccion_sujeto['localidad'],
                        "colonia"=>$direccion_sujeto['colonia'],
                        "calle"=>$direccion_sujeto['calle'],
                        "entre_calles"=>$direccion_sujeto['entre_calle'],
                        "referencias"=>$direccion_sujeto['otra_referencia'],
                        "codigo_postal"=>$direccion_sujeto['codigo_postal'],
                        "no_exterior"=>$direccion_sujeto['numero_exterior'],
                        "no_interior"=>$direccion_sujeto['numero_exterior']

                    ];
                    array_push($direcciones, $datos_direccion);
                }
            }

            if(isset($sujeto['datos'])){
                foreach($sujeto['datos'] as $datosS){
                    $datos_adicionales=[
                        "id_datos_persona"=> isset($datosS['id_datos_persona'])?$datosS['id_datos_persona']:'-',
                        "id_persona"=>isset($sujeto['id'])?$sujeto['id']:'-',
                        "id_nivel_escolaridad"=> $datosS['id_nivel_escolaridad'],
                        "id_lengua"=> $datosS['id_lengua'],
                        "id_religion"=> $datosS['id_religion'],
                        "id_lgbttti"=> $datosS['id_lgbttti'],
                        "id_grupo_etnico"=> $datosS['id_grupo_etnico'],
                        "tipo_ocupacion"=> $datosS['tipo_ocupacion'],
                        "otra_escolaridad"=> $datosS['otra_escolaridad'],
                        "otra_ocupacion"=> $datosS['otra_ocupacion'],
                        "otra_religion"=> $datosS['otra_religion'],
                        "otro_grupo_etnico"=> $datosS['otro_grupo_etnico'],
                        "otro_idioma_traductor"=> $datosS['otro_idioma_traductor'],
                        "requiere_traductor"=> $datosS['requiere_traductor'],
                        "idioma_traductor"=> $datosS['idioma_traductor'],
                        "requiere_interprete"=> $datosS['requiere_interprete'],
                        "tipo_interprete"=> $datosS['tipo_interprete'],
                        "capacidades_diferentes"=> $datosS['capacidades_diferentes'],
                        "capacidad_diferente"=> isset($datosS['capacidad_diferente'])?$datosS['capacidad_diferente']:'-',
                        "poblacion"=> $datosS['poblacion'],
                        "otra_poblacion"=> $datosS['otra_poblacion'],
                        "pertenece_grupo_etnico"=> $datosS['pertenece_grupo_etnico'],
                        "entiende_idioma_espanol"=> $datosS['entiende_idioma_espanol'],
                        "descripcion_discapacidad"=> $datosS['descripcion_discapacidad'],
                        "sabe_leer_escribir"=> $datosS['sabe_leer_escribir'],
                        "poblacion_callejera"=> $datosS['poblacion_callejera'],
                        "estatus"=> $datosS['estatus'],

                    ];
                    $datos=$datos_adicionales;
                }
            }

            $persona=[
                "id_persona"=>$sujeto['id']=='-'?'':$sujeto['id'],
                "estatus"=>$sujeto['id']=='-'?'':$sujeto['estatus'],
                "info_principal"=>$info_principal,
                "datos"=>$datos,
                "direcciones"=>$direcciones,
                "alias"=>$alias,
                "delitos"=>[],
                "contacto"=>$contactos,
            ];
            array_push($personas, $persona);

        }

        $archivos =[];
        foreach($request['documentos'] as $documento){
            $archivo = [
                "id_doc" => $documento['id'],
                "b64" => $documento['b64'],
                "extension" => $documento['extension'],
                "nombre" => preg_replace('([^A-Za-z0-9-_-])', '', $documento['nombre_documento']),
                "tamanio" => $documento['tamanio'],
                "estatus" => $documento['id'] == '-' ? '-' : $documento['estatus'],
            ];
            array_push($archivos, $archivo);
        }

        $solicitud = [
            "id_solicitud"=> $request->id_solicitud,
            "tipo_solicitud_"=>"PRO-MUJER",
            "fecha_recepcion"=>$request->fecha_recepcion,
            "hora_recepcion"=> $request->hora_recepcion ,
            "descripcion_hechos" => $request->relato_hechos,
            "materia_destino"=>"-",
            "estatus_urgente"=>"-",
            "estatus_delito_grave"=>"-",
            "carpeta_investigacion"=>"-",
            "fecha_fenece"=>"-",
            "id_tipo_solicitud_audiencia"=>"-",
            "id_audiencia"=>"-",
            "duracion_aproximada"=>"-",
            "estatus_telepresencia"=>"-",
            "estatus_area_resguardo"=>"-",
            "estatus_mod_testigo_protegido"=>"-",
            "estatus_mesa_evidencia"=>"-",
            "id_fiscalia"=>"-",
            "id_agencia"=>"-",
            "unidad_id_fis"=>"-",
            "cordinacion_territorial"=>"-",
            "correo_mp"=>"-",
            "curp_mp"=>"-",
            "mp_nombres"=>"-",
            "mp_apellido_paterno"=>"-",
            "mp_apellido_materno"=>"-",
            "extension_doc"=>"-",
            "b64_doc"=> "-",
            "personas"=>$personas,
            "delitos_no_relacionados"=>[],
        ];

        //dd($request['sujetos_procesales']);
        //dd($solicitud);

        $datos=[
            "datos_solicitud"=>$solicitud,
            "archivos_promujer" => $archivos,
        ];

        //dd($datos);

        $response = $request
        ->clienteWS_penal
        ->request('PUT', 'modificar_solicitud/'.Session::get('usuario_id').'/'.$request->id_solicitud,[
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



    public function consulta_promujer(Request $request){

        /*    $arr_solicitudes=catalogos::solicitudes($request);
           $solicitudes=Arr::sort($arr_solicitudes, 'solicitudes'); */
           $id_usuario = Session::get('usuario_id');
           $response = $request
           ->clienteWS_penal
           ->request('get', 'obtener_acciones_vista'."/".$id_usuario."/15",[
               "headers" => [
                   "sesion-id" => $request->session()->get("sesion-id"),
                   "cadena-sesion" => $request->session()->get("cadena-sesion"),
                   "usuario-id" => $request->session()->get("usuario-id"),
                   "Content-Type" => "application/json"
               ]

           ]);
           $acciones = json_decode($response->getBody(),true);
           $acciones = $acciones['response'];

           //dd($acciones);

         $elementos=["entorno"=>$request->entorno,
                     "request"=>$request,
                     "sesion"=>Session::all(),
                     "menu_general"=>$request->menu_general,
                     "acciones"=>$acciones,
                    /*  "solicitudes"=>$solicitudes */

                     ];
         return view('promujer.consulta_promujer', $elementos);

    }


    public function obtener_solicitudes_promujer( Request $request ){


        $response = $request
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
                    "fecha_solicitud_min" => $request->fecha_recepcion_min,
                    "fecha_solicitud_max" => $request->fecha_recepcion_max,
                    "id_unidad_gestion" => $request->id_unidad,
                   /*  "modo"=>$request->modo,
                    "id_solicitud"=>$request->id_solicitud,
                    "folio_solicitud"=>$request->folio_solicitud,
                    "folio_carpeta"=>$request->folio_carpeta,
                    "carpeta_investigacion"=>$request->carpeta_investigacion,
                    "fecha_solicitud_min"=>$request->fecha_recepcion,
                    "fecha_solicitud_max"=>$request->fecha_recepcionh,
                    "estatus_actual"=>$request->estatus_flujo_actual,
                    "estatus_urgente"=>$request->estatus_urgente,
                    "materia_destino"=>$request->materia_destino, */

                    "modo"=>$request->modo,
                    "tipo_solicitud"=>"PRO-MUJER",
                    "color"=>$request->estatus_semaforo,


                ], "paginacion"=>[
                    "registros_por_pagina"=>$request->registros_por_pagina,
                    "pagina"=>$request->pagina]
            ]
        ]);
        $response = json_decode($response->getBody(),true) ;
        return $response;
    }


     //PDF
    public function descargar_pdfs_promujer( Request $request,$id_solicitud,$id_version ){


        $response = $request
        ->clienteWS_penal
        ->request('GET', 'consultar_pdf_solicitud/'.$id_solicitud.'/'.$id_version,[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[]
            ]
        ]);$response = json_decode($response->getBody(),true);



        if(!isset($response['status'])){

            $files = glob( base_path(). '/public/pdf_solicitud/*'); //obtenemos todos los nombres de los ficheros
            foreach($files as $file){
                if(is_file($file))
                unlink($file); //elimino ficheros
            }
            $url_local= base_path(). '/public/pdf_solicitud/'.$id_solicitud.'.pdf';


            $documento_pdf=$response[0]['url'];
            copy($documento_pdf, $url_local);

            return [
                "status"=>100,
                "response"=>"/pdf_solicitud/$id_solicitud.pdf"
            ];
          }else{
              return $response;
          }
    }

    public function descargar_pdf( Request $request,$id_solicitud ){


        $response = $request
        ->clienteWS_penal
        ->request('GET', 'consultar_pdf_solicitud/'.$id_solicitud.'/todas',[
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
        return $response;

    }

    public function obtener_carpeta_judicial_sigjp_latis( Request $request){
        // se debe teenr la siguiente estructura
        if($request->entorno["variables_entorno"]["SIGJP_LATIS_ACTIVO"]==1){

            $base_uri = $request->entorno["variables_entorno"]["SIGJP_LATIS_DESARROLLO_BASE_URI"];
            $metodo = $request->entorno["variables_entorno"]["SIGJP_LATIS_DESARROLLO_METODO"];
            
            if( $request->entorno["variables_entorno"]["SIGJP_LATIS_PRODUCCION"]==1 ){
                $base_uri = $request->entorno["variables_entorno"]["SIGJP_LATIS_PRODUCCION_BASE_URI"];
                $metodo = $request->entorno["variables_entorno"]["SIGJP_LATIS_PRODUCCION_METODO"];
            }

            $xml_req = `
            <Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
                <Body>
                    <registrarSolicitudLAVLV xmlns="$base_uri/webServices">
                        <cadObj>
                        {
                        "relatoriaHechos":"Aqui va el relato de hechos",
                        "folioSolicitud":"00899/2021",
                        "idRegistroSolicitud":"1378",
                        "documentos":
                        [
                            {"idDocumento":"404","contenido":"b64","descripcion":"croquis","nombreArchivo":"nombre_original.pdf"}
                            {"idDocumento":"405","contenido":"b64","descripcion":"INE","nombreArchivo":"identificacon_ine.pdf"}
                        ],
                        "registradoPor":"Lucio Perez Rodriguez",
                        "adscripcionRegistrante":"CENTRO DE JUSTICIA PARA LA MUJER IZTAPALAPA",
                        "emailRegistrante":"cjmi@gamil.com",
                        "partes":
                        [
                            {
                            "idFiguraJuridica":"5",
                            "apellidoPaterno":"COSSIO",
                            "apellidoMaterno":"OLMEDO",
                            "genero":"0",
                            "curp":"",
                            "tipoPersona":"1",
                            "fechaNacimiento":"",
                            "estadoCivil":"",
                            "nombre":"ANTONIO",
                            "esMexicano":"1"
                            },
                            {"idFiguraJuridica":"4",
                            "apellidoPaterno":"AGUILAR",
                            "apellidoMaterno":"VELAZQUEZ",
                            "genero":"0",
                            "curp":"",
                            "tipoPersona":"1",
                            "fechaNacimiento":"",
                            "estadoCivil":"",
                            "nombre":"JUAN CARLOS",
                            "esMexicano":"1"
                            },
                            {"idFiguraJuridica":"2",
                            "apellidoPaterno":"AGUILAR",
                            "apellidoMaterno":"VELAZQUEZ",
                            "genero":"1",
                            "curp":"",
                            "tipoPersona":"1",
                            "fechaNacimiento":"",
                            "estadoCivil":"",
                            "nombre":"INOCENCIA JUANA",
                            "esMexicano":"1"
                            }
                        ]
                        }
                        </cadObj>
                    </registrarSolicitudLAVLV>
                </Body>
            </Envelope>
            `; 

            try{
                $client = new Client( ['base_uri' => $base_uri] );

                $usmeca = $client->request('POST',$metodo,
                    [
                        'body'=> $xml_req ,
                        'headers' => [
                            "Accept" => "*/*",
                            "Accept-Encoding" => "gzip, deflate",
                            "Accept-Language" => "es-US,es-MX;q=0.9,es-419;q=0.8,es;q=0.7",
                            "Connection" => "keep-alive",
                            "Content-Type" => "application/soap+xml; charset=UTF-8",
                            "Host" => "10.17.5.29:8080",
                            "SOAPAction" => "",
                        ]
                    ]
                );
                $xml_resp = $usmeca->getBody()->getContents();
                
            }catch( \Exception $e){
                return ['status'=> 0, 'response'=> ['mensaje' => 'Error con SIGJP LATIS  :'.$e->getMessage()] ];
            }

            dd($xml_resp);
        }

    }

}
