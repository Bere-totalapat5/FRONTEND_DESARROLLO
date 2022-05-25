@php
    use App\Http\Controllers\clases\humanRelativeDate;
    $humanRelativeDate = new humanRelativeDate();
@endphp

@extends('layouts.index')

@section('contenido-pageheader')
    <ol class="breadcrumb slim-breadcrumb">
        <li class="breadcrumb-item"><a href="/home">Home</a></li>
        <li class="breadcrumb-item">Procesos de trabajo</li>
        <li class="breadcrumb-item active" aria-current="page">Grupos de trabajo</li>
    </ol>
    <h6 class="slim-pagetitle">Grupos de trabajo</h6>
@endsection
 
@section('contenido-principal')

    <div class="section-wrapper " >
        
        
            <div class="col-lg-12">
                <h3 class="card-profile-name">Grupos de trabajo</h3>
            </div>
            
            <div class="col-lg-12 mg-t-5 ">
                 

                    <h5>Permisos de {{$request->session()->get('usuario_nombre')}} - {{$request->session()->get('usuario_nombre_completo')}}</h5>
                        <div id="accordion" class="accordion-one " role="tablist" aria-multiselectable="true" >
                            
                            <div class="card">
                              <div class="card-header" role="tab" id="headingOne">
                                <a data-toggle="collapse" data-parent="#accordion" data-toggle="collapse" href="#collapseOne_{{$request->session()->get('usuario_id')}}" aria-expanded="false" aria-controls="collapseOne" class="collapsed tx-gray-800 transition" style="padding-top: 7px; padding-bottom:7px;" onclick="cargarPermisosUsuarios(this, {{$request->session()->get('usuario_id')}});">
                                  Permisos
                                </a>
                              </div><!-- card-header -->
                 
                              <div id="collapseOne_{{$request->session()->get('usuario_id')}}" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="card-body" id="permisos_{{$request->session()->get('usuario_id')}}">
                                  
                                </div>
                              </div>
                            </div>
                            

                            <div class="card">
                              <div class="card-header" role="tab" id="headingTwo">
                                <a class="collapsed tx-gray-800 transition" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo_{{$request->session()->get('usuario_id')}}" aria-expanded="false" aria-controls="collapseTwo" style="padding-top: 7px; padding-bottom:7px;" onclick="cargarMenuUsuarios(this, {{$request->session()->get('usuario_id')}});">
                                  Menu
                                </a>
                              </div>
                              <div id="collapseTwo_{{$request->session()->get('usuario_id')}}" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
                                <div class="card-body" id="menu_{{$request->session()->get('usuario_id')}}">
                                  
                                </div>
                              </div>
                            </div>
                          </div><!-- accordion -->


 


@isset($lista_grupos['response']['auxiliares'])

<br><hr>


                      <a href="javascript:void(0);" data-toggle="modal" data-target="#modaldemo3" onclick="llenarParticipantes({{$lista_grupos['response']['auxiliares'][0]['id_grupo_trabajo']}},{{$lista_grupos['response']['auxiliares'][0]['id_usuario']}},'{{$lista_grupos['response']['auxiliares'][0]['tipo_usuario']}}');" style="float: right;">Agregar usuario al grupo de trabajo</a>

                        <div class="table-wrapper">

                            


                            <table id="datatable1" class="table display responsive nowrap">
                                <thead>
                                    <tr>
                                        <th>Estatus</th>
                                        <th>Usuario</th>
                                        <th>Nombre</th>
                                        <th>Puesto</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody> 
                                    @php $bandera=0; @endphp
                                  @isset($lista_grupos['response']['auxiliares'])
                                    @foreach ($lista_grupos['response']['auxiliares'] as $grupo)
                                        
                                        
                                            @php $bandera=1; @endphp
                                            <tr>
                                                <td scope="row">@if($grupo['estatus_actividad']=='validado')<span style="color:green;"><i class="fa fa-check"></i> {{$grupo['estatus_actividad']}}</span>@else <span style="color:red;"><i class="fa fa-exclamation"></i> {{$grupo['estatus_actividad']}}</span> @endif</td>
                                                <td>{{$grupo['nombre_clave']}} </td>
                                                <td>{{$grupo['nombre']}}</td>
                                                <td>{{$grupo['tipo_usuario']}}</td>
                                                <td><a href="javascript:void(0);" onclick="agregarUsuarioGrupo(1, '{{$grupo['id_usuario']}}-{{$grupo['id_grupo_trabajo']}}-{{$grupo['id_grupo_trabajo_superior']}}');">Eliminar</a></td>
                                            </tr>

                                            <tr>
                                                <td colspan="5" style="padding: 0px; margin:0px; padding-bottom:20px;">
                            

                                                    <div id="accordion" class="accordion-one " role="tablist" aria-multiselectable="true" >
                                                        
                                                        <div class="card">
                                                          <div class="card-header" role="tab" id="headingOne">
                                                            <a data-toggle="collapse" data-parent="#accordion" data-toggle="collapse" href="#collapseOne_{{$grupo['id_usuario']}}" aria-expanded="false" aria-controls="collapseOne" class="collapsed tx-gray-800 transition" style="padding-top: 7px; padding-bottom:7px;" onclick="cargarPermisosUsuarios(this, {{$grupo['id_usuario']}});">
                                                              Permisos
                                                            </a>
                                                          </div><!-- card-header -->
                                            
                                                          <div id="collapseOne_{{$grupo['id_usuario']}}" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                                            <div class="card-body" id="permisos_{{$grupo['id_usuario']}}">
                                                              
                                                            </div>
                                                          </div>
                                                        </div>
                                                        

                                                        <div class="card">
                                                          <div class="card-header" role="tab" id="headingTwo">
                                                            <a class="collapsed tx-gray-800 transition" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo_{{$grupo['id_usuario']}}" aria-expanded="false" aria-controls="collapseTwo" style="padding-top: 7px; padding-bottom:7px;" onclick="cargarMenuUsuarios(this, {{$grupo['id_usuario']}});">
                                                              Menu
                                                            </a>
                                                          </div>
                                                          <div id="collapseTwo_{{$grupo['id_usuario']}}" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
                                                            <div class="card-body" id="menu_{{$grupo['id_usuario']}}">
                                                              
                                                            </div>
                                                          </div>
                                                        </div>
                                                      </div><!-- accordion -->


                                                </td>
                                            </tr>
                                        

                                    @endforeach
                                  @endisset
                                </tbody>
                            </table>
                        </div>
