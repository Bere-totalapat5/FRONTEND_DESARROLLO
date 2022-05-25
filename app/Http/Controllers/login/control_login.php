<?php
namespace App\Http\Controllers\login;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\clases\elementos_front;

class control_login extends Controller
{
    public function vista_login( Request $request  ){
        //dd($request['error']);
        $next = $request->next;
    	return view('login.login',["entorno" => $request->entorno, "next"=>$next ]);
    }

	public function action_login(Request $request){ 
        
		$response = $request
                        ->clienteWS_penal
                        ->request('post', 'login',[
                            "form_params" => [
                                "usuario" => $request->usuario,
                                "password" => $request->password,
                                "tipo" => $request->tipo
                            ]
                        ]);
        $responseBody = json_decode($response->getBody(),true) ;

        // return explode("-",$responseBody['response'][0]['tipo_sesion'])[0];
        
        if($responseBody['status']==100 and ($responseBody['response'][0]['tipo_sesion']=="penal_soporte" or explode("-",$responseBody['response'][0]['tipo_sesion'])[0]=="penal_web" or $responseBody['response'][0]['tipo_sesion']=="penal_desarrollo")){
            
           
            $response = $request
                        ->clienteWS_penal
                        ->request('get', 'descifrado',[
                            "form_params" => [
                            ],
                            "headers" => [
                                "sesion-id" => $responseBody['response'][0]['usuario_sesion_id'],
                                "cadena-sesion" => $responseBody['response'][0]['cadena_sesion'],
                                "usuario-id" => $responseBody['response'][0]['usuario_id'],
                                "autorizacion" => 'autorization_penal_luke'
                            ]
                        ]);

            $responseBodySesion = json_decode($response->getBody(),true) ; 

            
            if($responseBodySesion['status']==100){            
                //dd($responseBodySesion); 
                //print($responseBodySesion['response']['juzgado_nombre_largo']); 
                // dd($responseBodySesion['response']);
                Session::put("cadena-sesion",$responseBody['response'][0]['cadena_sesion']);
                Session::put("sesion-id",$responseBody['response'][0]['usuario_sesion_id']);
                Session::put("usuario-id",$responseBody['response'][0]['usuario_id']);
                Session::put("usuario_id",$responseBodySesion['response']['id_usuario']);
                Session::put("id_unidad_gestion",$responseBodySesion['response']['id_unidad_gestion']);
                Session::put("usuario_nombre",$responseBodySesion['response']['usuario_nombre']);
                Session::put("sesion_tipo",$responseBodySesion['response']['sesion_tipo']);
                Session::put("clave_token",$responseBodySesion['response']['clave_token']);
                Session::put("usuario_tipo",$responseBodySesion['response']['usuario_tipo']);
                Session::put("usuario_nombre_completo",$responseBodySesion['response']['usuario_nombre_completo']);
                Session::put("nombre_unidad",$responseBodySesion['response']['nombre_unidad']);
                Session::put("id_inmueble",$responseBodySesion['response']['id_inmueble']);
                Session::put("estatus_reseteo_pass",$responseBodySesion['response']['estatus_reseteo_pass']);
                // Session::put("grupo_trabajo_tipo_area",$responseBodySesion['response']['grupo_trabajo_tipo_area']);
                // Session::put("grupo_trabajo_identificar_area",$responseBodySesion['response']['grupo_trabajo_identificar_area']);
                Session::put("usuario_grupo_trabajo",$responseBodySesion['response']['usuario_grupo_trabajo']);
                Session::put("id_tipo_usuario",$responseBodySesion['response']['id_tipo_usuario']);
                Session::put("tipo_usuario_descripcion",$responseBodySesion['response']['tipo_usuario_descripcion']);
                Session::put("usuario_inicio_sesion",$responseBodySesion['response']['usuario_inicio_sesion']);
                Session::put("sesion_id",$responseBodySesion['response']['sesion_id']);
                Session::put("intf_usuario_sesion_id",$responseBodySesion['response']['intf_usuario_sesion_id']);
                Session::put("intf_usuario_id",$responseBodySesion['response']['intf_usuario_id']);
                Session::put("genero",$responseBodySesion['response']['genero']);
                Session::put("horario_cierre","16:00:00");
                
                if( isset( $responseBodySesion['response']['id_usuario_chia'] ) )
                    Session::put("id_usuario_chia", $responseBodySesion['response']['id_usuario_chia']);

                if( isset($responseBodySesion['response']['sustituyendo_a']['id_usuario']) ) {

                    Session::put("sustituyendo_a_usuario", $responseBodySesion['response']['sustituyendo_a']['usuario']);
                    Session::put("sustituyendo_a_nombre_completo", $responseBodySesion['response']['sustituyendo_a']['nombre_completo']);
                    Session::put("sustituyendo_a_id_usuario", $responseBodySesion['response']['sustituyendo_a']['id_usuario']);
                    Session::put("sustituyendo_a_fecha_inicio", $responseBodySesion['response']['sustituyendo_a']['fecha_inicio']);
                    Session::put("sustituyendo_a_fecha_fin", $responseBodySesion['response']['sustituyendo_a']['fecha_fin']);
                    Session::put("sustituyendo_a_id_tipo_usuario", $responseBodySesion['response']['sustituyendo_a']['id_tipo_usuario']);

                }

                if( isset($responseBodySesion['response']['sustituido_por']['id_usuario']) ) {

                    Session::put("sustituido_por_usuario", $responseBodySesion['response']['sustituido_por']['usuario']);
                    Session::put("sustituido_por_nombre_completo", $responseBodySesion['response']['sustituido_por']['nombre_completo']);
                    Session::put("sustituido_por_id_usuario", $responseBodySesion['response']['sustituido_por']['id_usuario']);
                    Session::put("sustituido_por_fecha_inicio", $responseBodySesion['response']['sustituido_por']['fecha_inicio']);
                    Session::put("sustituido_por_fecha_fin", $responseBodySesion['response']['sustituido_por']['fecha_fin']);
                    Session::put("sustituido_por_id_tipo_usuario", $responseBodySesion['response']['sustituido_por']['id_tipo_usuario']);

                }
                
                // if($responseBodySesion['response']['ministerio_ley']['estatus']=="si"){
                //     Session::put("ministerio_ley_status",$responseBodySesion['response']['ministerio_ley']['estatus']);
                //     Session::put("ministerio_ley_sustituido_por",$responseBodySesion['response']['ministerio_ley']['sustituido_por']);
                //     Session::put("ministerio_ley_sustituye_a",$responseBodySesion['response']['ministerio_ley']['sustituye_a']);
                //     Session::put("ministerio_ley_rol",$responseBodySesion['response']['ministerio_ley']['rol']);
                // }

                //Session::put("horario_cierre",'13:20:00');
                //return response( $responseBodySesion )->withHeaders(["algo" => "algo"]); 

                if($responseBodySesion['response']['tipo_usuario_descripcion']=="oralidad"){
                    return redirect("/oralidad/calendario/");
                }
                if($responseBodySesion['response']['tipo_usuario_descripcion']=="estadistica"){
                    return redirect("/estadistica/");
                }
                else{
                    if($request->next!=""){
                        return redirect($request->next);
                    }
                    else{
                        return redirect("/home");
                    }
                }

            }
            else{

                if(is_array($responseBodySesion['message'])){
                    return back()->with('error', $responseBodySesion['message'][0]);
                }
                return back()->with('error', $responseBodySesion['message']);

                //return back()->with('error', $responseBodySesion['message']);

            }
        }
        else if($responseBody['status']==100 and $responseBody['response'][0]['tipo_sesion']=="plugin"){
            return response( $responseBody )->withHeaders(["algo" => "algo"]);
        }
        else{
            if(is_array($responseBody['message'])){
                return back()->with('error', $responseBody['message'][0]);
            }
            if($responseBody['message']=="el usuario ya dispone con una sesion iniciada"){
                $responseBody['message']="El usuario ya cuenta con una sesión activa,<br>cierre todas las sesiones para poder ingresar";
            }
            return back()->with('error', $responseBody['message']);

            //return back()->withInput(['error' => $responseBody['message'][0]]);

            //return redirect()->route('login.principal', ['error' => $responseBody['message'][0]]);

            //return response( $responseBody );
        }
    }
    
    public function cambiar_reseteo(Request $request){ 
        $response = $request
        ->clienteWS_penal
        ->request('PATCH', 'reseteo_password/'.$request->session()->get("usuario-id"),[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
              "datos"=>[
                "password"=>$request->pws,
                "modo"=>$request->modo
              ]
            ]
        ]);
        return $response = json_decode($response->getBody(),true) ;
    }

    public function statuspws(Request $request){
        try{
            Session::put("estatus_reseteo_pass",1);
            return ["status"=>100, "message"=>"Cambiado"];
        }catch(\Exception $e){
            return ["status"=>0, "message"=>$e->getMessage()];
        }
    }
}