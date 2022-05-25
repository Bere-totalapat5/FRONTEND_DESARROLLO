@php
  use App\Http\Controllers\clases\humanRelativeDate;
  use App\Http\Controllers\clases\utilidades;
  $humanRelativeDate = new humanRelativeDate();
@endphp
@extends('layouts.index')
@section('contenido-pageheader')

@endsection

@section('contenido-principal')
  <div class="section-wrapper mg-b-100" id="pageone" data-role="page">
    <div id="scheduler_here" class="dhx_cal_container" style='width:100%; height:600px;'>
      <div class="dhx_cal_navline">
        <div class="dhx_cal_prev_button">&nbsp;</div>
        <div class="dhx_cal_next_button">&nbsp;</div>
        <div class="dhx_cal_today_button"></div>
        <div class="dhx_cal_date"></div>
        <div class="dhx_cal_tab" name="day_tab" style="right:204px;"></div>
        <div class="dhx_cal_tab" name="week_tab" style="right:140px;"></div>
        <div class="dhx_cal_tab" name="month_tab" style="right:76px;"></div>
      </div>
      <div class="dhx_cal_header">
      </div>
      <div class="dhx_cal_data">
      </div>		
    </div>
  </div>
@endsection
@section('seccion-estilos')
  <link rel="stylesheet" href="/box/scheduler_5.3.13_enterprise/codebase/dhtmlxscheduler_material.css?v=5.3.8" type="text/css" charset="utf-8">
  <style>
    .dhx_time_block {
      background: #FBDFB3 !important;
    }
    .dhx_scale_holder_now {
      background-color: #FFF !important;
    }
  </style>
@endsection
@section('seccion-scripts-libs')
  <script src="/box/scheduler_5.3.13_enterprise/codebase/dhtmlxscheduler.js?v=5.3.11" type="text/javascript" charset="utf-8"></script>
  <script src="/box/scheduler_5.3.13_enterprise/codebase/ext/dhtmlxscheduler_limit.js?v=5.3.11" type="text/javascript" charset="utf-8"></script>
  <script src="/box/scheduler_5.3.13_enterprise/codebase/locale/locale_es.js" type="text/javascript" charset="utf-8"></script>
	<script src="/box/scheduler_5.3.13_enterprise/codebase/ext/dhtmlxscheduler_units.js?v=5.3.11" type="text/javascript" charset="utf-8"></script>
	<script src="/box/scheduler_5.3.13_enterprise/codebase/ext/dhtmlxscheduler_serialize.js?v=5.3.11" type="text/javascript" charset="utf-8"></script>
	<script src="/box/scheduler_5.3.13_enterprise/codebase/ext/dhtmlxscheduler_year_view.js?v=5.3.11" type="text/javascript" charset="utf-8"></script>
	{{-- <script src='/box/scheduler_5.3.13_enterprise/codebase/ext/dhtmlxscheduler_timeline.js?v=5.3.11' type="text/javascript" charset="utf-8"></script> --}}

@endsection
@section('seccion-scripts-functions')
<script >
//  scheduler.blockTime(new Date(2009,6,3), [0,10*60]);
</script>
<script>

  $(document).ready( () => {
    setTimeout( () => {
      $('#modal_loading').modal('hide');
      obtener_horarios_sala()
    },400);
  });


  function obtener_horarios_sala() {
    bloquear_horarios();
  }

  function init() {
    scheduler.clearAll();
    // scheduler.unblockTime();
    scheduler.config.time_step = 30;
    scheduler.config.multi_day = true;
    scheduler.locale.labels.section_subject = false;
    scheduler.locale.labels.workweek_tab = false;
    scheduler.config.first_hour = 0;
    scheduler.config.limit_time_select = true;
    scheduler.config.details_on_dblclick = true;
    scheduler.config.details_on_create = true;

    scheduler.templates.event_class=function(start, end, event){
      var css = "";

      if(event.subject) // if event has subject property then special class should be assigned
        css += "event_"+event.subject;

      if(event.id == scheduler.getState().select_id){
        css += " selected";
      }
      return css; // default return

      /*
        Note that it is possible to create more complex checks
        events with the same properties could have different CSS classes depending on the current view:

        var mode = scheduler.getState().mode;
        if(mode == "day"){
          // custom logic here
        }
        else {
          // custom logic here
        }
      */
    };

    // we can block specific dates
    
    scheduler.config.lightbox.sections=[
      {name:"description", height:43, map_to:"text", type:"textarea" , focus:true},
      {name:"time", height:72, type:"time", map_to:"auto" }
    ];

    scheduler.init('scheduler_here', new Date(), "day");
  
    
  }

  function bloquear_horarios() {
    console.log(scheduler);
    scheduler.unblockTime(new Date(2021,10,12), "fullday");

    scheduler.blockTime({
      days: new Date(2021,10,12),
      zones: [1*60,13*60],
      type:  "dhx_time_block", 
      css: "red_section",
    });

    scheduler.addMarkedTimespan({ // blocks 4th July, 2012 (this is Wednesday).
      days:  new Date(2021,10,10),
      // zones: "fullday", 
      // type:  "dhx_time_block",
      css:   "red_section" // the name of applied CSS class
    });


    init();



  }

</script>
@endsection
@section('seccion-modales')

@endsection
