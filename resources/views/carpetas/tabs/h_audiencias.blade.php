{{-- AUDIENCIAS--}}

<div class="form-layout">
  <div class="row mg-b-25">
    <br>
    {{--SECCION EDICION DE AUDIENCIAS--}}
    <div class="col-lg-12">
      <div id="accordionAudienciasEditar" class="accordion-one mg-b-10" role="tablist" aria-multiselectable="true" width="100%" style="display:block">
        <div class="card">
          <div class="card-header" role="tab" id="headingOne">
            <a id="titleAccordionAudienciasEditar" data-toggle="collapse" data-parent="#accordionAudienciasEditar" href="#collapseOneAudienciasEditar" aria-expanded="true" aria-controls="collapseOneAudienciasEditar" class="bkg-collapsed-btn-edit tx-gray-800 transition collapsed tx-white">
              Modificación de Audiencia
            </a>
          </div><!-- card-header -->
          <div id="collapseOneAudienciasEditar" class="collapse" role="tabpanel" aria-labelledby="headingOneAudienciasEditar">
            <div class="card-body">
              <div id="espacioEditarAudiencia" class="mg-t-15">

              </div>
            </div> <!-- CARD BODY -->
          </div> <!-- BODY COLLAPSE -->
        </div> <!-- CARD -->
      </div> <!-- ACCORDEON EDCIIOND E AUDIENCIAS -->
    </div>
    <br>
    {{-- SECCION TABLA AUDIENCIAS --}}
    <div class="col-lg-12">
      <br>
      <h5 class="form-control-label">Audiencias</h5>
      <hr/>
      <div class="row" id="divAudiencias">
        <div class="col-lg-12">
          <div class="pagination-wrapper justify-content-between">
            <ul class="pagination mg-b-0">
              <li class="page-item">
                <a class="page-link primera-A" href="javascript:void(0)" aria-label="Last" onclick="pintarAudiencias(1)">
                  <i class="fa fa-angle-double-left"></i>
                </a>
              </li>
              <li class="page-item">
                <a class="page-link anterior-A" href="javascript:void(0)" aria-label="Next" onclick="pintarAudiencias(1)">
                  <i class="fa fa-angle-left"></i>
                </a>
              </li>
            </ul>

            <ul class="pagination mg-b-0">
              <li class="page-item">Página <span class="pagina-A">1</span> de <span class="total-paginas-A">1</span></li>
            </ul>

            <ul class="pagination mg-b-0">
              <li class="page-item">
                <a class="page-link siguiente-A" href="javascript:void(0)" aria-label="Next" onclick="pintarAudiencias(1)">
                  <i class="fa fa-angle-right"></i>
                </a>
              </li>
              <li class="page-item">
                <a class="page-link ultima-A" href="javascript:void(0)" aria-label="Last" onclick="pintarAudiencias(1)">
                  <i class="fa fa-angle-double-right"></i>
                </a>
              </li>
            </ul>
          </div>
          <table id="tableAudiencias" class="display dataTable dtr-inline collapsed">
            <thead style="background-color: #EBEEF1; color: #000;">
              <tr>
                <th>#</th>
                <th style="min-width:60px;">Acciones</th>
                <th> </th>
                <th>Situación</th>
                <th>Fecha Audiencia</th>
                <th>Hora <br> Programada</th>
                <th>Horario Realizacion</th>
                <th>Tipo Audiencia</th>
                <th>Edificio</th>
                <th>Sala</th>
                <th>Recursos</th>
                <th>Juez</th>
                <th>Total imputados</th>
                <th>Imputados</th>
                <th>Delitos</th>
                <th>Carpeta de Investigacion</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
          <div class="pagination-wrapper justify-content-between">
            <ul class="pagination mg-b-0">
              <li class="page-item">
                <a class="page-link primera-A" href="javascript:void(0)" aria-label="Last" onclick="pintarAudiencias(1)">
                  <i class="fa fa-angle-double-left"></i>
                </a>
              </li>
              <li class="page-item">
                <a class="page-link anterior-A" href="javascript:void(0)" aria-label="Next" onclick="pintarAudiencias(1)">
                  <i class="fa fa-angle-left"></i>
                </a>
              </li>
            </ul>

            <ul class="pagination mg-b-0">
              <li class="page-item">Página <span class="pagina-A">1</span> de <span class="total-paginas-A">1</span></li>
            </ul>

            <ul class="pagination mg-b-0">
              <li class="page-item">
                <a class="page-link siguiente-A" href="javascript:void(0)" aria-label="Next" onclick="pintarAudiencias(1)">
                  <i class="fa fa-angle-right"></i>
                </a>
              </li>
              <li class="page-item">
                <a class="page-link ultima-A" href="javascript:void(0)" aria-label="Last" onclick="pintarAudiencias(1)">
                  <i class="fa fa-angle-double-right"></i>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <br>
    </div><!-- col-lg-12-->
    <hr/>

  </div><!-- row -->

  {{-- BOTONES--}}
  <div class="form-layout-footer d-flex">
  </div><!-- form-layout-footer -->
</div>



{{-- ESTILOS Y SCRITPS --}}

<style type="text/css" >

  .dhx_cal_event div.dhx_footer,
  .dhx_cal_event.past_event div.dhx_footer,
  .dhx_cal_event.event_english div.dhx_footer,
  .dhx_cal_event.event_math div.dhx_footer,
  .dhx_cal_event.event_science div.dhx_footer{
    background-color: transparent !important;
  }
  .dhx_cal_event .dhx_body{
    -webkit-transition: opacity 0.1s;
    transition: opacity 0.1s;
    opacity: 0.7;
  }
  .dhx_cal_event .dhx_title{
    line-height: 12px;
  }
  .dhx_cal_event_line:hover,
  .dhx_cal_event:hover .dhx_body,
  .dhx_cal_event.selected .dhx_body,
  .dhx_cal_event.dhx_cal_select_menu .dhx_body{
    opacity: 1;
  }

  .dhx_cal_event.event_1 div,
  .dhx_cal_event_line.event_1{
    background-color: #6989b0 !important;
    border-color: #6989b0 !important;
  }

  .dhx_cal_event.dhx_cal_editor.event_1{
    background-color: #6989b0 !important;
  }

  .dhx_cal_event_clear.event_1{
    color:#6989b0 !important;
  }

  .dhx_cal_event.event_2 div,
  .dhx_cal_event_line.event_2{
    background-color: #01377a !important;
    border-color: #01377a !important;
  }

  .dhx_cal_event.dhx_cal_editor.event_2{
    background-color: #01377a !important;
  }

  .dhx_cal_event_clear.event_2{
    color:#01377a !important;
  }

  .dhx_cal_event.event_3 div,
  .dhx_cal_event_line.event_3{
    background-color: #3e5169 !important;
    border-color: #3e5169 !important;
  }

  .dhx_cal_event.dhx_cal_editor.event_3{
    background-color: #3e5169 !important;
  }

  .dhx_cal_event_clear.event_3{
    color:#B82594 !important;
  }

  .event_danger div, .dhx_cal_editor.event_danger, .dhx_cal_event_line.event_danger {
    background-color: #c93d11 !important;
  }

  .event_primary div, .dhx_cal_editor.event_primary, .dhx_cal_event_line.event_primary {
    background-color: #848f33cf !important;
  }

  .event_bkg_danger{
    background-color: #c93d11 !important;
  }

  .event_bkg_primary{
    background-color: #848f33cf !important;
  }


  .dhx_cal_event_line {
    height: auto !important;
  }

  #divAudiencias{
    overflow: auto !important;
  }

  #tableAudiencias{
    font-size:11px;
  }

  .tx-bold{
    font-weight:bold;
  }

  .tx-registrada{
    color: #ffb300 !important;
  }

  .tx-confirmada{
    color: #23BF08 !important;
  }

  .tx-finalizada{
    color: #2075d5 !important;
  }

  .tx-cancelada{
    color: #212529 !important;
  }

  .bkg-white{
    background-color: #fff !important;
  }

  .bkg-tras{
    background-color: rgb(0 0 0 / 0%) !important;
  }
  th.acciones1{
    width: 100px;
  }
  .acciones2{
    background: #848F33;
    color: #fff;
    padding: 4px;
    border-radius: 4px;
  }
  @media(max-width: 900px){
    .title-pane{
      font-size: 1.2em !important;
    }
  }
  .custom-input-file {
    cursor: pointer;
    font-size: 25px;
    font-weight: bold;
    margin: 0 auto 0;
    min-height: 15px;
    overflow: hidden;
    padding: 10px;
    position: relative;
    text-align: center;
    width: 500px;
    color: #848F33;
    border: 2px solid #EEE;
    border-style: dotted;
    height: 80px;
    border-radius: 25px;
    width: 80%;
  }
  .custom-input-file .input-file {
    border: 10000px solid transparent;
    cursor: pointer;
    font-size: 10000px;
    margin: 0;
    opacity: 0;
    outline: 0 none;
    padding: 0;
    position: absolute;
    right: -1000px;
    top: -1000px;
  }
</style>

