@php
  use App\Http\Controllers\clases\humanRelativeDate;
  use App\Http\Controllers\clases\utilidades;
  $humanRelativeDate = new humanRelativeDate();
@endphp
@extends('layouts.index')
@section('contenido-pageheader')
  <ol class="breadcrumb slim-breadcrumb d-none d-md-flex">
    <li class="breadcrumb-item"><a href="/home">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Prueba firma electrónica</li>
  </ol>
  <h6 class="slim-pagetitle" id="title_tareas">Prueba firma electrónica</h6>
@endsection

@section('contenido-principal')
  <div class="section-wrapper mg-b-100" id="pageone" data-role="page">
    <form id="form_firma_firel" enctype="multipart/form-data" method="post">
      <div class="row">
        <div class="col-lg-12">
          <h6 class="slim-pagetitle" id="">Documento</h6>
          <br>
          <div class="row mg-t-15 pd-r-10 pd-l-10">
            <div class="col-md-4">
              <label class="rdiobox">
                <input name="doc" type="radio" value="subir" class="doc" onchange="tipoDocumento()" checked>
                <span>Subir Documento</span>
              </label>
            </div>
            <div class="col-md-4">
              <label class="rdiobox">
                <input name="doc" type="radio" value="crear" class="doc" onchange="tipoDocumento()">
                <span>Crear Documento en Línea</span>
              </label>
            </div>
          </div>
          <div class="mg-t-40  d-none" id="porDOC">
            <div class="custom-input-file">
              <input type="file" id="archivoDoc" class="input-file" value="" name="archivo_doc" onchange="leeDocumento('archivoDoc')" accept=".doc,.docx">
              <h5 class="px-3 py-3">Arrastre hasta aquí su documento de Word o de clic para adjuntarlo</h5>
            </div>
            <div class="row">
              <div class="col-md-3 d-none">
                <div id="docSeleccionado" class="mg-t-40">
                </div>
              </div>
              <div class="col-12" id="vistaPreviaDocPDF">

              </div>
            </div>
          </div>
          <div class="d-none" id="porHTML">
            <div id="editor" style="text-align: -webkit-center;">
              <div id='edit' style="margin-top: 20px; width:100%;">
                <table>
                  <tbody>
                    <tr>
                      <td>
                        <img src="http://172.19.228.38:8083/images/logoTSJCDMX2.png" style="height: 100px;" id="logo_tsj">
                      </td>
                      <td>
                        <p>{{$leyenda}}</p>
                        <img src="http://172.19.228.38:8083/images/logoDEGJ.png" style="height: 100px;" id="logo_tsj">
                      </td>
                    </tr>
                  </tbody>
                </table>
                <br>
                <br>
                <p>
                  Prueba de firma electrónica {{date('Y-m-d H:i:s')}} por {{Session::get('usuario_nombre_completo')}}
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                </p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-12" style="">
          <br><br>
          <h6 class="slim-pagetitle" id="title_tareas">Firma</h6>
          <br>
          <div class="media-body table-responsive-xl" style="">
            <h5 class="card-profile-name">Selecciona el tipo de firma</h5>
              <p class="card-profile-position">
                <div class="row col-lg-12" id="">
                  {{-- @if (Session::get('id_tipo_usuario')==5 || Session::get('id_tipo_usuario')==2) --}}
                      
                    @if($request->entorno["variables_entorno"]["MIFIRMA_ACTIVO"]==0)
                        <div class="col-lg-6">
                            <label class="rdiobox">
                                <input name="tipo_firma_firel" type="radio" id="tipo_firma_firel1" value="firel" @if(Session::get('id_tipo_usuario')==5 || Session::get('id_tipo_usuario')==2) checked @endif onclick="seleccionarCredenciales('firel')">
                                <span>Firel</span>
                            </label>
                        </div><!-- col-3 -->
                        <div class="col-lg-6 mg-t-20 mg-lg-t-0">
                            <label class="rdiobox">
                                <input name="tipo_firma_firel" type="radio" id="tipo_firma_firel2" value="fiel" onclick="seleccionarCredenciales('fiel')">
                                <span>E.Firma</span>
                            </label>
                        </div><!-- col-3 -->
                    @else
                        <div class="col-lg-6">
                            <label class="rdiobox">
                                <input name="tipo_firma_firel" type="radio" id="tipo_firma_firel3" value="firel_tsj" checked onclick="seleccionarCredenciales('firel_tsj')">
                                <span> FIREL (PFX)</span>
                            </label>
                        </div><!-- col-3 -->
                        <div class="col-lg-6 mg-t-20 mg-lg-t-0">
                            <label class="rdiobox">
                                <input name="tipo_firma_firel" type="radio" id="tipo_firma_firel4" value="fiel_tsj" onclick="seleccionarCredenciales('fiel_tsj')">
                                <span>FIEL (SAT - Key y CER)</span>
                            </label>
                        </div><!-- col-3 -->
                    @endif
    
                    @if($request->entorno["variables_entorno"]["SELLO_SIGJ_ACTIVO"]==1)
                        <div class="col-lg-6 mg-t-20 mg-lg-t-0" id="sello_sigj_visible_1">
                            <label class="rdiobox">
                                <input name="tipo_firma_firel" type="radio" id="tipo_firma_firel" value="sello_sigj" onclick="seleccionarCredenciales('sello_sigj')">
                                <span>Sello SIGJ</span>
                            </label>
                        </div><!-- col-3 -->
                    @endif
                  
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
                <div class="mg-t-40 mg-b-40 col-lg-12" id="porDOC" style="display: none;">
                  <div class="form-group">
                    <label class="form-control-label">Tipo de Audiencia: <span class="tx-danger">*</span></label>
                    <select class="form-control select2-show-search valid" id="accionFirmaAutografa" name="tipo_audiencia" autocomplete="off" onchange="accionFirmaAut()">
                        <option selected value="cargar">CARGAR DOCUMENTO Y FIRMAR</option>
                        @if(Session::get('id_tipo_usuario')==5 || Session::get('id_tipo_usuario')==2)
                          <option value="delegar">AUTORIZAR Y DELEGAR</option>
                        @endif
                    </select>
                  </div>
                  <div id="divFirmaAutDoc">
                    <div class="custom-input-file">
                      <input type="file" id="archivoPDF_firma" class="input-file" value="" name="archivoPDF_firma">
                      <h5 class="px-3 py-3">Arrastre hasta aquí su documento pdf o de clic para adjuntarlo</h5>
                    </div>
    
                    <div id="divDocumento">
                      
                    </div>
                  </div>
                  <input type="hidden" id="bDoc" name="bDoc">
                </div>
                <div class="row">
                  <div class="col-lg-12" id="id_contrasenia">
                    <div class="form-group">
                        <label class="form-control-label">Contraseña: <span class="tx-danger">*</span></label>
                        <input class="form-control" type="password" name="password" id="password" value="" placeholder="" required>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12">
                    <div class="" style="left: 15px; display: inline-block;">
                      <div class="d-flex">
                        <button type="button" id="procesFirel" class="btn btn-primary" onclick="firmar();">Firmar</button>
                        <button type="button" id="enviar" class="btn btn-primary d-none" onclick="confirmarResolucionAcuerdo();">Aceptar</button>
                      </div>
                    </div>
                    <div class="card fracciones d-none" id="accordionFracciones">
                      <div class="card-header fracciones" role="tab" id="headingTwo">
                        <a class="collapsed tx-gray-800 transition fracciones" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" style="padding:10px; color:#000">
                          Medidas de protección <i class="fa fa-angle-down" aria-hidden="true"></i>
                        </a>
                      </div>
                      <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
                        <div class="card-body fracciones">
                          <div class="row">
                            <div class="col-md">
                              <div class="card">
                                <div class="card-header">
                                  <ul class="nav nav-tabs card-header-tabs" id="navItemsFracciones">
                                    
                                  </ul>
                                </div><!-- card-header -->
                                <div class="card-body">
                                  <div class="tab-content" id="tabPaneFracciones">
                                    
                                  </div><!-- tab-content -->
                                </div><!-- card-body -->
                              </div><!-- card -->
                            </div><!-- col -->
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <br>
          </div>
        </div>
      </div>
    </form>
  </div>
