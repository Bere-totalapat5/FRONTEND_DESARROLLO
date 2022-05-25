@php
    use App\Http\Controllers\clases\humanRelativeDate;
    $humanRelativeDate = new humanRelativeDate();
@endphp

@extends('layouts.index_estadistica')

@section('contenido-pageheader')
    <ol class="breadcrumb slim-breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Información SIGJ/OPC</li>
    </ol>
    <h6 class="slim-pagetitle">Información SIGJ/OPC</h6>
@endsection


@section('contenido-principal')

    <div class="section-wrapper " style="">
        <br>


        <div class="form-layout">
            <div class="row mg-b-25">
              <div class="col-lg-6 mg-b-25">

                <label class="form-control-label">Materia: <span class="tx-danger">*</span></label>

                <div class="d-md-flex">
                    <div id="slWrapper" class="parsley-select">
                        <select class="form-control select2" id="juzgado_subtipo_id" data-placeholder="Selecciona una" data-parsley-class-handler="#slWrapper" data-parsley-errors-container="#slErrorContainer" required>
                            <option label="Selecciona una"></option>

                            @foreach($lista_materias['response'] AS $materia)
                                <option value="{{$materia['juzgado_subtipo_clave']}}" @if($materia['juzgado_subtipo_clave']==$juzgado_subtipo_id) selected @endif>{{$materia['juzgado_subtipo_nombre']}}</option>
                            @endforeach

                        </select>
                    <div id="slErrorContainer"></div>
                    </div>
                    <div class="mg-md-l-10 mg-t-10 mg-md-t-0">
                    <button onclick="irMateria();" class="btn btn-primary pd-x-20" value="5">Ir</button>
                    </div>
                </div><!-- d-flex -->




              </div><!-- col-4 -->

              @isset($lista_submateria['response'])

              <div class="col-lg-6 mg-b-25">

                <label class="form-control-label">Juzgado: <span class="tx-danger">*</span></label>

                <div class="d-md-flex">
                    <div id="slWrapper" class="parsley-select">
                        <select class="form-control select2" id="codigo_juzgado" data-placeholder="Selecciona una" data-parsley-class-handler="#slWrapper" data-parsley-errors-container="#slErrorContainer" required>
                            <option label="Selecciona una"></option>

                            @foreach($lista_submateria['response'] AS $juzgado)
                                <option value="{{$juzgado['codigo']}}" @if($juzgado['codigo']==$codigo_juicio) selected @endif >{{$juzgado['nombre']}}</option>
                            @endforeach

                        </select>
                        <div id="slErrorContainer"></div>
                    </div>
                    <div class="mg-md-l-10 mg-t-10 mg-md-t-0">
                    <button onclick="irJuzgado();" class="btn btn-primary pd-x-20" value="5">Ir</button>
                    </div>
                </div><!-- d-flex -->

              </div><!-- col-4 -->
              @endisset


              @if($codigo_juicio!="")
              <div class="col-lg-12">
                <hr>
              </div>
              <div class="col-lg-12">

                <div class="row mg-b-25">
                    <div class="col-lg-2">
                      <div class="form-group">
                        <label class="form-control-label">Expediente: <span class="tx-danger">*</span></label>
                        <input class="form-control" type="text" id="expedinete" value="{{$expedinete}}" placeholder="">
                      </div>
                    </div><!-- col-4 -->
                    <div class="col-lg-2">
                        <div class="form-group">
                          <label class="form-control-label">Año: </label>
                        <input class="form-control" type="text" id="anio" value="{{$anio}}" placeholder="">
                        </div>
                      </div><!-- col-4 -->
                    <div class="col-lg-2">
                      <div class="form-group">
                        <label class="form-control-label">Bis: </label>
                        <input class="form-control" type="text" id="bis" value="{{$bis}}" placeholder="">
                      </div>

                    </div>
                    <div class="mg-md-l-10 mg-t-10 mg-md-t-0">
                        <br>
                        <button onclick="buscarExpediente();" class="btn btn-primary pd-x-20" value="5">Buscar</button>
                        </div>
                </div>
              </div><!-- col-4 -->
              @endif



              @isset($archivo_detalle['response'])
              <div class="col-lg-12">
                <hr>
              </div>
              <div class="col-lg-12">



                <div class="table-responsive">
                    <table class="table mg-b-0">
                      <thead>
                        <tr>
                          <th>Expediente</th>
                          <th>Tipo</th>
                          <th>Acción</th>
                        </tr>
                      </thead>
                      <tbody>
                          @foreach ($archivo_detalle['response'] as $expedinetes)
                          <tr>
                            <th scope="row">{{$expedinetes['datos_archivo']['expediente']}}/{{$expedinetes['datos_archivo']['anio']}}

                              @if ($expedinetes['datos_archivo']['bis']!="")
                                Bis. {{$expedinetes['datos_archivo']['bis']}}
                              @endif

                              @if ($expedinetes['datos_archivo']['cuaderno']!="")
                                Cuaderno. {{$expedinetes['datos_archivo']['cuaderno']}}
                              @endif

                              @if ($expedinetes['datos_archivo']['alias']!="")
                                Alias. {{$expedinetes['datos_archivo']['baliasis']}}
                              @endif

                            </th>
                                <td>{{$expedinetes['datos_archivo']['tipo_expediente']}}</td>
                          <td>
                            <a href="javascript:void(0);" onclick="generarCaratulaExpediente('{{str_replace('_','',$expedinetes['datos_archivo']['tipo_expediente'])}}_{{$juzgado_subtipo_id}}_{{$codigo_juicio}}_{{$expedinetes['datos_archivo']['expediente']}}_{{$expedinetes['datos_archivo']['anio']}}_{{($bis=="") ? 0 : $bis}}_{{$expedinetes['datos_archivo']['id_juicio']}}')">Carátula</a><br>
                            <a href="javascript:void(0);" onclick="generarCaratulaExpedienteXML('{{str_replace('_','',$expedinetes['datos_archivo']['tipo_expediente'])}}_{{$juzgado_subtipo_id}}_{{$codigo_juicio}}_{{$expedinetes['datos_archivo']['expediente']}}_{{$expedinetes['datos_archivo']['anio']}}_{{($bis=="") ? 0 : $bis}}_{{$expedinetes['datos_archivo']['id_juicio']}}')">XML</a><br>
                            <a href="/estadistica/{{$juzgado_subtipo_id}}/{{$codigo_juicio}}/{{$expedinete}}/{{$anio}}/{{($bis=="") ? 0 : $bis}}/{{$expedinetes['datos_archivo']['id_juicio']}}">Seleccionar</a>
                          </td>
                          </tr>
                          @endforeach

                      </tbody>
                    </table>
                  </div><!-- table-responsive -->



              </div><!-- col-4 -->
              @endisset



              @isset($lista_acuerdos['response'])
              <div class="col-lg-12">
                <hr>
              </div>
              <a href="javascript:void(0);" onclick="generarCaratula()">Generar carátula</a>
              <div class="col-lg-12">



                <div class="table-responsive">
                    <table class="table mg-b-0">
                      <thead>
                        <tr>
                          <th>Fecha</th>
                          <th>Acuerdo</th>
                          <th>Acuerdo</th>
                          <th>Promoción</th>
                        </tr>
                      </thead>
                      <tbody>
                          @foreach ($lista_acuerdos['response'] as $acuerdos)
                            @if($acuerdos['tipo']=='acuerdo')
                            <tr>
                                <th scope="row">{{$acuerdos['fecha']}}</th>
                                <td>{{$acuerdos['acuerdo']}}</td>
                                <td>
                                    <label class="ckbox">
                                        <input type="checkbox" class="chbox_acuerdo" value="acuerdo_{{$juzgado_subtipo_id}}_{{$codigo_juicio}}_{{$expedinete}}_{{$anio}}_{{($bis=="") ? 0 : $bis}}_{{$archivo_detalle['response'][0]['datos_archivo']['id_juicio']}}_{{$acuerdos['id']}}_{{$acuerdos['acuerdo']}}_{{$acuerdos['fecha']}}"><span>Seleccionar</span>
                                      </label>

                                    </td>
                                    <td>
                                        <label class="ckbox">
                                            <input type="checkbox" class="chbox_acuerdo" value="promocion_{{$juzgado_subtipo_id}}_{{$codigo_juicio}}_{{$expedinete}}_{{$anio}}_{{($bis=="") ? 0 : $bis}}_{{$archivo_detalle['response'][0]['datos_archivo']['id_juicio']}}_{{$acuerdos['id']}}_{{$acuerdos['acuerdo']}}_{{$acuerdos['fecha']}}"><span>Seleccionar</span>
                                          </label>

                                        </td>
                            </tr>
                            @endif
                          @endforeach

                      </tbody>
                    </table>
                  </div><!-- table-responsive -->



              </div><!-- col-4 -->
              @endisset



            </div>
        </div>





    </div><!-- section-wrapper -->
