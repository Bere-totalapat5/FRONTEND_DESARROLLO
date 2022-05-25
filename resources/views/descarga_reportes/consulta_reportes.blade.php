@php
  use App\Http\Controllers\clases\humanRelativeDate;
  use App\Http\Controllers\clases\utilidades;
  $humanRelativeDate = new humanRelativeDate();
  $ids_permitidos = [1,18,20];
  $id_user = $request->session()->get('id_tipo_usuario');
@endphp

@extends('layouts.index')

{{-- Header --}}
@section('contenido-pageheader')
  <ol class="breadcrumb slim-breadcrumb">
     <li class="breadcrumb-item"><a href="javascript:void(0);">Reportes</a></li>
     <li class="breadcrumb-item"><a href="javascript:void(0);"> Consulta Reportes</a></li>
  </ol>
  <h6 class="slim-pagetitle">  Consulta Reportes</h6>
@endsection
{{-- Estilos --}}
@section('seccion-estilos')
    <link href="{{asset("/lib/datatables/css/jquery.dataTables.css")}}" rel="stylesheet">
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
    <style>
        .tablas_collapsadas{
          border: 1px solid #848f3361;
          padding: 10px;
          font-size: 1.1em;
          border-radius: 4px;
          display: flex;
          justify-content: space-between;
          align-items: center;
          cursor: pointer;
        }
        .activos{
          border-left: 4px solid #848f33 !important;
        }
        .activo_c{
          display: block !important;
        }

        .lista_reportes{
          border: 1px solid #eee;
          padding: 4px 11px;
          text-align: left;
          margin: 2% 0px;
          cursor: pointer;
        }

        .lista_reportes:hover{
          border-left: 4px solid #848f33 !important;
        }

        .div_lista_reportes{
          width: 100%; 
          height: 340px;
          overflow: auto;
        }

        .div_lista_reportes::-webkit-scrollbar {
          width: 8px;
          height: 8px;     
        }

        .div_lista_reportes::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 4px;
        }

        .div_lista_reportes::-webkit-scrollbar-thumb:hover {
            background: #b3b3b3;
            box-shadow: 0 0 2px 1px rgba(0, 0, 0, 0.2);
        }

        .div_lista_reportes::-webkit-scrollbar-thumb:active {
            background-color: #999999;
        }

        .div_lista_reportes::-webkit-scrollbar-track {
            background: #e1e1e1;
            border-radius: 4px;
        }
      
        .div_lista_reportes::-webkit-scrollbar-track:hover,
        .div_lista_reportes::-webkit-scrollbar-track:active {
          background: #d4d4d4;
        }  

        .cont_lista_reportes{
          width: 100%; 
          list-style:none; 
          height: auto;
          overflow:auto; 
          padding-left:0;
          padding-right: 5%;
          font-size: 0.9em;
          font-weight: bold;
          color: #aaa;
        }
        
        .cont_lista_reportes{
          width: 100%; 
          list-style:none; 
          height: auto;
          overflow:auto; 
          padding-left:0;
          padding-right: 5%;
          font-size: 0.9em;
          font-weight: bold;
          color: #aaa;
        }
        
        .cont_lista_reportes::-webkit-scrollbar {
          width: 8px;
          height: 8px;     
        }

        .cont_lista_reportes::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 4px;
        }

        .cont_lista_reportes::-webkit-scrollbar-thumb:hover {
            background: #b3b3b3;
            box-shadow: 0 0 2px 1px rgba(0, 0, 0, 0.2);
        }

        .cont_lista_reportes::-webkit-scrollbar-thumb:active {
            background-color: #999999;
        }

        .cont_lista_reportes::-webkit-scrollbar-track {
            background: #e1e1e1;
            border-radius: 4px;
        }
      
        .cont_lista_reportes::-webkit-scrollbar-track:hover,
        .cont_lista_reportes::-webkit-scrollbar-track:active {
          background: #d4d4d4;
        }  

        .bot{
          width:50%; 
          color:#fff; 
          background:#848F33 !important; 
          border-color:#848F33 !important; 
          padding:4px !important;
        }

        @media(max-width: 770px){
          .bot{
              width: 100% !important;
              border-color:#848F33 !important;
          }
        }
        #accordion .card{
            border:none !important;
        }
        #accordion .card .card-header{
          width: 75px !important;
          border: 1px solid #dee2e6 !important;
        }
        #accordion .card .card-header a{
          padding: 10px !important;
        }
        #collapseSearchAdvance{
          border: 1px solid #eee !important;
          background: #f8f9fa;
        }
        #accordion a::before{
          top: 10px !important;
        }
        .select2-container.select2-container--default.select2-container--open{
            z-index: 1050 !important;
        }
        .page-link{
            border:none !important;
        }
        #cmp_clave{
          position: relative;
        }
        #cmp_clave i{
          position: absolute;
          top: 30%;
          right: 6%;
          cursor: pointer;
        }
        #alertaVacio{
          display: none;
          color: #E74C3C;
          font-size: 0.9em;
        }
        .lds-roller {
          display: inline-block;
          position: relative;
          width: 80px;
          height: 80px;
        }
        .lds-roller div {
          animation: lds-roller 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
          transform-origin: 40px 40px;
        }
        .lds-roller div:after {
          content: " ";
          display: block;
          position: absolute;
          width: 7px;
          height: 7px;
          border-radius: 50%;
          background: #fff;
          margin: -4px 0 0 -4px;
        }
        .lds-roller div:nth-child(1) {
          animation-delay: -0.036s;
        }
        .lds-roller div:nth-child(1):after {
          top: 63px;
          left: 63px;
        }
        .lds-roller div:nth-child(2) {
          animation-delay: -0.072s;
        }
        .lds-roller div:nth-child(2):after {
          top: 68px;
          left: 56px;
        }
        .lds-roller div:nth-child(3) {
          animation-delay: -0.108s;
        }
        .lds-roller div:nth-child(3):after {
          top: 71px;
          left: 48px;
        }
        .lds-roller div:nth-child(4) {
          animation-delay: -0.144s;
        }
        .lds-roller div:nth-child(4):after {
          top: 72px;
          left: 40px;
        }
        .lds-roller div:nth-child(5) {
          animation-delay: -0.18s;
        }
        .lds-roller div:nth-child(5):after {
          top: 71px;
          left: 32px;
        }
        .lds-roller div:nth-child(6) {
          animation-delay: -0.216s;
        }
        .lds-roller div:nth-child(6):after {
          top: 68px;
          left: 24px;
        }
        .lds-roller div:nth-child(7) {
          animation-delay: -0.252s;
        }
        .lds-roller div:nth-child(7):after {
          top: 63px;
          left: 17px;
        }
        .lds-roller div:nth-child(8) {
          animation-delay: -0.288s;
        }
        .lds-roller div:nth-child(8):after {
          top: 56px;
          left: 12px;
        }
        @keyframes lds-roller {
          0% {
            transform: rotate(0deg);
          }
          100% {
            transform: rotate(360deg);
          }
        }
        .menu_correos{
          width: 100%;
          height: 100%;
          border: 1px solid #ccc;
          background: #fff;
          padding: 10px;
        }
        .add_email{
          border: 1px solid #ccc;
          width: 60px;
          height: 60px;
          position: fixed;
          z-index: 1000;
          display: flex;
          justify-content: center;
          align-items: center;
          right: 4%;
          bottom: 8%;
          font-size: 1.2em;
          cursor: pointer;
          color: #848F33 ;
          background: #fff;
        }

        .add_email:hover{
          background: #848F33;
          color: #fff;
        }
        
        @media (max-width:600px){
          .add_email{
            width: 50px;
            height: 50px;
            right:3%;
            bottom: 4%;
          }
        }

        @media (max-width:900px){
          .add_email{
            width: 50px;
            height: 50px;
            right: 3.5%;
            bottom: 4%;
          }
        }

        @media (min-width:1300px){
          .add_email{
            width: 60px;
            height: 60px;
            right: 10%;
            bottom: 10%;
          }
        }

        .titulo_correos{
          width: 100%;
          border: 1px solid #ccc;
          padding: 20px;
          text-align: center;
          font-size: 1.2em;
          background: #848F33 !important;
          color: #fff;
          line-height: 20px;
          font-weight: bold;
        }
        .row_contenedor{
          width: 100%;
          padding-top: 1%;
        }
        .title_c{
          width: 100%;
          padding: 10px;
          text-align: center;
          font-size: 1.2em;
          color: rgb(94, 94, 94);
          line-height: 10px;
          font-weight: bold;
          position: relative;
        }
        .clearfix{
          clear: both;
          content: '';
        }
        #contactos{
          overflow-y: auto;
          padding:20px;
          height: 500px;
        }
        #contactos::-webkit-scrollbar {
          width: 8px;
          height: 8px;     
        }

        #contactos::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 4px;
        }

        #contactos::-webkit-scrollbar-thumb:hover {
            background: #b3b3b3;
            box-shadow: 0 0 2px 1px rgba(0, 0, 0, 0.2);
        }

        #contactos::-webkit-scrollbar-thumb:active {
            background-color: #999999;
        }

        #contactos::-webkit-scrollbar-track {
            background: #e1e1e1;
            border-radius: 4px;
        }
      
        #contactos::-webkit-scrollbar-track:hover,
        #contactos::-webkit-scrollbar-track:active {
          background: #d4d4d4;
        }    
        .contacto{
          width: 100%;
          padding:5px;
          margin: 1.5% 0;
          border-radius: 4px;
          background: #f1f1f1;
        }
        .image_contact{
          width: 35px;
          min-width: 35px;
          height: 35px;
          display: inline-block;
          float: left;
        }
        .imagen{
          width: 32px;
          min-width: 32px;
          height: 32px;
          border-radius: 50%;
          font-size: 1em;
          font-weight: bold;
          text-align: center;
          line-height: 32px;
          text-transform: uppercase;
          margin: 0 auto;
        }
        .info_contact{
          width: 60%;
          min-width: 60%;
          height: 35px;
          display: inline-block;
          float: left;
        }
        .nombre_contact{
          color: #444;
          font-size: 0.75em;
          text-align: left;
          font-weight: bold;
          padding-left: 10px;
        }
        .correo_contact{
          color: #abaaaa;
          text-align: left;
          font-weight: bold;
          font-size: 0.7em;
          padding-left: 10px;
        }
        .button_contact{
          width: 72px;
          min-width: 72px;
          height: 35px;
          display: inline-block;
          float: right;
          text-align: center;
        }
        .button_contact i{
          color: #abaaaa;
          cursor: pointer;
          font-weight: bold;
          font-size: 0.8em;
          line-height: 32px;
          padding-right: 10px;
        }

        .button_contact i:hover{
          color: #848F33 !important;
        }
        .adduser{
          border: 1px solid #848F33 !important;
          color: #848f33;
          width: 40px;
          text-align: center;
          border-radius: 4px;
          position: absolute;
          right: 5%;
          padding: 4px;
          font-size: 0.7em;
          bottom: 16%;
          cursor: pointer;
          background: #fff;
        }
        .adduser:focus{
          outline: none;
        }
        .adduser:active{
          transform: scale(0.95);
        }

        .reportes{
          height: 500px;
          overflow-y: auto;
          padding:20px;
        }
        .reportes::-webkit-scrollbar {
          width: 6px;
          height: 8px;     
        }

        .reportes::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 4px;
        }

        .reportes::-webkit-scrollbar-thumb:hover {
            background: #b3b3b3;
            box-shadow: 0 0 2px 1px rgba(0, 0, 0, 0.2);
        }

        .reportes::-webkit-scrollbar-thumb:active {
            background-color: #999999;
        }

        .reportes::-webkit-scrollbar-track {
            background: #e1e1e1;
            border-radius: 4px;
        }
      
        .reportes::-webkit-scrollbar-track:hover,
        .reportes::-webkit-scrollbar-track:active {
          background: #d4d4d4;
        }

        .reporte{
          width: 100%;
          padding:5px;
          margin: 0 0 1.5% 0;
          border-radius: 4px;
        }
        .title-reporte{
          text-align: center;
          font-size: 1em;
          color: #444;
          background: #fff;
          box-shadow: 0px 1px 3px 0px #848f33;
          position: relative;
          height: 42px;
          line-height: 42px;
        }
        .button_reporte_collapse{
          width: 50px;
          height: 35px;
          position: absolute;
          text-align: center;
          left: 1%;
          top: 0%;
        }
        .button_reporte_collapse i{
          color: #abaaaa;
          cursor: pointer;
          font-weight: bold;
          font-size: 0.9em;
        }
        .button_reporte_config{
          width: 50px;
          height: 35px;
          position: absolute;
          text-align: center;
          right: 1%;
          bottom:14%;
        }
        .button_reporte_config i{
          color: #abaaaa;
          cursor: pointer;
          font-weight: bold;
          font-size: 0.9em;
        }
        .body_reporte{
          display: block;
          height: auto;
          padding: 10px;
          border: 1px solid #ccc;
        }
        .body_contacto{
          display: none;
          height: auto;
          padding: 10px;
          font-size: 0.9em;
        }
        #letra, #letra_edit{
          width: 50px;
          height: 50px;
          border-radius: 50%;
          font-size: 1.4em;
          font-weight: bold;
          text-align: center;
          line-height: 48px;
          text-transform: uppercase;
          margin: 16px auto;
        }
        .refresh{
          width: 20px;
          height: 20px;
          border: 1px solid #ccc;
          border-radius: 50%;
          text-align: center;
          line-height: -9px;
          padding: 5;
          font-size: 0.5em;
          display: flex;
          justify-content: center;
          align-items: center;
          position: absolute;
          right: 32%;
          bottom: 10%;
          cursor: pointer;
        }
        @media(max-width:770px){
          .button_contact{
            width: 100%;
          }
        }
        @media(max-width:765px){
          .title_c{
            border: 1px solid #ccc;
          }
          .reportes, .contactos, .menu_correos{
            height: auto;
          }
          .reportes{
            padding: 10px;
            margin-bottom: 10%;
          }
          #contactos{
            padding: 10px;
          }
          .letra{
            width: 70px;
            height: 70px;
            line-height: 70px;
            font-size: 1.9em;
          }
          .refresh{
            width: 25px;
            height: 25px;
            right: 35%;
          }
          .button_contact{
            width: 72px;
          }
        }
        @media(max-width:365px){
          .button_contact{
            width: 100%;
          }
        }
        .joinReporte{
          width: 30px;
          height: 20px;
          border: 1px solid #ccc;
          text-align: center;
          display: flex;
          justify-content: center;
          align-items: center;
          color: #848F33;
          position: absolute;
          right: 4%;
          bottom: 6%;
          cursor: pointer;
        }
        .joinReporte:hover{
          background: #848F33;
          color: #fff;
        }
        .joinReporte:active{
          transform: scale(0.9);
        }
        .checks{
          display: block;
          margin-left: 4%;
          margin-bottom: 0%;
          font-size: 0.9em;
        }
        .checks input[type="checkbox"]{
          margin-right: 1%;
          border: none;
          background: #b3b3b3;
        }
    </style>
