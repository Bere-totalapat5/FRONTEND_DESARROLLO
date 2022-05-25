<?php

namespace App\Http\Controllers\chia;

use App\Http\Controllers\Controller;
use App\Http\Controllers\clases\catalogos;
use App\Http\Controllers\clases\chia;
use App\Http\Controllers\clases\carpeta_judicial;
use Illuminate\Http\Request;
use Session;
use App;
use PhpOffice\PhpWord\SimpleType\Jc;
use Luecano\NumeroALetras\NumeroALetras;

class ChiaController extends Controller
{
    public function agregar_valores( Request $request ) {
        
        $monedas = catalogos::obtener_catalogo_monedas( $request );
        $valores = catalogos::obtener_catalogo_valores( $request );
        $conceptos = catalogos::obtener_catalogo_conceptos( $request, "1", "-", "30" );
        $instancias = catalogos::obtener_catalogo_instancias( $request );
        $bancos = catalogos::obtener_catalogo_bancos( $request );
        

        $elementos=[
            "entorno"=>$request->entorno,
            "request"=>$request,
            "sesion"=>Session::all(),
            "menu_general"=>$request->menu_general,
            "monedas" => $monedas,
            "valores" => $valores,
            "conceptos" => $conceptos,
            "instancias" => $instancias,
            "bancos" => $bancos,
            "cve_instancia_usuario" => $this->clave_instancia_chia(Session::get('id_unidad_gestion'))
        ];

        return view('chia.agregar_valores', $elementos);
        
    }

    public function valida_valor( Request $request ){

        // $cve_materia = $this->clave_instancia_chia(Session::get('id_unidad_gestion'));
        
        $valor = chia::obtener_valores($request);
        
        return $valor['status'];
    }

    public function registrar_valor_chia( Request $request ) {
        
        $documentosValor = [];
        
        if( isset( $request->documentosValor ) ) {
            foreach( $request->documentosValor as $key => $documento ) {
                $documentosValor[] = [
                    "b64" => base64_encode(file_get_contents($request->entorno['variables_entorno']['ruta_storage'].'app'.$documento['url'])),
                    "extension_archivo" => str_replace('.','',$documento['extension_archivo']),
                    "tamanio_archivo" => ((int)($documento['tamanio_archivo']))/1048576,
                    "nombre_archivo" => str_replace($documento['extension_archivo'],'',$documento['nombre_archivo']),
                ];
                
            }
        }
        
        $datos =  [
            "folio" => mb_strtoupper($request->folio, 'UTF-8'), 
            "tipo_valor" => $request->tipo_valor,
            "instancia" => $this->clave_instancia_chia(Session::get('id_unidad_gestion')),
            "moneda" => $request->moneda,
            "importe" => $request->importe, 
            "depositante" => mb_strtoupper($request->depositante, 'UTF-8'), 
            "expediente" => $request->carpeta_judicial, 
            "id_usuario" => Session::get('usuario-id'), 
            "id_usuario_chia" => Session::get('id_usuario_chia'),
            "banco" => $request->banco, 
            "disposicion" => $request->disposicion,  
            "concepto" => $request->concepto,  
            "fecha_expedicion" => $request->fecha_expedicion, 
            "fecha_exhibicion" => $request->fecha_exhibicion,
            "hora_update" => date('Ymd H:i:s'),
            "beneficiario" => mb_strtoupper($request->beneficiario, 'UTF-8'),
            "institucion" => mb_strtoupper($request->institucion, 'UTF-8'),
            "documentos" => $documentosValor,
        ];

        // return $datos;

        $response = $request
        ->clienteWS_penal
        ->request('post', 'registrar_valor_chia',[
            "headers" => [
                "sesion-id" => Session::get("sesion-id"),
                "cadena-sesion" => Session::get("cadena-sesion"),
                "usuario-id" => Session::get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json" =>[
                "datos" => $datos
            ]
        ]);
        
        return  json_decode($response->getBody(),true) ;

    }

