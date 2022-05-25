@php
  use App\Http\Controllers\clases\humanRelativeDate;
  use App\Http\Controllers\clases\utilidades;
  $humanRelativeDate = new humanRelativeDate();
@endphp

@extends('layouts.index')

@section('contenido-pageheader')
  <ol class="breadcrumb slim-breadcrumb">
    <li class="breadcrumb-item"><a href="/home">Home</a></li>
    <li class="breadcrumb-item"><a href="#">Permisos</a></li>
    <li class="breadcrumb-item active" aria-current="page">Permisos del Menú</li>
  </ol>
  <h6 class="slim-pagetitle">Guardias Penal</h6>
@endsection

@section('contenido-principal')
  <div class="section-wrapper mg-b-100">
    @if(!utilidades::buscarPermisoMenu($request->menu_general['response'], 4, 0))
      <h1 class="mg-b-50">No tiene permiso para acceder a esta sección, verifíquelo con su titular</h1>
      <a href="/home"><button class="btn btn-primary btn-block">Regresar al inicio</button><a>
    @else
			<div class="form-layout">

        <div class="d-flex justify-content-between" style="align-items: center;">
          <a style="border:1px solid #ccc; width: 70px; height: 45px;" data-toggle="collapse" data-parent="#accordion"
              href="#collapseSearchAdvance" aria-expanded="false" aria-controls="collapseSearchAdvance"
              class="btn btn-default">
              <i class="fa fa-search" aria-hidden="true"></i>
              <i class="fa fa-chevron-down" style="margin-left: 5%; font-size:0.7em;"></i>
          </a>
          <div class="row justify-content-end" style="width:80%;">
              <input type="hidden" id="filtro_consulta" name="filtro_consulta" value="">

              @foreach($acciones as $acc)
                @if($acc['id_vista_accion'] == 34 and $acc['valor'] != 0)
                  <div class="col-sm-2 pd-t-10" aling="right">
                      <a href="javascript:void(0);" onclick="agregarGuardia()"  class="btn btn-primary btn-sm btn-block "><i class="fa fa-plus mg-r-5"></i></i>Agregar Guardia</a>
                  </div>
                @endif
              @endforeach
          </div>
        </div>

        <div id="accordion" class="accordion-one mg-b-20" role="tablist" aria-multiselectable="true">
          <div class="card">
              <div id="collapseSearchAdvance" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="card-body">
                      <div>
                          <form class="row mg-b-25" autocomplete="nope">

                            <div class="col-lg-6">
                              <div class="form-group">
                                <label class="form-control-label">Unidad: <span class="tx-danger">*</span></label>
                                <select class="form-control select2" id="unidad" name="unidad" autocomplete="off">
                                  <option selected disabled value="">Elija una opción</option>
                                  @foreach ($ugas as $uga)
                                      <option value="{{$uga['id_unidad_gestion']}}">{{$uga['nombre_unidad']}}</option>
                                  @endforeach
                              </select>
                              </div>
                            </div>

                            <!--<div class="col-lg-6">
                              <div class="form-group">
                                <label class="form-control-label">Tipo:</label>
                                <select class="form-control select2" id="tipoB" name="tipoB" autocomplete="off">
                                  <option selected value="-">Todas</option>
                                  <option value="G-PROMUJER">Guardia Promujer</option>
                                  <option value="GFS-PROMUJER">Guardia Promujer Fin de Semana</option>
                              </select>
                              </div>
                            </div>-->

                          </form>
                      </div>

                      <div class="row">
                          <div class="col-lg-12">
                              <button type="button" class="btn btn-primary btn-sm btn-block mg-b-10" data-toggle="collapse" data-target="#demo" onclick="buscar(1);">Filtrar</button>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
        </div>

			</div>

			<div class="row">
				<div class="col-lg-12">
					<table id="tableGuardias" class="display dataTable dtr-inline collapsed" style="overflow-x: auto; padding-left:0; padding-rigth:0">
						<thead style="background-color: #EBEEF1; color: #000;">
              <th class="acciones">Acciones</th>
							<th class="unidad">Unidad</th>
              <th class="tipo">Tipo</th>
							<th class="responsable">Responsable</th>
							<th class="inicio">Fecha Inicio</th>
							<th class="fin">Fecha Fin</th>
              <th class="estatus">Estatus</th>
              <th class="jueces">Jueces</th>
              <th class="comentarios">Comentarios</th>
						</thead>
						<tbody id="bodyGuardias">

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
  <link rel="stylesheet" type="text/css" href="{{ asset('/css/dropzone.min.css') }}">
  <link href="{{ asset('/lib/datatables/css/jquery.dataTables.css') }}" rel="stylesheet">
  <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
  <link rel="stylesheet" href="/box/scheduler/codebase/dhtmlxscheduler_material.css?v=5.3.8" type="text/css" charset="utf-8">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="/box/scheduler/samples/common/controls_styles.css?v=5.3.8">
  <link href="{{ $entorno['version_pages']['version'] }}/lib/jt.timepicker/css/jquery.timepicker.css" rel="stylesheet">
  <link href="{{ $entorno['version_pages']['version'] }}/lib/select2/css/select2.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/js/clockpicker-gh-pages/src/clockpicker.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">


  <style>
    #accordion .card {
        border: none !important;
    }

    #accordion .card .card-header {
        width: 75px !important;
        border: 1px solid #dee2e6 !important;
    }

    #accordion .card .card-header a {
        padding: 10px !important;
    }

    #collapseSearchAdvance,
    #collapseSearchAdvance {
        border: 1px solid #eee !important;
        background: #f8f9fa;
    }

    #accordion a::before {
        top: 10px !important;
    }

    .select2-container.select2-container--default.select2-container--open{
			z-index: 1050;
		}
		.ui-datepicker.ui-widget.ui-widget-content.ui-helper-clearfix.ui-corner-all{
			z-index: 1050 !important;
		}
    .unidad{
      min-width: 190px !important;
    }
    .tipo{
      min-width: 180px !important;
    }
    .responsable{
      min-width: 110px !important;
    }
    .inicio, .fin{
      min-width: 160px !important;
    }
    .comentarios{
      min-width: 180px !important;
    }
    td.acciones{
      font-size: 16px !important;
    }
    .jueces{
      min-width: 170px !important;
    }
    .estatus{
      min-width: 50px !important;
    }
    #tableGuardias{
      display:table;
    }
    div.modal-body i.tx-success{
      color: #23BF08 !important;
    }
    @media only screen and (max-width: 1464px) {
      #tableGuardias{
        display: block;
      }
    }
  </style>
