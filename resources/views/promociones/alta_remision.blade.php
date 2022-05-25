@php
  use App\Http\Controllers\clases\humanRelativeDate;
  use App\Http\Controllers\clases\utilidades;
  $humanRelativeDate = new humanRelativeDate();
@endphp

@extends('layouts.index')

@section('contenido-pageheader')
 <ol class="breadcrumb slim-breadcrumb">
    <li class="breadcrumb-item"><a href="#">Reenvio de Carpetas</a></li>
    <li class="breadcrumb-item"><a href="#"> Nueva Redireccion de carpeta </a></li>
 </ol>
 <h6 class="slim-pagetitle">Redireccion de carpeta</h6>
@endsection



@section('contenido-principal')

  {{--   @if(!isset($request->menu_general['response']))
    <div class="section-wrapper">
        <BR><h1 style="text-align: center;">Por el momento solo puede utilizar el modulo de demandas y promociones para su consulta</h1>
    </div>
    @else
    @if(!utilidades::buscarPermisoMenu($request->menu_general['response'], 1151))
        <div class="section-wrapper">
            <BR><h1 style="text-align: center;">Por el momento solo puede utilizar el modulo de demandas y promociones para su consulta</h1>
        </div>
    @else --}}
 <div class="section-wrapper" style="max-width: 1200px;">

    <div class="form-layout">
        <div class="row mg-b-25 " id="datosReenvioCarpeta">{{-- datos de solicitud de audiencia --}}


          <div class="col-lg-4" >
            <label class="form-control-label">Unidad de Gestión Origen:</label>
            <div class="form-group" >
                <select class="form-control-lg select2 valid" width='100%'  autocomplete="off" id="unidadOrigen">
                  <option selected disabled value="">Elija una opción</option>

                  @foreach ($unidades['response'] as $unidad)
                       <option value="{{$unidad['id_unidad_gestion']}}">{{$unidad['nombre_unidad']}}</option> 
                  @endforeach
                </select>
            </div>
            </div>

            <div class="col-lg-4" >
              <label class="form-control-label">Tipo de Carpeta a Redireccionar:</label>
              <div class="form-group" >
                  <select class="form-control-lg select2 valid" width='100%'  autocomplete="off" id="tipoCarpeta">
                    <option selected disabled value="">Elija una opción</option>
  {{-- 
                    @foreach ($unidades['response'] as $unidad)
                         <option value="{{$unidad['id_unidad_gestion']}}">{{$unidad['nombre_unidad']}}</option> 
                    @endforeach --}}
                  </select>
              </div>
              </div>
          

      
          <div class="col-lg-4" id="divAsociada" style="display:block">
                <div class="form-group">
                  <label class="form-control-label">Carpeta Judicial: <span class="tx-danger">*</span></label>
{{--                   <input class="form-control" type="text" onkeyup="buscarCarpeta();" name="carpeta_judicial_asociada" id="carpetaJudicialAsociada"   placeholder="Carpeta Judicial Asociada" autocomplete="off">
 --}}              
                {{--   <select class="form-control select2" id="selectCarpeta" onkeyup="buscarCarpeta();" name="select_carpeta" autocomplete="off">
                
                  </select> --}}
              

                  <input class="form-control" list="datalistCarpetas"  id="carpetaJudicialAsociada" onkeyup="buscarCarpeta();" placeholder="Escribe para Buscar...">
                       {{--  <datalist id="datalistCarpetas">
                   
                        </datalist> --}}
              
                </div>
              </div><!-- col-3 -->
    
              <div class="col-lg-8">
                <div class="form-group" id="destinoAsignacion">
                  <label class="form-control-label mg-t-20">Tipo de asignación de unidad destino: <span class="tx-danger">*</span></label>
                  <div class="d-inline-block mg-l-10">
                    <label class="rdiobox d-inline-block mg-l-5">
                      <input name="destino_asignacion" type="radio" value="unidad">
                      <span class="pd-l-0">Selección de unidad destino</span>
                    </label>
                    <label class="rdiobox d-inline-block mg-l-5">
                      <input name="destino_asignacion1" type="radio" value="balanceo">
                      <span class="pd-l-0">Por balanceo según inmueble</span>
                    </label>
                  </div>
                </div>
              </div>

              <div class="col-lg-4" id="unidadDestinoDiv" style="display:block">
                <label class="form-control-label">Unidad de Gestión Destino:</label>
                <div class="form-group" >
                    <select class="form-control-lg select2 valid" width='100%'  autocomplete="off" id="UnidadDestino">
                      <option selected disabled value="">Elija una opción</option>
    
                      @foreach ($unidades['response'] as $unidad)
                           <option value="{{$unidad['id_unidad_gestion']}}">{{$unidad['nombre_unidad']}}</option> 
                      @endforeach
                    </select>
                </div>
                </div>


                <div class="col-lg-12" id="tipoDestinoDiv" style="display:none">
                  <div class="form-group" id="tipo_unidad_destino">
                    <label class="form-control-label mg-t-20">Tipo  de unidad destino: <span class="tx-danger">*</span></label>
                    <div class="d-inline-block mg-l-10">

                      <label class="rdiobox d-inline-block mg-l-5">
                        <input name="tipo_unidad_destino" type="radio" value="control">
                        <span class="pd-l-0">Unidad de control</span>
                      </label>

                      <label class="rdiobox d-inline-block mg-l-5">
                        <input name="tipo_unidad_destino" type="radio" value="enjuiciamiento">
                        <span class="pd-l-0">Tribunal de Enjuiciamiento</span>
                      </label>

                      <label class="rdiobox d-inline-block mg-l-5">
                          <input name="tipo_unidad_destino" type="radio" value="ejecucion">
                          <span class="pd-l-0">Unidad de Ejecución</span>
                        </label>

                    </div>
                  </div>
                </div>

  


       
          
       


          <div class="col-lg-12">
            <div class="form-group">
              <label class="form-control-label">Motivo del Cambio</label>
             
              <th colspan="100%">
                <textarea id="textarea" id="resumenDocumento" rows="2"  ></textarea>
                 </th>
            </div>
          </div><!-- col-9 -->

     
        </div><!-- row -->{{-- </datos de solicitud de audiencia> --}}

        <div id="accordion" class="accordion-one mg-b-20" role="tablist" aria-multiselectable="true">
            <div class="card">

                <div class="card-header" role="tab" id="headingOne">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" class="tx-gray-800 transition collapsed">
                    Personas autorizadas para recibir documentación
                    </a>
                </div><!-- card-header -->

                <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                    <div class="card-body">
                        <button class="btn btn-outline-primary mg-b-10 btn-sm mg-r-10" id="agregarPersona">Agregar Persona <i class="fa fa-plus"></i></button>
                        <div id="datosPersona">
                          
                        </div>
                      </div>
                        </div>
                        </div>
                        </div><!-- accordion -->

       
        <div class="form-layout-footer d-flex">
{{--           <button class="btn btn-secondary bd-0 d-inline-block" id="atras" disabled>Atrás</button>
 --}}          <button class="btn btn-primary bd-0 d-inline-block ml-auto" id="enviarPromocion">Enviar Solicitud</button>
        </div><!-- form-layout-footer -->
      </div>
   



