@php
    use App\Http\Controllers\clases\humanRelativeDate;
    $humanRelativeDate = new humanRelativeDate();
@endphp

@extends('layouts.index')
 
@section('contenido-pageheader')
    <ol class="breadcrumb slim-breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Agenda de Citas</li>
    </ol>
    <h6 class="slim-pagetitle">Agenda de Citas</h6>
@endsection


@section('contenido-principal')

        <div class="section-wrapper">
            <form method="POST" action="{{ route('agendas.guardar_agenda') }}" enctype="multipart/form-data">
                <input type="hidden" name="fecha_evento" id="fecha_evento" value="{{date('Y-m-d')}}">
                <input type="hidden" name="fecha_cita_hidden" id="fecha_cita_hidden" value="{{date('Y-m-d')}}">

                <div class="row">
                    <div class="col-lg-12 pd-b-20">
                        <h3 class="card-profile-name">Agenda de citas para consulta de expedientes</h3> 
                    </div> 
                
                    
                    <div class="col-lg-5"> 
                        <div id="cal_here" ></div>
                    </div>
                    

                    <div class="col-lg-7" >
                        
                        <div class="alert alert-info" role="alert">
                            <strong>Importante:</strong> Agenda de citas para consulta de expediente y tramites administrativos. 
                          </div><!-- alert -->

                          <p class="mg-b-0"><i class="fa fa-circle tx-primary mg-r-8"></i>Consulta de Expedientes</p>
                          <p class="mg-b-0"><i class="fa fa-circle tx-success mg-r-8"></i>Entrega y recepción de billetes de depósito y/o títulos de valor</p>
                          <p class="mg-b-0"><i class="fa fa-circle mg-r-8" style="color: #34efe8;"></i>Entrega de copias simples</p>
                          <p class="mg-b-0"><i class="fa fa-circle tx-danger mg-r-8"></i>Solicitud verbal o por comparecencia y entrega de copias simples</p>
                          <p class="mg-b-0"><i class="fa fa-circle tx-info mg-r-8"></i>Recepción de exhortos</p>
                          <p class="mg-b-0"><i class="fa fa-circle tx-indigo mg-r-8"></i>Recepción de Cartas Rogatorias</p>
                          <p class="mg-b-0"><i class="fa fa-circle mg-r-8" style="color: #8a9897;"></i>Recepción de oficios diversos</p>
                          <p class="mg-b-0"><i class="fa fa-circle tx-teal mg-r-8"></i>Recepción de copias certificadas</p>
                          <p class="mg-b-0"><i class="fa fa-circle tx-pink mg-r-8"></i>Comparecencias de ratificación de allanamientos, promociones o cualquier otra similar, ordenada por la Jueza o Juez respectivo</p>
                          <p class="mg-b-0"><i class="fa fa-circle tx-orange mg-r-8"></i>Citas para Notaria o Notario Público para la revisión o firma de escritura pública</p>
                    </div>

               

                </div> 
            </form>
        </div>
        <div class="sch_control">
            <div class="col-lg-12" id="alerta_warning">
                @isset ($arr_json['estatus'])
                    <div class="alert alert-danger" role="alert">

                        <strong>{{$arr_json['msj']}}</strong> 
                    </div><!-- alert -->
                @endisset
            </div>

            <div class="filters_wrapper" id="filters_wrapper">
                <span>Mostrar:</span>

                @if(($sesion['usuario_secretaria']==1 or $sesion['usuario_secretaria']=="") and $sesion['juzgado_tipo']=="sala")
                <label class="checked_label" id="scale1">
                    <input type="checkbox" class="sch_radio" name="1" value="1" checked/>
                    <i class="material-icons icon_color">check_box</i>Ponencia 1
                </label>
                @endif
                @if(($sesion['usuario_secretaria']==2 or $sesion['usuario_secretaria']=="") and $sesion['juzgado_tipo']=="sala")
                <label class="checked_label" id="scale1">
                    <input type="checkbox" class="sch_radio" name="2" value="1" checked/>
                    <i class="material-icons icon_color">check_box</i>Ponencia 2
                </label>
                @endif
                @if(($sesion['usuario_secretaria']==3 or $sesion['usuario_secretaria']=="") and $sesion['juzgado_tipo']=="sala")
                <label class="checked_label" id="scale1">
                    <input type="checkbox" class="sch_radio" name="3" value="1" checked/>
                    <i class="material-icons icon_color">check_box</i>Ponencia 3
                </label>
                @endif


                @if(($sesion['usuario_secretaria']=='A' or $sesion['usuario_secretaria']=="") and $sesion['juzgado_tipo']=="juzgado")
                <label class="checked_label" id="scale1">
                    <input type="checkbox" class="sch_radio" name="A" value="1" checked/>
                    <i class="material-icons icon_color">check_box</i>Secretaría A
                </label>
                @endif
                @if(($sesion['usuario_secretaria']=='B' or $sesion['usuario_secretaria']=="") and $sesion['juzgado_tipo']=="juzgado")
                <label class="checked_label" id="scale1">
                    <input type="checkbox" class="sch_radio" name="B" value="1" checked/>
                    <i class="material-icons icon_color">check_box</i>Secretaría B
                </label>
                @endif
                @if(($sesion['usuario_secretaria']=='C' or $sesion['usuario_secretaria']=="") and $sesion['juzgado_tipo']=="juzgado" and 0)
                <label class="checked_label" id="scale1">
                    <input type="checkbox" class="sch_radio" name="C" value="1" checked/>
                    <i class="material-icons icon_color">check_box</i>Secretaría C
                </label>
                @endif

                
            </div>
            <div ><a href="javascript:void(0);" onclick="openWindowWithPost()">Exportar a Excel</a></div>
        </div>
        <div id="hidden_info">
            @isset($arr_json[0])
                @foreach ($arr_json as $agenda)
                    @php
                    $estatus='No definido';
                    if($agenda['estatus']==2){
                        $estatus='Atendida';
                    }
                    else if($agenda['estatus']==3){
                        $estatus='Cancelada';
                    }
                    @endphp
                    
                    <input type="hidden" id="{{$agenda['folio']}}" value="<h4 class=\'tx-bold\'><small>Expediente</small><br>{{$agenda['expediente']}}</h4><br><h4 class=\'tx-bold\'><small>Tipo de trámite</small><br>{{$agenda['tramite']}}</h4><br><h4 class=\'tx-bold\'><small>Partes</small><br>{{$agenda['partes']}}</h4><br><h4 class=\'tx-bold\'><small>Secretaría</small><br>{{$agenda['secretaria']}}</h4><br><h4 class=\'tx-bold\'><small>Folio</small><br>{{$agenda['folio']}}</h4><br><h4 class=\'tx-bold\'><small>Horario</small><br>{{$agenda['hora_humana']}}</h4><br><h4 class=\'tx-bold\'><small>Estatus</small><br>{{$estatus}}</h4>">
                @endforeach
            @endisset
        </div>

        <div class="section-wrapper ht-100v" style="padding: 0px; border-top:none;">
            <div id="scheduler_here" class="dhx_cal_container ht-auto" style='width:100%; height:100%;'>
                <div class="dhx_cal_navline">
                    <div class="dhx_cal_prev_button">&nbsp;</div>
                    <div class="dhx_cal_next_button">&nbsp;</div>
                    <div class="dhx_cal_today_button"></div>
                    <div class="dhx_cal_date"></div>
                    <div class="dhx_cal_tab" name="day_tab" style="right:204px;"></div>
                </div>
                <div class="dhx_cal_header">
                </div>
                <div class="dhx_cal_data">
                </div>		
            </div>
        </div><!-- section-wrapper -->
        <br><br>