<script>
  var arrA=[];
  var arrAllA=[];
  var scheulder=null;

  var jueces = [];
  const tipos_audiencia = @php echo json_encode($tipos_audiencia);@endphp;
  const inmuebles = @php echo json_encode($inmuebles);@endphp;
  const recursos_audiencia = @php echo json_encode($recursos_audiencia);@endphp;

  var arrRAA = [];

  var newDA=null;

  //variables de contador
  var count_days = 0;
  var count_months = 0;
  var count_years = 0;

  const permiso_cancelacion = parseInt("{{ $request->session()->get('id_tipo_usuario') }}")


  function pintarAudiencias(pagina=1){
    $("#tableAudiencias tbody tr").remove();
    $.ajax({
      method:'POST',
      url:'/public/consulta_audiencias',
      data:{
        carpeta : $("#id_carpeta_judicial").val(),
        id_solicitud : $("#id_solicitud").val(),
        tipo_solicitud : $("#tipo_solicitud").val(),
      },
      success:function(response){
        arrA=[];
        console.log(response);

        if(response.status ==100){
          arrA=response.response;
          //return arrA;return false;

          var listaImputados = ``;
          $(carpetaActiva.imputados).each(function(index_i,i){
            listaImputados = listaImputados.concat(`
              ${i.tipo=='fisica'?(i.nombre?i.nombre:''):(i.razon_social?i.razon_social:'')}<br>
            `);
          });

          var listaDelitos = ``;
          $(carpetaActiva.delitos).each(function(index_d,d){
            listaDelitos = listaDelitos.concat(`
              ${d.delito?d.delito:''}<br>
            `);
          });

          $(response.response).each(function(index, a){

            let strVerInfoA='';
            let strVerVideoA='';
            //let strBorrarA = ``;
            let strEditarA = ``;
            let strHistorialA=``;
            let strCancelarA=``;
            //let strSemaforoA=``;
            if(true){ // aquí se controla el permiso de edición
              strVerInfoA = `<i class="fas fa-info" data-toggle="tooltip-primary" data-placement="top" title="Ver informacion Audiencia" onclick="verInfoAudiencia(${index})"></i>`;
              //strRelacionarDSR = `<button class="btn btn-primary d-inline-block mg-l-10" onclick="relacionarDelitoSinRelacionar(${index})">Imputar delitos</button>`;
              //strBorrarDSR = `<button class="btn btn-danger d-inline-block mg-l-10" onclick="borrarDelitoSinRelacionar(${index})">Borrar</button>`;
              //strEditarDSR = `<button class="btn btn-info d-inline-block mg-l-10" onclick="editarDelitoSinRelacionar(${index})">Editar</button>`;
              //strHistorialDSR = `<button class="btn btn-secondary d-inline-block mg-l-10" onclick="mostrarHistorialDelitoSinRelacionar(${index})">Historial</button>`;
            }

            var listaRecursos =``;
            for( var i in a.recursos ){
              listaRecursos = listaRecursos + `
                ${ a.recursos[i].nombre_recurso }<br>
              `;
            }


            strEditarA = `<i class="fas fa-edit" data-toggle="tooltip-primary" data-placement="top" title="Editar Audiencia" onclick="editarAudiencia(${index})"></i>`

            let horario_real = ( a.hora_inicio_audiencia_real?'De '+a.hora_inicio_audiencia_real.substring(0,5):'' )+( a.hora_fin_audiencia_real?'<br> a '+a.hora_fin_audiencia_real.substring(0,5):'');
            horario_real = horario_real.length?horario_real:'<span class="tx-italic">Sin registro</span>';

            $('#tableAudiencias tbody').append(`
              <tr>
                <td>${index+1}</td>
                <td>${strEditarA} ${strVerInfoA}</td>
                <td> <i class="fas fa-circle tx-${a.estatus_semaforo} d-inline-block mg-l-10 bkg-tras" data-toggle="tooltip-primary" data-placement="top" title="Audiencia ${a.estatus_semaforo}" ></i> </td>
                <td>${a.estatus_audiencia}</td>
                <td>${a.fecha_audiencia}</td>
                <td> De ${a.hora_inicio_audiencia.substring(0,5)}<br> a ${a.hora_fin_audiencia.substring(0,5)} </td>
                <td>${horario_real}</td>
                <td>${a.tipo_audiencia}</td>
                <td>${a.nombre_corto}</td>
                <td>${a.nombre_sala}</td>
                <td class="involucrados d-block" > <span>${listaRecursos}</span></td>
                <td>${a.juez.nombre_usuario}</td>
                <td>${carpetaActiva.imputados.length}</td>
                <td class="involucrados d-block" > <span>${listaImputados}</span></td>
                <td class="delitos">${listaDelitos}</td>
                <td>${carpetaActiva.carpeta_investigacion}</td>
              </tr>
            `);

            // setTimeout(function(){ $('#collapseLineaTiempoAudiencias').collapse('show'); },200);
          });

          let anterior=pagina==1?1:pagina-1;
          let totalPaginas=response.response_paginacion.paginas_totales;
          let siguiente=pagina+1>=totalPaginas?totalPaginas:pagina+1;

          $('.anterior-A').attr('onclick',`pintarAudiencias(${anterior})`);
          $('.pagina-A').html(pagina);
          $('.total-paginas-A').html(totalPaginas);
          $('.siguiente-A').attr('onclick',`pintarAudiencias(${siguiente})`);
          $('.ultima-A').attr('onclick',`pintarAudiencias(${totalPaginas})`);

        }  // if status==100
        else{
          $('#tableAudiencias tbody').append(`
            <tr>
              <td colspan="8">
                <span class="tx-italic">No hay audiencias</span>
              </td>
            </tr>
          `);
          $('.anterior-A').attr('onclick',`pintarAudiencias(1)`);
          $('.pagina-A').html('1');
          $('.total-paginas-A').html('1');
          $('.siguiente-A').attr('onclick',`pintarAudiencias(1)`);
          $('.ultima-A').attr('onclick',`pintarAudiencias(1)`);

          if( response.message!="ERROR - sin datos asociados") modal_error(response.message,'modalAdministracion');
        }
      } // success
    }); // ajax
  }

  function verInfoAudiencia( indexA ){

    let a = arrA[ indexA ];
    let title=`Información de Audiencia`;

    console.log(a);
    
    let carpeta_judicial_F = a.folio_carpeta; 

    let horario_real = ( a.hora_inicio_audiencia_real?'De las '+a.hora_inicio_audiencia_real.substring(0,5)+' hrs.':'' )+( a.hora_fin_audiencia_real?' a las '+a.hora_fin_audiencia_real.substring(0,5)+' hrs.':'');
    horario_real = horario_real.length?horario_real+' del '+a.fecha_audiencia:'<span class="tx-italic">Sin registro</span>';

    let tr_recursos = ``;
    if( (a.recursos).length > 0){
      for( var i in a.recursos ){
        tr_recursos = tr_recursos + `
          </tr>
            <td>${ parseInt( i ) + 1}</td>
            <td>${ a.recursos[i].nombre_recurso }</td>
            <td>Del ${ a.recursos[i].fecha_requerido_inicio} a las ${a.recursos[i].horario_requerido_inicio.substring(0,5)} hrs. <br>hasta el ${a.recursos[i].fecha_requerido_fin} a las ${a.recursos[i].horario_requerido_fin.substring(0,5)} hrs.</td>
            <td>${ a.recursos[i].descripcion != null ?  a.recursos[i].descripcion : ''}</td>
            <td>${ a.recursos[i].comentarios_recurso != null ? a.recursos[i].comentarios_recurso : '' }</td>
          </tr>
        `;
      }
    }else{
      tr_recursos = `
        <tr>
          <td colspan="5" class="tx-center tx-bold">Sin Recursos Adicionales </td>
        </tr>
      `;
    }

    // let strConfirmarA = ``;
    // let strFinalizarA = ``;
    // let strCancelarA = ``;

    let strEstatusA = `<div class="p-3"><i class="fas fa-circle tx-${a.estatus_semaforo} d-inline-block mg-l-10 bkg-tras"></i> ${a.estatus_semaforo}</div>`;

    //@if($request->session()->get('id_tipo_usuario') == 1 || $request->session()->get('id_tipo_usuario') == 20 )
      /*if( a.estatus_semaforo == 'registrada' ) strConfirmarA = `<div class="p-3"> <button type="button" class="btn btn-outline-success btn-block mg-b-10" onclick="estatusAudiencia(${indexA},'confirmada')"><i class="fas fa-circle mg-r-5"></i> Confrimar </button> </div>`;
      /*if( a.estatus_semaforo == 'confirmada' ) strFinalizarA = `<div class="p-3"> <button type="button" class="btn btn-outline-info btn-block mg-b-10" onclick="estatusAudiencia(${indexA},'finalizada')"><i class="fas fa-circle mg-r-5"></i> Finalizar </button> </div>`;
      /*if( a.estatus_semaforo == 'confirmada' ) strCancelarA = `<div class="p-3"> <button type="button" class="btn btn-outline-dark btn-block mg-b-10" onclick="estatusAudiencia(${indexA},'cancelada')"><i class="fas fa-circle mg-r-5"></i> Cancelar </button> </div>`;
    //@endif */

    // strEstatusA = `
    //   <div class="p-1">
    //     <select id="selectEstatusAudiencia" class="form-control select2" data-placeholder="" style="width:100%;" onchange="estatusAudiencia( ${indexA}, this.value )">
    //       <option value="confirmada" ${a.estatus_semaforo=='confirmada' ? 'selected' : ''} > <i class="fas fa-circle tx-confirmada d-inline-block mg-l-10 bkg-tras"></i> Confirmada </option>
    //       <option value="finalizada" ${a.estatus_semaforo=='finalizada' ? 'selected' : ''} > <i class="fas fa-circle tx-finalizada d-inline-block mg-l-10 bkg-tras"></i> Finalizada  </option>
    //       <option value="cancelada" ${a.estatus_semaforo=='cancelada' ? 'selected' : ''} > <i class="fas fa-circle tx-cancelada d-inline-block mg-l-10 bkg-tras"></i> Cancelada </option>
    //     </select>
    //   </div>
    // `;

    //@if($request->session()->get('id_tipo_usuario') == 1 || $request->session()->get('id_tipo_usuario') == 20 )

      strEstatusA = `
        <div class="dropdown">
          <a href="#" class="btn btn-outline-${a.estatus_semaforo=='confirmada' ? 'success' : ( a.estatus_semaforo == 'finalizada' ? 'info' : 'dark' )}" id="dropdown-menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-circle  mg-l-5 bkg-tras"></i>
            <span> ${a.estatus_semaforo} </span>
            <i class="fa fa-angle-down mg-l-5 bkg-tras"></i>
          </a>
          <div class="dropdown-menu dropdown-media-list wd-200">
            <div class="dropdown-menu-header">
              <label>Seleccione una opción</label>
            </div><!-- d-flex -->
            <div class="media-list">

              <a href="#" class="media ${a.estatus_semaforo == 'confirmada' ? 'd-none' : ''}" onclick="estatusAudiencia(${indexA},'confirmada')">
                <div class="media-body">
                  <div>
                    <p> <i class="fa fa-circle tx-confirmada mg-l-5 bkg-tras"></i> Confirmada</p>
                  </div>
                </div>
              </a>

              <a href="#" class="media ${a.estatus_semaforo == 'finalizada' ? 'd-none' : ''}" onclick="estatusAudiencia(${indexA},'finalizada')">
                <div class="media-body">
                  <div>
                    <p> <i class="fa fa-circle tx-finalizada mg-l-5 bkg-tras"></i> Finalizada</p>
                  </div>
                </div>
              </a>

              <a href="#" class="media ${a.estatus_semaforo == 'cancelada' ? 'd-none' : ''}" onclick="estatusAudiencia(${indexA},'cancelada')">
                <div class="media-body">
                  <div>
                    <p> <i class="fa fa-circle tx-cancelada mg-l-5 bkg-tras"></i> Cancelada</p>
                  </div>
                </div>
              </a>

            </div><!-- media-list -->
          </div><!-- dropdown-menu -->
        </div>
      `;
    //@endif

    let body=`
      <div class="row" style="display:block; margin-right:0px; margin-left:0px;">
        
        {{-- //Tabs de la informacion de audiencia  --}}
        <nav>
          <div class="nav nav-tabs" id="nav-tab-info-audiencia" role="tablist">
            <a class="nav-item nav-link active" id="nav-datos_audiencia-tab"        			    data-toggle="tab" href="#nav-datos_audiencia"         			  role="tab" aria-controls="nav-datos_audiencia"        			    aria-selected="true">Datos de la audiencia</a> 
            <a class="nav-item nav-link"        id="nav-mandamientos_judiciales-tab"        	data-toggle="tab" href="#nav-mandamientos_judiciales"         role="tab" aria-controls="nav-mandamientos_judiciales"        	aria-selected="true">Mandamientos judiciales</a> 
            <a class="nav-item nav-link"        id="nav-acciones_resolutivos-tab"   			    data-toggle="tab" href="#nav-acciones_resolutivos"            role="tab" aria-controls="nav-acciones_resolutivos"             aria-selected="false">Acciones/resolutivos</a> 
            <a class="nav-item nav-link"        id="nav-acuerdos_reparatorios-tab"      		  data-toggle="tab" href="#nav-acuerdos_reparatorios"       		role="tab" aria-controls="nav-acuerdos_reparatorios"      		  aria-selected="false">Acuerdos reparatorios</a> 
            <a class="nav-item nav-link"        id="nav-medidas_cautelares-tab" 				      data-toggle="tab" href="#nav-medidas_cautelares"  				    role="tab" aria-controls="nav-medidas_cautelares" 				      aria-selected="false">Medidas cautelares</a> 
            <a class="nav-item nav-link"        id="nav-medidas_proteccion-tab"   			      data-toggle="tab" href="#nav-medidas_proteccion"    			    role="tab" aria-controls="nav-medidas_proteccion"   			      aria-selected="false">Medidas de protección</a> 
            <a class="nav-item nav-link"        id="nav-condiciones_suspension_proceso-tab"   data-toggle="tab" href="#nav-condiciones_suspension_proceso"  role="tab" aria-controls="nav-condiciones_suspension_proceso"   aria-selected="false">Condiciones de suspensión de proceso </a> 
          </div>
        </nav> 

        <div class="tab-content" id="nav-tabContent-info-audiencia">
        
          <div class="tab-pane fade show active" id="nav-datos_audiencia" role="tabpanel" aria-labelledby="nav-datos_audiencia-tab">
            @include('carpetas.tabs.sub-tabs-info-audiencia.datos_audiencia')
          </div><!-- tab-datos_audiencia -->

          <div class="tab-pane fade show" id="nav-mandamientos_judiciales" role="tabpanel" aria-labelledby="nav-mandamientos_judiciales-tab">
            @include('carpetas.tabs.sub-tabs-info-audiencia.mandamientos_judiciales')
          </div><!-- tab-mandamientos_judiciales -->

          <div class="tab-pane fade" id="nav-acciones_resolutivos" role="tabpanel" aria-labelledby="nav-acciones_resolutivos-tab">
            @include('carpetas.tabs.sub-tabs-info-audiencia.acciones_resolutivos')
          </div><!-- tab-acciones_resolutivos -->

          <div class="tab-pane fade" id="nav-acuerdos_reparatorios" role="tabpanel" aria-labelledby="nav-acuerdos_reparatorios-tab">
            @include('carpetas.tabs.sub-tabs-info-audiencia.acuerdos_reparatorios')
          </div><!-- tab-acuerdos_reparatorios -->

          <div class="tab-pane fade" id="nav-medidas_cautelares" role="tabpanel" aria-labelledby="nav-medidas_cautelares-tab">
            @include('carpetas.tabs.sub-tabs-info-audiencia.medidas_cautelares')
          </div><!-- tab-medidas_cautelares -->

          <div class="tab-pane fade" id="nav-medidas_proteccion" role="tabpanel" aria-labelledby="nav-medidas_proteccion-tab">
            @include('carpetas.tabs.sub-tabs-info-audiencia.medidas_proteccion')
          </div><!-- tab-medidas_proteccion -->
          
          <div class="tab-pane fade" id="nav-condiciones_suspension_proceso" role="tabpanel" aria-labelledby="nav-condiciones_suspension_proceso-tab">
            @include('carpetas.tabs.sub-tabs-info-audiencia.condiciones_suspension_proceso') 
          </div><!-- tab-condiciones_suspension_proceso -->

        </div> 



      </div>
    `;
    modal_historial(title,body,'modalAdministracion');

    setTimeout( function(){ 
        //acciones resolutivos
        $("#selectEstatusAudiencia").select2(); 
        $('#cmp_resolutivo').select2();
        $('#cmp_fecha_base').datepicker({dateFormat: 'yy-mm-dd',firstDay: 1}).datepicker("setDate", new Date());
        $('#cmp_fecha_resultado').datepicker({dateFormat: 'yy-mm-dd'});
        $('#cmp_fecha_base_E').datepicker({dateFormat: 'yy-mm-dd',firstDay: 1}).datepicker("setDate", new Date());
        $('#cmp_fecha_resultado_E').datepicker({dateFormat: 'yy-mm-dd'});
        $('#cmp_fecha').datepicker({dateFormat: 'yy-mm-dd',firstDay: 1}).datepicker("setDate", new Date());
        $('#cmp_fecha_E').datepicker({dateFormat: 'yy-mm-dd',firstDay: 1}).datepicker("setDate", new Date());
        //mandamientos
        $('#cmp_libramiento').datepicker({dateFormat:'yy-mm-dd',firstDay: 1}).datepicker("setDate", new Date());
        $('#cmp_libramiento_E').datepicker({dateFormat:'yy-mm-dd',firstDay: 1}).datepicker("setDate", new Date());

        //acuerdos Reparatorios
        $('#cmp_fehcaExtincion_AR_E').datepicker({dateFormat: 'yy-mm-dd'});
        $('#cmp_fehcaExtincion_AR').datepicker({dateFormat: 'yy-mm-dd'});
        $('#cmp_imputado_AR_E').select2({placeholder: 'Selecciona Imputado'});
        $('#cmp_imputado_AR').select2({placeholder: 'Selecciona imputado'});

        //medidas Cautelares

        //medias Proteccion

        //funciones
        obtener_resolutivos('cmp_resolutivo');
        obtener_MedidasCautelares('cmp_medidaC_medida');
        obtener_resolutivos('cmp_resolutivo_E');
        obtener_MedidasCautelares('cmp_medidaC_medida_E');
        obtener_MedidasProteccion('cmp_medidaP_medida');
        obtener_MedidasProteccion('cmp_medidaP_medida_E');
        obtener_CondicionesSuspension('cmp_condicionS_medida');
        obtener_CondicionesSuspension('cmp_condicionS_medida_E');


        obtener_audiencias_resolutivos(carpeta_judicial_F,'primera');
        obtener_mandamientos(carpeta_judicial_F,'primera');
        obtener_MedidaC(carpeta_judicial_F,'primera');
        obtener_MedidaP(carpeta_judicial_F,'primera');
        obtener_CondicionS(carpeta_judicial_F,'primera');
        obtener_AcuerdosR(carpeta_judicial_F,'primera');
      }, 1000);
  }

  async function editarAudiencia( indexA ){
    let audiencia = arrA[ indexA ];

    $("#collapseOneAudienciasEditar").collapse('show');

    let strOptionTA = ``;
    for( var i in tipos_audiencia ){
      strOptionTA = strOptionTA + `
        <option value="${tipos_audiencia[i].id_ta}" ${tipos_audiencia[i].id_ta== audiencia.id_tipo_audiencia ? 'selected' : '' }> ${tipos_audiencia[i].tipo_audiencia} </option>
      `;
    }

    let strOptionJ = `<option value="${audiencia.id_juez}" selected}> ${audiencia.juez.nombre_usuario} </option>`;
    // jueces = await obtener_jueces_ejecucion();
    // if( jueces.status ==100){
    //   for( var i  in jueces = jueces.response ){
    //     strOptionJ = strOptionJ + `
    //       <option value="${jueces[i].id_usuario}"> ${jueces[i].nombre_juez} </option>
    //     `;
    //   }
    // }

    let strOptionI = ``;
    for( var i  in inmuebles ){
      strOptionI = strOptionI + `<option value="${inmuebles[i].id_inmueble}" ${inmuebles[i].id_inmueble==audiencia.id_inmueble ? 'selected' : ''}> ${inmuebles[i].nombre_inmueble}</option>`;
    }

    let strOptionS = ``;
    let salas = await obtener_salas( audiencia.id_inmueble );
    strOptionS = strOptionS + `<option value="${audiencia.id_sala}" selected> ${audiencia.nombre_sala}</option>`;
    console.log('sala',salas);
    if( salas.status == 100 ){
      for( var i in salas = salas.response){
        if( salas[i].id_sala == audiencia.id_sala ) continue;
        else strOptionS = strOptionS + `<option value="${salas[i].id_sala}" ${salas[i].id_sala==audiencia.id_sala ? 'selected' : ''}> ${salas[i].nombre_sala}</option>`;
      }
    }

    let strOptionR = ``;
    for( var i in recursos_audiencia ){
      strOptionR = strOptionR + `<option value="${recursos_audiencia[i].id_tipo_recurso}">${recursos_audiencia[i].tipo_recurso}</option>`;
    }

    arrRAA = audiencia.recursos;

    let trRecursos = ``;
    if( (arrRAA).length > 0){
      for( var i in arrRAA ){
        let btnEdit = `<i class="fas fa-edit" data-toggle="tooltip-primary" data-placement="top" title="Editar Recurso" onclick="editarRecurso(${index})"></i>`;
        let btnDelete = `<i class="fas fa-trash" data-toggle="tooltip-primary" data-placement="top" title="Quitar Recurso" onclick="quitarRecurso(${index})"></i>`;

        trRecursos = trRecursos + `
          </tr>
            <td>${ parseInt( i ) + 1}</td>
            <td>  ${ btnDelete } ${  btnEdit } </td>
            <td>${ arrRAA[i].nombre_recurso }</td>
            <td>Del ${ arrRAA[i].fecha_requerido_inicio} a las ${arrRAA[i].horario_requerido_inicio.substring(0,5)} hrs. <br>hasta el ${arrRAA[i].fecha_requerido_fin} a las ${arrRAA[i].horario_requerido_fin.substring(0,5)} hrs.</td>
            <td>${ arrRAA[i].descripcion != null ?  arrRAA[i].descripcion : ''}</td>
            <td>${ arrRAA[i].comentarios_recurso != null ? arrRAA[i].comentarios_recurso : '' }</td>
          </tr>
        `;
      }
    }else{
      trRecursos = `
        <tr>
          <td colspan="6" class="tx-center tx-bold">Sin Recursos Adicionales </td>
        </tr>
      `;
    }

    $("#espacioEditarAudiencia").empty();
    $("#espacioEditarAudiencia").append(`
      <input type="hidden" name="id_audiencia_edit" id="id_audiencia_edit" value="${audiencia.id_audiencia}">
      <div class="row">
        <div class="col-lg-6">
          <div class="row"> <!-- FROM AUDIENCIA -->

            <div class="col-lg-12 mg-b-20">
              <label class="form-control-label">Tipo Audiencia :<span class="tx-danger">*</span> </label>
              <select class="form-control select-edit" id="tipoAudiencia-A" name="tipoAudiencia-A" autocomplete="off">
                ${strOptionTA}
              </select>
            </div>

            <div class="col-lg-12 mg-b-20">
              <div class="row">
                <div class="col-md-8">
                  <label class="form-control-label">Juez Asignado :<span class="tx-danger">*</span> </label>
                  <select class="form-control select-edit" id="juez-A" name="juez-A" autocomplete="off">
                    ${strOptionJ}
                  </select>
                </div>
                <div class="col-md-4">
                  <label class="ckbox mg-t-40">
                    <input type="checkbox" onchange="excusar(this)"><span>Excusar</span>
                  </label>
                </div>
              </div>
            </div>

            <div class="col-lg-6 mg-b-20">
              <label class="form-control-label">Inmueble <span class="tx-danger">*</span> :</label>
              <select class="form-control select-edit" id="inmueble-A" name="inmueble-A" autocomplete="off" onchange="refrescar_salas( this.value, '#sala-A' )">
                ${strOptionI}
              </select>
            </div>

            <div class="col-lg-6 mg-b-20">
              <label class="form-control-label">Sala <span class="tx-danger">*</span> :</label>
              <select class="form-control select-edit" id="sala-A" name="sala-A" autocomplete="off" onchange="pintar_eventos( this , '#fecha-A' )">
                ${strOptionS}
              </select>
            </div>

            <div class="col-lg-12 mg-b-20 col-md-12">
              <div class="row">

                <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-control-label">Fecha <span class="tx-danger">*</span> :</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                        </div>
                      </div>
                      <input type="text" class="form-control datepicker-edit" placeholder="DD-MM-AAAA" value="${arrA[ indexA ].fecha_audiencia.split('-').reverse().join('-')}" id="fecha-A" name="fecha-A" autocomplete="off" readonly onchange="pintar_eventos( '#sala-A' , this)">
                    </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-control-label">Hora inicio <span class="tx-danger">*</span> :</label>
                    <div class="d-flex">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <i class="fa fa-clock-o tx-16 lh-0 op-6"></i>
                          </div><!-- input-group-text -->
                        </div><!-- input-group-prepend -->
                        <input  type="text" class="form-control time-edit" id="horaInicio-A" name="horaInicio-A" placeholder="hh:mm" value="${arrA[ indexA ].hora_inicio_audiencia.substring(0,5)}">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-control-label">Hora termino <span class="tx-danger">*</span> :</label>
                    <div class="d-flex">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <i class="fa fa-clock-o tx-16 lh-0 op-6"></i>
                          </div><!-- input-group-text -->
                        </div><!-- input-group-prepend -->
                        <input  type="text" class="form-control time-edit" id="horaTermino-A" name="horaTermino-A" placeholder="hh:mm" value="${arrA[ indexA ].hora_fin_audiencia.substring(0,5)}">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>

          <div class="row"> <!-- FORM RECURSOS -->

            <div class="col-lg-12 mg-b-20">
              <div class="col-lg-12">
                <div id="accordionRecusosAdicionales-A" class="accordion-one mg-b-10" role="tablist" aria-multiselectable="true" width="100%" style="display:block">
                  <div class="card">
                    <div class="card-header" role="tab" id="headingOne">
                      <a id="titleAccordionRecusosAdicionales-A" data-toggle="collapse" data-parent="#accordionRecusosAdicionales-A" href="#collapseOneRecusosAdicionales-A" aria-expanded="true" aria-controls="collapseOneRecusosAdicionales-A" class="bkg-collapsed-btn tx-gray-800 transition collapsed tx-white">
                        Modificación de Audiencia
                      </a>
                    </div><!-- card-header -->
                    <div id="collapseOneRecusosAdicionales-A" class="collapse" role="tabpanel" aria-labelledby="headingOneRecusosAdicionales-A">
                      <div class="card-body">

                        <div class="row">
                          <div class="col-lg-12">
                            <label class="form-control-label">Recurso :<span class="tx-danger">*</span> </label>
                            <select class="form-control select-edit" id="recurso-A" name="recurso-A" autocomplete="off">
                              ${strOptionR}
                            </select>
                          </div>

                          <div class="col-lg-12 mg-b-20 col-md-12">
                            <div class="row">

                              <div class="col-md-4">
                                <div class="form-group">
                                  <label class="form-control-label">Fecha <span class="tx-danger">*</span> :</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <div class="input-group-text">
                                        <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                      </div>
                                    </div>
                                    <input type="text" class="form-control datepicker-edit" placeholder="DD-MM-AAAA" value="" id="fechaRecurso-A" name="fechaRecurso-A" autocomplete="off" readonly >
                                  </div>
                                </div>
                              </div>

                              <div class="col-md-4">
                                <div class="form-group">
                                  <label class="form-control-label">Hora inicio <span class="tx-danger">*</span> :</label>
                                  <div class="d-flex">
                                    <div class="input-group">
                                      <div class="input-group-prepend">
                                        <div class="input-group-text">
                                          <i class="fa fa-clock-o tx-16 lh-0 op-6"></i>
                                        </div><!-- input-group-text -->
                                      </div><!-- input-group-prepend -->
                                      <input  type="text" class="form-control time-edit" id="horaInicioRecurso-A" name="horaInicioRecurso-A" placeholder="hh:mm" value="">
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <div class="col-md-4">
                                <div class="form-group">
                                  <label class="form-control-label">Hora termino <span class="tx-danger">*</span> :</label>
                                  <div class="d-flex">
                                    <div class="input-group">
                                      <div class="input-group-prepend">
                                        <div class="input-group-text">
                                          <i class="fa fa-clock-o tx-16 lh-0 op-6"></i>
                                        </div><!-- input-group-text -->
                                      </div><!-- input-group-prepend -->
                                      <input  type="text" class="form-control time-edit" id="horaTerminoRecurso-A" name="horaTerminoRecurso-A" placeholder="hh:mm" value="">
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <div class="col-md-12">
                                <div class="form-group">
                                  <label class="form-control-label">Comentarios :</label>
                                  <textarea class="form-control" name="comentariosRecurso-A" id="comentariosRecurso-A" rows="1"></textarea>
                                </div>
                              </div>

                              <div class="col-md-12">
                                <table class="datatable tableDatosSujeto" style="overflow-x: none; display: table; text-align: left;">
                                  <thead>
                                    <tr>
                                      <th class="tx-center" style="background:#f8f9fa" colspan="6" class="tx-center tx-bold">Recursos Adicionales de la Audiencia:</th>
                                    </tr>
                                    <tr>
                                      <th class="tx-center" style="background:#f8f9fa" >#</th>
                                      <th class="tx-center" style="background:#f8f9fa" >Accion</th>
                                      <th class="tx-center" style="background:#f8f9fa" >Recurso</th>
                                      <th class="tx-center" style="background:#f8f9fa" >Horario de uso</th>
                                      <th class="tx-center" style="background:#f8f9fa" >Descripción</th>
                                      <th class="tx-center" style="background:#f8f9fa" >Comentarios</th>
                                    </tr>
                                  </thead>
                                  <tbody style="font-weight: lighter;">
                                    ${trRecursos}
                                  </tbody>
                                </table>
                              </div>


                            </div>
                          </div>
                        </div>

                      </div> <!-- CARD BODY -->
                    </div> <!-- BODY COLLAPSE -->
                  </div> <!-- CARD -->
                </div> <!-- ACCORDEON RECURSOS ADICIONALES -->
              </div>
            </div>

          </div>

          <div class="row"> <!-- BOTONES -->

            <div class="col-lg-6 col-md-6" align="left">
              <button type="button" class="btn btn-oblong btn-secondary" data-anterior="" data-actual="#paso1-AE" data-siguiente="#paso2-AE" onclick="limpiarEspacioA('#espacioEditarAudiencia')" style="width: 100px;"> Cancelar </button>
            </div>

            <div class="col-lg-6 col-md-6" align="right">
              <button type="button" class="btn btn-oblong btn-primary" data-anterior="" data-actual="#paso1-AE" data-siguiente="#paso2-AE" onclick="cambiarPaso(this,'siguiente')" style="width: 100px;"> Guardar </button>
            </div>

          </div>

        </div>
        <div class="col-lg-6">
          <div id="calendario" class="dhx_cal_container" style='width:100%; height:50vh;'>
          </div>
        </div>
      </div>
    `);

    setTimeout( function(){ loadConfigComponentA(); }, 1000);
    setTimeout( function(){ pintar_eventos( '#sala-A', '#fecha-A'); }, 2000);
  }

  function excusar( tag ){
    console.log( tag );
    if( $(tag).is(':checked') ){

      $.ajax({
        method:'POST',
        url:'/public/obtener_siguiente_juez_control',
        data:{
          id_unidad : carpetaActiva.id_unidad
        },
        success:function(response){
          console.log( "consulta jueces tramite", response );
          if( response.status == 100 ){
            let juez = response.response;

            title = `Excusando Juez`;

            body = `
              <div class="col-lg-12">
                <label class="form-control-label">Juez :<span class="tx-danger">*</span> </label>
                <select class="form-control select-edit" id="juezExcusa-A" name="juezExcusa-A" autocomplete="off">
                  <option value="${juez.id_usuario}"> ${juez.nombre} </option>
                </select>
              </div>
              <div class="col-lg-12">
                <div class="form-group">
                  <label class="form-control-label">Ingrese los motivos por los que desea remover este documento:</label>
                  <textarea class="form-control" name="motivoExcusa-A" id="motivoExcusa-A" rows="4" placeholder="Ingrese sus motivos"></textarea>
                </div>
              </div>
            `;

            modal_confirm(title,body,null,'modalAdministracion');
          }
        },
        error : function( errors ){
          modal_error('Error :'+ errors.message,'modalAdministracion');
          //modal_error('Error :'+ JSON.stringify(errors),'modalAdministracion');
        }
      });

    }else return false;
  }


  @if($request->session()->get('id_tipo_usuario') == 1 || $request->session()->get('id_tipo_usuario') == 20 )
    function estatusAudiencia( indexA, estatus, modal=true ){
      if( modal ){
        $("#modalHistory").modal('hide');
        title = `Cambio de estatus de semáforo`;
        body = `
          <div class="row justify-content-md-center">
            <div class="col-lg-10">
              <label class="form-control-label"> Ingrese los motivos del porqué la audiencia cambia al estatus ${estatus.toUpperCase()} </label>
              <textarea class="form-control" name="motivoCambioEstatus-A" id="motivoCambioEstatus-A" rows="4"></textarea>
            </div>
          </div>
        `;
        setTimeout(function (){ modal_confirm(title,body,`estatusAudiencia( ${indexA}, '${estatus}', ${false} )`,'modalAdministracion'); },1000);
      }else{

        $("#modalHistory").modal('hide');
        //setTimeout(function(){ loading(true)},500);
        $.ajax({
          method:'POST',
          url:'/public/modificar_estatus_audiencia_cj',
          async: false,
          data:{
            id_unidad : carpetaActiva.id_unidad,
            carpeta_judicial:carpetaActiva.id_carpeta_judicial,
            id_audiencia: arrA[ indexA ].id_audiencia,
            estatus,
            motivos : $("#motivoCambioEstatus-A").val(),
          },
          success:function(response){
            console.log(response);
            if(response.status==100){
              //loading(false);
              modal_success('Semáforo de Audiencia cambiado exitosamente a '+estatus.toUpperCase(),'modalAdministracion');
              pintarAudiencias();
            }else{
              loading(false);
              modal_error(response.message,'modalAdministracion');
            }
          },
          error : function( errors ){
            loading(false);
            modal_error('Error :'+errors,'modalAdministracion');
          }
        });

      }

    }
  @endif




  function limpiarEspacioA( tag ){
    $( tag ).empty();
  }



  /*********+
   *
   *  FUNCIONES DE CONFIGURACION
   *
   * *******/

  function loadConfigComponentA(){
    $('.select-edit').select2({minimumResultsForSearch: ''});
    

    $('.datepicker-edit').datepicker({
        showOtherMonths: true,
        selectOtherMonths: true,
        format: 'dd/mm/yyyy',
        changeYear: true,
        yearRange: "c-100:c+0"
    });
    $('.time-edit').timepicker();

    scheduler.config.header = [
      //"day",
      // "week",
      // "month",
      "date",
      //"prev",
      //"today",
      //"next"
    ];

    scheduler.attachEvent("onDblClick", function(){ return false; });

    scheduler.attachEvent("onClick",function(id, e){ return false; });

    scheduler.config.dblclick_create = false;
    scheduler.config.details_on_dblclick = true;

    // scheduler.templates.event_class = function(start,end,ev){
    //   return "event_bkg_"+ev.color;
    // };

    scheduler.init('calendario',new Date(),"day");
  }

  async function refrescar_salas( id_inmueble, tag){

    console.log("refresca salas:", id_inmueble, tag);

    let salas = await obtener_salas( id_inmueble );
    let strOptionS = ``;

    if( salas.status == 100 ){
      if( (salas.response).length == 0 ) strOptionS = strOptionS + `<option value="null" disabeld selected > No tiene permiso para usar las salas de este inmueble </option>`;
      for( var i in salas = salas.response){
        strOptionS = strOptionS + `<option value="${salas[i].id_sala}"> ${salas[i].nombre_sala} </option>`;
      }
    }

    $( tag ).empty();
    $( tag ).append( strOptionS );

    pintar_eventos( tag , '#fecha-A' );
  }

  function pintar_eventos( tag_sala , tag_fecha ){
    if( scheduler.getEvents().length > 0) scheduler.clearAll();
    if( $(tag_sala).val() != 'null' && $(tag_fecha).val() )
      obtener_eventos( $(tag_sala).val() , $(tag_fecha).val().split('-').reverse().join('-') );
    else
      return false;
  }

  function obtener_eventos( id_sala, fecha ){
    //return new Promise(resolve => {
      $.ajax({
        method:'POST',
        url:'/public/consulta_audiencias',
        data:{
          id_sala,
          fecha_min : fecha,
          fecha_max : fecha,
        },
        success:function(response){
          console.log( "consulta audiencias", response );
          if( response.status == 100 ){
            let eventos = [];
            for(var i in response.response){
              evento = response.response[i];
              eventos.push({
                id: evento.id_audiencia,
                text: evento.id_unidad == carpetaActiva.id_unidad ? evento.tipo_audiencia : 'Ocupado',
                start_date: new Date( evento.fecha_audiencia+' '+evento.hora_inicio_audiencia ),
                end_date: new Date( evento.fecha_audiencia+' '+evento.hora_fin_audiencia ),
                color: evento.id_audiencia == $("#id_audiencia_edit").val() ? 'danger' : 'primary',
              });
            }
            scheduler.parse(eventos);
          }
          //revolse( response );
        },
        error : function( errors ){
          modal_error('Error :'+errors,'modalAdministracion');
          //revolse( {status:0, message:'Error al consumir servicio consulta audiencias'} );
        }
      });
      scheduler.setCurrentView(new Date( fecha+" 08:00:00" ));
    //});
  }


  /***************************
   *
   *  Promesas
   *
   * *************************/

  function obtener_salas(id_inmueble=null){
    return new Promise(resolve => {
      $.ajax({
        method:'POST',
        url:'/public/obtener_inmueble_salas',
        //  async: false,
        data:{ id_unidad:carpetaActiva.id_unidad, id_inmueble : id_inmueble  },
        success:function(response){
          console.log(response);
          resolve(response);
        },
        error : function( errors ){
          modal_error('Error :'+errors,'modalAdministracion');
          resolve( {status:0, message:'Error al consumir servicio inmueble salas'} ) ;
        }
      });

    });
  }

  function obtener_jueces_ejecucion(){
    return new Promise(resolve => {
      $.ajax({
        method:'POST',
        url:'/public/obtener_jueces_ejecucion',
        async: false,
        data:{ id_unidad:carpetaActiva.id_unidad },
        success:function(response){
          console.log(response);
          resolve(response);
        },
        error : function( errors ){
          modal_error('Error :'+errors,'modalAdministracion');
          revolse( {status:0, message:'Error al consumir servicio jueces ejecucion'} );
        }
      });
    });
  }

  /**************
   *
   * FUNCIONES PARA MODAL DE AUDIENCIAS INFO
   *
   * ***********/
  
   {{--  Resolutivos  --}}
   
  function agregarAccionesResolutivo(folio, id_audiencia){
    $('#modalHistory').modal('hide');
    $('#modalAccionesResolutivos').modal('show');
    $('#folioC').val(folio);
    $('#folioC_id_audiencia').val(id_audiencia)
  }

  function obtener_resolutivos(resolutivo){

      $.ajax({
        type:'post',
        url:'/public/obtener_resolutivos',
        data:{
        },
        success:function(response) {
          body = '';
          if(response.status==100){
              var datas = response.response;
              console.log(datas);
              body='<option value="-">Seleccione un resolutivo</option>';
              for (var j = 0; j < datas.length; j++) {
                body += `<option value="${datas[j]['id_resolutivo']}" data-tipo="${datas[j]['tipo_resultado']}">${datas[j]['descripcion']}</option>`;
              }
            $("#"+resolutivo).html(body);

          }else{
            body = body.concat('<option value="-">Seleccione un resolutivo</option>');
            $("#"+resolutivo).html(body);

          }
        }
      });
  }

  function elegir_menu(id){
    menu = $('option:selected', id).attr('data-tipo');

    if(menu == 1){
      $('#menu1').css('display', 'block');
      $('#menu2').css('display', 'none');
      $('#menu4').css('display', 'none');
      $('#menu5').css('display', 'none');
      $('#menu8').css('display', 'none');
    }else if(menu == 2){
      $('#menu1').css('display', 'none');
      $('#menu2').css('display', 'block');
      $('#menu4').css('display', 'none');
      $('#menu5').css('display', 'none');
      $('#menu8').css('display', 'none');
    }else if(menu == 4){
      $('#menu1').css('display', 'none');
      $('#menu2').css('display', 'none');
      $('#menu4').css('display', 'block');
      $('#menu5').css('display', 'none');
      $('#menu8').css('display', 'none');
    }else if(menu == 5){
      $('#menu1').css('display', 'none');
      $('#menu2').css('display', 'none');
      $('#menu4').css('display', 'none');
      $('#menu5').css('display', 'block');
      $('#menu8').css('display', 'none');
    }else if(menu == 8){
      $('#menu1').css('display', 'none');
      $('#menu2').css('display', 'none');
      $('#menu4').css('display', 'none');
      $('#menu5').css('display', 'none');
      $('#menu8').css('display', 'block');
    }

  }

  function obtener_audiencias_resolutivos(folio,pagina_accion){
    obtener_resolutivos('cmp_resolutivo_E');
    obtener_resolutivos('cmp_resolutivo');
    //paginacion
    pagina=parseInt($('#pagina_actual_resolutivos').val(), 10);
    registros_por_pagina=10;
    if(pagina_accion=="primera"){
        pagina=1;
    }
    else if(pagina_accion=="avanzar"){
        pagina=pagina+1;
    }
    else if(pagina_accion=="atras"){
        pagina=pagina-1;
    }
    else if(pagina_accion=="ultima"){
        pagina=$('#paginas_totales_resolutivos').val();
    }
    if(pagina<=0 || pagina>$('#paginas_totales_resolutivos').val()){

    }else{
      //asignacion de la paginacion
      $('#pagina_actual_resolutivos').val(pagina);
      $('#numeropagina_resolutivos').val(pagina);
      $('.pagina_actual_texto_resolutivos').html(pagina);
      $('.pagina_total_texto_resolutivos').html($('#paginas_totales_resolutivos').val());
      //Consulta al servicio
      $.ajax({
        type:'post',
        url:'/public/obtener_audiencias_resolutivos',
        data:{
            carpeta_judicial: folio,
            registros_por_pagina:registros_por_pagina,
            pagina:$("#pagina_actual_resolutivos").val(),
        },
        
        success:function(response) {
          
          body = '';
          if(response.status==100){

              $('.pagina_total_texto_resolutivos').html(response.response_pag['paginas_totales']);
              $('#paginas_totales_resolutivos').val(response.response_pag['paginas_totales']);

              var datas = response.response;
              console.log(datas);
              for (var j = 0; j < datas.length; j++) {
                var valor='';
                var comentarios = '';
                var color='';
                var estado='';

                if(datas[j]['tipo_resultado'] == 1){
                  valor = datas[j]['tipo_valor'];
                }else if(datas[j]['tipo_resultado'] == 2){
                  valor = datas[j]['fecha_base']+' '+datas[j]['fecha_resultado'];
                }else if(datas[j]['tipo_resultado'] == 4){
                  valor = datas[j]['fecha'];
                }else if(datas[j]['tipo_resultado'] == 5){
                  valor = datas[j]['numero'];
                }else if(datas[j]['tipo_resultado'] == 8){
                  valor = datas[j]['imputado'];
                }else{
                  valor = '-';
                }
                

                if(datas[j]['comentarios_adicionales'] == null){
                  comentarios = 'Sin comentarios';
                }else{
                  comentarios = datas[j]['comentarios_adicionales'];
                }

                if(datas[j]['estatus'] == 1){
                  color = 'green';
                  estado = 'Activo';
                }else{
                  color= 'red';
                  estado = 'Inactivo';
                }

                body += `<tr>
                  <td><i class="fas fa-edit acciones2" data-toggle="tooltip-primary" data-placement="top" title="Editar resolutivo" onclick="cargarCamposEditarResolutivo(${datas[j]['id_audiencia_resolutivo']},${datas[j]['id_audiencia']},'${datas[j]['folio_carpeta']}',${datas[j]['id_resolutivo']}, ${datas[j]['id_imputado']}, '${datas[j]['imputado']}','${datas[j]['tipo_valor']}',${datas[j]['numero']}, '${datas[j]['fecha']}', '${datas[j]['fecha_base']}','${datas[j]['fecha_resultado']}','${datas[j]['comentarios_imputado']}', '${datas[j]['comentarios_adicionales']}', ${datas[j]['tipo_resultado']},${datas[j]['estatus']} )"></i></td> 
                            <td>${datas[j]['folio_carpeta']}</td>
                            <td>${datas[j]['descripcion']}</td>
                            <td>${comentarios}</td>
                            <td>${valor}</td>
                            <td style="color:${color};">${estado}</td>
                        </tr>`;
              }
            $("#body-table1").html(body);
            
          }else{
            body = body.concat('<tr><td colspan="5">No existen registros</td></tr>');
            $("#body-table1").html(body);
          }
        }
      });
    }
  }

  function limpiarCamposResolutivo(){
    $("#frm_resolutivos select").each(function() { this.selectedIndex = 0 });
    $("#frm_resolutivos input[type=text] , #frm_resolutivos textarea").each(function() { this.value = '' });
    $('#menu1').css('display', 'none');
    $('#menu2').css('display', 'none');
    $('#menu4').css('display', 'none');
    $('#menu5').css('display', 'none');
    $('#menu8').css('display', 'none');

    $("#frm_resolutivos_E select").each(function() { this.selectedIndex = 0 });
    $("#frm_resolutivos_E input[type=text] , #frm_resolutivos textarea").each(function() { this.value = '' });
    $('#menu1_E').css('display', 'none');
    $('#menu2_E').css('display', 'none');
    $('#menu4_E').css('display', 'none');
    $('#menu5_E').css('display', 'none');
    $('#menu8_E').css('display', 'none');

    $("#frm_medidasC_ select").each(function() { this.selectedIndex = 0 });
    $("#frm_medidasC input[type=text] , #frm_medidasC textarea").each(function() { this.value = '' });
    $('#medidaC_menu1').css('display', 'none');
    $('#medidaC_menu2').css('display', 'none');

    $("#frm_medidasC_E select").each(function() { this.selectedIndex = 0 });
    $("#frm_medidasC_E input[type=text] , #frm_medidasC_E textarea").each(function() { this.value = '' });
    $('#medidaC_menu1_E').css('display', 'none');
    $('#medidaC_menu2_E').css('display', 'none');
  }

  function cancelar_resolutivo(abrir, cerrar){
    limpiarCamposResolutivo();
    
    $('#'+abrir).modal('show');
    $('#'+cerrar).modal('hide');
  }
  
  function guardar_resolutivo(){
     folioC =$('#folioC').val();
     id_resolutivo = $('#cmp_resolutivo').val();
     resolutivo = $('select[name="cmp_resolutivo"] option:selected').text();
     tipo_resolutivo = $('select[name="cmp_resolutivo"] option:selected').attr('data-tipo');
     comentarios_adicionales  = $('#cmp_comentarios_resolutivo').val();
     folioC_id_audiencia = $('#folioC_id_audiencia').val();

     if(tipo_resolutivo == 1){
      tipo_valor = $('#cmp_valor').val();
     }else{
      tipo_valor = null;
     }

    if(tipo_resolutivo == 2){
      fecha_base = $('#cmp_fecha_base').val();
      fecha_resultado = $('#cmp_fecha_resultado').val();
    }else{
      fecha_base = null;
      fecha_resultado = null;
    }

    if(tipo_resolutivo == 4){
      fecha = $('#cmp_fecha').val();
    }else{
      fecha = null;
    }

    if(tipo_resolutivo == 5){
      numero = $('#cmp_cantidad').val();
    }else{
      numero = null;
    }

    if(tipo_resolutivo == 8){
      id_imputado = $('#cmp_imputado').val();
      comentarios_imputado = $('#cmp_imputado_comentario').val();
    }else{
      id_imputado = null;
      comentarios_imputado = null;
    }

    console.log(folioC+','+id_resolutivo+','+ id_imputado+','+ tipo_valor+','+numero  +','+fecha+','+ fecha_base+','+ fecha_resultado+','+ comentarios_imputado+','+ comentarios_adicionales+','+ tipo_resolutivo)
    
    $.ajax({
      type:'post',
      url:'/public/guardar_audiencias_resolutivos',
      data:{
        "folio_carpeta":folioC,
        "id_resolutivo":id_resolutivo,
        "id_imputado":id_imputado,
        "tipo_valor": tipo_valor,
        "numero":numero,
        "fecha":fecha,
        "fecha_base":fecha_base,
        "fecha_resultado":fecha_resultado,
        "comentarios_imputado":comentarios_imputado,
        "comentarios_adicionales":comentarios_adicionales,
        "tipo_resultado":tipo_resolutivo,
        "id_audiencia":folioC_id_audiencia
      },
      success:function(response) {
        body = '';
        if(response.status==100){
          var exito = "<p class='mg-b-20 mg-x-20'>El Resolutivo "+resolutivo+ " Fue agregado </p>";
          $('#modalAccionesResolutivos').modal('hide');
          $('#modalHistory').modal('hide');
          modal_success(exito,'modalHistory');
          obtener_audiencias_resolutivos(folioC,'primera');
          limpiarCamposResolutivo();
        }else{
          var error = "<p class='mg-b-20 mg-x-20'>"+response.message+"</p>";
          $('#modalAccionesResolutivos').modal('hide');
          $('#modalHistory').modal('hide');
          limpiarCamposResolutivo();
          modal_error(error,'modalHistory');
        }
      }
    });
    
  }

  function cargarCamposEditarResolutivo(id_audiencia_resolutivo,id_audiencia,folio_carpeta,id_resolutivo,id_imputado,imputado,tipo_valor,numero,fecha,fecha_base,fecha_resultado,comentarios_imputado,comentarios_adicionales,tipo_resultado,estatus){
    $('#modalHistory').modal('hide');
    $('#modalAccionesResolutivos_E').modal('show');

    switch (tipo_resultado){

      case 1: 
        $('#cmp_valor_E option[value='+ tipo_valor +']').attr("selected",true);
        $('#cmp_estatus_resolutivo_E option[value='+ estatus +']').attr("selected",true);
        $('#folioC_E').val(folio_carpeta);
        $('#folioC_A_E').val(id_audiencia_resolutivo);
        $('#folioC_id_audiencia_E').val(id_audiencia);
        $('#cmp_resolutivo_E option[value='+ id_resolutivo +']').attr("selected",true);
        $('#cmp_resolutivo_E').prop('disabled', true);
        $('#cmp_comentarios_resolutivo_E').val(comentarios_adicionales);
        $('div#menu1_E').css('display', 'block');
        break;
      
      case 2:
        $('#cmp_fecha_base_E').val(fecha_base);
        $('#cmp_estatus_resolutivo_E option[value='+ estatus +']').attr("selected",true);
        $('#cmp_fecha_resultado_E').val(fecha_resultado);
        $('#folioC_E').val(folio_carpeta);
        $('#folioC_A_E').val(id_audiencia_resolutivo);
        $('#folioC_id_audiencia_E').val(id_audiencia);
        $('#cmp_resolutivo_E option[value='+ id_resolutivo +']').attr("selected",true);
        $('#cmp_resolutivo_E').prop('disabled', true);
        $('#cmp_comentarios_resolutivo_E').val(comentarios_adicionales);
        $('div#menu2_E').css('display', 'block');
        break;

      case 4:
        $('#cmp_fecha_E').val(fecha);
        $('#cmp_estatus_resolutivo_E option[value='+ estatus +']').attr("selected",true);
        $('#folioC_E').val(folio_carpeta);
        $('#folioC_A_E').val(id_audiencia_resolutivo);
        $('#folioC_id_audiencia_E').val(id_audiencia);
        $('#cmp_resolutivo_E option[value='+ id_resolutivo +']').attr("selected",true);
        $('#cmp_resolutivo_E').prop('disabled', true);
        $('#cmp_comentarios_resolutivo_E').val(comentarios_adicionales);
        $('div#menu4_E').css('display', 'block');
        break;

      case 5:
        $('#cmp_cantidad_E').val(numero);
        $('#cmp_estatus_resolutivo_E option[value='+ estatus +']').attr("selected",true);
        $('#folioC_E').val(folio_carpeta);
        $('#folioC_A_E').val(id_audiencia_resolutivo);
        $('#folioC_id_audiencia_E').val(id_audiencia);
        $('#cmp_resolutivo_E option[value='+ id_resolutivo +']').attr("selected",true);
        $('#cmp_resolutivo_E').prop('disabled', true);
        $('#cmp_comentarios_resolutivo_E').val(comentarios_adicionales);
        $('div#menu5_E').css('display', 'block');
        break;
      
      case 8: 
        $('#cmp_imputado_E').val('');
        $('#cmp_estatus_resolutivo_E option[value='+ estatus +']').attr("selected",true);
        $('#cmp_nombre_imputado_E').html(imputado);
        $('#cmp_imputado_comentario_E').val(comentarios_imputado);
        $('#folioC_E').val(folio_carpeta);
        $('#folioC_A_E').val(id_audiencia_resolutivo);
        $('#folioC_id_audiencia_E').val(id_audiencia);
        $('#cmp_resolutivo_E option[value='+ id_resolutivo +']').attr("selected",true);
        $('#cmp_resolutivo_E').prop('disabled', true);
        $('#cmp_comentarios_resolutivo_E').val(comentarios_adicionales);
        $('div#menu8_E').css('display', 'block');
        break;
      
    }

  }

  function editar_resolutivo(){
     folioC = $('#folioC_E').val();
     folioC_A_E =  $('#folioC_A_E').val();
     id_resolutivo = $('#cmp_resolutivo_E').val();
     resolutivo = $('select[name="cmp_resolutivo_E"] option:selected').text();
     tipo_resolutivo = $('select[name="cmp_resolutivo_E"] option:selected').attr('data-tipo');
     comentarios_adicionales  = $('#cmp_comentarios_resolutivo_E').val();
     estatus = $('#cmp_estatus_resolutivo_E').val();
     id_audiencia = $('#folioC_id_audiencia_E').val();

     if(tipo_resolutivo == 1){
      tipo_valor = $('#cmp_valor_E').val();
     }else{
      tipo_valor = null;
     }

    if(tipo_resolutivo == 2){
      fecha_base = $('#cmp_fecha_base_E').val();
      fecha_resultado = $('#cmp_fecha_resultado_E').val();
    }else{
      fecha_base = null;
      fecha_resultado = null;
    }

    if(tipo_resolutivo == 4){
      fecha = $('#cmp_fecha_E').val();
    }else{
      fecha = null;
    }

    if(tipo_resolutivo == 5){
      numero = $('#cmp_cantidad_E').val();
    }else{
      numero = null;
    }

    if(tipo_resolutivo == 8){
      id_imputado = $('#cmp_imputado_E').val();
      comentarios_imputado = $('#cmp_imputado_comentario_E').val();
    }else{
      id_imputado = null;
      comentarios_imputado = null;
    }

    console.log(id_audiencia+','+folioC+','+folioC_A_E+','+id_resolutivo+','+ id_imputado+','+ tipo_valor+','+numero  +','+fecha+','+ fecha_base+','+ fecha_resultado+','+ comentarios_imputado+','+ comentarios_adicionales+','+ tipo_resolutivo+','+estatus)
    

    $.ajax({
     type:'post',
     url:'/public/editar_audiencias_resolutivos',
     data:{
       "id_audiencia_resolutivo":folioC_A_E,
       "folio_carpeta":folioC,
       "id_resolutivo":id_resolutivo,
       "id_imputado":id_imputado,
       "tipo_valor": tipo_valor,
       "numero":numero,
       "fecha":fecha,
       "fecha_base":fecha_base,
       "fecha_resultado":fecha_resultado,
       "comentarios_imputado":comentarios_imputado,
       "comentarios_adicionales":comentarios_adicionales,
       "tipo_resultado":tipo_resolutivo,
       "estatus":estatus,
       "id_audiencia":id_audiencia
     },
     success:function(response) {
       body = '';
       if(response.status==100){
         var exito = "<p class='mg-b-20 mg-x-20'>El Resolutivo "+resolutivo+ " Fue agregado </p>";
         $('#modalAccionesResolutivos_E').modal('hide');
         $('#modalHistory').modal('hide');
         modal_success(exito,'modalHistory');
         obtener_audiencias_resolutivos(folioC,'primera');
         limpiarCamposResolutivo();
       }else{
        var error = "<p class='mg-b-20 mg-x-20'>"+response.message+"</p>";
        $('#modalAccionesResolutivos_E').modal('hide');
        $('#modalHistory').modal('hide');
        limpiarCamposResolutivo();
        obtener_audiencias_resolutivos(folioC,'primera');
        modal_error(error,'modalHistory');
       }
     }
    });
    
  }

	function sumar_dias (days, res) {
			fecha_resultado = $('#'+res).val()
			if(fecha_resultado.length < 1){
				fecha=new Date();	 
		    	fecha.setDate(fecha.getDate()+days);
		    	$('#'+res).val(devolverFechaFormateada(fecha));
			}else{
				fecha=new Date(fecha_resultado);		 
		    	fecha.setDate(fecha.getDate()+days);
		    	$('#'+res).val(devolverFechaFormateada(fecha));
			}
	}
	function sumar_meses (month, res) {
			fecha_resultado = $('#'+res).val()
			if(fecha_resultado.length < 1){
		    	fecha=new Date();		 
		    	fecha.setMonth(fecha.getMonth()+month);
		    	$('#'+res).val(devolverFechaFormateada(fecha));
			}else{
		    	fecha=new Date(fecha_resultado);		 
		    	fecha.setMonth(fecha.getMonth()+month);
		    	$('#'+res).val(devolverFechaFormateada(fecha));
			}

	}
	function sumar_anios( year, res) {
			fecha_resultado = $('#'+res).val()
			if(fecha_resultado.length < 1){
		    	fecha=new Date();		 
		    	fecha.setFullYear(fecha.getFullYear()+year);
		    	$('#'+res).val(devolverFechaFormateada(fecha));
			}else{
		    	fecha=new Date(fecha_resultado);
		    	console.log(fecha)		 
		    	fecha.setFullYear(fecha.getFullYear()+year);
		    	$('#'+res).val(devolverFechaFormateada(fecha));
			}

	}
	function devolverFechaFormateada ( fecha){
		    var day=fecha.getDate();
		    // el mes es devuelto entre 0 y 11
		    var month=fecha.getMonth()+1;
		    var year=fecha.getFullYear();

		    return year+"-"+month+"-"+day;
	}
	 
	function sumar_dia(val, res){count_days += 1; $('#'+val).val(count_days); sumar_dias(+1, res)}
	function restar_dia(val, res){if(count_days > 0){	count_days -= 1; $('#'+val).val(count_days); sumar_dias(-1, res) }else{	count_days = 0;}}

	function sumar_mes(val, res){if(count_months > 11){	count_months = 12;}else{	count_months += 1;	$('#'+val).val(count_months); sumar_meses(+1, res)}}
	function restar_mes(val, res){ if(count_months > 0){count_months -= 1; $('#'+val).val(count_months); sumar_meses(-1, res);}else{	count_months = 0; }}

	function sumar_anio(val, res){count_years += 1;$('#'+val).val(count_years); sumar_anios(+1, res)}
	function restar_anio(val, res){if(count_years > 0 ){count_years -= 1; $('#'+val).val(count_years); sumar_anios(-1, res)}else{count_years = 0;}}

