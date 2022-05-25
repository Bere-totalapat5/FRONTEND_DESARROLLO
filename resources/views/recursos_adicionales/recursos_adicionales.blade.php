@php
  use App\Http\Controllers\clases\utilidades;
@endphp

@extends('layouts.index')

@section('contenido-pageheader')
  <ol class="breadcrumb slim-breadcrumb">
     <li class="breadcrumb-item"><a href="#">Recursos Adicionales</a></li>
     <li class="breadcrumb-item"><a href="#">Consulta Recursos Adicionales</a></li>
  </ol>
  <h6 class="slim-pagetitle">  Recursos Adicionales</h6>
@endsection

@section('seccion-estilos')
    <link href="{{asset("/lib/datatables/css/jquery.dataTables.css")}}" rel="stylesheet">
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
    <style>

      .select2-container.select2-container--default.select2-container--open{
        z-index: 1050 !important;
      }
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
    
      table {
          width: calc(100% - 2px) !important;
          border-bottom: 1px solid #f0f2f7;
      }
    
      td,
      th {
          padding-left: 1px !important;
          padding-right: 3px !important;
          padding-top: 0px;
          padding-bottom: px !important;
          border-bottom: 1px solid #f0f2f7;
          max-width: 110px !important;
      }
      span.select2-container.select2-container--default.select2-container--open {
          width: "100%";
      }
    
      .datepicker-container {
          z-index: 1110;
      }
    
      .abs-center {
          display: flex;
          align-items: center;
          justify-content: center;
          min-height: 100vh;
      }
      .iconify {
          display: inline-block;
          text-align: left;
          vertical-align: top;
      }
    
      .ref {
          min-width: 80px !important;
      }
      .th_accion {
          min-width: 120px !important;
      }
      .id_usuario {
          min-width: 140px !important;
      }
      .th_usuario {
          min-width: 170px !important;
      }
      .th_correo {
          min-width: 180px !important;
      }
      .th_nombre {
          min-width: 200px !important;
      }
      .th_clave {
          min-width: 160px !important;
      }
      .th_unidad {
          min-width: 220px !important;
      }
      .th_tipo {
          min-width: 260px !important;
      }
      .hover:hover{
         background-color:#90a03c;
         color:white;
      }
    
      .td-title {
          background-color: #f0f2f7 !important;
          min-width: 120px !important;
          border-color: #f0f2f7 !important;
          max-height: 5px !important;
          padding: 3px 5px 3px 5px !important;
      }
    
      .th-title {
          column-span: 100%;
          background-color: #f0f2f7 !important;
          min-width: 130px !important;
          border-color: #f0f2f7 !important;
          max-height: 5px !important;
          padding: 3px 0px 3px 5px !important;
          align: center !important;
      }
    
      .slim-navbar {
          z-index: 1000 !important;
      }
      .flex-container {
      display: flex;
      justify-content: center;
      
      }
    
      .flex-container > div {
      margin: 1px;
      padding: 1px;
      font-size: 16px;
      }
    
      table#datosolicitud tr td:nth-child(2) {
          padding-left: 5px !important;
      }
    
      td.acciones {
          font-size: 25px !important;
          padding-top: 0 !important;
          padding-bottom: 0 !important;
          display: inline-block;
      }
      td.acciones a {
          display: inline;
          margin-left: 20%;
          cursor: pointer;
          text-align: left;
      }
      td.acciones a:first-child {
          margin-left: 0;
          text-align: left;
      }
    
      .ul {
          list-style: none;
      }
    
      .depo {
          min-width: 80px !important;
      }
    
      table {
          width: calc(100% - 2px) !important;
      }
      table a:hover {
          font-weight: bold;
      }
      span.select2-container {
          width: "100%";
      }
    
      div .icon{
              background: #848F33 !important;
              padding: 2px 5px;
              border-radius: 25%;
              color: #fff;
            }
          
    </style>
@endsection

@section('contenido-principal')
  <div class="section-wrapper" style="max-width: 100%;">
    <div class="form-layout">
      <h2>Recursos adicionales</h2>
    </div>
  </div>

@endsection
@section('seccion-scripts-libs')
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/jquery-ui/js/jquery-ui.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/datatables/js/jquery.dataTables.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/datatables-responsive/js/dataTables.responsive.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/select2/js/select2.min.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/moment/js/moment.js"></script>
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
     <script src="https://cdn.datatables.net/colreorder/1.5.3/js/dataTables.colReorder.min.js"></script>
@endsection

@section('seccion-scripts-functions')
  <script>

    $(function(){
    //Aqui las function
      setTimeout(function(){
        $('#modal_loading').modal('hide');
      }, 1000);
    });

  </script>
@endsection
