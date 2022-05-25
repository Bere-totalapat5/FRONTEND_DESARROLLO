<?php
namespace App\Http\Controllers\clases;

use Illuminate\Http\Request;
use DB;

class procesos_trabajo{

    /*
    *   SOLICITUDES
    */
    public static function obtener_solicitudes_count(Request $request){

        $response = $request
        ->clienteWS
        ->request('get', 'NumPorRevisarSeguimientos',[
            "query" => [
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id")
            ]
        ]);
        
        $response = json_decode($response->getBody(),true);
        return $response;
    }

    public static function obtener_solicitudes_lista(Request $request){

        $response = $request
        ->clienteWS
        ->request('get', 'SeguimientosPorRevisar',[
            "query" => [
                "datos" => [
                    "numero" =>"",
                    "desde" => "",
                    "hasta" => ""
                ]
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id")
            ]
        ]);
        
        $response = json_decode($response->getBody(),true) ;
        return $response;
    }

    public static function cambiar_solicitudes_estatus(Request $request, $id, $estatus){

        
        $response = $request
        ->clienteWS
        ->request('put', 'SeguimientoActualizacion/'.$id.'/'.$estatus,[
            "json" => [
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id")
            ]
        ]);
        
        $response = json_decode($response->getBody(),true) ;
        return $response;
    }

    public static function obtenerPromocionPDF(Request $request, $id){

        $response = $request
        ->clienteWS
        ->request('GET', 'obtenerPromocionPDF/'.$id,[
            "jquery" => [
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id")
            ]
        ]);
        
        $response = json_decode($response->getBody(),true) ;
        return $response;
    }

