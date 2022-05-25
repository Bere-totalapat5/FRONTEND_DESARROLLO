@php
  use App\Http\Controllers\clases\humanRelativeDate;
  use App\Http\Controllers\clases\utilidades;
  $humanRelativeDate = new humanRelativeDate();
@endphp

@extends('layouts.index')

@section('contenido-pageheader')
 <ol class="breadcrumb slim-breadcrumb">
    <li class="breadcrumb-item"><a href="#">Sustituciones</a></li>
    <li class="breadcrumb-item"><a href="#">Sustituciones de Jueces</a></li>
 </ol>
 <h6 class="slim-pagetitle">Sustituciones de Jueces</h6>
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
                            <div id='calendar'></div>
                    </div>

                    <div class="dropdown">
                        <div class="dropdown-content">
                          <p>Click a calendar date to invoke a Bootstrap Modal Box.</p>
                          <p>Add event title/description, start date, and end date.</p>
                          <p>Click "Save" to save event.</p>
                          <p>Click event again to re-open in Bootstrap Modal Box (Event is non-editable).
                            <p>
                              <p>Click "x" to delete event.</p>
                        </div>
                        <button class="fa dropbtn" style="font-size:24px; margin-left: 75%; color: black"><span>&#xf128;</span></button>
                      </div>

                      <div id='datepicker'></div>


@endsection




@section('seccion-estilos')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.6.0/main.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.6.0/main.min.css" />

    <link href="{{asset("/lib/datatables/css/jquery.dataTables.css")}}" rel="stylesheet">
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>

        <style>
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

            #modal-ver .modal-dialog {
                font-size: 18px;
                width: 100%;
                max-width:80%;
                height: 90%;
                margin: 0;
                padding: 1;
        }


        #modal-ver .modal-body {
            height: 95%;
            min-width: 90%;
        }

         #modal-ver .modal-content {
            height: 95%;
            min-width: 90%;
        }

        #documentoPDFrame {
                                min-height: 395px;
                                min-width: 100%;

                            }




            table{
                width: calc(100% - 2px) !important;
                border-bottom: 1px solid #f0f2f7;
            }

            td, th{
                padding-left: 1px !important;
                padding-right: 3px !important;
                padding-top: 0px;
                padding-bottom: px !important;
                border-bottom: 1px solid #f0f2f7;
                max-width: 110px !important;
                font-size: 16px;
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


                    #calendar {
                    max-width: 1100px;
                    margin: 40px auto;
                    }
                    body {
                            margin: 40px 10px;
                            padding: 0;
                            font-family: "Lucida Grande", Helvetica, Arial, Verdana, sans-serif;
                            font-size: 14px;
                            }

                            #calendar {
                            width: 900px;
                            margin: 0 auto;
                            }

                            #wrap {
                            width: 1100px;
                            margin: 0 auto;
                            }

                            .closeon {
                            border-radius: 5px;
                            }

                            input {
                            width: 50%;
                            }

                            input[type="text"][readonly] {
                            border: 2px solid rgba(0, 0, 0, 0);
                            }

                            /*info btn*/
                            .dropbtn {
                            /*background-color: #4CAF50;*/
                            background-color: #eee;
                            margin: 10px;
                            padding: 8px 16px 8px 16px;
                            font-size: 16px;
                            border: none;
                            }

                            .dropdown {
                            position: relative;
                            display: inline-block;
                            }

                            .dropdown-content {
                            display: none;
                            position: absolute;
                            background-color: #f1f1f1;
                            min-width: 200px;
                            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
                            z-index: 1;
                            margin-left: 100px;
                            margin-top: -300px;
                            }

                            .dropdown-content p {
                            color: black;
                            padding: 4px 4px;
                            text-decoration: none;
                            display: block;
                            }

                            .dropdown-content a:hover {
                            background-color: #ddd;
                            }

                            .dropdown:hover .dropdown-content {
                            display: block;
                            }

                            .dropdown:hover .dropbtn {
                            background-color: grey;
                            }

                            .dropdown:hover .dropbtn span {
                            color: white;
                            }

                            .ui-datepicker{
                            z-index: 55555 !important;
                            }

                            #ui-datepicker-div{
                                z-index: 55555 !important;
                                }

    </style>
