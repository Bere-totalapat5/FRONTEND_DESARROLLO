@php
use App\Http\Controllers\clases\utilidades;
@endphp

@extends('layouts.master')

@section('head-title')
  Sistema Integral de Gestion Judicial  
@endsection

@section('cuerpo') 
@php
if ($request->session()->get("sesion_tipo")=="soporte"){
  
  //print_r($sesion); 
}
//phpinfo();
@endphp

<div style="background-color:#FFFFFF; width:100%;">
@if ($request->session()->get("sesion_tipo")=="soporte")
  <div class="alert alert-warning" role="alert">
    <strong>Sesion de soporte</strong> Usted acaba de iniciar la sesión en modo soporte.
  </div><!-- alert -->
@endif
  <center><img src="/images/header.png" style="background-color:#FFFFFF; width:100%; max-width:1400px;" class="img_header"></center>
</div>
  <div class="slim-header">
    
    

    <div class="container">
      <div class="slim-header-left" style="width:100%;">

        <div class="col-6 col-sm-6 col-sm-6 col-md-4">

          <div class="dropdown dropdown-demo" >
            <a href="#" class="dd-link" data-toggle="dropdown" >
              <div style="border: none; padding:0px;">
                @if(isset($sesion['ministerio_ley_status']) and $sesion['ministerio_ley_status']=='si')
                  <i class="fa fa-exclamation-triangle" style="font-size: 20px; padding-right:5px; color:red;"></i>
                @endif
                <span>
                <div class="organo_desktop">@yield('contenido-pageheader-organo')</div>
                <div class="organo_movil" style="display: none;"><small>{{$sesion['juzgado_nombre_corto']}}</small></div>
                <h4 style="margin-bottom:0px;" class="tx-bold tx-inverse titulo-primario">{{strtoupper($sesion['usuario_nombre'])}}</h4>
                </span>
                <i class="fa fa-angle-down mg-l-5"></i>
              </div>
            </a>
            <div class="dropdown-menu pd-0 wd-sm-350">
              <div style="padding: 10px;">

                <div class="" >Oralidad</div>
                <h6 style="margin-bottom:0px;" class="tx-bold tx-inverse titulo-primario">{{strtoupper($sesion['juzgado_nombre_largo'])}}</h6>

                <div class="" style="padding-top: 5px;">Usuario</div>
                <h6 style="margin-bottom:0px;" class="tx-bold tx-inverse titulo-primario">{{strtoupper($sesion['usuario_nombre'])}}</h6>

                <div class="" style="padding-top: 5px;">Nombre</div>
                <h6 style="margin-bottom:0px;" class="tx-bold tx-inverse titulo-primario">{{strtoupper($sesion['usuario_nombre_completo'])}}</h6>

                <div class="" style="padding-top: 5px;">Puesto</div>
                @if(strtoupper($sesion['tipo_usuario_descripcion'])=="JUEZ MAGISTRADO")
                  <h6 style="margin-bottom:0px;" class="tx-bold tx-inverse titulo-primario">{{$request->lang['MAGISTRADO']}}</h6>
                @else
                  <h6 style="margin-bottom:0px;" class="tx-bold tx-inverse titulo-primario">{{strtoupper($sesion['tipo_usuario_descripcion'])}}</h6>
                @endif


                

                <div class="" style="padding-top: 5px;">Area de trabajo</div>
                <h6 style="margin-bottom:0px;" class="tx-bold tx-inverse titulo-primario">{{strtoupper($sesion['grupo_trabajo_tipo_area'])}} @if($sesion['usuario_secretaria']!="") {{$sesion['usuario_secretaria']}} @endif</h6>

                @if(isset($sesion['ministerio_ley_status']) and $sesion['ministerio_ley_status']=='si')
                <hr>
                <h6 style="margin-bottom:0px; color:red;" class="tx-bold tx-inverse titulo-primario"><i class="fa fa-exclamation-triangle" style="color:red;"></i> MINISTERIO DE LEY ACTIVADO</h6>

                @if($sesion['ministerio_ley_sustituido_por']!="")
                  <div class="" style="padding-top: 5px;">Sustituido por</div>
                  <h6 style="margin-bottom:0px;" class="tx-bold tx-inverse titulo-primario">{{strtoupper($sesion['ministerio_ley_sustituido_por'])}}</h6>
                @else
                  <div class="" style="padding-top: 5px;">Sustituye a</div>
                  <h6 style="margin-bottom:0px;" class="tx-bold tx-inverse titulo-primario">{{strtoupper($sesion['ministerio_ley_sustituye_a'])}}</h6>
                @endif
                <div class="" style="padding-top: 5px;">Puesto</div>
                @if(strtoupper($sesion['ministerio_ley_rol'])=="JUEZ MAGISTRADO")
                  <h6 style="margin-bottom:0px;" class="tx-bold tx-inverse titulo-primario">MAGISTRADO</h6>
                @else
                  <h6 style="margin-bottom:0px;" class="tx-bold tx-inverse titulo-primario">{{strtoupper($sesion['ministerio_ley_rol'])}}</h6>
                @endif
                
                

                @endif
                

              </div>
              <!--
              <ul class="nav nav-tabs nav-tabs-dropdown nav-justified" role="tablist">
                <li class="nav-item">
                  <a class="nav-link pd-y-10 active" data-toggle="tab" href="#tabRegular" role="tab">Regular</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link pd-y-10" data-toggle="tab" href="#tabExtended" role="tab">Extended</a>
                </li>
              </ul>
              <!-- Tab panes -- >
              <div class="tab-content pd-30">
                <div class="tab-pane active" id="tabRegular" role="tabpanel">
                  <h1 class="dropdown-tab-price">$16</h1>
                  <h6 class="dropdown-tab-label">Regular License</h6>
                  <p class="mg-b-0 tx-13">Use, by you or one client, in a single end product which end users are not charged for. The total price includes the item price and a buyer fee.</p>
                </div>
                <div class="tab-pane" id="tabExtended" role="tabpanel">
                  <h1 class="dropdown-tab-price">$799</h1>
                  <h6 class="dropdown-tab-label">Extended License</h6>
                  <p class="mg-b-0 tx-13">Use, by you or one client, in a single end product which end users can be charged for. The total price includes the item price and a buyer fee.</p>
                </div>
              </div>
            -->
            </div><!-- dropdown-menu -->
          </div>
      


          
        </div>

        

        <div class="col-md-3 col-sm-4">
          <div class="dash-content" style="align:center;">
            <div class="titulo_secundario_horario_min"><small>@if(in_array(date('Y-m-d'), $request->dias_festivos_arr)) día inhábil @else {{$request->fecha_movil}} @endif</small></div>
            <div class="titulo_secundario">@if(in_array(date('Y-m-d'), $request->dias_festivos_arr)) día inhábil @else cierre {{ $sesion['horario_cierre'] }} hrs @endif</div>
            <h4 style="margin-bottom:0px;" class="tx-bold tx-inverse titulo-primario-reloj @if(in_array(date('Y-m-d'), $request->dias_festivos_arr)) reloj_vencido @endif" id="clock_index"></h4>
          </div>
        </div>

      <div class="col-md-5 col-sm-0 stage_fecha">
        <div class="dash-content">
          <h4 style="margin-bottom:0px;" class="tx-bold tx-inverse titulo_secundario custom-cells">
            {{$request->fecha_desktop}}
            <input type="text" id="dp" style="visibility: hidden; width:0px;">
            <i class="fa fa-calendar custom-cells" id="custom-cells" style=""></i>
          </h4>
        </div>
      </div>

      </div><!-- slim-header-left -->


      <div class="slim-header-right" >
        <!--
        <div class="dropdown dropdown-a" id="actividad_div" style="display:none;">
          <a href="" class="header-notification" data-toggle="dropdown">
            <i class="icon ion-ios-bolt-outline"></i>
          </a>
          <div class="dropdown-menu">
            <div class="dropdown-menu-header">
              <h6 class="dropdown-menu-title">Activity Logs</h6>
              <div>
                <a href="">Filter List</a>
                <a href="">Settings</a>
              </div>
            </div><!-- dropdown-menu-header -- >
            <div class="dropdown-activity-list">
              <div class="activity-label">Today, December 13, 2017</div>
              <div class="activity-item">
                <div class="row no-gutters">
                  <div class="col-2 tx-right">10:15am</div>
                  <div class="col-2 tx-center"><span class="square-10 bg-success"></span></div>
                  <div class="col-8">Purchased christmas sale cloud storage</div>
                </div><!-- row -- >
              </div><!-- activity-item -- >
              <div class="activity-item">
                <div class="row no-gutters">
                  <div class="col-2 tx-right">9:48am</div>
                  <div class="col-2 tx-center"><span class="square-10 bg-danger"></span></div>
                  <div class="col-8">Login failure</div>
                </div><!-- row -- >
              </div><!-- activity-item -- >
              <div class="activity-item">
                <div class="row no-gutters">
                  <div class="col-2 tx-right">7:29am</div>
                  <div class="col-2 tx-center"><span class="square-10 bg-warning"></span></div>
                  <div class="col-8">(D:) Storage almost full</div>
                </div><!-- row -- >
              </div><!-- activity-item -- >
              <div class="activity-item">
                <div class="row no-gutters">
                  <div class="col-2 tx-right">3:21am</div>
                  <div class="col-2 tx-center"><span class="square-10 bg-success"></span></div>
                  <div class="col-8">1 item sold <strong>Christmas bundle</strong></div>
                </div><!-- row -- >
              </div><!-- activity-item -- >
              <div class="activity-label">Yesterday, December 12, 2017</div>
              <div class="activity-item">
                <div class="row no-gutters">
                  <div class="col-2 tx-right">6:57am</div>
                  <div class="col-2 tx-center"><span class="square-10 bg-success"></span></div>
                  <div class="col-8">Earn new badge <strong>Elite Author</strong></div>
                </div><!-- row -- >
              </div><!-- activity-item -- >
            </div><!-- dropdown-activity-list -- >
            <div class="dropdown-list-footer">
              <a href="page-activity.html"><i class="fa fa-angle-down"></i> Show All Activities</a>
            </div>
          </div><!-- dropdown-menu-right -- >
        </div><!-- dropdown -- >



        <div class="dropdown dropdown-b">
          <a href="" class="header-notification" data-toggle="dropdown" style="display:none;">
            <i class="icon ion-ios-bell-outline"></i>
            <span class="indicator"></span>
          </a>
          <div class="dropdown-menu">
            <div class="dropdown-menu-header">
              <h6 class="dropdown-menu-title">Notifications</h6>
              <div>
                <a href="">Mark All as Read</a>
                <a href="">Settings</a>
              </div>
            </div><!-- dropdown-menu-header -- >
            <div class="dropdown-list">
              <!-- loop starts here -- >
              <a href="" class="dropdown-link">
                <div class="media">
                  <img src="http://via.placeholder.com/500x500" alt="">
                  <div class="media-body">
                    <p><strong>Suzzeth Bungaos</strong> tagged you and 18 others in a post.</p>
                    <span>October 03, 2017 8:45am</span>
                  </div>
                </div><!-- media -- >
              </a>
              <!-- loop ends here -- >
              <a href="" class="dropdown-link">
                <div class="media">
                  <img src="http://via.placeholder.com/500x500" alt="">
                  <div class="media-body">
                    <p><strong>Mellisa Brown</strong> appreciated your work <strong>The Social Network</strong></p>
                    <span>October 02, 2017 12:44am</span>
                  </div>
                </div><!-- media -- >
              </a> 
              <a href="" class="dropdown-link read">
                <div class="media">
                  <img src="http://via.placeholder.com/500x500" alt="">
                  <div class="media-body">
                    <p>20+ new items added are for sale in your <strong>Sale Group</strong></p>
                    <span>October 01, 2017 10:20pm</span>
                  </div>
                </div><!-- media -- >
              </a>
              <a href="" class="dropdown-link read">
                <div class="media">
                  <img src="http://via.placeholder.com/500x500" alt="">
                  <div class="media-body">
                    <p><strong>Julius Erving</strong> wants to connect with you on your conversation with <strong>Ronnie Mara</strong></p>
                    <span>October 01, 2017 6:08pm</span>
                  </div>
                </div><!-- media -- >
              </a>
              <div class="dropdown-list-footer">
                <a href="page-notifications.html"><i class="fa fa-angle-down"></i> Show All Notifications</a>
              </div>
            </div><!-- dropdown-list -- >
          </div><!-- dropdown-menu-right -- >
        </div><!-- dropdown -->



        <div class="dropdown dropdown-c">
          <a href="#" class="logged-user" data-toggle="dropdown">
            <img src="/images/logo.png" alt="">
            <span>@yield('contenido-pageheader-usuario')</span>
            <i class="fa fa-angle-down"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right">
            <nav class="nav">
              <!--
              <a href="page-profile.html" class="nav-link"><i class="icon ion-person"></i> View Profile</a>
              <a href="page-edit-profile.html" class="nav-link"><i class="icon ion-compose"></i> Edit Profile</a>
              <a href="page-activity.html" class="nav-link"><i class="icon ion-ios-bolt"></i> Activity Log</a>
              -->
              <a href="" class="nav-link" data-toggle="modal" data-target="#modal_aviso_privacidad"><i class="icon ion-ios-gear"></i> Aviso de privacidad</a>
              <a href="/logout" class="nav-link"><i class="icon ion-forward"></i> Salir</a>
            </nav>
          </div><!-- dropdown-menu -->
        </div><!-- dropdown -->
      </div><!-- header-right -->
    </div><!-- container -->
  </div><!-- slim-header -->


  <!-- MENU DE ABAJO  -->
  <!-- <li class="nav-item with-sub active">  -->
  @isset($request->menu_general['response'])
    <div class="slim-navbar">
      <div class="container"> 
        <ul class="nav">
          @php $descripcion=""; @endphp
          @foreach ($request->menu_general['response'] as $menu)
        <li class="nav-item @isset($menu['submenus'][0]) with-sub @endisset  @if(strtoupper($menu['descripcion'])=='LIBROS DE GOBIERNO') mega-dropdown @endif ">
              <a class="nav-link" href="javascript:void(0);">
                  <span>{{ $menu["descripcion"] }}</span>
                  @php $descripcion=$menu["descripcion"]; @endphp
              </a>

              @foreach ($menu['submenus'] as $submenu )
                @if($loop->first and (strtoupper($descripcion)=='LIBROS DE GOBIERNO'))
                <div class="sub-item" style="">
                  <div class="row">
                    <div class="col-lg-12">
                      
                      <div class="row">
                        <div class="col">
                          <ul>
                @elseif($loop->first)
                  <div class="sub-item">
                    <ul>
                @endif
                

                @if($submenu['descripcion']=='<hr>')
                  <hr>
                @elseif($submenu['descripcion']=='<divisionmenu>')
                    </ul>
                  </div><!-- col -->
                  <div class="col-lg">
                    <ul>
                @else
                  <li><a href="{{$submenu['vista']}}" >{{$submenu['descripcion']}}</a></li>
                @endif


                @if($loop->last and (strtoupper($descripcion)=='LIBROS DE GOBIERNO'))
                          </ul>
                        </div><!-- col -->
                      </div><!-- row -->
                    </div>
                  </div>
                </div>
                @elseif($loop->last)
                    </ul>
                  </div>
                @endif
              @endforeach
            </li>
          @endforeach
        </ul>
      </div><!-- container -->
    </div><!-- slim-navbar -->
  @endisset

  <div class="slim-mainpanel">


    <div class="container">


      
      <div class="slim-pageheader">
        @yield('contenido-pageheader')
      </div><!-- slim-pageheader -->


      <div class="manager-wrapper">
        <div class="manager-right" style=""> 
          @yield('contenido-principal')
        </div>
           
      </div>
    </div><!-- container -->
  </div><!-- slim-mainpanel -->

  <div class="slim-footer">
    <div class="container" style="height:20px;">
      <!--
      <p>Copyright 2018 &copy; All Rights Reserved. Slim Dashboard Template</p>
      <p>Designed by: <a href="">ThemePixels</a></p>
      -->
    </div><!-- container -->
  </div><!-- slim-footer -->

