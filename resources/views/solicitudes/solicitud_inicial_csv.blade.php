@php
  use App\Http\Controllers\clases\humanRelativeDate;
  use App\Http\Controllers\clases\utilidades;
  $humanRelativeDate = new humanRelativeDate();
@endphp
@extends('layouts.index')
@section('contenido-pageheader')
  <ol class="breadcrumb slim-breadcrumb">

    <li class="breadcrumb-item"><a href="#">Solicitudes</a></li>
    <li class="breadcrumb-item active" aria-current="page">Carga Masiva de Solicitudes Iniciales por CSV</li>
  </ol>
  <h6 class="slim-pagetitle">Carga Masiva de Solicitudes Iniciales por CSV</h6>
@endsection

@section('contenido-principal')
{{--   @if($error!="")
    <div class="alert alert-warning" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <strong>Alerta!</strong> {{$error}}.
    </div><!-- alert -->
  @endif --}}
  <div class="section-wrapper">


 {{--    <select class="form-control select2-show-search valid" id="tipoAudiencia" name="tipo_audiencia" autocomplete="off">
      <option selected disabled value="">Elija una opción</option>
      @foreach ($tipos_audiencia as $tipo_audiencia)
           <option value="{{$tipo_audiencia['id_ta']}}" data-duracion="{{$tipo_audiencia['promedio_duracion']}}">{{$tipo_audiencia['tipo_audiencia']}}</option>
      @endforeach
  </select> --}}



      <div class="row">

        <form onsubmit="return false;" id="cargarDocumento" style="width: 100%; action="/" enctype="multipart/form-data">
            <div class="custom-input-file">
              <input type="file" id="archivoPDF" class="input-file" value="" name="archivoPDF" onchange="leeDocumento(this);">
              <h5 class="px-3 py-3">Arrastre hasta aquí su documento .CSV o de clic para adjuntarlo</h5>
              </div>
          </form>



        </div>
<br>
        <div class="row">
            <div id="divDucumento">
                <object data=""  id="documentoPDF" width="100%" height="350px" class="d-none mg-t-25"></object>
                 <input type="hidden" id="bDoc">
               </div>

        </div>





  </div>


@endsection
@section('seccion-estilos')
<script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>



<style>
    label.permiso{
      /* width: max-content; */
      /* display: inline-block; */
      margin-bottom: 0;
      margin-top: 5px;
      color: black;
    }
    .col-permiso{
      padding: 5px 20px;
      /* background-color: #f8f9fa; */
    }
    .accordion-one .card-header a::before {
      top: 5px !important;

    }
    #byte_content { white-space: pre}
    .accordion-one .card-header{
      /* border: 1px solid lightgrey; */
      border-bottom: 1px solid lightgrey;
    }

    a.transition {
      /* display: inline-block !important; */
      /* font-weight: 300; */
      margin-top: 3px;
      padding: 5px 20px !important;
    }
    .col-6.salas{
      padding-left: 0;
      text-align: center;
    }
    .card-header .row{
      padding-left: 15px;
      padding-right: 15px;


    }
    .btn{
      background-color: #4CAF50;


    }

    .accordion-one .card-header a {
      display: block;
      padding: 9px 10px;
      color: #154f89;
      position: relative;
      border-bottom: none !important;
      background-color: #fff !important;

    }
    .accordion-one{
      max-width: 100%;

    }
    tbody.table-datos-sujeto tr td:first-child{
      background-color: #f8f9fa;
      min-width: 150px;

      font-weight: bolder;
    }
    .iconify{
                display: inline-block;
                text-align: left;
                vertical-align: top;
                width: 90px; height: 90px;
                color: #4CAF50;
             }

    .div-padre{
      max-width: 700px;
      background-color: #f8f9fa;
    }
    .mg-l-16{
      margin-left: 16px;
    }

    .custom-input-file {
        cursor: pointer;
        font-size: 25px;
        font-weight: bold;
        margin: 0 auto 0;
        min-height: 15px;
        overflow: hidden;
        padding: 10px;
        position: relative;
        text-align: center;
        width: 500px;
        color: #848F33;
        border: 2px solid #EEE;
        border-style: dotted;
        height: 80px;
        border-radius: 25px;
        width: 80%;
      }

      .custom-input-file:hover{
        background: #848F33;
        color: #fff;
      }

      .custom-input-file .input-file{
        border: 10000px solid transparent;
        cursor: pointer;
        font-size: 10000px;
        margin: 0;
        opacity: 0;
        outline: 0 none;
        padding: 0 ;
        position: absolute;
        right: -1000px;
        top: -1000px;
      }
  </style>
@endsection


@section('seccion-scripts-libs')
<script src="{{ $entorno["version_pages"]["version"] }}/lib/jquery-ui/js/jquery-ui.js"></script>
<script src="{{ $entorno["version_pages"]["version"] }}/lib/datatables/js/jquery.dataTables.js"></script>
<script src="{{ $entorno["version_pages"]["version"] }}/lib/datatables-responsive/js/dataTables.responsive.js"></script>
<script src="{{ $entorno["version_pages"]["version"] }}/lib/select2/js/select2.min.js"></script>
<script src="{{ $entorno["version_pages"]["version"] }}/lib/moment/js/moment.js"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
<script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>



@endsection



@section('seccion-scripts-functions')
  <script>
let ID_usuario='';

$(function(){
    'use strict';

                //timeout modal
                setTimeout(function(){
                $('#modal_loading').modal('hide');
                  }, 1000);


            // Select2
            $('.select2').select2({
                minimumResultsForSearch: Infinity
              });


              //focus textfiled
              $('.form-layout .form-control').on('focusin', function(){
                  $(this).closest('.form-group').addClass('form-group-active');
              });

              $('.form-layout .form-control').on('focusout', function(){
                  $(this).closest('.form-group').removeClass('form-group-active');
                });


});//strict function

