<?php

namespace App\Http\Controllers\procesosTrabajo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\clases\procesos_trabajo;
use App\Http\Controllers\clases\utilidades;
use DB;


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

class control_solicitudes extends Controller
{
    public function inicio_solicitudes( Request $request, $folio="", $fecha_inic="", $fecha_final=""  ){

        //$lista=procesos_trabajo::obtener_solicitudes_lista($request);

        $lista_arr=procesos_trabajo::obtenerListaSicor($request, $_GET);

        $lista=$lista_arr[0];
        $datos=$lista_arr[1];
        $juicio_sicor_count=$lista_arr[2];
        $lista_promociones=$lista_arr[3];
        
        return view(    "procesosTrabajo.solicitudes_sicor",
                        ["entorno"=>$request->entorno, 
                        "request"=>$request,
                        "sesion"=>$request->session()->all(),
                        "menu_general"=>$request->menu_general,
                        "lista"=>$lista,
                        "datos"=>$datos,
                        "juicio_sicor_count"=>$juicio_sicor_count,
                        "lista_promociones"=>$lista_promociones
                        ]
                    );

    }
    
    //aprovado, rechazado, cancelado o rebocado
    public function solicitudes_cabiar_estatus( Request $request ){
        $input = $request->all();
        $id=$input['id'];
        $estatus=$input['estatus'];

        $lista=procesos_trabajo::cambiar_solicitudes_estatus($request, $id, $estatus);
        if($lista['status']=="100"){
            //se manda el correo

        }

        return response()->json([$lista]);
    }

    public function solicitudes_cabiar_estatus_masivo( Request $request ){
        $input = $request->all();

        $arr_status=explode('-',$input['arr_imprimir']);

        //return response()->json([$arr_status]);

        for($i=0; $i<count($arr_status); $i++){
            if($arr_status[$i]!=""){
                $arr_valores=explode(',', $arr_status[$i]);

                $id=$arr_valores[1];
                $estatus=$input['estatus'];
        
                $lista=procesos_trabajo::cambiar_solicitudes_estatus($request, $id, $estatus);
            }
        }
        
        return response()->json([$lista]);
    }

    public function obtenerPromocionPDF( Request $request ){
        $input = $request->all();

        $lista=procesos_trabajo::obtenerPromocionPDF($request, $input['id']);

        return response()->json([$lista]);
    }

    public function exportar_lista_excel(Request $request){

        $input = $request->all();

        $lista=procesos_trabajo::obtenerListaSicor($request, $input);


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
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(60);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(15);

        //PONEMOS EL TITULO AZUL
        $spreadsheet->getActiveSheet()->getStyle('A1:E1')->getFill()->setFillType(Fill::FILL_SOLID);
        $spreadsheet->getActiveSheet()->getStyle('A1:E1')->getFill()->getStartColor()->setARGB('FF216465');
        $spreadsheet->getActiveSheet()->getStyle('A1:E1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A1:E1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A1:E1')->getFont()->getColor()->setARGB(Color::COLOR_WHITE);
        $spreadsheet->getActiveSheet()->getStyle('A1:E1')->getAlignment()->setWrapText(true);

        //ESCRIBIMOS LOS TITULOS
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'FOLIO')
            ->setCellValue('B1', 'EXPEDIENTE' )
            ->setCellValue('C1', 'SOLICITANTE' )
            ->setCellValue('D1', 'FECHA' )
            ->setCellValue('E1', 'ESTATUS' );   

            
        //se pone la info
        $styleThinBlackBorderOutline = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];
       
        for($j=0; $j<count($lista[0]); $j++){
            $row=$j+2;
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A'.$row, $lista[0][$j]['id_usuario_juicio']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('B'.$row, $lista[0][$j]['expediente'].'/'.$lista[0][$j]['anio']."\r\n".'Sec. '.$lista[0][$j]['secretaria']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('C'.$row, $lista[0][$j]['nombres'].' '.$lista[0][$j]['paterno'].' '.$lista[0][$j]['materno']."\r\n".'Parte: '.$lista[0][$j]['parte']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('D'.$row, date("Y-m-d", strtotime($lista[0][$j]['alta'])));
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('E'.$row, 'Estatus: ' . $lista[0][$j]['estatus']);


            $spreadsheet->getActiveSheet()->getStyle('A'.$row.':E'.$row)->getFont()->setSize(9);
            $spreadsheet->getActiveSheet()->getStyle('A'.$row.':E'.$row)->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
            $spreadsheet->getActiveSheet()->getStyle('A'.$row.':E'.$row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $spreadsheet->getActiveSheet()->getStyle('A'.$row.':E'.$row)->getAlignment()->setWrapText(true);
            $spreadsheet->getActiveSheet()->getStyle('A'.$row.':E'.$row)->applyFromArray($styleThinBlackBorderOutline);

        }
        
        if(isset($input['exportacion']) and $input['exportacion']=="pdf"){
            $response = response()->streamDownload(function() use ($spreadsheet) {
                $writer = IOFactory::createWriter($spreadsheet, 'Mpdf');
                $writer->save('php://output');
            });

            $response->setStatusCode(200);
            $response->headers->set('Content-Type', 'application/pdf');
            $response->headers->set('Content-Disposition', 'attachment; filename="lista_solicitudes_'.date('m_d').'.pdf"');
            $response->send();
        }
        else{
            $response = response()->streamDownload(function() use ($spreadsheet) {
                $writer = new Xls($spreadsheet);
                $writer->save('php://output');
            });

            $response->setStatusCode(200);
            $response->headers->set('Content-Type', 'application/vnd.ms-excel');
            $response->headers->set('Content-Disposition', 'attachment; filename="lista_solicitudes_'.date('m_d').'.xls"');
            $response->send();
        }

    }
        
}