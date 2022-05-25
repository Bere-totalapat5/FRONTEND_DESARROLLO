<?php
namespace App\Http\Controllers\clases;
use App\Http\Controllers\clases\des_cifrado;

class token{

	public static function generar_token_llave( $datos ){

		if( !is_array($datos) ){
			return false;
		}

		//preparacion de cadena token con datos especificos de usuario
		$cadena = "";
		foreach( $datos as $valor ){
			$cadena .= $valor."|";
		}

		//creacion de token con algoritmo de cifrado
		$token = hash("sha512",$cadena);
		return $token;
	}

	public static function generar_token_cadena( $datos ){

		if( !is_array($datos) ){
			return false;
		}

		$json = json_encode($datos);
		$cadena_264 = base64_encode(base64_encode($json));
		$cadena = des_cifrado::cifrado_descifrado( $cadena_264 );

		if( $cadena["status"] == 100 ){
			return $cadena["response"];
		} else {
			return false;
		}

	}

	public static function decodi_token_cadena( $cadena ){

		$cadena264 = des_cifrado::cifrado_descifrado( $cadena, "descifrado" )["response"];
		$json = base64_decode(base64_decode($cadena264));

		return json_decode($json,true);

	}

}