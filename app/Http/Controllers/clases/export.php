<?php

namespace App\Http\Controllers\clases;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
// returnuse Session;

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
use \PhpOffice\PhpSpreadsheet\Cell\DataType;

use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class export 
{
    private $report_title = null;
    private $sheet_title = null;
    private $data=null;     // ['nombre_columna' => 'Ejemplo dato BD']
    private $headers=null;  // ['nombre_Columna' => 'Titulo en columna XLS o PDF']
    private $path='/var/www/html/sigj_penal/storage/temp_exportaciones/';
    private $filename=null;
    private $temas = ['sigj_penal' => 'FF848F33', 'PJ' => 'FF216465', 'promujer' => 'FF075576'];
    private $tema = 'PJ';
    private $position_sheet = 'vertical';

    private $columns = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];

    public function set_report_title($title){
        $this->report_title = $title;
    }
    
    public function set_sheet_title($title){
        $this->sheet_title = $title;
    }

    public function set_header($array_headers){
        $this->headers = $array_headers;
    }

    public function set_data($array_data){
        $this->data = $array_data;
    }

    public function set_tema($tema){
        $this->tema = $tema;
    }
    
    public function set_position_sheet($position_sheet){
        $this->position_sheet = $position_sheet;
    }

    public function get_file($export, $out){
        //dd('armando');
        $filename = $this->filename != null ? $this->filename : ( $this->report_title != null ? str_replace(' ','_',$this->report_title) : 'Prueba_Reporte_CLASE' );
        $filename = $filename.'.'.$export;
        $file_path = $this->path.$filename;
        $sheet_title = $this->sheet_title != null ? $this->sheet_title : 'Hoja 1';

        $tema = $this->temas[$this->tema];

        $spreadsheet = new Spreadsheet();


        $spreadsheet->getProperties()
            ->setCreator('SIGJ PENAL')
            ->setLastModifiedBy('SIGJ PENAL')
            ->setTitle('Exportacion de datos')
            ->setSubject('Exportacion de datos')
            ->setDescription('Datos exportados a un archivo xsl o pdf.');

        $spreadsheet->setActiveSheetIndex(0);
        $spreadsheet->getActiveSheet()->setTitle( $sheet_title );

        // se agrega titulo 

        // SE PONE EL LOGO
        $drawing = new Drawing();
        $drawing->setName('Paid');
        $drawing->setDescription('Paid');
        $drawing->setPath(__DIR__ . '/../../../../public/images/LOGO_PJ_vextendida_color.png');
        $drawing->setHeight(86);
        $drawing->setCoordinates('A1');
        $drawing->setWorksheet($spreadsheet->getActiveSheet());

        //$spreadsheet->getActiveSheet()->getStyle('A1')->setHeight(50);

        // se obtiene el total de columnas a usar
        $max_col = count($this->headers);

        // se pone fecha y aplican estrilos para el mismo
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('C1', 'Ciudad de México a '.utilidades::acomodarFecha(date('Y-m-d')).'.');
        $spreadsheet->getActiveSheet()->setCellValueExplicit('C2', $this->report_title , DataType::TYPE_STRING);

        $spreadsheet->getActiveSheet()->getStyle('C1:'.$this->columns[$max_col-1].'4')->getFill()->setFillType(Fill::FILL_SOLID);
        $spreadsheet->getActiveSheet()->getStyle('C1:'.$this->columns[$max_col-1].'4')->getFill()->getStartColor()->setARGB( $tema );
        $spreadsheet->getActiveSheet()->getStyle('C1:'.$this->columns[$max_col-1].'4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('C1:'.$this->columns[$max_col-1].'4')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('C1:'.$this->columns[$max_col-1].'4')->getFont()->getColor()->setARGB(Color::COLOR_WHITE);
        $spreadsheet->getActiveSheet()->getStyle('C1:'.$this->columns[$max_col-1].'4')->getAlignment()->setWrapText(true);

        // se unen celdas para titulo
        $spreadsheet->getActiveSheet()->mergeCells('A1:B4'); // imagen
        $spreadsheet->getActiveSheet()->mergeCells('C1:'.$this->columns[$max_col-1].'1'); // fecha
        $spreadsheet->getActiveSheet()->mergeCells('C2:'.$this->columns[$max_col-1].'2'); // titulo
        $spreadsheet->getActiveSheet()->mergeCells('C3:'.$this->columns[$max_col-1].'4'); // Vacio


        // se aplican estilos para fecha, titulo del reporte titulos de cada columna
        $spreadsheet->getActiveSheet()->getStyle('A5:'.$this->columns[$max_col-1].'5')->getFill()->setFillType(Fill::FILL_SOLID);
        $spreadsheet->getActiveSheet()->getStyle('A5:'.$this->columns[$max_col-1].'5')->getFill()->getStartColor()->setARGB( $tema );
        $spreadsheet->getActiveSheet()->getStyle('A5:'.$this->columns[$max_col-1].'5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A5:'.$this->columns[$max_col-1].'5')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A5:'.$this->columns[$max_col-1].'5')->getFont()->getColor()->setARGB(Color::COLOR_WHITE);
        $spreadsheet->getActiveSheet()->getStyle('A5:'.$this->columns[$max_col-1].'5')->getAlignment()->setWrapText(true);
    

        // se llena header

        $row = 5;
        $col= 0;
        foreach ($this->headers as $th){
            $spreadsheet->getActiveSheet()->getColumnDimension($this->columns[$col])->setAutoSize(true);
            $spreadsheet->getActiveSheet()->setCellValue($this->columns[$col].$row, $th);
            $col = $col + 1;
        }
        
        // se llena body

        $row = 6;
        foreach ($this->data as $data){
            $col= 0;
            foreach ($this->headers as $index => $value ){
                $spreadsheet->getActiveSheet()->setCellValueExplicit($this->columns[$col].$row, $data[$index], DataType::TYPE_STRING);
                $col = $col + 1;
            }
            $row = $row + 1;
        }

        // SE AGREGAN ESTILOS AL body

        // se obtiene el rango ocupado
        $range = $spreadsheet->getActiveSheet()->getHighestRowAndColumn();

        if($export == 'pdf'){
            $styleThinBlackBorderOutline = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => 'FF000000'],
                    ],
                ],
            ];
            $spreadsheet->getActiveSheet()->getStyle('A5:'.$range['column'].$range['row'])->applyFromArray($styleThinBlackBorderOutline);
        }


        // se$spreadsheet->getActiveSheet()->getStyle('A3:'.$range['column'].$range['row'])->getFont()->setSize(10);
        $spreadsheet->getActiveSheet()->getStyle('A5:'.$range['column'].$range['row'])->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A5:'.$range['column'].$range['row'])->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // se pone paginación
        //$spreadsheet->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&P');
        //$spreadsheet->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&F Page &P / &N');
        // $spreadsheet->getActiveSheet()->getHeaderFooter()->setDifferentOddEven(false);
        // $spreadsheet->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&F Page &P / &N');

        // SE DEFINE HORIENTACION
        if( $this->position_sheet == 'horizontal'){
            $spreadsheet->getActiveSheet()->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
        }


        // SE DEFINE LA EXPORTACION PDF O XLS

        $writer = null;
        $application_type = $export == 'pdf' ? 'pdf' : 'vnd.ms-excel'; //vnd.openxmlformats-officedocument.spreadsheetml.sheet;

        if($export == 'pdf'){
            $writer = IOFactory::createWriter($spreadsheet, 'Mpdf');
            //$writer->generateTableFooter();
        }else{
            $writer = new Xls($spreadsheet);
        }

        // SE DEFINE LA SALIDA donwload O B64
        
        if($out == 'download'){
            header('Content-Type: application/'.$application_type);
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
        }

        if($out == 'B64'){
            if(!(file_exists($this->path) && is_dir($this->path)) )
                mkdir($this->path, 0777, true);

            $writer->save($file_path);
            if (file_exists($file_path) && is_file ($file_path) ) {
                $file_B64 = base64_encode( file_get_contents($file_path) );
                unlink($file_path);
            }
            
            //return $file_B64;
            return array('status' =>100,'message'=>'DATOS EXPORTADOS CON EXITO','file'=>"data:application/".$application_type.";base64,".$file_B64, 'filename' => $filename ) ;
        }
    }
}
