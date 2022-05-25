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
  <h6 class="slim-pagetitle">Agregar Valores</h6>
@endsection
@section('contenido-principal')
{{-- {{dd($request)}} --}}
  <div class="section-wrapper mg-b-100">
    @if( !utilidades::buscarPermisoMenu($request->menu_general['response'], 53, 0) )
      <h1 class="mg-b-50">No tiene permiso para acceder a esta sección, verifíquelo con su titular</h1>
      <a href="/home"><button class="btn btn-primary btn-block">Regresar al inicio</button><a>
    @else
      <div class="form-layout">
        <div class="row">          
          <div class="col-md-12">
            <h6 class="slim-pagetitle mg-b-20">Datos del valor</h6>
            <div class="row mg-b-25 mg-t-10">
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label">Tipo de valor: <span class="tx-danger">*</span></label>
                  <select class="form-control select2-show-search valid" id="tipoValor" name="tipo_valor" autocomplete="off" onchange="tipoValor()">
                      <option selected disabled value="">Elija una opción</option>
                      @if ( $valores['status'] == 100 )
                        @foreach ( $valores['response'] as $valor )
                          @if( in_array($valor['CveTypeCertificate'], [1,4] ) )
                            {{-- <option value="{{$valor['CveTypeCertificate']}}">{{$valor['Name']=='Vale'?'Efectivo':$valor['Name']}}</option>  --}}
                            <option value="{{$valor['CveTypeCertificate']}}">{{$valor['Name']}}</option> 
                          @endif
                        @endforeach
                      @endif
                      {{-- <option value="1">Billete</option>
                      <option value="2">Cheque</option>
                      <option value="3">Vale</option> --}}
                  </select>
                </div>
              </div><!-- col-3 -->
              <div class="col-lg-4">
                <div class="form-group mg-b-10-force">
                  <label class="form-control-label">Folio:<span class="tx-danger">*</span></label>
                  <input class="form-control" type="text" name="folio" id="folio" value=""  autocomplete="off">
                </div>
              </div><!-- col-3 -->
              <div class="col-lg-4">
                <div class="form-group mg-b-10-force">
                  <label class="form-control-label">Carpeta Judicial:<span class="tx-danger">*</span></label>
                  <input class="form-control" type="text" name="numero_expediente" id="numeroExpediente" value="" placeholder="" autocomplete="off">
                </div>
              </div><!-- col-3 -->
              <div class="col-lg-4">
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
              <div class="col-lg-4">
                <div class="form-group mg-b-10-force">
                  <label class="form-control-label">Importe:<span class="tx-danger">*</span></label>
                  <input class="form-control input-money" style="text-align: end" type="text" name="importe" id="importe" value="$" autocomplete="off">
                </div>
              </div><!-- col-3 -->
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label">Fecha de expedición:<span class="tx-danger">*</span></label>
                  <div class="input-group">
                      <div class="input-group-prepend">
                          <div class="input-group-text">
                              <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                          </div>
                      </div>
                      <input type="text" class="form-control fc-datepicker" placeholder="DD-MM-AAAA" value="{{date('d-m-Y')}}" id="fechaExpedicion" name="fecha_expedicion" autocomplete="off">
                  </div>
                </div>
              </div><!-- col-3 -->
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label">Fecha de exhibición:<span class="tx-danger">*</span></label>
                  <div class="input-group">
                      <div class="input-group-prepend">
                          <div class="input-group-text">
                              <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                          </div>
                      </div>
                      <input type="text" class="form-control fc-datepicker" placeholder="DD-MM-AAAA" value="{{date('d-m-Y')}}" id="fechaExhibicion" name="fecha_exhibicion" autocomplete="off">
                  </div>
                </div>
              </div><!-- col-3 -->
              <div class="col-lg-4">
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
              <div class="col-lg-4">
                <div class="form-group mg-b-10-force">
                  <label class="form-control-label">Nombre del depositante:<span class="tx-danger">*</span></label>
                  <input class="form-control" type="text" name="nombre_depositante" id="nombreDepositante" value="" autocomplete="off">
                </div>
              </div><!-- col-3 -->              
              <div class="col-lg-8">
                <div class="form-group">
                  <label class="form-control-label">A disposición de:<span class="tx-danger">*</span></label>
                  <select class="form-control select2-show-search valid" id="disposicion" name="disposicion" autocomplete="off">
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
              <div class="col-lg-4">
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
              <div class="col-lg-6">
                <div class="form-group mg-b-10-force">
                  <label class="form-control-label">Beneficiario:</label>
                  <input class="form-control" type="text" name="beneficiario" id="beneficiario" value="" autocomplete="off">
                </div>
              </div><!-- col-3 -->
              <div class="col-lg-6">
                <div class="form-group mg-b-10-force">
                  <label class="form-control-label">Institución:<span class="tx-danger">*</span></label>
                  <input class="form-control" type="text" name="institucion" id="institucion" value="" autocomplete="off">
                </div>
              </div><!-- col-3 -->
            </div><!-- row -->
          </div>
          <div class="col-md-4 d-none" id="coldocs">
            <h6 class="slim-pagetitle mg-b-20">Documentos</h6>
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
        <div class="form-layout-footer d-flex">
          <button class="btn btn-primary bd-0 d-inline-block ml-auto" id="btnAgregarMovimiento" onclick="agregarMovimiento()">Agregar movimiento</button>
        </div><!-- form-layout-footer -->
      </div>
    @endif
  </div>
