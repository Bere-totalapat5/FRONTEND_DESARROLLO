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
    <li class="breadcrumb-item active" aria-current="page">Permisos por Default</li>
  </ol>
  <h6 class="slim-pagetitle">Permisos por Default</h6>
@endsection

@section('contenido-principal')
{{--   @if($error!="")
    <div class="alert alert-warning" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <strong>Alerta!</strong> {{$error}}.
    </div><!-- alert -->
  @endif --}}
  <div class="section-wrapper" style="max-width: 90%;">
    <div class="row">
        <div class="col-lg-12">
            <h3 class="card-profile-name">Permisos por Default</h3>
        </div>

        <div class="col-lg-4">
            <div class="form-group">
                <label class="form-control-label">Tipo de Usuario: {{-- <span class="tx-danger">*</span> --}}</label>
                <select class="form-control select2-show-search valid select2-hidden-accessible" id="select-tipousuario" autocomplete="off"> </select>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="form-group">
                {{-- <label class="form-control-label">Tipo de Usuario: </label>
                <select class="form-control select2" id="select-tipousuario" autocomplete="off">
                    --}}

                    <div id="acordeondiv" role="tablist"></div>
                    <div id="acordeoncont" role="tablist"></div>
                    <div id="acordeonbox" role="tablist"></div>
                </select>
            </div>
        </div>

        <div class="col-lg-12">
            <button class="btn btn-primary btn-block btn-sm mg-t-25" onclick="guardarPermisos();">Guardar</button>
        </div>
        <!-- col-4 -->
    </div>

  </div>


@endsection
@section('seccion-estilos')
<script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>

<style>
    label.permiso{

      margin-bottom: 0;
      margin-top: 5px;
      color: #000;
    }
    .col-permiso{
      padding: 5px 20px;
    }
    .accordion-one .card-header a::before {
      top: 5px !important;

    }
    .accordion-one .card-header{
      border-bottom: 1px solid lightgrey;
    }

    a.transition {
      margin-top: 3px;
      padding: 5px 20px !important;
    }
    .col-6.acciones{
      padding-left: 0;
      text-align: center;
    }
    .card-header .row{
      padding-left: 15px;
      padding-right: 15px;
    }
    .btn{
      background-color: #4CAF50;

    }

    .accordion-one .card-header a {
      display: block;
      padding: 18px 20px;
      color: #154f89;
      position: relative;
      border-bottom: none !important;
      background-color: #fff !important;

    }
    .accordion-one{
      max-width: 90%;

    }
    .iconify{
                display: inline-block;
                text-align: left;
                vertical-align: top;
                width: 90px; height: 90px;
                color: #4CAF50;
             }

    .div-padre{
      max-width: 700px;
      background-color: #f8f9fa;
    }
    .mg-l-16{

      margin-left: 16px;
    }
  </style>
@endsection


@section('seccion-scripts-libs')
<script src="{{ $entorno["version_pages"]["version"] }}/lib/jquery-ui/js/jquery-ui.js"></script>
<script src="{{ $entorno["version_pages"]["version"] }}/lib/datatables/js/jquery.dataTables.js"></script>
<script src="{{ $entorno["version_pages"]["version"] }}/lib/datatables-responsive/js/dataTables.responsive.js"></script>
<script src="{{ $entorno["version_pages"]["version"] }}/lib/select2/js/select2.min.js"></script>
<script src="{{ $entorno["version_pages"]["version"] }}/lib/moment/js/moment.js"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
<script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>


@endsection
@section('seccion-scripts-functions')
  <script>
let ID_usuario='';

