<div class="col-md-12">
  <div class="form-layout">

    {{-- Titulo de la seccion y botones de accion  --}}
    <div class="row justify-content-between mt-2">
      <div class="title-pane" style=" width:100%; border-bottom:2px solid #848F33; text-align:left; font-size:1.4em; display: flex;flex-wrap: wrap;">
        <div class="col-md-12" style="padding: 4px 0 6px 2px;">Medidas de proteccion</div>
      </div>
    </div>

    <div class="row" id="menu_adicional_cnnpp">
      <div class="title-pane" style=" width:100%; border-bottom:2px solid #848F33; text-align:left; font-size: 0.9em; padding:10px; display: flex;flex-wrap: wrap;">
        <input type="hidden" id="cmp_medidaP_id_acuerdo">

        <div class="col-md-2">
          <div class="form-group text-left">
            <label class="form-control-label">Tipo de resolución:</label> 
            <select class="form-control select2" id="tipo_resolucion_s">

            </select>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group text-left">
            <label class="form-control-label">Fecha incio:</label>
            <input type="text" id="cmp_medidaP_fecha_inicio_acuerdo" name="cmp_medidaP_fecha_inicio_acuerdo" class="form-control cal">
          </div>
        </div>

        <div class="col">
          <div class="form-group text-left">
            <label class="form-control-label">Dias:</label>
            <div style="display: flex;">
              <input type="text" id="cmp_medidaP_cantidad_dias" name="cmp_medidaP_cantidad_dias" class="form-control">
            </div>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group text-left">
            <label class="form-control-label">Fecha fin:</label>
            <input type="text" id="cmp_medidaP_fecha_fin_acuerdo" name="cmp_medidaP_fecha_fin_acuerdo" class="form-control" readonly>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group text-left">
            <label class="form-control-label">Resolución a la solicitud:</label>
            <select class="form-control select2" id="resolucion_solicitud_medidad">
            </select>
          </div>
        </div>

        <div class="col-md-2" style="display: flex; justify-content: center; align-items: center;">
          <div class="form-group text-left" style="margin-bottom: 0;">
            <button class="btn btn-primary" id="saveFechas"><i class="fas fa-save"></i></button>
          </div>
        </div>

        <div class="alert alert-warning alert-dismissible fade show" role="alert" style=" width: 60%; padding: 4px; margin: 0;">
          <strong>Aviso!</strong> Para llenar estos campos en necesario que el acuerdo haya sido firmado<button type="button" class="close" data-dismiss="alert" aria-label="Close" style="padding: 6px;">
            <span aria-hidden="true">×</span>
          </button>
        </div>

      </div>
    </div>

    <div id="medias_proteccion_menu_penal">

      <div class="row justify-content-between mt-3">
          <div class="col-sm-4 col-md-3 col-lg-2 pd-t-10" align="left">
              <a href="javascript:void(0);" onclick="agregarMedidaP('${a.folio_carpeta}', ${a.id_audiencia})" class="btn btn-success btn-sm btn-block " style="background: #848F33;"><i class="fa fa-pdf mg-r-5"></i>Nueva  Medida</a>
          </div>
      </div>

    
      <div class="row mt-4">
        <div class="col-md-12">
          <div  class="mg-b-20 table-responsive" style="height: 500px; overflow-x:auto;">
            <table id="medidasPTable" class="table table-hover dataTable dtr-inline collapsed pd-y-0" style="width: 100% !important;"  role="grid" aria-describedby="example_info">
              <thead class="thead">
                  <tr>
                      <th class="acciones1">Acciones</th>
                      <th style="min-width: 100px;">Imputado</th>
                      <th style="min-width: 400px;">Medida de proteccion</th>
                      <th style="min-width: 100px;">Comentarios Adicionales </th>
                      <th style="min-width: 130px;">Fecha Inicio </th>
                      <th style="min-width: 130px;">Fecha Fin </th>
                      <th style="min-width: 80px;">Estatus</th></th>
                  </tr>
              </thead>
              <tbody id="body-table5"  style="width: 100%; text-align: center;">
                <tr>
                  <td colspan="5">Sin datos Relacionados</td>
                </tr>
              </tbody>
            </table>
          </div>


          {{-- Paginacion --}}

          <div class="pagination-wrapper justify-content-between">
            <ul class="pagination mg-b-0">
              <li class="page-item">
                <a class="page-link primera-DG" href="javascript:void(0)" aria-label="Last" onclick="obtener_MedidaP('${a.folio_carpeta}','primera')">
                  <i class="fa fa-angle-double-left"></i>
                </a>
              </li>
              <li class="page-item">
                <a class="page-link anterior-DG" href="javascript:void(0)" aria-label="Next" onclick="obtener_MedidaP('${a.folio_carpeta}','atras')">
                  <i class="fa fa-angle-left"></i>
                </a>
              </li>
            </ul>
          
            <ul class="pagination mg-b-0">
              <li id="texto_paginator_medidap" class="page-item">Página <span class="pagina-DG pagina_actual_texto_medidap">1</span> de <span class="total-paginas-DG pagina_total_texto_medidap">1</span></li>
            </ul>
          
            <ul class="pagination mg-b-0">
              <li class="page-item">
                <a class="page-link siguiente-DG" href="javascript:void(0)" aria-label="Next" onclick="obtener_MedidaP('${a.folio_carpeta}','avanzar')">
                  <i class="fa fa-angle-right"></i>
                </a>
              </li>
              <li class="page-item">
                <a class="page-link ultima-DG" href="javascript:void(0)" aria-label="Last" onclick="obtener_MedidaP('${a.folio_carpeta}','ultima')">
                  <i class="fa fa-angle-double-right"></i>
                </a>
              </li>
            </ul>
          </div>

          {{-- pagination params --}}
          <input type="hidden" id="pagina_actual_medidap" name="pagina_actual_medidap" value="1">
          <input type="hidden" id="paginas_totales_medidap" name="paginas_totales_medidap" value="1">
          <input type="hidden" id="numeropagina_medidap">

        </div>
      </div>

    </div>

    <div id="medias_proteccion_menu_promujer_rat" style="display: none;">
      <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-" role="tabpanel" aria-labelledby="nav-home-tab">
          <div class="col-lg-12">
            <div style="display: flex; flex-wrap:wrap; justify-content: space-between;">
              <div class="col-sm-12 col-md-6 col-lg-4 mg-b-2">
                <select class="form-control" ids_victimas="" id="lista_victimas" style="border: none; border-bottom: 1px solid #848F33; border-left: 1px solid #848F33; border-right: 1px solid #848F33;" onchange="listaFracciones(${a.id_audiencia});">

                </select>
              </div>
              <div class="col-sm-12 col-md-4 col-lg-2 mg-b-2">
                <button type="button" class="btn btn-success" id="checkados_fracc" style="background:#848F33 !important; border:none; cursor:pointer;" tipo="" onclick="checkados_fracc(${a.id_audiencia})">Guardar Seleccion</button>
              </div>
            </div>
            <div class="responsive-table mg-t-35" style="padding: 0 2%;">
              <table id="tablaFracciones_e">
                <thead>
                  <tr>
                    <th style="font-size: 1.3em; font-weight: bold;"></th>
                    <th style="font-size: 1.3em; font-weight: bold;">Fraccion</th>
                    <th style="font-size: 1.1em; font-weight: bold; text-align:center;">Solicitadas</th>
                    <th style="font-size: 1.1em; font-weight: bold; text-align:center;">Audiencia</th>
                  </tr>
                </thead>
                <tbody id="table_fracciones_e">
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