@endsection

@section('modales')
    <!-- MODAL ALERT MESSAGE -->
    <div id="modal_loading" class="modal fade">
      <div class="modal-dialog" role="document">
        <div class="modal-content tx-size-sm">
          <div class="modal-body tx-center pd-y-20 pd-x-20">
            <div class="sk-chasing-dots tx-success" style="width: 100px; height: 100px;">
              <div class="sk-child sk-dot1 bg-gray-500"></div>
              <div class="sk-child sk-dot2 bg-gray-500"></div>
            </div>
            <h4 class="tx-gray-800 tx-semibold mg-b-20">Procesando, espere un momento...</h4>
            <p class="mg-b-20 mg-x-20" id="mensaje_procesos">Se esta procesando su información, favor de esperar un momento...</p>
          </div><!-- modal-body -->
        </div><!-- modal-content -->
      </div><!-- modal-dialog -->
    </div><!-- modal -->

    <!-- MODAL NOTIFICACIONES -->
    @if($request->session()->get('bandera_aviso')==1)
      <div id="modal_notificaciones" class="modal fade">
        <div class="modal-dialog" role="document">
          <div class="modal-content tx-size-sm">
            <div class="modal-body tx-center pd-y-20 pd-x-20">
              <h3 class="tx-gray-800 tx-semibold mg-b-20"><br>Aviso de Privacidad</h3>
              <div class="mg-b-20" >
                <strong class="tx-gray-800">Sistema Integral para la Consulta de Resoluciones (SICOR)<br><br></strong>
              </div>
              <h4 class="tx-gray-800 tx-semibold mg-b-20">Procesando, espere un momento...</h4>
              <p class="mg-b-20 mg-x-20" id="mensaje_procesos">Se esta procesando su información, favor de esperar un momento...</p>
            </div><!-- modal-body -->
          </div><!-- modal-content -->
        </div><!-- modal-dialog -->
      </div><!-- modal -->
    @endif

    @if($request->session()->get('bandera_reseteo_pass')==0)
      <!-- MODAL RESET -->
      <div id="modal_reset" class="modal fade">
        <div class="modal-dialog modal-lg modal-dialog-vertical-center" role="document" style="width: 95%;">
          <div class="modal-content tx-size-sm">
            <div class="modal-header pd-x-20">
              <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Personaliza tu contraseña</h6>
            </div>
            <div class="modal-body pd-20">
              <h5 class=" lh-3 mg-b-20">Bienvenido, para continuar, es necesario que actualices tu contraseña.</h5>
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                      <label class="form-control-label">Nueva contraseña:</label>
                      <input class="form-control" id="reset_pass_1" name="reset_pass_1" type="password" name="involucrados_nombre" value="" placeholder="">
                  </div>
                </div><!-- col-4 -->
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="form-control-label">Repetir contraseña: </label>
                        <input class="form-control" id="reset_pass_2" name="reset_pass_2" type="password" name="involucrados_apellido_paterno" value="" placeholder="">
                    </div>
                </div><!-- col-4 -->

                <div class="col-lg-12">
                  <div id="message_reset">
                    <p class="tx-normal">La contraseña debe de tener las siguientes características:</p>
                    <p id="letter" class="invalid">Al menos una letra en <b>minúscula</b></p>
                    <p id="capital" class="invalid">Al menos una letra en <b>mayúscula</b></p>
                    <p id="number" class="invalid">Al menos un <b>número</b></p>
                    <p id="length" class="invalid">Mínimo <b>8 caracteres</b></p>
                  </div>
                </div>


              </div>
            </div><!-- modal-body -->
            <div class="modal-footer">
              <button type="button" class="btn btn-success" onclick="resetPass();" >Guardar</button>
            </div>
          </div>
        </div><!-- modal-dialog -->
      </div><!-- modal -->

      <style>

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

      </style>
      <script>
        var myInput = document.getElementById("reset_pass_1");
        var letter = document.getElementById("letter");
        var capital = document.getElementById("capital");
        var number = document.getElementById("number");
        var length = document.getElementById("length");

        // When the user clicks on the password field, show the message box
        myInput.onfocus = function() {
          //document.getElementById("message_reset").style.display = "block";
        }

        // When the user clicks outside of the password field, hide the message box
        myInput.onblur = function() {
          //document.getElementById("message_reset").style.display = "none";
        }

        // When the user starts to type something inside the password field
        var bandera_reset=0;
        myInput.onkeyup = function() {
          // Validate lowercase letters
          var lowerCaseLetters = /[a-z]/g;
          if(myInput.value.match(lowerCaseLetters)) {  
            letter.classList.remove("invalid");
            letter.classList.add("valid");
            bandera_reset=1;
          } else {
            letter.classList.remove("valid");
            letter.classList.add("invalid");
            bandera_reset=0;
          }
          
          // Validate capital letters
          var upperCaseLetters = /[A-Z]/g;
          if(myInput.value.match(upperCaseLetters)) {  
            capital.classList.remove("invalid");
            capital.classList.add("valid");
            bandera_reset=1;
          } else { 
            capital.classList.remove("valid");
            capital.classList.add("invalid");
            bandera_reset=0;
          }

          // Validate numbers
          var numbers = /[0-9]/g;
          if(myInput.value.match(numbers)) {  
            number.classList.remove("invalid");
            number.classList.add("valid");
            bandera_reset=1;
          } else {
            number.classList.remove("valid");
            number.classList.add("invalid");
            bandera_reset=0;
          }
          
          // Validate length
          if(myInput.value.length >= 8) {
            length.classList.remove("invalid");
            length.classList.add("valid");
            bandera_reset=1;
          } else {
            length.classList.remove("valid");
            length.classList.add("invalid");
            bandera_reset=0;
          }
        }
      </script>
    @endif


    <!-- MODAL AVISO PRIVACIDAD -->
    <div id="modal_aviso_privacidad" class="modal fade" style="">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content tx-size-sm">
          <div class="modal-body tx-center pd-y-20 pd-x-20">
            <h3 class="tx-gray-800 tx-semibold mg-b-20"><br>Aviso de Privacidad</h3>
            <div class="mg-b-20" >
              <strong class="tx-gray-800">Sistema Integral para la Consulta de Resoluciones (SICOR)<br><br>
                Los datos personales recabados serán protegidos, incorporados y tratados en el
                Sistema de Datos Personales “Sistema Integral para la Consulta de Resoluciones (SICOR)”</strong><br><br>
