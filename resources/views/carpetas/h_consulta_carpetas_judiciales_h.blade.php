@php
  use App\Http\Controllers\clases\humanRelativeDate;
  use App\Http\Controllers\clases\utilidades;
  $humanRelativeDate = new humanRelativeDate();
@endphp
@extends('layouts.index') 

@section('contenido-pageheader')
  <ol class="breadcrumb slim-breadcrumb">
    <li class="breadcrumb-item"><a href="/home">Home</a></li>
    <li class="breadcrumb-item"><a href="#">Administracion</a></li>
    <li class="breadcrumb-item active" aria-current="page">Administracion Carpetas Judiciales</li>
  </ol>
  <h6 class="slim-pagetitle">Administracion de carpetas judiciales</h6>
@endsection
@section('contenido-principal')
  <div class="section-wrapper mg-b-100">
    @if(false){{-- @if(!utilidades::buscarPermisoMenu($request->menu_general['response'], 4, 0)) --}}
      <h1 class="mg-b-50">No tiene permiso para acceder a esta sección, verifíquelo con su titular</h1>
      <a href="/home"><button class="btn btn-primary btn-block">Regresar al inicio</button><a>
    @else
			<div class="form-layout mg-b-25">
				<div id="accordion" class="accordion-one" role="tablist" aria-multiselectable="true">
					<div class="card">
						<div class="card-header" role="tab" id="headingOne">
							<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" class="tx-gray-800 transition collapsed">
                <i class="fa fa-search" aria-hidden="true"></i> 
							</a>
						</div><!-- card-header -->
						<div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne">
							<div class="card-body">
									<div class="row mg-b-15">
                    <div class="col-lg-3">
                      <div class="form-group mg-b-10-force">
                        <label class="form-control-label">Carpeta Investigacion:</label>
                        <input class="form-control" type="text" name="carpeta_inv" id="carpetaInvestigacion"  autocomplete="off">
                      </div>
                    </div><!-- col-3 -->
                    <div class="col-lg-3">
                      <div class="form-group mg-b-10-force">
                        <label class="form-control-label">Carpeta Judicial:</label>
                        <input class="form-control" type="text" name="folioCarpeta" id="folioCarpeta"  autocomplete="off">
                      </div>
                    </div><!-- col-3 -->
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="form-control-label">Desde:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                </div>
                            </div>
                            <input type="text" class="form-control fc-datepicker" placeholder="DD/MM/AAAA" id="fechaAsignacionMin" name="fecha_asiganacion_min" autocomplete="off">
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="form-control-label">Hasta:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                </div>
                            </div>
                            <input type="text" class="form-control fc-datepicker" placeholder="DD/MM/AAAA" id="fechaAsignacionMax" name="fecha_asignacion_max" autocomplete="off">
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group mg-b-10-force">
                        <label class="form-control-label">Tipo Carpeta:</label>
                        <select class="form-control select2" id="tipoCarpeta" name ="tipoCarpeta">
                          <option value="-" selected>Todas</option>
                          <option value="1">Carpeta de Control</option>
                          <option value="2">Carpeta de Exhorto</option>
                          <option value="3">Carpeta de Amparo</option>
                          <option value="4">Carpeta de Apelación</option>
                          <option value="5">Carpeta de Tribunal enjuiciamiento</option>
                          <option value="6">Carpeta de Ejecución</option>
                          <option value="7">Cuadernillos (Unidad Ejecución)</option>
                          <option value="8">Carpeta Judicial de Alzada</option>
                          <option value="9">Cuadernillo Ley Nacional</option>
                          <option value="10">Carpeta de Ley Mujeres Libre de Violencia</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group mg-b-10-force">
                        <label class="form-control-label">Nombre(s):</label>
                        <input class="form-control" type="text" name="nombres" id="nombres"  autocomplete="off">
                      </div>
                    </div><!-- col-3 -->
                    <div class="col-lg-3">
                      <div class="form-group mg-b-10-force">
                        <label class="form-control-label">Apellido Paterno:</label>
                        <input class="form-control" type="text" name="apellidoPaterno" id="apellido_paterno"  autocomplete="off">
                      </div>
                    </div><!-- col-3 -->
                    <div class="col-lg-3">
                      <div class="form-group mg-b-10-force">
                        <label class="form-control-label">Apellido Materno:</label>
                        <input class="form-control" type="text" name="apellidoMaterno" id="apellido_materno"  autocomplete="off">
                      </div>
                    </div><!-- col-3 -->
									</div>
									<div class="row col-lg-15">
										<div class="col-lg-12 d-flex">
											<button class="btn btn-primary mg-l-auto " onclick="buscar(1)">Buscar</button>
										</div>
									</div>
							</div><!-- card-bod -->
						</div>
					</div>
				</div><!-- accordion -->
			</div>
			<div class="row">
				<div class="col-lg-12">
          
					<table id="tableCarpetas" class="dataTable dtr-inline collapsed" style="overflow-x: auto; padding-left:0; padding-rigth:0; display:table;">
						<thead style="background-color: #EBEEF1; color: #000;">
              <th class="acciones">Acciones</th>
							<th class="carpeta">Tipo de Carpeta</th>
              <th class="folio">Carpeta Judicial</th>
              <th class="carpeta_inv">Carpeta Inv</th>
              <th class="fecha">Creación</th>
              <th class="situacion">Situación</th>
              <th class="tipo_solicitud">T. Solicitud</th>
              <th class="involucrados">Involucrados</th>
              <th class="delitos">Delitos</th>
						</thead>
						<tbody id="bodyCarpetas">

						</tbody>
					</table>
          <div class="pagination-wrapper justify-content-between">
            <ul class="pagination mg-b-0">
              <li class="page-item">
                <a class="page-link primera" href="javascript:void(0)" aria-label="Last" onclick="buscar(1)">
                  <i class="fa fa-angle-double-left"></i>
                </a>
              </li>
              <li class="page-item">
                <a class="page-link anterior" href="javascript:void(0)" aria-label="Next" onclick="buscar(1)">
                  <i class="fa fa-angle-left"></i>
                </a>
              </li>
            </ul>

            <ul class="pagination mg-b-0">
              <li class="page-item">Página <span class="pagina">1</span> de <span class="total-paginas">1</span></li>
            </ul>

            <ul class="pagination mg-b-0">
              <li class="page-item">
                <a class="page-link siguiente" href="javascript:void(0)" aria-label="Next" onclick="buscar(1)">
                  <i class="fa fa-angle-right"></i>
                </a>
              </li>
              <li class="page-item">
                <a class="page-link ultima" href="javascript:void(0)" aria-label="Last" onclick="buscar(1)">
                  <i class="fa fa-angle-double-right"></i>
                </a>
              </li>
            </ul>
          </div>
				</div>
			</div>
    @endif
  </div>
@endsection
@section('seccion-estilos')
  <link rel="stylesheet" type="text/css" href="{{asset("/css/dropzone.min.css")}}">
  <link href="{{asset("/lib/datatables/css/jquery.dataTables.css")}}" rel="stylesheet">


  <!-- estilos para linea del tiempo -->
  <link rel="stylesheet" href="/box/scheduler/codebase/dhtmlxscheduler_material.css?v=5.3.8" type="text/css" charset="utf-8">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="/box/scheduler/samples/common/controls_styles.css?v=5.3.8">
  <link href="{{ $entorno["version_pages"]["version"] }}/lib/jt.timepicker/css/jquery.timepicker.css" rel="stylesheet">
  <link href="{{ $entorno["version_pages"]["version"] }}/lib/select2/css/select2.min.css" rel="stylesheet">
  
  <!-- estilos para editor de texto -->
  <link rel="stylesheet" href="/box/froala_editor_3.1.1/css/froala_editor.css">
  <link rel="stylesheet" href="/box/froala_editor_3.1.1/css/froala_style.css">
  <link rel="stylesheet" href="/box/froala_editor_3.1.1/css/plugins/code_view.css">
  <link rel="stylesheet" href="/box/froala_editor_3.1.1/css/plugins/colors.css">
  <link rel="stylesheet" href="/box/froala_editor_3.1.1/css/plugins/emoticons.css">
  <link rel="stylesheet" href="/box/froala_editor_3.1.1/css/plugins/image_manager.css">
  <link rel="stylesheet" href="/box/froala_editor_3.1.1/css/plugins/image.css">
  <link rel="stylesheet" href="/box/froala_editor_3.1.1/css/plugins/line_breaker.css">
  <link rel="stylesheet" href="/box/froala_editor_3.1.1/css/plugins/quick_insert.css">
  <link rel="stylesheet" href="/box/froala_editor_3.1.1/css/plugins/table.css">
  <link rel="stylesheet" href="/box/froala_editor_3.1.1/css/plugins/file.css">
  <link rel="stylesheet" href="/box/froala_editor_3.1.1/css/plugins/char_counter.css">
  <link rel="stylesheet" href="/box/froala_editor_3.1.1/css/plugins/video.css">
  <link rel="stylesheet" href="/box/froala_editor_3.1.1/css/plugins/emoticons.css">
  <link rel="stylesheet" href="/box/froala_editor_3.1.1/css/plugins/fullscreen.css">
  
  <style>
    .modal {
      overflow-y: auto !important;
    }
    .select2-container.select2-container--default.select2-container--open{
			z-index: 1050;
		}
		.ui-datepicker.ui-widget.ui-widget-content.ui-helper-clearfix.ui-corner-all{
			z-index: 1050 !important;
		}
    .carpeta{
      min-width: 101px !important;
    }
    .folio{
      min-width: 130px !important;
    }
    .fecha{
      min-width: 75px !important;
    }
    .situacion{
      min-width: 60px !important;
    }
    .tipo_solicitud{
      min-width: 100px !important;
    }
    .involucrados{
      min-width: 170px !important;
    }
    .delitos{
      min-width: 190px !important;
    }
    td.tipo_audiencia{
      text-transform: uppercase;
    }
    .acciones{
      min-width: 110px !important;
    }
    .carpeta_inv{
      min-width: 120px !important;
    }
    td.acciones{
      font-size: 16px !important;
    }

    #tableCarpetas{
      display:table;
      margin-bottom: 15px;
      margin-top: 15px;
    }
    #tableCarpetas td,#tableCarpetas th{
      padding:12px !important;
    }
    div.modal-body i.tx-success{
      color: #23BF08 !important;
    }
    .pagination-wrapper{
      height: 50px !important;
    }

    table.tableDatosSujeto  td, table.tableDatosSujeto th{
      border: 1px solid #EEE;
      vertical-align: text-top;
      padding: 5px;
    }

    table.tableDatosSujeto2  td, table.tableDatosSujeto2 th{
      border: 1px solid #EEE;
      vertical-align: text-top;
      padding: 5px;
      width: 33%;
    }
    table.tableDatosSujeto tbody.table-datos-sujeto tr td:nth-child(2n-1){
      background-color: #f8f9fa;
    }
    table.tableDatosSujeto tbody.table-datos-sujeto tr td{
      width: 25%;
    }
    table.tableDatosSujeto2 thead tr:first-child{
      background-color: #f8f9fa;
    }

    /* div.modalAdministracion-body{
      min-width: 1600px;
    } */
 
    .modal-dialog-xxl{
      min-width: 90%;
      max-width: 90%;
      /*
      min-height: 90%;
      max-height: 800px !important;
      overflow-x: auto;
      */
    }

    div.modalRemision-body{
      /* min-width: 90% !important; */
      min-width: 1400px;
    }

    /* div.modalAdministracion-content{
      min-height: 800px;
    } */
    div.modalRemision-content{
      min-height: 700px;
    }
    
    .tx-secondary {
      color: #727C2E !important;
    }

    /* toggle con apariencia de boton */
    .bkg-collapsed-btn{
      background-color: #b0b781 !important;
    }

    .bkg-collapsed-btn-hover {
      background-color: #fff !important;
      color: #848961 !important; 
      border: 2px solid #848961 !important;
      /* background-color: #848961  !important; */
    }

    .bkg-collapsed-btn-hover:hover{
      /* background-color: #fff !important;
      color: #848961 !important; 
      border: 2px solid #848961 !important; */
      background-color: #848961  !important;
      color: #ffffff !important; 
    }

    .bkg-collapsed-btn-edit {
      /* background-color: #FF5733 !important; */
      background-color: #f5755a !important;
    }

    .tx-white {
      color: #ffffff !important;
    }

    table .fas, .far {
      background: #848F33 ;
      padding: 5px 5px;
      border-radius: 25%;
      color: #fff;
    }

    .row{
      /*PARA QUE SELECT NO SALGA DE ROW POR SER MUY LARGO  */
      overflow: hidden;
    }

    .dhx_cal_event_line{
      background: #848961;
    }

    .timeline_scalex_class{
      min-width:40px !important;
      max-width:41px !important;
    }

    .td-title{
      background:#f8f9fa;
    }

    @media only screen and (max-width: 1700px) {
      #tableCarpetas{
        display: table;
      }
      /* div.modalAdministracion-body{
        max-width: 900px !important;
      } */
    } 
    @media (min-width: 992px){
      .modal-lg.xl {
          max-width: 1017px;
      }

      div.modalRemision-body{
        max-width: 900px !important;
      }

      .labelTipoRemision{
        font-family: "Roboto", "Helvetica Neue", Arial, sans-serif;
        font-size: 1.875rem;
        font-weight: 400;
        line-height: 1.5;
        color: #848F33 ;
        text-align: left;
      }

     .formularioRemision{
        max-width: 60% !important;
      }
      textarea{
        background-color: white  !important;
        min-height: 100px !important;
        width: 100% !important;
      }

      #tableCarpetas{
        display: block;
      }
    }
    
  </style>
