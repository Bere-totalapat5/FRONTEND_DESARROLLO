<?php

namespace App\Http\Controllers\adip;


use App\Http\Controllers\Controller;
use App\Http\Controllers\clases\catalogos;
use App\Http\Controllers\clases\export;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Session;

class AdipController_c extends Controller
{
    //VISTAS

    public function consulta_adip(Request $request){


         $elementos=["entorno"=>$request->entorno,
                     "request"=>$request,
                     "sesion"=>Session::all(),
                     "menu_general"=>$request->menu_general,
                    /*  "solicitudes"=>$solicitudes */

                     ];
         return view('adip.consulta_adip_c', $elementos);


       }


    //DATOS

    public function obtener_reportes_adip( Request $request ){

      $response = $request
      ->clienteWS_penal
      ->request('GET', 'consulta_reportes_adip',[
          "headers" => [
              "sesion-id" => $request->session()->get("sesion-id"),
              "cadena-sesion" => $request->session()->get("cadena-sesion"),
              "usuario-id" => $request->session()->get("usuario-id"),
              "Content-Type" => "application/json"
          ],
          "json"=>[
              "datos"=>[
                   "fecha_inicio"=>$request->fecha_inicio,
                   "fecha_final"=>$request->fecha_final,
                   "bandera_reporte"=>$request->bandera_reporte,
              ],
              "paginacion"=>[
                "registros_por_pagina"=>$request->registros_por_pagina,
                "pagina"=>$request->pagina
              ]
          ]
      ]);
      $response = json_decode($response->getBody(),true) ;
      return $response;


    }

    public function obtener_reportes_excel( Request $request,$id_reporte,$tipo ){


                        $response = $request
                        ->clienteWS_penal
                        ->request('GET', 'obtener_archivo_reporte_adip/'.$id_reporte.'/'.$tipo,[
                            "headers" => [
                                "sesion-id" => $request->session()->get("sesion-id"),
                                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                                "usuario-id" => $request->session()->get("usuario-id"),
                                "Content-Type" => "application/json"
                            ],
                            "json"=>[
                                "datos"=>[]
                            ]
                        ]);
                        $response = json_decode($response->getBody(),true);

                        if(!isset($response['status'])){

                          $files = glob('/san/www/html/front_penal_desarrollo/public/excel_adip/*'); //obtenemos todos los nombres de los ficheros
                        foreach($files as $file){
                          if(is_file($file))
                          unlink($file); //elimino ficheros
                          }
                              $url_local='/san/www/html/front_penal_desarrollo/public/excel_adip/'.$id_reporte.'.xml';


                              $documento_xml=$response['response'];
                              copy($documento_xml, $url_local);

                              return [
                                  "status"=>100,
                                  "response"=>"/excel_adip/$id_reporte.xml"
                              ];
                          }else{
                              return $response;
                          }
    }

    public function obtener_reportes_xml( Request $request,$id_reporte,$tipo ){
        $response = $request
        ->clienteWS_penal
        ->request('GET', 'obtener_archivo_reporte_adip/'.$id_reporte.'/'.$tipo,[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[]
            ]
        ]);
        $response = json_decode($response->getBody(),true);

