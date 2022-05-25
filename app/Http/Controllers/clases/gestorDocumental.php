<?php
namespace App\Http\Controllers\clases;

use Illuminate\Http\Request;

class gestorDocumental{

    public static function guardarInfoGestor(Request $request, $datos){

        $response = $request
        ->clienteWS
        ->request('POST', 'uploadopv',[
            "json" => [
                "datos" => [
                    "correos"=>$datos
                ]
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id")
            ]
        ]);
        
        $response_menu = json_decode($response->getBody(),true);
        return $response_menu;
    }

    public static function pingGestor($url_simple, $url_simple_port){
        if(!utilidades::pingServer($url_simple, $url_simple_port)){
            return false;
        }
        else{
            return true;
        }
    }

    public static function getDocGestor(Request $request, $idGlobal, $url=''){


        //API URL
        if($request->entorno['variables_entorno']['GESTOR_PRODUCCION']==1){
            $url = $request->entorno['variables_entorno']['GESTOR_URL_PRO'].'api/document?instanceName=TSJ&idGlobal='.$idGlobal;

            $url_simple = $request->entorno['variables_entorno']['GESTOR_URL_PRO_SIMPLE'];
            $url_simple_port = $request->entorno['variables_entorno']['GESTOR_URL_PRO_PORT'];

            $data = array(
                'username' => $request->entorno['variables_entorno']['GESTOR_USER_PRO'],
                'password' => $request->entorno['variables_entorno']['GESTOR_PASS_PRO']
            );
        }
        else{
            $url = $request->entorno['variables_entorno']['GESTOR_URL_DES'].'api/document?instanceName=TSJ&idGlobal='.$idGlobal;

            $url_simple = $request->entorno['variables_entorno']['GESTOR_URL_DES_SIMPLE'];
            $url_simple_port = $request->entorno['variables_entorno']['GESTOR_URL_DES_PORT'];
            
            $data = array(
                'username' => $request->entorno['variables_entorno']['GESTOR_USER_DES'],
                'password' => $request->entorno['variables_entorno']['GESTOR_PASS_DES']
            );
        }

        if(!utilidades::pingServer($url_simple, $url_simple_port)){
            $datos['response']=0;
            $datos['url']=$url;
            $datos['pdf']='<center><br><br><h2>Servicio apagado del gestor documental</h2></center>';
            return $datos;
        }
        
        //create a new cURL resource
        $ch = curl_init($url);

        //setup request to send json via POST
       
        $payload = json_encode(array("user" => $data));

        //attach encoded JSON string to the POST fields
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

        //set the content type to application/json
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

        //return response instead of outputting
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //execute the POST request
        $result = curl_exec($ch);

        //close cURL resource
        curl_close($ch);

        $result_arr=json_decode($result);
        if(isset($result_arr->file64)){

            $b64=$result_arr->file64;
            $bin = base64_decode($b64, true);
            if (strpos($bin, '%PDF') !== 0) {
                
                $datos['response']=0;
                $datos['url']=$url;
                $datos['pdf']='<br><br><h2>EL DOCUMENTO NO ES UN PDF</h2>';
                return $datos;
            }

            $datos['response']=100;
            $datos['url']=$url;
            $datos['pdf']=$bin;
            return $datos;
        }
        else{
            $datos['response']=0;
            $datos['url']=$url;
            $datos['pdf']='<center><br><br><h2>Servicio no disponible del gestor documental</h2></center>';
            return $datos;
        }
    }


    public static function getDocGestorUrl(Request $request, $ulGlobal){


        //API URL
        if($request->entorno['variables_entorno']['GESTOR_PRODUCCION']==1){
            $url = $request->entorno['variables_entorno']['GESTOR_URL_PRO'].'api/document?instanceName=TSJ&idGlobal=';
            $url_simple = $request->entorno['variables_entorno']['GESTOR_URL_PRO_SIMPLE'];
            $url_simple_port = $request->entorno['variables_entorno']['GESTOR_URL_PRO_PORT'];
        }
        else{
            $url = $request->entorno['variables_entorno']['GESTOR_URL_DES'].'api/document?instanceName=TSJ&idGlobal=';
            $url_simple = $request->entorno['variables_entorno']['GESTOR_URL_DES_SIMPLE'];
            $url_simple_port = $request->entorno['variables_entorno']['GESTOR_URL_DES_PORT'];
        }

        if(!utilidades::pingServer($url_simple, $url_simple_port)){
            $datos['response']=0;
            $datos['url']=$url;
            $datos['pdf']='<center><br><br><h2>Servicio apagado del gestor documental</h2></center>';
            return $datos;
        }
        
        //se limpia la URL
        $bin = chunk_split(base64_encode(file_get_contents($ulGlobal)));
        $datos['response']=100;
        $datos['url']=$url;
        $datos['pdf']=$bin;
        return $datos;
    }
}