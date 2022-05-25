<?php
  include "ClassQR.php";
  include "qrfmwk/qrlib.php"; 
  $oQR = new QR;

use setasign\Fpdi\Fpdi;

require_once('fpdf/fpdf.php'); // Incluímos las librerías anteriormente mencionadas
require_once('fpdi/src/autoload.php'); // Incluímos las librerías anteriormente mencionadas


function guardarPDF($idSentencia, $metadatos){

    class PDF extends FPDF
    {
    // Cabecera de página
            function Header()
            {
                // Logo
                $this->Image('/var/www/html/sicor_extendido_80/app/Http/Controllers/pruebas/caratula_qr/pjcdmx.png',10,8,60);
                //$this->Image('/var/www/html/sicor_extendido_80/app/Http/Controllers/promociones/caratula_qr/transparencia.png',170,8,33);
                // Arial bold 15
                $this->SetFont('Arial','B',20);
                // Movernos a la derecha
                $this->Ln(30);
                $this->Cell(80);
                // Título
                $this->Cell(30,10,utf8_decode('Sistema Integral de Gestión Judicial'),0,0,'C');
                $this->Ln(10);
                $this->Cell(185,8,utf8_decode('PROMOCIÓN'),0,0,'C');
                // Salto de línea
                
               
            }

            // Pie de página
            function Footer()
            {
                // Posición: a 1,5 cm del final
                $this->SetY(-20);
                // Arial italic 8
                $this->SetFont('Arial','',10);
                // Número de página
                $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
            }




            var $B=0;
            var $I=0;
            var $U=0;
            var $HREF='';
            var $ALIGN='';

            function WriteHTML($html)
            {
                //HTML parser
                $html=str_replace("\n",' ',$html);
                $a=preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
                foreach($a as $i=>$e)
                {
                    if($i%2==0)
                    {
                        //Text
                        if($this->HREF)
                            $this->PutLink($this->HREF,$e);
                        elseif($this->ALIGN=='center')
                            $this->Cell(0,5,$e,0,1,'C');
                        else
                            $this->Write(5,$e);
                    }
                    else
                    {
                        //Tag
                        if($e[0]=='/')
                            $this->CloseTag(strtoupper(substr($e,1)));
                        else
                        {
                            //Extract properties
                            $a2=explode(' ',$e);
                            $tag=strtoupper(array_shift($a2));
                            $prop=array();
                            foreach($a2 as $v)
                            {
                                if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
                                    $prop[strtoupper($a3[1])]=$a3[2];
                            }
                            $this->OpenTag($tag,$prop);
                        }
                    }
                }
            }

            function OpenTag($tag,$prop)
            {
                //Opening tag
                if($tag=='B' || $tag=='I' || $tag=='U')
                    $this->SetStyle($tag,true);
                if($tag=='A')
                    $this->HREF=$prop['HREF'];
                if($tag=='BR')
                    $this->Ln(5);
                if($tag=='P')
                    $this->ALIGN=$prop['ALIGN'];
                if($tag=='HR')
                {
                    if( !empty($prop['WIDTH']) )
                        $Width = $prop['WIDTH'];
                    else
                        $Width = $this->w - $this->lMargin-$this->rMargin;
                    $this->Ln(2);
                    $x = $this->GetX();
                    $y = $this->GetY();
                    $this->SetLineWidth(0.4);
                    $this->Line($x,$y,$x+$Width,$y);
                    $this->SetLineWidth(0.2);
                    $this->Ln(2);
                }
            }

            function CloseTag($tag)
            {
                //Closing tag
                if($tag=='B' || $tag=='I' || $tag=='U')
                    $this->SetStyle($tag,false);
                if($tag=='A')
                    $this->HREF='';
                if($tag=='P')
                    $this->ALIGN='';
            }

            function SetStyle($tag,$enable)
            {
                //Modify style and select corresponding font
                $this->$tag+=($enable ? 1 : -1);
                $style='';
                foreach(array('B','I','U') as $s)
                    if($this->$s>0)
                        $style.=$s;
                $this->SetFont('',$style);
            }

            function PutLink($URL,$txt)
            {
                //Put a hyperlink
                $this->SetTextColor(0,0,255);
                $this->SetStyle('U',true);
                $this->Write(5,$txt,$URL);
                $this->SetStyle('U',false);
                $this->SetTextColor(0);
            }


            function drawTextBox($strText, $w, $h, $align='L', $valign='T', $border=true)
            {
                $xi=$this->GetX();
                $yi=$this->GetY();
                
                $hrow=$this->FontSize;
                $textrows=$this->drawRows($w,$hrow,$strText,0,$align,0,0,0);
                $maxrows=floor($h/$this->FontSize);
                $rows=min($textrows,$maxrows);

                $dy=0;
                if (strtoupper($valign)=='M')
                    $dy=($h-$rows*$this->FontSize)/2;
                if (strtoupper($valign)=='B')
                    $dy=$h-$rows*$this->FontSize;

                $this->SetY($yi+$dy);
                $this->SetX($xi);

                $this->drawRows($w,$hrow,$strText,0,$align,false,$rows,1);

                if ($border)
                    $this->Rect($xi,$yi,$w,$h);
            }

            function drawRows($w, $h, $txt, $border=0, $align='J', $fill=false, $maxline=0, $prn=0)
            {
                $cw=&$this->CurrentFont['cw'];
                if($w==0)
                    $w=$this->w-$this->rMargin-$this->x;
                $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
                $s=str_replace("\r",'',$txt);
                $nb=strlen($s);
                if($nb>0 && $s[$nb-1]=="\n")
                    $nb--;
                $b=0;
                if($border)
                {
                    if($border==1)
                    {
                        $border='LTRB';
                        $b='LRT';
                        $b2='LR';
                    }
                    else
                    {
                        $b2='';
                        if(is_int(strpos($border,'L')))
                            $b2.='L';
                        if(is_int(strpos($border,'R')))
                            $b2.='R';
                        $b=is_int(strpos($border,'T')) ? $b2.'T' : $b2;
                    }
                }
                $sep=-1;
                $i=0;
                $j=0;
                $l=0;
                $ns=0;
                $nl=1;
                while($i<$nb)
                {
                    //Get next character
                    $c=$s[$i];
                    if($c=="\n")
                    {
                        //Explicit line break
                        if($this->ws>0)
                        {
                            $this->ws=0;
                            if ($prn==1) $this->_out('0 Tw');
                        }
                        if ($prn==1) {
                            $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
                        }
                        $i++;
                        $sep=-1;
                        $j=$i;
                        $l=0;
                        $ns=0;
                        $nl++;
                        if($border && $nl==2)
                            $b=$b2;
                        if ( $maxline && $nl > $maxline )
                            return substr($s,$i);
                        continue;
                    }
                    if($c==' ')
                    {
                        $sep=$i;
                        $ls=$l;
                        $ns++;
                    }
                    $l+=$cw[$c];
                    if($l>$wmax)
                    {
                        //Automatic line break
                        if($sep==-1)
                        {
                            if($i==$j)
                                $i++;
                            if($this->ws>0)
                            {
                                $this->ws=0;
                                if ($prn==1) $this->_out('0 Tw');
                            }
                            if ($prn==1) {
                                $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
                            }
                        }
                        else
                        {
                            if($align=='J')
                            {
                                $this->ws=($ns>1) ? ($wmax-$ls)/1000*$this->FontSize/($ns-1) : 0;
                                if ($prn==1) $this->_out(sprintf('%.3F Tw',$this->ws*$this->k));
                            }
                            if ($prn==1){
                                $this->Cell($w,$h,substr($s,$j,$sep-$j),$b,2,$align,$fill);
                            }
                            $i=$sep+1;
                        }
                        $sep=-1;
                        $j=$i;
                        $l=0;
                        $ns=0;
                        $nl++;
                        if($border && $nl==2)
                            $b=$b2;
                        if ( $maxline && $nl > $maxline )
                            return substr($s,$i);
                    }
                    else
                        $i++;
                }
                //Last chunk
                if($this->ws>0)
                {
                    $this->ws=0;
                    if ($prn==1) $this->_out('0 Tw');
                }
                if($border && is_int(strpos($border,'B')))
                    $b.='B';
                if ($prn==1) {
                    $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
                }
                $this->x=$this->lMargin;
                return $nl;
            }

            
    }

    //1593141963|6|1|1.0|C|C100|2020|1|Ordinario|Centésimo de lo Civil|2020-08-26 20:24:17|Salvador  Ríos  García , Pepe  Pecas  |Lalo  Landa  |1|1593141963|sigj_promocion


    $datos=explode('|', $metadatos);

    // Creación del objeto de la clase heredada
    $pdf = new PDF('P','mm','Letter');
    $pdf->AliasNbPages();
    $pdf->AddPage();

    $pdf->SetFont('Arial','',12);
    //$pdf->Image("/var/www/html/sicor_extendido_80/app/Http/Controllers/pruebas/caratula_qr/qr_img/".$idSentencia.".png",70,70);
    $pdf->Ln(120);


    $pdf->SetTextColor(73,102,70);

    $pdf->Cell(32);
    $pdf->drawTextBox('En el <b><i>Boletín Judicial</i> </b> No. <U>                          </U> correspondiente al día <U>           </U> de            <U>                                           </U>    de ', 150, 50, 'L', 'T');


    

    

    $pdf->Cell(20);
    /*
    $pdf->WriteHTML('<table width="100%" style="page-break-inside: avoid;"><tr>
    <td><p style="color: #464;margin-left: 3em">En el <b><i>Boletín Judicial</i>&nbsp;</b> No. <U>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</U>
    correspondiente al día <U>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</U> de 
    <U>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</U> de <U>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</U> se hizo la publicación de Ley.&mdash; Conste.<br>
    El <U>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</U> de <U>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</U> del <U>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</U>, surtió efectos la notificación anterior.&mdash; Conste.</P>
    </td></tr></table>');
    */
    $pdf->Cell(20);
    $pdf->Cell(0,6,utf8_decode('JUZGADO:                                       '),0,1);
    $pdf->Cell(20);
    $pdf->Cell(0,6,utf8_decode('EXPEDIENTE:                                 '),0,1);
    //$pdf->Cell(20);
    //$pdf->Cell(0,6,utf8_decode('NÚMERO EXPEDIENTE:                '.$datos[7]),0,1);
    $pdf->Cell(20);
    $pdf->Cell(0,6,utf8_decode('FECHA DE DOCUMENTO:             '),0,1);
    $pdf->Output();

    /*
    $pdf->Cell(20);
    $pdf->Cell(0,6,utf8_decode('ID DOCUMENTO:                             '.$datos[0]),0,1);
    $pdf->Cell(20);
    $pdf->Cell(0,6,utf8_decode('ID APLICATIVO:                               '.$datos[2]),0,1);
    $pdf->Cell(20);
    $pdf->Cell(0,6,utf8_decode('ID MATERIA:                                    '.$datos[4]),0,1);
    $pdf->Cell(20);
    $pdf->Cell(0,6,utf8_decode('MATERIA:                                        '.$datos[9]),0,1);
    $pdf->Cell(20);
    $pdf->Cell(0,6,utf8_decode('ID JUICIO:                                        '.$datos[13]),0,1);
    $pdf->Cell(20);
    $pdf->Cell(0,6,utf8_decode('JUICIO:                                            '.$datos[8]),0,1);
    $pdf->Cell(20);
    $pdf->Cell(0,6,utf8_decode('ID JUZGADO:                                  '.$datos[5]),0,1);
    $pdf->Cell(20);
    $pdf->Cell(0,6,utf8_decode('JUZGADO:                                       '.$datos[9]),0,1);
    $pdf->Cell(20);
    $pdf->Cell(0,6,utf8_decode('AÑO EXPEDIENTE:                         '.$datos[6]),0,1);
    $pdf->Cell(20);
    $pdf->Cell(0,6,utf8_decode('NÚMERO EXPEDIENTE:                '.$datos[7]),0,1);
    $pdf->Cell(20);
    $pdf->Cell(0,6,utf8_decode('ASUNTO:'),0,1);
    $pdf->Cell(20);
    $pdf->Cell(0,6,utf8_decode('ID TIPO EXPEDIENTE:                   POS'),0,1);
    $pdf->Cell(20);
    $pdf->Cell(0,6,utf8_decode('TIPO EXPEDIENTE:                        POSTERIOR'),0,1);
    $pdf->Cell(20);
    $pdf->Cell(0,6,utf8_decode('FECHA DE DOCUMENTO:             '.$datos[10]),0,1);
    $pdf->Cell(20);
    $pdf->Cell(0,6,utf8_decode('ACTOR:                                           '.$datos[11]),0,1);
    $pdf->Cell(20);
    $pdf->Cell(0,6,utf8_decode('DEMANDAO:                                   '.$datos[12]),0,1);
    $pdf->Output();
    */
}


/*
DATOS FINALES
$idSentencia = rand();
$formData = array("A","B","C","D");


$qrGenerado = $oQR -> generaImagenQR($idSentencia,$formData);
$resultado = guardarPDF($idSentencia);

var_dump($resultado);
*/


/* $pdf->AddPage();
$pdf->setSourceFile("Ruta_de_mi_archivo_PDF"); // Sin extensión
$template = $pdf->importPage(1);
$pdf->useTemplate($template);
$pdf->Image('Ruta_de_mi_imagen.jpg', $x, $y, $width, $height);
$pdf->Output($nuevoNombreDelPDF, "F"); */

?>