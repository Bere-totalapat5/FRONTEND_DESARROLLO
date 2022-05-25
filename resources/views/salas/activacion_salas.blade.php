@php
use App\Http\Controllers\clases\humanRelativeDate;
use App\Http\Controllers\clases\utilidades;
$humanRelativeDate = new humanRelativeDate();
@endphp
@extends('layouts.index')
@section('contenido-pageheader')
    <ol class="breadcrumb slim-breadcrumb">

        <li class="breadcrumb-item"><a href="#">Salas</a></li>
        <li class="breadcrumb-item active" aria-current="page">Activación de Salas</li>
    </ol>
    <h6 class="slim-pagetitle">Activación de Salas</h6>
@endsection

@section('contenido-principal')
    {{-- @if ($error != '')
    <div class="alert alert-warning" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <strong>Alerta!</strong> {{$error}}.
    </div><!-- alert -->
    @endif --}}
    <div class="section-wrapper">


      {{-- <select class="form-control select2-show-search valid" id="tipoAudiencia" name="tipo_audiencia" autocomplete="off">
      <option selected disabled value="">Elija una opción</option>
        @foreach ($tipos_audiencia as $tipo_audiencia)
             <option value="{{$tipo_audiencia['id_ta']}}" data-duracion="{{$tipo_audiencia['promedio_duracion']}}">{{$tipo_audiencia['tipo_audiencia']}}</option>
        @endforeach
      </select> --}}



        <div class="row">

            <div class="col-lg-12">
                <h3 class="card-profile-name">Activación de Salas</h3>
            </div>

            <div class="col-lg-4">
                <div class="form-group">
                    <label class="form-control-label">Selecciona la Unidad de Gestion a consultar:
                        {{-- <span class="tx-danger">*</span> --}}</label>
                    <select class="form-control select2-show-search valid" id="select_unidad" name="select_unidad"
                        autocomplete="off">
                        <option selected disabled value="">Elija una opción</option>
                        @foreach ($unidades['response'] as $unidad)
                            <option value="{{ $unidad['id_unidad_gestion'] }}">{{ $unidad['nombre_unidad'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="ml-auto p-2" style="padding-right: 1rem !important;">
              <div class="align-self-end">
                <button class="btn btn-primary" onclick="mostrarModalSala('nuevo',null)">Nueva Sala</button>
              </div>
            </div>

            <br>
            <br>

            <div class="col-lg-12">
                <div class="form-group">
                    <div id="acordeondiv" role="tablist"> </div>
                    {{-- <div  id="acordeoncont" role="tablist"> </div>
                    <div  id="acordeonbox" role="tablist"> </div> --}}
                    </select>
                </div>
            </div>

            {{-- <div class="col-lg-12">
                <button class="btn btn-primary btn-block btn-sm mg-t-25"
                    onclick="guardarModificacionSalas();">Guardar</button>
            </div><!-- col-4 --> --}}


        </div>


    </div>

@endsection

@section('seccion-estilos')
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
    <link href="{{ $entorno["version_pages"]["version"] }}/lib/select2/css/select2.min.css" rel="stylesheet">


    <style>
        .tx-primary {
          color: #848F33 !important;
        }
        
        .box-edit{
          padding-top: 0.2rem !important;
          padding-right: 0.3rem !important;
        }

        .select2-container.select2-container--default.select2-container--open{
          z-index: 1050 !important;
        }

        label.permiso {
            /* width: max-content; */
            /* display: inline-block; */
            margin-bottom: 0;
            margin-top: 5px;
            color: black;
        }

        .col-permiso {
            padding: 5px 20px;
            /* background-color: #f8f9fa; */
        }

        .accordion-one .card-header a::before {
            top: 5px !important;

        }

        .accordion-one .card-header {
            /* border: 1px solid lightgrey; */
            border-bottom: 1px solid lightgrey;
        }

        a.transition {
            /* display: inline-block !important; */
            /* font-weight: 300; */
            margin-top: 3px;
            padding: 5px 20px !important;
        }

        .col-6.salas {
            padding-left: 0;
            text-align: center;
        }

        .card-header .row {
            padding-left: 15px;
            padding-right: 15px;


        }

        .btn {
            background-color: #4CAF50;


        }

        .accordion-one .card-header a {
            display: block;
            padding: 9px 10px;
            color: #154f89;
            position: relative;
            border-bottom: none !important;
            background-color: #fff !important;

        }

        .accordion-one {
            max-width: 100%;

        }

        .iconify {
            display: inline-block;
            text-align: left;
            vertical-align: top;
            width: 90px;
            height: 90px;
            color: #4CAF50;
        }

        .div-padre {
            max-width: 700px;
            background-color: #f8f9fa;
        }

        .mg-l-16 {

            margin-left: 16px;
        }

        .selected_all{
          position: absolute;
          top: 13%;
          right: 20%;
          font-size: 0.9em;
          color:#848F33 !important;
          cursor: pointer;
          padding: 4px;
          z-index: 1000;
        }
        .selected_all:hover{
          background: #f5f7f5;
          border-radius: 8px;
        }
        .textSalas{
          text-align: center !important;
          padding-left: 5% !important;
        }
        @media(max-width: 1024){
          .textSalas{
            padding-left: 3% !important;
          }
          .selected_all{
            right: 24%;
          }
        }
        @media(max-width: 500px){
          .textSalas{
            text-align: left !important;
            padding-left: 0% !important;
          }
          .selected_all{
            right: 21%;
          }
          .accordion-one .card-header a::before {
            right: 0px !important;
          }
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
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>



@endsection



@section('seccion-scripts-functions')
    <script>
        let ID_usuario = '';

        $(function() {
            'use strict';

            //timeout modal
            setTimeout(function() {
                $('#modal_loading').modal('hide');
            }, 1000);


            // Select2
            $('.select2').select2({
                minimumResultsForSearch: Infinity
            });


            //focus textfiled
            $('.form-layout .form-control').on('focusin', function() {
                $(this).closest('.form-group').addClass('form-group-active');
            });

            $('.form-layout .form-control').on('focusout', function() {
                $(this).closest('.form-group').removeClass('form-group-active');
            });




            $('#select_unidad').change(function() {
              consultar_salas();
            });

        }); //strict function

        let salas = [];

        function consultar_salas(){
          $.ajax({
            type: 'POST',
            url: '/public/obtener_salas',
            data: {
                id_unidad_gestion: $('#select_unidad').val(),
            },
            success: function(response) {

                if (response.status == 100) {
                    console.log(response.response);
                    let usuarios = '';
                    let prendido = '';

                    let acordeones = [];
                    let acordeonescont = [];
                    let acordeonboxes = [];




                    $(response.response).each((index, menu_padre) => {

                        const {
                            id_inmueble,
                            nombre_inmueble,
                            salas
                        } = menu_padre;

                        let accordioncont = '';
                        let accordionboxes = ' ';
                        acordeonboxes = [];
                        let on = '';


                        $(salas).each((index_a, sala) => { //ACCIONES chkbox

                            const {
                                id_inmueble,
                                id_unidad_gestion,
                                id_unidad_sala,
                                id_sala,
                                nombre_inmueble,
                                nombre_sala,
                                valor
                            } = sala;

                            if (valor == 1) {
                                on = 'checked';
                            } else if (valor == 0) {
                                on = '';
                            }

                            accordionboxes = accordionboxes + `
                            <div class="col-sm-3 col-md-2 sala_${index} d-flex">
                              <div class="box-edit">
                                <span onclick="mostrarModalSala('edicion',${id_sala})"><i class="fas fa-edit tx-primary"></i></span>
                              </div>
                              <div>
                                <label class="ckbox permiso">
                                  <input type="checkbox" name="accion" id="${id_unidad_sala}" data-id="${id_unidad_sala}" data-unidad="${id_unidad_gestion}" class="accion" ${on}><span>${nombre_sala ?? ""}</span>
                                </label>
                              </div>
                            </div>`;
                            acordeonboxes[index] = accordionboxes;

                        }); //FIN ACCIONES



                        accordioncont = accordioncont + `
                        <div id="accordion${index}" class="accordion-one mg-b-5" role="tablist" aria-multiselectable="true">
                          <div class="card">

                            <div class="card-header" role="tab" id="headingOne">
                              <div class="row">
                                <div class="col-7 col-permiso">
                                  <strong> <label style="color:black">${nombre_inmueble ?? "Sin datos aún"} </label></strong>
                                </div>
                                <div class="col-5 acciones textSalas" align="left">
                                  <a data-toggle="collapse" data-parent="#accordion${index}" href="#collapseOne${id_inmueble}" aria-expanded="false" aria-controls="collapseOne" class="tx-gray-800 transition collapsed">
                                      <label style="color:#444">Salas</label>
                                  </a>
                                  <label class="selected_all" onclick="selectedAll('${index}')" >Todas</label>
                                </div>
                              </div>
                            </div><!-- card-header -->

                            <div id="collapseOne${id_inmueble}" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                              <div class="card-body">
                                <div class="row">
                                  ${acordeonboxes[index] ?? " "}
                                </div>
                              </div>
                            </div>
                          </div>
                        </div><!-- accordion --> `;
                        acordeonescont[index] = accordioncont;

                        acordeones = acordeones.concat(accordioncont);

                    });

                    $('#acordeondiv').html(acordeones);

                } else {
                    console.log("BAD REQUEST");
                }
            }
          });
        }

        $('#acordeondiv').on('change', '.accion', async function () {

          salas = [];

          const sala = {
            valor : $(this).is(':checked') == true ? 1 : 0,
            id_unidad_sala : $(this).data("id"),
            unidad_gestion : $(this).attr('data-unidad'),
          }

          salas.push(sala);

          if( await guardarModificacionSalas() == 100 )
            $(this).parent().find('span').append(' <i class="fa fa-check tx-success response_sala" aria-hidden="true"></i>');
          else
            $(this).parent().find('span').append(' <i class="fa fa-times tx-danger response_sala" aria-hidden="true"></i>');

          setTimeout( () => {
            $(this).parent().find('i').remove();
          }, 800);

        });

        function guardarModificacionSalas() {

            return new Promise( resolve => {

              $.ajax({
                  type: 'POST',
                  url: '/public/guardar_unidades_salas',
                  data: {
                      salas
                  },
                  success: function(response) {
                      resolve(response.status);
                  }
              });
            });
        };

        async function selectedAll(sala){
          let todos = false;
          $('.sala_'+sala+' .accion').each(function(){
            if($(this).prop('checked')){
              todos = true;
            }else{
              todos = false;
            }
          });

          if(todos){

            $('.sala_'+sala+' .accion').each( function(){

              $(this).prop('checked', false);
              const sala = {
                valor : 0,
                id_unidad_sala : $(this).data("id"),
                unidad_gestion : $(this).attr('data-unidad'),
              }
              salas.push(sala);

            });

          }else{

            $('.sala_'+sala+' .accion').each( function(){

              $(this).prop('checked', true);
              const sala = {
                valor : 1,
                id_unidad_sala : $(this).data("id"),
                unidad_gestion : $(this).attr('data-unidad'),
              }
              salas.push(sala);
            });

          }

          if( await guardarModificacionSalas() == 100 )
            $('.sala_'+sala+' .accion').parent().find('span').append(' <i class="fa fa-check tx-success response_sala" aria-hidden="true"></i>');
          else
            $('.sala_'+sala+' .accion').parent().find('span').append(' <i class="fa fa-times tx-danger response_sala" aria-hidden="true"></i>');

          setTimeout( () => {
            $('.response_sala').remove();
          }, 800);

        }

        function mostrarModalSala( modo , id_sala = null ){
          
          limpiarModalSala();

          if( modo == 'edicion') {

            $.ajax({
              type: 'POST',
              url: '/public/consulta_sala',
              data: { id_sala },
              success: function(response) {
                if( response.status == 100 ){

                  let sala = response.response[0];

                  $("#lbl-titulo-modalSala").text("Editando a "+ sala.nombre_sala );
                  $("#btn-borarSala").removeClass("d-none");
                  
                  $("#id_sala").val( sala.id_sala );
                  $("#inmueble").val( sala.id_inmueble ).trigger("change");
                  $("#codigo").val( sala.codigo );
                  $("#clave").val( sala.clave_sala );
                  $("#nombre_sala").val( sala.nombre_sala );
                  $("#url_rtmp").val( sala.rtmp );
                  $("#url_ws").val( sala.ws );

                  $("#btn-borrarSala").removeClass("d-none");

                }else{ 
                  return false;
                }
              }, 
              error: function(error) {
                console.log(error);
              }
            });

          }

          $("#modalSala").modal("show");
        }

        function limpiarModalSala(){
          $("#lbl-titulo-modalSala").text("Agregar Nueva Sala");
          $("#btn-borrarSala").addClass("d-none");
          $("#id_sala").val("-");
          $("#inmueble").val("-").trigger("change");
          $("#codigo").val("");
          $("#clave").val("");
          $("#nombre_sala").val("");
          $("#url_rtmp").val("");
          $("#url_ws").val("");
        }

        function guardarSala(){
          let id_sala = $("#id_sala").val();

          if( id_sala == "-" ){

            $.ajax({
              type: 'POST',
              url: '/public/nueva_sala',
              data: { 
                inmueble: $("#inmueble").val(),
                codigo: $("#codigo").val(),
                clave_sala: $("#clave").val(),
                nombre_sala: $("#nombre_sala").val(),
                url_rtmp: $("#url_rtmp").val(),
                url_ws: $("#url_ws").val(),
              },
              success: function(response) {
                if( response.status == 100 ){
                  mostrar_mensaje("success","Sala guardada correctamente",3);
                  if( $('#select_unidad').val() != "" && $('#select_unidad').val() != null ) consultar_salas();
                }else{ 
                  mostrar_mensaje("error",response.message,3);
                }
              }, 
              error: function(error) {
                console.log(error);
              }
            });

          }else{

            $.ajax({
              type: 'POST',
              url: '/public/actualiza_sala',
              data: { 
                id_sala: $("#id_sala").val(),
                inmueble: $("#inmueble").val(),
                codigo: $("#codigo").val(),
                clave_sala: $("#clave").val(),
                nombre_sala: $("#nombre_sala").val(),
                url_rtmp: $("#url_rtmp").val(),
                url_ws: $("#url_ws").val(),
              },
              success: function(response) {
                if( response.status == 100 ){
                  mostrar_mensaje("success","Sala actualizada correctamente",3);
                  consultar_salas();
                }else{ 
                  mostrar_mensaje("error",response.message,3);
                }
              }, 
              error: function(error) {
                console.log(error);
              }
            });

          }
        }

        function borrarSala(){

          let id_sala = $("#id_sala").val();

          $.ajax({
            type: 'POST',
            url: '/public/actualiza_sala',
            data: { 
              id_sala: $("#id_sala").val(),
              estatus: "0",
            },
            success: function(response) {
              if( response.status == 100 ){
                mostrar_mensaje("success","Sala eliminada correctamente",3);
                consultar_salas();
              }else{ 
                mostrar_mensaje("error",response.message,3);
              }
            }, 
            error: function(error) {
              console.log(error);
            }
          });

        }

        function mostrar_mensaje( tipo , mensaje, segundos_muestra_mensaje = 5 ){
          
          let clase = 'alert alert-secondary';

          if( tipo == 'success' ) clase = 'success';
          else if( tipo == 'error' ) clase = 'danger';

          $("#mensaje").text(mensaje);
          $("#mensaje").addClass("alert-"+clase);
          $("#mensaje").attr("role",clase);
          $("#mensaje").parent().removeClass("d-none");

          if( tipo == 'success' ){ 
            console.log( "ocultar footre" );
            $("#modalSala-footer").attr("style","display: none !important");
          }

          setTimeout( function() { 
            $("#mensaje").parent().addClass("d-none");
            $("#mensaje").removeClass("alert-"+clase);

            if( tipo == "success" ){ 
              $("#modalSala").modal("hide");
              $("#modalSala-footer").attr("style","display: flex !important");
              $("#modalSala-footer").removeClass("d-none");
            }
          } , segundos_muestra_mensaje * 1000  );
        }

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

                    <p id="mensaje_sucess" class="mg-b-20 mg-x-20" style='color:black'>Activación de salas Correcta</p>

                    <button type="button" class="btn btn-sucess" style='color:black' data-dismiss="modal"
                        aria-label="Close">Cerrar</button>
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

                    <p id="mensaje_fail" class="mg-b-20 mg-x-20" style='color:red'>Activacion de sala Incorrecta</p>

                    <button type="button" class="btn btn-danger pd-x-25" data-dismiss="modal"
                        aria-label="Close">Cerrar</button>
                </div><!-- modal-body -->
            </div><!-- modal-content -->
        </div><!-- modal-dialog -->
    </div><!-- modal -->

    <div id="modalSala" class="modal fade"  data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog xl" role="document">
        <div class="modal-content tx-size-sm">
          <div class="modal-header pd-x-20 d-flex justify-content-between">
            <div class="p-2">
              <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"><div id="estado_carpeta"></div><span id="lbl-titulo-modalSala"></span></h6>
            </div>
            
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="limpiarModalSala()">
              <span aria-hidden="true">&times;</span>
            </button>
          </div> <!-- HEADER -->

          <div class="modal-body pd-y-20 pd-x-20">
            
            <div class="row">

              <input type="hidden" class="form-control" id="id_sala" name="id_sala" value="">
              
              <div class="col-lg-12">
                <div class="form-group">
                  <label class="form-control-label">Inmueble: <span class="tx-danger">*</span></label>
                  <select class="form-control select2" id="inmueble" name="inmueble">
                    <option value="-">Elija una opción</option>
                    @foreach ($inmuebles['response'] as $inmueble)
                      <option value="{{ $inmueble['id_inmueble'] }}">{{ $inmueble['nombre_inmueble'] }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label">Codigo: <span class="tx-danger">*</span></label>
                  <input type="text" class="form-control" id="codigo" name="codigo" autocomplete="off">
                </div>
              </div>
              
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label">Clave: <span class="tx-danger">*</span></label>
                  <input type="text" class="form-control" id="clave" name="clave" autocomplete="off">
                </div>
              </div>
              
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label">Nombre: <span class="tx-danger">*</span></label>
                  <input type="text" class="form-control" id="nombre_sala" name="nombre_sala" autocomplete="off">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label">URL Streaming: <span class="tx-danger">*</span></label>
                  <input type="text" class="form-control" id="url_rtmp" name="url_rtmp" autocomplete="off">
                </div>
              </div>

              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label">URL Webservices: <span class="tx-danger">*</span></label>
                  <input type="text" class="form-control" id="url_ws" name="url_ws" autocomplete="off">
                </div>
              </div>
              
              
              <div class="col-lg-12 d-none">
                <div id="mensaje" class="alert " role="-">
                  Aquí mensaje de alerta
                </div>
              </div>

            </div>

          </div><!-- modal-body -->

          <div class="modal-footer d-flex justify-content-between" id="modalSala-footer" >
            <button type="button" class="btn btn-danger pd-x-25" data-dismiss="modal" aria-label="Close" onclick="limpiarModalSala()">Cancelar</button>
            <button type="button" class="btn btn-secondary pd-x-25 d-none" id="btn-borrarSala" onclick="borrarSala()">Borrar</button>
            <button type="button" class="btn btn-primary pd-x-25" onclick="guardarSala()">Guardar</button>
          </div>
        </div><!-- modal-content -->
      </div><!-- modal-dialog -->
    </div><!-- modal -->

@endsection
