{{-- DOCUMENTOS ASOCIADOS--}}

  <style>
    /*
      Carpetas acumuladas
      {{--  #menu * { 
        list-style:none;
      }
      #menu li{ 
        line-height:180%;
      }
      #menu li a{
        color:#222; 
        text-decoration:none;
      }
      .cuadro:before{ 
        content:"\025AA"; 
        color:#ddd; 
        margin-right:4px;
      }
      #menu input[name="list"] {
        position: absolute;
        left: -1000em;
      }
      #menu label:before{ 
        content:"\025b8"; 
        margin-right:4px;
      }
      #menu input:checked ~ label:before{ 
        content:"\025be";
      }
      #menu .interior{
        display: none;
      }
      #menu input:checked ~ ul{
        display:block;
      }  --}}

    */

    .folders-tipos{
      list-style: none;
      margin: 0;
      padding: 0;
    }
    .navbarAcumSide{
      display: block;
      position: absolute;
      background: #fff;
      z-index: 1;
      top: 16%;
      left: 1%;
    }
    .wraper_navside{
      display: flex; 
      justify-content: space-between;
    }
    .carpetas_acumuladas_navbar{
      border: 1px solid #eee;
      width: 83px;
      padding: 4px;
    }
    .carpetas_acumuladas_navbar_none{
      display: none;
    }
    .divcontentall_part{
      width: calc(100% - 100px);
    }
    .divcontentall_all{
      width: 100%;
    }
    .icon_bars_s{
      font-size: 1.5em; 
      font-weight:bold; 
      word-break: break-word; 
      text-align: center; 
      margin-top: 5%; 
      color: #fff;
    }
    .carpetas_acumuladas_div_s{
      font-size: 0.9em; 
      font-weight:bold; 
      word-break: break-word; 
      text-align: center; 
      margin-bottom: 5%;
    }
    .folders-tipos > li{
      text-align: center;
      font-size: 2.3em;
      color: #848F33;
      margin: 20% 0;
      cursor: pointer;
      position: relative;
    }
    .globito_carp{
      width: 230px;
      height: 90px;
      position: absolute;
      background: #fff;
      padding: 4px;
      z-index: 1;
      border-top: 2px solid #eee;
      border-right: 2px solid #eee;
      border-bottom: 2px solid #eee;
      border-radius: 0 5px 5px 0px;
      top: 0;
      left: 105%;
      display: none;
    }
    .folders-tipos > li:hover > #globito_carp_rem{
      display: block;
    }
    .folders-tipos > li:hover > #globito_carp_asoc{
      display: block;
    }
    .folders-tipos > li:hover > #globito_carp_amp{
      display: block;
    }
    .folders-tipos > li:hover > #globito_carp_apel{
      display: block;
    }

    @media(max-width: 970px){
      .wraper_navside{
        flex-direction: column;
      }
      .carpetas_acumuladas_navbar{
        width: 100%;
        margin: 1% 0;
      }
      .folders-tipos{
        width: 100%;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(75px, 1fr));
      }
      .folders-tipos > li{
        margin: 1% 0;
      }
      .divcontentall_part{
        width: 100%;
      }
      .icon_bars_s{
        display: none;
      }
      .carpetas_acumuladas_div_s{
        margin-bottom: 2%;
      }
    }


    #modulo_documentos_asociados{
      padding: 0 1%;
      width: 100%;
    }
    #modulo_acumuladas{
      background: #fff;
      height: auto;
      width: 230px;
      transition: 2s all;
    }
    #brannd{
      width: 33px !important;
      justify-content: center;
      display: flex;
      align-items: center;
      font-size: 1.3em;
      color: #fff;
      background: #b0b781 !important;
      border: none;
      cursor: pointer;
    }
    #titleAccordionDocumentosAsociados{
      width: 100%;
    }
    .mostrar{
      display: block;
      transition: 2s all;
    }
    .hide{
      display: none;
      transition: 2s all;
    }
    .grande{
      width:100% !important;
      transition: 0.5s all;
    }
    #acum_rem_mobil{
      display: flex !important;
      justify-content: center; 
      visibility: hidden;
    }

    @media (max-width:768px){

      #modulo_acumuladas{
        width: 200px;
      }

    }

    @media (max-width:680px){
      #modulo_documentos_asociados{
        padding: 0 3%;
        width: 100%;
      }
      #modulo_acumuladas{
        display: none;
      }
      #acum_rem_mobil{
        visibility: visible;
      }

    }

  </style>

  <div class="form-layout">
    <div class="row mg-b-25">

      {{--
      <div id="modulo_acumuladas" class="mg-t-20">
        <div class="accordion" id="accordionExample">

          <div class="card">
            <div class="card-header" id="headingOne" style="background: #fff;">
              <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left"  style="color: #848F33;" type="button" data-toggle="collapse" data-target="#collapseuno" aria-expanded="true" aria-controls="collapseuno">
                  <i class="fas fa-folder"></i> Carpetas de Remisión
                </button>
              </h2>
            </div>
        
            <div id="collapseuno" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
              <div class="card-body">
                <ul class="interior"  style="padding-left: 10px; width:100%;">
                  <li style="list-style: none;">
                    <span id="li_padre1"></span>
                    <ul id="li_acumuladas1" style='list-style: none; width: 100%; font-size: 0.8em; padding: 10px 0px 10px 16px;'>
  
                    </ul>
                  </li>
                </ul>
              </div>
            </div>
          </div>

          <div class="card">
            <div class="card-header" id="headingTwo" style="background: #fff;">
              <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left collapsed" style="color: #848F33;"  type="button" data-toggle="collapse" data-target="#collapsedos" aria-expanded="false" aria-controls="collapsedos">
                  <i class="fas fa-folder"></i> Carpetas Asociadas
                </button>
              </h2>
            </div>
            <div id="collapsedos" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
              <div class="card-body">
              <ul class="interior"  style="padding-left: 10px; width:100%;">
                <li style="list-style: none;">
                  <span id="li_padre"></span>
                  <ul id="li_acumuladas" style='list-style: none; width: 100%; font-size: 0.8em; padding: 10px 0px 10px 16px;'>

                  </ul>
                </li>
              </ul>
              </div>
            </div>
          </div>

          <div class="card">
            <div class="card-header" id="headingThree" style="background: #fff;">
              <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left collapsed" style="color: #848F33;"  type="button" data-toggle="collapse" data-target="#collapsetres" aria-expanded="false" aria-controls="collapsetres">
                  <i class="fas fa-folder"></i> Carpetas Amparo
                </button>
              </h2>
            </div>
            <div id="collapsetres" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
              <div class="card-body">
              <ul class="interior"  style="padding-left: 10px; width:100%;">
                <li style="list-style: none;">
                  <span id="li_padre4"></span>
                  <ul id="li_acumuladas4" style='list-style: none; width: 100%; font-size: 0.8em; padding: 10px 0px 10px 16px;'>

                  </ul>
                </li>
              </ul>
              </div>
            </div>
          </div>

          <div class="card">
            <div class="card-header" id="headingFour" style="background: #fff;">
              <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left collapsed" style="color: #848F33;"  type="button" data-toggle="collapse" data-target="#collapsecuatro" aria-expanded="false" aria-controls="collapsecuatro">
                  <i class="fas fa-folder"></i> Carpetas Apelación
                </button>
              </h2>
            </div>
            <div id="collapsecuatro" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
              <div class="card-body">
              <ul class="interior"  style="padding-left: 10px; width:100%;">
                <li style="list-style: none;">
                  <span id="li_padre5"></span>
                  <ul id="li_acumuladas5" style='list-style: none; width: 100%; font-size: 0.8em; padding: 10px 0px 10px 16px;'>

                  </ul>
                </li>
              </ul>
              </div>
            </div>
          </div>


        </div>
      </div>
      --}}
      
      {{-- SECCION  DOCUMENTOS ASOCIADOS--}}
      <div id="modulo_documentos_asociados" class="mg-t-20">
        @if( isset($permisos[79]) and $permisos[79] == 1 )
          <div id="accordionDocumentosAsociados" class="accordion-one mg-b-10" role="tablist" aria-multiselectable="true" width="100%">
            <div class="card">
              <div class="card-header" role="tab" id="headingOne">
                <a id="titleAccordionDocumentosAsociados" data-toggle="collapse" data-parent="#accordionDocumentosAsociados" href="#collapseOneDocumentosAsociados" aria-expanded="true" aria-controls="collapseOneDocumentosAsociados" class="bkg-collapsed-btn tx-gray-800 transition collapsed tx-white">
                  Adjuntar Documento
                </a>
              </div><!-- card-header -->
              <div id="collapseOneDocumentosAsociados" class="collapse" role="tabpanel" aria-labelledby="headingOneDocumentosAsociados">
                <div class="card-body">
                  <div class="mg-t-15">
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <input type="hidden" id="idDocumentoRelacionado" name="idDocumentoRelacionado" value="">
                          <label class="form-control-label">Tipo de documento: <span class="tx-danger">*</span> </label>
                          <select class="form-control" id="tipo_documento" name="tipo_documento" autocomplete="off">
                            <option selected value="null">Elija una opción</option>
                            @foreach( $tipos_documento_carpeta as $tipo_documento )
                              <option value="{{$tipo_documento['id_documento']}}">{{$tipo_documento['nombre']}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>

                      <div class="col-lg-6 d-none" id="col_nombre_documento_asociado">
                        <div class="form-group">
                          <label class="form-control-label">Nombre documento: <span class="tx-danger">*</span> </label>
                          <input class="form-control" type="text" id="nombre_documento" name="nombre_documento" autocomplete="off">
                        </div>
                      </div>
                      
                      <div class="col-lg-12 d-none" id="col_audiencia_asociada-DA">
                        <div class="form-group">
                          <label class="form-control-label">Audiencia: <span class="tx-danger">*</span> </label>
                          <select class="form-control" id="audiencia_asociada-DA" name="audiencia_asociada-DA">
                          </select>
                        </div>
                      </div>
                    </div>

                    <div class="row d-none" id="row_documento_asociado">
                      <div class="col-lg-12">
                        <form onsubmit="return false;" id="cargarDocumentoAsociado" action="/" enctype="multipart/form-data">
                          <div class="custom-input-file">
                            <input type="file" id="archivoPDF" class="input-file" value="" name="archivoPDF" accept=".pdf" >
                            <h5 class="px-3 py-3">Arrastre hasta aquí su documento o de clic para adjuntarlo</h5>
                          </div>
                        </form>
                      </div>
                    </div>
                    <br><br>
                    <div class="row" id="divViewDocumentosAsociados">
                    </div>
                    <div class="col-lg-12 d-flex mg-t-5" id="botonesDocumentosAsociados">
                      <button type="button" class="btn btn-secondary d-inline-block btn-edicion mg-l-auto" id="cancelarDocumentoAsociado" onclick="limpiaFormularioDocumentosAsociados()">Cancelar</button>
                      <button class="btn btn-primary bd-0 d-inline-block ml-auto" id="agregarDocumentoAsociado" onclick="agregarDocumentoAsociado()">Agregar Documento</button>
                    </div>
                  </div>
                </div> <!-- CARD BODY -->
              </div> <!-- BODY COLLAPSE -->
            </div> <!-- CARD -->
          </div> <!-- ACCORDEON TODAS PARTES PROCESALES -->
        @endif
        <br>
        <h5 class="form-control-label">Documentos Asociados (<span style="font-size: 0.7em" id="carpetaActivaNavVar"></span>) </h5>


        <div class="form-group mg-t-20 col-lg-12">

          <label class="form-control-label mg-r-10">Seleccione vista:</label>

          <label class="rdiobox d-inline-block" onclick="showHide('.vista-tabla-DA', '.vista-previsualizacion-DA')">
            <input name="vista-DA" type="radio" checked value="tabla">
            <span>Tabla</span>
          </label>

          <label class="rdiobox d-inline-block mg-xs-l-20" onclick="showHide('.vista-previsualizacion-DA', '.vista-tabla-DA')">
            <input name="vista-DA" type="radio" value="preview">
            <span>Indice</span>
          </label>

        </div>

        <hr/>
        <div class="row vista-tabla-DA" id="divDocumentosAsociados">

          <div class="col-lg-4 mb-3">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Tipo Documento:</span>
              </div>
              <div class="col pl-0 pr-0">
                <select class="form-control" id="tipo_documento_buscar" name="tipo_documento_buscar" autocomplete="off">
                  <option selected value="-">Todos</option>
                  <option value="207">Acuerdo (Recepción de apelación)</option>
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
              <input class="form-control" type="text" id="nombre_documento_buscar" name="nombre_documento_buscar" autocomplete="off">
            </div>
          </div>

          <div class="col-lg-4 mb-3">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Extension:</span>
              </div>
              <div class="col pl-0 pr-0">
                <select class="form-control select2" id="extension_documento_buscar" name="extension_documento_buscar" autocomplete="off">
                  <option selected value="">TODAS</option>
                  <option value="doc">DOC</option>
                  <option value="docx">DOCX</option>
                  <option value="jpeg">JPEG</option>
                  <option value="jpg">JPG</option>
                  <option value="pdf">PDF</option>
                  <option value="png">PNG</option>
                </select>
              </div>
              <div class="col-md-3 pr-0">
                <button class="btn btn-primary w-100" id="filtrarDocumentosAsociados" onclick="pintarDocumentosAsociados(1)">Filtrar</button>
              </div>
            </div>
          </div>

          <div class="col-lg-12" align="right">
            <span><a href="javascript:void(0)" style="color: #848961 !important;" onclick="imprimirSeleccionDA(1);">Imprimir todo</a> | </span>
            <span><a href="javascript:void(0)" style="color: #848961 !important;" onclick="imprimirSeleccionDA(0);">Imprimir selección</a></span>
          </div>

        </div>
        <br>
        <div class="row vista-tabla-DA">
          <div class="col-lg-12">
            <div class="table-responsive" style="max-height: 300px; overflow-x: auto;">
              <table id="tableDocumentosAsociados" class="display dataTable dtr-inline collapsed">
                <thead style="background-color: #EBEEF1; color: #000;">
                  <tr>
                    <th style="text-align:center;">#</th>
                    <th style="text-align:center;">Acciones</th>
                    <th style="min-width: 120px; text-align:center;">Tipo documento</th>
                    <th style="min-width: 120px; text-align:center;">Documento</th>
                    <!-- <th>Tamaño</th> -->
                    <th style="min-width: 125px; text-align:center;">Asociado a</th>
                    <th style="min-width: 125px; text-align:center;">Fecha creacion</th>
                    <th>imprimir</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>

            <div class="pagination-wrapper justify-content-between">
              <ul class="pagination mg-b-0">
                <li class="page-item">
                  <a class="page-link primera-DA" href="javascript:void(0)" aria-label="Last" onclick="pintarDocumentosAsociados(1)">
                    <i class="fa fa-angle-double-left"></i>
                  </a>
                </li>
                <li class="page-item">
                  <a class="page-link anterior-DA" href="javascript:void(0)" aria-label="Next" onclick="pintarDocumentosAsociados(1)">
                    <i class="fa fa-angle-left"></i>
                  </a>
                </li>
              </ul>

              <ul class="pagination mg-b-0">
                <li class="page-item">Página <span class="pagina-DA">1</span> de <span class="total-paginas-DA">1</span></li>
              </ul>

              <ul class="pagination mg-b-0">
                <li class="page-item">
                  <a class="page-link siguiente-DA" href="javascript:void(0)" aria-label="Next" onclick="pintarDocumentosAsociados(1)">
                    <i class="fa fa-angle-right"></i>
                  </a>
                </li>
                <li class="page-item">
                  <a class="page-link ultima-DA" href="javascript:void(0)" aria-label="Last" onclick="pintarDocumentosAsociados(1)">
                    <i class="fa fa-angle-double-right"></i>
                  </a>
                </li>
              </ul>
            </div>
          
          </div>
        </div>

        <div class="row vista-previsualizacion-DA" style="display: none">
          <div class="col-4" style="border-right: solid; overflow-y: auto; max-height:800px;">
            <ul class="list-group" id="listaDocumentosAsociados">
            </ul>
          </div>
          <div class="col-8" id="viewerDocumentosAsociados">
          </div>
        </div>
        <br><br>
      </div><!-- col-lg-12-->
      {{--  col-xl-10 col-lg-10 col-md-10 col-sm-12  --}}
      <hr/>

    </div><!-- row -->

    {{-- BOTONES
    <div id="acum_rem_mobil" >

      <div class="btn-group dropup" id="c_acum">
        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 0.9em !important;">
          Acumuladas
        </button>
        <div class="dropdown-menu">
          <div id="li_acumuladas2">

          </div>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#" id="li_padre2"></a>
        </div>
      </div>

      <div class="btn-group dropup" id="c_rem">
        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 0.9em !important;">
          Remitidas
        </button>
          <div class="dropdown-menu">
            <div id="li_acumuladas3">

            </div>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#" id="li_padre3">Action</a>
          </div>
      </div>

      <div class="btn-group dropup" id="c_amp">
        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 0.9em !important;">
          Amparo
        </button>
        <div class="dropdown-menu">
          <div id="li_acumuladas6">

          </div>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#" id="li_padre6"></a>
        </div>
      </div>

      <div class="btn-group dropup" id="c_apel">
        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 0.9em !important;">
          Apelación
        </button>
        <div class="dropdown-menu">
          <div id="li_acumuladas7">

          </div>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#" id="li_padre7"></a>
        </div>
      </div>


    </div>--}}
    
  </div>

  <style>
    .tx-primary{
      color : #848F33;
    }
    .dropdown-item:active {
      background: transparent;
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
      color: #848F33 ;
      border: 2px solid #EEE;
      border-style: dotted;
      height: 80px;
      border-radius: 25px;
      width: 80%;
    }

    .custom-input-file:hover{
      background: #848F33 ;
      color: #fff;
    }

    .custom-input-file .input-file{
      border: 10000px solid transparent;
      cursor: pointer;
      font-size: 10000px;
      margin: 0;
      opacity: 0;
      outline: 0 none;
      padding: 0 ;
      position: absolute;
      right: -1000px;
      top: -1000px;
    }

    .list-group-item{
      overflow: hidden;
    }
  </style> 

  {{-- JS --}}
  <script>
    var arrDA=[];
    //  var arrNewDA=[];
    var newDA=null;
    const tipos_documento_carpeta= @php echo json_encode($tipos_documento_carpeta);@endphp;

    var arrDAVis = [];
    var id_carpeta_activa_archivos_asociados = null;
    var id_solicitud_activa_archivos_asociados = null;

    var carpetaDocumentosActiva = null;

    /************************
    *
    * MUESTRA TODOS LOS DOCUMENTOS ASOCIADOS
    *
    *************************/

    async function pintarDocumentosAsociados(pagina=1, id_carpeta_judicial=null){

      if(id_carpeta_judicial ==null){
        carpetaDocumentosActiva = carpetaActiva ;
      }else{
        carpetaDocumentosActiva = await obtener_carpeta_por_id(  id_carpeta_judicial );
        if( carpetaDocumentosActiva == null )  return false;
      }

      id_carpeta_activa_archivos_asociados = id_carpeta_judicial;

      $('#carpetaActivaNavVar').html(carpetaDocumentosActiva.folio_carpeta)

      $("#tableDocumentosAsociados tbody tr").remove();
      $.ajax({
        method:'POST',
        url:'/public/obtener_documentos_asociados_carpeta',
        data:{
          carpeta : carpetaDocumentosActiva.id_carpeta_judicial,
          id_solicitud : carpetaDocumentosActiva.id_solicitud,
          tipo_solicitud : carpetaDocumentosActiva.tipo_solicitud_,
          id_documento : 'todas',

          tipo_documento : $("#tipo_documento_buscar").val(),
          nombre_documento : $("#nombre_documento_buscar").val(),
          extension_documento : $("#extension_documento_buscar").val(),

          pagina,
          //origen_documento : $("#origen_documento_buscar").val(),
        },
        success:function(response){
        //  console.log('Consulta documentos asociados:',response);
          arrDA=[];
          if( response.status == 100){



            $(response.response).each(function(index_d,doc){ arrDA.push(doc); });

            $(arrDA).each(function(index_doc, doc){

              let {extension_archivo,id_documento,id_tipo_archivo,id_ultima_version,motivos,nombre_archivo,origen,ruta_base,tamanio_archivo,creacion} = doc;
              //  split_ruta_base = ruta_base.split('/');
              //  let nombre_ext_archivo= split_ruta_base[ split_ruta_base.length-1 ];
              //  arrDA[index_doc].nombre_ext_archivo = nombre_ext_archivo;
              //  arrDA[index_doc].extension_archivo = nombre_ext_archivo.split('.')[1];
              //  arrDA[index_doc].nombre_archivo = nombre_ext_archivo.split('.')[0];
              //  arrDA[index_doc].tipo_doc = tipo_doc;
              //  extension_archivo = (extension_archivo==null?nombre_ext_archivo.split('.')[1] : extension_archivo);
              
              let tipo_doc = get_tipo_documento( id_tipo_archivo );

              let nombre_ext_archivo = nombre_archivo+"."+extension_archivo;
              arrDA[index_doc].nombre_ext_archivo = nombre_ext_archivo;
              arrDA[index_doc].extension_archivo = extension_archivo;
              arrDA[index_doc].nombre_archivo = nombre_archivo;
              arrDA[index_doc].tipo_doc = tipo_doc;

              let strVerDoc = ``;
              let strEditDoc = ``;
              let strBorrarDoc = ``;
              let strHistorialDoc = ``;
              let strFlujo = ``;
              let funcion_ver = `verDocumentoAsociado(${index_doc})`;
              
              if( doc.origen=='ACUERDO' ){
                funcion_ver = `ver_acuerdo_pdf(${id_documento});`;
              }
              if( doc.origen=='PROMOCION' ){
                funcion_ver = `muestraPromocion(${id_documento});`;
              }
              
              if( !bandera_solo_consulta ){ // aquí se controla el permiso de edicion
                let title = `Remover el Documento ${nombre_archivo} de Carpeta Judicial`;
                let body = `borrar_documento`;

                strVerDoc = `<i class="${getIconClass( extension_archivo )}" data-toggle="tooltip-primary" data-placement="top" title="Ver documento" onclick="verDocumentoAsociado(${index_doc})"></i>`;

                if( doc.origen=='CJ' ){
                  strEditDoc = `<i class="fas fa-edit " data-toggle="tooltip-primary" data-placement="top" title="Editar documento" onclick="editarDocumentoAsociado(${index_doc})"></i>`;
                  strBorrarDoc = `<i class="fas fa-trash-alt " data-toggle="tooltip-primary" data-placement="top" title="Borrar documento" onclick="modal_confirm('${title}','${body}','borrarDocumentoAsociado(${index_doc})','modalAdministracion')"></i>`;
                  strHistorialDoc = `<i class="fas fa-history " data-toggle="tooltip-primary" data-placement="top" title="Ver historial documento" onclick="mostrarHistorialDocumentoAsociado(${index_doc},'archivos')"></i>`;

                  nombre_ext_archivo = nombre_archivo == null ? ruta_base.substring(ruta_base.lastIndexOf("/")).replace('/','') :  nombre_archivo+"."+extension_archivo;
                  arrDA[index_doc].nombre_ext_archivo = nombre_ext_archivo;
                }
                if( doc.origen=='SOLICITUD' ){
                  strFlujo =`<i class="fas fa-history " data-toggle="tooltip-primary" data-placement="top" title="Ver flujo solicitud" onclick="mostrarFlujoSolicitud()"></i>`;
                  //tipo_doc = 'solicitud inicial';
                  @if( $request->session()->get('id_unidad_gestion') == 0 and isset($permisos[80]) and $permisos[80] == 1 )
                    strBorrarDoc = `<i class="fas fa-trash-alt " data-toggle="tooltip-primary" data-placement="top" title="Borrar documento" onclick="modal_confirm('${title}','${body}','borrarDocumentoSolicitud(${id_documento})','modalAdministracion')"></i>`;
                  @endif
                  nombre_ext_archivo = nombre_archivo == null ? ruta_base.substring(ruta_base.lastIndexOf("/")).replace('/','') :  nombre_archivo+"."+extension_archivo;
                  arrDA[index_doc].nombre_ext_archivo = nombre_ext_archivo;

                }
              
                if( doc.origen=='ACUERDO' ){
                //if( id_tipo_archivo==207 || id_tipo_archivo==2 || doc.origen=='ACUERDO' ){
                  strVerDoc =`<i class="${getIconClass(extension_archivo)}" data-toggle="tooltip-primary" data-placement="top" title="Ver documento" onclick="ver_acuerdo_pdf(${id_documento});"></i>`;
                  strEditDoc='';
                  @if( $request->session()->get('id_unidad_gestion') == 0 and isset($permisos[80]) and $permisos[80] == 1 )
                    strBorrarDoc = `<i class="fas fa-trash-alt " data-toggle="tooltip-primary" data-placement="top" title="Borrar documento" onclick="modal_confirm('${title}','${body}','borrarDocumentoAcuerdo(${id_documento},${id_ultima_version})','modalAdministracion')"></i>`;
                  @endif
                  strHistorialDoc = `<i class="fas fa-history " data-toggle="tooltip-primary" data-placement="top" title="Ver historial documento" onclick="mostrarHistorialDocumentoAsociado(${index_doc},'acuerdos')"></i>`;
                  funcion_ver = `ver_acuerdo_pdf(${id_documento});`;
                  arrDA[index_doc].tipo_doc = "Acuerdos";
                  //tipo_doc = "Acuerdos";
                }
                //if(id_tipo_archivo==1 || doc.origen=='PROMOCION' ){
                if( doc.origen=='PROMOCION' ){
                  strVerDoc =`<i class="${getIconClass(extension_archivo)}" data-toggle="tooltip-primary" data-placement="top" title="Ver documento" onclick="muestraPromocion(${id_documento});"></i>`;
                  strEditDoc='';
                  @if( $request->session()->get('id_unidad_gestion') == 0 and isset($permisos[80]) and $permisos[80] == 1 )
                    strBorrarDoc = `<i class="fas fa-trash-alt " data-toggle="tooltip-primary" data-placement="top" title="Borrar documento" onclick="modal_confirm('${title}','${body}','borrarDocumentoPromocion(${id_documento})','modalAdministracion')"></i>`;
                  @endif
                  strHistorialDoc='';
                  funcion_ver = `muestraPromocion(${id_documento});`;
                }
              }

              $("#tableDocumentosAsociados tbody").append(`
                <tr>
                  <td style="text-align:center;">${index_doc + 1}</td>
                  <td style="text-align:center;"> ${strBorrarDoc} ${strEditDoc} ${strFlujo} ${strHistorialDoc} ${strVerDoc}</td>
                  <td style="text-align:center;"> <a href="#" onclick="${funcion_ver}"> ${tipo_doc} <i class="fa fa-download d-inline-block d-md-none" aria-hidden="true"></i></a> </td>
                  <td style="text-align:center;"> <a href="#" onclick="${funcion_ver}"> ${nombre_ext_archivo} <i class="fa fa-download d-inline-block d-md-none" aria-hidden="true"></i></a> </td>
                  <!-- <td>${ Number.parseFloat( tamanio_archivo/1048576 ).toFixed(2)} MB</td> -->
                  <td style="text-align:center;">${origen=='SOLICITUD' ? 'SOLICITUD INICIAL':'CARPETA JUDICIAL'}</td>
                  <td style="text-align:center;">${creacion.split(" ")[0].split("-").reverse().join("-")} ${creacion.split(" ")[1]}</td>
                  <td><input name="imprimirDA_${index_doc}" class="chkDA form-control" type="checkbox" value="${index_doc}"></td>
                </tr>
              `);

              if(typeof(response.response_paginas)!='undefined'){
                let anterior=pagina==1?1:pagina-1;
                let totalPaginas=response.response_paginas.paginas_totales;
                let siguiente=pagina+1>=totalPaginas?totalPaginas:pagina+1;

                $('.primera-DA').attr('onclick',`pintarDocumentosAsociados(1,${id_carpeta_judicial})`);
                $('.anterior-DA').attr('onclick',`pintarDocumentosAsociados(${anterior},${id_carpeta_judicial})`);
                $('.pagina-DA').html(pagina);
                $('.total-paginas-DA').html(totalPaginas);
                $('.siguiente-DA').attr('onclick',`pintarDocumentosAsociados(${siguiente},${id_carpeta_judicial})`);
                $('.ultima-DA').attr('onclick',`pintarDocumentosAsociados(${totalPaginas},${id_carpeta_judicial})`);
              }
            });
          }else{
            $('#tableDocumentosAsociados tbody').append(`
              <tr>
                  <td colspan="5">
                    <span class="tx-italic">No hay documentos asociados</span>
                  </td>
              </tr>
            `);

            $('.primera-DA').attr('onclick',`pintarDocumentosAsociados(1,${id_carpeta_judicial})`);
            $('.anterior-DA').attr('onclick',`pintarDocumentosAsociados(1,${id_carpeta_judicial})`);
            $('.pagina-DA').html('1');
            $('.total-paginas-DA').html('1');
            $('.siguiente-DA').attr('onclick',`pintarDocumentosAsociados(1,${id_carpeta_judicial})`);
            $('.ultima-DA').attr('onclick',`pintarDocumentosAsociados(1,${id_carpeta_judicial})`);
            if( response.message!="ERROR - sin referencia a datos" && response.message!="ERROR - sin datos asociados" ){
              modal_error('Consulta de documentos asociados dice: <br> '+response.message,'modalAdministracion');
            }
          }
        } // success
      }); // ajax
      visualizadorDocumentosAsociados();
    }

    function visualizadorDocumentosAsociados(){
      $("#listaDocumentosAsociados li").remove();
      $("#viewerDocumentosAsociados object").remove();

      $.ajax({
        method:'POST',
        url:'/public/obtener_documentos_asociados_carpeta',
        data:{
          carpeta : carpetaDocumentosActiva.id_carpeta_judicial,
          id_solicitud : carpetaDocumentosActiva.id_solicitud,
          tipo_solicitud : carpetaDocumentosActiva.tipo_solicitud_,
          id_documento : 'todas',

          pagina:1,
          registros_por_pagina:100000,

        },
        success:function(response){
          //console.log('Visor documentos asociados:',response);

          let lis= ``;

          if( response.status == 100){

            $(response.response).each(function(index_d,doc){

              let {extension_archivo,id_documento,id_tipo_archivo,id_ultima_version,motivos,nombre_archivo,origen,ruta_base,tamanio_archivo} = doc;
              //split_ruta_base = ruta_base.split('/');
              let nombre_ext_archivo = nombre_archivo+'.'+extension_archivo;
              let funcion = ``;
              if( doc.origen=='CJ' || doc.origen=='SOLICITUD') funcion = `visualizarDocumentoAsociado( '${id_documento}', '${nombre_archivo}', '${extension_archivo}', '${origen}', '#viewerDocumentosAsociados' )`;
              else if( doc.origen=='ACUERDO') funcion = `ver_acuerdo_pdf(${id_documento}, '#viewerDocumentosAsociados');`;
              else if( doc.origen=='PROMOCION') funcion = `verPromocionPDF(${id_documento}, '#viewerDocumentosAsociados');`;

              lis = lis + `
								<li class="list-group-item" onclick="${funcion}">
                  <a href="#">
									<p class="mg-b-0" >
										${parseInt(index_d) +1}. <i class="${getIconClass(extension_archivo)} fa-2x tx-primary mg-r-8"></i>
										<strong class="tx-inverse tx-medium"> ${nombre_ext_archivo}</strong>
									</p>
                  </a>
								</li>
							`;
            });

            $("#listaDocumentosAsociados").append(lis);

          }else{
            if( response.message!='ERROR - sin datos asociados' && response.message != 'Error - sin referencia a datos') modal_error('Visor de documentos asociados dice: <br> '+response.message,'modalAdministracion');
          }
        } // success
      }); // ajax
    }

    function visualizarDocumentoAsociado( id_documento, nombre_archivo, extension_archivo, origen, espacio ){
      $.ajax({
        method:'POST',
        url:'/public/obtener_documentos_asociados_carpeta',
        data:{
          carpeta : carpetaDocumentosActiva.id_carpeta_judicial,
          id_solicitud : carpetaDocumentosActiva.id_solicitud,
          tipo_solicitud : carpetaDocumentosActiva.tipo_solicitud_,
          id_documento : id_documento,
          documento_nombre: nombre_archivo,
          extension: extension_archivo,
          documento_origen : origen,
        },
        success:function(response){
          //console.log('RESPUESTA VER DOC :',response);
          if( !response.message){
            $( espacio ).empty();
            $( espacio ).append(`<object data="${response.response}"	width="100%"	height="800px">	</object>`);
          }else{
            modal_error(response.message,'modalAdministracion');
          }
        } // success
      }); // ajax

    }

    /************************
    *
    * GUARDAD UN NUEVO DOCUMENNTO ASOCIADO
    *
    *************************/
    @if( isset($permisos[79]) and $permisos[79] == 1 )
      function agregarDocumentoAsociado(){
        $('.error').removeClass('error');
        if( !validaDocumentoAsociado() ){
          return false;
        }

        newDA.id_version='-';
        newDA.id_tipo_archivo=$("#tipo_documento").val();
        newDA.nombre_archivo=$("#nombre_documento").val();
        newDA.estatus='-';

        audiencia_referenciada = ((newDA.id_tipo_archivo==12) ? arrA[ $("#audiencia_asociada-DA").val() ].id_audiencia : null);
        $.ajax({
          method:'POST',
          url:'/public/guardar_documentos_asociados_carpeta',
          data:{
            carpeta : $("#id_carpeta_judicial").val(),
            id_solicitud : $("#id_solicitud").val(),
            tipo_solicitud : $("#tipo_solicitud").val(),
            documento : newDA,
            audiencia_referenciada : audiencia_referenciada
          },
          success:function(response){
            if( response.status == 100){
              pintarDocumentosAsociados();
              limpiaFormularioDocumentosAsociados();
              modal_success( response.message ,'modalAdministracion');
              if( newDA.id_tipo_archivo == 12 ) pintarAudiencias();
            }else{
              modal_error(response.message,'modalAdministracion');
            }
          } // success
        }); // ajax
      }
    @endif

    /************************
    *
    * MUESTRA DOCUMENTO EN UNA NUEVA PAGINA
    *
    *************************/

    function verDocumentoAsociado( indexDA ){
      console.log('ver doc',arrDA[ indexDA ]);
      $.ajax({
        method:'POST',
        url:'/public/obtener_documentos_asociados_carpeta',
        data:{
          carpeta : carpetaDocumentosActiva.id_carpeta_judicial,
          id_solicitud : carpetaDocumentosActiva.id_solicitud,
          tipo_solicitud : carpetaDocumentosActiva.tipo_solicitud_,
          id_documento : arrDA[ indexDA ].id_documento,
          documento_nombre: arrDA[ indexDA ].nombre_archivo,
          extension: arrDA[ indexDA ].extension_archivo,
          documento_origen : arrDA[ indexDA ].origen,
          bandera_ws_usmeca : 1,
        },
        success:function(response){
          //console.log('RESPUESTA VER DOC :',response);
          if( !response.message){
            
            

            if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {

              window.open(response.response, '_blank');

            } else { 

              if(arrDA[indexDA].origen == 'SOLICITUD' || arrDA[indexDA].origen == 'ACUERDO' || arrDA[indexDA].origen == 'CJ'){
                $('#nav-fracciones-tab').css('display', 'none');

                $('#nav-documento_view-tab').addClass('active');
                $('#nav-documento_view').addClass('active');
                $('#nav-documento_view').addClass('show');
    
                $('#nav-fracciones-tab').removeClass('active');
                $('#nav-fracciones').removeClass('active');
                $('#nav-fracciones').removeClass('show');
              }

              modal_detalle('DOCUMENTO',`
                <div class="file-group">
                  <div class="file-item">
                    <div class="row no-gutters wd-100p">
                      <div class="col-9 col-sm-7 d-flex align-items-center">
                        <i class="${getIconClass( arrDA[indexDA].extension_archivo ).replaceAll('fas', 'fa')}-o" style="font-size:20px;"></i>
                        <a href="">${arrDA[indexDA].nombre_ext_archivo}</a>
                      </div><!-- col-6 -->
                      <div class="col-3 col-sm-2 tx-right tx-sm-left">${ Number.parseFloat( arrDA[indexDA].tamanio_archivo/1024 ).toFixed(3)} KB</div>
                      <div class="col-6 col-sm-3 tx-right mg-t-5 mg-sm-t-0">${arrDA[indexDA].creacion.split(' ')[0].split('-').reverse().join('-')} ${arrDA[indexDA].creacion.split(' ')[1]}</div>
                    </div><!-- row -->
                  </div><!-- file-item -->
                </div>
                <object data="${response.response}"	width="100%"	height="600">	</object>
              `,'modalAdministracion');
            }
          }else{
            modal_error(response.message,'modalAdministracion');
          }
        } // success
      }); // ajax
    }

    function ver_acuerdo_pdf(id_acuerdo, espacio = null){
      acuerdo = arrDA.filter( x=>x.id_documento == id_acuerdo)[0];
      $.ajax({
        type:'GET',
        url:'public/descargar_pdf_acuerdo/'+ id_acuerdo+'/'+carpetaDocumentosActiva.id_unidad,
        data:{
        },
        success:function(response) {
          if(response.status==100){
            $('#nav-fracciones-tab').css('display', 'block');

            $('#nav-documento_view-tab').addClass('active');
            $('#nav-documento_view').addClass('active');
            $('#nav-documento_view').addClass('show');

            $('#nav-fracciones-tab').removeClass('active');
            $('#nav-fracciones').removeClass('active');
            $('#nav-fracciones').removeClass('show');

            verFraccionesPDF(id_acuerdo, carpetaActiva.victimas);
            if( espacio == null ) modal_detalle('DOCUMENTO',`
              <div class="file-group">
                <div class="file-item">
                  <div class="row no-gutters wd-100p">
                    <div class="col-9 col-md-7 d-flex align-items-center">
                      <i class="fa fa-file-pdf-o" style="font-size:20px;"></i>
                      <a href="">${acuerdo.nombre_ext_archivo}</a>
                    </div><!-- col-6 -->
                    <div class="col-3 col-md-2 tx-right tx-sm-left">${ Number.parseFloat( acuerdo.tamanio_archivo/1024 ).toFixed(3)} KB</div>
                    <div class="col-6 col-md-3 tx-right mg-t-5 mg-sm-t-0">${acuerdo.creacion.split(' ')[0].split('-').reverse().join('-')} ${acuerdo.creacion.split(' ')[1]}</div>
                  </div><!-- row -->
                </div><!-- file-item -->
              </div>
              <object data="${response.response}"	width="100%"	height="600">	</object>
            `,'modalAdministracion');
            else{ $( espacio ).empty(); $( espacio ).append( `<object data="${response.response}"	width="100%"	height="800px">	</object>` ); }
          }else modal_error(response.message,'modalAdministracion');
        }
      });
    }

    function verFraccionesPDF(id_acuerdo, victimas){
      var option = '<option value="0" disabled>Selecciona una opción</option>';
      var selected = '';

      for(i in victimas){
        if(i == 0){
          selected = 'selected';
        }else{
          selected = '';
        }

        option += `<option ${selected} value="${victimas[i].id_persona}" acuerdo="${id_acuerdo}">${victimas[i].nombre}</option>`;
      }

      $('#victimas_acuerdo').html(option);

      setTimeout(function(){  ConsultarFraccionAcu(); }, 500); 
    }

    function ConsultarFraccionAcu(obj){
      var id_persona = $('#victimas_acuerdo').val();
      var id_acuerdo = $('#victimas_acuerdo :selected').attr('acuerdo');

      
      $.ajax({
        type:'POST',
        url:'public/catalogo_fracciones_solicitud_acuerdo',
        data:{
          id_persona: id_persona,
          id_acuerdo:id_acuerdo
        },
        success:function(response){
          if(response.status == 100){
            var lista = response.response;
            var html = '';

            for(i = 0; i < lista.length; i++){

              button_show = '';
              checkado_promujer = '';
              checkado_audi = '';
              descripcion = '';
  
              if(lista[i].id_cat != 16){
                
                if(lista[i].soli_fraccion_valor == 1){
                  checkado_promujer = `<i style="color: #229954; font-size: 1.4em; background:none;" class="far fa-check-circle"></i>`;
                }else{
                  checkado_promujer = `<i style="color: #c0b5b4c4; font-size: 1.4em; background:none;" class="fas fa-minus"></i>`;
                }
  
                if(lista[i].acu_fraccion_valor == 1){
                  checkado_audi = `checked`;
                  button_show = `<i style="color: #229954; font-size: 1.4em; background:none;" class="far fa-check-circle"></i>`;
                }else{
                  checkado_audi = ``;
                  button_show = `<i style="color: #c0b5b4c4; font-size: 1.4em; background:none;" class="fas fa-minus"></i>`;
                }
  
                descripcion = lista[i].descripcion;
              
              }else{
                
                checkado_promujer ='';

                if(lista[i].soli_fraccion_valor == 1){
                  checkado_promujer = `<i style="color: #229954; font-size: 1.4em; background:none;" class="far fa-check-circle"></i>`;
                }else{
                  checkado_promujer = `<i style="color: #c0b5b4c4; font-size: 1.4em; background:none;" class="fas fa-minus"></i>`;
                }

                if(lista[i].acu_fraccion_valor == 1){
                  checkado_audi = `checked`;
                }else{
                  checkado_audi = ``;
                }
  
                descripcion = lista[i].audi_fraccion_descripcion_otros;
                
                if(lista[i].acu_fraccion_valor == 1){
                  checkado_audi = `checked`;
                  button_show = `<i style="color: #229954; font-size: 1.4em; background:none;" class="far fa-check-circle"></i>`;
                }else{
                  checkado_audi = ``;
                  button_show = `<i style="color: #c0b5b4c4; font-size: 1.4em; background:none;" class="fas fa-minus"></i>`;
                }
              }
  
              //quitar el if en caso de mostrar las hipotesis
              if(lista[i].id_padre == 0){
                //cuerpo de la tabla
                html += `<tr>
                  <td style="min-width: 5%; text-align:center; border: 1px solid #eee; color: #848F33;;font-weight: bold;font-size: 1.2em;">${lista[i].id_padre == 0 ? lista[i].fraccion : '' }</td>
                  <td style="min-width: 80%; text-align:justify; border-bottom: 1px solid #eee; padding:1px 1%; font-size: 0.9em;">${descripcion == null ? 'Sin Titulo' : descripcion}</td>
                  <td style="min-width: 5%; border-left: 1px solid #eee; display: table-cell; text-align: center; padding: 1% 1%;">
                    ${checkado_promujer} 
                  </td>
                  <td style="min-width: 5%; border-left: 1px solid #eee; border-right: 1px solid #eee; display: table-cell; padding: 1% 1%; text-align: center;">
                    ${button_show}
                  </td>
                </tr>`;
              }
              
            }
            
            $('#Fra_cciones').html(html);


          }else{
            $('#nav-fracciones-tab').css('display', 'none');
						$('#nav-documento_view-tab').css('display', 'block');
			
						$('#nav-documento_view-tab').addClass('active');
						$('#nav-documento_view').addClass('active');
						$('#nav-documento_view').addClass('show');
			
						$('#nav-fracciones-tab').removeClass('active');
						$('#nav-fracciones').removeClass('active');
						$('#nav-fracciones').removeClass('show');

            $('#Fra_cciones').html(`<tr style="text-alig:center;">
                                      <td colspan="3" style="padding: 20px; text-align:center;">Acuerdo sin formato de medidas</td>
                                    </tr>`);
          }
        }
      });
      
    }

    function verPromocionPDF(id_promocion, espacio = null){
      promocion = arrDA.filter( x=>x.id_documento == id_promocion)[0];
			$.ajax({
				method:'GET',
				url:'/public/descargar_pdf_promocion/'+id_promocion,
				success:function(response){
					if(response.status==100){
            if( espacio == null ) modal_detalle('DOCUMENTO',`
              <div class="file-group">
                <div class="file-item">
                  <div class="row no-gutters wd-100p">
                    <div class="col-9 col-sm-6 d-flex align-items-center">
                      <i class="${getIconClass( promocion.extension_archivo )}-o"></i> &bnsp;
                      <p>${promocion.nombre_ext_archivo}</p>
                    </div><!-- col-6 -->
                    <div class="col-3 col-sm-2 tx-right tx-sm-left">${ Number.parseFloat( promocion.tamanio_archivo/1024 ).toFixed(2)}</div>
                    <div class="col-6 col-sm-4 mg-t-5 mg-sm-t-0">${promocion.creacion.split(' ')[0].split('-').reverse().join('-')} ${promocion.creacion.split(' ')[1]}</div>
                  </div><!-- row -->
                </div><!-- file-item -->
              </div>
              <object data="${response.response}"	width="100%"	height="600">	</object>
            `,'modalAdministracion');
            else{ $( espacio ).empty(); $( espacio ).append( `<object data="${response.response}"	width="100%"	height="800px">	</object>` ); }
					}else modal_error(response.message,'modalAdministracion');
				}
			});
		}

    /************************
    *
    * CARGA EL DOCUMENTO A EDITAR
    *
    *************************/

    function editarDocumentoAsociado( indexDA){
      limpiaFormularioDocumentosAsociados();

      let{ id_documento,id_tipo_archivo,nombre_archivo,nombre_ext_archivo}= arrDA[ indexDA ];
      $("#idDocumentoRelacionado").val(id_documento);
      $('#tipo_documento').val(id_tipo_archivo);
      $('#tipo_documento').trigger('change');
      $("#nombre_documento").val(nombre_archivo);

      $("#titleAccordionDocumentosAsociados").html(`Editando al documento `+nombre_ext_archivo);
      $("#titleAccordionDocumentosAsociados").removeClass(`bkg-collapsed-btn`);
      $("#titleAccordionDocumentosAsociados").addClass(`bkg-collapsed-btn-edit`);

      if( !$("#row_documento_asociado").hasClass('d-none') )
        $("#row_documento_asociado").addClass('d-none');

      $("#botonesDocumentosAsociados").append(`
        <!--<button type="button" class="btn btn-secondary d-inline-block btn-edicion mg-l-auto" id="cancelarDocumentoAsociado" onclick="limpiaFormularioDocumentosAsociados()">Cancelar</button>-->
        <button class="btn btn-primary bd-0 d-inline-block ml-auto" id="actualizarDocumentoAsociado" onclick="actualizarDocumentoAsociado( ${indexDA} )">Actualizar Documento</button>
      `);

      $("#agregarDocumentoAsociado").removeClass('d-inline-block');
      $("#agregarDocumentoAsociado").addClass('d-none');
      $("#collapseOneDocumentosAsociados").collapse('show');
    }


    /************************
    *
    * ACTUALIZA DOCUMENTO EDITADO
    *
    *************************/

    function actualizarDocumentoAsociado( indexDA ){
      $('.error').removeClass('error');

      if( !$("#tipo_documento").val() || $("#tipo_documento").val()=='null' ){
        modal_error('Debe seleccionar el tipo de documento','modalAdministracion');
        $("#tipo_documento").parent().addClass('error');
        return false;
      }

      let documento = arrDA[indexDA];
      documento.id_tipo_archivo = $("#tipo_documento").val();
      documento.b64 = '';
      documento.estatus = 1;
      documento.motivos = $("#motivoRemoverDocumento").val()? $("#motivoRemoverDocumento").val():'-' ;

      $.ajax({
        method:'POST',
        url:'/public/guardar_documentos_asociados_carpeta',
        data:{
          carpeta : $("#id_carpeta_judicial").val(),
          id_solicitud : $("#id_solicitud").val(),
          tipo_solicitud : $("#tipo_solicitud").val(),
          documento : documento,
          audiencia_referenciada : $("#audiencia_asociada-DA").val(),
        },
        success:function(response){
          if( response.status == 100){
            pintarDocumentosAsociados();
            limpiaFormularioDocumentosAsociados();
            modal_success('Documento actualizado exitosamente','modalAdministracion');
          }else{
            modal_error(response.message,'modalAdministracion');
          }
        } // success
      }); // ajax
    }

    /************************
    *
    * ELIMINA DOCUMENTO
    *
    *************************/
    @if( isset($permisos[80]) and $permisos[80] == 1 )
      function borrarDocumentoAsociado( indexDA ){
        //console.log('Borrar doc',arrDA[indexDA]);
        $("#modalConfirm").modal('hide');

        let documento = arrDA[indexDA];
        documento.b64 = '';
        documento.estatus = 0;
        documento.motivos = $("#motivoRemoverDocumento").val()? $("#motivoRemoverDocumento").val():'-' ;

        let audiencia_referenciada = null;
        
        if(arrDA[indexDA].id_tipo_archivo == 12){
          let a = arrA.filter( x => x.id_doc_acta_minima == arrDA[indexDA].id_documento );
          if( (a).length > 0 ) audiencia_referenciada = a[0].id_audiencia;
          else audiencia_referenciada = 0;
        } 

        $.ajax({
          method:'POST',
          url:'/public/guardar_documentos_asociados_carpeta',
          data:{
            carpeta : $("#id_carpeta_judicial").val(),
            id_solicitud : $("#id_solicitud").val(),
            tipo_solicitud : $("#tipo_solicitud").val(),
            audiencia_referenciada : audiencia_referenciada,
            documento : documento,
          },
          success:function(response){
            if( response.status == 100){
              pintarDocumentosAsociados();
              modal_success('Documento removido exitosamente','modalAdministracion');
              if(arrDA[indexDA].id_tipo_archivo == 12) pintarAudiencias();
            }else{
              modal_error(response.message,'modalAdministracion');
            }
          } // success
        }); // ajax
      }

      function borrarDocumentoSolicitud( id_documento ){

        let documento = arrDA.filter( x => x.id_documento == id_documento );

        if( documento.length == 0 ) return false;

        $("#modalConfirm").modal('hide');
        
        let motivos = $("#motivoRemoverDocumento").val()? $("#motivoRemoverDocumento").val():'-' ;

        $.ajax({
          method:'POST',
          url:'/public/estatus_documento_solicitud_inicial',
          data:{
            id_documento : id_documento,
            estatus : 0,
            motivos : motivos
          },
          success:function(response){
            if( response.status == 100){
              pintarDocumentosAsociados();
              modal_success('Documento removido exitosamente','modalAdministracion');
            }else{
              modal_error(response.message,'modalAdministracion');
            }
          } // success
        }); // ajax
      }
      
      function borrarDocumentoAcuerdo( id_documento , id_version ){

        let documento = arrDA.filter( x => x.id_documento == id_documento );

        if( documento.length == 0 ) return false;

        $("#modalConfirm").modal('hide');
        
        let motivos = $("#motivoRemoverDocumento").val()? $("#motivoRemoverDocumento").val():'-' ;

        $.ajax({
          method:'POST',
          url:'/public/estatus_version_acuerdo',
          data:{
            carpeta : carpetaDocumentosActiva.id_carpeta_judicial,
            id_documento : id_documento,
            id_version : id_version,
            estatus : "eliminar",
            motivos : motivos
          },
          success:function(response){
            if( response.status == 100){
              pintarDocumentosAsociados();
              modal_success('Documento removido exitosamente','modalAdministracion');
            }else{
              modal_error(response.message,'modalAdministracion');
            }
          } // success
        }); // ajax
      }
      
      function borrarDocumentoPromocion( id_documento ){

        let documento = arrDA.filter( x => x.id_documento == id_documento );

        if( documento.length == 0 ) return false;

        $("#modalConfirm").modal('hide');
        
        let motivos = $("#motivoRemoverDocumento").val()? $("#motivoRemoverDocumento").val():'-' ;

        $.ajax({
          method:'POST',
          url:'/public/estatus_documento_promocion',
          data:{
            carpeta : carpetaDocumentosActiva.id_carpeta_judicial,
            id_documento : id_documento,
            estatus : 0,
            motivos : motivos
          },
          success:function(response){
            if( response.status == 100){
              pintarDocumentosAsociados();
              modal_success('Documento removido exitosamente','modalAdministracion');
            }else{
              modal_error(response.message,'modalAdministracion');
            }
          } // success
        }); // ajax
      }
    @endif

    /**********************
    *
    * CANCELAR EDICION DE DOCUMENTOS
    *
    **********************/

    function limpiaFormularioDocumentosAsociados(){
      $("#titleAccordionDocumentosAsociados").html(`Adjuntar Documento`);
      $("#titleAccordionDocumentosAsociados").removeClass(`bkg-collapsed-btn-edit`);
      $("#titleAccordionDocumentosAsociados").addClass(`bkg-collapsed-btn`);

      $('.error').removeClass('error');

      $("#agregarDocumentoAsociado").addClass('d-inline-block');
      $("#agregarDocumentoAsociado").removeClass('d-none');

      $('#divViewDocumentosAsociados div').remove();
      $('#archivoPDF').val('');

      $("#row_documento_asociado").addClass('d-none');
      $("#col_nombre_documento_asociado").addClass('d-none');

      $("#idDocumentoRelacionado").val('');
      $("#nombre_documento").val('');
      $("#tipo_documento").val('null');

      $("#cancelarDocumentoAsociado").remove();
      $("#actualizarDocumentoAsociado").remove();

      $("#collapseOneDocumentosAsociados").collapse('hide');
    }


    /**********************
    *
    * LEE NUEVOS DOCUMENTOS ASOCIADOS
    *
    **********************/

    function leeDocumentoAsociado (input) {
      let acepted_files=["pdf","PDF","png","jpg","docx","doc"];

      let file = $('#archivoPDF').val();
      let ext = "";
      let extension = "";
      let nombre_documento = "";

      if(file.length){
        //console.log( file.lastIndexOf(".") + 1 , file.length - file.lastIndexOf(".") , file.substr( file.lastIndexOf(".") +1 , file.length - file.lastIndexOf(".") -1 ) );
        extension = file.substr( file.lastIndexOf(".") +1 , file.length - file.lastIndexOf(".") -1 );   
        extension = extension.toLowerCase();
        nombre_documento = (file.split('\\')[2]);
        nombre_documento = nombre_documento.substr( 0 , nombre_documento.lastIndexOf(".") );   
        nombre_documento = nombre_documento.replaceAll(' ', '_');
        nombre_documento = nombre_documento.replaceAll('  ', '_');
        nombre_documento = nombre_documento.replaceAll('.', '_');
        if(extension!=''){
          if( !acepted_files.includes(extension) ){
            modal_error('Solo puede adjutar archivos PDF, PNG, JPG, DOC o DOCX','modalAdministracion');
            $('#archivoPDF').val('');
            return false
          }else{
            if (input.files && input.files[0]) {
              let reader = new FileReader();
              reader.onload = e=> {
                newDA = {
                  'b64' : e.target.result.split('base64,')[1],
                  'nombre_archivo' : nombre_documento,
                  'tamanio_archivo': input.files[0].size / 1048576,
                  'extension_archivo' : extension,
                  'tipo_data': get_tipo_data(extension),
                };
              }
              reader.readAsDataURL(input.files[0]);
            }
            setTimeout(function(){ pintar_documento_asociado(); },500);
          }
        }
      }else{
        return false;
      }
    }


    /**********************
    *
    * PINTA LOS NUEVOS DOCUMENTOS ASOCIADOS
    *
    **********************/

    function pintar_documento_asociado(){
      //console.log("Pinta documentos");
      $('#divViewDocumentosAsociados div').remove();

      let reader_files=["pdf","png","jpg"];

      documento = newDA;

      if ( reader_files.includes(documento.extension_archivo) ) {
        $('#divViewDocumentosAsociados').append(`
          <div class="col-lg-12" align="center">
            <object height="300px" ${ documento.extension_archivo=="pdf"?'width="100%"' : ''} class="mg-t-25" data="${documento.tipo_data+documento.b64}"></object>
          </div>
        `);
      }else{
        $('#divViewDocumentosAsociados').append(`
          <div class="col-lg-12" align="center">
            ${getIcon(documento.extension_archivo)}
          </div>
        `);
      }

      $("#nombre_documento").val( documento.nombre_archivo );

      $("#col_nombre_documento_asociado").removeClass('d-none');
      $("#col_nombre_documento_asociado").focus();
    }

    /**********************
    *
    * MOSTRAR HISTORIAL DOCUMENTO ASOCIADO
    *
    **********************/

    function mostrarHistorialDocumentoAsociado( indexDA , historial ){
      let title = "HISTORIAL DEL DOCUMENTO: "+arrDA[ indexDA ].nombre_archivo.toUpperCase();
      let body = ``;
      let listaHistorial=``;

      
      $.ajax({
        method:'POST',
        url:'/public/consulta_historial',
        data:{
          carpeta : $("#id_carpeta_judicial").val(),
          id_solicitud : $("#id_solicitud").val(),
          tipo_solicitud : $("#tipo_solicitud").val(),
          historial: historial,
          documento_origen: arrDA[ indexDA ].origen,
          id_documento: arrDA[ indexDA ].id_documento,
        },
        success:function(response){
          //console.log(response);
          if(response.status==100){
            if(arrDA[ indexDA ].origen=='CJ'){
              $(response.response).each(function(index_d,doc){
                let { nombre,extension,tamanio,tipo_documento,creacion,motivos }=doc
                listaHistorial=listaHistorial.concat(`
                  <tr>
                    <td>${creacion}</td>
                    <td>${tipo_documento}</td>
                    <td>${nombre},${extension}</td>
                    <td>${tamanio}</td>
                    <!--<td>${motivos}</td>-->
                  </tr>
                `);
              });

              body = `
                <div class="row">
                  <div class="col-lg-12">
                    <table class="datatable tableDatosSujeto" style="overflow-x: none; display: table">
                      <thead>
                          <tr>
                            <th class="tx-center" style="background:#f8f9fa">Fecha</th>
                            <th class="tx-center" style="background:#f8f9fa">Tipo Documento</th>
                            <th class="tx-center" style="background:#f8f9fa">Documento</th>
                            <th class="tx-center" style="background:#f8f9fa">Tamaño</th>
                            <!-- <th class="tx-center" style="background:#f8f9fa">Motivos</th> -->
                          </tr>
                        </thead>
                      <tbody class="table-datos-sujeto">
                      ${ listaHistorial.length ? listaHistorial : '<tr><td colspan="4"><span class="tx-italic">Sin historial</span></td></tr>' }
                      </tbody>
                    </table>
                  </div>
                </div>
              `;
            }else if(arrDA[ indexDA ].origen=='ACUERDO')  {
              $(response.response).each(function(index_d,doc){
              
                listaHistorial=listaHistorial.concat(`
                  <tr>
                    <td>${doc.creacion.split(' ')[0].split('-').reverse().join('-')} ${doc.creacion.split(' ')[1]}</td>
                    <td>${doc.nombres??''} ${doc.apellido_paterno??''} ${doc.apellido_materno??''} (<small>${doc.usuario??''}</small>)</td>
                    <td>${doc.flujo_comentarios.replaceAll("[]","")}.</td>
                  </tr>
                `);
                
              });

              body = `
                <div class="row">
                  <div class="col-lg-12">
                    <table class="datatable tableDatosSujeto" style="overflow-x: none; display: table">
                      <thead>
                          <tr>
                            <th class="tx-center" style="background:#f8f9fa">Fecha</th>
                            <th class="tx-center" style="background:#f8f9fa">Responsable</th>
                            <th class="tx-center" style="background:#f8f9fa">Acción</th>
                          </tr>
                        </thead>
                      <tbody class="table-datos-sujeto">
                      ${ listaHistorial.length ? listaHistorial : '<tr><td colspan="3"><span class="tx-italic">Sin historial</span></td></tr>' }
                      </tbody>
                    </table>
                  </div>
                </div>
              `;
            }

            modal_historial(title,body,'modalAdministracion');
          }else{
            modal_error(response.message,'modalAdministracion');
          }
        } // success
      }); // ajax
      
      modal_historial(title,body,'modalAdministracion');
    }

    function mostrarFlujoSolicitud(){
      let title=`FLUJO DE LA SOLICITUD`;
      let body=``;
      let listaFlujo=``;
      $.ajax({
        type: "GET",
        url: "public/ver_flujo/"+$("#id_solicitud").val(),
        data: {},
        success: function (response) {
          $(response.response).each(function(index,flujo){
            let{nombres,apellido_paterno,apellido_materno,usuario,estatus_actividad,creacion}=flujo;
            nombres = (nombres!=null?nombres:'')+(apellido_paterno!=null?apellido_paterno:'')+(apellido_materno!=null?apellido_materno:'');
            nombres = nombres.length?nombres:'Desconocido';
            usuario = usuario!=null?usuario:'Desconocido';
            listaFlujo= listaFlujo.concat(`
              <tr>
                <td>${estatus_actividad}</td>
                <td> <strong>Nombre: </strong>${nombres}<br><strong>Usuario: </strong>${usuario}</td>
                <td>${creacion}</td>
              </tr>
            `);
          });

          body = `
            <div class="row">
              <div class="col-lg-12">
                <table class="datatable tableDatosSujeto" style="overflow-x: none; display: table">
                  <thead>
                      <tr>
                        <th class="tx-center" style="background:#f8f9fa">Estatus</th>
                        <th class="tx-center" style="background:#f8f9fa">Reponsable</th>
                        <th class="tx-center" style="background:#f8f9fa">Fecha</th>
                      </tr>
                    </thead>
                  <tbody class="table-datos-sujeto">
                  ${ listaFlujo.length ? listaFlujo : '<tr><td colspan="3"><span class="tx-italic">Sin historial de flujo</span></td></tr>' }
                  </tbody>
                </table>
              </div>
            </div>
          `;

          modal_historial(title,body,'modalAdministracion');
        },
      });
    }

    function imprimirSeleccionDA(imprimirTodo=0){
      let arrSeleccionados = [];
      if(imprimirTodo==0){
        $(".chkDA:checked").each(function(){
          arrSeleccionados.push({
            carpeta : $("#id_carpeta_judicial").val(),
            id_solicitud : arrDA[ $(this).val() ].id_solicitud,
            tipo_solicitud : $("#tipo_solicitud").val(),
            id_documento : arrDA[ $(this).val() ].id_documento,
            nombre_archivo: arrDA[ $(this).val() ].nombre_archivo,
            extension_archivo: arrDA[ $(this).val() ].extension_archivo,
            ruta_base: arrDA[ $(this).val() ].ruta_base,
            origen : arrDA[ $(this).val() ].origen,
          });
        });
      }
      //console.log(imprimirTodo,arrSeleccionados);
      //return false;
      $.ajax({
        method:'POST',
        url:'/public/coser_documentos_asociados',
        data:{
          id_unidad : carpetaActiva.id_unidad,
          carpeta : $("#id_carpeta_judicial").val(),
          id_solicitud : $("#id_solicitud").val(),
          tipo_solicitud : $("#tipo_solicitud").val(),

          tipo_documento : $("#tipo_documento_buscar").val(),
          nombre_documento : $("#nombre_documento_buscar").val(),
          extension_documento : $("#extension_documento_buscar").val(),

          imprimir_todo : imprimirTodo,
          seleccionados : arrSeleccionados,
        },
        success:function(response){
        //  console.log('RESPUESTA VER DOC :',response);
          if( !response.message){
            var win = window.open(response.response, '_blank');
          }else{
            modal_error(response.message,'modalAdministracion');
          }
        } // success
      }); // ajax
    }
    /**********************
    *
    * FUNCIONES GENERALES
    *
    **********************/

    function getIcon( extension ){
      if( extension=='pdf' || extension=='html' ){ return `<i class="fas fa-file-pdf fa-2x" title="pdf"></i>`;  }
      if( extension=='doc' || extension=='docx' ){ return `<i class="fas fa-file-word fa-2x" title="word"></i>`;  }
      if( extension=='jpg' || extension=='png'  ){ return `<i class="far fa-file-image fa-2x" title="imagen"> </i>`;  }
      else{ return `<i class="fas fa-file"></i>`; }
    }

    function getIconClass( extension ){
      if( extension=='pdf' || extension=='html' ){ return `fas fa-file-pdf`;  }
      if( extension=='doc' || extension=='docx' ){ return `fas fa-file-word`;  }
      if( extension=='jpg' || extension=='png'  ){ return `far fa-file-image`;  }
      else{ return `fas fa-file`; }
    }

    function get_tipo_data( extension ){
      if( extension == 'pdf' ) return 'data:application/pdf;base64,';
      if( extension == 'jpg' ) return 'data:image/jpeg;base64,';
      if( extension == 'png' ) return 'data:image/png;base64,';
      if( extension == 'doc' ) return '';
      if( extension == 'docx' ) return '';
      else return '';
    }

    function get_tipo_documento( id_tipo_documento ){
      if( id_tipo_documento==0 || id_tipo_documento==null ) return 'no identificado';
      if( id_tipo_documento==207 ) return 'Acuerdo (Recepción de apelación)';

      let tipo_docu = tipos_documento_carpeta.filter( index => index.id_documento == id_tipo_documento);
      //console.log(tipo_docu);
      if(tipo_docu.length)return tipo_docu[0].nombre;
      else return 'No figurado en catalogo';
    }

    /******************
    *
    * CONFIG COMPONENTS DA
    *
    *********************/

    function loadConfigComponentsDA(){
      $('#tipo_documento').select2({minimumResultsForSearch: ''});
      $('#tipo_documento_buscar').select2({minimumResultsForSearch: ''});
      $('#origen_documento_buscar').select2({minimumResultsForSearch: ''});
      /************************
       *
       * FUNCIONES ON CHANGE
       *
      ************************/
      $("#archivoPDF").on('input',function () {
        leeDocumentoAsociado(this);
      });

      $("#tipo_documento").change(function () {
        if($(this).val()!='null' && !$("#idDocumentoRelacionado").val() ){
          $("#row_documento_asociado").removeClass('d-none');

          if($(this).val() == 12){
            
            $("#col_audiencia_asociada-DA").removeClass('d-none');
            
            if( $("#audiencia_asociada-DA").hasClass('select2') ){ 
              $('#audiencia_asociada-DA').select2('destroy');
            }

            $("#audiencia_asociada-DA").html( get_strOption('audiencias_cj') );
            setTimeout(function(){ $('#audiencia_asociada-DA').select2({minimumResultsForSearch: ''}); }, 1000);
            
          }else{
            if( !$("#col_audiencia_asociada-DA").hasClass('d-none') ){ 
              $("#col_audiencia_asociada-DA").addClass('d-none');
            }
          }
        }else{
          $("#row_documento_asociado").addClass('d-none');
        }
      });
    }

    function validaDocumentoAsociado(){
      
      if( !$("#tipo_documento").val() || $("#tipo_documento").val()=='null' ){
        modal_error('Debe seleccionar el tipo de documento','modalAdministracion');
        $("#tipo_documento").parent().addClass('error');
        return false;
      }

      if( $("#tipo_documento").val() == 12 ){

        if( !$("#audiencia_asociada-DA").val() || $("#audiencia_asociada-DA").val() == 'null' ){
          modal_error('Debe seleccionar una audiencia a la cual asociar el Acta mínima','modalAdministracion');
          $("#audiencia_asociada-DA").parent().addClass('error');
          return false;
        }
        /*
        if( arrA[ $("#audiencia_asociada-DA").val() ].id_doc_acta_minima != null  ){
          modal_error('Esta audiencia ya tiene asociada un Acta mínima.<br>Seleccione otra','modalAdministracion');
          $("#audiencia_asociada-DA").parent().addClass('error');
          return false;
        }
        */
      }

      if( !$("#archivoPDF").val() ){
        modal_error('Debe adjuntar un documento','modalAdministracion');
        $("#archivoPDF").parent().addClass('error');
        return false;
      }

      if( !$("#nombre_documento").val() ){
        modal_error('Debe ingresar el nombre del documento','modalAdministracion');
        $("#nombre_documento").parent().addClass('error');
        return false;
      }
      return true;
    }

    /***** antes pintar Documentos
    function pintarDocumentosAsociados(){
      $("#tableDocumentosAsociados tbody tr").remove();
      $.ajax({
        method:'POST',
        url:'/public/obtener_documentos_asociados_carpeta',
        data:{
          carpeta : $("#id_carpeta_judicial").val(),
          id_solicitud : $("#id_solicitud").val(),
          tipo_solicitud : $("#tipo_solicitud").val(),
          id_documento : 'todas',
        },
        success:function(response){
          console.log(response);
          arrDA=response;

          if( !response.message){
            $(response).each(function(index_doc, doc){
              let { nombre_archivo, tamanio, tipo_doc, id_version }=doc;
              let extension = nombre_archivo.split('.')[1];
              let nombre = nombre_archivo.split('.')[0];
              arrDA[index_doc].extension = extension;
              arrDA[index_doc].nombre = nombre;

              let strVerDoc = `<i class="${getIconClass(extension)}" data-toggle="tooltip-primary" data-placement="top" title="Ver documento" onclick="verDocumentoAsociado(${index_doc})"></i>`;
              let strEditDoc = ``;
              let strBorrarDoc = ``;
              let strHistorialDoc = ``;
              if(true){ // aquí te controla el permiso de edicion
                let title = `Remover el Documento ${nombre_archivo} de Carpeta Judicial`;
                let body = `borrar_documento`;
                strEditDoc = `<i class="fas fa-edit " data-toggle="tooltip-primary" data-placement="top" title="Editar documento" onclick="editarDocumentoAsociado(${index_doc})"></i>`;
                strBorrarDoc = `<i class="fas fa-trash-alt " data-toggle="tooltip-primary" data-placement="top" title="Borrar documento" onclick="modal_confirm('${title}','${body}','borrarDocumentoAsociado(${index_doc})','modalAdministracion')"></i>`;
                strHistorialDoc = `<i class="fas fa-history " data-toggle="tooltip-primary" data-placement="top" title="Ver historial documento" onclick="mostrarHistorialDocumentoAsociado(${index_doc})"></i>`;
              }

              $("#tableDocumentosAsociados tbody").append(`
                <tr>
                  <td>${index_doc + 1}</td>
                  <td>${strBorrarDoc} ${strEditDoc} ${strHistorialDoc} ${strVerDoc}</td>
                  <td>${tipo_doc}</td>
                  <td>${nombre_archivo}</td>
                  <td>${tamanio} MB</td>
                </tr>
              `);
            });
          }else{
            $('#tableDocumentosAsociados tbody').append(`
                <tr>
                    <td colspan="5">
                      <span class="tx-italic">No hay documentos asociados</span>
                    </td>
                </tr>
              `);
            modal_error(response.message,'modalAdministracion');
          }
        } // success
      }); // ajax
    }
    */

    /* SI FUNCIONA SOLO SE ESTA DESARROLLANDO EL PAGINATOR
    function pintarDocumentosAsociados(pagina=1){
      $("#tableDocumentosAsociados tbody tr").remove();
      $.ajax({
        method:'POST',
        url:'/public/obtener_documentos_asociados_carpeta',
        data:{
          carpeta : $("#id_carpeta_judicial").val(),
          id_solicitud : $("#id_solicitud").val(),
          tipo_solicitud : $("#tipo_solicitud").val(),
          id_documento : 'todas',
        },
        success:function(response){
          console.log(response);
          arrDA=[];
          if( response.status == 100){
            $(response.response.solicitud).each(function(index_d,doc){
              doc.documento_origen='solicitud';
              arrDA.push(doc);
            });
            $(response.response.otros_asociados).each(function(index_d,doc){
              doc.documento_origen='carpeta_judicial';
              arrDA.push(doc);
            });

            $(arrDA).each(function(index_doc, doc){
              let { nombre, tamanio_mb, tipo_documento, id_version, documento_origen }=doc;
              let nombre_archivo = nombre;
              let extension = nombre.split('.')[1];
              let tipo_doc = get_tipo_documento( tipo_documento );

              nombre = nombre.split('.')[0];
              arrDA[index_doc].nombre_archivo = nombre_archivo;
              arrDA[index_doc].extension = extension;
              arrDA[index_doc].nombre = nombre;
              arrDA[index_doc].tipo_doc = tipo_doc;
              let strVerDoc = `<i class="${getIconClass(extension)}" data-toggle="tooltip-primary" data-placement="top" title="Ver documento" onclick="verDocumentoAsociado(${index_doc})"></i>`;
              let strEditDoc = ``;
              let strBorrarDoc = ``;
              let strHistorialDoc = ``;
              let strFlujo = ``;
              if(true){ // aquí te controla el permiso de edicion
                let title = `Remover el Documento ${nombre_archivo} de Carpeta Judicial`;
                let body = `borrar_documento`;

                if( doc.documento_origen=='carpeta_judicial' ){
                  strEditDoc = `<i class="fas fa-edit " data-toggle="tooltip-primary" data-placement="top" title="Editar documento" onclick="editarDocumentoAsociado(${index_doc})"></i>`;
                  strBorrarDoc = `<i class="fas fa-trash-alt " data-toggle="tooltip-primary" data-placement="top" title="Borrar documento" onclick="modal_confirm('${title}','${body}','borrarDocumentoAsociado(${index_doc})','modalAdministracion')"></i>`;
                  strHistorialDoc = `<i class="fas fa-history " data-toggle="tooltip-primary" data-placement="top" title="Ver historial documento" onclick="mostrarHistorialDocumentoAsociado(${index_doc})"></i>`;
                }
                if( doc.documento_origen=='solicitud' ){
                  strFlujo =`<i class="fas fa-history " data-toggle="tooltip-primary" data-placement="top" title="Ver flujo solicitud" onclick="mostrarFlujoSolicitud()"></i>`;
                }
              }

              $("#tableDocumentosAsociados tbody").append(`
                <tr>
                  <td>${index_doc + 1}</td>
                  <td>${strBorrarDoc} ${strEditDoc} ${strFlujo} ${strHistorialDoc} ${strVerDoc}</td>
                  <td>${tipo_doc}</td>
                  <td>${nombre_archivo}</td>
                  <td>${tamanio_mb} MB</td>
                  <td>${documento_origen.replaceAll('_',' ')}</td>
                </tr>
              `);
            });
          }else{
            $('#tableDocumentosAsociados tbody').append(`
                <tr>
                    <td colspan="5">
                      <span class="tx-italic">No hay documentos asociados</span>
                    </td>
                </tr>
              `);
            modal_error(response.message,'modalAdministracion');
          }
        } // success
      }); // ajax
    }
    */

  </script>
