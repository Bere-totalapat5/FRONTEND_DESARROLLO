@php
  use App\Http\Controllers\clases\humanRelativeDate;
  use App\Http\Controllers\clases\utilidades;
  $humanRelativeDate = new humanRelativeDate();
@endphp

@extends('layouts.index')

@section('contenido-principal')
<div class="section-wrapper" style="max-width: 1200px;">
    <div class="form-layout">
        {{-- <div id="accordion" class="accordion-one mg-b-20" role="tablist" aria-multiselectable="true">
            <div class="card">
                <div class="card-header" role="tab" id="headingOne">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" class="tx-gray-800 transition collapsed">
                    Búsqueda Avanzada
                    </a>
                </div><!-- card-header -->
                <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                    <div class="card-body">
                        <div class="row mg-b-25">
                          <div class="col-lg-2">
                            <label class="form-control-label">Estatus actual:</label>
                            <div class="form-group">
                              <select class="form-control-lg select2 valid" autocomplete="off">
                                  <option selected disabled value="">Elija una opción</option>
                                       <option value="" >{{'RECIBIDA'}}</option>
                                       <option value="" >{{'REGISTRADA'}}</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-lg-2">
                            <label class="form-control-label">Estatus urgente:</label>
                            <div class="form-group">
                              <select class="form-control-lg select2 valid" autocomplete="off">
                                  <option selected disabled value="">Elija una opción</option>
                                       <option value="" >{{'SI'}}</option>
                                       <option value="" >{{'NO'}}</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-lg-2">
                            <label class="form-control-label">Materia destino:</label>
                            <div class="form-group">
                              <select class="form-control-lg select2 valid" autocomplete="off">
                                  <option selected disabled value="">Elija una opción</option>
                                       <option value="" >{{'Adolescentes'}}</option>
                                       <option value="" >{{'Adultos'}}</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-lg-6">
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="label">Fecha solicitud (Desde): </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control fc-datepicker" placeholder="AAAA/MM/DD" value="{{date('Y-m-d')}}" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="label">Fecha solicitud (Hasta): </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control fc-datepicker" placeholder="AAAA/MM/DD" value="{{date('Y-m-d')}}" autocomplete="off">
                                    </div>                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="label">Folio solicitud de Audiencia (Desde): </label>
                                    <input class="form-control" type="text"  value="" placeholder="">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="form-control-label">Folio solicitud de Audiencia (Hasta): </label>
                                    <input class="form-control" type="text"  value="" placeholder="" >
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="label">Fecha recepción (Desde): </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control fc-datepicker" placeholder="AAAA/MM/DD" value="{{date('Y-m-d')}}" autocomplete="off">
                                    </div>                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="label">Fecha recepción (Hasta): </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control fc-datepicker" placeholder="AAAA/MM/DD" value="{{date('Y-m-d')}}" autocomplete="off">
                                    </div>                                </div>
                            </div>
                            <div class="col-lg-3">
                              <div class="form-group">
                                <label class="form-control-label">Hora de Recepción (Desde)<small>(24hrs)</small>: <span class="tx-danger">*</span></label>
                                <div class="d-flex">
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <div class="input-group-text">
                                        <i class="fa fa-clock-o tx-16 lh-0 op-6"></i>
                                      </div><!-- input-group-text -->
                                    </div><!-- input-group-prepend -->
                                    <input  type="text" class="form-control" placeholder="hh:mm" autocomplete="off">
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-3">
                              <div class="form-group">
                                <label class="form-control-label">Hora de Recepción (Hasta)<small>(24hrs)</small>: <span class="tx-danger">*</span></label>
                                <div class="d-flex">
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <div class="input-group-text">
                                        <i class="fa fa-clock-o tx-16 lh-0 op-6"></i>
                                      </div><!-- input-group-text -->
                                    </div><!-- input-group-prepend -->
                                    <input  type="text" class="form-control"  placeholder="hh:mm" autocomplete="off">
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="label">Fecha fenece(Desde): </label>
                                    <input class="form-control" type="text" value="" placeholder="" >
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="label">Fecha fenece (Hasta): </label>
                                    <input class="form-control" type="text" value="" placeholder="" >
                                </div>
                            </div>
                        </div><!-- row -->
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="button" class="btn btn-primary btn-sm btn-block mg-b-10" data-toggle="collapse" data-target="#demo" onclick="sec_ajax();">Filtrar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- accordion --> --}}

        <input type="text" id="busqueda" onkeyup="buscar_solicitud()" placeholder="Buscar por solicitud.." title="Ingresa el numero de solicitud">
        <br>

        <br>
        {{-- <div class="pagination-wrapper justify-content-between mg-b-20">
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
            <div id="texto_paginator">Página <span class="pagina_actual_texto">0</span> de <span class="pagina_total_texto">0</span></div>
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
            </div> --}}


        </div><!-- pagination-wrapper -->


        <div class="table-responsive">
            <table id="tabla_solicitudes" class="table table-striped" >
                <thead style="background-color: #EBEEF1; color: rgb(0, 0, 0); text-align:center font-size: 10px; ">
                    <tr >
                    <th class="">Acciones</th>
                    <th class="">Folio de solicitud</th>
                    <th class="">Fecha/hora de registro</th>
                    <th class="">Carpeta Judicial</th>
                    <th class="">Carpeta de Investigacion</th>
                    <th class="">Tipo de Audiencia</th>
                    <th class="">Clase de Audiencia</th>
                    <th class="">Estado de la Solicitud</th>
                    <th class="">Responsable</th>
                </tr>
              </thead>
              <tbody id="body-table1" style="width: 100%; font-size: 10px; text-align: left;">

                @foreach ($solicitudes['response'] as $solicitud)

                        <tr>
                            <th class="btn-group btn-group-xs" scope="row">

                                <button type="button" title="PDF" class="btn" data-toggle="modal" target="#modal_pdf" value="{{$solicitud['ruta_base_pdf']}}"><i class="fas fa-file"></i></button>
                            </th>

                            <th scope="row">{{$solicitud['id_solicitud']}}</th>
                            <th scope="row">{{$solicitud['id_solicitud']}}</th>
                            <th scope="row">{{$solicitud['fecha_solicitud']}}</th>
                            <th scope="row">{{$solicitud['id_carpeta_judicial']}}</th>
                            <th scope="row">{{$solicitud['carpeta_investigacion']}}</th>
                            <th scope="row">{{$solicitud['tipo_audiencia']}}</th>
                            <th scope="row">{{$solicitud['estatus_flujo_actual']}}</th>
                            <th scope="row">{{$solicitud['estatus_flujo_actual']}}</th>

                        </tr>

                      @endforeach


            </tbody>
            </table>
          </div><!-- table-responsive -->



        <div class="pagination-wrapper justify-content-space-between col-sm-4 " style="border:0px;float:none;margin:auto;">
            <ul class="pagination pagination-sm">
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
            <div id="texto_paginator">Página <span class="pagina_actual_texto">0</span> de <span class="pagina_total_texto">0</span></div>
                <ul class="pagination pagination-sm">
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
        </div>
        @endsection

        @section('modalPDF')

            {{-- <div class="modal fade" id="modalPDF">
                <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <object type="application/pdf" data="path/to/pdf" width="100%" height="500" style="height: 85vh;">No Support</object>
                    </div>
                </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal --> --}}

            <div id="modal_pdf" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                   <div class="modal-content">
                     <div class="modal-header">
                       <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
                       <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                     </div>
                     <div class="modal-body">
                       ...
                     </div>
                     <div class="modal-footer">
                       <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                       <button type="button" class="btn btn-primary">Save changes</button>
                     </div>
                   </div>
                 </div>
               </div>


        @endsection

        @section('seccion-estilos')
        <link href="{{ $entorno["version_pages"]["version"] }}/lib/datatables/css/jquery.dataTables.css" rel="stylesheet">
        <link href="{{ $entorno["version_pages"]["version"] }}/lib/select2/css/select2.min.css" rel="stylesheet">

       {{--  .asc:after {
            content: ' ↑';
          }

          .desc:after {
            content: " ↓";
          } --}}

        @endsection

        {{-- file-earmark-code
        file-earmark-ppt-fill --}}



        @section('seccion-scripts-functions')
        <script type="text/javascript">


