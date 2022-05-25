@php
    use App\Http\Controllers\clases\humanRelativeDate;
    $humanRelativeDate = new humanRelativeDate();
@endphp

@extends('layouts.index')

@section('contenido-pageheader')
    <ol class="breadcrumb slim-breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Agenda de Audiencias</li>
    </ol>
    <h6 class="slim-pagetitle">Agenda de Audiencias</h6>
@endsection


@section('contenido-principal')

        <div class="section-wrapper">
            <form method="POST" action="{{ route('agendas.guardar_agenda') }}" enctype="multipart/form-data" onsubmit="return validateForm()">
                <input type="hidden" name="fecha_evento" id="fecha_evento" value="{{date('Y-m-d')}}">
                <input type="hidden" value="0" id="id_juicio_promocion" name="id_juicio_promocion">
                <input type="hidden" value="0" id="juicio_promocion" name="juicio_promocion">
                <input type="hidden" value="" id="ponencia_evento" name="ponencia_evento">
                <input type="hidden" value="" id="id_acuerdo_promocion" name="id_acuerdo">

                <div class="row">
                    <div class="col-lg-12"> 
                        <h3 class="card-profile-name">Agenda de Audiencias</h3>
                    </div>
                
                    <div class="col-lg-5">
                        <div id="cal_here" ></div>
                    </div>

                    <div class="col-lg-7">
                        
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label class="form-control-label">Acuerdo: <span class="tx-danger">*</span></label>
                                <table width="100%">
                                    <tr>
                                        <td style="width:30%;"><input class="form-control" type="text" name="toca" id="toca" value="" placeholder="" onkeyup="limpiarValidacion()" required></td>
                                        <td><center>/</center></td>
                                        <td style="width:30%;">
                                            <select class="form-control select2" data-placeholder="" id="anio_toca" style="width:100%;" onchange="limpiarValidacion()">
                                                @for($i=request()->entorno['variables_entorno']['ANIO_FIN']; $i>=request()->entorno['variables_entorno']['ANIO_INICIO']; $i--)
                                                    <option value="{{$i}}">{{$i}}</option>
                                                @endfor
                                            </select>

                                        </td>
                                        <td><center> {{$request->lang['/']}} </center></td>
                                        <td style="width:30%;"><input class="form-control" type="text" name="asunto_toca" id="asunto_toca" value="" placeholder="" onkeyup="limpiarValidacion()"></td>
                                        
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-2">
                                <button class="btn btn-success bd-0" data-toggle="modal" data-target="#modaldemo3" onclick="validarToca();" type="button">Validar</button>
                            </div>

                            <div class="col-lg-10" id="informacion_toca">
                        
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-control-label">Evento: <span class="tx-danger">*</span></label>
                                    <input class="form-control" type="text" id="nombre_evento" name="nombre_evento"  value="" placeholder="" required>
                                </div>
                            </div><!-- col-4 --> 

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-control-label">Descripción: <span class="tx-danger">*</span></label>
                                    <input class="form-control" type="text" id="descripcion_evento" name="descripcion_evento"  value="" placeholder="" required>
                                </div>
                            </div><!-- col-4 -->

                            <!--
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-control-label">{{$request->lang['Ponencia']}}: <span class="tx-danger">*</span></label>
                                    <select id="ponencia_evento" class="form-control select2" name="ponencia_evento" @if($sesion['usuario_secretaria']!='') readonly @endif>
                                        @if($request->session()->get('juzgado_tipo')=='sala')
                                            <option value="1" @if($sesion['usuario_secretaria']==1 or $sesion['usuario_secretaria']=="") selected @else disabled @endif>1</option>
                                            <option value="2" @if($sesion['usuario_secretaria']==2 or $sesion['usuario_secretaria']=="") selected @else disabled @endif>2</option>
                                            <option value="3" @if($sesion['usuario_secretaria']==3 or $sesion['usuario_secretaria']=="") selected  @else disabled @endif>3</option>
                                        @else
                                            <option value="A" @if($sesion['usuario_secretaria']=='A' or $sesion['usuario_secretaria']=="") selected @else disabled @endif>A</option>
                                            <option value="B" @if($sesion['usuario_secretaria']=='B' or $sesion['usuario_secretaria']=="") selected @else disabled @endif>B</option>
                                            <option value="C" @if($sesion['usuario_secretaria']=='C' or $sesion['usuario_secretaria']=="") selected @else disabled @endif>C</option>
                                        @endif
                                    </select>
                                </div>
                            </div><! -- col-4 -->
    
                            <div class="col-lg-12">

                                <table style="width: 100%;">
                                    <tr>
                                        <td style="width: 50%;">

                                    <div class="form-group">
                                        <label class="form-control-label">Inicio: <span class="tx-danger">*</span></label>
                                <div class="wd-150 mg-b-30">
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                        <i class="fa fa-clock-o tx-16 lh-0 op-6"></i>
                                        </div><!-- input-group-text -->
                                    </div><!-- input-group-prepend -->
                                    <input id="hora_inicio" name="hora_inicio" type="text" class="form-control tp2" placeholder="00:00" required>
                                    </div>
                                </div><!-- wd-150 -->
                                </div>

                                        </td>
                                        <td style="width: 50%;">


                                            <div class="form-group">
                                                <label class="form-control-label">Finalización: <span class="tx-danger">*</span></label>
                                        <div class="wd-150 mg-b-30">
                                            <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                <i class="fa fa-clock-o tx-16 lh-0 op-6"></i>
                                                </div><!-- input-group-text -->
                                            </div><!-- input-group-prepend -->
                                            <input id="hora_final" name="hora_final" type="text" class="form-control tp2" placeholder="00:00" required>
                                            </div>
                                        </div><!-- wd-150 -->
                                        </div>



                                        </td>
                                    </tr>
                                </table>

                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12" style="display: none;">
                        <hr>
                        <div class="row">
                            
                            <div class="col-lg-2 mg-t-20">
                                <h5 class="card-profile-name">Recordatorio</h5>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group mg-b-0">
                                    <label>Minutos antes del evento: <span class="tx-danger">*</span></label>
                                    <select id="intervalo_min" class="form-control select2" name="intervalo_min" data-placeholder="Minutos antes del evento">
                                        <option value="5">5</option>
                                        <option value="10">10</option>
                                        <option value="15" selected>15</option>
                                        <option value="20">20</option>
                                        <option value="25">25</option>
                                        <option value="30">30</option>
                                        <option value="35">35</option>
                                        <option value="40">40</option>
                                        <option value="45">45</option>
                                        <option value="50">50</option>
                                        <option value="55">55</option>
                                        <option value="60">60</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 mg-t-20">
                                <label class="ckbox">
                                    <input type="checkbox" id="recordatorio_sms" name="recordatorio_sms" value="1" checked><span>Enviar por SMS</span>
                                </label>
                            </div>
                            <div class="col-lg-3 mg-t-20">
                                <label class="ckbox">
                                    <input type="checkbox" id="recordatorio_correo" name="recordatorio_correo" value="1" checked><span>Enviar por email</span>
                                </label>
                            </div>
                        </div>
                    </div><!-- col-4 -->

                    <div class="col-lg-12">
                        <br>
                        <button class="btn btn-primary btn-block mg-b-10" onclick="">Guardar agenda</button>
                    </div><!-- col-4 -->


                </div>
            </form>
        </div>
        <div class="sch_control">
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
                
                @if(($sesion['usuario_secretaria']=='C' or $sesion['usuario_secretaria']=="") and $sesion['juzgado_tipo']=="juzgado")
                <label class="checked_label" id="scale1">
                    <input type="checkbox" class="sch_radio" name="C" value="1" checked/>
                    <i class="material-icons icon_color">check_box</i>Secretaría C
                </label>
                @endif
                
                
            </div>
        </div>

        
        <div class="section-wrapper ht-100v" style="padding: 0px; border-top:none;">
            <div id="scheduler_here" class="dhx_cal_container ht-auto" style='width:100%; height:100%;'>
                <div class="dhx_cal_navline">
                    <div class="dhx_cal_prev_button">&nbsp;</div>
                    <div class="dhx_cal_next_button">&nbsp;</div>
                    <div class="dhx_cal_today_button"></div>
                    <div class="dhx_cal_date"></div>
                    <div class="dhx_cal_tab" name="day_tab" style="right:204px;"></div>
                    <div class="dhx_cal_tab" name="week_tab" style="right:140px;"></div>
                    <div class="dhx_cal_tab" name="timeline_tab" style="right:280px;"></div>
                    <div class="dhx_cal_tab" name="month_tab" style="right:76px;"></div>
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

		.dhx_cal_event.event_3 div,
		.dhx_cal_event_line.event_3{
			background-color: #3e5169 !important;
			border-color: #3e5169 !important;
		}

		.dhx_cal_event.dhx_cal_editor.event_3{
			background-color: #3e5169 !important;
		}

		.dhx_cal_event_clear.event_3{
			color:#B82594 !important;
        }
        
       
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
        setTimeout(function(){
            $('#modal_loading').modal('hide');
        }, 1000);

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
                                    "prev",
                                    "date",
                                    "next",
                                ]
                            },
                            { 
                                cols: [@if($sesion['usuario_secretaria']!="")
                                "day",
                                "week_agenda",
                                "month",
                                "timeline",
                                "agenda",
                                "spacer",
                                "today",
                                @else
                                "unit",
                                "week_agenda",
                                "month",
                                "timeline",
                                "agenda",
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
                                    "prev",
                                    "date",
                                    "next",
                                ]
                            },
                            { 
                                cols: [@if($sesion['usuario_secretaria']!="")
                                "day",
                                "week_agenda",
                                "month",
                                "timeline",
                                "agenda",
                                "spacer",
                                "today",
                                @else
                                "unit",
                                "week_agenda",
                                "month",
                                "timeline",
                                "agenda",
                                "spacer",
                                "today",
                                @endif
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

            scheduler.createTimelineView({
                section_autoheight: false,
                name:	"timeline",
                x_unit:	"minute",
                x_date:	"%H:%i",
                x_step:	30,
                x_size: 30,
                x_start: 16,
                x_length:	20,
                y_unit: elements,
                y_property:	"section_id",
                render: "tree",
                column_width: 70, 
                scrollable: true,
                autoscroll: {           
                    range_x: 200,       
                    range_y: 100,       
                    speed_x: 20,        
                    speed_y: 10         
                }   
            });

            //===============
            //CONFIGURACION INICIAL
            //===============
            scheduler.attachEvent("onBeforeViewChange", resetConfig);
            scheduler.attachEvent("onSchedulerResize", resetConfig);
            scheduler.config.multi_day = true;
            scheduler.config.first_hour = 7;
            scheduler.config.last_hour = 18;
            scheduler.config.mark_now = true;
            //scheduler.config.agenda_start = new Date({{date('Y')}}, {{date('m')-1}}, 1);
            //scheduler.config.agenda_end = new Date({{date('Y')}}, {{date('m')+2}}, 1);
            scheduler.config.readonly = true;
            scheduler.config.max_month_events = 5;
            scheduler.config.details_on_dblclick = false;
            scheduler.config.dblclick_create = false;
            scheduler.attachEvent("onBeforeDrag",function(){return false;})

            
            //===============
            //Agendas
            //===============
            scheduler.config.xml_date = "%Y-%m-%d %h:%i";
            scheduler.date.agenda_start = function(date){
                return scheduler.date.month_start(new Date(date)); 
            };

            scheduler.date.add_agenda = function(date, inc){
                return scheduler.date.add(date, inc, "month"); 
            };

            scheduler.attachEvent("onTemplatesReady", function(){
                scheduler.templates.agenda_date = scheduler.templates.month_date;
            });

            scheduler.templates.event_header = function(start,end,ev){
                console.log(ev);
                console.log(ev.acuerdo);
                return scheduler.templates.event_date(start)+" - "+ev.acuerdo;
//                return scheduler.templates.event_date(start);
            };

            scheduler.attachEvent("onClick",function(id, e){
                    cargarInfoAgenda(id);
                }
            )
    
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
                        { key: "B", label: "Secretaría B" },
                        
                        { key: "C", label: "Secretaría C" }
                       
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
                    return true;
                }
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

                if(event.section_id) // if event has subject property then special class should be assigned
                    css += "event_"+event.section_id;

                if(event.id == scheduler.getState().select_id){
                    css += " selected";
                }
                return css; // default return
            };
            
            
            scheduler.init('scheduler_here',new Date(),@if($sesion['usuario_secretaria']!="")"day"@else"unit"@endif);
            scheduler.parse([
                @isset($lista["response"])
                    @foreach ($lista["response"] as $agenda)
                        @php $acuerdo=""; @endphp
                        @isset($agenda['datos_juicio']['datos'][0]['acuerdo'])
                            @php $acuerdo=strtoupper($agenda['datos_juicio']['datos'][0]['tipo_expediente']).' '.$agenda['datos_juicio']['datos'][0]['acuerdo']; @endphp
                        @endisset
                        { start_date: "{{$agenda['fecha']}} {{$agenda['hora_inicio']}}", acuerdo:"{{$acuerdo}}" , end_date: "{{$agenda['fecha']}} {{$agenda['hora_final']}}", text:"{{$agenda['nombre']}}", section_id:"{{$agenda['ponencia']}}", id:"{{$agenda['id_evento']}}"},
                    @endforeach
                @endisset
            ]);
 
            setTimeout(function(){
                var calendar = scheduler.renderCalendar({
                    container:"cal_here", 
                    navigation:true,
                    handler:function(date){
                        //console.log(scheduler.getState().mode);
                        scheduler.setCurrentView(date, @if($sesion['usuario_secretaria']!="")"day"@else"unit"@endif);
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
                        $('#fecha_evento').val(date.getFullYear()+'-'+mes+"-"+dia);
 
                    }
                });
                scheduler.linkCalendar(calendar);
                scheduler.setCurrentView();

                $('.tp2').timepicker({'scrollDefault': 'now', 'timeFormat': "H:i", 'minTime': '7:00', 'maxTime': '18:00'});
            }, 500);
        });

        $(document).ready(function() {
            // Select2
            $('.select2').select2({
                minimumResultsForSearch: Infinity
            });

        });

        function validarToca(){
            if($('#toca').val()==""){

                alert("El número de {{$request->lang['toca']}} es obligatorio");
                setTimeout(function(){
                    $('#modaldemo3').modal('hide');
                },500);

            }
            else{
                $('#modaldemo3').find('.modal-header').html('');
                $('#modaldemo3').find('.modal-body').html('<div class="col-md-12 col-xl-12"><div class="d-flex  ht-300 pos-relative align-items-center">    <div class="sk-three-bounce">        <div class="sk-child sk-bounce1 bg-gray-800"></div>        <div class="sk-child sk-bounce2 bg-gray-800"></div>        <div class="sk-child sk-bounce3 bg-gray-800"></div>      </div> </div><!-- d-flex --></div><!-- col-4 -->');
                $.ajax({
                    type:'POST',
                    url:'/agendas/validar_acuerdo_ajax',
                    data:{ toca:$('#toca').val(), anio_toca:$('#anio_toca').val(), asunto_toca:$('#asunto_toca').val()  },
                    success:function(data){
                        console.log(data);
                        $('#modaldemo3').find('.modal-header').html(data.plantilla_archivo_header);
                        $('#modaldemo3').find('.modal-body').html(data.plantilla_archivo_body);
                    }
                });
            }
        }

        function limpiarValidacion(){
            $('#id_juicio_promocion').val(0);
            $('#informacion_toca').html('');
            $('#lista_caratulas').html('');
        }

        function cargarCaratulasPendinetes(){

        }

        function cargarInfoAgenda(agenda_id){
            $('#modaldemo3').modal('show');
            $('#modaldemo3').find('.modal-header').html('');
            $('#modaldemo3').find('.modal-body').html('<div class="col-md-12 col-xl-12"><div class="d-flex  ht-300 pos-relative align-items-center">    <div class="sk-three-bounce">        <div class="sk-child sk-bounce1 bg-gray-800"></div>        <div class="sk-child sk-bounce2 bg-gray-800"></div>        <div class="sk-child sk-bounce3 bg-gray-800"></div>      </div> </div><!-- d-flex --></div><!-- col-4 -->');
            
            $.ajax({
                type:'POST',
                url:'/agendas/consultaEventoAjax',
                data:{ agenda_id:agenda_id },
                success:function(data){
                    console.log(data);
                    $('#modaldemo3').find('.modal-header').html(data.plantilla_archivo_header);
                    $('#modaldemo3').find('.modal-body').html(data.plantilla_archivo_body);
                }
            });
        }


        function validateForm(){
            if($('#hora_inicio').val() > $('#hora_final').val()){
                alert("El horario final debe de ser mayor al inicial.");
                return false;
            }
            if($('#id_juicio_promocion').val() == 0) {
                alert("Debe de validar el {{$request->lang['toca']}}.");
                return false;
            }
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
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->

@endsection