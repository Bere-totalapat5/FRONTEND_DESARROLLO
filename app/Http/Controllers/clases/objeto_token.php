<?php
namespace App\Http\Controllers\clases;

use DB;
use App\Http\Controllers\clases\constantes;

class objeto_token {

    private static $key = "LLAVEMAESTRA";

	public static function obtener_clave_token($datos){

		//preparacion de cadena token con datos especificos de usuario
		$cadena = "";
		foreach( $datos as $valor ){
			$cadena .= $valor."|";
		}

		//creacion de token con algoritmo de cifrado
		$token = hash("sha512",$cadena);
		return $token;
	}

	public static function validar_token($cadena_sesion){

        //descifrado de cadena
        $cadena_sesion = objeto_token::cifrado_descifrado("descifrado",$cadena_sesion);

        if( $cadena_sesion["status"] == 100 ){

            //decodificacion de cadena token de sesion
            $arreglo_sesion = json_decode(base64_decode(base64_decode($cadena_sesion["response"])),true);

            if( $arreglo_sesion !== NULL ){//decodificacion satisfactoria

                //validacion de presencia de campos necesarios en cadena token sesion
                if( !(	isset($arreglo_sesion["usuario"]) &&
                        isset($arreglo_sesion["token"]) &&
                        isset($arreglo_sesion["usuario_name"])
                    ) ){
                    return array("status"=>0,"message"=>"TOKEN OBSOLETO");
                }

                //busqueda de usuario con valores proporcionados en cadena token en SIRCOR-WORD
                $consulta = DB::table("usuarios")
                            ->select("usuario_id")
                            ->where([
                                        ["usuario_id","=",$arreglo_sesion["usuario"]],
                                        ["usuario_llave_sesion","LIKE BINARY",$arreglo_sesion["token"]],
                                        ["usuario_nombre_clave","LIKE BINARY",$arreglo_sesion["usuario_name"]]
                                    ])
                            ->limit(1)
                            ->get();

                if( $consulta->count() === 1 ){//existencia de usuario en SICOR-WORD
                    return array(
                            "status"=>100,
                            "message"=>"TOKEN VALIDO"
                            );
                } else {//inexistencia de usuario SICOR-WORD y inexistencia de juzgado SICOR2
                    return array(
                            "status"=>0,
                            "message"=>"TOKEN DE SESION INVALIDO"
                            );
                }

            } else {//decodificacion corrupta
                return array(
                            "status"=>0,
                            "message"=>"CADENA DE SESION INVALIDA"
                            );
            }
        } else {
            return [ "status"=>0, "message"=>$cadena_sesion["message"] ];
        }
	}

	public static function destruir_token($cadena_sesion){

		$arreglo_sesion = json_decode(base64_decode(base64_decode($cadena_sesion)),true);

		if( $arreglo_sesion !== NULL ){

			$r_transaccion = DB::table("usuarios")
								->where([
									["usuario_id","=",$arreglo_sesion["usuario"]],
									["usuario_llave_sesion","LIKE BINARY",$arreglo_sesion["token"]]
								])
								->update([
										"usuario_llave_sesion"=>"",
										"usuario_fecha_fin_sesion"=>DB::raw("now()")
										]);

			if( $r_transaccion ){

				self::new_log("log_login","SESION FINALIZADA : ".$arreglo_sesion["usuario_name"]." : SUCCESS");
				return array(
						"status"=>100,
						"message"=>"SESION FINALIZADA"
						);
			} else {
				return array(
						"status"=>0,
						"message"=>"TOKEN EXPIRADO"
						);
			}
		} else {
			return array(
						"status"=>0,
						"message"=>"CADENA DE SESION INVALIDA"
						);
		}

	}

	public static function decodificar_token($cadena_sesion, &$request){

        //descifrado de cadena de sesion
        $cadena_sesion = objeto_token::cifrado_descifrado("descifrado",$cadena_sesion);

        if( $cadena_sesion["status"] == 100 ){

            //decodificacion de cadena de sesion
            $arreglo_sesion = json_decode(base64_decode(base64_decode($cadena_sesion["response"])),true);
            //obteniendo valores de sesion y asignando a objeto request
            foreach($arreglo_sesion as $llave=>$valor){
                //token no se asignara en request
                if( $llave == "token" ){ continue; }
                $request->$llave = $valor;
            }

            self::new_log("decod_token",json_encode($arreglo_sesion));

            return [ "status"=>100, "response"=>$arreglo_sesion ];

        } else {
            return [ "status"=>0, "message"=>$cadena_sesion["message"] ];
        }
	}

    public static function cifrado_descifrado( $action='cifrado',$string=false ){

        $action = trim($action);
        $output = false;
        $r_constantes = constantes::cifrados();
        $myKey = "";
        $myIV = "";

        if( $r_constantes["status"] == 100 ){

            $myKey = $r_constantes["response"]["KEY"];
            $myIV = $r_constantes["response"]["IV"];

            $encrypt_method = 'AES-256-CBC';

            $secret_key = hash('sha256',$myKey);
            $secret_iv = substr(hash('sha256',$myIV),0,16);

            if ( $action && ($action == 'cifrado' || $action == 'descifrado') && $string )
            {
                $string = trim(strval($string));

                if ( $action == 'cifrado' )
                {
                    $output = openssl_encrypt($string, $encrypt_method, $secret_key, 0, $secret_iv);
                }

                if ( $action == 'descifrado' )
                {
                    $output = openssl_decrypt($string, $encrypt_method, $secret_key, 0, $secret_iv);
                }
            };

            return [ "status"=>100, "response"=>$output ];

        } else {
            return [ "status"=>0, "message"=>$r_constantes["message"] ];
        }

    }

}

?>