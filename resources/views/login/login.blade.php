@extends('layouts.master')

@section('head-title')
Bienvenido al Sistema Integral de Gestion Judicial
@endsection
 
@section('cuerpo') 

<div style="background-color:#FFFFFF; width:100%;">

  <center style="background: linear-gradient(90deg, rgba(244,245,247,1) 0%, rgba(244,245,247,1) 49%, rgba(134,145,55,1) 50%, rgba(134,145,55,1) 100%);margin-left:1%;margin-right:1%; background-size: auto 77px;background-repeat: no-repeat;background-position: center;" id="header_escritorio">
    <img src="/images/header_2.png" style="background-color:#FFFFFF; width:100%; max-width:1400px; padding-top:3px" class="img_header">
  </center>
  <div id="header_movil" style="width:100%; height:90px;">
    
    <div class="cinta_movil">
      <div style="width: 50%;" >
        <div class="logo_tsj" >
          <img src="/images/logo_tsj.png" alt="" style="width: 100%; height:100%;">
        </div>
      </div>
      <div style="width: 50%">
        <div class="logo_penal" >
          <img src="/images/logo_penal.png" alt="" style="width: 100%; height:100%;">
        </div>
      </div>
    </div>

  </div>
</div>

<div class="signin-wrapper" style="min-height: 90vh; margin-top:-50px; ">
  <form action="/" method="POST"> <!-- Al dar click en el botón nos redirecciona a la ruta /,POST, que se encuentra en control_login.php-->
    @if (session('error'))
      <div class="alert alert-danger mg-b-0" role="alert">
        <strong>Error</strong> {!! session('error') !!}
      </div><!-- alert -->
      @endif 

    <div class="signin-box" >

      <h2 class="slim-logo " style="margin-bottom:0px;"><a href=""><img src="/images/LOGO_PJ_vextendida_color.png" style="width:50%;" class="img_header_tsj"></a></h2>
      {{-- <h3 class="signin-title-primary">Bienvenido de regreso!</h3> --}}
      <h3 class="signin-title-secondary" style="margin-bottom:20px;">Inicia sesión para continuar.</h3>

      <div class="form-group">
        <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario">
      </div><!-- form-group -->
      <div class="form-group mg-b-50">
        <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña">
      </div><!-- form-group -->
      <button class="btn btn-primary btn-block btn-signin">Accesar</button>
      {{-- <p class="mg-b-0">No recuerdas tu contraseña? <a href="page-signup.html">Haz click aquí</a></p> --}}
      @if(isset($_GET['soporte']))
        @if($_GET['soporte']=='develope')
          <input type="hidden" value="penal_desarrollo" id="tipo" name="tipo">
        @else
          <input type="hidden" value="penal_soporte" id="tipo" name="tipo">
        @endif
      @else
        <input type="hidden" value="penal_web" id="tipo" name="tipo">
      @endif
    <input type="hidden" value="{{$next}}" id="next" name="next">
    </div><!-- signin-box -->
  </form>
</div><!-- signin-wrapper -->

<style>

  @media screen and (min-width: 576px) and (max-height:700px) {
    .signin-wrapper{
      margin-top:0px !important;
    }
    .img_header_tsj{
      display: none;
    }
  }
  @media screen and (max-width: 600px) {
    .signin-wrapper{
      margin-top:-100px !important;
    }

    .titulo_secundario {
      visibility: hidden;
      clear: both;
      float: left;
      margin: 10px auto 5px 20px;
      width: 28%;
      display: none;
    }
    .slim-logo{
      margin:10px;
    }
    .img_header{
      content:url("/images/header_movil.png");
    }

    .img_header_tsj{
      display: none;
    }
    /* .img_footer{
      margin-top: -100px;
      content:url("/images/Footer_movil.png");
    } */
  }

  .img_header{
    position:unset;
    width:100%;
    max-width:1400px;
  }


  #message_reset {
    
    background: #f1f1f1;
    position: relative;
    padding: 10px;
    margin-top: 10px; 
  }

  #message_reset p {
    padding: 0px 35px;
    
  }

  /* Add a green text color and a checkmark when the requirements are right */
  .valid {
    color: green;
  }

  .valid:before {
    position: relative;
    left: -15px;
    content: "✔";
  }

  /* Add a red text color and an "x" when the requirements are wrong */
  .invalid {
    color: red;
  }

  .invalid:before {
    position: relative;
    left: -15px;
    content: "✖";
  }

  @media only screen and (max-width: 600px) {
    #clock_index {
      font-size: 0.875rem;
      margin-right: 2px;
    }
    #ulBandejas a{
      font-size: 0.631rem;
    }
  }


  /* load */
  *, *::before, *::after {
    box-sizing: border-box;
  }



  .wrapper {
    position: absolute;
    top: 50%;
    left: 50%;
    margin: -10px 0 0 -100px;
    width: 200px;
    height: 20px;
  }

  .border {
    border: 3px solid #272b33;
    height: 100%;
    width: 100%;
    padding: 4px;
  }

  .space {
    position: relative;
    overflow: hidden;
    height: 100%;
    width: 100%;
    margin: 0 auto;
  }

  @keyframes loading {
    0% {
      left: -100%;
    }

    100% {
      left: 100%;
    }
  }

  .loading {
    position: absolute;
    height: 100%;
    width: 100%;
    background-color: #FFF ;
    animation: loading 5s steps(40) infinite;
  }
