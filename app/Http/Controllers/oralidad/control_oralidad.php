<?php

namespace App\Http\Controllers\oralidad;

use App\Http\Controllers\clases\agendas;
use App\Http\Controllers\clases\anales;
use App\Http\Controllers\clases\bandejas;
use App\Http\Controllers\clases\acuerdos;
use App\Http\Controllers\clases\archivos;
use App\Http\Controllers\clases\promociones;
use App\Http\Controllers\clases\utilidades;
use App\Http\Controllers\clases\notificaciones;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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


class control_oralidad extends Controller 
{
    public function inicio( Request $request ){

        $lista=agendas::oralidad_agenda_divorcios($request);

        //dd($lista);

        $lista_agenda=[];
        for($i=0; $i<count($lista); $i++){

            $lista[$i]['datos_evento']['evento_nombre']=str_replace("Acuerdo ", "", $lista[$i]['datos_evento']['evento_nombre']);

            if($lista[$i]['datos_acuerdo']['id_catalogo_juicios']=="623"){
                $lista[$i]['datos_acuerdo']['accion']="Div. Inc. Amb. Partes";
            }
            else if($lista[$i]['datos_acuerdo']['accion']=="625"){
                $lista[$i]['datos_acuerdo']['accion']="Acred. Concubinato";
            }
            else if($lista[$i]['datos_acuerdo']['accion']=="622"){
                $lista[$i]['datos_acuerdo']['accion']="Dep. Económica";
            }


            $lista_agenda[$i]=[];
            $lista_agenda[$i]['start_date']=$lista[$i]['datos_evento']['evento_fecha']." ".$lista[$i]['datos_evento']['evento_hora_inicio'];
            $lista_agenda[$i]['end_date']=$lista[$i]['datos_evento']['evento_fecha']." ".$lista[$i]['datos_evento']['evento_hora_final'];
            $lista_agenda[$i]['text']=$lista[$i]['datos_evento']['evento_nombre']."<br>".$lista[$i]['datos_acuerdo']['accion'];
            $lista_agenda[$i]['section_id']=$lista[$i]['datos_acuerdo']['juzgado'];
            $lista_agenda[$i]['evento_id']=$lista[$i]['datos_evento']['evento_id'];
        }

        return view(    "oralidad.oralidad_div_express",
                        ["entorno"=>$request->entorno, 
                        "request"=>$request,
                        "sesion"=>$request->session()->all(),
                        "menu_general"=>$request->menu_general,
                        "lista"=>$lista,
                        "lista_agenda"=>$lista_agenda
                        ]
                    );
    }