    public static function obtenerListaSicor(Request $request, $datos_get){
        $where=[];
        $datos=[];
        $lista_promociones=[];
        $bandera=1;
        
        if(isset($datos_get['folio']) and $datos_get['folio']!=""){
            $where[]=['uj.id_usuario_juicio', '=', $datos_get['folio']];
            $datos['folio']=$datos_get['folio'];
            $bandera=0;
        }
        if(isset($datos_get['expediente']) and $datos_get['expediente']!=""){
            $where[]=['j.expediente', '=', $datos_get['expediente']];
            $datos['expediente']=$datos_get['expediente'];
            
        }
        if(isset($datos_get['secretaria']) and $datos_get['secretaria']!="" and $datos_get['secretaria']!="-"){
            $where[]=['j.secretaria', '=', $datos_get['secretaria']];
            $datos['secretaria']=$datos_get['secretaria'];
            
        }
        if(isset($datos_get['anio']) and $datos_get['anio']!=""){
            $where[]=['j.anio', '=', $datos_get['anio']];
            $datos['anio']=$datos_get['anio'];
            $bandera=0;
        }
        if(isset($datos_get['fecha_desde']) and $datos_get['fecha_desde']!=""){
            $where[]=['uj.alta', '>=', $datos_get['fecha_desde']];
            //$where[]=['uj.estatus', 'like', 'por revisar'];
            $datos['fecha_desde']=$datos_get['fecha_desde'];
            
        }
        if(isset($datos_get['fecha_hasta']) and $datos_get['fecha_hasta']!=""){
            $where[]=['uj.alta', '<=', $datos_get['fecha_hasta']];
            //$where[]=['uj.estatus', 'like', 'por revisar'];
            $datos['fecha_hasta']=$datos_get['fecha_hasta'];
            $bandera=0;
        }

        if(isset($datos_get['estatus']) and ($datos_get['estatus']!="" and $datos_get['estatus']!="-")){
            $where[]=['uj.estatus', 'like', $datos_get['estatus']];
            $datos['estatus']=$datos_get['estatus'];
        }
        else if(isset($datos_get['estatus']) and ($datos_get['estatus']=="-")){
            $datos['estatus']='-';
        }
        else if($bandera==1){
            $where[]=['uj.estatus', 'like', 'por revisar'];
            $datos['estatus']='por revisar';
        }

        //$where[]=['j.juzgado', '=', $request->session()->get("usuario_juzgado")];
        if(DB::connection()->getDatabaseName()){
            $juicio_sicor = DB::table('usuario_juicio AS uj')
                        ->select( 'uj.fecha_auto', 'j.secretaria', 'j.juzgado', 'j.expediente', 'j.anio', 'j.toca', 'j.anio_toca', 'uj.sala', 'uj.sala2', 'uj.id_juicio', 'uj.id_usuario_juicio', 'j.tipo_expediente', 'j.bis', 'ip.nombres', 'ip.paterno', 'ip.materno', 'p1.nombre AS actor', 'p2.nombre AS demandado', 'p3.nombre AS terceria', 'jz.nombre AS nombre_juzgado', 'jz.subtipo', 'uj.alta', 'uj.fecha_permiso', 'uj.foja', 'uj.parte', 'uj.parte_otro', 'uj.estatus', 'uj.tipo_juicio', 'uj.bandera_cancelcacion')
                        ->leftJoin('juicio AS j', 'j.id_juicio', '=', 'uj.id_juicio')
                        ->leftJoin('juicio_partes AS jp', 'jp.id_juicio', '=', 'uj.id_juicio')
                        ->leftJoin('informacionpersonal AS ip', 'ip.id_usuario', '=', 'uj.id_usuario')
                        ->leftJoin('parte AS p1', 'p1.id_parte', '=', 'jp.id_parte1')
                        ->leftJoin('parte AS p2', 'p2.id_parte', '=', 'jp.id_parte2')
                        ->leftJoin('parte AS p3', 'p3.id_parte', '=', 'jp.id_parte3')
                        ->leftJoin('juzgado AS jz', 'jz.codigo', '=', 'j.juzgado')
                        ->where('j.juzgado', $request->session()->get("usuario_juzgado"))
                        ->where($where)
                        ->orderBy('uj.id_usuario_juicio', 'DESC')
                        ->limit(100)
                        ->get(); 
            
            $juicio_sicor_count = DB::table('usuario_juicio AS uj')
                        ->leftJoin('juicio AS j', 'j.id_juicio', '=', 'uj.id_juicio')
                        ->leftJoin('juicio_partes AS jp', 'jp.id_juicio', '=', 'uj.id_juicio')
                        ->leftJoin('informacionpersonal AS ip', 'ip.id_usuario', '=', 'uj.id_usuario')
                        ->leftJoin('parte AS p1', 'p1.id_parte', '=', 'jp.id_parte1')
                        ->leftJoin('parte AS p2', 'p2.id_parte', '=', 'jp.id_parte2')
                        ->leftJoin('parte AS p3', 'p3.id_parte', '=', 'jp.id_parte3')
                        ->leftJoin('juzgado AS jz', 'jz.codigo', '=', 'j.juzgado')
                        ->where('j.juzgado', $request->session()->get("usuario_juzgado"))
                        ->where('uj.estatus', 'like', 'por revisar')
                        ->count();

            $lista=[];
            $lista_promocion=[];
            $lista_promocion_inic=[];
            for($i=0; $i<count($juicio_sicor); $i++){
                $lista[$i]['juzgado']=$juicio_sicor[$i]->juzgado;
                $lista[$i]['expediente']=$juicio_sicor[$i]->expediente;
                $lista[$i]['secretaria']=$juicio_sicor[$i]->secretaria;
                $lista[$i]['anio']=$juicio_sicor[$i]->anio;
                $lista[$i]['toca']=$juicio_sicor[$i]->toca;
                $lista[$i]['anio_toca']=$juicio_sicor[$i]->anio_toca;
                $lista[$i]['sala']=$juicio_sicor[$i]->sala;
                $lista[$i]['sala2']=$juicio_sicor[$i]->sala2;
                $lista[$i]['id_juicio']=$juicio_sicor[$i]->id_juicio;
                $lista[$i]['id_usuario_juicio']=$juicio_sicor[$i]->id_usuario_juicio;
                $lista[$i]['tipo_expediente']=$juicio_sicor[$i]->tipo_expediente;
                $lista[$i]['bis']=$juicio_sicor[$i]->bis;
                $lista[$i]['nombres']=$juicio_sicor[$i]->nombres;
                $lista[$i]['paterno']=$juicio_sicor[$i]->paterno;
                $lista[$i]['materno']=$juicio_sicor[$i]->materno;
                $lista[$i]['actor']=isset($juicio_sicor[$i]->actor) ? $juicio_sicor[$i]->actor : "";
                $lista[$i]['demandado']=isset($juicio_sicor[$i]->demandado) ? $juicio_sicor[$i]->demandado : ""; 
                $lista[$i]['nombre_juzgado']=isset($juicio_sicor[$i]->nombre_juzgado) ? $juicio_sicor[$i]->nombre_juzgado : ""; 
                $lista[$i]['terceria']=isset($juicio_sicor[$i]->terceria) ? $juicio_sicor[$i]->terceria : ""; 
                $lista[$i]['subtipo']=$juicio_sicor[$i]->subtipo;
                $lista[$i]['alta']=$juicio_sicor[$i]->alta;
                $lista[$i]['fecha_permiso']=$juicio_sicor[$i]->fecha_permiso;
                $lista[$i]['foja']=$juicio_sicor[$i]->foja;
                $lista[$i]['parte']=$juicio_sicor[$i]->parte;
                $lista[$i]['parte_otro']=$juicio_sicor[$i]->parte_otro;
                $lista[$i]['estatus']=$juicio_sicor[$i]->estatus;
                $lista[$i]['tipo_juicio']=$juicio_sicor[$i]->tipo_juicio;
                $lista[$i]['bandera_cancelcacion']=$juicio_sicor[$i]->bandera_cancelcacion;
                $lista[$i]['fecha_auto']=$juicio_sicor[$i]->fecha_auto;

                $lista_promocion_inic['id_juicio']=$juicio_sicor[$i]->id_juicio;
                $lista_promocion_inic['juzgado']=$juicio_sicor[$i]->juzgado;
                $lista_promocion[]=$lista_promocion_inic;
            }

            if(count($lista_promocion)!=0){
                //dd('aqui');
                $lista_promociones=promociones::obtener_caratulas_batch($request, $lista_promocion);
                //$lista_promociones=array_reverse($lista_promociones);
                //dd($lista_promociones);
            }

        }
        else{
            $lista=[];
            $juicio_sicor_count="";
        }
        return [$lista, $datos, $juicio_sicor_count, $lista_promociones];
    }