    public function consultar_valores( Request $request ) {

        $monedas = catalogos::obtener_catalogo_monedas( $request );
        $valores = catalogos::obtener_catalogo_valores( $request );
        $conceptos = catalogos::obtener_catalogo_conceptos( $request, "-", "1", "30" );
        $instancias = catalogos::obtener_catalogo_instancias( $request );
        $bancos = catalogos::obtener_catalogo_bancos( $request );
        $estatus = catalogos::obtener_catalogo_estatus( $request );
        $jueces = catalogos::obtener_jueces( $request, Session::get('id_unidad_gestion'), [5]);

        // return $estatus;
        $elementos=[
            "entorno"=>$request->entorno,
            "request"=>$request,
            "sesion"=>Session::all(),
            "menu_general"=>$request->menu_general,
            "monedas" => $monedas,
            "valores" => $valores,
            "conceptos" => $conceptos,
            "instancias" => $instancias,
            "bancos" => $bancos,
            "estatus" => $estatus,
            "cve_instancia_usuario" => $this->clave_instancia_chia(Session::get('id_unidad_gestion')),
            "jueces_control" => $jueces
        ];
        
        return view('chia.consultar_valores', $elementos);
        
    }

    public function obtener_valores_chia( Request $request ) {

        $cve_materia = $this->clave_instancia_chia( Session::get('id_unidad_gestion') );

        if( Session::get('id_unidad_gestion') == 0 )
            $cve_materia = $request->filtro_instancia;
        // return $cve_materia;
        $valores = chia::obtener_valores($request, $cve_materia);

        return $valores;
    }