@endsection

@section('seccion-scripts-libs') 
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

  <!-- SCRIPTS para linea de tiempo -->
  <script src="/box/scheduler/codebase/dhtmlxscheduler.js?v=5.3.8" charset="utf-8"></script>
  <script src="/box/scheduler/codebase/ext/dhtmlxscheduler_limit.js?v=5.3.8" charset="utf-8"></script>
  <script src="/box/scheduler/codebase/ext/dhtmlxscheduler_agenda_view.js?v=5.3.8" charset="utf-8"></script>
  <script src='/box/scheduler/codebase/ext/dhtmlxscheduler_timeline.js?v=5.3.8' type="text/javascript" charset="utf-8"></script>
  <script src='/box/scheduler/codebase/ext/dhtmlxscheduler_treetimeline.js?v=5.3.8' type="text/javascript" charset="utf-8"></script>
  <script src="/box/scheduler/codebase/ext/dhtmlxscheduler_minical.js?v=5.3.8" type="text/javascript" charset="utf-8"></script>
  <script src="/box/scheduler/codebase/ext/dhtmlxscheduler_units.js?v=5.3.8" type="text/javascript" charset="utf-8"></script>
  <script src="/box/scheduler/codebase/ext/dhtmlxscheduler_week_agenda.js?v=5.3.8" type="text/javascript" charset="utf-8"></script>

  <!--- scripts para editor de texto en linea -->
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/froala_editor.min.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/froala_editor.pkgd.min.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/align.min.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/code_beautifier.min.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/code_view.min.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/colors.min.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/emoticons.min.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/draggable.min.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/font_size.min.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/font_family.min.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/image.min.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/image_manager.min.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/line_breaker.min.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/quick_insert.min.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/link.min.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/lists.min.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/paragraph_format.min.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/paragraph_style.min.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/video.min.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/table.min.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/url.min.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/emoticons.min.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/file.min.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/entities.min.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/inline_style.min.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/save.min.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/fullscreen.min.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/languages/es.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/quote.min.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/char_counter.min.js"></script>

  <script src="{{ $entorno["version_pages"]["version"] }}/lib/jt.timepicker/js/jquery.timepicker.js"></script>
  <script src="{{ $entorno["version_pages"]["version"] }}/lib/select2/js/select2.min.js"></script>
@endsection

@section('seccion-scripts-functions')
  <script>
    const expRegFecha=/^([0-2][0-9]|3[0-1])(-)(0[1-9]|1[0-2])\2(\d{4})$/,
          expRegHora=/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/;
          guardias=[];
    let arrPersonas;
    var arrCarpetasJudiciales=[];
    var carpetaActiva=null;

    $(document).ready(function() {
      buscar(1);
    
      setTimeout(function(){ loadConfigComponentsPP(); }, 300);
      setTimeout(function(){ loadConfigComponentsDA(); }, 300);
      setTimeout(function(){ loadConfigComponentLT(); }, 300);
      setTimeout(function(){ loadConfigComponentsDG(); }, 300);
      setTimeout(function(){ $('#modal_loading').modal('hide'); }, 1000);
    });
		
    $(function(){
      'use strict'
      $('.ui-datepicker-year').addClass('select2');
      
      // Datepicker
      $('.fc-datepicker').datepicker({
          
          showOtherMonths: true,
          selectOtherMonths: true,
          format: 'dd/mm/yyyy',
          changeYear: true,
          yearRange: "c-100:c+0"
      });

      $('#datepickerNoOfMonths').datepicker({
          showOtherMonths: true,
          selectOtherMonths: true,
          numberOfMonths: 2
          
      });

    });
    
    $(function(){
      'use strict'

      Toggles
      $('.toggle').toggles({
        on: false,
        height: 26
      });

      // Input Masks
      $('#dateMask').mask('99/99/9999');
      $('#phoneMask').mask('(999) 999-9999');
      $('#ssnMask').mask('999-99-9999');

      // Time Picker
      $('#tpBasic').timepicker();
      $('#tp2').timepicker({'scrollDefault': 'now'});
      $('#horaInicio').timepicker();
			$('#horaFin').timepicker();

      $('#setTimeButton').on('click', function (){
        $('#horaRecepcion').timepicker('setTime', new Date());
      });

      // Color picker
      $('#colorpicker').spectrum({
        color: '#17A2B8'
      });

      $('#showAlpha').spectrum({
        color: 'rgba(23,162,184,0.5)',
        showAlpha: true
      });

      $('#showPaletteOnly').spectrum({
          showPaletteOnly: true,
          showPalette:true,
          color: '#DC3545',
          palette: [
              ['#1D2939', '#fff', '#0866C6','#23BF08', '#F49917'],
              ['#DC3545', '#17A2B8', '#6610F2', '#fa1e81', '#72e7a6']
          ]
      });

      //acuerdos reparatorios
      $("#acuerdoPDF").on('input',function () {
        leeDocumentoAcuerdoR(this);
        $('#divViewDocumentosAcuerdo').css('display', 'block');
        $('#col_nombre_documento_acuerdo').css('display', 'block');   
      });

      //mandamiento
      $("#mandamientoPDF").on('input',function () {
        leeDocumentoMandamiento(this);
        $('#divViewDocumentosMandamiento').css('display', 'block');
        $('#col_nombre_documento_mandamiento').css('display', 'block');   
      });
    });


		function buscar(pagina){
      
      arrCarpetasJudiciales=[];

			$.ajax({
				method:'POST',
				url:'/public/obtener_carpetas_judiciales',
				data:{
					modo:"completo",
          carpeta_inv:$('#carpetaInvestigacion').val(),
          fecha_asignacion_min:$('#fechaAsignacionMin').val(),
          fecha_asignacion_max:$('#fechaAsignacionMax').val(),
          folio_carpeta:$('#folioCarpeta').val(),
          carpeta_judicial:$('#carpetaJudicial').val(),
          tipo_carpeta:$("#tipoCarpeta").val(),
          nombre:$('#nombre').val(),
          apellido_paterno:$('#apellidoPaterno').val(),
          apellido_materno:$('#apellidoMaterno').val(),
          pagina,
				},
				success:function(response){
					$('#bodyCarpetas').html('');
					if(response.status==100){
            // guardias=response.response;
            console.log(response);
						$(response.response).each(function(index, carpeta_judicial){
							const {nombre_tipo_carpeta,folio_carpeta,fecha_creacion,situacion_carpeta,tipo_solicitud_, imputados, victimas, delitos, id_carpeta_judicial, carpeta_investigacion}=carpeta_judicial;
              let lIimputados='',
                  lVictimas='',
                  lDelitos='';

              arrCarpetasJudiciales[id_carpeta_judicial]=carpeta_judicial;

              if(imputados.length){
                lIimputados=lIimputados.concat('<h6 class="mg-b-0">Imputados</h6>');
                $(imputados).each(function(index, imputado){
                  lIimputados=lIimputados.concat(`<div class="b-l-2">${imputado.razon_social==null?'':imputado.razon_social}${imputado.nombre==null?'':imputado.nombre}</div>`);
                });
              }

              if(victimas.length){
                lVictimas=lVictimas.concat('<h6 class="mg-b-0">Víctimas</h6>');
                $(victimas).each(function(index, victima){
                  lVictimas=lVictimas.concat(`<div class="b-l-2">${victima.razon_social==null?'':victima.razon_social}${victima.nombre==null?'':victima.nombre}</div>`);
                });
              }

              if(delitos.length){
                $(delitos).each(function(index, delito){
                  lDelitos=lDelitos.concat(`<div class="b-l-2">${delito.delito}</div>`);
                });
              }

              fechaCreacion='';
              if(fecha_creacion!=null){
                const fCrea=fecha_creacion.split(' ')[0].split('-');
                fechaCreacion=fCrea[2]+'-'+fCrea[1]+'-'+fCrea[0];
              }
              
							const tr=`<tr>
                          <td class="acciones">
                            <i class="icon ion-folder" data-toggle="tooltip-primary" data-placement="top" title="Administrar Carpeta" onclick="abrirModalAdministracion(${id_carpeta_judicial})"></i>
                            <i class="icon fa fa-trash" data-toggle="tooltip-primary" data-placement="top" title="Borrar Carpeta" onclick="abrirModalBorrarCJ(${id_carpeta_judicial})"></i>
                            <!-- <i class="icon ion-person-stalker" data-toggle="tooltip-primary" data-placement="top" title="Sujetos Procesales" onclick="verPersonas(${id_carpeta_judicial})"></i> -->
                            <i class="icon ion-ios-information" title="Remitir Carpeta Judicial" style="cursor: pointer" onclick="abrirModalRemision('${id_carpeta_judicial}')" id="reenvioCarpeta"></i> 
                          </td>
                          <td class="carpeta tx-uppercase">${nombre_tipo_carpeta==null?'':nombre_tipo_carpeta}</td>
                          <td class="folio">${folio_carpeta==null?'':folio_carpeta}</td>
                          <td class="carpeta_inv">${carpeta_investigacion==null?'':carpeta_investigacion}</td>
                          <td class="fecha">${fechaCreacion}</td>
                          <td class="situacion tx-uppercase">${situacion_carpeta==null?'':situacion_carpeta}</td>
                          <td class="tipo_solicitud">${tipo_solicitud_==null?'':tipo_solicitud_}</td>
                          <td class="involucrados d-block"><span>${lIimputados}</span><span>${lVictimas}</span></td>
                          <td class="delitos">${lDelitos}</td>
							 					<tr>`;
							$('#bodyCarpetas').append(tr);
						});

            const anterior=pagina==1?1:pagina-1,
                  totalPaginas=response.response_pag.paginas_totales,
                  siguiente=pagina+1>=totalPaginas?totalPaginas:pagina+1;
            
            $('.anterior').attr('onclick',`buscar(${anterior})`);
            $('.pagina').html(pagina);
            $('.total-paginas').html(totalPaginas);
            $('.siguiente').attr('onclick',`buscar(${siguiente})`);
            $('.ultima').attr('onclick',`buscar(${totalPaginas})`);

					}else{
						const tr=`<tr>
													<td class="unidad tx-center tx-danger" colspan="8">Sin Datos Relacionados</td>
													<td class="d-none"></td>
													<td class="d-none"></td>
													<td class="d-none"></td>
                          <td class="d-none"></td>
                          <td class="d-none"></td>
                          <td class="d-none"></td>
                          <td class="d-none"></td>
												<tr>`;
							$('#bodyCarpetas').append(tr);

              $('.anterior').attr('onclick',`buscar(1)`);
              $('.pagina').html('1');
              $('.total-paginas').html('1');
              $('.siguiente').attr('onclick',`buscar(1)`);
              $('.ultima').attr('onclick',`buscar(1)`);

					}
          
				}
			});
		}

    function abrirModalAdministracion( id_carpeta_judicial ){
      carpetaActiva = null;
      carpetaActiva = arrCarpetasJudiciales[id_carpeta_judicial];
      let titulo = 'CARPETA JUDICIAL : '+arrCarpetasJudiciales[id_carpeta_judicial].folio_carpeta;
      $("#lbl-titulo-modal-administracion").text( titulo );
      $("#id_carpeta_judicial").val( id_carpeta_judicial );
      $("#id_solicitud").val( arrCarpetasJudiciales[id_carpeta_judicial].id_solicitud );
      $("#tipo_solicitud").val( arrCarpetasJudiciales[id_carpeta_judicial].tipo_solicitud_ );
      
      //loading(true);
      $.ajax({
        method:'POST',
        url:'/public/sincronizacion_carpeta',
        async:false,
        data:{ id_solicitud : carpetaActiva.id_solicitud, },
        success:function(response){
          console.log('RESPUESTA SINCRONIZACIÓN CJ :',response);
          loading(false);
        },
        error: function(request, status, error){
          console.log(request, status, error);
          loading(false);
        },
      }); // ajax

      $("#modalAdministracion").modal('show');

      pintarAudiencias();
      pintarDocumentosAsociados();
      pintarPersonas();
      pintarDelitosSinRelacionar();
      pintarEventosLT();
      pintarDocumentosGenerados();
      pintarOficiosEnviadosUSMC();

      //pintarCHR();
      $("#tipoPlantilla").val('-').change();
      cancelarEdicionDG();
      cargaUsuarios();
      obtenerAudenciasDGVP();
    }

    function abrirModalBorrarCJ( id_carpeta_judicial ){
      carpetaActiva = arrCarpetasJudiciales[id_carpeta_judicial];
      let titulo = 'CARPETA JUDICIAL A BORRAR: '+carpetaActiva.folio_carpeta;
      $("#id_carpeta_borrar").val(carpetaActiva.id_carpeta_judicial);
      $("#id_unidad_redireccion").val('-').trigger('change');
      $("#motivo_redireccion").empty();
      $("#modalBorrarCJ").modal('show');
    }

    function borrarCarpetaJudicial(){
      $("#modalBorrarCJ").modal('hide');
      $.ajax({
        method:'POST',
        url:'/public/borrar_carpeta_judicial',
        data:{
          carpeta:carpetaActiva.id_carpeta,
          id_unidad_redireccion:$("#id_unidad_redireccion").val(),
          motivo_redireccion:$("#motivo_redireccion").val(),
        },
        success:function(response){
          console.log('RESPUESTA BORRAR CJ :',response);
          if(response.status==100){

          }else{
            modal_error(response.message);
          }
        } // success
      }); // ajax
    }

    function loading(accion){
      if(accion){
        $('#modal_loading').modal('show');
      }else{
        setTimeout(function(){ $('#modal_loading').modal('hide'); }, 500);
      }
    }

    $(".cerrar-modal").click(function(){
      let modalOpen = $(this).attr('data-modal');
      let modalClose = $(this).attr('data-thismodal');
      //console.log(modalOpen,modalClose);
      $("#"+modalClose).modal('hide');
      if( modalOpen.length ) setTimeout(function(){ $("#"+modalOpen).modal('show'); }, 500); 
    });

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

    function modal_confirm(title,body,fn=null,modalAnterior=null){

      if(body=='borrar_documento'){
        body = `
          <div class="row">
            <div class="col-lg-12">
              <div class="form-group">
                <label class="form-control-label">Ingrese los motivos por los que desea remover este documento:</label>
                <textarea class="form-control" name="motivo_remover_documento" id="motivoRemoverDocumento" rows="4"></textarea>
              </div>
            </div>
          </div>
        `;
      }else if( body=='enviar_documento' ){
        body = `
          <div class="row">
            <div class="col-lg-12">
              <div class="form-group">
                <label class="form-control-label">Turnar documento </label>
                <label class="form-control-label">Comentarios Adicionales </label>
                <textarea class="form-control" name="comentariosAdicionalesEnvioDocumento" id="comentariosAdicionalesEnvioDocumento" rows="4"></textarea>
              </div>
            </div>
          </div>
        `;
      }

      $("#tituloModalConfirm").html(''); 
      $("#bodyModalConfirm").empty();
      $("#btnAceptarModalConfirm").removeAttr( "onClick" );

      $("#tituloModalConfirm").html(title);       
      $("#bodyModalConfirm").append(body);
      if( fn!=null ) $("#btnAceptarModalConfirm").attr('onClick',fn);
     
      if( modalAnterior ) $('#'+modalAnterior).modal('hide');
      
      $('#btnCancelarModalConfirm').attr('data-modal',modalAnterior!=null?modalAnterior:'');
      $("#modalConfirm").modal('show');       
    }

    function modal_historial(title,body,modalAnterior=null){
      $("#tituloModalHistory").html(''); 
      $("#bodyModalHistory div").remove();

      $("#tituloModalHistory").html(title);       
      $("#bodyModalHistory").append(body);

      if( modalAnterior ) $('#'+modalAnterior).modal('hide');
      $('.btnCerrarModalHistory').attr('data-modal',modalAnterior!=null?modalAnterior:'');
      //$('#btnCerrarModalHistory').attr('data-modal',modalAnterior!=null?modalAnterior:'');
      $("#modalHistory").modal('show');       
    }

    function modal_detalle(title,body,modalAnterior=null){
      $("#tituloModalDetalle").html(''); 
      $("#bodyModalDetalle div").remove();
      $("#bodyModalDetalle").empty();

      $("#tituloModalDetalle").html(title);       
      $("#bodyModalDetalle").append(body);

      if( modalAnterior ) $('#'+modalAnterior).modal('hide');
      //$('#btnCerrarModalDetalle').attr('data-modal',modalAnterior!=null?modalAnterior:'');
      $('.btnCerrarModalDetalle').attr('data-modal',modalAnterior!=null?modalAnterior:'');
      $("#modalDetalle").modal('show');     
    }

    function get_unique_id(){
      var date = new Date();
      return date.getHours()+''+date.getMinutes()+''+date.getSeconds()+''+date.getMilliseconds();;
    }

    function get_fecha_letra(fecha, options=null){
      fl = new Date(fecha);
      options = options?? { year: 'numeric', month: 'long', day: 'numeric' };

      return fl.toLocaleDateString("es-ES", options);
    }



