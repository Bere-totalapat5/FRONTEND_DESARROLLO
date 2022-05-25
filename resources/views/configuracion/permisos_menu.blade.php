@php
  use App\Http\Controllers\clases\humanRelativeDate;
  use App\Http\Controllers\clases\utilidades;
  $humanRelativeDate = new humanRelativeDate();
@endphp
@extends('layouts.index')
@if(!isset($request->menu_general['response']))
@php header("Location: " . URL::to('/menu_permisos'), true, 302);
  exit();
@endphp
@endif
@section('contenido-pageheader')
  <ol class="breadcrumb slim-breadcrumb">
    <li class="breadcrumb-item"><a href="/home">Home</a></li>
    <li class="breadcrumb-item"><a href="#">Permisos</a></li>
    <li class="breadcrumb-item active" aria-current="page">Permisos del Menú</li>
  </ol>
  <h6 class="slim-pagetitle">Permisos del Menú</h6>
@endsection
@section('contenido-principal')
  {{-- @if($error!="")
    <div class="alert alert-warning" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <strong>Alerta!</strong> {{$error}}.
    </div><!-- alert -->
  @endif --}}
  <div class="section-wrapper">
    @if(!1==1)
    {{-- @if(!utilidades::buscarPermisoMenu($request->menu_general['response'], 1, 0) && !utilidades::buscarPermisoMenu($request->menu_general['response'], 2, 0)) --}}
      <h1 class="mg-b-50">No tiene permiso para acceder a esta sección, verifíquelo con su titular</h1>
      <a href="/home"><button class="btn btn-primary btn-block">Regresar al inicio</button><a>
    @else
      <div id="alert"></div>
      <input type="hidden" name="usuario" id="usuario" value="{{$id_usuario}}">
      <div class="row">
        <div class="col-lg-12">
          <h3 class="card-profile-name">Permisos del Menú</h3>
        </div>
        <div class="col-lg-12">
          {{-- {{dd($lista_permisos_menu)}} --}}
          @foreach ($lista_permisos_menu['response'] as $menus)
          {{-- {{dd($lista_permisos_menu['response'])}} --}}
            <div class="div-padre">
              <h6 class="mg-t-15 pd-t-5 pd-b-5 mg-b-5 tx-inverse" style="background-color: #f8f9faa !important">
                <label class="ckbox permiso mg-l-16">
                  <input type="checkbox" name="menu" class="menu padre" id="{{$menus['permiso_id']}}" value="{{$menus['permiso_id']}}" @if($menus['permiso_valor']==1) checked @endif><span style="font-size: 17px;"><u>{{$menus['descripcion']}}</u></span>
                </label>
              </h6>
            </div>
            @foreach ($menus['submenus'] as $submenus)
            <div id="accordion{{$submenus['permiso_id']}}" class="accordion-one mg-b-5" role="tablist" aria-multiselectable="true">
              <div class="card">
                <div class="card-header" role="tab" id="headingOne">
                  <div class="row">
                    <div class="col-7 col-permiso">
                        <label class="ckbox permiso">
                          <input type="checkbox" name="menu" class="menu submenu" data-padre="{{$menus['permiso_id']}}" value="{{$submenus['permiso_id']}}" @if($submenus['permiso_valor']==1) checked @endif><span>{{$submenus['descripcion']}}</span>
                        </label>
                    </div>
                    <div class="col-5 acciones">
                      <a data-toggle="collapse" data-parent="#accordion{{$submenus['permiso_id']}}" href="#collapseOne{{$submenus['permiso_id']}}" aria-expanded="false" aria-controls="collapseOne" class="tx-gray-800 transition collapsed">
                        Acciones
                      </a>
                    </div>
                  </div>
                </div><!-- card-header -->
                <div id="collapseOne{{$submenus['permiso_id']}}" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="card-body">
                    <div class="row">
                      @foreach ($submenus['acciones_interfaz'] as $accion)
                        <div class="col-sm-6 col-md-4">
                          <label class="ckbox permiso">
                            <input type="checkbox" name="accion" class="accion" value="{{$accion['id_usuario_accion']}}" @if($accion['valor']==1) checked @endif><span>{{$accion['descripcion_accion']}}</span>
                          </label>
                        </div>
                      @endforeach
                    </div>
                  </div>
                </div>
              </div>
            </div><!-- accordion -->
            @endforeach
          @endforeach
        </div>
        <div class="col-lg-12">
          <button class="btn btn-primary btn-block btn-sm mg-t-25" onclick="guardarPermisos();">Guardar</button>
        </div><!-- col-4 -->
      </div>
    @endif
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

  a.transition {
    /* display: inline-block !important; */
    /* font-weight: 300; */
    margin-top: 3px;
    padding: 5px 20px !important;
  }
  .col-6.acciones{
    padding-left: 0;
    text-align: center;
  }
  .card-header .row{
    padding-left: 15px;
    padding-right: 15px;
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
@endsection
@section('seccion-scripts-functions')
  <script>
      setTimeout(function(){
          $('#modal_loading').modal('hide');
      }, 2000);

      $('.transition').click(function(){
        if(!$(this).hasClass('tx-gray-800 transition collapsed')){
          $(this).parent().parent().find('.col-permiso, .acciones').css({'border-bottom':'none'})
        }else{
          $(this).parent().parent().find('.col-permiso, .acciones').css({'border-bottom':'1px solid #ced4da'})
        }
      });

      $('.submenu').click(function(){
        const padre=$(this).attr('data-padre');
        $('#'+padre).prop("checked", true); 
      });

      $('.padre').click(function() {
        const id = $(this).attr('id');
        if($(this).is(':checked')){
          $('input[data-padre='+id+']').prop("checked", true);
        }else{
          $('input[data-padre='+id+']').prop("checked", false);
        }
      })

      function guardarPermisos(){
        $('#modal_loading').modal('show');

        const permisos=[],
            acciones=[];
        let valor;
  
        $('.menu').each(function(){
          if($(this).is(':checked')){
            valor=1;
          }else{
            valor=0
          }
          const permiso={
            "id_menu":$(this).val(),
            "valor":valor
            };
          permisos.push(permiso);
        });

        $('.accion').each(function(){
          if($(this).is(':checked')){
            valor=1;
          }else{
            valor=0
          }
          const accion={
            "id_menu":$(this).val(),
            "valor":valor
            };
          acciones.push(accion);
        });

        console.log(acciones);
        console.log(permisos);
        $.ajax({
          type:'POST',
          url:'/public/guardar_permisos',
          data:{
            permisos,
            acciones,
            usuario:$('#usuario').val(),
          },
          success:response=>{
            if(response.status==-1){
              windos.location.reload();
            }else if(response.status==100){
              const alert= `<div class="alert alert-success" role="alert" id="alert">
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                              </button>
                              <strong>Hecho!</strong> Cambios realizados satisfactoriamente.
                            </div>`
              $('#alert').html(alert).focus();
              setTimeout(()=>{
                $('#modal_loading').modal('hide');
                window.location.reload();
                $('#alert').html(``);
              },300);
            }else{
              alert(response.message);
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
@endsection