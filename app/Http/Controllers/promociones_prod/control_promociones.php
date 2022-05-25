<?php
namespace App\Http\Controllers\promociones;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//clases
use App\Http\Controllers\clases\promociones;
use App\Http\Controllers\clases\archivos;
use App\Http\Controllers\clases\libros_front;
use App\Http\Controllers\clases\humanRelativeDate;
use GuzzleHttp\Client;

class control_promociones extends Controller
{

    public function inicio( Request $request, $bandeja ){

        //dd($bandeja);
        if($bandeja=='iniciales'){
            $datos['tipo_documento']='inic';
        }
        else{
            $datos['tipo_documento']='pos';
        }
        $datos['fecha']='';
        $datos['confirmados']='';
        $datos['no_confirmados']='';
        $datos['juzgado_sicor']=$request->session()->get('usuario_juzgado');
        $datos['id_juicio']='';
        $datos['pagina']='1';
        $datos['registros_por_pagina']='10';

        //se buscan las promciones
        $lista=promociones::consultarPromociones($request, $datos);

        //se pone el catalogo
        if(isset($lista['response'][0]['tipo_expediente'])){
            for($i=0; $i<count($lista['response']); $i++){
                $lista['response'][$i]['tipo_expediente_texto']=control_promociones::getCatalogoExpedientes($lista['response'][$i]['tipo_expediente']);

                for($j=0; $j<count($lista['response'][$i]['adjuntos']); $j++){
                    if($lista['response'][$i]['adjuntos'][$j]['json_archivo']!=""){
                        $lista['response'][$i]['adjuntos'][$j]['json_arr']=json_decode($lista['response'][$i]['adjuntos'][$j]['json_archivo']);
                    }
                    else{
                        $lista['response'][$i]['adjuntos'][$j]['json_archivo']=array();
                    }
                }
            }
        }

        //se madna a la vista
        return view(    "promociones.promociones",
            ["entorno"=>$request->entorno,
            "request"=>$request,
            "sesion"=>$request->session()->all(),
            "menu_general"=>$request->menu_general,
            "bandeja"=>$bandeja,
            "lista"=>$lista
            ]
        );
    }


    public function nueva_promcion( Request $request ){

        //se madna a la vista
        return view(    "promociones.nueva_promociones",
            ["entorno"=>$request->entorno,
            "request"=>$request,
            "sesion"=>$request->session()->all(),
            "menu_general"=>$request->menu_general
            ]
        );
    }


    public function validar_toca_ajax( Request $request ){

        $promocion_id=0;
        if($request->session()->get('juzgado_tipo')=='sala'){

            $input = $request->all();
            $toca=$input['toca'];
            $anio_toca=$input['anio_toca'];
            $asunto_toca=$input['asunto_toca'];

            //bucamos el expediente
            unset($datos);
            $datos['asunto_toca']=$asunto_toca;
            $datos['por_turnar']='';
            $datos['expediente']='-';
            $datos['expediente_anio']='-';
            $datos['involucrados_nombre']='-';
            $datos['involucrados_apellido_paterno']='-';
            $datos['involucrados_apellido_materno']='-';
            $datos['registrado_desde']='-';
            $datos['registrado_hasta']='-';
            $datos['toca']=$toca;
            $datos['anio_toca']=$anio_toca;
            $datos['tipo_archivo']='-';


            $lista_expediente=archivos::obtener_listado_archivos($request, $datos);


            //se pone la plantilla
            $plantilla_archivo_body=print_r($lista_expediente, true);
            $plantilla_archivo_header='';
            include "plantilla_asignar_promocion_nueva.php";
        }
        else{
            $input = $request->all();
            $expediente=$input['toca'];
            $expediente_anio=$input['anio_toca'];
            $expediente_bis=$input['asunto_toca'];

            //bucamos el expediente
            unset($datos);
            $datos['expediente']=$expediente;
            $datos['expediente_anio']=$expediente_anio;
            $datos['id_expediente']='';
            $datos['expediente_bis']=$expediente_bis;
            $datos['registrado_desde']='';
            $datos['registrado_hasta']='';
            $datos['involucrados_nombre']='';
            $datos['involucrados_apellido_paterno']='';
            $datos['involucrados_apellido_materno']='';

            $lista_expediente=archivos::obtener_listado_archivos_juzgados($request, $datos);
            $promocion_id=0;
            //se pone la plantilla
            $plantilla_archivo_body=print_r($lista_expediente, true);
            $plantilla_archivo_header='';
            include "plantilla_asignar_promocion_nueva_juzgado.php";


        }
        return response()->json(['plantilla_archivo_header'=>$plantilla_archivo_header, 'plantilla_archivo_body'=>$plantilla_archivo_body]);
    }


    public function buscar_promocion_ajax( Request $request ){

        $input = $request->all();
        $bandeja=$input['bandeja'];

        //dd($bandeja);
        if($bandeja=='iniciales'){
            $datos['tipo_documento']='inic';
        }
        else{
            $datos['tipo_documento']='POS';
        }

        $datos['fecha']='';
        if($input['fecha']!=""){
            $datos['fecha']=$input['fecha'];
        }

        $datos['confirmados']='';
        $datos['no_confirmados']='';
        if($input['tipo']=='n'){
            $datos['no_confirmados']='1';
        }
        if($input['tipo']=='c'){
            $datos['confirmados']='1';
        }

        $datos['juzgado_sicor']=$request->session()->get('usuario_juzgado');
        $datos['id_juicio']='';


        ($input['pagina']=="-") ? $datos['pagina']="1" : $datos['pagina']=$input['pagina'];
        ($input['registros_por_pagina']=="-") ? $datos['registros_por_pagina']="10" : $datos['registros_por_pagina']=$input['registros_por_pagina'];

        //se buscan las promciones
        $lista=promociones::consultarPromociones($request, $datos);

        $humanRelativeDate = new humanRelativeDate();
        if(isset($lista['response'][0]['fecha_recepcion'])){
            //se pone el catalogo
            for($i=0; $i<count($lista['response']); $i++){

                //se ajusta la fecha
                $fecha_arr=explode(' ', $lista['response'][$i]['fecha_recepcion']);
                $fechaHumana=$humanRelativeDate->getTextForSQLDate($fecha_arr[0]);
                $lista['response'][$i]['fecha_humana']=$fechaHumana;
                $lista['response'][$i]['fecha_1']=$fecha_arr[0];
                $lista['response'][$i]['fecha_2']=$fecha_arr[1];

                //se agrega al catalogo
                $lista['response'][$i]['tipo_expediente_texto']=control_promociones::getCatalogoExpedientes($lista['response'][$i]['tipo_expediente']);

                for($j=0; $j<count($lista['response'][$i]['adjuntos']); $j++){
                    if($lista['response'][$i]['adjuntos'][$j]['json_archivo']!=""){
                        $lista['response'][$i]['adjuntos'][$j]['json_arr']=json_decode($lista['response'][$i]['adjuntos'][$j]['json_archivo']);
                    }
                }
            }
        }
        return response()->json($lista);
    }



    public function buscar_promocion_juzgado( Request $request ){

        $input = $request->all();

        //return response()->json($input);

        $bandeja=$input['bandeja'];
        if($bandeja=='iniciales'){
            $datos['tipo_documento']='inic';
        }
        else{
            $datos['tipo_documento']='POS';
        }

        $datos['fecha']='';
        $datos['no_confirmados']='';
        $datos['confirmados']='1';

        $datos['juzgado_sicor']=$request->session()->get('usuario_juzgado');
        $datos['id_juicio']=$input['id_juicio'];

        //se buscan las promciones
        $lista=promociones::consultarPromociones($request, $datos);


        $humanRelativeDate = new humanRelativeDate();
        if(isset($lista['response'][0]['fecha_recepcion'])){
            //se pone el catalogo
            for($i=0; $i<count($lista['response']); $i++){

                //se ajusta la fecha
                $fecha_arr=explode(' ', $lista['response'][$i]['fecha_recepcion']);
                $fechaHumana=$humanRelativeDate->getTextForSQLDate($fecha_arr[0]);
                $lista['response'][$i]['fecha_humana']=$fechaHumana;
                $lista['response'][$i]['fecha_1']=$fecha_arr[0];
                $lista['response'][$i]['fecha_2']=$fecha_arr[1];

                //se agrega al catalogo
                $lista['response'][$i]['tipo_expediente_texto']=control_promociones::getCatalogoExpedientes($lista['response'][$i]['tipo_expediente']);

                for($j=0; $j<count($lista['response'][$i]['adjuntos']); $j++){
                    if($lista['response'][$i]['adjuntos'][$j]['json_archivo']!=""){
                        $lista['response'][$i]['adjuntos'][$j]['json_arr']=json_decode($lista['response'][$i]['adjuntos'][$j]['json_archivo']);
                    }
                }
            }
        }
        return response()->json($lista);
    }



