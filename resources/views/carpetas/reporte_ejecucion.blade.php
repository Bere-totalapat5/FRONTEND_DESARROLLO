@php
  use App\Http\Controllers\clases\utilidades;
@endphp

@extends('layouts.index')

{{-- Header --}}
@section('contenido-pageheader')
  <ol class="breadcrumb slim-breadcrumb">
     <li class="breadcrumb-item"><a href="javascript:void(0);">Carpetas Judiciales</a></li>
     <li class="breadcrumb-item"><a href="javascript:void(0);"> Reporte Ejecución</a></li>
  </ol>
  <h6 class="slim-pagetitle">  Reporte de Ejecución</h6>
@endsection
{{-- Estilos --}}
@section('seccion-estilos')
    <link href="{{asset("/lib/datatables/css/jquery.dataTables.css")}}" rel="stylesheet">
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
    <style>
      #ejecucionTable::-webkit-scrollbar {
        width: 8px;
        height: 9px;     
      }

      #ejecucionTable::-webkit-scrollbar-thumb {
          background: #ccc;
          border-radius: 4px;
      }

      #ejecucionTable::-webkit-scrollbar-thumb:hover {
          background: #b3b3b3;
          box-shadow: 0 0 2px 1px rgba(0, 0, 0, 0.2);
      }

      #ejecucionTable::-webkit-scrollbar-thumb:active {
          background-color: #999999;
      }

      #ejecucionTable::-webkit-scrollbar-track {
          background: #e1e1e1;
          border-radius: 4px;
      }
    
      #ejecucionTable::-webkit-scrollbar-track:hover,
      #ejecucionTable::-webkit-scrollbar-track:active {
        background: #d4d4d4;
      }  
      .input-ejec{
        width: 100%;
        border: none;
        background: #ebebeb;
        border-radius: 4px;
        padding: 7px;
      }

      .input-ejec:focus{
        outline: none;
      }

    </style>
@endsection

