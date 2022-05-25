@php
    use App\Http\Controllers\clases\humanRelativeDate;
    $humanRelativeDate = new humanRelativeDate();
@endphp

@extends('layouts.index')

@section('contenido-pageheader')
    <ol class="breadcrumb slim-breadcrumb">
        <li class="breadcrumb-item"><a href="/home">Home</a></li>
        <li class="breadcrumb-item">Procesos de trabajo</li>
        <li class="breadcrumb-item active" aria-current="page">Solicitudes</li>
    </ol>
    <h6 class="slim-pagetitle">Lista de Solicitudes</h6>
@endsection

@section('contenido-principal')


<div id="accordion" class="accordion-one" role="tablist" aria-multiselectable="true" style="margin-bottom:10px;">
  <div class="card">
    <div class="card-header" role="tab" id="headingOne">
      <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" class="tx-gray-800 transition collapsed">
        Busqueda Avanzada
      </a>
    </div><!-- card-header -->

    <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne">
      <div class="card-body">
       
          <div class="form-layout">
              <div class="row mg-b-0">
                  
                  <div class="col-lg-12">
                  <div class="form-group mg-b-10-force">
                  <label class="form-control-label">Solicitud:</label>
                  <input class="form-control" type="text" name="folio" id="folio" value="" placeholder="Número">
                  
                  </div>
              </div><!-- col-4 -->
              

              <div class="col-lg-12">
                  <div class="form-group mg-b-10-force">
                  <label class="form-control-label">Registro: </label>
                  
                  <table style="width:100%;">
                          <tr>
                              <td style="width:10%;">Desde </td>
                              <td style="width:30%;">
                                  <div class="input-group" style="width:100%;">
                                      <div class="input-group-prepend">
                                      <div class="input-group-text">
                                          <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                      </div>
                                      </div>
                                      <input type="text" class="form-control fc-datepicker" placeholder="MM/DD/YYYY" name="fecha_desde" id="fecha_desde" readonly="readonly">
                                  </div>
                                  </td>
                              <td> &nbsp; &nbsp; &nbsp;</td>
                              <td style="width:10%;">Hasta </td>
                              <td style="width:30%;">
                                  <div class="input-group">
                                      <div class="input-group-prepend">
                                      <div class="input-group-text">
                                          <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                      </div>
                                      </div>
                                      <input type="text" class="form-control fc-datepicker" placeholder="MM/DD/YYYY" name="fecha_hasta" id="fecha_hasta" readonly="readonly">
                                  </div>
                              </td>
                          </tr>
                      </table>
                  </div>
              </div><!-- col-4 -->
              <div class="col-lg-12">
                  <button class="btn btn-primary btn-sm btn-block mg-b-10" onclick="accionBuscar_ajax();">Buscar Solicitud</button>
              </div>
              </div><!-- row -->
          </div>
      </div>
  </div>
</div>
</div>


    <div class="section-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="card-profile-name">Lista de Solicitudes</h3>
            </div>
            <div class="col-lg-12 mg-t-20">

              <div style="float: left;">
                
            </div>
            <div style="float: right">
                
                <a href="javascript:void(0)" onclick="autorizarMasivo(0, 'aprobado')"> Autorizar selección</a>   |    <a href="javascript:void(0)" onclick="autorizarMasivo(1, 'aprobado')">Autorizar  10 acuerdos</a>
            </div>


                <div style="" >
                  <table id="datatable1" class="table display responsive nowrap">
                    <thead>
                    <tr>
                        <th>Folio</th>
                        <th>{{$request->lang['Sala']}}</th>
                        <th>{{$request->lang['Toca']}}</th>
                        <th>Solicitante</th>
                        <th>Representa</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                        <th><input name="select_all" value="1" type="checkbox"></th>
                    </tr>
                    </thead>
                    <tbody>
                      @isset($lista['response'][0]['id'])
                        @php $i=0; @endphp
                        @foreach ($lista['response'] as $solicitud)
    
                          <tr id="data-row-id-{{$i}}">
                            <input type="hidden" class="impresion_masivo" id="masivo_{{$i}}" value="{{$i}},{{$solicitud['id']}}">
                            <td>{{$solicitud['folio']}}</td>
                            <td class="romperCadena">{{$solicitud['juzgado']}}</td>

                            @if($request->session()->get('juzgado_tipo')=='sala')
                              <td>{{$solicitud['toca']}}</td>
                            @else
                              <td>{{$solicitud['expediente']}}</td>
                            @endif
                            <td class="romperCadena">{{$solicitud['solicitante']}}</td>
                            <td>{{$solicitud['representa']}}</td>
                            <td>{{date("Y-m-d", strtotime($solicitud['alta']))}}</td>
                            <td><a href="javascript:void(0);" onclick="cambiarEstatusSolicitud('{{$i}}', 'aprobado', '{{$solicitud['id']}}');">Aceptar</a><br><a href="javascript:void();" onclick="cambiarEstatusSolicitud('{{$i}}', 'rechazado', '{{$solicitud['id']}}');">Denegar</a>
                            
                              <br><a href="javascript:void();" onclick="verPromocion('{{$solicitud['id']}}');">Ver promoción</a>
                            
                            </td>
                            <td></td>
                          </tr>
                          @php $i++; @endphp
                        @endforeach
                      @endisset
    
    
                    </tbody>
                  </table>
            </div>
          </div>
        </div>
    </div>
