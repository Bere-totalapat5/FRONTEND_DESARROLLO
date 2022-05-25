@php
  use App\Http\Controllers\clases\humanRelativeDate;
  use App\Http\Controllers\clases\utilidades;
  $humanRelativeDate = new humanRelativeDate();
@endphp
@extends('layouts.index')
@section('contenido-pageheader')
  <ol class="breadcrumb slim-breadcrumb">
   
    <li class="breadcrumb-item"><a href="#">Salas</a></li>
    <li class="breadcrumb-item active" aria-current="page">Activación de Salas</li>
  </ol>
  <h6 class="slim-pagetitle">Activación de Salas</h6>
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

          <div class="col-lg-12">
            <h3 class="card-profile-name">Activación de Salas</h3>
          </div>
  
          <div class="col-lg-4">
              <div class="form-group">
                <label class="form-control-label">Inmueble: {{-- <span class="tx-danger">*</span> --}}</label>
                <select class="form-control select2-show-search valid" id="select_inmueble" name="select_inmueble" autocomplete="off">
                  <option selected disabled value="">Elija una opción</option>
                  @foreach ($inmuebles['response'] as $inmueble)
                       <option value="{{$inmueble['id_inmueble']}}">{{$inmueble['nombre_inmueble']}}</option> 
                  @endforeach
              </select>
              </div>
            </div> 

            <div class="col-lg-12">
                <div class="form-group">
  

<div  id="acordeondiv" role="tablist"> </div>
<div  id="acordeoncont" role="tablist"> </div>
<div  id="acordeonbox" role="tablist"> </div>

                    </select>
                  </div>

            </div>





          <div class="col-lg-12">
            <button class="btn btn-primary btn-block btn-sm mg-t-25" onclick="guardarModificacionSalas();">Guardar</button>
          </div><!-- col-4 -->



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
      color: #000;
    }
    .col-permiso{
      padding: 5px 20px;
      /* background-color: #f8f9fa; */
    }
    .accordion-one .card-header a::before {
      top: 5px !important;
      
    }
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
      padding: 18px 20px;
      color: #154f89;
      position: relative;
      border-bottom: none !important;
      background-color: #fff !important;
   
    }
    .accordion-one{
      max-width: 700px;
      
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




        $('#select_inmueble').change(function(){


       $.ajax({
            type:'POST',
            url:'/public/obtener_salas',
            data:{
            id_inmueble:$('#select_inmueble').val(),
            },
            success:function(response){

              if(response.status==100){
                console.log(response.response);

           

                   let usuarios='';
          let prendido='';

          let  acordeones=[];
          let  acordeonescont=[];
          let  acordeonboxes=[];


    

          $(response.response).each((index, menu_padre)=>{

          const {id_inmueble,nombre_inmueble,unidades,estatus,direccion,descripcion}=menu_padre;

            let accordioncont='';
            let  accordionboxes=' ';
            acordeonboxes=[];




            $(unidades).each((index_s, submenu)=>{ 
              let on='';
              let on2='';
              accordionboxes='';
             // acordeonboxes=[];

              const {id_inmueble,id_unidad_gestion,nombre_unidad,salas,estatus}=submenu; //submenu con salas

              console.log(nombre_unidad);
              console.log(submenu);

              $(salas).each((index_a, sala)=>{ //salas chkbox
                  
                const {id_unidad_gestion,id_sala,id_unidad_sala,nombre_sala,valor,estatus}=sala; //submenu con salas


                    if (valor ==1) {
                      on='checked';
                      } else if (valor ==0){
                      on='';
                    }

                  accordionboxes = accordionboxes +` 
                      <div class="col-sm-6 col-md-4">
                      <label class="ckbox permiso">
                      <input type="checkbox" name="accion" id="accion"  data-id="${id_sala}" class="accion" value="${id_sala}" ${on} ><span>${nombre_sala ?? ""}</span>
                      </label>
                      </div>`;
                       acordeonboxes[index_s]=accordionboxes;

                  
                }); //FIN salas

              


                  accordioncont = accordioncont + `      
            <div id="accordion${index_s}" class="accordion-one mg-b-5" role="tablist" aria-multiselectable="true">
              <div class="card">

                <div class="card-header" role="tab" id="headingOne">
                  <div class="row">
                    
                    <div class="col-7 col-permiso">
                       
                        <span>${nombre_unidad ?? "Sin datos aún"}</span>
                       
                    </div>

                        <div class="col-5 salas">
                          <a data-toggle="collapse" data-parent="#accordion${index_s}" href="#collapseOne${id_unidad_gestion}" aria-expanded="false" aria-controls="collapseOne" class="tx-gray-800 transition collapsed">
                            Salas
                          </a>                
                        </div>

                  </div>
                </div><!-- card-header -->

                        <div id="collapseOne${id_unidad_gestion}" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                  <div class="card-body">
                                              <div class="row">
                                                ${acordeonboxes[index_s] ?? " "}
                                              
                                              </div>
                                  </div>
                        </div>
            </div>
            </div><!-- accordion --> `;  acordeonescont[index]=accordioncont;
 


            });


            /*     if (valor ==1) {
                 prendido='checked';
                } else if (valor ==0) {
                 prendido='';
                } */
    

     if (acordeonescont[index]) {
      acordeonescont[index];
    } else {
      acordeonescont[index]=" Sin unidades asignadas";
    }  

                const accordion = `
                  
                <div class="div-padre">
              <h6 class="mg-t-15 pd-t-5 pd-b-5 mg-b-5 tx-inverse" style="background-color: #f8f9faa !important">
              
                 <span style="font-size: 17px;"><u>${nombre_inmueble ?? ""}</u></span>
               
              </h6>
            </div>

                ` + acordeonescont[index] ;

                   acordeones=acordeones.concat(accordion);
                        
                });

                $('#acordeondiv').html(acordeones);
             //   $('#acordeoncont').html(acordeonescont);



              }else{

                               

                console.log("BAD REQUEST");
              }
       

            }
        }); 

        });

});//strict function 