<ul style="text-align: justify; margin: 0px; padding:0px; margin-right:10px; margin-left:10px;" >
  <li type="circle">
    <strong>La Identificación del responsable y la ubicación de su domicilio</strong>
  </li>
El responsable del Sistema de datos personales es el Ing. Federico Vargas Ortíz, Director Ejecutivo de Gestión Tecnológica, Avenida Niños Héroes, Número 150, Piso 4, Colonia Doctores, Delegación Cuauhtémoc, C.P. 06720, Ciudad de México.
<br><br>
  <li type="circle">
<strong>Fundamento legal que faculta al responsable para llevar a cabo el tratamiento</strong>
  </li>
1. La Constitución Política de los Estados Unidos Mexicanos en sus artículos 6 párrafo segundo fracción II, 16
párrafo segundo y 108 párrafo primero.<br><br>
2. Artículo 7, inciso E), puntos 1, 2, 3 y 4 de la Constitución Política de la Ciudad de México.<br><br>
3. Artículo 1 de la Ley Orgánica del Tribunal Superior de Justicia del Distrito Federal ahora Ciudad de México.<br><br>
4. Los artículos 6, fracciones XII, XIII, XIV, XV, XVI, XVII, XXII, XLI y XLII y 186 de la Ley de Transparencia,
Acceso a la Información Pública y Rendición de Cuentas de la Ciudad de México.<br><br>
  </ul>

  <ul style="text-align: justify; margin: 0px; padding:0px; margin-right:10px; margin-left:10px;" >
			  
    5. Los artículos 1, 2, 3, fracciones I, II, IX, IX, XI, XXIX, 4, 6, 7, 8, 9, 10, 11, 12, 13, 14, 16, 17, 18, 19, 20, 21,
    22, 24, 25, 26, 37, 38 y 39 de la Ley de Protección de Datos Personales en Posesión de Sujetos Obligados de
    la Ciudad de México.<br><br>
    6. Los artículos 1, 3 fracción X, 30 fracciones VI y VII, 31, 32, 33, 34, 35 fracción VIII, 37, 38 y 40 de la Ley de
    Archivos del Distrito Federal ahora Ciudad de México.<br><br>
    7. Artículo 15 de los Lineamientos para la Organización y Conservación de Archivos.<br><br>
    8. Artículos 49, fracciones I y V, y 210 Ley de Responsabilidades Administrativas de la Ciudad de México.<br><br>
    9. Artículos 1, 4, 13, 15, 16, 17, 21, 24, 25, 27, 31 y 83 de la Ley Federal del Derecho de Autor.<br><br>
    10. Manual de Procedimientos de la Dirección Ejecutiva de Gestión Tecnológica, Capitulo IV puntos 110 y 111.<br><br>
    11. Acuerdo General 38-01/2018, emitido por el Pleno del Consejo de la Judicatura de la Ciudad de México,
    en enero de 2018. Se establecen las Normas Generales para el Uso, Aprovechamiento y Conservación de
    Bienes y Servicios Tecnológicos del Tribunal Superior de Justicia y del Consejo de la Judicatura, ambos de la
    Ciudad de México.<br><br>
    12. Acuerdo Plenario 57-26/2012 emitido por el pleno de la judicatura en marzo de 2012.<br><br>
    13. Acuerdo Plenario 28-35/2018 emitido por el pleno de la judicatura el 30 de agosto de 2018.<br><br>

		  <li type="circle">
    <strong>Los datos personales que serán sometidos al tratamiento, así como la
    existencia de un sistema de datos personales.</strong>
		  </li>
    a) Clave de elector (alfa-numérico anverso credencial IFE)<br>
    b) Clave del Registro Federal de Contribuyentes (RFC)<br>
		  c)	Clave Única de Registro de Población (CURP)<br>