        if (!isset($response['status'])) {

            $nombre_doc = rand().'-'.$id_reporte.'-'.rand();

            $url_local = base_path().'/public/pdf_promocion/' . $nombre_doc . '.xml';

            $documento_pdf = $response['response'];
            copy($documento_pdf, $url_local);

            return [
                "status" => 100,
                "response" => "/pdf_promocion/$id_reporte.xml",
                "ruta_local"=>$url_local,
                "extension"=>'xml',
            ];
        }else{
            return $response;
        }
    }

    // obtiene los datos del servidor 
    public function obtener_csv(Request $request){
      $tipo = 'csv';
      $response = $request
      ->clienteWS_penal
      ->request('GET', 'obtener_csv/'.$request->id_reporte.'/'.$tipo,[
          "headers" => [
              "sesion-id" => $request->session()->get("sesion-id"),
              "cadena-sesion" => $request->session()->get("cadena-sesion"),
              "usuario-id" => $request->session()->get("usuario-id"),
              "Content-Type" => "application/json"
          ],
          "json"=>[
              "datos"=>[]
          ]
      ]);
      $response = json_decode($response->getBody(),true); //documento

      $version = $response['version'];
      // $version = 1;
      $id_reporte = $request->id_reporte;
      $ruta_base_local = base_path().'/public/adip_csv/';
      
      if ($response['status'] == 0) {
        return [
            "status" => 200,
            "response" => "No contiene archivo CSV"
        ];
      }else{
          $documento_pdf = $response['response'];
          $data = $this->csvToJson($documento_pdf);
          $version = $response['version'];
          
          // array con claves
          $data_key_c = [];
          for($i = 0; $i < count($data)-1; $i++){
                array_push($data_key_c, array(
                    "no"=>$i,
                    "CJ"=>$data[$i][0], 
                    "CI"=>$data[$i][1],
                    "nombre"=>$data[$i][2], 
                    "apellidoPaterno"=>$data[$i][3],  
                    "apellidoMaterno"=>$data[$i][4], 
                    "fechaNacimiento"=>$data[$i][5],
                    "domicilio"=>$data[$i][6],  
                    "genero"=>$data[$i][7],  
                    "edad"=>$data[$i][8], 
                    "ingreso"=>$data[$i][9],  
                    "estatus_imputado"=>$data[$i][10], 
                    "estatus_reincidencia"=>$data[$i][11],  
                    "fecha_vinculacion_proceso"=>$data[$i][12], 
                    "fecha_sentencia"=>$data[$i][13], 
                    "fecha_apelacion"=>$data[$i][14], 
                    "estatus_multa_posterior_apelacion"=>$data[$i][15], 
                    "pena_pecunaria_posterior_apelacion"=>$data[$i][16],
                    "fecha_amparo"=>$data[$i][17], 
                    "fecha_sobreseimiento"=>$data[$i][18],  
                    "tipo_juicio"=>$data[$i][19],
                    "tiempo_sentencia"=>$data[$i][20], 
                    "estatus_multa_posterior_sentencia"=>$data[$i][21], 
                    "pena_pecunaria_sentencia"=>$data[$i][22],  
                    "estatus_carpeta"=>$data[$i][23]    
                ));
          }
          

          $response["data"] =  $data;
          $res = [  "status"=>100,
                    "response"=>$data_key_c, 
                    "version"=>$version, 
                    "nombre_documento"=>$id_reporte.'_'.$version
                  ];

          return $res;
          
      }
    
      /*
      $data = [
        array(
          "no" => "1",
          "CJ"=> "001/0545/2021",
          "CI"=> "CI-FICUH/CUH-2/UI-2 C/D/01782/04-2021",
          "fecha_creacion_carpeta"=> "2021-04-11 15=>25=>02",
          "estatus_carpeta"=> "Activo",
          "fecha_apelacion"=> "",
          "fecha_amparo"=> "",
          "fecha_vinculacion_proceso"=> "2021-04-12 13=>29=>00",
          "fecha_sentencia"=> "no",
          "fecha_sobreseimiento"=> "no",
          "tiempo_sentencia"=> "no",
          "id_persona"=> 615012,
          "tipoPersona"=> "1",
          "nombre"=> "DANILO",
          "apellidoPaterno"=> "MACIAS",
          "apellidoMaterno"=> "ROMO",
          "genero"=> "Masculino",
          "edad"=> 20,
          "fechaNacimiento"=> "2000-11-28",
          "estatus_imputado"=> "ACTIVO",
          "domicilio"=> "EUCALIPTO #28B Colonia ARBOLEDAS DE ARAGON C.P. 55290 ECATEPEC, ESTADO DE MEXICO",
          "ingreso"=> "",
          "estatus_reincidencia"=> 0,
          "estatus_multa_posterior_apelacion"=> 0,
          "pena_pecunaria_posterior_apelacion"=> 0,
          "tipo_juicio"=> 0,
          "estatus_multa_posterior_sentencia"=> 0,
          "pena_pecunaria_sentencia"=> 0
        ),
        array(
          "no" => "2",
          "CJ"=> "001/0546/2021",
          "CI"=> "CI-FIDS/FDS-6/UI-FDS-6-02/00962/04-2021",
          "fecha_creacion_carpeta"=> "2021-04-11 18=>23=>48",
          "estatus_carpeta"=> "Activo",
          "fecha_apelacion"=> "",
          "fecha_amparo"=> "",
          "fecha_vinculacion_proceso"=> "no",
          "fecha_sentencia"=> "no",
          "fecha_sobreseimiento"=> "no",
          "tiempo_sentencia"=> "no",
          "id_persona"=> 615072,
          "tipoPersona"=> "1",
          "nombre"=> "PASIANO ISIDRO",
          "apellidoPaterno"=> "IDELFONSO",
          "apellidoMaterno"=> "RODRIGUEZ",
          "genero"=> "Masculino",
          "edad"=> 55,
          "fechaNacimiento"=> "1966-03-09",
          "estatus_imputado"=> "ACTIVO",
          "domicilio"=> "CALLE DURAZNO #478 Colonia MIRAVALLE C.P. 09696 IZTAPALAPA, CIUDAD DE MEXICO",
          "ingreso"=> "",
          "estatus_reincidencia"=> 0,
          "estatus_multa_posterior_apelacion"=> 0,
          "pena_pecunaria_posterior_apelacion"=> 0,
          "tipo_juicio"=> 0,
          "estatus_multa_posterior_sentencia"=> 0,
          "pena_pecunaria_sentencia"=> 0
        ),
        array(
          "no" => "3",
          "CJ"=> "001/0547/2021",
          "CI"=> "CI-FIIZP/IZP-8/UI-2 C/D/01330/04-2021",
          "fecha_creacion_carpeta"=> "2021-04-11 23=>18=>12",
          "estatus_carpeta"=> "Activo",
          "fecha_apelacion"=> "",
          "fecha_amparo"=> "",
          "fecha_vinculacion_proceso"=> "no",
          "fecha_sentencia"=> "no",
          "fecha_sobreseimiento"=> "no",
          "tiempo_sentencia"=> "no",
          "id_persona"=> 615170,
          "tipoPersona"=> "1",
          "nombre"=> "ADRIAN",
          "apellidoPaterno"=> "GUILLEN",
          "apellidoMaterno"=> "GRANDE",
          "genero"=> "Masculino",
          "edad"=> 29,
          "fechaNacimiento"=> "1991-07-09",
          "estatus_imputado"=> "ACTIVO",
          "domicilio"=> "QUINTO CALLEJON DE GENERAL ANAYA #82 Colonia SAN LUCAS C.P. 09000D IZTAPALAPA, CIUDAD DE MEXICO",
          "ingreso"=> "",
          "estatus_reincidencia"=> 0,
          "estatus_multa_posterior_apelacion"=> 0,
          "pena_pecunaria_posterior_apelacion"=> 0,
          "tipo_juicio"=> 0,
          "estatus_multa_posterior_sentencia"=> 0,
          "pena_pecunaria_sentencia"=> 0
        ),
        array(
          "no" => "4",
          "CJ"=> "001/0547/2021",
          "CI"=> "CI-FIIZP/IZP-8/UI-2 C/D/01330/04-2021",
          "fecha_creacion_carpeta"=> "2021-04-11 23=>18=>12",
          "estatus_carpeta"=> "Activo",
          "fecha_apelacion"=> "",
          "fecha_amparo"=> "",
          "fecha_vinculacion_proceso"=> "no",
          "fecha_sentencia"=> "no",
          "fecha_sobreseimiento"=> "no",
          "tiempo_sentencia"=> "no",
          "id_persona"=> 615171,
          "tipoPersona"=> "1",
          "nombre"=> "DANIEL",
          "apellidoPaterno"=> "RICO",
          "apellidoMaterno"=> "HERNANDEZ",
          "genero"=> "Masculino",
          "edad"=> 26,
          "fechaNacimiento"=> "1994-07-10",
          "estatus_imputado"=> "ACTIVO",
          "domicilio"=> "CALLE GENERAL ANAYA #64 Colonia SAN LUCAS C.P. 09000D IZTAPALAPA, CIUDAD DE MEXICO",
          "ingreso"=> "",
          "estatus_reincidencia"=> 0,
          "estatus_multa_posterior_apelacion"=> 0,
          "pena_pecunaria_posterior_apelacion"=> 0,
          "tipo_juicio"=> 0,
          "estatus_multa_posterior_sentencia"=> 0,
          "pena_pecunaria_sentencia"=> 0
        ),
        array(
          "no" => "5",
          "CJ"=> "001/0547/2021",
          "CI"=> "CI-FIIZP/IZP-8/UI-2 C/D/01330/04-2021",
          "fecha_creacion_carpeta"=> "2021-04-11 23=>18=>12",
          "estatus_carpeta"=> "Activo",
          "fecha_apelacion"=> "",
          "fecha_amparo"=> "",
          "fecha_vinculacion_proceso"=> "no",
          "fecha_sentencia"=> "no",
          "fecha_sobreseimiento"=> "no",
          "tiempo_sentencia"=> "no",
          "id_persona"=> 615173,
          "tipoPersona"=> "1",
          "nombre"=> "JACQUELINE",
          "apellidoPaterno"=> "AVILES",
          "apellidoMaterno"=> "HERNANDEZ",
          "genero"=> "Femenino",
          "edad"=> 33,
          "fechaNacimiento"=> "1987-09-10",
          "estatus_imputado"=> "ACTIVO",
          "domicilio"=> "CALLE ZAPATA #8 Colonia LOS REYES CULHUACAN C.P. 09840 IZTAPALAPA, CIUDAD DE MEXICO",
          "ingreso"=> "",
          "estatus_reincidencia"=> 0,
          "estatus_multa_posterior_apelacion"=> 0,
          "pena_pecunaria_posterior_apelacion"=> 0,
          "tipo_juicio"=> 0,
          "estatus_multa_posterior_sentencia"=> 0,
          "pena_pecunaria_sentencia"=> 0
        ),
        array(
          "no" => "6",
          "CJ"=> "001/0548/2021",
          "CI"=> "CI-FIBJ/BJ-2/UI-3 C/D/00619/04-2021",
          "fecha_creacion_carpeta"=> "2021-04-12 05=>26=>41",
          "estatus_carpeta"=> "Cerrada",
          "fecha_apelacion"=> "",
          "fecha_amparo"=> "",
          "fecha_vinculacion_proceso"=> "2021-04-12 12=>26=>00",
          "fecha_sentencia"=> "no",
          "fecha_sobreseimiento"=> "no",
          "tiempo_sentencia"=> "no",
          "id_persona"=> 615223,
          "tipoPersona"=> "1",
          "nombre"=> "NORMAN ALEXANDER",
          "apellidoPaterno"=> "FORSYHT",
          "apellidoMaterno"=> "DERGAL",
          "genero"=> "Masculino",
          "edad"=> 45,
          "fechaNacimiento"=> "1975-12-29",
          "estatus_imputado"=> "BAJA",
          "domicilio"=> "HOLBEIN #63 Colonia CIUDAD DE LOS DEPORTES C.P. 03710 BENITO JUAREZ, CIUDAD DE MEXICO",
          "ingreso"=> "",
          "estatus_reincidencia"=> 0,
          "estatus_multa_posterior_apelacion"=> 0,
          "pena_pecunaria_posterior_apelacion"=> 0,
          "tipo_juicio"=> 0,
          "estatus_multa_posterior_sentencia"=> 0,
          "pena_pecunaria_sentencia"=> 0
        ),
        array(
          "no" => "7",
          "CJ"=> "001/0549/2021",
          "CI"=> "CI-FNNA/59/UI-3 C/D/00447/02-2020",
          "fecha_creacion_carpeta"=> "2021-04-12 09=>01=>43",
          "estatus_carpeta"=> "Activo",
          "fecha_apelacion"=> "",
          "fecha_amparo"=> "",
          "fecha_vinculacion_proceso"=> "no",
          "fecha_sentencia"=> "no",
          "fecha_sobreseimiento"=> "no",
          "tiempo_sentencia"=> "no",
          "id_persona"=> 614423,
          "tipoPersona"=> "1",
          "nombre"=> "MARCOS",
          "apellidoPaterno"=> "PINEDA",
          "apellidoMaterno"=> "BARCENAS",
          "genero"=> "Masculino",
          "edad"=> 44,
          "fechaNacimiento"=> "1975-09-24",
          "estatus_imputado"=> "ACTIVO",
          "domicilio"=> "CERRADA 2 DE ARBOLITOS #S/N Colonia TECAXTITLA C.P. 12100B MILPA ALTA, CIUDAD DE MEXICO",
          "ingreso"=> "",
          "estatus_reincidencia"=> 0,
          "estatus_multa_posterior_apelacion"=> 0,
          "pena_pecunaria_posterior_apelacion"=> 0,
          "tipo_juicio"=> 0,
          "estatus_multa_posterior_sentencia"=> 0,
          "pena_pecunaria_sentencia"=> 0
        ),
        array(
          "no" => "8",
          "CJ"=> "001/0551/2021",
          "CI"=> "CI-FSP/B/UI-B-3 C/D/519/02-2019",
          "fecha_creacion_carpeta"=> "2021-04-12 12=>33=>14",
          "estatus_carpeta"=> "Cerrada",
          "fecha_apelacion"=> "",
          "fecha_amparo"=> "",
          "fecha_vinculacion_proceso"=> "no",
          "fecha_sentencia"=> "no",
          "fecha_sobreseimiento"=> "no",
          "tiempo_sentencia"=> "no",
          "id_persona"=> 635065,
          "tipoPersona"=> "1",
          "nombre"=> "JOSE GUADALUPE",
          "apellidoPaterno"=> "VELASCO",
          "apellidoMaterno"=> "MANZANO",
          "genero"=> "Masculino",
          "edad"=> null,
          "fechaNacimiento"=> null,
          "estatus_imputado"=> "BAJA",
          "domicilio"=> " #0 Colonia  C.P.  , ",
          "ingreso"=> "",
          "estatus_reincidencia"=> 0,
          "estatus_multa_posterior_apelacion"=> 0,
          "pena_pecunaria_posterior_apelacion"=> 0,
          "tipo_juicio"=> 0,
          "estatus_multa_posterior_sentencia"=> 0,
          "pena_pecunaria_sentencia"=> 0
        ),
        array(
          "no" => "9",
          "CJ"=> "001/0551/2021",
          "CI"=> "CI-FSP/B/UI-B-3 C/D/519/02-2019",
          "fecha_creacion_carpeta"=> "2021-04-12 12=>33=>14",
          "estatus_carpeta"=> "Cerrada",
          "fecha_apelacion"=> "",
          "fecha_amparo"=> "",
          "fecha_vinculacion_proceso"=> "no",
          "fecha_sentencia"=> "no",
          "fecha_sobreseimiento"=> "no",
          "tiempo_sentencia"=> "no",
          "id_persona"=> 635066,
          "tipoPersona"=> "1",
          "nombre"=> "GABRIELA",
          "apellidoPaterno"=> "TRENADO",
          "apellidoMaterno"=> "PEREZ",
          "genero"=> "Femenino",
          "edad"=> null,
          "fechaNacimiento"=> null,
          "estatus_imputado"=> "BAJA",
          "domicilio"=> " #0 Colonia  C.P.  , ",
          "ingreso"=> "",
          "estatus_reincidencia"=> 0,
          "estatus_multa_posterior_apelacion"=> 0,
          "pena_pecunaria_posterior_apelacion"=> 0,
          "tipo_juicio"=> 0,
          "estatus_multa_posterior_sentencia"=> 0,
          "pena_pecunaria_sentencia"=> 0
        ),
        array(
          "no" => "10",
          "CJ"=> "001/0551/2021",
          "CI"=> "CI-FSP/B/UI-B-3 C/D/519/02-2019",
          "fecha_creacion_carpeta"=> "2021-04-12 12=>33=>14",
          "estatus_carpeta"=> "Cerrada",
          "fecha_apelacion"=> "",
          "fecha_amparo"=> "",
          "fecha_vinculacion_proceso"=> "no",
          "fecha_sentencia"=> "no",
          "fecha_sobreseimiento"=> "no",
          "tiempo_sentencia"=> "no",
          "id_persona"=> 635072,
          "tipoPersona"=> "1",
          "nombre"=> "JESUS",
          "apellidoPaterno"=> "VENTURA",
          "apellidoMaterno"=> "SANCHEZ",
          "genero"=> "Masculino",
          "edad"=> null,
          "fechaNacimiento"=> null,
          "estatus_imputado"=> "BAJA",
          "domicilio"=> " #0 Colonia  C.P.  , ",
          "ingreso"=> "",
          "estatus_reincidencia"=> 0,
          "estatus_multa_posterior_apelacion"=> 0,
          "pena_pecunaria_posterior_apelacion"=> 0,
          "tipo_juicio"=> 0,
          "estatus_multa_posterior_sentencia"=> 0,
          "pena_pecunaria_sentencia"=> 0
        ),
        array(
          "no" => "11",
          "CJ"=> "001/0551/2021",
          "CI"=> "CI-FSP/B/UI-B-3 C/D/519/02-2019",
          "fecha_creacion_carpeta"=> "2021-04-12 12=>33=>14",
          "estatus_carpeta"=> "Cerrada",
          "fecha_apelacion"=> "",
          "fecha_amparo"=> "",
          "fecha_vinculacion_proceso"=> "no",
          "fecha_sentencia"=> "no",
          "fecha_sobreseimiento"=> "no",
          "tiempo_sentencia"=> "no",
          "id_persona"=> 635073,
          "tipoPersona"=> "1",
          "nombre"=> "JOSE CARLOS",
          "apellidoPaterno"=> "VILLAREAL",
          "apellidoMaterno"=> "ROSILLO",
          "genero"=> "Masculino",
          "edad"=> null,
          "fechaNacimiento"=> null,
          "estatus_imputado"=> "BAJA",
          "domicilio"=> " #0 Colonia  C.P.  , ",
          "ingreso"=> "",
          "estatus_reincidencia"=> 0,
          "estatus_multa_posterior_apelacion"=> 0,
          "pena_pecunaria_posterior_apelacion"=> 0,
          "tipo_juicio"=> 0,
          "estatus_multa_posterior_sentencia"=> 0,
          "pena_pecunaria_sentencia"=> 0
        ),
        array(
          "no" => "12",
          "CJ"=> "001/0554/2021",
          "CI"=> "CI-FCH/CUH-8/UI-2 S/D/02839/08-2019",
          "fecha_creacion_carpeta"=> "2021-04-12 14=>59=>34",
          "estatus_carpeta"=> "Cerrada",
          "fecha_apelacion"=> "",
          "fecha_amparo"=> "",
          "fecha_vinculacion_proceso"=> "no",
          "fecha_sentencia"=> "no",
          "fecha_sobreseimiento"=> "no",
          "tiempo_sentencia"=> "no",
          "id_persona"=> 620389,
          "tipoPersona"=> "1",
          "nombre"=> "INDETERMINADO",
          "apellidoPaterno"=> "INDETERMINADO",
          "apellidoMaterno"=> "",
          "genero"=> "Indeterminado",
          "edad"=> null,
          "fechaNacimiento"=> null,
          "estatus_imputado"=> "BAJA",
          "domicilio"=> " #0 Colonia  C.P.  , ",
          "ingreso"=> "",
          "estatus_reincidencia"=> 0,
          "estatus_multa_posterior_apelacion"=> 0,
          "pena_pecunaria_posterior_apelacion"=> 0,
          "tipo_juicio"=> 0,
          "estatus_multa_posterior_sentencia"=> 0,
          "pena_pecunaria_sentencia"=> 0
        ),
        array(
          "no" => "13",
          "CJ"=> "001/0555/2021",
          "CI"=> "CI-FIAO/AO-3/UI-3 C/D/00555/04-2021",
          "fecha_creacion_carpeta"=> "2021-04-12 17=>52=>24",
          "estatus_carpeta"=> "Activo",
          "fecha_apelacion"=> "",
          "fecha_amparo"=> "",
          "fecha_vinculacion_proceso"=> "2021-04-13 15=>04=>27",
          "fecha_sentencia"=> "no",
          "fecha_sobreseimiento"=> "no",
          "tiempo_sentencia"=> "no",
          "id_persona"=> 615631,
          "tipoPersona"=> "1",
          "nombre"=> "IRVIG JOSUE",
          "apellidoPaterno"=> "GALLEGOS",
          "apellidoMaterno"=> "PEREZ",
          "genero"=> "Masculino",
          "edad"=> 21,
          "fechaNacimiento"=> "1999-11-12",
          "estatus_imputado"=> "ACTIVO",
          "domicilio"=> "CALLE LINTERNA NUMERO 06 #06 Colonia BARRIO NORTE C.P. 01410 ALVARO OBREGON, CIUDAD DE MEXICO",
          "ingreso"=> "",
          "estatus_reincidencia"=> 0,
          "estatus_multa_posterior_apelacion"=> 0,
          "pena_pecunaria_posterior_apelacion"=> 0,
          "tipo_juicio"=> 0,
          "estatus_multa_posterior_sentencia"=> 0,
          "pena_pecunaria_sentencia"=> 0
        ),
        array(
          "no" => "14",
          "CJ"=> "001/0556/2021",
          "CI"=> "CI-FIGAM/GAM-2/UI-3 C/D/00750/04-2021",
          "fecha_creacion_carpeta"=> "2021-04-12 19=>06=>30",
          "estatus_carpeta"=> "Activo",
          "fecha_apelacion"=> "",
          "fecha_amparo"=> "",
          "fecha_vinculacion_proceso"=> "no",
          "fecha_sentencia"=> "no",
          "fecha_sobreseimiento"=> "no",
          "tiempo_sentencia"=> "no",
          "id_persona"=> 615688,
          "tipoPersona"=> "1",
          "nombre"=> "VICTOR ADRIAN",
          "apellidoPaterno"=> "ALVAREZ",
          "apellidoMaterno"=> "MADRIGAL",
          "genero"=> "Masculino",
          "edad"=> 34,
          "fechaNacimiento"=> "1986-10-20",
          "estatus_imputado"=> "ACTIVO",
          "domicilio"=> "AV PRIMAVERA #LT 04 Colonia LA CANDELARIA TICOMAN C.P. 07310 GUSTAVO A MADERO, CIUDAD DE MEXICO",
          "ingreso"=> "",
          "estatus_reincidencia"=> 0,
          "estatus_multa_posterior_apelacion"=> 0,
          "pena_pecunaria_posterior_apelacion"=> 0,
          "tipo_juicio"=> 0,
          "estatus_multa_posterior_sentencia"=> 0,
          "pena_pecunaria_sentencia"=> 0
        ),
        array(
          "no" => "15",
          "CJ"=> "001/0557/2021",
          "CI"=> "CI-FIDAMPU/A/UI-1 C/D/00302/04-2021",
          "fecha_creacion_carpeta"=> "2021-04-12 22=>16=>02",
          "estatus_carpeta"=> "Activo",
          "fecha_apelacion"=> "",
          "fecha_amparo"=> "",
          "fecha_vinculacion_proceso"=> "2021-04-13 14=>44=>00",
          "fecha_sentencia"=> "no",
          "fecha_sobreseimiento"=> "no",
          "tiempo_sentencia"=> "no",
          "id_persona"=> 615721,
          "tipoPersona"=> "1",
          "nombre"=> "CARLOS",
          "apellidoPaterno"=> "MONROY",
          "apellidoMaterno"=> "PONCE",
          "genero"=> "Masculino",
          "edad"=> 60,
          "fechaNacimiento"=> "1960-10-07",
          "estatus_imputado"=> "ACTIVO",
          "domicilio"=> "CANAL DE CHALCO ESQUINA LAS TORRES #SN Colonia SAN LORENZO C.P. 09857A IZTAPALAPA, CIUDAD DE MEXICO",
          "ingreso"=> "",
          "estatus_reincidencia"=> 0,
          "estatus_multa_posterior_apelacion"=> 0,
          "pena_pecunaria_posterior_apelacion"=> 0,
          "tipo_juicio"=> 0,
          "estatus_multa_posterior_sentencia"=> 0,
          "pena_pecunaria_sentencia"=> 0
        )

      ];
      
      $json_string = json_decode( json_encode($data), true );

      $res = ["status"=>100,"response"=>$data, "ruta"=>$ruta_base_local.'reporte_ADIP_'.$id_reporte.'_'.$version.'.json', "version"=>$version, "nombre_documento"=>'reporte_ADIP_'.$id_reporte.'_'];

      return $res;
      */
    }
    //guarda datos en el local
    public function guardar_json_local(Request $request){
      $data = $request->response;
      $nombre = $request->nombre;
      $version = $request->version;
      $status = $request->status;

      $ruta_base_local = base_path().'/public/adip_csv/';

      if($status == 100){
        $fp = fopen($ruta_base_local.$nombre.'.json', 'a');
          foreach($data as $dato){
            fwrite($fp,json_encode($dato));
          }
        fclose($fp);

        return ["status" => 100, "message" => "Los cambios han sido guardados"];
        
      }else{
        return ["status" => 0, "message" => "Error al guardar los datos"];
      }
    }
    // elimina los archivos temporales
    public function eliminar_json_temporal(Request $request){
      $ruta_base_local = base_path().'/public/adip_csv/';
      $nombre_archivo = $request->nombre_archivo;
      $file = $ruta_base_local.$nombre_archivo.'.json';

      if(is_file($file)){
        unlink($file); 
        return ["status" => 100, "message" => "Archivo temporal eliminado"];
      }else{
        return ["status" => 100, "message" => "No existe el archivo: ".$nombre_archivo.".json"];
      }
    }
    //Convierte a csv
    public function csvToJson($fname) {

      $content =  file_get_contents($fname);  
      $rows = explode("\n",$content);
      $s = array();   

      foreach($rows as $key => $row) {
        $s[] = str_getcsv($row);
      }

      return $s; 
    }
    //cambiar estado en linea
    public function cambiar_estado_online(Request $request){
      $response = $request
      ->clienteWS_penal
      ->request('POST', 'estado_online',[
          "headers" => [
              "sesion-id" => $request->session()->get("sesion-id"),
              "cadena-sesion" => $request->session()->get("cadena-sesion"),
              "usuario-id" => $request->session()->get("usuario-id"),
              "Content-Type" => "application/json"
          ],
          "json"=>[
              "datos"=>[
                   "id_reporte"=>$request->id_reporte,
                   "estado"=>$request->estado
              ]
          ]
      ]);
      $response = json_decode($response->getBody(),true) ;
      return $response;
    }    
    //revisar estado en linea
    public function revisar_estado_online(Request $request){
      $response = $request
      ->clienteWS_penal
      ->request('POST', 'revisar_estado',[
          "headers" => [
              "sesion-id" => $request->session()->get("sesion-id"),
              "cadena-sesion" => $request->session()->get("cadena-sesion"),
              "usuario-id" => $request->session()->get("usuario-id"),
              "Content-Type" => "application/json"
          ],
          "json"=>[
              "datos"=>[
                   "bandera_reporte"=>$request->adip,
              ]
          ]
      ]);
      $response = json_decode($response->getBody(),true) ;
      return $response;
    }
    //guardar version json
    public function csv_version_nueva(Request $request){
      $response = $request
      ->clienteWS_penal
      ->request('POST', 'csv_version_nueva',[
          "headers" => [
              "sesion-id" => $request->session()->get("sesion-id"),
              "cadena-sesion" => $request->session()->get("cadena-sesion"),
              "usuario-id" => $request->session()->get("usuario-id"),
              "Content-Type" => "application/json"
          ],
          "json"=>[
              "datos"=>[
                   "new_csv"=>$request->data,
                   "nombre"=>$request->nombre,
                   "version"=>$request->version,
                   "nombre_session"=> $request->session()->get("usuario_nombre")
              ]
          ]
      ]);
      $response = json_decode($response->getBody(),true) ;
      return $response;
    }


}
