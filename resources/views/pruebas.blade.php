<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>title</title>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.css">

  </head>
  <body>
    <div id="editor">
      <div id='edit' style="margin-top: 30px;">
        
       

      </div>
    </div>
  </body>

  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/froala_editor.min.js"></script>
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
    (function() {
      FroalaEditor.DefineIcon('alert', {NAME: 'info', SVG_KEY: 'help'});
      FroalaEditor.RegisterCommand('alert', {
        title: 'Hello',
        focus: false,
        undo: false,
        refreshAfterCallback: false,
        callback: function () {
          alert('Hello!');
        }
      });

      

        new FroalaEditor("#edit", {
            language: 'es',
            key: '0BA3jA11A8B5A3E4D4aIVLEABVAYFKc2Cb1MYGH1g1NYVMiG5G4E3C3A1C8C6D4A3F4==',
            // Set custom buttons with separator between them.
            toolbarButtons: {
              'moreText': {
                'buttons': ['alert', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'fontFamily', 'fontSize', 'textColor', 'backgroundColor', 'inlineClass', 'inlineStyle', 'clearFormatting']
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
            toolbarButtonsXS: [['undo', 'redo'], ['bold', 'italic', 'underline']],
            events: {
            'image.beforeUpload': function (files) {
              const editor = this
              if (files.length) {
                var reader = new FileReader()
                reader.onload = function (e) {
                  var result = e.target.result
                  editor.image.insert(result, null, null, editor.image.get())
                }
                reader.readAsDataURL(files[0])
              }
              return false
            }
          }
        })
    })()
    </script>
</html>