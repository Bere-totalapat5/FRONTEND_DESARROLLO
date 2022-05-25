{{-- DOCUMENTOS ASOCIADOS--}}

<div class="form-layout"><br>
  <div class="row mg-b-25">
    {{-- SECCION   DELITOS SIN RELACIONAR --}}
    <div class="col-lg-12">
      <div id="accordionDocumentosGenerados" class="accordion-one mg-b-10" role="tablist" aria-multiselectable="true" width="100%">
        <div class="card">
          <div class="card-header" role="tab" id="headingOne">
            <a id="titleAccordionDocumentosGenerados" data-toggle="collapse" data-parent="#accordionDocumentosGenerados" href="#collapseOneDocumentosGenerados" aria-expanded="true" aria-controls="collapseOneDocumentosGenerados" class="bkg-collapsed-btn tx-gray-800 transition collapsed tx-white">
              Generar Documento
            </a>
          </div><!-- card-header -->
          <div id="collapseOneDocumentosGenerados" class="collapse" role="tabpanel" aria-labelledby="headingOneDocumentosGenerados">
            {{-- <form id="form_generar_documento" enctype="multipart/form-data" method="post"> --}}
            <div class="card-body">
              <div class="mg-t-15">

                <input type="hidden" name="request_usmeca" id="request_usmeca">
                <input type="hidden" name="consumir_ws_usmeca" id="consumir_ws_usmeca">

                <div class="row" id="divTipoPlantilla">
                  <div class="col-lg-12">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">Oficios:</label>
                      <select class="form-control select2" id="tipoPlantilla" name ="tipoPlantilla">
                        <option value="-">Seleccione una plantilla</option>
                        {{-- @foreach( $tipos_documentos_generados as $tipo_documento )
                          <option value="{{$tipo_documento['codigo']}}">{{$tipo_documento['nombre_formato']}}</option>
                        @endforeach --}}
                        <option value="41">[USMC] Formato para  informar suspensión condicional del proceso</option>
                        <option value="532">[USMC] Medida Cautelar dentro del plazo constitucional</option>
                        <option value="503">[USMC] Se informa imposicion de medida cautelar</option>
                        <option value="533">[USMC] Formato para  informar suspensión condicional del proceso e imposicion de medida cautelar</option>
                        <!-- <option value="513">[USMC] Se informa sobreseimiento </option>
                        <option value="504">[USMC] Se informa audiencia y se solicita informe de solución alterna</option> -->
                        <option value="501">[Otros]  Plantilla General</option>
                      </select>
                    </div>
                  </div>
                </div>

                <div id="divFormularioDG">
                </div>

                <div class="row d-none" id="divActualizarDG" align="right">
                  <div class="col-lg-12" align="right">
                    <input type="hidden" name="id_documento_dg_editar" id="id_documento_dg_editar">
                    <!-- <button type="button" class="btn btn-primary bd-0 ml-10" id="btnAcutalizarDocumento" onclick="actualizarDocumentoGenerado()">Guardar Cambios</button> -->
                  </div>
                </div>

              </div>
            </div> <!-- CARD BODY -->
            {{-- </form> --}}
          </div> <!-- BODY COLLAPSE -->
        </div> <!-- CARD -->
      </div> <!-- ACCORDEON DOCUMENTOS GENERADOS -->
      <br>

      <div class="row">
        <div class="col-lg-3">
          <h5 class="form-control-label">Documentos Generados </h5>
        </div>
        <div class="col-lg-9">
          <div class="form-group">

            <label class="form-control-label mg-r-10">Seleccione vista:</label>

            <label class="rdiobox d-inline-block" onclick="showHide('#divDocumentosGenerados', '#divOficiosEnviadosUSMC')">
              <input name="vista-DG" type="radio" checked value="tabla">
              <span>Documentos en proceso</span>
            </label>

            <label class="rdiobox d-inline-block mg-xs-l-20" onclick="showHide('#divOficiosEnviadosUSMC', '#divDocumentosGenerados')">
              <input name="vista-DG" type="radio" value="preview">
              <span>Oficios enviados a USMC</span>
            </label>

          </div>
        </div>
        <hr/>
      </div>



      <div class="row" id="divDocumentosGenerados">

        <div class="col-lg-4 mb-3">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">Tipo Documento:</span>
            </div>
            <div class="col pl-0 pr-0">
              <select class="form-control select2" id="tipo_documento_dg_buscar" name="tipo_documento_dg_buscar" autocomplete="off">
                <option selected value="-">Todos</option>
                @foreach( $tipos_documento_carpeta as $tipo_documento )
                  <option value="{{$tipo_documento['id_documento']}}">{{$tipo_documento['nombre']}}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>

        <div class="col-lg-4 mb-3">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">Nombre:</span>
            </div>
            <input class="form-control" type="text" id="nombre_documento_dg_buscar" name="nombre_documento_dg_buscar" autocomplete="off">
          </div>
        </div>

        <div class="col-lg-4 mb-3">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">Estatus:</span>
            </div>
            <div class="col pl-0 pr-0">
              <select class="form-control select2" id="estatus_documento_dg_buscar" name="estatus_documento_dg_buscar" autocomplete="off">
                <option selected value="">Todas</option>
                <option value="firmado">Pendiente de firma</option>
                <option value="delegado">Delegado</option>
                <option value="correccion">En Correcion</option>
              </select>
            </div>
            <div class="col-md-3 pr-0">
              <button class="btn btn-primary w-100" id="filtrarDocumentosAsociados" onclick="pintarDocumentosGenerados(1)">Filtrar</button>
            </div>
          </div>
        </div>

        <div class="col-lg-12">

          <table id="tableDocumentosGenerados" class="display dataTable dtr-inline collapsed">
            <thead style="background-color: #EBEEF1; color: #000;">
              <tr>
                <th>#</th>
                <th>Acciones</th>
                <th>Fecha de creacion</th>
                <th>Tipo de documento</th>
                <th>Titulo del documento</th>
                <!-- <th>Tamaño</th> -->
                <th>Registrado por</th>
                <th>Situación actual</th>
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
        </div>
      </div>

      <div class="row" id="divOficiosEnviadosUSMC" style="display:none;">
        <div class="col-lg-12">

          <table id="tableOficiosEnviadosUSMC" class="table" width="100%" style="display:table;">
            <thead>
              <tr>
                <th>#</th>
                <th>Accion</th>
                <th>Fecha Firmado</th>
                <th>Tipo Oficio</th>
                <th>Nombre Oficio</th>
                <!-- <th>Tamaño</th> -->
                <th>Folio USMC</th>
                <th>Mensaje Error</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>

          <div class="pagination-wrapper justify-content-between">
            <ul class="pagination mg-b-0">
              <li class="page-item">
                <a class="page-link primera-DG-USMC" href="javascript:void(0)" aria-label="Last" onclick="pintarOficiosEnviadosUSMC(1)">
                  <i class="fa fa-angle-double-left"></i>
                </a>
              </li>
              <li class="page-item">
                <a class="page-link anterior-DG-USMC" href="javascript:void(0)" aria-label="Next" onclick="pintarOficiosEnviadosUSMC(1)">
                  <i class="fa fa-angle-left"></i>
                </a>
              </li>
            </ul>

            <ul class="pagination mg-b-0">
              <li class="page-item">Página <span class="pagina-DG-USMC">1</span> de <span class="total-paginas-DG-USMC">1</span></li>
            </ul>

            <ul class="pagination mg-b-0">
              <li class="page-item">
                <a class="page-link siguiente-DG-USMC" href="javascript:void(0)" aria-label="Next" onclick="pintarOficiosEnviadosUSMC(1)">
                  <i class="fa fa-angle-right"></i>
                </a>
              </li>
              <li class="page-item">
                <a class="page-link ultima-DG-USMC" href="javascript:void(0)" aria-label="Last" onclick="pintarOficiosEnviadosUSMC(1)">
                  <i class="fa fa-angle-double-right"></i>
                </a>
              </li>
            </ul>
          </div>

        </div>
      </div>

      <br><br>
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

  .notfocus{
    opacity: 0.4 !important;
  }

</style>

