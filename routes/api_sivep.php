<?php
  // PARA SIVEP NO MOVER ESTA RUTA
  Route::post("ver_ugas_sivep/{materia?}", "sivep_sigj\control_sivep@ver_ugas_sivep");
  Route::post('sivep_obtener_jueces_unidad/{id_unidad?}', 'sivep_sigj\control_sivep@obtener_jueces_unidad')->name('sivep_obtener_jueces_unidad');