{{--  Mandamientos  --}}
  function obtener_mandamientos(folio,pagina_accion){
    rellenarUnidadDelito(folio,'cmp_unidad_gestion','cmp_delitos');
    rellenarUnidadDelito(folio,'cmp_unidad_gestion_E','cmp_delitos_E');
    //paginacion
    pagina=parseInt($('#pagina_actual_mandamientos').val(), 10);
    registros_por_pagina=10;
    if(pagina_accion=="primera"){
        pagina=1;
    }
    else if(pagina_accion=="avanzar"){
        pagina=pagina+1;
    }
    else if(pagina_accion=="atras"){
        pagina=pagina-1;
    }
    else if(pagina_accion=="ultima"){
        pagina=$('#paginas_totales_mandamientos').val();
    }
    if(pagina<=0 || pagina>$('#paginas_totales_mandamientos').val()){

    }else{
      //asignacion de la paginacion
      $('#pagina_actual_mandamientos').val(pagina);
      $('#numeropagina_mandamientos').val(pagina);
      $('.pagina_actual_texto_mandamientos').html(pagina);
      $('.pagina_total_texto_mandamientos').html($('#paginas_totales_mandamientos').val());
      //Consulta al servicio
      $.ajax({
        type:'post',
        url:'/public/obtener_audiencias_mandamientos_judiciales',
        data:{
          "no_carpeta_judicial": folio,
          registros_por_pagina:registros_por_pagina,
          pagina:$("#pagina_actual_mandamientos").val(),
        },
        success:function(response) {
          body = '';

          if(response.status==100){

            $('.pagina_total_texto_mandamientos').html(response.response_pag['paginas_totales']);
            $('#paginas_totales_mandamientos').val(response.response_pag['paginas_totales']);

              var datas = response.response;
              console.log(datas);
              for (var j = 0; j < datas.length; j++) {
                if(datas[j]['estatus'] == 1){
                  color = 'green';
                  estado = 'Activo';
                }else{
                  color= 'red';
                  estado = 'Inactivo';
                }

                body += `<tr>
                            <td> <i class="fas fa-edit acciones2" data-toggle="tooltip-primary" data-placement="top" title="Editar resolutivo" onclick="cargarCamposEditarMandamiento(${datas[j]['id_audiencia_mandamiento_judicial']},${datas[j]['id_audiencia']},${datas[j]['id_solicitud']}, '${datas[j]['fecha_libramiento_orden']}', '${datas[j]['no_carpeta_judicial']}', ${datas[j]['no_oficio']} , '${datas[j]['tipo_orden']}' , '${datas[j]['ids_delitos']}', '${datas[j]['descripcion_orden']}',  ${datas[j]['id_unidad_gestion']},${datas[j]['estatus']})"></i></td> 
                            <td> ${datas[j]['no_carpeta_judicial']} </td>
                            <td> ${datas[j]['no_oficio']}           </td> 
                            <td> ${datas[j]['tipo_orden']}         </td>
                            <td> ${datas[j]['descripcion_orden']}   </td>
                            <td> ${datas[j]['nombre_unidad']}       </td>
                            <td style="color:${color};">${estado}   </td>
                          </tr>`;
              }
              $("#body-table2").html(body);
              
          }else{
            body = body.concat('<tr><td colspan="6">No existen registros</td></tr>');
            $("#body-table2").html(body);
          }
        }
      });
    }
  }

  function modalNuevoMandamiento(folio, audiencia){
    $('#modalHistory').modal('hide');
    $('#modalMandamiendoJudicial').modal('show');
    $('#cmp_carpeta_judicial').val(folio);
    $('#cmp_id_audiencia').val(audiencia);
  }

  function rellenarUnidadDelito(folio, unidad, delito){
    $.ajax({
      type:'post',
      url:'/public/consultar_carpetas_judiciales',
      data:{
        "no_carpeta_judicial": folio
      },
      success:function(response) {
        body = '';
        optionUnidad = '';
        optionDelitos = '';

        if(response.status==100){
            var datas = response.response;
            console.log(datas);
          optionDelitos='<option value="-">Seleccione el delito</option>';
          for (var i = 0; i < datas.length; i++) {
            for(var m = 0; m < datas[i]['delitos'].length; m++){
              optionDelitos+= `<option value="${datas[i]['delitos'][m]['id_delito']}">${datas[i]['delitos'][m]['delito']}</option>`;
            }
          }

          $('#'+delito).html(optionDelitos);

          optionUnidad='<option selected  value="0">Elija una unidad</option>';
          for (var k = 0; k < datas.length; k++) {
            optionUnidad+= `<option value="${datas[k]['id_unidad']}">${datas[k]['nombre_unidad']}</option>`;
          }

          $('#'+unidad).html(optionUnidad);

        }else{
          optionDelitos='<option value="-">Seleccione el delito</option>';
          optionUnidad='<option selected  value="0">Elija una unidad</option>';

          $('#'+delito).html(optionDelitos);
          $('#'+unidad).html(optionUnidad);
        }
      }
    });
  }

  function guardarMandamiento(){
    cmp_tipoOrden = $('#cmp_tipoOrden').val();
    cmp_delitos = $('#cmp_delitos').val();
    cmp_unidad_gestion = $('#cmp_unidad_gestion').val();
    cmp_oficio = $('#cmp_oficio').val();
    cmp_carpeta_judicial = $('#cmp_carpeta_judicial').val();
    cmp_id_solicitud = $('#cmp_id_solicitud').val();
    cmp_comentarios_mandamiento = $('#cmp_comentarios_mandamiento').val();
    cmp_libramiento = $('#cmp_libramiento').val();
    cmp_id_audiencia = $('#cmp_id_audiencia').val();


    newDA.id_version='-';
    newDA.id_tipo_archivo='-';
    newDA.nombre_archivo=$("#nombre_documento_mandamiento").val();
    newDA.estatus='-';

    console.log(newDA);
    
    $.ajax({
      type:'post',
      url:'/public/guardar_mandamiento',
      data:{
        "id_audiencia":cmp_id_audiencia,
        "no_oficio":cmp_oficio,
        "tipo_orden":cmp_tipoOrden,
        "id_delito":cmp_delitos,
        "descripcion_orden":cmp_comentarios_mandamiento,
        "id_unidad_gestion":cmp_unidad_gestion,
        "documento":newDA
      },
      success:function(response) {
        body = '';
        if(response.status==100){
          $('#modalMandamiendoJudicial').modal('hide');
          var exito = "<p class='mg-b-20 mg-x-20'>El Mandamiento "+cmp_tipoOrden+ " Fue agregado </p>";
          modal_success(exito,'modalHistory');
          obtener_mandamientos(cmp_carpeta_judicial,'primera');
        }else{
          $('#modalMandamiendoJudicial').modal('hide');
          var error = "<p class='mg-b-20 mg-x-20'>"+response.message+"</p>";
          modal_error(error,'modalHistory');
        }
      }
    });
    
  }

  function cargarCamposEditarMandamiento(id_audiencia_mandamiento_judicial, id_audiencia, id_solicitud, fecha_libramiento_orden, no_carpeta_judicial, no_oficio, tipo_orden, id_delito, descripcion_orden, id_unidad_gestion, estatus){
    $('#id_audiencia_mandamiento_E').val(id_audiencia_mandamiento_judicial);
    $('#id_audiencia_E').val(id_audiencia);
    $('#cmp_tipoOrden_E option[value='+ tipo_orden +']').attr("selected",true);
    $('#cmp_delitos_E option[value='+ id_delito +']').attr("selected",true);
    $('#cmp_libramiento_E').val(fecha_libramiento_orden);
    $('#cmp_id_solicitud_E').val(id_solicitud);
    $('#cmp_oficio_E').val(no_oficio);
    $('#cmp_unidad_gestion_E option[value='+ id_unidad_gestion +']').attr("selected",true);
    $('#cmp_carpeta_judicial_E').val(no_carpeta_judicial);
    $('#cmp_comentarios_mandamiento_E').val(descripcion_orden);
    $('#cmp_estatus_E option[value='+ estatus +']').attr("selected",true);

    $('#modalMandamiendoJudicialEdit').modal('show');
    $('#modalHistory').modal('hide');
  }

  function actualizar_mandamientos(){
    id_audiencia_mandamiento = $('#id_audiencia_mandamiento_E').val();
    cmp_id_audiencia = $('#id_audiencia_E').val();
    cmp_tipoOrden = $('#cmp_tipoOrden_E').val();
    cmp_delitos = $('#cmp_delitos_E').val();
    cmp_unidad_gestion = $('#cmp_unidad_gestion_E').val();
    cmp_oficio = $('#cmp_oficio_E').val();
    cmp_carpeta_judicial = $('#cmp_carpeta_judicial_E').val();
    cmp_id_solicitud = $('#cmp_id_solicitud_E').val();
    cmp_comentarios_mandamiento = $('#cmp_comentarios_mandamiento_E').val();
    cmp_libramiento = $('#cmp_libramiento_E').val();
    cmp_status = $('#cmp_estatus_E').val();
    
    $.ajax({
      type:'post',
      url:'/public/modificacion_audiencias_mandamientos_judiciales',
      data:{
        "id_audiencia": cmp_id_audiencia,
        "id_unidad_gestion":cmp_unidad_gestion,
        "id_audiencia_mandamiento_judicial":id_audiencia_mandamiento,
        "id_delito":cmp_delitos,
        "no_oficio":cmp_oficio,
        "tipo_orden":cmp_tipoOrden,
        "descripcion_orden":cmp_comentarios_mandamiento,
        "estatus":cmp_status
      },
      success:function(response) {
        body = '';
        if(response.status==100){
          $('#modalMandamiendoJudicialEdit').modal('hide');
          var exito = "<p class='mg-b-20 mg-x-20'>El Mandamiento "+cmp_tipoOrden+ " Fue actualizado </p>";
          modal_success(exito,'modalHistory');
          obtener_mandamientos(cmp_carpeta_judicial,'primera');
        }else{
          $('#modalMandamiendoJudicialEdit').modal('hide');
          var error = "<p class='mg-b-20 mg-x-20'>"+response.message+"</p>";
          modal_error(error,'modalHistory');
        }
      }
    });
    
  }

  function leeDocumentoMandamiento(input) {
    let acepted_files=["pdf","png","jpg","docx","doc"];

    let file = $('#mandamientoPDF').val();
    let ext = "";
    let extension = "";
    let nombre_documento = "";

    if(file.length){
     extension = file.split('.')[1];
     extension = extension.toLowerCase();
     nombre_documento = (file.split('\\')[2]).split('.')[0];
     nombre_documento = nombre_documento.replaceAll(' ', '_');
     nombre_documento = nombre_documento.replaceAll('  ', '_');
     if(extension!=''){
        if( !acepted_files.includes(extension) ){
          modal_error('Solo puede adjutar archivos PDF, PNG, JPG, DOC o DOCX','modalHistory');
          $('#mandamientoPDF').val('');
          return false
        }else{
          if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = e=> {
              newDA = {
                'b64' : e.target.result.split('base64,')[1],
                'nombre_archivo' : nombre_documento,
                'tamanio_archivo': input.files[0].size,
                'extension_archivo' : extension,
                'tipo_data': get_tipo_data(extension),
              };
            }
            reader.readAsDataURL(input.files[0]); 
          }
          setTimeout(function(){ pintar_documento_mandamiento(); },500);
        }
      }
    }else{
      return false;
    }
  }

  function pintar_documento_mandamiento(){

    $('#divViewDocumentosAcuerdo div').remove();
    
    let reader_files=["pdf","png","jpg"];

    documento = newDA;

    if ( reader_files.includes(documento.extension_archivo) ) { 
      $('#divViewDocumentosMandamiento').append(`
        <div class="col-lg-12" align="center">
          <object height="300px" ${ documento.extension_archivo=="pdf"?'width="100%"' : ''} class="mg-t-25" data="${documento.tipo_data+documento.b64}"></object>
        </div>
      `);    
    }else{
      $('#divViewDocumentosMandamiento').append(`
        <div class="col-lg-12" align="center">
          ${getIcon(documento.extension_archivo)}
        </div>
      `);
    }

    $("#nombre_documento_mandamiento").val( documento.nombre_archivo );  

    $("#col_nombre_documento_mandamiento").removeClass('d-none');
    $("#col_nombre_documento_mandamiento").focus();
  }