</div>





@endsection



    @section('seccion-estilos')
    <link href="{{asset("/lib/datatables/css/jquery.dataTables.css")}}" rel="stylesheet">
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
        <style>
            .flex-container {
            display: flex;
            justify-content: center;

            }

                        textarea{
            background-color: white  !important;
            min-height: 100px !important;
            width: 100% !important;
            }

                .accordion {
                /* background-color: #eee; */

                color: #444;
                cursor: pointer;
                padding: 10px;
                width: 100%;
                border: none;
                text-align: left;
                outline: none;
                font-size: 15px;
                transition: 0.4s;
           }

            .active, .accordion:hover {
            /*  background-color: #ccc; */
            }

           .flex-container > div {
           margin: 1px;
           padding: 1px;
           font-size: 16px;
           }


          @media screen and (max-width: 600px) {

            }
            #modal-ver .modal-dialog {
            width: 100%;
            max-width:700px;
            height: 90%;
            margin: 0;
            padding: 1;
        }

     
            span.select2-container.select2-container--default.select2-container--open{
                width:'100%';
            }

             .datepicker-container{
                z-index: 1110;
            }

            .abs-center {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    min-height: 100vh;
            }
            .iconify{
                display: inline-block;
                text-align: left;
                vertical-align: top;
             }

            .fecha{
                min-width: 111px !important;
            }
    

            table a:hover{
                font-weight:bold;
            }
            span.select2-container{
                width:'100%';
            }
            /* .active:after {
                        content: "\2212";
                        } */



            .panel {

            padding: 0 18px;
            background-color: white;
            max-height: 0;
            overflow: hidden;
            transition: 0.2s ease-out;
            }

            #datosPersona .row{
                border: 1px solid #EEE;
                border-collapse: collapse;
                margin-top: 2px
                }
                div#datosPersona .row:nth-child(2n){
                background: #FDFDFD !important;
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
@endsection