    public function actualizar_devolucion( Request $request ) {

        $documentosValor = [];
        
        if( isset( $request->documentosValor ) && count( $request->documentosValor ) >= 1 ) {
            foreach( $request->documentosValor as $key => $documento ) {
                $documentosValor[] = [
                    "b64" => base64_encode(file_get_contents($request->entorno['variables_entorno']['ruta_storage'].'app'.$documento['url'])),
                    "extension_archivo" => str_replace('.','',$documento['extension_archivo']),
                    "tamanio_archivo" => ((int)($documento['tamanio_archivo']))/1048576,
                    "nombre_archivo" => str_replace($documento['extension_archivo'],'',$documento['nombre_archivo']),
                ];
            }
        }else{
            return ['status' => 0, 'message' => 'No ha adjuntado ningún documento'];
        }
        
        $datos = [
            "id_valor" => $request->valor,
            "folio" => $request->CveFolio,
            "operacion" => $request->operacion,
            "concepto_devolucion" => $request->concepto_devolucion,
            "fecha_devolucion" => $request->fecha_devolucion,
            "instancia" => $this->clave_instancia_chia(Session::get('id_unidad_gestion')),
            "hora_update" => date('Ymd H:i:s'),
            "documentos" => $documentosValor,
            "compareciente" => $request->compareciente,
            "identificacion" => $request->identificacion,
            "juez" => $request->juez,
        ];
        
        $response = $request
        ->clienteWS_penal
        ->request('patch', 'actualizacion_devolucion',[
            "headers" => [
                "sesion-id" => Session::get("sesion-id"),
                "cadena-sesion" => Session::get("cadena-sesion"),
                "usuario-id" => Session::get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json" =>[
                "datos" => $datos
            ]
        ]);

        $actualizacion = json_decode($response->getBody(),true) ;

        if( $actualizacion['status'] == 1000 ){

            $datos_carpeta_buscar = [
                "modo" => "completo",
                "folio_carpeta" => $request->Expedient,
            ]; 
            
            $carpeta = carpeta_judicial::obtener_carpetas($request, $datos_carpeta_buscar);
           
            $leyenda = catalogos::ver_leyenda( $request, date('Y'));

            // Creacion word
            $phpWord = new \PhpOffice\PhpWord\PhpWord();

            $section = $phpWord->addSection();
            
            // leyenda
            $text = "\t\t\t\t\t".'"'.$leyenda['response'][0]['leyenda'].'"';            
            $section->addText($text, array('italic'=>true, 'size'=>12), array('align'=>'end', 'spaceAfter'=>100));


            $section->addImage(base_path().'/public/images/logoTSJCDMX2.png', 
                array(
                    'width'            => 200, 
                    'height'           => 90, 
                    'marginTop'        => 77,
                    'marginLeft'       => 50,
                    'positioning'      => \PhpOffice\PhpWord\Style\Image::POSITION_RELATIVE,
                    'posHorizontal'    => 'absolute',
                    'posVertical'      => 'absolute',
                    'posHorizontalRel' => \PhpOffice\PhpWord\Style\Image::POSITION_RELATIVE_TO_PAGE,
                    'posVerticalRel'   => \PhpOffice\PhpWord\Style\Image::POSITION_RELATIVE_TO_PAGE,
                    )
                );

            $section->addTextBreak(3);
            $section->addImage(base_path().'/public/images/logoDEGJ.png', 
                array(
                    'width'            => 150, 
                    'height'           => 60, 
                    'marginTop'        => 105,
                    'marginLeft'       => 360,
                    'positioning'      => \PhpOffice\PhpWord\Style\Image::POSITION_RELATIVE,
                    'posHorizontal'    => 'absolute',
                    'posVertical'      => 'absolute',
                    'posHorizontalRel' => \PhpOffice\PhpWord\Style\Image::POSITION_RELATIVE_TO_PAGE,
                    'posVerticalRel'   => \PhpOffice\PhpWord\Style\Image::POSITION_RELATIVE_TO_PAGE,
                )
            );
            

            $html = '<p style="font-size:16px; text-align: right;"><b>Carpeta judicial: </b>'.$request->Expedient.'</p>';

            $imputados = '';
            if( $carpeta['status'] == 100 ) {
                if( count($carpeta['response'][0]['imputados']) > 0 ){

                    $imputados .= $carpeta['response'][0]['imputados'][0]['nombre'];
    
                    if( count($carpeta['response'][0]['imputados']) == 2 )
                        $imputados .= " Y OTRO ";
                    elseif( count($carpeta['response'][0]['imputados']) > 2 )
                        $imputados .= " Y OTROS";
                    
                }
            }
            

            $html .= '<p style="font-size:16px; text-align: right;"><b>Imputado: </b>'.$imputados.'</p>';

            $delitos = '';
            if( $carpeta['status'] == 100 ) {
                if( count($carpeta['response'][0]['delitos']) >0 )
                    $delitos .= $carpeta['response'][0]['delitos'][0]['delito'];
            }

            $html .= '<p style="font-size:16px; text-align: right;"><b>Delito: </b>'.$delitos.'</p>';

            $meses = ['', 'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
            $exp_fecha = explode('-',$request->fecha_devolucion);
            $html .= '<p style="font-size:16px; background:blue">Ciudad de México, <b>'.$exp_fecha[0].' de '.$meses[(int)$exp_fecha[1]].' de '.$exp_fecha[2].'.</b></p>';

            $nombre_usuario = Session::get('usuario_nombre_completo');
            $titulo = Session::get('genero')=='femenino'?'la Licenciada ':'el Licenciado ';
            $cve_materia = $this->clave_instancia_chia(Session::get('id_unidad_gestion'));
            $valores = chia::obtener_valores($request, '', $request->CveFolio);
            $valor = $valores['response'][0];

            $formateador = new \NumberFormatter( 'en_US', \NumberFormatter::DECIMAL );
            $monto_valor = $valores['response'][0]['Amount'];
            $monto = $formateador->format($monto_valor);
            $exp_monto = explode('.', $monto);

            if( isset($exp_monto[1]) )
                $monto_centavos = str_pad($exp_monto[1],  2, "0"); 
            else
                $monto_centavos = "00"; 
            
            $monto_pesos = "$".$exp_monto[0].".".$monto_centavos;
            $formatter = new NumeroALetras();
            $numero_letra = $formatter->toWords(explode(".",$monto_valor)[0]);
            $moneda = $valor['OldKey'] == 'P'?'M.N.':$valor['Amount'];
            $banco = $valor['CveBank']==null?'- - - - - -':catalogos::obtener_catalogo_bancos( $request, $valor['CveBank'] )['response'][0]['Name'];
            
            $html .='<br></br><p style="font-size:16px; text-align: justify; line-height: 1.6; margin-top: 15px">       Comparece en esta '.Session::get("nombre_unidad").' <b>'.$request->compareciente.'</b> en la carpeta judicial citada el rubro quien se identifica con <b>'.$request->identificacion.'</b> la cual cuenta con una fotografía que concuerda con los rasgos fisonómicos del compareciente, manifestando que comparece con el propósito de recoger el billete de depósito <b>'.$request->CveFolio.' </b> que ampara la cantidad de <b>'.$monto_pesos.' ('.$numero_letra.' PESOS '.$monto_centavos.'/100 '.$moneda.')</b> expedido por '.$banco.' el cual fue exhibido como pago '.$valor['MotivoDev'].' tal y como lo autorizó el Juez de Control del Sitema Procesal Penal Acusatorio de la Ciudad de México, <b>'.$request->juez.'</b>, por lo que se hace entrega a <b>'.$request->compareciente.'</b> del citado billete refiriendo el compareciente que lo recibe a su entera satisfacción, firmando por su recibo y para constancia legal, lo anterior par los efectos legales a que haya lugar.</p>';

            $html .='
                <table style="display: table; width: 92%; font-size:16px">
                    <thead>
                        <tr style="">
                            <th style="text-align: center;"><br></br><br></br>RECIBE:</th>
                            <th style="text-align: center;"><br></br><br></br>ENTREGA:</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="">
                            <td style="text-align: center;"><br></br><br></br><br></br><br></br>_________________________</td>
                            <td style="text-align: center;"><br></br><br></br><br></br><br></br>_________________________</td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">'.$request->compareciente.'</td>
                            <td style="text-align: center;">'.Session::get('usuario_nombre_completo').'</td>
                        </tr>
                    </tbody>
                </table>';

            \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html, false, false);

            $rand=md5(date('YmdHis').rand(0,9999));
            $ruta_local = base_path().'/storage/app/formato_devolucion/'.$rand.'.docx';
            $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
            $objWriter->save($ruta_local);
            link($ruta_local, base_path().'/public/temporales/'.$rand.".docx");
            unlink($ruta_local);
            
            $actualizacion['url'] = '/temporales/'.$rand.'.docx';
        }

        return  $actualizacion;

    }