@endsection
@section('seccion-estilos')
  <link rel="stylesheet" type="text/css" href="{{asset("/css/dropzone.min.css")}}">
  <link href="{{asset("/lib/datatables/css/jquery.dataTables.css")}}" rel="stylesheet">
  <link rel="stylesheet" href="{{asset("css/chia/agregar_valor.css")}}">
  <style>
    .error{
      border : 1px solid red;
    }
    input{
      text-transform: uppercase;
    }
  </style>
@endsection
@section('seccion-scripts-libs')    
<script src="{{asset('/js/chia/agregar_valor.js')}}"></script>
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

  <div id="modalConfirmacion" class="modal fade" data-backdrop="static">
    <div class="modal-dialog modal-dialog-vertical-center" role="document" style="">
      <div class="modal-content bd-0 tx-14" style="min-width: 100%">
        <div class="modal-header">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">CONFIRMACIÓN DE REGISTRO DE VALOR</h6>
        </div>
        <div class="modal-body pd-25">
          <div class="row">
            <div class="col-12">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Folio:<span class="tx-danger">*</span></label>
                <input class="form-control" type="text" name="folio_confirmacion" id="folioConfirmacion" value=""  autocomplete="off" onpaste="return false;">
              </div>
            </div><!-- col-3 -->
            <div class="col-12">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Importe:<span class="tx-danger">*</span></label>
                <input class="form-control input-money" style="text-align: end" type="text" name="importe_confirmacion" id="importeConfirmacion" value="$" autocomplete="off">
              </div>
            </div><!-- col-3 -->
          </div>
        </div>
        <div class="modal-footer d-flex">
          <button type="button" class="btn btn-secondary mg-r-auto"  data-dismiss="modal" style="margin-right: auto;">Regresar</button>
          <button type="button" class="btn btn-primary mg-l-auto" onclick="registraValor()" data-dismiss="modal">Aceptar</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->

  <div id="modalSuccess" class="modal fade"  data-backdrop="static" data-keyboard="false" >
    <div class="modal-dialog" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-body tx-center pd-y-20 pd-x-20">
          <i class="icon ion-ios-checkmark-outline tx-100 tx-success lh-1 mg-t-20 d-inline-block"></i>
          <h6 class="tx-success tx-semibold mg-b-20">!Registrado!</h6>
          <p style="padding-left: 5vh; padding-right: 5vh;" id="modal-success-titulo"></p>
        </div><!-- modal-body -->
        <div class="modal-footer d-flex">
          <button type="button" class="btn btn-primary pd-x-25 mg-l-auto cerrar-modal" data-dismiss="modal"  data-thismodal="modalSuccess" id="btnCerrarSuccess" onclick="window.location.reload()">Aceptar</button>
        </div>
      </div><!-- modal-content -->
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
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->

@endsection