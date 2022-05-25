<?php
namespace App\Http\Controllers\clases;

use Illuminate\Http\Request;

class archivo_judicial{ 

    public static function juicios_para_archivo_judicial(Request $request, $datos){ 

        $response = $request
        ->clienteWS 
        ->request('GET', 'juicios_para_archivo_judicial/'.$request->session()->get('usuario_juzgado'),[
            "query" => [
                "datos" => [
                    "modo" => $datos['modo']
                ],
                "paginacion" => [
                    "pagina" => $datos['pagina'],
                    "registros_por_pagina" => $datos['registros_por_pagina']
                ],
            ],
            "headers" => [
                "Content-Type" => "application/json",
                "autorizacion" => "minutmanQAEtHReI",
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id")
            ]
        ]);
        
        $lista = json_decode($response->getBody(),true);

        return $lista;
    }


    public static function historial_archivo_judicial_expediente(Request $request, $datos){ 

        $response = $request
        ->clienteWS 
        ->request('GET', 'historial_archivo_judicial_expediente/'.$datos['id_juicio'].'/'.$request->session()->get('usuario_juzgado'),[
            "query" => [
                "datos" => [
                ]
            ],
            "headers" => [
                "Content-Type" => "application/json",
                "autorizacion" => "minutmanQAEtHReI",
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id")
            ]
        ]);
        
        $lista = json_decode($response->getBody(),true);
        return $lista;
    }


    public static function agregar_a_lista_archivo_judicial(Request $request, $datos){ 

        $response = $request
        ->clienteWS 
        ->request('POST', 'agregar_a_lista_archivo_judicial/'.$datos['id_juicio'].'/'.$request->session()->get('usuario_juzgado').'/'.$request->session()->get('usuario-id'),[
            "json" => [
                "datos" => [
                    "tipo_archivo_judicial"=>"archivo_judicial",
                    "num_fojas"=>$datos['fojas']
                ]
            ],
            "headers" => [
                "Content-Type" => "application/json",
                "autorizacion" => "minutmanQAEtHReI",
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
            ]
        ]);
        
        $lista = json_decode($response->getBody(),true);
        return $lista;
    }


    public static function eliminar_a_lista_archivo_judicial(Request $request, $datos){ 

        $response = $request
        ->clienteWS 
        ->request('PATCH', 'modificar_lista_archivo_judicial/'.$datos['id_archivo_judicial_lista'],[
            "json" => [
                "datos" => [
                    "estatus"=>"0"
                ]
            ],
            "headers" => [
                "Content-Type" => "application/json",
                "autorizacion" => "minutmanQAEtHReI",
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
            ]
        ]);
        
        $lista = json_decode($response->getBody(),true);
        return $lista;
    }


    public static function agregar_expediente_archivo_judicial(Request $request, $datos, $datos1){ 

        $response = $request
        ->clienteWS 
        ->request('PATCH', 'agregar_expediente_archivo_judicial/'.$request->session()->get('usuario-id').'/'.$request->session()->get('usuario_juzgado'),[
            "json" => [
                "datos" => [
                    "tipo_archivo_judicial"=>$datos1['tipo_archivo_judicial'],
                    "folio_lista"=>$datos1['folio_lista'],
                    "juicios"=>$datos
                ]
                
            ],
            "headers" => [
                "Content-Type" => "application/json",
                "autorizacion" => "minutmanQAEtHReI",
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id")
            ]
        ]);
        
        $lista = json_decode($response->getBody(),true);
        return $lista;
    }


    public static function agregar_lista_pdf_archivo_judicial(Request $request, $id, $accion, $pdf64){ 

        $response = $request
        ->clienteWS 
        ->request('POST', 'agregar_lista_pdf_archivo_judicial/'.$id.'/documento',[
            "json" => [
                "datos" => [
                    "modo"=>$accion,
                    "b64_pdf"=>$pdf64
                ]
                
            ],
            "headers" => [
                "Content-Type" => "application/json",
                "autorizacion" => "minutmanQAEtHReI",
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id")
            ]
        ]);
        
        $lista = json_decode($response->getBody(),true);
        return $lista;
    }


