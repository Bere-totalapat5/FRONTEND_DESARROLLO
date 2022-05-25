@php
  use App\Http\Controllers\clases\humanRelativeDate;
  use App\Http\Controllers\clases\utilidades;
  $humanRelativeDate = new humanRelativeDate();
@endphp
@extends('layouts.index')

@section('contenido-pageheader')
  <ol class="breadcrumb slim-breadcrumb">
    <li class="breadcrumb-item"><a href="/home">Home</a></li>
    <li class="breadcrumb-item"><a href="#">Bandejas</a></li>
    <li class="breadcrumb-item active" aria-current="page">Notificaciones</li>
  </ol>
  <h6 class="slim-pagetitle">Notificaciones</h6>
@endsection
@section('contenido-principal')
  <div class="section-wrapper mg-b-100">
    {{-- @if(!utilidades::buscarPermisoMenu($request->menu_general['response'], 4, 0)) --}}
		@if(1==2)
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
									@if(utilidades::obtener_acciones_vista($request,Session::get('usuario_id'),29,42))
										<div class="col-lg-6">
												<div class="form-group">
														<label class="form-control-label">Unidad:</label>
														<select class="form-control select2-show-search" id="unidad" name="unidad" autocomplete="off" onchange="obtenerUsuariosUnidad()">
																		<option selected value="">Todas</option>
																		@foreach ($ugas as $uga)
																						<option value="{{$uga['id_unidad_gestion']}}">{{$uga['nombre_unidad']}}</option>
																		@endforeach
														</select>
												</div>
										</div>
										<div class="col-lg-6">
												<div class="form-group">
														<label class="form-control-label">Usuario: </label>
														<select class="form-control select2-show-search" id="usuario" name="usuario" autocomplete="off">
																		<option selected value="">Todos</option>
														</select>
												</div>
										</div>
									@endif
										<div class="col-lg-4">
											<div class="form-group mg-b-10-force">
												<label class="form-control-label">Folio:</label>
												<input class="form-control" type="text" name="folio" id="folio" value="" autocomplete="off">
											</div>
										</div><!-- col-3 -->
										<div class="col-lg-4">
											<div class="form-group">
												<label class="form-control-label">Estatus: </label>
												<select class="form-control select2-show-search" id="estatus" name="estatus" autocomplete="off">
													<option value="-">Todos</option>
													<option selected value="espera">Espera</option>
													<option value="atendida">Atendida</option>
												</select>
											</div>
										</div>
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label class="form-control-label">Carpeta Judicial: </label>
                          <input class="form-control" type="text" name="carpeta_judicial" id="carpetaJudicial" value="" autocomplete="off">

                        </div>
                      </div>
                    <div class="col-lg-4">
											<div class="form-group mg-b-10-force">
												<label class="form-control-label">Carpeta Inv:</label>
												<input class="form-control" type="text" name="carpeta_inv" id="carpetaInv" value="" autocomplete="off">
											</div>
                     
										</div><!-- col-3 -->
										<div class="col-lg-4">
											<div class="form-group">
												<label class="form-control-label">Desde: </label>
												<div class="input-group">
														<div class="input-group-prepend">
																<div class="input-group-text">
																		<i class="icon ion-calendar tx-16 lh-0 op-6"></i>
																</div>
														</div>
														<input type="text" class="form-control fc-datepicker" placeholder="DD/MM/AAAA" id="desde"  name="desde" autocomplete="off">
												</div>
											</div>
										</div><!-- col-3 -->
										<div class="col-lg-4">
											<div class="form-group">
												<label class="form-control-label">Hasta: </label>
												<div class="input-group">
														<div class="input-group-prepend">
																<div class="input-group-text">
																		<i class="icon ion-calendar tx-16 lh-0 op-6"></i>
																</div>
														</div>
														<input type="text" class="form-control fc-datepicker" placeholder="DD/MM/AAAA" id="hasta"  name="hasta" autocomplete="off">
												</div>
											</div>
										</div><!-- col-3 -->
									
										<div class="col-lg-4">
											<div class="form-group mg-b-10-force">
												<label class="form-control-label">Nombre:</label>
												<input class="form-control" type="text" name="nombre_persona" id="nombrePersona" value="" autocomplete="off">
											</div>
										</div><!-- col-3 -->
										<div class="col-lg-4">
											<div class="form-group mg-b-10-force">
												<label class="form-control-label">Apellido Paterno:</label>
												<input class="form-control" type="text" name="ap_paterno_persona" id="apPaternoPersona" value="" autocomplete="off">
											</div>
										</div><!-- col-3 -->
										<div class="col-lg-4">
											<div class="form-group mg-b-10-force">
												<label class="form-control-label">Apellido Materno:</label>
												<input class="form-control" type="text" name="ap_materno_persona" id="apMaternoPersona" value="" autocomplete="off">
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
          <a href="javascript:void(0)" id="aAtendidas" ><i class="fa fa-check-square" aria-hidden="true"></i> Marcar como atendidas</a>
					<table id="tableNotificaciones" class="display dataTable dtr-inline collapsed" style="overflow-x: auto; padding-left:0; padding-rigth:0; margin-top: 10px">
						<thead style="background-color: #EBEEF1; color: #000;">
              <th class="acciones">
                <label class="ckbox d-inline-block">
                  <input type="checkbox" id="seleccionaTodas"><span></span>
                </label>
                Acciones</th>
              <th class="folio">Folio</th>
              <th class="remitente">Fecha de tarea</th>
              <th class="carpeta">Carpeta Judicial</th>
              <th class="descripcion">Descripción Tarea</th>
              <th class="remitente">Remitente</th>
              <th class="remitente">Receptor</th>
              <th class="partes">Partes Procesales</th>
              <th class="delitos">Delitos</th>
              <th class="comentarios">Comentarios</th>
						</thead>
						<tbody id="bodyNotificaciones">

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
	<link rel="stylesheet" href="{{asset("/css/bandejas/tareas.css")}}">
  <link rel="stylesheet" href="{{asset("/css/bandejas/notificaciones.css")}}">
  <style>
		.acciones{
			min-width: 100px !important;
		}
    .folio{
			min-width: 70px !important;
		}
		.tipo{
			min-width: 78px !important;
		}
		.fecha{
			min-width: 75px !important;
		}
		.estatus_flujo{
			min-width: 118px !important;
		}
		.carpeta{
			min-width: 130px !important;
		}
		.partes{
			min-width: 178px !important;
		}
		.delitos{
			min-width: 178px !important;
		}

		#tableNotificaciones{
			display: block;
		}

    #accordion .card{
      border:none !important;
    }
    #accordion .card .card-header{
      width: 75px !important;
      border: 1px solid #dee2e6 !important;
    }
    #accordion .card .card-header a{
      padding: 10px !important;
    }
    #collapseOne{
      border: 1px solid #eee !important;
      background: #f8f9fa;
    }
    #accordion a::before{
      top: 10px !important;
    }
    
  </style>
