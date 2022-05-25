@php
    use App\Http\Controllers\clases\humanRelativeDate;
    $humanRelativeDate = new humanRelativeDate();
@endphp

@extends('layouts.index')

@section('contenido-pageheader')
    <ol class="breadcrumb slim-breadcrumb">
        <li class="breadcrumb-item"><a href="/home">Home</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="window.history.back();">Bandeja</a></li> 
        <li class="breadcrumb-item active" aria-current="page">Editar Acuerdo</li>
    </ol>
    <h6 class="slim-pagetitle">Editar Acuerdo</h6>
@endsection


@section('contenido-principal')
  <div class="section-wrapper">
    <div class="row">
      <div class="col-lg-12">
        <h3 class="card-profile-name">Editar Acuerdo {{$acuerdo}}</h3>
      </div>
      
      <div class="col-lg-4 ">
        <button class="btn btn-primary  btn-block mg-b-10" onclick="window.history.back();">Regresar</button>
      </div>

      <div class="col-lg-4 ">
        <button class="btn btn-info  btn-block mg-b-10" onclick="guardar_editor_HTML();">Guardar</button>
      </div>

      <div class="col-lg-4 ">
        @if($bandeja=="firma" and 0)
          <button class="btn btn-secondary  btn-block mg-b-10" onclick="avanzarFlujo();">Firmar</button>
        @endif
      </div>


      <div class="col-lg-12 ">
        
        <div id="editor" style="">
          <div id='edit' style="margin-top: 20px; width:100%;">
            {!! $contenido !!}
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('seccion-estilos')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="/box/froala_editor_3.1.1/css/froala_editor.css">
<link rel="stylesheet" href="/box/froala_editor_3.1.1/css/froala_style.css">
<link rel="stylesheet" href="/box/froala_editor_3.1.1/css/plugins/code_view.css">
<link rel="stylesheet" href="/box/froala_editor_3.1.1/css/plugins/colors.css">
<link rel="stylesheet" href="/box/froala_editor_3.1.1/css/plugins/emoticons.css">
<link rel="stylesheet" href="/box/froala_editor_3.1.1/css/plugins/image_manager.css">
<link rel="stylesheet" href="/box/froala_editor_3.1.1/css/plugins/image.css">
<link rel="stylesheet" href="/box/froala_editor_3.1.1/css/plugins/line_breaker.css">
<link rel="stylesheet" href="/box/froala_editor_3.1.1/css/plugins/quick_insert.css">
<link rel="stylesheet" href="/box/froala_editor_3.1.1/css/plugins/table.css">
<link rel="stylesheet" href="/box/froala_editor_3.1.1/css/plugins/file.css">
<link rel="stylesheet" href="/box/froala_editor_3.1.1/css/plugins/char_counter.css">
<link rel="stylesheet" href="/box/froala_editor_3.1.1/css/plugins/video.css">
<link rel="stylesheet" href="/box/froala_editor_3.1.1/css/plugins/emoticons.css">
<link rel="stylesheet" href="/box/froala_editor_3.1.1/css/plugins/fullscreen.css">
@endsection

@section('seccion-scripts-libs')
<script type="text/javascript" src="/box/froala_editor_3.1.1/js/froala_editor.min.js"></script>
<script type="text/javascript" src="/box/froala_editor_3.1.1/js/froala_editor.pkgd.min.js"></script>
<script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/align.min.js"></script>
<script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/code_beautifier.min.js"></script>
<script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/code_view.min.js"></script>
<script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/colors.min.js"></script>
<script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/emoticons.min.js"></script>
<script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/draggable.min.js"></script>
<script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/font_size.min.js"></script>
<script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/font_family.min.js"></script>
<script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/image.min.js"></script>
<script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/image_manager.min.js"></script>
<script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/line_breaker.min.js"></script>
<script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/quick_insert.min.js"></script>
<script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/link.min.js"></script>
<script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/lists.min.js"></script>
<script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/paragraph_format.min.js"></script>
<script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/paragraph_style.min.js"></script>
<script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/video.min.js"></script>
<script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/table.min.js"></script>
<script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/url.min.js"></script>
<script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/emoticons.min.js"></script>
<script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/file.min.js"></script>
<script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/entities.min.js"></script>
<script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/inline_style.min.js"></script>
<script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/save.min.js"></script>
<script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/fullscreen.min.js"></script>
<script type="text/javascript" src="/box/froala_editor_3.1.1/js/languages/es.js"></script>
<script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/quote.min.js"></script>
<script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/char_counter.min.js"></script>
@endsection

