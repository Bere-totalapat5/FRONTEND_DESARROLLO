<?php

$tipo=$input['tipo'];
$id_acuerdo=$input['id_acuerdo'];
$ponencia=$input['ponencia'];
$id_documento=$input['id_documento'];
$tipo_documento=$input['tipo_documento'];
$flujo_id=$input['flujo_id'];
$flujo_id=$input['flujo_id'];
$bandera_firmante=$input['bandera_firmante'];

$plantilla_archivo_header = <<<EOF

    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Actualización del documento</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
EOF;

$plantilla_archivo_body = <<<EOF
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
    <div id="editor" style="">
    <center>
      <div id='edit' style="margin-top: 20px; width:95%;">
        
      $contenido

      </div>
      </center>
    </div>


  <style>
    .fr-box {
        display: flex;
        height: 100%;
        flex-direction: column;

        .fr-wrapper {
           flex: 1;

           .fr-element {
               min-height: 100%; 
            }
        }
    }
  </style>
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

  <script>

  var editor_html="";
  function guardar_editor_HTML(){
    $('#modaldemo_editar_html').css('z-index', '1040');
    $('#modal_loading').modal({backdrop: 'static', keyboard: false});

      texto=editor_html.html.get();
    $.ajax({
        type:'POST',
        url:'/bandejas/guardarEditorHTML',
        data:{ tipo:'$tipo', id_acuerdo:'$id_acuerdo', ponencia:'$ponencia', id_documento:'$id_documento', tipo_documento:'$tipo_documento', flujo_id:'$flujo_id', documento_html:texto },
        success:function(data){
            alert('Se guardó exitosamente');
            

            $('#modal_loading').modal('hide');

            $('#modaldemo_editar_html').css('z-index', '1050');
            console.log(data);
            //location.reload();
        }
    });
  }

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

    </script>
EOF;

?>