@php
  use App\Http\Controllers\clases\humanRelativeDate;
  use App\Http\Controllers\clases\utilidades;
  $humanRelativeDate = new humanRelativeDate();
@endphp

@extends('layouts.index')

@section('contenido-pageheader')
    <ol class="breadcrumb slim-breadcrumb">
       <li class="breadcrumb-item"><a href="#">WebSockets</a></li>
       <li class="breadcrumb-item"><a href="#">WebSockets</a></li>
    </ol>
    <h6 class="slim-pagetitle">Prueba Websockets</h6>
@endsection


@section('contenido-principal')

    <div class="section-wrapper">

        <div class="form-layout">
            <div class="row">
              <h2>Pruebas</h2>
            </div>

            <div class="content">
              <div class="table_responsive">
                <table>
                  <tr class="head_table">
                    <th>Nombre</th>
                    <th>Apellido P</th>
                    <th>Apellido M</th>
                    <th>Nombre</th>
                    <th>Apellido P</th>
                    <th>Apellido M</th>
                    <th>Nombre</th>
                    <th>Apellido P</th>
                    <th>Apellido M</th>
                    <th>Nombre</th>
                    <th>Apellido P</th>
                    <th>Apellido M</th>
                    <th>Nombre</th>
                    <th>Apellido P</th>
                    <th>Apellido M</th>
                  </tr>
                  <tr>
                    <td>Carlos</td>
                    <td>Najera</td>
                    <td>Velazquez</td>
                    <td>Carlos</td>
                    <td>Najera</td>
                    <td>Velazquez</td>
                    <td>Carlos</td>
                    <td>Najera</td>
                    <td>Velazquez</td>
                    <td>Carlos</td>
                    <td>Najera</td>
                    <td>Velazquez</td>
                    <td>Carlos</td>
                    <td>Najera</td>
                    <td>Velazquez</td>
                  </tr>
                  <tr>
                    <td>Carlos</td>
                    <td>Najera</td>
                    <td>Velazquez</td>
                    <td>Carlos</td>
                    <td>Najera</td>
                    <td>Velazquez</td>
                    <td>Carlos</td>
                    <td>Najera</td>
                    <td>Velazquez</td>
                    <td>Carlos</td>
                    <td>Najera</td>
                    <td>Velazquez</td>
                    <td>Carlos</td>
                    <td>Najera</td>
                    <td>Velazquez</td>
                  </tr>
                  <tr>
                    <td>Carlos</td>
                    <td>Najera</td>
                    <td>Velazquez</td>
                    <td>Carlos</td>
                    <td>Najera</td>
                    <td>Velazquez</td>
                    <td>Carlos</td>
                    <td>Najera</td>
                    <td>Velazquez</td>
                    <td>Carlos</td>
                    <td>Najera</td>
                    <td>Velazquez</td>
                    <td>Carlos</td>
                    <td>Najera</td>
                    <td>Velazquez</td>
                  </tr>
                  <tr>
                    <td>Carlos</td>
                    <td>Najera</td>
                    <td>Velazquez</td>
                    <td>Carlos</td>
                    <td>Najera</td>
                    <td>Velazquez</td>
                    <td>Carlos</td>
                    <td>Najera</td>
                    <td>Velazquez</td>
                    <td>Carlos</td>
                    <td>Najera</td>
                    <td>Velazquez</td>
                    <td>Carlos</td>
                    <td>Najera</td>
                    <td>Velazquez</td>
                  </tr>
                  <tr>
                    <td>Carlos</td>
                    <td>Najera</td>
                    <td>Velazquez</td>
                    <td>Carlos</td>
                    <td>Najera</td>
                    <td>Velazquez</td>
                    <td>Carlos</td>
                    <td>Najera</td>
                    <td>Velazquez</td>
                    <td>Carlos</td>
                    <td>Najera</td>
                    <td>Velazquez</td>
                    <td>Carlos</td>
                    <td>Najera</td>
                    <td>Velazquez</td>
                  </tr>
                </table>
              </div>
            </div>

            <div class="content flex">
              <div class="images">
                <i class="fa fa-spotify"></i>
                Spotify
              </div>
              <div class="text">
                Hello World!
              </div>
            </div>

            <div class="content carrousel">
                <div class="item" style="background: #EC7063 ;">1</div>
                <div class="item" style="background: #5DADE2;">2</div>
                <div class="item" style="background: #F4D03F;">3</div>
                <div class="item" style="background: #48C9B0;">4</div>
                <div class="item" style="background: #F5B041;">5</div>
                <div class="item" style="background: #FDEDEC;">6</div>
            </div>

            <div class="content">
              <div class="loading">
                <div class="circle "></div>
                <div class="square "></div>
              </div>
            </div>


        </div>

    </div>

@endsection


