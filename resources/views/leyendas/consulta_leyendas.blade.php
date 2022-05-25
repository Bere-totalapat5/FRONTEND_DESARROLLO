@php
  use App\Http\Controllers\clases\humanRelativeDate;
  use App\Http\Controllers\clases\utilidades;
  $humanRelativeDate = new humanRelativeDate();
@endphp

@extends('layouts.index')

@section('contenido-pageheader')
 <ol class="breadcrumb slim-breadcrumb">
    <li class="breadcrumb-item"><a href="#">Leyendas</a></li>
    <li class="breadcrumb-item"><a href="#"> Consulta de Leyendas</a></li>
 </ol>
 <h6 class="slim-pagetitle">  Consulta de Leyendas</h6>
@endsection
@section('contenido-principal')

 <div class="section-wrapper" style="max-width: 100%;">
    <div class="form-layout">
        <div id="accordion" class="accordion-one mg-b-20" role="tablist" aria-multiselectable="true">
            <div class="card">

                <div class="card-header" role="tab" id="headingOne">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" class="tx-gray-800 transition collapsed">
                    Búsqueda Avanzada
                    </a>
                </div><!-- card-header -->

                <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                    <div class="card-body">
                        <div class="row mg-b-25">

                                <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="label">Año:</label>
                                            <select class="form-control-lg select2 valid" id="anioBusqueda">
                                            <option value="" selected>Todas</option>
                                            <?php  for($i=2010;$i<=2030;$i++) { echo "<option value='".$i."'>".$i."</option>"; } ?>
                                            </select>
                                        </div>
                                    </div>



                                </div><!-- row -->
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="button" class="btn btn-primary btn-sm btn-block mg-b-10" data-toggle="collapse" data-target="#demo" onclick="sec_ajax('primera');">Filtrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        </div>
                        <br>

                        <br>
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
                            <div id="texto_paginator">Página <span class="pagina_actual_texto">0</span> de <span class="pagina_total_texto">0</span></div>
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
                            </div>

                            <div class="row justify-content-begin">
                              <div class="col-sm-2" align="left">
                                <button type="button" align="left" class="btn btn-primary" onclick="nuevo_usuario()" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Agregar Leyenda
                                <i class="fa fa-plus"></i>
                                </button>
                              </div>
                            </div>


                            <br>


                            <!-- Modal Nueva leyenda-->
                            <div class="modal fade" id="modalNuevaLeyenda"  tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" style="width: 60%;">
                                    <div class="modal-content" >
                                        <div class="modal-header" >
                                            <h5 class="modal-title">Nueva Leyenda</h5>
                                        </div>
                                        <div class="modal-body"   >
                                        <div class="row form-layout">

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="label">Año:</label>
                                                <select class="form-control-lg select2 valid" id="anioRegistroNuevo">
                                                    <?php  for($i=2015;$i<=2030;$i++) { echo "<option value='".$i."'>".$i."</option>"; } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <label class="label">Leyenda: <span class="tx-danger">*</span></label>
                                            <div class="form-group">
                                                    <input type="text" style="text-align:center;" class="form-control"  id="leyendaRegistroNuevo" placeholder="Escribe la leyenda" autocomplete="off">
                                            </div>
                                        </div>



                                    </div>
                                        </div>
                                        <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" onclick="cerrar_modal('modalNuevaLeyenda')" data-bs-dismiss="modal">Cancelar</button>
                                                    <button type="button" onclick="guardar_nueva_leyenda()" class="btn btn-primary">Guardar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <!-- Modal modificar leyenda-->
                            <div class="modal fade" id="modal_modificar_leyenda" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <input type="hidden" id="oculto" value="">
                              <input type="hidden" id="e_id_unidad_gestion" value="">
                                <div class="modal-dialog modal-lg" style="width: 70%;" >
                            <div class="modal-content">
                            <div class="modal-header" id="modal_header">
                                <h5 class="modal-title">Editar Leyenda</h5>
                            </div>
                            <div class="modal-body" id="contenido_modificar_usuario">
                              <div class="row form-layout">



                                    <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="label">Año:</label>
                                    <select class="form-control-lg select2 valid" id="anioRegistroEditar">
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                              <label class="label">Leyenda: <span class="tx-danger">*</span></label>
                            <div class="form-group">
                              <input type="text" style="text-align:center;" class="form-control"  id="leyendaRegistroEditar" placeholder="Escribe la leyenda" autocomplete="off">
                            </div>
                            </div>



                             <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="label">Estatus:</label>
                                              <select class='form-control-lg select2 valid' id='estatusRegistroEditar'>"+
                                              </select>
                                        </div>
                             </div>



                          </div>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" onclick="cerrar_modal('modal_modificar_leyenda')" data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary" onclick="guardar_cambios()">Guardar</button>
                            </div>
                            </div>
                            </div>
                            </div>






