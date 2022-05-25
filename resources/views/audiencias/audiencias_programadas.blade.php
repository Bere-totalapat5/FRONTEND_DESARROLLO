@php
  use App\Http\Controllers\clases\humanRelativeDate;
  use App\Http\Controllers\clases\utilidades;
  $humanRelativeDate = new humanRelativeDate();
@endphp
@extends('layouts.index')
@section('contenido-pageheader')


    <ol class="breadcrumb slim-breadcrumb d-none d-md-flex">
      <li class="breadcrumb-item"><a href="/home">Home</a></li>
      <li class="breadcrumb-item active" aria-current="page">Audiencias programadas</li>
    </ol>
    <h6 class="slim-pagetitle" id="title_tareas">Audiencias programadas</h6>

@endsection

@section('contenido-principal')
  <div class="section-wrapper mg-b-100" id="pageone" data-role="page">
    @if(!utilidades::buscarPermisoMenu($request->menu_general['response'], 64, 0))
      <h1 class="mg-b-50">No tiene permiso para acceder a esta sección, verifíquelo con su titular</h1>
      <a href="/home"><button class="btn btn-primary btn-block">Regresar al inicio</button><a>
    @else
      <div class="form-layout mg-b-25" style="min-height: 100%;" >
        <div id="scheduler_here" class="dhx_cal_container" style='width:100%; height:100vh'>
          <div class="dhx_cal_navline">
            <div class="dhx_cal_prev_button">&nbsp;</div>
            <div class="dhx_cal_next_button">&nbsp;</div>
            <div class="dhx_cal_today_button"></div>
            <div class="dhx_cal_date"></div>
            {{-- <div class="dhx_minical_icon" id="dhx_minical_icon" onclick="show_minical()" style="left: 231px;width: 214px;font-size: 1.35em;font-weight: 500;"></div> --}}
          </div>
          <div class="dhx_cal_header">
          </div>
          <div class="dhx_cal_data">
          </div>
        </div>
      </div>
    @endif
  </div>
@endsection

@section('seccion-estilos')
<link rel="stylesheet" type="text/css" href="{{asset("/css/dropzone.min.css")}}">
<link rel="stylesheet" href="/js/clockpicker-gh-pages/src/clockpicker.css">
<link href="{{ $entorno["version_pages"]["version"] }}/lib/jt.timepicker/css/jquery.timepicker.css" rel="stylesheet">
<link rel="stylesheet" href="/box/scheduler_5.3.13_enterprise/codebase/dhtmlxscheduler_material.css?v=5.3.13" type="text/css" charset="utf-8">
<style>
.dhx_cal_tab {
  display: none;
}
.dhx_cal_qi_controls {
  display: none;
}
.dhx_cal_qi_tcontent {
  display: none;
}
.dhx_cal_qi_tdate {
  display: none;
}

.dhx_cal_qi_title {
  display: none;
}

.dhx_cal_quick_info {
  min-width: 45em;
}

.dhx_cal_quick_info .dhx_cal_qi_content {
  width: calc(100% - 27px);
}

@media only screen and ( max-width: 767px ) {
  .dhx_cal_quick_info {
    top: 0 !important;
    left: 0 !important;
    min-width: calc( 100% - 0.5em );
  }
}
.dhx_cal_qi_content .ta_oculto {
  display: none;
}

.tableAudiencia td {
  padding: 0.3em 0.4em;
  border: 1px solid #EEE;
}
</style>

@endsection

@section('seccion-scripts-libs')
<script src="/js/clockpicker-gh-pages/src/clockpicker.js"></script>  
<script src="../lib/jquery-ui/js/jquery-ui.js"></script>
<script src="/js/picker.js"></script>
<script src="/js/moment.js"></script>
<script src="/js/moment-with-locales.js"></script>
<script src="/box/scheduler/codebase/dhtmlxscheduler.js?v=5.3.8" charset="utf-8"></script>
<script src="/box/scheduler/codebase/ext/dhtmlxscheduler_multiselect.js?v=5.3.8"></script>	
<script src="/box/scheduler/codebase/ext/dhtmlxscheduler_editors.js?v=5.3.8"></script>
<script src="/box/scheduler/codebase/ext/dhtmlxscheduler_recurring.js?v=5.3.8" charset="utf-8"></script>
<script src="/box/scheduler/codebase/ext/dhtmlxscheduler_quick_info.js?v=5.3.8" charset="utf-8"></script>
<script src="/box/scheduler/codebase/locale/locale_es.js?v=5.3.13" type="text/javascript" charset="utf-8"></script>
<script src="/box/scheduler/codebase/ext/dhtmlxscheduler_minical.js?v=5.3.13" type="text/javascript" charset="utf-8"></script>
<script src="/js/moment.js"></script>
<script src="/js/moment-with-locales.js"></script>