@endsection
@section('seccion-scripts-libs')  

@endsection
@section('seccion-scripts-functions')
  <script>
    const expRegFecha=/^([0-2][0-9]|3[0-1])(-)(0[1-9]|1[0-2])\2(\d{4})$/,
          expRegHora=/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/;    
    let notiSelecionada;
		buscar(1);
		setInterval(function(){
			buscar(1);
		},120000);
    setTimeout(function(){
        $('#modal_loading').modal('hide');
    }, 2000);
		
		function obtenerUsuariosUnidad(){
			$('#usuario').html('');
			$.ajax({
				method:'POST',
				url:'/public/obtener_usuarios_unidad',
				data:{
					uga:$('#unidad').val(),
				},
				success:function(response){
					$('#usuario').append('<option value="">Todos</option>');
					if(response.status==100){
						$(response.response).each(function(index, usuario_unidad){
							const {usuario, id_usuario}=usuario_unidad;
							$('#usuario').append(`<option value="${id_usuario}">${usuario}</option>`);
						});
					}
				}
			});
		}

		function buscar(pagina){
      moment.locale('es-mx');  
      $.ajax({
          method:'POST',
          url:'/public/obtener_bandeja',
          data:{
              modo:"lista",
              tipo:"notificaciones",
              pagina,
              uga:$('#unidad').val(),
              usuario:$('#usuario').val(),
              folio:$('#folio').val(),
              estatus:$('#estatus').val(),
              desde:$('#desde').val(),
              hasta:$('#hasta').val(),
              carpeta_inv:$('#carpetaInv').val(),
              nombre_persona:$('#nombrePersona').val(),
              ap_paterno_persona:$('#apPaternoPersona').val(),
              ap_materno_persona:$('#apMaternoPersona').val(),
              folio_carpeta: $('#carpetaJudicial').val(),

          },
          success:function(response){
              $('#bodyNotificaciones').html('');
              if(response.status==100){
              arrNotificaciones = response.response;
                
              $(response.response).each(function(index, tarea){
                const {id_acuerdo,id_bandeja,estatus_bandeja,creacion_bandeja,mensaje_bandeja,comentarios_bandeja ,folio_solicitud,tipo_solicitud_,fecha_recepcion_solicitud,clave_bandeja,carpeta_investigacion,cve_juez_promujer,nombre_juez_promujer , nombre_usuario_origen,partes_procesales,delitos,carpeta_judicial,descripcion_bandeja,id_usuario_origen,usuario_origen,id_usuario_destino,nombre_usuario_destino,usuario_destino}=tarea;

                let lPartes='',
                    lDelitos='',
                    lCarpetas='',
                    fhCarpetas='';

                $(carpeta_judicial).each(function(index, carpeta){
                    fechaAsignacion='';
                    if(carpeta.fecha_asignacion!=null){
                        const fhCrea=carpeta.fecha_asignacion.split(' ');
                        fechaAsignacion=formatoFecha(fhCrea[0]);
                    }
                    lCarpetas=lCarpetas.concat(`<div class="">${carpeta.folio_carpeta==null?'':carpeta.folio_carpeta}</div>`);
                    fhCarpetas=fhCarpetas.concat(`${fechaAsignacion}`);
                });

                if( partes_procesales ) {
                  const tipos_partes = Object.keys(partes_procesales);
                  $(tipos_partes).each( function( index, tipo_parte ) {
                      lPartes=lPartes.concat(`<h6 class="mg-b-0 text-capitalize">${tipo_parte}</h6>`);
                      $(partes_procesales[tipo_parte]).each( function( index, parte ) {
                          const {razon_social,nombre, apellido_paterno, apellido_materno} = parte;
                          lPartes=lPartes.concat(`<div class="b-l-2">${razon_social == null ? '' : razon_social}${nombre == null ? '' : nombre} ${apellido_paterno == null ? '' : apellido_paterno} ${apellido_materno == null ? '' : apellido_materno}</div>`);
                      });
                  });
                }

                $(delitos).each(function(index, delito){
                    lDelitos=lDelitos.concat(`<div class="b-l-2">${delito.delito}</div>`);
                });

                const tr=`
                  <tr>
                    <td class="acciones">
                      <label class="ckbox d-inline-block">
                        <input type="checkbox" class="seleccion_tarea" value="${parseInt(id_bandeja)}"><span></span>
                      </label>
                      <a href="javascript:verDatosNotificacion(${index})" data-toggle="tooltip-primary" data-placement="top" title="Información de la notificación">
                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                      </a>
                    </td>
                    <td class="folio">${id_bandeja}<br><small class="text-uppercase mg-b-0 ${estatus_bandeja=='espera'?'tx-danger':'tx-success'}">${estatus_bandeja}</small></td>
                    <td class="remitente">${creacion_bandeja == null ? '' : moment(creacion_bandeja).format('LLLL') + ' hrs.'}</td>
                    <td class="carpeta">${lCarpetas}</td>
                    <td class="descripcion">${descripcion_bandeja}</td>
                    <td class="remitente">${id_usuario_origen==0||id_usuario_origen==null?"PGJ":""}${nombre_usuario_origen==null?"":nombre_usuario_origen} ${usuario_origen==null?"":'<br>('+usuario_origen+')'}</td>
                    <td class="remitente">${id_usuario_destino==0||id_usuario_destino==null?"MASTER":""}${nombre_usuario_destino==null?"":nombre_usuario_destino} ${usuario_destino==null?"":'<br>('+usuario_destino+')'}</td>
                    <td class="partes">${lPartes}</td>
                    <td class="delitos">${lDelitos}</td>
                    <td class="comentarios">${comentarios_bandeja==null?'':comentarios_bandeja}</td>  
                  </tr>
                `;
                $('#bodyNotificaciones').append(tr);
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
              const tr=`
                  <tr>
                    <td class="unidad tx-center tx-danger" colspan="8">Sin Datos Relacionados</td>
                    <td class="d-none"></td>
                    <td class="d-none"></td>
                    <td class="d-none"></td>
                    <td class="d-none"></td>
                    <td class="d-none"></td>
                    <td class="d-none"></td>
                    <td class="d-none"></td>
                    <td class="d-none"></td>
                  <tr>
              `;

              $('#bodyNotificaciones').append(tr);

              $('.anterior').attr('onclick',`buscar(1)`);
              $('.pagina').html('1');
              $('.total-paginas').html('1');
              $('.siguiente').attr('onclick',`buscar(1)`);
              $('.ultima').attr('onclick',`buscar(1)`);
              }
          }
      });
    }
		 
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
    <div class="modal-dialog mg-b-100" role="document">
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
                  <option selected disabled value="">Elija una opción</option>
                 
              </select>
							</div>
						</div>
            <div class="col-lg-6">
							<div class="form-group">
                <label class="form-control-label">Fecha Inicio:<small>(24hrs)</small>: <span class="tx-danger">*</span></label>
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
								<label class="form-control-label">Hora Inicio:<small>(24hrs)</small>: <span class="tx-danger">*</span></label>
								<div class="d-flex">
									<div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text">
												<i class="fa fa-clock-o tx-16 lh-0 op-6"></i>
											</div><!-- input-group-text -->
										</div><!-- input-group-prepend -->
										<input  type="text" class="form-control" id="horaInicio" name="hora_inicio" placeholder="hh:mm" autocomplete="off">
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
                <label class="form-control-label">Fecha Fin:<small>(24hrs)</small>: <span class="tx-danger">*</span></label>
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
								<label class="form-control-label">Hora Fin:<small>(24hrs)</small>: <span class="tx-danger">*</span></label>
								<div class="d-flex">
									<div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text">
												<i class="fa fa-clock-o tx-16 lh-0 op-6"></i>
											</div><!-- input-group-text -->
										</div><!-- input-group-prepend -->
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
          <p style="padding-left: 5vh; padding-right: 5vh;">Guardia registrada exitósamente</p>
        </div><!-- modal-body -->
        <div class="modal-footer d-flex">
          <button type="button" class="btn btn-primary pd-x-25 mg-l-auto" data-dismiss="modal" aria-label="Close" >Aceptar</button>
        </div>
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
  </div><!-- modal -->
  <div id="modalDatosNoti" class="modal fade" style="overflow-y: scroll;" data-backdrop="static">
    <div class="modal-dialog mg-b-100" role="document" style="" >
      <div class="modal-content tx-size-sm" style="">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"><span id="titleTarea"></span></h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pd-20">         
          <div  id="divDatosNoti"></div>
        </div><!-- modal-body -->
        <div class="modal-footer d-flex">          
            <button type="button" class="btn btn-primary d-inline-block mg-l-auto" data-dismiss="modal" aria-label="Cerrar">Cerrar</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->

  <div id="modalAlertaConfirmacion" class="modal fade" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content bd-0 tx-14">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Atención</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body pd-20">
          <p class="mg-b-5" id="mensajeAlertaConfirmacion"></p>
        </div>
        <div class="modal-footer justify-content-center">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary" onclick="enviaTareasAtendidas()">Aceptar</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div>
@endsection