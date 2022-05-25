@php
    use App\Http\Controllers\clases\humanRelativeDate;
    $humanRelativeDate = new humanRelativeDate();
@endphp 

@extends('layouts.index')

@section('contenido-pageheader-usuario')
{{$sesion['usuario_nombre']}}
@endsection

@section('contenido-pageheader-organo')
{{$sesion['juzgado_nombre_largo']}}
@endsection


@section('contenido-pageheader')
    <ol class="breadcrumb slim-breadcrumb">
        <li class="breadcrumb-item"><a href="/home">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Libros Digitales Juzgados</li>
    </ol>
    <h6 class="slim-pagetitle">Libros Digitales Juzgados</h6>
@endsection

@section ('contenido-principal')
<div class="container" id="wrapper_form">

    <p class="text-center" id="titulo_libro"></p>

    <!--ACORDION DE BUSQUEDA TOCA-->
    <div id="accordion_busqueda" class="accordion-one" role="tablist" aria-multiselectable="true" style="margin-bottom:10px;">
        <div class="card">
            <div class="card-header" role="tab" id="headingOne">
                <a id="title_busqueda" data-toggle="collapse" data-parent="#accordion_busqueda" href="#collapse_busqueda" aria-expanded="false" aria-controls="collapseOne" class="tx-gray-800 transition collapsed">
                    Busqueda Expediente
                </a>
            </div>
            <div id="collapse_busqueda" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                <div class="card-body"><!--CUERPO BUSQUEDA TOCA-->
                    <div class="col-sm-12 col-md-12 col-gl-12 col-xl-12">
                        <div id="alertas_busqueda"></div>
                        <form class="row" id = "cuerpo_busqueda">
                            <div class="form-group col-md-3">
                                <label>No. Expediente
                                    <span class="tx-danger">*</span>
                                </label>
                                <input class="_number form-control" type="number" max="9999" min="1" name="expediente" id="expediente">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Año
                                    <span class="_number tx-danger">*</span>
                                </label>
                                <select class="form-control control_change" name="anios" id="anios"></select>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Bis</label>
                                <input class="_number form-control" type="number" max="9999" min="1" name="bis" id="bis">
                            </div>
                        </form>
                        <div class="row" id="acciones">
                            <div class="col-sm-6 col-md-6 col-gl-6 col-xl-6" id="btn_buscar" style="margin-bottom:15px;">
                                <button class="btn  btn-primary btn-sm" onclick="buscar_expediente();">Buscar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--ACORDION DE AGREGAR/EDITAR LIBRO-->
    <div id="accordion_formulario" class="accordion-one" role="tablist" aria-multiselectable="true" style="margin-bottom:10px;">
        <div class="card">
            <div class="card-header" role="tab" id="headingOne">
                <a id="title_formulario" data-toggle="collapse" data-parent="#accordion_formulario" href="#collapse_formulario" aria-expanded="false" aria-controls="collapseOne" class="tx-gray-800 transition collapsed">
                    Agregar al registro de libros 
                </a>
            </div>
            <div id="collapse_formulario" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                <div class="card-body"><!--CUERPO AGREGAR/EDITAR LIBRO-->
                    <div class="section-wrapper">
                        <div class="col-sm-12 col-md-12 col-gl-12 col-xl-12">
                            <div id="alertas_formulario"></div>
                            
                            <div class="row col-md-12" id="datos_expediente"></div>
                            
                            <div class="col-md-12" id="btn_partes" style ="margin-bottom:25px;"></div>
                            
                            <form class="row" id="cuerpo_form" action="javascript:void(0);"></form>
                            
                            <div id="alertas_acciones"></div>

                            <div class="row" id="acciones">
                                <div class="col-sm-6 col-md-6 col-gl-6 col-xl-6" id="btn_guardar" style="margin-bottom:15px;"></div>
                                <div class="col-sm-6 col-md-6 col-gl-6 col-xl-6" id="btn_editar" style="margin-bottom:15px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

    {{-- SECCIÓN PARA TABLA | REGISTROS DE LIBRO --}}
<div class="container accordion-one" id="wrapper_table" role="tablist" aria-multiselectable="true" style="margin-bottom:10px;width: auto;display: flex;">
    <div class="section-wrapper table-responsive" style="margin:0px; max-width: 850px;">
        <div class="card-header" role="tab" id="headingOne">
            <a id="title_busqueda" data-toggle="collapse" data-parent="#wrapper_table" href="#div_form_busqueda_en_libro" aria-expanded="false" aria-controls="collapseOne" class="tx-gray-800 transition collapsed" style="font-style: bold;"> 
                Busqueda en libro
            </a>
        </div>
        <div id="acciones_tabla">
            <div class="col-sm-6 col-md-6 col-gl-6 col-xl-6" id="btn_nuevo_libro" style="margin-bottom:15px;"></div>
        </div>
        <div id="div_form_busqueda_en_libro" class="collapse" role="tabpanel" aria-labelledby="headingOne">
            <form id ="cuerpo_busqueda_en_libro">
                <div class="row">
                    <div class="form-group col-md">
                        <label>No. Expediente</label>
                        <input class="_number form-control" type="number" max="9999" min="1" maxlength="4" name="expediente_en_libro" id="expediente_en_libro">
                    </div>
                    <div class="form-group col-md">
                        <label>Año</label>
                        <input class="_number form-control" type="number" max="9999" min="1973" maxlength="4" name="anios_en_libro" id="anios_en_libro">
                        {{-- <select class="form-control control_change" name="anios_en_libro" id="anios_en_libro"></select> --}}
                    </div>
                    <div class="form-group col-md">
                        <label>Bis</label>
                        <input class="_number form-control" type="number" max="9999" min="1" name="bis_en_libro" id="bis_en_libro">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md">
                        <label>Desde:</label>
                        <div class="input-group" style="width:100%;">
                            <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                            </div>
                            </div>
                            <input type="text" class="form-control fc-datepicker" placeholder="MM/DD/YYYY" name="fecha_desde" id="fecha_desde_en_libro" readonly="readonly">
                        </div>
                    </div>
                    <div class="form-group col-md">
                        <label>Hasta:</label>
                        <div class="input-group" style="width:100%;">
                            <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                            </div>
                            </div>
                            <input type="text" class="form-control fc-datepicker" placeholder="MM/DD/YYYY" name="fecha_desde" id="fecha_hasta_en_libro" readonly="readonly">
                        </div>
                    </div>
                </div>
                <input type="hidden" name="tipo" id="tipo" value="{{$tipo}}">
                <input type="hidden" name="libro" id="libro" value="{{$libro}}">
            </form>
            <div class="row" id="acciones" align="center">
                <div class="col-sm col-md col-gl col-xl" id="btn_buscar_en_libro" style="margin-bottom:15px;">
                    <button class="btn  btn-primary btn-sm" onclick="buscarPaginaLibro_ajax(1);">Buscar</button>
                </div>
            </div>
        </div>
        <div id="alertas_tabla"></div>
        <div id="acciones_tabla">
            <div class="col-sm-6 col-md-6 col-gl-6 col-xl-6" id="btn_nuevo_libro" style="margin-bottom:15px;"></div>
        </div>

        <div class="table-wrapper">
            <div class="pagination-wrapper justify-content-between" style="margin-bottom: 20px;">
                <ul class="pagination mg-b-0">
                <li class="page-item">
                    <a class="page-link" href="javascript:void(0);" onclick="buscarPaginaLibro_ajax('primera');" aria-label="Last">
                    <i class="fa fa-angle-double-left"></i>
                    </a>
                </li>
                
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0);" onclick="buscarPaginaLibro_ajax('anterior');" aria-label="Next">
                        <i class="fa fa-angle-left"></i>
                        </a>
                    </li>
                
                </ul>
    
                <div id="texto_paginator">Página <span class="pagina_actual_texto">0</span> de <span class="pagina_total_texto">0</span></div>
    
                <ul class="pagination mg-b-0">
                
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0);" onclick="buscarPaginaLibro_ajax('siguiente');" aria-label="Next">
                        <i class="fa fa-angle-right"></i>
                        </a>
                    </li>
                    

                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0);" onclick="buscarPaginaLibro_ajax('ultima');" aria-label="Last">
                        <i class="fa fa-angle-double-right"></i>
                        </a>
                    </li>
                </ul>
            </div><!-- pagination-wrapper -->
            

            <div id="div_scroll_sup_data_tables_libros" style="overflow-x:scroll;"><div id="div_interno_scroll_sup">&nbsp;</div></div>
            <div id="div_data_table_libros" style="max-width: 850px;max-height: 900px;overflow-y: scroll;overflow-x: scroll;">
                <table id="data_table_libros" class="table display nowrap">
                    <thead>
                        <tr></tr>
                    </thead>
                    <tbody>
                         <tr></tr>
                    </tbody>
                </table>
            </div>
            
            <input type="hidden" id="pagina_actual_en_libro" name="pagina_actual" value="0">
            <input type="hidden" id="paginas_totales_en_libro" name="paginas_totales" value="0">

            <div class="pagination-wrapper justify-content-between">
                <ul class="pagination mg-b-0">
                <li class="page-item">
                    <a class="page-link" href="javascript:void(0);" onclick="buscarPaginaLibro_ajax('primera');" aria-label="Last">
                    <i class="fa fa-angle-double-left"></i>
                    </a>
                </li>
                
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0);" onclick="buscarPaginaLibro_ajax('anterior');" aria-label="Next">
                        <i class="fa fa-angle-left"></i>
                        </a>
                    </li>
                
                </ul>
    
                <div id="texto_paginator">Página <span class="pagina_actual_texto">0</span> de <span class="pagina_total_texto">0</span></div>
    
                <ul class="pagination mg-b-0">
                
                <li class="page-item">
                    <a class="page-link" href="javascript:void(0);" onclick="buscarPaginaLibro_ajax('siguiente');" aria-label="Next">
                    <i class="fa fa-angle-right"></i>
                    </a>
                </li>
                

                <li class="page-item">
                    <a class="page-link" href="javascript:void(0);" onclick="buscarPaginaLibro_ajax('ultima');" aria-label="Last">
                    <i class="fa fa-angle-double-right"></i>
                    </a>
                </li>
                </ul>
            </div><!-- pagination-wrapper -->
        </div><!-- table-wrapper -->
    </div><!-- section-wrapper --> 
</div>

<!--MODAL DE ACUERDOS ENCONTRADOS-->
<div id="modal_acuerdos" class="modal fade" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Resultados</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body pd-20" style="overflow-y: auto; height:550px;">
                
                <div id="alertas_modal"></div>
                
                <div class="table-responsive" style="overflow-y: auto;">
                    <table id="tabla_archivo" class="table table-hover"></table>
                </div>

            </div><!-- modal-body -->
            <div class="modal-footer">
            </div>
        </div>
    </div><!-- modal-dialog -->
</div>

<!--MODAL MODIFICACION DE PARTES-->
<div id="modalpartes" class="modal fade" style="display: none; overflow-y: auto; height:550px;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">¿Modificar Partes?</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body pd-20 text-center">
                <div class="col-md-12" id="mensaje_partes"></div>
                <div class="row col-md-12" id="acciones_partes"></div>
            </div><!-- modal-body -->
            <div class="modal-footer">
            </div>
        </div>
    </div><!-- modal-dialog -->
</div>

<!--MODAL AGREGAR PARTES-->
<div id="modal_add_partes" class="modal fade" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold" id ="titulo_modal">Agregar</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body pd-20 col-md-12" style="overflow-y: auto; height:550px;">

                <div class="row" id="select_partes_existentes" name="select_partes_existentes">
                    <div class="form-group col-md-6"><label>Tipo de parte</label>
                        <select class="form-control _tipo_parte" name="partes_existentes" id="partes_existentes">
                            <option value="0">--Seleccione una opción--</option>
                            <option value="Actor">Actor</option>
                            <option value="Demandado">Demandado</option>
                        </select>
                    </div>

                    <div class="form-group col-md-6"><label>Partes</label>
                        <select class="form-control" name="partes_participantes" id="partes_participantes">
                            <option value="0">--Seleccione una opción--</option>
                        </select>
                    </div>

                </div>

                <div class="row col-md-12" style="margin-bottom:20px;">
                    <button class="btn btn-primary btn-sm" onclick="agregar_parte_existente()">Agregar seleccionado</button>
                </div>

                <div class="row col-md-12" style="margin-bottom:20px;">
                    <button class="btn btn-primary btn-sm" onclick="agregar_parte_extra()">Agregar nuevo</button>
                </div>

                <div class="col-md-12" id="mensaje_partes_extra"></div>

                <ul class="list-group list-group-striped mg-b-25" id="lista_partes_extra"></ul>
            
            </div><!-- modal-body -->
            <div class="modal-footer text-center">
                <div class="col-md-6">
                    <a class="btn btn-primary btn-sm" onclick="guardar_partes_extra()" href="#select_partes_existentes">Guardar</a>
                </div>
                <div class="col-md-6">
                    <button class="btn btn-danger btn-sm"  data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div><!-- modal-dialog -->
