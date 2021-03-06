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
    <li class="breadcrumb-item active" aria-current="page">Documentos</li>
  </ol>
  <h6 class="slim-pagetitle">Documentos</h6>
@endsection
@section('contenido-principal')
  <div class="section-wrapper mg-b-100">
    @if(!utilidades::buscarPermisoMenu($request->menu_general['response'], 30, 0))
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
									@if(utilidades::obtener_acciones_vista($request,Session::get('usuario_id'),30,43))
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
                  <div class="col-lg-3">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">Folio:</label>
                      <input class="form-control" type="text" name="folio" id="folio" value="" autocomplete="off">
                    </div>
                  </div><!-- col-3 -->
                  <div class="col-lg-3">
                    <div class="form-group">
                      <label class="form-control-label">Estatus: </label>
                      <select class="form-control select2-show-search" id="estatus" name="estatus" autocomplete="off">
                        <option value="-">Todos</option>
                        <option selected value="espera">Espera</option>
                        <option value="atendida">Atendida</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-lg-3">
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
                  <div class="col-lg-3">
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
                  <div class="col-lg-2">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label" >Carpeta judicial:</label>
                      <input class="form-control" type="text" name="carpeta_judicial" id="carpetaJudicial" value="" autocomplete="off">
                    </div>
                  </div>
                  <div class="col-lg-2">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">Carpeta Inv:</label>
                      <input class="form-control" type="text" name="carpeta_inv" id="carpetaInv" value="" autocomplete="off">
                    </div>
                  </div><!-- col-3 -->
                  <div class="col-lg-2">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">Nombre:</label>
                      <input class="form-control" type="text" name="nombre_persona" id="nombrePersona" value="" autocomplete="off">
                    </div>
                  </div><!-- col-3 -->
                  <div class="col-lg-3">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">Apellido Paterno:</label>
                      <input class="form-control" type="text" name="ap_paterno_persona" id="apPaternoPersona" value="" autocomplete="off">
                    </div>
                  </div><!-- col-3 -->
                  <div class="col-lg-3">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">Apellido Materno:</label>
                      <input class="form-control" type="text" name="ap_materno_persona" id="apMaternoPersona" value="" autocomplete="off">
                    </div>
                  </div><!-- col-3 -->
								</div>
								<div class="row col-lg-12">
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
          {{-- <button class="btn btn-primary btn-sm mg-b-15" onclick="firmado('masivo')">Firmar Seleccionados</button> --}}
          <a href="javascript:void(0)" id="aAtendidas" class="mg-b-10"><i class="fa fa-check-square" aria-hidden="true"></i> Marcar como atendidas</a>
					<table id="tableDocumentos" class="display dataTable dtr-inline collapsed mg-t-10" style="overflow-x: auto; padding-left:0; padding-rigth:0; margin-top: 10px;">
						<thead style="background-color: #EBEEF1; color: #000;">
              <th class="seleccion">
                <label class="ckbox">
                  <input type="checkbox" id="selecciona-todos"><span></span>
                </label>
              </th>
              <th class="acciones">Acciones</th>
              <th class="folio">Folio</th>
              <th class="remitente">Fecha de recepcion</th>
              <th class="carpeta">Carpeta asociada</th>
              <th class="remitente">Nombre del documento</th>
              <th class="remitente">Tipo de documento</th>
              <th class="estatus">Estatus</th>
              <th class="remitente">Remitente</th>
              <th class="partes">Partes Procesales</th>
              <th class="delitos">Delitos</th>
              <th class="comentarios">Comentarios</th>
						</thead>
						<tbody id="bodyDocumentos">

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
  
  <link href="{{asset("/lib/datatables/css/jquery.dataTables.css")}}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
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
  <link rel="stylesheet" href="/css/bandejas/documentos.css">
  <style>
		.acciones{
			min-width: 85px !important;
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

		#tableDocumentos{
			display: block;
		}

    #modal_firel .modal-dialog{
      width: calc( 100% - 16px );
    }

    @media only screen and (min-width: 575px) {
      #modal_firel .modal-dialog{
        min-width: 95%;
      }
    }

    @media only screen and (min-width: 1017px) {
      #modal_firel .modal-dialog{
        min-width: 1000px;
      }
    }
    /* @media (min-width: 992px){
      .modal-lg.xl {
          max-width: 1017px;
      }
    } */

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
  <script src="/lib/datatables/js/jquery.dataTables.js"></script>
	<script src="/js/bandejas/documentos.js"></script>
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
  <script src="/js/carpetas/data_carpeta.js"></script>
  