@endsection

@section('seccion-scripts-libs')
  <script src="{{ $entorno['version_pages']['version'] }}/lib/jquery-ui/js/jquery-ui.js"></script>
  <script src="{{ $entorno['version_pages']['version'] }}/lib/datatables/js/jquery.dataTables.js"></script>
  <script src="{{ $entorno['version_pages']['version'] }}/lib/datatables-responsive/js/dataTables.responsive.js"></script>
  <script src="{{ $entorno['version_pages']['version'] }}/lib/jt.timepicker/js/jquery.timepicker.js"></script>
  <script src="{{ $entorno['version_pages']['version'] }}/lib/select2/js/select2.min.js"></script>
  <script src="{{ $entorno['version_pages']['version'] }}/lib/moment/js/moment.js"></script>
  <script src="https://cdn.datatables.net/colreorder/1.5.3/js/dataTables.colReorder.min.js"></script>

  <script src="/box/scheduler/codebase/dhtmlxscheduler.js?v=5.3.8" charset="utf-8"></script>
  <script src="/box/scheduler/codebase/ext/dhtmlxscheduler_limit.js?v=5.3.8" charset="utf-8"></script>
  <script src="/box/scheduler/codebase/ext/dhtmlxscheduler_agenda_view.js?v=5.3.8" charset="utf-8"></script>
  <script src='/box/scheduler/codebase/ext/dhtmlxscheduler_timeline.js?v=5.3.8' type="text/javascript" charset="utf-8"></script>
  <script src='/box/scheduler/codebase/ext/dhtmlxscheduler_treetimeline.js?v=5.3.8' type="text/javascript" charset="utf-8"></script>
  <script src="/box/scheduler/codebase/ext/dhtmlxscheduler_minical.js?v=5.3.8" type="text/javascript" charset="utf-8"></script>
  <script src="/box/scheduler/codebase/ext/dhtmlxscheduler_units.js?v=5.3.8" type="text/javascript" charset="utf-8"></script>
  <script src="/box/scheduler/codebase/ext/dhtmlxscheduler_week_agenda.js?v=5.3.8" type="text/javascript" charset="utf-8"></script> -->

  <script src="/box/scheduler_5.3.11_enterprise/codebase/dhtmlxscheduler.js" charset="utf-8"></script>
  <script src="/box/scheduler_5.3.11_enterprise/codebase/ext/dhtmlxscheduler_limit.js" charset="utf-8"></script>
  <script src="/box/scheduler_5.3.11_enterprise/codebase/ext/dhtmlxscheduler_agenda_view.js" charset="utf-8"></script>
  <script src='/box/scheduler_5.3.11_enterprise/codebase/ext/dhtmlxscheduler_timeline.js' type="text/javascript" charset="utf-8"></script>
  <script src='/box/scheduler_5.3.11_enterprise/codebase/ext/dhtmlxscheduler_treetimeline.js' type="text/javascript" charset="utf-8"></script>
  <script src="/box/scheduler_5.3.11_enterprise/codebase/ext/dhtmlxscheduler_minical.js" type="text/javascript" charset="utf-8"></script>
  <script src="/box/scheduler_5.3.11_enterprise/codebase/ext/dhtmlxscheduler_units.js" type="text/javascript" charset="utf-8"></script>
  <script src="/box/scheduler_5.3.11_enterprise/codebase/ext/dhtmlxscheduler_week_agenda.js" type="text/javascript" charset="utf-8"></script>

  <script src="http://10.6.5.1:9002/dist/development/ovenplayer/ovenplayer.js"></script>
  <script src="/js/clockpicker-gh-pages/src/clockpicker.js"></script>
