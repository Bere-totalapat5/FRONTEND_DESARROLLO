@php
use App\Http\Controllers\clases\utilidades;
// use Illuminate\Support\Facades\Session;
@endphp

@extends('layouts.master')

@section('head-title')
  Sistema Integral de Gestion Judicial  
@endsection

@section('cuerpo')

  @php
    $rand = rand(2,9);
  @endphp
  
  <div id="page">
    <div id="menu_movil" class="" >
      <ul class="" role="tablist">
        <li class="" style=""><a class="" data-toggle="tab" href="#" role="tab">&nbsp;</a></li>
          @if(utilidades::buscarPermisoMenu($request->menu_general['response'], 28, 0))
            <li class="" style="max-width: 200px;">
              <a class="" href="/notificaciones">
                <i class="fa fa-bell-o" aria-hidden="true"></i> <span class="">Notificaciones &nbsp; </span>
                  <span class="countNotificaciones tx-danger"></span>
              </a>
            </li>
            <hr>
          @endif
          @if(utilidades::buscarPermisoMenu($request->menu_general['response'], 29, 0))
            <li class="" style="max-width: 200px">
              <a class="" href="/tareas">
                <i class="fa fa-bell-o" aria-hidden="true"></i> <span class="">Tareas &nbsp; </span>
                  <span class="countTareas tx-danger"></span>
              </a>
            </li>
            <hr>
          @endif
          @if(utilidades::buscarPermisoMenu($request->menu_general['response'], 30, 0))
            <li class="" style="max-width: 200px">
              <a class="" href="/documentos">
                <i class="fa fa-bell-o" aria-hidden="true"></i> <span class="">Documentos &nbsp; </span>
                  <span class="countFirmas tx-danger"></span>
              </a>
            </li>
            <hr>
          @endif
        
        @foreach ($request->menu_general['response'] as $key_menu => $menu)

          @if ($menu['menu_id'] != 27)
            <div class="dropdown show">
              <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink{{$key_menu}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-ellipsis-h" aria-hidden="true"></i> {{$menu['descripcion']}}
              </a>
            
              <div class="dropdown-menu" aria-labelledby="dropdownMenuLink{{$key_menu}}">
                @foreach ($menu['submenus'] as $key_submenu=> $submenu )        
                <a class="dropdown-item" href="{{$submenu['vista']}}" ><i class="fa fa-link" aria-hidden="true"></i> {{$submenu['descripcion']}}</a>
              @endforeach
                {{-- <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <a class="dropdown-item" href="#">Something else here</a> --}}
              </div>
            </div>
            <hr>
          @endif    


          {{-- <li class="menu" id="menu{{$key_menu}}" data-menu="div{{$key_menu}}"><a class="" data-toggle="tab" href="#" role="tab">{{ $menu["descripcion"] }}</a></li> --}}
          {{-- <div class="submenu" id="div{{$key_menu}}">
            @foreach ($menu['submenus'] as $key_submenu=> $submenu )        
              <li><a href="{{$submenu['vista']}}" >{{$submenu['descripcion']}}</a></li>          
            @endforeach
          </div> --}}
        @endforeach
        <li class=""><a href="" class="" data-toggle="modal" data-target="#modal_aviso_privacidad"><i class="icon ion-ios-gear"></i> Aviso de privacidad</a></li>
        <hr>
        <li class=""><a href="" class="" data-toggle="modal" data-target="#modal_avisos"><i class="icon ion-ios-paper"></i> Avisos</a></li>
        <hr>
        <li class=""><a href="javascript:void(0)" onclick="logout()" class=""><i class="icon ion-forward"></i> Salir</a></li>
        <hr>
      </ul>
    </div>
    <div id="contenido">
      <div style="background-color:#FFFFFF; width:100%;">
        @if ($request->session()->get("sesion_tipo")=="soporte")
          <div class="alert alert-warning" role="alert">
            <strong>Sesion de soporte</strong> Usted acaba de iniciar la sesión en modo soporte.
          </div><!-- alert -->
        @endif
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
      <div id="header">
        <div class="slim-header" style="height: 60px">
          <div class="container">
            <div class="alertas" onclick="ver_menu_notificacion(this)" data-click="1">
              <span class="cant" id="cant">0</span>
              <i class="fa fa-bell" aria-hidden="true"></i>
            </div>
            <div class="slim-header-left" style="width: 100%;">
              <a href="javascript:void(0)" id="btn-menuMovil" onclick="menu_movil()">
                <i class="fa fa-bars" aria-hidden="true"></i>
              </a>
              <div class="col-6 col-sm-6 col-sm-6 col-md-4">
                <div class="dropdown dropdown-demo" >
                  <a href="#" class="dd-link" data-toggle="dropdown" >
                    <div style="border: none; padding:0px;">
                      @if(isset($sesion['ministerio_ley_status']) and $sesion['ministerio_ley_status']=='si')
                        <i class="fa fa-exclamation-triangle" style="font-size: 20px; padding-right:5px; color:red;"></i>
                      @endif
                      <span>
                        <div class="organo_desktop">
                          @yield('contenido-pageheader-organo')
                        </div>
                        <div class="organo_movil" style="display: none;">
                          <small>{{$sesion['nombre_unidad']}}</small>
                        </div>
                        <h4 style="margin-bottom:0px;" class="tx-bold tx-inverse titulo-primario d-none d-md-block">{{strtoupper($sesion['usuario_nombre'])}}</h4>
                        @if( Session::get('sustituido_por_id_usuario') != '' || Session::get('sustituyendo_a_id_usuario') != '' )
                          <small class="tx-danger">Sustitución aplicada</small>
                        @endif
                        <h6 style="margin-bottom:0px;" class="tx-bold tx-inverse titulo-primario d-md-none">{{strtoupper($sesion['usuario_nombre'])}}</h6>
                      </span>
                      <i class="fa fa-angle-down mg-l-5"></i>
                    </div>
                  </a>
                  <div class="dropdown-menu pd-0 wd-sm-350">
                    <div style="padding: 10px;">
                      <div class="" >
                        {{-- {{$request->lang['Sala']}} --}}
                      </div>
                      <h6 style="margin-bottom:0px;" class="tx-bold tx-inverse titulo-primario">{{strtoupper($sesion['nombre_unidad'])}}</h6>
                      <div class="" style="padding-top: 5px;">Usuario</div>
                      <h6 style="margin-bottom:0px;" class="tx-bold tx-inverse titulo-primario">{{strtoupper($sesion['usuario_nombre'])}}</h6>
        
                      <div class="" style="padding-top: 5px;">Nombre</div>
                      <h6 style="margin-bottom:0px;" class="tx-bold tx-inverse titulo-primario">{{strtoupper($sesion['usuario_nombre_completo'])}}</h6>
        
                      <div class="" style="padding-top: 5px;">Puesto</div>
                      @if(strtoupper($sesion['tipo_usuario_descripcion'])=="JUEZ MAGISTRADO")
                        <h6 style="margin-bottom:0px;" class="tx-bold tx-inverse titulo-primario">
                          {{-- {{$request->lang['MAGISTRADO']}} --}}
                        </h6>
                      @else
                        <h6 style="margin-bottom:0px;" class="tx-bold tx-inverse titulo-primario">{{strtoupper($sesion['tipo_usuario_descripcion'])}}</h6>
                      @endif
                       
                      @if( Session::get('sustituido_por_id_usuario') != '' ) 
                        <div class="tx-danger" style="padding-top: 5px;">Sustituido por:</div>
                        <h6 style="margin-bottom:0px;" class="tx-bold tx-inverse titulo-primario tx-uppercase">{{Session::get('sustituido_por_usuario')}}</h6>  
                      @endif

                      @if( Session::get('sustituyendo_a_id_usuario') != '') 
                        <div class="tx-danger" style="padding-top: 5px;">Sustituyendo a:</div>
                        <h6 style="margin-bottom:0px;" class="tx-bold tx-inverse titulo-primario tx-uppercase">{{Session::get('sustituyendo_a_usuario')}}</h6>  
                      @endif


                      {{-- <div class="" style="padding-top: 5px;">Area de trabajo</div>
                      <h6 style="margin-bottom:0px;" class="tx-bold tx-inverse titulo-primario">{{strtoupper($sesion['grupo_trabajo_tipo_area'])}}</h6> --}}
                    </div>
                  </div><!-- dropdown-menu -->
                </div>
              </div>
              <div class="col-md-3 col-sm-4">
                <div class="dash-content" style="text-align:center;;">
                  <div class="titulo_secundario_horario_min d-none"><small>@if(in_array(date('Y-m-d'), $request->dias_festivos_arr)) día inhábil @else {{$request->fecha_movil}} @endif</small></div>
                  <div class="titulo_secundario d-none">@if(in_array(date('Y-m-d'), $request->dias_festivos_arr)) día inhábil @else <span class="d-none d-md-inline-block">cierre</span> {{ $sesion['horario_cierre'] }} hrs @endif</div>
                  <h4 style="margin-bottom:0px; display:none;" class="d-none tx-bold tx-inverse titulo-primario-reloj @if(in_array(date('Y-m-d'), $request->dias_festivos_arr)) reloj_vencido @endif" id="clock_index"></h4>
                </div>
              </div> 
              <div class="col-md-5 col-sm-0 stage_fecha  d-none d-md-block">
                <div class="dash-content">
                  <h4 style="margin-bottom:0px;" class="tx-bold tx-inverse titulo_secundario custom-cells">
                    {{$request->fecha_desktop}}
                    <input type="text" id="dp" style="visibility: hidden; width:0px;" class="">
                    <i class="fa fa-calendar custom-cells" id="custom-cells" style=""></i>
                  </h4>
                </div>
              </div>
            </div><!-- slim-header-left -->
            <div class="slim-header-right" id="btn-menuD">
              <div class="dropdown dropdown-c">
                <a href="#" class="logged-user" data-toggle="dropdown" onclick="menu_movil()">
                  <img src="/images/logo_penal.png" alt="">
                  <span>@yield('contenido-pageheader-usuario')</span>
                  <i class="fa fa-angle-down"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right" id="menu_user" style="border-top: 1px solid rgba(0, 0, 0, 0.15)">
                  <nav class="nav">
                    {{-- <a href="" class="nav-link" data-toggle="modal" data-target="#modal_aviso_privacidad"><i class="icon ion-ios-gear"></i> Aviso de privacidad</a>
                    <a href="" class="nav-link" data-toggle="modal" data-target="#modal_avisos"><i class="icon ion-ios-paper"></i> Avisos</a> --}}
                    {{-- <a href="" class="nav-link" data-toggle="modal" data-target="#modalTelegram"><i class="fa fa-paper-plane" style="font-size: 1em; color: #848F33; margin-right: 7px;"></i> Telegram</a> --}}
                    <a href="javascript:void(0)" onclick="logout()" class="nav-link"><i class="icon ion-forward"></i> Salir</a>
                  </nav>
                </div><!-- dropdown-menu -->
              </div><!-- dropdown -->
            </div><!-- header-right -->
          </div><!-- container -->
        </div><!-- slim-header -->
      </div>
      
      {{-- Bandejas --}}
      @if(utilidades::buscarPermisoMenu($request->menu_general['response'], 27, 0))
        <div class="slim-navbar" id="divBandejas" style="position: initial; background-color:#FFF !important; padding:10px; border-top:0">
          <div class="container">
            <ul class="nav bandejas" id="ulBandejas">
              @if(utilidades::buscarPermisoMenu($request->menu_general['response'], 28, 0))
                <li class="nav-item" style="max-width: 200px;">
                  <a class="nav-link2 {{ $request->path()=='notificaciones' ? 'activo' : '' }}" href="/notificaciones">
                    <span class="d-inlineblock">Notificaciones &nbsp; </span>
                      <span class="countNotificaciones tx-danger d-inlineblock"></span>
                  </a>
                </li>
              @endif
              @if(utilidades::buscarPermisoMenu($request->menu_general['response'], 29, 0))
                <li class="nav-item" style="max-width: 200px">
                  <a class="nav-link2 {{ $request->path()=='tareas' ? 'activo' : '' }}" href="/tareas">
                    <span class="d-inlineblock">Tareas &nbsp; </span>
                      <span class="countTareas tx-danger d-inlineblock"></span>
                  </a>
                </li>
              @endif
              @if(utilidades::buscarPermisoMenu($request->menu_general['response'], 30, 0))
                <li class="nav-item" style="max-width: 200px">
                  <a class="nav-link2 {{ $request->path()=='documentos' ? 'activo' : '' }}" href="/documentos">
                    <span class="d-inlineblock">Documentos &nbsp; </span>
                      <span class="countFirmas tx-danger d-inlineblock"></span>
                  </a>
                </li>
              @endif
            </ul>
          </div><!-- container -->
        </div>
      @endif
      
      <!-- MENU DE ABAJO  -->
      <!-- <li class="nav-item with-sub active">  -->
      @isset($request->menu_general['response'])
        <div class="slim-navbar" style="z-index: 100" id="menu_escritorio">
          <div class="container"> 
            <ul class="nav">
              {{$descripcion=""}}
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
      
      <div class="slim-mainpanel" style="max-width: 1650px; margin-left: auto;margin-right: auto;" id="contenidoS">
        <div class="pd-l-5 pd-r-5 pd-md-l-30 pd-md-r-30">
          <div class="slim-pageheader">
            @yield('contenido-pageheader')
          </div><!-- slim-pageheader -->
          <div class="manager-wrapper">
            <div class="manager-right" style=""> 
              @yield('contenido-principal')
            </div>
                
            {{-- <div class="manager-left">
              @isset($request->menu_general['response'])
              
                @if(utilidades::buscarPermisoMenu($request->menu_general['response'], 4, 0))
                  <a href="/solicitud_audiencia_inicial" class="btn btn-contact-new" style="margin: 0px; margin-bottom:5px;">Solicitud Inicial</a>
                @endif
                @if(utilidades::buscarPermisoMenu($request->menu_general['response'], 6, 0))
                  <a href="/consulta_solicitudes" class="btn btn-contact-new" style="margin: 0px; margin-bottom:5px;">Consultar Solicitudes</a>
                @endif
                @if(utilidades::buscarPermisoMenu($request->menu_general['response'], 13, 0))
                  <a href="/carpetas_judiciales" class="btn btn-contact-new" style="margin: 0px; margin-bottom:5px;">Consultar Carpetas Judiciales</a>
                @endif
      
        
                @if(utilidades::buscarPermisoMenu($request->menu_general['response'], 20, 0))
                  <a href="/consulta_promujer" class="btn btn-contact-new" style="margin: 0px; margin-bottom:5px;">Consultar Solicitudes Promujer</a>
                @endif
              @endisset  
            </div><!-- manager-left --> --}}
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
    </div>
    <div class="menu_notificacion">
      <div class="title_not">
        Alertas
      </div>
      <div class="body_notificacion" id="body_notificacion">

      </div>
    </div>
    <div id="notificacion_flotante">
    </div> 
  </div>
@endsection

@section('estilos')
  @yield('seccion-estilos')
@endsection

@section('scripts-libs') 
  @yield('seccion-scripts-libs')
    {{-- <script src="/box/air-datepicker-master/dist/js/datepicker.min.js"></script>
    <script src="/box/air-datepicker-master/dist/js/i18n/datepicker.es.js"></script> --}}
    <script src="/box/js/time-ago-in-words.js"></script>
    <script src="/box/js/function.addon.js?id=1"></script>
    <script src="/box/js/channel.addon.js"></script>
    <script src="../lib/jquery-ui/js/jquery-ui.js"></script>
    <script src="/js/countBandejas.js"></script>
    <script src="/js/picker.js"></script>
@endsection

@section('scripts-functions')
  
  <script>
    //Pusher API KEYS
    
    var PUSHER_APP_KEY = "8051d2629c23ceb5a0fc";
    var pusher = new Pusher(PUSHER_APP_KEY, {
      cluster: 'us2',
      forceTLS: false,
      wsHost: window.location.hostname,
      wsPort:6001,
      disableStats:true,
    });
    

    reloj_cierre(@php  $today = getdate(); echo $today['year'].",".$today['mon'].",".$today['mday'].",".$today['hours'].",".$today['minutes'].",".$today['seconds'];  @endphp, '{{ $sesion['horario_cierre'] }}');
    diasAsueto('dp', [@php if(isset($request->dias_inhabiles["response"])){for($i=0; $i<count($request->dias_inhabiles["response"]); $i++){ print("'".$request->dias_inhabiles["response"][$i]["fecha"]."', ");   }} @endphp]);
    ws_push_eventos("{{ $sesion['usuario_id'] }}");
    obtener_notificaciones_alertas("{{ $sesion['usuario_id'] }}");
    
    @if($request->session()->get('estatus_reseteo_pass') == 0) //status_reseteo_pass
      modal_reset_password();
    @endif
    
    $('#modal_avisos').on('hide.bs.modal', function () {
      // do something... 
      $.ajax({
          type:'POST',
          url: "{{ route('home.aviso_sesion') }}",
          data:{  },
          success:function(data){
              console.log(data);
          }
      });

    });

    $(document).ready(function(){
      setTimeout(function(){
        $('#modal_loading').modal('hide')
      },300);
    });

    // menu movil
    function menu_movil(){
      const y =window.scrollY;
      
      $('body').addClass('modal-open');
      $('#menu_movil').css({'left':'0','transition': '0.7s'});
      $('#menu_movil ul').css({'font-size':'1rem','transition': '0.2s'});
    }

    function oculta_mm(){
      
      $('#menu_movil ul').css({'font-size':'0','transition': '250ms'});
      $('#menu_movil').css({'left':'-1000px','transition': '700ms'});
      $('.dropdown-menu').removeClass('show');
      $('body').removeClass('modal-open');
    }

    document.addEventListener('swiped-left', function(e) {
      oculta_mm()
    });

    window.onscroll = function() {
      const y =window.scrollY;
      $('#menu_movil').css({'margin-top':`${y}px`});
      const t=85-y;
      $('#header').css({'top':`${85-y}px`});
      if(t <= 0){
        $('#header').css({'top':'0px'});
      }
      
    };

    $('.menu').click(function(){});

    console.log('canal {{$request->session()->get('usuario_id')}}')
    //Pusher.logToConsole = true;
    var canal_name = 'user_{{$request->session()->get('usuario_id')}}';
    var channel = null;
    
    channel = pusher.subscribe(canal_name);

    //console.log('canal', channel);

    channel.bind('user-event',function( data ){
    
      console.log( 'datas Socket', JSON.stringify(data))

      obtener_notificaciones_alertas("{{$sesion['usuario_id']}}");

      
      $('#notificacion_flotante').show("slide", { direction: "left" });
      
      $('#notificacion_flotante').append(`
              <div class="header_not">
                <div class="image">
                  <img src="/images/logo_penal.png" alt=""> SIGJ PENAL
                </div>
                <div class="buttons closes" onclick="cerraNot()">
                  x
                </div>
              </div>
              <div class="body_not" style="margin-bottom:1%;">
                <ul>
                  <li onclick="ver_accion('${data.clave}', ${data.id},0,'${data.identificador}')" style="cursor:pointer;">${data.mensaje}</li>
                </ul>
              </div>
      `);

      let comentarios  = $('#notificacion_flotante .header_not').length;

      if(comentarios > 4){
          $('#notificacion_flotante').html('');
    
          $('#notificacion_flotante').show("slide", { direction: "left" });

          $('#notificacion_flotante').append(`
              <div class="header_not">
                <div class="image">
                  <img src="/images/logo_penal.png" alt=""> SIGJ PENAL
                </div>
                <div class="buttons closes" onclick="cerraNot()">
                  x
                </div>
              </div>
              <div class="body_not" style="margin-bottom:1%;">
                <ul>
                  <li onclick="ver_accion('${data.clave}', ${data.id},0,'${data.identificador}')" style="cursor:pointer;">${data.mensaje}</li>
                </ul>
              </div>
          `);

          setTimeout(function(){
            cerraNot();
          },5000)

      }else{
          setTimeout(function(){
            cerraNot();
          },5000)
      }
      
      countBandejas();
    });

    
    function cerraNot(){
      $('#notificacion_flotante').hide("slide",{direction:"right"});
    }

    function ver_accion(clave, id, id_notificacion = 0, identificador){
      if(clave == 'tarea'){ // si es una tarea
        var URLactual = window.location.pathname;
        console.log(URLactual);

        //visto
        actualizar_leido(id_notificacion);
        ocultar_menu_notificacion();

        if(URLactual == '/tareas'){
          console.log(id);
          $('#folio').val(id);
          $('#searchFolioB').trigger('click');

          setTimeout(function(){
            $('#tarea_'+id).trigger('click');
          }, 500);
          
        }else{
          var domain = window.location.origin;
          console.log(domain);
          iden = btoa(id);
          console.log(iden)
          window.location.href = domain+'/tareas/'+ iden;
        }

      }else if(clave == 'carpeta'){// si es una carpeta
        
        var URLactual = window.location.pathname;

        //visto
        actualizar_leido(id_notificacion);
        ocultar_menu_notificacion();

        // condicion 
        if(URLactual == '/carpetas_judiciales'){ //si nos encontramos en la vista de carpetas 
          console.log(identificador);
          $("#unidad option:first").prop('selected',true).trigger( "change" );
          $("#tipoCarpeta option:first").prop('selected',true).trigger( "change" );

          $('#folioCarpeta').val(identificador);
          $('#buzz').trigger('click');

          setTimeout(function(){
            abrirModalAdministracion(id);
            $('#folioCarpeta').val('');
            $('#buzz').trigger('click');
          }, 800);
            
        }else{ // si nos encontramos en otra vista 
          var domain = window.location.origin;
          console.log(domain);
          iden = btoa(id+'_'+identificador);
          console.log(iden)
          window.location.href = domain+'/carpetas_judiciales/'+ iden;
        }

      }
    }

    function ver_menu_notificacion(obj){
      var toggle = $(obj).attr('data-click');
      if(toggle == 1){
        $('.menu_notificacion').removeClass('close_menu_n');
        $('.alertas').removeClass('alertas_close');
        $('.menu_notificacion').addClass('open_menu_n');
        $('.alertas').addClass('alertas_s');
        obtener_notificaciones_alertas("{{ $sesion['usuario_id'] }}");
        $(obj).attr('data-click', 0);
      }else if(toggle == 0){
        $('.menu_notificacion').addClass('close_menu_n');
        $('.alertas').addClass('alertas_close');
        $('.menu_notificacion').removeClass('open_menu_n');
        $('.alertas').removeClass('alertas_s');
        $(obj).attr('data-click', 1);
      }
    }

    function ocultar_menu_notificacion(){
      $('.menu_notificacion').addClass('close_menu_n');
      $('.alertas').addClass('alertas_close');
      $('.menu_notificacion').removeClass('open_menu_n');
      $('.alertas').removeClass('alertas_s');
      $('.alertas').attr('data-click', 1);
    }

    function obtener_notificaciones_alertas(id){
      console.log(id);
      $.ajax({
        type:'POST',
        url:'/public/obtener_alertas',
        data:{
            id_usuario: id
        },
        success:function(response) {
          console.log(response);
          var datos = response.response;
          var cant = response.cantidad;
          var alertas = '';
          
          if(cant > 0){
            for(i=0; i<datos.length; i++){

              tiempo = formato_horas_notificacion(datos[i].fecha_creacion); 

              alertas += `<div class="alertas_n">
                            <div class="notificacion_header">
                              <div style="display:flex;justify-content: space-around; align-items: center;">
                                <div class="image_n">
                                  <img src="/images/logo_penal.png" alt="">
                                </div>
                              </div>
                              <div style="width:155px; display:flex;justify-content: space-around; align-items: center;">
                                <i class="fas fa-circle" style="font-size: 0.4em; margin-right:1%;"></i>
                                Tribunal Superior de Justicia
                                <i class="fas fa-circle" style="font-size: 0.4em; margin-left:1%;"></i>
                              </div>
                              <div style="font-size: 0.84em;">
                                ${tiempo}
                              </div>
                              <div style="display: flex;justify-content: center;align-items: center;width: 22px;">
                                <i class="fas fa-chevron-down" abierto="0" onclick="mostrarMensaje(this,${datos[i].id_alerta})"></i>
                              </div>  
                            </div>
                            <div class="notificacion_body" onclick="ver_accion('${datos[i].clave}',${datos[i].id},${datos[i].id_alerta}, '${datos[i].identificador}')">
                              <div class="mass ocultarTexto" id="mass_${datos[i].id_alerta}">
                                ${datos[i].mensaje}
                              </div>
                            </div>
                            <div class="notificacion_footer">
                              <a href="#" onclick="actualizar_leido(${datos[i].id_alerta})">Marcar como leído</a>
                            </div>
                          </div>`;
            }
          }else{
            alertas = `<div class="empty_notification"><i class="fa fa-bell" aria-hidden="true"></i>Bandeja de Alertas Vacia</div>`;
          }

          $('#body_notificacion').html(alertas);

          if(cant > 10){
            $('#cant').html('10+');
          }else{
            $('#cant').html(cant);
          }
        }
      });
      
    }

    function mostrarMensaje(obj, id_alerta){
      var abierto = $(obj).attr('abierto');
      if(abierto == 0){
        $(obj).removeClass('fa-chevron-down');
        $(obj).addClass('fa-chevron-up');
        $('#mass_'+id_alerta).removeClass('ocultarTexto');
        $('#mass_'+id_alerta).addClass('mostrarTexto');
        $(obj).attr('abierto', 1);
      }else{
        $(obj).addClass('fa-chevron-down');
        $(obj).removeClass('fa-chevron-up');
        $('#mass_'+id_alerta).addClass('ocultarTexto');
        $('#mass_'+id_alerta).removeClass('mostrarTexto');
        $(obj).attr('abierto', 0);
      }
    }

    function formato_horas_notificacion(fecha){
      var startTime = new Date(fecha); 
      var endTime = new Date();
      var difference = endTime.getTime() - startTime.getTime();
      
      var resultInHours = Math.round(difference / 3600000);
      var resultInMinutes = Math.round(difference / 60000);
      var contdias = Math.round(difference/(1000*60*60*24));

      console.log(resultInMinutes);

      var respuesta = '';

      if(resultInMinutes < 0){
        respuesta = 'Hace unos segundos';

        return respuesta;
      }if(resultInMinutes >= 0 && resultInMinutes < 59 ){
        respuesta = 'Hace '+resultInMinutes+' Min';

        return respuesta;
      }else if(resultInHours > 0 && resultInHours < 24 && resultInMinutes > 59){
        respuesta = 'Hace '+resultInHours+' Hrs';

        return respuesta;
      }else if(resultInHours > 23 && contdias > 0){
        respuesta = 'Hace '+contdias+' Dias';

        return respuesta;
      }
    }

    function actualizar_leido(id){
      if(id != 0){
        $.ajax({
          type:'POST',
          url:'/public/actualizar_visto',
          data:{
              id_notificacion: id
          },
          success:function(response) {
            console.log(response);
            if(response.response){
              obtener_notificaciones_alertas("{{ $sesion['usuario_id'] }}");
            }
          }
        });
      }
    }

    function modal_reset_password(){
      $('#modal_reset').modal('show');
    }

    function modal_error(mensaje,modalAnterior=null){
      $('#messageError').html(`${mensaje}`);
      $('#btnCerrarError').attr('data-modal',modalAnterior!=null?modalAnterior:'');
      if( modalAnterior!=null ) $('#'+modalAnterior).modal('hide');
      $('#modalError').modal('show');
    }


    function resetPass(){
      var pass1 = $('#reset_pass_1').val();
      var pass2 = $('#reset_pass_2').val();

      if(pass1.length > 0 && pass2.length > 0){
        if(pass1 != pass2){
          $('#difference').fadeIn('slow');
          setTimeout(function(){
            $('#difference').fadeOut('slow');
          },2000);
        }else{
          //se cambia la pass
          console.log('se cambia las pass');
          $.ajax({
            method: 'POST',
            async: false,
            url: '/public/cambiar_reseteo',
            //  async: false,
            data: {
                pws: pass1,
                modo:"c_validacion"
            },
            success: function(response) {
              if(response.status == 100){
                statuspws();
                $('#modal_reset').modal('hide');
                $('#successMessage').html('EXITO - actualización de password satisfactoria');
                $('#modalSuccess').modal('show');
              }else{
                modal_error(response.message,'modal_reset');
              } 
            }
          });
        }
      }else{
        $('#empty_field').fadeIn('slow');
        setTimeout(function(){
          $('#empty_field').fadeOut('slow');
        },2000);
      }
    }

    function statuspws(){
      $.ajax({
        method: 'POST',
        async: false,
        url:'/public/statuspws',
        data:{
          status: 1
        },
        success: function(reponse){
        }
      });
    }

    function mostrarPassword(obj, self){
      var cambio = document.getElementById(obj);
      if(cambio.type == "password"){
        cambio.type = "text";
        $('#'+self).removeClass('fa fa-eye-slash').addClass('fa fa-eye');
      }else{
        cambio.type = "password";
        $('#'+self).removeClass('fa fa-eye').addClass('fa fa-eye-slash');
      }
    } 


  </script>

  <script>
    const session_ = @php echo json_encode($sesion); @endphp;
    
    historyRecorder();

    function historyRecorder(){
    
      // --- Deteccion de la session 
      const sessioData = getSessionData();
      if(!localStorage.history){
        localStorage.history = JSON.stringify({session:sessioData, modules:[]});
      }

      setRecorderMove();

    }

    function getSessionData(){
      const dataMobile = getSistemaOperativo();
      var ip = '';

      $.ajax({
        type:'GET',
        async:false,
        url:'/public/obtener_ip',
        data:{},
        success:function(response) {
          if(response.status == 100){
            ip = response.IP;
          }
        }
      });

      var sessioData = {
        fecha_session: fecha_actual_(),
        hora_session: hora_actual_(),
        id_usuario: parseInt('{{$request->session()->get('usuario_id')}}'),
        usuario: '{{$request->session()->get('usuario_nombre')}}',
        tipo_usuario: '{{$request->session()->get('usuario_tipo')}}',
        id_tipo_usuario: parseInt('{{$request->session()->get('id_tipo_usuario')}}'),
        grupo_trabajo: parseInt('{{$request->session()->get('usuario_grupo_trabajo')}}'),
        id_unidad: parseInt('{{$request->session()->get('id_unidad_gestion')}}'),
        id_inmueble: parseInt('{{$request->session()->get('id_inmueble')}}'),
        nombre_completo: '{{$request->session()->get('usuario_nombre_completo')}}',
        tipo_session: '{{$request->session()->get('sesion_tipo')}}',
        cadena_session: '{{$request->session()->get('cadena-sesion')}}',
        dispositivo: {
          tipo: dataMobile.tipo,
          OS: dataMobile.OS,
          navegador: dataMobile.navegador,
          ip: ip
        },
      }
      return sessioData;
    }

    function getSistemaOperativo() {

      var userAgent = navigator.userAgent || navigator.vendor || window.opera;
      
      //---- deteccion celulares o tabletas
      if (/windows phone/i.test(userAgent)) {
          return {tipo:"Telefono",navegador:"" ,OS: "Windows Phone"}
      }
    
      if (/android/i.test(userAgent)) {
        return {tipo:"Telefono",navegador:"Desconocido", OS: "Android"}
      }
    
      if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream) {
        if(/iPad/.test(userAgent)){
          return {tipo:"Tableta iPad",navegador:"Desconocido", OS: "iOS"}
        }else if(/iPhone/.test(userAgent)){
          return {tipo:"Telefono iPhone",navegador:"Desconocido", OS: "iOS"}
        }else if(/iPod/.test(userAgent)){
          return {tipo:"iPod",navegador:"Desconocido", OS: "iOS"}
        }
      }

      //----- deteccion pc
      if (/Windows/i.test(userAgent)) {
        if(/Firefox/i.test(userAgent)) return {tipo:"PC" , OS: "Windows", navegador: "Firefox " } 
        if(/Chrome/i.test(userAgent)) return {tipo:"PC" , OS: "Windows", navegador: "Chrome" }
        if(/Edge/i.test(userAgent)) return {tipo:"PC" , OS: "Windows", navegador: "Edge " } 
        if(/Opera/i.test(userAgent)) return {tipo:"PC" , OS: "Windows", navegador: "Opera " } 
      }
      
      return {tipo:"Desconocido",navegador:"Desconocido", OS: "Desconocido"}
    }

    function setRecorderMove(){
      //----- Inspector de Vistas -----
      var URLactual = window.location.pathname;
      var URLcompleta = window.location.href;
      
      const module = {
        modulo: URLactual,
        fecha: fecha_actual_(),
        hora: hora_actual_(),
        url_completa: URLcompleta,
        accion:"Entrada al modulo "+URLactual
      }

      history_ = JSON.parse(localStorage.history);
      history_.modules.push(module);
      localStorage.history = JSON.stringify(history_);

      setMoveIntoView();
    }

    function setMoveIntoView(){
      history_ = JSON.parse(localStorage.history);
      modulos = history_.modules.length;

      for(i = modulos; i > modulos; i--){
        console.log(modulos[i]);
      }
      
    }

    //-------  Funciones Herramienta --------
    function fecha_actual_(){
      var f = new Date();
      var dia = f.getDate() < 10 ? '0'+f.getDate() : f.getDate();
      var mes = (f.getMonth() + 1) < 10 ? '0'+(f.getMonth() + 1) : (f.getMonth() + 1);

      var fecha = dia+'/'+mes+'/'+f.getFullYear();

      return fecha;
    }
    
    function hora_actual_(){
      var f = new Date();
      var hora = f.getHours();
      var minutos = f.getMinutes();
      var segundos = f.getSeconds();

      var hora_ = hora+':'+minutos+':'+segundos;

      return hora_;
    }

    function logout(){
      localStorage.clear()
      setTimeout(function(){
        location.href='/logout';
      },800)
    }

  </script>

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

  @yield('seccion-scripts-functions')