    public static function generarListaArchivoJudicial( Request $request, $datos, $folio, $tipo){

        
        ob_start();
        ?>

        <!DOCTYPE html>
        <html>
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
            </head>
            <body >
                
                <table style="font-family:'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif; width: 100%; font-size: 14px; ">
                    <tr>
                        <td style="width: 60%;">
                            <img src="/images/LOGO_PJ_vextendida_color.png" width="160px">
                        </td>
                        <td style="text-align: right;">
                            FOLIO: <?php print($folio); ?>
                        </td>
                    </tr>
                </table>
                <table style="font-family:'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif; width: 100%; font-size: 14px; ">
                    <tr>
                        <td style="text-align: justify;">
                            EXPEDIENTES QUE REMITE EL <?php print(mb_strtoupper($request->session()->get('juzgado_nombre_largo'), 'UTF-8')); ?>, CON ESTA FECHA AL ARCHIVO JUDICIAL <strong>EXPEDIENTES PARA SU RESGUARDO CON FUNDAMENTO EN EL ARTÍCULO 150</strong> DE LA LEY ORGÁNICA DEL TRIBUNAL SUPERIOR DE JUSTICIA DE LA CIUDAD DE MÉXICO.
                            <br>
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: right; ">
                        <br>REMISIÓN: <?php print(date('d/m/Y')); ?>
                        </td>
                    </tr>

                    <tr>
                        <td style="text-align: center; font-size:16px; text-decoration:underline;">
                        <?php
                            if($tipo=="archivo_judicial"){
                                print('<br><strong>RESGUARDO</strong><br><br><br>');
                            }
                            else if($tipo=="destruccion"){
                                print('<br><strong>DESTRUCCIÓN</strong><br><br><br>');
                            }
                            else{
                                print('<br><strong>DEVOLUCIÓN</strong><br><br><br>');
                            }
                        ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table class="lista">
                                <thead>
                                    <tr>
                                        <th class="lista">No. de órden</th>
                                        <th class="lista">Expediente</th>
                                        <th class="lista">Actor</th>
                                        <th class="lista">Demandado</th>
                                        <th class="lista">Materia del Juicio</th>
                                        <th class="lista">Fojas del expediente</th>
                                    </tr>
                                </thead>
                                <?php for($i=0; $i<count($datos); $i++){ ?>
                                <tr class="lista">
                                    <td class="lista" style="text-align: center;">
                                        <?php print($datos[$i]['num']); ?>
                                    </td>
                                    <td class="lista" style="text-align: center;">
                                    <?php print($datos[$i]['expediente']); ?>
                                    </td>
                                    <td class="lista">
                                        <?php print(mb_strtoupper($datos[$i]['actor'], 'UTF-8')); ?>
                                    </td>
                                    <td class="lista">
                                        <?php print(mb_strtoupper($datos[$i]['demandado'], 'UTF-8')); ?> 
                                    </td>
                                    <td class="lista">
                                        <?php print(mb_strtoupper($datos[$i]['juicio'], 'UTF-8')); ?> 
                                    </td>
                                    <td class="lista">
                                        <?php print(strtoupper($datos[$i]['fojas'])); ?> 
                                    </td>
                                </tr>
                                <?php } ?>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <BR><BR>
                            <table>
                                <tr>
                                    <td style="width: 70px;">
                                        
                                    </td>
                                    <td style="text-align:center; width: 140px; font-size:10px; " >
                                        ENTREGÓ
                                    </td>
                                    <td style="width: 50px;">
                                       
                                    </td>
                                    <td style="text-align:center; width: 140px; font-size:10px;" >
                                        RECIBIÓ
                                    </td>
                                    <td style="width: 50px;">
                                        
                                    </td>
                                    <td style="text-align:center; width: 140px; font-size:10px;" >
                                        C. DIRECTOR DEL ARCHIVO JUDICIAL
                                    </td>
                                    <td style="width: 70px;">
                                        
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <BR><BR><BR><BR>
                            <table>
                                <tr>
                                    <td style="width:70px;">
                                        
                                    </td>
                                    <td style="text-align:center; width: 140px; border-bottom: 1px; border-bottom-style: outset; border-bottom-color: #000; vertical-align: bottom;" >
                                    </td>
                                    <td style="width: 50px;">
                                        
                                    </td>
                                    <td style="text-align:center; width: 140px; border-bottom: 1px; border-bottom-style: outset; border-bottom-color: #000; vertical-align: bottom;" >
                                    </td>
                                    <td style="width: 50px;">
                                        
                                    </td>
                                    <td style="text-align:center; width: 140px; border-bottom: 1px; border-bottom-style: outset; border-bottom-color: #000; vertical-align: bottom;" >
                                    </td>
                                    <td style="width: 70px;">
                                        
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </body>
        </html>

        <style>
            table.lista {
                border: 1px solid black;
                border-spacing: 0px;
                font-size: 12px;
                height: 70px;
            }

            th.lista{
                border-left: 1px solid black;
                border-bottom: 1px solid black;
            }

            td.lista{
                padding:5px;
                border-left: 1px solid black;
                height: 70px;
            }
        </style>
        <?php
        $html = ob_get_contents();
        ob_end_clean();
 
        
        $id_acuerdo='nuevo';

        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8', 
            'format' => 'Letter'
        ]);

        $arr = array (
            'L' => array (
              'content' => 'SIGJ',
              'font-size' => 10,
              'font-style' => 'B',
              'font-family' => 'serif',
              'color'=>'#000000'
            ),
            'C' => array (
              'content' => '',
              'font-size' => 10,
              'font-style' => 'B',
              'font-family' => 'serif',
              'color'=>'#000000'
            ),
            'R' => array (
              'content' => '{PAGENO}',
              'font-size' => 10,
              'font-style' => 'B',
              'font-family' => 'serif',
              'color'=>'#000000'
            ),
            'line' => 1,
        );

        
        $mpdf->SetFont('Arial','B',14);
        $mpdf->setFooter($arr, 'O');

        $mpdf->WriteHTML($html);
        $mpdf->Output(public_path('temporales').'/sello_boletin_'.$id_acuerdo.'.pdf', \Mpdf\Output\Destination::FILE);

        return public_path('temporales').'/sello_boletin_'.$id_acuerdo.'.pdf';

    }

    
    
}