{{--  Acuerdos Reparatorios  --}}

function obtener_AcuerdosR(folio,pagina_accion){
    rellenarImputadosMedidas(folio,'cmp_imputado_AR');
    rellenarImputadosMedidas(folio,'cmp_imputado_AR_E');
    //paginacion
    pagina=parseInt($('#pagina_actual_acuerdosr').val(), 10);
    registros_por_pagina=10;
    if(pagina_accion=="primera"){
        pagina=1;
    }
    else if(pagina_accion=="avanzar"){
        pagina=pagina+1;
    }
    else if(pagina_accion=="atras"){
        pagina=pagina-1;
    }
    else if(pagina_accion=="ultima"){
        pagina=$('#paginas_totales_acuerdosr').val();
    }
    if(pagina<=0 || pagina>$('#paginas_totales_acuerdosr').val()){

    }else{
      //asignacion de la paginacion
      $('#pagina_actual_acuerdosr').val(pagina);
      $('#numeropagina_acuerdosr').val(pagina);
      $('.pagina_actual_texto_acuerdosr').html(pagina);
      $('.pagina_total_texto_acuerdosr').html($('#paginas_totales_acuerdosr').val());
      //Consulta al servicio
      $.ajax({
        type:'post',
        url:'/public/obtener_AcuerdosR',
        data:{
          "no_carpeta_judicial": folio,
           registros_por_pagina:registros_por_pagina,
           pagina:$("#pagina_actual_acuerdosr").val(),
        },
        success:function(response) {
          body = '';

          if(response.status==100){

            $('.pagina_total_texto_acuerdosr').html(response.response_pag['paginas_totales']);
            $('#paginas_totales_acuerdosr').val(response.response_pag['paginas_totales']);

              var datas = response.response;
              console.log(datas);
              for (var j = 0; j < datas.length; j++) {
                if(datas[j]['estatus'] == 1){
                  color = 'green';
                  estado = 'Activo';
                }else{
                  color= 'red';
                  estado = 'Inactivo';
                }

                body += `<tr>
                            <td> <i class="fas fa-edit acciones2" data-toggle="tooltip-primary" data-placement="top" title="Editar resolutivo" onclick="editarAcuerdoR(${datas[j]['id_audiencia_acuerdo_reparatorio']},${datas[j]['id_audiencia']},'${datas[j]['folio_carpeta']}', ${datas[j]['id_imputado']}, '${datas[j]['tipo_cumplimiento']}', '${datas[j]['aprueba_acuerdo']}' , '${datas[j]['fecha_extincion']}' , '${datas[j]['resumen_acuerdo']}', ${datas[j]['estatus']},  '${datas[j]['comentarios_adicionales']}')"></i></td> 
                            <td> ${datas[j]['imputado']}            </td>
                            <td> ${datas[j]['tipo_cumplimiento']}   </td> 
                            <td> ${datas[j]['aprueba_acuerdo']}     </td>
                            <td> ${datas[j]['fecha_extincion']}     </td>
                            <td style="color:${color};">${estado}   </td>
                          </tr>`;
              }
              $("#body-table3").html(body);
              
          }else{
            body = body.concat('<tr><td colspan="6">No existen registros</td></tr>');
            $("#body-table3").html(body);
          }
        }
      });
    }
}

