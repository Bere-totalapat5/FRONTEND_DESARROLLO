@php
  use App\Http\Controllers\clases\humanRelativeDate;
  use App\Http\Controllers\clases\utilidades;
  $humanRelativeDate = new humanRelativeDate();
@endphp
{{-- {{dd($sustituciones)}} --}}
@extends('layouts.index')

@section('contenido-pageheader')
 <ol class="breadcrumb slim-breadcrumb">
    <li class="breadcrumb-item"><a href="#">Incidencias</a></li>
    <li class="breadcrumb-item"><a href="#">Incidencias de Usuarios</a></li>
 </ol>
 <h6 class="slim-pagetitle">Incidencias de Usuarios</h6>
@endsection


@section('contenido-principal')
    <div class="section-wrapper" style="margin-bottom: 150px; height: 90vh;">
        <div id="scheduler_here" style='width:100%; height:100%;'></div>
        {{-- <div class="add_event_button" data-tooltip="Create new event"><span></span></div> --}}
    </div>
@endsection


@section('seccion-estilos')
<link rel="stylesheet" href="/box/scheduler/codebase/dhtmlxscheduler_material.css?v=5.3.8" type="text/css" charset="utf-8">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="/box/scheduler/samples/common/controls_styles.css?v=5.3.8">
<link href="{{ $entorno["version_pages"]["version"] }}/lib/jt.timepicker/css/jquery.timepicker.css" rel="stylesheet">
<link href="{{ $entorno["version_pages"]["version"] }}/lib/select2/css/select2.min.css" rel="stylesheet">

<style type="text/css" >
	
    ::-webkit-scrollbar {
        height: 8px;  
        width: 8px;
    }
    ::-webkit-scrollbar-thumb {
        background: #D7DCE1; 
    }
    ::-webkit-scrollbar-thumb:hover {
        background: #a8acaf; 
    }
    ::-webkit-scrollbar-track {
        background: #fff 
    }

	.add_event_button{
		position: absolute;
		width: 55px;
		height: 55px;
		background: #ff5722;
		border-radius: 50px;
		bottom: 40px;
		right: 55px;
		box-shadow: 0 2px 5px 0 rgba(0,0,0,0.3);
		z-index: 5;
		cursor:pointer;
	}
	.add_event_button:after{
		background: #000;
		border-radius: 2px;
		color: #FFF;
		content: attr(data-tooltip);
		margin: 16px 0 0 -137px;
		opacity: 0;
		padding: 4px 9px;
		position: absolute;
		visibility: visible;
		font-family: "Roboto";
		font-size: 14px;
		visibility: hidden;
		transition: all .5s ease-in-out;
	}
	.add_event_button:hover{
		background: #ff774c;
	}
	.add_event_button:hover:after{
		opacity: 0.55;
		visibility: visible;
	}
	.add_event_button span:before{
		content:"";
		background: #fff;
		height: 16px;
		width: 2px;
		position: absolute;
		left: 26px;
		top: 20px;
	}
	.add_event_button span:after{
		content:"";
		height: 2px;
		width: 16px;
		background: #fff;
		position: absolute;
		left: 19px;
		top: 27px;
	}

	@media only screen and (max-width: 1000px){
		.add_event_button{
			bottom: 5vw;
			right: 5vw;
		}
	}

    .dhx_cal_light.dhx_cal_light_wide.dhx_cal_light_rec.dhx_cal_light_responsive {
        top: 10em !important;
        z-index: 1031 !important;
    }

    /* .dhx_cal_light.dhx_cal_light_wide.dhx_cal_light_rec.dhx_cal_light_responsive{
        z-index: ;
    } */

    .dhx_cal_navline.dhx_cal_navline_flex .dhx_cal_tab {
        display: none;
    }

    .dhx_cal_event_line {
        background-color: #848F33 !important;
    }

    td {
        padding-left: -1px;
    }

    .select2-container.select2-container--default.select2-container--open{
        z-index: 1032;
    }
</style>
@endsection

@section('seccion-scripts-libs')

