<div class="row" style="padding: 0 2%;">
  <div class="col-lg-12" style="border:2px solid #848F33; padding:10px 5px; text-align:center; font-weight: bold; font-size: 1.2em;">
    Datos de Audiencia
  </div>
</div>

<div class="row mg-t-20" style="padding: 0 2%;">
  <div class="col-sm-12 col-md-4 col-lg-3">
    <div class="infor">
      <div class="infor_brand">
        Fecha de la Audiencia:
      </div>
      <div class="infor_body">
        <i class="far fa-calendar-alt"></i>
        <div>
          ${a.fecha_audiencia}
        </div>
        <div class="fecha_hora_info">
          De las ${a.hora_inicio_audiencia != null ?  a.hora_inicio_audiencia.substring(0,5) : ''} hrs. a las ${a.hora_fin_audiencia != null ? a.hora_fin_audiencia.substring(0,5) : ''} hrs.
        </div>
      </div> 
    </div>
  </div>

  <div class="col-sm-12 col-md-4 col-lg-3">
    <div class="infor">
      <div class="infor_brand">
        Tipo de Audiencia:
      </div>
      <div class="infor_body">
        <i class="fas fa-landmark" style="margin: 4.5% 0 !important;"></i>
        <div>
          ${a.nombre_sala}
        </div>
        <div class="fecha_hora_info">
          ${a.tipo_audiencia}
        </div>
      </div> 
    </div>
  </div>

  <div class="col-sm-12 col-md-4 col-lg-3">
    <div class="infor">
      <div class="infor_brand">
        Centro de gestion:
      </div>
      <div class="infor_body">
        <i class="far fa-building"></i>
        <div class="nombre_inmueble">
          ${a.nombre_inmueble}
        </div>
        <div class="fecha_hora_info">
          ${a.nombre_unidad}
        </div>
      </div> 
    </div>
  </div>

  <div class="col-sm-12 col-md-4 col-lg-3">
    <div class="infor">
      <div class="infor_brand">
        Juez Asignado:
      </div>
      <div class="infor_body">
        <i class="fas fa-user" style="margin: 4.5% 0 !important;"></i>
        <div>
          Juez
        </div>
        <div class="fecha_hora_info">
          ${a.juez.nombre_usuario}
        </div>
      </div> 
    </div>
  </div>

</div>

<di class="row mg-t-20">
  <div class="col-md-4">
    <div class="www">
      <div class="www_title">
        Situación
      </div>
      ${ strEstatusA }
      
      <div style="font-weight: bold;">${ a.estatus_audiencia }</div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="www">
      <div class="www_title">
        Duracion estimada
      </div>
      <i class="fas fa-hourglass-half" style="color: #848f33;font-size: 3.2em;background: #fff;"></i>
      <div style="font-weight: bold;">${a.duracion_estimada?a.duracion_estimada:'Sin registro'}</div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="www">
      <div class="www_title">
        Horario de desarollo real
      </div>
      <i class="far fa-clock" style="color: #848f33;font-size: 3.2em;background: #fff;"></i>
      <div style="font-weight: bold;">${horario_real}</div>
    </div>
  </div>

  <div class="col-lg-12 mg-t-10 d-none" id="comentsCancelado">
    <div style="background: #fff;padding: 4px;border-radius: 11px;border: 1px solid #848f3340;">
        <div style="font-size: 0.98em;padding: 6px;font-weight: bold;/* border: 1px solid #848f33; */width: 200px;margin: 1% auto;">Comentarios de Cancelacion</div>
        <div style="background: #f7f4f4;border-radius: 9px;height: 56px;width: 91%;margin: 0 auto 2% auto;padding: 4px;">
          ${a.comentarios_cancelacion ? a.comentarios_cancelacion : 'Sin comentarios'} &nbsp;&nbsp; 
          <a href="#" style="font-size: 0.9em;padding: 6px; width: 200px;margin: 1% auto;" class="${a.nombre_archivo_cancelacion ? '' : 'd-none'}" onclick="ver_documento_cancelacion_audiencia('${a.id_audiencia}')">${a.nombre_archivo_cancelacion ? 'Ver documento: '+a.nombre_archivo_cancelacion : 'Sin documento de cancelacion'}</a>
        </div>
    </div>
  </div>

  <div class="col-lg-12 mg-t-10">
    <table class="datatable tableDatosSujeto mt-4" style="overflow-x: none; display: table; text-align: left;">
      <thead>
        <tr>
          <th class="tx-center" style="background:#f8f9fa" colspan="5" class="tx-center tx-bold">Recursos Adicionales de la Audiencia:</th>
        </tr>
        <tr>
          <th class="tx-center" style="background:#f8f9fa" >#</th>
          <th class="tx-center" style="background:#f8f9fa" >Recurso</th>
          <th class="tx-center" style="background:#f8f9fa" >Horario de uso</th>
          <th class="tx-center" style="background:#f8f9fa" >Descripción</th>
          <th class="tx-center" style="background:#f8f9fa" >Comentarios</th>
        </tr>
      </thead>
      <tbody style="font-weight: lighter;">
        ${tr_recursos}
      </tbody>
    </table>
  </div>
</di>

