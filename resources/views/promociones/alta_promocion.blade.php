@php
  use App\Http\Controllers\clases\humanRelativeDate;
  use App\Http\Controllers\clases\utilidades;
  $humanRelativeDate = new humanRelativeDate();
@endphp

@extends('layouts.index')

@section('contenido-pageheader')
 <ol class="breadcrumb slim-breadcrumb">
    <li class="breadcrumb-item"><a href="#">Promociones</a></li>
    <li class="breadcrumb-item"><a href="#"> Alta de Promociones </a></li>
 </ol>
 <h6 class="slim-pagetitle">Alta de Promociones </h6>
@endsection

@section('contenido-principal')

  {{--   @if(!isset($request->menu_general['response']))
    <div class="section-wrapper">
        <BR><h1 style="text-align: center;">Por el momento solo puede utilizar el modulo de demandas y promociones para su consulta</h1>
    </div>
    @else
    @if(!utilidades::buscarPermisoMenu($request->menu_general['response'], 1151))
        <div class="section-wrapper">
            <BR><h1 style="text-align: center;">Por el momento solo puede utilizar el modulo de demandas y promociones para su consulta</h1>
        </div>
    @else --}}
 <div class="section-wrapper" style="max-width: 100%;">

    <div class="form-layout">
        <div class="row mg-b-25 " id="datosSolicitudAudiencia">{{-- datos de solicitud de audiencia --}}
          <div class="col-lg-3">
            <div class="form-group">
              <label class="form-control-label tx-justify">Folio de Solicitud: </label>
              <input class="form-control" type="text" name="folio_solicitud_promocion" id="folioSolicitudPromocion" placeholder="Folio de Solicitud de Promocion" autocomplete="off" disabled>
            </div>
          </div><!-- col-3 -->
          <div class="col-lg-3">
            <div class="form-group">
              <label class="form-control-label">Fecha de la solicitud: </label>
              <div class="input-group">
                  <div class="input-group-prepend">
                      <div class="input-group-text">
                          <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                      </div>
                  </div>
                  <input type="text" class="form-control fc-datepicker" placeholder="DD/MM/AAAA" id="fechaSolicitud"  name="fecha_solicitud" autocomplete="off" disabled>
              </div>
            </div>
          </div><!-- col-3 -->
          <div class="col-lg-3">
                <div class="form-group">
                  <label class="form-control-label">Fecha de Recepción: <span class="tx-danger">*</span></label>
                  <div class="input-group">
                      <div class="input-group-prepend">
                          <div class="input-group-text">
                              <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                          </div>
                      </div>
                      <input type="text" class="form-control fc-datepicker" placeholder="DD-MM-AAAA" value="{{date('d-m-Y')}}" id="fechaRecepcion" name="fecha_recepcion" autocomplete="off">
                  </div>
                </div>
              </div><!-- col-3 -->
              <div class="col-lg-3">
                <form autocomplete="nope">
                <div class="form-group">
                  <label class="form-control-label">Hora de Recepción <small>(24hrs)</small>: <span class="tx-danger">*</span></label>
                  <div class="input-group clockpicker" data-placement="left" data-align="top" data-autoclose="true">
                    <input type="text" class="form-control"  id="horaRecepcion" name="hora_recepcion" autocomplete="nope">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-time"></span>
                    </span>
                  </div>
                </div>
              </form>
              </div>
              <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label">Tipo de promoción recibida: <span class="tx-danger">*</span></label>
                      <select class="form-control select2-show-search valid" id="tipoPromocion" name="tipo_promocion" autocomplete="off">
                          <option selected disabled value="">Elija una opción</option>
                          <option value=1>Petición Relacionada con carpeta judicial de la unidad de gestión</option>
                          <option value=2>Petición Relacionada a carpeta judicial de OTRA unidad de gestión</option>
                      </select>
                    </div>
                    <input type="hidden" id="id_carpeta_judicial">
              </div>
              <div class="col-lg-6" id="divAsociada" style="display:block">
                <div class="form-group">
                  <label class="form-control-label">Carpeta Judicial Asociada: <span class="tx-danger">*</span></label>
                    <form autocomplete="nope">
                  <input autocomplete="new-text" class="form-control" id="carpetaJudicialAsociada" onkeyup="buscarCarpeta();" placeholder="Escribe para Buscar..." autocomplete="nope">
                    </form>
                <datalist id="datalistCarpetas"></datalist>
                  <div id="carpetasJudicialesA"></div>
                </div>
              </div>
                <div class="col-lg-6" id="divReferida" style="display:none">
                <div class="form-group">
                  <label class="form-control-label">Carpeta Judicial Referida: <span class="tx-danger">*</span></label>
                  <form autocomplete="nope">
                   <input class="form-control" autocomplete="off" id="carpetaJudicialReferida"  onkeyup="buscarCarpetaReferida();" placeholder="Escribe para Buscar..." autocomplete="nope">
                 </form>
                  <datalist id="datalistCarpetas"></datalist>
                  <div id="carpetasJudicialesR"></div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                    <label class="form-control-label">Figura Jurídica: <span class="tx-danger">*</span></label>
                    <select class="form-control select2-show-search valid" id="figuraJuridica" name="figura_juridica" autocomplete="off">
                        <option selected disabled value="0">Elija una opción</option>
                            @foreach ($calidad_juridica as $calidad)
                                <option value="{{$calidad['id_calidad_juridica']}}">{{$calidad['calidad_juridica']}}</option>
                            @endforeach
                    </select>
                </div>
              </div>
          <div class="col-lg-6 mg-t-20">
            <div class="row">
                    <div class="col-9">
                       <label class="form-control-label">Si el promovente NO se encuentra en el listado, verifique haya seleccionado la carpeta judicial correcta</label>
                    </div>
              <div class="col-3">
                <div class="toggle-wrapper" id="checkPromovente"  name="check_promovente">
                  <div class="toggle toggle-light primary"></div>
                </div>
              </div>
            </div>
          </div>


          <div class="col-lg-6" id="promoventediv" style="display:block">
            <div class="form-group">
              <label class="form-control-label">Nombre del Promovente: <span class="tx-danger">*</span></label>
              <select class="form-control select2-show-search valid" id="nombrePromovente" name="nombre_promovente" autocomplete="off">
             </select>
            </div>
          </div><!-- col-9 -->


          <div class="col-lg-3" id="promoventediv2" style="display:none">
            <div class="form-group">
              <label class="form-control-label" >Nombres: <span class="tx-danger">*</span></label>
              <input class="form-control" type="text" name="nombrePromovente2" id="nombrePromovente2" value=""  placeholder="Nombres" autocomplete="off">

            </div>
          </div><!-- col-3 -->

          <div class="col-lg-3" id="promoventediv2-1" style="display:none">
            <div class="form-group">
              <label class="form-control-label" >Apellido Paterno: <span class="tx-danger">*</span></label>
              <input class="form-control" type="text" name="apellidoPPromovente2" id="apellidoPPromovente2" value=""  placeholder="Apellido Paterno" autocomplete="off">


            </div>
          </div><!-- col-3 -->

          <div class="col-lg-3" id="promoventediv2-2" style="display:none">
            <div class="form-group">
              <label class="form-control-label" >Apellido Materno</label>
              <input class="form-control" type="text" name="ApellidoMPromovente2" id="ApellidoMPromovente2" value=""  placeholder="Apellido Materno" autocomplete="off">
            </div>
          </div><!-- col-3 -->


          <div class="col-lg-6" >
            <div class="form-group">
              <label class="form-control-label">Tipo de Requerimiento: </label>
              <select class="form-control select2-show-search valid" id="tipoRequerimiento" name="tipo_requerimiento" autocomplete="off">
                  <option selected disabled value="">Elija una opción</option>
                  <option data-requerimiento="Promoción de Solicitud de Programación de Audiencia" value="1">Promoción de Solicitud de Programación de Audiencia</option>
                  <option data-requerimiento="Promoción de Tramite" value="2">Promoción de Tramite</option>
             </select>
            </div>
          </div><!-- col-9 -->

          <div class="col-lg-6" id="divAudiencia" style="display:none">
                <div class="form-group">
                  <label class="form-control-label">Tipo de Audiencia: </label>
                  <select class="form-control select2-show-search valid" id="tipoAudiencia" name="tipo_audiencia" autocomplete="off">
                      <option selected disabled value="">Elija una opción</option>
                          @foreach ($tipos_audiencia as $tipo_audiencia)
                          <option value="{{$tipo_audiencia['id_ta']}}" >{{$tipo_audiencia['tipo_audiencia']}}</option>
                    @endforeach
                  </select>
                </div>
              </div><!-- col-9 -->


          <div class="col-lg-12">
            <div class="form-group">
              <label class="form-control-label">Resumen del Documento</label>

              <th colspan="100%">
                <textarea  id="resumenDocumento" rows="2"  ></textarea>
                 </th>
            </div>
          </div><!-- col-9 -->


        </div><!-- row -->{{-- </datos de solicitud de audiencia> --}}

        <div id="accordion" class="accordion-one mg-b-20" role="tablist" aria-multiselectable="true">
            <div class="card">

                <div class="card-header" role="tab" id="headingOne">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" class="tx-gray-800 transition collapsed">
                    Personas autorizadas para recibir documentación
                    </a>
                </div><!-- card-header -->

                <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                    <div class="card-body">
                        <button class="btn btn-outline-primary mg-b-10 btn-sm mg-r-10" id="agregarPersona">Agregar Persona <i class="fa fa-plus"></i></button>
                        <div id="datosPersona">

                        </div>
                      </div>
                        </div>
                        </div>
                        </div>
                    <div class="form-layout-footer d-flex">
                      <button class="btn btn-primary btn btn-secondary bd-0 d-inline-block" onclick="enviarPromocion('registrar')">Guardar</button>
                      <button class="btn btn-primary bd-0 d-inline-block ml-auto" id="enviarPromocionDoc">Documento</button>
                    </div>
                  </div>
