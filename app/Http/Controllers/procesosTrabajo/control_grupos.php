<?php

namespace App\Http\Controllers\procesosTrabajo;

use App\Http\Controllers\clases\configuracion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\clases\procesos_trabajo;

class control_grupos extends Controller
{
    public function inicio_grupos( Request $request ){


        $lista_grupos=procesos_trabajo::obtener_grupos_lista($request, $request->session()->get('usuario_juzgado'));
        //dd($lista_grupos);

        

        return view(    "procesosTrabajo.grupos",
                        ["entorno"=>$request->entorno, 
                        "request"=>$request,
                        "sesion"=>$request->session()->all(),
                        "menu_general"=>$request->menu_general,
                        "lista_grupos"=>$lista_grupos
                        ]
                    );
    }


    public function cargar_permisos_usuarios( Request $request ){
        $input = $request->all();
        $lista=procesos_trabajo::obetner_acciones($request, $input['usuario_id']);
        //return $lista;

        $texto['html']='<div class="row">';
        for($i=0; $i<count($lista['response']); $i++){
            if($request->session()->get('juzgado_tipo')=="sala" and $lista['response'][$i]['descripcion']!='Enviar Acuerdo a Notificación') {
                $texto['html'].='<div class="col-lg-4">
                <label class="ckbox">
                    <input class="checkpermisos" type="checkbox" '; if($lista['response'][$i]['valor']==1){ $texto['html'].='checked'; } $texto['html'].=' onclick="guardarAccion(this, '.$input['usuario_id'].', '.$lista['response'][$i]['permiso_id'].');"><span>'.$lista['response'][$i]['descripcion'].'</span>
                </label>
                </div><!-- col-3 -->';
            }
            else if($request->session()->get('juzgado_tipo')=="juzgado" and $lista['response'][$i]['descripcion']=='Enviar Acuerdo a Notificación') {
                $texto['html'].='<div class="col-lg-4">
                <label class="ckbox">
                    <input class="checkpermisos" type="checkbox" '; if($lista['response'][$i]['valor']==1){ $texto['html'].='checked'; } $texto['html'].=' onclick="guardarAccion(this, '.$input['usuario_id'].', '.$lista['response'][$i]['permiso_id'].');"><span>'.$lista['response'][$i]['descripcion'].'</span>
                </label>
                </div><!-- col-3 -->';
            }

            //$texto['html'].=$lista['response'][$i]['descripcion'].' '.print_r($lista['response'][$i], true).'<br>';
        }
        $texto['html'].='</div>';
        
        return $texto;
    }


    public function cargar_menu_usuarios( Request $request ){
        $input = $request->all();

        $lista=configuracion::generar_permisos_menu($request, $input['usuario_id']);
        $lista_permisos_menu=configuracion::obtener_permisos_menu($request, $input['usuario_id']);

        //return $lista_permisos_menu;

        if($lista_permisos_menu['status']!=0){
            $texto['html']='<div class="row"><div class="col-lg-12">';
            foreach ($lista_permisos_menu['response'] as $clave => $valor) {

           
                $texto['html'].='
                

                    <br>
                    <label class="ckbox">
                        <input class="checkpermisos" type="checkbox" '; if($valor['permiso_valor']==1){ $texto['html'].='checked'; } $texto['html'].=' onclick="guardarMenu(this, '.$input['usuario_id'].', '.$valor['permiso_id'].');"><span class="tx-normal tx-inverse" style="font-size: 17px;"><u><strong>'.$valor['descripcion'].'</strong></u></span>
                    </label>

                
               <div class="row">';

                for($j=0; $j<count($valor['submenus']); $j++){
                    $texto['html'].='<div class="col-lg-4">
                    <label class="ckbox">
                        <input class="checkpermisos" type="checkbox" '; if($valor['submenus'][$j]['permiso_valor']==1){ $texto['html'].='checked'; } $texto['html'].=' onclick="guardarMenu(this, '.$input['usuario_id'].', '.$valor['submenus'][$j]['permiso_id'].');"><span>'.$valor['submenus'][$j]['descripcion'].'</span>
                    </label>
                    </div><!-- col-3 -->';
                }
                $texto['html'].='</div>';
            }
            $texto['html'].='</div></div>';
        }
        else{
            $texto['html']='<h4>No hay permisos</h4>';
        }
        
        return $texto;
    }

    public function guardar_menu_usuarios( Request $request ){
        $input = $request->all();

        $datos_finales[0]['permiso_id']=$input['menu_id'];
        $datos_finales[0]['usuario_id']=$input['id_usuario'];
        $datos_finales[0]['permiso_valor']=$input['activo'];
        
        $salvar=configuracion::gestionar_permisos_menu($request, $datos_finales);
        return $salvar;
    }


    public function guardar_accion_usuarios( Request $request ){
        $input = $request->all();

        $datos_finales[0]['permiso_id']=$input['menu_id'];
        $datos_finales[0]['usuario_id']=$input['id_usuario'];
        $datos_finales[0]['valor']=$input['activo'];
        
        $salvar=configuracion::modificar_acciones($request, $datos_finales);
        return $salvar;
    }

    