@section('seccion-scripts-functions')
<script>

let solicitudes=[];
let tabla_direcciones=[];
let tabla_alias=[];
let tabla_contacto=[];
let tabla_correo=[];

let tabla_datos=[];
let tabla_delitos=[];
let tabla_no_relacionados=[];

const expVacio=/^[\s]*$/;

$(function(){
    'use strict';

    $('#agregarPersona').click(function(){
      $('#datosPersona').append(`<div class="row datos-persona">

                                <div class="col-12" >
                                  <p class="tx-right tx-danger"><i class="fa fa-close borrar-persona"></i></p>
                                </div>

                                <div class="col-lg-3">
                                  <div class="form-group mg-b-10-force">
                                    <label class="form-control-label">Nombres:</label>
                                    <input class="form-control persona" type="text" name="personaAgregada" autocomplete="off">
                                  </div>                             
                                </div><!-- col-3-->


                                <div class="col-lg-3">
                                  <div class="form-group mg-b-10-force">
                                    <label class="form-control-label">Apellido Paterno:</label>
                                    <input class="form-control persona" type="text" name="personaAgregadaPaterno" autocomplete="off">
                                  </div>                             
                                </div><!-- col-3-->

                                <div class="col-lg-3">
                                  <div class="form-group mg-b-10-force">
                                    <label class="form-control-label">Apellido Materno:</label>
                                    <input class="form-control persona" type="text" name="personaAgregadaMaterno" autocomplete="off">
                                  </div>                             
                                </div><!-- col-3-->



                              </div>`);
    });

    $('#datosPersona').on('click','.borrar-persona',function(){
      $(this).parent().parent().parent().remove();
    });

 

 

    //if(!$('input:radio[name=materia_destino]:checked').length) return {'estatus':0,'campo':'materiaDestino','error':'No ha seleccionado la materia destino'};

 /*    $('input:radio[name=materia_destino]:checked').val(),
    style="display:block" */


    $("#destinoAsignacion").click(function(){    
    
    
if ($('input:radio[name=destino_asignacion]:checked')) {
  
  $("#unidadDestinoDiv").css("display", "block");
   $("#tipoDestinoDiv").css("display", "none");

} else if($('input:radio[name=destino_asignacion]:checked')){

$("#unidadDestinoDiv").css("display", "none");
   $("#tipoDestinoDiv").css("display", "block");
 

}
    
       
    
    }); 






  //  if($('#requiereTelepresencia').find('.toggle-on').hasClass('active')) requiereTelepresencia='si';

  //check promovente
     $("#checkPromovente").click(function(){    
        var $this = $(this);
    
        if($("#checkPromovente").find('.toggle-off').hasClass('active')) {
         
            $("#promoventediv").css("display", "block");
            $("#promoventediv2").css("display", "none");
            $("#promoventediv2-1").css("display", "none");
            $("#promoventediv2-2").css("display", "none");

        }
        else if($("#checkPromovente").find('.toggle-on').hasClass('active')) {
              
            $("#checkPromovente").css("clicked");
            $("#promoventediv").css("display", "none");
            $("#promoventediv2").css("display", "block");
            $("#promoventediv2-1").css("display", "block");
            $("#promoventediv2-2").css("display", "block");
        }
    
    }); 


/* 
    $("#checkPromovente").toggle(function(){    

        $("#promoventediv").css("display", "none");
            $("#promoventediv2").css("display", "block");
    },function(){ 
        
        $("#promoventediv").css("display", "block");
            $("#promoventediv2").css("display", "none");
    }); */

    
    if ($("#carpetaJudicialAsociada").val()) {
      folio_carpeta= $("#carpetaJudicialAsociada").val();
    } else if ($("#carpetaJudicialReferida").val()) {
      folio_carpeta= $("#carpetaJudicialReferida").val();
    }
    


/* //TIPO PROMOCION
    document.getElementById("tipoPromocion").onchange = function(){    
      
        if($("#tipoPromocion").val() == "2") {
          $("#carpetaJudicialAsociada").val('');
            
            $("#divReferida").css("display", "block");
            $("#divAsociada").css("display", "none"); 
        }
        else if ($("#tipoPromocion").val() == "1") {
          $("#carpetaJudicialReferida").val('');

            $("#divReferida").css("display", "none");
            $("#divAsociada").css("display", "block");
        }
    
    }; */



/* 
//TIPO AUDIENCIA
    document.getElementById("tipoRequerimiento").onchange = function(){    
        
        if($("#tipoRequerimiento").val() == "1") {   

        $("#divAudiencia").css("display", "block");    
        }
        else {
            $("#divAudiencia").css("display", "none");
        }

    };
 */
    
 

    Toggles
      $('.toggle').toggles({
        on: false,
        height: 26
      });


     // Select2
     $('.select2').select2({
        minimumResultsForSearch: Infinity
    });


    $(function(){
      'use strict'
      $('.ui-datepicker-year').addClass('select2');
      
      // Datepicker
      $('.fc-datepicker').datepicker({
          
          showOtherMonths: true,
          selectOtherMonths: true,
          format: 'dd/mm/yyyy',
          changeYear: true,
          yearRange: "c-100:c+0"
      });

      $('#datepickerNoOfMonths').datepicker({
          showOtherMonths: true,
          selectOtherMonths: true,
          numberOfMonths: 2
          
      });

    });

    
      // Time Picker
      $('#tpBasic').timepicker();
      $('#tp2').timepicker({'scrollDefault': 'now'});
      $('#horaRecepcion').timepicker();

      $('#setTimeButton').on('click', function (){
        $('#horaRecepcion').timepicker('setTime', new Date());
      });

    //focus textfiled
    $('.form-layout .form-control').on('focusin', function(){
        $(this).closest('.form-group').addClass('form-group-active');
    });
    $('.form-layout .form-control').on('focusout', function(){
        $(this).closest('.form-group').removeClass('form-group-active');
    });



      /* //TIPO persona
document.getElementById("figuraJuridica").onchange = function(){    
        
    var  figura= $("#figuraJuridica").val();
    var  folio_carpeta="";

    if ($("#carpetaJudicialAsociada").val()) {
      folio_carpeta= $("#carpetaJudicialAsociada").val();
    } else if ($("#carpetaJudicialReferida").val()) {
      folio_carpeta= $("#carpetaJudicialReferida").val();
    }
   
      
     if($("#figuraJuridica").val()) {
   
             $.ajax({
           type:'POST',
           url:'public/buscar_partes_carpeta',
           data:{
             figura: figura,
             folio_carpeta: folio_carpeta,
           },
           success:function(response){
             console.log(response.response);

             if(response.status==100){
              let datosFigura='';

            $(response.response).each(function(index, datos){

            const {folio_carpeta,id_carpeta_judicial,id_solicitud,personas}  =datos;



             if (personas) {

              $(personas).each(function(index, persona){

const {id_persona,nombre,apellido_materno,apellido_paterno,calidad_juridica,id_calidad_juridica}=persona;
const option=`<option value="${id_persona}">${nombre ??""} ${apellido_paterno ??""} ${apellido_materno ??""}</option>`;
datosFigura=datosFigura.concat(option); });  
               
             } else {

            
  const option=`<option value="0
  
  
  
  
  ">Sin datos relacionados</option>`;
datosFigura=datosFigura.concat(option);  
               
             }

              }); 
              $('#nombrePromovente').html(`<option selected disabled value="">Elija una opción</option> `
                + datosFigura );               
         
         
  
         
            }
                 }
             });
     
           } 

  }; */

            //promocion antes de pdf
    $('#enviarPromocion').click(function(){
        $('.error').removeClass('error');
        const validacion=validarDatos();
        if(validacion==100){
          mostrarModalDocumento();
        }else{
          const {campo , error} = validacion;
          if($('#'+campo).is('select')){
            $('span[aria-labelledby="select2-'+campo+'-container"]').addClass('error');
        }else{
            $('#'+campo).focus().addClass('error');
        }
          $('#messageError').html(`${error}`);
          $('#modalError').modal('show');
        }
    });



    setTimeout(function(){
        $('#modal_loading').modal('hide');
    }, 1000);




});

    function turnar(id_solicitud){

        //alert("turnar");

        const turnado= `<button type="button" onclick="turnar(${id_solicitud ?? ""})" class="btn btn-success" data-dismiss="modal">Turnar</button>   `
                    $('#boton').html( `${turnado}`);

        $.ajax({
        type:'PUT',
        url:'public/turnar_carpeta/5/'+ id_solicitud,
        data:{

        },
        success:function(response) {
             setTimeout(function(){
                $('#modal_loading').modal('hide');
                }, 500);
                if(response.status==100){

            //valor y boton id solicitud para turnado
          /*   const turnado= `<p class="mg-b-20 mg-x-20" > Carpeta Judicial Asignada ${response.folio_carpeta ?? ""}</p>   `
                                $('#carpetaAsignada').html( `${turnado}`);



                    const carpeta= response.folio_carpeta;
 */


                    $('#modalOkTurnado').modal('show');


                    }
                else{
                    $('#modalFailTurnado').modal('show');
                }
        }
        });
    }

  function mostrarModalDocumento(){

        $('#modalAdjuntarDocumento').modal('show');
  }

    


  function leeDocumento (input) {
      const file = $('#archivoPDF').val();
      const ext = file.substring(file.lastIndexOf("."));
      if(ext!=''){
        if(ext != ".pdf"){
          alert('Solo puede adjutar archivos .pdf');
          $('#archivoPDF').val('');
        }else{
            if (input.files && input.files[0]) {
              const reader = new FileReader();
              reader.onload = e=> {
                  $('#documentoPDF').attr('data', e.target.result); 
                  $('#documentoPDF').removeClass('d-none');
                  $('#bDoc').val(e.target.result.split('base64,')[1]);
              }
              reader.readAsDataURL(input.files[0]); 
            }
        }
      }
      
    }

    $("#archivoPDF").on('input',function () {
        leeDocumento(this);   
    });



  function buscarCarpeta() {
    var carpetaAsociada = $('#carpetaJudicialAsociada').val();
      
      if (carpetaAsociada.length > 3) {
        
          $.ajax({
          type:'POST',
          url:'public/buscar_carpetas_asociadas',
          data:{
            carpetaAsociada: carpetaAsociada,
          },
          success:function(response){
            console.log(response);
              
              if(response.status==100){
                let carpetas='';
                    $(response.response).each(function(index, carpeta){

                const {id_carpeta_judicial,folio_carpeta}  =carpeta;
      
                const option=`<option value="${folio_carpeta}">${folio_carpeta}</option>`;
                  carpetas=carpetas.concat(option);
                  });  
        $('#carpetaJudicialAsociada').
        html(`
        <datalist id="datalistCarpetas">           
          <option selected disabled value="">Elija una opción</option> `+ carpetas+`
        </datalist>` );



              }else{
                $('#carpetaJudicialAsociada').
        html(`
        <datalist id="datalistCarpetas">           
          <option selected disabled value="">No hay datos para Mostrar</option>
        </datalist>` );
              }

              setTimeout(function(){  $('#modal_loading').modal('hide');  }, 500);
          }
      });



        }//else

  }

  function buscarCarpetaReferida() {
    var carpetaAsociada = $('#carpetaJudicialReferida').val();
      
      if (carpetaAsociada.length > 3) {
        
          $.ajax({
          type:'POST',
          url:'public/buscar_carpetas_asociadas',
          data:{
            carpetaAsociada: carpetaAsociada,
          },
          success:function(response){
            console.log(response);
              
              if(response.status==100){
                let carpetas='';
                    $(response.response).each(function(index, carpeta){

                const {id_carpeta_judicial,folio_carpeta}  =carpeta;
      
                const option=`<option value="${folio_carpeta}">${folio_carpeta}</option>`;
                  carpetas=carpetas.concat(option);
                  });  
        $('#carpetaJudicialReferida').
        html(`
        <datalist id="datalistCarpetasReferidas">           
          <option selected disabled value="">Elija una opción</option> `+ carpetas+`
        </datalist>` );



              }else{
                $('#carpetaJudicialReferida').
        html(`
        <datalist id="datalistCarpetasReferidas">           
          <option selected disabled value="">No hay datos para Mostrar</option>
        </datalist>` );
              }

              setTimeout(function(){  $('#modal_loading').modal('hide');  }, 500);
          }
      });



        }//else

  }




  function validarDatos(){

    //carpetaJudicialAsociada
        if($('#fechaRecepcion').val()==null) return {'estatus':0,'campo':'fechaRecepcion','error':'No ha seleccionado la fecha de recepcion'};

        if(expVacio.test($('#horaRecepcion').val())) return {'estatus':0,'campo':'horaRecepcion','error':'Falta la hora de recepcion'};

        if($('#tipoPromocion').val()==null) return {'estatus':0,'campo':'tipoPromocion','error':'No ha seleccionado el tipo de promocion'};

              //referida  y asociada
        if($('#tipoPromocion').val()=='2'){

            if(expVacio.test($('#carpetaJudicialReferida').val())) return {'estatus':0,'campo':'carpetaJudicialReferida','error':'Falta la carpeta Judicial Referida '};

            }else{
              if(expVacio.test($('#carpetaJudicialAsociada').val())) return {'estatus':0,'campo':'carpetaJudicialAsociada','error':'Falta la carpeta Judicial Asociada '};
            }


        if($('#figuraJuridica').val()==null) return {'estatus':0,'campo':'figuraJuridica','error':'No ha seleccionado la figura juridica'};


    
          if($("#checkPromovente").find('.toggle-off').hasClass('active')) {
          
            if($('#nombrePromovente').val()==null) return {'estatus':0,'campo':'nombrePromovente','error':'No ha seleccionado el nombre del promovente asociado'};

          }
          else if($("#checkPromovente").find('.toggle-on').hasClass('active')) {
                
            if(expVacio.test($('#nombrePromovente2').val())) return {'estatus':0,'campo':'nombrePromovente2','error':'Falta el nombre del promovente'};
            if(expVacio.test($('#apellidoPPromovente2').val())) return {'estatus':0,'campo':'apellidoPPromovente2','error':'Falta el apellido del promovente'};

          }
      

      // if(!$('input:radio[name=materia_destino]:checked').length) return {'estatus':0,'campo':'materiaDestino','error':'No ha seleccionado la materia destino'};


  /*       if(expVacio.test($('#nombreFiscal').val())) return {'estatus':0,'campo':'nombreFiscal','error':'Falta el nombre del fiscal'};

        if(expVacio.test($('#apellidoPaternoFiscal').val())) return {'estatus':0,'campo':'apellidoPaternoFiscal','error':'Falta el apellido paterno del fiscal'};
  */      
        return 100;
  }

    