{{-- Contenido Principal --}}
@section('contenido-principal')
    <div class="section-wrapper" style="max-width: 100%;">
        <div class="form-layout">

          {{-- //Botones de descarga --}}
          <div class="d-flex justify-content-between" style="align-items: center;">
              <a style="border:1px solid #ccc; width: 70px; height: 45px;" data-toggle="collapse" data-parent="#accordion"
                  href="#collapseSearchAdvance" aria-expanded="false" aria-controls="collapseSearchAdvance"
                  class="btn btn-default">
                  <i class="fa fa-search" aria-hidden="true"></i>
                  <i class="fas fa-chevron-down" style="margin-left: 5%; font-size:0.7em;"></i>
              </a>
              <div class="row justify-content-end" style="width:80%;">
                  <input type="hidden" id="filtro_consulta" name="filtro_consulta" value="">
                  <div class="col-sm-4 col-md-3 col-lg-2 pd-t-10" aling="right">
                      <button onclick="descargar_r_ejecucion();" id="exportxls" class="btn btn-primary btn-sm btn-block " title="Exportar excel"><i class="fa fa-pdf mg-r-5"></i>Exportar Excel</button>
                  </div>
                  <div class="col-sm-1 col-md-1 col-lg-1 pd-t-10" aling="right">
                    <button onclick="sec_ajax('primera')" id="exportxls" style="padding: 7px 0;" class="btn btn-primary btn-sm btn-block " title="Refrescar Tabla"><i class="fas fa-sync-alt mg-r-5"></i></button>
                </div>
              </div>
          </div>

          {{-- //Filtros --}}
          <div id="accordion" class="accordion-one mg-b-20" role="tablist" aria-multiselectable="true">
              <div class="card" style="border:none;">

                  <div id="collapseSearchAdvance" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                      <div class="card-body">
                          <div class="row mg-b-25">

                              <div class="col-lg-4">
                                  <label class="form-control-label">Carpeta Judicial:</label>
                                  <div class="form-group">
                                     <input type="text" class="form-control" placeholder="Carpeta Judicial" id="capretaSearch">
                                  </div>
                              </div> 

                              <div class="col-lg-4">
                                  <div class="form-group">
                                      <label class="label">Fecha inicio (Desde): </label>
                                      <div class="input-group">
                                          <div class="input-group-prepend">
                                              <div class="input-group-text">
                                                  <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                              </div>
                                          </div>
                                          <input type="text" class="form-control fc-datepicker date" placeholder="DD-MM-AAAA" id="fechaini" name="" autocomplete="off">
                                      </div>
                                  </div>
                              </div>

                              <div class="col-lg-4">
                                <div class="form-group">
                                  <label class="label">Fecha fin (Hasta): </label>
                                  <div class="input-group">
                                      <div class="input-group-prepend">
                                          <div class="input-group-text">
                                              <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                          </div>
                                      </div>
                                      <input type="text" class="form-control fc-datepicker date" placeholder="DD-MM-AAAA" id="fechafin" name="" autocomplete="off">
                                  </div>
                                </div>
                              </div>

                          </div><!-- row -->
                          <div class="row">
                              <div class="col-lg-12">
                                  <button type="button" class="btn btn-primary btn-sm btn-block mg-b-10"
                                      data-toggle="collapse" data-target="#demo" onclick="sec_ajax('primera');">Filtrar</button>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>

          <!-- pagination-wrapper -->
          <div class="pagination-wrapper justify-content-between mg-b-20">
                <ul class="pagination mg-b-0">
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0);" onclick="sec_ajax('primera');" aria-label="Last">
                            <i class="fa fa-angle-double-left"></i>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0);" onclick="sec_ajax('atras');" aria-label="Next">
                            <i class="fa fa-angle-left"></i>
                        </a>
                    </li>
                </ul>
                <div id="texto_paginator">Página <span class="pagina_actual_texto">0</span> de <span
                        class="pagina_total_texto">0</span></div>
                <ul class="pagination mg-b-0">
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0);" onclick="sec_ajax('avanzar');" aria-label="Next">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0);" onclick="sec_ajax('ultima');" aria-label="Last">
                            <i class="fa fa-angle-double-right"></i>
                        </a>
                    </li>
                </ul>
          </div>


          <!--TABLA RESULTADOS BUSQUEDA -->
          <div id="table-ejecucion" class="mg-b-20">
              <table id="ejecucionTable" class="display dataTable dtr-inline collapsed d-block" style="overflow-x: auto; padding-left:0; padding-rigth:0" role="grid" aria-describedby="example_info">
                  <thead style="background-color: #EBEEF1; color: #000; text-align:center">
                    <tr>
                      <th colspan="4" style="padding:0; min-width: 940px !important;" name=""></th> 
                      <th colspan="3" style="padding:0; cursor:pointer; font-size: 0.84em; min-width: 150px  !important;" name="pena">Pena</th>
                      <th colspan="3" style="padding:0; min-width: 626px !important;" name=""></th> 
                      <th colspan="3" style="padding:0; cursor:pointer; font-size: 0.84em; min-width: 150px !important;" name="fecha_compurga">Fecha Compurga</th>
                      <th style="padding:0; min-width: 180px !important;" name=""></th> 
                      <th colspan="3" style="padding:0; cursor:pointer; font-size: 0.84em; min-width: 150px !important;" name="fecha_prescripcion">Fecha Prescripción</th>
                      <th style="padding:0; min-width: 180px !important;" name=""></th> 
                    </tr>
                    <tr>
                      <th style="cursor:pointer; font-size: 0.84em; min-width: 140px  !important;" name="carpeta_judicial">Carpeta de Ejecucion</th> 
                      <th style="cursor:pointer; font-size: 0.84em; min-width: 200px  !important;" name="sentenciado">Sentenciado</th>
                      <th style="cursor:pointer; font-size: 0.84em; min-width: 300px  !important;" name="victima">Victima</th>
                      <th style="cursor:pointer; font-size: 0.84em; min-width: 300px  !important;" name="delito">Delito</th>
                      <th style="cursor:pointer; font-size: 0.84em; min-width: 50px   !important;" name="anio_pena">Años</th>
                      <th style="cursor:pointer; font-size: 0.84em; min-width: 50px   !important;" name="meses_pena">Meses</th>
                      <th style="cursor:pointer; font-size: 0.84em; min-width: 50px   !important;" name="dias_pena">Dias</th>
                      <th style="cursor:pointer; font-size: 0.84em; min-width: 300px  !important;" name="interno_libre">Interno/Libre</th>
                      <th style="cursor:pointer; font-size: 0.84em; min-width: 180px  !important;" name="fecha_audiencia">Medida Alternativa a la prision</th>
                      <th style="cursor:pointer; font-size: 0.84em; min-width: 146px  !important;" name="tipo_audiencia">Beneficio Preliberacional</th>
                      <th style="cursor:pointer; font-size: 0.84em; min-width: 50px   !important;" name="anio_compurga">Años</th>
                      <th style="cursor:pointer; font-size: 0.84em; min-width: 50px   !important;" name="meses_compurga">Meses</th>
                      <th style="cursor:pointer; font-size: 0.84em; min-width: 50px   !important;" name="dias_compurga">Dias</th>
                      <th style="cursor:pointer; font-size: 0.84em; min-width: 180px  !important;" name="imputados">Orden de Reaprehensión</th>
                      <th style="cursor:pointer; font-size: 0.84em; min-width: 50px   !important;" name="anio_prescripcion">Año</th>
                      <th style="cursor:pointer; font-size: 0.84em; min-width: 50px   !important;" name="meses_prescripcion">Mes</th>
                      <th style="cursor:pointer; font-size: 0.84em; min-width: 50px   !important;" name="dias_prescripcion">Dia</th>
                      <th style="cursor:pointer; font-size: 0.84em; min-width: 180px  !important;" name="extincion">Extinción</th>
                    </tr>
                  </thead>
                  <tbody id="body-tableEjecucion" class="items-agregados" style="width: 100%; text-align: center; font-size: 0.84em;">
                    <tr>
                      <td colspan="17">No existen datos relacionados</td>
                    </tr>
                  </tbody>
              </table>
          </div>

          <!-- pagination-wrapper -->
          <div class="pagination-wrapper justify-content-between">
              <ul class="pagination mg-b-0">
                  <li class="page-item">
                      <a class="page-link" href="javascript:void(0);" onclick="sec_ajax('primera');" aria-label="Last">
                          <i class="fa fa-angle-double-left"></i>
                      </a>
                  </li>
                  <li class="page-item">
                      <a class="page-link" href="javascript:void(0);" onclick="sec_ajax('atras');" aria-label="Next">
                          <i class="fa fa-angle-left"></i>
                      </a>
                  </li>
              </ul>
              <div id="texto_paginator">Página <span class="pagina_actual_texto">0</span> de <span
                      class="pagina_total_texto">0</span></div>
              <ul class="pagination mg-b-0">
                  <li class="page-item">
                      <a class="page-link" href="javascript:void(0);" onclick="sec_ajax('avanzar');" aria-label="Next">
                          <i class="fa fa-angle-right"></i>
                      </a>
                  </li>
                  <li class="page-item">
                      <a class="page-link" href="javascript:void(0);" onclick="sec_ajax('ultima');" aria-label="Last">
                          <i class="fa fa-angle-double-right"></i>
                      </a>
                  </li>
              </ul>
          </div><!-- pagination-wrapper -->

        </div>

        <input type="hidden" id="pagina_actual" name="pagina_actual" value="1">
        <input type="hidden" id="paginas_totales" name="paginas_totales" value="1">
        <input type="hidden" id="numeropagina">

    </div>

@endsection


{{-- modales de exito y error --}}
<div id="modalSuccess" class="modal fade"  data-backdrop="static" data-keyboard="false" style="display: none">
    <div class="modal-dialog" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-body tx-center pd-y-20 pd-x-20">
          <i class="icon ion-ios-checkmark-outline tx-100 tx-success lh-1 mg-t-20 d-inline-block"></i>
          <h4 class="tx-success tx-semibold mg-b-20">Hecho!</h4>
          <div id="messageExito">
          </div>
        </div><!-- modal-body -->
        <div class="modal-footer d-flex">
          <button type="button" class="btn btn-primary pd-x-25 mg-l-auto" data-dismiss="modal" aria-label="Close" >Aceptar</button>
        </div>
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div>

<div id="modalError" class="modal fade" style="display: none">
    <div class="modal-dialog" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-body tx-center pd-y-20 pd-x-20">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <i class="icon icon ion-ios-close-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block "></i>
          <div id="messageError" class="mg-b-20">
          </div>
          <button type="button" class="btn btn-danger pd-x-25" data-dismiss="modal" aria-label="Close">Aceptar</button>
        </div><!-- modal-body -->
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->

<div id="modalWarning" class="modal fade"  data-backdrop="static" data-keyboard="false" style="display: none">
    <div class="modal-dialog" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-body tx-center pd-y-20 pd-x-20">
          <i class="icon ion-warning-outline tx-100 tx-warning lh-1 mg-t-20 d-inline-block"></i>
          <h4 class="tx-warning tx-semibold mg-b-20">Advertencia!</h4>
          <div>
            Hay Campos vacios
          </div>
        </div><!-- modal-body -->
        <div class="modal-footer d-flex">
          <button type="button" class="btn btn-primary pd-x-25 mg-l-auto" data-dismiss="modal" aria-label="Close" >Aceptar</button>
        </div>
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div>

<div id="loader" class="modal fade"  data-backdrop="static" data-keyboard="false" style="display: none">
  <div class="modal-dialog" role="document">
    <div class="modal-content tx-size-sm">
      <div class="modal-body tx-center pd-y-20 pd-x-20" style="background: rgba(0,0,0,0.7);">
        <h5 style="color:#fff;">Consultando Reporte</h5>
        <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
      </div>
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div>

{{-- Scripts librerias --}}
@section('seccion-scripts-libs')
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/jquery-ui/js/jquery-ui.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/datatables/js/jquery.dataTables.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/datatables-responsive/js/dataTables.responsive.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/select2/js/select2.min.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/moment/js/moment.js"></script>
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
     <script src="https://cdn.datatables.net/colreorder/1.5.3/js/dataTables.colReorder.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">
@endsection

{{-- Scripts --}}
@section('seccion-scripts-functions')
  <script>

    var idf_unidad_ge = @php echo json_encode($request->session()->get('id_unidad_gestion')); @endphp;
    var clave = '';
    var combo_unidades = '';
    console.log(idf_unidad_ge);

    switch(idf_unidad_ge){
      case 12:
        clave = '001';
        break;
      case 13:
        clave = '002';
        break;
      case 14:
        clave = '003';
        break;
      case 15:
        clave = '004';
        break;
      case 16:
        clave = '005';
        break;
      case 17:
        clave = '006';
        break;
      case 18:
        clave = '007';
        break;
      case 19:
        clave = '008';
        break;
      case 32:
        clave = '209';
        break;
      case 31:
        clave = '010';
        break;
      case 30:
        clave = '011';
        break;
      case 34:
        clave = '012';
        break;
      case 33:
        clave = '301';
        break;
    }

    $(function(){
        //select
        $('.date').datepicker({
          showOtherMonths: true,
          selectOtherMonths: true,
          dateFormat: 'yyyy-mm-dd'
        });

        //Loader
        setTimeout(function(){
          $('#modal_loading').modal('hide');
        }, 1000);

        $.ajax({
            type: 'POST',
            url: '/public/obtener_unidades',
            data: {

            },

            success: function(response) {

                console.log(response);

                if (response.status == 100) {
                    let unidades = response.response;
                    combo_unidades = unidades;
                    var option = '';
                    for(i = 0; i<unidades.length; i++){
                      var option = option + `<option value="${unidades[i].id_unidad_gestion}"> ${unidades[i].nombre_unidad} </option>`;
                    }

                    $('#idunidad').html(`<option selected disabled value="">Elija una opción</option> <option value=""> TODAS LAS UNIDADES </option>` + option);
                }
            }
        });

        sec_ajax();
        //hScroll(60);
    });

    //desaparecer un elemento pulsando en cualquier lado de la pantalla
    $(document).on("click",function(e) {
                    
      var container = $("#raf");
                         
         if (!container.is(e.target) && container.has(e.target).length === 0) { 
          $('#ver_libertades').removeClass('expadir');
          $('#datos_adicionales').removeClass('responsive_tabla_libertades');
          $('#ver_libertades').html('');
          $("#raf").attr('data-open', 0);  
         }
    });

    //Aqui las function
    function descargar_r_ejecucion(){
        var inicio = get_date($('#fechaini').val());
        var final = get_date($('#fechafin').val());
        var carpeta = $('#capretaSearch').val();

        $.ajax({
          type:'POST',
          url:'/public/descargar_r_ejecucion',
          data:{
            fecha_inicio: inicio,
            fecha_final:final,
            carpeta: carpeta,
          },
          beforeSend: function(){
            $('#exportxls').html('Consultando...');
            $('#exportxls').prop('disabled', true);
            loading(true);
          },
          success:function(response) {
              console.log(response);
              if(response.status==100){
                $('#exportxls').html('Exportar Excel');
                window.open(response.response);
                $('#exportxls').prop('disabled', false);
                loading(false);
              }else{
                  error(response.message);
                  $('#exportxls').html('Exportar Excel');
                  loading(false);
              }
          }
        }); 
        
    }

    function sec_ajax(pagina_accion) {

      $(document).ready(function() {
          $(".nav-tabs a").click(function() {
              $(this).tab('show');
          });
      });

      let body = "";

      pagina = parseInt($('#pagina_actual').val());
      registros_por_pagina = 10;

      if (pagina_accion == "primera") {
          pagina = 1;
      } else if (pagina_accion == "avanzar") {
          pagina = pagina + 1;
      } else if (pagina_accion == "atras") {
          pagina = pagina - 1;
      } else if (pagina_accion == "ultima") {
          pagina = $('#paginas_totales').val();
      }

      if (pagina <= 0 || pagina > $('#paginas_totales').val()) {

      } else {
          $('#pagina_actual').val(pagina);
          $('#numeropagina').val(pagina);
          $('.pagina_actual_texto').html(pagina);

          let id_solicitud = "";

          //cambio formato de fecha
          var fechaini = get_date($("#fechaini").val());
          var fechafin = get_date($("#fechafin").val());
          var carpeta = $('#capretaSearch').val();
          
          $.ajax({
              type: 'POST',
              url: '/public/consulta_reporte_Ejecucion',
              data: {
                  carpeta: carpeta,
                  fecha_ini: fechaini,
                  fecha_fin: fechafin,
                  pagina: $('#numeropagina').val(),
                  registros_por_pagina: 10,
              },
              success: function(response) {
                console.log(response);
                  if (response.status == 100) {
                      var datos = response.response;
                      var html = '';
                      console.log(datos);
                      
                      for(i  in datos){

                        fecha_prescripcion = datos[i].fecha_prescripcion == '' ? ' - - ' : datos[i].fecha_prescripcion.split('-');
                        fecha_compurga = datos[i].fecha_compurga == '' ? ' - - ' :  datos[i].fecha_compurga.split('-');
                        
                        var estatus_imputado = '';
                        if(datos[i].imputados.length > 0){
                          switch (datos[i].imputados[0].estatus_imputado){
                            case 1:
                              estatus_imputado = 'ACTIVO';
                            break;
                            case 26:
                              estatus_imputado = 'LIBRE';
                            break;
                            case 27:
                              estatus_imputado = 'INTERNO';
                            break;
                            case 28:
                              estatus_imputado = 'DEFUNCION';
                            break;
                          }
                        }

                        var readonly = '';
                        var id_persona = 0;
                        var estilo = '';
                        if(datos[i].imputados.length){  
                          if(datos[i].imputados[0].id_persona > 0){
                            id_persona = datos[i].imputados[0].id_persona;
                            readonly = '';
                          }else{
                            readonly = 'readonly';
                          }

                          if(datos[i].imputados[0].medida_alternativa_prision != null || datos[i].imputados[0].beneficio_preliberacional != null || datos[i].imputados[0].extincion != null  ){
                            estilo = 'style="background: #848F33; color: #fff"';
                          }else{
                            estilo = '';
                          }

                        }else{
                          readonly ='readonly'
                        }

                        html += `<tr>
                                  <td style="font-size: 0.9em;" >${datos[i].folio_carpeta}</td>
                                  <td style="font-size: 0.9em;" >${datos[i].imputados.length > 0 ? datos[i].imputados[0].nombre : 'N/A' }</td>
                                  <td style="font-size: 0.9em;" >${datos[i].victimas.length > 0 ? datos[i].victimas[0].nombre : 'N/A'}</td>
                                  <td style="font-size: 0.9em;" >${datos[i].delitos.length > 0 ? datos[i].delitos[0].delito : 'N/a'}</td>
                                  <td style="font-size: 0.9em;" >${datos[i].pena.length > 0 ? datos[i].pena[0].anios_por_cumplir : '0'}</td>
                                  <td style="font-size: 0.9em;" >${datos[i].pena.length > 0 ? datos[i].pena[0].meses_por_cumplir : '0'}</td>
                                  <td style="font-size: 0.9em;" >${datos[i].pena.length > 0 ? datos[i].pena[0].dias_por_cumplir : '0'}</td>
                                  <td style="font-size: 0.9em;" >${estatus_imputado}</td>
                                  <td style="font-size: 0.9em;" ><input type="text" ${readonly} ${estilo} campo ="medida_alternativa_prision" persona="${id_persona}" value="${datos[i].imputados.length > 0 ? (datos[i].imputados[0].medida_alternativa_prision == null ? '' : datos[i].imputados[0].medida_alternativa_prision) : '' }" class="input-ejec medida_alternativa" onchange="saveData(this)"></td>
                                  <td style="font-size: 0.9em;" ><input type="text" ${readonly} ${estilo} campo ="beneficio_preliberacional" persona="${id_persona}" value="${datos[i].imputados.length > 0 ? (datos[i].imputados[0].beneficio_preliberacional == null ? '' : datos[i].imputados[0].beneficio_preliberacional) : '' }" class="input-ejec beneficio" onchange="saveData(this)"></td>
                                  <td style="font-size: 0.9em;" >${fecha_compurga[0]}</td>
                                  <td style="font-size: 0.9em;" >${fecha_compurga[1]}</td>
                                  <td style="font-size: 0.9em;" >${fecha_compurga[2]}</td>
                                  <td style="font-size: 0.9em;" >${datos[i].orden_reaprehension}</td>
                                  <td style="font-size: 0.9em;" >${fecha_prescripcion[0]}</td>
                                  <td style="font-size: 0.9em;" >${fecha_prescripcion[1]}</td>
                                  <td style="font-size: 0.9em;" >${fecha_prescripcion[2]}</td>
                                  <td style="font-size: 0.9em;" ><input type="text" ${readonly} ${estilo} campo ="extincion" persona="${id_persona}" value="${datos[i].imputados.length > 0 ? (datos[i].imputados[0].extincion == null ? '' : datos[i].imputados[0].extincion) : '' }" class="input-ejec extinsion" onchange="saveData(this)"></td>
                                </tr>
                              `;
                      }
                      $('#body-tableEjecucion').html(html);

                      $('.pagina_total_texto').html(response.response_paginacion['paginas_totales']);
                      $('#paginas_totales').val(response.response_paginacion['paginas_totales'])

                  } else {
                      let body = `<tr><td colspan="19">Sin referencia de Datos</td></tr>`;
                      $("#body-tableEjecucion").html(body);
                  }
              }
          });
          
      }
    } 

    function saveData(obj){
      var valor = $(obj).val();
      var id_persona = $(obj).attr('persona');
      var campo = $(obj).attr('campo');

      $(obj).css('background', '#DCDFCB');
      

      $.ajax({
        type: 'POST',
        url: '/public/guardarCamposEjecucion',
        data: {
          dato: valor,
          persona: id_persona,
          campo: campo
        },
        success: function(response) {
            console.log(response);
            if(response.status == 100){
              if(valor.length == ''){
                $(obj).css('background', '#efefef');
                $(obj).css('color', '#444');
              }else{
                $(obj).css('background', '#848F33'); 
                $(obj).css('color', '#fff');
              }
            }else{
              $(obj).css('background', '#CB4335');
              $(obj).css('color', '#fff'); 
            }
        }
      });

    }


    //Auto llenado

    function loader(accion){
      if(accion){
        $('#loader').modal('show');
      }else{
        setTimeout(function(){ $('#loader').modal('hide'); }, 500);
      }
    }

    function loading(accion){
      if(accion){
        $('#modal_loading').modal('show');
      }else{
        setTimeout(function(){ $('#modal_loading').modal('hide'); }, 500);
      }
    }

    function get_date(date, format = 'YYYY-MM-DD') {
      if (format == 'YYYY-MM-DD' && date.substring(0, 4).includes('-'))
          return date.split('-').reverse().join('-');
      if (format == 'DD-MM-YYYY' && !date.substring(0, 4).includes('-'))
          return date.split('-').reverse().join('-');
      else
          return date;
    }
  
  </script>
@endsection