@endsection

{{-- Contenido Principal --}}
@section('contenido-principal')
    <div class="section-wrapper" style="max-width: 100%;">
      @if(!utilidades::buscarPermisoMenu($request->menu_general['response'], 49, 0))
        <h1 class="mg-b-50">No tiene permiso para acceder a esta sección, verifíquelo con su titular</h1>
        <a href="/home"><button class="btn btn-primary btn-block">Regresar al inicio</button><a>
      @else
        <div class="form-layout" style="position: relative;">

          <div id="bodyConsultaReportes">

            <div class="card-header">
              <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                  <a class="nav-link active" href="#generacion_reportes" data-toggle="tab">Reportes</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#reenvio_reportes" data-toggle="tab">Reenvio de reportes automaticos</a>
                </li>
                @php
                if( in_array($id_user, $ids_permitidos) ){
                  echo '<li class="nav-item">
                    <a class="nav-link" href="#datos_contacto" data-toggle="tab">Contactos y reportes automaticos</a>
                  </li>';
                }
                @endphp
              </ul>
            </div>

            <div class="card-body">
              <div class="tab-content">
    
                <div class="tab-pane active" id="generacion_reportes">
                  <div class="row mt-3 px-3 justify-content-center">

                    <div class="col-sm-12 col-md-4 mb-3" class="div_lista_reportes" style="border: 1px solid #ccc;">
                      <div style="background: #848f33; color: #fff; font-size: 1.2em; font-weight: bold; padding: 5px; text-align: center;">
                        Consulta de Reportes
                      </div>
                      <div class="div_lista_reportes" style="padding: 8px;">
                        <ul class="cont_lista_reportes" style="height: auto;">
                          <li class="lista_reportes activos" onclick="elegirReporte('libertades', this)">Reporte de Reporte de Libertades</li>
                          <li class="lista_reportes "  onclick="elegirReporte('delitos', this)">Reporte de Delitos de Genero</li>
                          <li class="lista_reportes "  onclick="elegirReporte('resolutivos_por_audiencia', this)">Reporte de captura de rosolutivos por audiencia</li>
                          @if( in_array($id_user, $ids_permitidos) )
                            <li class="lista_reportes "  onclick="elegirReporte('resolutivos_audiencia', this)">Reporte de captura de rosolutivos</li>
                            <li class="lista_reportes "  onclick="elegirReporte('medidas_rati_lamv', this)">Reporte de Medidas de proteccion LAMV - Ratificación</li>
                            <li class="lista_reportes "  onclick="elegirReporte('desempeno_juez', this)">Informe de desempeño de juez</li>
                            <li class="lista_reportes "  onclick="elegirReporte('cj_recibidas', this)">Informe de carpetas judiciales recibidas</li>
                            <li class="lista_reportes "  onclick="elegirReporte('contadores_audiencias', this)">Reporte Contadores de Audiencias</li>
                            <li class="lista_reportes "  onclick="elegirReporte('prom_tipos_audiencia', this)">Reporte de cuenta pública</li>
                            <li class="lista_reportes "  onclick="elegirReporte('remisiones_incompetencia', this)">Reporte de remisiones de incompetencia</li>
                          @endif
                          <li class="lista_reportes "  onclick="elegirReporte('suspension_condicional', this)">Reporte de Suspension condicional del proceso</li>
                        </ul>
                      </div>
                    </div>
      
                    <div class="col-sm-12 col-md-8 mb-3 activo_c">
                      <div class="card" id="repsi">
                      </div>
                    </div>
      
                  </div>
                </div>
    
                <div class="tab-pane" id="reenvio_reportes">
                  <div class="row">
                      <div style="width:100%; padding: 5px; background:#848F33; color:#fff; font-size:1.2em; text-align:center;">
                        Reenvio de Correos
                      </div>
                  </div>
      
                  <div class="row my-4 justify-content-center">

                    {{--  <div class="col-md-8">


                      <div class="tablas_collapsadas" data-toggle="collapse" data-target="#multiCollapseExample1" aria-expanded="false"><span>Correos enviados - Agenda de Audiencias</span><span><i class="fas fa-sort-down"></i></span></div>

                      <div class="row mb-3">
                        <div class="col">
                          <div class="collapse" id="multiCollapseExample1">
                            <div class="card card-body">
                              
                              <div class="table-responsive">
                                <table class="table">
                                  <thead>
                                    <tr>
                                      <th>Reporte</th>
                                      <th>Fecha de Envio</th>
                                      <th>Accion</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td>Reporte de Audiencias</td>
                                      <td>2022-02-03 06:00:00</td>
                                      <td>
                                        <i class="fas fa-file-pdf"></i>
                                        <i class="fas fa-file-excel"></i>
                                        <i class="fas fa-send"></i>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>

                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="tablas_collapsadas" data-toggle="collapse" data-target="#multiCollapseExample2" aria-expanded="false"><span>Correos enviados - Libertades</span><span><i class="fas fa-sort-down"></i></span></div>

                      <div class="row mb-3">
                        <div class="col">
                          <div class="collapse" id="multiCollapseExample2">
                            <div class="card card-body">
                              
                              <div class="table-responsive">
                                <table class="table">
                                  <thead>
                                    <tr>
                                      <th>Reporte</th>
                                      <th>Fecha de Envio</th>
                                      <th>Accion</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td>Reporte de Libertades</td>
                                      <td>2022-02-03 06:00:00</td>
                                      <td>
                                        <i class="fas fa-file-excel"></i>
                                        <i class="fas fa-send"></i>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>

                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="tablas_collapsadas" data-toggle="collapse" data-target="#multiCollapseExample3" aria-expanded="false"><span>Correos enviados - Delitos</span><span><i class="fas fa-sort-down"></i></span></div>

                      <div class="row mb-3">
                        <div class="col">
                          <div class="collapse" id="multiCollapseExample3">
                            <div class="card card-body">
                              
                              <div class="table-responsive">
                                <table class="table">
                                  <thead>
                                    <tr>
                                      <th>Reporte</th>
                                      <th>Fecha de Envio</th>
                                      <th>Accion</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td>Reporte de Delitos</td>
                                      <td>2022-02-03 06:00:00</td>
                                      <td>
                                        <i class="fas fa-file-excel"></i>
                                        <i class="fas fa-send"></i>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>

                            </div>
                          </div>
                        </div>
                      </div>

                    </div>  --}}

                      <div class="col-md-4 col-sm-12 col-lg-4 mb-3">
                        <div class="card" style="width: 18rem; margin:0 auto;">
                          <div style="display: flex;justify-content: center;align-items: center;flex-direction: column;width: 100%;height: 100%; font-size: 1.2em; font-weight: bold; padding: 7px;">
                            LIBERTADES
                          </div>
                          <div class="card-body">
                            <button id="reenv_libertades" style="background:#848F33 !important; color:#fff; border:none; width:100%;" class="btn btn-succes" onclick="modalPass('libertades')"><i class="far fa-envelope"></i> Reenviar</button>
                          </div>
                        </div>
                      </div>
  
                      <div class="col-md-4 col-sm-12 col-lg-4 mb-3">
                        <div class="card" style="width: 18rem; margin:0 auto;">
                          <div style="display: flex;justify-content: center;align-items: center;flex-direction: column;width: 100%;height: 100%; font-size: 1.2em; font-weight: bold; padding: 7px;">
                            AUDIENCIAS
                          </div>
                          <div class="card-body">
                            <button id="reenv_audiencias" style="background:#848F33 !important; color:#fff; border:none; width:100%;" class="btn btn-succes" onclick="modalPass('audiencias')"><i class="far fa-envelope"></i> Reenviar</button>
                          </div>
                        </div>
                      </div>
  
                      <div class="col-md-4 col-sm-12 col-lg-4  mb-3">
                        <div class="card" style="width: 18rem; margin:0 auto;">
                          <div style="display: flex;justify-content: center;align-items: center;flex-direction: column;width: 100%;height: 100%; font-size: 1.2em; font-weight: bold; padding: 7px;">
                            DELITOS
                          </div>
                          <div class="card-body">
                            <button id="reenv_delitos" style="background:#848F33 !important; color:#fff; border:none; width:100%;" class="btn btn-succes" onclick="modalPass('delitos')"><i class="far fa-envelope"></i> Reenviar</button>
                          </div>
                        </div>
                      </div>

                  </div>
                </div>
    
                <div class="tab-pane" id="datos_contacto">
                  <div class="menu_correos">
                    <div class="titulo_correos">Configuracion de Correos</div>
      
                    <div class="row mt-2"> {{--row_contenedor --}}
      
                      <div class="col-sm-12 col-md-6 col-lg-6 col-xl-8"> {{-- contenedor_r --}}
                        <div class="title_c">Reportes <button class="adduser" onclick="nuevo_reporte()"><i class="fas fa-folder-plus"></i></button></div>
                        <div class="reportes" id="reportes">
      
                        </div>
                      </div>
      
                      <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4"> {{--contenedor_a--}}
                        <div class="title_c">Contactos <button class="adduser" onclick="nuevo_contacto()"><i class="fas fa-user-plus"></i></button></div>
                        <div class="contactos" id="contactos">
                        </div>
                      </div>
      
                      <div class="clearfix"></div>
                    </div>
      
                  </div>
                </div>
    
              </div>
            </div>

          </div>

        </div>
      @endif
    </div>

