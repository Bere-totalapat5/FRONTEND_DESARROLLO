<?php

namespace App\Http\Controllers\catalogos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\clases\catalogos;
use Illuminate\Support\Arr;
use Session;

class CatalogosController extends Controller
{
    public function obtener_modalidades(Request $request){
        $arr_modalidades=catalogos::modalidades($request, $request->delito);

        $modalidades=Arr::sort($arr_modalidades, 'nombre_modalidad');

        return $modalidades;
    }

    public function obtener_agencias(Request $request){
        $arr_agencias=catalogos::agencias($request, $request->fiscalia);

        $agencias=Arr::sort($arr_agencias, 'agencia_investigacion');

        return $agencias;
    }
    //#############################
    public function obtener_paises(Request $request){

        $paises=catalogos::paises($request, $request->pais);

        return $paises;
    }

    public function discapacidades(Request $request){

        $discapacidades=catalogos::discapacidades($request, $request->id_discapacidad);

        return $discapacidades;
    }

    public function condicion_migratoria(Request $request){

        $condicion_migratoria=catalogos::condicion_migratoria($request, $request->id_condicion_migratoria);

        return $condicion_migratoria;
    }

    public function lengua_extranjera(Request $request){

        $lengua_extranjera=catalogos::lengua_extranjera($request, $request->id_lengua_extranjera);

        return $lengua_extranjera;
    }

    public function relacion_imputado(Request $request){

        $relacion_imputado=catalogos::relacion_imputado($request, $request->id_relacion_imputado);

        return $relacion_imputado;
    }

    public function actos_investigacion(Request $request){

        $acto_investigacion=catalogos::actos_investigacion($request, $request->id_acto_investigacion);

        return $acto_investigacion;
    }

    public function tipo_solucion_alterna(Request $request){

        $tipo_solucion_alterna=catalogos::tipo_solucion_alterna($request, $request->id_tipo_solucion_alterna);

        return $tipo_solucion_alterna;
    }

    public function tipo_sobreseimiento(Request $request){

        $tipo_sobreseimiento=catalogos::tipo_sobreseimiento($request, $request->id_tipo_sobreseimiento);

        return $tipo_sobreseimiento;
    }

    public function tipo_reparacion_danio(Request $request){

        $tipo_reparacion_danio=catalogos::tipo_reparacion_danio($request, $request->id_tipo_reparacion_danio);

        return $tipo_reparacion_danio;
    }

    public function reparacion_danio(Request $request){

        $reparacion_danio=catalogos::reparacion_danio($request, $request->id_reparacion_danio);

        return $reparacion_danio;
    }

    public function modalidad_reparacion_danio(Request $request ){

        $modalidad_reparacion_danio=catalogos::modalidad_reparacion_danio($request, $request->id_modalidad_reparacion_danio);

        return $modalidad_reparacion_danio;
    }

    public static function catalogo_comision(Request $request ){

        $catalogo_comision=catalogos::catalogo_comision($request, $request->id_elemento_comision_delito);

        return $catalogo_comision;
    }

    public static function catalogo_modalidad_agresion(Request $request ){

        $catalogo_modalidad_agresion=catalogos::catalogo_modalidad_agresion($request, $request->id_modalidad_agresion);

        return $catalogo_modalidad_agresion;
    }

    //#############################
    public function obtener_municipios(Request $request){

        $municipios=catalogos::municipios($request, $request->estado);


        return $municipios;
    }

    public function obtener_solicitudes(Request $request){

        $solicitudes=catalogos::solicitudes($request);

        return $solicitudes;
    }

    public function obtener_jueces_guardias(Request $request){

        $jueces=catalogos::obtener_jueces($request, $request->uga, [5]);

        return $jueces;
    }

    public function obtener_jueces_unidad(Request $request, $tipo = [5] ){

        $id_unidad = in_array(Session::get('id_tipo_usuario'), [1,20]) ? $request->id_unidad : Session::get('id_unidad_gestion');

        if( isset($request->uga) )
            $id_unidad = $request->uga;
        
        $unidades_ejecucion = explode(',', $request->entorno['unidades_ejecucion']['ids']);  
        
        //if( in_array(Session::get('id_unidad_gestion'), $unidades_ejecucion) )
        if( in_array( $id_unidad, $unidades_ejecucion) )
            $tipo = [15]; 

        if( isset($request->director) ) 
            array_push($tipo, (int)($request->director));

        $jueces = catalogos::obtener_jueces($request, $id_unidad, $tipo);

        if( isset($request->descartar_jueces_con_incidencias) and $request->descartar_jueces_con_incidencias==1){
            
            $id_unidad = $id_unidad;
            $tipo_evento = isset($request->tipo_evento) ? $request->tipo_evento : "incidencias,vacaciones";
            $fecha_desde = isset($request->fecha_desde) ? $request->fecha_desde : null;
            $fecha_hasta = isset($request->fecha_hasta) ? $request->fecha_hasta : null;

            $incidencias = catalogos::incidencia_jueces_unidades( $request, $id_unidad , $tipo_evento , $fecha_desde , $fecha_hasta );
            $jueces["incidencias"] = $incidencias;

            if( $incidencias["status"] == 100 and count($incidencias["message"]) > 0 and $jueces["status"] ==100 ){                
                $ids_jueces_incidencia = [];
                $ids_jueces = [];

                $jueces_return = [];
                
                foreach($incidencias["message"] as $j){
                    $ids_jueces_incidencia [] = $j ["id_usuario"];
                }

                foreach($jueces["response"] as $j ){
                    $ids_jueces [] = $j["id_usuario"];
                }

                $ids_jueces_retornar = array_diff( $ids_jueces, $ids_jueces_incidencia);

                foreach($jueces["response"] as $j){
                    if( in_array(  $j["id_usuario"] , $ids_jueces_retornar ) )
                    $jueces_return [] = $j;
                }

                $jueces["original_response"] = $jueces["response"];
                $jueces["response"] = $jueces_return;
            }
        }
        
        return $jueces;
    }

