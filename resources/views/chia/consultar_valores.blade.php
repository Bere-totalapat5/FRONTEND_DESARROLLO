@php
  use App\Http\Controllers\clases\humanRelativeDate;
  use App\Http\Controllers\clases\utilidades;
  $humanRelativeDate = new humanRelativeDate();
@endphp
@extends('layouts.index')

@section('contenido-pageheader')
  <ol class="breadcrumb slim-breadcrumb"> 
    <li class="breadcrumb-item"><a href="/home">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Billetes</li>
  </ol>
  <h6 class="slim-pagetitle">Consultar Valores</h6>
@endsection
@section('contenido-principal')
{{-- {{dd($request)}} --}}
  <div class="section-wrapper mg-b-100">
    @if(!utilidades::buscarPermisoMenu($request->menu_general['response'], 54, 0))
      <h1 class="mg-b-50">No tiene permiso para acceder a esta sección, verifíquelo con su titular</h1>
      <a href="/home"><button class="btn btn-primary btn-block">Regresar al inicio</button><a>
    @else
    <div class="form-layout mg-b-25">
      <div id="accordion" class="accordion-one" role="tablist" aria-multiselectable="true">
        <div class="card">
          <div class="card-header" role="tab" id="headingOne">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" class="tx-gray-800 transition collapsed">
              <i class="fa fa-search" aria-hidden="true"></i>
            </a>
          </div><!-- card-header -->
          <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne">
            <div class="card-body">
              <div class="row mg-b-25 ">
                <div class="col-lg-3">
                  <div class="form-group mg-b-10-force">
                    <label class="form-control-label">Folio:</label>
                    <input class="form-control" type="text" name="folio" id="folio" value=""  autocomplete="off">
                  </div>
                </div><!-- col-3 -->
                <div class="col-lg-3">
                  <div class="form-group mg-b-10-force">
                    <label class="form-control-label">Carpeta:</label>
                    <input class="form-control" type="text" name="numero_expediente" id="numeroExpediente" value="" placeholder="" autocomplete="off">
                  </div>
                </div><!-- col-3 -->
                <div class="col-lg-3 d-none">
                  <div class="form-group">
                    <label class="form-control-label">Moneda:<span class="tx-danger">*</span></label>
                    <select class="form-control select2-show-search valid" id="moneda" name="moneda" autocomplete="off">
                        <option selected disabled value="">Elija una opción</option>
                        @if ( $monedas['status'] == 100 )
                          @foreach ( $monedas['response'] as $moneda )
                            <option value="{{$moneda['CveCurrency']}}">{{$moneda['Name']}}</option> 
                          @endforeach
                        @endif
                    </select>
                  </div>
                </div><!-- col-3 -->
                <div class="col-lg-3 d-none">
                  <div class="form-group mg-b-10-force">
                    <label class="form-control-label">Importe:<span class="tx-danger">*</span></label>
                    <input class="form-control input-money" style="text-align: end" type="text" name="importe" id="importe" value="$ 0" autocomplete="off">
                  </div>
                </div><!-- col-3 -->
                <div class="col-lg-3">
                  <div class="form-group">
                    <label class="form-control-label">Fecha de expedición:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                            </div>
                        </div>
                        <input type="text" class="form-control fc-datepicker" placeholder="DD-MM-AAAA" value="" id="fechaExpedicion" name="fecha_expedicion" autocomplete="off">
                    </div>
                  </div>
                </div><!-- col-3 -->
                <div class="col-lg-3">
                  <div class="form-group">
                    <label class="form-control-label">Fecha de exhibición:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                            </div>
                        </div>
                        <input type="text" class="form-control fc-datepicker" placeholder="DD-MM-AAAA" value="" id="fechaExhibicion" name="fecha_exhibicion" spellcheck="false" autocomplete="off">
                    </div>
                  </div>
                </div><!-- col-3 -->
                <div class="col-lg-3">
                  <div class="form-group">
                    <label class="form-control-label">Tipo de valor: </label>
                    <select class="form-control select2-show-search valid" id="tipoValor" name="tipo_valor" autocomplete="off" >
                        <option selected value="">Elija una opción</option>
                        @if ( $valores['status'] == 100 )
                          @foreach ( $valores['response'] as $valor )
                            @if( in_array($valor['CveTypeCertificate'], [1,4] ) )
                              <option value="{{$valor['CveTypeCertificate']}}">{{$valor['Name']}}</option> 
                            @endif
                          @endforeach
                        @endif
                    </select>
                  </div>
                </div><!-- col-3 -->
                <div class="col-lg-3 d-none">
                  <div class="form-group">
                    <label class="form-control-label">Concepto:<span class="tx-danger">*</span></label>
                    <select class="form-control select2-show-search" id="concepto" name="concepto" autocomplete="off">
                      <option selected disabled value="">Elija una opción</option>
                      @if ( $conceptos['status'] == 100 )
                        @foreach ( $conceptos['response'] as $concepto )
                          <option value="{{$concepto['CveConcept']}}">{{$concepto['Name']}}</option> 
                        @endforeach
                      @endif
                    </select>
                  </div>
                </div><!-- col-3 -->
                <div class="col-lg-3 d-none">
                  <div class="form-group mg-b-10-force">
                    <label class="form-control-label">Nombre del depositante:<span class="tx-danger">*</span></label>
                    <input class="form-control" type="text" name="nombre_depositante" id="nombreDepositante" value="" autocomplete="off">
                  </div>
                </div><!-- col-3 -->
                @if( Session::get('id_unidad_gestion') == 0 )
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label">Instancia:</label>
                      <select class="form-control select2-show-search valid" id="filtro_instancia" name="filtro_instancia" autocomplete="off">
                        <option value="">Elija una opción</option>
                        @if ( $instancias['status'] == 100 )
                          @foreach ( $instancias['response'] as $instancia )
                            <option value="{{$instancia['CveInstance']}}">{{$instancia['Name']}}</option> 
                          @endforeach
                        @endif
                      </select>
                    </div>
                  </div><!-- col-3 -->
                @endif
                <div class="col-lg-3 d-none">
                  <div class="form-group d-none">
                    <label class="form-control-label">Banco:<span class="tx-danger">*</span></label>
                    <select class="form-control select2-show-search" id="banco" name="banco" autocomplete="off">
                      <option selected disabled value="">Elija una opción</option>
                      @if ( $bancos['status'] == 100 )
                        @foreach ( $bancos['response'] as $banco )
                          <option value="{{$banco['CveBank']}}">{{$banco['Name']}}</option> 
                        @endforeach
                      @endif              
                    </select>
                  </div>
                </div><!-- col-3 -->
              </div><!-- row -->
              <div class="form-layout-footer d-flex">
                <button class="btn btn-primary bd-0 d-inline-block ml-auto" id="btnAgregarMovimiento" onclick="obtener_valores(1)">Buscar</button>
              </div><!-- form-layout-footer -->
            </div><!-- card-bod -->
          </div>
        </div>
      </div><!-- accordion -->
    </div>

      
      <div class="row"  >
        <div class="col-12">
          <table  data-swipe-ignore="true" id="tableValores" class="display dataTable dtr-inline collapsed" style="overflow-x: auto; padding-left:0; padding-rigth:0">
            <thead style="background-color: #EBEEF1; color: #000;" data-swipe-ignore="true">
              <th class="acciones">Acciones</th>
              <th class="folio">Folio</th>
              <th class="carpeta_judicial">Carpeta Judicial</th>
              <th class="estatus">Estatus</th>
              <th class="instancia">Instancia</th>
              <th class="fecha_ingreso">Fecha de ingreso</th>
              <th class="fecha_egreso">Fecha de egreso</th>
              <th class="fecha_devolucion">Fecha de devolución</th>
              <th class="importe">Importe</th>
              <th class="moneda">Moneda</th>
              <th class="depositante">Depositante</th>
              <th class="beneficiario">Beneficiario</th>
              <th class="institucion">Institucion</th>
            </thead>
            <tbody id="bodyValores">
            </tbody>
          </table>
          <div class="pagination-wrapper justify-content-between">
            <ul class="pagination mg-b-0">
              <li class="page-item">
                <a class="page-link primera" href="javascript:void(0)" aria-label="Last" onclick="obtener_valores(1)">
                  <i class="fa fa-angle-double-left"></i>
                </a>
              </li>
              <li class="page-item">
                <a class="page-link anterior" href="javascript:void(0)" aria-label="Next" onclick="obtener_valores(1)">
                  <i class="fa fa-angle-left"></i>
                </a>
              </li>
            </ul>
            <ul class="pagination mg-b-0">
              <li class="page-item">Página <span class="pagina">1</span> de <span class="total-paginas">1</span></li>
            </ul>

            <ul class="pagination mg-b-0">
              <li class="page-item">
                <a class="page-link siguiente" href="javascript:void(0)" aria-label="Next" onclick="obtener_valores(1)">
                  <i class="fa fa-angle-right"></i>
                </a>
              </li>
              <li class="page-item">
                <a class="page-link ultima" href="javascript:void(0)" aria-label="Last" onclick="obtener_valores(1)">
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
  <link rel="stylesheet" href="{{asset("css/chia/consultar_valores.css")}}">
  <style>
    .error{
      border : 1px solid red;
    }
    ul.uib-datepicker-popup.dropdown-menu.ng-scope { z-index: 1090 !important; }
    #ui-datepicker-div{
      z-index: 1050 !important;
    }

    #accordion .card{
      border:none !important;
    }
    #accordion .card .card-header{
      width: 75px !important;
      border: 1px solid #dee2e6 !important;
    }
    #accordion .card .card-header a{
      padding: 10px !important;
    }
    #collapseOne{
      border: 1px solid #eee !important;
      background: #f8f9fa;
    }
    #accordion a::before{
      top: 10px !important;
    }
  </style>