<div  class="mg-b-20"  >
      <table id="leyendasTable" class="display dataTable dtr-inline collapsed d-block" style="overflow-x: auto; padding-left:0; padding-rigth:0" role="grid" aria-describedby="example_info">

        <thead style="background-color: #EBEEF1; color: #000; text-align:center">
            <tr>
                <th class="acciones">Acciones</th>
                <th style="cursor:pointer"  class="anio" name="id_usuario">Año</th>
                <th style="cursor:pointer"  class="leyenda" name="leyenda">Leyenda</th>
                <th style="cursor:pointer"  class="creacion" name="creacion">Fecha de Creación</th>
                <th style="cursor:pointer"  class="modificacion" name="modificacion">Fecha de Modificación</th>
                <th style="cursor:pointer"  class="estatus" name="estatus">Estatus</th>
            </tr>
        </thead>
        <tbody id="body-table1"  style="width: 100%; text-align: center;">

        </tbody>
    </table>
</div>
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
    <div id="texto_paginator">Página <span class="pagina_actual_texto">0</span> de <span class="pagina_total_texto">0</span></div>
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
    </div>
</div><!-- pagination-wrapper -->

    <input type="hidden" id="pagina_actual" name="pagina_actual" value="1">
    <input type="hidden" id="paginas_totales" name="paginas_totales" value="1">
    <input type="hidden" id="numeropagina">

    <div class="pagination-wrapper justify-content-space-between col-sm-4 " style="border:0px;float:none;margin:auto;">
    </div>
        </div>
     {{--    @endif
    @endif --}}
@endsection
    @section('seccion-estilos')
    <link href="{{asset("/lib/datatables/css/jquery.dataTables.css")}}" rel="stylesheet">
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
<style>

.select2-container.select2-container--default.select2-container--open{
  z-index: 1050 !important;
}
.flex-container {
    display: flex;
    justify-content: center;
}

.flex-container > div {
    margin: 1px;
    padding: 1px;
    font-size: 16px;
}