    /*
    *   MINISTERIO DE LEY
    */
    public static function obtener_ministerioLey_lista(Request $request){

        $response = $request
        ->clienteWS
        ->request('get', 'obtenerMinisterios',[
            "query" => [
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id")
            ]
        ]);
        
        $response = json_decode($response->getBody(),true) ;
        return $response;
    }

    public static function editar_ministerioLey(Request $request, $id_ministerio, $datos){

        $response = $request
        ->clienteWS
        ->request('PATCH', 'modificarMinisterio/'.$id_ministerio,[
            "json" => [
                "datos" => [
                    "sustituyente" => $datos['sustituyente'],
                    "fecha_inicio" => $datos['fecha_inicio'],
                    "fecha_termino"=> $datos['fecha_termino'],
                    "activo"=> $datos['activo']
                ]
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id")
            ]
        ]);
        
        $response = json_decode($response->getBody(),true) ;
        return $response;
    }

    public static function agregar_ministerioLey(Request $request, $datos){

        $response = $request
        ->clienteWS
        ->request('POST', 'nuevoMinisterio',[
            "json" => [ 
                "datos" => [
                    "id_titular" => $datos['id_titular'],
                    "id_sustituyente" => $datos['id_sustituyente'],
                    "fecha_inicio" => $datos['fecha_inicio'],
                    "fecha_termino"=> $datos['fecha_termino']
                ]
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id")
            ]
        ]);
        
        $response = json_decode($response->getBody(),true) ;
        return $response;
    }