</div>
<div id="modalAdjuntarDocumento" class="modal fade">
    <div class="modal-dialog modal-lg mg-b-100" role="document" style="width: -webkit-fill-available;">
        <div class="modal-content tx-size-sm">
            <div class="modal-header pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"><span id="titleSujeto">Adjuntar Documento</span></h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pd-20">
                <form onsubmit="return false;" id="cargarDocumento" action="/" enctype="multipart/form-data">
                    <div class="custom-input-file">
                        <input type="file" id="archivoPDF" class="input-file" value="" name="archivoPDF" onchange="leeDocumento('archivoPDF');" />
                        <h5 class="px-3 py-3">Arrastre hasta aquí su documento pdf o de clic para adjuntarlo</h5>
                    </div>
                </form>
                <div id="Iframe-Master-CC-and-Rs" class="set-margin set-padding set-border set-box-shadow center-block-horiz">
                    <div id="divDucumento">
                        <object data="" id="documentoPDF" width="100%" class="d-none mg-t-25"></object>
                        <input type="hidden" id="bDoc" />
                        <input type="hidden" id="nameDoc" />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary d-inline-block mg-r-auto" onclick="cambiarPantalla('modal')" data-dismiss="modal">Cerrar</button>
                <button class="btn btn-primary btn btn-secondary bd-0 d-inline-block" onclick="enviarPromocion('registrar')">Guardar</button>
                <button type="button" class="btn btn-primary d-inline-block mg-l-auto" style="margin-left: auto;" onclick="enviarPromocion('turnar')">Turnar</button>
            </div>
        </div>
    </div>
