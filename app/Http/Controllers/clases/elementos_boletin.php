<?php
namespace App\Http\Controllers\clases;

use Illuminate\Http\Request;
use App\Http\Controllers\clases\utilidades;

class elementos_boletin{

    public static function calculo_numero_boletin(Request $request, $fecha){

        
        $response = $request
        ->clienteWS
        ->request('get', 'calculo_numero_boletin',[
            "query" => [
                "datos" =>[
                    "fecha"=>$fecha,
                    "reporte"=>"no"
                ]
            ],
            "headers" => [
                "autorizacion" => 'minutmanQAEtHReI',
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ]
        ]);
        
        $response= json_decode($response->getBody(),true) ;
        //dd($response);
        return $response;
    }

    public static function calculo_numero_boletin_sinse(Request $request, $fecha){

        
        $response = $request
        ->clienteWS
        ->request('get', 'calculo_numero_boletin',[
            "query" => [
                "datos" =>[
                    "fecha"=>$fecha,
                    "reporte"=>"no"
                ]
            ],
            "headers" => [
                "autorizacion" => 'minutmanQAEtHReI',
                "Content-Type" => "application/json"
            ]
        ]);
        
        $response= json_decode($response->getBody(),true) ;
        //dd($response);
        return $response;
    }

    public static function obtener_boletin(Request $request, $fecha, $juzgado=""){

        
        $response = $request
        ->clienteWS
        ->request('get', 'datosBoletin/'.$fecha.'/'.$juzgado,[
            "query" => [
            ],
            "headers" => [
                "autorizacion" => 'minutmanQAEtHReI',
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ]
        ]);
        
        $response= json_decode($response->getBody(),true) ;
        //dd($response);
        return $response;
    }

    public static function obtener_boletin_anales(Request $request, $fecha, $juzgado=""){

        
        $response = $request
        ->clienteWS
        ->request('get', 'datosBoletinAnales/'.$fecha.'/'.$juzgado,[
            "query" => [
            ],
            "headers" => [
                "autorizacion" => 'minutmanQAEtHReI',
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ]
        ]);
        
        $response= json_decode($response->getBody(),true) ;
        //dd($response);
        return $response;
    }

    public static function obtener_juzgados( Request $request, $subtipo ){

    
        $response = $request
        ->clienteWS
        ->request('get', 'obtenerJuzgadoTipo/'.$subtipo,[
            "query" => [
            ],
            "headers" => [
                "autorizacion" => 'minutmanQAEtHReI',
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ]
        ]);
        
        $response= json_decode($response->getBody(),true) ;

        
        return $response;


    }

    public static function getDiasHabiles($fecha, $diasferiados = array()) {
        //$fecha = '2015-06-22';
        //$diasferiados = ['2015-07-04', '2015-10-31', '2015-12-25'];
        $i = 1;
        $siguienteDiaLaboral = date('Y-m-d', strtotime($fecha . ' +' . $i . ' Weekday'));

        while (in_array($siguienteDiaLaboral, $diasferiados)) {
            $i++;
            $siguienteDiaLaboral = date('Y-m-d', strtotime($fecha . ' +' . $i . ' Weekday'));
        }
    
        return $siguienteDiaLaboral;
    }

    public static function getMesText($mes){
        $mes_arr[1]='Enero';
        $mes_arr[2]='Febrero';
        $mes_arr[3]='Marzo';
        $mes_arr[4]='Abril';
        $mes_arr[5]='Mayo';
        $mes_arr[6]='Junio';
        $mes_arr[7]='Julio';
        $mes_arr[8]='Agosto';
        $mes_arr[9]='Septiembre';

        $mes_arr['01']='Enero';
        $mes_arr['02']='Febrero';
        $mes_arr['03']='Marzo';
        $mes_arr['04']='Abril';
        $mes_arr['05']='Mayo';
        $mes_arr['06']='Junio';
        $mes_arr['07']='Julio';
        $mes_arr['08']='Agosto';
        $mes_arr['09']='Septiembre';


        $mes_arr[10]='Octubre';
        $mes_arr[11]='Noviembre';
        $mes_arr[12]='Diciembre';
        return $mes_arr[$mes];
    }

    public static function getNombreJuicioMin($juicio){
        $arr_juicio['']='';
        $arr_juicio['PENAL']='Penal';
        $arr_juicio['CIVIL']='Civ.';
        $arr_juicio['FAMILIAR']='Fam.';
        $arr_juicio['MERCANTIL']='Merc.';
        $arr_juicio['PAZ CIVIL']='Paz Civ.';
        $arr_juicio['PAZ MERCANTIL']='Paz Merc.';
        $arr_juicio['ORAL CIVIL']='Oral Civ.';
        $arr_juicio['ORAL MERCANTIL']='Oral Merc.';
        $arr_juicio['CUANTÍA MENOR CIVIL']='C.M. Civ.';
        $arr_juicio['CUANTÍA MENOR MERCANTIL']='C.M. Merc.';

        $texto_min="";
        $texto_min=$arr_juicio[$juicio];
        if($texto_min==""){
            $texto_min=$juicio;
        }
        return $texto_min;
    }