    public function actualizar_valor_chia( Request $request ) {

        $cve_materia = $this->clave_instancia_chia(Session::get('id_unidad_gestion'));

        
        $valores = chia::obtener_valores($request, $cve_materia, $request->CveFolio);

        if( $valores['status'] != 100 )
            return $valores;
        
        $datos =  [
            "id_valor" => $request->valor,
            "folio" => mb_strtoupper($request->CveFolio, 'UTF-8'),
            "tipo_valor" => $request->tipo_valor,
            "instancia" => $this->clave_instancia_chia(Session::get('id_unidad_gestion')),
            "moneda" => $request->moneda,
            "importe" => $request->importe, 
            "depositante" => mb_strtoupper($request->depositante, 'UTF-8'), 
            "expediente" => $request->carpeta_judicial, 
            "id_usuario" => Session::get('usuario-id'), 
            "id_usuario_chia" => Session::get('id_usuario_chia'),
            "banco" => $request->banco, 
            "disposicion" => $request->disposicion,  
            "concepto" => $request->concepto,  
            "fecha_expedicion" => $request->fecha_expedicion, 
            "fecha_exhibicion" => $request->fecha_exhibicion,
            "concepto_devolucion" => $request->concepto_devolucion,
            "fecha_devolucion" => $request->fecha_devolucion,
            "hora_update" => date('Ymd H:i:s'),
            "beneficiario" => mb_strtoupper($request->beneficiario, 'UTF-8'), 
            "institucion" => mb_strtoupper($request->institucion, 'UTF-8'), 
        ];

        // return $datos;

        $response = $request
        ->clienteWS_penal
        ->request('patch', 'actualizar_valor_chia',[
            "headers" => [
                "sesion-id" => Session::get("sesion-id"),
                "cadena-sesion" => Session::get("cadena-sesion"),
                "usuario-id" => Session::get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json" =>[
                "datos" => $datos
            ]
        ]);
        
        return  json_decode($response->getBody(),true) ;

    }