$(function () {
    "use strict";

    setTimeout(function () {
        $("#modal_loading").modal("hide");
    }, 1000);

    $(".select2").select2({
        minimumResultsForSearch: Infinity,
    });

    $(".form-layout .form-control").on("focusin", function () {
        $(this).closest(".form-group").addClass("form-group-active");
    });

    $(".form-layout .form-control").on("focusout", function () {
        $(this).closest(".form-group").removeClass("form-group-active");
    });

    $.ajax({
        type: "POST",
        url: "/public/obtener_tipo_usuario",
        data: {},

        success: function (response) {
            if (response.status == 100) {
                let tipos_usuario = "";

                $(response.response).each((index, tipo) => {
                    const { creacion, descripcion, estatus, id_tipo_usuario, modificacion } = tipo;
                    const option = "<option value='" + id_tipo_usuario + "'>" + descripcion + "</option>";
                    tipos_usuario = tipos_usuario.concat(option);
                });

                $("#select-tipousuario").html("<option selected disabled value=''>Elija una opción</option>" + tipos_usuario);
            }
        },
    });

    $("#select-tipousuario").change(function () {
        $.ajax({
            type: "POST",
            url: "/public/obtener_configuracion_usuario",
            data: {
                id_tipo_usuario: $("#select-tipousuario").val(),
            },
            success: function (response) {
                let prendido = "";
                let acordeones = [];
                let acordeonescont = [];
                let acordeonboxes = [];
                ID_usuario = response[0].id_tipo_usuario;

                $(response[0].padres).each((index, menu_padre) => {
                    const { id_menu, id, descripcion, valor, vistas } = menu_padre;

                    let id_padrote = id;
                    let accordioncont = "";
                    let accordionboxes = " ";
                    acordeonboxes = [];

                    $(vistas).each((index_s, submenu) => {
                        let on = "";
                        let on2 = "";
                        accordionboxes = "";
                        const { id_menu, id, id_padre, valor, vista, acciones } = submenu;

                        $(acciones).each((index_a, action) => {
                            const { accion, id_accion, id_menu, id, valor } = action;

                            if (valor == 1) {
                                on = "checked";
                            } else if (valor == 0) {
                                on = "";
                            }
                            accordionboxes =
                                accordionboxes +
                                "<div class='col-sm-6 col-md-4'>" +
                                "<label class='ckbox permiso'>" +
                                "<input type='checkbox' name='accion' id='accion' data-id='" +
                                id +
                                "' " +
                                "class='accion' value='" +
                                id_menu +
                                "' " +
                                on +
                                "><span>" +
                                accion +
                                "</span></label></div>";
                            acordeonboxes[index_s] = accordionboxes;
                        });

                        if (valor == 1) {
                            on2 = "checked";
                        } else if (valor == 0) {
                            on2 = "";
                        }

                        let divs_acciones = '';

                        $( acciones ).each( function( i, accion ) {

                          var checked = "";
                          if(accion.valor == 1){
                            checked = "checked";
                          }

                          divs_acciones += "<div class='col-sm-6 col-md-4'>"+
                                           "<label class='ckbox permiso'>"+
                                           "<input type='checkbox' data-padre='"+id_padrote+"' name='accion' id='"+accion.id+"' data-id='"+accion.id+
                                           "' class='accion' value='"+accion.id_menu_accion+"' "+checked+"><span>"+accion.accion+"</span>"+
                                           "</label>"+
                                           "</div>";
                        });


                        accordioncont =
                            accordioncont +
                            "<div id='accordion" +
                            index_s +
                            "' class='accordion-one mg-b-5' role='tablist' aria-multiselectable='true'>" +
                            "<div class='card'>" +
                            "<div class='card-header' role='tab' id='headingOne'>" +
                            "<div class='row'>" +
                            "<div class='col-7 col-permiso'>" +
                            "<label class='ckbox permiso'>" +
                            "<input type='checkbox'  data-padre='"+id_padrote+"'  name='menu' id='menu' data-id=" +
                            id +
                            " class='menu submenu' value=" +
                            id_menu +
                            "  " +
                            on2 +
                            " ><span>" +
                            vista +
                            "</span>" +
                            "</label></div>" +
                            "<div class='col-5 acciones'>" +
                            "<a data-toggle='collapse' data-parent='#accordion" +
                            index_s +
                            "' href='#collapseOne" +
                            id +
                            "' aria-expanded='false' aria-controls='collapseOne' class='tx-gray-800 transition collapsed'>" +
                            "Acciones" +
                            "</a>" +
                            "</div>" +
                            "</div>" +
                            "</div>" +
                            "<div id='collapseOne" +
                            id +
                            "' class='collapse' role='tabpanel' aria-labelledby='headingOne'>" +
                            "<div class='card-body'>" +
                            "<div class='row'>" +
                            divs_acciones +
                            "</div></div></div></div></div>";

                        acordeonescont[index] = accordioncont;
                    });

                    if (valor == 1) {
                        prendido = "checked";
                    } else if (valor == 0) {
                        prendido = "";
                    }

                    if (acordeonescont[index]) {
                        acordeonescont[index];
                    } else {
                        acordeonescont[index] = " ";
                    }

                    const accordion =
                        "<div class='div-padre'>" +
                        "<h6 class='mg-t-15 pd-t-5 pd-b-5 mg-b-5 tx-inverse' style='background-color: #f8f9faa !important'>" +
                        "<label class='ckbox permiso mg-l-16'>" +
                        "<input type='checkbox' name='menu' id='" + id + "' data-id='" + id + "' class='menu padre' value='" +
                        id_menu + "' " + prendido + ">" + "<span style='font-size: 17px;'><u>" + descripcion + "</u></span>" +
                        "</label></h6></div>" +
                        acordeonescont[index];

                    acordeones = acordeones.concat(accordion);
                });

                $("#acordeondiv").html(acordeones);
            },
        });
    });
});