<script src="{{ $entorno["version_pages"]["version"] }}/lib/jt.timepicker/js/jquery.timepicker.js"></script>
<script src="{{ $entorno["version_pages"]["version"] }}/lib/select2/js/select2.min.js"></script>
<script src="/box/scheduler/codebase/dhtmlxscheduler.js?v=5.3.8" charset="utf-8"></script>
<script src="/box/scheduler/codebase/ext/dhtmlxscheduler_multiselect.js?v=5.3.8"></script>	
<script src="/box/scheduler/codebase/ext/dhtmlxscheduler_editors.js?v=5.3.8"></script>
<script src="/box/scheduler/codebase/ext/dhtmlxscheduler_recurring.js?v=5.3.8" charset="utf-8"></script>
<script src="/box/scheduler/codebase/ext/dhtmlxscheduler_quick_info.js?v=5.3.8" charset="utf-8"></script>
<script src="/box/scheduler/codebase/locale/locale_es.js?v=5.3.13" type="text/javascript" charset="utf-8"></script>

 @endsection

@section('seccion-scripts-functions')
 
<script>

    let sustituciones = [];

    $(document).ready( () => {
        cargarSustituciones();
        setTimeout(function () {
            $('#modal_loading').modal('hide');
        },600);

    });

	window.addEventListener("DOMContentLoaded", function(){
        
		// different configs for different screen sizes
		var compactView = {
			xy: {
				nav_height: 80
			},
			config: {
				header: {
					rows: [
						{ 
							cols: [
								"prev",
								"date",
								"next",
							]
						},
						{ 
							cols: [
								"day",
								"week",
								"month",
								"spacer",
								"today"
							]
						}
					]
				}
			},
			templates: {
				month_scale_date: scheduler.date.date_to_str("%D"),
				week_scale_date: scheduler.date.date_to_str("%D, %j"),
				event_bar_date: function(start,end,ev) {
					return "";
				}
				
			}
		};
		var fullView = {
			xy: {
				nav_height: 80
			},
			config: {
				header: [
					"day",
					"week",
					"month",
					"date",
					"prev",
					"today",
					"next"
				]
			},
			templates: {
				month_scale_date: scheduler.date.date_to_str("%l"),
				week_scale_date: scheduler.date.date_to_str("%l, %F %j"),
				event_bar_date: function(start,end,ev) {
					return "• <b>"+scheduler.templates.event_date(start)+"</b> ";
				}
			}
		};

        var ugas_opts = [
            { "key" : "", "label":"Seleccione una opción",},
        @isset($unidades['response'])
                @foreach ($unidades['response'] as $unidad)
                    { key: "{{$unidad['id_unidad_gestion']}}" ,  label:"{{$unidad['nombre_unidad']}}"},
                @endforeach
            @endisset
        ];


        var parent_onchange = function( event ) {

            var arrGuardias = [];

			$.ajax({
                url:'/public/obtener_usuarios_sustitucion',
                type: "POST",
               async: true,
                data: {id_unidad_gestion:this.value},
                success : function(response){


                    arrGuardias.push({
                        "key":"",
                        "label":"Seleccione una opción",
                    });

                    $(response.response).each(function(index, incidencia) {

                        var datosGuardia = "";
                        const {id_usuario, usuario, nombres, apellido_paterno, apellido_materno } = incidencia;

                        datosGuardia = {
                            "key":id_usuario,
                            "label":usuario+" "+nombres+" "+apellido_paterno,
                        }
                        arrGuardias.push(datosGuardia);
                    });

                	new_child_options = arrGuardias;
                    update_select_options(scheduler.formSection('Usuario').control, new_child_options);
                    update_select_options(scheduler.formSection('Reemplazo').control, new_child_options);

                }
            });

			//update_select_options(scheduler.serverList('projectos').control, new_child_options);
		};


        var update_select_options = function(select, options) { // helper function
			select.options.length = 0;
			for (var i=0; i<options.length; i++) {
				var option = options[i];
				select[i] = new Option(option.label, option.key);
			}
		};


		function resetConfig(){
			var settings;
			if(window.innerWidth < 1000){
				settings = compactView;
			}else{
				settings = fullView;
			
			}
			scheduler.utils.mixin(scheduler.config, settings.config, true);
			scheduler.utils.mixin(scheduler.templates, settings.templates, true);
			scheduler.utils.mixin(scheduler.xy, settings.xy, true);
			return true;
		}

		scheduler.config.responsive_lightbox = true;
		resetConfig();
        scheduler.config.drag_move = false;
		scheduler.attachEvent("onBeforeViewChange", resetConfig);
		scheduler.attachEvent("onSchedulerResize", resetConfig);
        scheduler.locale.labels.workweek_tab = false;
		scheduler.locale.labels.decade_tab = false;

		scheduler.config.lightbox.sections = [
            { name:"Unidad de Gestión", height:40, map_to:"id_unidad_gestion", type:"select", options:ugas_opts, onchange:parent_onchange },
            { name:"Usuario", height:40, map_to:"juez_titular", type:"select", options:scheduler.serverList("Usuario")},
            { name:"Reemplazo", height:40, map_to:"juez_sustituye", type:"select",options:scheduler.serverList("Reemplazo")},
            { name:"Motivo", height:200, map_to:"descripcion", type:"textarea" , focus:true},
            { name:"Periodo", height:72, type:"time", map_to:"auto"}
        ];


		scheduler.init('scheduler_here',new Date(),"month");
        
		// scheduler.load("../common/events.json");

		// document.querySelector(".add_event_button").addEventListener("click", function(){
		// 	scheduler.addEventNow();
		// });
	});

    scheduler.attachEvent("onEventSave",function(id,ev) {

        console.log(ev);

        if (!ev.id_unidad_gestion) {
            alert("Falta elegir la unidad");
            return false;   
        }

        if (!ev.juez_titular || ev.juez_titular == '' ) {
            alert("Falta elegir al usuario titular");
            return false;   
        }

        if (!ev.juez_sustituye || ev.juez_sustituye == '' ) {
            alert("Falta elegir al usuario que sustituye al titular");
            return false;   
        }

        if (!ev.descripcion) {
            alert("La descripcion no puede estar vacia");
            return false;   
        }


        
        const evento_existente = sustituciones.filter( evento => evento.id_sustitucion == id);
        var formatFunc = scheduler.date.date_to_str("%Y-%m-%d %H:%i:%s");
        var start_date = formatFunc(ev.start_date);
        var end_date = formatFunc(ev.end_date);

        const data = {
            id_usuario_titular: ev.juez_titular,
            id_usuario_sustituye: ev.juez_sustituye,
            id_unidad_gestion: ev.id_unidad_gestion,
            descripcion: ev.descripcion,
            fecha_ini: start_date,
            fecha_fin: end_date,
        };
        
        if( evento_existente.length ) {

            data.id_sustitucion = id;
            editaSustitucion( data );

        } else {
            
            registraSustitucion( data );

        }

        return true;

    });

    scheduler.attachEvent("onDblClick", function (id, ev){ return false; });

    scheduler.attachEvent("onBeforeTaskDrag", function (id, ev){
        alert('hi');
        return false;
        $('.dhx_qi_big_icon.icon_details').attr('onclick', `pintaCampos(${id})`);
        $('.dhx_qi_big_icon.icon_delete').attr('onclick', `confirmaEliminacion(${id})`);
        
        return true;

    })

    scheduler.attachEvent("onClick", function (id, ev){
        
        $('.dhx_qi_big_icon.icon_details').attr('onclick', `pintaCampos(${id})`);
        $('.dhx_qi_big_icon.icon_delete').attr('onclick', `confirmaEliminacion(${id})`);
        
        
        
        return true;

    });

    function confirmaEliminacion( id ) {
        
        setTimeout( () => {
            $('.dhtmlx_popup_text').html( "La sustitución se eliminará definitivamente, ¿Desea continuar?");
            $('.dhtmlx_popup_button.dhtmlx_ok_button').attr('onclick', `eliminarSustitucion(${id})`);
            
            const btnOk = $('.dhtmlx_popup_controls').find('div')[1];
            const btnCancel = $('.dhtmlx_popup_controls').find('div')[3];

            $(btnOk).html('Aceptar')
            $(btnCancel).html('Cancelar');

        },100);
    }

    function eliminarSustitucion( id ) {

        const data = { 
            id_sustitucion: id,
            estatus: 0
        }

        editaSustitucion( data )

    }

    function cargarSustituciones() { 
        
        sustituciones = [];
        scheduler.clearAll();
        
        $.ajax({
            method: 'GET',
            url: '/public/obtener_sustituciones',
            data: {},
            success: function (response ) {
                if( response.status == 100 ) {

                    sustituciones = response.response;

                    $( response.response ).each( function( i, evento ) {
                        
                        const { id_sustitucion, fecha_inicio, fecha_fin, usuario_titular, nombre_usuario_titular, usuario_sustituye, nombre_usuario_sustituye, descripcion, nombre_unidad } = evento;

                        scheduler.addEvent({
                            id: id_sustitucion,
                            start_date: fecha_inicio,
                            end_date: fecha_fin,
                            text: "(" + usuario_titular + ")" + nombre_usuario_titular + " es sustituido por (" + usuario_sustituye + ") " + nombre_usuario_sustituye, 
                            descripcion: descripcion,
                            unidad: nombre_unidad,
                        });

                    }); 

                }
            }
        });
    }

    function registraSustitucion( data ) {

        $('#modal_loading').modal('show');
        console.log('pasa a registrar');
        $.ajax({
            type:'POST',
            url:'/public/registrar_sustitucion',
            data:data,
            success:function(response){
    
                if(response.status==100){

                    $('#datos-respuesta-solicitud').html(`${response.response }`);
                    $('#modalSuccess').modal('show');
                
                }else {

                    $('#messageError').html(`${response.message} `);
                    $('#modalError').modal('show');
                }

                setTimeout( () => {
                    $('#modal_loading').modal('hide');
                },600);

                cargarSustituciones();
            }
        });
    }

    function editaSustitucion( data ) {
        
        $('#modal_loading').modal('show');

        console.log('pasa a editar');
        $('#modal_loading').modal('show');
        
        $.ajax({
            type:'POST',
            url:'/public/modifica_agenda_sustitucion',
            data:data,
            success:function(response){
    
                if(response.status==100){

                    $('#datos-respuesta-solicitud').html(`${response.response }`);
                    $('#modalSuccess').modal('show');
                
                }else {

                    $('#messageError').html(`${response.message} `);
                    $('#modalError').modal('show');
                }

                setTimeout( () => {
                    $('#modal_loading').modal('hide');
                },600);

                cargarSustituciones();
            }
        });

        setTimeout( () => {
            $('#modal_loading').modal('hide');
        },400);

    }

    function pintaCampos( id ) {

        const obj_evento = scheduler.getEvent(id),
            sustitucion_evento = sustituciones.filter( sustitucion => sustitucion.id_sustitucion == obj_evento.id );

        const { id_unidad_gestion, id_usuario_titular, id_usuario_sustituye} = sustitucion_evento[0];

        pintaUsuarios(id_unidad_gestion, id_usuario_titular, id_usuario_sustituye);

        setTimeout( () => {
                    $('.dhx_delete_btn_set').attr('onclick', `confirmaEliminacion(${id})`);
                },2000);
        
    }



    function pintaUsuarios( id_unidad_gestion, id_titular = '', id_sustituye = '' ) {
        
        var arrGuardias = [];

        $.ajax({
            url:'/public/obtener_usuarios_sustitucion',
            type: "POST",
            async: true,
            data: {id_unidad_gestion:id_unidad_gestion},
            success : function(response){

                arrGuardias.push({
                    "key":"",
                    "label":"Seleccione una opción",
                });

                $(response.response).each(function(index, incidencia) {

                    var datosGuardia = "";
                    const {id_usuario, usuario, nombres, apellido_paterno, apellido_materno } = incidencia;

                    datosGuardia = {
                        "key":id_usuario,
                        "label":usuario+" "+nombres+" "+apellido_paterno,
                    }
                    arrGuardias.push(datosGuardia);
                });

                new_child_options = arrGuardias;
                updateSelectOptions(scheduler.formSection('Usuario').control, new_child_options);
                updateSelectOptions(scheduler.formSection('Reemplazo').control, new_child_options);

                scheduler.formSection('Unidad de Gestión').setValue(id_unidad_gestion);
                scheduler.formSection('Usuario').setValue(id_titular);
                scheduler.formSection('Reemplazo').setValue(id_sustituye);

            }
        });

        //update_select_options(scheduler.serverList('projectos').control, new_child_options);
    };

    function updateSelectOptions(select, options) { // helper function
			select.options.length = 0;
			for (var i=0; i<options.length; i++) {
				var option = options[i];
				select[i] = new Option(option.label, option.key);
			}
	};
