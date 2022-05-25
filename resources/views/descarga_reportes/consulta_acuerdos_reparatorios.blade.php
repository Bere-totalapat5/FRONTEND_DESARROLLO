@php
  use App\Http\Controllers\clases\humanRelativeDate;
  use App\Http\Controllers\clases\utilidades;
  $humanRelativeDate = new humanRelativeDate();
@endphp

@extends('layouts.index')

{{-- Header --}}
@section('contenido-pageheader')
  <ol class="breadcrumb slim-breadcrumb">
     <li class="breadcrumb-item"><a href="javascript:void(0);">Reportes</a></li>
     <li class="breadcrumb-item"><a href="javascript:void(0);"> Busqueda acuerdos reparatorios</a></li>
  </ol>
  <h6 class="slim-pagetitle">  Acuerdos Reparatorios</h6>
@endsection
{{-- Estilos --}}
@section('seccion-estilos')
    <link href="{{asset("/lib/datatables/css/jquery.dataTables.css")}}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
    <style>
      .empty{
        background: #ebebeb;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        min-height: 400px;
        margin: 1% 0;
        color: #ccc;
        font-size: 5.4em;
        width: 100%;
      }
      .resultado{
        display: flex;
        justify-content: flex-start;
        height: 250px;
        margin: 1% 0;
        padding: 0 1%;
        width: 100%;
        min-width: 2386px;
      }
      .resultado:hover{
        background: #e6e7df;
      }
    </style>
@endsection

{{-- Contenido Principal --}}
@section('contenido-principal')
    <div class="section-wrapper" style="max-width: 100%;">
      @if(!utilidades::buscarPermisoMenu($request->menu_general['response'], 65, 0))
        <h1 class="mg-b-50">No tiene permiso para acceder a esta sección, verifíquelo con su titular</h1>
        <a href="/home"><button class="btn btn-primary btn-block">Regresar al inicio</button><a>
      @else
        <div class="form-layout" style="position: relative;">
          <div class="row justify-content-between">

            <div class="col-md-5">
              <form action="" autocomplete="off">
                <div class="form-group" style="width: 75%; float: left;">
                  <label>Imputado</label>
                  <input type="text" class="form-control" autocomplete="off" id="imputado_se" placeholder="Nombre Imputado" >
                </div>
              </form>
              <div class="form-group" style="float: left; display: flex; justify-content: center; align-items: center; height: 100%; margin-left: 2%; padding-top: 2.4%;">
                <a href="javascript:void(0);" class="btn btn-outline-secondary"  title="Buscar" onclick="buscarPersonaAcuerdo('primera');"><i class="fas fa-search"></i></a>
                <a href="javascript:void(0);" class="btn btn-outline-secondary" title="Limpiar Busqueda" onclick="limpiarEspacio();" style="margin-left: 6%;"><i class="fas fa-sync"></i></a>
              </div>
            </div>

            <div class="col-md-7" style="display: flex; justify-content: flex-end;">
              <div class="col-sm-12 col-md-6 col-lg-7 pd-t-10" aling="right">
                <a href="javascript:void(0);" onclick="descargar_acuerdo(0);" class="btn btn-primary btn-sm btn-block "><i class="fa fa-file-alt mg-r-5"></i> Generar informe de NO existencia de acuerdo</a>
                <a href="javascript:void(0);" onclick="descargar_acuerdo(1);" class="btn btn-primary btn-sm btn-block "><i class="fa fa-file-alt mg-r-5"></i> Generar informe de existencia de acuerdo</a>
              </div>
            </div>

          </div>

          <div id="resultados" style="overflow: auto;">
            <div class="empty">
              <i class="fas fa-users"></i>
              <p style="font-size: 0.5em;">Realice una busqueda</p>
            </div>
          </div>

          <!-- pagination-wrapper -->
          <div class="pagination-wrapper justify-content-between">
              <ul class="pagination mg-b-0">
                  <li class="page-item">
                      <a class="page-link" href="javascript:void(0);" onclick="buscarPersonaAcuerdo('primera');" aria-label="Last">
                          <i class="fa fa-angle-double-left"></i>
                      </a>
                  </li>
                  <li class="page-item">
                      <a class="page-link" href="javascript:void(0);" onclick="buscarPersonaAcuerdo('atras');" aria-label="Next">
                          <i class="fa fa-angle-left"></i>
                      </a>
                  </li>
              </ul>
              <div id="texto_paginator">Página <span class="pagina_actual_texto">0</span> de <span
                      class="pagina_total_texto">0</span></div>
              <ul class="pagination mg-b-0">
                  <li class="page-item">
                      <a class="page-link" href="javascript:void(0);" onclick="buscarPersonaAcuerdo('avanzar');" aria-label="Next">
                          <i class="fa fa-angle-right"></i>
                      </a>
                  </li>
                  <li class="page-item">
                      <a class="page-link" href="javascript:void(0);" onclick="buscarPersonaAcuerdo('ultima');" aria-label="Last">
                          <i class="fa fa-angle-double-right"></i>
                      </a>
                  </li>
              </ul>
          </div><!-- pagination-wrapper -->

        </div>

        <input type="hidden" id="pagina_actual" name="pagina_actual" value="1">
        <input type="hidden" id="paginas_totales" name="paginas_totales" value="1">
        <input type="hidden" id="numeropagina">
      @endif
    </div>

