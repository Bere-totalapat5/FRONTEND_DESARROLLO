<?php
namespace App\Http\Controllers\clases;

use Illuminate\Http\Request;
 
class utilidades{

    public static function buscarCatalogoBandera($catalogo_entorno, $catalogo_id){
        $arr_catalogos=explode(',', $catalogo_entorno);
        if (in_array($catalogo_id, $arr_catalogos)) {
            return true;
        } 
        else{
            return false;
        }
    }

    /*
    *   FECHAS MIN
    */
    public static function acomodarFechaMinHora($fecha){
        $meses_min = array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");

        $arr_hora=explode(" ", $fecha);
        $arr_fecha=explode("-", $arr_hora[0]);

        if(isset($arr_hora[1])){
            $arr_hora_final=explode(':', $arr_hora[1]);
        }
        else{
            $arr_hora_final[]='00';
            $arr_hora_final[]='00';
        }


        $fechaFinal=$arr_fecha[2] . ' ' . $meses_min[$arr_fecha[1]-1] . ', ' . $arr_fecha[0] . '. ' . $arr_hora_final[0].':'.$arr_hora_final[1].' hrs.';
        return $fechaFinal;
    }
    public static function acomodarFechaMin($fecha){
        if($fecha!="0000-00-00" and $fecha!=""){
            $meses_min = array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
            $arr_hora=explode(" ", $fecha);
            
            $arr_fecha=explode("-", $arr_hora[0]);

            $fechaFinal=$arr_fecha[2] . ' ' . $meses_min[$arr_fecha[1]-1] . ' ' . $arr_fecha[0];
            return $fechaFinal;
        }
    } 


    /*
    *   FECHAS COMPLETAS
    */
    public static function acomodarFechaHora($fecha){
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $arr_hora=explode(" ", $fecha);
        if(isset($arr_hora[1])){
            $arr_hora_final=explode(':', $arr_hora[1]);
        }
        else{
            $arr_hora_final[]='00';
            $arr_hora_final[]='00';
        }
        $arr_fecha=explode("-", $arr_hora[0]);

        $fechaFinal=$arr_fecha[2] . ' de ' . $meses[$arr_fecha[1]-1] . ' del ' . $arr_fecha[0] . ', ' . $arr_hora_final[0].':'.$arr_hora_final[1].' hrs.';
        return $fechaFinal;
    }
    public static function acomodarFecha($fecha){
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $arr_hora=explode(" ", $fecha);
        $arr_fecha=explode("-", $arr_hora[0]);

        $fechaFinal=$arr_fecha[2] . ' de ' . $meses[$arr_fecha[1]-1] . ' del ' . $arr_fecha[0] ;
        return $fechaFinal;
    }

    public static function acomodarMes($mes){
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

        $fechaFinal=$meses[$mes];
        return $fechaFinal;
    }


    public static function acomodarTipoExpedienteTxt($tipo_expediente_clave){
        $tipo_expediente = array("expediente"=>"EXPEDIENTE",
            "expedientillo"=>"EXPEDIENTILLO",
            "cuadernillo"=>"CUADERNILLO",
            "incidente"=>"INCIDENTE",
            "terceria"=>"TERCERÍA",
            "exhorto"=>"EXHORTO",
            "amparo"=>"AMPARO",
            "amparo_directo"=>"AMPARO DIRECTO",
            "amparo_indirecto"=>"AMPARO INDIRECTO",
            "toca"=>"TOCA",
            "amparo_exploratorio"=>"AMPARO EXPLORATORIO",
            "cumplimiento"=>"CUMPLIMIENTO",
            "expedientillo_no_corresponde"=>"EXPEDIENTILLO NO CORRESPONDE",
            "recusacion"=>"RECURSACIÓN",
            "denuncia_incumplimiento_1_2019_v_cuad_amparo"=>"DEN. INC. 1/2019 CUAD. AMP.", 
            "denuncia_incumplimiento_1_2019_v_toca"=>"DEN. INC. 1/2019 TOCA",
            "seccion_de_ejecucion"=>"SECCION DE EJECUCION",
            "cuaderno_amparo_tercerista"=>"CUAD. DE APM. TERCERISTA",
            "cuaderno_amparo_act"=>"CUAD. AMP. ACT.",
            "cuaderno_amparo_dem"=>"CUAD. AMP. DEM.",
            "expedientillo_del_cuaderno"=>"EXPEDIENTILLO DEL CUAD. AMP.",
            "sentencia_definitiva"=>"SENT. DEF.",
            "acuerdos_audiencia"=>"ACDOS. AUDIENCIA",
            "OTROS"=>"OTROS"
        );

        $texto=$tipo_expediente[$tipo_expediente_clave];
        return $texto;
    }
 