    public function obtener_usuarios_unidad( Request $request ){

        $jueces=catalogos::obtener_usuarios_unidad($request, $request->uga);

        return $jueces;
    }

    public function obtener_grupo_trabajo( Request $request ){

        if( isset( $request->id_usuario ) && $request->id_usuario != 0 )
            $id_usuario = $request->id_usuario;
        else
            $id_usuario = Session::get('usuario_id');

        $usuarios=catalogos::obtener_grupo_trabajo($request, $id_usuario, $request->tipo, $request->nivel);

        return $usuarios;
    }

    public function obtener_siguiente_juez_control( Request $request ){

        if( in_array(Session::get('id_tipo_usuario'), [1,20]) && isset( $request->id_unidad ) )
            $id_unidad = $request->id_unidad;
        else 
            $id_unidad = Session::get('id_unidad_gestion');

        $usuarios = catalogos::obtener_siguiente_juez_control($request, $id_unidad);

        return $usuarios;
    }

    public function obtener_inmuebles( Request $request ){
        $lista=catalogos::inmuebles($request);
        return $lista;
    }

    public function ver_reclusorios( Request $request ){
        
        return catalogos::ver_reclusorios($request);
        
    }

    public function obtener_inmueble_salas( Request $request ){
        $id_unidad= isset($request->id_unidad) ? $request->id_unidad : Session::get('id_unidad_gestion');
        //$id_unidad= Session::get('id_tipo_usuario') == 1 ? $request->id_unidad : Session::get('id_unidad_gestion');
        //$id_unidad= Session::get('id_unidad_gestion');
        $lista= catalogos::obtener_inmueble_salas($request, $request->id_inmueble, $id_unidad);
        //$lista=catalogos::obtener_inmueble_salas($request, 5, 13);
        return $lista;
    }

    public function obtener_jueces_ejecucion(Request $request){

        $id_unidad= in_array(Session::get('id_tipo_usuario'), [1,20]) ? $request->id_unidad : Session::get('id_unidad_gestion');

        $jueces=catalogos::obtener_jueces($request, $id_unidad, [15]);

        return $jueces;
    }

    public function obtener_juez_tramite(Request $request){

        $id_unidad= in_array(Session::get('id_tipo_usuario'), [1,20]) ? $request->id_unidad : Session::get('id_unidad_gestion');

        $jueces=catalogos::obtener_juez_tramite($request, $id_unidad);

        return $jueces;
    }

    public function obtener_horarios_salas(Request $request){

        $horario_salas=catalogos::obtener_horarios_salas($request, $request->id_sala, $request->fecha);
        return $horario_salas;
    }

    public function obtener_ver_tipos_recursos(Request $request){

        $tipos_recursos=catalogos::obtener_ver_tipos_recursos($request);
        return $tipos_recursos;
    }

    public function obtener_nombre_tipos_recursos(Request $request){

        $tipos_recursos=catalogos::obtener_nombre_tipos_recursos($request, $request->id_tipo_recurso);
        return $tipos_recursos;
    }

    public function obtener_horarios_recursos(Request $request){
        // return $request->all();
        $horarios_recursos=catalogos::obtener_horarios_recursos($request, $request->sala, $request->fecha, $request->audiencia, $request->tipo_recurso, $request->nombre_recurso);
        return $horarios_recursos;
    }

    public function obtener_penas(Request $request){

        $penas=catalogos::obtener_penas($request);
        return $penas;
    }

    public function obtener_detalle_pena(Request $request){

        $detalles_pena=catalogos::obtener_detalle_pena($request);
        return $detalles_pena;
    }


    public function obtener_catalogo_desagregado( Request $request){
        
        return catalogos::obtener_catalogo_desagregado($request, $request->desagregados);
        
    }

    public function obtener_autoridades_control_constitucional( Request $request ) {
        return catalogos::obtener_autoridades_control_constitucional($request);
    }

    public function obtener_desagregado_delito_estadistico( Request $request){

        $param = [
            "tipo_delictivo" => isset( $request->tipo_delictivo ) ? $request->tipo_delictivo : "-",
            "desagregado_n1" => isset( $request->desagregado_n1 ) ? $request->desagregado_n1 : "-",
            "desagregado_n2" => isset( $request->desagregado_n2 ) ? $request->desagregado_n2 : "-",
            "desagregado_n3" => isset( $request->desagregado_n3 ) ? $request->desagregado_n3 : "-",
        ];
        
        return catalogos::obtener_desagregado_delito_estadistico($request, $param);
        
    }

}
