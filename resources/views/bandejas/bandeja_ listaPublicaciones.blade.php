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
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Agendas de Audiencias</li>
    </ol>
    <h6 class="slim-pagetitle">Agendas de Audiencias</h6>
@endsection


@section('contenido-principal')

        <div class="section-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="card-profile-name">Agenda de Audiencias</h3>
                    <p class="mg-b-20 mg-sm-b-20">Resoluciones turnadas desde el sistema de SASFam.</p>
                </div>
                <div class="col-lg-5">
                    <div id="cal_here" ></div>
                </div>

                <div class="col-lg-7">
                    
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-control-label">Evento:</label>
                            <input class="form-control" type="text" name="involucrados_nombre"  value="" placeholder="">
                        </div>
                    </div><!-- col-4 -->

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-control-label">Descripción:</label>
                            <input class="form-control" type="text" name="involucrados_nombre"  value="" placeholder="">
                        </div>
                    </div><!-- col-4 -->

                    <div class="col-lg-12">

                        <table style="width: 100%;">
                            <tr>
                                <td style="width: 50%;">

                            <div class="form-group">
                                <label class="form-control-label">Inicio:</label>
                        <div class="wd-150 mg-b-30">
                            <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                <i class="fa fa-clock-o tx-16 lh-0 op-6"></i>
                                </div><!-- input-group-text -->
                            </div><!-- input-group-prepend -->
                            <input id="" type="text" class="form-control tp2" placeholder="00:00">
                            </div>
                        </div><!-- wd-150 -->
                        </div>

                                </td>
                                <td style="width: 50%;">


                                    <div class="form-group">
                                        <label class="form-control-label">Finalización:</label>
                                <div class="wd-150 mg-b-30">
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                        <i class="fa fa-clock-o tx-16 lh-0 op-6"></i>
                                        </div><!-- input-group-text -->
                                    </div><!-- input-group-prepend -->
                                    <input id="" type="text" class="form-control tp2" placeholder="00:00">
                                    </div>
                                </div><!-- wd-150 -->
                                </div>



                                </td>
                            </tr>
                        </table>

                    </div>

                    <div class="col-lg-12">
                        <button class="btn btn-primary btn-sm btn-block mg-b-10" onclick="">Guardar agenda</button>
                    </div><!-- col-4 -->


                </div>
            </div>
        </div>
        <div class="sch_control">
            <div class="filters_wrapper" id="filters_wrapper">
                <span>Mostrar:</span>
        
                <label class="checked_label" id="scale1">
                    <input type="checkbox" class="sch_radio" name="1" value="1" checked/>
                    <i class="material-icons icon_color">check_box</i>Ponencia 1
                </label>
        
                <label class="checked_label" id="scale1">
                    <input type="checkbox" class="sch_radio" name="2" value="1" checked/>
                    <i class="material-icons icon_color">check_box</i>Ponencia 2
                </label>
        
                <label class="checked_label" id="scale1">
                    <input type="checkbox" class="sch_radio" name="3" value="1" checked/>
                    <i class="material-icons icon_color">check_box</i>Ponencia 3
                </label>
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
@endsection

@section('seccion-estilos')
    <link rel="stylesheet" href="/box/scheduler/codebase/dhtmlxscheduler_material.css?v=5.3.8" type="text/css" charset="utf-8">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="/box/scheduler/samples/common/controls_styles.css?v=5.3.8">
    <link href="{{ $entorno["version_pages"]["version"] }}/lib/jt.timepicker/css/jquery.timepicker.css" rel="stylesheet">

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
                                cols: [
                                    "day",
                                    "week",
                                    "month",
                                    "timeline",
                                    "agenda",
                                    "unit",
                                    "week_agenda",
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
                                    "timeline",
                                    "agenda",
                                    "unit",
                                    "week_agenda",
                                    "spacer",
                                    "today"
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
                    {key:1, label:"Ponencia 1"},
                    {key:2, label:"Ponencia 2"},
                    {key:3, label:"Ponencia 3"}
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
                x_size: 12,
                x_start: 16,
                x_length:	48,
                y_unit: elements,
                y_property:	"section_id",
                render: "tree",
                folder_dy:30,
                dy:60
            });

            //===============
            //CONFIGURACION INICIAL
            //===============
            scheduler.attachEvent("onBeforeViewChange", resetConfig);
            scheduler.attachEvent("onSchedulerResize", resetConfig);
            scheduler.config.multi_day = true;
            scheduler.config.first_hour = 7;
            scheduler.config.mark_now = true;
            scheduler.config.agenda_start = new Date(2017, 1, 1);
            scheduler.config.agenda_end = new Date(2019, 7, 1);
            scheduler.config.readonly = true;
            scheduler.config.max_month_events = 5;
            scheduler.config.details_on_dblclick = false;
            scheduler.config.dblclick_create = false;
            scheduler.attachEvent("onBeforeDrag",function(){return false;})
    
            scheduler.attachEvent("onClick",function(id, e){
                
                    console.log(id);
                    $('#modaldemo3').modal('show');
                }
            )
    
            //===============
            //GRUPOS
            //===============
            var types = [
                        { key: "1", label: "Ponencia 1" },
                        { key: "2", label: "Ponencia 2" },
                        { key: "3", label: "Ponencia 3" }
                    ];
            
            //===============
            //FILTROS
            //===============
            var filters = {
                        1: true,
                        2: true,
                        3: true
                    };
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
            
            
            scheduler.init('scheduler_here',new Date(2017,5,30),"week_agenda");
            scheduler.parse([
                { start_date: "2017-06-30 09:00", end_date: "2017-06-30 12:00", text:"Task A-isra", section_id:1, id:"isra"},
                { start_date: "2017-06-30 10:00", end_date: "2017-06-30 16:00", text:"Task A-89411", section_id:1 },
                { start_date: "2017-06-30 10:00", end_date: "2017-06-30 14:00", text:"Task A-64168", section_id:1 },
                { start_date: "2017-06-30 16:00", end_date: "2017-06-30 17:00", text:"Task A-46598", section_id:1 },
                
                { start_date: "2017-06-30 12:00", end_date: "2017-06-30 20:00", text:"Task B-48865", section_id:2 },
                { start_date: "2017-06-30 14:00", end_date: "2017-06-30 16:00", text:"Task B-44864", section_id:2 },
                { start_date: "2017-06-30 16:30", end_date: "2017-06-30 18:00", text:"Task B-46558", section_id:2 },
                { start_date: "2017-06-30 18:30", end_date: "2017-06-30 20:00", text:"Task B-45564", section_id:2 },
                
                { start_date: "2017-06-30 09:20", end_date: "2017-06-30 12:20", text:"Task D-52688", section_id:3 },
                { start_date: "2017-06-30 11:40", end_date: "2017-06-30 16:30", text:"Task D-46588", section_id:3 },
                { start_date: "2017-06-30 12:00", end_date: "2017-06-30 18:00", text:"Task D-12458", section_id:3 }
            ]);

            setTimeout(function(){
                var calendar = scheduler.renderCalendar({
                    container:"cal_here", 
                    navigation:true,
                    handler:function(date){
                        //console.log(scheduler.getState().mode);
                        scheduler.setCurrentView(date, 'day');
                    }
                });
                scheduler.linkCalendar(calendar);
                scheduler.setCurrentView();

                $('.tp2').timepicker({'scrollDefault': 'now'});
            }, 500);
        });
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