//REMISION DE CARPETA
    function abrirModalRemision( id_carpeta_judicial ){

      //  let titulo = 'REMITIR LA CARPETA JUDICIAL : '+id_carpeta_judicial;

        let titulo = 'REMITIR LA CARPETA JUDICIAL : '+arrCarpetasJudiciales[id_carpeta_judicial].folio_carpeta;
        $("#lbl-titulo-modal-remision").text( titulo );

            //TIPO PROMOCION
            document.getElementById("tipoRemision").onchange = function(){

        let formularioRemision="";
        $("#formularioRemision").val("");
        if($("#tipoRemision").val() == "incompetencia") {

          $("#labelTipoRemision").html(" ENVIO DE CARPETA JUDICIAL POR INCOMPETENCIA");
          let formularioRemision="";
          console.log("incompentencia");

        formularioRemision  = `
        <div class="col-lg-2">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">Carpeta Judicial a Remitir:</label>
                      <input class="form-control" type="text" name="carpeta_a_remitir" id="carpetaARemitir" value="`+arrCarpetasJudiciales[id_carpeta_judicial].folio_carpeta+`" placeholder="N/E" autocomplete="off" disabled="">
                    </div>
                  </div>

                  <div class="col-lg-3">
                    <div class="form-group">
                        <label class="form-control-label">Motivo de la incompetencia:</label>
                        <select class="form-control select2" id="tipoRemision" name="tipo_remision" autocomplete="off">
                            <option selected value="">Seleccione una Opción</option>
                          <option value="otramateria">Pertenece a otra materia</option>
                          <option value="vinculacionproceso">Por vinculación a proceso</option>
                          <option value="violenciagenero">Por turno extraodinario violencia de género</option>
                          <option value="mandatozona">Por mandato judicial - zona territorial</option>
                          <option value="otro">Otro</option>
                        </select>
                      </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group" id="materiaDestino">
                          <label class="form-control-label mg-t-20"><strong>Materia Destino: </strong><span class="tx-danger">*</span></label>
                          <div class="d-inline-block mg-l-10">
                            <label class="rdiobox d-inline-block mg-l-5">
                              <input name="materia_destino" type="radio" value="adultos">
                              <span class="pd-l-0">Penal Adultos</span>
                            </label>
                            <label class="rdiobox d-inline-block mg-l-5">
                              <input name="materia_destino" type="radio" value="adolescentes">
                              <span class="pd-l-0">Penal Adolescentes</span>
                            </label>
                          </div>
                        </div>
                      </div>

                      <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label">Fiscalía: <span class="tx-danger">*</span></label>
                      <select class="form-control select2" id="fiscalia" name="fiscalia" autocomplete="off">
                          <option selected disabled  value="">Elija una opción</option>
                          @foreach ($fiscalias as $fiscalia)
                              <option value="{{$fiscalia['id_fiscalia']}}">{{$fiscalia['fiscalia']}}</option>
                          @endforeach
                      </select>
                    </div>
                  </div><!-- col-4-->

                  <div class="col-lg-3">
                    <div class="form-group">
                        <label class="form-control-label">Tipo de unidad destino:</label>
                        <select class="form-control select2" id="tipoUnidadDestino" name="tipo_unidad_destino" autocomplete="off">
                            <option selected value="">Seleccione una Opción</option>
                          <option value="">Unidad especializada en Aprehensiones, Cateos y Técnicas de Investigacion</option>
                          <option value="">Unidad especializada en delitos de Oficio</option>
                          <option value="">Unidad especializada en delitos de Querella</option>
                          <option value="">PUnidad especializada en Mujeres</option>
                        </select>
                      </div>
                    </div>


                  <div class="col-lg-4">
                        <div class="form-group" id="privadoLibertadDiv">
                          <label class="form-control-label mg-t-20"><strong>¿El imputado se encuentra privado de su libertad?: </strong><span class="tx-danger">*</span></label>
                          <div class="d-inline-block mg-l-10">
                            <label class="rdiobox d-inline-block mg-l-5">
                              <input name="privado_libertad" type="radio" value="si">
                              <span class="pd-l-0">Si</span>
                            </label>
                            <label class="rdiobox d-inline-block mg-l-5">
                              <input name="privado_libertad" type="radio" value="no">
                              <span class="pd-l-0">No</span>
                            </label>
                          </div>
                        </div>
                      </div>

                      <div class="col-lg-3">
                    <div class="form-group">
                        <label class="form-control-label">Lugar de internamiento:</label>
                        <select class="form-control select2" id="lugarInternamiento" name="lugar_internamiento" autocomplete="off">
                            <option selected value="">Seleccione una Opción</option>
                            <option value="00020005">Centro de Ejecución de Sanciones Penales Varonil Norte</option>
                            <option value="00020006">Centro de Ejecución de Sanciones Penales Varonil Oriente</option>
                            <option value="00020010">Centro de Reinserción Social Varonil (CERESOVA)</option>
                            <option value="00020009">Centro Femenil de Reinserción Social (Tepepan)</option>
                            <option value="00020014">Centro Preventivo y de Reinserción Social Chalco</option>
                            <option value="00020004">Centro Varonil de Rehabilitación Psicosocial (CEVAREPSI)</option>
                            <option value="00020011">Centro Varonil de Seguridad Penitenciaria I (CEVASEP I)</option>
                            <option value="00020012">Centro Varonil de Seguridad Penitenciaria II (CEVASEP II)</option>
                            <option value="00020013">Institución Abierta Casa de Medio Camino</option>
                            <option value="00020007">Penitenciaría de la Ciudad de México</option>
                            <option value="00020008">Centro Femenil de Reinserción Social (Santa Martha)</option>
                            <option value="00020001">Reclusorio Preventivo Varonil Norte</option>
                            <option value="00020002">Reclusorio Preventivo Varonil Oriente</option>
                            <option value="00020003">Reclusorio Preventivo Varonil Sur</option>                
                            </select>
                      </div>
                    </div>

                    <div class="col-lg-3">
                    <div class="form-group">
                        <label class="form-control-label">Edificio/reclusorio receptor:</label>
                        <select class="form-control select2" id="edificioReceptor" name="edificio_receptor" autocomplete="off">
                            <option selected value="">Seleccione una Opción</option>
                            <option value="7">Reclusorio Preventivo Varonil Norte</option>
                            <option value="8">Reclusorio Preventivo Varonil Oriente</option>
                            <option value="9">Reclusorio Preventivo Varonil Sur</option>
                            <option value="10">Centro Femenil de Reinserción Social (Santa Martha)</option>
                            <option value="5">Dr. Lavista</option>
                            <option value="4">Sullivan</option>
                            </select>
                      </div>
                    </div>


                    <div class="col-lg-12">
                      <div class="form-group">
                        <label class="form-control-label">Comentarios Adicionales</label>
                      
                        <th colspan="100%">
                          <textarea id="comentariosAdicionales" rows="2"  ></textarea>
                          </th>
                      </div>
                    </div><!-- col-9 -->

              

                

        `;

          $("#formularioRemision").html(formularioRemision);
          $("#formularioRemision").css("display", "");

        /*   $("#carpetaJudicialAsociada").val('');

            $("#divReferida").css("display", "block");
            $("#divAsociada").css("display", "none"); */

          // var divIncompetencia=
        }
        else if ($("#tipoRemision").val() == "enjuiciamiento") {
          console.log("enjuiciamiento");
          let formularioRemision="";
          formularioRemision  = `
          <div class="col-lg-2">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">Carpeta Judicial a Remitir:</label>
                      <input class="form-control" type="text" name="carpeta_a_remitir" id="carpetaARemitir" value="`+arrCarpetasJudiciales[id_carpeta_judicial].folio_carpeta+`" placeholder="N/E" autocomplete="off" disabled="">
                    </div>
                  </div>

                  <div class="col-lg-3">
                    <div class="form-group">
                        <label class="form-control-label">Fecha de la audiencia en la cual se determina la vinculación a Juicio Oral:</label>
                        <select class="form-control select2" id="fechaAudiencia" name="fecha_audiencia" autocomplete="off">
                            <option selected value="">Seleccione una Opción</option>
                            </select>
                      </div>
                    </div>

                    <div class="col-lg-3">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">Juez que determino la vinculacion:</label>
                      <input class="form-control" type="text" name="juez_vinculacion" id="juezVinculacion" value="" placeholder="N/E" autocomplete="off" disabled="">
                    </div>
                  </div>

                  <div class="col-lg-4">
                        <div class="form-group" id="privadoLibertadDiv">
                          <label class="form-control-label mg-t-20"><strong>¿El imputado se encuentra interno en algún reclusorio?: </strong><span class="tx-danger">*</span></label>
                          <div class="d-inline-block mg-l-10">
                            <label class="rdiobox d-inline-block mg-l-5">
                              <input name="privado_libertad" type="radio" value="si">
                              <span class="pd-l-0">Si</span>
                            </label>
                            <label class="rdiobox d-inline-block mg-l-5">
                              <input name="privado_libertad" type="radio" value="no">
                              <span class="pd-l-0">No</span>
                            </label>
                          </div>
                        </div>
                      </div>

                      <div class="col-lg-3">
                    <div class="form-group">
                        <label class="form-control-label">Reclusorio de internamiento:</label>
                        <select class="form-control select2" id="reclusorioInternamiento" name="reclusorio_internamiento" autocomplete="off">
                            <option selected value="">Seleccione una Opción</option>
                            <option value="00020008">Centro Femenil de Reinserción Social (Santa Martha)</option>
                            <option value="00020004">Centro Varonil de Rehabilitación Psicosocial (CEVAREPSI)</option>
                            <option value="00020001">Reclusorio Preventivo Varonil Norte</option>
                            <option value="00020002">Reclusorio Preventivo Varonil Oriente</option>
                            <option value="00020003">Reclusorio Preventivo Varonil Sur</option>
                            </select>
                      </div>
                    </div>


                    <div class="col-lg-12">
                      <div class="form-group">
                        <label class="form-control-label">Comentarios Adicionales</label>
                      
                        <th colspan="100%">
                          <textarea id="comentariosAdicionales" rows="2"  ></textarea>
                          </th>
                      </div>
                    </div><!-- col-9 -->

              
                  
              `;

          $("#labelTipoRemision").html(" ENVIO DE CARPETA JUDICIAL A TRIBUNAL DE ENJUICIAMIENTO");

          $("#formularioRemision").html(formularioRemision);
          $("#formularioRemision").css("display", "");



        /*  $("#carpetaJudicialReferida").val('');

            $("#divReferida").css("display", "none");
            $("#divAsociada").css("display", "block"); */
        }
        else if ($("#tipoRemision").val() == "ejecucion") {
          console.log("ejecucion");
          let formularioRemision="";
          formularioRemision  = `
          <div class="col-lg-2">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">Carpeta Judicial a Remitir:</label>
                      <input class="form-control" type="text" name="carpeta_a_remitir" id="carpetaARemitir" value="`+arrCarpetasJudiciales[id_carpeta_judicial].folio_carpeta+`" placeholder="N/E" autocomplete="off" disabled="">
                    </div>
                  </div>

                  <div class="col-lg-2">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">Carpeta de Investigación:</label>
                      <input class="form-control" type="text" name="carpeta_investigacion" id="carpetaInvestigacion" value="`+arrCarpetasJudiciales[id_carpeta_judicial].folio_carpeta+`" placeholder="N/E" autocomplete="off" disabled="">
                    </div>
                  </div>
                  
                  <div class="col-lg-2.5">
                    <div class="form-group">
                        <label class="form-control-label">Fecha en la cual se dicta sentencia:</label>
                        <select class="form-control select2" id="fechaSentencia" name="fecha_sentencia" autocomplete="off">
                            <option selected value="">Seleccione una Opción</option>
                            </select>
                      </div>
                    </div>
                  
                    <div class="col-lg-3">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">Juez que dictó sentencia:</label>
                      <input class="form-control" type="text" name="juez_sentencia" id="juezSentencia" value="" placeholder="N/E" autocomplete="off" disabled="">
                    </div>
                  </div>

                  <div class="col-lg-3">
                              <div class="form-group">
                                <label class="form-control-label">Fecha a partir de la cual causa ejecutoria:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control fc-datepicker" placeholder="DD/MM/AAAA" id="fechaEjecutoria" name="fecha_ejecutoria" autocomplete="off">
                                </div>
                              </div>
                            </div>

                            <div class="col-lg-12">
                      <div class="form-group">
                        <label class="form-control-label">Comentarios Adicionales</label>
                      
                        <th colspan="100%">
                          <textarea id="comentariosAdicionales" rows="2"  ></textarea>
                          </th>
                      </div>
                    </div><!-- col-9 -->

                  `;

          $("#labelTipoRemision").html(" ENVIO DE CARPETA JUDICIAL A UNIDAD DE EJECUCIÓN");

          $("#formularioRemision").html(formularioRemision);
          $("#formularioRemision").css("display", "");
        /*     $("#carpetaJudicialReferida").val('');

            $("#divReferida").css("display", "none");
            $("#divAsociada").css("display", "block"); */
        }
        else if ($("#tipoRemision").val() == "preventiva") {
          console.log("preventiva");
          let formularioRemision="";
          formularioRemision  = `
          <div class="col-lg-2">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">Carpeta Judicial a Remitir:</label>
                      <input class="form-control" type="text" name="carpeta_a_remitir" id="carpetaARemitir" value="`+arrCarpetasJudiciales[id_carpeta_judicial].folio_carpeta+`" placeholder="N/E" autocomplete="off" disabled="">
                    </div>
                  </div>


                  <div class="col-lg-2">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">Unidad de gestión origen:</label>
                      <input class="form-control" type="text" name="unidad_origen" id="unidadOrigen" value="" placeholder="N/E" autocomplete="off" disabled="">
                    </div>
                  </div>

                  <div class="col-lg-3">
                    <div class="form-group">
                        <label class="form-control-label">Audiencia en la que se impuso prisión preventiva:</label>
                        <select class="form-control select2" id="fechaAudiencia" name="fecha_audiencia" autocomplete="off">
                            <option selected value="">Seleccione una Opción</option>
                            </select>
                      </div>
                    </div>

                    <div class="col-lg-3">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">Juez que impuso la prision preventiva:</label>
                      <input class="form-control" type="text" name="juez_preventiva" id="juezPreventiva" value="" placeholder="N/E" autocomplete="off" disabled="">
                    </div>
                  </div>

                  <div class="col-lg-2">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">Carpeta de prisión preventiva asignada:</label>
                      <input class="form-control" type="text" name="carpeta_asignada" id="carpetaAsignada" value="" placeholder="N/E" autocomplete="off" disabled="">
                    </div>
                  </div>
                  
                  `;

          $("#labelTipoRemision").html(" ENVIO DE CARPETA JUDICIAL POR PRISION PREVENTIVA");


          $("#formularioRemision").html(formularioRemision);
          $("#formularioRemision").css("display", "");
        /*   $("#carpetaJudicialReferida").val('');

            $("#divReferida").css("display", "none");
            $("#divAsociada").css("display", "block"); */
      }

      };
      $("#modalRemision").modal('show');
    }


  </script>                                                 
