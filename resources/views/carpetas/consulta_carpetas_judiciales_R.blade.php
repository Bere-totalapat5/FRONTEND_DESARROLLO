  @php
    use App\Http\Controllers\clases\humanRelativeDate;
    use App\Http\Controllers\clases\utilidades;
    $humanRelativeDate = new humanRelativeDate();
  @endphp
  @extends('layouts.index') 

  @section('contenido-pageheader')
    <ol class="breadcrumb slim-breadcrumb">
      <li class="breadcrumb-item"><a href="/home">Home</a></li>
      <li class="breadcrumb-item"><a href="#">Administracion</a></li>
      <li class="breadcrumb-item active" aria-current="page">Administracion Carpetas Judiciales</li>
    </ol>
    <h6 class="slim-pagetitle">Administracion de carpetas judiciales</h6>
  @endsection
  @section('contenido-principal')
    <div class="section-wrapper mg-b-100">
      {{-- @if(!utilidades::buscarPermisoMenu($request->menu_general['response'], 4, 0)) --}}
      @if(false)
        <h1 class="mg-b-50">No tiene permiso para acceder a esta sección, verifíquelo con su titular</h1>
        <a href="/home"><button class="btn btn-primary btn-block">Regresar al inicio</button><a>
      @else
        <div class="form-layout mg-b-25">
          <div id="accordion" class="accordion-one" role="tablist" aria-multiselectable="true">
            <div class="card">
              <div class="card-header" role="tab" id="headingOne">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" class="tx-gray-800 transition collapsed">
                Búsqueda Avanzada
                </a>
              </div><!-- card-header -->
              <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                <div class="card-body">
                    <div class="row mg-b-15">
                      <div class="col-lg-3">
                        <div class="form-group mg-b-10-force">
                          <label class="form-control-label">Carpeta:</label>
                          <input class="form-control" type="text" name="carpeta_inv" id="carpetaInvestigacion"  autocomplete="off">
                        </div>
                      </div><!-- col-3 -->
                      <div class="col-lg-3">
                        <div class="form-group mg-b-10-force">
                          <label class="form-control-label">Folio:</label>
                          <input class="form-control" type="text" name="folioCarpeta" id="folioCarpeta"  autocomplete="off">
                        </div>
                      </div><!-- col-3 -->
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label class="form-control-label">Desde:</label>
                          <div class="input-group">
                              <div class="input-group-prepend">
                                  <div class="input-group-text">
                                      <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                  </div>
                              </div>
                              <input type="text" class="form-control fc-datepicker" placeholder="DD/MM/AAAA" id="fechaAsignacionMin" name="fecha_asiganacion_min" autocomplete="off">
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label class="form-control-label">Hasta:</label>
                          <div class="input-group">
                              <div class="input-group-prepend">
                                  <div class="input-group-text">
                                      <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                  </div>
                              </div>
                              <input type="text" class="form-control fc-datepicker" placeholder="DD/MM/AAAA" id="fechaAsignacionMax" name="fecha_asignacion_max" autocomplete="off">
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="form-group mg-b-10-force">
                          <label class="form-control-label">Nombre(s):</label>
                          <input class="form-control" type="text" name="nombres" id="nombres"  autocomplete="off">
                        </div>
                      </div><!-- col-3 -->
                      <div class="col-lg-4">
                        <div class="form-group mg-b-10-force">
                          <label class="form-control-label">Apellido Paterno:</label>
                          <input class="form-control" type="text" name="apellidoPaterno" id="apellido_paterno"  autocomplete="off">
                        </div>
                      </div><!-- col-3 -->
                      <div class="col-lg-4">
                        <div class="form-group mg-b-10-force">
                          <label class="form-control-label">Apellido Materno:</label>
                          <input class="form-control" type="text" name="apellidoMaterno" id="apellido_materno"  autocomplete="off">
                        </div>
                      </div><!-- col-3 -->
                    </div>
                    <div class="row col-lg-15">
                      <div class="col-lg-12 d-flex">
                        <button class="btn btn-primary mg-l-auto " onclick="buscar(1)">Buscar</button>
                      </div>
                    </div>
                </div><!-- card-bod -->
              </div>
            </div>
          </div><!-- accordion -->
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="pagination-wrapper justify-content-between">
              <ul class="pagination mg-b-0">
                <li class="page-item">
                  <a class="page-link primera" href="javascript:void(0)" aria-label="Last" onclick="buscar(1)">
                    <i class="fa fa-angle-double-left"></i>
                  </a>
                </li>
                <li class="page-item">
                  <a class="page-link anterior" href="javascript:void(0)" aria-label="Next" onclick="buscar(1)">
                    <i class="fa fa-angle-left"></i>
                  </a>
                </li>
              </ul>

              <ul class="pagination mg-b-0">
                <li class="page-item">Página <span class="pagina">1</span> de <span class="total-paginas">1</span></li>
              </ul>

              <ul class="pagination mg-b-0">
                <li class="page-item">
                  <a class="page-link siguiente" href="javascript:void(0)" aria-label="Next" onclick="buscar(1)">
                    <i class="fa fa-angle-right"></i>
                  </a>
                </li>
                <li class="page-item">
                  <a class="page-link ultima" href="javascript:void(0)" aria-label="Last" onclick="buscar(1)">
                    <i class="fa fa-angle-double-right"></i>
                  </a>
                </li>
              </ul>
            </div>
            <table id="tableCarpetas" class="display dataTable dtr-inline collapsed" style="overflow-x: auto; padding-left:0; padding-rigth:0">
              <thead style="background-color: #EBEEF1; color: #000;">
                <th class="acciones">Acciones</th>
                <th class="carpeta">Tipo de Carpeta</th>
                <th class="folio">Folio</th>
                <th class="carpeta_inv">Carpeta Inv</th>
                <th class="fecha">Creación</th>
                <th class="situacion">Situación</th>
                <th class="tipo_solicitud">T. Solicitud</th>
                <th class="involucrados">Involucrados</th>
                <th class="delitos">Delitos</th>
              </thead>
              <tbody id="bodyCarpetas">

              </tbody>
            </table>
            <div class="pagination-wrapper justify-content-between">
              <ul class="pagination mg-b-0">
                <li class="page-item">
                  <a class="page-link primera" href="javascript:void(0)" aria-label="Last" onclick="buscar(1)">
                    <i class="fa fa-angle-double-left"></i>
                  </a>
                </li>
                <li class="page-item">
                  <a class="page-link anterior" href="javascript:void(0)" aria-label="Next" onclick="buscar(1)">
                    <i class="fa fa-angle-left"></i>
                  </a>
                </li>
              </ul>

              <ul class="pagination mg-b-0">
                <li class="page-item">Página <span class="pagina">1</span> de <span class="total-paginas">1</span></li>
              </ul>

              <ul class="pagination mg-b-0">
                <li class="page-item">
                  <a class="page-link siguiente" href="javascript:void(0)" aria-label="Next" onclick="buscar(1)">
                    <i class="fa fa-angle-right"></i>
                  </a>
                </li>
                <li class="page-item">
                  <a class="page-link ultima" href="javascript:void(0)" aria-label="Last" onclick="buscar(1)">
                    <i class="fa fa-angle-double-right"></i>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      @endif
    </div>
  @endsection
  @section('seccion-estilos')
    <link rel="stylesheet" type="text/css" href="{{asset("/css/dropzone.min.css")}}">
    <link href="{{asset("/lib/datatables/css/jquery.dataTables.css")}}" rel="stylesheet">

    <link rel="stylesheet" href="/box/scheduler/codebase/dhtmlxscheduler_material.css?v=5.3.8" type="text/css" charset="utf-8">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="/box/scheduler/samples/common/controls_styles.css?v=5.3.8">
    <link href="{{ $entorno["version_pages"]["version"] }}/lib/jt.timepicker/css/jquery.timepicker.css" rel="stylesheet">
    <link href="{{ $entorno["version_pages"]["version"] }}/lib/select2/css/select2.min.css" rel="stylesheet">

    
    <style>
      .custom-input-file {
        cursor: pointer;
        font-size: 1em;
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
      .select2-container.select2-container--default.select2-container--open{
        z-index: 1050;
      }
      .ui-datepicker.ui-widget.ui-widget-content.ui-helper-clearfix.ui-corner-all{
        z-index: 1050 !important;
      }
      .carpeta{
        min-width: 101px !important;
      }
      .folio{
        min-width: 130px !important;
      }
      .fecha{
        min-width: 75px !important;
      }
      .situacion{
        min-width: 60px !important;
      }
      .tipo_solicitud{
        min-width: 100px !important;
      }
      .involucrados{
        min-width: 170px !important;
      }
      .delitos{
        min-width: 190px !important;
      }
      td.tipo_audiencia{
        text-transform: uppercase;
      }
      .acciones{
        min-width: 60px !important;
      }
      .carpeta_inv{
        min-width: 120px !important;
      }
      td.acciones{
        font-size: 16px !important;
      }

      #tableCarpetas{
        display:table;
        margin-bottom: 15px;
        margin-top: 15px;
      }
      #tableCarpetas td,#tableCarpetas th{
        padding:12px !important;
      }
      div.modal-body i.tx-success{
        color: #23BF08 !important;
      }
      .pagination-wrapper{
        height: 50px !important;
      }

      table.tableDatosSujeto  td, table.tableDatosSujeto th{
        border: 1px solid #EEE;
        vertical-align: text-top;
        padding: 5px;
      }

      table.tableDatosSujeto2  td, table.tableDatosSujeto2 th{
        border: 1px solid #EEE;
        vertical-align: text-top;
        padding: 5px;
        width: 33%;
      }
      table.tableDatosSujeto tbody.table-datos-sujeto tr td:nth-child(2n-1){
        background-color: #f8f9fa;
      }
      table.tableDatosSujeto tbody.table-datos-sujeto tr td{
        width: 25%;
      }
      table.tableDatosSujeto2 thead tr:first-child{
        background-color: #f8f9fa;
      }

      div.modalAdministracion-body{
        /* min-width: 90% !important; */
        min-width: 1600px;
      }

      div.modalRemision-body{
        /* min-width: 90% !important; */
        min-width: 90%;;
      }

      div.modalAdministracion-content{
        min-height: 800px;
      }
      div.modalRemision-content{
        min-height: 80%;
      }
      
      .tx-secondary {
        color: #727C2E !important;
      }

      /* toggle con apariencia de boton */
      .bkg-collapsed-btn{
        background-color: #b0b781 !important;
      }

      .bkg-collapsed-btn-hover {
        background-color: #848961  !important;
      }

      .bkg-collapsed-btn-hover:hover{
        background-color: #fff !important;
        color: #848961 !important; 
        border: 2px solid #848961 !important;
      }

      .bkg-collapsed-btn-edit {
        /* background-color: #FF5733 !important; */
        background-color: #f5755a !important;
      }

      .tx-white {
        color: #ffffff !important;
      }

      table .fas, .far {
        background: #848F33 !important;
        padding: 5px 5px;
        border-radius: 25%;
        color: #fff;
      }

      .row{
        /*PARA QUE SELECT NO SALGA DE ROW POR SER MUY LARGO  */
        overflow: hidden;
      }

      .dhx_cal_event_line{
        background: #848961;
      }

      .timeline_scalex_class{
        min-width:40px !important;
        max-width:41px !important;
      }

      @media only screen and (max-width: 1700px) {
        #tableCarpetas{
          display: block;
        }
        div.modalAdministracion-body{
          max-width: 900px !important;
        }
      } 
      @media (min-width: 992px){
        .modal-lg.xl {
            max-width: 1017px;
        }

        div.modalRemision-body{
          max-width: 900px !important;
        }

        .labelTipoRemision{
          font-family: "Roboto", "Helvetica Neue", Arial, sans-serif;
      font-size: 1.875rem;
      font-weight: 400;
      line-height: 1.5;
      color: #848F33 ;
      text-align: left;
        }

      /* <estilos rulo> */
      #formularioRemision{
        /* max-width: 60% !important; */
        display: grid;
      }

      textarea{
        background-color: white  !important;
        min-height: 100px !important;
        width: 100% !important;
      }

    
    
      .accordionImputados-one .card-header a {
        display: block;
    /*   padding: 9px 10px; */
        color: #154f89;
        position: relative;
        border-bottom: none !important;
        background-color: #f8f9fa !important;
    
      }
      .accordionImputados{
        max-width: 100%;
        
      }
      }
      
      #ui-datepicker-div{
        z-index: 1050 !important;
      }

      .table-remi{
        overflow-x: auto;
        display: block;
      }

      .table-remi tr{
        border: 1px solid #dee2e6;
      }

      .table-remi tbody tr:hover{
        background-color: #f6f6f6;
      }

      .table-remi thead tr{
        background: #eee;
        color: #000;
        padding: 12px;
      }
      
      .table-remi th,td{
        padding: 7px 10px;
      }
      .acciones{
        min-width: 40px;
      }
      .nombre{
        min-width: 180px;
      }
      .t-persona{
        min-width: 105px !important;
      }
      .delito{
        min-width: 380px;
      }
      .anios_abono{
        min-width: 40px;
      }
      .meses_abono{
        min-width: 40px;
      }
      .dias_abono{
        min-width: 40px;
      }
      .centro_abono{
        min-width: 365px;
      }
      .otro_centro_abono{
        min-width: 365px;
      }
      .sustitutivo{
        min-width: 279px;
      }
      .monto_sustitutivo{
        min-width: 100px;
      }
      .acoge_sustitutivo{
        min-width: 163px;
      }
      .detalles_adicionales_sustitutivo{
        min-width: 279px;
      }
      .pena{
        min-width: 180px;
      }
      .delitos{
        min-width: 230px;
      }
      .detalles{
        min-width: 230px;
      }
      .sustitutivo{
        min-width: 230px;
      }
      .nav-link{
        padding: 0.5rem 0.5rem !important;
      }
      .sk-circle {
          margin: auto auto !important;
      }
      .mg-b-18{
        margin-bottom: 18px;
      }
      .input-number, .input-money{
        text-align: end;
      }

      #modalRemision .modal-dialog{
        width: calc(100% - 16px);
      }

      #modalDocumento .modal-dialog{
        width: calc(100% - 16px);
      }

      #modalSentenciado .modal-dialog{
        width: 100%;
        min-width: calc(100% - 16px);
      }

      @media only screen and (max-width:776px){
        #modalSentenciado .modal-dialog{
          width: 95%;
        } 
        
      }

      #modalPenas .modal-dialog{
        width: calc(100% - 16px);
      }

      #modalDelitos .modal-dialog{
        width: calc(100% - 16px);
      }
      #modalDefensor .modal-dialog{
        width: calc(100% - 16px);
      }
      #tablePenas{
        display: block;
      }

      @media only screen and (min-width:503px){
        .table-remi{
          display: table;
        }
      }
      @media only screen and (min-width:887){
        
      }
      @media only screen and (min-width:992px){
        #modalRemision .modal-dialog{
          width: 95%;
          max-width: 1300px;
        }
        #modalDocumento .modal-dialog{
          width: 95%;
          max-width: 1300px;
        }
        #modalSentenciado .modal-dialog{
          min-width: 990px;
        }
        #modalPenas .modal-dialog{
          min-width: 95%;
        }
        #modalDelitos .modal-dialog{
          min-width: 800px;
        }
        #modalDefensor .modal-dialog{
          width: 990px;;
        }
        #tablePenas{
          display: table;
        }
        .br-lg-1{
          border-right: 3px solid #ced4da;
        }
        .bt-lg-1{
          border-top: 3px solid #ced4da;
        }
        .bb-lg-1{
          border-bottom: 3px solid #ced4da;
        }
        .mg-t-md-28{
          margin-top: 28px;
        }
      }

      @media only screen and (min-width:1141px){
        #modalRemision .modal-dialog{
          width: 95%;
          max-width: 1300px !important;
        }
        #modalDocumento .modal-dialog{
          width: 95%;
          max-width: 1300px !important;
        }
        #modalPenas .modal-dialog{
          min-width: 990px;
        }
      }
      p#modal-success-titulo::first-letter{
        text-transform: uppercase;
      }
      @media only screen and (max-width:1208px){
        .mg-b-1208-29{
          margin-bottom: 29px;
        }
      }
      @media only screen and (max-width:1360px){
        .mg-b-1360-29{
          margin-bottom: 29px;
        }
      }
      @media only screen and (min-width:1050px) and (max-width:1360px){
        .mg-b-1360-29-2{
          margin-bottom: 29px;
        }
      }
      /* </estilos rulo> */
    </style>
  @endsection
  @section('seccion-scripts-libs') 
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    <script src="/box/scheduler/codebase/dhtmlxscheduler.js?v=5.3.8" charset="utf-8"></script>
    <script src="/box/scheduler/codebase/ext/dhtmlxscheduler_limit.js?v=5.3.8" charset="utf-8"></script>
    <script src="/box/scheduler/codebase/ext/dhtmlxscheduler_agenda_view.js?v=5.3.8" charset="utf-8"></script>
    <script src='/box/scheduler/codebase/ext/dhtmlxscheduler_timeline.js?v=5.3.8' type="text/javascript" charset="utf-8"></script>
    <script src='/box/scheduler/codebase/ext/dhtmlxscheduler_treetimeline.js?v=5.3.8' type="text/javascript" charset="utf-8"></script>
    <script src="/box/scheduler/codebase/ext/dhtmlxscheduler_minical.js?v=5.3.8" type="text/javascript" charset="utf-8"></script>
    <script src="/box/scheduler/codebase/ext/dhtmlxscheduler_units.js?v=5.3.8" type="text/javascript" charset="utf-8"></script>
    <script src="/box/scheduler/codebase/ext/dhtmlxscheduler_week_agenda.js?v=5.3.8" type="text/javascript" charset="utf-8"></script>

    <script src="{{ $entorno["version_pages"]["version"] }}/lib/jt.timepicker/js/jquery.timepicker.js"></script>
    <script src="{{ $entorno["version_pages"]["version"] }}/lib/select2/js/select2.min.js"></script>
    <script src="{{asset('/js/remisiones/remision.js')}}"></script>
    <script src="{{asset('/js/remisiones/remision_unidad_ejecucion.js')}}"></script>
  @endsection
  @section('seccion-scripts-functions')
    <script>
      const expRegFecha=/^([0-2][0-9]|3[0-1])(-)(0[1-9]|1[0-2])\2(\d{4})$/,
            expRegHora=/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/,
            expVacio=/^[\s]*$/;
            guardias=[],
            penas=[],
            tipos_documentos_carpeta = @php echo json_encode($tipos_documento_carpeta); @endphp;
      let arrPersonas,
          folio_carpeta_seleccionada,
          carpeta_seleccionada,
          unidad_carpeta,
          strUnidadesDestino,
          form,
          copia_certificada_sentencia,
          etapas_rue=[]
          remi_sentenciados=[];
      var arrCarpetasJudiciales=[];
      var carpetaActiva=null;

      $(document).ready(function() {
        buscar(1);
        // setTimeout(function(){ loadConfigComponentsPP(); }, 300);
        // setTimeout(function(){ loadConfigComponentsDA(); }, 300);
        // setTimeout(function(){ loadConfigComponentLT(); }, 300);
        setTimeout(function(){ $('#modal_loading').modal('hide'); }, 1000);
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
      
      $(function(){
        'use strict'

        Toggles
        $('.toggle').toggles({
          on: false,
          height: 26
        });

        // Input Masks
        $('#dateMask').mask('99/99/9999');
        $('#phoneMask').mask('(999) 999-9999');
        $('#ssnMask').mask('999-99-9999');

        // Time Picker
        $('#tpBasic').timepicker();
        $('#tp2').timepicker({'scrollDefault': 'now'});
        $('#horaInicio').timepicker();
        $('#horaFin').timepicker();

        $('#setTimeButton').on('click', function (){
          $('#horaRecepcion').timepicker('setTime', new Date());
        });

        // Color picker
        $('#colorpicker').spectrum({
          color: '#17A2B8'
        });

        $('#showAlpha').spectrum({
          color: 'rgba(23,162,184,0.5)',
          showAlpha: true
        });

        $('#showPaletteOnly').spectrum({
            showPaletteOnly: true,
            showPalette:true,
            color: '#DC3545',
            palette: [
                ['#1D2939', '#fff', '#0866C6','#23BF08', '#F49917'],
                ['#DC3545', '#17A2B8', '#6610F2', '#fa1e81', '#72e7a6']
            ]
        });
        
      });

      function internoRecl(myRadio) {
                
        var selectedValue = myRadio.value;

        if (selectedValue==="no") {
          
          $('#reclusorioInternamiento').attr('disabled',true);
          $('#reclusorioInternamiento').val('').select2({minimumResultsForSearch: ''});
          $("#reclusorioInternamiento").parent().find('.tx-danger').addClass('d-none');
          
        } else if (selectedValue==="si"){
          
          $('#reclusorioInternamiento').removeAttr('disabled');
          $("#reclusorioInternamiento").parent().find('.tx-danger').removeClass('d-none');
        }

      }

              
      function privadoLib(myRadio) {
                
        var selectedValue = myRadio.value;

        if (selectedValue==="no") {
          
          $('#lugarInternamiento').attr('disabled',true);
          $('#lugarInternamiento').val('').select2({minimumResultsForSearch: ''});
          $("#lugarInternamiento").parent().find('.tx-danger').addClass('d-none');
          
        } else if (selectedValue==="si"){
          
          $('#lugarInternamiento').removeAttr('disabled');
          $("#lugarInternamiento").parent().find('.tx-danger').removeClass('d-none');
        }

      }

      function tipoUnidad(myRadio) {
        
        // var selectedValue = myRadio.value;

        // if (selectedValue==="uAprehensiones") {
        //   console.log("especifica");
        //   document.getElementById('unidadDestinoLabel').placeholder='UNIDAD DE GESTION JUDICIAL 12';
        //   document.getElementById('edificioReceptor').value='5';

          
        // } else if (selectedValue==="uOficio"){
        //   console.log("oficio");
          
        // }else if (selectedValue==="uQuerella"){
        //   console.log("querella");

        //   document.getElementById('unidadDestinoLabel').placeholder='Unidad de Gestión Judicial 1, Unidad de Gestión Judicial 3, Unidad de Gestión Judicial 4, Unidad de Gestión Judicial 5';
          
        // }else if (selectedValue==="uMujeres"){
        //   console.log("mujeres");
        //   document.getElementById('unidadDestinoLabel').placeholder='UNIDAD DE GESTION JUDICIAL 11';
        //   document.getElementById('edificioReceptor').value='10';
        // }

      }

      function buscar(pagina){
        
        arrCarpetasJudiciales=[];

        $.ajax({
          method:'POST',
          url:'/public/h_obtener_carpetas_judiciales_h',
          data:{
            modo:"completo",
            carpeta_inv:$('#carpetaInvestigacion').val(),
            fecha_asignacion_min:$('#fechaAsignacionMin').val(),
            fecha_asignacion_max:$('#fechaAsignacionMax').val(),
            folio_carpeta:$('#folioCarpeta').val(),
            carpeta_judicial:$('#carpetaJudicial').val(),
            nombre:$('#nombre').val(),
            apellido_paterno:$('#apellidoPaterno').val(),
            apellido_materno:$('#apellidoMaterno').val(),
            pagina,
          },
          success:function(response){
            $('#bodyCarpetas').html('');
            if(response.status==100){
              // guardias=response.response;
              $(response.response).each(function(index, carpeta_judicial){
                const {nombre_tipo_carpeta,folio_carpeta,fecha_creacion,situacion_carpeta,tipo_solicitud_, imputados, victimas, delitos, id_carpeta_judicial, carpeta_investigacion}=carpeta_judicial;
                let lIimputados='',
                    lVictimas='',
                    lDelitos='';

                arrCarpetasJudiciales[id_carpeta_judicial]=carpeta_judicial;

                if(imputados.length){
                  lIimputados=lIimputados.concat('<h6 class="mg-b-0">Imputados</h6>');
                  $(imputados).each(function(index, imputado){
                    lIimputados=lIimputados.concat(`<div class="b-l-2">${imputado.razon_social==null?'':imputado.razon_social}${imputado.nombre==null?'':imputado.nombre}</div>`);
                  });
                }

                if(victimas.length){
                  lVictimas=lVictimas.concat('<h6 class="mg-b-0">Víctimas</h6>');
                  $(victimas).each(function(index, victima){
                    lVictimas=lVictimas.concat(`<div class="b-l-2">${victima.razon_social==null?'':victima.razon_social}${victima.nombre==null?'':victima.nombre}</div>`);
                  });
                }

                if(delitos.length){
                  $(delitos).each(function(index, delito){
                    lDelitos=lDelitos.concat(`<div class="b-l-2">${delito.delito}</div>`);
                  });
                }

                fechaCreacion='';
                if(fecha_creacion!=null){
                  const fCrea=fecha_creacion.split(' ')[0].split('-');
                  fechaCreacion=fCrea[2]+'-'+fCrea[1]+'-'+fCrea[0];
                }
                
                const tr=`<tr>
                            <td class="acciones">
                              <i class="icon ion-folder" data-toggle="tooltip-primary" data-placement="top" title="Administrar Carpeta" onclick="abrirModalAdministracion(${id_carpeta_judicial})"></i>
                              <!-- <i class="icon ion-person-stalker" data-toggle="tooltip-primary" data-placement="top" title="Sujetos Procesales" onclick="verPersonas(${id_carpeta_judicial})"></i> -->
                              <i class="icon ion-ios-information" title="Remitir Carpeta Judicial" style="cursor: pointer" onclick="nuevaRemision('${id_carpeta_judicial}')" id="reenvioCarpeta"></i> 
                            </td>
                            <td class="carpeta tx-uppercase">${nombre_tipo_carpeta==null?'':nombre_tipo_carpeta}</td>
                            <td class="folio">${folio_carpeta==null?'':folio_carpeta}</td>
                            <td class="carpeta_inv">${carpeta_investigacion==null?'':carpeta_investigacion}</td>
                            <td class="fecha">${fechaCreacion}</td>
                            <td class="situacion tx-uppercase">${situacion_carpeta==null?'':situacion_carpeta}</td>
                            <td class="tipo_solicitud">${tipo_solicitud_==null?'':tipo_solicitud_}</td>
                            <td class="involucrados d-block"><span>${lIimputados}</span><span>${lVictimas}</span></td>
                            <td class="delitos">${lDelitos}</td>
                          <tr>`;
                $('#bodyCarpetas').append(tr);
              });

              const anterior=pagina==1?1:pagina-1,
                    totalPaginas=response.response_pag.paginas_totales,
                    siguiente=pagina+1>=totalPaginas?totalPaginas:pagina+1;
              
              $('.anterior').attr('onclick',`buscar(${anterior})`);
              $('.pagina').html(pagina);
              $('.total-paginas').html(totalPaginas);
              $('.siguiente').attr('onclick',`buscar(${siguiente})`);
              $('.ultima').attr('onclick',`buscar(${totalPaginas})`);

            }else{
              const tr=`<tr>
                            <td class="unidad tx-center tx-danger" colspan="8">Sin Datos Relacionados</td>
                            <td class="d-none"></td>
                            <td class="d-none"></td>
                            <td class="d-none"></td>
                            <td class="d-none"></td>
                            <td class="d-none"></td>
                            <td class="d-none"></td>
                            <td class="d-none"></td>
                          <tr>`;
                $('#bodyCarpetas').append(tr);

                $('.anterior').attr('onclick',`buscar(1)`);
                $('.pagina').html('1');
                $('.total-paginas').html('1');
                $('.siguiente').attr('onclick',`buscar(1)`);
                $('.ultima').attr('onclick',`buscar(1)`);

            }
            
          }
        });
      }

      function abrirModalAdministracion( id_carpeta_judicial ){
        carpetaActiva = null;
        carpetaActiva = arrCarpetasJudiciales[id_carpeta_judicial];
        let titulo = 'CARPETA JUDICIAL : '+arrCarpetasJudiciales[id_carpeta_judicial].folio_carpeta;
        $("#lbl-titulo-modal-administracion").text( titulo );
        $("#id_carpeta_judicial").val( id_carpeta_judicial );
        $("#id_solicitud").val( arrCarpetasJudiciales[id_carpeta_judicial].id_solicitud );
        $("#tipo_solicitud").val( arrCarpetasJudiciales[id_carpeta_judicial].tipo_solicitud_ );
        $("#modalAdministracion").modal('show');
        pintarAudiencias();
        pintarDocumentosAsociados();
        pintarPersonas();
        pintarDelitosSinRelacionar();
      }

      function loading(accion){
        if(accion){
          $('#modal_loading').modal('show');
        }else{
          setTimeout(function(){ $('#modal_loading').modal('hide'); }, 500);
        }
      }

      $(".cerrar-modal").click(function(){
        let modalOpen = $(this).attr('data-modal');
        let modalClose = $(this).attr('data-thismodal');
        //console.log(modalOpen,modalClose);
        $("#"+modalClose).modal('hide');
        if( modalOpen.length ) $("#"+modalOpen).modal('show');
      });

      function modal_error(mensaje,modalAnterior=null){
        $('#messageError').html(`${mensaje}`);
        $('#btnCerrarError').attr('data-modal',modalAnterior!=null?modalAnterior:'');
        if( modalAnterior!=null ) $('#'+modalAnterior).modal('hide');
        $('#modalError').modal('show');
      }

      function modal_success(mensaje,modalAnterior=null){
        $('#modal-success-titulo').html(`${mensaje}`);
        $('#btnCerrarSuccess').attr('data-modal',modalAnterior!=null?modalAnterior:'');
        if( modalAnterior!=null ) $('#'+modalAnterior).modal('hide');
        $('#modalSuccess').modal('show');
      }

      function modal_confirm(title,body,fn=null,modalAnterior=null){

        if(body=='borrar_documento'){
          body = `
            <div class="row">
              <div class="col-lg-12">
                <div class="form-group">
                  <label class="form-control-label">Ingrese los motivos por los que desea remover este documento:</label>
                  <textarea class="form-control" name="motivo_remover_documento" id="motivoRemoverDocumento" rows="4"></textarea>
                </div>
              </div>
            </div>
          `;
        }

        $("#tituloModalConfirm").html(''); 
        $("#bodyModalConfirm div").remove();
        $("#btnAceptarModalConfirm").removeAttr( "onClick" );

        $("#tituloModalConfirm").html(title);       
        $("#bodyModalConfirm").append(body);
        if( fn!=null ) $("#btnAceptarModalConfirm").attr('onClick',fn);
      
        if( modalAnterior ) $('#'+modalAnterior).modal('hide');
        
        $('#btnCancelarModalConfirm').attr('data-modal',modalAnterior!=null?modalAnterior:'');
        $("#modalConfirm").modal('show');       
      }

      function modal_historial(title,body,modalAnterior=null){
        $("#tituloModalHistory").html(''); 
        $("#bodyModalHistory div").remove();

        $("#tituloModalHistory").html(title);       
        $("#bodyModalHistory").append(body);

        if( modalAnterior ) $('#'+modalAnterior).modal('hide');
        $('#btnCerrarModalHistory').attr('data-modal',modalAnterior!=null?modalAnterior:'');
        $("#modalHistory").modal('show');       
      }

      function get_unique_id(){
        var date = new Date();
        return date.getHours()+''+date.getMinutes()+''+date.getSeconds()+''+date.getMilliseconds();;
      }

      function motivoIncompretencia(){
        
        $('#motivoIncompetenciaOtro').val('').attr('readonly', true);
        $(".materia_destino").removeAttr('readonly').parent().parent().parent().find('.tx-danger').removeClass('d-none');
        $('#tipoUnidadDestino').attr('readonly',true).val('').select2({minimumResultsForSearch: Infinity}).parent().find('.tx-danger');
        $('#edificioReceptor').val('').attr('disabled',true).select2({minimumResultsForSearch: Infinity}).parent().find('.tx-danger').addClass('d-none');
        $("input[name=materia_destino]").prop("checked", false).removeAttr('disabled');


        switch($('#motivoIncompetencia').val()){
          case "otra_materia":
            $('#edificioReceptor').val('4').select2({minimumResultsForSearch: Infinity}).attr('disabled', true);
            break;
          case "vinculacion_proceso":
            $('#tipoUnidadDestino').removeAttr('disabled').parent().find('.tx-danger');
            $("input[name=materia_destino][value='adultos']").prop("checked", true);
            $("input[name=materia_destino][value='adolescentes']").attr('disabled', true);
            break;
          case "violencia_genero":
            $("input[name=materia_destino][value='adultos']").prop("checked", true);
            $("input[name=materia_destino][value='adolescentes']").attr('disabled', true);
            $(".materia_destino").attr('disabled', true).parent().parent().parent().find('.tx-danger').addClass('d-none');
            $('#edificioReceptor').val('').attr('disabled',true).trigger('change').parent().find('.tx-danger').addClass('d-none');
            $('#tipoUnidadDestino').val('').attr('disabled',true).trigger('change').parent().find('.tx-danger').addClass('d-none');
            break;
          case "mandato_zona":
            $(".materia_destino").attr('disabled', true).parent().parent().parent().find('.tx-danger').addClass('d-none');
            $('#tipoUnidadDestino').removeAttr('disabled').parent().find('.tx-danger');
            $('#edificioReceptor').val('').attr('disabled',true).trigger('change').parent().find('.tx-danger').addClass('d-none');
            $("input[name=materia_destino][value='adultos']").prop("checked", true);
            $("input[name=materia_destino][value='adolescentes']").attr('disabled', true);
            break;
          case "otro": 
            $('#motivoIncompetenciaOtro').removeAttr('readonly');
            $("input[name=materia_destino][value='adultos']").prop("checked", true);
            $("input[name=materia_destino][value='adolescentes']").attr('disabled', true);
            break;
          default:
            alert("Opción inválida");
        }
        
      }
      
      //REMISION DE CARPETA
      function abrirModalRemision(carpeta_jud){

        const {id_unidad,folio_carpeta,carpeta_investigacion,id_carpeta_judicial}=arrCarpetasJudiciales[carpeta_jud];
        unidad_carpeta=id_unidad;
        carpeta_seleccionada=id_carpeta_judicial;
        delitos=[];
                

        $("#formularioRemision").html('');
        $("#labelTipoRemision").html('');
        $("#tipoRemision").val('').select2({minimumResultsForSearch: Infinity});

        let titulo = 'REMITIR LA CARPETA JUDICIAL : '+arrCarpetasJudiciales[id_carpeta_judicial].folio_carpeta;
        $("#lbl-titulo-modal-remision").text( titulo );

        $("#modalRemision").modal('show');
      } //modal remision fin

      //TIPO PROMOCION
      $("#tipoRemisionX").change(async function(){

        $("#formularioRemision").html("");
        $('#imputados').html('').append('<option selected disabled value="">Seleccione una opción</option>');
        let imputadosRemitidos='';

        const {id_unidad,folio_carpeta,carpeta_investigacion,id_carpeta_judicial}=arrCarpetasJudiciales[carpeta_seleccionada];

        if(arrCarpetasJudiciales[carpeta_seleccionada].imputados){
              
          folio_carpeta_seleccionada=arrCarpetasJudiciales[carpeta_seleccionada].folio_carpeta;
          
          $(arrCarpetasJudiciales[carpeta_seleccionada].imputados).each((index, imputado)=>{

            const {nombre,razon_social,tipo,id_persona}=imputado;
            
            $('#imputados').append(`<option value="${id_persona}" data-tipo="${tipo}">${nombre==null?'':nombre}${razon_social==null?'':razon_social}</option>`);

            imputadosRemitidos = imputadosRemitidos.concat(` 
              <div class="col-md-4">
                <label class="ckbox">
                  <input type="checkbox" value="${id_persona}" data-tipo="${tipo}" name="imputados_sel"><span>${nombre==null?'':nombre}${razon_social==null?'':razon_social}</span>
                </label>
              </div>
            `);
          });
        }

        if($("#tipoRemision").val() == "incompetencia") {
  
        }else if ($("#tipoRemision").val() == "tribunal_enjuiciamiento") {          //ENJUICIAMIENTO
          formularioRemision  = `
            <div class="row mg-b-15">
              <div class="col-lg-4">
                <div class="form-group mg-b-10-force">
                  <label class="form-control-label" style="margin-bottom:29px">Carpeta Judicial a Remitir:</label>
                  <input class="form-control" type="text" name="carpeta_a_remitir" id="carpetaARemitir" value="${folio_carpeta_seleccionada}" placeholder="N/E" autocomplete="off" disabled="">
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-group mg-b-10-force">
                  <label class="form-control-label"  style="margin-bottom:29px">Juez que determino la vinculacion:</label>
                  <input class="form-control" type="text" name="juez_vinculacion" id="juezVinculacion" value="" placeholder="N/E" autocomplete="off" disabled="">
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label">Fecha de la audiencia en la cual se determina la vinculación a Juicio Oral:</label>
                  <select class="form-control select2" id="fechaAudiencia" name="fecha_audiencia" autocomplete="off">
                    <option selected value="">Seleccione una Opción</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row mg-b-15">
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label">¿El imputado se encuentra interno en algún reclusorio?: <span class="tx-danger">*</span></label>
                  <div class="d-inline-block mg-l-10" id="privadoLibertadDiv">
                    <label class="rdiobox d-inline-block mg-l-5" style="margin: 0 20px;">
                      <input name="privado_libertad" type="radio" onclick="internoRecl(this);" value="si">
                      <span class="pd-l-0">Si</span>
                    </label>
                    <label class="rdiobox d-inline-block mg-l-5" style="margin: 0 20px;">
                      <input name="privado_libertad" type="radio" onclick="internoRecl(this);"  value="no">
                      <span class="pd-l-0">No</span>
                    </label>
                  </div>
                </div>
              </div>
              <div class="col-lg-4" id="reclusorioInternamientoDiv">
                <div class="form-group">
                  <label class="form-control-label" style="margin-bottom:20px;">Reclusorio de internamiento:</label>
                  <select class="form-control select2" id="reclusorioInternamiento" name="lugar_internamiento" autocomplete="off" disabled>
                    <option selected value="">Seleccione una Opción</option>
                    <option value="00020008">Centro Femenil de Reinserción Social (Santa Martha)</option>
                    <option value="00020004">Centro Varonil de Rehabilitación Psicosocial (CEVAREPSI)</option>
                    <option value="00020001">Reclusorio Preventivo Varonil Norte</option>
                    <option value="00020002">Reclusorio Preventivo Varonil Oriente</option>
                    <option value="00020003">Reclusorio Preventivo Varonil Sur</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row mg-b-15">
              <div class="col-lg-12">
                <div class="form-group">
                  <label class="form-control-label">Comentarios Adicionales</label>
                  <th colspan="100%">
                    <textarea id="comentariosAdicionales" rows="2"  ></textarea>
                  </th>
                </div>
              </div>
            </div>
            <div class="custom-input-file mg-t-30">
              <input type="file" id="archivoPDF" class="input-file" value="" name="archivoPDF" accept="application/pdf">
              <h5 class="px-3 py-3">Arrastre hasta aquí su documento pdf o de clic para adjuntarlo</h5>
            </div>
            <div class="row mg-b-15">
              <div id="divDocumento" style="width:100%" class="col-12">
                <object data=""  id="documentoPDF" width="100%" height="350px" class=" mg-t-25"></object>
                <input type="hidden" id="bDoc" name="bDoc">
              </div>
            </div>
          `;
          $("#labelTipoRemision").html(" ENVIO DE CARPETA JUDICIAL A TRIBUNAL DE ENJUICIAMIENTO");

          
          $("#formularioRemision").html(formularioRemision);
          // $("#formularioRemision").css("display", "");

          $('#reclusorioInternamiento').select2({minimumResultsForSearch: ''});

        }else if ($("#tipoRemision").val() == "preventiva") {    //PRISION PREVENTIVA
          let formularioRemision="";
          formularioRemision  = `
            <div class="col-lg-2">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Carpeta Judicial a Remitir:</label>
                <input class="form-control" type="text" name="carpeta_a_remitir" id="carpetaARemitir" value="`+arrCarpetasJudiciales[id_carpeta_judicial].folio_carpeta+`" placeholder="N/E" autocomplete="off" disabled="">
              </div>
            </div>
            <div class="col-lg-3">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Unidad de gestión origen:</label>
                <input class="form-control" type="text" name="unidad_origen" id="unidadOrigen" value="" placeholder="N/E" autocomplete="off" disabled="">
              </div>
            </div>
            <div class="col-lg-3">
              <div class="form-group">
                <label class="form-control-label">Audiencia en la que se impuso prisión preventiva:</label>
                <select class="form-control select2" id="fechaAudiencia" name="fecha_audiencia" autocomplete="off">
                  <option selected value="">Seleccione una Opción</option>
                </select>
              </div>
            </div>
            <div class="col-lg-3">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Juez que impuso la prision preventiva:</label>
                <input class="form-control" type="text" name="juez_preventiva" id="juezPreventiva" value="" placeholder="N/E" autocomplete="off" disabled="">
              </div>
            </div>
            <div class="col-lg-2">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Carpeta de prisión preventiva asignada:</label>
                <input class="form-control" type="text" name="carpeta_asignada" id="carpetaAsignada" value="" placeholder="N/E" autocomplete="off" disabled="">
              </div>
            </div>
          `;


          $("#labelTipoRemision").html(" ENVIO DE CARPETA JUDICIAL POR PRISION PREVENTIVA");


          $("#formularioRemision").html(formularioRemision);
          // $("#formularioRemision").css("display", "");
          
          /*   $("#carpetaJudicialReferida").val('');

            $("#divReferida").css("display", "none");
            $("#divAsociada").css("display", "block"); */
        }

      });

      function indicaJuez(){
        const juez = $('#fechaAudienciaSentencia option:selected').attr('data-juez');
        $('#juezDictoSent').val(juez);
        $('#inicial .square-8 ').remove();
        $('#inicial').append('<span class="square-8 bg-danger mg-r-5 mg-l-5 rounded-circle"></span>');
      }

     
      function obtenerFechasAudSent(carpeta_judicial,fecha_selec){
        return new Promise(resolve => {
          $.ajax({
            method:'POST',
            url:'/public/obtener_fechas_aud_sent',
            data:{carpeta_judicial},
            success:function(response){
              let options='';
              if( response.status == 100 ){
                $(response.response).each(function(index, audiencia){
                  const exp=audiencia.fecha_audiencia.split("-"),
                        fecha=exp[2]+'-'+exp[1]+'-'+exp[0];
                  if( fecha_selec === audiencia.fecha_audiencia){
                    const option = `<option value="${audiencia.id_audiencia}" data-juez="${audiencia.juez.nombre_usuario}" data-cvj="${audiencia.id_juez}" data-fecha="${audiencia.fecha_audiencia} ${audiencia.hora_inicio_audiencia}" selected>${fecha}</option>`;
                    options=options.concat(option);
                  }else{
                    const option = `<option value="${audiencia.id_audiencia}" data-juez="${audiencia.juez.nombre_usuario}" data-cvj="${audiencia.id_juez}" data-fecha="${audiencia.fecha_audiencia} ${audiencia.hora_inicio_audiencia}">${fecha}</option>`;
                    options=options.concat(option);
                  }
                });
              }
              resolve(options)
            }
          });
        }); 
      }

      function consultaRemisiones(carpeta_judicial){
        return new Promise(resolve => {
          $.ajax({
            method:'POST',
            url:'/public/consultar_remisiones_carpeta',
            data:{carpeta_judicial},
            success:function(response){
              resolve(response);
            }
          });
        }); 
      }

      function validaRemInc(){
        $('.error').removeClass('error');

        let strImputados='';

        if($('#motivoIncompetencia').val()=='' || $('#motivoIncompetencia').val()==null){
          error('Datos Incompletos', 'No ha seleccionado el motivo de incompetencia', 'modalRemision');
          $('span[aria-labelledby="select2-motivoIncompetencia-container"]').addClass('error');
          return 0;
        }

        if($('#motivoIncompetencia').val()=='otro'){
          if(expVacio.test($('#motivoIncompetenciaOtro').val())){
            error('Datos Incompletos', 'Indique el motivo de la incompetencia (otro)', 'modalRemision');
            $('#motivoIncompetenciaOtro').addClass('error');
            return 0;
          }
        }

        if($('#motivoIncompetencia').val() == 'otra_materia' || $('#motivoIncompetencia').val() == 'vinculacion_proceso' || $('#motivoIncompetencia').val() == 'otro'){
          if($('input:radio[name=materia_destino]:checked').val() == undefined){
            error('Datos Incompletos', 'No ha seleccionado la materia destino', 'modalRemision');
            $('#divMateriaDestino').addClass('error');
            return 0;
          }
        }

        if($('#fiscalia').val()=='' || $('#fiscalia').val()==null){
          error('Datos Incompletos', 'No ha seleccionado la fiscalia', 'modalRemision');
          $('span[aria-labelledby="select2-fiscalia-container"]').addClass('error');
          return 0;
        }

        // if($('#tipoUnidadDestino').val()=='' || $('#tipoUnidadDestino').val() == null){
        //   error('Datos Incompletos', 'No ha seleccionado el tipo de unidad destino', 'modalRemision');
        //   $('span[aria-labelledby="select2-tipoUnidadDestino-container"]').addClass('error');
        //   return 0;
        // }

        if($('input:radio[name=privado_libertad]:checked').val() == undefined){
          error('Datos Incompletos', 'No ha indicado si el imputado se encuentra privado de su libertad', 'modalRemision'); 
          $('#privadoLibertadDiv').addClass('error');
          return 0;
        }

        if($('input:radio[name=privado_libertad]:checked').val() == 'si'){
          if($('#lugarInternamiento').val()=='' || $('#lugarInternamiento').val() == null){
            error('Datos Incompletos', 'No ha seleccionado el lugar de internamiento', 'modalRemision');
            $('span[aria-labelledby="select2-lugarInternamiento-container"]').addClass('error');
            return 0;
          }
        }

        if($('#motivoIncompetencia').val() == 'mandato_zona'){
          if($('#edificioReceptor').val()=='' || $('#edificioReceptor').val()==null){
            error('Datos Incompletos', 'No ha seleccionado el edificio receptor', 'modalRemision');
            $('span[aria-labelledby="select2-edificioReceptor-container"]').addClass('error');
            return 0;
          }
        }

        if(!($('input[name=imputados_sel]:checked').length)){
          error('Datos Incompletos', 'No ha seleccionado a ningún imputado', 'modalRemision');
          return 0;
        }else{
          let i=0;
          $('input[name=imputados_sel]:checked').each(function(){
            if(i==0){
              strImputados=strImputados.concat($(this).val());
            }else{
              strImputados=strImputados.concat(','+$(this).val());
            }
            i++;
          });
        }

        if($('#bDoc').val()=='' || $('#bDoc').val()==null){
          error('Datos Incompletos', 'No ha agregado su documento PDF', 'modalRemision');
          return 0;
        }
        
        
        form=new FormData($("#formRemision")[0]);
        tamanio_archivo=$('#archivoPDF')[0].files[0].size;

        if($('#motivoIncompetencia').val() != 'mandato_zona'){
          form.append('edificio_receptor', $('#edificioReceptor').val());
        }
        
        form.append('carpeta', carpeta_seleccionada);
        form.append('tamanio_archivo', tamanio_archivo);
        form.append('unidades', strUnidadesDestino);
        form.append('personas_remitidas', strImputados);
        
        form.append('unidad_carpeta',unidad_carpeta);

        return 100;
        
      }

      function validaRemTriEnj(){

        $('.error').removeClass('error');

        if($('input:radio[name=privado_libertad]:checked').val() == undefined){
          error('Datos Incompletos', 'No ha indicado si el imputado se encuentra privado de su libertad', 'modalRemision'); 
          $('#privadoLibertadDiv').addClass('error');
          return 0;
        }

        if($('input:radio[name=privado_libertad]:checked').val() == 'si'){
          if($('#reclusorioInternamiento').val()=='' || $('#reclusorioInternamiento').val() == null){
            error('Datos Incompletos', 'No ha seleccionado el reclusorio de internamiento', 'modalRemision');
            $('span[aria-labelledby="select2-reclusorioInternamiento-container"]').addClass('error');
            return 0;
          }
        }

        if($('#bDoc').val()=='' || $('#bDoc').val()==null){
          error('Datos Incompletos', 'No ha agregado su documento PDF', 'modalRemision');
          return 0;
        }

        form=new FormData($("#formRemision")[0]);
        tamanio_archivo=$('#archivoPDF')[0].files[0].size;

        form.append('carpeta', carpeta_seleccionada);
        form.append('tamanio_archivo', tamanio_archivo);
        form.append('unidad_carpeta',unidad_carpeta);

        return 100;
      }

      function obtenerUnidadDestino(){
        $('#edificioReceptor').val('4').attr('disabled', true).trigger('change');
        
        if( $('#motivoIncompetencia').val() != 'mandato_zona' ){
          switch ($('#tipoUnidadDestino').val()){
            case 'u12':
            case 'querella':
              $('#edificioReceptor').val('5').trigger('change');
              break;
            case 'oficioso':
              $('#edificioReceptor').val('8').trigger('change');
              break;
            case 'mujeres':
              $('#edificioReceptor').val('10').trigger('change');
              break;
            default:
            $('#edificioReceptor').val('').trigger('change');
          }
        }

        $.ajax({
          method:'POST',
          url:'/public/obtener_unidad_destino_remision',
          data:{
            tipo_unidad:$('#tipoUnidadDestino').val(),
            fiscalia:$('#fiscalia').val(),
          },
          success:function(response){
            let strUnidades='';
            if(response.status==100){
              strUnidadesDestino=response.response.unidades;
              $(response.response.unidades_data).each(function(index, unidad){
                const {nombre_unidad} = unidad;
                
                if(index > 0){
                  strUnidades=strUnidades.concat(', '+nombre_unidad);
                }else{
                  strUnidades=strUnidades.concat(nombre_unidad);
                }

              });
            }
            $('#select_unidad').val(strUnidades);
          }
        });
      }

      async function leeDocumento (input, tipo_archivo='', documento) {
        let b_subiendo = 0;
        const file =  $('#'+input.id).val(),
              ext = file.substring(file.lastIndexOf(".")),
              tipos_archivo = tipo_archivo.split(',');
        
        if( ext!='' ){

          if( tipo_archivo != '' && !tipos_archivo.includes( ext ) ){
            
            error( 'Tipo de archivo inválido', 'Solo puede adjutar archivos '+ tipo_archivo ,'modalRemision');
            $('#'+input.id).val('');

          }else{
            
            if( input.files && input.files[0] ) {
              
              
              if ( documento == 'TE' || documento == 'incompetencia' ) {
                
                const reader = new FileReader();
                reader.readAsDataURL(input.files[0]);
                reader.onload = e => {
                    $('#documentoPDF').attr('data', e.target.result); 
                    $('#documentoPDF').removeClass('d-none');
                    $('#bDoc').val(e.target.result.split('base64,')[1]);
                }
                
              }else if( documento == 'copia_certificada_sentencia' || documento == 'copia_certificada_auto' || documento == 'acta_minima'  ) {
                
                b_cargando ++;
                $('#div_'+documento).html(doc_loadind);
                $('#'+input.id).parent().addClass('d-none');
                
                const dataDoc = await datosDoc(input, ext, documento);
                if( informacion_complementaria.documentos_remision_ue[documento] ){
                  informacion_complementaria.documentos_remision_ue[documento].url = dataDoc.url;
                  informacion_complementaria.documentos_remision_ue[documento].nombre_archivo = dataDoc.nombre_archivo;
                  informacion_complementaria.documentos_remision_ue[documento].extension = dataDoc.extension;
                  informacion_complementaria.documentos_remision_ue[documento].estatus = dataDoc.estatus;   
                }else{
                  informacion_complementaria.documentos_remision_ue[documento] = dataDoc;
                }

                
                 console.log(informacion_complementaria.documentos_remision_ue);
                b_cargando --;
                $('#div_'+documento).html(`
                  <div style="padding-top: 13px;">
                    <a href="javascript:void(0)" ondblclick="abrirDocumento('${documento}')" class="d-none d-md-inline-flex">
                      <i class="fa ${dataDoc.icon}" aria-hidden="true" style="font-size:3rem;position: relative;"></i>
                    </a>
                    <a href="${dataDoc.url}" class="d-inline-flex d-md-none">
                      <i class="fa ${dataDoc.icon}" aria-hidden="true" style="font-size:3rem;position: relative;"></i>
                    </a>
                    <a href="javascript:void(0)" onclick="eliminarDocumento('${documento}')" class="mg-l-auto" style="position: absolute;">
                      <i class="fa fa-times-circle tx-danger btn-cancel" aria-hidden="true" style="font-size:1rem;padding-top:4px;position: relative;top: -13px;"></i>
                    </a>
                  </div>`);
                
              }else if( documento == 'adjunto' ){
                
                const dataDoc = await datosDoc(input, ext, documento);
                dataDoc.estatus = 1;
                dataDoc.tipo_documento = $('#tipo_documento_adjunto').val();
                adjuntos_remision.push(dataDoc);
                showAdjuntos()
              }
            }
          }
        }
        
      }

      function eliminarDocumento(doc, index=''){

          $('#div_'+doc).html('');
          $('#'+doc).parent().removeClass('d-none');
          documentos_remision_ue[doc] = '';
        
      }

      function datosDoc( input = '', ext = '', documento = '' ){
        return new Promise( resolve => {
          let icon;
          switch (ext){
            case '.pdf':
             icon = "fa-file-pdf-o";
              break;
            case '.jpg':
            case '.png':
            case '.JPEG ':
             icon = "fa-file-image-o";
              break;
            case '.doc':
            case '.docx': 
              icon = "fa-file-word-o";
              break;
            case '.txt': 
              icon = "fa-file-text";
              break;
            default:
              icon='fa-question';
          }

          // const {data, nombre_archivo, id} = documentos_remision_ue[documento];
          const nombre_archivo = normalize((input.files[0].name).replace(ext,'')) + ext,
                tamanio_archivo = input.files[0].size;
          
          form = new FormData($("#formRemision")[0]);
          form.append('origen','b64'),
          form.append('tipo_documento', documento);
          form.append('ext', ext);
          form.append('nombre_archivo', nombre_archivo);
          form.append('tamanio', tamanio_archivo);

          $.ajax({
            method: 'POST',
            url: '/public/vista_previa',
            data:form,
            processData: false,
            contentType: false,
            success: function(url){
              const dataDoc = {
                      id_documento : 0,
                      extension_archivo: ext,
                      nombre_archivo,
                      tamanio_archivo,
                      icon,
                      url,
                      documento,
                      estatus: 0
                    };
              resolve(dataDoc);
            }
          });
          
        });
      }

      function error(title='', message='', modal=''){
        $('#titleError').html(title);
        $('#messageError').html(message);
        $('#modalError').modal('show');
        if(modal!=''){
          $('#'+modal).modal('hide');
          $('#btnCerrarError').attr('onclick', `abreModal('${modal}',355)`);
        }
      }

      function abreModal(modal, time=0){
        setTimeout(function(){
          $('#'+modal).modal('show');
        },time);
      }

      const doc_loadind = `
        
          <div class="sk-circle">
            <div class="sk-circle1 sk-child"></div>
            <div class="sk-circle2 sk-child"></div>
            <div class="sk-circle3 sk-child"></div>
            <div class="sk-circle4 sk-child"></div>
            <div class="sk-circle5 sk-child"></div>
            <div class="sk-circle6 sk-child"></div>
            <div class="sk-circle7 sk-child"></div>
            <div class="sk-circle8 sk-child"></div>
            <div class="sk-circle9 sk-child"></div>
            <div class="sk-circle10 sk-child"></div>
            <div class="sk-circle11 sk-child"></div>
            <div class="sk-circle12 sk-child"></div>
          </div>
        
      `;
    </script>                                                 
  @endsection
  @section('seccion-modales')
    <!-- M O D A L    A D M  I N  I S T  R A  C I O N -->
    <div id="modalAdministracion" class="modal fade" style="overflow-y: scroll;">
      <div class="modal-dialog modal-lg xl mg-b-100 modalAdministracion-body" role="document" style="width: -webkit-fill-available;">
        <div class="modal-content tx-size-sm modalAdministracion-content">
          <div class="modal-header pd-x-20">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"><span id="lbl-titulo-modal-administracion"></span></h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div> <!-- HEADER -->
          
          <div class="modal-body pd-20">
            <input type="hidden" name="id_carpeta_judicial" id="id_carpeta_judicial" value="">  
            <input type="hidden" name="id_solicitud" id="id_solicitud" value="">  
            <input type="hidden" name="tipo_solicitud" id="tipo_solicitud" value=""> 
            {{--@include('carpetas.tabs.vida-carpeta')--}}
            <br><br>
            <nav>
              <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="nav-documentos-asociados-tab" data-toggle="tab" href="#nav-documentos-asociados" role="tab" aria-controls="nav-documentos-asociados" aria-selected="true">Documentos Asociados</a>
                <a class="nav-item nav-link" id="nav-audiencias-tab" data-toggle="tab" href="#nav-audiencias" role="tab" aria-controls="nav-audiencias" aria-selected="false">Audiencias</a>
                <a class="nav-item nav-link" id="nav-partes-procesales-tab" data-toggle="tab" href="#nav-partes-procesales" role="tab" aria-controls="nav-partes-procesales" aria-selected="false">Partes Procesales</a>
                <a class="nav-item nav-link" id="nav-delitos-sin-relacionar-tab" data-toggle="tab" href="#nav-delitos-sin-relacionar" role="tab" aria-controls="nav-delitos-sin-relacionar" aria-selected="false">Delitos Sin Relacionar</a>
                <a class="nav-item nav-link" id="nav-documentos-generados-tab" data-toggle="tab" href="#nav-documentos-generados" role="tab" aria-controls="nav-documentos-generados" aria-selected="false">Documentos Generados</a>
              </div>
            </nav>   
            <div class="tab-content" id="nav-tabContent">
              <div class="tab-pane fade show active" id="nav-documentos-asociados" role="tabpanel" aria-labelledby="nav-documentos-asociados">
                {{--@include('carpetas.tabs.documentos-asociados')--}}
              </div><!-- tab-docuemntos-asociados -->
              <div class="tab-pane fade" id="nav-audiencias" role="tabpanel" aria-labelledby="nav-audiencias">
                {{--@include('carpetas.tabs.audiencias')--}}
              </div><!-- tab-audiencias -->
              <div class="tab-pane fade" id="nav-partes-procesales" role="tabpanel" aria-labelledby="nav-partes-procesales">
                {{--@include('carpetas.tabs.partes-procesales')--}}
              </div><!-- tab-partes-procesales -->
              <div class="tab-pane fade" id="nav-delitos-sin-relacionar" role="tabpanel" aria-labelledby="nav-delitos-sin-relacionar">
                {{--@include('carpetas.tabs.delitos-sin-relacionar')--}}
              </div><!-- tab-delitos-sin-relacionar -->
              <div class="tab-pane fade" id="nav-documentos-generados" role="tabpanel" aria-labelledby="nav-documentos-generados">
                {{--@include('carpetas.tabs.documentos-generados')--}}
              </div><!-- tab-documentos-generados -->
            </div><!-- div-tabs-content -->   
          </div><!-- modal-body -->
          <div class="modal-footer d-flex">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          </div>
        </div> 
      </div><!-- modal-dialog -->
    </div><!-- modal -->

    <!-- M O D A L    U S O     G E N E R A L -->

    <div id="modalError" class="modal fade" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog" role="document">
        <div class="modal-content tx-size-sm">
          <div class="modal-body tx-center pd-y-20 pd-x-20">
            <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button> -->
            <i class="icon icon ion-ios-close-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
            <h4 class="tx-danger mg-b-20" id="titleError"></h4>
            <p class="mg-b-20 mg-x-20" id="messageError"></p>
            <button type="button" class="btn btn-danger pd-x-25 cerrar-modal" data-modal="" data-thismodal="modalError" id="btnCerrarError">Aceptar</button>
          </div><!-- modal-body -->
        </div><!-- modal-content -->
      </div><!-- modal-dialog -->
    </div><!-- modal -->

    <div id="modalSuccess" class="modal fade"  data-backdrop="static" data-keyboard="false" >
      <div class="modal-dialog" role="document">
        <div class="modal-content tx-size-sm">
          <div class="modal-body tx-center pd-y-20 pd-x-20">
            <i class="icon ion-ios-checkmark-outline tx-100 tx-success lh-1 mg-t-20 d-inline-block"></i>
            <h6 class="tx-success tx-semibold mg-b-20">Hecho!</h6>
            <p style="padding-left: 5vh; padding-right: 5vh;" id="modal-success-titulo"></p>
          </div><!-- modal-body -->
          <div class="modal-footer d-flex">
            <button type="button" class="btn btn-primary pd-x-25 mg-l-auto cerrar-modal" data-modal="" data-thismodal="modalSuccess" id="btnCerrarSuccess">Aceptar</button>
          </div>
        </div><!-- modal-content -->
      </div><!-- modal-dialog -->
    </div><!-- modal -->
    
    <div id="modalConfirm" class="modal fade"  data-backdrop="static" data-keyboard="false" >
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content tx-size-sm">
          <div class="modal-header pd-x-20">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold" id="tituloModalConfirm"></h6>
          </div>
          <div class="modal-body tx-center pd-y-20 pd-x-20" id="bodyModalConfirm">
            
          </div><!-- modal-body -->
          <div class="modal-footer d-flex">
            <button type="button" class="btn btn-secondary pd-x-25 mg-l-10 cerrar-modal" data-modal="modalAdministracion" data-thismodal="modalConfirm" id="btnCancelarModalConfirm">Cancelar</button>
            <button type="button" class="btn btn-primary pd-x-25 mg-l-10 cerrar-modal" data-modal="modalAdministracion" data-thismodal="modalConfirm" id="btnAceptarModalConfirm">Aceptar</button>
          </div>
        </div><!-- modal-content -->
      </div><!-- modal-dialog -->
    </div><!-- modal -->

    <div id="modalHistory" class="modal fade"  data-backdrop="static" data-keyboard="false" >
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content tx-size-sm">
          <div class="modal-header pd-x-20">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold" id="tituloModalHistory"></h6>
          </div>
          <div class="modal-body tx-center pd-y-20 pd-x-20" id="bodyModalHistory">
          </div><!-- modal-body -->
          <div class="modal-footer d-flex">
            <button type="button" class="btn btn-secondary pd-x-25 mg-l-10 cerrar-modal" data-modal="modalAdministracion" data-thismodal="modalHistory" id="btnCerrarModalHistory">Cerrar</button>
          </div>
        </div><!-- modal-content -->
      </div><!-- modal-dialog -->
    </div><!-- modal -->

    <div id="modalRemision" class="modal fade" data-backdrop="static" data-keyboard="false" style="overflow-y: scroll;"> 
      <div class="modal-dialog modal-lg xl mg-b-100 " role="document">
        <div class="modal-content tx-size-sm modalRemision-content">
          <div class="modal-header pd-x-20">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"><span id="lbl-titulo-modal-remision"></span></h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div> <!-- HEADER -->
          <div class="modal-body pd-20">
            <form action="/" onsubmit="return false;" enctype="multipart/form-data" id="formRemision">
              <div class="row mg-b-25 " id="cuerpoRemision1"><!-- datos de solicitud de audiencia -->
                <div class="col-lg-4">
                  <div class="form-group">
                    <label class="form-control-label">Remitir carpeta judicial:</label>
                    <select class="form-control select2" id="tipoRemision" name="tipo_remision" autocomplete="off" onchange="tipo_Remision()">
                      <option selected value="">Seleccione una Opción</option>
                      <option value="incompetencia">Por Incompetencia</option>
                      <option value="tribunal_enjuiciamiento">A Tribunal de Enjuiciamiento</option>
                      <option value="unidad_ejecucion">A Unidad de Ejecución</option>
                      <option value="preventiva">Reportar Unidad de Ejecución Prisión preventiva</option>
                    </select>
                  </div>
                </div>
                <div class="col-lg-8" align="center">
                  <div class="form-group mg-t-30 d-none d-lg-block">
                    <h4 id="labelTipoRemision"></h4>
                  </div>
                </div>
              </div>
              <hr>
              <div  style="background: #f8f9fa; padding: 10px; min-height: 470px; border: 1px solid #EEE; display: grid;" id="formularioRemision" class="mg-b-25"><!-- datos de solicitud de audiencia -->
              </div>
            </form>
          </div><!-- modal-body -->
          <div class="modal-footer">
            <div style="display: contents">
              <button data-dismiss="modal" aria-label="Close" class="btn btn-secondary mg-r-auto">Cerrar</button>
              <button class="btn btn-primary mg-l-auto" onclick="remisionEjecAutorizacion()" id="btnSiguiente">Solicitar Autorización</button>
            </div>
          </div>
        </div> 
      </div><!-- modal-dialog -->
    </div><!-- modal -->
    <!-- M O D A L E S   P E R S O N A S    P R O C E S A L E S  N O   S E     U S A N  -->
    <div id="modalSentenciado" class="modal fade" data-backdrop="static" data-keyboard="false" style="overflow-y: scroll;">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content tx-size-sm">
          <div class="modal-header pd-x-20">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Datos del sentenciado</h6>
          </div>
          <div class="modal-body pd-20">
            <div class="row mg-b-15">
              <div class="col-12">
                <div class="form-group">
                  <label class="form-control-label">Nombre del sentenciado:<span class="tx-danger">*</span></label>
                  <select class="form-control select2" id="imputados" name="imputados" autocomplete="off">                    
                  </select>
                </div>
              </div>
            </div>
            <div class="row mg-b-15">
              <div class="col-md-5">
                <div class="form-group" id="">
                  <label class="form-control-label">¿El sentenciado se encuentra en libertad?:
                    <span class="tx-danger">*</span></label>
                  <div class="row pd-7">
                    <div class="col-6 col-md-4">
                      <label class="rdiobox d-inline-block mg-l-20">
                        <input name="sentenciado_libertad" type="radio" value="si" class="sentenciado_libertad" onchange="sentenciadoLibertad()">
                        <span class="pd-l-0">Sí</span>
                      </label>
                    </div>
                    <div class=" col-6 col-md-4">
                      <label class="rdiobox d-inline-block mg-l-20">
                        <input name="sentenciado_libertad" type="radio" value="no" class="sentenciado_libertad" onchange="sentenciadoLibertad()">
                        <span class="pd-l-0">No</span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-7">
                <div class="form-group">
                  <label class="form-control-label">Centro de detención: <span class="tx-danger">*</span></label>
                  <select class="form-control select2" id="centroDetencion" name="centro_detencion" autocomplete="off">
                    <option value="" disabled selected>Seleccione una opción</option>
                    <option value="7">Reclusorio Preventivo Varonil Norte</option>
                    <option value="8">Reclusorio Preventivo Varonil Oriente</option>
                    <option value="9">Reclusorio Preventivo Varonil Sur</option>
                    <option value="10">Centro Femenil de Reinserción Social (Santa Martha)</option>
                    <option value="5">Dr. Lavista</option>
                    <option value="4">Sullivan</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row mg-b-30">
              <div class="col-12">
                <div>
                  <div class="d-flex">
                    <label for="table-remi" class="form-control-label">Penas impuestas en la sentencia:</label>
                    <a href="javascript:void(0)" onclick="nuevaPena()" class="mg-l-auto"><i class="fa fa-plus-circle" aria-hidden="true" style="color:#848F33"></i> Agregar pena</a>
                  </div>
                  <table class="table-remi" id="tablePenas">
                    <thead>
                      <tr>
                        <th class="acciones">Acciones</th>
                        <th class="pena">Pena impuesta</th>
                        <th class="delitos">Deltilos</th>
                        <th class="detalles">Detalles adicionales</th>
                        <th class="sustitutivo">Sustitutivo para la pena</th>
                      </tr>
                    </thead>
                    <tbody id="bodyPenas">
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="row mg-b-15">
              <div class="col-12">
                <div class="form-group" id="">
                  <label class="form-control-label">
                    ¿Se concede la SUSPENSIÓN CONDICIONAL DE LA EJECUCIÓN DE LA PENA?:
                    <span class="tx-danger">*</span></label>
                  
                    <label class="rdiobox d-inline-block mg-l-15">
                      <input name="suspension_ejecucion" type="radio" value="si" class="suspension_ejecucion">
                      <span class="pd-l-0">Sí</span>
                    </label>
                    <label class="rdiobox d-inline-block mg-l-15">
                      <input name="suspension_ejecucion" type="radio" value="no" class="suspension_ejecucion">
                      <span class="pd-l-0">No</span>
                    </label>
                </div>
              </div>
            </div>
          </div><!-- modal-body -->
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="agregarSentenciado()">Guardar sentenciado</button>
            <button type="button" class="btn btn-secondary" onclick="abreModal('modalRemision',300)" data-dismiss="modal" aria-label="Close">Cerrar</button>
          </div>
        </div>
      </div><!-- modal-dialog -->
    </div><!-- modal -->

    <div id="modalPenas" class="modal fade" data-backdrop="static" data-keyboard="false" style="overflow-y: scroll;">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content tx-size-sm">
          <div class="modal-header pd-x-20">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Registrar pena</h6>
          </div>
          <div class="modal-body pd-20">
            <div class="card">
              <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                  <li class="nav-item">
                    <a class="nav-link active" href="#datosGenerales" data-toggle="tab" id="navDatosGenerales">Datos generales</a>
                  </li>
                  <li class="nav-item d-none" id="sectionAbonoPrision">
                    <a class="nav-link" href="#abonoPrision" data-toggle="tab">Abono de prisión preventiva</a>
                  </li>
                  <li class="nav-item d-none" id="sectionSustitutivosPena">
                    <a class="nav-link" href="#sutitutivosPena" data-toggle="tab">Sustitutivos de pena</a>
                  </li>
                </ul>
              </div><!-- card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane active" id="datosGenerales">
                    <div class="row mg-b-10">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="form-control-label">Tipo de pena:<span class="tx-danger">*</span></label>
                          <select class="form-control select2" id="tipoPena" name="tipo_pena" autocomplete="off" onchange="obtenerPenas()">  
                            <option value="" disabled selected>Seleccione una opción</option>
                            @foreach ($penas as $pena)
                                <option value="{{$pena['id_tipo_pena']}}">{{$pena['descripcion']}}</option>
                            @endforeach                   
                          </select>
                        </div>
                      </div>
                      <div class="col-md-8">
                        <div class="form-group">
                          <label class="form-control-label">Tipo de pena:<span class="tx-danger">*</span></label>
                          <select class="form-control" id="penaImpuesta" name="pena_impuesta" autocomplete="off" onchange="penaImpuesta()">
                            <option value="">Seleccione una opción</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row mg-b-10 d-none" id="divDecomisos">
                      <div class="col-md-4">
                        <label class="ckbox">
                          <input type="checkbox" class="decomiso" id="decomisoInstrumento"><span>Decomiso de instrumento</span>
                        </label>
                      </div>
                      <div class="col-md-4">
                        <label class="ckbox">
                          <input type="checkbox" class="decomiso" id="decomisoObjetos"><span>Decomiso de objetos</span>
                        </label>
                      </div>
                      <div class="col-md-4">
                        <label class="ckbox">
                          <input type="checkbox" class="decomiso" id="decomisoProductos"><span>Decomiso de productos del delito</span>
                        </label>
                      </div>
                    </div>
                    <div class="row mg-b-10">
                      <div class="col-12">
                        <div class="form-group d-none" id="divDetallePena">
                          <label class="form-control-label">Detalle de la pena:<span class="tx-danger">*</span></label>
                          <select class="form-control" id="detallePena" name="detalle_pena" autocomplete="off">  
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row mg-b-10 d-none" id="divPeriodo">
                      <div class="col-md-2">
                        <div class="form-group">
                          <label class="form-control-label">Años: <span class="tx-danger">*</span></label>
                          <input class="form-control input-number" type="text" name="periodo_anios" id="periodoAnios" autocomplete="off" oninput="calculoAbonoSentencia()" min="0" >
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <label class="form-control-label">Meses: <span class="tx-danger">*</span></label>
                          <input class="form-control input-number" type="text" name="periodo_meses" id="periodoMeses" value=""  placeholder="" autocomplete="off" oninput="calculoAbonoSentencia()" min="0">
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <label class="form-control-label">Días: <span class="tx-danger">*</span></label>
                          <input class="form-control input-number" type="text" name="periodo_dias" id="periododias" value=""  placeholder="" autocomplete="off" oninput="calculoAbonoSentencia()" min="0">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group" id="divCentroDetencionPena">
                          <label class="form-control-label">Centro de detención actual:<span class="tx-danger">*</span></label>
                          <select class="form-control" id="centroDetencionPena" name="centro_detencion_pena" autocomplete="off" >  
                            <option value="" disabled selected>Seleccione una opción</option>
                            @foreach ($centros_detencion as $centro_detencion)
                                <option value="{{$centro_detencion['id_reclusorio']}}">{{$centro_detencion['nombre']}}</option>
                            @endforeach                   
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row mg-b-10">
                      <div class="col-12">
                        <div class="form-group">
                          <label class="form-control-label">Detalles Adicionales:</label>
                          <textarea class="form-control" name="detalles_adicionales" id="detallesAdicionalesPena" rows="4"></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="row mg-b-30">
                      <div class="col-12">
                        <div>
                          <div class="row">
                            <div class="col-6">
                              <label for="table-remi" class="form-control-label">Delitos por los cuales se impone al pena:</label>
                            </div>
                            <div class="col-6 text-right">
                              <a href="javascript:void(0)" onclick="nuevoDelito()" class=""><i class="fa fa-plus-circle" aria-hidden="true" style="color:#848F33"></i> Agregar delito</a>
                            </div>
                          </div>
                          <table class="table-remi">
                            <thead>
                              <tr>
                                <th class="acciones">Acciones</th>
                                <th class="delito">Delitos</th>
                              </tr>
                            </thead>
                            <tbody id="bodyDelitos">
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div><!-- tab-pane -->
                  <div class="tab-pane" id="abonoPrision">
                    <div class="row mg-b-15">
                      <div class="col-12">
                        <a href="javascript:void(0)" onclick="nuevoAbono()"><i class="fa fa-plus-circle" aria-hidden="true" style="color:#848F33"></i> Agregar cómputo</a>
                      </div>
                    </div>
                    <div class="row mg-b-15 d-none" id="divCentroDetencionAbono">
                      <div class="col-md-2">
                        <div class="form-group">
                          <label class="form-control-label">Años: <span class="tx-danger">*</span></label>
                          <input class="form-control input-number" type="text" name="abono_anios" id="abonoAnios" value="">
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <label class="form-control-label">Meses: <span class="tx-danger">*</span></label>
                          <input class="form-control input-number" type="text" name="abono_meses" id="abonoMeses" value="">
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <label class="form-control-label">Días: <span class="tx-danger">*</span></label>
                          <input class="form-control input-number" type="text" name="abono_dias" id="abonodias" value="">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="form-control-label">Centro de detención:<span class="tx-danger">*</span></label>
                          <select class="form-control select2-show-search" id="centroDetencionAbono" name="centro_detencion_abono" autocomplete="off" onchange="centroDetencionAbono()">  
                            <option value="" selected disabled>Seleccione una opción</option>
                            <option value="otro">Otro</option>
                            @foreach ($centros_detencion as $centro_detencion)
                                <option value="{{$centro_detencion['id_reclusorio']}}">{{$centro_detencion['nombre']}}</option>
                            @endforeach                   
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="form-control-label">Otro centro de detención:</label>
                          <input class="form-control" type="text" name="centro_detencion_abono_otro" id="centroDetencionAbonoOtro" value=""  placeholder="" autocomplete="off">
                        </div>
                      </div>
                      <div class="col-md-6" style="padding-top: 28px">
                        <button type="button" class="btn btn-outline-primary" onclick="agregarAbono()">Agregar</button>
                        <button type="button" class="btn btn-outline-secondary"  onclick="cancelarAbono()">Cancelar</button>
                      </div>
                    </div>
                    <div class="row mg-b-30">
                      <div class="col-md-12">
                        <table class="table-remi d-block">
                          <thead>
                            <th class="acciones">Acciones</th>
                            <th class="anios_abono">Años</th>
                            <th class="meses_abono">Meses</th>
                            <th class="dias_abono">Días</th>
                            <th class="centro_abono">Centro de detención</th>
                            <th class="otro_centro_abono">Otro centro de detención</th>
                          </thead>
                          <tbody id="bodyAbonos"></tbody>
                        </table>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <p style="font-weight: bold">Total de abono de prisión preventiva:</p>
                      </div>
                      <div class="col-md-4">
                        <p><span id="abonoAniosTotal">0</span> años, <span id="abonoMesesTotal">0</span> meses, <span id="abonoDiasTotal">0</span> días</p>
                      </div>
                    </div>
                    <div class="row mg-b-15">
                      <div class="col-md-4">
                        <p style="font-weight: bold">Total de sentencia por cumplir:</p>
                      </div>
                      <div class="col-md-4">
                        <p><span id="aniosTotalCumplir">0</span> años, <span id="mesesTotalCumplir">0</span> meses, <span id="diasTotalCumplir">0</span> días</p>
                      </div>
                    </div>
                  </div><!-- tab-pane -->
                  <div class="tab-pane" id="sutitutivosPena">
                    <div class="row mg-b-15">
                      <div class="col-12">
                        <a href="javascript:void(0)" onclick="nuevoSustitutivo()"><i class="fa fa-plus-circle" aria-hidden="true" style="color:#848F33"></i> Agregar sustitutivo</a>
                      </div>
                    </div>
                    <div id="sistitutivoNuevo" class="d-none">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="form-control-label">Sustitutivo:<span class="tx-danger">*</span></label>
                            <select class="form-control select2-show-search" id="sustitutivo" name="sustitutivo" autocomplete="off" onchange="sustitutivo()">  
                              <option value="" selected>Seleccione una opción</option>
                              <option value="1" >Multa en beneficio de la víctima</option>
                              <option value="2" >Multa en favor de la comunidad</option>
                              <option value="3" >Trabajo en beneficio de la víctima</option>
                              <option value="4" >Trabajo en favor de la comunidad</option>
                              <option value="5" >Tratamiento en libertad</option>
                              <option value="6" >Tratamiento en semilibertad</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group d-none" id="divMonto">
                            <label class="form-control-label">Monto:</label>
                            <input class="form-control input-money" type="text" name="monto_sustitutivo" id="montoSustitutivo" value="" autocomplete="off">
                          </div>
                        </div>
                      </div>
                      <div class="row mg-b-15">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="form-control-label">¿Se acoge al sustitutivo?<span class="tx-danger">*</span></label>
                            <div class="d-inline-block mg-l-5 mg-t-10" id="divMateriaDestino">
                              <label class="rdiobox d-inline-block mg-l-5">
                                <input name="acoge_sustitutivo" type="radio" value="si" class="acoge_sustitutivo_val">
                                <span class="pd-l-0">Si</span>
                              </label>
                              <label class="rdiobox d-inline-block mg-l-5">
                                <input name="acoge_sustitutivo" type="radio" value="no" class="acoge_sustitutivo_val">
                                <span class="pd-l-0">no</span>
                              </label>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row mg-b-15">
                        <div class="col-lg-12">
                          <div class="form-group">
                            <label class="form-control-label">Detalles adicionales:</label>
                            <textarea class="form-control" name="detalles_adicionales_sustitutivo" id="detallesAdicionalesSustitutivo" rows="4"></textarea>
                          </div>
                        </div>
                      </div>
                      <div class="row mg-b-20">
                        <div class="col-12 d-flex">
                          <button type="button" class="btn btn-outline-primary mg-l-auto" onclick="agregarSustitutivo()">Guardar</button>
                          <button type="button" class="btn btn-outline-secondary mg-l-10" onclick="cancelarSustitutivo()">Cancelar</button>
                        </div>
                      </div>
                    </div>
                    <div class="row mg-b-30">
                      <div class="col-12">
                        <table class="table-remi d-block d-md-table">
                          <thead>
                            <th class="acciones">Acciones</th>
                            <th class="sustitutivo">Sustitutivo</th>
                            <th class="monto_sustitutivo">Monto</th>
                            <th class="acoge_sustitutivo">Se acoge al sustitutivo</th>
                            <th class="detalles_adicionales_sustitutivo">Detalles adicionales</th>
                          </thead>
                          <tbody id="bodySustitutivos"></tbody>
                        </table>
                      </div>
                    </div>
                  </div><!-- tab-pane -->
                </div><!-- tab-content -->
              </div><!-- card-body -->
            </div><!-- card -->            
          </div><!-- modal-body -->
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="agregarPena()">Guardar pena</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="abreModal('modalSentenciado',400)">Cerrar</button>
          </div>
        </div>
      </div><!-- modal-dialog -->
    </div><!-- modal -->

    <div id="modalDelitos" class="modal fade" data-backdrop="static" data-keyboard="false" style="overflow-y: scroll;">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content tx-size-sm">
          <div class="modal-header pd-x-20">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Agregar delito</h6>
          </div>
          <div class="modal-body pd-20">
            <div class="row mg-b-10">
              <div class="col-12">
                <div class="form-group">
                  <label class="form-control-label">Delito a agregar:<span class="tx-danger">*</span></label>
                  <select class="form-control select2-show-search" id="delitoPena" name="delitoPena" autocomplete="off">                    
                  </select>
                </div>
              </div>              
            </div>
          </div><!-- modal-body -->
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="agregarDelito()">Guardar delito</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="abreModal('modalPenas',400)">Cerrar</button>
          </div>
        </div>
      </div><!-- modal-dialog -->
    </div><!-- modal -->

    <div id="modalDefensor" class="modal fade" data-backdrop="static" data-keyboard="false" style="overflow-y: scroll;">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content tx-size-sm">
          <div class="modal-header pd-x-20">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Agregar defensor</h6>
          </div>
          <div class="modal-body pd-20">
            <div class="row mg-b-10">
              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-control-label">Tipo de presona:<span class="tx-danger">*</span></label>
                  <select class="form-control select2-show-search" id="tipoPersonaDefensor" name="tipo_persona_defensor" autocomplete="off"> 
                    <option value="" selected disabled>Seleccione una opción</option>
                    <option value="fisica">Física</option>
                    <option value="moral">Moral</option>
                  </select>
                </div>
              </div>     
              <div class="col-md-4 fisica">
                <div class="form-group">
                  <label class="form-control-label">Nacionalidad:<span class="tx-danger">*</span></label>
                  <select class="form-control select2-show-search" id="nacionalidadDefensor" name="nacionalidad_defensor" autocomplete="off"> 
                    <option value="" selected disabled>Seleccione una opción</option>
                    <option value="mexicana">Mexicana</option>
                    <option value="extranjero">Extranjero</option>
                    <option value="mexicana_otro">Mexicana/Otra</option>
                    <option value="no_especificada">No especificada</option>
                  </select>
                </div>
              </div> 
            </div>
            <div class="row">    
              <div class="col-lg-6 fisica">
                <div class="form-group">
                  <label class="form-control-label">Indique la Nacionalidad: </label>
                  <select class="form-control " id="otraNacionalidadDefensor" name="otra_nacionalidad_defensor" autocomplete="off" disabled>
                      <option selected  value="" disabled>Elija una opción</option>
                      @foreach ($nacionalidades as $nacionalidad)
                            <option value="{{$nacionalidad['id_nacionalidad']}}">{{$nacionalidad['nacionalidad']}}</option> 
                      @endforeach
                  </select>
                </div>
              </div><!-- col-6-->    
            </div>
            <div class="row mg-b-15">
              <div class="col-lg-4 fisica">
                <div class="form-group mg-b-10-force">
                  <label class="form-control-label">Nombre(s): <span class="tx-danger">*</span></label>
                  <input class="form-control" type="text" name="nombre_defensor" id="nombreDefensor" autocomplete="off">
                </div>
              </div><!-- col-4 -->
              <div class="col-lg-4 fisica">
                <div class="form-group mg-b-10-force">
                  <label class="form-control-label">Apellido Paterno: <span class="tx-danger">*</span></label>
                  <input class="form-control" type="text" name="apellido_paterno_defensor" id="apellidoPaternoDefensor" autocomplete="off">
                </div>
              </div><!-- col-4 -->
              <div class="col-lg-4 fisica">
                <div class="form-group mg-b-10-force">
                  <label class="form-control-label">Apellido Materno:</label>
                  <input class="form-control" type="text" name="apellido_materno_defensor" id="apellidoMaternoDefensor" autocomplete="off">
                </div>
              </div><!-- col-4-->
            </div>
            <div class="row mg-b-15">
              <div class="col-lg-3 fisica">
                <div class="form-group">
                  <label class="form-control-label">Genero: <span class="tx-danger">*</span></label>
                  <select class="form-control select2" id="generoDefensor" name="genero_defensor" autocomplete="off">
                      <option selected disabled value="">Elija una opción</option>
                      <option value="masculino">MASCULINO</option>
                      <option value="femenino">FEMENINO</option>
                      <option value="indeterminado">INDETERMINADO</option>
                  </select>
                </div>
              </div><!-- col-4-->
            </div>
            <div class="row mg-b-15">
              <div class="col-lg-3 fisica">
                <div class="form-group">
                  <label class="form-control-label">Fecha de Nacimiento: </label>
                  <div class="input-group">
                      <div class="input-group-prepend">
                          <div class="input-group-text">
                              <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                          </div>
                      </div>
                      <input type="text" class="form-control fc-datepicker" placeholder="DD/MM/AAAA" id="fechaNacimientoDefensor" name="fecha_nacimiento_defensor" autocomplete="off">
                  </div>
                </div>
              </div><!-- col-4 -->
              <div class="col-lg-3 fisica">
                <div class="form-group mg-b-10-force">
                  <label class="form-control-label">Edad:</label>
                  <input class="form-control input-number" type="text" name="edad_defensor" id="edadDefensor" autocomplete="off">
                </div>
              </div><!-- col-4-->
            </div>
            <div class="row mg-b-15">
              <div class="col-lg-3 fisica">
                <div class="form-group">
                  <label class="form-control-label">Estado Civil: </label>
                  <select class="form-control select2" id="estadoCivilDefensor" name="estado_civil_defensor" autocomplete="off">
                      <option selected   value="">Elija una opción</option>
                      @foreach ($estado_civil as $estado)
                          <option value="{{$estado['id_estado_civil']}}">{{$estado['estado_civil']}}</option>
                      @endforeach
                  </select>
                </div>
              </div><!-- col-4-->
              <div class="col-lg-4 fisica">
                <div class="form-group mg-b-10-force">
                  <label class="form-control-label">CURP:</label>
                  <input class="form-control" type="text" name="curp_defensor" id="curpDefensor" autocomplete="off">
                </div>
              </div><!-- col-4 -->
            </div>
            <div class="row mg-b-15">  
              <div class="col-lg-8 moral d-none">
                <div class="form-group mg-b-10-force">
                  <label class="form-control-label">Razón Social:</label>
                  <input class="form-control" type="text" name="razon_social_defensor" id="razonSocialDefensor" autocomplete="off">
                </div>
              </div><!-- col-4 -->
              <div class="col-lg-4 moral d-none">
                <div class="form-group mg-b-10-force">
                  <label class="form-control-label">RFC:</label>
                  <input class="form-control" type="text" name="rfc_defensor" id="rfcDefensor" autocomplete="off">
                </div>
              </div><!-- col-4 -->
            </div>
          </div><!-- modal-body -->
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="agregarNuevoDefensor()">Agregar delito</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="abreModal('modalPenas',400)">Cerrar</button>
          </div>
        </div>
      </div><!-- modal-dialog -->
    </div><!-- modal -->

    <div id="modalDocumento" class="modal fade" data-backdrop="static" data-keyboard="false" style="overflow-y: scroll;">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content tx-size-sm">
          <div class="modal-header pd-x-20">
            <h6 class="tx-14 mg-b-0 tx-inverse tx-bold" id="nombreDocumento"></h6>
          </div>
          <div class="modal-body pd-20" id="objectDocumento">
          </div><!-- modal-body -->
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="abreModal('modalRemision',400)">Cerrar</button>
          </div>
        </div>
      </div><!-- modal-dialog -->
    </div><!-- modal -->
  @endsection