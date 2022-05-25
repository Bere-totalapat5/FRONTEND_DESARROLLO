@php
  use App\Http\Controllers\clases\utilidades;
@endphp

@extends('layouts.index')

{{-- Header --}}
@section('contenido-pageheader')
  <ol class="breadcrumb slim-breadcrumb">
     <li class="breadcrumb-item"><a href="javascript:void(0);">Reportes</a></li>
     <li class="breadcrumb-item"><a href="javascript:void(0);"> Informes DEGJ</a></li>
  </ol>
  <h6 class="slim-pagetitle">Informes de Desempeño</h6>
@endsection

{{-- Estilos --}}
@section('seccion-estilos')
    <link href="{{asset("/lib/datatables/css/jquery.dataTables.css")}}" rel="stylesheet">
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
    <style>
      .accion{
        width: 100%;
        background: #eee;
        height: 40vh;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #bbb;
        font-size: 1.9em;
      }
      .select2-container.select2-container--default.select2-container--open{
          z-index: 1050 !important;
      }

    </style>
@endsection

{{-- Contenido Principal --}}
@section('contenido-principal')
    <div class="section-wrapper" style="max-width: 100%;">
        <div class="form-layout">

          {{-- //Botones de descarga --}}
          <div class="row justify-content-between mg-b-20" style="align-items: center;">
              
              <div class="form-group col-lg-4">
                <label for="exampleFormControlInput1">Tipo de informe:</label>
                <select class="form-control select2" onchange="buscarPor(this)">
                  <option value="blanco" selected>Selecciona una opcion</option>
                  <option value="audi">Audiencias</option>
                  <option value="oug">Operación en unidades de Gestión</option> 
                  {{--  <option value="icjr">Estadisticas Generales</option>  --}}
                </select>
              </div>
              
              {{-- 
                <div class="form-group col-lg-2 justify-content-end">
                  <button onclick="descargar_reporte_seleccionado();" id="exportxls" class="btn btn-primary btn-sm btn-block " title="Exportar excel"><i class="fa fa-pdf mg-r-5"></i>Exportar Excel</button>
                </div>
              --}}
              <div class="col-lg-7" style="align-items: center; display: flex;" id="tipoInforme"></div>
          </div>

          <div class="row" style="padding-left:1%;">
            <h5 id="titulo_seccion"></h5>
          </div>

          <div class="row" id="visorGeneral">
            <div class="accion">
              <i class="fas fa-search" style="margin-right: 1%;"></i>Seleccione un tipo de informe
            </div>
          </div>

        </div>

        <input type="hidden" id="pagina_actual" name="pagina_actual" value="1">
        <input type="hidden" id="paginas_totales" name="paginas_totales" value="1">
        <input type="hidden" id="numeropagina">

    </div>

@endsection

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
     <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js" integrity="sha512-TW5s0IT/IppJtu76UbysrBH9Hy/5X41OTAbQuffZFU6lQ1rdcLHzpU5BzVvr/YFykoiMYZVWlr/PX1mDcfM9Qg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection

{{-- Scripts --}}
@section('seccion-scripts-functions')
  <script>

    var id_unidad_session = @php echo json_encode($request->session()->get('id_unidad_gestion')); @endphp;
    console.log(id_unidad_session);

    var reporte_config = {
      'audi':{
        'titulo':'Audiencias',
        'ruta': '/public/descargar_r_libertades'
      },
      'oug':{
        'titulo':'Operación en unidades de Gestión',
        'ruta': '/public/descargar_r_libertades'
      }
    };

    const CHART_COLORS = {
      red: {
        rgb:'rgb(255, 99, 132)',
        rgba: 'rgba(255, 99, 132, 0.5)'
      },
      orange:{
        rgb:'rgb(255, 159, 64)',
        rgba: 'rgba(255, 159, 64, 0.5)'
      },
      yellow:{
        rgb:'rgb(255, 205, 86)',
        rgba: 'rgba(255, 205, 86,0.5)',
      },
      green:{
        rgb:'rgb(75, 192, 192)',
        rgba: 'rgba(75, 192, 192,0.5)'
      },
      blue:{
        rgb:'rgb(54, 162, 235)',
        rgba: 'rgba(54, 162, 235,0.5)'
      },
      purple:{
        rgb:'rgb(153, 102, 255)',
        rgba: 'rgba(153, 102, 255,0.5)'
      },
      grey:{
        rgb: 'rgb(201, 203, 207)',
        rgba: 'rgba(201, 203, 207,0.5)'
      } 
    };


    $(function(){
        //Loader
        setTimeout(function(){
          $('#modal_loading').modal('hide');
        }, 1000);

        //sec_ajax();
        //hScroll(60);
    });


    function buscarPor(obj){
      var valor = $(obj).val();
      var html = '';

      $('#tipoInforme').html(``);

      $('#visorGeneral').html(`
        <div class="accion">
          <i class="fas fa-search" style="margin-right: 1%;"></i>Seleccione un rango de fechas
        </div>
      `);

      if(valor == 'blanco') {
        $('#tipoInforme').html(``);
        $('#titulo_seccion').html('');
        $('#visorGeneral').html(`
          <div class="accion">
            <i class="fas fa-search" style="margin-right: 1%;"></i>Seleccione un tipo de informe
          </div>
        `);
        return false;
      }

      $('#titulo_seccion').html(reporte_config[valor].titulo);

      html = `
        <form autocomplete="off" style="width:100%; display: flex;">
          <div class="col-lg-6">
            <div class="form-group">
                <label class="label">Fecha inicio (Desde): </label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                        </div>
                    </div>
                    <input type="text" class="form-control date" placeholder="DD-MM-AAAA" id="fechaini" name="" autocomplete="off">
                </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <label class="label">Fecha fin (Hasta): </label>
              <div class="input-group">
                  <div class="input-group-prepend">
                      <div class="input-group-text">
                          <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                      </div>
                  </div>
                  <input type="text" class="form-control date" placeholder="DD-MM-AAAA" id="fechafin" name="" autocomplete="off">
              </div>
            </div>
          </div>
        </form>
        <div class="form-group col justify-content-end" style="align-items: center; margin: 0;">
            <button onclick="consultar('${valor}');" id="consultarInforme" class="btn btn-primary btn-sm btn-block " title="Consultar Informe"><i class="fa fa-search mg-r-5"></i></button>
        </div>
      `;

      $('#tipoInforme').html(html);

      setTimeout(function(){
        $('.date').datepicker({ 
          showOtherMonths: true,
          selectOtherMonths: true,
          dateFormat: 'yy-mm-dd'
        });
      },200);
      
    }

    function consultar(tipo){
      loading(true);

      var fecha_inicio = $('#fechaini').val();
      var fecha_fin = $('#fechafin').val();

      var chart_html = '';


      if(tipo == 'audi'){
        chart_html = `<canvas id="resolutivos_count" width="400" height="200"></canvas><canvas id="resolutivos_procentaje" width="400" height="200" style="margin-top:7%;"></canvas>`;
      }else if(tipo == 'oug'){
        chart_html = `
          <canvas id="documentos_generados" width="400" height="200"></canvas>
          <canvas id="rep_at_exhortos" width="400" height="200" style="margin-top:7%;"></canvas>
          <canvas id="rep_at_apel" width="400" height="200" style="margin-top:7%;"></canvas>
          <canvas id="juicios_amparo" width="400" height="200" style="margin-top:7%;"></canvas>
        `;
      }

      $('#visorGeneral').html(chart_html);

      setTimeout(function(){
        loading(false);

        if(tipo == 'audi'){

          //Primer Grafica
          const ctx = document.getElementById('resolutivos_count');

          const config = {
            type: 'bar',
            data: {
                labels: ['UGJ 1','UGJ 2','UGJ 3','UGJ 4','UGJ 5','UGJ 6','UGJ 7','UGJ 8','UGJ 9','UGJ 10','UGJ 11','UGJ 12', 'UGJJA', 'EJEC-SULLIVAN', 'EJEC-NORTE', 'EJEC-ORIENTE', 'UGJEMS', 'TOTAL'],
                datasets: [
                  {
                    label: 'Audiencias Generadas',
                    data: [80, 59, 34,56,8,45,23,31],
                    backgroundColor: CHART_COLORS.blue.rgba,
                    borderColor: CHART_COLORS.blue.rgb,
                    borderWidth: 1
                  },
                  {
                    label: 'Audiencias Con Resolutivos En Registro',
                    data: [65, 39,34,52,8,75,23,31],
                    backgroundColor: CHART_COLORS.yellow.rgba,
                    borderColor: CHART_COLORS.yellow.rgb,
                    borderWidth: 1
                  },
                  {
                    label: 'Audiencias Con Resolutivos Concluidos',
                    data: [42, 78,34,5,28,45,27,30],
                    backgroundColor: CHART_COLORS.green.rgba,
                    borderColor: CHART_COLORS.green.rgb,
                    borderWidth: 1
                  },
                  {
                    label: 'Audiencias Sin Resolutivos Registrados',
                    data: [6, 2,34,49,8,70,23,3],
                    backgroundColor: CHART_COLORS.red.rgba,
                    borderColor: CHART_COLORS.red.rgb,
                    borderWidth: 1
                  }
                ]
            },
            options: {
              indexAxis: 'y',
              scales: {
                  y: {
                      beginAtZero: true
                  }
              },
              responsive: true,
              plugins: {
                legend: {
                  position: 'left',
                },
                title: {
                  display: true,
                  text: 'Resolutivos registrados en el periodo'
                }
              }
            }
          }

          const myChart = new Chart(ctx, config);

          //Segunda grafica
          const c = document.getElementById('resolutivos_procentaje');

          const config_c = {
            type: 'bar',
            data: {
                labels: ['UGJ 1','UGJ 2','UGJ 3','UGJ 4','UGJ 5','UGJ 6','UGJ 7','UGJ 8','UGJ 9','UGJ 10','UGJ 11','UGJ 12', 'UGJJA', 'EJEC-SULLIVAN', 'EJEC-NORTE', 'EJEC-ORIENTE', 'UGJEMS', 'TOTAL'],
                datasets: [
                  {
                    label: 'Audiencias Generadas',
                    data: [80, 59, 34,56,8,45,23,31],
                    backgroundColor: CHART_COLORS.blue.rgba,
                    borderColor: CHART_COLORS.blue.rgb,
                    borderWidth: 1
                  },
                  {
                    label: 'Audiencias Con Resolutivos En Registro',
                    data: [65, 39,34,52,8,75,23,31],
                    backgroundColor: CHART_COLORS.yellow.rgba,
                    borderColor: CHART_COLORS.yellow.rgb,
                    borderWidth: 1
                  },
                  {
                    label: 'Audiencias Con Resolutivos Concluidos',
                    data: [42, 78,34,5,28,45,27,30],
                    backgroundColor: CHART_COLORS.green.rgba,
                    borderColor: CHART_COLORS.green.rgb,
                    borderWidth: 1
                  },
                  {
                    label: 'Audiencias Sin Resolutivos Registrados',
                    data: [6, 2,34,49,8,70,23,3],
                    backgroundColor: CHART_COLORS.red.rgba,
                    borderColor: CHART_COLORS.red.rgb,
                    borderWidth: 1
                  }
                ]
            },
            options: {
              indexAxis: 'x',
              scales: {
                  y: {
                      beginAtZero: true
                  }
              },
              responsive: true,
              plugins: {
                legend: {
                  position: 'bottom',
                },
                title: {
                  display: true,
                  text: 'Resolutivos registrados en el periodo'
                }
              }
            }
          }

          const porcentajes_chart = new Chart(c, config_c);

        }else if(tipo == 'oug'){
          //Primer Grafica
          const documentos_generados = document.getElementById('documentos_generados');
          const rep_at_exhortos = document.getElementById('rep_at_exhortos');
          const rep_at_apel = document.getElementById('rep_at_apel');
          const juicios_amparo = document.getElementById('juicios_amparo');

          const config1 = {
            type: 'bar',
            data: {
                labels: ['UGJ 1','UGJ 2','UGJ 3','UGJ 4','UGJ 5','UGJ 6','UGJ 7','UGJ 8','UGJ 9','UGJ 10','UGJ 11','UGJ 12', 'UGJJA', 'EJEC-SULLIVAN', 'EJEC-NORTE', 'EJEC-ORIENTE', 'UGJEMS', 'TOTAL'],
                datasets: [
                  {
                    label: 'Promociones recibidas por sistema',
                    data: [6, 2,34,49,8,70,23,3],
                    backgroundColor: CHART_COLORS.red.rgba,
                    borderColor: CHART_COLORS.red.rgb,
                    borderWidth: 1
                  },
                  {
                    label: 'Promociones Registradas Manualmente',
                    data: [80, 59, 34,56,8,45,23,31],
                    backgroundColor: CHART_COLORS.blue.rgba,
                    borderColor: CHART_COLORS.blue.rgb,
                    borderWidth: 1
                  },
                  {
                    label: 'Total Promociones',
                    data: [42, 78,34,5,28,45,27,30],
                    backgroundColor: CHART_COLORS.green.rgba,
                    borderColor: CHART_COLORS.green.rgb,
                    borderWidth: 1
                  }
                ]
            },
            options: {
              indexAxis: 'y',
              scales: {
                  y: {
                      beginAtZero: true
                  }
              },
              responsive: true,
              plugins: {
                legend: {
                  position: 'left',
                },
                title: {
                  display: true,
                  text: 'Documentos Generados en el periodo'
                }
              }
            }
          }

          const config2 = {
            type: 'bar',
            data: {
                labels: ['UGJ 1','UGJ 2','UGJ 3','UGJ 4','UGJ 5','UGJ 6','UGJ 7','UGJ 8','UGJ 9','UGJ 10','UGJ 11','UGJ 12', 'UGJJA', 'EJEC-SULLIVAN', 'EJEC-NORTE', 'EJEC-ORIENTE', 'UGJEMS', 'TOTAL'],
                datasets: [
                  {
                    label: 'Exhortos Recibidos',
                    data: [6, 2,34,49,8,70,23,3],
                    backgroundColor: CHART_COLORS.red.rgba,
                    borderColor: CHART_COLORS.red.rgb,
                    borderWidth: 1
                  },
                  {
                    label: 'Exhortos atendidos',
                    data: [80, 59, 34,56,8,45,23,31],
                    backgroundColor: CHART_COLORS.blue.rgba,
                    borderColor: CHART_COLORS.blue.rgb,
                    borderWidth: 1
                  },
                  {
                    label: 'Exhortos sin atención',
                    data: [42, 78,34,5,28,45,27,30],
                    backgroundColor: CHART_COLORS.green.rgba,
                    borderColor: CHART_COLORS.green.rgb,
                    borderWidth: 1
                  }
                ]
            },
            options: {
              indexAxis: 'y',
              scales: {
                  y: {
                      beginAtZero: true
                  }
              },
              responsive: true,
              plugins: {
                legend: {
                  position: 'left',
                },
                title: {
                  display: true,
                  text: 'Recepción/Atención de Exhortos'
                }
              }
            }
          }

          const config3 = {
            type: 'bar',
            data: {
                labels: ['UGJ 1','UGJ 2','UGJ 3','UGJ 4','UGJ 5','UGJ 6','UGJ 7','UGJ 8','UGJ 9','UGJ 10','UGJ 11','UGJ 12', 'UGJJA', 'EJEC-SULLIVAN', 'EJEC-NORTE', 'EJEC-ORIENTE', 'UGJEMS', 'TOTAL'],
                datasets: [
                  {
                    label: 'Apelaciones Registradas',
                    data: [6, 2,34,49,8,70,23,3],
                    backgroundColor: CHART_COLORS.red.rgba,
                    borderColor: CHART_COLORS.red.rgb,
                    borderWidth: 1
                  },
                  {
                    label: 'Confirman Sentencia',
                    data: [80, 59, 34,56,8,45,23,31],
                    backgroundColor: CHART_COLORS.blue.rgba,
                    borderColor: CHART_COLORS.blue.rgb,
                    borderWidth: 1
                  },
                  {
                    label: 'Modifican Sentencia',
                    data: [42, 78,34,5,28,45,27,30],
                    backgroundColor: CHART_COLORS.green.rgba,
                    borderColor: CHART_COLORS.green.rgb,
                    borderWidth: 1
                  },

                  {
                    label: 'Revocan Sentencia',
                    data: [65, 39,34,52,8,75,23,31],
                    backgroundColor: CHART_COLORS.yellow.rgba,
                    borderColor: CHART_COLORS.yellow.rgb,
                    borderWidth: 1
                  },
                  {
                    label: 'NO se Aceptan en Sala Penal',
                    data: [6, 2,34,49,8,70,23,3],
                    backgroundColor: CHART_COLORS.purple.rgba,
                    borderColor: CHART_COLORS.purple.rgb,
                    borderWidth: 1
                  }
                ]
            },
            options: {
              indexAxis: 'y',
              scales: {
                  y: {
                      beginAtZero: true
                  }
              },
              responsive: true,
              plugins: {
                legend: {
                  position: 'left',
                },
                title: {
                  display: true,
                  text: 'Registro/Atención de Apelaciones'
                }
              }
            }
          }

          const config4 = {
            type: 'bar',
            data: {
                labels: ['UGJ 1','UGJ 2','UGJ 3','UGJ 4','UGJ 5','UGJ 6','UGJ 7','UGJ 8','UGJ 9','UGJ 10','UGJ 11','UGJ 12', 'UGJJA', 'EJEC-SULLIVAN', 'EJEC-NORTE', 'EJEC-ORIENTE', 'UGJEMS', 'TOTAL'],
                datasets: [
                  {
                    label: 'Juicios de Amparos Registrados',
                    data: [6, 2,34,49,8,70,23,3],
                    backgroundColor: CHART_COLORS.red.rgba,
                    borderColor: CHART_COLORS.red.rgb,
                    borderWidth: 1
                  },
                  {
                    label: 'Juicios de Amparos Ciertos',
                    data: [80, 59, 34,56,8,45,23,31],
                    backgroundColor: CHART_COLORS.blue.rgba,
                    borderColor: CHART_COLORS.blue.rgb,
                    borderWidth: 1
                  },
                  {
                    label: 'Juicios de Amparos Transitorios',
                    data: [42, 78,34,5,28,45,27,30],
                    backgroundColor: CHART_COLORS.green.rgba,
                    borderColor: CHART_COLORS.green.rgb,
                    borderWidth: 1
                  }
                ]
            },
            options: {
              indexAxis: 'y',
              scales: {
                  y: {
                      beginAtZero: true
                  }
              },
              responsive: true,
              plugins: {
                legend: {
                  position: 'left',
                },
                title: {
                  display: true,
                  text: 'Juicios de Amparo'
                }
              }
            }
          }
        
          const myChart1 = new Chart(documentos_generados, config1);
          const myChart2 = new Chart(rep_at_exhortos, config2);
          const myChart3 = new Chart(rep_at_apel, config3);
          const myChart4 = new Chart(juicios_amparo, config4);
        }

      }, 1000);


      /*
      $.ajax({
        type:'POST',
        url:'/public/consulta_informes_c',
        data:{
          fecha_inicio: fecha_inicio,
          fecha_final:fecha_fin,
          tipo_informe: tipo_informe,
          edificio:edificio,
          unidad_gestion: unidad_gestion,
        },
        success:function(response) {
            console.log(response);
          
            if(response.status==100){

              loading(false);
            }else{
                error(response.message);
                
                loading(false);
            }
          
        }
      });
      */

    }

    //funciones Generales
    function success(mensaje){
      $('#messageExito').html(mensaje);
      $('#modalSuccess').modal('show');
    }

    function error(mensaje){
      $('#messageError').html(mensaje);
      $('#modalError').modal('show');
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
    
    function cerrar_modal(valor){
      $("#"+valor).modal('hide');
    }

  </script>

@endsection

@section('seccion-modales')
  {{-- modales de exito y error --}}
  <div id="modalSuccess" class="modal fade"  data-backdrop="static" data-keyboard="false">
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

  <div id="modalError" class="modal fade">
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

  <div id="modalWarning" class="modal fade"  data-backdrop="static" data-keyboard="false">
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

  <div id="loader" class="modal fade"  data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-body tx-center pd-y-20 pd-x-20" style="background: rgba(0,0,0,0.7);">
          <h5 style="color:#fff;">Consultando Reporte</h5>
          <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
        </div>
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
  </div>
@endsection


