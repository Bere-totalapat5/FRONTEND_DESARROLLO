<?php

namespace App\Http\Controllers\agendas;

use App\Http\Controllers\clases\acuerdos;
use App\Http\Controllers\clases\agendas;
use App\Http\Controllers\clases\archivos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\clases\utilidades;

//convertir en Excel y PDF
use PhpOffice\PhpSpreadsheet\RichText\RichText;
use PhpOffice\PhpSpreadsheet\RichText\Run;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Border;
use setasign\Fpdi\Fpdi;

class control_agendas extends Controller
{
    public function inicio( Request $request ){

        $ponencia=($request->session()->get('usuario_secretaria')!="") ? $request->session()->get('usuario_secretaria') : '0' ;

        $lista=agendas::obtener_evento_agendas($request, $ponencia, 0);
        return view(    "agendas.agendas",
                        ["entorno"=>$request->entorno, 
                        "request"=>$request,
                        "sesion"=>$request->session()->all(),
                        "menu_general"=>$request->menu_general,
                        "lista"=>$lista
                        ]
                    );
    }

    public function citas( Request $request ){


        $arr_json=agendas::obtener_citas_zoho($request, date('Y-m-d'));
        
        //dd($arr_json);
        
        if(!isset($arr_json['estatus'])){
            
            
            $arr_expedientes_final = [];
            for($i=0; $i<count($arr_json); $i++){
                $arr_expediente=explode('/', $arr_json[$i]['expediente']);

                $arr_expedientes = [];
                $arr_expedientes['bis']="";
                $arr_expedientes['numero']=$arr_expediente[0];
                $arr_expedientes['anio']=$arr_expediente[1];
                if(isset($arr_expediente[2])){
                    $arr_expedientes['bis']=$arr_expediente[2];
                }
                $arr_expedientes['tipo']='expediente';
                $arr_expedientes['juzgado']=$request->session()->get('usuario_juzgado');
                $arr_expedientes_final[] = $arr_expedientes;
            }
            $lista_expediente=archivos::obtener_listado_archivos_juzgados_batch($request, $arr_expedientes_final);

            //se buscan las secreetarias y se guarda en el arreglo
            for($i=0; $i<count($arr_json); $i++){
                //se divide el expediente para su busqueda
                $arr_expediente=explode('/', $lista_expediente[$i]['juicio']);
                
                /*
                if(0){
                    //se busca al expediente
                    unset($datos);
                    $datos['expediente_bis']="-";
                    $datos['id_expediente']="-";
                    $datos['registrado_desde']="-";
                    $datos['registrado_hasta']="-";
                    $datos['involucrados_nombre']="-";
                    $datos['involucrados_apellido_paterno']="-";
                    $datos['involucrados_apellido_materno']="-";

                    $datos['expediente']=$arr_expediente[0];
                    $datos['expediente_anio']=$arr_expediente[1];
                    if(isset($arr_expediente[2])){
                        $datos['expediente_bis']=$arr_expediente[2];
                    }
                    $lista_expediente=archivos::obtener_listado_archivos_juzgados($request, $datos);

                }
                //se busca en sicor
                else if(0){

                    unset($datos);
                    $datos['expediente']=$arr_expediente[0];
                    $datos['expediente_anio']=$arr_expediente[1];
                    $lista_expediente=archivos::obtener_listado_sicor($request, $datos);
                }
                */

                //dd($lista_expediente);

                //se completa el arreglo
                $arr_json[$i]['expediente_num']=$arr_expediente[0];
                $arr_json[$i]['anio']=$arr_expediente[1];


                $arr_json[$i]['partes']="";
                if(isset($lista_expediente[$i]['partes']['actor'])){
                    for($j=0; $j<count($lista_expediente[$i]['partes']['actor']); $j++){
                        if($j!=0){
                            $arr_json[$i]['partes'].=', ';
                        }
                        $arr_json[$i]['partes'].=$lista_expediente[$i]['partes']['actor'][$j]['nombre'].' '.$lista_expediente[$i]['partes']['actor'][$j]['apellido_paterno'].' '.$lista_expediente[$i]['partes']['actor'][$j]['apellido_materno'];
                    }
                }
                if(isset($lista_expediente[$i]['partes']['demandado'])){
                    for($j=0; $j<count($lista_expediente[$i]['partes']['demandado']); $j++){
                        if($j==0){
                            $arr_json[$i]['partes'].=' VS ';
                        }
                        if($j!=0){
                            $arr_json[$i]['partes'].=', ';
                        }
                        $arr_json[$i]['partes'].=$lista_expediente[$i]['partes']['demandado'][$j]['nombre'].' '.$lista_expediente[$i]['partes']['demandado'][$j]['apellido_paterno'].' '.$lista_expediente[$i]['partes']['demandado'][$j]['apellido_materno'];
                    }
                }

                if($arr_json[$i]['partes']==""){
                    $arr_json[$i]['partes']="Expediente no encontrado";
                }

                $arr_json[$i]['partes']=str_replace('"', "'", $arr_json[$i]['partes']); 
                

                if(isset($arr_json[$i]['tramite'])){
                    $arr_json[$i]['tramite']=$arr_json[$i]['tramite'];
                    $arr_json[$i]['color']="primary";

                    if($arr_json[$i]['tramite']=="Consulta de Expedientes"){
                        $arr_json[$i]['color']="primary";
                    }
                    else if($arr_json[$i]['tramite']=="Entrega y recepción de billetes de depósito y/o títulos de valor"){
                        $arr_json[$i]['color']="success";
                    }
                    else if($arr_json[$i]['tramite']=="Entrega de copias simples"){
                        $arr_json[$i]['color']="warning";
                    }
                    else if($arr_json[$i]['tramite']=="Solicitud verbal o por comparecencia y entrega de copias simples"){
                        $arr_json[$i]['color']="danger";
                    }
                    else if($arr_json[$i]['tramite']=="Recepción de exhortos"){
                        $arr_json[$i]['color']="info";
                    }
                    else if($arr_json[$i]['tramite']=="Recepción de Cartas Rogatorias"){
                        $arr_json[$i]['color']="indigo";
                    }
                    else if($arr_json[$i]['tramite']=="Recepción de oficios diversos"){
                        $arr_json[$i]['color']="purple";
                    }
                    else if($arr_json[$i]['tramite']=="Recepción de copias certificadas"){
                        $arr_json[$i]['color']="teal";
                    }
                    else if($arr_json[$i]['tramite']=="Comparecencias de ratificación de allanamientos, promociones o cualquier otra similar, ordenada por la Jueza o Juez respectivo"){
                        $arr_json[$i]['color']="pink";
                    }
                    else if($arr_json[$i]['tramite']=="Citas para Notaria o Notario Público para la revisión o firma de escritura pública"){
                        $arr_json[$i]['color']="orange";
                    }
                }

                $segundos_horaInicial=strtotime($arr_json[$i]['hora_cita']);
                $segundos_minutoAnadir=15*60;
                $nuevaHora=date("H:i:s",$segundos_horaInicial+$segundos_minutoAnadir);
                $arr_json[$i]['hora_cita_final']=$nuevaHora;

                $arr_json[$i]['hora_humana']=utilidades::acomodarFechaHora($arr_json[$i]['fecha_cita']." ".$arr_json[$i]['hora_cita']);


                if($lista_expediente[$i]['secretaria']!=""){
                    $arr_json[$i]['secretaria']=$lista_expediente[$i]['secretaria'];
                    $arr_json[$i]['existente']=1;
                }
                else{
                    $arr_json[$i]['secretaria']='A';
                    $arr_json[$i]['existente']=0;
                }
            }
        }
        else{
            $arr_json['msj']="Sin citas para este dia";
        }

        return view(    "agendas.agendas_citas",
                        ["entorno"=>$request->entorno, 
                        "request"=>$request,
                        "sesion"=>$request->session()->all(),
                        "menu_general"=>$request->menu_general,
                        "arr_json"=>$arr_json
                        ]
                    );
    }