d)	Domicilio<br>
e)	Firma<br>
f)	Nombre<br>
g)	Numero identificador (OCR) (reverso de la credencial IFE)<br>
h)	Contraseñas<br>
i)	Correo electrónico no oficial<br>
j)	Juicios en materia laboral, civil, penal, fiscal, administrativa o de cualquier otra rama del Derecho<br>
k)	Cédula profesional<br>
Inscritos en el SISTEMA INTEGRAL PARA LA CONSULTA DE RESOLUCIONES (SICOR)

		  <br><br>
		  <li type="circle">
		  <strong>Las finalidades del tratamiento para las cuales se recaban los datos personales, el ciclo de vida de los mismos, la revocación del consentimiento y los derechos del titular sobre estos.</strong>
			</li>
a).- Contar con un sistema automatizado de distribución y colocación de servicios por medios electrónicos, que simplifique y sistematice los procesos entre el solicitante del servicio, la entrega del mismo y la administración de los ingresos generados por esos conceptos. <br>
b).- La impresión, distribución y control del saldo de la Tarjeta de Prepago. <br>
c).- Ofrecer liquidez inmediata y reducción de costos de operación y administración de efectivo.<br>
d).- Interconexión con el módulo de fotocopiado para controlar la producción de fotocopiado mediante un sistema central de consumo y autorización de impresión, identificando de forma automática digital el tipo de fotocopia.<br>
e).- Concentrar todos los pagos de depósitos que recibe el Tribunal Superior de Justicia de la Ciudad de México y del Consejo de la Judicatura de la Ciudad de México, en una única plataforma de autoservicio que ofrezca diversos canales electrónicos y soporte todos los medios de pago. <br>
f).- Contar con un catálogo electrónico de servicios flexible que ofrezca la posibilidad de cobrar o recibir dinero de cualquier servicio del Tribunal Superior de Justicia de la Ciudad de México y del Consejo de la Judicatura de la Ciudad de México.<br>
g).- El manejo de los datos personales, en apego al cuadro de clasificación archivística que se muestra en la siguiente guía.<br>
<br><strong>Revocación del consentimiento:</strong> Procederá a partir de que el titular exprese de manera libre, voluntaria e inequívoca su solicitud para que cese el tratamiento de sus datos personales, el cual no tendrá efectos retroactivos.<br>
<br><strong>Derechos del titular:</strong> El titular que acredite su identidad o, en su caso, su representante que acredite identidad y personalidad, podrá ejercer los derechos de acceso, rectificación, cancelación y oposición (ARCO).<br><br>

		  
		  <img src="/images/tabla1.png" style="width: 99%;"><br><br>
		  
		  