{{-- JS --}}
<script>
  var editor_html=null;

  var tipo_firma=null;
  var b64_doc_firmado=null;

  // Collecciones para documentos generados
  var arrItems=[];
  var arrUsuarios=[];
  var arrFirmantes=[];
  var arrImputadosSeleccionados=[];
  //var suspension_condicional = @php echo json_encode($suspension_condicional);@endphp;

  var arrDG=[];
  var arrOfDG=[];
  var arrAnexosDG = [];
  var arrAuDG = [];

  const oficiosUSMC_WS=['504','513','503','532','41'];
  // const tipos_documento_carpeta= @php echo json_encode($tipos_documento_carpeta);@endphp;


  /************************
  *
  * MUESTRA TODOS LOS DOCUMENTOS ASOCIADOS
  *
  *************************/

  function pintarDocumentosGenerados(pagina=1){
    //return true;
    $("#tableDocumentosGenerados tbody tr").remove();
    $.ajax({
      method:'POST',
      url:'/public/obtener_documentos_generados',
      data:{
        carpeta : $("#id_carpeta_judicial").val(),
        id_solicitud : $("#id_solicitud").val(),
        tipo_solicitud : $("#tipo_solicitud").val(),
        estatus_proceso : 'no_firmado',
        //id_documento : 'todas',
        tipo_documento : $("#tipo_documento_dg_buscar").val(),
        nombre_archivo : $("#nombre_documento_dg_buscar").val(),
        estatus : $("#estatus_documento_dg_buscar").val(),
        pagina,
      },
      success:function(response){
        console.log(response);
        arrDG=[];
        if( response.status == 100){
          arrDG = response.response;

          $(arrDG).each(function(index_doc, doc){
            let { id_documento,id_tipo_documento, nombre_formato,nombre_archivo,extension_archivo,tamanio_archivo,id_ultima_version,motivos,creacion,flujo_estatus,id_usuario,nombres_creador,apellido_paterno_creador,apellido_materno_creador, }=doc;

            let strVerDoc = `<i class="fas fa-file-pdf" data-toggle="tooltip-primary" data-placement="top" title="Ver documento" onclick="verDocumentoGenerado(${doc.id_documento})"></i>`;
            let strEditDoc = ``;
            let strBorrarDoc = ``;
            let strHistorialDoc = ``;
            let strFlujo = ``;

            if( !bandera_solo_consulta ){ // aquí te controla el permiso de edicion
              let title = `Remover el Documento ${nombre_archivo} de Carpeta Judicial`;
              let body = `borrar_documento`;

              if( true ){ // aquí va permiso de capretas judiciales
                strEditDoc = `<i class="fas fa-edit " data-toggle="tooltip-primary" data-placement="top" title="Editar documento" onclick="editarDocumentoGenerado(${doc.id_documento})"></i>`;

                if( flujo_estatus != 'firmado' ){
                  strBorrarDoc = `<i class="fas fa-trash-alt " data-toggle="tooltip-primary" data-placement="top" title="Borrar documento" onclick="borrarDocumentoGenerado(${doc.id_documento})"></i>`;
                }
                
                @if( isset($permisos[87]) and $permisos[87] == 1 )
                  strBorrarDoc = `<i class="fas fa-trash-alt " data-toggle="tooltip-primary" data-placement="top" title="Borrar documento" onclick="borrarDocumentoGenerado(${doc.id_documento})"></i>`;
                @endif
                //  strHistorialDoc = `<i class="fas fa-history " data-toggle="tooltip-primary" data-placement="top" title="Ver historial documento" onclick="mostrarHistorialDocumentoGenerado(${index_doc})"></i>`;
              }
            }

            $("#tableDocumentosGenerados tbody").append(`
              <tr>
                <td>${index_doc + 1}</td>
                <td>${strBorrarDoc} ${strEditDoc} ${strFlujo} ${strHistorialDoc} ${strVerDoc}</td>
                <td>${creacion}</td>
                <td> <a href="#" onclick="verDocumentoGenerado(${doc.id_documento});" > ${nombre_formato} </a> </td>
                <td> <a href="#" onclick="verDocumentoGenerado(${doc.id_documento});" > ${nombre_archivo} </a> </td>
                <!-- <td>${ Number.parseFloat( tamanio_archivo/1048576 ).toFixed(2)} MB</td> -->
                <td>${nombres_creador??''} ${apellido_paterno_creador??''} ${apellido_materno_creador??''}</td>
                <td>${flujo_estatus=='firmado'?'Pendiente de Firma' : flujo_estatus}</td>
              </tr>
            `);
          });
          if(!arrDG.length){
            $('#tableDocumentosGenerados tbody').append(`
            <tr>
              <td colspan="5">
                <span class="tx-italic">No hay documentos generados</span>
              </td>
            </tr>
          `);
          }
          if(typeof(response.response_paginacion)!='undefined'){
              let anterior=pagina==1?1:pagina-1;
              let totalPaginas=response.response_paginacion.paginas_totales;
              let siguiente=pagina+1>=totalPaginas?totalPaginas:pagina+1;

              $('.anterior-DG').attr('onclick',`pintarDocumentosGenerados(${anterior})`);
              $('.pagina-DG').html(pagina);
              $('.total-paginas-DG').html(totalPaginas);
              $('.siguiente-DG').attr('onclick',`pintarDocumentosGenerados(${siguiente})`);
              $('.ultima-DG').attr('onclick',`pintarDocumentosGenerados(${totalPaginas})`);
            }
        }else{
          $('#tableDocumentosGenerados tbody').append(`
            <tr>
                <td colspan="5">
                  <span class="tx-italic">No hay documentos generados</span>
                </td>
            </tr>
          `);

          $('.anterior-DG').attr('onclick',`pintarDocumentosGenerados(1)`);
          $('.pagina-DG').html('1');
          $('.total-paginas-DG').html('1');
          $('.siguiente-DG').attr('onclick',`pintarDocumentosGenerados(1)`);
          $('.ultima-DG').attr('onclick',`pintarDocumentosGenerados(1)`);
          if( response.message!="Error - sin referencia a datos" && response.message!="ERROR - sin referencia a datos") modal_error('Documentos Generados dice: <br>'+response.message,'modalAdministracion');
        }
      } // success
    }); // ajax
  }

  function pintarOficiosEnviadosUSMC(pagina=1){
    $("#tableOficiosEnviadosUSMC tbody tr").remove();
    $.ajax({
      method:'POST',
      url:'/public/obtener_documentos_generados',
      data:{
        carpeta : $("#id_carpeta_judicial").val(),
        id_solicitud : $("#id_solicitud").val(),
        tipo_solicitud : $("#tipo_solicitud").val(),
        bandera_ws_usmeca : 1,
        estatus_proceso : 'firmado',
        // tipo_documento : $("#tipo_documento_dg_buscar").val(),
        // nombre_archivo : $("#nombre_documento_dg_buscar").val(),
        // estatus : $("#estatus_documento_dg_buscar").val(),
        pagina,
      },
      success:function(response){
        console.log(response);
        arrOfDG = [];
        if( response.status == 100){
          arrOfDG = response.response;
          $(response.response).each(function(index_doc, doc){
            let d=doc;
            
            let strVerDoc = '';
            let strReenviarDoc = '';

            if( !bandera_solo_consulta ){
              let strVerDoc = `<i class="fas fa-file-pdf" data-toggle="tooltip-primary" data-placement="top" title="Ver documento" onclick="verDocumentoGenerado(${doc.id_documento},'enviados_usmc')"></i>`;
              let strReenviarDoc = `<i class="fas fa-share-square" data-toggle="tooltip-primary" data-placement="top" title="Reenviar Oficio a USMC" onclick="reenviarSolicitudUSMC(${doc.id_documento})"></i>`;
            }

            if(doc.sincronizacion_ws_usmeca=='SUCCESS') strReenviarDoc = ``;

            $("#tableOficiosEnviadosUSMC tbody").append(`
              <tr>
                <td>${index_doc + 1}</td>
                <td>${strVerDoc} ${strReenviarDoc}</td>
                <td>${d.fecha_firmado != null ? d.fecha_firmado : ''}</td>
                <td> <a href="#" onclick="verDocumentoGenerado(${doc.id_documento},'enviados_usmc');" > ${d.nombre_formato} </a> </td>
                <td> <a href="#" onclick="verDocumentoGenerado(${doc.id_documento},'enviados_usmc');" > ${d.nombre_archivo} </a> </td>
                <!-- <td>${ Number.parseFloat( d.tamanio_archivo/1048576 ).toFixed(2)} MB</td> -->
                <td>${ d.folio_ws_usmeca==null ? d.folio_ws_usmeca : d.folio_ws_usmeca }</td>
                <td>${ d.mensaje_ws_usmeca==null ? '' : d.mensaje_ws_usmeca }</td>
              </tr>
            `);
          });
          if(!arrDG.length){
            $('#tableOficiosEnviadosUSMC tbody').append(`
            <tr>
              <td colspan="8">
                <span class="tx-italic">No hay oficios enviados a USMC</span>
              </td>
            </tr>
          `);
          }
          if(typeof(response.response_paginacion)!='undefined'){
              let anterior=pagina==1?1:pagina-1;
              let totalPaginas=response.response_paginacion.paginas_totales;
              let siguiente=pagina+1>=totalPaginas?totalPaginas:pagina+1;

              $('.anterior-DG-USMC').attr('onclick',`pintarOficiosEnviadosUSMC(${anterior})`);
              $('.pagina-DG-USMC').html(pagina);
              $('.total-paginas-DG-USMC').html(totalPaginas);
              $('.siguiente-DG-USMC').attr('onclick',`pintarOficiosEnviadosUSMC(${siguiente})`);
              $('.ultima-DG-USMC').attr('onclick',`pintarOficiosEnviadosUSMC(${totalPaginas})`);
            }
        }else{
          $('#tableOficiosEnviadosUSMC tbody').append(`
            <tr>
                <td colspan="5">
                  <span class="tx-italic">No hay documentos generados</span>
                </td>
            </tr>
          `);

          $('.anterior-DG-USMC').attr('onclick',`pintarOficiosEnviadosUSMC(1)`);
          $('.pagina-DG-USMC').html('1');
          $('.total-paginas-DG-USMC').html('1');
          $('.siguiente-DG-USMC').attr('onclick',`pintarOficiosEnviadosUSMC(1)`);
          $('.ultima-DG-USMC').attr('onclick',`pintarOficiosEnviadosUSMC(1)`);
          if( response.message!="Error - sin referencia a datos") modal_error("Documentos Generados dice:<br>"+response.message,'modalAdministracion');
        }
      } // success
    }); // ajax
  }

  /************************
  *
  * GUARDAR UN NUEVO DOCUMENNTO ASOCIADO
  *
  *************************/

  function avanzarDocumento(id_documento=null,avance='firma'){
    let id_usuario_destino=null;
    tipo_firma = $('input:radio[name=tipo_firma]:checked').val();
    let archivo_pfx=null;
    let archivo_key=null;
    let archivo_cer=null;
    let archivo_firmado=null;
    let password=null;
    arrAnexosDG=[];

    let origen_contenido_oficio = $('input:radio[name=origenContenidoOficio-DG]:checked').val();
    let contenido_documento = null;
    let tipo_archivo = $("#tipoPlantilla").val() == '501' ? 3 : 52 ;

    let enviar_oficio = $("input:radio[name=enviarOficio-DG]:checked").val();
    let persona_a_enviar = $("#personaEnviar option:selected").text();
    let nombre_documento = $("#tipoPlantilla").find('option:selected').text();

    if( $("#wizard-pasoAcuerdo-DG").hasClass("activo") ){

      origen_contenido_oficio = 'archivo';

      if( !$("#acuerdoWord-DG").val() ){
        modal_error('Debe Adjuntar un Archivo de WORD','modalAdministracion');
        return false;
      }else{
        contenido_documento = $("#acuerdoWord-DG")[0].files[0];
      }

      if($("#personaEnviarAcuerdo").val()=='-'){
        modal_error('Para enviar el documento a otra persona, es necesario seleccionar un destinatario','modalAdministracion');
        return false;
      } else id_usuario_destino = $("#personaEnviarAcuerdo").val();

      nombre_documento = $("#acuerdoWord-DG")[0].files[0].name;
      nombre_documento = nombre_documento.substr( 0 , nombre_documento.lastIndexOf(".") );   
      persona_a_enviar = $("#personaEnviarAcuerdo option:selected").text();
      enviar_oficio = "enviar";
      tipo_archivo = 2;
      
    }else{

      if( origen_contenido_oficio == 'editor' ) contenido_documento= editor_html.html.get();
      else if( origen_contenido_oficio == 'archivo' ){
        if( !$("#oficioWord-DG").val() ){
          modal_error('Debe Adjuntar un Archivo de WORD','modalAdministracion');
          return false;
        }
  
        contenido_documento = $("#oficioWord-DG")[0].files[0];
      }
  
  
      if(enviar_oficio=='enviar'){
        if($("#personaEnviar").val()=='-'){
          modal_error('Para enviar el documento a otra persona, es necesario seleccionar un destinatario','modalAdministracion');
          return false;
        } else id_usuario_destino = $("#personaEnviar").val();
  
        @if( $request->session()->get('id_tipo_usuario') == 3 )
          $(".anexos-adjuntados-DG").each(function( index ){
            arrAnexosDG.push({
              'b64' : $(this).attr('data').split('base64,')[1],
              'nombre_archivo' : 'Anexo ('+$(this).attr('data-nombre')+')',
              //'nombre_archivo' : 'Anexo_'+(parseInt( index ) + 1) + ($("#numOficio-DG").val() ? '_Oficio_Num_'+$("#numOficio-DG").val() : '') +'('+$(this).attr('data-nombre')+')',
              'tamanio_archivo': $(this).attr('data-tamanio'),
              'extension_archivo' : $(this).attr('data-extension'),
            });
          });
        @endif
  
      }else if(enviar_oficio=='firmar'){
        //  id_usuario_destino= "1610132330907";
        id_usuario_destino= "{{$request->session()->get('usuario-id')}}";
        if(tipo_firma=='firel_tsj' || tipo_firma=='firel_csj') archivo_pfx = $("#archivo_pfx")[0].files[0];
        else if(tipo_firma=='fiel_tsj') {
          archivo_key = $("#archivo_key")[0].files[0];
          archivo_cer = $("#archivo_cer")[0].files[0];
        }else if(tipo_firma=='firma_Autografa'){
          archivo_firmado = $("#archivo_firmado")[0].files[0];
        }
        password = $("#password").val();
  
        if( $("#tipoPlantilla").val() != 501 ){
  
          if( ($(".anexos-adjuntados-DG")).length == 0 ){
            modal_error('Debes adjuntar al menos un anexo','modalAdministracion');
            return false;
          }
  
          $(".anexos-adjuntados-DG").each(function(){
            arrAnexosDG.push({
              'b64' : $(this).attr('data').split('base64,')[1],
              'nombre_archivo' : $(this).attr('data-nombre'),
              'tamanio_archivo': $(this).attr('data-tamanio'),
              'extension_archivo' : $(this).attr('data-extension'),
            });
          });
  
        }
  
      }

    }


    afectarEspacio('documento-enviado');

    var form = new FormData();
    form.append('carpeta', $("#id_carpeta_judicial").val());
    form.append('id_unidad', carpetaActiva.id_unidad);
    //form.append('id_tipo_archivo',52 );
    form.append('id_tipo_archivo', tipo_archivo );
    form.append('id_tipo_plantilla',$("#tipoPlantilla").val() );
    form.append('nombre_documento', nombre_documento );
    form.append('contenido_documento',contenido_documento);
    form.append('avance',enviar_oficio );
    form.append('id_usuario_destino',id_usuario_destino );
    form.append('tipo_firma',tipo_firma );
    form.append('archivo_pfx',archivo_pfx );
    form.append('archivo_key',archivo_key );
    form.append('archivo_cer',archivo_cer );
    form.append('password',password );
    form.append('request_usmeca',$("#request_usmeca").val() );
    form.append('consumir_ws_usmeca',$("#consumir_ws_usmeca").val() );
    form.append('arrAnexosDG',JSON.stringify(arrAnexosDG) );
    form.append('b64_doc_firmado',b64_doc_firmado );
    form.append('origen_contenido_oficio',origen_contenido_oficio );
    $('#modalAdministracion').modal('hide');

    console.log( ' USEMCA ENVIAR-FIRMAR : '+ (new Date()).getDate() +'-'+ (new Date()).getMonth() +'-'+ (new Date()).getFullYear() +'  '+ (new Date()).getHours() +':'+ (new Date()).getMinutes() +':'+ (new Date()).getSeconds() );

    loading(true);
    $.ajax({
      method:'POST',
      url:'/public/avanzar_documento_generado_carpeta',
      data:form,
      dataType: 'json',
      processData: false,
      contentType: false,
      success:function(response){
        console.log( ' LLEGA RESPONSE : '+ (new Date()).getDate() +'-'+ (new Date()).getMonth() +'-'+ (new Date()).getFullYear() +'  '+ (new Date()).getHours() +':'+ (new Date()).getMinutes() +':'+ (new Date()).getSeconds() );
        loading(false);
        console.log(response);
        if(response.status==100){
          let message = '';
          if( oficiosUSMC_WS.includes( $("#tipoPlantilla").val())  && enviar_oficio=='firmar' ){
            res_usmc = response.response.response_ws_usmc;
            message = 'Oficio firmado exitosamente <br>'+ (res_usmc.status == 100 ? 'Enviado exitosamente a USMC  <br> Folio: '+res_usmc.response.folio : 'Error USMC respondió: '+res_usmc.response.mensaje);
          }else{
            message = enviar_oficio=='firmar' ? 'Oficio firmado exitosamente' : 'Oficio enviado exitosamente a '+ persona_a_enviar ;
          }
          modal_success(message,'modalAdministracion');
          $('#tipoPlantilla').val('-').trigger('change');
          $("#divFormularioDG").empty();
          arrAnexosDG=[];
          pintarDocumentosGenerados(1);
          pintarOficiosEnviadosUSMC(1);
          pintarDocumentosAsociados(1);
        }else{
          message= response.message!=undefined?response.message:response.mensaje;
          $(".avanzar-documento").attr("disabled",false);
          modal_error(message,'modalAdministracion');
        }
      },
      error:function(request, error){
        console.log( ' LLEGA ERROR : '+ (new Date()).getDate() +'-'+ (new Date()).getMonth() +'-'+ (new Date()).getFullYear() +'  '+ (new Date()).getHours() +':'+ (new Date()).getMinutes() +':'+ (new Date()).getSeconds() );
        loading(false);
        modal_error('Ocurrio un error, por favor intente nuevamente','modalAdministracion');
      }
    });
    //$(".avanzar-documento").attr("disabled",false);
  }

  /************************
  *
  * CARGA EL DOCUMENTO A EDITAR
  *
  *************************/

  function editarDocumentoGenerado( id_documento){
    $("#divFormularioDG").empty();
    doc = arrDG.filter( x=>x.id_documento==id_documento );
    $.ajax({
      method:'POST',
      url:'/public/obtener_ultima_version_documento_generado',
      data:{
        carpeta : $("#id_carpeta_judicial").val(),
        id_documento,
        modo : 'html',
      },
      success:function(response){
        //$("#modalAdministracion").modal('show');
        console.log('RESPUESTA OBTENER HTML :',response);
        if( response.status == 100){
          if( response.extension == 'doc' || response.extension == 'docx'){
            window.open(response.response, '_blank');

            $("#divTipoPlantilla").css('display','none');
            $("#divFormularioDG").append(`
              <div class="row">

                <input type="hidden" name="origen_contenido_oficio-DG" id="origen_contenido_oficio-DG" value="archivo">

                <div class="col-lg-12" id="divOficioWordDocumentoGenerado">
                  <div class="form-group">
                    <label class="form-control-label"><span class="tx-danger">*</span> Oficio actualizado:</label>
                    <div id="div_upload" class="field">
                      <input class="btn btn-oblong btn-outline-primary" type="file" name="oficioWord-DG" id="oficioWord-DG" accept=".doc, .docx" style="width: 100%;">
                    </div>
                  </div>
                </div>

                <div class="col-lg-6" align="left">
                  <br>
                  <button type="button" class="btn btn-oblong btn-secondary" onclick="cancelarEdicionDG()" style="width: 100px;"> Cancelar </button>
                </div>

                <div class="col-lg-6" align="right">
                  <br>
                  <button type="button" class="btn btn-oblong btn-primary" onclick="actualizarDocumentoGenerado( ${id_documento} )" style="width: 100px;"> Actualizar </button>
                </div>

              </div>
            `);

            $("#collapseOneDocumentosGenerados").collapse('show');

            $("#id_documento_dg_editar").val(id_documento);
            $("#request_usmeca").val( JSON.stringify( response.request_usmeca ) );
            $("#titleAccordionDocumentosGenerados").text(`Editando oficio : ${doc[0].nombre_archivo}`);

          } else{
            $("#divTipoPlantilla").css('display','none');
            $("#divFormularioDG").append(`
              <div class="row">

                <input type="hidden" name="origen_contenido_oficio-DG" id="origen_contenido_oficio-DG" value="editor">

                <div class="col-lg-12" id="divEditorDocumentoGenerado" >
                  <div id='editor' style="margin-top: 20px; text-align: -webkit-center;">

                  </div>
                </div>

                <div class="col-lg-6" align="left">
                  <br>
                  <button type="button" class="btn btn-oblong btn-secondary" onclick="cancelarEdicionDG()" style="width: 100px;"> Cancelar </button>
                </div>

                <div class="col-lg-6" align="right">
                  <br>
                  <button type="button" class="btn btn-oblong btn-primary" onclick="actualizarDocumentoGenerado( ${id_documento} )" style="width: 100px;"> Actualizar </button>
                </div>

              </div>
            `);
            cargarHTMLEditor(response.response);

            $("#collapseOneDocumentosGenerados").collapse('show');

            $("#id_documento_dg_editar").val(id_documento);
            $("#request_usmeca").val( JSON.stringify( response.request_usmeca ) );
            $("#titleAccordionDocumentosGenerados").text(`Editando oficio : ${doc[0].nombre_archivo}`);
          }

        }else{
          modal_error(response.message,'modalAdministracion');
        }
      } // success
    }); // ajax
  }


  /************************
  *
  * ACTUALIZA DOCUMENTO EDITADO
  *
  *************************/

  function actualizarDocumentoGenerado( id_documento ){
    doc = arrDG.filter( x=>x.id_documento==id_documento );
    $("#modalAdministracion").modal('hide');

    let origen_contenido_oficio = $("#origen_contenido_oficio-DG").val();
    let contenido_documento = null;
    if( origen_contenido_oficio == 'editor' ) contenido_documento= editor_html.html.get();
    else if( origen_contenido_oficio == 'archivo' ){
      if( !$("#oficioWord-DG").val() ){
        modal_error('Debe Adjuntar un Archivo de WORD','modalAdministracion');
        return false;
      }

      contenido_documento = $("#oficioWord-DG")[0].files[0];
    }

    var form = new FormData();
    form.append('carpeta', $("#id_carpeta_judicial").val());
    form.append('id_documento', id_documento);
    form.append('origen_contenido_oficio',origen_contenido_oficio );
    form.append('contenido_documento',contenido_documento);
    form.append('nombre_documento',doc[0].nombre_archivo );
    form.append('request_a_usmeca', $("#request_usmeca").val() );

    loading(true);
    $.ajax({
      method:'POST',
      url:'/public/actualizar_documento_generado',
      data:form,
      dataType: 'json',
      processData: false,
      contentType: false,
      success:function(response){
        //$("#modalAdministracion").modal('show');
        console.log('RESPUESTA ACTUALIZAR DG :',response);
        if( response.status == 100){
          loading(false);
          modal_success('Documento actualizado','modalAdministracion')
          pintarDocumentosGenerados(1);

          $("#collapseOneDocumentosGenerados").collapse('hide');
          $("#id_documento_dg_editar").val();
          $("#divFormularioDG").empty();
          $("#request_usmeca").val( '' );
          $("#titleAccordionDocumentosGenerados").text(`Generar Documento`);
          $("#divTipoPlantilla").css('display','flex');

        }else{
          loading(false);
          modal_error(response.message,'modalAdministracion');
        }
      } // success
    }); // ajax
  }


  /**********************
  *
  * CANCELAR EDICION DE DOCUMENTOS
  *
  **********************/

  function cancelarEdicionDG(){
    $("#collapseOneDocumentosGenerados").collapse('hide');
    $("#id_documento_dg_editar").val();
    $("#divFormularioDG").empty();
    $("#request_usmeca").val( '' );
    $("#titleAccordionDocumentosGenerados").text(`Generar Documento`);
    $("#divTipoPlantilla").css('display','flex');
  }

  function verDocumentoGenerado(id_documento, vista = 'tabla'){
    oficio = vista == 'tabla' ? arrDG.filter(x=>x.id_documento==id_documento)[0] : arrOfDG.filter(x=>x.id_documento==id_documento)[0]
    fecha = vista == 'tabla' ? oficio.creacion : oficio.fecha_firmado;

    $.ajax({
      method:'POST',
      url:'/public/obtener_ultima_version_documento_generado',
      data:{
        carpeta : $("#id_carpeta_judicial").val(),
        id_documento,
        modo : 'pdf',
      },
      success:function(response){
        console.log('RESPUESTA DG PDF :',response);
        if( response.status == 100){
          if( response.response.split('.')[1] == 'pdf' )
            modal_detalle('DOCUMENTO',`
              <div class="file-group">
                <div class="file-item">
                  <div class="row no-gutters wd-100p">
                    <div class="col-9 col-md-7 d-flex align-items-center">
                      <i class="fa fa-file-pdf-o" style="font-size:20px;"></i>
                      <a href="">${oficio.nombre_archivo}.pdf</a>
                    </div><!-- col-6 -->
                    <div class="col-3 col-md-2 tx-right tx-sm-left">${ Number.parseFloat( oficio.tamanio_archivo * 1024 ).toFixed(3)} KB</div>
                    <div class="col-6 col-md-3 tx-right mg-t-5 mg-sm-t-0">${fecha.split(' ')[0].split('-').reverse().join('-')} ${fecha.split(' ')[1]}</div>
                  </div><!-- row -->
                </div><!-- file-item -->
              </div>
              <object data="${response.response}"	width="100%"	height="600">	</object>
            `,'modalAdministracion');
          else
            window.open(response.response, '_blank');
        }else{
          modal_error(response.message,'modalAdministracion');
        }
      } // success
    }); // ajax
  }

  function borrarDocumentoGenerado(id_documento){
    $("#modalAdministracion").modal('hide');

    let docs = arrDG.filter( x => x.id_documento == id_documento );
    
    if( docs[0].flujo_estatus == 'firmado' ){
      @if( isset($permisos[87]) and $permisos[87] == 1 )
      @else
        return false;
      @endif
    }
    

    loading(true);
    $.ajax({
      method:'POST',
      url:'/public/actualizar_documento_generado',
      data:{
        carpeta : $("#id_carpeta_judicial").val(),
        id_documento,
        estatus_documento:0,
      },
      success:function(response){
        //$("#modalAdministracion").modal('show');
        console.log('RESPUESTA ACTUALIZAR DG :',response);
        if( response.status == 100){
          loading(false);
          modal_success('Documento Borrado','modalAdministracion')
          pintarDocumentosGenerados(1);
          afectarEspacio('todo');
        }else{
          loading(false);
          modal_error(response.message,'modalAdministracion');
        }
      } // success
    }); // ajax
  }

  function reenviarSolicitudUSMC(id_documento){
    $("#modalAdministracion").modal('hide');
    loading(true);
    $.ajax({
      method:'POST',
      url:'/public/enviar_solicitud_usmeca',
      data:{
        carpeta : $("#id_carpeta_judicial").val(),
        id_documento,
      },
      error:function(err){
        loading(false);
        setTimeout(function(){ modal_error(err,'modalAdministracion'); },1500);

      },
      success:function(response){
        //$("#modalAdministracion").modal('show');
        console.log('RESPUESTA REENVIAR USMC :',response);
        if( response.status == 100){
          loading(false);
          setTimeout(function(){ modal_success('Oficio reenviado a USMC <br> Folio: '+response.response.folio,'modalAdministracion'); },1000);
          pintarDocumentosGenerados(1);
          pintarOficiosEnviadosUSMC(1);
        }else{
          loading(false);
          modal_error('Error USMC dice: '+response.response.mensaje,'modalAdministracion');
        }
      } // success
    }); // ajax
  }


  /**********************
  *
  * CONFIRMAR ENVIO
  *
  **********************/
  function confirmarEnvio(){
    modal_error('OPS! En desarrollo','modalAdministracion');
  }

  function generarDocumento(){
    //alert("Llegaste a generar documento");
    if( $("#tipoPlantilla").val()=='-' ) {
      modal_error('Debes seleccionar una plantilla','modalAdministracion');
      $("#btnGenerarDocumento").attr("disabled",false);
      return false;
    }

    let validacion = validar($("#tipoPlantilla").val());
    if( validacion['status']==0 ){
      $(validacion['input']).parent().parent().addClass('error');
      modal_error(validacion['message'],'modalAdministracion');

      $(".paso").css('display','none');
      let content = obtener_padre( $(validacion['input']) , 'paso');
      $( content ).css('display','flex');
      return false;
    }

    $("#btnGenerarDocumento").attr("disabled",true);

    $.ajax({
      method:'POST',
      url:'/public/obtener_plantilla_documento_generado_carpeta',
      data:{
        carpeta : $("#id_carpeta_judicial").val(),
        id_solicitud : $("#id_solicitud").val(),
        tipo_solicitud : $("#tipo_solicitud").val(),
        plantilla : $("#tipoPlantilla").val(),

        asunto : $("#asunto-DG").val(),
        plazoProceso : $("#plazoProceso-DG").val(),
        obligacionPresentarseUSMC : $("#obligacionPresentarseUSMC-DG").val(),

        codigo: $("#tipoPlantilla").val(),
        numOficio:$("#numOficio-DG").val(),
        carpetaJudicial:$("#carpetaJudicial-DG").val(),

        audienciaConcede:$("#audienciaConcede-DG").val(),
        audienciaConcedeObj: arrAuDG[ $("#audienciaConcede-DG").val() ],
        peridoSuspension:$("#peridoSuspension-DG").val(),
        fechaFenecimiento:$("#fechaFenecimiento-DG").val(),
        presentacionImputadoAnteUnidad:$("#presentacionImputadoAnteUnidad-DG").val(),
        fechaPresentacionImputado:$("#fechaPresentacionImputado-DG").val(),
        periodoPresentacionImputado:$("#periodoPresentacionImputado-DG").val(),
        valorPeriodoPresentacionImputadoAnteUnidad:$("#valorPeriodoPresentacionImputadoAnteUnidad-DG").val(),
        plazoReporteIncumplimiento:$("#plazoReporteIncumplimiento-DG").val(),
        JuezInformante:$("#JuezInformante-DG").val(),

        arrItems,
        //arrAnexosDG,

        imputados: arrImputadosSeleccionados, //  $("#imputados-DG").val(),
        id_imputado:$("#imputados-DG option:Selected").attr("data-idpersona"),
        audienciaImposicionMedidasCautelares:$("#audienciaImposicionMedidasCautelares-DG").val(),
        audienciaImposicionMedidasCautelaresObj: arrAuDG[ $("#audienciaImposicionMedidasCautelares-DG").val()],
        mostrarVictimasComo:$("#mostrarVictimasComo-DG").val(),
        firmadoPor:$("#firmadoPor-DG").val(),

        audienciaSobreseimiento:$("#audienciaSobreseimiento-DG").val(),
        audienciaSobreseimientoObj: arrAuDG[ $("#audienciaSobreseimiento-DG").val()],
        audienciaMedidasCautelares:$("#audienciaMedidasCautelares-DG").val(),
        audienciaMedidasCautelaresObj: arrAuDG[ $("#audienciaMedidasCautelares-DG").val()],
        numeroOficioMedidasCautelares:$("#numeroOficioMedidasCautelares-DG").val(),

        audienciaCelebrarObj: arrAuDG[ $("#audienciaCelebrar-DG").val() ],

        tiempoResolucionSituacionJuridica:$("#tiempoResolucionSituacionJuridica-DG").val(),

        planReparacionDanio: $("#planReparacionDanio-DG").val(),

      },
      error: function(request, status, error){
        $("#btnGenerarDocumento").attr("disabled",false);
        console.log(request,status,error);
        modal_error('Ocurrió un error','modalAdministracion');
      },
      success:function(response){
        console.log(response);
        //return false;
        if( response.status == 100){
          cargarHTMLEditor(response.response.plantilla);
          //cargarHTMLEditor(response.message[0].txt_plantilla_documento);
          $("#request_usmeca").val( JSON.stringify(response.response.request_usmeca) );
          $("#consumir_ws_usmeca").val( response.response.consumir_ws_usmeca );
          //afectarEspacio('documento-generado');
          setTimeout(function(){
            
            $('#editor').css({'width': '800PX', 'text-align': '-webkit-center', 'margin-left':'auto', 'margin-right': 'auto'
          });
            $( "#editor div:nth-child(1) div:nth-child(1)" ).addClass( "show-placeholder");
            $( "#editor td:nth-child(1)" ).css( {"width":"50%", "padding-top":"10px"} );
            $( "#editor img:nth-child(1)" ).css( {"height":"100px"} );
            $( "#editor td:nth-child(2)" ).css( {"text-align": "right", "width":"50%"} );
            $( "#editor img:nth-child(2)" ).css( {"height": "90px", "margin-left":"auto"} );
            $( "#editor td:nth-child(2) p" ).css( {"font-weigth":"bold", "font-style": "italic", "font-size": "18px", "margin-bottom": "0px"} );
          }, 500);
        }else{
          $("#btnGenerarDocumento").attr("disabled",false);
          modal_error(response.message,'modalAdministracion');
        }
      } // success
    }); // ajax
  }

  function validar(id_plantilla){
    $(".error").removeClass('error');

    if(id_plantilla=='501') return {'status':100};

    if( !$("#numOficio-DG").val() ) return {'status':0,'input' : '#numOficio-DG', 'message' : 'Debe ingresar un numero de oficio'};
    arrImputadosSeleccionados=[];
    // arrAnexosDG=[];

    // $("#divPreviewDG object").each(function(){
    //   arrAnexosDG.push( {
    //     'b64' : $(this).attr('data').split('base64,')[1],
    //     'nombre_archivo' : $(this).attr('data-nombre'),
    //     'tamanio_archivo': $(this).attr('data-tamanio'),
    //     'extension_archivo' : $(this).attr('data-extension'),
    //   } );
    // });

    switch(id_plantilla){
      case "41" : // suspensión condicional del proceso
        if($("#imputados-DG option:selected").val()=='-') return {'status':0,'input' : '#imputados-DG', 'message' : 'Debe seleccionar un imputado'};

        arrImputadosSeleccionados.push( arrPP[ $("#imputados-DG option:selected").val() ] );
        // $(".imputado-DG:checked").each(function(){
        //   console.log($(this).val(),arrPP[ $(this).val() ]);
        //   arrImputadosSeleccionados.push( arrPP[ $(this).val() ] );
        // });
        if( arrImputadosSeleccionados.length==0) return {'status':0,'input' : '#imputados-DG', 'message' : 'Debe seleccionar un imputado'};
        if( $("#audienciaConcede-DG").val() == '-') return {'status':0,'input' : '#audienciaConcede-DG', 'message' : 'Debe seleccionar una audiencia'};
        if( !$("#plazoProceso-DG").val() ) return {'status':0,'input' : '#plazoProceso-DG', 'message' : 'Debe ingresar un plazo'};
        if( !$("#obligacionPresentarseUSMC-DG").val() ) return {'status':0,'input' : '#obligacionPresentarseUSMC-DG', 'message' : 'Debe ingresar un lapso de tiempo en que el imputado debe presentarse ante la USMC'};
        if( !$("#peridoSuspension-DG").val() ) return {'status':0,'input' : '#peridoSuspension-DG', 'message' : 'Debe ingresar un peridoo de suspension'};
        if( !$("#fechaFenecimiento-DG").val() || !expRegFecha.test( $("#fechaFenecimiento-DG").val() ) ) return {'status':0,'input' : '#fechaFenecimiento-DG', 'message' : 'Debe ingresar la fecha de fenecimiento con el formato correcto DD-MM-AAAA'};
        if( $("#presentacionImputadoAnteUnidad-DG").val()=='fecha' && (!$("#fechaPresentacionImputado-DG").val() || !expRegFecha.test( $("#fechaPresentacionImputado-DG").val() ))  ) return {'status':0,'input' : '#fechaPresentacionImputado-DG', 'message' : 'Debe ingresar la fecha de presentación con el formato correcto DD-MM-AAAA'};
        if( $("#presentacionImputadoAnteUnidad-DG").val()=='periodo' && (!$("#periodoPresentacionImputado-DG").val() ||!expRegFecha.test( $("#periodoPresentacionImputado-DG").val() ) ) ) return {'status':0,'input' : '#periodoPresentacionImputado-DG', 'message' : 'Debe ingresar un periodo de presentación con el formato correcto DD-MM-AAAA'};
        if( !$("#plazoReporteIncumplimiento-DG").val() ) return {'status':0,'input' : '#plazoReporteIncumplimiento-DG', 'message' : 'Debe ingresar un plazo'};
        if( $("#JuezInformante-DG").val()=='-' ) return {'status':0,'input' : '#JuezInformante-DG', 'message' : 'Debe seleccionar un juez'};
        if( arrItems.length==0 ) return {'status':0,'input' : '#itemID-DG', 'message' : 'Debe ingresar al menos una condición'};
        return {'status':100};
      break;

      case "532" : // Medida Cautelar dentro del plazo constitucional
      case "503" : // imposición de medida cautelar

        if($("#imputados-DG option:selected").val()=='-') return {'status':0,'input' : '#imputados-DG', 'message' : 'Debe seleccionar un imputado'};
         arrImputadosSeleccionados.push( arrPP[ $("#imputados-DG option:selected").val() ] );
        // $(".imputado-DG:checked").each(function(){
        //   console.log($(this).val(),arrPP[ $(this).val() ]);
        //   arrImputadosSeleccionados.push( arrPP[ $(this).val() ] );
        // });
        if( arrImputadosSeleccionados.length==0) return {'status':0,'input' : '#imputados-DG', 'message' : 'Debe seleccionar un imputado'};
        if( !$("#plazoProceso-DG").val() ) return {'status':0,'input' : '#plazoProceso-DG', 'message' : 'Debe ingresar un plazo'};
        if( !$("#obligacionPresentarseUSMC-DG").val() ) return {'status':0,'input' : '#obligacionPresentarseUSMC-DG', 'message' : 'Debe ingresar un lapso de tiempo en que el imputado debe presentarse ante la USMC'};
        if( $("#audienciaImposicionMedidasCautelares-DG").val() == '-') return {'status':0,'input' : '#audienciaImposicionMedidasCautelares-DG', 'message' : 'Debe seleccionar una audiencia'};
        if( $("#firmadoPor-DG").val()=='-' ) return {'status':0,'input' : '#firmadoPor-DG', 'message' : 'Debe seleccionar un juez'};
        if( arrItems.length==0 ) return {'status':0,'input' : '#itemID-DG', 'message' : 'Debe ingresar al menos una medida cautelar'};
        return {'status':100};
      break;

      case "513":  //Se informa sobreseimiento :

        if($("#imputados-DG option:selected").val()=='-') return {'status':0,'input' : '#imputados-DG', 'message' : 'Debe seleccionar un imputado'};
        arrImputadosSeleccionados.push( arrPP[ $("#imputados-DG option:selected").val() ] );
        // $(".imputado-DG:checked").each(function(){
        //   console.log($(this).val(),arrPP[ $(this).val() ]);
        //   arrImputadosSeleccionados.push( arrPP[ $(this).val() ] );
        // });
        if( arrImputadosSeleccionados.length==0) return {'status':0,'input' : '#imputados-DG', 'message' : 'Debe seleccionar un imputado'};
        if( $("#imputados-DG").val() == '-') return {'status':0,'input' : '#imputados-DG', 'message' : 'Debe seleccionar un imputado'};
        if( $("#audienciaSobreseimiento-DG").val() == '-') return {'status':0,'input' : '#audienciaSobreseimiento-DG', 'message' : 'Debe seleccionar la audiencia de sobreseimiento'};
        if( $("#audienciaMedidasCautelares-DG").val() == '-') return {'status':0,'input' : '#audienciaMedidasCautelares-DG', 'message' : 'Debe seleccionar la audiencia de medida cautelar'};
        if( !$("#numeroOficioMedidasCautelares-DG").val() ) return {'status':0,'input' : '#numeroOficioMedidasCautelares-DG', 'message' : 'Debe ingresar el numero de oficio de medida cautelar'};
        if( $("#firmadoPor-DG").val()=='-' ) return {'status':0,'input' : '#firmadoPor-DG', 'message' : 'Debe seleccionar un juez'};
        return {'status':100};
      break;

      case "504" : // Se informa audiencia y se solicita informe de solución alterna

        if($("#imputados-DG option:selected").val()=='-') return {'status':0,'input' : '#imputados-DG', 'message' : 'Debe seleccionar un imputado'};
        arrImputadosSeleccionados.push( arrPP[ $("#imputados-DG option:selected").val() ] );
        // $(".imputado-DG:checked").each(function(){
        //   console.log($(this).val(),arrPP[ $(this).val() ]);
        //   arrImputadosSeleccionados.push( arrPP[ $(this).val() ] );
        // });
        if( arrImputadosSeleccionados.length==0) return {'status':0,'input' : '.imputados-DG', 'message' : 'Debe seleccionar un imputado'};
        if( $("#imputados-DG").val() == '-') return {'status':0,'input' : '#imputados-DG', 'message' : 'Debe seleccionar un imputado'};
         if( $("#audienciaCelebrar-DG").val() == '-') return {'status':0,'input' : '#audienciaCelebrar-DG', 'message' : 'Debe seleccionar la audiencia'};
        if( $("#firmadoPor-DG").val()=='-' ) return {'status':0,'input' : '#firmadoPor-DG', 'message' : 'Debe seleccionar un juez'};
        return {'status':100};
      break;

      case "533" : // suspensión condicional del proceso y medidas cautelares
        if($("#imputados-DG option:selected").val()=='-') return {'status':0,'input' : '#imputados-DG', 'message' : 'Debe seleccionar un imputado'};

        arrImputadosSeleccionados.push( arrPP[ $("#imputados-DG option:selected").val() ] );
        // $(".imputado-DG:checked").each(function(){
        //   console.log($(this).val(),arrPP[ $(this).val() ]);
        //   arrImputadosSeleccionados.push( arrPP[ $(this).val() ] );
        // });
        if( arrImputadosSeleccionados.length==0) return {'status':0,'input' : '#imputados-DG', 'message' : 'Debe seleccionar un imputado'};
        if( $("#audienciaConcede-DG").val() == '-') return {'status':0,'input' : '#audienciaConcede-DG', 'message' : 'Debe seleccionar una audiencia'};
        if( !$("#plazoProceso-DG").val() ) return {'status':0,'input' : '#plazoProceso-DG', 'message' : 'Debe ingresar un plazo'};
        if( !$("#obligacionPresentarseUSMC-DG").val() ) return {'status':0,'input' : '#obligacionPresentarseUSMC-DG', 'message' : 'Debe ingresar un lapso de tiempo en que el imputado debe presentarse ante la USMC'};
        // if( !$("#peridoSuspension-DG").val() ) return {'status':0,'input' : '#peridoSuspension-DG', 'message' : 'Debe ingresar un peridoo de suspension'};
        // if( !$("#fechaFenecimiento-DG").val() ) return {'status':0,'input' : '#fechaFenecimiento-DG', 'message' : 'Debe ingresar la fecha de fenecimiento'};
        // if( $("#presentacionImputadoAnteUnidad-DG").val()=='fecha' && !$("#fechaPresentacionImputado-DG").val() ) return {'status':0,'input' : '#fechaPresentacionImputado-DG', 'message' : 'Debe ingresar la fecha de presentación'};
        // if( $("#presentacionImputadoAnteUnidad-DG").val()=='periodo' && !$("#periodoPresentacionImputado-DG").val() ) return {'status':0,'input' : '#periodoPresentacionImputado-DG', 'message' : 'Debe ingresar un periodo de presentación'};
        // if( !$("#plazoReporteIncumplimiento-DG").val() ) return {'status':0,'input' : '#plazoReporteIncumplimiento-DG', 'message' : 'Debe ingresar un plazo'};
        if( $("#JuezInformante-DG").val()=='-' ) return {'status':0,'input' : '#JuezInformante-DG', 'message' : 'Debe seleccionar un juez'};
        if( arrItems.length==0 ) return {'status':0,'input' : '#itemID-DG', 'message' : 'Debe ingresar al menos una condición'};
        return {'status':100};
      break;

      default:
        return {'status':100};
      break;
    }
  }

  function obtener_padre( tag , clase){
    if( $(tag).hasClass( clase ) ) return tag;
    else return obtener_padre( $( tag ).parent() , clase);
  }


  /******************
  *
  * CONFIG COMPONENTS DG
  *
  *********************/

  function loadConfigComponentsDG(){

    setTimeout(function(){$('#tipoPlantilla').select2({minimumResultsForSearch: ''});},2000);
    $('#personaEnviar').select2({minimumResultsForSearch: ''});

    $("#tipoPlantilla").change(function(){
      $("#divFormularioDG").empty();

      if($(this).val()!='-'){

        if(  oficiosUSMC_WS.includes( $(this).val() ) ){
          arrCalidadImputados = [ 56, 46 ];
          let imputados_fisicos  = arrPP.filter( function(x) {
            console.log( "calidad_juridica DG:"+x.info_principal.id_calidad_juridica );
            if( arrCalidadImputados.includes( x.info_principal.id_calidad_juridica ) ){
              return x;
            }
          });

          if( !imputados_fisicos.length ){
            modal_error('No se puede generar un oficio a USMC. <br> la carpeta judicial no cuenta con imputados físicos','modalAdministracion');
            return false;
          }
        }

        $("#divFormularioDG").append(obtenerFormularioDG($(this).val()));
        setTimeout(function(){ aplicarClasesTag(); }, 1000)

        if($(this).val()=='501'){
          generarDocumento();
        }
      }

      arrItems=[];
      arrAnexosDG = [];
    });

    //setTimeout(function(){cargarHTMLEditor();},500);
  }

  function obtenerFormularioDG(id_plantilla=`-`){
    let strForms = `
      <div class="col-lg-12">
        <br>
        <h5> ${ $("#tipoPlantilla").find('option:selected').text() } </h5>
        <hr/>
      </div>
    `;

    let formComun = `
      <input name="origenContenidoOficio-DG" type="radio" checked="checked" value="editor" style="display: none;">

      <div class="col-lg-4">
        <div class="form-group mg-b-10-force">
          <label class="form-control-label">No de oficio a asignar:<span class="tx-danger">*</span></label>
          <input type="number" class="form-control" id="numOficio-DG" name ="numOficio-DG" value="xxxxxxx"/>
        </div>
      </div>

      <div class="col-lg-4">
        <div class="form-group mg-b-10-force">
          <label class="form-control-label">Carpeta Judicial:<span class="tx-danger">*</span></label>
          <input type="text" class="form-control" id="carpetaJudicial-DG" name ="carpetaJudicial-DG" value="${ carpetaActiva.folio_carpeta }" readonly disabled />
        </div>
      </div>

      <div class="col-lg-4">
        <div class="form-group mg-b-10-force">
          <label class="form-control-label">Imputados:<span class="tx-danger">*</span></label>
          <select class="form-control" id="imputados-DG" name ="imputados-DG">
            <option value="-">Seleccione un imputado</option>
            ${get_strOption('imputados')}
          </select>
        </div>
      </div>

    `;

    let paso_siguiente = 0;

    switch(id_plantilla){
      case "41" : // suspensión condicional del proceso
      strForms = strForms + `
        <table class="mg-b-20 table-wizard">
          <tr>
            <td class="td-wizard">
              <p class="wizard activo d-inline-block d-md-flex" id="wizard-paso1-DG"><span class="num-wizard">1</span><span class="text-wizard d-none d-md-block">FORMULARIO</span></p>
            </td>
            <td class="td-wizard">
              <p class="wizard espera  d-inline-block d-md-flex" id="wizard-paso2-DG"><span class="num-wizard">2</span><span class="text-wizard d-none d-md-block">CONDICIONES DE SUSPENSIÓN CONDICIONAL</span></p>
            </td>
            <td class="td-wizard">
              <p class="wizard espera  d-inline-block d-md-flex" id="wizard-paso3-DG"><span class="num-wizard">3</span><span class="text-wizard d-none d-md-block">EDICIÓN DEL OFICIO</span></p>
            </td>
            <td class="td-wizard">
              <p class="wizard espera  d-inline-block d-md-flex" id="wizard-paso4-DG"><span class="num-wizard">4</span><span class="text-wizard d-none d-md-block">ENVÍO DE OFICIO</span></p>
            </td>
          </tr>
        </table>

        <div id="paso1-DG" class="row paso">
          ${formComun}

          <div class="col-lg-6">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label">Audiencia en la cual se concede:<span class="tx-danger">*</span></label>
              <select class="form-control select2" id="audienciaConcede-DG" name ="audienciaConcede-DG">
                <option value="-">Seleccione una audiencia</option>
                ${get_strOption('audiencias_cj')}
              </select>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label">Juez informante:<span class="tx-danger">*</span></label>
              <select class="form-control select2" id="JuezInformante-DG" name ="JuezInformante-DG">
                <option value="-">Seleccione un juez</option>
                ${get_strOption('jueces')}
              </select>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label">Periodo Suspensión:<span class="tx-danger">*</span></label>
              <input type="number" class="form-control" id="peridoSuspension-DG" name ="peridoSuspension-DG" placeholder="Periodo de suspensión en meses"/>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label">Fecha de fenecimiento:<span class="tx-danger">*</span></label>
              <div class="input-group">
                  <div class="input-group-prepend">
                      <div class="input-group-text">
                          <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                      </div>
                  </div>
                  <input type="text" class="form-control fc-datepicker" placeholder="DD/MM/AAAA" id="fechaFenecimiento-DG" name="fechaFenecimiento-DG" autocomplete="off">
              </div>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label">Plazo reporte incumplimiento:<span class="tx-danger">*</span></label>
              <input type="text" class="form-control datePicker" id="plazoReporteIncumplimiento-DG" name ="plazoReporteIncumplimiento-DG" placeholder="Plazo en días"/>
            </div>
          </div>

          <div class="col-lg-12">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label">Presentación de imputado ante unidad:<span class="tx-danger">*</span></label>

              <div class="row">
                <div class="col-lg-4">
                  <select class="form-control select2" id="presentacionImputadoAnteUnidad-DG" name ="presentacionImputadoAnteUnidad-DG">
                    <option value="fecha" selected>Fecha</option>
                    <option value="periodo">Periodo</option>
                  </select>
                </div>

                <div class="col-lg-4">
                  <div class="input-group" id="div-fechaPresentacionImputado-DG">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                        </div>
                    </div>
                    <input type="text" class="form-control fc-datepicker" id="fechaPresentacionImputado-DG" name ="fechaPresentacionImputado-DG" placeholder="DD/MM/AAAA"/>
                  </div>
                  <input type="text" class="form-control d-none" id="periodoPresentacionImputado-DG" name ="peridoPresentacionImputado-DG"/>
                </div>

                <div class="col-lg-4 d-none" id="div-valorPeriodoPresentacionImputadoAnteUnidad-DG">
                  <select class="form-control select2" id="valorPeriodoPresentacionImputadoAnteUnidad-DG" name ="valorPeriodoPresentacionImputadoAnteUnidad-DG">
                    <option value="horas">Horas</option>
                    <option value="dias">Dias</option>
                    <option value="meses">Meses</option>
                    <option value="anios">Años</option>
                  </select>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label">Plazo del Proceso:<span class="tx-danger">*</span></label>
              <input type="text" class="form-control" id="plazoProceso-DG" name ="plazoProceso-DG" placeholder="Ingrese el plazo de proceso" maxlength="50"/>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label">Obligacion de presentarse ante la USMC:<span class="tx-danger">*</span></label>
              <input type="text" class="form-control" id="obligacionPresentarseUSMC-DG" name ="obligacionPresentarseUSMC-DG" placeholder="Ingresar lapso en que debe presentarse el imputado" maxlength="100"/>
            </div>
          </div>

          <div class="col-lg-12">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label">Plan de reparación del daño:<span class="tx-danger">*</span></label>
              <textarea type="text" class="form-control" id="planReparacionDanio-DG" name ="planReparacionDanio-DG" placeholder="Ingrese plan de reparacion del daño" maxlength="700"></textarea>
            </div>
          </div>

          <div class="col-lg-6 col-6">
            <br>
          </div>

          <div class="col-lg-6 col-6" align="right">
            <br>
            <button type="button" class="btn btn-oblong btn-primary" data-anterior="" data-actual="#paso1-DG" data-siguiente="#paso2-DG" onclick="cambiarPaso(this,'siguiente')" style="width: 100px;"> Continuar </button>
          </div>

        </div>

        <div id="paso2-DG" class="row paso" style="display:none;">

          <div class="col-lg-12">
            <br>
            <h6> Ingrese las Condiciones de Suspension Condicional de Proceso </h6>
            <hr/>
          </div>

          <div class="col-lg-6">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label">Condición:</label>
              <select class="form-control select2" id="itemID-DG" name ="itemID-DG">
                ${get_strOption('condiciones')}
              </select>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label">Duración:</label>
              <input type="text" class="form-control" id="duracion-DG" name ="duracion-DG" placeholder="Ingrese el tiempo de duracion de la condicion" maxlength="50"/>
            </div>
          </div>

          <!--
          <div class="col-lg-12">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label">Detalles adicionales:</label>
              <textarea class="form-control select2" id="detallesAdcionales-DG" name ="detallesAdcionales-DG"></textarea>
            </div>
          </div>
          -->

          <div class="col-lg-12" align="right">
            <br>
            <button class="btn btn-oblong btn-outline-primary" type="button" onclick="agregarItem()" id="agregarItem-DG"> Agregar Condición </button>
          </div>


          <div class="col-lg-12">
            <br>
            <table id="tablaItems-DG" class="table datatable" style="border: 1px solid #dee2e6">
              <thead>
                <tr>
                  <th>Accion</th>
                  <th>Condición</th>
                  <!-- <th>Detalle adicional</th> -->
                  <th>Duración</th>
                </tr>
              </thead>
              <tbody>
                <td colspan="3" align="center">Sin condiciones agregadas</td>
              </tbody>
            </table>
            <br>
          </div>

          <div class="col-lg-6" align="left">
            <br>
            <button type="button" class="btn btn-oblong btn-secondary" data-anterior="#paso1-DG" data-actual="#paso2-DG" data-siguiente="#paso3-DG" onclick="cambiarPaso(this,'anterior')" style="width: 100px;"> Retroceder </button>
          </div>

          <div class="col-lg-6" align="right">
            <br>
            <button type="button" class="btn btn-oblong btn-primary" data-anterior="#paso1-DG" data-actual="#paso2-DG" data-siguiente="#paso3-DG" onclick="cambiarPaso(this,'siguiente',generarDocumento)" style="width: 100px;"> Continuar </button>
          </div>

        </div>

        <div id="paso3-DG" class="row paso" style="display:none;">

          <!--

          <div class="col-lg-6" align="center">
            <button type="button" class="btn btn-teal" onclick="showHide('#divEditorDocumentoGenerado','#divOficioWordDocumentoGenerado')" style="width: 100px;"> Generar Oficio </button>
          </div>

          <div class="col-lg-6" align="center">
            <button type="button" class="btn btn-info" onclick="showHide('#divOficioWordDocumentoGenerado','#divEditorDocumentoGenerado')" style="width: 100px;"> Subir Archivo Word </button>
          </div>

          <div class="col-lg-12" id="divOficioWordDocumentoGenerado" style="display: none;">
            <div class="custom-input-file">
              <input type="file" id="oficioWord-DG" class="input-file" value="" name="oficioWord-DG" accept=".doc, .docx" onchange="agregar_anexo(this)">
              <h5 class="px-3 py-3">Arrastre hasta aquí sus oficioWord o de clic para adjuntarlos</h5>
            </div>
          </div>

          -->

          <div class="col-lg-12" id="divEditorDocumentoGenerado" >
            <div id='editor' style="margin-top: 20px; width:100%;">

            </div>
          </div>


          <div class="col-lg-6" align="left">
            <br>
            <button type="button" class="btn btn-oblong btn-secondary" data-anterior="#paso2-DG" data-actual="#paso3-DG" data-siguiente="#paso4-DG" onclick="cambiarPaso(this,'anterior',cargarHTMLEditor)" style="width: 100px;"> Retroceder </button>
          </div>

          <div class="col-lg-6" align="right">
            <br>
            <button type="button" class="btn btn-oblong btn-primary" data-anterior="#paso2-DG" data-actual="#paso3-DG" data-siguiente="#paso4-DG" onclick="cambiarPaso(this,'siguiente')" style="width: 100px;"> Continuar </button>
          </div>

        </div>
      `;

      paso_siguiente = 4;
      break;

      case "503" : // imposición de medida cautelar
        strForms = strForms + `
          <table class="mg-b-20 table-wizard">
            <tr>
              <td class="td-wizard">
                <p class="wizard activo d-inline-block d-md-flex" id="wizard-paso1-DG"><span class="num-wizard">1</span><span class="text-wizard d-none d-md-block">FORMULARIO</span></p>
              </td>
              <td class="td-wizard">
                <p class="wizard espera  d-inline-block d-md-flex" id="wizard-paso2-DG"><span class="num-wizard">2</span><span class="text-wizard d-none d-md-block">IMPOSICIÓN DE MEDIDAS CAUTELARES</span></p>
              </td>
              <td class="td-wizard">
                <p class="wizard espera  d-inline-block d-md-flex" id="wizard-paso3-DG"><span class="num-wizard">3</span><span class="text-wizard d-none d-md-block">EDICIÓN DEL OFICIO</span></p>
              </td>
              <td class="td-wizard">
                <p class="wizard espera  d-inline-block d-md-flex" id="wizard-paso4-DG"><span class="num-wizard">4</span><span class="text-wizard d-none d-md-block">ENVÍO DE OFICIO</span></p>
              </td>
            </tr>
          </table>

          <div id="paso1-DG" class="row paso">
            ${formComun}

            <div class="col-lg-8">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Audiencia imposición de medidas cautelares:<span class="tx-danger">*</span></label>
                <select class="form-control" id="audienciaImposicionMedidasCautelares-DG" name ="audienciaImposicionMedidasCautelares-DG">
                  <option value="-">Seleccione una opcion</option>
                  ${get_strOption('audiencias_cj')}
                </select>
                </div>
            </div>

            <div class="col-lg-4">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Mostrar victimas como:<span class="tx-danger">*</span></label>
                <select class="form-control select2" id="mostrarVictimasComo-DG" name ="mostrarVictimasComo-DG">
                  <option value="-">Seleccione una opcion</option>
                  <option value="nombre_Completo">Nombre completo</option>
                  <option value="iniciales">Identidad reservada</option>
                </select>
              </div>
            </div>

            <div class="col-lg-4">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Plazo del Proceso:<span class="tx-danger">*</span></label>
                <input type="text" class="form-control" id="plazoProceso-DG" name ="plazoProceso-DG" placeholder="Ingrese el plazo de proceso" maxlength="50"/>
              </div>
            </div>

            <div class="col-lg-4">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Obligacion de presentarse ante la USMC:<span class="tx-danger">*</span></label>
                <input type="text" class="form-control" id="obligacionPresentarseUSMC-DG" name ="obligacionPresentarseUSMC-DG" placeholder="Ingresar lapso en que debe presentarse el imputado" maxlength="100"/>
              </div>
            </div>

            <div class="col-lg-4">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Firmado por:<span class="tx-danger">*</span></label>
                <select class="form-control" id="firmadoPor-DG" name ="firmadoPor-DG">
                  <option value="-">Seleccione un juez</option>
                  ${get_strOption('jueces')}
                </select>
              </div>
            </div>


            <div class="col-lg-6 col-6">
              <br>
            </div>

            <div class="col-lg-6 col-6" align="right">
              <br>
              <button type="button" class="btn btn-oblong btn-primary" data-anterior="" data-actual="#paso1-DG" data-siguiente="#paso2-DG" onclick="cambiarPaso(this,'siguiente')" style="width: 100px;"> Continuar </button>
            </div>

          </div>

          <div id="paso2-DG" class="row paso" style="display:none;">

            <div class="col-lg-12">
              <h6> Ingrese las Medidas Cautelares </h6>
              <hr/>
            </div>

            <div class="col-lg-6">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Medida cautelar:</label>
                <select class="form-control select2" id="itemID-DG" name ="itemID-DG">
                  ${get_strOption('medida_cautelar')}
                </select>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Duración:</label>
                <input type="text" class="form-control" id="duracion-DG" name ="duracion-DG" placeholder="Ingrese el tiempo de duracion de la medida cautelar" maxlength="50"/>
              </div>
            </div>

            <!--
            <div class="col-lg-12">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Detalles adicionales:</label>
                <textarea class="form-control" id="detallesAdcionales-DG" name ="detallesAdcionales-DG"></textarea>
              </div>
            </div>
            -->

            <div class="col-lg-12" align="right">
              <br>
              <button class="btn btn-oblong btn-outline-primary" type="button" onclick="agregarItem()" id="agregarItem-DG"> Agregar Medida Cautelar </button>
            </div>


            <div class="col-lg-12">
              <br>
              <table id="tablaItems-DG" class="table datatable" style="border: 1px solid #dee2e6">
                <thead>
                  <tr>
                    <th>Accion</th>
                    <th>Medida Cautelar</th>
                    <!-- <th>Detalle adicional</th> -->
                    <th>Duración</th>
                  </tr>
                </thead>
                <tbody>
                  <td colspan="3" align="center">Sin medidas cuatelares agregadas</td>
                </tbody>
              </table>
              <br>
            </div>

            <div class="col-lg-6" align="left">
              <br>
              <button type="button" class="btn btn-oblong btn-secondary" data-anterior="#paso1-DG" data-actual="#paso2-DG" data-siguiente="#paso3-DG" onclick="cambiarPaso(this,'anterior')" style="width: 100px;"> Retroceder </button>
            </div>

            <div class="col-lg-6" align="right">
              <br>
              <button type="button" class="btn btn-oblong btn-primary" data-anterior="#paso1-DG" data-actual="#paso2-DG" data-siguiente="#paso3-DG" onclick="cambiarPaso(this,'siguiente',generarDocumento)" style="width: 100px;"> Continuar </button>
            </div>

          </div>

          <div id="paso3-DG" class="row paso" style="display:none;">

            <div class="col-lg-12" id="divEditorDocumentoGenerado" >
              <div id='editor' style="margin-top: 20px; width:100%;">

              </div>
            </div>

            <div class="col-lg-6" align="left">
              <br>
              <button type="button" class="btn btn-oblong btn-secondary" data-anterior="#paso2-DG" data-actual="#paso3-DG" data-siguiente="#paso4-DG" onclick="cambiarPaso(this,'anterior',cargarHTMLEditor)" style="width: 100px;"> Retroceder </button>
            </div>

            <div class="col-lg-6" align="right">
              <br>
              <button type="button" class="btn btn-oblong btn-primary" data-anterior="#paso2-DG" data-actual="#paso3-DG" data-siguiente="#paso4-DG" onclick="cambiarPaso(this,'siguiente')" style="width: 100px;"> Continuar </button>
            </div>

          </div>
        `;
        paso_siguiente = 4;
      break;

      case "532" : // imposición de medida cautelar dentro del plazo constitucional
        strForms = strForms + `

          <table class="mg-b-20 table-wizard">
            <tr>
              <td class="td-wizard">
                <p class="wizard activo d-inline-block d-md-flex" id="wizard-paso1-DG"><span class="num-wizard">1</span><span class="text-wizard d-none d-md-block">FORMULARIO</span></p>
              </td>
              <td class="td-wizard">
                <p class="wizard espera  d-inline-block d-md-flex" id="wizard-paso2-DG"><span class="num-wizard">2</span><span class="text-wizard d-none d-md-block">MEDIDAS CAUTELARES</span></p>
              </td>
              <td class="td-wizard">
                <p class="wizard espera  d-inline-block d-md-flex" id="wizard-paso3-DG"><span class="num-wizard">3</span><span class="text-wizard d-none d-md-block">EDICIÓN DEL OFICIO</span></p>
              </td>
              <td class="td-wizard">
                <p class="wizard espera  d-inline-block d-md-flex" id="wizard-paso4-DG"><span class="num-wizard">4</span><span class="text-wizard d-none d-md-block">ENVÍO DE OFICIO</span></p>
              </td>
            </tr>
          </table>

          <div id="paso1-DG" class="row paso">
            ${formComun}

            <div class="col-lg-8">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Audiencia imposición de medidas cautelares:<span class="tx-danger">*</span></label>
                <select class="form-control" id="audienciaImposicionMedidasCautelares-DG" name ="audienciaImposicionMedidasCautelares-DG">
                  <option value="-">Seleccione una opcion</option>
                  ${get_strOption('audiencias_cj')}
                </select>
                </div>
            </div>

            <div class="col-lg-4">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Mostrar victimas como:<span class="tx-danger">*</span></label>
                <select class="form-control select2" id="mostrarVictimasComo-DG" name ="mostrarVictimasComo-DG">
                  <option value="-">Seleccione una opcion</option>
                  <option value="nombre_Completo">Nombre completo</option>
                  <option value="iniciales">Identidad reservada</option>
                </select>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Plazo del Proceso:<span class="tx-danger">*</span></label>
                <input type="text" class="form-control" id="plazoProceso-DG" name ="plazoProceso-DG" placeholder="Ingrese el plazo de proceso" maxlength="50"/>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Obligacion de presentarse ante la USMC:<span class="tx-danger">*</span></label>
                <input type="text" class="form-control" id="obligacionPresentarseUSMC-DG" name ="obligacionPresentarseUSMC-DG" placeholder="Ingresar lapso en que debe presentarse el imputado" maxlength="100"/>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Tiempo de resolucion de situación jurídica:<span class="tx-danger">*</span></label>
                <input type="text" class="form-control" id="tiempoResolucionSituacionJuridica-DG" name ="tiempoResolucionSituacionJuridica-DG" placeholder="Ingrese horas" maxlength="50"/>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Firmado por:<span class="tx-danger">*</span></label>
                <select class="form-control" id="firmadoPor-DG" name ="firmadoPor-DG">
                  <option value="-">Seleccione un juez</option>
                  ${get_strOption('jueces')}
                </select>
              </div>
            </div>


            <div class="col-lg-6 col-6">
              <br>
            </div>

            <div class="col-lg-6 col-6" align="right">
              <br>
              <button type="button" class="btn btn-oblong btn-primary" data-anterior="" data-actual="#paso1-DG" data-siguiente="#paso2-DG" onclick="cambiarPaso(this,'siguiente')" style="width: 100px;"> Continuar </button>
            </div>

          </div>

          <div id="paso2-DG" class="row paso" style="display:none;">

            <div class="col-lg-12">
              <h6> Ingrese las Medidas Cautelares </h6>
              <hr/>
            </div>

            <div class="col-lg-6">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Medida cautelar:</label>
                <select class="form-control select2" id="itemID-DG" name ="itemID-DG">
                  ${get_strOption('medida_cautelar')}
                </select>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Duración:</label>
                <input type="text" class="form-control" id="duracion-DG" name ="duracion-DG" placeholder="Ingrese el tiempo de duracion de la medida cautelar" maxlength="50"/>
              </div>
            </div>

            <!--
            <div class="col-lg-12">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Detalles adicionales:</label>
                <textarea class="form-control" id="detallesAdcionales-DG" name ="detallesAdcionales-DG"></textarea>
              </div>
            </div>
            -->

            <div class="col-lg-12" align="right">
              <br>
              <button class="btn btn-oblong btn-outline-primary" type="button" onclick="agregarItem()" id="agregarItem-DG"> Agregar Medida Cautelar </button>
            </div>


            <div class="col-lg-12">
              <br>
              <table id="tablaItems-DG" class="table datatable" style="border: 1px solid #dee2e6">
                <thead>
                  <tr>
                    <th>Accion</th>
                    <th>Medida Cautelar</th>
                    <!-- <th>Detalle adicional</th> -->
                    <th>Duración</th>
                  </tr>
                </thead>
                <tbody>
                  <td colspan="3" align="center">Sin medidas cuatelares agregadas</td>
                </tbody>
              </table>
              <br>
            </div>

            <div class="col-lg-6" align="left">
              <br>
              <button type="button" class="btn btn-oblong btn-secondary" data-anterior="#paso1-DG" data-actual="#paso2-DG" data-siguiente="#paso3-DG" onclick="cambiarPaso(this,'anterior')" style="width: 100px;"> Retroceder </button>
            </div>

            <div class="col-lg-6" align="right">
              <br>
              <button type="button" class="btn btn-oblong btn-primary" data-anterior="#paso1-DG" data-actual="#paso2-DG" data-siguiente="#paso3-DG" onclick="cambiarPaso(this,'siguiente',generarDocumento)" style="width: 100px;"> Continuar </button>
            </div>

          </div>

          <div id="paso3-DG" class="row paso" style="display:none;">

            <div class="col-lg-12" id="divEditorDocumentoGenerado" >
              <div id='editor' style="margin-top: 20px; width:100%;">

              </div>
            </div>

            <div class="col-lg-6" align="left">
              <br>
              <button type="button" class="btn btn-oblong btn-secondary" data-anterior="#paso2-DG" data-actual="#paso3-DG" data-siguiente="#paso4-DG" onclick="cambiarPaso(this,'anterior',cargarHTMLEditor)" style="width: 100px;"> Retroceder </button>
            </div>

            <div class="col-lg-6" align="right">
              <br>
              <button type="button" class="btn btn-oblong btn-primary" data-anterior="#paso2-DG" data-actual="#paso3-DG" data-siguiente="#paso4-DG" onclick="cambiarPaso(this,'siguiente')" style="width: 100px;"> Continuar </button>
            </div>

          </div>
        `;
        paso_siguiente = 4;
      break;

      case "513":  //Se informa sobreseimiento
        strForms = strForms + `
          <table class="mg-b-20 table-wizard">
            <tr>
              <td class="td-wizard">
                <p class="wizard activo d-inline-block d-md-flex" id="wizard-paso1-DG"><span class="num-wizard">1</span><span class="text-wizard d-none d-md-block">FORMULARIO</span></p>
              </td>
               <td class="td-wizard">
                <p class="wizard espera  d-inline-block d-md-flex" id="wizard-paso2-DG"><span class="num-wizard">2</span><span class="text-wizard d-none d-md-block">EDICIÓN DEL OFICIO</span></p>
              </td>
              <td class="td-wizard">
                <p class="wizard espera  d-inline-block d-md-flex" id="wizard-paso3-DG"><span class="num-wizard">3</span><span class="text-wizard d-none d-md-block">ENVÍO DE OFICIO</span></p>
              </td>
            </tr>
          </table>

          <div id="paso1-DG" class="row paso">
            ${formComun}

            <div class="col-lg-6">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Audiencia en la cual se indica sobreseimiento:<span class="tx-danger">*</span></label>
                <select class="form-control" id="audienciaSobreseimiento-DG" name ="audienciaSobreseimiento-DG">
                  <option value="-">Seleccione una opcion</option>
                  ${get_strOption('audiencias_cj')}
                </select>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Audiencia en la cual se fijan medidas cautelares:<span class="tx-danger">*</span></label>
                <select class="form-control" id="audienciaMedidasCautelares-DG" name ="audienciaMedidasCautelares-DG">
                  <option value="-">Seleccione una opcion</option>
                  ${get_strOption('audiencias_cj')}
                </select>
              </div>
            </div>

            <div class="col-lg-4">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">No. Oficio que informa medidas cautelares:<span class="tx-danger">*</span></label>
                <input type="number" class="form-control" id="numeroOficioMedidasCautelares-DG" name ="numeroOficioMedidasCautelares-DG" value="" placeholder="ingrese numero de oficio"/>
              </div>
            </div>

            <div class="col-lg-4">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Mostrar victimas como:<span class="tx-danger">*</span></label>
                <select class="form-control" id="mostrarVictimasComo-DG" name ="mostrarVictimasComo-DG">
                  <option value="-">Seleccione una opcion</option>
                  <option value="nombre_completo">Nombre completo</option>
                  <option value="iniciales">Identidad reservada</option>
                </select>
              </div>
            </div>

            <div class="col-lg-4">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Plazo del Proceso:<span class="tx-danger">*</span></label>
                <input type="text" class="form-control" id="plazoProceso-DG" name ="plazoProceso-DG" placeholder="Ingrese el plazo de proceso" maxlength="50"/>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Obligacion de presentarse ante la USMC:<span class="tx-danger">*</span></label>
                <input type="text" class="form-control" id="obligacionPresentarseUSMC-DG" name ="obligacionPresentarseUSMC-DG" placeholder="Ingresar lapso en que debe presentarse el imputado" maxlength="100"/>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Firmado por:<span class="tx-danger">*</span></label>
                <select class="form-control" id="firmadoPor-DG" name ="firmadoPor-DG">
                  <option value="-">Seleccione un juez</option>
                  ${get_strOption('jueces')}
                </select>
              </div>
            </div>

            <div class="col-lg-6 col-6">
              <br>
            </div>

            <div class="col-lg-6 col-6" align="right">
              <br>
              <button type="button" class="btn btn-oblong btn-primary" data-anterior="" data-actual="#paso1-DG" data-siguiente="#paso2-DG" onclick="cambiarPaso(this,'siguiente',generarDocumento)" style="width: 100px;"> Continuar </button>
            </div>

          </div>

          <div id="paso2-DG" class="row paso" style="display:none;">

            <div class="col-lg-12" id="divEditorDocumentoGenerado" >
              <div id='editor' style="margin-top: 20px; width:100%;">

              </div>
            </div>


            <div class="col-lg-6" align="left">
              <br>
              <button type="button" class="btn btn-oblong btn-secondary" data-anterior="#paso1-DG" data-actual="#paso2-DG" data-siguiente="#paso3-DG" onclick="cambiarPaso(this,'anterior',cargarHTMLEditor)" style="width: 100px;"> Retroceder </button>
            </div>

            <div class="col-lg-6" align="right">
              <br>
              <button type="button" class="btn btn-oblong btn-primary" data-anterior="#paso1-DG" data-actual="#paso2-DG" data-siguiente="#paso3-DG" onclick="cambiarPaso(this,'siguiente')" style="width: 100px;"> Continuar </button>
            </div>

          </div>
        `;
        paso_siguiente = 3;
      break;

      case "504" : // Se informa audiencia y se solicita informe de solución al70era</textarea>
        strForms = strForms + `
          <table class="mg-b-20 table-wizard">
            <tr>
              <td class="td-wizard">
                <p class="wizard activo d-inline-block d-md-flex" id="wizard-paso1-DG"><span class="num-wizard">1</span><span class="text-wizard d-none d-md-block">FORMULARIO</span></p>
              </td>
               <td class="td-wizard">
                <p class="wizard espera  d-inline-block d-md-flex" id="wizard-paso2-DG"><span class="num-wizard">2</span><span class="text-wizard d-none d-md-block">EDICIÓN DEL OFICIO</span></p>
              </td>
              <td class="td-wizard">
                <p class="wizard espera  d-inline-block d-md-flex" id="wizard-paso3-DG"><span class="num-wizard">3</span><span class="text-wizard d-none d-md-block">ENVÍO DE OFICIO</span></p>
              </td>
            </tr>
          </table>

          <div id="paso1-DG" class="row paso">
            ${formComun}

            <div class="col-lg-6">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Audiencia a celebrar:<span class="tx-danger">*</span></label>
                <select class="form-control" id="audienciaCelebrar-DG" name ="audienciaCelebrar-DG">
                  <option value="-">Seleccione una opcion</option>
                  ${get_strOption('audiencias_cj')}
                </select>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Mostrar victimas como:<span class="tx-danger">*</span></label>
                <select class="form-control select2" id="mostrarVictimasComo-DG" name ="mostrarVictimasComo-DG">
                  <option value="-">Seleccione una opcion</option>
                  <option value="nombre_Completo">Nombre completo</option>
                  <option value="iniciales">Identidad reservada</option>
                </select>
              </div>
            </div>


            <div class="col-lg-4">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Plazo del Proceso:<span class="tx-danger">*</span></label>
                <input type="text" class="form-control" id="plazoProceso-DG" name ="plazoProceso-DG" placeholder="Ingrese el plazo de proceso" maxlength="50"/>
              </div>
            </div>

            <div class="col-lg-4">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Obligacion de presentarse ante la USMC:<span class="tx-danger">*</span></label>
                <input type="text" class="form-control" id="obligacionPresentarseUSMC-DG" name ="obligacionPresentarseUSMC-DG" placeholder="Ingresar lapso en que debe presentarse el imputado" maxlength="100"/>
              </div>
            </div>

            <div class="col-lg-4">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Firmado por:<span class="tx-danger">*</span></label>
                <select class="form-control" id="firmadoPor-DG" name ="firmadoPor-DG">
                  <option value="-">Seleccione un juez</option>
                  ${get_strOption('jueces')}
                </select>
              </div>
            </div>

            <div class="col-lg-6 col-6">
              <br>
            </div>

            <div class="col-lg-6 col-6" align="right">
              <br>
              <button type="button" class="btn btn-oblong btn-primary" data-anterior="" data-actual="#paso1-DG" data-siguiente="#paso2-DG" onclick="cambiarPaso(this,'siguiente',generarDocumento)" style="width: 100px;"> Continuar </button>
            </div>

          </div>

          <div id="paso2-DG" class="row paso" style="display:none;">

            <div class="col-lg-12" id="divEditorDocumentoGenerado" >
              <div id='editor' style="margin-top: 20px; width:100%;">

              </div>
            </div>


            <div class="col-lg-6" align="left">
              <br>
              <button type="button" class="btn btn-oblong btn-secondary" data-anterior="#paso1-DG" data-actual="#paso2-DG" data-siguiente="#paso3-DG" onclick="cambiarPaso(this,'anterior',cargarHTMLEditor)" style="width: 100px;"> Retroceder </button>
            </div>

            <div class="col-lg-6" align="right">
              <br>
              <button type="button" class="btn btn-oblong btn-primary" data-anterior="#paso1-DG" data-actual="#paso2-DG" data-siguiente="#paso3-DG" onclick="cambiarPaso(this,'siguiente')" style="width: 100px;"> Continuar </button>
            </div>

          </div>
        `;
        paso_siguiente = 3;
      break;

      case "533" : // Suspensión condicional y medidas cautelares
        strForms = strForms + `
          <table class="mg-b-20 table-wizard">
            <tr>
              <td class="td-wizard">
                <p class="wizard activo d-inline-block d-md-flex" id="wizard-paso1-DG"><span class="num-wizard">1</span><span class="text-wizard d-none d-md-block">FORMULARIO</span></p>
              </td>
              <td class="td-wizard">
                <p class="wizard espera  d-inline-block d-md-flex" id="wizard-paso2-DG"><span class="num-wizard">2</span><span class="text-wizard d-none d-md-block">CONDICIONES DE SUSPENSIÓN CONDICIONAL</span></p>
              </td>
              <td class="td-wizard">
                <p class="wizard espera  d-inline-block d-md-flex" id="wizard-paso3-DG"><span class="num-wizard">3</span><span class="text-wizard d-none d-md-block">EDICIÓN DEL OFICIO</span></p>
              </td>
              <td class="td-wizard">
                <p class="wizard espera  d-inline-block d-md-flex" id="wizard-paso4-DG"><span class="num-wizard">4</span><span class="text-wizard d-none d-md-block">ENVÍO DE OFICIO</span></p>
              </td>
            </tr>
          </table>

          <div id="paso1-DG" class="row paso">
            ${formComun}

            <div class="col-lg-6">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Audiencia en la cual se concede:<span class="tx-danger">*</span></label>
                <select class="form-control select2" id="audienciaConcede-DG" name ="audienciaConcede-DG">
                  <option value="-">Seleccione una audiencia</option>
                  ${get_strOption('audiencias_cj')}
                </select>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Juez informante:<span class="tx-danger">*</span></label>
                <select class="form-control select2" id="JuezInformante-DG" name ="JuezInformante-DG">
                  <option value="-">Seleccione un juez</option>
                  ${get_strOption('jueces')}
                </select>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Plazo del Proceso:<span class="tx-danger">*</span></label>
                <input type="text" class="form-control" id="plazoProceso-DG" name ="plazoProceso-DG" placeholder="Ingrese el plazo de proceso" maxlength="50"/>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Obligacion de presentarse ante la USMC:<span class="tx-danger">*</span></label>
                <input type="text" class="form-control" id="obligacionPresentarseUSMC-DG" name ="obligacionPresentarseUSMC-DG" placeholder="Ingresar lapso en que debe presentarse el imputado" maxlength="100"/>
              </div>
            </div>

            <div class="col-lg-12">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Plan de reparación del daño:<span class="tx-danger">*</span></label>
                <textarea type="text" class="form-control" id="planReparacionDanio-DG" name ="planReparacionDanio-DG" placeholder="Ingrese plan de reparacion del daño" maxlength="700"></textarea>
              </div>
            </div>

            <div class="col-lg-6 col-6">
              <br>
            </div>

            <div class="col-lg-6 col-6" align="right">
              <br>
              <button type="button" class="btn btn-oblong btn-primary" data-anterior="" data-actual="#paso1-DG" data-siguiente="#paso2-DG" onclick="cambiarPaso(this,'siguiente')" style="width: 100px;"> Continuar </button>
            </div>

          </div>

          <div id="paso2-DG" class="row paso" style="display:none;">

            <div class="col-lg-12">
              <br>
              <h6> Ingrese las Condiciones de Suspension Condicional de Proceso y medidas cautelares </h6>
              <hr/>
            </div>

            <div class="col-lg-6">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Tipo:</label>
                <select class="form-control select2" id="itemTipo-DG" name ="itemTipo-DG" onchange="showHide( this.options[ this.selectedIndex ].dataset.show , this.options[ this.selectedIndex ].dataset.hide)">
                  <option value="condicion_suspension_del_proceso" data-show="#divSelectSuspension-DG" data-hide="#divSelectMedidas-DG" selected >Condicion de suspensión proceso</option>
                  <option value="medida_cautelar" data-show="#divSelectMedidas-DG" data-hide="#divSelectSuspension-DG">Medida cautelar</option>
                </select>
              </div>
            </div>

            <div class="col-lg-6" id="divSelectSuspension-DG" style="display:block;">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Condición:</label>
                <select class="form-control select2" id="itemID-DG" name ="itemID-DG">
                  ${get_strOption('condiciones')}
                </select>
              </div>
            </div>

            <div class="col-lg-6" id="divSelectMedidas-DG" style="display:none;">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Medida cautelar:</label>
                <select class="form-control select2" id="itemIDMC-DG" name ="itemIDMC-DG">
                  ${get_strOption('medida_cautelar')}
                </select>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Duración:</label>
                <input type="text" class="form-control" id="duracion-DG" name ="duracion-DG" placeholder="Ingrese el tiempo de duracion de la condicion" maxlength="50"/>
              </div>
            </div>

            <div class="col-lg-6" align="right">
              <br>
              <button class="btn btn-oblong btn-outline-primary" type="button" onclick="agregarItem()" id="agregarItem-DG"> Agregar  </button>
            </div>


            <div class="col-lg-12">
              <br>
              <table id="tablaItems-DG" class="table datatable" style="border: 1px solid #dee2e6">
                <thead>
                  <tr>
                    <th>Accion</th>
                    <th>Tipo</th>
                    <th>Artículo</th>
                    <th>Duración</th>
                  </tr>
                </thead>
                <tbody>
                  <td colspan="4" align="center">Sin articulos agregados</td>
                </tbody>
              </table>
              <br>
            </div>

            <div class="col-lg-6" align="left">
              <br>
              <button type="button" class="btn btn-oblong btn-secondary" data-anterior="#paso1-DG" data-actual="#paso2-DG" data-siguiente="#paso3-DG" onclick="cambiarPaso(this,'anterior')" style="width: 100px;"> Retroceder </button>
            </div>

            <div class="col-lg-6" align="right">
              <br>
              <button type="button" class="btn btn-oblong btn-primary" data-anterior="#paso1-DG" data-actual="#paso2-DG" data-siguiente="#paso3-DG" onclick="cambiarPaso(this,'siguiente',generarDocumento)" style="width: 100px;"> Continuar </button>
            </div>

          </div>

          <div id="paso3-DG" class="row paso" style="display:none;">

            <!--

            <div class="col-lg-6" align="center">
              <button type="button" class="btn btn-teal" onclick="showHide('#divEditorDocumentoGenerado','#divOficioWordDocumentoGenerado')" style="width: 100px;"> Generar Oficio </button>
            </div>

            <div class="col-lg-6" align="center">
              <button type="button" class="btn btn-info" onclick="showHide('#divOficioWordDocumentoGenerado','#divEditorDocumentoGenerado')" style="width: 100px;"> Subir Archivo Word </button>
            </div>

            <div class="col-lg-12" id="divOficioWordDocumentoGenerado" style="display: none;">
              <div class="custom-input-file">
                <input type="file" id="oficioWord-DG" class="input-file" value="" name="oficioWord-DG" accept=".doc, .docx" onchange="agregar_anexo(this)">
                <h5 class="px-3 py-3">Arrastre hasta aquí sus oficioWord o de clic para adjuntarlos</h5>
              </div>
            </div>

            -->

            <div class="col-lg-12" id="divEditorDocumentoGenerado" >
              <div id='editor' style="margin-top: 20px; width:100%;">

              </div>
            </div>


            <div class="col-lg-6" align="left">
              <br>
              <button type="button" class="btn btn-oblong btn-secondary" data-anterior="#paso2-DG" data-actual="#paso3-DG" data-siguiente="#paso4-DG" onclick="cambiarPaso(this,'anterior',cargarHTMLEditor)" style="width: 100px;"> Retroceder </button>
            </div>

            <div class="col-lg-6" align="right">
              <br>
              <button type="button" class="btn btn-oblong btn-primary" data-anterior="#paso2-DG" data-actual="#paso3-DG" data-siguiente="#paso4-DG" onclick="cambiarPaso(this,'siguiente')" style="width: 100px;"> Continuar </button>
            </div>

          </div>
        `;

        paso_siguiente = 4;
      break;
      default:
        strForms = strForms + `
          <table class="mg-b-20 table-wizard">
            <tr>
              <td class="td-wizard">
                <p class="wizard activo d-inline-block d-md-flex" id="wizard-paso1-DG" onclick="selecciona_wizard();"><span class="num-wizard">1</span><span class="text-wizard d-none d-md-block">CREACION DE OFICIO</span></p>
              </td>
              <td class="td-wizard">
                <p class="wizard espera  d-inline-block d-md-flex" id="wizard-paso2-DG" onclick="selecciona_wizard();"><span class="num-wizard">2</span><span class="text-wizard d-none d-md-block">ENVIO DE OFICIO</span></p>
              </td>
              <td class="td-wizard">
                <p class="wizard espera  d-inline-block d-md-flex" id="wizard-pasoAcuerdo-DG" onclick="selecciona_wizard('#wizard-pasoAcuerdo-DG')"><span class="num-wizard">A</span><span class="text-wizard d-none d-md-block">ACUERDO</span></p>
              </td>
            </tr>
          </table>

          <div id="paso1-DG" class="row paso">

            <div class="col-lg-12">
              <div class="form-group mg-t-20 col-lg-12">

                <label class="form-control-label mg-r-10">Seleccione que desea hacer:</label>

                <label class="rdiobox d-inline-block" onclick="showHide('#divEditorDocumentoGenerado','#divOficioWordDocumentoGenerado')">
                  <input name="origenContenidoOficio-DG" type="radio" checked="checked" value="editor">
                  <span>Crear un Documento en linea</span>
                </label>

                <label class="rdiobox d-inline-block mg-xs-l-20" onclick="showHide('#divOficioWordDocumentoGenerado','#divEditorDocumentoGenerado')">
                  <input name="origenContenidoOficio-DG" type="radio" value="archivo">
                  <span>Subir Oficio</span>
                </label>

              </div>
            </div>

            <div class="col-lg-12" id="divEditorDocumentoGenerado" >
              <div id='editor' style="margin-top: 20px; width:100%;">

              </div>
            </div>

            <div class="col-lg-12" id="divOficioWordDocumentoGenerado" style="display: none;">
              <div class="form-group">
                <label class="form-control-label"><span class="tx-danger">*</span> Oficio:</label>
                <div id="div_upload" class="field">
                  <input class="btn btn-oblong btn-outline-primary" type="file" name="oficioWord-DG" id="oficioWord-DG" accept=".doc, .docx" style="width: 100%;">
                </div>
              </div>
            </div>

            <div class="col-lg-6" align="left">
              <br>
            </div>

            <div class="col-lg-6" align="right">
              <br>
              <button type="button" class="btn btn-oblong btn-primary" data-anterior="#paso1-DG" data-actual="#paso1-DG" data-siguiente="#paso2-DG" onclick="cambiarPaso(this,'siguiente')" style="width: 100px;"> Continuar </button>
            </div>

          </div>

        `;
        paso_siguiente = 2;
      break;
    }

    let arrPlantillas = ["41","503","532"];
    //if( arrPlantillas.includes(id_plantilla) ){
    let strFormAnexo = ``;
    if( id_plantilla != 501 ){
      strFormAnexo = strFormAnexo + `
        <div class="col-lg-12">
          <br><br>
          <h3 class="tx-danger"align="center"> A n e x o s </h3>
          <hr>

          <div class="row">

            <div class="col-lg-4" id="divListaAnexos-DG" style="border-right: solid;">
              <ul class="list-group"  id="listaAnexos-DG">

              </ul>
            </div>

            <div class="col-lg-8">
              <div class="custom-input-file">
                <input type="file" id="anexos-DG" class="input-file" value="" name="anexos-DG" accept=".pdf" onchange="agregar_anexo(this)">
                <h5 class="px-3 py-3">Arrastre hasta aquí sus anexos o de clic para adjuntarlos</h5>
              </div>

              <div class="row" id="divPreviewDG">
              </div>
            </div>

          </div>
        </div>
      `;
    }

    strForms = strForms + `
      <div id="paso${paso_siguiente}-DG" class="row paso" style="display:none;">

        <div class="col-lg-12">
          <div class="form-group mg-t-20 col-lg-12">

            <label class="form-control-label mg-r-10">Seleccione que desea hacer con el oficio:</label>

            <label class="rdiobox d-inline-block" onclick="showHide('#enviar-DG', '#firmar-DG')">
              <input name="enviarOficio-DG" type="radio" checked value="enviar">
              <span>Enviar a otra persona</span>
            </label>

            <label class="rdiobox d-inline-block mg-xs-l-20" onclick="showHide('#firmar-DG', '#enviar-DG')">
              <input name="enviarOficio-DG" type="radio" value="firmar">
              <span>Firmar ${ id_plantilla != 501 ? 'y agregar anexos' : ''}</span>
            </label>

          </div>
        </div>


        <div class="col-lg-12" id="enviar-DG">
          <div class="form-group mg-b-10-force">
            <label class="form-control-label ">Enviar plantilla a:</label>
            <select class="form-control" id="personaEnviar" name ="personaEnviar">
              <option value="-">Seleccione una persona</option>
              ${get_strOption('firmantes-sin-subcausa')}
            </select>
          </div>
          <br><br>
        </div>

        <div class="col-lg-12" id="firmar-DG" style="display: none;">

            <div class="row" >

              <div class="col-lg-12">
                <label class="form-control-label mg-r-10">Selecciona el tipo de firma</label>
              </div>

              <div class="col-md-3">
                <label class="rdiobox">
                  <input name="tipo_firma" type="radio" id="tipo_firma_firel" value="firel_tsj" checked="" onclick="seleccionarCredenciales('firel_tsj')">
                  <span>Mi Firma</span>
                </label>
              </div>
              <div class="col-md-3">
                <label class="rdiobox">
                  <input name="tipo_firma" type="radio" id="tipo_firma_firel" value="firel_csj" onclick="seleccionarCredenciales('firel_csj')">
                  <span>Firel</span>
                </label>
              </div>
              <div class="col-md-3 mg-t-20 mg-lg-t-0">
                <label class="rdiobox">
                  <input name="tipo_firma" type="radio" id="tipo_firma_fiel" value="fiel_tsj" onclick="seleccionarCredenciales('fiel_tsj')">
                  <span>Fiel</span>
                </label>
              </div>
              <div class="col-md-3 mg-t-20 mg-lg-t-0" id="sello_sigj_visible_1">
                <label class="rdiobox">
                  <input name="tipo_firma" type="radio" id="tipo_firma_autografa" value="firma_autografa" onclick="seleccionarCredenciales('firma_autografa')">
                  <span>Firma Autografa</span>
                </label>
              </div>

              </hr>

              <div class="col-lg-6" id="id_pfx" style="display: block;">
                <div class="form-group">
                  <label class="form-control-label"><span class="tx-danger">*</span> Archivo PFX:</label>
                  <div id="div_upload" class="field">
                    <input class="btn btn-oblong btn-outline-primary" type="file" name="archivo_pfx" id="archivo_pfx" accept=".pfx" style="width: 100%;">
                  </div>
                </div>
              </div>
              <div class="col-lg-6" id="id_key" style="display: none;">
                <div class="form-group">
                  <label class="form-control-label"><span class="tx-danger">*</span> Archivo KEY:</label>
                  <div id="div_upload" class="field">
                    <input class="btn btn-oblong btn-outline-primary" type="file" name="archivo_key" id="archivo_key" accept=".key" style="width: 100%;">
                  </div>
                </div>
              </div>
              <div class="col-lg-6" id="id_cert" style="display: none;">
                <div class="form-group">
                  <label class="form-control-label"><span class="tx-danger">*</span> Archivo CER:</label>
                  <div id="div_upload" class="field">
                    <input class="btn btn-oblong btn-outline-primary" type="file" name="archivo_cer" id="archivo_cer" accept=".cer" style="width: 100%;">
                  </div>
                </div>
              </div>

              <div class="col" id="id_contrasenia" style="display: block;">
                <div class="form-group">
                  <label class="form-control-label">Contraseña: <span class="tx-danger">*</span></label>
                  <input class="form-control" type="password" name="password" id="password" value="" placeholder="" >
                </div>
              </div>

              <div class="col-lg-12" id="id_autografa" style="display: none;" align="center">
                <div class="form-group" align="right">
                  <a href="#" onclick="previewDG()"> Volver a descargar Oficio para Firma Autografa </a>
                  <br><br>
                </div>

                <div class="col-lg-12 custom-input-file">
                  <input type="file" id="archivo_firmado" class="input-file" value="" name="archivo_firmado" accept=".pdf" onchange="previewDGFA(this);">
                  <h5 class="px-3 py-3">Arrastre hasta aquí su oficio firmado o de clic para adjuntarlo</h5>
                </div>

                <div class="row">

                  <div class="col-lg-6" id="previewDownloadDG">
                    <br>
                    <h5> Oficio a descargar </h5>
                    <object id="objetoPreviewDownloadDG" height="300px" width="100%" class="mg-t-25" data=""></object>
                  </div>

                  <div class="col-lg-6" id="previewUploadDG">
                    <br>
                    <h5> Oficio firmado autografamente </h5>
                    <object id="objetoPreviewUploadDG" height="300px" width="100%" class="mg-t-25" data=""></object>
                  </div>
                </div>
              </div>

              @if( $request->session()->get('id_tipo_usuario') != 3 )
              ${strFormAnexo}
              @endif

            </div>
            <br>
        </div>

        @if( $request->session()->get('id_tipo_usuario') == 3 )
          ${strFormAnexo}
        @endif


        <div class="col-lg-6 col-6" align="left">
          <br>
          <button type="button" class="btn btn-oblong btn-secondary" data-anterior="#paso${paso_siguiente-1}-DG" data-actual="#paso${paso_siguiente}-DG" data-siguiente="" onclick="cambiarPaso(this,'anterior')" style="width: 100px;"> Retroceder </button>
        </div>
        <div class="col-lg-6 col-6" align="right">
          <br>
          <button type="button" class="btn btn-oblong btn-primary bd-0 ml-10" id="firmarDocumento" onclick="avanzarDocumento(null,'firmar')" style="width: 100px;">Enviar Oficio</button>
        </div>
      </div>
    `;

    if( id_plantilla == 501 ){
      strForms = strForms + `
        <div id="pasoAcuerdo-DG" class="row paso" style="display:none;">

          <div class="col-lg-12" id="divAcuerdoWordDocumentoGenerado">
            <div class="form-group">
              <label class="form-control-label"><span class="tx-danger">*</span> Acuerdo:</label>
              <div id="div_upload" class="field">
                <input class="btn btn-oblong btn-outline-primary" type="file" name="acuerdoWord-DG" id="acuerdoWord-DG" accept=".doc, .docx" style="width: 100%;">
              </div>
            </div>
          </div>

          <div class="col-lg-9" id="enviarAcuerdo-DG">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label ">Enviar acuerdo a:</label>
              <select class="form-control" id="personaEnviarAcuerdo" name ="personaEnviarAcuerdo">
                <option value="-">Seleccione una persona</option>
                ${get_strOption('jueces-directores')}
              </select>
            </div>
            <br><br>
          </div>

        
          <div class="col-lg-3" align="right">
            <br>
            <button type="button" class="btn btn-oblong btn-primary bd-0 ml-10" id="enviarDocumentoAcuerdo" onclick="avanzarDocumento(null,'enviar')" style="width: 150px;">Enviar Acuerdo</button>
          </div>

        </div>
      `;
    }

    return strForms;
  }

  function selecciona_wizard( tag_wizard = null ){
    $("#paso1-DG").css('display', 'none');
    $("#paso2-DG").css('display', 'none');
    $("#pasoAcuerdo-DG").css('display', 'none');
    
    $("p.wizard").removeClass("notfocus");

    
    if( tag_wizard == "#wizard-pasoAcuerdo-DG"){
      $("#wizard-pasoAcuerdo-DG").removeClass("espera").addClass("activo");
      $("#pasoAcuerdo-DG").css('display', 'flex');
      $("#wizard-paso1-DG").addClass("notfocus");
      $("#wizard-paso2-DG").addClass("notfocus");
    }
    else{
      $("#wizard-pasoAcuerdo-DG").removeClass("activo").addClass("espera");

      if( $("#wizard-paso1-DG").hasClass("resuelto") ){
        $("#paso2-DG").css('display', 'flex')
      }else{
        $("#paso1-DG").css('display', 'flex')
      }
    }
  }

  function cambiarPaso( button, sentido='siguiente', funcion=null){
    console.log(button);

    let ocultar = button.dataset.actual;
    let mostrar = sentido=='siguiente' ? button.dataset.siguiente :  button.dataset.anterior;

    $( ocultar ).css('display', 'none');
    $( mostrar ).css('display', 'flex');

    $( ocultar.replaceAll('#','#wizard-') ).addClass('espera resuelto').removeClass('activo');
    $( mostrar.replaceAll('#','#wizard-') ).addClass('activo').removeClass('espera');

    if(funcion!=null){
      funcion();
    }
  }

  function showHide( show, hide){
    console.log("show & hide :",show,hide);
    let display_block = ['#divSelectMedidas-DG','#divSelectSuspension-DG'];
    if( display_block.includes( show ) ) $( show ).css('display','block');
    else $( show ).css('display','flex');
    $( hide ).css('display','none');

    if(show=='#enviar-DG') $("#firmarDocumento").text('Enviar Oficio');
    if(show=='#firmar-DG') $("#firmarDocumento").text('Firmar Oficio');
    // if(show=='#divEditorDocumentoGenerado') generarDocumento();

  }

  function afectarEspacio(accion='todo'){
    return false;
    switch(accion){
      case 'select-plantilla-general':
        $("#divFormularioDG").empty();
        //if($('#personaEnviar').hasClass('select2-'))
        $('#personaEnviar').empty();
        $('#personaEnviar').append(get_strOption('firmantes'));
        $("#editor").addClass('d-none');
        generarDocumento();
        $(".avanzar-documento").attr("disabled",false);
        $(".avanzar-documento").removeClass('d-none');

        $("#titleAccordionDocumentosGenerados").text(`Generar Documento`);
        $("#titleAccordionDocumentosGenerados").addClass(`bkg-collapsed-btn`);
        $("#titleAccordionDocumentosGenerados").removeClass(`bkg-collapsed-btn-edit`);
        $("#divActualizarDG").addClass('d-none');
        $("#id_documento_dg_editar").val('');
        $("#btnAcutalizarDocumento").attr('onclick',``);
        arrItems=[];
      break;
      case 'select-otra-plantilla':
        setTimeout(function(){aplicarClasesTag();},200);

        $("#btnGenerarDocumento").removeClass('d-none');
        $("#btnGenerarDocumento").attr('disabled',false);
        $("#editor").addClass('d-none');

        $('#personaEnviar').empty();
        $('#personaEnviar').append(get_strOption('firmantes'));

        $(".avanzar-documento").attr("disabled",true);
        $(".avanzar-documento").addClass('d-none');

        $("#titleAccordionDocumentosGenerados").text(`Generar Documento`);
        $("#titleAccordionDocumentosGenerados").addClass(`bkg-collapsed-btn`);
        $("#titleAccordionDocumentosGenerados").removeClass(`bkg-collapsed-btn-edit`);
        $("#divActualizarDG").addClass('d-none');
        $("#id_documento_dg_editar").val('');
        $("#btnAcutalizarDocumento").attr('onclick',``);
        arrItems=[];
      break;
      case 'documento-generado':
        $("#divFormularioDG").empty();
        $("#btnGenerarDocumento").addClass('d-none');

        $("#editor").removeClass('d-none');

        $(".avanzar-documento").removeClass('d-none');
        $(".avanzar-documento").attr("disabled",false);
      break;
      case 'documento-enviado':
        $(".avanzar-documento").attr("disabled",true);
      break;
      case 'edicion':
        $("#divFormularioDG").empty();
        //if($('#personaEnviar').hasClass('select2-'))
        $('#personaEnviar').empty();
        $('#personaEnviar').append(get_strOption('firmantes'));
        $("#editor").removeClass('d-none');
        $("#divActualizarDG").removeClass('d-none');
        $("#collapseOneDocumentosGenerados").collapse('show');
        $("#titleAccordionDocumentosGenerados").removeClass(`bkg-collapsed-btn`);
        $("#titleAccordionDocumentosGenerados").addClass(`bkg-collapsed-btn-edit`);
        $(".avanzar-documento").attr("disabled",true);
        $(".avanzar-documento").addClass('d-none');
      break;
      case 'todo': // reset formulario
      $('#tipoPlantilla').val('-').trigger('change');
      $("#btnGenerarDocumento").attr("disabled",true);
      $("#btnGenerarDocumento").addClass('d-none');
      $("#divSelectPlantilla").addClass('d-none');
      $("#enviarDocumento").addClass('d-none');
      $("#collapseOneDocumentosGenerados").collapse('hide');
      $("#firmarDocumento").addClass('d-none');
      $("#tipo_firma_firel").click();
      $("#editor").addClass('d-none');
      //cargarHTMLEditor('');
      $(".avanzar-documento").addClass('d-none');
      $("#id_documento_dg_editar").val('');
      $("#divActualizarDG").addClass('d-none');
      $("#titleAccordionDocumentosGenerados").text(`Generar Documento`);
      $("#titleAccordionDocumentosGenerados").addClass(`bkg-collapsed-btn`);
      $("#titleAccordionDocumentosGenerados").removeClass(`bkg-collapsed-btn-edit`);
      arrItems=[];
      break;
    }
  }

  function cargarHTMLEditor(html=``){
    //if( !$("#editor").hasClass('d-none') ) $("#editor").addClass('d-none');
    if(editor_html!=null)editor_html.destroy();
    editor_html=null;
    $("#editor").empty();
    $("#editor").append(`<div width="100%" align="center"><div style="max-width:640px;width:640px;min-width:640px;">${ html }</div></div>`);
    setTimeout(function(){editorHTML();},100);
    //$(".avanzar-documento").attr("disabled",true);
  }

  function editorHTML(){
    editor_html = new FroalaEditor("div#editor", {
      height: 'calc(100vh - 100vh/2)',
      language: 'es',
      imageDefaultWidth: 0,
      imageOutputSize: true,

      key: '0BA3jA11A8B5A3E4D4aIVLEABVAYFKc2Cb1MYGH1g1NYVMiG5G4E3C3A1C8C6D4A3F4==',
      embedlyKey: '0BA3jA11A8B5A3E4D4aIVLEABVAYFKc2Cb1MYGH1g1NYVMiG5G4E3C3A1C8C6D4A3F4==',

      htmlAllowedTags: ['.*'],
      htmlAllowedAttrs: ['.*'],
      htmlAllowedStyleProps: ['.*'],
      htmlRemoveTags: [],
      pasteAllowedStyleProps: ['.*'],
      pasteDeniedAttrs: [],
      lineBreakerOffset: 0,
      lineBreakerTags: [''],
      htmlAllowComments: true,

      attribution: false,
      autofocus: true,
      htmlUntouched: true,
      //htmlAllowedAttrs: ['v:shapes'],
      imageUploadParams:{
        'v:shapes':'mi_prueba'
      },
      imageRoundPercent: true,

      // Set custom buttons with separator between them.
      toolbarButtons: {
        'moreText': {
          'buttons': ['bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'fontFamily', 'fontSize', 'textColor', 'backgroundColor', 'inlineClass', 'inlineStyle', 'clearFormatting']
        },
        'moreParagraph': {
          'buttons': ['alignLeft', 'alignCenter', 'formatOLSimple', 'alignRight', 'alignJustify', 'formatOL', 'formatUL', 'paragraphFormat', 'paragraphStyle', 'lineHeight', 'outdent', 'indent', 'quote']
        },
        'moreRich': {
          'buttons': ['insertLink', 'insertImage', 'insertTable', 'fontAwesome', 'specialCharacters', 'embedly', 'insertFile', 'insertHR']
        },
        // 'moreMisc': {
        //   'buttons': ['undo', 'redo', 'fullscreen', 'print', 'getPDF', 'spellChecker', 'selectAll', 'html', 'help']
        // }
      },
      imageEditButtons: [['imageReplace', 'imageAlign', 'imageRemove', '|', 'imageLink', 'linkOpen', 'linkEdit', 'linkRemove', '-', 'imageDisplay', 'imageStyle', 'imageAlt', 'imageSize']],
      // toolbarButtonsXS: [['undo', 'redo'], ['bold', 'italic', 'underline']],
      events: {
        'image.beforeUpload': function (files) {
          const editor = this
          if (files.length) {
            var reader = new FileReader()
            reader.onload = function (e) {
              var result = e.target.result;
              console.log(result);
              console.log(e.target);
              num1=Math.floor(Math.random() * 100) + 1;
              num2=Math.floor(Math.random() * 100) + 1;

              editor.image.insert(result, null, {'v:shapes': 'Imagen_'+num1+'_'+num2+''}, editor.image.get())

              const dataAttributesToFix = ['v:shapes'] // replace this for the attributes you want fixed
              editor.events.on('image.inserted', image => {
                dataAttributesToFix.forEach(k => {
                  if (image.attr('data-str' + k)) {
                      image.attr( k, image.attr('data-str' + k))
                      image.removeAttr('data-str' + k)
                  }
                })
              })

            }
            reader.readAsDataURL(files[0])
          }
          return false
        }
      }
    })
  }

  /******************
  *
  * SUB - FUNCIONES PARA FORMULARIOS
  *
  *********************/
  function get_strOption(catalogo){
    arrCalidadImputados = [ 56, 46 ];
    arrCalidadVictima = [ 2, 8, 13, 60, 61, 62 ];
    strOptions = ``;
    switch(catalogo){
      case 'audiencias_cj':
        $(arrAuDG).each(function(index,a){
        //$(arrA).each(function(index,a){
          strOptions= strOptions + `<option value="${index}">${a.fecha_audiencia} de ${a.hora_inicio_audiencia} a ${a.hora_fin_audiencia} hrs.  ${a.tipo_audiencia}</option>`;
        });
        if( strOptions.length == 0 ) strOptions = `<option value="">Esta carpeta no tiene audiencias</option>`;
        console.log('catalogo:'+catalogo,'opciones:'+strOptions);
        return strOptions;
      break;
      case 'jueces':
        jueces = arrFirmantes.filter( x=>x.id_tipo_usuario==5 || x.id_tipo_usuario==14  );
        $(jueces).each(function(index,j){
          strOptions= strOptions + `<option value="${j.usuario}">${j.nombres} (${j.descripcion})</option>`;
        });
        console.log('catalogo:'+catalogo,'opciones:'+strOptions);
        return strOptions;
      break;
      case 'condiciones':
        $.ajax({
          method:'POST',
          url:'/public/obtener_catalogo_usmeca',
          async: false,
          data:{
            catalogo:'CSP',
            tipo: carpetaActiva.materia_destino  == 'adultos' ? 'adulto' : 'adolescente',
          },
          success:function(response){
            console.log(response);
            if(response.status==100){
              $(response.response).each(function(index,c){
                strOptions= strOptions + `<option value="${c.id_scmc}">${c.descripcion}</option>`;
              });
              console.log('catalogo:'+catalogo,'opciones:'+strOptions);
              return strOptions;
            }else{
              modal_error(response.message,'modalAdministracion');
            }
          }
        });
        return strOptions;
      break;
      case 'imputados':
        imputados = arrPP.filter( function(x) {
                                    if(  arrCalidadImputados.includes( x.info_principal.id_calidad_juridica )  )
                                      return x;
                                } );
        $(imputados).each(function(index,i){
          let nombre_completo = (i.info_principal.nombre??'')+' '+(i.info_principal.apellido_paterno??'')+' '+(i.info_principal.apellido_materno??'');
          if( i.info_principal.tipo_persona == 'moral' ) nombre_completo =  i.info_principal.razon_social;
          strOptions= strOptions + `<option value="${index}" data-idpersona="${i.info_principal.id_persona}">${nombre_completo} </option>`;
        });
        console.log('catalogo:'+catalogo,'opciones:'+strOptions);
        return strOptions;
      break;
      case 'medida_cautelar':
        $.ajax({
            method:'POST',
            url:'/public/obtener_catalogo_usmeca',
            async: false,
            data:{
              catalogo:'IMC',
              tipo: carpetaActiva.materia_destino  == 'adultos' ? 'adulto' : 'adolescente',
            },
            success:function(response){
              console.log(response);
              if(response.status==100){
                $(response.response).each(function(index,c){
                  strOptions= strOptions + `<option value="${c.id_scmc}">${c.descripcion}</option>`;
                });
                console.log('catalogo:'+catalogo,'opciones:'+strOptions);
                return strOptions;
              }else{
                modal_error(response.message,'modalAdministracion');
              }
            }
        });
        return strOptions;
      break;
      case 'victimas':
        vistimas = arrPP.filter( arrCalidadVictima.includes( x.info_principal.id_calidad_juridica ) );
        $(vistimas).each(function(index,v){
          let nombre_completo = (v.info_principal.nombre??'')+' '+(v.info_principal.apellido_paterno??'')+' '+(v.info_principal.apellido_materno??'')
          strOptions= strOptions + `<option value="${nombre_completo}">${nombre_completo} </option>`;
        });
        console.log('catalogo:'+catalogo,'opciones:'+strOptions);
        return strOptions;
      break;
      case 'firmantes':
        firmantes = arrFirmantes;
        strOptions=strOptions + `<option value="-">Seleccione una opcion</option>`;
        $(firmantes).each(function(index,f){
          strOptions= strOptions + `<option value="${f.id_usuario}">${f.nombres} (${f.descripcion}) - ${f.usuario}</option>`;
        });
        return strOptions;
        console.log('catalogo:'+catalogo,'opciones:'+strOptions);
      break;
      case 'firmantes-sin-subcausa':
        firmantes = arrFirmantes.filter( x=>x.id_tipo_usuario != 3 );
        strOptions=strOptions + `<option value="-">Seleccione una opcion</option>`;
        $(firmantes).each(function(index,f){
          strOptions= strOptions + `<option value="${f.id_usuario}">${f.nombres} (${f.descripcion}) - ${f.usuario}</option>`;
        });
        return strOptions;
        console.log('catalogo:'+catalogo,'opciones:'+strOptions);
      break;
      case 'jueces-directores':
        jd = arrFirmantes.filter( x=>x.id_tipo_usuario==5 || x.id_tipo_usuario==14 || x.id_tipo_usuario==2 );
        $(jd).each(function(index,j){
          strOptions= strOptions + `<option value="${j.id_usuario}">${j.nombres} (${j.descripcion}) - ${j.usuario}</option>`;
        });
        console.log('catalogo:'+catalogo,'opciones:'+strOptions);
        return strOptions;
      case 'audiencias_da':
        $(arrAuDG).each(function(index,a){
        //$(arrA).each(function(index,a){
          strOptions= strOptions + `<option value="${a.id_audiencia}">${a.fecha_audiencia} de ${a.hora_inicio_audiencia} a ${a.hora_fin_audiencia} hrs.  ${a.tipo_audiencia}</option>`;
        });
        if( strOptions.length == 0 ) strOptions = `<option value="">Esta carpeta no tiene audiencias</option>`;
        console.log('catalogo:'+catalogo,'opciones:'+strOptions);
        return strOptions;
      break;
      default:
        console.log('catalogo:'+catalogo,'opciones:'+strOptions);
        return strOptions;
      break;
    }
  }

  /******************
  *
  * SUB - FUNCIONES PARA FIRMADO DG
  *
  *********************/

  function aplicarClasesTag(){
    $("#divFormularioDG select").select2();
    $("#divFormularioDG .ui-datepicker-year").select2();

    // Datepicker
    $('#divFormularioDG .fc-datepicker').datepicker({
        showOtherMonths: true,
        selectOtherMonths: true,
        format: 'dd/mm/yyyy',
        changeYear: true,
        yearRange: "c-100:c+0"
    });

    $("#presentacionImputadoAnteUnidad-DG").change(function(){
      if( $(this).val() == 'fecha'){
        $("#div-fechaPresentacionImputado-DG").removeClass('d-none');
        $("#periodoPresentacionImputado-DG").addClass('d-none');
        $("#div-valorPeriodoPresentacionImputadoAnteUnidad-DG").addClass('d-none');
      }else{
        $("#div-fechaPresentacionImputado-DG").addClass('d-none');
        $("#periodoPresentacionImputado-DG").removeClass('d-none');
        $("#div-valorPeriodoPresentacionImputadoAnteUnidad-DG").removeClass('d-none');
      }
    });
  }

  function seleccionarCredenciales(tipo){
    $("#firmarDocumento").text('Firmar Oficio');
    $('#archivo_firmado').val('');
    $("#previewUploadDG").css('display', 'none');
    $("#objetoPreviewUploadDG").attr('src','');
    b64_doc_firmado = null;

    if(tipo=="firel_tsj" || tipo=="firel_csj"){
      $('#id_pfx').css("display", "block");
      $('#id_key').css("display", "none");
      $('#id_cert').css("display", "none");
      $('#id_autografa').css("display", "none");
      $('#id_contrasenia').css("display", "block");
      tipo_firma='firel_tsj';
    }
    else if(tipo=="fiel_tsj"){
      $('#id_pfx').css("display", "none");
      $('#id_key').css("display", "block");
      $('#id_cert').css("display", "block");
      $('#id_autografa').css("display", "none");
      $('#id_contrasenia').css("display", "block");
      tipo_firma='fiel_tsj';
    }
    else if(tipo=="firma_autografa"){
      $('#id_pfx').css("display", "none");
      $('#id_key').css("display", "none");
      $('#id_cert').css("display", "none");
      $('#id_autografa').css("display", "block");
      $('#id_contrasenia').css("display", "none");
      tipo_firma='firma_autografa';
      previewDG();
    }
    else{
      $('#id_pfx').css("display", "none");
      $('#id_key').css("display", "none");
      $('#id_cert').css("display", "none");
      $('#id_autografa').css("display", "none");
      $('#id_contrasenia').css("display", "none");
    }
  }

  function previewDG(){
    // $("#modalAdministracion").modal('hide');

    // setTimeout(function(){ loading(true); },600)
    //setTimeout(function(){ $("#modalAdministracion").modal('hide'); },300)
    //$("#modalAdministracion").modal('hide');
    let origen_contenido_oficio = $('input:radio[name=origenContenidoOficio-DG]:checked').val();
    let contenido_documento = null;

    if( origen_contenido_oficio == 'editor' ) contenido_documento= editor_html.html.get();
    else if( origen_contenido_oficio == 'archivo' ){
      if( !$("#oficioWord-DG").val() ){
        modal_error('Debe Adjuntar un Archivo de WORD','modalAdministracion');
        return false;
      }

      contenido_documento = $("#oficioWord-DG")[0].files[0];
    }

    var form = new FormData();
    form.append('carpeta', $("#id_carpeta_judicial").val());
    form.append('nombre_documento', $("#tipoPlantilla").find('option:selected').text() );
    form.append('origen_contenido_oficio',origen_contenido_oficio );
    form.append('contenido_documento',contenido_documento);

    $.ajax({
      method:'POST',
      url:'/public/obtener_archivo_firma_autografa',
      data:form,
      dataType: 'json',
      processData: false,
      contentType: false,
      success:function(response){
        //loading(false);
        //$("#modalAdministracion").modal('show');
        //setTimeout(function(){ $("#modalAdministracion").modal('show'); },1600)

        console.log('RESPUESTA GENERAR DOC :',response);
        if( !response.message){
          $("#objetoPreviewDownloadDG").attr('data',response.response);
          $("#previewDownloadDG").css('display','block');
         //setTimeout(function(){window.open(response.response, '_blank');},3000)
        }else{
          modal_error(response.message,'modalAdministracion');
        }
      } // success
    }); // ajax
    $("#firmarDocumento").text('Subir Archivo Firmado');
  }

  function previewDGFA(input){
    $("#objetoPreviewUploadDG").attr('src','');
    b64_doc_firmado = null;

    let file = $('#archivo_firmado').val();

    if(file.length){
      if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = e=> {
          $("#objetoPreviewUploadDG").attr('data',e.target.result);
          $("#previewUploadDG").css('display', 'block');
          b64_doc_firmado = e.target.result.split('base64,')[1];
        }
        reader.readAsDataURL(input.files[0]);
      }
    }
  }

  function cargaUsuarios(){
    $.ajax({
      method:'POST',
      url:'/public/obtener_usuarios_por_tipo',
      async:false,
      data:{
        id_unidad:carpetaActiva.id_unidad,
      },
      success:function(response){
        console.log(response);
        if(response.status==100){
          arrFirmantes=response.response;
        }else{
          //modal_error(response.message,'modalAdministracion');
        }
      }
    });
  }

  function obtenerAudenciasDGVP(){
    arrAuDG=[];
    $.ajax({
      method:'POST',
      url:'/public/obtener_audiencias_viejo_penal',
      async: false,
      data:{
        carpeta_judicial:carpetaActiva.id_carpeta_judicial,
      },
      success:function(response){
        console.log(response);
        if(response.status==100){
          arrAuDG = response.response;
        }else{
          //modal_error(response.message,'modalAdministracion');
        }
      }
    });
  }

  /******************
  *
  * SUB - FUNCIONES DE UTILIDAD EN FORMULARIO DG
  *
  *********************/

  function agregarItem(index_affected=null){
    let valid = true;

    $(".error").removeClass("error");

    if( !$("#itemID-DG").val() || $("#itemID-DG").val()=='-'){
      $("#select2-itemID-DG-container").addClass('error');
      modal_error('Debe seleccionar una opción','modalAdministracion');
      valid = false;
    }


    let exist = [];

    console.log( 'exist' , exist, 'id', $("#itemID-DG").val() );

    if( $("#tipoPlantilla").val() == '533' ){
      let exist_tipo = arrItems.filter( x=>x.tipo == $("#itemTipo-DG option:selected").val() );
      if( $("#itemTipo-DG option:selected").val() == 'medida_cautelar' )
        exist = exist_tipo.filter( x=>x.tipo == $("#itemIDMC-DG").val() );
      else
        exist = exist_tipo.filter( x=>x.tipo == $("#itemID-DG").val() );
    }
    else{
      exist = arrItems.filter( x=>x.id == $("#itemID-DG").val() );
    }
    console.log( 'exist' , exist, 'tipo', $("#itemTipo-DG option:selected").val() );

    if( exist.length ){
      $("#select2-itemID-DG-container").addClass('error');
      modal_error('El articulo seleccionado ya se encuentra agregado. <br> Seleccione otra opción','modalAdministracion');
      valid = false;
    }

    if( !$("#duracion-DG").val() || !($("#duracion-DG").val()).length ){
      $("#duracion-DG").addClass('error');
      modal_error('Debe ingresar el tiempo de duración','modalAdministracion');
      valid = false;
    }

    if( valid ){

      if( index_affected==null){
        arrItems.push({
          id: $("#tipoPlantilla").val() != '533' ? $("#itemID-DG").val() : ( $("#itemTipo-DG option:selected").val() == 'medida_cautelar' ?  $("#itemIDMC-DG").val() : $("#itemID-DG").val() ) ,
          descripcion: $("#tipoPlantilla").val() != '533' ? $("#itemID-DG option:selected").text() : ( $("#itemTipo-DG option:selected").val() == 'medida_cautelar' ?  $("#itemIDMC-DG option:selected").text() : $("#itemID-DG option:selected").text() ) ,
          //detalle_adicional: $("#detallesAdcionales-DG").val(),
          duracion: $("#duracion-DG").val(),
          tipo: $("#tipoPlantilla").val() != '533' ? null : $("#itemTipo-DG").val() ,
        });
      }else{
        arrItems[ index_affected ].id = $("#tipoPlantilla").val() != '533' ? $("#itemID-DG").val() : ( $("#itemTipo-DG").val() == 'medida_cautelar' ?  $("#itemIDMC-DG").val() : $("#itemID-DG").val() ) ;
        arrItems[ index_affected ].descripcion = $("#tipoPlantilla").val() != '533' ? $("#itemID-DG option:selected").text() : ( $("#itemTipo-DG").val() == 'medida_cautelar' ?  $("#itemIDMC-DG option:selected").text() : $("#itemID-DG option:selected").text() );
        // arrItems[ index_affected ].detalle_adicional = $("#detallesAdcionales-DG").val();
        arrItems[ index_affected ].duracion = $("#duracion-DG").val();
        arrItems[ index_affected ].tipo = $("#tipoPlantilla").val() == '533' ?  $("#itemTipo-DG").val() : null;
      }

    }

    pintarItems();
    //$("#itemID-DG").val('1').trigger('change');
    $("#detallesAdcionales-DG").val('');
    $("#duracion-DG").val('');
    $("#agregarItem-DG").attr('onclick','agregarItem()');
    //$("#agregarItem-DG").text('Agregar');
  }

  function pintarItems(){
    $("#tablaItems-DG tbody tr").remove();

    if(arrItems.length==0) $("#tablaItems-DG tbody").append(` <tr> <td colspan="3"> Sin condiciones agregadas </td> </tr> `);

    $(arrItems).each(function(index,item){
      $("#tablaItems-DG tbody").append(`
        <tr>
          <td> <i class="fa fa-trash" onclick="borrarItem(${index})"></i> <i class="fa fa-edit" onclick="editarItem(${index})"></i> </td>
          ${ item.tipo != null && $("#tipoPlantilla").val() == '533' ? '<td>'+item.tipo.replaceAll('_',' ')+'</td>' : ''}
          <td> ${ item.descripcion} </td>
          <td> ${ item.duracion} </td>
        </tr>
      `);
    });

  }

  function editarItem(index_affected){
    if( $("#tipoPlantilla").val() == '533' ){
      $("#itemTipo-DG").val( arrItems[ index_affected ].tipo ).trigger('change');
      if( arrItems[ index_affected ].tipo == 'medida_cautelar' )
        $("#itemIDMC-DG").val( arrItems[ index_affected ].id ).trigger('change');
      else
        $("#itemID-DG").val( arrItems[ index_affected ].id ).trigger('change');
    }else
      $("#itemID-DG").val( arrItems[ index_affected ].id ).trigger('change');

    // $("#detallesAdcionales-DG").val( arrItems[ index_affected ].detalle_adicional ),
    $("#duracion-DG").val( arrItems[ index_affected ].duracion ),
    $("#agregarItem-DG").attr('onclick',`agregarItem(${index_affected})`);
    $("#agregarItem-DG").text('Aplicar cambios');
  }

  function borrarItem(index_affected){
    let arrayCleared = [];
    $(arrItems).each(function(index_i,item){
      if( index_affected != index_i ) arrayCleared.push(item);
    });
    arrItems=arrayCleared;
    pintarItems();
  }

  // para agregar y quitar anexos
  function agregar_anexo(input){
    let acepted_files=["pdf"];

    if( ($(".anexos-adjuntados-DG")).length >= 3 ){
      modal_error('Sólo puedes adjuntar tres anexos','modalAdministracion');
      return false;
    }

    if(input){
      let file = input.value;
      let extension = input.value.split('.')[1];
      let nombre_documento = input.value.split('\\')[2].split('.')[0];
      nombre_documento = nombre_documento.replaceAll(' ', '_');

      if( !acepted_files.includes(extension) ){
        modal_error('Solo puede adjutar archivos PDF','modalAdministracion');
        return false
      }else{
        if (input.files && input.files[0]) {

          if( input.files[0].size > 5242880){
            modal_error('El archivo rebasa los 5 MB permitidos; Anexe un archivo mas ligero','modalAdministracion');
            return false;
          }

          let reader = new FileReader();
          reader.onload = e=> {

            $("#listaAnexos-DG").append(`
              <li class="list-group-item">
                <p class="mg-b-0">
                  <i class="fa fa-close fa-2x tx-danger mg-r-8" onclick="quitar_anexo(this)"></i>  &nbsp; &nbsp; &nbsp;
                  <a href="#" class="anexos-adjuntados-DG" onclick="previewAnexoDG(this)" data-nombre="${nombre_documento}" data-tamanio="${input.files[0].size}" data-extension="${extension}" data="${e.target.result}" data-toggle="tooltip-primary" data-placement="top" title="Ver vista previa">
                    <i class="fas fa-file-pdf fa-2x tx-primary mg-r-8"></i>  &nbsp;
                    <strong class="tx-inverse tx-medium"> ${nombre_documento}.${extension} </strong> <small class="text-muted">( ${Number.parseFloat( input.files[0].size/1048576 ).toFixed(2)} MB) </small></strong> &nbsp;
                  </a>
                </p>
              </li>
            `);
          }
          reader.readAsDataURL(input.files[0]);
        }
      }
      setTimeout(function(){
        console.log('Limpiando...')
        $(input).val(""); // limpiamos input
        input.files = null; // limpiando files
        console.log( $("#"+input.id).val(), input.files )
        return false;
      }, 500);
    }else{
      return false;
    }
  }

  function quitar_anexo( tag ){
    //console.log( tag, $(tag).parent());
    $( tag ).parent().parent().remove();

  }

  function previewAnexoDG( tag ){
    $('#divPreviewDG').empty();
    $('#divPreviewDG').append(`
      <div class="col-12" align="center">
        <object height="300px" width="100%" class="mg-t-25" data="${ $( tag ).attr('data') }"></object>
      </div>
    `);
  }

</script>
