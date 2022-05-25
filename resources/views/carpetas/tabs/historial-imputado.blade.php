{{-- estatus imputado--}}

<div class="form-layout"><br>
  <div class="row mg-b-25">
    <div class="col-lg-12">
      @if( isset($permisos[88]) and $permisos[88] == 1 )
        <div id="accordionHisgtorialImputado" class="accordion-one mg-b-10" role="tablist" aria-multiselectable="true" width="100%">
          <div class="card">
            <div class="card-header" role="tab" id="headingOne">
              <a id="titleAccordionHisgtorialImputado" onclick = "catalogo_estatus();ver_imputados()" data-toggle="collapse" data-parent="#accordionHisgtorialImputado" href="#collapseHisgtorialImputado" aria-expanded="true" aria-controls="collapseHisgtorialImputado" class="bkg-collapsed-btn tx-gray-800 transition collapsed tx-white">
                Registrar cambio de estatus de imputado
              </a>
            </div><!-- card-header -->
            <div id="collapseHisgtorialImputado" class="collapse" role="tabpanel" aria-labelledby="headingOneNotificaionAlerta">
              <div class="card-body">
                <div class="mg-t-15">
                  <div class="row">
                    <div class="col-lg-5">
                      <div class="form-group">
                        <label class="form-control-label">Cambiar estatus a:&nbsp;<span class="tx-danger">*</span></label>
                        <select class="form-control select2" id="catalogo_estatus" autocomplete="off">
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-7">
                      <div class="form-group">
                        <label class="form-control-label">Imputados a modificar:&nbsp;<span class="tx-danger">*</span></label>
                        <select class="form-control select2" id="imputados_select" autocomplete="off">
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-5">
                      <div class="form-group">
                        <label class="form-control-label">Comentarios adicionales:</label>
                        <textarea class="form-control" id="comentarios_adicionales" ></textarea>
                      </div>
                    </div>
                    <div class="col-lg-2">
                    <div class="form-group">
                      <br>
                      <button class="btn btn-primary"  type="button" onclick="guardar_cambio_estatus()">Guardar</button>
                    </div>
                    </div>
                  </div>
                </div>
              </div> <!-- CARD BODY -->
            </div> <!-- BODY COLLAPSE -->
          </div> <!-- CARD -->
        </div>
      @endif

      <table id="tableHisgtorialImputado" class="display dataTable dtr-inline collapsed">
        <thead style="background-color: #EBEEF1; color: #000;">
          <tr>
            <th>#</th>
            <th>Fecha de cambio</th>
            <th>Nombre del imputado</th>
            <th>Situación anterior</th>
            <th>Situación actual</th>
            <th>Responsable cambio</th>
            <th>Comentarios adicionales</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>

      <div class="pagination-wrapper justify-content-between">
        <ul class="pagination mg-b-0">
          <li class="page-item">
            <a class="page-link primera-DG" href="javascript:void(0)" aria-label="Last" onclick="pintarDocumentosGenerados(1)">
              <i class="fa fa-angle-double-left"></i>
            </a>
          </li>
          <li class="page-item">
            <a class="page-link anterior-DG" href="javascript:void(0)" aria-label="Next" onclick="pintarDocumentosGenerados(1)">
              <i class="fa fa-angle-left"></i>
            </a>
          </li>
        </ul>

        <ul class="pagination mg-b-0">
          <li class="page-item">Página <span class="pagina-DG">1</span> de <span class="total-paginas-DG">1</span></li>
        </ul>

        <ul class="pagination mg-b-0">
          <li class="page-item">
            <a class="page-link siguiente-DG" href="javascript:void(0)" aria-label="Next" onclick="pintarDocumentosGenerados(1)">
              <i class="fa fa-angle-right"></i>
            </a>
          </li>
          <li class="page-item">
            <a class="page-link ultima-DG" href="javascript:void(0)" aria-label="Last" onclick="pintarDocumentosGenerados(1)">
              <i class="fa fa-angle-double-right"></i>
            </a>
          </li>
        </ul>
      </div>

    </div><!-- col-lg-12-->

    <hr/>

  </div><!-- row -->

  {{-- BOTONES--}}
  <div class="form-layout-footer d-flex">
  </div><!-- form-layout-footer -->
</div>

<style>
  table.table-wizard{
    display: flex;
  }
  .wizard{
    /* border: 1px solid #000; */
    border-radius: 25px;
    background: #EEEEEE;
    display: flex;
  }
  .wizard .num-wizard{
    display: inline-block;
    background: #FFF;
    margin: 4px;
    border-radius: 50%;
    padding: 3px 8px 3px 8px;
    width: 25px;
    height: 25px;
  }
  .wizard .text-wizard{
    display: inline-block;
    margin-left: auto;
    margin-right: auto;
    padding: 6px 8px 6px 4px;
  }
  .wizard.resuelto{
    /* background: #848F33 ; */
    background: #848f3387 ;
  }
  .wizard.resuelto .text-wizard{
    color: #FFF;
  }
  .wizard.activo{
    background: #848F33 ;
  }
  .wizard.activo .text-wizard{
    color: #FFF;
    text-decoration: underline;
  }
  td.td-wizard{
    padding-left: 20px;
  }
  td.td-wizard:first-child{
    padding-left: 0;
  }

</style>

{{-- JS --}}

