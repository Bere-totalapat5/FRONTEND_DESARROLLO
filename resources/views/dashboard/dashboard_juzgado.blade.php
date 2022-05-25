
@php
use App\Http\Controllers\clases\humanRelativeDate;
$humanRelativeDate = new humanRelativeDate();
use App\Http\Controllers\clases\utilidades;
@endphp

@extends('layouts.index')

@section('contenido-pageheader')
    <ol class="breadcrumb slim-breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">
            Tareas
        </li>
    </ol>
    <h6 class="slim-pagetitle">
        Home/Tareas
    </h6>
@endsection
@section('contenido-principal')
<div class="section-wrapper">
    @if(!utilidades::buscarPermisoMenu($request->menu_general['response'], 65))
        <h1 class="mg-b-50">No tiene permiso para acceder a esta sección, verifíquelo con su titular</h1>
        <a href="/home"><button class="btn btn-primary btn-block">Regresar al inicio</button><a>
    @else
    @endif
</div>
@endsection

@section('seccion-estilos')
    <link href="{{ $entorno["version_pages"]["version"] }}/lib/datatables/css/jquery.dataTables.css" rel="stylesheet">
    <link href="{{ $entorno["version_pages"]["version"] }}/lib/select2/css/select2.min.css" rel="stylesheet">
    <style>
        @media screen and (max-width: 600px) {
            .filtro_tocas_turnados{
                float: left !important;
            }
        }
        .filtro_tocas_turnados{
            float: right;
        }
        table.dataTable tbody td {
            word-break: break-word;
            vertical-align: top;
            white-space:normal;
        }
    </style>
@endsection

@section('seccion-scripts-libs')
    <script src="{{ $entorno["version_pages"]["version"] }}/lib/datatables/js/jquery.dataTables.js"></script>
    <script src="{{ $entorno["version_pages"]["version"] }}/lib/datatables-responsive/js/dataTables.responsive.js"></script>
    <script src="{{ $entorno["version_pages"]["version"] }}/lib/select2/js/select2.min.js"></script>
    <script src="{{ $entorno["version_pages"]["version"] }}/lib/moment/js/moment.js"></script>
    <script src="{{ $entorno["version_pages"]["version"] }}/lib/jquery-ui/js/jquery-ui.js"></script>
@endsection

@section('seccion-scripts-functions')
    <script>
    $('#modal_loading').modal({backdrop: 'static', keyboard: false});

    var dataTableGlobal;

    $(function(){

        'use strict';
        
        //datatable
        dataTableGlobal=$('#datatable1').DataTable({
            responsive: true,
            "paging":   false,
            "info":     false,
            "ordering": false,
            "searching": false,
            'columnDefs': [
                
                { "targets": [0], responsivePriority: 1, targets: 0, "orderable": false, "visible": true },
                { "targets": [1], responsivePriority: 1, "orderable": false, "visible": true },
                { "targets": [2], responsivePriority: 1, "orderable": false, "visible": true },
                { "targets": [3], responsivePriority: 2, targets: 0, "orderable": false  },
                { "targets": [4], responsivePriority: 2, "orderable": false }
            ],
            orderable: false,
            bLengthChange: false,
            searching: false,
            responsive: true,
            language: {
                searchPlaceholder: 'Filtrar...',
                sSearch: '',
                lengthMenu: '_MENU_ Registros'
            }
            
        });

        //focus textfiled
        $('.form-layout .form-control').on('focusin', function(){
            $(this).closest('.form-group').addClass('form-group-active');
        });
        $('.form-layout .form-control').on('focusout', function(){
            $(this).closest('.form-group').removeClass('form-group-active');
        });

        // Select2
        $('.select2').select2({
            minimumResultsForSearch: Infinity
        });

        //fechas
        $('.fc-datepicker').datepicker({
            language: 'es',
            showOtherMonths: true,
            selectOtherMonths: true,
            dateFormat: 'yyyy-mm-dd',
        });

        setTimeout(function(){
            $('#modal_loading').modal('hide');
        }, 1000);
    });    
    </script>
@endsection

@section('seccion-modales')


@endsection