</div>

@endsection

{{-- Secction Style --}}
  @section('seccion-estilos')
    <link href="{{asset("/lib/datatables/css/jquery.dataTables.css")}}" rel="stylesheet">
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
    <link rel="stylesheet" href="/js/clockpicker-gh-pages/src/clockpicker.css">
    <style>
      .flex-container {
        display: flex;
        justify-content: center;
      }

      textarea{
        background-color: white  !important;
        min-height: 100px !important;
        width: 100% !important;
      }

      .accordion {
        /* background-color: #eee; */

        color: #444;
        cursor: pointer;
        padding: 10px;
        width: 100%;
        border: none;
        text-align: left;
        outline: none;
        font-size: 15px;
        transition: 0.4s;
      }

      .active, .accordion:hover {
        /*  background-color: #ccc; */
      }

      .flex-container > div {
        margin: 1px;
        padding: 1px;
        font-size: 16px;
      }

      @media screen and (max-width: 600px) {

      }

      #modal-ver .modal-dialog {
        width: 100%;
        max-width:700px;
        height: 90%;
        margin: 0;
        padding: 1;
      }

      span.select2-container.select2-container--default.select2-container--open{
        width:'100%';
      }

      .datepicker-container{
          z-index: 1110;
      }

      .abs-center {
              display: flex;
              align-items: center;
              justify-content: center;
              min-height: 100vh;
      }

      .iconify{
          display: inline-block;
          text-align: left;
          vertical-align: top;
      }

      .fecha{
          min-width: 111px !important;
      }

      tbody.table-datos-sujeto tr td:first-child{
        background-color: #f8f9fa;
        min-width: 150px;
        font-weight: bolder;
      }

      input[carpetaJudicialAsociada]{
        max-width: 400%;

      }

      /*Input Carpeta Asociada*/
      #carpetaJudicialAsociada{
        background: #fff;
      }
      #carpetasJudicialesA, #carpetasJudicialesR{
        width: 96%;
        max-height: 200px;
        overflow-y: auto;
        background: #444;
        position: absolute;
        z-index: 1000;
      }
      @media (max-width:768px){
        #carpetasJudicialesA, #carpetasJudicialesR{
          width: 95.5%;
        }
      }
      @media (max-width:416px){
        #carpetasJudicialesA, #carpetasJudicialesR{
          width: 92%;
        }
      }
      @media (max-width:360px){
        #carpetasJudicialesA, #carpetasJudicialesR{
          width: 90%;
        }
      }
      #carpetasJudicialesA ul, #carpetasJudicialesR ul{
        width: 100%;
        padding: 6px;
        background: #444;
        color: #fff;
        list-style: none;
      }
      #carpetasJudicialesA ul li, #carpetasJudicialesR ul li{
        width: 100%;
        padding: 5px;
        text-align: left;
        cursor: pointer;
        transition: all 300ms;
      }
      #carpetasJudicialesA ul li:hover, #carpetasJudicialesR ul li:hover{
        background: rgb(86, 86, 86);
      }
      table a:hover{
          font-weight:bold;
      }
      span.select2-container{
          width:'100%';
      }
            /* .active:after {
                        content: "\2212";
                        } */
      .panel {
        padding: 0 18px;
        background-color: white;
        max-height: 0;
        overflow: hidden;
        transition: 0.2s ease-out;
      }

      #datosPersona .row{
        border: 1px solid #EEE;
        border-collapse: collapse;
        margin-top: 2px
      }

      div#datosPersona .row:nth-child(2n){
        background: #FDFDFD !important;
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
        color: #848F33;
        border: 2px solid #EEE;
        border-style: dotted;
        height: 80px;
        border-radius: 25px;
        width: 80%;
      }

      .custom-input-file:hover{
        background: #848F33;
        color: #fff;
      }

      .custom-input-file .input-file{
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

      #Iframe-Master-CC-and-Rs {
            max-height: 70%;
            overflow: hidden;
            }
      #modalAdjuntarDocumento .modal-dialog {
        font-size: 18px;
        width: 100%;
        max-width:80%;
        height: 90%;
        margin: 0;
        padding: 1;
      }

     #modalAdjuntarDocumento .modal-body {
         height: 95%;
         min-width: 90%;
     }

    #modalAdjuntarDocumento .modal-content {
         height: 95%;
         min-width: 90%;
     }

     #documentoPDF{
         min-height: 500px;
        min-width: 100%;

     }
</style>

@endsection