@endsection

@section('modales')
    <!-- MODAL ALERT MESSAGE -->
    <div id="modal_loading1" class="modal fade" data-backdrop="static" data-keyboard="false" >
      <div class="modal-dialog" role="document" style="width: 100%;height: 30%; max-width: 300px;">
        <div class="modal-content tx-size-sm" id="modal_content-loading" style="height:0">
          <div class="modal-body" style="margin-left: 20%;">
            {{-- <div class="sk-chasing-dots tx-success" style="width: 100px; height: 100px;">
              <div class="sk-child sk-dot1 bg-gray-500"></div>
              <div class="sk-child sk-dot2 bg-gray-500"></div>
            </div> --}}
            <div class="loading" style="">
              <img src="{{asset('/images/pj1.png')}}" alt="" width="150px">
            </div>
            
            <h4 class="tx-semibold mg-b-20" style="margin-top: 250px; color:#FFF;"> Procesando... </h4>
            {{-- <p class="mg-b-20 mg-x-20" id="mensaje_procesos">Se esta procesando su información, favor de esperar un momento...</p> --}}
          </div><!-- modal-body -->
        </div><!-- modal-content -->
      </div><!-- modal-dialog -->
    </div><!-- modal -->

    <div id="modal_loading" class="modal fade" data-backdrop="static" data-keyboard="false" >
      <div class="modal-dialog" role="document" style="width: 100%;height: 50%; max-width: 300px;">
        <div class="modal-content tx-size-sm" id="modal_content-loading" style="height:0">
          <div class="modal-body" style="text-align:center">
            {{-- <div class="sk-chasing-dots tx-success" style="width: 100px; height: 100px;">
              <div class="sk-child sk-dot1 bg-gray-500"></div>
              <div class="sk-child sk-dot2 bg-gray-500"></div>
            </div> --}}
            <div class="loadin" style="">
              <img src="{{asset('/images/pj1.png')}}" alt="" width="150px">
              <div class="wrapper" style="margin-top: 110px">
                <div class="border">
                  <div class="space">
                    <div class="loading">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            {{-- <h4 class="tx-semibold mg-b-20" style="margin-top: 250px; color:#FFF;"> Procesando... </h4> --}}
            {{-- <p class="mg-b-20 mg-x-20" id="mensaje_procesos">Se esta procesando su información, favor de esperar un momento...</p> --}}
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

    <!-- MODAL RESET -->
    <div id="modal_reset" class="modal fade" data-backdrop="static" data-keyboard="false">
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
                    <div class="input-group">
                      <input class="form-control" id="reset_pass_1" name="reset_pass_1" type="password" name="involucrados_nombre" value="" placeholder="" style="text-transform:none">
                      <div class="input-group-append">
                        <button id="show_password" class="btn btn-primary ojito" type="button" onclick="mostrarPassword('reset_pass_1', 'icons1')"> <span class="fa fa-eye-slash icons" id="icons1"></span> </button>
                      </div>
                    </div>
                </div>
              </div><!-- col-4 -->
              <div class="col-lg-6">
                  <div class="form-group">
                      <label class="form-control-label">Repetir contraseña: </label>
                      <div class="input-group">
                        <input class="form-control" id="reset_pass_2" name="reset_pass_2" type="password" name="involucrados_apellido_paterno" value="" placeholder="" style="text-transform:none">
                        <div class="input-group-append">
                          <button id="show_password" class="btn btn-primary ojito" type="button" onclick="mostrarPassword('reset_pass_2', 'icons2')"> <span class="fa fa-eye-slash icons" id="icons2"></span> </button>
                        </div>
                      </div>
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

              <div class="alert alert-danger" role="alert" id="difference" style="margin: 2% auto 0 auto; display:none;">
                Las Contraseñas no coinciden
              </div>

              <div class="alert alert-warning" role="alert" id="empty_field" style="margin: 2% auto 0 auto; display:none;">
                Existen Campos vacios
              </div>

            </div>
          </div><!-- modal-body -->
          <div class="modal-footer">
            <button type="button" class="btn btn-success" onclick="resetPass();" >Guardar</button>
          </div>
        </div>
      </div><!-- modal-dialog -->
    </div><!-- modal -->

    @if($request->session()->get('bandera_reseteo_pass')==0)

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
          /* background: #FFF; */
          width: 100%;
          left: -1000px;
          transition: 0.8s;
          z-index: 1031;
          /* background: rgb(0, 0, 0, 0.25); */
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

       
        #menu_movil::-webkit-scrollbar-thumb{   
          background: rgb(0, 0, 0, 0.15);
        }

        #menu_movil::-webkit-scrollbar-track {
          background: none !important;
        }
        #menu_movil::-webkit-scrollbar {
          width: 0px;  
        }

      </style>

    @endif

    <!-- MODAL AVISO PRIVACIDAD -->
    <div id="modal_aviso_privacidad" class="modal fade" style="">
      <div class="modal-dialog modal-lg" style="max-width: 80%;" role="document">
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
                  <strong>Los datos personales que serán sometidos al tratamiento, así como la existencia de un sistema de datos personales.</strong>
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
                <br>
                <strong>Revocación del consentimiento:</strong> Procederá a partir de que el titular exprese de manera libre, voluntaria e inequívoca su solicitud para que cese el tratamiento de sus datos personales, el cual no tendrá efectos retroactivos.<br>
                <br>
                <strong>Derechos del titular:</strong> El titular que acredite su identidad o, en su caso, su representante que acredite identidad y personalidad, podrá ejercer los derechos de acceso, rectificación, cancelación y oposición (ARCO).<br><br>    
		            <img src="/images/tabla1.png" style="width: 99%;"><br><br>
                <li type="circle">
                  <strong>Los mecanismos, medios y procedimientos disponibles para ejercer los derechos de Acceso, Rectificación, Cancelación y Oposición:</strong>
                </li>
                El interesado podrá dirigirse al Instituto de Acceso a la Información Pública de la Ciudad de México, donde recibirá asesoría sobre los derechos que tutela la Ley de Protección de Datos Personales para la Ciudad de México, al teléfono: 5636-4636; correo electrónico: datos.personales@infodf.org.mx o www.infodf.org.mx”. Solicitar información a través del sistema de solicitudes de información (INFOMEX) http://infomexdf.org.mx/InfomexDF/default.aspx; de manera presencial en las oficinas de la Unidad de Transparencia del Tribunal Superior de Justicia de la Ciudad de México, o vía correo electrónico de la Unidad de transparencia: oip@tsjcdmx.gob.mx.<br><br>
                <li type="circle">
                  <strong>El domicilio de la Unidad de Transparencia:</strong>
                </li>
                Av. Niños Héroes #132, Planta Baja, Colonia Doctores, Delegación Cuauhtémoc, C.P. 06720, Ciudad de México, en días hábiles y en un horario de atención al público de 09:00 a 15:00 horas de lunes jueves y de 09:00 a 14:00 horas los viernes.
              </ul>
            </div>
          </div><!-- modal-body -->
        </div><!-- modal-content -->
      </div><!-- modal-dialog -->
    </div><!-- modal -->

    <!-- MODAL AVISO PRIVACIDAD -->
    <div id="modal_avisos" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" >
      <div class="modal-dialog modal-lg modal-dialog-vertical-center modal-dialog-centered" role="document" style="width: 1000%;">
        <div class="modal-content tx-size-sm" >
          <div class="modal-header pd-x-20">
            <h4>Avisos</h4>
          </div>
          {{-- <div class="modal-body pd-20">
            @if($request->avisos['status']==0)
              <h4 style="text-align: center;">No hay avisos en este momento.</h4>
            @endif
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              @if($request->avisos['status']==100)
                @php $i=0; @endphp
                @foreach ($request->avisos['response'] as $aviso)
                  <li class="nav-item">
                    <a class="nav-link @if($i==0) active @endif" id="home-tab" data-toggle="tab" href="#aviso_{{$aviso['id_aviso']}}" role="tab" aria-controls="home" aria-selected="true">{{$aviso['aviso_titulo']}}</a>
                  </li>
                  @php $i++; @endphp
                @endforeach 
              @endif
            </ul>
            <div class="tab-content" id="myTabContent">
              @if($request->avisos['status']==100)
                @php $i=0; @endphp
                @foreach ($request->avisos['response'] as $aviso)
                  <div class="tab-pane fade @if($i==0) show active @endif" id="aviso_{{$aviso['id_aviso']}}" role="tabpanel" aria-labelledby="home-tab" style="padding: 10px;">{{$aviso['aviso_descripcion']}}</div>
                  @php $i++; @endphp
                @endforeach 
              @endif
            </div>
          </div><!-- modal-body --> activo en sigj--}}
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div><!-- modal-dialog -->
    </div><!-- modal -->

    <div id="modalTelegram" class="modal fade">
      <div class="modal-dialog modal-dialog-vertical-center" role="document">
        <div class="modal-content bd-0 tx-14">
          <div class="modal-header">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Registro para notificaciones Telegram</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body pd-25">
            <h5 class="lh-3 mg-b-20">Siga los siguientes pasos para registrarse y recibir notificaciones vía Telegram</h5>
            <ol>
              <li class="mg-b-10">Descargue la aplicacion de Telegram en su dispositivo móvil o PC</li>
              <li class="mg-b-10">En el buscador de la aplicación busque<span style="font-weight: bolder; font-family: monospace; font-size: 1em;"> @sigj_penal_bot </span></li>
              <li class="mg-b-10">Envie el siguiente mensaje: <span style="font-weight: bolder; font-family: monospace; font-size: 1em;">/registrar?{{intdiv(Session::get('usuario_id'),$rand).(Session::get('usuario_id')%$rand).$rand}}</span></li>
              <li class="mg-b-10">Espere a que la aplicacion le responda con un mensaje de confirmación </li>
            </ol>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div><!-- modal-dialog -->
    </div><!-- modal -->

    @yield('seccion-modales')
@endsection