<li type="circle"><strong>Los mecanismos, medios y procedimientos disponibles para ejercer los derechos de Acceso, Rectificación, Cancelación y Oposición:</strong></li>

El interesado podrá dirigirse al Instituto de Acceso a la Información Pública de la Ciudad de México, donde recibirá asesoría sobre los derechos que tutela la Ley de Protección de Datos Personales para la Ciudad de México, al teléfono: 5636-4636; correo electrónico: datos.personales@infodf.org.mx o www.infodf.org.mx”. Solicitar información a través del sistema de solicitudes de información (INFOMEX) http://infomexdf.org.mx/InfomexDF/default.aspx; de manera presencial en las oficinas de la Unidad de Transparencia del Tribunal Superior de Justicia de la Ciudad de México, o vía correo electrónico de la Unidad de transparencia: oip@tsjcdmx.gob.mx.<br><br>

<li type="circle"><strong>El domicilio de la Unidad de Transparencia:</strong></li>
Av. Niños Héroes #132, Planta Baja, Colonia Doctores, Delegación Cuauhtémoc, C.P. 06720, Ciudad de México, en días hábiles y en un horario de atención al público de 09:00 a 15:00 horas de lunes jueves y de 09:00 a 14:00 horas los viernes.
</ul>

            </div>
          </div><!-- modal-body -->
        </div><!-- modal-content -->
      </div><!-- modal-dialog -->
    </div><!-- modal -->

    @yield('seccion-modales')