@endsection

{{-- Scripts librerias --}}
@section('seccion-scripts-libs')
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/jquery-ui/js/jquery-ui.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/datatables/js/jquery.dataTables.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/datatables-responsive/js/dataTables.responsive.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/select2/js/select2.min.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/moment/js/moment.js"></script>
     <script src="https://cdn.datatables.net/colreorder/1.5.3/js/dataTables.colReorder.min.js"></script>
@endsection

{{-- Scripts --}}
@section('seccion-scripts-functions')
  <script>
    const unidades_precargadas = @php echo json_encode($unidades);@endphp;
    const inmuebles_precargados = @php echo json_encode($inmuebles);@endphp;
    var id_unidad_sesion = @php echo json_encode($request->session()->get('id_unidad_gestion')); @endphp;

    var auerdos_arr = [];

    $(function(){
        //select
        $('.select2').select2();
        
        //Loader
        setTimeout(function(){
          $('#modal_loading').modal('hide');
        }, 1000);

        console.log('unidades', unidades_precargadas);
        console.log('inmuebles', inmuebles_precargados);  
    });

    function buscarPersonaAcuerdo(pagina_accion) {
      loading(true);

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


          var nombre = $("#imputado_se").val();

          console.log('id_unidad_sesion',id_unidad_sesion);

          if(nombre.length < 1){
            error('Debe escribir un nombre para realizar la busqueda');
          }else{
            
            var resultado = ``;

            auerdos_arr.length = 0;

            $.ajax({
                type: 'GET',
                url: '/public/buscar_acuerdos_reparatorios',
                data: {
                    nombre: nombre,
                    id_unidad: id_unidad_sesion == 0 ? '-' : id_unidad_sesion,
                    pagina: $('#numeropagina').val(),
                    registros_por_pagina: 30,
                },
                success: function(response) {
                    console.log(response);
                    if(response.status == 100) {
                        //$("#imputado_se").val('');
                        loading(false);
                        var datos = response.response;
                        var resultado = ``;


                        for(i = 0; i < datos.length; i++){

                          auerdos_arr.push({
                            "nombre":datos[i].nombre.toUpperCase(),
                            "id_audiencia": datos[i].id_audiencia,
                            "id_audiencia_acuerdo": datos[i].id_audiencia_acuerdo_reparatorio,
                            "estatus":0
                          });

                          let documento = '';
                          if(datos[i].documento != null){
                            documento = `<a style="font-size: 1em; cursor: pointer;"  href="javascript:void(0);" onclick="verDocumentoAcueRep(${datos[i].documento}, ${datos[i].id_audiencia}, 'acuerdo_reparatorio')"><i class="fas fa-file-pdf" style="font-size: 1.4em; color:#e11b1b;"></i> Ver Documento</a>`;
                          }else{
                            documento = '(Sin documentos asociados)';
                          }

                          resultado += `
                            <div class="resultado">
                              
                              <div style="min-width: 275px; border: 1px solid #eee; height: auto; display: flex; justify-content: center; flex-direction: column; position:relative;">
                                <input style="position: absolute;top: 3%;left: 2%;" type="checkbox" value="${i}" id="acuerdo_${i}" onchange="addAcuerdo(this, ${i})">
                                <div style="color: #848f33; font-weight: bold; font-size: 2.9em; text-align: center; text-transform: uppercase;">
                                  <i class="fa fa-user"></i>
                                </div>
                                <div style="text-align: left; width: 100%; padding-left: 6%; font-weight: bold; color: #bbb7b7; font-size: 0.8em;">Imputado</div>
                                <div style="font-weight:bold; font-size:0.9em; text-align:center; text-transform:uppercase;">${datos[i].nombre}</div>

                                <div style="margin-top: 12%; font-weight:bold; font-size:0.72em; padding-left: 3%; text-align:left;">Unidad: ${datos[i].unidad ?? ""}</div>
                                <div style="font-weight:bold; font-size:0.72em; padding-left: 3%; text-align:left;">Usuario Responsable: ${datos[i].usuario_creador ?? ""}</div>
                              </div>
              
                              <div style="min-width: 420px;">
                                <table class="table" style="border: 1px solid #eee; height: 100%;">
                                  <tr>
                                    <td>Carpeta Judicial</td>
                                    <td style="border-right: 2px solid #848f33;">${datos[i].folio_carpeta ?? ""}</td>
                                  </tr>
                                  <tr>
                                    <td>Tipo Cumplimiento</td>
                                    <td style="border-right: 2px solid #848f33;">${datos[i].tipo_cumplimiento ?? ""}</td>
                                  </tr>
                                  <tr>
                                    <td>Acuerdo aprobado</td>
                                    <td style="border-right: 2px solid #848f33;">${datos[i].aprueba_acuerdo ?? ""}</td>
                                  </tr>
                                  <tr>
                                    <td>Fecha de extinción de la acción penal</td>
                                    <td style="border-right: 2px solid #848f33;">${datos[i].fecha_extincion ?? "Sin fecha"}</td>
                                  </tr>
                                </table>
                              </div>
              
                              <div style="min-width: 480px;">
                                <table class="table" style="border: 1px solid #eee; height: 100%;">
                                  <tr>
                                    <td>Situacion</td>
                                    <td style="border-right: 2px solid #848f33;">${datos[i].inactividad == 1 ? '<span style="color:#3aad3a; font-weight: bold;">Activo</span>' : '<span style="color:#e11b1b; font-weight: bold;">Inactivo</span>'}</td>
                                  </tr>
                                  <tr>
                                    <td>Delito</td>
                                    <td style="border-right: 2px solid #848f33;">${datos[i].delito}</td>
                                  </tr>
                                  <tr>
                                    <td>Victimas</td>
                                    <td style="border-right: 2px solid #848f33;">${datos[i].victimas}</td>
                                  </tr>
                                  <tr>
                                    <td>Documentos de acuerdo</td>
                                    <td style="border-right: 2px solid #848f33;">${documento}</td>
                                  </tr>
                                </table>
                              </div>

                              <div style="min-width: 600px;">
                                <table class="table" style="border: 1px solid #eee; height: 100%;">
                                  <tr>
                                    <td style="min-width: 170px;">Resumen del acuerdo</td>
                                    <td style="border-right: 2px solid #848f33;"><div style="height: 100%;overflow:auto;">${datos[i].resumen_acuerdo ?? ""}</div></td>
                                  </tr>
                                </table>
                              </div>

                              <div style="min-width: 600px;">
                                <table class="table" style="border: 1px solid #eee; height: 100%;">
                                  <tr>
                                    <td style="min-width: 170px;">Comentarios adicionales</td>
                                    <td style="border-right: 2px solid #848f33;"><div style="height: 100%;overflow:auto;">${datos[i].comentarios_adicionales ?? "(Sin comentarios)"}</div></td>
                                  </tr>
                                </table>
                              </div>
              
                            </div>  
                          `;
                        }


                        $('#resultados').html(resultado);
                        $('.pagina_total_texto').html(response.response_pag['paginas_totales']);
                        $('#paginas_totales').val(response.response_pag['paginas_totales'])

                    } else {
                      let body = `<div class="empty">
                        <i class="fas fa-users"></i>
                        <p style="font-size: 0.5em;">Lo sentimos, no encontramos datos relacionados</p>
                      </div>`;

                      $('#resultados').html(body);
                    }
                }
            });
            
          }
      }
    } 
    
    function descargar_acuerdo(existencia){

      var datos = [];
      let ids = [];
      let ids_acuerdos = '';

      if(existencia == 1){
        for(i in auerdos_arr){
          if(auerdos_arr[i].estatus == 1){
            ids.push(auerdos_arr[i].id_audiencia_acuerdo);
          }
        }

        if(ids.length > 0){
          ids_acuerdos = ids.join();
        }
      }

      if(existencia == 1 && ids.length <= 0  ) return error('Lo sentimos de seleecionar al menos a un imputado');
      
      
      var data = {
        existencia: existencia,
        nombre: $('#imputado_se').val(),
        ids_acuerdos: ids_acuerdos,
      }

      console.log('Datos',data);

      
      $.ajax({
        type: 'POST',
        url: '/public/informe_existencia_acuerdo',
        data:data,
        beforeSend: function(){
          loading(true);
        },
        success:function(response) {
          console.log(response);
          if(response.status==100){
            window.open(response.response);
            loading(false);
          }else{
            error(response.response);
            loading(false);
          }
        }
      }); 
      
    }
    
    function addAcuerdo(obj, __index__){
      var info = auerdos_arr[__index__];

      if($(obj).is(':checked')){
        auerdos_arr[__index__].estatus = 1;
        if(  $('#imputado_se').val().length <= 0)
          $('#imputado_se').val(info.nombre);
      }else{
        auerdos_arr[__index__].estatus = 0;
      }

    }

    function verDocumentoAcueRep(id_acuerdo, id_audiencia, tipo){
      $('#visorPDFdocumento').html('');

      $.ajax({
        type:'GET',
        url:'/public/obtener_documento_resolutivo',
        data:{
          id_audiencia:id_audiencia,
          id_acuerdo:id_acuerdo,
          tipo:tipo
        },
        success:function(response) {
          if(response.status ==100){
            console.log(response.response);

            pdf = `<embed src="${response.response}" type="application/pdf" width="100%" height="600px" />`;
            $('#visorPDFdocumento').html(pdf);

          }else{
            pdf = `<div style="height: 600px;background: #444;display: flex;justify-content: center;align-items: center;flex-direction: column;font-size: 1.2em;;">
              <i class="fa fa-file-pdf" style="color: #fff;font-size: 1.1em;margin-right: 3%;margin-bottom: 2%;font-size: 4em;"></i>
              Sin Documento PDF
            </div>`;

            $('#visorPDFdocumento').html(pdf);
          }
        }
      });

      $('#modal-res-documento').modal('show');
      
    }

    function limpiarEspacio(){
      $('#resultados').html(`
        <div class="empty">
          <i class="fas fa-users"></i>
          <p style="font-size: 0.5em;">Realice una busqueda</p>
        </div>
      `);
    }


    // ########## FUNCIONES GENERALES  ##############

    function get_date( date , format = 'YYYY-MM-DD' ){
      if( format == 'YYYY-MM-DD' && date.substring(0,4).includes('-') ) 
        return date.split('-').reverse().join('-');
      if( format == 'DD-MM-YYYY' && !date.substring(0,4).includes('-') )
        return date.split('-').reverse().join('-');
      if( format == 'YYYY-MM-DD' && date.substring(0,4).includes('/') ) 
        return date.split('-').reverse().join('-');
      if( format == 'DD-MM-YYYY' && !date.substring(0,4).includes('/') )
        return date.split('-').reverse().join('-');
      else
        return date;
    }

    function success(mensaje){
      $('#messageExito').html(mensaje);
      $('#modalSuccess').modal('show');
    }

    function error(mensaje){
      $('#messageError2').html(mensaje);
      $('#modalError2').modal('show');
    }

    function modal_error(mensaje,modalAnterior=null){
      $('#messageError').html(`${mensaje}`);
      $('#btnCerrarError').attr('data-modal',modalAnterior!=null?modalAnterior:'');
      if( modalAnterior!=null ) $('#'+modalAnterior).modal('hide');
      $('#modalError').modal('show');
    }

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

    function cerrar_modal(valor){
      $("#"+valor).modal('hide');
    }


  </script>
