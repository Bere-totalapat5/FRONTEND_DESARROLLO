<?php
namespace App\Http\Controllers\clases;

use App\Http\Controllers\clases\fpdf181\FPDF;

class pdf extends FPDF{

    private $ruta_publica_img;
    private $ruta_publica_doc;
    private $num_caracteres;
    private $tiempo;

    public function __construct($opc1, $opc2, $opc3){
        parent::__construct($opc1, $opc2, $opc3);

        $this->ruta_publica_img = $_SERVER["DOCUMENT_ROOT"]."/imagenes/";
        $this->ruta_publica_doc = $_SERVER["DOCUMENT_ROOT"]."/documentos/reportes_ventas/";
        $this->num_caracteres = 88;
        $this->tiempo = $this->tiempo();

        $this->AddPage();

        $this->SetXY(5,5);
        $this->Image($this->ruta_publica_img."logo_anales.png",(($this->GetPageWidth()/2)/2),0,($this->GetPageWidth()/2),30);

        $this->SetXY(($this->GetPageWidth() - 45),15);
        $this->SetFont('Arial','B',8);

        $this->Cell(40,10,date("Y-m-d h:i a", $this->tiempo ));

        $this->SetXY(18,30);
    }

    public function encabezado_tabla(){

        $this->SetDrawColor(91,156,180);
        $this->SetFillColor(91,156,180);
        $this->SetTextColor(255,255,255);

        $this->SetFont('Arial','B',10);
        $this->Cell(10,5,'#',1,0,'C',true);
        $this->Cell(30,5,'Clave Producto',1,0,'C',true);
        $this->Cell(145,5,'Producto',1,0,'C',true);
        $this->Cell(30,5,'Costo Unitario',1,0,'C',true);
        $this->Cell(20,5,'Cantidad',1,0,'C',true);
        $this->Cell(25,5,'Costo Total',1,0,'C',true);

    }

    public function datos_tabla( $datos, $monto, $libros ){

        if( is_array($datos) ){

            $this->SetFont('Arial','',8);
            $this->SetFillColor(233,248,254);
            $this->SetTextColor(0,0,0);

            $color = false;
            $contador = 0;

            foreach( $datos as $llave => $subarr ){

                $this->Ln(); $this->SetX(18);
                $this->Cell(10,5,++$contador,1,0,'C',$color);
                $this->Cell(30,5,$llave,1,0,'C',$color);

                if( strlen($subarr["nombre"]) >= $this->num_caracteres ){
                    $nombre = substr( $subarr["nombre"],0, ($this->num_caracteres - 7) )."...";
                    $this->Cell(145,5,$nombre,1,0,'C',$color);
                } else {
                    $this->Cell(145,5,$subarr["nombre"],1,0,'C',$color);
                }

                $this->Cell(30,5,('$'.number_format($subarr["costo_unitario"],2,'.',',')),1,0,'C',$color);
                $this->Cell(20,5,$subarr["cantidad"],1,0,'C',$color);
                $this->Cell(25,5,('$'.number_format($subarr["costo"],2,'.',',')),1,0,'C',$color);

                $color = !$color;
            }

            $this->Ln(); $this->SetX(18);
            $this->Cell(10,5,'',1,0,'C',$color);
            $this->Cell(30,5,'',1,0,'C',$color);
            $this->Cell(145,5,'',1,0,'C',$color);
            $this->Cell(30,5,'Total',1,0,'C',$color);
            $this->Cell(20,5,$libros,1,0,'C',$color);
            $this->Cell(25,5,('$'.number_format($monto,2,'.',',')),1,0,'C',$color);

        }

    }

    public function generar_documento(){
        $this->Output('F',$this->ruta_publica_doc."".$this->tiempo.".pdf");
    }

    public function retornar_nombre_documento(){
        return $this->tiempo.".pdf";
    }

    private function tiempo(){
        return (time() - (1 * 5 * 60 * 60));
    }

}

