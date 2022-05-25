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
        <form>
          <div class="form-layout">
              <div class="row mg-b-0">
                  
                <div class="col-lg-6">
                  <div class="form-group mg-b-10-force">
                  <label class="form-control-label">Solicitud:</label>
                  <input class="form-control" type="text" name="folio" id="folio" value="@isset($datos['folio']){{$datos['folio']}}@endisset" placeholder="Número">
                  
                  </div>
                </div><!-- col-4 -->


                <div class="col-lg-6">
                  <div class="form-group mg-b-10-force">
                  <label class="form-control-label">Secretaría:</label>
                  <select class="form-control select2" id="secretaria" name="secretaria" data-placeholder="Escoge una opción" style="width: 100%;">
                    <option value="-">Todos</option>
                    <option value="A" @if(isset($datos['secretaria']) and $datos['secretaria']=='A' ) selected @endif>A</option>
                    <option value="B" @if(isset($datos['secretaria']) and $datos['secretaria']=='B' ) selected @endif>B</option>
                  </select>
                  
                  </div>
                </div><!-- col-4 -->
              
                <div class="col-lg-6">
                  <div class="form-group mg-b-10-force">
                    <label class="form-control-label">Expediente:</label>
                    <input class="form-control" type="text" name="expediente" id="expediente" value="@isset($datos['expediente']){{$datos['expediente']}}@endisset" placeholder="Expediente">
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group mg-b-10-force">
                    <label class="form-control-label">Año:</label>
                    <input class="form-control" type="text" name="anio" id="anio" value="@isset($datos['anio']){{$datos['anio']}}@endisset" placeholder="Año">
                  </div>
                </div>


                <div class="col-lg-6">
                  <div class="form-group mg-b-10-force">
                    <label class="form-control-label">Estatus:</label><br>
                      <select class="form-control select2" id="estatus" name="estatus" data-placeholder="Escoge una opción" style="width: 100%;">
                        <option value="-">Todos</option>
                        <option value="por revisar" @if(isset($datos['estatus']) and $datos['estatus']=='por revisar' ) selected @endif>Por revisar</option>
                        <option value="cancelado" @if(isset($datos['estatus']) and $datos['estatus']=='cancelado' ) selected @endif>Cancelado</option>
                        <option value="cancelado_juzgado" @if(isset($datos['estatus']) and $datos['estatus']=='cancelado_juzgado' ) selected @endif>Cancelado por DEGT</option>
                        <option value="cancelado_litigante" @if(isset($datos['estatus']) and $datos['estatus']=='cancelado_litigante' ) selected @endif>Cancelado por Litigante</option>
                        <option value="aprobado" @if(isset($datos['estatus']) and $datos['estatus']=='aprobado' ) selected @endif>Aprobado</option>
                        <option value="rechazado" @if(isset($datos['estatus']) and $datos['estatus']=='rechazado' ) selected @endif>Rechazado</option>
                        
                      </select>
                    
                    </div>

                </div>
                <div class="col-lg-6">

                  

                </div>


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
                                      <input type="text" class="form-control fc-datepicker" value="@isset($datos['fecha_desde']){{$datos['fecha_desde']}}@endisset" placeholder="MM/DD/YYYY" name="fecha_desde" id="fecha_desde" readonly="readonly">
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
                                      <input type="text" class="form-control fc-datepicker" value="@isset($datos['fecha_hasta']){{$datos['fecha_hasta']}}@endisset" placeholder="MM/DD/YYYY" name="fecha_hasta" id="fecha_hasta" readonly="readonly">
                                  </div>
                              </td>
                          </tr>
                      </table>
                  </div>
              </div><!-- col-4 -->
              <div class="col-lg-12">
                  <button class="btn btn-primary btn-sm btn-block mg-b-10" type="submit">Buscar Solicitud</button>
              </div>
              </div><!-- row -->
          </div>
        </form>
      </div>
  </div>