    public static function ministerio_migrar_firmas(Request $request, $id_titular, $id_sustituyente){

        $response = $request
        ->clienteWS
        ->request('PATCH', 'ministerio_migrar_firmas/'.$id_titular.'/'.$id_sustituyente,[
            "json" => [ 
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id")
            ]
        ]);
        
        $response = json_decode($response->getBody(),true) ;
        return $response;
    }

    public static function ministerio_regresar_firmas(Request $request, $id_titular, $id_sustituyente){

        $response = $request
        ->clienteWS
        ->request('PATCH', 'ministerio_regresar_firmas/'.$id_titular.'/'.$id_sustituyente,[
            "json" => [ 
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id")
            ]
        ]);
        
        $response = json_decode($response->getBody(),true) ;
        return $response;
    }

    public static function obtener_ministerio_lista(Request $request){

        $response = $request
        ->clienteWS
        ->request('get', 'obtener_personas_ministerio/',[
            "query" => [
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id")
            ]
        ]);
        
        $response = json_decode($response->getBody(),true) ;
        return $response;
    }


    /*
    *   GRUPOS
    */
    public static function obtener_grupos_lista(Request $request, $juzgado){

        $response = $request
        ->clienteWS
        ->request('get', 'consultarGrupoTrabajo/',[
            "query" => [
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id")
            ]
        ]);
        
        $response = json_decode($response->getBody(),true) ;
        return $response;
    }

    public static function obtener_participantes_grupos(Request $request, $juzgado){

        $response = $request
        ->clienteWS
        ->request('get', 'usuariosParaGrupo/'.$juzgado,[
            "query" => [
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id")
            ]
        ]);
        
        $response = json_decode($response->getBody(),true) ;
        return $response;
    }

    public static function guardar_participante_grupo(Request $request, $juzgado, $id_grupo_trabajo, $id_usuario, $area, $ponencia){

        $response = $request
        ->clienteWS
        ->request('POST', 'agregarAGrupoTrabajo/'.$juzgado,[
            "json" => [
                "datos" => [
                    "id_usuario" => $id_usuario,
                    "id_superior" => $id_grupo_trabajo,
                    "rol"=> 'empleado',
                    "area"=> $area,
                    "ponencia"=> $ponencia,
                    "nivel"=> 3,
                    "permiso_firma"=>1
                ]
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id")
            ]
        ]);
        
        $response = json_decode($response->getBody(),true) ;
        return $response;
    }

    public static function modificar_participante_grupo(Request $request, $id_grupo_trabajo, $id_usuario, $id_superior_txt){

        $response = $request
        ->clienteWS
        ->request('PATCH', 'modificarIntegrante',[
            "json" => [
                "datos" => [
                    "id_usuario" => $id_usuario,
                    "id_grupo" => $id_grupo_trabajo,
                    "id_superior" => $id_superior_txt
                ]
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id")
            ]
        ]);
        
        $response = json_decode($response->getBody(),true) ;
        return $response;
    }

    /*
    *   acciones
    */
    public static function obetner_acciones(Request $request, $usuario_id){

        $response = $request
        ->clienteWS
        ->request('get', 'obetner_acciones/'.$usuario_id,[
            "query" => [
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id")
            ]
        ]);
        
        $response = json_decode($response->getBody(),true) ;
        return $response;
    }

    public static function obtener_valor_permiso_accion(Request $request, $permiso_id){

        $response = $request
        ->clienteWS
        ->request('get', 'obtener_valor_permiso_accion/'.$permiso_id,[
            "query" => [
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id")
            ]
        ]);
        
        $response = json_decode($response->getBody(),true) ;
        return $response;
    }


}