    public function citas_json( Request $request ){

        $input = $request->all();

        //$texto_json = file_get_contents('https://citas.poderjudicialcdmx.gob.mx/juzgados/zoho/citas_juzgado.php?juzgado='.$request->session()->get("usuario_juzgado").'&fecha='.$input['fecha']);
        //$texto_json = file_get_contents('https://citas.poderjudicialcdmx.gob.mx/juzgados/zoho/citas_juzgado.php?juzgado=13PIF&fecha='.$input['fecha']);
        //$arr_json=json_decode($texto_json, true);


        $arr_json=agendas::obtener_citas_zoho($request, $input['fecha']);


        if(!isset($arr_json['estatus'])){

            $arr_expedientes_final = [];
            for($i=0; $i<count($arr_json); $i++){
                $arr_expediente=explode('/', $arr_json[$i]['expediente']);

                $arr_expedientes = [];
                $arr_expedientes['bis']="";
                $arr_expedientes['numero']=$arr_expediente[0];
                $arr_expedientes['anio']=$arr_expediente[1];
                if(isset($arr_expediente[2])){
                    $arr_expedientes['bis']=$arr_expediente[2];
                }
                $arr_expedientes['tipo']='expediente';
                $arr_expedientes['juzgado']=$request->session()->get('usuario_juzgado');
                $arr_expedientes_final[] = $arr_expedientes;
            }

            $lista_expediente=archivos::obtener_listado_archivos_juzgados_batch($request, $arr_expedientes_final);


            //se buscan las secreetarias y se guarda en el arreglo
            for($i=0; $i<count($arr_json); $i++){
                //se divide el expediente para su busqueda
                $arr_expediente=explode('/', $lista_expediente[$i]['juicio']);
                
                /*
                if(0){
                    //se busca al expediente
                    unset($datos);
                    $datos['expediente_bis']="-";
                    $datos['id_expediente']="-";
                    $datos['registrado_desde']="-";
                    $datos['registrado_hasta']="-";
                    $datos['involucrados_nombre']="-";
                    $datos['involucrados_apellido_paterno']="-";
                    $datos['involucrados_apellido_materno']="-";

                    $datos['expediente']=$arr_expediente[0];
                    $datos['expediente_anio']=$arr_expediente[1];
                    if(isset($arr_expediente[2])){
                        $datos['expediente_bis']=$arr_expediente[2];
                    }
                    $lista_expediente=archivos::obtener_listado_archivos_juzgados($request, $datos);

                    
                    
                    if(isset($lista_expediente['response'][0]['datos_archivo']['secretaria'])){
                        $arr_json[$i]['secretaria']=$lista_expediente['response'][0]['datos_archivo']['secretaria'];
                        $arr_json[$i]['existente']=1;
                    }
                    else{
                        $arr_json[$i]['secretaria']='A';
                        $arr_json[$i]['existente']=0;
                    }

                    $arr_json[$i]['partes']="Expediente no encontrado";
                    if(isset($lista_expediente['response'][0]['partes']['actor'][0]['nombre'])){
                        $arr_json[$i]['partes']=$lista_expediente['response'][0]['partes']['actor'][0]['nombre'];
                    }
                    if(isset($lista_expediente['response'][0]['partes']['demandado'][0]['nombre']) and $lista_expediente['response'][0]['partes']['demandado'][0]['nombre']!=""){
                        $arr_json[$i]['partes'].=" VS ".$lista_expediente['response'][0]['partes']['demandado'][0]['nombre'];
                    }



                } 
                //se busca en sicor
                else{

                    unset($datos);
                    $datos['expediente']=$arr_expediente[0];
                    $datos['expediente_anio']=$arr_expediente[1];
                    $lista_expediente=archivos::obtener_listado_sicor($request, $datos);

                    if(isset($lista_expediente[0]->secretaria)){
                        $arr_json[$i]['secretaria']=$lista_expediente[0]->secretaria;
                        $arr_json[$i]['existente']=1;
                    }
                    else{
                        $arr_json[$i]['secretaria']='A';
                        $arr_json[$i]['existente']=0;
                    }

                    $arr_json[$i]['partes']="Expediente no encontrado";
                    if(isset($lista_expediente[0]->p1_nombre)){
                        $arr_json[$i]['partes']=$lista_expediente[0]->p1_nombre;
                    }
                    if(isset($lista_expediente[0]->p2_nombre) and $lista_expediente[0]->p2_nombre!=""){
                        $arr_json[$i]['partes'].=" VS ".$lista_expediente[0]->p2_nombre;
                    }

                }
                */
                
                
                //se completa el arreglo
                $arr_json[$i]['expediente_num']=$arr_expediente[0];
                $arr_json[$i]['anio']=$arr_expediente[1];


                $arr_json[$i]['partes']="";
                if(isset($lista_expediente[$i]['partes']['actor'])){
                    for($j=0; $j<count($lista_expediente[$i]['partes']['actor']); $j++){
                        if($j!=0){
                            $arr_json[$i]['partes'].=', ';
                        }
                        $arr_json[$i]['partes'].=$lista_expediente[$i]['partes']['actor'][$j]['nombre'].' '.$lista_expediente[$i]['partes']['actor'][$j]['apellido_paterno'].' '.$lista_expediente[$i]['partes']['actor'][$j]['apellido_materno'];
                    }
                }
                if(isset($lista_expediente[$i]['partes']['demandado'])){
                    for($j=0; $j<count($lista_expediente[$i]['partes']['demandado']); $j++){
                        if($j==0){
                            $arr_json[$i]['partes'].=' VS ';
                        }
                        if($j!=0){
                            $arr_json[$i]['partes'].=', ';
                        }
                        $arr_json[$i]['partes'].=$lista_expediente[$i]['partes']['demandado'][$j]['nombre'].' '.$lista_expediente[$i]['partes']['demandado'][$j]['apellido_paterno'].' '.$lista_expediente[$i]['partes']['demandado'][$j]['apellido_materno'];
                    }
                }

                if($arr_json[$i]['partes']==""){
                    $arr_json[$i]['partes']="Expediente no encontrado";
                }

                $arr_json[$i]['partes']=str_replace('"', "'", $arr_json[$i]['partes']); 


                if(isset($arr_json[$i]['tramite'])){
                    $arr_json[$i]['tramite']=$arr_json[$i]['tramite'];
                    $arr_json[$i]['color']="primary";

                    if($arr_json[$i]['tramite']=="Consulta de Expedientes"){
                        $arr_json[$i]['color']="primary";
                    }
                    else if($arr_json[$i]['tramite']=="Entrega y recepción de billetes de depósito y/o títulos de valor"){
                        $arr_json[$i]['color']="success";
                    }
                    else if($arr_json[$i]['tramite']=="Entrega de copias simples"){
                        $arr_json[$i]['color']="warning";
                    }
                    else if($arr_json[$i]['tramite']=="Solicitud verbal o por comparecencia y entrega de copias simples"){
                        $arr_json[$i]['color']="danger";
                    }
                    else if($arr_json[$i]['tramite']=="Recepción de exhortos"){
                        $arr_json[$i]['color']="info";
                    }
                    else if($arr_json[$i]['tramite']=="Recepción de Cartas Rogatorias"){
                        $arr_json[$i]['color']="indigo";
                    }
                    else if($arr_json[$i]['tramite']=="Recepción de oficios diversos"){
                        $arr_json[$i]['color']="purple";
                    }
                    else if($arr_json[$i]['tramite']=="Recepción de copias certificadas"){
                        $arr_json[$i]['color']="teal";
                    }
                    else if($arr_json[$i]['tramite']=="Comparecencias de ratificación de allanamientos, promociones o cualquier otra similar, ordenada por la Jueza o Juez respectivo"){
                        $arr_json[$i]['color']="pink";
                    }
                    else if($arr_json[$i]['tramite']=="Citas para Notaria o Notario Público para la revisión o firma de escritura pública"){
                        $arr_json[$i]['color']="orange";
                    }
                }

                $segundos_horaInicial=strtotime($arr_json[$i]['hora_cita']);
                $segundos_minutoAnadir=15*60;
                $nuevaHora=date("H:i:s",$segundos_horaInicial+$segundos_minutoAnadir);
                $arr_json[$i]['hora_cita_final']=$nuevaHora;

                $arr_json[$i]['hora_humana']=utilidades::acomodarFechaHora($arr_json[$i]['fecha_cita']." ".$arr_json[$i]['hora_cita']);


                if($lista_expediente[$i]['secretaria']!=""){
                    $arr_json[$i]['secretaria']=$lista_expediente[$i]['secretaria'];
                    $arr_json[$i]['existente']=1;
                }
                else{
                    $arr_json[$i]['secretaria']='A';
                    $arr_json[$i]['existente']=0;
                }

                
            }
        }
        else{
            $arr_json['msj']="Sin citas para este dia";
        }

        return $arr_json;

    }
   