@endsection

@section('seccion-estilos')
  <link href="{{ $entorno["version_pages"]["version"] }}/lib/datatables/css/jquery.dataTables.css" rel="stylesheet">
  <link href="{{ $entorno["version_pages"]["version"] }}/lib/select2/css/select2.min.css" rel="stylesheet">
  <style>
    .romperCadena{
            word-wrap: break-word !important;
            white-space:normal !important;
        }
  </style>
@endsection

@section('seccion-scripts-libs')
  <script src="{{ $entorno["version_pages"]["version"] }}/lib/datatables/js/jquery.dataTables.js"></script>
  <script src="{{ $entorno["version_pages"]["version"] }}/lib/datatables-responsive/js/dataTables.responsive.js"></script>
  <script src="{{ $entorno["version_pages"]["version"] }}/lib/select2/js/select2.min.js"></script>
@endsection

@section('seccion-scripts-functions')
  <script>
    setTimeout(function(){
        $('#modal_loading').modal('hide');
    }, 1000);


    $(function(){
      'use strict';


      // Select2
      $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

    });

  
  function verPromocion(id){

    $.ajax({
      type:'POST',
      url: "{{ route('procesosTrabajo.obtenerPromocionPDF') }}",
      data:{ id: id  },
      success:function(data){
        console.log(data);
        setTimeout(function(){
          $('#modal_loading').modal('hide');
        }, 500);
        
        
        if(data[0].status==100){
          var win = window.open(data[0].response, '_blank');
        }
        else{
          alert(data[0].message);
        }
      }
    });

  }

  function updateDataTableSelectAllCtrl(table){
      var $table             = table.table().node();
      var $chkbox_all        = $('tbody input[type="checkbox"]', $table);
      var $chkbox_checked    = $('tbody input[type="checkbox"]:checked', $table);
      var chkbox_select_all  = $('thead input[name="select_all"]', $table).get(0);

      // If none of the checkboxes are checked
      if($chkbox_checked.length === 0){
          chkbox_select_all.checked = false;
          if('indeterminate' in chkbox_select_all){
              chkbox_select_all.indeterminate = false;
          }

      // If all of the checkboxes are checked
      } else if ($chkbox_checked.length === $chkbox_all.length){
          chkbox_select_all.checked = true;
          if('indeterminate' in chkbox_select_all){
              chkbox_select_all.indeterminate = false;
          }

      // If some of the checkboxes are checked
      } else {
          chkbox_select_all.checked = true;
          if('indeterminate' in chkbox_select_all){
              chkbox_select_all.indeterminate = true;
          }
      }
  }

  var dataTableGlobal;
  var i_global=-1;
  $(document).ready(function() {
      var rows_selected = [];
      var table ;
      
      dataTableGlobal = table = $('#datatable1').DataTable( {
          "ordering": false,
          'columnDefs': [
          { responsivePriority: 1, targets: 7 },  
          { "targets": [0],  "orderable": false, "visible": true },
          { "targets": [1],  "orderable": false, "visible": true },
          { "targets": [2],  "orderable": false, "visible": true },
          { "targets": [3],  "orderable": false, "visible": true, 'className': 'romperCadena' },
          { "targets": [4],  "orderable": false, "visible": true },
          {
              'targets': 7,
              'searchable': false,
              'orderable': false,
              'width': '1%',
              'className': 'dt-body-center',
              'render': function (data, type, full, meta){
                  i_global++;
                  return '<input type="checkbox" id="chbox_'+i_global+'" class="chbox_imprimir" value="'+i_global+'">';
          }
          }],
          bLengthChange: false,
          searching: false,
          responsive: true,
          pageLength: 10,

          'rowCallback': function(row, data, dataIndex){
              // Get row ID
              var rowId = data[0];

              // If row ID is in the list of selected row IDs
              if($.inArray(rowId, rows_selected) !== -1){
                  $(row).find('input[type="checkbox"]').prop('checked', true);
                  $(row).addClass('selected');
              }
          }
      });
          
          // Handle click on checkbox
      $('#datatable1 tbody').on('click', 'input[type="checkbox"]', function(e){
          var $row = $(this).closest('tr');

          // Get row data
          var data = table.row($row).data();

          // Get row ID
          var rowId = data[0];

          // Determine whether row ID is in the list of selected row IDs
          var index = $.inArray(rowId, rows_selected);

          // If checkbox is checked and row ID is not in list of selected row IDs
          if(this.checked && index === -1){
              rows_selected.push(rowId);

          // Otherwise, if checkbox is not checked and row ID is in list of selected row IDs
          } else if (!this.checked && index !== -1){
              rows_selected.splice(index, 1);
          }

          if(this.checked){
              $row.addClass('selected');
          } else {
              $row.removeClass('selected');
          }

          // Update state of "Select all" control
          updateDataTableSelectAllCtrl(table);

          // Prevent click event from propagating to parent
          e.stopPropagation();
      });

      /*
      // Handle click on table cells with checkboxes
      $('#datatable1').on('click', 'tbody td, thead th:first-child', function(e){
          $(this).parent().find('input[type="checkbox"]').trigger('click');
      });
      */

      // Handle click on "Select all" control
      $('thead input[name="select_all"]', table.table().container()).on('click', function(e){
          if(this.checked){
              $('#datatable1 tbody input[type="checkbox"]:not(:checked)').trigger('click');
          } else {
              $('#datatable1 tbody input[type="checkbox"]:checked').trigger('click');
          }

          // Prevent click event from propagating to parent
          e.stopPropagation();
      });

      // Handle table draw event
      table.on('draw', function(){
          // Update state of "Select all" control
          updateDataTableSelectAllCtrl(table);
      });
  
      'use strict';
      //focus textfiled
      $('.form-layout .form-control').on('focusin', function(){
          $(this).closest('.form-group').addClass('form-group-active');
      });
      $('.form-layout .form-control').on('focusout', function(){
          $(this).closest('.form-group').removeClass('form-group-active');
      });

      
  });

  function autorizarMasivo(todos, estatus){
    arr_imprimir="";
    if(todos==1){
      $('.impresion_masivo').each(function(i){
        console.log($(this).val());
        arr_imprimir+=$(this).val()+'-';
      });
    }
    else{
      $( ".chbox_imprimir" ).each(function( index ) {
        console.log(1);
        if($(this).is(':checked')) {
          console.log(2);
          arr_imprimir+=$('#masivo_'+$(this).val()).val()+'-';
        }
      });
    }

    if(arr_imprimir!=""){

      if(confirm('¿Esta seguro de aceptar todas las solicitudes?')){

        $('#modal_loading').modal({backdrop: 'static', keyboard: false});

          $.ajax({
            type:'POST',
            url: "{{ route('procesosTrabajo.solicitudes_cabiar_estatus_ajax_masivo') }}",
            data:{ estatus: estatus, arr_imprimir:arr_imprimir },
            success:function(data){
              console.log(data);
              setTimeout(function(){
                $('#modal_loading').modal('hide');
              }, 500);
              
              
              if(data[0].status==100){
                dataTableGlobal.rows('.selected').remove().draw();
              }
              else{
                alert(data[0].message);
              }
            }
          });
      }
      else{
        alert('Debe de seleccionar alguna solicitud');
      }
    }
  }


  function cambiarEstatusSolicitud(index, estatus, id, juicio_id){
    texto=estatus;
    if(estatus=="aprobado"){
      texto="aceptar";
    }
    if(confirm('¿Esta seguro de '+texto+' la solicitud?')){
      
      
      $('#modal_loading').modal({backdrop: 'static', keyboard: false});
      $.ajax({
          type:'POST',
          url: "{{ route('procesosTrabajo.cambiar_estatus_solicitudes_ajax') }}",
          data:{ estatus:estatus, id:id },
          success:function(data){
            console.log(data);
            setTimeout(function(){
              $('#modal_loading').modal('hide');
            }, 500);
            
            
            if(data[0].status==100){
              $('#bandejas_sicor').find('#solicitudes').html($('#bandejas_sicor').find('#solicitudes').html()-1);
              $('#datatable1').find('#data-row-id-'+index).fadeOut('slow', function($row){
                  dataTableGlobal.rows(index).remove().draw();
              });
            }
            else{
              alert(data[0].message);
            }
          }
      });

    }
  }

  </script>
@endsection

@section('seccion-modales')

<!-- LARGE MODAL -->
  <div id="modaldemo3" class="modal fade">
    <div class="modal-dialog modal-lg modal-dialog-vertical-center" role="document" style="width: 95%;">
      <div class="modal-content tx-size-sm">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Message Preview</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pd-20">
          <h5 class=" lh-3 mg-b-20"><a href="" class="tx-inverse hover-primary">Why We Use Electoral College, Not Popular Vote</a></h5>
          <p class="mg-b-5">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. </p>
        </div><!-- modal-body -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->

@endsection