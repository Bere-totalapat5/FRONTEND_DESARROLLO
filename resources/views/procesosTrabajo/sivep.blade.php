@php
    use App\Http\Controllers\clases\humanRelativeDate;
    $humanRelativeDate = new humanRelativeDate();
@endphp

@extends('layouts.index')

@section('contenido-pageheader')
    <ol class="breadcrumb slim-breadcrumb">
        <li class="breadcrumb-item"><a href="/home">Home</a></li>
        <li class="breadcrumb-item">Procesos de trabajo</li>
        <li class="breadcrumb-item active" aria-current="page">SIVEP</li>
    </ol>
    <h6 class="slim-pagetitle">SIVEP</h6>
@endsection

@section('contenido-principal')

    <div class="section-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="card-profile-name">Lista de Pendientes</h3>
            </div>
            <div class="col-lg-12 mg-t-20">

              <div style="float: left;">
                
            </div>


                <div style="" >
                  <table id="datatable1" class="table display responsive nowrap">
                    <thead>
                    <tr>
                        <th>Fecha de resolución</th>
                        <th>Secretaría</th>
                        <th>Expedinete</th>
                        <th>Involucrados</th>
                    </tr>
                    </thead>
                    <tbody>
                      @isset($lista['response'][0]['id_acuerdo'])
                        @php $i=0; @endphp
                        @foreach ($lista['response'] as $sivep)
    
                          <tr>
                            
                            <td>{{$sivep['fecha']}}</td>

                            
                            <td>{{$sivep['secretaria']}}</td>

                            <td class="romperCadena">{{$sivep['acuerdo']}}</td>
                            
                            <td>
                                @isset($sivep['partes'][0]['actores'][0]['parte_id'])
                                    @php $i=0; @endphp
                                    @foreach ($sivep['partes'][0]['actores'] as $parte)
                                        @if($i!=0) , @endif
                                        {{$parte['nombre_c']}}
                                        
                                        @php $i++; @endphp
                                    @endforeach
                                @endisset

                                @isset($sivep['partes'][0]['demandados'][0]['parte_id'])
                                    VS 
                                    @php $i=0; @endphp
                                    @foreach ($sivep['partes'][0]['demandados'] as $parte)
                                        @if($i!=0) , @endif
                                        {{$parte['nombre_c']}}
                                        
                                        @php $i++; @endphp
                                    @endforeach
                                @endisset
                            </td>
                            
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
          { responsivePriority: 1, targets: 3 },  
          { "targets": [0],  "orderable": false, "visible": true },
          { "targets": [1],  "orderable": false, "visible": true },
          { "targets": [2],  "orderable": false, "visible": true,  'className': 'romperCadena' },
          { "targets": [3],  "orderable": false, "visible": true, 'className': 'romperCadena' }
          ],
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