    public function guardar_asignacion(Request $request){
        $input = $request->all();

        $datos=[];
        //$lista=archivos::insertar_juicio_sicor($request, $datos);
        //return $lista;

        //exit;
        if($input['juicio_id']!=0){
            $lista=promociones::editar_promocion_asignacion($request, $input['promocion_id'], $input['juicio_id']);
            return response()->json($lista);
        }
        else{

            if($input['tipo_juicio_id']==357){
                $request->session()->flash('tipo_juicio_id', 623);
            }
            else if($input['tipo_juicio_id']==358){
                $request->session()->flash('tipo_juicio_id', 622);
            }
            else if($input['tipo_juicio_id']==360){
                $request->session()->flash('tipo_juicio_id', 625);
            }
            else{
                $request->session()->flash('tipo_juicio_id', 0);
            }
            $request->session()->flash('promocion_id', $input['promocion_id']);
            return redirect()->away("/juicio/nuevo/");
        }
    }

    public function buscar_expediente_ajax( Request $request ){
        $input = $request->all();
        //return response()->json($input);

        $arr_expediente=explode('/', $input['expediente']);
        $promocion_id=$input['promocion_id'];
        $tipo_juicio_id=$input['tipo_juicio_id'];
        $promocion_tipo_tramite_divorcio=$input['promocion_tipo_tramite_divorcio']; 
        $fecha=$input['fecha'];
        $origen=$input['origen'];

        $datos=[];

        if(isset($arr_expediente[0])){
            $datos['expediente']=$arr_expediente[0];
        }
        if(isset($arr_expediente[1])){
            $datos['expediente_anio']=$arr_expediente[1];
        }

        $lista_expediente=archivos::obtener_listado_sicor($request, $datos);


        $plantilla_archivo_body=print_r($input, true).'<br><br>'.print_r($datos, true).'<br><br>';
        $plantilla_archivo_header='';

        //return response()->json(['plantilla_archivo_header'=>$plantilla_archivo_header, 'plantilla_archivo_body'=>$plantilla_archivo_body]);

        if(($tipo_juicio_id!=357 and $tipo_juicio_id!=358 and $tipo_juicio_id!=360) or $origen=='OPC'){

            $plantilla_archivo_body=print_r($lista_expediente, true).'<br><br>'.print_r($datos, true).'<br><br>';
            $plantilla_archivo_header='';

            include "plantilla_asignar_promocion_confirmar_sicor.php";
            return response()->json(['plantilla_archivo_header'=>$plantilla_archivo_header, 'plantilla_archivo_body'=>'SICOR'.$plantilla_archivo_body]);

        }
        else if($promocion_tipo_tramite_divorcio==0){
            include "plantilla_asignar_promocion_confirmar_sicor.php";
            return response()->json(['plantilla_archivo_header'=>$plantilla_archivo_header, 'plantilla_archivo_body'=>'SICOR'.$plantilla_archivo_body]);
        }
        else if(($tipo_juicio_id==357 or $tipo_juicio_id==358 or $tipo_juicio_id==360) and $promocion_tipo_tramite_divorcio==0 and $fecha<"2020-07-13"){


            include "plantilla_asignar_promocion_confirmar_sicor.php";
            return response()->json(['plantilla_archivo_header'=>$plantilla_archivo_header, 'plantilla_archivo_body'=>'SICOR'.$plantilla_archivo_body]);
        }


        if($request->session()->get('juzgado_tipo')=='sala'){
            //bucamos el expediente
            unset($datos);
            $datos['toca']='';
            $datos['anio_toca']='';
            $datos['asunto_toca']='';
            $datos['por_turnar']='';
            $datos['expediente']='';
            $datos['expediente_anio']='';
            $datos['involucrados_nombre']='';
            $datos['involucrados_apellido_paterno']='';
            $datos['involucrados_apellido_materno']='';
            $datos['registrado_desde']='';
            $datos['registrado_hasta']='';
            $datos['tipo_archivo']='';

            if(isset($arr_expediente[0])){
                $datos['toca']=$arr_expediente[0];
            }
            if(isset($arr_expediente[1])){
                $datos['anio_toca']=$arr_expediente[1];
            }
            if(isset($arr_expediente[2])){
                $datos['asunto_toca']=$arr_expediente[2];
            }

            $lista_expediente=archivos::obtener_listado_archivos($request, $datos);

            //se pone la plantilla
            $plantilla_archivo_body=print_r($lista_expediente, true);
            $plantilla_archivo_header='';
            include "plantilla_asignar_promocion_confirmar.php";
        }
        else{

            //bucamos el expediente
            unset($datos);
            $datos['expediente']='';
            $datos['expediente_anio']='';
            $datos['id_expediente']='';
            $datos['expediente_bis']='';
            $datos['registrado_desde']='';
            $datos['registrado_hasta']='';
            $datos['involucrados_nombre']='';
            $datos['involucrados_apellido_paterno']='';
            $datos['involucrados_apellido_materno']='';

            if(isset($arr_expediente[0])){
                $datos['expediente']=$arr_expediente[0];
            }
            if(isset($arr_expediente[1])){
                $datos['expediente_anio']=$arr_expediente[1];
            }
            if(isset($arr_expediente[2])){
                $datos['expediente_bis']=$arr_expediente[2];
            }

            $lista_expediente=archivos::obtener_listado_archivos_juzgados($request, $datos);

            //se pone la plantilla
            $plantilla_archivo_body=print_r($lista_expediente, true);
            $plantilla_archivo_header='';
            include "plantilla_asignar_promocion_confirmar_juzgado.php";
        }
        return response()->json(['plantilla_archivo_header'=>$plantilla_archivo_header, 'plantilla_archivo_body'=>$plantilla_archivo_body]);
    }