@endsection

@section('seccion-scripts-functions')
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="sweetalert2.min.js"></script>
  <script src="sweetalert2.all.min.js"></script>
  <script src="/js/clockpicker-gh-pages/src/clockpicker.js"></script>
  <link rel="stylesheet" href="sweetalert2.min.css">

  <script>

    const expRegFecha=/^([0-2][0-9]|3[0-1])(-)(0[1-9]|1[0-2])\2(\d{4})$/,
          expRegHora=/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/;
          guardias=[];

		buscar(1);

    setTimeout(function(){
        $('#modal_loading').modal('hide');
    }, 2000);

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

      // Input Masks
      $('#dateMask').mask('99/99/9999');
      $('#phoneMask').mask('(999) 999-9999');
      $('#ssnMask').mask('999-99-9999');

      // Time Picker
      // $('#tpBasic').timepicker();
      // $('#tp2').timepicker({'scrollDefault': 'now'});
      // $('#horaInicio').timepicker();
			// $('#horaFin').timepicker();

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

    $('#uga').change(function(){

      if( !$('#uga').val() || $('#uga').val() == "disabled" ) return false;

      $.ajax({
        method:'POST',
        url:'/public/obtener_jueces_guardias',
        data:{
          uga:$('#uga').val(),
        },
        success:function(response){
          $('#jueces').html('');

          if(response.status==100){

            $('#jueces').append(`<div class='col-md-6'>
                                  <label class="ckbox">
                                    <input type="checkbox" id="selectall" onclick="select_all()"><span>Todos</span>
                                    </label>
                                </div>`);

            $(response.response).each(function(index, juez){
              const {id_usuario, nombres, apellido_paterno, apellido_materno, cve_juez}=juez;
              $('#jueces').append(`<div class='col-md-6'>
                                    <label class="ckbox">
                                      <input type="checkbox" class="juez" name="juez[]" value="${id_usuario}"><span>${nombres} ${apellido_paterno} ${apellido_materno} (${cve_juez})</span>
                                      </label>
                                  </div>`);
            });

          }
        }
      });
    });

    $('.clockpicker').clockpicker({
        autoclose: true
    });

    function select_all(){
        $(".juez").click();
    }

    $("#selectall").on("click", function() {
          $(".juez").prop("checked", this.checked);
    });

    $(".case").on("click", function() {
        if ($(".juez").length == $(".juez:checked").length) {
          $("#selectall").prop("checked", true);
        } else {
          $("#selectall").prop("checked", false);
        }
    });


		function buscar(pagina){

			$.ajax({
				method:'POST',
				url:'/public/obtener_guardias',
				data:{
					unidad:$('#unidad').val(),
					tipo: 'NORMAL',
          pagina,
				},
				success:function(response){
					$('#bodyGuardias').html('');
					if(response.status==100){
            guardias=response.response.map(guardia=>{
              guardia.tipo=$('#tipoB').val();
              return guardia;
            });
						$(response.response).each(function(index, guardia){
							const {nombre_unidad, responsable, fecha_inicio, fecha_fin, estatus,
                     id_guardia, comentarios_guardia, data_jueces,estatus_activo,tipo_guardia}=guardia,
										ini=fecha_inicio.split(' ')[0].split('-'),
										inicioFecha=ini[2]+'-'+ini[1]+'-'+ini[0],
										horaInicio=fecha_inicio.split(' ')[1],
										fin=fecha_fin.split(' ')[0].split('-'),
										finFecha=fin[2]+'-'+fin[1]+'-'+fin[0],
										horaFin=fecha_fin.split(' ')[1];

              let listaJueces='';

              $(data_jueces).each(function(index, juez){
                const {nombres, ap, am}=juez;

                listaJueces=listaJueces.concat(`-${nombres} ${ap} ${am}<br>`);
              });

              var estatus_ = "<font style='color:green;'>Activa</font>";

              if(estatus_activo == "inactivo"){
                 estatus_ = "<font style='color:red;'>Inactiva</font>";
              }

							const tr=`<tr>
                          <td class="acciones tx-center">
                          @foreach($acciones as $acc)
                          @if($acc['id_vista_accion'] == 35 and $acc['valor'] != 0)
                            <a href="javascript:void(0)" onclick="editarGuardia(${index})"  data-toggle="tooltip" data-placement="a" title="Editar" ><i class="icon ion-edit"></i></a>
                          @endif
                          @endforeach
                          <a href="javascript:void(0)" onclick="modalEliminar(${id_guardia})"  data-toggle="tooltip" data-placement="a" title="eliminar" ><i class="icon ion-close-circled"></i></a>
                          </td>
													<td class="unidad">${nombre_unidad}</td>
                          <td class="unidad">${tipo_guardia}</td>
													<td class="responsable">${responsable==null?'':responsable}</td>
													<td class="inicio">${inicioFecha} ${horaInicio}</td>
													<td class="fin">${finFecha} ${horaFin}</td>
                          <td class="estatus">${estatus_}</td>
                          <td class="jueces">${listaJueces}</td>
                          <td class="comentarios">${comentarios_guardia==null?'':comentarios_guardia}</td>
												<tr>`;

							$('#bodyGuardias').append(tr);
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
													<td class="unidad tx-center" colspan="8">Sin Datos Relacionados</td>
													<td class="d-none"></td>
													<td class="d-none"></td>
													<td class="d-none"></td>
                          <td class="d-none"></td>
                          <td class="d-none"></td>
                          <td class="d-none"></td>
                          <td class="d-none"></td>
												<tr>`;
							$('#bodyGuardias').append(tr);

              $('.anterior').attr('onclick',`buscar(1)`);
              $('.pagina').html('1');
              $('.total-paginas').html('1');
              $('.siguiente').attr('onclick',`buscar(1)`);
              $('.ultima').attr('onclick',`buscar(1)`);

					}
				}
			});
		}

		function agregarGuardia(){
      limpiarDatos();
      $('#divEstatus').removeClass('d-flex').addClass('d-none');
      $('#horaInicio').val('15:00')
      $('#horaFin').val('15:00')
			$('#modalAgregarGuardia').modal('show');
      $('#buttonGuardia').attr('onclick', `guardaGuardia()`)
		}

    function guardaGuardia(){
      $('.error').removeClass('error');
      $('#modalAgregarGuardia').modal('hide');
      const validacion=validaDatos();

      if(validacion==100){
        const jueces=[];
        $('input[class=juez]:checked').each(function(index, juez){
          jueces.push($(this).val());
        });

        $.ajax({
          method:'POST',
          url:'/public/guardar_guardia',
          data:{
            unidad:$('#uga').val(),
            fecha_inicio:$('#fechaInicio').val(),
            hora_inicio:$('#horaInicio').val(),
            fecha_fin:$('#fechaFin').val(),
            hora_fin:$('#horaFin').val(),
            comentarios:$('#comentarios').val(),
            tipo:"NORMAL",
            jueces,
          },
          success:function(response){
            if(response.status==100){
              $('#modalSuccess').modal('show');
              buscar(1);
              limpiarDatos();
            }
          }
        });
      }else{
        const {campo , error} = validacion;
        if($('#'+campo).is('select')){
          $('span[aria-labelledby="select2-'+campo+'-container"]').addClass('error');
        }else{
          $('#'+campo).addClass('error');
        }
        $('#messageError').html(`${error}`);
        $('#modalError').modal('show');
      }
    }

    function validaDatos(){
      if($('#uga').val()==null) return {'estatus':0,'campo':'uga','error':'No ha seleccionado una UGA'};

      if(!$('input[class=juez]:checked').length)return {'estatus':0,'campo':'jueces','error':'No ha seleccionado a ningún juez'};

      if(!expRegFecha.test($('#fechaInicio').val())) return {'estatus':0,'campo':'fechaInicio','error':'No ha indicado una fecha de inicio o el formato es inválido'};

      if(!expRegHora.test($('#horaInicio').val())) return {'estatus':0,'campo':'horaInicio','error':'No ha indicado una hora de inicio o el formato es inválido'};

      if(!expRegFecha.test($('#fechaFin').val())) return {'estatus':0,'campo':'fechaInicio','error':'No ha indicado una fecha finalización o el formato es inválido'};

      if(!expRegHora.test($('#horaFin').val())) return {'estatus':0,'campo':'horaInicio','error':'No ha indicado una hora de fincalización o el formato es inválido'};

      return 100;
    }

    function editarGuardia(guardia){
      $('#divEstatus').removeClass('d-none').addClass('d-flex');
      $('#jueces').html('');
      const {id_unidad_gestion, nombre_unidad, responsable, fecha_inicio, fecha_fin,estatus,
             id_guardia, comentarios_guardia,data_jueces, tipo_guardia,estatus_activo}=guardias[guardia],
            ini=fecha_inicio.split(' ')[0].split('-'),
            inicioFecha=ini[2]+'-'+ini[1]+'-'+ini[0],
            horaInicio=fecha_inicio.split(' ')[1].split(':'),
            fin=fecha_fin.split(' ')[0].split('-'),
            finFecha=fin[2]+'-'+fin[1]+'-'+fin[0],
            horaFin=fecha_fin.split(' ')[1].split(':');

      $.ajax({
        method:'POST',
        url:'/public/obtener_jueces_guardias',
        data:{
          uga:id_unidad_gestion,
        },
        success:function(response){
          $('#jueces').html('');
          if(response.status==100){
            $(response.response).each(function(index, juez){
              let checked='';
              const {id_usuario, nombres, apellido_paterno, apellido_materno, cve_juez}=juez;
              if(data_jueces.some(juezAct=>juezAct.id_usuario==id_usuario)){
                checked='checked';
              }

              $('#jueces').append(`<div class='col-md-6'>
                                    <label class="ckbox">
                                      <input type="checkbox" class="juez" value="${id_usuario}" ${checked}><span>${nombres} ${apellido_paterno} ${apellido_materno} (${cve_juez})</span>
                                    </label>
                                  </div>`);
            });
          }
        }
      });

      $('#uga').val(id_unidad_gestion).select2({minimumResultsForSearch: Infinity});
      $('#tipo').val(tipo_guardia).select2({minimumResultsForSearch: Infinity});
      $('#fechaInicio').val(inicioFecha);
      $('#horaInicio').val(horaInicio[0]+':'+horaInicio[1]);
      $('#fechaFin').val(finFecha);
      $('#horaFin').val(horaFin[0]+':'+horaFin[1]);
      $('#comentarios').val(comentarios_guardia==null?'':comentarios_guardia);
      $('#buttonGuardia').attr('onclick', `guardarEdicion(${id_guardia})`);

      if(estatus_activo=="activo"){
          $('.toggle').toggles({on: true,height: 26});
      }else{
        $('.toggle').toggles({on: false,height: 26});
      }

      $('#modalAgregarGuardia').modal('show');
    }

    function modalEliminar(id_guardia){
      $('#eliminarGuardiaP').attr('onclick', `EliminarGuardia(${id_guardia})`);
      $('#modalEliminar').modal('show');
    }

    function EliminarGuardia(valor) {
      $('#modalEliminar').modal('hide');
      $.ajax({
          method: "POST",
          url: "/public/elimina_guardias",
          data: {
              id_guardia: valor,
          },
          success: function (response) {
              if (response.status == 100) {
                  buscar(1);
                  limpiarDatos();
                  $("#modalSuccess").modal("show");
              }else{
                modal_error(response.message);
              }
          },
      });

    }

    function guardarEdicion(guardia){
      $('.error').removeClass('error');
      $('#modalAgregarGuardia').modal('hide');
      const validacion=validaDatos();

      if(validacion==100){
        const jueces=[];
        $('input[class=juez]:checked').each(function(index, juez){
          jueces.push($(this).val());
        });
        let estatus=0;
        if($('#estatus').find('.toggle-on').hasClass('active')) estatus=1;
        $.ajax({
          method:'POST',
          url:'/public/guardar_edicion_guardia',
          data:{
            unidad:$('#uga').val(),
            fecha_inicio:$('#fechaInicio').val(),
            hora_inicio:$('#horaInicio').val(),
            fecha_fin:$('#fechaFin').val(),
            hora_fin:$('#horaFin').val(),
            tipo: 'NORMAL',
            comentarios:$('#comentarios').val(),
            jueces,
            guardia,
            estatus,
          },
          success:function(response){
            if(response.status==100){
              $('#modalSuccess').modal('show');
              buscar(1);
              limpiarDatos();
            }
          }
        });
      }else{
        const {campo , error} = validacion;
        if($('#'+campo).is('select')){
          $('span[aria-labelledby="select2-'+campo+'-container"]').addClass('error');
        }else{
          $('#'+campo).addClass('error');
        }
        $('#messageError').html(`${error}`);
        $('#modalError').modal('show');
      }
    }

    function limpiarDatos(unidad){
      $('#fechaInicio').val("");
      $('#fechaFin').val("");
      $('#comentarios').val("");

      var option_tipo = "<option disabled selected>Seleccione...</option>"+
                        "<option value='G-PROMUJER'>Guardia Promujer</option>"+
                        "<option value='GFS-PROMUJER'>Guardia Promujer Fin de Semana</option>";

      $("#tipo").html(option_tipo);
      $("#jueces").html("");

      $('#uga').val('disabled').trigger('change');


    }

    function modal_error(mensaje,modalAnterior=null){
      $('#messageError').html(`${mensaje}`);
      $('#btnCerrarError').attr('data-modal',modalAnterior!=null?modalAnterior:'');
      if( modalAnterior!=null ) $('#'+modalAnterior).modal('hide');
      $('#modalError').modal('show');
    }

    $(".cerrar-modal").click(function(){
      let modalOpen = $(this).attr('data-modal');
      let modalClose = $(this).attr('data-thismodal');
      
        if(modalClose == 'listaJuecesTramite'){
            $('#tramitelawer').prop('checked',false);
        }

      //console.log(modalOpen,modalClose);
      $("#"+modalClose).modal('hide');
      if( modalOpen.length ) setTimeout(function(){ $("#"+modalOpen).modal('show'); }, 500); 
    });

  </script>
@endsection

@section('seccion-modales')
  <div id="modalError" class="modal fade">
    <div class="modal-dialog" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-body tx-center pd-y-20 pd-x-20">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <i class="icon icon ion-ios-close-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
          <h4 class="tx-danger mg-b-20">Datos incompletos</h4>
          <p class="mg-b-20 mg-x-20" id="messageError"></p>
          <button type="button" class="btn btn-danger pd-x-25" data-dismiss="modal" aria-label="Close" onclick="agregarGuardia()">Aceptar</button>
        </div><!-- modal-body -->
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
  </div><!-- modal -->

  <div id="modalAgregarGuardia" class="modal fade modal-agregar-delito">
    <div class="modal-dialog modal-lg mg-b-100" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Agregar Guardia</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pd-20">
          <div class="row form-layout">
            <div class="col-lg-12">
							<div class="form-group">
								<label class="form-control-label">Unidad: <span class="tx-danger">*</span></label>
								<select class="form-control select2" id="uga" name="uga" autocomplete="off">
                  <option value="disabled" disabled selected>Seleccione...</option>
                  @foreach ($ugas as $uga)
                    @if($uga['id_unidad_gestion']!=34)
                      <option value="{{$uga['id_unidad_gestion']}}">{{$uga['nombre_unidad']}}</option>
                    @endif
                  @endforeach
              </select>
							</div>
						</div>
            <div class="col-lg-12">
							<div class="form-group">
								<label class="form-control-label">Jueces: <span class="tx-danger">*</span></label>
								<div class="row" id="jueces">

                </div>
							</div>
						</div>
            <div class="col-lg-6">
							<div class="form-group">
                <label class="form-control-label">Fecha Inicio:<span class="tx-danger">*</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                        </div>
                    </div>
                    <input type="text" class="form-control fc-datepicker" placeholder="DD/MM/AAAA" id="fechaInicio" name="fecha_inicio" autocomplete="off">
                </div>
              </div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label class="form-control-label">Hora Inicio: <small>(24hrs)</small>: <span class="tx-danger">*</span></label>
                <div class="d-flex">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <i class="fa fa-clock-o tx-16 lh-0 op-6"></i>
                    </div>
                  </div>
									<div class="input-group clockpicker" data-placement="left" data-align="top" data-autoclose="true">
										<input  type="text" class="form-control" id="horaInicio" name="hora_inicio" placeholder="hh:mm" autocomplete="off">
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
                <label class="form-control-label">Fecha Fin:<span class="tx-danger">*</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                        </div>
                    </div>
                    <input type="text" class="form-control fc-datepicker" placeholder="DD/MM/AAAA" id="fechaFin" name="fecha_fin" autocomplete="off">
                </div>
              </div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label class="form-control-label">Hora Fin <small>(24hrs)</small>: <span class="tx-danger">*</span></label>
                <div class="d-flex">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <i class="fa fa-clock-o tx-16 lh-0 op-6"></i>
                    </div>
                  </div>
									<div class="input-group clockpicker" data-placement="left" data-align="top" data-autoclose="true">
										<input  type="text" class="form-control" id="horaFin" name="hora_fin" placeholder="hh:mm" autocomplete="off">
									</div>
								</div>
							</div>
						</div>
            <div class="col-12">
              <div class="form-group">
                <label class="form-control-label">Comentarios:</label>
                <textarea  class="form-control"  id="comentarios" name="comentarios" autocomplete="off"></textarea>
              </div>
            </div>
            <div class="col-lg-12 mg-t-20 d-flex" id="divEstatus">
              <div>
                <label class="form-control-label mg-b-0">Activa:</label>
              </div>
              <div class="toggle-wrapper mg-l-15" id="estatus">
                <div class="toggle toggle-light primary"></div>
              </div>
            </div>
          </div>

        </div><!-- modal-body -->
        <div class="modal-footer d-flex">
          <button type="button" class="btn btn-secondary d-block" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary d-block ml-auto" id="buttonGuardia">Guardar</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->

  <div id="modalSuccess" class="modal fade"  data-backdrop="static" data-keyboard="false" >
    <div class="modal-dialog" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-body tx-center pd-y-20 pd-x-20">
          <i class="icon ion-ios-checkmark-outline tx-100 tx-success lh-1 mg-t-20 d-inline-block"></i>
          <h6 class="tx-success tx-semibold mg-b-20">Hecho!</h6>
          <p style="padding-left: 5vh; padding-right: 5vh;">Se guardaron los datos correctamente</p>
        </div><!-- modal-body -->
        <div class="modal-footer d-flex">
          <button type="button" class="btn btn-primary pd-x-25 mg-l-auto" data-dismiss="modal" aria-label="Close" >Aceptar</button>
        </div>
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
  </div><!-- modal -->

  <div id="modalEliminar" class="modal fade" data-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Eliminar Guardia Promujer</h5>
        </div>
        <div class="modal-body">
          <input type="hidden" id="idGrupo">
          <input type="hidden" id="iduser_input">
          <h5>¿Deseas eliminar la Guardia?</h5>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary cerrar-modal" data-modal="modalHistory" data-thismodal="modalEliminar">Cerrar</button>
          <button type="button" class="btn btn-danger" id="eliminarGuardiaP" onclick="EliminarGuardia()">Eliminar</button>
        </div>
      </div>
    </div>
  </div>
@endsection