@endsection

@section('seccion-estilos')
    <link href="{{ $entorno["version_pages"]["version"] }}/lib/select2/css/select2.min.css" rel="stylesheet">
    <link href="{{ $entorno["version_pages"]["version"] }}/lib/jt.timepicker/css/jquery.timepicker.css" rel="stylesheet">
    <link href="{{ $entorno["version_pages"]["version"] }}/lib/select2/css/select2.min.css" rel="stylesheet">
    <!-- graficas -->
    <link href="{{ $entorno["version_pages"]["version"] }}/lib/morris.js/css/morris.css" rel="stylesheet">

    <style type="text/css" >
	    circle{
            cursor: pointer;
        }

        .ckbox span:before{
            content:'' !important;
            border:1px solid #adb5bd !important;
        }

	</style>
@endsection

@section('seccion-scripts-libs')
    <script src="{{ $entorno["version_pages"]["version"] }}/lib/raphael/js/raphael.min.js"></script>
    <script src="{{ $entorno["version_pages"]["version"] }}/lib/morris.js/js/morris.js"></script>
    <script src="{{ $entorno["version_pages"]["version"] }}/lib/select2/js/select2.full.min.js"></script>
@endsection

@section('seccion-scripts-functions')
    <script>
        setTimeout(function(){
            $('#modal_loading').modal('hide');
        }, 1000);

        $(document).ready(function() {


            $('.select2').select2({
                minimumResultsForSearch: Infinity // disabling search
            });
        });

        function irMateria(){
            materia=$( "#juzgado_subtipo_id option:selected" ).val();
            location="/estadistica/"+materia;
        }

        function irJuzgado(){
            materia=$( "#juzgado_subtipo_id option:selected" ).val();
            juzgado=$( "#codigo_juzgado option:selected" ).val();
            location="/estadistica/"+materia+"/"+juzgado;
        }

        function buscarExpediente(){
            materia=$( "#juzgado_subtipo_id option:selected" ).val();
            juzgado=$( "#codigo_juzgado option:selected" ).val();

            expedinete=$( "#expedinete" ).val();
            anio=$( "#anio" ).val();
            bis=$( "#bis" ).val();

            location="/estadistica/"+materia+"/"+juzgado+"/"+expedinete+"/"+anio+"/"+bis;
        }


        function generarCaratulaExpediente(expediente_arr){

           var arr_acuerdo="";
           arr_acuerdo=expediente_arr+"-*-";

           console.log(arr_acuerdo);

           if(arr_acuerdo!="" || arr_promocion!=""){

               var form = $('<form></form>');

               form.attr("method", "post");
               form.attr("target", "_blank");
               form.attr("action", "/estadistica/generar_caratula");

               var field = $('<input></input>');
               field.attr("type", "hidden");
               field.attr("name", "juzgado");
               field.attr("value", $('#codigo_juzgado option:selected').text());
               form.append(field);

               var field = $('<input></input>');
               field.attr("type", "hidden");
               field.attr("name", "arr_acuerdo");
               field.attr("value", arr_acuerdo);
               form.append(field);


               // The form needs to be a part of the document in
               // order for us to be able to submit it.
               $(document.body).append(form);
               form.submit();
           }
           else{
               alert("Debe de seleccionar un acuerdo para generar alguna carátula");
           }
       }

       function generarCaratulaExpedienteXML(expediente_arr){

           if('¿Esta seguro de crear una nueva carátula en formato XML?'){
            var arr_acuerdo="";
            arr_acuerdo=expediente_arr+"-*-";

            console.log(arr_acuerdo);

            if(arr_acuerdo!="" || arr_promocion!=""){

                var form = $('<form></form>');

                form.attr("method", "post");
                form.attr("target", "_blank");
                form.attr("action", "/estadistica/generar_caratula_xml");

                var field = $('<input></input>');
                field.attr("type", "hidden");
                field.attr("name", "juzgado");
                field.attr("value", $('#codigo_juzgado option:selected').text());
                form.append(field);

                var field = $('<input></input>');
                field.attr("type", "hidden");
                field.attr("name", "arr_acuerdo");
                field.attr("value", arr_acuerdo);
                form.append(field);


                // The form needs to be a part of the document in
                // order for us to be able to submit it.
                $(document.body).append(form);
                form.submit();
            }
            else{
                alert("Debe de seleccionar un acuerdo para generar alguna carátula");
            }
           }
       }






        function generarCaratula(){

            var arr_acuerdo="";
            $( ".chbox_acuerdo" ).each(function( index ) {
                if($(this).is(':checked')) {
                    arr_acuerdo+=$(this).val()+'-*-';
                }
            });

            var arr_promocion="";
            $( ".chbox_promocion" ).each(function( index ) {
                if($(this).is(':checked')) {
                    arr_promocion+=$(this).val()+'-*-';
                }
            });

            console.log(arr_acuerdo);
            console.log(arr_promocion);

            if(arr_acuerdo!="" || arr_promocion!=""){

                var form = $('<form></form>');

                form.attr("method", "post");
                form.attr("target", "_blank");
                form.attr("action", "/estadistica/generar_caratula");

                var field = $('<input></input>');
                field.attr("type", "hidden");
                field.attr("name", "juzgado");
                field.attr("value", $('#codigo_juzgado option:selected').text());
                form.append(field);

                var field = $('<input></input>');
                field.attr("type", "hidden");
                field.attr("name", "arr_acuerdo");
                field.attr("value", arr_acuerdo);
                form.append(field);

                var field = $('<input></input>');
                field.attr("type", "hidden");
                field.attr("name", "arr_promocion");
                field.attr("value", arr_promocion);
                form.append(field);


                // The form needs to be a part of the document in
                // order for us to be able to submit it.
                $(document.body).append(form);
                form.submit();
            }
            else{
                alert("Debe de seleccionar un acuerdo para generar alguna carátula");
            }

        }

        function cargarInfoAgenda(agenda_id){
            alert(agenda_id);
            $('#modaldemo3').modal('show');
            $('#modaldemo3').find('.modal-header').html('');
            $('#modaldemo3').find('.modal-body').html('<div class="col-md-12 col-xl-12"><div class="d-flex  ht-300 pos-relative align-items-center">    <div class="sk-three-bounce">        <div class="sk-child sk-bounce1 bg-gray-800"></div>        <div class="sk-child sk-bounce2 bg-gray-800"></div>        <div class="sk-child sk-bounce3 bg-gray-800"></div>      </div> </div><!-- d-flex --></div><!-- col-4 -->');

            $.ajax({
                type:'POST',
                url:'/agendas/consultaEventoAjax',
                data:{ agenda_id:agenda_id },
                success:function(data){
                    console.log(data);
                    $('#modaldemo3').find('.modal-header').html(data.plantilla_archivo_header);
                    $('#modaldemo3').find('.modal-body').html(data.plantilla_archivo_body);
                }
            });
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