@endsection


{{-- Scripts librerias --}}
@section('seccion-scripts-libs')
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/jquery-ui/js/jquery-ui.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/datatables/js/jquery.dataTables.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/datatables-responsive/js/dataTables.responsive.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/select2/js/select2.min.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/moment/js/moment.js"></script>
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
     <script src="https://cdn.datatables.net/colreorder/1.5.3/js/dataTables.colReorder.min.js"></script>
@endsection

{{-- Scripts --}}
@section('seccion-scripts-functions')
  <script>
    const unidades_precargadas = @php echo json_encode($unidades);@endphp;
    const jueces_precargados = @php echo json_encode($jueces);@endphp;
    const inmuebles_precargados = @php echo json_encode($inmuebles);@endphp;
    var id_unidad_sesion = @php echo json_encode($request->session()->get('id_unidad_gestion')); @endphp;

    var reporte_config = {
      'libertades':{
        'titulo':'Reporte de Libertades',
        'icono': 'fas fa-balance-scale',
        'ruta': '/public/descargar_r_libertades'
      },
      'delitos':{
        'titulo': 'Reporte de Delitos de Genero',
        'icono': 'fas fa-venus-mars',
        'ruta': '/public/descargar_r_delitos'
      },
      'resolutivos_audiencia':{
        'titulo': 'Reporte de captura de rosolutivos',
        'icono': 'far fa-list-alt',
        'ruta': '/public/descargar_r_resolutivos_audiencia'
      },
      'resolutivos_por_audiencia':{
        'titulo': 'Reporte de captura de rosolutivos por audiencia',
        'icono': 'far fa-list-alt',
        'ruta': '/public/descargar_r_resolutivos_por_audiencia'
      },
      'desempeno_juez':{
        'titulo': 'Informe de desempeño de juez',
        'icono': 'fas fa-gavel',
        'ruta': '/public/descargar_r_desempeno_juez'
      }, 
      'cj_recibidas':{
        'titulo': 'Informe de carpetas judiciales recibidas',
        'icono': 'fas fa-folder-open',
        'ruta': '/public/descargar_r_cj_recibidas'
      }, 
      'audiencias':{
        'titulo': 'Informe de audiencias',
        'icono': 'far fa-list-alt',
        'ruta': '/public/descargar_r_audiencias'
      }, 
      'sol_recibidas_td':{  
        'titulo': 'Solicitudes recibidas por tipo de delito',
        'icono': 'fas fa-table',
        'ruta': '/public/descargar_r_sol_recibidas_td'
      }, 
      'medidas_rati_lamv':{  
        'titulo': 'Medidas de Proteccion LAMV - RATI',
        'icono': 'fas fa-user-shield',
        'ruta': '/public/descargar_r_medidas_Rati_LAMV'
      },
      'contadores_audiencias':{  
        'titulo': 'Reporte Contadores de Audiencias',
        'icono': 'fas fa-file-signature',
        'ruta': '/public/descargar_r_contadores_audiencias'
      },
      'prom_tipos_audiencia':{  
        'titulo': 'Reporte de cuenta pública',
        'icono': 'far fa-window-restore',
        'ruta': '/public/descargar_r_prom_tipos_audiencia'
      },
      'suspension_condicional':{  
        'titulo': 'Reporte de Suspension condicional del proceso',
        'icono': 'fas fa-user-shield',
        'ruta': '/public/descargar_r_suspension_condicional'
      },
      'remisiones_incompetencia':{  
        'titulo': 'Reporte de remisiones de incompetencia',
        'icono': 'far fa-folder',
        'ruta': '/public/descargar_r_remisiones_incompetencia'
      }
    };


    $(function(){
        //select
        $('.selectable').select2();
        
        //Loader
        setTimeout(function(){
          $('#modal_loading').modal('hide');
        }, 1000);

        obtener_contactos();
        obtener_reportes();
        elegirReporte('libertades');
        console.log('jueces', jueces_precargados);
        console.log('unidades', unidades_precargadas);
        console.log('inmuebles', inmuebles_precargados);  
    });

    //Aqui las function
    function elegirReporte(reporte, obj=null){
      
      var select_unidad = '';
      var select_juez = '';
      var select_tipo = '';
      var select_inmueble = '';

      
      if(reporte == 'resolutivos_por_audiencia' || reporte == 'suspension_condicional'){
        let unidadesss = '<option value="" selected>Seleccionar</option>';
        for(i in unidades_precargadas){
          if(id_unidad_sesion == 0){
            unidadesss += `<option value="${unidades_precargadas[i].id_unidad_gestion}">${unidades_precargadas[i].nombre_unidad}</option>`;
          }else{
            if(unidades_precargadas[i].id_unidad_gestion == id_unidad_sesion){
              unidadesss += `<option selected value="${unidades_precargadas[i].id_unidad_gestion}">${unidades_precargadas[i].nombre_unidad}</option>`;
            }
          }
        }
        select_unidad = `
          <div class="form-group">
            <label for="unidadSeleccionada">Unidad de Gestión</label>
            <select id="unidadSeleccionada" class="form-control select2">
              ${unidadesss}
            </select>
          </div>
        `;
      }

      if(reporte == 'desempeno_juez'){
        //if(jueces_precargados['status'] == 100){
          let juecesss = '<option value="" disabled selected>Seleccionar</option>';
          let data = jueces_precargados;
          for(i in data){
            juecesss += `<option value="${data[i].id_usuario}">[${data[i].cve_juez}] ${data[i].nombres} ${data[i].apellido_paterno} ${data[i].apellido_materno} (${data[i].descripcion})</option>`;
          }
        //}else{
          //juecesss = '<option value="" selected>Seleccionar</option>';
        //}

        select_juez = `
          <div class="form-group">
            <label for="juez_seleccionado">Juez</label>
            <select id="juez_seleccionado" class="form-control select2">
              ${juecesss}
            </select>
          </div>
        `;
      }

      if(reporte == 'cj_recibidas'){
        let unidadesss = '<option value="" disabled selected>Seleccionar</option><option value="-">Todas</option>';

        for(i in unidades_precargadas){
          unidadesss += `<option value="${unidades_precargadas[i].id_unidad_gestion}">${unidades_precargadas[i].nombre_unidad}</option>`;
        }
        select_unidad = `
          <div class="form-group">
            <label for="unidadSeleccionada">Unidad de Gestión</label>
            <select id="unidadSeleccionada" class="form-control select2">
              ${unidadesss}
            </select>
          </div>
        `;
        
        
        select_tipo = `
        <div class="form-group">
          <label for="tipo_carpeta">Tipo Carpeta</label>
          <select id="tipo_carpeta" class="form-control select2">
            <option value="1" selected>Carpeta de Control</option>
            <option value="5">Carpeta de Tribunal enjuiciamiento</option>
            <option value="6">Carpeta de Ejecución</option>
            <option value="9">Carpeta de Ley Nacional</option>
          </select>
        </div>
        `;
      }

      if(reporte == 'audiencias'){
        let inmuebless = '<option value="" disabled selected>Seleccionar</option><option value="0">Todo</option>';

        for(i in inmuebles_precargados){
          inmuebless += `<option value="${inmuebles_precargados[i].id_inmueble}">${inmuebles_precargados[i].nombre_inmueble}</option>`;
        }
        select_inmueble = `
          <div class="form-group">
            <label for="inmuebleSelecc">Inmueble</label>
            <select id="inmuebleSelecc" class="form-control select2">
              ${inmuebless}
            </select>
          </div>
        `;
      }


      var html = `
        <div class="card-header" style="background:#848F33 !important; color:#fff;">
          ${reporte_config[reporte].titulo}
        </div>
        
        <div class="card-body">
          <div class="row">
            <div class="col-md-4">
              <div style="display: flex;justify-content: center;align-items: center;flex-direction: column;width: 100%;height: 100%">
                <i class="${reporte_config[reporte].icono}" style="font-size: 5.2em; color:#848F33 !important;"></i>
              </div>
            </div>
            <div class="col-md-8">
              <form action="" autocomplete="off">
                ${select_inmueble}
                ${select_unidad}
                ${select_juez}
                ${select_tipo}
                <div class="form-group">
                  <label for="fecha_inicio">Fecha inicio</label>
                  <input type="text" class="form-control date" autocomplete="off" id="fecha_inicio" placeholder="Fecha inicio" onChange="input_lleno(this)">
                </div>
                <div class="form-group">
                  <label for="fecha_final">Fecha final</label>
                  <input type="text" class="form-control date" autocomplete="off" id="fecha_final" placeholder="Fecha Final" onChange="input_lleno(this)">
                </div>
              </form>
              <div class="form-group">
                <input type="button" class="bot btn btn-success btnDescargar" onclick="descargarReporte('${reporte}')" value="Consultar">
              </div>
            </div>
          </div>
        </div>
      `;

      $('#repsi').html(html);
      
      if(obj != null){
        $('li.activos').removeClass('activos');
        $(obj).addClass('activos');
      }

      setTimeout(function(){
        $('.select2').select2();

        let fecha_actual = new Date();
        $('.date').datepicker({
          showOtherMonths: true,
          selectOtherMonths: true,
          dateFormat: 'yy-mm-dd',
          changeYear: true,
          yearRange: "c-100:" + fecha_actual.getFullYear()
        });
      },600)
      
    
    }

    function descargarReporte(reporte){
      var validar = revisar_campos(reporte);
      console.log('estatus', validar );
      if(validar.status == 100){

        var inicio = $('#fecha_inicio').val();
        var final =  $('#fecha_final').val();
        var select_unidad = '';
        var select_juez = '';
        var select_carpeta = '';
        var select_inmueble = '';

        if(reporte == 'delitos'){ inicio = inicio +' 00:00:00' ; final = final +' 23:59:59';}
        if(reporte == 'resolutivos_por_audiencia' || reporte == 'suspension_condicional'){ select_unidad = $('#unidadSeleccionada').val();}
        if(reporte == 'desempeno_juez'){ select_juez = $('#juez_seleccionado').val(); }
        if(reporte == 'cj_recibidas'){ 
          select_unidad = $('#unidadSeleccionada').val();
          select_carpeta = $('#tipo_carpeta').val();
        }
        if(reporte == 'audiencias'){ select_inmueble = $('#inmuebleSelecc').val(); }
        
        
        
        $.ajax({
          type:'POST',
          url: reporte_config[reporte].ruta,
          data:{
            fecha_inicio: inicio,
            fecha_final:final,
            id_inmueble: select_inmueble,
            id_unidad: select_unidad,
            id_juez: select_juez,
            tipo_carpeta: select_carpeta
          },beforeSend: function(){
            $('.btnDescargar').html('Consultando...');
            $('.btnDescargar').prop('disabled', true);
            loading(true);
          },
          success:function(response) {
            console.log(response);
            if(response.status==100){
              $('.btnDescargar').html('Consultar');
              $('.btnDescargar').prop('disabled', false);
              window.open(response.response);
              loading(false);
              elegirReporte(reporte);
            }else{
              error(response.message);
              $('.btnDescargar').html('Consultar');
              loading(false);
            }
          }
        }); 
        
      }else{
        $(`${validar.campo}`).addClass('is-invalid');
        error(validar.mensaje);
      }
    }

    // ########## Revisar Campos  ##############
    function revisar_campos(reporte){
      var inicio = $('#fecha_inicio').val();
      var final =  $('#fecha_final').val();

      /*
      if(reporte == 'resolutivos_audiencia'){
        var select_unidad = $('#unidadSeleccionada').val();
        if(select_unidad == '') return {'status':0, 'campo':'#unidadSeleccionada', 'mensaje':'Seleccione una unidad'}
      }
      */

      if(reporte == 'desempeno_juez'){
        var select_juez = $('#juez_seleccionado').val();
        if(select_juez == '') return {'status':0, 'campo':'#juez_seleccionado', 'mensaje':'Seleccione un juez'}
      }

      if(inicio == '') return {'status':0, 'campo':'#fecha_inicio', 'mensaje':'Campo de fecha inicio vacio'}
      if(final == '' ) return {'status':0, 'campo':'#fecha_final', 'mensaje':'Campo de fecha final vacio'}

      return {'status':100};
    }

    function input_lleno(val){
      var input = $('#'+val.id).val();
      if(input.length < 1){
        $('#'+val.id).css('border', '1px solid #ced4da');
      }else{
        $('#'+val.id).css('border', '1px solid #2ECC71');
      }
      
    }

    function get_date( date , format = 'YYYY-MM-DD' ){
      if( format == 'YYYY-MM-DD' && date.substring(0,4).includes('-') ) 
        return date.split('-').reverse().join('-');
      if( format == 'DD-MM-YYYY' && !date.substring(0,4).includes('-') )
        return date.split('-').reverse().join('-');
      if( format == 'YYYY-MM-DD' && date.substring(0,4).includes('/') ) 
        return date.split('-').reverse().join('-');
      if( format == 'DD-MM-YYYY' && !date.substring(0,4).includes('/') )
        return date.split('-').reverse().join('-');
      else
        return date;
    }


    function reenviar(reporte){
      switch(reporte){
        case 'delitos':
          $.ajax({
            type:'POST',
            url:'/public/reenvio_correo',
            data:{
              reporte_tipo: reporte 
            },
            beforeSend: function(){
              $('#reenv_delitos').html('<i class="far fa-envelope"></i>...');
            },
            success:function(response) {
                console.log(response);
                if(response.status==100){
                  success(response.message);
                  $('#reenv_delitos').html('<i class="far fa-envelope"></i> Reenviar');
                }else{
                  error(response.message);
                  $('#reenv_delitos').html('<i class="far fa-envelope"></i> Reenviar');
                }
            }
          }); 
        break;

        case 'libertades': 
          $.ajax({
            type:'POST',
            url:'/public/reenvio_correo',
            data:{
              reporte_tipo: reporte 
            },
            beforeSend: function(){
              $('#reenv_libertades').html('<i class="far fa-envelope"></i>...');
            },
            success:function(response) {
                console.log(response);
                if(response.status==100){
                  success(response.message);
                  $('#reenv_libertades').html('<i class="far fa-envelope"></i> Reenviar');
                }else{
                  error(response.message);
                  $('#reenv_libertades').html('<i class="far fa-envelope"></i> Reenviar');
                }
            }
          }); 
        break;

        case 'audiencias': 
          $.ajax({
            type:'POST',
            url:'/public/reenvio_correo',
            data:{
              reporte_tipo: reporte 
            },
            beforeSend: function(){
              $('#reenv_audiencias').html('<i class="far fa-envelope"></i>...');
            },
            success:function(response) {
                console.log(response);
                if(response.status==100){
                  success(response.message);
                  $('#reenv_audiencias').html('<i class="far fa-envelope"></i> Reenviar');
                }else{
                  error(response.message);
                  $('#reenv_audiencias').html('<i class="far fa-envelope"></i> Reenviar');
                }
            }
          }); 
        break;
      }
    }

    function success(mensaje){
      $('#messageExito').html(mensaje);
      $('#modalSuccess').modal('show');
    }

    function error(mensaje){
      $('#messageError2').html(mensaje);
      $('#modalError2').modal('show');
    }

    function modal_error(mensaje,modalAnterior=null){
      $('#messageError').html(`${mensaje}`);
      $('#btnCerrarError').attr('data-modal',modalAnterior!=null?modalAnterior:'');
      if( modalAnterior!=null ) $('#'+modalAnterior).modal('hide');
      $('#modalError').modal('show');
    }

    function verificarPass(){
      
      var pass = $('#clave').val();
      var correo = $('#correo_sd').val();
      
      if(pass < 1){
        $('#clave').css('border', '1px solid #E74C3C');
        $('#alertaVacio').css('display', 'block');
      }else{
        $('#alertaVacio').css('display', 'none');
        $('#clave').css('border', '1px solid #ced4da');
        
        $.ajax({
          type:'POST',
          url:'/public/validacion_password',
          data:{
            pass_correo: pass 
          },
          beforeSend: function(){
            $('#verificar_btn').html('Verificando...');
          },
          success:function(response) {
              console.log(response);
              if(response.status==100){
                reenviar(correo)
                console.log(response.response);
                $('#verificar_btn').html('Verificar');
                $('#clave').val('');
                $('#modalClave').modal('hide');
              }else{
                $('#modalClave').modal('hide');
                error(response.response);
                $('#clave').val('');
                $('#verificar_btn').html('Verificar');
              }
          }
        }); 
      }
    }
    
    function modalPass(correo){
      $('#modalClave').modal('show');
      $('#correo_sd').val(correo);
    }

    function verPass(){
      var pass = $('#clave').attr('type');
      if(pass == 'password'){
        $('#clave').attr('type','text');
      }else{
        $('#clave').attr('type','password');
      }
    }

    function loader(accion){
      if(accion){
        $('#loader').modal('show');
      }else{
        setTimeout(function(){ $('#loader').modal('hide'); }, 500);
      }
    }

    function loading(accion){
      if(accion){
        $('#modal_loading').modal('show');
      }else{
        setTimeout(function(){ $('#modal_loading').modal('hide'); }, 500);
      }
    }
    /*
    function abrir_menu_correos(){
      $('.menu_correos').toggle("slow");
    }
    */

    function abrir_body(id){
      $('#'+id).toggle();
    }

    function abrirBodyContacto(id){
      $('#'+id).toggle();
    }

    function cerrar_modal(valor){
      $("#"+valor).modal('hide');
    }

    function obtener_reportes(){
      $.ajax({
        type:'POST',
        url:'/public/obtener_reportes_programados',
        data:{
        },
        success:function(response) {
          console.log(response);
          if(response.status = 100){
            var datos = response.response;
            var reportes = '';
            for(i=0; i < datos.length; i++){

              reportes += ` <div class="reporte">
                              <div class="title-reporte">
                                <div class="button_reporte_collapse" onclick="abrir_body('reporte_body_${datos[i].id_reporte}')"><i class="fas fa-sort-down"></i></div>
                                ${datos[i].titulo}
                                <div class="button_reporte_config" onclick="rellenarCamposReporte(${datos[i].id_reporte}, '${datos[i].titulo}', '${datos[i].remitente}', '${datos[i].nombre_remitente}')"><i class="fas fa-edit"></i></div>
                              </div>
                              <div class="body_reporte" id="reporte_body_${datos[i].id_reporte}">`;
              if(datos[i].contactos.length > 0){
                
                reportes += `<div style="font-size: 0.9em;border-bottom: 1px solid #ccc;padding: 8px 0;">Destinatarios</div>`;

                for(j=0; j < datos[i].contactos.length; j++){

                  if(datos[i].contactos[j].tipo_correo == 'principal'){

                    var inicial = datos[i].contactos[j].nombre_contacto.substring(0,1);
                    var color = JSON.parse(datos[i].contactos[j].color);
                    if(datos[i].contactos[j].apellidoM_contacto === null){
                      var apellidoM_contacto = '';
                    }else{
                      apellidoM_contacto = datos[i].contactos[j].apellidoM_contacto;
                    }
                  
                    reportes += ` <div class="col-md-12 contacto my-2">
                                      <div class="image_contact">
                                        <div class="imagen" style="background:${color[0].background}; color: ${color[0].color}"> ${inicial} </div>
                                      </div>
                                      <div class="info_contact">
                                        <div class="nombre_contact">${datos[i].contactos[j].nombre_contacto} ${datos[i].contactos[j].apellidoP_contacto} ${apellidoM_contacto}</div>
                                        <div class="correo_contact">${datos[i].contactos[j].correo_contacto}</div>
                                      </div>
                                      <div class="button_contact">
                                        <i class="fas fa-minus" title="Remover de ${datos[i].titulo}" onclick="removerContactoMensaje(${datos[i].id_reporte}, ${datos[i].contactos[j].id_contacto}, '${datos[i].contactos[j].nombre_contacto}', '${datos[i].contactos[j].apellidoP_contacto}', '${datos[i].titulo}' )"></i>
                                      </div>
                                      <div class="clearfix"></div>
                                  </div>`;
                  }
                }
                reportes += `<div style="font-size: 0.9em;border-bottom: 1px solid #ccc;padding: 8px 0;">Destinatarios (CC)</div>`;

                for(j=0; j < datos[i].contactos.length; j++){

                  if(datos[i].contactos[j].tipo_correo == 'copia'){

                    var inicial = datos[i].contactos[j].nombre_contacto.substring(0,1);
                    var color = JSON.parse(datos[i].contactos[j].color);
                    if(datos[i].contactos[j].apellidoM_contacto === null){
                      var apellidoM_contacto = '';
                    }else{
                      apellidoM_contacto = datos[i].contactos[j].apellidoM_contacto;
                    }
                  
                    reportes += ` <div class="col-md-12 contacto my-2">
                                      <div class="image_contact">
                                        <div class="imagen" style="background:${color[0].background}; color: ${color[0].color}"> ${inicial} </div>
                                      </div>
                                      <div class="info_contact">
                                        <div class="nombre_contact">${datos[i].contactos[j].nombre_contacto} ${datos[i].contactos[j].apellidoP_contacto} ${apellidoM_contacto}</div>
                                        <div class="correo_contact">${datos[i].contactos[j].correo_contacto}</div>
                                      </div>
                                      <div class="button_contact">
                                        <i class="fas fa-minus" title="Remover de ${datos[i].titulo}" onclick="removerContactoMensaje(${datos[i].id_reporte}, ${datos[i].contactos[j].id_contacto}, '${datos[i].contactos[j].nombre_contacto}', '${datos[i].contactos[j].apellidoP_contacto}', '${datos[i].titulo}' )"></i>
                                      </div>
                                      <div class="clearfix"></div>
                                  </div>`;
                  }
                }

              }else{
                reportes +=`<div style="text-align: center; color: #444; font-size: 0.8em; border: 1px solid #ccc; padding: 8px;">No cuentas con contactos</div>`
              }

              reportes +=     `</div>
                            </div>`;
            }

            $('#reportes').html(reportes);
          }else{
            var sin_datos = `<div style="text-align: center; color: #444; font-size: 1.2em; border: 1px solid #ccc; padding: 8px;">No cuentas con reportes programados</div>`;
            $('#reportes').html(sin_datos);
          }
        }
      }); 
    }

    function obtener_contactos(){
      $.ajax({
        type:'POST',
        url:'/public/obtener_contactos',
        data:{
        },
        success:function(response) {
          console.log(response);
          if(response.status = 100){
            var datos = response.response;
            var contactos = '';
            for(i=0; i < datos.length; i++){

              var inicial = datos[i].nombre_contacto.substring(0,1);
              var color = JSON.parse(datos[i].color);
              if(datos[i].apellidoM_contacto === null){
                var apellidoM_contacto = '';
              }else{
                apellidoM_contacto = datos[i].apellidoM_contacto;
              }

              contactos += ` <div class="col-md-12 contacto my-2">
                                <div class="image_contact">
                                  <div class="imagen" style="background:${color[0].background}; color: ${color[0].color}"> ${inicial} </div>
                                </div>
                                <div class="info_contact">
                                  <div class="nombre_contact">${datos[i].nombre_contacto} ${datos[i].apellidoP_contacto} ${apellidoM_contacto}</div>
                                  <div class="correo_contact">${datos[i].correo_contacto}</div>
                                </div>
                                <div class="button_contact">
                                  <i class="fas fa-plus" onclick="abrirBodyContacto('contacto_body_${datos[i].id_contacto}')"></i>
                                  <i class="fas fa-edit" onclick="rellenarCamposContacto(${datos[i].id_contacto},'${datos[i].nombre_contacto}','${datos[i].apellidoP_contacto}','${apellidoM_contacto}','${datos[i].correo_contacto}', '${color[0].background}','${color[0].color}')"></i>
                                  <i class="fas fa-trash" onclick="mensajeDelete(${datos[i].id_contacto},'${datos[i].nombre_contacto}','${datos[i].apellidoP_contacto}')"></i>
                                </div>
                                <div class="clearfix"></div>
                                <div class="body_contacto" id="contacto_body_${datos[i].id_contacto}">`;
                                  
                  for(j=0; j < datos[i].reportes.length; j++){
                    
                    if(datos[i].reportes[j].unido == true){
                      checked = 'checked';
                      guardado = '1';
                    }else{
                      checked = '';
                      guardado = '0';
                    }

                    let checked1 = '';
                    let checked2 = '';

                    if(datos[i].reportes[j].tipo_reporte == 'principal'){
                       checked1 = 'checked';
                    }
                    else  if(datos[i].reportes[j].tipo_reporte == 'copia'){
                     checked2  = 'checked';
                    }else{
                       checked1 = 'checked';
                    }


                    contactos += ` <label class="checks">
                                    <input class="form-check-input position-static" type="checkbox" ${checked} asignado="${guardado}" class="checky" value="${datos[i].reportes[j].id_reporte}" aria-label="">
                                    ${datos[i].reportes[j].titulo}
                                  </label>
                                  <div style="display: flex; justify-content: flex-start;">
                                    <div class="form-check" style="font-size: 0.9em; margin: 0 2%;">
                                      <input class="form-check-input position-static" ${checked1} type="radio" name="tipo_reporte_${datos[i].reportes[j].id_reporte}_${datos[i].id_contacto}" id="tipo_reporte_${datos[i].reportes[j].id_reporte}_${datos[i].id_contacto}" value="principal" aria-label="...">
                                      Principal
                                    </div>
                                    <div class="form-check" style="font-size: 0.9em; margin: 0 2%;">
                                      <input class="form-check-input position-static" ${checked2} type="radio" name="tipo_reporte_${datos[i].reportes[j].id_reporte}_${datos[i].id_contacto}" id="tipo_reporte_${datos[i].reportes[j].id_reporte}_${datos[i].id_contacto}" value="copia" aria-label="...">
                                      Copia
                                    </div>
                                  </div>
                                  `;   
                  }
              contactos += `      <div class="joinReporte" onclick="asignarContacto('contacto_body_${datos[i].id_contacto}', ${datos[i].id_contacto})">
                                    <i class="fas fa-save"></i>
                                  </div>
                                </div>
                            </div>`;
            }

            $('#contactos').html(contactos);
          }else{
            var sin_datos = `<div style="text-align: center; color: #444; font-size: 1.2em; border: 1px solid #ccc; padding: 8px;">No cuentas con contactos</div>`;
            $('#contactos').html(sin_datos);
          }
        }
      }); 
    }

    function removerContactoMensaje(id_reporte, id_contacto, nombre_contacto, apellido_contacto, titulo){
      $('#id_conctato_remove').val(id_reporte);
      $('#id_reporte_remove').val(id_contacto);
      $('#nombre_remove').val(nombre_contacto);
      $('#apellido_remove').val(apellido_contacto);
      $('#titulo_remove').val(titulo);

      $('#nombre_contacto_k').html(nombre_contacto+' '+apellido_contacto);
      $('#titulo_k').html(titulo);
      
      $('#remove_contacto').modal('show');
    }

    function removerContacto(){
      id_reporte = $('#id_conctato_remove').val();
      id_contacto = $('#id_reporte_remove').val();
      nombre_contacto = $('#nombre_remove').val();
      apellido_contacto = $('#apellido_remove').val();

      nombre_completo = nombre_contacto + ' ' +apellido_contacto;

      $.ajax({
        type:'POST',
        url:'/public/removerContacto',
        data:{
          id_reporte:id_reporte,
          id_contacto:id_contacto,
          nombre_completo : nombre_completo
        },
        success:function(response) {
          if(response.status  == 100){
            $('#remove_contacto').modal('hide');
            success(response.response);
            obtener_reportes();
          }else{
            modal_error(response.response, 'remove_contacto');
          }
        }
      });
    }

    function nuevo_reporte(){
      $('#nuevo_reporte').modal('show');
    }

    function nuevo_contacto(){
      var color = color_random();
      
      $('#letra').css(color);
      $('#color_bolita_b').val(color.background);
      $('#color_bolita_c').val(color.color);
      $('#nuevo_contacto').modal('show');
    }

    function color_random(){
      colores = [
        {background:'#C0392B', color:'#fff'},
        {background:'#E74C3C', color:'#fff'},
        {background:'#9B59B6', color:'#fff'},
        {background:'#8E44AD', color:'#fff'},
        {background:'#2980B9', color:'#fff'},
        {background:'#3498DB', color:'#fff'},
        {background:'#7D3C98', color:'#fff'},
        {background:'#117A65', color:'#fff'},
        {background:'#D35400', color:'#fff'},
        {background:'#2980B9', color:'#fff'},
        {background:'#900c3f', color:'#fff'},
        {background:'#F1C40F', color:'#444'},
        {background:'#FFA07A', color:'#444'},
        {background:'#FA8072', color:'#444'},
        {background:'#FFC0CB', color:'#444'},
        {background:'#F0E68C', color:'#444'},
        {background:'#E6E6FA', color:'#444'}
      ];

      numero = Math.floor(Math.random() * ((16+1)-0)+0);

      return colores[numero];

    }

    function cambiarColor(back,colors){
      var color = color_random();

      $('#letra').css(color);
      $('#letra_edit').css(color);
      $('#'+back).val(color.background);
      $('#'+colors).val(color.color);
    }

    function letra_validate(obj){
      var valor = obj.value;

      if(valor.length > 0){
        $('#letra').html(valor.substring(0,1));
        $(obj).css({border:'1px solid #28B463'});
      }else{
        $('#letra').html('?');
        $(obj).css({border:'1px solid #ced4da'});
      }
    }

    function validate_campo(obj){
      var valor = obj.value;

      if(valor.length > 0){
        $(obj).css({border:'1px solid #28B463'});
      }else{
        $(obj).css({border:'1px solid #ced4da'});
      }
    }

    function limpiarCampos(){
      $("#frm_nuevo_contacto select").each(function() { this.selectedIndex = 0 });
      $("#frm_nuevo_contacto input[type=text] , #frm_nuevo_contacto textarea, #frm_nuevo_contacto input[type=email]").each(function() { this.value = '' });
      $("#frm_nuevo_contacto input[type=text] , #frm_nuevo_contacto textarea, #frm_nuevo_contacto input[type=email]").each(function() { this.style.border = '1px solid #ced4da' });
      $('#letra').html('?');

      $("#frm_editar_contacto select").each(function() { this.selectedIndex = 0 });
      $("#frm_editar_contacto input[type=text] , #frm_editar_contacto textarea, #frm_editar_contacto input[type=email]").each(function() { this.value = '' });
      $("#frm_editar_contacto input[type=text] , #frm_editar_contacto textarea, #frm_editar_contacto input[type=email]").each(function() { this.style.border = '1px solid #ced4da' });
    

      $("#frm_nuevo_reporteo input[type=text] , #frm_nuevo_reporteo textarea, #frm_nuevo_reporteo input[type=email]").each(function() { this.value = '' });
      $("#frm_nuevo_reporteo input[type=text] , #frm_nuevo_reporteo textarea, #frm_nuevo_reporteo input[type=email]").each(function() { this.style.border = '1px solid #ced4da' });
    
    
    }

    function asignarContacto(bandeja, id_contacto){

      let asignados = [];

      $("#"+bandeja+" input[type=checkbox]:checked").each(function(){
  
        if($(this).attr('asignado') == 0){
          let valor_check = $(this).val();
          let tipo = $('input[name="tipo_reporte_'+valor_check+'_'+id_contacto+'"]:checked').val();

          if(tipo === undefined){
            tipo = 'principal';
          }

          asignados.push( 
                          {
                            "id_reporte":valor_check, 
                            "tipo_reporte":tipo
                          }
                        );

        }else if($(this).attr('asignado') == 1){
          let valor_check = $(this).val();
          let tipo = $('input[name="tipo_reporte_'+valor_check+'_'+id_contacto+'"]:checked').val();

          asignados.push( 
                          {
                            "id_reporte":valor_check, 
                            "tipo_reporte":tipo
                          }
                        );
        }
      });

      console.log(asignados);

       
      $.ajax({
        type:'POST',
        url:'/public/asignar_contacto',
        data:{
          id_contacto:id_contacto,
          asignados:asignados
        },
        success:function(response) {
          if(response.status  == 100){
            success(response.response);
            obtener_reportes();
            obtener_contactos();
          }else{
            error(response.response);
          }
        }
      });
      
    }

    function guardarContacto(){
      var nombre = $('#nombre_rc').val();
      var apaterno = $('#app_rc').val();
      var amaterno = $('#apm_rc').val();
      var correo = $('#email_rc').val();
      var reporte = $('#reporte_rc').val();
      var background = $('#color_bolita_b').val();
      var color = $('#color_bolita_c').val();

      console.log(nombre,apaterno,amaterno,correo,reporte,color);

      if(nombre.length < 1 || apaterno.length < 1 || correo.length < 1){
        $('#camposempty').fadeIn('slow');
        setTimeout(function(){
          $('#camposempty').fadeOut('slow');
        }, 3000);
      }else{
        $.ajax({
          type:'POST',
          url:'/public/guardar_contacto',
          data:{
            nombre:nombre,
            apaterno:apaterno,
            amaterno:amaterno,
            correo:correo,
            reporte:reporte,
            background:background,
            color:color
          },
          success:function(response) {
            if(response.status  == 100){
              limpiarCampos();
              $('#nuevo_contacto').modal('hide');
              success(response.response);
              obtener_contactos();
            }else{
              modal_error(response.response, 'nuevo_contacto');
            }
          }
        });

      }

    }

    function guardarReporte(){
      var titulo = $('#titulo_rc').val();
      var remitente = $('#remitente_rc').val();
      var nombre_remitente = $('#nmbreR_rc').val();


      console.log(titulo,remitente,nombre_remitente);

      if(titulo.length < 1 || remitente.length < 1 || nombre_remitente.length < 1){
        $('#camposempty').fadeIn('slow');
        setTimeout(function(){
          $('#camposempty').fadeOut('slow');
        }, 3000);
      }else{
        $.ajax({
          type:'POST',
          url:'/public/guardar_reporte_programado',
          data:{
            titulo:titulo,
            remitente:remitente,
            nombre_remitente:nombre_remitente,
          },
          success:function(response) {
            if(response.status  == 100){
              limpiarCampos();
              $('#nuevo_reporte').modal('hide');
              success(response.response);
              obtener_reportes();
            }else{
              modal_error(response.response, 'nuevo_reporte');
            }
          }
        });

      }

    }

    function rellenarCamposReporte(id, titulo, remitente, nombre_remitente){
      $('#titulo_rc_edit').val(titulo);
      $('#remitente_rc_edit').val(remitente);
      $('#nmbreR_rc_edit').val(nombre_remitente);
      $('#id_reporte_editable').val(id);

      $('#editar_reporte').modal('show');
    }

    function rellenarCamposContacto(id, nombre, apaterno, amaterno, correo, background,color){
      $('#nombre_rc_edit').val(nombre);
      $('#app_rc_edit').val(apaterno);
      $('#apm_rc_edit').val(amaterno);
      $('#email_rc_edit').val(correo);
      $('#id_rc_edit').val(id);
      $('#letra_edit').css({background: background, color:color});
      $('#letra_edit').html(nombre.substring(0,1));
      $('#color_bolita_b_edit').val(background);
      $('#color_bolita_c_edit').val(color);

      $('#editar_contacto').modal('show');
    }

    function editarContacto(){
      var nombre = $('#nombre_rc_edit').val();
      var apaterno = $('#app_rc_edit').val();
      var amaterno = $('#apm_rc_edit').val();
      var correo = $('#email_rc_edit').val();
      var id = $('#id_rc_edit').val();
      var background = $('#color_bolita_b_edit').val();
      var color = $('#color_bolita_c_edit').val();

      if(nombre.length < 1 || apaterno.length < 1 || correo.length < 1){
        $('#camposempty1').fadeIn('slow');
        setTimeout(function(){
          $('#camposempty1').fadeOut('slow');
        }, 3000);
      }else{
        $.ajax({
          type:'POST',
          url:'/public/actualizar_contacto',
          data:{
            id:id,
            nombre:nombre,
            apaterno:apaterno,
            amaterno:amaterno,
            correo:correo,
            background:background,
            color:color
          },
          success:function(response) {
            if(response.status  == 100){
              limpiarCampos();
              $('#editar_contacto').modal('hide');
              success(response.response);
              obtener_contactos();
            }else{
              modal_error(response.response, 'editar_contacto');
            }
          }
        });
      }
    } 

    function editarReporte(){
      var titulo= $('#titulo_rc_edit').val();
      var remitente= $('#remitente_rc_edit').val();
      var nombre_remitente= $('#nmbreR_rc_edit').val();
      var id= $('#id_reporte_editable').val();

      if(titulo.length < 1 || remitente.length < 1 || nombre_remitente.length < 1){
        $('#camposempty').fadeIn('slow');
        setTimeout(function(){
          $('#camposempty').fadeOut('slow');
        }, 3000);
      }else{
        $.ajax({
          type:'POST',
          url:'/public/actualizar_reporte_programado',
          data:{
            id:id,
            titulo:titulo,
            remitente:remitente,
            nombre_remitente:nombre_remitente,
          },
          success:function(response) {
            if(response.status  == 100){
              limpiarCampos();
              $('#editar_reporte').modal('hide');
              success(response.response);
              obtener_reportes();
            }else{
              modal_error(response.response, 'editar_reporte');
            }
          }
        });

      }

    } 

    function mensajeDelete(id,nombre,apellido){
      $('#id_delete').val(id);
      $('#nombre_delete').val(nombre);
      $('#apellido_delete').val(apellido);

      $('#nombre_contacto_f').html(nombre+' '+apellido);
      $('#delete_contacto').modal('show');
    }

    function eliminarContacto(){
      var nombre = $('#nombre_delete').val();
      var apaterno = $('#apellido_delete').val();
      var id = $('#id_delete').val();

      $.ajax({
        type:'POST',
        url:'/public/eliminar_contacto',
        data:{
          id:id,
          nombre:nombre,
          apellido:apaterno
        },
        success:function(response) {
          if(response.status  == 100){
            $('#delete_contacto').modal('hide');
            success(response.response);
            obtener_contactos();
          }else{
            modal_error(response.response, 'delete_contacto');
          }
        }
      });
    }

  </script>