    /*
    *   PERMISOS DEL MENU
    */
    public static function buscarPermisoMenu($arr_permisos_menu, $clave_juzgado=0, $clave_sala=0){
        foreach($arr_permisos_menu as $menu){
            if($menu['menu_id']==$clave_juzgado){
                return 1; 
            }
            foreach($menu['submenus'] as $submenu){
                if($submenu['menu_id']==$clave_juzgado or $submenu['menu_id']==$clave_sala){
                    return 1;
                }
            }
        }
        return 0;
    }


    public static function obtener_acciones_vista(Request $request,$id_usuario, $id_vista, $accion=''){
        $response = $request
        ->clienteWS_penal
        ->request('get', 'obtener_acciones_vista'."/".$id_usuario."/". $id_vista,[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ]

        ]);
        $acciones = json_decode($response->getBody(),true);

        if($acciones['status']!=100){
            $acciones['response']=[];
        }

        if($accion!=''){
            foreach($acciones['response'] as $accion_vista){
                if($accion_vista['id_vista_accion']==$accion && $accion_vista['valor']==1){
                    return 1;
                }
            }
            return 0;
        }
        
        return $acciones;
    }
    /*
    *   CREACION DE QR
    */
    public static function crearEscanerQR($request, $texto, $nombre_qr){
        
    } 

    /*
    *   CREACION DE CARATULA QR ESCANER
    */
    public static function caraturlaEscanerQR($request, $texto, $nombre_qr, $width, $height){

        \QrCode::format('png')->size(800)->color(0,0,0)->backgroundColor(255,255,255)->encoding('UTF-8')->errorCorrection('L')->generate($texto, storage_path('app/temporales/'.$nombre_qr.'.png'));

        require_once('caratula_qr/fpdf/fpdf.php'); // Incluímos las librerías anteriormente mencionadas
        // Creación del objeto de la clase heredada

        $pdf = new \FPDF('P','mm',array($width,$height));
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Arial','',11);
        $pdf->Image(storage_path('app/temporales/'.$nombre_qr.'.png'),190,10, 10);
        $pdf->Ln(120);
        
        $pdf->Output('F', storage_path('app/temporales/'.$nombre_qr.'.pdf'));
        return storage_path('app/temporales/'.$nombre_qr.'.pdf');

    }

    /*
    *   LOG 
    */
    public static function guardarLog($request, $archivo, $proceso, $estatus=0, $info, $break=1){
        $estatus_txt="";
        if($estatus==0) $estatus_txt="DEBUG - ";
        if($estatus==1) $estatus_txt="INFO  - ";
        if($estatus==2) $estatus_txt="INIC  - ";
        if($estatus==3) $estatus_txt="FIN   - ";
        if($estatus==4) $estatus_txt="ERROR - ";

        $fp = fopen("/san/www/html/sicor_extendido_80/public/log/".$archivo."_".date("Y_m_d").".txt","a");
        $break_txt="\t\n";
        if($break==0) $break_txt="";
        fwrite($fp, date("Y-m-d H:i:s")." [".$proceso."] : ". $estatus_txt." ".$info. $break_txt);
        fclose($fp);
    }

    /*
    *   PING SERVER
    */
    public static function pingServer($host, $port){
        $waitTimeoutInSeconds = 3; 
        try{
            $fp=fsockopen($host,$port,$errCode,$errStr,$waitTimeoutInSeconds);
            fclose($fp);
            return true;
        } catch (\Exception $e) { 
            return false;
        }
    }

   
    /*
    *   BOLETIN
    */
    public static function titleCase($string, $delimiters = array(" "), $exceptions = array("de", "en", "y", "del", "hasta", "entre", "cabe", "la", "lo", "las", "los", "el", "ellos", "XXIX", "XXX" )) {
        /*
        * Exceptions in lower case are words you don't want converted
        * Exceptions all in upper case are any words you don't want converted to title case
        *   but should be converted to upper case, e.g.:
        *   king henry viii or king henry Viii should be King Henry VIII
        */
        $string = mb_convert_case($string, MB_CASE_TITLE, "UTF-8");

        foreach ($delimiters as $dlnr => $delimiter){
            $words = explode($delimiter, $string);
            $newwords = array();
            foreach ($words as $wordnr => $word){

                if (in_array(mb_strtoupper($word, "UTF-8"), $exceptions)){
                    // check exceptions list for any words that should be in upper case
                    $word = mb_strtoupper($word, "UTF-8");
                }
                elseif (in_array(mb_strtolower($word, "UTF-8"), $exceptions)){
                    // check exceptions list for any words that should be in upper case
                    $word = mb_strtolower($word, "UTF-8");
                }

                elseif (!in_array($word, $exceptions) ){
                    // convert to uppercase (non-utf8 only)
                    $word = ucfirst($word);
                }
                array_push($newwords, $word);
            }
            $string = join($delimiter, $newwords);
        }//foreach
        return $string;
    }

    /*
    *
    */
    public static function parseWord($userDoc) {

        $fileHandle = fopen($userDoc, "r");
        $word_text = @fread($fileHandle, filesize($userDoc));
        $line = "";
        $tam = filesize($userDoc);
        $nulos = 0;
        $caracteres = 0;
        for($i=1536; $i<$tam; $i++)
        {
            $line .= $word_text[$i];

            if( $word_text[$i] == 0)
            {
                $nulos++;
            }
            else
            {
                $nulos=0;
                $caracteres++;
            }

            if( $nulos>1996)
            {   
                break;  
            }
        }

        //echo $caracteres;

        $lines = explode(chr(0x0D),$line);
        //$outtext = "<pre>";

        $outtext = "";
        foreach($lines as $thisline)
        {
            $tam = strlen($thisline);
            if( !$tam )
            {
                continue;
            }

            $new_line = ""; 
            for($i=0; $i<$tam; $i++)
            {
                $onechar = $thisline[$i];
                if( $onechar > chr(240) )
                {
                    continue;
                }

                if( $onechar >= chr(0x20) )
                {
                    $caracteres++;
                    $new_line .= $onechar;
                }

                if( $onechar == chr(0x14) )
                {
                    $new_line .= "</a>";
                }

                if( $onechar == chr(0x07) )
                {
                    $new_line .= "\t";
                    if( isset($thisline[$i+1]) )
                    {
                        if( $thisline[$i+1] == chr(0x07) )
                        {
                            $new_line .= "\n";
                        }
                    }
                }
            }
            //troca por hiperlink
            $new_line = str_replace("HYPERLINK" ,"<a href=",$new_line); 
            $new_line = str_replace("\o" ,">",$new_line); 
            $new_line .= "\n";

            //link de imagens
            $new_line = str_replace("INCLUDEPICTURE" ,"<br><img src=",$new_line); 
            $new_line = str_replace("\*" ,"><br>",$new_line); 
            $new_line = str_replace("MERGEFORMATINET" ,"",$new_line); 


            $outtext .= nl2br($new_line);
        }
        return $outtext;
    }

    public static function acomodarCeros($num, $ceros_leng){
        $count=strlen($num);
        $ceros='';
        for($i=$count; $i<$ceros_leng; $i++){
            $ceros.='0';
        }
        return $ceros.$num;
    }

} 