    public function inicio_consulta_acuerdos( Request $request, $materia="", $codigo_juicio="", $expedinete="", $anio="", $bis="", $id_juicio=""){

        $arr_materias= ['JFO'];
        $arr_juzgados= ['1JFO','2JFO','3JFO','4JFO','5JFO','6JFO','7JFO','8JFO','9JFO','10JFO'];

        //se cargan los catálogos de materias
        $lista_materias_total=anales::obtenerTiposJuzgado($request);
        $index=0;
        for($i=0; $i<count($lista_materias_total['response']); $i++){
            if(in_array($lista_materias_total['response'][$i]['juzgado_subtipo_clave'], $arr_materias)){
                $lista_materias['response'][$index]['juzgado_subtipo_clave']=$lista_materias_total['response'][$i]['juzgado_subtipo_clave'];
                $lista_materias['response'][$index]['juzgado_subtipo_nombre']=$lista_materias_total['response'][$i]['juzgado_subtipo_nombre'];
                $index++;
            }
        }
        //dd($lista_materias);

        //dd($materia);
        $lista_submateria=[];
        if($materia!=""){
            $lista_submateria_total=anales::obtenerJuzgadoTipo($request, $materia);
            $index=0;
            for($i=0; $i<count($lista_submateria_total['response']); $i++){
                if(in_array($lista_submateria_total['response'][$i]['codigo'], $arr_juzgados)){
                    $lista_submateria['response'][$index]['codigo']=$lista_submateria_total['response'][$i]['codigo'];
                    $lista_submateria['response'][$index]['nombre']=$lista_submateria_total['response'][$i]['nombre'];
                    $index++;
                }
            }

        }

        $archivo_detalle=[];
        if($codigo_juicio!="" and $materia!="" and $expedinete!=""){

            $id_juicio_local="";
            if($id_juicio!=""){
                $id_juicio_local=$id_juicio;
            }
            unset($datos);
            $datos['id_expediente']=$id_juicio_local;
            $datos['expediente']=($expedinete==0) ? "" : $expedinete;
            $datos['expediente_anio']=($anio==0) ? "" : $anio;
            $datos['involucrados_nombre']="";
            $datos['expediente_bis']=($bis==0) ? "" : $bis;
            $datos['involucrados_apellido_paterno']=""; 
            $datos['involucrados_apellido_materno']="";
            $datos['registrado_desde']="";
            $datos['registrado_hasta']="";

            //dd($datos);
            $archivo_detalle=archivos::obtener_listado_archivos_juzgados_litigante($request, $datos, $codigo_juicio);

            //dd($archivo_detalle);

        }

        $lista_acuerdos=[];
        if($id_juicio!=""){
            $lista_acuerdos=archivos::expedientes_digitales($request, $id_juicio, $codigo_juicio, 'promocion_acuerdo');
            
        }

        

        return view(    "oralidad.consulta_acuerdos",
                        ["entorno"=>$request->entorno, 
                        "request"=>$request,
                        "sesion"=>$request->session()->all(),
                        "menu_general"=>$request->menu_general,
                        "lista_materias"=>$lista_materias,
                        "lista_submateria"=>$lista_submateria,
                        "archivo_detalle"=>$archivo_detalle,
                        "lista_acuerdos"=>$lista_acuerdos,
                        
                        "juzgado_subtipo_id"=>$materia,
                        "codigo_juicio"=>$codigo_juicio,
                        "expedinete"=>$expedinete,
                        "anio"=>$anio,
                        "bis"=>$bis,

                        ]
        
                    );
    }

    public function inicio_consulta_promociones( Request $request, $materia="", $codigo_juicio="", $expedinete="", $anio="", $bis="", $id_juicio=""){

        $arr_materias= ['JFO'];
        $arr_juzgados= ['1JFO','2JFO','3JFO','4JFO','5JFO','6JFO','7JFO','8JFO','9JFO','10JFO'];

        //se cargan los catálogos de materias
        $lista_materias_total=anales::obtenerTiposJuzgado($request);
        $index=0;
        for($i=0; $i<count($lista_materias_total['response']); $i++){
            if(in_array($lista_materias_total['response'][$i]['juzgado_subtipo_clave'], $arr_materias)){
                $lista_materias['response'][$index]['juzgado_subtipo_clave']=$lista_materias_total['response'][$i]['juzgado_subtipo_clave'];
                $lista_materias['response'][$index]['juzgado_subtipo_nombre']=$lista_materias_total['response'][$i]['juzgado_subtipo_nombre'];
                $index++;
            }
        }
        //dd($lista_materias);

        //dd($materia);
        $lista_submateria=[];
        if($materia!=""){
            $lista_submateria_total=anales::obtenerJuzgadoTipo($request, $materia);
            $index=0;
            for($i=0; $i<count($lista_submateria_total['response']); $i++){
                if(in_array($lista_submateria_total['response'][$i]['codigo'], $arr_juzgados)){
                    $lista_submateria['response'][$index]['codigo']=$lista_submateria_total['response'][$i]['codigo'];
                    $lista_submateria['response'][$index]['nombre']=$lista_submateria_total['response'][$i]['nombre'];
                    $index++;
                }
            }
        }

        $archivo_detalle=[];
        $lista_acuerdos=[];
        if($codigo_juicio!="" and $materia!="" ){
            
            unset($datos);
            $datos['id_juicio']='-';
            $datos['confirmados']="-"; 
            $datos['tipo_documento']="INIC";
            $datos['fecha']="-";
            $datos['no_confirmados']="-";
            $datos['juzgado_sicor']=$codigo_juicio;
            $datos['bandera_sigj_web']="-";
            $datos['origen']="-";
            $datos['pagina']="1";
            $datos['registros_por_pagina']="50";

            //dd($datos);
            $lista_acuerdos=promociones::consultarPromociones($request, $datos);

            //dd($archivo_detalle);

        }

        
        

        return view(    "oralidad.consulta_promociones",
                        ["entorno"=>$request->entorno, 
                            "request"=>$request,
                            "sesion"=>$request->session()->all(),
                            "menu_general"=>$request->menu_general,
                            "lista_materias"=>$lista_materias,
                            "lista_submateria"=>$lista_submateria,
                            "archivo_detalle"=>$archivo_detalle,
                            "lista_acuerdos"=>$lista_acuerdos,
                            
                            "juzgado_subtipo_id"=>$materia,
                            "codigo_juicio"=>$codigo_juicio,
                            "expedinete"=>$expedinete,
                            "anio"=>$anio,
                            "bis"=>$bis,

                        ]
                    );
    }

