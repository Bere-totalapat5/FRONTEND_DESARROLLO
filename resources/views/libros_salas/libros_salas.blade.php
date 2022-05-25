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
        <li class="breadcrumb-item active" aria-current="page">Libros Digitales Salas</li>
    </ol>
    <h6 class="slim-pagetitle">Libros Digitales Salas</h6>
@endsection

@section ('contenido-principal')
<div class="container" id="wrapper_form">

    <p class="text-center" id="titulo_libro"></p>

    <!--ACORDION DE BUSQUEDA TOCA-->
    <div id="accordion_busqueda" class="accordion-one" role="tablist" aria-multiselectable="true" style="margin-bottom:10px;">
        <div class="card">
            <div class="card-header" role="tab" id="headingOne">
                <a id="title_busqueda" data-toggle="collapse" data-parent="#accordion_busqueda" href="#collapse_busqueda" aria-expanded="false" aria-controls="collapseOne" class="tx-gray-800 transition collapsed">
                    Busqueda Toca
                </a>
            </div>
            <div id="collapse_busqueda" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                <div class="card-body"><!--CUERPO BUSQUEDA TOCA-->
                    <div class="col-sm-12 col-md-12 col-gl-12 col-xl-12">
                        <div id="alertas_busqueda"></div>
                        <form class="row" id = "cuerpo_busqueda">
                            <div class="form-group col-md-2" name="1" id="1">
                                <label>No. Toca
                                    <span class="tx-danger">*</span>
                                </label>
                                <input class="_number form-control" type="number" max="9999" min="1" name="toca" id="toca">
                            </div>
                            <div class="form-group col-md-2" name="2" id="2">
                                <label>Año
                                    <span class="tx-danger">*</span>
                                </label>
                                <select class="_number form-control control_change" name="anios" id="anios"></select>
                            </div>
                            <div class="form-group col-md-2" name="3" id="3">
                                <label>Asunto</label>
                                <input class="_number form-control" type="number" max="9999" min="1" name="asunto" id="asunto">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="ckbox">
                                    <input type="checkbox" name="turnados" id="turnados"><span>Turnados</span>
                                </label>
                            </div>
                        </form>
                        <div class="row" id="acciones">
                            <div class="col-sm-6 col-md-6 col-gl-6 col-xl-6" id="btn_buscar" style="margin-bottom:15px;">
                                <button class="btn  btn-primary btn-sm" onclick="buscar_toca();">Buscar</button>
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
                    Agregar a Libros
                </a>
            </div>
            <div id="collapse_formulario" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                <div class="card-body"><!--CUERPO AGREGAR/EDITAR LIBRO-->
                    <div class="section-wrapper">
                        <div class="col-sm-12 col-md-12 col-gl-12 col-xl-12">
                            <div id="alertas_formulario"></div>                        
                            
                            <form class="row" id = "cuerpo_form"></form>

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
                    <table id="tabla_toca" class="table table-hover"></table>
                </div>

            </div><!-- modal-body -->
            <div class="modal-footer">
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

        var anios = "";
        var juzgados = "";
        var consecutivo = "";

        var resultados = "";
        var datos_expediente = [];

        var formulario = "";
        var tabla = "";
        var elementos = [];
        var campos = "";

        var id = "";
        var juzgado_user = "";

        var tipos_secretaria = "";

        $(document).ready(function() 
        {
            $("._number").on('input', function()
            {
                this.value = this.value.replace(/[^0-9]/g, '');
            });

            consecutivo = @json($consecutivo);

            formulario = @json($datos_formulario);
            tabla = @json($datos_tabla);
            anios = @json($anios);
            juzgados = @json($juzgados);
            juzgado_user = @json($sesion);
            tipos_secretaria = @json($tipos_secretaria);

            $("#anios").html(anios);

            setTimeout(function(){ $('#modal_loading').modal('hide'); }, 1000);

            var logs = @json($logs);
            console.log(logs);

            inicio();
        });

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
                    mostrar_alerta("alertas_tabla", "warning", tabla.message)
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
                    mostrar_alerta("alertas_formulario", "warning", formulario.message)
                }

                if(consecutivo.status == 100)
                {
                    consecutivo = consecutivo.response[0].consecutivo_libro_consecutivo;
                }

                else
                {
                    mostrar_alerta("alertas_formulario", "warning", consecutico.message);

                    console.log(consecutivo.response);
                }
            }
            catch(exp)
            {
                setTimeout(function(){ $('#modal_loading').modal('hide'); }, 1000);

                mostrar_alerta("alertas_formulario", "warning", exp)
            }
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

                if(value.tipo == "huella")
                {
                    html += generar_biometrico(value);
                }

                if(value.tipo == "firma")
                {
                    html += generar_biometrico(value);
                }

                if(value.tipo == "seccion")
                {
                    html += generar_seccion(value);
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
        }

        function buscar_toca()
        {
            try
            {
                $.ajax({
                    url:"/libros_gobierno/buscar_toca",
                    method:"POST",
                    data:{  toca:$("#toca").val(), 
                            anio:$("#anios").val(), 
                            asunto:$("#asunto").val(), 
                            turnados:$("#turnados").prop("checked")},

                    error:function(error)
                    {
                        var mensaje = "Se recibio el error: " + error.status;

                        mostrar_alerta("alertas_busqueda", "danger", mensaje);
                    },

                    success:function(data)
                    {
                        if(data.status == 100)
                        {
                            $("#tabla_toca").html(data.response);
                            $('#modal_acuerdos').modal('show');

                            if(data.tipo == "juzgado")
                            {
                                resultados = data.resultados;
                                btn_partes = data.btn_partes;
                            }
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

        function datos_base(id_accion)
        {
            try
            {
                $.ajax({
                    url:"/libros_gobierno/datos_base_libro/",
                    method:"POST",
                    data:{id_accion:id_accion},

                    error:function(error)
                    {
                        var mensaje = "Se recibio el error: " + error.status;
                        mostrar_alerta("alertas_modal", "danger", mensaje);
                    },

                    success:function(data)
                    {
                        if(data.status == 100)
                        {
                            crear_formulario();

                            $("#btn_guardar").html("<button class='btn btn-primary btn-sm' onClick='guardar_libro();'>Guardar</button>");

                            $('#modal_acuerdos').modal('hide');

                            expandir_acordion("title_formulario");

                            colocar_valores(data.response);

                            id = id_accion;
                        }

                        else if(data.status == 200)
                        {
                            mostrar_alerta("alertas_modal", "warning", data.message);
                        }

                        else if(data.status == 0)
                        {
                            mostrar_alerta("alertas_modal", "danger", data.message);
                        }
                    }

                });
            }
            catch(exp)
            {
                mostrar_alerta("alertas_modal", "danger", exp);
            }
        }

        function colocar_valores(data)
        {
            $("#no_toca").val(data.toca);
            $("#anio_toca").val(data.anio);
            $("#asunto_toca").val(data.asunto);
            $("#actor").val(data.actor);
            $("#demandado").val(data.demandado);

            $("#no_expediente").val(data.expediente);
            $("#anio_expediente").val(data.anio_exp);
            $("#asunto_expediente").val(data.bis);

            $("#no_toca").prop("disabled", true);
            $("#anio_toca").prop("disabled", true);
            $("#asunto_toca").prop("disabled", true);
            $("#actor").prop("disabled", true);
            $("#demandado").prop("disabled", true);

            $("#no_expediente").prop("disabled", true);
            $("#anio_expediente").prop("disabled", true);
            $("#asunto_expediente").prop("disabled", true);
        }

        function guardar_libro()
        {
            try
            {
                var formulario_campos = $('#cuerpo_form');
                var disable_input = formulario_campos.find(':input:disabled').removeAttr('disabled');
                formulario_campos = formulario_campos.serializeArray();
                disable_input.attr('disabled','disabled');

                $.ajax({
                    url: "/libros_gobierno/guardar",
                    method: 'post',
                    data: { datos:formulario_campos,
                            tabla:formulario.response.nombre_db, 
                            materia:formulario.response.materia,
                            id_juzgado:id},

                    error:function(error)
                    {
                        var mensaje = "Se recibio el error: " + error.status;
                        mostrar_alerta("alertas_acciones", "danger", mensaje);
                    },

                    success: function(data)
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
                        }
                    }
                });
            }

            catch(exp)
            {
                $('#modal_loading').modal('hide');

                mostrar_alerta("alertas_acciones", "danger", exp);
            }
        }
      
        function editar(id_valor)
        {
            try
            {
                $('#modal_loading').modal('show');
                
                setTimeout(function(){ $('#modal_loading').modal('hide'); }, 2000);

                $.ajax({
                    
                    url:"/libros_gobierno/buscar_registro",
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
                            crear_formulario();

                            $("#consecutivo").val(data.query.consecutivo);

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

                                            if( valor_f.children[1].id == "no_toca" || valor_f.children[1].id == "anio_toca" || 
                                                valor_f.children[1].id == "asunto_toca" || valor_f.children[1].id == "actor" ||
                                                valor_f.children[1].id == "demandado" || valor_f.children[1].id == "no_expediente" ||
                                                valor_f.children[1].id == "anio_expediente" || valor_f.children[1].id == "asunto_expediente")
                                                {
                                                    $("#" + valor_f.children[1].id).prop("disabled", true);
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

                $.ajax({
                    url:'/libros_gobierno/guardar_edicion',
                    method:'POST',
                    data:{  datos:formulario_campos,
                            id_valor:id_valor, 
                            tabla:formulario.response.nombre_db, 
                            materia:formulario.response.materia},

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
                        }
                    }
                });
                
            }
            catch(exp)
            {
                mostrar_alerta("alertas_acciones", "danger", exp);
            }
        }

        function cancelar()
        {
            location.reload();
        }

        function mostrar_alerta(id_zona, tipo, texto)
        {
            $("#" + id_zona).empty();

            var html_alerta = '<div class="alert alert-'+ tipo +'" role="alert">'+ texto +'</div>';

            $("#" + id_zona).html(html_alerta);

            setTimeout(function(){ $("#" + id_zona).empty(); }, 3000);
        }
        
        function expandir_acordion(id_titulo)
        {
            if($("#" + id_titulo).hasClass("collapsed"))
            {
                $("#" + id_titulo).trigger('click');
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

        //GENERACION DE ELEMENTOS
        function generar_input_consecutivo(object)
        {
            try
            {
                var html =  '<div class="form-group col-md-'+ object.column_space +'" name="' + object.id_campo + '" id="' + object.id_campo + '">' +
                        '<label>' + object.label + '</label>' +
                        '<input class="_number form-control" type="text" max="9999" min="1" name ="'+ object.id +'" id="'+ object.id +'" value="'+ consecutivo +'" disabled="">' +
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
                var html =  '<div class="form-group col-md-'+ object.column_space +'" name="' + object.id_campo + '" id="' + object.id_campo + '">' +
                        '<label>' + object.label + '</label>' +
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
                var html =  '<div class="form-group col-md-'+ object.column_space +'" name="' + object.id_campo + '" id="' + object.id_campo + '">' +
                            '<label>' + object.label + '</label>' +
                            '<div class="input-group">' +
                            '<div class="input-group-prepend">' +
                            '<span class="input-group-text">$</span>' +
                            '</div>' +
                            '<input class="form-control" type="text" name ="'+ object.id +'" id="'+ object.id +'" value="$" onkeypress="mascara(this,cpf)"  onpaste="return false">' +
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
                var html =  '<div class="form-group col-md-'+ object.column_space +'" name="' + object.id_campo + '" id="' + object.id_campo + '">' +
                            '<label>' + object.label + '</label>' +
                            '<input class="_text form-control" name ="'+ object.id +'" id="'+ object.id +'">' +
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
                var html =  '<div class="form-group col-md-12" name="' + object.id_campo + '" id="' + object.id_campo + '">' +
                            '<label>' + object.label + '</label>' +
                            '<textarea rows="3" class="_text_area form-control" name ="'+ object.id +'" id="'+ object.id +'"></textarea>' +
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
                var html =  '<div class="form-group col-md-'+ object.column_space +'" name="' + object.id_campo + '" id="' + object.id_campo + '">' +
                            '<label>' + object.label + '</label>' +
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

                        else if(funcion == "tipo_secretaria")
                        {
                            html += tipos_secretaria;
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

        function generar_check(object)
        {
            try
            {
                var html = '<div class="form-group col-md-'+ object.column_space +'" name="' + object.id_campo + '" id="' + object.id_campo + '">' +
                                '<label class="_check ckbox">' +
                                    '<input type="checkbox" checked="false" name ="'+ object.id +'" id="'+ object.id + '"><span>' + object.label + '</span>' +
                                '</label>'
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
                var html =  '<div class="form-group col-md-'+ object.column_space +'" name="' + object.id_campo + '" id="' + object.id_campo + '">' +
                            '<label>' + object.label + '</label>' +
                            '<input type="time" min="00:00" class="_time form-control" name ="'+ object.id +'" id="'+ object.id +'" value="00:00">' +
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
                var html =  '<div class="form-group col-md-'+ object.column_space +'" name="' + object.id_campo + '" id="' + object.id_campo + '">' +
                            '<label>' + object.label + '</label>' +
                            '<input type="date" class="_date form-control" name ="'+ object.id +'" id="'+ object.id +'">' +
                            '</div>';
                return html;
            }

            catch(exp)
            {
                mostrar_alerta("alertas_formulario", "danger", exp);

                return "";
            }
        }

        function generar_biometrico(object)
        {
            try
            {
                var html =  '<div class="form-group col-md-3" name="' + object.id_campo + '" id="' + object.id_campo + '">' +
                            '<label>' + object.label + '</label>' +
                            '<button class="btn btn-default btn-sm" disabled="">Biometrico</button>' +
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