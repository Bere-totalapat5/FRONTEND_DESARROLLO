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
    <li class="breadcrumb-item active" aria-current="page">Documentos enviados a USMC</li>
  </ol>
  <h6 class="slim-pagetitle">Consulta de Documentos Enviados a USMC</h6>
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
							Búsqueda Avanzada
							</a>
						</div><!-- card-header -->
						<div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne">
							<div class="card-body">
									<div class="row mg-b-15">
                    
                    <div class="col-lg-4">
                      <div class="form-group mg-b-10-force">
                        <label class="form-control-label">Unidad:</label>
                        <select class="form-control-lg select2 valid" id="id_unidad_gestion" name="id_unidad_gestion">
                          <option value=""  selected>Todas</option>
                          @foreach($unidades as $unid)
                          <option value="{{$unid['id_unidad_gestion']}}">{{$unid['nombre_unidad']}}</option>
                          @endforeach
                          </select>
                      </div>
                    </div><!-- col-3 -->

                    <div class="col-lg-4">
                      <div class="form-group mg-b-10-force">
                        <label class="form-control-label">Carpeta Judicial:</label>
                        <input class="form-control" type="text" name="carpeta_judicial" id="carpeta_judicial"  autocomplete="off">
                      </div>
                    </div><!-- col-3 -->

                    <div class="col-lg-4">
                      <div class="form-group mg-b-10-force">
                        <label class="form-control-label">Folio / Acuse:</label>
                        <input class="form-control" type="text" name="folio_acuse" id="folio_acuse"  autocomplete="off">
                      </div>
                    </div><!-- col-3 -->

                    <div class="col-lg-3">
                      <div class="form-group mg-b-10-force">
                        <label class="form-control-label">Estatus Proceso:</label>
                        <select class="form-control select2" id="estatus_proceso" name ="estatus_proceso">
                          <option value="-" selected>Todos</option>
                          <option value="por_firmar">Por Firmar</option>
                          <option value="por_corregir">Por Corregir</option>
                          <option value="delegado">Delegado</option>
                          <option value="corregido">Corregido</option>
                          <option value="firmado">Firmado</option>
                          <option value="no_firmado">No Firmado</option>
                        </select>    
                      </div>
                    </div><!-- col-3 -->


                    <div class="col-lg-3">
                      <div class="form-group mg-b-10-force">
                        <label class="form-control-label">Estatus Respuesta:</label>
                        <select class="form-control select2" id="estatus_respuesta" name ="estatus_respuesta">
                          <option value="-" selected>Todos</option>
                          <option value="SUCCESS">Exitosos</option>
                          <option value="ERROR">Erroneos</option>
                        </select>    
                      </div>
                    </div><!-- col-3 -->

                    
                    <div class="col-lg-3">
                      <div class="form-group mg-b-10-force">
                        <label class="form-control-label">Desde la fecha:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                </div>
                            </div>
                            <input type="text" class="form-control fc-datepicker" placeholder="DD-MM-AAAA" value="" id="fecha_desde" name="fecha_desde" autocomplete="off">
                        </div>
                      </div>
                    </div><!-- col-3 -->
                    
                    <div class="col-lg-3">
                      <div class="form-group mg-b-10-force">
                        <label class="form-control-label">Hasta la fecha:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                </div>
                            </div>
                            <input type="text" class="form-control fc-datepicker" placeholder="DD-MM-AAAA" value="" id="fecha_hasta" name="fecha_hasta" autocomplete="off">
                        </div>
                      </div>
                    </div><!-- col-3 -->
                    
									<div class="row col-lg-15">
										<div class="col-lg-12 d-flex">
											<button class="btn btn-primary mg-l-auto " onclick="pintarOficiosEnviadosUSMC(1)">Buscar</button>
										</div>
									</div>
							</div><!-- card-bod -->
						</div>
					</div>
				</div><!-- accordion -->
			</div>
			<div class="row">
				<div class="col-lg-12">
          
					<table id="tableOficiosEnviadosUSMC" class="table" width="100%" style="display:table;">
            <thead>
              <tr>
                <th>#</th>
                <th>Accion</th>
                <th>Unidad</th>
                <th>Carpeta Judicial</th>
                <!-- <th>Carpeta Investigacion</th> -->
                <th>Fecha Flujo</th>
                <th>Estatus Flujo</th>
                <th>Estatus USMC</th>
                <th>Folio USMC</th>
                <th>Mensaje Error</th>
                <th>Tipo Oficio</th>
                <th>Nombre Oficio</th>
                <th>Tamaño</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>

          <div class="pagination-wrapper justify-content-between">
            <ul class="pagination mg-b-0">
              <li class="page-item">
                <a class="page-link primera-DG-USMC" href="javascript:void(0)" aria-label="Last" onclick="pintarOficiosEnviadosUSMC(1)">
                  <i class="fa fa-angle-double-left"></i>
                </a>
              </li>
              <li class="page-item">
                <a class="page-link anterior-DG-USMC" href="javascript:void(0)" aria-label="Next" onclick="pintarOficiosEnviadosUSMC(1)">
                  <i class="fa fa-angle-left"></i>
                </a>
              </li>
            </ul>

            <ul class="pagination mg-b-0">
              <li class="page-item">Página <span class="pagina-DG-USMC">1</span> de <span class="total-paginas-DG-USMC">1</span></li>
            </ul>

            <ul class="pagination mg-b-0">
              <li class="page-item">
                <a class="page-link siguiente-DG-USMC" href="javascript:void(0)" aria-label="Next" onclick="pintarOficiosEnviadosUSMC(1)">
                  <i class="fa fa-angle-right"></i>
                </a>
              </li>
              <li class="page-item">
                <a class="page-link ultima-DG-USMC" href="javascript:void(0)" aria-label="Last" onclick="pintarOficiosEnviadosUSMC(1)">
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

    .border-none{
      border: none !important;
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

  <script src="{{ $entorno["version_pages"]["version"] }}/lib/jt.timepicker/js/jquery.timepicker.js"></script>
  <script src="{{ $entorno["version_pages"]["version"] }}/lib/select2/js/select2.min.js"></script>
@endsection
@section('seccion-scripts-functions')
  <script>
    const expRegFecha=/^([0-2][0-9]|3[0-1])(-)(0[1-9]|1[0-2])\2(\d{4})$/,
          expRegHora=/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/;

    const unidades = @php echo  json_encode($unidades) @endphp;
    
    arrO = [];

    $(document).ready(function() {
      pintarOficiosEnviadosUSMC(1);
  
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

    });

    
    function pintarOficiosEnviadosUSMC(pagina=1){
      $("#tableOficiosEnviadosUSMC tbody tr").remove();
      $.ajax({
        method:'POST',
        url:'/public/obtener_documentos_generados',
        data:{
          unidad_gestion : $("#id_unidad_gestion").val(),
          carpeta_judicial : $("#carpeta_judicial").val(),
          estatus_proceso : $("#estatus_proceso").val(),
          estatus_respuesta_usmc : $("#estatus_respuesta").val(),
          folio_usmc : $("#folio_acuse").val(),
          fecha_desde : $("#fecha_desde").val() ? $("#fecha_desde").val().split("-").reverse().join("-") : null,
          fecha_hasta : $("#fecha_hasta").val() ? $("#fecha_hasta").val().split("-").reverse().join("-") : null,
          bandera_ws_usmeca : 1,
          pagina,
        }, 
        success:function(response){
          console.log(response);
          arrO = [];
          if( response.status == 100){
            arrO = response.response;
            $(response.response).each(function(index_doc, doc){
              let d=doc;
              
              let strVerDoc = `<i class="fas fa-file-pdf" data-toggle="tooltip-primary" data-placement="top" title="Ver documento" onclick="verDocumentoGenerado(${doc.id_documento},'enviados_usmc')"></i>`;
              let strReenviarDoc = `<i class="fas fa-share-square" data-toggle="tooltip-primary" data-placement="top" title="Reenviar Oficio a USMC" onclick="reenviarSolicitudUSMC(${doc.id_documento})"></i>`;

              if(doc.sincronizacion_ws_usmeca=='SUCCESS') strReenviarDoc = ``;

              $("#tableOficiosEnviadosUSMC tbody").append(`
                <tr>
                  <td>${index_doc + 1}</td>
                  <td>${strVerDoc} ${strReenviarDoc}</td>
                  <td>${ unidades.filter( x=>x.id_unidad_gestion == doc.id_unidad )[0].nombre_unidad }</td>
                  <td>${ doc.folio_carpeta }</td>
                  <td>${doc.creacion != null ? doc.creacion : ''}</td>
                  <td>${ doc.flujo_estatus }</td>
                  <td>${ doc.sincronizacion_ws_usmeca==null ? doc.sincronizacion_ws_usmeca : doc.sincronizacion_ws_usmeca }</td>
                  <td>${ doc.folio_ws_usmeca==null ? doc.folio_ws_usmeca : doc.folio_ws_usmeca }</td>
                  <td>${ doc.mensaje_ws_usmeca==null ? '' : doc.mensaje_ws_usmeca }</td>
                  <td> <a href="#" onclick="verDocumentoGenerado(${doc.id_documento},'enviados_usmc');" > ${doc.nombre_formato} </a> </td>
                  <td> <a href="#" onclick="verDocumentoGenerado(${doc.id_documento},'enviados_usmc');" > ${doc.nombre_archivo} </a> </td>
                  <td>${ Number.parseFloat( doc.tamanio_archivo/1048576 ).toFixed(2)} MB</td>
                </tr>
              `);
            }); 
            if(!arrO.length){
              $('#tableOficiosEnviadosUSMC tbody').append(`
              <tr>
                <td colspan="12">
                  <span class="tx-italic">No hay oficios enviados a USMC</span>
                </td>
              </tr>
            `);
            }
            if(typeof(response.response_paginacion)!='undefined'){
                let anterior=pagina==1?1:pagina-1;
                let totalPaginas=response.response_paginacion.paginas_totales;
                let siguiente=pagina+1>=totalPaginas?totalPaginas:pagina+1;
                
                $('.anterior-DG-USMC').attr('onclick',`pintarOficiosEnviadosUSMC(${anterior})`);
                $('.pagina-DG-USMC').html(pagina);
                $('.total-paginas-DG-USMC').html(totalPaginas);
                $('.siguiente-DG-USMC').attr('onclick',`pintarOficiosEnviadosUSMC(${siguiente})`);
                $('.ultima-DG-USMC').attr('onclick',`pintarOficiosEnviadosUSMC(${totalPaginas})`);
              }
          }else{
            $('#tableOficiosEnviadosUSMC tbody').append(`
              <tr>
                  <td colspan="5">
                    <span class="tx-italic">No hay documentos generados</span>
                  </td>
              </tr>
            `);

            $('.anterior-DG-USMC').attr('onclick',`pintarOficiosEnviadosUSMC(1)`);
            $('.pagina-DG-USMC').html('1');
            $('.total-paginas-DG-USMC').html('1');
            $('.siguiente-DG-USMC').attr('onclick',`pintarOficiosEnviadosUSMC(1)`);
            $('.ultima-DG-USMC').attr('onclick',`pintarOficiosEnviadosUSMC(1)`);
            modal_error(response.message,'modalAdministracion');
          }
        } // success
      }); // ajax
    }

    function verDocumentoGenerado(id_documento){
      oficio = arrO.filter(x=>x.id_documento==id_documento)[0]
      fecha = oficio.creacion ;
      
      $.ajax({
        method:'POST',
        url:'/public/obtener_ultima_version_documento_generado',
        data:{
          carpeta : oficio.id_carpeta_judicial,
          id_documento,
          modo : 'pdf',
        },
        success:function(response){
          console.log('RESPUESTA DG PDF :',response);
          if( response.status == 100){
            if( response.response.split('.')[1] == 'pdf' )
              modal_detalle('DOCUMENTO',`
                <div class="file-group">
                  <div class="file-item">
                    <div class="row no-gutters wd-100p">
                      <div class="col-9 col-md-7 d-flex align-items-center">
                        <i class="fa fa-file-pdf-o" style="font-size:20px;"></i>
                        <a href="">${oficio.nombre_archivo}.pdf</a>
                      </div><!-- col-6 -->
                      <div class="col-3 col-md-2 tx-right tx-sm-left">${ Number.parseFloat( oficio.tamanio_archivo/1048576 ).toFixed(3)} MB</div>
                      <div class="col-6 col-md-3 tx-right mg-t-5 mg-sm-t-0">${fecha.split(' ')[0].split('-').reverse().join('-')} ${fecha.split(' ')[1]}</div>
                    </div><!-- row -->
                  </div><!-- file-item -->
                </div>
                <object data="${response.response}"	width="100%"	height="600">	</object>
              `);
            else
              window.open(response.response, '_blank');
          }else{
            modal_error(response.message,'modalAdministracion');
          }
        } // success
      }); // ajax
    } 

    function reenviarSolicitudUSMC(id_documento){
      oficio = arrO.filter(x=>x.id_documento==id_documento)[0]
      
      
      $("#modalAdministracion").modal('hide');
      loading(true);
      $.ajax({
        method:'POST',
        url:'/public/enviar_solicitud_usmeca',
        data:{
          carpeta :  oficio.id_carpeta_judicial,
          id_documento,
        },
        error:function(err){
          loading(false);
          setTimeout(function(){ modal_error(err,'modalAdministracion'); },1500);

        },
        success:function(response){
          //$("#modalAdministracion").modal('show');
          console.log('RESPUESTA REENVIAR USMC :',response);
          if( response.status == 100){
            loading(false);
            setTimeout(function(){ modal_success('Oficio reenviado a USMC <br> Folio: '+response.response.folio,'modalAdministracion'); },1000); 
            pintarDocumentosGenerados(1);
            pintarOficiosEnviadosUSMC(1);
          }else{
            loading(false);
            modal_error('Error USMC dice: '+response.response.mensaje,'modalAdministracion');
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

    function get_fecha_letra(fecha, options=null){
      fl = new Date(fecha);
      options = options?? { year: 'numeric', month: 'long', day: 'numeric' };

      return fl.toLocaleDateString("es-ES", options);
    }

   

  </script>                                                 
@endsection
@section('seccion-modales')
  
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

@endsection