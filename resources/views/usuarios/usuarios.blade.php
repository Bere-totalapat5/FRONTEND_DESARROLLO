@php
use App\Http\Controllers\clases\humanRelativeDate;
use App\Http\Controllers\clases\utilidades;
$humanRelativeDate = new humanRelativeDate();
@endphp

@extends('layouts.index')

@section('contenido-pageheader')
    <ol class="breadcrumb slim-breadcrumb">
        <li class="breadcrumb-item"><a href="#">Usuarios</a></li>
        <li class="breadcrumb-item"><a href="#"> Consulta de Usuarios</a></li>
    </ol>
    <h6 class="slim-pagetitle">Consulta de Usuariostl</h6>
@endsection
@section('contenido-principal')

    <div class="section-wrapper" style="max-width: 100%;">
        <div class="form-layout">
            <div id="accordion" class="accordion-one mg-b-20" role="tablist" aria-multiselectable="true">
                <div class="card">

                    <div class="card-header" role="tab" id="headingOne">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false"
                            aria-controls="collapseOne" class="tx-gray-800 transition collapsed">
                            Búsqueda Avanzada
                        </a>
                    </div><!-- card-header -->

                    <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                        <div class="card-body">
                            <div class="row mg-b-25">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="label">Tipo de usuario:</label>
                                        <select class="form-control select2-show-search valid select2-hidden-accessible"
                                            id="id_tipo_usuario">
                                            <option value="" selected>Todas</option>
                                            @foreach ($tipos_usuario as $tu)
                                                <option value="{{ $tu['id_tipo_usuario'] }}">{{ $tu['descripcion'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="label">Adscripción:</label>
                                        <select class="form-control select2-show-search valid select2-hidden-accessible"
                                            id="id_unidad_gestion">
                                            <option value="" selected>Todas</option>
                                            @foreach ($unidades as $unid)
                                                <option value="{{ $unid['id_unidad_gestion'] }}">
                                                    {{ $unid['nombre_unidad'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-control-label">Usuario:</label>
                                        <input class="form-control" style="text-align:center" type="text" id="usuario">
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-control-label">Nombre:</label>
                                        <input class="form-control" style="text-align:center" type="text"
                                            id="nombre_busqueda">
                                    </div>
                                </div>
                            </div><!-- row -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <br>
                                    <button type="button" class="btn btn-primary btn-sm btn-block mg-b-10"
                                        data-toggle="collapse" data-target="#demo"
                                        onclick="sec_ajax('primera');">Filtrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row justify-content-end">
                <input type="hidden" id="filtro_consulta" name="filtro_consulta" value="">
                @foreach ($acciones as $acc)
                    @if ($acc['id_vista_accion'] == 32 and $acc['valor'] != 0)
                        <div class="col-sm-2 pd-t-10" align="right">
                            <a href="javascript:void(0);" onclick="descargar_consulta('xls');"
                                class="btn btn-primary btn-sm btn-block "><i class="fa fa-pdf mg-r-5"></i>Exportar Excel</a>
                        </div>
                    @endif
                    @if ($acc['id_vista_accion'] == 33 and $acc['valor'] != 0)
                        <div class="col-sm-2 pd-t-10" align="right">
                            <a href="javascript:void(0);" onclick="descargar_consulta('pdf');"
                                class="btn btn-primary btn-sm btn-block "><i class="fa fa-pdf mg-r-5"></i>Exportar PDF</a>
                        </div>
                    @endif
                @endforeach
            </div>
            <br>
            <div class="pagination-wrapper justify-content-between mg-b-20">
                <ul class="pagination mg-b-0">
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0);" onclick="sec_ajax('primera');"
                            aria-label="Last">
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
                        <a class="page-link" href="javascript:void(0);" onclick="sec_ajax('avanzar');"
                            aria-label="Next">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0);" onclick="sec_ajax('ultima');"
                            aria-label="Last">
                            <i class="fa fa-angle-double-right"></i>
                        </a>
                    </li>
                </ul>
            </div>
            @foreach ($acciones as $acc)
                @if ($acc['id_vista_accion'] == 29 and $acc['valor'] != 0)
                    <div class="row justify-content-begin">
                        <div class="col-sm-1" align="center">
                            <button type="button" title="Agregar nuevo usuario" class="btn btn-primary"
                                onclick="nuevo_usuario()" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Nuevo usuario
                            </button>
                        </div>
                    </div>
                @endif
            @endforeach

            <br>
            <!-- Modal Nuevo usuario-->
            <div class="modal fade" id="modal_nuevo_usuario" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Nuevo usuario</h5>
                        </div>
                        <div class="modal-body" id="contenido_nuevo_usuario">
                            <div class="row form-layout">

                                <div class="col-lg-4">
                                    <label class="label">Género: <span class="tx-danger">*</span></label>
                                    <select class='form-control-lg select2 valid' id='m_genero'>"
                                        <option disabled selected>Seleccione..</option>
                                        <option value="Hombre">Hombre</option>
                                        <option value="Mujer">Mujer</option>
                                        <option value="Otro">Otro</option>
                                    </select>
                                </div>
                                <div class="col-lg-4">
                                    <label class="label">Adscripción: <span class="tx-danger">*</span></label>
                                    <div class="form-group">
                                        <select class="form-control select2-show-search valid select2-hidden-accessible"
                                            id="m_id_unidad_gestion">
                                            <option value="0" selected>Todas</option>
                                            @foreach ($unidades as $unid)
                                                <option value="{{ $unid['id_unidad_gestion'] }}">
                                                    {{ $unid['nombre_unidad'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label class="label">Título:</label>
                                    <select class="form-control-lg select2 valid" id="m_titulo">
                                        <option disabled selected>Seleccione...</option>
                                        <option value="Lic">Licenciado</option>
                                        <option value="Ing">Ingeniero</option>
                                        <option value="Mtro">Maestro</option>
                                        <option value="Mtra">Maestra</option>
                                        <option value="C">Ciudadano</option>
                                    </select>
                                </div>
                                <div class="col-lg-4">
                                    <label class="label">Nombres: <span class="tx-danger">*</span></label>
                                    <div class="form-group">
                                        <input type="text" style="text-align:center;" class="form-control" id="m_nombres"
                                            autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label class="label">Apellido paterno: <span
                                            class="tx-danger">*</span></label>
                                    <div class="form-group">
                                        <input type="text" style="text-align:center;" class="form-control" id="m_ap"
                                            autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label class="label">Apellido materno:</label>
                                    <div class="form-group">
                                        <input type="text" style="text-align:center;" class="form-control" id="m_am"
                                            autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label class="label">Correo: </label>
                                    <div class="form-group">
                                        <input type="text" style="text-align:center;" class="form-control" id="m_correo"
                                            autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label class="label">Contraseña: <span class="tx-danger">*</span></label>
                                    <div class="form-group">
                                        <input type="password" style="text-align:center;" class="form-control"
                                            id="m_contraseña" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label class="label">Ingrese contraseña nuevamente: <span
                                            class="tx-danger">*</span></label>
                                    <div class="form-group">
                                        <input type="password" style="text-align:center;" class="form-control"
                                            id="m_contraseña2" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label class="label">Celular:</label>
                                    <div class="form-group">
                                        <input type="number" style="text-align:center;" class="form-control" id="celular"
                                            autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label class="label">Telegram:</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="notificacion_telegram"
                                            name="notificacion_telegram">
                                        <label class="form-check-label" for="notificacion_telegram">Recibir notificaciones</label>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label class="label campos-cve_juez" style="display: none;">Clave Juez:</label>
                                    <div class="form-group campos-cve_juez" style="display: none;">
                                        <input type="text"  style="text-align:center;" class="form-control" id="cve_juez" name="cve_juez">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row form-layout">
                                        <div class="col-lg-3">
                                            <label class="label">Usuario:</label>
                                            <button class="btn btn-primary" style="align:left;" align="left" type="button"
                                                name="button" onclick="generar_usuarios()"
                                                title="Generar nombre de usuario">
                                                <i class="fas fa-angle-double-right"></i>
                                            </button>
                                        </div>
                                        <div class="col-lg-9">
                                            <input type="hidden" id="m_usuario" value="">
                                            <label class="label"><span class="tx-danger">*</span></label>
                                            <div class="border border-1" style="height: 150px;" id="usuario_opciones">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-8">
                                    <label class="label">Tipos de usuario: <span
                                            class="tx-danger">*</span></label>
                                    <div class="form-group">
                                        <select class='form-control-lg select2 valid' name="lstStates" multiple="multiple"
                                            id="lstStates" onchange="mostrar_cve_juez(this,'nuevo')">
                                            @foreach ($tipos_usuario as $tu)
                                                <option value="{{ $tu['id_tipo_usuario'] }}">{{ $tu['descripcion'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" onclick="cerrar_modal('modal_nuevo_usuario')"
                                data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" onclick="guardar_nuevo_usuario()"
                                class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal modificar usuario-->
            <div class="modal fade" id="modal_modificar_usuario" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <input type="hidden" id="oculto" value="">
                <input type="hidden" id="e_id_unidad_gestion" value="">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header" id="modal_header">
                        </div>
                        <div class="modal-body" id="contenido_modificar_usuario">
                            <div class="row form-layout">
                                <div class="col-lg-4">
                                    <label class="label">Usuario:</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" style="text-align:center;" id="e_usuario"
                                            autocomplete="off" disabled>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label class="label">Correo:<span class="tx-danger">*</span></label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" style="text-align:center;" id="e_correo"
                                            autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label class="label">Contraseña:</label>
                                    <div class="form-group">
                                        <input type="password" class="form-control" style="text-align:center;"
                                            id="e_contraseña" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label class="label">Nombres:<span class="tx-danger">*</span></label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" style="text-align:center;" id="e_nombres"
                                            autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label class="label">Apellido paterno:<span
                                            class="tx-danger">*</span></label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" style="text-align:center;" id="e_ap"
                                            autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label class="label">Apellido materno:</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" style="text-align:center;" id="e_am"
                                            autocomplete="off">
                                    </div>
                                </div>

                                <div class="col-lg-8" id="div-e_tipos_usuario">
                                    <label class="label">Tipos de usuario: <span
                                            class="tx-danger">*</span></label>
                                    <div class="form-group">
                                        <select class='form-control-lg select2 valid' name="lstStates" multiple="multiple"
                                            id="lstStates_" onchange="mostrar_cve_juez(this,'edicion')">
                                            @foreach ($tipos_usuario as $tu)
                                                <option value="{{ $tu['id_tipo_usuario'] }}">{{ $tu['descripcion'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-4" id="div-campos-e_cve_juez" style="display: none;">
                                    <label class="label">Clave Juez:</label>
                                    <div class="form-group">
                                        <input type="text"  style="text-align:center;" class="form-control" id="e_cve_juez" name="e_cve_juez">
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label class="label">Estatus:</label>
                                        <select class='form-control-lg select2 valid' id='e_estatus'>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label class="label">Estatus pass:</label>
                                        <select class='form-control-lg select2 valid' id='reset_pass'>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                onclick="cerrar_modal('modal_modificar_usuario')" data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary" onclick="guardar_cambios()">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modal_adscripcion" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <input type="hidden" id="id_usuario_oculto" value="">
                <input type="hidden" id="id_tipo_usuario_oculto" value="">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="width:400px;">
                            <h5 class="modal-title">Cambio de adscripción</h5>
                        </div>
                        <div class="modal-body">
                            <div class="col-lg-12">
                                <label class="label">Nombre:<span class="tx-danger"></span></label>
                                <div class="form-group" id="contenido_modal_adscripcion">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <label class="label">Adscripción:<span class="tx-danger"></span></label>
                                <div class="form-group" id="contenido_modal_adscripcion2">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="label">Cambiar a:</label>
                                    <select class="form-control-lg select2 valid" id="nueva_adscripcion">
                                        <option disabled selected>Seleccione...</option>
                                        @foreach ($unidades as $unid)
                                            <option value="{{ $unid['id_unidad_gestion'] }}">{{ $unid['nombre_unidad'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" onclick="cerrar_modal('modal_adscripcion')"
                                data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" onclick="guardar_adscripcion()" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>


            <div id="modalSuccess" class="modal fade" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog" role="document">
                    <div class="modal-content tx-size-sm">
                        <div class="modal-body tx-center pd-y-20 pd-x-20">
                            <i class="icon ion-ios-checkmark-outline tx-100 tx-success lh-1 mg-t-20 d-inline-block"></i>
                            <h4 class="tx-success tx-semibold mg-b-20">Hecho!</h4>
                            <p style="padding-left: 5vh; padding-right: 5vh;">Se realizó exitósamente</p>
                        </div><!-- modal-body -->
                        <div class="modal-footer d-flex">
                            <button type="button" class="btn btn-primary pd-x-25 mg-l-auto" data-dismiss="modal"
                                aria-label="Close">Aceptar</button>
                        </div>
                    </div><!-- modal-content -->
                </div><!-- modal-dialog -->
            </div>

            <div id="modalError" class="modal fade">
                <div class="modal-dialog" role="document">
                    <div class="modal-content tx-size-sm">
                        <div class="modal-body tx-center pd-y-20 pd-x-20">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <i class="icon icon ion-ios-close-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
                            <div id="messageError">
                            </div>
                            <button type="button" class="btn btn-danger pd-x-25" data-dismiss="modal"
                                aria-label="Close">Aceptar</button>
                        </div><!-- modal-body -->
                    </div><!-- modal-content -->
                </div><!-- modal-dialog -->
            </div><!-- modal -->



            <div class="mg-b-20">
                <table id="usuariosTable" class="display dataTable dtr-inline collapsed d-block"
                    style="overflow-x: auto; padding-left:0; padding-rigth:0" role="grid" aria-describedby="example_info">

                    <thead style="background-color: #EBEEF1; color: #000; text-align:center">
                        <tr>
                            <th class="th_accion">Acciones</th>
                            <th style="cursor:pointer" class="estatus" name="estatus"></th>
                            <th style="cursor:pointer" class="id_usuario" name="id_usuario">ID usuario</th>
                            <th style="cursor:pointer" class="th_usuario" name="usuario">Usuario</th>
                            <th style="cursor:pointer" class="th_nombre" name="nombre">Nombre</th>
                            <th style="cursor:pointer" class="th_unidad" name="unidad">Unidad</th>
                            <th style="cursor:pointer" class="th_tipo" name="tipo">Tipo</th>
                            <th style="cursor:pointer" class="th_correo" name="correo">Correo</th>
                            <th style="cursor:pointer" class="th_clave" name="clave">Clave</th>
                            <th style="cursor:pointer" class="th_alta" name="alta">Clave</th>
                        </tr>
                    </thead>
                    <tbody id="body-table1" style="width: 100%; text-align: center;">

                    </tbody>
                </table>
            </div>
            <div class="pagination-wrapper justify-content-between">
                <ul class="pagination mg-b-0">
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0);" onclick="sec_ajax('primera');"
                            aria-label="Last">
                            <i class="fa fa-angle-double-left"></i>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0);" onclick="sec_ajax('atras');"
                            aria-label="Next">
                            <i class="fa fa-angle-left"></i>
                        </a>
                    </li>
                </ul>
                <div id="texto_paginator">Página <span class="pagina_actual_texto">0</span> de <span
                        class="pagina_total_texto">0</span></div>
                <ul class="pagination mg-b-0">
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0);" onclick="sec_ajax('avanzar');"
                            aria-label="Next">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0);" onclick="sec_ajax('ultima');"
                            aria-label="Last">
                            <i class="fa fa-angle-double-right"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div><!-- pagination-wrapper -->

        <input type="hidden" id="pagina_actual" name="pagina_actual" value="1">
        <input type="hidden" id="paginas_totales" name="paginas_totales" value="1">
        <input type="hidden" id="numeropagina">

        <div class="pagination-wrapper justify-content-space-between col-sm-4 " style="border:0px;float:none;margin:auto;">
        </div>
    </div>
    {{-- @endif
    @endif --}}
@endsection
@section('seccion-estilos')
    <link href="{{ asset('/lib/datatables/css/jquery.dataTables.css') }}" rel="stylesheet">
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
    <style>
        .select2-container.select2-container--default.select2-container--open {
            z-index: 1050 !important;
        }

        .flex-container {
            display: flex;
            justify-content: center;
        }

        .flex-container>div {
            margin: 1px;
            padding: 1px;
            font-size: 16px;
        }

        @media screen and (max-width: 600px) {}

        table {
            width: calc(100% - 2px) !important;
            border-bottom: 1px solid #f0f2f7;
        }

        td,
        th {
            padding-left: 1px !important;
            padding-right: 3px !important;
            padding-top: 0px;
            padding-bottom: px !important;
            border-bottom: 1px solid #f0f2f7;
            max-width: 110px !important;
        }

        span.select2-container.select2-container--default.select2-container--open {
            width: "100%";
        }

        .datepicker-container {
            z-index: 1110;
        }

        .abs-center {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .iconify {
            display: inline-block;
            text-align: left;
            vertical-align: top;
        }

        .ref {
            min-width: 80px !important;
        }

        .th_accion {
            min-width: 120px !important;
        }

        .id_usuario {
            min-width: 140px !important;
        }

        .th_usuario {
            min-width: 170px !important;
        }

        .th_correo {
            min-width: 180px !important;
        }

        .th_nombre {
            min-width: 200px !important;
        }

        .th_clave {
            min-width: 160px !important;
        }

        .th_alta {
            min-width: 160px !important;
        }

        .estatus {
            min-width: 60px !important;
        }

        .th_unidad {
            min-width: 220px !important;
        }

        .th_tipo {
            min-width: 260px !important;
        }

        .hover:hover {
            background-color: #90a03c;
            color: white;
        }

        .td-title {
            background-color: #f0f2f7 !important;
            min-width: 120px !important;
            border-color: #f0f2f7 !important;
            max-height: 5px !important;
            padding: 3px 5px 3px 5px !important;
        }

        .th-title {
            column-span: 100%;
            background-color: #f0f2f7 !important;
            min-width: 130px !important;
            border-color: #f0f2f7 !important;
            max-height: 5px !important;
            padding: 3px 0px 3px 5px !important;
            align: center !important;
        }

        .slim-navbar {
            z-index: 1000 !important;
        }

        .flex-container {
            display: flex;
            justify-content: center;

        }

        .flex-container>div {
            margin: 1px;
            padding: 1px;
            font-size: 16px;
        }

        table#datosolicitud tr td:nth-child(2) {
            padding-left: 5px !important;
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

        .ul {
            list-style: none;
        }

        .depo {
            min-width: 80px !important;
        }

        table {
            width: calc(100% - 2px) !important;
        }

        table a:hover {
            font-weight: bold;
        }

        span.select2-container {
            width: "100%";
        }

        div .icon {
            background: #848F33 !important;
            padding: 2px 5px;
            border-radius: 25%;
            color: #fff;
        }

    </style>
@endsection
@section('seccion-scripts-libs')
    <script src="{{ $entorno['version_pages']['version'] }}/lib/jquery-ui/js/jquery-ui.js"></script>
    <script src="{{ $entorno['version_pages']['version'] }}/lib/datatables/js/jquery.dataTables.js"></script>
    <script src="{{ $entorno['version_pages']['version'] }}/lib/datatables-responsive/js/dataTables.responsive.js">
    </script>
    <script src="{{ $entorno['version_pages']['version'] }}/lib/select2/js/select2.min.js"></script>
    <script src="{{ $entorno['version_pages']['version'] }}/lib/moment/js/moment.js"></script>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
        integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <script src="https://cdn.datatables.net/colreorder/1.5.3/js/dataTables.colReorder.min.js"></script>
@endsection
@section('seccion-scripts-functions')
    <script>
        const ids_tipo_juez = ['93','5','15','94','14','92','35'];


        $(function() {
            'use strict';
            $('.select2').select2({
                minimumResultsForSearch: Infinity
            });

            sec_ajax();

            $('.fc-datepicker').datepicker({
                showOtherMonths: true,
                selectOtherMonths: true
            });
            $(".fc-datepicker").datepicker("option", "dd-mm-yy");

            $.datepicker.regional['es'] = {
                closeText: 'Cerrar',
                prevText: '< Ant',
                nextText: 'Sig >',
                currentText: 'Hoy',
                monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto',
                    'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
                ],
                monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov',
                    'Dic'
                ],
                dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
                dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
                weekHeader: 'Sm',
                dateFormat: 'dd/mm/yy',
                firstDay: 1,
                isRTL: false,
                showMonthAfterYear: false,
                yearSuffix: ''
            };

            $.datepicker.setDefaults($.datepicker.regional['es']);
            $(function() {
                $("#fc-datepicker").datepicker();
            });

            $('.form-layout .form-control').on('focusin', function() {
                $(this).closest('.form-group').addClass('form-group-active');
            });
            $('.form-layout .form-control').on('focusout', function() {
                $(this).closest('.form-group').removeClass('form-group-active');
            });

            setTimeout(function() {
                $('#modal_loading').modal('hide');
            }, 1000);
        });

        function valida_contraseña(valor, valor2) {
            var numeros = "0123456789";
            var letras = "abcdefghyjklmnñopqrstuvwxyz";
            var num = 0;
            var letr = 0;

            if (valor.length < 8) {
                return "La contraseña debe contar con 8 caracteres como mínimo.";
            }

            for (i = 0; i < valor.length; i++) {
                if (numeros.indexOf(valor.charAt(i), 0) != -1) {
                    num = 1;
                }
            }

            valor = valor.toLowerCase();
            for (i = 0; i < valor.length; i++) {
                if (letras.indexOf(valor.charAt(i), 0) != -1) {
                    letr = 1;
                }
            }
            if (num == 0) {
                return "La contraseña debe contar con al menos 1 número.";
            }

            if (letr == 0) {
                return "La contraseña debe tener letras.";
            }

            if (valor != valor2) {
                return "Las contraseñas no coinciden.";
            }

            return 1;

        }

        function elegir_usuario(valor) {
            $("#m_usuario").val(valor);
        }

        function generar_usuarios() {
            var m_nombres = "";
            var m_ap = "";
            var m_am = "";

            if ($('#m_nombres').val().trim().length > 0) {
                m_nombres = normalize($("#m_nombres").val());
            }
            if ($('#m_ap').val().trim().length > 0) {
                m_ap = normalize($("#m_ap").val());
            }
            if ($('#m_am').val().trim().length > 0) {
                m_am = normalize($("#m_am").val());
            }

            if ((m_nombres) && (m_ap)) {
                $.ajax({
                    type: 'post',
                    url: '/public/generar_usuarios',
                    data: {
                        nombres: m_nombres,
                        apellido_paterno: m_ap,
                        apellido_materno: m_am
                    },
                    success: function(response) {
                        if (response.status == 100) {

                            var usuarios = response.response;
                            var radios = "";

                            for (var i = 0; i < usuarios.length; i++) {
                                var radio = usuarios[i]['usuario'];

                                radios += "<div class='hover'>" +
                                    "<input type='radio' name='radio' onclick='elegir_usuario(this.value);' id='m_usuario' value='" +
                                    radio + "'> " +
                                    "<label class='form-check-label'>" + radio + "</label>" +
                                    "</div>";
                            }
                            $("#usuario_opciones").html(radios);

                        }
                    }
                });
            } else {

                radios = "<div class='form-check border border-1 hover'>" +
                    "<label class='form-check-label'>Sin resultados</label>" +
                    "</div>";

                $("#usuario_opciones").html(radios);
            }
        }

        function guardar_adscripcion() {
            var id_usuario = $("#id_usuario_oculto").val();
            var id_tipo_usuario = $("#id_tipo_usuario_oculto").val();
            var id_unidad_gestion = $("#nueva_adscripcion").val();

            $.ajax({
                type: 'post',
                url: '/public/cambio_adscripcion',
                data: {
                    id_usuario: id_usuario,
                    id_tipo_usuario: id_tipo_usuario,
                    id_unidad_gestion: id_unidad_gestion
                },
                success: function(response) {

                    if (response.status == 100) {

                        cerrar_modal('modal_adscripcion');
                        $('#modalSuccess').modal('show');
                        sec_ajax();

                    }
                    if (response.status == 0) {
                        var error = "<p class='mg-b-20 mg-x-20'>" + response.response + "</p>";
                        $('#messageError').html(error);
                        $('#modalError').modal('show');
                    }
                }
            });
        }

        function modificar_usuario(valor, valor2) {
            var id_usuario = valor;
            var selected = "";
            $("#lstStates_").val("");
            $.ajax({
                type: 'post',
                url: '/public/ver_usuario',
                data: {
                    id_usuario: id_usuario
                },
                success: function(response) {

                    if (response.status == 100) {

                        response.response.forEach(function(resp, index) {
                            selected += "<option value='" + resp.id_tipo_usuario +
                                "' selected='true'>" + resp.descripcion + "</option>";
                        });

                        $("#lstStates_").append(selected);
                        $("#lstStates_").change();


                        $("#e_usuario").val(response.response[0]["usuario"]);
                        $("#e_nombres").val(response.response[0]["nombres"]);
                        $("#e_ap").val(response.response[0]["apellido_paterno"]);
                        $("#e_am").val(response.response[0]["apellido_materno"]);
                        $("#e_correo").val(response.response[0]["correo"]);
                        $("#oculto").val(response.response[0]["id_usuario"]);
                        $("#e_id_unidad_gestion").val(response.response[0]["id_unidad_gestion"]);
                        $("#e_cve_juez").val(response.response[0]["cve_juez"]);


                        var e_estatus = "";

                        if (response.response[0]["estatus"] == 1) {
                            e_estatus = "<option value='1' selected>ACTIVO</option>" +
                                "<option value='0' >INACTIVO</option>";
                        } else {
                            e_estatus = "<option value='0' selected>INACTIVO</option>" +
                                "<option value='1' >ACTIVO</option>";
                        }
                        $("#e_estatus").html(e_estatus);



                        var reset_pass = "";

                        if (response.response[0]["estatus_reseteo_pass"] == 1) {
                            reset_pass = "<option value='1' selected>SI</option>" +
                                "<option value='0' >NO</option>";
                        } else {
                            reset_pass = "<option value='0' selected>NO</option>" +
                                "<option value='1' >SI</option>";
                        }

                        $("#reset_pass").html(reset_pass);
                        var titulo = "";
                        if ((response.response[0]["titulo"]) && response.response[0]["titulo"] != null &&
                            response.response[0]["titulo"] != "") {
                            titulo = response.response[0]["titulo"] + " .";
                        }

                        var nombre_ = titulo + response.response[0]["nombres"] +
                            " " + response.response[0]["apellido_paterno"] +
                            " " + response.response[0]["apellido_paterno"];

                        $("#id_usuario_oculto").val(response.response[0]["id_usuario"]);
                        $("#id_tipo_usuario_oculto").val(response.response[0]["id_tipo_usuario"]);

                        var cma = "<strong>" + nombre_ + "</strong>";
                        $("#contenido_modal_adscripcion").html(cma);

                        var cma2 = "<strong>" + response.response[0]["nombre_unidad"] + "</strong>";
                        $("#contenido_modal_adscripcion2").html(cma2);


                        var modal_header = "<h5 class='modal-title'>Modificar datos de " + nombre_ + "</h5>";
                        $("#modal_header").html(modal_header);

                        $("#" + valor2).modal("show");

                    }
                }
            });
        }

        function nuevo_usuario() {

            $("#lstStates").val('').trigger("change");

            @foreach ($tipos_usuario as $tu)
                $("#m{{ $tu['id_tipo_usuario'] }}").prop('checked', false);
            @endforeach

            $("#modal_nuevo_usuario").modal("show");

            $("#m_nombres").val("");
            $("#m_ap").val("");
            $("#m_am").val("");
            $("#m_correo").val("");
            $("#m_contraseña").val("");
            $("#m_contraseña2").val("");
            $("#m_usuario").val("");
            $("#usuario_opciones").html("");
            $("#cve_juez").val("");
        }

        function nuevo_tipo_usuario() {
            $("#modal_nuevo_tipo_usuario").modal("show");
        }

        function cerrar_modal(valor) {
            $("#" + valor).modal('hide');
            $('body').removeClass('modal-open');

        }

        function guardar_cambios() {

            var str = $("#lstStates_").val();

            var password = $("#e_contraseña").val();
            var nombres = $("#e_nombres").val();
            var apellido_paterno = $("#e_ap").val();
            var apellido_materno = $("#e_am").val();
            var correo = $("#e_correo").val();
            var id_usuario = $("#oculto").val();
            var e_estatus = $("#e_estatus").val();
            var e_id_unidad_gestion = $("#e_id_unidad_gestion").val();
            var reset_pass = $("#reset_pass").val();
            var cve_juez = $("#e_cve_juez").val();

            if ((str) && (apellido_paterno) && (nombres) && (e_id_unidad_gestion)) {

                $.ajax({
                    type: 'post',
                    url: '/public/guardar_cambios',
                    data: {
                        id_usuario: id_usuario,
                        id_tipo_usuario: str,
                        password: password,
                        nombres: nombres,
                        apellido_paterno: apellido_paterno,
                        apellido_materno: apellido_materno,
                        correo: correo,
                        estatus: e_estatus,
                        id_unidad_gestion: e_id_unidad_gestion,
                        reset_pass: reset_pass,
                        cve_juez: cve_juez
                    },
                    success: function(response) {

                        if (response.status == 100) {
                            cerrar_modal('modal_modificar_usuario');
                            $('#modalSuccess').modal('show');
                            sec_ajax();
                        }
                        if (response.status == 0) {
                            var error = "<p class='mg-b-20 mg-x-20'>" + response.message + "</p>";
                            $('#messageError').html(error);
                            $('#modalError').modal('show');
                        }

                    }
                });
            } else {
                $('#messageError').html("Llene los campos obligatorios.");
                $('#modalError').modal('show');
            }

        }

        function guardar_nuevo_usuario() {
            var str = $("#lstStates").val();
            var contraseña = $("#m_contraseña").val();
            var contraseña2 = $("#m_contraseña2").val();
            var notificacion_telegram = 0

            if ($("#notificacion_telegram").is(':checked')) {
                notificacion_telegram = 1;
            }

            contraseña = valida_contraseña(contraseña, contraseña2);

            var m_genero = $("#m_genero").val();
            var usuario = $("#m_usuario").val();
            var password = $("#m_contraseña").val();
            var nombres = $("#m_nombres").val();
            var apellido_paterno = $("#m_ap").val();
            var apellido_materno = $("#m_am").val();
            var id_unidad_gestion = $("#m_id_unidad_gestion").val();
            var correo = $("#m_correo").val();
            var titulo = $("#m_titulo").val();
            var cve_juez = $("#cve_juez").val();

            if ((str) && (usuario) && (password) && (nombres) && (apellido_paterno) && (id_unidad_gestion)) {

                if (contraseña != 1) {
                    $('#messageError').html(contraseña);
                    $('#modalError').modal('show');
                } else {

                    $.ajax({
                        type: 'post',
                        url: '/public/guardar_usuario',
                        data: {
                            id_tipo_usuario: str,
                            id_unidad_gestion: id_unidad_gestion,
                            usuario: usuario,
                            password: password,
                            nombres: nombres,
                            apellido_paterno: apellido_paterno,
                            apellido_materno: $("#m_am").val(),
                            correo: correo,
                            m_genero: m_genero,
                            titulo: $("#m_titulo").val(),
                            celular: $("#celular").val(),
                            notificacion_telegram: notificacion_telegram,
                            sistema_origen: 'penal',
                            cve_juez: cve_juez
                        },

                        success: function(response) {
                            if (response.status == 100) {

                                cerrar_modal('modal_nuevo_usuario');
                                $("#m_genero").val("");
                                $("#m_id_unidad_gestion").val("0").trigger('change');
                                $("#m_usuario").val("");
                                $("#m_contraseña").val("");
                                $("#m_nombres").val("");
                                $("#m_ap").val("");
                                $("#m_am").val("");
                                $("#m_correo").val("");
                                $("#m_titulo").val("");
                                $("#lstStates").val("");
                                $("#celular").val("");
                                $("#notificacion_telegram").prop('checked', false);
                                $('#modalSuccess').modal('show');
                                sec_ajax();
                            } else {
                                var error = "<p class='mg-b-20 mg-x-20'>" + response.message + "</p>";
                                $('#messageError').html(error);
                                $('#modalError').modal('show');
                            }
                        }
                    });
                }
            } else {
                $('#messageError').html("Llene los campos obligatorios.");
                $('#modalError').modal('show');
            }
        }

        function ver_permisos(valor) {
            window.location = "/menu_permisos/{" + valor + "}"
        }

        function sec_ajax(pagina_accion) {
            $(document).ready(function() {
                $(".nav-tabs a").click(function() {
                    $(this).tab('show');
                });
            });
            let body = "";
            pagina = parseInt($('#pagina_actual').val());
            registros_por_pagina = 10;

            if (pagina_accion == "primera") {
                pagina = 1;
            } else if (pagina_accion == "avanzar") {
                pagina = pagina + 1;
            } else if (pagina_accion == "atras") {
                pagina = pagina - 1;
            } else if (pagina_accion == "ultima") {
                pagina = $('#paginas_totales').val();
            }
            if (pagina <= 0 || pagina > $('#paginas_totales').val()) {} else {
                $('#pagina_actual').val(pagina);
                $('#numeropagina').val(pagina);
                $('.pagina_actual_texto').html(pagina);
                $("#filtro_consulta").val(
                    JSON.stringify({
                        id_tipo_usuario: $("#id_tipo_usuario").val(),
                        id_unidad_gestion: $("#id_unidad_gestion").val(),
                        usuario: $("#usuario").val(),
                        nombre_busqueda: $("#nombre_busqueda").val(),
                        pagina: 1,
                        registros_por_pagina: 1000000
                    })
                );
                $.ajax({
                    type: 'GET',
                    url: '/public/consulta_usuarios_filtros',
                    data: {
                        id_tipo_usuario: $("#id_tipo_usuario").val(),
                        id_unidad_gestion: $("#id_unidad_gestion").val(),
                        usuario: $("#usuario").val(),
                        nombre_busqueda: $("#nombre_busqueda").val(),
                        pagina: $('#numeropagina').val(),
                        registros_por_pagina: 10,
                    },

                    success: function(response) {
                        if (response.status == 100) {

                            let color;
                            let msg;
                            let modal1 = "'modal_modificar_usuario'";
                            let modal2 = "'modal_adscripcion'";
                            let prmiso = "menu_permisos";

                            var datos = response.response;
                            var body = new $('#usuariosTable').dataTable({
                                processing: true,
                                data: datos,
                                columns: [{
                                        "data": "id_usuario",
                                        "render": function(data, type, row, meta) {

                                            return '<div class="icono"><i class="fas fa-pen" title="Modificar" onclick="modificar_usuario(' +
                                                data + ',' + modal1 +
                                                ')" style="cursor: pointer" id="editar"></i></div> ' +
                                                '<div class="icono"><i class="fas fa-user-check" title="Permisos" aria-hidden="true" style="cursor: pointer" onclick=window.location.href="menu_permisos/' +
                                                data + '" id="permisos"></i></div> ' +
                                                '<div class="icono"><i class="fas fa-landmark" title="Cambio de Adscripcion" style="cursor: pointer" onclick="modificar_usuario(' +
                                                data + ',' + modal2 +
                                                ')" id="adscripcion"></i></div> '
                                        }
                                    },
                                    {
                                        data: "estatus",
                                        render: function(data, type, row, meta) {
                                            if (data == 1) {
                                                color = "green";
                                                title = "ACTIVO";
                                            } else {
                                                color = "grey";
                                                title = "INACTIVO";
                                            }
                                            return '<i class="fas fa-user-circle fa-lg" style="color:' +
                                                color + '" title="' + title + '" ></i>';
                                        },
                                    },
                                    {
                                        data: "id_usuario",
                                        title: "ID Usuario"
                                    },
                                    {
                                        data: "usuario",
                                        title: "Usuario"
                                    },
                                    {
                                        data: "nombres",
                                        title: "Nombre"
                                    },
                                    {
                                        data: "nombre_unidad",
                                        title: "Adscripción"
                                    },
                                    {
                                        data: "descripcion",
                                        title: "Tipo"
                                    },
                                    {
                                        data: "correo",
                                        title: "Correo"
                                    },
                                    {
                                        data: "cve_juez",
                                        title: "Clave"
                                    },
                                    {
                                        data: "creacion",
                                        title: "Fecha de alta"
                                    },

                                ],
                                columnDefs: [{
                                    orderable: false,
                                    targets: 0
                                }],
                                colReorder: {
                                    fixedColumnsLeft: 1
                                },
                                bDestroy: true,
                                colReset: true,
                                paging: false,
                                ordering: true,
                                info: false,
                                search: false,
                                filter: false,
                                stateSave: true,
                            });

                            $('.pagina_total_texto').html(response.response_pag['paginas_totales']);
                            $('#paginas_totales').val(response.response_pag['paginas_totales'])
                        } else {
                            body = "<tr>" +
                                "<td colspan='5'>" +
                                "<td colspan='7'>" +
                                "<h3>Sin datos relacionados</h3>" +
                                "</td>" +
                                "<tr>";

                            $('#body-table1').html(body);
                        }
                    }
                });
            }

        }

        function descargar_consulta(extension) {

            let orden_columnas = get_orden_columnas();

            $('#modal_loading').modal('show');

            $.ajax({
                type: 'GET',
                url: '/exportar_busqueda_usuarios',
                data: {
                    id_tipo_usuario: $("#id_tipo_usuario").val(),
                    id_unidad_gestion: $("#id_unidad_gestion").val(),
                    usuario: $("#usuario").val(),
                    pagina: 1,
                    registros_por_pagina: 10000000,
                    extension: extension,
                    orden_columnas: orden_columnas,
                },
                success: function(data) {
                    if (data.status == 100) {
                        let tag_a = $("<a>");
                        tag_a.attr("href", data.file);
                        $("body").append(tag_a);
                        tag_a.attr("download", data.filename);
                        tag_a[0].click();
                        tag_a.remove();
                    } else {
                        alert(data.message);
                    }

                    setTimeout(function() {
                        $('#modal_loading').modal('hide');
                    }, 500);
                }
            });
        }

        function get_orden_columnas() {
            let campos_title = [{
                    campo: "id_usuario",
                    titulo: "ID Usuario"
                },
                {
                    campo: "usuario",
                    titulo: "Usuario"
                },
                {
                    campo: "nombres",
                    titulo: "Nombre"
                },
                {
                    campo: "nombre_unidad",
                    titulo: "Adscripción"
                },
                {
                    campo: "descripcion",
                    titulo: "Tipo"
                },
                {
                    campo: "correo",
                    titulo: "Correo"
                },
                {
                    campo: "cve_juez",
                    titulo: "Clave"
                },
                {
                    campo: "creacion",
                    titulo: "Fecha de alta"
                },
            ];
            let columnas = [];
            $('#usuariosTable thead tr th').each(function() {
                let columna = campos_title.filter(index => index.titulo == $(this).text());
                if (columna.length) {
                    columnas.push({
                        titulo: columna[0].titulo,
                        campo: columna[0].campo
                    });
                }
            });
            return columnas;
        }

        function mostrar_cve_juez( tag_select , modo = 'nuevo' ){
            let tipos_usuarios = $(tag_select).val();
            let filtrado = tipos_usuarios.filter( function(x){ if( ids_tipo_juez.includes(x) ) return x; } );

            if( filtrado.length > 0 ){
                if( modo == 'nuevo' ) $(".campos-cve_juez").show();
                else if( modo == 'edicion' ){
                    $("#div-e_tipos_usuario").removeClass('col-lg-8').addClass('col-lg-4')
                    $("#div-campos-e_cve_juez").show();
                }
            }else{
                if( modo == 'nuevo' ){
                    $("#cve_juez").val("");
                    $(".campos-cve_juez").hide();
                }else if( modo == 'edicion' ){
                    $("#div-e_tipos_usuario").removeClass('col-lg-4').addClass('col-lg-8')
                    $("#e_cve_juez").val("");
                    $("#div-campos-e_cve_juez").hide();
                }
            }
        }

        $(function() {
            //$('#lstStates').materialSelect();
            /*$('#lstStates').multiselect({
                buttonText: function(options, select) {
                    if (options.length === 0) {
                        return 'Sin Seleccion';
                    }
                    if (options.length === select[0].length) {
                        return 'Todos (' + select[0].length + ')';
                    } else if (options.length >= 4) {
                        return options.length + ' Seleccionados';
                    } else {
                        var labels = [];
                        options.each(function() {
                            labels.push($(this).val());
                        });
                        return labels.join(', ') + '';
                    }
                },
                afterSelect: function(values){
                    alert("nuevos");
                    if( ids_tipo_juez.includes($values) ){
                        $("#div-cve_juez").show();
                    }
                },
                afterDeselect: function(values){
                    alert("nuevox");
                    if( ids_tipo_juez.includes($values) ){
                        $("#cve_juez").val("");
                        $("#div-cve_juez").hide();
                    }
                }
            });*/
        });

    </script>
@endsection
