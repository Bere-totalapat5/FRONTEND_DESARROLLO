@php
	$estilos_version="pages-5.0.3";
@endphp

@extends('layouts.master')

@section('head-title')
Bienvenidos a SASFam
@endsection


@section('cuerpo')

<div class="login-wrapper ">
      <!-- START Login Background Pic Wrapper-->
      <div class="bg-pic">
        <!-- START Background Caption-->
        <div class="bg-caption pull-bottom sm-pull-bottom text-white p-l-20 m-b-20">
          <h1 class="semi-bold text-white">
					Meet pages - The simplest and fastest way to build web UI for your dashboard or app.</h1>
          <p class="small">
            Our beautifully-designed UI Framework come with hundreds of customizable features. Every Layout is just a starting point. ©2019-2020 All Rights Reserved. Pages® is a registered trademark of Revox Ltd.
          </p>
        </div>
        <!-- END Background Caption-->
      </div>
      <!-- END Login Background Pic Wrapper-->
      <!-- START Login Right Container-->
      <div class="login-container bg-white">
        <div class="p-l-50 p-r-50 p-t-50 m-t-30 sm-p-l-15 sm-p-r-15 sm-p-t-40">
          <img src="assets/img/logo-48x48_c.png" alt="logo" data-src="assets/img/logo-48x48_c.png" data-src-retina="assets/img/logo-48x48_c@2x.png" width="48" height="48">
          <h2 class="p-t-25">Bienvenidos a<br/> SASFAM</h2>
          <p class="mw-80 m-t-5">Iniciar sesión en su cuenta</p>
          <!-- START Login Form -->
          <form id="form-login" class="p-t-15" role="form" action="/" method="post">
            <!-- START Form Control-->
            <div class="form-group form-group-default">
              <label>Usuario</label>
              <div class="controls">
                <input type="text" name="username" id="username" placeholder="" class="form-control" value="@if( isset($error) ) {{ $username }} @endif" required>
              </div>
            </div>
            <!-- END Form Control-->
            <!-- START Form Control-->
            <div class="form-group form-group-default">
              <label>Contraseña</label>
              <div class="controls">
                <input type="password" class="form-control" name="password" id="password" placeholder="" value="@if( isset($error) ) {{ $password }} @endif" required>
              </div>
            </div>
            <!-- START Form Control-->
            <div class="row">
              <div class="col-md-6 no-padding sm-p-l-10">
                
              </div>
              <div class="col-md-6 d-flex align-items-center justify-content-end">
                <button aria-label="" class="btn btn-primary btn-lg m-t-10" type="submit">Entrar</button>
              </div>
            </div>
            <div class="m-b-5 m-t-30">
              <a href="#" class="normal">Lost your password?</a>
            </div>
            <div>
              <a href="#" class="normal">Aviso de privacidad.</a>
            </div>
            <!-- END Form Control-->
          </form>
          <!--END Login Form-->
          <div class="pull-bottom sm-pull-bottom">
            <div class="m-b-30 p-r-80 sm-m-t-20 sm-p-r-15 sm-p-b-20 clearfix">
              <div class="col-sm-9 no-padding m-t-10">
                <p class="small-text normal hint-text">
                  ©2019-2020 All Rights Reserved. Pages® is a registered trademark of Revox Ltd. <a href="">Cookie Policy</a>, <a href=""> Privacy and Terms</a>.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- END Login Right Container-->
    </div>
    <!-- START OVERLAY -->
	
@endsection

@section('scripts')
 <!-- END VENDOR JS -->
    <script src="{{ $estilos_version }}/pages/js/pages.min.js"></script>
    <script>
    $(function(){
      $('#form-login').validate();
    })
    </script>
@endsection