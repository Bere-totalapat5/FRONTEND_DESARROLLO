@php
  use App\Http\Controllers\clases\humanRelativeDate;
  use App\Http\Controllers\clases\utilidades;
  $humanRelativeDate = new humanRelativeDate();
@endphp

@extends('layouts.index')

@section('contenido-pageheader')
 <ol class="breadcrumb slim-breadcrumb">
    <li class="breadcrumb-item"><a href="#">ADIP</a></li>
    <li class="breadcrumb-item"><a href="#"> Consulta de reportes ADIP</a></li>
 </ol>
 <h6 class="slim-pagetitle">Consulta de reportes ADIP </h6>
@endsection

@section('contenido-principal')

    <div class="section-wrapper" style="max-width: 100%;">
        <div class="form-layout">

            @php
                $meses = ['','ENERO', 'FEBRERO','MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'];
                $dias = ['', 'LUNES', 'MARTES', 'MIERCOLES', 'JUEVES', 'VIERNES', 'SABADO', 'DOMINGO'];
                $tipos_usuarios_permitidos = [1,18,20,101,102];
            @endphp

            <div class="d-flex justify-content-between">
                <a style="border:1px solid #ccc; width: 60px;  display:flex; text-align:center; align-items:center; text-align: center;" data-toggle="collapse" data-parent="#accordion" href="#collapseSearchAdvance" aria-expanded="false" aria-controls="collapseSearchAdvance" class="btn btn-default" >
                    <i class="fa fa-search" aria-hidden="true"></i>
                    <i class="fas fa-chevron-down" style="margin-left: 5%; font-size:0.7em;"></i> 
                </a>
                
                @php
                    $id_user = $request->session()->get('id_tipo_usuario');
                    if(!in_array($id_user, $tipos_usuarios_permitidos)){
                    
                      echo '<a  style="background: #848F33 !important; color:#fff; width:80%;" data-toggle="collapse" data-parent="#accordion" href="#collapseSearchAdvance1" aria-expanded="false" aria-controls="collapseSearchAdvance1" class="btn btn-default">
                                <label style="color: #fff !important;" id="titulo_reporte_adip"></label>
                            </a>';
                    }else{
                        echo '<div class="contenedor_header_adip">
                                <select class="form-control" style="width:10%; height:100%; background: #848F33 !important; color:#fff; border:none;" id="elige_unidad_editar">
                                    <option selected value="001">Unidad 1</option>
                                    <option value="002">Unidad 2</option>
                                    <option value="003">Unidad 3</option>
                                    <option value="004">Unidad 4</option>
                                    <option value="005">Unidad 5</option>
                                    <option value="006">Unidad 6</option>
                                    <option value="007">Unidad 7</option>
                                    <option value="008">Unidad 8</option>
                                    <option value="009">Unidad 9</option>
                                    <option value="010">Unidad 10</option>
                                    <option value="011">Unidad 11</option>
                                    <option value="012">Unidad 12</option>
                                </select>
                                <a  style="background: #848F33 !important; color:#fff; width:100%;" data-toggle="collapse" data-parent="#accordion" href="#collapseSearchAdvance1" aria-expanded="false" aria-controls="collapseSearchAdvance1" class="btn btn-default">
                                    <label style="color: #fff !important;" id="titulo_reporte_adip"></label>
                                </a>
                            </div>
                            <a style="border:1px solid #ccc; width: 60px; display:flex; text-align:center; align-items:center; text-align: center;" data-toggle="collapse" data-parent="#accordion" href="#collapseSearchAdvance2" aria-expanded="false" aria-controls="collapseSearchAdvance2" class="btn btn-default" >
                                <i class="fa fa-cogs" aria-hidden="true"></i>
                                <i class="fas fa-chevron-down" style="margin-left: 5%; font-size:0.7em;"></i> 
                            </a>
                            ';
                    }
                @endphp
            </div>

            {{--  Busqueda Avanzada  --}}
            <div id="accordion" class="accordion-one mg-b-15" role="tablist" aria-multiselectable="true">
                <div class="card">
                  {{--  header del card  
                  <div class="card-header" role="tab" id="headingOne">
                  </div>--}}
                  {{--  body del card  --}}
                  <div id="collapseSearchAdvance" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                        <div class="card-body">
                          {{--  Formulario de la busqueda avanzada --}}
                          <div class="row mg-b-25">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="label">Fecha de Inicial : </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control fc-datepicker" placeholder="DD-MM-AAAA" id="fechaini" name="" autocomplete="off">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="label">Fecha Final : </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control fc-datepicker" placeholder="DD-MM-AAAA" id="fechafin" name="" autocomplete="off">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="label">Tipo Reporte:</label>
                                    @php
                                        $id_user = $request->session()->get('id_tipo_usuario');
                                        if($id_user != 39){
                                        
                                            echo '<select name="tipo_reporte" id="tipo_reporte" class="form-control ">
                                                <option value="-">Seleccione un tipo de reporte</option>
                                                <option value="adip">ADIP</option>
                                                <option value="estadistico">ESTADISTICA</option>
                                                <option value="audiencias_p">AUDIENCIAS</option>
                                                <option value="delitos">DELITOS</option>
                                                <option value="cln">CARPETAS LN</option>
                                            </select>';
                                        }else{
                                            echo '<select name="tipo_reporte" id="tipo_reporte" class="form-control ">
                                                <option value="-">Seleccione un tipo de reporte</option>
                                                <option value="adip">ADIP</option>
                                            </select>';
                                        }
                                    @endphp

                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="label">Id Reporte:</label>
                                    <input type="text" class="form-control" id="searchIdReporte" />
                                </div>
                            </div>
                          </div>
                          {{--  Boton para filtrar  --}}
                          <div class="row">
                            <div class="col-lg-12">
                                <button type="button" class="btn btn-primary btn-sm btn-block mg-b-10" data-toggle="collapse" data-target="#demo" onclick="sec_ajax('primera');">Filtrar</button>
                            </div>
                          </div>

                        </div>
                  </div>
                </div>
            </div>        

            {{--  horarios  --}}
            <div id="accordion" class="accordion-one mg-b-15" role="tablist" aria-multiselectable="true">
                <div class="card">
                  {{--  body del card  --}}
                  <div id="collapseSearchAdvance2" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                        <div class="card-body">

                            <div style="width: 230px; border-bottom:3px solid #848F33; margin: 1% 0; text-align:left; font-size: 1.2em;">
                                Horarios de Cierre de Bloque
                            </div>

                            {{--  Formulario de la busqueda avanzada --}}
                            <div class="row mg-b-2">
                                @php
                                    $html = '';
                                    foreach($unidades as $unidad){
                                        $id_unidad = $unidad['id_unidad_gestion'];
                                        $clave_unidad = $unidad['clave_unidad'];
                                        $numero_unidad = intval($unidad['clave_unidad']);
                                        $horario_adip = $unidad['horario_adip'];
                                        if($numero_unidad < 13){
                                            $html .= '<div class="col-md-3">
                                                <label class="sr-only" for="inlineFormInputGroup">Unidad '.$numero_unidad.'</label>
                                                <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text" style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
                                                        <i class="far fa-building"></i> 
                                                        <span style="font-weight: bold;margin-top: 12%;font-size: 0.7em;">unidad '.$numero_unidad.'</span>
                                                    </div>
                                                </div>
                                                <input type="time" class="form-control" id="u_'.$id_unidad.'" data-unidad="'.$clave_unidad.'" placeholder="Unidad '.$numero_unidad.'" value="'.$horario_adip.'">
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-primary" title="Guardar horario" type="button" onclick="cambiarHorario('.$id_unidad.')"><i class="far fa-save"></i></button>
                                                </div>
                                                </div>
                                            </div>';
                                        }
                                    }   
                                
                                    echo $html;
                                @endphp
                            </div>

                            {{--  Boton para filtrar  --}}
                            {{--  <div class="row justify-content-center mt-4">
                                <div class="col-lg-3">
                                    <button type="button" class="btn btn-primary btn-sm btn-block mg-b-10" data-toggle="collapse" data-target="#demo" onclick="cambiar_horario();">Guardar</button>
                                </div>
                            </div>  --}}
        
                            <div style="width: 230px; border-bottom:3px solid #848F33; margin: 1% 0; text-align:left; font-size: 1.2em;">
                                Desbloqueo de reporte
                            </div>

                            <div class="row mg-b-2" style="justify-content: start; align-items:center;">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="searchReporte">Id Reporte <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="searchReporte" />
                                    </div>
                                </div>
                                <div class="col-md-2 mg-t-10">
                                    <button class="btn btn-primary" onclick="desbloquearReporte('#searchReporte')">Desbloquear</button>
                                </div>
                            </div>

                            <div style="width: 230px; border-bottom:3px solid #848F33; margin: 1% 0; text-align:left; font-size: 1.2em;">
                                Creacion de reporte General
                            </div>

                            <div class="row mg-b-2" style="justify-content: start; align-items:center;">
                                <div class="col-md-6">
                                    <button class="btn btn-primary" id="fusionarButton" disabled onclick="fusionarReporte()">Fusionar Reportes &nbsp; &nbsp;<i class="fas fa-code-branch"></i></button>
                                    <button class="btn btn-primary" id="MasterButton" disabled onclick="generarReporteMaster()">Generar Reporte &nbsp; &nbsp;<i class="fas fa-file-contract"></i></button>
                                </div>
                            </div>

                        </div>
                  </div>
                </div>
            </div>     

            {{--  ADIP EDITAR  --}}
            <div id="accordion" class="acordion1 accordion-one mg-b-15" role="tablist" aria-multiselectable="true">
                <div class="card">
                   {{--  header del card  
                   <div class="card-header" role="tab" id="headingOne" style="background: #848F33 !important;"></div>--}}
                   {{--  body del card  --}}
                   <div id="collapseSearchAdvance1" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                      <div class="card-body">
                        <div class="row" style="padding-left: 13px; font-size: 0.9em; font-weight: bold;">
                            Unidad 
                            <span id="numero_unidad" style="margin-left: 1%;">1</span>
                        </div>
                        {{--  Formulario de la busqueda avanzada --}}
                        <div class="row mg-b-25">
                            <ul class="fechas_adip" id="fechas_adip">
                            </ul>
                            {{--  <div class="row pl-2">
                                <div class="col-md-3">
                                    <button class="btn btn-success" style="background: #848F33 !important;">Reporte General</button>
                                </div>
                            </div>  --}}
                        </div>
                      </div>
                   </div>

                </div>
            </div>    

        </div>

        @php
            $claves = ['','001','002','003','004','005','006','007','008','009','010','011','012'];

            $unidad_gestion = $request->session()->get('id_unidad_gestion');


            if(empty($unidad_gestion)){
                $unidad = '';
            }else{
                if($unidad_gestion == 12){$unidad = $claves[1];} //001
                if($unidad_gestion == 13){$unidad = $claves[2];} //002
                if($unidad_gestion == 14){$unidad = $claves[3];} //003
                if($unidad_gestion == 15){$unidad = $claves[4];} //004
                if($unidad_gestion == 16){$unidad = $claves[5];} //005
                if($unidad_gestion == 17){$unidad = $claves[6];} //006
                if($unidad_gestion == 18){$unidad = $claves[7];} //007
                if($unidad_gestion == 19){$unidad = $claves[8];} //008
                if($unidad_gestion == 32){$unidad = $claves[9];} //209
                if($unidad_gestion == 31){$unidad = $claves[10];} //010
                if($unidad_gestion == 30){$unidad = $claves[11];} //011
                if($unidad_gestion == 34){$unidad = $claves[12];} //012
            }
        @endphp

        <!-- pagination-wrapper -->
        <div class="pagination-wrapper justify-content-between mg-b-20">
                <ul class="pagination mg-b-0">
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0);" onclick="sec_ajax('primera', <?php echo "'".$unidad."'";?>);" aria-label="Last">
                            <i class="fa fa-angle-double-left"></i>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0);" onclick="sec_ajax('atras',  <?php echo "'".$unidad."'";?>);" aria-label="Next">
                            <i class="fa fa-angle-left"></i>
                        </a>
                    </li>
                </ul>
                <div id="texto_paginator">Página <span class="pagina_actual_texto">0</span> de <span class="pagina_total_texto">0</span></div>
                    <ul class="pagination mg-b-0">
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0);" onclick="sec_ajax('avanzar',  <?php echo "'".$unidad."'";?>);" aria-label="Next">
                            <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0);" onclick="sec_ajax('ultima',  <?php echo "'".$unidad."'";?>);" aria-label="Last">
                                <i class="fa fa-angle-double-right"></i>
                            </a>
                        </li>
                    </ul>
        </div>

        <!--TABLA RESULTADOS BUSQUEDA -->
        <div id="table-acuerdos" class="mg-b-20">
                <table id="adipTable" class="display dataTable dtr-inline collapsed d-block" style="overflow-x: auto; padding-left:0; padding-rigth:0" role="grid" aria-describedby="example_info">
                    <thead style="background-color: #EBEEF1; color: #000; text-align:center">
                        <tr>
                            <th style="" class="acciones" name="acciones">Acciones</th>
                            {{--  <th style="cursor:pointer" class="bandera_creacion" name="bandera_creacion">Correcto</th>  --}}
                            <th style="cursor:pointer" class="bandera_reporte" name="bandera_reporte">Tipo</th>
                            <th style="cursor:pointer" class="registros_procesados" name="registros_procesados">Total de registros procesados</th>
                            <th style="cursor:pointer" class="fecha_final" name="fecha_final">Fechas</th>
                            {{--  <th style="cursor:pointer" class="fecha_inicio" name="fecha_inicio">Fecha final</th>  --}}
                            <th style="cursor:pointer" class="creacion" name="creacion">Fecha de Creacion</th>
                            <th style="cursor:pointer" class="creacion" name="creacion">Tipo Creacion</th>
                        </tr>
                    </thead>
                    <tbody id="body-table1" class="items-agregados" style="width: 100%; text-align: center;">

                </table>
        </div>

        <!-- pagination-wrapper -->
        <div class="pagination-wrapper justify-content-between">
                <ul class="pagination mg-b-0">
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0);" onclick="sec_ajax('primera', <?php echo "'".$unidad."'";?>);" aria-label="Last">
                        <i class="fa fa-angle-double-left"></i>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0);" onclick="sec_ajax('atras', <?php echo "'".$unidad."'";?>);" aria-label="Next">
                        <i class="fa fa-angle-left"></i>
                        </a>
                    </li>
                </ul>
                <div id="texto_paginator">Página <span class="pagina_actual_texto">0</span> de <span class="pagina_total_texto">0</span></div>
                    <ul class="pagination mg-b-0">
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0);" onclick="sec_ajax('avanzar', <?php echo "'".$unidad."'";?>);" aria-label="Next">
                            <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0);" onclick="sec_ajax('ultima',<?php echo "'".$unidad."'";?>);" aria-label="Last">
                            <i class="fa fa-angle-double-right"></i>
                            </a>
                        </li>
                    </ul>
                </div>
        </div>

        <input type="hidden" id="pagina_actual" name="pagina_actual" value="1">
        <input type="hidden" id="paginas_totales" name="paginas_totales" value="1">
        <input type="hidden" id="numeropagina">

        <div class="pagination-wrapper justify-content-space-between col-sm-4 " style="border:0px;float:none;margin:auto;">
        </div>

    </div>

@endsection