@section('seccion-estilos')

    <link rel="stylesheet" href="/box/scheduler/codebase/dhtmlxscheduler_material.css?v=5.3.8" type="text/css" charset="utf-8">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="/box/scheduler/samples/common/controls_styles.css?v=5.3.8">
    <link href="{{ $entorno["version_pages"]["version"] }}/lib/jt.timepicker/css/jquery.timepicker.css" rel="stylesheet">
    <link href="{{ $entorno["version_pages"]["version"] }}/lib/select2/css/select2.min.css" rel="stylesheet">
    {{--  ESTILOS  --}}
    <style>
      .content{
        border:1px solid #000;
        width:100%;
        margin: 3% 0;
      }


      .flex{
        display: flex;
      }
      .images{
        order: 2;
        height: 300px;
        border:1px solid #ccc;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        font-size: 5.5em;
      }
      .text{
        order:1;
        height: 300px;
        font-size: 3.5em;
        border:1px solid #ccc;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
      }


      .table_responsive{
        width: 900px;
        overflow-x: auto;
        resize: horizontal;
        margin: 2%;
      }
      table{
        width: 100%;
        overflow-x: auto;
        border: 1px solid #ccc;
      }
      .head_table{
        background: #eee;
      }
      td,th{
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        border: 1px solid #ccc;
        text-align: center;
      }



      .carrousel{
        display: flex;
        overflow: auto;
        scroll-snap-type: mandatory;
      }
      .carrousel::-webkit-scrollbar{
        width: 8px;    
        height: 8px;   
        display: none; 
      }
      .container::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 4px;
      }
      .container::-webkit-scrollbar-thumb:hover {
        background: #b3b3b3;
        box-shadow: 0 0 2px 1px rgba(0, 0, 0, 0.2);
      }
      .container::-webkit-scrollbar-thumb:active {
        background-color: #999999;
      }
      .container::-webkit-scrollbar-track {
        background: #e1e1e1;
        border-radius: 4px;
      }
      .container::-webkit-scrollbar-track:hover,
      .container::-webkit-scrollbar-track:active {
      background: #d4d4d4;
      }
      .carrousel > .item{
        min-width: 100%;
        scroll-snap-align: start;
        color: #000;
        height: 300px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 8em;
      }


      .loading{
        width: 40%;
        border-radius: 9px;
        margin: 5% auto;
        height: 200px;
        background: #eee;
      }
      .shimmer{
        background-image: linear-gradient(
          90deg,
          #eeeeee 0%, #eeeeee 40%, 
          #dddddd 50%, #dddddd 55%,
          #eeeeee 65%, #eeeeee 100%,
        );
        background-size: 400%;
        animation: shimmer 1500ms infinite;
      }
      @keyframes shimmer{
        from {background-position: 100% 100% }
        to {background-position: 0 0; }
      }

      .circle{
        width: 100px;
        height: 100px;
        border-radius: 50%;
      }
      .square{
        width: 100px;
        height: 100px;
        border-radius: 9px;
      }

    </style>
@endsection

@section('seccion-scripts-libs')  

    <script src="/box/scheduler/codebase/dhtmlxscheduler.js?v=5.3.8" charset="utf-8"></script>
    <script src="/box/scheduler/codebase/ext/dhtmlxscheduler_tooltip.js" charset="utf-8"></script>
    <script src="/box/scheduler/codebase/ext/dhtmlxscheduler_limit.js?v=5.3.8" charset="utf-8"></script>
    <script src="/box/scheduler/codebase/ext/dhtmlxscheduler_agenda_view.js?v=5.3.8" charset="utf-8"></script>
    <script src='/box/scheduler/codebase/ext/dhtmlxscheduler_timeline.js?v=5.3.8' type="text/javascript" charset="utf-8"></script>
    <script src='/box/scheduler/codebase/ext/dhtmlxscheduler_treetimeline.js?v=5.3.8' type="text/javascript" charset="utf-8"></script>
    <script src="/box/scheduler/codebase/ext/dhtmlxscheduler_minical.js?v=5.3.8" type="text/javascript" charset="utf-8"></script>
    <script src="/box/scheduler/codebase/ext/dhtmlxscheduler_units.js?v=5.3.8" type="text/javascript" charset="utf-8"></script>
    <script src="/box/scheduler/codebase/ext/dhtmlxscheduler_week_agenda.js?v=5.3.8" type="text/javascript" charset="utf-8"></script>

    {{--  Pusher  --}}
    <script src="{{ $entorno["version_pages"]["version"] }}/lib/jt.timepicker/js/jquery.timepicker.js"></script>
    <script src="{{ $entorno["version_pages"]["version"] }}/lib/select2/js/select2.min.js"></script>
    <script src="/js/moment.js"></script>
    <script src="/js/moment-with-locales.js"></script>
@endsection

{{--  SCRIPTS  --}}
@section('seccion-scripts-functions')
    <script>

      loading(false);

      function loading(accion, delay = 500){
        if(accion){
          $('#modal_loading').modal('show');
        }else{
          setTimeout(function(){ $('#modal_loading').modal('hide'); }, delay);
        }
      }
    </script>
@endsection

{{--  MODALES --}}
@section('seccion-modales')


@endsection