    public static function getJuicioCatalogoMin($catalogo_juicio){
        $arr_juicio_catalogo["Actos prejudiciales"]="Act. Perj. %";
        $arr_juicio_catalogo["Arbitraje comercial"]="Arb. Com. %";
        $arr_juicio_catalogo["Concurso voluntario y necesario"]="Conc. Vol.";
        $arr_juicio_catalogo["Contraversias de arrendamiento"]="Controv. Arr.";
        $arr_juicio_catalogo["Controversias del orden familiar"]="Controv. %";
        $arr_juicio_catalogo["Convencional o preferente"]="Conv. o Pref. %";
        $arr_juicio_catalogo["Ejecutivo"]="Ejec. %";
        $arr_juicio_catalogo["Especial de fianzas"]="Esp. Fian.";
        $arr_juicio_catalogo["Especial Hipotecario"]="Esp. Hip.";
        $arr_juicio_catalogo["Especial"]="Esp. %";
        $arr_juicio_catalogo["Exhorto"]="Exh. %";
        $arr_juicio_catalogo["Exhortos"]="Exh. %";
        $arr_juicio_catalogo["Extinción de dominio"]="Ext. Dom.";
        $arr_juicio_catalogo["Inmatriculación Judicial"]="Inmat. Jud.";
        $arr_juicio_catalogo["Juicio arbitral"]="J. Arb.";
        $arr_juicio_catalogo["Jurisdicción voluntaria"]="Juris. Vol. %";
        $arr_juicio_catalogo["Medios preparatorios"]="Med. Prep. %";
        $arr_juicio_catalogo["Oral"]="Oral %";
        $arr_juicio_catalogo["Ordinario civil"]="Ord. Civ. %";
        $arr_juicio_catalogo["Ordinario"]="Ord. %";
        $arr_juicio_catalogo["Providencias precautorias"]="Prov. Prec. %";
        $arr_juicio_catalogo["Quiebra"]="Quiebra";
        $arr_juicio_catalogo["Sucesorio"]="Suc.";
        $arr_juicio_catalogo["Suspensión de pagos"]="Susp. Pagos";
        $arr_juicio_catalogo["Tercerías"]="Ter. %";
        $arr_juicio_catalogo["Venta de prenda"]="Vta. Prenda %";
        $arr_juicio_catalogo["Vía de apremio"]="Vía Aprem. %";
        $arr_juicio_catalogo["Vía ejecutiva"]="Vía Ejec.";
        $arr_juicio_catalogo["Vía especial"]="Vía Esp.";
        $arr_juicio_catalogo["Juicio especial de levantamiento de acta"]="Esp. Lev. Acta";
        $arr_juicio_catalogo["Juicio especial de pérdida de la patria potestad"]="Esp. Pérd. P.P.";
        $arr_juicio_catalogo["Pago de daños culposos causados por motivos del transito de vehiculo"]="Pago daños Veh. %";
        $arr_juicio_catalogo["Ejecución de garantías otorgadas mediante prenda sin transmisión de posesión y fideicomiso de garantía (procedimiento extrajudicial)"]="Ejec. Gar. Prenda Extrajud. %";
        $arr_juicio_catalogo["Ejecución de garantías otorgadas mediante prenda sin transmisión de posesión y fideicomiso de garantía (procedimiento judicial)"]="Ejec. Gar. Prenda Jud. %";
        $arr_juicio_catalogo["Ejecución de sentencias dictadas en el extranjero"]="Ejec. Sent. Extranjero %";
        $arr_juicio_catalogo["Ejecución de sentencias dictadas en el extranjero, derivadas de juicios"]="Ejec. Sent. Extranjero Juicio %";
        $arr_juicio_catalogo["Especial de cancelación y reposición de titulos de crédito"]="Esp. Canc. y Rep. %";

        $texto_min="";
        $texto_min=$arr_juicio_catalogo[$catalogo_juicio];
        if($texto_min==""){
            $texto_min=$catalogo_juicio;
        }
        return $texto_min;
    }

    public static function acomodarCeros($numero, $ceros){
        $valor=$numero;
        for($i=strlen($numero); $i<$ceros; $i++){
            $valor='0'.$valor;
        }
        return $valor;
    }

