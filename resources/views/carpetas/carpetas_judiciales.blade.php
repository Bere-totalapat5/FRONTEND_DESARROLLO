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
  <h6 class="slim-pagetitle">Permisos del Menú</h6>
@endsection
@section('contenido-principal')
  <div class="section-wrapper mg-b-100">
    @if(!utilidades::buscarPermisoMenu($request->menu_general['response'], 4, 0))
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
                    <div class="col-lg-3">
                      <div class="form-group mg-b-10-force">
                        <label class="form-control-label">Carpeta:</label>
                        <input class="form-control" type="text" name="carpeta_inv" id="carpetaInvestigacion"  autocomplete="off">
                      </div>
                    </div><!-- col-3 -->
                    <div class="col-lg-3">
                      <div class="form-group mg-b-10-force">
                        <label class="form-control-label">Folio:</label>
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
                    <div class="col-lg-4">
                      <div class="form-group mg-b-10-force">
                        <label class="form-control-label">Nombre(s):</label>
                        <input class="form-control" type="text" name="nombres" id="nombres"  autocomplete="off">
                      </div>
                    </div><!-- col-3 -->
                    <div class="col-lg-4">
                      <div class="form-group mg-b-10-force">
                        <label class="form-control-label">Apellido Paterno:</label>
                        <input class="form-control" type="text" name="apellidoPaterno" id="apellido_paterno"  autocomplete="off">
                      </div>
                    </div><!-- col-3 -->
                    <div class="col-lg-4">
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
					<table id="tableCarpetas" class="display dataTable dtr-inline collapsed" style="overflow-x: auto; padding-left:0; padding-rigth:0">
						<thead style="background-color: #EBEEF1; color: #000;">
              <th class="acciones">Acciones</th>
							<th class="carpeta">Tipo de Carpeta</th>
              <th class="folio">Folio</th>
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
  <link rel="stylesheet" href="/box/scheduler/codebase/dhtmlxscheduler_material.css?v=5.3.8" type="text/css" charset="utf-8">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="/box/scheduler/samples/common/controls_styles.css?v=5.3.8">
  <link rel="stylesheet" type="text/css" href="{{asset("/css/dropzone.min.css")}}">
  <link href="{{asset("/lib/datatables/css/jquery.dataTables.css")}}" rel="stylesheet">
  <style>
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
      min-width: 60px !important;
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
    @media only screen and (max-width: 1700px) {
      #tableCarpetas{
        display: block;
      }
    } 
    @media (min-width: 992px){
      .modal-lg.xl {
          max-width: 1017px;
      }
    }
    
  </style>
@endsection
@section('seccion-scripts-libs') 
  <script src="/box/scheduler/codebase/dhtmlxscheduler.js?v=5.3.8" charset="utf-8"></script>
  <script src="/box/scheduler/codebase/ext/dhtmlxscheduler_limit.js?v=5.3.8" charset="utf-8"></script>
  <script src="/box/scheduler/codebase/ext/dhtmlxscheduler_agenda_view.js?v=5.3.8" charset="utf-8"></script>
  <script src='/box/scheduler/codebase/ext/dhtmlxscheduler_timeline.js?v=5.3.8' type="text/javascript" charset="utf-8"></script>
  <script src='/box/scheduler/codebase/ext/dhtmlxscheduler_treetimeline.js?v=5.3.8' type="text/javascript" charset="utf-8"></script>
  <script src="/box/scheduler/codebase/ext/dhtmlxscheduler_minical.js?v=5.3.8" type="text/javascript" charset="utf-8"></script>
  <script src="/box/scheduler/codebase/ext/dhtmlxscheduler_units.js?v=5.3.8" type="text/javascript" charset="utf-8"></script>
  <script src="/box/scheduler/codebase/ext/dhtmlxscheduler_week_agenda.js?v=5.3.8" type="text/javascript" charset="utf-8"></script>   
  {{-- scripts remisiones --}}
  <script src="{{asset('/js/remisiones/remision.js')}}"></script>
  <script src="{{asset('/js/remisiones/remision_unidad_ejecucion.js')}}"></script>
