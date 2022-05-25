@php
  use App\Http\Controllers\clases\utilidades;
@endphp

@extends('layouts.index')

{{-- Header --}}
@section('contenido-pageheader')
  <ol class="breadcrumb slim-breadcrumb">
     <li class="breadcrumb-item"><a href="javascript:void(0);">Recursos Adicionales</a></li>
     <li class="breadcrumb-item"><a href="javascript:void(0);"> Consulta Recursos Adicionales</a></li>
  </ol>
  <h6 class="slim-pagetitle">  Recursos Adicionales</h6>
@endsection
{{-- Estilos --}}
@section('seccion-estilos')
    <link href="{{asset("/lib/datatables/css/jquery.dataTables.css")}}" rel="stylesheet">
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
    <style>
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
        #collapseSearchAdvance{
          border: 1px solid #eee !important;
          background: #f8f9fa;
        }
        #accordion a::before{
          top: 10px !important;
        }
        .select2-container.select2-container--default.select2-container--open{
            z-index: 1050 !important;
        }
        .page-link{
            border:none !important;
        }
        table {
            width: 100%;
            border-bottom: 1px solid #f0f2f7;
            font-size: 1.1em;
        }
        .thead{
            background-color: #EBEEF1; 
            color: #444; 
            text-align:center;
        }
        th, tr{
            cursor: pointer;
        }
        td.acciones {
            font-size: 25px !important;
            padding-top: 0 !important;
            padding-bottom: 0 !important;
            display: inline-block;
        }
        td.acciones a {
            display: inline;
            margin-left: 20%;
            cursor: pointer;
            text-align: left;
        }
        td.acciones a:first-child {
            margin-left: 0;
            text-align: left;
        }
        .boton{
            background: #848F33 !important;
            color: #fff !important;
            border: none !important;
            box-shadow: none !important;
            border-radius: 8px !important;
            width: 25px;
            height: 25px;
            margin: 0px 10px;
            padding: 0px !important;
            font-size: 0.8em !important;
        }
        .boton:hover{
            opacity: 0.9;
        }
        .boton:active{
            border: none !important;
            box-shadow: none !important;
        }
        .modal-size{
            width: 95% !important;
        }
        @media(min-width: 1200px){
            .modal-size{
                width: 30% !important;
            }
        }
        @media(min-width: 1024px){
            .modal-size{
                width: 50% !important;
            }
        }
        .acciones1{
            width: 150px;
        }
        .nav-tabs .nav-link.active{
            background: #848F33 !important;
            color: #fff !important;
        }
    </style>
@endsection