function guardarModificacionSalas(){

      $('#modal_loading').modal('show');

        const salas=[];
 
        let valor;
        let id;
  
  
        $('.accion').each(function(){
          if($(this).is(':checked')){
            valor=1;
          }else{
            valor=0
          }

          id= $(this).data("id");;

          const accion={
          /*   "tipo_usuario":ID_usuario,
            "id_menu":$(this).val(), */
            "id":id,
            "valor":valor,        
            };
            salas.push(accion);
        }); 

        console.log(salas);

        $.ajax({
          type:'POST',
          url:'/public/guardar_defaultcon',
          data:{
            salas
          },
          success:response=>{

         /*    if(response.status==-1){
              windos.location.reload();
            }else */ if(response.status==100){
       /*        const alert= `<div class="alert alert-success" role="alert" id="alert">
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                              </button>
                              <strong>Hecho!</strong> Cambios realizados satisfactoriamente.
                            </div>`
              $('#alert').html(alert).focus();
              setTimeout(()=>{
                $('#alert').html(``);
              },3000);
           */ 
           $('#modalOk').modal('show');
           
           
           
            }else{
              $('#modalFail').modal('show');

            }
            setTimeout(()=>{
                $('#modal_loading').modal('hide');
            }, 300);
          }
        }); 
      };


  </script>

@endsection


@section('seccion-modales')

<div id="modalOk" class="modal fade">
    <div class="modal-dialog" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-body tx-center pd-y-20 pd-x-20">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <span class="iconify" data-icon="ion-ios-checkmark-circle-outline" data-inline="false"></span>        
            <h4 class=" tx-semibold mg-b-20" style='color:#4CAF50'>Proceso Concluido!</h4>

          <p id="" class="mg-b-20 mg-x-20" style='color:black'>Permisos Asignados Correctamente</p>

          <button type="button" class="btn btn-sucess" style='color:black' data-dismiss="modal" aria-label="Close" >Cerrar</button>
        </div><!-- modal-body -->
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
  </div><!-- modal -->

  <div id="modalFail" class="modal fade">
      <div class="modal-dialog" role="document">
        <div class="modal-content tx-size-sm">
          <div class="modal-body tx-center pd-y-20 pd-x-20">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <span class="iconify" data-icon="akar-icons:circle-x" style='color:red' data-inline="false"></span> 
            <h4 class=" tx-semibold ' mg-b-20" style='color:red'>Proceso Terminado!</h4>
   
            <p id="" class="mg-b-20 mg-x-20" style='color:red'>Permisos no Asignados</p>
  
            <button type="button" class="btn btn-danger pd-x-25" data-dismiss="modal" aria-label="Close" >Cerrar</button>
          </div><!-- modal-body -->
        </div><!-- modal-content -->
      </div><!-- modal-dialog -->
    </div><!-- modal -->

@endsection