</div>

<!--MODAL USO GENERAL-->
<div id="modal_general" class="modal fade" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold" id ="titulo_modal_general"></h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div id="body_modal_general" class="modal-body pd-20 col-md-12" style="overflow-y: auto; height:550px;"></div><!-- modal-body -->
            <div id="footer_modal_general" class="modal-footer">
                <div id="acciones_modal_general"></div>
            </div>
        </div>
    </div><!-- modal-dialog -->
</div>
@endsection

@section('seccion-scripts-libs')
    <script src="{{ $entorno["version_pages"]["version"] }}/lib/datatables/js/jquery.dataTables.js"></script>
    <script src="{{ $entorno["version_pages"]["version"] }}/lib/datatables-responsive/js/dataTables.responsive.js"></script>
    <script src="{{ $entorno["version_pages"]["version"] }}/lib/select2/js/select2.min.js"></script>
    <script src="{{ $entorno["version_pages"]["version"] }}/lib/moment/js/moment.js"></script>
    <script src="{{ $entorno["version_pages"]["version"] }}/lib/jquery-ui/js/jquery-ui.js"></script>
@endsection

@section('seccion-scripts-functions')
    {{-- script busqueda en libro --}}
    <script>
        function buscarPaginaLibro_ajax(accion_pagina){

            var tipo = $("#tipo").val();
            var libro = $("#libro").val();
            var filtro = [];
            var expediente = $("#expediente_en_libro").val();
            var anios = $("#anios_en_libro").val();
            var bis = $("#bis_en_libro").val();
            var fecha_desde = $("#fecha_desde_en_libro").val();
            var fecha_hasta = $("#fecha_hasta_en_libro").val();
            var pagina_actual_en_libro = parseInt($("#pagina_actual_en_libro").val());
            var paginas_totales_en_libro = parseInt($("#paginas_totales_en_libro").val());

            if (accion_pagina == "primera")
                pagina = 1;
            else if (accion_pagina == "siguiente")
                pagina = pagina_actual_en_libro + 1;
            else if (accion_pagina == "anterior")
                pagina = pagina_actual_en_libro - 1;
            else if (accion_pagina == "ultima")
                pagina = paginas_totales_en_libro;
            else
                pagina = 1; 

            if ( (pagina > paginas_totales_en_libro || pagina < 1) && pagina_actual_en_libro!=0 ){
                alert("No hay más paginas que mostrar");
                mostrar_alerta("No hay más paginas que mostrar");
                return;
            }else{
                $('#modal_loading').modal('show');
            }
            $.ajax({
                url:"/libros_gobierno/"+tipo+"/"+libro+"/"+pagina,
                method:"POST",
                data:{ 
                    expediente:expediente, 
                    anios:anios, 
                    bis:bis, 
                    fecha_desde:fecha_desde, 
                    fecha_hasta:fecha_hasta, 
                    filtro:filtro, 
                    pagina:pagina,
                },
                error:function(error)
                {
                    var mensaje = "Se recibio el error: " + error.status;
                    mostrar_alerta("alertas_tabla", "danger", mensaje);
                },
                success:function(data)
                {
                    data = JSON.parse(data);
                    //$("#data_table_libros tr").remove();
                    //$("#paginas_tabla ul").remove();
                    
                    $("#div_data_table_libros table").remove();
                    $("#div_data_table_libros").append('<table id="data_table_libros" class="table display nowrap"></table>');
                    //console.log(data);
                    if(data.datos_tabla.status == 100)
                    {
                        $("#data_table_libros").html(data.datos_tabla.response.registros);
                        setTimeout(function(){ config_table_libros(); }, 2000);
                        $("#pagina_actual_en_libro").val(data.datos_tabla.response.pagina_actual);
                        $("#paginas_totales_en_libro").val(data.datos_tabla.response.paginas.total_paginas);
                        $(".pagina_actual_texto").text(data.datos_tabla.response.pagina_actual);
                        $(".pagina_total_texto").text(data.datos_tabla.response.paginas.total_paginas);
                        doble_scroll();
                    }
                    else
                    {
                        $("#pagina_actual_en_libro").val(0);
                        $("#paginas_totales_en_libro").val(0);
                        $(".pagina_actual_texto").text(0);
                        $(".pagina_total_texto").text(0);
                        alert(data.datos_tabla.message);
                        mostrar_alerta("alertas_tabla", "warning", data.datos_tabla.message);
                    }
                    setTimeout(function(){ $('#modal_loading').modal('hide'); }, 2000);
                }
            });
        }

        function doble_scroll(){
            setTimeout(function(){ 
                $("#div_interno_scroll_sup").width($("#data_table_libros").width());
                //$("#div_interno_scroll_sup thead").css('overflow-y' 'auto'); 
                
                $("#div_scroll_sup_data_tables_libros").on("scroll", function(){
                    $("#div_data_table_libros").scrollLeft($(this).scrollLeft()); 
                });
                $("#div_data_table_libros").on("scroll", function(){
                    $("#div_scroll_sup_data_tables_libros").scrollLeft($(this).scrollLeft()); 
                }); 
            }, 100);
        }

        $('.fc-datepicker').datepicker({
            language: 'es',
            showOtherMonths: true,
            selectOtherMonths: true,
            dateFormat: 'yyyy-mm-dd',
        });

        function config_table_libros(){
            $('#data_table_libros').DataTable( {
                "paging":   false,
                "ordering": true,
                "order": [[1, 'desc']],
                "info":     false,
                "searching": false,
            } );
        }
    </script>
    <script>
        var time;

        var anios = "";
        var juzgados = "";
        var todos_juzgados = "";
        var tipo_juicio = "";
        var especialidad = "";
        var pais_origen = "";
        var consecutivo = "";

        var resultados = "";
        var formulario = "";
        var tabla = "";
        var elementos = [];
        var campos = "";

        var expediente_completo = "";

        var id = "";

        var tipo_juicio = "";

        //DATOS ENVIADOS POR EL BACKEND
        var tipos_secretaria = "";
        var tipos_secretaria_c = "";
        var cuantias = "";
        var tipos_moneda = "";
        var tipos_resolucion = "";
        var tipo_diligencia = "";
        
        //OBJETO DE PARTES EXTRA
        var contador_li = 0;
        var array_partes_extra = [];
        var id_seccion = "";
        var p_nombre = "";
        var p_paterno = "";
        var p_materno = "";

        //CERTIFICADOS
        var array_certificados = [];

        $(document).ready(function() 
        {
            consecutivo = @json($consecutivo);

            formulario = @json($datos_formulario);
            tabla = @json($datos_tabla);
            anios = @json($anios);
            juzgados = @json($juzgados);
            todos_juzgados  = @json($todos_juzgados);
            especialidad = @json($especialidad);
            pais_origen = @json($pais_origen);
            tipo_juicio = @json($tipo_juicio);
            tipo_diligencia = @json($tipo_diligencia);

            cuantias = @json($cuantias);
            tipos_moneda = @json($tipos_moneda);
            tipos_resolucion = @json($tipos_resolucion);
            tipos_secretaria = @json($tipos_secretaria);
            tipos_secretaria_c = @json($tipos_secretaria_c);

            $("#anios").html(anios);

            setTimeout(function(){ $('#modal_loading').modal('hide'); }, 1000);

            $("._number").on('input', function()
            {
                this.value = this.value.replace(/[^0-9]/g, '');
            });

            $("._p_tipo").change(function()
            {
                generar_campos_tipo($("#" + this.id).val(), this.id, 0);
            });

            var logs = @json($logs);
            console.log(logs);
            // console.log(@json($request));
            inicio();
            //doble_scroll();
        });

        //JUZGADOS
        function inicio()
        {
            try
            {
                // CREACION TABLA
                if(tabla.status == 100)
                {
                    buscarPaginaLibro_ajax('primera');
                    //$("#data_table_libros").html(tabla.response.registros);
                    //$("#paginas_tabla").html(tabla.response.paginas);
                }

                else
                {
                    mostrar_alerta("alertas_tabla", "warning", tabla.message);
                    console.log(tabla.response);
                }

                // GUARDADO FORMULARIO
                if(formulario.status == 100)
                {
                    var libro = formulario.response.descripcion;
                    
                    $("#titulo_libro").html("<h2><p class='text-center'>"+ libro +"</p></h2>");
                    
                    campos = JSON.parse(unescape(formulario.formulario));
                }

                else
                {
                    mostrar_alerta("alertas_formulario", "warning", formulario.message);
                    console.log(formulario.response);
                }

                //CONSECUTIVO
                if(consecutivo.status == 100)
                {
                    consecutivo = consecutivo.response[0].consecutivo_libro_consecutivo;
                }

                else
                {
                    consecutivo = 0;
                    mostrar_alerta("alertas_formulario", "warning", consecutivo.message);
                    console.log(consecutivo.response);
                }
            }

            catch(exp)
            {
                setTimeout(function(){ $('#modal_loading').modal('hide'); }, 1000);

                mostrar_alerta("alertas_formulario", "warning", exp)
            }
        }

        function cancelar()
        {
            location.reload();
        }

        function mostrar_alerta(id_zona, tipo, texto)
        {
            clearTimeout(time);

            $("#" + id_zona).empty();

            var html_alerta = '<div class="alert alert-'+ tipo +'" role="alert"><strong>'+ texto +'</strong></div>';

            $("#" + id_zona).html(html_alerta);

            time = setTimeout(function(){ $("#" + id_zona).empty(); }, 3000);
        }

        function crear_formulario()
        {
            $("#cuerpo_form").empty();

            $.each(campos.campos, function(index, value) 
            {
                var html = "";

                if(value.tipo == "consecutivo")
                {
                    html += generar_input_consecutivo(value);
                }

                if(value.tipo == "number")
                {
                    html += generar_input_number(value);
                }

                if(value.tipo == "money")
                {
                    html += generar_input_money(value);
                }

                if(value.tipo == "text")
                {
                    html += generar_input(value);
                }

                if(value.tipo == "check")
                {
                    html += generar_check(value);
                }

                if(value.tipo == "option")
                {
                    html += generar_option(value);
                }

                if(value.tipo == "time")
                {
                    html += generar_time(value);
                }
                
                if(value.tipo == "date")
                {
                    html += generar_date(value);
                }
                
                if(value.tipo == "date_time")
                {
                    html += generar_date_time(value);
                }

                if(value.tipo == "big_text")
                {
                    html += generar_text_area(value);
                }

                if(value.tipo == "seccion_actor")
                {
                    html += seccion_actor(value);
                }

                if(value.tipo == "seccion_beneficiario")
                {
                    html += seccion_actor(value);
                }

                if(value.tipo == "seccion_certificado_egresos")
                {
                    html += seccion_certificado_egresos(value);
                }

                if(value.tipo == "seccion_diligencia")
                {
                    html += seccion_diligencias(value);
                }

                if(value.tipo == "seccion_diligencia_2")
                {
                    html += seccion_diligencias_2(value);
                }
                
                $("#cuerpo_form").append(html);
            });

            $(".control_change").change(function() {
                generar_elemento_extra(this.id, $(this).parent().attr('id'));
            });

            $("._number").on('input', function()
            {
                this.value = this.value.replace(/[^0-9]/g, '');
            });

            $("._seccion").click(function()
            {
                id_seccion = this.id;

                mostrar_partes_extra(id_seccion);

                $("#modal_add_partes").modal("show");

                $("._tipo_parte").change(function()
                {
                    seleccion_extra_existente(this.id);
                });
            });

            $("._certificado").click(function()
            {
                seccion_certificado(this.id);

                $("#modal_general").modal("show");
            });

            $("._diligencia").click(function()
            {
                id_seccion = this.id;

                seccion_diligencia(id_seccion);

                $("#modal_general").modal("show");
            });

            $("._diligencia_2").click(function()
            {
                id_seccion = this.id;

                seccion_diligencia_2(id_seccion);

                $("#modal_general").modal("show");
            });
        }

        function buscar_expediente()
        {
            try
            {
                $.ajax({
                    url:"/libros_gobierno/buscar_expediente",
                    method:"POST",
                    data:{  expediente:$("#expediente").val(), 
                            anio:$("#anios").val(), 
                            bis:$("#bis").val()},

                    error:function(error)
                    {
                        var mensaje = "Se recibio el error: " + error.status;

                        mostrar_alerta("alertas_busqueda", "danger", mensaje);
                    },

                    success:function(data)
                    {
                        if(data.status == 100)
                        {
                            $("#tabla_archivo").html(data.response);
                            $('#modal_acuerdos').modal('show');

                            resultados = data.resultados;

                            console.log(resultados);
                        }
                        else
                        {
                            mostrar_alerta("alertas_busqueda", "warning", data.message);
                        }
                    }
                });
            }
            catch(exp)
            {
                mostrar_alerta("alertas_busqueda", "danger", exp);
            }
        }

        function buscar_resultados(id_juicio)
        {
            try
            {
                var elemento = resultados.find(x => x.datos_archivo.id_juicio == id_juicio);

                if(elemento != null)
                {
                    tipo_juicio = elemento.tipo_juicio[0].juicio;

                    $("#area_actores").val("");
                    $("#area_demandados").val("")

                    crear_formulario();

                    id = id_juicio;

                    var expediente = '<div class="col-md-4"><p><strong>Expediente:</strong></p><p>';
                    var actores = '<div class="col-md-4"><p><strong>Actores:</strong></p>';
                    var demandado = '<div class="col-md-4"><p><strong>Demandados:</strong></p>';

                    expediente += elemento.datos_archivo.expediente + "/";
                    var anio = elemento.datos_archivo.anio; 
                    var bis = (elemento.datos_archivo.bis != null) ? "-" + elemento.datos_archivo.bis: "";

                    expediente_completo = elemento.datos_archivo.expediente + "/" + anio + bis;

                    expediente += anio + bis + '</p></div>';
                    
                    $.each(elemento.partes.actor, function(index, valor)
                    {
                        var actor_n = (valor.nombre != 'null') ? valor.nombre: "";
                        var actor_p = (valor.apellido_paterno !== null) ? valor.apellido_paterno: "";
                        var actor_m = (valor.apellido_materno !== null) ? valor.apellido_materno: "";

                        $("#area_actores").val($("#area_actores").val() + " " + actor_n + " " + actor_p + " " + actor_m + "\n");

                        actores += "<p>" + actor_n + actor_p + actor_m + "</p>";
                    });
                    actores += '</div>';

                    $.each(elemento.partes.demandado, function(index, valor)
                    {
                        var demandado_n = (valor.nombre != 'null') ? valor.nombre: "";
                        var demandado_p = (valor.apellido_paterno !== null) ? valor.apellido_paterno: "";
                        var demandado_m = (valor.apellido_materno !== null) ? valor.apellido_materno: "";

                        $("#area_demandados").val($("#area_demandados").val() + " " + demandado_n + " " + demandado_p + " " + demandado_m + "\n");

                        demandado += "<p>" + demandado_n + demandado_p + demandado_m + "</p>";
                    });
                    demandado += '</div>';

                    $("#expediente_titulo").html(expediente_completo);

                    $("#expediente_form").html(expediente_completo);

                    $("#datos_expediente").html(expediente + actores + demandado);

                    $('#modal_acuerdos').modal('hide');
                    
                    $('#btn_partes').html('<button class="_partes btn btn-primary btn-sm">Modificar Partes</button>');

                    $("#btn_guardar").html("<button class='btn btn-primary btn-sm' onClick='guardar_juzgado(" + id + ", " + elemento.datos_archivo.expediente + ", " + elemento.datos_archivo.anio + ", " + elemento.datos_archivo.bis + ");'>Guardar</button>");
                    $("#btn_editar").html("<button class='btn btn-danger btn-sm' onClick='cancelar();'>Cancelar</button>");

                    expandir_acordion("title_formulario");

                    $("._partes").click(function()
                    {
                        $('#mensaje_partes').html('<p>¿Esta seguro de modificar las partes del expediente ' + expediente_completo + '?</p><p>Sera redirigido a otra pagina</p>');
                        $('#acciones_partes').html('<div class="col-md-6"><button class="_redirigir btn btn-primary btn-sm">Continuar</button></div> <div class="col-md-6"><button class="_cancelar btn btn-danger btn-sm">Cancelar</button></div>');

                        $("#modalpartes").modal('show');

                        $("._redirigir").click(function()
                        {
                            $(window).attr('location','http://216.144.236.27/juicio/editar/' + id)
                        });

                        $("._cancelar").click(function()
                        {
                            $("#modalpartes").modal('hide');
                        });
                    });
                }

                else
                {
                    mostrar_alerta("alertas_modal", "warning", "No se encontro información");
                }
            }

            catch(exp)
            {
                mostrar_alerta("alertas_modal", "danger", exp);
            }
        }

        function guardar_juzgado(id_juicio, expediente, anio, bis)
        {
            try
            {
                var formulario_campos = $('#cuerpo_form').serializeArray();

                if(array_partes_extra.length > 0)
                {
                    $.each(campos.campos, function(index, valor)
                    {
                        var replace = valor.id.split("_");

                        var existe = $.inArray("seccion", replace);

                        if(existe >= 0)
                        {
                            var datos = array_partes_extra.filter(x=>x.id_seccion == valor.id);

                            var objeto_nuevo = new Object();
                            objeto_nuevo.name = valor.id;
                            objeto_nuevo.value = JSON.stringify(datos);

                            formulario_campos.push(objeto_nuevo);
                        }
                    });
                }

                $.ajax({
                    url:"/libros_gobierno/guardar/juzgado/",
                    method:"POST",
                    data:{  datos:formulario_campos, 
                            tabla:formulario.response.nombre_db, 
                            materia:formulario.response.materia, 
                            id_juicio:id,
                            expediente:expediente,
                            anio:anio,
                            bis:bis,
                            partes_extra:array_partes_extra,
                            seccion_certificados:array_certificados,
                            tipo_juicio:tipo_juicio
                        },

                    error:function(error)
                    {
                        var mensaje = "Se recibio el error: " + error.status;
                        mostrar_alerta("alertas_acciones", "danger", mensaje);
                    },

                    success:function(data)
                    {console.log(data);
                        if(data.status == 100)
                        {
                            mostrar_alerta("alertas_acciones", "success", data.message);

                            cancelar();
                        }

                        else if(data.status == 200)
                        {
                            mostrar_alerta("alertas_acciones", "warning", data.message);
                            
                            if(data.response.length > 0)
                            {
                                $.each(data.response, function(index, valor)
                                {
                                    $("#" + valor).addClass("is-invalid");
                                });
                            }
                        }

                        else if(data.status == 300)
                        {
                            mostrar_alerta("alertas_acciones", "danger", data.message);
                            console.log(data.response);
                        }
                    }
                });
            }
            catch(exp)
            {
                mostrar_alerta("alertas_acciones", "danger", exp);
                console.log(exp);
            }
        }

        function editar(id_valor)
        {
            try
            {
                array_partes_extra = [];

                $('#modal_loading').modal('show');
                
                setTimeout(function(){ $('#modal_loading').modal('hide'); }, 2000);

                $.ajax({
                    
                    url:"/libros_gobierno/buscar_registro/juzgado",
                    method:"POST",
                    data:{  valor:id_valor, 
                            tabla:formulario.response.nombre_db, 
                            materia:formulario.response.materia},

                    error:function(error)
                    {
                        var mensaje = "Se recibio el error: " + error.status;
                        mostrar_alerta("alertas_tabla", "danger", mensaje);
                    },

                    success:function(data)
                    {console.log(data);
                        if(data.status == 100)
                        {
                            resultados = data.expediente;

                            buscar_resultados(data.query.id_juzgado);

                            crear_formulario();

                            $("#consecutivo").val(data.query.consecutivo);

                            colocar_secciones(data.response.campos);

                            $("#btn_guardar").html("<button class='btn btn-warning btn-sm' onClick='terminar_edicion(" + data.valor + ");'>Terminar Edición</button>");
                            $("#btn_editar").html("<button class='btn btn-danger btn-sm' onClick='cancelar();'>Cancelar</button>");
                            
                            expandir_acordion("title_formulario");

                            $.each(data.response.campos, function(index, valor_d)
                            {
                                $.each($("#cuerpo_form div"), function(index, valor_f)
                                {
                                    if(valor_f.children.length > 1)
                                    {
                                        if(valor_d.id === valor_f.children[1].id) 
                                        {
                                            valor_f.children[1].value = valor_d.valor;

                                            if(valor_f.children[1].type === 'select-one')
                                            {
                                                $("#" + valor_f.children[1].id).trigger('change');
                                            }
                                        }
                                    }
                                });
                            });
                        }
                        else if(data.status == 200)
                        {
                            mostrar_alerta("alertas_tabla", "warning", data.message);
                        }
                        else if(data.status == 300)
                        {
                            mostrar_alerta("alertas_tabla", "danger", data.message);
                        }
                    }
                });
            }

            catch(exp)
            {
                mostrar_alerta("alertas_tabla", "danger", exp)
            }
        }

        function terminar_edicion(id_valor)
        {
            try
            {
                var formulario_campos = $('#cuerpo_form');
                var disable_input = formulario_campos.find(':input:disabled').removeAttr('disabled');
                formulario_campos = formulario_campos.serializeArray();
                disable_input.attr('disabled','disabled');

                if(array_partes_extra.length > 0)
                {
                    $.each(campos.campos, function(index, valor)
                    {
                        var replace = valor.id.split("_");

                        var existe = $.inArray("seccion", replace);

                        if(existe >= 0)
                        {
                            var datos = array_partes_extra.filter(x=>x.id_seccion == valor.id);

                            var objeto_nuevo = new Object();
                            objeto_nuevo.name = valor.id;
                            objeto_nuevo.value = JSON.stringify(datos);

                            formulario_campos.push(objeto_nuevo);
                        }
                        
                    });
                }

                $.ajax({
                    url:'/libros_gobierno/guardar_edicion/juzgado',
                    method:'POST',
                    data:{  datos:formulario_campos,
                            id_valor:id_valor, 
                            tabla:formulario.response.nombre_db, 
                            materia:formulario.response.materia,
                            partes_extra:array_partes_extra,
                            seccion_certificados:array_certificados,
                        },

                    error:function(error)
                    {
                        var mensaje = "Se recibio el error: " + error.status;
                        mostrar_alerta("alertas_acciones", "danger", mensaje); 
                    },

                    success:function(data)
                    {console.log(data);
                        if(data.status == 100)
                        {
                            mostrar_alerta("alertas_acciones", "success", data.message);

                            cancelar();
                        }
                        else if(data.status == 101)
                        {
                            mostrar_alerta("alertas_acciones", "primary", data.message);

                            cancelar();
                        }
                        else if(data.status == 200)
                        {
                            mostrar_alerta("alertas_acciones", "warning", data.message);

                            if(data.response.length > 0)
                            {
                                $.each(data.response, function(index, valor)
                                {
                                    $("#" + valor).addClass("is-invalid");
                                });
                            }
                        }
                        else if(data.status == 300)
                        {
                            mostrar_alerta("alertas_acciones", "danger", data.message);
                            console.log(data.response);
                        }
                    }
                });
                
            }
            catch(exp)
            {
                mostrar_alerta("alertas_acciones", "danger", exp);
                console.log(exp);
            }
        }

        function informacion(id_valor)
        {
            try
            {
                $("#titulo_modal_general").empty();
                $("#body_modal_general").empty();
                $("#mensaje_modal_general").empty();
                $("#acciones_modal_general").empty();

                var html =  '<div id="box_info_libro" class="col-md-12"></div>'+
                            '<div class="col-md-12 table-responsive">'+
                            '<table id="tabla_info_libro" class="table table-hover"></table></div>';

                var botones = '<button class="btn btn-danger btn-sm" data-dismiss="modal">Cerrar</button>';

                $("#titulo_modal_general").html("Información");
                $("#body_modal_general").html(html);
                $("#acciones_modal_general").html(botones);
                
                $('#modal_loading').modal('show');

                $.ajax({
                    url:"/libros_gobierno/consultar_informacion",
                    method: "POST",
                    data:{  id_valor:id_valor, 
                            tabla:formulario.response.nombre_db,
                            materia:formulario.response.materia
                        },

                    error:function(error)
                    {
                        var mensaje = "Se recibio el error: " + error.status;
                        mostrar_alerta("#mensaje_modal_general", "danger", mensaje);
                    },

                    success:function(data)
                    {console.log(data);

                        if(data.status == 100)
                        {
                            var datos_libro =   '<h3 class="text-center"><strong>Información general</strong></h3>'+
                                                '<h5 style="margin-top:20px; margin-bottom:20px;"><strong>No. de registro: </strong>' + data.response.no_registro + '<br>' +
                                                '<strong>Expediente: </strong>' + data.response.expediente + '<br>' +
                                                '<strong>Fecha de creación: </strong>' + data.response.fecha_creacion + '<br><br>'+
                                                '<strong>Actores: </strong>' + data.response.actores + '<br>' +
                                                '<strong>Demandados: </strong>' + data.response.demandados + 
                                                '</h5>';

                            $("#tabla_info_libro").empty();
                            $("#tabla_info_libro").html(data.response.tabla);
                            $("#box_info_libro").html(datos_libro);
                            $("#body_modal_general").append(data.response.certificados);
                        }

                        setTimeout(function(){ $('#modal_loading').modal('hide'); $("#modal_general").modal("show"); }, 1000);
                    }                    
                });
            }

            catch(exp)
            {
                console.log(exp);
                setTimeout(function(){ $('#modal_loading').modal('hide'); }, 1000);
                mostrar_alerta("alertas_tabla", "danger", "Ocurrio un error al consultar la información del registro");
            }
        }

        //FUNCIONES DE MONEDAS
        function mascara(o,f)
        {
            v_obj=o;  
            v_fun=f;  
            setTimeout("execmascara()",1);  
        }
        
        function execmascara()
        {
		    v_obj.value=v_fun(v_obj.value);
        }  
        
        function cpf(v)
        {
            v=v.replace(/([^0-9\.]+)/g,''); 
            v=v.replace(/^[\.]/,''); 
            v=v.replace(/[\.][\.]/g,''); 
            v=v.replace(/\.(\d)(\d)(\d)/g,'.$1$2'); 
            v=v.replace(/\.(\d{1,2})\./g,'.$1'); 
            v = v.toString().split('').reverse().join('').replace(/(\d{3})/g,'$1,');    
            v = v.split('').reverse().join('').replace(/^[\,]/,''); 
            return v;
	    }

        //PARTES EXTRA
        function colocar_secciones(object)
        {
            try
            {
                $.each(object, function(index, valor)
                {
                    var seccion = valor.id.replace("_", " ");

                    if( seccion.indexOf("seccion") > -1)
                    {
                        var datos_s = JSON.parse(valor.valor);
                        
                        $.each(datos_s, function(i, valor_s)
                        {
                            array_partes_extra.push(valor_s);
                        });                        
                    }
                });

                console.log(array_partes_extra);
            }

            catch(exp)
            {
                console.log(exp);
            }
        }

        function seleccion_extra_existente(id_elemento)
        {
            $("#partes_participantes").empty();

            var opciones_participantes = '<option value="0">--Seleccione una opción--</option>';

            if( $("#" + id_elemento).val() == "Actor" )
            {
                if(resultados[0].partes.actor.length)
                {
                    $.each(resultados[0].partes.actor, function(index, valor)
                    {
                        var actor_n = (valor.nombre != 'null') ? valor.nombre: "";
                        var actor_p = (valor.apellido_paterno !== null) ? valor.apellido_paterno: "";
                        var actor_m = (valor.apellido_materno !== null) ? valor.apellido_materno: "";
                        
                        var nombre_completo = actor_n + " " + actor_p + " " + actor_m;

                        opciones_participantes += '<option value="'+ valor.parte_id +'">'+ nombre_completo +'</option>';
                    });

                    $("#partes_participantes").html(opciones_participantes);
                }
            }

            else if( $("#" + id_elemento).val() == "Demandado" )
            {
                if(resultados[0].partes.demandado.length)
                {
                    $.each(resultados[0].partes.demandado, function(index, valor)
                    {
                        var demandado_n = (valor.nombre != 'null') ? valor.nombre: "";
                        var demandado_p = (valor.apellido_paterno !== null) ? valor.apellido_paterno: "";
                        var demandado_m = (valor.apellido_materno !== null) ? valor.apellido_materno: "";

                        var nombre_completo = demandado_n + " " + demandado_p + " " + demandado_m;

                        opciones_participantes += '<option value="'+ valor.parte_id +'">'+ nombre_completo +'</option>';
                    });

                    $("#partes_participantes").html(opciones_participantes);
                }
            }
        }

        function mostrar_partes_extra(id)
        {
            $("#lista_partes_extra").empty();

            contador_li = 0;
            console.log(array_partes_extra);
            var array_partes = array_partes_extra.filter(x =>x.id_seccion == id);
            console.log(array_partes);
            if(array_partes.length > 0)
            {
                array_partes.sort(function(a,b){return a.no_lista-b.no_lista});
                
                var array_inverso = array_partes.reverse();
                
                contador_li = array_partes[0].no_lista;
                
                array_partes.reverse();

                $.each(array_partes, function(index, valor)
                {
                    var nodo = valor.id_seccion + "_" + valor.no_lista;
                    
                    var html = '<li class="list-group-item" id="'+ nodo +'">'+
                                    '<div class="row">'+
                                        '<div style="margin-left: auto; margin-right: 15px;" class="eliminar">'+
                                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close" onClick="eliminar_nodo('+ nodo + ')">'+
                                                '<span aria-hidden="true"><i class="fa fa-close" style="color: red"></i></span>'+
                                            '</button>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="row">'+
                                        '<div class="col-lg-4">'+
                                            '<div class="form-group mg-b-10-force">'+
                                                '<label class="form-control-label">Tipo persona <span class="tx-danger">*</span></label>'+
                                                '<select class="_p_tipo  form-control" name="p_tipo_persona_' + valor.no_lista +'" id="p_tipo_persona_'+ valor.no_lista +'">'+
                                                    '<option value="0">--Seleccione una opción--</option>'+
                                                    '<option value="fisica">Física</option>'+
                                                    '<option value="moral">Moral</option>'+
                                                '</select>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="row" name="datos_p_persona_'+ valor.no_lista +'" id="datos_p_persona_'+ valor.no_lista +'"></div>'+
                                '</li>';

                    $("#lista_partes_extra").append(html);

                    $("._p_tipo").change(function()
                    {
                        generar_campos_tipo($("#" + this.id).val(), this.id, 0);
                    });

                    p_nombre = valor.nombre_p;
                    p_paterno = valor.paterno_p;
                    p_materno = valor.materno_p;

                    $("#p_tipo_persona_" + valor.no_lista).val(valor.tipo_persona);

                    generar_campos_tipo(valor.tipo_persona, 'p_tipo_persona_' + valor.no_lista, 1);
                });
            }
        }

        function pintar_partes_extra(array_partes)
        {
            var html = ""

            $.each(array_partes, function(index, valor)
            {
                var nodo = valor.id_seccion + "_" + valor.no_lista;
                
                html += '<li class="list-group-item" id="'+ nodo +'">'+
                                '<div class="row">'+
                                    '<div style="margin-left: auto; margin-right: 15px;" class="eliminar">'+
                                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close" onClick="eliminar_nodo('+ nodo + ')">'+
                                            '<span aria-hidden="true"><i class="fa fa-close" style="color: red"></i></span>'+
                                        '</button>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="row">'+
                                    '<div class="col-lg-4">'+
                                        '<div class="form-group mg-b-10-force">'+
                                            '<label class="form-control-label">Tipo persona <span class="tx-danger">*</span></label>'+
                                            '<select class="_p_tipo  form-control" name="p_tipo_persona_' + valor.no_lista +'" id="p_tipo_persona_'+ valor.no_lista +'">'+
                                                '<option value="0">--Seleccione una opción--</option>'+
                                                '<option value="fisica">Física</option>'+
                                                '<option value="moral">Moral</option>'+
                                            '</select>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="row" name="datos_p_persona_'+ valor.no_lista +'" id="datos_p_persona_'+ valor.no_lista +'"></div>'+
                            '</li>';
            });

            return html;
        }

        function agregar_parte_extra()
        {
            contador_li++;
            var nodo = id_seccion + "_" + contador_li;

            var html = '<li class="list-group-item" id="'+ nodo +'">'+
                            '<div class="row">'+
                                '<div style="margin-left: auto; margin-right: 15px;" class="eliminar">'+
                                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close" onClick="eliminar_nodo('+ nodo + ')">'+
                                        '<span aria-hidden="true"><i class="fa fa-close" style="color: red"></i></span>'+
                                    '</button>'+
                                '</div>'+
                            '</div>'+
                            '<div class="row">'+
                                '<div class="col-lg-4">'+
                                    '<div class="form-group mg-b-10-force">'+
                                        '<label class="form-control-label">Tipo persona <span class="tx-danger">*</span></label>'+
                                        '<select class="_p_tipo  form-control" name="p_tipo_persona_' + contador_li +'" id="p_tipo_persona_'+ contador_li +'">'+
                                            '<option value="0">--Seleccione una opción--</option>'+
                                            '<option value="Física">Física</option>'+
                                            '<option value="Moral">Moral</option>'+
                                        '</select>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                            '<div class="row" name="datos_p_persona_'+ contador_li +'" id="datos_p_persona_'+ contador_li +'"></div>'+
                        '</li>';

            $("#lista_partes_extra").append(html);

            $("._p_tipo").change(function()
            {
                generar_campos_tipo($("#" + this.id).val(), this.id, 0);
            });
        }

        function agregar_parte_existente()
        {
            if( $("#partes_existentes").val() != "0" && $("#partes_participantes").val() != "0" )
            {
                var resultado = "";
                
                p_nombre = "";
                p_paterno = "";
                p_materno = "";
                
                if( $("#partes_existentes").val() == "Actor" )
                {
                    resultado = resultados[0].partes.actor.filter(x => x.parte_id == $("#partes_participantes").val());
                }
                else if( $("#partes_existentes").val() == "Demandado" )
                {
                    resultado = resultados[0].partes.demandado.filter(x => x.parte_id == $("#partes_participantes").val());
                }

                if(resultado.length > 0)
                {
                    contador_li ++;
                    var nodo = id_seccion + "_" + contador_li;

                    p_nombre = (resultado[0].nombre != 'null') ? resultado[0].nombre: "";
                    p_paterno = (resultado[0].apellido_paterno !== null) ? resultado[0].apellido_paterno: "";
                    p_materno = (resultado[0].apellido_materno !== null) ? resultado[0].apellido_materno: "";

                    var html = '<li class="list-group-item" id="'+ nodo +'">'+
                                '<div class="row">'+
                                    '<div style="margin-left: auto; margin-right: 15px;" class="eliminar">'+
                                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close" onClick="eliminar_nodo('+ nodo + ')">'+
                                            '<span aria-hidden="true"><i class="fa fa-close" style="color: red"></i></span>'+
                                        '</button>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="row">'+
                                    '<div class="col-lg-4">'+
                                        '<div class="form-group mg-b-10-force">'+
                                            '<label class="form-control-label">Tipo persona <span class="tx-danger">*</span></label>'+
                                            '<select class="_p_tipo  form-control" name="p_tipo_persona_' + contador_li +'" id="p_tipo_persona_'+ contador_li +'">'+
                                                '<option value="0">--Seleccione una opción--</option>'+
                                                '<option value="fisica">Física</option>'+
                                                '<option value="moral">Moral</option>'+
                                            '</select>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="row" name="datos_p_persona_'+ contador_li +'" id="datos_p_persona_'+ contador_li +'"></div>'+
                            '</li>';

                    $("#lista_partes_extra").append(html);

                    $("._p_tipo").change(function()
                    {
                        generar_campos_tipo($("#" + this.id).val(), this.id, 0);
                    });
                
                    $("#p_tipo_persona_" + contador_li).val(resultado[0].parte_tipo_persona);

                    generar_campos_tipo(resultado[0].parte_tipo_persona, 'p_tipo_persona_' + contador_li, 1);
                }
                else
                {
                    mostrar_alerta("mensaje_partes_extra", "warning", "No se encontro la parte seleccionada");
                }
            }
            else
            {
                mostrar_alerta("mensaje_partes_extra", "warning", "Debe seleccionar una parte existente");
            }
        }

        function generar_campos_tipo(valor_elemento, id_lugar, bandera)
        {
            var no_lista = id_lugar.substring(15, id_lugar.length);

            if(bandera === 0)
            {
                p_nombre = $("#p_nombre_persona_" + no_lista).val();
                p_paterno = $("#p_paterno_persona_" + no_lista).val();
                p_materno = $("#p_materno_persona_" + no_lista).val();
            }

            if(valor_elemento == "Física")
            {
                $("#datos_p_persona_" + no_lista).empty();

                var html =  '<div class="col-lg-4">'+
                                '<div class="form-group mg-b-10-force">'+
                                    '<label class="form-control-label">Nombre<span class="tx-danger">*</span></label>'+
                                    '<input class="form-control" type="text" name="p_nombre_persona_'+ no_lista +'" id="p_nombre_persona_'+ no_lista +'">'+
                                '</div>'+
                            '</div>'+
                            '<div class="col-lg-4">'+
                                '<div class="form-group mg-b-10-force">'+
                                    '<label class="form-control-label">Apellido paterno</label>'+
                                    '<input class="form-control" type="text" name="p_paterno_persona_'+ no_lista +'" id="p_paterno_persona_'+ no_lista +'">'+
                                '</div>'+
                            '</div>'+
                            '<div class="col-lg-4">'+
                                '<div class="form-group mg-b-10-force">'+
                                    '<label class="form-control-label">Apellido materno</label>'+
                                    '<input class="form-control" type="text" name="p_materno_persona_'+ no_lista +'" id="p_materno_persona_'+ no_lista +'">'+
                                '</div>'+
                            '</div>';

                $("#datos_p_persona_" + no_lista).html(html);

                $("#p_nombre_persona_" + no_lista).val(p_nombre);
                $("#p_paterno_persona_" + no_lista).val(p_paterno);
                $("#p_materno_persona_" + no_lista).val(p_materno);
            }

            else if(valor_elemento == "Moral")
            {
                $("#datos_p_persona_" + no_lista).empty();

                var html =  '<div class="col-lg-12">'+
                                '<div class="form-group mg-b-10-force">'+
                                    '<label class="form-control-label">Razón Social<span class="tx-danger">*</span></label>'+
                                    '<input class="form-control" type="text" name="p_nombre_persona_'+ no_lista +'" id="p_nombre_persona_'+ no_lista +'">'+
                                '</div>'+
                            '</div>';

                $("#datos_p_persona_" + no_lista).html(html);

                $("#p_nombre_persona_" + no_lista).val(p_nombre);
            }
        }

        function guardar_partes_extra()
        {
            var contador = 0;

            var eliminar = array_partes_extra.filter(x=>x.id_seccion === id_seccion);

            $.each(eliminar, function(index, valor)
            {
                var i = array_partes_extra.indexOf(valor);

                if(i !== -1)
                {
                    array_partes_extra.splice(i, 1);
                }
            });

            $("#lista_partes_extra li").each(function()
            {
                var long_base = (id_seccion.length + 1);
                var long_seccion = this.id.length;

                var no_lista = this.id.substring(long_base, long_seccion);
                
                var tipo_p = $("#p_tipo_persona_" + no_lista);
                var nombre_p = $("#p_nombre_persona_" + no_lista);
                var paterno_p = $("#p_paterno_persona_" + no_lista);
                var materno_p = $("#p_materno_persona_" + no_lista);
                
                var parte_extra = new Object();
                parte_extra.id_seccion = id_seccion;
                parte_extra.tipo_persona = tipo_p.val();
                parte_extra.nombre_p = nombre_p.val();
                parte_extra.paterno_p = (typeof paterno_p.val() !== "undefined") ? paterno_p.val() : "";
                parte_extra.materno_p = (typeof materno_p.val() !== "undefined") ? materno_p.val() : "";
                parte_extra.no_lista = no_lista;

                if($.trim(parte_extra.nombre_p).length > 0 && parte_extra.tipo_persona != "0")
                {
                    var existe = array_partes_extra.filter(x=>x.id_seccion == parte_extra.id_seccion && x.no_lista == parte_extra.no_lista);
                    
                    if(existe.length == 0)
                    {
                        array_partes_extra.push(parte_extra);
                    }
                }
                else
                {
                    contador++;
                }
            });

            if(contador > 0)
            {
                mostrar_alerta("mensaje_partes_extra", "warning", "Solo se agregaran los campos llenados correctamente");
            }

            else
            {
                mostrar_alerta("mensaje_partes_extra", "success", "Se almacenaron los datos correctamente");
            }
        }

        function eliminar_nodo(id_seccion)
        {
            $("#" + id_seccion.id).remove();
        }

        //SECCIONES DIFERENTES
        function seccion_certificado()
        {
            try
            {
                contador_li = 0;

                $("#titulo_modal_general").empty();
                $("#body_modal_general").empty();
                $("#mensaje_modal_general").empty();
                $("#acciones_modal_general").empty();

                var html =  '<div class="col-md-12" style="margin:15px;">'+
                            '<button name="agregar_registro" id="agregar_registro" class="btn btn-primary btn-sm" type="button" onClick="agregar_certificado(0,0)">Agregar certificado</button>'+
                            '</div>'+
                            '<div col-md-12 id="mensaje_modal_general"></div>'+
                            '<ul class="list-group list-group-striped mg-b-25" id="lista_general_partes"></ul>';
                            
                var botones = '<a class="btn btn-success btn-sm" href="#agregar_registro" onclick="guardar_certificados()">Agregar</a> <button class="btn btn-danger btn-sm" data-dismiss="modal">Cerrar</button>';

                $("#titulo_modal_general").html("Certificados");
                $("#acciones_modal_general").html(botones);
                $("#body_modal_general").html(html);

                partes_extra_certificado();
            }

            catch(exp)
            {
                console.log(exp);
                mostrar_alerta("mensaje_modal_general", "danger", "Ocurrio un error");
            }
        }
        
        function partes_extra_certificado()
        {
            try
            {
                if(array_certificados.length > 0)
                {
                    array_certificados.sort(function(a,b){return a.no_lista-b.no_lista});
                
                    array_certificados.reverse();
                    
                    contador_li = array_certificados[0].no_lista;
                    
                    array_certificados.reverse();

                    $.each(array_certificados, function(index, value)
                    {
                        if(value.eliminado == "")
                        {
                            agregar_certificado(value.no_lista, value.id_db)
                        }

                        $.each(value.datos, function(indice, valor)
                        {
                            $("#" + valor.name).val(valor.value);
                        });
                    });
                }
            }
            catch(exp)
            {
                console.log(exp);
                mostrar_alerta("mensaje_modal_general", "danger", "Ocurrio un error al cargar los certificados existentes");
            }
        }

        function agregar_certificado(contador, id_db)
        {
            try
            {
                var numero;

                if(contador == 0)
                {
                    contador_li++;
                    numero = contador_li;
                }

                else
                {
                    numero = contador;
                }

                var html = '<li class="list-group-item" id="elemento_'+numero+'" id_db="'+id_db+'">'+
                            '<div class="row">'+
                                '<div style="margin-left: auto; margin-right: 15px;" class="eliminar">'+
                                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close" onClick="quitar_li(\'elemento_'+numero+'\')">'+
                                        '<span aria-hidden="true"><i class="fa fa-close" style="color: red"></i></span>'+
                                    '</button>'+
                                '</div>'+
                            '</div>'+

                            '<form class="row" id_li ="'+numero+'" id="form_certificados_'+numero+'" action="javascript:void(0);" id_db="">'+
                                '<div class="form-group col-md-4">'+
                                    '<label>Fecha de expedición</label>'+
                                    '<input type="date" class="form-control" name="fecha_expedicion_'+numero+'" id="fecha_expedicion_'+numero+'">'+
                                '</div>'+
                                '<div class="form-group col-md-4">'+
                                    '<label>Fecha de ingreso</label>'+
                                    '<input type="date" class="form-control" name="fecha_ingreso_'+numero+'" id="fecha_ingreso_'+numero+'">'+
                                '</div>'+
                                '<div class="form-group col-md-4">'+
                                    '<label>No. de certificado o documento</label>'+
                                    '<input type="text" class="form-control" name="no_certificado_'+numero+'" id="no_certificado_'+numero+'">'+
                                '</div>'+
                                '<div class="form-group col-md-6">'+
                                    '<label>Importe del certificado o documento</label>'+
                                    '<div class="input-group">'+
                                        '<div class="input-group-prepend">'+
                                            '<span class="input-group-text">$</span>'+
                                        '</div>'+
                                        '<input name="importe_documento_'+numero+'" id="importe_documento_'+numero+'" class="form-control" type="text" value="0" onkeypress="mascara(this,cpf)"  onpaste="return false">'+
                                    '</div>'+
                                '</div>'+
                                '<div class="form-group col-md-6">'+
                                    '<label>Institución que lo expide</label>'+
                                    '<input type="text" class="form-control" name="institucion_expide_'+numero+'" id="institucion_expide_'+numero+'">'+
                                '</div>'+
                                '<div class="row col-md-12 _div_tipos" id="datos_beneficiario_'+numero+'">'+
                                    '<div class="form-group col-md-4">'+
                                        '<label>Nombre del beneficiario</label>'+
                                        '<select class="_tipos form-control" id_t="datos_beneficiario_'+numero+'" id="tipo_beneficiario_'+numero+'">'+
                                            '<option value="0">--Seleccione una opción--</option>'+
                                            '<option value="Física">Física</option>'+
                                            '<option value="Moral">Moral</option>'+
                                        '</select>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="form-group col-md-4">'+
                                    '<label>Asiento de caja del folio</label>'+
                                    '<input type="text" class="form-control" name="asiencto_caja_'+numero+'" id="asiencto_caja_'+numero+'">'+
                                '</div>'+
                                '<div class="form-group col-md-4">'+
                                    '<label>Fecha de entrega</label>'+
                                    '<input type="date" class="form-control" name="fecha_entrega_'+numero+'" id="fecha_entrega_'+numero+'">'+
                                '</div>'+
                                '<div class="form-group col-md-6">'+
                                    '<label>Concepto</label>'+
                                    '<input type="text" class="form-control" name="concepto_'+numero+'" id="concepto_'+numero+'">'+
                                '</div>'+
                                '<div class="form-group col-md-6">'+
                                    '<label>Cáracter con el que recibe</label>'+
                                    '<input type="text" class="form-control" name="caracter_recibe_'+numero+'" id="caracter_recibe_'+numero+'">'+
                                '</div>'+
                                '<div class="form-group col-md-6">'+
                                    '<label>Identificación</label>'+
                                    '<input type="text" class="form-control" name="identificacion_'+numero+'" id="identificacion_'+numero+'">'+
                                '</div>'+
                                '<div class="form-group col-md-4">'+
                                    '<label>Firma del benficiario</label>'+
                                    '<button name="firma_beneficiario_'+numero+'" id="firma_beneficiario_'+numero+'" class="btn btn-default btn-sm" disabled="">Biometrico</button>'+
                                '</div>'+
                                '<div class="form-group col-md-4">'+
                                    '<label>Huella del beneficiario</label>'+
                                    '<button name="huella_beneficiario_'+numero+'" id="huella_beneficiario_'+numero+'" class="btn btn-default btn-sm" disabled="">Biometrico</button>'+
                                '</div>'+
                                '<div class="form-group col-md-4">'+
                                    '<label>Nombre y firma del juez</label>'+
                                    '<button name="firma_juez_'+numero+'" id="firma_juez_'+numero+'" class="btn btn-default btn-sm" disabled="">Biometrico</button>'+
                                '</div>'+
                                '<div class="form-group col-md-4">'+
                                    '<label>Nombre y firma del secretario</label>'+
                                    '<button name="firma_secretario_'+numero+'" id="firma_secretario_'+numero+'" class="btn btn-default btn-sm" disabled="">Biometrico</button>'+
                                '</div>'+
                                '<div class="form-group col-md-12">'+
                                    '<label>Observaciones</label>'+
                                    '<textarea class="form-control" name="observaciones_'+numero+'" id="observaciones_'+numero+'"></textarea>'+
                                '</div>'+
                            '</form>'+
                        '</li>';
            
                $("#lista_general_partes").append(html);

                $("input").click(function()
                {
                    $("#" + this.id).removeClass("is-invalid");
                });

                $("._tipos").click(function()
                {
                    $("#" + this.id).removeClass("is-invalid");
                });

                $("._tipos").change(function()
                {
                    var id_seccion_tipo = $("#" + this.id).attr("id_t");

                    var num = id_seccion_tipo.substring(19, id_seccion_tipo.length);
                    
                    if($("#" + this.id).val() == "Física")
                    {
                        $("._dato_tipo_"+num).remove();

                        var html = '<div class="_dato_tipo_'+num+' form-group col-md-4">'+
                                        '<label>A. paterno</label>'+
                                        '<input type="text" class="form-control" name="tipo_paterno_'+num+'" id="tipo_paterno_'+num+'">'+
                                    '</div>'+
                                    '<div class="_dato_tipo_'+num+' form-group col-md-4">'+
                                        '<label>A. Materno</label>'+
                                        '<input type="text" class="form-control" name="tipo_materno_'+num+'" id="tipo_materno_'+num+'">'+
                                    '</div>'+
                                    '<div class="_dato_tipo_'+num+' form-group col-md-4">'+
                                        '<label>Nombre(s)</label>'+
                                        '<input type="text" class="form-control" name="tipo_nombres_'+num+'" id="tipo_nombres_'+num+'">'+
                                    '</div>';

                        $("#" + id_seccion_tipo).append(html);
                    }

                    else if($("#" + this.id).val() == "Moral")
                    {
                        $("._dato_tipo_"+num).remove();

                        var html = '<div class="_dato_tipo_'+num+' form-group col-md-12">'+
                                        '<label>Razón Social</label>'+
                                        '<input type="text" class="form-control" name="tipo_razon_social_'+num+'" id="tipo_razon_social_'+num+'">'+
                                    '</div>';

                        $("#" + id_seccion_tipo).append(html);
                    }

                    else
                    {
                        $("._dato_tipo_"+num).remove();
                    }

                    $("input").click(function()
                    {
                        $("#" + this.id).removeClass("is-invalid");
                    });
                });
            }

            catch(exp)
            {
                console.log(exp);
            }
        }

        function guardar_certificados()
        {
            var datos = $("#lista_general_partes form");
            var contador_tipo = 0;
            var contador_general = 0;
            const regex = /[^0-9\s]/gi;

            if(datos.length == 0)
            {
                var datos_db = array_certificados.filter(x=>x.id_db != 0);

                $.each(datos_db, function(index, value)
                {
                    var indice = array_certificados.indexOf(x=>x.id_db == value.id_db);
                    array_certificados[indice].eliminado = "1";
                });
            }

            var existen = array_certificados.filter(x=>x.eliminado == "1");

            if(existen.length == 0)
            {
                array_certificados = [];
            }

            //RECORRIENDO LAS SECCIONES
            $.each(datos, function(index, value)
            {   
                var partes = $("#" + value.id + " ._tipos");
                var div_partes = $("#" + value.id + " ._div_tipos");
                var num_limpio = 0;
                var id_db = $("#" + value.id).attr("id_db");

                if($("#" + partes[0].id).val() == "Física" || $("#" + partes[0].id).val() == "Moral")
                {
                    var json =  $('#' + value.id).serializeArray();
                    
                    json.push({name:partes[0].id, value: $("#" + partes[0].id).val()});
                    
                    var contador_campos = 0;

                    //RECORRIENDO LOS DATOS DE CADA SECCION
                    $.each(json, function(indice, valor)
                    {
                        if($.trim(valor.value).length > 0)
                        {
                            $("#" + valor.name).removeClass("is-invalid");
                            num_limpio = valor.name.replace(regex, "");
                        }

                        else
                        {
                            $("#" + valor.name).addClass("is-invalid");
                            contador_campos++;
                            contador_general++;
                        }
                    });

                    if(contador_campos == 0)
                    {
                        var objeto_certificado = new Object();
                        objeto_certificado.id_db = id_db;
                        objeto_certificado.no_lista = num_limpio;
                        objeto_certificado.eliminado = "";
                        objeto_certificado.id_seccion_certificado = "elemento_" + num_limpio;
                        objeto_certificado.datos = json;
                        
                        var existe = array_certificados.filter(x => x.id_seccion_certificado == "elemento_" + num_limpio);

                        if(existe == 0)
                        {
                            array_certificados.push(objeto_certificado);
                        }

                        mostrar_alerta("mensaje_modal_general", "success", "Datos almacenados correctamente");

                        $("#modal_general").modal("hide");
                    }

                }
                else
                {
                    $("#" + partes[0].id).addClass("is-invalid");
                    contador_tipo++;
                }
            });

            if(contador_tipo > 0)
            {
                mostrar_alerta("mensaje_modal_general", "warning", "No se a seleccionado el tipo de beneficiario en " + contador_tipo + " registros");
            }

            if(contador_general > 0)
            {
                mostrar_alerta("mensaje_modal_general", "warning", "Existen " + contador_general + " campos vacios, favor de llenarlos todos");
            }

            console.log(array_certificados);
        }

        function quitar_li(id)
        {
            var datos_elemento = array_certificados.filter(x=>x.id_seccion_certificado == id && x.id_db != 0);

            if(datos_elemento.length > 0)
            {
                var index = array_certificados.indexOf(x=>x.id_db == datos_elemento[0].id_db);
                
                array_certificados[index].eliminado = "1";
            }

            else
            {
                $("#" + id).remove();
            }
        }

        //DILIGENCIAS
        function seccion_diligencia(id)
        {
            contador_li = 0;

            $("#titulo_modal_general").empty();
            $("#body_modal_general").empty();
            $("#mensaje_modal_general").empty();
            $("#acciones_modal_general").empty();

            var html =  '<div class="col-md-12" style="margin:15px;">'+
                            '<button name="agregar_diligencia" id="agregar_diligencia" class="btn btn-primary btn-sm" type="button" onClick="agregar_diligencia()">Agregar nueva</button>'+
                            '</div>'+
                            '<div col-md-12 id="mensaje_modal_general"></div>'+
                            '<ul class="list-group list-group-striped mg-b-25" id="lista_general_diligencia"></ul>';
                            
            var botones = '<a class="btn btn-success btn-sm" href="#agregar_diligencia" onclick="guardar_diligencias()">Agregar</a> <button class="btn btn-danger btn-sm" data-dismiss="modal">Cerrar</button>';

            $("#titulo_modal_general").html("Diligencias");
            $("#acciones_modal_general").html(botones);
            $("#body_modal_general").html(html);

            mostrar_diligencias(id);
        }

        function agregar_diligencia()
        {
            contador_li++;
            var nodo = id_seccion + "_" + contador_li;

            var html = '<li class="list-group-item" id="'+ nodo +'">'+
                            '<div class="row">'+
                                '<div style="margin-left: auto; margin-right: 15px;" class="eliminar">'+
                                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close" onClick="eliminar_nodo('+ nodo + ')">'+
                                        '<span aria-hidden="true"><i class="fa fa-close" style="color: red"></i></span>'+
                                    '</button>'+
                                '</div>'+
                            '</div>'+
                            '<div class="row">'+
                                '<div class="col-lg-6">'+
                                    '<div class="form-group mg-b-10-force">'+
                                        '<label class="form-control-label">Diligencia encomendada<span class="tx-danger">*</span></label>'+
                                        '<input type="text" class="form-control" name="diligencia_encomendada_'+contador_li+'" id="diligencia_encomendada_'+contador_li+'">'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-lg-6">'+
                                    '<div class="form-group mg-b-10-force">'+
                                        '<label class="form-control-label">Fecha de diligenciación<span class="tx-danger">*</span></label>'+
                                        '<input type="date" class="form-control" name="fecha_diligenciacion_'+contador_li+'" id="fecha_diligenciacion_'+contador_li+'">'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-lg-6">'+
                                    '<div class="form-group mg-b-10-force">'+
                                        '<label class="form-control-label">Se diligenció<span class="tx-danger">*</span></label>'+
                                        '<select class="_p_tipo  form-control" name="se_diligencio_'+contador_li+'" id="se_diligencio_'+contador_li+'">'+
                                            '<option value="">--Seleccione una opción--</option>'+
                                            '<option value="Si">Si</option>'+
                                            '<option value="No">No</option>'+
                                            '<option value="Parcialmente">Parcialmente</option>'+
                                        '</select>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</li>';

            $("#lista_general_diligencia").append(html);
        }

        function mostrar_diligencias(id) 
        {
            contador_li = 0;
            console.log(array_partes_extra);
            var array_partes = array_partes_extra.filter(x =>x.id_seccion == id);
            console.log(array_partes);

            if(array_partes.length > 0)
            {
                array_partes.sort(function(a,b){return a.no_lista-b.no_lista});
                
                var array_inverso = array_partes.reverse();
                
                contador_li = array_partes[0].no_lista;
                
                array_partes.reverse();

                $.each(array_partes, function(index, valor)
                {
                    var nodo = valor.id_seccion + "_" + valor.no_lista;

                    var html = '<li class="list-group-item" id="'+ nodo +'">'+
                            '<div class="row">'+
                                '<div style="margin-left: auto; margin-right: 15px;" class="eliminar">'+
                                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close" onClick="eliminar_nodo('+ nodo + ')">'+
                                        '<span aria-hidden="true"><i class="fa fa-close" style="color: red"></i></span>'+
                                    '</button>'+
                                '</div>'+
                            '</div>'+
                            '<div class="row">'+
                                '<div class="col-lg-6">'+
                                    '<div class="form-group mg-b-10-force">'+
                                        '<label class="form-control-label">Diligencia encomendada<span class="tx-danger">*</span></label>'+
                                        '<input type="text" class="form-control" name="diligencia_encomendada_'+valor.no_lista+'" id="diligencia_encomendada_'+valor.no_lista+'">'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-lg-6">'+
                                    '<div class="form-group mg-b-10-force">'+
                                        '<label class="form-control-label">Fecha de diligenciación<span class="tx-danger">*</span></label>'+
                                        '<input type="date" class="form-control" name="fecha_diligenciacion_'+valor.no_lista+'" id="fecha_diligenciacion_'+valor.no_lista+'">'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-lg-6">'+
                                    '<div class="form-group mg-b-10-force">'+
                                        '<label class="form-control-label">Se diligenció<span class="tx-danger">*</span></label>'+
                                        '<select class="_p_tipo  form-control" name="se_diligencio_'+valor.no_lista+'" id="se_diligencio_'+valor.no_lista+'">'+
                                            '<option value="">--Seleccione una opción--</option>'+
                                            '<option value="Si">Si</option>'+
                                            '<option value="No">No</option>'+
                                            '<option value="Parcialmente">Parcialmente</option>'+
                                        '</select>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</li>';

                    $("#lista_general_diligencia").append(html);

                    $("#diligencia_encomendada_" + valor.no_lista).val(valor.diligencia_encomendada);
                    $("#fecha_diligenciacion_" + valor.no_lista).val(valor.fecha_diligenciacion);
                    $("#se_diligencio_" + valor.no_lista).val(valor.se_diligencio);
                });
            }
        }

        function guardar_diligencias()
        {
            var contador = 0;

            var eliminar = array_partes_extra.filter(x=>x.id_seccion === id_seccion);

            $.each(eliminar, function(index, valor)
            {
                var i = array_partes_extra.indexOf(valor);

                if(i !== -1)
                {
                    array_partes_extra.splice(i, 1);
                }
            });

            $("#lista_general_diligencia li").each(function()
            {
                var long_base = (id_seccion.length + 1);
                var long_seccion = this.id.length;

                var no_lista = this.id.substring(long_base, long_seccion);
                
                var diligencia_encomendada = $("#diligencia_encomendada_" + no_lista);
                var fecha_diligenciacion = $("#fecha_diligenciacion_" + no_lista);
                var se_diligencio = $("#se_diligencio_" + no_lista);
                
                var parte_extra = new Object();
                parte_extra.id_seccion = id_seccion;
                parte_extra.no_lista = no_lista;
                parte_extra.diligencia_encomendada = (typeof diligencia_encomendada.val() !== "undefined") ? diligencia_encomendada.val() : "";
                parte_extra.fecha_diligenciacion = (typeof fecha_diligenciacion.val() !== "undefined") ? fecha_diligenciacion.val() : "";
                parte_extra.se_diligencio = (typeof se_diligencio.val() !== "undefined") ? se_diligencio.val() : "";
                

                if($.trim(parte_extra.diligencia_encomendada).length > 0 && $.trim(parte_extra.fecha_diligenciacion).length > 0 && $.trim(parte_extra.se_diligencio).length > 0)
                {
                    var existe = array_partes_extra.filter(x=>x.id_seccion == parte_extra.id_seccion && x.no_lista == parte_extra.no_lista);
                    
                    if(existe.length == 0)
                    {
                        array_partes_extra.push(parte_extra);
                    }
                }
                else
                {
                    contador++;
                }
            });

            if(contador > 0)
            {
                mostrar_alerta("mensaje_modal_general", "warning", "Solo se agregaran los campos llenados correctamente");
            }

            else
            {
                mostrar_alerta("mensaje_modal_general", "success", "Se almacenaron los datos correctamente");

                $("#modal_general").modal("hide");

                console.log(array_partes_extra);
            }
        }

        //DILIGENCIAS_2
        function seccion_diligencia_2(id)
        {
            contador_li = 0;

            $("#titulo_modal_general").empty();
            $("#body_modal_general").empty();
            $("#mensaje_modal_general").empty();
            $("#acciones_modal_general").empty();

            var html =  '<div class="col-md-12" style="margin:15px;">'+
                            '<button name="agregar_diligencia" id="agregar_diligencia" class="btn btn-primary btn-sm" type="button" onClick="agregar_diligencia_2()">Agregar nueva</button>'+
                            '</div>'+
                            '<div col-md-12 id="mensaje_modal_general"></div>'+
                            '<ul class="list-group list-group-striped mg-b-25" id="lista_general_diligencia"></ul>';
                            
            var botones = '<a class="btn btn-success btn-sm" href="#agregar_diligencia" onclick="guardar_diligencias_2()">Agregar</a> <button class="btn btn-danger btn-sm" data-dismiss="modal">Cerrar</button>';

            $("#titulo_modal_general").html("Diligencias");
            $("#acciones_modal_general").html(botones);
            $("#body_modal_general").html(html);

            mostrar_diligencias_2(id);
        }

        function mostrar_diligencias_2(id) 
        {
            contador_li = 0;
            console.log(array_partes_extra);
            var array_partes = array_partes_extra.filter(x =>x.id_seccion == id);
            console.log(array_partes);
            if(array_partes.length > 0)
            {
                array_partes.sort(function(a,b){return a.no_lista-b.no_lista});
                
                var array_inverso = array_partes.reverse();
                
                contador_li = array_partes[0].no_lista;
                
                array_partes.reverse();

                $.each(array_partes, function(index, valor)
                {
                    var nodo = valor.id_seccion + "_" + valor.no_lista;
                    
                    var html = '<li class="list-group-item" id="'+ nodo +'">'+
                            '<div class="row">'+
                                '<div style="margin-left: auto; margin-right: 15px;" class="eliminar">'+
                                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close" onClick="eliminar_nodo('+ nodo + ')">'+
                                        '<span aria-hidden="true"><i class="fa fa-close" style="color: red"></i></span>'+
                                    '</button>'+
                                '</div>'+
                            '</div>'+
                            '<div class="row">'+
                                '<div class="col-lg-6">'+
                                    '<div class="form-group mg-b-10-force">'+
                                        '<label class="form-control-label">Número de cedula<span class="tx-danger">*</span></label>'+
                                        '<input type="text" class="form-control" name="no_cedula_'+valor.no_lista+'" id="no_cedula_'+valor.no_lista+'">'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-lg-6">'+
                                    '<div class="form-group mg-b-10-force">'+
                                        '<label class="form-control-label">Persona a notificar<span class="tx-danger">*</span></label>'+
                                        '<select class="_p_tipo  form-control" name="p_tipo_persona_' + valor.no_lista +'" id="p_tipo_persona_'+ valor.no_lista +'">'+
                                            '<option value="">--Seleccione una opción--</option>'+
                                            '<option value="Física">Física</option>'+
                                            '<option value="Moral">Moral</option>'+
                                        '</select>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-lg-12 row" name="datos_p_persona_'+ valor.no_lista +'" id="datos_p_persona_'+ valor.no_lista +'"></div>'+
                                '<div class="col-lg-12">'+
                                    '<div class="form-group mg-b-10-force">'+
                                        '<label class="form-control-label">Lugar donde debe actuarse<span class="tx-danger">*</span></label>'+
                                        '<textarea class="form-control" name="lugar_actuarse_'+valor.no_lista+'" id="lugar_actuarse_'+valor.no_lista+'"></textarea>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-lg-6">'+
                                    '<div class="form-group mg-b-10-force">'+
                                        '<label class="form-control-label">Fecha de la diligencia<span class="tx-danger">*</span></label>'+
                                        '<input type="date" class="form-control" name="fecha_diligencia_'+valor.no_lista+'" id="fecha_diligencia_'+valor.no_lista+'">'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-lg-6">'+
                                    '<div class="form-group mg-b-10-force">'+
                                        '<label class="form-control-label">Fecha de la devolución<span class="tx-danger">*</span></label>'+
                                        '<input type="date" class="form-control" name="fecha_devolucion_'+valor.no_lista+'" id="fecha_devolucion_'+valor.no_lista+'">'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</li>';

                    $("#lista_general_diligencia").append(html);

                    $("._p_tipo").change(function()
                    {
                        generar_campos_tipo($("#" + this.id).val(), this.id, 0);
                    });

                    p_nombre = valor.nombre_p;
                    p_paterno = valor.paterno_p;
                    p_materno = valor.materno_p;

                    $("#p_tipo_persona_" + valor.no_lista).val(valor.tipo_persona);
                    $("#no_cedula_" + valor.no_lista).val(valor.no_cedula);
                    $("#p_tipo_persona_" + valor.no_lista).val(valor.tipo_persona);
                    $("#lugar_actuarse_" + valor.no_lista).val(valor.lugar_actuarse);
                    $("#fecha_diligencia_" + valor.no_lista).val(valor.fecha_diligencia);
                    $("#fecha_devolucion_" + valor.no_lista).val(valor.fecha_devolucion);

                    generar_campos_tipo(valor.tipo_persona, 'p_tipo_persona_' + valor.no_lista, 1);
                });
            }
        }

        function agregar_diligencia_2()
        {
            contador_li++;
            var nodo = id_seccion + "_" + contador_li;

            var html = '<li class="list-group-item" id="'+ nodo +'">'+
                            '<div class="row">'+
                                '<div style="margin-left: auto; margin-right: 15px;" class="eliminar">'+
                                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close" onClick="eliminar_nodo('+ nodo + ')">'+
                                        '<span aria-hidden="true"><i class="fa fa-close" style="color: red"></i></span>'+
                                    '</button>'+
                                '</div>'+
                            '</div>'+
                            '<div class="row">'+
                                '<div class="col-lg-6">'+
                                    '<div class="form-group mg-b-10-force">'+
                                        '<label class="form-control-label">Número de cedula<span class="tx-danger">*</span></label>'+
                                        '<input type="text" class="form-control" name="no_cedula_'+contador_li+'" id="no_cedula_'+contador_li+'">'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-lg-6">'+
                                    '<div class="form-group mg-b-10-force">'+
                                        '<label class="form-control-label">Persona a notificar<span class="tx-danger">*</span></label>'+
                                        '<select class="_p_tipo  form-control" name="p_tipo_persona_' + contador_li +'" id="p_tipo_persona_'+ contador_li +'">'+
                                            '<option value="">--Seleccione una opción--</option>'+
                                            '<option value="Física">Física</option>'+
                                            '<option value="Moral">Moral</option>'+
                                        '</select>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-lg-12 row" name="datos_p_persona_'+ contador_li +'" id="datos_p_persona_'+ contador_li +'"></div>'+
                                '<div class="col-lg-12">'+
                                    '<div class="form-group mg-b-10-force">'+
                                        '<label class="form-control-label">Lugar donde debe actuarse<span class="tx-danger">*</span></label>'+
                                        '<textarea class="form-control" name="lugar_actuarse_'+contador_li+'" id="lugar_actuarse_'+contador_li+'"></textarea>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-lg-6">'+
                                    '<div class="form-group mg-b-10-force">'+
                                        '<label class="form-control-label">Fecha de la diligencia<span class="tx-danger">*</span></label>'+
                                        '<input type="date" class="form-control" name="fecha_diligencia_'+contador_li+'" id="fecha_diligencia_'+contador_li+'">'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-lg-6">'+
                                    '<div class="form-group mg-b-10-force">'+
                                        '<label class="form-control-label">Fecha de la devolución<span class="tx-danger">*</span></label>'+
                                        '<input type="date" class="form-control" name="fecha_devolucion_'+contador_li+'" id="fecha_devolucion_'+contador_li+'">'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</li>';

            $("#lista_general_diligencia").append(html);

            $("._p_tipo").change(function()
            {
                generar_campos_tipo($("#" + this.id).val(), this.id, 0);
            });
        }

        function guardar_diligencias_2()
        {
            var contador = 0;

            var eliminar = array_partes_extra.filter(x=>x.id_seccion === id_seccion);

            $.each(eliminar, function(index, valor)
            {
                var i = array_partes_extra.indexOf(valor);

                if(i !== -1)
                {
                    array_partes_extra.splice(i, 1);
                }
            });

            $("#lista_general_diligencia li").each(function()
            {
                var long_base = (id_seccion.length + 1);
                var long_seccion = this.id.length;

                var no_lista = this.id.substring(long_base, long_seccion);                
                var no_cedula = $("#no_cedula_" + no_lista);
                var tipo_persona = $("#p_tipo_persona_" + no_lista);
                var nombre_p = $("#p_nombre_persona_" + no_lista);
                var paterno_p = $("#p_paterno_persona_" + no_lista);
                var materno_p = $("#p_materno_persona_" + no_lista);
                var lugar_actuarse = $("#lugar_actuarse_" + no_lista);
                var fecha_diligencia = $("#fecha_diligencia_" + no_lista);
                var fecha_devolucion = $("#fecha_devolucion_" + no_lista);
                
                var parte_extra = new Object();
                parte_extra.id_seccion = id_seccion;
                parte_extra.no_lista = no_lista;
                parte_extra.no_cedula = no_cedula.val();
                parte_extra.tipo_persona = tipo_persona.val();
                parte_extra.nombre_p = nombre_p.val();
                parte_extra.paterno_p = (typeof paterno_p.val() !== "undefined") ? paterno_p.val() : "";;
                parte_extra.materno_p = (typeof materno_p.val() !== "undefined") ? materno_p.val() : "";;
                parte_extra.lugar_actuarse = lugar_actuarse.val();
                parte_extra.fecha_diligencia = fecha_diligencia.val();
                parte_extra.fecha_devolucion = fecha_devolucion.val();
                
                if( $.trim(parte_extra.nombre_p).length > 0 && $.trim(parte_extra.no_cedula).length > 0 && $.trim(parte_extra.tipo_persona).length > 0 && 
                    $.trim(parte_extra.lugar_actuarse).length > 0 && $.trim(parte_extra.fecha_diligencia).length > 0 && $.trim(parte_extra.fecha_devolucion).length > 0 )
                {
                    var existe = array_partes_extra.filter(x=>x.id_seccion == parte_extra.id_seccion && x.no_lista == parte_extra.no_lista);
                    
                    if(existe.length == 0)
                    {
                        array_partes_extra.push(parte_extra);
                    }
                }
                else
                {
                    contador++;
                }
            });

            if(contador > 0)
            {
                mostrar_alerta("mensaje_modal_general", "warning", "Solo se agregaran los campos llenados correctamente");
            }

            else
            {
                mostrar_alerta("mensaje_modal_general", "success", "Se almacenaron los datos correctamente");

                $("#modal_general").modal("hide");

                console.log(array_partes_extra);
            }
        }

        //GENERACION DE ELEMENTOS
        function expandir_acordion(id_titulo)
        {
            if($("#" + id_titulo).hasClass("collapsed"))
            {
                $("#" + id_titulo).trigger('click');
            }
        }

        function generar_input_consecutivo(object)
        {
            try
            {
                var obligatorio = "";

                if(object.obligatorio === true)
                {
                    obligatorio = '<span class="tx-danger">*</span>';
                }

                var html =  '<div class="form-group col-md-'+ object.column_space +'" name="' + object.id_campo + '" id="' + object.id_campo + '">' +
                        '<label>' + object.label + ' ' + obligatorio +'</label>' +
                        '<input class="form-control" type="text" max="9999" min="1" name ="'+ object.id +'" id="'+ object.id +'" value="' + consecutivo + '" disabled="">' +
                        '</div>';
                return html;
            }
            catch(exp)
            {
                mostrar_alerta("alertas_formulario", "danger", exp)

                return "";
            }
        }

        function generar_input_number(object)
        {
            try
            {
                var obligatorio = "";

                if(object.obligatorio === true)
                {
                    obligatorio = '<span class="tx-danger">*</span>';
                }

                var html =  '<div class="form-group col-md-'+ object.column_space +'" name="' + object.id_campo + '" id="' + object.id_campo + '">' +
                        '<label>' + object.label + ' ' + obligatorio + '</label>' +
                        '<input class="_number form-control" type="'+ object.tipo +'" max="9999" min="1" name ="'+ object.id +'" id="'+ object.id +'" value="0">' +
                        '</div>';
                return html;
            }
            catch(exp)
            {
                mostrar_alerta("alertas_formulario", "danger", exp)

                return "";
            }
        }

        function generar_input_money(object)
        {
            try
            {
                var obligatorio = "";

                if(object.obligatorio === true)
                {
                    obligatorio = '<span class="tx-danger">*</span>';
                }

                var html =  '<div class="form-group col-md-'+ object.column_space +'" name="' + object.id_campo + '" id="' + object.id_campo + '">' +
                            '<label>' + object.label + ' ' + obligatorio + '</label>' +
                            '<div class="input-group">' +
                            '<div class="input-group-prepend">' +
                            '<span class="input-group-text">$</span>' +
                            '</div>' +
                            '<input class="form-control" type="text" name ="'+ object.id +'" id="'+ object.id +'" value="0" onkeypress="mascara(this,cpf)"  onpaste="return false">' +
                            '</div>' +
                            '</div>';
                return html;
            }
            catch(exp)
            {
                mostrar_alerta("alertas_formulario", "danger", exp)

                return "";
            }
        }

        function generar_input(object)
        {
            try
            {
                var obligatorio = "";

                if(object.obligatorio === true)
                {
                    obligatorio = '<span class="tx-danger">*</span>';
                }

                var html =  '<div class="form-group col-md-'+ object.column_space +'" name="' + object.id_campo + '" id="' + object.id_campo + '">' +
                            '<label>' + object.label + ' ' + obligatorio + '</label>' +
                            '<input class="form-control" name ="'+ object.id +'" id="'+ object.id +'">' +
                            '</div>';
                return html;
            }

            catch(exp)
            {
                mostrar_alerta("alertas_formulario", "danger", exp)

                return "";
            }
        }

        function generar_text_area(object)
        {
            try
            {
                var obligatorio = "";

                if(object.obligatorio === true)
                {
                    obligatorio = '<span class="tx-danger">*</span>';
                }

                var html =  '<div class="form-group col-md-12" name="' + object.id_campo + '" id="' + object.id_campo + '">' +
                            '<label>' + object.label + ' ' + obligatorio + '</label>' +
                            '<textarea rows="3" class="form-control" name ="'+ object.id +'" id="'+ object.id +'"></textarea>' +
                            '</div>';
                return html;
            }

            catch(exp)
            {
                mostrar_alerta("alertas_formulario", "danger", exp)

                return "";
            }
        }

        function generar_option(object)
        {
            try
            {
                var obligatorio = "";

                if(object.obligatorio === true)
                {
                    obligatorio = '<span class="tx-danger">*</span>';
                }

                var html =  '<div class="form-group col-md-'+ object.column_space +'" name="' + object.id_campo + '" id="' + object.id_campo + '">' +
                            '<label>' + object.label + ' ' + obligatorio + '</label>' +
                            '<select class="form-control control_change" name ="'+ object.id +'" id="'+ object.id +'">';
                        
                if(object.elementos_internos.length > 0)
                {
                    var tipo = object.elementos_internos[0].tipo;
                    var funcion = object.elementos_internos[0].label;

                    if(tipo == "select")
                    {
                        $.each(object.elementos_internos, function(index, value)
                        {
                            html += '<option value="'+ value.id +'">' + value.label + '</option>';

                            if(value.generar_elementos.length > 0)
                            {
                                guardar_elementos(value.generar_elementos, object.id_campo, object.id, value.id);
                            }
                        });
                    }

                    else if(tipo == "function")
                    {
                        if(funcion == "anios")
                        {
                           html += anios;
                        }

                        else if(funcion == "juzgados")
                        {
                            html += juzgados;
                        }

                        else if(funcion == "todos_juzgados")
                        {
                            html += todos_juzgados;
                        }

                        else if(funcion == "cuantia")
                        {
                            html += cuantias;
                        }

                        else if(funcion == "tipo_moneda")
                        {
                            html += tipos_moneda;
                        }

                        else if(funcion == "tipo_resolucion" || funcion == "tipo_sentencia")
                        {
                            html += tipos_resolucion;
                        }

                        else if(funcion == "tipo_secretaria")
                        {
                            html += tipos_secretaria;
                        }

                        else if(funcion == "tipo_secretaria_c")
                        {
                            html += tipos_secretaria_c;
                        }

                        else if(funcion == "especialidad")
                        {
                            html += especialidad;
                        }

                        else if(funcion == "pais_origen")
                        {
                            html += pais_origen;
                        }

                        else if(funcion == "tipo_juicio")
                        {
                            html += tipo_juicio;
                        }

                        else if(funcion == "tipo_diligencia")
                        {
                            html += tipo_diligencia;
                        }
                    }
                }
                else
                {
                    html += '<option value="0">--Seleccione una opción--</option>';
                }
                            
                html += '</select>' +
                        '</div>';

                return html;
            }

            catch(exp)
            {
                mostrar_alerta("alertas_formulario", "danger", exp);

                return "";
            }
        }

        function generar_time(object)
        {
            try
            {
                var obligatorio = "";

                if(object.obligatorio === true)
                {
                    obligatorio = '<span class="tx-danger">*</span>';
                }

                var html =  '<div class="form-group col-md-'+ object.column_space +'" name="' + object.id_campo + '" id="' + object.id_campo + '">' +
                            '<label>' + object.label + ' ' + obligatorio + '</label>' +
                            '<input type="time" min="00:00" class="form-control" name ="'+ object.id +'" id="'+ object.id +'" value="00:00">' +
                            '</div>';
                return html;
            }

            catch(exp)
            {
                mostrar_alerta("alertas_formulario", "danger", exp);

                return "";
            }
        }

        function generar_date(object)
        {
            try
            {
                var obligatorio = "";

                if(object.obligatorio === true)
                {
                    obligatorio = '<span class="tx-danger">*</span>';
                }

                var html =  '<div class="form-group col-md-'+ object.column_space +'" name="' + object.id_campo + '" id="' + object.id_campo + '">' +
                            '<label>' + object.label + ' ' + obligatorio + '</label>' +
                            '<input type="date" class="form-control" name ="'+ object.id +'" id="'+ object.id +'">' +
                            '</div>';
                return html;
            }

            catch(exp)
            {
                mostrar_alerta("alertas_formulario", "danger", exp);

                return "";
            }
        }

        function seccion_actor(object)
        {
            try
            {
                var html =  '<div class="col-md-12" style="margin-bottom:15px;">' +
                            '<button class="_seccion btn btn-primary btn-sm" id="'+ object.id +'">Agregar '+ object.label +'</button>' +
                            '</div>';
                return html;
            }

            catch(exp)
            {
                mostrar_alerta("alertas_formulario", "danger", exp);

                return "";
            }
        }

        function seccion_certificado_egresos(object)
        {
            try
            {
                var html =  '<div class="col-md-12" id="beneficario_text" style="margin-bottom:15px;">' +
                            '<button id="'+ object.id +'" class="_certificado btn btn-primary btn-sm">Agregar '+ object.label +'</button>' +
                            '</div>';
                return html;
            }

            catch(exp)
            {
                mostrar_alerta("alertas_formulario", "danger", exp);

                return "";
            }
        }

        function seccion_diligencias(object)
        {
            try
            {
                var html =  '<div class="col-md-12" id="diligencia_text" style="margin-bottom:15px;">' +
                            '<button id="'+ object.id +'" class="_diligencia btn btn-primary btn-sm">Agregar '+ object.label +'</button>' +
                            '</div>';
                return html;
            }

            catch(exp)
            {
                mostrar_alerta("alertas_formulario", "danger", exp);

                return "";
            }
        }

        function seccion_diligencias_2(object)
        {
            try
            {
                var html =  '<div class="col-md-12" id="diligencia_text" style="margin-bottom:15px;">' +
                            '<button id="'+ object.id +'" class="_diligencia_2 btn btn-primary btn-sm">Agregar '+ object.label +'</button>' +
                            '</div>';
                return html;
            }

            catch(exp)
            {
                mostrar_alerta("alertas_formulario", "danger", exp);

                return "";
            }   
        }

        function generar_elemento_extra(id_elemento, id_div_padre)
        {
            try
            {
                eliminar_div(id_elemento, id_div_padre);
                
                var valor_elemento = $("#" + id_elemento).val();

                var elemento = elementos.find(x => x.id_disparador === valor_elemento && x.campo_anterior == id_div_padre);
                
                if(typeof elemento !== "undefined")
                {
                    var html = "";

                    $.each(elemento.elemento, function(index, value)
                    {
                        if(value.tipo == "number")
                        {
                            html += generar_input_number(value);
                        }

                        if(value.tipo == "text")
                        {
                            html += generar_input(value);
                        }

                        if(value.tipo == "big_text")
                        {
                            html += generar_text_area(value);
                        }

                        if(value.tipo == "option")
                        {
                            html += generar_option(value);
                        }

                        if(value.tipo == "date")
                        {
                            html += generar_date(value);
                        }
                    });

                    $("#" + elemento.campo_anterior).after(html);

                    $(".control_change").change(function() {
                        generar_elemento_extra(this.id,  $(this).parent().attr('id'));
                    });
                }
            }
            catch(exp)
            {
                mostrar_alerta("alertas_formulario", "danger", exp);
            }
        }

        function guardar_elementos(object, id_campo_padre, id_padre, id_disparador)
        {
            try
            {
                var json_elemento = {id_elemento:object[0].id, id_padre:id_padre, id_disparador:id_disparador, campo_anterior:id_campo_padre, elemento:object};

                var elemento = elementos.find(x => x.id_elemento === object[0].id && x.campo_anterior === id_campo_padre);

                if(typeof elemento === "undefined")
                {
                    elementos.push(json_elemento);
                }
            }
            catch(exp)
            {
                alert("ERROR guardar elementos: " + exp);
            }
        }

        function eliminar_div(id_elemento, id_div_padre)
        {
            try
            {
                var array_elementos = elementos.filter(x => x.id_padre === id_elemento && x.campo_anterior == id_div_padre);                

                var div = "";

                $.each(array_elementos, function(index, value)
                {
                    $.each(array_elementos[index].elemento, function(index_e, value_e)
                    {
                        div = $("#" + value_e.id_campo).attr("id");

                        if(typeof div !== "undefined")
                        {
                            $("#" + value_e.id_campo).remove();
                            
                            if(value_e.generar_elementos.length > 0)
                            {
                                eliminar_div(value_e.id, div);
                            }

                            if(value_e.elementos_internos.length > 0)
                            {
                                $.each(value_e.elementos_internos, function(index_in, value_in)
                                {
                                    $.each(value_in.generar_elementos, function(index_in_e, value_in_e)
                                    {
                                        $("#" + value_in_e.id_campo).remove();   
                                    });
                                });
                            }
                        }
                    });
                });
            }
            catch(exp)
            {
                mostrar_alerta("alertas_formulario", "danger", exp);
            }
        }
    </script>

@endsection