<script>

  var arrHI=[];
  var tr = "";
  var count = 0;

  function pintarHistorialImputados(pagina=1){
    $("#tableHisgtorialImputado tbody tr").remove();
    $("#tableHisgtorialImputado tbody").html("");

    $.ajax({
      method:'POST',
      url:'/public/historial_estatus_imputado',
      data:{
        id_carpeta_judicial : $("#id_carpeta_judicial").val(),
        pagina,
      },
      success:function(response){
        if( response.status == 100){

          arrHI = response.response;

          var count = 0;

          if(arrHI.length > 0){
            $(arrHI).each(function(index_doc, doc){
              if(doc.comentarios){
                comentarios_adicionales = doc.comentarios;
              }
              else{
                comentarios_adicionales = "";
              }

              count ++;
               tr += "<tr>"+
                     "<th>" + count + "</th>" +
                     "<td>" + doc.fecha_cambio + "</td>" +
                     "<td>" + doc.nombre_imputado + "</td>" +
                     "<td>" + doc.situacion_imputado_anterior + "</td>" +
                     "<td>" + doc.situacion_imputado + "</td>" +
                     "<td>" + doc.usuario_responsable + "</td>" +
                     "<td>" + comentarios_adicionales + "</td>" +
                     "</tr>";
                  });
            }
             else{
                   tr = "<tr><td colspan='7'><center><span class='tx-italic'>No hay registros en el historial del imputado</span></center></td></tr>";
                 }
        $("#tableHisgtorialImputado tbody").html("");
        $("#tableHisgtorialImputado tbody").html(tr);
        tr = "";

          if(typeof(response.response_pag)!='undefined'){

              let anterior=pagina==1?1:pagina-1;
              let totalPaginas=response.response_pag.paginas_totales;
              let siguiente=pagina+1>=totalPaginas?totalPaginas:pagina+1;

              $('.anterior-DG').attr('onclick',`pintarHistorialImputados(${anterior})`);
              $('.pagina-DG').html(pagina);
              $('.total-paginas-DG').html(totalPaginas);
              $('.siguiente-DG').attr('onclick',`pintarHistorialImputados(${siguiente})`);
              $('.ultima-DG').attr('onclick',`pintarHistorialImputados(${totalPaginas})`);
            }
        }
        else{

               tr = "<tr><td colspan='5'><center><span class='tx-italic'>No hay registros en el historial del imputado</span></center></td></tr>";
               $("#tableHisgtorialImputado tbody").append(tr);

               $('.anterior-DG').attr('onclick',`pintarHistorialImputados(1)`);
               $('.pagina-DG').html('1');
               $('.total-paginas-DG').html('1');
               $('.siguiente-DG').attr('onclick',`pintarHistorialImputados(1)`);
               $('.ultima-DG').attr('onclick',`pintarHistorialImputados(1)`);
               if( response.message!="Error - sin referencia a datos") modal_error('Historial Imputado dice:<br>'+response.message,'modalAdministracion');
        }
      } // success
    }); // ajax
  }

  function catalogo_estatus(){
      $.ajax({
        method:'POST',
        url:'/public/ver_catalogo_situacion_imputado',
        data:{
          catalogo : 1
        },
        success:function(response){
          if( response.status == 100){
            arrHI  = response.response;
            option = "<option disabled selected>Seleccione...</option>";
            $(arrHI).each(function(index_doc, doc){
              option += "<option value = " + doc.idRegistro + ">" + doc.situacion + "</option>";
            });
            $("#catalogo_estatus").html(option)
          }
        }
      });
  }
  function ver_imputados(){
    $.ajax({
      method:'POST',
      url:'/public/ver_imputados',
      data:{
        id_carpeta_judicial : $("#id_carpeta_judicial").val(),
        id_calidad_juridica : 46
      },
      success:function(response){
        if( response.status == 100){
          arrHI  = response.response.personas;
          option = "<option disabled selected>Seleccione...</option>";

          $(arrHI).each(function(index_doc, doc){
            option += "<option value = " + doc.id_persona + ">" + doc.nombre_completo + "</option>";
          });

          $("#imputados_select").html(option)
        }
      }
    });
  }

  function guardar_cambio_estatus(){
    $('#modalAdministracion').modal('hide');
    var idRegistro = $("#catalogo_estatus").val();
    var id_persona = $("#imputados_select").val();
    var comentarios_adicionales = $("#comentarios_adicionales").val();

    if((idRegistro)&&(id_persona)){
      $.ajax({
        method:'POST',
        url:'/public/guardar_cambio_estatus',
        data:{
          idRegistro : idRegistro,
          id_persona : id_persona,
          comentarios_adicionales : comentarios_adicionales
        },
        success:function(response){
          if( response.status == 100){
            modal_success('Estatus actualizado');
            pintarHistorialImputados();
            ver_imputados();
            catalogo_estatus();
            $("#comentarios_adicionales").val("");
            setTimeout(() => {
              abrirModalAdministracion(carpetaActiva.id_carpeta_judicial);  
              buscar($('#pagina_buscar').val());
              $('#modalSuccess').modal('hide');
            }, 500);
          }
          else{
            modal_error(response.message,'modalAdministracion')

          }
        }
      });
    }
    else{
      modal_error('Llene los campos obligatorios','modalAdministracion')
    }
  }

</script>