{{-- Contenido Principal --}}
@section('contenido-principal')
    <div class="section-wrapper" style="max-width: 100%;">
        <div class="form-layout">
            {{--  Busqueda Avanzada  --}}
            <div id="accordion" class="accordion-one mg-b-15" role="tablist" aria-multiselectable="true">
                <div class="card">
                    {{--  header del card  --}}
                    <div class="card-header" role="tab" id="headingOne">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseSearchAdvance" aria-expanded="false" aria-controls="collapseSearchAdvance" class="tx-gray-800 transition collapsed">
                            <i class="fa fa-search" aria-hidden="true"></i> 
                        </a>
                    </div>
                    {{--  body del card  --}}
                    <div id="collapseSearchAdvance" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                        <div class="card-body">
                            {{--  Formulario de la busqueda avanzada --}}
                            <div class="row mg-b-25 d-flex justify-content-start">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="label">Codigo:</label>
                                        <select class="form-control-lg select2 valid" id="tipoRecurso_option">
                                            <option value="" selected>Todas</option>
                                            <option value="Sala de Sala de prueba">Sala de Telepresencia</option>
                                            <option value="Sala de prueba">Sala de prueba</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="label">Estatus:</label>
                                        <select class="form-control-lg select2 valid" id="status_option">
                                            <option value="" selected>Todas</option>
                                            <option value="1">Activo</option>
                                            <option value="0">Inactivo</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            {{--  Boton para filtrar  --}}
                            <div class="row d-flex justify-content-center">
                                <div class="col-lg-9">
                                    <button type="button" class="btn btn-primary btn-sm btn-block mg-b-10" data-toggle="collapse" data-target="#demo">Filtrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{--  Botones de De exportacion  --}}

            <div class="row justify-content-between">
                {{--  <input type="hidden" id="filtro_consulta" name="filtro_consulta" value="">  --}}
                <div class="col-sm-3 col-md-4 col-lg-2 pd-t-10" id="NTRec" align="left">
                    <a href="javascript:void(0);" onclick="nuevo_recurso()" class="btn btn-primary btn-sm btn-block "><i class="fa fa-pdf mg-r-5"></i>Nuevo  Recurso</a>
                </div>

                <div class="col-sm-9 col-md-8 col-lg-10 d-flex justify-content-end" align="right" style="display: none !important;">
                    <div class="col-sm-4 col-md-4 col-lg-2 pd-t-10 pd-l-0-force" align="right">
                        <a href="javascript:void(0);" onclick="descargar_consulta('xls');" class="btn btn-primary btn-sm btn-block "><i class="fa fa-pdf mg-r-5"></i>Exportar Excel</a>
                    </div>
    
                    <div class="col-sm-4 col-md-4 col-lg-2 pd-t-10 pd-r-0-force" align="right">
                        <a href="javascript:void(0);" onclick="descargar_consulta('pdf');" class="btn btn-primary btn-sm btn-block "><i class="fa fa-pdf mg-r-5"></i>Exportar PDF</a>
                    </div>
                </div>
            </div>

            {{--  Paginacion Cabecera  --}}

            <div class="pagination-wrapper justify-content-between mg-y-20">
                <ul class="pagination mg-b-0">
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0);" onclick="cargarTablaRecursos('primera');" aria-label="Last">
                            <i class="fa fa-angle-double-left"></i>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0);" onclick="cargarTablaRecursos('atras');" aria-label="Next">
                            <i class="fa fa-angle-left"></i>
                        </a>
                    </li>
                </ul>
                <div id="texto_paginator">Página <span class="pagina_actual_texto">0</span> de <span class="pagina_total_texto">0</span></div>
                <ul class="pagination mg-b-0">
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0);" onclick="cargarTablaRecursos('avanzar');" aria-label="Next">
                        <i class="fa fa-angle-right"></i>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0);" onclick="cargarTablaRecursos('ultima');" aria-label="Last">
                            <i class="fa fa-angle-double-right"></i>
                        </a>
                    </li>
                </ul>
            </div>

            {{--  Tabla de registros  --}}

            <div  class="mg-b-20 table-responsive" >
                <table id="recursosTable" class="table table-hover dataTable pd-y-0"  role="grid" aria-describedby="example_info">
                  <thead class="thead">
                      <tr>
                          <th class="acciones1">Acciones</th>
                          <th>Tipo de Recurso</th>
                          <th>Descripción</th>
                          <th class="acciones1">Codigo</th>
                          <th class="acciones1">Status</th>
                      </tr>
                  </thead>
                  <tbody id="body-table1"  style="width: 100%; text-align: center;">
                    
                  </tbody>
                </table>

            </div>

            {{--  Paginacion pie de pagina  --}}

            <div class="pagination-wrapper justify-content-between mg-y-20">
                <ul class="pagination mg-b-0">
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0);" onclick="cargarTablaRecursos('primera');" aria-label="Last">
                            <i class="fa fa-angle-double-left"></i>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0);" onclick="cargarTablaRecursos('atras');" aria-label="Next">
                            <i class="fa fa-angle-left"></i>
                        </a>
                    </li>
                </ul>
                <div id="texto_paginator">Página <span class="pagina_actual_texto">0</span> de <span class="pagina_total_texto">0</span></div>
                <ul class="pagination mg-b-0">
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0);" onclick="cargarTablaRecursos('avanzar');" aria-label="Next">
                        <i class="fa fa-angle-right"></i>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0);" onclick="cargarTablaRecursos('ultima');" aria-label="Last">
                            <i class="fa fa-angle-double-right"></i>
                        </a>
                    </li>
                </ul>
            </div>

            {{-- pagination params --}}
            <input type="hidden" id="pagina_actual" name="pagina_actual" value="1">
            <input type="hidden" id="paginas_totales" name="paginas_totales" value="1">
            <input type="hidden" id="numeropagina">
        </div>
    </div>

@endsection


