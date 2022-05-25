<!DOCTYPE html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta charset="utf-8">
    <meta http-equiv="content-type" content="text/html;charset=UTF-8">
    <meta name="theme-color" content="#848F33">
    <meta name="csrf-token" content="{{ csrf_token() }}"> 
    
    <title>@yield('head-title')</title>
    <link rel="stylesheet" href="/css/normalize.css">
    <link href="../lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="../lib/Ionicons/css/ionicons.css" rel="stylesheet">
    <link href="../lib/SpinKit/css/spinkit.css" rel="stylesheet">

    <link rel="stylesheet" href="../css/slim.css">

    <link id="headerSkin" rel="stylesheet" href="">
    
    <!-- vendor css -->
    <link href="{{asset("/lib/font-awesome/css/font-awesome.css")}}" rel="stylesheet">
    <link href="{{asset("/lib/Ionicons/css/ionicons.css")}}" rel="stylesheet">
    <link href="{{asset("/lib/select2/css/select2.min.css")}}" rel="stylesheet">
    <link href="{{asset("/lib/jt.timepicker/css/jquery.timepicker.css")}}" rel="stylesheet">
    <link href="{{asset("/lib/jquery-toggles/css/toggles-full.css")}}" rel="stylesheet">
    
    @yield('estilos')
    <!-- Slim CSS -->
    <link rel="stylesheet" href="{{asset("/css/slim.css")}}">


    <style>
      .b-l-2{
        border-left:3px solid #848F33;
        padding-left: 5px;
        margin-bottom: 5px;
      }
      .btn-primary{
        background: #848F33 !important;
        border: 1px solid #848F33;
      }
      .btn-primary:focus{
        box-shadow:0 0 0 0.2rem rgba(227, 234, 183,0.5);
      }
      .btn-contact-new{
        background: #848F33 !important;
      }
      .slim-pagetitle{
        border-left: 4px solid #848F33 !important;
      }
      .logged-user img {
        width: 50px;
        height: 50px;
        padding: 3px;
        border: 1px solid #727C2E !important;
        border-radius: 100%;
      }
      table .icon{
        background: #848F33 !important;
        padding: 2px 5px;
        border-radius: 25%;
        color: #fff;
      }
      .icon.tx-danger, .icon.ion-calendar, .icon.tx-success{
        background: none !important;
      }
      .icon.ion-calendar{
        color:#495057;
      }
      .ckbox span:after{
        background-color: #848F33 !important;
      }
      .select2-container--default .select2-results__option--highlighted[aria-selected]{
        background-color: #848F33 !important;
      }
      li.ui-timepicker-selected, .ui-timepicker-list li:hover, .ui-timepicker-list .ui-timepicker-selected:hover{
        background-color: #848F33 !important;
      }
      .toggle-light.primary .toggle-on.active{
        background: #848F33 !important;
      }
      .toggle-light.primary .toggle-on.active + .toggle-blob{
        border: 3px solid #848F33 !important;
      }
      .error{
        border: 1px solid red !important;
        position: relative;
        animation-name: error;
        animation-duration: 0.6s;
      }
      
      @keyframes error {
        
        5%  {left: 10px;}
        10% {left: 0px;}
        20% {left: 10px;}
        30% {left: 0px;}
        40% {left: 10px;}
        60% {left: 0px;}
        70% {left: 3px}
        80% {left: 6px;}
        90% {left: 3px}
        100% {left: 0px;}
      }

      table{
        width: calc(100% - 2px) !important;
      }
      table.dataTable tbody tr:nth-child(2n){
        background-color: #FCFCFC;
      }
      table.dataTable tbody td {
        word-break: break-word;
        vertical-align: top;
        white-space:normal;
      }
      .btn-outline-primary {
        color: #848F33;
        background-color: transparent;
        background-image: none;
        border-color: #848F33;
      }
      .btn-outline-primary:hover {
        color: #fff;
        background-color: #848F33;
        border-color:  #848F33;
      }
      .toggle-blob{
        z-index: 1 !important;
      }
      .ui-datepicker-year{
        min-width: 60px;
      }
      .manager-left{
        width: 227px !important;
      }
      .manager-right{
        width: 918px !important;
      }
      .rdiobox input[type='radio']:checked + span:before {
        border-color: transparent;
        background-color: #848F33 !important;
      }
      .dia-inhabil a{
        background-color: #FDE7E7 !important;
      }
      .custom-cells{
        cursor: pointer;
      }
      span.select2{
        width: 100% !important;
      }
      ul.bandejas li a{
        height: 28px !important;
      }
      ul.bandejas li:first-child{
        margin-left: auto;
      }
      ul.bandejas li:last-child{
        margin-right: auto;
      }
      a.nav-link2{
        text-transform: uppercase;
        font-size: 13px;
        letter-spacing: .7px;
        font-weight: 500;
        color: #656d75;
        height: 46px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-right-width: 0;
        top: auto;
        bottom: 100%;
        margin-top: 0;
        margin-bottom: 0.025rem;
      }
      .slim-header-right .dropdown-c .nav-link .icon{
        color: #848F33;
      }
      .slim-navbar .nav-item:last-child .nav-link2 {
          border-right-width: 1px;
      }
      .activo{
        border:1px solid #848F33 !important;
      }
      .reloj_vencido{
        color: red;
      }
      .f-mayus::first-letter{
        text-transform: uppercase;
      }
      div.icono{
        background: #848F33;
        height: 25px;
        width: 25px;
        display: inline-block;
        text-align: center;
        border-radius: 25%;
      }
      div.icono a{
        height: 100%;
        width: 100%;
      }
      div.icono i{
        color: #FFF;
        font-size: 13px;
        padding-top: 5px;
      }
      div.icono.danger{
        background: #cc3300;
      }
      div.icono.warning{
        background:	#ffcc00;
      }
      div.warning-alert{
        height: 100px;
        width: 100px;
        border: 2px solid #ffcc00;
        margin-right: auto;
        margin-left: auto;
        text-align: center;
        font-size: 65px;
        color: #ffcc00;
        border-radius: 50%;
        margin-bottom: 28px;
        background-color:none !important;
      }
      .flex-container > div{
        padding: 0 !important;
      }

      .pagination-wrapper{
        height: 50px !important;
      }
      #modal_loading{
        z-index: 1150;
      }
      @media only screen and (max-width: 1199px){
        .manager-right{
          width: 100% !important;
        }
      }
      @media only screen and (max-width: 600px){
        #ui-datepicker-div{
          top: 200.5px !important;
        }
      }
      
        #notificacion_flotante{
          width: 15%;
          height: auto;
          border-radius: 10px;
          position: fixed;
          top: 4%;
          right: 1%;
          color: #fff;
        }
        .header_not{
          border: 1px solid #ccc;
          border-radius: 7px 7px 0px 0px;
          background: #848F33 !important;
          display: flex;
          justify-content: space-between;
        }
        .image{
          width: 50%;
          padding: 1px;
          font-weight: bold;
          font-size: 0.9em;
        }
        .image img{
          width: 15px;
          height: 15px;
          margin:  0 3%;
        }
        .buttons{
          width: 7%;
          display: flex;
          justify-content: center;
          align-items: center;
        }
        .closes{
          text-align: center;
          text-align: center;
          font-size: 0.8em;
          font-weight: bold;
          cursor: pointer;
        }
        .closes:hover{
          background: rgba(255, 255, 255, 0.1);
        }
        .closes:active{
          transform: scale(0.95);
        }
        .body_not{
          border: 1px solid #ccc;
          border-radius: 0px 0px 7px 7px;
          height: auto;
          color: rgb(104, 104, 104);
          background: #fff;
        }
        .body_not ul{
          padding: 0;
          font-size: 0.84em;
          font-weight: bold;
          color: #aaa;
        }
        .body_not ul li{
          list-style: none;
          width: 100%;
          text-align: center;
          padding-top: 4px; 
          width: 270px;
          white-space: nowrap;
          text-overflow: ellipsis;
          overflow: hidden;
          padding: 4px;
        }

        /* MENU DE ALERTAS */
        .alertas{
          position: fixed;
          right: 0;
          width: 40px;
          height: 40px;
          border: 1px solid #ccc;
          text-align: center;
          cursor: pointer;
          border-radius: 20px 0 0 20px;
          border-right: none;
          color: #fff;
          background: #848F33 !important;
          display: flex;
          justify-content: center;
          align-items: center;
          z-index: 9999;
        }
        .cant{
          background: red;
          width: 14px;
          height: 14px;
          font-size: 0.6em;
          text-align: center;
          position: absolute;
          border-radius: 50%;
          top: 5px;
          right: 6px;
        }
        .menu_notificacion{
          width: 300px;
          background: #848f33e0  !important;
          height: 100%;
          position: fixed;
          padding: 6px;
          top: 0;
          right: -300px;
          z-index: 2000;
        }
        .open_menu_n{
          right: 0;
          transition: right 0.5s ease-in-out;
        }
        .alertas_s{
          right: 300px;
          transition: right 0.5s ease-in-out;
        }
        .close_menu_n{
          right: -300px;
          transition: right 0.5s ease-in-out;
        }
        .alertas_close{
          right: 0;
          transition: right 0.5s ease-in-out;
        }
        .title_not{
          width: 100%;
          border: 3px solid #fff;
          padding: 6px;
          text-align: center;
          color: #fff;
          font-weight: bold;
        }
        .notificacion_header{
          display: flex;
          justify-content: space-between;
          align-items: center;
          height: 20px;
          width: 100%;
          font-size: 0.7em;
          font-weight: bold;      
        }
        .body_notificacion{
          width: 100%;
          height: 92%;
          margin: 9% 0;
          overflow: auto;
        }
        .body_notificacion::-webkit-scrollbar {
          width: 5px;
          height: 8px;     
        }
    
        .body_notificacion::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 4px;
        }
    
        .body_notificacion::-webkit-scrollbar-thumb:hover {
            background: #b3b3b3;
            box-shadow: 0 0 2px 1px rgba(0, 0, 0, 0.2);
        }
    
        .body_notificacion::-webkit-scrollbar-thumb:active {
            background-color: #999999;
        }
    
        .body_notificacion::-webkit-scrollbar-track {
            background: #e1e1e1;
            border-radius: 4px;
        }
    
        .body_notificacion::-webkit-scrollbar-track:hover,
        .body_notificacion::-webkit-scrollbar-track:active {
          background: #d4d4d4;
        } 
        .notificacion_footer{
          font-size: 0.63em;
          font-weight: bold;
          text-align: right;
          padding: 4px  12px  1px  12px;
        }
        .notificacion_footer a{
          color: #848F33;
        }
        .alertas_n{
          width: 100%;
          min-height: 70px;
          height: auto;
          border: 1px solid  #ccc;
          background: rgba(255, 255, 255, 0.8);
          display: flex;
          border-radius: 6px;
          cursor: pointer;
          margin: 1.5% 0;
          padding: 4px;
          flex-direction: column;
        }
        .alertas_n:hover{
          background: rgba(255, 255, 255, 0.89);
        }
        .logo_n{
          width: 30%;
          height: auto;
          display: flex;
          justify-content: center;
          align-items: center;
        }
        .image_n{
          width: 20px;
          height: 20px;
          border-radius: 50%;
        }
        .image_n img{
          width: 100%;
          height: 100%;
        }
        .mensaje_notificacion{
          width: 70%;
          height: auto;
        }
        .mass{
          font-size: 0.7em;
          text-align: left;
          color: #7d7d7d;
          margin-top: 3%;
          padding: 4px 10px;
          text-align: justify;
        }
        .ocultarTexto{
          width: 270px;
          white-space: nowrap;
          text-overflow: ellipsis;
          overflow: hidden;
        }
        .mostrarTexto{
          width: 100%;
          height: auto;
          transition: all 10ms;
        }
        .hora{
          width: 100%;
          font-size: 0.61em;
          text-align: left;
          margin-top: 4%;
          transition: all 10ms;
        }
        .empty_notification{
          color: rgba(255,255,255,0.5);
          text-align: center;
          display: flex;
          justify-content: center;
          align-items: center;
          flex-direction: column;
        }
        .empty_notification i{
          font-size: 2em;
          margin: 7% 0;
        }
        #reset_pass_1, #reset_pass_2{
          border-right: none;
        }
        .ojito{
          background:transparent !important; 
          color:#ccc; 
          border-left:none !important; 
          color:#ccc; 
          outline:none;
          border-right:1px solid #ccc !important;
          border-top:1px solid #ccc !important;
          border-bottom:1px solid  #ccc!important;
        }
        .ojito:focus{
          outline:none !important;
          box-shadow: none !important;
        }
        .ojito:active{
          outline:none !important;
          box-shadow: none !important;
        }
        .ojito:hover{
          color: #ccc;
        }
    </style>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">

    
  </head>
  <body>
    <div id="app">
      @yield('content')
    </div>

    
      

      @yield('cuerpo')
  
      @yield('modales')
      
    <script src="{{ $entorno["version_pages"]["version"] }}/lib/jquery/js/jquery.js"></script>
    <script src="{{ $entorno["version_pages"]["version"] }}/lib/moment/js/moment.js"></script>
    <script src="{{ $entorno["version_pages"]["version"] }}/lib/bootstrap/js/bootstrap.js?id=1"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    {{-- <script type="text/javascript" src="{{asset('js/app.js')}}"></script> --}}

    <script>
      $('#modal_loading').modal('show');
    </script>
    
    

    <script src="{{ $entorno["version_pages"]["version"] }}/lib/popper.js/js/popper.js"></script>
    <script src="{{ $entorno["version_pages"]["version"] }}/lib/jquery.cookie/js/jquery.cookie.js"></script>
    {{-- <script src="{{asset("/lib/jquery/js/jquery.js")}}"></script>  --}}
    {{-- <script src="{{asset("/lib/popper.js/js/popper.js")}}"></script> --}}
    {{-- <script src="{{asset("/lib/bootstrap/js/bootstrap.js")}}"></script> --}}
    {{-- <script src="{{asset("/lib/jquery.cookie/js/jquery.cookie.js")}}"></script> --}}
    <script src="{{asset("/lib/select2/js/select2.full.min.js")}}"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script> --}}
    <script src="{{asset("/lib/jquery-toggles/js/toggles.min.js")}}"></script>
    <script src="{{asset("/lib/jt.timepicker/js/jquery.timepicker.js")}}"></script>
    <script src="{{asset("/lib/spectrum/js/spectrum.js")}}"></script>
    <script src="{{asset("/lib/jquery.maskedinput/js/jquery.maskedinput.js")}}"></script>
    <script src="{{asset("/lib/bootstrap-tagsinput/js/bootstrap-tagsinput.js")}}"></script>

    <script src="{{asset("/js/slim.js")}}"></script>
    <script src="{{asset('js/swiped-events.js')}}"></script>
    @yield('scripts-libs')
   
    @yield('scripts-functions')
      <script>
        $(function(){
          'use strict';
          
          $('.slim-mainpanel').ready(function(){
            
          });
          
          $('.select2').select2({
              minimumResultsForSearch: Infinity
          });

          // Select2 by showing the search
          $('.select2-show-search').select2({
            minimumResultsForSearch: ''
          });

          // Colored Hover
          $('#select2').select2({
            dropdownCssClass: 'hover-success',
            minimumResultsForSearch: Infinity // disabling search
          });

          $('#select3').select2({
            dropdownCssClass: 'hover-danger',
            minimumResultsForSearch: Infinity // disabling search
          });

          // Outline Select
          $('#select4').select2({
            containerCssClass: 'select2-outline-success',
            dropdownCssClass: 'bd-success hover-success',
            minimumResultsForSearch: Infinity // disabling search
          });

          $('#select5').select2({
            containerCssClass: 'select2-outline-info',
            dropdownCssClass: 'bd-info hover-info',
            minimumResultsForSearch: Infinity // disabling search
          });

          // Full Colored Select Box
          $('#select6').select2({
            containerCssClass: 'select2-full-color select2-primary',
            minimumResultsForSearch: Infinity // disabling search
          });

          $('#select7').select2({
            containerCssClass: 'select2-full-color select2-danger',
            dropdownCssClass: 'hover-danger',
            minimumResultsForSearch: Infinity // disabling search
          });

          // Full Colored Dropdown
          $('#select8').select2({
            dropdownCssClass: 'select2-drop-color select2-drop-primary',
            minimumResultsForSearch: Infinity // disabling search
          });

          $('#select9').select2({
            dropdownCssClass: 'select2-drop-color select2-drop-indigo',
            minimumResultsForSearch: Infinity // disabling search
          });

          // Full colored for both box and dropdown
          $('#select10').select2({
            containerCssClass: 'select2-full-color select2-primary',
            dropdownCssClass: 'select2-drop-color select2-drop-primary',
            minimumResultsForSearch: Infinity // disabling search
          });

          $('#select11').select2({
            containerCssClass: 'select2-full-color select2-indigo',
            dropdownCssClass: 'select2-drop-color select2-drop-indigo',
            minimumResultsForSearch: Infinity // disabling search
          });

        });
      </script>
      <script>
        $('body').on('input','.input-number', function(){
          valor = this.value.replace(/[^0-9]/g, '');
          $(this).val(valor);
        });

        $('body').on('input','.input-money', function() {
          $(this).val(toMoney($(this).val(), 'input'));
        });

        function toMoney(val, ver_en='') {
          
          const valor = val.toString().replace('$','').split('.');
          let pesos = new Intl.NumberFormat("en-US").format(valor[0].replace(/[^0-9]/g, '')) ;
          let n_valor = pesos;
          if( valor.length > 1 ){
            const centavos = "."+(valor[1].replace(/[^0-9]/g, '').substr(0,2));
            n_valor = n_valor.concat(centavos);
          }else if( ver_en != 'input') {
            const centavos = ".00";
            n_valor = n_valor.concat(centavos);
          }

          return "$ "+n_valor;
        }

        var normalize = (function() {
          var from = "ÃÀÁÄÂÈÉËÊÌÍÏÎÒÓÖÔÙÚÜÛãàáäâèéëêìíïîòóöôùúüûÑñÇç",
              to   = "AAAAAEEEEIIIIOOOOUUUUaaaaaeeeeiiiioooouuuunncc",
              mapping = {};

          for(var i = 0, j = from.length; i < j; i++ )
              mapping[ from.charAt( i ) ] = to.charAt( i );

          return function( str ) {
              var ret = [];
              for( var i = 0, j = str.length; i < j; i++ ) {
                  var c = str.charAt( i );
                  if( mapping.hasOwnProperty( str.charAt( i ) ) )
                      ret.push( mapping[ c ] );
                  else
                      ret.push( c );
              }
              return ret.join( '' ).replace( /-|[^-A-Za-z0-9]+/g, '_' ).toLowerCase();;
          }

        })();

        function formatoFecha(fecha_origen, formato="dd-mm-yy", formato_mes='l') {
        
          meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];

          arr_fecha = fecha_origen.split('-');
          fecha = new Date(arr_fecha[0], arr_fecha[1]-1, arr_fecha[2]);
          let mes = '';
          if( formato_mes == 'l' )
            mes = meses[fecha.getMonth()];
          else
            mes = (fecha.getMonth() +1).toString().padStart(2, '0');
            
          const map = {
              dd: fecha.getDate().toString().padStart(2, '0'),
              mm: mes,
              yy: fecha.getFullYear().toString(),
              yyyy: fecha.getFullYear()
          }
          
          return formato.replace(/dd|mm|yy|yyy/gi, matched => map[matched])
        }

      </script>
  
    <div id="pg-visible-sm" class="visible-sm"></div>
    <div id="pg-visible-xs" class="visible-xs"></div>
    @if (Session::has('cadena-sesion'))

      <script>      
        
        const sesion = @php echo json_encode(Session::all()) @endphp;
        
        document.tidioIdentify = {
          distinct_id: @php echo Session::get('usuario_id'); @endphp, // Unique visitor ID in your system
          email: "contact@mail", // visitor email
          name: '@php echo Session::get('usuario_nombre').' '.Session::get('usuario_nombre_completo'); @endphp', // Visitor name
          phone: "+44 2032897807" //Visitor phone
        };

      </script>
      
    @endif
    @if( date('Y-m-d H:i:s') >= '2022-01-31 08:00:00')

      <script src="//code.tidio.co/uxw0qgvt6ic2ahekrjfz3qyum2hysduy.js" async></script>

    @endif
    </body>
</html>