@section('seccion-estilos')
    <link rel="stylesheet" type="text/css" href="{{asset("/css/dropzone.min.css")}}">
    <link href="{{asset("/lib/datatables/css/jquery.dataTables.css")}}" rel="stylesheet">
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
    {{--     <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/colreorder/1.5.3/css/colReorder.dataTables.min.css"/> --}}
        <style>
            @media screen and (max-width: 600px) {

            }
            .contextual_adip{
              position: absolute;
              right: 5px;
              bottom: -4px;
              font-size: 0.72em;
            }
            .fechas_adip{
              width: 100%;
              padding-left: 2px;
            }
            .fechas_adip li{
              position: relative;
              padding: 10px;
              list-style: none;
              border: 1px solid #eee;
              width: 120px;
              height: 80px;
              text-align: center;
              cursor: pointer;
              display: inline-block;
              float: left;
              margin-left: 10px;
              margin-top: 10px;
            }
            .fechas_adip li i{
              font-size: 1.5em;
              color:#848F33;
              margin: 5px 0;
            }
            .fechas_adip li:hover{
              border-bottom: 2px solid #848F33;
            }
            .desactivado{
              opacity: 0.9;
              background: rgb(86 86 86 / 10%);
              cursor: not-allowed !important;
            }
            .desactivado:hover{
              opacity: 0.9;
              background: rgb(86 86 86 / 10%);
              cursor: not-allowed !important;
            }
            #accordion .card{
              border:none !important;
            }
            #accordion .card .card-header{
              width: 75px !important;
              border: 1px solid #dee2e6 !important;
            }
            #accordion.acordion1 .card .card-header{
              width: 80% !important;
              margin: 0 auto;
              text-align: center;
              border: 1px solid #dee2e6 !important;
            }
            #accordion.acordion1 .card .card-body{
              border: 1px solid #dee2e6 !important;
            }
            #accordion .card .card-header a{
              padding: 10px !important;
            }
            #collapseSearchAdvance, #collapseSearchAdvance{
              border: 1px solid #eee !important;
              background: #f8f9fa;
            }
            #accordion a::before{
              top: 10px !important;
            }
            #modal-ver .modal-dialog {
            width: 100%;
            max-width:700px;
            height: 90%;
            margin: 0;
            padding: 1;
            }

            table{
                width: calc(100% - 2px) !important;
                border-bottom: 1px solid #f0f2f7;
            }

            td, th{
                padding-left: 1px !important;
                padding-right: 3px !important;
                padding-top: 0px;
                padding-bottom: px !important;
                border-bottom: 1px solid #f0f2f7;
                max-width: 110px !important;
            }
            span.select2-container.select2-container--default.select2-container--open{

                width:'100%';
            }

             .datepicker-container{
                z-index: 1110;
            }

            .abs-center {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    min-height: 100vh;
            }
            .iconify{
                display: inline-block;
                text-align: left;
                vertical-align: top;
             }
            .acciones {
                min-width: 170px !important;
            }
            .bandera_creacion {
                min-width: 185px !important;
            }
            .bandera_reporte {
                min-width: 200px !important;
            }
            .tipo{
                padding: 4px;
                border-radius: 5px;
                color: #444;
                font-size: 0.8em;
                position: relative;
            }
            .audiencias_r{
                border: 2px solid #ddc23f;
                margin: 0 8%;
            }
            .audi_r{
                border: 2px solid #3498DB;
                margin: 0 8%;
            }
            .adip_r{
                border: 2px solid #848F33;
                margin: 0 8%;
            }
            .adip_master{
                border: 2px solid #8E44AD;
                margin: 0 8%;
            }
            .delitos_r{
                border: 2px solid #d8deae;
                margin: 0 8%;
            }
            .estadistica_r{
                border: 2px solid #8ebd99;
                margin: 0 8%;
            }
            .cln_r{
                border: 2px solid #427a4f;
                margin: 0 8%;
            }
            .lb_r{
                border: 2px solid #939693;
                margin: 0 8%;
            }
            .ejec_r{
                border: 2px solid #EC7063;
                margin: 0 8%;
            }
            .registros_procesados {
                min-width: 280px !important;
            }

            .disponible{
                background: #28B463;
                width: 7px;
                height: 7px;
                border-radius: 50%;
                margin: 2% 24%;
                position: absolute;
                top: 0;
                right: -23px;
            }
            .ocupado{
                background: #F1C40F;
                width: 7px;
                height: 7px;
                border-radius: 50%;
                margin: 2% 24%;
                position: absolute;
                top: 0;
                right: -23px;
            }

            .fecha_final {
                min-width: 290px !important;
            }
            .fecha_inicio {
                min-width: 280px !important;
            }
            .creacion {
                min-width: 280px !important;
            }

             .td-title {
                background-color: #f0f2f7 !important;
                min-width: 120px !important;
                border-color: #f0f2f7 !important;
                max-height:5px !important;
                padding: 3px 5px 3px 5px  !important;
            }

            .odd {
               text-align: center !important;

            }
            .even {
               text-align: center !important;
            }

            .slim-navbar{
                z-index: 1000 !important;
            }


            .ul{
                list-style: none;
            }

            .depo {
                min-width: 80px  !important;
            }

            table{

                width: calc(100% - 2px) !important;
            }
            table a:hover{
                font-weight:bold;
            }
            span.select2-container{
                width:'100%';
            }


            #modalAdjuntarDocumento .modal-dialog {
            height: 95%;
            min-width: 90%;
            }


            #modalAdjuntarDocumento .modal-body {
                height: 95%;
                min-width: 90%;
            }

            #modalAdjuntarDocumento .modal-content {
                height: 95%;
                min-width: 90%;
            }

            #documentoPDFrame , #vista_Excel_Modal{
                min-height: 100%;
                min-width: 100%;
            }

            .table-responsive::-webkit-scrollbar {
                width: 8px;
                height: 8px;     
            }

            .table-responsive::-webkit-scrollbar-thumb {
                background: #ccc;
                border-radius: 4px;
            }

            .table-responsive::-webkit-scrollbar-thumb:hover {
                background: #b3b3b3;
                box-shadow: 0 0 2px 1px rgba(0, 0, 0, 0.2);
            }

            .table-responsive::-webkit-scrollbar-thumb:active {
                background-color: #999999;
            }

            .table-responsive::-webkit-scrollbar-track {
                background: #e1e1e1;
                border-radius: 4px;
            }
        
            .table-responsive::-webkit-scrollbar-track:hover,
            .table-responsive::-webkit-scrollbar-track:active {
              background: #d4d4d4;
            }    

                                 
            #table_vista_Excel_Modal{
                table-layout: fixed;
                margin: 3% auto;
            }

            #adipTable tbody tr td{
                display: table-cell;
                vertical-align: middle;
            }

            #encabezado_personalizado th{
                font-size: 0.8em;
                padding: 0.2rem 0.2rem !important;
                overflow: auto;
                border: 1px solid #ccc;
                background: #eee;
                display: table-cell;
                vertical-align: middle;
                text-align: center;
            } 
            #encabezado_personalizado.dataTable tbody td{
                word-break: keep-all;;
            }
            #table_vista_Excel_Modal tbody td{
                font-size: 0.7em;
                border:1px solid #eee;
            }
            #tatable_vista_Excel_Modalble.dataTable.dataTable_width_auto {
                width: auto;
            }
            .dataTables_wrapper .dataTables_paginate .paginate_button.current, .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover, .dataTables_wrapper .dataTables_paginate .paginate_button.current:focus {
                background-color: #848F33 !important;
            }
            #encabezado_personalizado th:nth-child(1){width: 40px  !important;} /* No */
            #encabezado_personalizado th:nth-child(2){width: 140px !important;} /* Expediente digital */
            #encabezado_personalizado th:nth-child(3){width: 225px !important;} /* Carpeta de Investigacion */
            #encabezado_personalizado th:nth-child(4){width: 140px !important;} /* Nombre */
            #encabezado_personalizado th:nth-child(5){width: 130px !important;} /* Apaterno */
            #encabezado_personalizado th:nth-child(6){width: 146px !important;} /* Amaterno */
            #encabezado_personalizado th:nth-child(7){width: 145px !important;} /* Fecha Nacimiento */
            #encabezado_personalizado th:nth-child(8){width: 300px !important;} /* Domicilio */
            #encabezado_personalizado th:nth-child(9){width: 80px  !important;} /* Sexo */
            #encabezado_personalizado th:nth-child(10){width: 80px !important;} /* Edad */
            #encabezado_personalizado th:nth-child(11){width: 100px !important;} /* Ingreso */
            #encabezado_personalizado th:nth-child(12){width: 170px !important;} /* Estatus imputado */
            #encabezado_personalizado th:nth-child(13){width: 180px !important;} /* Estatus de reincidencia */
            #encabezado_personalizado th:nth-child(14){width: 180px !important;} /* Fecha vinculacion proceso */
            #encabezado_personalizado th:nth-child(15){width: 180px !important;} /* Fecha sentencia */
            #encabezado_personalizado th:nth-child(16){width: 125px !important;} /* Fecha apelacion */
            #encabezado_personalizado th:nth-child(17){width: 170px !important;} /* Estatus de la multa posterior a la apelacion */
            #encabezado_personalizado th:nth-child(18){width: 230px !important;} /* Pena pecuniaria posterior a la apelacion */
            #encabezado_personalizado th:nth-child(19){width: 130px !important;} /* Fecha Amparo */
            #encabezado_personalizado th:nth-child(20){width: 180px !important;} /* Fecha sobreseimiento */
            #encabezado_personalizado th:nth-child(21){width: 105px !important;} /* Tipo de juicio */
            #encabezado_personalizado th:nth-child(22){width: 240px !important;} /* Tiempo se sentencia */
            #encabezado_personalizado th:nth-child(23){width: 195px !important;} /* Estatus de la multa posterior a la sentencia */
            #encabezado_personalizado th:nth-child(24){width: 235px !important;} /* Pena pecuniaria de sentencia */
            #encabezado_personalizado th:nth-child(25){width: 135px !important;} /* Estatus de proceso */
            #encabezado_personalizado th:nth-child(26){width: 70px  !important; visibility: hidden; } /* Persona */
            
            #encabezado_personalizado th,#table_vista_Excel_Modal tbody td th{
                max-width: 300px !important;
            }

            #sarchItem{
                border: 1px solid #eee;
                border-radius: 0 0 10% 10%;
                padding: 4px;
                text-align: center;
                width: 30%;
                outline: none;
            }
            #sarchItem:active{
                outline: none;
            }
            #table_vista_Excel_Modal_filter{
                display: none;
            }   
            #table_vista_Excel_Modal_length{
                display: none;
            }
            #table_vista_Excel_Modal_paginate{
                position: fixed;
                bottom: 2%;
                left: 40%;
            }
            @media (max-width:900px){
                #table_vista_Excel_Modal_paginate{
                    left: 26%;
                }
            }
            @media (max-width:700px){
                #table_vista_Excel_Modal_paginate{
                    left: 2%;
                }
            }
            @media (max-width:500px){
                #sarchItem{
                    width: 90%;
                }
                #table_vista_Excel_Modal_paginate{
                    left: 22%;
                    bottom: 10%;
                }
                #modal-footer{
                    padding-top: 18%;
                    justify-content: center;
                }
            }

            .CI_auto, .CJ_auto, .nombre_auto, .apellidoPaterno_auto, .apellidoMaterno_auto, 
            .fechaNacimiento_auto, .domicilio_auto, .genero_auto, .edad_auto, 
            .ingreso_auto, .estatus_imputado_auto, .estatus_reincidencia_auto, .fecha_vinculacion_proceso_auto,
            .fecha_sentencia_auto, .fecha_apelacion_auto, .estatus_multa_posterior_apelacion_auto, 
            .pena_pecunaria_posterior_apelacion_auto, .fecha_amparo_auto, .fecha_sobreseimiento_auto,
            .tipo_juicio_auto, .tiempo_sentencia_auto, .estatus_multa_posterior_sentencia_auto,
            .pena_pecunaria_sentencia_auto, .estatus_carpeta_auto, .tiempo_anio_sentencia_auto, .tiempo_mes_sentencia_auto, .tiempo_dia_sentencia_auto
            {
                width: 100%;
                padding: 8px;
                text-align: center;
                border: none;
                background: #efefef;
                border-radius: 3px;
            }
		    .ui-datepicker.ui-widget.ui-widget-content.ui-helper-clearfix.ui-corner-all{
		    	z-index: 1050 !important;
		    }
            .CI_auto:focus, .CJ_auto:focus, .nombre_auto:focus, .apellidoPaterno_auto:focus, .apellidoMaterno_auto:focus, 
            .fechaNacimiento_auto:focus, .domicilio_auto:focus, .genero_auto:focus, .edad_auto:focus, 
            .ingreso_auto:focus, .estatus_imputado_auto:focus, .estatus_reincidencia_auto:focus, .fecha_vinculacion_proceso_auto:focus,
            .fecha_sentencia_auto:focus, .fecha_apelacion_auto:focus, .estatus_multa_posterior_apelacion_auto:focus, 
            .pena_pecunaria_posterior_apelacion_auto:focus, .fecha_amparo_auto:focus, .fecha_sobreseimiento_auto:focus,
            .tipo_juicio_auto:focus, .tiempo_sentencia_auto:focus, .estatus_multa_posterior_sentencia_auto:focus,
            .pena_pecunaria_sentencia_auto:focus, .estatus_carpeta_auto:focus, .tiempo_anio_sentencia_auto:focus, .tiempo_mes_sentencia_auto:focus, .tiempo_dia_sentencia_auto:focus{
                outline-color: #848F33;
            }
            .nombre_auto, .apellidoPaterno_auto, .apellidoMaterno_auto{
                text-transform: uppercase;
            }
            .check_adip{
                margin-left: 20px;
                margin-top: 5px;
            }
            .vers{
                width: 124px;
                height: 100px;
                border: 1px solid #ccc;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                font-weight: 600;
                cursor: pointer;
                float: left;
                margin: 1%;
            }

            #adipTable::-webkit-scrollbar {
                width: 8px;
                height: 8px;     
            }

            #adipTable::-webkit-scrollbar-thumb {
                background: #ccc;
                border-radius: 4px;
            }

            #adipTable::-webkit-scrollbar-thumb:hover {
                background: #b3b3b3;
                box-shadow: 0 0 2px 1px rgba(0, 0, 0, 0.2);
            }

            #adipTable::-webkit-scrollbar-thumb:active {
                background-color: #999999;
            }

            #adipTable::-webkit-scrollbar-track {
                background: #e1e1e1;
                border-radius: 4px;
            }
        
            #adipTable::-webkit-scrollbar-track:hover,
            #adipTable::-webkit-scrollbar-track:active {
              background: #d4d4d4;
            }
            .icons{
                background: #848F33 !important;
                padding: 6px 5px;
                border-radius: 25%;
                color: #fff;
            } 
            #titulo_reporte_adip b{
                display: inline-block;
            }
            .contenedor_header_adip{
                width: 80%;
                display: flex; 
            }
            @media(max-width:500px){
                #titulo_reporte_adip{
                    font-size: 0.8em;
                }
                #titulo_reporte_adip b{
                    display: block;
                }
                .contenedor_header_adip{
                    width:70%; 
                }
            }
            .novinculado{
                -webkit-appearance: initial;
                appearance: initial;
                background: rgb(194, 194, 194);
                border: 1px solid #ccc;
                width: 15px;
                height: 15px;
                position: relative;
                cursor: pointer;
                border-radius: 3px;
            }
            .novinculado:checked{
                background: #848F33;
            }
            .novinculado:checked::after{
                content: "\2714";
                color: #fff;
                position: absolute;
                left: 50%;
                top: 50%;
                -webkit-transform: translate(-50%,-50%);
                -moz-transform: translate(-50%,-50%);
                -ms-transform: translate(-50%,-50%);
                transform: translate(-50%,-50%);
            }
        </style>
@endsection

@section('seccion-scripts-libs')
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/jquery-ui/js/jquery-ui.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/datatables/js/jquery.dataTables.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/datatables-responsive/js/dataTables.responsive.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/select2/js/select2.min.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/moment/js/moment.js"></script>
     <script src="https://cdn.datatables.net/colreorder/1.5.3/js/dataTables.colReorder.min.js"></script>
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
@endsection