@endsection
@section('seccion-modales')
  <!-- M O D A L    A D M  I N  I S T  R A  C I O N -->
  <div id="modalAdministracion" class="modal fade"  data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-xxl modal-lg xl mg-b-100 modalAdministracion-body" role="document" style="width: -webkit-fill-available;">
      <div class="modal-content tx-size-sm modalAdministracion-content" style="overflow-y: scroll; min-height: 900px;">
        <div class="modal-header pd-x-20 d-flex justify-content-between">
          <div class="p-2">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"><span id="lbl-titulo-modal-administracion"></span></h6>
          </div>
          <div class="p-2">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"><span id="lbl-hijos-modal-administracion"></span></h6>
          </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div> <!-- HEADER -->
        
        <div class="modal-body pd-20">
          <input type="hidden" name="id_carpeta_judicial" id="id_carpeta_judicial" value="">  
          <input type="hidden" name="id_solicitud" id="id_solicitud" value="">  
          <input type="hidden" name="tipo_solicitud" id="tipo_solicitud" value=""> 
          @include('carpetas.tabs.vida-carpeta')
          <br><br>
          <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
              <a class="nav-item nav-link active" id="nav-documentos-asociados-tab" data-toggle="tab" href="#nav-documentos-asociados" role="tab" aria-controls="nav-documentos-asociados" aria-selected="true">Documentos Asociados</a>
              <a class="nav-item nav-link" id="nav-audiencias-tab" data-toggle="tab" href="#nav-audiencias" role="tab" aria-controls="nav-audiencias" aria-selected="false">Audiencias</a>
              <a class="nav-item nav-link" id="nav-partes-procesales-tab" data-toggle="tab" href="#nav-partes-procesales" role="tab" aria-controls="nav-partes-procesales" aria-selected="false">Partes Procesales</a>
              <a class="nav-item nav-link" id="nav-delitos-sin-relacionar-tab" data-toggle="tab" href="#nav-delitos-sin-relacionar" role="tab" aria-controls="nav-delitos-sin-relacionar" aria-selected="false">Delitos Sin Relacionar</a>
              <a class="nav-item nav-link" id="nav-documentos-generados-tab" data-toggle="tab" href="#nav-documentos-generados" role="tab" aria-controls="nav-documentos-generados" aria-selected="false">Documentos Generados</a>
              <a class="nav-item nav-link" id="nav-carpetas-hijas-tab" data-toggle="tab" href="#nav-carpetas-hijas" role="tab" aria-controls="nav-carpetas-hijas" aria-selected="false">Carpetas Asociadas</a>
            </div>
          </nav>

          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-documentos-asociados" role="tabpanel" aria-labelledby="nav-documentos-asociados">
              @include('carpetas.tabs.documentos-asociados')
            </div><!-- tab-docuemntos-asociados -->
            <div class="tab-pane fade" id="nav-audiencias" role="tabpanel" aria-labelledby="nav-audiencias">
              @include('carpetas.tabs.h_audiencias')
            </div><!-- tab-audiencias -->
            <div class="tab-pane fade" id="nav-partes-procesales" role="tabpanel" aria-labelledby="nav-partes-procesales">
              @include('carpetas.tabs.partes-procesales')
            </div><!-- tab-partes-procesales -->
            <div class="tab-pane fade" id="nav-delitos-sin-relacionar" role="tabpanel" aria-labelledby="nav-delitos-sin-relacionar">
              @include('carpetas.tabs.delitos-sin-relacionar')
            </div><!-- tab-delitos-sin-relacionar -->
            <div class="tab-pane fade" id="nav-documentos-generados" role="tabpanel" aria-labelledby="nav-documentos-generados">
              @include('carpetas.tabs.documentos-generados')
            </div><!-- tab-documentos-generados -->
            <div class="tab-pane fade" id="nav-carpetas-hijas" role="tabpanel" aria-labelledby="nav-carpetas-hijas">
              {{-- @include('carpetas.tabs.carpetas-hijas') --}}
            </div><!-- tab-carpetas-hijas -->
          </div><!-- div-tabs-content -->

        </div><!-- modal-body -->
        <div class="modal-footer d-flex">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div> 
    </div><!-- modal-dialog -->
  </div><!-- modal -->

  <!-- M O D A L    U S O     G E N E R A L -->

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
  
  <div id="modalConfirm" class="modal fade"  data-backdrop="static" data-keyboard="false" >
    <div class="modal-dialog modal-dialog-xxl modal-lg" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold" id="tituloModalConfirm"></h6>
        </div>
        <div class="modal-body tx-center pd-y-20 pd-x-20" id="bodyModalConfirm">
          
        </div><!-- modal-body -->
        <div class="modal-footer d-flex">
          <button type="button" class="btn btn-secondary pd-x-25 mg-l-10 cerrar-modal" data-modal="modalAdministracion" data-thismodal="modalConfirm" id="btnCancelarModalConfirm">Cancelar</button>
          <button type="button" class="btn btn-primary pd-x-25 mg-l-10 cerrar-modal" data-modal="modalAdministracion" data-thismodal="modalConfirm" id="btnAceptarModalConfirm">Aceptar</button>
        </div>
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
  </div><!-- modal -->

  <div id="modalHistory" class="modal fade"  data-backdrop="static" data-keyboard="false" >
    <div class="modal-dialog modal-dialog-xxl modal-lg" role="document">
      <div class="modal-content tx-size-sm" style="overflow-y: scroll; min-height: 800px;">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold" id="tituloModalHistory"></h6>
          <button type="button" class="close cerrar-modal btnCerrarModalHistory" data-modal="modalAdministracion" data-thismodal="modalHistory" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body tx-center pd-y-20 pd-x-20" id="bodyModalHistory">
          
        </div><!-- modal-body -->
        <div class="modal-footer d-flex">
          <button type="button" class="btn btn-secondary pd-x-25 mg-l-10 cerrar-modal btnCerrarModalHistory" data-modal="modalAdministracion" data-thismodal="modalHistory" id="btnCerrarModalHistory">Cerrar</button>
        </div>
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
  </div><!-- modal -->




<!-- M O D A L    A U D I E N C I A   I N F O -->