    public function promocion_guardar( Request $request ){

        $input = $request->all();
        $arr_juicio=explode('/', $input['juicio_promocion']);

        unset($datos); 
        $datos['origen']='SIGJ WEB';
        $datos['idDocumento']=!is_null($request['idDocumento']) ? $request['idDocumento'] : '0' ;
        $datos['bandera_tramite_divorcio']=!is_null($request['bandera_tramite_divorcio']) ? $request['bandera_tramite_divorcio'] : '0' ;
        $datos['juzgado']=!is_null($request['juzgado']) ? $request['juzgado'] : '-' ;
        $datos['idMateria']=!is_null($request['idMateria']) ? $request['idMateria'] : '-' ;
        $datos['noExpediente']=$arr_juicio[0];
        $datos['anioExpediente']=$arr_juicio[1];
        $datos['fechaRecepcion']=!is_null($request['fechaRecepcion']) ? $request['fechaRecepcion']." ".$request['tp3'] : '-' ;
        $datos['tipoJuicio']=!is_null($request['tipoJuicio']) ? $request['tipoJuicio'] : '0' ;
        $datos['reg_date']=date('Y-m-d');
        $datos['idExpediente']=0 ;
        $datos['id_juicio']=!is_null($request['id_juicio_promocion']) ? $request['id_juicio_promocion'] : '-' ;
        $datos['tipoDocumento']=!is_null($request['tipoDocumento']) ? $request['tipoDocumento'] : '-' ;
        $datos['idGestor']=!is_null($request['idGestor']) ? $request['idGestor'] : '0' ;
        $datos['partes']['actores']=[];
        $datos['partes']['demandados']=[];
        $datos['adjuntos']=[];
        $datos['juzgado_sicor']=$request->session()->get('usuario_juzgado');

        $datos['opc_promocion_nombreCapturista']='-' ;
        $datos['opc_promocion_emailCapturista']= '-' ;
        $datos['opc_promocion_telefonoCapturista']= '-' ;
        $datos['estatus_traslado']=!is_null($request['estatus_traslado']) ? $request['estatus_traslado'] : '-' ;
        $datos['fecha_pago_traslado']=!is_null($request['fecha_pago_traslado']) ? $request['fecha_pago_traslado'] : '-' ;
        $datos['num_transaccion_traslado']=!is_null($request['num_transaccion_traslado']) ? $request['num_transaccion_traslado'] : '-' ;
        $datos['opc_promocion_bandera_mensaje']=!is_null($request['opc_promocion_bandera_mensaje']) ? $request['opc_promocion_bandera_mensaje'] : '0' ;

        
        $lista=promociones::guardar_promocion($request, $datos); 
        //dd($lista);
        $id_juicio=$datos['id_juicio'];
        //$id_juicio=1592267616;
        //$lista['response']['id_promocion']=1593141963;

        if(isset($lista['response']['id_promocion'])){

            //se obtiene la info para el gestor
            if($request->session()->get('juzgado_tipo')=='sala'){

                $lista_expediente=archivos::obtener_archivo($request, $id_juicio);

                $metadatos='';

                //462946899|6|1|1.0|C|C11|2020|6010|103|JUZGADO 11 DE LO CIVIL|Thu Jun 25 19:58:24 CDT 2020|MICHELINES||103
                if(isset($lista_expediente['response']['datos_toca'][0]['id_juicio'])){

                    //se sube el pdf
                    $url_promocion="";
                    if($request->archivo_acuerdo->isValid()){
                        $url_promocion=$request->archivo_acuerdo->store('temporales');
                    }
                    $docuemntoPDF='/san/www/html/sicor_extendido_80/storage/app/'.$url_promocion;
                    $b64_promocion_pdf=(base64_encode(file_get_contents($docuemntoPDF, "r")));


                    //datos generales
                    $expediente=$lista_expediente['response']['datos_toca'][0]['toca'];
                    $expediente_anio=$lista_expediente['response']['datos_toca'][0]['anio_toca'];
                    $juicio=$lista_expediente['response']['datos_toca'][0]['juicio'];
                    $id_catalogo_juicios=$lista_expediente['response']['datos_toca'][0]['id_catalogo_juicios'];

                    //partes
                    $actores="";
                    if(isset($lista_expediente['response']['partes']['partes']['actor'][0]['nombres'])){
                        for($i=0; $i<count($lista_expediente['response']['partes']['partes']['actor']); $i++){
                            if($i==0){
                                $actores.=$lista_expediente['response']['partes']['partes']['actor'][$i]['nombres'];
                            }
                            else{
                                $actores.=", ".$lista_expediente['response']['partes']['partes']['actor'][$i]['nombres'];
                            }

                        }
                    }
                    $demandado="";
                    if(isset($lista_expediente['response']['partes']['partes']['demandado'][0]['nombres'])){
                        for($i=0; $i<count($lista_expediente['response']['partes']['partes']['demandado']); $i++){
                            if($i==0){
                                $demandado.=$lista_expediente['response']['partes']['partes']['demandado'][$i]['nombres'];
                            }
                            else{
                                $demandado.=", ".$lista_expediente['response']['partes']['partes']['demandado'][$i]['nombres'];
                            }
                        }
                    }

                    //se otiene la materia SIGJ a OPC
                    $materia_opc=$this->getMateria($request->session()->get('juzgado_subtipo'));
                    //numero SIGJ a OPC
                    $materias_arr = array("PIC", "PIF", "JCO", "PC", "JFO", "CJM", "SF", "SC");
                    $numero = str_replace($materias_arr, "", $request->session()->get('usuario_juzgado'));
                    $numero=$this->getNumeroJuzgadoSIGJtoOPC($request->session()->get('juzgado_subtipo'), $numero);


                    $docuemntoPDF='/san/www/html/sicor_extendido_80/storage/app/documentos/blanco.pdf';
                    $b64_pdf=(base64_encode(file_get_contents($docuemntoPDF, "r")));
                    $metadatos=$lista['response']['id_promocion']."|6|1|1.0|$materia_opc|$materia_opc$numero|$expediente_anio|$expediente|$juicio|".$request->session()->get('juzgado_nombre_largo')."|".date('Y-m-d H:i:s')."|$actores|$demandado|$id_catalogo_juicios";

                    //dd($metadatos);
                    //$metadatos=$lista['response']['id_promocion']."|6|1|1.0|C|C1|$expediente_anio|$expediente|$juicio|".$request->session()->get('juzgado_nombre_largo')."|".date('Y-m-d H:i:s')."|$actores|$demandado|$id_catalogo_juicios";




                    //se manda al gestor
                    $full_path = "";
                    if($request->entorno['variables_entorno']['GESTOR_PRODUCCION']==1){
                        $full_path = $request->entorno['variables_entorno']['GESTOR_URL_PRO'].'api/document/';
                    }
                    else{
                        $full_path = $request->entorno['variables_entorno']['GESTOR_URL_DES'].'api/document/';
                    }

                    try{
                        //Cliente gestor 1
                        $cliente_gestor = new Client([
                            "base_uri" => $full_path
                        ]);
                        $json=array (
                            'metadata' => $metadatos,
                            'documents' =>
                            array (
                                0 =>
                                array (
                                    'file64' => $b64_pdf,
                                    'filename' => 'blanco.pdf',
                                ),
                            ),
                        );
                        $response = $cliente_gestor
                        ->request('POST', 'uploadopv',[
                            "json" => $json
                        ]);
                    }
                    catch (\Exception $e) {
                        $request->session()->flash('error', '01 Error al registrar la demanda/promoción');
                        return back();
                    }

                    $return_1=json_decode($response->getBody(),true);
                    if($return_1['documents'][0]['status']==false){
                        $request->session()->flash('error', '03 Error al guardar el documento');
                        return back();
                    }

                    //print_r(json_decode($response->getBody(),true));


                    //Cliente gestor 2
                    $json=array (
                        'instanceName' => "TSJ",
                        'repositoryName' => "OPC",
                        'idDocument' => $lista['response']['id_promocion'],
                        'separatorCode' => "02",
                        'filename' => "promocion.pdf",
                        'file64' => $b64_promocion_pdf
                    );
                    $response = $cliente_gestor
                    ->request('POST', 'uploadopv/attach',[
                        "json" => $json
                    ]);

                    $arr_promocion_gestor=json_decode($response->getBody(),true);
                    //print_r($arr_promocion_gestor);

                    $id_gestor_file=$arr_promocion_gestor['idGlobal'];
                    //print('<br>'.$id_gestor_file);

                    //se actualiza la promocion
                    unset($datos_promocion);
                    $datos_promocion['tipoDocumento']=$datos['tipoDocumento'];
                    $datos_promocion['json_file']=$arr_promocion_gestor;
                    $lista_expediente=promociones::editar_promocion_min($request, $lista['response']['id_promocion'], $datos_promocion);

                    if($lista_expediente['status']==100){
                        $request->session()->flash('succes', 'Se registró exitosamente la demanda/promoción, <a href="javascript:void(0);" onclick="openDocumentoGestor('.$id_gestor_file.');" >consultalo aquí</a>');
                        return back();
                    }
                    else{
                        $request->session()->flash('error', '02 Error al registrar la demanda/promoción');
                        return back();
                    }
                }
            }
            else{
                //bucamos el expediente
                unset($datos_busqueda);
                $datos_busqueda['expediente']='';
                $datos_busqueda['expediente_anio']='';
                $datos_busqueda['id_expediente']=$id_juicio;
                $datos_busqueda['expediente_bis']='';
                $datos_busqueda['registrado_desde']='';
                $datos_busqueda['registrado_hasta']='';
                $datos_busqueda['involucrados_nombre']='';
                $datos_busqueda['involucrados_apellido_paterno']='';
                $datos_busqueda['involucrados_apellido_materno']='';

                $lista_expediente=archivos::obtener_listado_archivos_juzgados($request, $datos_busqueda);

                $metadatos='';

                //462946899|6|1|1.0|C|C11|2020|6010|103|JUZGADO 11 DE LO CIVIL|Thu Jun 25 19:58:24 CDT 2020|MICHELINES||103
                if(isset($lista_expediente['response'][0]['datos_archivo']['id_juicio'])){

                    //se sube el pdf
                    $url_promocion="";
                    if($request->archivo_acuerdo->isValid()){
                        $url_promocion=$request->archivo_acuerdo->store('temporales');
                    }
                    $docuemntoPDF='/san/www/html/sicor_extendido_80/storage/app/'.$url_promocion;
                    $b64_promocion_pdf=(base64_encode(file_get_contents($docuemntoPDF, "r")));


                    //datos generales
                    $expediente=$lista_expediente['response'][0]['datos_archivo']['expediente'];
                    $expediente_anio=$lista_expediente['response'][0]['datos_archivo']['anio'];
                    $juicio=$lista_expediente['response'][0]['tipo_juicio'][0]['juicio'];
                    $id_catalogo_juicios=$lista_expediente['response'][0]['tipo_juicio'][0]['id_catalogo_juicios'];

                    //partes
                    $actores="";
                    if(isset($lista_expediente['response'][0]['partes']['actor'][0]['nombre'])){
                        for($i=0; $i<count($lista_expediente['response'][0]['partes']['actor']); $i++){
                            if($i==0){
                                $actores.=$lista_expediente['response'][0]['partes']['actor'][$i]['nombre'].' '.$lista_expediente['response'][0]['partes']['actor'][$i]['apellido_paterno'].' '.$lista_expediente['response'][0]['partes']['actor'][$i]['apellido_materno'];
                            }
                            else{
                                $actores.=", ".$lista_expediente['response'][0]['partes']['actor'][$i]['nombre'].' '.$lista_expediente['response'][0]['partes']['actor'][$i]['apellido_paterno'].' '.$lista_expediente['response'][0]['partes']['actor'][$i]['apellido_materno'];
                            }

                        }
                    }
                    $demandado="";
                    if(isset($lista_expediente['response'][0]['partes']['demandado'][0]['nombre'])){
                        for($i=0; $i<count($lista_expediente['response'][0]['partes']['demandado']); $i++){
                            if($i==0){
                                $demandado.=$lista_expediente['response'][0]['partes']['demandado'][$i]['nombre'].' '.$lista_expediente['response'][0]['partes']['demandado'][$i]['apellido_paterno'].' '.$lista_expediente['response'][0]['partes']['demandado'][$i]['apellido_materno'];
                            }
                            else{
                                $demandado.=", ".$lista_expediente['response'][0]['partes']['demandado'][$i]['nombre'].' '.$lista_expediente['response'][0]['partes']['demandado'][$i]['apellido_paterno'].' '.$lista_expediente['response'][0]['partes']['demandado'][$i]['apellido_materno'];
                            }
                        }
                    }

                    //se otiene la materia SIGJ a OPC
                    $materia_opc=$this->getMateria($request->session()->get('juzgado_subtipo'));
                    //numero SIGJ a OPC

                    $materias_arr = array("PIC", "PIF", "JCO", "PC", "JFO", "CJM", "SF", "SC");
                    $numero = str_replace($materias_arr, "", $request->session()->get('usuario_juzgado'));
                    $numero=$this->getNumeroJuzgadoSIGJtoOPC($request->session()->get('juzgado_subtipo'), $numero);


                    $docuemntoPDF='/san/www/html/sicor_extendido_80/storage/app/documentos/blanco.pdf';
                    $b64_pdf=(base64_encode(file_get_contents($docuemntoPDF, "r")));
                    $metadatos=$lista['response']['id_promocion']."|6|1|1.0|$materia_opc|$materia_opc$numero|$expediente_anio|$expediente|$juicio|".$request->session()->get('juzgado_nombre_largo')."|".date('Y-m-d H:i:s')."|$actores|$demandado|$id_catalogo_juicios";

                    //dd($metadatos); 

                    //se manda al gestor
                    $full_path = "";
                    if($request->entorno['variables_entorno']['GESTOR_PRODUCCION']==1){
                        $full_path = $request->entorno['variables_entorno']['GESTOR_URL_PRO'].'api/document/';
                    }
                    else{
                        $full_path = $request->entorno['variables_entorno']['GESTOR_URL_DES'].'api/document/';
                    }



                    try{
                        //Cliente gestor 1
                        $cliente_gestor = new Client([
                            "base_uri" => $full_path
                        ]);
                        $json=array (
                            'metadata' => $metadatos,
                            'documents' =>
                            array (
                                0 =>
                                array (
                                    'file64' => $b64_pdf,
                                    'filename' => 'blanco.pdf',
                                ),
                            ),
                        );
                        $response = $cliente_gestor
                        ->request('POST', 'uploadopv',[
                            "json" => $json
                        ]);
                    }
                    catch (\Exception $e) {
                        $request->session()->flash('error', '01 Error al registrar la demanda/promoción');
                        return back();
                    }

                    $arr_promocion_gestor_1=json_decode($response->getBody(),true);

                    if($arr_promocion_gestor_1['documents'][0]['status']==""){
                        $request->session()->flash('error', 'ERROR GESTOR ' . $arr_promocion_gestor_1['documents'][0]['message']);
                    }


 

                    //Cliente gestor 2
                    $json=array (
                        'instanceName' => "TSJ",
                        'repositoryName' => "OPC",
                        'idDocument' => $lista['response']['id_promocion'],
                        'separatorCode' => "02",
                        'filename' => "promocion.pdf",
                        'file64' => $b64_promocion_pdf
                    );
                    $response = $cliente_gestor
                    ->request('POST', 'uploadopv/attach',[
                        "json" => $json
                    ]);

                    $arr_promocion_gestor=json_decode($response->getBody(),true);
                    //print_r($arr_promocion_gestor);

                    $id_gestor_file=$arr_promocion_gestor['idGlobal'];
                    //print('<br>'.$id_gestor_file);

                    //se actualiza la promocion
                    unset($datos_promocion);
                    $datos_promocion['tipoDocumento']=$datos['tipoDocumento'];
                    $datos_promocion['json_file']=$arr_promocion_gestor;
                    $lista_expediente=promociones::editar_promocion_min($request, $lista['response']['id_promocion'], $datos_promocion);


                    //se guarda en libro de gobierno
                    unset($datos_libro);
                    $datos_libro['juzgado_subtipo']=$request->session()->get('juzgado_subtipo');
                    $datos_libro['juzgado_tipo']=$request->session()->get('juzgado_tipo');
                    $datos_libro['usuario_juzgado']=$request->session()->get('usuario_juzgado');
                    $datos_libro['usuario_id']=$request->session()->get('usuario_id');
                    $datos_libro['id_juzgado']=$id_juicio;
                    $datos_libro['expediente']=$expediente;
                    $datos_libro['anio']=$expediente_anio;
                    $datos_libro['bis']="";
                    $datos_libro['fecha_recepcion']=$request['fechaRecepcion'];
                    $datos_libro['hora_recepcion']=$request['tp3'];
                    $datos_libro['info_anexos']="1";

                    /*
                    $datos_libro['anio_judicial']="2020";
                    $datos_libro['promovente']="1";
                    $datos_libro['paterno_fisica']="1";
                    $datos_libro['materno_fisica']="1";
                    $datos_libro['nombre_fisica']="1";
                    $datos_libro['razon_social']="1";
                    $datos_libro['observaciones']="1";
                   */



                    $lista_libro=libros_front::guardarLibroPromocionesJFO($request, $datos_libro);
                    //dd($lista_libro);

                    if($lista_expediente['status']==100){
                        $request->session()->flash('succes', 'Se registró exitosamente la demanda/promoción, <a href="javascript:void(0);" onclick="openDocumentoGestor('.$id_gestor_file.');" >consultalo aquí</a>');
                        return back();
                    }
                    else{
                        $request->session()->flash('error', '02 Error al registrar la demanda/promoción');
                        return back();
                    }

                }

            }
        }

        $request->session()->flash('error', '03 Error al registrar la demanda/promoción');
        return back();
    }


