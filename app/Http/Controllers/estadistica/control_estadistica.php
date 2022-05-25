<?php

namespace App\Http\Controllers\estadistica;

use App\Http\Controllers\clases\acuerdos;
use App\Http\Controllers\clases\estadisticas;
use App\Http\Controllers\clases\anales;
use App\Http\Controllers\clases\archivos;
use App\Http\Controllers\clases\promociones;
use App\Http\Controllers\clases\humanRelativeDate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use SimpleSoftwareIO\QrCode; 
  
use setasign\Fpdi\Fpdi;
use App\Http\Controllers\clases\fpdf181\FPDF;

class control_estadistica extends Controller
{
    public function inicio( Request $request, $materia="", $codigo_juicio="", $expedinete="", $anio="", $bis="", $id_juicio=""){

        if($request->session()->get('usuario_id')=='1602685074'){
            
        }
        //se cargan los catálogos de materias
        $lista_materias=anales::obtenerTiposJuzgado($request);

        //dd($materia);
        $lista_submateria=[];
        if($materia!=""){
            $lista_submateria=anales::obtenerJuzgadoTipo($request, $materia);
        }

        $archivo_detalle=[];
        if($codigo_juicio!="" and $materia!="" and $expedinete!=""){

            $id_juicio_local="";
            if($id_juicio!=""){
                $id_juicio_local=$id_juicio;
            }
            unset($datos);
            $datos['id_expediente']=$id_juicio_local;
            $datos['expediente']=$expedinete;
            $datos['expediente_anio']=$anio;
            $datos['involucrados_nombre']="";
            $datos['expediente_bis']=($bis==0) ? "" : $bis;
            $datos['involucrados_apellido_paterno']=""; 
            $datos['involucrados_apellido_materno']="";
            $datos['registrado_desde']="";
            $datos['registrado_hasta']="";
            $archivo_detalle=archivos::obtener_listado_archivos_juzgados_litigante($request, $datos, $codigo_juicio);

        }

        $lista_acuerdos=[];
        if($id_juicio!=""){
            $lista_acuerdos=archivos::expedientes_digitales($request, $id_juicio, $codigo_juicio, 'promocion_acuerdo');
        }

        return view(    "estadistica.estadistica",
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

    public function inicio_caratulas( Request $request, $materia="", $codigo_juicio="" ){

        //se cargan los catálogos de materias
        $lista_materias=anales::obtenerTiposJuzgado($request);

        //dd($materia);
        $lista_submateria=[];
        if($materia!=""){
            $lista_submateria=anales::obtenerJuzgadoTipo($request, $materia);
        }

        $lista['response_pag']['pagina_actual']=0;
        $lista['response_pag']['paginas_totales']=0;
        if($codigo_juicio!=""){

            unset($datos);
            $datos['juzgado']=$codigo_juicio;
            $datos['fecha_menor']='';
            $datos['fecha_mayor']='';
            $datos['fecha_simple']='';
            $datos['sincronizados']='no';
            $datos['expediente']='';
            $datos['expediente_anio']='';
            $datos['id_promocion']='';
            $datos['origen']='EXPEDIENTE EMP';
            $datos['pagina']=1;
            $datos['registros_por_pagina']=20;
            
            $lista=promociones::obtener_caratulas($request, $datos);
        }

        if(isset($lista['status']) and $lista['status']==0){
            $lista['response_pag']['pagina_actual']=0;
            $lista['response_pag']['paginas_totales']=0;
        }

        //se madna a la vista
        return view(    "estadistica.caratula_promociones",
            ["entorno"=>$request->entorno,
            "request"=>$request,
            "sesion"=>$request->session()->all(),
            "menu_general"=>$request->menu_general,
            "lista"=>$lista,
            "lista_materias"=>$lista_materias,
            "lista_submateria"=>$lista_submateria,
            "juzgado_subtipo_id"=>$materia,
            "codigo_juicio"=>$codigo_juicio
            ]
        );
    }
   
    public function generar_caratula( Request $request){

        
        $input = $request->all();
        $proceso = rand(100, 999);
        

        $arr_acuerdo=explode('-*-', $input['arr_acuerdo']);
        for($i=0; $i<count($arr_acuerdo); $i++){

            //dd($arr_acuerdo[$i]);

            if($arr_acuerdo[$i]!=""){
                $arr_datos=explode('_', $arr_acuerdo[$i]);

                

                $texto="PROMOCION";
                if($arr_datos[0]=='acuerdo'){
                    $texto="ACUERDO";
                }
                else if($arr_datos[0]=='promocion'){
                    $texto="PROMOCION";
                }
                else{

                    unset($datos);
                    $datos['expediente']=
                    $datos['expediente_anio']=
                    $datos['expediente_bis']=
                    $datos['registrado_desde']=
                    $datos['registrado_hasta']=
                    $datos['involucrados_nombre']=
                    $datos['involucrados_apellido_paterno']=
                    $datos['involucrados_apellido_materno']='';
                    $datos['id_expediente']=$arr_datos[6];
                    $lista_juzgado=archivos::obtener_listado_archivos_juzgados_litigante($request, $datos, $arr_datos[2]);


                    $texto=strtoupper($lista_juzgado['response'][0]['datos_archivo']['tipo_expediente']);
                }
            
                if(isset($arr_datos[7])){
                    $id_acuerdo=$arr_datos[7];
                }
                else{
                    $id_acuerdo=$arr_datos[6];
                }
                
                $id_juicio=$arr_datos[6];
                $id_organo=$arr_datos[2];
                //$arr_expediente=explode('-', $arr_datos[8]);

                unset($datos);
                $datos['expediente']=
                $datos['expediente_anio']=
                $datos['expediente_bis']=
                $datos['registrado_desde']=
                $datos['registrado_hasta']=
                $datos['involucrados_nombre']=
                $datos['involucrados_apellido_paterno']=
                $datos['involucrados_apellido_materno']='';
                $datos['id_expediente']=$id_juicio;
                $lista_juzgado=archivos::obtener_listado_archivos_juzgados_litigante($request, $datos, $id_organo);

                //dd($lista_juzgado);

                unset($datos);
                if($arr_datos[0]=='acuerdo'){
                    $datos['origen']='ACUERDO EMP'; 
                }
                else if($arr_datos[0]=='promocion'){
                    $datos['origen']='PROMOCION EMP';
                }
                else{
                    $datos['origen']='EXPEDIENTE EMP';
                    //$datos['origen']='PROMOCION EMP';
                }

                $datos['idDocumento']= $id_juicio;
                $datos['bandera_tramite_divorcio']= '0' ;
                $datos['juzgado']= '-' ;
                $datos['idMateria']= '-';
                $datos['noExpediente']=$arr_datos[3];
                $datos['anioExpediente']=$arr_datos[4];
                $datos['fechaRecepcion']= date('Y-m-d') ;
                $datos['tipoJuicio']= '0' ;
                $datos['reg_date']=date('Y-m-d');
                $datos['idExpediente']=$id_juicio;
                $datos['id_juicio']=  $id_juicio;
                $datos['tipoDocumento']= '-' ;
                $datos['idGestor']= '0' ;
                $datos['partes']['actores']=[];
                $datos['partes']['demandados']=[];
                $datos['adjuntos']=[];
                $datos['juzgado_sicor']=$id_organo;
                $datos['opc_promocion_nombreCapturista']='-' ;
                $datos['opc_promocion_emailCapturista']= '-' ;
                $datos['opc_promocion_telefonoCapturista']= '-' ;
                $datos['estatus_traslado']= '-' ;
                $datos['fecha_pago_traslado']= '-' ;
                $datos['num_transaccion_traslado']= '-' ;
                $datos['opc_promocion_bandera_mensaje']= '0' ;
                $datos['opc_promocion_metadata']=  '';
                $lista=promociones::guardar_promocion($request, $datos);


                $materias_arr = array("PIC", "PIF", "JCO", "PC", "JFO", "CJM", "SF", "SC");
                $numero = str_replace($materias_arr, "", $id_organo);
                $metadatos=$lista['response']['id_promocion']."|6|1|1.0|C|C".$numero."|".$arr_datos[3]."|".$arr_datos[4]."|||".date('Y-m-d H:i:s')."|||".$lista_juzgado['response'][0]['datos_archivo']['id_catalogo_juicios']."|".$lista['response']['id_promocion']."|".$arr_acuerdo[$i];


                //se actualiza la promocion
                unset($datos_promocion);
                $datos_promocion['tipoDocumento']='-';
                $datos_promocion['opc_promocion_metadata']=$metadatos;
                $datos_promocion['opc_promocion_nombreCapturista']='-';
                $lista_editar=promociones::editar_promocion_metadatos($request, $lista['response']['id_promocion'], $datos_promocion);

                
                \QrCode::format('png')->size(800)->color(0,0,0)->backgroundColor(255,255,255)->encoding('UTF-8')->errorCorrection('L')->generate($metadatos, storage_path('app/temporales/'.$id_acuerdo.'.png'));

                
                 
                ob_start();
                ?>
                <!DOCTYPE html>
                <html>
                    <head>
                        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
                    </head>
                    <body style="font-size: 15px; ">
                        <img src="https://sigj.poderjudicialcdmx.gob.mx/images/LOGO_PJ_vextendida_color.png" style="width: 200px;">
                        <br><br>
                        <div style="text-align:center;">
                        <img src="<?php print(storage_path('app/temporales/'.$id_acuerdo.'.png')); ?>" width="50px;" style="width: 200px; text-align:center;">
                        </div>
                        <br><br>
                        <div style="text-align:center; font-size: 20px;"><?php print($texto); ?></div>
                        <div style="text-align:center; font-size: 20px;">JUZGADO: <?php print($input['juzgado']); ?></div>

                        <?php if($texto=="ACUERDO"){ ?>
                            <div style="text-align:center; font-size: 20px;">ACUERDO: <?php print($arr_datos[8]); ?></div>
                            <div style="text-align:center; font-size: 20px;">FECHA DE PUBLICACION: <?php $arr=explode(" ", $arr_datos[9]); print($arr[0]); ?></div>
                        <?php 
                        }
                        else if($texto=="PROMOCION"){

                        }
                        else{ ?>
                            <div style="text-align:center; font-size: 20px;"><?php 
                            print($arr_datos[3].'/'.$arr_datos[4]);
                            if($lista_juzgado['response'][0]['datos_archivo']['bis']!=""){
                                print(' Bis. '.$lista_juzgado['response'][0]['datos_archivo']['bis']);
                            }

                            if($lista_juzgado['response'][0]['datos_archivo']['cuaderno']!=""){
                                print(' Cuaderno. '.$lista_juzgado['response'][0]['datos_archivo']['cuaderno']);
                            }

                            if($lista_juzgado['response'][0]['datos_archivo']['alias']!=""){
                                print(' Alias. '.$lista_juzgado['response'][0]['datos_archivo']['alias']);
                            }
                            
                            ?></div> 
                        <?php } ?>

                        <div style="text-align:center; font-size: 10px;"><?php print($arr_acuerdo[$i]); ?></div>
                        <br>
                        <div style="text-align:center; font-size: 12px;">ID: <?php print($lista['response']['id_promocion']); ?></div>
                        <br><br>
                        <div style="text-align:center; font-size: 15px;">* La presente hoja NO forma parte del expediente;<br>fue generada con motivo del proceso interno de digitalización.</div>
                    </body>
                </html>

                <?php

                $html = ob_get_contents();
                ob_end_clean();
        
                $mpdf = new \Mpdf\Mpdf([
                    'mode' => 'utf-8', 
                    //'format' => 'A4'
                    'format' => 'Legal'
                ]);
                $mpdf->WriteHTML($html);
                $mpdf->Output('/san/www/html/sicor_extendido_80/public/temporales/numero_'.$proceso.'_'.$i.'_'.$texto.'_'.$id_acuerdo.'.pdf', \Mpdf\Output\Destination::FILE);


            }
        }
        
        $url_unidos="/san/www/html/sicor_extendido_80/public/temporales/caratulas_".$proceso.".pdf";
        $shell_cat="pdftk /san/www/html/sicor_extendido_80/public/temporales/numero_".$proceso."_* cat output $url_unidos";
        //print($shell_cat.'<br>');
        $output = shell_exec($shell_cat);


        //$qrGenerado = $oQR -> generaImagenQR($input['id_promocion'],$input['metadatos']);
        
        $file = $url_unidos;
        $filename = "caratulas_".$proceso.".pdf";
        header('Content-type: application/pdf');
        header('Content-Disposition: inline; filename="' . $filename . '"');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . filesize($file));
        header('Accept-Ranges: bytes');
        @readfile($file);

        exit;

    }

    public function cargar_caratulas_pdf( Request $request ){
        $input = $request->all();
        $proceso = rand(100, 999);

        if(isset($input['metadatos']) and isset($input['id_promocion'])){


            
            \QrCode::format('png')->size(1200)->color(0,0,0)->backgroundColor(255,255,255)->encoding('UTF-8')->errorCorrection('L')->generate($input['metadatos'], storage_path('app/temporales/'.$input['id_promocion'].'.png'));

            $arr_datos_metadatos=explode('|', $input['metadatos']);
            $arr_datos=explode('_', $arr_datos_metadatos[15]);

            unset($datos);
            $datos['expediente']=
            $datos['expediente_anio']=
            $datos['expediente_bis']=
            $datos['registrado_desde']=
            $datos['registrado_hasta']=
            $datos['involucrados_nombre']=
            $datos['involucrados_apellido_paterno']=
            $datos['involucrados_apellido_materno']='';
            $datos['id_expediente']=$arr_datos[6];
            $lista_juzgado=archivos::obtener_listado_archivos_juzgados_litigante($request, $datos, $arr_datos[2]);

           // dd($lista_juzgado);

            $texto="PROMOCION";
            if($arr_datos[0]=='acuerdo'){
                $texto="ACUERDO";
            }
            else if($arr_datos[0]=='promocion'){
                $texto="PROMOCION";
            }
            else{
                $texto=strtoupper($lista_juzgado['response'][0]['datos_archivo']['tipo_expediente']);
            }
            
            $lista_juzgado_nombre = anales::obtenerJuzgadoTipo($request, 'PIC');
            $nombre_juzgado = "";
            for($i=0; $i<count($lista_juzgado_nombre['response']); $i++){
                if($lista_juzgado_nombre['response'][$i]['codigo']==$arr_datos[2]){
                    $nombre_juzgado=$lista_juzgado_nombre['response'][$i]['nombre'];
                }
            }

            ob_start();
            ?>
            <!DOCTYPE html>
            <html>
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
                </head>
                <body style="font-size: 15px; ">
                    <img src="https://sigj.poderjudicialcdmx.gob.mx/images/LOGO_PJ_vextendida_color.png" style="width: 200px;">
                    <br><br>
                    <!--
                    <br><br>
                    -->
                    <div style="text-align:center;">
                    <img src="<?php print(storage_path('app/temporales/'.$input['id_promocion'].'.png')); ?>" width="150px;" style="width: 280px; text-align:center;">
                    </div>
                    <br><br>
                    <div style="text-align:center; font-size: 20px;"><?php print($texto); ?></div>
                    <div style="text-align:center; font-size: 20px;">JUZGADO: <?php print($arr_datos[2]); ?></div>

                    <?php if($texto=="ACUERDO"){ ?>
                        <div style="text-align:center; font-size: 20px;">ACUERDO: <?php print($arr_datos[8]); ?></div>
                        <div style="text-align:center; font-size: 20px;">FECHA DE PUBLICACION: <?php $arr=explode(" ", $arr_datos[9]); print($arr[0]); ?></div>
                    <?php 
                    }
                    else if($texto=="PROMOCION"){

                    }
                    else{ ?>
                        <div style="text-align:center; font-size: 20px;"><?php 
                        print($arr_datos[3].'/'.$arr_datos[4]);
                        if($lista_juzgado['response'][0]['datos_archivo']['bis']!=""){
                            print(' Bis. '.$lista_juzgado['response'][0]['datos_archivo']['bis']);
                        }

                        if($lista_juzgado['response'][0]['datos_archivo']['cuaderno']!=""){
                            print(' Cuaderno. '.$lista_juzgado['response'][0]['datos_archivo']['cuaderno']);
                        }

                        if($lista_juzgado['response'][0]['datos_archivo']['alias']!=""){
                            print(' Alias. '.$lista_juzgado['response'][0]['datos_archivo']['alias']);
                        }
                        
                        ?></div> 
                    <?php } ?>

                    <div style="text-align:center; font-size: 10px;"><?php print($arr_datos_metadatos[15]); ?></div>
                    <br>
                    <div style="text-align:center; font-size: 12px;">ID: <?php print($input['id_promocion']); ?></div>
                    <br><br>
                        <div style="text-align:center; font-size: 15px;">* La presente hoja NO forma parte del expediente;<br>fue generada con motivo del proceso interno de digitalización.</div>

                </body>
            </html>

            <?php

            $html = ob_get_contents();
            ob_end_clean();
    
            $mpdf = new \Mpdf\Mpdf([
                'mode' => 'utf-8', 
                //'format' => 'letter'
                'format' => 'Legal'
            ]);
            $mpdf->WriteHTML($html);
            $mpdf->Output('/san/www/html/sicor_extendido_80/public/temporales/numero_'.$proceso.'_'.$texto.'_'.$arr_datos[6].'.pdf', \Mpdf\Output\Destination::INLINE);

            

        }
        else{
            print('<center><br><br><br><h1>ERROR AL GENERAR LA CARÁTULA.</h1></center>');
            exit;
        }

    }

    public function generar_caratula_xml( Request $request){

        
        $input = $request->all();
        $proceso = rand(100, 999);
        

        $arr_acuerdo=explode('-*-', $input['arr_acuerdo']);
        for($i=0; $i<count($arr_acuerdo); $i++){

            //dd($arr_acuerdo[$i]);

            if($arr_acuerdo[$i]!=""){
                $arr_datos=explode('_', $arr_acuerdo[$i]);

                

                $texto="PROMOCION";
                if($arr_datos[0]=='acuerdo'){
                    $texto="ACUERDO";
                }
                else if($arr_datos[0]=='promocion'){
                    $texto="PROMOCION";
                }
                else{

                    unset($datos);
                    $datos['expediente']=
                    $datos['expediente_anio']=
                    $datos['expediente_bis']=
                    $datos['registrado_desde']=
                    $datos['registrado_hasta']=
                    $datos['involucrados_nombre']=
                    $datos['involucrados_apellido_paterno']=
                    $datos['involucrados_apellido_materno']='';
                    $datos['id_expediente']=$arr_datos[6];
                    $lista_juzgado=archivos::obtener_listado_archivos_juzgados_litigante($request, $datos, $arr_datos[2]);


                    $texto=strtoupper($lista_juzgado['response'][0]['datos_archivo']['tipo_expediente']);
                }
            
                if(isset($arr_datos[7])){
                    $id_acuerdo=$arr_datos[7];
                }
                else{
                    $id_acuerdo=$arr_datos[6];
                }
                
                $id_juicio=$arr_datos[6];
                $id_organo=$arr_datos[2];
                //$arr_expediente=explode('-', $arr_datos[8]);

                unset($datos);
                $datos['expediente']=
                $datos['expediente_anio']=
                $datos['expediente_bis']=
                $datos['registrado_desde']=
                $datos['registrado_hasta']=
                $datos['involucrados_nombre']=
                $datos['involucrados_apellido_paterno']=
                $datos['involucrados_apellido_materno']='';
                $datos['id_expediente']=$id_juicio;
                $lista_juzgado=archivos::obtener_listado_archivos_juzgados_litigante($request, $datos, $id_organo);

                //dd($lista_juzgado);

                unset($datos);
                if($arr_datos[0]=='acuerdo'){
                    $datos['origen']='ACUERDO EMP'; 
                }
                else if($arr_datos[0]=='promocion'){
                    $datos['origen']='PROMOCION EMP';
                }
                else{
                    $datos['origen']='EXPEDIENTE EMP';
                    //$datos['origen']='PROMOCION EMP';
                }

                $datos['idDocumento']= $id_juicio;
                $datos['bandera_tramite_divorcio']= '0' ;
                $datos['juzgado']= '-' ;
                $datos['idMateria']= '-';
                $datos['noExpediente']=$arr_datos[3];
                $datos['anioExpediente']=$arr_datos[4];
                $datos['fechaRecepcion']= date('Y-m-d') ;
                $datos['tipoJuicio']= '0' ;
                $datos['reg_date']=date('Y-m-d');
                $datos['idExpediente']=$id_juicio;
                $datos['id_juicio']=  $id_juicio;
                $datos['tipoDocumento']= '-' ;
                $datos['idGestor']= '0' ;
                $datos['partes']['actores']=[];
                $datos['partes']['demandados']=[];
                $datos['adjuntos']=[];
                $datos['juzgado_sicor']=$id_organo;
                $datos['opc_promocion_nombreCapturista']='-' ;
                $datos['opc_promocion_emailCapturista']= '-' ;
                $datos['opc_promocion_telefonoCapturista']= '-' ;
                $datos['estatus_traslado']= '-' ;
                $datos['fecha_pago_traslado']= '-' ;
                $datos['num_transaccion_traslado']= '-' ;
                $datos['opc_promocion_bandera_mensaje']= '0' ;
                $datos['opc_promocion_metadata']=  '';
                $lista=promociones::guardar_promocion($request, $datos);


                $materias_arr = array("PIC", "PIF", "JCO", "PC", "JFO", "CJM", "SF", "SC");
                $numero = str_replace($materias_arr, "", $id_organo);
                $metadatos=$lista['response']['id_promocion']."|6|1|1.0|C|C".$numero."|".$arr_datos[3]."|".$arr_datos[4]."|||".date('Y-m-d H:i:s')."|||".$lista_juzgado['response'][0]['datos_archivo']['id_catalogo_juicios']."|".$lista['response']['id_promocion']."|".$arr_acuerdo[$i];


                //se actualiza la promocion
                unset($datos_promocion);
                $datos_promocion['tipoDocumento']='-';
                $datos_promocion['opc_promocion_metadata']=$metadatos;
                $datos_promocion['opc_promocion_nombreCapturista']='-';
                $lista_editar=promociones::editar_promocion_metadatos($request, $lista['response']['id_promocion'], $datos_promocion);

                $nombre=$lista['response']['id_promocion'].'_'.$id_organo.'_'.$arr_datos[3].'_'.$arr_datos[4];
                header("Content-Type: text/plain");
                header('Content-Disposition: attachment; filename="'.$nombre.'.xml"');
                echo '<?xml version="1.0" encoding="utf-8"?><doc><page><item name="Barcode 1 string" value="'.$metadatos.'"/></page></doc>';
                exit;
                
            }
        }
        
        $url_unidos="/san/www/html/sicor_extendido_80/public/temporales/caratulas_".$proceso.".pdf";
        $shell_cat="pdftk /san/www/html/sicor_extendido_80/public/temporales/numero_".$proceso."_* cat output $url_unidos";
        //print($shell_cat.'<br>');
        $output = shell_exec($shell_cat);


        //$qrGenerado = $oQR -> generaImagenQR($input['id_promocion'],$input['metadatos']);
        
        $file = $url_unidos;
        $filename = "caratulas_".$proceso.".pdf";
        header('Content-type: application/pdf');
        header('Content-Disposition: inline; filename="' . $filename . '"');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . filesize($file));
        header('Accept-Ranges: bytes');
        @readfile($file);

        exit;

    }