{{-- Section Script--}}
@section('seccion-scripts-libs')
     <script src="/js/clockpicker-gh-pages/src/clockpicker.js"></script>

     <script src="{{ $entorno["version_pages"]["version"] }}/lib/jquery-ui/js/jquery-ui.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/datatables/js/jquery.dataTables.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/datatables-responsive/js/dataTables.responsive.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/select2/js/select2.min.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/moment/js/moment.js"></script>
     <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
     <script src="sweetalert2.all.min.js"></script>
     <script src="sweetalert2.min.js"></script>
     <link rel="stylesheet" href="sweetalert2.min.css">
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
@endsection

@section('seccion-scripts-functions')
<script>

window.onload = function() {
  var carpetaSeleccionadaR = document.getElementById('carpetaJudicialReferida');
  carpetaSeleccionadaR.onpaste = function(e) {
    e.preventDefault();
    $('#bSocumento').focus().addClass('error');
    $('#messageError').html("Digite el folio de la carpeta judicial y seleccione del listado");
    $('#modalError').modal('show');

    var carpetaSeleccionadaA = document.getElementById('carpetaJudicialAsociada');
    carpetaSeleccionadaA.onpaste = function(e) {
      e.preventDefault();
      $('#bSocumento').focus().addClass('error');
      $('#messageError').html("Digite el folio de la carpeta judicial y seleccione del listado");
      $('#modalError').modal('show');
    }
  }
}

window.addEventListener("DOMContentLoaded", () => {
  var m = document.getElementById("carpetasJudicialesA");
  var r = document.getElementById("carpetasJudicialesR");
  if(m.style.display !== "none") (function (){
    window.addEventListener("click", () => { m.style.display = "none";});
  })();
  if(r.style.display !== "none") (function (){
    window.addEventListener("click", () => { r.style.display = "none";});
  })();
});

let solicitudes=[];
let tabla_direcciones=[];
let tabla_alias=[];
let tabla_contacto=[];
let tabla_correo=[];

let tabla_datos=[];
let tabla_delitos=[];
let tabla_no_relacionados=[];

let folio_carpeta_seleccionada="";
let id_carpeta_seleccionada="";
let tamañoPDF;
fecha_actual = new Date();


const expVacio=/^[\s]*$/;

