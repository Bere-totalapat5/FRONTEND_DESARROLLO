<?php

namespace App\Http\Controllers\procesosTrabajo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\clases\notificaciones;
use App\Http\Controllers\clases\bandejas;
use App\Http\Controllers\clases\archivos;
use App\Http\Controllers\clases\litigantes;


class control_envioCorreoElectronico extends Controller
{
    public function inicio( Request $request ){
        
        
                   
        $datos['modal_id_acuerdo']="1593311514";
        $datos['id_juicio']="1593198984";
        $datos['modal_notificaicon_url']="http://104.223.47.11/archivos_internos/d7abdde7015c8742541e6c0aff050e04f8d6010514a7137994ad048e286dc1335d8a11aeb836223574f29d1eedec14fb76baca5ecb2ba1b84234f318bb995fad.pdf";


        $cuerpo='<strong>CÉDULA DE NOTIFICACIÓN TSJCDMX</strong><br><br>
        Mediante el presente correo electrónico se le informa que se ordenó realizar la notificación de un asunto tramitado en el Poder Judicial en el que participa <br><br>
        Anexo al correo electrónico encontrara:<br><br>
        -Cédula de Notificación firmada electronicamente<br><br>
        -La dirección electrónica para ingresar al sistema y consultar el contenido del acuerdo  <br><br>
        Sin más por el momento, aprovecho la ocasión para enviarle un cordial saludo. <br><br><br>
        A T E N T A M E N T E. <br><br><br><br>
        El Actuario del Órgano Jurisdiccional';
        $texto_sms='Un Organo Jurisdiccional del PJCDMX determino realizarle una notificacion personal, favor de revisar sus correo para mas informacion';

        //se obtienen a los correos
        $datos_finales= [];
        $lista_archivos=archivos::obtener_archivo($request, $datos['id_juicio']);
//dd($lista_archivos);
        for($i=0; $i<count($lista_archivos['response']['partes']['partes']['actor']); $i++){
            
            if($lista_archivos['response']['partes']['partes']['actor'][$i]['notificacion']=="si"){
                $bandera1=1;
                $bandera0=1;
                if($lista_archivos['response']['partes']['partes']['actor'][$i]['correo']!="" and $lista_archivos['response']['partes']['partes']['actor'][$i]['correo']!="-"){
                    $datos_correo['correo_destinatario']=$lista_archivos['response']['partes']['partes']['actor'][$i]['correo'];
                    $datos_correo_inv['correo_destinatario']=$lista_archivos['response']['partes']['partes']['actor'][$i]['correo'];
                }
                else{
                    $datos_correo['correo_destinatario']="";
                    $datos_correo_inv['correo_destinatario']="";
                    $bandera0=0;
                }
    
                if($lista_archivos['response']['partes']['partes']['actor'][$i]['telefono']!="" and $lista_archivos['response']['partes']['partes']['actor'][$i]['telefono']!="-"){
                    $datos_correo['telefonos']=$lista_archivos['response']['partes']['partes']['actor'][$i]['telefono'];
                    $datos_correo_inv['telefonos']=$lista_archivos['response']['partes']['partes']['actor'][$i]['telefono'];
                }
                else{
                    $datos_correo['telefonos']="";
                    $datos_correo_inv['telefonos']="";
                    $bandera1=0;
                }
                
                $datos_correo['correo_remitente']='sicor@tsjcdmx.gob.mx';
                $datos_correo['nombre_destinatario']=$lista_archivos['response']['partes']['partes']['actor'][$i]['nombre'];
                $datos_correo['nombre_remitente']='TSJCDMX';
                $datos_correo['correo_titulo']='Notificacion electronica: '.$request->session()->get('juzgado_nombre_largo');
                $datos_correo['mensaje_sms']=$texto_sms;
                $datos_correo['correo_cuerpo']=$cuerpo;
                $datos_correo['id_parte']=$lista_archivos['response']['partes']['partes']['actor'][$i]['id'];
                $datos_correo['juzgado']=$request->session()->get('usuario_juzgado');
                $datos_correo['id_acuerdo']=$datos['modal_id_acuerdo'];
                $datos_correo['cc']=[];
                $datos_correo['archivos'][0]['url_public']=$datos['modal_notificaicon_url'];

                if(!isset($lista_archivos['response']['partes']['partes']['actor'][$i]['datos_usuario'][0]['correo']) and $lista_archivos['response']['partes']['partes']['actor'][$i]['notificacion']=="si" ){
                    $cuerpo='<strong>CÉDULA DE NOTIFICACIÓN TSJCDMX</strong><br><br>
                    Dando seguimito a su solicitud ante un Órgano Jurisdiccional del Poder Judicial de la CDMX de recibir notificaciones electrónicas, le informamos que es necesario crear una cuenta en el Sistema Integral de Gestión Judicial<br><br> 
Le hacemos la cordial invitación de ingresar a la siguiente dirección electrónica y registrarse para poder ver el contenido de sus notificaciones <br><br>
Nota: es importante que al momento del registro utilice el mismo correo que proporciono en el Órgano Jurisdiccional<br>';
                    $texto_sms='Un Organo Jurisdiccional del PJCDMX determino realizarle una notificacion personal, favor de revisar sus correo para mas informacion';
                    
                    $datos_correo_inv['correo_remitente']='sicor@tsjcdmx.gob.mx';
                    $datos_correo_inv['nombre_destinatario']=$lista_archivos['response']['partes']['partes']['actor'][$i]['nombre'];
                    $datos_correo_inv['nombre_remitente']='TSJCDMX';
                    $datos_correo_inv['correo_titulo']='Notificacion electronica: '.$request->session()->get('juzgado_nombre_largo');
                    $datos_correo_inv['mensaje_sms']=$texto_sms;
                    $datos_correo_inv['correo_cuerpo']=$cuerpo;
                    $datos_correo_inv['id_parte']=$lista_archivos['response']['partes']['partes']['actor'][$i]['id'];
                    $datos_correo_inv['juzgado']=$request->session()->get('usuario_juzgado');
                    $datos_correo_inv['id_acuerdo']=$datos['modal_id_acuerdo'];
                    $datos_correo_inv['cc']=[];
                    $datos_correo_inv['archivos']=[];
                    //dd($datos_correo_inv);
                    $datos_correo_inv_arr[] = $datos_correo_inv;
                    notificaciones::envio_correos($request, $datos_correo_inv_arr);
                }

                if($bandera0==1){
                    $datos_finales[] = $datos_correo;
                }

                 //se agreega a la notificaicon
                $datos_ligitantes['id_juicio']=$datos['id_juicio'];
                $datos_ligitantes['id_acuerdo']=$datos['modal_id_acuerdo'];
                $datos_ligitantes['id_parte']=$lista_archivos['response']['partes']['partes']['actor'][$i]['id'];
                //dd($datos_ligitantes);
                litigantes::agregar_notificacion_enviada($request, $datos_ligitantes);

            }
        }

        if(isset($lista_archivos['response']['partes']['partes']['demandado'][0]['correo'])){
            for($i=0; $i<count($lista_archivos['response']['partes']['partes']['demandado']); $i++){

                if($lista_archivos['response']['partes']['partes']['demandado'][$i]['notificacion']=="si"){
    
                    $bandera1=1;
                    $bandera0=1;
                    if($lista_archivos['response']['partes']['partes']['demandado'][$i]['correo']!="" and $lista_archivos['response']['partes']['partes']['demandado'][$i]['correo']!="-"){
                        $datos_correo['correo_destinatario']=$lista_archivos['response']['partes']['partes']['demandado'][$i]['correo'];
                        $datos_correo_inv['correo_destinatario']=$lista_archivos['response']['partes']['partes']['demandado'][$i]['correo'];
                    }
                    else{
                        $datos_correo['correo_destinatario']="";
                        $datos_correo_inv['correo_destinatario']="";
                        $bandera0=0;
                    }
        
                    if($lista_archivos['response']['partes']['partes']['demandado'][$i]['telefono']!="" and $lista_archivos['response']['partes']['partes']['demandado'][$i]['telefono']!="-"){
                        $datos_correo['telefonos']=$lista_archivos['response']['partes']['partes']['demandado'][$i]['telefono'];
                        $datos_correo_inv['telefonos']=$lista_archivos['response']['partes']['partes']['demandado'][$i]['telefono'];
                    }
                    else{
                        $datos_correo['telefonos']="";
                        $datos_correo_inv['telefonos']="";
                        $bandera1=0;
                    }
                    
                    $datos_correo['correo_remitente']='sicor@tsjcdmx.gob.mx';
                    $datos_correo['nombre_destinatario']=$lista_archivos['response']['partes']['partes']['demandado'][$i]['nombre'];
                    $datos_correo['nombre_remitente']='TSJCDMX';
                    $datos_correo['correo_titulo']='Notificacion electronica: '.$request->session()->get('juzgado_nombre_largo');
                    $datos_correo['mensaje_sms']=$texto_sms;
                    $datos_correo['correo_cuerpo']=$cuerpo;
                    $datos_correo['id_parte']=$lista_archivos['response']['partes']['partes']['demandado'][$i]['id'];
                    $datos_correo['juzgado']=$request->session()->get('usuario_juzgado');
                    $datos_correo['id_acuerdo']=$datos['modal_id_acuerdo'];
                    $datos_correo['cc']=[];
                    $datos_correo['archivos'][0]['url_public']=$datos['modal_notificaicon_url'];

                    //se envia corre de invitación
                    if(!isset($lista_archivos['response']['partes']['partes']['demandado'][$i]['datos_usuario'][0]['correo']) and $lista_archivos['response']['partes']['partes']['demandado'][$i]['notificacion']=="si" ){
                        
                        $cuerpo='<strong>CÉDULA DE NOTIFICACIÓN TSJCDMX</strong><br><br>
                        Dando seguimito a su solicitud ante un Órgano Jurisdiccional del Poder Judicial de la CDMX de recibir notificaciones electrónicas, le informamos que es necesario crear una cuenta en el Sistema Integral de Gestión Judicial<br><br> 
Le hacemos la cordial invitación de ingresar a la siguiente dirección electrónica y registrarse para poder ver el contenido de sus notificaciones <br><br>
Nota: es importante que al momento del registro utilice el mismo correo que proporciono en el Órgano Jurisdiccional<br>';
                        $texto_sms='Un Organo Jurisdiccional del PJCDMX determino realizarle una notificacion personal, favor de revisar sus correo para mas informacion';
                        
                        $datos_correo_inv['correo_remitente']='sicor@tsjcdmx.gob.mx';
                        $datos_correo_inv['nombre_destinatario']=$lista_archivos['response']['partes']['partes']['demandado'][$i]['nombre'];
                        $datos_correo_inv['nombre_remitente']='TSJCDMX';
                        $datos_correo_inv['correo_titulo']='Notificacion electronica: '.$request->session()->get('juzgado_nombre_largo');
                        $datos_correo_inv['mensaje_sms']=$texto_sms;
                        $datos_correo_inv['correo_cuerpo']=$cuerpo;
                        $datos_correo_inv['id_parte']=$lista_archivos['response']['partes']['partes']['demandado'][$i]['id'];
                        $datos_correo_inv['juzgado']=$request->session()->get('usuario_juzgado');
                        $datos_correo_inv['id_acuerdo']=$datos['modal_id_acuerdo'];
                        $datos_correo_inv['cc']=[];
                        $datos_correo_inv['archivos']=[];
                        //dd($datos_correo_inv);
                        $datos_correo_inv_arr[] = $datos_correo_inv;
                        notificaciones::envio_correos($request, $datos_correo_inv_arr);
                    }

                    if($bandera0==1){
                        $datos_finales[] = $datos_correo;
                    }


                    //se agreega a la notificaicon
                    $datos_ligitantes['id_juicio']=$datos['id_juicio'];
                    $datos_ligitantes['id_acuerdo']=$datos['modal_id_acuerdo'];
                    $datos_ligitantes['id_parte']=$lista_archivos['response']['partes']['partes']['demandado'][$i]['id'];
                    litigantes::agregar_notificacion_enviada($request, $datos_ligitantes);


                }
            }
        }

        if(isset($lista_archivos['response']['partes']['partes']['tercero'][0]['correo'])){
            for($i=0; $i<count($lista_archivos['response']['partes']['partes']['tercero']); $i++){

                if($lista_archivos['response']['partes']['partes']['tercero'][$i]['notificacion']=="si"){

                    $bandera1=1;
                    $bandera0=1;
                    if($lista_archivos['response']['partes']['partes']['tercero'][$i]['correo']!="" and $lista_archivos['response']['partes']['partes']['tercero'][$i]['correo']!="-"){
                        $datos_correo['correo_destinatario']=$lista_archivos['response']['partes']['partes']['tercero'][$i]['correo'];
                    }
                    else{
                        $datos_correo['correo_destinatario']="";
                        $bandera0=0;
                    }
        
                    if($lista_archivos['response']['partes']['partes']['tercero'][$i]['telefono']!="" and $lista_archivos['response']['partes']['partes']['tercero'][$i]['telefono']!="-"){
                        $datos_correo['telefonos']=$lista_archivos['response']['partes']['partes']['tercero'][$i]['telefono'];
                    }
                    else{
                        $datos_correo['telefonos']="";
                        $bandera1=0;
                    }
                    
                    $datos_correo['correo_remitente']='sicor@tsjcdmx.gob.mx';
                    $datos_correo['nombre_destinatario']=$lista_archivos['response']['partes']['partes']['tercero'][$i]['nombre'];
                    $datos_correo['nombre_remitente']='TSJCDMX';
                    $datos_correo['correo_titulo']='Notificacion electronica: '.$request->session()->get('juzgado_nombre_largo');
                    $datos_correo['mensaje_sms']=$texto_sms;
                    $datos_correo['correo_cuerpo']=$cuerpo;
                    $datos_correo['id_parte']=$lista_archivos['response']['partes']['partes']['tercero'][$i]['id'];
                    $datos_correo['juzgado']=$request->session()->get('usuario_juzgado');
                    $datos_correo['id_acuerdo']=$datos['modal_id_acuerdo'];
                    $datos_correo['cc']=[];
                    $datos_correo['archivos'][0]['url_public']=$datos['modal_notificaicon_url'];

                    if($bandera0==1){
                        $datos_finales[] = $datos_correo;
                    }


                    //se agreega a la notificaicon
                    $datos_ligitantes['id_juicio']=$datos['id_juicio'];
                    $datos_ligitantes['id_acuerdo']=$datos['modal_id_acuerdo'];
                    $datos_ligitantes['id_parte']=$lista_archivos['response']['partes']['partes']['tercero'][$i]['id'];
                    litigantes::agregar_notificacion_enviada($request, $datos_ligitantes);

                }
            }
        }
        notificaciones::envio_correos($request, $datos_finales);

    }
    
}