@endsection

@section('seccion-estilos')
    <link rel="stylesheet" href="/box/scheduler/codebase/dhtmlxscheduler_material.css?v=5.3.8" type="text/css" charset="utf-8">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="/box/scheduler/samples/common/controls_styles.css?v=5.3.8">
    <link href="{{ $entorno["version_pages"]["version"] }}/lib/jt.timepicker/css/jquery.timepicker.css" rel="stylesheet">
    <link href="{{ $entorno["version_pages"]["version"] }}/lib/select2/css/select2.min.css" rel="stylesheet">

    <style type="text/css" >
	
		.dhx_cal_event div.dhx_footer,
		.dhx_cal_event.past_event div.dhx_footer,
		.dhx_cal_event.event_english div.dhx_footer,
		.dhx_cal_event.event_math div.dhx_footer,
		.dhx_cal_event.event_science div.dhx_footer{
			background-color: transparent !important;
		}
		.dhx_cal_event .dhx_body{
			-webkit-transition: opacity 0.1s;
			transition: opacity 0.1s;
			opacity: 0.7;
		}
		.dhx_cal_event .dhx_title{
			line-height: 12px;
		}
		.dhx_cal_event_line:hover,
		.dhx_cal_event:hover .dhx_body,
		.dhx_cal_event.selected .dhx_body,
		.dhx_cal_event.dhx_cal_select_menu .dhx_body{
			opacity: 1;
		}

		.dhx_cal_event.event_1 div,
		.dhx_cal_event_line.event_1{
			background-color: #6989b0 !important;
			border-color: #6989b0 !important;
		}

		.dhx_cal_event.dhx_cal_editor.event_1{
			background-color: #6989b0 !important;
		}

		.dhx_cal_event_clear.event_1{
			color:#6989b0 !important;
		}

		.dhx_cal_event.event_2 div,
		.dhx_cal_event_line.event_2{
			background-color: #01377a !important;
			border-color: #01377a !important;    
		}

		.dhx_cal_event.dhx_cal_editor.event_2{
			background-color: #01377a !important;
		}

		.dhx_cal_event_clear.event_2{
			color:#01377a !important;
		}

		.dhx_cal_event.event_B div,
		.dhx_cal_event_line.event_B{
			background-color: #44ad9a !important;
			border-color: #44ad9a !important;
		}

		.dhx_cal_event.dhx_cal_editor.event_B{
			background-color: #44ad9a !important;
		}

		.dhx_cal_event_clear.event_B{
			color:#44ad9a !important;
        }

        .dhx_cal_event.event_primary div,
		.dhx_cal_event_line.event_primary{
			background-color: #234c87 !important;
			border-color: #234c87 !important;
		}

		.dhx_cal_event.dhx_cal_editor.event_primary{
			background-color: #234c87 !important;
		}

		.dhx_cal_event_clear.event_primary{
			color:#234c87 !important;
        }
        

        .dhx_cal_event.event_success div,
		.dhx_cal_event_line.event_success{
			background-color: #4cbe28 !important;
			border-color: #4bbe28 !important;
		}

		.dhx_cal_event.dhx_cal_editor.event_success{
			background-color: #4cbe28 !important;
		}


		.dhx_cal_event_clear.event_success{
			color:#4cbe28 !important;
        }



        .dhx_cal_event.event_warning div,
		.dhx_cal_event_line.event_warning{
			background-color: #34efe8 !important;
			border-color: #34efe8 !important;
		}

		.dhx_cal_event.dhx_cal_editor.event_warning{
			background-color: #34efe8 !important;
		}

		.dhx_cal_event_clear.event_warning{
			color:#34efe8 !important;
        }


        .dhx_cal_event.event_danger div,
		.dhx_cal_event_line.event_danger{
			background-color: #d14549 !important;
			border-color: #d14549 !important;
		}

		.dhx_cal_event.dhx_cal_editor.event_danger{
			background-color: #d14549 !important;
		}

		.dhx_cal_event_clear.event_danger{
			color:#d14549 !important;
        }





        .dhx_cal_event.event_info div,
		.dhx_cal_event_line.event_info{
			background-color: #6490d1 !important;
			border-color: #6490d1 !important;
		}

		.dhx_cal_event.dhx_cal_editor.event_info{
			background-color: #6490d1 !important;
		}

		.dhx_cal_event_clear.event_info{
			color:#6490d1 !important;
        }




        .dhx_cal_event.event_indigo div,
		.dhx_cal_event_line.event_indigo{
			background-color: #6300ed !important;
			border-color: #6300ed !important;
		}

		.dhx_cal_event.dhx_cal_editor.event_indigo{
			background-color: #6300ed !important;
		}

		.dhx_cal_event_clear.event_indigo{
			color:#6300ed !important;
        }




        .dhx_cal_event.event_purple div,
		.dhx_cal_event_line.event_purple{
			background-color: #8a9897 !important;
			border-color: #8a9897 !important;
		}

		.dhx_cal_event.dhx_cal_editor.event_purple{
			background-color: #8a9897 !important;
		}

		.dhx_cal_event_clear.event_purple{
			color:#8a9897 !important;
        }




        .dhx_cal_event.event_teal div,
		.dhx_cal_event_line.event_teal{
			background-color: #45ad9a !important;
			border-color: #45ad9a !important;
		}

		.dhx_cal_event.dhx_cal_editor.event_teal{
			background-color: #45ad9a !important;
		}

		.dhx_cal_event_clear.event_teal{
			color:#45ad9a !important;
        }



        .dhx_cal_event.event_pink div,
		.dhx_cal_event_line.event_pink{
			background-color: #dd4b8c !important;
			border-color: #dd4b8c !important;
		}

		.dhx_cal_event.dhx_cal_editor.event_pink{
			background-color: #dd4b8c !important;
		}

		.dhx_cal_event_clear.event_pink{
			color:#dd4b8c !important;
        }
  

        .dhx_cal_event.event_orange div,
		.dhx_cal_event_line.event_orange{ 
			background-color: #e87e27 !important;
			border-color: #e87e27 !important;
		}

		.dhx_cal_event.dhx_cal_editor.event_orange{
			background-color: #e87e27 !important;
		}

		.dhx_cal_event_clear.event_orange{
			color:#e87e27 !important;
        }

        .dhx_agenda_area .dhx_agenda_line span{
            display:block !important;
        } 


        .dhx_agenda_line{ background-color: transparent !important; }
         
       
	</style>