    public function transferir_valor_chia( Request $request ) {
        
        $datos = [
            "id_valor" => $request->valor,
            "folio" => mb_strtoupper($request->CveFolio, 'UTF-8'),
            "instancia" => $this->clave_instancia_chia(Session::get('id_unidad_gestion')),
            "disposicion" => $request->disposicion,  
            "hora_update" => date('Ymd H:i:s'),
            "id_usuario" => Session::get('usuario_id'),
            "origen" => Session::get('nombre_unidad')
        ];

        // return $datos;

        $response = $request
        ->clienteWS_penal
        ->request('patch', 'transferir_valor_chia',[
            "headers" => [
                "sesion-id" => Session::get("sesion-id"),
                "cadena-sesion" => Session::get("cadena-sesion"),
                "usuario-id" => Session::get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json" =>[
                "datos" => $datos
            ]
        ]);
        
        return  json_decode($response->getBody(),true) ;
    }

    public function ver_documento_chia( Request $request ) {

        $response = $request
        ->clienteWS_penal
        ->request('get', 'obtener_documentos_valor/'.$request->valor.'/'.$request->id_documento,[
            "headers" => [
                "sesion-id" => Session::get("sesion-id"),
                "cadena-sesion" => Session::get("cadena-sesion"),
                "usuario-id" => Session::get("usuario-id"),
                "Content-Type" => "application/json"
            ]
        ]);

        $documentos = json_decode($response->getBody(),true) ;

        if( $documentos['status'] == 0 )
            return $documentos;

        if( isset($request->id_documento) ){
            // return $documentos;
            $exp_url = explode(".", $documentos['response'] );
            $ext = end($exp_url);
            $nombre = md5( date("YmdHis").rand(1000,9999 ) )."_".date('H').".".$ext;
            $ruta_local = base_path()."/storage/app/temporales/".$nombre;
            copy(  $documentos['response'], $ruta_local);
            link($ruta_local, base_path().'/public/temporales/'.$nombre);

            if( isset( $request->redirect ) )
                return response()->file($ruta_local);
            else
                return ["status" => 100 , "url" => '/temporales/'.$nombre];

        }else{

            return $documentos;

        }

    }

