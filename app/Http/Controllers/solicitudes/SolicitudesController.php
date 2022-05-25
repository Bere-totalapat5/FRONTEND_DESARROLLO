<?php

namespace App\Http\Controllers\solicitudes;

use App\Http\Controllers\clases\configuracion;
use App\Http\Controllers\clases\archivos;
use App\Http\Controllers\Controller;
use App\Http\Controllers\clases\catalogos;
use App\Http\Controllers\clases\solicitudes;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Session;

class SolicitudesController extends Controller
{
    public function solicitud_audiencia_inicial(Request $request){

        $arr_tipos_audiencia=catalogos::tipos_audiencia( $request, 1 )['response'];
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
                    "calidad_juridica"=>$calida_juridica,
                    "nacionalidades"=>$nacionalidades,
                    "estado_civil"=>$estado_civil,
                    "fiscalias"=>$fiscalias,
                    "calificativos"=>$calificativos,
                    "estados"=>$estados,
                    "unidades_investigacion"=>$unidades_investigacion
                    ];

        return view('solicitudes.solicitud_audiencia_inicial', $elementos);
    }
    
    public function editar_solicitud_audiencia_inicial(Request $request){

        if(!$request->solicitud) return redirect('home');

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

            $documento=archivos::obtener_pdf_solicitud($request, $request->solicitud);

            if( $documento['status'] == 100 )
                $documento_ = $documento['response'];
            else 
                $documento_ = '';

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
                        "documento"=>$documento_,
                        "escolaridades"=>$escolaridades,
                        "ocupaciones"=>$ocupaciones,
                        "religiones"=>$religiones,
                        "grupos_etnicos"=>$grupos_etnicos,
                        "lenguas"=>$lenguas,
                        "poblaciones_lgbttti"=>$poblaciones_lgbttti,
                        "idiomas"=>$idiomas
                        ];

            return view('solicitudes.editar_solicitud_audiencia_inicial', $elementos);
        }else{
            return redirect('home');
        }
    }

    public function consulta_solicitudes(Request $request){

        $arr_solicitudes=catalogos::solicitudes($request);
        $solicitudes=Arr::sort($arr_solicitudes, 'solicitudes');
        $id_usuario = Session::get('usuario_id');

        $permisos = configuracion::obtener_permisos_ventana( $request, $request->session()->get("usuario-id"), 6 );
        if( $permisos["status"] == 100 ){
            $permisos_tratados = [];
            foreach($permisos["response"] as $idx => $p){
                $permisos_tratados[ $p["id_vista_accion"] ] = $p["valor"];
            }
            $permisos = $permisos_tratados;
        }else $permisos = [];


        $elementos=["entorno"=>$request->entorno,
                  "request"=>$request,
                  "sesion"=>Session::all(),
                  "menu_general"=>$request->menu_general,
                  "solicitudes"=>$solicitudes,
                  "permisos"=>$permisos

                  ];
      return view('solicitudes.consulta_solicitudes', $elementos);

    }

    public function enviar_solicitud(Request $request){
        // return $request->documento;
        $solicitud = [
            "tipo_solicitud_"=>"INICIAL",
            "fecha_recepcion"=>$request->fecha_recepcion,
            "hora_recepcion"=>$request->hora_recepcion.":00",
            "carpeta_investigacion"=>$request->numero_carpeta_investigacion,
            "id_audiencia"=>$request->tipo_audiencia,
            "duracion_aproximada"=>$request->duracion_aproximada,
            "estatus_urgente"=>$request->urgente,
            "estatus_telepresencia"=>$request->requiere_telepresencia,
            "estatus_area_resguardo"=>$request->requiere_resguardo,
            "estatus_mod_testigo_protegido"=>$request->requiere_testigoProtegido,
            "estatus_mesa_evidencia"=>$request->requiere_mesa,
            "estatus_delito_grave"=>$request->prision_oficiosa,
            "id_fiscalia"=>$request->fiscalia,
            "id_agencia"=>$request->agecia,
            "unidad_id_fis"=>$request->unidad_investigacion,
            "cordinacion_territorial"=>$request->coordinacion_territorial,
            "correo_mp"=>$request->correo_fiscal,
            "curp_mp"=>$request->curp_fical,
            "mp_nombres"=>$request->nombre_fiscal,
            "mp_apellido_paterno"=>$request->apellido_paterno_fiscal,
            "mp_apellido_materno"=>$request->apellido_materno_fiscal,
            "nombre_archivo_b64"=>$request->nombre_documento,
            "extension_doc"=>"pdf",
            "b64_doc" => base64_encode(file_get_contents($request->entorno['variables_entorno']['ruta_storage'].'app'.$request->documento['url_doc'])),
            "materia_destino"=>$request->materia_destino,
            "estatus_declaratoria" => $request->declaratoria
        ];

        $personas=[];

        foreach($request->sujetos_procesales as $sujeto){
            $delitos=[];
            if(isset($sujeto['delitos'])){
                foreach($sujeto['delitos'] as $delito){
                    $datos_delito=[
                        "id_delito"=>$delito['id_delito'],
                        "id_modalidad"=>$delito['id_modalidad'],
                        "id_calificativo"=>$delito['id_calificativo'],
                        "forma_comision"=>"forma",
                        "grado_realizacion"=>$delito['grado_realizacion'],
                        "delito_grave"=>$delito['delito_grave'],
                    ];
                    array_push($delitos, $datos_delito);
                }
            }
            $contactos=[];

            if(isset($sujeto['correos'])){
                foreach($sujeto['correos'] as $correo){
                    $datos_correo=[
                        "contacto" => $correo['correo'] == null ? "-" : $correo['correo'],
                        "tipo" => "correo electronico",
                        "extension"=>''
                    ];
                    array_push($contactos, $datos_correo);
                }
            }
            if(isset($sujeto['correos'])){
                foreach($sujeto['telefonos'] as $telefono){
                    $datos_telefono=[
                        "contacto" => $telefono['numero'] == null ? "-" : $telefono['numero'],
                        "tipo" => $telefono['tipo'],
                        "extension"=>$telefono['extension'] == null ? "-" : $telefono['extension']
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

            $persona=[
                "id_calidad_juridica"=>$sujeto['tipo_parte'],
                "tipo_defensor"=>"-",
                "tipo_persona"=>$sujeto['tipo_persona'],
                "es_mexicano"=>$sujeto['tipo_parte']=='mexicana'?'si':'no',
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
                "datos"=>[
                    "id_nivel_escolaridad"=>"-",
                    "id_lengua"=>"-",
                    "id_religion"=>"-",
                    "id_lgbttti"=>"-",
                    "id_grupo_etnico"=>"-",
                    "tipo_ocupacion"=>"-",
                    "otra_escolaridad"=>"-",
                    "otra_ocupacion"=>"-",
                    "otra_religion"=>"-",
                    "otro_grupo_etnico"=>"-",
                    "otro_idioma_traductor"=>"-",
                    "requiere_traductor"=>"-",
                    "idioma_traductor"=>"-",
                    "requiere_interprete"=>"-",
                    "tipo_interprete"=>"-",
                    "capacidades_diferentes"=>"-",
                    "capacidad_diferente"=>"-",
                    "poblacion"=>"-",
                    "otra_poblacion"=>"-",
                    "pertenece_grupo_etnico"=>"-",
                    "entiende_idioma_espanol"=>"-",
                    "descripcion_discapacidad"=>"-",
                    "sabe_leer_escribir"=>"-",
                    "poblacion_callejera"=>"-"
                ],
                "direccion"=>[
                    "id_municipio"=>$sujeto['municipio'],
                    "municipio_importacion"=>"-",
                    "entidad_federativa"=>$sujeto['estado'],
                    "localidad"=>$sujeto['localidad'],
                    "colonia"=>$sujeto['colonia'],
                    "calle"=>$sujeto['calle'],
                    "entre_calles"=>$sujeto['entre_calle'],
                    "referencias"=>$sujeto['otra_referencia'],
                    "codigo_postal"=>$sujeto['codigo_postal'],
                    "no_exterior"=>$sujeto['numero_exterior'],
                    "no_interior"=>$sujeto['numero_exterior']
                ],
                "alias"=>$alias,
                "delitos"=>$delitos,
                "contactos"=>$contactos,
            ];
            array_push($personas, $persona);
        }

        $datos=[
            "solicitud"=>$solicitud,
            "personas"=>$personas,
        ];

        // return $datos;
        $response = $request
        ->clienteWS_penal
        ->request('POST', 'registrar_solicitud_interface/'.Session::get('usuario_id'),[
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

    public function enviar_solicitud_editada(Request $request){

        $personas=[];
        $delitos_no_relacionados=[];

        if(isset($request->delitos_no_relacionados)){

            foreach($request->delitos_no_relacionados as $delito){

                $str_imputables='';
                if(isset($delito['id_imputable_a'])){
                    foreach($delito['id_imputable_a'] as $imputable){
                        $i=0;
                        if($i==0){
                            $str_imputables.=$imputable;
                        }else{
                            $str_imputables.=','.$imputable;
                        }
                    }
                }
                $datos_delito=[
                    "id_persona_delito"=>$delito['id'],
                    "id_solicitud"=>$request->solicitud,
                    "id_persona"=>$str_imputables,
                    "id_delito"=> $delito['id_delito'],
                    "id_modalidad"=>$delito['id_modalidad'],
                    "id_calificativo"=>$delito['id_calificativo'],
                    "forma_comision"=> "",
                    "grado_realizacion"=>$delito['grado_realizacion'],
                    "delito_grave"=>$delito['delito_grave'],
                ];
                array_push($delitos_no_relacionados, $datos_delito);
            }
        }


        foreach($request->sujetos_procesales as $sujeto){
            $delitos=[];

            if(isset($sujeto['delitos'])){
                foreach($sujeto['delitos'] as $delito){
                    $datos_delito=[
                        "id_delito_persona"=>$delito['id'],
                        "estatus"=>$delito['estatus'],
                        "id_delito"=>$delito['id_delito'],
                        "id_modalidad"=>$delito['id_modalidad'],
                        "id_calificativo"=>$delito['id_calificativo'],
                        "forma_comision"=>"forma",
                        "grado_realizacion"=>$delito['grado_realizacion'],
                        "delito_grave"=>$delito['delito_grave'],
                    ];
                    array_push($delitos, $datos_delito);
                }
            }

            $contactos=[];

            if(isset($sujeto['correos'])){
                foreach($sujeto['correos'] as $correo){
                    $datos_correo=[
                        "id_contacto"=>$correo['id'],
                        "estatus"=>$correo['estatus'],
                        "contacto"=>$correo['correo'],
                        "tipo_contacto"=>"correo electronico",
                        "extension"=>''
                    ];
                    array_push($contactos, $datos_correo);
                }
            }
            if(isset($sujeto['correos'])){
                foreach($sujeto['telefonos'] as $telefono){
                    $datos_telefono=[
                        "id_contacto"=>$telefono['id'],
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
                        "id_alias"=>$alias_sujeto['id'],
                        "estatus"=>$alias_sujeto['estatus'],
                        "alias"=>$alias_sujeto['alias'],
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
            // return $alias;

            $info_principal=[
                // "id_persona_fiscalia": null,
                // "id_persona_defensor": null,
                // "id_calidad_juridica": 1,
                "id_estado_civil"=>$sujeto['estado_civil'],
                // "id_tipo_identificacion": 1,
                "id_nacionalidad"=>$sujeto['otra_nacionalidad'],
                "tipo_persona"=>$sujeto['tipo_persona'],
                "nombre"=>$sujeto['nombre'],
                "apellido_paterno"=>$sujeto['apellido_paterno'],
                "apellido_materno"=>$sujeto['apellido_materno'],
                "genero"=>$sujeto['genero'],
                "edad"=>$sujeto['edad'],
                "fecha_nacimiento"=> $fecha_nacimiento,
                // "folio_identificacion": "123456",
                "otra_nacionalidad"=>$sujeto['otra_nacionalidad'],
                "es_mexicano"=>$sujeto['nacionalidad']=='mexicana'?'si':'no',
                "curp"=>$sujeto['curp'],
                "rfc_empresa"=>$sujeto['rfc'],
                // "requiere_defensoria": null,
                // "lugar_reclusorio": null,
                // "reclusorio_detencion": null,
                "cedula_profesional"=>$sujeto['cedula_profesional'],
                // "tipo_defensor": "publico",
                // "otro_lugar_retencion": null,
                // "otra_identificacion": null
            ];

            $datos=[];

            if(isset($sujeto['datos'])){
                foreach($sujeto['datos'] as $datosS){
                    $datos_adicionales=[
                        "id_datos_persona"=> $datosS['id_datos_persona'],
                        "id_persona"=>$sujeto['id'],
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
                        "capacidad_diferente"=> $datosS['capacidad_diferente'],
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

            $direcciones=[];
            if(isset($sujeto['direcciones'])){
                foreach($sujeto['direcciones'] as $direccion_sujeto){
                    $datos_direccion=[
                        "id_direccion"=>$direccion_sujeto['id'],
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

            $persona = [
                "id_persona"=>$sujeto['id']=='-'?'':$sujeto['id'],
                "estatus"=>$sujeto['id']=='-'?'':$sujeto['estatus'],
                "info_principal"=>$info_principal,
                "alias"=>$alias,
                "contacto"=>$contactos,
                "datos"=>$datos,
                "direcciones"=>$direcciones,
                "delitos"=>$delitos,
                "delitos_estadisticos" => []
            ];
            array_push($personas, $persona);
        }

        $solicitud=[
            "id_solicitud"=> $request->solicitud,
            "id_carpeta_judicial"=>$request->carpeta_judicial,
            "id_fiscalia"=>$request->fiscalia,
            "id_agencia"=>$request->agencia,
            "unidad_id_fis"=>$request->unidad_investigacion,
            "id_tipo_solicitud_audiencia"=>$request->tipo_audiencia,
            "id_audiencia"=>$request->tipo_audiencia,
            "estatus_flujo_actual"=>$request->estatus_flujo,
            "estatus_urgente"=>$request->urgente,
            "estatus_telepresencia"=>$request->requiere_telepresencia,
            "estatus_area_resguardo"=>$request->requiere_resguardo,
            "estatus_mod_testigo_protegido"=>$request->requiere_testigoProtegido,
            "estatus_mesa_evidencia"=>$request->requiere_mesa,
            // "estatus_declaratoria": "si",
            // "estatus_detenido": "no",
            "estatus_delito_grave"=>$request->prision_oficiosa,
            "materia_destino"=>$request->materia_destino,
            // "fecha_solicitud": "-",
            // "folio_solicitud_audiencia": null,
            "fecha_recepcion"=>$request->fecha_recepcion,
            "hora_recepcion"=>$request->hora_recepcion.":00",
            "duracion_aproximada"=>$request->duracion_aproximada,
            // "ctrl_solicitud": "0601040000000048201904",
            // "solicitud_id_fis": "3",
            // "cve_solicitud": "135",
            // "ctrl_uinv": "9223372036854775807",
            "carpeta_investigacion"=>$request->numero_carpeta_investigacion,
            "mp_solicitante"=>$request->nombre_fiscal,
            "correo_mp"=>$request->correo_fiscal,
            "curp_mp"=>$request->curp_fical,
            "cordinacion_territorial"=>$request->coordinacion_territorial,
            // "cve_coortermp": "AO-1",
            // "fecha_fenece": "2020-01-01",
            "personas"=>$personas,
            "archivo_b64"=>$request->documento,
            "delitos_no_relacionados"=>$delitos_no_relacionados,
            
        ];

        $datos=[
            "datos_solicitud"=>$solicitud,
        ];
        // return $datos;
        $response = $request
        ->clienteWS_penal
        ->request('put', 'modificar_solicitud/'.Session::get('usuario_id').'/'.$request->solicitud,[
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

    public function enviar_solicitud_xml(Request $request){
       
        $solicitud = solicitudes::enviar_solicitud_xml($request->getContent());

        return $solicitud;
    }

    public function enviar_promocion_xml(Request $request){

        $promocion = promociones::enviar_promocion_xml($request->getContent());

        return $promocion;

    }

    public function prueba2(Request $request){

        $datos = [
            "ctrlSolicitud" => "1111",
            "idSolicitud" => "111"
          ];
        //   return $datos;
        $solicitud = solicitudes::obtener_audiencia_solicitud( $datos );

        return $solicitud;

    }

    public function enviar_solicitud_public(Request $request){

        $response = $request
        ->clienteWS_penal
        ->request('post', 'registrar_solicitud_interface/5',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>$request->datos,
            ]
        ]);
        $response = json_decode($response->getBody(),true) ;

        return $response;
    }

    public function obtener_documentos_solicitud( Request $request ){
        
        if(isset($request->id_solicitud)) {

            $documento=archivos::obtener_documentos_solicitud($request, $request->id_solicitud, $request->version);
            return $documento;
            return redirect($documento['response']);

        }
        //return "hola";
        $docuento=archivos::obtener_documentos_solicitud($request, $request->solicitud, $request->version);
        
        return $docuento;
    }

    public function obtener_datos_solicitud( Request $request){

        $datos=[
            "modo"=>"completo",
            "id_solicitud"=>$request->solicitud,
            "tipo_solicitud"=>$request->tipo
        ];

        // return $datos;
        $response = $request
        ->clienteWS_penal
        ->request('get', 'consultar_solicitudes',[
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

    public function autorizacion_exhorto(Request $request){

        $datos=[
            "autorizacion"=>$request->autorizacion,
            "comentario"=>$request->comentarios,
        ];

        $response = $request
        ->clienteWS_penal
        ->request('post', 'autorizar_exhorto/'.Session::get('usuario_id').'/'.Session::get('id_unidad_gestion').'/'.$request->solicitud,[
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

    // ####	Registro de solicitudes iniciales (Tribunal de Enjuiciamiento / Ejecución) #####

    public function solicitudes_ejecucion_tribunal_enjuciamiento(Request $request){

        $arr_unidades=catalogos::obtener_ugas($request,3)['response'];
        $unidades=Arr::sort($arr_unidades, 'id_unidad_gestion');

        $inmuebles = catalogos::inmuebles($request)['response'];
        $tipos_audiencia = catalogos::tipos_audiencia($request)['response'];
        $recursos_audiencia = catalogos::obtener_ver_tipos_recursos($request)['response'];
        $tipos_audiencia = catalogos::tipos_audiencia($request)['response'];

        $jueces = catalogos::obtener_jueces( $request, Session::get('id_unidad_gestion') , [5] );
        $estados = catalogos::estados($request);
        $nacionalidades = catalogos::nacionalidades($request);

        $arr_calidad_juridica=catalogos::calidad_juridica($request)['response'];
        $calida_juridica=Arr::sort($arr_calidad_juridica, 'calidad_juridica');
        $calidad_juridica_filtrada = [];

        $arr_reclusorios= catalogos::ver_reclusorios($request)['message'];
        $reclusorios = Arr::sort($arr_reclusorios, 'id_reclusorio');

        $arr_tipos_audiencia=catalogos::tipos_audiencia( $request, 1 )['response'];
        $arr_delitos=catalogos::delitos($request)['response'];
        $arr_estado_civil=catalogos::estado_civil($request)['response'];
        $arr_fiscalias=catalogos::fiscalias($request)['response'];
        $arr_calificativos=catalogos::calificativos($request)['response'];
        $arr_unidades_investigacion=catalogos::unidades_investigacion($request)['response'];


        $tipos_audiencia=Arr::sort($arr_tipos_audiencia, 'tipo_audiencia');
        $delitos=Arr::sort($arr_delitos, 'delito');
        $estado_civil=Arr::sort($arr_estado_civil, 'estado_civil');
        $fiscalias=Arr::sort($arr_fiscalias, 'fiscalia');
        $unidades_investigacion=Arr::sort($arr_unidades_investigacion, 'unidad_investigacion');
        $calificativos=Arr::sort($arr_calificativos, 'calificativo');

        foreach($calida_juridica as $cj){

            if ( 
                ($cj['id_calidad_juridica'] == 29) || // Abogado defensor
                ($cj['id_calidad_juridica'] == 46) || // Imputado
                ($cj['id_calidad_juridica'] == 3)  || // Testigo(s)
                ($cj['id_calidad_juridica'] == 33) || // Acompañante
                ($cj['id_calidad_juridica'] == 2)  || // Victima
                ($cj['id_calidad_juridica'] == 53)  ||  // Acusado
                ($cj['id_calidad_juridica'] == 6)   || // Representante Legal
                ($cj['id_calidad_juridica'] == 47)    // Asesor juridico
            ){
                $calidad_juridica_filtrada[]=$cj;
            }
        }



      $elementos=["entorno"=>$request->entorno,
                  "request"=>$request,
                  "sesion"=>Session::all(),
                  "menu_general"=>$request->menu_general,
                  "unidades"=>$unidades,
                  "inmuebles"=>$inmuebles,
                  "tipos_audiencia"=>$tipos_audiencia,
                  "recursos_audiencia" => $recursos_audiencia,
                  "tipos_audiencia"=>$tipos_audiencia,
                  "calidad_juridica"=>$calidad_juridica_filtrada,
                  "jueces" => $jueces,
                  "estados" => $estados,
                  "nacionalidades" => $nacionalidades,
                  "delitos"=>$delitos,
                  "estado_civil"=>$estado_civil,
                  "fiscalias"=>$fiscalias,
                  "calificativos"=>$calificativos,
                  "unidades_investigacion"=>$unidades_investigacion,
                  "reclusorios"=> $reclusorios
                  ];
      return view('solicitudes.solicitud_inicial_tribunal_ejecucion', $elementos);

    }

    public function registrar_solicitud_TE_EJEC(Request $request){

        $tejec = [];
        $solicitud = [];

        $tejec = [
            "tipo_expediente"=>$request->TEJEC['tipo_expediente'],
            "id_carpeta_ref"=>$request->TEJEC['id_carpeta_ref'],
            "folio_carpeta_ref"=>$request->TEJEC['folio_carpeta_ref'],
            "carpeta_judicial_expediente"=>$request->TEJEC['carpeta_judicial_expediente'],
            "ugj_juzgado_emisor"=>$request->TEJEC['ugj_juzgado_emisor'],
            "tipo_solicitud_recibida"=>$request->TEJEC['tipo_solicitud_recibida'],
            "otra_tipo_solicitud_recibida"=>$request->TEJEC['otra_tipo_solicitud_recibida'],
            "ids_personas_remitidas"=>isset($request->TEJEC['ids_personas_remitidas']) ? implode(',',$request->TEJEC['ids_personas_remitidas']) : '-',
            "materia_destino"=>$request->TEJEC['materia_destino'],
            "tipo_unidad_destino"=>$request->TEJEC['tipo_unidad_destino'],
            "imputado_privado_libertad"=>$request->TEJEC['imputado_privado_libertad'],
            "lugar_internamiento"=>$request->TEJEC['lugar_internamiento'],
            "unidad_receptora"=>$request->TEJEC['unidad_receptora'],
            "b64_doc"=>$request->TEJEC['documento']['b64'],
            "nombre_doc"=>$request->TEJEC['documento']['nombre_archivo'],
        ];

        $solicitud = [
            "tipo_solicitud_"=>$request->solicitud['tipo_solicitud_'],
            "fecha_recepcion"=>$request->solicitud['fecha_recepcion'],
            "hora_recepcion"=>$request->solicitud['hora_recepcion'],
            "materia_destino"=>$request->solicitud['materia_destino'],
            "estatus_urgente"=>'-',
            "estatus_delito_grave"=>'-',
            "carpeta_investigacion"=>'-',
            "fecha_fenece"=>'-',
            "id_tipo_solicitud_audiencia"=>'-',
            "id_audiencia"=>'-',
            "duracion_aproximada"=>'-',
            "estatus_telepresencia"=>'-',
            "estatus_area_resguardo"=>'-',
            "estatus_mod_testigo_protegido"=>'-',
            "estatus_mesa_evidencia"=>'-',
            "id_fiscalia"=>'-',
            "id_agencia"=>'-',
            "unidad_id_fis"=>'-',
            "cordinacion_territorial"=>'-',
            "correo_mp"=>'-',
            "curp_mp"=>'-',
            "mp_nombres"=>'-',
            "mp_apellido_paterno"=>'-',
            "mp_apellido_materno"=>'-',
            "extension_doc"=>'pdf',
            "descripcion_hechos"=>'-',
            "nombre_archivo_b64"=>$request->solicitud['documento']['nombre_archivo'],
            "tamanio_archivo_b64"=>$request->solicitud['documento']['tamanio_archivo'],
            "b64_doc"=>$request->solicitud['documento']['b64'],
        ];
        
        if($request->tipo != 'OptcarpetaJ'){

            $personas=[];

            foreach($request->personas as $sujeto){
                $delitos=[];
                if(isset($sujeto['delitos'])){
                    foreach($sujeto['delitos'] as $delito){
                        $datos_delito=[
                            "id_delito"=>$delito['id_delito'],
                            "id_modalidad"=>$delito['id_modalidad'],
                            "id_calificativo"=>$delito['id_calificativo'],
                            "forma_comision"=>"forma",
                            "grado_realizacion"=>$delito['grado_realizacion'],
                            "delito_grave"=>$delito['delito_grave'],
                        ];
                        array_push($delitos, $datos_delito);
                    }
                }
                
                $contactos=[];
                if(isset($sujeto['contactos'])){
                    foreach($sujeto['contactos'] as $correo){
                        if($correo['tipo'] == 'correo'){
                            $datos_correo=[
                                "contacto" => $correo['contacto'] == null ? "-" : $correo['contacto'],
                                "tipo" => "correo electronico",
                                "extension"=>''
                            ];
                            array_push($contactos, $datos_correo);
                        }else if($correo['tipo'] == 'telefono'){
                            $datos_telefono=[
                                "contacto" => $correo['contacto'] == null ? "-" : $correo['contacto'],
                                "tipo" => $correo['tipo'],
                                "extension"=>$correo['extension'] == null ? "-" : $correo['extension']
                            ];
                            array_push($contactos, $datos_telefono);
                        }else{
                            $datos_telefono=[
                                "contacto" => $correo['contacto'] == null ? "-" : $correo['contacto'],
                                "tipo" => $correo['tipo'],
                                "extension"=>$correo['extension'] == null ? "-" : $correo['extension']
                            ];
                            array_push($contactos, $datos_telefono);
                        }
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

                /*
                if($sujeto['fecha_nacimiento']){
                    $fecha_n=explode("-",$sujeto['fecha_nacimiento']);
                    $fecha_nacimiento="$fecha_n[2]-$fecha_n[1]-$fecha_n[0]";
                }else{
                    $fecha_nacimiento="-";
                }
                */

                $persona=[
                    "id_calidad_juridica"=>$sujeto['id_calidad_juridica'],
                    "tipo_defensor"=>$sujeto['tipo_defensor'],
                    "tipo_persona"=>$sujeto['tipo_persona'],
                    "es_mexicano"=>$sujeto['es_mexicano'],
                    "id_nacionalidad"=>'-',
                    "otra_nacionalidad"=>'-',
                    "nombre"=>$sujeto['nombre'],
                    "apellido_paterno"=>$sujeto['apellido_paterno'],
                    "apellido_materno"=>$sujeto['apellido_materno'],
                    "genero"=>$sujeto['genero'],
                    "edad"=>'-',
                    "fecha_nacimiento"=> '-',
                    "id_tipo_identificacion"=>'-',
                    "folio_identificacion"=>'-',
                    "otra_identificacion"=>'-',
                    "curp"=>'-',
                    "rfc_empresa"=>'-',
                    "cedula_profesional"=>'-',
                    "razon_social"=>$sujeto['razon_social'],
                    "datos"=>[
                        "id_nivel_escolaridad"=>"-",
                        "id_lengua"=>"-",
                        "id_religion"=>"-",
                        "id_lgbttti"=>"-",
                        "id_grupo_etnico"=>"-",
                        "tipo_ocupacion"=>"-",
                        "otra_escolaridad"=>"-",
                        "otra_ocupacion"=>"-",
                        "otra_religion"=>"-",
                        "otro_grupo_etnico"=>"-",
                        "otro_idioma_traductor"=>"-",
                        "requiere_traductor"=>"-",
                        "idioma_traductor"=>"-",
                        "requiere_interprete"=>"-",
                        "tipo_interprete"=>"-",
                        "capacidades_diferentes"=>"-",
                        "capacidad_diferente"=>"-",
                        "poblacion"=>"-",
                        "otra_poblacion"=>"-",
                        "pertenece_grupo_etnico"=>"-",
                        "entiende_idioma_espanol"=>"-",
                        "descripcion_discapacidad"=>"-",
                        "sabe_leer_escribir"=>"-",
                        "poblacion_callejera"=>"-"
                    ],
                    "direccion"=>[
                        "id_municipio"=>$sujeto['direccion']['id_municipio'],
                        "municipio_importacion"=>$sujeto['direccion']['municipio_importacion'],
                        "entidad_federativa"=>$sujeto['direccion']['entidad_federativa'],
                        "localidad"=>$sujeto['direccion']['localidad'],
                        "colonia"=>$sujeto['direccion']['colonia'],
                        "calle"=>$sujeto['direccion']['calle'],
                        "entre_calles"=>$sujeto['direccion']['entre_calles'],
                        "referencias"=>$sujeto['direccion']['referencias'],
                        "codigo_postal"=>$sujeto['direccion']['codigo_postal'],
                        "no_exterior"=>$sujeto['direccion']['no_exterior'],
                        "no_interior"=>$sujeto['direccion']['no_interior']
                    ],
                    "alias"=>$alias,
                    "delitos"=>$delitos,
                    "contactos"=>$contactos,
                ];
                array_push($personas, $persona);
            }
        }else{
            $personas = $request->personas;
        }

        $datos = [
            "TEJEC"=>$tejec,
            "solicitud"=>$solicitud,
            "personas"=>$personas
        ];

        //return ['status'=>100, 'response'=>$datos];

        $response = $request
        ->clienteWS_penal
        ->request('post', 'registrar_solicitud_TE_EJEC/'.Session::get('usuario_id'),[
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

        if($response['status'] == 100){
            if(isset($response['response']['status']) && $response['response']['status'] == 100){
                return ['status'=>100, 'message'=>$response['response']['message'], 'response'=>$response['response']['response']];
            }else{
                return $response;
            }
        }

    }

    public function consultar_solicitudes_TEJEC(Request $request){
        $response = $request
        ->clienteWS_penal
        ->request('GET', 'consultar_solicitudes_TEJEC',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[
                    "modo"=>"completo",
                    "folio"=>"-",
                    "fecha_registro_min"=>"-",
                    "fecha_registro_max"=>"-",
                    "carpeta_origen"=>"-",
                    "expediente"=>"-",
                    "juzgado"=>"-",
                    "carpeta_asignada"=>"-"
                ],
                "paginacion"=>[
                    "pagina"=>$request->pagina,
                    "registros_por_pagina"=>$request->registros_por_pagina
                ]
            ]
        ]);
        $response = json_decode($response->getBody(),true) ;

        return $response; 
    }


    // #######  generar tareas
    public function generarTarea(Request $request){

        if($request->tipo == 'promocion'){
            $response = $request
            ->clienteWS_penal
            ->request('POST', 'reenviar_tareas_promocion',[
                "headers" => [
                    "sesion-id" => $request->session()->get("sesion-id"),
                    "cadena-sesion" => $request->session()->get("cadena-sesion"),
                    "usuario-id" => $request->session()->get("usuario-id"),
                    "Content-Type" => "application/json"
                ],
                "json"=>[
                    "datos"=>[
                        "tipo"=>$request->tipo,
                        "id_promocion"=>$request->id_solicitud,
                        "id_unidad"=>"-"
                    ]
                ]
            ]);
            $response = json_decode($response->getBody(),true) ;
    
            return $response; 
        }else{
            $response = $request
            ->clienteWS_penal
            ->request('POST', 'generar_tareas/'.$request->tipo.'/'.$request->id_solicitud,[
                "headers" => [
                    "sesion-id" => $request->session()->get("sesion-id"),
                    "cadena-sesion" => $request->session()->get("cadena-sesion"),
                    "usuario-id" => $request->session()->get("usuario-id"),
                    "Content-Type" => "application/json"
                ],
                "json"=>[
                    "datos"=>[
    
                    ]
                ]
            ]);
            $response = json_decode($response->getBody(),true) ;
    
            return $response;
        }
    }

    // ##### Exportar solicitudes a Excel 
    public function exportar_solicitudes_excel(Request $request){
        $ruta_base_local = $request->entorno_privado["servidor_local"]["uri_local_proyecto"];

        $response = $request
        ->clienteWS_penal
        ->request('GET', 'exportar_solicitudes_excel',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos" => [
                    "modo" => $request->modo,
                    "id_unidad_gestion" => $request->unidad == null ? Session::get("id_unidad_gestion") : $request->unidad,
                    "id_solicitud" => $request->id_solicitud,
                    "folio_solicitud" => $request->folio_solicitud,
                    "folio_carpeta" => $request->folio_carpeta,
                    "carpeta_investigacion" => $request->carpeta_investigacion,
                    "fecha_solicitud_min" => $request->fecha_recepcion,
                    "fecha_solicitud_max" => $request->fecha_recepcionh,
                    "estatus_actual" => $request->estatus_flujo_actual,
                    "estatus_urgente" => $request->estatus_urgente,
                    "materia_destino" => $request->materia_destino,
                    "tipo_solicitud" => isset($request->tipo_solicitud) ? $request->tipo_solicitud : null,
                    "color" => $request->color,
                    "id_unidad_gestion" => isset($request->id_unidad_gestion) ? $request->id_unidad_gestion : null,
                ],
                "paginacion" => [
                    "registros_por_pagina" => $request->registros_por_pagina,
                    "pagina" => $request->pagina,
                ],
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
    
        }
    }

    // ###### Correos Enviados
    public function correos_enviados(Request $request){
        $response = $request
        ->clienteWS_penal
        ->request('GET', 'correos_enviados/'.$request->id_solicitud.'/'.$request->tipo,[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
            ]
        ]);
        $response = json_decode($response->getBody(),true) ;

        return $response; 
    }
  
}