function buscar_solicitud() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("busqueda");
  filter = input.value.toUpperCase();
  table = document.getElementById("tabla_solicitudes");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("th")[1];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}

$('#body-table1').on('submit', function(ev) {
    $('#modal_pdf').modal({
        show: 'false'
    });


    var data = $(this).serializeObject();
    json_data = JSON.stringify(data);
    $("#results").text(json_data);
    $(".modal-body").text(json_data);

    // $("#results").text(data);

    ev.preventDefault();
});

/*
$('th').click(function() {
    var table = $(this).parents('table').eq(0)
    var rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()))
    this.asc = !this.asc
    if (!this.asc) {
      rows = rows.reverse()
    }
    for (var i = 0; i < rows.length; i++) {
      table.append(rows[i])
    }
    setIcon($(this), this.asc);
  })

  function comparer(index) {
    return function(a, b) {
      var valA = getCellValue(a, index),
        valB = getCellValue(b, index)
      return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.localeCompare(valB)
    }
  }

  function getCellValue(row, index) {
    return $(row).children('th').eq(index).html()
  }

  function setIcon(element, asc) {
    $("th").each(function(index) {
      $(this).removeClass("sorting");
      $(this).removeClass("asc");
      $(this).removeClass("desc");
    });
    element.addClass("sorting");
    if (asc) element.addClass("asc");
    else element.addClass("desc");
  } */



</script>
        @endsection