@endsection
@section('seccion-scripts-functions')
<script>
    const unidadGestion=@php echo Session::get('id_unidad_gestion')==''?0:Session::get('id_unidad_gestion'); @endphp;
    const tUsuario=@php echo Session::get('id_tipo_usuario')==''?0:Session::get('id_tipo_usuario'); @endphp;
    let tables = {};

    $('#tableDocumentos').on('change', '#selecciona-todos', function(){
        $(".seleccion-tarea").prop("checked", this.checked);
    });

    function buscar(pagina){
      $.ajax({
          method:'POST',
          url:'/public/obtener_bandeja',
          data:{
              modo:"lista",
              tipo:"firmas",
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
              $('#bodyDocumentos').html('');
              if(response.status==100){
              arrTareas=response.response;
                console.log(arrTareas)
              $(response.response).each(function(index, tarea){
                  const {tabla_asociada,id_tabla_asociada,id_acuerdo,id_bandeja,estatus_bandeja,creacion_bandeja,mensaje_bandeja,comentarios_bandeja ,folio_solicitud,tipo_solicitud_,fecha_recepcion_solicitud,clave_bandeja,carpeta_investigacion,cve_juez_promujer,nombre_juez_promujer , nombre_usuario_origen,partes_procesales,delitos,carpeta_judicial,descripcion_bandeja,id_usuario_origen,usuario_origen,id_carpeta_judicial,tipos_usuario_origen,fecha_creacion_acuerdo}=tarea;

                  let lPartes='',
                      lDelitos='',
                      lCarpetas='';

                  $(carpeta_judicial).each(function(index, carpeta){
                      fechaAsignacion='';
                      if(carpeta.fecha_asignacion!=null){
                          const fCrea=carpeta.fecha_asignacion.split(' ')[0].split('-');
                          fechaAsignacion='<br>'+ fCrea[2]+'-'+fCrea[1]+'-'+fCrea[0];
                      }
                      lCarpetas=lCarpetas.concat(`<div class="">${carpeta.folio_carpeta==null?'':carpeta.folio_carpeta}</div>`);
                  });

                  if(partes_procesales){
                    const tipos_partes=Object.keys(partes_procesales);
                    $(tipos_partes).each(function(index, tipo_parte){
                        lPartes=lPartes.concat(`<h6 class="mg-b-0 text-capitalize">${tipo_parte}</h6>`);
                        $(partes_procesales[tipo_parte]).each(function(index, parte){
                            const {razon_social,nombre, apellido_paterno, apellido_materno} = parte;
                            lPartes=lPartes.concat(`<div class="b-l-2">${razon_social==null?'':razon_social}${nombre==null?'':nombre} ${apellido_paterno==null?'':apellido_paterno} ${apellido_materno==null?'':apellido_materno}</div>`);
                        });
                    });
                  }

                  $(delitos).each(function(index, delito){
                      lDelitos=lDelitos.concat(`<div class="b-l-2">${delito.delito}</div>`);
                  });

                  let creacionBandeja='';
                  if(creacion_bandeja!=null){
                      const fCrea=creacion_bandeja.split(' ')[0].split('-');
                      creacionBandeja=fCrea[2]+'-'+fCrea[1]+'-'+fCrea[0];
                  }



                  let fechaRecepcionSolicitud='';
                  if(fecha_creacion_acuerdo!=null){
                      const fRep=fecha_creacion_acuerdo.split(' ')[0].split('-');
                      fechaRecepcionSolicitud=fRep[2]+'-'+fRep[1]+'-'+fRep[0]+'<br>';
                  }

                  let datosDocumento='';
                  // if(clave_bandeja=='RS'){
                      datosDocumento=`
                          <span>${tipo_solicitud_}</span>
                          <span>${folio_solicitud}</span>
                          <span>${fechaRecepcionSolicitud}</span>
                          <span>${carpeta_investigacion==null?'':fechaRecepcionSolicitud}</span>
                          <span class="font-weight-bold">${cve_juez_promujer==null?'':'('+cve_juez_promujer+')'} ${nombre_juez_promujer==null?'':nombre_juez_promujer}</span>
                      `;
                  // }

                  let tipo_documento = '';
                  if(tabla_asociada=='acuerdos'){
                    urlDoc=`/obtener_ultima_version_acuerdo/${id_acuerdo}`;
                    tipo_documento = 'acuerdo';
                  }else if(tabla_asociada=='carpetas_judiciales_documentos'){
                    urlDoc=`/obtener_ultima_version_oficio/${id_carpeta_judicial}/${id_tabla_asociada}`
                    tipo_documento = 'carpetas_judiciales_documentos';
                  }

                  let tr = `<tr id="row_${index}"><td class="seleccion"><label class="ckbox"><input type="checkbox" class="seleccion-tarea" name="seleccion-tarea" value="${id_bandeja}"><span></span></label></td>`;
                  
                  tr += `<td class="acciones"><div class="icono"><a href="${urlDoc}" target="_blank" data-toggle="tooltip" title="Ver Documento"><i class="fa fa-file-pdf-o"></i></a></div>`;

                  if( tarea.estatus_bandeja != "atendida" )
                    tr += `<div class="icono">  <i class="fa fa-pencil-square-o" data-toggle="tooltip" title="Firmar" onclick="firmado('indiv', ${index}, ${id_acuerdo})" doc=${id_acuerdo}></i></div>
                    <div class="icono warning"><i class="fa fa-arrow-left"  data-toggle="tooltip" title="Regresar" onclick=regresar(${index},${tabla_asociada=='carpetas_judiciales_documentos'?id_tabla_asociada:id_acuerdo},'${tipo_documento}')></i></div>`;
                            
                  tr += `</td>
                      <td class="folio">${id_bandeja}<br><small class="text-uppercase mg-b-0 ${estatus_bandeja=='espera'?'tx-danger':'tx-success'}"></small></td>
                      <td class="carpeta">${fechaRecepcionSolicitud}</td>
                      <td class="carpeta">${lCarpetas}</td>
                      <td class="datos-documento">${descripcion_bandeja}</td>
                      <td class="datos-documento">${datosDocumento}</td>
                      <td class="estatus">${estatus_bandeja}</td>
                      <td class="remitente">${id_usuario_origen==0||id_usuario_origen==null?"PGJ":""}${nombre_usuario_origen==null?"":nombre_usuario_origen} ${ usuario_origen == null ? "" : '<br> ('+usuario_origen+')' } <br>${ tipos_usuario_origen[0] == undefined ? '' : tipos_usuario_origen[0] }</td>
                      <td class="partes">${lPartes}</td>
                      <td class="delitos">${lDelitos}</td>
                      <td class="comentarios">${comentarios_bandeja==null?'':comentarios_bandeja}</td>
                    <tr>
                  `;
                  
                  $('#bodyDocumentos').append(tr);
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
                  <tr>
              `;

              $('#bodyDocumentos').append(tr);

              $('.anterior').attr('onclick',`buscar(1)`);
              $('.pagina').html('1');
              $('.total-paginas').html('1');
              $('.siguiente').attr('onclick',`buscar(1)`);
              $('.ultima').attr('onclick',`buscar(1)`);
              }
          }
      });
    }

    function regresar(index,acuerdo,tipo_documento='acuerdo'){
      const leyenda_tipo_documento = tipo_documento == 'acuerdo' ? 'acuerdo' : 'documento'
      $('#modal_firel').modal('hide');
      abreModal('modal_loading');
      // verTarea(index);
      $('#mensajeConfirmacion').html(`
        <div class="warning-alert">
          <i class="fa fa-exclamation" aria-hidden="true"></i>
        </div>
        <p class="tx-center">¿Está seguro de mandar el ${leyenda_tipo_documento} a corrección?<br>El ${leyenda_tipo_documento} se enviará a ${arrTareas[index].nombre_usuario_origen} (${arrTareas[index].usuario_origen})</p>
        <div class="form-group mg-b-10-force">
          <label class="form-control-label">Comentarios:</label>
          <textarea class="form-control" type="text" id="comentariosRegresar" name="comentariosRegresar" autocomplete="off" value=""></textarea>
        </div>
      `);
      $('#botonConfirmar').html(`<button type="button" class="btn btn-primary" onclick="enviarCorreccion(${acuerdo},'${tipo_documento}')" >Continuar</button>`);
      setTimeout(()=>{
        abreModal('modalConfirmacion');
        $('#modal_loading').modal('hide');
      },1000);
      
    }

    function obtenerUltimaVersionOficio(id_carpeta_judicial, documento){
      $.ajax({
        method:'POST',
        url:'/public/obtener_ultima_version_oficio',
        data:{id_carpeta_judicial,documento},
        success: function(response){
          if( response.status == 100 ){
            $('#request_usmeca').val(JSON.stringify(response.request_usmeca));

            let anexos = response.documentos_anexados.split(',');
            let lista = ``;
            
            console.log(response);
              
            for( var i in anexos){
              lista = lista + `
                <li class="list-group-item">
                  <i class="fa fa-close fa-2x tx-danger" onclick="quitar_anexo(this)"></i>  &nbsp; &nbsp; &nbsp;
                  <a href="#" class="anexos-adjuntados" onclick="obtenerAnexoOficio(${id_carpeta_judicial},${anexos[i]})" data-id_documento="${anexos[i]}" data-storage="1" data-delete="0" >
                    <i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size:20px"></i>  &nbsp; 
                    <strong class="tx-inverse tx-medium"> Anexo ${ parseInt(i) + 1 } </strong>
                  </a>
                </li>
              `;
            }

            lista = lista.length > 0 ? lista : `
              <li class="list-group-item" class="sin_anexos">
                <span> 
                  <a href="javascript:void(0)">
                    <strong class="tx-inverse tx-medium"> Sin anexos </strong>
                  </a>
                </span>
              </li>
            `;


            $("#listAnexos").html(lista);

          }
        }
      });
    }

    function obtenerAnexoOficio( id_carpeta_judicial, documento  ){
      $.ajax({
        method:'POST',
        url:'/public/obtener_anexo',
        data:{id_carpeta_judicial,documento},
        success: function(response){
          if( response.status == 100 ){
            $('#previewAnexo').html(`<object data="${response.response}" id="anexo_pdf" width="100%" height="350px" class=""></object>`); 
            $('#preview').addClass('d-none');
            $('#previewAnexo').removeClass('d-none');
          }
        }
      });
    }


    async function firmado(modo, index='', acuerdo = '') {
      docs_firmar = [];
      anexos = [];
      $('#btnARevision').addClass('d-none');
      

      $('#docFirma').html('');
      $('#listAnexos').html('');
      $('#navItemsFracciones').html('');
      $('#tabPaneFracciones').html('');
      $('.no-footer').DataTable().destroy();
      
      if( $('.transition.fracciones').attr('aria-expanded') == 'true' ){
        $('.transition.fracciones').click();
      }
        

      tareaSeleccionada = arrTareas[index];

      if( tareaSeleccionada.id_solicitud != null ){
        
        const datosSolicitud = await obtenerDatosSolicitud( tareaSeleccionada.id_solicitud );

        if( tareaSeleccionada.tipo_solicitud_ == 'PRO-MUJER' || ( tareaSeleccionada.tipo_solicitud_ == 'INICIAL' && tareaSeleccionada.id_ta == 52 )){ 
          
          $('#accordionFracciones').removeClass('d-none');
          $( tareaSeleccionada.personas ).each( async function( i, persona ) {

            const { id_calidad_juridica, nombre, apellido_paterno, apellido_materno, id_persona } = persona.info_principal;

            if( tipo_victima.includes(id_calidad_juridica) ) {

              $('#navItemsFracciones').append(`
                <li class="nav-item">
                  <a class="nav-link" href="#tab${i}" data-toggle="tab" onclick="tableFracciones(${i})">${nombre == null ? '':nombre} ${apellido_paterno == null ? '' : apellido_paterno}</a>
                </li>
              `);

              $('#tabPaneFracciones').append(`
                <div class="tab-pane" id="tab${i}">
                  <div class="tx-center btn-nombre-fracciones">
                    <h5 style="margin-bottom: 10px;">${nombre == null ? '': nombre} ${apellido_paterno == null ? '' : apellido_paterno} ${apellido_materno == null ? '' : apellido_materno}</h5>
                    <button class="btn btn-primary" onclick="guardarCambiosMedidas(${id_persona},${i})" type="button" style="padding: 10px 24px;">Guardar cambios<span style="position:absolute"> <i class="fa fa-check tx-success d-none" style="position: relative; left: 2px; font-size: 1.2em;" id="check${id_persona}" aria-hidden="true"></i></button>
                  </div>
                  <table id="tableFracciones${i}" cellspacing style="display: block;overflow-x: scroll;" class="cell-border">
                    <thead>
                      <tr>
                        <th>Fracción</th>
                        <th></th>
                        <th>Seleccionada</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody id="tbody${i}">
                     
                    </tbody>
                  </table>
                </div>
              `);

              const medidasProteccion = await obtenerMedidasProteccion( id_persona );

              if( medidasProteccion.status == 100 ) {
                $('#accordionFracciones').removeClass('d-none');
                contiene_fracciones = true;
                $(medidasProteccion.response).each(function( im, medida) {
                  
                  const { fraccion, descripcion, id_cat, acu_fraccion_valor, id_acu_fraccion, id_padre, soli_fraccion_valor, id_soli_fraccion, acu_fraccion_descripcion_otros } = medida;

                  if( id_padre == 0 ) {

                    let toggle_solicitud;

                    if( tareaSeleccionada.tipo_solicitud_ == 'PRO-MUJER' )

                      if( soli_fraccion_valor == 1 )

                        toggle_solicitud = `<div class="toggle-wrapper" style="margin: auto !important; display: table !important;" disabled=""><div class="toggle-light primary valor_fraccion" id="a1" style="height: 26px;width: 50px;" disabled=""><div class="toggle-slide"><div class="toggle-inner" style="width: 74px; margin-left: 0px;"><div class="toggle-on active" style="height: 26px; width: 37px; text-indent: -8.66667px; line-height: 26px;">SI</div><div class="toggle-blob" style="height: 26px; width: 26px; margin-left: -13px;"></div><div class="toggle-off" style="height: 26px; width: 37px; margin-left: -13px; text-indent: 8.66667px; line-height: 26px;">NO</div></div></div></div></div>`;
                      else

                        toggle_solicitud = `<div class="toggle-wrapper 1" style="margin: auto !important; display: table !important;"><div class="toggle-light primary valor_fraccion" id="a27" style="height: 26px; width: 50px;"><div class="toggle-slide"><div class="toggle-inner" style="width: 74px; margin-left: -24px;"><div class="toggle-on" style="height: 26px; width: 37px; text-indent: -8.66667px; line-height: 26px;">SI</div><div class="toggle-blob" style="height: 26px; width: 26px; margin-left: -13px;"></div><div class="toggle-off active" style="height: 26px; width: 37px; margin-left: -13px; text-indent: 8.66667px; line-height: 26px;">NO</div></div></div></div></div>`;

                    else
                      toggle_solicitud = `
                        <div class="toggle-wrapper" style="margin: auto !important; display: table !important;">
                          <div class="toggle${soli_fraccion_valor == 1 ? '_on' : ''} toggle-light primary valor_fraccion fraccion_solicitud ${id_persona}" tipo-fraccion="solicitud" id-cat="${id_cat}"  id="${id_soli_fraccion}" id-persona="${id_persona}" id-fraccion-solicitud="${id_soli_fraccion}"></div>
                        </div>
                      `;

                    const desc_otros = acu_fraccion_descripcion_otros == "-" ? "" : acu_fraccion_descripcion_otros;

                    let btnAgregar = '';

                    if( medidasProteccion.response.length == (im + 1) )
                        btnAgregar = `<div class="agregarRow" style="text-align:center; padding-top: 20px;">
                            <a href="javascript:void(0)" onclick="addroww(${i})"  style="font-size: 1.8em;"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                          </div>`;

                    $('#tbody'+i).append(`
                      <tr style="background-color: #f8f9fa">
                        <td class="nFraccion pd-10"><h6>${fraccion}</h6></td>
                        <td class="dFraccion pd-10">
                          ${descripcion}
                          ${id_cat != 16 ? '': '(especifique):<div class="form-group mg-b-10-force mg-t-10"><input type="text" style="width:100%" id="descripcion_otros" class="form-control" value="'+desc_otros+'"></div>'}
                        </td>
                        <td class="sFraccion pd-10" style="text-align: -webkit-center;">
                          ${toggle_solicitud}
                        </td>
                        <td class="sFraccion pd-10" style="text-align: -webkit-center;">
                          <div class="toggle-wrapper" style="margin: auto !important; display: table !important;">
                            <div class="toggle${acu_fraccion_valor == 1 ? '_on' : ''} toggle-light primary valor_fraccion fraccion_acuerdo ${id_persona}" id-cat="${id_cat}" id-acu-fraccion="${id_acu_fraccion}" id="${id_acu_fraccion}" id-persona="${id_persona}" tipo-fraccion="acuerdo"></div>
                          </div>
                          ${btnAgregar}
                        </td>
                      </tr>
                    `);

                    $(medidasProteccion.response).each(function(ih , hipotesis) {

                      if( hipotesis.id_padre == id_cat ) {
                        $('#tbody'+i).append(`
                          <tr>
                            <td class="nHipotesis pd-10"></td>
                            <td class="dHipotesis pd-10 pd-l-20">${hipotesis.descripcion}</td>
                            <td class="sHipotesis pd-10" style="text-align: -webkit-center;">
                              <div class="toggle-wrapper 1" style="margin: auto !important; display: table !important;">
                                <div class="toggle-light primary valor_fraccion" id="a27" style="height: 26px; width: 50px;"><div class="toggle-slide"><div class="toggle-inner" style="width: 74px; margin-left: -24px;"><div class="toggle-on" style="height: 26px; width: 37px; text-indent: -8.66667px; line-height: 26px;">SI</div><div class="toggle-blob" style="height: 26px; width: 26px; margin-left: -13px;"></div><div class="toggle-off active" style="height: 26px; width: 37px; margin-left: -13px; text-indent: 8.66667px; line-height: 26px;">NO</div></div></div></div>
                              </div>
                            </td>
                            <td class="sHipotesis pd-10" style="text-align: -webkit-center;">
                              <div class="toggle-wrapper" style="margin: auto !important; display: table !important;">
                                <div class="toggle${hipotesis.acu_fraccion_valor == 1 ? '_on' : ''} toggle-light primary hipotesis fraccion_acuerdo ${id_cat} ${id_persona}" id-cat-padre="${id_cat}" id-cat="${hipotesis.id_cat}" id-acu-fraccion="${hipotesis.id_acu_fraccion}" id="${hipotesis.id_acu_fraccion}" id-persona="${id_persona}"></div>
                              </div>
                            </td>
                          </tr>`);
                      }

                    });
                  }
                  
                });

                
                $('.toggle').toggles({
                  on: false,
                  height: 26
                });

                $('.toggle_on').toggles({
                  on: true,
                  height: 26
                });

                

              }else {
                contiene_fracciones = false;
              }
              
            }
          });

        }else{

          $('#accordionFracciones').addClass('d-none');

        }
      } 
      
      if( tareaSeleccionada.clave_bandeja == "FDE" ) {
        $('input[name=tipo_firma_firel]').attr('disabled', true);
        $('input[name=tipo_firma_firel][value=firma_autografa]').removeAttr('disabled').click();
        
      }

      if( modo == 'indiv' ){

        $('#btnARevision').attr('onclick', `regresar(${index},${tareaSeleccionada.tabla_asociada=='carpetas_judiciales_documentos'?tareaSeleccionada.id_tabla_asociada:tareaSeleccionada.id_acuerdo},'${tareaSeleccionada.tabla_asociada}')`).removeClass('d-none');
        const {tabla_asociada, id_acuerdo, id_carpeta_judicial, id_tabla_asociada} = tareaSeleccionada;
        carpeta_firma = id_carpeta_judicial;

        if(tabla_asociada=='acuerdos'){

          urlDoc=`/obtener_ultima_version_acuerdo/${id_acuerdo}`;
          $('#divInputAnexos').addClass('d-none');
          $('#indexDocs').addClass('d-none');
          $('#divInputAnexos').addClass('d-none');
          $('#preview').parent().removeClass('col-md-9').addClass('col-12');
          $('#docFirma').append(`<a href="javascript:void(0)"  onclick="showDocument()"><i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size:20px"></i> Documento a firmar</a>`);

        }else if(tabla_asociada=='carpetas_judiciales_documentos'){
          const request_usmeca = obtenerUltimaVersionOficio(id_carpeta_judicial,id_tabla_asociada);
          urlDoc=`/obtener_ultima_version_oficio/${id_carpeta_judicial}/${id_tabla_asociada}`;
          $('#divInputAnexos').removeClass('d-none');
          $('#preview').parent().addClass('col-md-9').removeClass('col-12');
          $('#indexDocs').removeClass('d-none');
          $('#docFirma').append(`
            <li class="list-group-item">
              <a href="javascript:void(0)" onclick="showDocument()" >
                <i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size:20px"></i>  &nbsp; 
                <strong class="tx-inverse tx-medium"> Documento a firmar </strong>
              </a>
            </li>
          `);
        }

        docs_firmar.push(index);
        
        $('#preview').html(`<object data="${urlDoc}" id="documentoPDF" width="100%" height="350px" class=""></object>`);
        $('#modal_firel').modal('show');

      }else if(modo=='masivo'){

        if($('input[class=seleccion-tarea]:checked').length){
          let ul=''
            cardBody='';
          $('input[class=seleccion-tarea]:checked').each(function(index_tarea, tarea){
            const {tabla_asociada, id_acuerdo, id_carpeta_judicial, id_tabla_asociada} = arrTareas[$(this).val()];
            docs_firmar.push($(this).val());
            const li=`
              <li class="nav-item">
                <a class="nav-link ${index_tarea==0?'active':''}" href="#doc${index_tarea+1}" data-toggle="tab">Documento ${index_tarea+1}</a>
              </li>
            `;
            ul=ul.concat(li);

            if(tabla_asociada=='acuerdos'){
              urlDoc=`/obtener_ultima_version_acuerdo/${id_acuerdo}`;
            }else if(tabla_asociada=='carpetas_judiciales_documentos'){
              urlDoc=`/obtener_ultima_version_oficio/${id_carpeta_judicial}/${id_tabla_asociada}`
            }

            const div=`
              <div class="tab-pane ${index_tarea==0?'active':''}" id="doc${index_tarea+1}">
                <object data="${urlDoc}" id="documentoPDF" width="100%" height="350px"></object>
              </div><!-- tab-pane -->
            `;

            cardBody=cardBody.concat(div);
          })
          const cards=`
          <div class="card">
            <div class="card-header">
              <ul class="nav nav-tabs card-header-tabs">
                ${ul}
              </ul>
            </div><!-- card-header -->
            <div class="card-body" style="padding:0">
              <div class="tab-content">
                ${cardBody}
              </div><!-- tab-content -->
            </div><!-- card-body -->
          </div><!-- card -->`;
          $('#preview').html(cards);
          $('#modal_firel').modal('show');
        }else{
          alert('no ha seleccionado ninguna tarea');
        }
      }
    }

    async function firmar() {
      $(docs_firmar).length;
      
      if($('#password').val()=="" && tipo_global != 'autografa'){
          alert("La contraseña es obligaroria");
          $('#password').focus();
          return 0;
      }
      if(!$("#archivo_pfx").val() && tipo_global=="firel_tsj"){
          alert("El archivo PFX es obligatorio");
          $('#archivo_pfx').focus();
          return 0;
      }


      if(!$("#archivo_key").val() && tipo_global=="fiel_tsj"){          
          alert("El archivo KEY es obligatorio");
          $('#archivo_key').focus();
          return 0;
      }
      if(!$("#archivo_cer").val() && tipo_global=="fiel_tsj"){
          alert("El archivo CER es obligatorio");
          $('#archivo_cer').focus();
          return 0;
      }
      
      $(docs_firmar).each(async function(index, doc_firma) {

        const {tabla_asociada, id_acuerdo, id_carpeta_judicial, id_tabla_asociada} = arrTareas[doc_firma];

        let form=new FormData($("#form_firma_firel")[0]);

        let anexos_borrados = [] ;
        let anexos_nuevos= [] ;
        anexos = [] ; 
        
        
        form.append('tipo_doc',tabla_asociada);
        

        if( tabla_asociada == 'carpetas_judiciales_documentos' && 1 == 0){
          if( ( $(".anexos-adjuntados") ).length == 0){
            alert("No ha agregado ningún archivo anexo");
            $('#archivo_key').focus();
            return 0;
          }else{
            $(".anexos-adjuntados").each(function( ){
              if( $(this).attr('data-storage') == '1' ){
                if( $(this).attr('data-delete') == '0' ){
                  anexos.push({ 'id_documento' : $(this).attr('data-id_documento') });
                }else{
                  anexos_borrados.push({ 'id_documento' : $(this).attr('data-id_documento') });
                }
              }else{
                anexos_nuevos.push({
                  'b64' : $(this).attr('data').split('base64,')[1],
                  'nombre_archivo' : 'Anexo ('+$(this).attr('data-nombre')+')',//$(this).attr('data-nombre'),
                  'tamanio_archivo': $(this).attr('data-tamanio'),
                  'extension_archivo' : $(this).attr('data-extension'),
                });
              }
            });
          }
        }

        form.append('arrAnexos',JSON.stringify(anexos));
        form.append('arrAnexosBorrados',JSON.stringify(anexos_borrados));
        form.append('arrAnexosNuevos',JSON.stringify(anexos_nuevos));

        
        if(tabla_asociada=='acuerdos'){
          form.append('modal_id_acuerdo',id_acuerdo);
        }else if(tabla_asociada=='carpetas_judiciales_documentos'){
          form.append('documento',id_tabla_asociada);
          form.append('carpeta_judicial',id_carpeta_judicial);
        }
        
        
        form.append('modal_tipo_avance','firma');

        if(tipo_global == 'autografa'){
        
          if($('#bDoc').val()=='' || $('#bDoc').val()==null || $('#archivoPDF_firma').val()==''){
            alert("El archivo PDF es obligatorio");
          }else{
            tamanio_archivo=$('#archivoPDF_firma')[0].files[0].size;
            form.append('tamanio_archivo',tamanio_archivo);
          } 
        }
        await procesarFirel(form);
      });
    }

    function procesarFirel(form){
      //manejo de modales
      $('#modal_firel').modal('hide');
      $('#modal_loading').modal('show');

      jQuery.ajax({
          type: 'POST',
          url:"{{ route('firmar_documento') }}",
          data: form,
          processData: false,
          contentType: false,
          async: true,
          success: function(data) {
              
            console.log(data);

            if( data.status != 100 ) {
              error("Error en firmado", data.message, "modal_firel");
            } else {
              $('#successMessage').html( data.message );
              $('#modalSuccess').modal('show');
              buscar(1);
              countBandejas();
            }
              
            setTimeout(function(){
                $('#modal_loading').modal('hide');
            }, 400);
          }
      });
    }

    var tipo_global="firel_tsj";
    function seleccionarCredenciales(tipo){
        tipo_global=tipo;
        $('#procesFirel').removeClass('d-none');
        $('#enviar').addClass('d-none');
        if(tipo=="firel" || tipo=="firel_tsj"){
          $('#porDOC').css("display", "none");
          $('#id_pfx').css("display", "block");
          $('#id_key').css("display", "none");
          $('#id_cert').css("display", "none");
          $('#id_contrasenia').css("display", "block");
        }
        else if(tipo=="fiel" || tipo=="fiel_tsj"){
          $('#porDOC').css("display", "none");
          $('#id_pfx').css("display", "none");
          $('#id_key').css("display", "block");
          $('#id_cert').css("display", "block");
          $('#id_contrasenia').css("display", "block");
        }
        else if (tipo=="autografa"){
          $('#porDOC').css("display", "block");
          $('#id_pfx').css("display", "none");
          $('#id_key').css("display", "none");
          $('#id_cert').css("display", "none");
          $('#id_contrasenia').css("display", "none");
          accionFirmaAut();
        }
        else{
          $('#porDOC').css("display", "none");
          $('#id_pfx').css("display", "none");
          $('#id_key').css("display", "none");
          $('#id_cert').css("display", "none");
          $('#id_contrasenia').css("display", "none");
        }
    }

    function leeDocumento (input) {
      const file = $('#archivoPDF_firma').val();
      const ext = file.substring(file.lastIndexOf("."));
      if(ext!=''){
        if(ext != ".pdf"){
          alert('Solo puede adjutar archivos .pdf');
          $('#archivoPDF_firma').val('');
        }else{
            if (input.files && input.files[0]) {
              
              const reader = new FileReader();
              reader.onload = e=> {
                const dataPDF=e.target.result;
                $('#divDocumento').html(`<object data="${dataPDF}"  id="documentoPDF_firma" width="100%" height="350px" class=" mg-t-25"></object>`);
                $('#bDoc').val(dataPDF.split('base64,')[1]);
              }
              reader.readAsDataURL(input.files[0]); 
            }
        }
      }
      
    }

    $("#archivoPDF_firma").on('input',function () {
        leeDocumento(this);   
    });

    $("#archivoPDF_anexo").on('input',function () {
        leeDocumentoAnexo(this);   
    });

    let anexos=[];

    function leeDocumentoAnexo (input) {
      const file = $('#archivoPDF_anexo').val();
      const ext = file.substring(file.lastIndexOf("."));
      if(ext!=''){
        if(ext != ".pdf"){
          alert('Solo puede adjutar archivos .pdf');
          $('#archivoPDF_anexo').val('');
        }else{
            if (input.files && input.files[0]) {
              const reader = new FileReader();
              reader.onload = e=> {

                const dataPDF=e.target.result;
               
                /*anexos.push({
                  "carpeta" : carpeta_firma,
                  "id_tipo_archivo" : 6,
                  "nombre_archivo" : normalize(input.files[0].name),
                  "extension_archivo" : (input.files[0].name).slice(-3),
                  "tamanio_archivo" : input.files[0].size,
                  "estatus" : 1,
                  "dataPDF" :  dataPDF,
                  "b64" : dataPDF.split('base64,')[1],
                  "motivos" : "-",
                  "anexos" : [],
                });

                showAnexos();
                $('#archivoPDF_anexo').val('');
                showDocument((anexos.length - 1) ,'anexo');*/
                
                $("#listAnexos").append(`
                  <li class="list-group-item">
                    <i class="fa fa-close fa-2x tx-danger" onclick="quitar_anexo(this)"></i>  &nbsp; &nbsp; &nbsp;
                    <a href="#" class="anexos-adjuntados" onclick="previewAnexoDG(this)" data-nombre="${ normalize(input.files[0].name) }" data-tamanio="${input.files[0].size}" data-extension="${ (input.files[0].name).slice(-3) }" data="${e.target.result}" title="Ver vista previa"> 
                      <i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size:20px"></i>  &nbsp; 
                      <strong class="tx-inverse tx-medium"> Anexo ${ ($(".anexos-adjuntados")).length + 1 } </strong>
                    </a>
                  </li>
                `);
              }
              reader.readAsDataURL(input.files[0]); 
            }
        }
      }
    }

    // ADD BY EL DESMADRA CODIGO
    function quitar_anexo( tag ){
      console.log( tag );
      tag_btn = tag;
      tag = $( tag ).parent().find('a')[0];


      if( parseInt( $(tag).attr('data-storage') ) == 1 ){
        console.log( $(tag).attr('data-delete')   );

        if( parseInt( $(tag).attr('data-delete') ) == 0 ){
          
          $(tag).attr('data-delete', 1);
          $(tag_btn).removeClass('fa-close').addClass('fa-undo');

        }else{

          $(tag).attr('data-delete', 0);
          $(tag_btn).removeClass('fa-undo').addClass('fa-close');

        }
        
      }else{
        $( tag ).parent().remove();
      }

    }

    function previewAnexoDG( tag ){
      $('#previewAnexo').html(`<object data="${$( tag ).attr('data')}" id="anexo_pdf" width="100%" height="350px" class=""></object>`); 
      $('#preview').addClass('d-none');
      $('#previewAnexo').removeClass('d-none');
    }

    // END ADD BY EL DESMADRA CODIGO

    var normalize = (function() {
      var from = "ÃÀÁÄÂÈÉËÊÌÍÏÎÒÓÖÔÙÚÜÛãàáäâèéëêìíïîòóöôùúüûÑñÇç",
          to   = "AAAAAEEEEIIIIOOOOUUUUaaaaaeeeeiiiioooouuuunncc",
          mapping = {};

      for(var i = 0, j = from.length; i < j; i++ )
          mapping[ from.charAt( i ) ] = to.charAt( i );

        return function( str ) {
            var ret = [];
            for( var i = 0, j = str.length; i < j; i++ ) {
                var c = str.charAt( i );
                if( mapping.hasOwnProperty( str.charAt( i ) ) )
                    ret.push( mapping[ c ] );
                else
                    ret.push( c );
            }
            return ret.join( '' ).replace( /-|[^-A-Za-z0-9]+/g, '_' ).toLowerCase();;
        }

    })();

    function showAnexos(){
      $('#listAnexos').html('');

      $(anexos).each(function(index, anexo){
        $('#listAnexos').append(`<li style="list-style:none; margin-bottom:15px; display:flex"><a href="javascript:void(0)" onclick="showDocument(${index},'anexo')"><i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size:22px"></i> ${anexo.nombre_archivo}</a><a href="javascript:void(0)" onclick="deleteAnexo(${index})" class="mg-l-auto"><i class="fa fa-trash tx-danger" aria-hidden="true" style="font-size:18px;padding-top:4px"></i></a></li>`);
      });
    }

    function deleteAnexo(index){
      anexos = anexos.filter((anexo, index_anexo) => {
        if( index != index_anexo )
          return anexo;
      })

      showAnexos();
      showDocument();
    }

    function showDocument(index='', tipo=''){
      if( tipo == 'anexo' ){
        $('#preview').addClass('d-none');
        $('#previewAnexo').removeClass('d-none');
        $('#previewAnexo').html(`<object data="${anexos[index].dataPDF}" width="100%" height="350px" class=""></object>`)
      }else{
        $('#preview').removeClass('d-none');
        $('#previewAnexo').addClass('d-none');
      }
    }
    
    function obtenerGrupoTrabajo(){
      return new Promise(resolve => {
        let usuarios='';
        $.ajax({
          method:'POST',
          url:'/public/obtener_grupo_trabajo',
          async:true,
          data:{
            tipo:'desc',
            nivel:'1'
          },
          success:function(response){
            if(response.status==100){

              $(response.response).each(function(index, usuarioGT){
                const {id_usuario, nombres, apellido_paterno, apellido_materno , usuario}=usuarioGT;
                usuarios=usuarios.concat(`<option class="text-uppercase"  value="${id_usuario}">${nombres} ${apellido_paterno} ${apellido_materno} (${usuario})</option>`);
              });
            }
            resolve(usuarios);
          }
        });

      });
    }

    function accionFirmaAut(){
      if($('#accionFirmaAutografa').val()=='cargar'){
        $('#divFirmaAutDoc').removeClass('d-none');
        $('#divFirmaAutDel').addClass('d-none');
        $('#procesFirel').removeClass('d-none');
        $('#enviar').addClass('d-none');
      }else{
        $('#divFirmaAutDoc').addClass('d-none');
        $('#divFirmaAutDel').removeClass('d-none');
        $('#procesFirel').addClass('d-none');
        $('#enviar').removeClass('d-none');
      }
    }

    function confirmarResolucionAcuerdo(){
      
      form = new FormData($("#form_firma_firel")[0]);

      const usuario_a_delegar = $('#delegarFirma').find('option:selected').text();

      $('#mensajeConfirmar').html(`Se delegará la tarea a ${usuario_a_delegar} para agregar el documento firmado`);
      $('#btnResolver').attr('onclick',`avanzar(${tareaSeleccionada.id_acuerdo},'${usuario_a_delegar}','firma_del')`);
      $('#modal_firel').modal('hide');
      abreModal('modalConfirmacion2',350);
      $('#regresar').attr('onclick','abreModal(`modal_firel`,400)');
      
    }

    function avanzar(acuerdo, nombre_usuario='', accion=''){
      $('#modal_loading').modal('show');
      form.append('comentarios',$('#comentarios').val());
      form.append('acuerdo',acuerdo);
      form.append('accion',accion);

      if(accion=="delegado" || accion=="firma_del"){
        form.append('usuario_destino',$('#delegarFirma').val());
      }

      // return new Promise(resolve => {
        
        $.ajax({
          method:'POST',
          url:'/public/avanzar_acuerdo',
          data:form,
          contentType: false,
          processData: false,
          cache: false,
          success:function(response){
            if(response.status==100){
              const message=response.message;
              if(accion=='firma'){
                $('#successMessage').html(`${message} <br> Acuerdo enviado a ${nombre_usuario}`);
              }else{
                $('#successMessage').html(`${message}`);
              }
              $('#modalConfirmacion').modal('hide');
              $('#modalConfirmacion2').modal('hide');
              $('#modalSuccess').modal('show');
              buscar(1);
              countBandejas();
            }else{
              $('#messageError').html(response.message);
              $('#modalError').modal('show');
            }
            // resolve(response.status);
            setTimeout(()=>{
              $('#modal_loading').modal('hide');
            },200);
          }
        });
      // });
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
          <h4 class="tx-danger mg-b-20">Datos incompletos o erroneos</h4>
          <p class="mg-b-20 mg-x-20" id="messageError"></p>
          <button type="button" class="btn btn-danger pd-x-25" data-dismiss="modal" aria-label="Close" id="acepError">Aceptar</button>
        </div><!-- modal-body -->
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
  </div><!-- modal -->
  <div id="modalDatosTarea" class="modal fade">
    <div class="modal-dialog modal-lg mg-b-100" role="document" style="width: -webkit-fill-available;">
      <div class="modal-content tx-size-sm">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"><span id="titleSujeto">Sujetos Procesales</span></h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pd-20" id="divTarea">
					<div class="steps d-flex">
						<p class="step activo d-inline-block d-md-flex mg-r-10" id="step-datos-solicitud"><span class="num-step">1</span><span class="text-step d-none d-md-block">Validación de Datos</span></p>
						<p class="step espera  d-inline-block d-md-flex  mg-r-10" id="step-resolucion"><span class="num-step">2</span><span class="text-step d-none d-md-block">Resolver Solicitud</span></p>
					</div>
          <form onsubmit="return false;" id="cargarDocumento" action="/" enctype="multipart/form-data" class="documento">
            <div id="validacionDatos">
              <div class="form-group">
                <label class="form-control-label">Resolver por:</label>
                <select class="form-control select2-show-search" id="tipoResolucion" name="tipo_resolucion" autocomplete="off">
                  <option selected value="">Seleccione una Opción</option>
                    <option value="acuerdo">Acuerdo</option>
                    <option value="audiencia">Audiencia</option>
                </select>
              </div>
              <div class="card">
                <div class="card-header">
                  <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item">
                      <a class="nav-link active" href="#divSolicitud" data-toggle="tab">Datos Solicitud</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#divDatosSujeto" data-toggle="tab">Partes Procesales</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#divDocumentos" data-toggle="tab">Documentos</a>
                    </li>
                  </ul>
                </div><!-- card-header -->
                <div class="card-body">
                  <div class="tab-content">
                    <div class="tab-pane active" id="divSolicitud">

                    </div><!-- tab-pane -->
                    <div class="tab-pane" id="divDatosSujeto">

                    </div><!-- tab-pane -->
                    <div class="tab-pane" id="divDocumentos">

                    </div><!-- tab-pane -->
                  </div><!-- tab-content -->
                </div><!-- card-body -->
              </div><!-- card -->
            </div>

            <div id="resolucion" class="d-none">

            </div>
          </form>
        </div><!-- modal-body -->
        <div class="modal-footer d-flex">
          <button type="button" class="btn btn-secondary d-inline-block" disabled onclick="atras()" id="atras">Atrás</button>
          <div id="divButtons" class="d-inline-block" style="margin-left: auto">
          </div>
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
          <p style="padding-left: 5vh; padding-right: 5vh;" id="successMessage"></p>
        </div><!-- modal-body -->
        <div class="modal-footer d-flex">
          <button type="button" class="btn btn-primary pd-x-25 mg-l-auto" data-dismiss="modal" aria-label="Close" >Aceptar</button>
        </div>
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
  </div><!-- modal -->
  <div id="modalConfirmacion" class="modal fade">
		<div class="modal-dialog modal-dialog-vertical-center mg-b-100" role="document">
			<div class="modal-content bd-0 tx-14">
				<div class="modal-header">
					<h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Confirmación</h6>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body pd-25" id="mensajeConfirmacion">

				</div>
				<div class="modal-footer ">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
					<div id="botonConfirmar" style="margin-left: auto;">

					</div>
				</div>
			</div>
		</div><!-- modal-dialog -->
	</div><!-- modal -->
	<div id="modalConfirmacion2" class="modal fade" data-backdrop="static">
    <div class="modal-dialog modal-dialog-vertical-center" role="document" style="">
      <div class="modal-content bd-0 tx-14" style="min-width: 100%">
        <div class="modal-header">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Resolver Tarea</h6>
        </div>
        <div class="modal-body pd-25">
          <h5 id="mensajeConfirmar"></h5>
          <div class="form-group mg-b-10-force">
            <label class="form-control-label">Comentarios:</label>
            <textarea class="form-control" type="text" id="comentarios" name="comentarios" autocomplete="off" value=""></textarea>
          </div>
        </div>
        <div class="modal-footer d-flex">
          <button type="button" class="btn btn-secondary mg-r-auto" id="regresar" data-dismiss="modal" style="margin-right: auto;">Regresar</button>
          <button type="button" class="btn btn-primary mg-l-auto" id="btnResolver">Aceptar</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->
  <div id="modal_firel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" >
    <div class="modal-dialog mg-b-100" role="document">
      <div class="modal-content tx-size-sm" >
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Firma del documento</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pd-20">
          <form id="form_firma_firel" enctype="multipart/form-data" method="post">
            {{-- <input type="hidden" value="" name="modal_id_acuerdo" id="modal_id_acuerdo">
            <input type="hidden" value="" name="modal_tipo_avance" id="modal_tipo_avance">
            <input type="hidden" value="" name="modal_index" id="modal_index"> --}}

            <div class="media-body table-responsive-xl" style="">
              <h5 class="card-profile-name">Selecciona el tipo de firma</h5>
                <p class="card-profile-position">
                  <div class="row col-lg-12" id="">
                    {{-- @if (Session::get('id_tipo_usuario')==5 || Session::get('id_tipo_usuario')==2) --}}
                        
                      @if($request->entorno["variables_entorno"]["MIFIRMA_ACTIVO"]==0)
                          <div class="col-lg-4">
                              <label class="rdiobox">
                                  <input name="tipo_firma_firel" type="radio" id="tipo_firma_firel1" value="firel" @if(Session::get('id_tipo_usuario')==5 || Session::get('id_tipo_usuario')==2) checked @endif onclick="seleccionarCredenciales('firel')">
                                  <span>Firel</span>
                              </label>
                          </div><!-- col-3 -->
                          <div class="col-lg-4 mg-t-20 mg-lg-t-0">
                              <label class="rdiobox">
                                  <input name="tipo_firma_firel" type="radio" id="tipo_firma_firel2" value="fiel" onclick="seleccionarCredenciales('fiel')">
                                  <span>E.Firma</span>
                              </label>
                          </div><!-- col-3 -->
                      @else
                          <div class="col-lg-4">
                              <label class="rdiobox">
                                  <input name="tipo_firma_firel" type="radio" id="tipo_firma_firel3" value="firel_tsj" checked onclick="seleccionarCredenciales('firel_tsj')">
                                  <span> FIREL / MI FIRMA (PFX)</span>
                              </label>
                          </div><!-- col-3 -->
                          <div class="col-lg-4 mg-t-20 mg-lg-t-0">
                              <label class="rdiobox">
                                  <input name="tipo_firma_firel" type="radio" id="tipo_firma_firel4" value="fiel_tsj" onclick="seleccionarCredenciales('fiel_tsj')">
                                  <span>FIEL (SAT - Key y CER)</span>
                              </label>
                          </div><!-- col-3 -->
                      @endif

                      @if($request->entorno["variables_entorno"]["SELLO_SIGJ_ACTIVO"]==1)
                          <div class="col-lg-4 mg-t-20 mg-lg-t-0" id="sello_sigj_visible_1">
                              <label class="rdiobox">
                                  <input name="tipo_firma_firel" type="radio" id="tipo_firma_firel" value="sello_sigj" onclick="seleccionarCredenciales('sello_sigj')">
                                  <span>Sello SIGJ</span>
                              </label>
                          </div><!-- col-3 -->
                      @endif
                    {{-- @endif --}}
                      <div class="col-lg-4 mg-t-20 mg-lg-t-0" id="firma_autografa">
                        <label class="rdiobox">
                            <input name="tipo_firma_firel" type="radio" id="tipo_firma_firel" value="firma_autografa" onclick="seleccionarCredenciales('autografa')" >
                            <span>Firma Autógrafa</span>
                        </label>
                      </div><!-- col-3 -->
                  </div>
                  <hr>
                  <div class="col-lg-12" id="id_pfx">
                      <div class="form-group">
                          <label class="form-control-label" ><span class="tx-danger">*</span> Archivo PFX:</label>
                          <div id="div_upload" class="field"  >
                              <input class="btn btn-oblong btn-outline-primary" type="file" name="archivo_pfx" id="archivo_pfx" size="50" required accept=".pfx">
                          </div>
                      </div>
                  </div><!-- col-2 -->
                  <div class="col-lg-12" id="id_key" style="display: none;">
                      <div class="form-group">
                          <label class="form-control-label" ><span class="tx-danger">*</span> Archivo KEY:</label>
                          <div id="div_upload" class="field"  >
                              <input class="btn btn-oblong btn-outline-primary" type="file" name="archivo_key" id="archivo_key" size="50" required accept=".key">
                          </div>
                      </div>
                  </div><!-- col-2 -->
                  <div class="col-lg-12" id="id_cert" style="display: none;">
                      <div class="form-group">
                          <label class="form-control-label" ><span class="tx-danger">*</span> Archivo CER:</label>
                          <div id="div_upload" class="field"  >
                              <input class="btn btn-oblong btn-outline-primary" type="file" name="archivo_cer" id="archivo_cer" size="50" required accept=".cer">
                          </div>
                      </div>
                  </div><!-- col-2 -->
                  <div class="mg-t-40 mg-b-40 col-lg-12" id="porDOC" style="display: none;">
                    <div class="form-group">
                      <label class="form-control-label">Tipo de Audiencia: <span class="tx-danger">*</span></label>
                      <select class="form-control select2-show-search valid" id="accionFirmaAutografa" name="tipo_audiencia" autocomplete="off" onchange="accionFirmaAut()">
                          <option selected value="cargar">CARGAR DOCUMENTO Y FIRMAR</option>
                          @if(Session::get('id_tipo_usuario')==5 || Session::get('id_tipo_usuario')==2)
                            <option value="delegar">AUTORIZAR Y DELEGAR</option>
                          @endif
                      </select>
                    </div>
                    <div id="divFirmaAutDoc">
                      <div class="custom-input-file">
                        <input type="file" id="archivoPDF_firma" class="input-file" value="" name="archivoPDF_firma" accept="application/pdf">
                        <h5 class="px-3 py-3">Arrastre hasta aquí su documento pdf o de clic para adjuntarlo</h5>
                      </div>
      
                      <div id="divDocumento">
                        
                      </div>
                    </div>
                    <div id="divFirmaAutDel" class=" @if(Session::get('id_tipo_usuario')!=5) d-none @endif ">
                      <div class="mg-t-40" id="divDelegarFirma">
                        <h5 class="mg-t-15">Seleccione el usuario a quien se le delegará la tarea</h5>
                        <div class="form-group">
                          <label class="form-control-label">Usuario:</label>
                          <select class="form-control select2-show-search" id="delegarFirma" name="delegar_firma" autocomplete="off">
                            <option selected value="" disabled>Elija un usuario</option>
                            @foreach ($juds_at as $jud_at)
                              <option value="{{$jud_at['id_usuario']}}">{{$jud_at['nombres']}} ({{$jud_at['usuario']}})</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                    </div>
                    <input type="hidden" id="bDoc" name="bDoc">
                  </div>
                  <div class="row">
                    <div class="col-lg-12" id="id_contrasenia">
                      <div class="form-group">
                          <label class="form-control-label">Contraseña: <span class="tx-danger">*</span></label>
                          <input class="form-control" type="password" name="password" id="password" value="" placeholder="" required>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12">
                      <div class="" style="left: 15px;">
                        <div class="d-flex">
                          <button type="button" id="btnARevision" class="btn btn-warning d-none" style="display: inline-block; margin-right: auto;">Regresar a revisión</button>
                          <button type="button" id="procesFirel" class="btn btn-primary" style="display: inline-block" onclick="firmar();">Firmar</button>
                          <button type="button" id="enviar" class="btn btn-primary d-none" style="display: inline-block" onclick="confirmarResolucionAcuerdo();">Aceptar</button>
                        </div>
                      </div>
                      <div class="card fracciones d-none" id="accordionFracciones">
                        <div class="card-header fracciones" role="tab" id="headingTwo">
                          <a class="collapsed tx-gray-800 transition fracciones" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" style="padding:10px; color:#000">
                            Medidas de protección <i class="fa fa-angle-down" aria-hidden="true"></i>
                          </a>
                        </div>
                        <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
                          <div class="card-body fracciones">
                            <div class="row">
                              <div class="col-md">
                                <div class="card">
                                  <div class="card-header">
                                    <ul class="nav nav-tabs card-header-tabs" id="navItemsFracciones">
                                      
                                    </ul>
                                  </div><!-- card-header -->
                                  <div class="card-body">
                                    <div class="tab-content" id="tabPaneFracciones">
                                      
                                    </div><!-- tab-content -->
                                  </div><!-- card-body -->
                                </div><!-- card -->
                              </div><!-- col -->
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  
                
                  <div class="row">
                    <div id="" class="col-12">
                      <input type="hidden" id="request_usmeca" name="request_usmeca">
                      <div class="row mg-b-15">
                        <div class="custom-input-file" id="divInputAnexos">
                          <input type="file" id="archivoPDF_anexo" class="input-file" value="" name="archivoPDF_anexo" accept="application/pdf">
                          <h5 class="px-3 py-3">Arrastre hasta aquí su anexo en pdf o de clic para adjuntarlo</h5>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-3 pd-t-5" id="indexDocs" style="border: 1px solid #eee;">
                          <div id="docFirma">
                          </div>
                          <div id="divAnexos">
                            <label for="listaAnexos" class="mg-t-15" style="font-size: 17px">Anexos:</label>
                            <ul id="listAnexos" style="padding-left: 5px;">
  
                            </ul>
                            <br>
                          </div>
                        </div>
                        <div class="col-md-9">
                          <div id="preview"></div>
                          <div id="previewAnexo" class="d-none"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                <br>
            </div>
          </form>
        </div><!-- modal-body -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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