$(function () {
    "use strict";
    $("#agregarPersona").click(function () {
        $("#datosPersona").append(
            "<div class='row datos-persona'>" +
                "<div class='col-12' >" +
                "<p class='tx-right tx-danger'><i class='fa fa-close borrar-persona'></i></p>" +
                "</div>" +
                "<div class='col-lg-3'>" +
                "<div class='form-group mg-b-10-force'>" +
                "<label class='form-control-label'>Nombres:</label>" +
                "<input class='form-control persona' type='text' name='personaAgregada' autocomplete='off'>" +
                "</div>" +
                "</div>" +
                "<div class='col-lg-3'>" +
                "<div class='form-group mg-b-10-force'>" +
                "<label class='form-control-label'>Apellido Paterno:</label>" +
                "<input class='form-control personaP' type='text' name='personaAgregadaPaterno' autocomplete='off'>" +
                "</div>" +
                "</div>" +
                "<div class='col-lg-3'>" +
                "<div class='form-group mg-b-10-force'>" +
                "<label class='form-control-label'>Apellido Materno:</label>" +
                "<input class='form-control personaM' type='text' name='personaAgregadaMaterno' autocomplete='off'>" +
                "</div>" +
                "</div>" +
                "</div>"
        );
    });

    $("#datosPersona").on("click", ".borrar-persona", function () {
        $(this).parent().parent().parent().remove();
    });

    $("#checkPromovente").click(function () {
        var $this = $(this);

        if ($("#checkPromovente").find(".toggle-off").hasClass("active")) {
            $("#promoventediv").css("display", "block");
            $("#promoventediv2").css("display", "none");
            $("#promoventediv2-1").css("display", "none");
            $("#promoventediv2-2").css("display", "none");
        } else if ($("#checkPromovente").find(".toggle-on").hasClass("active")) {
            $("#checkPromovente").css("clicked");
            $("#promoventediv").css("display", "none");
            $("#promoventediv2").css("display", "block");
            $("#promoventediv2-1").css("display", "block");
            $("#promoventediv2-2").css("display", "block");
        }
    });

    //TIPO PROMOCION
    document.getElementById("tipoPromocion").onchange = function () {
        $("#id_carpeta_judicial").val("");

        if ($("#tipoPromocion").val() == "2") {
            $("#carpetaJudicialAsociada").val("");

            $("#divReferida").css("display", "block");
            $("#divAsociada").css("display", "none");
        } else if ($("#tipoPromocion").val() == "1") {
            $("#carpetaJudicialReferida").val("");

            $("#divReferida").css("display", "none");
            $("#divAsociada").css("display", "block");
        }
    };

    //TIPO AUDIENCIA
    document.getElementById("tipoRequerimiento").onchange = function () {
        if ($("#tipoRequerimiento").val() == "1") {
            $("#divAudiencia").css("display", "block");
        } else {
            $("#divAudiencia").css("display", "none");
        }
    };

    Toggles;
    $(".toggle").toggles({
        on: false,
        height: 26,
    });

    // Select2
    $(".select2").select2({
        minimumResultsForSearch: Infinity,
    });

    $(function () {
        "use strict";
        $(".ui-datepicker-year").addClass("select2");

        $(".clockpicker").clockpicker();
        // Datepicker
        $(".fc-datepickerA").datepicker({
            showOtherMonths: true,
            selectOtherMonths: true,
            format: "dd/mm/yyyy",
            changeYear: true,
            yearRange: "c-100:" + fecha_actual.getFullYear(),
        });

        $("#datepickerNoOfMonths").datepicker({
            showOtherMonths: true,
            selectOtherMonths: true,
            numberOfMonths: 2,
        });
    });

    // Time Picker
    $("#tpBasic").timepicker();
    $("#tp2").timepicker({ scrollDefault: "now" });
    //$('#horaRecepcion').timepicker();

    $("#setTimeButton").on("click", function () {
        //$('#horaRecepcion').timepicker('setTime', new Date());
    });

    //focus textfiled
    $(".form-layout .form-control").on("focusin", function () {
        $(this).closest(".form-group").addClass("form-group-active");
    });
    $(".form-layout .form-control").on("focusout", function () {
        $(this).closest(".form-group").removeClass("form-group-active");
    });

    //TIPO persona

    $(document).ready(function () {
        document.getElementById("figuraJuridica").onchange = function () {
            var figura = $("#figuraJuridica").val();
            folio_carpeta_seleccionada = "";
            id_carpeta_seleccionada = "";

            if ($("#carpetaJudicialAsociada").val()) {
                folio_carpeta_seleccionada = $("#carpetaJudicialAsociada").val();
                id_carpeta_seleccionada = $("#id_carpeta_judicial").val();
            } else if ($("#carpetaJudicialReferida").val()) {
                folio_carpeta_seleccionada = $("#carpetaJudicialReferida").val();
                id_carpeta_seleccionada = $("#id_carpeta_judicial").val();
            }

            if ($("#figuraJuridica").val()) {
                $.ajax({
                    type: "POST",
                    url: "/public/buscar_partes_carpeta",
                    data: {
                        figura: figura,
                        id_carpeta_judicial: id_carpeta_seleccionada,
                    },
                    success: function (response) {
                        if (response.status == 100) {
                            if (figura == 10001) {
                                //ministerio publico
                                $("#nombrePromovente").prop("disabled", true);
                                $("#nombrePromovente").removeClass("valid");
                            } else {
                                $("#nombrePromovente").prop("disabled", false);
                                $("#nombrePromovente").addClass("valid");

                                let datosFigura = "";
                                $(response.response).each(function (index, datos) {
                                    const { folio_carpeta, id_carpeta_judicial, id_solicitud, personas, razon_social } = datos;

                                    if (personas) {
                                        $(personas).each(function (index, persona) {
                                            const { id_persona, nombre, apellido_materno, apellido_paterno, calidad_juridica, id_calidad_juridica, razon_social } = persona;
                                            const option = "<option value='" + persona.id_persona + "'>" + persona.nombre + "</option>";
                                            datosFigura = datosFigura.concat(option);
                                        });
                                    } else {
                                        const option = "<option value='0'>Sin datos relacionados</option>";
                                        datosFigura = datosFigura.concat(option);
                                    }
                                });
                                $("#nombrePromovente").html("<option selected disabled >Seleccione...</option>" + datosFigura);
                            }
                        }
                    },
                });
            }
        };
    });

    //promocion antes de pdf
    $("#enviarPromocionDoc").click(function () {
        $(".error").removeClass("error");
        const validacion = validarDatos();
        if (validacion == 100) {
            mostrarModalDocumento();
        } else {
            const { campo, error } = validacion;
            if ($("#" + campo).is("select")) {
                $('span[aria-labelledby="select2-' + campo + '-container"]').addClass("error");
            } else {
                $("#" + campo)
                    .focus()
                    .addClass("error");
            }
            $("#messageError").html(`${error}`);
            $("#modalError").modal("show");
        }
    });

    setTimeout(function () {
        $("#modal_loading").modal("hide");
    }, 1000);
});


function mostrarModalDocumento(){
  $('#modalAdjuntarDocumento').modal('show');
}

function leeDocumento(input) {
    console.log();
    const file = $("#archivoPDF").val();
    const ext = file.substring(file.lastIndexOf("."));
    tamañoPDF = "";
    if (ext != "") {
        if (ext == ".pdf" || ext == ".PDF") {
          if (input.files && input.files[0]) {
              const reader = new FileReader();
              reader.onload = (e) => {
                  $("#documentoPDF").attr("data", e.target.result);
                  $("#nameDoc").val(input.files[0].name);
                  $("#documentoPDF").removeClass("d-none");
                  $("#bDoc").val(e.target.result.split("base64,")[1]);
                  tamañoPDF = input.files[0].size / 1024;
              };
              reader.readAsDataURL(input.files[0]);
          }

        } else {

          alert("Solo puede adjuntar archivos .pdf");
          $("#archivoPDF").val("");

        }
    }
}

$("#archivoPDF").on("input", function () {
    leeDocumento(this);
});