function enviarPromocion(){

    const validaDocumento=$('#bDoc').val();

    if(validaDocumento=='' || validaDocumento==null){
    $('#bSocumento').focus().addClass('error');
    $('#messageError').html(`No ha agregago su documento PDF`);
    $('#modalError').modal('show');
    }else{

    alert("Promocion enviada");
    }

    /* 
    const validaDocumento=$('#bDoc').val();

    if(validaDocumento=='' || validaDocumento==null){
      $('#bSocumento').focus().addClass('error');
      $('#messageError').html(`No ha agregago su documento PDF`);
      $('#modalError').modal('show');
    }else{
      $('#modal_loading').modal('show');
      $('#modalAdjuntarDocumento').modal('hide');
      cambiarPantalla('modal');
      const fechaRecepcion=$('#fechaRecepcion').val().split('-');
      let urgente='no',
          requiereTelepresencia='no',
          requiereResguardo='no',
          requiereTestigoProtegido='no',
          requiereMesa='no',
          priosionOficiosa='no',
          turnar='no';
      
      if($('#urgente').find('.toggle-on').hasClass('active')) urgente='si';
      
      if($('#requiereTelepresencia').find('.toggle-on').hasClass('active')) requiereTelepresencia='si';

      if($('#requiereResguardo').find('.toggle-on').hasClass('active'))requiereResguardo='si';
    
      if($('#requiereTestigoProtegido').find('.toggle-on').hasClass('active')) requiereTestigoProtegido='si';

      if($('#requiereMesa').find('.toggle-on').hasClass('active')) requiereMesa='si';
    
      if($('#priosionOficiosa').find('.toggle-on').hasClass('active')) priosionOficiosa='si';

      if($('#turnar').find('.toggle-on').hasClass('active')) turnar='si';

      $.ajax({
        type:'POST',
        url:'/public/enviar_solicitud',
        data:{
          fecha_recepcion:fechaRecepcion[2]+'-'+fechaRecepcion[1]+'-'+fechaRecepcion[0],
          hora_recepcion:$('#horaRecepcion').val(),
          numero_carpeta_investigacion:$('#numeroCarpetaInvestigacion').val(),
          tipo_audiencia:$('#tipoAudiencia').val(),
          duracion_aproximada:$('#duracionAproximada').val().split('minutos')[0],
          urgente:urgente,
          requiere_telepresencia:requiereTelepresencia,
          requiere_resguardo:requiereResguardo,
          requiere_testigoProtegido:requiereTestigoProtegido,
          requiere_mesa:requiereMesa,
          prision_oficiosa:priosionOficiosa,
          turnar:turnar,
          materia_destino:$('input:radio[name=materia_destino]:checked').val(),
          sujetos_procesales:arrSujetosProcesales,
          fiscalia:$('#fiscalia').val(),
          agecia:$('#agencia').val(),
          unidad_investigacion:$('#unidadInvestigacion').val(),
          coordinacion_territorial:$('#coordinacionTerritorial').val(),
          nombre_fiscal:$('#nombreFiscal').val(),
          // apellido_paterno_fiscal:$('#apellidpPaternoFiscal').val(),
          // apellido_materno_fiscal:$('#apellidpMaternoFiscal').val(),
          curp_fical:$('#curpFiscal').val(),
          correo_fiscal:$('#correoFiscal').val(),
          documento:$('#bDoc').val(),
        },
        success:function(response){
          console.log(response);
          if(response.status==100){
            $('#modalSuccess').modal('show');
            let tabla=`<table style="border:1px solid #EEE">
                          <tbody class="table-datos-sujeto">
                            <tr>
                              <td>Acuse</td>
                              <td>${response.response.id_acuse}</td>
                            </tr>
                            <tr>
                              <td>Folio de Solicitud</td>
                              <td>${response.response.folio_solicitud}</td>
                            </tr>`;

            if(response.response_carpeta.status==100){
              let estatusActual='No Disponible',
                  fehca_asignacion='No Disponible'
                  carpeta='No Disponible';

              if(response.response_carpeta.response){
                if(response.response_carpeta.response.fecha_asignacion_carpeta){
                  const fA=response.response_carpeta.response.fecha_asignacion_carpeta.split(' ')[0].split('-');
                  fehca_asignacion=fA[2]+'-'+fA[1]+'-'+fA[0];
                } 
                if(response.response_carpeta.response.fecha_asignacion){
                  const fA=response.response_carpeta.response.fecha_asignacion.split(' ')[0].split('-');
                  fehca_asignacion=fA[2]+'-'+fA[1]+'-'+fA[0];
                } 
                if(response.response_carpeta.response.estatus_flujo_actual){
                  estatusActual=response.response_carpeta.response.estatus_flujo_actual;
                }
                if(response.response_carpeta.response.folio_carpeta){
                  carpeta=response.response_carpeta.response.folio_carpeta;
                }
              }
              
              const mensaje=response.response_carpeta.message.split('-')[1];
              tabla=tabla.concat(`<tr>
                                    <td>Carpeta</td>
                                    <td><p class="fl-m mg-b-0">${carpeta}</p></td>
                                  </tr>
                                  <tr>
                                    <td>Estado de la Carpeta</td>
                                    <td><p class="fl-m mg-b-0">${mensaje}</p></td>
                                  </tr>
                                  <tr>
                                    <td>Fecha de Asignación</td>
                                    <td>${fehca_asignacion}</td>
                                  </tr>
                                  <tr>
                                    <td>Estatus Flujo Actual</td>
                                    <td>${estatusActual}</td>
                                  </tr>
                                </tbody>
                              </table>`);
            }else{
              tabla=tabla.concat(` </tbody>
                            </table>`);
            }
            $('#datosCarpeta').html(tabla);
          }
          setTimeout(()=>{
            $('#modal_loading').modal('hide');
          },300);
        }
      });
    } */
}


