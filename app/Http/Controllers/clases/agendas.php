<?php
namespace App\Http\Controllers\clases;

use Illuminate\Http\Request;
 
class agendas{

    public static function obtener_evento_agendas(Request $request, $ponencia, $agenda_id, $organo=0, $id_acuerdo=0){
       
        //dd('obtenerEventos/'.$agenda_id.'/'.$ponencia);
        //se obtiene la lista de archivos
        $response = $request
        ->clienteWS
        ->request('get', 'obtenerEventos/'.$agenda_id.'/'.$ponencia.'/'.$organo.'/'.$id_acuerdo,[
            "query" => [
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ]
        ]);
        $lista_archivos = json_decode($response->getBody(),true) ;
        //dd($lista_archivos);
        return $lista_archivos;
    }

    public static function guardar_evento_agenda(Request $request, $datos){

        //dd($datos);
        //se obtiene la lista de archivos
        $response = $request
        ->clienteWS
        ->request('POST', 'crearEvento',[
            "json" => [
                "datos" => [
                    "nombre_evento" =>$datos['nombre_evento'],
                    "descripcion_evento" => $datos['descripcion_evento'],
                    "fecha_evento" => $datos['fecha_evento'],
                    "hora_inicio" => $datos['hora_inicio'],
                    "hora_final" => $datos['hora_final'],
                    "liga_evento"=> $datos['liga_evento'],
                    "ponencia_evento"=> $datos['ponencia_evento'],
                    "recordatorio_correo"=> $datos['recordatorio_correo'],
                    "recordatorio_sms"=> $datos['recordatorio_sms'],
                    "intervalo_min"=> $datos['intervalo_min'],
                    "id_acuerdo"=> $datos['id_acuerdo']
                ]
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                 "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ]
        ]);
        
        $lista = json_decode($response->getBody(),true) ;
        //dd($lista);

        return $lista;
    }
 
    public static function editar_evento_agenda(Request $request, $id, $datos){

        //dd($datos);
        //se obtiene la lista de archivos
        $response = $request
        ->clienteWS
        ->request('PUT', 'modificarEvento/'.$id,[
            "json" => [
                "datos" => [
                    "nombre_evento" =>$datos['nombre_evento'],
                    "descripcion_evento" => $datos['descripcion_evento'],
                    "fecha_evento" => $datos['fecha_evento'],
                    "hora_inicio" => $datos['hora_inicio'],
                    "hora_final" => $datos['hora_final'],
                    "liga_evento"=> $datos['liga_evento'],
                    "ponencia_evento"=> $datos['ponencia_evento'],
                    "recordatorio_correo"=> $datos['recordatorio_correo'],
                    "recordatorio_sms"=> $datos['recordatorio_sms'],
                    "intervalo_min"=> $datos['intervalo_min'],
                    "estatus_eliminacion" => $datos['estatus_eliminacion'],
                    "id_acuerdo" => $datos['id_acuerdo']
                ]
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                 "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ]
        ]);
        
        $lista = json_decode($response->getBody(),true) ;
        //dd($lista);
        return $lista;
    }

    public static function cancelar_evento(Request $request, $id_acuerdo, $codigo_organo){

        //dd($datos);
        //se obtiene la lista de archivos
        $response = $request
        ->clienteWS
        ->request('PUT', 'cancelar_evento/'.$id_acuerdo.'/'.$codigo_organo,[
            "json" => [
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                 "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ]
        ]);
        
        $lista = json_decode($response->getBody(),true) ;
        //dd($lista);
        return $lista;
    }

    public static function obtener_tiempo_disponible(Request $request){
       
        //dd('obtenerEventos/'.$agenda_id.'/'.$ponencia);
        //se obtiene la lista de archivos
        $response = $request
        ->clienteWS
        ->request("GET", "obtener_tiempo_disponible/",[
            "query" => [
                "datos" => [
                    "fecha" => "-",
                    "ponencia" => "-"
                ]
            ], ['exceptions' => true],
            "headers" => [ 
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ]
        ]);

        

        $lista_archivos = json_decode($response->getBody(),true) ;
        //dd($lista_archivos);
        return $lista_archivos;
    }

    public static function verificar_tiempo_disponible(Request $request, $fecha, $hora){
       
        //dd('obtenerEventos/'.$agenda_id.'/'.$ponencia);
        //se obtiene la lista de archivos
        $response = $request
        ->clienteWS
        ->request("GET", "verificar_tiempo_disponible",[
            "query" => [
                "datos" => [
                    "fecha" => $fecha,
                    "hora" => $hora,
                    "juzgado" => $request->session()->get("usuario_juzgado")
                ]
            ], ['exceptions' => true],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ]
        ]);

        $lista = json_decode($response->getBody(),true) ;
        return $lista;
    }

    public static function calcular_dias(Request $request, $fecha, $num_dias, $atras){
        
        //dd('obtenerEventos/'.$agenda_id.'/'.$ponencia);
        //se obtiene la lista de archivos
        $response = $request
        ->clienteWS
        ->request("GET", "calcular_dias",[
            "query" => [
                "datos" => [
                    "fecha" => $fecha,
                    "num_dias" => $num_dias,
                    "atras" => $atras
                ]
            ], ['exceptions' => true],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ]
        ]);

        $lista = json_decode($response->getBody(),true) ;
        return $lista;
    }

    public static function calcular_dias_sinse(Request $request, $fecha, $num_dias, $atras){
        
        //dd('obtenerEventos/'.$agenda_id.'/'.$ponencia);
        //se obtiene la lista de archivos
        $response = $request
        ->clienteWS
        ->request("GET", "calcular_dias",[
            "query" => [
                "datos" => [
                    "fecha" => $fecha,
                    "num_dias" => $num_dias,
                    "atras" => $atras
                ]
            ], ['exceptions' => true],
            "headers" => [
                "Content-Type" => "application/json"
            ]
        ]);

        $lista = json_decode($response->getBody(),true) ;
        return $lista;
    }

    public static function oralidad_agenda_divorcios(Request $request, $id_evento="", $fecha_desde="-", $fecha_hasta="-"){
        
        $response = $request
        ->clienteWS
        ->request("GET", "oralidad_agenda_divorcios",[
            "query" => [
                "datos" => [
                    "id_evento" => $id_evento,
                    "fecha_desde" => $fecha_desde,
                    "fecha_hasta" => $fecha_hasta
                ]
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ]
        ]);

        $lista = json_decode($response->getBody(),true) ;
        return $lista;
    }
 
    public static function obtener_citas_zoho(Request $request, $fecha){

        try{
            $texto_json = file_get_contents('https://citas.poderjudicialcdmx.gob.mx/juzgados/zoho/citas_juzgado.php?juzgado='.$request->session()->get("usuario_juzgado").'&fecha='.$fecha);
            $arr_json=json_decode($texto_json, true);

            foreach ($arr_json as $key => $row) {
                $aux[$key] = $row['hora_cita'];
            }
            array_multisort($aux, SORT_ASC, $arr_json);
        }
        catch (\Exception $e) { 
            $arr_json['estatus']=0;
            $arr_json['msj']="Error - Servicio de citas no disponible";
        }
        return $arr_json;
    }

    public static function cambiar_estatus_cita_zoho(Request $request, $folio, $estatus){
        
        try{
            $texto_json = file_get_contents('https://citas.poderjudicialcdmx.gob.mx/juzgados/zoho/citas_estatus.php?folio='.$folio.'&estatus='.$estatus);
            $arr_json=json_decode($texto_json, true);
        }
        catch (\Exception $e) { 
            $arr_json['estatus']=0;
            $arr_json['msj']="Error - Servicio de citas no disponible";
        }
        return $arr_json;
    }
}