<div class="col-md-12">
  <div class="form-layout">

    {{-- Titulo de la seccion y botones de accion  --}}
    <div class="row justify-content-between mt-2">
      <div class="title-pane p-2" style=" width:100%; border-bottom:2px solid #848F33; text-align:left; font-size:1.4em;">
        Mandamientos judiciales
      </div>
    </div>
    <div class="row justify-content-between mt-3">
        <div class="col-sm-4 col-md-4 col-lg-2 pd-t-10" align="left">
            <a href="javascript:void(0);" onclick="modalNuevoMandamiento('${a.folio_carpeta}',${a.id_audiencia} )" class="btn btn-success btn-sm btn-block " style="background: #848F33; border:none;"><i class="fa fa-pdf mg-r-5"></i>Nuevo Mandamiento</a>
        </div>
    </div>

    {{-- Campos --}}
    <div class="row mt-4">
      <div class="col-md-12">
        <div  class="mg-b-20 table-responsive" style="height: 500px; overflow-x:auto;">
          <table id="mandamientosTable" class="table table-hover dataTable dtr-inline collapsed pd-y-0" style="width: 100%;"  role="grid" aria-describedby="example_info">
            <thead class="thead">
                <tr>
                    <th class="acciones1">Acciones</th>
                    <th class="acciones1">N° Carpeta</th>
                    <th class="acciones1">N° Oficio</th>
                    <th >Orden</th>
                    <th style="min-width: 300px;">Descripcion de la orden</th>
                    <th style="min-width: 140px;">Unidad de gestion</th>
                    <th style="min-width: 80px;"class="acciones1">Estatus</th>
                </tr>
            </thead>
            <tbody id="body-table2"  style="width: 100%; text-align: center;">
            </tbody>
          </table>
        </div>

        <div class="pagination-wrapper justify-content-between">
          <ul class="pagination mg-b-0">
            <li class="page-item">
              <a class="page-link primera-DG" href="javascript:void(0)" aria-label="Last" onclick="obtener_mandamientos('${a.folio_carpeta}','primera')">
                <i class="fa fa-angle-double-left"></i>
              </a>
            </li>
            <li class="page-item">
              <a class="page-link anterior-DG" href="javascript:void(0)" aria-label="Next" onclick="obtener_mandamientos('${a.folio_carpeta}','atras')">
                <i class="fa fa-angle-left"></i>
              </a>
            </li>
          </ul>

          <ul class="pagination mg-b-0">
          <li id="texto_paginator_mandamientos" class="page-item">Página <span class="pagina-DG pagina_actual_texto_mandamientos">1</span> de <span class="total-paginas-DG pagina_total_texto_mandamientos">1</span></li>
          </ul>

          <ul class="pagination mg-b-0">
            <li class="page-item">
              <a class="page-link siguiente-DG" href="javascript:void(0)" aria-label="Next" onclick="obtener_mandamientos('${a.folio_carpeta}','avanzar')">
                <i class="fa fa-angle-right"></i>
              </a>
            </li>
            <li class="page-item">
              <a class="page-link ultima-DG" href="javascript:void(0)" aria-label="Last" onclick="obtener_mandamientos('${a.folio_carpeta}','ultima')">
                <i class="fa fa-angle-double-right"></i>
              </a>
            </li>
          </ul>
        </div>

        {{-- pagination params --}}
        <input type="hidden" id="pagina_actual_mandamientos" name="pagina_actual_mandamientos" value="1">
        <input type="hidden" id="paginas_totales_mandamientos" name="paginas_totales_mandamientos" value="1">
        <input type="hidden" id="numeropagina_mandamientos">

      </div>
    </div>


  </div>
</div>
