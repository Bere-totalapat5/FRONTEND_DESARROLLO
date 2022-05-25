@php
  use App\Http\Controllers\clases\humanRelativeDate;
  use App\Http\Controllers\clases\utilidades;
  $humanRelativeDate = new humanRelativeDate();
@endphp

@extends('layouts.index')

@section('contenido-pageheader')
  <ol class="breadcrumb slim-breadcrumb">
    <li class="breadcrumb-item"><a href="#">Solicitudes</a></li>
    <li class="breadcrumb-item"><a href="#"> Registro de solicitudes iniciales (Tribunal de Enjuiciamiento / Ejecución)</a></li>
  </ol>

  <h6 class="slim-pagetitle"> Registro de solicitudes iniciales (Tribunal de Enjuiciamiento / Ejecución)</h6>

@endsection

@section('contenido-principal')

    <div class="section-wrapper" style="max-width: 100%;">
      @if(!utilidades::buscarPermisoMenu($request->menu_general['response'], 61, 0))
        <h1 class="mg-b-50">No tiene permiso para acceder a esta sección, verifíquelo con su titular</h1>
        <a href="/home"><button class="btn btn-primary btn-block">Regresar al inicio</button><a>
      @else
        <div class="form-layout">

            <div class="d-flex justify-content-between">
                <a style="border:1px solid #ccc; width: 60px;  display:flex; text-align:center; align-items:center; text-align: center;" data-toggle="collapse" data-parent="#accordion" href="#collapseSearchAdvance" aria-expanded="false" aria-controls="collapseSearchAdvance" class="btn btn-default" >
                    <i class="fa fa-search" aria-hidden="true"></i>
                    <i class="fas fa-chevron-down" style="margin-left: 5%; font-size:0.7em;"></i> 
                </a>
                <div class="row justify-content-end" style="width:80%;">
                  <input type="hidden" id="filtro_consulta" name="filtro_consulta" value="">
                  <div class="col-sm-4 col-md-3 col-lg-3 pd-t-10" aling="right">
                      <a href="javascript:void(0);" onclick="nuevaSolicitud()" class="btn btn-primary btn-sm btn-block "><i class="fa fa-pdf mg-r-5"></i>Nueva Solicitud</a>
                  </div> 
                  {{-- <div class="col-sm-4 col-md-3 col-lg-2 pd-t-10" aling="right">
                      <a href="javascript:void(0);" onclick="" class="btn btn-primary btn-sm btn-block "><i class="fa fa-pdf mg-r-5"></i>Exportar Excel</a>
                  </div> --}}
                </div>
            </div>


            <div id="accordion" class="accordion-one mg-b-15" role="tablist" aria-multiselectable="true">
                <div class="card">
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
        </div>


        <div id="table-solicitudes" class="mg-b-20">
          <table id="solicitudesTable" class="display dataTable dtr-inline collapsed d-block" style="text-align:center; overflow-x: auto; padding-left:0; padding-rigth:0" role="grid" aria-describedby="example_info">
              <thead style="background-color: #EBEEF1; color: #000; text-align:center">
                  <tr>
                      <th style="min-width: 80px !important;"                   name="acciones">Acciones</th>
                      <th style="cursor:pointer; min-width: 120px !important;"  name="bandera_reporte">Folio de registro</th>
                      <th style="cursor:pointer; min-width: 150px !important;"  name="registros_procesados">Fecha de registro</th>
                      <th style="cursor:pointer; min-width: 190px !important;"  name="fecha_final">Carpeta Judicial de origen</th>
                      <th style="cursor:pointer; min-width: 130px !important;"  name="creacion">No. de expediente</th>
                      <th style="cursor:pointer; min-width: 190px !important;"  name="creacion">Carpeta Judicial asignada</th>
                      <th style="cursor:pointer; min-width: 200px !important;"  name="creacion">Unidad de Gestión asignada</th>
                      <th style="cursor:pointer; min-width: 200px !important;"  name="creacion">Situación registro</th>
                      <th style="cursor:pointer; min-width: 200px !important;"  name="creacion">Usuario Responsable</th>
                  </tr>
              </thead>
              <tbody id="body-table1" class="items-agregados" style="width: 100%; text-align: center;">
                <tr>
                  <td colspan="9">Sin datos relacionados</td>
                </tr>
              </tbody>
          </table>
        </div>


        <div class="pagination-wrapper justify-content-between">
            <ul class="pagination mg-b-0">
                <li class="page-item">
                    <a class="page-link" href="javascript:void(0);" onclick="sec_ajax('primera');" aria-label="Last">
                        <i class="fa fa-angle-double-left"></i>
                    </a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="javascript:void(0);" onclick="sec_ajax('atras');" aria-label="Next">
                        <i class="fa fa-angle-left"></i>
                    </a>
                </li>
            </ul>
            <div id="texto_paginator">Página <span class="pagina_actual_texto">0</span> de <span
                    class="pagina_total_texto">0</span></div>
            <ul class="pagination mg-b-0">
                <li class="page-item">
                    <a class="page-link" href="javascript:void(0);" onclick="sec_ajax('avanzar');" aria-label="Next">
                        <i class="fa fa-angle-right"></i>
                    </a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="javascript:void(0);" onclick="sec_ajax('ultima');" aria-label="Last">
                        <i class="fa fa-angle-double-right"></i>
                    </a>
                </li>
            </ul>
        </div>

        <input type="hidden" id="pagina_actual" name="pagina_actual" value="1">
        <input type="hidden" id="paginas_totales" name="paginas_totales" value="1">
        <input type="hidden" id="numeropagina">
      @endif
    </div>

@endsection

@section('seccion-estilos')
        <link rel="stylesheet" type="text/css" href="{{asset("/css/dropzone.min.css")}}">
        <link href="{{asset("/lib/datatables/css/jquery.dataTables.css")}}" rel="stylesheet">
        <link rel="stylesheet" href="/js/clockpicker-gh-pages/src/clockpicker.css">
        
        <style>
            .cjon{
              width: 65%;
              display: flex;
              justify-content: center;
              flex-direction: column;
              border: 1px solid #ccc;
              margin:0 auto;
              padding: 4px;
            }
            .hRemi{
              display: flex;
              flex-wrap: wrap;
              justify-content: space-between;
              align-items: center;
              color: #fff;
              background: #848F33;
              padding: 10px;
            }

            .tx-total{
              color: #848F33;
            }
            /*Aspecto de boton file*/
            .file-select {
              position: relative;
              display: inline-block;
            }
            .file-select::before {
              background-color: #848F33;
              color: white;
              display: flex;
              justify-content: center;
              align-items: center;
              border-radius: 3px;
              content: 'Arrastre hasta aquí su documento o de clic para adjuntarlo';
              position: absolute;
              left: 0;
              right: 0;
              top: 0;
              bottom: 0;
              text-align: center;
              font-weight: bold;
            }
            .file-select input[type="file"] {
              opacity: 0;
              width: 100%;
              height: 65px;
              display: block;
              cursor: pointer;
            }
            .file-select:hover{
              background-color: #a8b167;
            }
            #TE_PDF::before {
              content: 'Arrastre hasta aquí su documento o de clic para adjuntarlo';
            }

            .form-check-input {
              margin-left: -1.80rem !important;
            }
            .modal-dialog-xxl{
              min-width: 60% !important;
              max-width: 60% !important;
            }
            @media(max-width:1024px){
              .modal-dialog-xxl{
                min-width: 90% !important;
                max-width: 60% !important;
              }
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
            span.select2-container.select2-container--default.select2-container--open{
               width:'100%';
            }
            .select2-container.select2-container--default.select2-container--open {
              z-index: 1050 !important;
            }
            .datepicker-container{
              z-index: 1110;
            }
            span.select2-container{
              width:'100%';
            }
		        .ui-datepicker.ui-widget.ui-widget-content.ui-helper-clearfix.ui-corner-all{
		        	z-index: 1050 !important;
		        }
            #solicitudesTable::-webkit-scrollbar {
                width: 8px;
                height: 8px;     
            }

            #solicitudesTable::-webkit-scrollbar-thumb {
                background: #ccc;
                border-radius: 4px;
            }

            #solicitudesTable::-webkit-scrollbar-thumb:hover {
                background: #b3b3b3;
                box-shadow: 0 0 2px 1px rgba(0, 0, 0, 0.2);
            }

            #solicitudesTable::-webkit-scrollbar-thumb:active {
                background-color: #999999;
            }

            #solicitudesTable::-webkit-scrollbar-track {
                background: #e1e1e1;
                border-radius: 4px;
            }
        
            #solicitudesTable::-webkit-scrollbar-track:hover,
            #solicitudesTable::-webkit-scrollbar-track:active {
              background: #d4d4d4;
            }
        </style>
@endsection

@section('seccion-scripts-libs')

     <script src="{{ $entorno["version_pages"]["version"] }}/lib/jquery-ui/js/jquery-ui.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/datatables/js/jquery.dataTables.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/datatables-responsive/js/dataTables.responsive.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/select2/js/select2.min.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/moment/js/moment.js"></script>
     <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
     <script src="/js/clockpicker-gh-pages/src/clockpicker.js"></script>
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
@endsection