    public function inicio_consulta_notificaciones( Request $request, $materia="", $codigo_juicio="", $estatus=""){

        $arr_materias= ['JFO'];
        $arr_juzgados= ['1JFO','2JFO','3JFO','4JFO','5JFO','6JFO','7JFO','8JFO','9JFO','10JFO', '100JFO'];

        //se cargan los catálogos de materias
        $lista_materias_total=anales::obtenerTiposJuzgado($request);
        $index=0;
        for($i=0; $i<count($lista_materias_total['response']); $i++){
            if(in_array($lista_materias_total['response'][$i]['juzgado_subtipo_clave'], $arr_materias)){
                $lista_materias['response'][$index]['juzgado_subtipo_clave']=$lista_materias_total['response'][$i]['juzgado_subtipo_clave'];
                $lista_materias['response'][$index]['juzgado_subtipo_nombre']=$lista_materias_total['response'][$i]['juzgado_subtipo_nombre'];
                $index++;
            }
        }
        //dd($lista_materias);

        //dd($materia);
        $lista_submateria=[];
        if($materia!=""){
            $lista_submateria_total=anales::obtenerJuzgadoTipo($request, $materia);
            $index=0;
            for($i=0; $i<count($lista_submateria_total['response']); $i++){
                if(in_array($lista_submateria_total['response'][$i]['codigo'], $arr_juzgados)){
                    $lista_submateria['response'][$index]['codigo']=$lista_submateria_total['response'][$i]['codigo'];
                    $lista_submateria['response'][$index]['nombre']=$lista_submateria_total['response'][$i]['nombre'];
                    $index++;
                }
            }
        }

        $lista_notificacion=[];
        if($codigo_juicio!="" and $materia!=""){

            if($estatus=="" or $estatus=="sin_notificar"){
                $bandeja="sin_notificar";
            }
            else{
                $bandeja="notificado";
            }
            $lista_notificacion=notificaciones::obtener_notificaciones_acuerdo($request, $bandeja, $codigo_juicio);
            
        }
        //dd($lista_notificacion);

        return view(    "oralidad.consulta_notificaciones",
                        ["entorno"=>$request->entorno, 
                            "request"=>$request,
                            "sesion"=>$request->session()->all(),
                            "menu_general"=>$request->menu_general,
                            "lista_materias"=>$lista_materias,
                            "lista_submateria"=>$lista_submateria,
                            "lista_notificacion"=>$lista_notificacion,
                            "juzgado_subtipo_id"=>$materia,
                            "codigo_juicio"=>$codigo_juicio,
                            "estatus"=>$estatus
                        ]
                    );
    }

    public function formulario_asignar_notificador( Request $request ){
        $input = $request->all();
        $lista_actuarios=acuerdos::actuarios_notificadores($request);
        $plantilla_archivo_header='';
        include "plantilla_editar_acuerdo_notificacion.php";

        return response()->json(['plantilla_archivo_header'=>$plantilla_archivo_header, 'plantilla_archivo_body'=>$plantilla_archivo_body]);
    }

    public function formulario_acuerdo_notificacion_guardar_ajax(Request $request){
        $input = $request->all();

        //primero guardo al acuerdo
        unset($datos);
        $datos_finales=[];

        $lista=acuerdos::modificar_notificacion_acuerdo($request, $input['id_not'], $input['lista_actuario']);
        
        $datos_finales[]=$lista;
        return $datos_finales;
    }

    public function descargar_acuerdo( Request $request){
        $input = $request->all(); 

        $lista_flujo=acuerdos::obtener_ultima_version_acuerdo_sinse($request, $input['id_acuerdo'], $input['ponencia']);
        $lista=bandejas::documento_descargar_sicor($request, $input['id_acuerdo'], $input['ponencia'], $lista_flujo['response'], 'pdf');

        return $lista;
    }