function setInputCarpteaAsociada(carpeta, tipo, idCarpeta){
  $("#id_carpeta_judicial").val(idCarpeta);
  if(tipo == 'asociado'){
    if(carpeta == 'n' && idCarpeta=='n'){
      $('#carpetaJudicialAsociada').val('');
      $('#carpetasJudicialesA').css('display', 'none');
    }else{
      $('#carpetaJudicialAsociada').val(carpeta);
      $('#carpetaJudicialAsociada').attr('data-idcarpeta',idCarpeta);
      $('#carpetasJudicialesA').css('display', 'none');
    }
  }else if(tipo == 'referido'){
    if(carpeta == 'n' && idCarpeta=='n'){
      $('#carpetaJudicialReferida').val('');
      $('#carpetasJudicialesR').css('display', 'none');
    }else{
      $('#carpetaJudicialReferida').val(carpeta);
      $('#carpetaJudicialReferida').attr('data-idcarpeta',idCarpeta);
      $('#carpetasJudicialesR').css('display', 'none');
    }
  }
}

function buscarCarpeta() {

    var carpetaAsociada = $('#carpetaJudicialAsociada').val();
    $('#carpetasJudicialesA').html("");

    var calidad = @php echo json_encode($calidad_juridica);@endphp;
    var option_cali = "<option disabled selected>Elija una opción</optio>";
    for(var i in calidad){
    option_cali += "<option value=" + calidad[i].id_calidad_juridica + ">" + calidad[i].calidad_juridica + "</option>"
    }

    $("#figuraJuridica").html(option_cali);
    $("#nombrePromovente").html("");


          $.ajax({
          type:'POST',
          url:'public/buscar_carpetas_asociadas',
          data:{
            carpetaAsociada: carpetaAsociada,
          },
          success:function(response){

              if(response.status==100){

                $('#carpetasJudicialesA').css('display', 'block');
                let carpetas='';
                var carpetas_act = [];
                $(response.response).each(function(index, carpeta){

                  const {id_carpeta_judicial,folio_carpeta}  = carpeta;
                  const option=`<li onclick="setInputCarpteaAsociada('${folio_carpeta}', 'asociado', '${id_carpeta_judicial}')">${folio_carpeta}</li>`;
                  carpetas=carpetas.concat(option);
                });

                $('#carpetasJudicialesA').html(`
                  <ul>
                    <li disabled selected>Elija una opción</li> `+ carpetas+`
                  </ul>`
                );
              }
              else{
               $('#carpetasJudicialesA').html("<ul><li>SIN DATOS</li></ul>");
              }
              setTimeout(function(){  $('#modal_loading').modal('hide');  }, 500);
          }
      });
}

function buscarCarpetaReferida() {
    var carpetaAsociada = $('#carpetaJudicialReferida').val();

    $('#carpetasJudicialesR').html("");

    var calidad = @php echo json_encode($calidad_juridica);@endphp;
    var option_cali = "<option disabled selected>Elija una opción</optio>";
    for(var i in calidad){
    option_cali += "<option value=" + calidad[i].id_calidad_juridica + ">" + calidad[i].calidad_juridica + "</option>"
    }

    $("#figuraJuridica").html(option_cali);
    $("#nombrePromovente").html("");

          $.ajax({
            type:'POST',
            url:'public/buscar_carpetas_referidas',
            data:{
              carpetaAsociada: carpetaAsociada,
            },
            success:function(response){

              if(response.status==100){
                $('#carpetasJudicialesR').css('display', 'block');
                let carpetas='';
                $(response.response).each(function(index, carpeta){
                  const {id_carpeta_judicial,folio_carpeta}  = carpeta;
                  const option=`<li onclick="setInputCarpteaAsociada('${folio_carpeta}', 'referido', '${id_carpeta_judicial}')">${folio_carpeta}</li>`;
                  carpetas=carpetas.concat(option);
                });

                $('#carpetasJudicialesR').html(`
                  <ul>
                    <li disabled selected>Elija una opción</li> `+ carpetas+`
                  </ul>`
                );

            }else{

              $('#carpetasJudicialesR').html("<ul><li>SIN DATOS</li></ul>");
            }
            setTimeout(function(){  $('#modal_loading').modal('hide');  }, 500);
            }
          });
}

function validarDatos() {
    if ($("#fechaRecepcion").val() == null) return { estatus: 0, campo: "fechaRecepcion", error: "No ha seleccionado la fecha de recepcion" };

    if (expVacio.test($("#horaRecepcion").val())) return { estatus: 0, campo: "horaRecepcion", error: "Falta la hora de recepcion" };

    if (expVacio.test($("#id_carpeta_judicial").val())) return { estatus: 0, campo: "id_carpeta_judicial", error: "Seleccione Carpeta Judicial" };

    if ($("#tipoPromocion").val() == null) return { estatus: 0, campo: "tipoPromocion", error: "No ha seleccionado el tipo de promocion" };

    if ($("#tipoPromocion").val() == "1") {
        if (expVacio.test($("#carpetaJudicialAsociada").val())) return { estatus: 0, campo: "carpetaJudicialAsociada", error: "Falta la carpeta Judicial Asociada " };
    } else {
        if (expVacio.test($("#carpetaJudicialReferida").val())) return { estatus: 0, campo: "carpetaJudicialReferida", error: "Falta la carpeta Judicial Referida " };
    }

    if ($("#figuraJuridica").val() == null) return { estatus: 0, campo: "figuraJuridica", error: "No ha seleccionado la figura juridica" };

    if ($("#checkPromovente").find(".toggle-off").hasClass("active") && $("#figuraJuridica").val() != 10001) {
        if ($("#nombrePromovente").val() == null) return { estatus: 0, campo: "nombrePromovente", error: "No ha seleccionado el nombre del promovente asociado" };
    } else if ($("#checkPromovente").find(".toggle-on").hasClass("active")) {
        if (expVacio.test($("#nombrePromovente2").val())) return { estatus: 0, campo: "nombrePromovente2", error: "Falta el nombre del promovente" };
        if (expVacio.test($("#apellidoPPromovente2").val())) return { estatus: 0, campo: "apellidoPPromovente2", error: "Falta el apellido del promovente" };
    }
    return 100;
}