    public function formato_devolucion( Request $request ) {

        try{

            $datos_carpeta_buscar = [
                "modo" => "completo",
                "folio_carpeta" => $request->Expedient,
            ]; 
            
            $carpeta = carpeta_judicial::obtener_carpetas($request, $datos_carpeta_buscar);
           
            $leyenda = catalogos::ver_leyenda( $request, date('Y'));

            // Creacion word
            $phpWord = new \PhpOffice\PhpWord\PhpWord();

            $section = $phpWord->addSection();
            
            // leyenda
            $text = "\t\t\t\t\t".'"'.$leyenda['response'][0]['leyenda'].'"';            
            $section->addText($text, array('italic'=>true, 'size'=>12), array('align'=>'end', 'spaceAfter'=>100));


            $section->addImage(base_path().'/public/images/logoTSJCDMX2.png', 
                array(
                    'width'            => 200, 
                    'height'           => 90, 
                    'marginTop'        => 77,
                    'marginLeft'       => 50,
                    'positioning'      => \PhpOffice\PhpWord\Style\Image::POSITION_RELATIVE,
                    'posHorizontal'    => 'absolute',
                    'posVertical'      => 'absolute',
                    'posHorizontalRel' => \PhpOffice\PhpWord\Style\Image::POSITION_RELATIVE_TO_PAGE,
                    'posVerticalRel'   => \PhpOffice\PhpWord\Style\Image::POSITION_RELATIVE_TO_PAGE,
                    )
                );

            $section->addTextBreak(3);
            $section->addImage(base_path().'/public/images/logoDEGJ.png', 
                array(
                    'width'            => 150, 
                    'height'           => 60, 
                    'marginTop'        => 105,
                    'marginLeft'       => 360,
                    'positioning'      => \PhpOffice\PhpWord\Style\Image::POSITION_RELATIVE,
                    'posHorizontal'    => 'absolute',
                    'posVertical'      => 'absolute',
                    'posHorizontalRel' => \PhpOffice\PhpWord\Style\Image::POSITION_RELATIVE_TO_PAGE,
                    'posVerticalRel'   => \PhpOffice\PhpWord\Style\Image::POSITION_RELATIVE_TO_PAGE,
                )
            );
            

            $html = '<p style="font-size:16px; text-align: right;"><b>Carpeta judicial: </b>'.$request->Expedient.'</p>';

            $imputados = '';
            if( $carpeta['status'] == 100 ) {
                if( count($carpeta['response'][0]['imputados']) > 0 ){

                    $imputados .= $carpeta['response'][0]['imputados'][0]['nombre'];
    
                    if( count($carpeta['response'][0]['imputados']) == 2 )
                        $imputados .= " Y OTRO ";
                    elseif( count($carpeta['response'][0]['imputados']) > 2 )
                        $imputados .= " Y OTROS";
                    
                }
            }
            

            $html .= '<p style="font-size:16px; text-align: right;"><b>Imputado: </b>'.$imputados.'</p>';

            $delitos = '';
            if( $carpeta['status'] == 100 ) {
                if( count($carpeta['response'][0]['delitos']) >0 )
                    $delitos .= $carpeta['response'][0]['delitos'][0]['delito'];
            }

            $html .= '<p style="font-size:16px; text-align: right;"><b>Delito: </b>'.$delitos.'</p>';

            $meses = ['', 'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
            if( isset($request->fecha_devolucion) )
                $exp_fecha = explode('-',$request->fecha_devolucion);
            else
                $exp_fecha = [0,00,0000];

            $html .= '<p style="font-size:16px; background:blue">Ciudad de México, <b>'.$exp_fecha[0].' de '.$meses[(int)$exp_fecha[1]].' de '.$exp_fecha[2].'.</b></p>';

            $nombre_usuario = Session::get('usuario_nombre_completo');
            $titulo = Session::get('genero')=='femenino'?'la Licenciada ':'el Licenciado ';
            $cve_materia = $this->clave_instancia_chia(Session::get('id_unidad_gestion'));
            $valores = chia::obtener_valores($request, '', $request->CveFolio);
            $valor = $valores['response'][0];

            $formateador = new \NumberFormatter( 'en_US', \NumberFormatter::DECIMAL );
            $monto_valor = $valores['response'][0]['Amount'];
            $monto = $formateador->format($monto_valor);
            $exp_monto = explode('.', $monto);

            if( isset($exp_monto[1]) )
                $monto_centavos = str_pad($exp_monto[1],  2, "0"); 
            else
                $monto_centavos = "00"; 
            
            $monto_pesos = "$".$exp_monto[0].".".$monto_centavos;
            $formatter = new NumeroALetras();
            $numero_letra = $formatter->toWords(explode(".",$monto_valor)[0]);
            $moneda = $valor['OldKey'] == 'P'?'M.N.':$valor['Amount'];
            $banco = $valor['CveBank']==null?'- - - - - -':catalogos::obtener_catalogo_bancos( $request, $valor['CveBank'] )['response'][0]['Name'];
            
            $compareciente = '';
            if( isset($request->compareciente) )
                $compareciente = $request->compareciente;
                
            $html .='<br></br><p style="font-size:16px; text-align: justify; line-height: 1.6; margin-top: 15px">       Comparece en esta '.Session::get("nombre_unidad").' <b>'.$compareciente.'</b> en la carpeta judicial citada el rubro quien se identifica con <b>'.$request->identificacion.'</b> la cual cuenta con una fotografía que concuerda con los rasgos fisonómicos del compareciente, manifestando que comparece con el propósito de recoger el billete de depósito <b>'.$request->CveFolio.' </b> que ampara la cantidad de <b>'.$monto_pesos.' ('.$numero_letra.' PESOS '.$monto_centavos.'/100 '.$moneda.')</b> expedido por '.$banco.' el cual fue exhibido como pago '.$valor['MotivoDev'].' tal y como lo autorizó el Juez de Control del Sitema Procesal Penal Acusatorio de la Ciudad de México, <b>'.$request->juez.'</b>, por lo que se hace entrega a <b>'.$request->compareciente.'</b> del citado billete refiriendo el compareciente que lo recibe a su entera satisfacción, firmando por su recibo y para constancia legal, lo anterior par los efectos legales a que haya lugar.</p>';

            $html .='
                <table style="display: table; width: 92%; font-size:16px">
                    <thead>
                        <tr style="">
                            <th style="text-align: center;"><br></br><br></br>RECIBE:</th>
                            <th style="text-align: center;"><br></br><br></br>ENTREGA:</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="">
                            <td style="text-align: center;"><br></br><br></br><br></br><br></br>_________________________</td>
                            <td style="text-align: center;"><br></br><br></br><br></br><br></br>_________________________</td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">'.$request->compareciente.'</td>
                            <td style="text-align: center;">'.Session::get('usuario_nombre_completo').'</td>
                        </tr>
                    </tbody>
                </table>';

            \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html, false, false);

            $rand = md5( date( 'YmdHis' ).rand( 0,9999 ) ).'_'.date( 'H' );
            $ruta_local = base_path().'/storage/app/formato_devolucion/'.$rand.'.docx';
            $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter( $phpWord, 'Word2007') ;
            $objWriter->save( $ruta_local );
            link( $ruta_local, base_path().'/public/temporales/'.$rand.".docx" );
            unlink( $ruta_local );

            return ["status" => 100, "url" => '/temporales/'.$rand.'.docx'];

        }catch( \Exception $e){

            return ["status" => 0, "message" => "Error en sistema, reporte a sistemas" ];

        }

    }