/* function limpiarCampos(){

      $('#idsolicitud').val('');//text
      $('#foliosolicitud').val('');
      $('#carpetainvestigacion').val('');
      $('#foliocarpeta').val('');

      $('#fechasolicitud').val('');//pickers
      $('#fechasolicitudh').val('');

      $('#estatusactual').val('');//selects
      $('#estatusurgente').val('');
      $('#materiadestino').val('');
      $('#estatus_color').val('');



    } */


</script>
@endsection



@section('seccion-modales')

    {{-- VER SOLICITUD --}}
    <div id="modal-ver" class="modal fade" data-keyboard="false">
            <div class="modal-dialog modal-dialog-vertical-center" role="document">
              <div class="modal-content bd-0 tx-14">


                 <div class="modal-body">


                            <button type="button" class="close ml-auto"  data-dismiss="modal" aria-label="Close">
                                <span  aling="right" aria-hidden="true">&times;</span>
                            </button>


                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Datos de la Solicitud</a>
                                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Personas</a>
                                <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Delitos no Relacionados</a>
                                </div>
                            </nav>
                            <br>

                            <div class="tab-content" id="nav-tabContent">

                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                    <table id="datosolicitud" class="dataTables"> </table>
                                </div>

                                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">


                                              <div class="accordion" id="acordeon" role="tablist"> </div>


