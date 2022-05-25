<?php
  if(!isset($_GET['pdf'])){
    header('location: /');
  }
  $url=$_GET['pdf'];
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Poder Judicial de la Ciudad de México</title>
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <link href="pflip/css/pdfflip.css" rel="stylesheet" type="text/css">

</head>
<body>

 

<div class="PDFFlip" id="PDFF" source="<?php echo $url ?>"></div>

<script src="pflip/js/libs/jquery.min.js" type="text/javascript"></script>
<script src="pflip/js/pdfflip.js" type="text/javascript"></script>
<script src="settings.js?id=2" type="text/javascript"></script>
<script src="toc.js" type="text/javascript"></script>

</body>
</html>