@media screen and (max-width: 600px) {
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
.acciones {
    min-width: 150px !important;
}
.anio {
    min-width: 150px !important;
}
.leyenda {
    min-width: 400px !important;
}
.creacion {
    min-width: 250px !important;
}
.modificacion {
    min-width: 250px !important;
}
.estatus {
    min-width: 250px !important;
}


.hover:hover{
   background-color:#90a03c;
   color:white;
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

.flex-container > div {
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

div .icon{
        background: #848F33 !important;
        padding: 2px 5px;
        border-radius: 25%;
        color: #fff;
      }

</style>
@endsection
     @section('seccion-scripts-libs')
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/jquery-ui/js/jquery-ui.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/datatables/js/jquery.dataTables.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/datatables-responsive/js/dataTables.responsive.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/select2/js/select2.min.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/moment/js/moment.js"></script>
     <script src="https://cdn.datatables.net/colreorder/1.5.3/js/dataTables.colReorder.min.js"></script>
     <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
     @endsection
@section('seccion-scripts-functions')
<script>

$(function(){
    'use strict';
     $('.select2').select2({
        minimumResultsForSearch: Infinity
    });

    sec_ajax();

    $('.fc-datepicker').datepicker({
            showOtherMonths: true,
            selectOtherMonths: true
        });
     $( ".fc-datepicker" ).datepicker( "option", "dd-mm-yy" );

     $.datepicker.regional['es'] = {
                closeText: 'Cerrar',
                prevText: '< Ant',
                nextText: 'Sig >',
                currentText: 'Hoy',
                monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
                dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
                dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
                weekHeader: 'Sm',
                dateFormat: 'dd/mm/yy',
                firstDay: 1,
                isRTL: false,
                showMonthAfterYear: false,
                yearSuffix: ''
                    };

          $.datepicker.setDefaults($.datepicker.regional['es']);
          $(function () {
                    $("#fc-datepicker").datepicker();
            });

    $('.form-layout .form-control').on('focusin', function(){
        $(this).closest('.form-group').addClass('form-group-active');
    });
    $('.form-layout .form-control').on('focusout', function(){
        $(this).closest('.form-group').removeClass('form-group-active');
    });

    setTimeout(function(){
        $('#modal_loading').modal('hide');
    }, 1000);
});




function modificar_leyenda(valor,valor2){
  var anio = valor;

  $.ajax({
      type:'post',
      url:'/public/obtener_leyendas',
      data:{
        anio : anio
      },
          success:function(response) {
            console.log(response);
          if(response.status==100){

             var e_anio = response.response[0]["anio"];
                var anios="";
              for($i=2015;$i<=2030;$i++) {
               anios= anios+  "<option value='"+$i+"'>"+$i+"</option>";
                }


            if(e_anio){
                e_anio = "<option value='"+e_anio+"' selected>"+e_anio+"</option>" ;
            }

            $("#anioRegistroEditar").html(e_anio);

           // $("#anioRegistroEditar").val(anio);
            $("#leyendaRegistroEditar").val(response.response[0]["leyenda"]);

            var e_estatus = "";

            if(response.response[0]["estatus"]==1){
              e_estatus = "<option value='1' selected>ACTIVO</option>"+
                          "<option value='0' >INACTIVO</option>";
            }
            else{
              e_estatus = "<option value='0' selected>INACTIVO</option>"+
                          "<option value='1' >ACTIVO</option>";
            }
            $("#estatusRegistroEditar").html(e_estatus);


            $("#"+valor2).modal("show");

          }
        }
        });
}

function nuevo_usuario() {


        $("#modalNuevaLeyenda").modal("show");

        $("#m_nombres").val("");
        $("#m_ap").val("");
        $("#m_am").val("");
        $("#m_correo").val("");
        $("#m_contraseña").val("");
        $("#m_contraseña2").val("");
        $("#m_usuario").val("");
        $("#usuario_opciones").html("");
}

function cerrar_modal(valor){
        $("#"+valor).modal('hide');
        $('body').removeClass('modal-open');


}

function guardar_cambios(){

        $.ajax({
        type:'post',
        url:'/public/guardar_cambios_leyenda',
        data:{
            anio:$("#anioRegistroEditar").val(),
            leyenda : $("#leyendaRegistroEditar").val(),
            estatus : $("#estatusRegistroEditar").val(),

        },
            success:function(response) {
                console.log(response);
                var anioLeyenda=$("#anioRegistroEditar").val();

            if(response.status==100){
                        cerrar_modal('modal_modificar_leyenda');

                        var exito = "<p class='mg-b-20 mg-x-20'>La leyenda relacionada con el año "+anioLeyenda+ " "+response.response+"</p>";
                                            $('#messageExito').html(exito);

                        $('#modalSuccess').modal('show');
                        sec_ajax();
            }
            else{
                    var error = "<p class='mg-b-20 mg-x-20'>"+response.message+"</p>";
                    $('#messageError').html(error);
                    $('#modalError').modal('show');
                            }
            }
            });
}

function guardar_nueva_leyenda(){

    $.ajax({
        type:'post',
        url:'/public/guardar_nueva_leyenda',
        data:{
                anio : $("#anioRegistroNuevo").val(),
                leyenda : $("#leyendaRegistroNuevo").val(),

        },

            success:function(response) {
                    console.log(response);
                    var anioLeyenda=$("#anioRegistroNuevo").val();

                    if(response.status==100){
                           // var anioLeyenda=  $("#anioRegistroNuevo").val("");
                            cerrar_modal('modalNuevaLeyenda');
                            $("#anioRegistroNuevo").val("");
                            $("#leyendaRegistroNuevo").val("");

                            var exito = "<p class='mg-b-20 mg-x-20'>La leyenda relacionada con el año "+anioLeyenda+ " "+response.response+"</p>";
                            $('#messageExito').html(exito);

                            $('#modalSuccess').modal('show');
                            sec_ajax();

                    }
                    else{
                            var error = "<p class='mg-b-20 mg-x-20'>"+response.message+"</p>";
                            $('#messageError').html(error);
                            $('#modalError').modal('show');
                    }

               }
        });

}



function sec_ajax(pagina_accion) {
    $(document).ready(function(){
        $(".nav-tabs a").click(function(){
            $(this).tab('show');
        });
    });
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
        }
        else{
            $('#pagina_actual').val(pagina);
            $('#numeropagina').val(pagina);
            $('.pagina_actual_texto').html(pagina);



                             $("#filtro_consulta").val(
                            JSON.stringify(
                                {
                                    id_tipo_usuario:$("#id_tipo_usuario").val(),
                                    id_unidad_gestion:$("#id_unidad_gestion").val(),
                                    usuario:$("#usuario").val(),
                                    pagina:1,
                                    registros_por_pagina:1000000
                                            }
                                        )
                                    );
        $.ajax({
            type:'POST',
            url:'/public/obtener_leyendas',
            data:{
                anio:$("#anioBusqueda").val(),
                /* id_unidad_gestion:$("#id_unidad_gestion").val(),
                usuario:$("#usuario").val(),
                pagina:$('#numeropagina').val(),
                 registros_por_pagina:10, */
            },

                success:function(response) {
                    console.log(response);
                if(response.status==100){



                    let color;
                    let msg;

                    let modal1="'modal_modificar_leyenda'";
                    let modal2="'modal_adscripcion'";
                    let prmiso="menu_permisos";

                    var datos=response.response;
                                    // onclick="window.location.href=/editar_solicitud_audiencia_inicial/"'+data+'
                    var body = new $('#leyendasTable').dataTable( {
                                processing: true,
                                data: datos,
                                columns: [
                                    {"data": "anio",
                                            "render": function ( data, type, row, meta ) {
                                                return '<div class="icono"><i class=" ion-edit" title="Modificar" onclick="modificar_leyenda('+data+','+modal1+')" style="cursor: pointer" id="editar"></i></div> '
                                                }
                                    },
                                    { data: "anio" ,title: "Año" },
                                    { data: "leyenda",title: "Leyenda" },
                                    { data: "creacion",title: "Fecha de Creación"  },
                                    { data: "modificacion",title: "Fecha de Modificacion"  },
                                   // { data: "estatus",title: "Estatus"},
                                    {"data": "estatus",
                                            "render": function ( data, type, row, meta ) {
                                                var estatus="";
                                                if (data==0) {
                                                  estatus='<p style="color:red;">INACTIVO</p>'
                                                } else if(data==1) {
                                                  estatus='<p style="color:green;">ACTIVO</p>'
                                                }
                                            return estatus
                                            }
                                    },
                                ],
                                columnDefs: [
                                              { orderable: false, targets: 0 }
                                            ],
                                colReorder:{
                                                fixedColumnsLeft: 1
                                            },
                                bDestroy: true,
                                colReset:true,
                                paging:   false,
                                ordering: true,
                                info:     false,
                                search:false,
                                filter:false,
                                stateSave: true,
                              //stateClear: false,
                              //stateLoaded: true,
                            } );

                              /*   $('.pagina_total_texto').html(response.response_pag['paginas_totales']);
                                $('#paginas_totales').val(response.response_pag['paginas_totales']) */


                   //  limpiarCampos();
                }else{
                    let  body="";
                  body = body.concat("<tr><td colspan='12'><h3>Sin datos relacionadoss</h3></td><tr>");
                    $("#body-table1").html(body);
                    //  limpiarCampos();

                }
            }
        });
    }

}

  function descargar_consulta(extension){
    console.log("entraste a generar :"+extension);

    let orden_columnas = get_orden_columnas();

    $('#modal_loading').modal('show');

    $.ajax({
        type:'GET',
        url:'/exportar_busqueda_usuarios',
        data:{
          id_tipo_usuario:$("#id_tipo_usuario").val(),
          id_unidad_gestion:$("#id_unidad_gestion").val(),
          usuario:$("#usuario").val(),
          pagina:1,
          registros_por_pagina:10000000,
          extension : extension,
          orden_columnas:orden_columnas,
        },
        success:function(data){
            console.log(data);
            if(data.status==100){
                let tag_a = $("<a>");
                tag_a.attr("href",data.file);
                $("body").append(tag_a);
                tag_a.attr("download",data.filename);
                tag_a[0].click();
                tag_a.remove();
            }else{
                alert(data.message);
            }

            setTimeout(function(){  $('#modal_loading').modal('hide');  }, 500);
        }
    });
  }

  function get_orden_columnas(){
    let campos_title = [
      { campo: "id_usuario" ,titulo: "ID Usuario" },
      { campo: "usuario",titulo: "Usuario" },
      { campo: "nombres",titulo: "Nombre"  },
      { campo: "nombre_unidad",titulo: "Unidad"  },
      { campo: "descripcion",titulo: "Tipo"  },
      { campo: "correo",titulo: "Correo"  },
      { campo: "cve_juez",titulo: "Clave"  },
    ];
    let columnas = [];
    $('#usuariosTable thead tr th').each(function() {
        let columna =  campos_title.filter( index => index.titulo == $(this).text() );
        if( columna.length ){
            columnas.push({ titulo:  columna[0].titulo, campo: columna[0].campo });
        }
    });
    return columnas;
  }

</script>
@endsection


@section('seccion-modales')


<div id="modalSuccess" class="modal fade"  data-backdrop="static" data-keyboard="false" >
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
          <button type="button" class="btn btn-danger pd-x-25" data-dismiss="modal" aria-label="Close">Aceptar</button>
        </div><!-- modal-body -->
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
  </div><!-- modal -->


@endsection