/* Load */

/* Menu */

  #menu_escritorio{
    display: none;
  }

  #page{
    
    position: relative;
  }

  #menu_movil{
    position: absolute;
    overflow-y: auto;
    height: 100vh;
    background: #FFF;
    width: 0;
    transition: 0.8s;
    z-index: 1031;
    background: rgb(0, 0, 0, 0.25);
  }

  #menu_movil ul{
    font-size: 0;
    padding: 0;
    background: #FFF;
    height: fit-content;
    width: 85%;
  }

  #menu_movil li{
    list-style: none;
    margin: 0px 20px;
  }

  #menu_movil i{
    color: #848F33 !important;
  }

  #menu_movil div.dropdown{
    margin: 0px 20px;
  }

  #menu_movil div.dropdown-menu{
    padding: 10px;
  }
  #menu_movil div.dropdown-menu a{
    margin:10px 0;
    font-size: 1rem;
  }

  #menu_movil a{
    padding: 0;
    background-color: none;
    border: 0;
    color: #000;
    width: 100%;
  }


  #btn-menuMovil{
    font-size: 22px;
  }

  @media only screen and (min-width: 992px) {
    #menu_escritorio{
      display: block;
    }
    #btn-menuMovil{
      display: none;
    }
    #header_movil{
      display: none;
    }
    #menu_movil, .logo_penal, .logo_tsj{
      display: none;
    }
    
  }



  @media only screen and (max-width: 992px) {
    #menu_user{
      display: none;
    }
    #divBandejas{
      display: none;
    }
    #btn-menuD{
      display: none;
    }
    #header{
      position: fixed;
      top: 85px;
      right: 0;
      left: 0;
      z-index: 1030;
    }
    #contenidoS{
      margin-top: 50px; 
    }
    #header_escritorio{
      display: none;
    }
    #header_movil{
      display: flex;
      align-items:center;
    }
    .cinta_movil{
      width: 100%;
      height:64px; 
      display:flex; 
      align-items:center; 
      justify:center; 
      background: linear-gradient(90deg, rgba(244,245,247,1) 0%, rgba(244,245,247,1) 27%, rgba(134,145,55,1) 90%, rgba(134,145,55,1) 84%); 
      background-size: auto 77px;
      background-repeat: no-repeat;
      background-position: center;
    }
    .logo_tsj{
      width: 40%; 
      height:60px; 
      margin:0 auto;
      float: right;
      margin-right:30%;
    }
    .logo_penal{
      width: 85px; 
      height:83px;
      margin:0 auto; 
      float:left; 
      margin-left:30%;
    }

    .dropdown-menu.show{
      max-height: 90vh;
      overflow-y: scroll;
    }
    
  }

  @media only screen and (max-width: 702px) {
    .logo_tsj{
      width: 54%; 
      height:60px; 
      margin:0 auto;
      float: right;
      margin-right:30%;
    }
  }

  @media only screen and (max-width: 502px) {
    .logo_tsj{
      width: 65%; 
      height:54px; 
      margin:0 auto;
      float: right;
      margin-right:26%;
    }
  }

  .submenu{
    height: 0;
    font-size: 0;
  }

  /* Termina menu */
  .pagination-wrapper{
    background: #f8f9fa !important;
  }
  #menu_escritorio .sub-item{
    max-height: 80vh;
    overflow-y: scroll;
  }

  #menu_escritorio .sub-item::-webkit-scrollbar-thumb {
    background: #a8acaf; 
    border-radius: 2px;
  }

  #menu_escritorio .sub-item::-webkit-scrollbar-track {
    background: #fff 
  }
  #menu_escritorio .sub-item::-webkit-scrollbar {
    width: 4px;  
  }
</style>
  
   
@endsection

@section('scripts')
 
@endsection