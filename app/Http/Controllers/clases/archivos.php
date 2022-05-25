<?php
namespace App\Http\Controllers\clases;

use Illuminate\Http\Request;
use App\Http\Controllers\clases\utilidades;
use DB;
use Session;
use App\Http\Controllers\clases\catalogos;

class archivos{

    public static function obtener_documentos_solicitud(Request $request, $id_solicitud, $version=''){

        if( $version != '' )
            $version = '/'.$version;
        
        $response = $request
        ->clienteWS_penal
        ->request('get', 'consultar_pdf_solicitud/'.$id_solicitud.$version,[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ]
        ]);

        // return $response;

        $response = json_decode($response->getBody(),true);
        
            if(!isset($response['status']) && $version !='todas' && isset($response[0]['url'])){
                
                $explode = explode( '.', $response[0]['url'] );

                $extension = end( $explode );
                $rand = md5(date('YmdHis').rand(0,9999)).'_'.date('H');

                $url_local = $request->entorno['variables_entorno']['ruta_storage'].'pdf_solicitudes/'.$rand.'.'.$extension;
                $url_publica = '/temporales/'.$rand.'.'.$extension;

                $documento_pdf=$response[0]['url'];

                copy($documento_pdf, $url_local);

                link($url_local, base_path().'/public'.$url_publica);

                return [
                    "status"=>100,
                    "response"=> $url_publica,
                    "data" => $response[0]
                ];

            }else{
                return $response;
            }

    }


    public static function obtener_ultima_version_acuerdo(Request $request, $id_acuerdo, $tipo){
        // apartado agregado para que se pueda ver con usuario master.
        $id_unidad=null;
        if(isset($request->id_unidad) && !$request->id_unidad!='-')
            $id_unidad =$request->id_unidad;
        else
            $id_unidad = Session::get('id_unidad_gestion');

        $response = $request
        ->clienteWS_penal
        ->request('get', 'obtener_ultima_version_acuerdo/'.Session::get('usuario_id').'/'.$id_unidad.'/'.$id_acuerdo.'/'.$tipo,[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ]
        ]);
        
                // return 'obtener_ultima_version_acuerdo/'.Session::get('usuario_id').'/'.Session::get('id_unidad_gestion').'/'.$id_acuerdo.'/'.$tipo;
        $response = json_decode($response->getBody(),true);
        // return $response;
        if($response['status']==100){

            $url=$response['response'];

            $expl=explode('.',$url);

            $extension=end($expl);

            $rand = md5(date('YmdHis').rand(0,9999)).'_'.date('H');

            $url_local = $request->entorno['variables_entorno']['ruta_storage'].'acuerdos/'.$rand.'.'.$extension;

            $documento_pdf=$response['response'];

            copy($documento_pdf, $url_local);

            $respuesta=[
                "status"=>100,
                "response"=>"/acuerdos/$rand.$extension",
                "ruta_local"=>$url_local,
                "extension"=>$extension,
            ];

            if($extension=='html' || $extension=='text'){
                $respuesta['contenido']=file_get_contents($url_local);
            }

            return $respuesta;
        }else{
            return $response;
        }

    }

    public static function obtener_pdf_solicitud(Request $request, $id_solicitud, $version=''){

        $response = $request
        ->clienteWS_penal
        ->request('get', 'consultar_pdf_solicitud/'.$id_solicitud.'/'.$version,[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ]
        ]);
        $response = json_decode($response->getBody(),true);


            if(!isset($response['status']) && !$version=='todas'){

                $explode=explode('.',$response[0]['url']);

                $extension=end($explode);


                $url_local = $request->entorno['variables_entorno']['ruta_storage'].'pdf_solicitudes/'.$id_solicitud.'.'.$extension;

                $documento_pdf=$response[0]['url'];

                copy($documento_pdf, $url_local);

                return [
                    "status"=>100,
                    "response"=>"/documento_solicitud/$id_solicitud.$extension",
                ];

            }else{

                return $response;
            }

    }

    public static function obtener_documentos_promocion(Request $request, $id_promocion, $version=''){

        $response = $request
        ->clienteWS_penal
        ->request('get', 'consultar_pdf_promocion/'.$id_promocion.'/'.$version,[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ]
        ]);
        $response = json_decode($response->getBody(),true);


        if(!isset($response['status']) && !$version=='todas'){

            $explode=explode('.',$response[0]['url']);

            $extension=end($explode);

            $rand=base64_encode(rand(0,9999));

            $url_local = $request->entorno['variables_entorno']['ruta_storage'].'pdf_solicitudes/'.$rand.'.'.$extension;

            $documento_pdf=$response[0]['url'];

            copy($documento_pdf, $url_local);

            return [
                "status"=>100,
                "response"=>"/documento_solicitud/$rand.$extension"
            ];

        }else{

            return $response;
        }

    }

    public static function obtener_documentos_remision(Request $request, $id_remision, $version=''){
        
        $response = $request
        ->clienteWS_penal
        ->request('get', 'consultar_documentos_remision/'.$id_remision.'/'.$version,[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
        ]);
        $response = json_decode($response->getBody(),true) ;


        if(!$version==''){

            $explode=explode('.',$response['response']);

            $extension=end($explode);

            $rand=base64_encode(rand(0,9999));

            $url_local = $request->entorno['variables_entorno']['ruta_storage'].'pdf_remisiones/'.$rand.'.'.$extension;

            $documento_pdf=$response['response'];

            copy($documento_pdf, $url_local);

            return [
                "status"=>100,
                "response"=>"/documento_remision/$rand.$extension"
            ];

        }else{

            return $response;
        }

    }

    public static function obtener_archivo_adip( $url, $extension='xml' ){

        $name=base64_encode(date('YmdHis').rand(0,9999));

        $url_local=base_path().'/storage/app/archivos_adip/'.$name.'.'.$extension;

        copy($url, $url_local);

        return "/archivo_adip/$name.$extension";
    }

    public static function genera_doc_exhorto( Request $request,  $datos_exhorto ) {

        $uri_front = $request->entorno['variables_entorno']['uri'];

        $anio_judicial = date('Y');
        
        $datos_leyenda = catalogos::ver_leyenda( $request, $anio_judicial );

        if( $datos_leyenda['status'] == 100 )
            $leyenda = $datos_leyenda['response'][0]['leyenda'];
        else    
            $leyenda = '';

        $id_acuse = $datos_exhorto['id_acuse'];
        $folio = $datos_exhorto['folio'];
        $folio_carpeta_judicial = $datos_exhorto['folio_carpeta_judicial'];
        $unidad_gestion = $datos_exhorto['unidad_gestion'];
        $fecha_asignacion = $datos_exhorto['fecha_asignacion'];
        $exhorto_nombre_juez = $datos_exhorto['exhorto_nombre_juez'];
        $exhorto_juzgado = $datos_exhorto['exhorto_juzgado'];
        $estado = $datos_exhorto['estado'];
        $exhorto_expediente_origen = $datos_exhorto['exhorto_expediente_origen'];
        $exhorto_num_folio = $datos_exhorto['exhorto_num_folio'];
        $rand =  md5(date('YmdHis').rand(0,9999)).'_'.date('H');
        $ruta_publica = '/temporales/'.$rand.".pdf";
        $ruta_local = $request->entorno['variables_entorno']['ruta_storage'].'/temporales/'.$rand.".pdf";
        $mpdf = new \Mpdf\Mpdf();
        
        $html = "
            <table>
                <tbody>
                    <tr>
                    <td style='width:50%; padding-top:10px'>
                        <img src='$uri_front/images/logoTSJCDMX2.png' style='height: 100px;' id='logo_tsj'>
                    </td>
                    <td style='text-align: right; width:50%'>
                        <p style='font-weigth:bold; font-style: italic; font-size: 18px; margin-bottom:0px;'>$leyenda</p>
                        <img src='$uri_front/images/logoDEGJ.png' style='height: 90px; margin-left: auto' id='logo_tsj'>
                    </td>
                    </tr>
                </tbody>
            </table><br><br><br>
            <p>POR INSTRUCCIONES DEL SEÑOR PRESIDENTE DE ESTE TRIBUNAL, POR CORRESPONDER EN TURNO,
            SE REMITE ESTE EXHORTO A:</p><br><br><br>
            <div style='display: flex'>
                <table style='display: block; margin-right: auto; margin-left: auto; text-transform: uppercase; border-collapse: collapse;' border='0'>
                    <tbody style=''>
                    <tr>
                        <td style='background: #F0F0EF; padding: 8px; text-transform: uppercase; border: 1px solid #000'>ID acuse</td>
                        <td style='padding: 8px; text-transform: uppercase; border: 1px solid #000'>$id_acuse</td>
                    </tr>
                    <tr>
                        <td style='background: #F0F0EF; padding: 8px; text-transform: uppercase; border: 1px solid #000'>Folio</td>
                        <td style='padding: 8px; text-transform: uppercase; border: 1px solid #000'>$folio</td>
                    </tr>
                    <tr>
                        <td style='background: #F0F0EF; padding: 8px; text-transform: uppercase; border: 1px solid #000'>Fecha de la asignación</td>
                        <td style='padding: 8px; text-transform: uppercase; border: 1px solid #000'>$fecha_asignacion</td>
                    </tr>
                    <tr>
                        <td style='background: #F0F0EF; padding: 8px; text-transform: uppercase; border: 1px solid #000'>Unidad de Gestión Judicial Asignada</td>
                        <td style='padding: 8px; text-transform: uppercase; border: 1px solid #000'>$unidad_gestion</td>
                    </tr>
                    <tr>
                        <td style='background: #F0F0EF; padding: 8px; text-transform: uppercase; border: 1px solid #000'>Folio de la carpeta judicial</td>
                        <td style='padding: 8px; text-transform: uppercase; border: 1px solid #000'>$folio_carpeta_judicial</td>
                    </tr>
                    <tr>
                        <td style='background: #F0F0EF; padding: 8px; text-transform: uppercase; border: 1px solid #000'>Exhortante</td>
                        <td style='padding: 8px; text-transform: uppercase; border: 1px solid #000'>$exhorto_nombre_juez, $exhorto_juzgado</td>
                    </tr>
                    <tr>
                        <td style='background: #F0F0EF; padding: 8px; text-transform: uppercase; border: 1px solid #000'>Entidad federativa</td>
                        <td style='padding: 8px; text-transform: uppercase; border: 1px solid #000'>$estado</td>
                    </tr>
                    <tr>
                        <td style='background: #F0F0EF; padding: 8px; text-transform: uppercase; border: 1px solid #000'>No. causa</td>
                        <td style='padding: 8px; text-transform: uppercase; border: 1px solid #000'>$exhorto_expediente_origen</td>
                    </tr>
                    <tr>
                        <td style='background: #F0F0EF; padding: 8px; text-transform: uppercase; border: 1px solid #000'>No. de oficio</td>
                        <td style='padding: 8px; text-transform: uppercase; border: 1px solid #000'>$exhorto_num_folio</td>
                    </tr>

                    </tbody>
                </table>
            </div>
            <br><br><br>
            <p>LA DEVOLUCIÓN DEL EXHORTO DEBE HACERSE DIRECTAMENTE AL ÓRGANO JURISDICCIONAL EXHORTANTE</p>
            <p>LA C. JEFA DE LA OFICIALIA DE PARTES DE LA PRESIDENCIA DEL TRIBUNAL SUPERIOR DE JUSTICIA DE LA CIUDAD DE MEXICO</p>
            <p>LIC. DIANA PATRICIA VILLAVICENCIO GALICIA</p>
        ";

        $mpdf->WriteHTML($html);
        $output=$mpdf->Output($ruta_local);
        
        link( $ruta_local, base_path().'/public'.$ruta_publica);
        
        return [ "ruta_publica" => $ruta_publica, "ruta_local" => $ruta_local];
    }
}