{{--  Modal agregar Recurso  --}}
<div class="modal fade" id="modalNuevoRecurso"  tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none">
    <div class="modal-dialog modal-lg modal-size">
        <div class="modal-content" >
            <div class="modal-header" >
                <h5 class="modal-title">Nuevo Tipo de Recurso</h5>
            </div>
            <div class="modal-body">
                <input type="hidden" id="codigoConsecutivo1">
                <input type="hidden" id="codigoConsecutivo2">
                <div class="row form-layout">
                    <div class="col-sm-10 col-lg-6">
                        <label class="label">Tipo de Recurso: <span class="tx-danger">*</span></label>
                        <div class="form-group">
                                <input type="text" style="text-align:center;" class="form-control"  id="RegistroNuevoTipoRecurso" placeholder="Escribe tipo de recurso" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-sm-10 col-lg-6">
                        <label class="label">Descripción: <span class="tx-danger">*</span></label>
                        <div class="form-group">
                                <input type="text" style="text-align:center;" class="form-control"  id="RegistroNuevoDescripcion" placeholder="Escribe una descripcón" autocomplete="off">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="cerrar_modal('modalNuevoRecurso')" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" onclick="guardar_recurso('modalNuevoRecurso')" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Editar Recurso --}}
<div class="modal fade" id="modalEditRecurso"  tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none">
    <div class="modal-dialog modal-lg modal-size">
        <div class="modal-content" >
            <div class="modal-header" >
                <h5 class="modal-title">Tipo de Recurso <span id="idE_TR">-</span></h5>
            </div>
            <div class="modal-body">
                <input type="hidden" id="idTipoRecurso">
                <div class="row form-layout">
                    <div class="col-lg-4">
                        <label class="label">Tipo de Recurso Adicional: <span class="tx-danger">*</span></label>
                        <div class="form-group">
                          <input type="text" style="text-align:center;" class="form-control"  id="RecursoRegistroEditar" placeholder="Escribe la Recurso adicional" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <label class="label">Descripcion: <span class="tx-danger">*</span></label>
                        <div class="form-group">
                          <input type="text" style="text-align:center;" class="form-control"  id="DescripcionRegistroEditar" placeholder="Escribe una descripcion" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="label">Estatus:</label>
                            <select class='form-control-lg select2 valid' id='estatusRegistroEditar'>
                                <option value="1" selected>ACTIVO</option>
                                <option value="0">INACTIVO</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="cerrar_modal('modalEditRecurso')" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" onclick="editar_recurso('modalEditRecurso')" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal agregar/editar Recurso Audiencia --}}
