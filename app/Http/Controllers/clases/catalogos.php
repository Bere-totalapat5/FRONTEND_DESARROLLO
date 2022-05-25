<?php
namespace App\Http\Controllers\clases;

use Illuminate\Http\Request;
use Session;

class catalogos{

    public static function delitos(Request $request, $id_delito = '' ){

        $response = $request
        ->clienteWS_penal
        ->request('post', 'ver_delitos',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json" =>
                $datos =[
                    "id_delito" => $id_delito
                ]
            
        ]);
        $delitos = json_decode($response->getBody(),true) ;

        return $delitos;
    }

    public static function calidad_juridica(Request $request){

        $response = $request
        ->clienteWS_penal
        ->request('post', 'ver_calidad_juridica',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ]
        ]);
        $calidad_juridica = json_decode($response->getBody(),true) ;

        return $calidad_juridica;
    }

    public static function ver_leyenda(Request $request, $anio){

        $response = $request
        ->clienteWS_penal
        ->request('post', 'ver_leyenda_doc',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json" => [
                "datos" => [
                    "anio" => $anio,
                ]
            ]
        ]);

        $calidad_juridica = json_decode($response->getBody(),true) ;

        return $calidad_juridica;
    }

    

    public static function tipos_audiencia( Request $request, $solicitud_inicial = '' ){

        $response = $request
        ->clienteWS_penal
        ->request('post', 'ver_ta',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json" => [ 
                "datos" => [
                    "solicitud_inicial" => $solicitud_inicial
                ]
            ]
        ]);
        $tipos_audiencia = json_decode($response->getBody(),true) ;

        return $tipos_audiencia;
    }

    public static function delegacionesCDMX(Request $request){

        $response = $request
        ->clienteWS_penal
        ->request('post', 'ver_municipios',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[
                  "cve_estado"=>"9",
                ]
            ]
        ]);
        $municipios = json_decode($response->getBody(),true) ;

        return $municipios;
      }

    public static function nacionalidades(Request $request){

        $response = $request
        ->clienteWS_penal
        ->request('post', 'ver_nacionalidades',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ]
        ]);
        $nacionalidades = json_decode($response->getBody(),true) ;

        return $nacionalidades;
    }

    public static function estado_civil(Request $request){

        $response = $request
        ->clienteWS_penal
        ->request('post', 'ver_estado_civil',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ]
        ]);
        $estado_civil = json_decode($response->getBody(),true) ;

        return $estado_civil;
    }

    public static function modalidades(Request $request, $id_delito){

        $response = $request
        ->clienteWS_penal
        ->request('post', 'ver_modalidades',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[
                    "id_delito"=>$id_delito
                ]
            ]
        ]);
        $modalidades = json_decode($response->getBody(),true) ;

        return $modalidades;
    }

    public static function calificativos(Request $request){

        $response = $request
        ->clienteWS_penal
        ->request('post', 'ver_calificativo',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ]
        ]);
        $calificativos = json_decode($response->getBody(),true) ;

        return $calificativos;
    }

    public static function fiscalias(Request $request){

        $response = $request
        ->clienteWS_penal
        ->request('post', 'ver_fiscalias',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],

        ]);
        $fiscalias = json_decode($response->getBody(),true) ;

        return $fiscalias;
    }

    public static function agencias(Request $request, $id_fiscalia){

        $response = $request
        ->clienteWS_penal
        ->request('post', 'ver_agencia',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[
                    "id_fiscalia"=>$id_fiscalia
                ]
            ]
        ]);
        $agencias = json_decode($response->getBody(),true) ;

        return $agencias;
    }
    //#############################
    public static function paises(Request $request, $id_pais = '-' ){

        $response = $request
        ->clienteWS_penal
        ->request('post', 'ver_paises',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json" => [
                "datos" => [
                    "id_pais" => $id_pais,
                ]
            ]
        ]);
        $paises = json_decode($response->getBody(),true);

        return $paises;
    }
    
    public static function discapacidades(Request $request, $id_discapacidad = '-' ){

        $response = $request
        ->clienteWS_penal
        ->request('post', 'ver_discapacidades',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json" => [
                "datos" => [
                    "id" => $id_discapacidad,
                ]
            ]
        ]);
        $discapacidades = json_decode($response->getBody(),true);

        return $discapacidades;
    }

    public static function condicion_migratoria(Request $request, $id_condicion_migratoria = '-' ){

        $response = $request
        ->clienteWS_penal
        ->request('post', 'ver_condicion_migratoria',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json" => [
                "datos" => [
                    "id" => $id_condicion_migratoria,
                ]
            ]
        ]);
        $condicion_migratoria = json_decode($response->getBody(),true);

        return $condicion_migratoria;
    }

    public static function lengua_extranjera(Request $request, $id_lengua_extranjera = '-' ){

        $response = $request
        ->clienteWS_penal
        ->request('post', 'ver_lengua_extranjera',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json" => [
                "datos" => [
                    "id" => $id_lengua_extranjera,
                ]
            ]
        ]);
        $lengua_extranjera = json_decode($response->getBody(),true);

        return $lengua_extranjera;
    }

    public static function relacion_imputado(Request $request, $id_relacion_imputado = '-' ){

        $response = $request
        ->clienteWS_penal
        ->request('post', 'ver_relacion_imputado',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json" => [
                "datos" => [
                    "id_relacion_imputado" => $id_relacion_imputado,
                ]
            ]
        ]);
        $relacion_imputado = json_decode($response->getBody(),true);

        return $relacion_imputado;
    }

    public static function actos_investigacion(Request $request, $id_acto_investigacion = '-' ){

        $response = $request
        ->clienteWS_penal
        ->request('post', 'ver_actos_investigacion',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json" => [
                "datos" => [
                    "id_acto_investigacion" => $id_acto_investigacion,
                ]
            ]
        ]);
        $acto_investigacion = json_decode($response->getBody(),true);

        return $acto_investigacion;
    }

    public static function tipo_solucion_alterna(Request $request, $id_tipo_solucion_alterna = '-' ){

        $response = $request
        ->clienteWS_penal
        ->request('post', 'ver_tipo_solucion_alterna',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json" => [
                "datos" => [
                    "id_tipo_solucion_alterna" => $id_tipo_solucion_alterna,
                ]
            ]
        ]);
        $tipo_solucion_alterna = json_decode($response->getBody(),true);

        return $tipo_solucion_alterna;
    }
    
    public static function tipo_sobreseimiento(Request $request, $id_tipo_sobreseimiento = '-' ){

        $response = $request
        ->clienteWS_penal
        ->request('post', 'ver_tipo_sobreseimiento',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json" => [
                "datos" => [
                    "id_tipo_sobreseimiento" => $id_tipo_sobreseimiento,
                ]
            ]
        ]);
        $tipo_sobreseimiento = json_decode($response->getBody(),true);

        return $tipo_sobreseimiento;
    }

    public static function tipo_reparacion_danio(Request $request, $id_tipo_reparacion_danio = '-' ){

        $response = $request
        ->clienteWS_penal
        ->request('post', 'ver_tipo_reparacion_danio',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json" => [
                "datos" => [
                    "id_tipo_reparacion_danio" => $id_tipo_reparacion_danio,
                ]
            ]
        ]);
        $tipo_reparacion_danio = json_decode($response->getBody(),true);

        return $tipo_reparacion_danio;
    }

    public static function reparacion_danio(Request $request, $id_reparacion_danio = '-' ){

        $response = $request
        ->clienteWS_penal
        ->request('post', 'ver_reparacion_danio',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json" => [
                "datos" => [
                    "id_reparacion_danio" => $id_reparacion_danio,
                ]
            ]
        ]);
        $reparacion_danio = json_decode($response->getBody(),true);

        return $reparacion_danio;
    }

    public static function modalidad_reparacion_danio(Request $request, $id_modalidad_reparacion_danio = '-' ){

        $response = $request
        ->clienteWS_penal
        ->request('post', 'ver_modalidad_reparacion_danio',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json" => [
                "datos" => [
                    "id_modalidad_reparacion_danio" => $id_modalidad_reparacion_danio,
                ]
            ]
        ]);
        $modalidad_reparacion_danio = json_decode($response->getBody(),true);

        return $modalidad_reparacion_danio;
    }

    public static function catalogo_comision(Request $request, $id_elemento_comision_delito = '-' ){

        $response = $request
        ->clienteWS_penal
        ->request('post', 'ver_catalogo_comision',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json" => [
                "datos" => [
                    "id_elemento_comision_delito" => $id_elemento_comision_delito,
                ]
            ]
        ]);
        $catalogo_comision = json_decode($response->getBody(),true);

        return $catalogo_comision;
    }

    public static function catalogo_modalidad_agresion(Request $request, $id_modalidad_agresion = '-' ){

        $response = $request
        ->clienteWS_penal
        ->request('post', 'ver_catalogo_modalidad_agresion',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json" => [
                "datos" => [
                    "id_modalidad_agresion" => $id_modalidad_agresion,
                ]
            ]
        ]);
        $catalogo_modalidad_agresion = json_decode($response->getBody(),true);

        return $catalogo_modalidad_agresion;
    }

    //#############################
    public static function estados(Request $request, $id_estado = '-' ){

        $response = $request
        ->clienteWS_penal
        ->request('post', 'ver_estados',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json" => [
                "datos" => [
                    "id_estado" => $id_estado,
                ]
            ]
        ]);
        $estados = json_decode($response->getBody(),true) ;

        return $estados;
    }

    public static function municipios(Request $request, $id_estado){

        $response = $request
        ->clienteWS_penal
        ->request('post', 'ver_municipios',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[
                    "cve_estado"=>$id_estado
                ]
            ]
        ]);
        $municipios = json_decode($response->getBody(),true) ;

        return $municipios;
    }

    public static function solicitudes(Request $request){

        $response = $request
        ->clienteWS_penal
        ->request('get', 'consultar_solicitudes',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ]


        ]);
        $solicitudes = json_decode($response->getBody(),true) ;

        return $solicitudes;
    }

    public static function unidades_investigacion(Request $request){

        $response = $request
        ->clienteWS_penal
        ->request('post', 'ver_unidades_inv',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ]
        ]);
        $unidades_investigacion = json_decode($response->getBody(),true) ;

        return $unidades_investigacion;
    }

    public static function obtener_escolaridades(Request $request){

        $response = $request
        ->clienteWS_penal
        ->request('post', 'ver_escolaridad',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ]
        ]);
        $escolaridades = json_decode($response->getBody(),true) ;

        return $escolaridades;
    }

    public static function obtener_ocupaciones(Request $request){

        $response = $request
        ->clienteWS_penal
        ->request('post', 'ver_ocupacion',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ]
        ]);
        $ocupaciones = json_decode($response->getBody(),true) ;

        return $ocupaciones;
    }

    public static function obtener_religiones(Request $request){

        $response = $request
        ->clienteWS_penal
        ->request('post', 'ver_religiones',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ]
        ]);
        $religiones = json_decode($response->getBody(),true) ;

        return $religiones;
    }

    public static function obtener_grupos_etnicos(Request $request){

        $response = $request
        ->clienteWS_penal
        ->request('post', 'ver_grupos_etnicos',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ]
        ]);
        $grupos_etnicos = json_decode($response->getBody(),true) ;

        return $grupos_etnicos;
    }

    public static function obtener_lenguas(Request $request){

        $response = $request
        ->clienteWS_penal
        ->request('post', 'ver_lenguas',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ]
        ]);
        $lenguas = json_decode($response->getBody(),true) ;

        return $lenguas;
    }

    public static function obtener_poblaciones_lgbttti(Request $request){

        $response = $request
        ->clienteWS_penal
        ->request('post', 'ver_lgbttti',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ]
        ]);
        $poblaciones_lgbttti = json_decode($response->getBody(),true) ;

        return $poblaciones_lgbttti;
    }

    public static function obtener_idiomas(Request $request){

        $response = $request
        ->clienteWS_penal
        ->request('post', 'ver_idiomas',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ]
        ]);
        $idiomas = json_decode($response->getBody(),true) ;

        return $idiomas;
    }

    public static function obtener_ugas(Request $request , $tipo = ""){

        $response = $request
        ->clienteWS_penal
        ->request('post', 'ver_ugas',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json" => [
                "datos"=> [
                    "tipo" => $tipo,
                ]
            ]
        ]);
        $response = json_decode($response->getBody(),true) ;

        return $response;
    }

    public static function obtener_ugas_por_id(Request $request, $id_unidad_gestion){

        $response = $request
        ->clienteWS_penal
        ->request('post', 'ver_ugas',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json" => [
                "datos"=> [
                    "id_unidad_gestion" => $id_unidad_gestion,
                    "tipo" => '',
                ]
            ]
        ]);
        $response = json_decode($response->getBody(),true) ;

        return $response;
    }


    public static function obtener_ugas_exhorto(Request $request){

        $response = $request
        ->clienteWS_penal
        ->request('post', 'ver_ugas',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[
                    // "modo"=>$request->modo,
                    "tipo"=>"4",
                ]
            ]
        ]);
        $response = json_decode($response->getBody(),true) ;

        return $response;
    }

    public static function obtener_ugas_incidencias_salas(Request $request){

        $response = $request
        ->clienteWS_penal
        ->request('post', 'ver_ugas',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[
                    // "modo"=>$request->modo,
                    "tipo"=>"5",
                ]
            ]
        ]);
        $response = json_decode($response->getBody(),true) ;

        return $response;
    }



    public static function obtener_jueces(Request $request, $id_unidad, $tipo=[5]){

        $datos = [
            "id_unidad_gestion" => $id_unidad,
            "tipo" => $tipo,
            "resolucion" => $request->tipo_resolucion
        ];
  
        $response = $request
        ->clienteWS_penal
        ->request('post', 'consulta_jueces',[
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
        $jueces = json_decode($response->getBody(),true) ;

        return $jueces;
    }

    public static function obtener_usuarios_unidad(Request $request, $id_unidad){

        $datos=[
            "id_unidad_gestion"=>$id_unidad,
        ];
        // return $datos;
        $response = $request
        ->clienteWS_penal
        ->request('post', 'consulta_usuario',[
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

    public static function consulta_usuario_id(Request $request, $id_usuario){

        $datos=[
            "id_usuario" => $id_usuario,
        ];
        // return $datos;
        $response = $request
        ->clienteWS_penal
        ->request('post', 'consulta_usuario_id',[
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

    public static function obtener_usuarios_tipo(Request $request, $id_unidad, $tipo=''){

        $datos=[
            "id_unidad_gestion"=>$id_unidad,
            "id_tipo_usuario"=>$tipo
        ];
        // return $datos;
        $response = $request
        ->clienteWS_penal
        ->request('post', 'consulta_usuarios',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>$datos,
                "paginacion" => [
                    "pagina" => 1,
                    "registros_por_pagina" => 1000
                ]
            ]
        ]);
        $response = json_decode($response->getBody(),true) ;

        return $response;
    }

    public static function obtener_grupo_trabajo(Request $request, $id_usuario, $tipo, $nivel){

        $datos=[
            "id_usuario"=>$id_usuario,
            "tipo"=>$tipo,
            "nivel"=>$nivel
        ];
        // return $datos;
        $response = $request
        ->clienteWS_penal
        ->request('post', 'usuario_estructura',[
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

    public static function tipos_documento_carpeta(Request $request){

        $response = $request
        ->clienteWS_penal
        ->request('post', 'catalogo_documentos_carpeta',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[ ]
        ]);
        $response = json_decode($response->getBody(),true) ;

        return $response;
    }

    public static function inmuebles(Request $request){

        $response = $request
        ->clienteWS_penal
        ->request('post', 'ver_inmueble',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[ ]
        ]);
        $response = json_decode($response->getBody(),true) ;

        return $response;
    }

    public static function ver_reclusorios( Request $request ) {

        $response = $request
        ->clienteWS_penal
        ->request('post', 'ver_reclusorios',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json" => [
                "datos" => [
                    "id_reclusorio" => $request->id_reclusorio
                ]
            ]
        ]);
        $response = json_decode($response->getBody(),true) ;

        return $response;
    }

    public static function salas(Request $request){

        $response = $request
        ->clienteWS_penal
        ->request('post', 'ver_inmueble',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[ ]
        ]);
        $response = json_decode($response->getBody(),true) ;

        return $response;
    }

    public static function obtener_inmueble_salas(Request $request, $id_inmueble, $id_unidad_gestion){

        $response = $request
        ->clienteWS_penal
        ->request('post', 'inmueble_salas',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos" => [
                    "id_inmueble" => $id_inmueble,
                    "id_unidad_gestion" => $id_unidad_gestion
                ]
             ]
        ]);
        $response = json_decode($response->getBody(),true) ;

        return $response;
    }

    public static function obtener_siguiente_juez_control(Request $request, $id_unidad){

        $response = $request
        ->clienteWS_penal
        ->request('get', 'obtener_siguiente_juez_control/'.$id_unidad,[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[ ]
        ]);
        $response = json_decode($response->getBody(),true) ;

        return $response;
    }

    public static function obtener_tipos_documentos_plantillas(Request $request, $modo='listado'){
        $datos = [
            "codigo"=>isset($request->datos['codigo'])?$request->datos['codigo']:"",
            "nombre_formato"=>isset($request->datos['nombre_formato'])?$request->datos['nombre_formato']:"",
            "cve_formato"=>isset($request->datos['cve_formato'])?$request->datos['cve_formato']:"",
            "modo"=>$modo
        ];

        $response = $request
        ->clienteWS_penal
        ->request('post', 'ver_tipos_documento',[
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

    public static function obtener_tipos_documentos(Request $request){

        $modo="listado";

        $datos = [
            "modo"=>$modo
        ];

        $response = $request
        ->clienteWS_penal
        ->request('post', 'ver_tipos_documento',[
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

    public static function obtener_catalogo_usmeca(Request $request, $catalogo=null,$tipo=null){
        $response = $request
        ->clienteWS_penal
        ->request('post', 'consulta_scmc',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[
                    "catalogo" => $catalogo,
                    "tipo" => $tipo,
                ],
            ]
        ]);

        return json_decode($response->getBody(),true) ;
    }

    public static function obtener_suspencion_condicional(Request $request,$nombre_condicion=null){
        $response = $request
        ->clienteWS_penal
        ->request('post', 'ver_condiciones_suspensorio',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[
                    "nombre_condicion" => $nombre_condicion,
                ],
            ]
        ]);

        return json_decode($response->getBody(),true) ;
    }

    public static function obtener_juez_tramite(Request $request,$id_unidad){
        $response = $request
        ->clienteWS_penal
        ->request('get', 'obtener_juez_tramite/'.$id_unidad,[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "query"=>[
            ]
        ]);

        return json_decode($response->getBody(),true) ;
    }

    public static function obtener_horarios_salas(Request $request,$id_sala,$fecha){
        $response = $request
        ->clienteWS_penal
        ->request('get', 'horarios_salas/'.$id_sala,[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "query"=>[
                "datos"=>[
                    "fecha" => $fecha,
                ],
            ]
        ]);

        return json_decode($response->getBody(),true) ;
    }


    public static function obtener_ver_tipos_recursos(Request $request){
        $response = $request
        ->clienteWS_penal
        ->request('post', 'ver_tipos_recursos',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[

                ],
            ]
        ]);

        return json_decode($response->getBody(),true) ;
    }

    public static function obtener_nombre_tipos_recursos(Request $request,$id_tipo_recurso){
        $response = $request
        ->clienteWS_penal
        ->request('post', 'tipos_recursos',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[
                    "id_tipo_recurso" => $id_tipo_recurso,
                ],
            ]
        ]);

        return json_decode($response->getBody(),true) ;
    }

    public static function obtener_horarios_recursos(Request $request, $sala, $fecha, $audiencia='-',$tipo_recurso='-', $id_nombre_recurso='-'){
        $response = $request
        ->clienteWS_penal
        ->request('get', 'horarios_recursos/0',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "query"=>[
                "datos"=>[
                    "fecha" => $fecha,
                    "id_audiencia" => $audiencia,
                    "id_tipo_recurso" => $tipo_recurso,
                    "id_nombre_recurso" => $id_nombre_recurso,
                    "id_sala" => $sala
                ],
            ]
        ]);

        return json_decode($response->getBody(),true) ;
    }

    public static function jueces_sustitucion(Request $request){

        $response = $request
        ->clienteWS_penal
        ->request('post', 'consulta_jueces',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[
                    //"id_unidad_gestion" => $request->id_unidad_gestion,
                    "tipo" => [5,14,35],
                ],
            ]
        ]);
        $response = json_decode($response->getBody(),true) ;

        return $response;
    }



    public static function ver_tipo_pena(Request $request){

        $response = $request
        ->clienteWS_penal
        ->request('post', 'ver_tipo_pena',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ]
        ]);
        $response = json_decode($response->getBody(),true) ;

        return $response;
    }

    public static function obtener_penas(Request $request){

        $datos=[
            "codigo"=>$request->codigo,
            "id_tipo_pena"=>$request->tipo_pena,
            "p_sustitutivo"=>"",
            "privativa_libertad"=>"",
            "anios_prescripcion"=>"",
            "orden"=>""
        ];

        $response = $request
        ->clienteWS_penal
        ->request('post', 'ver_penas',[
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

    public static function obtener_detalle_pena(Request $request){

        $datos=[
            "id_pena"=>$request->pena_impuesta,
        ];

        $response = $request
        ->clienteWS_penal
        ->request('post', 'ver_pena_opcion',[
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

    public static function obtener_centros_detencion(Request $request){

        $response = $request
        ->clienteWS_penal
        ->request('post', 'ver_reclusorios',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ]
        ]);
        $response = json_decode($response->getBody(),true) ;

        return $response;
    }



    public static function obtener_jueces_administracion(Request $request){

        $response = $request
        ->clienteWS_penal
        ->request('post', 'consulta_jueces',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>"5",
            ]
        ]);
        $jueces = json_decode($response->getBody(),true) ;

        return $jueces;
    }

    // CHIA
    
    public static function obtener_catalogo_monedas( Request $request ){

        $response = $request
        ->clienteWS_penal
        ->request('get', 'obtener_catalogo_monedas',[
            "headers" => [
                "sesion-id" => Session::get("sesion-id"),
                "cadena-sesion" => Session::get("cadena-sesion"),
                "usuario-id" => Session::get("usuario-id"),
                "Content-Type" => "application/json"
            ]
        ]);
        $monedas = json_decode($response->getBody(),true) ;

        return $monedas;
    }

    public static function obtener_catalogo_valores( Request $request ){

        $response = $request
        ->clienteWS_penal
        ->request('get', 'obtener_catalogo_valores',[
            "headers" => [
                "sesion-id" => Session::get("sesion-id"),
                "cadena-sesion" => Session::get("cadena-sesion"),
                "usuario-id" => Session::get("usuario-id"),
                "Content-Type" => "application/json"
            ]
        ]);
        $valores = json_decode($response->getBody(),true) ;

        return $valores;
    }

    public static function obtener_catalogo_conceptos( Request $request, $exh='', $dev='', $materia='' ){

        $response = $request
        ->clienteWS_penal
        ->request('get', "obtener_catalogo_conceptos/$exh/$dev/$materia",[
            "headers" => [
                "sesion-id" => Session::get("sesion-id"),
                "cadena-sesion" => Session::get("cadena-sesion"),
                "usuario-id" => Session::get("usuario-id"),
                "Content-Type" => "application/json"
            ]
        ]);
        $conceptos = json_decode($response->getBody(),true) ;

        return $conceptos;
    }

    public static function obtener_catalogo_instancias( Request $request ){

        $response = $request
        ->clienteWS_penal
        ->request('get', 'obtener_catalogo_instancias',[
            "headers" => [
                "sesion-id" => Session::get("sesion-id"),
                "cadena-sesion" => Session::get("cadena-sesion"),
                "usuario-id" => Session::get("usuario-id"),
                "Content-Type" => "application/json"
            ]
        ]);
        $instancias = json_decode($response->getBody(),true) ;

        return $instancias;
    }

    public static function obtener_catalogo_bancos( Request $request, $CveBank='' ){

        $response = $request
        ->clienteWS_penal
        ->request('get', 'obtener_catalogo_bancos',[
            "headers" => [
                "sesion-id" => Session::get("sesion-id"),
                "cadena-sesion" => Session::get("cadena-sesion"),
                "usuario-id" => Session::get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos" => [
                    "CveBank" => $CveBank,
                ],
            ]
        ]);
        $bancos = json_decode($response->getBody(),true) ;

        return $bancos;
    }

    public static function obtener_catalogo_estatus( Request $request ){

        $response = $request
        ->clienteWS_penal
        ->request('get', 'obtener_catalogo_estatus',[
            "headers" => [
                "sesion-id" => Session::get("sesion-id"),
                "cadena-sesion" => Session::get("cadena-sesion"),
                "usuario-id" => Session::get("usuario-id"),
                "Content-Type" => "application/json"
            ]
        ]);
        $estatus = json_decode($response->getBody(),true) ;

        return $estatus;
    }

    public static function obtener_catalogo_tipo_delictivo(Request $request, $ids_tipo_delictivo=""){

        $response = $request
        ->clienteWS_penal
        ->request('post', 'ver_catalogo_tipo_delictivo',[
            "headers" => [
                "sesion-id" => Session::get("sesion-id"),
                "cadena-sesion" => Session::get("cadena-sesion"),
                "usuario-id" => Session::get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json" => [
                "datos" => [
                    "ids_tipo_delictivo" => $ids_tipo_delictivo
                ]
            ]
        ]);

        return json_decode($response->getBody(),true) ;

    }
    
    public static function obtener_catalogo_desagregado(Request $request, $ids_desagregado="-"){

        $response = $request
        ->clienteWS_penal
        ->request('post', 'ver_catalogo_desagregado',[
            "headers" => [
                "sesion-id" => Session::get("sesion-id"),
                "cadena-sesion" => Session::get("cadena-sesion"),
                "usuario-id" => Session::get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json" => [
                "datos" => [
                    "ids_desagregado" => $ids_desagregado
                ]
            ]
        ]);

        return json_decode($response->getBody(),true) ;

    }

    public static function obtener_catalogo_fracciones(Request $request){

        $response = $request
        ->clienteWS_penal
        ->request('get', 'ver_catalogo_fracciones',[
            "headers" => [
                "sesion-id" => Session::get("sesion-id"),
                "cadena-sesion" => Session::get("cadena-sesion"),
                "usuario-id" => Session::get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json" => [
                "datos" => [
                    
                ]
            ]
        ]);

        return json_decode($response->getBody(),true) ;

    }

    public static function obtener_actos_reclamacion(Request $request){

        $response = $request
        ->clienteWS_penal
        ->request('get', 'ver_catalogo_actos_reclamacion',[
            "headers" => [
                "sesion-id" => Session::get("sesion-id"),
                "cadena-sesion" => Session::get("cadena-sesion"),
                "usuario-id" => Session::get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json" => [
                "datos" => [
                    
                ]
            ]
        ]);

        return json_decode($response->getBody(),true) ;

    }

    public static function obtener_autoridades_control_constitucional( Request $request ) {

        $response = $request
        ->clienteWS_penal
        ->request('get', 'obtener_autoridades_control_constitucional',[
            "headers" => [
                "sesion-id" => Session::get("sesion-id"),
                "cadena-sesion" => Session::get("cadena-sesion"),
                "usuario-id" => Session::get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json" => [
                "datos" => [
                    "entidad_federativa" => $request->entidad_federativa,
                    "asunto_trata" => $request->tipo_amparo,
                ]
            ]
        ]);

        return json_decode($response->getBody(),true) ;

    }

    public static function identificaciones(Request $request){

        $response = $request
        ->clienteWS_penal
        ->request('post', 'ver_identificaciones',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
        ]);
        $identificaciones = json_decode($response->getBody(),true) ;

        return $identificaciones;
    }


    public static function incidencia_jueces_unidades( Request $request, $id_unidad = null, $tipo_evento = null, $fecha_desde = null, $fecha_hasta= null ){
        
        //$tipo_evento acepta "", "roles_guardias", "jueces_tramite", "incidencias", "vacaciones"

        $response = $request
        ->clienteWS_penal
        ->request('POST', 'consulta_agenda_jueces',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[
                    "id_unidad_gestion" => $id_unidad,
                    "tipo" => $tipo_evento,
                    "fecha_desde" => $fecha_desde,
                    "fecha_hasta" => $fecha_hasta,
                ]
            ]
        ]);
        $response = json_decode($response->getBody(),true) ;

        return $response;
    }
    
    public static function ver_catalogo_cierres_carpeta( Request $request ){
        
        $response = $request
        ->clienteWS_penal
        ->request('get', 'ver_catalogo_situacion_carpeta',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[
                    "ids_situaciones" => [3,8,9,17,19,22],
                ]
            ]
        ]);
        $response = json_decode($response->getBody(),true) ;

        return $response;
    }

    public static function obtener_desagregado_delito_estadistico(Request $request, $param = []){
        //dd($param);
        $response = $request
        ->clienteWS_penal
        ->request('get', 'obtener_desagregado_delito_estadistico',[
            "headers" => [
                "sesion-id" => Session::get("sesion-id"),
                "cadena-sesion" => Session::get("cadena-sesion"),
                "usuario-id" => Session::get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json" => [
                "datos" => [
                    "tipo_delictivo" => isset( $param["tipo_delictivo"]) ? $param["tipo_delictivo"] : "-",
                    "desagregado_n1" => isset( $param["desagregado_n1"]) ? $param["desagregado_n1"] : "-",
                    "desagregado_n2" => isset( $param["desagregado_n2"]) ? $param["desagregado_n2"] : "-",
                    "desagregado_n3" => isset( $param["desagregado_n3"]) ? $param["desagregado_n3"] : "-"
                ]
            ]
        ]);

        return json_decode($response->getBody(),true) ;

    }
   
}