    public static function crearBoletinToca(Request $request, $fecha){

        $lista_boletin=elementos_boletin::obtener_boletin($request, $fecha);
        $lista_juzgados=elementos_boletin::obtener_juzgados($request, $request->session()->get('juzgado_subtipo'));

        //dd($lista_juzgados);

        $arr_boletin=array();

        $arr_tipo_resolucion=['acuerdo', 'sentencia', 'audiencia'];
        $arr_caso_especial=['normal', 'mal publicado', 'no publicado'];

        $arr_juzgados=['1SC','2SC','3SC','4SC','5SC','6SC','7SC','8SC','9SC','10SC','1SF','2SF','3SF','4SF','5SF'];

        //for($u=0; $u<count($arr_juzgados); $u++){
            $u=14;
            $arr_boletin[$arr_juzgados[$u]]=array();

            //if(isset($lista_boletin['response'][$arr_tipo_resolucion[$n]])){

                for($n=0; $n<count($arr_tipo_resolucion); $n++){

                    $arr_boletin[$arr_juzgados[$u]][$arr_tipo_resolucion[$n]]=array();

                    if(isset($lista_boletin['response'][$arr_tipo_resolucion[$n]])){

                        for($k=0; $k<count($arr_caso_especial); $k++){

                            $arr_boletin[$arr_juzgados[$u]][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]]=array();

                            if(isset($lista_boletin['response'][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]])){

                                if(isset($lista_boletin['response'][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]])){
                                    $arr_boletin[$arr_juzgados[$u]]['general']['juzgado']=$lista_boletin['response'][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][0]['juzgado']['nombre'];
                                    $arr_boletin[$arr_juzgados[$u]]['general']['autoridad']=$lista_boletin['response'][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][0]['secretario_acuerdos'];
                                    $arr_boletin[$arr_juzgados[$u]]['general']['fecha_publicacion']=$lista_boletin['response'][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][0]['secretario_acuerdos'];
                                    $arr_boletin[$arr_juzgados[$u]]['general']['fecha_acuerdos']=$lista_boletin['response'][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][0]['fecha_mostrar'];
                                }
                                for($i=0; $i<count($lista_boletin['response'][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]]); $i++) {

                                    $valor=$lista_boletin['response'][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$i];

                                    $expediente=$valor['expedientes_relacionados'][0]['codigo_organo_pertenece'].'-'.$valor['expedientes_relacionados'][0]['expediente_relacionado_nummero'].'-'.$valor['expedientes_relacionados'][0]['expediente_relacionado_anio'];
                                    if($valor['expedientes_relacionados'][0]['expediente_relacionado_bis']!=''){
                                        $expediente.='-'.elementos_boletin::acomodarCeros($valor['expedientes_relacionados'][0]['expediente_relacionado_bis'], 3);
                                    }

                                    //se revisa si ya existia
                                    $bandera_nuevo=0;
                                    if(!isset($arr_boletin[$arr_juzgados[$u]][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente])){
                                        $bandera_nuevo=1;
                                        //se crea el arreglo
                                        $arr_boletin[$arr_juzgados[$u]][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]=array();
                                    }

                                    
                                    /*
                                    *   PARTES
                                    */
                                    if($bandera_nuevo==1){
                                        $partes='';
                                        for($j=0; $j<count($valor['partes']['actor']); $j++){
                                            $partes.=mb_convert_case($valor['partes']['actor'][$j]['nombre'], MB_CASE_TITLE, "UTF-8");
                                            if($j!=count($valor['partes']['actor'])-1){
                                                $partes.=' y ';
                                            }
                                        }
                                        if(isset($valor['partes']['demandado'])){
                                            if($partes!=""){
                                                $partes.=' vs. ';
                                            }
                                            //$partes.=' vs. ';
                                            for($j=0; $j<count($valor['partes']['demandado']); $j++){
                                                $partes.=mb_convert_case($valor['partes']['demandado'][$j]['nombre'], MB_CASE_TITLE, "UTF-8");
                                                if($j!=count($valor['partes']['demandado'])-1){
                                                    $partes.=' y ';
                                                }
                                            }
                                        }
                                        if(isset($valor['partes']['tercero'])){
                                            if($partes!=""){
                                                $partes.=' vs. ';
                                            }
                                            
                                            for($j=0; $j<count($valor['partes']['tercero']); $j++){
                                                $partes.=mb_convert_case($valor['partes']['tercero'][$j]['nombre'], MB_CASE_TITLE, "UTF-8");
                                                if($j!=count($valor['partes']['tercero'])-1){
                                                    $partes.=' y ';
                                                }
                                            }
                                        }
                                        $partes.='.';
                                        $arr_boletin[$arr_juzgados[$u]][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['partes']=$partes;
                                    }


                                    /*
                                    *   TOCA
                                    */
                                    $toca=$valor['juicio']['toca'].'-'.$valor['juicio']['anio_toca'];
                                    if($valor['juicio']['asunto_toca']!=''){
                                        $toca.='-'.elementos_boletin::acomodarCeros($valor['juicio']['asunto_toca'], 3);
                                    }
                                    /*
                                    *   ANOTACION
                                    */
                                    if($valor['acuerdo']['anotacion']!=""){
                                        $toca.=$valor['acuerdo']['anotacion'];
                                    }

                                    if(!isset($arr_boletin[$arr_juzgados[$u]][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca])){
                                        $arr_boletin[$arr_juzgados[$u]][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]=array();
                                    }

                                    /*
                                    *   TIPO DE JUICIO
                                    */
                                    $tipo_juicio=elementos_boletin::getJuicioCatalogoMin($valor['juicio']['cat_juicio']);
                                    if(strstr($tipo_juicio, '%')){
                                        $materia=elementos_boletin::getNombreJuicioMin($valor['juicio']['cat_materia']);
                                        $tipo_juicio=str_replace('%', $materia, $tipo_juicio);
                                    }
                                    $arr_boletin[$arr_juzgados[$u]][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['tipo_juicio']=$tipo_juicio;

                                    /*
                                    *   PONENCIA
                                    */
                                    $arr_boletin[$arr_juzgados[$u]][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['secretaria']=$valor['juicio']['secretaria'];

                                    /*
                                    *   TIPO EXPEDIENTE
                                    */
                                    $tipo_expediente='';
                                    if($valor['juicio']['tipo_expediente']=='amparo_directo' or $valor['juicio']['tipo_expediente']=='amparo_indirecto' or $valor['juicio']['tipo_expediente']=='amparo_exploratorio'){
                                        $tipo_expediente=' Cuad. Amp.';
                                        if($valor['juicio']['cuaderno']!=''){
                                            $tipo_expediente.=' '.$valor['juicio']['cuaderno'].', ';
                                        }
                                    }
                                    else if($valor['juicio']['tipo_expediente']=='expedientillo' or $valor['juicio']['tipo_expediente']=='expedientillo_no_corresponde'){
                                        $tipo_expediente=' Expdllo.';
                                    }
                                    $arr_boletin[$arr_juzgados[$u]][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['tipo_expediente']=$tipo_expediente;

                                    /*
                                    *   ACUERDOS
                                    */
                                    if(!isset($arr_boletin[$arr_juzgados[$u]][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['acuerdos'])){
                                        $arr_boletin[$arr_juzgados[$u]][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['acuerdos']=1;
                                    }
                                    else{
                                        $arr_boletin[$arr_juzgados[$u]][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['acuerdos']=$arr_boletin[$arr_juzgados[$u]][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['acuerdos']+1;
                                    }

                                    /*
                                    *   PUBLICAR EN
                                    */
                                    if($valor['acuerdo']['publicar_en']=='toca'){
                                        $arr_boletin[$arr_juzgados[$u]][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['publicar_en']='';
                                    }
                                    else if($valor['acuerdo']['publicar_en']=='CUADERNO DE CONSTANCIAS'){
                                        $arr_boletin[$arr_juzgados[$u]][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['publicar_en']='Cuad. de Const.';
                                    }
                                    else if($valor['acuerdo']['publicar_en']=='CUADERNO DE AMAPARO: DEMANDADO'){
                                        $arr_boletin[$arr_juzgados[$u]][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['publicar_en']='Cuad. Amp. Dem.';
                                    }
                                    else if($valor['acuerdo']['publicar_en']=='CUADERNO DE AMAPARO: ACTOR'){
                                        $arr_boletin[$arr_juzgados[$u]][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['publicar_en']='Cuad. Amp. Act.';
                                    }
                                    else if($valor['acuerdo']['publicar_en']=='CUADERNO DE AMAPARO'){
                                        $arr_boletin[$arr_juzgados[$u]][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['publicar_en']='Cuad. Amp.';
                                        if($valor['juicio']['cuaderno']!=""){
                                            $arr_boletin[$arr_juzgados[$u]][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['publicar_en'].=' '.$valor['juicio']['cuaderno'].',';
                                        }
                                    }
                                    else if($valor['acuerdo']['publicar_en']=='REPOSICION DE CUADERNO DE AMPAROS'){
                                        $arr_boletin[$arr_juzgados[$u]][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['publicar_en']='Cuad. Amp.';
                                        if($valor['juicio']['cuaderno']!=""){
                                            $arr_boletin[$arr_juzgados[$u]][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['publicar_en'].=' '.$valor['juicio']['cuaderno'].',';
                                        }
                                    }
                                    else if($valor['acuerdo']['publicar_en']=='CONSTANCIA'){
                                        $arr_boletin[$arr_juzgados[$u]][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['publicar_en']='Const.';
                                    }
                                    else if($valor['acuerdo']['publicar_en']=='EXPEDIENTILLO'){
                                        $arr_boletin[$arr_juzgados[$u]][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['publicar_en']='Expdllo.';
                                    }
                                    else if($valor['acuerdo']['publicar_en']=='CUADERNILLO'){
                                        $arr_boletin[$arr_juzgados[$u]][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['publicar_en']='Cuadernillo.';
                                    }
                                    else{
                                        $arr_boletin[$arr_juzgados[$u]][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['publicar_en']=''.$valor['acuerdo']['publicar_en'];
                                    }

                                    /*
                                    *   ESPECIAL
                                    */
                                    if($valor['acuerdo']['especial']==''){
                                        $arr_boletin[$arr_juzgados[$u]][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['especial']='';
                                    }
                                    else if($valor['acuerdo']['especial']=='no publicado'){
                                        $arr_boletin[$arr_juzgados[$u]][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['especial']='No Publ.';
                                    }
                                    else if($valor['acuerdo']['especial']=='mal publicado' and $valor['acuerdo']['anotacion']==''){
                                        $arr_boletin[$arr_juzgados[$u]][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['especial']='Mal Publ.';
                                    }

                                    $arr_boletin[$arr_juzgados[$u]][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['fecha_especial']='';
                                    if($valor['acuerdo']['fecha_especial']!='0000-00-00' and $valor['acuerdo']['fecha_especial']!='1900-01-01' and $valor['acuerdo']['anotacion']==''){
                                        $arr_fecha=explode('-', $valor['acuerdo']['fecha_especial']);
                                        $arr_boletin[$arr_juzgados[$u]][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['fecha_especial']=$arr_fecha[2].' de '.elementos_boletin::getMesText($arr_fecha[1]);
                                    }
                                }
                            }
                        }
                    }
                }
            //}
        //}
        //dd($arr_boletin);
        return $arr_boletin;
    }


    public static function renderBoletinSala($arr_boletin){
       
        $texto_boletin="";
        foreach($arr_boletin as $key => $arr_juzgados){
            if(isset($arr_juzgados['general'])){
                $texto_boletin='<h1>'.mb_convert_case($arr_juzgados['general']['juzgado'], MB_CASE_UPPER, "UTF-8").'</h1>';

                //  TITULOS
                foreach($arr_juzgados as $key_1 => $arr_tipo_resolucion){
                    if(count($arr_juzgados[$key_1])!=0 and $key_1!='general'){
                        if($key_1=='acuerdo'){
                            $arr_fecha=explode('-', $arr_juzgados['general']['fecha_acuerdos']);

                            $texto_boletin.='<h2 >'.strtoupper($key_1).'S DEL '.$arr_fecha[2].' DE '.strtoupper(elementos_boletin::getMesText($arr_fecha[1])) .' DEL '.$arr_fecha[0].'</h2>';
                        }
                        else{
                            $texto_boletin.='<h2>'.strtoupper($key_1).'</h2>';
                        }

                        //CASO ESPECIAL
                        foreach($arr_tipo_resolucion as $key => $arr_caso_especial){
                            if($key!='normal' and count($arr_caso_especial)!=0){
                                $texto_boletin.='<h3>'.mb_convert_case($key, MB_CASE_UPPER, "UTF-8").'S</h3>';
                            }

                            //EXPEDIENTES
                            foreach($arr_caso_especial as $key => $arr_expedientes){
                                $texto_boletin.='<div>'.$arr_expedientes['partes'];

                                //TOCAS
                                foreach($arr_expedientes['tocas'] as $key => $arr_tocas){
                                    
                                    $texto_boletin.=' '.$arr_tocas['tipo_juicio'];
                                    $texto_boletin.=' T. '.$key;

                                    if($key_1=="acuerdo"){
                                        if($arr_tocas['acuerdos']==1) $texto_boletin.=', 1 Acdo.';
                                        else $texto_boletin.=', '.$arr_tocas['acuerdos'].' Acdos.';

                                        //publicar en
                                        if($arr_tocas['publicar_en']!="") $texto_boletin.=' en '.$arr_tocas['publicar_en'];
                                    }
                                    else if($key_1=="sentencia"){
                                        if($arr_tocas['secretaria']==""){
                                            $texto_boletin.=' Sent.';
                                        }
                                        else{
                                            $texto_boletin.=' Sent. Pon '.$arr_tocas['secretaria'];
                                        }
                                    }
                                    else{
                                        $texto_boletin.='AUDIENCIA';
                                    }

                                    //si no es ulitmo
                                    if (next($arr_expedientes['tocas'])==true) $texto_boletin .= ",";
                                }
                                $texto_boletin.='</div>';
                            }
                        }
                    }
                }
                $texto_boletin.='<br><h3>EL SECRETARIO DE ACUERDOS<BR>'.mb_convert_case($arr_juzgados['general']['autoridad'], MB_CASE_UPPER, "UTF-8").'</h3>';

            }
            else{
                return '<h1>No hay resoluciones</h1><br><br>';
            }
        }
        return $texto_boletin;
    }



    public static function crearBoletinJuzgado(Request $request, $fecha, $juzgado="", $subtipo="", $nombre_largo=""){

        //dd($fecha);
        if($juzgado==""){
            $lista_boletin=elementos_boletin::obtener_boletin($request, $fecha);
            $lista_juzgados=elementos_boletin::obtener_juzgados($request, $request->session()->get('juzgado_subtipo'));
            $juzgado_texto=$request->session()->get('juzgado_nombre_largo');
        }
        else{
            $lista_boletin=elementos_boletin::obtener_boletin_anales($request, $fecha, $juzgado);
            $lista_juzgados=elementos_boletin::obtener_juzgados($request, $subtipo);
            $juzgado_texto=$nombre_largo;
        }

        //dd($lista_boletin);
 
        $arr_boletin=array();
        
        $arr_juzgados=[];
        $u=0;
        for($i=0; $i<count($lista_juzgados['response']); $i++){
            if($lista_juzgados['response'][$i]['nombre']==$juzgado_texto){
                $u=$i;
            }
            $arr_juzgados[]=$lista_juzgados['response'][$i]['nombre'];
        }

        $arr_tipo_resolucion=['acuerdo', 'sentencia', 'audiencia', 'sentencia definitiva', 'sentencia interlocutoria'];
        $arr_caso_especial=['normal', 'mal publicado', 'no publicado'];

        //$arr_juzgados=['1SC','2SC','3SC','4SC','5SC','6SC','7SC','8SC','9SC','10SC','1SF','2SF','3SF','4SF','5SF'];

        //for($u=0; $u<count($arr_juzgados); $u++){
            
            $arr_boletin[$juzgado_texto]=array();

            //if(isset($lista_boletin['response'][$arr_tipo_resolucion[$n]])){

                $arr_boletin[$arr_juzgados[$u]]['A']=array();
                $arr_boletin[$arr_juzgados[$u]]['B']=array();
                $arr_boletin[$arr_juzgados[$u]]['C']=array();

                for($n=0; $n<count($arr_tipo_resolucion); $n++){


                    $arr_boletin[$arr_juzgados[$u]]['A'][$arr_tipo_resolucion[$n]]=array();
                    $arr_boletin[$arr_juzgados[$u]]['B'][$arr_tipo_resolucion[$n]]=array();
                    $arr_boletin[$arr_juzgados[$u]]['C'][$arr_tipo_resolucion[$n]]=array();

                    
                    
                    


                    if(isset($lista_boletin['response'][$juzgado_texto][$arr_tipo_resolucion[$n]])){

                        //dd($lista_boletin['response'][$juzgado_texto][$arr_tipo_resolucion[$n]]);

                        for($k=0; $k<count($arr_caso_especial); $k++){

                            $arr_boletin[$arr_juzgados[$u]]['A'][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]]=array();
                            $arr_boletin[$arr_juzgados[$u]]['B'][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]]=array();
                            $arr_boletin[$arr_juzgados[$u]]['C'][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]]=array();

                            if(isset($lista_boletin['response'][$juzgado_texto][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]])){

                                
                                
                                
                                for($i=0; $i<count($lista_boletin['response'][$juzgado_texto][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]]); $i++) {

                                    $valor=$lista_boletin['response'][$juzgado_texto][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$i];


                                    if(isset($lista_boletin['response'][$juzgado_texto][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]])){

                                        $arr_boletin[$arr_juzgados[$u]]['general']['juzgado']=$lista_boletin['response'][$juzgado_texto][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$i]['juzgado']['nombre'];
                                        $arr_boletin[$arr_juzgados[$u]]['general']['fecha_acuerdos']=$lista_boletin['response'][$juzgado_texto][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$i]['fecha_mostrar'];

                                        $arr_boletin[$arr_juzgados[$u]][$valor['juicio']['secretaria']]['juzgado']=$lista_boletin['response'][$juzgado_texto][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$i]['juzgado']['nombre'];
                                        $arr_boletin[$arr_juzgados[$u]][$valor['juicio']['secretaria']]['autoridad']=$lista_boletin['response'][$juzgado_texto][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$i]['secretario_acuerdos'];
                                        $arr_boletin[$arr_juzgados[$u]][$valor['juicio']['secretaria']]['fecha_publicacion']=$lista_boletin['response'][$juzgado_texto][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$i]['secretario_acuerdos'];
                                        $arr_boletin[$arr_juzgados[$u]][$valor['juicio']['secretaria']]['fecha_acuerdos']=$lista_boletin['response'][$juzgado_texto][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$i]['fecha_mostrar'];
                                    }



                                   // dd($valor);
                                    $expediente=$valor['juicio']['expediente'].'/'.$valor['juicio']['anio'];
                                    if($valor['juicio']['bis']!=''){
                                        //$expediente.='/'.elementos_boletin::acomodarCeros($valor['juicio']['bis'], 3);
                                        $expediente .= " bis. ".$valor['juicio']['bis'];
                                    }
                                

                                    //se revisa si ya existia
                                    $bandera_nuevo=0;
                                    if(!isset($arr_boletin[$arr_juzgados[$u]][$valor['juicio']['secretaria']][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente])){
                                        $bandera_nuevo=1;
                                        //se crea el arreglo
                                        $arr_boletin[$arr_juzgados[$u]][$valor['juicio']['secretaria']][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]=array();
                                    }
                                    

                                    
                                    /*
                                    *   PARTES
                                    */
                                    if($bandera_nuevo==1){
                                        if($valor['acuerdo']['visibilidad']=="secreto"){
                                            $partes='Secreto.';
                                        }
                                        else{
                                            $partes='';
                                            if(isset($valor['partes']['actor']) and trim($valor['partes']['actor'][0]['nombre'])!=""){
                                                for($j=0; $j<count($valor['partes']['actor']); $j++){
                                                    $partes.=utilidades::titleCase(trim($valor['partes']['actor'][$j]['nombre']));
                                                    if($j!=count($valor['partes']['actor'])-1){
                                                        $partes.=' y ';
                                                    }
                                                }
                                            }
                                            if(isset($valor['partes']['demandado']) and trim($valor['partes']['demandado'][0]['nombre'])!=""){
                                                if($partes!=""){
                                                    $partes.=' vs. ';
                                                }
                                                //$partes.=' vs. ';
                                                for($j=0; $j<count($valor['partes']['demandado']); $j++){
                                                    if(trim($valor['partes']['demandado'][$j]['nombre'])!=""){
                                                        $partes.=utilidades::titleCase(trim($valor['partes']['demandado'][$j]['nombre']));
                                                        if($j!=count($valor['partes']['demandado'])-1){
                                                            $partes.=' y ';
                                                        }
                                                    }
                                                }
                                            }
                                            if(isset($valor['partes']['tercero']) and trim($valor['partes']['tercero'][0]['nombre'])!=""){
                                                if($partes!=""){
                                                    $partes.=' vs. ';
                                                }
                                                //$partes.=' vs. ';
                                                for($j=0; $j<count($valor['partes']['tercero']); $j++){
                                                    if(trim($valor['partes']['tercero'][$j]['nombre'])!=""){
                                                        $partes.=utilidades::titleCase(trim($valor['partes']['tercero'][$j]['nombre']));
                                                        if($j!=count($valor['partes']['tercero'])-1){
                                                            $partes.=' y ';
                                                        }
                                                    }
                                                }
                                            }

                                            $partes.='.';
                                        }
                                        $arr_boletin[$arr_juzgados[$u]][$valor['juicio']['secretaria']][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['partes']=$partes;
                                    }


                                    /*
                                    *   TOCA
                                    */
                                    $toca=$valor['juicio']['toca'].'-'.$valor['juicio']['anio_toca'];
                                    if($valor['juicio']['asunto_toca']!=''){
                                        $toca.='-'.elementos_boletin::acomodarCeros($valor['juicio']['asunto_toca'], 3);
                                    }
                                    /*
                                    *   ANOTACION
                                    */
                                    if($valor['acuerdo']['anotacion']!=""){
                                        $toca.=$valor['acuerdo']['anotacion'];
                                    }

                                    if(!isset($arr_boletin[$arr_juzgados[$u]][$valor['juicio']['secretaria']][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca])){
                                        $arr_boletin[$arr_juzgados[$u]][$valor['juicio']['secretaria']][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]=array();
                                    }

                                    /*
                                    *   TIPO DE JUICIO
                                    * /
                                    $tipo_juicio=elementos_boletin::getJuicioCatalogoMin($valor['juicio']['cat_juicio']);
                                    if(strstr($tipo_juicio, '%')){
                                        $materia=elementos_boletin::getNombreJuicioMin($valor['juicio']['cat_materia']);
                                        $tipo_juicio=str_replace('%', $materia, $tipo_juicio);
                                    }
                                    */
                                    if($valor['juicio']['cat_juicio']==""){
                                        $tipo_juicio=utilidades::titleCase($valor['juicio']['nomco']);
                                    }
                                    else{
                                        $tipo_juicio=utilidades::titleCase($valor['juicio']['cat_juicio']).' '.utilidades::titleCase($valor['juicio']['cat_materia']);
                                    }
                                    
                                    $arr_boletin[$arr_juzgados[$u]][$valor['juicio']['secretaria']][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['tipo_juicio']=$tipo_juicio;

                                    /*
                                    *   PONENCIA
                                    */
                                    $arr_boletin[$arr_juzgados[$u]][$valor['juicio']['secretaria']][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['secretaria']=$valor['juicio']['secretaria'];


                                    /*
                                    *   CONCEPTO
                                    */
                                    $arr_boletin[$arr_juzgados[$u]][$valor['juicio']['secretaria']][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['concepto']=utilidades::titleCase(trim($valor['acuerdo']['concepto']));

                                    /*
                                    *   TIPO EXPEDIENTE
                                    */
                                    $tipo_expediente='';
                                    if($valor['juicio']['tipo_expediente']=='amparo_directo' or $valor['juicio']['tipo_expediente']=='amparo_indirecto' or $valor['juicio']['tipo_expediente']=='amparo_exploratorio'){
                                        $tipo_expediente='Cuad. Amp.';
                                        if($valor['juicio']['cuaderno']!=''){
                                            $tipo_expediente.=' '.$valor['juicio']['cuaderno'].', ';
                                        }
                                    }
                                    else if($valor['juicio']['tipo_expediente']=='expedientillo' or $valor['juicio']['tipo_expediente']=='expedientillo_no_corresponde'){
                                        $tipo_expediente='Expedientillo';
                                    }
                                    else if($valor['juicio']['tipo_expediente']!='expediente'){
                                        $tipo_expediente=utilidades::titleCase($valor['juicio']['tipo_expediente']);
                                    }
                                    
                                    $arr_boletin[$arr_juzgados[$u]][$valor['juicio']['secretaria']][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['tipo_expediente']=$expediente;

                                    

                                    /*
                                    *   PUBLICAR EN
                                    */
                                    if($valor['juicio']['tipo_expediente']=='incidente'){
                                        $arr_boletin[$arr_juzgados[$u]][$valor['juicio']['secretaria']][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['publicar_en']='Insidente';
                                    }
                                    else if($valor['juicio']['tipo_expediente']=='terceria'){
                                        $arr_boletin[$arr_juzgados[$u]][$valor['juicio']['secretaria']][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['publicar_en']='Tercería';
                                    }
                                    else if($valor['juicio']['tipo_expediente']=='exhorto'){
                                        $arr_boletin[$arr_juzgados[$u]][$valor['juicio']['secretaria']][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['publicar_en']='Exhorto';
                                    }
                                    else if($valor['juicio']['tipo_expediente']=='cumplimiento'){
                                        $arr_boletin[$arr_juzgados[$u]][$valor['juicio']['secretaria']][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['publicar_en']='Cumplimiento';
                                    }
                                    else if($valor['juicio']['tipo_expediente']=='seccion_de_ejecucion'){
                                        $arr_boletin[$arr_juzgados[$u]][$valor['juicio']['secretaria']][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['publicar_en']='Seccion de Ejecución';
                                    }
                                    else if($valor['juicio']['tipo_expediente']=='expedientillo_del_cuaderno'){
                                        $arr_boletin[$arr_juzgados[$u]][$valor['juicio']['secretaria']][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['publicar_en']='Expedientillo Cuad. Amp.';
                                    }
                                    else if($valor['juicio']['tipo_expediente']=='sentencia_definitiva'){
                                        $arr_boletin[$arr_juzgados[$u]][$valor['juicio']['secretaria']][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['publicar_en']='Sent. Def.';
                                    }
                                    else if($valor['juicio']['tipo_expediente']=='acuerdos_audiencia'){
                                        $arr_boletin[$arr_juzgados[$u]][$valor['juicio']['secretaria']][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['publicar_en']='Acdos. Audiencia.';
                                    }
                                    else if($valor['juicio']['tipo_expediente']=='OTROS'){
                                        $arr_boletin[$arr_juzgados[$u]][$valor['juicio']['secretaria']][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['publicar_en']='Otros.';
                                    }
                                    


                                    else if($valor['acuerdo']['publicar_en']=='CUADERNO DE CONSTANCIAS'){
                                        $arr_boletin[$arr_juzgados[$u]][$valor['juicio']['secretaria']][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['publicar_en']='Cuad. de Const.';
                                    }
                                    else if($valor['acuerdo']['publicar_en']=='CUADERNO DE AMAPARO: DEMANDADO' or $valor['juicio']['tipo_expediente']=='cuaderno_amparo_dem'){
                                        $arr_boletin[$arr_juzgados[$u]][$valor['juicio']['secretaria']][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['publicar_en']='Cuad. Amp. Dem.';
                                    }
                                    else if($valor['acuerdo']['publicar_en']=='CUADERNO DE AMAPARO: ACTOR' or $valor['juicio']['tipo_expediente']=='cuaderno_amparo_act'){
                                        $arr_boletin[$arr_juzgados[$u]][$valor['juicio']['secretaria']][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['publicar_en']='Cuad. Amp. Act.';
                                    }
                                    else if($valor['juicio']['tipo_expediente']=='cuaderno_amparo_tercerista'){
                                        $arr_boletin[$arr_juzgados[$u]][$valor['juicio']['secretaria']][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['publicar_en']='Cuad. Amp. Ter.';
                                    }
                                    else if($valor['acuerdo']['publicar_en']=='CUADERNO DE AMAPARO'){
                                        $arr_boletin[$arr_juzgados[$u]][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['publicar_en']='Cuad. Amp.';
                                        if($valor['juicio']['cuaderno']!=""){
                                            $arr_boletin[$arr_juzgados[$u]][$valor['juicio']['secretaria']][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['publicar_en'].=' '.$valor['juicio']['cuaderno'].',';
                                        }
                                    }
                                    else if($valor['acuerdo']['publicar_en']=='REPOSICION DE CUADERNO DE AMPAROS'){
                                        $arr_boletin[$arr_juzgados[$u]][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['publicar_en']='Cuad. Amp.';
                                        if($valor['juicio']['cuaderno']!=""){
                                            $arr_boletin[$arr_juzgados[$u]][$valor['juicio']['secretaria']][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['publicar_en'].=' '.$valor['juicio']['cuaderno'].',';
                                        }
                                    }
                                    else if($valor['acuerdo']['publicar_en']=='CONSTANCIA' or $valor['juicio']['tipo_expediente']=='constancia'){
                                        $arr_boletin[$arr_juzgados[$u]][$valor['juicio']['secretaria']][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['publicar_en']='Const.';
                                    }
                                    else if($valor['acuerdo']['publicar_en']=='EXPEDIENTILLO' or $valor['juicio']['tipo_expediente']=='expedientillo'){
                                        $arr_boletin[$arr_juzgados[$u]][$valor['juicio']['secretaria']][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['publicar_en']='Expedientillo';
                                    }
                                    else if($valor['acuerdo']['publicar_en']=='CUADERNILLO' or $valor['juicio']['tipo_expediente']=='cuadernillo'){
                                        $arr_boletin[$arr_juzgados[$u]][$valor['juicio']['secretaria']][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['publicar_en']='Cuadernillo.';
                                    }
                                    else if($valor['acuerdo']['publicar_en']=='EXPEDIENTE' or $valor['juicio']['tipo_expediente']=='expediente' ){
                                        $arr_boletin[$arr_juzgados[$u]][$valor['juicio']['secretaria']][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['publicar_en']='';
                                    }
                                    else{
                                        if($valor['juicio']['tipo_expediente']!=''){
                                            $arr_boletin[$arr_juzgados[$u]][$valor['juicio']['secretaria']][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['publicar_en']=utilidades::titleCase($valor['juicio']['tipo_expediente']);
                                        }
                                        else{
                                            $arr_boletin[$arr_juzgados[$u]][$valor['juicio']['secretaria']][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['publicar_en']=utilidades::titleCase($valor['acuerdo']['publicar_en']);
                                        }
                                        
                                    } 


                                    //dd($arr_boletin);



                                    /*
                                    *   ACUERDOS
                                    */
                                    if(!isset($arr_boletin[$arr_juzgados[$u]][$valor['juicio']['secretaria']][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['acuerdos'])){
                                        $arr_boletin[$arr_juzgados[$u]][$valor['juicio']['secretaria']][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['acuerdos']=array();
                                    }
                                    if(!isset($arr_boletin[$arr_juzgados[$u]][$valor['juicio']['secretaria']][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['acuerdos'][$tipo_expediente."**".$arr_boletin[$arr_juzgados[$u]][$valor['juicio']['secretaria']][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['publicar_en']])){
                                        $arr_boletin[$arr_juzgados[$u]][$valor['juicio']['secretaria']][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['acuerdos'][$tipo_expediente."**".$arr_boletin[$arr_juzgados[$u]][$valor['juicio']['secretaria']][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['publicar_en']]=1;
                                    }
                                    else{
                                        $arr_boletin[$arr_juzgados[$u]][$valor['juicio']['secretaria']][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['acuerdos'][$tipo_expediente."**".$arr_boletin[$arr_juzgados[$u]][$valor['juicio']['secretaria']][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['publicar_en']]=$arr_boletin[$arr_juzgados[$u]][$valor['juicio']['secretaria']][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['acuerdos'][$tipo_expediente."**".$arr_boletin[$arr_juzgados[$u]][$valor['juicio']['secretaria']][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['publicar_en']]+1;
                                    }


                                    /*
                                    *   ESPECIAL
                                    */
                                    if($valor['acuerdo']['especial']==''){
                                        $arr_boletin[$arr_juzgados[$u]][$valor['juicio']['secretaria']][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['especial']='';
                                    }
                                    else if($valor['acuerdo']['especial']=='no publicado'){
                                        $arr_boletin[$arr_juzgados[$u]][$valor['juicio']['secretaria']][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['especial']='No Publ.';
                                    }
                                    else if($valor['acuerdo']['especial']=='mal publicado' and $valor['acuerdo']['anotacion']==''){
                                        $arr_boletin[$arr_juzgados[$u]][$valor['juicio']['secretaria']][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['especial']='Mal Publ.';
                                    }

                                    $arr_boletin[$arr_juzgados[$u]][$valor['juicio']['secretaria']][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['fecha_especial']='';
                                    if($valor['acuerdo']['fecha_especial']!='0000-00-00' and $valor['acuerdo']['fecha_especial']!='1900-01-01' and $valor['acuerdo']['anotacion']==''){
                                        $arr_fecha=explode('-', $valor['acuerdo']['fecha_especial']);
                                        $arr_boletin[$arr_juzgados[$u]][$valor['juicio']['secretaria']][$arr_tipo_resolucion[$n]][$arr_caso_especial[$k]][$expediente]['tocas'][$toca]['fecha_especial']=$arr_fecha[2].' de '.elementos_boletin::getMesText($arr_fecha[1]);
                                    }
                                }
                            }
                        }
                    }
                }
            //}
        //}
        //dd($arr_boletin);
        return $arr_boletin;
    }

    public static function renderBoletinJuzgado($arr_boletin){
       
        
       
        $texto_boletin="";
        foreach($arr_boletin as $key => $arr_juzgados){


            if(isset($arr_juzgados['general'])){

                $texto_boletin='<h1>'.mb_convert_case($arr_juzgados['general']['juzgado'], MB_CASE_UPPER, "UTF-8").'</h1>';

                //  TITULOS
                foreach($arr_juzgados as $key_secreatria => $arr_secretaria){

                    if($key_secreatria!="general"){
                        $texto_boletin.='<h2>SECRETARIA '.strtoupper($key_secreatria).'</h2>';
                    }
                    foreach($arr_secretaria as $key_1 => $arr_tipo_resolucion){

                        if(isset($arr_secretaria[$key_1]) and is_array($arr_secretaria[$key_1]) and count($arr_secretaria[$key_1])!=0 and $key_1!='general'){
                            if((count($arr_secretaria[$key_1]['normal'])!=0 or count($arr_secretaria[$key_1]['mal publicado'])!=0 or count($arr_secretaria[$key_1]['no publicado'])!=0) and ($key_1=='acuerdo' or $key_1=='sentencia definitiva')){
                                $arr_fecha=explode('-', $arr_juzgados['general']['fecha_acuerdos']);

                                $texto_boletin.='<br><h2>'.strtoupper($key_1).'S DEL '.$arr_fecha[2].' DE '.strtoupper(elementos_boletin::getMesText($arr_fecha[1])) .' DEL '.$arr_fecha[0].'</h2>';
                            }
                            elseif((count($arr_secretaria[$key_1]['normal'])!=0 or count($arr_secretaria[$key_1]['mal publicado'])!=0 or count($arr_secretaria[$key_1]['no publicado'])!=0)){
                                $texto_boletin.='<br><h2>'.strtoupper($key_1).'</h2>';
                            }

                            //CASO ESPECIAL
                            foreach($arr_tipo_resolucion as $key => $arr_caso_especial){
                                if($key!='normal' and count($arr_caso_especial)!=0){
                                    $texto_boletin.='<h3>'.mb_convert_case($key, MB_CASE_UPPER, "UTF-8").'S</h3>';
                                }

                                //EXPEDIENTES
                                foreach($arr_caso_especial as $key => $arr_expedientes){
                                    
                                // print("La llave: ".$key);
                                

                                    $expediente_txt=$key;

                                    $texto_boletin.='<div>'.$arr_expedientes['partes'];


                                    //TOCAS
                                    foreach($arr_expedientes['tocas'] as $key => $arr_tocas){
                                        
                                        $arr_anotacion=explode('-', $key);
                                        $arr_tocas['anotacion']='';
                                        if(isset($arr_anotacion[1]) and $arr_anotacion[1]!=""){
                                            $arr_tocas['anotacion']=$arr_anotacion[1];
                                        }

                                        if($key_1=="acuerdo" ){

                                                
                                            $texto_boletin.=' '.$arr_tocas['tipo_juicio'];
                                            

                                            if($arr_tocas['anotacion']!=""){
                                                $texto_boletin.=' '.$arr_tocas['anotacion'];
                                            }

                                            if($arr_tocas['concepto']!=""){
                                                $texto_boletin.=' '.$arr_tocas['concepto'].'.';
                                            }



                                            $llave_acuerdo_exp="";
                                            $num_acuerdo_exp="";
                                            $texto_boletin_1="";
                                            foreach($arr_tocas['acuerdos'] as $key_acuerdo => $num_acuerdo){

                                                //se hace el arreglo de la suma total de acuerdos
                                                $arr_key_acuerdo=explode('**', $key_acuerdo);

                                                //se pone el tipo de expediente
                                                $llave_acuerdo_exp=$arr_key_acuerdo[0];

                                                if($arr_key_acuerdo[1]!=""){
                                                    if($num_acuerdo==1) $texto_boletin_1.=' '.$num_acuerdo.' Acuerdo en ' . $arr_key_acuerdo[1].'.';
                                                    else $texto_boletin_1.=' '.$num_acuerdo.' Acuerdos en ' . $arr_key_acuerdo[1].'.';
                                                }
                                                if($arr_key_acuerdo[1]==""){
                                                    $num_acuerdo_exp=$num_acuerdo;
                                                }
                                            }

                                            if($num_acuerdo_exp=="") $texto_boletin.="";
                                            else if($num_acuerdo_exp==1) $texto_boletin.=' 1 Acdo.'; 
                                            else $texto_boletin.=' '.$num_acuerdo_exp.' Acdos.';


                                            $texto_boletin.=$texto_boletin_1;

                                            $texto_boletin.=' Núm. Exp. '.$expediente_txt;

                                            if($llave_acuerdo_exp!=""){
                                                //$texto_boletin.= " (".$llave_acuerdo_exp.")";
                                            }

                                            $texto_boletin.='.';

                                            //publicar en
                                            //if($arr_tocas['publicar_en']!="") $texto_boletin.=' en '.$arr_tocas['publicar_en'];
                                        }
                                        else if($key_1=="sentencia" or $key_1=="sentencia definitiva" or $key_1=="sentencia interlocutoria"){

                                            $texto_boletin.=' '.$arr_tocas['tipo_juicio'];

                                            if($arr_tocas['anotacion']!=""){
                                                $texto_boletin.=' '.$arr_tocas['anotacion'];
                                            }

                                            if($arr_tocas['concepto']!=""){
                                                $texto_boletin.=' '.$arr_tocas['concepto'];
                                            }

                                            if($arr_tocas['secretaria']==""){
                                                $texto_boletin.=' Sent.';
                                                if($key_1=="sentencia definitiva"){
                                                    $texto_boletin.=' Sent. Def.';
                                                }
                                            }
                                            else{
                                                if($key_1=="sentencia definitiva"){
                                                    $texto_boletin.=' Sent. Def. Núm. Exp. '.$expediente_txt;
                                                }
                                                else{
                                                    $texto_boletin.=' Sent. Núm. Exp. '.$expediente_txt;
                                                }
                                                
                                            }
                                        }
                                        else{
                                            // $texto_boletin.='AUDIENCIA';

                                            if($arr_tocas['anotacion']!=""){
                                                $texto_boletin.=' '.$arr_tocas['anotacion'];
                                            }

                                            if($arr_tocas['concepto']!=""){
                                                $texto_boletin.=' '.$arr_tocas['concepto'];
                                            }

                                            $texto_boletin.=' '.$arr_tocas['tipo_juicio'].'. Aud. ';
                                            


                                            $llave_acuerdo_exp="";
                                            $num_acuerdo_exp="";
                                            foreach($arr_tocas['acuerdos'] as $key_acuerdo => $num_acuerdo){

                                                //se hace el arreglo de la suma total de acuerdos
                                                $arr_key_acuerdo=explode('**', $key_acuerdo);

                                                //se pone el tipo de expediente
                                                $llave_acuerdo_exp=$arr_key_acuerdo[0];

                                                if($arr_key_acuerdo[1]!=""){
                                                    if($num_acuerdo==1) $texto_boletin.=' '.$num_acuerdo.' Acuerdo en ' . $arr_key_acuerdo[1].'.';
                                                    else $texto_boletin.=' '.$num_acuerdo.' Acuerdos en ' . $arr_key_acuerdo[1].'.';
                                                }
                                                if($arr_key_acuerdo[1]==""){
                                                    $num_acuerdo_exp=$num_acuerdo;
                                                }

                                            }

                                            if($num_acuerdo_exp=="") $texto_boletin.="";
                                            else if($num_acuerdo_exp==1) $texto_boletin.=' 1 Acdo.';
                                            else $texto_boletin.=' '.$num_acuerdo_exp.' Acdos.';
                                        
                                            //if($arr_tocas['acuerdos']==1) $texto_boletin.=' 1 Audiencia. ';
                                            //else $texto_boletin.=' '.$arr_tocas['acuerdos'].' Audiencia. ';

                                            $texto_boletin.='Núm. Exp. '.$expediente_txt.'.';



                                        
                                        }

                                        //si no es ulitmo
                                        if (next($arr_expedientes['tocas'])==true) $texto_boletin .= ",";
                                    }
                                    $texto_boletin.='</div>';
                                }
                            }
                        }

                    }

                    if(isset($arr_juzgados[$key_secreatria]['autoridad']) ){
                        $texto_boletin.='<br><h3>EL SECRETARIO DE ACUERDOS<BR>'.mb_convert_case($arr_juzgados[$key_secreatria]['autoridad'], MB_CASE_UPPER, "UTF-8").'</h3><br>';
                    }

                }

            }
            else{
                return '<h1>'.$key.'</h1><h2>No hay resoluciones</h2>';
            }
        }
        return $texto_boletin;
    }
}