    public function cargarInfoEvento_ajax( Request $request ){

        $input = $request->all(); 

        //se obtiene la info
        unset($datos);
        $lista=agendas::oralidad_agenda_divorcios($request, $input['agenda_id']);

        $plantilla_archivo_body=print_r($lista, true);
        $plantilla_archivo_header='';
        include "plantilla_info_oralidad.php";

        return response()->json(['plantilla_archivo_header'=>$plantilla_archivo_header, 'plantilla_archivo_body'=>$plantilla_archivo_body]);
    }

    public function citas_excel(Request $request){

        $input = $request->all();
        $fecha_inicio_suma = date("Y-m-d",strtotime($input['dia_inicio']."+ 0 days"));
        $fecha_final_suma = date("Y-m-d",strtotime($input['dia_inicio']."+ 4 days"));

        //dd($input);

        $helper = new Sample();

        $fecha_inicio=$fecha_inicio_suma;
        $fecha_final=$fecha_final_suma;

        //print($fecha_inicio.'<br>');
        //print($fecha_final.'<br>');
        
        $arr_dias=['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes'];

        $lista=agendas::oralidad_agenda_divorcios($request, '', $fecha_inicio, $fecha_final);

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
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(30);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(30);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(30);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(30);
        
        
        //SE PONE EN BLANCO
        $spreadsheet->getActiveSheet()->getStyle('A1:F4')->getFill()->setFillType(Fill::FILL_SOLID);
        $spreadsheet->getActiveSheet()->getStyle('A1:F4')->getFill()->getStartColor()->setARGB('FFFFFFFF');
        $spreadsheet->getActiveSheet()->getStyle('A16:F17')->getFill()->setFillType(Fill::FILL_SOLID);
        $spreadsheet->getActiveSheet()->getStyle('A16:F17')->getFill()->getStartColor()->setARGB('FFFFFFFF');


        // SE PONE EL LOGO
        
        $drawing = new Drawing();
        $drawing->setName('Paid');
        $drawing->setDescription('Paid');
        $drawing->setPath(__DIR__ . '/../../../../public/images/LOGO_PJ_vextendida_color.png');
        $drawing->setHeight(86);
        $drawing->setCoordinates('A1');
        $drawing->setWorksheet($spreadsheet->getActiveSheet());

        

        // Add some data
        //$helper->log('Add some data');
        //$spreadsheet->getActiveSheet()->mergeCells('E1:F1');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('F1', 'Ciudad de México a '.utilidades::acomodarFecha(date('Y-m-d')).'.');
        $spreadsheet->getActiveSheet()->getStyle('F1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        //$spreadsheet->getActiveSheet()->getStyle('E1')->getFont()->getColor()->setARGB(Color::COLOR_BLACK);

        
        //unimos para el titulo
        $spreadsheet->getActiveSheet()->mergeCells('A2:F2');
        $spreadsheet->getActiveSheet()->mergeCells('A3:F3');
        $spreadsheet->getActiveSheet()->mergeCells('A16:F16');
        $spreadsheet->getActiveSheet()->mergeCells('A17:F17');

        // TITULO
        //$helper->log('Set fonts');
        $spreadsheet->getActiveSheet()->getStyle('A2')->getFont()->setSize(15);
        $spreadsheet->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A2', 'REPORTE DE AUDIENCIAS DE JUICIOS EN LÍNEA');
        $spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setWrapText(true);
        

        $spreadsheet->getActiveSheet()->getStyle('A3')->getFont()->setSize(15);
        $spreadsheet->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A3', 'JUZGADOS FAMILIARES DE PROCESO ORAL');
        $spreadsheet->getActiveSheet()->getStyle('A3')->getAlignment()->setWrapText(true);

        //FOOTER
        $spreadsheet->getActiveSheet()->getStyle('A15:F15')->getFill()->setFillType(Fill::FILL_SOLID); 
        $spreadsheet->getActiveSheet()->getStyle('A15:F15')->getFill()->getStartColor()->setARGB('FF216465');
        
        /*
        $spreadsheet->getActiveSheet()->getStyle('A16')->getFont()->setSize(12);
        $spreadsheet->getActiveSheet()->getStyle('A16')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('A16')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A16', 'SUBDIRECTOR DE LA CENTRAL DE COMUNICACIONES PROCESALES DE LA UNIDAD DE GESTION ADMINISTRATIVA');
        $spreadsheet->getActiveSheet()->getStyle('A16')->getAlignment()->setWrapText(true);

        $spreadsheet->getActiveSheet()->getStyle('A17')->getFont()->setSize(12);
        $spreadsheet->getActiveSheet()->getStyle('A17')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('A17')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A17', 'LIC. OMAR ARTURO PEREZ RICALDE');
        $spreadsheet->getActiveSheet()->getStyle('A17')->getAlignment()->setWrapText(true);
        */
       
        //PONEMOS EL TITULO VERDE
        $spreadsheet->getActiveSheet()->getStyle('A4:F4')->getFill()->setFillType(Fill::FILL_SOLID);
        $spreadsheet->getActiveSheet()->getStyle('A4:F4')->getFill()->getStartColor()->setARGB('FF216465');
        $spreadsheet->getActiveSheet()->getStyle('A4:F4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A4:F4')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A4:F4')->getFont()->getColor()->setARGB(Color::COLOR_WHITE);
        $spreadsheet->getActiveSheet()->getStyle('A4')->getAlignment()->setWrapText(true);

        //ESCRIBIMOS LOS TITULOS
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A4', 'JUZGADOS')
            ->setCellValue('B4', $arr_dias[0]." ".date("d",strtotime($fecha_inicio."+ 0 days")) )
            ->setCellValue('C4', $arr_dias[1]." ".date("d",strtotime($fecha_inicio."+ 1 days")) )
            ->setCellValue('D4', $arr_dias[2]." ".date("d",strtotime($fecha_inicio."+ 2 days")) )
            ->setCellValue('E4', $arr_dias[3]." ".date("d",strtotime($fecha_inicio."+ 3 days")) )
            ->setCellValue('F4', $arr_dias[4]." ".date("d",strtotime($fecha_inicio."+ 4 days")) );

        //ESCRIBIMOS LOS JUZGADOS
        $run1 = new Run('PRIMERO DE LO FAMILIAR DE PROCESO ORAL' . chr(10));
        //$run1->getFont()->setBold(true);
        $run2 = new Run('https://tsj-cdmx.webex.com/meet/jfpo.01');
        $run2->getFont()->setSize(8)->setColor(new Color(Color::COLOR_BLUE));
        $richText = new RichText();
        $richText->addText($run1);
        $richText->addText($run2);
        $spreadsheet->getActiveSheet()->getCell('A5')->setValue($richText);
        $spreadsheet->getActiveSheet()->getStyle('A5')->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getCell('A5')->getHyperlink()->setUrl("https://tsj-cdmx.webex.com/meet/jfpo.01");


        $run1 = new Run('SEGIMDP DE LO FAMILIAR DE PROCESO ORAL' . chr(10));
        //$run1->getFont()->setBold(true);
        $run2 = new Run('https://tsj-cdmx.webex.com/meet/jfpo.02');
        $run2->getFont()->setSize(8)->setColor(new Color(Color::COLOR_BLUE));
        $richText = new RichText();
        $richText->addText($run1);
        $richText->addText($run2);
        $spreadsheet->getActiveSheet()->getCell('A6')->setValue($richText);
        $spreadsheet->getActiveSheet()->getStyle('A6')->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getCell('A6')->getHyperlink()->setUrl("https://tsj-cdmx.webex.com/meet/jfpo.02");


        $run1 = new Run('TERCERO DE LO FAMILIAR DE PROCESO ORAL' . chr(10));
        //$run1->getFont()->setBold(true);
        $run2 = new Run('https://tsj-cdmx.webex.com/meet/jfpo.03');
        $run2->getFont()->setSize(8)->setColor(new Color(Color::COLOR_BLUE));
        $richText = new RichText();
        $richText->addText($run1);
        $richText->addText($run2);
        $spreadsheet->getActiveSheet()->getCell('A7')->setValue($richText);
        $spreadsheet->getActiveSheet()->getStyle('A7')->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getCell('A7')->getHyperlink()->setUrl("https://tsj-cdmx.webex.com/meet/jfpo.03");


        $run1 = new Run('CUARTO DE LO FAMILIAR DE PROCESO ORAL' . chr(10));
        //$run1->getFont()->setBold(true);
        $run2 = new Run('https://tsj-cdmx.webex.com/meet/jfpo.04');
        $run2->getFont()->setSize(8)->setColor(new Color(Color::COLOR_BLUE));
        $richText = new RichText();
        $richText->addText($run1);
        $richText->addText($run2);
        $spreadsheet->getActiveSheet()->getCell('A8')->setValue($richText);
        $spreadsheet->getActiveSheet()->getStyle('A8')->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getCell('A8')->getHyperlink()->setUrl("https://tsj-cdmx.webex.com/meet/jfpo.04");


        $run1 = new Run('QUINTO DE LO FAMILIAR DE PROCESO ORAL' . chr(10));
        //$run1->getFont()->setBold(true);
        $run2 = new Run('https://tsj-cdmx.webex.com/meet/jfpo.05');
        $run2->getFont()->setSize(8)->setColor(new Color(Color::COLOR_BLUE));
        $richText = new RichText();
        $richText->addText($run1);
        $richText->addText($run2);
        $spreadsheet->getActiveSheet()->getCell('A9')->setValue($richText);
        $spreadsheet->getActiveSheet()->getStyle('A9')->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getCell('A9')->getHyperlink()->setUrl("https://tsj-cdmx.webex.com/meet/jfpo.05");


        $run1 = new Run('SEXTO DE LO FAMILIAR DE PROCESO ORAL' . chr(10));
        //$run1->getFont()->setUnderline(false);
        $run2 = new Run('https://tsj-cdmx.webex.com/meet/jfpo.06');
        $run2->getFont()->setSize(8)->setColor(new Color(Color::COLOR_BLUE));
        $richText = new RichText();
        $richText->addText($run1);
        $richText->addText($run2);
        $spreadsheet->getActiveSheet()->getCell('A10')->setValue($richText);
        $spreadsheet->getActiveSheet()->getStyle('A10')->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getCell('A10')->getHyperlink()->setUrl("https://tsj-cdmx.webex.com/meet/jfpo.06");


        $run1 = new Run('SEPTIMO DE LO FAMILIAR DE PROCESO ORAL' . chr(10));
        //$run1->getFont()->setBold(true);
        $run2 = new Run('https://tsj-cdmx.webex.com/meet/jfpo.07');
        $run2->getFont()->setSize(8)->setColor(new Color(Color::COLOR_BLUE));
        $richText = new RichText();
        $richText->addText($run1);
        $richText->addText($run2);
        $spreadsheet->getActiveSheet()->getCell('A11')->setValue($richText);
        $spreadsheet->getActiveSheet()->getStyle('A11')->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getCell('A11')->getHyperlink()->setUrl("https://tsj-cdmx.webex.com/meet/jfpo.07");

        $run1 = new Run('OCTAVO DE LO FAMILIAR DE PROCESO ORAL' . chr(10));
        //$run1->getFont()->setBold(true);
        $run2 = new Run('https://tsj-cdmx.webex.com/meet/jfpo.08');
        $run2->getFont()->setSize(8)->setColor(new Color(Color::COLOR_BLUE));
        $richText = new RichText();
        $richText->addText($run1);
        $richText->addText($run2);
        $spreadsheet->getActiveSheet()->getCell('A12')->setValue($richText);
        $spreadsheet->getActiveSheet()->getStyle('A12')->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getCell('A12')->getHyperlink()->setUrl("https://tsj-cdmx.webex.com/meet/jfpo.08");


        $run1 = new Run('NOVENO DE LO FAMILIAR DE PROCESO ORAL' . chr(10));
        //$run1->getFont()->setBold(true);
        $run2 = new Run('https://tsj-cdmx.webex.com/meet/jfpo.09');
        $run2->getFont()->setSize(8)->setColor(new Color(Color::COLOR_BLUE));
        $richText = new RichText();
        $richText->addText($run1);
        $richText->addText($run2);
        $spreadsheet->getActiveSheet()->getCell('A13')->setValue($richText);
        $spreadsheet->getActiveSheet()->getStyle('A13')->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getCell('A13')->getHyperlink()->setUrl("https://tsj-cdmx.webex.com/meet/jfpo.09");


        $run1 = new Run('DECIMO DE LO FAMILIAR DE PROCESO ORAL' . chr(10));
        //$run1->getFont()->setBold(true);
        $run2 = new Run('https://tsj-cdmx.webex.com/meet/jfpo.10');
        $run2->getFont()->setSize(8)->setColor(new Color(Color::COLOR_BLUE));
        $richText = new RichText();
        $richText->addText($run1);
        $richText->addText($run2);
        $spreadsheet->getActiveSheet()->getCell('A14')->setValue($richText);
        $spreadsheet->getActiveSheet()->getStyle('A14')->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getCell('A14')->getHyperlink()->setUrl("https://tsj-cdmx.webex.com/meet/jfpo.10");


        $spreadsheet->getActiveSheet()->getStyle('A5:A14')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        //$spreadsheet->getActiveSheet()->getStyle('A5:A14')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A5:A14')->getAlignment()->setWrapText(true);
         

        //se pone la info
        $spreadsheet->getActiveSheet()->getStyle('B5:F14')->getFont()->setSize(9);
        $spreadsheet->getActiveSheet()->getStyle('B5:F14')->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
        $spreadsheet->getActiveSheet()->getStyle('B5:F14')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('B5:F14')->getAlignment()->setWrapText(true);
        
        $arr_columnas=['B', 'C', 'D', 'E', 'F'];
        

        for($i=0; $i<5; $i++){
            $fecha=date("Y-m-d",strtotime($fecha_inicio."+ ".$i." days"));

            //se pone la info en la tabla
            $columna=$arr_columnas[$i];
            $renglon=5;
            
            for($j=0; $j<count($lista); $j++){
                if($lista[$j]['datos_evento']['evento_fecha']==$fecha){
                    if($lista[$j]['datos_evento']['codigo_organo']=='1JFO') $renglon="5";
                    if($lista[$j]['datos_evento']['codigo_organo']=='2JFO') $renglon="6";
                    if($lista[$j]['datos_evento']['codigo_organo']=='3JFO') $renglon="7";
                    if($lista[$j]['datos_evento']['codigo_organo']=='4JFO') $renglon="8";
                    if($lista[$j]['datos_evento']['codigo_organo']=='5JFO') $renglon="9";
                    if($lista[$j]['datos_evento']['codigo_organo']=='6JFO') $renglon="10";
                    if($lista[$j]['datos_evento']['codigo_organo']=='7JFO') $renglon="11";
                    if($lista[$j]['datos_evento']['codigo_organo']=='8JFO') $renglon="12";
                    if($lista[$j]['datos_evento']['codigo_organo']=='9JFO') $renglon="13";
                    if($lista[$j]['datos_evento']['codigo_organo']=='10JFO') $renglon="14";


                    if($spreadsheet->getActiveSheet()->getCell($columna.''.$renglon)->getValue()!=""){
                        $texto=$spreadsheet->getActiveSheet()->getCell($columna.''.$renglon)->getValue();
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue($columna.''.$renglon, $texto."\r\n".$lista[$j]['datos_evento']['evento_hora_inicio'].'Hrs. '.$lista[$j]['datos_acuerdo']['acuerdo']."\r\n".$lista[$j]['datos_acuerdo']['accion']);
                    }
                    else{
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue($columna.''.$renglon, $lista[$j]['datos_evento']['evento_hora_inicio'].'Hrs. '.$lista[$j]['datos_acuerdo']['acuerdo']."\r\n".$lista[$j]['datos_acuerdo']['accion']);
                    }
                }
            }
        }

        $styleThinBlackBorderOutline = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];
        $spreadsheet->getActiveSheet()->getStyle('A5:F14')->applyFromArray($styleThinBlackBorderOutline);

        

        if($input['exportacion']=="pdf"){
            $response = response()->streamDownload(function() use ($spreadsheet) {
                $writer = IOFactory::createWriter($spreadsheet, 'Mpdf');
                $writer->save('php://output');
            });

            $response->setStatusCode(200);
            $response->headers->set('Content-Type', 'application/pdf');
            $response->headers->set('Content-Disposition', 'attachment; filename="agenda_audiencias_'.date('m_d').'.pdf"');
            $response->send();
        }
        else{
            $response = response()->streamDownload(function() use ($spreadsheet) {
                $writer = new Xls($spreadsheet);
                $writer->save('php://output');
            });

            $response->setStatusCode(200);
            $response->headers->set('Content-Type', 'application/vnd.ms-excel');
            $response->headers->set('Content-Disposition', 'attachment; filename="agenda_audiencias_'.date('m_d').'.xls"');
            $response->send();
        }

    }

}