    /*
    *   conexión WS
    */
    public function gestor_guardar_doc( Request $request ){
        $input = $request->all();

        $fp = fopen("/san/www/html/sicor_extendido_80/public/log/gestor_".date("Y_m_d").".txt","a");
        fwrite($fp, date("Y-m-d H:i:s")." ".print_r($input, true) . "\t\n");
        fclose($fp);

        if(isset($input['id_expediente_opc'])){

            $data_json='{"status":true,"message":"document saved","idDocument":'.$input['idGlobal'].',"url":"'.$input['url'].'"}';

            $datos['adjuntos'][]=[
                "id_expediente_opc" => isset($input['id_expediente_opc']) ? $input['id_expediente_opc'] : 0,
                "nombre" => "GESTOR DOCUMENTAL",
                "data_json" => $data_json
            ];

            $lista=promociones::alta_adjunto_promocion($request, $input['id_documento'], $datos);

            $texto=[];
            if(isset($lista['response'][0])){
                $texto["response"]=100;
                $texto["mensaje"]=$lista['response'][0];
            }
            else{
                $texto["response"]=0;
                $texto["mensaje"]=$lista['message'];
            }

            return response()->json($texto);
        }
        else{
            $texto=[];
            $texto["response"]=0;
            $texto["mensaje"]="llave faltante";
            return response()->json($texto);
        }
    }