@section('seccion-scripts-functions')
  <script>
    var editor_html;
    $(document).ready(function() {
      
      setTimeout(function(){
        (function() {
          editor_html = new FroalaEditor("#edit", {
              height: 'calc(100vh - 100vh/2)', 
              language: 'es',
              imageDefaultWidth: 0,
              imageOutputSize: true,

              key: '0BA3jA11A8B5A3E4D4aIVLEABVAYFKc2Cb1MYGH1g1NYVMiG5G4E3C3A1C8C6D4A3F4==',
              embedlyKey: '0BA3jA11A8B5A3E4D4aIVLEABVAYFKc2Cb1MYGH1g1NYVMiG5G4E3C3A1C8C6D4A3F4==',

              attribution: false,
              autofocus: true,
              htmlUntouched: true,
              htmlAllowedAttrs: ['v:shapes'],
              imageUploadParams:{
                'v:shapes':'mi_prueba'
              },
              imageRoundPercent: true,

              // Set custom buttons with separator between them.
              toolbarButtons: {
                'moreText': {
                  'buttons': ['bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'fontFamily', 'fontSize', 'textColor', 'backgroundColor', 'inlineClass', 'inlineStyle', 'clearFormatting']
                },
                'moreParagraph': {
                  'buttons': ['alignLeft', 'alignCenter', 'formatOLSimple', 'alignRight', 'alignJustify', 'formatOL', 'formatUL', 'paragraphFormat', 'paragraphStyle', 'lineHeight', 'outdent', 'indent', 'quote']
                },
                'moreRich': {
                  'buttons': ['insertLink', 'insertImage', 'insertVideo', 'insertTable', 'emoticons', 'fontAwesome', 'specialCharacters', 'embedly', 'insertFile', 'insertHR']
                },
                'moreMisc': {
                  'buttons': ['undo', 'redo', 'fullscreen', 'print', 'getPDF', 'spellChecker', 'selectAll', 'html', 'help']
                }
              },
              imageEditButtons: [['imageReplace', 'imageAlign', 'imageRemove', '|', 'imageLink', 'linkOpen', 'linkEdit', 'linkRemove', '-', 'imageDisplay', 'imageStyle', 'imageAlt', 'imageSize']],
              toolbarButtonsXS: [['undo', 'redo'], ['bold', 'italic', 'underline']],
              events: {
              'image.beforeUpload': function (files) {
                const editor = this
                if (files.length) {
                  var reader = new FileReader()
                  reader.onload = function (e) {
                    var result = e.target.result;
                    console.log(result);
                    console.log(e.target);
                    num1=Math.floor(Math.random() * 100) + 1;
                    num2=Math.floor(Math.random() * 100) + 1;

                    editor.image.insert(result, null, {'v:shapes': 'Imagen_'+num1+'_'+num2+''}, editor.image.get())

                    const dataAttributesToFix = ['v:shapes'] // replace this for the attributes you want fixed 
                    editor.events.on('image.inserted', image => {
                      dataAttributesToFix.forEach(k => {
                        if (image.attr('data-str' + k)) {
                            image.attr( k, image.attr('data-str' + k))
                            image.removeAttr('data-str' + k)
                        }
                      })
                    })

                  }
                  reader.readAsDataURL(files[0])  
                }
                return false
              }
            }
          })
        })()
      }, 500);


      //fechas
      $('.fc-datepicker').datepicker({
          language: 'es',
          showOtherMonths: true,
          selectOtherMonths: true
      });
      
      setTimeout(function(){
          $('#modal_loading').modal('hide');
      }, 500);

    });


    function guardar_editor_HTML(){
      $('#modal_loading').modal({backdrop: 'static', keyboard: false});

      texto=editor_html.html.get();
      $.ajax({
          type:'POST',
          url:'/bandejas/guardarEditorHTML',
          data:{ tipo:'acuerdo', id_acuerdo:'{{$id_acuerdo}}', id_juicio:'{{$id_juicio}}', ponencia:'{{$request->session()->get('usuario_juzgado')}}',  flujo_id:'{{$flujo_id}}', documento_html:texto },
          success:function(data){
              alert('Se guardó exitosamente');
              

              $('#modal_loading').modal('hide');

              $('#modaldemo_editar_html').css('z-index', '1050');
              console.log(data);
              //location.reload();
          }
      });
    }

    function seleccionarCredenciales(tipo){
        if(tipo=="firel"){
            $('#id_pfx').css("display", "block");
            $('#id_key').css("display", "none");
            $('#id_cert').css("display", "none");
            $('#id_contrasenia').css("display", "block");
        }
        else if(tipo=="fiel"){
            $('#id_pfx').css("display", "none");
            $('#id_key').css("display", "block");
            $('#id_cert').css("display", "block");
            $('#id_contrasenia').css("display", "block");
        }
        else{
            $('#id_pfx').css("display", "none");
            $('#id_key').css("display", "none");
            $('#id_cert').css("display", "none");
            $('#id_contrasenia').css("display", "none");
        }
    }

    function avanzarFlujo(id_acuerdo=0, bandeja='firma', accion='avance', index=0, codigo_organo=0, ultima_version=0, tipo_firma='firel', id_juicio=0, tipo_flujo_nombre="", sello=1){
      
      id_acuerdo={{$id_acuerdo}};
      codigo_organo='{{$request->session()->get('usuario_juzgado')}}';
      id_juicio={{$id_juicio}};

      arr_imprimir=Array();

      if(accion=='avance' || accion=="corregido"){
        console.log(index);


        $('#nav-profile-tab_1').css('display', 'none');
        $('#nav-profile-tab_2').css('display', 'none');
        $('#nav-profile-tab_3').css('display', 'none');
        $('#nav-profile-tab_4').css('display', 'none');
        $('#nav-profile-tab_5').css('display', 'none');
        $('#nav-profile-tab_6').css('display', 'none');
        $('#nav-profile-tab_7').css('display', 'none');
        $('#nav-profile-tab_8').css('display', 'none');
        $('#nav-profile-tab_9').css('display', 'none');
        $('#nav-profile-tab_10').css('display', 'none');
        $('#nav-profile-tab_11').css('display', 'none');
        $('#nav-profile-tab_12').css('display', 'none');
        $('#nav-profile-tab_13').css('display', 'none');
        $('#nav-profile-tab_14').css('display', 'none');
        $('#nav-profile-tab_15').css('display', 'none');
        $('#nav-profile-tab_16').css('display', 'none');
        $('#nav-profile-tab_17').css('display', 'none');
        $('#nav-profile-tab_18').css('display', 'none');
        $('#nav-profile-tab_19').css('display', 'none');
        $('#nav-profile-tab_20').css('display', 'none');
        $('#preview_pdf_1').html("");
        $('#preview_pdf_2').html("");
        $('#preview_pdf_3').html("");
        $('#preview_pdf_4').html("");
        $('#preview_pdf_5').html("");
        $('#preview_pdf_6').html("");
        $('#preview_pdf_7').html("");
        $('#preview_pdf_8').html("");
        $('#preview_pdf_9').html("");
        $('#preview_pdf_10').html("");
        $('#preview_pdf_11').html("");
        $('#preview_pdf_12').html("");
        $('#preview_pdf_13').html("");
        $('#preview_pdf_14').html("");
        $('#preview_pdf_15').html("");
        $('#preview_pdf_16').html("");
        $('#preview_pdf_17').html("");
        $('#preview_pdf_18').html("");
        $('#preview_pdf_19').html("");
        $('#preview_pdf_20').html("");


        if(tipo_firma=='firel' & bandeja=="firma"){

            $.ajax({
                type:'POST',
                url: "{{ route('bandeja.descargarPDFPreview') }}",
                data:{ id_acuerdo:id_acuerdo, id_juicio:id_juicio, codigo_organo:codigo_organo  },
                success:function(data){
                    breakSesion(data);
                    console.log(data);

                    if(data.status==100){

                        //se pone el pdf en el preview
                        $('#preview_pdf_1').html('<object data="'+data.response+'" type="application/pdf" id="" width="100%" height="350px"></object>');
                        $('#nav-profile-tab_1').css("display", "block");
                        $('#nav-profile-tab_1').click();


                        $('#modal_id_acuerdo').val(id_acuerdo);
                        $('#modal_bandeja').val(bandeja);
                        $('#modal_accion').val(accion);
                        $('#modal_index').val(index);
                        $('#modal_codigo_organo').val(codigo_organo);
                        $('#modal_ultima_version').val(ultima_version);
                        $('#modal_tipo_firma').val(tipo_firma);
                        $('#modal_id_juicio').val(id_juicio);
                        $('#modal_tipo_flujo_nombre').val(tipo_flujo_nombre);

                        if(sello==0){
                            $('#sello_sigj_visible').css('display', 'none');
                        }

                        //se muesstra el modal de la firel
                        $('#modal_firel').modal('show');
                    }
                    else{
                        alert(data.message);
                    }
                }
            });
        }
        else{
                
            $('#modal_loading').modal({backdrop: 'static', keyboard: false})
            $.ajax({
                type:'POST',
                url: "{{ route('bandeja.bandeja_avanzar_revision_ajax') }}",
                data:{ accion:accion, id_acuerdo:id_acuerdo, codigo_organo:codigo_organo, ultima_version:ultima_version, bandeja:bandeja, tipo_firma:tipo_firma, tipo_flujo_nombre:tipo_flujo_nombre },
                success:function(data){
                    console.log(data);
                    breakSesion(data);
                    setTimeout(function(){
                        $('#modal_loading').modal('hide');
                    }, 500);

                    if(data.status!=0){
                        if(data.response.finalizacion_flujo=="si"){
                            alert("La fecha de publicación es: " + data.response.fecha_a_publicar);
                        }

                        $('#bandejas_sicor').find('#'+bandeja).html($('#bandejas_sicor').find('#'+bandeja).html()-1);
                        //$('#datatable1').find('.data-row-id-'+index).fadeOut('slow', function($row){
                            dataTableGlobal.rows($('#datatable1').find('.data-row-id-'+index)).remove().draw();
                        //});
                    }
                    else{
                        alert('Problemas al avanzar el flujo');
                    }
                }
            });
        }
      }
    }


    function procesarFirel(){


      if($('#modal_masivo').val()==0){
          console.log('Es individual');

          
          //manejo de modales
          $('#modal_firel').modal('hide');
          $('#modal_loading').modal({backdrop: 'static', keyboard: false});

          jQuery.ajax({
              type: 'POST',
              url:"{{ route('bandeja.bandeja_firmar_firel_ajax') }}",
              data: new FormData($("#form_firma_firel")[0]),
              processData: false, 
              contentType: false,
              async: true,
              success: function(data) {
                  breakSesion(data);
                  console.log(data);
                  

                  setTimeout(function(){
                      $('#modal_loading').modal('hide');
                  }, 500);
                  
                  if(data.error==1){
                      alert(data.mensaje);
                  }
                  else{
                      if(data.response.finalizacion_flujo=="si"){
                          alert("La fecha de publicación es: " + data.response.fecha_a_publicar);
                      }
                      bandeja=$('#modal_bandeja').val();
                      index=$('#modal_index').val();

                      $('#bandejas_sicor').find('#'+bandeja).html($('#bandejas_sicor').find('#'+bandeja).html()-1);
                      //$('#datatable1').find('.data-row-id-'+index).fadeOut('slow', function($row){
                          //dataTableGlobal.rows($('#datatable1').find('.data-row-id-'+index)).remove().draw();  
                      //});
                      location="/bandejas/firma/";
                  }
              }
          });
      }
      else{
          console.log('se manda al masivo');
          $('#modal_firel').modal('hide');


          total=arr_imprimir.length;
          $('#modal_loading').modal({backdrop: 'static', keyboard: false});
          $('#modal_loading').find('#mensaje_procesos').html('Procesando '+procesado+' de ' + total);


          setTimeout(function(){
              procesarMasivoFirmas();
          }, 500);
          
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


   <!-- LARGE MODAL -->
<div id="modal_firel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" >
  <div class="modal-dialog modal-lg modal-dialog-vertical-center modal-dialog-centered" role="document" style="width: 95%;">
    <div class="modal-content tx-size-sm" >
      <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Firma del documento</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
      </div>
      <div class="modal-body pd-20">
          <form id="form_firma_firel" enctype="multipart/form-data" method="post">

              <input type="hidden" value="" name="modal_id_acuerdo" id="modal_id_acuerdo">
              <input type="hidden" value="" name="modal_bandeja" id="modal_bandeja">
              <input type="hidden" value="" name="modal_accion" id="modal_accion">
              <input type="hidden" value="" name="modal_index" id="modal_index">
              <input type="hidden" value="" name="modal_codigo_organo" id="modal_codigo_organo">
              <input type="hidden" value="" name="modal_ultima_version" id="modal_ultima_version">
              <input type="hidden" value="" name="modal_tipo_firma" id="modal_tipo_firma">
              <input type="hidden" value="" name="modal_masivo" id="modal_masivo">
              <input type="hidden" value="" name="modal_id_juicio" id="modal_id_juicio">
              <input type="hidden" value="" name="modal_tipo_flujo_nombre" id="modal_tipo_flujo_nombre">
              
               
              
              <div class="media-body table-responsive-xl" style="">
                  <h5 class="card-profile-name">Selecciona el tipo de firma</h5>
                  <p class="card-profile-position"> 
                      <div class="row col-lg-12" id="">
                          <div class="col-lg-4">
                              <label class="rdiobox">
                                <input name="tipo_firma_firel" type="radio" id="tipo_firma_firel" value="firel" checked onclick="seleccionarCredenciales('firel')">
                                <span>Firel</span>
                              </label>
                            </div><!-- col-3 -->
                            <div class="col-lg-4 mg-t-20 mg-lg-t-0">
                              <label class="rdiobox">
                                <input name="tipo_firma_firel" type="radio" id="tipo_firma_firel" value="fiel" onclick="seleccionarCredenciales('fiel')">
                                <span>E.Firma</span>
                              </label>
                            </div><!-- col-3 -->
                            <div class="col-lg-4 mg-t-20 mg-lg-t-0" id="sello_sigj_visible_1">
                              <label class="rdiobox">
                                <input name="tipo_firma_firel" type="radio" id="tipo_firma_firel" value="sello_sigj" onclick="seleccionarCredenciales('sello_sigj')">
                                <span>Sello SIGJ</span>
                              </label>
                            </div><!-- col-3 -->
                      </div>
                      <hr>

                      <div class="col-lg-12" id="id_pfx">
                          <div class="form-group">
                              <label class="form-control-label" ><span class="tx-danger">*</span> Archivo PFX:</label>
                              <div id="div_upload" class="field"  >
                                  <input class="btn btn-oblong btn-outline-primary" type="file" name="archivo_pfx" id="archivo_pfx" size="50" required accept=".pfx">
                              </div>
                          </div>
                      </div><!-- col-2 -->


                      <div class="col-lg-12" id="id_key" style="display: none;">
                          <div class="form-group">
                              <label class="form-control-label" ><span class="tx-danger">*</span> Archivo KEY:</label>
                              <div id="div_upload" class="field"  >
                                  <input class="btn btn-oblong btn-outline-primary" type="file" name="archivo_key" id="archivo_key" size="50" required accept=".key">
                              </div>
                          </div>
                      </div><!-- col-2 -->
                      <div class="col-lg-12" id="id_cert" style="display: none;">
                          <div class="form-group">
                              <label class="form-control-label" ><span class="tx-danger">*</span> Archivo CER:</label>
                              <div id="div_upload" class="field"  >
                                  <input class="btn btn-oblong btn-outline-primary" type="file" name="archivo_cer" id="archivo_cer" size="50" required accept=".cer">
                              </div>
                          </div>
                      </div><!-- col-2 -->




                      <div class="col-lg-12" id="id_contrasenia">

                          <div class="form-group">
                              <label class="form-control-label">Contraseña: <span class="tx-danger">*</span></label>
                              <input class="form-control" type="password" name="password" value="" placeholder="" required>
                          </div>
                      </div>
                      <div class="col-lg-12">
                          <button type="button" class="btn btn-primary" onclick="procesarFirel();">Firmar</button>
                      </div>
                  </p>
                  
                  <nav>
                      <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-profile-tab_1" data-toggle="tab" href="#preview_pdf_1" role="tab" aria-controls="nav-home" aria-selected="true" >Documento a firmar 1</a>
                        <a class="nav-item nav-link" id="nav-profile-tab_2" data-toggle="tab" href="#preview_pdf_2" role="tab" aria-controls="nav-profile" aria-selected="false" >Documento a firmar 2</a>
                        <a class="nav-item nav-link" id="nav-profile-tab_3" data-toggle="tab" href="#preview_pdf_3" role="tab" aria-controls="nav-contact" aria-selected="false" >Documento a firmar 3</a>
                        <a class="nav-item nav-link" id="nav-profile-tab_4" data-toggle="tab" href="#preview_pdf_4" role="tab" aria-controls="nav-contact" aria-selected="false" >Documento a firmar 4</a>
                        <a class="nav-item nav-link" id="nav-profile-tab_5" data-toggle="tab" href="#preview_pdf_5" role="tab" aria-controls="nav-contact" aria-selected="false" >Documento a firmar 5</a>
                        <a class="nav-item nav-link" id="nav-profile-tab_6" data-toggle="tab" href="#preview_pdf_6" role="tab" aria-controls="nav-contact" aria-selected="false" >Documento a firmar 6</a>
                        <a class="nav-item nav-link" id="nav-profile-tab_7" data-toggle="tab" href="#preview_pdf_7" role="tab" aria-controls="nav-contact" aria-selected="false" >Documento a firmar 7</a>
                        <a class="nav-item nav-link" id="nav-profile-tab_8" data-toggle="tab" href="#preview_pdf_8" role="tab" aria-controls="nav-contact" aria-selected="false" >Documento a firmar 8</a>
                        <a class="nav-item nav-link" id="nav-profile-tab_9" data-toggle="tab" href="#preview_pdf_9" role="tab" aria-controls="nav-contact" aria-selected="false" >Documento a firmar 9</a>
                        <a class="nav-item nav-link" id="nav-profile-tab_10" data-toggle="tab" href="#preview_pdf_10" role="tab" aria-controls="nav-contact" aria-selected="false" >Documento a firmar 10</a>
                        <a class="nav-item nav-link" id="nav-profile-tab_11" data-toggle="tab" href="#preview_pdf_11" role="tab" aria-controls="nav-contact" aria-selected="false" >Documento a firmar 11</a>
                        <a class="nav-item nav-link" id="nav-profile-tab_12" data-toggle="tab" href="#preview_pdf_12" role="tab" aria-controls="nav-contact" aria-selected="false" >Documento a firmar 12</a>
                        <a class="nav-item nav-link" id="nav-profile-tab_13" data-toggle="tab" href="#preview_pdf_13" role="tab" aria-controls="nav-contact" aria-selected="false" >Documento a firmar 13</a>
                        <a class="nav-item nav-link" id="nav-profile-tab_14" data-toggle="tab" href="#preview_pdf_14" role="tab" aria-controls="nav-contact" aria-selected="false" >Documento a firmar 14</a>
                        <a class="nav-item nav-link" id="nav-profile-tab_15" data-toggle="tab" href="#preview_pdf_15" role="tab" aria-controls="nav-contact" aria-selected="false" >Documento a firmar 15</a>
                        <a class="nav-item nav-link" id="nav-profile-tab_16" data-toggle="tab" href="#preview_pdf_16" role="tab" aria-controls="nav-contact" aria-selected="false" >Documento a firmar 16</a>
                        <a class="nav-item nav-link" id="nav-profile-tab_17" data-toggle="tab" href="#preview_pdf_17" role="tab" aria-controls="nav-contact" aria-selected="false" >Documento a firmar 17</a>
                        <a class="nav-item nav-link" id="nav-profile-tab_18" data-toggle="tab" href="#preview_pdf_18" role="tab" aria-controls="nav-contact" aria-selected="false" >Documento a firmar 18</a>
                        <a class="nav-item nav-link" id="nav-profile-tab_19" data-toggle="tab" href="#preview_pdf_19" role="tab" aria-controls="nav-contact" aria-selected="false" >Documento a firmar 19</a>
                        <a class="nav-item nav-link" id="nav-profile-tab_20" data-toggle="tab" href="#preview_pdf_20" role="tab" aria-controls="nav-contact" aria-selected="false" >Documento a firmar 20</a>
                      </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                      <div class="tab-pane fade show active" id="preview_pdf_1" role="tabpanel" aria-labelledby="nav-home-tab"></div>
                      <div class="tab-pane fade" id="preview_pdf_2" role="tabpanel" aria-labelledby="nav-profile-tab"></div>
                      <div class="tab-pane fade" id="preview_pdf_3" role="tabpanel" aria-labelledby="nav-contact-tab"></div>
                      <div class="tab-pane fade" id="preview_pdf_4" role="tabpanel" aria-labelledby="nav-contact-tab1"></div>
                      <div class="tab-pane fade" id="preview_pdf_5" role="tabpanel" aria-labelledby="nav-contact-tab2"></div>
                      <div class="tab-pane fade" id="preview_pdf_6" role="tabpanel" aria-labelledby="nav-contact-tab3"></div>
                      <div class="tab-pane fade" id="preview_pdf_7" role="tabpanel" aria-labelledby="nav-contact-tab4"></div>
                      <div class="tab-pane fade" id="preview_pdf_8" role="tabpanel" aria-labelledby="nav-contact-tab5"></div>
                      <div class="tab-pane fade" id="preview_pdf_9" role="tabpanel" aria-labelledby="nav-contact-tab6"></div>
                      <div class="tab-pane fade" id="preview_pdf_10" role="tabpanel" aria-labelledby="nav-contact-tab7"></div>
                      <div class="tab-pane fade" id="preview_pdf_11" role="tabpanel" aria-labelledby="nav-contact-tab7"></div>
                      <div class="tab-pane fade" id="preview_pdf_12" role="tabpanel" aria-labelledby="nav-contact-tab7"></div>
                      <div class="tab-pane fade" id="preview_pdf_13" role="tabpanel" aria-labelledby="nav-contact-tab7"></div>
                      <div class="tab-pane fade" id="preview_pdf_14" role="tabpanel" aria-labelledby="nav-contact-tab7"></div>
                      <div class="tab-pane fade" id="preview_pdf_15" role="tabpanel" aria-labelledby="nav-contact-tab7"></div>
                      <div class="tab-pane fade" id="preview_pdf_16" role="tabpanel" aria-labelledby="nav-contact-tab7"></div>
                      <div class="tab-pane fade" id="preview_pdf_17" role="tabpanel" aria-labelledby="nav-contact-tab7"></div>
                      <div class="tab-pane fade" id="preview_pdf_18" role="tabpanel" aria-labelledby="nav-contact-tab7"></div>
                      <div class="tab-pane fade" id="preview_pdf_19" role="tabpanel" aria-labelledby="nav-contact-tab7"></div>
                      <div class="tab-pane fade" id="preview_pdf_20" role="tabpanel" aria-labelledby="nav-contact-tab7"></div>
                    </div>


                  
                  <!--
                  <iframe src="" style="width:100%; height:300px; border:solid 1px #cccccc;">Vista previa del coumento</iframe>
                  -->
                  <br>
              </div>
          </form>
      </div><!-- modal-body -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div><!-- modal-dialog -->
</div><!-- modal -->

@endsection