@endsection

@section('seccion-scripts-libs')
    <script src="/box/scheduler/codebase/dhtmlxscheduler.js?v=5.3.8" charset="utf-8"></script>
    <script src="/box/scheduler/codebase/ext/dhtmlxscheduler_limit.js?v=5.3.8" charset="utf-8"></script>
    <script src="/box/scheduler/codebase/ext/dhtmlxscheduler_agenda_view.js?v=5.3.8" charset="utf-8"></script>
    <script src='/box/scheduler/codebase/ext/dhtmlxscheduler_timeline.js?v=5.3.8' type="text/javascript" charset="utf-8"></script>
    <script src='/box/scheduler/codebase/ext/dhtmlxscheduler_treetimeline.js?v=5.3.8' type="text/javascript" charset="utf-8"></script>
    <script src="/box/scheduler/codebase/ext/dhtmlxscheduler_minical.js?v=5.3.8" type="text/javascript" charset="utf-8"></script>
    <script src="/box/scheduler/codebase/ext/dhtmlxscheduler_units.js?v=5.3.8" type="text/javascript" charset="utf-8"></script>
    <script src="/box/scheduler/codebase/ext/dhtmlxscheduler_week_agenda.js?v=5.3.8" type="text/javascript" charset="utf-8"></script>

    <script src="{{ $entorno["version_pages"]["version"] }}/lib/jt.timepicker/js/jquery.timepicker.js"></script>
    <script src="{{ $entorno["version_pages"]["version"] }}/lib/select2/js/select2.min.js"></script>
