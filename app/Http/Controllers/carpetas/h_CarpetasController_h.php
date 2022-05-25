<?php

namespace App\Http\Controllers\carpetas;

use App\Http\Controllers\promociones\PromocionesController_h;

use App\Http\Controllers\clases\audiencias;
use App\Http\Controllers\clases\catalogos;
use App\Http\Controllers\clases\carpeta_judicial;
use App\Http\Controllers\clases\documentos_asociados;
use App\Http\Controllers\clases\documentos_generados;
use App\Http\Controllers\clases\bandejas;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Session;
use App;
use DateTime;

use App\Http\Controllers\clases\archivos;

class h_CarpetasController_h extends Controller
{
    public function carpetas_judiciales( Request $request ){
        //dd(base_path(), public_path());
        $ugas=catalogos::obtener_ugas($request);
        $calidad_juridica=catalogos::calidad_juridica($request);
        $nacionalidades=catalogos::nacionalidades($request);
        $estado_civil=catalogos::estado_civil($request);
        $estados=catalogos::estados($request);
        $ocupaciones=catalogos::obtener_ocupaciones($request);
        $escolaridades=catalogos::obtener_escolaridades($request);
        $religiones=catalogos::obtener_religiones($request);
        $grupos_etnicos=catalogos::obtener_grupos_etnicos($request);
        $lenguas=catalogos::obtener_lenguas($request);
        $poblaciones_lgbttti =catalogos::obtener_poblaciones_lgbttti($request);
        $idiomas=catalogos::obtener_idiomas($request);
        $tipos_documento_carpeta=catalogos::tipos_documento_carpeta($request);
        $arr_fiscalias=catalogos::fiscalias($request)['response'];

        $calificativos = catalogos::calificativos($request);
        //$delitos = Arr::sort(  catalogos::delitos($request)['response'] , 'delito');
        $delitos = catalogos::delitos($request)['response'];
        $fiscalias=Arr::sort($arr_fiscalias, 'fiscalia');

        $tipos_documentos_generados = catalogos::obtener_tipos_documentos_plantillas($request);
        $suspension_condicional = catalogos::obtener_suspencion_condicional($request);

        $inmuebles = catalogos::inmuebles($request)['response'];
        $tipos_audiencia = catalogos::tipos_audiencia($request)['response'];
        $recursos_audiencia = catalogos::obtener_ver_tipos_recursos($request)['response'];

        $elementos=["entorno"=>$request->entorno,
                    "request"=>$request,
                    "sesion"=>Session::all(),
                    "menu_general"=>$request->menu_general,
                    "ugas"=>$ugas['response'],
                    "calidad_juridica"=>$calidad_juridica['response'],
                    "nacionalidades"=>$nacionalidades['response'],
                    "estado_civil"=>$estado_civil['response'],
                    "estados"=>$estados['response'],
                    "ocupaciones"=>$ocupaciones['response'],
                    "escolaridades"=>$escolaridades['response'],
                    "religiones"=>$religiones['response'],
                    "grupos_etnicos"=>$grupos_etnicos['response'],
                    "lenguas"=>$lenguas['response'],
                    "poblaciones_lgbttti"=>$poblaciones_lgbttti['response'],
                    "idiomas"=>$idiomas['response'],
                    "calificativos" => $calificativos['response'],
                    "delitos" => $delitos,
                    "tipos_documento_carpeta"=>$tipos_documento_carpeta['response'],
                    "tipos_documentos_generados"=>$tipos_documentos_generados['message'],
                    "fiscalias"=>$fiscalias,
                    "suspension_condicional"=>$suspension_condicional['response'],
                    "inmuebles"=>$inmuebles,
                    "tipos_audiencia"=>$tipos_audiencia,
                    "recursos_audiencia" => $recursos_audiencia,
                    ];

        //dd($elementos);
        //return view('carpetas.carpetas_judiciales', $elementos);
        //dd(Session::all() );
        return view('carpetas.h_consulta_carpetas_judiciales_h', $elementos);
    }

    public function carpetas_judiciales_R( Request $request ){
        $ugas=catalogos::obtener_ugas($request);
        $calidad_juridica=catalogos::calidad_juridica($request);
        $nacionalidades=catalogos::nacionalidades($request);
        $estado_civil=catalogos::estado_civil($request);
        $estados=catalogos::estados($request);
        $ocupaciones=catalogos::obtener_ocupaciones($request);
        $escolaridades=catalogos::obtener_escolaridades($request);
        $religiones=catalogos::obtener_religiones($request);
        $grupos_etnicos=catalogos::obtener_grupos_etnicos($request);
        $lenguas=catalogos::obtener_lenguas($request);
        $poblaciones_lgbttti =catalogos::obtener_poblaciones_lgbttti($request);
        $idiomas=catalogos::obtener_idiomas($request);
        $tipos_documento_carpeta=catalogos::tipos_documento_carpeta($request);
        $arr_fiscalias=catalogos::fiscalias($request)['response'];
        $arr_unidades=catalogos::obtener_ugas($request, $request->unidades);


        $calificativos = catalogos::calificativos($request);
        //$delitos = Arr::sort(  catalogos::delitos($request)['response'] , 'delito');
        $delitos = catalogos::delitos($request)['response'];
        $fiscalias=Arr::sort($arr_fiscalias, 'fiscalia');

        $unidades=Arr::sort($arr_unidades, 'id_unidad_gestion');
        $penas = catalogos::ver_tipo_pena($request);
        $centros_detencion = catalogos::obtener_centros_detencion($request);

        $elementos=[
            "entorno"=>$request->entorno,
            "request"=>$request,
            "sesion"=>Session::all(),
            "menu_general"=>$request->menu_general,
            "ugas"=>$ugas,
            "calidad_juridica"=>$calidad_juridica['response'],
            "nacionalidades"=>$nacionalidades['response'],
            "estado_civil"=>$estado_civil['response'],
            "estados"=>$estados['response'],
            "ocupaciones"=>$ocupaciones['response'],
            "escolaridades"=>$escolaridades['response'],
            "religiones"=>$religiones['response'],
            "grupos_etnicos"=>$grupos_etnicos['response'],
            "lenguas"=>$lenguas['response'],
            "poblaciones_lgbttti"=>$poblaciones_lgbttti['response'],
            "idiomas"=>$idiomas['response'],
            "calificativos" => $calificativos['response'],
            "delitos" => $delitos,
            "tipos_documento_carpeta"=>$tipos_documento_carpeta['response'],
            "fiscalias"=>$fiscalias,
            "unidades"=>$unidades,
            "penas" => $penas['message'],
            "centros_detencion" => $centros_detencion['message'],
        ];

        //dd($elementos);
        //return view('carpetas.carpetas_judiciales', $elementos);
        return view('carpetas.consulta_carpetas_judiciales_R', $elementos);
    }