function agregarAcuerdoR(folio, id_audiencia){
  resetform();
  $('#modalHistory').modal('hide');
  $('#modalAcuerdoR').modal('show');
  $('#CarpetaF').val(folio);
  $('#cmp_id_audiencia_AR').val(id_audiencia);
}

function guardarAcuerdoR(){
  CarpetaF = $('#CarpetaF').val();
  cmp_id_audiencia_AR =  $('#cmp_id_audiencia_AR').val();
  cmp_imputado_AR = $('#cmp_imputado_AR').val();
  cmp_resumenAcuerdo_AR = $('#cmp_resumenAcuerdo_AR').val();
  cmp_tipoCumplimiento_AR = $('#cmp_tipoCumplimiento_AR').val();
  cmp_apruebaAcuerdo_AR = $('#cmp_apruebaAcuerdo_AR').val();
  cmp_fehcaExtincion_AR = $('#cmp_fehcaExtincion_AR').val();
  cmp_comentariosAdicionales_AR = $('#cmp_comentariosAdicionales_AR').val();

  $.ajax({
    type:'post',
    url:'/public/guardarAcuerdoR',
    data:{
      "carpeta_judicial": CarpetaF,
      "id_audiencia":cmp_id_audiencia_AR,
      "id_imputado":cmp_imputado_AR,
      "resumen_acuerdo":cmp_resumenAcuerdo_AR,
      "tipo_cumplimiento":cmp_tipoCumplimiento_AR,
      "aprueba_acuerdo":cmp_apruebaAcuerdo_AR,
      "fecha_extincion":cmp_fehcaExtincion_AR,
      "comentarios_adicionales":cmp_comentariosAdicionales_AR
    },
    success:function(response) {
      body = '';
      if(response.status==100){
        $('#modalAcuerdoR').modal('hide');
        var exito = "<p class='mg-b-20 mg-x-20'>El Acuerdo reparatorio Fue agregado </p>";
        modal_success(exito,'modalHistory');
        obtener_AcuerdosR(CarpetaF,'primera');
      }else{
        $('#modalAcuerdoR').modal('hide');
        var error = "<p class='mg-b-20 mg-x-20'>"+response.message+"</p>";
        modal_error(error,'modalHistory');
      }
    }
  });
}