<div class="modal fade" id="modalNuevoRecursoAudiencia"  tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none">
    <div class="modal-dialog modal-lg modal-size">
        <div class="modal-content" >
            <div class="modal-header" >
                <h5 class="modal-title">Nuevo Recurso Audiencia <span id="idTR">-</span></h5>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" id="nav-addRecurso" data-toggle="tab" href="#addRecurso" role="tab" aria-controls="nav-home" aria-selected="true" >Agregar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="nav-editRecurso" data-toggle="tab" href="#editRecurso" role="tab" aria-controls="nav-profile" aria-selected="false">Editar</a>
                    </li>
                    <li id="listaRecursosAudiencia" class="nav-item dropdown" style="display: none">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Recursos Audiencia</a>
                        <div class="dropdown-menu" style="height: 200px; overflow:auto;" id="catalogo_recursos_audiencia">
                          <a class="dropdown-item" href="#">Cubículo de Telepresencia 1 - Rec. Sur</a>
                        </div>
                    </li>
                </ul>
                <div class="tab-content" id="nav-tabContent">
                    {{-- Agregar Recurso de audiencia --}}
                    <div class="tab-pane fade show active" id="addRecurso" role="tabpanel" aria-labelledby="nav-addRecurso">
                        <div class="row form-layout mt-4">
                            <input type="hidden" id="A_idTipoRecurso">
                            <div class="col-lg-12">
                                <label class="label">Nombre Recurso: <span class="tx-danger">*</span></label>
                                <div class="form-group">
                                        <input type="text" style="text-align:center;" class="form-control"  id="A_nombreRecurso" placeholder="Escribe el Nombre Recurso" autocomplete="off">
                                </div>
                            </div>
                            <!-- <div class="col-lg-4">
                                <label class="label">Codigo unidad: <span class="tx-danger">*</span></label>
                                <div class="form-group">
                                        <input type="text" style="text-align:center; cursor: no-drop !important;" class="form-control"  id="A_codigoUnidad" placeholder="Escribe el Codigo unidad"  autocomplete="off" value="001" readonly>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <label class="label">Codigo institucion: <span class="tx-danger">*</span></label>
                                <div class="form-group">
                                        <input type="text" style="text-align:center; cursor: no-drop !important;" class="form-control"  id="A_codigo_Institucion" placeholder="Escribe la institucion"  autocomplete="off" value="001" readonly>
                                </div> 
                            </div> -->
                            <div class="col-lg-6">
                                <label class="label">Codigo: <span class="tx-danger">*</span></label>
                                <div class="form-group">
                                        <input type="text" style="text-align:center; cursor: no-drop !important;" class="form-control"  id="A_codigo" placeholder="Escribe el Codigo" autocomplete="off" readonly>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label class="label">Clave Recurso: <span class="tx-danger">*</span></label>
                                <div class="form-group">
                                        <input type="text" style="text-align:center;" class="form-control"  id="A_claveRecurso" placeholder="Escribe la Clave recurso" autocomplete="off">
                                </div>
                            </div>
                            <!-- <div class="col-lg-4">
                                <label class="label">Adscripcion: <span class="tx-danger">*</span></label>
                                <div class="form-group">
                                        <input type="text" style="text-align:center; cursor: no-drop !important;" class="form-control"  id="A_adscripcion" placeholder="Escribe la Adscripcion"  autocomplete="off" value="00020003" readonly>
                                </div>
                            </div> -->
                        </div>
                    </div>
                    {{-- Editar Recurso de Audiencia --}}
                    <div class="tab-pane fade" id="editRecurso" role="tabpanel" aria-labelledby="nav-editRecurso">
                        <div class="row form-layout mt-4">
                            <input type="hidden" id="E_idTipoRecurso">
                            <input type="hidden" id="E_idRecursoAudiencia">
                            <div class="col-lg-12">
                                <label class="label">Nombre Recurso: <span class="tx-danger">*</span></label>
                                <div class="form-group">
                                        <input type="text" style="text-align:center;" class="form-control"  id="E_nombreRecurso" placeholder="Escribe el Nombre Recurso" autocomplete="off">
                                </div>
                            </div>
                            <!-- <div class="col-lg-4">
                                <label class="label">Codigo unidad: <span class="tx-danger">*</span></label>
                                <div class="form-group">
                                        <input type="text" style="text-align:center; cursor: no-drop !important;" class="form-control"  id="E_codigoUnidad" placeholder="Escribe el Codigo unidad"  autocomplete="off" readonly>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <label class="label">Codigo institucion: <span class="tx-danger">*</span></label>
                                <div class="form-group">
                                        <input type="text" style="text-align:center; cursor: no-drop !important;" class="form-control"  id="E_codigo_Institucion" placeholder="Escribe la institucion" autocomplete="off" readonly>
                                </div>
                            </div> -->
                            <div class="col-lg-4">
                                <label class="label">Codigo: <span class="tx-danger">*</span></label>
                                <div class="form-group">
                                        <input type="text" style="text-align:center; cursor: no-drop !important;" class="form-control"  id="E_codigo" placeholder="Escribe el Codigo" autocomplete="off" readonly>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <label class="label">Clave Recurso: <span class="tx-danger">*</span></label>
                                <div class="form-group">
                                        <input type="text" style="text-align:center;" class="form-control"  id="E_claveRecurso" placeholder="Escribe la Clave recurso" autocomplete="off">
                                </div>
                            </div>
                            <!-- <div class="col-lg-4">
                                <label class="label">Adscripcion: <span class="tx-danger">*</span></label>
                                <div class="form-group">
                                        <input type="text" style="text-align:center; cursor: no-drop !important;" class="form-control"  id="E_adscripcion" placeholder="Escribe la Adscripcion"  autocomplete="off" readonly>
                                </div>
                            </div> -->
                            <div class="col-lg-4">
                                <label class="label">Estatus:</label>
                                <div class="form-group">
                                    <select class='form-control-lg select2 valid' id='E_estatus'>
                                        <option value="1" selected>Activo</option>
                                        <option value="0">Inactivo</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="cerrar_modal('modalNuevoRecursoAudiencia')" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" id="saveRecursoAudiencia" onclick="guardar_recurso_audiencia('modalNuevoRecursoAudiencia')" class="btn btn-primary">Guardar</button>
                <button type="button" id="updateRecursoAudiencia" onclick="update_recurso_audiencia('modalNuevoRecursoAudiencia')" class="btn btn-primary" style="display: none;">Actualizar</button>
            </div>
        </div>
    </div>