@endsection
@section('seccion-scripts-libs')    
<script src="{{asset('/js/chia/consultar_valores.js')}}"></script>
<script src="{{asset('/js/chia/chia.js')}}"></script>
  {{-- <script type="text/javascript" src="{{asset('/js/dropzone.min.js')}}"></script> --}}
@endsection
@section('seccion-scripts-functions')
  <script>
    
    let step=1;
    const expRegFecha=/^([0-2][0-9]|3[0-1])(-)(0[1-9]|1[0-2])\2(\d{4})$/,
          expRegHora=/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/,
          expVacio=/^[\s]*$/,
          expRFC=/^(([ÑA-Z|ña-z|&]{3}|[A-Z|a-z]{4})\d{2}((0[1-9]|1[012])(0[1-9]|1\d|2[0-8])|(0[13456789]|1[012])(29|30)|(0[13578]|1[02])31)(\w{2})([A|a|0-9]{1}))$|^(([ÑA-Z|ña-z|&]{3}|[A-Z|a-z]{4})([02468][048]|[13579][26])0229)(\w{2})([A|a|0-9]{1})$/;
          arrSujetosProcesales=[];

    $('document').ready(() => {
      setTimeout(function(){
        $('#modal_loading').modal('hide');
      }, 2000);
    })
    
    $(function(){
      'use strict'
      $('.ui-datepicker-year').addClass('select2');
      
      // Datepicker
      $('.fc-datepicker').datepicker({
          
          showOtherMonths: true,
          selectOtherMonths: true,
          format: 'yyyy/mm/dd',
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

      // Toggles
      
      $('.toggle-on').toggles({
        on: true,
        height: 26
      });
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
      $('#horaRecepcion').timepicker();

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

  </script>                                                                                                                                    
@endsection
@section('seccion-modales')
  <div id="modalError" class="modal fade" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-body tx-center pd-y-20 pd-x-20">
          <i class="icon icon ion-ios-close-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
          <h4 class="tx-danger mg-b-20" id="titleError"></h4>
          <p class="mg-b-20 mg-x-20" id="messageError"></p>
          <button type="button" class="btn btn-danger pd-x-25" id="btnError" data-dismiss="modal" aria-label="Close">Aceptar</button>
        </div><!-- modal-body -->
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
  </div><!-- modal -->
  
  <div id="modalSuccess" class="modal fade"  data-backdrop="static" data-keyboard="false" >
    <div class="modal-dialog" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-body tx-center pd-y-20 pd-x-20">
          <i class="icon ion-ios-checkmark-outline tx-100 tx-success lh-1 mg-t-20 d-inline-block"></i>
          <h6 class="tx-success tx-semibold mg-b-20" id="tituloSuccess"></h6>
          <p style="padding-left: 5vh; padding-right: 5vh;" id="modal-success-titulo"></p>
        </div><!-- modal-body -->
        <div class="modal-footer d-flex">
          <button type="button" class="btn btn-primary pd-x-25 mg-l-auto cerrar-modal" data-dismiss="modal"  data-thismodal="modalSuccess" id="btnCerrarSuccess">Aceptar</button>
        </div>
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
  </div><!-- modal -->

  <div id="modalDevolucion" class="modal fade" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-vertical-center" role="document" style="">
      <div class="modal-content bd-0 tx-14" style="min-width: 100%">
        <div class="modal-header">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">DEVOLUCIÓN DE VALOR <span id="folioDev" class="font-weight-normal"></span></h6>
        </div>
        <div class="modal-body pd-25">
          <div class="row">
            <div class="col-md-6">
              <h6 class="slim-pagetitle mg-b-20">Datos de la devolución</h6>
              <div class="row">            
                <div class="col-12">
                  <div class="form-group">
                    <label class="form-control-label">Operación:<span class="tx-danger">*</span></label>
                    <select class="form-control select2" id="operacion" name="operacion" autocomplete="off">
                      <option selected disabled value="">Elija una opción</option>
                      @if ( $estatus['status'] == 100 )
                        @foreach ( $estatus['response'] as $estatus_val )
                          <option value="{{$estatus_val['CveValueStatus']}}">{{$estatus_val['Description']}}</option> 
                        @endforeach
                      @endif              
                    </select>
                  </div>
                </div><!-- col-3 -->
                <div class="col-12">
                  <div class="form-group">
                    <label class="form-control-label">Concepto de devolución:<span class="tx-danger">*</span></label>
                    <select class="form-control select2-show-search" id="conceptoDevolucion" name="concepto_devolucion" autocomplete="off">
                      <option selected disabled value="">Elija una opción</option>
                      @if ( $conceptos['status'] == 100 )
                        @foreach ( $conceptos['response'] as $concepto )
                          <option value="{{$concepto['CveConcept']}}">{{$concepto['Name']}}</option> 
                        @endforeach
                      @endif
                    </select>
                  </div>
                </div><!-- col-3 -->
                <div class="col-12">
                  <div class="form-group">
                    <label class="form-control-label">Fecha de devolución:<span class="tx-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                            </div>
                        </div>
                        <input type="text" class="form-control fc-datepicker" placeholder="DD-MM-AAAA" value="{{date('d-m-Y')}}" id="fechaDevolucion" name="fecha_devolucion" autocomplete="off">
                    </div>
                  </div>
                </div><!-- col-3 -->
                <div class="col-12">
                  <div class="form-group mg-b-10-force">
                    <label class="form-control-label">Compareciente:<span class="tx-danger">*</span></label>
                    <input class="form-control" type="text" name="compareciente" style="text-transform: none" id="compareciente"  autocomplete="off">
                  </div>
                </div><!-- col-3 -->
                <div class="col-12">
                  <div class="form-group mg-b-10-force">
                    <label class="form-control-label">Identificación:<span class="tx-danger">*</span></label>
                    <input class="form-control" type="text" name="identificacion" style="text-transform: none" id="identificacion"  autocomplete="off">
                  </div>
                </div><!-- col-3 -->
                <div class="col-12">
                  <div class="form-group">
                    <label class="form-control-label">Juez que autoriza:<span class="tx-danger">*</span></label>
                    <input class="form-control" type="text" name="juezAutoriza" style="text-transform: none" id="juezAutoriza"  autocomplete="off">
                    {{-- <select class="form-control select2-show-search " id="juezAutoriza" name="juez_autoriza" autocomplete="off">
                      <option selected disabled value="">Elija una opción</option>
                      @if ( $jueces_control['status'] == 100 )
                        @foreach ( $jueces_control['response'] as $juez )
                          <option value="{{$juez['nombres']}} {{$juez['apellido_paterno']}} {{$juez['apellido_materno']}}">{{$juez['nombres']}} {{$juez['apellido_paterno']}} {{$juez['apellido_materno']}}</option> 
                        @endforeach
                      @endif
                    </select> --}}
                  </div>
                </div><!-- col-3 -->
              </div>
            </div>
            <div class="col-md-6">
              <h6 class="slim-pagetitle mg-b-20">Documentos</h6>
                <div class="container">
                  <table style="text-align: center;border: 1px solid #eee;color: #000;">
                    <thead style="background: #848F33;"><tr><th style="color: #FFF">Descargar formato de devolucion</th></tr></thead>
                    <tbody><tr><td  style="font-size: 3em;"><a href="javascript:void(0)" id="btnDescargaFormatoDevolucion"><i class="fa fa-download" aria-hidden="true"></i></a></td></tr></tbody>
                  </table>
                </div>
                <br>
                <form onsubmit="return false;" id="cargarDocumento" action="/" enctype="multipart/form-data">
                  <div class="custom-input-file">
                    <input type="file" id="archivo_doc" class="input-file" value="" name="documento_adjunto" onchange="leeDocumento(this);" accept="application/pdf">
                    <p class="px-3 py-3">Arrastre hasta aquí su documento pdf o de clic para adjuntarlo</p>
                  </div>
                </form>
                <div id="divDocumentos" class="pd-30 row text-center">
    
                </div>
            </div>
          </div>
        </div>
        <div class="modal-footer d-flex">
          <button type="button" class="btn btn-secondary mg-r-auto"  data-dismiss="modal" style="margin-right: auto;">Cancelar</button>
          <button type="button" class="btn btn-primary mg-l-auto" onclick="devolverValor()" id="btnDevolucion" data-dismiss="modal">Aceptar</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->

  <div id="modalEdicion" class="modal fade" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Actualización de valor</h6>
        </div>
        <div class="modal-body pd-20">
          <div class="form-layout">
            <div class="row mg-b-25 ">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-control-label">Tipo de valor: <span class="tx-danger">*</span></label>
                  <select class="form-control select2-show-search valid" id="tipoValorE" name="tipo_valor_e" autocomplete="off" onchange="tipoValorE()">
                      <option selected disabled value="">Elija una opción</option>
                      @if ( $valores['status'] == 100 )
                        @foreach ( $valores['response'] as $valor )
                          @if( in_array($valor['CveTypeCertificate'], [1,4] ) )
                            <option value="{{$valor['CveTypeCertificate']}}">{{$valor['Name']}}</option> 
                          @endif
                        @endforeach
                      @endif
                  </select>
                </div>
              </div><!-- col-3 -->
              <div class="col-md-6">
                <div class="form-group mg-b-10-force">
                  <label class="form-control-label">Folio:<span class="tx-danger">*</span></label>
                  <input class="form-control" type="text" name="folio_e" id="folioE" value=""  autocomplete="off" readonly style="background: #FFF">
                </div>
              </div><!-- col-3 -->
              <div class="col-md-6">
                <div class="form-group mg-b-10-force">
                  <label class="form-control-label">Carpeta Judicial:<span class="tx-danger">*</span></label>
                  <input class="form-control" type="text" name="numero_expediente_e" id="numeroExpedienteE" value="" placeholder="" autocomplete="off">
                </div>
              </div><!-- col-3 -->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-control-label">Moneda:<span class="tx-danger">*</span></label>
                  <select class="form-control select2-show-search valid" id="monedaE" name="moneda_e" autocomplete="off">
                      <option selected disabled value="">Elija una opción</option>
                      @if ( $monedas['status'] == 100 )
                        @foreach ( $monedas['response'] as $moneda )
                          <option value="{{$moneda['CveCurrency']}}">{{$moneda['Name']}}</option> 
                        @endforeach
                      @endif
                  </select>
                </div>
              </div><!-- col-3 -->
              <div class="col-md-6">
                <div class="form-group mg-b-10-force">
                  <label class="form-control-label">Importe:<span class="tx-danger">*</span></label>
                  <input class="form-control input-money" style="text-align: end" type="text" name="importe_e" id="importeE" value="$" autocomplete="off">
                </div>
              </div><!-- col-3 -->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-control-label">Fecha de expedición:<span class="tx-danger">*</span></label>
                  <div class="input-group">
                      <div class="input-group-prepend">
                          <div class="input-group-text">
                              <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                          </div>
                      </div>
                      <input type="text" class="form-control fc-datepicker" placeholder="DD-MM-AAAA" value="" id="fechaExpedicionE" name="fecha_expedicion_e" autocomplete="off">
                  </div>
                </div>
              </div><!-- col-3 -->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-control-label">Fecha de exhibición:<span class="tx-danger">*</span></label>
                  <div class="input-group">
                      <div class="input-group-prepend">
                          <div class="input-group-text">
                              <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                          </div>
                      </div>
                      <input type="text" class="form-control fc-datepicker" placeholder="DD-MM-AAAA" value="" id="fechaExhibicionE" name="fecha_exhibicion_e" autocomplete="off">
                  </div>
                </div>
              </div><!-- col-3 -->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-control-label">Concepto de exhibición:<span class="tx-danger">*</span></label>
                  <select class="form-control select2-show-search" id="conceptoE" name="concepto_e" autocomplete="off">
                    <option selected disabled value="">Elija una opción</option>
                    @if ( $conceptos['status'] == 100 )
                      @foreach ( $conceptos['response'] as $concepto )
                        <option value="{{$concepto['CveConcept']}}">{{$concepto['Name']}}</option> 
                      @endforeach
                    @endif
                  </select>
                </div>
              </div><!-- col-3 -->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-control-label">Fecha de devolución:<span class="tx-danger">*</span></label>
                  <div class="input-group">
                      <div class="input-group-prepend">
                          <div class="input-group-text">
                              <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                          </div>
                      </div>
                      <input type="text" class="form-control fc-datepicker" placeholder="DD-MM-AAAA" value="" id="fechaDevolucionE" name="fecha_devolucion_e" autocomplete="off">
                  </div>
                </div>
              </div><!-- col-3 -->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-control-label">Concepto de devolución:<span class="tx-danger">*</span></label>
                  <select class="form-control select2-show-search" id="conceptoDevolucionE" name="concepto_decolucion_e" autocomplete="off">
                    <option selected disabled value="">Elija una opción</option>
                    @if ( $conceptos['status'] == 100 )
                      @foreach ( $conceptos['response'] as $concepto )
                        <option value="{{$concepto['CveConcept']}}">{{$concepto['Name']}}</option> 
                      @endforeach
                    @endif
                  </select>
                </div>
              </div><!-- col-3 -->              
              <div class="col-md-6">
                <div class="form-group mg-b-10-force">
                  <label class="form-control-label">Nombre del depositante:<span class="tx-danger">*</span></label>
                  <input class="form-control" type="text" name="nombre_depositante_e" id="nombreDepositanteE" value="" autocomplete="off">
                </div>
              </div><!-- col-3 -->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-control-label">A disposición de:<span class="tx-danger">*</span></label>
                  <select class="form-control select2-show-search valid" id="disposicionE" name="disposicion_e" autocomplete="off">
                    <option selected disabled value="">Elija una opción</option>
                    @if ( $instancias['status'] == 100 )
                      @foreach ( $instancias['response'] as $instancia )
                        @if( $instancia['CveInstance'] != $cve_instancia_usuario )
                          <option value="{{$instancia['CveInstance']}}">{{$instancia['Name']}}</option> 
                        @else
                          <option value="{{$instancia['CveInstance']}}" selected>{{$instancia['Name']}}</option> 
                        @endif
                      @endforeach
                    @endif
                  </select>
                </div>
              </div><!-- col-3 -->    
              <div class="col-md-6">
                <div class="form-group mg-b-10-force">
                  <label class="form-control-label">Beneficiario:</label>
                  <input class="form-control" type="text" name="beneficiario_e" id="beneficiarioE" value="" autocomplete="off">
                </div>
              </div><!-- col-3 -->
              <div class="col-md-6">
                <div class="form-group mg-b-10-force">
                  <label class="form-control-label">Institución:</label>
                  <input class="form-control" type="text" name="instituicion_e" id="institucionE" value="" autocomplete="off">
                </div>
              </div><!-- col-3 -->          
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-control-label">Banco:<span class="tx-danger">*</span></label>
                  <select class="form-control select2-show-search" id="bancoE" name="banco_e" autocomplete="off">
                    <option selected disabled value="">Elija una opción</option>
                    @if ( $bancos['status'] == 100 )
                      @foreach ( $bancos['response'] as $banco )
                        <option value="{{$banco['CveBank']}}">{{$banco['Name']}}</option> 
                      @endforeach
                    @endif              
                  </select>
                </div>
              </div><!-- col-3 -->
              
            </div><!-- row -->
          </div>
        </div><!-- modal-body -->
        <div class="modal-footer d-flex">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary mg-l-auto" id="btnEditar">Guardar cambios</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->

  <div id="modalTransferencia" class="modal fade" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document" style="">
      <div class="modal-content bd-0 tx-14" style="min-width: 100%">
        <div class="modal-header">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">INSTANCIA A TRANSFERIR EL VALOR: <span id="folioTransfir" class="font-weight-normal"></span></h6>
        </div>
        <div class="modal-body pd-25">
          <div class="row">            
            <div class="col-12">
              <div class="form-group">
                <label class="form-control-label">A disposición de:<span class="tx-danger">*</span></label>
                <select class="form-control select2-show-search valid" id="disposicionT" name="disposicion_t" autocomplete="off">
                  <option selected disabled value="">Elija una opción</option>
                  @if ( $instancias['status'] == 100 )
                    @foreach ($instancias['response'] as $instancia)    
                      @if( $instancia['CveInstance'] != $cve_instancia_usuario )
                        <option value="{{$instancia['CveInstance']}}">{{$instancia['Name']}}</option> 
                      @else
                        <option value="{{$instancia['CveInstance']}}" selected>{{$instancia['Name']}}</option> 
                      @endif
                    @endforeach
                  @endif
                </select>
              </div>
            </div><!-- col-3 -->
          </div>
        </div>
        <div class="modal-footer d-flex">
          <button type="button" class="btn btn-secondary mg-r-auto"  data-dismiss="modal" style="margin-right: auto;">Cancelar</button>
          <button type="button" class="btn btn-primary mg-l-auto" id="btnTransferir" data-dismiss="modal">Transferir</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->

  <div id="modalDocumentos" class="modal fade">
    <div class="modal-dialog modal-dialog-vertical-center" role="document">
      <div class="modal-content bd-0 tx-14">
        <div class="modal-header">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Documentos</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pd-25 row text-center" id="lista_docs">          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal" >Cerrar</button>
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
          <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="abreModal('modalDocumentos',400)">Cerrar</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->

  <div id="modalDocumentoDevolucion" class="modal fade" data-backdrop="static" data-keyboard="false" style="overflow-y: scroll;">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-inverse tx-bold" id="nombreDocumentoDevolucion"></h6>
        </div>
        <div class="modal-body pd-20" id="objectDocumentoDevolucion">
        </div><!-- modal-body -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="abreModal('modalDevolucion',400)">Cerrar</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->

@endsection