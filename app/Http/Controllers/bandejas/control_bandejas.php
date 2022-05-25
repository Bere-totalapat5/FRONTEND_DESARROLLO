<?php

namespace App\Http\Controllers\bandejas;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Controllers\clases\notificaciones;
use App\Http\Controllers\clases\bandejas;
use App\Http\Controllers\clases\acuerdos;
use App\Http\Controllers\clases\archivos;
use App\Http\Controllers\clases\agendas;
use App\Http\Controllers\clases\anales;
use App\Http\Controllers\clases\promociones;
use App\Http\Controllers\clases\gestorDocumental;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\clases\humanRelativeDate;
use App\Http\Controllers\clases\utilidades;
use App\Http\Controllers\clases\procesos_trabajo;
use App\Http\Controllers\clases\elementos_boletin;
use App\Http\Controllers\clases\WSFirma;


class control_bandejas extends Controller
{
    public function inicio( Request $request, $bandeja){

        //dd(archivos::numero_firmas_acuerdo($request, "100PIC", "1600742819"));

        if($request->session()->get('juzgado_tipo')=='sala'){
            $datos['toca']="";
            $datos['anio_toca']="";
            $datos['asunto_toca']="";
            $datos['expediente']="";
            $datos['expediente_anio']="";
            $datos['involucrados_nombre']="";
            $datos['involucrados_apellido_paterno']="";
            $datos['involucrados_apellido_materno']="";
            $datos['tipo_acuerdo']="";
            $datos['origen_acuerdo']="";
            $datos['registrado_desde']="";
            $datos['registrado_hasta']="";
            
            $lista=bandejas::obtener_listado_bandejas($request, $bandeja, $datos);

            //se carga el permiso de fecha de publicacion
            $bandera_modificar_flujo=procesos_trabajo::obtener_valor_permiso_accion($request, 3);


            $bandeja_txt="Firma";
            if($bandeja=="revision"){
                $bandeja_txt="Revisión";
            }
            
            return view(    "bandejas.bandejas",
                            ["entorno"=>$request->entorno, 
                            "request"=>$request,
                            "sesion"=>$request->session()->all(),
                            "menu_general"=>$request->menu_general,
                            "lista"=>$lista,
                            "bandeja"=>$bandeja,
                            "bandeja_txt"=>$bandeja_txt,
                            "bandera_modificar_flujo"=>$bandera_modificar_flujo
                            ]
                        );
        }
        else{

            $datos['toca']="";
            $datos['anio_toca']="";
            $datos['asunto_toca']="";
            $datos['expediente']="";
            $datos['expediente_anio']="";
            $datos['involucrados_nombre']="";
            $datos['involucrados_apellido_paterno']="";
            $datos['involucrados_apellido_materno']="";
            $datos['tipo_acuerdo']="";
            $datos['origen_acuerdo']="";
            $datos['registrado_desde']="";
            $datos['registrado_hasta']="";

            $lista=bandejas::obtener_listado_bandejas($request, $bandeja, $datos);

            $bandeja_txt="Firma";
            if($bandeja=="revision"){
                $bandeja_txt="Revisión";
            }
            
            return view(    "bandejas.bandejas_juzgados",
                            ["entorno"=>$request->entorno, 
                            "request"=>$request,
                            "sesion"=>$request->session()->all(),
                            "menu_general"=>$request->menu_general,
                            "lista"=>$lista,
                            "bandeja"=>$bandeja,
                            "bandeja_txt"=>$bandeja_txt
                            ]
                        );
        }
    }

    public function editarAcuerdoHtml( Request $request, $id_acuerdo, $id_juicio, $flujo_id, $bandeja=""){

        if($bandeja=="firma"){
            //se pone la plantilla
            $contenido="";
            $lista=acuerdos::cancelar_publicacion($request, $id_acuerdo);
            $lista=bandejas::bandeja_avanzar_revision_juzgado($request, $id_acuerdo, 'corregido');
        }
        else if($bandeja=="revision"){
            //dd(2);
        }
        
        $lista_flujo=acuerdos::obtener_ultima_version_acuerdo($request, $id_acuerdo);
        if($lista_flujo['status']!=100){
            return $lista_flujo;
        }
        $ultima_version=$lista_flujo['response'];

        $lista=bandejas::documento_descargar($request, $id_acuerdo, $request->session()->get('usuario_juzgado'), $ultima_version, 'html');
        $lista_acuerdo=acuerdos::obtener_archivo_acuerdo($request, $id_juicio, $id_acuerdo);
        //dd($lista_acuerdo);
        $contenido=file_get_contents($lista['response']);
        
        return view(    "bandejas.bandeja_editar_acuerdo_html",
                        ["entorno"=>$request->entorno, 
                        "request"=>$request,
                        "sesion"=>$request->session()->all(),
                        "menu_general"=>$request->menu_general,
                        "contenido"=>$contenido,
                        "id_acuerdo" => $id_acuerdo,
                        "id_juicio" => $id_juicio,
                        "flujo_id" => $flujo_id,
                        "usuario_juzgado" => $flujo_id,
                        "acuerdo" => $lista_acuerdo['response'][0]['acuerdo'],
                        "bandeja" => $bandeja,
                        ]
                    );
        
    }

    public function buscar_bandeja_ajax( Request $request ){

        $input = $request->all();
        //return response()->json($input);
        unset($datos);
        
        if($request->session()->get('juzgado_tipo')=='sala'){
            ($input['toca']=="-") ? $datos['toca']="" : $datos['toca']=$input['toca'];
            ($input['anio_toca']=="0") ? $datos['anio_toca']="" : $datos['anio_toca']=$input['anio_toca'];
            ($input['asunto_toca']=="-") ? $datos['asunto_toca']="" : $datos['asunto_toca']=$input['asunto_toca'];
            ($input['expediente']=="-") ? $datos['expediente']="" : $datos['expediente']=$input['expediente'];
            ($input['anio_expediente']=="0") ? $datos['expediente_anio']="" : $datos['expediente_anio']=$input['anio_expediente'];
            ($input['involucrados_nombre']=="-") ? $datos['involucrados_nombre']="" : $datos['involucrados_nombre']=$input['involucrados_nombre'];
            ($input['involucrados_apellido_paterno']=="-") ? $datos['involucrados_apellido_paterno']="" : $datos['involucrados_apellido_paterno']=$input['involucrados_apellido_paterno'];
            ($input['involucrados_apellido_materno']=="-") ? $datos['involucrados_apellido_materno']="" : $datos['involucrados_apellido_materno']=$input['involucrados_apellido_materno'];
            ($input['tipo_acuerdo']=="-") ? $datos['tipo_acuerdo']="" : $datos['tipo_acuerdo']=$input['tipo_acuerdo'];
            ($input['origen_acuerdo']=="-") ? $datos['origen_acuerdo']="" : $datos['origen_acuerdo']=$input['origen_acuerdo'];
            ($input['fecha_desde']=="-") ? $datos['registrado_desde']="" : $datos['registrado_desde']=$input['fecha_desde'];
            ($input['fecha_hasta']=="-") ? $datos['registrado_hasta']="" : $datos['registrado_hasta']=$input['fecha_hasta'];

            $lista_archivos=bandejas::obtener_listado_bandejas($request, $input['bandeja'], $datos);


            $humanRelativeDate = new humanRelativeDate();
            if(isset($lista_archivos['response'][0]['Fecha'])){
                for($i=0; $i<count($lista_archivos['response']); $i++){

                    $fecha_arr=explode(' ', $lista_archivos['response'][$i]['Fecha']);

                    $fechaCreacion=$humanRelativeDate->getTextForSQLDate($fecha_arr[0]);
                    $lista_archivos['response'][$i]['fecha_humana']=$fechaCreacion;
                    $lista_archivos['response'][$i]['fecha_1']=$fecha_arr[0];

                    $lista_archivos['response'][$i]['TocaEstado']=$lista_archivos['response'][$i]['Toca/Estado'];

                }
            }
        }
        else{
            $datos['toca']="";
            $datos['anio_toca']="";
            $datos['asunto_toca']="";
            ($input['expediente']=="-") ? $datos['expediente']="" : $datos['expediente']=$input['expediente'];
            ($input['anio_expediente']=="0") ? $datos['expediente_anio']="" : $datos['expediente_anio']=$input['anio_expediente'];
            ($input['involucrados_nombre']=="-") ? $datos['involucrados_nombre']="" : $datos['involucrados_nombre']=$input['involucrados_nombre'];
            ($input['involucrados_apellido_paterno']=="-") ? $datos['involucrados_apellido_paterno']="" : $datos['involucrados_apellido_paterno']=$input['involucrados_apellido_paterno'];
            ($input['involucrados_apellido_materno']=="-") ? $datos['involucrados_apellido_materno']="" : $datos['involucrados_apellido_materno']=$input['involucrados_apellido_materno'];
            ($input['tipo_acuerdo']=="-") ? $datos['tipo_acuerdo']="" : $datos['tipo_acuerdo']=$input['tipo_acuerdo'];
            ($input['origen_acuerdo']=="-") ? $datos['origen_acuerdo']="" : $datos['origen_acuerdo']=$input['origen_acuerdo'];
            ($input['fecha_desde']=="-") ? $datos['registrado_desde']="" : $datos['registrado_desde']=$input['fecha_desde'];
            ($input['fecha_hasta']=="-") ? $datos['registrado_hasta']="" : $datos['registrado_hasta']=$input['fecha_hasta'];

            $lista_archivos=bandejas::obtener_listado_bandejas($request, $input['bandeja'], $datos);

            $humanRelativeDate = new humanRelativeDate();
            if(isset($lista_archivos['response'][0]['Fecha'])){
                for($i=0; $i<count($lista_archivos['response']); $i++){

                    $fecha_arr=explode(' ', $lista_archivos['response'][$i]['Fecha']);

                    $fechaCreacion=$humanRelativeDate->getTextForSQLDate($fecha_arr[0]);
                    $lista_archivos['response'][$i]['fecha_humana']=$fechaCreacion;
                    $lista_archivos['response'][$i]['fecha_1']=$fecha_arr[0];

                    $lista_archivos['response'][$i]['TocaEstado']=$lista_archivos['response'][$i]['Toca/Estado'];

                }
            }

        }
        return response()->json($lista_archivos);
    }

    public function obtener_listado_proxima_publicacion( Request $request){

        $datos['toca']="";
        $datos['anio_toca']="";
        $datos['asunto_toca']="";
        $datos['registrado_desde']="";
        $datos['registrado_hasta']="";
        
        $lista=bandejas::obtener_listado_proxima_publicacion($request, $datos, '');
        $lista_acciones=procesos_trabajo::obetner_acciones($request, $request->session()->get('usuario-id'));
        
        return view(    "bandejas.bandejas_proximaPublicacion",
                        ["entorno"=>$request->entorno, 
                        "request"=>$request,
                        "sesion"=>$request->session()->all(),
                        "menu_general"=>$request->menu_general,
                        "lista"=>$lista,
                        "lista_acciones"=>$lista_acciones
                        ]
                    );
    }

    public function obtener_listado_proxima_publicacion2( Request $request){

        $datos['toca']="";
        $datos['anio_toca']="";
        $datos['asunto_toca']="";
        $datos['registrado_desde']="";
        $datos['registrado_hasta']="";

        $lista_fecha_publicacion=agendas::obtener_tiempo_disponible($request);
        $lista=bandejas::obtener_listado_proxima_publicacion($request, $datos, '');

        $lista_acciones=procesos_trabajo::obetner_acciones($request, $request->session()->get('usuario-id'));

        return view(    "bandejas.bandejas_busquedaPublicacion",
                        ["entorno"=>$request->entorno, 
                        "request"=>$request,
                        "sesion"=>$request->session()->all(),
                        "menu_general"=>$request->menu_general,
                        "lista"=>$lista,
                        "lista_fecha_publicacion"=>$lista_fecha_publicacion,
                        "lista_acciones"=>$lista_acciones
                        ]
                    );
    }
 