@endsection

@section('seccion-scripts-functions')
    <script>
         $(document).ready(function() {
            $('.select2').select2({ minimumResultsForSearch: Infinity });

            setTimeout(function(){
                $('#modal_loading').modal('hide');
            }, 1000);
        });


        window.addEventListener("DOMContentLoaded", function(){

            //===============
            //RESPONSIVO
            //===============
            var compactView = {
                xy: {
                    nav_height: 80
                },
                config: {
                    header: {
                        rows: [
                            { 
                                cols: [
                                    "date",
                                    "unit",
                                    "agenda",
                                ]
                            },
                            { 
                                cols: [@if($sesion['usuario_secretaria']!="")
                                "day",
                                "spacer",
                                "today",
                                @else
                                "unit",
                                "spacer",
                                "today",
                                @endif
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
                    header: {
                        rows: [
                            { 
                                cols: [
                                    "date",
                                    "unit", 
                                    "agenda"
                                ]
                            }
                        ]
                    }

                },
                templates: {
                    month_scale_date: scheduler.date.date_to_str("%l"),
                    week_scale_date: scheduler.date.date_to_str("%l, %F %j"),
                    event_bar_date: function(start,end,ev) {
                        return "• <b>"+scheduler.templates.event_date(start)+"</b> ";
                    }
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
            resetConfig();

            //===============
            //TIMELINE
            //===============
            var elements = [ // original hierarhical array to display
                {key:10, label:"Sala Familiar", open: true, children: [
                    @if(($sesion['usuario_secretaria']==1 or $sesion['usuario_secretaria']=="") and $sesion['juzgado_tipo']=="sala")
                    {key:1, label:"Ponencia 1"},
                    @endif
                    @if(($sesion['usuario_secretaria']==2 or $sesion['usuario_secretaria']=="") and $sesion['juzgado_tipo']=="sala")
                    {key:2, label:"Ponencia 2"},
                    @endif
                    @if(($sesion['usuario_secretaria']==3 or $sesion['usuario_secretaria']=="") and $sesion['juzgado_tipo']=="sala")
                    {key:3, label:"Ponencia 3"},
                    @endif

                    @if(($sesion['usuario_secretaria']=='A' or $sesion['usuario_secretaria']=="") and $sesion['juzgado_tipo']=="juzgado")
                    {key:1, label:"Secretaría A"},
                    @endif
                    @if(($sesion['usuario_secretaria']=='B' or $sesion['usuario_secretaria']=="") and $sesion['juzgado_tipo']=="juzgado")
                    {key:2, label:"Secretaría B"},
                    @endif
                    @if(($sesion['usuario_secretaria']=='C' or $sesion['usuario_secretaria']=="") and $sesion['juzgado_tipo']=="juzgado")
                    {key:3, label:"Secretaría C"},
                    @endif
                ]}
                /*,
                {key:30, label:"Sala Familiar 2",  open: true, children: [
                    {key:40, label:"SF2 Ponencia 1"},
                    {key:50, label:"SF2 Ponencia 2"}
                ]},
                {key:110, label:"Sala Familiar 3", open:true, children: [
                    {key:80, label:"SF3 Ponencia 1"},
                    {key:90, label:"SF3 Ponencia 2"}
                ]}
                */
            ];

            

            //===============
            //CONFIGURACION INICIAL
            //===============
            scheduler.attachEvent("onBeforeViewChange", resetConfig);
            scheduler.attachEvent("onSchedulerResize", resetConfig);
            scheduler.config.multi_day = true;
            scheduler.config.mark_now = true;
            //scheduler.config.agenda_start = new Date({{date('Y')}}, {{date('m')-1}}, {{date('d')}}-1, 0, 1);
            //scheduler.config.agenda_end = new Date({{date('Y')}}, {{date('m')-1}}, {{date('d')}}+1, 23, 59);
            scheduler.config.readonly = true;
            scheduler.config.details_on_dblclick = false;
            scheduler.config.dblclick_create = false;
            scheduler.attachEvent("onBeforeDrag",function(){return false;})
            scheduler.locale.labels.description="Descripción";
            scheduler.locale.labels.date="Día";

            scheduler.config.first_hour = 9;
            scheduler.config.last_hour = 15;
            scheduler.config.hour_size_px = 176;
            var format = scheduler.date.date_to_str("%H:%i");
            scheduler.templates.hour_scale = function(date){
				var step = 15;
				var html = "";
				for (var i=0; i<60/step; i++){
					html += "<div style='height:44px;line-height:44px;'>"+format(date)+"</div>";
					date = scheduler.date.add(date, step, "minute");
				}
				return html;
			}

            scheduler.templates.event_header = function(start,end,ev){
                //console.log(ev);
//                return scheduler.templates.event_date(start)+" - ID. "+ev.id;
                return scheduler.templates.event_date(start);
            };

             
            scheduler.attachEvent("onClick",function(id, e){
                    cargarInfoAgenda(id);
                }
            )


            scheduler.date.agenda_start = function(date){
                return scheduler.date.month_start(new Date(date)); 
            };
            
            scheduler.date.add_agenda = function(date, inc){
                return scheduler.date.add(date, inc, "month"); 
            };
            
    
            //===============
            //GRUPOS
            //===============
            @if($sesion['juzgado_tipo']=="sala")
            var types = [
                        { key: "1", label: "Ponencia 1" },
                        { key: "2", label: "Ponencia 2" },
                        { key: "3", label: "Ponencia 3" }
                    ];
            @else
            var types = [
                        { key: "A", label: "Secretaría A" },
                        { key: "B", label: "Secretaría B" }
                    ];
            @endif
            
            //===============
            //FILTROS
            //===============
            @if($sesion['juzgado_tipo']=="sala")
            var filters = {
                        1: true,
                        2: true,
                        3: true
                    };
            @else
            var filters = {
                        'A': true,
                        'B': true,
                        'C': true
                    };
            @endif
            var filter_inputs = document.getElementById("filters_wrapper").getElementsByTagName("input");
            for (var i=0; i<filter_inputs.length; i++) {
                var filter_input = filter_inputs[i];

                // set initial input value based on filters settings
                filter_input.checked = filters[filter_input.name];

                // attach event handler to update filters object and refresh view (so filters will be applied)
                filter_input.onchange = function() {
                    filters[this.name] = !!this.checked;
                    scheduler.updateView();
                    updIcon(this);
                }
            }
            // here we are using single function for all filters but we can have different logic for each view
            scheduler.filter_month = scheduler.filter_day = scheduler.filter_week = scheduler.filter_agenda = scheduler.filter_week_agenda = scheduler.filter_unit = scheduler.filter_timeline = function(id, event) {
                
                // display event only if its type is set to true in filters obj
                // or it was not defined yet - for newly created event
                if (filters[event.section_id] || event.section_id==scheduler.undefined) {
                    //console.log('1');
                    return true;
                }
                //console.log(2);
                // default, do not display event
                return false;
            };

            function updIcon(el){
                el.parentElement.classList.toggle("checked_label");

                var iconEl = el.parentElement.querySelector("i"),
                    checked = "check_box",
                    unchecked = "check_box_outline_blank",
                    className = "icon_color";

                iconEl.textContent = iconEl.textContent==checked?unchecked:checked;
                iconEl.classList.toggle(className);
            }

            //===============
            //UNITS
            //===============
            scheduler.createUnitsView({
                name: "unit",
                property: "section_id",
                list: types
            });
            scheduler.locale.labels.unit_tab = "Día";

            //===============
            //ESTILOS
            //===============
            scheduler.templates.event_class=function(start, end, event){
                var css = "";

                if(event.color) // if event has subject property then special class should be assigned
                    css += "event_"+event.color;
                
                return css; // default return
            };
            
            
            scheduler.init('scheduler_here',new Date(),"unit");
            scheduler.parse([
                @isset($arr_json[0])
                    @foreach ($arr_json as $agenda)
                        { color:"{{$agenda['color']}}", start_date: "{{$agenda['fecha_cita']}} {{$agenda['hora_cita']}}", end_date: "{{$agenda['fecha_cita']}} {{$agenda['hora_cita_final']}}", text:"{{$agenda['expediente']}} {{$agenda['tramite']}}", section_id:"{{$agenda['secretaria']}}", id:"{{$agenda['folio']}}"},
                    @endforeach
                @endisset
            ]);

            setTimeout(function(){
                var calendar = scheduler.renderCalendar({
                    container:"cal_here", 
                    navigation:true, 
                    handler:function(date){
                        //console.log(scheduler.getState().mode);
                        scheduler.setCurrentView(date, "unit");
                        //console.log(date.getDate());
                        //console.log(date.getMonth());
                        //console.log(date.getFullYear());
                        mes=(date.getMonth()+1);
                        if(mes<10){
                            mes='0'+mes;
                        }

                        dia=date.getDate();
                        if(dia<10){
                            dia='0'+dia;
                        }
                        //se actualiza el json 

                        $('#fecha_cita_hidden').val(date.getFullYear()+"-"+mes+"-"+dia);

                        
                        $('#modal_loading').modal('show');
                        $.ajax({
                            type:'POST',
                            url:'/agendas/citas_json',
                            data:{ fecha: date.getFullYear()+"-"+mes+"-"+dia},
                            success:function(data){
                                scheduler.clearAll();
                                console.log(data);
                                if(data.estatus!=0){
                                    $('#alerta_warning').html('');

                                    for(i=0; i<data.length; i++){ 
                                        //se agrega la info hidden
                                        
                                        estatus='No definido';
                                        if(data[i].estatus==2){
                                            estatus='Atendida';
                                        }
                                        else if(data[i].estatus==3){
                                            estatus='Cancelada';
                                        }
                                        $('#hidden_info').append('<input type="hidden" id="'+data[i].folio+'" value="<h4 class=\'tx-bold\'><small>Expediente</small><br>'+data[i].expediente+'</h4><br><h4 class=\'tx-bold\'><small>Tipo de trámite</small><br>'+data[i].tramite+'</h4><br><h4 class=\'tx-bold\'><small>Partes</small><br>'+data[i].partes+'</h4><br><h4 class=\'tx-bold\'><small>Secretaría</small><br>'+data[i].secretaria+'</h4><br><h4 class=\'tx-bold\'><small>Folio</small><br>'+data[i].folio+'</h4><br><h4 class=\'tx-bold\'><small>Horario</small><br>'+data[i].hora_humana+'</h4><br><h4 class=\'tx-bold\'><small>Correo</small><br>'+data[i].cv_usuario+'</h4><br><h4 class=\'tx-bold\'><small>Estatus</small><br>'+estatus+'</h4>" >');


                                        scheduler.addEvent({
                                            color: data[i].color,
                                            start_date: data[i].fecha_cita+" "+data[i].hora_cita,
                                            end_date:  data[i].fecha_cita+" "+data[i].hora_cita_final,
                                            text:   data[i].expediente+" "+data[i].tramite,
                                            section_id: data[i].secretaria, // userdata
                                            id:   data[i].folio     // userdata
                                        });

                                    }
                                }else{
                                    $('#alerta_warning').html('<div class="alert alert-danger" role="alert"><strong>'+data.msj+'</strong></div>');
                                }
                                
                                setTimeout(function(){
                                    $('#modal_loading').modal('hide');
                                }, 500);
                                
                            }
                        });
                        
                    }
                });
                scheduler.linkCalendar(calendar);
                scheduler.setCurrentView();

                $('.tp2').timepicker({'scrollDefault': 'now', 'timeFormat': "H:i"});
            }, 500);
        });

        $(document).ready(function() {


        });

        function cargarInfoAgenda(texto){
            $('#folio_ventana').val(texto);
            $('#modaldemo3').modal('show');
            $('#modaldemo3').find('.modal-header').html('');
            $('#modaldemo3').find('.modal-body').html('<div class="col-md-12 col-xl-12"><div class="d-flex  ht-300 pos-relative align-items-center">    <div class="sk-three-bounce">        <div class="sk-child sk-bounce1 bg-gray-800"></div>        <div class="sk-child sk-bounce2 bg-gray-800"></div>        <div class="sk-child sk-bounce3 bg-gray-800"></div>      </div> </div><!-- d-flex --></div><!-- col-4 -->');
            $('#modaldemo3').find('.modal-body').html($('#'+texto).val());
        }

        function openWindowWithPost() {

            var form = document.createElement("form");
            //form.target = "_blank";
            form.method = "POST";
            form.action = '/agendas/exportar_citas_excel';
            form.style.display = "none";


            var input = document.createElement("input");
            input.type = "hidden";
            input.name = "fecha_cita_hidden";
            input.value = $('#fecha_cita_hidden').val();
            form.appendChild(input);


            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);
        }
                    
        function guardarEstatusCita(){

            $.ajax({
                type:'POST',
                url: "/agendas/cambiar_estatus_citas_zoho",
                data:{ folio: $('#folio_ventana').val(), estatus:$('#estatus_cita').val()  },
                success:function(data){
                    console.log(data);
                    
                    if(data.estatus==1){
                        alert('Se guardó exitosamente');
                    }
                    else{
                        alert('Problemas de comunicación');
                    }
                    
                    
                }
            });

        }

    </script>

@endsection

@section('seccion-modales')

<!-- LARGE MODAL -->
  <div id="modaldemo3" class="modal fade">
    <div class="modal-dialog modal-lg modal-dialog-vertical-center" role="document" style="width: 95%;">
      <div class="modal-content tx-size-sm">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Message Preview</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body pd-20">
          <h5 class=" lh-3 mg-b-20"><a href="" class="tx-inverse hover-primary">Why We Use Electoral College, Not Popular Vote</a></h5>
          <p class="mg-b-5">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. </p>
        </div><!-- modal-body -->
        

        <div class="row">
            <div class="col-lg-12" style="text-align: center;">
            <hr>
            <h4>Selecciona una opción</h4>
            </div>

            <div class="col-lg-2"></div>
            <div class="col-lg-4">
              <select class="form-control" data-placeholder="" id="estatus_cita" name="estatus_cita">
                <option value="2">Asistió</option>
                <option value="3">No asistió</option>
              </select>
            </div><!-- col-4 -->
            <div class="col-lg-4">

                <button class="btn btn-primary btn-block mg-b-10 btn-sm" onclick="guardarEstatusCita();">Guardar</button>
                <input type="hidden" id="folio_ventana" name="folio_ventna" value="">
            </div>

        </div>


        <div class="modal-footer" style="width: 100%;">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->

@endsection