    public function opc_promocion_guardar( Request $request ){
        $input = $request->all();

        $fp = fopen("/san/www/html/sicor_extendido_80/public/log/opv_".date("Y_m_d").".txt","a");
        fwrite($fp, date("Y-m-d H:i:s")." ".print_r($input, true) . "\t\n");
        fclose($fp);





        $header_key = $request->header('key_ws');
        $texto=[];
        $llave_acceso='';
        if($request->entorno['variables_entorno']['OPC_PRODUCCION']==1){
            $llave_acceso=$request->entorno['variables_entorno']['OPC_LLAVE_PRO'];
        }
        else{
            $llave_acceso=$request->entorno['variables_entorno']['OPC_LLAVE_DES'];
        }

        if($header_key==$llave_acceso or 1){

            $input = $request->all();

            $myfile = fopen("/san/www/html/sicor_extendido_80/public/temporales/newfile1.txt", "w") or die("Unable to open file!");
            $txt = "Input: ".print_r($input, true);
            fwrite($myfile, $txt);
            fclose($myfile);

            $juzgado_numero=substr($request['juzgado'],1);
            $juzgado_sicor="";
            $juzgado_sicor=$this::getJuzgadoSicor($request["juzgado"], $request["idMateria"]);


            //return response()->json($request);


            //actores
            $arr_actores1=json_decode($request['arr_actores']);


            $arr_actores=$arr_actores1->actores;

            //demandados
            $arr_demandados1=(isset($request['arr_demandados']) && !empty($request['arr_demandados'])) ? json_decode($request['arr_demandados'], true): "";
            $arr_demandados=array();

            if(isset($arr_demandados1['demandados'])){

                $arr_demandados=$arr_demandados1['demandados'];
            }


            //adjuntos
            $json_adjuntos = (isset($request["adjuntos"]) && !empty($request["adjuntos"])) ? json_decode($request["adjuntos"], true) : "";


            $actores=array();
            for($i=0; $i<count($arr_actores); $i++){
                $actores[$i]['nombres']=($arr_actores[$i]->razonSocial=="" and $arr_actores[$i]->nombre=="") ? '-' : $arr_actores[$i]->razonSocial."".$arr_actores[$i]->nombre;
                $actores[$i]['apellido_paterno']=($arr_actores[$i]->apPaterno!="") ? $arr_actores[$i]->apPaterno : '-' ;
                $actores[$i]['apellido_materno']=($arr_actores[$i]->apMaterno!="") ? $arr_actores[$i]->apMaterno : '-' ;
                $actores[$i]['correo']=(isset($arr_actores[$i]->email) and $arr_actores[$i]->email!="") ? $arr_actores[$i]->email : '-' ;

                if($arr_actores[$i]->tipoPersona=='M'){
                    $actores[$i]['tipo_persona']='moral';
                }
                else{
                    $actores[$i]['tipo_persona']='fisica';
                }

                $actores[$i]['promovente']=0;
                $actores[$i]['id_opc']=$arr_actores[$i]->idPersona;
            }

            $demandados=array();
            for($i=0; $i<count($arr_demandados); $i++){
                $demandados[$i]['nombres']=($arr_demandados[$i]['razonSocial']=="" and $arr_demandados[$i]['nombre']=="") ? '-' : $arr_demandados[$i]['razonSocial']."".$arr_demandados[$i]['nombre'];

                $demandados[$i]['apellido_paterno']=($arr_demandados[$i]['apPaterno']!="") ? $arr_demandados[$i]['apPaterno'] : '-' ;
                $demandados[$i]['apellido_materno']=($arr_demandados[$i]['apMaterno']!="") ? $arr_demandados[$i]['apMaterno'] : '-' ;
                $demandados[$i]['correo']=(isset($arr_demandados[$i]['email']) and $arr_demandados[$i]['email']!="") ? $arr_demandados[$i]['email'] : '-' ;

                if($arr_demandados[$i]['tipoPersona']=='M'){
                    $demandados[$i]['tipo_persona']='moral';
                }
                else{
                    $demandados[$i]['tipo_persona']='fisica';
                }

                $demandados[$i]['promovente']=0;
                $demandados[$i]['id_opc']=$arr_demandados[$i]['idPersona'];
            }



            // $adjuntos=array();
            // for($i=0; $i<count($arr_adjuntos); $i++){
            //     $adjuntos[$i]['nombre']=$arr_adjuntos[$i]->nombre;
            //     $adjuntos[$i]['b64']=$arr_adjuntos[$i]->base64;
            // }

            $array_adjuntos = array();
            if(is_array($json_adjuntos))
            {
                foreach($json_adjuntos as $valor)
                {
                    if(isset($valor["url"])){
                        $array_url = explode("/", $valor["url"]);
                        $nueva_url = "";

                        foreach($array_url as $index => $valor_url)
                        {
                            $nueva_url .= ($index >= 3 ) ? "/" . $valor_url : "";
                        }
                        $valor["url"] = $nueva_url;
                        array_push($array_adjuntos, array("data_json" => $valor));
                    }
                }
            }

 

            unset($datos);
            $datos['origen']=!is_null($request['origen']) ? $request['origen'] : '-' ;
            $datos['idDocumento']=!is_null($request['idDocumento']) ? $request['idDocumento'] : '0' ;
            $datos['juzgado']=!is_null($request['juzgado']) ? $request['juzgado'] : '-' ;
            $datos['idMateria']=!is_null($request['idMateria']) ? $request['idMateria'] : '-' ;
            $datos['noExpediente']=!is_null($request['noExpediente']) ? $request['noExpediente'] : '-' ;
            $datos['anioExpediente']=!is_null($request['anioExpediente']) ? $request['anioExpediente'] : '-' ;
            $datos['fechaRecepcion']=!is_null($request['fechaRecepcion']) ? $request['fechaRecepcion'] : '-' ;
            $datos['tipoJuicio']=!is_null($request['tipoJuicio']) ? $request['tipoJuicio'] : '-' ;
            $datos['reg_date']=!is_null($request['reg_date']) ? $request['reg_date'] : '-' ;
            $datos['idExpediente']=!is_null($request['idExpediente']) ? $request['idExpediente'] : '-' ;
            $datos['tipoDocumento']=!is_null($request['tipoDocumento']) ? $request['tipoDocumento'] : '-' ;
            $datos['idGestor']=!is_null($request['idGestor']) ? $request['idGestor'] : '0' ;
            $datos['bandera_tramite_divorcio']=!is_null($request['tipoTramiteDivorcio']) ? $request['tipoTramiteDivorcio'] : '0' ;
            $datos['partes']['actores']=$actores;
            $datos['partes']['demandados']=$demandados;
            $datos['adjuntos']=$array_adjuntos;
            $datos['juzgado_sicor']=$juzgado_sicor;
            $datos['opc_promocion_nombreCapturista']=!is_null($request['nombreCapturista']) ? $request['nombreCapturista'] : '-' ;
            $datos['opc_promocion_emailCapturista']=!is_null($request['emailCapturista']) ? $request['emailCapturista'] : '-' ;
            $datos['opc_promocion_telefonoCapturista']=!is_null($request['telefonoCapturista']) ? $request['telefonoCapturista'] : '-' ;
            $datos['estatus_traslado']=!is_null($request['estatus_traslado']) ? $request['estatus_traslado'] : '-' ;
            $datos['fecha_pago_traslado']=!is_null($request['fecha_pago_traslado']) ? $request['fecha_pago_traslado'] : '-' ;
            $datos['num_transaccion_traslado']=!is_null($request['num_transaccion_traslado']) ? $request['num_transaccion_traslado'] : '-' ;
            $datos['opc_promocion_bandera_mensaje']=!is_null($request['opc_promocion_bandera_mensaje']) ? $request['opc_promocion_bandera_mensaje'] : '0' ;
            $datos['id_juicio']=0;

            //return response()->json($datos);

            $lista=promociones::guardar_promocion($request, $datos);
            //return($lista);

            if($lista['status']==100){
                $texto["response"]=100;
                $texto["mensaje"]="";
                $texto["id"]=$lista["response"]["id_promocion"];
            }
            else{
                $texto["response"]=0;
                $texto["mensaje"]=$lista['message'];
            }
            return response()->json($texto);
        }
        $texto=[];
        $texto["response"]=0;
        $texto["mensaje"]="clave incorrecta";
        return response()->json($texto);
    }