    public function obtener_carpetas_judiciales( Request $request ){

        $fecha_min='';
        $fecha_max='';

        if(isset($request->fecha_asignacion_min)){
            $f=explode('-',$request->fecha_asignacion_min);
            $fecha_min="$f[2]-$f[1]-$f[0] 00:00:00";
        }

        if(isset($request->fecha_asignacion_max)){
            $f=explode('-',$request->fecha_asignacion_max);
            $fecha_max="$f[2]-$f[1]-$f[0] 00:00:00";
        }

        $datos=[
            "modo"=>$request->modo,
            "id_unidad"=>Session::get('id_unidad_gestion'),
            "fecha_asignacion_min"=>$fecha_min,
            "fecha_asignacion_max"=>$fecha_max,
            "folio_carpeta"=>$request->folio_carpeta,
            "fecha_apelacion"=>$request->fecha_apelacion,
            "id_carpeta_judicial"=>$request->carpeta_judicial,
            "id_tipo_carpeta"=>$request->tipo_carpeta,
            "persona_nom"=>$request->nombre,
            "persona_ap"=>$request->apellido_paterno,
            "persona_am"=>$request->apellido_materno,
            "carpeta_investigacion"=>$request->carpeta_inv,
        ];

        $paginacion=[
            "registros_por_pagina"=>"10",
            "pagina"=>$request->pagina
        ];

        $response = $request
        ->clienteWS_penal
        ->request('get', 'consultar_carpetas_judiciales',[
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

    public function borrar_carpeta_judicial(Request $request){
        $param = [
            'carpeta'=>isset($request->carpeta)?$request->carpeta:'-',
            'id_unidad_redireccion'=>isset($request->id_unidad_redireccion)?$request->id_unidad_redireccion:'-',
            'motivo_redireccion'=>isset($request->motivo_redireccion)?$request->motivo_redireccion:'-',
        ];
        return ['status' =>0, 'message'=>'Sección en desarrollo'];
    }

    public function sincronizacion_carpeta(Request $request ){
        return carpeta_judicial::sincronizacion_carpeta( $request, $request->id_solicitud );
    }

    /********* PARTES PROCESALES *********/

    public function obtener_personas_carpeta( Request $request ){

        $response = $request
        ->clienteWS_penal
        ->request('get', 'consultar_partes_carpeta/'.Session::get('usuario_id').'/'.$request->carpeta,[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json" => [
                'datos' => [
                    "calidad_juridica"=> 'null',
                    "comparacion" => "!="
                ]
            ]
        ]);
        $response = json_decode($response->getBody(),true) ;
        //dd($response, $request->carpeta);
        // if($response['status']==100){
        //     $newPP = [];
        //     foreach($response['response']['personas'] as $p){
        //         //if( $p['info_principal']['id_calidad_juridica']==null ) continue;
        //         // if( $p['info_principal']['bandera_identidad_reservada']==1  ){
        //         //     $p['info_principal']['apellido_paterno']= $this->obtener_iniciales( $p['info_principal']['apellido_paterno'], ' ');
        //         //     $p['info_principal']['apellido_materno']= $this->obtener_iniciales( $p['info_principal']['apellido_materno'], ' ');
        //         //     $p['info_principal']['nombre']= $this->obtener_iniciales( $p['info_principal']['nombre'], ' ');
        //         //     $p['info_principal']['razon_social']= $this->obtener_iniciales( $p['info_principal']['razon_social'], ' ');
        //         // }
        //         $newPP[]=$p;
        //     }
        //     $response['response']['personas']=$newPP;
        // }
        
        return $response;
    }

    public function agregar_parte_procesal( Request $request){
        //dd($request);

        $delitos=[];
        if(isset($request->delitos)){
            foreach($request->delitos as $delito){
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

        if(isset($request->correos)){
            foreach($request->correos as $correo){
                $datos_correo=[
                    "contacto"=>$correo['correo'],
                    "tipo_contacto"=>"correo electronico",
                    "extension"=>''
                ];
                array_push($contactos, $datos_correo);
            }
        }

        if(isset($request->telefonos)){
            foreach($request->telefonos as $telefono){
                $datos_telefono=[
                    "contacto"=>$telefono['numero'],
                    "tipo_contacto"=>$telefono['tipo'],
                    "extension"=>$telefono['extension']
                ];
                array_push($contactos, $datos_telefono);
            }
        }

        $alias=[];
        if(isset($request->alias)){
            foreach($request->alias as $alias_sujeto){
                $datos_alias=[
                    "alias"=>$alias_sujeto['alias'],
                ];
                array_push($alias, $datos_alias);
            }
        }

        $direcciones=[];
        if(isset($request->direcciones)){
            foreach($request->direcciones as $new_direccion){
                $direccion = [];

                if( isset($new_direccion['municipio']) && $new_direccion['municipio'] && $new_direccion['municipio'] != '-' && $new_direccion['municipio'] != null )
                    $direccion["id_municipio" ] = $new_direccion['municipio'];

                if( isset($new_direccion['estado']) && $new_direccion['estado'] && $new_direccion['estado'] != '-' && $new_direccion['estado'] != null )
                    $direccion["entidad_federativa" ] = $new_direccion['estado'];
                if( isset($new_direccion['localidad']) && $new_direccion['localidad'] && $new_direccion['localidad'] != '-' && $new_direccion['localidad'] != null )
                    $direccion["localidad" ] = $new_direccion['localidad'];

                if( isset($new_direccion['colonia']) && $new_direccion['colonia'] && $new_direccion['colonia'] != '-' && $new_direccion['colonia'] != null )
                    $direccion["colonia" ] = $new_direccion['colonia'];

                if( isset($new_direccion['calle']) && $new_direccion['calle'] && $new_direccion['calle'] != '-' && $new_direccion['calle'] != null )
                    $direccion["calle" ] = $new_direccion['calle'];

                if( isset($new_direccion['entre_calle']) && $new_direccion['entre_calle'] && $new_direccion['entre_calle'] != '-' && $new_direccion['entre_calle'] != null )
                    $direccion["entre_calles" ] = $new_direccion['entre_calle'];

                if( isset($new_direccion['otra_referencia']) && $new_direccion['otra_referencia'] && $new_direccion['otra_referencia'] != '-' && $new_direccion['otra_referencia'] != null )
                    $direccion["referencias" ] = $new_direccion['otra_referencia'];

                if( isset($new_direccion['codigo_postal']) && $new_direccion['codigo_postal'] && $new_direccion['codigo_postal'] != '-' && $new_direccion['codigo_postal'] != null )
                    $direccion["codigo_postal" ] = $new_direccion['codigo_postal'];

                if( isset($new_direccion['numero_exterior']) && $new_direccion['numero_exterior'] && $new_direccion['numero_exterior'] != '-' && $new_direccion['numero_exterior'] != null )
                    $direccion["no_exterior" ] = $new_direccion['numero_exterior'];

                if( isset($new_direccion['numero_interior']) && $new_direccion['numero_interior'] && $new_direccion['numero_interior'] != '-' && $new_direccion['numero_interior'] != null )
                    $direccion["no_interior" ] = $new_direccion['numero_interior'];

                array_push($direcciones, $direccion);
            }
        }


        $datos = [];
        if( $request->info_principal['tipo_persona'] == 'fisica' ){
            $datos = [
                "id_datos_persona"=> '-',
                "id_persona"=>'-',
                "id_nivel_escolaridad"=> isset($request->datos['id_nivel_escolaridad']) ? $request->datos['id_nivel_escolaridad'] : '-',
                "id_lengua"=> isset($request->datos['id_lengua']) ? $request->datos['id_lengua'] : '-',
                "id_religion"=> isset($request->datos['id_religion']) ? $request->datos['id_religion'] : '-',
                "id_lgbttti"=> isset($request->datos['id_lgbttti']) ? $request->datos['id_lgbttti'] : '-',
                "id_grupo_etnico"=> isset($request->datos['id_grupo_etnico']) ? $request->datos['id_grupo_etnico'] : '-',
                "tipo_ocupacion"=> isset($request->datos['tipo_ocupacion']) ? $request->datos['tipo_ocupacion'] : '-',
                "otra_escolaridad"=> isset($request->datos['otra_escolaridad']) ? $request->datos['otra_escolaridad'] : '-',
                "otra_ocupacion"=> isset($request->datos['otra_ocupacion']) ? $request->datos['otra_ocupacion'] : '-',
                "otra_religion"=> isset($request->datos['otra_religion']) ? $request->datos['otra_religion'] : '-',
                "otro_grupo_etnico"=> isset($request->datos['otro_grupo_etnico']) ? $request->datos['otro_grupo_etnico'] : '-',
                "otro_idioma_traductor"=> isset($request->datos['otro_idioma_traductor']) ? $request->datos['otro_idioma_traductor'] : '-',
                "requiere_traductor"=> isset($request->datos['requiere_traductor']) ? $request->datos['requiere_traductor'] : '-',
                "idioma_traductor"=> isset($request->datos['idioma_traductor']) ? $request->datos['idioma_traductor'] : '-',
                "requiere_interprete"=> isset($request->datos['requiere_interprete']) ? $request->datos['requiere_interprete'] : '-',
                "tipo_interprete"=> isset($request->datos['tipo_interprete']) ? $request->datos['tipo_interprete'] : '-',
                "capacidades_diferentes"=> isset($request->datos['capacidades_diferentes']) ? $request->datos['capacidades_diferentes'] : '-',
                "capacidad_diferente"=> isset($request->datos['capacidad_diferente'])?$request->datos['capacidad_diferente']:'-',
                "poblacion"=> isset($request->datos['poblacion']) ? $request->datos['poblacion'] : '-',
                "otra_poblacion"=> isset($request->datos['otra_poblacion']) ? $request->datos['otra_poblacion'] : '-',
                "pertenece_grupo_etnico"=> isset($request->datos['pertenece_grupo_etnico']) ? $request->datos['pertenece_grupo_etnico'] : '-',
                "entiende_idioma_espanol"=> isset($request->datos['entiende_idioma_espanol']) ? $request->datos['entiende_idioma_espanol'] : '-',
                "descripcion_discapacidad"=> isset($request->datos['descripcion_discapacidad']) ? $request->datos['descripcion_discapacidad'] : '-',
                "sabe_leer_escribir"=> isset($request->datos['sabe_leer_escribir']) ? $request->datos['sabe_leer_escribir'] : '-',
                "poblacion_callejera"=> isset($request->datos['poblacion_callejera']) ? $request->datos['poblacion_callejera'] : '-',
                "estatus"=> '-',
            ];
        }


        if($request->info_principal['fecha_nacimiento']){
            $fecha_n=explode("-",$request->info_principal['fecha_nacimiento']);
            $fecha_nacimiento="$fecha_n[2]-$fecha_n[1]-$fecha_n[0]";
        }else{
            $fecha_nacimiento="-";
        }

        $info_principal=[
            "id_calidad_juridica"=>$request->info_principal['tipo_parte'],
            "tipo_defensor"=>"-",
            "tipo_persona"=>$request->info_principal['tipo_persona'],
            "es_mexicano"=>$request->info_principal['nacionalidad']=='mexicana'?'si':'no',
            "id_nacionalidad"=>$request->info_principal['otra_nacionalidad'],
            "otra_nacionalidad"=>$request->info_principal['otra_nacionalidad'],
            "nombre"=>$request->info_principal['nombre'],
            "apellido_paterno"=>$request->info_principal['apellido_paterno'],
            "apellido_materno"=>$request->info_principal['apellido_materno'],
            "genero"=>$request->info_principal['genero'],
            "edad"=>$request->info_principal['edad'],
            "fecha_nacimiento"=> $fecha_nacimiento,
            "id_tipo_identificacion"=>'-',
            "folio_identificacion"=>'-',
            "otra_identificacion"=>'-',
            "curp"=>$request->info_principal['curp'],
            "rfc_empresa"=>$request->info_principal['rfc'],
            "cedula_profesional"=>$request->info_principal['cedula_profesional'],
            "razon_social"=>$request->info_principal['razon_social'],
            "id_estado_civil"=>$request->info_principal['estado_civil'],
            "origen" => 'carpeta_judicial'
        ];


        $persona=[
            "id_persona"=> '-',
            "estatus"=> '-',
            "info_principal"=>$info_principal,
            "datos"=>$datos,
            "direcciones"=>$direcciones,
            "alias"=>$alias,
            "delitos"=>$delitos,
            "contacto"=>$contactos,
        ];


        //dd($persona);

        $solicitud = [
            "id_solicitud"=> $request->id_solicitud,
            "tipo_solicitud_"=> $request->tipo_solicitud,
            // "fecha_recepcion"=>$request->fecha_recepcion,
            // "hora_recepcion"=> $request->hora_recepcion ,
            // "descripcion_hechos" => $request->relato_hechos,
            // "materia_destino"=>"-",
            // "estatus_urgente"=>"-",
            // "estatus_delito_grave"=>"-",
            // "carpeta_investigacion"=>"-",
            // "fecha_fenece"=>"-",
            // "id_tipo_solicitud_audiencia"=>"-",
            // "id_audiencia"=>"-",
            // "duracion_aproximada"=>"-",
            // "estatus_telepresencia"=>"-",
            // "estatus_area_resguardo"=>"-",
            // "estatus_mod_testigo_protegido"=>"-",
            // "estatus_mesa_evidencia"=>"-",
            // "id_fiscalia"=>"-",
            // "id_agencia"=>"-",
            // "unidad_id_fis"=>"-",
            // "cordinacion_territorial"=>"-",
            // "correo_mp"=>"-",
            // "curp_mp"=>"-",
            // "mp_nombres"=>"-",
            // "mp_apellido_paterno"=>"-",
            // "mp_apellido_materno"=>"-",
            // "extension_doc"=>"-",
            // "b64_doc"=> "-",
            "personas"=>[$persona],
            "delitos_no_relacionados"=>[],
        ];

        //dd($solicitud);

        $datos=[
            "datos_solicitud"=>$solicitud,
        ];

        // //dd($datos);

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

    public function modificar_parte_procesal( Request $request){
        //dd($request);

        $delitos=[];
        if(isset($request->delitos)){
            foreach($request->delitos as $delito){
                $datos_delito=[
                    //  "id_persona_delito"=>$delito['id'],
                    "id_delito_persona"=>$delito['id'],
                    "estatus"=>$delito['estatus'],
                    "id_persona"=>$request->id_persona,
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

        if(isset($request->correos)){
            foreach($request->correos as $correo){
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

        if(isset($request->telefonos)){
            foreach($request->telefonos as $telefono){
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
        if(isset($request->alias)){
            foreach($request->alias as $alias_sujeto){
                $datos_alias=[
                    "id_alias"=>$alias_sujeto['id'],
                    "estatus"=>$alias_sujeto['estatus'],
                    "alias"=>$alias_sujeto['alias'],
                ];
                array_push($alias, $datos_alias);
            }
        }

        $direcciones=[];
        if(isset($request->direcciones)){
            foreach($request->direcciones as $new_direccion){
                $direccion = [];

                $direccion["id_direccion"]=$new_direccion['id'];
                $direccion["estatus"]=$new_direccion['estatus'];

                if( isset($new_direccion['municipio']) && $new_direccion['municipio'] && $new_direccion['municipio'] != '-' && $new_direccion['municipio'] != null )
                    $direccion["id_municipio" ] = $new_direccion['municipio'];

                if( isset($new_direccion['estado']) && $new_direccion['estado'] && $new_direccion['estado'] != '-' && $new_direccion['estado'] != null )
                    $direccion["entidad_federativa" ] = $new_direccion['estado'];
                if( isset($new_direccion['localidad']) && $new_direccion['localidad'] && $new_direccion['localidad'] != '-' && $new_direccion['localidad'] != null )
                    $direccion["localidad" ] = $new_direccion['localidad'];

                if( isset($new_direccion['colonia']) && $new_direccion['colonia'] && $new_direccion['colonia'] != '-' && $new_direccion['colonia'] != null )
                    $direccion["colonia" ] = $new_direccion['colonia'];

                if( isset($new_direccion['calle']) && $new_direccion['calle'] && $new_direccion['calle'] != '-' && $new_direccion['calle'] != null )
                    $direccion["calle" ] = $new_direccion['calle'];

                if( isset($new_direccion['entre_calle']) && $new_direccion['entre_calle'] && $new_direccion['entre_calle'] != '-' && $new_direccion['entre_calle'] != null )
                    $direccion["entre_calles" ] = $new_direccion['entre_calle'];

                if( isset($new_direccion['otra_referencia']) && $new_direccion['otra_referencia'] && $new_direccion['otra_referencia'] != '-' && $new_direccion['otra_referencia'] != null )
                    $direccion["referencias" ] = $new_direccion['otra_referencia'];

                if( isset($new_direccion['codigo_postal']) && $new_direccion['codigo_postal'] && $new_direccion['codigo_postal'] != '-' && $new_direccion['codigo_postal'] != null )
                    $direccion["codigo_postal" ] = $new_direccion['codigo_postal'];

                if( isset($new_direccion['numero_exterior']) && $new_direccion['numero_exterior'] && $new_direccion['numero_exterior'] != '-' && $new_direccion['numero_exterior'] != null )
                    $direccion["no_exterior" ] = $new_direccion['numero_exterior'];

                if( isset($new_direccion['numero_interior']) && $new_direccion['numero_interior'] && $new_direccion['numero_interior'] != '-' && $new_direccion['numero_interior'] != null )
                    $direccion["no_interior" ] = $new_direccion['numero_interior'];

                array_push($direcciones, $direccion);
            }
        }


        $datos = [];
        if( $request->info_principal['tipo_persona'] == 'fisica' ){
            $datos = [
                "id_datos_persona"=> isset($request->datos['id_datos_persona']) ? $request->datos['id_datos_persona'] : '-',
                "id_persona"=> $request->id_persona,
                "id_nivel_escolaridad"=> isset($request->datos['id_nivel_escolaridad']) ? $request->datos['id_nivel_escolaridad'] : '-',
                "id_lengua"=> isset($request->datos['id_lengua']) ? $request->datos['id_lengua'] : '-',
                "id_religion"=> isset($request->datos['id_religion']) ? $request->datos['id_religion'] : '-',
                "id_lgbttti"=> isset($request->datos['id_lgbttti']) ? $request->datos['id_lgbttti'] : '-',
                "id_grupo_etnico"=> isset($request->datos['id_grupo_etnico']) ? $request->datos['id_grupo_etnico'] : '-',
                "tipo_ocupacion"=> isset($request->datos['tipo_ocupacion']) ? $request->datos['tipo_ocupacion'] : '-',
                "otra_escolaridad"=> isset($request->datos['otra_escolaridad']) ? $request->datos['otra_escolaridad'] : '-',
                "otra_ocupacion"=> isset($request->datos['otra_ocupacion']) ? $request->datos['otra_ocupacion'] : '-',
                "otra_religion"=> isset($request->datos['otra_religion']) ? $request->datos['otra_religion'] : '-',
                "otro_grupo_etnico"=> isset($request->datos['otro_grupo_etnico']) ? $request->datos['otro_grupo_etnico'] : '-',
                "otro_idioma_traductor"=> isset($request->datos['otro_idioma_traductor']) ? $request->datos['otro_idioma_traductor'] : '-',
                "requiere_traductor"=> isset($request->datos['requiere_traductor']) ? $request->datos['requiere_traductor'] : '-',
                "idioma_traductor"=> isset($request->datos['idioma_traductor']) ? $request->datos['idioma_traductor'] : '-',
                "requiere_interprete"=> isset($request->datos['requiere_interprete']) ? $request->datos['requiere_interprete'] : '-',
                "tipo_interprete"=> isset($request->datos['tipo_interprete']) ? $request->datos['tipo_interprete'] : '-',
                "capacidades_diferentes"=> isset($request->datos['capacidades_diferentes']) ? $request->datos['capacidades_diferentes'] : '-',
                "capacidad_diferente"=> isset($request->datos['capacidad_diferente'])?$request->datos['capacidad_diferente']:'-',
                "poblacion"=> isset($request->datos['poblacion']) ? $request->datos['poblacion'] : '-',
                "otra_poblacion"=> isset($request->datos['otra_poblacion']) ? $request->datos['otra_poblacion'] : '-',
                "pertenece_grupo_etnico"=> isset($request->datos['pertenece_grupo_etnico']) ? $request->datos['pertenece_grupo_etnico'] : '-',
                "entiende_idioma_espanol"=> isset($request->datos['entiende_idioma_espanol']) ? $request->datos['entiende_idioma_espanol'] : '-',
                "descripcion_discapacidad"=> isset($request->datos['descripcion_discapacidad']) ? $request->datos['descripcion_discapacidad'] : '-',
                "sabe_leer_escribir"=> isset($request->datos['sabe_leer_escribir']) ? $request->datos['sabe_leer_escribir'] : '-',
                "poblacion_callejera"=> isset($request->datos['poblacion_callejera']) ? $request->datos['poblacion_callejera'] : '-',
                "estatus"=> 1,
            ];
        }


        if($request->info_principal['fecha_nacimiento']){
            $fecha_n=explode("-",$request->info_principal['fecha_nacimiento']);
            $fecha_nacimiento="$fecha_n[2]-$fecha_n[1]-$fecha_n[0]";
        }else{
            $fecha_nacimiento="-";
        }

        $info_principal=[
            "id_calidad_juridica"=>$request->info_principal['tipo_parte'],
            "tipo_defensor"=>"-",
            "tipo_persona"=>$request->info_principal['tipo_persona'],
            "es_mexicano"=>$request->info_principal['nacionalidad']=='extranjero'?'no':'si',
            "id_nacionalidad"=>$request->info_principal['otra_nacionalidad'],
            "otra_nacionalidad"=>$request->info_principal['otra_nacionalidad'],
            "nombre"=>$request->info_principal['nombre'],
            "apellido_paterno"=>$request->info_principal['apellido_paterno'],
            "apellido_materno"=>$request->info_principal['apellido_materno'],
            "genero"=>$request->info_principal['genero'],
            "edad"=>$request->info_principal['edad'],
            "fecha_nacimiento"=> $fecha_nacimiento,
            "id_tipo_identificacion"=>'-',
            "folio_identificacion"=>'-',
            "otra_identificacion"=>'-',
            "curp"=>$request->info_principal['curp'],
            "rfc_empresa"=>$request->info_principal['rfc'],
            "cedula_profesional"=>$request->info_principal['cedula_profesional'],
            "razon_social"=>$request->info_principal['razon_social'],
            "id_estado_civil"=>$request->info_principal['estado_civil'],
            //"origen" => 'carpeta_judicial'
        ];


        $persona=[
            "id_persona"=> $request->id_persona,
            "estatus"=> 1,
            "info_principal"=>$info_principal,
            "datos"=>$datos,
            "direcciones"=>$direcciones,
            "alias"=>$alias,
            "delitos"=>$delitos,
            "contacto"=>$contactos,
        ];


        //dd($persona);

        $solicitud = [
            "id_solicitud"=> $request->id_solicitud,
            "tipo_solicitud_"=> $request->tipo_solicitud,
            // "fecha_recepcion"=>$request->fecha_recepcion,
            // "hora_recepcion"=> $request->hora_recepcion ,
            // "descripcion_hechos" => $request->relato_hechos,
            // "materia_destino"=>"-",
            // "estatus_urgente"=>"-",
            // "estatus_delito_grave"=>"-",
            // "carpeta_investigacion"=>"-",
            // "fecha_fenece"=>"-",
            // "id_tipo_solicitud_audiencia"=>"-",
            // "id_audiencia"=>"-",
            // "duracion_aproximada"=>"-",
            // "estatus_telepresencia"=>"-",
            // "estatus_area_resguardo"=>"-",
            // "estatus_mod_testigo_protegido"=>"-",
            // "estatus_mesa_evidencia"=>"-",
            // "id_fiscalia"=>"-",
            // "id_agencia"=>"-",
            // "unidad_id_fis"=>"-",
            // "cordinacion_territorial"=>"-",
            // "telefono_mp"=>"-",
            // "curp_mp"=>"-",
            // "mp_nombres"=>"-",
            // "mp_apellido_paterno"=>"-",
            // "mp_apellido_materno"=>"-",
            // "extension_doc"=>"-",
            // "b64_doc"=> "-",
            "personas"=>[$persona],
            "delitos_no_relacionados"=>[],
        ];

        //dd($solicitud);

        $datos=[
            "datos_solicitud"=>$solicitud,
        ];

        // //dd($datos);

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

    public function borrar_parte_procesal( Request $request){

        $info_principal=[
            "origen" => 'carpeta_judicial',
            "estatus"=> 0,
        ];

        $persona=[
            "id_persona"=> $request->id_persona,
            "estatus"=> 0,
            "info_principal"=>$info_principal,
            "datos"=>[],
            "direcciones"=>[],
            "alias"=>[],
            "delitos"=>[],
            "contacto"=>[],
        ];


        //dd($persona);

        $solicitud = [
            "id_solicitud"=> $request->id_solicitud,
            "tipo_solicitud_"=> $request->tipo_solicitud,
            "personas"=>[$persona],
            "delitos_no_relacionados"=>[],
        ];

        //dd($solicitud);

        $datos=[
            "datos_solicitud"=>$solicitud,
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

    public function modificar_bandera_identidad_parte_procesal(Request $request){
        $info_principal=[
            "origen" => 'carpeta_judicial',
            "bandera_identidad_reservada"=> $request->bandera_identidad_reservada,
        ];

        $persona=[
            "id_persona"=> $request->id_persona,
            "estatus"=> 1,
            "info_principal"=>$info_principal,
            "datos"=>[],
            "direcciones"=>[],
            "alias"=>[],
            "delitos"=>[],
            "contacto"=>[],
        ];

        $solicitud = [
            "id_solicitud"=> $request->id_solicitud,
            "tipo_solicitud_"=> $request->tipo_solicitud,
            "personas"=>[$persona],
            "delitos_no_relacionados"=>[],
        ];

        $datos=[
            "datos_solicitud"=>$solicitud,
        ];

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
        return json_decode($response->getBody(),true) ;
    }

    /********* DELITOS SIN RELACIONAR *********/

    public function relacionar_delitos_sin_relacionar(Request $request){

        $solicitud = [
            "id_solicitud"=> $request->id_solicitud,
            "estatus" => 1,
            "tipo_solicitud_"=> $request->tipo_solicitud,
            "personas"=>[],
            "delitos_no_relacionados"=> $request->delitos_sin_relacionar,
        ];

        $datos=[
            "datos_solicitud"=>$solicitud,
        ];
        //dd(json_encode($datos));
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

    public function actualizar_delito_sin_relacionar(Request $request){

        $solicitud = [
            "id_solicitud"=> $request->id_solicitud,
            "estatus" => 1,
            "tipo_solicitud_"=> $request->tipo_solicitud,
            "personas"=>[],
            "delitos_no_relacionados"=> $request->delitos_sin_relacionar,
        ];

        $datos=[
            "datos_solicitud"=>$solicitud,
        ];
        //dd(json_encode($datos));
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


    /******** DOCUMENTOS ASOCIADOS *********** */

    public function obtener_documentos_asociados_carpeta(Request $request){
        $documento_origen = isset($request->documento_origen) ? $request->documento_origen : null;

        if( $documento_origen== null){
            $response = $request
            ->clienteWS_penal
            ->request('GET', 'consultar_documentos_carpeta/'.$request->session()->get("usuario-id").'/'.$request->carpeta,[
                "headers" => [
                    "sesion-id" => $request->session()->get("sesion-id"),
                    "cadena-sesion" => $request->session()->get("cadena-sesion"),
                    "usuario-id" => $request->session()->get("usuario-id"),
                    "Content-Type" => "application/json"
                ],
                "json" => [
                    "datos" => [
                        "tipo_documento" => isset($request->tipo_documento)?$request->tipo_documento:'-',
                        "nombre_documento" => isset($request->nombre_documento)?$request->nombre_documento:'-',
                        "extension_documento" => isset($request->extension_documento)?$request->extension_documento:'-',
                        "origen_documento" => isset($request->origen_documento)?$request->origen_documento:'-',
                    ],
                    "paginacion" => [
                        "pagina"=> isset($request->pagina)?$request->pagina:1,
                        "registros_por_pagina"=> isset($request->registros_por_pagina)?$request->registros_por_pagina:10,
                    ],
                    //"status" => 100
                ]
            ]);

            return $response = json_decode($response->getBody(),true);
        }else if( $documento_origen == 'SOLICITUD'){

            $res_doc = carpeta_judicial::obtener_pdf_solicitud($request, $request->id_solicitud, $request->id_documento);
            if ($res_doc['status']==100 ) return ["status"=>100,"response"=>$res_doc["response"]];
            else return $res_doc;

            // $response = $request
            // ->clienteWS_penal
            // ->request('GET', 'consultar_pdf_solicitud/'.$request->id_solicitud.'/'.$request->id_documento,[
            //     "headers" => [
            //         "sesion-id" => $request->session()->get("sesion-id"),
            //         "cadena-sesion" => $request->session()->get("cadena-sesion"),
            //         "usuario-id" => $request->session()->get("usuario-id"),
            //         "Content-Type" => "application/json"
            //     ],
            //     "json" => [
            //         "datos" => [],
            //         "status" => 100
            //     ]
            // ]);

            // $response = json_decode($response->getBody(),true);

            // if( isset($response[0]['url']) ){

            //     $url_local='/var/www/html/sigj_penal/storage/pdf_solicitudes/'.$request->id_solicitud.'.'.$request->extension;

            //     $documento_pdf=$response[0]['url'];
            //     copy($documento_pdf, $url_local);

            //     return ["status"=>100,"response"=>"/pdf_solicitud/$request->id_solicitud.$request->extension"];
            // }else{
            //     return $response;
            // }
        }else if($documento_origen == 'CJ'){
            $response = $request
            ->clienteWS_penal
            ->request('POST', 'documento_carpeta_judicial/'.Session::get('usuario_id').'/'.$request->carpeta.'/'.$request->id_documento.'/ARCHIVO',[
                "headers" => [
                    "sesion-id" => $request->session()->get("sesion-id"),
                    "cadena-sesion" => $request->session()->get("cadena-sesion"),
                    "usuario-id" => $request->session()->get("usuario-id"),
                    "Content-Type" => "application/json"
                ],
                "json" => [
                    "datos" => [],
                ]
            ]);
            $response = json_decode($response->getBody(),true);
            //dd($response);

            if( isset($response['url']) ){
                $explode_url=explode('/',$response['url']);
                //dd($explode_url);
                $explode_url=end($explode_url);
                $random=(explode('.',$explode_url))[0];
                $nom_doc = $random.$request->documento_nombre.'.'.$request->extension;

                if(isset($response['is_oficio']) && $response['is_oficio']==1) $nom_doc = str_replace('.'.$request->extension,'.pdf',$nom_doc);

                $url_local=base_path().'/storage/pdf_solicitudes/'.$nom_doc;

                $documento_pdf=$response['url'];
                copy($documento_pdf, $url_local);

                return ["status"=>100,"response"=>"/pdf_solicitud/$nom_doc"];
            }else{
                return $response;
            }
        }
    }

    public function guardar_documentos_asociados_carpeta(Request $request){
        $id_documento = isset($request->documento['id_documento']) && $request->documento['id_documento'] != '-' ? $request->documento['id_documento'] : null;
        $response = $request
        ->clienteWS_penal
        ->request('POST', 'documento_carpeta_judicial/'.Session::get('usuario_id').'/'.$request->carpeta.'/'.$id_documento,[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[
                    "tipo_documento"=>$request->documento['id_tipo_archivo'],
                    "nombre"=>$request->documento['nombre_archivo'],
                    "extension"=>$request->documento['extension_archivo'],
                    "tamanio"=>$request->documento['tamanio_archivo'],
                    "estatus"=>$request->documento['estatus'],
                    "b64_doc"=>$request->documento['b64'],
                    "motivos"=>isset($request->documento['motivos']) ? $request->documento['motivos'] : '-' ,
                ]
            ]
        ]);

        return $response = json_decode($response->getBody(),true);
    }

    public function coser_documentos_asociados( Request $request ){

        $arr_coser=[];
        $docs_seleccionados = [];
        if($request->imprimir_todo==0) $docs_seleccionados=$request->seleccionados;
        else{
            $filtro = [
                "carpeta" => isset($request->carpeta) ? $request->carpeta : '-',
                "tipo_documento" => isset($request->tipo_documento) ? $request->tipo_documento : '-',
                "nombre_documento" => isset($request->nombre_documento) ? $request->nombre_documento : '-',
                "extension_documento" => isset($request->extension_documento) ? $request->extension_documento : '-',
                "origen_documento" => isset($request->origen_documento) ? $request->origen_documento : '-',
                "pagina" => isset($request->pagina) ? $request->pagina : 1,
                "registros_por_pagina" => 1000000,
            ];

            $docs_seleccionados = documentos_asociados::obtener_documentos($request, $filtro);

            if($docs_seleccionados['status'] !=100) return $docs_seleccionados;
            else $docs_seleccionados= $docs_seleccionados['response'];
        }

        $num_cocer=0;
        $total_cocer = count($docs_seleccionados);
        $random = date('YmdHis').rand();

        foreach($docs_seleccionados as $index => $doc){

            if( $doc['origen']=='SOLICITUD'){
                $res_doc = carpeta_judicial::obtener_pdf_solicitud($request, $doc['id_solicitud'], $doc['tipo_solicitud']=='PRO-MUJER'?$doc['id_documento']:'');

                $explode=explode('/',$doc['ruta_base']);
                if( !isset($doc['nombre_archivo'])  ) $doc['nombre_archivo']= explode('.',end($explode))[0];
                //dd($res_doc);
            }

            if( $doc['origen']=='CJ'){
                $res_doc = carpeta_judicial::obtener_documento_asociado($request, $request->carpeta,$doc['id_documento']);
                //dd($doc);
            }

            if( $doc['origen']=='ACUERDO'){
                $res_doc = carpeta_judicial::obtener_ultima_version_acuerdo( $request, $request->id_unidad ,$doc["id_documento"], "pdf");
            }
            
            if( $doc['origen']=='PROMOCION'){
                $res_doc = carpeta_judicial::obtener_pdf_promocion( $request, $doc["id_documento"]);
            }

            if($res_doc['status']!=100) return $res_doc;

            $ext_doc = explode('.', $res_doc['ruta_local'])[1];
            if( $ext_doc != 'pdf' && in_array($ext_doc,['png','jpg','jpeg']) ){

                $html='<img src="data:image/'.$ext_doc.';base64, '.base64_encode(file_get_contents($res_doc['ruta_local'])).'" width="100%"/><br><p align="center">'.$doc['nombre_archivo'].'.'.$ext_doc.'</p>';
                $res_doc['ruta_local']= str_replace('.'.$ext_doc,'.pdf',$res_doc['ruta_local']);
                if( !documentos_generados::save_html_to_pdf($html,$res_doc['ruta_local'])) return ['status' =>0, 'message' =>'Error al convertir imagen '.$ext_doc.' a pdf'];
                unlink(str_replace('.pdf','.'.$ext_doc,$res_doc['ruta_local']));

            }else if ( in_array($ext_doc,['doc','docx']) ){
                $ruta_word =  $res_doc['ruta_local'];
                $ruta_pdf = str_replace('.'.$ext_doc,'.pdf',$ruta_word);
                documentos_generados::docx_to_pdf( $ruta_word, $ruta_pdf);
            }

            $url_tmp='/var/www/html/sigj_penal/storage/temp_exportaciones/coser'.'-'.$random.'-'.($num_cocer+1).'-'.$total_cocer.'-'.$doc['origen'].'.pdf';
            copy($res_doc['ruta_local'], $url_tmp);
            if(file_exists($res_doc['ruta_local']))
            {
                unlink($res_doc['ruta_local']);
                $arr_coser[] = $url_tmp;
            }
            $num_cocer++;
        }

        if(count($arr_coser)==0){
            $lista['status']=1;
            $lista['message']='No hay documentos válidos.';
            return response()->json($lista);
        }

        //se manda a coser
        $lista_coser=carpeta_judicial::coser_documentos_pdf($arr_coser);
        $lista_coser['arr_coser']=$arr_coser;

        foreach($arr_coser as $d){
            if(file_exists($d) && is_file($d)) unlink($d);
        }

        return response()->json($lista_coser);
    }

    /** DOCUMENTOS GENERADOS */
    public function obtener_documentos_generados(Request $request){
        $param = [
            "id_documento" => isset($request->id_documento) ? $request->id_documento:'-',
            "id_tipo_documento" => isset($request->tipo_documento) ? $request->tipo_documento:'-',
            "nombre_archivo" => isset($request->nombre_archivo) ? $request->nombre_archivo:'-',
            "estatus" => isset($request->estatus) ? $request->estatus:'-',
            "id_carpeta_judicial" => isset($request->carpeta) ? $request->carpeta:'-',
            "pagina"=>isset( $request->pagina) ? $request->pagina:1,
            "registros_por_pagina"=>isset( $request->registros_por_pagina) ? $request->registros_por_pagina:10,
            "unidad_gestion" => isset($request->unidad_gestion) ? $request->unidad_gestion : '-',
            "carpeta_judicial" => isset($request->carpeta_judicial) ? $request->carpeta_judicial : '-',
            "estatus_proceso" => isset($request->estatus_proceso) ? $request->estatus_proceso : '-',
            "bandera_ws_usmeca" => isset($request->bandera_ws_usmeca) ? $request->bandera_ws_usmeca : '-',
            "estatus_respuesta_usmc" => isset($request->estatus_respuesta_usmc) ? $request->estatus_respuesta_usmc : '-',
            "folio_usmc" => isset($request->folio_usmc) ? $request->folio_usmc : '-',
            "fecha_desde" => isset($request->fecha_desde) ? $request->fecha_desde : '-',
            "fecha_hasta" => isset($request->fecha_hasta) ? $request->fecha_hasta : '-',
        ];
        return documentos_generados::obtener_documentos($request, $param);
    }

    public function obtener_usuarios_por_tipo(Request $request){
        $tipos_usuarios = isset($request->tipos_usuarios)? $request->tipos_usuarios:[2,3,5,14];
        $id_unidad_gestion = isset($request->id_unidad)?$request->id_unidad:Session::get('id_unidad_gestion');
        $usuarios=[];
        foreach($tipos_usuarios as $tu){
            $us = catalogos::obtener_usuarios_tipo($request,$id_unidad_gestion,$tu);
            if($us["status"]!=100) continue;//return $us;
            else $usuarios[]=$us['response'][0];
        }
        return ["status" =>100, "response"=>$usuarios];
    }

    public function obtener_catalogo_usmeca(Request $request){
        return catalogos::obtener_catalogo_usmeca($request, $request->catalogo, $request->tipo);
    }

    public function obtener_plantilla_documento_generado_carpeta(Request $request){
        //dd($request);
        //dd(Session::all());
        //return catalogos::obtener_tipos_documentos_plantillas($request,'completo');

        $cj = carpeta_judicial::obtener_carpetas($request,['modo'=>'completo','id_carpeta_judicial'=>$request->carpeta]);
        if($cj['status']!=100) return $cj;
        $cj=$cj['response'][0];
        //dd($cj);
        //dd(catalogos::obtener_ugas($request));
        
        // las audiencias y remitente llegan por id,usuario, se deben consultar y sacar sus datos.
        $numero_ugj = intval( $cj['clave_unidad'] );
        
        $uga = catalogos::obtener_ugas_por_id($request, intval( $cj['id_unidad'] ))['response'];
        //$uga = $uga[0];
        // $uga = array_values( 
        //             array_filter( catalogos::obtener_ugas($request)['response'], 
        //                 function( $u ) use ($id_ugj){ 
        //                     if($u['id_unidad_gestion'] == $id_ugj ){ 
        //                         return $u; 
        //                     }
        //                 }
        //             )
        //         );
        //dd($uga);
        
        $materia_carpeta = $cj['materia_destino'];
        $asunto = null;
        $imputados=null;
        $victimas=null;
        $audiencia=null;
        $audienciamc=null;
        $oficiomc=null;
        $remitente=null;
        $juez_control=null;

        $periodo_suspension=null;
        $fecha_fenece=null;
        $presentacion=null;
        $fecha_presentacion=null;
        $valor_periodo=null;
        $plazo=null;
        $condiciones=[];
        $medidas_cautelares=[];

        $ws_usmc_req=null;
        $consumir_ws_usmeca = 0;
        $dirUGJ = null;

        $tiempo_resolucion_situacion_juridica='[SIN-HORAS]';
 
        $modo_ver_victimas = isset($request->mostrarVictimasComo)?$request->mostrarVictimasComo:'nombre_completo';
        if( $request->plantilla=='41' ){ // suspencion condicional proceso
            $asunto = isset($request->asunto)?$request->asunto:'Suspensión Condicional del Proceso';
            $filtro['id_audiencia'] = $request->audienciaConcede;
            // $audiencia = audiencias::obtener_audiencias($request,$filtro);
            // if($audiencia['status']==100) $audiencia = $audiencia['response'][0];
            // else $audiencia = ["fecha_audiencia"=>date('Y-m-d'),'hora_inicio_audiencia'=>date('H:i:s'),'hora_fin_audiencia'=>date('H:i:s'),'tipo_audiencia'=>'AUDIENCIA DE PRUEBA']; //return $audiencia;
            //dd($audiencia = $request->audienciaConcedeObj);
            
            $audiencia = $request->audienciaConcedeObj;
            $audiencia['fecha_inicio_letra'] = $this->obtener_fecha_letra($audiencia['fecha_audiencia'],'d \d\e F \d\e Y');
            $audiencia['hora_inicio_letra'] = $this->obtener_fecha_letra($audiencia['hora_inicio_audiencia'],'H:i');
            //dd($audiencia);
            $periodo_suspension = $request->peridoSuspension;
            $fecha_fenece = $this->obtener_fecha_letra($request->fechaFenecimiento,'d \d\e F \d\e Y');
            $presentacion = $request->presentacionImputadoAnteUnidad;
            $fecha_presentacion = $presentacion=='fecha' ? $this->obtener_fecha_letra($request->fechaPresentacionImputado,'d \d\e F \d\e Y'):$request->periodoPresentacionImputado;
            $valor_periodo = $request->valorPeriodoPresentacionImputadoAnteUnidad;
            $plazo = $request->plazoReporteIncumplimiento;
            $condiciones = $request->arrItems;

            unset($filtro);

            // $juez_control = documentos_generados::obtener_usuarios($request,['id_tipo_usuario'=>5,'id_unidad_gestion'=>$cj['id_unidad']]);
            // if($juez_control['status']==100) $juez_control=$juez_control['response'][0];
            // else $juez_control=["apellido_materno" => "[apellido_materno]", "apellido_paterno" => "[apellido_paterno]", "correo" => "[correo]", "cve_juez" => "[cve_juez]", "descripcion" => "Juez de control", "id_tipo_usuario" => "[id_tipo_usuario]", "id_unidad_gestion" => "[id_unidad_gestion]", "id_usuario" => "[id_usuario]", "nombre_unidad" => "[nombre_unidad]", "nombres" => "[nombres]", "usuario" => "[usuario]"];

            // $juez_control['nombre_completo']=$this->obtener_nombre_completo( $juez_control['nombres'], $juez_control['apellido_paterno'], $juez_control['apellido_materno'] );
            // $juez_control['nombre_mayuscula'] = $this->obtener_mayusculas( $juez_control['nombre_completo'] );
            // $juez_control['puesto_mayuscula'] = $this->obtener_mayusculas( $juez_control['descripcion']);
            
            $juez_control['nombre_completo']= $audiencia['juez']['nombre_usuario'];
            $juez_control['nombre_mayuscula'] = $this->obtener_mayusculas( $juez_control['nombre_completo'] );
            $juez_control['puesto_mayuscula'] = $this->obtener_mayusculas( 'juez de control' );
            $juez_control['titulo'] = 'Lic.';

            $remitente = documentos_generados::obtener_usuarios($request,['usuario'=>$request->JuezInformante]);
            //dd($remitente);
            if($remitente['status']==100) $remitente=$remitente['response'][0];
            else $remitente=["apellido_materno" => "[apellido_materno]", "apellido_paterno" => "[apellido_paterno]", "correo" => "[correo]", "cve_juez" => "[cve_juez]", "descripcion" => "[descripcion]", "id_tipo_usuario" => "[id_tipo_usuario]", "id_unidad_gestion" => "[id_unidad_gestion]", "id_usuario" => "[id_usuario]", "nombre_unidad" => "[nombre_unidad]", "nombres" => "[nombres]", "usuario" => "[usuario]"];

            $remitente['nombre_completo'] = $this->obtener_nombre_completo( $remitente['nombres'], $remitente['apellido_paterno'], $remitente['apellido_materno'] );
            $remitente['nombre_mayuscula'] = $this->obtener_mayusculas( $remitente['nombre_completo'] );
            $remitente['puesto_mayuscula'] = $this->obtener_mayusculas( $remitente['descripcion']);
            $remitente['titulo'] = isset($remitente['titulo'])?$this->obtener_mayusculas( $remitente['titulo'] ):'LIC';

            $imputados=isset($request->imputados)?$this->procesa_partes_procesales( $request->imputados):'[SIN-IMPUTADOS]';
            // $imputado['nombre']=($request->imputados)?$request->imputados:'Inombre Iaparteno Iamaterno';
            // $imputado['nombre_mayuscula']= $this->obtener_mayusculas( $imputado['nombre'] );

            $victimas= !empty($cj['victimas'])?$this->obtener_nombres($cj['victimas'],$modo_ver_victimas):'[SIN-VICTIMAS]';
        }if( $request->plantilla=='532' ){ // Medida Cautelar dentro del plazo constitucional  
            $asunto = isset($request->asunto)?$request->asunto:'Medida Cautelar dentro del plazo constitucional';
            $filtro['id_audiencia'] = $request->audienciaImposicionMedidasCautelares;
            // $audiencia = audiencias::obtener_audiencias($request,$filtro);
            // if($audiencia['status']==100) $audiencia = $audiencia['response'][0];
            // else $audiencia = ["fecha_audiencia"=>date('Y-m-d'),'hora_inicio_audiencia'=>date('H:i:s'),'hora_fin_audiencia'=>date('H:i:s'),'tipo_audiencia'=>'AUDIENCIA DE PRUEBA']; //return $audiencia;

            $audiencia = $request->audienciaImposicionMedidasCautelaresObj;

            $audiencia['fecha_inicio_letra'] = $this->obtener_fecha_letra($audiencia['fecha_audiencia'],'d \d\e F \d\e Y');
            $audiencia['hora_inicio_letra'] = $this->obtener_fecha_letra($audiencia['hora_inicio_audiencia'],'H:i');

            $periodo_suspension = $request->peridoSuspension;
            $fecha_fenece = $this->obtener_fecha_letra($request->fechaFenecimiento,'d \d\e F \d\e Y');
            $presentacion = $request->presentacionImputadoAnteUnidad;
            $fecha_presentacion = $presentacion=='fecha' ? $this->obtener_fecha_letra($request->fechaPresentacionImputado,'d \d\e F \d\e Y'):$request->periodoPresentacionImputado;
            $valor_periodo = $request->valorPeriodoPresentacionImputadoAnteUnidad;
            $plazo = $request->plazoReporteIncumplimiento;
            $medidas_cautelares = $request->arrItems;

            unset($filtro);

            // $juez_control = documentos_generados::obtener_usuarios($request,['id_tipo_usuario'=>5,'id_unidad_gestion'=>$cj['id_unidad']]);
            // if($juez_control['status']==100) $juez_control=$juez_control['response'][0];
            // else $juez_control=["apellido_materno" => "[apellido_materno]", "apellido_paterno" => "[apellido_paterno]", "correo" => "[correo]", "cve_juez" => "[cve_juez]", "descripcion" => "Juez de control", "id_tipo_usuario" => "[id_tipo_usuario]", "id_unidad_gestion" => "[id_unidad_gestion]", "id_usuario" => "[id_usuario]", "nombre_unidad" => "[nombre_unidad]", "nombres" => "[nombres]", "usuario" => "[usuario]"];

            // $juez_control['nombre_completo']=$this->obtener_nombre_completo( $juez_control['nombres'], $juez_control['apellido_paterno'], $juez_control['apellido_materno'] );
            // $juez_control['nombre_mayuscula'] = $this->obtener_mayusculas( $juez_control['nombre_completo'] );
            // $juez_control['puesto_mayuscula'] = $this->obtener_mayusculas( $juez_control['descripcion']);
            //$juez_control['titulo'] = isset($remitente['titulo'])?$this->obtener_mayusculas( $remitente['titulo'] ):'LIC';

            $juez_control['nombre_completo']= $audiencia['juez']['nombre_usuario'];
            $juez_control['nombre_mayuscula'] = $this->obtener_mayusculas( $juez_control['nombre_completo'] );
            $juez_control['puesto_mayuscula'] = $this->obtener_mayusculas( 'juez de control' );
            $juez_control['titulo'] = 'Lic.';

            $remitente = documentos_generados::obtener_usuarios($request,['usuario'=>$request->JuezInformante]);
            //dd($remitente);
            if($remitente['status']==100) $remitente=$remitente['response'][0];
            else $remitente=["apellido_materno" => "[apellido_materno]", "apellido_paterno" => "[apellido_paterno]", "correo" => "[correo]", "cve_juez" => "[cve_juez]", "descripcion" => "[descripcion]", "id_tipo_usuario" => "[id_tipo_usuario]", "id_unidad_gestion" => "[id_unidad_gestion]", "id_usuario" => "[id_usuario]", "nombre_unidad" => "[nombre_unidad]", "nombres" => "[nombres]", "usuario" => "[usuario]"];

            $remitente['nombre_completo'] = $this->obtener_nombre_completo( $remitente['nombres'], $remitente['apellido_paterno'], $remitente['apellido_materno'] );
            $remitente['nombre_mayuscula'] = $this->obtener_mayusculas( $remitente['nombre_completo'] );
            $remitente['puesto_mayuscula'] = $this->obtener_mayusculas( $remitente['descripcion']);
            $remitente['titulo'] = isset($remitente['titulo'])?$this->obtener_mayusculas( $remitente['titulo'] ):'LIC';

            $imputados=isset($request->imputados)?$this->procesa_partes_procesales( $request->imputados):'[SIN-IMPUTADOS]';
            
            $victimas= !empty($cj['victimas'])?$this->obtener_nombres($cj['victimas'],$modo_ver_victimas):'[SIN-VICTIMAS]';

            $tiempo_resolucion_situacion_juridica = isset($request->tiempoResolucionSituacionJuridica) ? $request->tiempoResolucionSituacionJuridica : $horas_medidas_cautelares;
        }
        if( $request->plantilla=='533' ){ // suspensión condicional y Medida Cautelar 
            $asunto = isset($request->asunto)?$request->asunto:'Suspensión Condicional del Proceso y Medida Cautelar';
            $filtro['id_audiencia'] = $request->audienciaImposicionMedidasCautelares;
            // $audiencia = audiencias::obtener_audiencias($request,$filtro);
            // if($audiencia['status']==100) $audiencia = $audiencia['response'][0];
            // else $audiencia = ["fecha_audiencia"=>date('Y-m-d'),'hora_inicio_audiencia'=>date('H:i:s'),'hora_fin_audiencia'=>date('H:i:s'),'tipo_audiencia'=>'AUDIENCIA DE PRUEBA']; //return $audiencia;

            $audiencia = $request->audienciaConcedeObj;;

            $audiencia['fecha_inicio_letra'] = $this->obtener_fecha_letra($audiencia['fecha_audiencia'],'d \d\e F \d\e Y');
            $audiencia['hora_inicio_letra'] = $this->obtener_fecha_letra($audiencia['hora_inicio_audiencia'],'H:i');

            // $periodo_suspension = $request->peridoSuspension;
            // $fecha_fenece = $this->obtener_fecha_letra($request->fechaFenecimiento,'d \d\e F \d\e Y');
            // $presentacion = $request->presentacionImputadoAnteUnidad;
            // $fecha_presentacion = $presentacion=='fecha' ? $this->obtener_fecha_letra($request->fechaPresentacionImputado,'d \d\e F \d\e Y'):$request->periodoPresentacionImputado;
            // $valor_periodo = $request->valorPeriodoPresentacionImputadoAnteUnidad;
            $plazo = $request->plazoReporteIncumplimiento;
            $medidas_cautelares = array_values( 
                                    array_filter( $request->arrItems , 
                                        function( $i ) { 
                                            if($i['tipo'] == 'medida_cautelar' ){ 
                                                return $i; 
                                            }
                                        }
                                    )
                                ); 
            $condiciones = array_values( 
                                array_filter( $request->arrItems , 
                                    function( $i ) { 
                                        if($i['tipo'] == 'condicion_suspension_del_proceso' ){ 
                                            return $i; 
                                        }
                                    }
                                )
                            );

            unset($filtro);

            // $juez_control = documentos_generados::obtener_usuarios($request,['id_tipo_usuario'=>5,'id_unidad_gestion'=>$cj['id_unidad']]);
            // if($juez_control['status']==100) $juez_control=$juez_control['response'][0];
            // else $juez_control=["apellido_materno" => "[apellido_materno]", "apellido_paterno" => "[apellido_paterno]", "correo" => "[correo]", "cve_juez" => "[cve_juez]", "descripcion" => "Juez de control", "id_tipo_usuario" => "[id_tipo_usuario]", "id_unidad_gestion" => "[id_unidad_gestion]", "id_usuario" => "[id_usuario]", "nombre_unidad" => "[nombre_unidad]", "nombres" => "[nombres]", "usuario" => "[usuario]"];

            // $juez_control['nombre_completo']=$this->obtener_nombre_completo( $juez_control['nombres'], $juez_control['apellido_paterno'], $juez_control['apellido_materno'] );
            // $juez_control['nombre_mayuscula'] = $this->obtener_mayusculas( $juez_control['nombre_completo'] );
            // $juez_control['puesto_mayuscula'] = $this->obtener_mayusculas( $juez_control['descripcion']);
            //$juez_control['titulo'] = isset($remitente['titulo'])?$this->obtener_mayusculas( $remitente['titulo'] ):'LIC';

            $juez_control['nombre_completo']= $audiencia['juez']['nombre_usuario'];
            $juez_control['nombre_mayuscula'] = $this->obtener_mayusculas( $juez_control['nombre_completo'] );
            $juez_control['puesto_mayuscula'] = $this->obtener_mayusculas( 'juez de control' );
            $juez_control['titulo'] = 'Lic.';

            $remitente = documentos_generados::obtener_usuarios($request,['usuario'=>$request->JuezInformante]);
            //dd($remitente);
            if($remitente['status']==100) $remitente=$remitente['response'][0];
            else $remitente=["apellido_materno" => "[apellido_materno]", "apellido_paterno" => "[apellido_paterno]", "correo" => "[correo]", "cve_juez" => "[cve_juez]", "descripcion" => "[descripcion]", "id_tipo_usuario" => "[id_tipo_usuario]", "id_unidad_gestion" => "[id_unidad_gestion]", "id_usuario" => "[id_usuario]", "nombre_unidad" => "[nombre_unidad]", "nombres" => "[nombres]", "usuario" => "[usuario]"];

            $remitente['nombre_completo'] = $this->obtener_nombre_completo( $remitente['nombres'], $remitente['apellido_paterno'], $remitente['apellido_materno'] );
            $remitente['nombre_mayuscula'] = $this->obtener_mayusculas( $remitente['nombre_completo'] );
            $remitente['puesto_mayuscula'] = $this->obtener_mayusculas( $remitente['descripcion']);
            $remitente['titulo'] = isset($remitente['titulo'])?$this->obtener_mayusculas( $remitente['titulo'] ):'LIC';

            $imputados=isset($request->imputados)?$this->procesa_partes_procesales( $request->imputados):'[SIN-IMPUTADOS]';
            
            $victimas= !empty($cj['victimas'])?$this->obtener_nombres($cj['victimas'],$modo_ver_victimas):'[SIN-VICTIMAS]';

            //$tiempo_resolucion_situacion_juridica = isset($request->tiempoResolucionSituacionJuridica) ? $request->tiempoResolucionSituacionJuridica : $horas_medidas_cautelares;
        }
        if( $request->plantilla=='503' ){ // imposición de medida cautelar
            $asunto = isset($request->asunto)?$request->asunto:'Imposición de Medidas Cautelares';
            $filtro['id_audiencia'] = $request->audienciaImposicionMedidasCautelares;
            // $audiencia = audiencias::obtener_audiencias($request,$filtro);
            // if($audiencia['status']==100) $audiencia = $audiencia['response'][0];
            // else $audiencia = ["fecha_audiencia"=>date('Y-m-d'),'hora_inicio_audiencia'=>date('H:i:s'),'hora_fin_audiencia'=>date('H:i:s'),'tipo_audiencia'=>'AUDIENCIA DE PRUEBA']; //return $audiencia;

            $audiencia = $request->audienciaImposicionMedidasCautelaresObj;

            $audiencia['fecha_inicio_letra'] = $this->obtener_fecha_letra($audiencia['fecha_audiencia'],'d \d\e F \d\e Y');
            $audiencia['hora_inicio_letra'] = $this->obtener_fecha_letra($audiencia['hora_inicio_audiencia'],'H:i');

            $periodo_suspension = $request->peridoSuspension;
            $fecha_fenece = $this->obtener_fecha_letra($request->fechaFenecimiento,'d \d\e F \d\e Y');
            $presentacion = $request->presentacionImputadoAnteUnidad;
            $fecha_presentacion = $presentacion=='fecha' ? $this->obtener_fecha_letra($request->fechaPresentacionImputado,'d \d\e F \d\e Y'):$request->periodoPresentacionImputado;
            $valor_periodo = $request->valorPeriodoPresentacionImputadoAnteUnidad;
            $plazo = $request->plazoReporteIncumplimiento;
            $medidas_cautelares = $request->arrItems;

            unset($filtro);

            // $juez_control = documentos_generados::obtener_usuarios($request,['id_tipo_usuario'=>5,'id_unidad_gestion'=>$cj['id_unidad']]);
            // if($juez_control['status']==100) $juez_control=$juez_control['response'][0];
            // else $juez_control=["apellido_materno" => "[apellido_materno]", "apellido_paterno" => "[apellido_paterno]", "correo" => "[correo]", "cve_juez" => "[cve_juez]", "descripcion" => "Juez de control", "id_tipo_usuario" => "[id_tipo_usuario]", "id_unidad_gestion" => "[id_unidad_gestion]", "id_usuario" => "[id_usuario]", "nombre_unidad" => "[nombre_unidad]", "nombres" => "[nombres]", "usuario" => "[usuario]"];

            // $juez_control['nombre_completo']=$this->obtener_nombre_completo( $juez_control['nombres'], $juez_control['apellido_paterno'], $juez_control['apellido_materno'] );
            // $juez_control['nombre_mayuscula'] = $this->obtener_mayusculas( $juez_control['nombre_completo'] );
            // $juez_control['puesto_mayuscula'] = $this->obtener_mayusculas( $juez_control['descripcion']);
            //$juez_control['titulo'] = isset($remitente['titulo'])?$this->obtener_mayusculas( $remitente['titulo'] ):'LIC';

            $juez_control['nombre_completo']= $audiencia['juez']['nombre_usuario'];
            $juez_control['nombre_mayuscula'] = $this->obtener_mayusculas( $juez_control['nombre_completo'] );
            $juez_control['puesto_mayuscula'] = $this->obtener_mayusculas( 'juez de control' );
            $juez_control['titulo'] = 'Lic.';

            $remitente = documentos_generados::obtener_usuarios($request,['usuario'=>$request->JuezInformante]);
            //dd($remitente);
            if($remitente['status']==100) $remitente=$remitente['response'][0];
            else $remitente=["apellido_materno" => "[apellido_materno]", "apellido_paterno" => "[apellido_paterno]", "correo" => "[correo]", "cve_juez" => "[cve_juez]", "descripcion" => "[descripcion]", "id_tipo_usuario" => "[id_tipo_usuario]", "id_unidad_gestion" => "[id_unidad_gestion]", "id_usuario" => "[id_usuario]", "nombre_unidad" => "[nombre_unidad]", "nombres" => "[nombres]", "usuario" => "[usuario]"];

            $remitente['nombre_completo'] = $this->obtener_nombre_completo( $remitente['nombres'], $remitente['apellido_paterno'], $remitente['apellido_materno'] );
            $remitente['nombre_mayuscula'] = $this->obtener_mayusculas( $remitente['nombre_completo'] );
            $remitente['puesto_mayuscula'] = $this->obtener_mayusculas( $remitente['descripcion']);
            $remitente['titulo'] = isset($remitente['titulo'])?$this->obtener_mayusculas( $remitente['titulo'] ):'LIC';

            $imputados=isset($request->imputados)?$this->procesa_partes_procesales( $request->imputados):'[SIN-IMPUTADOS]';
            // $imputado['nombre']=($request->imputados)?$request->imputados:'Inombre Iaparteno Iamaterno';
            // $imputado['nombre_mayuscula']= $this->obtener_mayusculas( $imputado['nombre'] );

            $victimas= !empty($cj['victimas'])?$this->obtener_nombres($cj['victimas'],$modo_ver_victimas):'[SIN-VICTIMAS]';
        }
        if( $request->plantilla=='513' ){ //Se informa sobreseimiento
            $asunto = isset($request->asunto)?$request->asunto:'Sobreseimiento';
            $filtro['id_audiencia'] = $request->audienciaSobreseimiento;
            // $audiencia = audiencias::obtener_audiencias($request,$filtro);
            // if($audiencia['status']==100) $audiencia = $audiencia['response'][0];
            // else $audiencia = ["fecha_audiencia"=>date('Y-m-d'),'hora_inicio_audiencia'=>date('H:i:s'),'hora_fin_audiencia'=>date('H:i:s'),'tipo_audiencia'=>'AUDIENCIA DE PRUEBA']; //return $audiencia;

            $audiencia = $request->audienciaSobreseimientoObj;

            $audiencia['fecha_inicio_letra'] = $this->obtener_fecha_letra($audiencia['fecha_audiencia'],'d \d\e F \d\e Y');
            $audiencia['hora_inicio_letra'] = $this->obtener_fecha_letra($audiencia['hora_inicio_audiencia'],'H:i');

            unset($filtro);

            $filtro['id_audiencia'] = $request->audienciaMedidasCautelares;
            // $audienciamc = audiencias::obtener_audiencias($request,$filtro);
            // if($audienciamc['status']==100) $audienciamc = $audienciamc['response'][0];
            // else $audienciamc = ["fecha_audiencia"=>date('Y-m-d'),'hora_inicio_audiencia'=>date('H:i:s'),'hora_fin_audiencia'=>date('H:i:s'),'tipo_audiencia'=>'AUDIENCIA DE PRUEBA 2']; //return $audienciamc;

            $audienciamc = $request->audienciaMedidasCautelaresObj;

            $audienciamc['fecha_inicio_letra'] = $this->obtener_fecha_letra($audienciamc['fecha_audiencia'],'d \d\e F \d\e Y');
            $audienciamc['hora_inicio_letra'] = $this->obtener_fecha_letra($audienciamc['hora_inicio_audiencia'],'H:i');

            $oficiomc = $request->numeroOficioMedidasCautelares;

            // $juez_control = documentos_generados::obtener_usuarios($request,['id_tipo_usuario'=>5,'id_unidad_gestion'=>$cj['id_unidad']]);
            // if($juez_control['status']==100) $juez_control=$juez_control['response'][0];
            // else $juez_control=["apellido_materno" => "[apellido_materno]", "apellido_paterno" => "[apellido_paterno]", "correo" => "[correo]", "cve_juez" => "[cve_juez]", "descripcion" => "Juez de control", "id_tipo_usuario" => "[id_tipo_usuario]", "id_unidad_gestion" => "[id_unidad_gestion]", "id_usuario" => "[id_usuario]", "nombre_unidad" => "[nombre_unidad]", "nombres" => "[nombres]", "usuario" => "[usuario]"];

            // $juez_control['nombre_completo']=$this->obtener_nombre_completo( $juez_control['nombres'], $juez_control['apellido_paterno'], $juez_control['apellido_materno'] );
            // $juez_control['nombre_mayuscula'] = $this->obtener_mayusculas( $juez_control['nombre_completo'] );
            // $juez_control['puesto_mayuscula'] = $this->obtener_mayusculas( $juez_control['descripcion']);
            //dd($juez_control);

            $juez_control['nombre_completo']= $audiencia['juez']['nombre_usuario'];
            $juez_control['nombre_mayuscula'] = $this->obtener_mayusculas( $juez_control['nombre_completo'] );
            $juez_control['puesto_mayuscula'] = $this->obtener_mayusculas( 'juez de control' );
            $juez_control['titulo'] = 'Lic.';
            $juez_control['descripcion'] = 'Juez de Control';

            $remitente = documentos_generados::obtener_usuarios($request,['usuario'=>$request->firmadoPor]);
            //dd($remitente);
            if($remitente['status']==100) $remitente=$remitente['response'][0];
            else $remitente=["apellido_materno" => "[apellido_materno]", "apellido_paterno" => "[apellido_paterno]", "correo" => "[correo]", "cve_juez" => "[cve_juez]", "descripcion" => "[descripcion]", "id_tipo_usuario" => "[id_tipo_usuario]", "id_unidad_gestion" => "[id_unidad_gestion]", "id_usuario" => "[id_usuario]", "nombre_unidad" => "[nombre_unidad]", "nombres" => "[nombres]", "usuario" => "[usuario]"];

            $remitente['nombre_completo'] = $this->obtener_nombre_completo( $remitente['nombres'], $remitente['apellido_paterno'], $remitente['apellido_materno'] );
            $remitente['nombre_mayuscula'] = $this->obtener_mayusculas( $remitente['nombre_completo'] );
            $remitente['puesto_mayuscula'] = $this->obtener_mayusculas( $remitente['descripcion']);
            $remitente['titulo'] = isset($remitente['titulo'])?$this->obtener_mayusculas( $remitente['titulo'] ):'LIC';

            $imputados=isset($request->imputados)?$this->procesa_partes_procesales( $request->imputados):'[SIN-IMPUTADOS]';
            // $imputado['nombre']=isset($request->imputados)?$request->imputados:'Inombre Iaparteno Iamaterno';
            // $imputado['nombre_mayuscula']= $this->obtener_mayusculas( $imputado['nombre'] );

            // $imputado['delitos']= $this->obtener_delitos_persona( $request, $request->carpeta ,$request->id_imputado);
            // $imputado['delitos_mayusculas']= $this->obtener_mayusculas( $imputado['delitos']);

            $victimas= !empty($cj['victimas'])?$this->obtener_nombres($cj['victimas'],$modo_ver_victimas):'[SIN-VICTIMAS]';
        }
        if( $request->plantilla=='504' ){ // Se informa audiencia y se solicita informe de solución alterna
            $asunto = isset($request->asunto)?$request->asunto:'Se Informa Audiencia y se solicita Informe de Solución Alterna';
            $filtro['id_audiencia'] = $request->audienciaCelebrar;
            // $audiencia = audiencias::obtener_audiencias($request,$filtro);
            // if($audiencia['status']==100) $audiencia = $audiencia['response'][0];
            // else $audiencia = ["fecha_audiencia"=>date('Y-m-d'),'hora_inicio_audiencia'=>date('H:i:s'),'hora_fin_audiencia'=>date('H:i:s'),'tipo_audiencia'=>'[AUDIENCIA DE PRUEBA]']; //return $audiencia;

            $audiencia = $request->audienciaCelebrarObj;

            $audiencia['fecha_inicio_letra'] = $this->obtener_fecha_letra($audiencia['fecha_audiencia'],'d \d\e F \d\e Y');
            $audiencia['hora_inicio_letra'] = $this->obtener_fecha_letra($audiencia['hora_inicio_audiencia'],'H:i');

            unset($filtro);
            $remitente = documentos_generados::obtener_usuarios($request,['usuario'=>$request->firmadoPor]);
            //dd($remitente);
            if($remitente['status']==100) $remitente=$remitente['response'][0];
            else $remitente=["apellido_materno" => "[apellido_materno]", "apellido_paterno" => "[apellido_paterno]", "correo" => "[correo]", "cve_juez" => "[cve_juez]", "descripcion" => "[descripcion]", "id_tipo_usuario" => "[id_tipo_usuario]", "id_unidad_gestion" => "[id_unidad_gestion]", "id_usuario" => "[id_usuario]", "nombre_unidad" => "[nombre_unidad]", "nombres" => "[nombres]", "usuario" => "[usuario]"];

            $remitente['nombre_completo'] = $this->obtener_nombre_completo( $remitente['nombres'], $remitente['apellido_paterno'], $remitente['apellido_materno'] );
            $remitente['nombre_mayuscula'] = $this->obtener_mayusculas( $remitente['nombre_completo'] );
            $remitente['puesto_mayuscula'] = $this->obtener_mayusculas( $remitente['descripcion']);
            $remitente['titulo'] = isset($remitente['titulo'])?$this->obtener_mayusculas( $remitente['titulo'] ):'LIC';

            $imputados=isset($request->imputados)?$this->procesa_partes_procesales( $request->imputados):'[SIN-IMPUTADOS]';
            // $imputado['nombre']=isset($request->imputados)?$request->imputados:'Inombre Iaparteno Iamaterno';
            // $imputado['nombre_mayuscula']= $this->obtener_mayusculas( $imputado['nombre'] );

            $victimas= !empty($cj['victimas'])?$this->obtener_nombres($cj['victimas'],$modo_ver_victimas):'[SIN-VICTIMAS]';
        }
        //  dd($imputados,$request->imputados);

        if( !isset($juez_control['titulo']) or $juez_control['titulo']==null or !strlen($juez_control['titulo']) ) $juez_control['titulo'] = 'Lic.';

        $parametros = [
            'plantilla' => $request->plantilla,
            'leyenda_anio' => documentos_generados::obtener_leyenda($request,date('Y'))['response'][0]['leyenda'],
            'fecha_oficio'=> $this->obtener_fecha_letra(date('Y-m-d'),'d \d\e F \d\e Y'),
            'numero_ugj' => $numero_ugj,
            'asunto'=> $asunto,
            'numero_oficio' => isset($request->numOficio)?$request->numOficio:'[SIN-NUMERO-OFICIO]',
            'materia_carpeta' => $materia_carpeta,
            
            'plazo_proceso' => isset($request->plazoProceso) ? $request->plazoProceso : '[SIN-PLAZO-PROCESO]',
            'obligacion_presentarse_usmc' => isset($request->obligacionPresentarseUSMC) ? $request->obligacionPresentarseUSMC : '[SIN-TIEMPO]',
            'plan_reparación_danio' => isset($request->planReparacionDanio) ? $request->planReparacionDanio : '[SIN-PLAN-REPARACION-DANIO]',

            'numero_oficio_mc' => $oficiomc!=null?$oficiomc:'[SIN-NUMERO-OFICIO-MC]',

            'carpeta_judicial' => $cj['folio_carpeta'],
            'carpeta_judicial_anterior' => $cj['id_carpeta_padre']!=null?$cj['folio_carpeta_padre']:'Sin carpeta anterior',
            'carpeta_investigacion' => $cj['carpeta_investigacion']!=null?$cj['carpeta_investigacion']:'[SIN-CARPETA-DE-INVESTIGACION]',

            'fecha_vinculacion_proceso' => $this->obtener_fecha_letra(date('Y-m-d'),'d \d\e F \d\e Y'),//$fecha_vinculacion_proceso,

            'periodo_suspension' => $periodo_suspension,
            'fecha_fenece' => $fecha_fenece,
            'presentacion' => $presentacion,
            'fecha_presentacion' => $fecha_presentacion,
            'valor_periodo' => $valor_periodo,
            'plazo' => $plazo,
            'condiciones'=>$condiciones,
            'medidas_cautelares'=>$medidas_cautelares,
            'tiempo_resolucion_situacion_juridica' => $tiempo_resolucion_situacion_juridica,

            'audiencia' =>$audiencia,
            'audienciamc' =>$audienciamc,
            'juez_control'=>$juez_control,
            'remitente' =>$remitente,
            'imputados' => $imputados,
            'victimas' => $victimas,

            'horario_apertura' => $this->obtener_fecha_letra($uga[0]['horario_apertura'],'H:i'),
            'horario_cierre_lj' => $this->obtener_fecha_letra($uga[0]['horario_cierre_LJ'],'H:i'),
            'horario_cierre_v' => $this->obtener_fecha_letra($uga[0]['horario_cierre_V'],'H:i'),
            'direccion' => $uga[0]['direccion'],
        ];

        //dd($parametros);
 
        if( $request->plantilla=="501" ){ return ["status" =>100, "response"=> ['plantilla' => view('carpetas.plantillas.plantilla_general',$parametros)->render(), "request_usmeca" => ['solicitud'=>['documento'=>['data'=> '' ]],'respuesta'=>[]], "consumir_ws_usmeca" => 0] ]; }
        
        
        if( $request->plantilla!="501" ){

            $dirUGJ = documentos_generados::obtener_usuarios($request,['id_tipo_usuario'=>2,'id_unidad_gestion'=>$cj['id_unidad']]);
            if($dirUGJ['status']==100) $dirUGJ=$dirUGJ['response'][0];
            else $dirUGJ=["apellido_materno" =>null, "apellido_paterno" =>null, "correo" =>null, "cve_juez" =>null, "descripcion" =>null, "id_tipo_usuario" =>null, "id_unidad_gestion" =>null, "id_usuario" =>null, "nombre_unidad" =>null, "nombres" =>null, "usuario" =>null];

            // $subDirUGJ = documentos_generados::obtener_usuarios($request,['id_tipo_usuario'=>2,'id_unidad_gestion'=>$cj['id_unidad']]);
            // if($dirUGJ['status']==100) $dirUGJ=$dirUGJ['response'][0];
            // else $dirUGJ=["apellido_materno" =>null, "apellido_paterno" =>null, "correo" =>null, "cve_juez" =>null, "descripcion" =>null, "id_tipo_usuario" =>null, "id_unidad_gestion" =>null, "id_usuario" =>null, "nombre_unidad" =>null, "nombres" =>null, "usuario" =>null];
            //dd($request->plantilla);

            $ws_usmc_req = [
                'solicitud' => [
                    'idTipoSolicitud' => (int) $request->plantilla=='41' ? 2 : ( ($request->plantilla=='532' || $request->plantilla=='503') ? 1 : 0),
                    'idArea' => $materia_carpeta =='adultos' ? (int) 4 : (int) 3,
                    'fechaDocumento' => date('d-m-Y'), // fecha redacción o edición o fecha fecha firma ?
                    'fechaAudiencia' => isset($audiencia['fecha_audiencia'])? (new DateTime ($audiencia['fecha_audiencia']))->format('d-m-Y') : null,
                    'carpetaJudicial' => strlen($cj['folio_carpeta'])<50 ? $cj['folio_carpeta'] : substr($cj['folio_carpeta'],0,49),
                    'carpetaJudicialAnterior' => strlen( $cj['id_carpeta_padre'])<50 ?  $cj['id_carpeta_padre'] : substr( $cj['id_carpeta_padre'],0,49),
                    'carpetaInvestigacion' => strlen( $cj['carpeta_investigacion'])<50 ?  $cj['carpeta_investigacion'] : substr( $cj['carpeta_investigacion'],0,49),
                    'documento' => [
                        'data' => 'b64',
                        'nombreDocumento' => 'UGJ-'.$numero_ugj.'-NO-'.$parametros['numero_oficio'].'-'.date('Y').'.pdf',
                    ],
                    'imputados' => [],
                    'asunto' => strlen($asunto)<200 ? $asunto : substr($asunto,0,199),
                    'numOficio' => strlen($request->numOficio)<25 ? $request->numOficio : substr($request->numOficio,0,24), // sólo numero o UGJX/xx/YYYY
                    'nombreJuez' => isset($juez_control['nombre_completo'])? ( strlen($juez_control['nombre_completo'])<50 ? $juez_control['nombre_completo'] : substr($juez_control['nombre_completo'],0,49) ) : null,
                    'reparacionDano' => strlen($parametros['plan_reparación_danio'])<700 ? $parametros['plan_reparación_danio'] : substr($parametros['plan_reparación_danio'],0,699) ,
                    'solicitante' => [
                        'nombre' => strlen($dirUGJ['nombres'])<100 ? $dirUGJ['nombres'] : substr($dirUGJ['nombres'],0,99),
                        'primerApellido' => strlen($dirUGJ['apellido_paterno'])<50 ? $dirUGJ['apellido_paterno'] : substr($dirUGJ['apellido_paterno'],0,49),
                        'segundoApellido' => strlen($dirUGJ['apellido_materno'])<100 ? $dirUGJ['apellido_materno'] : substr($dirUGJ['apellido_materno'],0,99),
                        'numeroUGJ' => $numero_ugj,
                        'sedeUGJ' => 'UNIDAD DE GESTIÓN JUDICIAL '.$numero_ugj, // si es eso o cómo
                        'nombreRemitente' => strlen($remitente['nombre_completo'])<100 ? $remitente['nombre_completo'] : substr($remitente['nombre_completo'],0,99),
                        'cargo' => strlen($remitente['descripcion'])<100 ? $remitente['descripcion'] : substr($remitente['descripcion'],0,99),
                        'subdirectorUGJ' => null, // sub de causa o cual ?
                    ],
                ],
                'respuesta' => [
                    'estatus' => null,
                    'mensaje' => null,
                    'folio' => null,
                ]
            ];
            
            
        }
        
        if( in_array( $request->plantilla, ['41','532','503'] ) ){
            $consumir_ws_usmeca = 1;
            
            foreach( $request->imputados as $ii => $i ){
                $ws_usmc_req['solicitud']['imputados'][$ii] = [
                    'delitos' => [],
                    'fracciones' => [],
                    'plazoProceso' => strlen( $request->plazo_proceso )>50 ? substr( $request->plazo_proceso, 0, 49 ) : $request->plazo_proceso,
                    'edad' => (int) $i['info_principal']['edad'],
                    'fechaNacimiento' => $i['info_principal']['fecha_nacimiento']!=null ? (new DateTime( $i['info_principal']['fecha_nacimiento'] ))->format('d-m-Y') : null, // opcional
                    'fechaTraslado' => isset($i['info_principal']['fecha_traslado']) && $i['info_principal']['fecha_traslado']!=null ? (new DateTime( date('Y-m-d') ))->format('d-m-Y') : null, // opcional
                    'horaTraslado' => date('H:i'), // opcional
                    'nombre' => strlen( $i['info_principal']['nombre'] )>50 ? substr( $i['info_principal']['nombre'], 0, 49 ) : $i['info_principal']['nombre'],
                    'primerApellido' => strlen( $i['info_principal']['apellido_paterno'] )>50 ? substr( $i['info_principal']['apellido_paterno'], 0, 49 ) : $i['info_principal']['apellido_paterno'],
                    'segundoApellido' => strlen( $i['info_principal']['apellido_materno'] )>50 ? substr( $i['info_principal']['apellido_materno'], 0, 49 ) : $i['info_principal']['apellido_materno'], // opcional
                    'sexo' => $i['info_principal']['genero'] == 'masculino' ? 0 : ($i['info_principal']['genero'] == 'femenino' ? 1 : 2),
                    'nombreVictima' => strlen( $victimas )>100 ? substr( $victimas, 0, 99 ) : $victimas,
                    'vinculacionProceso' => 1, // por defecto se tiene 1
                    'fechaVinculacion' => isset($i['info_principal']['fecha_vinculacion_proceso']) ? (new DateTime( $i['info_principal']['fecha_vinculacion_proceso'] ))->format('d-m-Y') : null, // opcional
                ];
                if( !empty( $i['delitos'] ) ){
    
                    foreach( $i['delitos'] as $id => $d){
                        $ws_usmc_req['solicitud']['imputados'][$ii]['delitos'][] = [
                            'idDelito' => (int) $d['id_delito'],
                        ];
                    }
                }
    
                if( !empty( $request->arrItems ) ){
                    foreach( $request->arrItems as $icmc => $cmc){
                        $ws_usmc_req['solicitud']['imputados'][$ii]['fracciones'][] = [
                            'idFraccion' => (int) $cmc['id'],
                            'especificacion' => '',//strlen( $cmc['detalle_adicional'] )> 500 ? substr($cmc['detalle_adicional'], 0,499) :  $cmc['detalle_adicional'],
                            'duracion' => strlen( $cmc['duracion'] )> 50 ? substr($cmc['duracion'], 0,49) :  $cmc['duracion'],
                        ];
                    }
                }
            }
        }

        //dd($ws_usmc_req);
        //dd($parametros,$request);

        return ["status" =>100, "response"=> ['plantilla' => view('carpetas.plantillas.plantilla_general',$parametros)->render(), "request_usmeca" => $ws_usmc_req, "consumir_ws_usmeca" => $consumir_ws_usmeca] ];
    }

    public function avanzar_documento_generado_carpeta(Request $request){

        //dd('llegaste');

        $log_path = base_path().'/storage/custom_logs/'.date('Y/m/');
        if( !file_exists( $log_path ) ) mkdir( $log_path, 0777, true );
        $log = fopen($log_path. date('d') .'.ini', 'a+' );

        $time = time();
        fwrite($log, "\n\n [ ".date('d-m-Y H:i:s').' ]  - ENTRA A avanzar_documento_generado_carpeta' );

        $request_in = (object) $request->all();
        $request_in->arrAnexosDG = json_decode($request_in->arrAnexosDG);
        $request_in->request_usmeca = json_decode($request_in->request_usmeca);
        //dd($request_in);
        $avance=[];
        $anexos=[];

        
        fwrite($log, "\n".date('d-m-Y H:i:s').' REQUEST TO OBJECT , tiempo: '. ( time() - $time ) );
        $time = time();


        $contenido_documento = $request_in->contenido_documento;
        $nombre_documento =  preg_replace('([^A-Za-z0-9-_-])', '', $this->eliminar_acentos(str_replace(' ','_',$request_in->nombre_documento)));

        fwrite($log, "\n".date('d-m-Y H:i:s').' PROCESA NOMBRE DOCUMENTO , tiempo: '. ( time() - $time ) );
        $time = time();

        $ruta_local = base_path().'/storage/temp_exportaciones/';
        $random = date('YmdHisu').rand();
        $extension_archivo = 'html';
        $ruta_ar_local = $ruta_local.$nombre_documento.$random.'.'.$extension_archivo;

        $tamanio_archivo = 0;
        
        if($request->origen_contenido_oficio=='editor'){
            file_put_contents($ruta_ar_local, $contenido_documento );  

            fwrite($log, "\n".date('d-m-Y H:i:s').' DOCUMENTO TEMPORAL EN LOCAL , tiempo: '. ( time() - $time ) );
            $time = time();

            $pdf_url_local = str_replace('.html','.pdf',$ruta_ar_local);
            if( ! documentos_generados::save_html_to_pdf($contenido_documento,$pdf_url_local) ) return ['status'=>0, 'message'=>'Error al generar PDF'];
            
            $tamanio_archivo = filesize ( $ruta_ar_local )/1048576;
            //$extension_archivo = 'html'; 
        } 
        else{
            $tamanio_archivo = $contenido_documento->getSize();
            $explode = explode('.', $contenido_documento->getClientOriginalName());
            $extension_archivo = end( $explode );
            $nombre_documento .= '_'.preg_replace('([^A-Za-z0-9-_-])', '', $this->eliminar_acentos(str_replace(' ','_',$explode[1])));
            
            
            $doc_pdf = carpeta_judicial::word_a_pdf($request, $contenido_documento);
            $ruta_ar_local = $doc_pdf['word_ruta_local'];
            $pdf_url_local = $doc_pdf['file'];
            //dd($doc_pdf);
            
        }


        fwrite($log, "\n".date('d-m-Y H:i:s').' CONVERSION DE HTML A PDF EN LOCAL , tiempo: '. ( time() - $time ) );
        $time = time();

        $documento = [
            "carpeta" => $request_in->carpeta,
            "id_tipo_archivo"=> $request_in->id_tipo_archivo,
            "id_tipo_plantilla"=> $request_in->id_tipo_plantilla,
            "nombre_archivo" => $nombre_documento,
            "extension_archivo" => $extension_archivo,
            "tamanio_archivo"=> $tamanio_archivo,
            "estatus"=>1,
            "b64"=>base64_encode(file_get_contents($ruta_ar_local)),
            "motivos"=>"-",
            "oficio"=>1,
            "request_usmeca"=> $request_in->request_usmeca,
            "bandera_consumir_ws_usmeca"=>$request_in->consumir_ws_usmeca,
            "anexos" => [],
        ];
        //dd($documento);
        $response = documentos_generados::guardar_documento($request, $documento);

        fwrite($log, "\n".date('d-m-Y H:i:s').' GUARDA DOCUMENTO EN LOCAL , tiempo: '. ( time() - $time ) );
        $time = time();

        // dd($response);
        if($response["status"]!=100) return $response;

        $id_documento = $response['response']['id_documento'];
        //unlink($ruta_ar_local);

        if( $request_in->avance=='enviar' ){

            if( $request->session()->get('id_tipo_usuario') == 3 ){ // sub de causa
                foreach( $request_in->arrAnexosDG as $d ){
                    $ruta_local = base_path().'/storage/temp_exportaciones_CJ/';
                    $random = date('YmdHis').rand();
                    $ruta_ar_local = $ruta_local.$d->nombre_archivo.'-'.$random.'.pdf';
                    
                    file_put_contents($ruta_ar_local, base64_decode($d->b64) );
    
                    if( file_exists($ruta_ar_local) && is_file($ruta_ar_local) ) $documentos_por_unir[] = $ruta_ar_local;
    
                    $anexos[]=[
                        "id_documento" => '-',
                        "carpeta" => $request_in->carpeta,
                        "id_tipo_archivo"=> 61,
                        "nombre_archivo" => $d->nombre_archivo,
                        "extension_archivo" => $d->extension_archivo,
                        "tamanio_archivo"=> $d->tamanio_archivo,
                        "estatus"=> 1,
                        "b64"=> $d->b64,
                        "motivos"=>"-",
                        "anexos" => [],
                    ];
                }
            }

            $avance = [
                'id_unidad_gestion'=>$request_in->id_unidad,
                'id_documento'=>$id_documento,
                'id_carpeta_judicial'=>$request_in->carpeta,
                'tipo_avance'=>'firma',
                'id_usuario_destino'=>$request_in->id_usuario_destino,
                'tamanio_archivo'=>$documento['tamanio_archivo'],
                'extension_archivo'=>$documento['extension_archivo'],
                'b64_archivo'=>$documento['b64'],
                'b64_pdf'=>base64_encode(file_get_contents($pdf_url_local)),
                'anexos' => $anexos,
                //'b64_pdf'=>base64_encode(documentos_generados::html_to_pdf(base64_decode($documento['b64']))),
            ];
            //dd($avance);
        }

        if($request_in->tipo_firma=='firma_autografa'){
            //unlink($pdf_url_local);
            //dd(base64_decode($request_in->b64_doc_firmado));
            file_put_contents($pdf_url_local,base64_decode($request_in->b64_doc_firmado));
            $avance = [
                'id_unidad_gestion'=>$request_in->id_unidad,
                'id_documento'=>$id_documento,
                'id_carpeta_judicial'=>$request_in->carpeta,
                'tipo_avance'=>'firma',
                'id_usuario_destino'=>$request_in->id_usuario_destino,
                'tamanio_archivo'=>filesize ( $pdf_url_local ),
                'extension_archivo'=>'html',
                'b64_archivo'=>$documento['b64'],
                'b64_pdf'=>$request_in->b64_doc_firmado,
            ];
            //unlink($pdf_url_local);
        }

        //$pdf_url_local=null;

        if($request_in->avance=='firmar' and $request_in->tipo_firma!='firma_autografa'){

            fwrite($log, "\n".date('d-m-Y H:i:s').' COMIENZA FIRMADO , tiempo: '. ( time() - $time ) );
            $time = time();

            $firmar =false;
            $url_cer=null;
            $url_key=null;

            if($request_in->tipo_firma=='firel_tsj' || $request_in->tipo_firma=='fiel_tsj' || $request->tipo_firma=='firel_csj'){
                if($request_in->tipo_firma=='firel_tsj' || $request->tipo_firma=='firel_csj' ){

                    if(!isset($request_in->archivo_pfx)){
                        $error=['error'=>1,'mensaje'=>'El archivo PFX es obligatorio.'];
                        //LOG
                        //utilidades::guardarLog($request_in, 'firma_juzgado', $proceso, 4, $error['mensaje']);
                        //utilidades::guardarLog($request_in, 'firma_juzgado', $proceso, 3, "");
                        return response()->json($error);
                    }

                    if($request_in->archivo_pfx->isValid()){
                        $url_cer=base_path().'/storage/app/'.$request_in->archivo_pfx->store('private');
                        $firmar=true;
                    }

                } else if($request_in->tipo_firma=='fiel_tsj'){
                    if(!isset($request_in->archivo_key)){
                        $error=['error'=>1,'mensaje'=>'El archivo KEY es obligatorio.'];
                        //LOG
                        //utilidades::guardarLog($request_in, 'firma_juzgado', $proceso, 4, $error['mensaje']);
                        //utilidades::guardarLog($request_in, 'firma_juzgado', $proceso, 3, "");

                        return response()->json($error);
                    }
                    if(!isset($request_in->archivo_cer)){
                        $error=['error'=>1,'mensaje'=>'El archivo CER es obligatorio.'];
                        //LOG
                        //utilidades::guardarLog($request_in, 'firma_juzgado', $proceso, 4, $error['mensaje']);
                        //utilidades::guardarLog($request_in, 'firma_juzgado', $proceso, 3, "");
                        return response()->json($error);
                    }
                    // Guardado de certificados
                    if($request_in->archivo_key->isValid()){
                        $url_key=base_path().'/storage/app/'.$request_in->archivo_key->store('private');
                        $firmar=true;
                    }
                    else{
                        $firmar=false;
                    }
                    if($request_in->archivo_cer->isValid()){
                        $url_cer=base_path().'/storage/app/'.$request_in->archivo_cer->store('private');
                        $firmar=true;
                    }
                    else{
                        $firmar=false;
                    }

                }
                //return "llegaste bien mano ".$url_cer;
            }

            if($firmar){
                fwrite($log, "\n".date('d-m-Y H:i:s').' SE MANDA A SELLAR, tiempo: '. ( time() - $time ) );
                $time = time();
                
                $pdf_sellado = bandejas::obtener_QR($request, [ 'documento_nombre_publico' => $nombre_documento , 'documento_url_local' => $pdf_url_local ] );
                if( $pdf_sellado['status'] != 100  ) return $pdf_sellado;

                $pdf_url_local = $pdf_sellado['url_local'];
                
                fwrite($log, "\n".date('d-m-Y H:i:s').' TERMINA SELLADO, tiempo: '. ( time() - $time ) );
                $time = time();

                fwrite($log, "\n".date('d-m-Y H:i:s').' SE MANDA A FIRMAR '.$request_in->tipo_firma.' , tiempo: '. ( time() - $time ) );
                $time = time();


                $pdf_firmado = null;

                //se manda a firmar
                if($request_in->tipo_firma=='firel_tsj' || $request_in->tipo_firma=='fiel_tsj'){
                    
                    $pdf_firmado=documentos_generados::firmar_documento_firma_judicial($request, $pdf_url_local, $url_cer, $url_key, $request_in->password);

                }else if( $request->tipo_firma=='firel_csj' ){
                    
                    $pdf_firmado = bandejas::obtener_firma_firel_acuerdo( $request, $pdf_url_local, $url_cer, $url_key, $request_in->password );

                } 

                fwrite($log, "\n".date('d-m-Y H:i:s').' TERMINA FIRMADO , tiempo: '. ( time() - $time ) );
                $time = time();
                
                if($pdf_firmado['resultado']!=1){
                    $error['error']=1;
                    $error['mensaje']=  $request->tipo_firma=='firel_csj' ? $pdf_firmado['mensaje'] : $pdf_firmado['msj'];
                    return response()->json($error);
                }
                
                $pdf_url_local= str_replace('.pdf','-firmado.pdf',$pdf_url_local);
                
                file_put_contents($pdf_url_local, base64_decode( $pdf_firmado['documento']));

                $avance = [
                    'id_unidad_gestion'=>$request_in->id_unidad,
                    'id_documento'=>$id_documento,
                    'id_carpeta_judicial'=>$request_in->carpeta,
                    'tipo_avance'=>'firma',
                    'id_usuario_destino'=>$request_in->id_usuario_destino,
                    'tamanio_archivo'=>filesize ( $pdf_url_local ),
                    'extension_archivo'=>'html',
                    'b64_archivo'=>$documento['b64'],
                    'b64_pdf'=>base64_encode(file_get_contents($pdf_url_local)),
                ];
                
            }else{ fwrite($log, "\n".date('d-m-Y H:i:s').' NO SE MANDA A FIRMAR , tiempo: '. ( time() - $time ) );  return ['status'=>0, 'message'=>'Error al firmar'];}
            $time = time();
        }

        fwrite($log, "\n".date('d-m-Y H:i:s').' ARMA REQUEST PARA USMECA '. ( time() - $time ) );
        $time = time();

        if( $request_in->tipo_firma=='firma_autografa' || $request_in->avance=='firmar' ){
            
            $documentos_por_unir = [ $pdf_url_local ];

            $anexos = [];

            fwrite($log, "\n".date('d-m-Y H:i:s').' CICLO DE ANEXOS EN TEMPORAL LOCAL , tiempo: '. ( time() - $time ) );
            $time = time();
            foreach( $request_in->arrAnexosDG as $d ){
                $ruta_local = base_path().'/storage/temp_exportaciones_CJ/';
                $random = date('YmdHis').rand();
                $ruta_ar_local = $ruta_local.$d->nombre_archivo.'-'.$random.'.pdf';
                
                file_put_contents($ruta_ar_local, base64_decode($d->b64) );

                if( file_exists($ruta_ar_local) && is_file($ruta_ar_local) ) $documentos_por_unir[] = $ruta_ar_local;

                $anexos[]=[
                    "id_documento" => '-',
                    "carpeta" => $request_in->carpeta,
                    "id_tipo_archivo"=> 61,
                    "nombre_archivo" => $d->nombre_archivo,
                    "extension_archivo" => $d->extension_archivo,
                    "tamanio_archivo"=> $d->tamanio_archivo,
                    "estatus"=> 1,
                    "b64"=> $d->b64,
                    "motivos"=>"-",
                    "anexos" => [],
                ];
            }
            fwrite($log, "\n".date('d-m-Y H:i:s').'SE MANDA A COSER , tiempo: '. ( time() - $time ) );
            $time = time();
            $ruta_ar_unido = $ruta_local.'oficio-firmado-anexos'.'-'.date('YmdHis').rand().'.pdf';
            $unidos = carpeta_judicial::coser_documentos_pdf($documentos_por_unir, $ruta_ar_unido);
            if($unidos['status']==100) $request_in->request_usmeca->solicitud->documento->data = base64_encode( file_get_contents( $unidos['ruta_local'] ) );
            fwrite($log, "\n".date('d-m-Y H:i:s').'TERMINA COCIMIENTO, tiempo: '. ( time() - $time ) );
            $time = time();
            $avance['request_usmeca'] =$request_in->request_usmeca;
            $avance['anexos'] = $anexos;
        }
        //dd($avance['anexos'],$avance['id_unidad_gestion']);
        fwrite($log, "\n".date('d-m-Y H:i:s').'SE MANDA AVANZAR FLUJO , tiempo: '. ( time() - $time ) );
        $time = time();
        $response_avance = documentos_generados::flujo_documento($request, $avance);
        fwrite($log, "\n".date('d-m-Y H:i:s').'FLUJO AVANZADO , tiempo: '. ( time() - $time ) );
        $time = time();
        fclose($log);
        return $response_avance;
    }

    public function obtener_archivo_firma_autografa(Request $request){
        $request_o = (object) $request->all();

        $contenido_documento = $request_o->contenido_documento;
        $nombre_documento =  preg_replace('([^A-Za-z0-9-_-])', '', $this->eliminar_acentos(str_replace(' ','_',$request_o->nombre_documento)));

        if( $request_o->origen_contenido_oficio=='editor'){

            $ruta_local = base_path().'/storage/pdf_solicitudes/';
            $random = date('YmdHis').rand();
            $nombre_documento.=$random.'.pdf';
            $ruta_ar_local = $ruta_local.$nombre_documento;
    
            if( ! documentos_generados::save_html_to_pdf($contenido_documento,$ruta_ar_local) ) return ['status'=>0, 'message'=>'Error al generar PDF'];

            //  return ['status'=>100,'response'=>"/documento_solicitud/".$nombre_documento];
    
        }else{
            $doc_pdf = carpeta_judicial::word_a_pdf($request, $contenido_documento);
            //return ['status'=>100,'response'=>$doc_pdf['url_pdf']];
        }

        //if( true ){
            
            $param = [
                'documento_nombre_publico' => $request_o->nombre_documento,
                'documento_url_local' => $ruta_ar_local,
            ];

            $mide = bandejas::obtener_QR( $request, $param );

            if( $mide['status'] == 100 ) unset($mide['message']);

            return $mide;

        //}  else  return ['status'=>100,'response'=>"/documento_solicitud/".$nombre_documento];
         
    }

    public function obtener_ultima_version_documento_generado(Request $request){
        //dd($request);
        $modo = isset($request->modo)?$request->modo:'pdf';
        //dd($modo);
        if( !in_array($modo,['pdf','html']) ) return ['status'=>0, 'message'=>'Error - modo no identificado'];
        $response = documentos_generados::obtener_ultima_version($request, $request->carpeta, $request->id_documento, $modo=='pdf'?$modo:'archivo');
        if($response['status'] != 100) return $response;
        if($modo=='pdf') return ['status'=>100, 'response'=>$response['response'], "request_usmeca" => $response['request_usmeca']];
        //dd($response);
        if(in_array($modo,['text','html','archivo'])){
            if( !in_array ($response['extension'] , ['docx', 'doc'])   )  return['status'=>100, 'response'=>$response['contenido'], "request_usmeca" => $response['request_usmeca'],  "extension" => $response['extension']];
            else return ['status'=>100, 'response'=>$response['response'], "request_usmeca" => $response['request_usmeca'], "extension" => $response['extension']];
        }
    }

    public function actualizar_documento_generado(Request $request){
        $request_a = (object) $request->all();
        $estatus = isset($request_a->estatus_documento)?$request_a->estatus_documento:1;
        $documento=null;
        if($estatus==1){
            $nombre_documento=$request_a->nombre_documento;
            $contenido_documento=$request_a->contenido_documento;
            $ruta_local = base_path().'/storage/temp_exportaciones/';
            $random = date('YmdHis').rand();
            $extension_archivo = 'html';
            $html_ruta_ar_local = $ruta_local.$nombre_documento.$random.'.'.$extension_archivo;
            $tamanio_archivo = 0;

            if( $request_a->origen_contenido_oficio != 'editor' ){

                $tamanio_archivo = $contenido_documento->getSize();
                $explode = explode('.', $contenido_documento->getClientOriginalName());
                $extension_archivo = end( $explode );
                $nombre_documento .= '_'.preg_replace('([^A-Za-z0-9-_-])', '', $this->eliminar_acentos(str_replace(' ','_',$explode[1])));
                
                
                $doc_pdf = carpeta_judicial::word_a_pdf($request, $contenido_documento);
                $html_ruta_ar_local = $doc_pdf['word_ruta_local'];
                $pdf_ruta_local = $doc_pdf['file'];

            }else{

                file_put_contents($html_ruta_ar_local, $contenido_documento );
    
                $pdf_ruta_local = str_replace('.html','.pdf',$html_ruta_ar_local);
                if( ! documentos_generados::save_html_to_pdf($contenido_documento,$pdf_ruta_local) ) return ['status'=>0, 'message'=>'Error al generar PDF'];
                $tamanio_archivo =filesize ( $html_ruta_ar_local )/1048576;
            }


            $documento = [
                "carpeta" => $request_a->carpeta,
                "id_documento" => $request_a->id_documento,
                "nombre" => $nombre_documento,
                "extension" => $extension_archivo,
                "tamanio"=> $tamanio_archivo,
                "b64_doc"=>base64_encode(file_get_contents($html_ruta_ar_local)),
                "b64_pdf"=>base64_encode(file_get_contents($pdf_ruta_local)),
                "request_usmeca"=>$request_a->request_a_usmeca,
                "estatus"=>1,
            ];
        }else{
            $documento = [
                "carpeta" => $request_a->carpeta,
                "id_documento" => $request_a->id_documento,
                "nombre" => '-',
                "extension" => '-',
                "tamanio"=> '-',
                "b64_doc"=>'-',
                "b64_pdf"=>'-',
                "request_usmeca"=>'-',
                "estatus"=>0,
            ];
        }

        return documentos_generados::actualizar_documento($request,$documento);
    }

    public function obtener_audiencias_viejo_penal(Request $request){
        $filtro=[
            // "id_audiencia"=> isset($request->id_audiencia)?$request->id_audiencia:"-",
            "id_cj"=> isset($request->carpeta_judicial)?$request->carpeta_judicial:"-",
            // "id_unidad"=> isset($request->id_unidad)?$request->id_unidad:"-",
            // "id_inmueble"=> isset($request->id_inmueble)?$request->id_inmueble:"-",
            // "id_sala"=> isset($request->id_sala)?$request->id_sala:"-",
            // "id_juez"=> isset($request->id_juez)?$request->id_juez:"-",
            // "fecha_min"=> isset($request->fecha_min)?$request->fecha_min:"-",
            // "fecha_max"=> isset($request->fecha_max)?$request->fecha_max:"-",
            // "pagina"=>isset($request->pagina)?$request->pagina:1,
            // "registros_por_pagina"=>isset($request->registros_por_pagina)?$request->registros_por_pagina:10,
        ];
        //dd($filtro);
        $res_aud_n = audiencias::obtener_audiencias($request, $filtro);
        $res_aud_v = carpeta_judicial::obtener_audiencias_viejo_penal($request, $request->carpeta_judicial);
        $audiencias = [];
        //dd($res_aud_v, $res_aud_n);
        if( $res_aud_n['status'] == 100 and $res_aud_v['status']==100 ) $audiencias = array_merge($res_aud_n['response'], $res_aud_v['response']);
        else $audiencias = $res_aud_n['status'] == 100 ? $res_aud_n['response'] : ( $res_aud_n['status']==100 ? $res_aud_v['response'] : [] );

        if( !empty($audiencias) ) return ['status'=>100, 'response'=> $audiencias ];
        else return ['status'=>0, 'message' => 'sin registro de audiencias'];
    }

    public function enviar_solicitud_usmeca( Request $request ){

        $ultima_v = documentos_generados::obtener_ultima_version($request,$request->carpeta, $request->id_documento, 'pdf');
        
        if( $ultima_v['status'] != 100 ) return $ultima_v;
        
        $ultima_v['request_usmeca'] = json_decode($ultima_v['request_usmeca']);
        //dd($ultima_v);

        $por_cocer = [];
        $por_cocer[] = $ultima_v['ruta_local'];

        foreach( explode( ',', $ultima_v['documentos_anexados']) as $i => $id_anexo){
            $anexo = carpeta_judicial::obtener_documento_asociado($request, $request->carpeta, $id_anexo);
            if( $anexo['status'] ==100) $por_cocer[] = $anexo['ruta_local'];
        }

        $ruta_local_cocidos = base_path().'/storage/temp_exportaciones_CJ/'.'oficio-firmado-anexos'.'-'.date('YmdHis').rand().'.pdf';

        $unidos = carpeta_judicial::coser_documentos_pdf($por_cocer, $ruta_local_cocidos);
        
        if($unidos['status']==100) $ultima_v['request_usmeca']->solicitud->documento->data = base64_encode( file_get_contents( $unidos['ruta_local'] ) );
        
        return documentos_generados::enviar_solicitud_usmeca($request, $request->id_documento, $ultima_v['request_usmeca'] );

    }

    /******* HISTORIALES CONSULTABLES EN CARPETAS JUDICIALES *******/

    public function consulta_historial(Request $request){
        switch ($request->historial) {
            case 'delitos':
                $response = $request
                ->clienteWS_penal
                ->request('GET', 'historial_delito/'.$request->session()->get("usuario-id").'/'.$request->id_solicitud.'/'.$request->id_delito,[
                    "headers" => [
                        "sesion-id" => $request->session()->get("sesion-id"),
                        "cadena-sesion" => $request->session()->get("cadena-sesion"),
                        "usuario-id" => $request->session()->get("usuario-id"),
                        "Content-Type" => "application/json"
                    ],
                    "json" => [
                        "datos" => [],
                    ]
                ]);
                $response = json_decode($response->getBody(),true);
                return $response;
                break;
            case 'archivos':
                if($request->documento_origen=='SOLICITUD'){
                    return ['status'=>0,"message"=>"OPS! - En desarrollo"];
                }else if($request->documento_origen == 'CJ'){

                    $response = $request
                    ->clienteWS_penal
                    ->request('POST', 'documento_carpeta_judicial/'.Session::get('usuario_id').'/'.$request->carpeta.'/'.$request->id_documento.'/HISTORIAL',[
                        "headers" => [
                            "sesion-id" => $request->session()->get("sesion-id"),
                            "cadena-sesion" => $request->session()->get("cadena-sesion"),
                            "usuario-id" => $request->session()->get("usuario-id"),
                            "Content-Type" => "application/json"
                        ],
                        "json" => [
                            "datos" => [],
                        ]
                    ]);
                    $response = json_decode($response->getBody(),true);
                    return $response;
                }else return ['status'=>0,"message"=>"origen documento no desconocido"];
                break;
            default:
                return ['status'=>0,'message'=>'historial no existente'];
                break;
        }
    }


    /******+ AUDIENCIAS ******/
    public function consulta_audiencias(Request $request){

        $filtro=[
            "id_audiencia"=> isset($request->id_audiencia)?$request->id_audiencia:"-",
            "id_cj"=> isset($request->carpeta)?$request->carpeta:"-",
            "id_unidad"=> isset($request->id_unidad)?$request->id_unidad:"-",
            "id_inmueble"=> isset($request->id_inmueble)?$request->id_inmueble:"-",
            "id_sala"=> isset($request->id_sala)?$request->id_sala:"-",
            "id_juez"=> isset($request->id_juez)?$request->id_juez:"-",
            "fecha_min"=> isset($request->fecha_min)?$request->fecha_min:"-",
            "fecha_max"=> isset($request->fecha_max)?$request->fecha_max:"-",
            "pagina"=>isset($request->pagina)?$request->pagina:1,
            "registros_por_pagina"=>isset($request->registros_por_pagina)?$request->registros_por_pagina:10,
        ];
        //dd($filtro);
        return audiencias::obtener_audiencias($request, $filtro);
    }

    public function modificar_estatus_audiencia_cj( Request $request ){
        return audiencias::modificar_estatus_audiencia( $request, $request->session()->get("usuario-id"), $request->id_unidad, $request->id_audiencia, $request->estatus, $request->motivos );
    }

    /****** VIDA CARPETA *******/
    public function consulta_vida_carpeta(Request $request){
        $response = $request
        ->clienteWS_penal
        ->request('GET', 'consultar_vida_carpeta_judicial/'.$request->id_carpeta,[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
        ]);
        $res_ev = json_decode($response->getBody(),true);

        if( $res_ev['status'] !=100) return $res_ev;

        return $res_ev;
    }


    /*** CONSULTA ACUERDOS EN CARPETA JUDICIAL */
    public function consulta_acuerdos_carpeta(Request $request){
        $filtro = [];

        if ( isset($request->id_unidad) && $request->id_unidad!=null) $filtro["id_unidad"] = $request->id_unidad;
        else $filtro["id_unidad"] = "-";
        if ( isset($request->tipo_documento) && $request->tipo_documento!=null) $filtro["tipo_documento"] = $request->tipo_documento;
        else $filtro["tipo_documento"] = "-";
        if ( isset($request->folio_carpeta) && $request->folio_carpeta!=null) $filtro["folio_carpeta"] = $request->folio_carpeta;
        else $filtro["folio_carpeta"] = "-";
        if ( isset($request->id_acuerdo) && $request->id_acuerdo!=null) $filtro["id_acuerdo"] = $request->id_acuerdo;
        else $filtro["id_acuerdo"] = "-";
        if ( isset($request->id_carpeta_judicial) && $request->id_carpeta_judicial!=null) $filtro["id_carpeta_judicial"] = $request->id_carpeta_judicial;
        else $filtro["id_carpeta_judicial"] = "-";
        if ( isset($request->pagina) && $request->pagina!=null) $filtro["pagina"] = $request->pagina;
        else $filtro["pagina"] = 1;
        if ( isset($request->registros_por_pagina) && $request->registros_por_pagina!=null) $filtro["registros_por_pagina"] = $request->registros_por_pagina;
        else $filtro["registros_por_pagina"] = 10;

        $response = $request
        ->clienteWS_penal
        ->request('GET', 'consultar_acuerdos/'.$request->id_carpeta,[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json" => [
                "datos"=>[
                    "id_unidad"=>$filtro["id_unidad"],
                    "tipo_documento"=>$filtro["tipo_documento"],
                    "folio_carpeta"=>$filtro["folio_carpeta"],
                    "id_acuerdo"=>$filtro["id_acuerdo"],
                    "id_carpeta_judicial"=>$filtro["id_carpeta_judicial"],

                ],
                "paginacion"=>[
                    "pagina"=>$filtro["pagina"],
                    "registros_por_pagina"=>$filtro["registros_por_pagina"]
                ]
            ]
        ]);
        $response = json_decode($response->getBody(),true);
        if (isset($request->obtener_archivo)&&$request->obtener_archivo){
            foreach($response["response"] as $index=>$a){
                $res_doc =  archivos::obtener_ultima_version_acuerdo( $request, $a["id_acuerdo"], "pdf");
                $response["response"][$index]['documento']  = $res_doc;
                $response["response"][$index]['documento']['b64']  =  $res_doc['status']==100?base64_encode(file_get_contents($res_doc['ruta_local'])):'';
            }
        }

        return $response;
    }

    public function consulta_remisiones_carpeta(Request $request){

        $modo = isset($request->modo)?$request->modo:'listado';
        $response = $request
        ->clienteWS_penal
        ->request('GET', 'consultar_remisiones',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json" => [
                "datos"=>[
                    "modo" => $modo,
                    "id_remision" => "-",
                    "carpeta_judicial" => "-",
                    "folio_carpeta_rem" => "-",
                    "tipo_remision" => "-",
                    "folio" => "-",
                    "fecha_registro_min" => "-",
                    "fecha_registro_max" => "-",
                    "autorizacion" => "si",
                    "id_carpeta_judicial" => $request->carpeta,
                    "id_Carpeta_judicial_rem" => "-",
                ],
                "paginacion"=>[
                    "pagina"=>1,
                    "registros_por_pagina"=>100
                ]
            ]
        ]);
        $response = json_decode($response->getBody(),true);

        return $response;
    }

    /** FUNCTION  */

    /**FUNCIONES PRIVADAS */
    private function obtener_fecha_letra($fecha,$formato){
        $days = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
        $dias = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");

        $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
        $mes = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $fecha = (new DateTime($fecha))->format($formato);
        $fecha = str_replace($months,$mes,$fecha);
        $fecha = str_replace($days,$dias,$fecha);
        return $fecha;
    }

    private function eliminar_acentos($cadena){

        //$cadena = utf8_decode($cadena);

		//Reemplazamos la A y a
		$cadena = str_replace(
		array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
		array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
		$cadena
		);

		//Reemplazamos la E y e
		$cadena = str_replace(
		array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
		array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
		$cadena );

		//Reemplazamos la I y i
		$cadena = str_replace(
		array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
		array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
		$cadena );

		//Reemplazamos la O y o
		$cadena = str_replace(
		array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
		array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
		$cadena );

		//Reemplazamos la U y u
		$cadena = str_replace(
		array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
		array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
		$cadena );

		//Reemplazamos la N, n, C y c
		$cadena = str_replace(
		array('Ñ', 'ñ', 'Ç', 'ç'),
		array('N', 'n', 'C', 'c'),
		$cadena
		);

		return $cadena;
	}

    private function obtener_nombre_completo( $nombre=null, $ap=null, $am=null ){
        return ($nombre!=null?$nombre:'').($ap!=null?' '.$ap:'').($am!=null?' '.$am:'');
    }

    private function obtener_mayusculas($str=null){
        return mb_strtoupper ( $str!=null?$str:'','utf-8');
    }

    private function obtener_iniciales( $str=null, $delimitador=' '){
        if($str==null) return '';
        if($delimitador==null) return '';

        $stri='';
        foreach( array_diff( explode( $delimitador,$str), [""] ) as $i ){
            $stri=$stri.( substr( $i, 0, 1).'. ');
        }
        return $stri;
    }

    private function obtener_nombres($arrPP='',$modo='nombre_completo'){
        $return = '';
        if( is_array($arrPP) ){
            foreach ($arrPP as $pp){
                $return .= strlen($return)? ', ':''; 

                $nom = $pp['tipo']=='fisica'?$pp['nombre']:$pp['razon_social'];
                
                if( $modo=='iniciales' )  $return .= $this->obtener_iniciales( $nom, ' ');
                else $return .= $nom;
            }
        }else{
            if( $modo=='iniciales' )  $return .= $arrPP;
            else $return .= $this->obtener_iniciales( $arrPP, ' ');
        }

        return $this->obtener_mayusculas( $return );
    }

    // esto es para las partes procesales que vienen del servicio de consultar partes procesales de carpeta judicial
    private function procesa_partes_procesales( $arrPP=[]){
        if(empty($arrPP)) return [];
        $imputados = [];
        $imputados_ws = [];
        
        foreach($arrPP as $pp){
            $nom = $pp['info_principal']['tipo_persona']=='fisica'? $this->obtener_nombre_completo($pp['info_principal']['nombre'],$pp['info_principal']['apellido_paterno'],$pp['info_principal']['apellido_materno']):$pp['info_principal']['razon_social'];
            $imputados[]=[ 'nombre_completo' => $nom, 'nombre_completo_mayuscula' => $this->obtener_mayusculas($nom), 'delitos' =>$this->concatenar_delitos(isset($pp['delitos'])?$pp['delitos']:[]), 'delitos_mayuscula' =>$this->obtener_mayusculas($this->concatenar_delitos(isset($pp['delitos'])?$pp['delitos']:[] ))];
        }
        return $imputados;
    }

    private function concatenar_delitos( $arrDelitos=[]){
        if(empty($arrDelitos)) return '[SIN-DELITOS]';
        $str_delitos = '';
        foreach($arrDelitos as $d){
            $str_delitos .= strlen($str_delitos)>0?', ':'';
            $str_delitos.= $d['delito']!=null?$d['delito']:'';
        }
        return $str_delitos;
    }

    private function obtener_iniciales_nombres($arr_partes_procesales){
        $str_iniciales="";

        foreach ($arr_partes_procesales as $pp){
            $nom = $pp['tipo']=='fisica'?$pp['nombre']:$pp['razon_social'];

            $nom = explode(' ',$nom);

            foreach ($nom as $i){
                $str_iniciales .= substr($i, 0, 1).'. '; // toma inicial
            }
            $str_iniciales .= strlen($str_iniciales)? ', ':''; 
        }

        $str_iniciales = mb_strtoupper($str_iniciales, 'UTF-8');

        return $str_iniciales;
    }

    private function obtener_delitos_persona(Request $request,$id_carpeta,$id_persona){
        $pp = carpeta_judicial::obtener_partes_procesales($request,$id_carpeta);
        if($pp['status']!=100) return 'SIN DELITOS';
        $imp=null;
        //dd($pp);
        foreach($pp['response']['personas'] as $p){
            if( $p['info_principal']['id_persona']==$id_persona){
                $imp=$p;
                break;
            }
        }
        $delitos='';
        if($imp!=null && isset($imp['delitos']) ){
            foreach($imp['delitos'] as $d){
                $delitos .= strlen($delitos)>0?', ':'';
                $delitos.= $d['delito']!=null?$d['delito']:'';
                $delitos.= ' en su modalidad ';
                $delitos.= $d['nombre_modalidad']!=null?$d['nombre_modalidad']:'sin modalidad';
            }
            if(strlen($delitos)>0) return $delitos;
            else return 'SIN DELITOS RELACIONADOS';
        }
        else return 'SIN DELITOS';
    }

}