</div>

{{-- modales de exito y error --}}
<div id="modalSuccess" class="modal fade"  data-backdrop="static" data-keyboard="false" style="display: none">
    <div class="modal-dialog" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-body tx-center pd-y-20 pd-x-20">
          <i class="icon ion-ios-checkmark-outline tx-100 tx-success lh-1 mg-t-20 d-inline-block"></i>
          <h4 class="tx-success tx-semibold mg-b-20">Hecho!</h4>
          <div id="messageExito">
          </div>
        </div><!-- modal-body -->
        <div class="modal-footer d-flex">
          <button type="button" class="btn btn-primary pd-x-25 mg-l-auto" data-dismiss="modal" aria-label="Close" >Aceptar</button>
        </div>
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div>

<div id="modalError" class="modal fade" style="display: none">
    <div class="modal-dialog" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-body tx-center pd-y-20 pd-x-20">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <i class="icon icon ion-ios-close-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
          <div id="messageError">
          </div>
          <button type="button" class="btn btn-danger pd-x-25" data-dismiss="modal" aria-label="Close">Aceptar</button>
        </div><!-- modal-body -->
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->

<div id="modalWarning" class="modal fade"  data-backdrop="static" data-keyboard="false" style="display: none">
    <div class="modal-dialog" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-body tx-center pd-y-20 pd-x-20">
          <i class="icon ion-warning-outline tx-100 tx-warning lh-1 mg-t-20 d-inline-block"></i>
          <h4 class="tx-warning tx-semibold mg-b-20">Advertencia!</h4>
          <div>
            Hay Campos vacios
          </div>
        </div><!-- modal-body -->
        <div class="modal-footer d-flex">
          <button type="button" class="btn btn-primary pd-x-25 mg-l-auto" data-dismiss="modal" aria-label="Close" >Aceptar</button>
        </div>
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div>

  {{-- Scripts librerias --}}
@section('seccion-scripts-libs')
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/jquery-ui/js/jquery-ui.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/datatables/js/jquery.dataTables.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/datatables-responsive/js/dataTables.responsive.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/select2/js/select2.min.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/moment/js/moment.js"></script>
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
     <script src="https://cdn.datatables.net/colreorder/1.5.3/js/dataTables.colReorder.min.js"></script>
@endsection