function guardarPermisos(){
    $("#modal_loading").modal("show");

    const permisos = [];
    const acciones = [];

    let valor;
    let id;

    $(".menu").each(function () {
        if ($(this).is(":checked")) {
            valor = 1;
        } else {
            valor = 0;
        }

        id = $(this).data("id");

        const permiso = {
            id: id,
            valor: valor,
        };
        permisos.push(permiso);
    });


    $(".accion").each(function () {
        if ($(this).is(":checked")) {
            valor = 1;
        } else {
            valor = 0;
        }

        id = $(this).data("id");

        const accion = {
            id: id,
            valor: valor,
        };
        permisos.push(accion);
    });

    $.ajax({
        type: "POST",
        url: "/public/guardar_defaultconf",
        data: {
            permisos,
            id_tipo_usuario: $("#select-tipousuario").val()
        },
        success: (response) => {
            if (response.status == 100) {
                $("#modalOk").modal("show");

            } else {
                $("#modalFail").modal("show");
            }
            setTimeout(() => {
                $("#modal_loading").modal("hide");
            }, 300);
        },
    });
}

  $('#acordeondiv').on('click', '.submenu', function(){
    const padre=$(this).attr('data-padre');
    $('#'+padre).prop("checked", true);
  });

  $('#acordeondiv').on('click', '.padre', function(){
    const id = $(this).attr('id');
    if($(this).is(':checked')){
      $('input[data-padre='+id+']').prop("checked", true);
    }else{
      $('input[data-padre='+id+']').prop("checked", false);
    }
  })

  $('#acordeondiv').on('click', '.transition', function() {
    if(!$(this).hasClass('tx-gray-800 transition collapsed')){
      $(this).parent().parent().find('.col-permiso, .acciones').css({'border-bottom':'none'})
    }else{
      $(this).parent().parent().find('.col-permiso, .acciones').css({'border-bottom':'1px solid #ced4da'})
    }
  });

</script>

@endsection
@section('seccion-modales')

<div id="modalOk" class="modal fade">
    <div class="modal-dialog" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-body tx-center pd-y-20 pd-x-20">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <span class="iconify" data-icon="ion-ios-checkmark-circle-outline" data-inline="false"></span>
            <h4 class=" tx-semibold mg-b-20" style='color:#4CAF50'>Proceso Concluido!</h4>

          <p id="" class="mg-b-20 mg-x-20" style='color:black'>Permisos Asignados Correctamente</p>

          <button type="button" class="btn btn-sucess" style='color:black' data-dismiss="modal" aria-label="Close" onclick="window.location.reload(true);" >Cerrar</button>
        </div><!-- modal-body -->
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
  </div><!-- modal -->

  <div id="modalFail" class="modal fade">
      <div class="modal-dialog" role="document">
        <div class="modal-content tx-size-sm">
          <div class="modal-body tx-center pd-y-20 pd-x-20">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <span class="iconify" data-icon="akar-icons:circle-x" style='color:red' data-inline="false"></span>
            <h4 class=" tx-semibold ' mg-b-20" style='color:red'>Proceso Terminado!</h4>

            <p id="" class="mg-b-20 mg-x-20" style='color:red'>Permisos no Asignados</p>

            <button type="button" class="btn btn-danger pd-x-25" data-dismiss="modal" aria-label="Close" >Cerrar</button>
          </div><!-- modal-body -->
        </div><!-- modal-content -->
      </div><!-- modal-dialog -->
    </div><!-- modal -->

@endsection