@endsection
@section('seccion-scripts-functions')
  <script>
    const expRegFecha=/^([0-2][0-9]|3[0-1])(-)(0[1-9]|1[0-2])\2(\d{4})$/,
          expRegHora=/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/;
          guardias=[];
    let arrPersonas;
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

		function buscar(pagina){
     
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
          nombre:$('#nombre').val(),
          apellido_paterno:$('#apellidoPaterno').val(),
          apellido_materno:$('#apellidoPaterno').val(),
          pagina,
				},
				success:function(response){
					$('#bodyCarpetas').html('');
					if(response.status==100){
            // guardias=response.response;
						$(response.response).each(function(index, carpeta_judicial){
							const {nombre_tipo_carpeta,folio_carpeta,fecha_creacion,situacion_carpeta,tipo_solicitud_, imputados, victimas, delitos, id_carpeta_judicial, carpeta_investigacion}=carpeta_judicial;
              let lIimputados='',
                  lVictimas='',
                  lDelitos='';

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
                          <td class="acciones"><i class="icon ion-person-stalker" data-toggle="tooltip-primary" data-placement="top" title="Sujetos Procesales" onclick="verPersonas(${id_carpeta_judicial})"></i></td>
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

    function verPersonas(carpeta){
      $('#modalDatosSujetos').modal('show');
      $('#divDatosSujeto').html('');
      $.ajax({
        method:'POST',
        url:'/public/obtener_personas_carpeta',
        data:{
          carpeta,
        },
        success:function(response){
          arrPersonas=response.response.personas;
          if(response.response.personas.length){
            $(response.response.personas).each(function(index, persona){
              const {alias, contacto, delitos, datos, direcciones, info_principal}= persona;

              let listaDelitos='',
                  listaAlias='',
                  listaCorreos='',
                  listaTelefonos='',
                  listaDirecciones='';

              $(alias).each(function(index, aliasSujeto){
                  li=`${aliasSujeto.alias}<br>`;
                  listaAlias=listaAlias.concat(li);
              });

              $(contacto).each(function(index,contactoSujeto){
                const {id_contacto_persona,tipo_contacto, contacto, estatus, extension}=contactoSujeto;
                if(estatus==1){
                  if(tipo_contacto=='correo electronico'){
                    li=`${contacto}<br>`;
                    listaCorreos=listaCorreos.concat(li);
                  }else{
                    li=`${tipo_contacto}: ${tipo_contacto} ${extension==null?'':'ext '+extension}<br>`;
                    listaTelefonos=listaTelefonos.concat(li);
                  }
                }
              });
              
              

              $(direcciones).each(function(index, direccionSujeto){
                const {estado ,estado_text, municipio_text, colonia, localidad, calle,numero_exterior, numero_interior, otra_referencia, entre_calle}=direccionSujeto;
                const tableDireccion=`<br>
                                      <table class="datatable tableDatosSujeto" style="overflow-x: none; display: table">
                                        <thead>
                                          <tr>
                                            <th class="tx-center" colspan="4" style="background:#f8f9fa">Domicilio ${index+1}</th>
                                            <th class="d-none"></th>
                                            <th class="d-none"></th>
                                            <th class="d-none"></th>
                                          </tr>
                                        </thead>
                                        <tbody class="table-datos-sujeto">
                                          <tr>
                                            <td>Calle</td>
                                            <td>${calle==null?'':calle}</td>
                                            <td>Número Exterior</td>
                                            <td>${numero_exterior==null?'':numero_exterior}</td>
                                          </tr>
                                          <tr>
                                            <td>Número Interior</td>
                                            <td>${numero_interior==null?'':numero_interior}</td>
                                            <td>Localidad</td>
                                            <td>${localidad==null?'':localidad}</td>
                                          </tr>
                                          <tr>
                                            <td>Colonia</td>
                                            <td>${colonia==null?'':colonia}</td>
                                            <td>Municipio</td>
                                            <td>${municipio_text==null?'':municipio_text}</td>
                                          </tr>
                                          <tr>
                                            <td>Estado</td>
                                            <td>${estado_text==null?'':estado_text}</td>
                                            <td>Entre Calle y Calle</td>
                                            <td>${entre_calle==null?'':entre_calle}</td>
                                          </tr>
                                          <tr>
                                            <td>Otras Referencias</td>
                                            <td>${otra_referencia==null?'':otra_referencia}</td>
                                          </tr>
                                        </tbody>
                                      </table>  `;

                listaDirecciones=listaDirecciones.concat(tableDireccion);
              });

              const {calidad_juridica,razon_social,nombre,apellido_paterno,apellido_materno,rfc_empresa,curp,cedula_profesional,genero,fecha_nacimiento,nacionalidad,estado_civil} = info_principal;
              
              fechaNacimiento='';
              if(fecha_nacimiento!=null){
                const f=fecha_nacimiento.split('-');
                fechaNacimiento=`${f[2]}-${f[1]}-${f[0]}`;
              }

              const {otra_ocupacion,nivel_escolaridad,otra_escolaridad,nombre_religion,otra_religion,grupo_etnico,otro_grupo_etnico,lengua,capacidad_diferente,descripcion_discapacidad,sabe_leer_escribir,poblacion_callejera,poblacion,otra_poblacion,nombre_poblacion,entiende_idioma_espanol,requiere_interprete,tipo_interprete,requiere_traductor,idioma_traductor,otro_idioma_traductor}=datos[0];
              ocupacion='';

              const table= `<table class="datatable tableDatosSujeto" style="overflow-x: none; display: table">
                              <tbody class="table-datos-sujeto">
                                <tr>
                                  <td>Calidad Jurídica</td>
                                  <td>${calidad_juridica}</td>
                                  <td>Ocupación</td>
                                  <td>${ocupacion==null?'':ocupacion}</td>
                                </tr>
                                <tr>
                                  <td>Nombre ó Razón Social</td>
                                  <td>${razon_social==null?'':razon_social}${nombre==null?'':nombre} ${apellido_paterno==null?'':apellido_paterno} ${apellido_materno==null?'':apellido_materno}</td>
                                  <td>Otra Ocupación</td>
                                  <td>${otra_ocupacion==null?'':otra_ocupacion}</td>
                                </tr>
                                <tr>
                                  <td>RFC</td>
                                  <td>${rfc_empresa==null?'':rfc_empresa}</td>
                                  <td>Escolaridad</td>
                                  <td>${nivel_escolaridad==null?'':nivel_escolaridad}</td>
                                </tr>
                                <tr>
                                  <td>CURP</td>
                                  <td>${curp==null?'':curp}</td>
                                  <td>Otra Escolaridad</td>
                                  <td>${otra_escolaridad==null?'':otra_escolaridad}</td>
                                </tr>
                                <tr>
                                  <td>Cédula Profesional</td>
                                  <td>${cedula_profesional==null?'':cedula_profesional}</td>
                                  <td>Religión</td>
                                  <td>${nombre_religion==null?'':nombre_religion}</td>
                                </tr>
                                <tr>
                                  <td>Género</td>
                                  <td class="text-capitalize">${genero==null?'':genero}</td>
                                  <td>Otra Religión</td>
                                  <td>${otra_religion==null?'':otra_religion}</td>
                                </tr>
                                <tr>
                                  <td>Fecha de Nacimiento</td>
                                  <td>${fechaNacimiento}</td>
                                  <td>Grupo Étnico</td>
                                  <td>${grupo_etnico==null?'':grupo_etnico}</td>
                                </tr>
                                <tr>
                                  <td>Nacionalidad</td>
                                  <td>${nacionalidad==null?'':nacionalidad}</td>
                                  <td>Otro Grupo Étnico</td>
                                  <td>${otro_grupo_etnico==null?'':otro_grupo_etnico}</td>
                                </tr>
                                <tr>
                                  <td>Estado Civíl</td>
                                  <td>${estado_civil==null?'':estado_civil}</td>
                                  <td>Lengua</td>
                                  <td>${lengua==null?'':lengua}</td>
                                </tr>
                                <tr>
                                  <td>Capacidad Diferente</td>
                                  <td>${capacidad_diferente==null?'':capacidad_diferente}</td>
                                  <td>Discapacidad</td>
                                  <td>${descripcion_discapacidad==null?'':descripcion_discapacidad}</td>
                                </tr>
                                <tr>
                                  <td>Sabe Leer y Escribir</td>
                                  <td class="text-capitalize">${sabe_leer_escribir==null?'':sabe_leer_escribir}</td>
                                  <td>Población Callejera</td>
                                  <td class="tx-capitalize">${poblacion_callejera==null?'':poblacion_callejera}</td>
                                </tr>
                                <tr>
                                  <td>Población</td>
                                  <td>${poblacion==null?'':poblacion}</td>
                                  <td>Otra Población</td>
                                  <td>${otra_poblacion==null?'':otra_poblacion}</td>
                                </tr>
                                <tr>
                                  <td>Nombre Población</td>
                                  <td>${nombre_poblacion==null?'':nombre_poblacion}</td>
                                  <td>Entiende el Idioma Español</td>
                                  <td class="text-capitalize">${entiende_idioma_espanol==null?'':entiende_idioma_espanol}</td>
                                </tr>
                                <tr>
                                  <td>Requiere Intérprete</td>
                                  <td class="text-capitalize">${requiere_interprete==null?'':requiere_interprete}</td>
                                  <td>Tipo de Intérprete</td>
                                  <td>${tipo_interprete==null?'':tipo_interprete}</td>
                                </tr>
                                <tr>
                                  <td>Requiere Traductor</td>
                                  <td class="text-capitalize">${requiere_traductor==null?'':requiere_traductor}</td>
                                  <td>Idioma del Traductor</td>
                                  <td>${idioma_traductor==null?'':idioma_traductor}</td>
                                </tr>
                                <tr>
                                  <td>Otro Idioma del Traductor</td>
                                  <td>${otro_idioma_traductor==null?'':otro_idioma_traductor}</td>
                                </tr>
                              </tbody>
                            </table>
                            <br>
                            <table  class="datatable tableDatosSujeto2" style="overflow-x: none; display: table">
                              <thead>
                                <tr>
                                  <th class="tx-center">Teléfonos</th>
                                  <th class="tx-center">Correos</th>
                                  <th class="tx-center">Alias</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td>${listaTelefonos==''?'<span class="tx-italic">Sin teléfonos registrados</span>':listaTelefonos}</td>
                                  <td>${listaCorreos==''?'<span class="tx-italic">Sin correos registrados</span>':listaCorreos}</td>
                                  <td>${listaAlias==''?'<span class="tx-italic">Sin alias registrados</span>':listaAlias}</td>
                                </tr>
                              </tbody>
                            </table>
                            ${listaDirecciones} 
                            <br>
                            <div class="d-flex">
                              <button class="btn btn-primary d-inline-block mg-l-auto" id="editarSujeto" onclick="editarSujeto(${index})">Editar</button>
                            </div`;

              $('#divDatosSujeto').append(`<div id="accordion${index}" class="accordion-one mg-b-10" role="tablist" aria-multiselectable="true">
                                            <div class="card">
                                              <div class="card-header" role="tab" id="headingOne">
                                                <a data-toggle="collapse" data-parent="#accordion${index}" href="#collapseOne${index}" aria-expanded="true" aria-controls="collapseOne${index}" class="tx-gray-800 transition collapsed">
                                                  ${razon_social==null?'':razon_social}${nombre==null?'':nombre} ${apellido_paterno==null?'':apellido_paterno} ${apellido_materno==null?'':apellido_materno}
                                                </a>
                                              </div><!-- card-header -->

                                              <div id="collapseOne${index}" class="collapse" role="tabpanel" aria-labelledby="headingOne${index}">
                                                <div class="card-body">
                                                  ${table}
                                                </div>
                                              </div>
                                            </div>
                                          </div>`);  

            });
          }

          $('#modalDatosSujeto').modal('show');
        }
      });
    }

    function editarSujeto(sujetoE){
      console.log(arrPersonas[sujetoE]);
      $('#modalDatosSujetos').modal('hide');
      setTimeout(function(){
        $('#modalEdicion').modal('show');
      },500);
      
      const {alias, contacto, delitos, datos, direcciones, info_principal}=arrPersonas[sujetoE];
      
      const {id_persona,tipo_parte,id_calidad_juridica,tipo_persona,id_nacionalidad,es_mexicano, otra_nacionalidad,curp,rfc_empresa,cedula_profesional,nombre,apellido_materno,apellido_paterno, genero,id_estado_civil,fecha_nacimiento,edad,razon_social}=info_principal;
      
      $('#persona').val(id_persona);

      // if($('#tipoParte').hasClass('select2-hidden-accessible')){
      //   $('#tipoParte').select2('destroy');
        $('#tipoParte').val(id_calidad_juridica); 
      // }
      // setTimeout(()=>{
        $('#tipoParte').select2({minimumResultsForSearch: ''});    
      // },200); 
      
      $('#tipoPersona').val(tipo_persona).select2({minimumResultsForSearch: Infinity});
      if(tipo_persona=='moral'){
        $('.moral').removeClass('d-none');
        $('.fisica').addClass('d-none')
        $('.fisica').find('.form-control').val('');
      }else{
        $('.fisica').removeClass('d-none');
        $('.moral').addClass('d-none')
        $('.moral').find('.form-control').val('');
      }
      
      let nacionalidad='';

      if(es_mexicano=='si'){
        if(id_nacionalidad==null){
          nacionalidad='mexicana';
        }else{
          nacionalidad='mexicana_otro';
        }
      }else{
        nacionalidad='extranjero'; 
      }

      $('#nacionalidad').val(nacionalidad).select2({minimumResultsForSearch: Infinity});
      if(nacionalidad=='mexicana' || nacionalidad==null || nacionalidad==''){
        $('#otraNacionalidad').attr('disabled', true).val('');
      }else{
        $('#divOtraNacionalidad').removeClass('d-none');
        $('#otraNacionalidad').removeAttr('disabled')
        if($('#otraNacionalidad').hasClass('select2-hidden-accessible')){
          $('#otraNacionalidad').select2('destroy');
          $('#otraNacionalidad').val(otra_nacionalidad)
        }
        setTimeout(()=>{
          $('#otraNacionalidad').select2({minimumResultsForSearch: ''});
        },150);
      }

      
      $('#curp').val(curp);
      $('#rfc').val(rfc_empresa);
      $('#cedulaProfesional').val(cedula_profesional);
      $('#nombre').val(nombre);
      $('#apellidoPaterno').val(apellido_paterno);
      $('#apellidoMaterno').val(apellido_materno);
      $('#genero').val(genero).select2({minimumResultsForSearch: Infinity});
      $('#estadoCivil').val(id_estado_civil).select2({minimumResultsForSearch: Infinity});

      let fechaNacimiento='';
      if(fecha_nacimiento!=null){
        const f=fecha_nacimiento.split('-');
        fechaNacimiento=`${f[2]}-${f[1]}-${f[0]}`;
      }
      
      $('#fechaNacimiento').val(fechaNacimiento);
      $('#edad').val(edad);
      $('#razonSocial').val(razon_social);

      const {id_nivel_escolaridad,id_lengua,id_religion,id_lgbttti,id_grupo_etnico,tipo_ocupacion,otra_escolaridad,otra_ocupacion,otra_religion,otro_grupo_etnico,otro_idioma_traductor,requiere_traductor,idioma_traductor,requiere_interprete,tipo_interprete,capacidades_diferentes,capacidad_diferente,poblacion,otra_poblacion,pertenece_grupo_etnico,entiende_idioma_espanol,descripcion_discapacidad,sabe_leer_escribir,poblacion_callejera,id_escolaridad,nivel_escolaridad,lengua,nombre_religion,nombre_poblacion,grupo_etnico,id_datos_persona}=datos[0]; 
      
      $('#escolaridad').val(id_nivel_escolaridad).select2({minimumResultsForSearch: Infinity});
      $('#sabe_leer_escribir').val(sabe_leer_escribir).select2({minimumResultsForSearch: Infinity});
      $('#entiende_idioma_espanol').val(entiende_idioma_espanol).select2({minimumResultsForSearch: Infinity});
      $('#poblacion_callejera').val(poblacion_callejera).select2({minimumResultsForSearch: Infinity});
      $('#requiere_interprete').val(requiere_interprete).select2({minimumResultsForSearch: Infinity});
      $('#requiere_traductor').val(requiere_traductor).select2({minimumResultsForSearch: Infinity});
      $('#ocupacion').val(tipo_ocupacion).select2({minimumResultsForSearch: ''});
      $('#religion').val(id_religion).select2({minimumResultsForSearch: ''});
      $('#grupo_etnico').val(id_grupo_etnico).select2({minimumResultsForSearch: ''});
      $('#lengua').val(id_lengua).select2({minimumResultsForSearch: ''});
      $('#poblacion').val(id_lgbttti).select2({minimumResultsForSearch: ''});
      $('#idioma_traductor').val(idioma_traductor).select2({minimumResultsForSearch: ''});

      if(otra_religion!=null && otra_religion!=''){
        $('#otra_religion').val(otra_religion).removeAttr('disabled');
      }
      if(otro_grupo_etnico!=null && otro_grupo_etnico!=''){
        $('#otro_grupo_etnico').val(otro_grupo_etnico).removeAttr('disabled');
      }
      if(otra_ocupacion!=null && otra_ocupacion!=''){
        $('#otra_ocupacion').val(otra_ocupacion).removeAttr('disabled');
      }
      if(otro_idioma_traductor!=null && otro_idioma_traductor!=''){
        $('#otro_idioma_traductor').val(otro_idioma_traductor).attr('disabled',true);
      }
      if(tipo_interprete!=null && tipo_interprete!=''){
        $('#tipo_interprete').val(tipo_interprete).removeAttr('disabled');
      }
      if(otra_poblacion!=null && otra_poblacion!=''){
        $('#otra_poblacion').val(otra_poblacion).removeAttr('disabled');
      }
      
      if(alias.length){
        sAlias='';
        $(alias).each(function(index, ali){
          sAlias=sAlias.concat(`<div class="row datos-alias ${ali.estatus==0?'d-none':''}" data-id="${ali.id}" data-status="${ali.estatus}">
                                <div class="col-12">
                                  <p class="tx-right tx-danger"><i class="fa fa-close borrar-alias" data-index="${index}" data-indexp="${sujetoE}"></i></p>
                                </div>
                                <div class="col-lg-6">
                                  <div class="form-group mg-b-10-force">
                                    <label class="form-control-label">Alias:</label>
                                    <input class="form-control alias" type="text" name="alias" autocomplete="off" value="${ali.alias}">
                                  </div>
                                </div><!-- col-3-->
                              </div>`);
        });
        $('#datosAlias').html(sAlias);
      }

      sCorreos='';
      sTelefonos='';
      $(contacto).each(function(index,contactoSujeto){
        const {id_contacto_persona,tipo_contacto, contacto, estatus, extension}=contactoSujeto;
        if(estatus==1){
          if(tipo_contacto=='correo electronico'){
            sCorreos=sCorreos.concat(`<div class="row datos-correo ${estatus==0?'d-none':''}"  data-id="${correo.id}" data-status="${estatus}">
                                      <div class="col-12">
                                        <p class="tx-right tx-danger"><i class="fa fa-close borrar-correo" data-index="${index}" data-indexp="${sujetoE}"></i></p>
                                      </div>
                                      <div class="col-8">
                                        <div class="form-group mg-b-10-force">
                                          <label class="form-control-label">Correo Electrónico:</label>
                                          <input class="form-control correo-electronico" type="text" name="correo_electronico" autocomplete="off" value="${contacto}">
                                        </div>
                                      </div><!-- col-3-->
                                    </div>`);
          }else{
            sTelefonos=sTelefonos.concat(`<div class="row datos-telefono ${estatus==0?'d-none':''}"  data-id="${id_contacto_persona}" data-status="${estatus}">
                                          <div class="col-12">
                                            <p class="tx-right tx-danger"><i class="fa fa-close borrar-telefono" data-index="${index}" data-indexp="${sujetoE}"></i></p>
                                          </div>
                                          <div class="col-lg-3">
                                            <div class="form-group">
                                              <label class="form-control-label">Tipo: </label>
                                              <select class="form-control tipo-telefono"  name="tipo_telefono" autocomplete="off">
                                                  <option value="fijo" ${tipo=='fijo'?'selected':''}>Fijo</option>
                                                  <option value="celular" ${tipo=='celular'?'selected':''}>Celular</option>
                                              </select>
                                            </div>
                                          </div><!-- col-3-->
                                          <div class="col-lg-4">
                                            <div class="form-group mg-b-10-force">
                                              <label class="form-control-label">Número:</label>
                                              <input class="form-control numero-telefono" type="text" name="numero_telefono" autocomplete="off" value="${contacto}">
                                            </div>
                                          </div><!-- col-3-->
                                          <div class="col-lg-2">
                                            <div class="form-group mg-b-10-force">
                                              <label class="form-control-label">Extension:</label>
                                              <input class="form-control extension" type="text" name="estension" autocomplete="off" value="${extension}">
                                            </div>
                                          </div><!-- col-3-->
                                        </div>`);
          }
        }
      });
      $('#correos').html(sCorreos);
      $('.tipo-telefono').select2({minimumResultsForSearch: Infinity});
      $('#telefonos').html(sTelefonos);

      if(direcciones.length){
        sDirecciones='';
        $(direcciones).each(function(index, direccionSujeto){
          console.log(direccionSujeto);
          const {estado ,estado_text, municipio_text, colonia, localidad, calle,numero_exterior, numero_interior, otra_referencia, entre_calle}=direccionSujeto;
          
          
          let estados='<option>Elija una opción</option>';
          
          $(catalogoEstados).each(function(index, datosEstado){
           
            if(estado==datosEstado.id_estado){
              
              const option=`<option value="${datosEstado.id_estado}" data-cve-estado="${datosEstado.cve_estado}" selected>${datosEstado.estado}</option>`;
              estados=estados.concat(option);
            }else{
              
              const option=`<option value="${datosEstado.id_estado}" data-cve-estado="${datosEstado.cve_estado}">${datosEstado.estado}</option>`;
              estados=estados.concat(option);
            }
            
          });
          
          let municipios='<option>Elija una opción</option>';

          if(estado!=null && estado!='' && municipio!=null && municipio!=''){
            
            $.ajax({
              type:'POST',
              url:'/public/obtener_municipios',
              data:{
                estado:cve_estado,
              },
              success:function(response){

                if(response.status==100){
                  
                  $(response.response).each(function(index, datosMunicipio){

                    if(datosMunicipio.id_municipio==municipio){
                      let option=`<option value="${datosMunicipio.id_municipio}" selected>${datosMunicipio.municipio}</option>`;
                      municipios=municipios.concat(option);
                    }else{
                      let option=`<option value="${datosMunicipio.id_municipio}">${datosMunicipio.municipio}</option>`;
                      municipios=municipios.concat(option);
                    }
                  });          
                }
              }
            });
          }

          setTimeout(function(){
            sDirecciones=sDirecciones.concat(`
                              <div class="row datos-domicilio ${estatus==0?'d-none':''}"  data-id="${id}" data-status="${estatus}">
                                <div class="col-12">
                                  <p class="tx-right tx-danger"><i class="fa fa-close borrar-domicilio" data-index="${index}" data-indexp="${indexp}"></i></p>
                                </div>
                                <div class="col-lg-4">
                                  <div class="form-group">
                                    <label class="form-control-label">Estado: </label>
                                    <select class="form-control estado" name="estado" autocomplete="off">
                                        ${estados}
                                    </select>
                                  </div>
                                </div>
                                <div class="col-lg-4">
                                  <div class="form-group">
                                    <label class="form-control-label">Municipio: </label>
                                    <select class="form-control municipio" name="municipio" autocomplete="off">
                                        ${municipios}
                                    </select>
                                  </div>
                                </div>
                                <div class="col-lg-4">
                                  <div class="form-group mg-b-10-force">
                                    <label class="form-control-label">Localidad:</label>
                                    <input class="form-control localidad" type="text" name="localidad"  autocomplete="off" value="${localidad==null?'':localidad}">
                                  </div>
                                </div>
                                <div class="col-lg-6">
                                  <div class="form-group mg-b-10-force">
                                    <label class="form-control-label">Calle:</label>
                                    <input class="form-control calle" type="text" name="calle" autocomplete="off"  value="${calle==null?'':calle}">
                                  </div>
                                </div><!-- col-4 -->
                                <div class="col-lg-3">
                                  <div class="form-group mg-b-10-force">
                                    <label class="form-control-label">Número Exterior:</label>
                                    <input class="form-control numeroExterior" type="text" name="numero_exterior" autocomplete="off" value="${numero_exterior==null?'':numero_exterior}">
                                  </div>
                                </div><!-- col-4 -->
                                <div class="col-lg-3">
                                  <div class="form-group mg-b-10-force">
                                    <label class="form-control-label">Número Interior:</label>
                                    <input class="form-control numero_interior" type="text" name="numero_interior"  autocomplete="off"  value="${numero_interior==null?'':numero_interior}">
                                  </div>
                                </div><!-- col-4-->
                                <div class="col-lg-9">
                                  <div class="form-group mg-b-10-force">
                                    <label class="form-control-label">Colonia:</label>
                                    <input class="form-control colonia" type="text" name="colonia"  autocomplete="off"  value="${colonia==null?'':colonia}">
                                  </div>
                                </div><!-- col-4 -->
                                <div class="col-lg-3">
                                  <div class="form-group mg-b-10-force">
                                    <label class="form-control-label">Código Postal:</label>
                                    <input class="form-control codigoPostal" type="text" name="codigo_postal" autocomplete="off" value="${codigo_postal==null?'':codigo_postal}">
                                  </div>
                                </div><!-- col-4 -->
                                <div class="col-lg-8">
                                  <div class="form-group mg-b-10-force">
                                    <label class="form-control-label">Entre la Calle:</label>
                                    <input class="form-control entreCalle" type="text" name="entre_calle" autocomplete="off"  value="${entre_calle==null?'':entre_calle}">
                                  </div>
                                </div><!-- col-4-->
                                <div class="col-lg-12">
                                  <div class="form-group mg-b-10-force">
                                    <label class="form-control-label">Otras Referencias:</label>
                                    <input class="form-control otrasReferencias" type="text" name="otras_referencias" autocomplete="off"  value="${otra_referencia==null?'':otra_referencia}">
                                  </div>
                                </div><!-- col-4-->
                              </div>
            `);
            $('#domicilios').html(sDirecciones);
          },500);
        });
        
        
        $('.estado').select2({minimumResultsForSearch: ''});
        $('.municipio').select2({minimumResultsForSearch: ''});
      }

      $('#botonesPartes').append(`<button type="button" class="btn btn-secondary d-inline-block btn-edicion mg-l-auto" onclick="limpiarCamposSujetos()">Cancelar</button>
                                  <button class="btn btn-primary d-inline-block   btn-edicion mg-l-5"  onclick="editarDatosSujeto(${indexp})">Guardar Edición</button>`);
      $('#agregarParte').addClass('d-none').removeClass('d-inline-block');
    
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
  <div id="modalDatosSujetos" class="modal fade">
    <div class="modal-dialog modal-lg mg-b-100" role="document" style="width: -webkit-fill-available;">
      <div class="modal-content tx-size-sm">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"><span id="titleSujeto">Sujetos Procesales</span></h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pd-20" id="divDatosSujeto">
          
        </div><!-- modal-body -->
        <div class="modal-footer d-flex">
          <div id="divEditarDelito">

          </div>
          <button type="button" class="btn btn-secondary d-inline-block mg-l-auto" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->
  <div id="modalEdicion" class="modal fade">
    <div class="modal-dialog modal-lg xl mg-b-100" role="document" style="width: -webkit-fill-available;">
      <div class="modal-content tx-size-sm">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Edición de Personas</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pd-20">
          <div class="row">
            <input type="hidden" id="persona" value="-">
            <div class="col-lg-6">
              <div class="form-group">
                <label class="form-control-label">Calidad Jurídica: <span class="tx-danger">*</span></label>
                <select class="form-control select2-show-search" id="tipoParte" name="tipo_parte" autocomplete="off">
                    <option selected disabled value="">Elija una opción</option>
                    @foreach ($calidad_juridica as $calidad)
                        <option value="{{$calidad['id_calidad_juridica']}}">{{$calidad['calidad_juridica']}}</option>
                    @endforeach
                </select>
              </div>
            </div><!-- col-6 -->
            <div class="col-lg-6">
              <div class="form-group">
                <label class="form-control-label">Tipo Persona: <span class="tx-danger">*</span></label>
                <select class="form-control select2" id="tipoPersona" name="tipo_persona" autocomplete="off">
                    <option selected disabled value="">Elija una opción</option>
                    <option value="fisica">FÍSICA</option>
                    <option value="moral">MORAL</option>
                </select>
              </div>
            </div><!-- col-6-->
            <div class="col-lg-6 fisica">
              <div class="form-group">
                <label class="form-control-label">Nacionalidad: </label>
                <select class="form-control select2" id="nacionalidad" name="nacionalidad" autocomplete="off">
                    <option selected  value="">Elija una opción</option>
                    <option value="mexicana">MEXICANA</option>
                    <option value="mexicana_otro">MEXICANA/OTRO</option>
                    <option value="extranjero">EXTRANJERO</option>
                </select>
              </div>
            </div><!-- col-6-->   
            <div class="col-lg-6 fisica">
              <div class="form-group">
                <label class="form-control-label">Indique la Nacionalidad: </label>
                <select class="form-control select2-show-search" id="otraNacionalidad" name="otra_nacionalidad" autocomplete="off" disabled>
                    <option selected  value="" disabled>Elija una opción</option>
                    @foreach ($nacionalidades as $nacionalidad)
                          <option value="{{$nacionalidad['id_nacionalidad']}}">{{$nacionalidad['nacionalidad']}}</option> 
                    @endforeach
                </select>
              </div>
            </div><!-- col-6-->
            <div class="col-lg-4 fisica">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">CURP:</label>
                <input class="form-control" type="text" name="curp" id="curp" autocomplete="off">
              </div>
            </div><!-- col-4 -->
            <div class="col-lg-4">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">RFC:</label>
                <input class="form-control" type="text" name="rfc" id="rfc" autocomplete="off">
              </div>
            </div><!-- col-4 -->
            <div class="col-lg-8 moral d-none">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Razón Social:</label>
                <input class="form-control" type="text" name="razon_social" id="razonSocial" autocomplete="off">
              </div>
            </div><!-- col-4 -->
            <div class="col-lg-4 fisica">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Cédula Profesional:</label>
                <input class="form-control" type="text" name="cedula_profesional" id="cedulaProfesional" autocomplete="off">
              </div>
            </div><!-- col-4 -->
            <div class="col-lg-4 fisica">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Nombre(s): <span class="tx-danger">*</span></label>
                <input class="form-control" type="text" name="nombre" id="nombre" autocomplete="off">
              </div>
            </div><!-- col-4 -->
            <div class="col-lg-4 fisica">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Apellido Paterno: <span class="tx-danger">*</span></label>
                <input class="form-control" type="text" name="apellido_paterno" id="apellidoPaterno" autocomplete="off">
              </div>
            </div><!-- col-4 -->
            <div class="col-lg-4 fisica">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Apellido Materno:</label>
                <input class="form-control" type="text" name="apellido_materno" id="apellidoMaterno" autocomplete="off">
              </div>
            </div><!-- col-4-->
            <div class="col-lg-3 fisica">
              <div class="form-group">
                <label class="form-control-label">Genero: <span class="tx-danger">*</span></label>
                <select class="form-control select2" id="genero" name="genero" autocomplete="off">
                    <option selected disabled value="">Elija una opción</option>
                    <option value="masculino">MASCULINO</option>
                    <option value="femenino">FEMENINO</option>
                    <option value="indeterminado">INDETERMINADO</option>
                </select>
              </div>
            </div><!-- col-4--> 
            <div class="col-lg-3 fisica">
              <div class="form-group">
                <label class="form-control-label">Estado Civil: </label>
                <select class="form-control select2" id="estadoCivil" name="estado_civil" autocomplete="off">
                    <option selected   value="">Elija una opción</option>
                    @foreach ($estado_civil as $estado)
                        <option value="{{$estado['id_estado_civil']}}">{{$estado['estado_civil']}}</option>
                    @endforeach
                </select>
              </div>
            </div><!-- col-4-->
            <div class="col-lg-3 fisica">
              <div class="form-group">
                <label class="form-control-label">Fecha de Nacimiento: </label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                        </div>
                    </div>
                    <input type="text" class="form-control fc-datepicker" placeholder="DD/MM/AAAA" id="fechaNacimiento" name="fecha_nacimiento" autocomplete="off">
                </div>
              </div>
            </div><!-- col-4 -->
            <div class="col-lg-3 fisica">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Edad:</label>
                <input class="form-control inpur-number" type="text" name="edad" id="edad" autocomplete="off">
              </div>
            </div><!-- col-4-->
          </div>          
          <div id="acordingAlias" class="accordion-two mg-b-15" role="tablist" aria-multiselectable="true">
            <div class="card">
              <div class="card-header" role="tab" id="headingAlias">
                <a data-toggle="collapse" data-parent="#acordingAlias" href="#collapseAlias" aria-expanded="false" aria-controls="collapseAlias" class="tx-gray-800 transition collapsed">
                  Alias
                </a>
              </div><!-- card-header -->
              <div id="collapseAlias" class="collapse" role="tabpanel" aria-labelledby="headingalias">
                <div class="card-body">
                  <button class="btn btn-outline-primary mg-b-10 btn-sm mg-r-10" id="agregarAlias">Agregar Alias <i class="fa fa-plus"></i></button>
                  <div id="datosAlias">{{-- lista de alias --}}
                    
                  </div>
                </div>
              </div>
            </div>
          </div><!-- accordion -->
          <div id="accordionContacto" class="accordion-two mg-b-15" role="tablist" aria-multiselectable="true">
            <div class="card">
              <div class="card-header" role="tab" id="headingContacto">
                <a data-toggle="collapse" data-parent="#accordionContacto" href="#collapseContacto" aria-expanded="false" aria-controls="collapseContacto" class="tx-gray-800 transition collapsed">
                  Agregar Datos de Contacto
                </a>
              </div><!-- card-header -->
              <div id="collapseContacto" class="collapse" role="tabpanel" aria-labelledby="headingContacto">
                <div class="card-body">
                  <div class="row">
                    <div class="col-12">
                      <button class="btn btn-outline-primary mg-b-10 btn-sm mg-r-10 mg-t-15" id="agregarDomicilio">Agregar Domicilio <i class="fa fa-plus"></i></button>
                      <div id="domicilios" class="mg-b-15">
                      </div>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-outline-primary mg-b-10 btn-sm mg-r-10 mg-t-15" id="agregarCorreo">Agregar Correo <i class="fa fa-plus"></i></button>
                      <div id="correos" class="mg-b-15">
                      </div>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-outline-primary mg-b-10 btn-sm mg-r-10" id="agregarTelefono">Agregar Telefono <i class="fa fa-plus"></i></button>
                      <div id="telefonos">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div><!-- accordion -->
          <div id="accordionDatosAdicionales" class="accordion-two" role="tablist" aria-multiselectable="true">
            <div class="card">
              <div class="card-header" role="tab" id="headingDatosAdicionales">
                <a data-toggle="collapse" data-parent="#accordionDatosAdicionales" href="#collapseDatosAdicionales" aria-expanded="false" aria-controls="collapseContacto" class="tx-gray-800 transition collapsed">
                  Datos Adicionales
                </a>
              </div><!-- card-header -->
              <div id="collapseDatosAdicionales" class="collapse" role="tabpanel" aria-labelledby="headingDatosAdicionales">
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="form-control-label">Ocupación: </label>
                        <select class="form-control select2" id="ocupacion" name="ocupacion" autocomplete="off">
                            <option selected   value="">Elija una opción</option>
                            @foreach ($ocupaciones as $ocupacion)
                                <option value="{{$ocupacion['id_ocupacion']}}" data-clave="{{$ocupacion['clave_ocupacion']}}">{{$ocupacion['nombre_ocupacion']}}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="form-control-label">Otra Ocuapación:</label>
                        <input class="form-control" type="text" name="otra_ocupacion" id="otra_ocupacion" autocomplete="off" disabled>
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="form-control-label">Escolaridad: </label>
                        <select class="form-control select2" id="escolaridad" name="escolaridad" autocomplete="off">
                            <option selected   value="">Elija una opción</option>
                            @foreach ($escolaridades as $escolaridad)
                                <option value="{{$escolaridad['id_escolaridad']}}">{{$escolaridad['nivel_escolaridad']}}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="form-control-label">Otra Escolaridad:</label>
                        <input class="form-control" type="text" name="otra_escolaridad" id="otra_escolaridad" autocomplete="off" disabled>
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="form-control-label">Religión: </label>
                        <select class="form-control select2-show-search" id="religion" name="religion" autocomplete="off">
                            <option selected  value="">Elija una opción</option>
                            @foreach ($religiones as $religion)
                                <option value="{{$religion['id_religion']}}">{{$religion['nombre_religion']}}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="form-control-label">Otra Religión:</label>
                        <input class="form-control" type="text" name="otra_religion" id="otra_religion" autocomplete="off" disabled>
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="form-control-label">Grupo Étnico: </label>
                        <select class="form-control select2-show-search" id="grupo_etnico" name="grupo_etnico" autocomplete="off">
                            <option selected   value="">Elija una opción</option>
                            @foreach ($grupos_etnicos as $grupo_etnico)
                                <option value="{{$grupo_etnico['id_grupo_etnico']}}">{{$grupo_etnico['grupo_etnico']}}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="form-control-label">Otro Grupo Étnico:</label>
                        <input class="form-control" type="text" name="otro_grupo_etnico" id="otro_grupo_etnico" autocomplete="off" disabled>
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="form-control-label">Capacidad Diferente: </label>
                        <select class="form-control select2" id="capacidades_diferentes" name="capacidades_diferentes" autocomplete="off">
                            <option selected   value="">Elija una opción</option>
                            <option value="si">SI</option>
                            <option value="no">NO</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="form-control-label">Discapacidad:</label>
                        <input class="form-control" type="text" name="discapacidad" id="discapacidad" autocomplete="off" disabled>
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="form-control-label">Lengua: </label>
                        <select class="form-control select2-show-search" id="lengua" name="lengua" autocomplete="off">
                            <option selected   value="">Elija una opción</option>
                            @foreach ($lenguas as $lengua)
                                <option value="{{$lengua['id_lengua']}}">{{$lengua['lengua']}}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="form-control-label">¿Sabe Leer y Escribir?: </label>
                        <select class="form-control select2" id="sabe_leer_escribir" name="sabe_leer_escribir" autocomplete="off">
                            <option selected   value="">Elija una opción</option>
                            <option value="si">SI</option>
                            <option value="no">NO</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="form-control-label">¿Entiende el Idioma Español?: </label>
                        <select class="form-control select2" id="entiende_idioma_espanol" name="entiende_idioma_espanol" autocomplete="off">
                            <option selected value="">Elija una opción</option>
                            <option value="si">SI</option>
                            <option value="no">NO</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="form-control-label">¿Población Callejera?: </label>
                        <select class="form-control select2" id="poblacion_callejera" name="poblacion_callejera" autocomplete="off">
                            <option selected   value="">Elija una opción</option>
                            <option value="si">SI</option>
                            <option value="no">NO</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="form-control-label">Poblacion LGBTTTI: </label>
                        <select class="form-control select2" id="poblacion" name="poblacion" autocomplete="off">
                            <option selected value="">Elija una opción</option>
                            @foreach ($poblaciones_lgbttti as $poblacion_lgbttti)
                                <option value="{{$poblacion_lgbttti['id_lgbttti']}}">{{$poblacion_lgbttti['nombre_poblacion']}}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="form-control-label">Otra Población:</label>
                        <input class="form-control" type="text" name="otra_poblacion" id="otra_poblacion" autocomplete="off" disabled>
                      </div>
                    </div>
                    <div class="col-lg-3 fisica">
                      <div class="form-group mg-b-10-force">
                        <label class="form-control-label">Nombre Población:</label>
                        <input class="form-control inpur-number" type="text" name="nombre_poblacion" id="nombre_poblacion" autocomplete="off">
                      </div>
                    </div><!-- col-4-->
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="form-control-label">¿Requiere Traducto?: </label>
                        <select class="form-control select2" id="requiere_traductor" name="requiere_traductor" autocomplete="off">
                            <option selected   value="">Elija una opción</option>
                            <option value="si">SI</option>
                            <option value="no">NO</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="form-control-label">Idioma del Traductor: </label>
                        <select class="form-control select2-show-search" id="idioma_traductor" name="idioma_traductor" autocomplete="off" disabled>
                            <option selected   value="">Elija una opción</option>
                            @foreach ($idiomas as $idioma)
                                <option value="{{$idioma['id_idioma']}}">{{$idioma['idioma']}}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="form-control-label">Otro Idioma del Traductor:</label>
                        <input class="form-control" type="text" name="otro_idioma_traductor" id="otro_idioma_traductor" autocomplete="off" disabled>
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="form-control-label">¿Requiere Intérprete?: </label>
                        <select class="form-control select2" id="requiere_interprete" name="requiere_interprete" autocomplete="off">
                            <option selected   value="">Elija una opción</option>
                            <option value="si">SI</option>
                            <option value="no">NO</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="form-control-label">Tipo de Intérprete:</label>
                        <input class="form-control" type="text" name="tipo_interprete" id="tipo_interprete" autocomplete="off" disabled>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div><!-- accordion --> 
        </div><!-- modal-body -->
        <div class="modal-footer d-flex">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary mg-l-auto">Guardar</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->

  {{-- modals remisiones --}}
  <div id="modalRemision" class="modal fade" data-backdrop="static" data-keyboard="false" style="overflow-y: scroll;"> 
    <div class="modal-dialog modal-lg xl mg-b-100 " role="document">
      <div class="modal-content tx-size-sm modalRemision-content">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"><span id="lbl-titulo-modal-remision"></span></h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div> <!-- HEADER -->
        <div class="modal-body pd-20">
          <form action="/" onsubmit="return false;" enctype="multipart/form-data" id="formRemision">
            <div class="row mg-b-25 " id="cuerpoRemision1"><!-- datos de solicitud de audiencia -->
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label">Remitir carpeta judicial:</label>
                  <select class="form-control select2" id="tipoRemision" name="tipo_remision" autocomplete="off" onchange="tipo_Remision()">
                    <option selected value="">Seleccione una Opción</option>
                    <option value="incompetencia">Por Incompetencia</option>
                    <option value="tribunal_enjuiciamiento">A Tribunal de Enjuiciamiento</option>
                    <option value="unidad_ejecucion">A Unidad de Ejecución</option>
                    <option value="preventiva">Reportar Unidad de Ejecución Prisión preventiva</option>
                  </select>
                </div>
              </div>
              <div class="col-lg-8" align="center">
                <div class="form-group mg-t-30 d-none d-lg-block">
                  <h4 id="labelTipoRemision"></h4>
                </div>
              </div>
            </div>
            <hr>
            <div  style="background: #f8f9fa; padding: 10px; min-height: 470px; border: 1px solid #EEE; display: grid;" id="formularioRemision" class="mg-b-25"><!-- datos de solicitud de audiencia -->
            </div>
          </form>
        </div><!-- modal-body -->
        <div class="modal-footer">
          <div style="display: contents">
            <button data-dismiss="modal" aria-label="Close" class="btn btn-secondary mg-r-auto">Cerrar</button>
            <button class="btn btn-primary mg-l-auto" onclick="remisionEjecAutorizacion()" id="btnSiguiente">Solicitar Autorización</button>
          </div>
        </div>
      </div> 
    </div><!-- modal-dialog -->
  </div><!-- modal -->
  
  <div id="modalSentenciado" class="modal fade" data-backdrop="static" data-keyboard="false" style="overflow-y: scroll;">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Datos del sentenciado</h6>
        </div>
        <div class="modal-body pd-20">
          <div class="row mg-b-15">
            <div class="col-12">
              <div class="form-group">
                <label class="form-control-label">Nombre del sentenciado:<span class="tx-danger">*</span></label>
                <select class="form-control select2" id="imputados" name="imputados" autocomplete="off">                    
                </select>
              </div>
            </div>
          </div>
          <div class="row mg-b-15">
            <div class="col-md-5">
              <div class="form-group" id="">
                <label class="form-control-label">¿El sentenciado se encuentra en libertad?:
                  <span class="tx-danger">*</span></label>
                <div class="row pd-7">
                  <div class="col-6 col-md-4">
                    <label class="rdiobox d-inline-block mg-l-20">
                      <input name="sentenciado_libertad" type="radio" value="si" class="sentenciado_libertad" onchange="sentenciadoLibertad()">
                      <span class="pd-l-0">Sí</span>
                    </label>
                  </div>
                  <div class=" col-6 col-md-4">
                    <label class="rdiobox d-inline-block mg-l-20">
                      <input name="sentenciado_libertad" type="radio" value="no" class="sentenciado_libertad" onchange="sentenciadoLibertad()">
                      <span class="pd-l-0">No</span>
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-7">
              <div class="form-group">
                <label class="form-control-label">Centro de detención: <span class="tx-danger">*</span></label>
                <select class="form-control select2" id="centroDetencion" name="centro_detencion" autocomplete="off">
                  <option value="" disabled selected>Seleccione una opción</option>
                  <option value="7">Reclusorio Preventivo Varonil Norte</option>
                  <option value="8">Reclusorio Preventivo Varonil Oriente</option>
                  <option value="9">Reclusorio Preventivo Varonil Sur</option>
                  <option value="10">Centro Femenil de Reinserción Social (Santa Martha)</option>
                  <option value="5">Dr. Lavista</option>
                  <option value="4">Sullivan</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row mg-b-30">
            <div class="col-12">
              <div>
                <div class="d-flex">
                  <label for="table-remi" class="form-control-label">Penas impuestas en la sentencia:</label>
                  <a href="javascript:void(0)" onclick="nuevaPena()" class="mg-l-auto"><i class="fa fa-plus-circle" aria-hidden="true" style="color:#848F33"></i> Agregar pena</a>
                </div>
                <table class="table-remi" id="tablePenas">
                  <thead>
                    <tr>
                      <th class="acciones">Acciones</th>
                      <th class="pena">Pena impuesta</th>
                      <th class="delitos">Deltilos</th>
                      <th class="detalles">Detalles adicionales</th>
                      <th class="sustitutivo">Sustitutivo para la pena</th>
                    </tr>
                  </thead>
                  <tbody id="bodyPenas">
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="row mg-b-15">
            <div class="col-12">
              <div class="form-group" id="">
                <label class="form-control-label">
                  ¿Se concede la SUSPENSIÓN CONDICIONAL DE LA EJECUCIÓN DE LA PENA?:
                  <span class="tx-danger">*</span></label>
                
                  <label class="rdiobox d-inline-block mg-l-15">
                    <input name="suspension_ejecucion" type="radio" value="si" class="suspension_ejecucion">
                    <span class="pd-l-0">Sí</span>
                  </label>
                  <label class="rdiobox d-inline-block mg-l-15">
                    <input name="suspension_ejecucion" type="radio" value="no" class="suspension_ejecucion">
                    <span class="pd-l-0">No</span>
                  </label>
              </div>
            </div>
          </div>
        </div><!-- modal-body -->
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="agregarSentenciado()">Guardar sentenciado</button>
          <button type="button" class="btn btn-secondary" onclick="abreModal('modalRemision',300)" data-dismiss="modal" aria-label="Close">Cerrar</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->

  <div id="modalPenas" class="modal fade" data-backdrop="static" data-keyboard="false" style="overflow-y: scroll;">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Registrar pena</h6>
        </div>
        <div class="modal-body pd-20">
          <div class="card">
            <div class="card-header">
              <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                  <a class="nav-link active" href="#datosGenerales" data-toggle="tab" id="navDatosGenerales">Datos generales</a>
                </li>
                <li class="nav-item d-none" id="sectionAbonoPrision">
                  <a class="nav-link" href="#abonoPrision" data-toggle="tab">Abono de prisión preventiva</a>
                </li>
                <li class="nav-item d-none" id="sectionSustitutivosPena">
                  <a class="nav-link" href="#sutitutivosPena" data-toggle="tab">Sustitutivos de pena</a>
                </li>
              </ul>
            </div><!-- card-header -->
            <div class="card-body">
              <div class="tab-content">
                <div class="tab-pane active" id="datosGenerales">
                  <div class="row mg-b-10">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="form-control-label">Tipo de pena:<span class="tx-danger">*</span></label>
                        <select class="form-control select2" id="tipoPena" name="tipo_pena" autocomplete="off" onchange="obtenerPenas()">  
                          <option value="" disabled selected>Seleccione una opción</option>
                          @foreach ($penas as $pena)
                              <option value="{{$pena['id_tipo_pena']}}">{{$pena['descripcion']}}</option>
                          @endforeach                   
                        </select>
                      </div>
                    </div>
                    <div class="col-md-8">
                      <div class="form-group">
                        <label class="form-control-label">Tipo de pena:<span class="tx-danger">*</span></label>
                        <select class="form-control" id="penaImpuesta" name="pena_impuesta" autocomplete="off" onchange="penaImpuesta()">
                          <option value="">Seleccione una opción</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row mg-b-10 d-none" id="divDecomisos">
                    <div class="col-md-4">
                      <label class="ckbox">
                        <input type="checkbox" class="decomiso" id="decomisoInstrumento"><span>Decomiso de instrumento</span>
                      </label>
                    </div>
                    <div class="col-md-4">
                      <label class="ckbox">
                        <input type="checkbox" class="decomiso" id="decomisoObjetos"><span>Decomiso de objetos</span>
                      </label>
                    </div>
                    <div class="col-md-4">
                      <label class="ckbox">
                        <input type="checkbox" class="decomiso" id="decomisoProductos"><span>Decomiso de productos del delito</span>
                      </label>
                    </div>
                  </div>
                  <div class="row mg-b-10">
                    <div class="col-12">
                      <div class="form-group d-none" id="divDetallePena">
                        <label class="form-control-label">Detalle de la pena:<span class="tx-danger">*</span></label>
                        <select class="form-control" id="detallePena" name="detalle_pena" autocomplete="off">  
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row mg-b-10 d-none" id="divPeriodo">
                    <div class="col-md-2">
                      <div class="form-group">
                        <label class="form-control-label">Años: <span class="tx-danger">*</span></label>
                        <input class="form-control input-number" type="text" name="periodo_anios" id="periodoAnios" autocomplete="off" oninput="calculoAbonoSentencia()" min="0" >
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label class="form-control-label">Meses: <span class="tx-danger">*</span></label>
                        <input class="form-control input-number" type="text" name="periodo_meses" id="periodoMeses" value=""  placeholder="" autocomplete="off" oninput="calculoAbonoSentencia()" min="0">
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label class="form-control-label">Días: <span class="tx-danger">*</span></label>
                        <input class="form-control input-number" type="text" name="periodo_dias" id="periododias" value=""  placeholder="" autocomplete="off" oninput="calculoAbonoSentencia()" min="0">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group" id="divCentroDetencionPena">
                        <label class="form-control-label">Centro de detención actual:<span class="tx-danger">*</span></label>
                        <select class="form-control" id="centroDetencionPena" name="centro_detencion_pena" autocomplete="off" >  
                          <option value="" disabled selected>Seleccione una opción</option>
                          @foreach ($centros_detencion as $centro_detencion)
                              <option value="{{$centro_detencion['id_reclusorio']}}">{{$centro_detencion['nombre']}}</option>
                          @endforeach                   
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row mg-b-10">
                    <div class="col-12">
                      <div class="form-group">
                        <label class="form-control-label">Detalles Adicionales:</label>
                        <textarea class="form-control" name="detalles_adicionales" id="detallesAdicionalesPena" rows="4"></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="row mg-b-30">
                    <div class="col-12">
                      <div>
                        <div class="row">
                          <div class="col-6">
                            <label for="table-remi" class="form-control-label">Delitos por los cuales se impone al pena:</label>
                          </div>
                          <div class="col-6 text-right">
                            <a href="javascript:void(0)" onclick="nuevoDelito()" class=""><i class="fa fa-plus-circle" aria-hidden="true" style="color:#848F33"></i> Agregar delito</a>
                          </div>
                        </div>
                        <table class="table-remi">
                          <thead>
                            <tr>
                              <th class="acciones">Acciones</th>
                              <th class="delito">Delitos</th>
                            </tr>
                          </thead>
                          <tbody id="bodyDelitos">
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div><!-- tab-pane -->
                <div class="tab-pane" id="abonoPrision">
                  <div class="row mg-b-15">
                    <div class="col-12">
                      <a href="javascript:void(0)" onclick="nuevoAbono()"><i class="fa fa-plus-circle" aria-hidden="true" style="color:#848F33"></i> Agregar cómputo</a>
                    </div>
                  </div>
                  <div class="row mg-b-15 d-none" id="divCentroDetencionAbono">
                    <div class="col-md-2">
                      <div class="form-group">
                        <label class="form-control-label">Años: <span class="tx-danger">*</span></label>
                        <input class="form-control input-number" type="text" name="abono_anios" id="abonoAnios" value="">
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label class="form-control-label">Meses: <span class="tx-danger">*</span></label>
                        <input class="form-control input-number" type="text" name="abono_meses" id="abonoMeses" value="">
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label class="form-control-label">Días: <span class="tx-danger">*</span></label>
                        <input class="form-control input-number" type="text" name="abono_dias" id="abonodias" value="">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="form-control-label">Centro de detención:<span class="tx-danger">*</span></label>
                        <select class="form-control select2-show-search" id="centroDetencionAbono" name="centro_detencion_abono" autocomplete="off" onchange="centroDetencionAbono()">  
                          <option value="" selected disabled>Seleccione una opción</option>
                          <option value="otro">Otro</option>
                          @foreach ($centros_detencion as $centro_detencion)
                              <option value="{{$centro_detencion['id_reclusorio']}}">{{$centro_detencion['nombre']}}</option>
                          @endforeach                   
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="form-control-label">Otro centro de detención:</label>
                        <input class="form-control" type="text" name="centro_detencion_abono_otro" id="centroDetencionAbonoOtro" value=""  placeholder="" autocomplete="off">
                      </div>
                    </div>
                    <div class="col-md-6" style="padding-top: 28px">
                      <button type="button" class="btn btn-outline-primary" onclick="agregarAbono()">Agregar</button>
                      <button type="button" class="btn btn-outline-secondary"  onclick="cancelarAbono()">Cancelar</button>
                    </div>
                  </div>
                  <div class="row mg-b-30">
                    <div class="col-md-12">
                      <table class="table-remi d-block">
                        <thead>
                          <th class="acciones">Acciones</th>
                          <th class="anios_abono">Años</th>
                          <th class="meses_abono">Meses</th>
                          <th class="dias_abono">Días</th>
                          <th class="centro_abono">Centro de detención</th>
                          <th class="otro_centro_abono">Otro centro de detención</th>
                        </thead>
                        <tbody id="bodyAbonos"></tbody>
                      </table>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <p style="font-weight: bold">Total de abono de prisión preventiva:</p>
                    </div>
                    <div class="col-md-4">
                      <p><span id="abonoAniosTotal">0</span> años, <span id="abonoMesesTotal">0</span> meses, <span id="abonoDiasTotal">0</span> días</p>
                    </div>
                  </div>
                  <div class="row mg-b-15">
                    <div class="col-md-4">
                      <p style="font-weight: bold">Total de sentencia por cumplir:</p>
                    </div>
                    <div class="col-md-4">
                      <p><span id="aniosTotalCumplir">0</span> años, <span id="mesesTotalCumplir">0</span> meses, <span id="diasTotalCumplir">0</span> días</p>
                    </div>
                  </div>
                </div><!-- tab-pane -->
                <div class="tab-pane" id="sutitutivosPena">
                  <div class="row mg-b-15">
                    <div class="col-12">
                      <a href="javascript:void(0)" onclick="nuevoSustitutivo()"><i class="fa fa-plus-circle" aria-hidden="true" style="color:#848F33"></i> Agregar sustitutivo</a>
                    </div>
                  </div>
                  <div id="sistitutivoNuevo" class="d-none">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="form-control-label">Sustitutivo:<span class="tx-danger">*</span></label>
                          <select class="form-control select2-show-search" id="sustitutivo" name="sustitutivo" autocomplete="off" onchange="sustitutivo()">  
                            <option value="" selected>Seleccione una opción</option>
                            <option value="1" >Multa en beneficio de la víctima</option>
                            <option value="2" >Multa en favor de la comunidad</option>
                            <option value="3" >Trabajo en beneficio de la víctima</option>
                            <option value="4" >Trabajo en favor de la comunidad</option>
                            <option value="5" >Tratamiento en libertad</option>
                            <option value="6" >Tratamiento en semilibertad</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group d-none" id="divMonto">
                          <label class="form-control-label">Monto:</label>
                          <input class="form-control input-money" type="text" name="monto_sustitutivo" id="montoSustitutivo" value="" autocomplete="off">
                        </div>
                      </div>
                    </div>
                    <div class="row mg-b-15">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="form-control-label">¿Se acoge al sustitutivo?<span class="tx-danger">*</span></label>
                          <div class="d-inline-block mg-l-5 mg-t-10" id="divMateriaDestino">
                            <label class="rdiobox d-inline-block mg-l-5">
                              <input name="acoge_sustitutivo" type="radio" value="si" class="acoge_sustitutivo_val">
                              <span class="pd-l-0">Si</span>
                            </label>
                            <label class="rdiobox d-inline-block mg-l-5">
                              <input name="acoge_sustitutivo" type="radio" value="no" class="acoge_sustitutivo_val">
                              <span class="pd-l-0">no</span>
                            </label>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row mg-b-15">
                      <div class="col-lg-12">
                        <div class="form-group">
                          <label class="form-control-label">Detalles adicionales:</label>
                          <textarea class="form-control" name="detalles_adicionales_sustitutivo" id="detallesAdicionalesSustitutivo" rows="4"></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="row mg-b-20">
                      <div class="col-12 d-flex">
                        <button type="button" class="btn btn-outline-primary mg-l-auto" onclick="agregarSustitutivo()">Guardar</button>
                        <button type="button" class="btn btn-outline-secondary mg-l-10" onclick="cancelarSustitutivo()">Cancelar</button>
                      </div>
                    </div>
                  </div>
                  <div class="row mg-b-30">
                    <div class="col-12">
                      <table class="table-remi d-block d-md-table">
                        <thead>
                          <th class="acciones">Acciones</th>
                          <th class="sustitutivo">Sustitutivo</th>
                          <th class="monto_sustitutivo">Monto</th>
                          <th class="acoge_sustitutivo">Se acoge al sustitutivo</th>
                          <th class="detalles_adicionales_sustitutivo">Detalles adicionales</th>
                        </thead>
                        <tbody id="bodySustitutivos"></tbody>
                      </table>
                    </div>
                  </div>
                </div><!-- tab-pane -->
              </div><!-- tab-content -->
            </div><!-- card-body -->
          </div><!-- card -->            
        </div><!-- modal-body -->
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="agregarPena()">Guardar pena</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="abreModal('modalSentenciado',400)">Cerrar</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->

  <div id="modalDelitos" class="modal fade" data-backdrop="static" data-keyboard="false" style="overflow-y: scroll;">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Agregar delito</h6>
        </div>
        <div class="modal-body pd-20">
          <div class="row mg-b-10">
            <div class="col-12">
              <div class="form-group">
                <label class="form-control-label">Delito a agregar:<span class="tx-danger">*</span></label>
                <select class="form-control select2-show-search" id="delitoPena" name="delitoPena" autocomplete="off">                    
                </select>
              </div>
            </div>              
          </div>
        </div><!-- modal-body -->
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="agregarDelito()">Guardar delito</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="abreModal('modalPenas',400)">Cerrar</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->

  <div id="modalDefensor" class="modal fade" data-backdrop="static" data-keyboard="false" style="overflow-y: scroll;">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Agregar defensor</h6>
        </div>
        <div class="modal-body pd-20">
          <div class="row mg-b-10">
            <div class="col-md-4">
              <div class="form-group">
                <label class="form-control-label">Tipo de presona:<span class="tx-danger">*</span></label>
                <select class="form-control select2-show-search" id="tipoPersonaDefensor" name="tipo_persona_defensor" autocomplete="off"> 
                  <option value="" selected disabled>Seleccione una opción</option>
                  <option value="fisica">Física</option>
                  <option value="moral">Moral</option>
                </select>
              </div>
            </div>     
            <div class="col-md-4 fisica">
              <div class="form-group">
                <label class="form-control-label">Nacionalidad:<span class="tx-danger">*</span></label>
                <select class="form-control select2-show-search" id="nacionalidadDefensor" name="nacionalidad_defensor" autocomplete="off"> 
                  <option value="" selected disabled>Seleccione una opción</option>
                  <option value="mexicana">Mexicana</option>
                  <option value="extranjero">Extranjero</option>
                  <option value="mexicana_otro">Mexicana/Otra</option>
                  <option value="no_especificada">No especificada</option>
                </select>
              </div>
            </div> 
          </div>
          <div class="row">    
            <div class="col-lg-6 fisica">
              <div class="form-group">
                <label class="form-control-label">Indique la Nacionalidad: </label>
                <select class="form-control " id="otraNacionalidadDefensor" name="otra_nacionalidad_defensor" autocomplete="off" disabled>
                    <option selected  value="" disabled>Elija una opción</option>
                    @foreach ($nacionalidades as $nacionalidad)
                          <option value="{{$nacionalidad['id_nacionalidad']}}">{{$nacionalidad['nacionalidad']}}</option> 
                    @endforeach
                </select>
              </div>
            </div><!-- col-6-->    
          </div>
          <div class="row mg-b-15">
            <div class="col-lg-4 fisica">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Nombre(s): <span class="tx-danger">*</span></label>
                <input class="form-control" type="text" name="nombre_defensor" id="nombreDefensor" autocomplete="off">
              </div>
            </div><!-- col-4 -->
            <div class="col-lg-4 fisica">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Apellido Paterno: <span class="tx-danger">*</span></label>
                <input class="form-control" type="text" name="apellido_paterno_defensor" id="apellidoPaternoDefensor" autocomplete="off">
              </div>
            </div><!-- col-4 -->
            <div class="col-lg-4 fisica">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Apellido Materno:</label>
                <input class="form-control" type="text" name="apellido_materno_defensor" id="apellidoMaternoDefensor" autocomplete="off">
              </div>
            </div><!-- col-4-->
          </div>
          <div class="row mg-b-15">
            <div class="col-lg-3 fisica">
              <div class="form-group">
                <label class="form-control-label">Genero: <span class="tx-danger">*</span></label>
                <select class="form-control select2" id="generoDefensor" name="genero_defensor" autocomplete="off">
                    <option selected disabled value="">Elija una opción</option>
                    <option value="masculino">MASCULINO</option>
                    <option value="femenino">FEMENINO</option>
                    <option value="indeterminado">INDETERMINADO</option>
                </select>
              </div>
            </div><!-- col-4-->
          </div>
          <div class="row mg-b-15">
            <div class="col-lg-3 fisica">
              <div class="form-group">
                <label class="form-control-label">Fecha de Nacimiento: </label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                        </div>
                    </div>
                    <input type="text" class="form-control fc-datepicker" placeholder="DD/MM/AAAA" id="fechaNacimientoDefensor" name="fecha_nacimiento_defensor" autocomplete="off">
                </div>
              </div>
            </div><!-- col-4 -->
            <div class="col-lg-3 fisica">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Edad:</label>
                <input class="form-control input-number" type="text" name="edad_defensor" id="edadDefensor" autocomplete="off">
              </div>
            </div><!-- col-4-->
          </div>
          <div class="row mg-b-15">
            <div class="col-lg-3 fisica">
              <div class="form-group">
                <label class="form-control-label">Estado Civil: </label>
                <select class="form-control select2" id="estadoCivilDefensor" name="estado_civil_defensor" autocomplete="off">
                    <option selected   value="">Elija una opción</option>
                    @foreach ($estado_civil as $estado)
                        <option value="{{$estado['id_estado_civil']}}">{{$estado['estado_civil']}}</option>
                    @endforeach
                </select>
              </div>
            </div><!-- col-4-->
            <div class="col-lg-4 fisica">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">CURP:</label>
                <input class="form-control" type="text" name="curp_defensor" id="curpDefensor" autocomplete="off">
              </div>
            </div><!-- col-4 -->
          </div>
          <div class="row mg-b-15">  
            <div class="col-lg-8 moral d-none">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Razón Social:</label>
                <input class="form-control" type="text" name="razon_social_defensor" id="razonSocialDefensor" autocomplete="off">
              </div>
            </div><!-- col-4 -->
            <div class="col-lg-4 moral d-none">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">RFC:</label>
                <input class="form-control" type="text" name="rfc_defensor" id="rfcDefensor" autocomplete="off">
              </div>
            </div><!-- col-4 -->
          </div>
        </div><!-- modal-body -->
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="agregarNuevoDefensor()">Agregar delito</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="abreModal('modalPenas',400)">Cerrar</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->

  <div id="modalDocumento" class="modal fade" data-backdrop="static" data-keyboard="false" style="overflow-y: scroll;">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-inverse tx-bold" id="nombreDocumento"></h6>
        </div>
        <div class="modal-body pd-20" id="objectDocumento">
        </div><!-- modal-body -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="abreModal('modalRemision',400)">Cerrar</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->

@endsection