</div>
</div>


    <div class="section-wrapper">
      <div style="float: right"><a href="javascript:void(0);" onclick="openWindowWithPost();">Exportar toda la lista a excel</a></div>
      <span style="color:red;">Pendientes en total: {{$juicio_sicor_count}}</span><br><br>

      <div class="row">
        <div class="col-lg-12">
            <h3 class="card-profile-name">Lista de Solicitudes con Digitalización</h3>
            
        </div>
        <div class="col-lg-12 mg-t-20">

          <div style="float: left;">
            
        </div>
        <div style="float: right">
            
            
        </div>


            <div style="" >
              <table id="datatable1" class="table display responsive nowrap">
                <thead>
                <tr>
                    <th>Folio</th>
                    <th>{{$request->lang['Toca']}}</th>
                    <th>Solicitante</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                  @isset($lista[0]['id_usuario_juicio'])
                    @php $i=0; @endphp
                    @foreach ($lista as $solicitud)

                      @if($lista_promociones[$i]['digitalizado']==1)

                        <tr class="data-row-id-{{$i}}">
                          
                          <td>{{$solicitud['id_usuario_juicio']}}<br>Digitalizado</td>

                          
                          <td>{{$solicitud['expediente']}}/{{$solicitud['anio']}}<br>Sec. {{$solicitud['secretaria']}}</td>

                          <td class="romperCadena">{{$solicitud['nombres']." ".$solicitud['paterno']." ".$solicitud['materno']}}
                          
                            <br>Parte {{$solicitud['parte']}}
                            @isset($solicitud['fecha_auto'])
                              <br>Fecha auto donde se legitimó: {{$solicitud['fecha_auto']}}
                            @endisset
                            
                          </td>
                          
                          <td>{{date("Y-m-d", strtotime($solicitud['alta']))}}</td>
                          <td>
                            
                            

                            @if($solicitud['estatus']=='aprobado')
                              <div id="opciones_{{$i}}">
                                Estatus: Aprobado<br>
                                <a href="javascript:void();" onclick="cancelarEstatusSolicitud('{{$i}}', 'rechazado', '{{$solicitud['id_usuario_juicio']}}');">Denegar</a>
                                <form target='_blank' method='GET' action="https://sicor.poderjudicialdf.gob.mx/juicios/AutorizacionImprSigj.php">
                                  <input type="hidden" name="folio" value="{{$solicitud['id_usuario_juicio']}}" />
                                  <div class="control_center" style="width: 150px;font-weight: bold">
                                      <input class="boton" value="Borrador Acuerdo" type="submit">
                                  </div>
                                </form>
                              </div>
                            @elseif($solicitud['estatus']=='por revisar')
                              <div id="opciones_{{$i}}">
                                Estatus: Por revisar<br>
                                <a href="javascript:void(0);" onclick="cambiarEstatusSolicitud('{{$i}}', 'aprobado', '{{$solicitud['id_usuario_juicio']}}');">Aceptar</a><br>
                                <a href="javascript:void();" onclick="cancelarEstatusSolicitud('{{$i}}', 'rechazado', '{{$solicitud['id_usuario_juicio']}}');">Denegar</a>
                              </div>
                            @elseif($solicitud['estatus']=='rechazado')

                              <div id="opciones_{{$i}}">
                                Estatus: Rechazado<br>
                                <a href="javascript:void(0);" onclick="cambiarEstatusSolicitud('{{$i}}', 'aprobado', '{{$solicitud['id_usuario_juicio']}}');">Aceptar</a><br>

                                <form target='_blank' method='GET' action="https://sicor.poderjudicialdf.gob.mx/juicios/RechazoImprSigj.php">
                                  <input type="hidden" name="folio" value="{{$solicitud['id_usuario_juicio']}}" />
                                  <div class="control_center" style="width: 150px;font-weight: bold">
                                      <input class="boton" value="Borrador Acuerdo" type="submit">
                                  </div>
                                </form>
                              </div>
                            @endif


                            <form target='_blank' method='POST' action="https://sicor.poderjudicialdf.gob.mx/seguimiento/SolicitudImprSigj.php">
                              <input type="hidden" name="folio" value="{{$solicitud['id_usuario_juicio']}}" />
                              <div class="control_center" style="width: 150px;font-weight: bold">
                                  <input class="boton" value="Imprimir acuse" type="submit">
                              </div>
                            </form>

                          
                          </td>
                          
                        </tr>

                      @endif
                      @php $i++; @endphp
                    @endforeach
                  @endisset


                </tbody>
              </table>
        </div>
      </div>
    </div>