    public function guardar_agenda( Request $request ){
        $datos['nombre_evento']=!is_null($request['nombre_evento']) ? $request['nombre_evento'] : '-' ;
        $datos['descripcion_evento']=!is_null($request['descripcion_evento']) ? $request['descripcion_evento'] : '-' ;
        $datos['fecha_evento']=!is_null($request['fecha_evento']) ? $request['fecha_evento'] : '-' ;
        $datos['hora_inicio']=!is_null($request['hora_inicio']) ? $request['hora_inicio'] : '-' ;
        $datos['hora_final']=!is_null($request['hora_final']) ? $request['hora_final'] : '-' ;
        $datos['liga_evento']=!is_null($request['liga_evento']) ? $request['liga_evento'] : '-' ;
        $datos['ponencia_evento']=!is_null($request['ponencia_evento']) ? $request['ponencia_evento'] : '-' ;
        $datos['recordatorio_correo']=!is_null($request['recordatorio_correo']) ? $request['recordatorio_correo'] : '0' ;
        $datos['recordatorio_sms']=!is_null($request['recordatorio_sms']) ? $request['recordatorio_sms'] : '0' ;
        $datos['intervalo_min']=!is_null($request['intervalo_min']) ? $request['intervalo_min'] : '-' ;
        $datos['id_acuerdo']=!is_null($request['id_acuerdo']) ? $request['id_acuerdo'] : '-' ;
        agendas::guardar_evento_agenda($request, $datos);
        return back();  
    }