{{-- Scripts --}}
@section('seccion-scripts-functions')
  <script>

    $(function(){
        //Carga de Tabla
        cargarTablaRecursos();
        
        //Tabs del modal nuevo Recurso Audiencia
        $('#nav-addRecurso').click(function(){
            $('#saveRecursoAudiencia').css('display', 'block');
            $('#updateRecursoAudiencia').css('display', 'none');
            $('#listaRecursosAudiencia').css('display', 'none');
        });
        $('#nav-editRecurso').click(function(){
            $('#updateRecursoAudiencia').css('display', 'block');
            $('#saveRecursoAudiencia').css('display', 'none');
            $('#listaRecursosAudiencia').css('display', 'block');
        });
        //Loader
        setTimeout(function(){
          $('#modal_loading').modal('hide');
        }, 1000);

    });

    //Aqui las function
    function cargarTablaRecursos(pagina_accion){
        //paginacion
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
        if(pagina<=0 || pagina>$('#paginas_totales').val()){

        }else{
            //asignacion de la paginacion
            $('#pagina_actual').val(pagina);
            $('#numeropagina').val(pagina);
            $('.pagina_actual_texto').html(pagina);
            $('.pagina_total_texto').html($('#paginas_totales').val());
            //Consulta al servicio
            $.ajax({
                type:'POST',
                url:'/public/obtener_recursos_adicionales',
                data:{
                    tipoRecurso:$("#tipoRecurso").val(),
                    registros_por_pagina:registros_por_pagina,
                    pagina:$("#pagina_actual").val(),
                },
                success:function(response) {
                    console.log(response);
                    if(response.status==100){

                        $('.pagina_total_texto').html(response.response_pag['paginas_totales']);
                        $('#paginas_totales').val(response.response_pag['paginas_totales']);

                        let color;
                        let msg;
                        let modal1="'modalNuevoRecursoAudiencia'";

                        var datos=response.response;
                        var tamanio = datos.length;
                        $('#codigoConsecutivo1').val(datos[tamanio-1]['codigo']);
                        var body = new $('#recursosTable').dataTable({
                                            processing: true,
                                            data: datos,
                                            columns:[
                                                {
                                                    "data":null, 
                                                    "render":function(data, type, row, meta){
                                                        return   `<div class="btn-group" role="group">
                                                                    <button type="button" class="btn btn-secondary boton" title="Agregar Recursos Audiencia" onclick="nuevo_recurso_audiencia(${data['id_tipo_recurso']}, '${data['tipo_recurso']}')" id="editar"><i class="fas fa-plus-circle"></i></button>
                                                                    <button type="button" class="btn btn-secondary boton" title="Editar Tipo de Recurso" onclick="Modale_editar_recurso(${data['id_tipo_recurso']},'${data['tipo_recurso']}', '${data['descripcion']}')" id="editar"><i class="fas fa-edit"></i></button>
                                                                </div>`;
                                                    }
                                                },
                                                {data: "tipo_recurso", title: "Tipo de Recurso"},
                                                {data: "descripcion", title: "Descripción"},
                                                {data: "codigo", title: "Codigo"},
                                                {data: "estatus",
                                                        "render": function ( data, type, row, meta ) {
                                                            var estatus="";
                                                            if (data==0) {
                                                              estatus='<p style="color:red;">Inactivo</p>'
                                                            } else if(data==1) {
                                                              estatus='<p style="color:green;">Activo</p>'
                                                            }
                                                            return estatus;
                                                        }
                                                }
                                            ],
                                            columnDefs: [{ orderable: false, targets: 0 }],
                                            colReorder:{fixedColumnsLeft: 1},
                                            bDestroy: true,
                                            colReset:true,
                                            paging:   false,
                                            ordering: true,
                                            info:     false,
                                            search:false,
                                            filter:false,
                                            stateSave: true,   
                                        });
                        
                    }else{
                        let  body="";
                        body = body.concat("<tr><td colspan='4'><h3>Sin datos relacionadoss</h3></td><tr>");
                        $("#body-table1").html(body);
                    }
                }
            });

        }
    }
    function nuevo_recurso() {
        $("#modalNuevoRecurso").modal("show");
        var consec = $('#codigoConsecutivo1').val();
        obtener_consecutivo(consec);
    }
    function guardar_recurso(modal1) {
        var tipoRecurso = $("#RegistroNuevoTipoRecurso").val();
        var descripcion = $("#RegistroNuevoDescripcion").val();
        if(tipoRecurso.length <= 0 || descripcion.length<=0){
            $('#modalWarning').modal('show');
        }else{
            $.ajax({
                type:'post',
                url:'/public/guardar_tipo_recursos_adicionales',
                data:{
                        tipoRecurso : $("#RegistroNuevoTipoRecurso").val(),
                        descripcion : $("#RegistroNuevoDescripcion").val(),
                        consecutivo : $('#codigoConsecutivo2').val()   
                },
                success:function(response) {
                    console.log(response);
                    var tipoRecurso=$("#RegistroNuevoTipoRecurso").val();
        
                    if(response.status==100){
                        cerrar_modal(modal1);
                        //limpiamos el campo
                        $("#RegistroNuevoTipoRecurso").val("");
                        $("#RegistroNuevoDescripcion").val("");
    
                        var exito = "<p class='mg-b-20 mg-x-20'>El Tipo de Recurso "+tipoRecurso+ " "+response.response+"</p>";
                        $('#messageExito').html(exito);
        
                        $('#modalSuccess').modal('show');
                        cargarTablaRecursos();
                    }
                    else{
                        var error = "<p class='mg-b-20 mg-x-20'>"+response.message+"</p>";
                        $('#messageError').html(error);
                        $('#modalError').modal('show');
                    }
                }
            });
        }

    }
    function Modale_editar_recurso(idTipoRecurso, TipoRecurso, descripcion){
        $('#modalEditRecurso').modal("show");
        $('#idE_TR').html(idTipoRecurso);
        $('#RecursoRegistroEditar').val(TipoRecurso);
        $('#idTipoRecurso').val(idTipoRecurso);
        $('#DescripcionRegistroEditar').val(descripcion);
    }
    function editar_recurso(modal1){
        $.ajax({
            type:'post',
            url:'/public/actualizar_tipo_recursos_adicionales',
            data:{
                    idtipoRecurso: $("#idTipoRecurso").val(),
                    tipoRecurso : $("#RecursoRegistroEditar").val(),
                    descripcion: $("#DescripcionRegistroEditar").val(),
                    estatus: $("#estatusRegistroEditar").val(),
            },
            success:function(response) {
                console.log(response);
                var tipoRecurso=$("#RegistroNuevoTipoRecurso").val();
    
                if(response.status==100){
                    cerrar_modal(modal1);
                    //limpiamos el campo
                    $("#RecursoRegistroEditar").val("");
                    $("#idTipoRecurso").val("");
                    $("#DescripcionRegistroEditar").val("");

                    var exito = "<p class='mg-b-20 mg-x-20'>El Tipo de Recurso "+tipoRecurso+ " "+response.response+"</p>";
                    $('#messageExito').html(exito);
    
                    $('#modalSuccess').modal('show');
                    cargarTablaRecursos();
                }
                else{
                    var error = "<p class='mg-b-20 mg-x-20'>"+response.message+"</p>";
                    $('#messageError').html(error);
                    $('#modalError').modal('show');
                }
            }
        });
    }
    function nuevo_recurso_audiencia(idTipoRecurso, TipoRecurso) {
        $("#modalNuevoRecursoAudiencia").modal("show");
        $('#idTR').html(TipoRecurso);
        $('#A_idTipoRecurso').val(idTipoRecurso);
        obtener_recursos_audiencia(idTipoRecurso);
    }
    function obtener_recursos_audiencia(idTipoRecurso){
        $.ajax({
            type:'POST',
            url:'/public/obtener_recursos_audiencia',
            data:{
                tipoRecurso:idTipoRecurso,
            },
            success:function(response) {
                body = '';
                console.log(response);
                if(response.status==100){
                    var datos=response.response;
                    var tamanio = datos.length;
                    obtener_consecutivo2(datos[tamanio-1]['codigo']);
                    for(i=0; i < datos.length; i++ ){
                        if(datos[i]['estatus'] != 0){
                            body += `<a class="dropdown-item" href="javascript:void(0);" onclick="asignarvalores(${idTipoRecurso}, ${datos[i]['id_recurso_audiencia']}, '${datos[i]['nombre_recurso']}', '${datos[i]['codigo_unidad']}', '${datos[i]['codigo_institucion']}', '${datos[i]['codigo']}', '${datos[i]['cve_recurso']}', '${datos[i]['adscripcion_recurso']}', ${datos[i]['estatus']})">${datos[i]['nombre_recurso']}</a>`;
                        }else{
                            body += `<a class="dropdown-item" href="javascript:void(0);" style="color:red;" onclick="asignarvalores(${idTipoRecurso}, ${datos[i]['id_recurso_audiencia']}, '${datos[i]['nombre_recurso']}', '${datos[i]['codigo_unidad']}', '${datos[i]['codigo_institucion']}', '${datos[i]['codigo']}', '${datos[i]['cve_recurso']}', '${datos[i]['adscripcion_recurso']}', ${datos[i]['estatus']})">${datos[i]['nombre_recurso']}</a>`;
                        }
                    }
                    $("#catalogo_recursos_audiencia").html(body);
                }else{
                    obtener_consecutivo2('0000/2021');
                    body = body.concat('<a class="dropdown-item" href="javascript:void(0);">No hay relaciones</a>');
                    $("#catalogo_recursos_audiencia").html(body);
                }
            }
        }); 
    }
    function asignarvalores(E_idTipoRecurso,E_idRecursoAudiencia, E_nombreRecurso,E_codigoUnidad,E_codigo_Institucion,E_codigo,E_claveRecurso,E_adscripcion,E_estatus){
        $('#E_idTipoRecurso').val(E_idTipoRecurso);
        $('#E_idRecursoAudiencia').val(E_idRecursoAudiencia);
        $('#E_nombreRecurso').val(E_nombreRecurso);
        $('#E_codigoUnidad').val(E_codigoUnidad);
        $('#E_codigo_Institucion').val(E_codigo_Institucion);
        $('#E_codigo').val(E_codigo);
        $('#E_claveRecurso').val(E_claveRecurso);
        $('#E_adscripcion').val(E_adscripcion);
        $('#E_estatus option[value='+E_estatus+']').attr("selected", true);
    }
    function cerrar_modal(valor){
        $("#"+valor).modal('hide');
        $('body').removeClass('modal-open');
        $('#E_idTipoRecurso').val('');
        $('#E_idRecursoAudiencia').val('');
        $('#E_nombreRecurso').val('');
        $('#E_codigoUnidad').val('');
        $('#E_codigo_Institucion').val('');
        $('#E_codigo').val('');
        $('#E_claveRecurso').val('');
        $('#E_adscripcion').val('');
        $('#E_estatus').val('');
    }
    function obtener_consecutivo(val){
        var dato = val.split('/');
        var longitud = dato[0].length
        var con = dato[0].substr(3,longitud);
        var consecutivo = parseInt(con, 10)+1;

        var today = new Date();
        var year = today.getFullYear();

        var nuevo_c = '000'+consecutivo+'/'+year
        $('#codigoConsecutivo2').val(nuevo_c);
    }
    function obtener_consecutivo2(val){
        var dato = val.split('/');
        var longitud = dato[0].length
        var con = dato[0].substr(3,longitud);
        var consecutivo = parseInt(con, 10)+1;

        var today = new Date();
        var year = today.getFullYear();

        var nuevo_c = '000'+consecutivo+'/'+year
        $('#A_codigo').val(nuevo_c);
    }
    function guardar_recurso_audiencia(modal1){
        var A_nombreRecurso = $("#A_nombreRecurso").val();
        var A_claveRecurso = $("#A_claveRecurso").val();
        var A_codigo = $("#A_codigo").val();

        if(A_nombreRecurso.length <= 0 || A_claveRecurso.length<=0){
            $('#modalWarning').modal('show');
        }else{
            $.ajax({
                type:'post',
                url:'/public/save_recurso_audiencia',
                data:{
                    tipoRecurso : $("#A_idTipoRecurso").val(),
                    A_nombreRecurso : $("#A_nombreRecurso").val(),
                    A_claveRecurso : $("#A_claveRecurso").val(),
                    A_codigo : $("#A_codigo").val()  
                },
                success:function(response) {
                    console.log(response);
                    var tipoRecurso=$("#A_nombreRecurso").val();
        
                    if(response.status==100){
                        cerrar_modal(modal1);
                        //limpiamos el campo
                        $("#A_nombreRecurso").val("");
                        $("#A_claveRecurso").val("");
    
                        var exito = "<p class='mg-b-20 mg-x-20'>El Tipo de Recurso "+tipoRecurso+ " "+response.response+"</p>";
                        $('#messageExito').html(exito);
        
                        $('#modalSuccess').modal('show');
                        cargarTablaRecursos();
                    }
                    else{
                        var error = "<p class='mg-b-20 mg-x-20'>"+response.message+"</p>";
                        $('#messageError').html(error);
                        $('#modalError').modal('show');
                    }
                }
            });
        }
    }
    function update_recurso_audiencia(modal1){
        var E_nombreRecurso = $("#E_nombreRecurso").val();
        var E_claveRecurso = $("#E_claveRecurso").val();

        if(E_nombreRecurso.length <= 0 || E_claveRecurso.length<=0){
            $('#modalWarning').modal('show');
        }else{
            $.ajax({
                type:'post',
                url:'/public/update_recurso_audiencia',
                data:{
                        E_idRecursoAudiencia: $("#E_idRecursoAudiencia").val(),
                        E_codigoUnidad: $("#E_codigoUnidad").val(),
                        E_codigo_Institucion: $("#E_codigo_Institucion").val(),
                        E_codigo: $("#E_codigo").val(),
                        E_idTipoRecurso: $("#E_idTipoRecurso").val(),
                        E_claveRecurso: $("#E_claveRecurso").val(),
                        E_nombreRecurso: $("#E_nombreRecurso").val(),
                        E_adscripcion: $("#E_adscripcion").val(),
                        E_estatus: $("#E_estatus").val()
                },
                success:function(response) {
                    console.log(response);
                    var tipoRecurso=$("#E_idTipoRecurso").val();
                
                    if(response.status==100){
                        cerrar_modal(modal1);
                        //limpiamos el campo
                        var exito = "<p class='mg-b-20 mg-x-20'>El Tipo de Recurso "+tipoRecurso+ " "+response.response+"</p>";
                        $('#messageExito').html(exito);
                    
                        $('#modalSuccess').modal('show');
                        cargarTablaRecursos();
                    }
                    else{
                        var error = "<p class='mg-b-20 mg-x-20'>"+response.message+"</p>";
                        $('#messageError').html(error);
                        $('#modalError').modal('show');
                    }
                }
            });
        }
    }
  </script>
@endsection



