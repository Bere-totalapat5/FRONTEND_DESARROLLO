<?php

    class CorreoDiario{

        private static $html;
        private static $text;

        public function __construct(){
            CorreoDiario::$html = <<<EOT
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
      <title>Actualizaci&oacute;n diaria</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style type="text/css">
    <!--
    #saludo p{
        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 12px;
    }
    #expedientes div.expediente{
        margin-top: 20px;
        margin-left: 20px;
    }
    #expedientes div.acuerdo{
        margin-left: 40px;
    }
    -->
    </style>
  </head>
  <body>
    <div id="saludo">
        <p>Buenos d&iacute;as #nombre# #usuario#</p>
        <p>Estas son las resoluciones publicadas en el Bolet&iacute;n Judicial del d&iacute;a #fecha# relacionadas con tus asuntos registrados:
    </div>
    <div id="expedientes">
      #expedientes#
    </div>
    <p>No responda este correo, para dudas y aclaraciones escriba a <a href="mailto:admin.sicor@tsjdf.gob.mx">admin.sicor@tsjdf.gob.mx</a>
  </body>
</html>
EOT;

            CorreoDiario::$text = <<<EOT
Buenos d&iacute;as #nombre# (#usuario#)

Estas son las resoluciones publicadas en el Bolet&iacute;n Judicial
del d&iacute;a #fecha# relacionadas con tus asuntos registrados
#expedientes#

No responda este correo, para dudas y aclaraciones escriba a admin.sicor@tsjdf.gob.mx
EOT;

        }

        public function getHTML($usuario, $nombre, $fecha, $expedientes){
            $_res = str_replace('#usuario#', $usuario, CorreoDiario::$html);
            $_res = str_replace('#nombre#', $nombre, $_res);
            $_res = str_replace('#fecha#', $fecha, $_res);
            $_res = str_replace('#expedientes#', $expedientes, $_res);
            return utf8_encode($_res);
        }

        public function  getTEXT($usuario,$nombre, $fecha,$expedientes){
            $_res = str_replace('#usuario#', $usuario, CorreoDiario::$text);
            $_res = str_replace('#nombre#', $nombre, $_res);
            $_res = str_replace('#fecha#', $fecha, $_res);
            $_res = str_replace('#expedientes#', $expedientes, $_res);
            return utf8_encode($_res);
        }

        public function getAsunto(){
            return "Actualizaciones de acuerdos";
        }

    }

?>