function enviarPromocion(valor) {
    var title = "";
    var confirmButtonText = "";

    if (valor == "turnar") {
        title = "¿Desea turnar la Promoción?";
        confirmButtonText = "Si,Turnar";
    }
    if (valor == "registrar") {
        title = "¿Desea guardar los cambios de la Promoción?";
        confirmButtonText = "Si,Guardar";
    }

    const validaDocumento = $("#bDoc").val();

    if ((validaDocumento == "" || validaDocumento == null) && valor == "turnar") {
        $("#bSocumento").focus().addClass("error");
        $("#messageError").html("Falta documento PDF");
        $("#modalError").modal("show");
    } else {
        Swal.fire({
            title: title,
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonColor: "#889434",
            confirmButtonText: confirmButtonText,
            denyButtonText: `No, seguir registrando`,
            denyButtonColor: "#A7A7A7",
        }).then((result) => {
            if (result.isConfirmed) {
                $(".error").removeClass("error");
                const validacion = validarDatos();
                if (validacion != 100) {
                    const { campo, error } = validacion;
                    if ($("#" + campo).is("select")) {
                        $('span[aria-labelledby="select2-' + campo + '-container"]').addClass("error");
                    } else {
                        $("#" + campo)
                            .focus()
                            .addClass("error");
                    }
                    $("#messageError").html(`${error}`);
                    $("#modalError").modal("show");
                } else {
                    $("#modal_loading").modal("show");
                    let arrPersonas = [];
                    $(".datos-persona").each(function () {
                        datos = {
                            nombres: $(this).find(".persona").val(),
                            apellido_paterno: $(this).find(".personaP").val(),
                            apellido_materno: $(this).find(".personaM").val(),
                        };
                        arrPersonas.push(datos);
                    });

                    var req = "";
                    if ($("#tipoRequerimiento").val() == "1") {
                        req = "Promoción de Solicitud de Programación de Audiencia";
                    } else if ($("#tipoRequerimiento").val() == "2") {
                        req = "Promoción de Tramite";
                    }

                    $.ajax({
                        type: "POST",
                        url: "public/enviar_promocion",
                        data: {
                            fecha_recepcion: $("#fechaRecepcion").val(),
                            hora_recepcion: $("#horaRecepcion").val(),
                            tipo_promocion: $("#tipoPromocion").val(),
                            id_carpeta: $("#id_carpeta_judicial").val(),
                            folio_carpeta: folio_carpeta_seleccionada,
                            id_calidad_juridica: $("#figuraJuridica").val(),
                            id_persona: $("#nombrePromovente").val(), //id persona promovente
                            nombres: $("#nombrePromovente2").val(),
                            apellido_paterno: $("#apellidoPPromovente2").val(),
                            apellido_materno: $("#ApellidoMPromovente2").val(),
                            id_tipo_requerimiento: $("#tipoRequerimiento").val(),
                            tipo_requerimiento: req,
                            tipoAudiencia: $("#tipoAudiencia").val(),
                            resumen: $("#resumenDocumento").val(),
                            nombre_documento: $("#nameDoc").val(),
                            extension_doc: "PDF",
                            tamanio_archivo_b64: tamañoPDF,
                            b64_doc: $("#bDoc").val(),
                            personas: arrPersonas,
                            estatus_registro: valor
                        },
                        success: function (response) {
                            if (response.status == 100) {
                                let tabla =
                                    "<table style='border:1px solid #EEE' class='dataTable'>" +
                                    "<tbody class='table-datos-sujeto'>" +
                                    "<tr>" +
                                    "<td>Mensaje</td>" +
                                    "<td>" +
                                    response.response +
                                    "</td>" +
                                    "</tr>" +
                                    "<tr>" +
                                    "<td>Folio de Carpeta</td>" +
                                    "<td>" +
                                    response.folio_carpeta_judicial +
                                    "</td>" +
                                    "</tr>" +
                                    "<tr>" +
                                    "<td>Unidad de gestión receptora</td>" +
                                    "<td>" +
                                    response.unidad +
                                    "</td>" +
                                    "</tr>" +
                                    "<tr>" +
                                    "<td>Folio</td>" +
                                    "<td><p class='fl-m mg-b-0'>" +
                                    response.folio +
                                    "</p></td>" +
                                    "</tr>" +
                                    "<tr>" +
                                    "<td>Id Acuse</td>" +
                                    "<td>" +
                                    response.id_promocion +
                                    "</td>" +
                                    "</tr>" +
                                    "<tr>" +
                                    "<td>Respuesta</td>" +
                                    "<td>" +
                                    response.estatus_registro +
                                    "</td>" +
                                    "</tr>" +
                                    "</tbody>" +
                                    "</table>";

                                $("#datos-respuesta-promocion").html(tabla);
                                $("#modalAdjuntarDocumento").modal("hide");
                                $('#modalSuccess').modal('show');


                            } else {
                                var texto_modal_fail = "<p class='mg-b-20 mg-x-20'>" + response.message + "</p>";

                                $("#texto_modal_fail").html(texto_modal_fail);
                                $('#modalFail').modal('show');

                            }
                            setTimeout(() => {
                                $("#modal_loading").modal("hide");
                            }, 300);
                        },
                    });
                }
            }
        });
    }
}


