<div class="col-md-12">
  <div class="form-layout">

    {{-- Titulo de la seccion y botones de accion  --}}
    <div class="row justify-content-between mt-2">
      <div class="title-pane p-2" style=" width:100%; border-bottom:2px solid #848F33; text-align:left; font-size:1.4em;">
        Medidas cautelares
      </div>
    </div>
    <div class="row justify-content-between mt-3">
        <div class="col-sm-4 col-md-3 col-lg-2 pd-t-10" align="left">
            <a href="javascript:void(0);" onclick="agregarMedidaC('${a.folio_carpeta}', ${a.id_audiencia})" class="btn btn-success btn-sm btn-block " style="background: #848F33;"><i class="fa fa-pdf mg-r-5"></i>Nueva  Medida</a>
        </div>
    </div>

    
    <div class="row mt-4">
      <div class="col-md-12">
        <div  class="mg-b-20 table-responsive" style="height: 500px; overflow-x: auto;">
          <table id="medidasCTable" class="table table-hover dataTable dtr-inline collapsed pd-y-0" style="width: 100% !important;" role="grid" aria-describedby="example_info">
            <thead class="thead">
                <tr>
                    <th class="acciones1">Acciones</th>
                    <th style="min-width: 100px;">Imputado</th>
                    <th style="min-width: 400px;">Medida Cautelar</th>
                    <th style="min-width: 100px;">Especificaciones </th>
                    <th style="min-width: 130px;">Fecha Inicio </th>
                    <th style="min-width: 130px;">Fecha Fin </th>
                    <th style="min-width: 80px;" >Estatus</th>
                </tr>
            </thead>
            <tbody id="body-table4"  style="width: 100%; text-align: center;">
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
              <a class="page-link primera-DG" href="javascript:void(0)" aria-label="Last" onclick="obtener_MedidaC('${a.folio_carpeta}','primera')">
                <i class="fa fa-angle-double-left"></i>
              </a>
            </li>
            <li class="page-item">
              <a class="page-link anterior-DG" href="javascript:void(0)" aria-label="Next" onclick="obtener_MedidaC('${a.folio_carpeta}','atras')">
                <i class="fa fa-angle-left"></i>
              </a>
            </li>
          </ul>
      
          <ul class="pagination mg-b-0">
            <li id="texto_paginator_medidac" class="page-item">P??gina <span class="pagina-DG pagina_actual_texto_medidac">1</span> de <span class="total-paginas-DG pagina_total_texto_medidac">1</span></li>
          </ul>
      
          <ul class="pagination mg-b-0">
            <li class="page-item">
              <a class="page-link siguiente-DG" href="javascript:void(0)" aria-label="Next" onclick="obtener_MedidaC('${a.folio_carpeta}','avanzar')">
                <i class="fa fa-angle-right"></i>
              </a>
            </li>
            <li class="page-item">
              <a class="page-link ultima-DG" href="javascript:void(0)" aria-label="Last" onclick="obtener_MedidaC('${a.folio_carpeta}','ultima')">
                <i class="fa fa-angle-double-right"></i>
              </a>
            </li>
          </ul>
        </div>

        {{-- pagination params --}}
        <input type="hidden" id="pagina_actual_medidac" name="pagina_actual_medidac" value="1">
        <input type="hidden" id="paginas_totales_medidac" name="paginas_totales_medidac" value="1">
        <input type="hidden" id="numeropagina_medidac">

      </div>
    </div> 

  </div>
</div>