function editarAcuerdoR(id_acuerdoR,id_audiencia,carpeta_judicial,impuatdo, tipoC, acuerdoA, fechaEx, resumenA, status, comentariosA){
  $('#modalHistory').modal('hide');
  $('#modalAcuerdoR_E').modal('show');

  //Rellenar datos
  $('#CarpetaF_E').val(carpeta_judicial);
  $('#cmp_id_audiencia_AR_E').val(id_audiencia);
  $('#cmp_AcuerdoF_id_audiencia_E').val(id_acuerdoR);

  $('#cmp_imputado_AR_E  option[value='+ impuatdo +']').attr("selected",true);
  $('#cmp_estatus_AR_E option[value='+ status +']').attr("selected",true);
  $('#cmp_resumenAcuerdo_AR_E').val(resumenA);
  $('#cmp_tipoCumplimiento_AR_E option[value='+ tipoC +']').attr("selected",true);
  $('#cmp_apruebaAcuerdo_AR_E option[value='+ acuerdoA +']').attr("selected",true);
  $('#cmp_fehcaExtincion_AR_E').val(fechaEx);
  $('#cmp_comentariosAdicionales_AR_E').val(comentariosA);
}

function actualizar_AcuerdoR(){
  id_acuerdoR = $('#cmp_AcuerdoF_id_audiencia_E').val();
  id_audiencia = $('#cmp_id_audiencia_AR_E').val();
  carpeta_judicial = $('#CarpetaF_E').val();

  impuatdo = $('#cmp_imputado_AR_E').val();
  tipoC = $('#cmp_tipoCumplimiento_AR_E').val();
  acuerdoA = $('#cmp_apruebaAcuerdo_AR_E').val();
  fechaEx = $('#cmp_fehcaExtincion_AR_E').val();
  resumenA = $('#cmp_resumenAcuerdo_AR_E').val();
  status = $('#cmp_estatus_AR_E').val();
  comentariosA = $('#cmp_comentariosAdicionales_AR_E').val();
  
  $.ajax({
    type:'post',
    url:'/public/actualizar_AcuerdoR',
    data:{
      "id_audiencia_acuerdo_reparatorio":id_acuerdoR,
      "carpeta_judicial": carpeta_judicial,
      "id_audiencia":id_audiencia,
      "id_imputado":impuatdo,
      "resumen_acuerdo":resumenA,
      "tipo_cumplimiento":tipoC,
      "aprueba_acuerdo":acuerdoA,
      "fecha_extincion":fechaEx,
      "comentarios_adicionales":comentariosA,
      "estatus":status
    },
    success:function(response) {
      body = '';
      if(response.status==100){
        $('#modalAcuerdoR_E').modal('hide');
        var exito = "<p class='mg-b-20 mg-x-20'>El Acuerdo Reparatorio "+id_acuerdoR+ " Fue actualizado </p>";
        modal_success(exito,'modalHistory');
        obtener_AcuerdosR(carpeta_judicial,'primera');
      }else{
        $('#modalAcuerdoR_E').modal('hide');
        var error = "<p class='mg-b-20 mg-x-20'>"+response.message+"</p>";
        modal_error(error,'modalHistory');
      }
    }
  });
}

function leeDocumentoAcuerdoR (input) {
    let acepted_files=["pdf","png","jpg","docx","doc"];

    let file = $('#acuerdoPDF').val();
    let ext = "";
    let extension = "";
    let nombre_documento = "";

    if(file.length){
     extension = file.split('.')[1];
     extension = extension.toLowerCase();
     nombre_documento = (file.split('\\')[2]).split('.')[0];
     nombre_documento = nombre_documento.replaceAll(' ', '_');
     nombre_documento = nombre_documento.replaceAll('  ', '_');
     if(extension!=''){
        if( !acepted_files.includes(extension) ){
          modal_error('Solo puede adjutar archivos PDF, PNG, JPG, DOC o DOCX','modalAdministracion');
          $('#acuerdoPDF').val('');
          return false
        }else{
          if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = e=> {
              newDA = {
                'b64' : e.target.result.split('base64,')[1],
                'nombre_archivo' : nombre_documento,
                'tamanio_archivo': input.files[0].size,
                'extension_archivo' : extension,
                'tipo_data': get_tipo_data(extension),
              };
            }
            reader.readAsDataURL(input.files[0]); 
          }
          setTimeout(function(){ pintar_documento_acuerdoR(); },500);
        }
      }
    }else{
      return false;
    }
}

function pintar_documento_acuerdoR(){

    $('#divViewDocumentosAcuerdo div').remove();
    
    let reader_files=["pdf","png","jpg"];

    documento = newDA;

    if ( reader_files.includes(documento.extension_archivo) ) { 
      $('#divViewDocumentosAcuerdo').append(`
        <div class="col-lg-12" align="center">
          <object height="300px" ${ documento.extension_archivo=="pdf"?'width="100%"' : ''} class="mg-t-25" data="${documento.tipo_data+documento.b64}"></object>
        </div>
      `);    
    }else{
      $('#divViewDocumentosAcuerdo').append(`
        <div class="col-lg-12" align="center">
          ${getIcon(documento.extension_archivo)}
        </div>
      `);
    }

    $("#nombre_documento_acuerdo").val( documento.nombre_archivo );  

    $("#col_nombre_documento_acuerdo").removeClass('d-none');
    $("#col_nombre_documento_acuerdo").focus();
}

function get_tipo_data( extension ){
  if( extension == 'pdf' ) return 'data:application/pdf;base64,';
  if( extension == 'jpg' ) return 'data:image/jpeg;base64,';
  if( extension == 'png' ) return 'data:image/png;base64,';
  if( extension == 'doc' ) return '';
  if( extension == 'docx' ) return '';
  else return '';
}

function resetform() {
     $("#frm_add_AcuerdoR select").each(function() { this.selectedIndex = 0 });
     $("#frm_add_AcuerdoR input[type=text] , form textarea").each(function() { this.value = '' });
     $('#divViewDocumentosAcuerdo').css('display', 'none');
     $('#col_nombre_documento_acuerdo').css('display', 'none');
}


{{--  Medidas Cautelares  --}}