@section('seccion-scripts-functions')
    <script>
        var filtro = null; // variable que almacena el filtro de busqueda para la exportacion a XSL o PDF

        var countDownDate = '';
        var fecha_fina_bloque_pasado = '';

        var array_versiones = [];

        var id_r = '';
        
        //desactivar la recarga
        var preventF5 = (event) => {

            cambiar_estado_online(id_r,1,'vista','');
            
            event.preventDefault();
            // Chrome 
            event.returnValue = '';
        };
        
        var tipo_user = @php echo json_encode($request->session()->get('id_tipo_usuario')); @endphp;
        var unidad_gestion_u = @php echo json_encode($request->session()->get('id_unidad_gestion')); @endphp;
        var cve_unidad_session = '';
        
        $(function(){

            'use strict';

            setTimeout(function(){
                $('#modal_loading').modal('hide');
            }, 1000);

            setInterval(revisar_estado_online, 1000);

            $.ajax({
                type:'POST',
                url:'/public/obtener_unidades',
                data:{},

                success:function(response){

                    console.log(response);

                    if(response.status==100){

                        let unidades='';
                        $(response.response).each((index, unidad)=>{
                            const {id_unidad_gestion, nombre_unidad,clave_unidad}=unidad;
                            const option=`<option value="${id_unidad_gestion}"> ${nombre_unidad} </option>`;
                            
                            
                            if(unidad_gestion_u == '' || unidad_gestion_u == null){
                                cve_unidad_session = '001';
                                unidad_gestion_u = 12;
                                sec_ajax();
                                dias_edicion(cve_unidad_session);
                            }else if(unidad_gestion_u == id_unidad_gestion){
                                cve_unidad_session = clave_unidad;
                                sec_ajax('',clave_unidad);
                                dias_edicion(clave_unidad);
                                /*
                                if(clave_unidad == '009'){
                                    sec_ajax('','209');
                                    dias_edicion('209');
                                }else{
                                    cve_unidad_session = clave_unidad;
                                    sec_ajax('',clave_unidad);
                                    dias_edicion(clave_unidad);
                                }*/
                            }

                            unidades=unidades.concat(option);
                        });
                        $('#idUnidad').html(`<option selected disabled value="">Elija una opción</option><option value=""> TODAS LAS UNIDADES </option>` + unidades);
                    }
                }
            });
            

            $(".cerrar-modal").click(function(){
                let modalOpen = $(this).attr('data-modal');
                let modalClose = $(this).attr('data-thismodal');
                //console.log(modalOpen,modalClose);
                $("#"+modalClose).modal('hide');
                if( modalOpen.length ) setTimeout(function(){ $("#"+modalOpen).modal('show'); }, 500); 
            });

            // Select2
            $('.select2').select2({
                minimumResultsForSearch: Infinity
            });

            

            $('.fc-datepicker').datepicker({
                showOtherMonths: true,
                selectOtherMonths: true
            });

            $( ".fc-datepicker" ).datepicker( "option", "dd-mm-yy" );

            $.datepicker.regional['es'] = {
                closeText: 'Cerrar',
                prevText: '< Ant',
                nextText: 'Sig >',
                currentText: 'Hoy',
                monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
                dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
                dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
                weekHeader: 'Sm',
                dateFormat: 'dd/mm/yy',
                firstDay: 1,
                isRTL: false,
                showMonthAfterYear: false,
                yearSuffix: ''
            };

            $.datepicker.setDefaults($.datepicker.regional['es']);
            $(function () {
                $("#fc-datepicker").datepicker();
            });

            //focus textfiled
            $('.form-layout .form-control').on('focusin', function(){
                $(this).closest('.form-group').addClass('form-group-active');
            });
            $('.form-layout .form-control').on('focusout', function(){
                $(this).closest('.form-group').removeClass('form-group-active');
            });

            $('#elige_unidad_editar').change(function(){
                var valor = $(this).val();
                var un = unidadEnnumero(valor);

                $('#numero_unidad').html(un);
                dias_edicion(valor);
            });

            $("#collapseSearchAdvance2.collapse").on('show.bs.collapse', function () {
                habilitarBotonFusinar();
            });
        });

        //busqueda
        function sec_ajax(pagina_accion, clave) {

            $(document).ready(function(){
                $(".nav-tabs a").click(function(){
                    $(this).tab('show');
                });
            });

            let body="";

            pagina=parseInt($('#pagina_actual').val());
            registros_por_pagina=10;

            if(pagina_accion=="primera"){
                pagina=1;
            }
            else if(pagina_accion=="avanzar"){
                pagina=pagina+1;
            }
            else if(pagina_accion=="atras"){
                pagina=pagina-1;
            }
            else if(pagina_accion=="ultima"){
                pagina=$('#paginas_totales').val();
            }

            if(pagina<=0 || pagina>$('#paginas_totales').val()){}
            else{
                $('#pagina_actual').val(pagina);
                $('#numeropagina').val(pagina);
                $('.pagina_actual_texto').html(pagina);

                let id_solicitud=""

                //cambio formato de fecha
                const format1 = "YYYY-DD-MM"

                var date1 = new Date($("#fechaini").val());
                fechaini = moment(date1).format(format1);
                if (fechaini === "Invalid date") {
                    fechaini= '';}


                var date2 = new Date($("#fechafin").val());
                fechafin = moment(date2).format(format1);
                if (fechafin === "Invalid date") {
                            fechafin= '';}


                var date3 = new Date($("#fechaini").val());
                fechainicreacion = moment(date3).format(format1);
                if (fechainicreacion === "Invalid date") {
                    fechainicreacion= '';}



                var date4 = new Date($("#fechafin").val());
                fechafincreacion = moment(date4).format(format1);
                if (fechafincreacion === "Invalid date") {
                    fechafincreacion= '';}


                var bandera_reporte = $("#tipo_reporte").val()

                var searchIdReporte = $('#searchIdReporte').val() == null ? '-' : $('#searchIdReporte').val();

                $.ajax({
                    type:'GET',
                    url:'/public/obtener_reportes_adip',
                    data:{
                        fecha_inicio: fechainicreacion,
                        fecha_final: fechafincreacion,
                        clave:clave,
                        bandera_reporte: bandera_reporte,
                        searchIdReporte:searchIdReporte,
                        pagina: $('#numeropagina').val(),
                        registros_por_pagina:10,
                    },
                        success:function(response) {
                            console.log(response);

                        if(response.status==100){

                            var datos=response.response;
                            let color;
                            let title;
                            var id_r = [];

                            body = new $('#adipTable').dataTable( {
                                        processing: true,
                                        data: datos,
                                        responsive: false,
                                        columns: [
                                            {
                                                data: "id_reporte",
                                                render: function (data, type, row, meta) {
                                                    /*if(row.bandera_reporte == 'adip'){

                                                        if(row.disponibilidad == 1){
                                                            boton = '<i class="icon fas fa-file-excel" title="Editar Excel" style="cursor: pointer;padding: 5px 6px;font-size: 0.8em; " id="b_'+data+'" onclick="vista_Excel_Modal('+data+')"></i>';
                                                        }else{
                                                            boton = '<i class="icon fas fa-file-excel" title="Editar Excel" style="cursor: pointer;padding: 5px 6px;font-size: 0.8em; background: #F1C40F !important;" id="b_'+data+'" onclick="alertaOcupado('+data+')"></i>';
                                                        }
                                                        return (
                                                            '<i class="icon ion-ios-download-outline"  title="Descargar Excel" style="cursor: pointer" onclick="descargar_excel(' +data +')" id="pdf"></i> ' +
                                                            '<i class="icon ion-code-download" title="Descargar XML" style="cursor: pointer" onclick="descargar_xml('+data+')" id="descarga_xml"></i> ' +
                                                            boton 
                                                        );
                                                    }else{
                                                    }*/
                                                    
                                                    if(row.bandera_reporte == "audiencias_bd" && row.tipo_reporte == 'otro'){
                                                        return '<i class="fas fa-ban" title="Solo Registro" style=" font-size: 0.9em;"></i>';
                                                    }


                                                    //Adip Unidad General
                                                    if(row.bandera_reporte == "adip" && row.tipo_reporte == 'unidad'){
                                                        var nombre_reporte = 'adip';
                                                        if(tipo_user != '39'){
                                                            var botones = `<i class="icons fas fa-file-excel"  title="Descargar Excel" style="cursor: pointer; font-size: 0.9em;" onclick="descargar_excel(${data},'${nombre_reporte}')" id="pdf"></i>
                                                                        <i class="icons fas fa-code" title="Descargar XML" style="cursor: pointer; font-size: 0.8em; padding: 6px 3px !important;" onclick="descargar_xml(${data},'${nombre_reporte}')" id="descarga_xml"></i>` ;
                                                        }else{
                                                            var botones = `<i class="icons fas fa-file-excel"  title="Descargar Excel" style="cursor: pointer; font-size: 0.9em;" onclick="descargar_excel(${data},'${nombre_reporte}')" id="pdf"></i>`;
                                                        }
                                                    
                                                    }

                                                    //Adip Unidad diarios
                                                    if(row.bandera_reporte == "adip" && row.tipo_reporte == 'hijo'){
                                                        var nombre_reporte = 'adip_hijo';

                                                        if(tipo_user != '39'){
                                                            var botones = `<i class="icons fas fa-file-excel"  title="Descargar Excel" style="cursor: pointer; font-size: 0.9em;" onclick="descargar_excel(${data},'${nombre_reporte}')" id="pdf"></i>
                                                            <i class="icons fas fa-code" title="Descargar XML" style="cursor: pointer; font-size: 0.8em; padding: 6px 3px !important;" onclick="descargar_xml(${data},'${nombre_reporte}')" id="descarga_xml"></i>` ;
                                                        }else{
                                                            var botones = `<i class="icons fas fa-file-excel"  title="Descargar Excel" style="cursor: pointer; font-size: 0.9em;" onclick="descargar_excel(${data},'${nombre_reporte}')" id="pdf"></i>` ;
                                                        }
                                                    }

                                                    //Adip Generados manual
                                                    if(row.bandera_reporte == "adip" && row.tipo_reporte == 'otro'){
                                                        var nombre_reporte = 'adip_hijo';
                                                        var botones = `<i class="icons fas fa-file-excel"  title="Descargar Excel" style="cursor: pointer; font-size: 0.9em;" onclick="descargar_excel(${data},'${nombre_reporte}')" id="pdf"></i>
                                                                        <i class="icons fas fa-code" title="Descargar XML" style="cursor: pointer; font-size: 0.8em; padding: 6px 3px !important;" onclick="descargar_xml(${data},'${nombre_reporte}')" id="descarga_xml"></i>` ;
                                                    }
                                                    //Adip General
                                                    if(row.bandera_reporte == "adip" && row.tipo_reporte == 'padre'){
                                                        var nombre_reporte = 'adip_hijo';
                                                        var botones = `<i class="icons fas fa-file-excel"  title="Descargar Excel" style="cursor: pointer; font-size: 0.9em;" onclick="descargar_excel(${data},'${nombre_reporte}')" id="pdf"></i>
                                                                        <i class="icons fas fa-code" title="Descargar XML" style="cursor: pointer; font-size: 0.8em; padding: 6px 3px !important;" onclick="descargar_xml(${data},'${nombre_reporte}')" id="descarga_xml"></i>` ;
                                                    }

                                                    // Audiencias
                                                    if(row.bandera_reporte == "audiencias_p" && row.tipo_reporte == 'otro'){
                                                        var nombre_reporte = 'audiencias_p'; 
                                                        var botones = `<i class="icons fas fa-file-excel"  title="Descargar Excel" style="cursor: pointer;font-size: 0.9em;" onclick="descargar_excel(${data},'${nombre_reporte}')" id="pdf"></i>
                                                        <i class="icons fas fa-file-pdf" title="Descargar PDF" style="cursor: pointer;font-size: 0.9em;" onclick="descargar_pdf(${data},'${nombre_reporte}')" id="descarga_xml"></i>` ;
                                                    }

                                                    // Delitos
                                                    if(row.bandera_reporte == "delitos" && row.tipo_reporte == 'otro'){
                                                        var nombre_reporte = 'delitos';
                                                        var botones = `<i class="icons fas fa-file-excel" title="Descargar Excel" style="cursor: pointer;font-size: 0.9em;" onclick="descargar_excel(${data},'${nombre_reporte}')" id="pdf"></i>` ;
                                                    }

                                                    // estadistico
                                                    if(row.bandera_reporte == "estadistico" && row.tipo_reporte == 'otro'){
                                                        var nombre_reporte = 'estadistica';
                                                        var botones = `<i class="icons fas fa-file-excel"  title="Descargar Excel" style="cursor: pointer;font-size: 0.9em;" onclick="descargar_excel(${data},'${nombre_reporte}')" id="pdf"></i>
                                                                        <i class="icons far fa-file-archive"  title="Descargar Zip" style="cursor: pointer;font-size: 0.9em;" onclick="descargar_zip(${data},'${nombre_reporte}')" id="pdf"></i>`;
                                                    }

                                                    // CLN
                                                    if(row.bandera_reporte == "cln" && row.tipo_reporte == 'otro'){
                                                        var nombre_reporte = 'cln';
                                                        var botones = `<i class="icons fas fa-file-excel"  title="Descargar Excel" style="cursor: pointer;font-size: 0.9em;" onclick="descargar_excel(${data},'${nombre_reporte}')" id="pdf"></i>` ;
                                                    }

                                                    // Libertades
                                                    if(row.bandera_reporte == "libertades" && row.tipo_reporte == 'otro'){
                                                        var nombre_reporte = 'libertades';
                                                        var botones = `<i class="icons fas fa-file-excel"  title="Descargar Excel" style="cursor: pointer;font-size: 0.9em;" onclick="descargar_excel(${data},'${nombre_reporte}')" id="pdf"></i>` ;
                                                    }

                                                    // Ejecucion
                                                    if(row.bandera_reporte == "ejecucion" && row.tipo_reporte == 'otro'){
                                                        var nombre_reporte = 'ejecucion';
                                                        var botones = `<i class="icons fas fa-file-excel"  title="Descargar Excel" style="cursor: pointer;font-size: 0.9em;" onclick="descargar_excel(${data},'${nombre_reporte}')" id="pdf"></i>` ;
                                                    }

                                                    return (botones); 
                                                },
                                            },
                                            {
                                                data: 'bandera_reporte',
                                                render : function (data, type, row, meta){
                                                    if(data == "adip" && row.tipo_reporte == 'unidad'){
                                                        title = "ADIP";
                                                        clase = 'adip_r';
                                                        un = '';
                                                        unidades_e = ['1','2','3','4','5','6', '7', '8', '9','10','11', '12'];
                                                        if(row.clave_unidad =='001'){un = unidades_e[0];}
                                                        else if(row.clave_unidad =='002'){un = unidades_e[1];}
                                                        else if(row.clave_unidad =='003'){un = unidades_e[2];}
                                                        else if(row.clave_unidad =='004'){un = unidades_e[3];}
                                                        else if(row.clave_unidad =='005'){un = unidades_e[4];}
                                                        else if(row.clave_unidad =='006'){un = unidades_e[5];}
                                                        else if(row.clave_unidad =='007'){un = unidades_e[6];}
                                                        else if(row.clave_unidad =='008'){un = unidades_e[7];}
                                                        else if(row.clave_unidad =='009'){un = unidades_e[8];}
                                                        else if(row.clave_unidad =='010'){un = unidades_e[9];}
                                                        else if(row.clave_unidad =='011'){un = unidades_e[10];}
                                                        else if(row.clave_unidad =='012'){un = unidades_e[11];}
                                                        else{ un = '?';}

                                                        unidad_e = '<span style="font-size: 0.8em;color: #848F33 !important;font-weight: 500;"> Unidad '+un+'</span>';
                                                        id_r = '<div style="color:#b3b3b3; font-size:0.8em;">'+row.id_reporte+'</div>';


                                                        fecha_title = 'Reporte completo de la unidad '+un+' de '+(row.fecha_inicio).substring(0,10).split('-').reverse().join('/') +' - '+(row.fecha_final).substring(0,10).split('-').reverse().join('/');

                                                        return '<div class="tipo '+clase+'" title="'+fecha_title+'">'+title +unidad_e+ id_r+' </div>';
                                                    }else if(data == 'estadistico'){
                                                        title = "ESTADISTICA";
                                                        clase = 'estadistica_r';
                                                        id_r = '<div style="color:#b3b3b3; font-size:0.8em;">'+row.id_reporte+'</div>';

                                                        return '<div class="tipo '+clase+'">'+title+id_r+'</div>';
                                                    }else if(data == 'audiencias_p'){
                                                        title = "AUDIENCIAS";
                                                        clase = 'audiencias_r';
                                                        id_r = '<div style="color:#b3b3b3; font-size:0.8em;">'+row.id_reporte+'</div>';

                                                        return '<div class="tipo '+clase+'">'+title+id_r+'</div>';
                                                    }else if(data =='delitos'){
                                                        title = "DELITOS";
                                                        clase = 'delitos_r';
                                                        id_r = '<div style="color:#b3b3b3; font-size:0.8em;">'+row.id_reporte+'</div>';

                                                        return '<div class="tipo '+clase+'">'+title+id_r+'</div>';
                                                    }
                                                    else if(data =='cln'){
                                                        title = "CLN";
                                                        clase = 'cln_r';
                                                        id_r = '<div style="color:#b3b3b3; font-size:0.8em;">'+row.id_reporte+'</div>';

                                                        return '<div class="tipo '+clase+'">'+title+id_r+'</div>';
                                                    }else if(data =='libertades'){
                                                        title = "LIBERTADES";
                                                        clase = 'lb_r';
                                                        id_r = '<div style="color:#b3b3b3; font-size:0.8em;">'+row.id_reporte+'</div>';

                                                        return '<div class="tipo '+clase+'">'+title+id_r+'</div>';
                                                    }else if(data == 'adip' && row.tipo_reporte == 'hijo'){
                                                        title = "ADIP";
                                                        clase = 'adip_r';

                                                        id_r = '<div style="color:#b3b3b3; font-size:0.8em;">'+row.id_reporte+'</div>';

                                                        return '<div class="tipo '+clase+'">'+title+ id_r+' </div>';
                                                    }else if(data == 'adip' && row.tipo_reporte == 'padre'){
                                                        title = "ADIP";
                                                        clase = 'adip_master';
                                                        unidad_e = '<span style="font-size: 0.8em;color: #848F33 !important;font-weight: 500;"> Master</span>';
                                                        id_r = '<div style="color:#b3b3b3; font-size:0.8em;">'+row.id_reporte+'</div>';


                                                        fecha_title = 'Reporte completo del periodo '+(row.fecha_inicio).substring(0,10).split('-').reverse().join('/') +' - '+(row.fecha_final).substring(0,10).split('-').reverse().join('/');

                                                        return '<div class="tipo '+clase+'" title="'+fecha_title+'">'+title +unidad_e+ id_r+' </div>';
                                                    }else if(data == 'adip' && row.tipo_reporte == 'otro'){
                                                        title = "ADIP";
                                                        clase = 'adip_r';

                                                        id_r = '<div style="color:#b3b3b3; font-size:0.8em;">'+row.id_reporte+'</div>';

                                                        return '<div class="tipo '+clase+'">'+title+ id_r+' </div>';
                                                    }else if(data =='ejecucion'){
                                                        title = "EJECUCIÓN";
                                                        clase = 'ejec_r';
                                                        id_r = '<div style="color:#b3b3b3; font-size:0.8em;">'+row.id_reporte+'</div>';

                                                        return '<div class="tipo '+clase+'">'+title+id_r+'</div>';
                                                    }else if(data == "audiencias_bd" && row.tipo_reporte == 'otro'){
                                                        title = "AUDIENCIA";
                                                        clase = 'audi_r';
                                                        id_r = '<div style="color:#b3b3b3; font-size:0.8em;">'+row.id_reporte+'</div>';
                                                        return '<div class="tipo '+clase+'">'+title+id_r+'</div>';
                                                    }

                                                    
                                                }
                                            },
                                            { data: "total_registros_procesados" ,title:"Total de Registros Procesados"},
                                            { data: "fecha_inicio" ,
                                                render : function (data, type, row, meta){
                                                    return(
                                                        '<div style="display: flex;justify-content: center;flex-direction: column; align-items: center;">'+
                                                            '<label style="border-left: 4px solid #848F33; width:83%">Fecha Inicio: '+data+'</label>'+
                                                            '<label style="border-left: 4px solid #848F33; width:83%">Fecha Final: '+row.fecha_final+'</label>'+
                                                        '</div>'
                                                    );
                                                },
                                            },
                                            { data: "creacion" ,title:"Fecha de Creacion"},
                                            {
                                            data: "creacion_bandera",
                                            render: function (data, type, row, meta){
                                                if(data == 'cron'){
                                                    return('<div style="width:100%; display:flex; flex-direction:column; align-items:center; text-align:center;"><i class="fas fa-clock" style="font-size: 1.3em; color: #86a54a;"></i> CRON</div>');
                                                }else{
                                                    return('<div style="width:100%; display:flex; flex-direction:column; align-items:center; text-align:center;"><i class="fas fa-object-group" style="font-size: 1.3em; color: #eaae58;"></i> INTERFAZ</div>');
                                                }
                                            }
                                            }
                                        ],
                                        colReorder: {
                                            fixedColumnsLeft: 2,
                                        },
                                        columnDefs: [
                                            { orderable: false, targets: 0 },

                                        ],
                                        bDestroy: true,
                                        colReset:true,
                                        paging:   false,
                                        ordering: true,
                                        info:     false,
                                        search:false,
                                        filter:false,
                                        stateSave: true,
                                    //  responsive: true
                                    //  stateClear: false,
                                    //  stateLoaded: true,
                                    } );


                                $('.pagina_total_texto').html(response.response_paginacion['paginas_totales']);
                                $('#paginas_totales').val(response.response_paginacion['paginas_totales'])
                        
                        }else {
                        body = "<tr><td colspan='12'><h3>Sin datos relacionados</h3></td><tr>";
                            $("#body-table1").html(body);

                            }
                        }
                    });

                }
        }

        function descargar_excel(id_reporte, nombre_reporte){

            setTimeout(function(){
                $('#modal_loading').modal('hide');
            }, 1000);

            var idReporte = id_reporte;
            var nombre_reporte = nombre_reporte;
            var tipo="xlsx";

            $.ajax({
                type:'GET',
                url:'/public/obtener_reportes_excel/'+ idReporte +"/"+ nombre_reporte+"/"+ tipo,
                data:{},
                success:function(response) {
                    if(response.status==100){
                        var win = window.open(response.response, '_blank');
                    }
                }
            });
        }

        function descargar_zip(id_reporte, nombre_reporte){

            setTimeout(function(){
                $('#modal_loading').modal('hide');
            }, 1000);

            var idReporte = id_reporte;
            var nombre_reporte = nombre_reporte;
            var tipo="zip";

            $.ajax({
                type:'GET',
                url:'/public/obtener_reportes_zip/'+ idReporte +"/"+ nombre_reporte+"/"+ tipo,
                data:{},
                success:function(response) {
                    if(response.status==100){
                        var win = window.open(response.response, '_blank');
                    }
                }
            });
        }

        function descargar_pdf(id_reporte, nombre_reporte){

            setTimeout(function(){
                $('#modal_loading').modal('hide');
            }, 1000);

            var idReporte = id_reporte;
            var nombre_reporte = nombre_reporte;
            var tipo="pdf";

            $.ajax({
                type:'GET',
                url:'/public/obtener_reportes_pdf/'+ idReporte +"/"+ nombre_reporte+"/"+ tipo,
                data:{},
                success:function(response) {
                    if(response.status==100){
                        var win = window.open(response.response, '_blank');
                    }
                }
            });
        }

        function Download(url) {
            document.getElementById('my_iframe').src = url;
        }

        function descargar_xml(id_reporte,nombre_reporte){

            setTimeout(function(){
                $('#modal_loading').modal('hide');
            }, 1000);

            var idReporte = id_reporte;
            var nombre_reporte = nombre_reporte;
            var tipo="xml";

            $.ajax({

                type:'GET',
                url:'/public/obtener_reportes_xml/'+idReporte+"/"+nombre_reporte+"/"+ tipo,
                data:{},
                success:function(response) {

                    if(response.status==100){
                        console.log(response.response);
                        window.open(response.response, 'Reporte XML', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=600,height=600,left = 390,top = 50');
                    }
                }

            });
            
                        /*     console.log(idAcuerdo);
                        console.log(versionAcuerdo); */
        }

        function mostrarModalDocumento(){
            $('#modalAdjuntarDocumento').modal('show');
        }

        function cerrar_modal(valor){
            if(valor == 'vista_Excel_Modal'){
                $("#"+valor).modal('hide');
                $('body').removeClass('modal-open');
                $('#table_vista_Excel_Modal').DataTable().destroy();
                var id_reporte = $('#id_report').val();
                $('#modalCerrarEdicion').modal('show');
                $('#modal_id_reporte').val(id_reporte);
                $('#tr_'+id).remove();
                //$('#modal-cerrarEdicion-titulo').html('Reporte: '+id_reporte);
            }else if(valor == 'modalInfoDocumento'){
            var id = $('#id_reporte_xlsx').val();
                $('#tr_'+id).remove();
                array_versiones = [];
            }
            else{
                $("#"+valor).modal('hide');
                $('body').removeClass('modal-open');
            }
        }

        function cerrar_modal_1(valor, modal_anterior){
            $("#"+valor).modal('hide');
            $("#"+modal_anterior).modal('show');
        }
        
        function modal_error(mensaje,modalAnterior=null){
            $('#messageError').html(`${mensaje}`);
            $('#btnCerrarError').attr('data-modal',modalAnterior!=null?modalAnterior:'');
            if( modalAnterior!=null ) $('#'+modalAnterior).modal('hide');
            $('#modalError').modal('show');
        }
    
        function modal_success(mensaje,modalAnterior=null){
            $('#modal-success-titulo').html(`${mensaje}`);
            $('#btnCerrarSuccess').attr('data-modal',modalAnterior!=null?modalAnterior:'');
            if( modalAnterior!=null ) $('#'+modalAnterior).modal('hide');
            $('#modalSuccess').modal('show');
        }

        function alertaOcupado(mensaje){
            $('#modal-warning-titulo').html(`El reporte ${mensaje} esta ocupado`);
            $('#modalWarning').modal('show');
        }

        // ########### EDICION DE EXCEL  ########
        //{{-- Trae los datos del servidor y genera el json con la version mas reciente --}}
        function vista_Excel_Modal(id_reporte){

            window.addEventListener('beforeunload', preventF5);
            id_r = id_reporte;

            $.ajax({
                type:'POST',
                url:'/public/obtener_csv/',
                data:{
                    id_reporte: id_reporte
                },
                success:function(response) {
                    console.log(response);
                    
                    if(response.status==100){
                        
                        cambiar_estado_online(id_reporte,0,'vista','');

                        //console.log(response.response);
                        
                        var datos=response.response;

                        var table = $('#table_vista_Excel_Modal').DataTable({
                            processing: true,
                            data:datos,
                            responsive: false,
                            columns: [
                                { data: "no",                               
                                    "render": function ( data, type, row, meta ) {
                                        return '<input type="text" disabled data-persona="'+row.id_persona+'" value="'+data+'" class="no_auto" style="width: 100%; text-align: center; border: none; background: #fff;">';
                                    }
                                },  
                                { data: "CJ",
                                    "render": function ( data, type, row, meta ) {
                                        
                                        //if(data < 1){
                                    //     return '<input type="text" placeholder="CI" class="CI_auto" onkeyup="seleccionCampo(this)">';
                                    // }else{
                                    //     return data;
                                    // }

                                        return data;
                                    }
                                },   
                                { data: "CI",
                                    "render": function ( data, type, row, meta ) {
                                        
                                    // if(data < 1){
                                    //     return '<input type="text" placeholder="CJ" class="CJ_auto" onkeyup="seleccionCampo(this)">';
                                    // }else{
                                    //     return data;
                                    // }
                                        
                                        return data;
                                    }
                                },   
                                { data: "nombre",
                                    "render": function ( data, type, row, meta ) {
                                        if(data < 1){
                                            return "";
                                            //return '<input type="text" placeholder="nombre" class="nombre_auto" onkeyup="seleccionCampo(this)">';
                                        }else{
                                            return data;
                                        }
                                    }
                                },       
                                { data: "apellidoPaterno",
                                    "render": function ( data, type, row, meta ) {
                                        if(data < 1){
                                            return  "";
                                            //return '<input type="text" placeholder="apellido Paterno" class="apellidoPaterno_auto" onkeyup="seleccionCampo(this)">';
                                        }else{
                                            return data;
                                        }
                                    }
                                },           
                                { data: "apellidoMaterno",
                                    "render": function ( data, type, row, meta ) {
                                        if(data < 1){
                                            return "";
                                            //return '<input type="text" placeholder="apellido Materno" class="apellidoMaterno_auto" onkeyup="seleccionCampo(this)">';
                                        }else{
                                            return data;
                                        }
                                    }
                                },           
                                { data: "fechaNacimiento",
                                    "render": function ( data, type, row, meta ) {
                                        if(data < 1 || data == 'no'){
                                            return '<input type="text" id="fec_'+row.no+'" placeholder="fecha Nacimiento" class="fechaNacimiento_auto fc_auto" onChange="seleccionCampoFec(this, '+row.no+')">';
                                        }else{
                                            return '<input type="text" id="fec_'+row.no+'" placeholder="fecha Nacimiento" class="fechaNacimiento_auto fc_auto" onChange="seleccionCampoFec(this, '+row.no+')" value="'+get_date(data)+'">';
                                        }
                                    }
                                },           
                                { data: "domicilio",
                                    "render": function ( data, type, row, meta ) {
                                        if(data < 1){
                                            return '<input type="text" placeholder="domicilio" class="domicilio_auto" onkeyup="seleccionCampo(this)">';
                                        }else{
                                            return data;
                                        }
                                    }
                                },       
                                { data: "genero",
                                    "render": function ( data, type, row, meta ) {
                                        if(data < 1){
                                            return '<select class="genero_auto" onChange="seleccionCampo(this)"><option value="">Genero</option><option value="Hombre">Hombre</option><option value="Mujer">Mujer</option><option value="Otro">Otro</option></select>';
                                        }else{
                                            if(data == 'hombre' || data == 'Hombre'){selected_h = 'selected' }else{ selected_h = '';}
                                            if(data == 'mujer'  || data == 'Mujer'){selected_m = 'selected' }else{ selected_m = '';}
                                            if(data == 'otro'   || data == 'Otro'){selected_o = 'selected' }else{ selected_o = '';}

                                            return '<select class="genero_auto" onChange="seleccionCampo(this)"><option value="">Genero</option><option value="hombre" '+selected_h+'>Hombre</option><option value="mujer" '+selected_m+'>Mujer</option><option value="otro" '+selected_o+'>Otro</option></select>';
                                        }
                                    }
                                },   
                                { data: "edad",
                                    "render": function ( data, type, row, meta ) {
                                        if(data < 1){
                                            return '<input type="number" id="ed_'+row.no+'" placeholder="edad" class="edad_auto" min="1" max="100" onChange="seleccionCampo(this)">';
                                        }else{
                                            return '<input type="number" id="ed_'+row.no+'" placeholder="edad" class="edad_auto" min="1" max="100" onChange="seleccionCampo(this)" value="'+data+'">';
                                        }
                                    }
                                },   
                                { data: "ingreso",
                                    "render": function ( data, type, row, meta ) {
                                        if(data < 1){
                                            return '<input type="text" placeholder="Ingreso" class="ingreso_auto fc_auto" onChange="seleccionCampo(this)">';
                                        }else{
                                            return '<input type="text" placeholder="Ingreso" class="ingreso_auto fc_auto" onChange="seleccionCampo(this)" value="'+data+'">';
                                        }
                                    }
                                },   
                                { data: "estatus_imputado",
                                    "render": function ( data, type, row, meta ) {
                                        if(data < 1){
                                            return '<select class="estatus_imputado_auto" onchange="seleccionCampo(this)"><option value="">Estatus</option><option value="LIBRE">LIBRE</option><option value="INTERNO">INTERNO</option><option value="DEFUNCION">DEFUNCION</option></select>';
                                        }else{
                                            if(data == 'ACTIVO'     ){selected_ac = 'selected' }else{ selected_ac = '';}
                                            if(data == 'LIBRE'      ){selected_li = 'selected' }else{ selected_li = '';}
                                            if(data == 'INTERNO'    ){selected_in = 'selected' }else{ selected_in = '';}
                                            if(data == 'DEFUNCION'  ){selected_de = 'selected' }else{ selected_de = '';}
                                            
                                        return '<select class="estatus_imputado_auto" onchange="seleccionCampo(this)"><option value="">Estatus</option><option value="ACTIVO" '+selected_ac+'>ACTIVO</option><option value="LIBRE" '+selected_li+'>LIBRE</option><option value="INTERNO" '+selected_in+'>INTERNO</option><option value="DEFUNCION" '+selected_de+'>DEFUNCION</option></select>';
                                        }
                                    }
                                },               
                                { data: "estatus_reincidencia",
                                    "render": function ( data, type, row, meta ) {
                                        if(data < 1){
                                            return '<select class="estatus_reincidencia_auto" onchange="seleccionCampo(this)"><option value="">Estatus</option><option value="Si">Si</option><option value="No">No</option></select>';
                                        }else{
                                            if(data == 'Si' || data =='si' ){selected_si = 'selected' }else{ selected_si = '';}
                                            if(data == 'No'  || data =='no' ){selected_no = 'selected' }else{ selected_no = '';}

                                            return '<select class="estatus_reincidencia_auto" onchange="seleccionCampo(this)"><option value="">Estatus</option><option value="Si" '+selected_si+'>Si</option><option value="No" '+selected_no+'>No</option></select>';
                                        }
                                    }
                                },                   
                                { data: "fecha_vinculacion_proceso",
                                    "render": function ( data, type, row, meta ) {
                                        if(data < 1 || data == 'no' ){
                                            return `<input type="text" placeholder="Fecha de vinculacion" class="fecha_vinculacion_proceso_input_auto fecha_vinculacion_proceso_auto fc_auto" style="width:80%; margin-right:3%;" onChange="seleccionCampo(this)"><input type="checkbox" value="No Vinculacion" title="No Vinculacion" class="novinculado" onchange="novincular(this)">`;
                                        }else{
                                            if(data == '1900-01-01' || data == 'No Vinculacion'){
                                                return `<input type="text" placeholder="Fecha de vinculacion" class="fecha_vinculacion_proceso_input_auto fecha_vinculacion_proceso_auto fc_auto" style="width:80%; margin-right:3%;" onChange="seleccionCampo(this)" value="No Vinculacion"><input type="checkbox" checked value="No Vinculacion" title="No Vinculacion" class="novinculado" onchange="novincular(this)">`;
                                            }else{
                                                return '<input type="text" placeholder="Fecha de vinculacion" class="fecha_vinculacion_proceso_input_auto fecha_vinculacion_proceso_auto fc_auto" onChange="seleccionCampo(this)" value="'+get_date(data)+'">';
                                            }
                                        }
                                    }
                                },                       
                                { data: "fecha_sentencia",
                                    "render": function ( data, type, row, meta ) {
                                        if(data < 1 || data == 'no'){
                                            return `<input type="text" placeholder="Fecha de sentencia" class="fecha_sentencia_input_auto fecha_sentencia_auto fc_auto" onChange="seleccionCampo(this)">`;
                                        }else{
                                            return '<input type="text" placeholder="Fecha de sentencia" class="fecha_sentencia_input_auto fecha_sentencia_auto fc_auto" onChange="seleccionCampo(this)" value="'+get_date(data)+'">';
                                        }
                                    }
                                },           
                                { data: "fecha_apelacion",
                                    "render": function ( data, type, row, meta ) {
                                        if(data < 1){
                                            return '<input type="text" placeholder="Fecha de Apelacion" class="fecha_apelacion_auto fc_auto" onChange="seleccionCampo(this)">';
                                        }else{
                                            return '<input type="text" placeholder="Fecha de Apelacion" class="fecha_apelacion_auto fc_auto" onChange="seleccionCampo(this)" value="'+get_date(data)+'">';
                                        }
                                    }
                                },           
                                { data: "estatus_multa_posterior_apelacion",
                                    "render": function ( data, type, row, meta ) {
                                        if(data < 1){
                                            return '<select class="estatus_multa_posterior_apelacion_auto" onchange="seleccionCampo(this)"><option value="">Estatus</option><option value="Cumplida">Si Cumplida</option><option value="No_Cumplida">No Cumplida</option></select>';
                                        }else{
                                            if(data == 'Cumplida' || data =='cumplida' ){selected_cum = 'selected' }else{ selected_cum = '';}
                                            if(data == 'No_Cumplida'  || data =='no_cumplida' ){selected_noc = 'selected' }else{ selected_noc = '';}

                                            return '<select class="estatus_multa_posterior_apelacion_auto" onchange="seleccionCampo(this)"><option value="">Estatus</option><option value="Cumplida" '+selected_cum+'>Si Cumplida</option><option value="No_Cumplida" '+selected_noc+'>No Cumplida</option></select>';
                                        }
                                    }
                                },                               
                                { data: "pena_pecunaria_posterior_apelacion",
                                    "render": function ( data, type, row, meta ) {
                                        if(data < 1){
                                            return (
                                                `<select  style="float:left; width:69.33%" class="pena_pecunaria_posterior_apelacion_select_auto pena_pecunaria_posterior_apelacion_auto " onchange="seleccionCampo(this)"><option value="">Pena Pecuniaria</option><option value="Multa">Multa</option><option value="Reparacion del daño">Reparacion del daño</option><option value="Sancion Economica">Sancion Economica</option></select>
                                                <input style="float:left; width:29.33%"  type="text" placeholder="cantidad" class="pena_pecunaria_posterior_apelacion_moneda_auto pena_pecunaria_posterior_apelacion_auto" onkeyup="seleccionCampo(this)">`
                                            )
                                        }else{
                                            return data;
                                        }
                                    }
                                },                               
                                { data: "fecha_amparo",
                                    "render": function ( data, type, row, meta ) {
                                        if(data < 1 || data == 'no'){
                                            return '<input type="text" placeholder="Fecha de Amparo" class="fecha_amparo_auto fc_auto" onChange="seleccionCampo(this)">';
                                        }else{
                                            return '<input type="text" placeholder="Fecha de Amparo" class="fecha_amparo_auto fc_auto" onChange="seleccionCampo(this)" value="'+get_date(data)+'">';
                                        }
                                    }
                                },           
                                { data: "fecha_sobreseimiento",
                                    "render": function ( data, type, row, meta ) {
                                        if(data < 1 || data == 'no'){
                                            return `<input type="text" placeholder="Fecha sobreseimiento" class="fecha_sobreseimiento_input_auto fecha_sobreseimiento_auto fc_auto" onChange="seleccionCampo(this)">`;
                                        }else{
                                            return '<input type="text" placeholder="Fecha sobreseimiento" class="fecha_sobreseimiento_input_auto fecha_sobreseimiento_auto fc_auto" onChange="seleccionCampo(this)" value="'+get_date(data)+'">';
                                        }
                                    }
                                },                
                                { data: "tipo_juicio",
                                    "render": function ( data, type, row, meta ) {
                                        if(data < 1 ){
                                            return '<select class="tipo_juicio_auto" onchange="seleccionCampo(this)"><option value="">Tipo Juicio</option><option value="Abreviado">Abreviado</option><option value="Ordinario Juicio Oral">Ordinario Juicio Oral</option></select>';
                                        }else{
                                            if(data == 'Abreviado' || data =='abreviado' ){selected_abr = 'selected' }else{ selected_abr = '';}
                                            if(data == 'Ordinario Juicio Oral'  || data =='ordinario juicio oral' ){selected_ojo = 'selected' }else{ selected_ojo = '';}

                                            return '<select class="tipo_juicio_auto" onchange="seleccionCampo(this)"><option value="">Tipo Juicio</option><option value="Abreviado" '+selected_abr+'>Abreviado</option><option value="Ordinario Juicio Oral" '+selected_ojo+'>Ordinario Juicio Oral</option></select>';
                                        }
                                    }
                                },       
                                { data: "tiempo_sentencia",
                                    "render": function ( data, type, row, meta ) {
                                        if(data < 1 || data == 'no'){
                                            return (
                                                `<input type="number" style="float:left; width:33.33%" placeholder="Año" min="0" max="100" id="tiempo_anio_sentencia_auto" class="tiempo_anio_sentencia_auto    tiempo_sentencia_auto" onkeyup="seleccionCampo(this)"/>
                                                <input type="number" style="float:left; width:33.33%" placeholder="Mes" min="0" max="50"  id="tiempo_mes_sentencia_auto " class="tiempo_mes_sentencia_auto     tiempo_sentencia_auto" onkeyup="seleccionCampo(this)"/>
                                                <input type="number" style="float:left; width:33.33%" placeholder="Dia" min="0" max="365" id="tiempo_dia_sentencia_auto " class="tiempo_dia_sentencia_auto     tiempo_sentencia_auto" onkeyup="seleccionCampo(this)"/>`
                                            ); 
                                        }else{
                                            return data;
                                        }
                                    }
                                },               
                                { data: "estatus_multa_posterior_sentencia",
                                    "render": function ( data, type, row, meta ) {
                                        if(data < 1){
                                            return '<select class="estatus_multa_posterior_sentencia_auto" onchange="seleccionCampo(this)"><option value="">Estatus</option><option value="Cumplida">Si Cumplida</option><option value="No_Cumplida">No Cumplida</option></select>';
                                        }else{
                                            if(data == 'Cumplida' | 'cumplida' ){selected_cump = 'selected' }else{ selected_cump = '';}
                                            if(data == 'No_Cumplida'  | 'no_cumplida' ){selected_nocu = 'selected' }else{ selected_nocu = '';}
                                            return '<select class="estatus_multa_posterior_sentencia_auto" onchange="seleccionCampo(this)"><option value="">Estatus</option><option value="Cumplida" '+selected_cump+'>Si Cumplida</option><option value="No_Cumplida" '+selected_nocu+'>No Cumplida</option></select>';
                                        }
                                    }
                                },                               
                                { data: "pena_pecunaria_sentencia",
                                    "render": function ( data, type, row, meta ) {
                                        if(data < 1){
                                            return (
                                                `<select  style="float:left; width:69.33%" class="pena_pecunaria_sentencia_select_auto pena_pecunaria_sentencia_auto " onchange="seleccionCampo(this)"><option value="">Pena Pecuniaria</option><option value="Multa">Multa</option><option value="Reparacion del daño">Reparacion del daño</option><option value="Sancion Economica">Sancion Economica</option></select>
                                                <input style="float:left; width:29.33%"  type="text" placeholder="cantidad" class="pena_pecunaria_sentencia_moneda_auto pena_pecunaria_sentencia_auto" onkeyup="seleccionCampo(this)">`
                                            )
                                        }else{
                                            return data;
                                        }
                                    }
                                },                       
                                { data: "estatus_carpeta",
                                    "render": function ( data, type, row, meta ) {
                                        if(data < 1){
                                            return '<select class="estatus_carpeta_auto" onchange="seleccionCampo(this)"><option value="">Estatus</option><option value="Activo">Activo</option><option value="Cerrada">Cerrada</option></select>';
                                        }else{
                                            if(data == 'ACTIVO' || data =='Activo' ){selected_acti = 'selected' }else{ selected_acti = '';}
                                            if(data == 'CERRADA'  || data =='Cerrada' ){selected_cerr = 'selected' }else{ selected_cerr = '';}

                                            return '<select class="estatus_carpeta_auto" onchange="seleccionCampo(this)"><option value="">Estatus</option><option value="Activo" '+selected_acti+'>Activo</option><option value="Cerrada" '+selected_cerr+'>Cerrada</option></select>';
                                        }
                                    }
                                },
                                { data: "id_persona",                               }         
                            ],
                            columnDefs:[
                                {targets: [25], visible: false, searchable: false}
                            ],
                            searching: true, 
                            paging: true,
                            info:false, 
                            language: {
                                "decimal": "",
                                "emptyTable": "No hay información",
                                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                                "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                                "infoPostFix": "",
                                "thousands": ",",
                                "lengthMenu": "Mostrar _MENU_ Entradas",
                                "loadingRecords": "Cargando...",
                                "processing": "Procesando...",
                                "search": "Buscar:",
                                "zeroRecords": "Sin resultados encontrados",
                                "paginate": {
                                    "first": "Primero",
                                    "last": "Ultimo",
                                    "next": "Siguiente",
                                    "previous": "Anterior"
                                }
                            },
                            lengthMenu: [[7,10, 25, 50, -1], [7,10, 25, 50, "All"]]
                        });
                        
                        $('#sarchItem').on('keyup', function () {
                            table.search($(this).val()).draw();
                        } );
            

                        $('#version_CSV').val(response.version);
                        $('#nombre_CSV').val(response.nombre_documento);
                        $('#id_report').val(id_reporte);
                        eliminar_json_temporal(response.nombre_documento,2);
                        
                    table.on('page.dt', function (){
                            setTimeout(function(){
                                $(".fc_auto").datepicker({showOtherMonths: true,selectOtherMonths: true,dateFormat: 'yy-mm-dd',});
                            }, 600);
                        });

                        $('#vista_Excel_Modal').modal('show');

                    }else if(response.status == 200){
                        $('#modal-warning-titulo').html(response.response);
                        $('#modalWarning').modal('show');
                    }
                    
                }
            });
            
            setTimeout(function(){
                $(".fc_auto").datepicker({showOtherMonths: true,selectOtherMonths: true,dateFormat: 'yy-mm-dd',});
            }, 600)

            hScroll(60);
        }

        //{{-- Guarda los datos en el json local --}}
        function guardar_json_local(){
            var json_csv= [];
            var csv2= [];
            var json = [];
            var version_CSV = (parseInt($('#version_CSV').val(), 10) + 1);
            var nombre_CSV = $('#nombre_CSV').val();
            var id_reporte = $('#id_report').val();
            var nombre_nuevo_CSV = id_reporte+'_'+version_CSV

            var no = [];
            var CI = [];
            var CJ = [];
            var nombre = [];
            var apellidoPaterno = [];
            var apellidoMaterno = [];
            var fechaNacimiento = [];
            var domicilio = [];
            var genero = [];
            var edad = [];
            var ingreso = [];
            var estatus_imputado = [];
            var estatus_reincidencia = [];
            var fecha_vinculacion_proceso = [];
            var fecha_sentencia = [];
            var fecha_apelacion = [];
            var estatus_multa_posterior_apelacion = [];
            var pena_pecunaria_posterior_apelacion = [];
            var fecha_amparo = [];
            var fecha_sobreseimiento = [];
            var tipo_juicio = [];
            var tiempo_sentencia = [];
            var estatus_multa_posterior_sentencia = [];
            var pena_pecunaria_sentencia = [];
            var estatus_carpeta = [];
            var persona = [];
            
            var rows = $("#table_vista_Excel_Modal").dataTable().fnGetNodes();
            for(var i=0; i<rows.length; i++)
            {
                no.push($(rows[i]).find("td").eq(0).children(".no_auto").val());
                CJ.push($(rows[i]).find("td").eq(1).text());
                CI.push($(rows[i]).find("td").eq(2).text());
                
                nombre.push( $(rows[i]).find("td").eq(3).text() );
                apellidoPaterno.push( $(rows[i]).find("td").eq(4).text() );
                apellidoMaterno.push($(rows[i]).find("td").eq(5).text());

                /*
                //nombre
                if($(rows[i]).find("td").eq(3).text().length >= 1){
                    nombre.push($(rows[i]).find("td").eq(3).text());
                }else{
                    var texto = $(rows[i]).find("td").eq(3).text().toUpperCase();

                    if(texto.length == 2){
                        texto = "";
                    }
                    nombre.push( texto );
                }

                //Apellido Paterno
                if($(rows[i]).find("td").eq(4).text().length >= 1){
                    apellidoPaterno.push($(rows[i]).find("td").eq(4).text());
                }else{
                    var texto = $(rows[i]).find("td").eq(4).text().toUpperCase() ;
                    if(texto.length == 2){
                        texto = "";
                    }
                    apellidoPaterno.push( texto );
                }

                //Apellido Materno
                if($(rows[i]).find("td").eq(5).text().length >= 1){
                    apellidoMaterno.push( $(rows[i]).find("td").eq(5).text() );
                }else{
                    var texto =  $(rows[i]).find("td").eq(5).text().toUpperCase() ;
                    if(texto.length == 2){
                        texto = "";
                    }
                    apellidoMaterno.push(texto);
                }
                */

                //Fecha Nacimiento
                if($(rows[i]).find("td").eq(6).children(".fechaNacimiento_auto").val().length <= 1){
                    fechaNacimiento.push("");
                }else{
                    var editado =  $(rows[i]).find("td").eq(6).children(".fechaNacimiento_auto").attr('modificado');
                    if(editado == 0){
                        var texto =  $(rows[i]).find("td").eq(6).children(".fechaNacimiento_auto").val()  + ',0';
                        if(texto.length == 2){
                            texto = "";
                        }
                        fechaNacimiento.push( texto );
                    }else{
                        var texto =  $(rows[i]).find("td").eq(6).children(".fechaNacimiento_auto").val();
                        fechaNacimiento.push( texto );
                    }
                }

                //Domicilio
                if($(rows[i]).find("td").eq(7).text().length >= 1){
                    domicilio.push($(rows[i]).find("td").eq(7).text());
                }else{
                    var texto =  $(rows[i]).find("td").eq(7).text();
                    if(texto.length == 2){
                        texto = "";
                    }
                    domicilio.push( texto );
                }

                //Genero
                if($(rows[i]).find("td").eq(8).children(".genero_auto").val().length <= 0 ){
                    genero.push("");
                }else{
                    var editado = $(rows[i]).find("td").eq(8).children(".genero_auto").attr('modificado');
                    if(editado == 0){
                        var texto = $(rows[i]).find("td").eq(8).children(".genero_auto").val() + ',0';
                        if(texto.length == 2){
                            texto = "";
                        }
                        genero.push( texto );
                    }else{
                        var texto = $(rows[i]).find("td").eq(8).children(".genero_auto").val();
                        genero.push( texto );
                    }
                }

                //edad
                if($(rows[i]).find("td").eq(9).children(".edad_auto").val().length <= 0){
                    edad.push("");
                }else{
                    var editado = $(rows[i]).find("td").eq(9).children(".edad_auto").attr('modificado');
                    if(editado == 0){
                        var texto = $(rows[i]).find("td").eq(9).children(".edad_auto").val() + ',0';
                        if(texto.length == 2){
                            texto = "";
                        }
                        edad.push( texto );
                    }else{
                        var texto = $(rows[i]).find("td").eq(9).children(".edad_auto").val();
                        edad.push( texto );
                    }
                }

                //ingreso
                if($(rows[i]).find("td").eq(10).children(".ingreso_auto").val().length <= 0){
                    ingreso.push("");
                }else{
                    var editado = $(rows[i]).find("td").eq(10).children(".ingreso_auto").attr('modificado');
                    if(editado == 0){
                        var texto = $(rows[i]).find("td").eq(10).children(".ingreso_auto").val() + ',0';
                        if(texto.length == 2){
                            texto = "";
                        }
                        ingreso.push( texto );
                    }else{
                        var texto = $(rows[i]).find("td").eq(10).children(".ingreso_auto").val();
                        ingreso.push( texto );
                    }
                }

                //estatus imputado
                if($(rows[i]).find("td").eq(11).children(".estatus_imputado_auto").val().length <= 0){
                    estatus_imputado.push("");
                }else{
                    var editado = $(rows[i]).find("td").eq(11).children(".estatus_imputado_auto").attr('modificado');
                    if(editado == 0){
                        var texto = $(rows[i]).find("td").eq(11).children(".estatus_imputado_auto").val()  + ',0';
                        if(texto.length == 2){
                            texto = "";
                        }
                        estatus_imputado.push(texto );
                    }else{
                        var texto = $(rows[i]).find("td").eq(11).children(".estatus_imputado_auto").val();
                        estatus_imputado.push( texto );
                    }
                }            

                //estatus reincidencia
                if($(rows[i]).find("td").eq(12).children(".estatus_reincidencia_auto").val().length <= 0){
                    estatus_reincidencia.push("");
                }else{
                    var editado = $(rows[i]).find("td").eq(12).children(".estatus_reincidencia_auto").attr('modificado');
                    if(editado == 0){
                        var texto = $(rows[i]).find("td").eq(12).children(".estatus_reincidencia_auto").val()  + ',0';
                        if(texto.length == 2){
                            texto = "";
                        }
                        estatus_reincidencia.push( texto );
                    }else{
                        var texto = $(rows[i]).find("td").eq(12).children(".estatus_reincidencia_auto").val();
                        estatus_reincidencia.push( texto );
                    }
                }  
                
                //Fecha vinculacion proceso (rango entre 1 y 10)
                if($(rows[i]).find("td").eq(13).children(".fecha_vinculacion_proceso_input_auto").val().length <= 0 ){
                    fecha_vinculacion_proceso.push("");
                }else{
                    var editado = $(rows[i]).find("td").eq(13).children(".fecha_vinculacion_proceso_input_auto").attr('modificado');
                    if(editado == 0){
                        var texto = $(rows[i]).find("td").eq(13).children(".fecha_vinculacion_proceso_input_auto").val() + ',0'
                        if(texto.length == 2){
                            texto = "";
                        }
                        fecha_vinculacion_proceso.push( texto );
                    }else{
                        var texto = $(rows[i]).find("td").eq(13).children(".fecha_vinculacion_proceso_input_auto").val();
                        fecha_vinculacion_proceso.push( texto );
                    }
                }   
                
                //Fecha setencia
                if($(rows[i]).find("td").eq(14).children(".fecha_sentencia_input_auto").val().length <= 0){
                    fecha_sentencia.push("");
                }else{
                    var editado = $(rows[i]).find("td").eq(14).children(".fecha_sentencia_input_auto").attr('modificado');
                    if(editado == 0){
                        var texto = $(rows[i]).find("td").eq(14).children(".fecha_sentencia_input_auto").val() + ',0'
                        if(texto.length == 2){
                            texto = "";
                        }
                        fecha_sentencia.push( texto );
                    }else{
                        var texto = $(rows[i]).find("td").eq(14).children(".fecha_sentencia_input_auto").val();
                        fecha_sentencia.push( texto );
                    }
                }             

                //Fecha apelacion
                if($(rows[i]).find("td").eq(15).children(".fecha_apelacion_auto").val() .length <= 1){
                    fecha_apelacion.push("");
                }else{
                    var editado = $(rows[i]).find("td").eq(15).children(".fecha_apelacion_auto").attr('modificado');
                    if(editado == 0){
                        var texto = $(rows[i]).find("td").eq(15).children(".fecha_apelacion_auto").val()  + ',0';
                        if(texto.length == 2){
                            texto = "";
                        }
                        fecha_apelacion.push(texto );
                    }else{
                        var texto = $(rows[i]).find("td").eq(15).children(".fecha_apelacion_auto").val();
                        fecha_apelacion.push( texto );
                    }
                } 

                //Estatus multa posterior apelacion
                if($(rows[i]).find("td").eq(16).children(".estatus_multa_posterior_apelacion_auto").val().length <= 0){
                    estatus_multa_posterior_apelacion.push(""); 
                }else{
                    var editado = $(rows[i]).find("td").eq(16).children(".estatus_multa_posterior_apelacion_auto").attr('modificado');
                    if(editado == 0){
                        var texto = $(rows[i]).find("td").eq(16).children(".estatus_multa_posterior_apelacion_auto").val()  + ',0';
                        if(texto.length == 2){
                            texto = "";
                        }
                        estatus_multa_posterior_apelacion.push( texto );
                    }else{
                        var texto = $(rows[i]).find("td").eq(16).children(".estatus_multa_posterior_apelacion_auto").val();
                        estatus_multa_posterior_apelacion.push( texto );
                    }
                }             

                //Pena pecunaria posterior apelacion
                if($(rows[i]).find("td").eq(17).text().length >= 1 && $(rows[i]).find("td").eq(17).text().length <= 30){
                    pena_pecunaria_posterior_apelacion.push($(rows[i]).find("td").eq(17).text());
                }else{

                    var texto = $(rows[i]).find("td").eq(17).children(".pena_pecunaria_posterior_apelacion_select_auto").val() + ' $' + $(rows[i]).find("td").eq(17).children(".pena_pecunaria_posterior_apelacion_moneda_auto").val() + ',0';

                    if(texto.length == 4){
                        texto = "";
                    }

                    pena_pecunaria_posterior_apelacion.push(texto);
                }

            //Fecha amparo
            if($(rows[i]).find("td").eq(18).children(".fecha_amparo_auto").val().length <= 0){
                    fecha_amparo.push(""); 
            }else{
                var editado = $(rows[i]).find("td").eq(18).children(".fecha_amparo_auto").attr('modificado');
                if(editado == 0){
                        var texto = $(rows[i]).find("td").eq(18).children(".fecha_amparo_auto").val() + ',0';
                        if(texto.length == 2){
                            texto = "";
                        }
                        fecha_amparo.push( texto );
                    }else{
                        var texto = $(rows[i]).find("td").eq(18).children(".fecha_amparo_auto").val();
                        fecha_amparo.push( texto );
                    }
            } 

                //Fecha sobreseimiento
                if($(rows[i]).find("td").eq(19).children(".fecha_sobreseimiento_input_auto").val() .length <=0){
                    fecha_sobreseimiento.push(""); 
                }else{
                    var editado = $(rows[i]).find("td").eq(19).children(".fecha_sobreseimiento_input_auto").attr('modificado');
                    if(editado == 0){
                        var texto = $(rows[i]).find("td").eq(19).children(".fecha_sobreseimiento_input_auto").val() + ',0'
                        if(texto.length == 20 || texto.length==2){
                            texto = "";
                        }
                        fecha_sobreseimiento.push( texto );
                    }else{
                        var texto = $(rows[i]).find("td").eq(19).children(".fecha_sobreseimiento_input_auto").val();
                        fecha_sobreseimiento.push( texto );
                    }
                } 

                //Tipo juicio
                if($(rows[i]).find("td").eq(20).children(".tipo_juicio_auto").val().length <= 0){
                    tipo_juicio.push($(rows[i]).find("td").eq(20).children(".tipo_juicio_auto").val());  
                }else{
                    var editado = $(rows[i]).find("td").eq(20).children(".tipo_juicio_auto").attr('modificado');
                    if(editado == 0){
                        var texto = $(rows[i]).find("td").eq(20).children(".tipo_juicio_auto").val() + ',0'
                        if(texto.length == 20 || texto.length == 2 ){
                            texto = "";
                        }
                        tipo_juicio.push( texto );
                    }else{
                        var texto = $(rows[i]).find("td").eq(20).children(".tipo_juicio_auto").val();
                        tipo_juicio.push( texto );
                    }
                }            

                //Tiempo sentencia
                if($(rows[i]).find("td").eq(21).text().length >= 1 && $(rows[i]).find("td").eq(21).text().length <= 30){
                    tiempo_sentencia.push($(rows[i]).find("td").eq(21).text());
                }else{

                    var texto = $(rows[i]).find("td").eq(21).children(".tiempo_anio_sentencia_auto").val() + ' años ' + $(rows[i]).find("td").eq(21).children(".tiempo_mes_sentencia_auto").val() + ' meses ' + $(rows[i]).find("td").eq(21).children(".tiempo_dia_sentencia_auto").val() + ' dias,0' ;

                    if(texto.length == 20){
                        texto = "";
                    }

                    tiempo_sentencia.push(texto);
                }            
                
                //estatus multa posterior setencia
                if( $(rows[i]).find("td").eq(22).children(".estatus_multa_posterior_sentencia_auto").val().length <=0){
                    estatus_multa_posterior_sentencia.push(""); 
                }else{
                    var editado = $(rows[i]).find("td").eq(22).children(".estatus_multa_posterior_sentencia_auto").attr('modificado');
                    if(editado == 0){
                        var texto = $(rows[i]).find("td").eq(22).children(".estatus_multa_posterior_sentencia_auto").val() + ',0'
                        if(texto.length == 20 || texto.length == 2){
                            texto = "";
                        }
                        estatus_multa_posterior_sentencia.push( texto );
                    }else{
                        var texto = $(rows[i]).find("td").eq(22).children(".estatus_multa_posterior_sentencia_auto").val();
                        estatus_multa_posterior_sentencia.push( texto );
                    }
                }

                //pena_pecunaria_sentencia
                if($(rows[i]).find("td").eq(23).text().length >= 1 && $(rows[i]).find("td").eq(23).text().length <= 30){
                    pena_pecunaria_sentencia.push($(rows[i]).find("td").eq(23).text()); 
                }else{
                    var texto = $(rows[i]).find("td").eq(23).children(".pena_pecunaria_sentencia_select_auto").val() + ' $' + $(rows[i]).find("td").eq(23).children(".pena_pecunaria_sentencia_moneda_auto").val() +',0';
                    if(texto.length == 4){
                        texto = "";
                    }
                    pena_pecunaria_sentencia.push(texto);
                }            

                //estatus_carpeta
                if($(rows[i]).find("td").eq(24).children(".estatus_carpeta_auto").val().length <= 0  ){
                    estatus_carpeta.push("");
                }else{
                    var editado = $(rows[i]).find("td").eq(24).children(".estatus_carpeta_auto").attr('modificado');
                    if(editado == 0){
                        var texto = $(rows[i]).find("td").eq(24).children(".estatus_carpeta_auto").val() + ',0'
                        if(texto.length == 20){
                            texto = "";
                        }
                        estatus_carpeta.push( texto );
                    }else{
                        var texto = $(rows[i]).find("td").eq(24).children(".estatus_carpeta_auto").val();
                        estatus_carpeta.push( texto );
                    } 
                }
                
                //persona
                persona.push($(rows[i]).find("td").eq(0).children(".no_auto").attr('data-persona'));
            }

            var tr = [];
            var tr2 = [];
            for(i = 0; i < CJ.length; i++){
                tr.push({
                    "CJ":CJ[i],
                    "CI":CI[i],
                    "nombre":nombre[i],
                    "apellidoPaterno":apellidoPaterno[i],
                    "apellidoMaterno":apellidoMaterno[i],
                    "fechaNacimiento":fechaNacimiento[i],
                    "domicilio":domicilio[i],
                    "genero":genero[i],
                    "edad":edad[i],
                    "ingreso":ingreso[i],
                    "estatus_imputado":estatus_imputado[i],
                    "estatus_reincidencia":estatus_reincidencia[i],
                    "fecha_vinculacion_proceso":fecha_vinculacion_proceso[i],
                    "fecha_sentencia":fecha_sentencia[i],
                    "fecha_apelacion":fecha_apelacion[i],
                    "estatus_multa_posterior_apelacion":estatus_multa_posterior_apelacion[i],
                    "pena_pecunaria_posterior_apelacion":pena_pecunaria_posterior_apelacion[i],
                    "fecha_amparo":fecha_amparo[i],
                    "fecha_sobreseimiento":fecha_sobreseimiento[i],
                    "tipo_juicio":tipo_juicio[i],
                    "tiempo_sentencia":tiempo_sentencia[i],
                    "estatus_multa_posterior_sentencia":estatus_multa_posterior_sentencia[i],
                    "pena_pecunaria_sentencia":pena_pecunaria_sentencia[i],
                    "estatus_carpeta":estatus_carpeta[i],
                    "id_persona":persona[i]
                });
            }

            for(i = 0; i < no.length; i++){
                var e_fechaNacimiento = fechaNacimiento[i].split(',')
                var e_genero = genero[i].split(',')
                var e_edad = edad[i].split(',')
                var e_ingreso = ingreso[i].split(',')
                var e_estatus_imputado = estatus_imputado[i].split(',')
                var e_estatus_reincidencia = estatus_reincidencia[i].split(',')
                var e_fecha_vinculacion_proceso = fecha_vinculacion_proceso[i].split(',')
                var e_fecha_sentencia = fecha_sentencia[i].split(',')
                var e_fecha_apelacion = fecha_apelacion[i].split(',')
                var e_estatus_multa_posterior_apelacion = estatus_multa_posterior_apelacion[i].split(',')
                var e_pena_pecunaria_posterior_apelacion = pena_pecunaria_posterior_apelacion[i].split(',')
                var e_fecha_amparo = fecha_amparo[i].split(',')
                var e_fecha_sobreseimiento = fecha_sobreseimiento[i].split(',')
                var e_tipo_juicio = tipo_juicio[i].split(',')
                var e_tiempo_sentencia = tiempo_sentencia[i].split(',')
                var e_estatus_multa_posterior_sentencia = estatus_multa_posterior_sentencia[i].split(',')
                var e_pena_pecunaria_sentencia = pena_pecunaria_sentencia[i].split(',')
                var e_estatus_carpeta = estatus_carpeta[i].split(',')


                tr2.push({
                    "no":no[i],
                    "CJ":CJ[i],
                    "CI":CI[i],
                    "nombre":nombre[i],
                    "apellidoPaterno":apellidoPaterno[i],
                    "apellidoMaterno":apellidoMaterno[i],
                    "fechaNacimiento":e_fechaNacimiento[0],
                    "domicilio":domicilio[i],
                    "genero":e_genero[0],
                    "edad":e_edad[0],
                    "ingreso":e_ingreso[0],
                    "estatus_imputado":e_estatus_imputado[0],
                    "estatus_reincidencia":e_estatus_reincidencia[0],
                    "fecha_vinculacion_proceso":e_fecha_vinculacion_proceso[0],
                    "fecha_sentencia":e_fecha_sentencia[0],
                    "fecha_apelacion":e_fecha_apelacion[0],
                    "estatus_multa_posterior_apelacion":e_estatus_multa_posterior_apelacion[0],
                    "pena_pecunaria_posterior_apelacion":e_pena_pecunaria_posterior_apelacion[0],
                    "fecha_amparo":e_fecha_amparo[0],
                    "fecha_sobreseimiento":e_fecha_sobreseimiento[0],
                    "tipo_juicio":e_tipo_juicio[0],
                    "tiempo_sentencia":e_tiempo_sentencia[0],
                    "estatus_multa_posterior_sentencia":e_estatus_multa_posterior_sentencia[0],
                    "pena_pecunaria_sentencia":e_pena_pecunaria_sentencia[0],
                    "estatus_carpeta":e_estatus_carpeta[0],
                    "id_persona":persona[i]
                });
            }
            
            for(j = 0; j < tr.length; j++){
                json_csv.push(tr[j]); //se manda a guardar
            }

            for(j = 0; j < tr2.length; j++){
                csv2.push(tr2[j]); // para mostrar
            }
            
            console.log('new_view',csv2); //vista nueva
            console.log('update',json_csv);  //JSON UPDATE
            
            if(version_CSV == '' || nombre_CSV == '' ||  version_CSV == null || nombre_CSV == null ){
                json['response'] = null;
                json['version'] = null;
                json['nombre'] = null;
                json['status'] = 0;
                
                var mensaje = 'Error en la version y nombre del documento';
                modal_error(mensaje, 'vista_Excel_Modal' );
            }else{
                
                json['response'] = json_csv; //JSON UPDATE
                json['version'] = version_CSV; 
                json['nombre'] = nombre_nuevo_CSV;
                json['status'] = 100;
                
                console.log(json); //JSON UPDATE
                console.log(csv2); //vista nueva

                $.ajax({
                    type:'POST',
                    url:'/public/guardar_json_local',
                    data:{
                        version:version_CSV,
                        nombre:nombre_nuevo_CSV,
                        status:100,
                        response:csv2, //vista nueva
                    },
                    beforeSend: function(){
                        $('#btn_guardarExcel').html('Guardando...');
                    },
                    success:function(response) {
                        console.log(response);
                        
                        if(response.status == 100){
                            $('#table_vista_Excel_Modal').DataTable().destroy();
                            mostrar_version_nueva_csv(id_reporte,version_CSV,json_csv, csv2); //JSON UPDATE, vista nueva
                            modal_success(response.message, 'vista_Excel_Modal' );
                            $('#btn_guardarExcel').html('Guardar');
                        }else{
                            modal_error(response.message, 'vista_Excel_Modal' );
                            $('#btn_guardarExcel').html('Guardar');
                        }
                    }
                });
                
            }
        }

        //{{--  Formateo fecha  --}}
        function get_date(date, format = 'YYYY-MM-DD') {
            if (format == 'YYYY-MM-DD' && date.substring(0, 4).includes('-'))
                return date.split('-').reverse().join('-');
            if (format == 'DD-MM-YYYY' && !date.substring(0, 4).includes('-'))
                return date.split('-').reverse().join('-');
            else
                return date;
        }

        //{{-- Muestra los datos del json local --}}
        function mostrar_version_nueva_csv(nombre, version, json, csv2){

                var table = $('#table_vista_Excel_Modal').DataTable({
                    processing: true,
                    data:csv2,
                    responsive: false,
                    columns: [
                        { data: "no",                               
                            "render": function ( data, type, row, meta ) {
                                return '<input type="text" disabled data-persona="'+row.id_persona+'" value="'+data+'" class="no_auto" style="width: 100%; text-align: center; border: none; background: #fff;">';
                            }
                        },    
                        { data: "CJ",
                            "render": function ( data, type, row, meta ) {
                                
                                //if(data < 1){
                            //     return '<input type="text" placeholder="CI" class="CI_auto" onkeyup="seleccionCampo(this)">';
                            // }else{
                            //     return data;
                            // }

                                return data;
                            }
                        },   
                        { data: "CI",
                            "render": function ( data, type, row, meta ) {
                                
                            // if(data < 1){
                            //     return '<input type="text" placeholder="CJ" class="CJ_auto" onkeyup="seleccionCampo(this)">';
                            // }else{
                            //     return data;
                            // }
                                
                                return data;
                            }
                        },   
                        { data: "nombre",
                            "render": function ( data, type, row, meta ) {
                                if(data < 1){
                                    return "";
                                    //return '<input type="text" placeholder="nombre" class="nombre_auto" onkeyup="seleccionCampo(this)">';
                                }else{
                                    return data;
                                }
                            }
                        },       
                        { data: "apellidoPaterno",
                            "render": function ( data, type, row, meta ) {
                                if(data < 1){
                                    return "";
                                    //return '<input type="text" placeholder="apellido Paterno" class="apellidoPaterno_auto" onkeyup="seleccionCampo(this)">';
                                }else{
                                    return data;
                                }
                            }
                        },           
                        { data: "apellidoMaterno",
                            "render": function ( data, type, row, meta ) {
                                if(data < 1){
                                    return "";
                                    //return '<input type="text" placeholder="apellido Materno" class="apellidoMaterno_auto" onkeyup="seleccionCampo(this)">';
                                }else{
                                    return data;
                                }
                            }
                        },           
                        { data: "fechaNacimiento",
                            "render": function ( data, type, row, meta ) {
                                if(data < 1 || data == 'no'){
                                    return '<input type="text" id="fec_'+row.no+'" placeholder="fecha Nacimiento" class="fechaNacimiento_auto fc_auto" onChange="seleccionCampoFec(this, '+row.no+')">';
                                }else{
                                    return '<input type="text" id="fec_'+row.no+'" placeholder="fecha Nacimiento" class="fechaNacimiento_auto fc_auto" onChange="seleccionCampoFec(this, '+row.no+')" value="'+get_date(data)+'">';
                                }
                            }
                        },              
                        { data: "domicilio",
                            "render": function ( data, type, row, meta ) {
                                if(data < 1){
                                    return '<input type="text" placeholder="domicilio" class="domicilio_auto" onkeyup="seleccionCampo(this)">';
                                }else{
                                    return data;
                                }
                            }
                        },       
                        { data: "genero",
                            "render": function ( data, type, row, meta ) {
                                if(data < 1){
                                    return '<select class="genero_auto" onChange="seleccionCampo(this)"><option value="">Genero</option><option value="Hombre">Hombre</option><option value="Mujer">Mujer</option><option value="Otro">Otro</option></select>';
                                }else{
                                    if(data == 'hombre' || data == 'Hombre'){selected_h = 'selected' }else{ selected_h = '';}
                                    if(data == 'mujer'  || data == 'Mujer'){selected_m = 'selected' }else{ selected_m = '';}
                                    if(data == 'otro'   || data == 'Otro'){selected_o = 'selected' }else{ selected_o = '';}

                                    return '<select class="genero_auto" onChange="seleccionCampo(this)"><option value="">Genero</option><option value="hombre" '+selected_h+'>Hombre</option><option value="mujer" '+selected_m+'>Mujer</option><option value="otro" '+selected_o+'>Otro</option></select>';
                                }
                            }
                        },   
                        { data: "edad",
                            "render": function ( data, type, row, meta ) {
                                if(data < 1){
                                    return '<input type="number" id="ed_'+row.no+'" placeholder="edad" class="edad_auto" min="1" max="100" onChange="seleccionCampo(this)">';
                                }else{
                                    return '<input type="number" id="ed_'+row.no+'" placeholder="edad" class="edad_auto" min="1" max="100" onChange="seleccionCampo(this)" value="'+data+'">';
                                }
                            }
                        },   
                        { data: "ingreso",
                            "render": function ( data, type, row, meta ) {
                                if(data < 1){
                                    return '<input type="text" placeholder="Ingreso" class="ingreso_auto fc_auto" onChange="seleccionCampo(this)">';
                                }else{
                                    return '<input type="text" placeholder="Ingreso" class="ingreso_auto fc_auto" onChange="seleccionCampo(this)" value="'+data+'">';
                                }
                            }
                        },   
                        { data: "estatus_imputado",
                            "render": function ( data, type, row, meta ) {
                                if(data < 1){
                                    return '<select class="estatus_imputado_auto" onchange="seleccionCampo(this)"><option value="">Estatus</option><option value="LIBRE">LIBRE</option><option value="INTERNO">INTERNO</option><option value="DEFUNCION">DEFUNCION</option></select>';
                                }else{
                                    if(data == 'ACTIVO'     ){selected_ac = 'selected' }else{ selected_ac = '';}
                                    if(data == 'LIBRE'      ){selected_li = 'selected' }else{ selected_li = '';}
                                    if(data == 'INTERNO'    ){selected_in = 'selected' }else{ selected_in = '';}
                                    if(data == 'DEFUNCION'  ){selected_de = 'selected' }else{ selected_de = '';}
                                    
                                return '<select class="estatus_imputado_auto" onchange="seleccionCampo(this)"><option value="">Estatus</option><option value="ACTIVO" '+selected_ac+'>ACTIVO</option><option value="LIBRE" '+selected_li+'>LIBRE</option><option value="INTERNO" '+selected_in+'>INTERNO</option><option value="DEFUNCION" '+selected_de+'>DEFUNCION</option></select>';
                                }
                            }
                        },               
                        { data: "estatus_reincidencia",
                            "render": function ( data, type, row, meta ) {
                                if(data < 1){
                                    return '<select class="estatus_reincidencia_auto" onchange="seleccionCampo(this)"><option value="">Estatus</option><option value="Si">Si</option><option value="No">No</option></select>';
                                }else{
                                    if(data == 'Si' || data =='si' ){selected_si = 'selected' }else{ selected_si = '';}
                                    if(data == 'No'  || data =='no' ){selected_no = 'selected' }else{ selected_no = '';}

                                    return '<select class="estatus_reincidencia_auto" onchange="seleccionCampo(this)"><option value="">Estatus</option><option value="Si" '+selected_si+'>Si</option><option value="No" '+selected_no+'>No</option></select>';
                                }
                            }
                        },                   
                        { data: "fecha_vinculacion_proceso",
                            "render": function ( data, type, row, meta ) {
                                if(data < 1 || data == 'no' ){
                                    return `<input type="text" placeholder="Fecha de vinculacion" class="fecha_vinculacion_proceso_input_auto fecha_vinculacion_proceso_auto fc_auto" style="width:80%; margin-right:3%;" onChange="seleccionCampo(this)"><input type="checkbox" value="No Vinculacion" title="No Vinculacion" class="novinculado" onchange="novincular(this)">`;
                                }else{
                                    if(data == '1900-01-01' || data == 'No Vinculacion'){
                                        return `<input type="text" placeholder="Fecha de vinculacion" class="fecha_vinculacion_proceso_input_auto fecha_vinculacion_proceso_auto fc_auto" style="width:80%; margin-right:3%;" onChange="seleccionCampo(this)" value="No Vinculacion"><input type="checkbox" checked value="No Vinculacion" title="No Vinculacion" class="novinculado" onchange="novincular(this)">`;
                                    }else{
                                        return '<input type="text" placeholder="Fecha de vinculacion" class="fecha_vinculacion_proceso_input_auto fecha_vinculacion_proceso_auto fc_auto" onChange="seleccionCampo(this)" value="'+get_date(data)+'">';
                                    }
                                }
                            }
                        },                       
                        { data: "fecha_sentencia",
                            "render": function ( data, type, row, meta ) {
                                if(data < 1 || data == 'no'){
                                    return `<input type="text" placeholder="Fecha de sentencia" class="fecha_sentencia_input_auto fecha_sentencia_auto fc_auto" onChange="seleccionCampo(this)">`;
                                }else{
                                    return '<input type="text" placeholder="Fecha de sentencia" class="fecha_sentencia_input_auto fecha_sentencia_auto fc_auto" onChange="seleccionCampo(this)" value="'+get_date(data)+'">';
                                }
                            }
                        },           
                        { data: "fecha_apelacion",
                            "render": function ( data, type, row, meta ) {
                                if(data < 1){
                                    return '<input type="text" placeholder="Fecha de Apelacion" class="fecha_apelacion_auto fc_auto" onChange="seleccionCampo(this)">';
                                }else{
                                    return '<input type="text" placeholder="Fecha de Apelacion" class="fecha_apelacion_auto fc_auto" onChange="seleccionCampo(this)" value="'+get_date(data)+'">';
                                }
                            }
                        },          
                        { data: "estatus_multa_posterior_apelacion",
                            "render": function ( data, type, row, meta ) {
                                if(data < 1){
                                    return '<select class="estatus_multa_posterior_apelacion_auto" onchange="seleccionCampo(this)"><option value="">Estatus</option><option value="Cumplida">Si Cumplida</option><option value="No_Cumplida">No Cumplida</option></select>';
                                }else{
                                    if(data == 'Cumplida' || data =='cumplida' ){selected_cum = 'selected' }else{ selected_cum = '';}
                                    if(data == 'No_Cumplida'  || data =='no_cumplida' ){selected_noc = 'selected' }else{ selected_noc = '';}

                                    return '<select class="estatus_multa_posterior_apelacion_auto" onchange="seleccionCampo(this)"><option value="">Estatus</option><option value="Cumplida" '+selected_cum+'>Si Cumplida</option><option value="No_Cumplida" '+selected_noc+'>No Cumplida</option></select>';
                                }
                            }
                        },                               
                        { data: "pena_pecunaria_posterior_apelacion",
                            "render": function ( data, type, row, meta ) {
                                if(data < 1){
                                    return (
                                        `<select  style="float:left; width:69.33%" class="pena_pecunaria_posterior_apelacion_select_auto pena_pecunaria_posterior_apelacion_auto " onchange="seleccionCampo(this)"><option value="">Pena Pecuniaria</option><option value="Multa">Multa</option><option value="Reparacion del daño">Reparacion del daño</option><option value="Sancion Economica">Sancion Economica</option></select>
                                        <input style="float:left; width:29.33%"  type="text" placeholder="cantidad" class="pena_pecunaria_posterior_apelacion_moneda_auto pena_pecunaria_posterior_apelacion_auto" onkeyup="seleccionCampo(this)">`
                                    )
                                }else{
                                    return data;
                                }
                            }
                        },                               
                        { data: "fecha_amparo",
                            "render": function ( data, type, row, meta ) {
                                if(data < 1 || data == 'no'){
                                    return '<input type="text" placeholder="Fecha de Amparo" class="fecha_amparo_auto fc_auto" onChange="seleccionCampo(this)">';
                                }else{
                                    return '<input type="text" placeholder="Fecha de Amparo" class="fecha_amparo_auto fc_auto" onChange="seleccionCampo(this)" value="'+get_date(data)+'">';
                                }
                            }
                        },           
                        { data: "fecha_sobreseimiento",
                            "render": function ( data, type, row, meta ) {
                                if(data < 1 || data == 'no'){
                                    return `<input type="text" placeholder="Fecha sobreseimiento" class="fecha_sobreseimiento_input_auto fecha_sobreseimiento_auto fc_auto" onChange="seleccionCampo(this)">`;
                                }else{
                                    return '<input type="text" placeholder="Fecha sobreseimiento" class="fecha_sobreseimiento_input_auto fecha_sobreseimiento_auto fc_auto" onChange="seleccionCampo(this)" value="'+get_date(data)+'">';
                                }
                            }
                        },                 
                        { data: "tipo_juicio",
                            "render": function ( data, type, row, meta ) {
                                if(data < 1 ){
                                    return '<select class="tipo_juicio_auto" onchange="seleccionCampo(this)"><option value="">Tipo Juicio</option><option value="Abreviado">Abreviado</option><option value="Ordinario Juicio Oral">Ordinario Juicio Oral</option></select>';
                                }else{
                                    if(data == 'Abreviado' || data =='abreviado' ){selected_abr = 'selected' }else{ selected_abr = '';}
                                    if(data == 'Ordinario Juicio Oral'  || data =='ordinario juicio oral' ){selected_ojo = 'selected' }else{ selected_ojo = '';}

                                    return '<select class="tipo_juicio_auto" onchange="seleccionCampo(this)"><option value="">Tipo Juicio</option><option value="Abreviado" '+selected_abr+'>Abreviado</option><option value="Ordinario Juicio Oral" '+selected_ojo+'>Ordinario Juicio Oral</option></select>';
                                }
                            }
                        },       
                        { data: "tiempo_sentencia",
                            "render": function ( data, type, row, meta ) {
                                if(data < 1 || data == 'no'){
                                    return (
                                        `<input type="number" style="float:left; width:33.33%" placeholder="Año" min="0" max="100" id="tiempo_anio_sentencia_auto" class="tiempo_anio_sentencia_auto    tiempo_sentencia_auto" onkeyup="seleccionCampo(this)"/>
                                        <input type="number" style="float:left; width:33.33%" placeholder="Mes" min="0" max="50"  id="tiempo_mes_sentencia_auto " class="tiempo_mes_sentencia_auto     tiempo_sentencia_auto" onkeyup="seleccionCampo(this)"/>
                                        <input type="number" style="float:left; width:33.33%" placeholder="Dia" min="0" max="365" id="tiempo_dia_sentencia_auto " class="tiempo_dia_sentencia_auto     tiempo_sentencia_auto" onkeyup="seleccionCampo(this)"/>`
                                    ); 
                                }else{
                                    return data;
                                }
                            }
                        },               
                        { data: "estatus_multa_posterior_sentencia",
                            "render": function ( data, type, row, meta ) {
                                if(data < 1){
                                    return '<select class="estatus_multa_posterior_sentencia_auto" onchange="seleccionCampo(this)"><option value="">Estatus</option><option value="Cumplida">Si Cumplida</option><option value="No_Cumplida">No Cumplida</option></select>';
                                }else{
                                    if(data == 'Cumplida' | 'cumplida' ){selected_cump = 'selected' }else{ selected_cump = '';}
                                    if(data == 'No_Cumplida'  | 'no_cumplida' ){selected_nocu = 'selected' }else{ selected_nocu = '';}
                                    return '<select class="estatus_multa_posterior_sentencia_auto" onchange="seleccionCampo(this)"><option value="">Estatus</option><option value="Cumplida" '+selected_cump+'>Si Cumplida</option><option value="No_Cumplida" '+selected_nocu+'>No Cumplida</option></select>';
                                }
                            }
                        },                               
                        { data: "pena_pecunaria_sentencia",
                            "render": function ( data, type, row, meta ) {
                                if(data < 1){
                                    return (
                                        `<select  style="float:left; width:69.33%" class="pena_pecunaria_sentencia_select_auto pena_pecunaria_sentencia_auto " onchange="seleccionCampo(this)"><option value="">Pena Pecuniaria</option><option value="Multa">Multa</option><option value="Reparacion del daño">Reparacion del daño</option><option value="Sancion Economica">Sancion Economica</option></select>
                                        <input style="float:left; width:29.33%"  type="text" placeholder="cantidad" class="pena_pecunaria_sentencia_moneda_auto pena_pecunaria_sentencia_auto" onkeyup="seleccionCampo(this)">`
                                    )
                                }else{
                                    return data;
                                }
                            }
                        },                       
                        { data: "estatus_carpeta",
                            "render": function ( data, type, row, meta ) {
                                if(data < 1){
                                    return '<select class="estatus_carpeta_auto" onchange="seleccionCampo(this)"><option value="">Estatus</option><option value="Activo">Activo</option><option value="Cerrada">Cerrada</option></select>';
                                }else{
                                    if(data == 'ACTIVO' || data =='Activo' ){selected_acti = 'selected' }else{ selected_acti = '';}
                                    if(data == 'CERRADA'  || data =='Cerrada' ){selected_cerr = 'selected' }else{ selected_cerr = '';}

                                    return '<select class="estatus_carpeta_auto" onchange="seleccionCampo(this)"><option value="">Estatus</option><option value="Activo" '+selected_acti+'>Activo</option><option value="Cerrada" '+selected_cerr+'>Cerrada</option></select>';
                                }
                            }
                        },
                        { data: "id_persona",                               }                
                    ],
                    columnDefs:[
                        {targets: [25], visible: false, searchable: false}
                    ],
                    searching: true, 
                    paging: true,
                    info:false, 
                    language: {
                        "decimal": "",
                        "emptyTable": "No hay información",
                        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                        "infoPostFix": "",
                        "thousands": ",",
                        "lengthMenu": "Mostrar _MENU_ Entradas",
                        "loadingRecords": "Cargando...",
                        "processing": "Procesando...",
                        "search": "Buscar:",
                        "zeroRecords": "Sin resultados encontrados",
                        "paginate": {
                            "first": "Primero",
                            "last": "Ultimo",
                            "next": "Siguiente",
                            "previous": "Anterior"
                        }
                    },
                    lengthMenu: [[7,10, 25, 50, -1], [7,10, 25, 50, "All"]]
                });
                        
                $('#sarchItem').on('keyup', function () {
                    table.search($(this).val()).draw();
                } );

                $('#version_CSV').val(version);
                $('#nombre_CSV').val(nombre);

                setTimeout(function(){
                    $(".fc_auto").datepicker({showOtherMonths: true,selectOtherMonths: true,dateFormat: 'yy-mm-dd',});
                }, 600);

                table.on('page.dt', function (){
                    setTimeout(function(){
                        $(".fc_auto").datepicker({showOtherMonths: true,selectOtherMonths: true,dateFormat: 'yy-mm-dd',});
                    }, 600);
                });

                guardar_json_CSV(nombre, version, json); //JSON UPDATE
        }

        //{{-- funcion que se ejecuta en segundo plano para enviar el json al servidor --}}
        function guardar_json_CSV(nombre, version, data){
            console.log('Json que se va', data);
            $.ajax({
                type:'POST',
                url:'/public/csv_version_nueva',
                data:{
                    nombre: nombre,
                    version: version,
                    id_unidad: unidad_gestion_u,
                    data:data
                },
                success: function(response){
                    console.log('respuesta',response);
                }
            });
        }

        //{{-- Eliminar documento Temporal de Version --}}
        function eliminar_json_temporal(nombre, version){
            var nombre_completo = nombre+version;

            $.ajax({
                type:'post',
                url:'/public/eliminar_json_temporal',
                data:{
                    nombre_archivo : nombre_completo
                },
                success: function(response){
                    console.log(response);
                }
            });
        }

        //{{-- Datos rellenados --}}
        function seleccionCampo(obj){
            if(obj.value.length > 0){
                obj.setAttribute('modificado', '0');
                obj.style.background='#848F33';
                obj.style.color='#fff';
            }else{
                obj.removeAttribute('modificado');
                obj.style.background='#efefef';
                obj.style.color='#444';
            }
        }

        function seleccionCampoFec(obj, id){
            if(obj.value.length > 0){
                obj.setAttribute('modificado', '0');
                var fecha = obj.value;
                var edad = calcularEdad(fecha);
                $('#ed_'+id).val(edad);
                $('#ed_'+id).attr('modificado', 0);
                obj.style.background='#848F33';
                obj.style.color='#fff';
                $('#ed_'+id).css('background','#848F33');
                $('#ed_'+id).css('color','#fff');
            }else{
                obj.style.background='#efefef';
                obj.style.color='#444';
                $('#ed_'+id).val("");
                $('#ed_'+id).css('background','#efefef');
                $('#ed_'+id).css('color','#444');
                $('#ed_'+id).removeAttr('modificado', 0);
                obj.removeAttribute('modificado');
            }
        }

        function calcularEdad(fecha) {
            var hoy = new Date();
            var cumpleanos = new Date(fecha);
            var edad = hoy.getFullYear() - cumpleanos.getFullYear();
            var m = hoy.getMonth() - cumpleanos.getMonth();
        
            if (m < 0 || (m === 0 && hoy.getDate() < cumpleanos.getDate())) {
                edad--;
            }
        
            return edad;
        }

        //{{-- Cambair estado online --}}
        function cambiar_estado_online(id,estado, donde, modal){
            if(donde=='modal'){
                id_reporte = $('#modal_id_reporte').val();
                $.ajax({
                    type:'POST',
                    url:'/public/cambiar_estado_online',
                    data:{
                        id_reporte: id_reporte,
                        estado: estado
                    },
                    success: function(response){}
                });
                $('#'+modal).modal('hide');
                window.removeEventListener("beforeunload", preventF5, false);
            }else if (donde == 'vista'){
                $.ajax({
                    type:'POST',
                    url:'/public/cambiar_estado_online',
                    data:{
                        id_reporte: id,
                        estado: estado
                    },
                    success: function(response){}
                });
            }

        }

        //{{-- Revisar Estado --}}
        function revisar_estado_online(){
            
            $.ajax({
                type:'POST',
                url:'/public/revisar_estado_online',
                data:{
                    adip: 'adip'
                },
                success: function(response){
                    if(response.status == 100){
                        datos = response.response;
                        //console.log(datos);
                        for(i= 0; i < datos.length; i++){
                            if(datos[i].disponibilidad == 0){
                                $('#d_'+datos[i].id_reporte).removeClass('disponible');
                                $('#d_'+datos[i].id_reporte).addClass('ocupado');
                                $('#c_'+datos[i].id_reporte).prop('disabled', true);
                                $('#b_'+datos[i].id_reporte).attr("onclick", 'alertaOcupado('+datos[i].id_reporte+')');
                                $('#b_'+datos[i].id_reporte).css("background", "#F1C40F !important");
                                $('#f_'+datos[i].id_reporte).html('<i class="fas fa-lock" style="margin-right: 7%;color:#F1C40F; font-size: 2em; text-align:left; margin-left:3%;"></i> Status');
                                $('#i_'+datos[i].id_reporte).text('Ocupado');
                            }else{
                                $('#d_'+datos[i].id_reporte).removeClass('ocupado');
                                $('#d_'+datos[i].id_reporte).addClass('disponible');
                                $('#c_'+datos[i].id_reporte).prop('disabled', false);
                                $('#b_'+datos[i].id_reporte).attr("onclick", 'vista_Excel_Modal('+datos[i].id_reporte+')');
                                $('#f_'+datos[i].id_reporte).html('<i class="fas fa-lock-open" style="margin-right: 7%;color:#28B463; font-size: 2em; text-align:left; margin-left:3%;"></i> Status');
                                $('#i_'+datos[i].id_reporte).text('Disponible');
                            }
                        }
                    }
                }
            });

        }

        //{{--  Fusionar reportes  --}}
        function fusionar_reporte(){
            array_fusion = [];

            $('.check_adip').each(function(){
                if($(this).is(':checked') ){
                    array_fusion.push($(this).attr('id').replace('c_', ''));
                }else{
                }
            });

            console.log(array_fusion);
        }

        //{{--  Menu contextual  --}}
        function ver_infoAdip(id){
            $.ajax({
                type:'POST',
                url:'/public/ver_infoAdip',
                data:{
                    id_reporte : id,
                },
                success: function(response){
                    if(response.status == 100){

                        datos = response.response;
                        console.log('datos', datos);
                        var i_rango_fecha = datos[0].fecha_inicio.substring(0,10) +' a '+ datos[0].fecha_final.substring(0,10);
                        array_versiones.push(JSON.parse(datos[0].historial_version));

                        $('#title_reporte').html('Informacion del documento '+id);
                        $('#i_id_reporte').html(id);
                        $('#i_rango_fecha').html(i_rango_fecha);
                        if(datos[0].version > 1){
                            $('#i_version').html(datos[0].version + `<i onclick="ver_versiones(1, ${datos[0].version},${id})" class="far fa-arrow-alt-circle-right" style="font-size:1.3em; position:absolute; right:6%; cursor:pointer;"></i>`);
                        }else{
                            $('#i_version').html(datos[0].version);
                        }
                        $('#i_registros').html((datos[0].total_registros_procesados) - 1 );
                        $('#i_creacion').html(datos[0].creacion);
                        $('#i_modificacion').html(datos[0].modificacion);
                        if(datos[0].ultimo_usuario === null){datos[0].ultimo_usuario = 'No modificado';}
                        if(datos[0].version > 1){
                            $('#i_ultimo_user').html(datos[0].ultimo_usuario.toUpperCase() + `<i onclick="ver_historial(1, ${datos[0].version}, ${id})" class="far fa-arrow-alt-circle-right" style="font-size:1.3em; position:absolute; right:6%; cursor:pointer;"></i>`);
                        }else{
                            $('#i_ultimo_user').html(datos[0].ultimo_usuario.toUpperCase() );
                        }
                        $('#id_reporte_xlsx').val(id);

                        $('#datos_documento_xlsx tbody').append(`
                            <tr id="tr_${id}">
                                <td scope="row" style="text-transform: uppercase; font-weight:bold;" id="f_${id}"><i class="fas fa-lock-open" style="margin-right: 7%;color:#28B463; font-size: 2em; text-align:left; margin-left:3%;"></i> Status</td>
                                <td id="i_${id}" style="text-align: center;">Disponible</td>
                            </tr>`
                        );
                        $('#modalInfoDocumento').modal('show');
                    }else{
                        $mensaje = response.response;
                        modal_error($mensaje, '');
                    }

                }
            });
        }

        //{{--  Ver historial de versiones  --}}
        function ver_versiones(accion, version,id){
            console.log(array_versiones);
            if(accion == 1){
                $('#infoReporte_v').css('display', 'none');
                $('#modal_versiones').css({display:'inline-block', width:'100%'});
                var ver = '<div style="position:relative; height:23px;"><i onclick="ver_versiones(2,0,0)" class="far fa-arrow-alt-circle-left" style="font-size:1.3em; position:absolute; left:1%; cursor:pointer;"></i></div>';
                
                for(i = 1; i <= version ; i++){
                    for(j = 0; j < array_versiones[0].length; j++){
                        if(array_versiones[0][j].version == i){
                            ver += `<div class="vers" onclick="descargar_csv(${id}, ${version})">
                                <i class="fas fa-code-branch" style="margin-right: 7%; font-size: 2em; text-align:left; margin-left:3%; margin-top:15%; margin-bottom:9%; "></i>
                                Version ${i}
                                <p style="font-size:0.8em">${array_versiones[0][j].fecha_m}</p>
                            </div>`;
                        }else{
                            /*
                            ver += `<div class="vers" onclick="descargar_csv(${id}, ${version})">
                                <i class="fas fa-code-branch" style="margin-right: 7%; font-size: 2em; text-align:left; margin-left:3%; margin-top:15%; margin-bottom:9%; "></i>
                                Version ${i}
                                <p style="font-size:0.8em">Sin fecha</p>
                            </div>`;
                            */
                        }
                    }
                }

                $('#modal_versiones').html(ver);
            }else if(accion == 2){ 
                $('#modal_versiones').html('');
                $('#modal_versiones').css({display:'none'});
                $('#infoReporte_v').css('display', 'block');
            }
        }

        //{{--  Ver historial de modificaciones  --}}
        function ver_historial(accion, version, id){
            if(accion == 1){
                $('#infoReporte_v').css('display', 'none');
                $('#modal_historial').css({display:'block', width:'100%'});
                var ver = '<div style="position:relative; height:23px;"><i onclick="ver_historial(2,0,0)" class="far fa-arrow-alt-circle-left" style="font-size:1.3em; position:absolute; left:1%; cursor:pointer;"></i></div>';
                    ver += '<div style="width:100%; text-align:center;font-size: 1.2em; border-bottom: 1px solid #ccc; padding-bottom: 4px; margin-bottom: 13px;">Historial de Modificaciones del reporte '+id+'</div>';
                    ver += `<div class="table-responsive mt-2">
                                <table class="table" style="text-align:center;">
                                    <thead>
                                        <th>Usuario</th>
                                        <th>Nombre Completo</th>
                                        <th>Fecha de modificacion</th>
                                        <th>Version de reporte</th>
                                        <th>Reporte</th>
                                    </thead>
                                    <tbody>`;

                                    for(i = 1; i <= version ; i++){
                                        for(j = 0; j < array_versiones[0].length; j++){
                                            if(array_versiones[0][j].version == i){
                                                ver +=  `<tr>
                                                    <td>${array_versiones[0][j].usuario_nombre}</td>
                                                    <td>${array_versiones[0][j].usuario_nombre_completo}</td>
                                                    <td>${array_versiones[0][j].fecha_m}</td>
                                                    <td>${array_versiones[0][j].version}</td>
                                                    <td>${id}</td>
                                                </tr>`;
                                            }else{
                                                /*
                                                ver +=  `<tr>
                                                    <td>Sin registro</td>
                                                    <td>Sin registro</td>
                                                    <td>Sin registro</td>
                                                    <td>${i}</td>
                                                    <td>${id}</td>
                                                </tr>`;
                                                */
                                            }

                                        }
                                    }

                    ver +=         `</tbody>
                                </table>
                            </div>`;
                
                $('#modal_historial').html(ver);
            }else if(accion == 2){ 
                $('#modal_historial').html('');
                $('#modal_historial').css({display:'none'});
                $('#infoReporte_v').css('display', 'block');
            }
        }

        //{{--  Activar el scroll horizontal  --}}
        function hScroll (amount) {
            amount = amount || 120;
            $('#table-resposive').bind("DOMMouseScroll mousewheel", function (event) {
                var oEvent = event.originalEvent, 
                    direction = oEvent.detail ? oEvent.detail * -amount : oEvent.wheelDelta, 
                    position = $(this).scrollLeft();
                position += direction > 0 ? -amount : amount;
                $('#table-resposive').scrollLeft(position);
                event.preventDefault();
            })
        }

        //{{--  Dias de edicion correspondientes al bloque  --}}
        function dias_edicion(cve_unidad){
            console.log('clave_edicion',cve_unidad);
            $.ajax({
                type:'POST',
                url:'/public/dias_edicion',
                data:{
                    unidad : cve_unidad
                },
                success: function(response){

                    if(response.status == 100){
                        datos = response.rango;
                        proximo_lunes = response.proximo_lunes;
                        fechas_adip = response.fechas;

                        //##### Calculo de la fecha de cierre para habilitar el boton de fusion
                        let f = new Date();
                        let fecha_hoy = f.getFullYear()+"-"+( f.getMonth() + 1 )+"-"+ f.getDate();
                        let ff = new Date(datos.substring(0,10));
                        let fecha_fin_b_ante = ff.getFullYear()+"-"+( ff.getMonth() + 1 )+"-"+ (ff.getDate() + 1);
                        
                        if(fecha_hoy == fecha_fin_b_ante){
                            fecha_fina_bloque_pasado = new Date(ff.getFullYear(), ff.getMonth(), (ff.getDate() + 1), 15,0,0);
                            console.log('fecha_fina_bloque_pasado dias edicion',fecha_fina_bloque_pasado)
                        }

                        //console.log('Datos',datos);
                        $('#titulo_reporte_adip').html('REPORTE ADIP <b>'+datos+'</b>');
                        //Carga de los dias.
                        $('#fechas_adip').html(fechas_adip);

                        var un = unidadEnnumero(cve_unidad);
                        $('#numero_unidad').html(un);

                        countDownDate = new Date(proximo_lunes).getTime();
                    }
                }
            });
        }

        //{{--  Descarga los csv de las versiones  --}}
        function descargar_csv(id_reporte, version){

            setTimeout(function(){
                $('#modal_loading').modal('hide');
            }, 1000);

            var idReporte=id_reporte;
            var tipo="csv";

            $.ajax({
                type:'GET',
                url:'/public/obtener_reportes_csv/'+ idReporte +"/"+version+'/'+ tipo ,
                data:{},
                success:function(response) {
                    if(response.status==100){
                        var win = window.open(response.response, '_blank');
                    }
                }
            });
        }

        //{{--  Tiempo restante para finalizar el bloque  --}}
        var x = setInterval(function() {
        
            
            var now = new Date().getTime();
            var distance = countDownDate - now;
            
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            $('#cuentaRegresiva').html( 'Faltan '+ days + "d " + hours + "h " + minutes + "m " + seconds + "s. Para cerrar bloque.");
                
            if (distance < 0) {
                clearInterval(x);
                $('#cuentaRegresiva').html ( "Bloque cerrado");

                var fecha = new Date();
                var tomorrow = (fecha.getDate() + 1) + '/' + (fecha.getMonth() + 1) + '/' + (fecha.getFullYear());

                // se ejecuta el metodo para unir los csv
                var fin_bloque = `<li style="width: 100%;margin: 0 auto; height: auto;">
                                    <div style="width:100%;"><i class="fas fa-calendar" style="font-size: 4em;"></i></div>
                                    <div style="width:100%; margin: 2% 0; font-weight:bold;">EL bloque anterior ha finalizado, el siguiente bloque se generara el dia de mañana ${tomorrow}.</div>  
                                </li>`;
                $('#fechas_adip').html(fin_bloque);
            }
        }, 1000);

        function novincular(obj){
            if($(obj).is(':checked')){
                $(obj).prevAll('.fecha_vinculacion_proceso_input_auto').val($(obj).val());
                $(obj).prevAll('.fecha_vinculacion_proceso_input_auto').attr('modificado', '0');
                $(obj).prevAll('.fecha_vinculacion_proceso_input_auto').css('background','#848F33');
                $(obj).prevAll('.fecha_vinculacion_proceso_input_auto').css('color','#fff');
            }else{   
                $(obj).prevAll('.fecha_vinculacion_proceso_input_auto').val('');
                $(obj).prevAll('.fecha_vinculacion_proceso_input_auto').removeAttr('modificado');
                $(obj).prevAll('.fecha_vinculacion_proceso_input_auto').css('background','#efefef');
                $(obj).prevAll('.fecha_vinculacion_proceso_input_auto').css('color','#444');
            }
        }

        function unidadEnnumero(valor){
            var un = '';
            switch(valor){
                case '001': 
                    un = '1';
                break;
                case '002': 
                    un = '2';
                break;
                case '003': 
                    un = '3';
                break;
                case '004': 
                    un = '4';
                break;
                case '005': 
                    un = '5';
                break;
                case '006': 
                    un = '6';
                break;
                case '007': 
                    un = '7';
                break;
                case '008': 
                    un = '8';
                break;
                case '009': 
                    un = '9';
                break;
                case '010': 
                    un = '10';
                break;
                case '011': 
                    un = '11';
                break;
                case '012': 
                    un = '12';
                break;
                default: 
                    un ='1';
                break;
            }
            return un;
        }

        function cambiarHorario(id_unidad){
            var hora = $('#u_'+id_unidad).val(); 

            if(id_unidad.length < 1){
                modal_error('Error al Actualizar el horario de la unidad');
            }else{
                $.ajax({
                    type:'POST',
                    url:'/public/cambiarHorarioAdip',
                    data:{
                        id_unidad: id_unidad,
                        hora:hora,
                    },
                    success:function(response) {
                        console.log(response);
            
                        if(response.status == 100){
                            modal_success(response.response);
                        }else{
                            modal_error(response.response);
                        }
                    }
                });
            }
        }

        function desbloquearReporte(input){
            var id_reporte = $(input).val();

            if(id_reporte.length < 1){
                modal_error('Error al desbloquear el reporte. ingrese un id valido');
            }else{
                $.ajax({
                    type:'POST',
                    url:'/public/cambiar_estado_online',
                    data:{
                        id_reporte: id_reporte,
                        estado: 1
                    },
                    success: function(response){
                        console.log(response);

                        if(response.status == 100){
                            $(input).val('');
                            modal_success('Reporte '+id_reporte+' fue desbloqueado satisfactoriamente');
                        }else{
                            modal_error('Lo sentimos ocurrio un problema al intentar desbloquear el reporte '+id_reporte);
                        }
                    }
                });
            }
        }

        function habilitarBotonFusinar(){
            if(fecha_fina_bloque_pasado == '') return false;
            let fecha_fin = fecha_fina_bloque_pasado;
            let fecha_fin_mas_tarde = new Date(fecha_fin.getFullYear(), fecha_fin.getMonth(), fecha_fin.getDate(), 16,0,0);
            let fecha_hoy = new Date();
            //let fecha_hoy = new Date(2022,2,4,15,30,0);

            //console.log('fecha_fin', fecha_fin);
            //console.log('fecha_hoy', fecha_hoy);
            //console.log('fecha_fin_mas_tarde', fecha_fin_mas_tarde);

            if(fecha_hoy.getTime() >= fecha_fin.getTime()  && fecha_hoy.getTime() <= fecha_fin_mas_tarde.getTime()) $('#fusionarButton').prop('disabled',false);
            else console.log('No coincide el get time');
            
        }

        function fusionarReporte(){
            $.ajax({
                type:'POST',
                url:'/public/fusionarReporte',
                data:{
                },
                success: function(response){
                    console.log(response);

                    if(response.status == 100){
                        $('#MasterButton').prop('disabled', false);
                        modal_success(response.response);
                    }else{
                        modal_error(response.response);
                    }
                }
            });
        }

        function generarReporteMaster(){
            $.ajax({
                type:'POST',
                url:'/public/generarReporteMaster',
                data:{
                },
                success: function(response){
                    console.log(response);

                    if(response.status == 100){
                        modal_success(response.message);
                    }else{
                        modal_error(response.message);
                    }
                }
            });
        }


        /*
        {{-- Hace las celdas editables --}}
        {{-- const createdCell = function(cell) {
            let original;

            if(cell.textContent.length > 0){

            }else{
                cell.setAttribute('contenteditable', true)
                cell.setAttribute('spellcheck', false)
                cell.addEventListener("focus", function(e) {
                    original = e.target.textContent
                })
                cell.addEventListener("blur", function(e) {
                    if (original !== e.target.textContent) {
                        const row = table.row(e.target.parentElement)
                        row.invalidate()
                        console.log('Row changed: ', row.data())
                    }
                })
            }
        } --}}
        */
        /*
        function seleccionCampoAud(obj, cj, tag){
            if(obj.value.length > 0){
                $(tag).html('');

                $.ajax({
                    type:'POST',
                    url:'/public/obtener_audiencias',
                    data:{
                        folio_carpeta: cj
                    },
                    success: function(response){
                        var dat = response.response;
                        var option = '<option disabled selected>Seleccione</option>';
                        for(i = 0; i< dat.length; i++ ){
                            option +='<option value="'+dat[i].idaudiencia+'">'+dat[i].audiencia+'</option>';
                        }
                        $(tag).append(option);
                    }
                });
                obj.style.background='#848F33';
                obj.style.color='#fff';
            }else{
                $(tag).style.background='#efefef';
                $(tag).style.color='#444';
                obj.style.background='#efefef';
                obj.style.color='#444';
                $(tag).html('<option disabled selected>Seleccione</option>');
            }
        }
        */
        

    </script>
@endsection

@section('seccion-modales')

    <!-- Modal flujo -->
    <div class="modal fade" id="modal_flujo" role="dialog">
        <div class="modal-dialog" style="width:550px;">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title">Flujo del Acuerdo</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body" id="modal_flujo_contenido">
                </div>
                <div class="modal-footer">
                <button type="button" onclick="cerrar_modal('modal_flujo')" class="btn btn-primary">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

    <div id="modalAdjuntarDocumento" class="modal fade">
        <div class="modal-dialog modal-lg mg-b-100" role="document" style="width: -webkit-fill-available;">
            <div class="modal-content tx-size-sm">
                <div class="modal-header pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"><span id="titleSujeto">Documento del acuerdo</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body pd-20">

                    <iframe src="" id="documentoPDFrame"></iframe>

                </div><!-- modal-body -->
                <div class="modal-footer d-flex">
                <button type="button" class="btn btn-secondary d-inline-block mg-l-auto"  style="margin-left: auto;" data-dismiss="modal">Cerrar</button>
           </div>
            </div>
        </div><!-- modal-dialog -->
    </div><!-- modal -->

    <div id="vista_Excel_Modal" class="modal fade" data-backdrop="static" data-keyboard="false" >
        <div class="modal-dialog modal-lg mg-b-100" role="document" style="width: -webkit-fill-available; max-width: 1350px!important;">
            <div class="modal-content tx-size-sm">
                <div class="modal-header pd-x-20" style="background:#848F33 !important; color:#fff !important;">
                <h5 class="modal-title" >Editar Excel - Reporte ADIP</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="cerrar_modal('vista_Excel_Modal')">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body pd-x-20 pd-t-0 pd-b-0">
                    <input type="hidden" id="version_CSV">
                    <input type="hidden" id="nombre_CSV">
                    <input type="hidden" id="id_report">
                    <div class="col-md-12 d-flex justify-content-center">
                        <input type="text" id="sarchItem" placeholder="Buscar registros">
                    </div>
                    <div class="table-responsive" id="table-resposive">
                        <table class="table" id="table_vista_Excel_Modal">
                            <thead>
                                <tr id="encabezado_personalizado">
                                    <th scope="col">N°</th>
                                    <th scope="col">Expediente Digital</th>
                                    <th scope="col">Carpeta Investigación</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Apellido Paterno</th>
                                    <th scope="col">Apellido Materno</th>
                                    <th scope="col">Fecha Nacimiento</th>
                                    <th scope="col">Domicilio</th>
                                    <th scope="col">Sexo</th>
                                    <th scope="col">Edad</th>
                                    <th scope="col">Ingreso</th>
                                    <th scope="col">Estatus del Imputado</th>
                                    <th scope="col">Estatus de Reincidencia</th>
                                    <th scope="col">Fecha vinculación proceso</th>
                                    <th scope="col">Fecha sentencia</th>
                                    <th scope="col">Fecha Apelación</th>
                                    <th scope="col">Estatus de la multa posterior a la apelación</th>
                                    <th scope="col">Pena pecuniaria posterior a la apelación</th>
                                    <th scope="col">Fecha Amparo</th>
                                    <th scope="col">Fecha Sobreseimiento</th>
                                    <th scope="col">Tipo de Juicio</th>
                                    <th scope="col">Tiempo de Sentencia</th>
                                    <th scope="col">Estatus de la multa posterior a la sentencia</th>
                                    <th scope="col">Pena pecuniaria de Sentencia</th>
                                    <th scope="col">Estatus Proceso</th>
                                    <th scope="col">Persona</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div><!-- modal-body -->
                <div class="modal-footer d-flex" id="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="cerrar_modal('vista_Excel_Modal')">Cerrar</button>
                    <button type="button" class="btn btn-secondary " onclick="guardar_json_local()" style="background:#848F33 !important; color:#fff;"  id="btn_guardarExcel">Guardar</button>
                </div>
            </div>
        </div><!-- modal-dialog -->
    </div><!-- modal -->

    <div id="modalInfoDocumento" class="modal fade" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg mg-b-100" role="document" style="width: -webkit-fill-available;">
            <div class="modal-content tx-size-sm">
                <div class="modal-header pd-x-20" style="background:#848F33 !important; color:#fff !important;">
                    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"><span id="title_reporte" style="color:#fff !important;">-</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="cerrar_modal('modalInfoDocumento')">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pd-20" id="modal_infoDoc">
                    <input type="hidden" id="id_reporte_xlsx">
                    <div class="table-responsive" id="infoReporte_v">
                        <table class="table" id="datos_documento_xlsx">
                              <tbody>
                                <tr>
                                    <td scope="row" style="text-transform: uppercase; font-weight:bold;"><i class="fas fa-table" style="margin-right: 7%; font-size: 2em; text-align:left; margin-left:3%;"></i> Reporte</td>
                                    <td id="i_id_reporte" style="text-align: center;"></td>
                                </tr>
                                <tr>
                                  <td scope="row" style="text-transform: uppercase; font-weight:bold;"><i class="fas fa-calendar-week" style="margin-right: 7%; font-size: 2em; text-align:left; margin-left:3%;"></i> Rango de Fechas</td>
                                  <td id="i_rango_fecha" style="text-align: center;"></td>
                                </tr>
                                <tr>
                                    <td scope="row" style="text-transform: uppercase; font-weight:bold;"><i class="fas fa-code-branch" style="margin-right: 7%; font-size: 2em; text-align:left; margin-left:3%;"></i> version</td>
                                  <td id="i_version" style="text-align: center;"></td>
                                </tr>
                                <tr>
                                    <td scope="row" style="text-transform: uppercase; font-weight:bold;"><i class="fas fa-database" style="margin-right: 7%; font-size: 2em; text-align:left; margin-left:3%;"></i> Registros</td>
                                    <td id="i_registros" style="text-align: center;"></td>
                                </tr>
                                <tr>
                                    <td scope="row" style="text-transform: uppercase; font-weight:bold;"><i class="fas fa-calendar-check" style="margin-right: 7%; font-size: 2em; text-align:left; margin-left:3%;"></i> Fecha Creacion</td>
                                  <td id="i_creacion" style="text-align: center;"></td>
                                </tr>
                                <tr>
                                    <td scope="row" style="text-transform: uppercase; font-weight:bold;"><i class="fas fa-clock" style="margin-right: 7%; font-size: 2em; text-align:left; margin-left:3%;"></i> Modificacion</td>
                                    <td id="i_modificacion" style="text-align: center;"></td>
                                </tr>
                                <tr>
                                    <td scope="row" style="text-transform: uppercase; font-weight:bold;"><i class="fas fa-user" style="margin-right: 7%; font-size: 2em; text-align:left; margin-left:3%;"></i> Ultimo usuario</td>
                                    <td id="i_ultimo_user" style="text-align: center;"></td>
                                </tr>
                              </tbody>
                        </table>
                    </div>
                    <div id="modal_versiones" style="display: none;">
                    </div>
                    <div id="modal_historial" style="display: none;">
                    </div>
                    
                </div>
                <div class="modal-footer d-flex">
                    <button type="button" class="btn btn-secondary d-inline-block mg-l-auto"  style="margin-left: auto;" data-dismiss="modal" onclick="cerrar_modal('modalInfoDocumento')">Cerrar</button>
                </div>
            </div>
        </div><!-- modal-dialog -->
    </div><!-- modal -->

    <div id="modalError" class="modal fade">
        <div class="modal-dialog" role="document">
          <div class="modal-content tx-size-sm">
            <div class="modal-body tx-center pd-y-20 pd-x-20">
              <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button> -->
              <i class="icon icon ion-ios-close-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
              <h4 class="tx-danger mg-b-20">Datos incompletos</h4>
              <p class="mg-b-20 mg-x-20" id="messageError"></p>
              <button type="button" class="btn btn-danger pd-x-25 cerrar-modal" data-modal="" data-thismodal="modalError" id="btnCerrarError">Aceptar</button>
            </div><!-- modal-body -->
          </div><!-- modal-content -->
        </div><!-- modal-dialog -->
    </div><!-- modal -->
    
    <div id="modalSuccess" class="modal fade"  data-backdrop="static" data-keyboard="false" >
        <div class="modal-dialog" role="document">
          <div class="modal-content tx-size-sm">
            <div class="modal-body tx-center pd-y-20 pd-x-20">
              <i class="icon ion-ios-checkmark-outline tx-100 tx-success lh-1 mg-t-20 d-inline-block"></i>
              <h6 class="tx-success tx-semibold mg-b-20">Hecho!</h6>
              <p style="padding-left: 5vh; padding-right: 5vh;" id="modal-success-titulo">Titulo Modal Success</p>
            </div><!-- modal-body -->
            <div class="modal-footer d-flex">
              <button type="button" class="btn btn-primary pd-x-25 mg-l-auto cerrar-modal" data-modal="" data-thismodal="modalSuccess" id="btnCerrarSuccess">Aceptar</button>
            </div>
          </div><!-- modal-content -->
        </div><!-- modal-dialog -->
    </div><!-- modal -->

    <div id="modalWarning" class="modal fade"  data-backdrop="static" data-keyboard="false" >
        <div class="modal-dialog" role="document">
          <div class="modal-content tx-size-sm">
            <div class="modal-body tx-center pd-y-20 pd-x-20">
                <i class="fas fa-exclamation-triangle tx-100 tx-warning lh-1 mg-y-20 d-inline-block"></i>
              <h6 class="tx-warning tx-semibold mg-b-20">Lo sentimos!</h6>
              <p style="padding-left: 5vh; padding-right: 5vh;" id="modal-warning-titulo">Titulo Modal Success</p>
            </div><!-- modal-body -->
            <div class="modal-footer d-flex">
              <button type="button" class="btn btn-primary pd-x-25 mg-l-auto cerrar-modal" data-modal="" data-thismodal="modalWarning" id="btnCerrarSuccess">Aceptar</button>
            </div>
          </div><!-- modal-content -->
        </div><!-- modal-dialog -->
    </div><!-- modal -->

    <div id="modalCerrarEdicion" class="modal fade"  data-backdrop="static" data-keyboard="false" >
        <div class="modal-dialog" role="document">
          <div class="modal-content tx-size-sm">
            <div class="modal-body tx-center pd-y-20 pd-x-20">
                <input type="hidden" id="modal_id_reporte">
                <i class="fas fa-exclamation-triangle tx-100 tx-warning lh-1 mg-y-20 d-inline-block"></i>
              <h6 class="tx-warning tx-semibold mg-b-20">Deseas salir sin guardar Cambios?</h6>
              <p style="padding-left: 5vh; padding-right: 5vh;" id="modal-cerrarEdicion-titulo"></p>
            </div><!-- modal-body -->
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn btn-default pd-x-25 cerrar-modal" data-modal=""  onclick="cerrar_modal_1('modalCerrarEdicion','vista_Excel_Modal')">Cancelar</button>
              <button type="button" class="btn btn-primary pd-x-25 cerrar-modal" data-modal=""  onclick="cambiar_estado_online('',1,'modal','modalCerrarEdicion')">Aceptar</button>
            </div>
          </div><!-- modal-content -->
        </div><!-- modal-dialog -->
    </div><!-- modal -->

@endsection