@endsection

@section('seccion-scripts-libs')

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.6.0/main.js"></script>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.6.0/main.min.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/jquery-ui/js/jquery-ui.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/datatables/js/jquery.dataTables.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/datatables-responsive/js/dataTables.responsive.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/select2/js/select2.min.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/moment/js/moment.js"></script>
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
     <script src="https://cdn.datatables.net/colreorder/1.5.3/js/dataTables.colReorder.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.6.0/locales/es.js"></script>



     @endsection

@section('seccion-scripts-functions')
 <script>

    let solicitudes=[];
    let tabla_direcciones=[];
    let tabla_alias=[];
    let tabla_contacto=[];
    let tabla_correo=[];

    let tabla_datos=[];
    let tabla_delitos=[];
    let tabla_no_relacionados=[];
    let calendar;

    document.addEventListener('DOMContentLoaded', function() {

            var calendarEl = document.getElementById('calendar');
            calendar = new FullCalendar.Calendar(calendarEl, {

                monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
        monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
        dayNames: ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],
        dayNamesShort: ['Dom','Lun','Mar','Mié','Jue','Vie','Sáb'],
            initialView: 'dayGridMonth',
            buttonText: {
                    today: 'Hoy',
                    month: 'Mes',
                    agendaWeek: 'Semana',
                    agendaDay: 'Dia'
                },
                navLinks: true,
        editable: true,
        selectable:true,
        events: <?php echo json_encode($eventos); ?>,

            //When u select some space in the calendar do the following:
            select: function (start, end) {
                $("#createEventModal").modal("show");
                        $("#createEventModal")
                            .find("#title")
                            .val("");
                        $("#createEventModal")
                            .find("#starts-at")
                            .val("");
                        $("#createEventModal")
                            .find("#ends-at")
                            .val("");
                        $("#save-event").show();
                        $("input").prop("readonly", false);
                //do something when space selected
                //Show 'add event' modal
               // $('#createEventModal').modal('show');
               $("#startsat").datepicker();
                    $("#ends-at").datepicker();
            },

            //When u drop an event in the calendar do the following:
            eventDrop: function (event, delta, revertFunc) {
                //do something when event is dropped at a new location
            },

            //When u resize an event in the calendar do the following:
            eventResize: function (event, delta, revertFunc) {
                //do something when event is resized
            },

          /*   eventRender: function(event, element) {
                $(element).tooltip({title: event.title});
            }, */

            //Activating modal for 'when an event is clicked'
            eventClick: function(calEvent, jsEvent) {
                    // Display the modal and set event values.
                    $("#createEventModal").modal("show");
                    $("#createEventModal")
                        .find("#title")
                        .val(calEvent.title);
                    $("#createEventModal")
                        .find("#starts-at")
                        .val(calEvent.start);
                    $("#createEventModal")
                        .find("#ends-at")
                        .val(calEvent.end);
                    $("#save-event").hide();
                    $("input").prop("readonly", true);
                    },




            });
            calendar.render();

            $("#save-event").on("click", function(event) {
                var title = $("#title").val();
                if (title) {
                var eventData = {
                    title: title,
                    start: $("#starts-at").val(),
                    end: $("#ends-at").val()
                };
                $("#calendar").fullCalendar("renderEvent", eventData, true); // stick? = true
                }
               // $("#calendar").fullCalendar("unselect");

                // Clear modal inputs
                $("#createEventModal")
                .find("input")
                .val("");
                // hide modal
                $("#createEventModal").modal("hide");
            });

        });





    $(function(){
        'use strict';





     // Select2
     $('.select2').select2({
        minimumResultsForSearch: Infinity
    });



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

    //focus textfiled
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







function cerrar_modal(valor){
$("#"+valor).modal('hide');
$('body').removeClass('modal-open');

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
                                <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Documentos Relacionados</a>
                                </div>
                            </nav>
                            <br>

                            <div class="tab-content" id="nav-tabContent">

                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                    <table id="datosolicitud" class="dataTables"> </table>
                                    <br>
                                    <table id="datosolicitudRes" class="dataTables"> </table>
                                </div>

                                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">


                                              <div class="accordion" id="acordeon" role="tablist"> </div>

{{--                                     <table id="datosparticipantes" class="dataTables"> </table>
 --}}
                               </div>

                                <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">


                                    <div id="documentos-relacionados" class="container">
                                    </div>

                                                    <iframe src="" id="documentoPDFrame"></iframe>



                                </div>
                            </div>
                        </div>

                 <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>

              </div>
            </div><!-- modal-dialog -->
        </div><!-- modal -->

{{-- SIN DATOS --}}

        <div id="modalFail" class="modal fade">
            <div class="modal-dialog" role="document">
              <div class="modal-content tx-size-sm">
                <div class="modal-body tx-center pd-y-20 pd-x-20">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <i class="icon ion-ios-close-outline tx-100 color='#848F33' lh-1 mg-t-20 d-inline-block"></i>
                  <h4 class=" tx-semibold style='color:red' mg-b-20">Ohhhh!</h4>
                  <p class="mg-b-20 mg-x-20">No existe documento relacionado.</p>
                  <button type="button" class="btn btn-danger pd-x-25" data-dismiss="modal" aria-label="Close" >Cerrar</button>
                </div><!-- modal-body -->
              </div><!-- modal-content -->
            </div><!-- modal-dialog -->
          </div><!-- modal -->

          <div id="modalFailTurnado" class="modal fade">
            <div class="modal-dialog" role="document">
              <div class="modal-content tx-size-sm">
                <div class="modal-body tx-center pd-y-20 pd-x-20">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <i class="icon ion-ios-close-outline tx-100 style='color:red' lh-1 mg-t-20 d-inline-block"></i>
                  <h4 class=" tx-semibold style='color:red' mg-b-20">Ohhhh!</h4>
                  <p class="mg-b-20 mg-x-20">La solicitud ya dispone con una Carpeta Judicial Asignada</p>
                  <button type="button" class="btn btn-danger pd-x-25" data-dismiss="modal" aria-label="Close" >Cerrar</button>
                </div><!-- modal-body -->
              </div><!-- modal-content -->
            </div><!-- modal-dialog -->
          </div><!-- modal -->

          <div id="modalOkTurnado" class="modal fade">
            <div class="modal-dialog" role="document">
              <div class="modal-content tx-size-sm">
                <div class="modal-body tx-center pd-y-20 pd-x-20">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <i class="icon ion-ios-checkmark-circle-outline tx-100 color='#848F33' lh-1 mg-t-20 d-inline-block"></i>
                  <h4 class=" tx-semibold style='color:green' mg-b-20" style='color:green'>Proceso Concluido!</h4>

                  <p id="carpetaAsignada" color='green'  class="mg-b-20 mg-x-20">Carpeta Judicial Asignada</p>

                  <button type="button" class="btn btn-sucess pd-x-25" data-dismiss="modal" aria-label="Close" >Cerrar</button>
                </div><!-- modal-body -->
              </div><!-- modal-content -->
            </div><!-- modal-dialog -->
          </div><!-- modal -->

          <div id="createEventModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4><input class="modal-title" type="text" name="title" id="title" placeholder="Event Title/Description" /></h4>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-xs-12">
                        <label class="col-xs-4" for="starts-at">Periodo del</label>
                        <input type="text" class="form-control fc-datepicker" placeholder="DD-MM-AAAA" name="starts_at" id="starts-at" />
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-12">
                        <label class="col-xs-4" for="ends-at">Al</label>
                        <input type="text" class="form-control fc-datepicker" placeholder="DD-MM-AAAA" name="ends_at" id="ends-at" />
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="save-event">Save</button>
                  </div>
                </div>
                <!-- /.modal-content -->
              </div>
            </div>



@endsection