@endsection
@section('seccion-estilos')
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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
  <style>
    .custom-input-file {
      cursor: pointer;
      font-size: 1.3em;
      font-weight: bold;
      margin: 0 auto 0;
      max-width: 800px;
      min-height: 15px;
      overflow: hidden;
      position: relative;
      text-align: center;
      /* width: 500px; */
      color: #848F33;
      border: 2px solid #EEE;
      border-style: dotted;
      height: 80px;
      border-radius: 25px;
      width: 100%;
      background: #FFF;
    }

    .custom-input-file:hover{
      background: #848F33;
      color: #fff;
    }

    .custom-input-file .input-file{
      border: 10000px solid transparent;
      cursor: pointer;
      font-size: 10000px;
      margin: 0;
      opacity: 0;
      outline: 0 none;
      padding: 0 ;
      position: absolute;
      right: -1000px;
      top: -1000px;
    }

    .custom-input-file.rem_ejec {
      cursor: pointer;
      font-size: 1rem;
      font-weight: bold;
      margin: 0 auto 0;
      min-height: 15px;
      overflow: hidden;
      padding: 0.5em; 
      position: relative;
      text-align: center;
      width: 500px;
      color: #848F33;
      border: 2px solid #EEE;
      border-style: dotted;
      /* height: 80px; */
      border-radius: 25px;
      width: 100%;
    }

    .custom-input-file.rem_ejec:hover{
      color: rgb(191, 181, 181);
    }
    
    ::-webkit-scrollbar {
      height: 8px;  
      width: 8px;
    }
    ::-webkit-scrollbar-thumb {
      background: #D7DCE1; 
    }
    ::-webkit-scrollbar-thumb:hover {
      background: #a8acaf; 
    }
    ::-webkit-scrollbar-track {
      background: #fff 
    }
    #porHTML table:first-child td{
      border: none;
    }
  </style>
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
<script >
  $(document).ready( () => {
    setTimeout( () => {
      $('input[name="doc"][value="crear"]').click();
      $('#modal_loading').modal('hide');
    },600);
  });

  var tipo_global="firel_tsj";
  function seleccionarCredenciales(tipo){
    tipo_global=tipo;
    $('#procesFirel').removeClass('d-none');
    $('#enviar').addClass('d-none');
    if(tipo=="firel" || tipo=="firel_tsj"){
      // $('#porDOC').css("display", "none");
      $('#id_pfx').css("display", "block");
      $('#id_key').css("display", "none");
      $('#id_cert').css("display", "none");
      $('#id_contrasenia').css("display", "block");
    }
    else if(tipo=="fiel" || tipo=="fiel_tsj"){
      // $('#porDOC').css("display", "none");
      $('#id_pfx').css("display", "none");
      $('#id_key').css("display", "block");
      $('#id_cert').css("display", "block");
      $('#id_contrasenia').css("display", "block");
    }
  }

  editorHTML();
  setTimeout(function(){
    $( "#editor div:nth-child(1) div:nth-child(1)" ).addClass( "show-placeholder");
    $( "#editor td:nth-child(1)" ).css( {"width":"50%", "padding-top":"10px"} );
    $( "#editor img:nth-child(1)" ).css( {"height":"100px"} );
    $( "#editor td:nth-child(2)" ).css( {"text-align": "right", "width":"50%"} );
    $( "#editor img:nth-child(2)" ).css( {"height": "90px", "margin-left":"auto"} );
    $( "#editor td:nth-child(2) p" ).css( {"font-weigth":"bold", "font-style": "italic", "font-size": "18px", "margin-bottom": "0px"} );
  }, 500);

  function tipoDocumento(){

    if($('input:radio[name=doc]:checked').val()=='subir'){

      $('#porDOC').removeClass('d-none');
      $('#divTipoArchivo').removeClass('d-none');
      $('#divFirmante').removeClass('d-none');
      $('#divNombreHTML').addClass('d-none');
      $('#porHTML').addClass('d-none');
      $('#delegarTarea').addClass('d-none');
      $('#divAccion').removeClass('d-none');


    }else if($('input:radio[name=doc]:checked').val()=='crear'){

      $('#porDOC').addClass('d-none');
      $('#divTipoArchivo').removeClass('d-none');
      $('#divNombreHTML').removeClass('d-none');
      $('#divFirmante').removeClass('d-none');
      $('#porHTML').removeClass('d-none');
      $('#delegarTarea').addClass('d-none');
      $('#divAccion').removeClass('d-none');


    }else if($('input:radio[name=doc]:checked').val()=='delegar'){

      $('#porDOC').addClass('d-none');
      $('#divTipoArchivo').addClass('d-none');
      $('#divNombreHTML').addClass('d-none');
      $('#divFirmante').addClass('d-none');
      $('#porHTML').addClass('d-none');
      $('#delegarTarea').removeClass('d-none');
      $('#divAccion').addClass('d-none');
      $('#delegar').removeAttr('disabled');


    }
  }

  function editorHTML(){
    editor_html = new FroalaEditor("#edit", {
      height: 'calc(100vh - 100vh/2)',
      language: 'es',
      width: '800',
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
          'buttons': ['insertLink', 'insertImage', 'insertTable', 'fontAwesome', 'specialCharacters', 'embedly', 'insertFile', 'insertHR']
        },
        // 'moreMisc': {
        //   'buttons': ['undo', 'redo', 'fullscreen', 'print', 'getPDF', 'spellChecker', 'selectAll', 'html', 'help']
        // }
      },
      imageEditButtons: [['imageReplace', 'imageAlign', 'imageRemove', '|', 'imageLink', 'linkOpen', 'linkEdit', 'linkRemove', '-', 'imageDisplay', 'imageStyle', 'imageAlt', 'imageSize']],
      // toolbarButtonsXS: [['undo', 'redo'], ['bold', 'italic', 'underline']],
      events: {
        'image.beforeUpload': function (files) {
          const editor = this
          if (files.length) {
            var reader = new FileReader()
            reader.onload = function (e) {
              var result = e.target.result;
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
  }

  async function leeDocumento (input) {

    const file = $('#archivoDoc').val(),
          ext = file.substring(file.lastIndexOf("."));
          nombre=normalize((file.split('\\')[2]).split('.')[0]);
          $('#archivoDoc')[0].files[0].name="gocumento.docx";
          setTimeout(()=>{
          },500);
    if(ext!=''){
      if(ext != ".doc" && ext != ".docx"){
        alert('Solo puede adjutar archivos .doc o .docx');
        $('#archivoDoc').val('');
        $('#docSeleccionado').html('');
        $('#vistaPreviaDocPDF').html(``);
      }else{
        $('#docSeleccionado').html(`
        <div class="tx-center d-none">
          <a href="javascript:void(0)"  onclick="borraDoc()"><i class="fa fa-times" aria-hidden="true" style="margin-left: 140px; margin-bottom: 10px; color: red;"></i></a>
          <i class="fa fa-file-word-o d-block mg-b-10" aria-hidden="true" style="color:#848F33; font-size:70px"></i>
          <label ondblclick="cambiarNombre()" id="labelNombre" style="width: 100%; overflow-x: scroll;">${nombre}${ext}</label>
          <input type="hidden" value="${nombre}" id="nombreDoc" name="nombre_doc" onblur="guardaNombreDoc('${ext}')"  onkeypress="guardaNombreDoc('${ext}', event)" style="text-align: center; border:#868ba1"></div>
        `);
        const url_previa= await vistaPrevia();
        $('#vistaPreviaDocPDF').html(`<object data="${url_previa}" width="100%" height="350px" class="mg-t-25"></object>`)
      }
    }
  }

  let ruta_pdf = '';
  function vistaPrevia(){
    return new Promise(resolve => {
      abreModal('modal_loading');
      $('#modalDatosTarea').modal('hide');
      resolucion=new FormData($("#form_firma_firel")[0]);
      resolucion.append('nombre_doc',$('#labelNombre').text())
      $.ajax({
        method:'POST',
        url:'/public/vista_previa',
        data:resolucion,
        contentType: false,
        processData: false,
        cache: false,
        success:function(response){
          cierraLoading();
          ruta_pdf = response;
          
          resolve(response);
        }
      });
    });
  }

  function abreModal(modal, time=0){
    setTimeout(function(){
      $('#'+modal).modal('show');
    },time);
  }

  function cierraLoading(time, modal){
    setTimeout( () => {
      $('#modal_loading').modal('hide');
    },time);
    setTimeout( () => {
      $('#'+modal).modal('show');
    }, time + 400);
  }

  function firmar() {

    form = new FormData($("#form_firma_firel")[0]);

    if( $('input:radio[name=doc]:checked').val() == 'subir' ) {
      console.log($('#archivoDoc').val());
      if( $('#archivoDoc').val() == '' || ruta_pdf == '' ) {
        $('#messageError').html( 'Falta adjuntar el documento a firmar' );
        $('#modalError').modal('show');
        return false;
      }

      const file = $('#archivoDoc').val();
        extension = file.substring(file.lastIndexOf("."));
        form.append('ruta_pdf', ruta_pdf);

    }else if( $('input:radio[name=doc]:checked').val() == 'crear' ){

      const extension='html',
        archivo = editor_html.html.get();
        nombre_archivo=$('#nombreHTML').val();
        form.append('archivo_html',archivo);
        form.append('extension',extension);
        form.append('nombre_archivo',nombre_archivo);

    }

    $('#modal_firel').modal('hide');
    $('#modal_loading').modal('show');

    jQuery.ajax({
        type: 'POST',
        url:"/public/prueba_firma",
        data: form,
        processData: false,
        contentType: false,
        async: true,
        success: function( data ) {
          
          if( data.status == 100 ) {
            setTimeout( () => {
              $('#divPDF').html(`<object data="${data.response}" type="application/pdf" style="width: 100%; height: 85vh;"></object>`);
              $('#modalpdf').modal('show');
            }, 900);
          }else {
            $('#messageError').html( data.message );
            $('#modalError').modal('show');
          }

          setTimeout( () => {
              $('#modal_loading').modal('hide');
          }, 500);
        }
    });

  }


</script>
@endsection
@section('seccion-modales')
  <div id="modalError" class="modal fade">
    <div class="modal-dialog" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-body tx-center pd-y-20 pd-x-20">
          <i class="icon icon ion-ios-close-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
          <h4 class="tx-danger mg-b-20" id="titleError"></h4>
          <p class="mg-b-20 mg-x-20" id="messageError"></p>
          <button type="button" class="btn btn-danger pd-x-25" data-dismiss="modal" aria-label="Close"   id="acepError">Aceptar</button>
        </div><!-- modal-body -->
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
  </div><!-- modal -->

  <div id="modalpdf" class="modal fade">
    <div class="modal-dialog modal-lg" role="document" style="width:-webkit-fill-available">
      <div class="modal-content tx-size-sm">
        <div class="modal-header pd-x-20">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pd-20" id="divPDF">
          
        </div><!-- modal-body -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->
@endsection