    public function opc_promocion_editar( Request $request ){

        $header_key = $request->header('key_ws');

        if($header_key=='dev_opc' or 1){

            $input = $request->all();

            if(isset($request['id_sicor'])){
                $id_sicor=$request['id_sicor'];
            }
            else{
                $texto["response"]=0;
                $texto["mensaje"]="sin llave principal";
                return response()->json($texto);
            }

            $myfile = fopen("/san/www/html/sicor_extendido_80/public/temporales/newfile2.txt", "w") or die("Unable to open file!");
            $txt = "Input: ".print_r($input, true);
            fwrite($myfile, $txt);
            fclose($myfile);


            $juzgado_sicor="-";
            //$juzgado_numero=substr($request['juzgado'],1);
            //$juzgado_sicor=$this::getJuzgadoSicor($request["juzgado"], $request["idMateria"]);

            //actores
            $arr_actores1=json_decode($request['arr_actores']);
            $arr_actores=$arr_actores1->actores;

            //demandados
            $arr_demandados1=json_decode($request['arr_demandados']);
            $arr_demandados=array();
            if(isset($arr_demandados1->demandados)){
                $arr_demandados=$arr_demandados1->demandados;
            }

            $actores=array();
            for($i=0; $i<count($arr_actores); $i++){
                $actores[$i]['nombres']=$arr_actores[$i]->razonSocial."".$arr_actores[$i]->nombre;
                $actores[$i]['apellido_paterno']=($arr_actores[$i]->apPaterno!="") ? $arr_actores[$i]->apPaterno : '-' ;
                $actores[$i]['apellido_materno']=($arr_actores[$i]->apMaterno!="") ? $arr_actores[$i]->apMaterno : '-' ;
                $actores[$i]['correo']=(isset($arr_actores[$i]->email) and $arr_actores[$i]->email!="") ? $arr_actores[$i]->email : '-' ;

                if($arr_actores[$i]->tipoPersona=='M'){
                    $actores[$i]['tipo_persona']='moral';
                }
                else{
                    $actores[$i]['tipo_persona']='fisica';
                }

                $actores[$i]['promovente']=0;
                $actores[$i]['id_opc']=$arr_actores[$i]->idPersona;
            }

            $demandados=array();
            for($i=0; $i<count($arr_demandados); $i++){
                $demandados[$i]['nombres']=$arr_demandados[$i]->razonSocial."".$arr_demandados[$i]->nombre;

                $demandados[$i]['apellido_paterno']=($arr_demandados[$i]->apPaterno!="") ? $arr_demandados[$i]->apPaterno : '-' ;
                $demandados[$i]['apellido_materno']=($arr_demandados[$i]->apMaterno!="") ? $arr_demandados[$i]->apMaterno : '-' ;
                $demandados[$i]['correo']=(isset($arr_demandados[$i]->email) and $arr_demandados[$i]->email!="") ? $arr_demandados[$i]->email : '-' ;

                if($arr_demandados[$i]->tipoPersona=='M'){
                    $demandados[$i]['tipo_persona']='moral';
                }
                else{
                    $demandados[$i]['tipo_persona']='fisica';
                }

                $demandados[$i]['promovente']=0;
                $demandados[$i]['id_opc']=$arr_demandados[$i]->idPersona;
            }

            unset($datos);
            $datos['origen']=!is_null($request['origen']) ? $request['origen'] : '-' ;
            $datos['idDocumento']=!is_null($request['idDocumento']) ? $request['idDocumento'] : '0' ;
            $datos['juzgado']=!is_null($request['juzgado']) ? $request['juzgado'] : '-' ;
            $datos['idMateria']=!is_null($request['idMateria']) ? $request['idMateria'] : '-' ;
            $datos['noExpediente']=!is_null($request['noExpediente']) ? $request['noExpediente'] : '-' ;
            $datos['anioExpediente']=!is_null($request['anioExpediente']) ? $request['anioExpediente'] : '-' ;
            $datos['fechaRecepcion']=!is_null($request['fechaRecepcion']) ? $request['fechaRecepcion'] : '-' ;
            $datos['tipoJuicio']=!is_null($request['tipoJuicio']) ? $request['tipoJuicio'] : '-' ;
            $datos['reg_date']=!is_null($request['reg_date']) ? $request['reg_date'] : '-' ;
            $datos['idExpediente']=!is_null($request['idExpediente']) ? $request['idExpediente'] : '-' ;
            $datos['tipoDocumento']=!is_null($request['tipoDocumento']) ? $request['tipoDocumento'] : '-' ;
            $datos['idGestor']=!is_null($request['idGestor']) ? $request['idGestor'] : '0' ;
            $datos['bandera_tramite_divorcio']=!is_null($request['tipoTramiteDivorcio']) ? $request['tipoTramiteDivorcio'] : '0' ;
            $datos['opc_promocion_nombreCapturista']=!is_null($request['nombreCapturista']) ? $request['nombreCapturista'] : '-' ;
            $datos['opc_promocion_emailCapturista']=!is_null($request['emailCapturista']) ? $request['emailCapturista'] : '-' ;
            $datos['opc_promocion_telefonoCapturista']=!is_null($request['telefonoCapturista']) ? $request['telefonoCapturista'] : '-' ;
            $datos['estatus_traslado']=!is_null($request['estatus_traslado']) ? $request['estatus_traslado'] : '-' ;
            $datos['fecha_pago_traslado']=!is_null($request['fecha_pago_traslado']) ? $request['fecha_pago_traslado'] : '-' ;
            $datos['num_transaccion_traslado']=!is_null($request['num_transaccion_traslado']) ? $request['num_transaccion_traslado'] : '-' ;


            $datos['partes']['actores']=$actores;
            $datos['partes']['demandados']=$demandados;
            $datos['juzgado_sicor']=$juzgado_sicor;
            $datos['id_juicio']='-';

            $lista=promociones::editar_promocion($request, $id_sicor, $datos);

            //return response()->json($lista);

            if($lista['status']==100){
                $texto["response"]=100;
                $texto["mensaje"]="success";
            }
            else{
                $texto["response"]=0;
                $texto["mensaje"]=$lista['message'];
            }
            return response()->json($texto);
        }
        $texto["response"]=0;
        $texto["mensaje"]="clave incorrecta";
        return response()->json($texto);
    }

    public function opc_promocion_eliminar( Request $request, $id_promocion, $proceso ){

        $response = $request
            ->clienteWS
            ->request("DELETE", "eliminacion_promocion/".$id_promocion."/".$proceso);

        return json_decode( $response->getBody(), true );

    }