@endsection

@section('estilos')
<link href="/box/css/styles.addon.css" rel="stylesheet">
<link href="{{ $entorno["version_pages"]["version"] }}/lib/SpinKit/css/spinkit.css" rel="stylesheet">
<link href="/box/air-datepicker-master/dist/css/datepicker.css" rel="stylesheet" type="text/css">
@yield('seccion-estilos')
@endsection

@section('scripts-libs')
  @yield('seccion-scripts-libs')
  <script src="/box/air-datepicker-master/dist/js/datepicker.min.js"></script>
  <script src="/box/air-datepicker-master/dist/js/i18n/datepicker.es.js"></script>
  <script src="/box/js/time-ago-in-words.js"></script>
  <script src="/box/js/function.addon.js?id=7"></script>
  <script src="/box/js/channel.addon.js"></script>
  @if ($request->session()->has('cadena-sesion'))
    <script src="//code.tidio.co/ysa0ohvalsmertli1ijepatymfx6thch.js"></script>
  @endif
  
@endsection


@section('scripts-functions')

<script>
  reloj_cierre(@php  $today = getdate(); echo $today['year'].",".$today['mon'].",".$today['mday'].",".$today['hours'].",".$today['minutes'].",".$today['seconds'];  @endphp, '{{ $sesion['horario_cierre'] }}');
  diasAsueto('dp', [@php for($i=0; $i<count($request->dias_inhabiles["response"]); $i++){ print("'".$request->dias_inhabiles["response"][$i]["dia_no_laboral_fecha"]."', ");   } @endphp]);
  ws_push_eventos("{{ $sesion['usuario_id'] }}");

  @if ($request->session()->has('cadena-sesion'))
    document.tidioIdentify = {
      distinct_id: '{{$request->session()->get("usuario-id")}}',
      name: '{{$request->session()->get("usuario_nombre_completo")}}',
      email: '{{$request->session()->get("usuario_nombre")}}'
    };
  @endif
 
  @if($request->session()->get('bandera_reseteo_pass')==0)
    $('#modal_reset').modal({backdrop: 'static', keyboard: false});
  @endif

</script>

  @yield('seccion-scripts-functions')
@endsection