@endsection


@section('seccion-modales')
  <div id="modalSuccess" class="modal fade"  data-backdrop="static" data-keyboard="false" style="display: none">
    <div class="modal-dialog" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-body tx-center pd-y-20 pd-x-20">
          <i class="icon ion-ios-checkmark-outline tx-100 tx-success lh-1 mg-t-20 d-inline-block"></i>
          <h4 class="tx-success tx-semibold mg-b-20">Hecho!</h4>
          <div id="messageExito">
          </div>
        </div><!-- modal-body -->
        <div class="modal-footer d-flex">
          <button type="button" class="btn btn-primary pd-x-25 mg-l-auto" data-dismiss="modal" aria-label="Close" >Aceptar</button>
        </div>
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
  </div>

  <div id="modalError" class="modal fade" data-backdrop="static" data-keyboard="false" style="display: none;">
    <div class="modal-dialog" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-body tx-center pd-y-20 pd-x-20">
          <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button> -->
          <i class="icon icon ion-ios-close-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
          <h4 class="tx-danger mg-b-20">Datos incompletos</h4>
          <p class="mg-b-20 mg-x-20" id="messageError"></p>
          <button type="button" class="btn btn-danger pd-x-25 cerrar-modal" data-modal="" data-thismodal="modalError" id="btnCerrarError">Aceptar</button>
        </div><!-- modal-body -->
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
  </div><!-- modal -->

  <div id="modalError2" class="modal fade" data-backdrop="static" data-keyboard="false" style="display: none;">
    <div class="modal-dialog" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-body tx-center pd-y-20 pd-x-20">
          <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button> -->
          <i class="icon icon ion-ios-close-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
          <h4 class="tx-danger mg-b-20">Datos incompletos</h4>
          <p class="mg-b-20 mg-x-20" id="messageError2"></p>
          <button type="button" class="btn btn-danger pd-x-25"  data-dismiss="modal" id="btnCerrarError">Aceptar</button>
        </div><!-- modal-body -->
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
  </div><!-- modal -->

  <div id="modalWarning" class="modal fade"  data-backdrop="static" data-keyboard="false" style="display: none">
    <div class="modal-dialog" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-body tx-center pd-y-20 pd-x-20">
          <i class="icon ion-warning-outline tx-100 tx-warning lh-1 mg-t-20 d-inline-block"></i>
          <h4 class="tx-warning tx-semibold mg-b-20">Advertencia!</h4>
          <div>
            Hay Campos vacios
          </div>
        </div><!-- modal-body -->
        <div class="modal-footer d-flex">
          <button type="button" class="btn btn-primary pd-x-25 mg-l-auto" data-dismiss="modal" aria-label="Close" >Aceptar</button>
        </div>
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
  </div>

  <div id="modalClave" class="modal fade"  data-backdrop="static" data-keyboard="false" style="display: none">
    <div class="modal-dialog" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-header pd-x-20" style="background:#848F33 !important; color:#fff !important;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body tx-center pd-y-20 pd-x-20">
          <h5 class="tx-success tx-semibold mg-b-20">Clave de autorización</h5>
          <input type="hidden" id="correo_sd">
          <div class="form-group" id="cmp_clave">
              <input type="password" class="form-control" id="clave" placeholder="Clave" autocomplete="nepe">
            <span id="alertaVacio">El campo esta vacio</span>
            <i class="fas fa-eye" onclick="verPass()"></i>
          </div>
          <button id="verificar_btn" class="btn btn-success" style="background:#848F33 !important; color:#fff;" onclick="verificarPass()">Verificar</button>
        </div>
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
  </div>

  <div id="loader" class="modal fade"  data-backdrop="static" data-keyboard="false" style="display: none">
    <div class="modal-dialog" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-body tx-center pd-y-20 pd-x-20" style="background: rgba(0,0,0,0.7);">
          <h5 style="color:#fff;">Consultando Reporte</h5>
          <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
        </div>
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
  </div>

  <div id="nuevo_contacto" class="modal fade" data-backdrop="static" data-keyboard="false" style="display: none">
    <div class="modal-dialog modal-lg mg-b-100" role="document" style="width: -webkit-fill-available; max-width: 1000px!important;">
        <div class="modal-content tx-size-sm">
            <div class="modal-header pd-x-20" style="background:#848F33 !important; color:#fff !important;">
            <h5 class="modal-title" >Nuevo Contacto</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="cerrar_modal('nuevo_contacto')">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body pd-x-20 pd-t-0 pd-b-0" id="frm_nuevo_contacto">
              <input type="hidden" id="color_bolita_b">
              <input type="hidden" id="color_bolita_c">
              <div class="row mt-2">
                <div class="col-md-3">
                  <div class="Letra" id="letra" style="background:#900c3f; color:#fff;">
                    ?
                  </div>
                  <div class="refresh" onclick="cambiarColor('color_bolita_b','color_bolita_c')">
                    <i class="fas fa-refresh"></i>
                  </div>
                </div>
                <div class="col-md-9">
                  <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-control-label">Nombre <span class="tx-danger">*</span> :</label>
                            <input type="text" class="form-control" id="nombre_rc" name="nombre_rc" placeholder="Nombre" value="" onkeyup="letra_validate(this)" style="text-transform: capitalize;">
                        </div>
                    </div>
                  
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-control-label">Apellido Paterno <span class="tx-danger">*</span> :</label>
                            <input type="text" class="form-control" id="app_rc" name="app_rc" placeholder="Apellido Paterno" value="" onchange="validate_campo(this)" style="text-transform: capitalize;">
                        </div>
                    </div>
                  
                    <div class="col-md-4">
                      <div class="form-group">
                          <label class="form-control-label">Apellido Materno: </label>
                          <input type="text" class="form-control" id="apm_rc" name="apm_rc" placeholder="Apellido Materno" value="" style="text-transform: capitalize;">
                      </div>
                    </div>
                  
                  </div>
                </div>
              </div>
              <div class="row mt-2">
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="form-control-label">Correo <span class="tx-danger">*</span> :</label>
                    <input type="email" class="form-control" id="email_rc" name="email_rc" placeholder="Correo" value="" onchange="validate_campo(this)" autocomplete="off">
                  </div>
                </div>
                {{--  <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-control-label">Asociar a reporte: </label>
                    <select name="reporte_rc" id="reporte_rc" class="form-control">
                      <option selected disabled value="">Elige una opcion</option>
                      <option value="123">Audiencias Programadas</option>
                      <option value="123">Delitos de Genero</option>
                    </select>
                  </div>
                </div>  --}}
              </div>
            
              <div  id="camposempty" class="alert alert-warning alert-dismissible" role="alert" style="display: none;">
                <strong>Lo sentimos!</strong> Existen campos obligatorios vacios.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            
            </div>
            <div class="modal-footer d-flex" id="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="cerrar_modal('nuevo_contacto')">Cerrar</button>
                <button type="button" class="btn btn-secondary " onclick="guardarContacto()" style="background:#848F33 !important; color:#fff;"  id="btn_guardarContacto">Guardar</button>
            </div>
        </div>
    </div>
  </div>

  <div id="nuevo_reporte" class="modal fade" data-backdrop="static" data-keyboard="false" style="display: none">
    <div class="modal-dialog modal-lg mg-b-100" role="document" style="width: -webkit-fill-available; max-width: 1000px!important;">
        <div class="modal-content tx-size-sm">
            <div class="modal-header pd-x-20" style="background:#848F33 !important; color:#fff !important;">
            <h5 class="modal-title" >Nuevo Reporte</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="cerrar_modal('nuevo_reporte')">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body pd-x-20 pd-t-0 pd-b-0" id="frm_nuevo_reporte">
              <div class="row mt-2">
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-control-label">Titulo <span class="tx-danger">*</span> :</label>
                            <input type="text" class="form-control" id="titulo_rc" name="titulo_rc" placeholder="Titulo" value="" onkeyup="validate_campo(this)">
                        </div>
                    </div>
                  
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-control-label">Remitente <span class="tx-danger">*</span> :</label>
                            <input type="email" class="form-control" readonly id="remitente_rc" name="remitente_rc" placeholder="Remitente" value="notificaciones.sgjp@tsjcdmx.gob.mx" onchange="validate_campo(this)" >
                        </div>
                    </div>
                  
                    <div class="col-md-4">
                      <div class="form-group">
                          <label class="form-control-label">Nombre Remitente <span class="tx-danger">*</span> : </label>
                          <input type="text" class="form-control" id="nmbreR_rc" name="nmbreR_rc" placeholder="Nombre remitente" value="TSJ CDMX" onkeyup="validate_campo(this)" style="text-transform: uppercase;">
                      </div>
                    </div>
                  
                  </div>
                </div>
              </div>
            
              <div  id="camposempty" class="alert alert-warning alert-dismissible" role="alert" style="display: none;">
                <strong>Lo sentimos!</strong> Existen campos obligatorios vacios.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            
            </div>
            <div class="modal-footer d-flex" id="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="cerrar_modal('nuevo_reporte')">Cerrar</button>
                <button type="button" class="btn btn-secondary " onclick="guardarReporte()" style="background:#848F33 !important; color:#fff;"  id="btn_guardarContacto">Guardar</button>
            </div>
        </div>
    </div>
  </div>

  <div id="editar_reporte" class="modal fade" data-backdrop="static" data-keyboard="false" style="display: none">
    <div class="modal-dialog modal-lg mg-b-100" role="document" style="width: -webkit-fill-available; max-width: 1000px!important;">
        <div class="modal-content tx-size-sm">
            <div class="modal-header pd-x-20" style="background:#848F33 !important; color:#fff !important;">
            <h5 class="modal-title" >Nuevo Reporte</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="cerrar_modal('editar_reporte')">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body pd-x-20 pd-t-0 pd-b-0" id="frm_editar_reporte">
              <input type="hidden" id="id_reporte_editable">
              <div class="row mt-2">
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-control-label">Titulo <span class="tx-danger">*</span> :</label>
                            <input type="text" class="form-control" id="titulo_rc_edit" name="titulo_rc_edit" placeholder="Titulo" value="" onkeyup="validate_campo(this)">
                        </div>
                    </div>
                  
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-control-label">Remitente <span class="tx-danger">*</span> :</label>
                            <input type="email" class="form-control" readonly id="remitente_rc_edit" name="remitente_rc_edit" placeholder="Remitente" value="notificaciones.sgjp@tsjcdmx.gob.mx" onchange="validate_campo(this)" >
                        </div>
                    </div>
                  
                    <div class="col-md-4">
                      <div class="form-group">
                          <label class="form-control-label">Nombre Remitente <span class="tx-danger">*</span> : </label>
                          <input type="text" class="form-control" id="nmbreR_rc_edit" name="nmbreR_rc_edit" placeholder="Nombre remitente" value="TSJ CDMX" onkeyup="validate_campo(this)" style="text-transform: uppercase;">
                      </div>
                    </div>
                  
                  </div>
                </div>
              </div>
            
              <div  id="camposempty" class="alert alert-warning alert-dismissible" role="alert" style="display: none;">
                <strong>Lo sentimos!</strong> Existen campos obligatorios vacios.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            
            </div>
            <div class="modal-footer d-flex" id="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="cerrar_modal('editar_reporte')">Cerrar</button>
                <button type="button" class="btn btn-secondary " onclick="editarReporte()" style="background:#848F33 !important; color:#fff;"  id="btn_guardarContacto">Actualizar</button>
            </div>
        </div>
    </div>
  </div>

  <div id="editar_contacto" class="modal fade" data-backdrop="static" data-keyboard="false" style="display: none">
    <div class="modal-dialog modal-lg mg-b-100" role="document" style="width: -webkit-fill-available; max-width: 1000px!important;">
        <div class="modal-content tx-size-sm">
            <div class="modal-header pd-x-20" style="background:#848F33 !important; color:#fff !important;">
            <h5 class="modal-title" >Actualizar Contacto</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="cerrar_modal('editar_contacto')">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body pd-x-20 pd-t-0 pd-b-0" id="frm_editar_contacto">
              <input type="hidden" id="id_rc_edit">
              <input type="hidden" id="color_bolita_b_edit">
              <input type="hidden" id="color_bolita_c_edit">
              <div class="row mt-2">
                <div class="col-md-3">
                  <div class="Letra" id="letra_edit" style="background:#900c3f; color:#fff;">
                    ?
                  </div>
                  <div class="refresh" onclick="cambiarColor('color_bolita_b_edit','color_bolita_c_edit')">
                    <i class="fas fa-refresh"></i>
                  </div>
                </div>
                <div class="col-md-9">
                  <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-control-label">Nombre <span class="tx-danger">*</span> :</label>
                            <input type="text" class="form-control" id="nombre_rc_edit" name="nombre_rc_edit" placeholder="Nombre" value="" onkeyup="letra_validate(this)" style="text-transform: capitalize;">
                        </div>
                    </div>
                  
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-control-label">Apellido Paterno <span class="tx-danger">*</span> :</label>
                            <input type="text" class="form-control" id="app_rc_edit" name="app_rc_edit" placeholder="Apellido Paterno" value="" onchange="validate_campo(this)" style="text-transform: capitalize;">
                        </div>
                    </div>
                  
                    <div class="col-md-4">
                      <div class="form-group">
                          <label class="form-control-label">Apellido Materno: </label>
                          <input type="text" class="form-control" id="apm_rc_edit" name="apm_rc_edit" placeholder="Apellido Materno" value="" style="text-transform: capitalize;">
                      </div>
                    </div>
                  
                  </div>
                </div>
              </div>
              <div class="row mt-2">
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="form-control-label">Correo <span class="tx-danger">*</span> :</label>
                    <input type="email" class="form-control" id="email_rc_edit" name="email_rc_edit" placeholder="Correo" value="" onchange="validate_campo(this)" autocomplete="off">
                  </div>
                </div>
              </div>
            
              <div  id="camposempty" class="alert alert-warning alert-dismissible" role="alert" style="display: none;">
                <strong>Lo sentimos!</strong> Existen campos obligatorios vacios.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            
            </div>
            <div class="modal-footer d-flex" id="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="cerrar_modal('editar_contacto')">Cerrar</button>
                <button type="button" class="btn btn-secondary " onclick="editarContacto()" style="background:#848F33 !important; color:#fff;"  id="btn_guardarContacto">Actualizar</button>
            </div>
        </div>
    </div>
  </div>

  <div id="delete_contacto" class="modal fade" data-backdrop="static" data-keyboard="false" style="display: none">
    <div class="modal-dialog modal-lg mg-b-100" role="document" style="width: -webkit-fill-available; max-width: 500px!important;">
        <div class="modal-content tx-size-sm">
            <div class="modal-header pd-x-20" style="background:#848F33 !important; color:#fff !important;">
            <h5 class="modal-title" >Eliminar Contacto</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="cerrar_modal('delete_contacto')">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body pd-x-20 pd-t-0 pd-b-0">
              <input type="hidden" id="id_delete">
              <input type="hidden" id="nombre_delete">
              <input type="hidden" id="apellido_delete">
              <h5 class="my-4">¿Deseas eliminar a <span id="nombre_contacto_f" style="color: #E74C3C;"></span> de tu lista de contactos?</h5>
            </div>
            <div class="modal-footer d-flex" id="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="cerrar_modal('delete_contacto')">Cancelar</button>
                <button type="button" class="btn btn-secondary " onclick="eliminarContacto()" style="background:#E74C3C !important; color:#fff;"  id="btn_guardarContacto">Eliminar</button>
            </div>
        </div>
    </div>
  </div>

  <div id="remove_contacto" class="modal fade" data-backdrop="static" data-keyboard="false" style="display: none">
    <div class="modal-dialog modal-lg mg-b-100" role="document" style="width: -webkit-fill-available; max-width: 500px!important;">
        <div class="modal-content tx-size-sm">
            <div class="modal-header pd-x-20" style="background:#848F33 !important; color:#fff !important;">
            <h5 class="modal-title" >Remover Contacto</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="cerrar_modal('remove_contacto')">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body pd-x-20 pd-t-0 pd-b-0">
              <input type="hidden" id="id_conctato_remove">
              <input type="hidden" id="id_reporte_remove">
              <input type="hidden" id="nombre_remove">
              <input type="hidden" id="apellido_remove">
              <input type="hidden" id="titulo_remove">
              <h5 class="my-4">¿Deseas remover a <span id="nombre_contacto_k" style="color: #E74C3C;"></span> de <span id="titulo_k" style="color: #848F33;"></span>?</h5>
            </div>
            <div class="modal-footer d-flex" id="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="cerrar_modal('remove_contacto')">Cancelar</button>
                <button type="button" class="btn btn-secondary " onclick="removerContacto()" style="background:#E74C3C !important; color:#fff;"  id="btn_guardarContacto">Remover</button>
            </div>
        </div>
    </div>
  </div>
@endsection