@section('seccion-scripts-functions')

  <script>
    var tipo_user = @php echo json_encode($request->session()->get('id_tipo_usuario')); @endphp;
    var id_unidad_sesion= @php echo json_encode($request->session()->get('id_unidad_gestion')); @endphp;
    const calidad_juridica = @php echo json_encode($calidad_juridica);@endphp;
    const nacionalidades = @php echo json_encode($nacionalidades);@endphp;
    const estados = @php echo json_encode($estados);@endphp;
    const unidades = @php echo json_encode($unidades);@endphp;
    const inmuebles = @php echo json_encode($inmuebles);@endphp;
    const reclusorios = @php echo json_encode($reclusorios);@endphp;
    const tipo_defensor = [4,29,43,52];
    const expVacio=/^[\s]*$/;
    const expRFC=/^(([ÑA-Z|ña-z|&]{3}|[A-Z|a-z]{4})\d{2}((0[1-9]|1[012])(0[1-9]|1\d|2[0-8])|(0[13456789]|1[012])(29|30)|(0[13578]|1[02])31)(\w{2})([A|a|0-9]{1}))$|^(([ÑA-Z|ña-z|&]{3}|[A-Z|a-z]{4})([02468][048]|[13579][26])0229)(\w{2})([A|a|0-9]{1})$/;

    let carpeta_referida = {}
    personas_c = [],
    alias_parte = [],
    telefonos_persona = [],
    correos_persona = [];
    var solicitudes = [];

    var newDA=null;

    $(function(){

      'use strict';
      sec_ajax();

      setTimeout(function(){
          $('#modal_loading').modal('hide');
      }, 1000);

      $(".cerrar-modal").click(function(){
            let modalOpen = $(this).attr('data-modal');
            let modalClose = $(this).attr('data-thismodal');
            //console.log(modalOpen,modalClose);
            $("#"+modalClose).modal('hide');
            if( modalOpen.length ) setTimeout(function(){ $("#"+modalOpen).modal('show'); }, 500); 
      });

      $('.clockpicker').clockpicker({
        autoclose: true
      });

      // Select2
      $('.select2').select2();

      let fecha_actual = new Date();
      $('.fc-datepicker').datepicker({
        showOtherMonths: true,
        selectOtherMonths: true,
        dateFormat: 'yy-mm-dd',
        changeYear: true,
        yearRange: "c-100:" + fecha_actual.getFullYear()
      });
    

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

      console.log('inmuebles',inmuebles);
      console.log('unidades',unidades);
      console.log('reclusorios', reclusorios);
    });

    /*
    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
      console.log('Esto es un dispositivo móvil');
    }
    */

    //busqueda
    function sec_ajax(pagina_accion) {

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

            $.ajax({
                type:'GET',
                url:'/public/consultar_solicitudes_TEJEC',
                data:{
                    pagina: $('#numeropagina').val(),
                    registros_por_pagina:10,
                },
                success:function(response) {
                    console.log('solicitudes',response);

                    if(response.status==100){

                      var datos = response.response;
                      solicitudes = datos; 
                      var tr = '';

                      for(i in datos){
                        tr += 
                        `<tr>
                          <td>
                            <i onclick="ver_info(${i})" class="fas fa-info-circle" style="color: #fff; font-size: 1.1em; cursor: pointer; background: #848f33; border-radius: 4px; padding: 4px;"></i>
                            <i onclick="ver_doc(${i})" class="fas fa-file-pdf" style="color: #fff; font-size: 1.1em; cursor: pointer; background: #848f33; border-radius: 4px; padding: 4px;"></i>
                          </td>  
                          <td>${datos[i].folio}</td>
                          <td>${datos[i].creacion}</td>
                          <td>${datos[i].tipo_expediente == 'carpeta_judicial' ? datos[i].folio_carpeta_ref : ''}</td>
                          <td>${datos[i].tipo_expediente == 'juzgado_tradicional' ?  datos[i].carpeta_judicial_expediente:'' }</td>
                          <td>${datos[i].folio_carpeta_resul}</td>
                          <td>${datos[i].solicitud != null ? datos[i].solicitud[0].nombre_unidad : ''}</td>
                          <td>${datos[i].estatus_flujo}</td>
                          <td>${datos[i].nombre_usuario.length > 0 ? datos[i].nombre_usuario[0].usuario : '  '}</td>
                        </tr>`;
                      }

                      $('#body-table1').html(tr);
                      $('.pagina_total_texto').html(response.response_pag['paginas_totales']);
                      $('#paginas_totales').val(response.response_pag['paginas_totales'])
                    
                    }else {
                       body = "<tr><td colspan='12'><h3>Sin datos relacionados</h3></td><tr>";
                        $("#body-table1").html(body);

                        }
                }
            });

        }
    }

    //######## Nueva solicitud ################
    function nuevaSolicitud(){
      var optCalidad_j = '<option value="" seleted>Seleccionar</option>'; 
      for(i in calidad_juridica){
        optCalidad_j += `<option value="${calidad_juridica[i].id_calidad_juridica}">${calidad_juridica[i].calidad_juridica}</option>`;
      }

      var optInmuebles = '<option value="" seleted>Seleccionar</option>';
      for(i in inmuebles){
        let nombre_inmueble = '';

        if(inmuebles[i].id_inmueble == 7){
          nombre_inmueble = 'Tribunal de Enjuiciamiento en reclusorio Norte';
          optInmuebles += `<option value="${inmuebles[i].id_inmueble}">${nombre_inmueble}</option>`;
        }
        if(inmuebles[i].id_inmueble == 8){
          nombre_inmueble = 'Tribunal de Enjuiciamiento en reclusorio Oriente';
          optInmuebles += `<option value="${inmuebles[i].id_inmueble}">${nombre_inmueble}</option>`;
        }
        if(inmuebles[i].id_inmueble == 9){
          nombre_inmueble = 'Tribunal de Enjuiciamiento en reclusorio Sur';
          optInmuebles += `<option value="${inmuebles[i].id_inmueble}">${nombre_inmueble}</option>`;
        }
        if(inmuebles[i].id_inmueble == 4){
          nombre_inmueble = 'Tribunal de Enjuiciamiento en Sullivan';
          optInmuebles += `<option selected value="${inmuebles[i].id_inmueble}">${nombre_inmueble}</option>`;
        }
        /*
        if(inmuebles[i].id_inmueble == 7){
          nombre_inmueble = 'Tribunal de Enjuiciamiento en Unidad Especializada en Adolescentes';
        }
        */
      }

      var optUGEJEC = '<option value="" seleted>Seleccionar</option>';
      for(i in unidades){
        var unidades_ejec = [36,37,35,20]
        if(unidades_ejec.includes(unidades[i].id_unidad_gestion)){
          selected = '';
          if(unidades[i].id_unidad_gestion == 20){
            selected = 'selected';
          }
          optUGEJEC += `<option ${selected} value="${unidades[i].id_unidad_gestion}">${unidades[i].nombre_unidad}</option>`;
        }
      }

      var optUGJ = '<option value="" seleted>Seleccionar</option>';
      for(i in unidades){
        var unidades_ejec = [34]
        if(unidades_ejec.includes(unidades[i].id_unidad_gestion)){
          optUGJ += `<option ${selected} value="${unidades[i].id_unidad_gestion}">${unidades[i].nombre_unidad}</option>`;
        }
      }

      var optRECl = '<option value="" seleted>Seleccionar</option>';
      for(i in reclusorios){
        var reclu_ejec = [1,2,3,5,6,7,8,9,10,11,12,13,14]
        if(reclu_ejec.includes(reclusorios[i].id_reclusorio)){
          optRECl += `<option value="${reclusorios[i].id_reclusorio}">${reclusorios[i].nombre}</option>`;
        }
      }

      var html = `
        <div class="row">
          <div class="col-lg-12">
            <h4 class="form-control-label"> Registro de solicitud inicial </h4>
            <hr/>
          </div>
    
          <div class="col-lg-6">
            <div class="form-group">
              <label class="form-control-label tx-justify">Folio de registro: </label>
              <input class="form-control" type="text" name="folio_registro" id="folioRegistro" placeholder="En trámite" autocomplete="off" disabled>
            </div>
          </div>
    
          <div class="col-lg-6">
            <div class="form-group">
              <label class="form-control-label">Fecha de registro: </label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                      <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                  </div>
                </div>
                <input type="text" class="form-control" placeholder="En trámite" id="fechaRegistro"  name="fecha_registro" autocomplete="off" readonly>
              </div>
            </div>
          </div>
    
          <div class="col-lg-6">
            <div class="form-group">
              <label class="form-control-label">Fecha de Recepción: <span class="tx-danger">*</span></label>
              <div class="input-group">
                  <div class="input-group-prepend">
                      <div class="input-group-text">
                          <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                      </div>
                  </div>
                  <input type="text" class="form-control date" placeholder="DD-MM-AAAA" value="{{date('d-m-Y')}}" id="fechaRecepcion" name="fecha_recepcion" autocomplete="off" readonly="readonly">
              </div>
            </div>
          </div>
    
          <div class="col-lg-6">
            <div class="form-group">
              <label class="form-control-label">Hora de Recepción <small>(24hrs)</small>: <span class="tx-danger">*</span></label>
              <div class="d-flex">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <i class="fa fa-clock-o tx-16 lh-0 op-6"></i>
                    </div><!-- input-group-text -->
                  </div><!-- input-group-prepend -->
                  <input  type="text" class="form-control clockpicker" id="horaRecepcion" name="hora_recepcion" placeholder="hh:mm" value="{{date('H:i')}}" readonly="readonly">
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label">Carpeta judicial asignada:</label>
              <input class="form-control" type="text" name="carpeta_judicial" id="carpetaJudicial" value="" placeholder="En trámite" autocomplete="off" disabled>
            </div>
          </div>
    
          <div class="col-lg-6">
            <div class="form-group">
              <label class="form-control-label">Unidad de gestion asignada: </label>
              <input class="form-control" type="text" name="unidad_gestion" id="unidadGestion" value=""  placeholder="En trámite" autocomplete="off" disabled>
            </div>
          </div>
          
        </div>

        <div class="row mt-5">
          <div class="col-lg-12">
            <h6 class="form-control-label" style="color:#848f33;"> Datos del expediente origen </h6>
            <hr/>
          </div>

          <div class="col-lg-12">
            <div class="form-group" style="margin-bottom: 2px;" id="todasUnidades">
                <label class="form-control-label mg-t-20"><strong> Tipo de expediente a registrar: </strong><span class="tx-danger">*</span></label>
                <div class="d-inline-block mg-l-10">
                    <label class="rdiobox d-inline-block mg-l-5">
                      <input name="tExpedienteR" checked onchange="tExpediente(this);" type="radio" value="OptcarpetaJ">
                      <span class="pd-l-0">Carpeta Judicial de Unidad de Gestión </span>
                    </label>
                    <label class="rdiobox d-inline-block mg-l-5">
                      <input name="tExpedienteR"  onchange="tExpediente(this);" type="radio" value="OptExpJuzT">
                      <span class="pd-l-0">Expediente de Juzgado Tradicional </span>
                    </label>
                </div>
            </div>
          </div>

        </div>

        <div class="row mt-3">

          <div class="col-lg-4 d-block" id="divcarpetaReferida">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label">Carpeta Judicial: <span class="tx-danger">*</span></label>
              <input class="form-control" type="text" idCarpeta="" name="carpetaReferida" id="carpetaReferida" value="" placeholder="" autocomplete="off">
              <span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span>
              <ul class="list-group d-none" id="listaCarpetas" style="max-height: 150px; overflow-y: auto; position: absolute; border: 1px solid #EEE; border-top: 0; padding: 5px 5px; color: #6c757d; background-color: #fff; width: 88%; z-index: 1;">
              </ul>
            </div>
          </div>

          <div class="col-lg-4 d-none" id="divExpediente">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label">No. Expediente: <span class="tx-danger">*</span></label>
              <input class="form-control" type="text" name="noExpediente" id="noExpediente" placeholder="" autocomplete="off">
            </div>
          </div>

          <div class="col-lg-4">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label">UGJ / Juzgado emisor: <span class="tx-danger">*</span></label>
              <input class="form-control" type="text" disabled name="juzgadoEmisor" id="juzgadoEmisor" placeholder="En trámite" autocomplete="off">
            </div>
          </div>

          <div class="col-lg-4">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label">Tipo de solicitud recibida: <span class="tx-danger">*</span></label>
              <select class="form-control select2 " id="tipo_solicitud_recibida" onchange="otra(this)">
                <option value="" seleted>Seleccionar</option>
                <option value="accion_penal_privada">Acción Penal Privada</option>
                <option value="incompetencia">Incompetencia</option>
                <option value="otra">Otra</option>
              </select>
            </div>
          </div>

          <div class="col-lg-3 d-none" id="cmpOtro">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label">Otro: </label>
              <input class="form-control" type="text" name="otroCmp" id="otroCmp" value="" placeholder="Otro" autocomplete="off">
            </div>
          </div>

        </div>

        
        <div class="row mt-5 d-none" id="OptExpJuzT">
          <div style="display:flex; justify-content: start; flex-wrap: wrap; padding-left:2%; padding-bottom:3px;">
            <div  class="chaa" onclick="nuevaParte()" style="margin-right: 1%; font-size: 0.8em; cursor:pointer; width: 104px; height:30px; background: #848f33; color:#fff; font-weight:bold; display:flex; justify-content:center; align-items:center;">
              <i class="fa fa-user"></i> + Agregar parte
            </div> 
            <div  class="chaa" id="agregarDelito" onclick="agregarDelito()" style="cursor:pointer; font-size: 0.8em; width: 104px; height:30px; background: #848f33; color:#fff; font-weight:bold; display:flex; justify-content:center; align-items:center;">
              <i class="fa fa-user"></i> + Agregar delito
            </div> 
          </div>
          <div class="col-lg-12">
            <div class="table-responsive">
              <table class="table" style="text-align:center;">
                <thead>
                  <tr>
                    <th>Acciones</th>
                    <th>Nombre Completo</th>
                    <th>Calidad</th>
                    <th>Delito/s</th>
                  </tr>
                </thead>
                <tbody id="personasAgregadasEXP">
                  <tr>
                    <td colspan="4" class="tx-danger">No ha agregado a ningúna Parte</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="row mt-5 justify-content-between d-flex" id="OptcarpetaJ">
          <div class="col-lg-5 cont_opt" style="display:block; justify-content:center; align-items:center;">
            <div class="form-group mg-b-10-force" style="width:100%;">
              <label class="form-control-label">Parte: <span class="tx-danger">*</span></label>
              <div class="d-flex">
                <select class="form-control select2" id="parte" name="parte" autocomplete="off">
                  <option selected disabled value="">Seleccionar</option>                            
                </select>
                <a href="javascript:void(0)" style="font-size: 26px; margin-left: 15px; color:#848f33;" onclick="agregarParte()">
                  <i class="fa fa-plus-circle d-inline-block" aria-hidden="true"></i>
                </a>
              </div>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="table-responsive">
              <table class="table" style="text-align:center;">
                <thead>
                  <tr>
                    <th>Acciones</th>
                    <th>Nombre Completo</th>
                    <th>Calidad</th>
                  </tr>
                </thead>
                <tbody id="personasAgregadasUGJ">
                  <tr>
                    <td colspan="4" class="tx-danger">No ha agregado a ningúna Parte</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="row mt-5" id="divExpedienteDestino">
          <div class="col-lg-12">
            <h6 class="form-control-label" style="color:#848f33;"> Datos del expediente destino </h6>
            <hr/>
          </div>

          <div class="col-lg-12">
            <div class="form-group" style="margin-bottom: 2px;" id="divMateriaDestino">
                <label class="form-control-label mg-t-20"><strong> Materia Destino: </strong><span class="tx-danger">*</span></label>
                <div class="d-inline-block mg-l-10">
                    <label class="rdiobox d-inline-block mg-l-5">
                      <input name="materia_destino" checked type="radio" value="OptPenalA" onchange="nuevosCampos(this)">
                      <span class="pd-l-0">Penal adultos</span>
                    </label>
                    <label class="rdiobox d-inline-block mg-l-5">
                      <input name="materia_destino"  type="radio" value="OptPAD" onchange="nuevosCampos(this)">
                      <span class="pd-l-0">Penal adolescentes</span>
                    </label>
                </div>
            </div>
          </div>

          <div class="col-lg-12">
            <div class="form-group" style="margin-bottom: 2px;" id="divTipoUnidadDestino">
                <label class="form-control-label mg-t-20"><strong> Tipo Unidad Destino: </strong><span class="tx-danger">*</span></label>
                <div class="d-inline-block mg-l-10">
                    <label class="rdiobox d-inline-block mg-l-5">
                      <input name="tipo_unidad_destino" checked type="radio" value="OptTE" onchange="tipo_unidad_destino(this)">
                      <span class="pd-l-0">Tribunal de Enjuiciamiento</span>
                    </label>
                    <label class="rdiobox d-inline-block mg-l-5">
                      <input name="tipo_unidad_destino"  type="radio" value="OptUE" onchange="tipo_unidad_destino(this)">
                      <span class="pd-l-0">Unidad de Ejecución</span>
                    </label>
                    <label class="rdiobox d-inline-block mg-l-5">
                      <input name="tipo_unidad_destino"  type="radio" value="OptUGJ" onchange="tipo_unidad_destino(this)">
                      <span class="pd-l-0">	Unidad de Gestión Judicial</span>
                    </label>
                </div>
            </div>
          </div>

          <div class="col-lg-12">
            <div class="form-group" style="margin-bottom: 2px;" id="divPrivadoLibertad">
                <label class="form-control-label mg-t-20"><strong> ¿El imputado se encuentra privado de su libertad? </strong><span class="tx-danger">*</span></label>
                <div class="d-inline-block mg-l-10">
                    <label class="rdiobox d-inline-block mg-l-5">
                      <input name="privado_libertad" type="radio" value="OptSi" onchange="privado_libertad(this)">
                      <span class="pd-l-0">Si</span>
                    </label>
                    <label class="rdiobox d-inline-block mg-l-5">
                      <input name="privado_libertad" checked type="radio" value="OptNo" onchange="privado_libertad(this)">
                      <span class="pd-l-0">No</span>
                    </label>
                </div>
            </div>
          </div>


          <div class="col-lg-12 d-none" id="divOptSi">
            <div class="form-group" style="margin-bottom: 2px;">
                <label class="form-control-label mg-t-20"><strong> Lugar de internamiento: </strong><span class="tx-danger">*</span></label>
                <select id="lugar_internamiento" class="form-control select2">
                  ${optRECl}
                </select>
            </div>
          </div>

          <div class="col-lg-12 d-block" id="divOptTE">
            <div class="form-group" style="margin-bottom: 2px;">
                <label class="form-control-label mg-t-20"><strong> Tribunal de Enjuiciamiento receptor: </strong><span class="tx-danger">*</span></label>
                <select id="TE_receptor" class="form-control select2">
                  ${optInmuebles}
                </select>
            </div>
          </div>

          <div class="col-lg-12 d-none" id="divOptUE">
            <div class="form-group" style="margin-bottom: 2px;">
                <label class="form-control-label mg-t-20"><strong> Unidad de Ejecución receptora: </strong><span class="tx-danger">*</span></label>
                <select id="UE_receptor" class="form-control select2">
                  ${optUGEJEC}
                </select>
            </div>
          </div>

          <div class="col-lg-12 d-none" id="divOptUGJ">
            <div class="form-group" style="margin-bottom: 2px;">
                <label class="form-control-label mg-t-20"><strong> Unidad de Gestión receptora: </strong><span class="tx-danger">*</span></label>
                <select id="UGJ_receptor" class="form-control select2">
                  ${optUGJ}
                </select>
            </div>
          </div>

        </div>

        <div class="row mt-5" id="divDocumento">
          <div class="col-lg-12">
            <h6 class="form-control-label" style="color:#848f33;">Adjuntar Documento </h6>
            <hr/>
          </div>

          <div class="col-lg-6">
            <div class="col-lg-12" id="row_documento_te">
              <div class="file-select" id="cargarDocumentoTE" style="width:100%;">
                <input type="file" id="TE_PDF" class="input-file" value="" name="TE_PDF" aria-label="Archivo" accept=".pdf">
              </div>
            </div>
            <div class="col-lg-12 mt-4" id="col_nombre_documento_TE">
              <label style="font-weight:bold;">Nombre Documento:  <span id="NDoc">Sin Documento</span></label>
              <input class="form-control" type="hidden" id="nombre_documento_te" name="nombre_documento_te" autocomplete="off">
            </div>
          </div>
          
          <div class="col-lg-6">
            <div class="row justify-content-center" id="divViewDocumentosTE" style="background:#ccc; color:#fff; height:auto; text-align:center; align-items:center;">
              <i class="fas fa-file-pdf fa-5x" style="margin:8% 0;"></i>
            </div>
          </div>

        </div>
        
      `;

      $('#espacioSolicitud').html(html);
      $('#modal-nueva-solicitud').modal('show');

      setTimeout(function(){
        configA();
        
        $("#TE_PDF").on('input',function () {
          leeDocumentoTE(this, 'CJUGJ');
        });

        $('#carpetaReferida').on('input click', function () {

          if( $(this).val() == '' )   return false;

          $('#juzgadoEmisor').val('En trámite');
          $('#juzgadoEmisor').attr('id_unidad','');
          $('#parte').html(`<option selected disabled value="">Seleccionar</option>`);

          $.ajax({
            method: 'POST',
            url: '/public/buscar_carpetas_asociadas',
            data: {carpetaAsociada: $(this).val() },
            success: function(response){

              $('#listaCarpetas').html('');
              console.log('response', response);

              if( response.status == 100 ) {

                $(response.response).each( function (i, carpeta) {
                  $('#listaCarpetas').append(`
                    <a href="javascript:void(0)"  onclick="seleccionarCarpeta(${carpeta.id_carpeta_judicial}, '${carpeta.folio_carpeta}', ${carpeta.id_unidad}, '${carpeta.unidad}')">
                      <li class="list-group-item text-muted" style="border-bottom: none; border: none; padding: 6px 15px;">
                        <p class="mg-b-0"><span class="">${carpeta.folio_carpeta}</span></p>
                      </li>
                    </a>
                  `);          
                });
                $('#listaCarpetas').removeClass('d-none');

              } else {

                $('#listaCarpetas').append(`
                  <li class="list-group-item text-muted" style="border-bottom: none; border: none; padding: 6px 15px;">
                    <p class="mg-b-0"><span class="">Sin resultados</span></p>
                  </li>
                `);
                $('#listaCarpetas').addClass('d-none');

              }

            }
          });
        
        });
  
        $('#calidadJuridica').change(function() {
   
          if( tipo_defensor.includes(parseInt($(this).val())) )
            $('#tipo_defensor').parent().parent().removeClass('d-none');
          else
            $('#tipo_defensor').parent().parent().addClass('d-none');
        
        });
        
        $('#estado').change(function() {
          $('#municipio').html('<option selected disabled value="">Seleccionar</option>');
        
          $.ajax({
            method: 'POST',
            url: '/public/obtener_municipios',
            data: { estado : $(this).val() },
            success: function(data) { 
              if( data.status == 100 )
                $(data.response).each(function( i, municipio ) {
                  $('#municipio').append(`
                    <option value="${municipio.cve_municipio}">${municipio.municipio}</option>
                  `);
                });
            }
          });
        });
        
        $('#tipo_persona').change(function() {
          
          if( $(this).val() == 'fisica' ) {
            $('#apellido_parteno_parte').parent().parent().removeClass('d-none');
            $('#apellido_marteno_parte').parent().parent().removeClass('d-none');
            $('#nacionalidad').parent().parent().removeClass('d-none');
            $('#genero').parent().parent().removeClass('d-none');
          }else {
            $('#apellido_parteno_parte').parent().parent().addClass('d-none');
            $('#apellido_marteno_parte').parent().parent().addClass('d-none');
            $('#nacionalidad').parent().parent().addClass('d-none');
            $('#genero').parent().parent().addClass('d-none');
          }
        
        });
        
        $('#nacionalidad').change(function() {
        
          if( ['extranjera', 'extranjera_mexicana'].includes($(this).val())  )
            $('#otra_nacionalidad').parent().parent().removeClass('d-none');
          else
            $('#otra_nacionalidad').parent().parent().addClass('d-none');
        
        });

        $('body').on('input','.select2-search__field', function () {
          $('#carpetaReferida').html('');
          if( $(this).parent().parent().find('ul').is("#select2-carpetaReferida-results") ){
            $.ajax({
              method: 'POST',
              url: '/public/buscar_carpetas_asociadas',
              data: {carpetaAsociada: $(this).val() },
              success: function(response){
                if( response.status == 100 ) 
                  $(response.response).each( function (i, carpeta) {
                    const newOption = new Option(carpeta.folio_carpeta, carpeta.id_carpeta_judicial, true, true);    
                    $('#carpetaReferida').append(newOption).trigger('change');
                  });
                else
                  $('#carpetaReferida').val(null).trigger('change');
              }
            });
          }
        });
    
        $(document).on("click",function(e) {                  
          var container = $("#listaCarpetas");
          if (!container.is(e.target) && container.has(e.target).length === 0) $('#listaCarpetas').addClass('d-none');         
        });
        
        $('#delito').change(function(){
          $('#modalidadDelito').html('<option selected value="0">Elija una opcion</option>');
          $.ajax({
            type:'POST',
            url:'/public/obtener_modalidades',
            data:{
              delito:$('#delito').val(),
            },
            success:function(response){
              if(response.status==100){
                let modalidades='<option selected value="0">Elija una opcion</option>';
                $(response.response).each((index, modalidad)=>{
                  const {id_modalidad, nombre_modalidad}=modalidad;
                  const option=`<option value="${id_modalidad}">${nombre_modalidad}</option>`;
                  modalidades=modalidades.concat(option);
                });
                $('#modalidadDelito').html(modalidades);
              }
            }
          });
        });
    
      },500);
    }

    function leeDocumentoTE(input, accion) {
      let acepted_files=["pdf","png","jpg","docx","doc"];
      
      let modal = 'modal-nueva-solicitud'
      let file = $('#TE_PDF').val();
      let ext = "";
      let extension = "";
      let nombre_documento = "";
  
      if(file.length){
       extension = file.split('.')[1];
       extension = extension.toLowerCase();
       nombre_documento = (file.split('\\')[2]).split('.')[0];
       nombre_documento = nombre_documento.replaceAll(' ', '_');
       nombre_documento = nombre_documento.replaceAll('  ', '_');
       if(extension!=''){
          if( !acepted_files.includes(extension) ){
            modal_error('Solo puede adjutar archivos PDF',modal);
            $('#TE_PDF').val('');
            //$('#mandamientoPDF_E').val();
            return false
          }else{
            if (input.files && input.files[0]) {
              let reader = new FileReader();
              reader.onload = e=> {
                newDA = {
                  'b64' : e.target.result.split('base64,')[1],
                  'nombre_archivo' : nombre_documento,
                  'tamanio_archivo': input.files[0].size,
                  'extension_archivo' : extension,
                  'tipo_data': get_tipo_data(extension),
                };
              }
              reader.readAsDataURL(input.files[0]); 
            }
            setTimeout(function(){ pintar_documento_TE(accion); },500);
          }
        }
      }else{
        return false;
      }
    }
  
    function pintar_documento_TE(accion){
      if(accion == 'CJUGJ'){
        $('#divViewDocumentosTE').html('');
        
        let reader_files=["pdf","png","jpg"];
    
        documento = newDA;
    
        if ( reader_files.includes(documento.extension_archivo) ) { 
          $('#divViewDocumentosTE').append(`
            <div class="col-lg-12" align="center">
              <object height="500px" ${ documento.extension_archivo=="pdf"?'width="100%"' : ''} class="mg-t-25" data="${documento.tipo_data+documento.b64}"></object>
            </div>
          `);    
        }else{
          $('#divViewDocumentosTE').append(`
            <div class="col-lg-12" align="center">
              ${getIcon(documento.extension_archivo)}
            </div>
          `);
        }
    
        $("#NDoc").html( documento.nombre_archivo+'.'+documento.extension_archivo );  
        $("#nombre_documento_te").val( documento.nombre_archivo );  


      }else if(accion == 'edit'){
        $('#divViewDocumentosMandamiento_E').html('');
        
        let reader_files=["pdf","png","jpg"];
    
        documento = newDA;
    
        if ( reader_files.includes(documento.extension_archivo) ) { 
          $('#divViewDocumentosMandamiento_E').append(`
            <div class="col-lg-12" align="center" style="height:100%;">
              <object style="height:100%;" ${ documento.extension_archivo=="pdf"?'width="100%"' : ''} class="mg-t-25" data="${documento.tipo_data+documento.b64}"></object>
            </div>
          `);    
        }else{
          $('#divViewDocumentosMandamiento_E').append(`
            <div class="col-lg-12" align="center">
              ${getIcon(documento.extension_archivo)}
            </div>
          `);
        }
    
        $("#nombre_documento_mandamiento_E").val( documento.nombre_archivo );  
    
        $("#col_nombre_documento_mandamiento_E").removeClass('d-none');
        $("#col_nombre_documento_mandamiento_E").focus();
      }
    }

    function get_tipo_data( extension ){
      if( extension == 'pdf' ) return 'data:application/pdf;base64,';
      if( extension == 'jpg' ) return 'data:image/jpeg;base64,';
      if( extension == 'png' ) return 'data:image/png;base64,';
      if( extension == 'doc' ) return '';
      if( extension == 'docx' ) return '';
      else return '';
    }

    function limpiarCamposDelito(){
      
      $('#modalidadDelito').val('').select2({minimumResultsForSearch: Infinity});
      $('#calificativo').val('').select2({minimumResultsForSearch: Infinity});
      $('#gradoRealizacion').val('').select2({minimumResultsForSearch: Infinity});
    }

    function validaDatosDelito(){
      if($('#delito').val()==null) return {'estatus':0,'campo':'delito','error':'No ha seleccionado el delito'};

      if($('#modalidadDelito').val()==null) return {'estatus':0,'campo':'modalidadDelito','error':'No ha seleccionado la modalidad del delito'};

      if($('#calificativo').val()==null) return {'estatus':0,'campo':'calificativo','error':'No ha seleccionado el calificativo'};

      if($('#gradoRealizacion').val()==null) return {'estatus':0,'campo':'gradoRealizacion','error':'No ha seleccionado el grado de realizacion'};

      return 100;
    }

    function obtenerSujetosSeleccionados(){
      let sujetosSeleccionados=[];
      if($('#personasAgregadasEXP input[type=checkbox]:checked').length){
        $('#personasAgregadasEXP input[type=checkbox]:checked').each(function(){
          sujetosSeleccionados.push($(this).val());
        });
      } 
      return sujetosSeleccionados;
    }

    function agregarDelito(){

        sujetosSeleccionados=obtenerSujetosSeleccionados();

        console.log('Sujetos seleccionados',sujetosSeleccionados);

        if(sujetosSeleccionados!=-1){
          // const listaImputados=[];
          const imputados=personas_c.filter((sujeto, index)=>{
            if(sujetosSeleccionados.some(indexSeleccionado=>indexSeleccionado==index) && sujeto.id_calidad_juridica==46){
              return sujeto;
            }
          });
          
          console.log('imputados',imputados)
           
          if(imputados.length){
            let listaImputados='';
            $(imputados).each((index, imputado)=>{
              const {razon_social, nombre, nombres,apellido_paterno, apellido_materno} =imputado;
              const li=`<li class="upercase">
                          ${razon_social ?? ''}${nombre}
                        </li>`;
              listaImputados=listaImputados.concat(li);
            });
            $('#listaImputados').html(listaImputados);
            const jsonSeleccion=JSON.stringify(sujetosSeleccionados);
            $('#guardarDelito').attr('onclick', 'guardarDelito(`'+jsonSeleccion+'`)');
            $('#modal-nueva-solicitud').modal('hide');
            $('#modalAgregarDelito').modal('show');
           
            setTimeout(()=>{
              $('#modalAgregarDelito .select2').select2({
                minimumResultsForSearch: Infinity
            });
            },150);
  
            if($('#delito').hasClass('select2-hidden-accessible')){
              $('#delito').select2('destroy');
              $('#delito').val('');  
            }
            setTimeout(()=>{
              $('#delito').select2({minimumResultsForSearch: ''});    
            },150);
          }
        }

    }

    function guardarDelito(sujetos){
      $('.error').removeClass('error');
      
      const validacion=validaDatosDelito();
      
      if(validacion==100){

        const sujetosSeleccionados=JSON.parse(sujetos);
        console.log('sujetosSeleccionados',sujetosSeleccionados);
        let nArrSujetosProcesales=personas_c.map((sujeto, index)=>{
          if(sujetosSeleccionados.some(indexSeleccionado=>indexSeleccionado==index) && sujeto.id_calidad_juridica==46){
            sujeto.delitos.push({
              "id_delito":$('#delito').val(),
              "delito_text":$('#delito').find('option:selected').text(),
              "id_modalidad":$('#modalidadDelito').val(),
              "modalidad_text":$('#modalidadDelito').find('option:selected').text(),
              "id_calificativo":$('#calificativo').val(),
              "calificativo_text":$('#calificativo').find('option:selected').text(),
              "forma_comision":"forma",
              "grado_realizacion":$('#gradoRealizacion').val(),
              "grado_realizacion_text":$('#gradoRealizacion').find('option:selected').text(),
              "delito_grave":$('#delito').find('option:selected').attr('data-grave'),
              });
          }
          return sujeto;
        });
        console.log('nArrSujetosProcesales',nArrSujetosProcesales);
        personas_c=nArrSujetosProcesales;
        $('#modalAgregarDelito').modal('hide');
        limpiarCamposDelito();
        mostrarPersonas('EXP');
        $('#modal-nueva-solicitud').modal('show');
      }else{
        const {campo , error} = validacion;
        if($('#'+campo).is('select')){
          $('span[aria-labelledby="select2-'+campo+'-container"]').addClass('error');
        }else{
          $('#'+campo).focus().addClass('error');
        }
        $('#messageError').html(`${error}`);
        $('#modalError').modal('show');
      }

      
    }

    /* Abrir Formulario de agregar parte*/
    function nuevaParte(modo = null, index = null) {  
      
      let tipoPersona = [
        {'id_tipo': 'fisica', 'tipo':'FÍSICA'},
        {'id_tipo': 'moral', 'tipo':'MORAL'}
      ];

      let genero = [
        {'id_genero': 'masculino', 'genero':'MASCULINO'},
        {'id_genero': 'femenino', 'genero':'FEMENINO'},
        {'id_genero': 'no_identificaco', 'genero':'NO IDENTIFICADO'}
      ];

      let nacionalidad = [
        {'id_nacionalidad': 'mexicana', 'nacionalidad':'MEXICANA'},
        {'id_nacionalidad': 'mexicana_otro', 'nacionalidad':'MEXICANA/OTRO'},
        {'id_nacionalidad': 'extranjero', 'nacionalidad':'EXTRANJERO'}
      ];


      console.log('calidad', calidad_juridica); 
      
      if(modo == 'act'){
        var persona = personas_c[index];
        console.log(persona);

        setTimeout(function(){
          mostrarAlias('act', index);
          mostrarCorreos('act', index);
          mostrarTelefonos('act', index);
        }, 1000);
      }

      strOptCalidad_juridica = '<option selected disabled value="">Seleccionar</option>';
      for(i in calidad_juridica){
        strOptCalidad_juridica += `<option ${modo == 'act' ? (persona.id_calidad_juridica == calidad_juridica[i].id_calidad_juridica ? 'selected': '') : ''} idCalidad="${calidad_juridica[i].id_calidad_juridica}" value="${calidad_juridica[i].calidad_juridica}">${calidad_juridica[i].calidad_juridica}</option>`;
      }

      strOptNacionalidades = '<option selected disabled value="">Seleccionar</option>';
      for(i in nacionalidad){
        strOptNacionalidades += `<option ${modo == 'act' ? (persona.nacionalidad == nacionalidad[i].id_nacionalidad ? 'selected': '') : ''} value="${nacionalidad[i].id_nacionalidad}">${nacionalidad[i].nacionalidad}</option>`;
      }
  

      strOptTipoPersona = '<option selected disabled value="">Seleccionar</option>';
      for(i in tipoPersona) {
        strOptTipoPersona += `<option ${modo == 'act' ? (persona.tipo_persona == tipoPersona[i].id_tipo ? 'selected': '') : ''}  value="${tipoPersona[i].id_tipo}">${tipoPersona[i].tipo}</option>`;
      }

      strOptGenero = '<option selected disabled value="">Seleccionar</option>';
      for(i in genero) {
        strOptGenero += `<option ${modo == 'act' ? (persona.genero == genero[i].id_genero ? 'selected': '') : ''}  value="${genero[i].id_genero}">${genero[i].genero}</option>`;
      }

      strOptEstados = '<option selected disabled value="">Seleccionar</option>';
      if(estados.status == 100){
        let est =  estados.response;
        for(i in est){
          strOptEstados += `<option ${modo == 'act' ? (persona.direccion.entidad_federativa == est[i].cve_estado ? 'selected': '') : ''} value="${est[i].cve_estado}">${est[i].estado}</option>`;
        }
      }

      let alias_fun = '';
      if(modo == 'act'){
        alias_fun = `agregarAlias('act',${index})`;
      }else{
        alias_fun = `agregarAlias()`;
      }

      let muni_fun = '';
      if(modo == 'act'){
        muni_fun = `elegirMunicipio(this, 'act' ,${persona.direccion.id_municipio})`
      }else{
        muni_fun = `elegirMunicipio(this)`
      }


      var html = `
        <div class="card-header">
          <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
              <a class="nav-link active" href="#datos_generales" data-toggle="tab">Datos generales</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#datos_alias" data-toggle="tab">Registro de alias</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#datos_contacto" data-toggle="tab">Datos de contacto</a>
            </li>
          </ul>
        </div>

        <div class="card-body">
          <div class="tab-content">

            <div class="tab-pane active" id="datos_generales">

              <div class="row">

                <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-control-label">Calidad jurídica: </label>
                    <select class="form-control select2 select2-show-search" id="calidadJuridica" name="calidad_juridica" autocomplete="off">
                      ${strOptCalidad_juridica}
                    </select>    
                  </div>  
                </div>

                <div class="col-md-4 d-none">
                  <div class="form-group">
                    <label class="form-control-label">Tipo de defensor: </label>
                    <select class="form-control select2 select2-show-search" id="tipo_defensor" name="tipo_defensor" autocomplete="off">
                      <option selected disabled value="">Seleccionar </option>
                      <option value="publico">Público</option>
                      <option value="privado">Privado<option>                                                                    
                    </select>    
                  </div>  
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-control-label">Tipo de persona: <span class="tx-danger">*</span></label>
                    <select class="form-control select2 select2-show-search" id="tipo_persona" name="tipo_persona" autocomplete="off" onchange="elegirPersona(this)">
                      ${strOptTipoPersona}                                         
                    </select>    
                  </div>  
                </div>

                <div class="col-lg-4 d-none" id="divRFC">
                  <div class="form-group mg-b-10-force">
                    <label class="form-control-label">RFC:</label>
                    <input class="form-control" type="text" name="rfc" id="rfc" autocomplete="off" style="text-transform: uppercase;" value="${modo == 'act' ? persona.rfc : ''}">
                  </div>
                </div>

                <div class="col-lg-8 d-none" id="divMoral">
                  <div class="form-group mg-b-10-force">
                    <label class="form-control-label">Razón Social:<span class="tx-danger">*</span></label>
                    <input class="form-control" type="text" name="razon_social" id="razonSocial" autocomplete="off" style="text-transform: uppercase;" value="${modo == 'act' ? persona.razon_social : ''}">
                  </div>
                </div>

                <div class="col-md-4" id="divNacionalidad">
                  <div class="form-group">
                    <label class="form-control-label">Nacionalidad: <span class="tx-danger">*</span></label>
                    <select class="form-control select2 select2-show-search" id="nacionalidad" name="nacionalidad" autocomplete="off">
                      ${strOptNacionalidades}                                        
                    </select>    
                  </div>  
                </div>

                <div class="col-md-4 d-none">
                  <div class="form-group">
                    <label class="form-control-label">Indique la nacionalidad: </label>
                    <select class="form-control select2 select2-show-search" id="otra_nacionalidad" name="otra_nacionalidad" autocomplete="off">
                      ${strOptNacionalidades}                                         
                    </select>    
                  </div>  
                </div>

                <div class="col-md-4" id="divGenero">
                  <div class="form-group">
                    <label class="form-control-label">Género: <span class="tx-danger">*</span></label>
                    <select class="form-control select2 select2-show-search" id="genero" name="genero" autocomplete="off">
                      ${strOptGenero}                                        
                    </select>    
                  </div>  
                </div>

                <div class="col-md-8" id="divNombres">
                  <div class="form-group mg-b-10-force">
                    <label class="form-control-label">Nombres: <span class="tx-danger">*</span></label>
                    <input class="form-control" type="text" name="nombres_parte" id="nombres_parte" style="text-transform: uppercase;" value="${modo == 'act' ? persona.nombres : ''}">
                  </div>
                </div>

                <div class="col-md-6" id="divApaterno">
                  <div class="form-group mg-b-10-force">
                    <label class="form-control-label">Apellido paterno: </label>
                    <input class="form-control" type="text" name="apellido_parteno_parte" id="apellido_paterno_parte" style="text-transform: uppercase;" value="${modo == 'act' ? persona.apellido_parteno : ''}">
                  </div>
                </div>

                <div class="col-md-6" id="divAmaterno">
                  <div class="form-group mg-b-10-force">
                    <label class="form-control-label">Apellido materno: </label>
                    <input class="form-control" type="text" name="apellido_marteno_parte" id="apellido_materno_parte" style="text-transform: uppercase;" value="${modo == 'act' ? persona.apellido_marteno : ''}">
                  </div>
                </div>

              </div>

            </div>

            <div class="tab-pane" id="datos_alias">

              <div class="row">

                <div class="col-md-10">
                  <div class="form-group mg-b-10-force">
                    <label class="form-control-label">Alias: <span class="tx-danger">*</span></label>
                    <input class="form-control" type="text" name="alias" id="alias">
                  </div>
                </div>

                <div class="col-md-2 tx-center" style="display: grid;">
                  <a href="javascript:void(0)" onclick="${alias_fun}" style="color: #848f33; font-size: 26px;margin-top: auto;margin-bottom: auto;display: block;">
                    <i class="fa fa-plus-circle" aria-hidden="true"></i>
                  </a>
                </div>

              </div>

              <table  data-swipe-ignore="true" id="tableAlias" class="display dataTable dtr-inline collapsed" style="overflow-x: auto; padding-left:0; padding-rigth:0">
                <thead style="background-color: #EBEEF1; color: #000;" data-swipe-ignore="true">
                  <th class="acciones">Acciones</th>
                  <th class="folio_registro">Alias</th>
                </thead>
                <tbody id="bodyAlias">
                  <tr class="tx-danger tx-center"><td colspan="4">No ha agregado ningún alias</td></tr>
                </tbody>
              </table>
            </div>

            <div class="tab-pane" id="datos_contacto">

              <div>

                <div  class="slim-pagetitle">
                  <h6>Domicilio</h6>  
                </div>

                <div class="row pd-10">

                  <div class="col-md-6">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">Calle: </label>
                      <input class="form-control" type="text" name="calle" id="calle" value="${modo == 'act' ? persona.direccion.calle : ''}">
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">Número exterior:: </label>
                      <input class="form-control" type="text" name="no_exterior" id="no_exterior" value="${modo == 'act' ? persona.direccion.no_exterior : ''}">
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">Número interior: </label>
                      <input class="form-control" type="text" name="no_interior" id="no_interior" value="${modo == 'act' ? persona.direccion.no_interior : ''}">
                    </div>
                  </div>

                  <div class="col-md-2">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">C.P.: </label>
                      <input class="form-control" type="text" name="codigo_postal" id="codigo_postal"  value="${modo == 'act' ? persona.direccion.codigo_postal : ''}">
                    </div>
                  </div>

                  <div class="col-md-5">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">Colonia: </label>
                      <input class="form-control" type="text" name="colonia" id="colonia"  value="${modo == 'act' ? persona.direccion.colonia : ''}">
                    </div>
                  </div>

                  <div class="col-md-5">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">Estado: </label>
                      <select class="form-control select2 select2-show-search" id="estado" name="estado" autocomplete="off" onchange="elegirMunicipio(this)">
                        ${strOptEstados}                                
                      </select>    
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">Municipio: </label>
                      <select class="form-control select2 select2-show-search" id="municipio" name="municipio" autocomplete="off">
                        <option selected disabled value="">Seleccionar</option>                                          
                      </select>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">Localidad: </label>
                      <input class="form-control" type="text" name="localidad" id="localidad"  value="${modo == 'act' ? persona.direccion.localidad : ''}">
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">Entre calle y calle: </label>
                      <input class="form-control" type="text" name="entre_calles" id="entre_calles" value="${modo == 'act' ? persona.direccion.entre_calles : ''}">
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">Otras referencias: </label>
                      <textarea class="form-control" type="text" value="${modo == 'act' ? persona.direccion.referencias : ''}" name="otra_referencia" id="otra_referencia">${modo == 'act' ? persona.direccion.referencias : ''}</textarea>
                    </div>
                  </div>

                </div>

                <div  class="slim-pagetitle mg-t-10">
                  <h6>Teléfonos</h6>  
                </div>

                <div class="row pd-10">

                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="form-control-label">Tipo: <span class="tx-danger">*</span></label>
                      <select class="form-control select2" id="tipo_telefono" name="tipo_telefono" autocomplete="off">
                        <option selected disabled value="">Seleccionar</option>                                          
                        <option value="fijo">Fijo</option>                                          
                        <option value="celular">Celular</option>                                          
                      </select>    
                    </div>  
                  </div>

                  <div class="col-md-2">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">Lada: </label>
                      <input class="form-control" type="text" name="lada" id="lada">
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">Número: <span class="tx-danger">*</span></label>
                      <input class="form-control" type="text" name="numero_telefono" id="numero_telefono">
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">Extensión: </label>
                      <input class="form-control" type="text" name="extension" id="extension">
                    </div>
                  </div>

                  <div class="col-md-1 tx-center" style="display: grid;">
                    <a href="javascript:void(0)" onclick="agregarTelefono()" style="color: #848f33;font-size: 26px;margin-top: auto;margin-bottom: auto;display: block;">
                      <i class="fa fa-plus-circle" aria-hidden="true"></i>
                    </a>
                  </div>

                  <div class="col-12">
                    <table  data-swipe-ignore="true" id="tableTelefonos" class="display dataTable dtr-inline collapsed" style="overflow-x: auto; padding-left:0; padding-rigth:0">
                      <thead style="background-color: #EBEEF1; color: #000;" data-swipe-ignore="true">
                        <tr>
                          <th class="text-center acciones"></th>
                          <th class="tipo">Tipo</th>
                          <th class="lada">Lada</th>
                          <th class="numero">Número</th>
                          <th class="extension">Extensión</th>
                        </tr>
                      </thead>
                      <tbody id="bodyTelefonos">
                        <tr class="tx-center"><td colspan="5" class="tx-danger">No ha agregado a ningún teléfono</td></tr>
                      </tbody>
                    </table>
                  </div>

                </div>

                <div  class="slim-pagetitle mg-t-10">
                  <h6>Correos electrónicos</h6>  
                </div>

                <div class="row pd-10">

                  <div class="col-md-10">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">Correo electrónico: <span class="tx-danger">*</span></label>
                      <input class="form-control" type="text" name="correo_electronico" id="correo_electronico">
                    </div>
                  </div>

                  <div class="col-md-2 tx-center" style="display: grid;">
                    <a href="javascript:void(0)" onclick="agregarCorreo()" style="color: #848f33;font-size: 26px;margin-top: auto;margin-bottom: auto;display: block;">
                      <i class="fa fa-plus-circle" aria-hidden="true"></i>
                    </a>
                  </div>

                  <div class="col-12">
                    <table  data-swipe-ignore="true" id="tableCorreos" class="display dataTable dtr-inline collapsed" style="overflow-x: auto; padding-left:0; padding-rigth:0">
                      <thead style="background-color: #EBEEF1; color: #000;" data-swipe-ignore="true">
                        <tr>
                          <th class="acciones"></th>
                          <th class="tx-center correo">Correo electrónico</th>
                        </tr>
                      </thead>
                      <tbody id="bodyCorreos">
                        <tr class="tx-center"><td colspan="2" class="tx-danger">No ha agregado a ningún correo electrónico</td></tr>
                      </tbody>
                    </table>
                  </div>

                </div> 

              </div>

            </div>

          </div>
        </div>
      `;

      $('#modalTitle').html('Agregar Parte');
      $('#bodyModalAgregarParte').html(html);
      $('#modal-nueva-solicitud').modal('hide');
      $('#modalAgregarParte').modal('show');
      $('#btnActGur').attr('onclick',`guardarNuevaPersona()`);

      if(modo == 'act'){
        setTimeout(function(){
            $('#estado').trigger('change');
        },1200);
      }

      setTimeout(function(){
        configA();
      });
    }

    //######## Funciones de inputs ################

    /* Tipo de Expediente  */
    function tExpediente(obj){
      var valor = $(obj).val();

      if(valor == 'OptcarpetaJ'){
        personas_c.length = 0;

        $('#OptcarpetaJ').addClass('d-flex');
        $('#OptcarpetaJ').removeClass('d-none');

        $('#OptExpJuzT').addClass('d-none');
        $('#OptExpJuzT').removeClass('d-block');

        $("#cmp_calidadJuridica option:first").prop('selected',true).trigger( "change" );

        $('.cont_opt').css({  
          display:'block',
          flexDireccion:'column'
        })

        $('#divParte').removeClass('d-block');
        $('#divParte').addClass('d-none');

        $('#juzgadoEmisor').prop('disabled',true)
        $('#juzgadoEmisor').attr('placeholder','En trámite')
        $('#juzgadoEmisor').val('')

        $('#divcarpetaReferida').addClass('d-block');
        $('#divcarpetaReferida').removeClass('d-none');

        $('#divExpediente').addClass('d-none');
        $('#divExpediente').removeClass('d-block');

        $('#personasAgregadas').html(`<tr class="tx-center"><td colspan="2" class="tx-danger">No ha agregado a ningúna Parte</td></tr>`);

        $('#carpetaReferida').val('');
        $('#parte').html(`<option selected disabled value="">Seleccionar</option>`)

        $('#personasAgregadasEXP').html(
        `<tr>
          <td colspan="2" class="tx-danger">No ha agregado a ningúna Parte</td>
        </tr>`
        );

      }else{
        personas_c.length = 0;

        $('#OptExpJuzT').addClass('d-block');
        $('#OptExpJuzT').removeClass('d-none');

        $('#OptcarpetaJ').addClass('d-none');
        $('#OptcarpetaJ').removeClass('d-flex');

        $('#divParte').removeClass('d-block');
        $('#divParte').addClass('d-none');
      
        $('.cont_opt').css({
          display:'flex',
          flexDireccion:'row'
        })

        $('#juzgadoEmisor').prop('disabled',false)
        $('#juzgadoEmisor').attr('placeholder','')
        $('#juzgadoEmisor').val('')

        $('#divcarpetaReferida').addClass('d-none');
        $('#divcarpetaReferida').removeClass('d-block');

        $('#divExpediente').addClass('d-block');
        $('#divExpediente').removeClass('d-none');

        $('#personasAgregadas').html(`<tr class="tx-center"><td colspan="2" class="tx-danger">No ha agregado a ningúna Parte</td></tr>`);

        $('#OptExpJuzT').val('');

        $('#personasAgregadasUGJ').html(
          `<tr>
            <td colspan="2" class="tx-danger">No ha agregado a ningúna Parte</td>
          </tr>`
        );
      }
    }

    /* CArpeta Judicial */
    function seleccionarCarpeta( id_carpeta_judicial, folio_carpeta, id_unidad, unidad ) {
      $('#listaCarpetas').addClass('d-none');
      carpeta_referida = { 
        id_carpeta_judicial,
        folio_carpeta
      }
      $('#carpetaReferida').val(folio_carpeta);
      $('#carpetaReferida').attr('idCarpeta',id_carpeta_judicial);
      $('#juzgadoEmisor').val(unidad);
      $('#juzgadoEmisor').attr('id_unidad',id_unidad);
      
      $('#parte').html('<option selected disabled value="">Seleccionar</option>');
      $.ajax({
        method: 'POST',
        url: '/public/obtener_personas_carpeta',
        data: { carpeta : id_carpeta_judicial },
        success: function(response){
          console.log(response);
          if( response.status == 100 ) 
            $(response.response.personas).each(function( i, persona ) {
              const {id_persona, nombre, apellido_paterno, apellido_materno, calidad_juridica} = persona.info_principal;
              $('#parte').append(`<option  calidad="${calidad_juridica}" nombre="${nombre == null?'&nbsp':nombre} ${apellido_paterno==null?'':apellido_paterno} ${apellido_materno==null?'':apellido_materno}"  value="${id_persona}">[${calidad_juridica ?? ''}] ${nombre == null?'&nbsp':nombre} ${apellido_paterno==null?'':apellido_paterno} ${apellido_materno==null?'':apellido_materno}</option>`);
            });
          else
            alert('Carpeta sin partes relacionadas');
        }
      });
      
    }

    function otra(obj){
      if($(obj).val() == 'otra'){
        $('#tipo_solicitud_recibida').parent().parent().removeClass('col-lg-4');
        $('#tipo_solicitud_recibida').parent().parent().addClass('col-lg-3');

        $('#juzgadoEmisor').parent().parent().removeClass('col-lg-4');
        $('#juzgadoEmisor').parent().parent().addClass('col-lg-3');

        $('#divcarpetaReferida').removeClass('col-lg-4');
        $('#divcarpetaReferida').addClass('col-lg-3');

        $('#divExpediente').removeClass('col-lg-4');
        $('#divExpediente').addClass('col-lg-3');

        $('#cmpOtro').addClass('d-block');
        $('#otroCmp').val('');
        $('#cmpOtro').removeClass('d-none');

      }else{
        $('#tipo_solicitud_recibida').parent().parent().removeClass('col-lg-3');
        $('#tipo_solicitud_recibida').parent().parent().addClass('col-lg-4');

        $('#juzgadoEmisor').parent().parent().removeClass('col-lg-3');
        $('#juzgadoEmisor').parent().parent().addClass('col-lg-4');

        $('#divcarpetaReferida').removeClass('col-lg-3');
        $('#divcarpetaReferida').addClass('col-lg-4');

        $('#divExpediente').removeClass('col-lg-3');
        $('#divExpediente').addClass('col-lg-4');

        $('#cmpOtro').addClass('d-none');
        $('#cmpOtro').removeClass('d-block');
      }
    }

    function tipo_unidad_destino(obj){
      var valor = $(obj).val();
      var materia_destino = $('input:radio[name=materia_destino]:checked').val();

      if(valor == 'OptTE'){
        $('#divOptTE').removeClass('d-none');
        $('#divOptTE').addClass('d-block');

        $('#divOptUE').removeClass('d-block');
        $('#divOptUE').addClass('d-none');

        $('#divOptUGJ').removeClass('d-block');
        $('#divOptUGJ').addClass('d-none');

        if(materia_destino == 'OptPenalA'){
          $("#TE_receptor option[value='4']").prop('selected',true).trigger( "change" );
        }else{
          $("#TE_receptor option[value='4']").prop('selected',true).trigger( "change" );
        }
      }

      if(valor == 'OptUE'){
        $('#divOptUE').removeClass('d-none');
        $('#divOptUE').addClass('d-block');

        $('#divOptTE').removeClass('d-block');
        $('#divOptTE').addClass('d-none');

        $('#divOptUGJ').removeClass('d-block');
        $('#divOptUGJ').addClass('d-none');
        
        if(materia_destino == 'OptPenalA'){
          $("#UE_receptor option[value='20']").prop('selected',true).trigger( "change" );
        }else{
          $("#UE_receptor option[value='36']").prop('selected',true).trigger( "change" );
        }
      }

      if(valor == 'OptUGJ'){
        $('#divOptUGJ').removeClass('d-none');
        $('#divOptUGJ').addClass('d-block');

        $('#divOptTE').removeClass('d-block');
        $('#divOptTE').addClass('d-none');

        $('#divOptUE').removeClass('d-block');
        $('#divOptUE').addClass('d-none');

        if(materia_destino == 'OptPenalA'){
          var optUGJ = '<option value="" seleted>Seleccionar</option>';
          for(i in unidades){
            var unidades_ejec = [34]
            if(unidades_ejec.includes(unidades[i].id_unidad_gestion)){
              optUGJ += `<option ${selected} value="${unidades[i].id_unidad_gestion}">${unidades[i].nombre_unidad}</option>`;
            }
          }
          $('#UGJ_receptor').html(optUGJ);
        }else{
          var optUGJ = '<option value="" seleted>Seleccionar</option>';
          for(i in unidades){
            var unidades_ejec = [33]
            if(unidades_ejec.includes(unidades[i].id_unidad_gestion)){
              optUGJ += `<option ${selected} value="${unidades[i].id_unidad_gestion}">${unidades[i].nombre_unidad}</option>`;
            }
          }

          $('#UGJ_receptor').html(optUGJ);
        }
      }

    }

    function privado_libertad(obj){
      var valor = $(obj).val();

      if(valor == 'OptSi'){
        $('#divOptSi').addClass('d-block');
        $('#divOptSi').removeClass('d-none');
      }else{
        $('#divOptSi').removeClass('d-block');
        $('#divOptSi').addClass('d-none');
      }
    }

    function nuevosCampos(obj){
      var valor = $(obj).val();
      var unidad_destino = $('input:radio[name=tipo_unidad_destino]:checked').val();

      if(valor == 'OptPenalA'){
        if(unidad_destino == 'OptTE'){
          $("#TE_receptor option[value='4']").prop('selected',true).trigger( "change" );
        }else if(unidad_destino == 'OptUE'){
          $("#UE_receptor option[value='20']").prop('selected',true).trigger( "change" );
        }else{
          var optUGJ = '<option value="" seleted>Seleccionar</option>';
          for(i in unidades){
            var unidades_ejec = [34]
            if(unidades_ejec.includes(unidades[i].id_unidad_gestion)){
              optUGJ += `<option ${selected} value="${unidades[i].id_unidad_gestion}">${unidades[i].nombre_unidad}</option>`;
            }
          }
          $('#UGJ_receptor').html(optUGJ);

        }
      }else{
        if(unidad_destino == 'OptTE'){
          $("#TE_receptor option[value='4']").prop('selected',true).trigger( "change" );
        }else if(unidad_destino == 'OptUE'){
          $("#UE_receptor option[value='36']").prop('selected',true).trigger( "change" );
        }else{
          var optUGJ = '<option value="" seleted>Seleccionar</option>';
          for(i in unidades){
            var unidades_ejec = [33]
            if(unidades_ejec.includes(unidades[i].id_unidad_gestion)){
              optUGJ += `<option ${selected} value="${unidades[i].id_unidad_gestion}">${unidades[i].nombre_unidad}</option>`;
            }
          }

          $('#UGJ_receptor').html(optUGJ);
    
        }
      }

    }

    function elegirPersona(obj){
      var valor = $(obj).val();

      if(valor ==  'moral'){
        $('#divNacionalidad').addClass('d-none');
        $('#divGenero').addClass('d-none');
        $('#divNombres').addClass('d-none');
        $('#divApaterno').addClass('d-none');
        $('#divAmaterno').addClass('d-none');

        $('#divNacionalidad').removeClass('d-block');
        $('#divGenero').removeClass('d-block');
        $('#divNombres').removeClass('d-block');
        $('#divApaterno').removeClass('d-block');
        $('#divAmaterno').removeClass('d-block');

        $('#divRFC').removeClass('d-none');
        $('#divMoral').removeClass('d-none');

        $('#divRFC').removeClass('d-block');
        $('#divMoral').removeClass('d-block');

      }else{
        $('#divNacionalidad').removeClass('d-none');
        $('#divGenero').removeClass('d-none');
        $('#divNombres').removeClass('d-none');
        $('#divApaterno').removeClass('d-none');
        $('#divAmaterno').removeClass('d-none');

        $('#divNacionalidad').addClass('d-block');
        $('#divGenero').addClass('d-block');
        $('#divNombres').addClass('d-block');
        $('#divApaterno').addClass('d-block');
        $('#divAmaterno').addClass('d-block');

        $('#divRFC').removeClass('d-block');
        $('#divMoral').removeClass('d-block');

        $('#divRFC').addClass('d-none');
        $('#divMoral').addClass('d-none');
      }
    }

    /* Agregar Parte de una carpeta Referida */
    function agregarParte() {
      $('#select2-parte-containe').removeClass('error');
    
      if( $('#parte').val() == null ){
        $('#select2-parte-container').addClass('error');
        return false;
      }
        
      
      const parte = {
        nombre: $('#parte option:selected').attr('nombre').toUpperCase(),
        calidad_juridica: $('#parte option:selected').attr('calidad').toUpperCase(),
        id_parte: $('#parte').val()
      }
    
      personas_c.push(parte);
    
      mostrarPersonas('UGJ');
      $("#parte option:first").prop('selected',true).trigger( "change" );
    }

    function eliminarPersona(i) {

      personas_c = personas_c.filter( ( q, j ) => j != i );
     
      mostrarPersonas('EXP');
    
    }

    /* Seccion Alias*/
    function agregarAlias(modo=null, index = null) {
      $('.error').removeClass('error');
      if( $('#alias').val() == '' ) {
        $('#alias').addClass('error');
        return false;
      }
    
      if(modo == 'act'){
        personas_c[index].alias.push({
          descripcion: $('#alias').val(),
        })
      }else{

        const alias = {
          descripcion : $('#alias').val(),
        };
      
        alias_parte.push(alias);
      }

      $('#alias').val('');
    
      mostrarAlias(modo, index);
    
    }
    
    function mostrarAlias(modo=null, index=null) {
      if(modo == 'act') alias_parte = personas_c[index].alias;

      $('#bodyAlias').html('');
      if( alias_parte.length > 0 ) 
        $(alias_parte).each(function( i, alias) {
          $('#bodyAlias').append(`
            <tr>
              <td>
                <a href="javascript:void(0)" onclick="eliminarAlias(${i})" style="font-size: 16px">
                  <i class="fa fa-trash tx-danger" aria-hidden="true"></i>
                </a>
              </td>
              <td>
                ${alias.descripcion}
              </td>
            </tr>
          `);
        });
      else 
        $('#bodyAlias').html(`<tr class="tx-danger tx-center"><td colspan="4">No ha agregado ningún alias</td></tr>`);
    
    }
    
    function eliminarAlias(i) {
      
      alias_parte = alias_parte.filter( ( a, j ) => j != i );
     
      mostrarAlias();
    
    }
    
    /* Seccion de Telefono*/
    function agregarTelefono(modo=null, index=null) {
    
      $('.error').removeClass('error');
    
      if( $('#tipo_telefono').val() == null ){
        $('#select2-tipo_telefono-container').addClass('error');
        return false;
      }
    
      if( $('#numero_telefono').val() == '' ){
        $('#numero_telefono').addClass('error');
        return false;
      }
    
      if(modo == 'act'){
        personas_c[index].telefonos.push({
          tipo: $('#tipo_telefono').val(),
          lada: $('#lada').val(),
          numero: $('#numero_telefono').val(),
          extension: $('#extension').val()
        })
      }else{
        const telefono = {
          tipo: $('#tipo_telefono').val(),
          lada: $('#lada').val(),
          numero: $('#numero_telefono').val(),
          extension: $('#extension').val()
        }
      
        telefonos_persona.push(telefono);
      }

      $('#tipo_telefono').val('')
      $('#lada').val('')
      $('#numero_telefono').val('')
      $('#extension').val('')

      mostrarTelefonos(modo, index);
    
    }
    
    function mostrarTelefonos(modo=null, index=null) {

      if(modo == 'act') telefonos_persona = personas_c[index].telefonos;

      $('#bodyTelefonos').html('');
      if( telefonos_persona.length > 0 ) 
        $(telefonos_persona).each( function( i, telefono) {
          $('#bodyTelefonos').append(`
            <tr>
              <td class="acciones">
                <a href="javascript:void(0)" onclick="eliminarTelefono(${i})" style="font-size: 16px">
                  <i class="fa fa-trash tx-danger" aria-hidden="true"></i>
                </a>
              </td>
              <td class="tipo">
                ${telefono.tipo == 'fijo' ? 'Fijo' : 'Celular'}
              </td>            
              <td class="lada">
                ${telefono.lada}
              </td>
              <td class="numero">
                ${telefono.numero}
              </td>
              <td class="extension">
                ${telefono.extension}
              </td>          
            </tr>
          `);
        });
      else
        $('#bodyTelefonos').html(`<tr class="tx-center"><td colspan="5" class="tx-danger">No ha agregado a ningún teléfono</td></tr>`);
      
    }
    
    function eliminarTelefono(i) {
    
      telefonos_persona = telefonos_persona.filter( ( t, j ) => j != i );
    
      mostrarTelefonos();
    }
    
    /* Seccion de Correo */
    function agregarCorreo(modo=null, index = null) {
      $('.error').removeClass('error');
    
      if( $('#correo_electronico').val() == '' ) {
        $('#correo_electronico').addClass('error');
        return false;
      }
      if(modo == 'act'){
        personas_c[index].correo.push({
          correo: $('#correo_electronico').val(),
        })
      }else{
        const correo = {
          correo : $('#correo_electronico').val(),
        };
      
        correos_persona.push(correo);
      }

      $('#correo_electronico').val('')
      mostrarCorreos(modo, index);
    }
    
    function mostrarCorreos(modo=null, index=null) {
      if(modo == 'act') correos_persona = personas_c[index].correo;

      $('#bodyCorreos').html('');
      if( correos_persona.length > 0 ) 
        $(correos_persona).each(function( i, correo ) {
          $('#bodyCorreos').append(`
            <tr>
              <td class="acciones">
                <a href="javascript:void(0)" onclick="eliminarCorreo(${i})" style="font-size: 16px">
                  <i class="fa fa-trash tx-danger" aria-hidden="true"></i>
                </a>
              </td>
              <td class="correo">
                ${correo.correo}
              </td>
            </tr>
          `);
        });
      else
        $('#bodyCorreos').html(`<tr class="tx-center"><td colspan="2" class="tx-danger">No ha agregado a ningún correo electrónico</td></tr>`);
      
    }
    
    function eliminarCorreo(i) {
    
      correos_persona = correos_persona.filter( ( c, j ) => j != i );
    
      mostrarCorreos();
    }

    /* Seccion Delito*/
    function eliminarDelito(__index__, __delito__){
      let delitos = personas_c[__index__].delitos;
      console.log('delitos', delitos);

      delitos = delitos.filter( (c, j) => j != __delito__);

      personas_c[__index__].delitos = delitos;

      mostrarPersonas('EXP')
    }

    /* Seccion Estado*/

    function elegirMunicipio(obj, modo=null, index=null){
        console.log($('#estado').val());
        $.ajax({
          type:'POST',
          url:'/public/obtener_municipios',
          data:{
            estado:$(obj).val(),
          },
          success:function(response){
            if(response.status==100){

              let municipios='<option disabled selected>Seleccionar</option>';
              $(response.response).each(function(index, datosMunicipio){
                const {id_municipio, municipio}=datosMunicipio;

                const option=`<option ${modo == 'act' ? (id_municipio == index ? 'selected' : '') : ''} value="${id_municipio}">${municipio}</option>`;
                municipios += option;
              });
              $('#municipio').html(municipios);
            }
          }
        });
    }

    /*Guardar Persona*/
    function guardarNuevaPersona(modo = null,index = null) { 
      $('.error').removeClass('error');
    
      if( $('#calidadJuridica').val() == null ) {
        $('#select2-calidadJuridica-container').addClass('error');
        return false;
      }
    
      if( tipo_defensor.includes($('#calidadJuridica').val()) ) {
        if( $('#tipo_defensor').val() == null ){
          $('#select2-calidadJuridica-container').addClass('error');
          return false;
        }
      }
    
      if( $('#tipo_persona').val() == null ) {
        $('#select2-tipo_persona-container').addClass('error');
        return false;
      }
    
      if( $('#tipo_persona').val() == 'fisica' ) {
        /*if( $('#nacionalidad').val() == null ) {
          $('#select2-nacionalidad-container').addClass('error');
          return false;
        }*/
        if( $('#genero').val() == null ) {
          $('#select2-genero-container').addClass('error');
          return false;
        }
      }

      if($('#divNombres').hasClass('d-block')){
        if($('#nombres_parte').val() == ''){
          $('#nombres_parte').addClass('is-invalid');
          return false;
        }
      }

      if($('#divMoral').hasClass('d-block')){
        if($('#razonSocial').val() == ''){
          $('#razonSocial').addClass('is-invalid');
          return false;
        }
        /*
        if(!expVacio.test($('#rfc').val())){
          if(!expRFC.test($('#rfc').val())) return false;
        }
        */
      }
    
      const nombres = $('#nombres_parte').val().toUpperCase(),
        apellido_parteno = $('#tipo_persona').val() == 'moral' ? '' : $('#apellido_paterno_parte').val().toUpperCase(),
        apellido_marteno = $('#tipo_persona').val() == 'moral' ? '' : $('#apellido_materno_parte').val().toUpperCase();
      
      const direccion = {
        id_municipio: $('#municipio').val() == null ? '' : $('#municipio').val(),
        municipio_importacion: '-',
        entidad_federativa: $('#estado').val() == null ? '' : $('#estado').val(),
        localidad: $('#localidad').val() == null ? '' : $('#localidad').val(),
        colonia: $('#colonia').val() == null ? '' : $('#colonia').val(),
        calle: $('#calle').val() == null ? '' : $('#calle').val(),
        entre_calles: $('#entre_calles').val() == null ? '' : $('#entre_calles').val(),
        referencias: $('#otra_referencia').val() == null ? '' : $('#otra_referencia').val(),
        codigo_postal: $('#codigo_postal').val() == null ? '' : $('#codigo_postal').val(),
        no_exterior: $('#no_exterior').val() == null ? '' : $('#no_exterior').val(),
        no_interior: $('#no_interior').val() == null ? '' : $('#no_interior').val(),
      }

      const persona = {
        calidad_juridica: $('#calidadJuridica').val(),
        id_calidad_juridica: $('#calidadJuridica option:selected').attr('idCalidad'),
        tipo_defensor: $('#calidadJuridica').val() == null ? '' : $('#tipo_defensor').val(),
        tipo_persona: $('#tipo_persona').val(),
        nacionalidad: $('#tipo_persona').val() == 'moral' ? '' : $('#nacionalidad').val(),
        genero: $('#tipo_persona').val() == null ? '' : $('#genero').val(),
        nombres,
        apellido_parteno,
        apellido_marteno,
        nombre: nombres+' '+apellido_parteno+' '+apellido_marteno,
        razon_social: $('#razonSocial').val() == '' ? '-' : $('#razonSocial').val().toUpperCase(),
        rfc: $('#rfc').val() == '' ? '-' :  $('#rfc').val().toUpperCase(),
        id_persona: 0,
        alias: alias_parte,
        telefonos: telefonos_persona,
        correo: correos_persona,
        direccion: direccion,
        delitos: []
      };

      if(modo == 'act'){
        personas_c[index] = persona;
      }else{
        personas_c.push(persona);
        alias_parte = [];
        telefonos_persona = [];
        correo_persona = [];
      }
    
      $('#modalAgregarParte').modal('hide');
    
      setTimeout( () => {
        $('#modal-nueva-solicitud').modal('show');
      },300);
    
      mostrarPersonas('EXP');
    }

    function editarPersona(__index__){
      nuevaParte('act', __index__);
      $('#modalTitle').html('Actualizar Parte');
      $('#btnActGur').html('Actualizar');
      $('#btnActGur').attr('onclick',`guardarNuevaPersona('act',${__index__})`);
    }

    function mostrarPersonas(tipo) { 
      
      if( personas_c.length > 0 ){
        if(tipo == 'EXP'){
          $('#personasAgregadasEXP').html('');
          for(i in personas_c){

            var delit = '<ul style="text-align:left; list-style: circle;">';
            for(j in personas_c[i].delitos){
              delit += `<li style="display:flex; justify-content: space-between;">${personas_c[i].delitos[j].delito_text}  
                  <a href="javascript:void(0)" onclick="eliminarDelito(${i}, ${j})" style="font-size: 13px;" title="Eliminar delito">
                    <i class="fa fa-trash tx-danger" aria-hidden="true"></i>
                  </a>
              </li>`;
            }
            delit += '</ul>';

            $('#personasAgregadasEXP').append(`
              <tr>
                <td class="tx-center acciones" style="display:flex; justify-content:center;">
                  <div class="form-check">
                    <input class="form-check-input sujeto-seleccion" type="checkbox" value="${i}" id="flexCheckDefault">
                  </div>
                  <a href="javascript:void(0)" onclick="eliminarPersona(${i})" style="font-size: 16px; margin-right: 10%;" title="Eliminar persona">
                    <i class="fa fa-trash tx-danger" aria-hidden="true"></i>
                  </a>
                  <a href="javascript:void(0)" onclick="editarPersona(${i})" style="font-size: 16px; " title="Editar persona">
                    <i class="fa fa-edit tx-total" aria-hidden="true"></i>
                  </a>
                </td> 
                <td class="nombre_persona">
                  ${personas_c[i].tipo_persona == 'fisica' ? personas_c[i].nombre : personas_c[i].razon_social}
                </td>
                <td class="nombre_persona">
                  ${personas_c[i].calidad_juridica}
                </td>
                <td>
                  ${personas_c[i].delitos.length > 0 ? delit : []}
                </td>
              </tr>
            `);
          }
        }else{
          $('#personasAgregadasUGJ').html('');
          $(personas_c).each(function ( i, persona) {
            $('#personasAgregadasUGJ').append(`
              <tr>
                <td class="tx-center acciones" style="display:flex; justify-content:center;">
                  <a href="javascript:void(0)" onclick="eliminarPersona(${i})" style="font-size: 16px">
                    <i class="fa fa-trash tx-danger" aria-hidden="true"></i>
                  </a>
                </td> 
                <td class="nombre_persona">
                  ${persona.nombre}
                </td>
                <td class="nombre_persona">
                  ${persona.calidad_juridica}
                </td>
              </tr>
            `);
          });
        }
      }else{
        $('#personasAgregadasUGJ').html(`<tr class="tx-center"><td colspan="4" class="tx-danger">No ha agregado a ningúna Parte</td></tr>`);
        $('#personasAgregadasEXP').html(`<tr class="tx-center"><td colspan="4" class="tx-danger">No ha agregado a ningúna Parte</td></tr>`);
      }
    }


    /* Guardar Solicitud */
    function guardarSolicitud(){

      let val = validador();
      console.log('validacion', val);
      if(val.status == 0) return modal_error(val.mensaje, 'modal-nueva-solicitud');

      // ###### DATOS GENERALES  ########3
      var fecha_recepcion = get_date($('#fechaRecepcion').val());
      var hora_recepcion = $('#horaRecepcion').val()+':00';

      // ###### DATOS DEL EXPEDIENTE ORIGEN #####
      var expediente = $('input[name="tExpedienteR"]:checked').val();
      var tipo_expediente = (expediente == 'OptcarpetaJ') ? 'carpeta_judicial' : 'juzgado_tradicional';

      var id_carpeta_referida = (expediente == 'OptcarpetaJ') ? $('#carpetaReferida').attr('idCarpeta') : '';
      var folio_carpeta_referida = (expediente == 'OptcarpetaJ') ? $('#carpetaReferida').val() : '';
      var no_expediente = (expediente == 'OptExpJuzT') ? $('#noExpediente').val() : '';

      var juzgadoEmisor = $('#juzgadoEmisor').val();
      var tipo_solicitud_recibida = $('#tipo_solicitud_recibida').val();
      var otro_tipo_solicitud = tipo_solicitud_recibida == 'otra' ? $('#otroCmp').val() : '-' ; 

      // ###### DATOS DEL EXPEDIENTE DESTINO
      var materia_destino = $('input[name="materia_destino"]:checked').val() == 'OptPenalA' ? 'adultos' : 'adolescentes';
      var tipo_unidad_destino = '';
      if($('input[name="tipo_unidad_destino"]:checked').val() == 'OptTE'){
        tipo_unidad_destino = 'TE'
      }else if($('input[name="tipo_unidad_destino"]:checked').val() == 'OptUE'){
        tipo_unidad_destino = 'EJEC'
      }else{
        tipo_unidad_destino = 'UGJ'
      }

      var en_libertad = $('input[name="privado_libertad"]:checked').val() == 'OptSi' ? 'si' : 'no';
      var lugar_internamiento = $('input[name="privado_libertad"]:checked').val() == 'OptSi' ? $('#lugar_internamiento').val() : '-';

      var TE_UEJEC_UGJ = '-';
      if(tipo_unidad_destino == 'TE'){
        switch($('#TE_receptor').val()){
          case '7': 
            TE_UEJEC_UGJ = 'TE_norte';
          break;

          case '8':
            TE_UEJEC_UGJ = 'TE_oriente';
          break;

          case '9':
            TE_UEJEC_UGJ = 'TE_sur';
          break;
          
          case '4':
            TE_UEJEC_UGJ = 'TE_sullivan';
          break;
        }
      }else if(tipo_unidad_destino == 'EJEC'){
        switch($('#UE_receptor').val()){
          case '20':
            TE_UEJEC_UGJ = 'EJEC_sullivan';
          break;

          case '35':
            TE_UEJEC_UGJ = 'EJEC_norte';
          break;

          case '37':
            TE_UEJEC_UGJ = 'EJEC_oriente';
          break;
          
          case '36':
            TE_UEJEC_UGJ = 'EJEC_ado';
          break;
        }
      }else{
        switch($('#UGJ_receptor').val()){
          case '34':
            TE_UEJEC_UGJ = 'u12';
          break;
        }
      }

      personas = [];
      personas_nuevas = [];
      __documentoR = null;
      __documentoN = null;

      if($('input[name="tExpedienteR"]:checked').val() == 'OptcarpetaJ'){
        // Personas para carpeta referida
        for(i in personas_c){
          personas.push(personas_c[i].id_parte)
        }
        __documentoR = newDA;
        __documentoN = {
          "b64":'-',
          "extension_archivo":'-',
          "nombre_archivo":'-',
          "tamanio_archivo":'-',
          "tipo_data":'-'
        };
      }else{
        //Para personas nuevas
        personas_nuevas = [];

        aliases = [
          {'descripcion':'-'}
        ]
        for (i in personas_c){
          contacto = [];
          /*
          correo:  personas_c[i].correo,
          telefonos:  personas_c[i].telefonos,
          */
          personas_nuevas.push({
            id_calidad_juridica:  personas_c[i].id_calidad_juridica,
            tipo_defensor:  personas_c[i].tipo_defensor,
            tipo_persona:  personas_c[i].tipo_persona,
            es_mexicano:  personas_c[i].nacionalidad == 'mexicana' ? 'si': 'no',
            nombre:  personas_c[i].nombres,
            apellido_paterno:  personas_c[i].apellido_parteno,
            apellido_materno:  personas_c[i].apellido_marteno,
            genero: personas_c[i].genero,
            razon_social: '-',
            direccion:{
              id_municipio:"-",
              municipio_importacion:"-",
              entidad_federativa:"-",
              localidad:"-",
              colonia:"-",
              calle:"-",
              entre_calles:"-",
              referencias:"-",
              codigo_postal:"-",
              no_exterior:"-",
              no_interior:"-"
            },
            alias: (personas_c[i].alias.length > 0) ?  personas_c[i].alias : aliases,
            delitos:  personas_c[i].delitos,
            contactos:[
              {"contacto":"-","tipo":"telefono","extension":"-"},
              {"contacto":"-","tipo":"celular","extension":"-"},
              {"contacto":"-","tipo":"correo electronico","extension":"-"}
            ]
          })
        }

        __documentoN = newDA;
        __documentoR = {
          "b64":'-',
          "extension_archivo":'-',
          "nombre_archivo":'-',
          "tamanio_archivo":'-',
          "tipo_data":'-'
        };
      }

      solicitud = {
        "tipo_solicitud_": "INICIAL_TEJEC",
        "fecha_recepcion":fecha_recepcion,
        "hora_recepcion":hora_recepcion,
        "materia_destino": "adultos",
        "documento":__documentoN
      }

      tejec = {
        "tipo_expediente":tipo_expediente,
        "id_carpeta_ref": id_carpeta_referida,
        "folio_carpeta_ref": folio_carpeta_referida,
        "carpeta_judicial_expediente":no_expediente,
        "ugj_juzgado_emisor": juzgadoEmisor,
        "tipo_solicitud_recibida":tipo_solicitud_recibida,
        "otra_tipo_solicitud_recibida":otro_tipo_solicitud,
        "ids_personas_remitidas":personas,
        "materia_destino":materia_destino,
        "tipo_unidad_destino":tipo_unidad_destino,
        "imputado_privado_libertad":en_libertad,
        "lugar_internamiento":lugar_internamiento,
        "unidad_receptora":TE_UEJEC_UGJ,
        "documento":__documentoR
      }

      data = {
        "TEJEC": tejec,
        "solicitud": solicitud,
        "personas": personas_nuevas,
        "tipo": $('input[name="tExpedienteR"]:checked').val()
      }

      console.log('Data',data);
    
      $.ajax({
        type:'POST',
        url:'/public/registrar_solicitud_TE_EJEC',
        data:data,
        success:function(response) {
          console.log('respuesta',response)
          if(response.status==100){
            $('#modal-nueva-solicitud').modal('hide');
            var table =`<table>
              <tr>
                <td style="border:1px solid #ccc; padding:4% 0;">Folio Carpeta: </td>
                <td style="border:1px solid #ccc; padding:4% 0;">${response.response.folio_carpeta}</td>
              </tr>  
              <tr>
                <td style="border:1px solid #ccc; padding:4% 0;">Fecha Asignacion: </td>
                <td style="border:1px solid #ccc; padding:4% 0;">${response.response.fecha_asignacion}</td>
              </tr>
            </table>`;

            var exito = `<p class='mg-b-20 mg-x-20'>Solicitud Creada Exitosamente </p> <br> ${table}`;
            modal_success(exito);
            sec_ajax();
          }else{
            var error = "<p class='mg-b-20 mg-x-20'>"+response.message+"</p>";
            modal_error(error,'modal-nueva-solicitud');
          }
        }
      });
      
    }

    /* Ver info de la solicitud*/
    function ver_info(__index__){
      solicitud = solicitudes[__index__];
      console.log(solicitud);
      
      let id_solicitud = solicitud.solicitud != null ? solicitud.solicitud[0].id_solicitud : 'No contiene solicitud';
      let fecha_creacion = solicitud.creacion;
      let folio = solicitud.folio;
      let carpeta_asignada = solicitud.folio_carpeta_resul;
      let unidad_asignada = solicitud.solicitud != null ? solicitud.solicitud[0].nombre_unidad: 'No contiene solicitud';

      let tipo_expediente_registrar = solicitud.tipo_expediente == 'juzgado_tradicional' ? 'Expediente de Juzgado Tradicional': 'Carpeta Judicial de Unidad de Gestión';
      let carpeta_Expediente = solicitud.tipo_expediente == 'juzgado_tradicional' ? (solicitud.carpeta_judicial_expediente == null ? 'No registrado': solicitud.carpeta_judicial_expediente) : solicitud.folio_carpeta_ref;
      let juzgado_emisor = solicitud.ugj_juzgado_emisor;
      let tipo_solicitud_recibida = solicitud.tipo_solicitud_recibida == 'accion_penal_privada' ? 'Acción Penal Privada' : solicitud.tipo_solicitud_recibida;

      let materia_destino = solicitud.materia_destino;
      let tipo_unidad_destino = solicitud.tipo_unidad_destino == 'EJEC' ? 'Ejecución' : (solicitud.tipo_unidad_destino == 'TE' ? 'Tribunal de Enjuicimaiento' : 'Unidad de Gestión Judicial')
      let en_libertad = solicitud.imputado_privado_libertad;
      let lugar_internamiento = solicitud.nombre;
      let nombre_unidad_recptor = solicitud.tipo_unidad_destino == 'EJEC' ? 'Unidad de Ejecución receptora' : (solicitud.tipo_unidad_destino == 'TE' ? 'Tribunal de Enjuiciamiento receptor' : 'Unidad de Gestión receptora')
      var TE_UEJEC_UGJ = '-';
      
      if(solicitud.tipo_unidad_destino  == 'TE'){
        switch(solicitud.unidad_receptora){
          case 'TE_norte': 
            TE_UEJEC_UGJ = 'Tribunal de Enjuiciamiento en reclusorio Norte';
          break;

          case 'TE_oriente':
            TE_UEJEC_UGJ = 'Tribunal de Enjuiciamiento en reclusorio Oriente';
          break;

          case 'TE_sur':
            TE_UEJEC_UGJ = 'Tribunal de Enjuiciamiento en reclusorio Sur';
          break;
          
          case 'TE_sullivan':
            TE_UEJEC_UGJ = 'Tribunal de Enjuiciamiento en Sullivan';
          break;
        }
      }else if(solicitud.tipo_unidad_destino  == 'EJEC'){
        switch(solicitud.unidad_receptora){
          case 'EJEC_sullivan':
            TE_UEJEC_UGJ = 'Unidad de Gestión Judicial de Ejecución de Sanciones Penales 1 (Sullivan)';
          break;

          case 'EJEC_norte':
            TE_UEJEC_UGJ = 'Unidad de Gestión Judicial de Ejecución de Sanciones Penales 2 (Norte)';
          break;

          case 'EJEC_oriente':
            TE_UEJEC_UGJ = 'Unidad de Gestión Judicial de Ejecución de Sanciones Penales 3 (Oriente)';
          break;
          
          case 'EJEC_ado':
            TE_UEJEC_UGJ = 'Unidad de Gestión Judicial en Materia de Ejecución en Medidas Sancionadoras';
          break;
        }
      }else{
        switch(solicitud.unidad_receptora){
          case 'u12':
            TE_UEJEC_UGJ = 'Unidad de Gestión Judicial 12';
          break;
        }
      }

      let personas = solicitud.solicitud != null ? solicitud.solicitud[0].personas : [];

      let tabla_direcciones=[];
      let tabla_alias=[];
      let tabla_contacto=[];
      let tabla_correo=[];
      let tabla_datos=[];
      let tabla_delitos=[];
      let tabla_no_relacionados=null;

      let listaPersona=[];
      let listaNorelacionados='';
      let listaSujetos=[];
      let acordeones=[];

      //PERSONAS
			$(personas).each(function(index_p, persona){

							listaPersona.push(persona.info_principal);

							let tablaDireccion='';
							let tablaAlias='';
							let tablaContacto='';
							let tablaCorreo='';
							let tablaDatos='';
							let tablaDelitos='';

							$(persona.direcciones).each(function(index_d, direccion){

								const {id_persona,calle,codigo_postal,colonia,entidad_federativa,entre_calles,estado,localidad,municipio,no_exterior,
									no_interior,referencias}=direccion;

								tablaDireccion = tablaDireccion + ` 
									<tr align="center"> <th colspan="100%" class="th-title">Direcciones</th> </tr>
									<tr>
										<td class="td-title">Calle</td>
										<td>${calle ?? "Sin datos"}</td>

										<td class="td-title">Número Exterior</td>
										<td>${no_exterior ?? "Sin datos"}</td>
									</tr>

									<tr>
										<td class="td-title">Número Interior</td>
										<td>${no_interior ?? "Sin datos"}</td>

										<td class="td-title">Localidad</td>
										<td>${localidad ?? "Sin datos"}</td>
									</tr>

									<tr>
										<td class="td-title">Colonia</td>
										<td>${colonia ?? "Sin datos"}</td>

										<td class="td-title">Estado</td>
										<td>${estado ?? "Sin datos"}</td>
									</tr>

									<tr>
										<td class="td-title">Municipio</td>
										<td>${municipio ?? "Sin datos"}</td>

										<td class="td-title">Otras Referencias</td>
										<td>${referencias ?? "Sin datos"}</td>
									</tr>

									<tr>
										<td class="td-title">Entre Calles</td>
										<td>${entre_calles ?? "Sin datos"}</td>

										<td class="td-title">Codigo Postal</td>
										<td>${codigo_postal ?? "Sin datos"}</td>
									</tr>
									`;
							});  

							tabla_direcciones[index_p] = tablaDireccion;

							//DELITOS PERSONAS
							if(persona.delitos.length){
								$(persona.delitos).each(function(index_de, delitoo){

									const {calificativo,forma_comision,grado_realizacion,delito,nombre_modalidad}  =delitoo;

									tablaDelitos = tablaDelitos + `
										<tr>
											<td>${delito ?? ""}</td>
											<td>${nombre_modalidad ?? ""}</td>
											<td>${calificativo ?? ""}</td>
											<td>${grado_realizacion ?? ""}</td>
										</tr>
									`;
								});   
								
								tabla_delitos[index_p] =` 
									<tr align="center"><th colspan="4" class="tx-center" style="background:#f8f9fa">Delitos Relacionados </th></tr>
										<tr>
											<td class="tx-center" style="background:#f8f9fa">Delito</td>
											<td class="tx-center" style="background:#f8f9fa">Modalidad del Delito</td>
											<td class="tx-center" style="background:#f8f9fa">Calificativo</td>
											<td class="tx-center" style="background:#f8f9fa">Grado de Realizacion</td>
										</tr>`+  tablaDelitos;
							}else{
								tabla_delitos[index_p] = `
									<tr align="center">
										<td colspan="4" class="tx-center" style="background:#f8f9fa"> Sin delitos relacionados </td>
									</tr>
								`;
							}
					
							//DATOS PERSONAS
							$(persona.datos).each(function(index_da, datos){
								const {capacidad_diferente,capacidades_diferentes,entiende_idioma_español,grupo_etnico,idioma_traductor,
								lengua,nivel_escolaridad,nombre_poblacion,nombre_religion,requiere_interprete,requiere_traductor,
								sabe_leer_escribir} =datos;
								tablaDatos=  datos;
							});
							tabla_datos[index_p] = tablaDatos;

							// ALIAS PERSONAS
							$(persona.alias).each(function(index_a, aliases){
								const {alias} =aliases;
								tablaAlias= tablaAlias + `${alias} <br>`;
							}); 
							tabla_alias[index_p] = tablaAlias;


							// CONTACTO PERSONAS
							$(persona.contacto).each(function(index_c, contact){
								const {contacto,tipo_contacto} =contact;

								if(tipo_contacto== "correo electronico"){
									tablaCorreo = tablaCorreo + `${contacto} <br>`;
								}
								else{
									tablaContacto = tablaContacto + ` ${tipo_contacto} : ${contacto} <br> `;
								}
							}); 
							
							tabla_contacto[index_p] = tablaContacto;
							tabla_correo[index_p] = tablaCorreo;
			});

			// INFO SOLICITUD PERSONAS
			$(listaPersona).each(function(index,sujetosProcesales){


								const {id_persona,nombre,apellido_paterno,apellido_materno,calidad_juridica,cedula_profesional,curp,edad,es_mexicano,
								estado_civil,fecha_nacimiento,folio_identificacion,lugar_reclusorio,genero,nacionalidad,otra_nacionalidad,tipo_identificacion,
								tipo_persona,rfc_empresa,tipo_ocupacion,poblacion_callejera} =sujetosProcesales;

								var tablaSujeto = `
									<table class="info-principa datatable tableDatosSujeto" style="overflow-x: none; display: table">
										<tbody class="table-datos-sujeto">
											<tr>
												<td class="td-title">Calidad Juridica</td>
												<td>${calidad_juridica ?? "Sin datos"}</td>

												<td class="td-title">Sabe Leer y Escribir</td>
												<td>${tabla_datos[index].sabe_leer_escribir ?? "Sin datos"}</td>
											</tr>

											<tr>
												<td class="td-title">RFC </td>
												<td>${rfc_empresa ?? ""}</td>

												<td class="td-title">LGBTTTI</td>
												<td>${tabla_datos[index].nombre_poblacion ?? "Sin datos"}</td>
											</tr>

											<tr>
												<td class="td-title">CURP </td>
												<td>${curp ?? ""}</td>

												<td class="td-title">Poblacion</td>
												<td>${tabla_datos[index].poblacion ?? "Sin datos"}</td>
											</tr>

											<tr>
												<td class="td-title">Cédula Profesional </td>
												<td>${cedula_profesional ?? "Sin datos"}</td>

												<td class="td-title">Requiere traductor</td>
												<td>${tabla_datos[index].requiere_traductor ?? "Sin datos"}</td>
											</tr>

											<tr>
												<td class="td-title">Género </td>
												<td>${genero ?? "Sin datos"}</td>

												<td class="td-title">Requiere Interprete</td>
												<td>${tabla_datos[index].requiere_interprete ?? "Sin datos"}</td>
											</tr>

											<tr>
												<td class="td-title">Fecha de Nacimiento </td>
												<td>${fecha_nacimiento ?? "Sin datos"}</td>

												<td class="td-title">Capacidades Diferentes</td>
												<td>${tabla_datos[index].capacidad_diferente ?? "Sin datos"}</td>
											</tr>

											<tr>
												<td class="td-title">Nacionalidad </td>
												<td>${nacionalidad ?? "Sin datos"}</td>

												<td class="td-title">Poblacion Callejera</td>
												<td>${tabla_datos[index].poblacion_callejera ?? "Sin datos"}</td>
											</tr>

											<tr>
												<td class="td-title">Otra Nacionalidad </td>
												<td>${otra_nacionalidad ?? "Sin datos"}</td>

												<td class="td-title">Lengua</td>
												<td>${estado_civil ?? "Sin datos"}</td>
											</tr>

											<tr>
												<td class="td-title">Estado Civil </td>
												<td>${estado_civil ?? "Sin datos"}</td>

												<td class="td-title">Religion</td>
												<td>${tabla_datos[index].nombre_religion ?? "Sin datos"}</td>
											</tr>

											<tr>
												<td class="td-title">Tipo Persona </td>
												<td>${tipo_persona ?? "Sin datos"}</td>

												<td class="td-title">Grupo Etnico</td>
												<td>${tabla_datos[index].grupo_etnico?? "Sin datos"}</td>
											</tr>

											<tr>
												<td class="td-title">Nivel Escolaridad </td>
												<td>${tabla_datos[index].nivel_escolaridad ?? "Sin datos"}</td>

												<td class="td-title">Ocupación</td>
												<td>${tabla_datos[index].tipo_ocupacion ?? "Sin datos"}</td>
											</tr>
										</tbody>
									</table>
									<br>
									<table class="direcciones datatable tableDatosSujeto" style="overflow-x: none; display: table">
										${tabla_direcciones[index] }
									</table>
									<br>
									<table class="contactos datatable tableDatosSujeto2" style="overflow-x: none; display: table">
										<thead>
											<tr>
												<td class="tx-center">Teléfono (s)</td>
												<td class="tx-center">Correo(s) Electrónico(s)</td>
												<td class="tx-center">Alias</td>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>${tabla_contacto[index].length ? tabla_contacto[index] : "Sin datos"}</td>
												<td>${tabla_correo[index].length ? tabla_correo[index] : "Sin datos"} </td>
												<td>${tabla_alias[index].length ? tabla_alias[index] : "Sin datos"}</td>
											</tr>
										</tbody>
									</table>
									<br>
									<table class="delitos datatable tableDatosSujeto" style="overflow-x: none; display: table">
										<tbody class="table-datos-sujeto">
											${tabla_delitos[index]}
										</tbody>
									</table> 
									<br>
								`;

								var accordion = `
									<div id="accordion-VCJ-Personas-${ index }" class="accordion-one mg-b-10" role="tablist" aria-multiselectable="true" width="100%">
										<div class="card">
											<div class="card-header" role="tab" id="headingOne">
												<a id="titleAccordion-VCJ-Personas-${ index }" style="background: #848f33c7 !important; color:#fff;" data-toggle="collapse" data-parent="#accordion-VCJ-Personas-${ index }" href="#collapseOne-VCJ-Personas-${ index }" aria-expanded="true" aria-controls="collapseOne-VCJ-Personas-${ index }" class="tx-gray-800 transition collapsed tx-semibold">
													<i class="fas fa-user" style="margin-right:1%;"></i>${nombre ?? "Sin nombre"} ${apellido_paterno ?? ""} ${apellido_materno ?? ""} [ ${calidad_juridica ?? "Sin datos"} ]
												</a>
											</div><!-- card-header -->
											<div id="collapseOne-VCJ-Personas-${ index }" class="collapse" role="tabpanel" aria-labelledby="headingOne-VCJ-Personas-${ index }">
												<div class="card-body">
													<div class="mg-t-15">
														${tablaSujeto}
													</div>
												</div> <!-- CARD BODY -->
											</div> <!-- BODY COLLAPSE -->
										</div> <!-- CARD -->
									</div> <!-- ACCORDEON VCJ PARTES PROCESALES -->
								`;

								listaSujetos += tablaSujeto;
								acordeones += accordion;

			});

      var html = `
      <div>
        <div class="hRemi">
          <span><b>Solicitud:</b> ${id_solicitud}</span>
          <span><b>Fecha:</b> ${fecha_creacion}</span>
        </div>
        
        <div class="row mt-3">
          <div class="col-md-4">
            <div class="cjon">
              <div style="text-align: center; font-size: 3.9em; color: #848f33;"><i class="fab fa-linode"></i></div>
              <div style="font-size: 0.9em;font-weight: bold;text-align: center;margin: 2% 0; background: #848f33; color: #fff; ">Folio de registro</div>
              <div style="text-align:center; font-size:0.9em;">${folio}</div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="cjon">
              <div style="text-align: center; font-size: 3.9em; color: #848f33;"><i class="fas fa-folder-open"></i></div>
              <div style="font-size: 0.9em;font-weight: bold;text-align: center;margin: 2% 0; background: #848f33; color: #fff; ">Carpeta Judicial asignada</div>
              <div style="text-align:center; font-size:0.9em;">${carpeta_asignada}</div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="cjon">
              <div style="text-align: center; font-size: 3.9em; color: #848f33;"><i class="fas fa-building"></i></div>
              <div style="font-size: 0.9em;font-weight: bold;text-align: center;margin: 2% 0; background: #848f33; color: #fff; ">Unidad de gestión destino</div>
              <div style="text-align:center; font-size:0.9em;">${unidad_asignada}</div>
            </div>
          </div>
        </div>

        <div class="row mt-5">
          <div class="col-md-6">
            <div style="padding: 1% 0; background: #848f33; color: #fff; text-align: center; margin-bottom: 5px;">Datos del expediente origen</div>
            <div class="table-responsive">
              <table class="table table-striped" style="font-size: 0.9em;">
                <tr>
                  <td style="border-right: 1px solid #eee; font-weight:bold;">Tipo de expediente a registrar</td>
                  <td>${tipo_expediente_registrar}</td>
                </tr>
                <tr>
                  <td style="border-right: 1px solid #eee; font-weight:bold;">Carpeta Judicial / No. Expediente</td>
                  <td>${carpeta_Expediente}</td>
                </tr>
                <tr>
                  <td style="border-right: 1px solid #eee; font-weight:bold;">UGJ / Juzgado emisor</td>
                  <td>${juzgado_emisor}</td>
                </tr>
                <tr>
                  <td style="border-right: 1px solid #eee; font-weight:bold;">Tipo de solicitud recibida</td>
                  <td>${tipo_solicitud_recibida}</td>
                </tr>
              </table>
            </div>
          </div>
          <div class="col-md-6">
            <div style="padding: 1% 0; background: #848f33; color: #fff; text-align: center; margin-bottom: 5px;">Datos del expediente destino</div>
            <div class="table-responsive">
              <table class="table table-striped" style="font-size: 0.9em;">
                <tr>
                  <td style="border-right: 1px solid #eee;font-weight:bold;">Materia destino</td>
                  <td>${materia_destino}</td>
                </tr>
                <tr>
                  <td style="border-right: 1px solid #eee;font-weight:bold;">Tipo de unidad destino</td>
                  <td>${tipo_unidad_destino}</td>
                </tr>
                <tr>
                  <td style="border-right: 1px solid #eee;font-weight:bold;">Lugar de internamiento</td>
                  <td>${lugar_internamiento}</td>
                </tr>
                <tr>
                  <td style="border-right: 1px solid #eee;font-weight:bold;">${nombre_unidad_recptor}</td>
                  <td>${TE_UEJEC_UGJ}</td>
                </tr>
              </table>
            </div>
          </div>
        </div>
        
        <div class="col-lg-12 mt-5">
          <h6 class="form-control-label" style="color:#848f33;"> Datos Partes Procesales </h6>
          <hr/>
        </div>

        <div>
          <div class="accordion" id="acordeon" role="tablist"    style="${ acordeones.length > 0 ? '' : 'font-weight: bold; text-align:center;'}"> ${ acordeones.length > 0 ? acordeones : 'No contiene una solicitud'} </div>
        </div>

      </div>
      `;


      $('#vTitleS').html('Ver solicitud');
      $('#espacioVerSolicitud').html(html);
      $('#modal-ver-solicitud').modal('show');  
    }

    function ver_doc(id_solicitud){
      $('#visorPDFacuse').html('');
      /*
      $.ajax({
          method: 'POST',
          url: '/public/obtener_acuse_audiencia',
          data: {
              id_audiencia: id_audiencia,
          },
          success: async function(response) {
              console.log(response);
              if(response.status == 100){
                  visorPDFAcuse = response.acuse;
                  visorPDFFormato = response.formato;

                  botones = '';

                  if(visorPDFAcuse.status == 100){
                      botones += `<div class="documento" onclick="ver_acuse_pdf(${id_audiencia}, '${visorPDFAcuse.response}')" style="cursor: pointer; border: 1px solid #848f33; border-radius: 4px; padding: 7px 10px 7px 20px; margin-bottom: 5%; text-align: left;">
                          <i class="far fa-file-pdf" style="color: #848f33; font-size: 1.1em; margin-right: 3%;"></i>
                          ${visorPDFAcuse.nombre}
                      </div>`;
                  }

                  if(visorPDFFormato.status == 100){
                      botones += `<div class="documento" onclick="ver_acuse_pdf(${id_audiencia}, '${visorPDFFormato.response}')" style="cursor: pointer; border: 1px solid #848f33; border-radius: 4px; padding: 7px 10px 7px 20px; margin-bottom: 5%; text-align: left;">
                          <i class="far fa-file-pdf" style="color: #848f33; font-size: 1.1em; margin-right: 3%;"></i>
                          Formato notificación a Juez de Control
                      </div>`;
                  }

                  pdf = `<embed src="${visorPDFAcuse.response}" type="application/pdf" width="100%" height="600px" />`;
                  $('#visorPDFacuse').html(pdf);
                  $('#lista_docs').html(botones);
              }else{
                  botones = `<div class="documento" style="cursor: pointer; border: 1px solid #848f33; border-radius: 4px; padding: 7px 10px 7px 20px; margin-bottom: 5%; text-align: left;">
                      <i class="far fa-file-pdf" style="color: #848f33; font-size: 1.1em; margin-right: 3%;"></i>
                      Sin documentos
                  </div>`;

                  pdf = `<div style="height: 600px;background: #444;display: flex;justify-content: center;align-items: center;flex-direction: column;font-size: 1.2em;;">
                              <i class="far fa-file-pdf" style="color: #fff;font-size: 1.1em;margin-right: 3%;margin-bottom: 2%;font-size: 4em;"></i>
                              Sin Documento PDF
                          </div>`;

                  $('#visorPDFacuse').html(pdf);
                  $('#lista_docs').html(botones);
              }
          }
      });
      */ 
      
      pdf = `<div style="height: 600px;background: #444;display: flex;justify-content: center;align-items: center;flex-direction: column;font-size: 1.2em;;">
        <i class="far fa-file-pdf" style="color: #fff;font-size: 1.1em;margin-right: 3%;margin-bottom: 2%;font-size: 4em;"></i>
        Sin Documento PDF
      </div>`;

      $('#visorPDFacuse').html(pdf);

      $('#modal-acuse').modal('show');
    }

    ///########## Funciones Generales #############
    function configA(){
      $('.clockpicker').clockpicker({
        autoclose: true
      });

      let fecha_actual = new Date();
      $('.date').datepicker({
        showOtherMonths: true,
        selectOtherMonths: true,
        dateFormat: 'yy-mm-dd',
        changeYear: true,
        yearRange: "c-100:" + fecha_actual.getFullYear()
      });

      $('.select2').select2();
    }

    function validador(){
      var fecha_recepcion = get_date($('#fechaRecepcion').val());
      var hora_recepcion = $('#horaRecepcion').val()+':00';

      var tipo_expediente = $('input[name="tExpedienteR"]:checked').val();
      var documento_referido = tipo_expediente == 'OptcarpetaJ' ? $('#carpetaReferida').val() : $('#noExpediente').val();
      var juzgadoEmisor = $('#juzgadoEmisor').val();
      var tipo_solicitud_recibida = $('#tipo_solicitud_recibida').val();

      var materia_destino = $('input[name="materia_destino"]:checked').val();
      var tipo_unidad_destino = $('input[name="tipo_unidad_destino"]:checked').val();
      var receptor = (tipo_unidad_destino == 'OptTE') ? $('#TE_receptor').val() :  (tipo_unidad_destino == 'OptUE') ?  $('#UE_receptor').val() : $('#UGJ_receptor').val() ;
      var en_libertad = $('input[name="privado_libertad"]:checked').val();

      if(fecha_recepcion.length <= 0) return {'status':0, 'mensaje':'Debe seleccionar uan fecha de recepción', 'longitud':fecha_recepcion.length}
      if(hora_recepcion.length <= 0) return {'status':0, 'mensaje':'Debe seleccionar una hora de recepción', 'longitud':hora_recepcion.length}

      if(tipo_expediente.length <= 0) return {'status':0, 'mensaje':'Debe seleccionar un tipo de expediente ', 'longitud':tipo_expediente.length}
      if(documento_referido.length <= 0) return {'status':0, 'mensaje':`Debe agregar ${tipo_expediente == 'OptcarpetaJ' ? 'una carpeta referida' : 'un No. expediente'}`, 'longitud':documento_referido.length}
      if(juzgadoEmisor.length <= 0) return {'status':0, 'mensaje':'Debe escribir un juzgado emisor', 'longitud':juzgadoEmisor.length}
      if(tipo_solicitud_recibida.length <= 0) return {'status':0, 'mensaje':'Debe seleccionar un tipo de solicitud', 'longitud':tipo_solicitud_recibida.length}

      if(materia_destino.length <= 0) return {'status':0, 'mensaje':'Debe seleccionar una materia destino', 'longitud':materia_destino.length}
      if(tipo_unidad_destino.length <= 0) return {'status':0, 'mensaje':'Debe seleccionar un tipo de unidad destino', 'longitud':tipo_unidad_destino.length}
      if(receptor.length <= 0) return {'status':0, 'mensaje':'Debe seleccionar una unidad receptora', 'longitud':receptor.length}
      if(en_libertad.length <= 0) return {'status':0, 'mensaje':'Debe seleccionar si el imputado se encuentra privado de su libertad', 'longitud':en_libertad.length}

      if(personas_c.length <= 0 ) return {'status':0, 'mensaje':'Debe agregar partes procesales', 'longitud':personas_c.length}

      if(tipo_expediente == 'OptExpJuzT'){
        for(i in personas_c){
          if(personas_c[i].id_calidad_juridica == 46){
            if(personas_c[i].delitos == null || personas_c[i].delitos.length <= 0) return {'status':0, 'mensaje':'Falta agregar delitos', 'longitud':personas_c.length}
          }
        }
      }

      if( newDA == null ) return {'status':0, 'mensaje':'Debe adjuntar un documento PDF a su solicitud', 'longitud':'No ha subido documento'}

      return 100
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

    function get_date(date, format = 'YYYY-MM-DD') {
        if (format == 'YYYY-MM-DD' && date.substring(0, 4).includes('-'))
            return date.split('-').reverse().join('-');
        if (format == 'DD-MM-YYYY' && !date.substring(0, 4).includes('-'))
            return date.split('-').reverse().join('-');
        else
            return date;
    }
  </script>
@endsection


@section('seccion-modales')

    {{-- MODAL NUEVA SOLICITUD --}}
    <div id="modal-nueva-solicitud" class="modal fade" data-keyboard="false" data-backdrop="static" style="overflow: auto; min-width:80%;">
      <div class="modal-dialog modal-dialog-vertical-center modal-xl modal-dialog-xxl" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Nueva Solicitud</h6>
                <button type="button" class="close ml-auto" data-dismiss="modal" aria-label="Close">
                    <span aling="right" aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="espacioSolicitud" style="padding:2rem;">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary " data-dismiss="modal">Cerrar</button>
              <button type="button" class="btn btn-success" onclick="guardarSolicitud()" style="background:#848F33 !important; border:none; cursor:pointer;">Guardar</button>
            </div>
        </div>
      </div>
    </div>

    <div id="modal-ver-solicitud" class="modal fade" data-keyboard="false" data-backdrop="static" style="overflow: auto; min-width:80%;">
      <div class="modal-dialog modal-dialog-vertical-center modal-xl modal-dialog-xxl" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold" id="vTitleS">Solicitud</h6>
                <button type="button" class="close ml-auto" data-dismiss="modal" aria-label="Close">
                    <span aling="right" aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="espacioVerSolicitud">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary " data-dismiss="modal">Cerrar</button>
            </div>
        </div>
      </div>
    </div>
    
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

    <div id="modalAgregarParte" class="modal fade" data-backdrop="static" data-keyboard="false"  style="overflow: auto;">
      <div class="modal-dialog modal-lg modal-dialog-vertical-center" role="document">
        <div class="modal-content bd-0 tx-14">

          <div class="modal-header">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold" id="modalTitle">Agregar Parte</h6>
          </div>

          <div class="modal-body pd-25">
            <div class="card" id="bodyModalAgregarParte"></div>
          </div>

          <div class="modal-footer">          
            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnCancelarParte" data-toggle="modal" data-target="#modal-nueva-solicitud">Cancelar</button>
            <button type="button" class="btn btn-primary" onclick="guardarNuevaPersona()" id="btnActGur">Guardar</button>
          </div>

        </div>
      </div>
    </div>

    <div id="modalAgregarDelito" class="modal fade modal-agregar-delito">
      <div class="modal-dialog modal-lg mg-b-100" role="document">
        <div class="modal-content tx-size-sm">
          <div class="modal-header pd-x-20">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Agregar Delito</h6>
            <button type="button" class="close cerrar-modal" data-modal="modal-nueva-solicitud" data-thismodal="modalAgregarDelito" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body pd-20">
            <div class="row form-layout">
              <div class="col-lg-12">
                <div class="form-group">
                  <label class="form-control-label">Delito: <span class="tx-danger">*</span></label>
                  <select class="form-control" id="delito" name="delito" autocomplete="nope">
                      <option selected disabled value="">Elija una opción</option>
                      @foreach ($delitos as $delito)
                          <option value="{{$delito['id_delito']}}" data-grave="{{$delito['delito_oficioso']==1?'si':'no'}}">{{$delito['delito']}}</option>
                      @endforeach
                  </select>
                </div>
              </div> 
              <div class="col-lg-12">
                <div class="form-group">
                  <label class="form-control-label">Modalidad de Delito:</label>
                  <select class="form-control select2" id="modalidadDelito" name="modalidad_delito" autocomplete="nope">
                      <option selected disabled value="">Elija una opción</option>
                     
                  </select>
                </div>
              </div> 
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label">Calificativo: <span class="tx-danger">*</span></label>
                  <select class="form-control select2" id="calificativo" name="calificativo" autocomplete="nope">
                      <option selected disabled value="">Elija una opción</option>
                      @foreach ($calificativos as $calificativo)
                          <option value="{{$calificativo['id_calificativo']}}">{{mb_strtoupper($calificativo['calificativo'])}}</option>
                      @endforeach
                  </select>
                </div>
              </div> 
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label">Grado de Realización: <span class="tx-danger">*</span></label>
                  <select class="form-control select2" id="gradoRealizacion" name="grado_realizacion" autocomplete="nope">
                      <option selected disabled value="">Elija una opción</option>
                      <option value="de_tentetiva">DE TENTATIVA</option>
                      <option value="consumado">CONSUMADO</option>
                      <option value="por_definir">POR DEFINIR</option>
                  </select>
                </div>
              </div> 
            </div>
            <h5 class="lh-3 mg-b-20 mg-t-20 tx-inverse hover-primary">Delito Imputable a:</h5>
            <ul id="listaImputados"></ul>
          </div><!-- modal-body -->
          <div class="modal-footer d-flex">
            <button type="button" class="btn btn-secondary d-block cerrar-modal"  data-modal="modal-nueva-solicitud" data-thismodal="modalAgregarDelito">Cancelar</button>
            <button type="button" class="btn btn-primary d-block ml-auto" id="guardarDelito">Guardar</button>
          </div>
        </div>
      </div><!-- modal-dialog -->
    </div><!-- modal -->

    <div id="modal-acuse" class="modal fade" data-keyboard="false">
      <div class="modal-dialog modal-dialog-vertical-center modal-xl" role="document" style="min-width: 70%;">
        <div class="modal-content bd-0 tx-14" >
          <div class="modal-header">
              <h6 class="tx-12 mg-b-0 tx-uppercase tx-inverse tx-bold">Documentos</h6>
              <button type="button" class="close ml-auto" data-dismiss="modal" aria-label="Close">
                  <span aling="right" aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body" style="text-align: center;">
              <div class="row">
                  <div class="col-md-12" id="visorPDFacuse">

                  </div>
              </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
@endsection