    public function guardar_agenda_editado( Request $request ){
        $input = $request->all();

        //dd($input) ;       
        $datos['nombre_evento']=!is_null($request['nombre_evento']) ? $request['nombre_evento'] : '-' ;
        $datos['id_acuerdo']=!is_null($request['id_acuerdo']) ? $request['id_acuerdo'] : '-' ;
        $datos['descripcion_evento']=!is_null($request['descripcion_evento']) ? $request['descripcion_evento'] : '-' ;
        $datos['fecha_evento']=!is_null($request['fecha_evento']) ? $request['fecha_evento'] : '-' ;
        $datos['hora_inicio']=!is_null($request['hora_inicio']) ? $request['hora_inicio'] : '-' ;
        $datos['hora_final']=!is_null($request['hora_final']) ? $request['hora_final'] : '-' ;
        $datos['liga_evento']=!is_null($request['liga_evento']) ? $request['liga_evento'] : '-' ;
        $datos['ponencia_evento']=!is_null($request['ponencia_evento']) ? $request['ponencia_evento'] : '-' ;
        $datos['recordatorio_correo']=!is_null($request['recordatorio_correo']) ? $request['recordatorio_correo'] : '0' ;
        $datos['recordatorio_sms']=!is_null($request['recordatorio_sms']) ? $request['recordatorio_sms'] : '0' ;
        $datos['intervalo_min']=!is_null($request['intervalo_min']) ? $request['intervalo_min'] : '-' ;
        $datos['estatus_eliminacion']=!is_null($request['estatus_eliminacion']) ? $request['estatus_eliminacion'] : '0' ;
        agendas::editar_evento_agenda($request, $request['id_evento'], $datos);
        return back();
    }