/* divDucumento">
            <object data=""  id="documentoPDF */


                var CsvRows;
                var headers;

                // This event will be triggered when file is selected
                // Note: This code is tested for UTF-8 encoded CSV file
                function leeDocumento(evt) {
                    const file = $('#archivoPDF').val();
      const ext = file.substring(file.lastIndexOf("."));


      if(ext!=''){

        if(ext != ".csv"){
          alert('Solo puede adjuntar archivos .csv');
          $('#archivoPDF').val('');
        }else{

                var reader = new FileReader();
                reader.onload = function() {

                    //reader.result gives the file content

              //       document.getElementById("divDucumento").value= reader.result.replace(/\s+/g, ''); //para espacios
                    document.getElementById('divDucumento').innerHTML = reader.result;
                   document.getElementById("divDucumento").value= reader.result.replace(/(\r\n|\n|\r)/gm,",%");

                    //parse the result into javascript object
    /*                 var lines = reader.result.split('\r\n\s');

                    headers = lines[0].split(',');
                    lines.shift();
                    CsvRows = lines.map((item) => {
                    var values = item.split(',');

                    var row = {};
                    headers.map((h, i) => {
                        row[h] = values[i];
                    });
                    return row;
                    });
                    console.log(CsvRows); */
                 //   document.getElementById('documentoPDF').style.display = 'block';
                 //   document.querySelector('.documentoPDF').innerText = target.result;


                };

                //read the selected file
                reader.readAsBinaryString(evt.files[0]);
                $("#modalEnviarCSV").modal("show");

            }

            }
                };








 function cerrar_modal(valor){
        $("#"+valor).modal('hide');
        $('body').removeClass('modal-open');


}

        function enviarCSV() {

            cerrar_modal('modalEnviarCSV')
            $('#modal_loading').modal('show');

        $.ajax({
                                type:'POST',
                                url:'public/enviarCSV',
                                data:{
                                    datos:$('#divDucumento').val(),
                                },
                                success:function(response) {
                                    console.log(response);

                                    if(response.status==100){

                                        let tabla="";
                                        let listaCarpetas=[];


               $(response.respuesta).each(function(index, solicitudes){

                    const{folio_carpeta,id_solicitud}=solicitudes



                    tabla=  tabla.concat(`<table style="border:1px solid #EEE" class="dataTable" id="tableRespuestaSolicitud">
                    <tbody class="table-datos-sujeto">

                    <tr>
                    <td>Mensaje</td>
                    <td>${response.message}</td>
                    </tr>
                    <tr>
                    <td>ID Acuse </td>
                    <td><p class="fl-m mg-b-0">${id_solicitud}</p></td>
                    </tr>
                    <tr>
                    <td>Folio de Carpeta</td>
                    <td>${folio_carpeta}</td>
                    </tr>
                    </tbody>
                    </table>`);



                                });$('#datos-respuesta-promocion').append(tabla);







                                        $('#modalSuccess').modal('show');
                                    //  $('#modalOkTurnado').modal('show');


                                            }
                                        else{

                                            var error = "<p class='mg-b-20 mg-x-20'>"+response.message+"</p>";
                                            $('#messageError').html(error);
                                            $('#modalError').modal('show');
                                        }

                                        setTimeout(()=>{
                                                $('#modal_loading').modal('hide');
                                        },300);

                                }
                                });

        }

  </script>

@endsection


@section('seccion-modales')

<div id="modalSuccess" class="modal fade"  data-backdrop="static" data-keyboard="false" >
    <div class="modal-dialog" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"><span id="">Solicitudes Registradas</h6>
        </div>
        <div class="modal-body tx-center pd-y-20 pd-x-20">
            <div style="width: 100%; height: 500px; overflow-y: auto;">

          <div id="datos-respuesta-promocion" align="left">
        </div>
          </div>
        </div><!-- modal-body -->
        <div class="modal-footer d-flex">
          <button type="button" class="btn btn-primary pd-x-25 mg-l-auto" data-dismiss="modal" aria-label="Close" onclick="window.location.reload()">Aceptar</button>
        </div>
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
  </div><!-- modal -->





        <div class="modal fade" id="modalEnviarCSV"  tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" style="width: 30%;">
            <div class="modal-content" >
                <div class="modal-header" style="padding:15px">
                    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"><span id="">Registrar Solicitudes</h6>
                </div>
                <div class="modal-body"   >
                <div class="row form-layout">

                    <h6 class="modal-title">¿Está seguro de querer enviar las solicitudes? </h6>

                  </div>
                </div>
                <div class="modal-footer" style="padding:10px">
                            <button type="button" class="btn btn-secondary btn-sm" onclick="cerrar_modal('modalEnviarCSV')" data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" onclick="enviarCSV()" class="btn btn-primary btn-sm">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <div id="modalError" class="modal fade">
        <div class="modal-dialog" role="document">
          <div class="modal-content tx-size-sm">
            <div class="modal-body tx-center pd-y-20 pd-x-20">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <i class="icon icon ion-ios-close-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
              <h4 class="tx-danger mg-b-20">Datos incompletos</h4>
              <p class="mg-b-20 mg-x-20" id="messageError"></p>
              <button type="button" class="btn btn-danger pd-x-25" data-dismiss="modal" aria-label="Close">Aceptar</button>
            </div><!-- modal-body -->
          </div><!-- modal-content -->
        </div><!-- modal-dialog -->
      </div><!-- modal -->

@endsection