{{--                                     <table id="datosparticipantes" class="dataTables"> </table>
 --}}
                               </div>

                                <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">


                                    <table id="datosno-asociados" class="dataTables"> </table>

                                </div>

                            </div>

                            <br>
                </div>



                 <div class="modal-footer">

                        <div id="boton" data-dismiss="modal">Turnar</div>

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>

              </div>
            </div><!-- modal-dialog -->
        </div><!-- modal -->

{{-- SIN DATOS --}}

        <div id="modalFail" class="modal fade">
            <div class="modal-dialog" role="document">
              <div class="modal-content tx-size-sm">
                <div class="modal-body tx-center pd-y-20 pd-x-20">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <i class="icon ion-ios-close-outline tx-100 color='#848F33' lh-1 mg-t-20 d-inline-block"></i>
                  <h4 class=" tx-semibold style='color:red' mg-b-20">Ohhhh!</h4>
                  <p class="mg-b-20 mg-x-20">No existe documento relacionado.</p>
                  <button type="button" class="btn btn-danger pd-x-25" data-dismiss="modal" aria-label="Close" >Cerrar</button>
                </div><!-- modal-body -->
              </div><!-- modal-content -->
            </div><!-- modal-dialog -->
          </div><!-- modal -->

          <div id="modalFailTurnado" class="modal fade">
            <div class="modal-dialog" role="document">
              <div class="modal-content tx-size-sm">
                <div class="modal-body tx-center pd-y-20 pd-x-20">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <i class="icon ion-ios-close-outline tx-100 style='color:red' lh-1 mg-t-20 d-inline-block"></i>
                  <h4 class=" tx-semibold style='color:red' mg-b-20">Ohhhh!</h4>
                  <p class="mg-b-20 mg-x-20">La solicitud ya dispone con una Carpeta Judicial Asignada</p>
                  <button type="button" class="btn btn-danger pd-x-25" data-dismiss="modal" aria-label="Close" >Cerrar</button>
                </div><!-- modal-body -->
              </div><!-- modal-content -->
            </div><!-- modal-dialog -->
          </div><!-- modal -->

          <div id="modalOkTurnado" class="modal fade">
            <div class="modal-dialog" role="document">
              <div class="modal-content tx-size-sm">
                <div class="modal-body tx-center pd-y-20 pd-x-20">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <i class="icon ion-ios-checkmark-circle-outline tx-100 color='#848F33' lh-1 mg-t-20 d-inline-block"></i>
                  <h4 class=" tx-semibold style='color:green' mg-b-20" style='color:green'>Proceso Concluido!</h4>

                  <p id="carpetaAsignada" color='green'  class="mg-b-20 mg-x-20">Carpeta Judicial Asignada</p>

                  <button type="button" class="btn btn-sucess pd-x-25" data-dismiss="modal" aria-label="Close" >Cerrar</button>
                </div><!-- modal-body -->
              </div><!-- modal-content -->
            </div><!-- modal-dialog -->
          </div><!-- modal -->


          <div id="modalAdjuntarDocumento" class="modal fade">
            <div class="modal-dialog modal-lg mg-b-100" role="document" style="width: -webkit-fill-available;">
              <div class="modal-content tx-size-sm">
                <div class="modal-header pd-x-20">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"><span id="titleSujeto">Adjuntar Documento</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body pd-20">
                  <form onsubmit="return false;" id="cargarDocumento" action="/" enctype="multipart/form-data">
                    <div class="custom-input-file">
                      <input type="file" id="archivoPDF" class="input-file" value="" name="archivoPDF" onchange="leeDocumento('archivoPDF');">
                      <h5 class="px-3 py-3">Arrastre hasta aquí su documento pdf o de clic para adjuntarlo</h5>
                      </div>
                  </form>
                  <div id="divDucumento">
                    <object data=""  id="documentoPDF" width="100%" height="350px" class="d-none mg-t-25"></object>
                    <input type="hidden" id="bDoc">
                  </div>
                </div><!-- modal-body -->
                <div class="modal-footer d-flex">
                  <button type="button" class="btn btn-secondary d-inline-block mg-r-auto" onclick="cambiarPantalla('modal')"  data-dismiss="modal">Cerrar</button>
                  <button type="button" class="btn btn-primary d-inline-block mg-l-auto" style="margin-left: auto;" onclick="enviarPromocion()">Enviar Solicitud</button>
                </div>
              </div>
            </div><!-- modal-dialog -->
          </div><!-- modal -->

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