@endisset

            </div>
        
        
    </div>
@endsection

@section('seccion-estilos')
    <link href="{{ $entorno["version_pages"]["version"] }}/lib/select2/css/select2.min.css" rel="stylesheet">

    <style>
        .accordion-one .card-header a::before{
            top: 8px!important;
        }
        

 

       
    .ckbox span:before, .ckbox span:after {
      line-height: 18px;
      position: absolute; }
    .ckbox span:before {
      
      background-color: #fff;
      border: 1px solid #adb5bd!important;
      }
    


    </style>
@endsection

@section('seccion-scripts-libs')
    <script src="{{ $entorno["version_pages"]["version"] }}/lib/select2/js/select2.min.js"></script>
@endsection

@section('seccion-scripts-functions')
  <script>
   

    $(function(){
      setTimeout(function(){
        $('#modal_loading').modal('hide');
      }, 500);
    });

      

    function agregarUsuarioGrupo(eliminar, usuario_grupo_id=""){
        
        if(usuario_grupo_id==""){
            usuario_grupo_id=$( "#usuario_grupo_id option:selected" ).val();
        }
        
        $.ajax({
            type:'POST',
            url:'/procesosTrabajo/grupos/guardarAgregarUsuario',
            data:{ eliminar:eliminar, usuario_grupo_id: usuario_grupo_id },
            success:function(data){
                console.log(data);
                if(data.status==100){
                    alert(data[0].message);
                    location='/procesosTrabajo/grupos/';
                }
                else{
                    alert(data[0].message);
                }
                location='/procesosTrabajo/grupos/';
            }
        });

    }
    
    function cargarPermisosUsuarios(boton, usuario_id){
        
        if($(boton).hasClass('collapsed')){
            $.ajax({
                type:'POST',
                url:'/procesosTrabajo/grupos/cargarPermisosUsuarios',
                data:{ usuario_id:usuario_id },
                success:function(data){
                    console.log(data);
                    $('#permisos_'+usuario_id).html(data.html);
                }
            });
        }
    }


    function cargarMenuUsuarios(boton, usuario_id){

        if($(boton).hasClass('collapsed')){
            $.ajax({
                type:'POST',
                url:'/procesosTrabajo/grupos/cargarMenusUsuarios',
                data:{ usuario_id:usuario_id },
                success:function(data){
                    console.log(data);
                    $('#menu_'+usuario_id).html(data.html);
                }
            });
        }
    }

    function llenarParticipantes(){
       

        $('#modaldemo3').find('.modal-header').html('');
        $('#modaldemo3').find('.modal-body').html('<div class="col-md-12 col-xl-12"><div class="d-flex  ht-300 pos-relative align-items-center">    <div class="sk-three-bounce">        <div class="sk-child sk-bounce1 bg-gray-800"></div>        <div class="sk-child sk-bounce2 bg-gray-800"></div>        <div class="sk-child sk-bounce3 bg-gray-800"></div>      </div> </div><!-- d-flex --></div><!-- col-4 -->');
        $.ajax({
            type:'POST',
            url:'/procesosTrabajo/grupos/agregarUsuario',
            data:{  },
            success:function(data){
                console.log(data);
                $('#modaldemo3').find('.modal-header').html(data[0].plantilla_archivo_header);
                $('#modaldemo3').find('.modal-body').html(data[0].plantilla_archivo_body);
            }
        });
    }

    function guardarMenu(checkbox, id_usuario, menu_id){
        activo=0;
        if($(checkbox).is(':checked')) {
            activo=1;
            
        }

        $.ajax({
            type:'POST',
            url:'/procesosTrabajo/grupos/guardarMenusUsuarios',
            data:{ id_usuario:id_usuario, menu_id:menu_id, activo:activo  },
            success:function(data){
                console.log(data);
                
            }
        });
    }


    function guardarAccion(checkbox, id_usuario, menu_id){
        activo=0;
        if($(checkbox).is(':checked')) {
            activo=1;
        }

        $.ajax({
            type:'POST',
            url:'/procesosTrabajo/grupos/guardarAccionUsuarios',
            data:{ id_usuario:id_usuario, menu_id:menu_id, activo:activo  },
            success:function(data){
                console.log(data);
                
            }
        });
    }
    

      
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