@endsection


@section('seccion-modales')

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

  <div id="modalError" class="modal fade" data-backdrop="static" data-keyboard="false" style="display: none;">
    <div class="modal-dialog" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-body tx-center pd-y-20 pd-x-20">
          <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button> -->
          <i class="icon icon ion-ios-close-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
          <h4 class="tx-danger mg-b-20">Datos incompletos</h4>
          <p class="mg-b-20 mg-x-20" id="messageError"></p>
          <button type="button" class="btn btn-danger pd-x-25 cerrar-modal" data-modal="" data-thismodal="modalError" id="btnCerrarError">Aceptar</button>
        </div><!-- modal-body -->
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
  </div><!-- modal -->

  <div id="modalError2" class="modal fade" data-backdrop="static" data-keyboard="false" style="display: none;">
    <div class="modal-dialog" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-body tx-center pd-y-20 pd-x-20">
          <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button> -->
          <i class="icon icon ion-ios-close-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
          <h4 class="tx-danger mg-b-20">Datos incompletos</h4>
          <p class="mg-b-20 mg-x-20" id="messageError2"></p>
          <button type="button" class="btn btn-danger pd-x-25"  data-dismiss="modal" id="btnCerrarError">Aceptar</button>
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

  <div id="modal-res-documento" class="modal fade" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-vertical-center modal-xl" role="document" style="min-width: 70%;">
      <div class="modal-content bd-0 tx-14" >
        <div class="modal-header">
            <h6 class="tx-12 mg-b-0 tx-uppercase tx-inverse tx-bold">Documentos</h6>
            <button type="button" class="close ml-auto" data-dismiss="modal" aria-label="Close">
                <span aling="right" aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" style="text-align: center;">
            <div class="row">
                <div class="col-md-12" id="visorPDFdocumento">

                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" >Cerrar</button>
        </div>
      </div>
    </div>
  </div>

@endsection