@endsection

@section('seccion-scripts-functions')
  <script>
    $(document).ready( function() {
      setTimeout( () => {
        $('#modal_loading').modal('hide');
        setTimeout( () => {
          cargarSustituciones();
        },700)
      },600);
    });
  </script>
  <script>

    window.addEventListener("DOMContentLoaded", function(){

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

      scheduler.config.readonly = true;
      scheduler.config.responsive_lightbox = true;
		  resetConfig();
      scheduler.config.drag_move = false;
      scheduler.attachEvent("onBeforeViewChange", resetConfig);
      scheduler.attachEvent("onSchedulerResize", resetConfig);
      scheduler.locale.labels.workweek_tab = false;
      scheduler.locale.labels.decade_tab = false;
      
      scheduler.init('scheduler_here',new Date(),"month");
      scheduler.attachEvent("onViewChange", function (new_mode , new_date){
        cargarSustituciones()
      });
    });

    function show_minical(){
      if (scheduler.isCalendarVisible())
        scheduler.destroyCalendar();
      else
        scheduler.renderCalendar({
          position:"dhx_minical_icon",
          date:scheduler.getState().date,
          navigation:true,
          handler:function(date,calendar){
            scheduler.setCurrentView(date);
            scheduler.destroyCalendar()
          }
        });
    }
  
    function cargarSustituciones() { 
      
      moment.locale('es-mx')

      $('#modal_loading').modal('show');

      sustituciones = [];
      scheduler.clearAll();
      
      $.ajax({
        method: 'GET',
        url: '/public/consultar_audiencias',
        data: {
          juezSearch: @php echo Session::get('usuario_id'); @endphp,
          fecha_ini: moment(scheduler.getState().min_date).format('YYYY-MM-DD'),
          fecha_fin: moment(scheduler.getState().max_date).format('YYYY-MM-DD'),
          registros_por_pagina : 9999,
        },
        success: function (response ) {
          
          if( response.status == 100 ) {
            
            sustituciones = response.response;

            $( response.response ).each( function( i, evento ) {
              
              const { fecha_audiencia, hora_inicio_audiencia,  hora_fin_audiencia, tipo_audiencia, carpeta_investigacion, nombre_unidad, id_audiencia, folio_carpeta, nombre_sala, nombre_inmueble, juez, id_carpeta_judicial } = evento;

              const { nombre_usuario, cve_juez } = juez;
              
              let table = '<table class="datatable tableAudiencia" style="overflow-x: none; display: table"><tbody class=""><tr><td style="background-color: #848F33; color: #FFF;" class="tx-center" colspan="4">Datos generales de la audiencia</td></tr>';

              const datos = [
                ["Carpeta Judicial:",	`<a href="/audiencia_carpeta_judicial/${id_carpeta_judicial}" target="_blank">${folio_carpeta}</a>`],
                ["Fecha de la audiencia:",	moment(fecha_audiencia+' '+hora_inicio_audiencia).format('LLL')],
                ["Horario:",	"De las " +hora_inicio_audiencia+" hrs. a las "+hora_fin_audiencia+" hrs. del "+moment().format('dddd LL')],
                ["Tipo de audiencia:",	tipo_audiencia],
                ["ID Evento:", id_audiencia],
                ["Sala asignada:",	nombre_sala],
                ["Centro de Gestión:",	nombre_unidad],
                ["Edificio sede:",	nombre_inmueble],
                ["Juez asignado:",	nombre_usuario+"("+cve_juez+")"]
              ];
                
              $( datos ).each( function( i , dato ) {
                table += `<tr><td style="font-weight:bold;">${dato[0]}</td><td>${dato[1]}</td></tr>`;
              });

              table += '</tbody></table>';

              scheduler.addEvent({
                id: id_audiencia,
                start_date: fecha_audiencia+' '+hora_inicio_audiencia,
                end_date: fecha_audiencia+' '+hora_fin_audiencia,
                // text: tipo_audiencia, 
                text: '<span class="ta_oculto">'+tipo_audiencia+'</span>' + table,
                descripcion: carpeta_investigacion,
                unidad: nombre_unidad,
              });
            }); 
          }

          setTimeout( () => {
              $('#modal_loading').modal('hide');
          },700);
        }
      });
    }
	
  </script>
@endsection

@section('seccion-modales')
  
@endsection