    public static function getJuzgadoSicor($juzgado, $materia){

        $materias_arr = array("C", "F", "V", "U", "R", "B", "SF", "SC");
        $juzgado_numero = str_replace($materias_arr, "", $juzgado);


        $juzgado_sicor="";
        //civil
        if($materia=='C'){
            $juzgado_sicor=$juzgado_numero;
            $juzgado_sicor.="PIC";
        }
        //familiar
        else if($materia=='F'){
            $juzgado_sicor=$juzgado_numero;
            $juzgado_sicor.="PIF";
        }
        //CIVIL DE PROCESO ORAL
        else if($materia=='V'){
            $juzgado_sicor=$juzgado_numero;
            $juzgado_sicor.="JCO";
        }
        //CUANTÍA MENOR
        else if($materia=='U'){
            if($juzgado_numero==1) $juzgado_sicor="2";
            if($juzgado_numero==2) $juzgado_sicor="3";
            if($juzgado_numero==3) $juzgado_sicor="7";
            if($juzgado_numero==4) $juzgado_sicor="8";
            if($juzgado_numero==5) $juzgado_sicor="10";
            if($juzgado_numero==6) $juzgado_sicor="11";
            if($juzgado_numero==7) $juzgado_sicor="12";
            if($juzgado_numero==8) $juzgado_sicor="13";
            if($juzgado_numero==9) $juzgado_sicor="15";
            if($juzgado_numero==10) $juzgado_sicor="16";
            if($juzgado_numero==11) $juzgado_sicor="17";
            if($juzgado_numero==12) $juzgado_sicor="21";
            if($juzgado_numero==13) $juzgado_sicor="22";
            if($juzgado_numero==14) $juzgado_sicor="27";
            if($juzgado_numero==15) $juzgado_sicor="33";
            if($juzgado_numero==16) $juzgado_sicor="36";
            if($juzgado_numero==17) $juzgado_sicor="42";
            if($juzgado_numero==18) $juzgado_sicor="43";
            if($juzgado_numero==19) $juzgado_sicor="44";
            if($juzgado_numero==20) $juzgado_sicor="46";
            if($juzgado_numero==21) $juzgado_sicor="50";
            if($juzgado_numero==22) $juzgado_sicor="54";
            if($juzgado_numero==23) $juzgado_sicor="57";
            if($juzgado_numero==24) $juzgado_sicor="58";
            if($juzgado_numero==25) $juzgado_sicor="63";
            if($juzgado_numero==26) $juzgado_sicor="66";
            if($juzgado_numero==27) $juzgado_sicor="67";
            $juzgado_sicor.="PC";
        }
        //FAMILIAR DE PROCESO ORAL
        else if($materia=='R'){
            $juzgado_sicor=$juzgado_numero;
            $juzgado_sicor.="JFO";
        }
        //PROCESO ORAL EN MATERIA FAMILIAR DE JUSTICIA PARA LAS MUJURES
        else if($materia=='B'){
            $juzgado_sicor=$juzgado_numero;
            $juzgado_sicor.="CJM";
        }
        else if($materia=='SC'){
            $juzgado_sicor=$juzgado_numero;
            $juzgado_sicor.="SC";
        }
        else if($materia=='SF'){
            $juzgado_sicor=$juzgado_numero;
            $juzgado_sicor.="SF";
        }
        else{
            $juzgado_sicor='100PIF';
        } 

        return $juzgado_sicor;
    }

    public static function getCatalogoExpedientes($id){

        $data_tipo_juicio[]='';
        $data_tipo_juicio[101]='EJECUTIVO CIVIL';
        $data_tipo_juicio[102]='PRESCRIPCION POSITIVA';
        $data_tipo_juicio[103]='REIVINDICATORIOS';
        $data_tipo_juicio[105]='JURIS. VOLUNTARIA';
        $data_tipo_juicio[106]='ESPECIAL HIPOTECARIO';
        $data_tipo_juicio[107]='PROVID. PRECAUTORIAS';
        $data_tipo_juicio[108]='MEDIOS PREPARATORIOS';
        $data_tipo_juicio[109]='ORDINARIO CIVIL';
        $data_tipo_juicio[113]='VIA DE APREMIO';
        $data_tipo_juicio[114]='SOLICITUDES DE EJECUCION DE CONVENIOS';
        $data_tipo_juicio[117]='INCOMPETENCIA INHIBITORIA';
        $data_tipo_juicio[118]='ORDINARIO CIVIL NULIDAD DE JUICIO CONCLUIDO';
        $data_tipo_juicio[119]='ORDINARIO CIVIL DAÑO MORAL';
        $data_tipo_juicio[123]='VIA DE APREMIO - CJA';
        $data_tipo_juicio[151]='EXTINCION DE DOMINIO';
        $data_tipo_juicio[152]='MEDIDAS CAUTELARES';
        $data_tipo_juicio[160]='ORAL CIVIL';
        $data_tipo_juicio[170]='JURISDICCION VOLUNTARIA';
        $data_tipo_juicio[198]='INTERDICTO';
        $data_tipo_juicio[199]='OTROS';
        $data_tipo_juicio[201]='EJECUTIVO MERCANTIL';
        $data_tipo_juicio[203]='ORDINARIO MERCANTIL';
        $data_tipo_juicio[208]='MEDIOS PREPARATORIOS A JUICIO';
        $data_tipo_juicio[210]='ESPECIAL DE FIANZAS';
        $data_tipo_juicio[211]='ESPECIAL MERCANTIL';
        $data_tipo_juicio[212]='PROCEDIMIENTO JUDICIAL DE EJECUCION DE GARANTIA OTORGADA MEDIANTE PRENDA SIN TRANSMISIÓN DE POSESION';
        $data_tipo_juicio[213]='JUICIO ESPECIAL DE TRANSACCIONES COMERCIALES Y ARBITRAJE';
        $data_tipo_juicio[260]='ORAL MERCANTIL';
        $data_tipo_juicio[261]='EJECUTIVO MERCANTIL ORAL';
        $data_tipo_juicio[262]='MEDIOS PREPARATORIOS A EJECUTIVO MERCANTIL EN MATERIA ORAL MERCANTIL';
        $data_tipo_juicio[263]='PROVIDENCIAS PRECAUTORIAS EN MATERIA ORAL MERCANTIL';
        $data_tipo_juicio[270]='MEDIOS PREPARATORIOS';
        $data_tipo_juicio[271]='PROVIDENCIAS PRECAUTORIAS';
        $data_tipo_juicio[301]='DIVORCIO NECESARIO';
        $data_tipo_juicio[302]='ALIMENTOS';
        $data_tipo_juicio[303]='DIVORCIO VOLUNTARIO';
        $data_tipo_juicio[305]='JURISDICCION VOLUNTARIA';
        $data_tipo_juicio[306]='INTESTAMENTARIO';
        $data_tipo_juicio[307]='TESTAMENTARIO';
        $data_tipo_juicio[308]='ADOPCION NACIONAL';
        $data_tipo_juicio[310]='MEDIOS PREPARATORIOS';
        $data_tipo_juicio[311]='INTERDICCION';
        $data_tipo_juicio[312]='ORDINARIO';
        $data_tipo_juicio[313]='CONTROVERSIA';
        $data_tipo_juicio[314]='RESTITUCION DE MENORES INTERNACIONAL';
        $data_tipo_juicio[315]='DIVORCIO INCAUSADO';
        $data_tipo_juicio[316]='TRANSEXO';
        $data_tipo_juicio[317]='SOLICITUDES DE EJECUCION DE CONVENIOS';
        $data_tipo_juicio[318]='ADOPCION INTERNACIONAL';
        $data_tipo_juicio[320]='INCOMPETENCIA INHIBITORIA';
        $data_tipo_juicio[321]='ADOPCION POR EXTRANJEROS';
        $data_tipo_juicio[323]='FAMILIAR ÓRDENES DE PROTECCIÓN';
        $data_tipo_juicio[340]='ORAL FAMILIAR ÓRDENES DE PROTECCIÓN';
        $data_tipo_juicio[341]='DIVORCIO INCAUSADO SOLICITADO POR AMBAS PARTES';


        $data_tipo_juicio[356]='JURISDICCION VOLUNTARIA';
        $data_tipo_juicio[357]='DIVORCIO INCAUSADO SOLICITADO POR AMBAS PARTES';
        $data_tipo_juicio[358]='DEPENDENCIA ECONÓMICA';


        $data_tipo_juicio[359]='AUTORIZACIÓN PARA SALIDA DE MENORES DEL PAIS';
        $data_tipo_juicio[360]='ACREDITACIÓN DE CONCUBINATO';
        $data_tipo_juicio[361]='NULIDAD DE MATRIMONIO';
        $data_tipo_juicio[362]='PÉRDIDA DE LA PATRIA POTESTAD DE MENORES ACOGIDOS POR UNA INSTITUCIÓN PÚBLICA O PRIVADA DE ASISTENCIA SOCIAL';
        $data_tipo_juicio[363]='ACCIONES DERIVADAS DE LA PATRIA POTESTAD';
        $data_tipo_juicio[365]='INTERDICCIÓN CONTENCIOSA';
        $data_tipo_juicio[367]='ACCIONES DERIVADAS DE LA FILIACIÓN';
        $data_tipo_juicio[368]='ADOPCIÓN NACIONAL';
        $data_tipo_juicio[370]='PERDIDA DE LA PATRIA POTESTAD';
        $data_tipo_juicio[378]='NULIDAD DE ACTAS';
        $data_tipo_juicio[379]='CONSTITUCIÓN DE PATRIMONIO FAMILIAR VOLUNTARIO Y FORZOSO';
        $data_tipo_juicio[380]='EXTINCIÓN DE PATRIMONIO FAMILIAR';
        $data_tipo_juicio[381]='DISMINUCIÓN O AUMENTO DE PATRIMONIO DE FAMILIA';
        $data_tipo_juicio[382]='MODIFICACIÓN DE RÉGIMEN PATRIMONIAL';
        $data_tipo_juicio[383]='LIQUIDACIÓN DE SOCIEDAD CONYUGAL, NO CONTENCIOSO';
        $data_tipo_juicio[385]='NULIDAD DE DECLARACIÓN DE ESTADO DE INTERDICCIÓN Y/O CESACIÓN DE INTERDICCIÓN';
        $data_tipo_juicio[389]='OTROS';
        $data_tipo_juicio[390]='MODIFICACION DE CONVENIO';
        $data_tipo_juicio[399]='OTROS';
        $data_tipo_juicio[403]='DESAHUCIO';
        $data_tipo_juicio[404]='CONSIGNACION';
        $data_tipo_juicio[405]='JURISDICCION VOLUNTARIA';
        $data_tipo_juicio[410]='MEDIOS PREPARATORIOS';
        $data_tipo_juicio[411]='PROVIDENCIAS PRECAUTORIAS';
        $data_tipo_juicio[416]='ORDINARIO';
        $data_tipo_juicio[417]='CONTROVERSIA DE ARRENDAMIENTO';
        $data_tipo_juicio[418]='LAUDO ARBITRAL';
        $data_tipo_juicio[419]='SOLICITUDES DE EJECUCION DE CONVENIOS';
        $data_tipo_juicio[499]='OTROS';
        $data_tipo_juicio[602]='INMATRICULACIÓN';
        $data_tipo_juicio[901]='ORAL';
        $data_tipo_juicio[902]='EJECUTIVO MERCANTIL';
        $data_tipo_juicio[903]='ORDINARIO MERCANTIL';
        $data_tipo_juicio[904]='MEDIOS PREPARATORIOS';
        $data_tipo_juicio[905]='PROVIDENCIAS PRECAUTORIAS';
        $data_tipo_juicio[906]='DILIGENCIAS PRELIMINARES DE CONSIGNACION';
        $data_tipo_juicio[907]='ESPECIAL HIPOTECARIO';
        $data_tipo_juicio[908]='EJECUTIVO CIVIL';
        $data_tipo_juicio[909]='ORDINARIO CIVIL';
        $data_tipo_juicio[910]='JURISDICCION VOLUNTARIA';
        $data_tipo_juicio[911]='MEDIOS PREPARATORIOS A JUICIO EJECUTIVO MERCANTIL';
        $data_tipo_juicio[912]='DAÑO A LA PROPIEDAD CULPOSO';
        $data_tipo_juicio[913]='SOL EJECUCIÓN DE CONVENIOS';
        $data_tipo_juicio[914]='DAÑO MORAL';
        $data_tipo_juicio[915]='PROCEDIMIENTO JUDICIAL DE EJECUCION DE GARANTIA OTORGADA MEDIANTE PRENDA SIN TRANSMISIÓN DE POSESION';
        $data_tipo_juicio[999]='OTROS';
        /*
        $data_tipo_juicio[353]='DEPENDENCIA ECONOMICA';
        $data_tipo_juicio[354]='DIVORCIO INCAUSADO SOLICITADO POR AMBAS PARTES';
        $data_tipo_juicio[355]='ACREDITACIÓN DE CONCUBINATO';
        */
        $data_tipo_juicio[0]='GUARDADO SIGJ';

        $data_tipo_juicio[104]='FALTANTE';

        if(!(isset($data_tipo_juicio[$id]))){
            return "NO DEFINIDO";
        }

        return $data_tipo_juicio[$id];
    }