    public function voto_particular_ajax( Request $request, $accion){
        if($accion=="cargarDocumentos"){

            $input = $request->all();

            $plantilla_archivo_body=print_r($input, true);
            $plantilla_archivo_header='';
            
            $plantilla_archivo_header='<h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Voto Particular</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>';
            $plantilla_archivo_body='
            <form method="POST" id="forma_voto_particuar"  enctype="multipart/form-data"> 
            
                <div class="media-body table-responsive-xl" style="">
                    <input type="hidden" id="id_acuerdo" name="id_acuerdo" value="'.$input['id_acuerdo'].'">
                    <input type="hidden" id="id_juicio" name="id_juicio" value="'.$input['id_juicio'].'">
                    <input type="hidden" id="index" name="index" value="'.$input['index'].'">
                    <div class="row no-gutters">
                        <h5 class="card-profile-name">Selecciona el tipo de firma</h5>
                        <p class="card-profile-position">
                        <div class="row col-lg-12" id="">
                            <div class="col-lg-4">
                                <label class="rdiobox">
                                  <input name="tipo_firma_firel_voto" type="radio" id="tipo_firma_firel" value="firel" checked onclick="seleccionarCredenciales(\'firel\')">
                                  <span>Firel</span> 
                                </label>
                              </div><!-- col-3 -->
                              <div class="col-lg-4 mg-t-20 mg-lg-t-0">
                                <label class="rdiobox">
                                  <input name="tipo_firma_firel_voto" type="radio" id="tipo_firma_firel" value="fiel" onclick="seleccionarCredenciales(\'fiel\')">
                                  <span>E.Firma</span>
                                </label>
                              </div><!-- col-3 -->
                              <div class="col-lg-4 mg-t-20 mg-lg-t-0">
                                <label class="rdiobox">
                                  <input name="tipo_firma_firel_voto" type="radio" id="tipo_firma_firel" value="sello_sigj" onclick="seleccionarCredenciales(\'sello_sigj\')">
                                  <span>Sello SIGJ</span>
                                </label>
                              </div><!-- col-3 -->
                        </div>
                        <hr>

                        <div class="col-lg-12" id="id_pfx">
                            <div class="form-group">
                                <label class="form-control-label" ><span class="tx-danger">*</span> Archivo PFX:</label>
                                <div id="div_upload" class="field"  >
                                    <input class="btn btn-oblong btn-outline-primary" type="file" name="archivo_pfx_voto" id="archivo_pfx" size="50"  accept=".pfx">
                                </div>
                            </div>
                        </div><!-- col-2 -->


                        <div class="col-lg-12" id="id_key" style="display: none;">
                            <div class="form-group">
                                <label class="form-control-label" ><span class="tx-danger">*</span> Archivo KEY:</label>
                                <div id="div_upload" class="field"  >
                                    <input class="btn btn-oblong btn-outline-primary" type="file" name="archivo_key_voto" id="archivo_key" size="50"  accept=".key">
                                </div>
                            </div>
                        </div><!-- col-2 -->
                        <div class="col-lg-12" id="id_cert" style="display: none;">
                            <div class="form-group">
                                <label class="form-control-label" ><span class="tx-danger">*</span> Archivo CER:</label>
                                <div id="div_upload" class="field"  >
                                    <input class="btn btn-oblong btn-outline-primary" type="file" name="archivo_cer_voto" id="archivo_cer" size="50"  accept=".cer">
                                </div>
                            </div>
                        </div><!-- col-2 -->
                        <div class="col-lg-12" id="id_contrasenia">
                            <div class="form-group">
                                <label class="form-control-label">Contraseña: <span class="tx-danger">*</span></label>
                                <input class="form-control" type="text" name="password_voto" value="" placeholder="" required>
                            </div>
                        </div>
                        <h5 class="card-profile-name"><br><br>Documento Voto Particular</h5>
                        <div class="col-12 col-sm-12 p-t-10" style="">
                            <div class="col-lg-12" >
                                <div class="form-group">
                                <input type="hidden" value="localFile" id="localFile" name="uploadType">
                                <label class="form-control-label" ><span class="tx-danger">*</span> Documento Voto Particular:</label>
                                    <div id="div_upload" class="field"  >
                                    <input class="btn btn-oblong btn-outline-primary" type="file" name="archivo_acuerdo_voto" id="archivo_acuerdo" size="50" required accept=".doc, .docx">
                                    </div>
                                </div>
                            </div><!-- col-2 -->
                        </div><!-- col-8 -->
                    </div><!-- row -->
                    <br>
                    <button class="btn btn-success btn-block mg-b-10" type="button" onclick="procesarVotoParticular('.$input['index'].')">Subir voto particular</button>
                </div><!-- form-layout -->
            </form>
            <script>
            function procesarVotoParticular(index){

                if(confirm("Esta seguro de subir el documento?")){
                    //manejo de modales
                    $("#modaldemo3").modal("hide");
                    $("#modal_loading").modal({backdrop: "static", keyboard: false});
        
                    jQuery.ajax({
                        type: "POST",
                        url:"/bandejas/votoParticular/subirDocumento",
                        data: new FormData($("#forma_voto_particuar")[0]),
                        processData: false, 
                        contentType: false, 
                        success: function(data) {
                            console.log(data);

                            setTimeout(function(){
                                $("#modal_loading").modal("hide");
                            }, 500);
                            
                             if(data.status!=0){
                                if(data.response.finalizacion_flujo=="si"){
                                    alert("La fecha de publicación es: " + data.response.fecha_a_publicar);
                                }

                                $("#bandejas_sicor").find("#firma").html($("#bandejas_sicor").find("#firma").html()-1);
                                $("#datatable1").find(".data-row-id-"+index).fadeOut("slow", function($row){
                                    dataTableGlobal.rows(index).remove().draw();
                                });
                            }
                        }
                    });
                }
            }

            $(\'input[type="file"]\').on("change", function(){
                var ext = $( this ).val().split(".").pop();
                if ($( this ).val() != "") {
                    if(ext == "doc" || ext == "docx"){ }
                    else{
                        //alert("Extensión no permitida: " + ext);
                    }
                }
            });
            </script>';
            return response()->json(['plantilla_archivo_header'=>$plantilla_archivo_header, 'plantilla_archivo_body'=>$plantilla_archivo_body]);
        }
        else if($accion=="subirDocumento"){
            
            $input = $request->all();
            $bandera=0;
            $url_pfx=$url_cer=$url_key="";
            

            if($input['tipo_firma_firel_voto']=='firel'){
                if($request->archivo_pfx_voto->isValid()){
                    $url_pfx=$request->archivo_pfx_voto->store('private');
                    $bandera=1;
                }
            }
            else if($input['tipo_firma_firel_voto']=='fiel'){
                if($request->archivo_key_voto->isValid()){
                    $url_key=$request->archivo_key_voto->store('private');
                    $bandera=1;
                }
                else{
                    $bandera=0;
                }
                if($request->archivo_cer_voto->isValid()){
                    $url_cer=$request->archivo_cer_voto->store('private');
                    $bandera=1;
                }
                else{
                    $bandera=0;
                }
            }
            else{
                $bandera=1;
            }
            

            //$url_pfx="private/4Epg9JN1hqxtt5brpRYuRcEpM7YJm6jGmqdLeDhN.bin";

            if($bandera==1){


                //se guarda el archivo
                $url_file="";
                $extension_word="";
                $docuemntoPDF="";
                if($request->archivo_acuerdo_voto->isValid()){
                    //$url_file=$request->archivo_acuerdo->store('firmados');
                    $url_file=$request->archivo_acuerdo_voto->store('porfirmar');
                    $extension_word = pathinfo(storage_path($url_file), PATHINFO_EXTENSION);
                    $datos_archvios[]='/san/www/html/sicor_extendido_80/storage/app/'.$url_file;    
                    $doc_arr=bandejas::documento_convertir_pdf($datos_archvios);
                    $docuemntoPDF=$doc_arr['file'];
 
                    
                }
                if($docuemntoPDF!=""){
                    //se firma con la firel
                    if($input['tipo_firma_firel_voto']=='firel'){
                        $documentoCER='/san/www/html/sicor_extendido_80/storage/app/'.$url_pfx;
                        $pdfFirmado=bandejas::obtener_firma_firel_acuerdo($docuemntoPDF, $documentoCER, "", $input['password_voto']);
                    }
                    else if($input['tipo_firma_firel_voto']=='fiel'){
                        $documentoCER='/san/www/html/sicor_extendido_80/storage/app/'.$url_cer;
                        $documentoKEY='/san/www/html/sicor_extendido_80/storage/app/'.$url_key;
                        $pdfFirmado=bandejas::obtener_firma_firel_acuerdo($docuemntoPDF, $documentoCER, $documentoKEY, $input['password_voto']);
                    }


                    else if($input['tipo_firma_firel_voto']=='firel_tsj'){
                        $documentoCER='/san/www/html/sicor_extendido_80/storage/app/'.$url_pfx;
                        $pdfFirmado=bandejas::obtener_firma_tsjcdmx_acuerdo($docuemntoPDF, $documentoCER, "", $input['password_voto']);
                    }
                    else if($input['tipo_firma_firel_voto']=='fiel_tsj'){
                        $documentoCER='/san/www/html/sicor_extendido_80/storage/app/'.$url_cer;
                        $documentoKEY='/san/www/html/sicor_extendido_80/storage/app/'.$url_key;
                        $pdfFirmado=bandejas::obtener_firma_tsjcdmx_acuerdo($docuemntoPDF, $documentoCER, $documentoKEY, $input['password_voto']);
                    }


                    else{
                        $pdfFirmado['resultado']=1;
                        $b64PDF=chunk_split(base64_encode(file_get_contents($docuemntoPDF, "r")));
                        $pdfFirmado['documento']=$b64PDF;
                    }

                    if($pdfFirmado['resultado']==1){

                        //se envia al storage
                        $b64Doc='-';
                        for($i=0; $i<110; $i++){
                            $b64Doc.='-';
                        }

                        $lista_voto=bandejas::voto_particular($request, $input['id_juicio'], $input['id_acuerdo'], 'doc_inicial', $pdfFirmado['documento'], $b64Doc);
                        
                        //se avanza la firma
                        if($lista_voto['status']!=0){
                            $lista=bandejas::bandeja_avanzar_revision($request, $input['id_acuerdo']);
                            return response()->json($lista);
                        }
                        else{
                            unset($datos);
                            $datos['response']=0;
                            $datos['error']='Error al convertir al subir el documento';
                            return response()->json($datos);
                        }
                    }
                }
                else{

                    unset($datos);
                    $datos['response']=0;
                    $datos['error']='Error al convertir a PDF';
                    return response()->json($datos);
                }
            }
            else{
                unset($datos);
                $datos['response']=0;
                $datos['error']='Error al firmar';
                return response()->json($datos);
            }
        }
    }

    public function buscar_listado_proxima_publicacion( Request $request){

        $input = $request->all();
        //return response()->json($input);
        unset($datos);
        
        ($input['toca']=="-") ? $datos['toca']="" : $datos['toca']=$input['toca'];
        ($input['anio_toca']=="0") ? $datos['anio_toca']="" : $datos['anio_toca']=$input['anio_toca'];
        ($input['asunto_toca']=="-") ? $datos['asunto_toca']="" : $datos['asunto_toca']=$input['asunto_toca'];
        ($input['fecha_desde']=="-") ? $datos['registrado_desde']="" : $datos['registrado_desde']=$input['fecha_desde'];
        ($input['fecha_hasta']=="-") ? $datos['registrado_hasta']="" : $datos['registrado_hasta']=$input['fecha_hasta'];


        //return response()->json($datos);
        $lista=bandejas::obtener_listado_proxima_publicacion($request, $datos, '');
        
        $humanRelativeDate = new humanRelativeDate();
        if(isset($lista['response'][0]['fecha_publicacion'])){
            for($i=0; $i<count($lista['response']); $i++){


                $fechaCreacion=$humanRelativeDate->getTextForSQLDate($lista['response'][$i]['fecha_publicacion']);
                $lista['response'][$i]['fecha_humana']=$fechaCreacion;
                
            }
        }
        return response()->json($lista);
    }

    public function buscar_listado_busquda_publicacion( Request $request){

        $input = $request->all();
        //return response()->json($input);
        unset($datos);
        
        ($input['toca']=="-") ? $datos['toca']="" : $datos['toca']=$input['toca'];
        ($input['anio_toca']=="0") ? $datos['anio_toca']="" : $datos['anio_toca']=$input['anio_toca'];
        ($input['asunto_toca']=="-") ? $datos['asunto_toca']="" : $datos['asunto_toca']=$input['asunto_toca'];
        ($input['fecha_desde']=="-") ? $datos['registrado_desde']="" : $datos['registrado_desde']=$input['fecha_desde'];
        ($input['fecha_hasta']=="-") ? $datos['registrado_hasta']="" : $datos['registrado_hasta']=$input['fecha_hasta'];


        //return response()->json($datos);
        $lista=bandejas::obtener_listado_proxima_publicacion($request, $datos, 'si');
        
        $humanRelativeDate = new humanRelativeDate();
        if(isset($lista['response'][0]['fecha_publicacion'])){
            for($i=0; $i<count($lista['response']); $i++){


                $fechaCreacion=$humanRelativeDate->getTextForSQLDate($lista['response'][$i]['fecha_publicacion']);
                $lista['response'][$i]['fecha_humana']=$fechaCreacion;
                
            }
        }
        return response()->json($lista);
    }
    
    public function bandeja_avanzar_revision_ajax( Request $request ){

        //$input['id_acuerdo']="1592971536";
        //$input['codigo_organo']="1PIF";
        //$input['ultima_version']="205";
        $input = $request->all();
        $proceso = rand(100, 999);
        $version_sello = 0;




        if($request->session()->get('juzgado_tipo')=='sala'){
            $lista=bandejas::bandeja_avanzar_revision($request, $input['id_acuerdo']);
            $lista_return=$lista;
        }
        else{
            if($input['accion']=="avance"){

                $lista=bandejas::bandeja_avanzar_revision_juzgado($request, $input['id_acuerdo'], 'firmado', '');
                $lista_return=$lista;
            }
            else{
                $lista=bandejas::bandeja_avanzar_revision_juzgado($request, $input['id_acuerdo'], 'corregido', 'sello_sigj');
                $lista_return=$lista;
            }
        }

        if($lista['response']['finalizacion_flujo']=='si' and $lista['response']['tipo_firma_finalizacion']=='sicor'){

            if($input['tipo_flujo_nombre']!="MPSD"){
                //$lista_flujo=acuerdos::consulta_flujo_detalles($request, $input['id_acuerdo']);
                //$ultima_version=$lista_flujo['response']['ultima_version_id'];

                $lista_flujo=acuerdos::obtener_ultima_version_acuerdo($request, $input['id_acuerdo']);
                if($lista_flujo['status']!=100){
                    return $lista_flujo;
                }
                $ultima_version=$lista_flujo['response'];

                 //se obtiene la info del acuerdo
                $lista_acuerdos=acuerdos::obtener_archivo_acuerdo($request, $input['id_juicio'], $input['id_acuerdo']);
                //si existe la version sello
                if(isset($lista_acuerdos['response'][0]['version_sello'])){
                    $version_sello=$lista_acuerdos['response'][0]['version_sello'];
                }

                $lista_return['lista_acuerdos']=$lista_acuerdos;

                
                //se obtiene la firma
                $lista_txt_firma=bandejas::obtener_firma_sicor_acuerdo($request, $input['id_acuerdo'], $input['codigo_organo']);
                Storage::put('firmados/firma.txt', utf8_decode($lista_txt_firma['response']));
                Storage::put('firmados/firma_voto.txt', utf8_decode($lista_txt_firma['response_voto']));
                Storage::put('firmados/id_mide.txt', utf8_decode($lista_txt_firma['id_mide']));

                //se descarga la ultma version
                $lista_archivos=bandejas::documento_descargar($request, $input['id_acuerdo'], $input['codigo_organo'], $ultima_version, 'pdf');
                $docuemntoPDF=$lista_archivos['response'];
                
                //se guarda en la carpeta
                $url_firma='/san/www/html/sicor_extendido_80/storage/app/firmados/documento_firmado_'.$input['codigo_organo'].'_'.$input['id_acuerdo'].'.pdf';
                $lista_return['url_firma']=$url_firma;

                $url = $docuemntoPDF;
                $source = file_get_contents($url);
                file_put_contents($url_firma, $source);

                //se manda a firmar
                $datos_archivo[]=$url_firma;
                //$lista_firma=bandejas::documento_convertir_pdf($datos_archivo);


                //se pone el dato del boletin judicial
                $id_acuerdo_padre=$input['id_acuerdo'];
                $id_acuerdo_boletin=$input['id_acuerdo'];
                if(isset($lista_acuerdos['response'][0]['acuerdo_copia_de'])){
                    $id_acuerdo_padre=$lista_acuerdos['response'][0]['acuerdo_copia_de'];
                }
                $url_temporal_boletin=$url_firma;


                $output = shell_exec("pdfinfo ".$url_temporal_boletin);
                preg_match('/Pages:\s+([0-9]+)/', $output, $pagecountmatches);
                $pagecount = $pagecountmatches[1];


                $lista_fecha_publicacion=agendas::obtener_tiempo_disponible($request);
                $lista_fecha_resolucion=agendas::calcular_dias($request, $lista_fecha_publicacion['response_publicacion'], 1, "no");
                $lista_fecha_resolucion_1=agendas::calcular_dias($request, $lista_fecha_publicacion['response_publicacion'], 1, "no");
                $lista_num_boletin=elementos_boletin::calculo_numero_boletin($request, $lista_fecha_publicacion['response_publicacion']);
                $arr_num_firas=archivos::numero_firmas_acuerdo($request, $request->session()->get('usuario_juzgado'), $id_acuerdo_padre);

                //utilidades::crearQR($request, 'isra', 'isra');

                $num_firmas_sigj=0;
                if(isset($arr_num_firas['response_data'])){
                    for($i=0; $i<count($arr_num_firas['response_data']); $i++){
                        if($arr_num_firas['response_data'][$i]['flujo_sala_tipo_firma']=='sello_sigj'){
                            $num_firmas_sigj=$arr_num_firas['response_data'][$i]['numero'];
                        }
                    }
                }

                $lista_return['arr_num_firas']=$arr_num_firas;
                
                $num_firmas_boletin=$arr_num_firas['response']-$num_firmas_sigj;
                $resta_sello_boletin=$pagecount-$num_firmas_boletin;


                $lista_return['num_firmas_boletin/arr_num_firas/num_firmas_sigj']=$num_firmas_boletin . ' ' . $pagecount. ' ' .  $num_firmas_sigj;

                unset($datos);
                $datos['fecha_resolucion']=$lista_fecha_publicacion['response_publicacion'];
                $datos['fecha_publicacion']=$lista_fecha_resolucion_1['response'];
                $datos['num_boletin']=$lista_num_boletin['response']['numero'];
        


                if($version_sello==1){
                    $url_boletin=archivos::generarSelloLibroGobMalaPublicacion_v1($request, $url_temporal_boletin, $id_acuerdo_boletin, $datos);
                    //$num_firmas_boletin=$num_firmas_boletin-1;
                }
                else if($version_sello==2){
                    $url_boletin=archivos::generarSelloLibroGobMalaPublicacion_v2($request, $url_temporal_boletin, $id_acuerdo_boletin, $datos);
                    //$num_firmas_boletin=$num_firmas_boletin-1;
                }
                else{
                    $url_boletin=archivos::generarSelloLibroGobMalaPublicacion($request, $url_temporal_boletin, $id_acuerdo_boletin, $datos);
                }
                

                $lista_return['url_boletin']=$url_boletin;


                $url_unidos=$url_temporal_boletin;
                $url_separados=public_path('temporales')."/doc_firmado_".$proceso."_".$id_acuerdo_boletin."_";
                $url_separados_comodin=public_path('temporales')."/doc_firmado_".$proceso."_".$id_acuerdo_boletin."_%04d.pdf";
        
                $shell_burst="pdftk ".$url_unidos." burst output ".$url_separados_comodin;
                //print($shell_burst.'<br>');
                $output = shell_exec($shell_burst);
                //print($output);
        
                if($pagecount==1){
                    copy($url_unidos, $url_separados.'0001.pdf');
                    $resta_sello_boletin=1;
                }
                

                $file_original=public_path('temporales')."/doc_firmado_".$proceso."_".$id_acuerdo_boletin."_".(utilidades::acomodarCeros($resta_sello_boletin, 4)).".pdf";
                $file_sustituir=public_path('temporales')."/doc_sello_firmado_".$proceso."_".$id_acuerdo_boletin."_".(utilidades::acomodarCeros($resta_sello_boletin, 4)).".pdf";
                
                //se copia para hacer el sellado
                copy($file_original, $file_sustituir);
        
                $shell_multistamp="pdftk $file_sustituir multistamp $url_boletin output $file_original";
                //print($shell_multistamp.'<br>');
                $output = shell_exec($shell_multistamp);
                
        
                $shell_cat="pdftk $url_separados*.pdf cat output $url_unidos";
                //print($shell_cat.'<br>');
                $output = shell_exec($shell_cat);

               
                $lista_return['shell_cat']=$shell_cat;


                

                //se envia al storage
                $b64Doc = chunk_split(base64_encode(file_get_contents($datos_archivo[0])));
                $b64PDF = chunk_split(base64_encode(file_get_contents($url_unidos)));
                $extension_word='docx';
                $lista_subir=bandejas::subir_documentos_flujo($request, $input['id_acuerdo'], $input['codigo_organo'], $lista['response']['id_flujo_participante'], $b64Doc, $extension_word, $b64PDF);
            }
            //dd($lista_return);
            /*if(isset($input['index'])){
                $lista['index']=$input['index'];
            }*/
            return response()->json($lista_return);
        }
        else if($input['bandeja']=='firma' and $lista['response']['tipo_firma_finalizacion']=='firel'){

            return response()->json($lista_return);
        }


        if(isset($input['index'])){
            $lista_return['index']=$input['index'];
        }
        return response()->json($lista_return);
    }

    public function bandeja_retroceso_revision_ajax( Request $request ){

        $input = $request->all();
        $proceso = rand(100, 999);
        $version_sello=0;
        
        //se obtiene la info del acuerdo
        $lista_acuerdos=acuerdos::obtener_archivo_acuerdo($request, $input['id_juicio'], $input['id_acuerdo']);
        //si existe la version sello
        if(isset($lista_acuerdos['response'][0]['version_sello'])){
            $version_sello=$lista_acuerdos['response'][0]['version_sello'];
        }
    
        //se consulta el utimo documento
        //$lista_flujo=acuerdos::consulta_flujo_detalles($request, $input['id_acuerdo']);
        //$ultima_version=$lista_flujo['response']['ultima_version_id'];

        $lista_flujo=acuerdos::obtener_ultima_version_acuerdo($request, $input['id_acuerdo']);
        if($lista_flujo['status']!=100){
            return $lista_flujo;
        }
        $ultima_version=$lista_flujo['response'];

        //se documento fuente
        if($lista_acuerdos['response'][0]['extension']=='.html'){
            $lista_doc=bandejas::documento_descargar($request, $input['id_acuerdo'], $input['codigo_organo'], $ultima_version, 'html');            
            $extension_final='html';

            if(!isset($lista_doc['response'])){
                return response()->json($lista_doc);
            }

            $docuemntoFuente=$lista_doc['response'];

            //se copia a local
            Storage::put('temporales/documento.html', file_get_contents($lista_doc['response']));
            //se guarda el juzgado
            Storage::put('firmados/juzgado_nombre.txt', ucwords(strtolower($request->session()->get('juzgado_nombre_largo'))));

            //convertimos
            $datos_archvios[]='/san/www/html/sicor_extendido_80/storage/app/temporales/documento.html';
            $doc_arr=bandejas::documento_convertir_html_pdf($datos_archvios);


            //subimos
            $b64Doc = chunk_split(base64_encode(file_get_contents($lista_doc['response'])));
            $b64PDF = chunk_split(base64_encode(file_get_contents($doc_arr['file'])));

        }
        else{
            $lista_doc=bandejas::documento_descargar($request, $input['id_acuerdo'], $input['codigo_organo'], $ultima_version, 'word');            
            if(!isset($lista_doc['response'])){
                return response()->json($lista_doc);
            }
            $docuemntoFuente=$lista_doc['response'];
            $extension_final='docx';

            //se copia a local
            $extension_word = pathinfo(storage_path($docuemntoFuente), PATHINFO_EXTENSION);
            Storage::put('porfirmar/documento.'.$extension_word, file_get_contents($docuemntoFuente));            
            $datos_archvios[]='/san/www/html/sicor_extendido_80/storage/app/porfirmar/documento.'.$extension_word;    
            //se convierte a pdf
            $doc_arr=bandejas::documento_convertir_pdf($datos_archvios);


        }

        if($version_sello==1){
            //$proceso = rand(100, 999);
            //$doc_arr['file']='/san/www/html/sicor_extendido_80/public/temporales/rpt_ml817g_e/unidos.pdf';
            //$request['id_juicio']='1599842277';
            $id_acuerdo_nuevo=$input['id_juicio'];
            $url_boletin=archivos::generarSelloLibroGob_v1($request, $doc_arr['file'], $id_acuerdo_nuevo);

            $output = shell_exec("pdfinfo ".$doc_arr['file']);
            preg_match('/Pages:\s+([0-9]+)/', $output, $pagecountmatches);
            $pagecount = $pagecountmatches[1];
            //print_r($pagecount);
            utilidades::guardarLog($request, 'subir_acuerdo_juzgado', $proceso, 0, "Se empieza con el sello del boletin judicial, numero hojas:" .  $pagecount);


            //se divide el documento
            $url_separados=public_path('temporales')."/doc_firmado_".$proceso."_".$id_acuerdo_nuevo."_";
            $url_separados_comodin=public_path('temporales')."/doc_firmado_".$proceso."_".$id_acuerdo_nuevo."_%04d.pdf";

            $shell_burst="pdftk ".$doc_arr['file']." burst output ".$url_separados_comodin;
            utilidades::guardarLog($request, 'subir_acuerdo_juzgado', $proceso, 0, "shell_burst " . $shell_burst);
            $output = shell_exec($shell_burst);
            utilidades::guardarLog($request, 'subir_acuerdo_juzgado', $proceso, 0, "shell_burst output" . $output);
            
            $file_original=public_path('temporales')."/doc_firmado_".$proceso."_".$id_acuerdo_nuevo."_".(utilidades::acomodarCeros($pagecount, 4)).".pdf";
            $file_sustituir=public_path('temporales')."/doc_sello_firmado_".$proceso."_".$id_acuerdo_nuevo."_".(utilidades::acomodarCeros($pagecount, 4)).".pdf";

            //se copia para hacer el sellado
            copy($file_original, $file_sustituir);

            $shell_multistamp="pdftk $file_sustituir multistamp $url_boletin output $file_original";
            utilidades::guardarLog($request, 'subir_acuerdo_juzgado', $proceso, 0, "shell_multistamp " . $shell_multistamp);
            //print($shell_multistamp.'<br>');
            $output = shell_exec($shell_multistamp);
            utilidades::guardarLog($request, 'subir_acuerdo_juzgado', $proceso, 0, "shell_multistamp output" . $output);


            $shell_cat="pdftk $url_separados*.pdf cat output ".$doc_arr['file'];
            utilidades::guardarLog($request, 'subir_acuerdo_juzgado', $proceso, 0, "shell_cat " . $shell_cat);
            //print($shell_cat.'<br>');
            $output = shell_exec($shell_cat);
            utilidades::guardarLog($request, 'subir_acuerdo_juzgado', $proceso, 0, "shell_cat output" . $output);

            copy($doc_arr['file'], '/san/www/html/sicor_extendido_80/public/'.$doc_arr['url']);

        }
        else if($version_sello==2){
            //$proceso = rand(100, 999);
            //$doc_arr['file']='/san/www/html/sicor_extendido_80/public/temporales/rpt_ml817g_e/unidos.pdf';
            //$request['id_juicio']='1599842277';
            $id_acuerdo_nuevo=$input['id_juicio'];
            $url_boletin=archivos::generarSelloLibroGob_v2($request, $doc_arr['file'], $id_acuerdo_nuevo);

            $output = shell_exec("pdfinfo ".$doc_arr['file']);
            preg_match('/Pages:\s+([0-9]+)/', $output, $pagecountmatches);
            $pagecount = $pagecountmatches[1];
            //print_r($pagecount);
            utilidades::guardarLog($request, 'subir_acuerdo_juzgado', $proceso, 0, "Se empieza con el sello del boletin judicial, numero hojas:" .  $pagecount);


            //se divide el documento
            $url_separados=public_path('temporales')."/doc_firmado_".$proceso."_".$id_acuerdo_nuevo."_";
            $url_separados_comodin=public_path('temporales')."/doc_firmado_".$proceso."_".$id_acuerdo_nuevo."_%04d.pdf";

            $shell_burst="pdftk ".$doc_arr['file']." burst output ".$url_separados_comodin;
            utilidades::guardarLog($request, 'subir_acuerdo_juzgado', $proceso, 0, "shell_burst " . $shell_burst);
            $output = shell_exec($shell_burst);
            utilidades::guardarLog($request, 'subir_acuerdo_juzgado', $proceso, 0, "shell_burst output" . $output);
            
            $file_original=public_path('temporales')."/doc_firmado_".$proceso."_".$id_acuerdo_nuevo."_".(utilidades::acomodarCeros($pagecount, 4)).".pdf";
            $file_sustituir=public_path('temporales')."/doc_sello_firmado_".$proceso."_".$id_acuerdo_nuevo."_".(utilidades::acomodarCeros($pagecount, 4)).".pdf";

            //se copia para hacer el sellado
            copy($file_original, $file_sustituir);

            $shell_multistamp="pdftk $file_sustituir multistamp $url_boletin output $file_original";
            utilidades::guardarLog($request, 'subir_acuerdo_juzgado', $proceso, 0, "shell_multistamp " . $shell_multistamp);
            //print($shell_multistamp.'<br>');
            $output = shell_exec($shell_multistamp);
            utilidades::guardarLog($request, 'subir_acuerdo_juzgado', $proceso, 0, "shell_multistamp output" . $output);


            $shell_cat="pdftk $url_separados*.pdf cat output ".$doc_arr['file'];
            utilidades::guardarLog($request, 'subir_acuerdo_juzgado', $proceso, 0, "shell_cat " . $shell_cat);
            //print($shell_cat.'<br>');
            $output = shell_exec($shell_cat);
            utilidades::guardarLog($request, 'subir_acuerdo_juzgado', $proceso, 0, "shell_cat output" . $output);

            copy($doc_arr['file'], '/san/www/html/sicor_extendido_80/public/'.$doc_arr['url']);

        }
        else{

            $url_boletin=archivos::generarSelloLibroGob($request, $doc_arr['file'], $input['id_juicio']);
            //se cose el boletin
            $arr_doc_boletin=[];
            $arr_doc_boletin[]=$doc_arr['file'];
            $arr_doc_boletin[]=$url_boletin;
            $lista_cosidos=bandejas::documento_coser_pdf($arr_doc_boletin);
            $doc_arr['file']=public_path().$lista_cosidos['file'];
            $doc_arr['url']=$lista_cosidos['file'];
        }


        //subimos
        $b64Doc = chunk_split(base64_encode(file_get_contents($docuemntoFuente)));
        $b64PDF = chunk_split(base64_encode(file_get_contents($doc_arr['file'])));



        if($request->entorno["variables_entorno"]["MIFIRMA_PRODUCCION"]==1){
            //se envia al WS del tsj
            $lista_subir_tsj=bandejas::subir_documento_firma_tsjcdmx($request, $doc_arr['file'], "");
            
            unset($datos);
            $datos['acuerdo_id']=$request['id_acuerdo'];
            $datos['llaves_documento_firma']=$lista_subir_tsj['subirArchivoResult']['identificadorDocumento'];
            $lista1=acuerdos::guardar_acuerdo_firma_tsj($datos, $request);
        }


        if($request->session()->get('juzgado_tipo')=='sala'){
            $lista=bandejas::bandeja_retroceso_revision($request, $input['id_acuerdo']);
            $lista_subir=bandejas::subir_documentos_flujo($request, $input['id_acuerdo'], $input['codigo_organo'], $lista['response']['id_flujo_participante'], $b64Doc, $extension_final, $b64PDF);
        }
        else{
            $lista=bandejas::bandeja_retroceso_revision_juzgado($request, $input['id_acuerdo']);
            $lista_subir=bandejas::subir_documentos_flujo($request, $input['id_acuerdo'], $input['codigo_organo'], $lista['response']['id_flujo_participante'], $b64Doc, $extension_final, $b64PDF);
        }
        return response()->json($lista);
    }

    public function documento_descargar_ajax( Request $request ){

        $input = $request->all();

        //$lista_flujo=acuerdos::consulta_flujo_detalles($request, $input['id_acuerdo']);

        $lista_flujo=acuerdos::obtener_ultima_version_acuerdo($request, $input['id_acuerdo']);
        if($lista_flujo['status']!=100){
            return $lista_flujo;
        }
        //$ultima_version=$lista_flujo['response'];


        if(isset($lista_flujo['response'])){
            $ultima_version=$lista_flujo['response'];
        }
        else{
            $ultima_version=$input['id_documento'];
        }


        $lista=bandejas::documento_descargar($request, $input['id_acuerdo'], $input['ponencia'], $ultima_version, $input['tipo_documento']);

        if(isset($input['copia'])){
            if($lista['status']==100){
                copy($lista['response'], '/san/www/html/sicor_extendido_80/public/temporales/pdf_tmp_'.$input['id_acuerdo'].'_'.$input['ponencia'].'.pdf');
                $lista['response']='/temporales/pdf_tmp_'.$input['id_acuerdo'].'_'.$input['ponencia'].'.pdf';
            }
        }

        return response()->json($lista);
    }

    public function documento_descargar_ajax_sinse( Request $request ){

        $input = $request->all();

        //$lista_flujo=acuerdos::consulta_flujo_detalles($request, $input['id_acuerdo']);

        $lista=bandejas::documento_descargar_sicor($request, $input['id_acuerdo'], $input['ponencia'], $input['id_documento'], $input['tipo_documento']);

        if(isset($input['copia'])){
            if($lista['status']==100){
                copy($lista['response'], '/san/www/html/sicor_extendido_80/public/temporales/pdf_tmp_'.$input['id_acuerdo'].'_'.$input['ponencia'].'.pdf');
                $lista['response']='/temporales/pdf_tmp_'.$input['id_acuerdo'].'_'.$input['ponencia'].'.pdf';
            }
        }

        return response()->json($lista);
    }

    public function mostrar_editor_HTML( Request $request ){
        $input = $request->all();

        //se pone la plantilla
        $plantilla_archivo_body="";
        $plantilla_archivo_header='';
        $contenido="";
        if($input['tipo']=="acuerdo"){

            //se investiga que no hayan firmado
            if($input['bandeja']=='firma'){
                $lista_firma="";
            }
            //$lista_flujo=acuerdos::consulta_flujo_detalles($request, $input['id_acuerdo']);
            //$ultima_version=$lista_flujo['response']['ultima_version_id'];

            $lista_flujo=acuerdos::obtener_ultima_version_acuerdo($request, $input['id_acuerdo']);
            if($lista_flujo['status']!=100){
                return $lista_flujo;
            }
            $ultima_version=$lista_flujo['response'];

            

            $lista=bandejas::documento_descargar($request, $input['id_acuerdo'], $input['ponencia'], $ultima_version, 'html');
            $contenido=file_get_contents($lista['response']);
        }

        $plantilla_archivo_body=print_r($lista_flujo, true);

        include "plantilla_editor_html.php"; 
        return response()->json(['plantilla_archivo_header'=>$plantilla_archivo_header, 'plantilla_archivo_body'=>$plantilla_archivo_body]);
    }

    public function guardar_editor_HTML( Request $request ){


        $input = $request->all();
        $proceso = rand(100, 999);
        $version_sello=0;

        if($input['tipo']=='acuerdo'){
            Storage::put('porfirmar/documento_'.$proceso.'.html', '<body>'.$input['documento_html'].'</body>');
            //se guarda el juzgado
            Storage::put('firmados/juzgado_nombre.txt', ucwords(strtolower($request->session()->get('juzgado_nombre_largo'))));

            //se manda a convertir a PDF
            $datos_archvios[]='/san/www/html/sicor_extendido_80/storage/app/porfirmar/documento_'.$proceso.'.html';
            $doc_arr=bandejas::documento_convertir_html_pdf($datos_archvios);

            if($doc_arr['file']=="0"){
                unset($datos);
                $datos['status']="0";
                $datos['file']='Problemas con las imporesoras HTML. Favor de consultar con soporte';
                return $datos;
            }

            $lista_acuerdos=acuerdos::obtener_archivo_acuerdo($request, $input['id_juicio'], $input['id_acuerdo']);
            if(isset($lista_acuerdos['response'][0]['version_sello'])){
                $version_sello=$lista_acuerdos['response'][0]['version_sello'];
            }


            if($version_sello==1){
                //$proceso = rand(100, 999);
                //$doc_arr['file']='/san/www/html/sicor_extendido_80/public/temporales/rpt_ml817g_e/unidos.pdf';
                //$request['id_juicio']='1599842277';
                $id_acuerdo_nuevo=$request['id_acuerdo'];
                $url_boletin=archivos::generarSelloLibroGob_v1($request, $doc_arr['file'], $id_acuerdo_nuevo);
    
                $output = shell_exec("pdfinfo ".$doc_arr['file']);
                preg_match('/Pages:\s+([0-9]+)/', $output, $pagecountmatches);
                $pagecount = $pagecountmatches[1];
                //print_r($pagecount);
                utilidades::guardarLog($request, 'subir_acuerdo_juzgado', $proceso, 0, "Se empieza con el sello del boletin judicial, numero hojas:" .  $pagecount);
    
    
                //se divide el documento
                $url_separados=public_path('temporales')."/doc_firmado_".$proceso."_".$id_acuerdo_nuevo."_";
                $url_separados_comodin=public_path('temporales')."/doc_firmado_".$proceso."_".$id_acuerdo_nuevo."_%04d.pdf";
    
                $shell_burst="pdftk ".$doc_arr['file']." burst output ".$url_separados_comodin;
                utilidades::guardarLog($request, 'subir_acuerdo_juzgado', $proceso, 0, "shell_burst " . $shell_burst);
                $output = shell_exec($shell_burst);
                utilidades::guardarLog($request, 'subir_acuerdo_juzgado', $proceso, 0, "shell_burst output" . $output);
                
                $file_original=public_path('temporales')."/doc_firmado_".$proceso."_".$id_acuerdo_nuevo."_".(utilidades::acomodarCeros($pagecount, 4)).".pdf";
                $file_sustituir=public_path('temporales')."/doc_sello_firmado_".$proceso."_".$id_acuerdo_nuevo."_".(utilidades::acomodarCeros($pagecount, 4)).".pdf";
    
                //se copia para hacer el sellado
                copy($file_original, $file_sustituir);
    
                $shell_multistamp="pdftk $file_sustituir multistamp $url_boletin output $file_original";
                utilidades::guardarLog($request, 'subir_acuerdo_juzgado', $proceso, 0, "shell_multistamp " . $shell_multistamp);
                //print($shell_multistamp.'<br>');
                $output = shell_exec($shell_multistamp);
                utilidades::guardarLog($request, 'subir_acuerdo_juzgado', $proceso, 0, "shell_multistamp output" . $output);
    
    
                $shell_cat="pdftk $url_separados*.pdf cat output ".$doc_arr['file'];
                utilidades::guardarLog($request, 'subir_acuerdo_juzgado', $proceso, 0, "shell_cat " . $shell_cat);
                //print($shell_cat.'<br>');
                $output = shell_exec($shell_cat);
                utilidades::guardarLog($request, 'subir_acuerdo_juzgado', $proceso, 0, "shell_cat output" . $output);

                copy($doc_arr['file'], '/san/www/html/sicor_extendido_80/public/'.$doc_arr['url']);

            }
            else if($version_sello==2){
                //$proceso = rand(100, 999);
                //$doc_arr['file']='/san/www/html/sicor_extendido_80/public/temporales/rpt_ml817g_e/unidos.pdf';
                //$request['id_juicio']='1599842277';
                $id_acuerdo_nuevo=$request['id_acuerdo'];
                $url_boletin=archivos::generarSelloLibroGob_v2($request, $doc_arr['file'], $id_acuerdo_nuevo);
    
                $output = shell_exec("pdfinfo ".$doc_arr['file']);
                preg_match('/Pages:\s+([0-9]+)/', $output, $pagecountmatches);
                $pagecount = $pagecountmatches[1];
                //print_r($pagecount);
                utilidades::guardarLog($request, 'subir_acuerdo_juzgado', $proceso, 0, "Se empieza con el sello del boletin judicial, numero hojas:" .  $pagecount);
    
    
                //se divide el documento
                $url_separados=public_path('temporales')."/doc_firmado_".$proceso."_".$id_acuerdo_nuevo."_";
                $url_separados_comodin=public_path('temporales')."/doc_firmado_".$proceso."_".$id_acuerdo_nuevo."_%04d.pdf";
    
                $shell_burst="pdftk ".$doc_arr['file']." burst output ".$url_separados_comodin;
                utilidades::guardarLog($request, 'subir_acuerdo_juzgado', $proceso, 0, "shell_burst " . $shell_burst);
                $output = shell_exec($shell_burst);
                utilidades::guardarLog($request, 'subir_acuerdo_juzgado', $proceso, 0, "shell_burst output" . $output);
                
                $file_original=public_path('temporales')."/doc_firmado_".$proceso."_".$id_acuerdo_nuevo."_".(utilidades::acomodarCeros($pagecount, 4)).".pdf";
                $file_sustituir=public_path('temporales')."/doc_sello_firmado_".$proceso."_".$id_acuerdo_nuevo."_".(utilidades::acomodarCeros($pagecount, 4)).".pdf";
    
                //se copia para hacer el sellado
                copy($file_original, $file_sustituir);
    
                $shell_multistamp="pdftk $file_sustituir multistamp $url_boletin output $file_original";
                utilidades::guardarLog($request, 'subir_acuerdo_juzgado', $proceso, 0, "shell_multistamp " . $shell_multistamp);
                //print($shell_multistamp.'<br>');
                $output = shell_exec($shell_multistamp);
                utilidades::guardarLog($request, 'subir_acuerdo_juzgado', $proceso, 0, "shell_multistamp output" . $output);
    
    
                $shell_cat="pdftk $url_separados*.pdf cat output ".$doc_arr['file'];
                utilidades::guardarLog($request, 'subir_acuerdo_juzgado', $proceso, 0, "shell_cat " . $shell_cat);
                //print($shell_cat.'<br>');
                $output = shell_exec($shell_cat);
                utilidades::guardarLog($request, 'subir_acuerdo_juzgado', $proceso, 0, "shell_cat output" . $output);

                copy($doc_arr['file'], '/san/www/html/sicor_extendido_80/public/'.$doc_arr['url']);

            }
            else{

                $url_boletin=archivos::generarSelloLibroGob($request, $doc_arr['file'], $request['id_acuerdo']);
                //se cose el boletin
                $arr_doc_boletin=[];
                $arr_doc_boletin[]=$doc_arr['file'];
                $arr_doc_boletin[]=$url_boletin;
                $lista_cosidos=bandejas::documento_coser_pdf($arr_doc_boletin);
                $doc_arr['file']=public_path().$lista_cosidos['file'];
                $doc_arr['url']=$lista_cosidos['file'];
            }

            //$lista_flujo=acuerdos::consulta_flujo_detalles($request, $input['id_acuerdo']);
            //$ultima_version=$lista_flujo['response']['ultima_version_id'];

            if($request->entorno["variables_entorno"]["MIFIRMA_ACTIVO"]==1){
                //se envia al WS del tsj
                $lista_subir_tsj=bandejas::subir_documento_firma_tsjcdmx($request, $doc_arr['file'], "");

                unset($datos);
                $datos['acuerdo_id']=$request['id_acuerdo'];
                $datos['llaves_documento_firma']=$lista_subir_tsj['subirArchivoResult']['identificadorDocumento'];
                $lista1=acuerdos::guardar_acuerdo_firma_tsj($datos, $request);
            }

            $b64Doc = chunk_split(base64_encode(file_get_contents('/san/www/html/sicor_extendido_80/storage/app/porfirmar/documento_'.$proceso.'.html')));
            $b64PDF = chunk_split(base64_encode(file_get_contents($doc_arr['file'])));
                
            $lista_subir=bandejas::subir_documentos_flujo($request, $input['id_acuerdo'], $input['ponencia'], $input['flujo_id'], $b64Doc, 'html', $b64PDF);
            $lista_subir['status']="1";

            return $lista_subir;
        }

        return $input;
    }

    public function documento_descargar_preview_ajax( Request $request ){

        
        $input = $request->all();


        $documentos_arr=explode('-', $input['arr_imprimir']);
        $documentos_arr_final=array();
        for($i=0; $i<count($documentos_arr); $i++){
            if($documentos_arr[$i]!=""){
                $documentos_arr_tmp=explode(',', $documentos_arr[$i]);
                $documentos_arr_final[$i]['acuerdo']=$documentos_arr_tmp[0];
                $documentos_arr_final[$i]['organo']=$documentos_arr_tmp[1];
                $documentos_arr_final[$i]['version']=$documentos_arr_tmp[2];

                //se obtiene la utlma version
                //$lista_flujo=acuerdos::consulta_flujo_detalles($request, $documentos_arr_tmp[0]);
                //$ultima_version=$lista_flujo['response']['ultima_version_id'];

                $lista_flujo=acuerdos::obtener_ultima_version_acuerdo($request, $documentos_arr_tmp[0]);
                if($lista_flujo['status']!=100){
                    return $lista_flujo;
                }
                $ultima_version=$lista_flujo['response'];


                $documentos_arr_final[$i]['version']=$ultima_version;
            }
        }

        $lista=bandejas::documento_descargar_batch($request, $documentos_arr_final[0]['acuerdo'], $documentos_arr_final[0]['organo'], $documentos_arr_final[0]['version'], 'pdf', $documentos_arr_final);

        foreach($lista['response'] as $key => $value){
            $proceso = rand(100, 999);

            $url_final='/var/www/html/sicor_extendido_80/public/temporales/preview_'.$key.'_'.$proceso.'.pdf';
            copy($value[0]['response'], $url_final);

            $lista['response'][$key][0]['response']='/temporales/preview_'.$key.'_'.$proceso.'.pdf';

        }
        return response()->json($lista);
    }

    public function documento_descargar_batch_ajax( Request $request ){

        $input = $request->all();


        $documentos_arr=explode('-', $input['arr_imprimir']);
        $documentos_arr_final=array();
        for($i=0; $i<count($documentos_arr); $i++){
            if($documentos_arr[$i]!=""){
                $documentos_arr_tmp=explode(',', $documentos_arr[$i]);
                if($documentos_arr_tmp[0]!=0){
                    $documentos_arr_final[$i]['acuerdo']=$documentos_arr_tmp[0];
                    $documentos_arr_final[$i]['organo']=$documentos_arr_tmp[1];
                    $documentos_arr_final[$i]['version']=$documentos_arr_tmp[2]; 

                    //se obtiene la utlma version
                    //$lista_flujo=acuerdos::consulta_flujo_detalles($request, $documentos_arr_tmp[0]);

                    $lista_flujo=acuerdos::obtener_ultima_version_acuerdo($request, $documentos_arr_tmp[0]);
                    if($lista_flujo['status']!=100){
                        return $lista_flujo;
                    }

                    
                    if(isset($lista_flujo['response'])){
                        $ultima_version=$lista_flujo['response'];
                        $documentos_arr_final[$i]['version']=$ultima_version;
                    }
                    
                }
            }
        }

        $lista=bandejas::documento_descargar_batch($request, $documentos_arr_final[0]['acuerdo'], $documentos_arr_final[0]['organo'], $documentos_arr_final[0]['version'], 'pdf', $documentos_arr_final);

        //return response()->json($lista);


        if(!isset($lista['response'])){
            return response()->json($lista);
        }
        //return response()->json($lista);

        //se prepara para coser 
        $arr_coser=array();
        $i=0;
        foreach ($lista['response'] as $clave => $valor) {
            if(isset($valor[0]['response'])){
                if($this->url_exists($valor[0]['response'])){
                    $arr_coser[$i]=$valor[0]['response'];
                    $i++;
                }
            }
        }

        if(count($arr_coser)==0){
            $lista['status']=1;
            $lista['message']='No hay documentos válidos.';
            return response()->json($lista);
        }
        
        //se manda a coser
        $lista_coser=bandejas::documento_coser_pdf($arr_coser);
        $lista_coser['status']=100;
        return response()->json($lista_coser);
    }

    public function documento_descargar_batch_ligitante_ajax( Request $request ){

        $input = $request->all();


        $num_cocer=0;
        $documentos_arr=explode('-', $input['arr_imprimir']); 
        $documentos_arr_final=array();
        $num_hojas=0;
        for($i=0; $i<count($documentos_arr); $i++){
            if($documentos_arr[$i]!=""){
                $documentos_arr_tmp=explode(',', $documentos_arr[$i]);
                if($documentos_arr_tmp[0]!=0 and $documentos_arr_tmp[2]!=0){
                    $documentos_arr_final[$i]['acuerdo']=$documentos_arr_tmp[0];
                    $documentos_arr_final[$i]['organo']=$documentos_arr_tmp[1];
                    $documentos_arr_final[$i]['version']=$documentos_arr_tmp[2];

                    //se obtiene la utlma version
                    //$lista_flujo=acuerdos::consulta_flujo_detalles($request, $documentos_arr_tmp[0]);
                    //$ultima_version=$lista_flujo['response']['ultima_version_id'];
                    //$documentos_arr_final[$i]['version']=$ultima_version;


                    //$lista=bandejas::documento_descargar($request, $documentos_arr_final[$i]['acuerdo'], $documentos_arr_final[$i]['organo'], $documentos_arr_final[$i]['version'], 'pdf');
                    $lista=bandejas::documento_descargar_litigante($request, $documentos_arr_final[$i]['acuerdo'], $documentos_arr_final[$i]['organo'], $documentos_arr_final[$i]['version'], 'pdf', $input['sesion_id'], $input['cadena_sesion'], $input['usuario_id']);

                    //return $lista;

                    if(!isset($lista['response'])){
                        return 0;
                    }

                    
                    
                    $url_tmp='/var/www/html/sicor_extendido_80/public/temporales/acuerdo_'.$documentos_arr_final[$i]['acuerdo'].'-'.$num_cocer.'.pdf';
                    copy($lista['response'], $url_tmp);


                    $arr_coser[$num_cocer]=$url_tmp;
                    $num_cocer++;


                }
                //son documentos del gestor
                else{
                    $gestor64=gestorDocumental::getDocGestor($request, $documentos_arr_tmp[2]);

                    if($gestor64['response']==100){
            
                        $pdf = fopen ('/var/www/html/sicor_extendido_80/public/temporales/test_'.$i.'.pdf','w');
                        fwrite ($pdf,$gestor64['pdf']);
                        //close output file
                        fclose ($pdf);
                        
                        $arr_coser[$num_cocer]='/var/www/html/sicor_extendido_80/public/temporales/test_'.$i.'.pdf';
                        $num_cocer++;

                    }
                }
            }
        }

       
        if(count($arr_coser)==0){
            $lista['status']=1;
            $lista['message']='No hay documentos válidos.';
            return response()->json($lista);
        }
        
        //return $arr_coser;

        //se manda a coser
        $lista_coser=bandejas::documento_coser_pdf($arr_coser);
        $lista_coser['status']=100;
        $lista_coser['arr_coser']=$arr_coser;
        return response()->json($lista_coser);
    }

    public function documento_descargar_masivo_expediente_digital_ligitante( Request $request ){

        $input = $request->headers->all();
        $input = $request->all();
        $arr_coser=array();


        $proceso = rand(100, 999);
        

        //return sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf';
        //$input['juicio'][0]=$input['juicio'];
        //$input['usuario-juzgado'][0]=$input['usuario-juzgado'];
        //$input['juzgado-nombre-largo'][0]=$input['juzgado-nombre-largo'];
        
        //$input['arr_imprimir']=$input['arr-imprimir'][0];

        $input['arr_imprimir']="";

        /*
        *   EXPEDIENTE DIGITAL
        */
        if(!isset($input['juicio'])){
            unset($lista);
            $lista['status']=1;
            $lista['message']='Ocurrio un problema, favor de reportarlo.';
            return response()->json($lista);
        }
        $lista_expediente=archivos::expedientes_digitales_litigantes($request, $input['juicio'], $input['usuario-juzgado'], 'promocion_acuerdo', $input['parte']);
        

        if(isset($lista_expediente['status'])==100){
            for($i=0; $i<count($lista_expediente['response']); $i++){
                if($lista_expediente['response'][$i]['tipo']=='demanda'){
                    //return 1;

                    for($k=0; $k<count($lista_expediente['response'][$i]['datos']); $k++){
                        //return 2;
                        if(isset($lista_expediente['response'][$i]['datos']['adjuntos'][0])){
                            //return 3;
                            //for($j=0; $j<count($lista_expediente['response'][$i]['datos']['adjuntos'][$k]); $j++){
                            
                            if(isset($lista_expediente['response'][$i]['datos']['adjuntos'][$k]['promocion_adjunto_json'])){
                                //return var_dump($lista_expediente['response'][$i]['datos']['adjuntos'][$k]['promocion_adjunto_json']);

                                $arr_adjuntos=json_decode($lista_expediente['response'][$i]['datos']['adjuntos'][$k]['promocion_adjunto_json']);
                                //return var_dump($arr_adjuntos->idDocument);
                                if(isset($arr_adjuntos->idDocument)){
                                    $input['arr_imprimir'].='0,0,'.$arr_adjuntos->idDocument.'-';
                                    //return $input;
                                }
                                else if(isset($arr_adjuntos->idGlobal)){
                                    $input['arr_imprimir'].='0,0,'.$arr_adjuntos->idGlobal.'-';
                                }
                            }
                        }
                    }
                }

                else if($lista_expediente['response'][$i]['tipo']=='acuerdo'){
                    $input['arr_imprimir'].=$lista_expediente['response'][$i]['id'].','.$input['usuario-juzgado'].','.$lista_expediente['response'][$i]['datos']['ultima_version'].'-';
                }
            }
        }

        //return 'final';

        //return $input['arr_imprimir'];
        /*
        *   PORTADA
        */

        unset($datos);
        $datos['id_expediente']=$input['juicio'];
        $datos['expediente']="";
        $datos['expediente_anio']="";
        $datos['involucrados_nombre']="";
        $datos['expediente_bis']='';
        $datos['involucrados_apellido_paterno']=""; 
        $datos['involucrados_apellido_materno']="";
        $datos['registrado_desde']="";
        $datos['registrado_hasta']="";
        $archivo_detalle=archivos::obtener_listado_archivos_juzgados_litigante($request, $datos, $input['usuario-juzgado']);

        
        //autoridades
        //representantes
        $lista_representantes=acuerdos::obtener_representantes_juzgado_sinse($request, $input['usuario-juzgado']);
        $datos_archivo['nombre_sa']="";
        $datos_archivo['nombre_juez']="";
        if(isset($lista_representantes['response']['secretarios'][0])){
            for($i=0; $i<count($lista_representantes['response']['secretarios']); $i++){
                if($lista_representantes['response']['secretarios'][$i]['grupo_trabajo_identificar_area']==$archivo_detalle['response'][0]['datos_archivo']['secretaria']){
                    $datos_archivo['nombre_sa']=$lista_representantes['response']['secretarios'][$i]['usuario_dato_personal_nombres'].' '.$lista_representantes['response']['secretarios'][$i]['usuario_dato_personal_apellido_paterno'].' '.$lista_representantes['response']['secretarios'][$i]['usuario_dato_personal_apellido_materno'];
                }
            }
            if(isset($lista_representantes['response']['juez'][0]['usuario_dato_personal_nombres'])){
                $datos_archivo['nombre_juez']=$lista_representantes['response']['juez'][0]['usuario_dato_personal_nombres'].' '.$lista_representantes['response']['juez'][0]['usuario_dato_personal_apellido_paterno'].' '.$lista_representantes['response']['juez'][0]['usuario_dato_personal_apellido_materno'];
            }
        }

        

        $datos_archivo['id_expediente']=$input['juicio'];
        $datos_archivo['secretaria']=$archivo_detalle['response'][0]['datos_archivo']['secretaria'];
        $datos_archivo['expediente']=$archivo_detalle['response'][0]['datos_archivo']['expediente'].'/'.$archivo_detalle['response'][0]['datos_archivo']['anio'];
        $datos_archivo['juzgado']=utf8_encode($input['juzgado-nombre-largo']);
        

        $datos_archivo['actor']=$datos_archivo['demandado']="";
        for($i=0; $i<count($archivo_detalle['response'][0]['partes']['actor']); $i++){
            if($archivo_detalle['response'][0]['partes']['actor'][$i]['parte_promovente']==0){
                if($i==0){
                    $datos_archivo['actor'].=$archivo_detalle['response'][0]['partes']['actor'][$i]['apellido_paterno']." ".$archivo_detalle['response'][0]['partes']['actor'][$i]['apellido_materno']." ".$archivo_detalle['response'][0]['partes']['actor'][$i]['nombre'];
                }
                else{
                    $datos_archivo['actor'].=', '.$archivo_detalle['response'][0]['partes']['actor'][$i]['apellido_paterno']." ".$archivo_detalle['response'][0]['partes']['actor'][$i]['apellido_materno']." ".$archivo_detalle['response'][0]['partes']['actor'][$i]['nombre'];
                } 
            }
        }

        if(isset($archivo_detalle['response'][0]['partes']['demandado'])){
            for($i=0; $i<count($archivo_detalle['response'][0]['partes']['demandado']); $i++){
                if($i==0){
                    $datos_archivo['demandado'].=$archivo_detalle['response'][0]['partes']['demandado'][$i]['apellido_paterno']." ".$archivo_detalle['response'][0]['partes']['demandado'][$i]['apellido_materno']." ".$archivo_detalle['response'][0]['partes']['demandado'][$i]['nombre'];
                }
                else{
                    $datos_archivo['demandado'].=', '.$archivo_detalle['response'][0]['partes']['demandado'][$i]['apellido_paterno']." ".$archivo_detalle['response'][0]['partes']['demandado'][$i]['apellido_materno']." ".$archivo_detalle['response'][0]['partes']['demandado'][$i]['nombre'];
                }
            }
        }

        $datos_archivo['juicio']="";
        if(isset($archivo_detalle['response'][0]['tipo_juicio'][0]['juicio'])){
            $datos_archivo['juicio']=$archivo_detalle['response'][0]['tipo_juicio'][0]['juicio'].' '.$archivo_detalle['response'][0]['tipo_juicio'][0]['materia'];
        }
        

        $datos_archivo['fecha_creacion']=$archivo_detalle['response'][0]['datos_archivo']['fecha_publicacion'];
        
        //return 3;
 
        //$html=archivos::generarPortada($request, $datos_archivo);
        //$arr_coser[0]='/san/www/html/sicor_extendido_80/public/temporales/caratula_'.$input['juicio'].'.pdf';

        $html=archivos::generarPortada_v2($request, $datos_archivo);
        $arr_coser[0]='/san/www/html/sicor_extendido_80/public/temporales/caratula_'.$input['juicio'].'.pdf';
        $arr_coser[1]='/var/www/html/sicor_extendido_80/storage/app/documentos/blanco.pdf';

        //return 11;
        
        $num_cocer=2;
        $documentos_arr=explode('-', $input['arr_imprimir']);

        $documentos_arr_final=array();
        $num_hojas=0;
        for($i=0; $i<count($documentos_arr); $i++){
            if($documentos_arr[$i]!=""){
                $documentos_arr_tmp=explode(',', $documentos_arr[$i]);
                if($documentos_arr_tmp[0]!=0 and $documentos_arr_tmp[2]!=0){
                    $documentos_arr_final[$i]['acuerdo']=$documentos_arr_tmp[0];
                    $documentos_arr_final[$i]['organo']=$documentos_arr_tmp[1];
                    $documentos_arr_final[$i]['version']=$documentos_arr_tmp[2];

                    //se obtiene la utlma version
                    //$lista_flujo=acuerdos::consulta_flujo_detalles($request, $documentos_arr_tmp[0]);
                    //$ultima_version=$lista_flujo['response']['ultima_version_id'];
                    //$documentos_arr_final[$i]['version']=$ultima_version;


                    $lista=bandejas::documento_descargar_sicor($request, $documentos_arr_tmp[0], $documentos_arr_tmp[1], $documentos_arr_tmp[2], 'pdf');
                    

                    if($lista['status']!=0){
                        $url_tmp='/var/www/html/sicor_extendido_80/public/temporales/acuerdo_'.$proceso.'_'.$documentos_arr_tmp[0].'_'.$documentos_arr_tmp[1].'.pdf';
                        
                        copy($lista['response'], $url_tmp);
                        $output = shell_exec("pdfinfo ".$url_tmp);

                        preg_match('/Pages:\s+([0-9]+)/', $output, $pagecountmatches);
                        if( isset($pagecountmatches[1])){

                            $arr_coser[$num_cocer]=$url_tmp;
                            $num_cocer++;
                        }
                    }

                    
                    /*
                    //se revisa el numero de hojas y se crea la hoja blanca
                    $output = shell_exec("pdfinfo ".$url_tmp);
                    preg_match('/Pages:\s+([0-9]+)/', $output, $pagecountmatches);
                    $pagecount = $pagecountmatches[1];
                    $num_hojas+=$pagecount;
                    //es inpar se agrega la pagina blanca
                    if($pagecount%2==1 and 0){
                        $arr_coser[$num_cocer]='/var/www/html/sicor_extendido_80/storage/app/documentos/blanco.pdf';
                        $num_cocer++;
                    }
                    */

                }
                //son documentos del gestor
                else{
                    $gestor64=gestorDocumental::getDocGestor($request, $documentos_arr_tmp[2]);

                    if($gestor64['response']==100){
            
                        $pdf = fopen ('/var/www/html/sicor_extendido_80/public/temporales/test_'.$proceso.'_'.$documentos_arr_tmp[2].'.pdf','w');
                        fwrite ($pdf,$gestor64['pdf']);
                        //close output file
                        fclose ($pdf);
                        
                        $arr_coser[$num_cocer]='/var/www/html/sicor_extendido_80/public/temporales/test_'.$proceso.'_'.$documentos_arr_tmp[2].'.pdf';
                        $num_cocer++;
                        

                        /*
                        //se revisa el numero de hojas y se crea la hoja blanca
                        $output = shell_exec("pdfinfo ".'/var/www/html/sicor_extendido_80/public/temporales/test_'.$i.'.pdf');
                        preg_match('/Pages:\s+([0-9]+)/', $output, $pagecountmatches);
                        $pagecount = $pagecountmatches[1];
                        $num_hojas+=$pagecount;
                        //es inpar se agrega la pagina blanca
                        if($pagecount%2==1 and 0){
                            $arr_coser[$num_cocer]='/var/www/html/sicor_extendido_80/storage/app/documentos/blanco.pdf';
                            $num_cocer++;
                        }
                        */

                    }
                }
            }
        }
        
        if(count($arr_coser)==0){
            $lista['status']=1;
            $lista['message']='No hay documentos a imprimir.';
            return response()->json($lista);
        }
        
        //se manda a coser
        $lista_coser=bandejas::documento_coser_pdf($arr_coser);

        //se deshace el pdf
        $url_temporal=public_path().$lista_coser['file'];
        $url_separados_comodin=public_path('temporales')."/doc_expediente_".$proceso."_".$input['usuario-juzgado']."_".$input['juicio']."_%04d.pdf";

        $shell_burst="pdftk ".$url_temporal." burst output ".$url_separados_comodin;
        $output = shell_exec($shell_burst);


        $filelist = array();
        
        if ($handle = opendir(public_path('temporales'))) {
            while ($entry = readdir($handle)) {
                if (strpos($entry, "doc_expediente_".$proceso."_".$input['usuario-juzgado']."_".$input['juicio']) === 0) {
                    //se genera el pdf con numero
                    $filelist[] = $entry;
                }
            }
            closedir($handle);
        }

        sort($filelist);
        $numero=0;
        $filelist_final=[];
        for($i=0; $i<count($filelist); $i++){

            //se genera el pdf con numero
            if($numero!=0 and $numero!=1){
                archivos::generarNumericoSelloAguaPDF($request, ($numero-1));
                $file_original=public_path('temporales')."/".$filelist[$i];
                $url_numero=public_path('temporales')."/numero_".($numero-1).".pdf";
                $file_final=public_path('temporales')."/paginacion_".$filelist[$i];

                $shell_multistamp="pdftk $file_original multibackground $url_numero output $file_final";
                $output = shell_exec($shell_multistamp);
                $filelist_final[]=$file_final;
            }
            else{
                $filelist_final[] = public_path('temporales')."/".$filelist[$i];
            }
            $numero++;
        }

        if($numero%2==0){
        //    $filelist_final[$numero]='/var/www/html/sicor_extendido_80/storage/app/documentos/blanco.pdf';
        }

        
        $lista_coser_final=bandejas::documento_coser_pdf($filelist_final);


        $lista_coser['status']=100;
        $lista_coser['filelist_final']=$filelist_final;
        $lista_coser['arr_coser']=$arr_coser;
        $lista_coser['lista_coser_final']=$lista_coser_final;
        $lista_coser['file']=$lista_coser_final['file'];
        $lista_coser['documentos_arr']=$documentos_arr;
        return response()->json($lista_coser);
    }

    public function documento_descargar_masivo_expediente_digital_ajax( Request $request ){

        $input = $request->all();
        $arr_coser=array();

        /*
        *   ORDEN
        */
        if(isset($input['arr_orden'])){
            $arr_orden=explode('--', $input['arr_orden']);
            $datos_orden=[];
            
            for($i=0; $i<count($arr_orden); $i++){
                if($arr_orden[$i]!=""){
                    $arr_orden_tmp=explode(',', $arr_orden[$i]);
                    $datos_tmp=[];
                    $datos_tmp['order']=$i;
                    
                    if($arr_orden_tmp[0]==1) $datos_tmp['considerar']=true;
                    else $datos_tmp['considerar']=false;

                    $datos_tmp['id']=$arr_orden_tmp[1];
                    $datos_tmp['tipo']=$arr_orden_tmp[2];
                    $datos_tmp['fecha']=$arr_orden_tmp[3];

                    $datos_orden[]=$datos_tmp;

                }
            }
            $lista_orden=archivos::guardar_orden_expediente_digital($request, $input['juicio'], $datos_orden, "agregar");
        }

        /*
        *   PORTADA
        */
        unset($datos);
        $datos['id_expediente']=$input['juicio'];
        $datos['expediente']="";
        $datos['expediente_anio']="";
        $datos['involucrados_nombre']="";
        $datos['expediente_bis']='';
        $datos['involucrados_apellido_paterno']=""; 
        $datos['involucrados_apellido_materno']="";
        $datos['registrado_desde']="";
        $datos['registrado_hasta']="";
        $archivo_detalle=archivos::obtener_listado_archivos_juzgados($request, $datos);


        //autoridades
        //representantes
        $lista_representantes=acuerdos::obtener_representantes_juzgado($request);
        $datos_archivo['nombre_sa']="";
        $datos_archivo['nombre_juez']="";
        if(isset($lista_representantes['response']['secretarios'][0])){
            for($i=0; $i<count($lista_representantes['response']['secretarios']); $i++){
                if($lista_representantes['response']['secretarios'][$i]['grupo_trabajo_identificar_area']==$archivo_detalle['response'][0]['datos_archivo']['secretaria']){
                    $datos_archivo['nombre_sa']=$lista_representantes['response']['secretarios'][$i]['usuario_dato_personal_nombres'].' '.$lista_representantes['response']['secretarios'][$i]['usuario_dato_personal_apellido_paterno'].' '.$lista_representantes['response']['secretarios'][$i]['usuario_dato_personal_apellido_materno'];
                }
            }
            if(isset($lista_representantes['response']['juez'][0]['usuario_dato_personal_nombres'])){
                $datos_archivo['nombre_juez']=$lista_representantes['response']['juez'][0]['usuario_dato_personal_nombres'].' '.$lista_representantes['response']['juez'][0]['usuario_dato_personal_apellido_paterno'].' '.$lista_representantes['response']['juez'][0]['usuario_dato_personal_apellido_materno'];
            }
        }
        
        $datos_archivo['id_expediente']=$input['juicio'];
        $datos_archivo['secretaria']=$archivo_detalle['response'][0]['datos_archivo']['secretaria'];
        $datos_archivo['expediente']=$archivo_detalle['response'][0]['datos_archivo']['expediente'].'/'.$archivo_detalle['response'][0]['datos_archivo']['anio'];
        $datos_archivo['juzgado']=$request->session()->get('juzgado_nombre_largo');

        $datos_archivo['actor']=$datos_archivo['demandado']="";
        if(isset($archivo_detalle['response'][0]['partes']['actor'])){
            for($i=0; $i<count($archivo_detalle['response'][0]['partes']['actor']); $i++){
                if($archivo_detalle['response'][0]['partes']['actor'][$i]['parte_promovente']==0){
                    if($i==0){
                        $datos_archivo['actor'].=$archivo_detalle['response'][0]['partes']['actor'][$i]['apellido_paterno']." ".$archivo_detalle['response'][0]['partes']['actor'][$i]['apellido_materno']." ".$archivo_detalle['response'][0]['partes']['actor'][$i]['nombre'];
                    }
                    else{
                        $datos_archivo['actor'].=', '.$archivo_detalle['response'][0]['partes']['actor'][$i]['apellido_paterno']." ".$archivo_detalle['response'][0]['partes']['actor'][$i]['apellido_materno']." ".$archivo_detalle['response'][0]['partes']['actor'][$i]['nombre'];
                    } 
                }
            }
        }
        if(isset($archivo_detalle['response'][0]['partes']['demandado'])){
            for($i=0; $i<count($archivo_detalle['response'][0]['partes']['demandado']); $i++){
                if($i==0){
                    $datos_archivo['demandado'].=$archivo_detalle['response'][0]['partes']['demandado'][$i]['apellido_paterno']." ".$archivo_detalle['response'][0]['partes']['demandado'][$i]['apellido_materno']." ".$archivo_detalle['response'][0]['partes']['demandado'][$i]['nombre'];
                }
                else{
                    $datos_archivo['demandado'].=', '.$archivo_detalle['response'][0]['partes']['demandado'][$i]['apellido_paterno']." ".$archivo_detalle['response'][0]['partes']['demandado'][$i]['apellido_materno']." ".$archivo_detalle['response'][0]['partes']['demandado'][$i]['nombre'];
                }
            }
        }
        $datos_archivo['juicio']=$archivo_detalle['response'][0]['tipo_juicio'][0]['juicio'].' '.$archivo_detalle['response'][0]['tipo_juicio'][0]['materia'];

        $datos_archivo['fecha_creacion']=$archivo_detalle['response'][0]['datos_archivo']['fecha_publicacion'];
        
 
        if ($request->session()->get("sesion_tipo")=="soporte" or 1){
            archivos::generarPortada_v2($request, $datos_archivo);
        }
        else{
            archivos::generarPortada($request, $datos_archivo);
        }
        
        $arr_coser[0]='/san/www/html/sicor_extendido_80/public/temporales/caratula_'.$input['juicio'].'.pdf';
        $arr_coser[1]='/var/www/html/sicor_extendido_80/storage/app/documentos/blanco.pdf';
        
        $num_cocer=2;
        $documentos_arr=explode('-', $input['arr_imprimir']); 
        $documentos_arr_final=array();
        $num_hojas=0;
        $return = [];
        for($i=0; $i<count($documentos_arr); $i++){
            if($documentos_arr[$i]!=""){
                $documentos_arr_tmp=explode(',', $documentos_arr[$i]);
                if($documentos_arr_tmp[0]!=0){
                    $documentos_arr_final[$i]['acuerdo']=$documentos_arr_tmp[0];
                    $documentos_arr_final[$i]['organo']=$documentos_arr_tmp[1];
                    $documentos_arr_final[$i]['version']=$documentos_arr_tmp[2];

                    //se obtiene la utlma version
                    //$lista_flujo=acuerdos::consulta_flujo_detalles($request, $documentos_arr_tmp[0]);
                    //$ultima_version=$lista_flujo['response']['ultima_version_id'];

                    $lista_flujo=acuerdos::obtener_ultima_version_acuerdo($request, $documentos_arr_tmp[0]);
                    $return[] = $lista_flujo;
                    if($lista_flujo['status']!=100){
                        return $lista_flujo;
                    }
                    $ultima_version=$lista_flujo['response'];

                    
                    $documentos_arr_final[$i]['version']=$ultima_version;


                    $lista=bandejas::documento_descargar($request, $documentos_arr_tmp[0], $documentos_arr_tmp[1], $documentos_arr_tmp[2], 'pdf');
                    $return[] = $lista;

                    if($lista['status']!=0){
                        $url_tmp='/var/www/html/sicor_extendido_80/public/temporales/acuerdo_'.$documentos_arr_tmp[0].'.pdf';
                        copy($lista['response'], $url_tmp);
                        $output = shell_exec("pdfinfo ".$url_tmp);

                        preg_match('/Pages:\s+([0-9]+)/', $output, $pagecountmatches);
                        if( isset($pagecountmatches[1])){

                            $arr_coser[$num_cocer]=$url_tmp;
                            $num_cocer++;
                        }
                    }

                    
                    /*
                    //se revisa el numero de hojas y se crea la hoja blanca
                    $output = shell_exec("pdfinfo ".$url_tmp);
                    preg_match('/Pages:\s+([0-9]+)/', $output, $pagecountmatches);
                    $pagecount = $pagecountmatches[1];
                    $num_hojas+=$pagecount;
                    //es inpar se agrega la pagina blanca
                    if($pagecount%2==1 and 0){
                        $arr_coser[$num_cocer]='/var/www/html/sicor_extendido_80/storage/app/documentos/blanco.pdf';
                        $num_cocer++;
                    }
                    */

                }
                //son documentos del gestor
                else{
                    $gestor64=gestorDocumental::getDocGestor($request, $documentos_arr_tmp[2]);

                    if($gestor64['response']==100){
            
                        $pdf = fopen ('/var/www/html/sicor_extendido_80/public/temporales/test_'.$i.'.pdf','w');
                        fwrite ($pdf,$gestor64['pdf']);
                        //close output file
                        fclose ($pdf);
                        
                        $arr_coser[$num_cocer]='/var/www/html/sicor_extendido_80/public/temporales/test_'.$i.'.pdf';
                        $num_cocer++;
                        

                        /*
                        //se revisa el numero de hojas y se crea la hoja blanca
                        $output = shell_exec("pdfinfo ".'/var/www/html/sicor_extendido_80/public/temporales/test_'.$i.'.pdf');
                        preg_match('/Pages:\s+([0-9]+)/', $output, $pagecountmatches);
                        $pagecount = $pagecountmatches[1];
                        $num_hojas+=$pagecount;
                        //es inpar se agrega la pagina blanca
                        if($pagecount%2==1 and 0){
                            $arr_coser[$num_cocer]='/var/www/html/sicor_extendido_80/storage/app/documentos/blanco.pdf';
                            $num_cocer++;
                        }
                        */


                    }
                }
            }
        }
        
        //return $arr_coser;
        if(count($arr_coser)==0){
            $lista['status']=1;
            $lista['message']='No hay documentos a imprimir.';
            return response()->json($lista);
        }
        
        //se manda a coser
        $lista_coser=bandejas::documento_coser_pdf($arr_coser);

        //se deshace el pdf
        $url_temporal=public_path().$lista_coser['file'];
        $url_separados_comodin=public_path('temporales')."/doc_expediente_".$input['juicio']."_%04d.pdf";

        $shell_burst="pdftk ".$url_temporal." burst output ".$url_separados_comodin;
        $output = shell_exec($shell_burst);


        $filelist = array();
        
        if ($handle = opendir(public_path('temporales'))) {
            while ($entry = readdir($handle)) {
                if (strpos($entry, "doc_expediente_".$input['juicio']) === 0) {
                    //se genera el pdf con numero
                    $filelist[] = $entry;
                }
            }
            closedir($handle);
        }

        sort($filelist);
        $numero=0;
        $filelist_final=[];
        for($i=0; $i<count($filelist); $i++){

            //se genera el pdf con numero
            if($numero!=0 and $numero!=1){
                archivos::generarNumericoPDF($request, ($numero-1));
                $file_original=public_path('temporales')."/".$filelist[$i];
                $url_numero=public_path('temporales')."/numero_".($numero-1).".pdf";
                $file_final=public_path('temporales')."/paginacion_".$filelist[$i];

                $shell_multistamp="pdftk $file_original multistamp $url_numero output $file_final";
                $output = shell_exec($shell_multistamp);
                $filelist_final[]=$file_final;
            }
            else{
                $filelist_final[] = public_path('temporales')."/".$filelist[$i];
            }
            $numero++;
        }

        if($numero%2==0){
        //    $filelist_final[$numero]='/var/www/html/sicor_extendido_80/storage/app/documentos/blanco.pdf';
        }

        
        $lista_coser_final=bandejas::documento_coser_pdf($filelist_final);


        $lista_coser['status']=100;
        $lista_coser['filelist_final']=$filelist_final;
        $lista_coser['arr_coser']=$arr_coser;
        $lista_coser['lista_coser_final']=$lista_coser_final;
        $lista_coser['file']=$lista_coser_final['file'];
        $lista_coser['documentos_arr']=$documentos_arr;
        return response()->json($lista_coser);
    }

    public function elminar_orden_expedinte_digital_ajax( Request $request ){
        $input = $request->all();
        $lista=archivos::guardar_orden_expediente_digital($request, $input['juicio'], [], "borrar");
        return $lista;
    }

    public function documento_descargar_masivo_ajax(Request $request){
        $input = $request->all();
        $bandeja=$input['bandeja'];

        //$bandeja='resoluciones';

        if($bandeja=='firma' or $bandeja=='revision'){

            if($request->session()->get('juzgado_tipo')=='sala'){
                ($input['toca']=="-") ? $datos['toca']="" : $datos['toca']=$input['toca'];
                ($input['anio_toca']=="0") ? $datos['anio_toca']="" : $datos['anio_toca']=$input['anio_toca'];
                ($input['asunto_toca']=="-") ? $datos['asunto_toca']="" : $datos['asunto_toca']=$input['asunto_toca'];
                ($input['expediente']=="-") ? $datos['expediente']="" : $datos['expediente']=$input['expediente'];
                ($input['anio_expediente']=="0") ? $datos['expediente_anio']="" : $datos['expediente_anio']=$input['anio_expediente'];
                ($input['involucrados_nombre']=="-") ? $datos['involucrados_nombre']="" : $datos['involucrados_nombre']=$input['involucrados_nombre'];
                ($input['involucrados_apellido_paterno']=="-") ? $datos['involucrados_apellido_paterno']="" : $datos['involucrados_apellido_paterno']=$input['involucrados_apellido_paterno'];
                ($input['involucrados_apellido_materno']=="-") ? $datos['involucrados_apellido_materno']="" : $datos['involucrados_apellido_materno']=$input['involucrados_apellido_materno'];
                ($input['tipo_acuerdo']=="-") ? $datos['tipo_acuerdo']="" : $datos['tipo_acuerdo']=$input['tipo_acuerdo'];
                ($input['origen_acuerdo']=="-") ? $datos['origen_acuerdo']="" : $datos['origen_acuerdo']=$input['origen_acuerdo'];
                ($input['fecha_desde']=="-") ? $datos['registrado_desde']="" : $datos['registrado_desde']=$input['fecha_desde'];
                ($input['fecha_hasta']=="-") ? $datos['registrado_hasta']="" : $datos['registrado_hasta']=$input['fecha_hasta'];
            }
            else{
                $datos['toca']="";
                $datos['anio_toca']="";
                $datos['asunto_toca']="";
                ($input['expediente']=="-") ? $datos['expediente']="" : $datos['expediente']=$input['expediente'];
                ($input['anio_expediente']=="0") ? $datos['expediente_anio']="" : $datos['expediente_anio']=$input['anio_expediente'];
                ($input['involucrados_nombre']=="-") ? $datos['involucrados_nombre']="" : $datos['involucrados_nombre']=$input['involucrados_nombre'];
                ($input['involucrados_apellido_paterno']=="-") ? $datos['involucrados_apellido_paterno']="" : $datos['involucrados_apellido_paterno']=$input['involucrados_apellido_paterno'];
                ($input['involucrados_apellido_materno']=="-") ? $datos['involucrados_apellido_materno']="" : $datos['involucrados_apellido_materno']=$input['involucrados_apellido_materno'];
                ($input['tipo_acuerdo']=="-") ? $datos['tipo_acuerdo']="" : $datos['tipo_acuerdo']=$input['tipo_acuerdo'];
                ($input['origen_acuerdo']=="-") ? $datos['origen_acuerdo']="" : $datos['origen_acuerdo']=$input['origen_acuerdo'];
                ($input['fecha_desde']=="-") ? $datos['registrado_desde']="" : $datos['registrado_desde']=$input['fecha_desde'];
                ($input['fecha_hasta']=="-") ? $datos['registrado_hasta']="" : $datos['registrado_hasta']=$input['fecha_hasta'];
            }


            $lista=bandejas::obtener_listado_bandejas($request, $bandeja, $datos);
            if(!isset($lista['response'])){
                $lista['status']=1;
                $lista['message']='No hay documentos en la bandeja.';
                return response()->json($lista);
            }

            $documentos_arr_final=array();
            for($i=0; $i<count($lista['response']); $i++){
                $documentos_arr_final[$i]['acuerdo']=$lista['response'][$i]['id_acuerdo'];
                $documentos_arr_final[$i]['organo']=$lista['response'][$i]['codigo_organo'];
                $documentos_arr_final[$i]['version']=$lista['response'][$i]['ultima_version'];
            }
            
        }
        else if($bandeja=='proximaPublicacion'){

            ($input['toca']=="") ? $datos['toca']="" : $datos['toca']=$input['toca'];
            ($input['anio_toca']=="0") ? $datos['anio_toca']="" : $datos['anio_toca']=$input['anio_toca'];
            ($input['asunto_toca']=="") ? $datos['asunto_toca']="" : $datos['asunto_toca']=$input['asunto_toca'];
            ($input['fecha_desde']=="") ? $datos['registrado_desde']="" : $datos['registrado_desde']=$input['fecha_desde'];
            ($input['fecha_hasta']=="") ? $datos['registrado_hasta']="" : $datos['registrado_hasta']=$input['fecha_hasta'];

            //return $datos;

            $lista=bandejas::obtener_listado_proxima_publicacion($request, $datos, '');

            //return response()->json($lista);

            if(!isset($lista['response'])){
                $lista['status']=1;
                $lista['message']='No hay documentos en la bandeja.';
                return response()->json($lista);
            }

            $documentos_arr_final=array();
            for($i=0; $i<count($lista['response']); $i++){
                $documentos_arr_final[$i]['acuerdo']=$lista['response'][$i]['id_acuerdo'];
                $documentos_arr_final[$i]['organo']=$lista['response'][$i]['id_organo'];
                $documentos_arr_final[$i]['version']=$lista['response'][$i]['ultima_version'];
            }

        }
        else if($bandeja=='busquedaPublicacion'){

            ($input['toca']=="") ? $datos['toca']="" : $datos['toca']=$input['toca'];
            ($input['anio_toca']=="0") ? $datos['anio_toca']="" : $datos['anio_toca']=$input['anio_toca'];
            ($input['asunto_toca']=="") ? $datos['asunto_toca']="" : $datos['asunto_toca']=$input['asunto_toca'];
            ($input['fecha_desde']=="") ? $datos['registrado_desde']="" : $datos['registrado_desde']=$input['fecha_desde'];
            ($input['fecha_hasta']=="") ? $datos['registrado_hasta']="" : $datos['registrado_hasta']=$input['fecha_hasta'];

            //return $datos;

            $lista=bandejas::obtener_listado_proxima_publicacion($request, $datos, 'si');

            //return response()->json($lista);

            if(!isset($lista['response'])){
                $lista['status']=1;
                $lista['message']='No hay documentos en la bandeja.';
                return response()->json($lista);
            }

            $documentos_arr_final=array();
            for($i=0; $i<count($lista['response']); $i++){
                $documentos_arr_final[$i]['acuerdo']=$lista['response'][$i]['id_acuerdo'];
                $documentos_arr_final[$i]['organo']=$lista['response'][$i]['id_organo'];
                $documentos_arr_final[$i]['version']=$lista['response'][$i]['ultima_version'];
            }

        }
        else if($bandeja=='acuerdos'){
            $id=$input['id'];
            $archivo_detalle=archivos::obtener_archivo($request, $id);
            $lista=acuerdos::obtener_archivo_acuerdos($request, $id);

            if(!isset($lista['response'])){
                $lista['status']=1;
                $lista['message']='No hay documentos en la bandeja.';
                return response()->json($lista);
            }

            $documentos_arr_final=array();
            $j=0;
            for($i=0; $i<count($lista['response']); $i++){
                if($lista['response'][$i]['fecha_publicacion']!=""){
                    $documentos_arr_final[$j]['acuerdo']=$lista['response'][$i]['id_acuerdo'];
                    $documentos_arr_final[$j]['organo']=$archivo_detalle['response']['datos_toca'][0]['juzgado'];
                    $documentos_arr_final[$j]['version']=$lista['response'][$i]['ultima_version'];
                    $j++;
                }
            }
        }
        else{
            $lista['status']=1;
            $lista['message']='No se seleccionó alguna bandeja.';
            return response()->json($lista);
        }

        //se pide las urls
        $lista=bandejas::documento_descargar_batch($request, $documentos_arr_final[0]['acuerdo'], $documentos_arr_final[0]['organo'], $documentos_arr_final[0]['version'], 'pdf', $documentos_arr_final);


        //se prepara para coser
        $arr_coser=array();
        $i=0;
        if(!isset($lista['response'])){
            $lista['status']=2;
            $lista['message']='Volver a intentar.';
            return response()->json($lista);
        }
        foreach ($lista['response'] as $clave => $valor) {
            if(isset($valor[0]['response'])){
                if($this->url_exists($valor[0]['response'])){
                    $arr_coser[$i]=$valor[0]['response'];
                    $i++;
                }
            }
        }

        //return response()->json($arr_coser);

        if(count($arr_coser)==0){
            $lista['status']=1;
            $lista['message']='No hay documentos válidos.';
            return response()->json($lista);
        }
        
        //se manda a coser
        $lista_coser=bandejas::documento_coser_pdf($arr_coser);
        $lista_coser['status']=100;
        return response()->json($lista_coser);
    }

    public function descargarPDFPreview( Request $request ){  
        
        $input = $request->all();

        //$lista_flujo=acuerdos::consulta_flujo_detalles($request, $input['id_acuerdo']);
        $lista_flujo=acuerdos::obtener_ultima_version_acuerdo($request, $input['id_acuerdo']);
        if($lista_flujo['status']!=100){
            return $lista_flujo;
        }
        //return $lista_flujo;
        $ultima_version=$lista_flujo['response'];
        
        //se descarga el pdf
        $lista=bandejas::documento_descargar($request, $input['id_acuerdo'], $input['codigo_organo'], $ultima_version, 'pdf');
        //$docuemntoPDF=$lista['response'];
        $proceso = rand(100, 999);
        $url_final='/var/www/html/sicor_extendido_80/public/temporales/preview_'.$input['id_acuerdo'].'_'.$proceso.'.pdf';
        copy($lista['response'], $url_final);

        $lista['response']='/temporales/preview_'.$input['id_acuerdo'].'_'.$proceso.'.pdf';
        return $lista;
 
    }

    public function ventana_mala_publicacion(Request $request){
        $input = $request->all();
        include "plantilla_mala_pubicacion.php";

        return response()->json(['plantilla_archivo_header'=>'', 'plantilla_archivo_body'=>$plantilla_archivo_body]);
        
    }

    public function crear_mala_publicacion( Request $request ){
        $input = $request->all();

        $lista=bandejas::acuerdo_mala_publicacion($request, $input['id_juicio'], $input['id_acuerdo'], $input['comentarios']);
        return $lista;
    }

    public function bandeja_firmar_firel_ajax( Request $request ){
        $input = $request->all();
        $proceso = rand(100, 999);
        $version_sello=0;
        //se revisa si ya expiro la fecha

        $lista_acuerdos=acuerdos::obtener_archivo_acuerdo($request, $input['modal_id_juicio'], $input['modal_id_acuerdo']);
        if($lista_acuerdos['status']!=100){
            utilidades::guardarLog($request, 'firma_juzgado', $proceso, 4, 'ACUERDO INEXISTENTE');
            utilidades::guardarLog($request, 'firma_juzgado', $proceso, 3, "");

            $error['error']=1;
            $error['mensaje']='Usted esta tratando de firmar un acuerdo inexistente.';
            return response()->json($error);
        }

        utilidades::guardarLog($request, 'firma_juzgado', $proceso, 2,  "Juzgado: " . $request->session()->get('usuario_juzgado') . " Usuario: " . $request->session()->get('usuario_nombre') . " Acuerdo: " . $lista_acuerdos['response'][0]['acuerdo'] . " id_juicio: " .$input['modal_id_juicio'] . ' id_acuerdo: '. $input['modal_id_acuerdo'].' tipo_firma_firel: '. $input['tipo_firma_firel']);
        
        //si existe la version sello
        if(isset($lista_acuerdos['response'][0]['version_sello'])){
            $version_sello=$lista_acuerdos['response'][0]['version_sello'];
        }
        
        if(isset($lista_acuerdos['response'][0]['acuerdo_etapa_procesal']) and $lista_acuerdos['response'][0]['acuerdo_etapa_procesal']=='admision'){
            //return response()->json($lista_acuerdos);

            //se obtiene la fecha
            $arr_fecha=explode(' ', $lista_acuerdos['response'][0]['acuerdo_fecha_publicacion_temp']);

            $fecha_actual = strtotime(date("Y-m-d H:i:00",time()));
            $fecha_entrada = strtotime($arr_fecha[0]." ".$request->session()->get('horario_cierre'));

            if($fecha_actual > $fecha_entrada){

                utilidades::guardarLog($request, 'firma_juzgado', $proceso, 4, 'DIV EXPRES: ADMISIÓN: El acuerdo ha caducado, se tenía que firmar antes del '.$arr_fecha[0]." ".$request->session()->get('horario_cierre'));
                utilidades::guardarLog($request, 'firma_juzgado', $proceso, 3, "");

                $error['error']=1;
                $error['mensaje']='DIV EXPRES: ADMISIÓN: El acuerdo ha caducado, se tenía que firmar antes del '.$arr_fecha[0]." ".$request->session()->get('horario_cierre');
                return response()->json($error);
            }

            utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "DIV EXPRES: ADMISIÓN: Las fechas de firma es correcta y son antes de: " . $arr_fecha[0]." ".$request->session()->get('horario_cierre'));

        }
        
        //return 0;

        $time=[];
        $time[]=[];

        $bandera=$voto=0;
        $url_pfx=$url_cer=$url_key="";
                                                                                                $time['time'][]=date('H:i:s');
                                                                                                $time['evento'][]='inicia';

        if($input['tipo_firma_firel']=='firel'){
            if(!isset($request->archivo_pfx)){
                $error['error']=1;
                $error['mensaje']='El archivo PFX es obligatorio.';

                //LOG
                utilidades::guardarLog($request, 'firma_juzgado', $proceso, 4, $error['mensaje']);
                utilidades::guardarLog($request, 'firma_juzgado', $proceso, 3, "");

                return response()->json($error);
            }
            if($request->archivo_pfx->isValid()){
                $url_pfx=$request->archivo_pfx->store('private');
                $bandera=1;
            }
        }
        else if($input['tipo_firma_firel']=='fiel'){
            if(!isset($request->archivo_key)){
                $error['error']=1;
                $error['mensaje']='El archivo KEY es obligatorio.';

                //LOG
                utilidades::guardarLog($request, 'firma_juzgado', $proceso, 4, $error['mensaje']);
                utilidades::guardarLog($request, 'firma_juzgado', $proceso, 3, "");

                return response()->json($error);
            }
            if(!isset($request->archivo_cer)){
                $error['error']=1;
                $error['mensaje']='El archivo CER es obligatorio.';

                //LOG
                utilidades::guardarLog($request, 'firma_juzgado', $proceso, 4, $error['mensaje']);
                utilidades::guardarLog($request, 'firma_juzgado', $proceso, 3, "");

                return response()->json($error);
            }


            /*
            *   SE GUARDAN LOS ARCHIVOS
            */
            if($request->archivo_key->isValid()){
                $url_key=$request->archivo_key->store('private');
                $bandera=1;
            }
            else{
                $bandera=0;
            }
            if($request->archivo_cer->isValid()){
                $url_cer=$request->archivo_cer->store('private');
                $bandera=1;
            }
            else{
                $bandera=0;
            }
        }


        else if($input['tipo_firma_firel']=='firel_tsj'){
            if(!isset($request->archivo_pfx)){
                $error['error']=1;
                $error['mensaje']='El archivo PFX es obligatorio.';

                //LOG
                utilidades::guardarLog($request, 'firma_juzgado', $proceso, 4, $error['mensaje']);
                utilidades::guardarLog($request, 'firma_juzgado', $proceso, 3, "");

                return response()->json($error);
            }
            if($request->archivo_pfx->isValid()){
                $url_pfx=$request->archivo_pfx->store('private');
                $bandera=1;
            }
        }
        else if($input['tipo_firma_firel']=='fiel_tsj'){
            if(!isset($request->archivo_key)){
                $error['error']=1;
                $error['mensaje']='El archivo KEY es obligatorio.';

                //LOG
                utilidades::guardarLog($request, 'firma_juzgado', $proceso, 4, $error['mensaje']);
                utilidades::guardarLog($request, 'firma_juzgado', $proceso, 3, "");

                return response()->json($error);
            }
            if(!isset($request->archivo_cer)){
                $error['error']=1;
                $error['mensaje']='El archivo CER es obligatorio.';

                //LOG
                utilidades::guardarLog($request, 'firma_juzgado', $proceso, 4, $error['mensaje']);
                utilidades::guardarLog($request, 'firma_juzgado', $proceso, 3, "");

                return response()->json($error);
            }


            /*
            *   SE GUARDAN LOS ARCHIVOS
            */
            if($request->archivo_key->isValid()){
                $url_key=$request->archivo_key->store('private');
                $bandera=1;
            }
            else{
                $bandera=0;
            }
            if($request->archivo_cer->isValid()){
                $url_cer=$request->archivo_cer->store('private');
                $bandera=1;
            }
            else{
                $bandera=0;
            }
        }


        else{
            $bandera=1;
        }

        //$url_pfx="private/4Epg9JN1hqxtt5brpRYuRcEpM7YJm6jGmqdLeDhN.bin";

        if($bandera==1){

            //LOG
            utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "Se consulta la ultima versión");

            $return=[];
            /*
            $lista_flujo=acuerdos::consulta_flujo_detalles($request, $input['modal_id_acuerdo']);
            
            //$lista_flujo=acuerdos::obtener_ultima_version_acuerdo($request, $input['modal_id_acuerdo']);
            if($lista_flujo['status']!=100){
                return $lista_flujo;
            }
            $ultima_version=$lista_flujo['response']['ultima_version_id'];
            */

            $lista_flujo=acuerdos::obtener_ultima_version_acuerdo($request, $input['modal_id_acuerdo']);
            if($lista_flujo['status']!=100){
                return $lista_flujo;
            }
            $ultima_version=$lista_flujo['response'];



            $time['flujo']=$lista_flujo;
            $time['modal_id_acuerdo']=$input['modal_id_acuerdo'];
            $time['ultima_version_id']=$ultima_version;
            $time['voto_particular']=0;

                                                                                                
            //se revisa la parte del candado
            $lista_candado=bandejas::candado_firmado($request, $input['modal_id_acuerdo'], "validacion");
            if($lista_candado['status']==0){
            //if(0){
                utilidades::guardarLog($request, 'firma_juzgado', $proceso, 4, 'El acuerdo tiene candado de proceso de firmado.');
                utilidades::guardarLog($request, 'firma_juzgado', $proceso, 3, "");

                $error['error']=1;
                $error['mensaje']=$lista_candado['message'];
                return response()->json($error);
            }
            //se bloquea el firmado del documento
            utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, 'Se pone el candado de firmado.');
            $lista_candado=bandejas::candado_firmado($request, $input['modal_id_acuerdo'], "registro");


            //se obtiene el voto particular
            /*
            for($i=0; $i<count($lista_flujo['response']['firmas']); $i++){
                if($lista_flujo['response']['firmas'][$i]['voto_particular']==1){
                    $voto=1;
                                                                                                $time['voto_particular']=1;
                    utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "Se detecta voto particular");
                }
            }
            */
            /*
            //se descarga el documento
            if($voto==1){
                //log
                utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "Intenta descargar documento Voto Particular");

                $lista_voto=bandejas::voto_particular_descarga($request, $input['modal_id_juicio'], $input['modal_id_acuerdo'], 'descarga_inicial');
                $docuemntoPDF_voto=$lista_voto['response'];

                $docuemntoPDF_voto='/var/www/html/sicor_extendido_80/storage/app/temporales/por_firmar_'.$input['modal_id_acuerdo'].'.pdf';
                copy($lista_voto['response'], $docuemntoPDF_voto);
                
                //se firma el documento obtenido
                if($input['tipo_firma_firel']=='firel'){
                    $documentoCER='/san/www/html/sicor_extendido_80/storage/app/'.$url_pfx;
                    $pdfFirmado_voto=bandejas::obtener_firma_firel_acuerdo($docuemntoPDF_voto, $documentoCER, "", $input['password']);
                    if($pdfFirmado_voto['resultado']==0){

                        utilidades::guardarLog($request, 'firma_juzgado', $proceso, 4, "No se pudo firmar con fiel el VOTO PARTICULAR, credenciales erroneas.");

                        //se bloquea el firmado del documento
                        utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, 'Se quita el candado de firmado.');
                        $lista_candado=bandejas::candado_firmado($request, $input['modal_id_acuerdo'], "eliminacion");

                        utilidades::guardarLog($request, 'firma_juzgado', $proceso, 3, "");

                        $error['error']=1;
                        $error['mensaje']='Error al firmar con el certificado, favor de revisar el llaves y la contraseña.';
                        return response()->json($error);
                    }
                }
                else if($input['tipo_firma_firel']=='fiel'){
                    $documentoCER='/san/www/html/sicor_extendido_80/storage/app/'.$url_cer;
                    $documentoKEY='/san/www/html/sicor_extendido_80/storage/app/'.$url_key;
                    $pdfFirmado_voto=bandejas::obtener_firma_firel_acuerdo($docuemntoPDF_voto, $documentoCER, $documentoKEY, $input['password']);

                    if($pdfFirmado_voto['resultado']==0){

                        utilidades::guardarLog($request, 'firma_juzgado', $proceso, 4, "No se pudo firmar con fiel el VOTO PARTICULAR, credenciales erroneas.");

                        //se bloquea el firmado del documento
                        utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, 'Se quita el candado de firmado.');
                        $lista_candado=bandejas::candado_firmado($request, $input['modal_id_acuerdo'], "eliminacion");

                        utilidades::guardarLog($request, 'firma_juzgado', $proceso, 3, "");

                        $error['error']=1;
                        $error['mensaje']='Error al firmar con el certificado, favor de revisar el llaves y la contraseña.';
                        return response()->json($error);
                    }


                }
                else{
                    $pdfFirmado['resultado']=1;
                    $b64PDF=chunk_split(base64_encode(file_get_contents($docuemntoPDF_voto, "r")));
                    $pdfFirmado_voto['documento']=$b64PDF;
                }
                                                                                                $time['time'][]=date('H:i:s');
                                                                                                $time['evento'][]='se firma el voto por la firel';
                //log
                utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "Firma FIREL documento Voto Particular");
            }
            */
            
            //log
            utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "Intenta descargar documento PDF acuerdo - ultima version: " . $ultima_version);

            //se descarga el pdf
            $lista=bandejas::documento_descargar($request, $input['modal_id_acuerdo'], $input['modal_codigo_organo'], $ultima_version, 'pdf');
            $docuemntoPDF=$lista['response'];

            $docuemntoPDF='/var/www/html/sicor_extendido_80/storage/app/temporales/por_firmar_'.$ultima_version.'.pdf';
            copy($lista['response'], $docuemntoPDF);


            if(($input['tipo_firma_firel']=='firel_tsj' or $input['tipo_firma_firel']=='fiel_tsj') and $lista_acuerdos['response'][0]['llaves_documento_firma']==""){
                utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, 'El acuerdo no tiene llaves de firma TSJ, se subirá');

                $lista_subir_tsj=bandejas::subir_documento_firma_tsjcdmx($request, $docuemntoPDF, "");
                utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "Respuesta de subir: " . json_encode($lista_subir_tsj));

                unset($datos_firma);
                $datos_firma['acuerdo_id']=$input['modal_id_acuerdo'];
                $datos_firma['llaves_documento_firma']=$lista_subir_tsj['subirArchivoResult']['identificadorDocumento'];
    
                $lista_acuerdos['response'][0]['llaves_documento_firma']=$lista_subir_tsj['subirArchivoResult']['identificadorDocumento'];

                //se edita el registro en la DB
                $lista1=acuerdos::guardar_acuerdo_firma_tsj($datos_firma, $request);
                utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "Se sube el documento para firma: " . json_encode($lista1));
            }
            

            //se documento fuente
            if($lista_acuerdos['response'][0]['extension']=='.html'){
                //log
                utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "Intenta descargar documento HTML acuerdo - ultima version: " . $ultima_version);

                $lista_doc=bandejas::documento_descargar($request, $input['modal_id_acuerdo'], $input['modal_codigo_organo'], $ultima_version, 'html');
                if(!isset($lista_doc['response'])){
                    utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "SIN RESPONSE: " . json_encode($lista_doc));
                    $lista_doc=bandejas::documento_descargar($request, $input['modal_id_acuerdo'], $input['modal_codigo_organo'], $ultima_version, 'html');

                    if(!isset($lista_doc['response'])){

                        utilidades::guardarLog($request, 'firma_juzgado', $proceso, 3, "");

                        $error['error']=1;
                        $error['mensaje']='Error con la descarga del documento html.';
                        return response()->json($error);
                    }
                }
                $docuemntoFuente=$lista_doc['response'];
                $extension_final='html';
            }
            else{
                //log
                utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "Intenta descargar documento WORD acuerdo - ultima version: " . $ultima_version);

                $lista_doc=bandejas::documento_descargar($request, $input['modal_id_acuerdo'], $input['modal_codigo_organo'], $ultima_version, 'word');
                if(!isset($lista_doc['response'])){
                    utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "SIN RESPONSE: " . json_encode($lista_doc));
                    $lista_doc=bandejas::documento_descargar($request, $input['modal_id_acuerdo'], $input['modal_codigo_organo'], $ultima_version, 'word');

                    if(!isset($lista_doc['response'])){

                        utilidades::guardarLog($request, 'firma_juzgado', $proceso, 3, "");
                        
                        $error['error']=1;
                        $error['mensaje']='Error con la descarga del documento docx.';
                        return response()->json($error);
                    }
                }     
                $docuemntoFuente=$lista_doc['response'];
                $extension_final='docx';
            }

            //log
            utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "Intenta firmar FIREL");

            $id_proceso_firmado="0";
            //se manda a firmar el pdf a la firel
            if($input['tipo_firma_firel']=='firel'){
                $documentoCER='/san/www/html/sicor_extendido_80/storage/app/'.$url_pfx;
                $pdfFirmado=bandejas::obtener_firma_firel_acuerdo($docuemntoPDF, $documentoCER, "", $input['password']);

                if($pdfFirmado['resultado']==1){
                    //se guarda el documento de la firel
                    $url='/san/www/html/sicor_extendido_80/storage/app/documentos/tmp/'.$input['modal_codigo_organo'].'_'.$input['modal_id_acuerdo'].'_2_firmado.pdf';
                    $pdf_decoded = base64_decode ($pdfFirmado['documento']);
                    $pdf = fopen ($url,'w');
                    fwrite ($pdf,$pdf_decoded);
                    //close output file
                    fclose ($pdf);
                    $documentoPDF_siguiente=$url;

                }
                else{
                    //log
                    utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "ERROR FIREL " . json_encode($pdfFirmado));
                }
            }
            else if($input['tipo_firma_firel']=='fiel'){
                $documentoCER='/san/www/html/sicor_extendido_80/storage/app/'.$url_cer;
                $documentoKEY='/san/www/html/sicor_extendido_80/storage/app/'.$url_key;
                $pdfFirmado=bandejas::obtener_firma_firel_acuerdo($docuemntoPDF, $documentoCER, $documentoKEY, $input['password']);


                if($pdfFirmado['resultado']==1){
                    //se guarda el documento de la firel
                    $url='/san/www/html/sicor_extendido_80/storage/app/documentos/tmp/'.$input['modal_codigo_organo'].'_'.$input['modal_id_acuerdo'].'_2_firmado.pdf';
                    $pdf_decoded = base64_decode ($pdfFirmado['documento']);
                    $pdf = fopen ($url,'w');
                    fwrite ($pdf,$pdf_decoded);
                    //close output file
                    fclose ($pdf);
                    $documentoPDF_siguiente=$url;

                }
                else{
                    //log
                    utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "ERROR FIEL " . json_encode($pdfFirmado));
                }
            }


            else if($input['tipo_firma_firel']=='firel_tsj'){
                $documentoCER='/san/www/html/sicor_extendido_80/storage/app/'.$url_pfx;
                $pdfFirmado=bandejas::crear_participante_firma_tsjcdmx($request, $lista_acuerdos['response'][0]['llaves_documento_firma'], $documentoCER, "", $input['password']);

                if($pdfFirmado['firmaAchivoResult']['estado']==0){

                    utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "LOG RESPUESTA WS FIRMADO TSJ: " . json_encode($pdfFirmado));

                    $pdfFirmado['resultado']=1;
                    $b64PDF=chunk_split(base64_encode(file_get_contents($docuemntoPDF, "r")));
                    $pdfFirmado['documento']=$b64PDF;
                    $documentoPDF_siguiente=$docuemntoPDF;
                    $id_proceso_firmado=$pdfFirmado['firmaAchivoResult']['transferencia'];

                }
                else{
                    //log
                    utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "ERROR FIREL " . json_encode($pdfFirmado));
                    $pdfFirmado['resultado']=0;
                }
            }
            else if($input['tipo_firma_firel']=='fiel_tsj'){
                $documentoCER='/san/www/html/sicor_extendido_80/storage/app/'.$url_cer;
                $documentoKEY='/san/www/html/sicor_extendido_80/storage/app/'.$url_key;
                $pdfFirmado=bandejas::crear_participante_firma_tsjcdmx($request, $docuemntoPDF, $documentoCER, $documentoKEY, $input['password']);


                if($pdfFirmado['firmaAchivoResult']['estado']==0){
                    
                    utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "LOG RESPUESTA WS FIRMADO TSJ: " . json_encode($pdfFirmado));

                    $pdfFirmado['resultado']=1;
                    $b64PDF=chunk_split(base64_encode(file_get_contents($docuemntoPDF, "r")));
                    $pdfFirmado['documento']=$b64PDF;
                    $documentoPDF_siguiente=$docuemntoPDF;
                    $id_proceso_firmado=$pdfFirmado['firmaAchivoResult']['transferencia'];

                }
                else{
                    //log
                    utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "ERROR FIEL " . json_encode($pdfFirmado));
                    $pdfFirmado['resultado']=0;
                }
            }


            else{
                $pdfFirmado['resultado']=1;
                $b64PDF=chunk_split(base64_encode(file_get_contents($docuemntoPDF, "r")));
                $pdfFirmado['documento']=$b64PDF;
                $documentoPDF_siguiente=$docuemntoPDF;
            }

           


            if($pdfFirmado['resultado']==1){


                //log
                utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "Finaliza firmar FIREL");


                                                                                                $time['time'][]=date('H:i:s');
                                                                                                $time['evento'][]='firma firel exitosa';


                //se avanza la bandeja
                if($request->session()->get('juzgado_tipo')=='sala'){
                    $lista_final=$lista=bandejas::bandeja_avanzar_revision($request, $input['modal_id_acuerdo']);
                }
                else{
                    $lista_final=$lista=bandejas::bandeja_avanzar_revision_juzgado($request, $input['modal_id_acuerdo'], 'firmado', $input['tipo_firma_firel'], $id_proceso_firmado);
                }

                utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "Se avanza la firma: ". json_encode($lista));

                if(!isset($lista['response']['id_flujo_participante'])){
                    //se bloquea el firmado del documento
                    utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, 'Acuerdo previamente firmado');
                    $lista_candado=bandejas::candado_firmado($request, $input['modal_id_acuerdo'], "eliminacion");

                    utilidades::guardarLog($request, 'firma_juzgado', $proceso, 3, "");

                    $error['error']=1;
                    $error['mensaje']='Acuerdo previamente firmado.';
                    return response()->json($error);
                }

                //se envia al storage
                $b64Doc=chunk_split(base64_encode(file_get_contents($docuemntoFuente, "r")));

                //se sube el ultimo documento con la firma de la firel
                if($input['tipo_firma_firel']!="sello_sigj"){
                    $b64Doc = $b64Doc;
                    $b64PDF = $pdfFirmado['documento'];
                    $extension_word = $extension_final;
                    bandejas::subir_documentos_flujo($request, $input['modal_id_acuerdo'], $input['modal_codigo_organo'], $lista['response']['id_flujo_participante'], $b64Doc, $extension_word, $b64PDF);
                }

                                                                                                $time['time'][]=date('H:i:s');
                                                                                                $time['evento'][]='se sube el documento, antes de preguntar si ternino el flujo';

                utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "Se avanza y sube el documento firmado por la Firel. Se pregunta si se finalizó el flujo.");


                if($lista['response']['finalizacion_flujo']=='si'){

                    //si es firma tsj se finaliza el documento y se descarga
                    if($input['tipo_firma_firel']=='fiel_tsj' or $input['tipo_firma_firel']=='firel_tsj'){
                        $documento_firmado=bandejas::cerrar_firma_tsjcdmx($request, $lista['response']['llave_firmado_documento'], $input['modal_id_acuerdo'].'.pdf' , $lista['response']['llaves_firmado_firmantes']);
                        //return [$documento_firmado, $lista];

                        $pdfFirmado['documento']=$documento_firmado['generaPDFResult']['pdfEvidencia'];
                        
                        $url='/san/www/html/sicor_extendido_80/storage/app/documentos/tmp/'.$input['modal_codigo_organo'].'_'.$input['modal_id_acuerdo'].'_2_firmado.pdf';
                        $pdf_decoded = base64_decode ($documento_firmado['generaPDFResult']['pdfEvidencia']);
                        $pdf = fopen ($url,'w');
                        fwrite ($pdf,$pdf_decoded);
                        //close output file
                        fclose ($pdf);
                        $documentoPDF_siguiente=$url;
                    }

                    //se sube el documento firmado por los dos antes del sello
                    utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "Se sube el documento con las dos firmas");
                    $b64Doc = $b64Doc;
                    $b64PDF = $pdfFirmado['documento'];
                    $extension_word = $extension_final;
                    bandejas::subir_documentos_flujo_firma($request, $input['modal_id_acuerdo'], $input['modal_codigo_organo'], $lista['response']['id_flujo_participante'], $b64Doc, $extension_word, $b64PDF, 'si');
                    

                    //se obtiene la ultima version del documento.
                    $lista_flujo=acuerdos::obtener_ultima_version_acuerdo($request, $input['modal_id_acuerdo']);
                    if($lista_flujo['status']!=100){
                        return $lista_flujo;
                    }
                    $ultima_version=$lista_flujo['response'];

                    
                    //se documento fuente
                    if($lista_acuerdos['response'][0]['extension']=='.html'){
                        $lista_doc=bandejas::documento_descargar($request, $input['modal_id_acuerdo'], $input['modal_codigo_organo'], $ultima_version, 'html');            
                        $docuemntoFuente=$lista_doc['response'];
                        $extension_final='html';
                    }
                    else{
                        $lista_doc=bandejas::documento_descargar($request, $input['modal_id_acuerdo'], $input['modal_codigo_organo'], $ultima_version, 'word');            
                        $docuemntoFuente=$lista_doc['response'];
                        $extension_final='docx';
                    }


                    //se guarda en la carpeta
                    $url_firma='/san/www/html/sicor_extendido_80/storage/app/firmados/documento_firmado_'.$proceso.'_'.$input['modal_codigo_organo'].'_'.$input['modal_id_acuerdo'].'.pdf';

                    utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "docuemntoPDF: " .  $documentoPDF_siguiente);
                    utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "url_firma: " .  $url_firma);
                    //sleep(3);
                    copy($documentoPDF_siguiente, $url_firma);
                    //$source = file_get_contents($url);
                    //file_put_contents($url_firma, $source); 


                    //se obtiene la firma
                    $lista_txt_firma=bandejas::obtener_firma_sicor_acuerdo($request, $input['modal_id_acuerdo'], $input['modal_codigo_organo']);
                    Storage::put('firmados/firma_'.$proceso.'_'.$input['modal_codigo_organo'].'_'.$input['modal_id_acuerdo'].'.txt', utf8_decode($lista_txt_firma['response']));
                    Storage::put('firmados/firma_voto_'.$proceso.'_'.$input['modal_codigo_organo'].'_'.$input['modal_id_acuerdo'].'.txt', utf8_decode($lista_txt_firma['response_voto']));
                    Storage::put('firmados/id_mide_'.$proceso.'_'.$input['modal_codigo_organo'].'_'.$input['modal_id_acuerdo'].'.txt', utf8_decode($lista_txt_firma['id_mide']));
                    utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "El flujo finalizó, el sello SIGJ es: " .  utf8_decode($lista_txt_firma['response'])); 

                    //se manda a firmar
                    $datos_archivo[]=$url_firma;
                    $lista_firma=bandejas::documento_convertir_pdf($datos_archivo, '_'.$proceso.'_'.$input['modal_codigo_organo'].'_'.$input['modal_id_acuerdo'], $request, $proceso);
                    $lista_final['lista_firma']=$lista_firma;

                    //return $lista_final;

                    utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "Primer sello sigj " . json_encode($lista_final));
                    utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "Finaliza sello sigj " . $lista_firma['file']);
                    
                    $time['time'][]=date('H:i:s');
                    $time['evento'][]='Se firma por el sello sigj: ' . $lista_firma['file'];

                    if($lista_firma['file']=="0"){

                        utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "Segundo intento sello " . $lista_firma['file']);
                        $lista_firma=bandejas::documento_convertir_pdf($datos_archivo, '_'.$proceso.'_'.$input['modal_codigo_organo'].'_'.$input['modal_id_acuerdo']);
                        $lista_final['lista_firma']=$lista_firma;

                        utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "Segundo sello sigj " . json_encode($lista_final));
                        utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "Finaliza sello sigj " . $lista_firma['file']);
                    }

                    if($lista_firma['file']=="0"){

                        utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "TERCERO intento sello " . $lista_firma['file']);
                        $lista_firma=bandejas::documento_convertir_pdf($datos_archivo, '_'.$proceso.'_'.$input['modal_codigo_organo'].'_'.$input['modal_id_acuerdo']);
                        $lista_final['lista_firma']=$lista_firma;

                        utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "TERCERO sello sigj " . json_encode($lista_final));
                        utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "Finaliza sello sigj " . $lista_firma['file']);
                    }

                    if($lista_firma['file']=="0"){

                        utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "CUARTO intento sello " . $lista_firma['file']);
                        $lista_firma=bandejas::documento_convertir_pdf($datos_archivo, '_'.$proceso.'_'.$input['modal_codigo_organo'].'_'.$input['modal_id_acuerdo']);
                        $lista_final['lista_firma']=$lista_firma;

                        utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "CUARTO sello sigj " . json_encode($lista_final));
                        utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "Finaliza sello sigj " . $lista_firma['file']);
                    } 

                    if($lista_firma['file']=="0"){

                        utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "QUINTO intento sello " . $lista_firma['file']);
                        $lista_firma=bandejas::documento_convertir_pdf($datos_archivo, '_'.$proceso.'_'.$input['modal_codigo_organo'].'_'.$input['modal_id_acuerdo']);
                        $lista_final['lista_firma']=$lista_firma;

                        utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "QUINTO sello sigj " . json_encode($lista_final));
                        utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "Finaliza sello sigj " . $lista_firma['file']);
                    }

                    if($lista_firma['file']=="0"){

                        utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "SEXT0 intento sello " . $lista_firma['file']);
                        $lista_firma=bandejas::documento_convertir_pdf($datos_archivo, '_'.$proceso.'_'.$input['modal_codigo_organo'].'_'.$input['modal_id_acuerdo']);
                        $lista_final['lista_firma']=$lista_firma;

                        utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "SEXT0 sello sigj " . json_encode($lista_final));
                        utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "Finaliza sello sigj " . $lista_firma['file']);
                    }



                    //se pone el dato del boletin judicial
                    $id_acuerdo_boletin=$input['modal_id_acuerdo'];
                    $url_temporal_boletin=$lista_firma['file'];
            
            
                    $output = shell_exec("pdfinfo ".$url_temporal_boletin);
                    preg_match('/Pages:\s+([0-9]+)/', $output, $pagecountmatches);
                    $pagecount = $pagecountmatches[1];
                    //print_r($pagecount);
                    utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "Se empieza con el sello del boletin judicial, numero hojas:" .  $pagecount);

            
                    //preg_match('/Page size:\s+([0-9]{0,5}\.?[0-9]{0,3}) x ([0-9]{0,5}\.?[0-9]{0,3})/', $output, $pagesizematches);
                    //print_r($pagesizematches);
            
                    $lista_fecha_publicacion=agendas::obtener_tiempo_disponible($request);
                    $lista_fecha_resolucion=agendas::calcular_dias($request, $lista_fecha_publicacion['response_publicacion'], 1, "no");
                    $lista_fecha_resolucion_1=agendas::calcular_dias($request, $lista_fecha_publicacion['response_publicacion'], 1, "no");
                    $lista_num_boletin=elementos_boletin::calculo_numero_boletin($request, $lista_fecha_publicacion['response_publicacion']);
                    $arr_num_firas=archivos::numero_firmas_acuerdo($request, $request->session()->get('usuario_juzgado'), $id_acuerdo_boletin);


                    $num_firmas_sigj=0;
                    if(isset($arr_num_firas['response_data'])){
                        for($i=0; $i<count($arr_num_firas['response_data']); $i++){
                            if($arr_num_firas['response_data'][$i]['flujo_sala_tipo_firma']=='sello_sigj'){
                                $num_firmas_sigj=$arr_num_firas['response_data'][$i]['numero'];
                            }
                        }
                    }


                    $num_firmas_boletin=$arr_num_firas['response']-$num_firmas_sigj;

                    utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "Se hacen consultas fecha resolucion:" .  $lista_fecha_resolucion['response'] ." Fecha publicacion: ". $lista_fecha_publicacion['response_publicacion'] . " número de boletin: ". $lista_num_boletin['response']['numero'] ." Número de firmantes: " . $num_firmas_boletin. ' $arr_num_firas: ' . json_encode($arr_num_firas) );

                    unset($datos);
                    $datos['fecha_resolucion']=$lista_fecha_publicacion['response_publicacion'];
                    $datos['fecha_publicacion']=$lista_fecha_resolucion_1['response'];
                    $datos['num_boletin']=$lista_num_boletin['response']['numero'];
                    
                    if($version_sello==1){
                        $url_boletin=archivos::llenarSelloLibroGob_v1($request, $url_temporal_boletin, $id_acuerdo_boletin, $datos);
                        //print($url_boletin.'<br>');
                        utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "Se finaliza el sello boletin judicial V1 " . $url_boletin);
                    }
                    if($version_sello==2){
                        $url_boletin=archivos::llenarSelloLibroGob_v2($request, $url_temporal_boletin, $id_acuerdo_boletin, $datos);
                        //print($url_boletin.'<br>');
                        utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "Se finaliza el sello boletin judicial V2 " . $url_boletin);
                    }
                    else{
                        $url_boletin=archivos::llenarSelloLibroGob($request, $url_temporal_boletin, $id_acuerdo_boletin, $datos);
                        //print($url_boletin.'<br>');
                        utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "Se finaliza el sello boletin judicial V0 " . $url_boletin);
                    }

                    $url_unidos=$url_temporal_boletin;
                    $url_separados=public_path('temporales')."/doc_firmado_".$proceso."_".$id_acuerdo_boletin."_";
                    $url_separados_comodin=public_path('temporales')."/doc_firmado_".$proceso."_".$id_acuerdo_boletin."_%04d.pdf";
            
                    $shell_burst="pdftk ".$url_unidos." burst output ".$url_separados_comodin;
                    utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "shell_burst " . $shell_burst);
                    //print($shell_burst.'<br>');
                    $output = shell_exec($shell_burst);
                    utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "shell_burst output" . $output);
                    //print($output);

                    $resta_sello_boletin=$pagecount-$num_firmas_boletin;
            
                    $file_original=public_path('temporales')."/doc_firmado_".$proceso."_".$id_acuerdo_boletin."_".(utilidades::acomodarCeros($resta_sello_boletin, 4)).".pdf";
                    $file_sustituir=public_path('temporales')."/doc_sello_firmado_".$proceso."_".$id_acuerdo_boletin."_".(utilidades::acomodarCeros($resta_sello_boletin, 4)).".pdf";
                    
                    //se copia para hacer el sellado
                    copy($file_original, $file_sustituir);
            
                    $shell_multistamp="pdftk $file_sustituir multistamp $url_boletin output $file_original";
                    utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "shell_multistamp " . $shell_multistamp);
                    //print($shell_multistamp.'<br>');
                    $output = shell_exec($shell_multistamp);
                    utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "shell_multistamp output" . $output);

                    //INFO PARA PONER EL QR ESCANER
                    $file_original_escaner=public_path('temporales')."/doc_firmado_".$proceso."_".$id_acuerdo_boletin."_0001.pdf";
                    $file_sustituir_escaner=public_path('temporales')."/doc_escaner_firmado_".$proceso."_".$id_acuerdo_boletin."_0001.pdf";
                    copy($file_original_escaner, $file_sustituir_escaner);

                    // find page sizes
                    $output = shell_exec("pdfinfo ".$file_original_escaner);
                    preg_match('/Page size:\s+([0-9]{0,5}\.?[0-9]{0,3}) x ([0-9]{0,5}\.?[0-9]{0,3})/', $output, $pagesizematches);
                    //print_r($pagesizematches);
                    $width = round($pagesizematches[1]/2.83);
                    $height = round($pagesizematches[2]/2.83);


                    //se crea el QR y el pdf para el esccaner
                    $metadata=$id_acuerdo_boletin."|6|1|1.0|C|C100|2020|1|||2020-08-27 18:06:58|||1|'.$id_acuerdo_boletin'|sigj_acuerdo-".$request->session()->get('usuario_juzgado');
                    $nombre_escaner=$proceso."_".$id_acuerdo_boletin;
                    $url_scaner=utilidades::caraturlaEscanerQR($request, $metadata, $nombre_escaner, $width, $height);

                    //se pone en la primera hoja
                    $shell_multistamp="pdftk $file_sustituir_escaner stamp $url_scaner output $file_original_escaner";
                    //$output = shell_exec($shell_multistamp);


            
                    $shell_cat="pdftk $url_separados*.pdf cat output $url_unidos";
                    utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "shell_cat " . $shell_cat);
                    //print($shell_cat.'<br>');
                    $output = shell_exec($shell_cat);
                    utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "shell_cat output" . $output);

                    
                    /*
                    //si hay voto, se firma ahora por el sello sigj
                    if($voto==1){
                        
                        //se guarda en la carpeta
                        $url_firma='/san/www/html/sicor_extendido_80/storage/app/firmados/documento_firmado_voto.pdf';
                        file_put_contents($url_firma, base64_decode($pdfFirmado_voto['documento']));

                        //se guarda la firma del voto
                        Storage::put('firmados/firma.txt', utf8_decode($lista_txt_firma['response_voto']));
                        
                        //se manda a firmar
                        $datos_archivo_voto[]=$url_firma;
                        $lista_firma_voto=bandejas::documento_convertir_pdf($datos_archivo_voto);

                        //se cose los dos documentos
                        $arr_cocer_voto=[];
                        $arr_cocer_voto[]=$lista_firma['file'];
                        $arr_cocer_voto[]=$lista_firma_voto['file'];
                        $lista_coser_voto=bandejas::documento_coser_pdf($arr_cocer_voto);

                        $lista_firma['file']='/san/www/html/sicor_extendido_80/public'.$lista_coser_voto['file'];

                                                                                            $time['time'][]=date('H:i:s');
                                                                                            $time['evento'][]='se firma y se cose con el sello sigj';
                        utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "Firma y se cose con el sello sigj");

                    }
                    */


                    //se envia al storage
                    $b64Doc = chunk_split(base64_encode(file_get_contents($docuemntoFuente)));
                    $b64PDF = chunk_split(base64_encode(file_get_contents($lista_firma['file'])));
                    $extension_word = $extension_final;
                    $lista_subir=bandejas::subir_documentos_flujo($request, $input['modal_id_acuerdo'], $input['modal_codigo_organo'], $lista['response']['id_flujo_participante'], $b64Doc, $extension_word, $b64PDF);


                                                                                            $time['time'][]=date('H:i:s');
                                                                                            $time['evento'][]='se sube documento con sello sigj, termino proceso normal de firmado';
                    utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "Se sube documento con sello sigj, termino proceso normal de firmado");





                    /*
                    *   INFO NOTIFICACION FISICA
                    */
                    $lista_archivos=archivos::obtener_archivo($request, $input['modal_id_juicio']);
                    $lista_acuerdos=acuerdos::obtener_archivo_acuerdo($request, $input['modal_id_juicio'], $input['modal_id_acuerdo']);
                    $actor=$demandado=$direccion="";
                    $n=0;
                    $n_1=0;
                    $n_2=0;
                    $arr_fisicos=[];
                    $arr_notificacion_1=[];
                    $arr_notificacion_2=[];
                    if(isset($lista_acuerdos['response'][0]['noti_elect'][0]['id_acuerdo_notificacion'])){

                        $id_acuerdo_notificacion=$lista_acuerdos['response'][0]['noti_elect'][0]['id_acuerdo_notificacion'];

                        //se detecta si hay fisicos y se hace el arreglo
                        if(isset($lista_archivos['response']['partes']['partes']['actor'])){
                            for($i=0; $i<count($lista_archivos['response']['partes']['partes']['actor']); $i++){
                                if($i==0){
                                    $actor.=$lista_archivos['response']['partes']['partes']['actor'][$i]['nombre'];
                                }
                                else{
                                    $actor.=', ' . $lista_archivos['response']['partes']['partes']['actor'][$i]['nombre'];
                                }

                                if($lista_archivos['response']['partes']['partes']['actor'][$i]['notificacion']=="3"){
                                    $arr_fisicos[$n] = [];
                                    $arr_fisicos[$n]['direccion']=$lista_archivos['response']['partes']['partes']['actor'][$i]['direccion'];
                                    $arr_fisicos[$n]['nombre']=$lista_archivos['response']['partes']['partes']['actor'][$i]['nombre'];
                                    $arr_fisicos[$n]['id']=$lista_archivos['response']['partes']['partes']['actor'][$i]['id'];
                                    $n++;
                                }
                                else if($lista_archivos['response']['partes']['partes']['actor'][$i]['notificacion']=="1"){
                                    $arr_notificacion_1[] = [];
                                    $arr_notificacion_1[$n_1]['correo']=$lista_archivos['response']['partes']['partes']['actor'][$i]['correo'];
                                    $arr_notificacion_1[$n_1]['nombre']=$lista_archivos['response']['partes']['partes']['actor'][$i]['nombre'];
                                    $arr_notificacion_1[$n_1]['id']=$lista_archivos['response']['partes']['partes']['actor'][$i]['id'];
                                    $n_1++;
                                }
                                else if($lista_archivos['response']['partes']['partes']['actor'][$i]['notificacion']=="2"){
                                    $arr_notificacion_2[] = [];
                                    $arr_notificacion_2[$n_2]['correo']=$lista_archivos['response']['partes']['partes']['actor'][$i]['correo'];
                                    $arr_notificacion_2[$n_2]['nombre']=$lista_archivos['response']['partes']['partes']['actor'][$i]['nombre'];
                                    $arr_notificacion_2[$n_2]['id']=$lista_archivos['response']['partes']['partes']['actor'][$i]['id'];
                                    $n_2++;
                                }
                            }
                        }
                        $demandado="";
                        if(isset($lista_archivos['response']['partes']['partes']['demandado'][0]['nombre'])){
                            for($i=0; $i<count($lista_archivos['response']['partes']['partes']['demandado']); $i++){
                                if($i==0){
                                    $demandado.=$lista_archivos['response']['partes']['partes']['demandado'][$i]['nombre'];
                                }
                                else{
                                    $demandado.=', ' . $lista_archivos['response']['partes']['partes']['demandado'][$i]['nombre'];
                                }

                                if($lista_archivos['response']['partes']['partes']['demandado'][$i]['notificacion']=="3"){
                                    $arr_fisicos[] = [];
                                    $arr_fisicos[$n]['direccion']=$lista_archivos['response']['partes']['partes']['demandado'][$i]['direccion'];
                                    $arr_fisicos[$n]['nombre']=$lista_archivos['response']['partes']['partes']['demandado'][$i]['nombre'];
                                    $arr_fisicos[$n]['id']=$lista_archivos['response']['partes']['partes']['demandado'][$i]['id'];
                                    $n++;
                                }
                                else if($lista_archivos['response']['partes']['partes']['demandado'][$i]['notificacion']=="1"){
                                    $arr_notificacion_1[] = [];
                                    $arr_notificacion_1[$n_1]['correo']=$lista_archivos['response']['partes']['partes']['demandado'][$i]['correo'];
                                    $arr_notificacion_1[$n_1]['nombre']=$lista_archivos['response']['partes']['partes']['demandado'][$i]['nombre'];
                                    $arr_notificacion_1[$n_1]['id']=$lista_archivos['response']['partes']['partes']['demandado'][$i]['id'];
                                    $n_1++;
                                }
                                else if($lista_archivos['response']['partes']['partes']['demandado'][$i]['notificacion']=="2"){
                                    $arr_notificacion_2[] = [];
                                    $arr_notificacion_2[$n_2]['correo']=$lista_archivos['response']['partes']['partes']['demandado'][$i]['correo'];
                                    $arr_notificacion_2[$n_2]['nombre']=$lista_archivos['response']['partes']['partes']['demandado'][$i]['nombre'];
                                    $arr_notificacion_2[$n_2]['id']=$lista_archivos['response']['partes']['partes']['demandado'][$i]['id'];
                                    $n_2++;
                                }


                            }
                        }

                        if(isset($arr_notificacion_1[0])){

                            for($i=0; $i<$n_1; $i++){
                                unset($datos_2);
                                $datos_2['id_acuerdo_notificacion']=$id_acuerdo_notificacion;
                                $datos_2['codigo_organo']=$request->session()->get('usuario_juzgado');
                                $datos_2['id_parte']=$arr_notificacion_1[$i]['id'];
                                $datos_2['parte_correo']=$arr_notificacion_1[$i]['correo'];
                                $datos_2['tipo_notificacion']=1;
                                $datos_2['noti_elect_estatus_envio']="sin notificar";
                                notificaciones::registrar_notificacion_electronica($request, $datos_2);
                            }
                            
                        }
                        if(isset($arr_notificacion_2[0])){

                            for($i=0; $i<$n_2; $i++){
                                unset($datos_2);
                                $datos_2['id_acuerdo_notificacion']=$id_acuerdo_notificacion;
                                $datos_2['codigo_organo']=$request->session()->get('usuario_juzgado');
                                $datos_2['id_parte']=$arr_notificacion_2[$i]['id'];
                                $datos_2['parte_correo']=$arr_notificacion_2[$i]['correo'];
                                $datos_2['tipo_notificacion']=2;
                                $datos_2['noti_elect_estatus_envio']="sin notificar";
                                notificaciones::registrar_notificacion_electronica($request, $datos_2);
                            }
                            
                        }

                        if(isset($arr_fisicos[0])){

                            //se pide el acuerdo
                            //$lista_flujo=acuerdos::consulta_flujo_detalles($request, $input['modal_id_acuerdo']);
                            //$ultima_version=$lista_flujo['response']['ultima_version_id'];


                            $lista_flujo=acuerdos::obtener_ultima_version_acuerdo($request, $input['modal_id_acuerdo']);
                            if($lista_flujo['status']!=100){
                                return $lista_flujo;
                            }
                            $ultima_version=$lista_flujo['response'];


                            $return[]=$lista_documento=bandejas::documento_descargar($request, $input['modal_id_acuerdo'], $input['modal_codigo_organo'], $ultima_version, 'pdf');
                            //dd($lista_documento);

                            for($i=0; $i<$n; $i++){
                                unset($datos_2);   

                                $direccion = str_replace(array("\r\n", "\n\r", "\r", "\n"), "<br />", $arr_fisicos[$i]['direccion']);

                                


                                $texto="<html><body><br><br><br><p align='left'>C. [%PARTE_NOMBRE%]<br><br>
                                                DOMICILIO:<br> ".$direccion."</p><br>
                                                    
                                                        <p align='justify'>En los autos del juicio [%TIPO_JUICIO%] promovido por [%PARTE_ACTOR%] en contra de [%PARTE_DEMANDADO%], bajo el número de expediente [%NUM_EXPEDIENTE%], el C. Juez dictó el siguiente proveído:</p><br><br></body></html>";
                                                    
                                                        
                                                    
                                $texto2="<html><body><br><br><br>                   
                                                        <p align='justify'>Dejo la presente cédula de notificación a ________________________________________________________________________________________________________________________________________________________________<br>
                                                        Siendo las _________ horas con ____________ minutos, del día ___________ del mes de ________________ del ".date('Y').".</p><br><br><br><br>
                                                    
                                                        <table width='100%'>
                                                            <tr>
                                                                <td width='10%'></td>
                                                                <td width='35%'>____________________</td>
                                                                <td width='10%'></td>
                                                                <td width='35%'>____________________</td>
                                                                <td width='10%'></td>
                                                            </tr>
                                                            <tr>
                                                                <td width='10%'></td>
                                                                <td width='30%'>Persona que recibe</td>
                                                                <td width='20%'></td>
                                                                <td width='30%'>C. Notificador</td>
                                                                <td width='10%'></td>
                                                            </tr>
                                                            </table>
                                                </body></html>";





                                $contenido=str_replace('[%TIPO_JUICIO%]', $lista_archivos['response']['datos_toca'][0]['juicio'], $texto);
                                $contenido=str_replace('[%PARTE_ACTOR%]', $actor, $contenido);
                                $contenido=str_replace('[%PARTE_DEMANDADO%]', $demandado, $contenido);
                                $contenido=str_replace('[%NUM_EXPEDIENTE%]', $lista_archivos['response']['datos_toca'][0]['expediente']."/".$lista_archivos['response']['datos_toca'][0]['anio'], $contenido);
                                $contenido=str_replace('[%JUZGADO%]', $request->session()->get("juzgado_nombre_largo"), $contenido);
                                $contenido=str_replace('[%PARTE_NOMBRE%]', $arr_fisicos[$i]['nombre'], $contenido);



                                //se guarda el juzgado
                                Storage::put('firmados/juzgado_nombre.txt', ucwords(strtolower($request->session()->get('juzgado_nombre_largo'))));

                                //se gurada en local
                                $url_local='/san/www/html/sicor_extendido_80/storage/app/documentos/tmp/'.$input['modal_id_acuerdo'].'_'.$arr_fisicos[$i]['id'].'_3'; 
                                $file = fopen($url_local.'.html', "w");
                                fwrite($file, $contenido);
                                fclose($file);
                                //se manda a convertir a pdf
                                $datos_archvios=[];
                                $datos_archvios[]=$url_local.'.html';
                                $return[]=$doc_arr_1=bandejas::documento_convertir_html_pdf($datos_archvios);



                                //se gurada en local
                                $url_local_2='/san/www/html/sicor_extendido_80/storage/app/documentos/tmp/'.$input['modal_id_acuerdo'].'_'.$arr_fisicos[$i]['id'].'_4'; 
                                $file_1 = fopen($url_local_2.'.html', "w");
                                fwrite($file_1, $texto2);
                                fclose($file_1);
                                //se manda a convertir a pdf
                                $datos_archvios1=[];
                                $datos_archvios1[]=$url_local_2.'.html';
                                $return[]=$doc_arr_2=bandejas::documento_convertir_html_pdf($datos_archvios1);






                                //se cose
                                $arr_coser=[];
                                $arr_coser[]=$doc_arr_1['file'];
                                $arr_coser[]=$lista_documento['response'];
                                $arr_coser[]=$doc_arr_2['file'];
                                $return[]=$arr_coser;
                                $return[]=$final=bandejas::documento_coser_pdf($arr_coser);

                                //se copia en la carpeta
                                copy('/var/www/html/sicor_extendido_80/public'.$final['file'], $url_local.'.pdf');
                                copy('/var/www/html/sicor_extendido_80/public'.$final['file'], '/var/www/html/sicor_extendido_80/public/notificacion/'.$input['modal_id_acuerdo'].'_'.$arr_fisicos[$i]['id'].'_3'.'.pdf');


                                $datos_2['id_acuerdo_notificacion']=$id_acuerdo_notificacion;
                                $datos_2['codigo_organo']=$request->session()->get('usuario_juzgado');
                                $datos_2['id_parte']=$arr_fisicos[$i]['id'];
                                $datos_2['parte_correo']=$arr_fisicos[$i]['direccion'];
                                $datos_2['tipo_notificacion']=3;
                                $datos_2['noti_elect_estatus_envio']="sin notificar";
                                notificaciones::registrar_notificacion_electronica($request, $datos_2);

                                
                            }

                        }
                    }

                    /*
                    *   INFO PARA DIVIRCIOS
                    */
                    $lista_archivos=archivos::obtener_archivo($request, $input['modal_id_juicio']);
                    $lista_acuerdos=acuerdos::obtener_archivo_acuerdo($request, $input['modal_id_juicio'], $input['modal_id_acuerdo']);

                    //para divorcio expres
                    if(isset($lista_archivos['response']['datos_toca'][0]['id_catalogo_juicios']) and isset($lista_acuerdos['response'][0]['acuerdo_tipo_audiencia'])){
                        if(utilidades::buscarCatalogoBandera($request->entorno["catalogos"]["divorcio_expres_sigj"], $lista_archivos['response']['datos_toca'][0]['id_catalogo_juicios']) and $lista_acuerdos['response'][0]['acuerdo_tipo_audiencia']=="virtual"){
                        //if($lista_archivos['response']['datos_toca'][0]['id_catalogo_juicios']==622 or $lista_archivos['response']['datos_toca'][0]['id_catalogo_juicios']==623 or $lista_archivos['response']['datos_toca'][0]['id_catalogo_juicios']==625){
                                            
                            utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "DIV.EXPRES - Se decta el servicio de divorcio expres Catalogo: ". $lista_archivos['response']['datos_toca'][0]['id_catalogo_juicios'] . " - Tipo: " . $lista_acuerdos['response'][0]['acuerdo_etapa_procesal'] );

                            //se obtiene el utimo tiempo
                            $lista_agenda=[];
                            if($lista_acuerdos['response'][0]['acuerdo_etapa_procesal']=='admision'){
                                //se obtiene fecha de proxima publicacion
                                
                                $lista_agenda=agendas::obtener_evento_agendas($request, '0', '0', '0', $input['modal_id_acuerdo']);
                                //dd($lista_agenda['response'][0]);
                            }
                            
                
                            //se obtiene el acuerdo
                            //se obtiene la ultima version
                            $arr_cocer=[];
                            $bandera_miguel=0;
                            $bandera_salvador=0;
                            $bandera_enviar=0;
                            //$lista_flujo=acuerdos::consulta_flujo_detalles($request, $input['modal_id_acuerdo']);
                            //$ultima_version=$lista_flujo['response']['ultima_version_id'];

                            $lista_flujo=acuerdos::obtener_ultima_version_acuerdo($request, $input['modal_id_acuerdo']);
                            if($lista_flujo['status']!=100){
                                return $lista_flujo;
                            }
                            $ultima_version=$lista_flujo['response'];


                            
                            //se descarga el pdf
                            $lista_segundo=bandejas::documento_descargar($request, $input['modal_id_acuerdo'], $input['modal_codigo_organo'], $ultima_version, 'pdf');            
                            $docuemntoPDF=$lista_segundo['response'];
                            $arr_cocer[]=$docuemntoPDF;
                
                                                                                                $time['time'][]=date('H:i:s');
                                                                                                $time['evento'][]='DIV.EXPRES - se consulta ultima hora agenda, descarga ultimo documento firmado';
                            utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "DIV.EXPRES - Descarga ultimo documento firmado ultima_version: " . $ultima_version );


                            $docuemntoPDF= chunk_split(base64_encode(file_get_contents($docuemntoPDF)));
                
                            $lista_coser=[];
                            //se descargan las promociones
                            $datos['tipo_documento']='';
                            $datos['fecha']='';
                            $datos['no_confirmados']='';
                            $datos['confirmados']='';
                            $datos['juzgado_sicor']='';
                            $datos['id_juicio']=$input['modal_id_juicio'];
                            $lista_promociones=promociones::consultarPromociones($request, $datos);
                
                            if($lista_acuerdos['response'][0]['acuerdo_etapa_procesal']=='admision'){     
                                if(isset($lista_promociones['response'][0]['fecha_recepcion'])){
                                    //se pone el catalogo
                                    for($i=0; $i<count($lista_promociones['response']); $i++){
                                        if(utilidades::buscarCatalogoBandera($request->entorno["catalogos"]["divorcio_expres_opc"], $lista_promociones['response'][$i]['tipo_expediente'])){
                                        //if($lista_promociones['response'][$i]['tipo_expediente']==358 or $lista_promociones['response'][$i]['tipo_expediente']==357 or $lista_promociones['response'][$i]['tipo_expediente']==360){
                                            for($j=0; $j<count($lista_promociones['response'][$i]['adjuntos']); $j++){
                                                if($lista_promociones['response'][$i]['adjuntos'][$j]['json_archivo']!=""){
                                                    $lista_promociones['response'][$i]['adjuntos'][$j]['json_arr']=json_decode($lista_promociones['response'][$i]['adjuntos'][$j]['json_archivo']);
                
                                                    //dd($lista_promociones['response'][$i]['adjuntos'][$j]['json_arr']->idDocument);
                
                                                    $gestor64=gestorDocumental::getDocGestor($request, $lista_promociones['response'][$i]['adjuntos'][$j]['json_arr']->idDocument);
                                                    if($gestor64['response']==100){
                                            
                                                        $pdf = fopen ('/var/www/html/sicor_extendido_80/public/temporales/test_'.$j.'.pdf','w');
                                                        fwrite ($pdf,$gestor64['pdf']);
                                                        //close output file
                                                        fclose ($pdf);
                                                        
                                                        $arr_cocer[]='/var/www/html/sicor_extendido_80/public/temporales/test_'.$j.'.pdf';
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                
                                //if(count($arr_cocer)!=0){
                                    $lista_coser=bandejas::documento_coser_pdf($arr_cocer);
                                //}

                                                                                                $time['time'][]=date('H:i:s');
                                                                                                $time['evento'][]='DIV.EXPRES - se descargan del gestor documental y cosen promociones con acuerdo';
                                utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "DIV.EXPRES - se descargan del gestor documental y cosen promociones con acuerdo");
                            }

                            $sala_virtual='https://tsjcdmx.webex.com/meet/jfpo.100';
                            $correo_fiscalia="salvador.rios@tsjcdmx.gob.mx";
                            if($request->session()->get('usuario_juzgado')=="1JFO"){  $correo_fiscalia="david_suarez@fgjcdmx.gob.mx"; $sala_virtual='https://tsjcdmx.webex.com/meet/jfpo.01';  }
                            if($request->session()->get('usuario_juzgado')=="2JFO"){  $correo_fiscalia="david_suarez@fgjcdmx.gob.mx"; $sala_virtual='https://tsjcdmx.webex.com/meet/jfpo.02';  }
                            if($request->session()->get('usuario_juzgado')=="3JFO"){  $correo_fiscalia="david_suarez@fgjcdmx.gob.mx"; $sala_virtual='https://tsjcdmx.webex.com/meet/jfpo.03';  }
                            if($request->session()->get('usuario_juzgado')=="4JFO"){  $correo_fiscalia="david_suarez@fgjcdmx.gob.mx"; $sala_virtual='https://tsjcdmx.webex.com/meet/jfpo.04';  }
                            if($request->session()->get('usuario_juzgado')=="5JFO"){  $correo_fiscalia="david_suarez@fgjcdmx.gob.mx"; $sala_virtual='https://tsjcdmx.webex.com/meet/jfpo.05';  }
                            if($request->session()->get('usuario_juzgado')=="6JFO"){  $correo_fiscalia="rafael_marquez@fgjcdmx.gob.mx"; $sala_virtual='https://tsjcdmx.webex.com/meet/jfpo.06';  }
                            if($request->session()->get('usuario_juzgado')=="7JFO"){  $correo_fiscalia="rafael_marquez@fgjcdmx.gob.mx"; $sala_virtual='https://tsjcdmx.webex.com/meet/jfpo.07';  }
                            if($request->session()->get('usuario_juzgado')=="8JFO"){  $correo_fiscalia="rafael_marquez@fgjcdmx.gob.mx"; $sala_virtual='https://tsjcdmx.webex.com/meet/jfpo.08';  }
                            if($request->session()->get('usuario_juzgado')=="9JFO"){  $correo_fiscalia="rafael_marquez@fgjcdmx.gob.mx"; $sala_virtual='https://tsjcdmx.webex.com/meet/jfpo.09';  }
                            if($request->session()->get('usuario_juzgado')=="10JFO"){  $correo_fiscalia="rafael_marquez@fgjcdmx.gob.mx"; $sala_virtual='https://tsjcdmx.webex.com/meet/jfpo.10';  }

                
                            if($lista_acuerdos['response'][0]['acuerdo_etapa_procesal']=='admision'){
                                $cuerpo='Por medio del presente correo electrónico, se le notifica un acuerdo en el que se admite a trámite su solicitud, donde se señaló fecha de audiencia y sala virtual para su desahogo, a la cual deberán presentarse en línea las partes interesadas.<br><br>
                                Adjunto a este correo se les envía íntegro el auto admisorio, con firma electrónica de la Jueza o Juez, así como de la o el Secretario correspondiente.<br><br>
                                Da fe de la presente notificación la(el) Secretaria(o) de acuerdos del Juzgado de origen que signo el documento adjunto.<br><br>
                                <BR><BR> HORARIO DE LA AUDIENCIA: '.$lista_agenda['response'][0]['fecha'].' '.$lista_agenda['response'][0]['hora_inicio'].'<br><br>La audiencia se celebrará en la sala virtual en: <href="'.$sala_virtual.'" target="_blank">'.$sala_virtual.'</a> '; 
                                $titulo='Admisión '.$lista_archivos['response']['datos_toca'][0]['expediente'].'/'.$lista_archivos['response']['datos_toca'][0]['anio'].' '.$request->session()->get('juzgado_nombre_largo').' Secretaría “'.$lista_archivos['response']['datos_toca'][0]['secretaria'].'”';
                            }
                            else if ($lista_acuerdos['response'][0]['acuerdo_etapa_procesal']=='desechamiento'){

                                $cuerpo='Por medio del presente correo electrónico, se le notifica un acuerdo en el que se desecha su solicitud.';                            
                                $titulo='Desechamiento '.$lista_archivos['response']['datos_toca'][0]['expediente'].'/'.$lista_archivos['response']['datos_toca'][0]['anio'].' '.$request->session()->get('juzgado_nombre_largo').' Secretaría “'.$lista_archivos['response']['datos_toca'][0]['secretaria'].'”';
            
                            }
                            else if ($lista_acuerdos['response'][0]['acuerdo_etapa_procesal']=='prevencion'){
                                
                                $cuerpo='Por medio del presente correo electrónico, se le notifica un acuerdo en el que se previene a las partes para que, dentro del término establecido en dicha resolución, los solicitantes por si o a través de sus representantes legales, desahoguen de manera electrónica el requerimiento, que deberá responderse a esta misma dirección de correo electrónico, con el apercibimiento contenido en la citada resolución.<BR><BR>
                                Adjunto a este correo se les envía íntegro el auto de prevención, con firma electrónica de la Jueza o Juez, así como de la o el Secretario correspondiente.<BR><BR>
                                Da fe de la presente notificación la(el) Secretaria(o) de acuerdos del Juzgado de origen que signo el documento adjunto.<BR><BR>';
                                $titulo='Prevención '.$lista_archivos['response']['datos_toca'][0]['expediente'].'/'.$lista_archivos['response']['datos_toca'][0]['anio'].' '.$request->session()->get('juzgado_nombre_largo').' Secretaría “'.$lista_archivos['response']['datos_toca'][0]['secretaria'].'”';

                            }
                            else if ($lista_acuerdos['response'][0]['acuerdo_etapa_procesal']=='autos'){
                                
                                $cuerpo='Por medio del presente correo electrónico se le notifica una resolución emitida en su expediente, misma que se adjunta para su conocimiento y efectos legales a que haya lugar.<BR><BR>';
                                $titulo='Autos '.$lista_archivos['response']['datos_toca'][0]['expediente'].'/'.$lista_archivos['response']['datos_toca'][0]['anio'].' '.$request->session()->get('juzgado_nombre_largo').' Secretaría “'.$lista_archivos['response']['datos_toca'][0]['secretaria'].'”';

                            }
                            else{ 
                                $cuerpo="VACIO";

                                $titulo="VACIO";
                            }
                
                            //se obtienen a los correos
                            $datos_finales= [];
                            
                            $nombres="";
                            //dd($lista_archivos['response']['partes']['partes']['actor']);
                            for($i=0; $i<count($lista_archivos['response']['partes']['partes']['actor']); $i++){
                
                                if($lista_archivos['response']['partes']['partes']['actor'][$i]['promovente']==0){
                                    $bandera0=1;
                                    if($lista_archivos['response']['partes']['partes']['actor'][$i]['correo']!="" and $lista_archivos['response']['partes']['partes']['actor'][$i]['correo']!="-"){
                                        $datos_correo['correo_destinatario']=$lista_archivos['response']['partes']['partes']['actor'][$i]['correo'];
                                        $nombres.=$datos_correo['correo_destinatario'] . " - ";
                                    }
                                    else{
                                        $datos_correo['correo_destinatario']="";
                                        $bandera0=0;
                                    }
                                    
                                    $nombres.=$lista_archivos['response']['partes']['partes']['actor'][$i]['nombre'] . " <br> ";

                                    $datos_correo['fecha_programacion']=$lista['response']['fecha_a_publicar'].' 07:00:00';
                                    if($request->session()->get('juzgado_correo')!=""){
                                        $datos_correo['correo_remitente']=$request->session()->get('juzgado_correo');
                                    }
                                    else{
                                        $datos_correo['correo_remitente']='sigj@tsjcdmx.gob.mx';
                                    }
                                    $datos_correo['nombre_destinatario']=$lista_archivos['response']['partes']['partes']['actor'][$i]['nombre'];
                                    $datos_correo['nombre_remitente']='TSJCDMX';
                                    $datos_correo['correo_titulo']=$titulo;
                                    $datos_correo['telefonos']="";
                                    $datos_correo['mensaje_sms']='';
                                    $datos_correo['correo_cuerpo']=$cuerpo;
                                    $datos_correo['id_parte']=$lista_archivos['response']['partes']['partes']['actor'][$i]['id'];
                                    $datos_correo['juzgado']=$request->session()->get('usuario_juzgado');
                                    $datos_correo['id_acuerdo']=$input['modal_id_acuerdo'];
                                    $datos_correo['cc']=array (
                                        0 => 
                                        array (
                                        'correo' => 'sigj@tsjcdmx.gob.mx',
                                        'nombre' => 'SIGJ',
                                        ),
                                        1 => 
                                        array (
                                        'correo' => $request->session()->get('juzgado_correo'),
                                        'nombre' => 'juzgado',
                                        ));
                                    $datos_correo['archivos'][0]['url_public']=$docuemntoPDF;
                                    //$datos_correo['archivos']=[];
                                    
                
                                    if($bandera0==1){
                                        $datos_finales[] = $datos_correo;
                                        $bandera_enviar=1;

                                        if($lista_acuerdos['response'][0]['acuerdo_etapa_procesal']=='admision' and $bandera_miguel==0){
                                            $datos_correo['nombre_destinatario']="MIGUEL ACEVEDO";
                                            $datos_correo['correo_destinatario']='miguel.acevedo@tsjcdmx.gob.mx';
                                            $datos_correo['cc']=[];
                                            $datos_finales[] = $datos_correo;
                                            $bandera_miguel=1;
                                        }
                    
                                        if($bandera_salvador==0){
                                            $datos_correo['cc']=[];
                                            $datos_correo['nombre_destinatario']="SALVADOR RIOS";
                                            $datos_correo['correo_destinatario']='salvador.rios@tsjcdmx.gob.mx'; 
                                            $datos_finales[] = $datos_correo;
                    
                                            $datos_correo['cc']=[];
                                            $datos_correo['nombre_destinatario']="LUCIO CHAVEZ";
                                            $datos_correo['correo_destinatario']='lchavez@totalpat.com';
                                            //$datos_finales[] = $datos_correo;

                                            $datos_correo['cc']=[];
                                            $datos_correo['nombre_destinatario']="ISRAEL ARELLANO";
                                            $datos_correo['correo_destinatario']='iarellano@totalpat.com';
                                            //$datos_finales[] = $datos_correo;
                                            $bandera_salvador=1;
                                        }
                                    }
                                }
                                else{
                                    
                                    if($lista_acuerdos['response'][0]['acuerdo_etapa_procesal']=='admision'){
                                        $cuerpo='Por medio del presente correo electrónico, se le notifica un acuerdo en el que se admite a trámite su solicitud, donde se señaló fecha de audiencia y sala virtual para su desahogo, a la cual deberán presentarse en línea las partes interesadas.<br><br>
                                        Adjunto a este correo se les envía íntegro el auto admisorio, con firma electrónica de la Jueza o Juez, así como de la o el Secretario correspondiente.<br><br>
                                        Da fe de la presente notificación la(el) Secretaria(o) de acuerdos del Juzgado de origen que signo el documento adjunto.<br><br>
                                        <BR><BR> HORARIO DE LA AUDIENCIA: '.$lista_agenda['response'][0]['fecha'].' '.$lista_agenda['response'][0]['hora_inicio'].'<br><br>La audiencia se celebrará en la sala virtual en: <href="'.$sala_virtual.'" target="_blank">'.$sala_virtual.'</a> '; 
                                        $titulo='Admisión '.$lista_archivos['response']['datos_toca'][0]['expediente'].'/'.$lista_archivos['response']['datos_toca'][0]['anio'].' '.$request->session()->get('juzgado_nombre_largo').' Secretaría “'.$lista_archivos['response']['datos_toca'][0]['secretaria'].'”';

                                    }
                                    else if ($lista_acuerdos['response'][0]['acuerdo_etapa_procesal']=='desechamiento'){

                                        $cuerpo='Por medio del presente correo electrónico, se le notifica un acuerdo en el que se desecha su solicitud.';
                                        $titulo='Desechamiento '.$lista_archivos['response']['datos_toca'][0]['expediente'].'/'.$lista_archivos['response']['datos_toca'][0]['anio'].' '.$request->session()->get('juzgado_nombre_largo').' Secretaría “'.$lista_archivos['response']['datos_toca'][0]['secretaria'].'”';
                    
                                    }
                                    else if ($lista_acuerdos['response'][0]['acuerdo_etapa_procesal']=='autos'){
                                
                                        $cuerpo='Por medio del presente correo electrónico se le notifica una resolución emitida en su expediente, misma que se adjunta para su conocimiento y efectos legales a que haya lugar.<BR><BR>';
                                        $titulo='Autos '.$lista_archivos['response']['datos_toca'][0]['expediente'].'/'.$lista_archivos['response']['datos_toca'][0]['anio'].' '.$request->session()->get('juzgado_nombre_largo').' Secretaría “'.$lista_archivos['response']['datos_toca'][0]['secretaria'].'”';
        
                                    }
                                    else{
                                        $cuerpo='Por medio del presente correo electrónico, se le notifica un acuerdo en el que se previene a las partes para que, dentro del término establecido en dicha resolución, los solicitantes por si o a través de sus representantes legales, desahoguen de manera electrónica el requerimiento, que deberá responderse a esta misma dirección de correo electrónico, con el apercibimiento contenido en la citada resolución.<BR><BR>
                                                Adjunto a este correo se les envía íntegro el auto de prevención, con firma electrónica de la Jueza o Juez, así como de la o el Secretario correspondiente.<BR><BR>
                                                Da fe de la presente notificación la(el) Secretaria(o) de acuerdos del Juzgado de origen que signo el documento adjunto.<BR><BR>';
                                        $titulo='Prevención '.$lista_archivos['response']['datos_toca'][0]['expediente'].'/'.$lista_archivos['response']['datos_toca'][0]['anio'].' '.$request->session()->get('juzgado_nombre_largo').' Secretaría “'.$lista_archivos['response']['datos_toca'][0]['secretaria'].'”';
                                    }

                                    $datos_correo=[];
                                    $datos_correo['correo_destinatario']=$lista_archivos['response']['partes']['partes']['actor'][$i]['correo'];   
                                    $nombres.=$lista_archivos['response']['partes']['partes']['actor'][$i]['correo'] . " - " . $lista_archivos['response']['partes']['partes']['actor'][$i]['nombre'];
                
                                    //$datos_correo['correo_destinatario']=$lista_promociones['response'][0]['opc_promocion_emailCapturista'];
                                    $datos_correo['fecha_programacion']=$lista['response']['fecha_a_publicar'].' 07:00:00';
                                    if($request->session()->get('juzgado_correo')!=""){
                                        $datos_correo['correo_remitente']=$request->session()->get('juzgado_correo');
                                    }
                                    else{
                                        $datos_correo['correo_remitente']='sigj@tsjcdmx.gob.mx';
                                    }
                                    $datos_correo['nombre_destinatario']=$lista_archivos['response']['partes']['partes']['actor'][$i]['nombre'];
                                    $datos_correo['nombre_remitente']='TSJCDMX';
                                    $datos_correo['correo_titulo']=$titulo;
                                    $datos_correo['telefonos']="";
                                    $datos_correo['mensaje_sms']='';
                                    $datos_correo['correo_cuerpo']=$cuerpo;
                                    $datos_correo['id_parte']=0;
                                    $datos_correo['juzgado']=$request->session()->get('usuario_juzgado');
                                    $datos_correo['id_acuerdo']=$input['modal_id_acuerdo'];
                                    $datos_correo['cc']=array (
                                        0 => 
                                        array (
                                        'correo' => 'sigj@tsjcdmx.gob.mx',
                                        'nombre' => 'SIGJ',
                                        ),
                                        1 => 
                                        array (
                                        'correo' => $request->session()->get('juzgado_correo'),
                                        'nombre' => 'juzgado',
                                        ));
                                    $datos_correo['archivos'][0]['url_public']=$docuemntoPDF;
                                    $datos_finales[] = $datos_correo;
                                    $bandera_enviar=1;
                                }
                            }


                                                                                                $time['time'][]=date('H:i:s');
                                                                                                $time['evento'][]='DIV.EXPRES - configuración correos partes para envios';
                            utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "DIV.EXPRES - configuración correos partes para envios");
                

                            if($lista_acuerdos['response'][0]['acuerdo_etapa_procesal']=='admision' and $bandera_enviar==1){
                
                                $pdf_base64='/var/www/html/sicor_extendido_80/public/'.$lista_coser['file'];
                                $pdf_content = chunk_split(base64_encode(file_get_contents($pdf_base64)));
                
                                $archivos_enviar= array (
                                    0 => 
                                    array (
                                    'url_public' => $pdf_content
                                    )
                                );
                
                                $datos_correo=[];
                                $cuerpo='Por medio del presente correo electrónico, se le da vista con la admisión de la solicitud, fecha de audiencia y sala virtual para el desarrollo de la misma, así como todas y cada una de las actuaciones que integran su expediente digital, para su desahogo. <BR><BR>

                                Adjunto a este correo se les envía íntegro el expediente electrónico, el cual contiene el auto admisorio, con firma electrónica de la Jueza o Juez, así como de la o el Secretario correspondiente.<BR><BR>
                                
                                Da fe de la presente notificación la(el) Secretaria(o) de acuerdos del Juzgado de origen que signo el documento adjunto.<BR><BR>
                                
                                <BR><BR> HORARIO DE LA AUDIENCIA: '.$lista_agenda['response'][0]['fecha'].' '.$lista_agenda['response'][0]['hora_inicio'].'<br><br>La audiencia se celebrará en la sala virtual en: <href="'.$sala_virtual.'" target="_blank">'.$sala_virtual.'</a> '; 
                                
                                $titulo='Vista M.P. '.$lista_archivos['response']['datos_toca'][0]['expediente'].'/'.$lista_archivos['response']['datos_toca'][0]['anio'].' '.$request->session()->get('juzgado_nombre_largo').' Secretaría “'.$lista_archivos['response']['datos_toca'][0]['secretaria'].'”';

                                $datos_correo['correo_destinatario']=$correo_fiscalia;
                                $datos_correo['fecha_programacion']=$lista['response']['fecha_a_publicar'].' 07:00:00';
                                if($request->session()->get('juzgado_correo')!=""){
                                    $datos_correo['correo_remitente']=$request->session()->get('juzgado_correo');
                                }
                                else{
                                    $datos_correo['correo_remitente']='sigj@tsjcdmx.gob.mx';
                                }
                                $datos_correo['nombre_destinatario']='Ficalia PGJ';
                                $datos_correo['nombre_remitente']='TSJCDMX';
                                $datos_correo['correo_titulo']=$titulo;
                                $datos_correo['telefonos']="";
                                $datos_correo['mensaje_sms']='';
                                $datos_correo['correo_cuerpo']=$cuerpo;
                                $datos_correo['id_parte']=0;
                                $datos_correo['juzgado']=$request->session()->get('usuario_juzgado');
                                $datos_correo['id_acuerdo']=$input['modal_id_acuerdo'];
                                $datos_correo['cc']=array (
                                    0 => 
                                    array (
                                    'correo' => 'sigj@tsjcdmx.gob.mx',
                                    'nombre' => 'SIGJ',
                                    ),
                                    1 => 
                                    array (
                                    'correo' => $request->session()->get('juzgado_correo'),
                                    'nombre' => 'juzgado',
                                    ));
                                //$datos_correo['archivos']=[];
                                $datos_correo['archivos']=$archivos_enviar;
                                $datos_finales[] = $datos_correo;
                            }
                
                            if($lista_acuerdos['response'][0]['acuerdo_etapa_procesal']=='sentencia' and $bandera_enviar==1){
                            
                                $datos_correo=[];
                                $datos_finales=[];
                                $cuerpo='ESTE ES EL CUERPO DE LA SENTENCIA <br><br>INTERESADOS<BR>'.$nombres; 
                                $datos_correo['correo_destinatario']='uga.familiar@tsjcdmx.gob.mx';
                                $datos_correo['fecha_programacion']=$lista['response']['fecha_a_publicar'].' 07:00:00';
                                if($request->session()->get('juzgado_correo')!=""){
                                    $datos_correo['correo_remitente']=$request->session()->get('juzgado_correo');
                                }
                                else{
                                    $datos_correo['correo_remitente']='sigj@tsjcdmx.gob.mx';
                                }
                                $datos_correo['nombre_destinatario']='CORREO SENTENCIA';
                                $datos_correo['nombre_remitente']='TSJCDMX';
                                $datos_correo['correo_titulo']='Agenda automática SENTENCIA';
                                $datos_correo['telefonos']="";
                                $datos_correo['mensaje_sms']='';
                                $datos_correo['correo_cuerpo']=$cuerpo;
                                $datos_correo['id_parte']=0;
                                $datos_correo['juzgado']=$request->session()->get('usuario_juzgado');
                                $datos_correo['id_acuerdo']=$input['modal_id_acuerdo'];
                                $datos_correo['cc']=array (
                                    0 => 
                                    array (
                                    'correo' => 'sigj@tsjcdmx.gob.mx',
                                    'nombre' => 'SIGJ',
                                    ),
                                    1 => 
                                    array (
                                    'correo' => $request->session()->get('juzgado_correo'),
                                    'nombre' => 'juzgado',
                                    ));
                                //$datos_correo['archivos']=[];
                                $datos_correo['archivos'][0]['url_public']=$docuemntoPDF;
                                $datos_finales[] = $datos_correo;
                
                                notificaciones::envio_correos($request, $datos_finales);
                                
                            }
                            //elseif($lista_acuerdos['response'][0]['acuerdo_etapa_procesal']!='desechamiento'){
                            else{

                                                                                                $time['time'][]=date('H:i:s');
                                                                                                $time['evento'][]='DIV.EXPRES - se mandan los correos al cron';
                                utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "DIV.EXPRES - se mandan los correos al cron");
                                notificaciones::envio_correos($request, $datos_finales);
                            }


                            $time['time'][]=date('H:i:s');
                            $time['evento'][]='DIV.EXPRES - finalizacion';
                            utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "DIV.EXPRES - finalizacion");

                        }
                    }
                
                }


                //se bloquea el firmado del documento
                utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, 'Se quita el candado de firmado.');
                $lista_candado=bandejas::candado_firmado($request, $input['modal_id_acuerdo'], "eliminacion");

 
                utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "Finalización de la firma.");
                utilidades::guardarLog($request, 'firma_juzgado', $proceso, 3, "");

                $lista_final['time']=$time;
                $lista_final['return']=$return;

                return response()->json($lista_final);
            }
            else{
                                                                                                 $time['time'][]=date('H:i:s');
                                                                                                $time['evento'][]='firma firel ERROR';

                utilidades::guardarLog($request, 'firma_juzgado', $proceso, 4, "No se pudo firmar con fiel, credenciales erroneas.");
                
                //se bloquea el firmado del documento
                utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, 'Se quita el candado de firmado.');
                $lista_candado=bandejas::candado_firmado($request, $input['modal_id_acuerdo'], "eliminacion");

                utilidades::guardarLog($request, 'firma_juzgado', $proceso, 3, "");

                $error['error']=1;
                $error['mensaje']='Error al firmar con el certificado, favor de revisar las llaves y la contraseña.';
                return response()->json($error); 
            }
        }
        else{

            utilidades::guardarLog($request, 'firma_juzgado', $proceso, 4, "El certificado no se cargo exitosamente.");
            utilidades::guardarLog($request, 'firma_juzgado', $proceso, 3, "");

            $error['error']=1;
            $error['mensaje']='El certificado no se cargo exitosamente.';
            return response()->json($error);
        }
        return $input;
    }

    public function url_exists( $url = NULL ) {
 
        if( empty( $url ) ){
            return false;
        }
     
        $options['http'] = array(
            'method' => "HEAD",
            'ignore_errors' => 1,
            'max_redirects' => 0
        );
        $body = @file_get_contents( $url, NULL, stream_context_create( $options ) );
        
        // Ver http://php.net/manual/es/reserved.variables.httpresponseheader.php
        if( isset( $http_response_header ) ) {
            sscanf( $http_response_header[0], 'HTTP/%*d.%*d %d', $httpcode );
     
            // Aceptar solo respuesta 200 (Ok), 301 (redirección permanente) o 302 (redirección temporal)
            $accepted_response = array( 200, 301, 302 );
            if( in_array( $httpcode, $accepted_response ) ) {
                return true;
            } else {
                return false;
            }
         } else {
             return false;
         }
    }

    public static function getMesText($mes){
        $mes_arr[1]='Enero';
        $mes_arr[2]='Febrero';
        $mes_arr[3]='Marzo';
        $mes_arr[4]='Abril';
        $mes_arr[5]='Mayo';
        $mes_arr[6]='Junio';
        $mes_arr[7]='Julio';
        $mes_arr[8]='Agosto';
        $mes_arr[9]='Septiembre';

        $mes_arr['01']='Enero';
        $mes_arr['02']='Febrero';
        $mes_arr['03']='Marzo';
        $mes_arr['04']='Abril';
        $mes_arr['05']='Mayo'; 
        $mes_arr['06']='Junio';
        $mes_arr['07']='Julio';
        $mes_arr['08']='Agosto';
        $mes_arr['09']='Septiembre';


        $mes_arr[10]='Octubre';
        $mes_arr[11]='Noviembre';
        $mes_arr[12]='Diciembre';
        return $mes_arr[$mes];
    }

    public function probarmetodo_1( Request $request ){

        exit;
        $input['modal_id_juicio']=1582151035139;
        $input['modal_id_acuerdo']=1595862060;
        $input['modal_codigo_organo']='1PIC';

        /*
                        *   INFO NOTIFICACION FISICA
                        */
                        $lista_archivos=archivos::obtener_archivo($request, $input['modal_id_juicio']);
                        $lista_acuerdos=acuerdos::obtener_archivo_acuerdo($request, $input['modal_id_juicio'], $input['modal_id_acuerdo']);
                        $actor=$demandado=$direccion="";
                        $n=0;
                        $arr_fisicos=[];
                        if(isset($lista_acuerdos['response'][0]['noti_elect'][0]['id_acuerdo_notificacion'])){

                            $id_acuerdo_notificacion=$lista_acuerdos['response'][0]['noti_elect'][0]['id_acuerdo_notificacion'];

                            //se detecta si hay fisicos y se hace el arreglo
                            if(isset($lista_archivos['response']['partes']['partes']['actor'])){
                                for($i=0; $i<count($lista_archivos['response']['partes']['partes']['actor']); $i++){
                                    if($i==0){
                                        $actor.=$lista_archivos['response']['partes']['partes']['actor'][$i]['nombre'];
                                    }
                                    else{
                                        $actor.=', ' . $lista_archivos['response']['partes']['partes']['actor'][$i]['nombre'];
                                    }
                                    if($lista_archivos['response']['partes']['partes']['actor'][$i]['notificacion']=="3"){
                                        $arr_fisicos[$n] = [];
                                        $arr_fisicos[$n]['direccion']=$lista_archivos['response']['partes']['partes']['actor'][$i]['direccion'];
                                        $arr_fisicos[$n]['nombre']=$lista_archivos['response']['partes']['partes']['actor'][$i]['nombre'];
                                        $arr_fisicos[$n]['id']=$lista_archivos['response']['partes']['partes']['actor'][$i]['id'];
                                        $n++;
                                    }
                                }
                            }
                            $demandado="";
                            if(isset($lista_archivos['response']['partes']['partes']['demandado'][0]['nombre'])){
                                for($i=0; $i<count($lista_archivos['response']['partes']['partes']['demandado']); $i++){
                                    if($i==0){
                                        $demandado.=$lista_archivos['response']['partes']['partes']['demandado'][$i]['nombre'];
                                    }
                                    else{
                                        $demandado.=', ' . $lista_archivos['response']['partes']['partes']['demandado'][$i]['nombre'];
                                    }

                                    if($lista_archivos['response']['partes']['partes']['demandado'][$i]['notificacion']=="3"){
                                        $arr_fisicos[] = [];
                                        $arr_fisicos[$n]['direccion']=$lista_archivos['response']['partes']['partes']['demandado'][$i]['direccion'];
                                        $arr_fisicos[$n]['nombre']=$lista_archivos['response']['partes']['partes']['demandado'][$i]['nombre'];
                                        $arr_fisicos[$n]['id']=$lista_archivos['response']['partes']['partes']['demandado'][$i]['id'];
                                        $n++;
                                    }
                                }
                            }


                            if(isset($arr_fisicos[0])){

                                //se pide el acuerdo
                                //$lista_flujo=acuerdos::consulta_flujo_detalles($request, $input['modal_id_acuerdo']);
                                //$ultima_version=$lista_flujo['response']['ultima_version_id'];


                                $lista_flujo=acuerdos::obtener_ultima_version_acuerdo($request, $input['modal_id_acuerdo']);
                                if($lista_flujo['status']!=100){
                                    return $lista_flujo;
                                }
                                $ultima_version=$lista_flujo['response'];



                                $return[]=$lista_documento=bandejas::documento_descargar($request, $input['modal_id_acuerdo'], $input['modal_codigo_organo'], $ultima_version, 'pdf');
                                //dd($lista_documento);

                                for($i=0; $i<$n; $i++){
                                                    
                                    $direccion = str_replace(array("\r\n", "\n\r", "\r", "\n"), "<br />", $arr_fisicos[$i]['direccion']);

                                    


                                    $texto="<html><body><br><br><br><p align='left'>C. [%PARTE_NOMBRE%]<br><br>
                                                    DOMICILIO:<br> ".$direccion."</p><br>
                                                        
                                                            <p align='justify'>En los autos del juicio [%TIPO_JUICIO%] promovido por [%PARTE_ACTOR%] en contra de [%PARTE_DEMANDADO%], bajo el número de expediente [%NUM_EXPEDIENTE%], el C. Juez dictó el siguiente proveído:</p><br><br>
                                                        
                                                            <br><p align='center'><strong>EXPEDIENTE: [%NUM_EXPEDIENTE%]</strong></p><br><br>
                                                        
                                                        
                                                            <p align='justify'>Dejo la presente cédula de notificación a ________________________________________________________________________________________________________________________________________________________________<br>
                                                            Siendo las _________ horas con ____________ minutos, del día ___________ del mes de ________________ del ".date('Y').".</p><br><br><br><br>
                                                        
                                                            <table width='100%'>
                                                                <tr>
                                                                    <td width='10%'></td>
                                                                    <td width='35%'>____________________</td>
                                                                    <td width='10%'></td>
                                                                    <td width='35%'>____________________</td>
                                                                    <td width='10%'></td>
                                                                </tr>
                                                                <tr>
                                                                    <td width='10%'></td>
                                                                    <td width='30%'>Persona que recibe</td>
                                                                    <td width='20%'></td>
                                                                    <td width='30%'>C. Notificador</td>
                                                                    <td width='10%'></td>
                                                                </tr>
                                                                </table>
                                                    </body></html>";





                                    $contenido=str_replace('[%TIPO_JUICIO%]', $lista_archivos['response']['datos_toca'][0]['juicio'], $texto);
                                    $contenido=str_replace('[%PARTE_ACTOR%]', $actor, $contenido);
                                    $contenido=str_replace('[%PARTE_DEMANDADO%]', $demandado, $contenido);
                                    $contenido=str_replace('[%NUM_EXPEDIENTE%]', $lista_archivos['response']['datos_toca'][0]['expediente']."/".$lista_archivos['response']['datos_toca'][0]['anio'], $contenido);
                                    $contenido=str_replace('[%JUZGADO%]', $request->session()->get("juzgado_nombre_largo"), $contenido);
                                    $contenido=str_replace('[%PARTE_NOMBRE%]', $arr_fisicos[$i]['nombre'], $contenido);



                                    //se guarda el juzgado
                                    Storage::put('firmados/juzgado_nombre.txt', ucwords(strtolower($request->session()->get('juzgado_nombre_largo'))));

                                    //se gurada en local
                                    $url_local='/san/www/html/sicor_extendido_80/storage/app/documentos/tmp/'.$input['modal_id_acuerdo'].'_'.$arr_fisicos[$i]['id'].'_3'; 
                                    $file = fopen($url_local.'.html', "w");
                                    fwrite($file, $contenido);
                                    fclose($file);

                                    //se manda a convertir a pdf
                                    $datos_archvios=[];
                                    $datos_archvios[]=$url_local.'.html';
                                    $return[]=$doc_arr_1=bandejas::documento_convertir_html_pdf($datos_archvios);

                                    //se cose
                                    $arr_coser=[];
                                    $arr_coser[]=$doc_arr_1['file'];
                                    $arr_coser[]=$lista_documento['response'];
                                    $return[]=$final=bandejas::documento_coser_pdf($arr_coser);

                                    //se copia en la carpeta
                                    copy('/var/www/html/sicor_extendido_80/public'.$final['file'], $url_local.'.pdf');
                                    copy('/var/www/html/sicor_extendido_80/public'.$final['file'], '/var/www/html/sicor_extendido_80/public/notificacion/'.$input['modal_id_acuerdo'].'_'.$arr_fisicos[$i]['id'].'_3'.'.pdf');


                                    $datos_2['id_acuerdo_notificacion']=$id_acuerdo_notificacion;
                                    $datos_2['codigo_organo']=$request->session()->get('usuario_juzgado');
                                    $datos_2['id_parte']=$arr_fisicos[$i]['id'];
                                    $datos_2['parte_correo']=$arr_fisicos[$i]['direccion'];
                                    $datos_2['tipo_notificacion']=3;
                                    $datos_2['noti_elect_estatus_envio']="sin notificar";
                                    notificaciones::registrar_notificacion_electronica($request, $datos_2);

                                    
                                }

                            }
                        }

    }

    public function probarmetodo(Request $request ){


        //phpinfo();
        
        //print_r(stream_get_wrappers());
        
        exit;
        $input['modal_id_juicio']=1596128305; 
        $input['modal_id_acuerdo']=1596128728;
        $input['modal_codigo_organo']='5JFO';
        $lista['response']['fecha_a_publicar']="2020-07-31";
         
        
        $lista_archivos=archivos::obtener_archivo($request, $input['modal_id_juicio']);
        $lista_acuerdos=acuerdos::obtener_archivo_acuerdo($request, $input['modal_id_juicio'], $input['modal_id_acuerdo']);

        //dd($lista_archivos);

        //$lista_acuerdos['response'][0]['acuerdo_etapa_procesal']='admision';
        //dd($lista_acuerdos['response'][0]['acuerdo_etapa_procesal']);
        //para divorcio expres

        if(utilidades::buscarCatalogoBandera($request->entorno["catalogos"]["divorcio_expres_sigj"], $lista_archivos['response']['datos_toca'][0]['id_catalogo_juicios'])){
            //if($lista_archivos['response']['datos_toca'][0]['id_catalogo_juicios']==622 or $lista_archivos['response']['datos_toca'][0]['id_catalogo_juicios']==623 or $lista_archivos['response']['datos_toca'][0]['id_catalogo_juicios']==625){
                
    
            //se obtiene el utimo tiempo
            $lista_agenda=[];
            if($lista_acuerdos['response'][0]['acuerdo_etapa_procesal']=='admision'){
                //se obtiene fecha de proxima publicacion
                

                $lista_agenda=agendas::obtener_evento_agendas($request, '0', '0', '0', $input['modal_id_acuerdo']);
                //dd($lista_agenda['response'][0]);
            }
            

            //se obtiene el acuerdo
            //se obtiene la ultima version
            $arr_cocer=[];
            $bandera_miguel=0;
            $bandera_salvador=0;
            //$lista_flujo=acuerdos::consulta_flujo_detalles($request, $input['modal_id_acuerdo']);
            //$ultima_version=$lista_flujo['response']['ultima_version_id'];


            $lista_flujo=acuerdos::obtener_ultima_version_acuerdo($request, $input['modal_id_acuerdo']);
            if($lista_flujo['status']!=100){
                return $lista_flujo;
            }
            $ultima_version=$lista_flujo['response'];
            
            
            //se descarga el pdf
            $lista_segundo=bandejas::documento_descargar($request, $input['modal_id_acuerdo'], $input['modal_codigo_organo'], $ultima_version, 'pdf');            
            $docuemntoPDF=$lista_segundo['response'];
            $arr_cocer[]=$docuemntoPDF;

                                                                                $time['time'][]=date('H:i:s');
                                                                                $time['evento'][]='DIV.EXPRES - se consulta ultima hora agenda, descarga ultimo documento firmado';

            $docuemntoPDF= chunk_split(base64_encode(file_get_contents($docuemntoPDF)));

            $lista_coser=[];
            //se descargan las promociones
            $datos['tipo_documento']='';
            $datos['fecha']='';
            $datos['no_confirmados']='';
            $datos['confirmados']='';
            $datos['juzgado_sicor']='';
            $datos['id_juicio']=$input['modal_id_juicio'];
            $lista_promociones=promociones::consultarPromociones($request, $datos);

            if($lista_acuerdos['response'][0]['acuerdo_etapa_procesal']=='admision'){     
                if(isset($lista_promociones['response'][0]['fecha_recepcion'])){
                    //se pone el catalogo
                    for($i=0; $i<count($lista_promociones['response']); $i++){
                        if(utilidades::buscarCatalogoBandera($request->entorno["catalogos"]["divorcio_expres_opc"], $lista_promociones['response'][$i]['tipo_expediente'])){
                        //if($lista_promociones['response'][$i]['tipo_expediente']==358 or $lista_promociones['response'][$i]['tipo_expediente']==357 or $lista_promociones['response'][$i]['tipo_expediente']==360){
                            for($j=0; $j<count($lista_promociones['response'][$i]['adjuntos']); $j++){
                                if($lista_promociones['response'][$i]['adjuntos'][$j]['json_archivo']!=""){
                                    $lista_promociones['response'][$i]['adjuntos'][$j]['json_arr']=json_decode($lista_promociones['response'][$i]['adjuntos'][$j]['json_archivo']);

                                    //dd($lista_promociones['response'][$i]['adjuntos'][$j]['json_arr']->idDocument);

                                    $gestor64=gestorDocumental::getDocGestor($request, $lista_promociones['response'][$i]['adjuntos'][$j]['json_arr']->idDocument);
                                    if($gestor64['response']==100){
                            
                                        $pdf = fopen ('/var/www/html/sicor_extendido_80/public/temporales/test_'.$j.'.pdf','w');
                                        fwrite ($pdf,$gestor64['pdf']);
                                        //close output file
                                        fclose ($pdf);
                                        
                                        $arr_cocer[]='/var/www/html/sicor_extendido_80/public/temporales/test_'.$j.'.pdf';
                                    }
                                }
                            }
                        }
                    }
                }

                //if(count($arr_cocer)!=0){
                    $lista_coser=bandejas::documento_coser_pdf($arr_cocer);
                //}

                                                                                $time['time'][]=date('H:i:s');
                                                                                $time['evento'][]='DIV.EXPRES - se descargan del gestor documental y cosen promociones con acuerdo';

            }

            $sala_virtual='https://tsj-cdmx.webex.com/meet/jfpo.100';
            $correo_fiscalia="salvador.rios@tsjcdmx.gob.mx";
            if($request->session()->get('usuario_juzgado')=="1JFO"){  $correo_fiscalia="david_suarez@fgjcdmx.gob.mx"; $sala_virtual='https://tsj-cdmx.webex.com/meet/jfpo.01';  }
            if($request->session()->get('usuario_juzgado')=="2JFO"){  $correo_fiscalia="david_suarez@fgjcdmx.gob.mx"; $sala_virtual='https://tsj-cdmx.webex.com/meet/jfpo.02';  }
            if($request->session()->get('usuario_juzgado')=="3JFO"){  $correo_fiscalia="david_suarez@fgjcdmx.gob.mx"; $sala_virtual='https://tsj-cdmx.webex.com/meet/jfpo.03';  }
            if($request->session()->get('usuario_juzgado')=="4JFO"){  $correo_fiscalia="david_suarez@fgjcdmx.gob.mx"; $sala_virtual='https://tsj-cdmx.webex.com/meet/jfpo.04';  }
            if($request->session()->get('usuario_juzgado')=="5JFO"){  $correo_fiscalia="david_suarez@fgjcdmx.gob.mx"; $sala_virtual='https://tsj-cdmx.webex.com/meet/jfpo.05';  }
            if($request->session()->get('usuario_juzgado')=="6JFO"){  $correo_fiscalia="rafael_marquez@fgjcdmx.gob.mx"; $sala_virtual='https://tsj-cdmx.webex.com/meet/jfpo.06';  }
            if($request->session()->get('usuario_juzgado')=="7JFO"){  $correo_fiscalia="rafael_marquez@fgjcdmx.gob.mx"; $sala_virtual='https://tsj-cdmx.webex.com/meet/jfpo.07';  }
            if($request->session()->get('usuario_juzgado')=="8JFO"){  $correo_fiscalia="rafael_marquez@fgjcdmx.gob.mx"; $sala_virtual='https://tsj-cdmx.webex.com/meet/jfpo.08';  }
            if($request->session()->get('usuario_juzgado')=="9JFO"){  $correo_fiscalia="rafael_marquez@fgjcdmx.gob.mx"; $sala_virtual='https://tsj-cdmx.webex.com/meet/jfpo.09';  }
            if($request->session()->get('usuario_juzgado')=="10JFO"){  $correo_fiscalia="rafael_marquez@fgjcdmx.gob.mx"; $sala_virtual='https://tsj-cdmx.webex.com/meet/jfpo.10';  }



            if($lista_acuerdos['response'][0]['acuerdo_etapa_procesal']=='admision'){
                $cuerpo='Por medio del presente correo electrónico, se le notifica un acuerdo en el que se admite a trámite su solicitud, donde se señaló fecha de audiencia y sala virtual para su desahogo, a la cual deberán presentarse en línea las partes interesadas.<br><br>

                Adjunto a este correo se les envía íntegro el auto admisorio, con firma electrónica de la Jueza o Juez, así como de la o el Secretario correspondiente.<br><br>
                
                Da fe de la presente notificación la(el) Secretaria(o) de acuerdos del Juzgado de origen que signo el documento adjunto.<br><br>
                
                <BR><BR> HORARIO DE LA AUDIENCIA: '.$lista_agenda['response'][0]['fecha'].' '.$lista_agenda['response'][0]['hora_inicio'].'<br><br>La audiencia se celebrará en la sala virtual en: <href="'.$sala_virtual.'" target="_blank">'.$sala_virtual.'</a> '; 
            
                $titulo='Admisión '.$lista_archivos['response']['datos_toca'][0]['expediente'].'/'.$lista_archivos['response']['datos_toca'][0]['anio'].' '.$request->session()->get('juzgado_nombre_largo').' Secretaría “'.$lista_archivos['response']['datos_toca'][0]['secretaria'].'”';
            }
            else if ($lista_acuerdos['response'][0]['acuerdo_etapa_procesal']=='prevencion'){
                

                $cuerpo='Por medio del presente correo electrónico, se le notifica un acuerdo en el que se previene a las partes para que, dentro del término establecido en dicha resolución, los solicitantes por si o a través de sus representantes legales, desahoguen de manera electrónica el requerimiento, que deberá responderse a esta misma dirección de correo electrónico, con el apercibimiento contenido en la citada resolución.<BR><BR>

                Adjunto a este correo se les envía íntegro el auto de prevención, con firma electrónica de la Jueza o Juez, así como de la o el Secretario correspondiente.<BR><BR>
                
                Da fe de la presente notificación la(el) Secretaria(o) de acuerdos del Juzgado de origen que signo el documento adjunto.<BR><BR>';
            
                $titulo='Prevención '.$lista_archivos['response']['datos_toca'][0]['expediente'].'/'.$lista_archivos['response']['datos_toca'][0]['anio'].' '.$request->session()->get('juzgado_nombre_largo').' Secretaría “'.$lista_archivos['response']['datos_toca'][0]['secretaria'].'”';

            }
            else if ($lista_acuerdos['response'][0]['acuerdo_etapa_procesal']=='desechamiento'){
                $cuerpo='Por medio del presente correo electrónico, se le notifica un acuerdo en el que se desecha su solicitud.';
            
                $titulo='Desechamiento '.$lista_archivos['response']['datos_toca'][0]['expediente'].'/'.$lista_archivos['response']['datos_toca'][0]['anio'].' '.$request->session()->get('juzgado_nombre_largo').' Secretaría “'.$lista_archivos['response']['datos_toca'][0]['secretaria'].'”';

            }
            else{ 
                $cuerpo="VACIO";

                $titulo="VACIO";
            }

            //se obtienen a los correos
            $datos_finales= [];
            
            $nombres="";
            //dd($lista_archivos['response']['partes']['partes']['actor']);
            for($i=0; $i<count($lista_archivos['response']['partes']['partes']['actor']); $i++){

                if($lista_archivos['response']['partes']['partes']['actor'][$i]['promovente']==0){
                    $bandera0=1;
                    if($lista_archivos['response']['partes']['partes']['actor'][$i]['correo']!="" and $lista_archivos['response']['partes']['partes']['actor'][$i]['correo']!="-"){
                        $datos_correo['correo_destinatario']=$lista_archivos['response']['partes']['partes']['actor'][$i]['correo'];
                        $nombres.=$datos_correo['correo_destinatario'] . " - ";
                    }
                    else{
                        $datos_correo['correo_destinatario']="";
                        $bandera0=0;
                    }
                    
                    $nombres.=$lista_archivos['response']['partes']['partes']['actor'][$i]['nombre'] . " <br> ";

                    $datos_correo['fecha_programacion']=$lista['response']['fecha_a_publicar'].' 07:00:00';
                    if($request->session()->get('juzgado_correo')!=""){
                        $datos_correo['correo_remitente']=$request->session()->get('juzgado_correo');
                    }
                    else{
                        $datos_correo['correo_remitente']='sigj@tsjcdmx.gob.mx';
                    }
                    $datos_correo['nombre_destinatario']=$lista_archivos['response']['partes']['partes']['actor'][$i]['nombre'];
                    $datos_correo['nombre_remitente']='TSJCDMX';
                    $datos_correo['correo_titulo']=$titulo;
                    $datos_correo['telefonos']="";
                    $datos_correo['mensaje_sms']='';
                    $datos_correo['correo_cuerpo']=$cuerpo;
                    $datos_correo['id_parte']=$lista_archivos['response']['partes']['partes']['actor'][$i]['id'];
                    $datos_correo['juzgado']=$request->session()->get('usuario_juzgado');
                    $datos_correo['id_acuerdo']=$input['modal_id_acuerdo'];
                    $datos_correo['cc']=array (
                        0 => 
                        array (
                            'correo' => 'sigj@tsjcdmx.gob.mx',
                            'nombre' => 'SIGJ',
                        ),
                        1 => 
                        array (
                            'correo' => $request->session()->get('juzgado_correo'),
                            'nombre' => 'juzgado',
                        ));
                    $datos_correo['archivos'][0]['url_public']=$docuemntoPDF;
                    //$datos_correo['archivos']=[];


                    if($bandera0==1){
                        $datos_finales[] = $datos_correo;

                        if($lista_acuerdos['response'][0]['acuerdo_etapa_procesal']=='admision' and $bandera_miguel==0){
                            $datos_correo['nombre_destinatario']="MIGUEL ACEVEDO";
                            $datos_correo['correo_destinatario']='miguel.acevedo@tsjcdmx.gob.mx';
                            $datos_correo['cc']=[];
                            $datos_finales[] = $datos_correo;
                            $bandera_miguel=1;
                        }
    
                        if($bandera_salvador==0){
                            $datos_correo['cc']=[];
                            $datos_correo['nombre_destinatario']="SALVADOR RIOS";
                            $datos_correo['correo_destinatario']='salvador.rios@tsjcdmx.gob.mx';
                            $datos_finales[] = $datos_correo;
    
                            $datos_correo['cc']=[];
                            $datos_correo['nombre_destinatario']="ISRAEL ARELLANO";
                            $datos_correo['correo_destinatario']='iarellano@totalpat.com';
                            $datos_finales[] = $datos_correo;
                            $bandera_salvador=1;
                        }



                    }
                }
                else{


                    
                    if($lista_acuerdos['response'][0]['acuerdo_etapa_procesal']=='admision'){
                        $cuerpo='Por medio del presente correo electrónico, se le notifica un acuerdo en el que se admite a trámite su solicitud, donde se señaló fecha de audiencia y sala virtual para su desahogo, a la cual deberán presentarse en línea las partes interesadas.<br><br>

                        Adjunto a este correo se les envía íntegro el auto admisorio, con firma electrónica de la Jueza o Juez, así como de la o el Secretario correspondiente.<br><br>
                        
                        Da fe de la presente notificación la(el) Secretaria(o) de acuerdos del Juzgado de origen que signo el documento adjunto.<br><br>
                        
                        <BR><BR> HORARIO DE LA AUDIENCIA: '.$lista_agenda['response'][0]['fecha'].' '.$lista_agenda['response'][0]['hora_inicio'].'<br><br>La audiencia se celebrará en la sala virtual en: <href="'.$sala_virtual.'" target="_blank">'.$sala_virtual.'</a> '; 
                    
                        $titulo='Admisión '.$lista_archivos['response']['datos_toca'][0]['expediente'].'/'.$lista_archivos['response']['datos_toca'][0]['anio'].' '.$request->session()->get('juzgado_nombre_largo').' Secretaría “'.$lista_archivos['response']['datos_toca'][0]['secretaria'].'”';

                    }
                    else if ($lista_acuerdos['response'][0]['acuerdo_etapa_procesal']=='desechamiento'){
                        $cuerpo='Por medio del presente correo electrónico, se le notifica un acuerdo en el que se desecha su solicitud.';
                    
                        $titulo='Desechamiento '.$lista_archivos['response']['datos_toca'][0]['expediente'].'/'.$lista_archivos['response']['datos_toca'][0]['anio'].' '.$request->session()->get('juzgado_nombre_largo').' Secretaría “'.$lista_archivos['response']['datos_toca'][0]['secretaria'].'”';
    
                    }
                    else{
                        $cuerpo='SE LE NOTIFICA QUE FUE PREVENIDO';
                    }

                    $datos_correo=[];
                    $datos_correo['correo_destinatario']=$lista_archivos['response']['partes']['partes']['actor'][$i]['correo'];   
                    $nombres.=$lista_archivos['response']['partes']['partes']['actor'][$i]['correo'] . " - " . $lista_archivos['response']['partes']['partes']['actor'][$i]['nombre'];

                    //$datos_correo['correo_destinatario']=$lista_promociones['response'][0]['opc_promocion_emailCapturista'];
                    $datos_correo['fecha_programacion']=$lista['response']['fecha_a_publicar'].' 07:00:00';
                    if($request->session()->get('juzgado_correo')!=""){
                        $datos_correo['correo_remitente']=$request->session()->get('juzgado_correo');
                    }
                    else{
                        $datos_correo['correo_remitente']='sigj@tsjcdmx.gob.mx';
                    }
                    $datos_correo['nombre_destinatario']=$lista_archivos['response']['partes']['partes']['actor'][$i]['nombre'];
                    $datos_correo['nombre_remitente']='TSJCDMX';
                    $datos_correo['correo_titulo']=$titulo;
                    $datos_correo['telefonos']="";
                    $datos_correo['mensaje_sms']='';
                    $datos_correo['correo_cuerpo']=$cuerpo;
                    $datos_correo['id_parte']=0;
                    $datos_correo['juzgado']=$request->session()->get('usuario_juzgado');
                    $datos_correo['id_acuerdo']=$input['modal_id_acuerdo'];
                    $datos_correo['cc']=array (
                        0 => 
                        array (
                            'correo' => 'sigj@tsjcdmx.gob.mx',
                            'nombre' => 'SIGJ',
                        ),
                        1 => 
                        array (
                            'correo' => $request->session()->get('juzgado_correo'),
                            'nombre' => 'juzgado',
                        ));
                    $datos_correo['archivos'][0]['url_public']=$docuemntoPDF;
                    $datos_finales[] = $datos_correo;
                }
            }


                                                                                $time['time'][]=date('H:i:s');
                                                                                $time['evento'][]='DIV.EXPRES - configuración correos partes para envios';
            


            if($lista_acuerdos['response'][0]['acuerdo_etapa_procesal']=='admision'){

                $pdf_base64='/var/www/html/sicor_extendido_80/public/'.$lista_coser['file'];
                $pdf_content = chunk_split(base64_encode(file_get_contents($pdf_base64)));

                $archivos_enviar= array (
                    0 => 
                    array (
                    'url_public' => $pdf_content
                    )
                );

                $datos_correo=[];
                $cuerpo='Por medio del presente correo electrónico, se le da vista con la admisión de la solicitud, fecha de audiencia y sala virtual para el desarrollo de la misma, así como todas y cada una de las actuaciones que integran su expediente digital, para su desahogo. <BR><BR>

                Adjunto a este correo se les envía íntegro el expediente electrónico, el cual contiene el auto admisorio, con firma electrónica de la Jueza o Juez, así como de la o el Secretario correspondiente.<BR><BR>
                
                Da fe de la presente notificación la(el) Secretaria(o) de acuerdos del Juzgado de origen que signo el documento adjunto.<BR><BR>
                
                <BR><BR> HORARIO DE LA AUDIENCIA: '.$lista_agenda['response'][0]['fecha'].' '.$lista_agenda['response'][0]['hora_inicio'].'<br><br>La audiencia se celebrará en la sala virtual en: <href="'.$sala_virtual.'" target="_blank">'.$sala_virtual.'</a> '; 
                
                $titulo='Vista M.P. '.$lista_archivos['response']['datos_toca'][0]['expediente'].'/'.$lista_archivos['response']['datos_toca'][0]['anio'].' '.$request->session()->get('juzgado_nombre_largo').' Secretaría “'.$lista_archivos['response']['datos_toca'][0]['secretaria'].'”';

                $datos_correo['correo_destinatario']=$correo_fiscalia;
                $datos_correo['fecha_programacion']=$lista['response']['fecha_a_publicar'].' 07:00:00';
                if($request->session()->get('juzgado_correo')!=""){
                    $datos_correo['correo_remitente']=$request->session()->get('juzgado_correo');
                }
                else{
                    $datos_correo['correo_remitente']='sigj@tsjcdmx.gob.mx';
                }
                $datos_correo['nombre_destinatario']='Ficalia PGJ';
                $datos_correo['nombre_remitente']='TSJCDMX';
                $datos_correo['correo_titulo']=$titulo;
                $datos_correo['telefonos']="";
                $datos_correo['mensaje_sms']='';
                $datos_correo['correo_cuerpo']=$cuerpo;
                $datos_correo['id_parte']=0;
                $datos_correo['juzgado']=0;
                $datos_correo['id_acuerdo']=$input['modal_id_acuerdo'];
                $datos_correo['cc']=[];
                //$datos_correo['archivos']=[];
                $datos_correo['archivos']=$archivos_enviar;
                $datos_finales[] = $datos_correo;
            

                
            }

            if($lista_acuerdos['response'][0]['acuerdo_etapa_procesal']=='sentencia'){
                
                $datos_correo=[];
                $datos_finales=[];
                $cuerpo='ESTE ES EL CUERPO DE LA SENTENCIA <br><br>INTERESADOS<BR>'.$nombres; 
                $datos_correo['correo_destinatario']='uga.familiar@tsjcdmx.gob.mx';
                $datos_correo['fecha_programacion']=$lista['response']['fecha_a_publicar'].' 07:00:00';
                if($request->session()->get('juzgado_correo')!=""){
                    $datos_correo['correo_remitente']=$request->session()->get('juzgado_correo');
                }
                else{
                    $datos_correo['correo_remitente']='sigj@tsjcdmx.gob.mx';
                }
                $datos_correo['nombre_destinatario']='CORREO SENTENCIA';
                $datos_correo['nombre_remitente']='TSJCDMX';
                $datos_correo['correo_titulo']='Agenda automática SENTENCIA';
                $datos_correo['telefonos']="";
                $datos_correo['mensaje_sms']='';
                $datos_correo['correo_cuerpo']=$cuerpo;
                $datos_correo['id_parte']=0;
                $datos_correo['juzgado']=0;
                $datos_correo['id_acuerdo']=$input['modal_id_acuerdo'];
                $datos_correo['cc']=[];
                //$datos_correo['archivos']=[];
                $datos_correo['archivos'][0]['url_public']=$docuemntoPDF;
                $datos_finales[] = $datos_correo;

                notificaciones::envio_correos($request, $datos_finales);

            }
            //elseif($lista_acuerdos['response'][0]['acuerdo_etapa_procesal']!='desechamiento'){
            else{

                                                                                $time['time'][]=date('H:i:s');
                                                                                $time['evento'][]='DIV.EXPRES - se mandan los correos al cron';

                notificaciones::envio_correos($request, $datos_finales);
            }
        }

                                                                                $time['time'][]=date('H:i:s');
                                                                                $time['evento'][]='DIV.EXPRES - finalizacion';
    }
    
    public function crearSelloSigj(Request $request){

        $input = $request->all();

        $input['modal_id_juicio']=$input['id_juicio'];
        $input['modal_id_acuerdo']=$input['id_acuerdo'];
        $input['modal_codigo_organo']=$input['codigo_organo'];
        //$fecha='2020-11-27';
        
        $proceso = rand(100, 999);
        $version_sello=0;
        

        //$lista_archivos=archivos::obtener_archivo($request, $input['modal_id_juicio']);
        $lista_acuerdos=acuerdos::obtener_archivo_acuerdo_sinse($request, $input['modal_id_juicio'], $input['modal_id_acuerdo'], $input['modal_codigo_organo']);
        
        $fecha = explode(" ",$lista_acuerdos['response'][0]['fecha_publicacion'])[0];

        //si existe la version sello
        if(isset($lista_acuerdos['response'][0]['version_sello'])){
            $version_sello=$lista_acuerdos['response'][0]['version_sello'];
        }

        

        //dd($lista_acuerdos);

        
        $lista_flujo=acuerdos::obtener_ultima_version_acuerdo_sinse($request, $input['modal_id_acuerdo'], $input['modal_codigo_organo']);
        if($lista_flujo['status']!=100){
            return $lista_flujo;
        }
        $ultima_version=$lista_flujo['response'];
        

        utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "Se intenta descargar nuevamente el documento para agregar el sello sigj ultima_version:" .  $ultima_version);

        //se descarga el pdf
        $lista_segundo=bandejas::documento_descargar_sinse($request, $input['modal_id_acuerdo'], $input['modal_codigo_organo'], 0, 'pdf', 'si');    
        $docuemntoPDF=$lista_segundo['response'];

        //dd($lista_segundo);
        
        //se documento fuente
        if($lista_acuerdos['response'][0]['extension']=='.html'){
            $lista_doc=bandejas::documento_descargar_sinse($request, $input['modal_id_acuerdo'], $input['modal_codigo_organo'], $ultima_version, 'html');            
            $docuemntoFuente=$lista_doc['response'];
            $extension_final='html';
        }
        else{
            $lista_doc=bandejas::documento_descargar_sinse($request, $input['modal_id_acuerdo'], $input['modal_codigo_organo'], $ultima_version, 'word');
            $docuemntoFuente=$lista_doc['response'];
            $extension_final='docx';
        }
        

        //se guarda en la carpeta
        $url_firma='/san/www/html/sicor_extendido_80/storage/app/firmados/documento_firmado_'.$input['modal_codigo_organo'].'_'.$input['modal_id_acuerdo'].'.pdf';
        $url = $docuemntoPDF;
        $source = file_get_contents($url);
        file_put_contents($url_firma, $source);


        //se obtiene la firma
        $lista_txt_firma=bandejas::obtener_firma_sicor_acuerdo_sinse($request, $input['modal_id_acuerdo'], $input['modal_codigo_organo']);
        //return $lista_txt_firma;
        //dd($lista_txt_firma);
        Storage::put('firmados/firma.txt', utf8_decode($lista_txt_firma['response']));
        Storage::put('firmados/firma_voto.txt', utf8_decode($lista_txt_firma['response_voto']));
        Storage::put('firmados/id_mide.txt', utf8_decode($lista_txt_firma['id_mide']));
        utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "El flujo finalizó, el sello SIGJ es: " .  utf8_decode($lista_txt_firma['response']));

        //se manda a firmar
        $datos_archivo[]=$url_firma;
        $lista_firma=bandejas::documento_convertir_pdf($datos_archivo);
        utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "Finaliza sello sigj " . $lista_firma['file']);

        $time['time'][]=date('H:i:s');
        $time['evento'][]='se descarga, y se firma por el sello sigj: ' . $lista_firma['file'];





        //se pone el dato del boletin judicial
        $id_acuerdo_boletin=$input['modal_id_acuerdo'];
        $url_temporal_boletin=$lista_firma['file'];


        $output = shell_exec("pdfinfo ".$url_temporal_boletin);
        preg_match('/Pages:\s+([0-9]+)/', $output, $pagecountmatches);
        $pagecount = $pagecountmatches[1];
        //print_r($pagecount);
        utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "Se empieza con el sello del boletin judicial, numero hojas:" .  $pagecount);


        //preg_match('/Page size:\s+([0-9]{0,5}\.?[0-9]{0,3}) x ([0-9]{0,5}\.?[0-9]{0,3})/', $output, $pagesizematches);
        //print_r($pagesizematches);

        //$lista_fecha_publicacion=agendas::obtener_tiempo_disponible($request);
        $lista_fecha_publicacion['response_publicacion']=$fecha;
        //dd($lista_fecha_publicacion);
        $lista_fecha_resolucion=agendas::calcular_dias_sinse($request, $lista_fecha_publicacion['response_publicacion'], 1, "no");
        $lista_fecha_resolucion_1=agendas::calcular_dias_sinse($request, $lista_fecha_publicacion['response_publicacion'], 1, "no");

        $lista_num_boletin=elementos_boletin::calculo_numero_boletin_sinse($request, $lista_fecha_publicacion['response_publicacion']);
        $arr_num_firas=archivos::numero_firmas_acuerdo_sinse($request, $input['modal_codigo_organo'], $id_acuerdo_boletin);


        $num_firmas_sigj=0;
        if(isset($arr_num_firas['response_data'])){
            for($i=0; $i<count($arr_num_firas['response_data']); $i++){
                if($arr_num_firas['response_data'][$i]['flujo_sala_tipo_firma']=='sello_sigj'){
                    $num_firmas_sigj=$arr_num_firas['response_data'][$i]['numero'];
                }
            }
        }


        $num_firmas_boletin=$arr_num_firas['response']-$num_firmas_sigj;

        utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "Se hacen consultas fecha resolucion:" .  $lista_fecha_resolucion['response'] ." Fecha publicacion: ". $lista_fecha_publicacion['response_publicacion'] . " número de boletin: ". $lista_num_boletin['response']['numero'] ." Número de firmantes: " . $num_firmas_boletin);

        unset($datos);
        $datos['fecha_resolucion']=$lista_fecha_publicacion['response_publicacion'];
        $datos['fecha_publicacion']=$lista_fecha_resolucion_1['response'];
        $datos['num_boletin']=$lista_num_boletin['response']['numero'];
        
        //$url_boletin=archivos::llenarSelloLibroGob($request, $url_temporal_boletin, $id_acuerdo_boletin, $datos);

        if($version_sello==1 or 1){
            $url_boletin=archivos::llenarSelloLibroGob_v1($request, $url_temporal_boletin, $id_acuerdo_boletin, $datos);
            //print($url_boletin.'<br>');
            utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "Se finaliza el sello boletin judicial " . $url_boletin);
        }
        else{
            $url_boletin=archivos::llenarSelloLibroGob($request, $url_temporal_boletin, $id_acuerdo_boletin, $datos);
            //print($url_boletin.'<br>');
            utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "Se finaliza el sello boletin judicial " . $url_boletin);
        }




        //print($url_boletin.'<br>');
        utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "Se finaliza el sello boletin judicial " . $url_boletin);


        $url_unidos=$url_temporal_boletin;
        $url_separados=public_path('temporales')."/doc_firmado_".$proceso."_".$id_acuerdo_boletin."_";
        $url_separados_comodin=public_path('temporales')."/doc_firmado_".$proceso."_".$id_acuerdo_boletin."_%04d.pdf";

        $shell_burst="pdftk ".$url_unidos." burst output ".$url_separados_comodin;
        utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "shell_burst " . $shell_burst);
        //print($shell_burst.'<br>');
        $output = shell_exec($shell_burst);
        //print($output);

        $resta_sello_boletin=$pagecount-$num_firmas_boletin;

        $file_original=public_path('temporales')."/doc_firmado_".$proceso."_".$id_acuerdo_boletin."_".(utilidades::acomodarCeros($resta_sello_boletin, 4)).".pdf";
        $file_sustituir=public_path('temporales')."/doc_sello_firmado_".$proceso."_".$id_acuerdo_boletin."_".(utilidades::acomodarCeros($resta_sello_boletin, 4)).".pdf";
        
        //se copia para hacer el sellado
        copy($file_original, $file_sustituir);

        $shell_multistamp="pdftk $file_sustituir multistamp $url_boletin output $file_original";
        utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "shell_multistamp " . $shell_multistamp);
        //print($shell_multistamp.'<br>');
        $output = shell_exec($shell_multistamp);
        

        //INFO PARA PONER EL QR ESCANER
        $file_original_escaner=public_path('temporales')."/doc_firmado_".$proceso."_".$id_acuerdo_boletin."_0001.pdf";
        $file_sustituir_escaner=public_path('temporales')."/doc_escaner_firmado_".$proceso."_".$id_acuerdo_boletin."_0001.pdf";
        copy($file_original_escaner, $file_sustituir_escaner);

        // find page sizes
        $output = shell_exec("pdfinfo ".$file_original_escaner);
        preg_match('/Page size:\s+([0-9]{0,5}\.?[0-9]{0,3}) x ([0-9]{0,5}\.?[0-9]{0,3})/', $output, $pagesizematches);
        //print_r($pagesizematches);
        $width = round($pagesizematches[1]/2.83);
        $height = round($pagesizematches[2]/2.83); 


        //se crea el QR y el pdf para el esccaner
        $metadata=$id_acuerdo_boletin."|6|1|1.0|C|C100|2020|1|||2020-08-27 18:06:58|||1|'.$id_acuerdo_boletin'|sigj_acuerdo-".$input['modal_codigo_organo'];
        $nombre_escaner=$proceso."_".$id_acuerdo_boletin;
        $url_scaner=utilidades::caraturlaEscanerQR($request, $metadata, $nombre_escaner, $width, $height);

        //se pone en la primera hoja
        $shell_multistamp="pdftk $file_sustituir_escaner stamp $url_scaner output $file_original_escaner";
        //$output = shell_exec($shell_multistamp);



        $shell_cat="pdftk $url_separados*.pdf cat output $url_unidos";
        utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "shell_cat " . $shell_cat);
        //print($shell_cat.'<br>');
        $output = shell_exec($shell_cat);


        $consultar_flujo=acuerdos::consulta_flujo_detalles_estadistica($request, $input['modal_id_acuerdo'], $input['modal_codigo_organo']);
        
        



        //se envia al storage
        $b64Doc = chunk_split(base64_encode(file_get_contents($docuemntoFuente)));
        $b64PDF = chunk_split(base64_encode(file_get_contents($lista_firma['file'])));
        $extension_word = $extension_final;
        $lista_subir=bandejas::subir_documentos_flujo_sinse($request, $input['modal_id_acuerdo'], $input['modal_codigo_organo'], $consultar_flujo['response']['firmas'][0]['id_flujo_sala'], $b64Doc, $extension_word, $b64PDF, $consultar_flujo['response']['firmas'][0]['id_usuario']);


                                                                                $time['time'][]=date('H:i:s');
                                                                                $time['evento'][]='se sube documento con sello sigj, termino proceso normal de firmado';
        //utilidades::guardarLog($request, 'firma_juzgado', $proceso, 0, "Se sube documento con sello sigj, termino proceso normal de firmado");


        return 1;
        

    }

    public function firmar_tsjcdmx(Request $request){
        
        $url_pdf="/san/www/html/sicor_extendido_80/public/temporales/1608096859136.pdf";
        $url_certificado="/san/www/html/sicor_extendido_80/storage/app/private/8Hs5AplmKlOZhHtdKWbkSjXKZs9cpYENlFLtrl9w.bin";
        $url_key="";
        $password="Lbh_220609";

        $return = bandejas::subir_documento_firma_tsjcdmx($request, $url_pdf, $url_key, $password);
        $return2 = bandejas::crear_participante_firma_tsjcdmx($request, $return['subirArchivoResult']['identificadorDocumento'], $url_certificado, "", $password);
        $return3 = bandejas::cerrar_firma_tsjcdmx($request, $return['subirArchivoResult']['identificadorDocumento'], "Inche_raul.pdf", $return2['firmaAchivoResult']['transferencia']);

        return [$return, $return2, $return3];
    }
}