<br><br><br>


      
      
      <div class="row">
            <div class="col-lg-12">
              
                <h3 class="card-profile-name">Lista de Solicitudes sin Digitalización</h3>
            </div>
            <div class="col-lg-12 mg-t-20">

              <div style="float: left;">
                
            </div>
            <div style="float: right">
                
                
            </div>


                <div style="" >
                  <table id="datatable2" class="table display responsive nowrap">
                    <thead>
                    <tr>
                        <th>Folio</th>
                        <th>{{$request->lang['Toca']}}</th>
                        <th>Solicitante</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                      @isset($lista[0]['id_usuario_juicio'])
                        @php $i=0; @endphp
                        @foreach ($lista as $solicitud)

                          @if($lista_promociones[$i]['digitalizado']==0)
    
                            <tr class="data-row-id-{{$i}}">
                              
                              <td>{{$solicitud['id_usuario_juicio']}}</td>

                              
                              <td>{{$solicitud['expediente']}}/{{$solicitud['anio']}}<br>Sec. {{$solicitud['secretaria']}}</td>

                              <td class="romperCadena">{{$solicitud['nombres']." ".$solicitud['paterno']." ".$solicitud['materno']}}
                              
                                <br>Parte {{$solicitud['parte']}}
                                @isset($solicitud['fecha_auto'])
                                  <br>Fecha auto donde se legitimó: {{$solicitud['fecha_auto']}}
                                @endisset
                                
                              </td>
                              
                              <td>{{date("Y-m-d", strtotime($solicitud['alta']))}}</td>
                              <td>
                                
                                

                                @if($solicitud['estatus']=='aprobado')
                                  <div id="opciones_500{{$i}}">
                                    Estatus: Aprobado<br>
                                    <a href="javascript:void();" onclick="cancelarEstatusSolicitud('500{{$i}}', 'rechazado', '{{$solicitud['id_usuario_juicio']}}');">Denegar</a>
                                    <form target='_blank' method='GET' action="https://sicor.poderjudicialdf.gob.mx/juicios/AutorizacionImprSigj.php">
                                      <input type="hidden" name="folio" value="{{$solicitud['id_usuario_juicio']}}" />
                                      <div class="control_center" style="width: 150px;font-weight: bold">
                                          <input class="boton" value="Borrador Acuerdo" type="submit">
                                      </div>
                                    </form>
                                  </div>
                                @elseif($solicitud['estatus']=='por revisar')
                                  <div id="opciones_500{{$i}}">
                                    Estatus: Por revisar<br>
                                    <a href="javascript:void(0);" onclick="cambiarEstatusSolicitud('500{{$i}}', 'aprobado', '{{$solicitud['id_usuario_juicio']}}');">Aceptar</a><br>
                                    <a href="javascript:void();" onclick="cancelarEstatusSolicitud('500{{$i}}', 'rechazado', '{{$solicitud['id_usuario_juicio']}}');">Denegar</a>
                                  </div>
                                @elseif($solicitud['estatus']=='rechazado')

                                  <div id="opciones_500{{$i}}">
                                    Estatus: Rechazado<br>
                                    <a href="javascript:void(0);" onclick="cambiarEstatusSolicitud('500{{$i}}', 'aprobado', '{{$solicitud['id_usuario_juicio']}}');">Aceptar</a><br>

                                    <form target='_blank' method='GET' action="https://sicor.poderjudicialdf.gob.mx/juicios/RechazoImprSigj.php">
                                      <input type="hidden" name="folio" value="{{$solicitud['id_usuario_juicio']}}" />
                                      <div class="control_center" style="width: 150px;font-weight: bold">
                                          <input class="boton" value="Borrador Acuerdo" type="submit">
                                      </div>
                                    </form>
                                  </div>
                                @endif


                                <form target='_blank' method='POST' action="https://sicor.poderjudicialdf.gob.mx/seguimiento/SolicitudImprSigj.php">
                                  <input type="hidden" name="folio" value="{{$solicitud['id_usuario_juicio']}}" />
                                  <div class="control_center" style="width: 150px;font-weight: bold">
                                      <input class="boton" value="Imprimir acuse" type="submit">
                                  </div>
                                </form>

                              
                              </td>
                              
                            </tr>
                          @endif
                          @php $i++; @endphp
                        @endforeach
                      @endisset
    
    
                    </tbody>
                  </table>
            </div>
          </div>
        </div>
    </div>
    <br><br>
    <iframe src="" width="100px" height="10px" style="border:none;" id="myiframe"></iframe>
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
    $(function(){
      'use strict';
      $('.dataTables_length select, .select2').select2({ minimumResultsForSearch: Infinity });
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

  var dataTableGlobal;
  var dataTableGlobal2;
  $(document).ready(function() {
      
    dataTableGlobal=$('#datatable1').DataTable({
      bLengthChange: false, 
      searching: false,
      responsive: true,
      "ordering": true,
      "pageLength": 20
    });
  
    'use strict';
    //focus textfiled
    $('.form-layout .form-control').on('focusin', function(){
      $(this).closest('.form-group').addClass('form-group-active');
    });
    $('.form-layout .form-control').on('focusout', function(){
      $(this).closest('.form-group').removeClass('form-group-active');
    });

    $('.fc-datepicker').datepicker({
      language: 'es',
      showOtherMonths: true,
      selectOtherMonths: true,
      dateFormat: "yyyy-mm-dd"
    });
      //$( ".fc-datepicker" ).datepicker( "option", "dateFormat", "yy-mm-dd" );

    setTimeout(function(){
        $('#modal_loading').modal('hide');
    }, 1000);

    dataTableGlobal2=$('#datatable2').DataTable({
      bLengthChange: false, 
      searching: false,
      responsive: true,
      "ordering": true,
      "pageLength": 20
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
    
    if(confirm('¿Esta seguro de '+texto+' la solicitud?') && texto=="aceptar"){

      $('#opciones_'+index).html('Estatus: Aprobado<br><a href="javascript:void();" onclick="cancelarEstatusSolicitud(\''+index+'\', \'rechazado\', \''+id+'\');">Denegar</a><form target="_blank" method="GET" action="https://sicor.poderjudicialdf.gob.mx/juicios/AutorizacionImprSigj.php"><input type="hidden" name="folio" value="'+id+'" /><div class="control_center" style="width: 150px;font-weight: bold"><input class="boton" value="Borrador Acuerdo" type="submit"></div></form>');
      //dataTableGlobal.rows($('#datatable1').find('.data-row-id-'+index)).remove().draw();
      //var myWindow = window.open('http://173.254.195.43/juicios/AutorizaSeguimientoSala.php?folio='+id, "MsgWindow", "width=400,height=200");
      document.getElementById("myiframe").src = 'https://sicor.poderjudicialdf.gob.mx/juicios/AutorizaSeguimientoSala.php?folio='+id;
    }
  }

  function cancelarEstatusSolicitud(index, estatus, id, juicio_id){
    
    if(confirm('¿Esta seguro de rechazar la solicitud?')){
      $('#opciones_'+index).html('Estatus: Rechazado<br><a href="javascript:void(0);" onclick="cambiarEstatusSolicitud(\''+index+'\', \'aprobado\', \''+id+'\');">Aceptar</a><br><form target="_blank" method="GET" action="https://sicor.poderjudicialdf.gob.mx/juicios/RechazoImprSigj.php"><input type="hidden" name="folio" value="'+id+'" /><div class="control_center" style="width: 150px;font-weight: bold"><input class="boton" value="Borrador Acuerdo" type="submit"></div></form>');
      //dataTableGlobal.rows($('#datatable1').find('.data-row-id-'+index)).remove().draw();
      //var myWindow = window.open('https://173.254.195.43/juicios/RechazaSeguimientoSala.php?folio='+id, "MsgWindow", "width=400,height=200");
      document.getElementById("myiframe").src = 'https://sicor.poderjudicialdf.gob.mx/juicios/RechazaSeguimientoSala.php?folio='+id;
    }
  }

  function openWindowWithPost() {

    var form = document.createElement("form");
    //form.target = "_blank";
    form.method = "POST";
    form.action = '/procesosTrabajo/solicitudes/exportar_lista_excel';
    form.style.display = "none";


    var input = document.createElement("input");
    input.type = "hidden";
    input.name = "folio";
    input.value = $('#folio').val();
    form.appendChild(input);

    var input = document.createElement("input");
    input.type = "hidden";
    input.name = "secretaria";
    input.value = $('#secretaria').val();
    form.appendChild(input);

    var input = document.createElement("input");
    input.type = "hidden";
    input.name = "expediente";
    input.value = $('#expediente').val();
    form.appendChild(input);

    var input = document.createElement("input");
    input.type = "hidden";
    input.name = "anio";
    input.value = $('#anio').val();
    form.appendChild(input);

    var input = document.createElement("input");
    input.type = "hidden";
    input.name = "estatus";
    input.value = $('#estatus').val();
    form.appendChild(input);

    var input = document.createElement("input");
    input.type = "hidden";
    input.name = "fecha_desde";
    input.value = $('#fecha_desde').val();
    form.appendChild(input);

    var input = document.createElement("input");
    input.type = "hidden";
    input.name = "fecha_hasta";
    input.value = $('#fecha_hasta').val();
    form.appendChild(input);


    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
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