function obtener_MedidaC(folio,pagina_accion){
  rellenarImputadosMedidas(folio,'cmp_medidaC_imputado');
  rellenarImputadosMedidas(folio,'cmp_medidaC_imputado_E');
  obtener_MedidasCautelares('cmp_medidaC_medida');
  obtener_MedidasCautelares('cmp_medidaC_medida_E');
    //paginacion
    pagina=parseInt($('#pagina_actual_medidac').val(), 10);
    registros_por_pagina=10;
    if(pagina_accion=="primera"){
        pagina=1;
    }
    else if(pagina_accion=="avanzar"){
        pagina=pagina+1;
    }
    else if(pagina_accion=="atras"){
        pagina=pagina-1;
    }
    else if(pagina_accion=="ultima"){
        pagina=$('#paginas_totales_medidac').val();
    }
    if(pagina<=0 || pagina>$('#paginas_totales_medidac').val()){

    }else{
      //asignacion de la paginacion
      $('#pagina_actual_medidac').val(pagina);
      $('#numeropagina_medidac').val(pagina);
      $('.pagina_actual_texto_medidac').html(pagina);
      $('.pagina_total_texto_medidac').html($('#paginas_totales_medidac').val());
      //Consulta al servicio
        $.ajax({
          type:'post',
          url:'/public/obtener_MedidaC',
          data:{
            "no_carpeta_judicial": folio,
            registros_por_pagina:registros_por_pagina,
            pagina:$("#pagina_actual_medidac").val(),
          },
          success:function(response) {
            body = '';

            if(response.status==100){

              $('.pagina_total_texto_medidac').html(response.response_pag['paginas_totales']);
              $('#paginas_totales_medidac').val(response.response_pag['paginas_totales']);

                var datas = response.response;
                console.log(datas);
                for (var j = 0; j < datas.length; j++) {
                  if(datas[j]['estatus'] == 1){
                    color = 'green';
                    estado = 'Activo';
                  }else{
                    color= 'red';
                    estado = 'Inactivo';
                  }

                  body += `<tr>
                              <td> <i class="fas fa-edit acciones2" data-toggle="tooltip-primary" data-placement="top" title="Editar resolutivo" onclick="cargarCamposEditarMedidaC(${datas[j]['id_audiencia_medida_cautelar']},${datas[j]['id_audiencia']},'${datas[j]['folio_carpeta']}', ${datas[j]['tipo_resultado']}, ${datas[j]['id_imputado']}, ${datas[j]['id_medida_cautelar']} , '${datas[j]['especificaciones_medida_cautelar']}' , '${datas[j]['autoridad_presentarse']}', ${datas[j]['monto_garantia']},  ${datas[j]['no_pagos']}, ${datas[j]['estatus']})"></i></td> 
                              <td> ${datas[j]['imputado']}            </td>
                              <td> ${datas[j]['id_medida_cautelar']}   </td> 
                              <td> ${datas[j]['especificaciones_medida_cautelar']} </td>
                              <td style="color:${color};">${estado}   </td>
                            </tr>`;
                }
                $("#body-table4").html(body);
                
            }else{
              body = body.concat('<tr><td colspan="6">No existen registros</td></tr>');
              $("#body-table4").html(body);
            }
          }
        });
      }
}

function obtener_MedidasCautelares(medida){

  $.ajax({
    type:'post',
    url:'/public/obtener_MedidasCautelares',
    data:{
    },
    success:function(response) {
      body = '';
      if(response.status==100){
          var datas = response.response;
          console.log(datas);
          body='<option value="">Seleccione Medida Cautelar</option>';
          for (var j = 0; j < datas.length; j++) {
            body += `<option value="${datas[j]['id_medida_c']}" data-tipo="${datas[j]['es_sancion_economica']}">${datas[j]['tipo_medida_cautelar']}</option>`;
          }
        $("#"+medida).html(body);

      }else{
        body = body.concat('<option value="-">Seleccione un resolutivo</option>');
        $("#"+medida).html(body);

      }
    }
  });
}

function agregarMedidaC(folio,id_audiencia){
  resetformCautelar();
  $('#modalHistory').modal('hide');
  $('#modalMedidasCautelares').modal('show');
  $('#cmp_medidaC_folioC').val(folio);
  $('#cmp_medidaC_id_audiencia').val(id_audiencia);
}

function elegir_menu_cautelar(id){
  menu = $('option:selected', id).attr('data-tipo');

  if(menu == 1){
    $('#medidaC_menu1').css('display', 'block');
    $('#medidaC_menu2').css('display', 'none');
  }else if(menu == 2){
    $('#medidaC_menu1').css('display', 'none');
    $('#medidaC_menu2').css('display', 'block');
  }else if(menu == 0){
    $('#medidaC_menu1').css('display', 'none');
    $('#medidaC_menu2').css('display', 'none');
  }

}

function guardarMedidaC(){
  CarpetaF = $('#cmp_medidaC_folioC').val();
  cmp_medidaC_id_audiencia =  $('#cmp_medidaC_id_audiencia').val();

  tipo_cautelar = $('select[name="cmp_medidaC_medida"] option:selected').attr('data-tipo');
  cmp_medidaC_imputado = $('#cmp_medidaC_imputado').val();
  cmp_medidaC_medida = $('#cmp_medidaC_medida').val();
  cmp_medidaC_comentarios = $('#cmp_medidaC_comentarios').val();

  if(tipo_cautelar == 2){
    cmp_medidaC_autoridad = $('#cmp_medidaC_autoridad').val();
   }else{
    cmp_medidaC_autoridad = null;
   }

  if(tipo_cautelar == 1){
    cmp_medidaC_garantia = $('#cmp_medidaC_garantia').val();
    cmp_medidaC_pagos = $('#cmp_medidaC_pagos').val();
   }else{
    cmp_medidaC_garantia = null;
    cmp_medidaC_pagos = null;
   }

  $.ajax({
    type:'post',
    url:'/public/guardarMedidaC',
    data:{
      "carpeta_judicial": CarpetaF,
      "id_audiencia":cmp_medidaC_id_audiencia,
      "id_imputado":cmp_medidaC_imputado,
      "id_medida_cautelar":cmp_medidaC_medida,
      "tipo_resultado":tipo_cautelar,
      "monto_garantia":cmp_medidaC_garantia,
      "no_pagos":cmp_medidaC_pagos,
      "autoridad_presentarse":cmp_medidaC_autoridad,
      "especificaciones_medida_cautelar":cmp_medidaC_comentarios

    },
    success:function(response) {
      body = '';
      if(response.status==100){
        $('#modalMedidasCautelares').modal('hide');
        var exito = "<p class='mg-b-20 mg-x-20'>La medida cautelar "+cmp_medidaC_medida+" Fue agregado </p>";
        modal_success(exito,'modalHistory');
        obtener_MedidaC(CarpetaF,'primera');
        resetformCautelar()
      }else{
        $('#modalMedidasCautelares').modal('hide');
        var error = "<p class='mg-b-20 mg-x-20'>"+response.message+"</p>";
        modal_error(error,'modalHistory');
      }
    }
  });
}

function cargarCamposEditarMedidaC(cmp_medidaC_id_audiencia_medida_cautelar_E,id_audiencia, CarpetaF, tipo_cautelar, id_imputado, id_medida_cautelar, especificaciones_medida_cautelar ,autoridad_presentarse, monto_garantia, numero_pagos, estatus){
  $('#cmp_medidaC_folioC_E').val(CarpetaF);
  $('#cmp_medidaC_id_audiencia_E').val(id_audiencia);
  $('#cmp_medidaC_id_audiencia_medida_cautelar_E').val(cmp_medidaC_id_audiencia_medida_cautelar_E)

  $('#cmp_medidaC_imputado_E  option[value='+ id_imputado +']').attr("selected",true);
  $('#cmp_medidaC_medida_E  option[value='+ id_medida_cautelar +']').attr("selected",true);
  $('#cmp_medidaC_comentarios_E').val(especificaciones_medida_cautelar);
  $('#cmp_medidaC_estatus_E  option[value='+ estatus +']').attr("selected",true);

  switch (tipo_cautelar){

    case 1: 
      $('#cmp_medidaC_garantia_E').val(monto_garantia);
      $('#cmp_medidaC_pagos_E').val(numero_pagos);
      $('div#medidaC_menu1_E').css('display', 'block');
      break;
    
    case 2: 
      $('#cmp_medidaC_autoridad_E  option[value='+ autoridad_presentarse +']').attr("selected",true);
      $('div#medidaC_menu2_E').css('display', 'block');
      break;
  }


  $('#modalMedidasCautelares_E').modal('show');
  $('#modalHistory').modal('hide');
}

function actualizar_MedidaC(){
  CarpetaF = $('#cmp_medidaC_folioC_E').val();
  cmp_medidaC_id_audiencia_E =  $('#cmp_medidaC_id_audiencia_E').val();
  cmp_medidaC_id_audiencia_medida_cautelar_E = $('#cmp_medidaC_id_audiencia_medida_cautelar_E').val();

  tipo_cautelar = $('select[name="cmp_medidaC_medida_E"] option:selected').attr('data-tipo');
  cmp_medidaC_imputado = $('#cmp_medidaC_imputado_E').val();
  cmp_medidaC_medida = $('#cmp_medidaC_medida_E').val();
  cmp_medidaC_comentarios = $('#cmp_medidaC_comentarios_E').val();
  cmp_medidaC_estatus_E = $('#cmp_medidaC_estatus_E').val();

  if(tipo_cautelar == 2){
    cmp_medidaC_autoridad = $('#cmp_medidaC_autoridad_E').val();
   }else{
    cmp_medidaC_autoridad = null;
   }

  if(tipo_cautelar == 1){
    cmp_medidaC_garantia = $('#cmp_medidaC_garantia_E').val();
    cmp_medidaC_pagos = $('#cmp_medidaC_pagos_E').val();
   }else{
    cmp_medidaC_garantia = null;
    cmp_medidaC_pagos = null;
   }

  $.ajax({
    type:'post',
    url:'/public/actualizar_MedidaC',
    data:{
      "id_audiencia_medida_cautelar":cmp_medidaC_id_audiencia_medida_cautelar_E,
      "id_audiencia":cmp_medidaC_id_audiencia_E,
      "id_imputado":cmp_medidaC_imputado,
      "id_medida_cautelar":cmp_medidaC_medida,
      "folio_carpeta":CarpetaF,
      "tipo_resultado":tipo_cautelar,
      "monto_garantia":cmp_medidaC_garantia,
      "no_pagos":cmp_medidaC_pagos,
      "autoridad_presentarse":cmp_medidaC_autoridad,
      "especificaciones_medida_cautelar":cmp_medidaC_comentarios,
      "estatus":cmp_medidaC_estatus_E
    },
    success:function(response) {
      body = '';
      if(response.status==100){
        $('#modalMedidasCautelares_E').modal('hide');
        var exito = "<p class='mg-b-20 mg-x-20'>La medida cautelar "+cmp_medidaC_medida+" Fue Actualizada </p>";
        modal_success(exito,'modalHistory');
        obtener_MedidaC(CarpetaF,'primera');
        resetformCautelar();
      }else{
        $('#modalMedidasCautelares_E').modal('hide');
        var error = "<p class='mg-b-20 mg-x-20'>"+response.message+"</p>";
        modal_error(error,'modalHistory');
      }
    }
  });

}

function resetformCautelar() {
  $("#frm_medidasC select").each(function() { this.selectedIndex = 0 });
  $("#frm_medidasC input[type=text] , form textarea").each(function() { this.value = '' });

  $("#frm_medidasC_E select").each(function() { this.selectedIndex = 0 });
  $("#frm_medidasC_E input[type=text] , form textarea").each(function() { this.value = '' });
}
{{--  Funcion Compratida  --}}
function rellenarImputadosMedidas(folio, imputado){
  $.ajax({
    type:'post',
    url:'/public/consultar_carpetas_judiciales',
    data:{
      "no_carpeta_judicial": folio
    },
    success:function(response) {
      body = '';
      optionImputados = '';

      if(response.status==100){
          var datas = response.response;
          console.log(datas);
          optionImputados='<option value="">Seleccione imputado</option>';
        for (var i = 0; i < datas.length; i++) {
          for(var m = 0; m < datas[i]['imputados'].length; m++){
            optionImputados+= `<option value="${datas[i]['imputados'][m]['id_persona']}">${datas[i]['imputados'][m]['nombre']}</option>`;
          }
        }

        $('#'+imputado).html(optionImputados);

      }else{
        optionImputados='<option value="">Seleccione imputado</option>';

        $('#'+imputado).html(optionImputados);

      }
    }
  });
}


{{--  Medidas Proteccion  --}}

function obtener_MedidaP(folio,pagina_accion){
  rellenarImputadosMedidas(folio,'cmp_medidaP_imputado');
  rellenarImputadosMedidas(folio,'cmp_medidaP_imputado_E');
  obtener_MedidasProteccion('cmp_medidaP_medida');
  obtener_MedidasProteccion('cmp_medidaP_medida_E');
    //paginacion
    pagina=parseInt($('#pagina_actual_medidap').val(), 10);
    registros_por_pagina=10;
    if(pagina_accion=="primera"){
        pagina=1;
    }
    else if(pagina_accion=="avanzar"){
        pagina=pagina+1;
    }
    else if(pagina_accion=="atras"){
        pagina=pagina-1;
    }
    else if(pagina_accion=="ultima"){
        pagina=$('#paginas_totales_medidap').val();
    }
    if(pagina<=0 || pagina>$('#paginas_totales_medidap').val()){

    }else{
      //asignacion de la paginacion
      $('#pagina_actual_medidap').val(pagina);
      $('#numeropagina_medidap').val(pagina);
      $('.pagina_actual_texto_medidap').html(pagina);
      $('.pagina_total_texto_medidap').html($('#paginas_totales_medidap').val());
      //Consulta al servicio
      $.ajax({
        type:'post',
        url:'/public/obtener_MedidaP',
        data:{
          "no_carpeta_judicial": folio,
           registros_por_pagina:registros_por_pagina,
           pagina:$("#pagina_actual_medidap").val(),
        },
        success:function(response) {
          body = '';

          if(response.status==100){

            $('.pagina_total_texto_medidap').html(response.response_pag['paginas_totales']);
            $('#paginas_totales_medidap').val(response.response_pag['paginas_totales']);

              var datas = response.response;
              console.log(datas);
              for (var j = 0; j < datas.length; j++) {

                  if(datas[j]['estatus'] == 1){
                    color = 'green';
                    estado = 'Activo';
                  }else{
                    color= 'red';
                    estado = 'Inactivo';
                  }

                  body += `<tr>
                              <td> <i class="fas fa-edit acciones2" data-toggle="tooltip-primary" data-placement="top" title="Editar resolutivo" onclick="cargarCamposEditarMedidaP(${datas[j]['id_audiencia_mproteccion_csuspension']},${datas[j]['id_audiencia']},'${datas[j]['folio_carpeta']}', ${datas[j]['id_imputado']}, ${datas[j]['id_medida_proteccion']} , '${datas[j]['especificaciones']}' , ${datas[j]['estatus']})"></i></td> 
                              <td> ${datas[j]['imputado']}            </td>
                              <td> ${datas[j]['id_medida_proteccion']}   </td> 
                              <td> ${datas[j]['especificaciones']} </td>
                              <td style="color:${color};">${estado}   </td>
                            </tr>`;
              }
              $("#body-table5").html(body);
              
          }else{
            body = body.concat('<tr><td colspan="6">No existen registros</td></tr>');
            $("#body-table5").html(body);
          }
        }
      });
    }

}

function obtener_MedidasProteccion(medida){

  $.ajax({
    type:'post',
    url:'/public/obtener_MedidasProteccion',
    data:{
    },
    success:function(response) {
      body = '';
      if(response.status==100){
          var datas = response.response;
          console.log(datas);
          body='<option value="">Seleccione Medida Proteccion</option>';
          for (var j = 0; j < datas.length; j++) {
            body += `<option value="${datas[j]['id_medida_p']}" >${datas[j]['medida_proteccion']}</option>`;
          }
        $("#"+medida).html(body);

      }else{
        body = body.concat('<option value="">Seleccione Medida Proteccion</option>');
        $("#"+medida).html(body);

      }
    }
  });
}

