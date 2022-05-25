<?php

namespace App\Http\Controllers\pruebas;

use App\Http\Controllers\clases\archivos;
use App\Http\Controllers\clases\gestorDocumental;
use App\Http\Controllers\clases\agendas;
use App\Http\Controllers\clases\elementos_boletin;
use App\Http\Controllers\clases\utilidades;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;



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


//require_once('/var/www/html/sicor_extendido_80/app/Http/Controllers/promociones/caratula_qr/fpdf/fpdf.php'); // Incluímos las librerías anteriormente mencionadas
require_once('/var/www/html/sicor_extendido_80/app/Http/Controllers/promociones/caratula_qr/fpdi/src/autoload.php'); // Incluímos las librerías anteriormente mencionadas


class control_pruebas extends Controller
{
    public function inicio(Request $request){

    	return view("pruebas",[
            "response" => "vista vista vista"
        ]);
    }

    public function probar_excel(Request $request){

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

    public function probardocumento(Request $request){

        $clean_html='';

    	
    }

    public function descarga_gestor( Request $request, $idDocument ){
        if(isset($idDocument)){
            //gestorDocumental::getDocGestor($request, $idDocument);

            $bin=gestorDocumental::getDocGestor($request, $idDocument); 

        
            header('Content-Type: application/pdf'); 
           //echo $bin['url'];
            echo $bin['pdf'];
            //$idGlobal=3163;



        }
        exit;
    }

    public function probarpdf( Request $request ){

        //return 1;
        $datos=[];
        $datos['secretaria']=1;
        $datos['expediente']=1;
        $datos['juzgado']=1;
        $datos['actor']=1;
        $datos['demandado']=1;
        $datos['juicio']=1;
        $datos['nombre_juez']=1;
        $datos['nombre_sa']=1;
        $datos['fecha_creacion']=1;
        $datos['id_expediente']=1;
        
        archivos::generarPortada_v2($request, $datos);
        

    }

    public function probar_pdf( Request $request ){

        $proceso = rand(100, 999);
        $id_acuerdo="1598822716";
        $url_temporal=public_path('temporales')."/preview_1601008008_245.pdf";

        $arr_num_firas=archivos::numero_firmas_acuerdo($request, $request->session()->get('usuario_juzgado'), $id_acuerdo);
        $num_firmas=$arr_num_firas['response'];

        $output = shell_exec("pdfinfo ".$url_temporal);
        preg_match('/Pages:\s+([0-9]+)/', $output, $pagecountmatches);
        $pagecount = $pagecountmatches[1];
        //print_r($pagecount);

        preg_match('/Page size:\s+([0-9]{0,5}\.?[0-9]{0,3}) x ([0-9]{0,5}\.?[0-9]{0,3})/', $output, $pagesizematches);
        //print_r($pagesizematches);

        $lista_fecha_publicacion=agendas::obtener_tiempo_disponible($request);
        $lista_fecha_resolucion=agendas::calcular_dias($request, $lista_fecha_publicacion['response_publicacion'], 1, "si");
        $lista_num_boletin=elementos_boletin::calculo_numero_boletin($request, $lista_fecha_publicacion['response_publicacion']);
        $arr_num_firas=archivos::numero_firmas_acuerdo($request, $request->session()->get('usuario_juzgado'), $id_acuerdo);

        unset($datos);
        $datos['fecha_resolucion']=$lista_fecha_resolucion['response'];
        $datos['fecha_publicacion']=$lista_fecha_publicacion['response_publicacion'];
        $datos['num_boletin']=$lista_num_boletin['response']['numero'];


        $num_firmas_sigj=0;
        if(isset($arr_num_firas['response_data'])){
            for($i=0; $i<count($arr_num_firas['response_data']); $i++){
                if($arr_num_firas['response_data'][$i]['flujo_sala_tipo_firma']=='sello_sigj'){
                    $num_firmas_sigj=$arr_num_firas['response_data'][$i]['numero'];
                }
            }
        }


        $num_firmas_boletin=$arr_num_firas['response']-$num_firmas_sigj;


        $url_boletin=archivos::llenarSelloLibroGob($request, $url_temporal, $id_acuerdo, $datos);
        print($url_boletin.'<br>');
 

        $url_unidos=$url_temporal;
        $url_separados=public_path('temporales')."/doc_firmado_".$proceso."_".$id_acuerdo."_";
        $url_separados_comodin=public_path('temporales')."/doc_firmado_".$proceso."_".$id_acuerdo."_%04d.pdf";

        $shell_burst="pdftk ".$url_unidos." burst output ".$url_separados_comodin;
        print($shell_burst.'<br>');
        $output = shell_exec($shell_burst);
        print($output);


        $resta_sello_boletin=$pagecount-$num_firmas_boletin;
 

        $file_original=public_path('temporales')."/doc_firmado_".$proceso."_".$id_acuerdo."_".(utilidades::acomodarCeros($resta_sello_boletin, 4)).".pdf";
        $file_sustituir=public_path('temporales')."/doc_sello_firmado_".$proceso."_".$id_acuerdo."_".(utilidades::acomodarCeros($resta_sello_boletin, 4)).".pdf";
        
        print($file_original.'<br>');
        print($file_sustituir.'<br>');
        //se copia para hacer el sellado
        copy($file_original, $file_sustituir);

        $shell_multistamp="pdftk $file_sustituir multistamp $url_boletin output $file_original";
        print($shell_multistamp.'<br>');
        $output = shell_exec($shell_multistamp);

        

        //se pone en la primera hoja
        $file_original_escaner=public_path('temporales')."/doc_firmado_".$proceso."_".$id_acuerdo."_0001.pdf";
        $file_sustituir_escaner=public_path('temporales')."/doc_escaner_firmado_".$proceso."_".$id_acuerdo."_0001.pdf";
        copy($file_original_escaner, $file_sustituir_escaner);

        
        // find page sizes
        $output = shell_exec("pdfinfo ".$file_original_escaner);
        preg_match('/Page size:\s+([0-9]{0,5}\.?[0-9]{0,3}) x ([0-9]{0,5}\.?[0-9]{0,3})/', $output, $pagesizematches);
        //print_r($pagesizematches);
        $width = round($pagesizematches[1]/2.83);
        $height = round($pagesizematches[2]/2.83);

        //se crea el QR y el pdf para el esccaner
        $url_scaner=utilidades::caraturlaEscanerQR($request, 'isra', 'isra', $width, $height);
        print($url_scaner.'<br>');


        $shell_multistamp="pdftk $file_sustituir_escaner stamp $url_scaner output $file_original_escaner";
        $output = shell_exec($shell_multistamp);


        $shell_cat="pdftk $url_separados*.pdf cat output $url_unidos";
        print($shell_cat.'<br>');
        $output = shell_exec($shell_cat);

    }

    public static function get_string_between($string, $start, $end, $posicion){
        $string = ' ' . $string;
        $ini = strpos($string, $start, $posicion);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        $final['texto']=substr($string, $ini, $len);
        $final['posicion']=$ini+$len;
        return $final;
    }


    public function migracion_exhortos( Request $request){
        
        $db_origen = DB::connection( 'SGJP_TSJCDMX' );

        if( isset( $request->datos['origen'] ) and $request->datos['origen'] == 'penal_prod'  )
        $db_origen = DB::connection( 'SGJP_TSJCDMX_PROD' );

        $db_destino = DB::connection( 'SIGJ_Penal' );

        if( isset( $request->datos['destino'] ) and $request->datos['destino'] == 'penal_prod'  )
        $db_destino = DB::connection( 'SIGJ_Penal_PROD' );

        $codigo_unidad = null;

        if( isset( $request->datos['unidad'] ) and $request->datos['unidad'] != '-' and strlen( $request->datos['unidad']) )
        $codigo_unidad = array_diff( explode(',',$request->datos['unidad']) , ["", " ", "   "] );

        $ids_exhorto = null;

        if( isset( $request->datos['ids_exhorto'] ) and $request->datos['ids_exhorto'] != '-' and strlen( $request->datos['ids_exhorto']) )
        $ids_exhorto = array_diff( explode(',',$request->datos['ids_exhorto']) , ["", " ", "   "] );

        $archivo_desde_id_exhorto = base_path().'/storage/migracion/desde_id_exhorto.log';
        $desde_id_exhorto = file_exist($archivo_desde_id_exhorto) ? file_get_contents( $archivo_desde_id_exhorto ) : 0;

        $db_origen->table( '_92_tablaDinamica' );

        // APLICAN WHERE

        if( $codigo_unidad == null ) $db_origen->where( 'id__92_tablaDinamica' , '>' , $desde_id_exhorto );        
        else $db_origen->whereIn( 'id__92_tablaDinamica' , $ids_exhorto ); 
        
        if( $codigo_unidad != null )  $db_origen->whereIn( 'codigoUnidad' , $codigo_unidad ); 

        $ruta_log_contador = base_path().'/storage/migracion/'.date('Y/m/d').'/exhortos_contador.log';
        $ruta_log_success =  base_path().'/storage/migracion/'.date('Y/m/d').'/exhortos_success.log';
        $ruta_log_error =    base_path().'/storage/migracion/'.date('Y/m/d').'/exhortos_error.log';
        $ruta_log_warning =  base_path().'/storage/migracion/'.date('Y/m/d').'/exhortos_warning.log';

        if( ! file_exists( base_path().'/storage/migracion/'.date('Y/m/d/') ) ) mkdir( base_path().'/storage/migracion/'.date('Y/m/d)'), 0777, true);
        
        $total_exhortos = $db_origen->count();

        $log_contador = fopen( $ruta_log_contador , 'a+');
        fwrite($log_contador, "[ ".date("Y-m-d H:i:s")." ]  Total : $total_exhortos ");
        

        $exhortos_success = 0;
        $exhortos_errors = 0;
        $exhortos_warnings = 0;

        $latencia = time();
        $ultimo_id_exhorto_migrado = 0;
        
        if( $total_exhortos > 0 ){

            fclose($log_contador);
            $log_contador =  fopen( $ruta_log_contador , 'a');
            $log_success =   fopen( $ruta_log_success , 'a+');
            $log_error =     fopen( $ruta_log_error , 'a+');
            $log_warning =   fopen( $ruta_log_warning , 'a+');

            fwrite($log_success,    "[ ".date("Y-m-d H:i:s")." ]   INICIA MIGRACION ");
            fwrite($log_error,      "[ ".date("Y-m-d H:i:s")." ]   INICIA MIGRACION ");
            fwrite($log_warning,    "[ ".date("Y-m-d H:i:s")." ]   INICIA MIGRACION ");


            $exhortos = $db_origen->get();

            foreach( $exhortos as $ie => $e ){

                $latencia = time() - $latencia; 
                fwrite($log_contador,   "\n\n [ ".date("Y-m-d H:i:s")." ]   SUCCESS : $exhortos_success  , ERRORS : $exhortos_errors  , WARNINGS : $exhortos_warnings , TAZA TRANSFERENCIA : $latencia seg.");
                $latencia = time();

                // $arch_exh = $db_origen->table('908_archivos')->where( 'idArchivo', '=', $e->id__92_tablaDinamica )->order_by( '' )->get();
                // if( $arch_exh->isEmpty() ) $arch_exh = (object) [ ["documentoRepositorio" => NULL, "nomArchivoOriginal" => NULL, "descripcion" => NULL, "documentoPKCS7" => NULL, ] ];
                
                try{

                    if( ! $db_destino->table('solicitudes')->where('id_solicitud', '=', $e->id__92_tablaDinamica )->exists() ){

                        $ins_e = $db_destino->table('solicitudes')->insertGetId([
                            "id_solicitud" => $e->id__92_tablaDinamica,
                            "id_unidad_registro" => $e->responsable,
                            "id_usuario_registro" => NULL,
                            "carga_masiva" => NULL,
                            "id_carpeta_judicial" => NULL,
                            "id_fiscalia" => NULL,
                            "id_agencia" => NULL,
                            "unidad_id_fis" => NULL,
                            "id_tipo_solicitud_audiencia" => NULL,
                            "id_audiencia" => NULL,
                            "id_solicitud_documento" => NULL,
                            "origen_solicitud" => NULL,
                            "tipo_solicitud_" => NULL,
                            "estatus_flujo_actual" => NULL,
                            "tipo_resolucion" => NULL,
                            "estatus_urgente" => NULL,
                            "estatus_telepresencia" => NULL,
                            "estatus_area_resguardo" => NULL,
                            "estatus_mod_testigo_protegido" => NULL,
                            "estatus_mesa_evidencia" => NULL,
                            "estatus_declaratoria" => NULL,
                            "estatus_detenido" => NULL,
                            "estatus_delito_grave" => NULL,
                            "estatus_semaforo" => NULL,
                            "folio_solicitud" => $e->codigo,
                            "materia_destino" => NULL,
                            "fecha_asignacion_carpeta" => NULL,
                            "fecha_solicitud" => NULL,
                            "folio_solicitud_audiencia" => NULL,
                            "fecha_recepcion" => $e->fechaRecepcion,
                            "hora_recepcion" => $e->horaRepepcion,
                            "duracion_aproximada" => NULL,
                            "ctrl_solicitud" => NULL,
                            "solicitud_id_fis" => NULL,
                            "cve_solicitud" => NULL,
                            "ctrl_uinv" => NULL,
                            "carpeta_investigacion" => NULL,
                            "mp_solicitante" => NULL,
                            "correo_mp" => NULL,
                            "curp_mp" => NULL,
                            "cordinacion_territorial" => NULL,
                            "cve_coortermp" => NULL,
                            "fecha_fenece" => NULL,
                            "descripcion_hechos" => NULL,
                            "ruta_base_xml" => NULL,
                            "ruta_base_log" => NULL,
                            "personas_ids" => NULL,
                            "ruta_base_pdf" => NULL,
                            "nombre_documento" => NULL,
                            "descripcion_documento" => NULL,
                            "md5_pdf" => NULL,
                            "exhorto_entidad_federativa" => (int) $e->entidadFederativa,
                            "exhorto_juzgado" => $e->autoridaExhortante,
                            "exhorto_nombre_juez" => $e->juezExhortante,
                            "exhorto_expediente_origen" => $e->numeroCausaOrigen,
                            "exhorto_num_folio" => $e->noOficio,
                            "exhorto_medio_recepcion" => NULL,
                            "exhorto_resumen" => $e->resumen,
                            "exhorto_tipo_unidad" => NULL,
                            "exhorto_id_unidad_especifica" => NULL,
                            "exhorto_autorizacion" => NULL,
                            "exhorto_comentario_autorizacion" => NULL,
                            "exhorto_delegacion" => (int) $e->delegacionExhorto,
                            "creacion" => $e->fechaCreacion,
                            "modificacion" => $e->fechaModif,
                            "estatus" => (int) $e->idEstado,
                        ]);

                        if( $ins_e > 0 ){
                            fwrite($log_success,   "\n\n [ ".date("Y-m-d H:i:s")." ] $e->id__92_tablaDinamica  => Insertado exitosamente , latencia => " . time()-$latencia ." seg." );    
                            $exhortos_success = $exhortos_success + 1;
                        }else{
                            fwrite($log_error,   "\n\n [ ".date("Y-m-d H:i:s")." ] $e->id__92_tablaDinamica  => No insertado" );    
                            $exhortos_errors = $exhortos_errors + 1; 
                        }

                    }else{
                        fwrite($log_warning,   "\n\n [ ".date("Y-m-d H:i:s")." ] $e->id__92_tablaDinamica  => Este id ya existe en solicitudes");    
                        $exhortos_warnings = $exhortos_warnings + 1;
                    } 

                }catch( \Exception $e){
                    fwrite($log_error,   "\n\n [ ".date("Y-m-d H:i:s")." ] $e->id__92_tablaDinamica  => ".$e->getMessage() );    
                    $exhortos_errors = $exhortos_errors + 1;
                }

                $ultimo_id_exhorto_migrado = $desde_id_exhorto < $ultimo_id_exhorto_migrado ? $ultimo_id_exhorto_migrado : $desde_id_exhorto;
            }

            $file = fopen( $archivo_desde_id_exhorto, 'w' );
            fwrite( $file,  $ultimo_id_exhorto_migrado );
            fclose( $file );

        }else{
            fwrite($log_contador, "[ ".date("Y-m-d H:i:s")." ] No se encontraron registros que cumplan con los parametros ingreados  -  ".date("Y-m-d H:i:s"));
            fclose($log_contador);
            //echo "No se encontraron registros que cumplan con los parametros ingreados";
        }
    }
}