{{--  // ########## MANDAMIENTOS jUDICIALES ##########  --}}

{{-- Modal Agregar acciones resolutivos --}}
<div id="modalAccionesResolutivos" class="modal fade"  data-backdrop="static" data-keyboard="false" >
  <div class="modal-dialog modal-dialog-xxl modal-lg" role="document">
    <div class="modal-content tx-size-sm" style="overflow-y: scroll; min-height: 800px;">
      <div class="modal-header pd-x-20">
        <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold" id="#">Nuevo Resolutivo</h6>
        <button type="button" class="close cerrar-modal btnCerrarModalAccionesResolutivos" data-modal="modalHistory" data-thismodal="modalAccionesResolutivos" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body tx-center pd-y-20 pd-x-20">
        <div class="row">
          <div class="col-lg-12">
          <form action="" id="frm_resolutivos">
            <input type="hidden" id="folioC" >
            <input type="hidden" id="folioC_id_audiencia" >

            <div class="form-group text-left">
              <label class="form-control-label">Resolutivo:</label>
              <select class="form-control" id="cmp_resolutivo" name ="cmp_resolutivo" autocomplete="off" onchange="elegir_menu(this)">
                <option value="-">Seleccione un resolutivo</option>
              </select>
            </div>
            
            <div id="menu5" style="display: none;">
              <div class="form-group text-left">
                <label class="form-control-label">Campo:</label>
                <div class="form-group">
                  <input type="number" style="text-align:center;" class="form-control"  id="cmp_cantidad" placeholder="Cantidad" autocomplete="off">
                </div>
              </div>
            </div>
            <div id="menu2" style="display: none;">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group text-left">
                    <label class="form-control-label">Fecha base:</label>
                    <div class="form-group">
                      <input type="text" style="text-align:center;" class="form-control"  id="cmp_fecha_base" placeholder="dd/mm/yyy"  autocomplete="off">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group text-left">
                    <label class="form-control-label">Fecha resultado:</label>
                    <div class="form-group">
                      <input type="text"  style="text-align:center;" class="form-control"  id="cmp_fecha_resultado" placeholder="dd/mm/yyy" autocomplete="off" readonly>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="formControlRange">Dias</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <button class="btn btn-outline-secondary" type="button"  onclick="restar_dia('dia','cmp_fecha_resultado')">-</button>
                      </div>
                      <input type="text" class="form-control" id="dia" placeholder="0" value="0" style="text-align: center;"  disabled>
                      <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button"  onclick="sumar_dia('dia','cmp_fecha_resultado')">+</button>
                     </div>
                  </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="formControlRange">Meses</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <button class="btn btn-outline-secondary" type="button" onclick="restar_mes('mes','cmp_fecha_resultado')" >-</button>
                      </div>
                      <input type="text" class="form-control" id="mes" placeholder="0" value="0" style="text-align: center;"  disabled>
                      <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" onclick="sumar_mes('mes','cmp_fecha_resultado')">+</button>
                     </div>
                  </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="formControlRange">Años</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <button class="btn btn-outline-secondary" type="button" onclick="restar_anio('anio','cmp_fecha_resultado')">-</button>
                      </div>
                      <input type="text" class="form-control" id="anio" placeholder="0" value="0" style="text-align: center;"  disabled>
                      <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" onclick="sumar_anio('anio','cmp_fecha_resultado')">+</button>
                     </div>
                  </div>
                  </div>
                </div>
              </div>
            </div>
            <div id="menu8" style="display: none;">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="cmp_imputado">
                    <label class="form-check-label" for="defaultCheck1" id="cmp_nombre_imputado">
                      Carlos Najera Velazquez
                    </label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group text-left">
                    <label class="form-control-label">Comentario:</label>
                    <div class="form-group">
                      <input type="text" style="text-align:center;" class="form-control"  id="cmp_imputado_comentario" placeholder="Escribe un comentario" autocomplete="off">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div id="menu1" style="display: none;">
              <div class="form-group text-left">
                <label class="form-control-label">Valor:</label>
                <select class="form-control" id="cmp_valor" name ="cmp_valor" autocomplete="off">
                  <option value="-">Seleccione un resolutivo</option>
                  <option value="Si">Si</option>
                  <option value="No">No</option>
                </select>
              </div>
            </div>
            <div id="menu4" style="display: none;">
              <div class="form-group text-left">
                <label class="form-control-label">Fecha:</label>
                <div class="form-group">
                  <input type="text" style="text-align:center;" class="form-control"  id="cmp_fecha" placeholder="Escribe una descripcón" autocomplete="off">
                </div>
              </div>
            </div>

            <div class="form-group text-left">
              <label class="form-control-label">Comentarios adicionales:</label>
              <textarea class="form-control" id="cmp_comentarios_resolutivo" rows="3"></textarea>
            </div>
          
          </form>


          </div>
        </div>
      </div><!-- modal-body -->
      <div class="modal-footer d-flex">
        <button type="button" class="btn btn-secondary pd-x-25 mg-l-10  btnCerrarModalAccionesResolutivos" onclick="cancelar_resolutivo('modalHistory', 'modalAccionesResolutivos')"  id="btnCerrarModalAccionesResolutivos">Cerrar</button>
        <button type="button" class="btn btn-secondary pd-x-25 mg-l-10" style="background:#848F33 !important; color:#fff;" onclick="guardar_resolutivo()" id="saveResolutivo">Guardar</button>
      </div>
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div><!-- modal -->

{{-- Modal editar acciones resolutivos--}}
<div id="modalAccionesResolutivos_E" class="modal fade"  data-backdrop="static" data-keyboard="false" >
  <div class="modal-dialog modal-dialog-xxl modal-lg" role="document">
    <div class="modal-content tx-size-sm" style="overflow-y: scroll; min-height: 800px;">
      <div class="modal-header pd-x-20">
        <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold" id="#">Editar Resolutivo</h6>
        <button type="button" class="close cerrar-modal btnCerrarModalAccionesResolutivos_E" data-modal="modalHistory" data-thismodal="modalAccionesResolutivos_E" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body tx-center pd-y-20 pd-x-20">
        <div class="row">
          <div class="col-lg-12">
          <form action="" id="frm_resolutivos_E">
            <input type="hidden" id="folioC_E">
            <input type="hidden" id="folioC_A_E">
            <input type="hidden" id="folioC_id_audiencia_E">

            <div class="row">
              <div class="col-md-8">
                <div class="form-group text-left">
                  <label class="form-control-label">Resolutivo:</label>
                  <select class="form-control" id="cmp_resolutivo_E" name ="cmp_resolutivo_E" autocomplete="off">
                    <option value="-">Seleccione un resolutivo</option>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group text-left">
                  <label class="form-control-label">Estatus:</label>
                  <select class="form-control" id="cmp_estatus_resolutivo_E" name ="cmp_estatus_resolutivo_E" autocomplete="off">
                    <option value="1">Activo</option>
                    <option value="0">Inctivo</option>
                  </select>
                </div>
              </div>
            </div>
            
            <div id="menu5_E" style="display: none;">
              <div class="form-group text-left">
                <label class="form-control-label">Campo:</label>
                <div class="form-group">
                  <input type="number" style="text-align:center;" class="form-control"  id="cmp_cantidad_E" placeholder="Cantidad" autocomplete="off">
                </div>
              </div>
            </div>
            <div id="menu2_E" style="display: none;">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group text-left">
                    <label class="form-control-label">Fecha base:</label>
                    <div class="form-group">
                      <input type="text" style="text-align:center;" class="form-control"  id="cmp_fecha_base_E" placeholder="dd/mm/yyy"  autocomplete="off">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group text-left">
                    <label class="form-control-label">Fecha resultado:</label>
                    <div class="form-group">
                      <input type="text"  style="text-align:center;" class="form-control"  id="cmp_fecha_resultado_E" placeholder="dd/mm/yyy" autocomplete="off" readonly>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="formControlRange">Dias</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <button class="btn btn-outline-secondary" type="button"  onclick="restar_dia('cmp_dias_E','cmp_fecha_resultado_E')">-</button>
                      </div>
                      <input type="text" class="form-control" id="cmp_dias_E" placeholder="0" value="0" style="text-align: center;"  disabled>
                      <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button"  onclick="sumar_dia('cmp_dias_E','cmp_fecha_resultado_E')">+</button>
                     </div>
                  </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="formControlRange">Meses</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <button class="btn btn-outline-secondary" type="button" onclick="restar_mes'cmp_meses_E','cmp_fecha_resultado_E')" >-</button>
                      </div>
                      <input type="text" class="form-control" id="cmp_meses_E" placeholder="0" value="0" style="text-align: center;"  disabled>
                      <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" onclick="sumar_mes('cmp_meses_E','cmp_fecha_resultado_E')">+</button>
                     </div>
                  </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="formControlRange">Años</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <button class="btn btn-outline-secondary" type="button" onclick="restar_anio('cmp_ano_E','cmp_fecha_resultado_E')">-</button>
                      </div>
                      <input type="text" class="form-control" id="cmp_ano_E" placeholder="0" value="0" style="text-align: center;"  disabled>
                      <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" onclick="sumar_anio('cmp_ano_E','cmp_fecha_resultado_E')">+</button>
                     </div>
                  </div>
                  </div>
                </div>
              </div>
            </div>
            <div id="menu8_E" style="display: none;">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1621006520431" id="cmp_imputado_E">
                    <label class="form-check-label" for="defaultCheck1" id="cmp_nombre_imputado_E">
                      PEPITO PEREZ PEREZ
                    </label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group text-left">
                    <label class="form-control-label">Comentario:</label>
                    <div class="form-group">
                      <input type="text" style="text-align:center;" class="form-control"  id="cmp_imputado_comentario_E" placeholder="Escribe un comentario" autocomplete="off">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div id="menu1_E" style="display: none;">
              <div class="form-group text-left">
                <label class="form-control-label">Valor:</label>
                <select class="form-control" id="cmp_valor_E" name ="cmp_valor_E" autocomplete="off">
                  <option value="-">Seleccione un resolutivo</option>
                  <option value="Si">Si</option>
                  <option value="No">No</option>
                </select>
              </div>
            </div>
            <div id="menu4_E" style="display: none;">
              <div class="form-group text-left">
                <label class="form-control-label">Fecha:</label>
                <div class="form-group">
                  <input type="text" style="text-align:center;" class="form-control"  id="cmp_fecha_E" placeholder="Escribe una descripcón" autocomplete="off">
                </div>
              </div>
            </div>

            <div class="form-group text-left">
              <label class="form-control-label">Comentarios adicionales:</label>
              <textarea class="form-control" id="cmp_comentarios_resolutivo_E" rows="3"></textarea>
            </div>
          
          </form>

          </div>
        </div>
      </div><!-- modal-body -->
      <div class="modal-footer d-flex">
        <button type="button" class="btn btn-secondary pd-x-25 mg-l-10  btnCerrarModalAccionesResolutivos_E" onclick="cancelar_resolutivo('modalHistory', 'modalAccionesResolutivos_E')"  id="btnCerrarModalAccionesResolutivos_E">Cerrar</button>
        <button type="button" class="btn btn-secondary pd-x-25 mg-l-10" style="background:#848F33 !important; color:#fff;" onclick="editar_resolutivo()" id="saveResolutivo">Actualizar</button>
      </div>
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div><!-- modal -->



{{-- Modal Agregar Mandamientos judiciales --}}
<div id="modalMandamiendoJudicial" class="modal fade"  data-backdrop="static" data-keyboard="false" >
  <div class="modal-dialog modal-dialog-xxl modal-lg" role="document">
    <div class="modal-content tx-size-sm" style="overflow-y: scroll; min-height: 800px;">
      <div class="modal-header pd-x-20">
        <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold" id="#">Nuevo Mandamiento Judicial</h6>
        <button type="button" class="close cerrar-modal btnCerrarmodalMandamiendoJudicial" data-modal="modalHistory" data-thismodal="modalMandamiendoJudicial" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body tx-center pd-y-20 pd-x-20">
        <div class="row">
          <div class="col-md-7">
            <div class="form-group text-left">
              <label class="form-control-label">Tipo de Orden:</label>
              <select class="form-control" id="cmp_tipoOrden" name ="cmp_tipoOrden" autocomplete="off">
                <option value="-">Seleccione un tipo de orden</option>
                <option value="cateo">Orden de Cateo</option>
                <option value="aprehension">Orden de Aprehensión</option>
                <option value="reaprehension">Orden de Reaprehensión</option>
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group text-left">
              <label class="form-control-label">Delitos:</label>
              <select class="form-control" id="cmp_delitos" name ="cmp_delitos" autocomplete="off">
                <option value="-">Seleccione el delito</option>
                <option value="">algo</option>
              </select>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group text-left">
              <label class="form-control-label">Fecha de libramiento:</label>
              <input type="text" style="text-align:center;" class="form-control"  id="cmp_libramiento" placeholder="Fecha de libramiento" autocomplete="off">
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <div class="form-group text-left">
              <label class="form-control-label">Unidad de Gestion Judicial:</label>
              <select class="form-control" id="cmp_unidad_gestion" name ="cmp_unidad_gestion" autocomplete="off">
                <option value="-">Seleccione unidad de gestion</option>
              </select>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-4">
            <div class="form-group text-left">
              <label class="form-control-label">N° Oficio:</label>
              <div class="form-group">
                <input type="text" style="text-align:center;" class="form-control"  id="cmp_oficio" placeholder="N° de oficio" autocomplete="off">
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group text-left">
              <label class="form-control-label">N° Carpeta Judicial:</label>
              <div class="form-group">
                <input type="hidden" id="cmp_id_audiencia">
                <input type="text" style="text-align:center;" class="form-control"  id="cmp_carpeta_judicial" placeholder="N° Carpeta Judicial" autocomplete="off" readonly>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group text-left">
              <label class="form-control-label">Id solicitud que derivo de la orden:</label>
              <div class="form-group">
                <input type="text" style="text-align:center;" class="form-control"  id="cmp_id_solicitud" placeholder="Id Solicitud" autocomplete="off">
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <div class="form-group text-left">
              <label class="form-control-label">Descripcion de la orden:</label>
              <textarea class="form-control" id="cmp_comentarios_mandamiento" rows="3"></textarea>
            </div>
          </div>
        </div>

        	
        <div class="row">
          <div class="col-lg-6 d-none" id="col_nombre_documento_mandamiento">
              <div class="form-group">
                <label class="form-control-label">Nombre documento: <span class="tx-danger">*</span> </label>
                <input class="form-control" type="text" id="nombre_documento_mandamiento" name="nombre_documento_mandamiento" autocomplete="off">
              </div>
            </div>
        </div>

        <div class="row" id="row_documento_mandamiento">
              <div class="col-lg-12">
                <form onsubmit="return false;" id="cargarDocumentoMandamiento" action="/" enctype="multipart/form-data">
                  <div class="custom-input-file">
                    <input type="file" id="mandamientoPDF" class="input-file" value="" name="mandamientoPDF" accept=".pdf">
                    <h5 class="px-3 py-3">Arrastre hasta aquí su documento o de clic para adjuntarlo</h5>
                  </div>
                </form>
              </div>
          </div>

        <div class="row" id="divViewDocumentosMandamiento"></div>



      </div><!-- modal-body -->
      <div class="modal-footer d-flex">
        <button type="button" class="btn btn-secondary pd-x-25 mg-l-10 cerrar-modal btnCerrarMandamiendoJudicial" data-modal="modalHistory" data-thismodal="modalMandamiendoJudicial" id="btnCerrarMandamiendoJudicial">Cerrar</button>
        <button type="button" class="btn btn-secondary pd-x-25 mg-l-10" style="background:#848F33 !important; color:#fff;" onclick="guardarMandamiento()" id="btnGuardarMandamiendoJudicial">Guardar</button>
      </div>
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div><!-- modal -->

{{-- Modal editar Mandamientos judiciales --}}
<div id="modalMandamiendoJudicialEdit" class="modal fade"  data-backdrop="static" data-keyboard="false" >
  <div class="modal-dialog modal-dialog-xxl modal-lg" role="document">
    <div class="modal-content tx-size-sm" style="overflow-y: scroll; min-height: 800px;">
      <div class="modal-header pd-x-20">
        <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold" id="#">Editar Mandamiento</h6>
        <button type="button" class="close cerrar-modal btnCerrarModalMandamiendoJudicialEdit" data-modal="modalHistory" data-thismodal="modalMandamiendoJudicialEdit" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body tx-center pd-y-20 pd-x-20">
        <input type="hidden" id="id_audiencia_mandamiento_E">
        <input type="hidden" id="id_audiencia_E">
        <div class="row">
          <div class="col-md-7">
            <div class="form-group text-left">
              <label class="form-control-label">Tipo de Orden:</label>
              <select class="form-control" id="cmp_tipoOrden_E" name ="cmp_tipoOrden_E" autocomplete="off">
                <option value="-">Seleccione un tipo de orden</option>
                <option value="cateo">Orden de Cateo</option>
                <option value="aprehension">Orden de Aprehensión</option>
                <option value="reaprehension">Orden de Reaprehensión</option>
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group text-left">
              <label class="form-control-label">Delitos:</label>
              <select class="form-control" id="cmp_delitos_E" name ="cmp_delitos_E" autocomplete="off">
                <option value="-">Seleccione el delito</option>
                <option value="">algo</option>
              </select>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group text-left">
              <label class="form-control-label">Fecha de libramiento:</label>
              <input type="text" style="text-align:center;" class="form-control"  id="cmp_libramiento_E" placeholder="Fecha de libramiento" autocomplete="off">
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-8">
            <div class="form-group text-left">
              <label class="form-control-label">Unidad de Gestion Judicial:</label>
              <select class="form-control" id="cmp_unidad_gestion_E" name ="cmp_unidad_gestion_E" autocomplete="off">
                <option value="-">Seleccione unidad de gestion</option>
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group text-left">
              <label class="form-control-label">Estatus:</label>
              <select class="form-control" id="cmp_estatus_E" name ="cmp_estatus_E" autocomplete="off">
                <option value="1">Activo</option>
                <option value="0">Inctivo</option>
              </select>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-4">
            <div class="form-group text-left">
              <label class="form-control-label">N° Oficio:</label>
              <div class="form-group">
                <input type="text" style="text-align:center;" class="form-control"  id="cmp_oficio_E" placeholder="N° de oficio" autocomplete="off">
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group text-left">
              <label class="form-control-label">N° Carpeta Judicial:</label>
              <div class="form-group">
                <input type="text" style="text-align:center;" class="form-control"  id="cmp_carpeta_judicial_E" placeholder="N° Carpeta Judicial" autocomplete="off" readonly>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group text-left">
              <label class="form-control-label">Id solicitud que derivo de la orden:</label>
              <div class="form-group">
                <input type="text" style="text-align:center;" class="form-control"  id="cmp_id_solicitud_E" placeholder="Id Solicitud" autocomplete="off" readonly>
              </div>
            </div>
          </div>
        </div>

        
        <div class="row">
          <div class="col-md-12">
            <div class="form-group text-left">
              <label class="form-control-label">Descripcion de la orden:</label>
              <textarea class="form-control" id="cmp_comentarios_mandamiento_E" rows="3"></textarea>
            </div>
          </div>
        </div>
      </div><!-- modal-body -->
      <div class="modal-footer d-flex">
        <button type="button" class="btn btn-secondary pd-x-25 mg-l-10 cerrar-modal btnCerrarModalMandamiendoJudicialEdit" data-modal="modalHistory" data-thismodal="modalMandamiendoJudicialEdit" id="btnCerrarMandamiendoJudicialEdit">Cerrar</button>
        <button type="button" class="btn btn-secondary pd-x-25 mg-l-10" style="background:#848F33 !important; color:#fff;" onclick="actualizar_mandamientos()" id="btnActualizarMandamiento">Actualizar</button>
      </div>
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div><!-- modal -->



{{--  // ########## ACUERDOS REPARATORIOS ##########  --}}
{{--  Modal Agregar Acuerdo Reparatorio  --}}
<div id="modalAcuerdoR" class="modal fade"  data-backdrop="static" data-keyboard="false" >
  <div class="modal-dialog modal-dialog-xxl modal-xl" role="document">
    <div class="modal-content tx-size-sm" style="overflow-y: auto; min-height: 800px;">
      <div class="modal-header pd-x-20">
        <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold" id="#">Nuevo Acuerdo Reparatorio</h6>
        <button type="button" class="close cerrar-modal btnCerrarModalAcuerdoR" data-modal="modalHistory" data-thismodal="modalAcuerdoR" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body tx-center pd-y-20 pd-x-20">
	    <div class="col-md-12">
	    	<form action="" id="frm_add_AcuerdoR">
	    		<input type="hidden" id="CarpetaF">
          <input type="hidden" id="cmp_id_audiencia_AR">

	        	<div class="form-group text-left">
	        	  	<label>Imputado:</label>
					      <select class="form-control" id="cmp_imputado_AR" name="cmp_imputado_AR" >
					      </select>
	        	</div>
	
	       		<div class="form-group text-left">
	        	  	<label>Resumen del Acuerdo:</label>	
	        	  	<textarea class="form-control" id="cmp_resumenAcuerdo_AR" rows="3"></textarea>
	        	</div>
	
	        	<div class="row">
	        		<div class="col-md-4">
	        			<div class="form-group text-left">
    						<label for="cmp_tipoCumplimiento_AR" class="col-sm-12 col-form-label">Tipo de Cumplimiento:</label>
    						<div class="col-sm-12">
    						  	<select class="form-control" id="cmp_tipoCumplimiento_AR" name="cmp_tipoCumplimiento_AR">
					  				<option value="Inmediato">Inmediato</option>
					  				<option value="Diferido">Diferido</option>
								</select>
    						</div>
  						</div>
	        		</div>
	        		<div class="col-md-4">
	        			<div class="form-group text-left">
    						<label for="cmp_apruebaAcuerdo_AR" class="col-sm-12 col-form-label">¿Se aprueba el acuerdo?</label>
    						<div class="col-sm-12">
    						  	<select class="form-control" id="cmp_apruebaAcuerdo_AR" name="cmp_apruebaAcuerdo_AR">
					  				<option value="No">No</option>
					  				<option value="Si">Si</option>
								</select>
    						</div>
  						</div>
	        		</div>
	        		<div class="col-md-4">
	        			<div class="form-group text-left">
    						<label for="cmp_fehcaExtincion_AR" class="col-sm-12 col-form-label">Fecha de extincion de accion penal</label>
    						<div class="col-sm-12">
    							<input type="text" class="form-control"  id="cmp_fehcaExtincion_AR" name="cmp_fehcaExtincion_AR">
    						</div>
  						</div>
	        		</div>
	        	</div>
	
	        	<div class="form-group text-left">
	        	  	<label>Comentarios Adicionales:</label>	
	        	  	<textarea class="form-control" id="cmp_comentariosAdicionales_AR" rows="3"></textarea>
	        	</div>
	
	        	<div class="row">
	        		<div class="col-lg-6 d-none" id="col_nombre_documento_acuerdo">
            		  <div class="form-group">
            		    <label class="form-control-label">Nombre documento: <span class="tx-danger">*</span> </label>
            		    <input class="form-control" type="text" id="nombre_documento_acuerdo" name="nombre_documento_acuerdo" autocomplete="off">
            		  </div>
            		</div>
	        	</div>
	
	        	<div class="row" id="row_documento_acuerdo">
            	    <div class="col-lg-12">
            	      <form onsubmit="return false;" id="cargarDocumentoAcurdo" action="/" enctype="multipart/form-data">
            	        <div class="custom-input-file">
            	          <input type="file" id="acuerdoPDF" class="input-file" value="" name="acuerdoPDF" accept=".pdf">
            	          <h5 class="px-3 py-3">Arrastre hasta aquí su documento o de clic para adjuntarlo</h5>
            	        </div>
            	      </form>
            	    </div>
            	</div>

            </form>
            <div class="row" id="divViewDocumentosAcuerdo"></div>


	    </div>


      </div><!-- modal-body -->
      <div class="modal-footer d-flex">
        <button type="button" class="btn btn-secondary pd-x-25 mg-l-10 cerrar-modal" data-modal="modalHistory" data-thismodal="modalAcuerdoR" id="btnCerrarModalAcuerdoR">Cerrar</button>
        <button type="button" class="btn btn-secondary pd-x-25 mg-l-10" style="background:#848F33 !important; color:#fff;" onclick="guardarAcuerdoR()" id="btnGuardarAcuerdoR">Guardar</button>
      </div>
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div><!-- modal -->

{{--  Modal Editar Acuerdo Reparatorio  --}}
<div id="modalAcuerdoR_E" class="modal fade"  data-backdrop="static" data-keyboard="false" >
  <div class="modal-dialog modal-dialog-xxl modal-xl" role="document">
    <div class="modal-content tx-size-sm" style="overflow-y: auto; min-height: 800px;">
      <div class="modal-header pd-x-20">
        <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold" id="#">Editar Acuerdo Reparatorio</h6>
        <button type="button" class="close cerrar-modal btnCerrarModalAcuerdoR_E" data-modal="modalHistory" data-thismodal="modalAcuerdoR_E" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body tx-center pd-y-20 pd-x-20">
     	<input type="hidden" id="CarpetaF_E">
      <input type="hidden" id="cmp_AcuerdoF_id_audiencia_E">
      <input type="hidden" id="cmp_id_audiencia_AR_E">

	    <div class="col-md-12">
	    		<div class="row">
	    			  <div class="col-sm-12 col-md-8 col-lg-8">
	        			<div class="form-group text-left">
	        			  	<label>Imputado:</label>
							      <select class="form-control" id="cmp_imputado_AR_E" name="cmp_imputado_AR_E" >
							      </select>
	        			</div>
	        		</div>
	        		<div class="col-sm-12 col-md-4 col-lg-4">
	        			<div class="form-group text-left">
	        			  	<label>Estatus:</label>
							      <select class="form-control" id="cmp_estatus_AR_E" name="cmp_estatus_AR_E">
							        <option value="0">Inctivo</option>
							        <option value="1">Activo</option>
							      </select>
	        			</div>
	        		</div>
	        </div>
	
	       		<div class="form-group text-left">
	        	  	<label>Resumen del Acuerdo:</label>	
	        	  	<textarea class="form-control" id="cmp_resumenAcuerdo_AR_E" rows="3"></textarea>
	        	</div>
	
	        	<div class="row">
	        		<div class="col-sm-12 col-md-4 col-lg-4">
	        			<div class="form-group text-left">
    						  <label for="cmp_tipoCumplimiento_AR" class="col-sm-12 col-form-label">Tipo de Cumplimiento:</label>
    						  <div class="col-sm-12">
    						    	<select class="form-control" id="cmp_tipoCumplimiento_AR_E" name="cmp_tipoCumplimiento_AR_E">
					  		  		  <option value="Inmediato">Inmediato</option>
					  		  		  <option value="Diferido">Diferido</option>
                      </select>
    						  </div>
  						  </div>
	        		</div>
	        		<div class="col-sm-12 col-md-4 col-lg-4">
	        			<div class="form-group text-left">
    						  <label for="cmp_apruebaAcuerdo_AR" class="col-sm-12 col-form-label">¿Se aprueba el acuerdo?</label>
    						  <div class="col-sm-12">
    						    	<select class="form-control" id="cmp_apruebaAcuerdo_AR_E" name="cmp_apruebaAcuerdo_AR_E">
					  		  		  <option value="No">No</option>
					  		  		  <option value="Si">Si</option>
								      </select>
    						  </div>
  						  </div>
	        		</div>
	        		<div class="col-sm-12 col-md-4 col-lg-4">
	        			<div class="form-group text-left">
    						<label for="cmp_fehcaExtincion_AR" class="col-sm-12 col-form-label">Fecha de extincion de accion penal</label>
    						<div class="col-sm-12">
    							<input type="text" class="form-control" id="cmp_fehcaExtincion_AR_E" name="cmp_fehcaExtincion_AR_E">
    						</div>
  						</div>
	        		</div>
	        	</div>
	
	        	<div class="form-group text-left">
	        	  	<label>Comentarios Adicionales:</label>	
	        	  	<textarea class="form-control" id="cmp_comentariosAdicionales_AR_E" rows="3"></textarea>
	        	</div>
	
	        	<div class="row">
	        		<div class="col-lg-6 d-none" id="col_nombre_documento_acuerdo_E">
            		  <div class="form-group">
            		    <label class="form-control-label">Nombre documento: <span class="tx-danger">*</span> </label>
            		    <input class="form-control" type="text" id="nombre_documento_acuerdo_E" name="nombre_documento_acuerdo_E" autocomplete="off">
            		  </div>
            		</div>
	        	</div>
	
	        	<div class="row" id="row_documento_acuerdo_E">
            	    <div class="col-lg-12">
            	      <form onsubmit="return false;" id="cargarDocumentoAcurdo_E" action="/" enctype="multipart/form-data">
            	        <div class="custom-input-file">
            	          <input type="file" id="acuerdoPDF_E" class="input-file" value="" name="acuerdoPDF_E" accept=".pdf">
            	          <h5 class="px-3 py-3">Arrastre hasta aquí su documento o de clic para adjuntarlo</h5>
            	        </div>
            	      </form>
            	    </div>
            </div>



            <div class="row" id="divViewDocumentosAcuerdo"></div>


	    </div>


      </div><!-- modal-body -->
      <div class="modal-footer d-flex">
        <button type="button" class="btn btn-secondary pd-x-25 mg-l-10 cerrar-modal" data-modal="modalHistory" data-thismodal="modalAcuerdoR_E" id="btnCerrarModalAcuerdoR_E">Cerrar</button>
        <button type="button" class="btn btn-secondary pd-x-25 mg-l-10" style="background:#848F33 !important; color:#fff;" onclick="actualizar_AcuerdoR()" id="btnEditarAcuerdoR">Actualizar</button>
      </div>
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div><!-- modal -->



{{--  // ########## MEDIDAS CAUTELARES##########  --}}
{{--  Modal Agregar Medida Cautelar  --}}
<div id="modalMedidasCautelares" class="modal fade"  data-backdrop="static" data-keyboard="false" >
  <div class="modal-dialog modal-dialog-xxl modal-lg" role="document">
    <div class="modal-content tx-size-sm" style="overflow-y: scroll; min-height: 800px;">
      <div class="modal-header pd-x-20">
        <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold" id="#">Nuevo Medida Cautelar</h6>
        <button type="button" class="close cerrar-modal btnCerrarModalMedidasCautelares" data-modal="modalHistory" data-thismodal="modalMedidasCautelares" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body tx-center pd-y-20 pd-x-20">
        <div class="row">
          <div class="col-lg-12">
          <form action="" id="frm_medidasC">
            <input type="hidden" id="cmp_medidaC_folioC" >
            <input type="hidden" id="cmp_medidaC_id_audiencia" >
            <div class="form-group text-left">
              <label class="form-control-label">Imputado:</label>
              <select class="form-control" id="cmp_medidaC_imputado" name ="cmp_medidaC_imputado" autocomplete="off">
                <option value="">Seleccione imputado</option>
              </select>
            </div>
            
            <div class="form-group text-left">
              <label class="form-control-label">Medida Cautelar:</label>
              <select class="form-control" id="cmp_medidaC_medida" name ="cmp_medidaC_medida" autocomplete="off" onchange="elegir_menu_cautelar(this)">
                <option value="-">Seleccione Medida Cautelar</option>
                <option value="123" data-tipo="1">Medida Cautelar garantias 1</option>
                <option value="345" data-tipo="2">Medida Cautelar pagos 2</option>
                <option value="567" data-tipo="0">Medida Cautelar 3</option>
                <option value="345" data-tipo="2">Medida Cautelar pagos 4</option>
                <option value="678" data-tipo="0">Medida Cautelar 5</option>
                <option value="876" data-tipo="1">Medida Cautelar garantias 6</option>
              </select>
            </div>

            <div id="medidaC_menu1" style="display: none;">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group text-left">
                    <label class="form-control-label">Monto de la Garantia:</label>
                    <div class="form-group">
                      <input type="text" style="text-align:center;" class="form-control"  id="cmp_medidaC_garantia" placeholder="monto de la garantia"  autocomplete="off">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group text-left">
                    <label class="form-control-label">Numero de pagos:</label>
                    <div class="form-group">
                      <input type="number"  style="text-align:center;" class="form-control"  id="cmp_medidaC_pagos" placeholder="numero de pagos" autocomplete="off">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div id="medidaC_menu2" style="display: none;">
              <div class="form-group text-left">
                <label class="form-control-label">Autoridad a la que debe presentarse:</label>
                <select class="form-control" id="cmp_medidaC_autoridad" name ="cmp_medidaC_autoridad" autocomplete="off">
                  <option value="-">Seleccione una autoridad</option>
                  <option value="UMECA">UMECA</option>
                  <option value="Juez">Juez</option>
                  <option value="Otro">Otro</option>
                </select>
              </div>
            </div>

            <div class="form-group text-left">
              <label class="form-control-label">Especificaciones:</label>
              <textarea class="form-control" id="cmp_medidaC_comentarios" rows="3"></textarea>
            </div>
          
          </form>

          </div>
        </div>
      </div><!-- modal-body -->
      <div class="modal-footer d-flex">
        <button type="button" class="btn btn-secondary pd-x-25 mg-l-10  btnCerrarModalMedidasCautelares" onclick="cancelar_resolutivo('modalHistory', 'modalMedidasCautelares')"  id="btnCerrarModalMedidasCautelares">Cerrar</button>
        <button type="button" class="btn btn-secondary pd-x-25 mg-l-10" style="background:#848F33 !important; color:#fff;" onclick="guardarMedidaC()" id="saveMedidaCautelar">Guardar</button>
      </div>
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div><!-- modal -->
{{--  Modal Editar Medida Cautelar  --}}
<div id="modalMedidasCautelares_E" class="modal fade"  data-backdrop="static" data-keyboard="false" >
  <div class="modal-dialog modal-dialog-xxl modal-lg" role="document">
    <div class="modal-content tx-size-sm" style="overflow-y: scroll; min-height: 800px;">
      <div class="modal-header pd-x-20">
        <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold" id="#">Editar Medida Cautelar</h6>
        <button type="button" class="close cerrar-modal btnCerrarModalMedidasCautelares_E" data-modal="modalHistory" data-thismodal="modalMedidasCautelares_E" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body tx-center pd-y-20 pd-x-20">
        <div class="row">
          <div class="col-lg-12">
          <form action="" id="frm_medidasC_E">

            <input type="hidden" id="cmp_medidaC_folioC_E" >
            <input type="hidden" id="cmp_medidaC_id_audiencia_E">
            <input type="hidden" id="cmp_medidaC_id_audiencia_medida_cautelar_E">

            <div class="row">
              <div class="col-sm-12 col-md-8 col-lg-8">
                <div class="form-group text-left">
                  <label class="form-control-label">Imputado:</label>
                  <select class="form-control" id="cmp_medidaC_imputado_E" name ="cmp_medidaC_imputado_E" autocomplete="off">
                    <option value="">Seleccione imputado</option>
                  </select>
                </div>
              </div>
              <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group text-left">
                    <label>Estatus:</label>
                    <select class="form-control" id="cmp_medidaC_estatus_E" name="cmp_medidaC_estatus_E">
                      <option value="0">Inactivo</option>
                      <option value="1">Activo</option>
                    </select>
                </div>
              </div>
            </div>

            <div class="form-group text-left">
              <label class="form-control-label">Medida Cautelar:</label>
              <select class="form-control" id="cmp_medidaC_medida_E" name ="cmp_medidaC_medida_E" autocomplete="off" onchange="elegir_menu_cautelar(this)">
                <option value="-">Seleccione Medida Cautelar</option>
                <option value="123" data-tipo="1">Medida Cautelar garantias 1</option>
                <option value="345" data-tipo="2">Medida Cautelar pagos 2</option>
                <option value="567" data-tipo="0">Medida Cautelar 3</option>
                <option value="345" data-tipo="2">Medida Cautelar pagos 4</option>
                <option value="678" data-tipo="0">Medida Cautelar 5</option>
                <option value="876" data-tipo="1">Medida Cautelar garantias 6</option>
              </select>
            </div>

            <div id="medidaC_menu1_E" style="display: none;">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group text-left">
                    <label class="form-control-label">Monto de la Garantia:</label>
                    <div class="form-group">
                      <input type="text" style="text-align:center;" class="form-control"  id="cmp_medidaC_garantia_E" placeholder="monto de la garantia"  autocomplete="off">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group text-left">
                    <label class="form-control-label">Numero de pagos:</label>
                    <div class="form-group">
                      <input type="number"  style="text-align:center;" class="form-control"  id="cmp_medidaC_pagos_E" placeholder="numero de pagos" autocomplete="off">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div id="medidaC_menu2_E" style="display: none;">
              <div class="form-group text-left">
                <label class="form-control-label">Autoridad a la que debe presentarse:</label>
                <select class="form-control" id="cmp_medidaC_autoridad_E" name ="cmp_medidaC_autoridad_E" autocomplete="off">
                  <option value="-">Seleccione una autoridad</option>
                  <option value="UMECA">UMECA</option>
                  <option value="Juez">Juez</option>
                  <option value="Otro">Otro</option>
                </select>
              </div>
            </div>

            <div class="form-group text-left">
              <label class="form-control-label">Especificaciones:</label>
              <textarea class="form-control" id="cmp_medidaC_comentarios_E" rows="3"></textarea>
            </div>
          
          </form>

          </div>
        </div>
      </div><!-- modal-body -->
      <div class="modal-footer d-flex">
        <button type="button" class="btn btn-secondary pd-x-25 mg-l-10  btnCerrarModalMedidasCautelares_E" onclick="cancelar_resolutivo('modalHistory', 'modalMedidasCautelares_E')"  id="btnCerrarModalMedidasCautelares_E">Cerrar</button>
        <button type="button" class="btn btn-secondary pd-x-25 mg-l-10" style="background:#848F33 !important; color:#fff;" onclick="actualizar_MedidaC()" id="saveMedidaCautelar_E">Actualizar</button>
      </div>
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div><!-- modal -->


{{--  // ########## MEDIDAS PROTECCION ##########  --}}
{{--  Modal Agregar Medida Proteccion  --}}
<div id="modalMedidasProteccion" class="modal fade"  data-backdrop="static" data-keyboard="false" >
  <div class="modal-dialog modal-dialog-xxl modal-lg" role="document">
    <div class="modal-content tx-size-sm" style="overflow-y: scroll; min-height: 800px;">
      <div class="modal-header pd-x-20">
        <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold" id="#">Nuevo Medida de Proteccion</h6>
        <button type="button" class="close cerrar-modal btnCerrarModalMedidasProteccion" data-modal="modalHistory" data-thismodal="modalMedidasProteccion" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body tx-center pd-y-20 pd-x-20">
        <div class="row">
          <div class="col-lg-12">
          <form action="" id="frm_medidasP">
            <input type="hidden" id="cmp_medidaP_folioC">
            <input type="hidden" id="cmp_medidaP_id_audiencia">
            <input type="hidden" id="cmp_medidaP_bandera" value="Proteccion">

            <div class="form-group text-left">
              <label class="form-control-label">Imputado:</label>
              <select class="form-control" id="cmp_medidaP_imputado" name ="cmp_medidaP_imputado" autocomplete="off">
                <option value="">Seleccione imputado</option>
              </select>
            </div>
            
            <div class="form-group text-left">
              <label class="form-control-label">Medida de Proteccion:</label>
              <select class="form-control" id="cmp_medidaP_medida" name ="cmp_medidaP_medida" autocomplete="off">
                <option value="">Seleccione Medida Proteccion</option>
                <option value="56784">Medida proteccion 1</option>
                <option value="36783">Medida proteccion 2</option>
                <option value="68729">Medida proteccion 3</option>
                <option value="89781">Medida proteccion 4</option>
                <option value="90732">Medida proteccion 5</option>
              </select>
            </div>

            <div class="form-group text-left">
              <label class="form-control-label">Comentarios adicionales:</label>
              <textarea class="form-control" id="cmp_medidaP_comentarios" rows="3"></textarea>
            </div>
          
          </form>

          </div>
        </div>
      </div><!-- modal-body -->
      <div class="modal-footer d-flex">
        <button type="button" class="btn btn-secondary pd-x-25 mg-l-10  btnCerrarModalModalMedidasProteccion" onclick="cancelar_resolutivo('modalHistory', 'modalMedidasProteccion')"  id="btnCerrarModalMedidasProteccion">Cerrar</button>
        <button type="button" class="btn btn-secondary pd-x-25 mg-l-10" style="background:#848F33 !important; color:#fff;" onclick="guardarMedidaP()" id="saveMedidaProteccion">Guardar</button>
      </div>
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div><!-- modal -->

{{--  Modal Editar Medida Proteccion  --}}
<div id="modalMedidasProteccion_E" class="modal fade"  data-backdrop="static" data-keyboard="false" >
  <div class="modal-dialog modal-dialog-xxl modal-lg" role="document">
    <div class="modal-content tx-size-sm" style="overflow-y: scroll; min-height: 800px;">
      <div class="modal-header pd-x-20">
        <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold" id="#">Editar Medida Cautelar</h6>
        <button type="button" class="close cerrar-modal btnCerrarModalMedidasProteccion_E" data-modal="modalHistory" data-thismodal="modalMedidasProteccion_E" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body tx-center pd-y-20 pd-x-20">
        <div class="row">
          <div class="col-lg-12">
          <form action="" id="frm_medidasP_E">
            <input type="hidden" id="cmp_medidaP_folioC_E" >
            <input type="hidden" id="cmp_medidaP_id_audiencia_E">
            <input type="hidden" id="cmp_medidaP_id_audiencia_medida_cautelar_E">
            <input type="hidden" id="cmp_medidaP_bandera_E" value="Proteccion">
            
            <div class="row">
              <div class="col-sm-12 col-md-8 col-lg-8">
                <div class="form-group text-left">
                  <label class="form-control-label">Imputado:</label>
                  <select class="form-control" id="cmp_medidaP_imputado_E" name ="cmp_medidaP_imputado_E" autocomplete="off" disabled>
                    <option value="">Seleccione imputado</option>
                  </select>
                </div>
              </div>
              <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group text-left">
                    <label>Estatus:</label>
                    <select class="form-control" id="cmp_medidaP_estatus_E" name="cmp_medidaP_estatus_E">
                      <option value="0">Inactivo</option>
                      <option value="1">Activo</option>
                    </select>
                </div>
              </div>
            </div>

            
            <div class="form-group text-left">
              <label class="form-control-label">Medida Proteccion:</label>
              <select class="form-control" id="cmp_medidaP_medida_E" name ="cmp_medidaP_medida_E" autocomplete="off" onchange="elegir_menu_cautelar(this)">
                <option value="">Seleccione Medida Proteccion</option>
                <option value="56784">Medida proteccion 1</option>
                <option value="36783">Medida proteccion 2</option>
                <option value="68729">Medida proteccion 3</option>
                <option value="89781">Medida proteccion 4</option>
                <option value="90732">Medida proteccion 5</option>
              </select>
            </div>

            <div class="form-group text-left">
              <label class="form-control-label">Comentarios adicionales:</label>
              <textarea class="form-control" id="cmp_medidaP_comentarios_E" rows="3"></textarea>
            </div>
          
          </form>

          </div>
        </div>
      </div><!-- modal-body -->
      <div class="modal-footer d-flex">
        <button type="button" class="btn btn-secondary pd-x-25 mg-l-10  btnCerrarModalMedidasProteccion_E" onclick="cancelar_resolutivo('modalHistory', 'modalMedidasProteccion_E')"  id="btnCerrarModalMedidasProteccion_E">Cerrar</button>
        <button type="button" class="btn btn-secondary pd-x-25 mg-l-10" style="background:#848F33 !important; color:#fff;" onclick="actualizar_MedidaP()" id="saveMedidaProteccion_E">Actualizar</button>
      </div>
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div><!-- modal -->



{{--  // ########## CONDICION DE PROCESOS ##########  --}}
{{--  Modal Agregar condicion de proceso  --}}
<div id="modalCondicionS" class="modal fade"  data-backdrop="static" data-keyboard="false" >
  <div class="modal-dialog modal-dialog-xxl modal-lg" role="document">
    <div class="modal-content tx-size-sm" style="overflow-y: scroll; min-height: 800px;">
      <div class="modal-header pd-x-20">
        <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold" id="#">Nueva Condicion de suspensión de proceso</h6>
        <button type="button" class="close cerrar-modal btnCerrarModalModalCondicionS" data-modal="modalHistory" data-thismodal="modalCondicionS" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body tx-center pd-y-20 pd-x-20">
        <div class="row">
          <div class="col-lg-12">
          <form action="" id="frm_condicionS">
            <input type="hidden" id="cmp_condicionS_folioC" >
            <input type="hidden" id="cmp_condicionS_id_audiencia">
            <input type="hidden" id="cmp_condicionS_bandera" value="Suspension">

            <div class="form-group text-left">
              <label class="form-control-label">Imputado:</label>
              <select class="form-control" id="cmp_condicionS_imputado" name ="cmp_condicionS_imputado" autocomplete="off">
                <option value="">Seleccione imputado</option>
              </select>
            </div>
            
            <div class="form-group text-left">
              <label class="form-control-label">Condicion de suspensión:</label>
              <select class="form-control" id="cmp_condicionS_medida" name ="cmp_condicionS_medida" autocomplete="off">
                <option value="">Seleccione Condicion de Suspensión</option>
                <option value="10003">Condicion de suspensión 1</option>
                <option value="10005">Condicion de suspensión 2</option>
                <option value="10006">Condicion de suspensión 3</option>
                <option value="10008">Condicion de suspensión 4</option>
                <option value="10011">Condicion de suspensión 5</option>
              </select>
            </div>

            <div class="form-group text-left">
              <label class="form-control-label">Comentarios adicionales:</label>
              <textarea class="form-control" id="cmp_condicionS_comentarios" rows="3"></textarea>
            </div>
          
          </form>

          </div>
        </div>
      </div><!-- modal-body -->
      <div class="modal-footer d-flex">
        <button type="button" class="btn btn-secondary pd-x-25 mg-l-10  btnCerrarModalModalCondicionS" onclick="cancelar_resolutivo('modalHistory', 'modalCondicionS')"  id="btnCerrarModalModalCondicionS">Cerrar</button>
        <button type="button" class="btn btn-secondary pd-x-25 mg-l-10" style="background:#848F33 !important; color:#fff;" onclick="guardarCondicionS()" id="saveCondicionS">Guardar</button>
      </div>
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div><!-- modal -->

{{--  Modal Editar Condicion de proceso  --}}
<div id="modalCondicionS_E" class="modal fade"  data-backdrop="static" data-keyboard="false" >
  <div class="modal-dialog modal-dialog-xxl modal-lg" role="document">
    <div class="modal-content tx-size-sm" style="overflow-y: scroll; min-height: 800px;">
      <div class="modal-header pd-x-20">
        <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold" id="#">Editar Condicion de suspensión de proceso</h6>
        <button type="button" class="close cerrar-modal btnCerrarModalCondicionS_E" data-modal="modalHistory" data-thismodal="modalCondicionS_E" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body tx-center pd-y-20 pd-x-20">
        <div class="row">
          <div class="col-lg-12">
          <form action="" id="frm_condicionS_E">
            <input type="hidden" id="cmp_condicionS_folioC_E" >
            <input type="hidden" id="cmp_condicionS_id_audiencia_E">
            <input type="hidden" id="cmp_condicionS_id_audiencia_medida_cautelar_E">
            <input type="hidden" id="cmp_condicionS_bandera_E" value="Suspension">
            
            <div class="row">
              <div class="col-sm-12 col-md-8 col-lg-8">
                <div class="form-group text-left">
                  <label class="form-control-label">Imputado:</label>
                  <select class="form-control" id="cmp_condicionS_imputado_E" name ="cmp_condicionS_imputado_E" autocomplete="off" disabled>
                    <option value="">Seleccione imputado</option>
                  </select>
                </div>
              </div>
              <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group text-left">
                    <label>Estatus:</label>
                    <select class="form-control" id="cmp_condicionS_estatus_E" name="cmp_condicionS_estatus_E">
                      <option value="0">Inactivo</option>
                      <option value="1">Activo</option>
                    </select>
                </div>
              </div>
            </div>

            <div class="form-group text-left">
              <label class="form-control-label">Condicion de Suspensión:</label>
              <select class="form-control" id="cmp_condicionS_medida_E" name ="cmp_condicionS_medida_E" autocomplete="off" onchange="elegir_menu_cautelar(this)">
                <option value="">Seleccione Condicion de Suspension</option>
                <option value="10003">Condicion de suspensión 1</option>
                <option value="10005">Condicion de suspensión 2</option>
                <option value="10006">Condicion de suspensión 3</option>
                <option value="10008">Condicion de suspensión 4</option>
                <option value="10011">Condicion de suspensión 5</option>
              </select>
            </div>

            <div class="form-group text-left">
              <label class="form-control-label">Comentarios adicionales:</label>
              <textarea class="form-control" id="cmp_condicionS_comentarios_E" rows="3"></textarea>
            </div>
          
          </form>

          </div>
        </div>
      </div><!-- modal-body -->
      <div class="modal-footer d-flex">
        <button type="button" class="btn btn-secondary pd-x-25 mg-l-10  btnCerrarModalCondicionS_E" onclick="cancelar_resolutivo('modalHistory', 'modalCondicionS_E')"  id="btnCerrarModalCondicionS_E">Cerrar</button>
        <button type="button" class="btn btn-secondary pd-x-25 mg-l-10" style="background:#848F33 !important; color:#fff;" onclick="actualizar_CondicionS()" id="saveCondicionS_E">Actualizar</button>
      </div>
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div><!-- modal -->



  {{--
  <div id="modalRemision" class="modal fade" style="overflow-y: scroll;">
    <div class="modal-dialog modal-lg xl mg-b-100 modalRemision-body" role="document" style="width: -webkit-fill-available;">
      <div class="modal-content tx-size-sm modalRemision-content">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"><span id="lbl-titulo-modal-remision"></span></h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div> <!-- HEADER -->
        
        <div class="modal-body pd-20">
          <div class="row mg-b-25 " id="cuerpoRemision1"><!-- datos de solicitud de audiencia -->
            <div class="col-lg-3">
              <div class="form-group">
                  <label class="form-control-label">Remitir carpeta judicial:</label>
                  <select class="form-control select2" id="tipoRemision" name="tipo_remision" autocomplete="off">
                    <option selected value="">Seleccione una Opción</option>
                    <option value="incompetencia">Por Incompetencia</option>
                    <option value="enjuiciamiento">A Tribunal de Enjuiciamiento</option>
                    <option value="ejecucion">A Unidad de Ejecución</option>
                    <option value="preventiva">Reportar Unidad de Ejecución Prisión preventiva</option>
                  </select>
                
                </div>
              </div>

              <div class="col-lg-9" align="right">
                <div class="form-group">
                  <label  id ="labelTipoRemision" text-color="#848F33 " class="labelTipoRemision"></label>
                </div>
              </div>

              <hr align="center" style="border:1px solid #848F33;" noshade="noshade" size="2" width="90%" />

            </div>
              <!-- CUERPO 2 -->
            <div class="row mg-b-25 "  id="formularioRemision"><!-- datos de solicitud de audiencia -->

              <!--  <div class="form-group" id="formularioRemision" style="display:block" > -->
            </div>
          </div>          
  
        </div><!-- modal-body -->
        <div class="modal-footer d-flex">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div> 
    </div><!-- modal-dialog -->
  </div><!-- modal -->
  --}}
  
  
  <!-- M O D A L E S   V I D A     C A R P  E T A    J U D I C I A L  -->

  <div id="modalDetalle" class="modal fade" data-keyboard="false" style="overflow-y: scroll;">
    <div class="modal-dialog modal-dialog-xxl modal-lg modal-dialog-vertical-center" role="document">
      <div class="modal-content bd-0 tx-14" style="overflow-y: scroll; min-height: 900px;">
        <div class="modal-header pd-x-20">
          <h6 class="tx-semibold mg-b-0 tx-uppercase"><span id="tituloModalDetalle"></span></h6>
          
          <button type="button" class="close cerrar-modal  btnCerrarDetalle" data-modal="modalAdministracion" data-thismodal="modalDetalle" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          
        </div> <!-- HEADER -->
        <div class="modal-body" id="bodyModalDetalle" style=" overflow-y: auto; overflow-x: auto; min-width: 700px;">
        </div>  <!-- BODY -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary cerrar-modal btnCerrarDetalle" data-modal="modalAdministracion" data-thismodal="modalDetalle" id="btnCerrarDetalle">Cerrar</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->

  <div id="modalBorrarCJ" class="modal fade" data-keyboard="false">
    <div class="modal-dialog modal-dialog-vertical-center" role="document">
      <div class="modal-content bd-0 tx-14" style="overflow-y: scroll; min-height: 500px;">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold" id="tituloModalBorrarCJ"></h6>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id_carpeta_borrar">
          <div class="row">
            <div class="col-lg-12">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Redireccionar a la unidad:</label>
                <select class="form-control select2" id="id_unidad_redireccion" name ="id_unidad_redireccion">
                  <option value="-" selected>Sin redireccionamiento, sólo borrar.</option>
                  @foreach( $ugas as $u )
                  <option value="{{$u['id_unidad_gestion']}}">{{$u['nombre_unidad']}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-lg-12">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Motivos:</label>
                <textarea class="form-control" name="motivo_redireccion" id="motivo_redireccion" rows="4"></textarea>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary" id="btnBorrarCJ" onclick="borrarCarpetaJudicial()">Borrar</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->
@endsection