    public static function getMateria($materia_sicor){

        if($materia_sicor=="PIC"){       //ya
            return "C";
        }
        else if($materia_sicor=="PIF"){
            return "F";
        }
        else if($materia_sicor=="JCO"){
            return "V";
        }
        else if($materia_sicor=="PC"){
            return "U";
        }
        else if($materia_sicor=="JFO"){             //revisar si es R o B
            return "R";
        }
        else if($materia_sicor=="CJM"){
            return "B";
        }
        else if($materia_sicor=='SF'){
            return "SF";
        }
        else if($materia_sicor=='SC'){
            return "SC";
        }
        else{
            return $materia_sicor;
        }
    }


    public static function getNumeroJuzgadoSIGJtoOPC($materia_sigj, $numero_sigj){

        $numero_opc=$numero_sigj;

        //civil
        if($materia_sigj=='PIC'){
            $numero_opc=$numero_sigj;
        }
        //familiar
        else if($materia_sigj=='PIF'){
            $numero_opc=$numero_sigj;
        }
        //CIVIL DE PROCESO ORAL
        else if($materia_sigj=='JCO'){
            $numero_opc=$numero_sigj;
        }
        //CIVIL DE PROCESO ORAL
        else if($materia_sigj=='JFO'){
            $numero_opc=$numero_sigj;
        }
        //CUANTÍA MENOR
        else if($materia_sigj=='PC'){
            if($numero_sigj==2) $numero_opc="1";
            if($numero_sigj==3) $numero_opc="2";
            if($numero_sigj==7) $numero_opc="3";
            if($numero_sigj==8) $numero_opc="4";
            if($numero_sigj==10) $numero_opc="5";
            if($numero_sigj==11) $numero_opc="6";
            if($numero_sigj==12) $numero_opc="7";
            if($numero_sigj==13) $numero_opc="8";
            if($numero_sigj==15) $numero_opc="9";
            if($numero_sigj==16) $numero_opc="10";
            if($numero_sigj==17) $numero_opc="11";
            if($numero_sigj==21) $numero_opc="12";
            if($numero_sigj==22) $numero_opc="13";
            if($numero_sigj==27) $numero_opc="14";
            if($numero_sigj==33) $numero_opc="15";
            if($numero_sigj==36) $numero_opc="16";
            if($numero_sigj==42) $numero_opc="17";
            if($numero_sigj==43) $numero_opc="18";
            if($numero_sigj==44) $numero_opc="19";
            if($numero_sigj==46) $numero_opc="20";
            if($numero_sigj==50) $numero_opc="21";
            if($numero_sigj==54) $numero_opc="22";
            if($numero_sigj==57) $numero_opc="23";
            if($numero_sigj==58) $numero_opc="24";
            if($numero_sigj==63) $numero_opc="25";
            if($numero_sigj==66) $numero_opc="26";
            if($numero_sigj==67) $numero_opc="27";

        }
        //FAMILIAR DE PROCESO ORAL
        else if($materia_sigj=='R'){
            $numero_opc=$numero_sigj;
        }
        //PROCESO ORAL EN MATERIA FAMILIAR DE JUSTICIA PARA LAS MUJURES
        else if($materia_sigj=='B'){
            $numero_opc=$numero_sigj;
        }
        //SALAS FAMILIARES
        else if($materia_sigj=='SF'){
            $numero_opc=$numero_sigj;
        }
        else if($materia_sigj=='SC'){
            $numero_opc=$numero_sigj;
        }
        else{
            $numero_opc=$numero_sigj;
        }
        return $numero_opc;
    }


}