    public function agregar_usuario_grupo( Request $request ){
        $input = $request->all();
        $lista=procesos_trabajo::obtener_participantes_grupos($request, $request->session()->get('usuario_juzgado'));

        $texto['plantilla_archivo_header']='<h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Agrega usuarios al grupo</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>';
        
        $group="";
        $texto['plantilla_archivo_body']='<div class="form-layout form-layout-7">
        <input type="hidden" id="id_grupo_trabajo" value="'.$request->session()->get('usuario_grupo_trabajo').'">
        <input type="hidden" id="id_usuario" value="'.$request->session()->get('usuario_id').'">
        <input type="hidden" id="tipo_usuario" value="'.$request->session()->get('id_tipo_usuario').'">

        <div class="row no-gutters">
          <div class="col-4 col-sm-3">
            Usuario:
          </div><!-- col-4 -->
          <div class="col-8 col-sm-9">
      
            <select class="form-control select2 select2-show-search" id="usuario_grupo_id" >';
                for($i=0; $i<count($lista); $i++){
                    if($group!=$lista[$i]['tipo']){
                        $texto['plantilla_archivo_body'].='<optgroup label="'.$lista[$i]['tipo'].'">';
                        $group=$lista[$i]['tipo'];
                    }
                    
                    $texto['plantilla_archivo_body'].='<option value="'.$lista[$i]['id_usuario'].'-'.$lista[$i]['grupo_trabajo'].'-'.$lista[$i]['superiores'].' ">'.$lista[$i]['nombre_clave'].' - '.$lista[$i]['nombre'].'</option>';
                    
                }
            $texto['plantilla_archivo_body'].='</select>
          </div><!-- col-8 -->

        </div><!-- row -->
        <br>
        <button class="btn btn-success btn-block mg-b-10" onclick="agregarUsuarioGrupo(0);">Agregar Usuario</button>
      
        </div><!-- form-layout -->
        <script>
            $(function(){
                $(".select2").select2({
                    minimumResultsForSearch: ""
                });
            });
        </script>
        <style>
            .select2-container--open {
                z-index: 9999999
            }
        </style>';

        return response()->json([$texto]);
    }

    public function guardar_usuario_grupo( Request $request ){

        $input = $request->all();

        $id_grupo_trabajo=$request->session()->get('usuario_grupo_trabajo');
        $id_usuario=$request->session()->get('usuario_id');
        $tipo_usuario=$request->session()->get('id_tipo_usuario');


        $arr_grupos_trabajo_usuario=explode('-', $input['usuario_grupo_id']);
        $area=$request->session()->get("grupo_trabajo_tipo_area");
        
        if($request->session()->get("grupo_trabajo_tipo_area")=="secretaria auxiliar"){
            $ponencia='0';
        }
        if($request->session()->get("grupo_trabajo_tipo_area")=="juzgado"){
            $ponencia='0';
        }
        else{
            $ponencia=$request->session()->get("usuario_secretaria");
        }
        

        //se agrega al registro
        if($arr_grupos_trabajo_usuario[1]==""){
            $lista=procesos_trabajo::guardar_participante_grupo($request, $request->session()->get('usuario_juzgado'), $id_grupo_trabajo, $arr_grupos_trabajo_usuario[0], $area, $ponencia);
        }
        else{
            //se agrega al arreglo
            if($input['eliminar']==0){
                $arr_superior=$arr_grupos_trabajo_usuario[2].','.$id_grupo_trabajo;
            }
            else{
                $arr_superior="";
                $arr_permisos_superiores=explode(',', $arr_grupos_trabajo_usuario[2]);
                for($i=0; $i<count($arr_permisos_superiores); $i++){
                    if($arr_permisos_superiores[$i]==$id_grupo_trabajo){
                        unset($arr_permisos_superiores[$i]);
                    }
                }

                $arr_permisos_superiores = array_values($arr_permisos_superiores);

                $j=0;
                for($i=0; $i<count($arr_permisos_superiores); $i++){
                    if($arr_permisos_superiores[$i]!="" and $arr_permisos_superiores[$i]!="0"){
                        if($j==0){
                            $arr_superior.=$arr_permisos_superiores[$i];
                            $j++;
                        }
                        else{
                            $arr_superior.=','.$arr_permisos_superiores[$i];
                        }
                    }
                }

                if($arr_superior==""){
                    $arr_superior="0";
                }
            }

           // $datos[]=$arr_grupos_trabajo_usuario[0];
           // $datos[]=$arr_grupos_trabajo_usuario[1];
           // $datos[]=$arr_grupos_trabajo_usuario[2];
           // $datos[]=$arr_permisos_superiores;
           // $datos[]=$arr_superior;
           // $datos[]=$input['eliminar'];
            //return $datos;
            $lista=procesos_trabajo::modificar_participante_grupo($request, $arr_grupos_trabajo_usuario[1], $arr_grupos_trabajo_usuario[0], $arr_superior);
        }

        
        //$lista=procesos_trabajo::guardar_participante_grupo($request, $request->session()->get('usuario_juzgado'), $input['id_grupo_trabajo'], $input['usuario_id'], $input['tipo_usuario'], $area, $ponencia);
        return response()->json([$lista]); 
    }


    public function array_sort($array, $on, $order=SORT_ASC)
    {
        $new_array = array();
        $sortable_array = array();
    
        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    $sortable_array[$k] = $v;
                }
            }
            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                break;
                case SORT_DESC:
                    arsort($sortable_array);
                break;
            }
    
            foreach ($sortable_array as $k => $v) {
                $new_array[$k] = $array[$k];
            }
        }
        return $new_array;
    }
    
    
}