    public function cargar_caratulas_xml( Request $request ){
        $input = $request->all();
        $proceso = rand(100, 999);

        if(isset($input['metadatos']) and isset($input['id_promocion'])){

            header("Content-Type: text/plain");
            header('Content-Disposition: attachment; filename="'.$input['nombre'].'.xml"');
            echo '<?xml version="1.0" encoding="utf-8"?><doc><page><item name="Barcode 1 string" value="'.$input['metadatos'].'"/></page></doc>';
            exit;

        }
        else{
            print('<center><br><br><br><h1>ERROR AL GENERAR LA CARÁTULA.</h1></center>');
            exit;
        }

    }

    public function buscar_caratula( Request $request ){

        $input = $request->all();


        //tipo documento
        $datos['tipo_documento']='-';
        if(isset($input['tipo_documento'])){
            $datos['tipo_documento']=$input['tipo_documento'];
        }

        $datos['fecha_menor']='';
        $datos['fecha_mayor']='';
        $datos['fecha_simple']='';
        $datos['id_promocion']='';
        $datos['expediente']='';
        $datos['expediente_anio']='';
        $datos['origen']='EXPEDIENTE EMP';

        if($input['fecha']!=""){
            $datos['fecha_simple']=$input['fecha'];
        }


        if($input['origen']!=""){
            $datos['origen']=$input['origen'];
        }

        if($input['expediente']!=""){
            $datos['expediente']=$input['expediente'];
        }
        if($input['expediente_anio']!=""){
            $datos['expediente_anio']=$input['expediente_anio'];
        }
        if($input['id_promocion']!=""){
            $datos['id_promocion']=$input['id_promocion'];
        }

        $datos['sincronizados']='';
        if($input['tipo']=='n'){
            $datos['sincronizados']='no';
        }
        else if($input['tipo']=='c'){
            $datos['sincronizados']='si';
        }

        $datos['juzgado']=$input['codigo_juicio'];


        ($input['pagina']=="-") ? $datos['pagina']="1" : $datos['pagina']=$input['pagina'];
        ($input['registros_por_pagina']=="-") ? $datos['registros_por_pagina']=20 : $datos['registros_por_pagina']=$input['registros_por_pagina'];

        
        //se buscan las promciones
        $lista=promociones::obtener_caratulas($request, $datos);

        $humanRelativeDate = new humanRelativeDate();
        if(isset($lista['response'][0]['opc_promocion_fecha_registro'])){
            //se pone el catalogo
            for($i=0; $i<count($lista['response']); $i++){

                //se ajusta la fecha
                $fecha_arr=explode(' ', $lista['response'][$i]['opc_promocion_fecha_registro']);
                $fechaHumana=$humanRelativeDate->getTextForSQLDate($fecha_arr[0]);
                $lista['response'][$i]['fecha_humana']=$fechaHumana;
                $lista['response'][$i]['fecha_1']=$fecha_arr[0];
                $lista['response'][$i]['fecha_2']=$fecha_arr[1];

                if(isset($lista['response'][$i]['adjuntos'])){
                    for($j=0; $j<count($lista['response'][$i]['adjuntos']); $j++){
                        if($lista['response'][$i]['adjuntos'][$j]['json_archivo']!=""){
                            $lista['response'][$i]['adjuntos'][$j]['json_arr']=json_decode($lista['response'][$i]['adjuntos'][$j]['json_archivo']);
                        }
                    }
                }
            }
        }
        return response()->json($lista);
    }

}