{{-- AUDIENCIAS--}}

  <div class="form-layout">
    <div class="row mg-b-25">
      <br>
      {{--SECCION EDICION DE AUDIENCIAS--}}
      <div class="col-lg-12">
        @if( isset($permisos[82]) and $permisos[82] == 1 )
          <div id="accordionAudienciasEditar" class="accordion-one mg-b-10" role="tablist" aria-multiselectable="true" width="100%" style="display:none">
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
        @endif
        @if( isset($permisos[81]) and $permisos[81] == 1 )  
          <div id="accordionAudienciasCrear" class="accordion-one mg-b-10" role="tablist" aria-multiselectable="true" width="100%">
            <div class="card">
              <div class="card-header" role="tab" id="headingOne">
                <a id="titleAccordionAudienciasCrear" data-toggle="collapse" data-parent="#accordionAudienciasCrear" href="#collapseOneAudienciasCrear" aria-expanded="true" aria-controls="collapseOneAudienciasCrear" class="bkg-collapsed-btn tx-gray-800 transition collapsed tx-white" onclick="nueva_audiencia()">
                  Nueva Audiencia
                </a>
              </div><!-- card-header -->
              <div id="collapseOneAudienciasCrear" class="collapse" role="tabpanel" aria-labelledby="headingOneAudienciasCrear">
                <div class="card-body">
                  <div id="espacioCrearAudiencia" class="mg-t-15">

                  </div>
                </div> <!-- CARD BODY -->
              </div> <!-- BODY COLLAPSE -->
            </div> <!-- CARD -->
          </div> <!-- ACCORDEON EDCIIOND E AUDIENCIAS -->
        @endif
      </div>
      <br>

      {{-- SECCION TABLA AUDIENCIAS --}}
      <div class="col-lg-12">
        <br>
        <h5 class="form-control-label">Audiencias (<span style="font-size: 0.7em" id="carpetaActivaNavVar_"></span>)</h5>
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
            <div class="table-responsive">
              <table id="tableAudiencias" class="display dataTable dtr-inline collapsed">
                <thead style="background-color: #EBEEF1; color: #000;">
                  <tr>
                    <th>#</th>
                    <th  style="min-width:100px;">Acciones</th>
                    <th  style="min-width:150px;">Ver Sala</th>
                    <th  style="min-width:150px;">Notificación Majo</th>
                    <th  style="min-width:80px;">Id Evento</th>
                    <th  style="min-width:150px;">Situación</th>
                    <th  style="min-width:100px;">Fecha Audiencia</th>
                    <th  style="min-width:180px;">Hora Programada</th>
                    <th  style="min-width:100px;">Horario Realizacion</th>
                    <th  style="min-width:200px;">Tipo Audiencia</th>
                    <th  style="min-width:180px;">Centro de Justicia<br>Pro Mujer</th>
                    <th  style="min-width:180px;">Unidad de Gestión</th>
                    <th  style="min-width:100px;">Inmueble</th>
                    <th  style="min-width:100px;">Sala</th>
                    <th  style="min-width:100px;">Recursos</th>
                    <th  style="min-width:100px;">Juez</th>
                    <th  style="min-width:100px;">Total imputados</th>
                    <th  style="min-width:230px;">Imputados</th>
                    <th  style="min-width:230px;">Delitos</th>
                    <th  style="min-width:230px;">Carpeta de Investigacion</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
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

  <style type="text/css" >
    .arrowClick{
      cursor: pointer;
    }
    .arrowClick:active{
      transform: scale(0.95);
    }

    .ui-datepicker-year{
      border: none;
      color: #5B93D3;
      font-weight: 500;
    }
    .ui-datepicker-year:focus{
      outline: none;
    }
    .infor{
      width: 100%;
      box-shadow: 7px 7px 34px -17px #ccc;
      margin: 7px 0;
      border-radius: 0px 15px 0px 0px;
    }
    .infor_brand{
      border-radius: 0px 15px 0px 0px;
      background: #848F33;
      color: #fff;
      padding: 2px 0;
    }
    .fecha_hora_info{
      font-size: 0.9em;
    }
    .nombre_inmueble{
      font-size: 0.9em;
    }
    .infor_body i{
      background: #fff;
      color: #848F33;
      font-size: 3.2em;
      margin: 3% 0;
    }
    .infor_body{
      height: 115px;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
    }
    .www{
      width: 285px;
      margin: 7px auto;
      height: 140px;
      border-left: 6px solid #848f33;
      display: flex;
      justify-content: space-between;
      flex-direction: column;
      box-shadow: 7px 7px 34px -17px #ccc;
    }
    .www_title{
      font-size: 0.9em;
      font-weight: bold;
      color: #848f33;
      padding: 2% 0;
    }
    #tabs_audiencias_infos{
      display:block; 
      width: 240px; 
      height: auto; 
      border-right: 2px solid #848f334a;
    }
    .barra_tabs{
      display: flex; 
      justify-content: space-between; 
      flex-direction: column; 
      align-items: start; 
      border-bottom:none !important;
    }
    .item_barra{
      color: #848F33; 
      width: 100%; 
      border-left: 3px solid #848F33; 
      text-align: left; 
      margin: 5% 0;
    }
    @media(min-width: 1441px) {
      .infor_body {
        height: 139px;
      }
    }

    @media(max-width: 1024px) {
      /*Tbas responsivas de la info de la audiencia*/
      #tabs_audiencias_infos{
        display: block !important;
        min-width: 100%;
        border-right: 0px;
        overflow-x: auto;
      }
      .barra_tabs{
        flex-direction: row; 
        height: 50px;
      }
      .barra_tabs .item_barra:nth-child(1){ min-width: 155px; margin: 0;}
      .barra_tabs .item_barra:nth-child(2){ min-width: 177px; margin: 0;}
      .barra_tabs .item_barra:nth-child(3){  margin: 0;}
      .barra_tabs .item_barra:nth-child(4){ min-width: 167px; margin: 0;}
      .barra_tabs .item_barra:nth-child(5){ min-width: 146px; margin: 0;}
      .barra_tabs .item_barra:nth-child(6){ min-width: 165px; margin: 0;}
      .barra_tabs .item_barra:nth-child(7){ min-width: 285px; margin: 0;}
      
      #nav-tabContent-info-audiencia{
        width: 100% !important;
      }
      .fecha_hora_info{
        font-size: 0.82em;
      }
      .nombre_inmueble{
        font-size: 0.82em;
      }
    }

    @media(max-width: 900px) {
      /*Tbas responsivas de la info de la audiencia*/
      #tabs_audiencias_infos{
        display: block !important;
        min-width: 100%;
        border-right: 0px;
        overflow-x: auto;
      }
      .barra_tabs{
        flex-direction: row; 
        height: 50px;
      }
      .barra_tabs .item_barra:nth-child(1){ min-width: 155px; margin: 0;}
      .barra_tabs .item_barra:nth-child(2){ min-width: 177px; margin: 0;}
      .barra_tabs .item_barra:nth-child(3){  margin: 0;}
      .barra_tabs .item_barra:nth-child(4){ min-width: 167px; margin: 0;}
      .barra_tabs .item_barra:nth-child(5){ min-width: 146px; margin: 0;}
      .barra_tabs .item_barra:nth-child(6){ min-width: 165px; margin: 0;}
      .barra_tabs .item_barra:nth-child(7){ min-width: 285px; margin: 0;}
            
      #nav-tabContent-info-audiencia{
        width: 100% !important;
      }
      .www{
        width: 215px;
      }
    }

    @media(max-width: 760px) {
      /*Tbas responsivas de la info de la audiencia*/
      #tabs_audiencias_infos{
        display: block !important;
        min-width: 100%;
        border-right: 0px;
        overflow-x: auto;
      }
      .barra_tabs{
        flex-direction: row; 
        height: 50px;
      }
      .barra_tabs .item_barra:nth-child(1){ min-width: 155px; margin: 0;}
      .barra_tabs .item_barra:nth-child(2){ min-width: 177px; margin: 0;}
      .barra_tabs .item_barra:nth-child(3){  margin: 0;}
      .barra_tabs .item_barra:nth-child(4){ min-width: 167px; margin: 0;}
      .barra_tabs .item_barra:nth-child(5){ min-width: 146px; margin: 0;}
      .barra_tabs .item_barra:nth-child(6){ min-width: 165px; margin: 0;}
      .barra_tabs .item_barra:nth-child(7){ min-width: 285px; margin: 0;}

      .infor_body{
        height: 120px;
        padding-bottom: 18px;
      }
      #nav-tabContent-info-audiencia{
        width: 100% !important;
      }
      #tablaFracciones_e, #tablaFracciones_e thead, #tablaFracciones_e tbody, #tablaFracciones_e th, #tablaFracciones_e td, #tablaFracciones_e tr {
		  	display: block;
		  }

		  #tablaFracciones_e thead tr {
		  	position: absolute;
		  	top: -9999px;
		  	left: -9999px;
		  }

      #tablaFracciones_e tr {
        margin: 0 0 1rem 0;
      }

      #tablaFracciones_e tr:nth-child(odd) {
        background: #fff;
      }

		  #tablaFracciones_e td {
		  	border: none;
		  	border-bottom: 1px solid #eee;
		  	position: relative;
		  	padding-left: 50%;
        display: block !important;
		  }

      #tablaFracciones_e td:nth-of-type(2){ 
        padding: 12px 1% !important; 
        border-left: 1px solid #eee; 
        border-right: 1px solid #eee; 
      }

		  #tablaFracciones_e td:before {
		  	position: absolute;
		  	top: 7px;
		  	left: 6px;
		  	width: 45%;
		  	padding-right: 10px;
		  	white-space: nowrap;
		  }

		  #tablaFracciones_e td:nth-of-type(1):before { content: "Fraccion"; }
      #tablaFracciones_e td:nth-of-type(2):before { content: ""; }
		  #tablaFracciones_e td:nth-of-type(3):before { content: "Solicitada"; }
		  #tablaFracciones_e td:nth-of-type(4):before { content: "Audiencia"; }
    }
    .addfr{
      color: #fff; 
      background: #848F33; 
      border: none; 
      border-radius: 50%; 
      padding: 2px 6px;
      cursor: pointer;
    }
    .addfr:focus{
      outline: none;
    }
    .fraccion16{
      width: 100%;
      border: none;
      background: #eee;
      padding: 4px;
      border-radius: 3px;
      font-size: 0.93em;
    }
    .fraccion16:focus{
      outline: none;
    }
    .actives{
      background: #848F33;
      color: #fff !important;
    }
    /* Switch personalizado*/
    .switch {
      position: relative;
      display: inline-block;
      width: 42px;
      height: 19px;
    }

    .switch input { 
      opacity: 0;
      width: 0;
      height: 0;
    }

    .slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #ccc;
      -webkit-transition: .4s;
      transition: .4s;
    }

    .slider:before {
      position: absolute;
      content: "";
      height: 12px;
      width: 12px;
      left: 4px;
      bottom: 4px;
      background-color: white;
      -webkit-transition: .4s;
      transition: .4s;
    }

    input:checked + .slider {
      background-color: #848F33;
    }

    input:focus + .slider {
      box-shadow: 0 0 1px #848F33;
    }

    input:checked + .slider:before {
      -webkit-transform: translateX(26px);
      -ms-transform: translateX(26px);
      transform: translateX(21px);
    }

    /* Rounded sliders */
    .slider.round {
      border-radius: 20px;
    }

    .slider.round:before {
      border-radius: 50%;
    }

    #tablaFracciones tr  td{
      display: table-cell;
      vertical-align: middle;
      text-align: center;
      padding: 1% 4px;
    }
    .add-frac{
      color: #848F33;
      font-weight: bold;
      font-size: 2em;
      cursor: pointer;
    }
    .add-frac:active{
      transform: scale(0.95);
    }
    .tr_added{
      width: 100%;
      border: none;
      padding: 4px;
      background: #f3f1f1;
    }
    .boton_quitar_remove{
      color: #CB4335;
      cursor: pointer;
    }
    .boton_quitar_remove:active{
      transform: scale(0.95);
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
    .lds-roller {
      display: inline-block;
      position: relative;
      width: 80px;
      height: 80px;
    }
    .lds-roller div {
      animation: lds-roller 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
      transform-origin: 40px 40px;
    }
    .lds-roller div:after {
      content: " ";
      display: block;
      position: absolute;
      width: 7px;
      height: 7px;
      border-radius: 50%;
      background: #fff;
      margin: -4px 0 0 -4px;
    }
    .lds-roller div:nth-child(1) {
      animation-delay: -0.036s;
    }
    .lds-roller div:nth-child(1):after {
      top: 63px;
      left: 63px;
    }
    .lds-roller div:nth-child(2) {
      animation-delay: -0.072s;
    }
    .lds-roller div:nth-child(2):after {
      top: 68px;
      left: 56px;
    }
    .lds-roller div:nth-child(3) {
      animation-delay: -0.108s;
    }
    .lds-roller div:nth-child(3):after {
      top: 71px;
      left: 48px;
    }
    .lds-roller div:nth-child(4) {
      animation-delay: -0.144s;
    }
    .lds-roller div:nth-child(4):after {
      top: 72px;
      left: 40px;
    }
    .lds-roller div:nth-child(5) {
      animation-delay: -0.18s;
    }
    .lds-roller div:nth-child(5):after {
      top: 71px;
      left: 32px;
    }
    .lds-roller div:nth-child(6) {
      animation-delay: -0.216s;
    }
    .lds-roller div:nth-child(6):after {
      top: 68px;
      left: 24px;
    }
    .lds-roller div:nth-child(7) {
      animation-delay: -0.252s;
    }
    .lds-roller div:nth-child(7):after {
      top: 63px;
      left: 17px;
    }
    .lds-roller div:nth-child(8) {
      animation-delay: -0.288s;
    }
    .lds-roller div:nth-child(8):after {
      top: 56px;
      left: 12px;
    }
    @keyframes lds-roller {
      0% {
        transform: rotate(0deg);
      }
      100% {
        transform: rotate(360deg);
      }
    }
    .buffering{
        width: 100%;
        padding: 10px;
        min-height: 200px;
        height: auto;
        text-align: center;
        background: rgba(0,0,0,0.8);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    #tableAudiencias tr td ,#tableAudiencias tr th{
      display: table-cell;
      vertical-align: middle;
      text-align: center;
    }
    .dot{
      width: 5px;
      height: 5px;
      position: absolute;
      right: 5px;
      top: 4px;
      background: #CB4335;
      border-radius: 50%;
      animation: pulse 1.2s ease-out infinite;
    }
    @keyframes pulse {
      0% {
          transform: scale(1);
      }
      50% {
          transform: scale(1.2);
      }
      100%{
          transform: scale(1);
      }
    }
    .status_audiencia{
      width: 8px;
      height: 8px;
      background: #23BF08;
      position: absolute;
      border-radius: 50%;
      left: 15%;
      top: 28%;
    }
    .confirm{
      background: #23BF08 !important;
    }
    .final{
      background: #2075d5 !important;
    }
    .cancel{
      background: #212529 !important;
    }
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
    #body-table1 tr td{
      display:table-cell; 
      vertical-align: middle;
    }



  </style>

  <style>
    /*EVENTO A DEFAULT*/
    .dhx_cal_event.event_bkg_azul div{
        background-color: #1796b0 !important;
        color: #fff !important;
    }
    
    /*EVENTOS A MODIFICAR*/
    .dhx_cal_event.event_bkg_rojo div{
        background-color: #900 !important;
        color: #fff !important;
    }

    /*EVENTOS DE LA SALA*/
    .dhx_cal_event.event_bkg_verde div{
        background-color: #030 !important;
        color: #fff !important;
    }
    
    /*EVENTOS DEL JUEZ*/
    .dhx_cal_event.event_bkg_naranja div{
        background-color: #E56A4B !important;
        color: #fff !important;
    }

    /*EVENTO A DEFAULT*/
    .bkg_azul{
      background-color: #1796b0 !important;
      opacity: 0.7;
    }
    
    /*EVENTOS A MODIFICAR*/
    .bkg_rojo{
      background-color: #900 !important;
      opacity: 0.7;
    }

    /*EVENTOS DE LA SALA*/
    .bkg_verde{
      background-color: #030 !important;
      opacity: 0.7;
    }
    
    /*EVENTOS DEL JUEZ*/
    .bkg_naranja{
      background-color: #E56A4B !important;
      opacity: 0.7;
    }
    
    .square-10 {
      display: inline-block;
      width: 10px;
      height: 10px;
    }

    .rounded-circle {
      border-radius: 50% !important;
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
    const catalogo_actos_investigacion = @php echo json_encode($actos_investigacion);@endphp;
    const catalogo_tipo_solucion_alterna = @php echo json_encode($tipo_solucion_alterna);@endphp;
    const catalogo_tipo_sobreseimiento = @php echo json_encode($tipo_sobreseimiento);@endphp;
    const catalogo_tipo_reparacion_danio = @php echo json_encode($tipo_reparacion_danio);@endphp;
    const catalogo_reparacion_danio = @php echo json_encode($reparacion_danio);@endphp;
    const catalogo_modalidad_reparacion_danio = @php echo json_encode($modalidad_reparacion_danio);@endphp;

    var arrRAA = [];
    var fracciones_totales = [];
    var newDA=null;
    var audiencia_activa = [];
    var newDAC = null;

    //variables de contador
    var count_days = 0;
    var count_months = 0;
    var count_years = 0;

    const permiso_cancelacion = parseInt("{{ $request->session()->get('id_tipo_usuario') }}")


    async function pintarAudiencias(pagina=1, id_carpeta_judicial=null){
      $("#tableAudiencias tbody tr").remove();

      if(id_carpeta_judicial ==null){
        carpetaDocumentosActiva = carpetaActiva ;
      }else{
        carpetaDocumentosActiva = await obtener_carpeta_por_id(  id_carpeta_judicial );
        if( carpetaDocumentosActiva == null )  return false;
      }

      $('#carpetaActivaNavVar_').html(carpetaDocumentosActiva.folio_carpeta)

      $.ajax({
        method:'POST',
        url:'/public/consulta_audiencias',
        data:{
          carpeta : carpetaDocumentosActiva.id_carpeta_judicial,
          id_solicitud : carpetaDocumentosActiva.id_solicitud,
          tipo_solicitud : carpetaDocumentosActiva.tipo_solicitud_,
        },
        success:function(response){
          arrA=[];
          console.log('Audiencias Carpeta',response);

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
                strVerInfoA = `<i class="fas fa-info-circle" style="cursor:pointer; padding: 5% 5%; font-size: 1.4em; color: #fff !important;" data-toggle="tooltip-primary" data-placement="top" title="Ver informacion Audiencia" onclick="verInfoAudiencia(${index})"></i>`;
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

              @if( isset($permisos[82]) and $permisos[82] == 1 )
                strEditarA = `<i class="fas fa-edit" style="cursor:pointer; padding: 5% 6%; font-size: 1.4em; font-weight: normal; color: #fff !important;" data-toggle="tooltip-primary" data-placement="top" title="Editar Audiencia" onclick="editarAudiencia(${index})"></i>`
              @endif
              strVerAcu = `<i class="fas fa-file-pdf" style="cursor:pointer; padding: 5% 7%; font-size: 1.4em; font-weight: normal; color: #fff !important;" title="Ver Documentos de Audiencia" style="cursor: pointer; padding: 4px 5px;" onclick="ver_acuse(${a.id_audiencia})" id="ver_acuse"></i>`

              if( bandera_solo_consulta ) strEditarA = '';

              let horario_real = ( a.hora_inicio_audiencia_real?'De '+a.hora_inicio_audiencia_real.substring(0,5):'' )+( a.hora_fin_audiencia_real?'<br> a '+a.hora_fin_audiencia_real.substring(0,5):'');
              horario_real = horario_real.length?horario_real:'<span class="tx-italic">Sin registro</span>';

              if(a.estatus_semaforo == 'Confirmada' || a.estatus_semaforo == 'confirmada' ){
                var estatus = `<div style="position:relative;">
                                <div class="status_audiencia confirm"></div>
                                <div style="color: #23BF08;text-transform: capitalize;">${a.estatus_semaforo}</div>
                              </div>`;
              }else if(a.estatus_semaforo == 'Finalizada' || a.estatus_semaforo == 'finalizada' ){
                var estatus = `<div style="position:relative;">
                                <div class="status_audiencia final"></div>
                                <div style="color: #2075d5;text-transform: capitalize;">${a.estatus_semaforo}</div>
                              </div>`;
              }else if(a.estatus_semaforo == 'Cancelado' || a.estatus_semaforo == 'cancelado'  || a.estatus_semaforo == 'cancelada' ){
                var estatus = `<div style="position:relative;">
                                <div class="status_audiencia cancel"></div>
                                <div style="color: #212529;text-transform: capitalize;">${a.estatus_semaforo}</div>
                              </div>`;
              }else{
                var estatus = `<div style="position:relative;">
                  <div class="status_audiencia confirm"></div>
                  <div style="color: #23BF08;text-transform: capitalize;">${a.estatus_semaforo}</div>
                </div>`;
              }

              var stream = '';

              if(a.estatus_audiencia == 'Finalizada' || a.estatus_audiencia == 'finalizada'){

                if(a.liga_audiencia === null){
                    liga_audiencia = 0; 
                }else{
                    liga_audiencia = a.liga_audiencia;
                }
                
                stream  = `<i class="far fa-play-circle" title="Visualizar Sala" style="cursor: pointer; color:#2075d5 !important; background:transparent !important; font-size:1.8em;" onclick="streaming(${a.id_audiencia},'${a.estatus_audiencia}', '${liga_audiencia}', '${a.clave_unidad}')"></i>`;
            
              }else if(a.estatus_audiencia == 'En desarrollo' || a.estatus_audiencia == 'en desarrollo'){

                if(a.liga_audiencia === null){
                    liga_audiencia = 0; 
                }else{
                    liga_audiencia = a.liga_audiencia;
                }

                stream = `<div style="position:relative; cursor:pointer; border:1px solid #CB4335; color:#CB4335; border-radius:5px; width:40%; margin:0 auto; font-size:0.7em; font-weight:bold;" onclick="streaming_live(${a.id_audiencia}, '${a.id_sala}', '${a.id_inmueble}')">
                                En Vivo <div class="dot"></div>
                            </div>`;
            
              }else if(a.estatus_audiencia == 'Cancelado' || a.estatus_audiencia == 'cancelado'){
                stream =  `<i class="fas fa-ban" title="Visualizar Sala" style="color:#CB4335 !important; font-size:1.5em;background: transparent; "></i>`;
              }else if(a.estatus_audiencia == 'En espera de confirmación' || a.estatus_audiencia == 'en espera de confirmación'){
                stream = `
                <i class="far fa-clock" title="En espera" style="color:#fff !important; font-size:1.5em;"></i>
                <div style="cursor: pointer; font-size: 0.9em; border: 1px solid #848f33; border-radius: 9px; width: 80%; margin: 7% auto 0 auto;" onclick="streaming_live(${a.id_audiencia}, '${a.id_sala}', '${a.id_inmueble}')">
                    <i class="fa fa-eye"></i> Ver Sala
                </div> 
                `;
              }else if(a.estatus_audiencia == 'Confirmada' || a.estatus_audiencia == 'confirmada'){
                stream = `
                <i class="far fa-clock" title="Confirmada" style="color:#fff !important;font-size:1.5em;"></i>
                <div style="cursor: pointer; font-size: 0.9em; border: 1px solid #848f33; border-radius: 9px; width: 80%; margin: 7% auto 0 auto;" onclick="streaming_live(${a.id_audiencia}, '${a.id_sala}', '${a.id_inmueble}')">
                    <i class="fa fa-eye"></i> Ver Sala
                </div> 
                `;
              }else{
                stream = `
                <i class="far fa-clock" title="En espera" style="color:#fff !important; font-size:1.5em;"></i>
                <div style="cursor: pointer; font-size: 0.9em; border: 1px solid #848f33; border-radius: 9px; width: 80%; margin: 7% auto 0 auto;" onclick="streaming_live(${a.id_audiencia}, '${a.id_sala}', '${a.id_inmueble}')">
                    <i class="fa fa-eye"></i> Ver Sala
                </div> 
                `;
              }


              var ver_sala = '';

              if(a.liga_audiencia === null){
                liga_audiencia = 0; 
              }else{
                  liga_audiencia = a.liga_audiencia;
              }

              ver_sala = `<div style="cursor: pointer; font-size: 1em; border: 1px solid #848f33; color:#848f33; border-radius: 9px; width: 80%; margin: 0 auto;" onclick="streaming_live(${a.id_audiencia}, '${a.id_sala}', '${a.id_inmueble}')">
                            <i class="far fa-play-circle" style="background:transparent; color: #848f33; font-size:1em;"></i> Ver Sala
                          </div> `;

              var notificado = a.notificacion_MAJO_SIAJOP;
              var estado = '';
              if(notificado == 1){
                  estado = `<i title="Enviado Majo con éxito" class="far fa-check-circle" style="background: transparent; padding: 2px 5px; font-size: 1.4em;color: #229954;"></i>`;
              }else{
                  estado = `<i title="Error envio con Majo" class="fas fa-ban" style="background: transparent; padding: 2px 5px; font-size: 1.4em;color: #992922;"></i>`;
              }
              
              majo = `<i class="icon ion-ios-redo" title="Reenviar a MAJO" style="cursor: pointer" onclick="ReenviarMAjo(${a.id_audiencia})" id="reenviarMajo"></i> 
                      ${estado}
                `;

              //majo = '<i class="icon ion-ios-redo" style="cursor:pointer; font-size: 1.3em; padding: 3px 7px;" title="Reenviar a MAJO" style="cursor: pointer" onclick="ver_solicitud(' +a.id_audiencia + ')" id="reenviarMajo"></i> ' +
              //'<i title="Enviado Majo con éxito" class="far fa-check-circle" style="background: transparent;font-size: 1.8em;color: #229954;"></i>';

              //<i class="fas fa-circle tx-${a.estatus_semaforo} d-inline-block mg-l-10 bkg-tras" data-toggle="tooltip-primary" data-placement="top" title="Audiencia ${a.estatus_semaforo}" ></i> 
              //<i class="fas fa-video d-inline-block mg-l-10 " data-toggle="tooltip-primary" data-placement="top" title="Ver Grabación" onclick="ver_grabacion_audiencia( ${index} )" ></i> 

              $('#tableAudiencias tbody').append(`
                <tr>
                  <td>${index+1}</td>
                  <td>${strEditarA} ${strVerInfoA} ${strVerAcu}</td>
                  <td>
                    ${stream}
                  </td>
                  <td>
                    ${majo}
                  </td>
                  <td>
                    ${a.id_audiencia}
                  </td>
                  <td>
                    <div>
                      ${estatus}
                      <div style="font-size: 0.8em; color: #b1b1b1;text-transform: capitalize;">
                        ${a.estatus_audiencia.toUpperCase()}
                      </div>
                    </div>
                  </td>
                  <td>${a.fecha_audiencia}</td>
                  <td> De ${a.hora_inicio_audiencia != null ?  a.hora_inicio_audiencia.substring(0,5) : ''} a ${a.hora_fin_audiencia != null ? a.hora_fin_audiencia.substring(0,5) : ''} </td>
                  <td>${horario_real}</td>
                  <td>${a.tipo_audiencia}</td>
                  <td>${a.centro_justicia_promujer}</td>
                  <td>${a.nombre_unidad}</td>
                  <td>
                    <div style="display: flex;justify-content: center;align-items: center;flex-direction: column;font-size: 0.8em; ">
                      <i class="far fa-building" style="background: transparent; color: #848f33;font-size: 2.9em;margin-bottom: 7%;"></i>  ${a.nombre_inmueble}
                    </div>
                  </td>
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

            if( response.message!="ERROR - sin referencia a datos" && response.message!="ERROR - sin datos asociados" ) modal_error('Consulta de Audiencias dice:<br>'+response.message,'modalAdministracion');
          }
        } // success
      }); // ajax

      obtenerAudenciasDGVP();
    }

    function ReenviarMAjo(id_audiencia){
      $.ajax({
          method:'POST',
          url:'/public/renotificar_audiencia_MAJO_SIAJOP ',
          data:{
            id_audiencia : id_audiencia,
          },
          success:function(response){
            console.log(response);
            if(response.status==100){
              modal_success('Se ha notificado Correctamente','modalAdministracion');
              pintarAudiencias();
            }else{
              loading(false);
              modal_error(response.message);
            }
          },
          error : function( errors ){
            loading(false);
            modal_error('Error :'+errors, 'modalAdministracion');
          }
      });        
    }


    function verInfoAudiencia( indexA ){
      audiencia_activa.length = 0;
      let a = arrA[ indexA ];
      let title=`Información de Audiencia ${a.id_audiencia}`;
      audiencia_activa = a;
      console.log('datos_info_audiencia',a);

      let carpeta_judicial_F = a.folio_carpeta; 
      let id_tipo_audiencia_F = a.id_tipo_audiencia;
      let victimas_F = a.victimas;
      let id_solicitud_F = a.id_solicitud;
      let id_audiencia_F = a.id_audiencia;

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

      let strEstatusA = `<div class="p-3 tx-${a.estatus_semaforo=='Confirmada' ? 'success' : ( a.estatus_semaforo == 'Finalizada' ? 'info' : 'dark' )}"><i class="fas fa-circle tx-${a.estatus_semaforo=='Confirmada' ? 'success' : ( a.estatus_semaforo == 'Finalizada' ? 'info' : 'dark' )} d-inline-block mg-l-10 bkg-tras"></i> ${a.estatus_semaforo}</div>`;

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
      @if( isset($permisos[83]) and $permisos[83] == 1 )

        strEstatusA = `
          <div class="dropdown">
            <a href="#" class="btn btn-outline-${a.estatus_semaforo=='Confirmada' ? 'success' : ( a.estatus_semaforo == 'Finalizada' ? 'info' : 'dark' )}" id="dropdown-menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fa fa-circle  mg-l-5 bkg-tras"></i>
              <span> ${a.estatus_semaforo} </span>
              <i class="fa fa-angle-down mg-l-5 bkg-tras"></i>
            </a>
            <div class="dropdown-menu dropdown-media-list wd-200">
              <div class="dropdown-menu-header">
                <label>Seleccione una opción</label>
              </div><!-- d-flex -->
              <div class="media-list">

                <a href="#" class="media ${a.estatus_semaforo == 'Confirmada' ? 'd-none' : ''}" onclick="estatusAudiencia(${indexA},'Confirmada')">
                  <div class="media-body">
                    <div>
                      <p> <i class="fa fa-circle tx-confirmada mg-l-5 bkg-tras"></i> Confirmada</p>
                    </div>
                  </div>
                </a>

                <a href="#" class="media ${a.estatus_semaforo == 'Finalizada' ? 'd-none' : ''}" onclick="estatusAudiencia(${indexA},'Finalizada')">
                  <div class="media-body">
                    <div>
                      <p> <i class="fa fa-circle tx-finalizada mg-l-5 bkg-tras"></i> Finalizada</p>
                    </div>
                  </div>
                </a>
                @if( isset($permisos[83]) and $permisos[83] == 1 )
                  <a href="#" class="media ${a.estatus_semaforo == 'Cancelada' ? 'd-none' : ''}" onclick="estatusAudiencia(${indexA},'Cancelado')">
                    <div class="media-body">
                      <div>
                        <p> <i class="fa fa-circle tx-cancelada mg-l-5 bkg-tras"></i> Cancelada</p>
                      </div>
                    </div>
                  </a>
                @endif

              </div><!-- media-list -->
            </div><!-- dropdown-menu -->
          </div>
        `;

      @endif
      //@endif

      let body=`
      <div class="row" style="display:block; margin-right:0px; margin-left:0px; display:flex; justify-content:space-between">
        
        {{-- //Tabs de la informacion de audiencia  --}}
        <div id="tabs_audiencias_infos">
          <nav style="height: 100%;">
            <div class="nav nav-tabs barra_tabs" id="nav-tab-info-audiencia" role="tablist" >
              <a class="item_barra nav-item nav-link active" id="nav-datos_audiencia-tab"        			                                                                                                                                                    data-toggle="tab" href="#nav-datos_audiencia"         			  role="tab" aria-controls="nav-datos_audiencia"        			    aria-selected="true">Datos de la audiencia</a> 
              <a class="item_barra nav-item nav-link"        id="nav-mandamientos_judiciales-tab"        	 onclick="elegirTab('mandamientos', ${id_tipo_audiencia_F},'${carpeta_judicial_F}',${id_solicitud_F}, ${id_audiencia_F})"                       data-toggle="tab" href="#nav-mandamientos_judiciales"         role="tab" aria-controls="nav-mandamientos_judiciales"        	aria-selected="true">Mandamientos judiciales</a> 
              <a class="item_barra nav-item nav-link"        id="nav-acciones_resolutivos-tab"   			     onclick="elegirTab('resolutivos', ${id_tipo_audiencia_F},'${carpeta_judicial_F}',${id_solicitud_F}, ${id_audiencia_F})"                        data-toggle="tab" href="#nav-acciones_resolutivos"            role="tab" aria-controls="nav-acciones_resolutivos"             aria-selected="false">Acciones/resolutivos</a> 
              <a class="item_barra nav-item nav-link"        id="nav-acuerdos_reparatorios-tab"      		   onclick="elegirTab('acuerdos_reparatorios', ${id_tipo_audiencia_F},'${carpeta_judicial_F}',${id_solicitud_F}, ${id_audiencia_F})"              data-toggle="tab" href="#nav-acuerdos_reparatorios"       		role="tab" aria-controls="nav-acuerdos_reparatorios"      		  aria-selected="false">Acuerdos reparatorios</a> 
              <a class="item_barra nav-item nav-link"        id="nav-medidas_cautelares-tab" 				       onclick="elegirTab('medidas_cautelares', ${id_tipo_audiencia_F},'${carpeta_judicial_F}',${id_solicitud_F}, ${id_audiencia_F})"                 data-toggle="tab" href="#nav-medidas_cautelares"  				    role="tab" aria-controls="nav-medidas_cautelares" 				      aria-selected="false">Medidas cautelares</a> 
              <a class="item_barra nav-item nav-link"        id="nav-medidas_proteccion-tab"   			       onclick="elegirTab('medidas_proteccion', ${id_tipo_audiencia_F},'${carpeta_judicial_F}', ${id_solicitud_F}, ${id_audiencia_F},${indexA})"  data-toggle="tab" href="#nav-medidas_proteccion"    			    role="tab" aria-controls="nav-medidas_proteccion"   			      aria-selected="false">Medidas de protección</a> 
              <a class="item_barra nav-item nav-link"        id="nav-condiciones_suspension_proceso-tab"   onclick="elegirTab('condicion_suspencion', ${id_tipo_audiencia_F},'${carpeta_judicial_F}', ${id_solicitud_F}, ${id_audiencia_F})"              data-toggle="tab" href="#nav-condiciones_suspension_proceso"  role="tab" aria-controls="nav-condiciones_suspension_proceso"   aria-selected="false">Condiciones de suspensión de proceso </a> 
            </div>
          </nav>
        </div>

        <div class="tab-content" id="nav-tabContent-info-audiencia" style=" width: calc(100% - 260px); ">
        
          <div class="tab-pane fade show active" id="nav-datos_audiencia" role="tabpanel" aria-labelledby="nav-datos_audiencia-tab">
            @include('carpetas.tabs.sub-tabs-info-audiencia.datos_audiencia')
          </div><!-- tab-datos_audiencia -->

          <div class="tab-pane fade show" id="nav-mandamientos_judiciales" role="tabpanel" aria-labelledby="nav-mandamientos_judiciales-tab" >
            @include('carpetas.tabs.sub-tabs-info-audiencia.mandamientos_judiciales')
          </div><!-- tab-mandamientos_judiciales -->

          <div class="tab-pane fade" id="nav-acciones_resolutivos" role="tabpanel" aria-labelledby="nav-acciones_resolutivos-tab" >
            @include('carpetas.tabs.sub-tabs-info-audiencia.acciones_resolutivos')
          </div><!-- tab-acciones_resolutivos -->

          <div class="tab-pane fade" id="nav-acuerdos_reparatorios" role="tabpanel" aria-labelledby="nav-acuerdos_reparatorios-tab" >
            @include('carpetas.tabs.sub-tabs-info-audiencia.acuerdos_reparatorios')
          </div><!-- tab-acuerdos_reparatorios -->

          <div class="tab-pane fade" id="nav-medidas_cautelares" role="tabpanel" aria-labelledby="nav-medidas_cautelares-tab" >
            @include('carpetas.tabs.sub-tabs-info-audiencia.medidas_cautelares')
          </div><!-- tab-medidas_cautelares -->

          <div class="tab-pane fade" id="nav-medidas_proteccion" role="tabpanel" aria-labelledby="nav-medidas_proteccion-tab" >
            @include('carpetas.tabs.sub-tabs-info-audiencia.medidas_proteccion')
          </div><!-- tab-medidas_proteccion -->
          
          <div class="tab-pane fade" id="nav-condiciones_suspension_proceso" role="tabpanel" aria-labelledby="nav-condiciones_suspension_proceso-tab" >
            @include('carpetas.tabs.sub-tabs-info-audiencia.condiciones_suspension_proceso') 
          </div><!-- tab-condiciones_suspension_proceso -->
          

        </div> 

      </div>
      `;

      setTimeout(function(){
        if(a.estatus_semaforo == 'Cancelado' || a.estatus_semaforo == 'cancelado' || a.estatus_audiencia == 'Cancelado' || a.estatus_audiencia == 'Cancelada'  ){
          $('#comentsCancelado').removeClass('d-none');
          $('#comentsCancelado').addClass('d-block');
        }else{
          $('#comentsCancelado').removeClass('d-block');
          $('#comentsCancelado').addClass('d-none');
        }
      },1000);

      modal_historial(title,body,'modalAdministracion', true);

    }

    function listar_acta_minima( id_audiencia ) {
      let audiencia  = arrA.filter( x => x.id_audiencia == id_audiencia )[0];
      id_documento = audiencia.id_doc_acta_minima;
      
      if( id_documento == null ){
        return false;
      }

      $.ajax({
        method:'POST',
        url:'/public/obtener_documentos_asociados_carpeta',
        data:{
          carpeta : carpetaActiva.id_carpeta_judicial,
          id_solicitud : carpetaActiva.id_solicitud,
          tipo_solicitud : carpetaActiva.tipo_solicitud_,
          id_documento :id_documento,
          documento_nombre: "Acta_minima",
          extension: "pdf" ,
          documento_origen : "CJ" 
        },
        success:function(response){
          if( !response.message){
            $("#lista_docs").append(`
              <div class="documento" onclick="ver_acuse_pdf(${id_audiencia}, '${response.response}')" style="cursor: pointer; border: 1px solid #848f33; border-radius: 4px; padding: 7px 10px 7px 20px; margin-bottom: 5%; text-align: left;">
                <i class="fa fa-file-pdf" style="color: #848f33; font-size: 1.1em; margin-right: 3%;"></i>
                Acta Minima
              </div>
            `);
                                
          }else{
            modal_error(response.message,'modalAdministracion');
          }
        } // success
      }); // ajax
    }

    function ver_documento_cancelacion_audiencia( id_audiencia ){
      $.ajax({
        method:'POST',
        url:'/public/consultar_documento_cancelacion_audiencia',
        data:{ id_audiencia },
        success:function(response){
          if( response.status==100){
            modal_generico('DOCUMENTO CANCELACION AUDIENCIA',`
              <div class="file-group">
                <div class="file-item">
                  <div class="row no-gutters wd-100p">
                    <div class="col-9 col-sm-7 d-flex align-items-center">
                      <i class="fa fa-file-pdf-o" style="font-size:20px;"></i>
                      <a href="">${response.nombre}</a>
                    </div><!-- col-6 -->
                  </div><!-- row -->
                </div><!-- file-item -->
              </div>
              <object data="${response.response}"	width="100%"	height="600">	</object>
            `,'modalHistory');
          }else{
            modal_error(response.message,'modalHistory');
          }
        } // success
      }); // ajax

    }


    @if( isset($permisos[82]) and $permisos[82] == 1 )
      async function editarAudiencia( indexA ){
        let audiencia = arrA[ indexA ];
        arrRAA = [];

        //var json =  JSON.stringify(audiencia)
        //console.log('Audiencia: '+json);

        $("#accordionAudienciasCrear").hide();
        $("#accordionAudienciasEditar").show();
        $("#collapseOneAudienciasEditar").collapse('show');

        let strOptionTA = ``;
        for( var i in tipos_audiencia ){
          strOptionTA = strOptionTA + `
            <option value="${tipos_audiencia[i].id_ta}" ${tipos_audiencia[i].id_ta== audiencia.id_tipo_audiencia ? 'selected' : '' }> ${tipos_audiencia[i].tipo_audiencia} </option>
          `;
        }

        let strOptionJ = `<option value="${audiencia.id_juez}" data-cve="${audiencia.juez.cve_juez}" selected}>[${audiencia.juez.cve_juez}] ${audiencia.juez.nombre_usuario} </option>`;

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
            let btnEdit = `<i class="fas fa-edit" data-toggle="tooltip-primary" data-placement="top" title="Editar Recurso" onclick="editarRecurso(${i})"></i>`;
            let btnDelete = `<i class="fas fa-trash" data-toggle="tooltip-primary" data-placement="top" title="" onclick="estatusRecurso(${i})"></i>`;
            arrRAA[i].storage = 1 ;

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


        let str_optionNR = ``;
        let nomRecurso = await obtener_recursos_hijos( recursos_audiencia[0].id_tipo_recurso );
        //let nomRecurso = await obtener_recursos_hijos( recursos_audiencia[0].id_tipo_recurso );
        if( nomRecurso.status==100 ){
          if( typeof nomRecurso.response === 'string' || (nomRecurso.response).length == 0 || (nomRecurso.response[0].recursos).length == 0 ) str_optionNR = str_optionNR + `<option value="null" disabeld selected > No hay recursos de este tipo </option>`;
          else{
            for ( var i in nomRecurso.response[0].recursos ){
              r = nomRecurso.response[0].recursos[i];
              str_optionNR = str_optionNR + `<option value="${r.id_recurso_audiencia}"> ${r.nombre_recurso} </option> `;
            }
          }
        }else{
          str_optionNR = str_optionNR + `<option value="null" disabeld selected > Error al obtener tipo de recursos </option>`;
        }
        // if( nomRecurso.response[0] )
        // for ( var i in nomRecurso.response[0].recursos ){
        //   r = nomRecurso.response[0].recursos[i];
        //   str_optionNR = str_optionNR + `<option value="${r.id_recurso_audiencia}"> ${r.nombre_recurso} </option> `;
        // }

        $("#espacioEditarAudiencia").empty();
        $("#espacioEditarAudiencia").append(`
          <input type="hidden" name="id_audiencia" id="id_audiencia" value="${audiencia.id_audiencia}">

          <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
              <a class="nav-item nav-link active" id="nav-edicion-audiencia-tab" data-toggle="tab" href="#nav-edicion-audiencia" role="tab" aria-controls="nav-edicion-audiencia" aria-selected="true">Datos de Audiencia</a>
              <a class="nav-item nav-link" id="nav-edicion-recursos-tab" data-toggle="tab" href="#nav-edicion-recursos" role="tab" aria-controls="nav-edicion-recursos" aria-selected="false">Recursos Adicionales</a>
            </div>
          </nav> 

          <div class="tab-content" id="nav-tabContent">

            <div class="tab-pane fade show active" id="nav-edicion-audiencia" role="tabpanel" aria-labelledby="nav-edicion-audiencia">
              <div class="row">
                <div class="col-lg-6">
                  <div class="row"> <!-- FROM AUDIENCIA -->

                    <div class="col-lg-12 mg-b-20">
                      <br>
                      <label class="form-control-label">Tipo Audiencia :<span class="tx-danger">*</span> </label>
                      <select class="form-control select-edit" id="tipoAudiencia-A" name="tipoAudiencia-A" autocomplete="off">
                        ${strOptionTA}
                      </select>
                    </div>

                    <div class="col-lg-12 mg-b-20">
                      <div class="row">
                        <div class="col-md-8 sin_excusar">
                          <label class="form-control-label">Juez Asignado :<span class="tx-danger">*</span> </label>
                          <select class="form-control select-edit" id="juez-A" name="juez-A" autocomplete="off">
                            ${strOptionJ}
                          </select>
                        </div>
                        <div class="col-md-8 excusado" style="display: none">
                          <label class="form-control-label">Juez Asignado :<span class="tx-danger">*</span> </label>
                          <select class="form-control select-edit" id="juezExcusa-A" name="juezExcusa-A" autocomplete="off">
                          </select>
                        </div>
                        <div class="col-md-4">
                          <label class="ckbox mg-t-40">
                            <input id="juez_excusa-A" type="checkbox" onchange="excusar( this , '#juezExcusa-A'  )"><span>Excusar</span>
                          </label>
                        </div>
                        <div class="col-lg-12 excusado" style="display: none">
                          <div class="form-group">
                            <label class="form-control-label">Ingrese los motivos por los que desea asignar otro juez:</label>
                            <textarea class="form-control" name="motivoExcusa-A" id="motivoExcusa-A" rows="1" placeholder="Ingrese sus motivos"></textarea>
                          </div>
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
                              <input type="text" class="form-control datepicker-edit" placeholder="DD-MM-AAAA" value="${get_date( audiencia.fecha_audiencia , 'DD-MM-YYYY' )}" id="fecha-A" name="fecha-A" autocomplete="off" readonly onchange="pintar_eventos( '#sala-A' , this)">
                            </div>
                          </div>
                        </div>

                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="form-control-label">Hora inicio <span class="tx-danger">*</span> :</label>
                            <div class="d-flex">
                              <div class="input-group-prepend">
                                <div class="input-group-text">
                                  <i class="fa fa-clock-o tx-16 lh-0 op-6"></i>
                                </div><!-- input-group-text -->
                              </div><!-- input-group-prepend -->
                              <div class="input-group clockpicker-A" data-placement="right" data-align="top" data-autoclose="true">
                                <input  type="text" class="form-control" id="horaInicio-A" name="horaInicio-A" placeholder="hh:mm" value="${arrA[ indexA ].hora_inicio_audiencia != null ? arrA[ indexA ].hora_inicio_audiencia.substring(0,5) : ''}" onchange="poner_hora_termino()">
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="form-control-label">Hora termino <span class="tx-danger">*</span> :</label>
                            <div class="d-flex">
                              <div class="input-group-prepend">
                                <div class="input-group-text">
                                  <i class="fa fa-clock-o tx-16 lh-0 op-6"></i>
                                </div><!-- input-group-text -->
                              </div><!-- input-group-prepend -->
                              <div class="input-group clockpicker-A" data-placement="left" data-align="top" data-autoclose="true">
                                <input  type="text" class="form-control" id="horaTermino-A" name="horaTermino-A" placeholder="hh:mm" value="${arrA[ indexA ].hora_fin_audiencia != null ? arrA[ indexA ].hora_fin_audiencia.substring(0,5) : ''}" onchange="redimensiona_evento_audiencia(${audiencia.id_audiencia})">
                              </div>
                            </div>
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>

                  <div class="row"> <!-- BOTONES -->

                    <div class="col-lg-6 col-md-6" align="left">
                      <button type="button" class="btn btn-oblong btn-secondary" onclick="limpiarEspacioA('#espacioEditarAudiencia')" style="width: 100px;"> Cancelar </button>
                    </div>

                    <div class="col-lg-6 col-md-6" align="right">
                      <button type="button" class="btn btn-oblong btn-primary btn-guardarAudiencia-A" onclick="actualizarAudiencia()" style="width: 100px;"> Guardar </button>
                    </div>

                  </div>

                </div>
                
                <div class="col-lg-6">
                  <div id="calendario_audiencias" class="dhx_cal_container" style='width:100%; height:47vh;'>
                  </div>
                  <div class="d-flex align-items-center">
                    <span class="square-10 bkg_rojo rounded-circle"></span>
                    <span class="mg-l-3 tx-left" style="font-size: 0.8rem;">Evento en edición</span>
                    
                    <span class="mg-l-10 square-10 bkg_verde rounded-circle"></span>
                    <span class="mg-l-3 tx-left" style="font-size: 0.8rem;">Evento de sala</span>
                  </div>
                </div>

              </div>


            </div><!-- tab-edicion-audiencia -->

              
            <div class="tab-pane fade" id="nav-edicion-recursos" role="tabpanel" aria-labelledby="nav-edicion-recursos">
              <div class="row">
                <div class="col-lg-6">
                  <div class="card-body">
                    <div class="row">

                      <div class="col-lg-12">
                        <label class="form-control-label">Tipo recurso :<span class="tx-danger">*</span> </label>
                        <select class="form-control select-edit" id="id_tipo_recurso-A" name="id_tipo_recurso-A" autocomplete="off" onchange="refrescar_recursos( this.value , '#id_nombre_recurso-A' )">
                          ${strOptionR}
                        </select>
                      </div>
                      
                      <div class="col-lg-12">
                        <label class="form-control-label">Nombre recurso :<span class="tx-danger">*</span> </label>
                        <select class="form-control select-edit" id="id_nombre_recurso-A" name="id_nombre_recurso-A" autocomplete="off" onchange="pintar_eventos_recursos( '#id_tipo_recurso-A' ,this , '#fechaInicioRecurso-A' )">
                          ${str_optionNR}
                        </select>
                      </div>

                      <div class="col-lg-12 mg-b-20 col-md-12">
                        <div class="row">

                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="form-control-label">Fecha <span class="tx-danger">*</span> :</label>                   
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <div class="input-group-text">
                                    <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                  </div>
                                </div>
                                <input type="text" class="form-control datepicker-edit" placeholder="DD-MM-AAAA" value="${get_date( audiencia.fecha_audiencia , 'DD-MM-YYYY' )}" id="fechaInicioRecurso-A" name="fechaInicioRecurso-A" autocomplete="off" onchange="pintar_eventos_recursos( '#id_tipo_recurso-A', '#id_nombre_recurso-A', this )" readonly >
                              </div>
                            </div>
                          </div>
                          
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="form-control-label">Fecha <span class="tx-danger">*</span> :</label>
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <div class="input-group-text">
                                    <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                  </div>
                                </div>
                                <input type="text" class="form-control datepicker-edit" placeholder="DD-MM-AAAA" value="${get_date( audiencia.fecha_audiencia , 'DD-MM-YYYY' )}" id="fechaFinRecurso-A" name="fechaFinRecurso-A" autocomplete="off" readonly >
                              </div>
                            </div>
                          </div>

                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="form-control-label">Hora inicio <span class="tx-danger">*</span> :</label>
                              <div class="d-flex">
                                <div class="input-group-prepend">
                                  <div class="input-group-text">
                                    <i class="fa fa-clock-o tx-16 lh-0 op-6"></i>
                                  </div><!-- input-group-text -->
                                </div><!-- input-group-prepend -->
                                <div class="input-group clockpicker-A" data-placement="right" data-align="top" data-autoclose="true">
                                  <input  type="text" class="form-control time-edit-A" id="horaInicioRecurso-A" name="horaInicioRecurso-A" placeholder="hh:mm" value="${ arrA[ indexA ].hora_inicio_audiencia != null ? arrA[ indexA ].hora_inicio_audiencia.substring(0,5) : '' }" onchange="redimensiona_evento_recurso('#idRecursoAdicional-A')">
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="form-control-label">Hora termino <span class="tx-danger">*</span> :</label>
                              <div class="d-flex">
                                <div class="input-group-prepend">
                                  <div class="input-group-text">
                                    <i class="fa fa-clock-o tx-16 lh-0 op-6"></i>
                                  </div><!-- input-group-text -->
                                </div><!-- input-group-prepend -->
                                <div class="input-group clockpicker-A" data-placement="left" data-align="top" data-autoclose="true">
                                  <input  type="text" class="form-control time-edit-A" id="horaTerminoRecurso-A" name="horaTerminoRecurso-A" placeholder="hh:mm" value="${ arrA[ indexA ].hora_fin_audiencia != null ? arrA[ indexA ].hora_fin_audiencia.substring(0,5) : '' }" onchange="redimensiona_evento_recurso('#idRecursoAdicional-A')">
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

                        </div>

                        <div class="row justify-content-end"> <!-- BOTONES -->
                          <input type="hidden" id="idRecursoAdicional-A" name ="idRecursoAdicional-A" value="${get_unique_id()}">
                          <button class="btn btn-oblong btn-outline-primary" type="button" onclick="agregarRecurso()" id="btn-agregarRecurso-A"> Agregar Recurso </button>
                        </div>

                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div id="calendario_recursos" class="dhx_cal_container" style='width:100%; height:54vh;'>
                  </div>
                  <div class="d-flex align-items-center">
                    <span class="square-10 bkg_rojo rounded-circle"></span>
                    <span class="mg-l-3 tx-left" style="font-size: 0.8rem;">Recurso en edición</span>
                    
                    <span class="mg-l-10 square-10 bkg_verde rounded-circle"></span>
                    <span class="mg-l-3 tx-left" style="font-size: 0.8rem;">Recurso agendados</span>
                  </div>
                </div>

                <div class="col-lg-12">
                  <div class="row">
                    <div class="col-md-12">
                      <br>
                      <table id="table-recursos-audiencia" class="datatable tableDatosSujeto" style="overflow-x: none; display: table; text-align: left;">
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

                  <div class="row"> <!-- BOTONES -->
                    
                    <div class="col-lg-6 col-md-6" align="left">
                      <button type="button" class="btn btn-oblong btn-secondary" onclick="limpiarEspacioA('#espacioEditarAudiencia')" style="width: 100px;"> Cancelar </button>
                    </div>

                    <div class="col-lg-6 col-md-6" align="right">
                      <button type="button" class="btn btn-oblong btn-primary btn-guardarAudiencia-A" onclick="actualizarAudiencia()" style="width: 100px;"> Guardar </button>
                    </div>

                  </div>
                </div>
              </div>
            </div><!-- tab-edicion-recursos -->

          </div><!-- div-tabs-content -->  

          
        `);

        setTimeout( function(){ loadConfigComponentA(); }, 1000);
        setTimeout( function(){ pintar_eventos( '#sala-A', '#fecha-A'); }, 2000);
        setTimeout( function(){ $('#id_tipo_recurso-A').trigger('change'); $('#id_nombre_recurso-A').trigger('change'); }, 1000);
        setTimeout( function(){ pintar_eventos_recursos( '#id_tipo_recurso-A', '#id_nombre_recurso-A', '#fechaInicioRecurso-A'); }, 2000);
      }
    @endif
    
    function excusar( tag , tag_select ){
      //console.log( tag );

      /*
      if( carpetaActiva.tipo_solicitud_ == 'PRO-MUJER' || carpetaActiva.id_juez_ejecucion != null ){
        if( $(tag).is(':checked') ) $(tag).prop( "checked", false );
        modal_error('Esta carpeta tiene un juez predefinido, para cambiarlo hágado desde el tablero de carpetas judiciales','modalAdministracion');
        return false;
      }
      */

      if( $(tag).is(':checked') ){

        $(".sin_excusar").hide();
        $(".excusado").show();

        $.ajax({
          method:'POST',
          url:'/public/obtener_jueces_unidad',
          data:{
            id_unidad : carpetaActiva.id_unidad,
            descartar_jueces_con_incidencias:1,
            fecha_desde: get_date( $("#fecha-A").val() , 'YYYY-MM-DD' ) +" "+ $("#horaInicio-A").val()+":00",
            fecha_hasta: get_date( $("#fecha-A").val() , 'YYYY-MM-DD' ) +" "+ $("#horaTermino-A").val()+":00",
          },
          success:function(response){
            console.log( "consulta jueces excusa", response );
            $(tag_select).empty();

            if( response.status == 100 ){
              
              let array_jueces_desordenados = response.response;

              array_jueces_desordenados.sort(function (a, b) {
                if ( parseInt(a.cve_juez) > parseInt(b.cve_juez) ) {
                  return 1;
                } 
                if ( parseInt(a.cve_juez) < parseInt(b.cve_juez) ) {
                  return -1;
                }
                return 0;
              });

              array_jueces_ordenados = array_jueces_desordenados;
              
              for( var i in array_jueces_ordenados ){
                let juez = array_jueces_ordenados[i];
                console.log(juez);
                $(tag_select).append(`<option value="${juez.id_usuario}" data-cve="${juez.cve_juez}"> [${juez.cve_juez}] ${juez.nombres??''} ${juez.apellido_paterno??''} ${juez.apellido_materno??''} </option>`);
              }
            }else{
              $(tag_select).append(`<option value="null" data-cve="null" selected}> No se encontró a un juez de ejecucion. </option>` );
            }
          },
          error : function( errors ){
            modal_error('Error :'+ errors.message,'modalAdministracion');
            //modal_error('Error :'+ JSON.stringify(errors),'modalAdministracion');
          }
        });

      }else{
        $(".sin_excusar").show();
        $(".excusado").hide();
        return false;
      }
    }

    function agregarRecurso( indexRA=null ){

      let validador = validar_datos_evento('recurso', $("#idRecursoAdicional-A").val() );
      if( validador.status != 100){
        modal_error(validador.message, 'modalAdministracion');
        return false;
      }

      if( indexRA == null ){

        scheduler_recursos.getEvent($("#idRecursoAdicional-A").val()).color = 'verde';
        scheduler_recursos.updateEvent($("#idRecursoAdicional-A").val());

        arrRAA.push({
          //id_recurso : '0',
          id_recurso : $("#idRecursoAdicional-A").val(),
          id_tipo_recurso : $("#id_tipo_recurso-A").val(),
          descripcion : $("#id_tipo_recurso-A option:selected").text(),
          id_nombre_recurso : $("#id_nombre_recurso-A").val(),
          nombre_recurso : $("#id_nombre_recurso-A option:selected").text(),
          fecha_requerido_inicio : get_date( $("#fechaInicioRecurso-A").val() ),
          fecha_requerido_fin : get_date( $("#fechaFinRecurso-A").val() ),
          horario_requerido_inicio : $("#horaInicioRecurso-A").val()+':00',
          horario_requerido_fin : $("#horaTerminoRecurso-A").val()+':00',
          comentarios_recurso : $("#comentariosRecurso-A").val(),
          estatus : 1,
          storage : 0,
        });
        //$("idRecursoAdicional-A").val(get_unique_id());
      }else{

        scheduler_recursos.getEvent( arrRAA[indexRA].id_recurso ).color = 'verde';
        scheduler_recursos.updateEvent( arrRAA[indexRA].id_recurso );

        arrRAA[indexRA].id_tipo_recurso = $("#id_tipo_recurso-A").val();
        arrRAA[indexRA].descripcion = $("#id_tipo_recurso-A option:selected").text();
        arrRAA[indexRA].id_nombre_recurso = $("#id_nombre_recurso-A").val();
        arrRAA[indexRA].nombre_recurso = $("#id_nombre_recurso-A option:selected").text();
        arrRAA[indexRA].fecha_requerido_inicio = get_date( $("#fechaInicioRecurso-A").val() );
        arrRAA[indexRA].fecha_requerido_fin = get_date( $("#fechaFinRecurso-A").val() );
        arrRAA[indexRA].horario_requerido_inicio = $("#horaInicioRecurso-A").val()+':00';
        arrRAA[indexRA].horario_requerido_fin = $("#horaTerminoRecurso-A").val()+':00';
        arrRAA[indexRA].comentarios_recurso = $("#comentariosRecurso-A").val();
        //$("idRecursoAdicional-A").val(get_unique_id());
      }
      let id = get_unique_id();
      console.log('Nueno ID Recurso', id);
      $("#idRecursoAdicional-A").val(id);
      $("#comentariosRecurso-A").val('');
      
      $("#btn-agregarRecurso-A").text('Agregar Recurso');
      $("#btn-agregarRecurso-A").attr('onclick','agregarRecurso()');

      pintarRecursos();

    }

    function pintarRecursos(){
      $("#table-recursos-audiencia tbody tr").remove();
      for( var i in arrRAA){
        let r = arrRAA[i];
        console.log(r);
        let btnEdit = `<i class="fas fa-edit" data-toggle="tooltip-primary" data-placement="top" title="Editar Recurso" onclick="editarRecurso(${i})"></i>`;
        let btnDelete = `<i class="fas ${r.estatus == 1 ? 'fa-trash' : 'fa-trash-restore-alt'} " data-toggle="tooltip-primary" data-placement="top" title="Quitar Recurso" onclick="estatusRecurso(${i})"></i>`;

        $("#table-recursos-audiencia tbody").append(`
          <tr>
            <td>${ parseInt( i ) + 1}</td>
            <td> ${ btnDelete } ${  btnEdit } </td>
            <td>${ r.nombre_recurso }</td>
            <td>Del ${ r.fecha_requerido_inicio} a las ${r.horario_requerido_inicio.substring(0,5)} hrs. <br>hasta el ${r.fecha_requerido_fin} a las ${r.horario_requerido_fin.substring(0,5)} hrs.</td>
            <td>${ r.descripcion != null ?  r.descripcion : ''}</td>
            <td>${ r.comentarios_recurso != null ? r.comentarios_recurso : '' }</td>
          </tr>
        `);
      }

    }

    function editarRecurso( indexRA ){
      let r = arrRAA[ indexRA ];
      //console.log( r , arrRAA[ indexRA ] , indexRA  );
      $("#idRecursoAdicional-A").val( r.id_recurso );
      $("#id_tipo_recurso-A").val( r.id_tipo_recurso ).trigger('change');
      $("#fechaInicioRecurso-A").val( r.fecha_requerido_inicio );
      $("#fechaFinRecurso-A").val( r.fecha_requerido_fin );
      $("#horaInicioRecurso-A").val( r.horario_requerido_inicio.substring(0,5) );
      $("#horaTerminoRecurso-A").val( r.horario_requerido_fin.substring(0,5) );
      $("#comentariosRecurso-A").val( r.comentarios_recurso );

      $("#btn-agregarRecurso-A").attr('onclick', `agregarRecurso(${indexRA})`);
      $("#btn-agregarRecurso-A").text('Actualizar Recurso');

      setTimeout( function(){ 
        //console.log($("#id_nombre_recurso-A").val() , r.id_nombre_recurso, r );
        if( parseInt($("#id_nombre_recurso-A").val()) != parseInt(r.id_nombre_recurso) ){
          $("#id_nombre_recurso-A").val( parseInt(r.id_nombre_recurso) ).trigger('change'); 
          //console.log('entro es distinto');
        }
      },3000);
    }

    function estatusRecurso( indexRA ){

      if( arrRAA[indexRA].estatus == 1 ){
        scheduler_recursos.deleteEvent(arrRAA[indexRA].id_recurso);
        redimensiona_evento_recurso( "#idRecursoAdicional-A" );
      }

      if( arrRAA[indexRA].storage == 1) arrRAA[indexRA].estatus = arrRAA[indexRA].estatus == 1 ? 0 : 1;
      else{
        let arrRAA_clean = [];
        for( var i in arrRAA ){
          if( i == indexRA ) continue;
          else arrRAA_clean.push( arrRAA[i] ); 
        }
        arrRAA = arrRAA_clean;
      }
      
      pintarRecursos();
    }

    @if( isset($permisos[82]) and $permisos[82] == 1 )
      function actualizarAudiencia(){
        $(".btn-guardarAudiencia-A").attr("disabled", true);
        pintar_eventos( "#sala-A" , "#fecha-A" );
        setTimeout( function(){ console.log("espere")},1500);
        if(carpetaActiva.id_carpeta_judicial != 1640806159563){
          validador = validar_datos_evento( 'audiencia', $("#id_audiencia").val() );
          console.log(validador);
          if( validador.status != 100 ){
            modal_error( validador.message , 'modalAdministracion' );
            $(".btn-guardarAudiencia-A").attr("disabled", false);
            return false;
          }
        }

        //return false;

        let id_juez = $("#juez-A").val();
        let cve_juez = $("#juez-A option:selected").data('cve');
        let band_exc = 0;

        if( $("#juez_excusa-A").is(":checked") ){
          id_juez = $("#juezExcusa-A").val();
          cve_juez = $("#juezExcusa-A option:selected").data('cve');
          band_exc = 1;
        }

        $.ajax({
          method:'POST',
          url:'/public/modificar_audiencia_cj',
          async: false,
          data:{
            id_unidad : carpetaActiva.id_unidad,
            carpeta_judicial : carpetaActiva.id_carpeta_judicial,
            id_audiencia: $("#id_audiencia").val(),
            id_inmueble : $("#inmueble-A").val(),
            id_sala : $("#sala-A").val(),
            id_tipo_audiencia : $("#tipoAudiencia-A").val(),
            id_juez : id_juez,
            cve_juez : cve_juez,
            fecha_audiencia : $("#fecha-A").val().split('-').reverse().join('-'),
            hora_inicio_audiencia : $("#horaInicio-A").val()+':00',
            hora_fin_audiencia : $("#horaTermino-A").val()+':00',
            bandera_juez_tramite : 0, //$("#bandera_juez_tramite").val(),
            bandera_juez_excusa : band_exc,
            comentarios_excusa : band_exc == 1 ? $("#motivoExcusa-A").val() : '-', 
            recursos_audiencia : arrRAA,
          },
          success:function(response){
            console.log(response);
            if(response.status==100){
              //loading(false);
              modal_success('Audiencia modificada exitosamente','modalAdministracion');
              limpiarEspacioA( "#espacioEditarAudiencia" );
              pintarAudiencias();
            }else{
              loading(false);
              modal_error(response.message,'modalAdministracion');
              $(".btn-guardarAudiencia-A").attr("disabled", false);
              pintar_eventos( "#sala-A" , "#fecha-A" );
            }
          },
          error : function( errors ){
            loading(false);
            modal_error('Error :'+errors,'modalAdministracion');
            $(".btn-guardarAudiencia-A").attr("disabled", false);
            pintar_eventos( "#sala-A" , "#fecha-A" );
          }
        });
      }
    @endif

    function poner_hora_termino(){
      let fecha_audiencia = get_date( $("#fecha-A").val() , 'DD-MM-YYYY' );
      let hora = $("#horaInicio-A").val()
      let hora_final = get_time( alter_time( fecha_audiencia+' '+hora+':00' , '+' , '2' , 'h' ) , 'HH:mm');
      console.log( fecha_audiencia,hora,hora_final );
      $("#horaTermino-A").val( hora_final );
      $("#horaInicioRecurso-A").val( hora );
      $("#horaTerminoRecurso-A").val( hora_final );
      redimensiona_evento_audiencia( $("#id_audiencia").val() );
    }
    
    function poner_hora_termino_recurso(){
      let fecha_audiencia = get_date( $("#fecha-A").val() , 'DD-MM-YYYY' );
      let hora = $("#horaTermino-A").val()
      hora = get_time( alter_time( fecha_audiencia+' '+hora+':00' , '+' , '0' , 'h' ) , 'HH:mm');

      $("#horaTerminoRecurso-A").val( hora );
      //redimensiona_evento_recurso( $("#id_recurso").val() );
    }

    function redimensiona_evento_audiencia( id_evento ){

      if( !$( "#sala-A" ).val()  
          || !$( "#tipoAudiencia-A" ).val() 
          || !$( "#fecha-A" ).val() 
          || !$( "#horaInicio-A" ).val() 
          || !$( "#horaTermino-A" ).val() 
        )
      return false;
      
      if( ($( "#horaInicio-A" ).val()).length != 5 ||  ($( "#horaTermino-A" ).val()).length != 5)
      return false;

      if( new Date( get_date( $( "#fecha-A" ).val() ) + " " + $( "#horaInicio-A" ).val() + ":00" ).getTime() >= new Date( get_date( $( "#fecha-A" ).val() ) + " " + $( "#horaTermino-A" ).val() + ":00" ).getTime())
      return false;

      poner_hora_termino_recurso();
      excusar( '#juez_excusa-A' , '#juezExcusa-A'  ); // revisa si esta excusado, y refresca la lista de jueces;

      id_evento =  isNaN(id_evento) ? $(id_evento).val() : id_evento;

      scheduler_audiencia.deleteEvent(id_evento);

      setTimeout( function(){ 
        scheduler_audiencia.addEvent({
          color: 'rojo',
          start_date: new Date( get_date( $( "#fecha-A" ).val() ) + " " + $( "#horaInicio-A" ).val() + ":00" ),
          end_date:   new Date( get_date( $( "#fecha-A" ).val() ) + " " + $( "#horaTermino-A" ).val() + ":00" ),
          text:  $( "#tipoAudiencia-A option:selected" ).text() ,
          id : id_evento,
        }); 
      }, 1000);
    }

    function redimensiona_evento_recurso( tag_id_evento_recurso ){
      //console.log("entratrase a redimensiona_evento_recurso ", tag_id_evento_recurso)
      if( !$( "#id_tipo_recurso-A" ).val()  
          || !$( "#id_nombre_recurso-A" ).val() 
          || !$( "#fechaInicioRecurso-A" ).val() 
          || !$( "#fechaFinRecurso-A" ).val() 
          || !$( "#horaInicioRecurso-A" ).val() 
          || !$( "#horaTerminoRecurso-A" ).val() 
        )
      return false;

      if( ($( "#horaInicioRecurso-A" ).val()).length != 5 ||  ($( "#horaTerminoRecurso-A" ).val()).length != 5)
      return false;

      //console.log("pasaste as validaciones de redimensiona_evento_recurso")

      let id_evento_recurso = $(tag_id_evento_recurso).val();
      console.log(id_evento_recurso);
      //scheduler_recursos.deleteEvent(id_evento_recurso);

      setTimeout( function(){ 
        //console.log("Añade evento")
        scheduler_recursos.addEvent({
          color: 'rojo',
          start_date: new Date( get_date( $( "#fechaInicioRecurso-A" ).val() ) + " " + $( "#horaInicioRecurso-A" ).val() + ":00" ),
          end_date:   new Date( get_date( $( "#fechaFinRecurso-A" ).val() ) + " " + $( "#horaTerminoRecurso-A" ).val() + ":00" ),
          text:  $( "#id_tipo_recurso-A option:selected" ).text()+': '+$( "#id_nombre_recurso-A option:selected" ).text() ,
          id : id_evento_recurso,
        }); 
      }, 1000);

    }

    @if( isset($permisos[81]) and $permisos[81] == 1 )
      async function nueva_audiencia(){
        if( $("#collapseOneAudienciasCrear").attr("aria-expanded") == 'false' ){
          limpiarEspacioA('#espacioCrearAudiencia');
          return false;
        }

        arrRAA = [];
        fecha_audiencia = (new Date).toLocaleDateString();
        hora = (new Date).toLocaleTimeString();

        fecha_audiencia = fecha_audiencia.split('/');
        fecha_audiencia = fecha_audiencia[0].padStart(2, "0")+'-'+fecha_audiencia[1].padStart(2, "0")+'-'+fecha_audiencia[2] ;

        hora = hora.split(':');
        hora = hora[0].padStart(2, "0")+':'+hora[1].padStart(2, "0")+':'+hora[2].padStart(2, "0") ;
        
        let strOptionTA = ``;
        for( var i in tipos_audiencia ){
          strOptionTA = strOptionTA + `
            <option value="${tipos_audiencia[i].id_ta}" ${carpetaActiva.id_tipo_solicitud_audiencia == tipos_audiencia[i].id_ta ? 'selected' : '' }> ${tipos_audiencia[i].tipo_audiencia} </option>
          `;
        }

        let strOptionJ = ``;
        let juez = await obtener_jueces( 'sig_control' );
        if( juez.status == 100 ){
          //console.log(juez.response.id_usuario);
          //for (var i  in juez.response ){
            strOptionJ = strOptionJ + `<option value="${juez.response.id_usuario}" data-cve="${juez.response.cve_juez}"> ${juez.response.nombre??''} </option>`;
          //}
        }else{
          strOptionJ = `<option value="null" data-cve="null" selected> No se encontró al juez de control. </option>` ;
        }

        let strOptionI = ``;
        for( var i  in inmuebles ){
          strOptionI = strOptionI + `<option value="${inmuebles[i].id_inmueble}" ${carpetaActiva.id_inmueble == inmuebles[i].id_inmueble ? 'selected' : ''} > ${inmuebles[i].nombre_inmueble}</option>`;
        }

        let strOptionS = ``;
        let salas = await obtener_salas( carpetaActiva.id_inmueble );
        if( salas.status == 100 ){
          for( var i in salas = salas.response){
            strOptionS = strOptionS + `<option value="${salas[i].id_sala}"> ${salas[i].nombre_sala}</option>`;
          }
        }else{
          strOptionS = `<option value="null"> No se encontraron salas para este inmueble. </option>` ;
        }

        let strOptionR = ``;
        for( var i in recursos_audiencia ){
          strOptionR = strOptionR + `<option value="${recursos_audiencia[i].id_tipo_recurso}">${recursos_audiencia[i].tipo_recurso}</option>`;
        }
        
        let str_optionNR = ``;
        let nomRecurso = await obtener_recursos_hijos( recursos_audiencia[0].id_tipo_recurso );
        //let nomRecurso = await obtener_recursos_hijos( recursos_audiencia[0].id_tipo_recurso );
        if( nomRecurso.status==100 ){
          if( typeof nomRecurso.response === 'string' || (nomRecurso.response).length == 0 || (nomRecurso.response[0].recursos).length == 0 ) str_optionNR = str_optionNR + `<option value="null" disabeld selected > No hay recursos de este tipo </option>`;
          else{
            for ( var i in nomRecurso.response[0].recursos ){
              r = nomRecurso.response[0].recursos[i];
              str_optionNR = str_optionNR + `<option value="${r.id_recurso_audiencia}"> ${r.nombre_recurso} </option> `;
            }
          }
        }else{
          str_optionNR = str_optionNR + `<option value="null" disabeld selected > Error al obtener tipo de recursos </option>`;
        }

        let inputs_cambiar_juez = ``;
       // if( ! bandera_juez_predefinido ){
          inputs_cambiar_juez=`
            <div class="col-md-8 excusado" style="display: none">
              <label class="form-control-label">Juez Asignado :<span class="tx-danger">*</span> </label>
              <select class="form-control select-edit" id="juezExcusa-A" name="juezExcusa-A" autocomplete="off">
              </select>
            </div>
            <div class="col-md-8 juez_tramite" style="display: none">
              <label class="form-control-label">Juez Asignado :<span class="tx-danger">*</span> </label>
              <select class="form-control select-edit" id="juezTramite-A" name="juezTramite-A" autocomplete="off">
              </select>
            </div>
            <div class="col-md-2">
              <label class="ckbox mg-t-40">
                <input id="juez_tramite-A" type="checkbox" onchange="mostrar_juez_tramite( this , '#juezTramite-A'  )"><span>Juez Tramite</span>
              </label>
            </div>
            <div class="col-md-2">
              <label class="ckbox mg-t-40">
                <input id="juez_excusa-A" type="checkbox" onchange="excusar( this , '#juezExcusa-A'  )"><span>Excusar</span>
              </label>
            </div>
            <div class="col-lg-12 excusado" style="display: none">
              <div class="form-group">
                <label class="form-control-label">Ingrese los motivos por los que desea seleccionar a otro juez:</label>
                <textarea class="form-control" name="motivoExcusa-A" id="motivoExcusa-A" rows="1" placeholder="Ingrese sus motivos"></textarea>
              </div>
            </div>
          `;
        //}

        $("#espacioCrearAudiencia").empty();
        $("#espacioCrearAudiencia").append(`
          <input type="hidden" name="id_audiencia" id="id_audiencia" value="${get_unique_id()}">

          <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
              <a class="nav-item nav-link active" id="nav-edicion-audiencia-tab" data-toggle="tab" href="#nav-edicion-audiencia" role="tab" aria-controls="nav-edicion-audiencia" aria-selected="true">Datos de Audiencia</a>
              <a class="nav-item nav-link" id="nav-edicion-recursos-tab" data-toggle="tab" href="#nav-edicion-recursos" role="tab" aria-controls="nav-edicion-recursos" aria-selected="false">Recursos Adicionales</a>
            </div>
          </nav> 

          <div class="tab-content" id="nav-tabContent">

            <div class="tab-pane fade show active" id="nav-edicion-audiencia" role="tabpanel" aria-labelledby="nav-edicion-audiencia">
              <div class="row">
                <div class="col-lg-6">
                  <div class="row"> <!-- FROM AUDIENCIA -->

                    <div class="col-lg-12 mg-b-20">
                      <br>
                      <label class="form-control-label">Tipo Audiencia :<span class="tx-danger">*</span> </label>
                      <select class="form-control select-edit" id="tipoAudiencia-A" name="tipoAudiencia-A" autocomplete="off">
                        ${strOptionTA}
                      </select>
                    </div>

                    <div class="col-lg-12 mg-b-20">
                      <div class="row">
                        <div class="${bandera_juez_predefinido?'col-md-12':'col-md-8'} sin_excusar no_juez_tramite">
                          <label class="form-control-label">Juez Asignado :<span class="tx-danger">*</span> </label>
                          <select class="form-control select-edit" id="juez-A" name="juez-A" autocomplete="off">
                            ${strOptionJ}
                          </select>
                        </div>
                        ${inputs_cambiar_juez}
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
                              <input type="text" class="form-control datepicker-edit" placeholder="DD-MM-AAAA" value="${fecha_audiencia}" id="fecha-A" name="fecha-A" autocomplete="off" readonly onchange="pintar_eventos( '#sala-A' , this)">
                            </div>
                          </div>
                        </div>

                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="form-control-label">Hora inicio <span class="tx-danger">*</span> :</label>
                            <div class="d-flex">
                              <div class="input-group-prepend">
                                <div class="input-group-text">
                                  <i class="fa fa-clock-o tx-16 lh-0 op-6"></i>
                                </div><!-- input-group-text -->
                              </div><!-- input-group-prepend -->
                              <div class="input-group clockpicker-A" data-placement="right" data-align="top" data-autoclose="true">
                                <input  type="text" class="form-control time-edit-A" id="horaInicio-A" name="horaInicio-A" placeholder="hh:mm" value="${hora.substring(0,5)}" onchange="poner_hora_termino()">                                
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="form-control-label">Hora termino <span class="tx-danger">*</span> :</label>
                            <div class="d-flex">
                              <div class="input-group-prepend">
                                <div class="input-group-text">
                                  <i class="fa fa-clock-o tx-16 lh-0 op-6"></i>
                                </div><!-- input-group-text -->
                              </div><!-- input-group-prepend -->
                              <div class="input-group clockpicker-A" data-placement="left" data-align="top" data-autoclose="true">
                                <input  type="text" class="form-control time-edit-A" id="horaTermino-A" name="horaTermino-A" placeholder="hh:mm" value="${ get_time(  alter_time( fecha_audiencia.split('-').reverse().join('-')+' '+hora , action = '+' , time = '2' , type_time = 'h' )  , 'HH:mm') }" onchange="redimensiona_evento_audiencia('#id_audiencia')">
                              </div>
                            </div>
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>

                  <div class="row"> <!-- BOTONES -->

                    <div class="col-lg-6 col-md-6" align="left">
                      <button type="button" class="btn btn-oblong btn-secondary" onclick="limpiarEspacioA('#espacioCrearAudiencia')" style="width: 100px;"> Cancelar </button>
                    </div>

                    <div class="col-lg-6 col-md-6" align="right">
                      <button type="button" class="btn btn-oblong btn-primary btn-guardarAudiencia-A" onclick="guardarAudiencia()" style="width: 100px;"> Guardar </button>
                    </div>

                  </div>

                </div>
                
                <div class="col-lg-6">
                  <div id="calendario_audiencias" class="dhx_cal_container" style='width:100%; height:47vh;'>
                  </div>
                  <div class="d-flex align-items-center">
                    <span class="square-10 bkg_rojo rounded-circle"></span>
                    <span class="mg-l-3 tx-left" style="font-size: 0.8rem;">Evento en edición</span>
                    
                    <span class="mg-l-10 square-10 bkg_verde rounded-circle"></span>
                    <span class="mg-l-3 tx-left" style="font-size: 0.8rem;">Evento de sala</span>
                  </div>
                </div>

              </div>


            </div><!-- tab-edicion-audiencia -->

              
            <div class="tab-pane fade" id="nav-edicion-recursos" role="tabpanel" aria-labelledby="nav-edicion-recursos">
              <div class="row">
                <div class="col-lg-6">
                  <div class="card-body">
                    <div class="row">

                      <div class="col-lg-12">
                        <label class="form-control-label">Tipo recurso :<span class="tx-danger">*</span> </label>
                        <select class="form-control select-edit" id="id_tipo_recurso-A" name="id_tipo_recurso-A" autocomplete="off" onchange="refrescar_recursos( this.value , '#id_nombre_recurso-A' )">
                          ${strOptionR}
                        </select>
                      </div>
                      
                      <div class="col-lg-12">
                        <label class="form-control-label">Nombre recurso :<span class="tx-danger">*</span> </label>
                        <select class="form-control select-edit" id="id_nombre_recurso-A" name="id_nombre_recurso-A" autocomplete="off" onchange="pintar_eventos_recursos( '#id_tipo_recurso-A' ,this , '#fechaInicioRecurso-A' )">
                          ${str_optionNR}
                        </select>
                      </div>

                      <div class="col-lg-12 mg-b-20 col-md-12">
                        <div class="row">

                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="form-control-label">Fecha <span class="tx-danger">*</span> :</label>
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <div class="input-group-text">
                                    <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                  </div>
                                </div>
                                <input type="text" class="form-control datepicker-edit" placeholder="DD-MM-AAAA" value="${fecha_audiencia}" id="fechaInicioRecurso-A" name="fechaInicioRecurso-A" autocomplete="off" onchange="pintar_eventos_recursos( '#id_tipo_recurso-A', '#id_nombre_recurso-A', this )" readonly >
                              </div>
                            </div>
                          </div>
                          
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="form-control-label">Fecha <span class="tx-danger">*</span> :</label>
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <div class="input-group-text">
                                    <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                  </div>
                                </div>
                                <input type="text" class="form-control datepicker-edit" placeholder="DD-MM-AAAA" value="${fecha_audiencia}" id="fechaFinRecurso-A" name="fechaFinRecurso-A" autocomplete="off" readonly >
                              </div>
                            </div>
                          </div>

                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="form-control-label">Hora inicio <span class="tx-danger">*</span> :</label>
                              <div class="d-flex">
                                <div class="input-group-prepend">
                                  <div class="input-group-text">
                                    <i class="fa fa-clock-o tx-16 lh-0 op-6"></i>
                                  </div><!-- input-group-text -->
                                </div><!-- input-group-prepend -->
                                <div class="input-group clockpicker-A" data-placement="right" data-align="top" data-autoclose="true">
                                  <input  type="text" class="form-control" id="horaInicioRecurso-A" name="horaInicioRecurso-A" autocomplete="nope" placeholder="hh:mm" value="${ get_time( alter_time( fecha_audiencia.split('-').reverse().join('-')+' '+hora , true , '0' , 'm' )  ) }" onchange="redimensiona_evento_recurso('#idRecursoAdicional-A')">
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="form-control-label">Hora termino <span class="tx-danger">*</span> :</label>
                              <div class="d-flex">
                                <div class="input-group-prepend">
                                  <div class="input-group-text">
                                    <i class="fa fa-clock-o tx-16 lh-0 op-6"></i>
                                  </div><!-- input-group-text -->
                                </div><!-- input-group-prepend -->
                                <div class="input-group clockpicker-A" data-placement="left" data-align="top" data-autoclose="true">
                                  <input  type="text" class="form-control" id="horaTerminoRecurso-A" name="horaTerminoRecurso-A" autocomplete="nope" placeholder="hh:mm" value="${ get_time( alter_time( fecha_audiencia.split('-').reverse().join('-')+' '+hora , true , '2' , 'h' )  ) }" onchange="redimensiona_evento_recurso('#idRecursoAdicional-A')">
                                  <span class="input-group-addon">
                                      <span class="glyphicon glyphicon-time"></span>
                                  </span>
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

                        </div>

                        <div class="row justify-content-end"> <!-- BOTONES -->
                          <input type="hidden" id="idRecursoAdicional-A" name ="idRecursoAdicional-A" value="${get_unique_id()}">
                          <button class="btn btn-oblong btn-outline-primary" type="button" onclick="agregarRecurso()" id="btn-agregarRecurso-A"> Agregar Recurso </button>
                        </div>

                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-lg-6">
                  <div id="calendario_recursos" class="dhx_cal_container" style='width:100%; height:54vh;'>
                  </div>
                  <div class="d-flex align-items-center">
                    <span class="square-10 bkg_rojo rounded-circle"></span>
                    <span class="mg-l-3 tx-left" style="font-size: 0.8rem;">Recurso en edición</span>
                    
                    <span class="mg-l-10 square-10 bkg_verde rounded-circle"></span>
                    <span class="mg-l-3 tx-left" style="font-size: 0.8rem;">Recurso agendados</span>
                  </div>
                </div>

                <div class="col-lg-12">
                  <div class="row">
                    <div class="col-md-12">
                      <br>
                      <table id="table-recursos-audiencia" class="datatable tableDatosSujeto" style="overflow-x: none; display: table; text-align: left;">
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
                          <tr>
                            <td colspan="6" class="tx-center tx-bold">Sin Recursos Adicionales </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>

                  <div class="row"> <!-- BOTONES -->
                    
                    <div class="col-lg-6 col-md-6" align="left">
                      <button type="button" class="btn btn-oblong btn-secondary" onclick="limpiarEspacioA('#espacioCrearAudiencia')" style="width: 100px;"> Cancelar </button>
                    </div>

                    <div class="col-lg-6 col-md-6" align="right">
                      <button type="button" class="btn btn-oblong btn-primary btn-guardarAudiencia-A" onclick="guardarAudiencia()" style="width: 100px;"> Guardar </button>
                    </div>

                  </div>
                </div>
              </div>
            </div><!-- tab-edicion-recursos -->

          </div><!-- div-tabs-content -->  

          
        `);

        setTimeout( function(){ loadConfigComponentA(); $('inmueble-A').trigger('change'); }, 1000);
        setTimeout( function(){ pintar_eventos( '#sala-A', '#fecha-A'); }, 2000);
        setTimeout( function(){ $('#id_tipo_recurso-A').trigger('change'); $('#id_nombre_recurso-A').trigger('change'); }, 1000);
        setTimeout( function(){ pintar_eventos_recursos( '#id_tipo_recurso-A', '#id_nombre_recurso-A', '#fechaInicioRecurso-A'); }, 2000);
      }
    @endif

    function mostrar_juez_tramite( tag , tag_select ){
      console.log( tag );

      if( carpetaActiva.tipo_solicitud_ == 'PRO-MUJER' || carpetaActiva.id_juez_ejecucion != null ){
        if( $(tag).is(':checked') ) $(tag).prop( "checked", false );
        modal_error('Esta carpeta tiene un juez predefinido, para cambiarlo hágado desde el tablero de carpetas judiciales','modalAdministracion');
        return false;
      }

      if( $(tag).is(':checked') ){

        $(".no_juez_tramite").hide();
        $(".juez_tramite").show();

        $.ajax({
          method:'POST',
          url:'/public/obtener_juez_tramite',
          data:{
            id_unidad : carpetaActiva.id_unidad
          },
          success:function(response){
            console.log( "consulta jueces excusa", response );
            $(tag_select).empty();

            if( response.status == 100 ){
              for( var i in response.response ){
                let juez = response.response[i];
                console.log(juez);
                $(tag_select).append(`<option value="${juez.id_usuario}" data-cve="${juez.cve_juez}"> ${juez.nombres??''} ${juez.apellido_paterno??''} ${juez.apellido_materno??''} </option>`);
              }
            }else{
              $(tag_select).append(`<option value="null" data-cve="null" selected}> No se encontró a un juez de tramite. </option>` );
            }
          },
          error : function( errors ){
            modal_error('Error :'+ errors.message,'modalAdministracion');
          }
        });

      }else{
        $(".no_juez_tramite").show();
        $(".juez_tramite").hide();
        return false;
      }
    }

    @if( isset($permisos[81]) and $permisos[81] == 1 )
      async function guardarAudiencia(){
        $(".btn-guardarAudiencia-A").attr("disabled", true);
        console.log("bloqueo - validando");
        pintar_eventos( "#sala-A" , "#fecha-A" );
        await delay( 2500 );
        if(carpetaActiva.id_carpeta_judicial != 1640806159563){
          validador = validar_datos_evento( 'audiencia', $("#id_audiencia").val() );
          console.log(validador);
          if( validador.status != 100 ){
            modal_error( validador.message , 'modalAdministracion' );
            $(".btn-guardarAudiencia-A").attr("disabled", false);
            return false;
          }
        }

        let id_juez = $("#juez-A").val();
        let cve_juez = $("#juez-A option:selected").data('cve');
        let band_exc = 0;
        let band_tra = 0;

        if( $("#juez_tramite-A").is(":checked") ){
          id_juez = $("#juezTramite-A").val();
          cve_juez = $("#juezTramite-A option:selected").data('cve');
          band_tra = 1;
        }

        if( $("#juez_excusa-A").is(":checked") ){
          id_juez = $("#juezExcusa-A").val();
          cve_juez = $("#juezExcusa-A option:selected").data('cve');
          band_exc = 1;
          band_tra = 0;
        }


        $.ajax({
          method:'POST',
          url:'/public/crear_audiencia',
          async: false,
          data:{
            id_unidad : carpetaActiva.id_unidad,
            carpeta_judicial : carpetaActiva.id_carpeta_judicial,
            id_inmueble : $("#inmueble-A").val(),
            id_sala : $("#sala-A").val(),
            id_tipo_audiencia : $("#tipoAudiencia-A").val(),
            id_juez : id_juez,
            cve_juez : cve_juez,
            fecha_audiencia : $("#fecha-A").val().split('-').reverse().join('-'),
            hora_inicio_audiencia : $("#horaInicio-A").val()+':00',
            hora_fin_audiencia : $("#horaTermino-A").val()+':00',
            bandera_juez_tramite : band_tra, //$("#bandera_juez_tramite").val(),
            bandera_juez_excusa : band_exc,
            comentarios_excusa : band_exc == 1 ? $("#motivoExcusa-A").val() : '-', 
            comentarios : '-', 
            recursos_audiencia : arrRAA,
          },
          success:function(response){
            console.log(response);
            if(response.status==100){
              //loading(false);
              modal_success('Audiencia creada exitosamente','modalAdministracion');
              limpiarEspacioA( "#espacioCrearAudiencia" );
              pintarAudiencias();
            }else{
              loading(false);
              modal_error(response.message,'modalAdministracion');
              $(".btn-guardarAudiencia-A").attr("disabled", false);
              pintar_eventos( "#sala-A" , "#fecha-A" );
            }
          },
          error : function( errors ){
            loading(false);
            modal_error('Error :'+errors,'modalAdministracion');
            $(".btn-guardarAudiencia-A").attr("disabled", false);
            pintar_eventos( "#sala-A" , "#fecha-A" );
          }
        });
      }
    @endif

    function ver_grabacion_audiencia( indexRA ) {
      let a = arrA[ indexRA ];
      //url_video = a.url_video;
      let url_video , type = '';
      if( true ){ // aquí va status de audiencia, FINALIZADA presenta URL de .mp4
        url_video = "http://172.25.100.1:7001/SALA-10/20210104_123435_1111_1111_26.mp4";
        type = "mp4";
      }else{ //GRABANDO  Streaming de envivo.
        url_video = "rtmp://10.6.5.201:1935/live/sala31";
        type = "mp4";
      }

      title = "Grabación de Audiencia";
      body = `
        <video src="rtmp://10.6.5.201:1935/live/sala31">
        </video>
        <div id="reproductor">
        </div>
      `;
      marca_agua = `
        <div class="marca-agua" style="display: flex; position: absolute; z-index: 1; color: #adb5bd; opacity : 0.4 ; overflow: hidden; font-size: 14px; font-weight: bold;" align="justify" >
          @for( $i = 0 ; $i<=500 ; $i ++ )
            {{ $request->session()->get('usuario_nombre_completo')  }}  ({{ $request->session()->get('usuario_nombre')  }}) de la unidad {{ $request->session()->get('nombre_unidad') }} &nbsp; &nbsp;
            {{ $request->session()->get('usuario_nombre_completo')  }}  ({{ $request->session()->get('usuario_nombre')  }}) de la unidad {{ $request->session()->get('nombre_unidad') }} &nbsp; &nbsp;
            {{ $request->session()->get('usuario_nombre_completo')  }}  ({{ $request->session()->get('usuario_nombre')  }}) de la unidad {{ $request->session()->get('nombre_unidad') }} &nbsp; &nbsp;
            {{ $request->session()->get('usuario_nombre_completo')  }}  ({{ $request->session()->get('usuario_nombre')  }}) de la unidad {{ $request->session()->get('nombre_unidad') }} &nbsp; &nbsp;
            {{ $request->session()->get('usuario_nombre_completo')  }}  ({{ $request->session()->get('usuario_nombre')  }}) de la unidad {{ $request->session()->get('nombre_unidad') }} &nbsp; &nbsp;
          @endfor
        </div>
      `;

      modal_historial( title , body , "modalAdministracion" );

      setTimeout( function(){  
        let player = OvenPlayer.create("reproductor", {
          waterMark: {
            text: 'olv',
            font: {
              'font-size': '20px',
              'color': '#fff',
              'font-weight': 'bold',
            },
            position: 'bottom-right',
            width : 'auto',
            opacity : '0.7',
          },
          sources: [
            {
              "type": type,
              "file": url_video, 
              "label": "480p",
            },
          ],
          autoStart : true,
        });

        setTimeout( function(){ 
          $("#reproductor").prepend(marca_agua ) ;
          setTimeout( function(){ 

            $( "#reproductor" ).resize(function() {
              $( ".marca-agua" ).width(  $( "#reproductor" ).width()  );
              $( ".marca-agua" ).height(  $( "#reproductor" ).height()  );
            });
          }, 1000 );

        }, 2000 );

      }, 1000 );
    }


    // Ver Streaming
    function streaming(id_audiencia, status, url, unidad){
      title = "Grabación de Audiencia: " + id_audiencia;
      body = `
        <div id="reproductor" style="width:100%; height:auto;">
        </div>
      `;
      marca_agua = `
        <div class="marca-agua" style="display: flex; position: absolute; color: #adb5bd; opacity : 0.4 ; overflow: hidden; font-size: 14px; font-weight: bold;" align="justify" >
          @for( $i = 0 ; $i<=500 ; $i ++ )
            {{ $request->session()->get('usuario_nombre_completo')  }}  ({{ $request->session()->get('usuario_nombre')  }}) de la unidad {{ $request->session()->get('nombre_unidad') }} &nbsp; &nbsp;
            {{ $request->session()->get('usuario_nombre_completo')  }}  ({{ $request->session()->get('usuario_nombre')  }}) de la unidad {{ $request->session()->get('nombre_unidad') }} &nbsp; &nbsp;
            {{ $request->session()->get('usuario_nombre_completo')  }}  ({{ $request->session()->get('usuario_nombre')  }}) de la unidad {{ $request->session()->get('nombre_unidad') }} &nbsp; &nbsp;
            {{ $request->session()->get('usuario_nombre_completo')  }}  ({{ $request->session()->get('usuario_nombre')  }}) de la unidad {{ $request->session()->get('nombre_unidad') }} &nbsp; &nbsp;
            {{ $request->session()->get('usuario_nombre_completo')  }}  ({{ $request->session()->get('usuario_nombre')  }}) de la unidad {{ $request->session()->get('nombre_unidad') }} &nbsp; &nbsp;
          @endfor
        </div>
      `;
      
      $('#streaming_id').html(title);

      loader(true);

      setTimeout(function(){

          if(url != 0){
              let url_video , type = '';
              if( status == 'Finalizada' || status == 'finalizada'){ 

                  protocolo = url.substring(0,4);
                  if(protocolo == 'http'){
                      type = 'mp4';
                      url_video = url;
                  }else if(protocolo == 'rtmp'){

                      switch (unidad){
                          case '001':
                              type = 'mp4';
                              url_frag = url.split('/');
                              url_video = 'http://172.20.101.23:8083/'+url_frag[4];
                              break;

                          case '002':
                              type = 'mp4';
                              url_frag = url.split('/');
                              url_video = 'http://172.21.101.202:8083/'+url_frag[4];
                              break;
                          
                          case '003':
                              //esta en http
                              break;

                          case '004':
                              //Esta en http
                              break;

                          case '005':
                              //estan en http
                              break;

                          case '006':
                              type = 'mp4';
                              url_frag = url.split('/');
                              url_video = 'http://172.21.101.202:8083/'+url_frag[4];
                              break;

                          case '007':
                              type = 'mp4';
                              url_frag = url.split('/');
                              url_video = 'http://172.22.100.103:8083/'+url_frag[4];
                              break;

                          case '008':
                              type = 'mp4';
                              url_frag = url.split('/');
                              url_video = 'http://172.20.101.23:8083/'+url_frag[4];
                              break;

                          case '209':
                              type = 'mp4';
                              url_frag = url.split('/');
                              url_video = 'http://172.20.101.23:8083/'+url_frag[4];
                              break;

                          case '010':
                              type = 'mp4';
                              url_frag = url.split('/');
                              url_video = 'http://172.21.101.202:8083/'+url_frag[4];
                              break;

                          case '011':
                              type = 'mp4';
                              url_frag = url.split('/');
                              url_video = 'http://172.23.100.25/'+url_frag[4];
                              break;

                          case '012':
                              //Estan en http
                              break;
                      }
                  }
                  console.log(protocolo);
                  console.log(type);
              }else{ 
                  url_video = url;
                  type = "mp4";
              }

              setTimeout( function(){  
                  
                let player = OvenPlayer.create("reproductor", {
                  sources: [
                    {
                      "type": type,
                      "file": url_video, 
                    },
                  ],
                  autoStart : true,
                  controls: true,
                  expandFullScreenUI:true,
                  playbackRate: 1,
                  playbackRates : [5,4,3,2.5,2, 1.5, 1, 0.5, 0.25],
                  hidePlaylistIcon: true
              });

              OvenPlayer.debug(true);
                  
                  setTimeout( function(){
                    $(".op-media-element-container").prepend(marca_agua ) ;
                    setTimeout( function(){ 
                  
                      $( "#reproductor" ).resize(function() {
                        $( ".marca-agua" ).width(  $( "#reproductor" ).width()  );
                        $( ".marca-agua" ).height(  $( "#reproductor" ).height()  );
                      });
                    }, 500 );
                
                  }, 600 );
                  
              }, 1200 );

          }else{

              console.log(url);
              title = "Grabación de Audiencia: " + id_audiencia;
              var mensaje_url_null = `<div style="margin: 0 auto; color: #fff; font-weight:bold; font-size:0.9em; width:50%; border-radius:6px; border: 2px solid #fff; padding: 10px; text-align:center; line-height:30px;">Video No encontrado</div>`;

              setTimeout(function(){  
                  loader(false); 
                  $('#streaming_id').html(title);
                  $('#stream').html(mensaje_url_null);
              }, 2000);
          }

          $('#stream').html(body);

      },1000);

      $('#modalAdministracion').modal('hide');
      $('#modal-streaming').modal('show');
      
    }

    function streaming_live(id_audiencia, sala, inmueble){
          loader(true);
          
          var url = obtener_url_stream(sala,inmueble);
          console.log(url);
          var url_video = url.response[0].ws;

          var type = 'mp4';

          title = "Audiencia " + id_audiencia + " en vivo";
          body = `
            <div id="reproductor" style="width:100%; height:auto;">
            </div>
          `;

          marca_agua = `
            <div class="marca-agua" style="display: flex; position: absolute; z-index: 1; color: #adb5bd; opacity : 0.4 ; overflow: hidden; font-size: 14px; font-weight: bold;" align="justify" >
              @for( $i = 0 ; $i<=500 ; $i ++ )
                {{ $request->session()->get('usuario_nombre_completo')  }}  ({{ $request->session()->get('usuario_nombre')  }}) de la unidad {{ $request->session()->get('nombre_unidad') }} &nbsp; &nbsp;
                {{ $request->session()->get('usuario_nombre_completo')  }}  ({{ $request->session()->get('usuario_nombre')  }}) de la unidad {{ $request->session()->get('nombre_unidad') }} &nbsp; &nbsp;
                {{ $request->session()->get('usuario_nombre_completo')  }}  ({{ $request->session()->get('usuario_nombre')  }}) de la unidad {{ $request->session()->get('nombre_unidad') }} &nbsp; &nbsp;
                {{ $request->session()->get('usuario_nombre_completo')  }}  ({{ $request->session()->get('usuario_nombre')  }}) de la unidad {{ $request->session()->get('nombre_unidad') }} &nbsp; &nbsp;
                {{ $request->session()->get('usuario_nombre_completo')  }}  ({{ $request->session()->get('usuario_nombre')  }}) de la unidad {{ $request->session()->get('nombre_unidad') }} &nbsp; &nbsp;
              @endfor
            </div>
          `;

          setTimeout(function(){  
              loader(false); 
              $('#streaming_id').html(title);
              $('#stream').html(body);
          }, 1600);

          setTimeout( function(){  
              let player = OvenPlayer.create("reproductor", {
                  waterMark: {
                    text: 'olv',
                    font: {
                      'font-size': '20px',
                      'color': '#fff',
                      'font-weight': 'bold',
                    },
                    position: 'bottom-right',
                    width : 'auto',
                    opacity : '0.7',
                  },
                  sources: [
                    {
                      "type": type,
                      "file": url_video, 
                      "label": "480p",
                    },
                  ],
                  autoStart : true,
              });
          
              setTimeout( function(){ 
                $("#reproductor").prepend(marca_agua ) ;
                setTimeout( function(){ 
              
                  $( "#reproductor" ).resize(function() {
                    $( ".marca-agua" ).width(  $( "#reproductor" ).width()  );
                    $( ".marca-agua" ).height(  $( "#reproductor" ).height()  );
                  });
                }, 500 );
            
              }, 600 );
  
          }, 2500 );
          
          $('#modalAdministracion').modal('hide');
          $('#modal-streaming').modal('show');
          
    }

    function obtener_url_stream(sala, inmueble){
      var ws = $.ajax({
          method: 'POST',
          async: false,
          url: '/public/ws_salas',
          //  async: false,
          data: {
              id_sala: sala,
              id_inmueble: inmueble
          },
          success: function(response) {}
      });

      return ws.responseJSON;
    }

    function loader(accion){
      if(accion){
        $('#stream').append('<div id="loader"> <h5 style="color: #fff;">Consultando video</h5><div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>');
      }else{
          $('#loader').css('display', 'none');
      }
    }

    function cerrarStream(modal, modalAnterior){
      $('#stream').html('');
      $('#'+modal).modal('hide');
      $('#'+modalAnterior).modal('show');
    }

    //Ver acuse Audiencia
    function ver_acuse(id_audiencia){
      $('#visorPDFacuse').html('');
      $.ajax({
          method: 'POST',
          url: '/public/obtener_acuse_audiencia',
          data: {
              id_audiencia: id_audiencia,
          },
          success: function(response) {
              console.log(response);
              if(response.status == 100){
                  visorPDFAcuse = response.acuse;
                  visorPDFFormato = response.formato;

                  botones = '';

                  if(visorPDFAcuse.status == 100){
                      botones += `<div class="documento" onclick="ver_acuse_pdf(${id_audiencia}, '${visorPDFAcuse.response}')" style="cursor: pointer; border: 1px solid #848f33; border-radius: 4px; padding: 7px 10px 7px 20px; margin-bottom: 5%; text-align: left;">
                          <i class="fa fa-file-pdf" style="color: #848f33; font-size: 1.1em; margin-right: 3%;"></i>
                          ${visorPDFAcuse.nombre} <i class="fa fa-download d-md-none" aria-hidden="true"></i>
                      </div>`;
                  }

                  if(visorPDFFormato.status == 100){
                      botones += `<div class="documento" onclick="ver_acuse_pdf(${id_audiencia}, '${visorPDFFormato.response}')" style="cursor: pointer; border: 1px solid #848f33; border-radius: 4px; padding: 7px 10px 7px 20px; margin-bottom: 5%; text-align: left;">
                          <i class="fa fa-file-pdf" style="color: #848f33; font-size: 1.1em; margin-right: 3%;"></i>
                          Formato notificación a Juez de Control <i class="fa fa-download d-md-none" aria-hidden="true"></i>
                      </div>`;
                  }

                  pdf = `<embed src="${visorPDFAcuse.response}" type="application/pdf" width="100%" height="600px" class="d-none d-md-block" />`;
                  $('#visorPDFacuse').html(pdf);
                  $('#lista_docs').html(botones);
              }else{
                  botones = `<div class="documento" style="cursor: pointer; border: 1px solid #848f33; border-radius: 4px; padding: 7px 10px 7px 20px; margin-bottom: 5%; text-align: left;">
                      <i class="fa fa-file-pdf" style="color: #848f33; font-size: 1.1em; margin-right: 3%;"></i>
                      Sin documentos
                  </div>`;

                  pdf = `<div style="height: 600px;background: #444;display: flex;justify-content: center;align-items: center;flex-direction: column;font-size: 1.2em;;">
                              <i class="fa fa-file-pdf" style="color: #fff;font-size: 1.1em;margin-right: 3%;margin-bottom: 2%;font-size: 4em;"></i>
                              Sin Documento PDF
                          </div>`;

                  $('#visorPDFacuse').html(pdf);
                  $('#lista_docs').html(botones);
              }
          }
      });
      
      $('#modal-acuse').modal('show');
      $('#modalAdministracion').modal('hide');
      listar_acta_minima( id_audiencia );
    }

    function ver_acuse_pdf(id_audiencia, url=null){
      $('#visorPDFacuse').html('');

      if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {

        window.open(url, '_blank');

      } else { 
        pdf = `<embed src="${url}" type="application/pdf" width="100%" height="600px" />`;
        $('#visorPDFacuse').html(pdf);
      }
      
      
    }

    function cerrarAcuse(modal, modalAnterior){
      $('#'+modal).modal('hide');
      $('#'+modalAnterior).modal('show');
    }

    //
    // ESTATUS AUDIENCIA
    //
    @if( isset($permisos[82]) and $permisos[82] == 1 )
      function estatusAudiencia( indexA, estatus, modal=true ){
        if( modal ){
          let strInputFile = '';
          if( estatus == "Cancelado" ){
            strInputFile = `
              <div class="col-lg-12">
                <br>
                <form onsubmit="return false;" id="cargarDocumentoCancelacionAudiencia" action="/" enctype="multipart/form-data">
                  <div class="custom-input-file">
                    <input type="file" id="archivoCancelacionPDF" class="input-file" value="" name="archivoCancelacionPDF" accept=".pdf" onchange="leeDocumentoCancelacionAudiencia(this)" >
                    <h5 class="px-3 py-3">Arrastre hasta aquí su documento o de clic para adjuntarlo</h5>
                  </div>
                </form>
              </div>
              <div class="col-12 d-none" align="center">
                <object height="300px" width="100%" class="mg-t-25" id="previewDocumentoCancelacionAudiencia" data=""></object>
              </div>
            `;
          }

          $("#modalHistory").modal('hide');
          title = `Cambio de estatus de semáforo`;
          body = `
            <div class="row justify-content-md-center">
              <div class="col-lg-10">
                <label class="form-control-label"> Ingrese los motivos del porqué la audiencia cambia al estatus ${estatus.toUpperCase()} </label>
                <textarea class="form-control" name="motivoCambioEstatus-A" id="motivoCambioEstatus-A" rows="4"></textarea>
              </div>
              ${strInputFile}
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
              nombre : newDAC != null ? newDAC.nombre : null,
              extension : newDAC != null ? newDAC.extension : null,
              tamanio : newDAC != null ? newDAC.tamanio : null,
              b64 : newDAC != null ? newDAC.b64 : null,
            },
            success:function(response){
              console.log(response);
              if(response.status==100){
                //loading(false);
                modal_success('Semáforo de Audiencia cambiado exitosamente a '+estatus.toUpperCase(),'modalAdministracion');
                newDAC = null;
                $("#previewDocumentoCancelacionAudiencia").attr("data",""); 
                $("#previewDocumentoCancelacionAudiencia").parent().addClass('d-none');
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

      function leeDocumentoCancelacionAudiencia (input) {
        let acepted_files=["pdf","PDF"];

        let file = $(input).val();
        let ext = "";
        let extension = "";
        let nombre_documento = "";

        if(file.length){
          
          extension = file.substr( file.lastIndexOf(".") +1 , file.length - file.lastIndexOf(".") -1 );   
          extension = extension.toLowerCase();
          nombre_documento = (file.split('\\')[2]);
          nombre_documento = nombre_documento.substr( 0 , nombre_documento.lastIndexOf(".") );   
          nombre_documento = nombre_documento.replaceAll(' ', '_');
          nombre_documento = nombre_documento.replaceAll('  ', '_');
          nombre_documento = nombre_documento.replaceAll('.', '_');
          
          if(extension!=''){
            if( !acepted_files.includes(extension) ){
              modal_error('Solo puede adjutar archivos PDF','modalAdministracion');
              $(input).val('');
              return false;
            }else{
              if (input.files && input.files[0]) {
                let reader = new FileReader();
                reader.onload = e=> {
                  newDAC = {
                    'b64' : e.target.result.split('base64,')[1],
                    'nombre' : nombre_documento,
                    'tamanio': input.files[0].size / 1048576,
                    'extension' : extension,
                  };

                  $("#previewDocumentoCancelacionAudiencia").attr("data",e.target.result); 
                  $("#previewDocumentoCancelacionAudiencia").parent().removeClass('d-none'); 
                }
                reader.readAsDataURL(input.files[0]);
              }
              
              setTimeout(function(){
                $(input).val(""); // limpiamos input
                input.files = null; // limpiando files
                console.log( $("#"+input.id).val(), input.files )
                return false;
              }, 500);
            }
          }
        }else{
          return false;
        }
      }
    @endif

    /*
    @if($request->session()->get('id_tipo_usuario') == 1 || $request->session()->get('id_tipo_usuario') == 2 || $request->session()->get('id_tipo_usuario') == 3 || $request->session()->get('id_tipo_usuario') == 18 || $request->session()->get('id_tipo_usuario') == 20 || $request->session()->get('id_tipo_usuario') == 26 || $request->session()->get('id_tipo_usuario') == 31 || $request->session()->get('id_tipo_usuario') == 32 || $request->session()->get('id_tipo_usuario') == 6 )
      @if( isset($permisos[82]) and $permisos[82] == 1 )
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
    @endif
    */

    function limpiarEspacioA( tag ){
      $( tag ).empty();

      if( tag == '#espacioEditarAudiencia' ){
        $("#accordionAudienciasCrear").show();
        $("#accordionAudienciasEditar").hide();
      }
      if( tag == '#espacioCrearAudiencia' ){
        $("#collapseOneAudienciasCrear").collapse('hide');
      }
    }

    /*************
    *
    * VALIDADORES
    * 
    * ***********/ 
    
    function validar_datos_evento( tipo_evento, evento_id ){
      console.log( "Entra a validacion ", tipo_evento, evento_id );
      if( tipo_evento=='audiencia' ){

        if( !$("#sala-A").val() || $("#sala-A").val()=="null" )
        return { status:0 , message:`Debe seleccionar una sala.` }

        let horario_inicial = get_date( $("#fecha-A").val(), 'YYYY-MM-DD' ) +' '+ $("#horaInicio-A").val() + ":00" ;
        let horario_final = get_date( $("#fecha-A").val(), 'YYYY-MM-DD' ) +' '+ $("#horaTermino-A").val() + ":00" ;

        new_time_inicial = new Date( horario_inicial ).getTime();
        new_time_final = new Date( horario_final ).getTime();

        //otros_eventos = scheduler_audiencia.getEvents().filter( x=>x.id != evento_id );

        if( new_time_inicial >= new_time_final )
          return {status:0 , message:'La hora de inicio debe ser menor a la hora de termino'};
         
        otras_audiencias = scheduler_audiencia.getEvents().filter( x=>x.id != evento_id );
        console.log(otras_audiencias)
        for( var i in otras_audiencias ){
          otra_audiencia = otras_audiencias[i];

          // time_inicial_ocupado = new Date( otra_audiencia.start_date ).getTime();
          // time_final_ocupado = new Date( otra_audiencia.end_date ).getTime();

          time_inicial_ocupado = new Date( otra_audiencia.start_date ).getTime()+59000;
          time_final_ocupado = new Date( otra_audiencia.end_date ).getTime()-59000;
          console.log('vuelta :' , i);

          // if ( ( time_inicial_ocupado < new_time_inicial && time_final_ocupado > new_time_inicial ) || (time_inicial_ocupado < time_final_ocupado && time_final_ocupado > time_final_ocupado) || ( time_inicial_ocupado > new_time_inicial && inicio_t < time_final_ocupado ) || ( time_inicial_ocupado == new_time_inicial ) || ( time_final_ocupado == time_final_ocupado ) ) 
          //   return { "status":0 , "message": 'El horario seleccionado ya no está disponible <br>El horario incial se empalma con otra audiencia<br>Debe dejar al menos un minuto de espacio entre audiencias' } ;
          if( time_inicial_ocupado <= new_time_inicial && new_time_inicial <=  time_final_ocupado ){
            console.log(  time_inicial_ocupado , new_time_inicial ,  time_final_ocupado );
            return { "status":0 , "message": 'El horario seleccionado ya no está disponible <br>El horario incial se empalma con otra audiencia' } ;
          }else if( time_inicial_ocupado <= new_time_final && new_time_final <=time_final_ocupado ){
            console.log(  time_inicial_ocupado , new_time_final ,  time_final_ocupado );
            return { "status":0 , "message": 'El horario seleccionado ya no está disponible <br>El horario final se empalma con otra audiencia' } ;
          }else if( new_time_inicial <= time_inicial_ocupado && new_time_final >= time_final_ocupado ){
            console.log(  new_time_inicial, time_inicial_ocupado , time_final_ocupado ,  new_time_final );
            return { "status":0 , "message": 'El horario seleccionado ya no está disponible <br>El horario seleccionado se empalma con otra audiencia' } ;
          }  
        }

        if( arrRAA.length > 0 ){
          
          for (var i in arrRAA){
            r = arrRAA[i];
            if( r.estatus == 0 ) continue;

            let r_time_inicial = new Date( get_date(r.fecha_requerido_inicio) +' '+r.horario_requerido_inicio ).getTime();
            let r_time_final = new Date( get_date(r.fecha_requerido_fin) +' '+r.horario_requerido_fin ).getTime();

            if( new_time_inicial > r_time_inicial || new_time_final < r_time_final)
            return { status:0 , message:`El recurso ${r.nombre_recurso} está fuera del horario de la audiencia. <br>Corrígalo para continuar.`   }
          }

        }

        return {status:100};
      }

      else if( tipo_evento =='recurso' ){
        
        let horario_inicial = get_date( $("#fechaInicioRecurso-A").val(), 'YYYY-MM-DD' ) +' '+ $("#horaInicioRecurso-A").val() + ":00" ;
        let horario_final = get_date( $("#fechaFinRecurso-A").val(), 'YYYY-MM-DD' ) +' '+ $("#horaTerminoRecurso-A").val() + ":00" ;

        let new_time_inicial = new Date( horario_inicial ).getTime();
        let new_time_final = new Date( horario_final ).getTime();

        if( new_time_inicial >= new_time_final )
        return {status:0 , message:'La hora de inicio debe ser menor a la hora de termino'};


        let horario_inicial_aud = get_date( $("#fecha-A").val(), 'YYYY-MM-DD' ) +' '+ $("#horaInicio-A").val() + ":00" ;
        let horario_final_aud = get_date( $("#fecha-A").val(), 'YYYY-MM-DD' ) +' '+ $("#horaTermino-A").val() + ":00" ;

        new_time_inicial_aud = new Date( horario_inicial_aud ).getTime();
        new_time_final_aud = new Date( horario_final_aud ).getTime();

        if( ! $("#id_tipo_recurso-A").val() )
        return { status:0 , message:`Debe seleccionar un tipo de recurso<br>Corrígalo para continuar.` };
        
        if( ! $("#id_nombre_recurso-A").val() || $("#id_nombre_recurso-A").val() == null || $("#id_nombre_recurso-A").val()=='null' )
        return { status:0 , message:`Debe seleccionar un recurso<br>Corrígalo para continuar.` };
        
        if( ! $("#fechaInicioRecurso-A").val() || $("#fechaInicioRecurso-A").val() == null || $("#fechaInicioRecurso-A").val()=='null' )
        return { status:0 , message:`Debe ingresar la fecha en que comenzará a usar el recurso <br>Corrígalo para continuar.` };
        
        if( ! $("#fechaFinRecurso-A").val() || $("#fechaFinRecurso-A").val() == null || $("#fechaFinRecurso-A").val()=='null' )
        return { status:0 , message:`Debe ingresar la fecha en que terminará de usar el recurso <br>Corrígalo para continuar.` };
        
        if( ! $("#horaInicioRecurso-A").val() || $("#horaInicioRecurso-A").val() == null || $("#horaInicioRecurso-A").val()=='null' || ($("#horaInicioRecurso-A").val()).length != 5 )
        return { status:0 , message:`Debe ingresar la hora en que comenzará a usar el recurso <br>Asegurese de ingresar la hora en fomato de 24 horas<br> Corrígalo para continuar.` };
        
        if( ! $("#horaTerminoRecurso-A").val() || $("#horaTerminoRecurso-A").val() == null || $("#horaTerminoRecurso-A").val()=='null' || ($("#horaTerminoRecurso-A").val()).length != 5 )
        return { status:0 , message:`Debe ingresar la hora en que terminará de usar el recurso <br>Asegurese de ingresar la hora en fomato de 24 horas<br> Corrígalo para continuar.` };

        if( new_time_inicial < new_time_inicial_aud || new_time_final > new_time_final_aud)
        return { status:0 , message:`El recurso ${r.nombre_recurso} está fuera del horario de la audiencia. <br>Corrígalo para continuar.` };


        otros_recursos = scheduler_recursos.getEvents().filter( x=>x.id != evento_id );
        console.log('Otros Recursos',evento_id,otros_recursos)
        for( var i in otros_recursos ){
          otro_recurso = otros_recursos[i];

          time_inicial_ocupado = new Date( otro_recurso.start_date ).getTime();
          time_final_ocupado = new Date( otro_recurso.end_date ).getTime();
          
          // console.log('vuelta :' , i);
          // console.log(  time_inicial_ocupado , new_time_inicial ,  time_final_ocupado );
          // console.log(  time_inicial_ocupado , time_final_ocupado ,  time_final_ocupado );

          // if ( ( time_inicial_ocupado < new_time_inicial && time_final_ocupado > new_time_inicial ) || (time_inicial_ocupado < time_final_ocupado && time_final_ocupado > time_final_ocupado) || ( time_inicial_ocupado > new_time_inicial && inicio_t < time_final_ocupado ) || ( time_inicial_ocupado == new_time_inicial ) || ( time_final_ocupado == time_final_ocupado ) ) 
          //   return { "status":0 , "message": 'El horario seleccionado ya no está disponible <br>El horario seleccionado se empalma con otro recurso<br>Debe dejar al menos un minuto de espacio entre recursos' } ;
          if( time_inicial_ocupado < new_time_inicial && new_time_inicial <  time_final_ocupado ){
            console.log(  time_inicial_ocupado , new_time_inicial ,  time_final_ocupado );
            return { "status":0 , "message": 'El horario seleccionado ya no está disponible <br>El horario incial se empalma con otro recurso<br>Debe dejar al menos un minuto de espacio entre recursos' } ;
          }else if( time_inicial_ocupado < new_time_final && new_time_final < time_final_ocupado ){
            console.log(  time_inicial_ocupado , new_time_final ,  time_final_ocupado );
            return { "status":0 , "message": 'El horario seleccionado ya no está disponible <br>El horario final se empalma con otro recurso<br>Debe dejar al menos un minuto de espacio entre recursos' } ;
          }else if( new_time_inicial < time_inicial_ocupado && new_time_final > time_final_ocupado ){
            console.log(  new_time_inicial, time_inicial_ocupado , time_final_ocupado ,  new_time_final );
            return { "status":0 , "message": 'El horario seleccionado ya no está disponible <br>El horario seleccionado se empalma con otro recurso<br>Debe dejar al menos un minuto de espacio entre recursos' } ;
          }  
        }

        return {status:100};
        
      }

    }

    function valida_horarios( arr_eventos , new_time_inical, new_time_final ){
      if( new_time_inicial >= new_time_final )
      return {status:0 , message:'La hora de inicio debe ser menor a la hora de termino'};

      // revisa si no se emplaman horarios
      
      console.log(arr_eventos)
      for( var i in arr_eventos ){
        otro_evento = arr_eventos[i];


        // time_inicial_ocupado = new Date( otro_evento.start_date ).getTime();
        // time_final_ocupado = new Date( otro_evento.end_date ).getTime();

        time_inicial_ocupado = new Date( otro_evento.start_date ).getTime()-59000;
        time_final_ocupado = new Date( otro_evento.end_date ).getTime()+59000;
        
        console.log('vuelta :' , i);

        // if ( ( time_inicial_ocupado < new_time_inicial && time_final_ocupado > new_time_inicial ) || (time_inicial_ocupado < time_final_ocupado && time_final_ocupado > time_final_ocupado) || ( time_inicial_ocupado > new_time_inicial && inicio_t < time_final_ocupado ) || ( time_inicial_ocupado == new_time_inicial ) || ( time_final_ocupado == time_final_ocupado ) ) 
        //   return { status:0 , message: `El horario seleccionado ya no está disponible <br>El horario seleccionado se empalma con ${ tipo_evento == 'audiencia' ? 'otra' : 'otro'} ${tipo_evento}<br>Debe dejar al menos un minuto de espacio entre ${tipo_evento}s` } ;

        if( time_inicial_ocupado <= new_time_inicial && new_time_inicial <=  time_final_ocupado ){
          console.log(  time_inicial_ocupado , new_time_inicial ,  time_final_ocupado );
          return { status:0 , message: `El horario seleccionado ya no está disponible <br>El horario incial se empalma con ${ tipo_evento == 'audiencia' ? 'otra' : 'otro'} ${tipo_evento}<br>Debe dejar al menos un minuto de espacio entre ${tipo_evento}s` } ;
        }else if( time_inicial_ocupado <= new_time_final && new_time_final <=time_final_ocupado ){
          console.log(  time_inicial_ocupado , new_time_final ,  time_final_ocupado );
          return { status:0 , message: `El horario seleccionado ya no está disponible <br>El horario final se empalma con ${ tipo_evento == 'audiencia' ? 'otra' : 'otro'} ${tipo_evento}<br>Debe dejar al menos un minuto de espacio entre ${tipo_evento}s` } ;
        }else if( new_time_inicial <= time_inicial_ocupado && new_time_final >= time_final_ocupado ){
          console.log(  new_time_inicial, time_inicial_ocupado , time_final_ocupado ,  new_time_final );
          return { status:0 , message: `El horario seleccionado ya no está disponible <br>El horario seleccionado se empalma con ${ tipo_evento == 'audiencia' ? 'otra' : 'otro'} ${tipo_evento}<br>Debe dejar al menos un minuto de espacio entre ${tipo_evento}s` } ;
        }  
      }
      return {status:100};
    }
    

    /*********+
     *
     *  FUNCIONES DE CONFIGURACION y REFRESCADORES
     *
     * *******/

    function loadConfigComponentA(){
      $('.select-edit').select2({minimumResultsForSearch: ''});
      
      let fecha_actual = new Date();
      $('.datepicker-edit').datepicker({
        showOtherMonths: true,
        selectOtherMonths: true,
        format: 'dd/mm/yyyy',
        changeYear: true,
        yearRange: "c-100:" +( fecha_actual.getFullYear() +3)
      });
      
      $('.clockpicker-A').clockpicker();
      
      //$('.time-edit-A').timepicker({show2400:true,timeFormat:'G:i'});

      scheduler_audiencia  = Scheduler.getSchedulerInstance();// Scheduler.getSchedulerInstance();
      scheduler_recursos  = Scheduler.getSchedulerInstance();// Scheduler.getSchedulerInstance();

      scheduler_audiencia.config.header = [ "date",];
      scheduler_recursos.config.header = [ "date",];

      scheduler_audiencia.attachEvent("onDblClick", function(){ return false; });
      scheduler_recursos.attachEvent("onDblClick", function(){ return false; });

			scheduler_audiencia.attachEvent("onClick",function(id, e){ return false; });
			scheduler_recursos.attachEvent("onClick",function(id, e){ return false; });

      scheduler_audiencia.config.dblclick_create = false;
      scheduler_audiencia.config.details_on_dblclick = true;

      scheduler_recursos.config.dblclick_create = false;
      scheduler_recursos.config.details_on_dblclick = true;

      scheduler_recursos.config.drag_resize = false;
      scheduler_recursos.config.drag_move = false;
      scheduler_recursos.config.drag_create = false;
      
      scheduler_audiencia.config.drag_resize = false;
      scheduler_audiencia.config.drag_move = false;
      scheduler_audiencia.config.drag_create = false;

      scheduler_audiencia.config.first_hour = 0;
      scheduler_audiencia.config.last_hour = 24;
      scheduler_audiencia.config.hour_size_px = 176;

      scheduler_recursos.config.first_hour = 0;
      scheduler_recursos.config.last_hour = 24;
      scheduler_recursos.config.hour_size_px = 176;

      var format_audiencia = scheduler_audiencia.date.date_to_str("%H:%i");
      scheduler_audiencia.templates.hour_scale = function(date){
        var step = 15;
        var html = "";
        for (var i=0; i<60/step; i++){
          html += "<div style='height:44px;line-height:44px;'>"+format_audiencia(date)+"</div>";
          date = scheduler_audiencia.date.add(date, step, "minute");
        }
        return html;
      }
     
      var format_recurso = scheduler_recursos.date.date_to_str("%H:%i");
      scheduler_recursos.templates.hour_scale = function(date){
        var step = 15;
        var html = "";
        for (var i=0; i<60/step; i++){
          html += "<div style='height:44px;line-height:44px;'>"+format_recurso(date)+"</div>";
          date = scheduler_recursos.date.add(date, step, "minute");
        }
        return html;
      }
      
      scheduler_audiencia.config.separate_short_events = true;
      scheduler_recursos.config.separate_short_events = true;

      scheduler_audiencia.templates.event_class = function(start,end,ev){
        return "event_bkg_"+ev.color;
      };

      scheduler_recursos.templates.event_class = function(start,end,ev){
        return "event_bkg_"+ev.color;
      };

      scheduler_audiencia.init('calendario_audiencias',new Date(),"day");
      scheduler_recursos.init('calendario_recursos',new Date(),"day");
    }

    async function refrescar_recursos( id_tipo_recurso, tag ){
      let recursos = await obtener_recursos_hijos(id_tipo_recurso);

      let str_optionNR = ``;

      if( recursos.status==100 ){
        if( typeof recursos.response === 'string' || (recursos.response).length == 0 || (recursos.response[0].recursos).length == 0 ) str_optionNR = str_optionNR + `<option value="null" disabeld selected > No hay recursos de este tipo </option>`;
        else{
          for ( var i in recursos.response[0].recursos ){
            r = recursos.response[0].recursos[i];
            str_optionNR = str_optionNR + `<option value="${r.id_recurso_audiencia}"> ${r.nombre_recurso} </option> `;
          }
        }
      }else{
        str_optionNR = str_optionNR + `<option value="null" disabeld selected > Error al obtener tipo de recursos </option>`;
      }

      $( tag ).empty();
      $( tag ).append( str_optionNR );

      pintar_eventos_recursos( '#id_tipo_recurso-A' , tag ,"#fechaInicioRecurso-A" );
      return true;
    }

    function pintar_eventos_recursos( tag_recurso, tag_nombre_recurso ,tag_fecha ){
      if( scheduler_recursos.getEvents().length > 0 ) scheduler_recursos.clearAll();
      if( $( tag_recurso ).val() != 'null' && $( tag_nombre_recurso ).val() != 'null' && $(tag_fecha).val() ){
        obtener_eventos_recursos( $(tag_recurso).val() , $(tag_nombre_recurso).val() , get_date( $(tag_fecha).val() ) );
        redimensiona_evento_recurso( "#idRecursoAdicional-A" );
      }
      else 
        return false;
    }
 
    function obtener_eventos_recursos( tipo_recurso, nombre_recurso , fecha ){
      $.ajax({
        method:'POST',
        url:'/public/obtener_horarios_recursos',
        data:{ fecha, tipo_recurso, nombre_recurso },
        success:function(response){
          console.log( "consulta recursos", response );
          if( response.status == 100 ){
            let eventos = [];
            for(var i in response.response){
              evento = response.response[i];
              eventos.push({
                id: evento.id_recurso,
                text: evento.tipo_recurso+': '+evento.nombre_recurso,
                start_date: new Date( evento.fecha_requerido_inicio+' '+evento.horario_requerido_inicio ),
                end_date: new Date( evento.fecha_requerido_fin+' '+evento.horario_requerido_fin ),
                color: evento.id_recurso == $("#idRecursoAdicional-A").val() ? 'rojo' : 'verde',
              });
            }
            scheduler_recursos.parse(eventos);

            if( (arrRAA).length > 0 ){
              let temp_arrRAA = arrRAA.filter( function( x ){ if (x.id_tipo_recurso == tipo_recurso && x.id_nombre_recurso == nombre_recurso ) return x; });
              if ( (temp_arrRAA).length > 0 ){
                for( var i in temp_arrRAA ){
                  let evento = temp_arrRAA[i];
                  
                  if( scheduler_recursos.getEvent(evento.id_recurso) != undefined ){
                  
                    scheduler_recursos.getEvent(evento.id_recurso).color = evento.id_recurso == $("#idRecursoAdicional-A").val() ? 'rojo' : 'verde';
                    scheduler_recursos.getEvent(evento.id_recurso).start_date = new Date(  evento.fecha_requerido_inicio + " " + evento.horario_requerido_inicio );
                    scheduler_recursos.getEvent(evento.id_recurso).end_date =   new Date( evento.fecha_requerido_fin + " " + evento.horario_requerido_fin );
                    scheduler_recursos.getEvent(evento.id_recurso).text = evento.descripcion + ": " + evento.nombre_recurso;
                    scheduler_recursos.getEvent(evento.id_recurso).id =  evento.id_recurso;
                    scheduler_recursos.updateEvent( evento.id_recurso );

                  }else{
                    
                    scheduler_recursos.addEvent({
                      color: evento.id_recurso == $("#idRecursoAdicional-A").val() ? 'rojo' : 'verde',
                      start_date: new Date(  evento.fecha_requerido_inicio + " " + evento.horario_requerido_inicio ),
                      end_date:   new Date( evento.fecha_requerido_fin + " " + evento.horario_requerido_fin ),
                      text: evento.descripcion + ": " + evento.nombre_recurso,
                      id : evento.id_recurso
                    });

                  }
                  
                }
              }
            }
          }
          //revolse( response );
        },
        error : function( errors ){
          modal_error('Error :'+errors,'modalAdministracion');
          //revolse( {status:0, message:'Error al consumir servicio consulta audiencias'} );
        }
      });
      scheduler_recursos.setCurrentView(new Date( fecha+" 08:00:00" ));
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
      console.log( "pintar_eventos , tag sala, tag_fecha", tag_sala , tag_fecha );
      if( scheduler_audiencia.getEvents().length > 0) scheduler_audiencia.clearAll();
      if( $(tag_sala).val() != 'null' && $(tag_fecha).val() ){
        obtener_eventos( $(tag_sala).val() , get_date( $(tag_fecha).val() ) );
        redimensiona_evento_audiencia( $( "#id_audiencia" ).val() );
      }
      else
        return false;
    }

    function obtener_eventos( id_sala, fecha ){
      //return new Promise(resolve => {
        $.ajax({
          method:'GET',
          url:'/public/consultar_audiencias',
          data:{
            id_sala:id_sala,
            fecha_ini : fecha,
            fecha_fin : fecha,
          },
          success:function(response){
            console.log( "consulta eventos audiencia", response );
            if( response.status == 100 ){
              let eventos = [];
              for(var i in response.response){
                evento = response.response[i];
                if( evento.estatus_semaforo == 'Cancelado' || evento.estatus_audiencia == 'Cancelado' ) continue;
                eventos.push({
                  id: evento.id_audiencia,
                  text: evento.id_unidad == carpetaActiva.id_unidad ? evento.tipo_audiencia : 'Ocupado por la audiencia: '+evento.id_audiencia,
                  start_date: new Date( evento.fecha_audiencia+' '+evento.hora_inicio_audiencia ),
                  end_date: new Date( evento.fecha_audiencia+' '+evento.hora_fin_audiencia ),
                  color: (evento.id_audiencia == $("#id_audiencia").val() ? 'rojo' : 'verde')
                });
              }
              scheduler_audiencia.parse(eventos);
            }
            //revolse( response );
          },
          error : function( errors ){
            modal_error('Error :'+errors,'modalAdministracion');
            //revolse( {status:0, message:'Error al consumir servicio consulta audiencias'} );
          }
        });
        scheduler_audiencia.setCurrentView(new Date( fecha+" 08:00:00" ));
        
        obtener_incidencias( id_sala, fecha, fecha );

        //var incidencias1 = obtener_incidencias( id_sala, fecha, null );
        //var incidencias1 = obtener_incidencias( id_sala, fecha, fecha );
        //var incidencias1 = obtener_incidencias( id_sala, null , fecha );

      //});
    }


    function obtener_incidencias( id_sala , fecha_desde, fecha_hasta ){
      $.ajax({
        method:'POST',
        url:'/public/obtener_incidencias_cj',
        data:{
          id_sala,
          id_unidad: carpetaActiva.id_unidad,
          fecha_desde : fecha_desde,
          fecha_hasta : fecha_hasta,
        },
        success:function(response){
          console.log( "consulta incidencias", response );
          if( response.status == 100 && response.response_pag.registros_totales > 0 ){
            let eventos = [];
            for(var i in response.response){
              evento = response.response[i];

              scheduler_audiencia.addEvent({
                id: evento.id_incidencia_sala,
                text: 'Ocupado (Incidencia)',
                start_date: new Date( evento.fecha_desde ),
                end_date: new Date( evento.fecha_hasta ),
                color: 'verde'
              }); 
              eventos.push();
                            
            }
          }
        },
        error : function( errors ){
          modal_error('Error :'+errors,'modalAdministracion');
        }
      });
    }

    /***************************
    *
    *  Promesas
    *
    * *************************/

    function obtener_recursos_hijos( id_tipo_recurso ){
      return new Promise(resolve => {
        $.ajax({
          method:'POST',
          url:'/public/obtener_nombre_tipos_recursos',
          data:{ id_tipo_recurso },
          success:function(response){
            console.log('nombre recursos' ,response);
            resolve(response);
          },
          error : function( errors ){
            modal_error('Error :'+errors,'modalAdministracion');
            resolve( {status:0, message:'Error al consumir servicio nombre recursos'} ) ;
          }
        });

      });
    }

    function obtener_salas(id_inmueble=null){
      return new Promise(resolve => {
        $.ajax({
          method:'POST',
          url:'/public/obtener_inmueble_salas',
          //  async: false,
          data:{ id_unidad:carpetaActiva.id_unidad, id_inmueble : id_inmueble  },
          success:function(response){
            console.log('salas',response);
            resolve(response);
          },
          error : function( errors ){
            modal_error('Error :'+errors,'modalAdministracion');
            resolve( {status:0, message:'Error al consumir servicio inmueble salas'} ) ;
          }
        });

      });
    }

    function obtener_jueces( tipo = 'sig_control' ){
      return new Promise(resolve => {

        let ruta = '';
        if(tipo=='ejecucion') ruta = 'obtener_jueces_ejecucion';
        if(tipo=='tramite') ruta = 'obtener_juez_tramite';
        if(tipo=='control_ejecucion') ruta = 'obtener_jueces_unidad';
        if(tipo=='sig_control'){
          ruta = 'obtener_siguiente_juez_control';

          if( carpetaActiva.tipo_solicitud_ == 'PRO-MUJER'){
            resolve({
              status:100,
              response:{
                cv_juez: carpetaActiva.cve_juez_promujer,
                id_usuario: carpetaActiva.id_juez_promujer,
                nombre: carpetaActiva.nombre_juez_promujer
              }
            });
            return false;
          }
          else if( carpetaActiva.id_juez_ejecucion != null ){
            resolve({
              status:100,
              response:{
                cv_juez: carpetaActiva.cve_juez_ejecucion,
                id_usuario: carpetaActiva.id_juez_ejecucion,
                nombre: carpetaActiva.nombre_juez_ejecucion
              }
            });
            return false;
          }
         
        }

        $.ajax({
          method:'POST',
          url:'/public/'+ruta,
          async: false,
          data:{ id_unidad:carpetaActiva.id_unidad, uga:carpetaActiva.id_unidad },
          success:function(response){
            console.log(response);
            resolve(response);
          },
          error : function( errors ){
            modal_error('Error :'+errors,'modalAdministracion');
            resolve( {status:0, message:'Error al consumir servicio jueces '+tipo} );
          }
        });
      });
    }

    function delay( miliseconds ){
      return new Promise(resolve => {
        setTimeout( function(){ resolve("espera terminada") }, miliseconds );
      });
    }


    /***************
    *
    * Fechas
    * 
    * **************/ 

    function get_date( date , format = 'YYYY-MM-DD' ){
      console.log( "Parseo fecha, fecha recibida :", date );
      if( format == 'YYYY-MM-DD' && date.substring(0,4).includes('-') ) 
        return date.split('-').reverse().join('-');
      if( format == 'DD-MM-YYYY' && !date.substring(0,4).includes('-') )
        return date.split('-').reverse().join('-');
      if( format == 'YYYY-MM-DD' && date.substring(0,4).includes('/') ) 
        return date.split('-').reverse().join('-');
      if( format == 'DD-MM-YYYY' && !date.substring(0,4).includes('/') )
        return date.split('-').reverse().join('-');
      else
        return date;
    }

    function get_time( time , format = 'HH:mm' ){
      let time_return = '';
      if( time.length > 8 ) time_return = time.split(' ')[1].substring(0,5); 
      else time_return = time.substring(0,5);

      time_return = time_return.split(':')[0].padStart(2,'0')+':'+time_return.split(':')[1].padStart(2,'0');

      return time_return;
    }

    function alter_time( date = new Date() , action = '+' , time = '1' , type_time = 's' ){
      //console.log( date );
      date = new Date( date ); 
      switch( type_time ){
        case 's' : time = time * 1000 ; break;
        case 'm' : time = time * 60 * 1000 ; break;
        case 'h' : time = time * 60 * 60 * 1000 ; break;
        case 'd' : time = time * 24 * 60 * 60 * 1000 ; break;
        default : time = time; break ;
      }
      //console.log(time);
      //console.log( date.getTime() );

      if( action == '+' || action == 'add' || action == true )  date = new Date( date.getTime() + time );
      else if( action == '-' || action == 'sub' || action == false ) date = new Date( date.getTime() - time );
      //console.log(date);
      return date.toLocaleDateString()+' '+date.toLocaleTimeString();
    }


    /**************
     *
     * FUNCIONES PARA MODAL DE AUDIENCIAS INFO
     *
     * ***********/
    
    //Elegir menu del tab
    function elegirTab(opcion,id_tipo_audiencia_F,carpeta_judicial_F, id_solicitud_F, id_audiencia_F, indice){
      switch (opcion){
        case 'mandamientos': 
          obtener_mandamientos(carpeta_judicial_F,id_audiencia_F,'primera');
        break;

        case 'resolutivos':  
          obtener_audiencias_resolutivos(carpeta_judicial_F, id_audiencia_F,'primera');
        break;

        case 'acuerdos_reparatorios':  
          obtener_AcuerdosR(carpeta_judicial_F,id_audiencia_F,'primera');
        break;

        case 'medidas_cautelares': 
          obtener_MedidaC(carpeta_judicial_F,id_audiencia_F,'primera');
        break;

        case 'medidas_proteccion':  
          victimas_F = carpetaActiva.victimas;
          menu_promujer_rat(id_tipo_audiencia_F,carpeta_judicial_F,victimas_F, id_solicitud_F, id_audiencia_F);
        break;

        case 'condicion_suspencion':  
          obtener_CondicionS(carpeta_judicial_F,id_audiencia_F,'primera');
        break;
      }
    }

    function alertaFinalizarCaptura(){
      let title = '¿Desea Finalizar la Captura de Resolutivos?';

      let body = `<h5>${title}</h5>`;
      
      $('#modalHistory').modal('hide');
      $('#tituloModalConfirmResolutivos').html('Finalizar Captura de Resolutivos');
      $('#bodyModalConfirmResolutivos').html(body);
      $('#btnAceptarModalConfirmResolutivos').attr('onclick', `finalizarCaptura(${audiencia_activa.id_audiencia})`)
      $('#modalConfirmResolutivos').modal('show');
    }

    function finalizarCaptura(id_audiencia){
      let ids_acuerdos_rep = audiencia_activa.ids_acuerdos_rep;
      let ids_cond_sus_pro = audiencia_activa.ids_cond_sus_pro;
      let ids_mandamientos_jud = audiencia_activa.ids_mandamientos_jud;
      let ids_medidas_cau = audiencia_activa.ids_medidas_cau;
      let ids_medidas_pro = audiencia_activa.ids_medidas_pro;
      let ids_resolutivos = audiencia_activa.ids_resolutivos;

      console.log('ids_resolutivos',ids_resolutivos)

      //if(ids_acuerdos_rep == null && ids_cond_sus_pro == null && ids_mandamientos_jud == null && ids_medidas_cau == null && ids_medidas_pro==null && ids_resolutivos == null){
      if(ids_resolutivos == null){
        let error = 'Lo sentimos, no puede finalizar la captura sin resolutivos registrados';
        $('#titleError').html('Error');
        $('#modalConfirmResolutivos').modal('hide');
        modal_error(error,'modalHistory');
      }else{
        $.ajax({
          type:'post',
          url:'/public/finalizarAbrirCaptura',
          data:{
              id_audiencia: id_audiencia,
              tipo: 'finalizar',
              bandera: 0
          },
          success:function(response) {
            if(response.status==100){
              $('#modalConfirmResolutivos').modal('hide')

              $('.item_barra').each(function(){
                if($(this).hasClass('active')){
                    $(this).trigger('click');
                }
              });
            
              let exito = 'Se ha finalizado la captura de resolutivos correctamente';
              modal_success(exito,'modalHistory');

            }else{
              $('#titleError').html('Error');
              $('#modalConfirmResolutivos').modal('hide');
              modal_error(response.response,'modalHistory');
            } 
          }
        });
      
      }
    }

    function aperturarCaptura(){
      $.ajax({
        type:'post',
        url:'/public/finalizarAbrirCaptura',
        data:{
            id_audiencia: audiencia_activa.id_audiencia,
            tipo: 'aperturar',
            bandera: 1
        },
        success:function(response) {
          if(response.status==100){
            $('#modalHistory').modal('hide')

            $('.item_barra').each(function(){
              if($(this).hasClass('active')){
                  $(this).trigger('click');
              }
            });

            let exito = 'Se ha abierto la captura de resolutivos nuevamente';
            modal_success(exito,'modalHistory');
          }else{
            $('#modalHistory').modal('hide')
            $('#titleError').html('Error');
            modal_error(response.response,'modalHistory');
          } 
        }
      });


    }

    //{{--  Resolutivos  --}}
    function obtener_audiencias_resolutivos(folio,id_audiencia,pagina_accion){
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
              id_carpeta: carpetaActiva.id_carpeta_judicial,
              id_audiencia: id_audiencia,
              registros_por_pagina:registros_por_pagina,
              pagina:$("#pagina_actual_resolutivos").val(),
          },
          
          success:function(response) {
            
            body = '';
            if(response.status==100){
  
                $('.pagina_total_texto_resolutivos').html(response.response_pag['paginas_totales']);
                $('#paginas_totales_resolutivos').val(response.response_pag['paginas_totales']);
  
                var datas = response.response;
                var ids_resol = [];

                console.log('resolutivos',datas);
                
                for (var j = 0; j < datas.length; j++) {
                  var valor='';
                  var comentarios = '';
                  var color='';
                  var estado='';
                  var ids_imputados_selected = null;
                  var ids_imputados = datas[j]['id_imputado'] == '' ? null : datas[j]['id_imputado'];
                  var id_causa_ilegal_detencion = '';
                  ids_resol.push(datas[j].id_audiencia_resolutivo);

                  if(datas[j]['tipo_resultado'] == 1){
                    valor = datas[j]['tipo_valor'];
                  }else if(datas[j]['tipo_resultado'] == 2){
                    valor = '<ul style="text-align:left;  margin-left: 8%;"><li>Base: '+datas[j]['fecha_base']+'</li> <li>Resultado: '+datas[j]['fecha_resultado']+'</li> <li>Presentacion: '+datas[j]['fecha_presentacion']+'</li></ul>';
                  }else if(datas[j]['tipo_resultado'] == 3){
                    valor = datas[j]['fecha_compurga'];
                  }else if(datas[j]['tipo_resultado'] == 4){
                    valor = datas[j]['fecha'];
                  }else if(datas[j]['tipo_resultado'] == 5){
                    valor = datas[j]['numero'];
                  }else if(datas[j]['tipo_resultado'] == 8){
                    ids_imputados_selected1 = [];

                    ul = '<ul>';
                    for(i in datas[j]['nombre_imputados']){
                      ul +=`<li>${datas[j]['nombre_imputados'][i].imputado}</li>`;
                      ids_imputados_selected1.push(datas[j]['nombre_imputados'][i].id_persona);
                    }
                    ul += '</ul>';

                    valor = ul;
                    ids_imputados_selected = ids_imputados_selected1;
                    id_causa_ilegal_detencion = datas[j]['id_causa_ilegal_detencion'];
                  }else{
                    valor = '-';
                    id_causa_ilegal_detencion = '';
                  }
                  
  
                  if(datas[j]['comentarios_adicionales'] == null){
                    comentarios = 'Sin comentarios';
                  }else{
                    comentarios = datas[j]['comentarios_adicionales'];
                  }
  
                  if(datas[j]['inactividad'] == 1){
                    color = 'green';
                    estado = 'Activo';
                  }else{
                    color= 'red';
                    estado = 'Inactivo';
                  }
                  
                  let permiso = '';
                  if(datas[j]['apertura_resolutivos'] == 1){
                    permiso = `
                      <i class="fas fa-trash-alt acciones2" data-toggle="tooltip-primary" data-placement="top" title="Eliminar resolutivo" style="cursor:pointer; background: #A72424;" onclick="modalEliminar(${datas[j]['id_audiencia_resolutivo']},${datas[j]['id_audiencia']}, 1)"></i>
                      <i class="fas fa-edit acciones2" data-toggle="tooltip-primary" data-placement="top" title="Editar resolutivo" style="cursor:pointer;" onclick="cargarCamposEditarResolutivo(${datas[j]['id_audiencia_resolutivo']},${datas[j]['id_audiencia']},'${datas[j]['folio_carpeta']}', ${datas[j]['id_resolutivo']},${ids_imputados} , ${ids_imputados_selected},'${datas[j]['tipo_valor']}',${datas[j]['numero']}, '${datas[j]['fecha']}', '${datas[j]['fecha_base']}',${datas[j]['anios']},${datas[j]['meses']},${datas[j]['dias']},'${datas[j]['fecha_compurga']}','${datas[j]['fecha_resultado']}','${datas[j]['fecha_presentacion']}','${id_causa_ilegal_detencion}','${datas[j]['comentarios_imputado']}', '${datas[j]['comentarios_adicionales']}', ${datas[j]['tipo_resultado']},${datas[j]['estatus']}, ${datas[j]['acto_investigacion']},${datas[j]['autoriza_acto_investigacion']},${datas[j]['determinacion_fiscalia']},${datas[j]['procede_recurso']}, ${datas[j]['tipo_solucion_alterna']}, ${datas[j]['tipo_sobreseimiento']}, '${datas[j]['fecha_dicta_sobreseimiento']}', ${datas[j]['reparacion_danio']},${datas[j]['tipo_reparacion_danio']}, ${datas[j]['modalidad_reparacion_danio']},${datas[j]['monto_reparacion_danio']} )"></i> 
                    `;
                  }else{
                    permiso = '<span style="color: #CB4335; margin-right:2%">Se ha finalizado la captura</span>';
                  }

                  body += `<tr>
                              <td>${permiso}</td> 
                              <td>${datas[j]['folio_carpeta']}</td>
                              <td>${datas[j]['descripcion']}</td>
                              <td>${comentarios}</td>
                              <td>${valor}</td>
                              <td style="color:${color};">${estado}</td>
                          </tr>`;
                }

                audiencia_activa.ids_resolutivos = ids_resol.join();

              $("#body-table1").html(body);
              
            }else{
              body = body.concat('<tr><td colspan="5">No existen registros</td></tr>');
              $("#body-table1").html(body);
            }
          }
        });
      }
    }

    function agregarAccionesResolutivo(folio, id_audiencia){

      let datosCarpeta = carpetaActiva;


      let imputados = '';
      for(i in datosCarpeta.imputados){
        imputados += `<div class="form-check my-2">
          <label class="form-check-label" for="cmp_imputado_${datosCarpeta.imputados[i].id_persona}" >
            <input class="form-check-input imputado_menu8" type="checkbox" value="${datosCarpeta.imputados[i].id_persona}" id="cmp_imputado_${datosCarpeta.imputados[i].id_persona}">
            ${ datosCarpeta.imputados[i].tipo == 'fisica' ? datosCarpeta.imputados[i].nombre : datosCarpeta.imputados[i].razon_social}
          </label>
        </div>`;
      }

      let date = new Date();
      let fecha_base = date.getFullYear()+'-'+(date.getMonth() + 1)+'-'+date.getDate();

      let actos_option = `<option selected value="">Seleccionar</option>`;
      let sub_actos_option_100 = `<option selected value="">Seleccionar</option>`;
      let sub_actos_option_300 = `<option selected value="">Seleccionar</option>`;
      for(i in catalogo_actos_investigacion){
        if(catalogo_actos_investigacion[i].clave < 100){
          actos_option += `<option value="${catalogo_actos_investigacion[i].id_acto_investigacion}" data-clave="${catalogo_actos_investigacion[i].clave}"> ${catalogo_actos_investigacion[i].acto_investigacion}</option>`;
        }else if(catalogo_actos_investigacion[i].clave > 100 && catalogo_actos_investigacion[i].clave < 300){
          sub_actos_option_100 += `<option value="${catalogo_actos_investigacion[i].id_acto_investigacion}" data-clave="${catalogo_actos_investigacion[i].clave}"> ${catalogo_actos_investigacion[i].acto_investigacion}</option>`;
        }else if(catalogo_actos_investigacion[i].clave > 300){
          sub_actos_option_300 += `<option value="${catalogo_actos_investigacion[i].id_acto_investigacion}" data-clave="${catalogo_actos_investigacion[i].clave}"> ${catalogo_actos_investigacion[i].acto_investigacion}</option>`;
        }
      }

      let tipos_solucion_alterna = '<option selected value="-">Seleccionar</option>';
      for(i in catalogo_tipo_solucion_alterna){
        tipos_solucion_alterna += `<option value="${catalogo_tipo_solucion_alterna[i].id_tipo_solucion_alterna}">${catalogo_tipo_solucion_alterna[i].tipo_solucion_alterna}</option>`;   
      }

      let tipo_sobreseimiento = '<option selected value="-">Seleccionar</option>';
      for(i in catalogo_tipo_sobreseimiento){
        tipo_sobreseimiento += `<option value="${catalogo_tipo_sobreseimiento[i].id_tipo_sobreseimiento}">${catalogo_tipo_sobreseimiento[i].tipo_sobreseimiento}</option>`;   
      }

      let tipo_reparacion_danio = '<option selected value="-">Seleccionar</option>';
      for(i in catalogo_tipo_reparacion_danio){
        tipo_reparacion_danio += `<option value="${catalogo_tipo_reparacion_danio[i].id_tipo_reparacion_danio}">${catalogo_tipo_reparacion_danio[i].tipo_reparacion_danio}</option>`;   
      }

      let reparacion_danio = '<option selected value="-">Seleccionar</option>';
      for(i in catalogo_reparacion_danio){
        reparacion_danio += `<option value="${catalogo_reparacion_danio[i].id_reparacion_danio}">${catalogo_reparacion_danio[i].reparacion_danio}</option>`;   
      }

      let modalidad_reparacion_danio = '<option selected value="-">Seleccionar</option>';
      for(i in catalogo_modalidad_reparacion_danio){
        modalidad_reparacion_danio += `<option value="${catalogo_modalidad_reparacion_danio[i].id_modalidad_reparacion_danio}">${catalogo_modalidad_reparacion_danio[i].modalidad_reparacion_danio}</option>`;   
      }

      let html = `
        <div class="row">
          <div class="col-lg-12">
          <form action="" id="frm_resolutivos">
            <input type="hidden" id="folioC" value="${folio}">
            <input type="hidden" id="folioC_id_audiencia" value="${id_audiencia}">

            <div class="form-group text-left">
              <label class="form-control-label">Resolutivo:</label>
              <select class="form-control select2" id="cmp_resolutivo" name ="cmp_resolutivo" autocomplete="off" onchange="elegir_menu(this)">
              </select>
            </div>

            <div>
              <div class="row justify-content-between">
                <div class="col-md-5">
                  <div class="form-group text-left">
                    <label class="form-control-label">Acto de investigación:</label>
                    <select class="form-control select2" id="cmp_autoriza_investigacion" name ="cmp_acto_investigacion" autocomplete="off" >
                      ${actos_option}
                    </select>
                  </div>
                </div>
                <div class="col-md-4 d-none" id="acto_investigacion_div">
                  <div class="form-group text-left">
                    <label class="form-control-label">Acto de investigación:</label>
                    <select class="form-control select2" id="cmp_autoriza_investigacion_sub" name ="cmp_acto_investigacion_sub" autocomplete="off">
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group text-left">
                    <label class="form-control-label">Autoriza Acto de investigación:</label>
                    <select class="form-control select2" id="cmp_autoriza_acto_investigacion" name ="cmp_autoriza_acto_investigacion" autocomplete="off" >
                      <option selected value="">Seleccionar</option>
                      <option selected value="1">Si</option>
                      <option selected value="2">No</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>

            <div id="menu5" style="display: none;">
              <div class="row">
                <div class="col">
                  <div class="form-group text-left">
                    <label class="form-control-label">Monto:</label>
                    <div class="form-group">
                      <input type="number" style="text-align:center;" class="form-control"  id="cmp_cantidad" placeholder="Cantidad" autocomplete="off">
                    </div>
                  </div>
                </div>
                
                <div class="col d-none" id="div_alterna_5">
                  <div class="form-group text-left">
                    <label class="form-control-label">Tipo de solucion alterna:</label>
                    <select class="form-control select2" id="cmp_tipo_solucion_alterna" name ="cmp_tipo_solucion_alterna" autocomplete="off">
                      ${tipos_solucion_alterna}
                    </select>
                  </div>
                </div>
              </div>
            </div>

            <div id="menu2" style="display: none;">
              <div class="row mb-2">
                <div class="col-md-4">
                  <div class="form-group text-left">
                    <label class="form-control-label">Fecha base:</label>
                    <div class="form-group">
                      <input type="text" style="text-align:center;" class="form-control cal"  id="cmp_fecha_base" onchange="ponerFechaBase(this)" value="${fecha_base}" placeholder="dd/mm/yyy"  autocomplete="off">
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group text-left">
                    <label class="form-control-label">Fecha resultado:</label>
                    <div class="form-group">
                      <input type="text"  style="text-align:center;" class="form-control"  id="cmp_fecha_resultado" value="${fecha_base}" placeholder="dd/mm/yyy" autocomplete="off" readonly>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group text-left">
                    <label class="form-control-label">Fecha de Presentacion de Acusación:</label>
                    <div class="form-group">
                      <input type="text"  style="text-align:center;" class="form-control date_fif cal"  id="cmp_fecha_presentacion" placeholder="dd/mm/yyy" autocomplete="off">
                    </div>
                  </div>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="formControlRange">Dias</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <button class="btn btn-outline-secondary" type="button"  onclick="operacion_dia(this, 'restar')">-</button>
                      </div>
                      <input type="text" class="form-control" id="dia" placeholder="0" value="0" style="text-align: center;"  disabled>
                      <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button"  onclick="operacion_dia(this,'sumar')">+</button>
                    </div>
                  </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="formControlRange">Meses</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <button class="btn btn-outline-secondary" type="button" onclick="operacion_mes(this, 'restar')" >-</button>
                      </div>
                      <input type="text" class="form-control" id="mes" placeholder="0" value="0" style="text-align: center;"  disabled>
                      <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" onclick="operacion_mes(this,'sumar')">+</button>
                    </div>
                  </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="formControlRange">Años</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <button class="btn btn-outline-secondary" type="button" onclick="operacion_anio(this, 'restar')">-</button>
                      </div>
                      <input type="text" class="form-control" id="anio" placeholder="0" value="0" style="text-align: center;"  disabled>
                      <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" onclick="operacion_anio(this,'sumar')">+</button>
                    </div>
                  </div>
                  </div>
                </div>
              </div>
              <div class="row mb-2 d-none" id="div_alterna_2">
                <div class="col-md-6">
                  <div class="form-group text-left">
                    <label class="form-control-label">Monto:</label>
                    <div class="form-group">
                      <input type="number" style="text-align:center;" class="form-control"  id="cmp_cantidad" placeholder="Cantidad" autocomplete="off">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group text-left">
                    <label class="form-control-label">Tipo de solucion alterna:</label>
                    <select class="form-control select2" id="cmp_tipo_solucion_alterna" name="cmp_tipo_solucion_alterna" autocomplete="off">
                      ${tipos_solucion_alterna}
                    </select>
                  </div>
                </div>
              </div>
            </div>

            <div id="menu8" style="display: none;">
              <div class="row my-4">
                <div class="col-md-5" id="cmp_imputados_res" style="justify-content: center; align-items: center; display: flex; flex-direction: column; flex-wrap: wrap;">
                  <div style="width: 105px;border-left: 2px solid #848f33;font-weight: bold; margin-bottom:1%;">Imputados</div>
                  ${imputados}
                </div>
                <div class="col-md-7" style="display:flex;  ">

                  <div class="col-md-6">
                    <div class="form-group text-left">
                      <label class="form-control-label">Causa ilegal detención:</label>
                      <div class="form-group">
                        <select class="form-control select2" id="id_causa_ilegal_detencion">
                          <option selected value="">Seleccionar</option>
                          <option value="1">Exceder tiempo de detención</option>
                          <option value="2">Posible caso de tortura</option>
                          <option value="3">Otro</option>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group text-left">
                      <label class="form-control-label">Comentario:</label>
                      <div class="form-group">
                        <input type="text" style="text-align:center;" disabled class="form-control"  id="cmp_imputado_comentario" placeholder="Otro" autocomplete="off">
                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </div>

            <div id="menu1" style="display: none;">

              <div class="form-group text-left">
                <label class="form-control-label">Valor:</label>
                <select class="form-control select2" id="cmp_valor" name ="cmp_valor" autocomplete="off">
                  <option selected value="-">Seleccionar</option>
                  <option value="Si">Si</option>
                  <option value="No">No</option>
                </select>
              </div>

              <div class="row d-none" id="div_impugnacion">
                <div class="col-md-6">
                  <div class="form-group text-left">
                    <label class="form-control-label">Determinación de la fiscalía:</label>
                    <select class="form-control select2" id="cmp_determinacion_fiscalia" name ="cmp_determinacion_fiscalia" autocomplete="off">
                      <option selected value="-">Seleccionar</option>
                      <option value="1">Abstención de investigar</option>
                      <option value="2">El archivo temporal</option>
                      <option value="3">La aplicación de un criterio de oportunidad</option>
                      <option value="4">El no ejercicio de la acción penal</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group text-left">
                    <label class="form-control-label">¿Procede el recurso?</label>
                    <select class="form-control select2" id="cmp_procede_recurso" name ="cmp_procede_recurso" autocomplete="off">
                      <option value="-">Seleccionar</option>
                      <option value="1">Si</option>
                      <option value="2">No</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="row d-none" id="div_alterna_1">
                <div class="col-md-6">
                  <div class="form-group text-left">
                    <label class="form-control-label">Monto:</label>
                    <div class="form-group">
                      <input type="number" style="text-align:center;" class="form-control"  id="cmp_cantidad" placeholder="Cantidad" autocomplete="off">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group text-left">
                    <label class="form-control-label">Tipo de solucion alterna:</label>
                    <select class="form-control select2" id="cmp_tipo_solucion_alterna" name ="cmp_tipo_solucion_alterna" autocomplete="off">
                      ${tipos_solucion_alterna}
                    </select>
                  </div>
                </div>
              </div>

              <div class="row d-none" id="div_sobreseimiento">
                <div class="col-md-6">
                  <div class="form-group text-left">
                    <label class="form-control-label">Fecha Sobreseimiento:</label>
                    <div class="form-group">
                      <input type="text" style="text-align:center;" class="form-control cal"  id="cmp_fecha_sobreseimiento" value="${fecha_base}" placeholder="dd/mm/yyy"  autocomplete="off">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group text-left">
                    <label class="form-control-label">Tipo de Sobreseimiento:</label>
                    <select class="form-control select2" id="cmp_tipo_sobreseimiento" name ="cmp_tipo_sobreseimiento" autocomplete="off">
                      ${tipo_sobreseimiento}
                    </select>
                  </div>
                </div>
              </div>

              <div class="row d-none" id="div_reparacion_danio">
                <div class="col-md-3">
                  <div class="form-group text-left">
                    <label class="form-control-label">Reparación del daño:</label>
                    <select class="form-control select2" id="cmp_reparacion_danio" name ="cmp_reparacion_danio" autocomplete="off">
                      ${reparacion_danio}
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group text-left">
                    <label class="form-control-label">Tipo de reparación del daño:</label>
                    <select class="form-control select2" id="cmp_tipo_reparacion_danio" name ="cmp_tipo_reparacion_danio" autocomplete="off">
                      ${tipo_reparacion_danio}
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group text-left">
                    <label class="form-control-label">Modalidad del cumplimiento de la reparación del daño:</label>
                    <select class="form-control select2" id="cmp_modalidad_reparacion_danio" name ="cmp_modalidad_reparacion_danio" autocomplete="off">
                      ${modalidad_reparacion_danio}
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group text-left">
                    <label class="form-control-label">Monto reparación del daño:</label>
                    <div class="form-group">
                      <input type="number" style="text-align:center;" class="form-control"  id="cmp_monto_reparacion_danio" min="0" placeholder="0" autocomplete="off">
                    </div>
                  </div>
                </div>
              </div>

            </div>

            <div id="menu4" style="display: none;">
              <div class="form-group text-left">
                <label class="form-control-label">Fecha:</label>
                <div class="form-group">
                  <input type="text" style="text-align:center;" class="form-control cal"  id="cmp_fecha" placeholder="Fecha" autocomplete="off">
                </div>
              </div>
            </div>

            <div id="menu3" style="display: none;">
              <div class="form-group text-left">
                <label class="form-control-label">Fecha:</label>
                <div class="form-group">
                  <input type="text" style="text-align:center;" class="form-control date_fif cal"  id="cmp_fecha_compurga" placeholder="Fecha" autocomplete="off">
                </div>
              </div>
            </div>

            <div class="form-group text-left">
              <label class="form-control-label">Comentarios adicionales:</label>
              <textarea class="form-control" id="cmp_comentarios_resolutivo" rows="3"></textarea>
            </div>
            
          </form>

          </div>
        </div>
      `;

      $('#modalHistory').modal('hide');
      $('#bodyAccionesResolutivos').html(html);
      $('#modalAccionesResolutivos').modal('show');

      setTimeout(function(){
        $('.select2').select2({placeholder: 'Seleccionar'});
        $('.calendar').datepicker({dateFormat:'yy-mm-dd',firstDay: 1}).datepicker("setDate", new Date());
        let fecha_actual = new Date();
        $('.cal').datepicker({
          showOtherMonths: true,
          selectOtherMonths: true,
          dateFormat: 'yy-mm-dd',
          changeYear: true,
          yearRange: "c-100:" + (fecha_actual.getFullYear() + 5)
        });

        $('#id_causa_ilegal_detencion').change(function(){
          if($(this).val() == 3){
            $('#cmp_imputado_comentario').prop('disabled', false);
          }else{
            $('#cmp_imputado_comentario').prop('disabled', true);
          }
        });

        $('#cmp_autoriza_investigacion').change(function(){
          if($(this).val() == 8 || $(this).val() == 1){
            $('#acto_investigacion_div').removeClass('d-none')
            $('#acto_investigacion_div').addClass('d-block')
            if($(this).val() == 1){
              $('#cmp_autoriza_investigacion_sub').html(sub_actos_option_100);
            }else{
              $('#cmp_autoriza_investigacion_sub').html(sub_actos_option_300);
            }
          }else{
            $('#acto_investigacion_div').addClass('d-none');
            $('#acto_investigacion_div').removeClass('d-block')
          }
        });

        $('#cmp_valor').change(function(){
          let valor = $(this).val()
          let resol = $('#cmp_resolutivo').val();
          if(resol == 95){
            if(valor == 'Si'){
              $('#div_impugnacion').removeClass('d-none');
            }else{
              $('#div_impugnacion').addClass('d-none');
            }
          }
        });

        $('#cmp_resolutivo').change(function(){
          if([34,41,78,173].includes(parseInt($('#cmp_resolutivo').val()) )){
            let tipo_valor = parseInt($('#cmp_resolutivo').find('option:selected').attr('data-tipo'));
            if(tipo_valor == 1){
              $('#div_alterna_1').removeClass('d-none');
            }else if(tipo_valor == 2){
              $('#div_alterna_2').removeClass('d-none');
            }else if(tipo_valor == 5){
              $('#div_alterna_5').removeClass('d-none');
            }
          }else{
            $('#div_alterna_1').addClass('d-none');
            $('#div_alterna_2').addClass('d-none');
            $('#div_alterna_5').addClass('d-none');
          } 

          if(parseInt($('#cmp_resolutivo').val()) == 9){
            let tipo_valor = parseInt($('#cmp_resolutivo').find('option:selected').attr('data-tipo'));
            if(tipo_valor == 1){
              $('#div_sobreseimiento').removeClass('d-none');
            }
          }else{
            $('#div_sobreseimiento').addClass('d-none');
          }

          if( [141,227].includes(parseInt($('#cmp_resolutivo').val()) ) ){
            let tipo_valor = parseInt($('#cmp_resolutivo').find('option:selected').attr('data-tipo'));
            if(tipo_valor == 1){
              $('#div_reparacion_danio').removeClass('d-none');
            }
          }else{
            $('#div_reparacion_danio').addClass('d-none');
          }

        });

        $.ajax({
          type:'post',
          url:'/public/obtener_resolutivos',
          data:{
          },
          success:function(response) {
            body = '';
            if(response.status==100){
                var datas = response.response;
                //console.log(datas);
                body='<option value="-">Seleccione un resolutivo</option>';
                for (var j = 0; j < datas.length; j++) {
                  body += `<option value="${datas[j]['id_resolutivo']}" data-tipo="${datas[j]['tipo_resultado']}">${datas[j]['descripcion']}</option>`;
                }
              $("#cmp_resolutivo").html(body);
  
            }else{
              body = body.concat('<option value="-">Seleccione un resolutivo</option>');
              $("#cmp_resolutivo").html(body);
  
            }
          }
        });

      },300)

    }
  
    function elegir_menu(id){
      menu = $('option:selected', id).attr('data-tipo');
  
      if(menu == 1){
        $('#menu1').css('display', 'block');
        $('#menu2').css('display', 'none');
        $('#menu3').css('display', 'none');
        $('#menu4').css('display', 'none');
        $('#menu5').css('display', 'none');
        $('#menu8').css('display', 'none');
      }else if(menu == 2){
        $('#menu1').css('display', 'none');
        $('#menu2').css('display', 'block');
        $('#menu3').css('display', 'none');
        $('#menu4').css('display', 'none');
        $('#menu5').css('display', 'none');
        $('#menu8').css('display', 'none');
      }else if(menu == 3){
        $('#menu1').css('display', 'none');
        $('#menu2').css('display', 'none');
        $('#menu3').css('display', 'block');
        $('#menu4').css('display', 'none');
        $('#menu5').css('display', 'none');
        $('#menu8').css('display', 'none');
      }else if(menu == 4){
        $('#menu1').css('display', 'none');
        $('#menu2').css('display', 'none');
        $('#menu3').css('display', 'none');
        $('#menu4').css('display', 'block');
        $('#menu5').css('display', 'none');
        $('#menu8').css('display', 'none');
      }else if(menu == 5){
        $('#menu1').css('display', 'none');
        $('#menu2').css('display', 'none');
        $('#menu3').css('display', 'none');
        $('#menu4').css('display', 'none');
        $('#menu5').css('display', 'block');
        $('#menu8').css('display', 'none');
      }else if(menu == 8){
        $('#menu1').css('display', 'none');
        $('#menu2').css('display', 'none');
        $('#menu3').css('display', 'none');
        $('#menu4').css('display', 'none');
        $('#menu5').css('display', 'none');
        $('#menu8').css('display', 'block');
      }
  
    }
  
    function guardar_resolutivo(){
      folioC =$('#folioC').val();
      id_resolutivo = $('#cmp_resolutivo').val();
      resolutivo = $('select[name="cmp_resolutivo"] option:selected').text();
      tipo_resolutivo = $('select[name="cmp_resolutivo"] option:selected').attr('data-tipo');
      comentarios_adicionales  = $('#cmp_comentarios_resolutivo').val();
      folioC_id_audiencia = $('#folioC_id_audiencia').val();
      acto_investigacion = ($('#cmp_autoriza_investigacion').val() == 8 || $('#cmp_autoriza_investigacion').val() == 1) ? $('#cmp_autoriza_investigacion_sub').val() : $('#cmp_autoriza_investigacion').val()
      autoriza_acto_investigacion = $('#cmp_autoriza_acto_investigacion').val();
    
      // ### valores iniciales ###
      // -- Menu 1
      let tipo_valor = null;
      let determinacion_fiscalia = null;
      let procede_recurso = null;
      let cmp_tipo_solucion_alterna = null;
      let fecha_dicta_sobreseimiento = null;
      let tipo_sobreseimiento = null;
      let reparacion_danio = null;
      let tipo_reparacion_danio = null;
      let modalidad_reparacion_danio = null;
      let monto_reparacion_danio = null;
      
      // -- Menu 2
      let fecha_base = null;
      let fecha_resultado = null;
      let fecha_presentacion = null;
      let anios = null;
      let meses  = null;
      let dias = null;

      // -- Menu 3
      let cmp_fecha_compurga = null;

      // -- Menu 4
      let fecha = null;

      // -- Menu 5
      let numero = null;

      // -- Menu 8
      let ids_imputado = null;
      let id_causa_ilegal_detencion = null;
      let comentarios_imputado = null;


      if(tipo_resolutivo == 1){
        tipo_valor = $('#cmp_valor').val();
        
        if(tipo_valor == 'Si'){
          if(id_resolutivo == 95){
            determinacion_fiscalia = $('#cmp_determinacion_fiscalia').val();
            procede_recurso = $('#cmp_procede_recurso').val();
          }
        }
        
        if([78,173].includes(parseInt(id_resolutivo))){
          numero = $('#div_alterna_1 #cmp_cantidad').val();
          cmp_tipo_solucion_alterna = $('#div_alterna_1 #cmp_tipo_solucion_alterna').val() == '-' ? null : $('#div_alterna_1 #cmp_tipo_solucion_alterna').val();
        }

        if(id_resolutivo == 9){
          tipo_sobreseimiento	= $('#cmp_tipo_sobreseimiento').val()
          fecha_dicta_sobreseimiento = $('#cmp_fecha_sobreseimiento').val()
        }

        if([141,227].includes(parseInt(id_resolutivo))){
          reparacion_danio = $('#cmp_reparacion_danio').val();
          tipo_reparacion_danio = $('#cmp_tipo_reparacion_danio').val();
          modalidad_reparacion_danio = $('#cmp_modalidad_reparacion_danio').val();
          monto_reparacion_danio = $('#cmp_monto_reparacion_danio').val();
        }

      }
    
      if(tipo_resolutivo == 3){
        cmp_fecha_compurga = $('#cmp_fecha_compurga').val();
      }

      if(tipo_resolutivo == 2){
        fecha_base = $('#cmp_fecha_base').val();
        fecha_resultado = $('#cmp_fecha_resultado').val();
        fecha_presentacion = $('#cmp_fecha_presentacion').val();
        anios = $('#anio').val();
        meses  = $('#mes').val();
        dias = $('#dia').val();
        if(id_resolutivo == 34){
          numero = $('#div_alterna_2 #cmp_cantidad').val();
          cmp_tipo_solucion_alterna = $('#div_alterna_2 #cmp_tipo_solucion_alterna').val() == '-' ? null : $('#div_alterna_2 #cmp_tipo_solucion_alterna').val();
        }
      }
    
      if(tipo_resolutivo == 4){
        fecha = $('#cmp_fecha').val();
      }
    
      if(tipo_resolutivo == 5){
        numero = $('#menu5 #cmp_cantidad').val();
        if(id_resolutivo == '41'){
          cmp_tipo_solucion_alterna = $('#div_alterna_5 #cmp_tipo_solucion_alterna').val() == '-' ? null : $('#cmp_tipo_solucion_alterna').val();
        }
      }
    
      if(tipo_resolutivo == 8){
        imputados_selected = [];
        $('.imputado_menu8').each(function(index, val){
            imputados_selected.push($(this).val());
        });

        ids_imputado = imputados_selected;
        id_causa_ilegal_detencion = $('#id_causa_ilegal_detencion').val();
        comentarios_imputado = $('#id_causa_ilegal_detencion').val() == 3 ? $('#cmp_imputado_comentario').val() : '';
      }
  
      var datas = {
        "folio_carpeta":folioC,
        "id_solicitud": carpetaActiva.id_solicitud,
        "id_resolutivo":id_resolutivo,
        "id_imputado":ids_imputado,
        "tipo_valor": tipo_valor,
        "numero":numero,
        "fecha":fecha,
        "fecha_base":fecha_base,
        "anios": anios,
        "meses": meses,
        "dias": dias,
        "cmp_fecha_compurga":cmp_fecha_compurga,
        "fecha_resultado":fecha_resultado,
        "fecha_presentacion":fecha_presentacion,
        "id_causa_ilegal_detencion":id_causa_ilegal_detencion,
        "comentarios_imputado":comentarios_imputado,
        "comentarios_adicionales":comentarios_adicionales,
        "tipo_resultado":tipo_resolutivo,
        "id_audiencia":folioC_id_audiencia,
        "acto_investigacion":acto_investigacion,
        "autoriza_acto_investigacion":autoriza_acto_investigacion,
        "determinacion_fiscalia": determinacion_fiscalia,
        "procede_recurso": procede_recurso,
        "tipo_solucion_alterna": cmp_tipo_solucion_alterna,
        "tipo_sobreseimiento": tipo_sobreseimiento,
        "fecha_dicta_sobreseimiento":fecha_dicta_sobreseimiento,
        "reparacion_danio" : reparacion_danio,
        "tipo_reparacion_danio" : tipo_reparacion_danio,
        "modalidad_reparacion_danio" : modalidad_reparacion_danio,
        "monto_reparacion_danio" : monto_reparacion_danio
      };
      
      console.log(datas);
      
      $.ajax({
        type:'post',
        url:'/public/guardar_audiencias_resolutivos',
        data:{
          "folio_carpeta":folioC,
          "id_solicitud": carpetaActiva.id_solicitud,
          "id_resolutivo":id_resolutivo,
          "id_imputado":ids_imputado,
          "tipo_valor": tipo_valor,
          "numero":numero,
          "fecha":fecha,
          "fecha_base":fecha_base,
          "anios": anios,
          "meses": meses,
          "dias": dias,
          "cmp_fecha_compurga":cmp_fecha_compurga,
          "fecha_resultado":fecha_resultado,
          "fecha_presentacion":fecha_presentacion,
          "id_causa_ilegal_detencion":id_causa_ilegal_detencion,
          "comentarios_imputado":comentarios_imputado,
          "comentarios_adicionales":comentarios_adicionales,
          "tipo_resultado":tipo_resolutivo,
          "id_audiencia":folioC_id_audiencia,
          "acto_investigacion":acto_investigacion,
          "autoriza_acto_investigacion":autoriza_acto_investigacion,
          "determinacion_fiscalia": determinacion_fiscalia,
          "procede_recurso": procede_recurso,
          "tipo_solucion_alterna": cmp_tipo_solucion_alterna,
          "tipo_sobreseimiento": tipo_sobreseimiento,
          "fecha_dicta_sobreseimiento":fecha_dicta_sobreseimiento,
          "reparacion_danio" : reparacion_danio,
          "tipo_reparacion_danio" : tipo_reparacion_danio,
          "modalidad_reparacion_danio" : modalidad_reparacion_danio,
          "monto_reparacion_danio" : monto_reparacion_danio
        },
        success:function(response) {
          body = '';
          if(response.status==100){
            var exito = "<p class='mg-b-20 mg-x-20'>Resolutivo agregado correctamente </p>";
            $('#modalAccionesResolutivos').modal('hide');
            $('#modalHistory').modal('hide');
            modal_success(exito,'modalHistory');
            obtener_audiencias_resolutivos(folioC,folioC_id_audiencia,'primera');
          }else{
            var error = "<p class='mg-b-20 mg-x-20'>"+response.message+"</p>";
            $('#modalAccionesResolutivos').modal('hide');
            $('#modalHistory').modal('hide');
            modal_error(error,'modalHistory');
          }
        }
      });
      
    }
  
    function cargarCamposEditarResolutivo(id_audiencia_resolutivo,id_audiencia,folio_carpeta,id_resolutivo,id_imputado,imputado,tipo_valor,numero,fecha,fecha_base,anio,mes,dia,cmp_fecha_compurga,fecha_resultado,fecha_presentacion,id_causa_ilegal_detencion,comentarios_imputado,comentarios_adicionales,tipo_resultado,estatus,acto_investigacion,autoriza_acto_investigacion,determinacion_fiscalia ,procede_recurso, tipo_solucion_alterna,tipo_sobreseimiento_c,fecha_dicta_sobreseimiento,reparacion_danio_c,tipo_reparacion_danio_c,modalidad_reparacion_danio_c,monto_reparacion_danio ){
      let menu ='';
      let actos_inv = [2,3,4,5,6,9,10];
      let date = new Date();
      let fecha_base_C = date.getFullYear()+'-'+(date.getMonth() + 1)+'-'+date.getDate();

      let tipos_solucion_alterna = '<option selected value="-">Seleccionar</option>';
      for(i in catalogo_tipo_solucion_alterna){
        if(tipo_solucion_alterna == catalogo_tipo_solucion_alterna[i].id_tipo_solucion_alterna){
          tipos_solucion_alterna += `<option selected value="${catalogo_tipo_solucion_alterna[i].id_tipo_solucion_alterna}">${catalogo_tipo_solucion_alterna[i].tipo_solucion_alterna}</option>`;   
        }
        tipos_solucion_alterna += `<option value="${catalogo_tipo_solucion_alterna[i].id_tipo_solucion_alterna}">${catalogo_tipo_solucion_alterna[i].tipo_solucion_alterna}</option>`;   
      }

      let tipo_sobreseimiento = '<option selected value="-">Seleccionar</option>';
      for(i in catalogo_tipo_sobreseimiento){
        if(tipo_sobreseimiento_c == catalogo_tipo_sobreseimiento[i].id_tipo_sobreseimiento){
          tipo_sobreseimiento += `<option selected value="${catalogo_tipo_sobreseimiento[i].id_tipo_sobreseimiento}">${catalogo_tipo_sobreseimiento[i].tipo_sobreseimiento}</option>`;   
        }
        tipo_sobreseimiento += `<option value="${catalogo_tipo_sobreseimiento[i].id_tipo_sobreseimiento}">${catalogo_tipo_sobreseimiento[i].tipo_sobreseimiento}</option>`;   
      }

      let tipo_reparacion_danio = '<option selected value="-">Seleccionar</option>';
      for(i in catalogo_tipo_reparacion_danio){
        if(tipo_reparacion_danio_c == catalogo_tipo_reparacion_danio[i].id_tipo_reparacion_danio){
          tipo_reparacion_danio += `<option selected value="${catalogo_tipo_reparacion_danio[i].id_tipo_reparacion_danio}">${catalogo_tipo_reparacion_danio[i].tipo_reparacion_danio}</option>`;   
        }
        tipo_reparacion_danio += `<option value="${catalogo_tipo_reparacion_danio[i].id_tipo_reparacion_danio}">${catalogo_tipo_reparacion_danio[i].tipo_reparacion_danio}</option>`;   
      }

      let reparacion_danio = '<option selected value="-">Seleccionar</option>';
      for(i in catalogo_reparacion_danio){
        if(reparacion_danio_c == catalogo_reparacion_danio[i].id_reparacion_danio){
          reparacion_danio += `<option selected value="${catalogo_reparacion_danio[i].id_reparacion_danio}">${catalogo_reparacion_danio[i].reparacion_danio}</option>`;   
        }
        reparacion_danio += `<option value="${catalogo_reparacion_danio[i].id_reparacion_danio}">${catalogo_reparacion_danio[i].reparacion_danio}</option>`;   
      }

      let modalidad_reparacion_danio = '<option selected value="-">Seleccionar</option>';
      for(i in catalogo_modalidad_reparacion_danio){
        if(modalidad_reparacion_danio_c == catalogo_modalidad_reparacion_danio[i].id_modalidad_reparacion_danio){
          modalidad_reparacion_danio += `<option selected value="${catalogo_modalidad_reparacion_danio[i].id_modalidad_reparacion_danio}">${catalogo_modalidad_reparacion_danio[i].modalidad_reparacion_danio}</option>`;   
        }
        modalidad_reparacion_danio += `<option value="${catalogo_modalidad_reparacion_danio[i].id_modalidad_reparacion_danio}">${catalogo_modalidad_reparacion_danio[i].modalidad_reparacion_danio}</option>`;   
      }

      switch (tipo_resultado){
  
        case 1: 

          let cmp_valor_E = '';
          let div_impugnacion = '';
          let div_alterna_1 = '';
          let div_sobreseimiento = '';
          let div_reparacion_danio = '';

          if(tipo_valor == 'No'){
            cmp_valor_E =`
              <option value="-">Seleccionar</option>
              <option value="Si">Si</option>
              <option selected value="No">No</option>
            `;
            
            div_impugnacion = `
              <div class="row d-none" id="div_impugnacion_E">
                <div class="col-md-6">
                  <div class="form-group text-left">
                    <label class="form-control-label">Determinación de la fiscalía:</label>
                    <select class="form-control select2" id="cmp_determinacion_fiscalia_E" name ="cmp_determinacion_fiscalia_E" autocomplete="off">
                      <option selected value="-">Seleccionar</option>
                      <option value="1">Abstención de investigar</option>
                      <option value="2">El archivo temporal</option>
                      <option value="3">La aplicación de un criterio de oportunidad</option>
                      <option value="4">El no ejercicio de la acción penal</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group text-left">
                    <label class="form-control-label">¿Procede el recurso?</label>
                    <select class="form-control select2" id="cmp_procede_recurso_E" name ="cmp_procede_recurso_E" autocomplete="off">
                      <option selected value="-">Seleccionar</option>
                      <option value="1">Si</option>
                      <option value="2">No</option>
                    </select>
                  </div>
                </div>
              </div>
            `;
          }else{
            cmp_valor_E =`
              <option value="-">Seleccionar</option>
              <option selected value="Si">Si</option>
              <option value="No">No</option>
            `;

            if(id_resolutivo == 95){
              div_impugnacion = `
                <div class="row" id="div_impugnacion_E">
                  <div class="col-md-6">
                    <div class="form-group text-left">
                      <label class="form-control-label">Determinación de la fiscalía:</label>
                      <select class="form-control select2" id="cmp_determinacion_fiscalia_E" name ="cmp_determinacion_fiscalia_E" autocomplete="off">
                        <option selected value="-">Seleccionar</option>
                        <option ${determinacion_fiscalia == 1 ? 'selected' : ''} value="1">Abstención de investigar</option>
                        <option ${determinacion_fiscalia == 2 ? 'selected' : ''} value="2">El archivo temporal</option>
                        <option ${determinacion_fiscalia == 3 ? 'selected' : ''} value="3">La aplicación de un criterio de oportunidad</option>
                        <option ${determinacion_fiscalia == 4 ? 'selected' : ''} value="4">El no ejercicio de la acción penal</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group text-left">
                      <label class="form-control-label">¿Procede el recurso?</label>
                      <select class="form-control select2" id="cmp_procede_recurso_E" name ="cmp_procede_recurso_E" autocomplete="off">
                        <option selected value="-">Seleccionar</option>
                        <option ${procede_recurso == 1 ? 'selected' : ''} value="1">Si</option>
                        <option ${procede_recurso == 2 ? 'selected' : ''} value="2">No</option>
                      </select>
                    </div>
                  </div>
                </div>
              `;
            }
          }

          if( [78,173].includes(parseInt(id_resolutivo)) ){
            div_alterna_1 = `
              <div class="row" id="div_alterna_1_E">
                <div class="col-md-6">
                  <div class="form-group text-left">
                    <label class="form-control-label">Monto:</label>
                    <div class="form-group">
                      <input type="number" style="text-align:center;" class="form-control" value="${numero}" id="cmp_cantidad_E" placeholder="Cantidad" autocomplete="off">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group text-left">
                    <label class="form-control-label">Tipo de solucion alterna:</label>
                    <select class="form-control select2" id="cmp_tipo_solucion_alterna_E" name ="cmp_tipo_solucion_alterna_E" autocomplete="off">
                      ${tipos_solucion_alterna}
                    </select>
                  </div>
                </div>
              </div>
            `;
          }

          if(id_resolutivo == 9){
            div_sobreseimiento = `
              <div class="row " id="div_sobreseimiento_E">
                <div class="col-md-6">
                  <div class="form-group text-left">
                    <label class="form-control-label">Fecha Sobreseimiento:</label>
                    <div class="form-group">
                      <input type="text" style="text-align:center;" class="form-control cal"  id="cmp_fecha_sobreseimiento_E" value="${fecha_dicta_sobreseimiento ?? fecha_base_c}" placeholder="dd/mm/yyy"  autocomplete="off">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group text-left">
                    <label class="form-control-label">Tipo de solucion alterna:</label>
                    <select class="form-control select2" id="cmp_tipo_sobreseimiento_E" name ="cmp_tipo_sobreseimiento_E" autocomplete="off">
                      ${tipo_sobreseimiento}
                    </select>
                  </div>
                </div>
              </div>
            `;
          }

          if( [141,227].includes(parseInt(id_resolutivo)) ){
            div_reparacion_danio = `
              <div class="row " id="div_reparacion_danio_E">
                <div class="col-md-3">
                  <div class="form-group text-left">
                    <label class="form-control-label">Reparación del daño:</label>
                    <select class="form-control select2" id="cmp_reparacion_danio_E" name ="cmp_reparacion_danio_E" autocomplete="off">
                      ${reparacion_danio}
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group text-left">
                    <label class="form-control-label">Tipo de reparación del daño:</label>
                    <select class="form-control select2" id="cmp_tipo_reparacion_danio_E" name ="cmp_tipo_reparacion_danio_E" autocomplete="off">
                      ${tipo_reparacion_danio}
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group text-left">
                    <label class="form-control-label">Modalidad del cumplimiento de la reparación del daño:</label>
                    <select class="form-control select2" id="cmp_modalidad_reparacion_danio_E" name ="cmp_modalidad_reparacion_danio_E" autocomplete="off">
                      ${modalidad_reparacion_danio}
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group text-left">
                    <label class="form-control-label">Monto reparación del daño:</label>
                    <div class="form-group">
                      <input type="number" style="text-align:center;" class="form-control"  id="cmp_monto_reparacion_danio_E" min="0" placeholder="0" value="${monto_reparacion_danio}" autocomplete="off">
                    </div>
                  </div>
                </div>
              </div>
            `;
          }

          menu = `
            <div id="menu1_E">
              <div class="form-group text-left">
                <label class="form-control-label">Valor:</label>
                <select class="form-control select2" id="cmp_valor_E" name ="cmp_valor_E" autocomplete="off">
                  ${cmp_valor_E}
                </select>
              </div>
              ${div_impugnacion}
              ${div_alterna_1}
              ${div_sobreseimiento}
              ${div_reparacion_danio}
            </div>
          `;
        break;
        
        case 2:
          count_days   = anio == null ? 0 : anio;
          count_months = mes == null ? 0 : mes;
          count_years = dia == null ? 0 : dia;

          let div_alterna_2 = '';
          if(parseInt(id_resolutivo) == 34 ){
            div_alterna_2 = `
              <div class="row mb-2" id="div_alterna_2_E">
                <div class="col-md-6">
                  <div class="form-group text-left">
                    <label class="form-control-label">Monto:</label>
                    <div class="form-group">
                      <input type="number" style="text-align:center;" class="form-control" value="${numero}" id="cmp_cantidad_E" placeholder="Cantidad" autocomplete="off">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group text-left">
                    <label class="form-control-label">Tipo de solucion alterna:</label>
                    <select class="form-control select2" id="cmp_tipo_solucion_alterna_E" name ="cmp_tipo_solucion_alterna_E" autocomplete="off">
                      ${tipos_solucion_alterna}
                    </select>
                  </div>
                </div>
              </div>
            `;
          }

          menu = `
            <div id="menu2_E">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group text-left">
                    <label class="form-control-label">Fecha base:</label>
                    <div class="form-group">
                      <input type="text" style="text-align:center;" class="form-control cal" value="${fecha_base}"  id="cmp_fecha_base" placeholder="dd/mm/yyy"  autocomplete="off">
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group text-left">
                    <label class="form-control-label">Fecha resultado:</label>
                    <div class="form-group">
                      <input type="text"  style="text-align:center;" class="form-control" value="${fecha_resultado}" id="cmp_fecha_resultado" placeholder="dd/mm/yyy" autocomplete="off" readonly>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group text-left">
                    <label class="form-control-label">Fecha de Presentacion de Acusación:</label>
                    <div class="form-group">
                      <input type="text"  style="text-align:center;" class="form-control date_fif cal" value="${fecha_presentacion}" id="cmp_fecha_presentacion_E" placeholder="dd/mm/yyy" autocomplete="off">
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="formControlRange">Dias</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <button class="btn btn-outline-secondary" type="button"  onclick="operacion_dia(this, 'restar')">-</button>
                      </div>
                      <input type="text" class="form-control" id="dia" placeholder="0" value="${dia}" style="text-align: center;"  disabled>
                      <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button"  onclick="operacion_dia(this,'sumar')">+</button>
                    </div>
                  </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="formControlRange">Meses</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <button class="btn btn-outline-secondary" type="button" onclick="operacion_mes(this, 'restar')" >-</button>
                      </div>
                      <input type="text" class="form-control" id="mes" placeholder="0" value="${mes}" style="text-align: center;"  disabled>
                      <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" onclick="operacion_mes(this,'sumar')">+</button>
                    </div>
                  </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="formControlRange">Años</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <button class="btn btn-outline-secondary" type="button" onclick="operacion_anio(this, 'restar')">-</button>
                      </div>
                      <input type="text" class="form-control" id="anio" placeholder="0" value="${anio}" style="text-align: center;"  disabled>
                      <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" onclick="operacion_anio(this,'sumar')">+</button>
                    </div>
                  </div>
                  </div>
                </div>
              </div>
              ${div_alterna_2}
            </div>
          `;
        break;
  
        case 3:

          menu = `
            <div id="menu3_E">
              <div class="form-group text-left">
                <label class="form-control-label">Fecha:</label>
                <div class="form-group">
                  <input type="text" style="text-align:center;" class="form-control date_fif cal" value="${cmp_fecha_compurga}" id="cmp_fecha_compurga_E" placeholder="Fecha" autocomplete="off">
                </div>
              </div>
            </div>
          `;

        break;

        case 4:

          menu = `
            <div id="menu4_E">
              <div class="form-group text-left">
                <label class="form-control-label">Fecha:</label>
                <div class="form-group">
                  <input type="text" style="text-align:center;" class="form-control" value="${fecha}" id="cmp_fecha_E" placeholder="Fecha" autocomplete="off">
                </div>
              </div>
            </div>
          `;
        break;
  
        case 5:
          let div_alterna_5 = '';
          if(parseInt(id_resolutivo) == 41 ){
            div_alterna_5 = `
              <div id="menu5_E">
                <div class="row mb-2">
                  <div class="col">
                    <div class="form-group text-left">
                      <label class="form-control-label">Monto:</label>
                      <div class="form-group">
                        <input type="number" style="text-align:center;" class="form-control" value="${numero}" id="cmp_cantidad_E" placeholder="Cantidad" autocomplete="off">
                      </div>
                    </div>
                  </div>
                  <div class="col" id="div_alterna_5_E">
                    <div class="form-group text-left">
                      <label class="form-control-label">Tipo de solucion alterna:</label>
                      <select class="form-control select2" id="cmp_tipo_solucion_alterna_E" name ="cmp_tipo_solucion_alterna_E" autocomplete="off">
                        ${tipos_solucion_alterna}
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            `;
          }else{
            div_alterna_5 = `
            <div id="menu5_E">
              <div class="form-group text-left">
                <label class="form-control-label">Campo:</label>
                <div class="form-group">
                  <input type="number" style="text-align:center;" class="form-control" value="${numero}" id="cmp_cantidad_E" placeholder="Cantidad" autocomplete="off">
                </div>
              </div>
            </div>  
            `;
          }

          menu = `${div_alterna_5}`;
        break;
        
        case 8: 

          let datosCarpeta = carpetaActiva;
          
          let imputados = '';
          for(i in datosCarpeta.imputados){
            checked = '';

            console.log('imputado seleccionado',imputado);

            if(imputado.length > 1){

              for (j in imputado){
                if(imputado[j] == datosCarpeta.imputados[i].id_persona){
                  console.log('entra a checkear')
                  checked = 'checked';
                }else{
                  console.log('entra a no checkear')
                  checked = '';
                }
              }
            }else{
              if(imputado == datosCarpeta.imputados[i].id_persona){
                checked = 'checked';
              }else{
                checked = '';
              }
            }

            imputados += `<div class="form-check my-2">
              <label class="form-check-label" for="cmp_imputado_${datosCarpeta.imputados[i].id_persona}" >
                <input ${checked} class="form-check-input imputado_menu8" type="checkbox" value="${datosCarpeta.imputados[i].id_persona}" id="cmp_imputado_${datosCarpeta.imputados[i].id_persona}">
                ${ datosCarpeta.imputados[i].tipo == 'fisica' ? datosCarpeta.imputados[i].nombre : datosCarpeta.imputados[i].razon_social}
              </label>
            </div>`;
          }

          menu = `
            <div id="menu8_E">
              <div class="row my-4">

                <div class="col-md-5" id="cmp_imputados_res" style="justify-content: center; align-items: center; display: flex; flex-direction: column; flex-wrap: wrap;">
                  <div style="width: 105px;border-left: 2px solid #848f33;font-weight: bold; margin-bottom:1%;">Imputados</div>
                  ${imputados}
                </div>

                <div class="col-md-7" style="display:flex;  ">

                  <div class="col-md-6">
                    <div class="form-group text-left">
                      <label class="form-control-label">Causa ilegal detención:</label>
                      <div class="form-group">
                        <select class="form-control select2" id="id_causa_ilegal_detencion_E">
                          <option selected value="">Seleccionar</option>
                          <option ${id_causa_ilegal_detencion == 1 ? 'selected' : ''} value="1">Exceder tiempo de detención</option>
                          <option ${id_causa_ilegal_detencion == 2 ? 'selected' : ''} value="2">Posible caso de tortura</option>
                          <option ${id_causa_ilegal_detencion == 3 ? 'selected' : ''} value="3">Otro</option>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group text-left">
                      <label class="form-control-label">Otro:</label>
                      <div class="form-group">
                        <input type="text" style="text-align:center;" ${id_causa_ilegal_detencion == 3 ? '' : 'disabled'} class="form-control" value="${comentarios_imputado == "null" ? "" : comentarios_imputado}" id="cmp_imputado_comentario_E" placeholder="Otro" autocomplete="off">
                      </div>
                    </div>
                  </div>

                </div>

              </div>
            </div>
          `;
        break;
      }
      
      let estatus1 = '';
      if(estatus == 1){
        estatus1 =`
          <option value="-">Seleccionar</option>
          <option selected value="1">Activo</option>
          <option value="0">Inactivo</option>
        `;
      }else{
        estatus1 =`
          <option value="-">Seleccionar</option>
          <option value="1">Activo</option>
          <option selected value="0">Inactivo</option>
        `;
      }

      let actos_option = `<option selected value="">Seleccionar</option>`;
      let sub_actos_option_100 = `<option selected value="">Seleccionar</option>`;
      let sub_actos_option_300 = `<option selected value="">Seleccionar</option>`;
      for(i in catalogo_actos_investigacion){
        if(catalogo_actos_investigacion[i].clave < 100){
          if([2,3,4,5,6].includes(acto_investigacion)){
            if(1 == catalogo_actos_investigacion[i].id_acto_investigacion){
              actos_option += `<option selected value="${catalogo_actos_investigacion[i].id_acto_investigacion}" data-clave="${catalogo_actos_investigacion[i].clave}"> ${catalogo_actos_investigacion[i].acto_investigacion}</option>`;
            }
          }

          if([1,10].includes(acto_investigacion)){
            if(8 == catalogo_actos_investigacion[i].id_acto_investigacion){
              actos_option += `<option selected value="${catalogo_actos_investigacion[i].id_acto_investigacion}" data-clave="${catalogo_actos_investigacion[i].clave}"> ${catalogo_actos_investigacion[i].acto_investigacion}</option>`;
            }
          }

          if(acto_investigacion == catalogo_actos_investigacion[i].id_acto_investigacion){
            actos_option += `<option selected value="${catalogo_actos_investigacion[i].id_acto_investigacion}" data-clave="${catalogo_actos_investigacion[i].clave}"> ${catalogo_actos_investigacion[i].acto_investigacion}</option>`;
          }
          actos_option += `<option value="${catalogo_actos_investigacion[i].id_acto_investigacion}" data-clave="${catalogo_actos_investigacion[i].clave}"> ${catalogo_actos_investigacion[i].acto_investigacion}</option>`;
        }

        if(catalogo_actos_investigacion[i].clave > 100 && catalogo_actos_investigacion[i].clave < 300){
          if(acto_investigacion == catalogo_actos_investigacion[i].id_acto_investigacion){
            sub_actos_option_100 += `<option selected value="${catalogo_actos_investigacion[i].id_acto_investigacion}" data-clave="${catalogo_actos_investigacion[i].clave}"> ${catalogo_actos_investigacion[i].acto_investigacion}</option>`;
          }
          sub_actos_option_100 += `<option value="${catalogo_actos_investigacion[i].id_acto_investigacion}" data-clave="${catalogo_actos_investigacion[i].clave}"> ${catalogo_actos_investigacion[i].acto_investigacion}</option>`;

        }else if(catalogo_actos_investigacion[i].clave > 300){
          if(acto_investigacion == catalogo_actos_investigacion[i].id_acto_investigacion){
            sub_actos_option_300 += `<option selected value="${catalogo_actos_investigacion[i].id_acto_investigacion}" data-clave="${catalogo_actos_investigacion[i].clave}"> ${catalogo_actos_investigacion[i].acto_investigacion}</option>`;
          }
          sub_actos_option_300 += `<option value="${catalogo_actos_investigacion[i].id_acto_investigacion}" data-clave="${catalogo_actos_investigacion[i].clave}"> ${catalogo_actos_investigacion[i].acto_investigacion}</option>`;
        }
      }

      let sub_actos_inv = actos_inv.includes(acto_investigacion) ? 'd-block':'d-none';
      let sub_actos_inv_opc = [2,3,4,5,6].includes(acto_investigacion) ? sub_actos_option_100 : ([9,10].includes(acto_investigacion) ? sub_actos_option_300 : '<option selected value="">Seleccionar</option>');

      let html = `
        <div class="row">
          <div class="col-lg-12">
          <form action="" id="frm_resolutivos_E">
            <input type="hidden" id="folioC_E" value="${folio_carpeta}">
            <input type="hidden" id="folioC_A_E" value="${id_audiencia_resolutivo}">
            <input type="hidden" id="folioC_id_audiencia_E" value="${id_audiencia}">

            <div class="row">
              <div class="col-md-8">
                <div class="form-group text-left">
                  <label class="form-control-label">Resolutivo:</label>
                  <select class="form-control select2" id="cmp_resolutivo_E" name ="cmp_resolutivo_E" autocomplete="off">
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group text-left">
                  <label class="form-control-label">Estatus:</label>
                  <select class="form-control select2" id="cmp_estatus_resolutivo_E" name ="cmp_estatus_resolutivo_E" autocomplete="off">
                    ${estatus1}
                  </select>
                </div>
              </div>
            </div>

            <div>
              <div class="row justify-content-between">
                <div class="col-md-5">
                  <div class="form-group text-left">
                    <label class="form-control-label">Acto de investigación:</label>
                    <select class="form-control select2" id="cmp_autoriza_investigacion_E" name ="cmp_acto_investigacion_E" autocomplete="off" >
                      ${actos_option}
                    </select>
                  </div>
                </div>
                <div class="col-md-4 ${sub_actos_inv}" id="acto_investigacion_div_E">
                  <div class="form-group text-left">
                    <label class="form-control-label">Acto de investigación:</label>
                    <select class="form-control select2" id="cmp_autoriza_investigacion_sub_E" name ="cmp_autoriza_investigacion_sub_E" autocomplete="off">
                      ${sub_actos_inv_opc}
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group text-left">
                    <label class="form-control-label">Autoriza Acto de investigación:</label>
                    <select class="form-control select2" id="cmp_autoriza_acto_investigacion_E" name ="cmp_autoriza_acto_investigacion_E" autocomplete="off" >
                      <option selected value="">Seleccionar</option>
                      <option ${autoriza_acto_investigacion == 1 ? 'selected': ''} value="1">Si</option>
                      <option ${autoriza_acto_investigacion == 2 ? 'selected': ''} value="2">No</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>

            ${menu}

            <div class="form-group text-left">
              <label class="form-control-label">Comentarios adicionales:</label>
              <textarea class="form-control" value="${comentarios_adicionales}" id="cmp_comentarios_resolutivo_E" rows="3">${comentarios_adicionales}</textarea>
            </div>

          </form>

          </div>
        </div>
      `;
      
      $('#modalHistory').modal('hide');
      $('#bodyAccionesResolutivos_E').html(html);
      $('#modalAccionesResolutivos_E').modal('show');

      setTimeout(function(){
        $('.select2').select2({placeholder: 'Seleccionar'});
        $('.calendar').datepicker({dateFormat:'yy-mm-dd',firstDay: 1}).datepicker("setDate", new Date());
        let fecha_actual = new Date();
        $('.cal').datepicker({
          showOtherMonths: true,
          selectOtherMonths: true,
          dateFormat: 'yy-mm-dd',
          changeYear: true,
          yearRange: "c-100:" + (fecha_actual.getFullYear() + 5)
        });

        $('#id_causa_ilegal_detencion_E').change(function(){
          if($(this).val() == 3){
            $('#cmp_imputado_comentario_E').prop('disabled', false);
          }else{
            $('#cmp_imputado_comentario_E').prop('disabled', true);
          }
        });

        $('#cmp_autoriza_investigacion_E').change(function(){
          if($(this).val() == 8 || $(this).val() == 1){
            $('#acto_investigacion_div_E').removeClass('d-none');
            $('#acto_investigacion_div_E').addClass('d-block');
            if($(this).val() == 1){
              $('#cmp_autoriza_investigacion_sub_E').html(sub_actos_option_100);
            }else{
              $('#cmp_autoriza_investigacion_sub_E').html(sub_actos_option_300);
            }
          }else{
            $('#acto_investigacion_div_E').addClass('d-none');
            $('#acto_investigacion_div_E').removeClass('d-block');
          }
        });

        $('#cmp_valor_E').change(function(){
          let valor = $(this).val()
          let resol = $('#cmp_resolutivo_E').val();
          if(resol == 95){
            if(valor == 'Si'){
              $('#div_impugnacion_E').removeClass('d-none');
            }else{
              $('#div_impugnacion_E').addClass('d-none');
            }
          }
        });

        $('#cmp_resolutivo_E').change(function(){
          if([34,41,78,173].includes(parseInt($('#cmp_resolutivo_E').val()) )){
            let tipo_valor = parseInt($('#cmp_resolutivo_E').find('option:selected').attr('data-tipo'));
            if(tipo_valor == 1){
              $('#div_alterna_1_E').removeClass('d-none');
            }else if(tipo_valor == 2){
              $('#div_alterna_2_E').removeClass('d-none');
            }else if(tipo_valor == 5){
              $('#div_alterna_5_E').removeClass('d-none');
            }
          }else{
            $('#div_alterna_1_E').addClass('d-none');
            $('#div_alterna_2_E').addClass('d-none');
            $('#div_alterna_5_E').addClass('d-none');
          }

          if(parseInt($('#cmp_resolutivo_E').val()) == 9){
            let tipo_valor = parseInt($('#cmp_resolutivo_E').find('option:selected').attr('data-tipo'));
            if(tipo_valor == 1){
              $('#div_sobreseimiento_E').removeClass('d-none');
            }
          }else{
            $('#div_sobreseimiento_E').addClass('d-none');
          }

          
          if( [141,227].includes(parseInt($('#cmp_resolutivo_E').val()) ) ){
            let tipo_valor = parseInt($('#cmp_resolutivo_E').find('option:selected').attr('data-tipo'));
            if(tipo_valor == 1){
              $('#div_reparacion_danio_E').removeClass('d-none');
            }
          }else{
            $('#div_reparacion_danio_E').addClass('d-none');
          }

        });

        $.ajax({
          type:'post',
          url:'/public/obtener_resolutivos',
          data:{
          },
          success:function(response) {
            body = '';
            if(response.status==100){
                var datas = response.response;
                //console.log(datas);
                body='<option value="-">Seleccione un resolutivo</option>';
                for (var j = 0; j < datas.length; j++) {
                  body += `<option ${datas[j]['id_resolutivo'] == id_resolutivo ? 'selected' : ''}  value="${datas[j]['id_resolutivo']}" data-tipo="${datas[j]['tipo_resultado']}">${datas[j]['descripcion']}</option>`;
                }
              $("#cmp_resolutivo_E").html(body);
              $('#cmp_resolutivo_E').prop('disabled', true);
            }else{
              body = body.concat('<option value="-">Seleccione un resolutivo</option>');
              $("#cmp_resolutivo_E").html(body);
  
            }
          }
        });

      },300)
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
      acto_investigacion = ($('#cmp_autoriza_investigacion_E').val() == 8 || $('#cmp_autoriza_investigacion_E').val() == 1) ? $('#cmp_autoriza_investigacion_sub_E').val() : $('#cmp_autoriza_investigacion_E').val()
      autoriza_acto_investigacion = $('#cmp_autoriza_acto_investigacion_E').val();
      
      // ### valores iniciales ###
      // -- Menu 1
      let tipo_valor = null;
      let determinacion_fiscalia = null;
      let procede_recurso = null;
      let cmp_tipo_solucion_alterna = null;
      let fecha_dicta_sobreseimiento = null;
      let tipo_sobreseimiento = null;
      let reparacion_danio = null;
      let tipo_reparacion_danio = null;
      let modalidad_reparacion_danio = null;
      let monto_reparacion_danio = null;

      // -- Menu 2
      let fecha_base = null;
      let fecha_resultado = null;
      let fecha_presentacion= null;
      let anios = null;
      let meses  = null;
      let dias = null;
      
      // -- Menu 3
      let cmp_fecha_compurga = null;

      // -- Menu 4
      let fecha = null;

      // -- Menu 5
      let numero = null;

      // -- Menu 8
      let ids_imputado = null;
      let id_causa_ilegal_detencion = null;
      let comentarios_imputado = null;


      if(tipo_resolutivo == 1){
        tipo_valor = $('#cmp_valor_E').val();

        if(tipo_valor == 'Si'){
          if(id_resolutivo == 95){
            determinacion_fiscalia = $('#cmp_determinacion_fiscalia_E').val();
            procede_recurso = $('#cmp_procede_recurso_E').val();
          }
        }

        if([78,173].includes(parseInt(id_resolutivo))){
          numero = $('#div_alterna_1_E #cmp_cantidad_E').val();
          cmp_tipo_solucion_alterna = $('#div_alterna_1_E #cmp_tipo_solucion_alterna_E').val() == '-' ? null : $('#div_alterna_1_E #cmp_tipo_solucion_alterna_E').val();
        }

        if(id_resolutivo == 9){
          tipo_sobreseimiento	= $('#cmp_tipo_sobreseimiento_E').val()
          fecha_dicta_sobreseimiento = $('#cmp_fecha_sobreseimiento_E').val()
        }

        if([141,227].includes(parseInt(id_resolutivo))){
          reparacion_danio = $('#cmp_reparacion_danio_E').val();
          tipo_reparacion_danio = $('#cmp_tipo_reparacion_danio_E').val();
          modalidad_reparacion_danio = $('#cmp_modalidad_reparacion_danio_E').val();
          monto_reparacion_danio = $('#cmp_monto_reparacion_danio_E').val();
        }
      }
  
      if(tipo_resolutivo == 2){
        fecha_base = $('#cmp_fecha_base').val();
        fecha_resultado = $('#cmp_fecha_resultado').val();
        fecha_presentacion = $('#cmp_fecha_presentacion_E').val()
        anios = $('#anio').val();
        meses  = $('#mes').val();
        dias = $('#dia').val();
        if(id_resolutivo == 34){
          numero = $('#div_alterna_2_E #cmp_cantidad_E').val();
          cmp_tipo_solucion_alterna = $('#div_alterna_2_E #cmp_tipo_solucion_alterna_E').val() == '-' ? null : $('#div_alterna_2_E #cmp_tipo_solucion_alterna_E').val();
        }
      }

      if(tipo_resolutivo == 3){
        cmp_fecha_compurga = $('#cmp_fecha_compurga_E').val();
      }

      if(tipo_resolutivo == 4){
        fecha = $('#cmp_fecha_E').val();
      }
  
      if(tipo_resolutivo == 5){
        numero = $('#cmp_cantidad_E').val();
        if(id_resolutivo == '41'){
          cmp_tipo_solucion_alterna = $('#div_alterna_5_E #cmp_tipo_solucion_alterna_E').val() == '-' ? null : $('#cmp_tipo_solucion_alterna_E').val();
        }
      }
  
      if(tipo_resolutivo == 8){
        imputados_selected = [];
        $('.imputado_menu8').each(function(index, val){
          imputados_selected.push($(this).val());
        });

        ids_imputado = imputados_selected;
        id_causa_ilegal_detencion = $('#id_causa_ilegal_detencion_E').val();
        comentarios_imputado = $('#id_causa_ilegal_detencion_E').val() == 3 ? $('#cmp_imputado_comentario_E').val() : '';
      }

      var data = {
        "id_audiencia_resolutivo":folioC_A_E,
        "folio_carpeta":folioC,
        "id_resolutivo":id_resolutivo,
        "id_imputado":ids_imputado,
        "tipo_valor": tipo_valor,
        "numero":numero,
        "fecha":fecha,
        "fecha_base":fecha_base,
        "anios": anios,
        "meses": meses,
        "dias": dias,
        "cmp_fecha_compurga":cmp_fecha_compurga,
        "fecha_resultado":fecha_resultado,
        "fecha_presentacion":fecha_presentacion,
        "id_causa_ilegal_detencion":id_causa_ilegal_detencion,
        "comentarios_imputado":comentarios_imputado,
        "comentarios_adicionales":comentarios_adicionales,
        "tipo_resultado":tipo_resolutivo,
        "estatus":estatus,
        "id_audiencia":id_audiencia,
        "acto_investigacion":acto_investigacion,
        "autoriza_acto_investigacion":autoriza_acto_investigacion,
        "determinacion_fiscalia": determinacion_fiscalia,
        "procede_recurso": procede_recurso,
        "tipo_solucion_alterna": cmp_tipo_solucion_alterna,
        "tipo_sobreseimiento": tipo_sobreseimiento,
        "fecha_dicta_sobreseimiento":fecha_dicta_sobreseimiento,
        "reparacion_danio" : reparacion_danio,
        "tipo_reparacion_danio" : tipo_reparacion_danio,
        "modalidad_reparacion_danio" : modalidad_reparacion_danio,
        "monto_reparacion_danio" : monto_reparacion_danio
      };

      console.log(data);
  
      $.ajax({
       type:'post',
       url:'/public/editar_audiencias_resolutivos',
       data:{
         "id_audiencia_resolutivo":folioC_A_E,
         "folio_carpeta":folioC,
         "id_resolutivo":id_resolutivo,
         "id_imputado":ids_imputado,
         "tipo_valor": tipo_valor,
         "numero":numero,
         "fecha":fecha,
         "fecha_base":fecha_base,
         "anios": anios,
         "meses": meses,
         "dias": dias,
         "cmp_fecha_compurga":cmp_fecha_compurga,
         "fecha_resultado":fecha_resultado,
         "fecha_presentacion":fecha_presentacion,
         "id_causa_ilegal_detencion":id_causa_ilegal_detencion,
         "comentarios_imputado":comentarios_imputado,
         "comentarios_adicionales":comentarios_adicionales,
         "tipo_resultado":tipo_resolutivo,
         "estatus":estatus,
         "id_audiencia":id_audiencia,
         "acto_investigacion":acto_investigacion,
         "autoriza_acto_investigacion":autoriza_acto_investigacion,
         "determinacion_fiscalia": determinacion_fiscalia,
         "procede_recurso": procede_recurso,
         "tipo_solucion_alterna": cmp_tipo_solucion_alterna,
         "tipo_sobreseimiento": tipo_sobreseimiento,
         "fecha_dicta_sobreseimiento":fecha_dicta_sobreseimiento,
         "reparacion_danio" : reparacion_danio,
         "tipo_reparacion_danio" : tipo_reparacion_danio,
         "modalidad_reparacion_danio" : modalidad_reparacion_danio,
         "monto_reparacion_danio" : monto_reparacion_danio
       },
       success:function(response) {
         body = '';
         if(response.status==100){
           var exito = "<p class='mg-b-20 mg-x-20'>Resolutivo actualizado correctamente</p>";
           $('#modalAccionesResolutivos_E').modal('hide');
           $('#modalHistory').modal('hide');
           modal_success(exito,'modalHistory');
           obtener_audiencias_resolutivos(folioC,id_audiencia,'primera');
         }else{
          var error = "<p class='mg-b-20 mg-x-20'>"+response.message+"</p>";
          $('#modalAccionesResolutivos_E').modal('hide');
          $('#modalHistory').modal('hide');
          modal_error(error,'modalHistory');
         }
       }
      });
      
    }
    
    function modalEliminar(id_resolutivo_audiencia,id_audiencia, tipo_resolutivo){

      let mensaje = '';

      if(tipo_resolutivo == 1){
        mensaje = '¿Deseas eliminar el resolutivo?';
      }else if(tipo_resolutivo == 2){
        mensaje = '¿Deseas eliminar el mandamiento judicial?';
      }else if(tipo_resolutivo == 3){
        mensaje = '¿Deseas eliminar el acuerdo reparatorio?';
      }else if(tipo_resolutivo == 4){
        mensaje = '¿Deseas eliminar la medida cautelar?';
      }else if(tipo_resolutivo == 5){
        mensaje = '¿Deseas eliminar la medida de proteccón?';
      }else if(tipo_resolutivo == 6){
        mensaje = '¿Deseas eliminar la condición de suspensión?';
      }

      $('#mensajeEliminacionResol').html(mensaje);
      $('#modalHistory').modal('hide');
      $('#eliminarResolutivos').attr('onclick', `eliminarResolutivo(${id_resolutivo_audiencia}, ${id_audiencia}, ${tipo_resolutivo})`);
      $('#modalEliminar').modal('show');
    }

    function eliminarResolutivo(id_resolutivo_audiencia, id_audiencia, tipo_resolutivo){
      $('#modalEliminar').modal('hide');

      let exito = '';
      let tipo_resolutivo1 = '';
      if(tipo_resolutivo == 1){
        exito = "<p class='mg-b-20 mg-x-20'>Resolutivo eliminado correctamente</p>";
        tipo_resolutivo1 = 'resolutivo';
      }else if(tipo_resolutivo == 2){
        exito = "<p class='mg-b-20 mg-x-20'>Mandamiento eliminado correctamente</p>";
        tipo_resolutivo1 = 'mandamiento';
      }else if(tipo_resolutivo == 3){
        exito = "<p class='mg-b-20 mg-x-20'>Acuerdo Reparatorio eliminado correctamente</p>";
        tipo_resolutivo1 = 'acuerdo_reparatorio';
      }else if(tipo_resolutivo == 4){
        exito = "<p class='mg-b-20 mg-x-20'>Medida Cautelar eliminado correctamente</p>";
        tipo_resolutivo1 = 'medida_cautelar';
      }else if(tipo_resolutivo == 5){
        exito = "<p class='mg-b-20 mg-x-20'>Medida de Protección eliminado correctamente</p>";
        tipo_resolutivo1 = 'medida_proteccion';
      }else if(tipo_resolutivo == 6){
        exito = "<p class='mg-b-20 mg-x-20'>Condición de Suspensión eliminado correctamente</p>";
        tipo_resolutivo1 = 'condicion_suspension';
      }


      $.ajax({
        type:'POST',
        url:'/public/eliminar_audiencias_resolutivos',
        data:{
          "id_audiencia_resolutivo":id_resolutivo_audiencia,
          "id_audiencia":id_audiencia,
          "tipo_resolutivo": tipo_resolutivo1
        },
        success:function(response) {
          body = '';
          if(response.status==100){
            
            $('#modalHistory').modal('hide');
            modal_success(exito,'modalHistory');

            if(tipo_resolutivo == 1){
              obtener_audiencias_resolutivos('',id_audiencia,'primera');
            }else if(tipo_resolutivo == 2){
              obtener_mandamientos('',id_audiencia,'primera');
            }else if(tipo_resolutivo == 3){
              obtener_AcuerdosR('',id_audiencia,'primera');
            }else if(tipo_resolutivo == 4){
              obtener_MedidaC('',id_audiencia,'primera');
            }else if(tipo_resolutivo == 5){
              obtener_MedidaP('',id_audiencia,'primera');
            }else if(tipo_resolutivo == 6){
              obtener_CondicionS('',id_audiencia,'primera');
            }
            
          }else{
           var error = "<p class='mg-b-20 mg-x-20'>"+response.message+"</p>";

           $('#modalHistory').modal('hide');
           modal_error(error,'modalHistory');
          }
        }
       });
    }

    //{{--  Mandamientos  --}}
    function obtener_mandamientos(folio,id_audiencia,pagina_accion){
      //rellenarUnidadDelito(folio,'cmp_unidad_gestion','cmp_delitos');
      //rellenarUnidadDelito(folio,'cmp_unidad_gestion_E','cmp_delitos_E');
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
            "id_audiencia": id_audiencia,
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

                  if(datas[j]['inactividad'] == 1){
                    color = 'green';
                    estado = 'Activo';
                  }else{
                    color= 'red';
                    estado = 'Inactivo';
                  }

                  let permiso = '';
                  if(datas[j]['apertura_resolutivos'] == 1){
                    permiso = `
                      <i class="fas fa-trash-alt acciones2" data-toggle="tooltip-primary" data-placement="top" title="Eliminar mandamiento" style="cursor:pointer; background: #A72424;" onclick="modalEliminar(${datas[j]['id_audiencia_mandamiento_judicial']},${datas[j]['id_audiencia']}, 2)"></i>
                      <i class="fas fa-edit acciones2" data-toggle="tooltip-primary" style="cursor:pointer;" data-placement="top" title="Editar mandamiento" onclick="cargarCamposEditarMandamiento(${datas[j]['id_audiencia_mandamiento_judicial']},${datas[j]['id_audiencia']},${datas[j]['id_solicitud']}, '${datas[j]['fecha_libramiento_orden']}', '${datas[j]['no_carpeta_judicial']}', ${datas[j]['no_oficio']} , '${datas[j]['tipo_orden']}' , '${datas[j]['ids_delitos']}', '${datas[j]['descripcion_orden']}', ${datas[j]['aprobado']} ,${datas[j]['id_unidad_gestion']},${datas[j]['estatus']})"></i>
                      `;
                  }else{
                    permiso = '<span style="color: #CB4335; margin-right:2%">Se ha finalizado la captura</span>';
                  }
  
                  body += `<tr>
                              <td> 
                                ${permiso}
                                <i class="fas fa-file-pdf acciones2" data-toggle="tooltip-primary" style="cursor:pointer;" data-placement="top" title="Ver documento" onclick="verPdf_documento(${datas[j]['id_audiencia_mandamiento_judicial']},${datas[j]['id_audiencia']}, 'mandamientos')"></i>
                              </td>
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
      //$('#cmp_carpeta_judicial').val(folio);
      //$('#cmp_id_audiencia').val(audiencia);

      let datosCarpeta = carpetaActiva;

      let delitos = '<option value="-" diabled>Seleccionar</option>';
      for(i in datosCarpeta.delitos){
        delitos += `<option value="${datosCarpeta.delitos[i].id_delito}">${datosCarpeta.delitos[i].delito}</option>`;
      }


      html = `
        <form action="" id="frm_mandamiento">
          <div class="row">
            <div class="col-md-7">
              <div class="form-group text-left">
                <label class="form-control-label">Tipo de Orden:</label>
                <select class="form-control select2" id="cmp_tipoOrden" name ="cmp_tipoOrden" autocomplete="off">
                  <option value="-">Seleccione un tipo de orden</option>
                  <option value="cateo">Orden de Cateo</option>
                  <option value="aprehension">Orden de Aprehensión</option>
                  <option value="reaprehension">Orden de Reaprehensión</option>
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group text-left">
                <label class="form-control-label">Delitos:</label>
                <select class="form-control select2" id="cmp_delitos" name ="cmp_delitos" autocomplete="off">
                  ${delitos}
                </select>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group text-left">
                <label class="form-control-label">Fecha de libramiento:</label>
                <input type="text" style="text-align:center;" class="form-control calendar" value=""  id="cmp_libramiento" placeholder="Fecha de libramiento" autocomplete="off">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-10">
              <div class="form-group text-left">
                <label class="form-control-label">Unidad de Gestion Judicial:</label>
                <input type="text" style="text-align:center;" readonly data-val="${datosCarpeta.id_unidad}" value="${datosCarpeta.nombre_unidad}" class="form-control"  id="cmp_unidad_gestion" name ="cmp_unidad_gestion" autocomplete="off">
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group text-left">
                <label class="form-control-label">Aprobado:</label>
                <select class="form-control select2" id="cmp_aprobado" name ="cmp_aprobado" autocomplete="off">
                  <option value="-" disabled>Seleccionar</option>
                  <option value="1">Si</option>
                  <option value="0">No</option>
                </select>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="form-group text-left">
                <label class="form-control-label">N° Oficio:</label>
                <div class="form-group">
                  <input type="text" style="text-align:center;" class="form-control"  id="cmp_oficio" placeholder="N° de oficio" autocomplete="off">
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group text-left">
                <label class="form-control-label">N° Carpeta Judicial:</label>
                <div class="form-group">
                  <input type="hidden" id="cmp_id_audiencia" value="${audiencia}">
                  <input type="text" style="text-align:center;" class="form-control"  value="${folio}" id="cmp_carpeta_judicial" placeholder="N° Carpeta Judicial" autocomplete="off" readonly>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group text-left">
                <label class="form-control-label">Id solicitud que derivo de la orden:</label>
                <div class="form-group">
                  <input type="text" style="text-align:center;" class="form-control"  id="cmp_id_solicitud" placeholder="Id Solicitud" autocomplete="off">
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group text-left">
                <label class="form-control-label">Descripcion de la orden:</label>
                <textarea class="form-control" id="cmp_comentarios_mandamiento" rows="3"></textarea>
              </div>
            </div>
          </div>
        </form>

        <div class="row">
          <div class="col-lg-6 d-none" id="col_nombre_documento_mandamiento">
              <div class="form-group">
                <label class="form-control-label">Nombre documento: <span class="tx-danger">*</span> </label>
                <input class="form-control" type="text" id="nombre_documento_mandamiento" name="nombre_documento_mandamiento" autocomplete="off">
              </div>
            </div>
        </div>

        <div class="row" id="row_documento_mandamiento">
              <div class="col-lg-12">
                <form onsubmit="return false;" id="cargarDocumentoMandamiento" action="/" enctype="multipart/form-data">
                  <div class="custom-input-file">
                    <input type="file" id="mandamientoPDF" class="input-file" value="" name="mandamientoPDF" accept=".pdf">
                    <h5 class="px-3 py-3">Arrastre hasta aquí su documento o de clic para adjuntarlo</h5>
                  </div>
                </form>
              </div>
          </div>

        <div class="row" id="divViewDocumentosMandamiento"></div>
      `; 

      $('#bodyMandamiendoJudicial').html(html);

      $('#modalMandamiendoJudicial').modal('show');
      
      setTimeout(function(){
        $('.select2').select2({placeholder: 'Seleccionar'});
        $('.calendar').datepicker({dateFormat:'yy-mm-dd',firstDay: 1}).datepicker("setDate", new Date());

        $("#mandamientoPDF").on('input',function () {
          leeDocumentoMandamiento(this, 'nuevo');
          $('#divViewDocumentosMandamiento').css('display', 'block');
          $('#col_nombre_documento_mandamiento').css('display', 'block');
          $('#col_nombre_documento_mandamiento').css('visibility', 'hidden');
        });
      },600)

    }
    
    function guardarMandamiento(){
      cmp_tipoOrden = $('#cmp_tipoOrden').val();
      cmp_delitos = $('#cmp_delitos').val();
      cmp_unidad_gestion = $('#cmp_unidad_gestion').attr('data-val');
      cmp_oficio = $('#cmp_oficio').val();
      cmp_carpeta_judicial = $('#cmp_carpeta_judicial').val();
      cmp_id_solicitud = $('#cmp_id_solicitud').val();
      cmp_comentarios_mandamiento = $('#cmp_comentarios_mandamiento').val();
      cmp_libramiento = $('#cmp_libramiento').val();
      cmp_id_audiencia = $('#cmp_id_audiencia').val();
      cmp_aprobado = $('#cmp_aprobado').val();
  
      newDA.id_version='-';
      newDA.id_tipo_archivo='-';
      newDA.nombre_archivo=$("#nombre_documento_mandamiento").val();
      newDA.estatus='-';
  
      console.log(newDA);
      
      $.ajax({
        type:'post',
        url:'/public/guardar_mandamiento',
        data:{
          "id_solicitud": carpetaActiva.id_solicitud,
          "id_audiencia":cmp_id_audiencia,
          "folio_carpeta":cmp_carpeta_judicial,
          "no_oficio":cmp_oficio,
          "tipo_orden":cmp_tipoOrden,
          "id_delito":cmp_delitos,
          "descripcion_orden":cmp_comentarios_mandamiento,
          "aprobado":cmp_aprobado,
          "id_unidad_gestion":cmp_unidad_gestion,
          "documento":newDA
        },
        success:function(response) {
          body = '';
          if(response.status==100){
            $('#modalMandamiendoJudicial').modal('hide');
            var exito = "<p class='mg-b-20 mg-x-20'>Mandamiento Agregado Correctamente </p>";
            modal_success(exito,'modalHistory');
            obtener_mandamientos(cmp_carpeta_judicial,cmp_id_audiencia,'primera');
          }else{
            $('#modalMandamiendoJudicial').modal('hide');
            var error = "<p class='mg-b-20 mg-x-20'>"+response.message+"</p>";
            modal_error(error,'modalHistory');
          }
        }
      });
      
    }
  
    function cargarCamposEditarMandamiento(id_audiencia_mandamiento_judicial, id_audiencia, id_solicitud, fecha_libramiento_orden, no_carpeta_judicial, no_oficio, tipo_orden, id_delito, descripcion_orden,aprobado, id_unidad_gestion, estatus){

      let datosCarpeta = carpetaActiva;

      let selected_cmp_tipoOrden_E = '';
      if(tipo_orden == 'cateo'){
        selected_cmp_tipoOrden_E = `
          <option value="-">Seleccione un tipo de orden</option>
          <option selected value="cateo">Orden de Cateo</option>
          <option value="aprehension">Orden de Aprehensión</option>
          <option value="reaprehension">Orden de Reaprehensión</option>
        `;
      }else if(tipo_orden == 'aprehension'){
        selected_cmp_tipoOrden_E = `
          <option value="-">Seleccione un tipo de orden</option>
          <option value="cateo">Orden de Cateo</option>
          <option selected value="aprehension">Orden de Aprehensión</option>
          <option value="reaprehension">Orden de Reaprehensión</option>
        `;
      }else if(tipo_orden == 'reaprehension'){
        selected_cmp_tipoOrden_E = `
          <option value="-">Seleccione un tipo de orden</option>
          <option value="cateo">Orden de Cateo</option>
          <option value="aprehension">Orden de Aprehensión</option>
          <option selected value="reaprehension">Orden de Reaprehensión</option>
        `;
      }

      let delitos = '<option value="-" diabled>Seleccionar</option>';
      for(i in datosCarpeta.delitos){
        delitos += `<option  ${datosCarpeta.delitos[i].id_delito == id_delito ? 'selected' : ''} value="${datosCarpeta.delitos[i].id_delito}">${datosCarpeta.delitos[i].delito}</option>`;
      }

      let estatus1 = '';
      if(estatus == 1){
        estatus1 =`
          <option value="-">Seleccionar</option>
          <option selected value="1">Activo</option>
          <option value="0">Inactivo</option>
        `;
      }else{
        estatus1 =`
          <option value="-">Seleccionar</option>
          <option value="1">Activo</option>
          <option selected value="0">Inactivo</option>
        `;
      }

      let cmp_aprobado_E = '';
      if(aprobado == 1){
        cmp_aprobado_E =`
          <option value="-">Seleccionar</option>
          <option selected value="1">Si</option>
          <option value="0">No</option>
        `;
      }else{
        cmp_aprobado_E =`
          <option value="-">Seleccionar</option>
          <option value="1">Si</option>
          <option selected value="0">No</option>
        `;
      }

      
      var html = `
        <input type="hidden" id="id_audiencia_mandamiento_E" value="${id_audiencia_mandamiento_judicial}">
        <input type="hidden" id="id_audiencia_E" value="${id_audiencia}">

        <div class="row">
          <div class="col-md-6">
            <form action="" id="frm_mandamiento_E">
              <div class="row">
                <div class="col-md-5">
                  <div class="form-group text-left">
                    <label class="form-control-label">Tipo de Orden:</label>
                    <select class="form-control select2" id="cmp_tipoOrden_E" name ="cmp_tipoOrden_E" autocomplete="off">
                      ${selected_cmp_tipoOrden_E}
                    </select>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group text-left">
                    <label class="form-control-label">Delitos:</label>
                    <select class="form-control select2" id="cmp_delitos_E" name ="cmp_delitos_E" autocomplete="off">
                      ${delitos}
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group text-left">
                    <label class="form-control-label">Estatus:</label>
                    <select class="form-control select2" id="cmp_estatus_E" name ="cmp_estatus_E" autocomplete="off">
                      ${estatus1}
                    </select>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group text-left">
                    <label class="form-control-label">Unidad de Gestion Judicial:</label>
                    <input type="text" style="text-align:center;" readonly data-val="${id_unidad_gestion}" value="${datosCarpeta.nombre_unidad}" class="form-control"  id="cmp_unidad_gestion_E" name ="cmp_unidad_gestion_E" autocomplete="off">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group text-left">
                    <label class="form-control-label">Fecha de libramiento:</label>
                    <input type="text" style="text-align:center;" class="form-control cal" value="${fecha_libramiento_orden}" id="cmp_libramiento_E" placeholder="Fecha de libramiento" autocomplete="off">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group text-left">
                    <label class="form-control-label">Aprobado:</label>
                    <select class="form-control select2" id="cmp_aprobado_E" name="cmp_aprobado_E" autocomplete="off">
                      ${cmp_aprobado_E}
                    </select>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-4">
                  <div class="form-group text-left">
                    <label class="form-control-label">N° Oficio:</label>
                    <div class="form-group">
                      <input type="text" style="text-align:center;" class="form-control" value="${no_oficio}" id="cmp_oficio_E" placeholder="N° de oficio" autocomplete="off">
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group text-left">
                    <label class="form-control-label">N° Carpeta Judicial:</label>
                    <div class="form-group">
                      <input type="text" style="text-align:center;" class="form-control" value="${no_carpeta_judicial}" id="cmp_carpeta_judicial_E" placeholder="N° Carpeta Judicial" autocomplete="off" readonly>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group text-left">
                    <label class="form-control-label">Id solicitud que derivo de la orden:</label>
                    <div class="form-group">
                      <input type="text" style="text-align:center;" class="form-control" value="${id_solicitud}" id="cmp_id_solicitud_E" placeholder="Id Solicitud" autocomplete="off" readonly>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <div class="form-group text-left">
                    <label class="form-control-label">Descripcion de la orden:</label>
                    <textarea class="form-control" value="${descripcion_orden}" id="cmp_comentarios_mandamiento_E" rows="3">${descripcion_orden}</textarea>
                  </div>
                </div>
              </div>
            </form>
            <div class="row">
              <div class="col-lg-6 d-none" id="col_nombre_documento_mandamiento_E">
                  <div class="form-group">
                    <label class="form-control-label">Nombre documento: <span class="tx-danger">*</span> </label>
                    <input class="form-control" type="text" id="nombre_documento_mandamiento_E" name="nombre_documento_mandamiento_E" autocomplete="off">
                  </div>
                </div>
            </div>

            <div class="row" id="row_documento_mandamiento_E">
              <div class="col-lg-12">
                <form onsubmit="return false;" id="cargarDocumentoAcurdo_E" action="/" enctype="multipart/form-data">
                  <div class="custom-input-file">
                    <input type="file" id="mandamientoPDF_E" class="input-file" value="" name="mandamientoPDF_E" accept=".pdf">
                    <h5 class="px-3 py-3">Arrastre hasta aquí su documento o de clic para adjuntarlo</h5>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="row" id="divViewDocumentosMandamiento_E" style="height: 100%; width:100%;"></div>
          </div>
        </div>
      `;
        

      $('#bodyMandamiendoJudicialEdit').html(html);
      $('#modalMandamiendoJudicialEdit').modal('show');
      $('#modalHistory').modal('hide');

      setTimeout(function(){
        $('.select2').select2({placeholder: 'Seleccionar'});
        $('.calendar').datepicker({dateFormat:'yy-mm-dd',firstDay: 1}).datepicker("setDate", new Date());

        let fecha_actual = new Date();
        $('.cal').datepicker({
          showOtherMonths: true,
          selectOtherMonths: true,
          dateFormat: 'yy-mm-dd',
          changeYear: true,
          yearRange: "c-100:" + (fecha_actual.getFullYear() + 5)
        });
        //$('.cal').datepicker({dateFormat: 'yy-mm-dd'});

        $("#mandamientoPDF_E").on('input',function () {
          leeDocumentoMandamiento(this, 'edit');
          $('#divViewDocumentosMandamiento_E').css('display', 'block');
          $('#col_nombre_documento_mandamiento_E').css('display', 'block');
          $('#col_nombre_documento_mandamiento_E').css('visibility', 'hidden');
        });

        $.ajax({
          type:'GET',
          url:'/public/obtener_documento_resolutivo',
          data:{
            id_audiencia:id_audiencia,
            id_acuerdo:id_audiencia_mandamiento_judicial,
            tipo:'mandamientos'
          },
          success:function(response) {
            if(response.status ==100){
              console.log(response.response);
  
              pdf = `<embed src="${response.response}" type="application/pdf" width="100%" height="100%" />`;
              $('#divViewDocumentosMandamiento_E').html(pdf);
            }else{
              pdf = `<div style="height: 600px; width:100%; background: #444;display: flex;justify-content: center;align-items: center;flex-direction: column;font-size: 1.2em;;">
                <i class="fa fa-file-pdf" style="color: #fff;font-size: 1.1em;margin-right: 3%;margin-bottom: 2%;font-size: 4em;"></i>
                Sin Documento PDF
              </div>`;
  
              $('#divViewDocumentosMandamiento_E').html(pdf);
            }
          }
        });

      },600)
    }
  
    function actualizar_mandamientos(){
      id_audiencia_mandamiento = $('#id_audiencia_mandamiento_E').val();
      cmp_id_audiencia = $('#id_audiencia_E').val();
      cmp_tipoOrden = $('#cmp_tipoOrden_E').val();
      cmp_delitos = $('#cmp_delitos_E').val();
      cmp_unidad_gestion = $('#cmp_unidad_gestion_E').attr('data-val');
      cmp_oficio = $('#cmp_oficio_E').val();
      cmp_carpeta_judicial = $('#cmp_carpeta_judicial_E').val();
      cmp_id_solicitud = $('#cmp_id_solicitud_E').val();
      cmp_comentarios_mandamiento = $('#cmp_comentarios_mandamiento_E').val();
      cmp_libramiento = $('#cmp_libramiento_E').val();
      cmp_status = $('#cmp_estatus_E').val();
      cmp_aprobado = $('#cmp_aprobado_E').val();

      newDA.id_version='-';
      newDA.id_tipo_archivo='-';
      newDA.nombre_archivo=$("#nombre_documento_mandamiento_E").val();
      newDA.estatus='-';

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
          "aprobado":cmp_aprobado,
          "estatus":cmp_status,
          "documento":newDA
        },
        success:function(response) {
          body = '';
          if(response.status==100){
            $('#modalMandamiendoJudicialEdit').modal('hide');
            var exito = "<p class='mg-b-20 mg-x-20'>El Mandamiento fue actualizado </p>";
            modal_success(exito,'modalHistory');
            obtener_mandamientos(cmp_carpeta_judicial,cmp_id_audiencia,'primera');
          }else{
            $('#modalMandamiendoJudicialEdit').modal('hide');
            var error = "<p class='mg-b-20 mg-x-20'>"+response.message+"</p>";
            modal_error(error,'modalHistory');
          }
        }
      });
      
    }
  
    function leeDocumentoMandamiento(input, accion) {
      let acepted_files=["pdf","png","jpg","docx","doc"];
  
      let modal = 'nuevo' ?  'modalMandamiendoJudicial': 'modalMandamiendoJudicialEdit';
      let file = accion == 'nuevo' ? $('#mandamientoPDF').val() : $('#mandamientoPDF_E').val();
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
            modal_error('Solo puede adjutar archivos PDF, PNG, JPG, DOC o DOCX',modal);
            $('#mandamientoPDF').val('');
            $('#mandamientoPDF_E').val();
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
            setTimeout(function(){ pintar_documento_mandamiento(accion); },500);
          }
        }
      }else{
        return false;
      }
    }
  
    function pintar_documento_mandamiento(accion){
      if(accion == 'nuevo'){
        $('#divViewDocumentosMandamiento div').remove();
        
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

      }else if(accion == 'edit'){
        $('#divViewDocumentosMandamiento_E').html('');
        
        let reader_files=["pdf","png","jpg"];
    
        documento = newDA;
    
        if ( reader_files.includes(documento.extension_archivo) ) { 
          $('#divViewDocumentosMandamiento_E').append(`
            <div class="col-lg-12" align="center" style="height:100%;">
              <object style="height:100%;" ${ documento.extension_archivo=="pdf"?'width="100%"' : ''} class="mg-t-25" data="${documento.tipo_data+documento.b64}"></object>
            </div>
          `);    
        }else{
          $('#divViewDocumentosMandamiento_E').append(`
            <div class="col-lg-12" align="center">
              ${getIcon(documento.extension_archivo)}
            </div>
          `);
        }
    
        $("#nombre_documento_mandamiento_E").val( documento.nombre_archivo );  
    
        $("#col_nombre_documento_mandamiento_E").removeClass('d-none');
        $("#col_nombre_documento_mandamiento_E").focus();
      }
    }



    //{{--  Acuerdos Reparatorios  --}}
    
    function obtener_AcuerdosR(folio,id_audiencia,pagina_accion){
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
              "id_audiencia": id_audiencia,
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
                    if(datas[j]['inactividad'] == 1){
                      color = 'green';
                      estado = 'Activo';
                    }else{
                      color= 'red';
                      estado = 'Inactivo';
                    }

                    
                  let permiso = '';
                  if(datas[j]['apertura_resolutivos'] == 1){
                    permiso = `
                    <i class="fas fa-trash-alt acciones2" data-toggle="tooltip-primary" data-placement="top" title="Eliminar resolutivo" style="cursor:pointer; background: #A72424;" onclick="modalEliminar(${datas[j]['id_audiencia_acuerdo_reparatorio']},${datas[j]['id_audiencia']}, 3)"></i>
                    <i class="fas fa-edit acciones2" data-toggle="tooltip-primary" style="cursor:pointer;" data-placement="top" title="Editar resolutivo" onclick="editarAcuerdoR(${datas[j]['id_audiencia_acuerdo_reparatorio']},${datas[j]['id_audiencia']},'${datas[j]['folio_carpeta']}', ${datas[j]['id_imputado']}, '${datas[j]['tipo_cumplimiento']}', '${datas[j]['aprueba_acuerdo']}' , '${datas[j]['fecha_extincion']}' , '${datas[j]['resumen_acuerdo']}', ${datas[j]['estatus']},  '${datas[j]['comentarios_adicionales']}')"></i>
                    `;
                  }else{
                    permiso = '<span style="color: #CB4335; margin-right:2%">Se ha finalizado la captura</span>';
                  }
    
                    body += `<tr>
                                <td> 
                                  ${permiso}
                                  <i class="fas fa-file-pdf acciones2" data-toggle="tooltip-primary" style="cursor:pointer;" data-placement="top" title="Ver documento" onclick="verPdf_documento(${datas[j]['id_audiencia_acuerdo_reparatorio']},${datas[j]['id_audiencia']}, 'acuerdo_reparatorio')"></i>
                                </td> 
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
      let datosCarpeta = carpetaActiva;

      let imputados = '<option value="-" diabled>Seleccionar</option>';
      for(i in datosCarpeta.imputados){
        imputados += `<option value="${datosCarpeta.imputados[i].id_persona}">${ datosCarpeta.imputados[i].tipo == 'fisica' ? datosCarpeta.imputados[i].nombre : datosCarpeta.imputados[i].razon_social}</option>`;
      }

      let html = `
        <div class="col-md-12">
          <form action="" id="frm_add_AcuerdoR">
            <input type="hidden" id="CarpetaF" value="${folio}">
            <input type="hidden" id="cmp_id_audiencia_AR" value="${id_audiencia}">

              <div class="form-group text-left">
                  <label>Imputado:</label>
                  <select class="form-control select2" id="cmp_imputado_AR" name="cmp_imputado_AR" >
                    ${imputados}
                  </select>
              </div>

              <div class="form-group text-left">
                  <label>Resumen del Acuerdo:</label>
                  <textarea class="form-control" id="cmp_resumenAcuerdo_AR" rows="3"></textarea>
              </div>

              <div class="row">
                <div class="col-md-4">
                  <div class="form-group text-left">
                  <label for="cmp_tipoCumplimiento_AR" class="col-sm-12 col-form-label">Tipo de Cumplimiento:</label>
                  <div class="col-sm-12">
                    <select class="form-control select2" id="cmp_tipoCumplimiento_AR" name="cmp_tipoCumplimiento_AR">
                      <option value="-" diabled>Seleccionar</option>
                      <option value="Inmediato">Inmediato</option>
                      <option value="Diferido">Diferido</option>
                    </select>
                  </div>
                </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group text-left">
                  <label for="cmp_apruebaAcuerdo_AR" class="col-sm-12 col-form-label">¿Se aprueba el acuerdo?</label>
                  <div class="col-sm-12">
                    <select class="form-control select2" id="cmp_apruebaAcuerdo_AR" name="cmp_apruebaAcuerdo_AR">
                      <option value="-" diabled>Seleccionar</option>
                      <option value="No">No</option>
                      <option value="Si">Si</option>
                    </select>
                  </div>
                </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group text-left">
                  <label for="cmp_fehcaExtincion_AR" class="col-sm-12 col-form-label">Fecha de extincion de accion penal</label>
                  <div class="col-sm-12">
                    <input type="text" class="form-control cal"  id="cmp_fehcaExtincion_AR" name="cmp_fehcaExtincion_AR">
                  </div>
                </div>
                </div>
              </div>

              <div class="form-group text-left">
                  <label>Comentarios Adicionales:</label>
                  <textarea class="form-control" id="cmp_comentariosAdicionales_AR" rows="3"></textarea>
              </div>

              <div class="row">
                <div class="col-lg-6 d-none" id="col_nombre_documento_acuerdo">
                    <div class="form-group">
                      <label class="form-control-label">Nombre documento: <span class="tx-danger">*</span> </label>
                      <input class="form-control" type="text" id="nombre_documento_acuerdo" name="nombre_documento_acuerdo" autocomplete="off">
                    </div>
                  </div>
              </div>

              <div class="row" id="row_documento_acuerdo">
                    <div class="col-lg-12">
                      <form onsubmit="return false;" id="cargarDocumentoAcurdo" action="/" enctype="multipart/form-data">
                        <div class="custom-input-file">
                          <input type="file" id="acuerdoPDF" class="input-file" value="" name="acuerdoPDF" accept=".pdf">
                          <h5 class="px-3 py-3">Arrastre hasta aquí su documento o de clic para adjuntarlo</h5>
                        </div>
                      </form>
                    </div>
                </div>

              </form>
              <div class="row" id="divViewDocumentosAcuerdo"></div>

        </div>
      `;

      $('#modalHistory').modal('hide');
      $('#bodyAcuerdoR').html(html);
      $('#modalAcuerdoR').modal('show');
      
      setTimeout(function(){
        $('.select2').select2({placeholder: 'Seleccionar'});
        $('.calendar').datepicker({dateFormat:'yy-mm-dd',firstDay: 1}).datepicker("setDate", new Date());
        let fecha_actual = new Date();
        $('.cal').datepicker({
          showOtherMonths: true,
          selectOtherMonths: true,
          dateFormat: 'yy-mm-dd',
          changeYear: true,
          yearRange: "c-100:" + (fecha_actual.getFullYear() + 5)
        });

        $("#acuerdoPDF").on('input',function () {
          leeDocumentoAcuerdoR(this, 'nuevo');
          $('#divViewDocumentosAcuerdo').css('display', 'block');
          $('#col_nombre_documento_acuerdo').css('display', 'block');
          $('#col_nombre_documento_acuerdo').css('visibility', 'hidden');
        });
      },600)
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

      if(newDA == null){
        newDA = [];
      }else{
        newDA.id_version='-';
        newDA.id_tipo_archivo='-';
        newDA.nombre_archivo=$("#nombre_documento_acuerdo").val();
        newDA.estatus='-';
      }

      var data={
        "carpeta_judicial": CarpetaF,
        "id_solicitud":carpetaActiva.id_solicitud,
        "id_audiencia":cmp_id_audiencia_AR,
        "id_imputado":cmp_imputado_AR,
        "resumen_acuerdo":cmp_resumenAcuerdo_AR,
        "tipo_cumplimiento":cmp_tipoCumplimiento_AR,
        "aprueba_acuerdo":cmp_apruebaAcuerdo_AR,
        "fecha_extincion":cmp_fehcaExtincion_AR,
        "comentarios_adicionales":cmp_comentariosAdicionales_AR,
        "documento":newDA
      };

      console.log(data);

      $.ajax({
        type:'post',
        url:'/public/guardarAcuerdoR',
        data:{
          "carpeta_judicial": CarpetaF,
          "id_solicitud":carpetaActiva.id_solicitud,
          "id_audiencia":cmp_id_audiencia_AR,
          "id_imputado":cmp_imputado_AR,
          "resumen_acuerdo":cmp_resumenAcuerdo_AR,
          "tipo_cumplimiento":cmp_tipoCumplimiento_AR,
          "aprueba_acuerdo":cmp_apruebaAcuerdo_AR,
          "fecha_extincion":cmp_fehcaExtincion_AR,
          "comentarios_adicionales":cmp_comentariosAdicionales_AR,
          "documento":newDA
        },
        success:function(response) {
          body = '';
          if(response.status==100){
            $('#modalAcuerdoR').modal('hide');
            var exito = "<p class='mg-b-20 mg-x-20'>El Acuerdo reparatorio fue agregado </p>";
            modal_success(exito,'modalHistory');
            obtener_AcuerdosR(CarpetaF,cmp_id_audiencia_AR,'primera');
            resetform();
          }else{
            $('#modalAcuerdoR').modal('hide');
            var error = "<p class='mg-b-20 mg-x-20'>"+response.message+"</p>";
            modal_error(error,'modalHistory');
          }
        }
      });
    }
    
    function editarAcuerdoR(id_acuerdoR,id_audiencia,carpeta_judicial,id_imputado, tipoC, acuerdoA, fechaEx, resumenA, estatus, comentariosA){
      
      let datosCarpeta = carpetaActiva;
      
      let imputados = '<option value="-" diabled>Seleccionar</option>';
      for(i in datosCarpeta.imputados){
        imputados += `<option  ${datosCarpeta.imputados[i].id_persona == id_imputado ? 'selected' : ''} value="${datosCarpeta.imputados[i].id_persona}">${ datosCarpeta.imputados[i].tipo == 'fisica' ? datosCarpeta.imputados[i].nombre : datosCarpeta.imputados[i].razon_social}</option>`;
      }

      let estatus1 = '';
      if(estatus == 1){
        estatus1 =`
          <option value="-">Seleccionar</option>
          <option selected value="1">Activo</option>
          <option value="0">Inactivo</option>
        `;
      }else{
        estatus1 =`
          <option value="-">Seleccionar</option>
          <option value="1">Activo</option>
          <option selected value="0">Inactivo</option>
        `;
      }

      let cmp_tipoCumplimiento_AR_E = '';
      if(tipoC == 'Inmediato'){
        cmp_tipoCumplimiento_AR_E =`
          <option value="-">Seleccionar</option>
          <option selected value="Inmediato">Inmediato</option>
          <option value="Diferido">Diferido</option>
        `;
      }else{
        cmp_tipoCumplimiento_AR_E =`
          <option value="-">Seleccionar</option>
          <option value="Inmediato">Inmediato</option>
          <option selected value="Diferido">Diferido</option>
        `;
      }


      let cmp_apruebaAcuerdo_AR_E = '';
      if(acuerdoA == 'No'){
        cmp_apruebaAcuerdo_AR_E =`
          <option value="-">Seleccionar</option>
          <option selected value="No">No</option>
          <option value="Si">Si</option>
        `;
      }else{
        cmp_apruebaAcuerdo_AR_E =`
          <option value="-">Seleccionar</option>
          <option value="No">No</option>
          <option selected value="Si">Si</option>
        `;
      }

      let html = `
        <input type="hidden" id="CarpetaF_E" value="${carpeta_judicial}">
        <input type="hidden" id="cmp_AcuerdoF_id_audiencia_E" value="${id_audiencia}">
        <input type="hidden" id="cmp_id_audiencia_AR_E" value="${id_acuerdoR}">

        <div class="row">
          <div class="col-md-6">
              <div class="row">
                  <div class="col-sm-12 col-md-8 col-lg-8">
                    <div class="form-group text-left">
                        <label>Imputado:</label>
                        <select class="form-control select2" id="cmp_imputado_AR_E" name="cmp_imputado_AR_E" >
                          ${imputados}
                        </select>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-4 col-lg-4">
                    <div class="form-group text-left">
                        <label>Estatus:</label>
                        <select class="form-control select2" id="cmp_estatus_AR_E" name="cmp_estatus_AR_E">
                          ${estatus1}
                        </select>
                    </div>
                  </div>
              </div>

                <div class="form-group text-left">
                    <label>Resumen del Acuerdo:</label>
                    <textarea class="form-control" value="${resumenA}" id="cmp_resumenAcuerdo_AR_E" rows="3">${resumenA}</textarea>
                </div>

                <div class="row">
                  <div class="col-sm-12 col-md-4 col-lg-4">
                    <div class="form-group text-left">
                      <label for="cmp_tipoCumplimiento_AR" class="col-sm-12 col-form-label">Tipo de Cumplimiento:</label>
                      <div class="col-sm-12">
                          <select class="form-control select2" id="cmp_tipoCumplimiento_AR_E" name="cmp_tipoCumplimiento_AR_E">
                            ${cmp_tipoCumplimiento_AR_E}
                          </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-4 col-lg-4">
                    <div class="form-group text-left">
                      <label for="cmp_apruebaAcuerdo_AR" class="col-sm-12 col-form-label">¿Se aprueba el acuerdo?</label>
                      <div class="col-sm-12">
                          <select class="form-control select2" id="cmp_apruebaAcuerdo_AR_E" name="cmp_apruebaAcuerdo_AR_E">
                            ${cmp_apruebaAcuerdo_AR_E}
                          </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-4 col-lg-4">
                    <div class="form-group text-left">
                    <label for="cmp_fehcaExtincion_AR" class="col-sm-12 col-form-label">Fecha de extincion de accion penal</label>
                    <div class="col-sm-12">
                      <input type="text" class="form-control cal" value="${fechaEx}" id="cmp_fehcaExtincion_AR_E" name="cmp_fehcaExtincion_AR_E">
                    </div>
                  </div>
                  </div>
                </div>

                <div class="form-group text-left">
                    <label>Comentarios Adicionales:</label>
                    <textarea class="form-control" value="${comentariosA}" id="cmp_comentariosAdicionales_AR_E" rows="3">${comentariosA}</textarea>
                </div>

                <div class="row">
                  <div class="col-lg-6 d-none" id="col_nombre_documento_acuerdo_E">
                      <div class="form-group">
                        <label class="form-control-label">Nombre documento: <span class="tx-danger">*</span> </label>
                        <input class="form-control" type="text" id="nombre_documento_acuerdo_E" name="nombre_documento_acuerdo_E" autocomplete="off">
                      </div>
                    </div>
                </div>

                <div class="row" id="row_documento_acuerdo_E">
                      <div class="col-lg-12">
                        <form onsubmit="return false;" id="cargarDocumentoAcurdo_E" action="/" enctype="multipart/form-data">
                          <div class="custom-input-file">
                            <input type="file" id="acuerdoPDF_E" class="input-file" value="" name="acuerdoPDF_E" accept=".pdf">
                            <h5 class="px-3 py-3">Arrastre hasta aquí su documento o de clic para adjuntarlo</h5>
                          </div>
                        </form>
                      </div>
                </div>

          </div>

          <div class="col-md-6">
            <div class="row" id="divViewDocumentosAcuerdo_E" style="height: 100%; width:100%;"></div>
          </div>

        </div>
      `;

      $('#modalHistory').modal('hide');
      $('#bodyAcuerdoR_E').html(html)
      $('#modalAcuerdoR_E').modal('show');

      setTimeout(function(){
        $('.select2').select2({placeholder: 'Seleccionar'});
        $('.calendar').datepicker({dateFormat:'yy-mm-dd',firstDay: 1}).datepicker("setDate", new Date());
        let fecha_actual = new Date();
        $('.cal').datepicker({
          showOtherMonths: true,
          selectOtherMonths: true,
          dateFormat: 'yy-mm-dd',
          changeYear: true,
          yearRange: "c-100:" + (fecha_actual.getFullYear() + 5)
        });

        $("#acuerdoPDF_E").on('input',function () {
          leeDocumentoAcuerdoR(this, 'edit');
          $('#divViewDocumentosAcuerdo_E').css('display', 'block');
          $('#col_nombre_documento_acuerdo_E').css('display', 'block');
          $('#col_nombre_documento_acuerdo_E').css('visibility', 'hidden');
        });

        $.ajax({
          type:'GET',
          url:'/public/obtener_documento_resolutivo',
          data:{
            id_audiencia:id_audiencia,
            id_acuerdo:id_acuerdoR,
            tipo:'acuerdo_reparatorio'
          },
          success:function(response) {
            if(response.status ==100){
              console.log(response.response);
    
              pdf = `<embed src="${response.response}" type="application/pdf" width="100%" height="100%" />`;
              $('#divViewDocumentosAcuerdo_E').html(pdf);
            }else{
              pdf = `<div style="height: 600px;background: #444;display: flex;justify-content: center;align-items: center;flex-direction: column;font-size: 1.2em;;">
                <i class="fa fa-file-pdf" style="color: #fff;font-size: 1.1em;margin-right: 3%;margin-bottom: 2%;font-size: 4em;"></i>
                Sin Documento PDF
              </div>`;
    
              $('#divViewDocumentosAcuerdo_E').html(pdf);
            }
          }
        });

      },600)

    }
    
    function actualizar_AcuerdoR(){
      id_audiencia = $('#cmp_AcuerdoF_id_audiencia_E').val();
      id_acuerdoR = $('#cmp_id_audiencia_AR_E').val();
      carpeta_judicial = $('#CarpetaF_E').val();
    
      impuatdo = $('#cmp_imputado_AR_E').val();
      tipoC = $('#cmp_tipoCumplimiento_AR_E').val();
      acuerdoA = $('#cmp_apruebaAcuerdo_AR_E').val();
      fechaEx = $('#cmp_fehcaExtincion_AR_E').val();
      resumenA = $('#cmp_resumenAcuerdo_AR_E').val();
      status = $('#cmp_estatus_AR_E').val();
      comentariosA = $('#cmp_comentariosAdicionales_AR_E').val();

      if(newDA == null){
        newDA = [];
      }else{
        newDA.id_version='-';
        newDA.id_tipo_archivo='-';
        newDA.nombre_archivo=$("#nombre_documento_acuerdo_E").val();
        newDA.estatus='-';
      }

      var data={
        "id_audiencia_acuerdo_reparatorio":id_acuerdoR,
        "carpeta_judicial": carpeta_judicial,
        "id_audiencia":id_audiencia,
        "id_imputado":impuatdo,
        "resumen_acuerdo":resumenA,
        "tipo_cumplimiento":tipoC,
        "aprueba_acuerdo":acuerdoA,
        "fecha_extincion":fechaEx,
        "comentarios_adicionales":comentariosA,
        "estatus":status,
        "documento":newDA
      };

      console.log(data);

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
          "estatus":status,
          "documento":newDA
        },
        success:function(response) {
          body = '';
          if(response.status==100){
            $('#modalAcuerdoR_E').modal('hide');
            var exito = "<p class='mg-b-20 mg-x-20'>Acuerdo reparatorio actualizado correctamente</p>";
            modal_success(exito,'modalHistory');
            obtener_AcuerdosR(carpeta_judicial,id_audiencia,'primera');
          }else{
            $('#modalAcuerdoR_E').modal('hide');
            var error = "<p class='mg-b-20 mg-x-20'>"+response.message+"</p>";
            modal_error(error,'modalHistory');
          }
        }
      });
    }
    
    function leeDocumentoAcuerdoR (input, accion) {
        let acepted_files=["pdf","png","jpg","docx","doc"];


        let modal = 'nuevo' ?  'modalAcuerdoR': 'modalAcuerdoR_E';
        let file = accion == 'nuevo' ? $('#acuerdoPDF').val() : $('#acuerdoPDF_E').val();
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
              modal_error('Solo puede adjutar archivos PDF, PNG, JPG, DOC o DOCX',modal);
              $('#acuerdoPDF').val('');
              $('#acuerdoPDF_E').val('');
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
              setTimeout(function(){ pintar_documento_acuerdoR(accion); },500);
            }
          }
        }else{
          return false;
        }
    }
    
    function pintar_documento_acuerdoR(accion){
      if(accion == 'nuevo'){
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
      }else if(accion == 'edit'){
        $('#divViewDocumentosAcuerdo_E').html('');
        
        let reader_files=["pdf","png","jpg"];
    
        documento = newDA;
    
        if ( reader_files.includes(documento.extension_archivo) ) { 
          $('#divViewDocumentosAcuerdo_E').append(`
            <div class="col-lg-12" align="center" style="height:100%;">
              <object style="height:100%;" ${ documento.extension_archivo=="pdf"?'width="100%"' : ''} class="mg-t-25" data="${documento.tipo_data+documento.b64}"></object>
            </div>
          `);    
        }else{
          $('#divViewDocumentosAcuerdo_E').append(`
            <div class="col-lg-12" align="center">
              ${getIcon(documento.extension_archivo)}
            </div>
          `);
        }
    
        $("#nombre_documento_acuerdo_E").val( documento.nombre_archivo );  
        $("#col_nombre_documento_acuerdo_E").removeClass('d-none');
        $("#col_nombre_documento_acuerdo_E").focus();
      }
    }
  
    //{{--  Medidas Cautelares  --}}
    
    function obtener_MedidaC(folio,id_audiencia,pagina_accion){
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
                "id_audiencia": id_audiencia,
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
                      if(datas[j]['inactividad'] == 1){
                        color = 'green';
                        estado = 'Activo';
                      }else{
                        color= 'red';
                        estado = 'Inactivo';
                      }

                      let permiso = '';
                      if(datas[j]['apertura_resolutivos'] == 1){
                        permiso = `
                          <i class="fas fa-trash-alt acciones2" data-toggle="tooltip-primary" data-placement="top" title="Eliminar resolutivo" style="cursor:pointer; background: #A72424;" onclick="modalEliminar(${datas[j]['id_audiencia_medida_cautelar']},${datas[j]['id_audiencia']}, 4)"></i>
                          <i class="fas fa-edit acciones2"  style="cursor:pointer;" data-toggle="tooltip-primary" data-placement="top" title="Editar resolutivo" onclick="cargarCamposEditarMedidaC(${datas[j]['id_audiencia_medida_cautelar']},${datas[j]['id_audiencia']},'${datas[j]['folio_carpeta']}', ${datas[j]['tipo_resultado']}, ${datas[j]['id_imputado']}, ${datas[j]['id_medida_cautelar']} , '${datas[j]['especificaciones_medida_cautelar']}' , '${datas[j]['autoridad_presentarse']}', ${datas[j]['monto_garantia']},  ${datas[j]['no_pagos']}, ${datas[j]['estatus']},'${datas[j]['fecha_inicio']}','${datas[j]['fecha_fin']}', ${datas[j]['estado_medida']})"></i>
                        `;
                      }else{
                        permiso = '<span style="color: #CB4335; margin-right:2%">Se ha finalizado la captura</span>';
                      }
    
                      body += `<tr>
                                  <td> ${permiso}</td> 
                                  <td> ${datas[j]['imputado']}            </td>
                                  <td> ${datas[j]['descripcion']}   </td> 
                                  <td> ${datas[j]['especificaciones_medida_cautelar'] ?? ""} </td>
                                  <td> ${datas[j]['fecha_inicio'] ?? ""} </td>
                                  <td> ${datas[j]['fecha_fin'] ?? ""} </td>
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
    
    function agregarMedidaC(folio,id_audiencia){
      let datosCarpeta = carpetaActiva;

      let imputados = '<option value="-" diabled>Seleccionar</option>';
      for(i in datosCarpeta.imputados){
        imputados += `<option value="${datosCarpeta.imputados[i].id_persona}">${ datosCarpeta.imputados[i].tipo == 'fisica' ? datosCarpeta.imputados[i].nombre : datosCarpeta.imputados[i].razon_social}</option>`;
      }

      var html = `
        <div class="row">
          <div class="col-lg-12">
          <form action="" id="frm_medidasC">
            <input type="hidden" id="cmp_medidaC_folioC" value="${folio}">
            <input type="hidden" id="cmp_medidaC_id_audiencia" value="${id_audiencia}">

            <div class="row">
              <div class="col-md-4">
                <div class="form-group text-left">
                  <label class="form-control-label">Imputado:</label>
                  <select class="form-control select2" id="cmp_medidaC_imputado" name ="cmp_medidaC_imputado" autocomplete="off">
                    ${imputados}
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group text-left">
                  <label class="form-control-label">Fecha Inicio:</label>
                  <input type="text" id="cmp_medidaC_fecha_inicio" name="cmp_medidaC_fecha_inicio" class="form-control date_fif cal">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group text-left">
                  <label class="form-control-label">Fecha fin:</label>
                  <input type="text" id="cmp_medidaC_fecha_fin" name="cmp_medidaC_fecha_fin" class="form-control date_fif cal">
                </div>
              </div>

            </div>

            <div class="row">
              <div class="col-md-8">
                <div class="form-group text-left">
                  <label class="form-control-label">Medida Cautelar:</label>
                  <select class="form-control select2" id="cmp_medidaC_medida" name ="cmp_medidaC_medida" autocomplete="off" onchange="elegir_menu_cautelar(this)">
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group text-left">
                  <label class="form-control-label">Estado de la medida cautelar:</label>
                  <select class="form-control select2" id="cmp_medidaC_estado_medida" name="cmp_medidaC_estado_medida" autocomplete="off">
                    <option selected value="-">Seleccionar</option>
                    <option value="1">Impuesta</option>
                    <option value="2">Revocada</option>
                  </select>
                </div>
              </div>
            </div>

            <div id="medidaC_menu1" style="display: none;">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group text-left">
                    <label class="form-control-label">Monto de la Garantia:</label>
                    <div class="form-group">
                      <input type="text" style="text-align:center;" class="form-control"  id="cmp_medidaC_garantia" placeholder="monto de la garantia"  autocomplete="off">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group text-left">
                    <label class="form-control-label">Numero de pagos:</label>
                    <div class="form-group">
                      <input type="number"  style="text-align:center;" class="form-control"  id="cmp_medidaC_pagos" placeholder="numero de pagos" autocomplete="off">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div id="medidaC_menu2" style="display: none;">
              <div class="form-group text-left">
                <label class="form-control-label">Autoridad a la que debe presentarse:</label>
                <select class="form-control select2" id="cmp_medidaC_autoridad" name ="cmp_medidaC_autoridad" autocomplete="off">
                  <option value="-">Seleccione una autoridad</option>
                  <option value="UMECA">UMECA</option>
                  <option value="Juez">Juez</option>
                  <option value="Otro">Otro</option>
                </select>
              </div>
            </div>

            <div class="form-group text-left">
              <label class="form-control-label">Especificaciones:</label>
              <textarea disabled class="form-control" id="cmp_medidaC_comentarios" rows="3"></textarea>
            </div>

          </form>

          </div>
        </div>
      `;

      $('#modalHistory').modal('hide');
      $('#bodyMedidasCautelares').html(html);
      $('#modalMedidasCautelares').modal('show');

      setTimeout(function(){
        $('.select2').select2({placeholder: 'Seleccionar'});
        $('.calendar').datepicker({dateFormat:'yy-mm-dd',firstDay: 1}).datepicker("setDate", new Date());
        let fecha_actual = new Date();
        $('.cal').datepicker({
          showOtherMonths: true,
          selectOtherMonths: true,
          dateFormat: 'yy-mm-dd',
          changeYear: true,
          yearRange: "c-100:" + (fecha_actual.getFullYear() + 5)
        });

        $('#cmp_medidaC_estado_medida').change(function(){
          if($(this).val() == 1){
            $('#cmp_medidaC_comentarios').prop('disabled', false);
          }else{
            $('#cmp_medidaC_comentarios').prop('disabled', true);
          }
        });

        $.ajax({
          type:'post',
          url:'/public/obtener_MedidasCautelares',
          data:{
          },
          success:function(response) {
            body = '';
            if(response.status==100){
                var datas = response.response;
                //console.log(datas);
                body='<option value="">Seleccione Medida Cautelar</option>';
                for (var j = 0; j < datas.length; j++) {
                  body += `<option value="${datas[j]['id_medida_c']}" data-tipo="${datas[j]['es_sancion_economica']}">${datas[j]['tipo_medida_cautelar']}</option>`;
                }
              $("#cmp_medidaC_medida").html(body);
      
            }else{
              body = body.concat('<option value="-">Seleccione un resolutivo</option>');
              $("#cmp_medidaC_medida").html(body);
      
            }
          }
        });

      },600)
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
      medidaCa = $('select[name="cmp_medidaC_medida"] option:selected').text();
      tipo_cautelar = $('select[name="cmp_medidaC_medida"] option:selected').attr('data-tipo');
      cmp_medidaC_imputado = $('#cmp_medidaC_imputado').val();
      cmp_medidaC_medida = $('#cmp_medidaC_medida').val();
      cmp_medidaC_comentarios = $('#cmp_medidaC_comentarios').val();
      cmp_medidaC_fecha_inicio = $('#cmp_medidaC_fecha_inicio').val();
      cmp_medidaC_fecha_fin = $('#cmp_medidaC_fecha_fin').val();
      cmp_medidaC_estado_medida = $('#cmp_medidaC_estado_medida').val();
    
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
          "id_solicitud":carpetaActiva.id_solicitud,
          "id_medida_cautelar":cmp_medidaC_medida,
          "tipo_resultado":tipo_cautelar,
          "monto_garantia":cmp_medidaC_garantia,
          "no_pagos":cmp_medidaC_pagos,
          "autoridad_presentarse":cmp_medidaC_autoridad,
          "especificaciones_medida_cautelar":cmp_medidaC_comentarios,
          "fecha_inicio" : cmp_medidaC_fecha_inicio,
          "fecha_fin" : cmp_medidaC_fecha_fin,
          "estado_medida" : cmp_medidaC_estado_medida
        },
        success:function(response) {
          body = '';
          if(response.status==100){
            $('#modalMedidasCautelares').modal('hide');
            var exito = "<p class='mg-b-20 mg-x-20'>Medida cautelar agregada correctamente </p>";
            modal_success(exito,'modalHistory');
            obtener_MedidaC(CarpetaF,cmp_medidaC_id_audiencia,'primera');
          }else{
            $('#modalMedidasCautelares').modal('hide');
            var error = "<p class='mg-b-20 mg-x-20'>"+response.message+"</p>";
            modal_error(error,'modalHistory');
          }
        }
      });
    }
    
    function cargarCamposEditarMedidaC(cmp_medidaC_id_audiencia_medida_cautelar_E,id_audiencia, CarpetaF, tipo_cautelar, id_imputado, id_medida_cautelar, especificaciones_medida_cautelar ,autoridad_presentarse, monto_garantia, numero_pagos, estatus,cmp_medidaC_fecha_inicio, cmp_medidaC_fecha_fin, cmp_medidaC_estado_medida_E){

      let datosCarpeta = carpetaActiva;

      let imputados = '<option value="-" diabled>Seleccionar</option>';
      for(i in datosCarpeta.imputados){
        imputados += `<option  ${datosCarpeta.imputados[i].id_persona == id_imputado ? 'selected' : ''} value="${datosCarpeta.imputados[i].id_persona}">${ datosCarpeta.imputados[i].tipo == 'fisica' ? datosCarpeta.imputados[i].nombre : datosCarpeta.imputados[i].razon_social}</option>`;
      }

      let estatus1 = '';
      if(estatus == 1){
        estatus1 =`
          <option value="-">Seleccionar</option>
          <option selected value="1">Activo</option>
          <option value="0">Inactivo</option>
        `;
      }else{
        estatus1 =`
          <option value="-">Seleccionar</option>
          <option value="1">Activo</option>
          <option selected value="0">Inactivo</option>
        `;
      }

      let menu_cautelar = '';
      switch (tipo_cautelar){
    
        case 1: 
          menu_cautelar = `
            <div id="medidaC_menu1_E" style="display: block;">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group text-left">
                    <label class="form-control-label">Monto de la Garantia:</label>
                    <div class="form-group">
                      <input type="text" style="text-align:center;" class="form-control" value="${monto_garantia}" id="cmp_medidaC_garantia_E" placeholder="monto de la garantia"  autocomplete="off">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group text-left">
                    <label class="form-control-label">Numero de pagos:</label>
                    <div class="form-group">
                      <input type="number"  style="text-align:center;" class="form-control" value="${numero_pagos}" id="cmp_medidaC_pagos_E" placeholder="numero de pagos" autocomplete="off">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          `;
          break;
        
        case 2: 
          let selected_autoridad_presentarse = '';
          if(autoridad_presentarse == 'UMECA'){
            selected_autoridad_presentarse = `
              <option value="-">Seleccionar</option>
              <option selected value="UMECA">UMECA</option>
              <option value="Juez">Juez</option>
              <option value="Otro">Otro</option>
            `;
          }else if(autoridad_presentarse == 'Juez'){
            selected_autoridad_presentarse = `
              <option value="-">Seleccionar</option>
              <option value="UMECA">UMECA</option>
              <option selected value="Juez">Juez</option>
              <option value="Otro">Otro</option>
            `;
          }else if(autoridad_presentarse == 'Otro'){
            selected_autoridad_presentarse = `
              <option value="-">Seleccionar</option>
              <option value="UMECA">UMECA</option>
              <option value="Juez">Juez</option>
              <option selected value="Otro">Otro</option>
            `;
          }

          menu_cautelar = `
            <div id="medidaC_menu2_E" style="display: block;">
              <div class="form-group text-left">
                <label class="form-control-label">Autoridad a la que debe presentarse:</label>
                <select class="form-control select2" id="cmp_medidaC_autoridad_E" name ="cmp_medidaC_autoridad_E" autocomplete="off">
                  ${selected_autoridad_presentarse}
                </select>
              </div>
            </div>
          `;
          break;
      }

      html = `
        <div class="row">
          <div class="col-lg-12">
          <form action="" id="frm_medidasC_E">

            <input type="hidden" id="cmp_medidaC_folioC_E" value="${CarpetaF}">
            <input type="hidden" id="cmp_medidaC_id_audiencia_E" value="${id_audiencia}">
            <input type="hidden" id="cmp_medidaC_id_audiencia_medida_cautelar_E" value="${cmp_medidaC_id_audiencia_medida_cautelar_E}">

            <div class="row">
              <div class="col-sm-12 col-md-8 col-lg-8">
                <div class="form-group text-left">
                  <label class="form-control-label">Imputado:</label>
                  <select class="form-control select2" id="cmp_medidaC_imputado_E" name ="cmp_medidaC_imputado_E" autocomplete="off">
                    ${imputados}
                  </select>
                </div>
              </div>
              <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group text-left">
                    <label>Estatus:</label>
                    <select class="form-control select2" id="cmp_medidaC_estatus_E" name="cmp_medidaC_estatus_E">
                      ${estatus1}
                    </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group text-left">
                  <label class="form-control-label">Fecha Inicio:</label>
                  <input type="text"  id="cmp_medidaC_fecha_inicio_E" name="cmp_medidaC_fecha_inicio_E" value="${cmp_medidaC_fecha_inicio}" class="form-control date_fif cal">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group text-left">
                  <label class="form-control-label">Fecha fin:</label>
                  <input type="text"  id="cmp_medidaC_fecha_fin_E" name="cmp_medidaC_fecha_fin_E" value="${cmp_medidaC_fecha_fin}" class="form-control date_fif cal">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-8">
                <div class="form-group text-left">
                  <label class="form-control-label">Medida Cautelar:</label>
                  <select class="form-control select2" id="cmp_medidaC_medida_E" name ="cmp_medidaC_medida_E" autocomplete="off" onchange="elegir_menu_cautelar(this)">
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group text-left">
                  <label class="form-control-label">Estado de la medida cautelar:</label>
                  <select class="form-control select2" id="cmp_medidaC_estado_medida_E" name="cmp_medidaC_estado_medida_E" autocomplete="off">
                    <option selected value="-">Seleccionar</option>
                    <option ${cmp_medidaC_estado_medida_E == 1 ? "selected" : ""} value="1">Impuesta</option>
                    <option ${cmp_medidaC_estado_medida_E == 2 ? "selected" : ""} value="2">Revocada</option>
                  </select>
                </div>
              </div>
            </div>

            ${menu_cautelar}

            <div class="form-group text-left">
              <label class="form-control-label">Especificaciones:</label>
              <textarea ${cmp_medidaC_estado_medida_E == 2 ? "disabled" : ""} class="form-control" value="${especificaciones_medida_cautelar == "null" ? "" : especificaciones_medida_cautelar }" id="cmp_medidaC_comentarios_E" rows="3">${especificaciones_medida_cautelar == "null" ? "" : especificaciones_medida_cautelar}</textarea>
            </div>

          </form>

          </div>
        </div>
      `;

      $('#modalHistory').modal('hide');
      $('#bodyMedidasCautelares_E').html(html)
      $('#modalMedidasCautelares_E').modal('show');
      
      setTimeout(function(){
        $('.select2').select2({placeholder: 'Seleccionar'});
        $('.calendar').datepicker({dateFormat:'yy-mm-dd',firstDay: 1}).datepicker("setDate", new Date());
        let fecha_actual = new Date();
        $('.cal').datepicker({
          showOtherMonths: true,
          selectOtherMonths: true,
          dateFormat: 'yy-mm-dd',
          changeYear: true,
          yearRange: "c-100:" + (fecha_actual.getFullYear() + 5)
        });

        $('#cmp_medidaC_estado_medida_E').change(function(){
          if($(this).val() == 1){
            $('#cmp_medidaC_comentarios_E').prop('disabled', false);
          }else{
            $('#cmp_medidaC_comentarios_E').prop('disabled', true);
          }
        });

        $.ajax({
          type:'post',
          url:'/public/obtener_MedidasCautelares',
          data:{
          },
          success:function(response) {
            body = '';
            if(response.status==100){
                var datas = response.response;
                //console.log(datas);
                body='<option value="">Seleccione Medida Cautelar</option>';
                for (var j = 0; j < datas.length; j++) {
                  body += `<option ${ datas[j]['id_medida_c'] == id_medida_cautelar ? 'selected' : ''} value="${datas[j]['id_medida_c']}" data-tipo="${datas[j]['es_sancion_economica']}">${datas[j]['tipo_medida_cautelar']}</option>`;
                }
              $("#cmp_medidaC_medida_E").html(body);
      
            }else{
              body = body.concat('<option value="-">Seleccione un resolutivo</option>');
              $("#cmp_medidaC_medida_E").html(body);
      
            }
          }
        });

      },600)
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
      cmp_medidaC_fecha_inicio_E = $('#cmp_medidaC_fecha_inicio_E').val();
      cmp_medidaC_fecha_fin_E = $('#cmp_medidaC_fecha_fin_E').val();
      cmp_medidaC_estado_medida_E = $('#cmp_medidaC_estado_medida_E').val();

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
          "estatus":cmp_medidaC_estatus_E,
          "fecha_inicio" : cmp_medidaC_fecha_inicio_E,
          "fecha_fin" : cmp_medidaC_fecha_fin_E,
          "estado_medida" :cmp_medidaC_estado_medida_E
        },
        success:function(response) {
          body = '';
          if(response.status==100){
            $('#modalMedidasCautelares_E').modal('hide');
            var exito = "<p class='mg-b-20 mg-x-20'>Medida cautelar actualizada correctamente </p>";
            modal_success(exito,'modalHistory');
            obtener_MedidaC(CarpetaF,cmp_medidaC_id_audiencia_E,'primera');
          }else{
            $('#modalMedidasCautelares_E').modal('hide');
            var error = "<p class='mg-b-20 mg-x-20'>"+response.message+"</p>";
            modal_error(error,'modalHistory');
          }
        }
      });
    
    }
  

    //{{--  Funcion Compratida  --}}
    function verPdf_documento(id_acuerdo, id_audiencia,tipo){
      $('#modalHistory').modal('hide');

      $.ajax({
        type:'GET',
        url:'/public/obtener_documento_resolutivo',
        data:{
          id_audiencia:id_audiencia,
          id_acuerdo:id_acuerdo,
          tipo:tipo
        },
        success:function(response) {
          if(response.status ==100){
            console.log(response.response);

            pdf = `<embed src="${response.response}" type="application/pdf" width="100%" height="600px" />`;
            $('#visorPDFdocumento').html(pdf);
          }else{
            pdf = `<div style="height: 600px;background: #444;display: flex;justify-content: center;align-items: center;flex-direction: column;font-size: 1.2em;;">
              <i class="fa fa-file-pdf" style="color: #fff;font-size: 1.1em;margin-right: 3%;margin-bottom: 2%;font-size: 4em;"></i>
              Sin Documento PDF
            </div>`;

            $('#visorPDFdocumento').html(pdf);
          }
        }
      });

      $('#modal-res-documento').modal('show');
    }
    
    function get_tipo_data( extension ){
      if( extension == 'pdf' ) return 'data:application/pdf;base64,';
      if( extension == 'jpg' ) return 'data:image/jpeg;base64,';
      if( extension == 'png' ) return 'data:image/png;base64,';
      if( extension == 'doc' ) return '';
      if( extension == 'docx' ) return '';
      else return '';
    }

    function ponerFechaBase(obj){
      var valor = $(obj).val();
      date = new Date(valor);
      $('#cmp_fecha_resultado').val(valor);
      $('#dia').val(0);
      $('#mes').val(0);
      $('#anio').val(0);
    }

    function operacion_dia(obj, tipo){
      let resultado = '';

      if(tipo == 'sumar'){
        if(count_days < 366){
          ++count_days;
          resultado = moment($('#cmp_fecha_resultado').val()).add(1, 'd').format("YYYY-MM-DD");

          $('#dia').val(count_days);
          $('#cmp_fecha_resultado').val(resultado);
        }
      }else if(tipo == 'restar'){
        if(count_days > 0){
          --count_days;
          resultado = moment($('#cmp_fecha_resultado').val()).subtract(1, 'd').format("YYYY-MM-DD");

          $('#dia').val(count_days);
          $('#cmp_fecha_resultado').val(resultado);
        }
      }
    }

    function operacion_mes(obj, tipo){
      let resultado = '';

      if(tipo == 'sumar'){
        if(count_months < 12){
          ++count_months;
          resultado = moment($('#cmp_fecha_resultado').val()).add(1, 'M').format("YYYY-MM-DD");
          $('#mes').val(count_months);
          $('#cmp_fecha_resultado').val(resultado);
        }
      }else if(tipo == 'restar'){
        if(count_months > 0){
          --count_months;
          resultado = moment($('#cmp_fecha_resultado').val()).subtract(1, 'M').format("YYYY-MM-DD");
          $('#mes').val(count_months);
          $('#cmp_fecha_resultado').val(resultado);
        }
      }
    }

    function operacion_anio(obj, tipo){
      let resultado = '';

      if(tipo == 'sumar'){
        if(count_years < 50){
          ++count_years;
          resultado = moment($('#cmp_fecha_resultado').val()).add(1, 'y').format("YYYY-MM-DD");
          $('#anio').val(count_years);
          $('#cmp_fecha_resultado').val(resultado);
        }
      }else if(tipo == 'restar'){ 
        if(count_years > 0){
          --count_years;
          resultado = moment($('#cmp_fecha_resultado').val()).subtract(1, 'y').format("YYYY-MM-DD");
          $('#anio').val(count_years);
          $('#cmp_fecha_resultado').val(resultado);
        }
      }
    }
    /*
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
    */

    //{{--  Medidas Proteccion  --}}
    
    function menu_promujer_rat(tipo_audiencia,carpeta_judicial_F,victimas_F, id_solicitud_F,id_audiencia_F){
      if(tipo_audiencia == 252 || tipo_audiencia == 52){
        $('#medias_proteccion_menu_promujer_rat').css('display', 'block');
        $('#medias_proteccion_menu_penal').css('display', 'none');
        listarVictimas(victimas_F,id_solicitud_F,id_audiencia_F, tipo_audiencia);
        setTimeout(function(){
          listaFracciones(id_audiencia_F,tipo_audiencia);
        },1000);
      }else{
        $('#medias_proteccion_menu_promujer_rat').css('display', 'none');
        $('#medias_proteccion_menu_penal').css('display', 'block');
        obtener_MedidaP(carpeta_judicial_F,id_audiencia_F,'primera');
      }
    }

    ///   MEDIDAS DE PROTECCION 
    function obtener_MedidaP(folio,id_audiencia,pagina_accion){

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
              id_audiencia: id_audiencia,
              registros_por_pagina:registros_por_pagina,
              pagina:$("#pagina_actual_medidap").val()
            },
            success:function(response) {
              body = '';
    
              if(response.status==100){
    
                $('.pagina_total_texto_medidap').html(response.response_pag['paginas_totales']);
                $('#paginas_totales_medidap').val(response.response_pag['paginas_totales']);
    
                  var datas = response.response;
                  console.log(datas);
                  for (var j = 0; j < datas.length; j++) {
    
                      if(datas[j]['inactividad'] == 1){
                        color = 'green';
                        estado = 'Activo';
                      }else{
                        color= 'red';
                        estado = 'Inactivo';
                      }

                      let permiso = '';
                      if(datas[j]['apertura_resolutivos'] == 1){
                        permiso = `
                          <i class="fas fa-trash-alt acciones2" data-toggle="tooltip-primary" data-placement="top" title="Eliminar resolutivo" style="cursor:pointer; background: #A72424;" onclick="modalEliminar(${datas[j]['id_audiencia_mproteccion_csuspension']},${datas[j]['id_audiencia']}, 5)"></i>
                          <i class="fas fa-edit acciones2" style="cursor:pointer;" data-toggle="tooltip-primary" data-placement="top" title="Editar resolutivo" onclick="cargarCamposEditarMedidaP(${datas[j]['id_audiencia_mproteccion_csuspension']},${datas[j]['id_audiencia']},'${datas[j]['folio_carpeta']}', ${datas[j]['id_imputado']}, ${datas[j]['id_medida_proteccion']} , '${datas[j]['especificaciones']}' , ${datas[j]['estatus']},'${datas[j]['fecha_inicio']}','${datas[j]['fecha_fin']}')"></i>
                        `;
                      }else{
                        permiso = '<span style="color: #CB4335; margin-right:2%">Se ha finalizado la captura</span>';
                      }
    
                      body += `<tr>
                                  <td> ${permiso}</td> 
                                  <td> ${datas[j]['imputado']}            </td>
                                  <td> ${datas[j]['medida_proteccion']}   </td> 
                                  <td> ${datas[j]['especificaciones']} </td>
                                  <td> ${datas[j]['fecha_inicio']} </td>
                                  <td> ${datas[j]['fecha_fin']} </td>
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
    
    function agregarMedidaP(folio, id_audiencia){

      let datosCarpeta = carpetaActiva;

      let imputados = '<option value="-" diabled>Seleccionar</option>';
      for(i in datosCarpeta.imputados){
        imputados += `<option value="${datosCarpeta.imputados[i].id_persona}">${ datosCarpeta.imputados[i].tipo == 'fisica' ? datosCarpeta.imputados[i].nombre : datosCarpeta.imputados[i].razon_social}</option>`;
      }

      var html = `
        <div class="row">
          <div class="col-lg-12">
          <form action="" id="frm_medidasP">
            <input type="hidden" id="cmp_medidaP_folioC" value="${folio}">
            <input type="hidden" id="cmp_medidaP_id_audiencia" value="${id_audiencia}">
            <input type="hidden" id="cmp_medidaP_bandera" value="Proteccion">

            <div class="row">
              <div class="col-md-4">
                <div class="form-group text-left">
                  <label class="form-control-label">Imputado:</label>
                  <select class="form-control select2" id="cmp_medidaP_imputado" name ="cmp_medidaP_imputado" autocomplete="off">
                    ${imputados}
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group text-left">
                  <label class="form-control-label">Fecha Inicio:</label>
                  <input type="text" id="cmp_medidaP_fecha_inicio" name="cmp_medidaP_fecha_inicio" class="form-control date_fif cal">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group text-left">
                  <label class="form-control-label">Fecha fin:</label>
                  <input type="text" id="cmp_medidaP_fecha_fin" name="cmp_medidaP_fecha_fin" class="form-control date_fif cal">
                </div>
              </div>
            </div>


            <div class="form-group text-left">
              <label class="form-control-label">Medida de Proteccion:</label>
              <select class="form-control select2" id="cmp_medidaP_medida" name ="cmp_medidaP_medida" autocomplete="off">
              </select>
            </div>

            <div class="form-group text-left">
              <label class="form-control-label">Comentarios adicionales:</label>
              <textarea class="form-control" id="cmp_medidaP_comentarios" rows="3"></textarea>
            </div>

          </form>

          </div>
        </div>
      `;

      $('#modalHistory').modal('hide');
      $('#boyMedidasProteccion').html(html);
      $('#modalMedidasProteccion').modal('show');

      setTimeout(function(){
        $('.select2').select2({placeholder: 'Seleccionar'});
        $('.calendar').datepicker({dateFormat:'yy-mm-dd',firstDay: 1}).datepicker("setDate", new Date());
        let fecha_actual = new Date();
        $('.cal').datepicker({
          showOtherMonths: true,
          selectOtherMonths: true,
          dateFormat: 'yy-mm-dd',
          changeYear: true,
          yearRange: "c-100:" + (fecha_actual.getFullYear() + 5)
        });

        $.ajax({
          type:'post',
          url:'/public/obtener_MedidasProteccion',
          data:{
          },
          success:function(response) {
            body = '';
            if(response.status==100){
                var datas = response.response;
                //console.log(datas);
                body='<option value="">Seleccione Medida Proteccion</option>';
                for (var j = 0; j < datas.length; j++) {
                  body += `<option value="${datas[j]['id_medida_p']}" >${datas[j]['medida_proteccion']}</option>`;
                }
              $("#cmp_medidaP_medida").html(body);
      
            }else{
              body = body.concat('<option value="">Seleccione Medida Proteccion</option>');
              $("cmp_medidaP_medida").html(body);
      
            }
          }
        });
      },600)

    }
    
    function guardarMedidaP(){
      cmp_medidaP_folioC = $('#cmp_medidaP_folioC').val();
      cmp_medidaP_id_audiencia =  $('#cmp_medidaP_id_audiencia').val();
      cmp_medidaP_bandera = $('#cmp_medidaP_bandera').val();
      cmp_medidaP_imputado = $('#cmp_medidaP_imputado').val();
      cmp_medidaP_medida = $('#cmp_medidaP_medida').val();
      cmp_medidaP_comentarios = $('#cmp_medidaP_comentarios').val();
      id_condicion_suspencion = null;
      cmp_medidaP_fecha_inicio = $('#cmp_medidaP_fecha_inicio').val();
      cmp_medidaP_fecha_fin = $('#cmp_medidaP_fecha_fin').val();

      medidaPro = $('select[name="cmp_medidaP_medida"] option:selected').text();
    
      $.ajax({
        type:'post',
        url:'/public/guardarMedidaP',
        data:{
          "id_imputado":cmp_medidaP_imputado,
          "id_solicitud":carpetaActiva.id_solicitud,
          "id_medida_proteccion":cmp_medidaP_medida,
          "id_condicion_suspencion":id_condicion_suspencion,
          "folio_carpeta":cmp_medidaP_folioC,
          "especificaciones":cmp_medidaP_comentarios,
          "bandera":cmp_medidaP_bandera,
          "id_audiencia":cmp_medidaP_id_audiencia,
          "fecha_inicio": cmp_medidaP_fecha_inicio,
          "fecha_fin":cmp_medidaP_fecha_fin
        },
        success:function(response) {
          body = '';
          if(response.status==100){
            $('#modalMedidasProteccion').modal('hide');
            var exito = "<p class='mg-b-20 mg-x-20'>Medida de protección agregada correctamente </p>";
            modal_success(exito,'modalHistory');
            obtener_MedidaP(cmp_medidaP_folioC,cmp_medidaP_id_audiencia,'primera');
          }else{
            $('#modalMedidasProteccion').modal('hide');
            var error = "<p class='mg-b-20 mg-x-20'>"+response.message+"</p>";
            modal_error(error,'modalHistory');
          }
        }
      });
      
    }
    
    function cargarCamposEditarMedidaP(id_audiencia_mproteccion_csuspension,id_audiencia,folio_carpeta,id_imputado,id_medida_proteccion, especificaciones, estatus, cmp_medidaP_fecha_inicio,cmp_medidaP_fecha_fin ){
      
      let datosCarpeta = carpetaActiva;

      let imputados = '<option value="-" diabled>Seleccionar</option>';
      for(i in datosCarpeta.imputados){
        imputados += `<option  ${datosCarpeta.imputados[i].id_persona == id_imputado ? 'selected' : ''} value="${datosCarpeta.imputados[i].id_persona}">${ datosCarpeta.imputados[i].tipo == 'fisica' ? datosCarpeta.imputados[i].nombre : datosCarpeta.imputados[i].razon_social}</option>`;
      }

      let estatus1 = '';
      if(estatus == 1){
        estatus1 =`
          <option value="-">Seleccionar</option>
          <option selected value="1">Activo</option>
          <option value="0">Inactivo</option>
        `;
      }else{
        estatus1 =`
          <option value="-">Seleccionar</option>
          <option value="1">Activo</option>
          <option selected value="0">Inactivo</option>
        `;
      }


      html = `
        <div class="row">
          <div class="col-lg-12">
          <form action="" id="frm_medidasP_E">
            <input type="hidden" id="cmp_medidaP_folioC_E" value="${folio_carpeta}">
            <input type="hidden" id="cmp_medidaP_id_audiencia_E" value="${id_audiencia}">
            <input type="hidden" id="cmp_medidaP_id_audiencia_medida_cautelar_E" value="${id_audiencia_mproteccion_csuspension}">
            <input type="hidden" id="cmp_medidaP_bandera_E" value="Proteccion">

            <div class="row">
              <div class="col-sm-12 col-md-8 col-lg-8">
                <div class="form-group text-left">
                  <label class="form-control-label">Imputado:</label>
                  <select class="form-control select2" id="cmp_medidaP_imputado_E" name ="cmp_medidaP_imputado_E" autocomplete="off">
                    ${imputados}
                  </select>
                </div>
              </div>
              <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group text-left">
                    <label>Estatus:</label>
                    <select class="form-control select2" id="cmp_medidaP_estatus_E" name="cmp_medidaP_estatus_E">
                      ${estatus1}
                    </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-4">
                <div class="form-group text-left">
                  <label class="form-control-label">Fecha Inicio:</label>
                  <input type="text" id="cmp_medidaP_fecha_inicio_E" name="cmp_medidaP_fecha_inicio_E" value="${cmp_medidaP_fecha_inicio}" class="form-control date_fif cal">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group text-left">
                  <label class="form-control-label">Fecha fin:</label>
                  <input type="text" id="cmp_medidaP_fecha_fin_E" name="cmp_medidaP_fecha_fin_E" value="${cmp_medidaP_fecha_fin}" class="form-control date_fif cal">
                </div>
              </div>
            </div>

            <div class="form-group text-left">
              <label class="form-control-label">Medida Proteccion:</label>
              <select class="form-control select2" id="cmp_medidaP_medida_E" name ="cmp_medidaP_medida_E" autocomplete="off" onchange="elegir_menu_cautelar(this)">
              </select>
            </div>

            <div class="form-group text-left">
              <label class="form-control-label">Comentarios adicionales:</label>
              <textarea class="form-control" value="${especificaciones}" id="cmp_medidaP_comentarios_E" rows="3">${especificaciones}</textarea>
            </div>

          </form>

          </div>
        </div>
      `;
    
      $('#modalHistory').modal('hide');
      $('#bodyMedidasProteccion_E').html(html);
      $('#modalMedidasProteccion_E').modal('show');

      setTimeout(function(){
        $('.select2').select2({placeholder: 'Seleccionar'});
        $('.calendar').datepicker({dateFormat:'yy-mm-dd',firstDay: 1}).datepicker("setDate", new Date());
        let fecha_actual = new Date();
        $('.cal').datepicker({
          showOtherMonths: true,
          selectOtherMonths: true,
          dateFormat: 'yy-mm-dd',
          changeYear: true,
          yearRange: "c-100:" + (fecha_actual.getFullYear() + 5)
        });

        $.ajax({
          type:'post',
          url:'/public/obtener_MedidasProteccion',
          data:{
          },
          success:function(response) {
            body = '';
            if(response.status==100){
                var datas = response.response;
                //console.log(datas);
                body='<option value="">Seleccione Medida Proteccion</option>';
                for (var j = 0; j < datas.length; j++) {
                  body += `<option ${ datas[j]['id_medida_p'] == id_medida_proteccion ? 'selected' : ''}  value="${datas[j]['id_medida_p']}" >${datas[j]['medida_proteccion']}</option>`;
                }
              $("#cmp_medidaP_medida_E").html(body);
      
            }else{
              body = body.concat('<option value="">Seleccione Medida Proteccion</option>');
              $("cmp_medidaP_medida_E").html(body);
      
            }
          }
        });
      },600)

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
    
      cmp_medidaP_fecha_inicio = $('#cmp_medidaP_fecha_inicio_E').val();
      cmp_medidaP_fecha_fin = $('#cmp_medidaP_fecha_fin_E').val();
    
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
          "fecha_inicio": cmp_medidaP_fecha_inicio,
          "fecha_fin":cmp_medidaP_fecha_fin
        },
        success:function(response) {
          body = '';
          if(response.status==100){
            $('#modalMedidasProteccion_E').modal('hide');
            var exito = "<p class='mg-b-20 mg-x-20'>Medida de protección actualizada correctamente </p>";
            modal_success(exito,'modalHistory');
            obtener_MedidaP(cmp_medidaP_folioC_E,cmp_medidaP_id_audiencia_E,'primera');
          }else{
            $('#modalMedidasProteccion_E').modal('hide');
            var error = "<p class='mg-b-20 mg-x-20'>"+response.message+"</p>";
            modal_error(error,'modalHistory');
          }
        }
      });
      
    }
  
    //################################################################
    // MEDIDAS DE PROTECCION  -- FRACCIONES --
    function listaFracciones(id_audiencia_F, tipo_audiencia){
      console.log($('#lista_victimas').val());
      
      fracciones_totales.splice(0,fracciones_totales.length);

      var id_solicitud_F =  $('#lista_victimas').attr('id_solicitud');
      var id_persona = $('#lista_victimas').val();

      console.log('id_audiencia',id_audiencia_F);

      // Revisar primero por audiencia
      $.ajax({
        type:'POST',
        url:'/public/catalogo_fracciones_solicitud',
        data:{
          id_persona : (id_persona == '' || id_persona == null) ? 0 : id_persona,
          id_solicitud : '',
          id_audiencia: id_audiencia_F
        },
        success:function(response){
          console.log(response);
          $('#table_fracciones_e').html('');

          //Existe un formato de audiencia
          if(response.status == 100){ 
            var html = '';
            var lista = response.response;
            $('#checkados_fracc').attr('tipo', 'audiencia');
            $('#checkados_fracc').html('Actualizar Seleccion');
            console.log('Con formato de audienca');

            for(i = 0; i < lista.length; i++){
        
              button_show = '';
              checkado_promujer = '';
              checkado_audi = '';
              descripcion = '';

              //Agregamos las fracciones a un array
              fracciones_totales.push({
                "id_padre": lista[i].id_padre,            
                "id_cat": lista[i].id_cat,
                "id_fraccion_valor": lista[i].id_audi_fraccion, //id de la medida de proteccion
                "fraccion_valor":lista[i].audi_fraccion_valor,
                "fraccion_descripcion_otros":lista[i].audi_fraccion_descripcion_otros
              });

              if(lista[i].id_cat != 16){
                
                if(lista[i].soli_fraccion_valor == 1){
                  checkado_promujer = `<i style="color: #229954; font-size: 1.4em; background:none;" class="far fa-check-circle"></i>`;
                }else{
                  checkado_promujer = `<i style="color: #c0b5b4c4; font-size: 1.4em; background:none;" class="fas fa-minus"></i>`;
                }

                if(lista[i].audi_fraccion_valor == 1){
                  checkado_audi = `checked`;
                }else{
                  checkado_audi = ``;
                }

                //switcc
                button_show = `<label class="switch" >
                  <input type="checkbox" ${checkado_audi} id="frac_${lista[i].id_cat}" class="fraccion_checada" value="${lista[i].id_cat}" padre="${lista[i].id_padre}" fraccion="${lista[i].descripcion}"  onchange="fraccion_check_audi(this,${lista[i].id_audi_fraccion} ,${lista[i].id_cat})">
                  <span class="slider round"></span>
                </label>`;

                descripcion = lista[i].descripcion;

              }else{
                
                checkado_promujer ='<i style="color: #c0b5b4c4; font-size: 1.4em; background:none;" class="fas fa-minus"></i>';
                
                if(i == (lista.length - 1)){
                  checkado_promujer =`<button class="addfr"><i class="fa fa-plus" onclick="add_fracc(${lista[i].id_cat}, ${lista[i].id_padre}, ${lista[i].id_audi_fraccion}, 'audiencia')"></i></button>`;
                }

                if(lista[i].audi_fraccion_valor == 1){
                  checkado_audi = `checked`;
                }else{
                  checkado_audi = ``;
                }

                descripcion = lista[i].audi_fraccion_descripcion_otros;
                
                button_show = `<label class="switch" >
                  <input type="checkbox" ${checkado_audi} id="frac_${lista[i].id_cat}" class="fraccion_checada" value="${lista[i].id_cat}" padre="${lista[i].id_padre}" fraccion="${lista[i].descripcion}"  onchange="fraccion_check_audi(this,${lista[i].id_audi_fraccion} ,${lista[i].id_cat})">
                  <span class="slider round"></span>
                </label>`;
                //button_show =  
              }

              //quitar el if en caso de mostrar las hipotesis
              if(lista[i].id_padre == 0){
                //cuerpo de la tabla
                html += `<tr>
                  <td style="min-width: 5%; text-align:center; border: 1px solid #eee; color: #848F33;;font-weight: bold;font-size: 1.2em;">${lista[i].id_padre == 0 ? lista[i].fraccion : '' }</td>
                  <td style="min-width: 80%; text-align:justify; border-bottom: 1px solid #eee; padding:1px 1%; font-size: 0.9em;">${descripcion == null ? 'Sin Titulo' : descripcion}</td>
                  <td style="min-width: 5%; border-left: 1px solid #eee; display: table-cell; justify-content: center; padding: 1% 1%; align-items: center;">
                    ${checkado_promujer} 
                  </td>
                  <td style="min-width: 5%; border-left: 1px solid #eee; display: table-cell; justify-content: center; padding: 1% 1%; align-items: center;">
                    ${button_show}
                  </td>
                </tr>`;
              }
              
            }
            
            $('#table_fracciones_e').html(html); //Caso de Audiencia

          }else{
            console.log('Con formato de solicitud');
            // En caso de que no tenga El formato de Audiencia Se ocupa el formato de la solicitud
            $.ajax({
              type:'POST',
              url:'/public/catalogo_fracciones_solicitud',
              data:{
                id_audiencia: '',
                id_persona : id_persona,
                id_solicitud : id_solicitud_F
              },
              success:function(response){
                
                console.log(response);
                $('#table_fracciones_e').html('');
        
                if(response.status == 100){
                  var html = '';
                  var lista = response.response;
                  $('#checkados_fracc').attr('tipo', 'solicitud');
                  $('#checkados_fracc').html('Guardar Seleccion');
                  var ids_vic = $('#lista_victimas').attr('ids_victimas');
                  var ids_victimas = ids_vic.split(',');

                  for(m in ids_victimas){
                    for(n = 0; n < lista.length; n++){
                      //Agregamos las fracciones a un array
                      fracciones_totales.push({
                        "id_persona":ids_victimas[m],              
                        "id_fraccion": lista[n].id_cat,
                        "valor_solicitado":'0',
                        "descripcion_otros":'-',
                        "fraccion": lista[n].fraccion,
                        "id_padre": lista[n].id_padre
                      });
                    }
                  }

                  for(i = 0; i < lista.length; i++){
              
                    button_show = '';
                    checkado_promujer = '';

                    if(lista[i].id_cat != 16){
                
                      if(lista[i].soli_fraccion_valor == 1){
                        checkado_promujer = `<i style="color: #229954; font-size: 1.4em; background:none;" class="far fa-check-circle"></i>`;
                      }else{
                        checkado_promujer = `<i style="color: #c0b5b4c4; font-size: 1.4em; background:none;" class="fas fa-minus"></i>`;
                      }
        
                      //switcc
                      button_show = `<label class="switch" >
                        <input type="checkbox" id="frac_${lista[i].id_cat}" class="fraccion_checada" value="${lista[i].id_cat}" fraccion="${lista[i].fraccion}" padre="${lista[i].id_padre}" onchange="fraccion_check(this, ${id_persona},${lista[i].id_cat})">
                        <span class="slider round"></span>
                      </label>`;
        
                    }else{
                      checkado_promujer ='';
                      button_show = `<button class="addfr"><i class="fa fa-plus" onclick="add_fracc(${lista[i].id_cat}, ${lista[i].id_padre}, ${id_persona}, 'solicitud')"></i></button>`;
                    }
        
                    //quitar el if en caso de mostrar las fracciones
                    if(lista[i].id_padre == 0){
                      html += `<tr>
                        <td style="min-width: 5%; text-align:center; border: 1px solid #eee; color: #848F33;;font-weight: bold;font-size: 1.2em;">${lista[i].id_padre == 0 ? lista[i].fraccion : '' }</td>
                        <td style="min-width: 80%; text-align:justify; border-bottom: 1px solid #eee; padding:1px 1%; font-size: 0.9em;">${lista[i].descripcion}</td>
                        <td style="min-width: 5%; border-left: 1px solid #eee; display: table-cell; justify-content: center; padding: 1% 1%; align-items: center;">
                          ${checkado_promujer} 
                        </td>
                        <td style="min-width: 5%; border-left: 1px solid #eee; display: table-cell; justify-content: center; padding: 1% 1%; align-items: center;">
                          ${button_show}
                        </td>
                      </tr>`;
                    }
                      
                  }

                }else{
                  html += `<tr>
                    <td style="min-width: 95%; text-align:left;">No se Encontraron resultados</td>
                    <td style="min-width: 5%; border-left: 1px solid #eee;">
                      <label class="switch">
                        <input type="checkbox" disabled>
                        <span class="slider round"></span>
                      </label>
                    </td>
                  </tr>`;
                }

                $('#table_fracciones_e').html(html); //Caso de solicitud
              }
            });
            
          }
        }
      });
    }

    function listarVictimas(victimas_F,id_solicitud_F, id_audiencia_F,tipo_audiencia ){
      console.log('Victimas a listar', victimas_F);

      $('#lista_victimas').attr('id_solicitud',id_solicitud_F);

      let victima = '<option value="0">Selecciona una opción</option>';
      var active = '';
      var ids_victimas = [];
      //var style = 'border-radius: 4px 4px 0px 0px; font-size: 0.7em; text-align: center; cursor: pointer; height: 36px; border:1px solid #848F33;';
      //var id_trigger = '';
      for(i in victimas_F){

        if(i == 0){
          active = 'selected';
        }else{
          active = '';
        }
        ids_victimas.push(victimas_F[i].id_persona);
        victima += `<option ${active} value="${victimas_F[i].id_persona}" solicitud="${id_solicitud_F}" audiencia="${id_audiencia_F}" >${victimas_F[i].tipo == 'fisica' ? victimas_F[i].nombre : victimas_F[i].razon_social}</option>`;
      }

      $('#lista_victimas').attr('ids_victimas',ids_victimas);
      $('#lista_victimas').html(victima);
      
      setTimeout(function(){
        $('#lista_victimas').select2();
        $('#tipo_resolucion_s').select2();
      },600)
      //### Aqui se agrega la opcion de campos
      obtener_fecha_acuerdo(carpetaActiva.id_solicitud,tipo_audiencia,id_audiencia_F);

    }

    function obtener_fecha_acuerdo(id_solicitud,tipo_audiencia,id_audiencia_F){

      $.ajax({
        type:'GET',
        url:'/public/obtener_fecha_acuerdo',
        data:{
          id_solicitud: id_solicitud,
          id_audiencia: id_audiencia_F
        },
        success:function(response){
      
          console.log('fecha_acuerdo',response);
          
          if(response.status == 100){

            if(response.response.tipo == 'acuerdo'){
              $('#tipo_resolucion_s').html(`
                <option value="audiencia">Audiencia</option>
                <option value="acuerdo">Acuerdo</option>
              `);
            }else{
              $('#tipo_resolucion_s').html(`
                <option value="audiencia">Audiencia</option>
              `);
            }

            $('#cmp_medidaP_fecha_inicio_acuerdo').val(`${response.response.fecha_inicio_medida == '' ? audiencia_activa.fecha_audiencia : response.response.fecha_inicio_medida}`);
            $('#cmp_medidaP_fecha_fin_acuerdo').val(`${response.response.fecha_fin_medida_proteccion ?? ""}`);

            $('#cmp_medidaP_id_acuerdo').val(`${response.response.id_acuerdo_audiencia}`);
            $('#cmp_medidaP_cantidad_dias').val(response.response.cantidad_dias);


            if(tipo_audiencia == 52){
              $('#resolucion_solicitud_medidad').html(`
                <option selected value="-">Selecciona una opcion</option>
                <option ${response.response.resolucion_solicitud == 0 ? 'selected': ''} value="0">Negada</option>
                <option ${response.response.resolucion_solicitud == 1 ? 'selected': ''} value="1">Ratificada</option>
                <option ${response.response.resolucion_solicitud == 2 ? 'selected': ''} value="2">No Ratificada</option>
                <option ${response.response.resolucion_solicitud == 3 ? 'selected': ''} value="3">Sin materia</option>
                <option ${response.response.resolucion_solicitud == 4 ? 'selected': ''} value="4">Desistida</option>
                <option ${response.response.resolucion_solicitud == 5 ? 'selected': ''} value="5">Solicitada</option>
                <option ${response.response.resolucion_solicitud == 6 ? 'selected': ''} value="6">Otro</option>
              `);
            }else{
              $('#resolucion_solicitud_medidad').html(`
                <option selected value="-">Selecciona una opcion</option>
                <option ${response.response.resolucion_solicitud == 0 ? 'selected': ''} value="0">Negada</option>
                <option ${response.response.resolucion_solicitud == 1 ? 'selected': ''} value="1">Concedida</option>
              `);
            }

          }else{

            if(tipo_audiencia == 52){
              $('#resolucion_solicitud_medidad').html(`
                <option selected value="-">Selecciona una opcion</option>
                <option value="0">Negada</option>
                <option value="1">Ratificada</option>
                <option value="2">No Ratificada</option>
                <option value="3">Sin materia</option>
                <option value="4">Desistida</option>
                <option value="5">Solicitada</option>
                <option value="6">Otro</option>
              `);
            }else{
              $('#resolucion_solicitud_medidad').html(`
                <option selected value="-">Selecciona una opcion</option>
                <option value="0">Negada</option>
                <option value="1">Concedida</option>
              `);
            }
          }
          
          setTimeout(function(){

            $('#saveFechas').click(function(){

              var data = {
                "tipo_resolucion": $('#tipo_resolucion_s').val(),
                "fecha_inicio": $('#cmp_medidaP_fecha_inicio_acuerdo').val(),
                "cantidad_dias": $('#cmp_medidaP_cantidad_dias').val(),
                "fecha_fin": $('#cmp_medidaP_fecha_fin_acuerdo').val(),
                "id_acuerdo_audiencia": $('#cmp_medidaP_id_acuerdo').val(),
                "resolucion_solicitud_medidad": $('#resolucion_solicitud_medidad').val()
              }
              
              $.ajax({
                type:'post',
                url:'/public/guardarFechas_rat',
                data: data,
                success:function(response) {
                  console.log(response);
                  if(response.status==100){ 
                    $('#modalMedidasProteccion').modal('hide');
                    var exito = "<p class='mg-b-20 mg-x-20'>"+response.response+"</p>";
                    modal_success(exito,'modalHistory');
                  }else{
                    var error = "<p class='mg-b-20 mg-x-20'>"+response.response+"</p>";
                    modal_error(error,'modalHistory');
                  }
                }
              });
            });

            $('#cmp_medidaP_cantidad_dias').on('input', function () { 
              this.value = this.value.replace(/[^0-9]/g,'');
            });

            let fecha_actual = new Date();
            $('.cal').datepicker({
              showOtherMonths: true,
              selectOtherMonths: true,
              dateFormat: 'yy-mm-dd',
              changeYear: true,
              yearRange: "c-100:" + (fecha_actual.getFullYear() + 5)
            });

            $('#resolucion_solicitud_medidad').select2();

            $('#cmp_medidaP_cantidad_dias').change(function(){
              let resultado = '';
              let cantidad = $(this).val();
              $('#cmp_medidaP_fecha_fin_acuerdo').val('');
              resultado = moment($('#cmp_medidaP_fecha_inicio_acuerdo').val()).add(cantidad, 'd').format("YYYY-MM-DD");
              $('#cmp_medidaP_fecha_fin_acuerdo').val(resultado);
            });

          },500);
          
        }
      });
    }

    function add_fracc(id_cat, id_padre, id_persona_audi_fraccion, tipo){

      if(tipo == 'solicitud'){
        if($('.boton_quitar_remove').length > 0){
          indice = 0;
        }else{
          indice = id_persona_audi_fraccion;
        }

        tr = `
          <tr>
            <td style="min-width: 3%; text-align:center; border: 1px solid #eee; color: #848f3363;font-weight: bold;font-size: 1.4em;">
              <i class="fa fa-times-circle boton_quitar_remove" title="Quitar filas" onclick="removeRow(this,${indice},${id_cat})"></i>
            </td>
            <td style="min-width: 82%; text-align:justify; border-bottom: 1px solid #eee; padding:0 1%;"><input type="text" class="fraccion16 fr"></td>
            <td style="min-width: 5%; border-left: 1px solid #eee;">
            </td>
            <td style="min-width: 5%; border-left: 1px solid #eee;">
              <label class="switch">
                <input type="checkbox" id="frac_${id_cat}" class="fraccion_checada" value="${id_cat}" fraccion="otros" padre="${id_padre}" onchange="fraccion_check(this, ${id_persona_audi_fraccion},${id_cat})">
                <span class="slider round"></span>
              </label>
            </td>
          </tr>
        `;
      }else{
        var indice = '';
        if($('.boton_quitar_remove').length > 0){
          indice = 0;
        }else{
          indice = id_persona_audi_fraccion;
        }

        tr = `
          <tr>
            <td style="min-width: 3%; text-align:center; border: 1px solid #eee; color: #075576;font-weight: bold;font-size: 1.4em;">
              <i class="fa fa-times-circle boton_quitar_remove" title="Quitar filas" onclick="removeRow(this,${indice},${id_cat})"></i>
            </td>
            <td style="min-width: 82%; text-align:justify; border-bottom: 1px solid #eee; padding:0 1%;"><input type="text" class="fraccion16 fr"></td>
            <td style="min-width: 5%; border-left: 1px solid #eee;">
            </td>
            <td style="min-width: 5%; border-left: 1px solid #eee;">
              <label class="switch">
                <input type="checkbox" id="frac_${id_cat}" class="fraccion_checada" value="${id_cat}" fraccion="otros" padre="${id_padre}" onchange="fraccion_check_audi(this, ${id_persona_audi_fraccion},${id_cat})">
                <span class="slider round"></span>
              </label>
            </td>
          </tr>
        `;
      }

      $('#table_fracciones_e').append(tr);
    }
    
    function removeRow(obj,id_audi_fraccion, id_fraccion){

      if(id_audi_fraccion == 0 && id_fraccion == 16){
        fracciones_totales.pop()
      }else{
        for(i in fracciones_totales){
          if(fracciones_totales[i].id_cat == id_fraccion && fracciones_totales[i].id_fraccion_valor == id_audi_fraccion){
            fracciones_totales[i].fraccion_valor = 0;
            fracciones_totales[i].fraccion_descripcion_otros = null;
          }
        } 
      }

      $(obj).closest('tr').remove();
      console.log(fracciones_totales);
    }
    
    
    //Guardar o Actualizar informacion 
    function checkados_fracc(id_audiencia){
      var tipo = $('#checkados_fracc').attr('tipo');
      var id_persona = $('#lista_victimas').val();

      if(tipo == 'solicitud'){
        $.ajax({
          type:'post',
          url:'/public/guardar_fracciones_audiencia_f',
          data:{
            "id_audiencia": id_audiencia,
            "tipo":tipo,
            "fracciones": fracciones_totales
          },
          success:function(response) {
            console.log(response);
            if(response.status==100){
              $('#modalMedidasProteccion').modal('hide');
              var exito = "<p class='mg-b-20 mg-x-20'>Fracciones Agregadas Exitosamente</p>";
              modal_success(exito,'modalHistory');
              listaFracciones(id_audiencia);
            }else{
              var error = "<p class='mg-b-20 mg-x-20'>"+response.message+"</p>";
              modal_error(error,'modalHistory');
            }
          }
        });
      }else{
        $.ajax({
          type:'post',
          url:'/public/guardar_fracciones_audiencia_f',
          data:{
            "id_audiencia": id_audiencia,
            "tipo":tipo,
            "id_persona":id_persona,
            "fracciones": fracciones_totales
          },
          success:function(response) {
            console.log(response);
            if(response.status==100){
              $('#modalMedidasProteccion').modal('hide');
              var exito = "<p class='mg-b-20 mg-x-20'>Fracciones Actualizadas Exitosamente</p>";
              modal_success(exito,'modalHistory');
              listaFracciones(id_audiencia);
            }else{
              var error = "<p class='mg-b-20 mg-x-20'>"+response.message+"</p>";
              modal_error(error,'modalHistory');
            }
          }
        });
      }
      console.log('Fracciones a guardar',fracciones_totales);
    }

    //Acciones de los check segun el tipo de formato
    function fraccion_check_audi(obj,id_audi_fraccion, id_fraccion){
      var valor_solicitado = '';
      var id_padre = '';

      if($(obj).attr('padre') == 0){

        //valor solicitado
        if($(obj).is(':checked')){
          valor_solicitado = '1';
        }else{
          valor_solicitado = '0';
        }
        
        //accion para agregar el valor a padre e hijos
        if(valor_solicitado == '1'){  //agregar valor

          for(i in fracciones_totales){
            // padre
            if(fracciones_totales[i].id_fraccion_valor == id_audi_fraccion && fracciones_totales[i].id_cat == id_fraccion){
              if(id_fraccion == 16){
                if(fracciones_totales[i].fraccion_valor == '1'){
                  fracciones_totales.push({
                    "id_padre":fracciones_totales[i].id_padre,
                    "id_cat":fracciones_totales[i].id_cat,
                    "id_fraccion_valor":0,
                    "fraccion_valor":valor_solicitado,
                    "fraccion_descripcion_otros": $('.fr:last').val()
                  })
                }else{
                  fracciones_totales[i].fraccion_valor = valor_solicitado;
                  fracciones_totales[i].fraccion_descripcion_otros = $('.fr:last').val();
                }
              }else{
                fracciones_totales[i].fraccion_valor = valor_solicitado;
              }
            }

            //hijos
            if(fracciones_totales[i].id_padre == id_fraccion){
              fracciones_totales[i].fraccion_valor = valor_solicitado;
              $('#frac_'+fracciones_totales[i].id_cat).prop('checked',true);
            }

          }
        }else{ //quitar valor

          for(i in fracciones_totales){
            // padre
            if(fracciones_totales[i].id_fraccion_valor == id_audi_fraccion && fracciones_totales[i].id_cat == id_fraccion){
              fracciones_totales[i].fraccion_valor = valor_solicitado;
            }

            //hijos
            if(fracciones_totales[i].id_padre == id_fraccion){
              fracciones_totales[i].fraccion_valor = valor_solicitado;
              $('#frac_'+fracciones_totales[i].id_cat).prop('checked',false);
            }

          }
        }

      }else{
        id_padre = $(obj).attr('padre');

        if($(obj).is(':checked')){
          valor_solicitado = '1';
        }else{
          valor_solicitado = '0';
        }

        if(valor_solicitado == '1'){
          for(i in fracciones_totales){
            // padre
            if(fracciones_totales[i].id_fraccion_valor == id_audi_fraccion && fracciones_totales[i].id_cat == id_padre){
              fracciones_totales[i].fraccion_valor = valor_solicitado;
              $('#frac_'+fracciones_totales[i].id_padre).prop('checked',true);
            }

            //hijos
            if(fracciones_totales[i].id_fraccion_valor == id_audi_fraccion && fracciones_totales[i].id_padre == id_fraccion){
              fracciones_totales[i].fraccion_valor = valor_solicitado;
            }
          }
        }else if(valor_solicitado == '0'){
          for(i in fracciones_totales){
            //hijos
            if(fracciones_totales[i].id_fraccion_valor == id_audi_fraccion && fracciones_totales[i].id_cat == id_fraccion){
              fracciones_totales[i].fraccion_valor = valor_solicitado;
            }
          }
        }

      }

      console.log(fracciones_totales)
    }

    function fraccion_check(obj,id_persona, id_fraccion){
      var valor_solicitado = '';
      var id_padre = '';

      if($(obj).attr('padre') == 0){

        if($(obj).is(':checked')){
          valor_solicitado = '1';
        }else{
          valor_solicitado = '0';
        }
        
        if(valor_solicitado == '1'){ //agregar valor

          for(i in fracciones_totales){
            // padre
            if(fracciones_totales[i].id_persona == id_persona && fracciones_totales[i].id_fraccion == id_fraccion){
              if(id_fraccion == 16){
                if(fracciones_totales[i].valor_solicitado == '1'){
                  fracciones_totales.push({
                    "id_persona":id_persona,              
                    "id_fraccion": id_fraccion,
                    "valor_solicitado":valor_solicitado,
                    "descripcion_otros":$('.fr:last').val(),
                    "fraccion": fracciones_totales[i].fraccion,
                    "id_padre": fracciones_totales[i].id_padre
                  })
                }else{
                  fracciones_totales[i].valor_solicitado = valor_solicitado;
                  fracciones_totales[i].descripcion_otros = $('.fr:last').val();
                }
              }else{
                fracciones_totales[i].valor_solicitado = valor_solicitado;
              }
            }

            //hijos
            if(fracciones_totales[i].id_persona == id_persona && fracciones_totales[i].id_padre == id_fraccion){
              fracciones_totales[i].valor_solicitado = valor_solicitado;
              $('#frac_'+fracciones_totales[i].id_fraccion).prop('checked',true);
            }

          }
        }else{

          for(i in fracciones_totales){
            // padre
            if(fracciones_totales[i].id_persona == id_persona && fracciones_totales[i].id_fraccion == id_fraccion){
              fracciones_totales[i].valor_solicitado = valor_solicitado;
            }

            //hijos
            if(fracciones_totales[i].id_persona == id_persona && fracciones_totales[i].id_padre == id_fraccion){
              fracciones_totales[i].valor_solicitado = valor_solicitado;
              $('#frac_'+fracciones_totales[i].id_fraccion).prop('checked',false);
            }

          }
        }

      }else{
        id_padre = $(obj).attr('padre');

        if($(obj).is(':checked')){
          valor_solicitado = '1';
        }else{
          valor_solicitado = '0';
        }

        if(valor_solicitado == '1'){
          for(i in fracciones_totales){
            // padre
            if(fracciones_totales[i].id_persona == id_persona && fracciones_totales[i].id_fraccion == id_padre){
              fracciones_totales[i].valor_solicitado = valor_solicitado;
              $('#frac_'+fracciones_totales[i].id_padre).prop('checked',true);
            }

            //hijos
            if(fracciones_totales[i].id_persona == id_persona && fracciones_totales[i].id_padre == id_fraccion){
              fracciones_totales[i].valor_solicitado = valor_solicitado;
            }
          }
        }else if(valor_solicitado == '0'){
          for(i in fracciones_totales){
            //hijos
            if(fracciones_totales[i].id_persona == id_persona && fracciones_totales[i].id_fraccion == id_fraccion){
              fracciones_totales[i].valor_solicitado = valor_solicitado;
            }
          }
        }

      }

      console.log(fracciones_totales)
    }

    //#############################################################
    
    //{{--  Condiciones de de suspension de proceso  --}}
    function obtener_CondicionS(folio,id_audiencia,pagina_accion){
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
              "id_audiencia": id_audiencia,
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
    
                      if(datas[j]['inactividad'] == 1){
                        color = 'green';
                        estado = 'Activo';
                      }else{
                        color= 'red';
                        estado = 'Inactivo';
                      }

                      let permiso = '';
                      if(datas[j]['apertura_resolutivos'] == 1){
                        permiso = `
                          <i class="fas fa-trash-alt acciones2" data-toggle="tooltip-primary" data-placement="top" title="Eliminar resolutivo" style="cursor:pointer; background: #A72424;" onclick="modalEliminar(${datas[j]['id_audiencia_mproteccion_csuspension']},${datas[j]['id_audiencia']}, 6)"></i>
                          <i class="fas fa-edit acciones2" data-toggle="tooltip-primary" style="cursor:pointer;" data-placement="top" title="Editar resolutivo" onclick="cargarCamposEditarCondicionS(${datas[j]['id_audiencia_mproteccion_csuspension']},${datas[j]['id_audiencia']},'${datas[j]['folio_carpeta']}', ${datas[j]['id_imputado']}, ${datas[j]['id_condicion_suspencion']} , '${datas[j]['especificaciones']}' , ${datas[j]['estatus']},'${datas[j]['fecha_inicio']}','${datas[j]['fecha_fin']}')"></i>
                        `;
                      }else{
                        permiso = '<span style="color: #CB4335; margin-right:2%">Se ha finalizado la captura</span>';
                      }
    
                      body += `<tr>
                                  <td> ${permiso}</td> 
                                  <td> ${datas[j]['imputado']}            </td>
                                  <td> ${datas[j]['nombre_condicion']}   </td> 
                                  <td> ${datas[j]['especificaciones']} </td>
                                  <td> ${datas[j]['fecha_inicio']} </td>
                                  <td> ${datas[j]['fecha_fin']} </td>
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
    
    function agregarCondicionS(folio, id_audiencia){

      let datosCarpeta = carpetaActiva;

      let imputados = '<option value="-" diabled>Seleccionar</option>';
      for(i in datosCarpeta.imputados){
        imputados += `<option value="${datosCarpeta.imputados[i].id_persona}">${ datosCarpeta.imputados[i].tipo == 'fisica' ? datosCarpeta.imputados[i].nombre : datosCarpeta.imputados[i].razon_social}</option>`;
      }

      html = `
        <div class="row">
          <div class="col-lg-12">
          <form action="" id="frm_condicionS">
            <input type="hidden" id="cmp_condicionS_folioC" value="${folio}">
            <input type="hidden" id="cmp_condicionS_id_audiencia" value="${id_audiencia}">
            <input type="hidden" id="cmp_condicionS_bandera" value="Suspension">

            <div class="row">
              <div class="col-md-4">
                <div class="form-group text-left">
                  <label class="form-control-label">Imputado:</label>
                  <select class="form-control select2" id="cmp_condicionS_imputado" name ="cmp_condicionS_imputado" autocomplete="off">
                    ${imputados}
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group text-left">
                  <label class="form-control-label">Fecha Inicio:</label>
                  <input type="text" id="cmp_condicionS_fecha_inicio" name="cmp_condicionS_fecha_inicio" class="form-control date_fif cal">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group text-left">
                  <label class="form-control-label">Fecha fin:</label>
                  <input type="text" id="cmp_condicionS_fecha_fin" name="cmp_condicionS_fecha_fin" class="form-control date_fif cal">
                </div>
              </div>
            </div>

            <div class="form-group text-left">
              <label class="form-control-label">Condicion de suspensión:</label>
              <select class="form-control select2" id="cmp_condicionS_medida" name ="cmp_condicionS_medida" autocomplete="off">
              </select>
            </div>

            <div class="form-group text-left">
              <label class="form-control-label">Comentarios adicionales:</label>
              <textarea class="form-control" id="cmp_condicionS_comentarios" rows="3"></textarea>
            </div>

          </form>

          </div>
        </div>
      `;


      $('#modalHistory').modal('hide');
      $('#bodyCondicionS').html(html);
      $('#modalCondicionS').modal('show');
      
      setTimeout(function(){
        $('.select2').select2({placeholder: 'Seleccionar'});
        $('.calendar').datepicker({dateFormat:'yy-mm-dd',firstDay: 1}).datepicker("setDate", new Date());
        let fecha_actual = new Date();
        $('.cal').datepicker({
          showOtherMonths: true,
          selectOtherMonths: true,
          dateFormat: 'yy-mm-dd',
          changeYear: true,
          yearRange: "c-100:" + (fecha_actual.getFullYear() + 5)
        });

        $.ajax({
          type:'post',
          url:'/public/obtener_CondicionesSuspension',
          data:{
          },
          success:function(response) {
            body = '';
            if(response.status==100){
                var datas = response.response;
                //console.log(datas);
                body='<option value="-" disabled>Seleccionar</option>';
                for (var j = 0; j < datas.length; j++) {
                  body += `<option value="${datas[j]['id_condicion_s']}">${datas[j]['nombre_condicion']}</option>`;
                }
              $("#cmp_condicionS_medida").html(body);
      
            }else{
              body = body.concat('<option value="">Seleccione Condicion de Suspensión</option>');
              $("#cmp_condicionS_medida").html(body);
      
            }
          }
        });
      },600)

    }
    
    function guardarCondicionS(){
      cmp_condicionS_folioC = $('#cmp_condicionS_folioC').val();
      cmp_condicionS_id_audiencia =  $('#cmp_condicionS_id_audiencia').val();
      cmp_condicionS_bandera = $('#cmp_condicionS_bandera').val();
      cmp_condicionS_imputado = $('#cmp_condicionS_imputado').val();
      cmp_condicionS_medida = $('#cmp_condicionS_medida').val();
      cmp_condicionS_comentarios = $('#cmp_condicionS_comentarios').val();
      id_condicion_proteccion = null;
      cmp_condicionS_fecha_inicio = $('#cmp_condicionS_fecha_fin').val();
      cmp_condicionS_fecha_fin = $('#cmp_condicionS_fecha_fin').val();
      condicionS = $('select[name="cmp_condicionS_medida"] option:selected').text();

      $.ajax({
        type:'post',
        url:'/public/guardarMedidaP',
        data:{
          "id_imputado":cmp_condicionS_imputado,
          "id_solicitud":carpetaActiva.id_solicitud,
          "id_medida_proteccion":id_condicion_proteccion,
          "id_condicion_suspencion":cmp_condicionS_medida,
          "folio_carpeta":cmp_condicionS_folioC,
          "especificaciones":cmp_condicionS_comentarios,
          "bandera":cmp_condicionS_bandera,
          "id_audiencia":cmp_condicionS_id_audiencia,
          "fecha_inicio": cmp_condicionS_fecha_inicio,
          "fecha_fin":cmp_condicionS_fecha_fin
        },
        success:function(response) {
          body = '';
          if(response.status==100){
            $('#modalCondicionS').modal('hide');
            var exito = "<p class='mg-b-20 mg-x-20'>Condición de proceso de suspensión agregada correctamente </p>";
            modal_success(exito,'modalHistory');
            obtener_CondicionS(cmp_condicionS_folioC,cmp_condicionS_id_audiencia,'primera');
          }else{
            $('#modalCondicionS').modal('hide');
            var error = "<p class='mg-b-20 mg-x-20'>"+response.message+"</p>";
            modal_error(error,'modalHistory');
          }
        }
      });
    }
    
    function cargarCamposEditarCondicionS(id_audiencia_mproteccion_csuspension,id_audiencia,folio_carpeta,id_imputado,id_medida_suspension, especificaciones, estatus,cmp_condicionS_fecha_inicio_E, cmp_condicionS_fecha_fin_E){
      
      let datosCarpeta = carpetaActiva;

      let imputados = '<option value="-" diabled>Seleccionar</option>';
      for(i in datosCarpeta.imputados){
        imputados += `<option  ${datosCarpeta.imputados[i].id_persona == id_imputado ? 'selected' : ''} value="${datosCarpeta.imputados[i].id_persona}">${ datosCarpeta.imputados[i].tipo == 'fisica' ? datosCarpeta.imputados[i].nombre : datosCarpeta.imputados[i].razon_social}</option>`;
      }

      let estatus1 = '';
      if(estatus == 1){
        estatus1 =`
          <option value="-">Seleccionar</option>
          <option selected value="1">Activo</option>
          <option value="0">Inactivo</option>
        `;
      }else{
        estatus1 =`
          <option value="-">Seleccionar</option>
          <option value="1">Activo</option>
          <option selected value="0">Inactivo</option>
        `;
      }


      html = `
        <div class="row">
          <div class="col-lg-12">
          <form action="" id="frm_condicionS_E">
            <input type="hidden" id="cmp_condicionS_folioC_E" value="${folio_carpeta}">
            <input type="hidden" id="cmp_condicionS_id_audiencia_E" value="${id_audiencia}">
            <input type="hidden" id="cmp_condicionS_id_audiencia_medida_cautelar_E" value="${id_audiencia_mproteccion_csuspension}">
            <input type="hidden" id="cmp_condicionS_bandera_E" value="Suspension">

            <div class="row">
              <div class="col-sm-12 col-md-8 col-lg-8">
                <div class="form-group text-left">
                  <label class="form-control-label">Imputado:</label>
                  <select class="form-control select2" id="cmp_condicionS_imputado_E" name ="cmp_condicionS_imputado_E" autocomplete="off">
                    ${imputados}
                  </select>
                </div>
              </div>
              <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group text-left">
                    <label>Estatus:</label>
                    <select class="form-control select2" id="cmp_condicionS_estatus_E" name="cmp_condicionS_estatus_E">
                      ${estatus1}
                    </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-4">
                <div class="form-group text-left">
                  <label class="form-control-label">Fecha Inicio:</label>
                  <input type="text" id="cmp_condicionS_fecha_inicio_E" name="cmp_condicionS_fecha_inicio_E" value="${cmp_condicionS_fecha_inicio_E}" class="form-control date_fif cal">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group text-left">
                  <label class="form-control-label">Fecha fin:</label>
                  <input type="text" id="cmp_condicionS_fecha_fin_E" name="cmp_condicionS_fecha_fin_E" value="${cmp_condicionS_fecha_fin_E}" class="form-control date_fif cal">
                </div>
              </div>
            </div>

            <div class="form-group text-left">
              <label class="form-control-label">Condicion de Suspensión:</label>
              <select class="form-control select2" id="cmp_condicionS_medida_E" name ="cmp_condicionS_medida_E" autocomplete="off" onchange="elegir_menu_cautelar(this)">
              </select>
            </div>

            <div class="form-group text-left">
              <label class="form-control-label">Comentarios adicionales:</label>
              <textarea class="form-control" value="${especificaciones}" id="cmp_condicionS_comentarios_E" rows="3">${especificaciones}</textarea>
            </div>

          </form>

          </div>
        </div>
      `;
    
      $('#bodyCondicionS_E').html(html);
      $('#modalCondicionS_E').modal('show');
      $('#modalHistory').modal('hide');

      setTimeout(function(){
        $('.select2').select2({placeholder: 'Seleccionar'});
        $('.calendar').datepicker({dateFormat:'yy-mm-dd',firstDay: 1}).datepicker("setDate", new Date());
        let fecha_actual = new Date();
        $('.cal').datepicker({
          showOtherMonths: true,
          selectOtherMonths: true,
          dateFormat: 'yy-mm-dd',
          changeYear: true,
          yearRange: "c-100:" + (fecha_actual.getFullYear() + 5)
        });

        $.ajax({
          type:'post',
          url:'/public/obtener_CondicionesSuspension',
          data:{
          },
          success:function(response) {
            body = '';
            if(response.status==100){
                var datas = response.response;
                //console.log(datas);
                body='<option value="-" disabled>Seleccionar</option>';
                for (var j = 0; j < datas.length; j++) {
                  body += `<option ${ datas[j]['id_condicion_s'] == id_medida_suspension ? 'selected' : ''}  value="${datas[j]['id_condicion_s']}">${datas[j]['nombre_condicion']}</option>`;
                }
              $("#cmp_condicionS_medida_E").html(body);
      
            }else{
              body = body.concat('<option value="">Seleccione Condicion de Suspensión</option>');
              $("#cmp_condicionS_medida_E").html(body);
            }
          }
        });
      },600)
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
    
      cmp_condicionS_fecha_inicio_E = $('#cmp_condicionS_fecha_inicio_E').val();
      cmp_condicionS_fecha_fin_E = $('#cmp_condicionS_fecha_fin_E').val();

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
          "fecha_inicio": cmp_condicionS_fecha_inicio_E,
          "fecha_fin":cmp_condicionS_fecha_fin_E
        },
        success:function(response) {
          body = '';
          if(response.status==100){
            $('#modalCondicionS_E').modal('hide');
            var exito = "<p class='mg-b-20 mg-x-20'>Condición de proceso de suspensión actualizada corectamente</p>";
            modal_success(exito,'modalHistory');
            obtener_CondicionS(cmp_condicionS_folioC_E,cmp_condicionS_id_audiencia_E,'primera');
          }else{
            $('#modalCondicionS_E').modal('hide');
            var error = "<p class='mg-b-20 mg-x-20'>"+response.message+"</p>";
            modal_error(error,'modalHistory');
          }
        }
      });
    }
  
  

    /**************
     *
     * FUNCIONES PARA EVENTOS EN CALEDARIO
     *
     * ***********/

    /*
      // scheduler_audiencia.templates.event_class = function(start,end,ev){
      //   return "event_bkg_"+ev.color;
      // };

      // scheduler_audiencia.attachEvent("onCellDblClick", function (x_ind, y_ind, x_val, y_val, e){
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
    */
  </script>