</script>
@endsection



@section('seccion-modales')


{{-- SIN DATOS --}}






          <div id="createEventModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header pd-x-20">
                    <h4>Seleccione los datos</h4>
                    <button type="button" class="close ml-auto"  data-dismiss="modal" aria-label="Close">
                                <span  aling="right" aria-hidden="true">&times;</span>
                            </button>                  </div>
                  <div class="modal-body">




                    <div class="col-lg-12" >
            <div class="form-group">
              <label class="form-control-label">Periodo del <span class="tx-danger">*</span></label>
              <input type="text" class="form-control fc-datepicker" placeholder="DD-MM-AAAA" value="" name="starts_at" id="starts-at" />
            </div>
          </div><!-- col-9 -->

          <!--
                   <div class="row">
                      <div class="col-xs-12">
                        <label class="col-xs-4" for="ends-at">Al</label>
                        <input type="text" class="form-control fc-datepicker" placeholder="DD-MM-AAAA" value="" name="ends_at" id="ends-at" />
                      </div>
                    </div> modal -->

                    <div class="col-lg-12" >
            <div class="form-group">
              <label class="form-control-label">Periodo del <span class="tx-danger">*</span></label>
              <input type="text" class="form-control fc-datepicker" placeholder="DD-MM-AAAA" name="ends_at" id="ends-at" />
            </div>
          </div><!-- col-9 -->


                    <div class="col-lg-12" >
            <div class="form-group">
              <label class="form-control-label">Juez a Sustituir <span class="tx-danger">*</span></label>
              <select class="form-control select2-show-search valid"  id="juezSustituir" name="sustituir" autocomplete="off">
                <option selected disabled value="">Elija una opción</option>

                </select>
            </div>
          </div><!-- col-9 -->

          <div class="col-lg-12" >
            <div class="form-group">
              <label class="form-control-label">Juez Sustituto <span class="tx-danger">*</span></label>
              <select class="form-control select2-show-search valid"  id="juezSustituto" name="sustituto" autocomplete="off">
                <option selected disabled value="">Elija una opción</option>

                </select>
            </div>
          </div><!-- col-9 -->



                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="save-event">Save</button>
                  </div>
                </div>
                <!-- /.modal-content -->
              </div>
            </div>






            <div id="modalSuccess" class="modal fade"  data-backdrop="static" data-keyboard="false" style="display: none">
                <div class="modal-dialog" role="document">
                <div class="modal-content tx-size-sm">
                    <div class="modal-body tx-center pd-y-20 pd-x-20">
                    <i class="icon ion-ios-checkmark-outline tx-100 tx-success lh-1 mg-t-20 d-inline-block"></i>
                    <h4 class="tx-success tx-semibold mg-b-20">Hecho!</h4>
                    <div id="datos-respuesta-solicitud">

                            </div>
                    </div><!-- modal-body -->
                    <div class="modal-footer d-flex">
                    <button type="button" class="btn btn-primary pd-x-25 mg-l-auto" data-dismiss="modal" aria-label="Close" >Aceptar</button>
                    </div>
                </div><!-- modal-content -->
                </div><!-- modal-dialog -->
            </div>




            <div id="modalError" class="modal fade" aria-hidden="true" style="display: none;">
                <div class="modal-dialog" role="document">
                  <div class="modal-content tx-size-sm">
                    <div class="modal-body tx-center pd-y-20 pd-x-20">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>
                      <i class="icon icon ion-ios-close-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
                      <p class="mg-b-20 mg-x-20" id="messageError"></p>
                      <button type="button" class="btn btn-danger pd-x-25" data-dismiss="modal" aria-label="Close">Aceptar</button>
                    </div><!-- modal-body -->
                  </div><!-- modal-content -->
                </div><!-- modal-dialog -->
              </div>


            <div id="modalSuccessModifica" class="modal fade"  data-backdrop="static" data-keyboard="false" >
                <div class="modal-dialog" role="document">
                <div class="modal-content tx-size-sm">
                    <div class="modal-body tx-center pd-y-20 pd-x-20">
                    <i class="icon ion-ios-checkmark-outline tx-100 tx-success lh-1 mg-t-20 d-inline-block"></i>
                    <h4 class="tx-success tx-semibold mg-b-20">Hecho!</h4>
                    <div id="datos-respuesta-modifica">

                            </div>
                    </div><!-- modal-body -->
                    <div class="modal-footer d-flex">
                    <button type="button" class="btn btn-primary pd-x-25 mg-l-auto" data-dismiss="modal" aria-label="Close" >Aceptar</button>
                    </div>
                </div><!-- modal-content -->
                </div><!-- modal-dialog -->
            </div><!-- modal -->






            <div id="modalErrorModifica" class="modal fade"  data-backdrop="static" data-keyboard="false" >
                <div class="modal-dialog" role="document">
                <div class="modal-content tx-size-sm">
                    <div class="modal-header pd-x-20">
                    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"><span id="">Error</h6>
                    </div>
                    <div class="modal-body tx-center pd-y-20 pd-x-20">
                    <div id="datos-respuesta-modifica-error" align="center">

                    </div>
                    </div><!-- modal-body -->
                    <div class="modal-footer d-flex">
                    <button type="button" class="btn btn-primary pd-x-25 mg-l-auto" data-dismiss="modal" aria-label="Close" >Aceptar</button>
                    </div>
                </div><!-- modal-content -->
                </div><!-- modal-dialog -->
            </div><!-- modal -->

@endsection
