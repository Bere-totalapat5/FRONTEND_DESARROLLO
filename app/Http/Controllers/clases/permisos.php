<?php
namespace App\Http\Controllers\clases;
use DB;

class permisos{

    public static function obtener_permisos( $usuario_id ){

        $resultado = DB::connection("oracle")
                        ->table("sys_users")
                        ->join("usuario_permisos","usuario_permisos.id_usuario","=","sys_users.user_id")
                        ->join("permisos_ferias","permisos_ferias.id_permiso","=","usuario_permisos.id_permiso_feria")
                        ->where([
                            ["permisos_ferias.permiso_feria_status","=",1],
                            ["sys_users.user_contact_status","=",1],
                            ["sys_users.user_id","=",$usuario_id]
                        ])
                        ->orderBy("sys_users.user_id","asc")
                        ->orderBy("usuario_permisos.id_permiso_feria","asc")
                        ->get();

        $response = [];
        foreach( $resultado as $permiso ){
            $response[$permiso->id_permiso_feria] = $permiso->usuario_permiso_activo;
        }

        return $response;

    }

}