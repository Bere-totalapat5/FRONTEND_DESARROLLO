@php
    use App\Http\Controllers\clases\humanRelativeDate;
    use App\Http\Controllers\clases\utilidades;
    $humanRelativeDate = new humanRelativeDate();

    $fecha_hoy = date('d/m/Y');
@endphp

@extends('layouts.index')

@section('contenido-pageheader')
    <ol class="breadcrumb slim-breadcrumb">
        <li class="breadcrumb-item"><a href="#">Audiencias</a></li>
        <li class="breadcrumb-item"><a href="#"> Consulta de Audiencias</a></li>
    </ol>
    <h6 class="slim-pagetitle"> Consulta de Audiencias</h6>
@endsection

@section('contenido-principal')

    <div class="section-wrapper" style="max-width: 100%;">
        <div class="form-layout">

            <div class="d-flex justify-content-between" style="align-items: center;">
                <a style="border:1px solid #ccc; width: 70px; height: 45px;" data-toggle="collapse" data-parent="#accordion"
                    href="#collapseSearchAdvance" aria-expanded="false" aria-controls="collapseSearchAdvance"
                    class="btn btn-default">
                    <i class="fa fa-search" aria-hidden="true"></i>
                    <i class="fas fa-chevron-down" style="margin-left: 5%; font-size:0.7em;"></i>
                </a>
                <div class="row justify-content-end" style="width:80%;">
                    <input type="hidden" id="filtro_consulta" name="filtro_consulta" value="">
                    {{-- 
                    <div class="col-sm-4 col-md-3 col-lg-2 pd-t-10" aling="right">
                        <a href="javascript:void(0);" onclick="streaming_live('123456789', '77','7');"
                            class="btn btn-primary btn-sm btn-block "><i class="fa fa-pdf mg-r-5"></i>Streaming</a>
                    </div>   --}}
                    @if( isset($permisos[76]) and $permisos[76] == 1 ) 
                        <div class="col-sm-4 col-md-3 col-lg-2 pd-t-10" aling="right">
                            <a href="javascript:void(0);" onclick="descargar_consulta();" class="btn btn-primary btn-sm btn-block "><i class="fa fa-pdf mg-r-5"></i>Exportar Excel</a>
                        </div>
                    @endif

                    {{--  <div class="col-sm-4 col-md-3 col-lg-2 pd-t-10" aling="right">
                        <a href="javascript:void(0);" onclick="descargar_consulta('pdf');"
                            class="btn btn-primary btn-sm btn-block "><i class="fa fa-pdf mg-r-5"></i>Exportar PDF</a>
                    </div>  --}}
                </div>
            </div>

            <div id="accordion" class="accordion-one mg-b-20" role="tablist" aria-multiselectable="true">
                <div class="card">
                    <div id="collapseSearchAdvance" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                        <div class="card-body">
                            <div id="filtrosAudiencia">
                                <form class="row mg-b-25" autocomplete="nope">

                                    @if($request->session()->get('id_tipo_usuario') == 1 || $request->session()->get('id_tipo_usuario') == 20 || $request->session()->get('id_tipo_usuario') == 18 || $request->session()->get('usuario_id') == 1640618039106 )
                                        <div class="col-lg-3">
                                            <label class="form-control-label">Inmueble:</label>
                                            <div class="form-group">
                                                <select class="form-control-lg select2 valid" width='100%' autocomplete="off" name="idInmueble_c" id="idInmueble_c">
                                                    <option selected value="">Seleccionar</option>
                                                    @foreach ($inmuebles as $inmueble)
                                                        <option value="{{$inmueble['id_inmueble']}}">{{$inmueble['nombre_inmueble']}}</option>                       
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif

                                    @if($request->session()->get('id_tipo_usuario') == 1 || $request->session()->get('id_tipo_usuario') == 20 || $request->session()->get('id_tipo_usuario') == 18 || $request->session()->get('usuario_id') == 1640618039106 )
                                        <div class="col-lg-3">
                                            <label class="form-control-label">Unidad de Gestion:</label>
                                            <div class="form-group">
                                                <select class="form-control-lg select2 valid" width='100%' autocomplete="off" name="idunidad" id="idunidad">
                                                    <option selected value="">Seleccionar</option>
                                                </select>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="label">Fecha Inicio: </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                                    </div>
                                                </div>
                                                <input type="text" class="form-control " placeholder="DD-MM-AAAA"  id="fechaini" name="" autocomplete="off" value="{{$fecha_hoy}}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="label">Fecha Fin: </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                                    </div>
                                                </div>
                                                <input type="text" class="form-control " placeholder="DD-MM-AAAA"  id="fechafin" name="" autocomplete="off" value="{{$fecha_hoy}}">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="label">Carpeta Judicial: </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="far fa-folder tx-16 lh-0 op-6"></i>
                                                    </div>
                                                </div>
                                                <input type="text" class="form-control" placeholder="Carpeta Judicial" id="searchCarpetaJudical" name="searchCarpetaJudical" autocomplete="off"> 
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="label">Id Evento: </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="fas fa-info-circle tx-16 lh-0 op-6"></i>
                                                    </div>
                                                </div>
                                                <input type="text" class="form-control" placeholder="Id Evento" id="searchIdEvento" name="searchIdEvento" autocomplete="off"> 
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="label">Tipo de Juez: </label>
                                            <select class="form-control " name="tipo_juezSearch" id="tipo_juezSearch">
                                                <option value="-" selected >Seleccionar</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="label">Juez: </label>
                                            <select class="form-control " name="juezSearch" id="juezSearch">
                                                <option value="-" selected >Seleccionar</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <label class="form-control-label">Tipo Audiencia:</label>
                                        <div class="form-group">
                                            <select class="form-control-lg select2 valid" width='100%' autocomplete="off" name="tipo_audiencia" id="tipo_audiencia">
                                                <option selected value="">Todas</option>
                                                @foreach ($tipos_audiencia as $tipo)
                                                    <option value="{{$tipo['id_ta']}}">{{$tipo['tipo_audiencia']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <label class="form-control-label">Sala:</label>
                                        <div class="form-group">
                                            <select class="form-control-lg select2 valid" width='100%' autocomplete="off" name="sala_c" id="sala_c">
                                                <option selected value="">Seleccionar</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <label class="form-control-label">Situacion:</label>
                                        <div class="form-group">
                                            <select class="form-control-lg select2 valid" width='100%' autocomplete="off" name="situacion_c" id="situacion_c">
                                                <option selected value="">Seleccionar</option>
                                                <option value="Confirmada">Confirmada</option>
                                                <option value="Finalizada">Finalizada</option>
                                                <option value="Cancelado">Cancelada</option>
                                                <option value="En desarrollo">En desarrollo</option>
                                                <option value="REGISTRADA">Registrada</option>
                                                <option value="Resuelta por acuerdo">Resuelta por acuerdo</option>
                                            </select>
                                        </div>
                                    </div>

                                </form>
                            </div><!-- row -->
                            <div class="row">
                                <div class="col-lg-10">
                                    <button type="button" class="btn btn-primary btn-sm btn-block mg-b-10" data-toggle="collapse" data-target="#demo" id="filtrarBtn" onclick="sec_ajax('primera');">Filtrar</button>
                                </div>
                                <div class="col-lg-2">
                                    <button type="button" title="Limpiar Filtros" class="btn btn-primary btn-sm btn-block mg-b-10" onclick="limpiarFiltros();"><i class="fas fa-refresh"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- pagination-wrapper -->
            <div class="pagination-wrapper justify-content-between mg-b-20">
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
            </div><!-- pagination-wrapper -->

            <div style="border: 1px solid #eee; width: 210px; height: 30px; display: flex; justify-content: center; align-items: center; padding: 0;">
                <div class="selectby">
                    <span class="orderby"><i class="fas fa-chevron-down" style="margin: 0 5%;font-size: 0.8em;"></i>Ordenar por </span>
                    <ul class="menu_orderby">
                        <li>
                            <label>
                                <div>
                                    <input class="che_orden" type="checkbox" value="id_audiencia" orden="ASC">
                                    <select onchange="cambiarDireccion(this)">
                                        <option value="ASC">ASC</option>
                                        <option value="DESC">DESC</option>
                                    </select>
                                </div>
                                Id Evento 
                            </label>
                        </li>
                        <li>
                            <label>
                                <div>
                                    <input class="che_orden" type="checkbox" value="estatus_semaforo" orden="ASC">
                                    <select onchange="cambiarDireccion(this)">
                                        <option value="ASC">ASC</option>
                                        <option value="DESC">DESC</option>
                                    </select>
                                </div>
                                Situacion Audiencia 
                            </label>
                        </li>
                        <li>
                            <label>
                                <div>
                                    <input class="che_orden" type="checkbox" value="folio_carpeta" orden="ASC">
                                    <select onchange="cambiarDireccion(this)">
                                        <option value="ASC">ASC</option>
                                        <option value="DESC">DESC</option>
                                    </select>
                                </div>
                                Carpeta Judicial 
                            </label>
                        </li>
                        <li>
                            <label>
                                <div>
                                    <input class="che_orden" type="checkbox" value="fecha_audiencia" orden="ASC">
                                    <select onchange="cambiarDireccion(this)">
                                        <option value="ASC">ASC</option>
                                        <option value="DESC">DESC</option>
                                    </select>
                                </div>
                                Fecha Audiencia 
                            </label>
                        </li>
                        <li>
                            <label>
                                <div>
                                    <input class="che_orden" type="checkbox" value="hora_inicio_audiencia" orden="ASC">
                                    <select onchange="cambiarDireccion(this)">
                                        <option value="ASC">ASC</option>
                                        <option value="DESC">DESC</option>
                                    </select>
                                </div>
                                Hora Programada 
                            </label>
                        </li>
                        <li>
                            <label>
                                <div>
                                    <input class="che_orden" type="checkbox" value="id_unidad_registro" orden="ASC">
                                    <select onchange="cambiarDireccion(this)">
                                        <option value="ASC">ASC</option>
                                        <option value="DESC">DESC</option>
                                    </select>
                                </div>
                                Unidad de Gestion 
                            </label>
                        </li>
                        <li>
                            <label>
                                <div>
                                    <input class="che_orden" type="checkbox" value="tipo_audiencia" orden="ASC">
                                    <select onchange="cambiarDireccion(this)">
                                        <option value="ASC">ASC</option>
                                        <option value="DESC">DESC</option>
                                    </select>
                                </div>
                                Tipo de Audiencia 
                            </label>
                        </li>
                        <li>
                            <label>
                                <div>
                                    <input class="che_orden" type="checkbox" value="id_inmueble" orden="ASC">
                                    <select onchange="cambiarDireccion(this)">
                                        <option value="ASC">ASC</option>
                                        <option value="DESC">DESC</option>
                                    </select>
                                </div>
                                Edificio 
                            </label>
                        </li>
                        <li>
                            <label>
                                <div>
                                    <input class="che_orden" type="checkbox" value="id_sala" orden="ASC">
                                    <select onchange="cambiarDireccion(this)">
                                        <option value="ASC">ASC</option>
                                        <option value="DESC">DESC</option>
                                    </select>
                                </div>
                                Sala 
                            </label>
                        </li>
                        <li>
                            <label>
                                <div>
                                    <input class="che_orden" type="checkbox" value="id_juez" orden="ASC">
                                    <select onchange="cambiarDireccion(this)">
                                        <option value="ASC">ASC</option>
                                        <option value="DESC">DESC</option>
                                    </select>
                                </div>
                                Juez 
                            </label>
                        </li>
                        <li><button onclick="aplicarOrden()" style="width: 97%; border: none; background: #848f33; color: #fff;">Aplicar</button></li>
                    </ul>
                </div>
                <div style="width: 20px; height: 100%; text-align: center; display: flex; justify-content: center; align-items: center; cursor: pointer;" title="Limpiar filtro de orden" onclick="borrarOrden()">
                    <i class="fas fa-trash-alt" style="color:#900;"></i>
                </div>
            </div>

            <!--TABLA RESULTADOS BUSQUEDA -->
            <div id="table-audiencias" class="mg-b-20">
                <table id="audienciasTable" class="display dataTable dtr-inline collapsed d-block"
                    style="overflow-x: auto; padding-left:0; padding-rigth:0" role="grid" aria-describedby="example_info">
                    <thead style="background-color: #EBEEF1; color: #000; text-align:center">
                        <tr id="encabezados_audiencias_table">
                            <th style="font-size: 0.84em;" class="acciones" name="acciones">Acciones</th>
                            <th style="font-size: 0.84em;" class="acciones_notificacion" name="acciones_notificacion">Notificación Majo</th>
                            @if( isset($permisos[75]) and $permisos[75] == 1 )
                                <th style="cursor:pointer; font-size: 0.84em;" class="streaming_sala" name="streaming_sala">Streaming</th>
                            @endif
                            <th style="cursor:pointer; font-size: 0.84em;" class="id_evento" name="id_evento" orden="2" campo="id_audiencia" onclick="ordenarPor(this,1)">ID Evento <i class="fas fa-sort-amount-up" style="margin-left: 5%;"></i></th>
                            <th style="cursor:pointer; font-size: 0.84em;" class="situacion_audiencia" name="situacion_audiencia" orden="2" campo="estatus_semaforo" onclick="ordenarPor(this,1)">Situación Audiencia <i class="fas fa-sort-amount-up" style="margin-left: 5%;"></i></th>
                            <th style="cursor:pointer; font-size: 0.84em;" class="carpeta_judicial" name="carpeta_judicial" orden="2" campo="folio_carpeta" onclick="ordenarPor(this,1)">Carpeta Judicial <i class="fas fa-sort-amount-up" style="margin-left: 5%;"></i></th>
                            <th style="cursor:pointer; font-size: 0.84em;" class="fecha_audiencia"  id="submenu_orden_fecha">
                                Fecha de la Audiencia 
                                <i class="fas fa-chevron-down" style="margin-left: 5%;"></i> 
                                <div class="d-none submenu_context" id="submenu_context_fecha">
                                    <ul>
                                        <li name="fecha_audiencia" orden="2" campo="fecha_audiencia" onclick="ordenarPor(this,2)">Fecha Audiencia <i class="fas fa-sort-amount-up" style="margin-left: 12%;"></i></li>
                                        <li name="hora_programada" orden="2" campo="hora_inicio_audiencia" onclick="ordenarPor(this,2)">Hora Programada <i class="fas fa-sort-amount-up" style="margin-left: 8%;"></i></li>
                                    </ul>
                                </div> 
                            </th>
                            <th style="cursor:pointer; font-size: 0.84em;" class="notificacion_cabina" name="unidad_gestion" orden="2" campo="id_unidad_registro" onclick="ordenarPor(this,1)">Unidad de Gestión <i class="fas fa-sort-amount-up" style="margin-left: 5%;"></i></th>
                            <th style="cursor:pointer; font-size: 0.84em;" class="tipo_audiencia" name="tipo_audiencia" orden="2" campo="tipo_audiencia" onclick="ordenarPor(this,1)">Tipo de Audiencia <i class="fas fa-sort-amount-up" style="margin-left: 5%;"></i></th>
                            <th style="cursor:pointer; font-size: 0.84em;" class="edificio" name="Edificio" orden="2" campo="id_inmueble" onclick="ordenarPor(this,1)">Edificio <i class="fas fa-sort-amount-up" style="margin-left: 5%;"></i></th>
                            <th style="cursor:pointer; font-size: 0.84em;" class="sala" name="Sala" orden="2" campo="id_sala" onclick="ordenarPor(this,1)">Sala <i class="fas fa-sort-amount-up" style="margin-left: 5%;"></i></th>
                            <th style="cursor:pointer; font-size: 0.84em;" class="con_recursos_adicionales" name="con_recursos_adicionales">Con recursos adicionales</th>
                            <th style="cursor:pointer; font-size: 0.84em;" class="recursos_adicionales" name="recursos_adicionales">Recursos adicionales</th>
                            <th style="cursor:pointer; font-size: 0.84em;" class="juez" name="juez" orden="2" campo="id_juez" onclick="ordenarPor(this,1)">Juez <i class="fas fa-sort-amount-up" style="margin-left: 5%;"></i></th>
                            <th style="cursor:pointer; font-size: 0.84em; min-width: 180px;" name="Edificio">Centro de Justicia PROMUJER</th>
                            <th style="cursor:pointer; font-size: 0.84em;" class="total_imputados" name="total_imputados">Total Imputados</th>
                            <th style="cursor:pointer; font-size: 0.84em;" class="imputados" name="imputados">Imputados</th>
                            <th style="cursor:pointer; font-size: 0.84em;" class="victimas" name="victimas">Victimas</th>
                            <th style="cursor:pointer; font-size: 0.84em;" class="delitos" name="delitos">Delitos</th>
                        </tr>
                    </thead>
                    <tbody id="body-table1" class="items-agregados" style="width: 100%; text-align: center;">
                    </tbody>
                </table>
            </div>

            <!-- pagination-wrapper -->
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
            </div><!-- pagination-wrapper -->

        </div>

        <input type="hidden" id="pagina_actual" name="pagina_actual" value="1">
        <input type="hidden" id="paginas_totales" name="paginas_totales" value="1">
        <input type="hidden" id="numeropagina">

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
        .selectby{
            width: calc(100% - 20px);
            position: relative;
            height: 100%;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        .selectby:hover{
            background: #eee;
            overflow: visible;
        }
        .orderby{
            font-size: 0.9em; 
            cursor: pointer;
            width: 100%;
            text-align: center;
        }
        .menu_orderby{
            position: absolute;
            margin: 0;
            padding: 4px;
            top: 27px;
            background: #fff;
            border: 1px solid #eee;
            z-index: 1;
            width: 210px;
            list-style: none;
            left: 0;
            font-size: 0.85em;
            height: 250px;
            overflow: auto;
        }

        .menu_orderby::-webkit-scrollbar {
            width: 8px;
            height: 8px;     
        }

        .menu_orderby::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 4px;
        }

        .menu_orderby::-webkit-scrollbar-thumb:hover {
            background: #b3b3b3;
            box-shadow: 0 0 2px 1px rgba(0, 0, 0, 0.2);
        }

        .menu_orderby::-webkit-scrollbar-thumb:active {
            background-color: #999999;
        }

        .menu_orderby::-webkit-scrollbar-track {
            background: #e1e1e1;
            border-radius: 4px;
        }
      
        .menu_orderby::-webkit-scrollbar-track:hover,
        .menu_orderby::-webkit-scrollbar-track:active {
          background: #d4d4d4;
        }  

        .menu_orderby li{
            padding: 4px;
            cursor: pointer;
        }
        .menu_orderby li label{
            height: 100%;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .menu_orderby li label div select{
            border: 1px solid #ccc;
            font-size: 0.9em;
        }
        .menu_orderby li label div select:focus{
            outline: none;
        }
        .menu_orderby li:hover{
            background: #eee;
        }
        .submenu_context{
            position: absolute;
            box-shadow: 3px 8px 14px -8px #ccc;
            width: 150px;
            padding: 4px;
            border-radius: 8px;
            background: #fff;
            z-index: 1;
            top: 70%;
        }
        .submenu_context > ul{
            list-style: none;
            margin: 0;
            width: 100%;
            text-align: left;
            padding: 4px;
        }
        .submenu_context > ul li{
            margin: 2% 0;
        }

        #botones_descarga{
            display: none;
        }
        @media(max-width: 600px){ 
            #lista_docs{
                display: none;
            }
            #visorPDFacuse{
                display: none;
            }
            #botones_descarga{
                display: block;
            }
        }

        .modal-dialog-xxl{
            min-width: 80% !important;
            max-width: 80% !important;
        }
        .ui-datepicker-year{
            border: none;
            color: #5B93D3;
            font-weight: 500;
        }
        .ui-datepicker-year:focus{
          outline: none;
        }
        #audienciasTable::-webkit-scrollbar {
            width: 8px;
            height: 8px;     
        }

        #audienciasTable::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 4px;
        }

        #audienciasTable::-webkit-scrollbar-thumb:hover {
            background: #b3b3b3;
            box-shadow: 0 0 2px 1px rgba(0, 0, 0, 0.2);
        }

        #audienciasTable::-webkit-scrollbar-thumb:active {
            background-color: #999999;
        }

        #audienciasTable::-webkit-scrollbar-track {
            background: #e1e1e1;
            border-radius: 4px;
        }
      
        #audienciasTable::-webkit-scrollbar-track:hover,
        #audienciasTable::-webkit-scrollbar-track:active {
          background: #d4d4d4;
        }  

        #audienciasTable tr td{
            position: relative;
        }

        .cuteScroll::-webkit-scrollbar {
            width: 8px;
            height: 8px;     
        }

        .cuteScroll::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 4px;
        }

        .cuteScroll::-webkit-scrollbar-thumb:hover {
            background: #b3b3b3;
            box-shadow: 0 0 2px 1px rgba(0, 0, 0, 0.2);
        }

        .cuteScroll::-webkit-scrollbar-thumb:active {
            background-color: #999999;
        }

        .cuteScroll::-webkit-scrollbar-track {
            background: #e1e1e1;
            border-radius: 4px;
        }
      
        .cuteScroll::-webkit-scrollbar-track:hover,
        .cuteScroll::-webkit-scrollbar-track:active {
          background: #d4d4d4;
        }  

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

        .dhx_cal_event div.dhx_footer,
        .dhx_cal_event.past_event div.dhx_footer,
        .dhx_cal_event.event_english div.dhx_footer,
        .dhx_cal_event.event_math div.dhx_footer,
        .dhx_cal_event.event_science div.dhx_footer {
            background-color: transparent !important;
        }

        .dhx_cal_event .dhx_body {
            -webkit-transition: opacity 0.1s;
            transition: opacity 0.1s;
            opacity: 0.7;
        }

        .dhx_cal_event .dhx_title {
            line-height: 12px;
        }

        .dhx_cal_event_line:hover,
        .dhx_cal_event:hover .dhx_body,
        .dhx_cal_event.selected .dhx_body,
        .dhx_cal_event.dhx_cal_select_menu .dhx_body {
            opacity: 1;
        }

        .dhx_cal_event.event_1 div,
        .dhx_cal_event_line.event_1 {
            background-color: #6989b0 !important;
            border-color: #6989b0 !important;
        }

        .dhx_cal_event.dhx_cal_editor.event_1 {
            background-color: #6989b0 !important;
        }

        .dhx_cal_event_clear.event_1 {
            color: #6989b0 !important;
        }

        .dhx_cal_event.event_2 div,
        .dhx_cal_event_line.event_2 {
            background-color: #01377a !important;
            border-color: #01377a !important;
        }

        .dhx_cal_event.dhx_cal_editor.event_2 {
            background-color: #01377a !important;
        }

        .dhx_cal_event_clear.event_2 {
            color: #01377a !important;
        }

        .dhx_cal_event.event_3 div,
        .dhx_cal_event_line.event_3 {
            background-color: #3e5169 !important;
            border-color: #3e5169 !important;
        }

        .dhx_cal_event.dhx_cal_editor.event_3 {
            background-color: #3e5169 !important;
        }

        .dhx_cal_event_clear.event_3 {
            color: #B82594 !important;
        }

        .event_danger div,
        .dhx_cal_editor.event_danger,
        .dhx_cal_event_line.event_danger {
            background-color: #c93d11 !important;
        }

        .event_primary div,
        .dhx_cal_editor.event_primary,
        .dhx_cal_event_line.event_primary {
            background-color: #848f33cf !important;
        }

        .event_bkg_danger {
            background-color: #c93d11 !important;
        }

        .event_bkg_primary {
            background-color: #848f33cf !important;
        }


        .dhx_cal_event_line {
            height: auto !important;
        }

        .select2-container.select2-container--default.select2-container--open {
            z-index: 1050 !important;
        }

        .datepicker-container{
            z-index: 1110;
        }

        #modal-ver .modal-dialog {
            width: 100%;
            max-width: 700px;
            height: 90%;
            margin: 0;
            padding: 1;
        }

        #modal-ver .modal-dialog {
            height: auto !important;
            min-width: 70%;
        }


        #modal-ver .modal-body {
            height: auto !important;
            min-width: 70%;
        }

        #modal-ver .modal-content {
            height: auto !important;
            min-width: 70%;
        }

        
        #modal-streaming .modal-dialog {
            width: 100%;
            max-width: 700px;
            height: 90%;
            margin: 0;
            padding: 1;
        }
        #modal-streaming .modal-dialog {
            height: auto !important;
            min-width: 70%;
        }


        #modal-streaming .modal-body {
            height: auto !important;
            min-width: 70%;
        }

        #modal-streaming .modal-content {
            height: auto !important;
            min-width: 70%;
        }

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

            width: '100%';
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

        .acciones {
            min-width: 150px !important;
        }

        .acciones_notificacion {
            min-width: 150px !important;
        }

        .semaforo {
            min-width: 50px !important;
        }

        .situacion_audiencia {
            min-width: 150px !important;
        }

        .carpeta_judicial {
            min-width: 240px !important;
        }

        .fecha_audiencia {
            min-width: 190px !important;
        }

        .hora_programada_audiencia {
            min-width: 150px !important;
        }

        .notificacion_cabina {
            min-width: 220px !important;
        }

        .notificacion_degt {
            min-width: 150px !important;
        }

        .hora_realizacion {
            min-width: 150px !important;
        }

        .tipo_audiencia {
            min-width: 200px !important;
        }

        .edificio {
            min-width: 150px !important;
        }

        .sala {
            min-width: 150px !important;
        }

        .streaming_sala {
            min-width: 150px !important;
        }

        .id_evento {
            min-width: 150px !important;
        }

        .con_recursos_adicionales {
            min-width: 70px !important;
        }

        .recursos_adicionales {
            min-width: 300px !important;
        }

        .juez {
            min-width: 150px !important;
        }

        .unidad_gestion {
            min-width: 150px !important;
        }

        .total_imputados {
            min-width: 150px !important;
        }

        .imputados {
            min-width: 300px !important;
        }

        .victimas {
            min-width: 300px !important;
        }

        .delitos {
            min-width: 265px !important;
        }

        .carpeta_investigacion {
            min-width: 150px !important;
        }

        .td-title {
            background-color: #f0f2f7 !important;
            min-width: 120px !important;
            border-color: #f0f2f7 !important;
            max-height: 5px !important;
            padding: 3px 5px 3px 5px !important;
        }

        .odd {
            text-align: center !important;

        }

        .even {
            text-align: center !important;
        }

        .slim-navbar {
            z-index: 1000 !important;
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
            width: '100%';
        }

        #espacioEditarAudiencia {
            width: '50%';
            display: inline-block
        }

        #calendario {
            width: '100%';
        }

        #espacioAgregarAudiencia {
            width: '50%';
            display: inline-block
        }

        #calendarioAgregarAudiencia {
            width: '100%';
        }

        #modal-agregar-audiencia .modal-dialog {
            height: auto !important;
            min-width: 70%;
        }

        #modal-agregar-audiencia .modal-body {
            height: auto !important;
            min-width: 70%;
        }

        #modal-agregar-audiencia .modal-content {
            height: auto !important;
            min-width: 70%;
        }
        .tx-secondary {
          color: #727C2E !important;
        }
        .tx-white {
          color: #ffffff !important;
        }
        .tx-bold{
          font-weight:bold;
        }
    
        .tx-registrada{
          color: #ffb300 !important;
        }
    
        .tx-confirmada{
          color: #23BF08 !important;
        }
    
        .tx-finalizada{
          color: #2075d5 !important;
        }
    
        .tx-cancelada{
          color: #212529 !important;
        }
        
        .btn-oblong {
          border-radius: 0px !important; 
        }
        .status_audiencia{
          width: 8px;
          height: 8px;
          background: #23BF08;
          position: absolute;
          border-radius: 50%;
          left: 15%;
          top: 28%;
        }
        .confirm{
          background: #23BF08 !important;
        }
        .final{
          background: #2075d5 !important;
        }
        .cancel{
          background: #212529 !important;
        }
        .ui-datepicker.ui-widget.ui-widget-content.ui-helper-clearfix.ui-corner-all{
            z-index: 1050 !important;
        }
        .lds-roller {
            display: inline-block;
            position: relative;
            width: 80px;
            height: 80px;
          }
          .lds-roller div {
            animation: lds-roller 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
            transform-origin: 40px 40px;
          }
          .lds-roller div:after {
            content: " ";
            display: block;
            position: absolute;
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #fff;
            margin: -4px 0 0 -4px;
          }
          .lds-roller div:nth-child(1) {
            animation-delay: -0.036s;
          }
          .lds-roller div:nth-child(1):after {
            top: 63px;
            left: 63px;
          }
          .lds-roller div:nth-child(2) {
            animation-delay: -0.072s;
          }
          .lds-roller div:nth-child(2):after {
            top: 68px;
            left: 56px;
          }
          .lds-roller div:nth-child(3) {
            animation-delay: -0.108s;
          }
          .lds-roller div:nth-child(3):after {
            top: 71px;
            left: 48px;
          }
          .lds-roller div:nth-child(4) {
            animation-delay: -0.144s;
          }
          .lds-roller div:nth-child(4):after {
            top: 72px;
            left: 40px;
          }
          .lds-roller div:nth-child(5) {
            animation-delay: -0.18s;
          }
          .lds-roller div:nth-child(5):after {
            top: 71px;
            left: 32px;
          }
          .lds-roller div:nth-child(6) {
            animation-delay: -0.216s;
          }
          .lds-roller div:nth-child(6):after {
            top: 68px;
            left: 24px;
          }
          .lds-roller div:nth-child(7) {
            animation-delay: -0.252s;
          }
          .lds-roller div:nth-child(7):after {
            top: 63px;
            left: 17px;
          }
          .lds-roller div:nth-child(8) {
            animation-delay: -0.288s;
          }
          .lds-roller div:nth-child(8):after {
            top: 56px;
            left: 12px;
          }
          @keyframes lds-roller {
            0% {
              transform: rotate(0deg);
            }
            100% {
              transform: rotate(360deg);
            }
          }
        .buffering{
            width: 100%;
            padding: 10px;
            min-height: 200px;
            height: auto;
            text-align: center;
            background: rgba(0,0,0,0.8);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        #body-table1 tr td{
            vertical-align: text-top;
        }
        .dot{
            width: 5px;
            height: 5px;
            position: absolute;
            right: 5px;
            top: 4px;
            background: #CB4335;
            border-radius: 50%;
            animation: pulse 1.2s ease-out infinite;
        }
        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.2);
            }
            100%{
                transform: scale(1);
            }
        }
        .molde3 {
            width: 100%;
            height: 80px;
            padding: 10px;
        }

        .barra_l {
            border-left: 3px solid #848F33 !important;
            padding: 4px;
        }

        .barra_l ul {
            width: 100%;
            padding: 0;
            text-align: left;
            margin-left: 2%;
        }

        .barra_l ul li {
            list-style: none;
            margin-bottom: 4px;
        }

        .barra_l ul li ul li {
            list-style: none;
        }
    </style>

    <style>
        /*EVENTO A DEFAULT*/
        .dhx_cal_event.event_bkg_azul div{
            background-color: #1796b0 !important;
            color: #fff !important;
        }

        /*EVENTOS A MODIFICAR*/
        .dhx_cal_event.event_bkg_rojo div{
            background-color: #900 !important;
            color: #fff !important;
        }

        /*EVENTOS DE LA SALA*/
        .dhx_cal_event.event_bkg_verde div{
            background-color: #030 !important;
            color: #fff !important;
        }

        /*EVENTOS DEL JUEZ*/
        .dhx_cal_event.event_bkg_naranja div{
            background-color: #E56A4B !important;
            color: #fff !important;
        }

        /*EVENTO A DEFAULT*/
        .bkg_azul{
          background-color: #1796b0 !important;
          opacity: 0.7;
        }

        /*EVENTOS A MODIFICAR*/
        .bkg_rojo{
          background-color: #900 !important;
          opacity: 0.7;
        }

        /*EVENTOS DE LA SALA*/
        .bkg_verde{
          background-color: #030 !important;
          opacity: 0.7;
        }

        /*EVENTOS DEL JUEZ*/
        .bkg_naranja{
          background-color: #E56A4B !important;
          opacity: 0.7;
        }

        .square-10 {
          display: inline-block;
          width: 10px;
          height: 10px;
        }

        .rounded-circle {
          border-radius: 50% !important;
        }

        .custom-input-file {
            cursor: pointer;
            font-size: 25px;
            font-weight: bold;
            margin: 0 auto 0;
            min-height: 15px;
            overflow: hidden;
            padding: 10px;
            position: relative;
            text-align: center;
            width: 500px;
            color: #848F33 ;
            border: 2px solid #EEE;
            border-style: dotted;
            height: 80px;
            border-radius: 25px;
            width: 80%;
        }

            .custom-input-file:hover {
            background: #848F33 ;
            color: #fff;
        }

            .custom-input-file .input-file {
            border: 10000px solid transparent;
            cursor: pointer;
            font-size: 10000px;
            margin: 0;
            opacity: 0;
            outline: 0 none;
            padding: 0 ;
            position: absolute;
            right: -1000px;
            top: -1000px;
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
    <script>
        var arrA = [];
        var arrAllA = [];
        var scheulder = null;

        var jueces = [];
        const tipos_audiencia = @php echo json_encode($tipos_audiencia);@endphp;
        const inmuebles = @php echo json_encode($inmuebles);@endphp;
        const unidades_precargadas = @php echo json_encode($unidades);@endphp;
        const recursos_audiencia = @php echo json_encode($recursos_audiencia);@endphp;
        var id_unidad_sesion = @php echo json_encode($request->session()->get('id_unidad_gestion')); @endphp;
        var id_inmueble_sesion = @php echo json_encode($request->session()->get('id_inmueble')); @endphp;
        const permisos = @php echo json_encode($permisos);@endphp;

        var arrRAA = [];
        var newDA=null;
        var newDAC=null;
        var audiencia_activa = [];
        var filtros_asignados = [];
        var bandera_juez_predefinido = false;
        var unidades_permitidas_control =[12, 13, 14, 15, 16, 17, 18, 19, 32, 31, 30,33];
        var unidades_permitidas_ejecucion = [34,20, 37,35,36];

        var ordenamiento = {
            "id_audiencia": 0,
            "estatus_semaforo": 0,
            "folio_carpeta": 0,
            "fecha_audiencia": 0,
            "hora_inicio_audiencia": 0,
            "id_unidad_registro": 0,
            "tipo_audiencia": 0,
            "id_inmueble": 0,
            "id_sala": 0,
            "id_juez":0
        };

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


        $('#submenu_orden_fecha').click(function(){

            $('#submenu_context_fecha').show("fast",function(){
                $(this).removeClass('d-none');
                $(this).addClass('d-block');
              document.body.addEventListener('click', boxCloser, false);
            });
          
        });
          
        function boxCloser(e){
          if(e.target.id != 'submenu_context_fecha'){
             document.body.removeEventListener('click', boxCloser, false);
             $('#submenu_context_fecha').hide("fast",function(){
                $(this).removeClass('d-block');
                $(this).addClass('d-none');
             });
          }
        }

        console.log('inmueble', id_inmueble_sesion);
        console.log('permisos', permisos);

        $(function() {

            'use strict';
            
            $('.clockpicker').clockpicker({
                autoclose: true
            });

            $('#modal-ver').on('scroll', function() {
                
                /*
                    const scroll = $(this).scrollTop()
                    const top_propover = $('.popover').attr('top');
                    const nuevo_top = top_propover-scroll;
                    console.log(scroll);
                    console.log(top_propover);
                    console.log(nuevo_top);
                    $('.popover').css({top: ( nuevo_top )})
                */

                var topPos = $("input[class='clockpicker']").offset().top;
                var leftPos = $("input[class='clockpicker']").offset().left;
                console.log(topPos);
                console.log(leftPos);
                $(".popover").css("top", topPos + 35);
                $(".popover").css("left", leftPos);
                
            });

            //scheduler.init('calendario',new Date(),"day");

            $('#nav-edit-tab').click(function() { //editar
                $('#btn_actualizar_1').css('display', 'block');
                $('#btn_actualizar_2').css('display', 'none');
            });

            $('#nav-recurso-tab').click(function() { //editar
                $('#btn_actualizar_1').css('display', 'block');
                $('#btn_actualizar_2').css('display', 'none');
            });

            $('#nav-home-tab').click(function() { //home
                $('#btn_actualizar_1').css('display', 'none');
                $('#btn_actualizar_2').css('display', 'none');
            });

            //obtener un
            $('#idunidad').change(function() {
                /*
                $.ajax({
                    type: 'POST',
                    url: '/public/obtener_usuarios',
                    data: {
                        id_unidad_gestion: $('#idunidad').val(),
                    },
                    success: function(response) {
                        console.log('unidades',response)
                        if (response.status == 100) {   

                            let usuarios = '';
                            $(response.response).each((index, usuarioo) => {
                                const {
                                    usuario,
                                    id_usuario,
                                    nombres,
                                    apellido_paterno,
                                    apellido_materno,
                                    cve_juez
                                } = usuarioo;
                                const option =
                                    `<option value="${id_usuario}" > (${usuario}) ${nombres} ${apellido_paterno} ${apellido_materno}</option>`;
                                usuarios = usuarios.concat(option);
                            });
                            $('#selectusuario').html(`<option selected disabled value="">Elija una opción</option> <option value=""> TODOS </option>` + usuarios);


                        }
                    }
                });
                */

                var id_inmueble_d = $('#idInmueble_c').val();
                            
                //Recarga salas
                $.ajax({
                    type: 'POST',
                    url: '/public/obtener_inmueble_salas',
                    data: {
                        id_unidad: $(this).val(), 
                        id_inmueble : id_inmueble_d
                    },
                    success: function(response) {
                        console.log(response.response)
    
                        if (response.status == 100) {
                            var datos = response.response;
                            var salas_cargadas = `<option value="" selected>Seleccionar</option>`;

                            for(i in datos){
                                if(datos[i].id_inmueble == id_inmueble_d){
                                    salas_cargadas += `<option value="${datos[i].id_sala}">${datos[i].nombre_sala}</option>`;
                                }else if(id_inmueble_d == 0){
                                    salas_cargadas += `<option value="${datos[i].id_sala}">${datos[i].nombre_sala}</option>`;
                                }
                            }

                            $('#sala_c').html(salas_cargadas);
                            
                        } else {
                            $('#sala_c').html(`<option value="" selected>Seleccionar</option>`);
                        }
                    }
                });
            });

            //enter key press
            $('#idunidad').keypress(function(e) {
                if (e.which == 13) {
                    sec_ajax('primera'); //<---- Add this line
                }
            });

            $('#juez').keypress(function(e) {
                if (e.which == 13) {
                    sec_ajax('primera'); //<---- Add this line
                }
            });

            $('#fechaini').keypress(function(e) {
                if (e.which == 13) {
                    sec_ajax('primera'); //<---- Add this line
                }
            });

            // Select2
            $('.select2').select2({
                minimumResultsForSearch: Infinity
            });

            sec_ajax();
            obtenerTiposJuez();
            //hScroll(60);
            /*
            let fecha_actual = new Date();
            $('.fc-datepicker').datepicker({
              showOtherMonths: true,
              selectOtherMonths: true,
              dateFormat: 'yy-mm-dd',
              changeYear: true,
              yearRange: "c-100:" + (fecha_actual.getFullYear()+5)
            });
            */

            /*$('.datepicker-edit').datepicker({
                showOtherMonths: true,
                selectOtherMonths: true,
                dateFormat: 'yy-mm-dd',
                changeYear: true,
                yearRange: "c-100:" + fecha_actual.getFullYear()
            });*/
            /*
            $('.fc-datepicker').datepicker({
                showOtherMonths: true,
                selectOtherMonths: true,
                dateFormat: 'yy-mm-dd',
                changeYear: true,
                yearRange: "c-100:" + (fecha_actual.getFullYear()+5)
            });
            */
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
            /*
            $(function() {
                $('#fc-datepicker').datepicker({
                    showOtherMonths: true,
                    selectOtherMonths: true,
                    dateFormat: 'yy-mm-dd',
                    changeYear: true,
                    yearRange: "c-100:" + (fecha_actual.getFullYear()+5)
                });
            });
            */
            //focus textfiled
            $('.form-layout .form-control').on('focusin', function() {
                $(this).closest('.form-group').addClass('form-group-active');
            });

            $('.form-layout .form-control').on('focusout', function() {
                $(this).closest('.form-group').removeClass('form-group-active');
            });

            setTimeout(function() {
                $('#modal_loading').modal('hide');
            }, 1000);
        

            $("#tipo_juezSearch").change(function(){

                if($(this).val() == 0 ){
                    $('#juezSearch').html(`<option value="-" selected>Seleccionar</option>`);
                }else{

                    let id_unidad_gestion ='';
                    if(id_unidad_sesion == 0){
                        id_unidad_gestion = $('#idunidad').val();
                    }else{
                        id_unidad_gestion = id_unidad_sesion;
                    }

                    $.ajax({
                        type: 'GET',
                        url: '/public/juezxtipo_juez',
                        data: {
                            id_tipo_juez: $(this).val(),
                            id_unidad_gestion: id_unidad_gestion
                        },
                        success: function(response) {
                            console.log(response.response)
        
                            if (response.status == 100) {
                                var datos = response.response;
                                var tipos_jueces = `<option value="" selected>Seleccionar</option>`;
                                for(i in datos){
                                    let nombre_completo = datos[i].nombre_completo == null ? 'Sin nombre' : datos[i].nombre_completo;
                                    tipos_jueces += `<option value="${datos[i].id_usuario}">${nombre_completo}</option>`;
                                }

                                $('#juezSearch').html(tipos_jueces);
                                
                            } else {
                                $('#juezSearch').html(`<option value="-" selected>Seleccionar</option>`);
                            }
                        }
                    });
                }
            });

            $('#idInmueble_c').change(function(){
                if($(this).val() == 0 ){
                    $('#idunidad').html(`<option value="" selected>Seleccionar</option>`);
                    $('#sala_c').html(`<option value="" selected>Seleccionar</option>`);
                }else{
                    let id_inmueble_d ='';
                    if(id_inmueble_sesion == 0){
                        id_inmueble_d = $('#idInmueble_c').val();
                    }else{
                        id_inmueble_d = id_inmueble_sesion;
                    }

                    var unidades_cargadas = `<option value="" selected>Seleccionar</option>`;
                    for(i in unidades_precargadas){
                        if(unidades_precargadas[i].id_inmueble == id_inmueble_d){
                            unidades_cargadas += `<option value="${unidades_precargadas[i].id_unidad_gestion}">${unidades_precargadas[i].nombre_unidad}</option>`;
                        }else if(id_inmueble_d == 0){
                            unidades_cargadas += `<option value="${unidades_precargadas[i].id_unidad_gestion}">${unidades_precargadas[i].nombre_unidad}</option>`;
                        }
                    }
                    $('#idunidad').html(unidades_cargadas);
                }
            });

            setTimeout(function(){
                $('#tipo_juezSearch').select2();
                $('#juezSearch').select2();
                $('#tipo_audiencia').select2();

                let fecha_actual = new Date();

                $('#fechaini').datepicker({
                    showOtherMonths: true,
                    selectOtherMonths: true,
                    dateFormat: 'yy-mm-dd',
                    changeYear: true,
                    yearRange: "c-100:" + (fecha_actual.getFullYear()+5)
                  });
                  
                $('#fechafin').datepicker({
                    showOtherMonths: true,
                    selectOtherMonths: true,
                    dateFormat: 'yy-mm-dd',
                    changeYear: true,
                    yearRange: "c-100:" + (fecha_actual.getFullYear()+5)
                  });
            },1000)

        });

        @if($request->session()->get('id_tipo_usuario') != 1 || $request->session()->get('id_tipo_usuario') != 20 )
            obtenerSalasPrecargadas();
        @endif

        // INICIAL
        function sec_ajax(pagina_accion) {

            pagina = parseInt($('#pagina_actual').val());
            registros_por_pagina = 100;

            if (pagina_accion == "primera") {
                pagina = 1;
            } else if (pagina_accion == "avanzar") {
                pagina = pagina + 1;
            } else if (pagina_accion == "atras") {
                pagina = pagina - 1;
            } else if (pagina_accion == "ultima") {
                pagina = $('#paginas_totales').val();
            }

            if (pagina <= 0 || pagina > $('#paginas_totales').val()) {

            } else {
                $('#pagina_actual').val(pagina);
                $('#numeropagina').val(pagina);
                $('.pagina_actual_texto').html(pagina);

                fechaini =  $('#fechaini').val().split('/').reverse().join('-');
                fechafin =  $('#fechafin').val().split('/').reverse().join('-');    

                console.log('id_universal',id_unidad_sesion);
                if(id_unidad_sesion == 0){
                    uni = '-';
                }else{
                    uni = id_unidad_sesion;
                }

                if($("#idunidad").length > 0){

                    if($("#idunidad").val().length > 0){
                        uni = $("#idunidad").val();
                    }
                }

                cj = $('#searchCarpetaJudical').val() == '' ? '-' : $('#searchCarpetaJudical').val(); 

                tipo_juezSearch = $('#tipo_juezSearch').val() == 0 ? '-' : $('#tipo_juezSearch').val();
                juezSearch = $('#juezSearch').val()
                tipo_audiencia = $('#tipo_audiencia').val();
                id_audiencia  = $('#searchIdEvento').val();
                id_inmueble = $('#idInmueble_c').val();
                id_sala =  $('#sala_c').val();
                situacion_c = $('#situacion_c').val();

                order = [];

                ordenamiento.id_audiencia != 0 ? (ordenamiento.id_audiencia == 1 ?  order.push({"campo":"id_audiencia", "sentido":"ASC"}) : order.push({"campo":"id_audiencia", "sentido":"DESC"}) ) : '';
                ordenamiento.estatus_semaforo != 0 ? (ordenamiento.estatus_semaforo == 1 ?  order.push({"campo":"estatus_semaforo", "sentido":"ASC"}) : order.push({"campo":"estatus_semaforo", "sentido":"DESC"}) ) : '';
                ordenamiento.folio_carpeta != 0 ? (ordenamiento.folio_carpeta == 1 ?  order.push({"campo":"folio_carpeta", "sentido":"ASC"}) : order.push({"campo":"folio_carpeta", "sentido":"DESC"}) ) : '';
                ordenamiento.fecha_audiencia != 0 ? (ordenamiento.fecha_audiencia == 1 ?  order.push({"campo":"fecha_audiencia", "sentido":"ASC"}) : order.push({"campo":"fecha_audiencia", "sentido":"DESC"}) ) : '';
                ordenamiento.hora_inicio_audiencia != 0 ? (ordenamiento.hora_inicio_audiencia == 1 ?  order.push({"campo":"hora_inicio_audiencia", "sentido":"ASC"}) : order.push({"campo":"hora_inicio_audiencia", "sentido":"DESC"}) ) : '';
                ordenamiento.id_unidad_registro != 0 ? (ordenamiento.id_unidad_registro == 1 ?  order.push({"campo":"id_unidad_registro", "sentido":"ASC"}) : order.push({"campo":"id_unidad_registro", "sentido":"DESC"}) ) : '';
                ordenamiento.tipo_audiencia != 0 ? (ordenamiento.tipo_audiencia == 1 ?  order.push({"campo":"tipo_audiencia", "sentido":"ASC"}) : order.push({"campo":"tipo_audiencia", "sentido":"DESC"}) ) : '';
                ordenamiento.id_inmueble != 0 ? (ordenamiento.id_inmueble == 1 ?  order.push({"campo":"id_inmueble", "sentido":"ASC"}) : order.push({"campo":"id_inmueble", "sentido":"DESC"}) ) : '';
                ordenamiento.id_sala != 0 ? (ordenamiento.id_sala == 1 ?  order.push({"campo":"id_sala", "sentido":"ASC"}) : order.push({"campo":"id_sala", "sentido":"DESC"}) ) : '';
                ordenamiento.id_juez != 0 ? (ordenamiento.id_juez == 1 ?  order.push({"campo":"id_juez", "sentido":"ASC"}) : order.push({"campo":"id_juez", "sentido":"DESC"}) ) : '';

                var data = {          
                    id_unidad_gestion: uni,
                    fecha_ini: fechaini,
                    fecha_fin: fechafin,
                    cj:cj,
                    tipo_juezSearch:tipo_juezSearch,
                    juezSearch:juezSearch,
                    tipo_audiencia:tipo_audiencia,
                    id_audiencia:id_audiencia,
                    id_inmueble:id_inmueble,
                    id_sala:id_sala,
                    situacion: situacion_c,
                    orden:order,
                    pagina: $('#numeropagina').val(),
                    registros_por_pagina: 100,
                }

                //console.log('Filtros ',data);

                loading(true);
                
                $.ajax({
                    type: 'GET',
                    url: '/public/consultar_audiencias',
                    data: data,
                    success: function(response) {
                        loading(false);
                        if (response.status == 100) {
                            var datos = response.response;
                            var tr = '';
                            arrA = datos;

                            console.log('Audiencias Tablero', datos);

                            for(i in datos){
                                //######### MAJO ###########
                                    var notificado = datos[i].notificacion_MAJO_SIAJOP;
                                    var estado = '';
                                    if(notificado == 1){
                                        estado = `<i title="Enviado Majo con éxito" class="far fa-check-circle" style="background: transparent; padding: 2px 5px; font-size: 1.4em;color: #229954;"></i>`;
                                    }else{
                                        estado = `<i title="Error envio con Majo" class="fas fa-ban" style="background: transparent; padding: 2px 5px; font-size: 1.4em;color: #992922;"></i>`;
                                    }
                                //##########################

                                //######### Streaming Audiencia ########
                                    let div = '';
                                    if(datos[i].estatus_audiencia == 'Finalizada' || datos[i].estatus_audiencia == 'finalizada'){

                                        if(datos[i].liga_audiencia === null){
                                            liga_audiencia = 0; 
                                        }else{
                                            liga_audiencia = datos[i].liga_audiencia;
                                        }
                                        div = `@if( isset($permisos[75]) and $permisos[75] == 1 ) <i class="far fa-play-circle" title="Visualizar Sala" style="cursor: pointer; color:#2075d5 !important; font-size:1.5em;" onclick="streaming(${datos[i].id_audiencia},'${datos[i].estatus_audiencia}', '${liga_audiencia}', '${datos[i].clave_unidad}')"></i> @endif`;
                                    
                                    }else if(datos[i].estatus_audiencia == 'En desarrollo' || datos[i].estatus_audiencia == 'en desarrollo'){

                                        if(datos[i].liga_audiencia === null){
                                            liga_audiencia = 0; 
                                        }else{
                                            liga_audiencia = datos[i].liga_audiencia;
                                        }

                                        div = `@if( isset($permisos[75]) and $permisos[75] == 1 ) 
                                                    <div style="position:relative; cursor:pointer; border:1px solid #CB4335; color:#CB4335; border-radius:5px; width:40%; margin:0 auto; font-size:0.7em; font-weight:bold;" onclick="streaming_live(${datos[i].id_audiencia}, '${datos[i].id_sala}', '${datos[i].id_inmueble}')">
                                                        En Vivo <div class="dot"></div>
                                                    </div>
                                                    @endif`;
                                    
                                    }else if(datos[i].estatus_audiencia == 'Cancelado' || datos[i].estatus_audiencia == 'cancelado'){
                                        div = `<i class="fas fa-ban" title="Visualizar Sala" style="color:#CB4335 !important; font-size:1.5em;"></i>`;
                                    }else if(datos[i].estatus_audiencia == 'En espera de confirmación' || datos[i].estatus_audiencia == 'en espera de confirmación'){
                                        div = `
                                            <i class="far fa-clock" title="En espera" style="color:#848F33 !important; font-size:1.5em;"></i>
                                            @if( isset($permisos[75]) and $permisos[75] == 1 ) 
                                                <div style="cursor: pointer; font-size: 0.9em; border: 1px solid #848f33; border-radius: 9px; width: 80%; margin: 7% auto 0 auto;" onclick="streaming_live(${datos[i].id_audiencia}, '${datos[i].id_sala}', '${datos[i].id_inmueble}')">
                                                    <i class="fa fa-eye"></i> Ver Sala
                                                </div> 
                                            @endif
                                        `;
                                    }else if(datos[i].estatus_audiencia == 'Confirmada' || datos[i].estatus_audiencia == 'confirmada'){
                                        div = `
                                        <i class="far fa-clock" title="Confirmada" style="color:#848F33 !important; font-size:1.5em;"></i>
                                        @if( isset($permisos[75]) and $permisos[75] == 1 ) 
                                            <div style="cursor: pointer; font-size: 0.9em; border: 1px solid #848f33; border-radius: 9px; width: 80%; margin: 7% auto 0 auto;" onclick="streaming_live(${datos[i].id_audiencia}, '${datos[i].id_sala}', '${datos[i].id_inmueble}')">
                                                <i class="fa fa-eye"></i> Ver Sala
                                            </div> 
                                        @endif
                                        `;
                                    }else{
                                        div = `
                                        <i class="far fa-clock" title="En espera" style="color:#848F33 !important; font-size:1.5em;"></i>
                                        @if( isset($permisos[75]) and $permisos[75] == 1 ) 
                                            <div style="cursor: pointer; font-size: 0.9em; border: 1px solid #848f33; border-radius: 9px; width: 80%; margin: 7% auto 0 auto;" onclick="streaming_live(${datos[i].id_audiencia}, '${datos[i].id_sala}', '${datos[i].id_inmueble}')">
                                                <i class="fa fa-eye"></i> Ver Sala
                                            </div>
                                        @endif
                                        `;
                                    }
                                //##########################
                                
                                //######### Estatus Audiencia ########
                                    let estatus = '';
                                    if(datos[i].estatus_semaforo == 'Confirmada' || datos[i].estatus_semaforo == 'confirmada' ){
                                        estatus = `<div style="position:relative;">
                                                        <div class="status_audiencia confirm"></div>
                                                        <div style="color: #23BF08;text-transform: capitalize;">${datos[i].estatus_semaforo}</div>
                                                    </div>`;
                                    }else if(datos[i].estatus_semaforo == 'Finalizada' || datos[i].estatus_semaforo == 'finalizada' ){
                                        estatus = `<div style="position:relative;">
                                                        <div class="status_audiencia final"></div>
                                                        <div style="color: #2075d5;text-transform: capitalize;">${datos[i].estatus_semaforo}</div>
                                                    </div>`;
                                    }else if(datos[i].estatus_semaforo == 'Cancelado' || datos[i].estatus_semaforo == 'cancelado' || datos[i].estatus_semaforo == 'cancelada' ){
                                        estatus = `<div style="position:relative;">
                                                        <div class="status_audiencia cancel"></div>
                                                        <div style="color: #212529;text-transform: capitalize;">${datos[i].estatus_semaforo}</div>
                                                    </div>`;
                                    }else{
                                        estatus = `<div style="position:relative;">
                                            <div class="status_audiencia confirm"></div>
                                            <div style="color: #23BF08;text-transform: capitalize;">Confirmada</div>
                                        </div>`;
                                    }
                                //##########################

                                //######### Disponibilidad de Recursos ########
                                    let tablaRecurso = "";
                                    let tabla_recursos = [];
                                    var respuesta = ''; 

                                    $.each(datos[i].recursos, function(indexR, recurso) {
                                        const {nombre_recurso} = recurso;
                                        tablaRecurso = tablaRecurso + recurso.nombre_recurso + `<br>`;
                                    });

                                    tabla_recursos = tablaRecurso;
                                    if(tabla_recursos.length > 0){ respuesta = 'Si';}else{ respuesta = 'No'}
                                //##########################

                                //######### Recursos Adicionales ########
                                    var recursos = '';
                                    if(datos[i].recursos){
                                        
                                        for(j = 0 ; j < datos[i].recursos.length; j++){
                                            recursos += `<li style="border-left: 2px solid #848f33; padding-left: 2%; margin: 4% 0;"><div>${datos[i].recursos[j].nombre_recurso}</div> <div>[${datos[i].recursos[j].descripcion}] -- Inicio: ${datos[i].recursos[j].horario_requerido_inicio}hrs. </div> </li>`;
                                        }
                                    
                                    }
                                //##########################

                                //######### Juez ########
                                    let nombre_juez = '';
                                    if(Object.keys(datos[i].juez).length > 0){
                                        nombre_juez = `<div style="display: flex;justify-content: center;align-items: center;flex-direction: column;font-size: 0.8em; ">
                                            <i class="far fa-user" style="color: #848f33;font-size: 2.9em;margin-bottom: 7%;"></i> ${datos[i].juez.nombre_usuario}
                                        </div>`;
                                    }
                                //##########################

                                //######### Centro de Justicia PROMUJER ########
                                    var centro_justicia = ``;

                                    if(datos[i].centro_justicia_promujer != null){
                                        centro_justicia = `<div style="display: flex;justify-content: center;align-items: center;flex-direction: column;font-size: 0.8em; ">
                                            <i class="fas fa-landmark" style="color: #848f33;font-size: 2.9em;margin-bottom: 7%;"></i> ${datos[i].centro_justicia_promujer}
                                        </div>`
                                    }
                                //##########################

                                //######### Imputados ########
                                    var imputados = '';
                                    if(datos[i].imputados != null){
                                        if(datos[i].imputados.length > 0){
                                            for(j = 0 ; j < datos[i].imputados.length; j++){
                                                if(datos[i].imputados[j].tipo == 'fisica'){
                                                    imputados += `<li style="border-left: 2px solid #848f33; padding-left: 2%; margin: 1% 0;">${datos[i].imputados[j].nombre}</li>`;
                                                }else{
                                                    imputados += `<li style="border-left: 2px solid #848f33; padding-left: 2%; margin: 1% 0;">${datos[i].imputados[j].razon_social}</li>`;
                                                }
                                            }
                                        }
                                    }
                                //###############################
                                
                                //######### Victimas ########
                                    var victimas = '';

                                    if(datos[i].victimas != null){
                                        if(datos[i].victimas.length > 0){
                                            for(j = 0 ; j < datos[i].victimas.length; j++){
                                                if(datos[i].victimas[j].tipo == 'fisica'){
                                                    victimas += `<li style="border-left: 2px solid #848f33; padding-left: 2%; margin: 1% 0;">${datos[i].victimas[j].nombre}</li>`;
                                                }else{
                                                    victimas += `<li style="border-left: 2px solid #848f33; padding-left: 2%; margin: 1% 0;">${datos[i].victimas[j].razon_social}</li>`;
                                                }
                                            }
                                        }
                                    }
                                //###############################

                                //######### Delitos ########
                                    var delitos = '';

                                    if(datos[i].delitos != null){
                                        if(datos[i].delitos.length > 0){
                                            for(j = 0 ; j < datos[i].delitos.length; j++){
                                                delitos += `<li style="list-style:none;">${datos[i].delitos[j].delito}</li>`;
                                            }
                                        }
                                    }
                                //###############################

                                tr += `
                                    <tr>
                                        <td> {{--  Acciones  --}}
                                            @if( isset($permisos[72]) and $permisos[72] == 1 ) <i class="icon ion-edit" title="Editar audiencia" style="cursor: pointer" onclick="ver_audiencia(${i})" id="genererAudiencia"></i> @endif
                                            @if( isset($permisos[71]) and $permisos[71] == 1 ) <i class="icon ion-plus" title="Nueva audiencia" style="cursor: pointer" onclick="nueva_audiencia(${i})" id="nuevaAudiencia"></i> @endif
                                            @if( isset($permisos[73]) and $permisos[73] == 1 ) <i class="icon fas fa-file-pdf" title="Ver Documentos de Audiencia" style="cursor: pointer; padding: 4px 5px;" onclick="ver_acuse(${datos[i].id_audiencia})" id="ver_acuse"></i> @endif
                                        </td>

                                        <td> {{--  Notificacion MAJO / SIAJOP  --}}
                                            @if( isset($permisos[74]) and $permisos[74] == 1 ) 
                                                <i class="icon ion-ios-redo" title="Reenviar a MAJO" style="cursor: pointer" onclick="ReenviarMAjo(${datos[i].id_audiencia})" id="reenviarMajo"></i> 
                                            @endif
                                            ${estado}
                                        </td>

                                        <td> {{--  Streaming  --}}
                                            @if( isset($permisos[75]) and $permisos[75] == 1 )
                                                ${div}
                                            @endif
                                        </td>

                                        <td> {{--  Id Evento  --}}
                                            ${datos[i].id_audiencia}
                                        </td>

                                        <td> {{--  Situacion Audiencia  --}}
                                            <div>
                                                ${estatus}
                                                <div style="font-size: 0.8em; color: #b1b1b1;">
                                                ${datos[i].estatus_audiencia}
                                                </div>
                                            </div>
                                        </td>

                                        <td> {{--  Carpetas  --}}
                                            <div class="molde3">
                                                <div class="barra_l">
                                                    <ul style="margin: 1.3% 0 1.3% 2%;">
                                                        <li style="font-size: 0.8em;"><strong>Carpeta Judicial:</strong> ${datos[i].folio_carpeta} </li>
                                                        <li style="font-size: 0.8em;"><strong>Carpeta Inv.:</strong>
                                                            <ul>
                                                                <li style="font-size: 0.97em;">${datos[i].carpeta_investigacion}</li>
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>

                                        <td> {{--  Datos de la audiencia  --}}
                                            <div style="position: absolute; top: 0; display: flex; justify-content: center; align-items: center; width: 100%; background: #dbe2a3; color: #8a8a8a;font-size: 0.85em; font-weight: bold;">
                                                Fecha: ${datos[i].fecha_audiencia}
                                            </div>
                                            <div style="font-size: 0.72em;text-align: right;font-weight: bold;">Fecha Fin: ${datos[i].fecha_fin_audiencia}</div>
                                            <div style="margin: 10% 0 5% 0; font-size: 0.9em;">
                                                <div style="border-left: 2px solid #848f33; padding-left: 4px;font-size: 0.83em;font-weight: bold;text-align: left;margin: 1% 0;">Hora programada</div>
                                                ${datos[i].hora_inicio_audiencia} - ${datos[i].hora_fin_audiencia}
                                            </div>
                                            <div style="margin:8% 0 5% 0;font-size: 0.9em;">
                                                <div style="border-left: 2px solid #848f33; padding-left: 4px;font-size: 0.83em;font-weight: bold;text-align: left;margin: 1% 0;">Hora realización</div>
                                                ${datos[i].hora_inicio_real == null ? '' : datos[i].hora_inicio_real }
                                            </div>
                                        </td>

                                        <td> {{--  Unidad de Gestión  --}}
                                            ${datos[i].nombre_unidad}
                                        </td>

                                        <td> {{--  Tipo de Audiencia  --}}
                                            ${datos[i].tipo_audiencia}
                                        </td>

                                        <td> {{--  Inmueble  --}}
                                            <div style="display: flex;justify-content: center;align-items: center;flex-direction: column;font-size: 0.8em; ">
                                                <i class="far fa-building" style="color: #848f33;font-size: 2.9em;margin-bottom: 7%;"></i> ${datos[i].nombre_inmueble}
                                            </div>
                                        </td>

                                        <td> {{--  Sala  --}}
                                            ${datos[i].nombre_sala}
                                        </td>

                                        <td> {{--  Disponibilidad de Recursos  --}}
                                            ${respuesta}
                                        </td>

                                        <td> {{--  Recursos Adicionales --}}
                                            <div style="width:100%; text-align:left; font-size:0.8em;">
                                                <ul class="cuteScroll" style="list-style:none;text-align:left; overflow-y: auto; max-height: 138px; width: 100%; padding: 2px 19px;">
                                                    ${recursos}
                                                </ul>
                                            </div>
                                        </td>

                                        <td> {{--  Juez  --}}
                                            ${nombre_juez}
                                        </td>

                                        <td> {{--  Centro de Justicia PROMUJER  --}}
                                            ${centro_justicia}
                                        </td>

                                        <td> {{--  Total Imputados  --}}
                                            ${datos[i].imputados != null ? datos[i].imputados.length : ''}
                                        </td>

                                        <td> {{--  Imputados  --}}
                                            <div style="width:100%; text-align:left; font-size:0.8em;">
                                                <ul class="cuteScroll" style="list-style:none; text-align:left; overflow-y: auto; max-height: 138px; width: 100%; padding: 2px 8px;">
                                                    ${imputados}
                                                </ul>
                                            </div>
                                        </td>

                                        <td> {{--  Victimas  --}}
                                            <div style="width:100%; text-align:center; font-size:0.8em;">
                                                <ul class="cuteScroll" style=" list-style:none;  text-align:left; overflow-y: auto; max-height: 138px; width: 100%; padding: 2px 8px;">
                                                    ${victimas}
                                                </ul>
                                            </div>
                                        </td>

                                        <td> {{--  Delitos  --}}
                                            <div style="width:100%; text-align:center; font-size:0.8em;">
                                                <ul>
                                                    ${delitos}
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                `;
                            }

                            $("#body-table1").html(tr);

                            $('.pagina_total_texto').html(response.response_paginacion['paginas_totales']);
                            $('#paginas_totales').val(response.response_paginacion['paginas_totales'])

                        } else {
                            body = `<tr><td colspan='12'><h4>Sin datos relacionados</h4></td><tr>`;
                            $("#body-table1").html(body);
                        }
                    }
                });

            }
        }

        //NUEVA AUDIENCIA MODAL
        async function nueva_audiencia(__index__) {
            audiencia_activa.length = 0;
            audiencia_activa = arrA[__index__];
            let audiencia = arrA[__index__];
            arrRAA.length = 0;
            fecha_audiencia = (new Date).toLocaleDateString();
            hora = (new Date).toLocaleTimeString();


            if( audiencia_activa.tipo_solicitud_ == 'PRO-MUJER' || audiencia_activa.id_tipo_carpeta == 6 ){
                bandera_juez_predefinido = true ;
            }else{
                bandera_juez_predefinido = false ;
            }

            fecha_audiencia = fecha_audiencia.split('/');
            fecha_audiencia = fecha_audiencia[0].padStart(2, "0")+'-'+fecha_audiencia[1].padStart(2, "0")+'-'+fecha_audiencia[2] ;

            hora = hora.split(':');
            hora = hora[0].padStart(2, "0")+':'+hora[1].padStart(2, "0")+':'+hora[2].padStart(2, "0") ;

            let strOptionTA = ``;
            for( var i in tipos_audiencia ){
              strOptionTA = strOptionTA + `
                <option value="${tipos_audiencia[i].id_ta}"> ${tipos_audiencia[i].tipo_audiencia} </option>
              `;
            }

            let strOptionJ = ``;
            let juez = await obtener_jueces( 'sig_control' );
            console.log('test juez',juez);
            if( juez.status == 100 ){
              //console.log(juez.response.id_usuario);
              //for (var i  in juez.response ){
                strOptionJ = strOptionJ + `<option value="${juez.response.id_usuario}" data-cve="${juez.response.cve_juez}"> ${juez.response.nombre??''} </option>`;
              //}
            }else{
              strOptionJ = `<option value="null" data-cve="null" selected> No se encontró al juez de control. </option>` ;
            }
      
            let strOptionI = ``;
            for( var i  in inmuebles ){
              strOptionI = strOptionI + `<option value="${inmuebles[i].id_inmueble}" ${audiencia.id_inmueble == inmuebles[i].id_inmueble ? 'selected' : ''} > ${inmuebles[i].nombre_inmueble}</option>`;
            }

            let strOptionS = ``;
            let salas = await obtener_salas( audiencia.id_inmueble );
            if( salas.status == 100 ){
              for( var i in salas = salas.response){
                strOptionS = strOptionS + `<option value="${salas[i].id_sala}"> ${salas[i].nombre_sala}</option>`;
              }
            }else{
              strOptionS = `<option value="null"> No se encontraron salas para este inmueble. </option>` ;
            }
        
            let strOptionR = ``;
            for( var i in recursos_audiencia ){
              strOptionR = strOptionR + `<option value="${recursos_audiencia[i].id_tipo_recurso}">${recursos_audiencia[i].tipo_recurso}</option>`;
            }

            let str_optionNR = ``;
            let nomRecurso = await obtener_recursos_hijos( recursos_audiencia[0].id_tipo_recurso );
            //let nomRecurso = await obtener_recursos_hijos( recursos_audiencia[0].id_tipo_recurso );
            if( nomRecurso.status==100 ){
              if( typeof nomRecurso.response === 'string' || (nomRecurso.response).length == 0 || (nomRecurso.response[0].recursos).length == 0 ) str_optionNR = str_optionNR + `<option value="null" disabeld selected > No hay recursos de este tipo </option>`;
              else{
                for ( var i in nomRecurso.response[0].recursos ){
                  r = nomRecurso.response[0].recursos[i];
                  str_optionNR = str_optionNR + `<option value="${r.id_recurso_audiencia}"> ${r.nombre_recurso} </option> `;
                }
              }
            }else{
              str_optionNR = str_optionNR + `<option value="null" disabeld selected > Error al obtener tipo de recursos </option>`;
            }


            let inputs_cambiar_juez = ``;
           // if( ! bandera_juez_predefinido ){
              inputs_cambiar_juez=`
                <div class="col-md-8 excusado" style="display: none">
                  <label class="form-control-label">Juez Asignado :<span class="tx-danger">*</span> </label>
                  <select class="form-control select-edit" id="juezExcusa-A" name="juezExcusa-A" autocomplete="off">
                  </select>
                </div>
                <div class="col-md-8 juez_tramite" style="display: none">
                  <label class="form-control-label">Juez Asignado :<span class="tx-danger">*</span> </label>
                  <select class="form-control select-edit" id="juezTramite-A" name="juezTramite-A" autocomplete="off">
                  </select>
                </div>
                <div class="col-md-2">
                  <label class="ckbox mg-t-40">
                    <input id="juez_tramite-A" type="checkbox" onchange="mostrar_juez_tramite( this , '#juezTramite-A'  )"><span>Juez Tramite</span>
                  </label>
                </div>
                <div class="col-md-2">
                  <label class="ckbox mg-t-40">
                    <input id="juez_excusa-A" type="checkbox" onchange="excusar( this , '#juezExcusa-A'  )"><span>Excusar</span>
                  </label>
                </div>
                <div class="col-lg-12 excusado" style="display: none">
                  <div class="form-group">
                    <label class="form-control-label">Ingrese los motivos por los que desea seleccionar a otro juez:</label>
                    <textarea class="form-control" name="motivoExcusa-A" id="motivoExcusa-A" rows="1" placeholder="Ingrese sus motivos"></textarea>
                  </div>
                </div>
              `;
           // }


            $('#espacioAudiencia').empty();
            $('#espacioAudiencia').html(`
                <input type="hidden" name="id_audiencia" id="id_audiencia" value="${get_unique_id()}">
                
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-home-tab"               data-toggle="tab" href="#nav-home"      role="tab" aria-controls="nav-home"     aria-selected="true">Datos de la Audiencia</a>
                        <a class="nav-item nav-link"        id="nav-edit-tab"               data-toggle="tab" href="#nav-edit"      role="tab" aria-controls="nav-edit"     aria-selected="false">Nueva Audiencia</a>
                        <a class="nav-item nav-link"        id="nav-edicion-recursos-tab"   data-toggle="tab" href="#nav-edicion-recursos" role="tab" aria-controls="nav-edicion-recursos" aria-selected="false">Recursos Adicionales</a>
                    </div>
                </nav>

                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home">
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label">Carpeta Judicial :<span class="tx-danger">*</span> </label>
                                    <input class="form-control" id="carpetaJudicial-AN" name="carpetaJudicial-AN" autocomplete="off" value="${audiencia.folio_carpeta}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label">Folio Audiencia :<span class="tx-danger">*</span> </label>
                                    <input class="form-control" id="folioAudiencia-AN" name="folioAudiencia-AN" autocomplete="off" value="N/E" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label">Situacion Audiencia :<span class="tx-danger">*</span> </label>
                                    <input class="form-control" id="situacionAudiencia-AN" name="situacionAudiencia-AN" autocomplete="off" value="En espera de confirmacion" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2 justify-content-center">
                            <div class="col-md-5">
                                <label class="form-control-label">Tipo Audiencia :<span class="tx-danger">*</span> </label>
                                <input class="form-control" id="tipoAudiencia-AN" name="tipoAudiencia-AN" autocomplete="off" value="En espera de confirmacion" readonly>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="form-control-label">Fecha :<span class="tx-danger">*</span> </label>
                                    <input class="form-control" id="fechaAudiencia-AN" name="fechaAudiencia-AN" autocomplete="off" value="${fecha_audiencia}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="nav-edit" role="tabpanel" aria-labelledby="nav-edicion-audiencia">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row"> <!-- FROM AUDIENCIA -->

                                    <div class="col-lg-12 mg-b-20">
                                        <br>
                                        <label class="form-control-label">Tipo Audiencia :<span class="tx-danger">*</span> </label>
                                        <select class="form-control select-edit" id="tipoAudiencia-A" name="tipoAudiencia-A" autocomplete="off">
                                        ${strOptionTA}
                                        </select>
                                    </div>

                                    <div class="col-lg-12 mg-b-20">
                                        <div class="row">
                                            <div class="${bandera_juez_predefinido?'col-md-12':'col-md-7'} sin_excusar no_juez_tramite">
                                                <label class="form-control-label">Juez Asignado :<span class="tx-danger">*</span> </label>
                                                <select class="form-control select-edit" id="juez-A" name="juez-A" autocomplete="off">
                                                ${strOptionJ}
                                                </select>
                                            </div>
                                            ${inputs_cambiar_juez}
                                        </div>
                                    </div>

                                    <div class="col-lg-6 mg-b-20">
                                        <label class="form-control-label">Inmueble <span class="tx-danger">*</span> :</label>
                                        <select class="form-control select-edit" id="inmueble-A" name="inmueble-A" autocomplete="off" onchange="refrescar_salas( this.value, '#sala-A' )">
                                        ${strOptionI}
                                        </select>
                                    </div>

                                    <div class="col-lg-6 mg-b-20">
                                        <label class="form-control-label">Sala <span class="tx-danger">*</span> :</label>
                                        <select class="form-control select-edit" id="sala-A" name="sala-A" autocomplete="off" onchange="pintar_eventos( this , '#fecha-A' )">
                                        ${strOptionS}
                                        </select>
                                    </div>

                                    <div class="col-lg-12 mg-b-20 col-md-12">
                                        <div class="row">

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-control-label">Fecha <span class="tx-danger">*</span> :</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                                            </div>
                                                        </div>
                                                        <input type="text" class="form-control datepicker-edit" placeholder="DD-MM-AAAA" value="${fecha_audiencia}" id="fecha-A" name="fecha-A" autocomplete="off" readonly onchange="pintar_eventos( '#sala-A' , this)">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-control-label">Hora inicio <span class="tx-danger">*</span> :</label>
                                                    <div class="d-flex">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="fa fa-clock-o tx-16 lh-0 op-6"></i>
                                                            </div><!-- input-group-text -->
                                                        </div><!-- input-group-prepend -->
                                                        <div class="input-group clockpicker-A" data-placement="right" data-align="top" data-autoclose="true">
                                                            <input  type="text" class="form-control time-edit-A" id="horaInicio-A" name="horaInicio-A" placeholder="hh:mm" value="${hora.substring(0,5)}" onchange="poner_hora_termino()">                                
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-control-label">Hora termino <span class="tx-danger">*</span> :</label>
                                                    <div class="d-flex">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="fa fa-clock-o tx-16 lh-0 op-6"></i>
                                                            </div><!-- input-group-text -->
                                                        </div><!-- input-group-prepend -->
                                                        <div class="input-group clockpicker-A" data-placement="left" data-align="top" data-autoclose="true">
                                                            <input  type="text" class="form-control time-edit-A" id="horaTermino-A" name="horaTermino-A" placeholder="hh:mm" value="${ get_time(  alter_time( fecha_audiencia.split('-').reverse().join('-')+' '+hora , action = '+' , time = '2' , type_time = 'h' )  , 'HH:mm') }" onchange="redimensiona_evento_audiencia('#id_audiencia')">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        
                            <div class="col-lg-6">
                                <div id="calendario_audiencias" class="dhx_cal_container" style='width:100%; height:47vh;'>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="square-10 bkg_rojo rounded-circle"></span>
                                    <span class="mg-l-3 tx-left" style="font-size: 0.8rem;">Evento en edición</span>
                                    
                                    <span class="mg-l-10 square-10 bkg_verde rounded-circle"></span>
                                    <span class="mg-l-3 tx-left" style="font-size: 0.8rem;">Evento de sala</span>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="tab-pane fade" id="nav-edicion-recursos" role="tabpanel" aria-labelledby="nav-edicion-recursos">
                        <div class="row">
                        <div class="col-lg-6">
                            <div class="card-body">
                            <div class="row">

                                <div class="col-lg-12">
                                <label class="form-control-label">Tipo recurso :<span class="tx-danger">*</span> </label>
                                <select class="form-control select-edit" id="id_tipo_recurso-A" name="id_tipo_recurso-A" autocomplete="off" onchange="refrescar_recursos( this.value , '#id_nombre_recurso-A' )">
                                    ${strOptionR}
                                </select>
                                </div>
                                
                                <div class="col-lg-12">
                                <label class="form-control-label">Nombre recurso :<span class="tx-danger">*</span> </label>
                                <select class="form-control select-edit" id="id_nombre_recurso-A" name="id_nombre_recurso-A" autocomplete="off" onchange="pintar_eventos_recursos( '#id_tipo_recurso-A' ,this , '#fechaInicioRecurso-A' )">
                                    ${str_optionNR}
                                </select>
                                </div>

                                <div class="col-lg-12 mg-b-20 col-md-12">
                                <div class="row">

                                    <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Fecha <span class="tx-danger">*</span> :</label>
                                        <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                            <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control datepicker-edit" placeholder="DD-MM-AAAA" value="${fecha_audiencia}" id="fechaInicioRecurso-A" name="fechaInicioRecurso-A" autocomplete="off" onchange="pintar_eventos_recursos( '#id_tipo_recurso-A', '#id_nombre_recurso-A', this )" readonly >
                                        </div>
                                    </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Fecha <span class="tx-danger">*</span> :</label>
                                        <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                            <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control datepicker-edit" placeholder="DD-MM-AAAA" value="${fecha_audiencia}" id="fechaFinRecurso-A" name="fechaFinRecurso-A" autocomplete="off" readonly >
                                        </div>
                                    </div>
                                    </div>

                                    <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Hora inicio <span class="tx-danger">*</span> :</label>
                                        <div class="d-flex">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                            <i class="fa fa-clock-o tx-16 lh-0 op-6"></i>
                                            </div><!-- input-group-text -->
                                        </div><!-- input-group-prepend -->
                                        <div class="input-group clockpicker-A" data-placement="right" data-align="top" data-autoclose="true">
                                            <input  type="text" class="form-control" id="horaInicioRecurso-A" name="horaInicioRecurso-A" autocomplete="nope" placeholder="hh:mm" value="${ get_time( alter_time( fecha_audiencia.split('-').reverse().join('-')+' '+hora , true , '0' , 'm' )  ) }" onchange="redimensiona_evento_recurso('#idRecursoAdicional-A')">
                                        </div>
                                        </div>
                                    </div>
                                    </div>

                                    <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Hora termino <span class="tx-danger">*</span> :</label>
                                        <div class="d-flex">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                            <i class="fa fa-clock-o tx-16 lh-0 op-6"></i>
                                            </div><!-- input-group-text -->
                                        </div><!-- input-group-prepend -->
                                        <div class="input-group clockpicker-A" data-placement="left" data-align="top" data-autoclose="true">
                                            <input  type="text" class="form-control" id="horaTerminoRecurso-A" name="horaTerminoRecurso-A" autocomplete="nope" placeholder="hh:mm" value="${ get_time( alter_time( fecha_audiencia.split('-').reverse().join('-')+' '+hora , true , '2' , 'h' )  ) }" onchange="redimensiona_evento_recurso('#idRecursoAdicional-A')">
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-time"></span>
                                            </span>
                                        </div>
                                        </div>
                                    </div>
                                    </div>

                                    <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-control-label">Comentarios :</label>
                                        <textarea class="form-control" name="comentariosRecurso-A" id="comentariosRecurso-A" rows="1"></textarea>
                                    </div>
                                    </div>

                                </div>

                                <div class="row justify-content-end"> <!-- BOTONES -->
                                    <input type="hidden" id="idRecursoAdicional-A" name ="idRecursoAdicional-A" value="${get_unique_id()}">
                                    <button class="btn btn-oblong btn-outline-primary" type="button" onclick="agregarRecurso()" id="btn-agregarRecurso-A"> Agregar Recurso </button>
                                </div>

                                </div>
                            </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div id="calendario_recursos" class="dhx_cal_container" style='width:100%; height:54vh;'>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="square-10 bkg_rojo rounded-circle"></span>
                                <span class="mg-l-3 tx-left" style="font-size: 0.8rem;">Evento en edición</span>
                                
                                <span class="mg-l-10 square-10 bkg_verde rounded-circle"></span>
                                <span class="mg-l-3 tx-left" style="font-size: 0.8rem;">Evento de sala</span>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="row">
                            <div class="col-md-12">
                                <br>
                                <table id="table-recursos-audiencia" class="datatable tableDatosSujeto" style="overflow-x: none; display: table; text-align: left;">
                                <thead>
                                    <tr>
                                    <th class="tx-center" style="background:#f8f9fa" colspan="6" class="tx-center tx-bold">Recursos Adicionales de la Audiencia:</th>
                                    </tr>
                                    <tr>
                                    <th class="tx-center" style="background:#f8f9fa" >#</th>
                                    <th class="tx-center" style="background:#f8f9fa" >Accion</th>
                                    <th class="tx-center" style="background:#f8f9fa" >Recurso</th>
                                    <th class="tx-center" style="background:#f8f9fa" >Horario de uso</th>
                                    <th class="tx-center" style="background:#f8f9fa" >Descripción</th>
                                    <th class="tx-center" style="background:#f8f9fa" >Comentarios</th>
                                    </tr>
                                </thead>
                                <tbody style="font-weight: lighter;">
                                    <tr>
                                    <td colspan="6" class="tx-center tx-bold">Sin Recursos Adicionales </td>
                                    </tr>
                                </tbody>
                                </table>
                            </div>
                            </div>

                        </div>
                        </div>
                    </div>
                </div>
            `);

            $('#footerEspacio').empty();
            $('#footerEspacio').html(`
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="limpiarEspacioA('#espacioEditarAudiencia')">Cerrar</button>
                <button type="button" class="btn btn-success" id="btn_guardar_1" onclick="guardarAudiencia()" style="display:none;background:#848F33 !important; border:none; cursor:pointer;">Guardar</button>
            `);
            
            $('#carpetaJL_actualizar').html(audiencia.folio_carpeta);

            setTimeout( function(){ loadConfigComponentA(); }, 1000);
            setTimeout( function(){ pintar_eventos( '#sala-A', '#fecha-A'); }, 2000);
            setTimeout( function(){ pintar_eventos_recursos( '#id_tipo_recurso-A', '#id_nombre_recurso-A', '#fechaInicioRecurso-A'); }, 2000);
            setTimeout( function(){ $('#id_tipo_recurso-A').trigger('change'); $('#id_nombre_recurso-A').trigger('change'); }, 1000);
            setTimeout( function(){
                $('#nav-edit-tab').click(function(){
                    $('#btn_guardar_1').css('display','block');
                });
                $('#nav-edicion-recursos-tab').click(function(){
                    $('#btn_guardar_1').css('display','block');
                });
                $('#nav-home-tab').click(function(){
                    $('#btn_guardar_1').css('display','none');
                });
            },1000);

            $('#modal-audiencia').modal('show');

        }

        //EDITAR AUDIENCIA MODAL
        async function ver_audiencia(__index__) {
            audiencia_activa.length = 0;
            let audiencia = arrA[ __index__ ];
            audiencia_activa = audiencia;
            arrRAA.length = 0;

            console.log('Audiencia Selected', audiencia);
            let strOptionTA = ``;
            for( var i in tipos_audiencia ){
              strOptionTA = strOptionTA + `
                <option value="${tipos_audiencia[i].id_ta}" ${tipos_audiencia[i].id_ta == audiencia.id_tipo_audiencia ? 'selected' : '' }> ${tipos_audiencia[i].tipo_audiencia} </option>
              `;
            }

            let strOptionJ = `<option value="${audiencia.id_juez}" data-cve="${audiencia.juez.cve_juez}" selected}>[${audiencia.juez.cve_juez}] ${audiencia.juez.nombre_usuario} </option>`;

            let strOptionI = ``;
            for( var i  in inmuebles ){
              strOptionI = strOptionI + `<option value="${inmuebles[i].id_inmueble}" ${inmuebles[i].id_inmueble==audiencia.id_inmueble ? 'selected' : ''}> ${inmuebles[i].nombre_inmueble}</option>`;
            }

            let strOptionS = ``;
            let salas = await obtener_salas( audiencia.id_inmueble );
            strOptionS = strOptionS + `<option value="${audiencia.id_sala}" selected> ${audiencia.nombre_sala}</option>`;
            console.log('sala',salas);
            if( salas.status == 100 ){
              for( var i in salas = salas.response){
                if( salas[i].id_sala == audiencia.id_sala ) continue;
                else strOptionS = strOptionS + `<option value="${salas[i].id_sala}" ${salas[i].id_sala==audiencia.id_sala ? 'selected' : ''}> ${salas[i].nombre_sala}</option>`;
              }
            }

            let strOptionR = ``;
            for( var i in recursos_audiencia ){
              strOptionR = strOptionR + `<option value="${recursos_audiencia[i].id_tipo_recurso}">${recursos_audiencia[i].tipo_recurso}</option>`;
            }

            arrRAA = audiencia.recursos;

            let trRecursos = ``;
            if( (arrRAA).length > 0){
              for( var i in arrRAA ){
                let btnEdit = `<i class="fas fa-edit" data-toggle="tooltip-primary" data-placement="top" title="Editar Recurso" onclick="editarRecurso(${i})"></i>`;
                let btnDelete = `<i class="fas fa-trash" data-toggle="tooltip-primary" data-placement="top" title="" onclick="estatusRecurso(${i})"></i>`;
                arrRAA[i].storage = 1 ;
      
                trRecursos = trRecursos + `
                  </tr>
                    <td>${ parseInt( i ) + 1}</td>
                    <td>  ${ btnDelete } ${  btnEdit } </td>
                    <td>${ arrRAA[i].nombre_recurso }</td>
                    <td>Del ${ arrRAA[i].fecha_requerido_inicio} a las ${arrRAA[i].horario_requerido_inicio.substring(0,5)} hrs. <br>hasta el ${arrRAA[i].fecha_requerido_fin} a las ${arrRAA[i].horario_requerido_fin.substring(0,5)} hrs.</td>
                    <td>${ arrRAA[i].descripcion != null ?  arrRAA[i].descripcion : ''}</td>
                    <td>${ arrRAA[i].comentarios_recurso != null ? arrRAA[i].comentarios_recurso : '' }</td>
                  </tr>
                `;
              }
            }else{
              trRecursos = `
                <tr>
                  <td colspan="6" class="tx-center tx-bold">Sin Recursos Adicionales </td>
                </tr>
              `;
            }

            let str_optionNR = ``;
            let nomRecurso = await obtener_recursos_hijos( recursos_audiencia[0].id_tipo_recurso );

            if( nomRecurso.status==100 ){
                if( typeof nomRecurso.response === 'string' || (nomRecurso.response).length == 0 || (nomRecurso.response[0].recursos).length == 0 ) str_optionNR = str_optionNR + `<option value="null" disabeld selected > No hay recursos de este tipo </option>`;
                else{
                  for ( var i in nomRecurso.response[0].recursos ){
                    r = nomRecurso.response[0].recursos[i];
                    str_optionNR = str_optionNR + `<option value="${r.id_recurso_audiencia}"> ${r.nombre_recurso} </option> `;
                  }
                }
            }else{
                str_optionNR = str_optionNR + `<option value="null" disabeld selected > Error al obtener tipo de recursos </option>`;
            }

            var juez_siguiente = `[${audiencia.juez.cve_juez}] ${audiencia.juez.nombre_usuario}`;
            var id_usuario_juez = audiencia.id_juez;
            var clave_juez = audiencia.juez.cve_juez;

            //Semaro del estatus de la audiencia 
            var strEstatusA =`<div class="p-3"><i class="fas fa-circle tx-${audiencia.estatus_semaforo} d-inline-block mg-l-10 bkg-tras"></i> ${audiencia.estatus_semaforo}</div>`;
            strEstatusA = strEstatusB(audiencia.estatus_semaforo, audiencia.id_carpeta_judicial, audiencia.id_audiencia, audiencia.id_unidad_gestion);

            var cancelado_com = '';
            if(audiencia_activa.estatus_semaforo == 'Cancelado' || audiencia_activa.estatus_semaforo == 'cancelado' || audiencia_activa.estatus_audiencia == 'Cancelado' || audiencia_activa.estatus_audiencia == 'Cancelada'  ){
                cancelado_com = `
                <div class="row mt-3">

                    <div class="col-lg-12 mg-t-10">
                        <div style="background: #fff;padding: 4px;border-radius: 11px;border: 1px solid #848f3340;">
                            <div style="font-size: 0.98em;padding: 6px;font-weight: bold;/* border: 1px solid #848f33; */width: 200px;margin: 1% auto;">Comentarios de Cancelacion</div>
                            <div style="text-align:center; background: #f7f4f4;border-radius: 9px;height: auto;width: 99%;margin: 0 auto 2% auto;padding: 8px;">${audiencia_activa.comentarios_cancelacion ?? 'Sin comentarios'}    
                                <a href="#" style="font-size: 0.9em;padding: 6px; width: 200px;margin: 1% auto;" class="${audiencia.nombre_archivo_cancelacion ? '' : 'd-none'}" onclick="ver_documento_cancelacion_audiencia('${audiencia.id_audiencia}')">${audiencia.nombre_archivo_cancelacion ? 'Ver documento: '+audiencia.nombre_archivo_cancelacion : 'Sin documento de cancelacion'}</a>
                                <br>
                                <object id="viewDocumentoCancelacionAudiencia" data=""	width="100%" height="400" class="d-none" ></object>
                            </div>
                        </div>
                    </div>

                </div>`;
            }
                                    

            $('#espacioAudiencia').empty();
            $('#espacioAudiencia').html(`
                <input type="hidden" name="id_audiencia" id="id_audiencia" value="${audiencia.id_audiencia}">
                
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-home-tab"               data-toggle="tab" href="#nav-home"      role="tab" aria-controls="nav-home"     aria-selected="true">Datos de la Audiencia</a>
                        <a class="nav-item nav-link"        id="nav-edit-tab"               data-toggle="tab" href="#nav-edit"      role="tab" aria-controls="nav-edit"     aria-selected="false">Editar Audiencia</a>
                        <a class="nav-item nav-link"        id="nav-edicion-recursos-tab"   data-toggle="tab" href="#nav-edicion-recursos" role="tab" aria-controls="nav-edicion-recursos" aria-selected="false">Recursos Adicionales</a>
                    </div>
                </nav>

                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home">
                        
                        <div class="row mt-3">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="info_tipoAudiencia">Tipo Audiencia</label>
                                    <input type="text" class="form-control" id="info_tipoAudiencia" placeholder="Tipo Audiencia" value="${audiencia.tipo_audiencia}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="info_juezAsignado">Juez Asignado</label>
                                    <input type="text" class="form-control" id="info_juezAsignado" placeholder="Juez Asignado" value="${juez_siguiente}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="info_inmueble">Inmueble</label>
                                    <input type="text" class="form-control" id="info_inmueble" placeholder="Inmueble" value="${audiencia.nombre_inmueble}" readonly>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="info_sala">Sala</label>
                                    <input type="text" class="form-control" id="info_sala" placeholder="Sala" value="${audiencia.nombre_sala}" readonly>
                                </div>
                            </div>
                        
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="info_fecha">Fecha</label>
                                    <input type="text" class="form-control" id="info_fecha" placeholder="Fecha" value="${audiencia.fecha_audiencia}" readonly>
                                </div>
                            </div>

                        </div>

                        <div class="row mt-3">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="info_hora_inicio">Horario</label>
                                    <input id="info_hora_inicio" type="text" class="form-control" placeholder="Hora de Inicio" autocomplete="off" value="De las ${audiencia.hora_inicio_audiencia}hrs. a las ${audiencia.hora_fin_audiencia}hrs." readonly>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="info_hora_inicio">Centro de gestion</label>
                                    <input id="info_hora_final" type="text" class="form-control" placeholder="Centro de Gestión" autocomplete="off" value="${audiencia.nombre_unidad}" readonly>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="estatus" id="info_situacion">${'situacion: '+audiencia.estatus_audiencia}</label>
                                    <div id="info_estatus_audiencia">
                                        ${strEstatusA}
                                    </div> 
                                </div>
                            </div>

                        </div>

                        ${cancelado_com}
                            
                    </div>

                    <div class="tab-pane fade" id="nav-edit" role="tabpanel" aria-labelledby="nav-edit">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row"> <!-- FROM AUDIENCIA -->
            
                                    <div class="col-lg-12 mg-b-20">
                                        <br>
                                        <label class="form-control-label">Tipo Audiencia :<span class="tx-danger">*</span> </label>
                                        <select class="form-control select-edit" id="tipoAudiencia-A" name="tipoAudiencia-A" autocomplete="off">
                                            ${strOptionTA}
                                        </select>
                                    </div>
            
                                    <div class="col-lg-12 mg-b-20">
                                        <div class="row">
                                            <div class="col-md-8 sin_excusar">
                                              <label class="form-control-label">Juez Asignado :<span class="tx-danger">*</span> </label>
                                              <select class="form-control select-edit" id="juez-A" name="juez-A" autocomplete="off">
                                                ${strOptionJ}
                                              </select>
                                            </div>
                                            <div class="col-md-8 excusado mt-3" style="display: none">
                                              <label class="form-control-label">Juez Asignado :<span class="tx-danger">*</span> </label>
                                              <select class="form-control select-edit" id="juezExcusa-A" name="juezExcusa-A" autocomplete="off">
                                              </select>
                                            </div>
                                            <div class="col-md-4">
                                              <label class="ckbox mg-t-40">
                                                <input id="juez_excusa-A" type="checkbox" onchange="excusar( this , '#juezExcusa-A'  )"><span>Excusar</span>
                                              </label>
                                            </div>
                                            <div class="col-lg-12 excusado mt-3" style="display: none">
                                                <div class="form-group">
                                                  <label class="form-control-label">Ingrese los motivos por los que desea asignar otro juez:</label>
                                                  <textarea class="form-control" name="motivoExcusa-A" id="motivoExcusa-A" rows="1" placeholder="Ingrese sus motivos"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
            
                                    <div class="col-lg-6 mg-b-20">
                                      <label class="form-control-label">Inmueble <span class="tx-danger">*</span> :</label>
                                      <select class="form-control select-edit" id="inmueble-A" name="inmueble-A" autocomplete="off" onchange="refrescar_salas( this.value, '#sala-A' )">
                                        ${strOptionI}
                                      </select>
                                    </div>
            
                                    <div class="col-lg-6 mg-b-20">
                                      <label class="form-control-label">Sala <span class="tx-danger">*</span> :</label>
                                      <select class="form-control select-edit" id="sala-A" name="sala-A" autocomplete="off" onchange="pintar_eventos( this , '#fecha-A' )">
                                        ${strOptionS}
                                      </select>
                                    </div>
            
                                    <div class="col-lg-12 mg-b-20 col-md-12">
                                        <div class="row">
                                        
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-control-label">Fecha <span class="tx-danger">*</span> :</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                              <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                                            </div>
                                                        </div>
                                                        <input type="text" class="form-control datepicker-edit" placeholder="DD-MM-AAAA" value="${get_date( audiencia.fecha_audiencia , 'DD-MM-YYYY' )}" id="fecha-A" name="fecha-A" autocomplete="off" readonly onchange="pintar_eventos( '#sala-A' , this)">
                                                    </div>
                                                </div>
                                            </div>
                                        
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-control-label">Hora inicio <span class="tx-danger">*</span> :</label>
                                                    <div class="d-flex">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="fa fa-clock-o tx-16 lh-0 op-6"></i>
                                                            </div><!-- input-group-text -->
                                                        </div><!-- input-group-prepend -->
                                                        <div class="input-group clockpicker-A" data-placement="right" data-align="top" data-autoclose="true">
                                                            <input  type="text" class="form-control" id="horaInicio-A" name="horaInicio-A" placeholder="hh:mm" value="${arrA[ __index__ ].hora_inicio_audiencia != null ?  arrA[ __index__ ].hora_inicio_audiencia.substring(0,5): ''}" onchange="poner_hora_termino()">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-control-label">Hora termino <span class="tx-danger">*</span> :</label>
                                                    <div class="d-flex">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="fa fa-clock-o tx-16 lh-0 op-6"></i>
                                                            </div><!-- input-group-text -->
                                                        </div><!-- input-group-prepend -->
                                                        <div class="input-group clockpicker-A" data-placement="left" data-align="top" data-autoclose="true">
                                                            <input  type="text" class="form-control" id="horaTermino-A" name="horaTermino-A" placeholder="hh:mm" value="${arrA[ __index__ ].hora_fin_audiencia != null ? arrA[ __index__ ].hora_fin_audiencia.substring(0,5) : ''}" onchange="redimensiona_evento_audiencia(${audiencia.id_audiencia})">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        
                                        </div>
                                    </div>

                                </div>
                            </div>
                          
                            <div class="col-lg-6">
                                <div id="calendario_audiencias" class="dhx_cal_container" style='width:100%; height:47vh;'>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="square-10 bkg_rojo rounded-circle"></span>
                                    <span class="mg-l-3 tx-left" style="font-size: 0.8rem;">Evento en edición</span>
                                    
                                    <span class="mg-l-10 square-10 bkg_verde rounded-circle"></span>
                                    <span class="mg-l-3 tx-left" style="font-size: 0.8rem;">Evento de sala</span>
                                </div>
                            </div>
            
                        </div>
            
                    </div>

                    <div class="tab-pane fade" id="nav-edicion-recursos" role="tabpanel" aria-labelledby="nav-edicion-recursos">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card-body">
                                    <div class="row">
                    
                                        <div class="col-lg-12">
                                            <label class="form-control-label">Tipo recurso :<span class="tx-danger">*</span> </label>
                                            <select class="form-control select-edit" id="id_tipo_recurso-A" name="id_tipo_recurso-A" autocomplete="off" onchange="refrescar_recursos( this.value , '#id_nombre_recurso-A' )">
                                                ${strOptionR}
                                            </select>
                                        </div>
                                        
                                        <div class="col-lg-12">
                                            <label class="form-control-label">Nombre recurso :<span class="tx-danger">*</span> </label>
                                            <select class="form-control select-edit" id="id_nombre_recurso-A" name="id_nombre_recurso-A" autocomplete="off" onchange="pintar_eventos_recursos( '#id_tipo_recurso-A' ,this , '#fechaInicioRecurso-A' )">
                                                ${str_optionNR}
                                            </select>
                                        </div>
                    
                                        <div class="col-lg-12 mg-b-20 col-md-12">
                                            <div class="row">
                                            
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-control-label">Fecha <span class="tx-danger">*</span> :</label>                   
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">
                                                                    <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                                                </div>
                                                            </div>
                                                            <input type="text" class="form-control datepicker-edit" placeholder="DD-MM-AAAA" value="${get_date( audiencia.fecha_audiencia , 'DD-MM-YYYY' )}" id="fechaInicioRecurso-A" name="fechaInicioRecurso-A" autocomplete="off" onchange="pintar_eventos_recursos( '#id_tipo_recurso-A', '#id_nombre_recurso-A', this )" readonly >
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-control-label">Fecha <span class="tx-danger">*</span> :</label>
                                                        <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                                            </div>
                                                        </div>
                                                        <input type="text" class="form-control datepicker-edit" placeholder="DD-MM-AAAA" value="${get_date( audiencia.fecha_audiencia , 'DD-MM-YYYY' )}" id="fechaFinRecurso-A" name="fechaFinRecurso-A" autocomplete="off" readonly >
                                                        </div>
                                                    </div>
                                                </div>
                                            
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-control-label">Hora inicio <span class="tx-danger">*</span> :</label>
                                                        <div class="d-flex">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="fa fa-clock-o tx-16 lh-0 op-6"></i>
                                                            </div><!-- input-group-text -->
                                                        </div><!-- input-group-prepend -->
                                                        <div class="input-group clockpicker-A" data-placement="right" data-align="top" data-autoclose="true">
                                                            <input  type="text" class="form-control time-edit-A" id="horaInicioRecurso-A" name="horaInicioRecurso-A" placeholder="hh:mm" value="${ audiencia.hora_inicio_audiencia != null ? audiencia.hora_inicio_audiencia.substring(0,5) :'' }" onchange="redimensiona_evento_recurso('#idRecursoAdicional-A')">
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-control-label">Hora termino <span class="tx-danger">*</span> :</label>
                                                        <div class="d-flex">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">
                                                                    <i class="fa fa-clock-o tx-16 lh-0 op-6"></i>
                                                                </div><!-- input-group-text -->
                                                            </div><!-- input-group-prepend -->
                                                            <div class="input-group clockpicker-A" data-placement="left" data-align="top" data-autoclose="true">
                                                                <input  type="text" class="form-control time-edit-A" id="horaTerminoRecurso-A" name="horaTerminoRecurso-A" placeholder="hh:mm" value="${ audiencia.hora_fin_audiencia != null ? audiencia.hora_fin_audiencia.substring(0,5) : '' }" onchange="redimensiona_evento_recurso('#idRecursoAdicional-A')">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label">Comentarios :</label>
                                                        <textarea class="form-control" name="comentariosRecurso-A" id="comentariosRecurso-A" rows="1"></textarea>
                                                    </div>
                                                </div>
                                            
                                            </div>
                    
                                            <div class="row justify-content-end"> <!-- BOTONES -->
                                                <input type="hidden" id="idRecursoAdicional-A" name ="idRecursoAdicional-A" value="${get_unique_id()}">
                                                <button class="btn btn-oblong btn-outline-primary" type="button" onclick="agregarRecurso()" id="btn-agregarRecurso-A"> Agregar Recurso </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div id="calendario_recursos" class="dhx_cal_container" style='width:100%; height:54vh;'>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="square-10 bkg_rojo rounded-circle"></span>
                                    <span class="mg-l-3 tx-left" style="font-size: 0.8rem;">Evento en edición</span>
                                    
                                    <span class="mg-l-10 square-10 bkg_verde rounded-circle"></span>
                                    <span class="mg-l-3 tx-left" style="font-size: 0.8rem;">Evento de sala</span>
                                </div>
                            </div>
            
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <br>
                                        <table id="table-recursos-audiencia" class="datatable tableDatosSujeto" style="overflow-x: none; display: table; text-align: left;">
                                            <thead>
                                              <tr>
                                                <th class="tx-center" style="background:#f8f9fa" colspan="6" class="tx-center tx-bold">Recursos Adicionales de la Audiencia:</th>
                                              </tr>
                                              <tr>
                                                <th class="tx-center" style="background:#f8f9fa" >#</th>
                                                <th class="tx-center" style="background:#f8f9fa" >Accion</th>
                                                <th class="tx-center" style="background:#f8f9fa" >Recurso</th>
                                                <th class="tx-center" style="background:#f8f9fa" >Horario de uso</th>
                                                <th class="tx-center" style="background:#f8f9fa" >Descripción</th>
                                                <th class="tx-center" style="background:#f8f9fa" >Comentarios</th>
                                              </tr>
                                            </thead>
                                            <tbody style="font-weight: lighter;">
                                              ${trRecursos}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    
                </div>
            `);


            $('#footerEspacio').empty();
            $('#footerEspacio').html(`
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="limpiarEspacioA('#espacioEditarAudiencia')">Cerrar</button>
                <button type="button" class="btn btn-success" onclick="actualizarAudiencia()" id="btn_actualizar_1" style="display:none;background:#848F33 !important; border:none; cursor:pointer;">Actualizar</button>
            `);
            
            $('#carpetaJL_actualizar').html(audiencia.folio_carpeta);

            setTimeout( function(){ loadConfigComponentA(); }, 1000);
            setTimeout( function(){ pintar_eventos( '#sala-A', '#fecha-A'); }, 2000);
            setTimeout( function(){ pintar_eventos_recursos( '#id_tipo_recurso-A', '#id_nombre_recurso-A', '#fechaInicioRecurso-A'); }, 2000);
            setTimeout( function(){ $('#id_tipo_recurso-A').trigger('change'); $('#id_nombre_recurso-A').trigger('change'); }, 1000);
            setTimeout( function(){
                $('#nav-edit-tab').click(function(){
                    $('#btn_actualizar_1').css('display','block');
                });
                $('#nav-edicion-recursos-tab').click(function(){
                    $('#btn_actualizar_1').css('display','block');
                });
                $('#nav-home-tab').click(function(){
                    $('#btn_actualizar_1').css('display','none');
                });
            },1000);

            $('#modal-audiencia').modal('show');

        }

        function limpiarFiltros(){
            $('#idInmueble_c').prop('selectedIndex',0).trigger( "change" );
            $('#idunidad').prop('selectedIndex',0).trigger( "change" );
            $('#tipo_juezSearch').prop('selectedIndex',0).trigger( "change" );
            $('#juezSearch').prop('selectedIndex',0).trigger( "change" );
            $('#tipo_audiencia').prop('selectedIndex',0).trigger( "change" );
            $('#sala_c').prop('selectedIndex',0).trigger( "change" );
            $('#situacion_c').prop('selectedIndex',0).trigger( "change" );

            $('#searchCarpetaJudical').val('');
            $('#searchIdEvento').val('');


            $("#fechaini").datepicker({
                dateFormat: 'dd/mm/yy',
                firstDay: 1
            }).datepicker("setDate", new Date());

            $("#fechafin").datepicker({
                dateFormat: 'dd/mm/yy',
                firstDay: 1
            }).datepicker("setDate", new Date());

        }

        function ordenarPor(obj, tipo){
            var name = $(obj).attr('name');
            var orden = $(obj).attr('orden');
            var campo = $(obj).attr('campo');

            /*
                0 sin orden
                1 Ascendente
                2 Descendente
            */
            
            $( `${tipo == 1 ? 'th' : 'li'}[name="${name}"] > i`).css('color', '#848f33');
            $('.che_orden').each(function(index, check){
                if($(this).val() == campo ){
                    $(this).prop('checked', true);
                }
            });

            if(orden == 1) {
                $( `${tipo == 1 ? 'th' : 'li'}[name="${name}"] > i`).attr('class', 'fas fa-sort-amount-up');
                $(obj).attr('orden', 2);

                ordenamiento[campo] = 1;

                $('.che_orden').each(function(index, check){
                    if($(this).val() == campo ){
                        ordenamiento[$(this).val()] = 1;
                        $(this).attr('orden', 'ASC');
                        $(this).parent().find('select option[value="ASC"]').attr("selected",true);
                    }
                });

                sec_ajax('primera');

            }else{
                $( `${tipo == 1 ? 'th' : 'li'}[name="${name}"] > i`).attr('class', 'fas fa-sort-amount-down');
                $(obj).attr('orden', 1);

                ordenamiento[campo] = 2;

                $('.che_orden').each(function(index, check){
                    if($(this).val() == campo ){
                        ordenamiento[$(this).val()] = 2;
                        $(this).attr('orden', 'DESC');
                        $(this).parent().find('select option[value="DESC"]').attr("selected",true);
                    }
                });
                
                sec_ajax('primera');

            }
            
        }

        function cambiarDireccion(obj){
            var orden = $(obj).val();

            $(obj).parent().find('input[type="checkbox"]').attr('orden', orden);
            
        }

        function aplicarOrden(){
            let orden_th = ['fecha_audiencia', 'hora_inicio_audiencia'];
            $('.che_orden').each(function(index, check){
                if($(this).is(':checked')){
                    ordenamiento[$(this).val()] = $(this).attr('orden') == 'ASC' ? 1 : 2;

                    if(orden_th.includes($(this).val())){ // li
                        $(`li[campo="${$(this).val()}"]`).attr('orden', $(this).attr('orden') == 'ASC' ? 2 : 1);
                        $(`li[campo="${$(this).val()}"] > i`).attr('class', $(this).attr('orden') == 'ASC' ? 'fas fa-sort-amount-up' : 'fas fa-sort-amount-down');
                        $(`li[campo="${$(this).val()}"] > i`).css('color', '#848f33');
                    }else{ // th
                        $(`th[campo="${$(this).val()}"]`).attr('orden', $(this).attr('orden') == 'ASC' ? 2 : 1);
                        $(`th[campo="${$(this).val()}"] > i`).attr('class', $(this).attr('orden') == 'ASC' ? 'fas fa-sort-amount-up' : 'fas fa-sort-amount-down');
                        $(`th[campo="${$(this).val()}"] > i`).css('color', '#848f33');
                    }
                }
            });

            sec_ajax('primera');
        }

        function borrarOrden(){
            $('.che_orden').each(function(index, check){
                if($(this).is(':checked')){
                    ordenamiento[$(this).val()] = 0;
                    $(this).attr('orden', 'ASC');
                }
            });

            let html = `
                <span class="orderby"><i class="fas fa-chevron-down" style="margin: 0 5%;font-size: 0.8em;"></i>Ordenar por </span>
                <ul class="menu_orderby">
                    <li>
                        <label>
                            <div>
                                <input class="che_orden" type="checkbox" value="id_audiencia" orden="ASC">
                                <select onchange="cambiarDireccion(this)">
                                    <option value="ASC">ASC</option>
                                    <option value="DESC">DESC</option>
                                </select>
                            </div>
                            Id Evento 
                        </label>
                    </li>
                    <li>
                        <label>
                            <div>
                                <input class="che_orden" type="checkbox" value="estatus_semaforo" orden="ASC">
                                <select onchange="cambiarDireccion(this)">
                                    <option value="ASC">ASC</option>
                                    <option value="DESC">DESC</option>
                                </select>
                            </div>
                            Situacion Audiencia 
                        </label>
                    </li>
                    <li>
                        <label>
                            <div>
                                <input class="che_orden" type="checkbox" value="folio_carpeta" orden="ASC">
                                <select onchange="cambiarDireccion(this)">
                                    <option value="ASC">ASC</option>
                                    <option value="DESC">DESC</option>
                                </select>
                            </div>
                            Carpeta Judicial 
                        </label>
                    </li>
                    <li>
                        <label>
                            <div>
                                <input class="che_orden" type="checkbox" value="fecha_audiencia" orden="ASC">
                                <select onchange="cambiarDireccion(this)">
                                    <option value="ASC">ASC</option>
                                    <option value="DESC">DESC</option>
                                </select>
                            </div>
                            Fecha Audiencia 
                        </label>
                    </li>
                    <li>
                        <label>
                            <div>
                                <input class="che_orden" type="checkbox" value="hora_inicio_audiencia" orden="ASC">
                                <select onchange="cambiarDireccion(this)">
                                    <option value="ASC">ASC</option>
                                    <option value="DESC">DESC</option>
                                </select>
                            </div>
                            Hora Programada 
                        </label>
                    </li>
                    <li>
                        <label>
                            <div>
                                <input class="che_orden" type="checkbox" value="id_unidad_registro" orden="ASC">
                                <select onchange="cambiarDireccion(this)">
                                    <option value="ASC">ASC</option>
                                    <option value="DESC">DESC</option>
                                </select>
                            </div>
                            Unidad de Gestion 
                        </label>
                    </li>
                    <li>
                        <label>
                            <div>
                                <input class="che_orden" type="checkbox" value="tipo_audiencia" orden="ASC">
                                <select onchange="cambiarDireccion(this)">
                                    <option value="ASC">ASC</option>
                                    <option value="DESC">DESC</option>
                                </select>
                            </div>
                            Tipo de Audiencia 
                        </label>
                    </li>
                    <li>
                        <label>
                            <div>
                                <input class="che_orden" type="checkbox" value="id_inmueble" orden="ASC">
                                <select onchange="cambiarDireccion(this)">
                                    <option value="ASC">ASC</option>
                                    <option value="DESC">DESC</option>
                                </select>
                            </div>
                            Edificio 
                        </label>
                    </li>
                    <li>
                        <label>
                            <div>
                                <input class="che_orden" type="checkbox" value="id_sala" orden="ASC">
                                <select onchange="cambiarDireccion(this)">
                                    <option value="ASC">ASC</option>
                                    <option value="DESC">DESC</option>
                                </select>
                            </div>
                            Sala 
                        </label>
                    </li>
                    <li>
                        <label>
                            <div>
                                <input class="che_orden" type="checkbox" value="id_juez" orden="ASC">
                                <select onchange="cambiarDireccion(this)">
                                    <option value="ASC">ASC</option>
                                    <option value="DESC">DESC</option>
                                </select>
                            </div>
                            Juez 
                        </label>
                    </li>
                    <li><button onclick="aplicarOrden()" style="width: 97%; border: none; background: #848f33; color: #fff;">Aplicar</button></li>
                </ul>
            `;
            
            let tr = `
                <th style="font-size: 0.84em;" class="acciones" name="acciones">Acciones</th>
                <th style="font-size: 0.84em;" class="acciones_notificacion" name="acciones_notificacion">Notificación Majo</th>
                @if( isset($permisos[75]) and $permisos[75] == 1 )
                    <th style="cursor:pointer; font-size: 0.84em;" class="streaming_sala" name="streaming_sala">Streaming</th>
                @endif
                <th style="cursor:pointer; font-size: 0.84em;" class="id_evento" name="id_evento" orden="2" campo="id_audiencia" onclick="ordenarPor(this,1)">ID Evento <i class="fas fa-sort-amount-up" style="margin-left: 5%;"></i></th>
                <th style="cursor:pointer; font-size: 0.84em;" class="situacion_audiencia" name="situacion_audiencia" orden="2" campo="estatus_semaforo" onclick="ordenarPor(this,1)">Situación Audiencia <i class="fas fa-sort-amount-up" style="margin-left: 5%;"></i></th>
                <th style="cursor:pointer; font-size: 0.84em;" class="carpeta_judicial" name="carpeta_judicial" orden="2" campo="folio_carpeta" onclick="ordenarPor(this,1)">Carpeta Judicial <i class="fas fa-sort-amount-up" style="margin-left: 5%;"></i></th>
                <th style="cursor:pointer; font-size: 0.84em;" class="fecha_audiencia"  id="submenu_orden_fecha">
                    Fecha de la Audiencia 
                    <i class="fas fa-chevron-down" style="margin-left: 5%;"></i> 
                    <div class="d-none submenu_context" id="submenu_context_fecha">
                        <ul>
                            <li name="fecha_audiencia" orden="2" campo="fecha_audiencia" onclick="ordenarPor(this,2)">Fecha Audiencia <i class="fas fa-sort-amount-up" style="margin-left: 12%;"></i></li>
                            <li name="hora_programada" orden="2" campo="hora_inicio_audiencia" onclick="ordenarPor(this,2)">Hora Programada <i class="fas fa-sort-amount-up" style="margin-left: 8%;"></i></li>
                        </ul>
                    </div> 
                </th>
                <th style="cursor:pointer; font-size: 0.84em;" class="notificacion_cabina" name="unidad_gestion" orden="2" campo="id_unidad_registro" onclick="ordenarPor(this,1)">Unidad de Gestión <i class="fas fa-sort-amount-up" style="margin-left: 5%;"></i></th>
                <th style="cursor:pointer; font-size: 0.84em;" class="tipo_audiencia" name="tipo_audiencia" orden="2" campo="tipo_audiencia" onclick="ordenarPor(this,1)">Tipo de Audiencia <i class="fas fa-sort-amount-up" style="margin-left: 5%;"></i></th>
                <th style="cursor:pointer; font-size: 0.84em;" class="edificio" name="Edificio" orden="2" campo="id_inmueble" onclick="ordenarPor(this,1)">Edificio <i class="fas fa-sort-amount-up" style="margin-left: 5%;"></i></th>
                <th style="cursor:pointer; font-size: 0.84em;" class="sala" name="Sala" orden="2" campo="id_sala" onclick="ordenarPor(this,1)">Sala <i class="fas fa-sort-amount-up" style="margin-left: 5%;"></i></th>
                <th style="cursor:pointer; font-size: 0.84em;" class="con_recursos_adicionales" name="con_recursos_adicionales">Con recursos adicionales</th>
                <th style="cursor:pointer; font-size: 0.84em;" class="recursos_adicionales" name="recursos_adicionales">Recursos adicionales</th>
                <th style="cursor:pointer; font-size: 0.84em;" class="juez" name="juez" orden="2" campo="id_juez" onclick="ordenarPor(this,1)">Juez <i class="fas fa-sort-amount-up" style="margin-left: 5%;"></i></th>
                <th style="cursor:pointer; font-size: 0.84em; min-width: 180px;" name="Edificio">Centro de Justicia PROMUJER</th>
                <th style="cursor:pointer; font-size: 0.84em;" class="total_imputados" name="total_imputados">Total Imputados</th>
                <th style="cursor:pointer; font-size: 0.84em;" class="imputados" name="imputados">Imputados</th>
                <th style="cursor:pointer; font-size: 0.84em;" class="victimas" name="victimas">Victimas</th>
                <th style="cursor:pointer; font-size: 0.84em;" class="delitos" name="delitos">Delitos</th>
            `;

            $('.selectby').html(html);
            $('#encabezados_audiencias_table').html(tr);
        
            setTimeout(function(){
                $('#submenu_orden_fecha').click(function(){

                    $('#submenu_context_fecha').show("fast",function(){
                        $(this).removeClass('d-none');
                        $(this).addClass('d-block');
                      document.body.addEventListener('click', boxCloser, false);
                    });
                  
                });
            }, 500);

            sec_ajax('primera');
        }

        // ######## Funciones Generales de Audiencia  ##########

        function get_unique_id(){
            var date = new Date();
            return date.getHours()+''+date.getMinutes()+''+date.getSeconds()+''+date.getMilliseconds();;
        }

        function loading(accion){
            if(accion){
              $('#modal_loading').modal('show');
            }else{
              setTimeout(function(){ $('#modal_loading').modal('hide'); }, 500);
            }
        }

        function excusar( tag , tag_select ){
            console.log( tag );
            /*
            if( audiencia_activa.tipo_solicitud_ == 'PRO-MUJER' || audiencia_activa.id_juez_ejecucion != null ){
                if( $(tag).is(':checked') ) $(tag).prop( "checked", false );
                modal_error('Esta carpeta tiene un juez predefinido, para cambiarlo hágalo desde el tablero de carpetas judiciales','modal-audiencia');
                return false;
            }
            */
            if( $(tag).is(':checked') ){
      
              $(".sin_excusar").hide();
              $(".excusado").show();
      
              $.ajax({
                method:'POST',
                url:'/public/obtener_jueces_unidad',
                data:{
                  id_unidad : audiencia_activa.id_unidad_gestion
                },
                success:function(response){
                  console.log( "consulta jueces excusa", response );
                  $(tag_select).empty();
      
                  if( response.status == 100 ){
                    
                    let array_jueces_desordenados = response.response;
      
                    array_jueces_desordenados.sort(function (a, b) {
                      if ( parseInt(a.cve_juez) > parseInt(b.cve_juez) ) {
                        return 1;
                      } 
                      if ( parseInt(a.cve_juez) < parseInt(b.cve_juez) ) {
                        return -1;
                      }
                      return 0;
                    });
      
                    array_jueces_ordenados = array_jueces_desordenados;
                    
                    for( var i in array_jueces_ordenados ){
                      let juez = array_jueces_ordenados[i];
                      console.log(juez);
                      $(tag_select).append(`<option value="${juez.id_usuario}" data-cve="${juez.cve_juez}"> [${juez.cve_juez}] ${juez.nombres??''} ${juez.apellido_paterno??''} ${juez.apellido_materno??''} </option>`);
                    }
                  }else{
                    $(tag_select).append(`<option value="null" data-cve="null" selected}> No se encontró a un juez de ejecucion. </option>` );
                  }
                },
                error : function( errors ){
                  modal_error('Error :'+ errors.message,'modal-audiencia');
                  //modal_error('Error :'+ JSON.stringify(errors),'modal-audiencia');
                }
              });
      
            }else{
              $(".sin_excusar").show();
              $(".excusado").hide();
              return false;
            }
        }

        function strEstatusB(estatus_semaforo, id_carpeta_judicial, id_audiencia, id_unidad){
            var finalizar = '';
            if(id_unidad_sesion == 1 || id_unidad_sesion == 20){
                finalizar =  `
                    <a href="#" class="media ${estatus_semaforo == 'Finalizada' ? 'd-none' : ''}" onclick="estatusAudiencia(${id_carpeta_judicial},${id_audiencia},${id_unidad},'Finalizada')">
                        <div class="media-body">
                          <div>
                            <p> <i class="fa fa-circle tx-finalizada mg-l-5 bkg-tras"></i> Finalizada</p>
                          </div>
                        </div>
                    </a>`;
            }
            
            var strEstatusAA = `
                <div class="dropdown">
                    <a href="#" class="btn btn-outline-${estatus_semaforo=='Confirmada' ? 'success' : ( estatus_semaforo == 'Finalizada' ? 'info' : 'dark' )}" id="dropdown-menu" data-toggle="dropdown" style="width:100%;" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-circle  mg-l-5 bkg-tras ${estatus_semaforo=='Confirmada' ? 'tx-confirmada' : ( estatus_semaforo == 'Finalizada' ? 'tx-finalizada' : 'tx-cancelada' )}"></i>
                        <span> ${estatus_semaforo} </span>
                        <i class="fa fa-angle-down mg-l-5 bkg-tras"></i>
                    </a>
                    <div class="dropdown-menu dropdown-media-list wd-200">
                        <div class="dropdown-menu-header">
                          <label>Seleccione una opción</label>
                        </div><!-- d-flex -->
                        
                        <div class="media-list">
                        
                          <a href="#" class="media ${estatus_semaforo == 'Confirmada' ? 'd-none' : ''}" onclick="estatusAudiencia(${id_carpeta_judicial},${id_audiencia},${id_unidad},'Confirmada')">
                            <div class="media-body">
                              <div>
                                <p> <i class="fa fa-circle tx-confirmada mg-l-5 bkg-tras"></i> Confirmada</p>
                              </div>
                            </div>
                          </a>
                      
                          ${finalizar}
                      
                          <a href="#" class="media ${estatus_semaforo == 'Cancelado' ? 'd-none' : ''}" onclick="estatusAudiencia(${id_carpeta_judicial},${id_audiencia},${id_unidad},'Cancelado')">
                            <div class="media-body">
                              <div>
                                <p> <i class="fa fa-circle tx-cancelada mg-l-5 bkg-tras"></i> Cancelada</p>
                              </div>
                            </div>
                          </a>
                      
                        </div><!-- media-list -->
                    </div><!-- dropdown-menu -->
                </div>
            `;
  
            return strEstatusAA;
        }

        function obtenerTiposJuez(){
            $.ajax({
                type: 'GET',
                url: '/public/ver_catalogo_tipos_usuario',
                data: {
                    palabra_clave:"juez"
                },
                success: function(response) {
                    console.log(response.response)

                    if (response.status == 100) {
                        var datos = response.response;
                        var tipos_jueces = `<option value="0" selected>Seleccionar</option>`;
                        for(i in datos){
                            if(unidades_permitidas_control.includes(id_unidad_sesion)){
                                if(datos[i].id_tipo_usuario == 5 || datos[i].id_tipo_usuario == 14 || datos[i].id_tipo_usuario == 94){
                                    tipos_jueces += `<option value="${datos[i].id_tipo_usuario}">${datos[i].descripcion}</option>`;
                                }
                            }else if(unidades_permitidas_ejecucion.includes(id_unidad_sesion)){
                                if(datos[i].id_tipo_usuario == 15 ){
                                    tipos_jueces += `<option value="${datos[i].id_tipo_usuario}">${datos[i].descripcion}</option>`;
                                }
                            }else{
                                tipos_jueces += `<option value="${datos[i].id_tipo_usuario}">${datos[i].descripcion}</option>`;
                            }
                        }

                        $('#tipo_juezSearch').html(tipos_jueces);

                    } else {
                        $('#tipo_juezSearch').html(`<option value="-" selected>Seleccionar</option>`);
                    }
                }
            });
        }

        function obtenerSalasPrecargadas(){
            var id_inmueble_d = id_inmueble_sesion
                            
            //Recarga salas
            $.ajax({
                type: 'POST',
                url: '/public/obtener_inmueble_salas',
                data: {
                    id_unidad: id_unidad_sesion, 
                    id_inmueble : id_inmueble_d
                },
                success: function(response) {
                    //console.log(response.response)

                    if (response.status == 100) {
                        var datos = response.response;
                        var salas_cargadas = `<option value="" selected>Seleccionar</option>`;

                        for(i in datos){
                            if(datos[i].id_inmueble == id_inmueble_d){
                                salas_cargadas += `<option value="${datos[i].id_sala}">${datos[i].nombre_sala}</option>`;
                            }else if(id_inmueble_d == 0){
                                salas_cargadas += `<option value="${datos[i].id_sala}">${datos[i].nombre_sala}</option>`;
                            }
                        }

                        $('#sala_c').html(salas_cargadas);
                        
                    } else {
                        $('#sala_c').html(`<option value="" selected>Seleccionar</option>`);
                    }
                }
            });
        }

        // **** VALIDADORES 
        function validar_datos_evento( tipo_evento, evento_id ){    
            console.log( "Entra a validacion ", tipo_evento, evento_id );
            if( tipo_evento=='audiencia' ){
      
              if( !$("#sala-A").val() )
              return { status:0 , message:`Debe seleccionar una sala.` }
      
              let horario_inicial = get_date( $("#fecha-A").val(), 'YYYY-MM-DD' ) +' '+ $("#horaInicio-A").val() + ":00" ;
              let horario_final = get_date( $("#fecha-A").val(), 'YYYY-MM-DD' ) +' '+ $("#horaTermino-A").val() + ":00" ;
      
              new_time_inicial = new Date( horario_inicial ).getTime();
              new_time_final = new Date( horario_final ).getTime();
      
              //otros_eventos = scheduler_audiencia.getEvents().filter( x=>x.id != evento_id );
      
              if( new_time_inicial >= new_time_final )
                return {status:0 , message:'La hora de inicio debe ser menor a la hora de termino'};
      
              otras_audiencias = scheduler_audiencia.getEvents().filter( x=>x.id != evento_id );
              console.log(otras_audiencias)
              for( var i in otras_audiencias ){
                otra_audiencia = otras_audiencias[i];
      
                time_inicial_ocupado = new Date( otra_audiencia.start_date ).getTime()-59000;
                time_final_ocupado = new Date( otra_audiencia.end_date ).getTime()+59000;
                console.log('vuelta :' , i);
                
                /*
                if ( 
                    ( time_inicial_ocupado < new_time_inicial && time_final_ocupado > new_time_inicial ) || 
                    (time_inicial_ocupado < time_final_ocupado && time_final_ocupado > time_final_ocupado) || 
                    ( time_inicial_ocupado > new_time_inicial && inicio_t < time_final_ocupado ) || 
                    ( time_inicial_ocupado == new_time_inicial ) || 
                    ( time_final_ocupado == time_final_ocupado ) 
                    
                )*/
                /*
                if(
                    (time_inicial_ocupado < new_time_inicial && time_final_ocupado > new_time_final) ||
                    (time_inicial_ocupado > new_time_inicial && time_final_ocupado < new_time_final) ||
                    (time_inicial_ocupado == new_time_inicial) ||
                    (time_final_ocupado == new_time_final)
                )
                return { "status":0 , "message": 'El horario seleccionado ya no está disponible <br>El horario incial se empalma con otra audiencia<br>Debe dejar al menos un minuto de espacio entre audiencias' } ;
                */
        
                
                if( otra_audiencia.start_date <= horario_inicial && horario_inicial <= otra_audiencia.end_date ){
                    console.log('Entra a primera Validacion')
                    console.log('Hora que quiero', horario_inicial)
                    console.log('Hora que ya esta final', otra_audiencia.end_date)
                    console.log(  time_inicial_ocupado , new_time_inicial ,  time_final_ocupado );

                    return { "status":0 , "message": 'El horario seleccionado ya no está disponible <br>El horario incial se empalma con otra audiencia<br>Debe dejar al menos un minuto de espacio entre audiencias' } ;
                  
                }else if( time_inicial_ocupado <= new_time_final && new_time_final <=time_final_ocupado ){
                  console.log(  time_inicial_ocupado , new_time_final ,  time_final_ocupado );
                  return { "status":0 , "message": 'El horario seleccionado ya no está disponible <br>El horario final se empalma con otra audiencia<br>Debe dejar al menos un minuto de espacio entre audiencias' } ;
                }else if( new_time_inicial <= time_inicial_ocupado && new_time_final >= time_final_ocupado ){
                  console.log(  new_time_inicial, time_inicial_ocupado , time_final_ocupado ,  new_time_final );
                  return { "status":0 , "message": 'El horario seleccionado ya no está disponible <br>El horario seleccionado se empalma con otra audiencia<br>Debe dejar al menos un minuto de espacio entre audiencias' } ;
                }  
                
              }
      
              if( arrRAA.length > 0 ){
                
                for (var i in arrRAA){
                  r = arrRAA[i];
                  if( r.estatus == 0 ) continue;
      
                  let r_time_inicial = new Date( get_date(r.fecha_requerido_inicio) +' '+r.horario_requerido_inicio ).getTime();
                  let r_time_final = new Date( get_date(r.fecha_requerido_fin) +' '+r.horario_requerido_fin ).getTime();
      
                  if( new_time_inicial > r_time_inicial || new_time_final < r_time_final)
                  return { status:0 , message:`El recurso ${r.nombre_recurso} está fuera del horario de la audiencia. <br>Corrígalo para continuar.`   }
                }
      
              }
      
              return {status:100};
            }
      
            else if( tipo_evento =='recurso' ){
              
              let horario_inicial = get_date( $("#fechaInicioRecurso-A").val(), 'YYYY-MM-DD' ) +' '+ $("#horaInicioRecurso-A").val() + ":00" ;
              let horario_final = get_date( $("#fechaFinRecurso-A").val(), 'YYYY-MM-DD' ) +' '+ $("#horaTerminoRecurso-A").val() + ":00" ;
      
              let new_time_inicial = new Date( horario_inicial ).getTime();
              let new_time_final = new Date( horario_final ).getTime();
      
              if( new_time_inicial >= new_time_final )
              return {status:0 , message:'La hora de inicio debe ser menor a la hora de termino'};
      
      
              let horario_inicial_aud = get_date( $("#fecha-A").val(), 'YYYY-MM-DD' ) +' '+ $("#horaInicio-A").val() + ":00" ;
              let horario_final_aud = get_date( $("#fecha-A").val(), 'YYYY-MM-DD' ) +' '+ $("#horaTermino-A").val() + ":00" ;
      
              new_time_inicial_aud = new Date( horario_inicial_aud ).getTime();
              new_time_final_aud = new Date( horario_final_aud ).getTime();
      
              if( ! $("#id_tipo_recurso-A").val() )
              return { status:0 , message:`Debe seleccionar un tipo de recurso<br>Corrígalo para continuar.` };
              
              if( ! $("#id_nombre_recurso-A").val() || $("#id_nombre_recurso-A").val() == null || $("#id_nombre_recurso-A").val()=='null' )
              return { status:0 , message:`Debe seleccionar un recurso<br>Corrígalo para continuar.` };
              
              if( ! $("#fechaInicioRecurso-A").val() || $("#fechaInicioRecurso-A").val() == null || $("#fechaInicioRecurso-A").val()=='null' )
              return { status:0 , message:`Debe ingresar la fecha en que comenzará a usar el recurso <br>Corrígalo para continuar.` };
              
              if( ! $("#fechaFinRecurso-A").val() || $("#fechaFinRecurso-A").val() == null || $("#fechaFinRecurso-A").val()=='null' )
              return { status:0 , message:`Debe ingresar la fecha en que terminará de usar el recurso <br>Corrígalo para continuar.` };
              
              if( ! $("#horaInicioRecurso-A").val() || $("#horaInicioRecurso-A").val() == null || $("#horaInicioRecurso-A").val()=='null' || ($("#horaInicioRecurso-A").val()).length != 5 )
              return { status:0 , message:`Debe ingresar la hora en que comenzará a usar el recurso <br>Asegurese de ingresar la hora en fomato de 24 horas<br> Corrígalo para continuar.` };
              
              if( ! $("#horaTerminoRecurso-A").val() || $("#horaTerminoRecurso-A").val() == null || $("#horaTerminoRecurso-A").val()=='null' || ($("#horaTerminoRecurso-A").val()).length != 5 )
              return { status:0 , message:`Debe ingresar la hora en que terminará de usar el recurso <br>Asegurese de ingresar la hora en fomato de 24 horas<br> Corrígalo para continuar.` };
      
              if( new_time_inicial < new_time_inicial_aud || new_time_final > new_time_final_aud)
              return { status:0 , message:`El recurso ${r.nombre_recurso} está fuera del horario de la audiencia. <br>Corrígalo para continuar.` };
      
      
              otros_recursos = scheduler_recursos.getEvents().filter( x=>x.id != evento_id );
              console.log('Otros Recursos',evento_id,otros_recursos)
              for( var i in otros_recursos ){
                otro_recurso = otros_recursos[i];
      
                time_inicial_ocupado = new Date( otro_recurso.start_date ).getTime();
                time_final_ocupado = new Date( otro_recurso.end_date ).getTime();
                
                console.log('vuelta :' , i);
                console.log(  time_inicial_ocupado , new_time_inicial ,  time_final_ocupado );
                console.log(  time_inicial_ocupado , time_final_ocupado ,  time_final_ocupado );
      
                if( time_inicial_ocupado < new_time_inicial && new_time_inicial <  time_final_ocupado ){
                  console.log(  time_inicial_ocupado , new_time_inicial ,  time_final_ocupado );
                  return { "status":0 , "message": 'El horario seleccionado ya no está disponible <br>El horario incial se empalma con otro recurso<br>Debe dejar al menos un minuto de espacio entre recursos' } ;
                }else if( time_inicial_ocupado < new_time_final && new_time_final <time_final_ocupado ){
                  console.log(  time_inicial_ocupado , new_time_final ,  time_final_ocupado );
                  return { "status":0 , "message": 'El horario seleccionado ya no está disponible <br>El horario final se empalma con otro recurso<br>Debe dejar al menos un minuto de espacio entre recursos' } ;
                }else if( new_time_inicial < time_inicial_ocupado && new_time_final > time_final_ocupado ){
                  console.log(  new_time_inicial, time_inicial_ocupado , time_final_ocupado ,  new_time_final );
                  return { "status":0 , "message": 'El horario seleccionado ya no está disponible <br>El horario seleccionado se empalma con otro recurso<br>Debe dejar al menos un minuto de espacio entre recursos' } ;
                }  
              }
      
              return {status:100};
              
            }
      
        }
      
        function valida_horarios( arr_eventos , new_time_inical, new_time_final ){
            if( new_time_inicial >= new_time_final )
            return {status:0 , message:'La hora de inicio debe ser menor a la hora de termino'};
      
            // revisa si no se emplaman horarios
            
            console.log(arr_eventos)
            for( var i in arr_eventos ){
              otro_evento = arr_eventos[i];
      
              time_inicial_ocupado = new Date( otro_evento.start_date ).getTime()-59000;
              time_final_ocupado = new Date( otro_evento.end_date ).getTime()+59000;
              
              console.log('vuelta :' , i);
      
              if( time_inicial_ocupado <= new_time_inicial && new_time_inicial <=  time_final_ocupado ){
                console.log(  time_inicial_ocupado , new_time_inicial ,  time_final_ocupado );
                return { status:0 , message: `El horario seleccionado ya no está disponible <br>El horario incial se empalma con ${ tipo_evento == 'audiencia' ? 'otra' : 'otro'} ${tipo_evento}<br>Debe dejar al menos un minuto de espacio entre ${tipo_evento}s` } ;
              }else if( time_inicial_ocupado <= new_time_final && new_time_final <=time_final_ocupado ){
                console.log(  time_inicial_ocupado , new_time_final ,  time_final_ocupado );
                return { status:0 , message: `El horario seleccionado ya no está disponible <br>El horario final se empalma con ${ tipo_evento == 'audiencia' ? 'otra' : 'otro'} ${tipo_evento}<br>Debe dejar al menos un minuto de espacio entre ${tipo_evento}s` } ;
              }else if( new_time_inicial <= time_inicial_ocupado && new_time_final >= time_final_ocupado ){
                console.log(  new_time_inicial, time_inicial_ocupado , time_final_ocupado ,  new_time_final );
                return { status:0 , message: `El horario seleccionado ya no está disponible <br>El horario seleccionado se empalma con ${ tipo_evento == 'audiencia' ? 'otra' : 'otro'} ${tipo_evento}<br>Debe dejar al menos un minuto de espacio entre ${tipo_evento}s` } ;
              }  
            }
            return {status:100};
        }


        // **** FUNCIONES DE CONFIGURACION
        function loadConfigComponentA() {
            $('.select-edit').select2({minimumResultsForSearch: ''});
      
            let fecha_actual = new Date();
            $('.datepicker-edit').datepicker({
              showOtherMonths: true,
              selectOtherMonths: true,
              format: 'dd-mm-yyyy',
              changeYear: true,
              yearRange: "c-100:" + (fecha_actual.getFullYear()+5)
            });

            $('.datepicker-edit').on('change', function(){
                $( this ).val( get_date( $( this ).val() , 'DD-MM-YYYY' ) );
            });

            if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
                console.log('Esto es un dispositivo móvil');
                $('.time-edit-A').attr('type','time');
            }else{
                $('.clockpicker-A').clockpicker();
            }
            
            //$('.time-edit-A').timepicker({show2400:true,timeFormat:'G:i'});
      
            scheduler_audiencia  = Scheduler.getSchedulerInstance();// Scheduler.getSchedulerInstance();
            scheduler_recursos  = Scheduler.getSchedulerInstance();// Scheduler.getSchedulerInstance();
      
            scheduler_audiencia.config.header = [ "date",];
            scheduler_recursos.config.header = [ "date",];
      
            scheduler_audiencia.attachEvent("onDblClick", function(){ return false; });
            scheduler_recursos.attachEvent("onDblClick", function(){ return false; });
      
                  scheduler_audiencia.attachEvent("onClick",function(id, e){ return false; });
                  scheduler_recursos.attachEvent("onClick",function(id, e){ return false; });
      
            scheduler_audiencia.config.dblclick_create = false;
            scheduler_audiencia.config.details_on_dblclick = true;
      
            scheduler_recursos.config.dblclick_create = false;
            scheduler_recursos.config.details_on_dblclick = true;
      
            scheduler_recursos.config.drag_resize = false;
            scheduler_recursos.config.drag_move = false;
            scheduler_recursos.config.drag_create = false;
            
            scheduler_audiencia.config.drag_resize = false;
            scheduler_audiencia.config.drag_move = false;
            scheduler_audiencia.config.drag_create = false;
      
            //scheduler_audiencia.config.hour_size_px = 88;
            //scheduler_recursos.config.hour_size_px = 88;
      
            scheduler_audiencia.config.first_hour = 0;
            scheduler_audiencia.config.last_hour = 24;
            scheduler_audiencia.config.hour_size_px = 176;
      
            scheduler_recursos.config.first_hour = 0;
            scheduler_recursos.config.last_hour = 24;
            scheduler_recursos.config.hour_size_px = 176;
      
            var format_audiencia = scheduler_audiencia.date.date_to_str("%H:%i");
            scheduler_audiencia.templates.hour_scale = function(date){
              var step = 15;
              var html = "";
              for (var i=0; i<60/step; i++){
                html += "<div style='height:44px;line-height:44px;'>"+format_audiencia(date)+"</div>";
                date = scheduler_audiencia.date.add(date, step, "minute");
              }
              return html;
            }
           
            var format_recurso = scheduler_recursos.date.date_to_str("%H:%i");
            scheduler_recursos.templates.hour_scale = function(date){
              var step = 15;
              var html = "";
              for (var i=0; i<60/step; i++){
                html += "<div style='height:44px;line-height:44px;'>"+format_recurso(date)+"</div>";
                date = scheduler_recursos.date.add(date, step, "minute");
              }
              return html;
            }
            
            scheduler_audiencia.config.separate_short_events = true;
            scheduler_recursos.config.separate_short_events = true;
      
            scheduler_audiencia.templates.event_class = function(start,end,ev){
              return "event_bkg_"+ev.color;
            };
      
            scheduler_recursos.templates.event_class = function(start,end,ev){
              return "event_bkg_"+ev.color;
            };
      
            scheduler_audiencia.init('calendario_audiencias',new Date(),"day");
            scheduler_recursos.init('calendario_recursos',new Date(),"day");
        }

        function limpiarEspacioA( tag ){
            $( tag ).empty();
        }

        // *** RECURSOS ADICIONALES
        async function refrescar_recursos( id_tipo_recurso, tag ){
            let recursos = await obtener_recursos_hijos(id_tipo_recurso);

            let str_optionNR = ``;

            if( recursos.status==100 ){
                if( typeof recursos.response === 'string' || (recursos.response).length == 0 || (recursos.response[0].recursos).length == 0 ) str_optionNR = str_optionNR + `<option value="null" disabeld selected > No hay recursos de este tipo </option>`;
                else{
                for ( var i in recursos.response[0].recursos ){
                    r = recursos.response[0].recursos[i];
                    str_optionNR = str_optionNR + `<option value="${r.id_recurso_audiencia}"> ${r.nombre_recurso} </option> `;
                }
                }
            }else{
                str_optionNR = str_optionNR + `<option value="null" disabeld selected > Error al obtener tipo de recursos </option>`;
            }

            $( tag ).empty();
            $( tag ).append( str_optionNR );

            pintar_eventos_recursos( '#id_tipo_recurso-A' , tag ,"#fechaInicioRecurso-A" );
            return true;
        }

        function pintar_eventos_recursos( tag_recurso, tag_nombre_recurso ,tag_fecha ){
          if( scheduler_recursos.getEvents().length > 0 ) scheduler_recursos.clearAll();
          if( $( tag_recurso ).val() != 'null' && $( tag_nombre_recurso ).val() != 'null' && $(tag_fecha).val() ){
            obtener_eventos_recursos( $(tag_recurso).val() , $(tag_nombre_recurso).val() , get_date( $(tag_fecha).val() ) );
            redimensiona_evento_recurso( "#idRecursoAdicional-A" );
          }
          else 
            return false;
        }
 
        function obtener_eventos_recursos( tipo_recurso, nombre_recurso , fecha ){
          $.ajax({
            method:'POST',
            url:'/public/obtener_horarios_recursos',
            data:{ fecha, tipo_recurso, nombre_recurso },
            success:function(response){
              console.log( "consulta recursos", response );
              if( response.status == 100 ){
                let eventos = [];
                for(var i in response.response){
                  evento = response.response[i];
                  eventos.push({
                    id: evento.id_recurso,
                    text: evento.tipo_recurso+': '+evento.nombre_recurso,
                    start_date: new Date( evento.fecha_requerido_inicio+' '+evento.horario_requerido_inicio ),
                    end_date: new Date( evento.fecha_requerido_fin+' '+evento.horario_requerido_fin ),
                    color: evento.id_recurso == $("#idRecursoAdicional-A").val() ? 'rojo' : 'verde',
                  });
                }
                scheduler_recursos.parse(eventos);

                if( (arrRAA).length > 0 ){
                  let temp_arrRAA = arrRAA.filter( function( x ){ if (x.id_tipo_recurso == tipo_recurso && x.id_nombre_recurso == nombre_recurso ) return x; });
                  if ( (temp_arrRAA).length > 0 ){
                    for( var i in temp_arrRAA ){
                      let evento = temp_arrRAA[i];
                    
                      if( scheduler_recursos.getEvent(evento.id_recurso) != undefined ){
                    
                        scheduler_recursos.getEvent(evento.id_recurso).color = evento.id_recurso == $("#idRecursoAdicional-A").val() ? 'rojo' : 'verde';
                        scheduler_recursos.getEvent(evento.id_recurso).start_date = new Date(  evento.fecha_requerido_inicio + " " + evento.horario_requerido_inicio );
                        scheduler_recursos.getEvent(evento.id_recurso).end_date =   new Date( evento.fecha_requerido_fin + " " + evento.horario_requerido_fin );
                        scheduler_recursos.getEvent(evento.id_recurso).text = evento.descripcion + ": " + evento.nombre_recurso;
                        scheduler_recursos.getEvent(evento.id_recurso).id =  evento.id_recurso;
                        scheduler_recursos.updateEvent( evento.id_recurso );

                      }else{

                        scheduler_recursos.addEvent({
                          color: evento.id_recurso == $("#idRecursoAdicional-A").val() ? 'rojo' : 'verde',
                          start_date: new Date(  evento.fecha_requerido_inicio + " " + evento.horario_requerido_inicio ),
                          end_date:   new Date( evento.fecha_requerido_fin + " " + evento.horario_requerido_fin ),
                          text: evento.descripcion + ": " + evento.nombre_recurso,
                          id : evento.id_recurso
                        });

                      }

                    }
                  }
                }
              }
              //revolse( response );
            },
            error : function( errors ){
              modal_error('Error :'+errors,'modal-audiencia');
              //revolse( {status:0, message:'Error al consumir servicio consulta audiencias'} );
            }
          });
          scheduler_recursos.setCurrentView(new Date( fecha+" 08:00:00" ));
        }

        function agregarRecurso( indexRA=null ){

            let validador = validar_datos_evento('recurso', $("#idRecursoAdicional-A").val() );
            if( validador.status != 100){
              modal_error(validador.message, 'modal-audiencia');
              return false;
            }
      
            if( indexRA == null ){
      
              scheduler_recursos.getEvent($("#idRecursoAdicional-A").val()).color = 'verde';
              scheduler_recursos.updateEvent($("#idRecursoAdicional-A").val());
      
              arrRAA.push({
                //id_recurso : '0',
                id_recurso : $("#idRecursoAdicional-A").val(),
                id_tipo_recurso : $("#id_tipo_recurso-A").val(),
                descripcion : $("#id_tipo_recurso-A option:selected").text(),
                id_nombre_recurso : $("#id_nombre_recurso-A").val(),
                nombre_recurso : $("#id_nombre_recurso-A option:selected").text(),
                fecha_requerido_inicio : get_date( $("#fechaInicioRecurso-A").val() ),
                fecha_requerido_fin : get_date( $("#fechaFinRecurso-A").val() ),
                horario_requerido_inicio : $("#horaInicioRecurso-A").val()+':00',
                horario_requerido_fin : $("#horaTerminoRecurso-A").val()+':00',
                comentarios_recurso : $("#comentariosRecurso-A").val(),
                estatus : 1,
                storage : 0,
              });
              //$("idRecursoAdicional-A").val(get_unique_id());
            }else{
      
              scheduler_recursos.getEvent( arrRAA[indexRA].id_recurso ).color = 'verde';
              scheduler_recursos.updateEvent( arrRAA[indexRA].id_recurso );
      
              arrRAA[indexRA].id_tipo_recurso = $("#id_tipo_recurso-A").val();
              arrRAA[indexRA].descripcion = $("#id_tipo_recurso-A option:selected").text();
              arrRAA[indexRA].id_nombre_recurso = $("#id_nombre_recurso-A").val();
              arrRAA[indexRA].nombre_recurso = $("#id_nombre_recurso-A option:selected").text();
              arrRAA[indexRA].fecha_requerido_inicio = get_date( $("#fechaInicioRecurso-A").val() );
              arrRAA[indexRA].fecha_requerido_fin = get_date( $("#fechaFinRecurso-A").val() );
              arrRAA[indexRA].horario_requerido_inicio = $("#horaInicioRecurso-A").val()+':00';
              arrRAA[indexRA].horario_requerido_fin = $("#horaTerminoRecurso-A").val()+':00';
              arrRAA[indexRA].comentarios_recurso = $("#comentariosRecurso-A").val();
              //$("idRecursoAdicional-A").val(get_unique_id());
            }
            let id = get_unique_id();
            console.log('Nueno ID Recurso', id);
            $("#idRecursoAdicional-A").val(id);
            $("#comentariosRecurso-A").val('');
            
            $("#btn-agregarRecurso-A").text('Agregar Recurso');
            $("#btn-agregarRecurso-A").attr('onclick','agregarRecurso()');
      
            pintarRecursos();
      
        }

        function pintarRecursos(){
            $("#table-recursos-audiencia tbody tr").remove();
            for( var i in arrRAA){
              let r = arrRAA[i];
              console.log(r);
              let btnEdit = `<i class="fas fa-edit" data-toggle="tooltip-primary" data-placement="top" title="Editar Recurso" onclick="editarRecurso(${i})"></i>`;
              let btnDelete = `<i class="fas ${r.estatus == 1 ? 'fa-trash' : 'fa-trash-restore-alt'} " data-toggle="tooltip-primary" data-placement="top" title="Quitar Recurso" onclick="estatusRecurso(${i})"></i>`;

              $("#table-recursos-audiencia tbody").append(`
                <tr>
                  <td>${ parseInt( i ) + 1}</td>
                  <td> ${ btnDelete } ${  btnEdit } </td>
                  <td>${ r.nombre_recurso }</td>
                  <td>Del ${ r.fecha_requerido_inicio} a las ${r.horario_requerido_inicio.substring(0,5)} hrs. <br>hasta el ${r.fecha_requerido_fin} a las ${r.horario_requerido_fin.substring(0,5)} hrs.</td>
                  <td>${ r.descripcion != null ?  r.descripcion : ''}</td>
                  <td>${ r.comentarios_recurso != null ? r.comentarios_recurso : '' }</td>
                </tr>
              `);
            }
        }

        function editarRecurso( indexRA ){
          let r = arrRAA[ indexRA ];
          //console.log( r , arrRAA[ indexRA ] , indexRA  );
          $("#idRecursoAdicional-A").val( r.id_recurso );
          $("#id_tipo_recurso-A").val( r.id_tipo_recurso ).trigger('change');
          $("#fechaInicioRecurso-A").val( r.fecha_requerido_inicio );
          $("#fechaFinRecurso-A").val( r.fecha_requerido_fin );
          $("#horaInicioRecurso-A").val( r.horario_requerido_inicio.substring(0,5) );
          $("#horaTerminoRecurso-A").val( r.horario_requerido_fin.substring(0,5) );
          $("#comentariosRecurso-A").val( r.comentarios_recurso );

          $("#btn-agregarRecurso-A").attr('onclick', `agregarRecurso(${indexRA})`);
          $("#btn-agregarRecurso-A").text('Actualizar Recurso');

          setTimeout( function(){ 
            //console.log($("#id_nombre_recurso-A").val() , r.id_nombre_recurso, r );
            if( parseInt($("#id_nombre_recurso-A").val()) != parseInt(r.id_nombre_recurso) ){
              $("#id_nombre_recurso-A").val( parseInt(r.id_nombre_recurso) ).trigger('change'); 
              //console.log('entro es distinto');
            }
          },3000);
        }

        function estatusRecurso( indexRA ){

          if( arrRAA[indexRA].estatus == 1 ){
            scheduler_recursos.deleteEvent(arrRAA[indexRA].id_recurso);
            redimensiona_evento_recurso( "#idRecursoAdicional-A" );
          }else{
            scheduler_recursos.addEvent({
                comentarios_recurso: arrRAA[indexRA].comentarios_recurso,
                descripcion: arrRAA[indexRA].descripcion,
                estatus: 1,
                fecha_requerido_fin: arrRAA[indexRA].fecha_requerido_fin,
                fecha_requerido_inicio: arrRAA[indexRA].fecha_requerido_inicio,
                horario_requerido_fin: arrRAA[indexRA].horario_requerido_fin,
                horario_requerido_inicio: arrRAA[indexRA].horario_requerido_inicio,
                id_nombre_recurso: arrRAA[indexRA].id_nombre_recurso,
                id_recurso: arrRAA[indexRA].id_recurso,
                id_tipo_recurso: arrRAA[indexRA].id_tipo_recurso,
                nombre_recurso: arrRAA[indexRA].nombre_recurso,
                storage: 0
            });
            redimensiona_evento_recurso( "#idRecursoAdicional-A" );
          }

          if( arrRAA[indexRA].storage == 1) arrRAA[indexRA].estatus = arrRAA[indexRA].estatus == 1 ? 0 : 1;
          else{
            let arrRAA_clean = [];
            for( var i in arrRAA ){
              if( i == indexRA ) continue;
              else arrRAA_clean.push( arrRAA[i] ); 
            }
            arrRAA = arrRAA_clean;
          }

          pintarRecursos();
        }

        // **** EVENTOS DE AUDIENCIA
        async function refrescar_salas( id_inmueble, tag){

          console.log("refresca salas:", id_inmueble, tag);

          let salas = await obtener_salas( id_inmueble );
          let strOptionS = ``;

          if( salas.status == 100 ){
            if( (salas.response).length == 0 ) strOptionS = strOptionS + `<option value="null" disabeld selected > No tiene permiso para usar las salas de este inmueble </option>`;
            for( var i in salas = salas.response){
              strOptionS = strOptionS + `<option value="${salas[i].id_sala}"> ${salas[i].nombre_sala} </option>`;
            }
          }

          $( tag ).empty();
          $( tag ).append( strOptionS );

          pintar_eventos( tag , '#fecha-A' );
        }

        function pintar_eventos( tag_sala , tag_fecha ){
          if( scheduler_audiencia.getEvents().length > 0) scheduler_audiencia.clearAll();
          if( $(tag_sala).val() != 'null' && $(tag_fecha).val() ){
            obtener_eventos( $(tag_sala).val() , get_date( $(tag_fecha).val() ) );
            redimensiona_evento_audiencia( $( "#id_audiencia" ).val() );
          }
          else
            return false;
        }

        function obtener_eventos( id_sala, fecha ){
            $.ajax({
                method:'GET',
                url:'/public/consultar_audiencias',
                data:{
                id_sala:id_sala,
                fecha_ini : fecha,
                fecha_fin : fecha,
            },
            success:function(response){
                console.log( "consulta eventos audiencia", response );
                if( response.status == 100 ){
                let eventos = [];
                for(var i in response.response){
                    evento = response.response[i];
                    if( evento.estatus_semaforo == 'Cancelado' 
                    || evento.estatus_audiencia == 'Cancelado' 
                    || evento.estatus_audiencia == 'Cancelada' 
                    || evento.estatus_semaforo == 'cancelada' ) continue;
                    eventos.push({
                        id: evento.id_audiencia,
                        text: evento.id_unidad == audiencia_activa.id_unidad_gestion ? evento.tipo_audiencia : 'Ocupado por la audiencia: '+evento.id_audiencia,
                        start_date: new Date( evento.fecha_audiencia+' '+evento.hora_inicio_audiencia ),
                        end_date: new Date( evento.fecha_audiencia+' '+evento.hora_fin_audiencia ),
                        color: (evento.id_audiencia == $("#id_audiencia").val() ? 'rojo' : 'verde')
                    });
                }
                scheduler_audiencia.parse(eventos);
                }
                //revolse( response );
            },
            error : function( errors ){
                modal_error('Error :'+errors,'modal-audiencia');
                //revolse( {status:0, message:'Error al consumir servicio consulta audiencias'} );
            }
            });
            scheduler_audiencia.setCurrentView(new Date( fecha+" 08:00:00" ));
            obtener_incidencias( id_sala, fecha, fecha );
        }

        function obtener_incidencias( id_sala ,  fecha_desde, fecha_hasta ){
            $.ajax({
              method:'POST',
              url:'/public/obtener_incidencias_cj',
              data:{
                id_sala,
                fecha_desde : fecha_desde,
                fecha_hasta : fecha_hasta,
              },
              success:function(response){
                console.log( "consulta incidencias", response );
                if( response.status == 100 && response.response_pag.registros_totales > 0 ){
                  let eventos = [];
                  for(var i in response.response){
                    evento = response.response[i];
                    for(var j in evento.unidades){
                      if( evento.unidades[j].id_unidad_gestion == audiencia_activa.id_unidad ){
                        scheduler_audiencia.addEvent({
                          id: evento.id_incidencia_sala,
                          text: 'Ocupado (Incidencia)',
                          start_date: new Date( evento.fecha_desde ),
                          end_date: new Date( evento.fecha_hasta ),
                          color: 'verde'
                        }); 
                        eventos.push();
                      }
                    }
                  }
                }
              },
              error : function( errors ){
                modal_error('Error :'+errors,'modal-audiencia');
              }
            });
        }

        function poner_hora_termino(){
          let fecha_audiencia = get_date( $("#fecha-A").val() , 'YYYY-MM-DD' );
          let hora = $("#horaInicio-A").val()
          let hora_final = get_time( alter_time( fecha_audiencia+' '+hora+':00' , '+' , '2' , 'h' ) , 'HH:mm');
          console.log( fecha_audiencia,hora,hora_final );
          $("#horaTermino-A").val( hora_final );
          $("#horaInicioRecurso-A").val( hora );
          $("#horaTerminoRecurso-A").val( hora_final );
          redimensiona_evento_audiencia( $("#id_audiencia").val() );
        }

        function poner_hora_termino_recurso(){
            let fecha_audiencia = get_date( $("#fecha-A").val() , 'YYYY-MM-DD' );
            let hora = $("#horaTermino-A").val()
            hora = get_time( alter_time( fecha_audiencia+' '+hora+':00' , '+' , '0' , 'h' ) , 'HH:mm');
      
            $("#horaTerminoRecurso-A").val( hora );
            //redimensiona_evento_recurso( $("#id_recurso").val() );
        }

        function redimensiona_evento_audiencia( id_evento ){

          if( !$( "#sala-A" ).val()  
              || !$( "#tipoAudiencia-A" ).val() 
              || !$( "#fecha-A" ).val() 
              || !$( "#horaInicio-A" ).val() 
              || !$( "#horaTermino-A" ).val() 
            )
          return false;
        
          if( ($( "#horaInicio-A" ).val()).length != 5 ||  ($( "#horaTermino-A" ).val()).length != 5)
          return false;

          if( new Date( get_date( $( "#fecha-A" ).val() ) + " " + $( "#horaInicio-A" ).val() + ":00" ).getTime() >= new Date( get_date( $( "#fecha-A" ).val() ) + " " + $( "#horaTermino-A" ).val() + ":00" ).getTime())
          return false;
        
          poner_hora_termino_recurso();

          id_evento =  isNaN(id_evento) ? $(id_evento).val() : id_evento;

          scheduler_audiencia.deleteEvent(id_evento);

          setTimeout( function(){ 
            scheduler_audiencia.addEvent({
              color: 'rojo',
              start_date: new Date( get_date( $( "#fecha-A" ).val() ) + " " + $( "#horaInicio-A" ).val() + ":00" ),
              end_date:   new Date( get_date( $( "#fecha-A" ).val() ) + " " + $( "#horaTermino-A" ).val() + ":00" ),
              text:  $( "#tipoAudiencia-A option:selected" ).text() ,
              id : id_evento,
            }); 
          }, 1000);
        }

        function redimensiona_evento_recurso( tag_id_evento_recurso ){
          //console.log("entratrase a redimensiona_evento_recurso ", tag_id_evento_recurso)
          if( !$( "#id_tipo_recurso-A" ).val()  
              || !$( "#id_nombre_recurso-A" ).val() 
              || !$( "#fechaInicioRecurso-A" ).val() 
              || !$( "#fechaFinRecurso-A" ).val() 
              || !$( "#horaInicioRecurso-A" ).val() 
              || !$( "#horaTerminoRecurso-A" ).val() 
            )
          return false;

          if( ($( "#horaInicioRecurso-A" ).val()).length != 5 ||  ($( "#horaTerminoRecurso-A" ).val()).length != 5)
          return false;

          //console.log("pasaste as validaciones de redimensiona_evento_recurso")

          let id_evento_recurso = $(tag_id_evento_recurso).val();
          console.log(id_evento_recurso);
          //scheduler_recursos.deleteEvent(id_evento_recurso);

          setTimeout( function(){ 
            //console.log("Añade evento")
            scheduler_recursos.addEvent({
              color: 'rojo',
              start_date: new Date( get_date( $( "#fechaInicioRecurso-A" ).val() ) + " " + $( "#horaInicioRecurso-A" ).val() + ":00" ),
              end_date:   new Date( get_date( $( "#fechaFinRecurso-A" ).val() ) + " " + $( "#horaTerminoRecurso-A" ).val() + ":00" ),
              text:  $( "#id_tipo_recurso-A option:selected" ).text()+': '+$( "#id_nombre_recurso-A option:selected" ).text() ,
              id : id_evento_recurso,
            }); 
          }, 1000);

        }

        function mostrar_juez_tramite( tag , tag_select ){
            console.log( tag );

            if( audiencia_activa.tipo_solicitud_ == 'PRO-MUJER' || audiencia_activa.id_juez_ejecucion != null ){
                if( $(tag).is(':checked') ) $(tag).prop( "checked", false );
                modal_error('Esta carpeta tiene un juez predefinido, para cambiarlo hágalo desde el tablero de carpetas judiciales','modal-audiencia');
                return false;
            }

            if( $(tag).is(':checked') ){
      
              $(".no_juez_tramite").hide();
              $(".juez_tramite").show();
      
              $.ajax({
                method:'POST',
                url:'/public/obtener_juez_tramite',
                data:{
                  id_unidad : audiencia_activa.id_unidad_gestion
                },
                success:function(response){
                  console.log( "consulta jueces excusa", response );
                  $(tag_select).empty();
      
                  if( response.status == 100 ){
                    for( var i in response.response ){
                      let juez = response.response[i];
                      console.log(juez);
                      $(tag_select).append(`<option value="${juez.id_usuario}" data-cve="${juez.cve_juez}"> ${juez.nombres??''} ${juez.apellido_paterno??''} ${juez.apellido_materno??''} </option>`);
                    }
                  }else{
                    $(tag_select).append(`<option value="null" data-cve="null" selected}> No se encontró a un juez de tramite. </option>` );
                  }
                },
                error : function( errors ){
                  modal_error('Error :'+ errors.message,'modal-audiencia');
                }
              });
      
            }else{
              $(".no_juez_tramite").show();
              $(".juez_tramite").hide();
              return false;
            }
        }


        //  *** PROMESAS ****
        function obtener_salas(id_inmueble=null){
            return new Promise(resolve => {
              $.ajax({
                method:'POST',
                url:'/public/obtener_inmueble_salas',
                data:{ id_unidad:audiencia_activa.id_unidad_gestion, id_inmueble : id_inmueble  },
                success:function(response){
                  console.log('salas',response);
                  resolve(response);
                },
                error : function( errors ){
                  modal_error('Error :'+errors,'modal-audiencia');
                  resolve( {status:0, message:'Error al consumir servicio inmueble salas'} ) ;
                }
              });
      
            });
        }

        function obtener_recursos_hijos( id_tipo_recurso ){
          return new Promise(resolve => {
            $.ajax({
              method:'POST',
              url:'/public/obtener_nombre_tipos_recursos',
              data:{ id_tipo_recurso },
              success:function(response){
                console.log('nombre recursos' ,response);
                resolve(response);
              },
              error : function( errors ){
                modal_error('Error :'+errors,'modal-audiencia');
                resolve( {status:0, message:'Error al consumir servicio nombre recursos'} ) ;
              }
            });

          });
        }

        function obtener_jueces( tipo = 'sig_control' ){
            return new Promise(resolve => {
      
              let ruta = '';
              if(tipo=='ejecucion') ruta = 'obtener_jueces_ejecucion';
              if(tipo=='tramite') ruta = 'obtener_juez_tramite';
              if(tipo=='control_ejecucion') ruta = 'obtener_jueces_unidad';
              if(tipo=='sig_control'){
                ruta = 'obtener_siguiente_juez_control';
      
                if( audiencia_activa.tipo_solicitud_ == 'PRO-MUJER'){
                  resolve({
                    status:100,
                    response:{
                      cv_juez: audiencia_activa.cve_juez_promujer,
                      id_usuario: audiencia_activa.id_juez_promujer,
                      nombre: audiencia_activa.juez.nombre_usuario
                    }
                  });
                  return false;
                }
                else if( audiencia_activa.id_juez_ejecucion != null ){
                  resolve({
                    status:100,
                    response:{
                      cv_juez: audiencia_activa.cve_juez_ejecucion,
                      id_usuario: audiencia_activa.id_juez_ejecucion,
                      nombre: audiencia_activa.juez.nombre_usuario
                    }
                  });
                  return false;
                }
               
              }

              $.ajax({
                method:'POST',
                url:'/public/'+ruta,
                async: false,
                data:{ id_unidad:audiencia_activa.id_unidad_gestion, uga:audiencia_activa.id_unidad_gestion },
                success:function(response){
                  console.log(response);
                  resolve(response);
                },
                error : function( errors ){
                  modal_error('Error :'+errors,'modal-audiencia');
                  revolse( {status:0, message:'Error al consumir servicio jueces '+tipo} );
                }
              });
            });
        }


        // ###### Funciones de Accion ##########

        //  **** FECHAS  *** 
        function get_time( time , format = 'HH:mm' ){
            let time_return = '';
            if( time.length > 8 ) time_return = time.split(' ')[1].substring(0,5); 
            else time_return = time.substring(0,5);
      
            time_return = time_return.split(':')[0].padStart(2,'0')+':'+time_return.split(':')[1].padStart(2,'0');
      
            return time_return;
        }

        function alter_time( date = new Date() , action = '+' , time = '1' , type_time = 's' ){
            console.log( date );
            date = new Date( date ); 
            switch( type_time ){
              case 's' : time = time * 1000 ; break;
              case 'm' : time = time * 60 * 1000 ; break;
              case 'h' : time = time * 60 * 60 * 1000 ; break;
              case 'd' : time = time * 24 * 60 * 60 * 1000 ; break;
              default : time = time; break ;
            }
            //console.log(time);
            //console.log( date.getTime() );
      
            if( action == '+' || action == 'add' || action == true )  date = new Date( date.getTime() + time );
            else if( action == '-' || action == 'sub' || action == false ) date = new Date( date.getTime() - time );
            //console.log(date);
            return date.toLocaleDateString()+' '+date.toLocaleTimeString();
        }

        function get_date( date , format = 'YYYY-MM-DD' ){
            date = date.replaceAll("/","-");
            
            if( format == 'YYYY-MM-DD' && date.substring(0,4).includes('-') ) 
              return date.split('-').reverse().join('-');
            if( format == 'DD-MM-YYYY' && !date.substring(0,4).includes('-') )
              return date.split('-').reverse().join('-');
            if( format == 'YYYY-MM-DD' && date.substring(0,4).includes('/') ) 
              return date.split('/').reverse().join('-');
            if( format == 'DD-MM-YYYY' && !date.substring(0,4).includes('/') )
              return date.split('/').reverse().join('-');
            else
              return date;
        }

        //EXPORTAR CONSULTA
        function descargar_consulta() { 
            $('#modal_loading').modal('show');
                

            fechaini =  $('#fechaini').val().split('/').reverse().join('-');
            fechafin =  $('#fechafin').val().split('/').reverse().join('-');    

            console.log('id_universal',id_unidad_sesion);
            if(id_unidad_sesion == 0){
                uni = '-';
            }else{
                uni = id_unidad_sesion;
            }

            if($("#idunidad").length > 0){

                if($("#idunidad").val().length > 0){
                    uni = $("#idunidad").val();
                }
            }

            cj = $('#searchCarpetaJudical').val() == '' ? '-' : $('#searchCarpetaJudical').val(); 

            tipo_juezSearch = $('#tipo_juezSearch').val() == 0 ? '-' : $('#tipo_juezSearch').val();
            juezSearch = $('#juezSearch').val()
            tipo_audiencia = $('#tipo_audiencia').val();
            id_audiencia  = $('#searchIdEvento').val();
            id_inmueble = $('#idInmueble_c').val();
            id_sala =  $('#sala_c').val();
            situacion_c = $('#situacion_c').val();
            
            order = [];

            ordenamiento.id_audiencia != 0 ? (ordenamiento.id_audiencia == 1 ?  order.push({"campo":"id_audiencia", "sentido":"ASC"}) : order.push({"campo":"id_audiencia", "sentido":"DESC"}) ) : '';
            ordenamiento.estatus_semaforo != 0 ? (ordenamiento.estatus_semaforo == 1 ?  order.push({"campo":"estatus_semaforo", "sentido":"ASC"}) : order.push({"campo":"estatus_semaforo", "sentido":"DESC"}) ) : '';
            ordenamiento.folio_carpeta != 0 ? (ordenamiento.folio_carpeta == 1 ?  order.push({"campo":"folio_carpeta", "sentido":"ASC"}) : order.push({"campo":"folio_carpeta", "sentido":"DESC"}) ) : '';
            ordenamiento.fecha_audiencia != 0 ? (ordenamiento.fecha_audiencia == 1 ?  order.push({"campo":"fecha_audiencia", "sentido":"ASC"}) : order.push({"campo":"fecha_audiencia", "sentido":"DESC"}) ) : '';
            ordenamiento.hora_inicio_audiencia != 0 ? (ordenamiento.hora_inicio_audiencia == 1 ?  order.push({"campo":"hora_inicio_audiencia", "sentido":"ASC"}) : order.push({"campo":"hora_inicio_audiencia", "sentido":"DESC"}) ) : '';
            ordenamiento.id_unidad_registro != 0 ? (ordenamiento.id_unidad_registro == 1 ?  order.push({"campo":"id_unidad_registro", "sentido":"ASC"}) : order.push({"campo":"id_unidad_registro", "sentido":"DESC"}) ) : '';
            ordenamiento.tipo_audiencia != 0 ? (ordenamiento.tipo_audiencia == 1 ?  order.push({"campo":"tipo_audiencia", "sentido":"ASC"}) : order.push({"campo":"tipo_audiencia", "sentido":"DESC"}) ) : '';
            ordenamiento.id_inmueble != 0 ? (ordenamiento.id_inmueble == 1 ?  order.push({"campo":"id_inmueble", "sentido":"ASC"}) : order.push({"campo":"id_inmueble", "sentido":"DESC"}) ) : '';
            ordenamiento.id_sala != 0 ? (ordenamiento.id_sala == 1 ?  order.push({"campo":"id_sala", "sentido":"ASC"}) : order.push({"campo":"id_sala", "sentido":"DESC"}) ) : '';
            ordenamiento.id_juez != 0 ? (ordenamiento.id_juez == 1 ?  order.push({"campo":"id_juez", "sentido":"ASC"}) : order.push({"campo":"id_juez", "sentido":"DESC"}) ) : '';

            var data = {          
                id_unidad_gestion: uni,
                fecha_ini: fechaini,
                fecha_fin: fechafin,
                cj:cj,
                tipo_juezSearch:tipo_juezSearch,
                juezSearch:juezSearch,
                tipo_audiencia:tipo_audiencia,
                id_audiencia:id_audiencia,
                id_inmueble:id_inmueble,
                id_sala:id_sala,
                situacion: situacion_c,
                orden:order,
                pagina: 1,
                registros_por_pagina: 1000000,
            }

            console.log(data);

            $.ajax({
                type: 'POST',
                url: '/public/exportar_busqueda_audiencias',
                data: data,
                success: function(response) {

                    setTimeout(function(){
                        $('#modal_loading').modal('hide');
                    },500);

                    if(response.status==100){
                        window.open(response.response);
                    }else{
                        error(response.message);
                    }
                }
            });
            
        }

        function error(mensaje){
            $('#messageError').html(mensaje);
            $('#modalError').modal('show');
        }

        function get_orden_columnas() {
            let campos_title = [

                {
                    campo: "estatus_audiencia",
                    titulo: "estatus audiencia"
                },
                {
                    campo: "fecha_audiencia",
                    titulo: "fecha audiencia"
                },
                {
                    campo: "nombre_unidad",
                    titulo: "nombre_unidad"
                },
                {
                    campo: "notificacion_degt",
                    titulo: "notifcacion"
                },
                {
                    campo: "hora_inicio_audiencia",
                    titulo: "hora inicio audiencia"
                },
                {
                    campo: "tipo_audiencia",
                    titulo: "tipo audiencia"
                },
                {
                    campo: "nombre_inmueble",
                    titulo: "inmueble"
                },
                {
                    campo: "nombre_sala",
                    titulo: "nombre sala"
                },
                {
                    campo: "id_usuario",
                    titulo: "usuario"
                },
                {
                    campo: "nombre_corto",
                    titulo: "Unidad de gestion"
                },
            ];
            let columnas = [];
            $('#audienciasTable thead tr th').each(function() {
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


        /// #####  MODALES  ########
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

        function modal_success(mensaje,modalAnterior=null){
          $('#modal-success-titulo').html(`${mensaje}`);
          $('#btnCerrarSuccess').attr('data-modal',modalAnterior!=null?modalAnterior:'');
          if( modalAnterior!=null ) $('#'+modalAnterior).modal('hide');
          $('#modalSuccess').modal('show');
        }

        function modal_error(mensaje,modalAnterior=null){
          $('#messageError').html(`${mensaje}`);
          $('#btnCerrarError').attr('data-modal',modalAnterior!=null?modalAnterior:'');
          if( modalAnterior!=null ) $('#'+modalAnterior).modal('hide');
          $('#modalError').modal('show');
        }

        // ##### FUNCIONES AJAX #####

        // **** ACTUALIZAR AUDIENCIA
        function actualizarAudiencia(){
            $('#btn_actualizar_1').prop('disabled', true);

            validador = validar_datos_evento( 'audiencia', $("#id_audiencia").val() );
            console.log(validador);
            if( validador.status != 100 ){
              modal_error( validador.message , 'modal-audiencia' );
              $('#btn_actualizar_1').prop('disabled', false);
              return false;
            }
      
            //return false;
      
            let id_juez = $("#juez-A").val();
            let cve_juez = $("#juez-A option:selected").data('cve');
            let band_exc = 0;
      
            if( $("#juez_excusa-A").is(":checked") ){
              id_juez = $("#juezExcusa-A").val();
              cve_juez = $("#juezExcusa-A option:selected").data('cve');
              band_exc = 1;
            }
      
            var data = {
                id_unidad : audiencia_activa.id_unidad_gestion,
                carpeta_judicial : audiencia_activa.id_carpeta_judicial,
                id_audiencia: $("#id_audiencia").val(),
                id_inmueble : $("#inmueble-A").val(),
                id_sala : $("#sala-A").val(),
                id_tipo_audiencia : $("#tipoAudiencia-A").val(),
                id_juez : id_juez,
                cve_juez : cve_juez,
                fecha_audiencia : get_date($("#fecha-A").val()),
                hora_inicio_audiencia : $("#horaInicio-A").val()+':00',
                hora_fin_audiencia : $("#horaTermino-A").val()+':00',
                bandera_juez_tramite : 0, //$("#bandera_juez_tramite").val(),
                bandera_juez_excusa : band_exc,
                comentarios_excusa : band_exc == 1 ? $("#motivoExcusa-A").val() : '-', 
                recursos_audiencia : arrRAA,
            }

            console.log(data);

            
            $.ajax({
              method:'POST',
              url:'/public/modificar_audiencia_cj',
              async: false,
              data:{
                id_unidad : audiencia_activa.id_unidad_gestion,
                carpeta_judicial : audiencia_activa.id_carpeta_judicial,
                id_audiencia: $("#id_audiencia").val(),
                id_inmueble : $("#inmueble-A").val(),
                id_sala : $("#sala-A").val(),
                id_tipo_audiencia : $("#tipoAudiencia-A").val(),
                id_juez : id_juez,
                cve_juez : cve_juez,
                fecha_audiencia : get_date($("#fecha-A").val()),
                hora_inicio_audiencia : $("#horaInicio-A").val()+':00',
                hora_fin_audiencia : $("#horaTermino-A").val()+':00',
                bandera_juez_tramite : 0, //$("#bandera_juez_tramite").val(),
                bandera_juez_excusa : band_exc,
                comentarios_excusa : band_exc == 1 ? $("#motivoExcusa-A").val() : '-', 
                recursos_audiencia : arrRAA,
              },
              success:function(response){
                console.log(response);
                if(response.status==100){
                  //loading(false);
                  $('#modal-audiencia').modal('hide');
                  modal_success('Audiencia modificada exitosamente');
                  limpiarEspacioA( "#espacioAudiencia" );
                  limpiarEspacioA( "#footerEspacio" );
                  $('#btn_actualizar_1').prop('disabled', false);
                  sec_ajax();
                }else{
                  loading(false);
                  modal_error(response.message,'modal-audiencia');
                }
              },
              error : function( errors ){
                loading(false);
                $('#btn_actualizar_1').prop('disabled', false);
                modal_error('Error :'+errors,'modal-audiencia');
              }
            });
            
        }

        // **** GUARDAR AUDIENCIA
        function guardarAudiencia(){
            $('#btn_guardar_1').prop('disabled', true);
            validador = validar_datos_evento( 'audiencia', $("#id_audiencia").val() );
            console.log(validador);
            if( validador.status != 100 ){
              modal_error( validador.message , 'modal-audiencia' );
              $('#btn_guardar_1').prop('disabled', false);
              return false;
            }
      
            let id_juez = $("#juez-A").val();
            let cve_juez = $("#juez-A option:selected").data('cve');
            let band_exc = 0;
            let band_tra = 0;
      
            if( $("#juez_tramite-A").is(":checked") ){
              id_juez = $("#juezTramite-A").val();
              cve_juez = $("#juezTramite-A option:selected").data('cve');
              band_tra = 1;
            }
      
            if( $("#juez_excusa-A").is(":checked") ){
              id_juez = $("#juezExcusa-A").val();
              cve_juez = $("#juezExcusa-A option:selected").data('cve');
              band_exc = 1;
              band_tra = 0;
            }

            var data = {
                id_unidad : audiencia_activa.id_unidad_gestion,
                carpeta_judicial : audiencia_activa.id_carpeta_judicial,
                id_inmueble : $("#inmueble-A").val(),
                id_sala : $("#sala-A").val(),
                id_tipo_audiencia : $("#tipoAudiencia-A").val(),
                id_juez : id_juez,
                cve_juez : cve_juez,
                fecha_audiencia : get_date($("#fecha-A").val()),
                hora_inicio_audiencia : $("#horaInicio-A").val()+':00',
                hora_fin_audiencia : $("#horaTermino-A").val()+':00',
                bandera_juez_tramite : band_tra, //$("#bandera_juez_tramite").val(),
                bandera_juez_excusa : band_exc,
                comentarios_excusa : band_exc == 1 ? $("#motivoExcusa-A").val() : '-', 
                comentarios : '-', 
                recursos_audiencia : arrRAA,
            }

            console.log('Audiencia Guardada', data);
 
            $.ajax({
              method:'POST',
              url:'/public/crear_audiencia',
              async: false,
              data:{
                id_unidad : audiencia_activa.id_unidad_gestion,
                carpeta_judicial : audiencia_activa.id_carpeta_judicial,
                id_inmueble : $("#inmueble-A").val(),
                id_sala : $("#sala-A").val(),
                id_tipo_audiencia : $("#tipoAudiencia-A").val(),
                id_juez : id_juez,
                cve_juez : cve_juez,
                fecha_audiencia : get_date($("#fecha-A").val()),
                hora_inicio_audiencia : $("#horaInicio-A").val()+':00',
                hora_fin_audiencia : $("#horaTermino-A").val()+':00',
                bandera_juez_tramite : band_tra, //$("#bandera_juez_tramite").val(),
                bandera_juez_excusa : band_exc,
                comentarios_excusa : band_exc == 1 ? $("#motivoExcusa-A").val() : '-', 
                comentarios : '-', 
                recursos_audiencia : arrRAA,
              },
              success:function(response){
                console.log(response);
                if(response.status==100){
                  //loading(false);
                  $('#modal-audiencia').modal('hide');
                  modal_success('Audiencia creada exitosamente');
                  limpiarEspacioA( "#espacioAudiencia" );
                  limpiarEspacioA( "#footerEspacio" );
                  $('#btn_guardar_1').prop('disabled', false);
                  sec_ajax();
                }else{
                  loading(false);
                  modal_error(response.message,'modal-audiencia');
                }
              },
              error : function( errors ){
                loading(false);
                $('#btn_guardar_1').prop('disabled', false);
                modal_error('Error :'+errors,'modal-audiencia');
              }
            });
            
        }

        // **** NOTIFICAR MAJO
        function ReenviarMAjo(id_audiencia){
            $.ajax({
                method:'POST',
                url:'/public/renotificar_audiencia_MAJO_SIAJOP ',
                data:{
                  id_audiencia : id_audiencia,
                },
                success:function(response){
                  console.log(response);
                  if(response.status==100){
                    modal_success('Se ha notificado Correctamente');
                    sec_ajax();
                  }else{
                    loading(false);
                    modal_error(response.message);
                  }
                },
                error : function( errors ){
                  loading(false);
                  modal_error('Error :'+errors);
                }
            });        
        }

        function estatusAudiencia(id_carpeta_judicial,id_audiencia ,id_unidad,estatus, modal=true ){
            if( modal ){
                let strInputFile = '';
                if( estatus == "Cancelado" ){
                    strInputFile = `
                    <div class="col-lg-12">
                        <br>
                        <form onsubmit="return false;" id="cargarDocumentoCancelacionAudiencia" action="/" enctype="multipart/form-data">
                        <div class="custom-input-file">
                            <input type="file" id="archivoCancelacionPDF" class="input-file" value="" name="archivoCancelacionPDF" accept=".pdf" onchange="leeDocumentoCancelacionAudiencia(this)" >
                            <h5 class="px-3 py-3">Arrastre hasta aquí su documento o de clic para adjuntarlo</h5>
                        </div>
                        </form>
                    </div>
                    <div class="col-12 d-none" align="center">
                        <object height="300px" width="100%" class="mg-t-25" id="previewDocumentoCancelacionAudiencia" data=""></object>
                    </div>
                    `;
                }

                $("#modal-ver").modal('hide');
                title = `Cambio de estatus de semáforo`;
                body = `
                      <div class="row justify-content-md-center">
                        <div class="col-lg-10">
                          <label class="form-control-label" style="text-align:justify;"> Ingrese los motivos del porqué la audiencia cambia al estatus ${estatus.toUpperCase()} </label>
                          <textarea class="form-control" name="motivoCambioEstatus-A" id="motivoCambioEstatus-A" rows="4"></textarea>
                        </div>
                        ${strInputFile}
                      </div>
                    `;
                setTimeout(function (){ modal_confirm(title,body,`estatusAudiencia(${id_carpeta_judicial},${id_audiencia}, ${id_unidad} ,'${estatus}', ${false} )`,'modal-audiencia'); },1000);
            }else{
          
              $("#modal-ver").modal('hide');
              //setTimeout(function(){ loading(true)},500);
              $.ajax({
                method:'POST',
                url:'/public/modificar_estatus_audiencia_cj',
                async: false,
                data:{
                  id_unidad : id_unidad,
                  carpeta_judicial: id_carpeta_judicial,
                  id_audiencia: id_audiencia, 
                  estatus,
                  motivos : $("#motivoCambioEstatus-A").val(),
                  nombre : newDAC != null ? newDAC.nombre : null,
                  extension : newDAC != null ? newDAC.extension : null,
                  tamanio : newDAC != null ? newDAC.tamanio : null,
                  b64 : newDAC != null ? newDAC.b64 : null,
                },
                success:function(response){
                  console.log(response);
                  if(response.status==100){
                    //loading(false);
                    $('#info_estatus_audiencia').html(strEstatusB(estatus,id_carpeta_judicial,id_audiencia, id_unidad));
                    newDAC = null;      
                    modal_success('Semáforo de Audiencia cambiado exitosamente a '+estatus.toUpperCase(),'modal-ver');
                    sec_ajax();
                  }else{
                    loading(false);
                    modal_error(response.message,'modal-audiencia');
                  }
                },
                error : function( errors ){
                  loading(false);
                  modal_error('Error :'+errors,'modal-audiencia');
                }
              });
            }
        
        }

        function leeDocumentoCancelacionAudiencia (input) {
            let acepted_files=["pdf","PDF"];

            let file = $(input).val();
            let ext = "";
            let extension = "";
            let nombre_documento = "";

            if(file.length){
            
                extension = file.substr( file.lastIndexOf(".") +1 , file.length - file.lastIndexOf(".") -1 );   
                extension = extension.toLowerCase();
                nombre_documento = (file.split('\\')[2]);
                nombre_documento = nombre_documento.substr( 0 , nombre_documento.lastIndexOf(".") );   
                nombre_documento = nombre_documento.replaceAll(' ', '_');
                nombre_documento = nombre_documento.replaceAll('  ', '_');
                nombre_documento = nombre_documento.replaceAll('.', '_');
            
                if(extension!=''){
                    if( !acepted_files.includes(extension) ){
                        modal_error('Solo puede adjutar archivos PDF','modalAdministracion');
                        $(input).val('');
                        return false;
                    }else{
                        if (input.files && input.files[0]) {
                            let reader = new FileReader();
                            reader.onload = e=> {
                                newDAC = {
                                    'b64' : e.target.result.split('base64,')[1],
                                    'nombre' : nombre_documento,
                                    'tamanio': input.files[0].size / 1048576,
                                    'extension' : extension,
                                };

                                $("#previewDocumentoCancelacionAudiencia").attr("data",e.target.result); 
                                $("#previewDocumentoCancelacionAudiencia").parent().removeClass('d-none'); 
                            }
                            reader.readAsDataURL(input.files[0]);
                        }
                        
                        setTimeout(function(){
                            $(input).val(""); // limpiamos input
                            input.files = null; // limpiando files
                            console.log( $("#"+input.id).val(), input.files )
                            return false;
                        }, 500);
                    }
                }
            }else{
                return false;
            }
        }

        function ver_documento_cancelacion_audiencia( id_audiencia ){
            $.ajax({
                method:'POST',
                url:'/public/consultar_documento_cancelacion_audiencia',
                data:{ id_audiencia },
                success:function(response){
                    if( response.status==100){
                        $("#viewDocumentoCancelacionAudiencia").attr("data",response.response);
                        $("#viewDocumentoCancelacionAudiencia").removeClass("d-none");
                    }else{
                        modal_error(response.message,'modalHistory');
                    }
                } // success
            }); // ajax

        }

        // ##### FUNCIONES CONDICIONALES ####
        @if($request->session()->get('id_tipo_usuario') == 1 || $request->session()->get('id_tipo_usuario') == 2 || $request->session()->get('id_tipo_usuario') == 3 || $request->session()->get('id_tipo_usuario') == 18 || $request->session()->get('id_tipo_usuario') == 20 || $request->session()->get('id_tipo_usuario') == 26 || $request->session()->get('id_tipo_usuario') == 31 || $request->session()->get('id_tipo_usuario') == 32 || $request->session()->get('id_tipo_usuario') == 6 )
        /*
          function estatusAudiencia(id_carpeta_judicial,id_audiencia ,id_unidad,estatus, modal=true ){
              if( modal ){
                  $("#modal-ver").modal('hide');
                  title = `Cambio de estatus de semáforo`;
                  body = `
                        <div class="row justify-content-md-center">
                          <div class="col-lg-10">
                            <label class="form-control-label" style="text-align:justify;"> Ingrese los motivos del porqué la audiencia cambia al estatus ${estatus.toUpperCase()} </label>
                            <textarea class="form-control" name="motivoCambioEstatus-A" id="motivoCambioEstatus-A" rows="4"></textarea>
                          </div>
                        </div>
                      `;
                  setTimeout(function (){ modal_confirm(title,body,`estatusAudiencia(${id_carpeta_judicial},${id_audiencia}, ${id_unidad} ,'${estatus}', ${false} )`,'modal-audiencia'); },1000);
              }else{
            
                $("#modal-ver").modal('hide');
                //setTimeout(function(){ loading(true)},500);
                $.ajax({
                  method:'POST',
                  url:'/public/modificar_estatus_audiencia_cj',
                  async: false,
                  data:{
                    id_unidad : id_unidad,
                    carpeta_judicial: id_carpeta_judicial,
                    id_audiencia: id_audiencia, 
                    estatus,
                    motivos : $("#motivoCambioEstatus-A").val(),
                  },
                  success:function(response){
                    console.log(response);
                    if(response.status==100){
                      //loading(false);
                      $('#info_estatus_audiencia').html(strEstatusB(estatus,id_carpeta_judicial,id_audiencia, id_unidad));
                      modal_success('Semáforo de Audiencia cambiado exitosamente a '+estatus.toUpperCase(),'modal-ver');
                      sec_ajax();
                    }else{
                      loading(false);
                      modal_error(response.message,'modal-audiencia');
                    }
                  },
                  error : function( errors ){
                    loading(false);
                    modal_error('Error :'+errors,'modal-audiencia');
                  }
                });
              }
          
          }
        */
        @endif

        //############  ACTIVACION DE VIDEO STRIMING  ############

        function hScroll (amount) {
            amount = amount || 120;
            $('#audienciasTable').bind("DOMMouseScroll mousewheel", function (event) {
                var oEvent = event.originalEvent, 
                    direction = oEvent.detail ? oEvent.detail * -amount : oEvent.wheelDelta, 
                    position = $(this).scrollLeft();
                position += direction > 0 ? -amount : amount;
                $('#audienciasTable').scrollLeft(position);
                event.preventDefault();
            })
        }

        function streaming(id_audiencia, status, url, unidad){
            title = "Grabación de Audiencia: " + id_audiencia;
            body = `
              <div id="reproductor" style="width:100%; height:auto;">
              </div>
            `;
            marca_agua = `
              <div class="marca-agua" style="display: flex; position: absolute; color: #adb5bd; opacity : 0.4 ; overflow: hidden; font-size: 14px; font-weight: bold;" align="justify" >
                @for( $i = 0 ; $i<=500 ; $i ++ )
                  {{ $request->session()->get('usuario_nombre_completo')  }}  ({{ $request->session()->get('usuario_nombre')  }}) de la unidad {{ $request->session()->get('nombre_unidad') }} &nbsp; &nbsp;
                  {{ $request->session()->get('usuario_nombre_completo')  }}  ({{ $request->session()->get('usuario_nombre')  }}) de la unidad {{ $request->session()->get('nombre_unidad') }} &nbsp; &nbsp;
                  {{ $request->session()->get('usuario_nombre_completo')  }}  ({{ $request->session()->get('usuario_nombre')  }}) de la unidad {{ $request->session()->get('nombre_unidad') }} &nbsp; &nbsp;
                  {{ $request->session()->get('usuario_nombre_completo')  }}  ({{ $request->session()->get('usuario_nombre')  }}) de la unidad {{ $request->session()->get('nombre_unidad') }} &nbsp; &nbsp;
                  {{ $request->session()->get('usuario_nombre_completo')  }}  ({{ $request->session()->get('usuario_nombre')  }}) de la unidad {{ $request->session()->get('nombre_unidad') }} &nbsp; &nbsp;
                @endfor
              </div>
            `;
            
            $('#streaming_id').html(title);

            loader(true);

            setTimeout(function(){

                if(url != 0){
                    let url_video , type = '';
                    if( status == 'Finalizada' || status == 'finalizada'){ 
                        console.log(url);
                        protocolo = url.substring(0,4);
                        if(protocolo == 'http'){
                            type = 'mp4';
                            url_video = url;
                        }else if(protocolo == 'rtmp'){
    
                            switch (unidad){
                                case '001':
                                    type = 'mp4';
                                    url_frag = url.split('/');
                                    url_video = 'http://172.20.101.23:8083/'+url_frag[4];
                                    break;
    
                                case '002':
                                    type = 'mp4';
                                    url_frag = url.split('/');
                                    url_video = 'http://172.21.101.202:8083/'+url_frag[4];
                                    break;
                                
                                case '003':
                                    //esta en http
                                    break;
    
                                case '004':
                                    //Esta en http
                                    break;
    
                                case '005':
                                    //estan en http
                                    break;
    
                                case '006':
                                    type = 'mp4';
                                    url_frag = url.split('/');
                                    url_video = 'http://172.21.101.202:8083/'+url_frag[4];
                                    break;
    
                                case '007':
                                    type = 'mp4';
                                    url_frag = url.split('/');
                                    url_video = 'http://172.22.100.103:8083/'+url_frag[4];
                                    break;
    
                                case '008':
                                    type = 'mp4';
                                    url_frag = url.split('/');
                                    url_video = 'http://172.20.101.23:8083/'+url_frag[4];
                                    break;
    
                                case '009':
                                    type = 'mp4';
                                    url_frag = url.split('/');
                                    url_video = 'http://172.20.101.23:8083/'+url_frag[4];
                                    break;
    
                                case '010':
                                    type = 'mp4';
                                    url_frag = url.split('/');
                                    url_video = 'http://172.21.101.202:8083/'+url_frag[4];
                                    break;
    
                                case '011':
                                    type = 'mp4';
                                    url_frag = url.split('/');
                                    url_video = 'http://172.23.100.25/'+url_frag[4];
                                    break;
    
                                case '012':
                                    //Estan en http
                                    break;

                                case '601':
                                    type = 'mp4';
                                    url_frag = url.split('/');
                                    url_video = 'http://172.21.100.200/'+url_frag[4];
                                break;
                            }
                        }
                        console.log(protocolo);
                        console.log(type);
                    }else{ 
                        url_video = url;
                        type = "mp4";
                    }

                    console.log(url_video);
                    setTimeout( function(){  
                        
                        let player = OvenPlayer.create("reproductor", {
                            sources: [
                              {
                                "type": type,
                                "file": url_video, 
                              },
                            ],
                            autoStart : true,
                            controls: true,
                            expandFullScreenUI:true,
                            playbackRate: 1,
                            playbackRates : [5,4,3,2.5,2, 1.5, 1, 0.5, 0.25],
                            hidePlaylistIcon: true
                        });

                        OvenPlayer.debug(true);
                        
                        setTimeout( function(){
                          $(".op-media-element-container").prepend(marca_agua ) ;
                          
                          setTimeout( function(){ 
                        
                            $( ".reproductor" ).resize(function() {
                              $( ".marca-agua" ).width(  $( "#reproductor" ).width()  );
                              $( ".marca-agua" ).height(  $( "#reproductor" ).height()  );
                            });
                          }, 500 );

                        }, 600 );
                        
                    }, 1200 );
    
                }else{
    
                    
                    title = "Grabación de Audiencia: " + id_audiencia;
                    var mensaje_url_null = `<div style="margin: 0 auto; color: #fff; font-weight:bold; font-size:0.9em; width:50%; border-radius:6px; border: 2px solid #fff; padding: 10px; text-align:center; line-height:30px;">Video No encontrado</div>`;
    
                    setTimeout(function(){  
                        loader(false); 
                        $('#streaming_id').html(title);
                        $('#stream').html(mensaje_url_null);
                    }, 2000);
                }

                $('#stream').html(body);

            },1000);

            $('#modal-streaming').modal('show');
        }

        function streaming_live(id_audiencia, sala, inmueble){
                loader(true);
                
                var url = obtener_url_stream(sala,inmueble);
                console.log(url);
                var url_video = url.response[0].ws;

                var type = 'mp4';

                title = "Audiencia " + id_audiencia + " en vivo";
                body = `
                  <div id="reproductor" style="width:100%; height:auto;">
                  </div>
                `;

                marca_agua = `
                  <div class="marca-agua" style="display: flex; position: absolute; z-index: 1; color: #adb5bd; opacity : 0.4 ; overflow: hidden; font-size: 14px; font-weight: bold;" align="justify" >
                    @for( $i = 0 ; $i<=500 ; $i ++ )
                      {{ $request->session()->get('usuario_nombre_completo')  }}  ({{ $request->session()->get('usuario_nombre')  }}) de la unidad {{ $request->session()->get('nombre_unidad') }} &nbsp; &nbsp;
                      {{ $request->session()->get('usuario_nombre_completo')  }}  ({{ $request->session()->get('usuario_nombre')  }}) de la unidad {{ $request->session()->get('nombre_unidad') }} &nbsp; &nbsp;
                      {{ $request->session()->get('usuario_nombre_completo')  }}  ({{ $request->session()->get('usuario_nombre')  }}) de la unidad {{ $request->session()->get('nombre_unidad') }} &nbsp; &nbsp;
                      {{ $request->session()->get('usuario_nombre_completo')  }}  ({{ $request->session()->get('usuario_nombre')  }}) de la unidad {{ $request->session()->get('nombre_unidad') }} &nbsp; &nbsp;
                      {{ $request->session()->get('usuario_nombre_completo')  }}  ({{ $request->session()->get('usuario_nombre')  }}) de la unidad {{ $request->session()->get('nombre_unidad') }} &nbsp; &nbsp;
                    @endfor
                  </div>
                `;

                setTimeout(function(){  
                    loader(false); 
                    $('#streaming_id').html(title);
                    $('#stream').html(body);
                }, 1600);

                setTimeout( function(){  
                    const player = OvenPlayer.create("reproductor", {
                        waterMark: {
                          text: 'olv',
                          font: {
                            'font-size': '20px',
                            'color': '#fff',
                            'font-weight': 'bold',
                          },
                          position: 'bottom-right',
                          width : 'auto',
                          opacity : '0.7',
                        },
                        sources: [
                          {
                            "type": type,
                            "file": url_video
                          },
                        ],
                        autoStart : true,
                        controls: true,
                        expandFullScreenUI:true
                    });

                    player.on("ready", function(data){
                    });
                    player.on("error", function(error){
                        console.log(error);
                    });
                
                    setTimeout( function(){ 
                      $("#reproductor").prepend(marca_agua ) ;
                      setTimeout( function(){ 
                    
                        $( "#reproductor" ).resize(function() {
                          $( ".marca-agua" ).width(  $( "#reproductor" ).width()  );
                          $( ".marca-agua" ).height(  $( "#reproductor" ).height()  );
                        });
                      }, 500 );
                  
                    }, 600 );
        
                }, 2500 );
                
                $('#modal-streaming').modal('show');
        }

        function obtener_url_stream(sala, inmueble){
            var ws = $.ajax({
                method: 'POST',
                async: false,
                url: '/public/ws_salas',
                //  async: false,
                data: {
                    id_sala: sala,
                    id_inmueble: inmueble
                },
                success: function(response) {}
            });

            return ws.responseJSON;
        }

        function loader(accion){
            if(accion){
              $('#stream').append('<div id="loader"> <h5 style="color: #fff;">Consultando video</h5><div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>');
            }else{
                $('#loader').css('display', 'none');
            }
        }

        function cerrarStream(modal){
            $('#stream').html('');
            $('#'+modal).modal('hide');
        }

        function ver_acuse(id_audiencia){
            $('#visorPDFacuse').html('');
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
            
            listar_acta_minima(id_audiencia);
            $('#modal-acuse').modal('show');
        }

        function ver_acuse_pdf(id_audiencia, url=null){
            $('#visorPDFacuse').html('');

            pdf = `<embed src="${url}" type="application/pdf" width="100%" height="600px" />`;
                        
            $('#visorPDFacuse').html(pdf);
            
        }

        function listar_acta_minima( id_audiencia ){
            
            $.ajax({
                method: 'POST',
                url: '/public/consulta_audiencias',
                data: {
                    id_audiencia: id_audiencia,
                },
                success: function(response) {
                    audiencia = response.response[0];
                    console.log(audiencia.id_doc_acta_minima);
                    if( audiencia.id_doc_acta_minima != null ) {
                        console.log("Entramos");
                        $.ajax({
                            method:'POST',
                            url:'/public/obtener_documentos_asociados_carpeta',
                            data:{
                            carpeta : audiencia.id_carpeta_judicial,
                            id_documento : audiencia.id_doc_acta_minima,
                            documento_nombre: "Acta_minima",
                            extension: "pdf" ,
                            documento_origen : "CJ" 
                            },
                            success:function(response){
                                if( !response.message){ 
                                    $("#lista_docs").append(`
                                        <div class="documento" onclick="ver_acuse_pdf(${id_audiencia}, '${response.response}')" style="cursor: pointer; border: 1px solid #848f33; border-radius: 4px; padding: 7px 10px 7px 20px; margin-bottom: 5%; text-align: left;">
                                            <i class="far fa-file-pdf" style="color: #848f33; font-size: 1.1em; margin-right: 3%;"></i>
                                           Acta Minima
                                        </div>
                                    `);
                                }else{
                                    console.log(response.message);
                                    resolve( ); 
                                }
                            } // success
                        }); // ajax
                    }
                }
            });
             
        }
        
    </script>
@endsection

@section('seccion-modales')

    {{-- MODAL AUDIENCIA --}}
    <div id="modal-audiencia" class="modal fade" data-keyboard="false" data-backdrop="static" style="overflow: auto; min-width:80%;">
      <div class="modal-dialog modal-dialog-vertical-center modal-xl modal-dialog-xxl" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Carpeta Judicial: <span id="carpetaJL_actualizar">-</h6>
                <button type="button" class="close ml-auto" data-dismiss="modal" aria-label="Close" onclick="limpiarEspacioA('#espacioEditarAudiencia')">
                    <span aling="right" aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="espacioAudiencia">
            </div>
            <div class="modal-footer" id="footerEspacio">
            </div>
        </div>
      </div>
    </div>

    {{-- MODAL CONFIRM --}}
    <div id="modalConfirm" class="modal fade"  data-backdrop="static" data-keyboard="false" >
      <div class="modal-dialog modal-dialog-xxl modal-lg" role="document">
        <div class="modal-content tx-size-sm">
          <div class="modal-header pd-x-20">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold" id="tituloModalConfirm"></h6>
          </div>
          <div class="modal-body tx-center pd-y-20 pd-x-20" id="bodyModalConfirm">
            
          </div><!-- modal-body -->
          <div class="modal-footer d-flex">
            <button type="button" class="btn btn-secondary pd-x-25 mg-l-10 cerrar-modal" data-modal="modal-ver" data-thismodal="modalConfirm" id="btnCancelarModalConfirm">Cancelar</button>
            <button type="button" class="btn btn-primary pd-x-25 mg-l-10 cerrar-modal" data-modal="modal-ver" data-thismodal="modalConfirm" id="btnAceptarModalConfirm">Aceptar</button>
          </div>
        </div><!-- modal-content -->
      </div><!-- modal-dialog -->
    </div>

    {{-- MODAL ERROR --}}
    <div id="modalError" class="modal fade">
      <div class="modal-dialog" role="document">
        <div class="modal-content tx-size-sm">
          <div class="modal-body tx-center pd-y-20 pd-x-20">
            <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button> -->
            <i class="icon icon ion-ios-close-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
            <h4 class="tx-danger mg-b-20">Error!</h4>
            <p class="mg-b-20 mg-x-20" id="messageError"></p>
            <button type="button" class="btn btn-danger pd-x-25 cerrar-modal" data-modal="" data-thismodal="modalError" id="btnCerrarError">Aceptar</button>
          </div><!-- modal-body -->
        </div><!-- modal-content -->
      </div><!-- modal-dialog -->
    </div>
  
    {{-- MODAL SUCCESS --}}
    <div id="modalSuccess" class="modal fade"  data-backdrop="static" data-keyboard="false" >
        <div class="modal-dialog" role="document">
            <div class="modal-content tx-size-sm">
              <div class="modal-body tx-center pd-y-20 pd-x-20">
                    <i class="icon ion-ios-checkmark-outline tx-100 tx-success lh-1 mg-t-20 d-inline-block"></i>
                    <h6 class="tx-success tx-semibold mg-b-20">Hecho!</h6>
                    <p style="padding-left: 5vh; padding-right: 5vh;" id="modal-success-titulo">Titulo Modal Success</p>
              </div>
              <div class="modal-footer d-flex">
                <button type="button" class="btn btn-primary pd-x-25 mg-l-auto cerrar-modal" data-modal="" data-thismodal="modalSuccess" id="btnCerrarSuccess">Aceptar</button>
              </div>
            </div>
        </div>
    </div>

    <div id="modal-streaming" class="modal fade" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-vertical-center modal-xl" role="document">
            <div class="modal-content bd-0 tx-14" style="border-radius: 7px;">
                <div class="modal-header" style="padding:2px 25px; background: rgba(0,0,0,0.8) !important; color:#fff !important; border-bottom:none;">
                    <h6 class="tx-12 mg-b-0 tx-uppercase tx-inverse tx-bold" style="color:#fff !important; margin-top:1.2%;"><span id="streaming_id">-</h6>
                    <button type="button" class="close ml-auto" data-dismiss="modal" aria-label="Close" style="color:#fff !important;" onclick="cerrarStream('modal-streaming')">
                        <span aling="right" aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding: 0px !important;">
                    <div id="stream" class="buffering">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- E AUDIENCIA --}}
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
                    <div class="col-md-3" >
                        <div class="documentos" id="lista_docs">

                        </div>
                    </div>
                    <div class="col-md-9" id="visorPDFacuse">

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