</script>
@endsection

@section('seccion-modales')

    {{-- VER SOLICITUD --}}
    <div id="modal-ver" class="modal fade" data-keyboard="false">
            <div class="modal-dialog modal-dialog-vertical-center" role="document">
              <div class="modal-content bd-0 tx-14">


                 <div class="modal-body">
                            <button type="button" class="close ml-auto"  data-dismiss="modal" aria-label="Close">
                                <span  aling="right" aria-hidden="true">&times;</span>
                            </button>
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Datos de la Solicitud</a>
                                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Personas</a>
                                <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Delitos no Relacionados</a>
                                </div>
                            </nav>
                            <br>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                    <table id="datosolicitud" class="dataTables"> </table>
                                </div>
                                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                              <div class="accordion" id="acordeon" role="tablist"> </div>
{{--                                     <table id="datosparticipantes" class="dataTables"> </table>
 --}}
                               </div>
                                <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                                    <table id="datosno-asociados" class="dataTables"> </table>
                                </div>
                            </div>
                            <br>
                         </div>
                 <div class="modal-footer">
                        <div id="boton" data-dismiss="modal">Turnar</div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
              </div>
            </div><!-- modal-dialog -->
        </div><!-- modal -->
          <div id="modalFail" class="modal fade">
            <div class="modal-dialog" role="document">
              <div class="modal-content tx-size-sm">
                <div class="modal-body tx-center pd-y-20 pd-x-20">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <i class="icon ion-ios-close-outline tx-100 style='color:red' lh-1 mg-t-20 d-inline-block"></i>
                  <h4 class=" tx-semibold style='color:red' mg-b-20">No disponible</h4>
                  <div id="texto_modal_fail">

                  </div>
                  <button type="button" class="btn btn-danger pd-x-25" data-dismiss="modal" aria-label="Close" >Cerrar</button>
                </div><!-- modal-body -->
              </div><!-- modal-content -->
            </div><!-- modal-dialog -->
          </div><!-- modal -->

         {{--  <div id="modalOkTurnado" class="modal fade">
            <div class="modal-dialog" role="document">
              <div class="modal-content tx-size-sm">
                <div class="modal-body tx-center pd-y-20 pd-x-20">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <i class="icon ion-ios-checkmark-circle-outline tx-100 color='#848F33' lh-1 mg-t-20 d-inline-block"></i>
                  <h4 class=" tx-semibold style='color:green' mg-b-20" style='color:green'>Proceso Concluido!</h4>

                  <p id="carpetaAsignada" color='green'  class="mg-b-20 mg-x-20">Carpeta Judicial Asignada</p>

                  <button type="button" class="btn btn-sucess pd-x-25" data-dismiss="modal" aria-label="Close" onclick="window.location.reload()" aria-label="Close" >Cerrar</button>
                </div><!-- modal-body -->
              </div><!-- modal-content -->
            </div><!-- modal-dialog -->
          </div><!-- modal -->
 --}}
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
                  <button type="button" class="btn btn-danger pd-x-25" data-dismiss="modal" aria-label="Close">Aceptar</button>
                </div><!-- modal-body -->
              </div><!-- modal-content -->
            </div><!-- modal-dialog -->
          </div><!-- modal -->

          <div id="modalSuccess" class="modal fade"  data-backdrop="static" data-keyboard="false" >
            <div class="modal-dialog" role="document">
              <div class="modal-content tx-size-sm">
                <div class="modal-header pd-x-20">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"><span id="">Promoción Registrada</h6>
                </div>
                <div class="modal-body tx-center pd-y-20 pd-x-20">
                  <div id="datos-respuesta-promocion" align="left">

                  </div>
                </div><!-- modal-body -->
                <div class="modal-footer d-flex">
                  <button type="button" class="btn btn-primary pd-x-25 mg-l-auto" data-dismiss="modal" aria-label="Close" onclick="window.location.reload()">Aceptar</button>
                </div>
              </div><!-- modal-content -->
            </div><!-- modal-dialog -->
          </div><!-- modal -->

      {{--     <div id="modalOkTurnado" class="modal fade">
            <div class="modal-dialog" role="document">
              <div class="modal-content tx-size-sm">
                <div class="modal-body tx-center pd-y-20 pd-x-20">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <i class="icon ion-ios-checkmark-circle-outline tx-100 color='#848F33' lh-1 mg-t-20 d-inline-block"></i>
                  <h4 class=" tx-semibold style='color:green' mg-b-20" style='color:green'>Proceso Concluido!</h4>

                  <p id="carpetaAsignada" color='green'  class="mg-b-20 mg-x-20">Promoción Registrada Correctamente</p>

                  <button type="button" class="btn btn-sucess pd-x-25" data-dismiss="modal" onclick="window.location.reload()" aria-label="Close" >Cerrar</button>
                </div><!-- modal-body -->
              </div><!-- modal-content -->
            </div><!-- modal-dialog -->
          </div><!-- modal --> --}}

@endsection