function agregarMedidaP(folio, id_audiencia){
  resetformProteccion();
  $('#modalHistory').modal('hide');
  $('#modalMedidasProteccion').modal('show');
  $('#cmp_medidaP_folioC').val(folio);
  $('#cmp_medidaP_id_audiencia').val(id_audiencia);
}

function guardarMedidaP(){
  cmp_medidaP_folioC = $('#cmp_medidaP_folioC').val();
  cmp_medidaP_id_audiencia =  $('#cmp_medidaP_id_audiencia').val();
  cmp_medidaP_bandera = $('#cmp_medidaP_bandera').val();
  cmp_medidaP_imputado = $('#cmp_medidaP_imputado').val();
  cmp_medidaP_medida = $('#cmp_medidaP_medida').val();
  cmp_medidaP_comentarios = $('#cmp_medidaP_comentarios').val();
  id_condicion_suspencion = null;

  $.ajax({
    type:'post',
    url:'/public/guardarMedidaP',
    data:{
      "id_imputado":cmp_medidaP_imputado,
      "id_medida_proteccion":cmp_medidaP_medida,
      "id_condicion_suspencion":id_condicion_suspencion,
      "folio_carpeta":cmp_medidaP_folioC,
      "especificaciones":cmp_medidaP_comentarios,
      "bandera":cmp_medidaP_bandera,
      "id_audiencia":cmp_medidaP_id_audiencia
    },
    success:function(response) {
      body = '';
      if(response.status==100){
        $('#modalMedidasProteccion').modal('hide');
        var exito = "<p class='mg-b-20 mg-x-20'>La medida de proteccion "+cmp_medidaP_medida+" Fue agregado </p>";
        modal_success(exito,'modalHistory');
        obtener_MedidaP(cmp_medidaP_folioC,'primera');
        resetformProteccion()
      }else{
        $('#modalMedidasProteccion').modal('hide');
        var error = "<p class='mg-b-20 mg-x-20'>"+response.message+"</p>";
        modal_error(error,'modalHistory');
      }
    }
  });
  
}

function cargarCamposEditarMedidaP(id_audiencia_mproteccion_csuspension,id_audiencia,folio_carpeta,id_imputado,id_medida_proteccion, especificaciones, estatus){
  $('#cmp_medidaP_folioC_E').val(folio_carpeta);
  $('#cmp_medidaP_id_audiencia_E').val(id_audiencia);
  $('#cmp_medidaP_id_audiencia_medida_cautelar_E').val(id_audiencia_mproteccion_csuspension)
  

  $('#cmp_medidaP_imputado_E  option[value='+ id_imputado +']').attr("selected",true);
  $('#cmp_medidaP_medida_E  option[value='+ id_medida_proteccion +']').attr("selected",true);
  $('#cmp_medidaP_comentarios_E').val(especificaciones);
  $('#cmp_medidaP_estatus_E  option[value='+ estatus +']').attr("selected",true);


  $('#modalMedidasProteccion_E').modal('show');
  $('#modalHistory').modal('hide');
}

function actualizar_MedidaP(){
  cmp_medidaP_folioC_E = $('#cmp_medidaP_folioC_E').val();
  cmp_medidaP_id_audiencia_E =  $('#cmp_medidaP_id_audiencia_E').val();
  cmp_medidaP_id_audiencia_medida_cautelar_E = $('#cmp_medidaP_id_audiencia_medida_cautelar_E').val();
  cmp_medidaP_bandera_E = $('#cmp_medidaP_bandera_E').val();

  cmp_medidaP_imputado_E = $('#cmp_medidaP_imputado_E').val();
  cmp_medidaP_medida_E = $('#cmp_medidaP_medida_E').val();
  cmp_medidaP_comentarios_E = $('#cmp_medidaP_comentarios_E').val();
  cmp_medidaP_estatus_E = $('#cmp_medidaP_estatus_E').val();


  $.ajax({
    type:'post',
    url:'/public/actualizar_MedidaP',
    data:{
      "id_audiencia_mproteccion_csuspension":cmp_medidaP_id_audiencia_medida_cautelar_E,
      "id_imputado":cmp_medidaP_imputado_E,
      "id_medida_proteccion":cmp_medidaP_medida_E,
      "id_condicion_suspencion":"",
      "folio_carpeta":cmp_medidaP_folioC_E,
      "especificaciones":cmp_medidaP_comentarios_E,
      "bandera":cmp_medidaP_bandera_E,
      "estatus":cmp_medidaP_estatus_E,
      "id_audiencia":cmp_medidaP_id_audiencia_E,
    },
    success:function(response) {
      body = '';
      if(response.status==100){
        $('#modalMedidasProteccion_E').modal('hide');
        var exito = "<p class='mg-b-20 mg-x-20'>La medida cautelar "+cmp_medidaP_medida_E+" Fue Actualizada </p>";
        modal_success(exito,'modalHistory');
        obtener_MedidaP(cmp_medidaP_folioC_E,'primera');
        resetformProteccion();
      }else{
        $('#modalMedidasProteccion_E').modal('hide');
        var error = "<p class='mg-b-20 mg-x-20'>"+response.message+"</p>";
        modal_error(error,'modalHistory');
      }
    }
  });
  
}

function resetformProteccion() {
  $("#frm_medidasP select").each(function() { this.selectedIndex = 0 });
  $("#frm_medidasP input[type=text] , form textarea").each(function() { this.value = '' });

  $("#frm_medidasP_E select").each(function() { this.selectedIndex = 0 });
  $("#frm_medidasP_E input[type=text] , form textarea").each(function() { this.value = '' });
}

{{--  Condiciones de de suspension de proceso  --}}
function obtener_CondicionS(folio,pagina_accion){
  rellenarImputadosMedidas(folio,'cmp_condicionS_imputado');
  rellenarImputadosMedidas(folio,'cmp_condicionS_imputado_E');
  obtener_CondicionesSuspension('cmp_condicionS_medida');
  obtener_CondicionesSuspension('cmp_condicionS_medida_E');
    //paginacion
    pagina=parseInt($('#pagina_actual_condicions').val(), 10);
    registros_por_pagina=10;
    if(pagina_accion=="primera"){
        pagina=1;
    }
    else if(pagina_accion=="avanzar"){
        pagina=pagina+1;
    }
    else if(pagina_accion=="atras"){
        pagina=pagina-1;
    }
    else if(pagina_accion=="ultima"){
        pagina=$('#paginas_totales_condicions').val();
    }
    if(pagina<=0 || pagina>$('#paginas_totales_condicions').val()){

    }else{
      //asignacion de la paginacion
      $('#pagina_actual_condicions').val(pagina);
      $('#numeropagina_condicions').val(pagina);
      $('.pagina_actual_texto_condicions').html(pagina);
      $('.pagina_total_texto_condicions').html($('#paginas_totales_condicions').val());
      //Consulta al servicio
      $.ajax({
        type:'post',
        url:'/public/obtener_CondicionS',
        data:{
          "no_carpeta_judicial": folio,
          registros_por_pagina:registros_por_pagina,
          pagina:$("#pagina_actual_condicions").val(),
        },
        success:function(response) {
          body = '';
          if(response.status==100){

            $('.pagina_total_texto_condicions').html(response.response_pag['paginas_totales']);
            $('#paginas_totales_condicions').val(response.response_pag['paginas_totales']);

              var datas = response.response;
              console.log(datas);
              for (var j = 0; j < datas.length; j++) {

                  if(datas[j]['estatus'] == 1){
                    color = 'green';
                    estado = 'Activo';
                  }else{
                    color= 'red';
                    estado = 'Inactivo';
                  }

                  body += `<tr>
                              <td> <i class="fas fa-edit acciones2" data-toggle="tooltip-primary" data-placement="top" title="Editar resolutivo" onclick="cargarCamposEditarCondicionS(${datas[j]['id_audiencia_mproteccion_csuspension']},${datas[j]['id_audiencia']},'${datas[j]['folio_carpeta']}', ${datas[j]['id_imputado']}, ${datas[j]['id_condicion_suspencion']} , '${datas[j]['especificaciones']}' , ${datas[j]['estatus']})"></i></td> 
                              <td> ${datas[j]['imputado']}            </td>
                              <td> ${datas[j]['id_condicion_suspencion']}   </td> 
                              <td> ${datas[j]['especificaciones']} </td>
                              <td style="color:${color};">${estado}   </td>
                            </tr>`;
              }

              $("#body-table6").html(body);
              
          }else{
            body = body.concat('<tr><td colspan="6">No existen registros</td></tr>');
            $("#body-table6").html(body);
          }
        }
      });
    }
}

function obtener_CondicionesSuspension(medida){

  $.ajax({
    type:'post',
    url:'/public/obtener_CondicionesSuspension',
    data:{
    },
    success:function(response) {
      body = '';
      if(response.status==100){
          var datas = response.response;
          console.log(datas);
          body='<option value="">Seleccione Condicion de Suspensión</option>';
          for (var j = 0; j < datas.length; j++) {
            body += `<option value="${datas[j]['id_condicion_s']}">${datas[j]['nombre_condicion']}</option>`;
          }
        $("#"+medida).html(body);

      }else{
        body = body.concat('<option value="">Seleccione Condicion de Suspensión</option>');
        $("#"+medida).html(body);

      }
    }
  });
}

function agregarCondicionS(folio, id_audiencia){
  resetformCondicionS();
  $('#modalHistory').modal('hide');
  $('#modalCondicionS').modal('show');
  $('#cmp_condicionS_folioC').val(folio);
  $('#cmp_condicionS_id_audiencia').val(id_audiencia);
}

function guardarCondicionS(){
  cmp_condicionS_folioC = $('#cmp_condicionS_folioC').val();
  cmp_condicionS_id_audiencia =  $('#cmp_condicionS_id_audiencia').val();
  cmp_condicionS_bandera = $('#cmp_condicionS_bandera').val();
  cmp_condicionS_imputado = $('#cmp_condicionS_imputado').val();
  cmp_condicionS_medida = $('#cmp_condicionS_medida').val();
  cmp_condicionS_comentarios = $('#cmp_condicionS_comentarios').val();
  id_condicion_proteccion = null;

  $.ajax({
    type:'post',
    url:'/public/guardarMedidaP',
    data:{
      "id_imputado":cmp_condicionS_imputado,
      "id_medida_proteccion":id_condicion_proteccion,
      "id_condicion_suspencion":cmp_condicionS_medida,
      "folio_carpeta":cmp_condicionS_folioC,
      "especificaciones":cmp_condicionS_comentarios,
      "bandera":cmp_condicionS_bandera,
      "id_audiencia":cmp_condicionS_id_audiencia
    },
    success:function(response) {
      body = '';
      if(response.status==100){
        $('#modalCondicionS').modal('hide');
        var exito = "<p class='mg-b-20 mg-x-20'>La condicion de proceso de suspencion "+cmp_condicionS_medida+" Fue agregada </p>";
        modal_success(exito,'modalHistory');
        obtener_CondicionS(cmp_condicionS_folioC,'primera');
        resetformCondicionS();
      }else{
        $('#modalCondicionS').modal('hide');
        var error = "<p class='mg-b-20 mg-x-20'>"+response.message+"</p>";
        modal_error(error,'modalHistory');
      }
    }
  });
}

function cargarCamposEditarCondicionS(id_audiencia_mproteccion_csuspension,id_audiencia,folio_carpeta,id_imputado,id_medida_suspension, especificaciones, estatus){
  $('#cmp_condicionS_folioC_E').val(folio_carpeta);
  $('#cmp_condicionS_id_audiencia_E').val(id_audiencia);
  $('#cmp_condicionS_id_audiencia_medida_cautelar_E').val(id_audiencia_mproteccion_csuspension);
  

  $('#cmp_condicionS_imputado_E  option[value='+ id_imputado +']').attr("selected",true);
  $('#cmp_condicionS_medida_E  option[value='+ id_medida_suspension +']').attr("selected",true);
  $('#cmp_condicionS_comentarios_E').val(especificaciones);
  $('#cmp_condicionS_estatus_E  option[value='+ estatus +']').attr("selected",true);

  $('#modalCondicionS_E').modal('show');
  $('#modalHistory').modal('hide');
}

function actualizar_CondicionS(){
  cmp_condicionS_folioC_E = $('#cmp_condicionS_folioC_E').val();
  cmp_condicionS_id_audiencia_E =  $('#cmp_condicionS_id_audiencia_E').val();
  cmp_condicionS_id_audiencia_medida_cautelar_E = $('#cmp_condicionS_id_audiencia_medida_cautelar_E').val();
  cmp_condicionS_bandera_E = $('#cmp_condicionS_bandera_E').val();

  cmp_condicionS_imputado_E = $('#cmp_condicionS_imputado_E').val();
  cmp_condicionS_medida_E = $('#cmp_condicionS_medida_E').val();
  cmp_condicionS_comentarios_E = $('#cmp_condicionS_comentarios_E').val();
  cmp_condicionS_estatus_E = $('#cmp_condicionS_estatus_E').val();


  $.ajax({
    type:'post',
    url:'/public/actualizar_MedidaP',
    data:{
      "id_audiencia_mproteccion_csuspension":cmp_condicionS_id_audiencia_medida_cautelar_E,
      "id_imputado":cmp_condicionS_imputado_E,
      "id_medida_proteccion":"",
      "id_condicion_suspencion":cmp_condicionS_medida_E,
      "folio_carpeta":cmp_condicionS_folioC_E,
      "especificaciones":cmp_condicionS_comentarios_E,
      "bandera":cmp_condicionS_bandera_E,
      "estatus":cmp_condicionS_estatus_E,
      "id_audiencia":cmp_condicionS_id_audiencia_E,
    },
    success:function(response) {
      body = '';
      if(response.status==100){
        $('#modalCondicionS_E').modal('hide');
        var exito = "<p class='mg-b-20 mg-x-20'>La condicion de proceso de suspencion "+cmp_condicionS_medida_E+" Fue Actualizada </p>";
        modal_success(exito,'modalHistory');
        obtener_CondicionS(cmp_condicionS_folioC_E,'primera');
        resetformCondicionS();
      }else{
        $('#modalCondicionS_E').modal('hide');
        var error = "<p class='mg-b-20 mg-x-20'>"+response.message+"</p>";
        modal_error(error,'modalHistory');
      }
    }
  });
}

function resetformCondicionS() {
  $("#frm_condicionS select").each(function() { this.selectedIndex = 0 });
  $("#frm_condicionS input[type=text] , form textarea").each(function() { this.value = '' });

  $("#frm_condicionS_E select").each(function() { this.selectedIndex = 0 });
  $("#frm_condicionS_E input[type=text] , form textarea").each(function() { this.value = '' });
}









  /**************
   *
   * FUNCIONES PARA EVENTOS EN CALEDARIO
   *
   * ***********/


  // scheduler.templates.event_class = function(start,end,ev){
  //   return "event_bkg_"+ev.color;
  // };

  // scheduler.attachEvent("onCellDblClick", function (x_ind, y_ind, x_val, y_val, e){
  //   return false;
  // });

  // function obtener_inmuebles(){
  //   $.ajax({
  //     method:'POST',
  //     url:'/public/obtener_inmuebles',
  //     async: false,
  //     success:function(response){
  //       console.log(response);
  //       if(response.status==100){
  //         return response;
  //       }else{
  //         modal_error(response.message,'modalAdministracion');
  //         return response;
  //       }
  //     },
  //     error : function( errors ){
  //       modal_error('Error :'+errors,'modalAdministracion');
  //       return {status:0, message:'Error al consumir servicio'};
  //     }
  //   });
  // }
</script>