    private function clave_instancia_chia( $cve_unidad ) {


        
        $cve_materia = [
            0 => 326, //unidad de prueba 1
            12 => 87, //UGJ01	Unidad de Gestión Judicial Primera del Sistema Procesal Penal Acusatorio
            13 => 88, //UGJ02	Unidad de Gestión Judicial Segunda del Sistema Procesal Penal Acusatorio
            14 => 89, //UGJ03	Unidad de Gestión Judicial Tercera del Sistema Procesal Penal Acusatorio
            15 => 90, //UGJ04	Unidad de Gestión Judicial Cuarta del Sistema Procesal Penal Acusatorio
            16 => 91, //UGJ05	Unidad de Gestión Judicial Quinta del Sistema Procesal Penal Acusatorio
            17 => 92, //UGJ06   Unidad de Gestión Judicial Sexta del Sistema Procesal Penal Acusatorio
            18 => 93, //UGJ07	Unidad de Gestión Judicial Séptima del Sistema Procesal Penal Acusatorio
            19 => 94, //UGJ08	Unidad de Gestión Judicial Octava del Sistema Procesal Penal Acusatorio
            32 => 95, //UGJ09	Unidad de Gestión Judicial Novena del Sistema Procesal Penal Acusatorio
            31 => 96, //UGJ10	Unidad de Gestión Judicial Décima del Sistema Procesal Penal Acusatorio
            30 => 97, //UGJ11	Unidad de Gestión Judicial Undécima del Sistema Procesal Penal Acusatorio
            34 => 98, //UGJ12	Unidad de Gestión Judicial Duodécima del Sistema Procesal Penal Acusatorio
            36 => 99, //UGJEMS01	Unidad de Gestión Judicial en Materia de Ejecución de Medidas Sancionadoras
            33 => 100, //UGJJA01	Unidad de Gestión Judicial en Materia de Justicia para Adolescentes
            35 => 294, //UGJEESP	Unidad de Gestión Judicial Especializada en Ejecución de Sanciones Penales Norte
            37 => 295, //UGJEESP	Unidad de Gestión Judicial Especializada en Ejecución de Sanciones Penales Oriente
            20 => 101, //UGJEESP	Unidad de Gestión Judicial Especializada en Ejecución de Sanciones Penales Sullivan
            96 => 102, //UGJTA01	Unidad de Gestión Judicial Para Tribunal de Alzada
        ];

        if( isset( $cve_materia[$cve_unidad] ) )
            return $cve_materia[$cve_unidad];
        else
            return 0;

    }

}