    public function consulta_evento_ajax( Request $request ){
        $input = $request->all();
        $sesion = $request->session()->all();
        $lista=agendas::obtener_evento_agendas($request, 0, $input['agenda_id']);
        $plantilla_archivo_body=print_r($lista, true);
        $plantilla_archivo_header='';
        include "plantilla_info_agenda.php";

        return response()->json(['plantilla_archivo_header'=>$plantilla_archivo_header, 'plantilla_archivo_body'=>$plantilla_archivo_body]);
    }

    public function validar_acuerdo_ajax( Request $request ){

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
            include "plantilla_asignar_agenda_nueva_juzgado.php";
        }
        else{
            $input = $request->all();
            $promocion_id=0;
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
            

            //se pone la plantilla
            $plantilla_archivo_body=print_r($lista_expediente, true);
            $plantilla_archivo_header='';
            include "plantilla_asignar_agenda_nueva_juzgado.php";


        }
        return response()->json(['plantilla_archivo_header'=>$plantilla_archivo_header, 'plantilla_archivo_body'=>$plantilla_archivo_body]);
    }

    public function exportar_citas_excel(Request $request){

        $input = $request->all();

        $arr_json=agendas::obtener_citas_zoho($request, $input['fecha_cita_hidden']);

        //dd($lista);
        //$helper->log('Create new Spreadsheet object');
        $spreadsheet = new Spreadsheet();

        // Set document properties
        //$helper->log('Set document properties');
        $spreadsheet->getProperties()
            ->setCreator('Maarten Balliauw')
            ->setLastModifiedBy('Maarten Balliauw')
            ->setTitle('PhpSpreadsheet Test Document')
            ->setSubject('PhpSpreadsheet Test Document')
            ->setDescription('Test document for PhpSpreadsheet, generated using PHP classes.')
            ->setKeywords('office PhpSpreadsheet php')
            ->setCategory('Test result file');


        //FORMATO POR CELDA
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(40);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(20);

        //PONEMOS EL TITULO AZUL
        $spreadsheet->getActiveSheet()->getStyle('A1:F1')->getFill()->setFillType(Fill::FILL_SOLID);
        $spreadsheet->getActiveSheet()->getStyle('A1:F1')->getFill()->getStartColor()->setARGB('FF216465');
        $spreadsheet->getActiveSheet()->getStyle('A1:F1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A1:F1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A1:F1')->getFont()->getColor()->setARGB(Color::COLOR_WHITE);
        $spreadsheet->getActiveSheet()->getStyle('A1:F1')->getAlignment()->setWrapText(true);

        //ESCRIBIMOS LOS TITULOS
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'FOLIO')
            ->setCellValue('B1', 'EXPEDIENTE' )
            ->setCellValue('C1', 'SECRETARIA' )
            ->setCellValue('D1', 'TIPO DE TRAMITE' )
            ->setCellValue('E1', 'PARTES' )
            ->setCellValue('F1', 'HORARIO' );   

            
        //se pone la info
        $styleThinBlackBorderOutline = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];
        
        if(!(isset($arr_json['estatus']) and $arr_json['estatus']==0)){
            
            $arr_expedientes_final = [];
            for($i=0; $i<count($arr_json); $i++){
                $arr_expediente=explode('/', $arr_json[$i]['expediente']);

                $arr_expedientes = [];
                $arr_expedientes['bis']="";
                $arr_expedientes['numero']=$arr_expediente[0];
                $arr_expedientes['anio']=$arr_expediente[1];
                if(isset($arr_expediente[2])){
                    $arr_expedientes['bis']=$arr_expediente[2];
                }
                $arr_expedientes['tipo']='expediente';
                $arr_expedientes['juzgado']=$request->session()->get('usuario_juzgado');
                $arr_expedientes_final[] = $arr_expedientes;
            }
            $lista_expediente=archivos::obtener_listado_archivos_juzgados_batch($request, $arr_expedientes_final);


            for($i=0; $i<count($arr_json); $i++){

                unset($datos);
                $arr_expediente=explode('/', $lista_expediente[$i]['juicio']);
                $datos['expediente']=$arr_expediente[0];
                $datos['expediente_anio']=$arr_expediente[1];
                //$lista_expediente=archivos::obtener_listado_sicor($request, $datos);


                $arr_json[$i]['partes']="";
                if(isset($lista_expediente[$i]['partes']['actor'])){
                    for($j=0; $j<count($lista_expediente[$i]['partes']['actor']); $j++){
                        if($j!=0){
                            $arr_json[$i]['partes'].=', ';
                        }
                        $arr_json[$i]['partes'].=$lista_expediente[$i]['partes']['actor'][$j]['nombre'].' '.$lista_expediente[$i]['partes']['actor'][$j]['apellido_paterno'].' '.$lista_expediente[$i]['partes']['actor'][$j]['apellido_materno'];
                    }
                }
                if(isset($lista_expediente[$i]['partes']['demandado'])){
                    for($j=0; $j<count($lista_expediente[$i]['partes']['demandado']); $j++){
                        if($j==0){
                            $arr_json[$i]['partes'].=' VS ';
                        }
                        if($j!=0){
                            $arr_json[$i]['partes'].=', ';
                        }
                        $arr_json[$i]['partes'].=$lista_expediente[$i]['partes']['demandado'][$j]['nombre'].' '.$lista_expediente[$i]['partes']['demandado'][$j]['apellido_paterno'].' '.$lista_expediente[$i]['partes']['demandado'][$j]['apellido_materno'];
                    }
                }

                if($arr_json[$i]['partes']==""){
                    $arr_json[$i]['partes']="Expediente no encontrado";
                }


                if($lista_expediente[$i]['secretaria']!=""){
                    $arr_json[$i]['secretaria']=$lista_expediente[$i]['secretaria'];
                    $arr_json[$i]['existente']=1;
                }
                else{
                    $arr_json[$i]['secretaria']='A';
                    $arr_json[$i]['existente']=0;
                }


                $row=$i+2;
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A'.$row, $arr_json[$i]['folio']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('B'.$row, $arr_json[$i]['expediente']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('C'.$row, $arr_json[$i]['secretaria']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('D'.$row, $arr_json[$i]['tramite']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('E'.$row, $arr_json[$i]['partes']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('F'.$row, $arr_json[$i]['fecha_cita'].' '.$arr_json[$i]['hora_cita']);


                $spreadsheet->getActiveSheet()->getStyle('A'.$row.':F'.$row)->getFont()->setSize(9);
                $spreadsheet->getActiveSheet()->getStyle('A'.$row.':F'.$row)->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
                $spreadsheet->getActiveSheet()->getStyle('A'.$row.':F'.$row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $spreadsheet->getActiveSheet()->getStyle('A'.$row.':F'.$row)->getAlignment()->setWrapText(true);
                $spreadsheet->getActiveSheet()->getStyle('A'.$row.':F'.$row)->applyFromArray($styleThinBlackBorderOutline);
                $spreadsheet->getActiveSheet()->getStyle('A'.$row.':F'.$row)->applyFromArray($styleThinBlackBorderOutline);

            }
        }
        
        if(isset($input['exportacion']) and $input['exportacion']=="pdf"){
            $response = response()->streamDownload(function() use ($spreadsheet) {
                $writer = IOFactory::createWriter($spreadsheet, 'Mpdf');
                $writer->save('php://output');
            });

            $response->setStatusCode(200);
            $response->headers->set('Content-Type', 'application/pdf');
            $response->headers->set('Content-Disposition', 'attachment; filename="lista_citas_'.$input['fecha_cita_hidden'].'.pdf"');
            $response->send();
        }
        else{
            $response = response()->streamDownload(function() use ($spreadsheet) {
                $writer = new Xls($spreadsheet);
                $writer->save('php://output');
            });

            $response->setStatusCode(200);
            $response->headers->set('Content-Type', 'application/vnd.ms-excel');
            $response->headers->set('Content-Disposition', 'attachment; filename="lista_citas_'.$input['fecha_cita_hidden'].'.xls"');
            $response->send();
        }

    }

    public function cambiar_estatus_citas_zoho(Request $request){
        $input = $request->all();

        $lista=agendas::cambiar_estatus_cita_zoho($request, $input['folio'], $input['estatus']);
        return $lista;
    }

}