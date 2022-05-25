
<?php
    $ruta_base="/var/www/html/front_penal_desarrollo";
    // se limpian las carptes cada 5 minutos
    array_map('unlink', glob($ruta_base."/storage/pdf_solicitudes/*".date('H', strtotime(date('Y-m-d H:m:s'))-7200).".*"));
    array_map('unlink', glob($ruta_base."/storage/app/porfirmar/*".date('H', strtotime(date('Y-m-d H:m:s'))-7200).".*"));
    array_map('unlink', glob($ruta_base."/storage/acuerdos/*".date('H', strtotime(date('Y-m-d H:m:s'))-7200).".*"));
    array_map('unlink', glob($ruta_base."/storage/acuerdos/*"));
    // array_map('unlink', glob($ruta_base."/storage/app/porfirmar/*.doc"));
    // array_map('unlink', glob($ruta_base."/storage/app/porfirmar/*.docx"));
    // array_map('unlink', glob($ruta_base."/storage/app/porfirmar/*.html"));
    // array_map('unlink', glob($ruta_base."/storage/app/porfirmar/*".date('H', strtotime(date('Y-m-d H:m:s'))-7200).".*"));
    array_map('unlink', glob($ruta_base."/storage/app/docs_penal/*.docx"));
    array_map('unlink', glob($ruta_base."/storage/app/docs_penal/*.doc"));
    array_map('unlink', glob($ruta_base."/public/temporales/*".date('H', strtotime(date('Y-m-d H:m:s'))-7200).".*"));
    array_map('unlink', glob($ruta_base."/storage/app/temporales/*".date('H', strtotime(date('Y-m-d H:m:s'))-7200).".*"));
    array_map('unlink', glob($ruta_base."/storage/temporales/*".date('H', strtotime(date('Y-m-d H:m:s'))-7200).".*"));
    array_map('unlink', glob($ruta_base."/storage/app/formato_devolucion/*".date('H', strtotime(date('Y-m-d H:m:s'))-7200).".*"));
    // array_map('unlink', glob($ruta_base."/public/temporales/*.pdf"));
    // array_map('unlink', glob($ruta_base."/public/temporales/rpt*"));
    // array_map('unlink', glob($ruta_base."/storage/app/temporales/*.pdf"));
?>
