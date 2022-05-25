{{-- Vida Carpeta --}}

<div id="accordionVidaCarpetaJudicial" class="accordion-one mg-b-10" role="tablist" aria-multiselectable="true" width="100%">
	<div class="card">
		<div class="card-header" role="tab" id="headingOne">
			<a id="titleAccordionVidaCarpetaJudicial" data-toggle="collapse" data-parent="#accordionVidaCarpetaJudicial" href="#collapseOneVidaCarpetaJudicial" aria-expanded="false" aria-controls="collapseOneVidaCarpetaJudicial" class="bkg-collapsed-btn-hover tx-gray-800 transition collapsed">
				Ver Historial de la Carpeta Judicial
			</a>
		</div><!-- card-header -->

		<div id="collapseOneVidaCarpetaJudicial" class="collapse" role="tabpanel" aria-labelledby="headingOneVidaCarpetaJudicial">
			<div class="card-body" style="height:auto; padding:0 !important;">
				<div class="mt-15">
					<div class="card pd-20">
						<div class="row" id="datosPrincipalesVCJ">

									<div class="card" style="width: 100%;">
											<div class="card-header">
												<a id="psss">	</a>
											</div>

											<div class="card-body">
												<div class="row">
													<div class="col-md-8">
														<div style="margin-bottom: 2%;">
															<div style="font-size:0.9em; text-transform: uppercase; font-weight:bold;padding: 5px;" >
																<i class="fas fa-users"></i> Imputado(s)
															</div>
															<div style="margin-left:2%;" id="pssd">
															</div>
														</div>
														<div>
															<div>
																<div style="font-size:0.9em; text-transform: uppercase; font-weight:bold;padding: 5px;" >
																	<i class="fas fa-user-friends"></i> Victima(s)
																</div>
																<div style="margin-left:2%; width: 70em; overflow-x: auto; white-space: nowrap; display: inline-block; height: 100px;;" id="pssf">
																</div>
															</div>
														</div>
													</div>
													<div class="col-md-4">
														<div style="width: 100%; border-bottom: 1px solid #ccc; padding: 6px; font-size: 0.9em; font-weight: bold; text-transform: uppercase; text-align: center; margin-bottom: 3%;">
															Hecho(s) delictivo(s)
														</div>
														<div  id="pssg">
														</div>
													</div>
												</div>
											</div>

									</div>
						</div>
						<br>
						<br>
						<h4 class="card-title mb-5 text-primary-green uc-label-primary" id="title-VCJ" align="center" style="font-size:18px;">Vida carpeta judicial</h4>
						<div class="row">
							<div class="col-md-1" style="font-weight: bold;">Etapas :</div>
							<div class="col-md-2"> <div class="bg-soft-etapa-inicial" style="border-radius: 4px; font-weight: bold;" align="center">Inicial</div> </div>
							<div class="col-md-2"> <div class="bg-soft-etapa-intermedia" style="border-radius: 4px; font-weight: bold;" align="center">Intermedia</div> </div>
							<div class="col-md-2"> <div class="bg-soft-etapa-juicio-oral" style="border-radius: 4px; font-weight: bold;" align="center">Juicio Oral</div> </div>
							<div class="col-md-2"> <div class="bg-soft-etapa-ejecucion" style="border-radius: 4px; font-weight: bold;" align="center">Ejecucion</div> </div>
							<div class="col-md-2"> <div class="bg-soft-etapa-ley-nacional" style="border-radius: 4px; font-weight: bold;" align="center">Ley Nacional</div> </div>
						</div>
						<br>

						<div class="card-custom-tl">
							<div class="hori-timeline" dir="ltr">
								<ul class="list-inline events d-flex flex-row" id="events-list-vcj">
								</ul>
							</div>
						</div><!-- end card -->
					</div>
				</div>
			</div> <!-- CARD BODY -->
		</div> <!-- BODY COLLAPSE -->

	</div> <!-- CARD -->
</div> <!-- ACCORDEON TODAS PARTES PROCESALES -->

	

  <style type="text/css" >

    #divAudiencias{
      overflow: auto !important;
    }

    #tableAudiencias{
      font-size:11px;
    }

    .tx-bold{
      font-weight:bold;
    }

		
		.hori-timeline .events {
			border-top: 4px solid rgba(176,183,129,.8) !important;
			overflow-x:auto;
		}
		.hori-timeline .events .event-list {
			display: block;
			position: relative;
			text-align: center;
			padding-top: 70px ;
			margin-right: 0;
			min-width: 250px;
		}
		.hori-timeline .events .event-list:before {
			content: "";
			position: absolute;
			height: 36px;
			border-right: 3px dashed rgba(176,183,129,.8) !important;
			top: 0;
		}
		.hori-timeline .events .event-list .event-date {
			/* position: absolute; */
			position: relative;
			top: -30px;
			left: 0;
			right: 0;
			width: 75px;
			margin: 0 auto;
			border-radius: 4px;
			padding: 2px 4px;
			min-width: 150px;
		}

		.card-custom-tl {
			border: none;
			margin-bottom: 24px;
			-webkit-box-shadow: 0 0 13px 0 rgba(236,236,241,.44);
			box-shadow: 0 0 13px 0 rgba(236,236,241,.44);
		}


		@media (min-width: 1140px) {
			.hori-timeline .events .event-list {
				display: inline-block;
				width: 24%;
				padding-top: 70px;
				min-width: 250px;
			}

			.hori-timeline .events .event-list .event-date {
				position: relative;
				top: -30px !important;
				left: 0;
				right: 0;
				width: 75px;
				margin: 0 auto;
				border-radius: 4px;
				padding: 2px 4px;
				min-width: 150px;
			}
		}

		.text-primary-green{
			color: #848961;
		}

		.bg-primary-green{
			background-color: #848961;
		}

		.uc-label-primary {
			font-size: 12px;
			font-weight: 700;
			color: #757a54;
			text-transform: uppercase;
			letter-spacing: 1px;
		}

		.uc-label-secondary {
			font-size: 13px;
			font-weight: 700;
			/* color: #343a40; */
			color: #6c757d;
			/* text-transform: uppercase; */
			letter-spacing: 1px;
		}
		
		/*
		
		.bg-soft-solicitud_inicial {
			background-color: rgba(230,126,34,.2 ) !important;
		}
		.text-solicitud_inicial{
			color: #ba4a00;
		}
		.text-soft-solicitud_inicial{
			color: rgba(230,126,34,.6 ) !important;
		}
		.btn-solicitud_inicial{
			background-color: rgba(230,126,34,.3 ) !important;
			color: #ba4a00;
		}



		.bg-soft-carpeta_judicial {
			background-color:rgba(46,204,113,.3) !important;
		}
		.text-carpeta_judicial{
			color: #1D8348;
		}
		.text-soft-carpeta_judicial{
			color: rgba(46,204,113,.7) !important;
		}
		.btn-carpeta_judicial{
			background-color: rgba(46,204,113,.3) !important;
			color: #1D8348;
		}

		*/

		.bg-soft-acuerdo {
			background-color:rgba(93, 173, 226 ,.3) !important;
		}
		.text-acuerdo{
			color: #1F618D;
		}
		.text-soft-acuerdo{
			color: rgba(93, 173, 226 ,.7) !important;
		}
		.btn-acuerdo{
			background-color: rgba(93, 173, 226 ,.3) !important;
			color: #1F618D;
		}


		.bg-soft-promocion {
			background-color:rgba(187, 143, 206 ,.3) !important;
		}
		.text-promocion{
			color: #7D3C98;
		}
		.text-soft-promocion{
			color: rgba(187, 143, 206 ,.9) !important;
		}
		.btn-promocion{
			background-color: rgba(187, 143, 206 ,.3) !important;
			color: #7D3C98;
		}


		.bg-soft-etapa-inicial {
			background-color: rgb(69, 179, 157,.15) !important;
			color: rgb(69, 179, 157);
		}

		.bg-soft-etapa-intermedia {
			background-color: rgb(247, 220, 111,.15) !important;
			color: rgb(247, 220, 111);
		}
		
		.bg-soft-etapa-juicio-oral {
			background-color: rgb(192, 57, 43,.15) !important;
			color: rgb(192, 57, 43);
		}
		
		.bg-soft-etapa-ejecucion {
			background-color: rgba(142, 68, 173,.15) !important;
			color: rgb(142, 68, 173);
		}

		.bg-soft-etapa-ley-nacional {
			background-color: rgba(23, 111, 230,.15) !important;
			color: rgb(23, 111, 230);
		}


		.bg-soft-evento-etapa-inicial {
			background-color:rgba(46,204,113,.3) !important;
		}
		.text-evento-etapa-inicial{
			color: #1D8348;
		}
		.text-soft-evento-etapa-inicial{
			color: rgba(46,204,113,.7) !important;
		}
		.btn-evento-etapa-inicial{
			background-color: rgba(46,204,113,.3) !important;
			color: #1D8348;
		}

		.bg-soft-evento-etapa-intermedia {
			background-color: rgba(230,126,34,.2 ) !important;
		}
		.text-evento-etapa-intermedia{
			color: #ba4a00;
		}
		.text-soft-evento-etapa-intermedia{
			color: rgba(230,126,34,.6 ) !important;
		}
		.btn-evento-etapa-intermedia{
			background-color: rgba(230,126,34,.3 ) !important;
			color: #ba4a00;
		}
		
		.bg-soft-evento-etapa-juicios-oral {
			background-color: rgba(242, 36, 36 ,.2 ) !important;
		}
		.text-evento-etapa-juicios-oral{
			color: #A93226;
		}
		.text-soft-evento-etapa-juicios-oral{
			color: rgba(242, 36, 36 ,.6 ) !important;
		}
		.btn-evento-etapa-juicios-oral{
			background-color: rgba(242, 36, 36 ,.3 ) !important;
			color: #A93226;
		}


		.bg-soft-evento-etapa-ejecucion {
			background-color:rgba(187, 143, 206 ,.3) !important;
		}
		.text-evento-etapa-ejecucion{
			color: #7D3C98;
		}
		.text-soft-evento-etapa-ejecucion{
			color: rgba(187, 143, 206 ,.9) !important;
		}
		.btn-evento-etapa-ejecucion{
			background-color: rgba(187, 143, 206 ,.3) !important;
			color: #7D3C98;
		}


		.bg-soft-evento-etapa-ley-nacional {
			background-color:rgba(23, 111, 230 ,.3) !important;
		}
		.text-evento-etapa-ley-nacional{
			color: #3C5C98;
		}
		.text-soft-evento-etapa-ley-nacional{
			color: rgba(23, 111, 230 ,.9) !important;
		}
		.btn-evento-etapa-ley-nacional{
			background-color: rgba(23, 111, 230 ,.3) !important;
			color: #3C5C98;
		}

  </style>
	
  <script>
		var arrEVCJ=[];

		const nombre_meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

		/*
		function loadConfigComponentLT(){
			$('#collapseOneVidaCarpetaJudicial').on('shown.bs.collapse', function () {
				pintarEventosLT();
				pintaInformacionPrincipalVCJ(); 
				hScroll(60);
			})
		}
		*/

		function hScroll (amount) {
			amount = amount || 120;
			$('#events-list-vcj').bind("DOMMouseScroll mousewheel", function (event) {
					var oEvent = event.originalEvent, 
							direction = oEvent.detail ? oEvent.detail * -amount : oEvent.wheelDelta, 
							position = $(this).scrollLeft();
					position += direction > 0 ? -amount : amount;
					$('#events-list-vcj').scrollLeft(position);
					event.preventDefault();
			})
		}

		function pintaInformacionPrincipalVCJ(){
			//$("#datosPrincipalesVCJ").empty();
			$('#psss').empty();
			$('#pssd').empty();
			$('#pssf').empty();
			$('#pssg').empty();

			$.ajax({
				method:'POST',
				url:'/public/obtener_carpetas_judiciales',
				data:{
					modo:"completo",
          carpeta_judicial:carpetaActiva.id_carpeta_judicial,
          pagina:1,
				},
				success:function(response){
					console.log(response);
					if(response.status==100){
						let cj = response.response[0];
						
						let liimputados=``;
						if(cj.imputados.length){
							$(cj.imputados).each(function(index_d, imputado){
								if(index_d == (cj.imputados.length - 1 )){
									liimputados +=`${imputado.razon_social==null?'':imputado.razon_social}${imputado.nombre==null?'':imputado.nombre}`;
								}else{
									liimputados += `${imputado.razon_social==null?'':imputado.razon_social}${imputado.nombre==null?'':imputado.nombre}, `;
								}
							});
						}

						let livictimas=``;
						if(cj.victimas.length){
							livictimas=livictimas.concat(`<ul>`);
							$(cj.victimas).each(function(index_d, victima){
								livictimas=livictimas.concat(`<li>${victima.razon_social==null?'':victima.razon_social}${victima.nombre==null?'':victima.nombre} </li>`);
								/*
								if(index_d == (cj.victimas.length - 1 )){
									livictimas=livictimas.concat(`${victima.razon_social==null?'':victima.razon_social}${victima.nombre==null?'':victima.nombre} `);
								}else{
									livictimas=livictimas.concat(`${victima.razon_social==null?'':victima.razon_social}${victima.nombre==null?'':victima.nombre}, `);
								}
								*/
							});
							livictimas=livictimas.concat(`</ul>`);
						}

						let lidelitos=``;
						if(cj.delitos.length){
							$(cj.delitos).each(function(index_d, delito){
								lidelitos=lidelitos.concat(`${delito.delito}<br>`);
							});
						}


						$('#psss').append(`<i class="fas fa-folder"></i> Carpeta Judicial : ${carpetaActiva.folio_carpeta}`);
						$('#pssd').append(`${liimputados.length ? liimputados :'Sin imputados'}`);
						$('#pssf').append(`${livictimas.length ? livictimas:'Sin victimas'}`);
						$('#pssg').append(`${lidelitos.length ? lidelitos:'Sin delitos'}`);
					}
				}

			});
			//$("#datosPrincipalesVCJ").html(``);
			/*
				<div class="col-md-12"> <span class="uc-label-primary"> Carpeta Judicial: </span> ${carpetaActiva.folio_carpeta} </div>
				<div class="col-md-12"> <span class="uc-label-primary"> Hecho(s) delictivo(s): </span> ${lidelitos.length?lidelitos:'Sin delitos'} </div>
				<div class="col-md-6"> <span class="uc-label-primary"> Imputado(s): </span> ${liimputados.length?liimputados:'Sin imputados'} </div>
				<div class="col-md-6"> <span class="uc-label-primary"> Victima(s): </span> ${livictimas.length?livictimas:'Sin victimas'} </div>
			*/
		}

		function pintarEventosLT(){
			//return true;
			$.ajax({
				method:'GET',
				url:'/public/consulta_vida_carpeta',
				data:{
					id_carpeta : $("#id_carpeta_judicial").val(),
					id_solicitud : $("#id_solicitud").val(),
					tipo_solicitud : $("#tipo_solicitud").val(),
				},
				success:function(response){
					$("#events-list-vcj").empty();
					console.log('Vida Carpeta',response);

					if(response.status==100){

						_control = response.response.control;
						_TE = response.response.TE;
						_LN = response.response.LN;
						_EJEC = response.response.EJEC;

						arrEVCJ = response.response

						let lieventos = ``;

						// CONTROL
						for(i = 0; i < _control.length; i++){
							class_etapa = 'inicial';
							class_etapa_juicio = 'juicio_oral';

							// Se revisa cada seccion si tiene datos
							if(_control[i].solicitudes.length > 0){//## SOLICITUDES ##

								for(k = 0; k < _control[i].solicitudes.length; k++){ //iteramos los datos de cada seccion 
									let fecha_evento = new Date( _control[i].solicitudes[k].fecha_evento );
						
									lieventos += `<li class="list-inline-item event-list bg-soft-etapa-${class_etapa}">
																	<div class="px-4">
																		<div class="event-date bg-soft-evento-etapa-${class_etapa} text-evento-etapa-${class_etapa}">${_control[i].solicitudes[k].fecha_evento.split('-')[2]} ${nombre_meses[fecha_evento.getMonth()]} ${fecha_evento.getFullYear()}</div>
																		<h5 class="font-size-16 text-soft-evento-etapa-${class_etapa}">${ _control[i].solicitudes[k].tipo_evento.replaceAll('_',' ').toUpperCase() }</h5>
																		<p class="text-evento-etapa-${class_etapa}">${_control[i].solicitudes[k].acontecimiento}</p>
																		<div>
																			<a href="#" class="btn btn-evento-etapa-${class_etapa} btn-sm" onClick="muestraDetalles('${_control[i].solicitudes[k].tipo_evento}', ${_control[i].solicitudes[k].numero_identificador})">Ver más</a>
																		</div>
																		<br>
																	</div>
																</li>`;
								}
							}

							if(_control[i].acuerdos.length > 0){// ## ACUERDOS ##
								for(k = 0; k < _control[i].acuerdos.length; k++){	
									let fecha_evento = new Date( _control[i].acuerdos[k].fecha_evento );
									let tipo_evento = '';
									
									if(_control[i].acuerdos[k].fecha_evento.length > 10 ){
										fecha_evento_s = _control[i].acuerdos[k].fecha_evento.substring(0,10);
									}else{
										fecha_evento_s = _control[i].acuerdos[k].fecha_evento;
									}

									lieventos += `<li class="list-inline-item event-list bg-soft-etapa-${class_etapa}">
																	<div class="px-4">
																		<div class="event-date bg-soft-evento-etapa-${class_etapa} text-evento-etapa-${class_etapa}">${fecha_evento_s.split('-')[2]} ${nombre_meses[fecha_evento.getMonth()]} ${fecha_evento.getFullYear()}</div>
																		<h5 class="font-size-16 text-soft-evento-etapa-${class_etapa}">${ _control[i].acuerdos[k].tipo_evento.replaceAll('_',' ').toUpperCase() }</h5>
																		<p class="text-evento-etapa-${class_etapa}">${_control[i].acuerdos[k].acontecimiento}</p>
																		<div>
																			<a href="#" class="btn btn-evento-etapa-${class_etapa} btn-sm" onClick="muestraDetalles('acuerdo',${_control[i].acuerdos[k].numero_identificador})">Ver más</a>
																		</div>
																		<br>
																	</div>
																</li>`;
								}
							}
					
							if(_control[i].audiencias.length > 0){//## AUDIENCIAS ##
								for(k = 0; k < _control[i].audiencias.length; k++){

									if(_control[i].audiencias[k].audiencias_juicio_oral.length > 0 ){
										for(j in _control[i].audiencias[k].audiencias_juicio_oral){
											let fecha_evento = new Date( _control[i].audiencias[k].audiencias_juicio_oral[j].fecha_evento );
											let tipo_evento = '';
											lieventos += `<li class="list-inline-item event-list bg-soft-etapa-${class_etapa}">
																			<div class="px-4">
																				<div class="event-date bg-soft-evento-etapa-${class_etapa} text-evento-etapa-${class_etapa}">${_control[i].audiencias[k].audiencias_juicio_oral[j].fecha_evento.split('-')[2]} ${nombre_meses[fecha_evento.getMonth()]} ${fecha_evento.getFullYear()}</div>
																				<h5 class="font-size-16 text-soft-evento-etapa-${class_etapa}">${ _control[i].audiencias[k].audiencias_juicio_oral[j].tipo_evento.replaceAll('_',' ').toUpperCase() }</h5>
																				<p class="text-evento-etapa-${class_etapa}">${_control[i].audiencias[k].audiencias_juicio_oral[j].acontecimiento}</p>
																				<div>
																					<a href="#" class="btn btn-evento-etapa-${class_etapa} btn-sm" onClick="muestraDetalles('audiencia',${_control[i].audiencias[k].audiencias_juicio_oral[j].numero_identificador})">Ver más</a>
																				</div>
																				<br>
																			</div>
																		</li>`;
										}
									}

									if(_control[i].audiencias[k].audiencias.length > 0 ){
										for(j in _control[i].audiencias[k].audiencias){
											let fecha_evento = new Date( _control[i].audiencias[k].audiencias[j].fecha_evento );
											let tipo_evento = '';
											lieventos += `<li class="list-inline-item event-list bg-soft-etapa-${class_etapa}">
																			<div class="px-4">
																				<div class="event-date bg-soft-evento-etapa-${class_etapa} text-evento-etapa-${class_etapa}">${_control[i].audiencias[k].audiencias[j].fecha_evento.split('-')[2]} ${nombre_meses[fecha_evento.getMonth()]} ${fecha_evento.getFullYear()}</div>
																				<h5 class="font-size-16 text-soft-evento-etapa-${class_etapa}">${ _control[i].audiencias[k].audiencias[j].tipo_evento.replaceAll('_',' ').toUpperCase() }</h5>
																				<p class="text-evento-etapa-${class_etapa}">${_control[i].audiencias[k].audiencias[j].acontecimiento}</p>
																				<div>
																					<a href="#" class="btn btn-evento-etapa-${class_etapa} btn-sm" onClick="muestraDetalles('audiencia',${_control[i].audiencias[k].audiencias[j].numero_identificador} )">Ver más</a>
																				</div>
																				<br>
																			</div>
																		</li>`;
										}
									}
								}
							}

							if(_control[i].documentos.length > 0){//## DOCUMENTOS ##
								for(k = 0; k < _control[i].documentos.length; k++){	
									let fecha_evento = new Date( _control[i].documentos[k].fecha_evento );
									let tipo_evento = '';
									lieventos += `<li class="list-inline-item event-list bg-soft-etapa-${class_etapa}">
																	<div class="px-4">
																		<div class="event-date bg-soft-evento-etapa-${class_etapa} text-evento-etapa-${class_etapa}">${_control[i].documentos[k].fecha_evento.split('-')[2]} ${nombre_meses[fecha_evento.getMonth()]} ${fecha_evento.getFullYear()}</div>
																		<h5 class="font-size-16 text-soft-evento-etapa-${class_etapa}">${ _control[i].documentos[k].tipo_evento.replaceAll('_',' ').toUpperCase() }</h5>
																		<p class="text-evento-etapa-${class_etapa}">${_control[i].documentos[k].acontecimiento}</p>
																		<div>
																			<a href="#" class="btn btn-evento-etapa-${class_etapa} btn-sm" onClick="muestraDetalles('documento', ${_control[i].documentos[k].numero_identificador})">Ver más</a>
																		</div>
																		<br>
																	</div>
																</li>`;
								}
							}

							if(_control[i].promociones.length > 0){//## PROMOCIONES ##
								for(k = 0; k < _control[i].promociones.length; k++){	
										let fecha_evento = new Date( _control[i].promociones[k].fecha_evento );
										let tipo_evento = '';
										lieventos += `<li class="list-inline-item event-list bg-soft-etapa-${class_etapa}">
																		<div class="px-4">
																			<div class="event-date bg-soft-evento-etapa-${class_etapa} text-evento-etapa-${class_etapa}">${_control[i].promociones[k].fecha_evento.split('-')[2]} ${nombre_meses[fecha_evento.getMonth()]} ${fecha_evento.getFullYear()}</div>
																			<h5 class="font-size-16 text-soft-evento-etapa-${class_etapa}">${ _control[i].promociones[k].tipo_evento.replaceAll('_',' ').toUpperCase() }</h5>
																			<p class="text-evento-etapa-${class_etapa}">${_control[i].promociones[k].acontecimiento}</p>
																			<div>
																				<a href="#" class="btn btn-evento-etapa-${class_etapa} btn-sm" onClick="muestraDetalles('promocion', ${_control[i].promociones[k].numero_identificador})">Ver más</a>
																			</div>
																			<br>
																		</div>
																	</li>`;
								}
							}

						}
						
						// TE
						for(i = 0; i < _TE.length; i++){
							class_etapa = 'intermedia';
							class_etapa_juicio = 'juicio_oral';

							// Se revisa cada seccion si tiene datos
							if(_TE[i].solicitudes.length > 0){//## SOLICITUDES ##

								for(k = 0; k < _TE[i].solicitudes.length; k++){ //iteramos los datos de cada seccion 
									let fecha_evento = new Date( _TE[i].solicitudes[k].fecha_evento );
						
									lieventos += `<li class="list-inline-item event-list bg-soft-etapa-${class_etapa}">
																	<div class="px-4">
																		<div class="event-date bg-soft-evento-etapa-${class_etapa} text-evento-etapa-${class_etapa}">${_TE[i].solicitudes[k].fecha_evento.split('-')[2]} ${nombre_meses[fecha_evento.getMonth()]} ${fecha_evento.getFullYear()}</div>
																		<h5 class="font-size-16 text-soft-evento-etapa-${class_etapa}">${ _TE[i].solicitudes[k].tipo_evento.replaceAll('_',' ').toUpperCase() }</h5>
																		<p class="text-evento-etapa-${class_etapa}">${_TE[i].solicitudes[k].acontecimiento}</p>
																		<div>
																			<a href="#" class="btn btn-evento-etapa-${class_etapa} btn-sm" onClick="muestraDetalles('Solicitud_TE',${_TE[i].solicitudes[k].numero_identificador})">Ver más</a>
																		</div>
																		<br>
																	</div>
																</li>`;
								}
							}

							if(_TE[i].acuerdos.length > 0){// ## ACUERDOS ##
								for(k = 0; k < _TE[i].acuerdos.length; k++){	
									let fecha_evento = new Date( _TE[i].acuerdos[k].fecha_evento );
									let tipo_evento = '';
									
									if(_TE[i].acuerdos[k].fecha_evento.length > 10 ){
										fecha_evento_s = _TE[i].acuerdos[k].fecha_evento.substring(0,10);
									}else{
										fecha_evento_s = _TE[i].acuerdos[k].fecha_evento;
									}

									lieventos += `<li class="list-inline-item event-list bg-soft-etapa-${class_etapa}">
																	<div class="px-4">
																		<div class="event-date bg-soft-evento-etapa-${class_etapa} text-evento-etapa-${class_etapa}">${fecha_evento_s.split('-')[2]} ${nombre_meses[fecha_evento.getMonth()]} ${fecha_evento.getFullYear()}</div>
																		<h5 class="font-size-16 text-soft-evento-etapa-${class_etapa}">${ _TE[i].acuerdos[k].tipo_evento.replaceAll('_',' ').toUpperCase() }</h5>
																		<p class="text-evento-etapa-${class_etapa}">${_TE[i].acuerdos[k].acontecimiento}</p>
																		<div>
																			<a href="#" class="btn btn-evento-etapa-${class_etapa} btn-sm" onClick="muestraDetalles('acuerdo',${_TE[i].acuerdos[k].numero_identificador})">Ver más</a>
																		</div>
																		<br>
																	</div>
																</li>`;
								}
							}
					
							if(_TE[i].audiencias.length > 0){//## AUDIENCIAS ##
								for(k = 0; k < _TE[i].audiencias.length; k++){
									if(_TE[i].audiencias[k].audiencias_juicio_oral.length > 0 ){
										for(j in _TE[i].audiencias[k].audiencias_juicio_oral){

											let fecha_evento = new Date( _TE[i].audiencias[k].audiencias_juicio_oral[j].fecha_evento );
											let tipo_evento = '';
											lieventos += `<li class="list-inline-item event-list bg-soft-etapa-${class_etapa_juicio}">
																			<div class="px-4">
																				<div class="event-date bg-soft-evento-etapa-${class_etapa_juicio} text-evento-etapa-${class_etapa_juicio}">${_TE[i].audiencias[k].audiencias_juicio_oral[j].fecha_evento.split('-')[2]} ${nombre_meses[fecha_evento.getMonth()]} ${fecha_evento.getFullYear()}</div>
																				<h5 class="font-size-16 text-soft-evento-etapa-${class_etapa_juicio}">${ _TE[i].audiencias[k].audiencias_juicio_oral[j].tipo_evento.replaceAll('_',' ').toUpperCase() }</h5>
																				<p class="text-evento-etapa-${class_etapa_juicio}">${_TE[i].audiencias[k].audiencias_juicio_oral[j].acontecimiento}</p>
																				<div>
																					<a href="#" class="btn btn-evento-etapa-${class_etapa_juicio} btn-sm" onClick="muestraDetalles('audiencia',${_TE[i].audiencias[k].audiencias_juicio_oral[j].numero_identificador})">Ver más</a>
																				</div>
																				<br>
																			</div>
																		</li>`;
										}
									}

									if(_TE[i].audiencias[k].audiencias.length > 0 ){
										for( j  in _TE[i].audiencias[k].audiencias){
											let fecha_evento = new Date( _TE[i].audiencias[k].audiencias[j].fecha_evento );
											let tipo_evento = '';
											lieventos += `<li class="list-inline-item event-list bg-soft-etapa-${class_etapa}">
																			<div class="px-4">
																				<div class="event-date bg-soft-evento-etapa-${class_etapa} text-evento-etapa-${class_etapa}">${_TE[i].audiencias[k].audiencias[j].fecha_evento.split('-')[2]} ${nombre_meses[fecha_evento.getMonth()]} ${fecha_evento.getFullYear()}</div>
																				<h5 class="font-size-16 text-soft-evento-etapa-${class_etapa}">${ _TE[i].audiencias[k].audiencias[j].tipo_evento.replaceAll('_',' ').toUpperCase() }</h5>
																				<p class="text-evento-etapa-${class_etapa}">${_TE[i].audiencias[k].audiencias[j].acontecimiento}</p>
																				<div>
																					<a href="#" class="btn btn-evento-etapa-${class_etapa} btn-sm" onClick="muestraDetalles('audiencia',${_TE[i].audiencias[k].audiencias[j].numero_identificador} )">Ver más</a>
																				</div>
																				<br>
																			</div>
																		</li>`;
										}
									}
								}
							}

							if(_TE[i].documentos.length > 0){//## DOCUMENTOS ##
								for(k = 0; k < _TE[i].documentos.length; k++){	
									let fecha_evento = new Date( _TE[i].documentos[k].fecha_evento );
									let tipo_evento = '';
									lieventos += `<li class="list-inline-item event-list bg-soft-etapa-${class_etapa}">
																	<div class="px-4">
																		<div class="event-date bg-soft-evento-etapa-${class_etapa} text-evento-etapa-${class_etapa}">${_TE[i].documentos[k].fecha_evento.split('-')[2]} ${nombre_meses[fecha_evento.getMonth()]} ${fecha_evento.getFullYear()}</div>
																		<h5 class="font-size-16 text-soft-evento-etapa-${class_etapa}">${ _TE[i].documentos[k].tipo_evento.replaceAll('_',' ').toUpperCase() }</h5>
																		<p class="text-evento-etapa-${class_etapa}">${_TE[i].documentos[k].acontecimiento}</p>
																		<div>
																			<a href="#" class="btn btn-evento-etapa-${class_etapa} btn-sm" onClick="muestraDetalles('documento', ${_TE[i].documentos[k].numero_identificador})">Ver más</a>
																		</div>
																		<br>
																	</div>
																</li>`;
								}
							}

							if(_TE[i].promociones.length > 0){//## PROMOCIONES ##
								for(k = 0; k < _TE[i].promociones.length; k++){	
										let fecha_evento = new Date( _TE[i].promociones[k].fecha_evento );
										let tipo_evento = '';
										lieventos += `<li class="list-inline-item event-list bg-soft-etapa-${class_etapa}">
																		<div class="px-4">
																			<div class="event-date bg-soft-evento-etapa-${class_etapa} text-evento-etapa-${class_etapa}">${_TE[i].promociones[k].fecha_evento.split('-')[2]} ${nombre_meses[fecha_evento.getMonth()]} ${fecha_evento.getFullYear()}</div>
																			<h5 class="font-size-16 text-soft-evento-etapa-${class_etapa}">${ _TE[i].promociones[k].tipo_evento.replaceAll('_',' ').toUpperCase() }</h5>
																			<p class="text-evento-etapa-${class_etapa}">${_TE[i].promociones[k].acontecimiento}</p>
																			<div>
																				<a href="#" class="btn btn-evento-etapa-${class_etapa} btn-sm" onClick="muestraDetalles('promocion', ${_TE[i].promociones[k].numero_identificador})">Ver más</a>
																			</div>
																			<br>
																		</div>
																	</li>`;
								}
							}

						}

						// EJEC
						for(i = 0; i < _EJEC.length; i++){
							class_etapa = 'ejecucion';
							class_etapa_juicio = 'juicio_oral';

							// Se revisa cada seccion si tiene datos
							if(_EJEC[i].solicitudes.length > 0){//## SOLICITUDES ##

								for(k = 0; k < _EJEC[i].solicitudes.length; k++){ //iteramos los datos de cada seccion 
									let fecha_evento = new Date( _EJEC[i].solicitudes[k].fecha_evento );
						
									lieventos += `<li class="list-inline-item event-list bg-soft-etapa-${class_etapa}">
																	<div class="px-4">
																		<div class="event-date bg-soft-evento-etapa-${class_etapa} text-evento-etapa-${class_etapa}">${_EJEC[i].solicitudes[k].fecha_evento.split('-')[2]} ${nombre_meses[fecha_evento.getMonth()]} ${fecha_evento.getFullYear()}</div>
																		<h5 class="font-size-16 text-soft-evento-etapa-${class_etapa}">${ _EJEC[i].solicitudes[k].tipo_evento.replaceAll('_',' ').toUpperCase() }</h5>
																		<p class="text-evento-etapa-${class_etapa}">${_EJEC[i].solicitudes[k].acontecimiento}</p>
																		<div>
																			<a href="#" class="btn btn-evento-etapa-${class_etapa} btn-sm" onClick="muestraDetalles('Solicitud_EJEC', ${_EJEC[i].solicitudes[k].numero_identificador})">Ver más</a>
																		</div>
																		<br>
																	</div>
																</li>`;
								}
							}
							
							if(_EJEC[i].acuerdos.length > 0){// ## ACUERDOS ##
								for(k = 0; k < _EJEC[i].acuerdos.length; k++){	
									let fecha_evento = new Date( _EJEC[i].acuerdos[k].fecha_evento );
									let tipo_evento = '';
									
									if(_EJEC[i].acuerdos[k].fecha_evento.length > 10 ){
										fecha_evento_s = _EJEC[i].acuerdos[k].fecha_evento.substring(0,10);
									}else{
										fecha_evento_s = _EJEC[i].acuerdos[k].fecha_evento;
									}

									lieventos += `<li class="list-inline-item event-list bg-soft-etapa-${class_etapa}">
																	<div class="px-4">
																		<div class="event-date bg-soft-evento-etapa-${class_etapa} text-evento-etapa-${class_etapa}">${fecha_evento_s.split('-')[2]} ${nombre_meses[fecha_evento.getMonth()]} ${fecha_evento.getFullYear()}</div>
																		<h5 class="font-size-16 text-soft-evento-etapa-${class_etapa}">${ _EJEC[i].acuerdos[k].tipo_evento.replaceAll('_',' ').toUpperCase() }</h5>
																		<p class="text-evento-etapa-${class_etapa}">${_EJEC[i].acuerdos[k].acontecimiento}</p>
																		<div>
																			<a href="#" class="btn btn-evento-etapa-${class_etapa} btn-sm" onClick="muestraDetalles('acuerdo',${_EJEC[i].acuerdos[k].numero_identificador})">Ver más</a>
																		</div>
																		<br>
																	</div>
																</li>`;
								}
							}
					
							if(_EJEC[i].audiencias.length > 0){//## AUDIENCIAS ##
								for(k = 0; k < _EJEC[i].audiencias.length; k++){
									if(_EJEC[i].audiencias[k].audiencias_juicio_oral.length > 0 ){
										for(j in _EJEC[i].audiencias[k].audiencias_juicio_oral){
											let fecha_evento = new Date( _EJEC[i].audiencias[k].audiencias_juicio_oral[j].fecha_evento );
											let tipo_evento = '';
											lieventos += `<li class="list-inline-item event-list bg-soft-etapa-${class_etapa_juicio}">
																			<div class="px-4">
																				<div class="event-date bg-soft-evento-etapa-${class_etapa_juicio} text-evento-etapa-${class_etapa_juicio}">${_EJEC[i].audiencias[k].audiencias_juicio_oral[j].fecha_evento.split('-')[2]} ${nombre_meses[fecha_evento.getMonth()]} ${fecha_evento.getFullYear()}</div>
																				<h5 class="font-size-16 text-soft-evento-etapa-${class_etapa_juicio}">${ _EJEC[i].audiencias[k].audiencias_juicio_oral[j].tipo_evento.replaceAll('_',' ').toUpperCase() }</h5>
																				<p class="text-evento-etapa-${class_etapa_juicio}">${_EJEC[i].audiencias[k].audiencias_juicio_oral[j].acontecimiento}</p>
																				<div>
																					<a href="#" class="btn btn-evento-etapa-${class_etapa_juicio} btn-sm" onClick="muestraDetalles('audiencia',${_EJEC[i].audiencias[k].audiencias_juicio_oral[j].numero_identificador})">Ver más</a>
																				</div>
																				<br>
																			</div>
																		</li>`;
										}
									}
									if(_EJEC[i].audiencias[k].audiencias.length > 0 ){
										for( j  in _EJEC[i].audiencias[k].audiencias){
											let fecha_evento = new Date( _EJEC[i].audiencias[k].audiencias[j].fecha_evento );
											let tipo_evento = '';
											lieventos += `<li class="list-inline-item event-list bg-soft-etapa-${class_etapa}">
																			<div class="px-4">
																				<div class="event-date bg-soft-evento-etapa-${class_etapa} text-evento-etapa-${class_etapa}">${_EJEC[i].audiencias[k].audiencias[j].fecha_evento.split('-')[2]} ${nombre_meses[fecha_evento.getMonth()]} ${fecha_evento.getFullYear()}</div>
																				<h5 class="font-size-16 text-soft-evento-etapa-${class_etapa}">${ _EJEC[i].audiencias[k].audiencias[j].tipo_evento.replaceAll('_',' ').toUpperCase() }</h5>
																				<p class="text-evento-etapa-${class_etapa}">${_EJEC[i].audiencias[k].audiencias[j].acontecimiento}</p>
																				<div>
																					<a href="#" class="btn btn-evento-etapa-${class_etapa} btn-sm" onClick="muestraDetalles('audiencia',${_EJEC[i].audiencias[k].audiencias[j].numero_identificador})">Ver más</a>
																				</div>
																				<br>
																			</div>
																		</li>`;
										}
									}
								}
							}

							if(_EJEC[i].documentos.length > 0){//## DOCUMENTOS ##
								for(k = 0; k < _EJEC[i].documentos.length; k++){	
									let fecha_evento = new Date( _EJEC[i].documentos[k].fecha_evento );
									let tipo_evento = '';
									lieventos += `<li class="list-inline-item event-list bg-soft-etapa-${class_etapa}">
																	<div class="px-4">
																		<div class="event-date bg-soft-evento-etapa-${class_etapa} text-evento-etapa-${class_etapa}">${_EJEC[i].documentos[k].fecha_evento.split('-')[2]} ${nombre_meses[fecha_evento.getMonth()]} ${fecha_evento.getFullYear()}</div>
																		<h5 class="font-size-16 text-soft-evento-etapa-${class_etapa}">${ _EJEC[i].documentos[k].tipo_evento.replaceAll('_',' ').toUpperCase() }</h5>
																		<p class="text-evento-etapa-${class_etapa}">${_EJEC[i].documentos[k].acontecimiento}</p>
																		<div>
																			<a href="#" class="btn btn-evento-etapa-${class_etapa} btn-sm" onClick="muestraDetalles('documento', ${_EJEC[i].documentos[k].numero_identificador})">Ver más</a>
																		</div>
																		<br>
																	</div>
																</li>`;
								}
							}

							if(_EJEC[i].promociones.length > 0){//## PROMOCIONES ##
								for(k = 0; k < _EJEC[i].promociones.length; k++){	
										let fecha_evento = new Date( _EJEC[i].promociones[k].fecha_evento );
										let tipo_evento = '';
										lieventos += `<li class="list-inline-item event-list bg-soft-etapa-${class_etapa}">
																		<div class="px-4">
																			<div class="event-date bg-soft-evento-etapa-${class_etapa} text-evento-etapa-${class_etapa}">${_EJEC[i].promociones[k].fecha_evento.split('-')[2]} ${nombre_meses[fecha_evento.getMonth()]} ${fecha_evento.getFullYear()}</div>
																			<h5 class="font-size-16 text-soft-evento-etapa-${class_etapa}">${ _EJEC[i].promociones[k].tipo_evento.replaceAll('_',' ').toUpperCase() }</h5>
																			<p class="text-evento-etapa-${class_etapa}">${_EJEC[i].promociones[k].acontecimiento}</p>
																			<div>
																				<a href="#" class="btn btn-evento-etapa-${class_etapa} btn-sm" onClick="muestraDetalles('promocion', ${_EJEC[i].promociones[k].numero_identificador})">Ver más</a>
																			</div>
																			<br>
																		</div>
																	</li>`;
								}
							}

						}
 
						// LN
						for(i = 0; i < _LN.length; i++){
							class_etapa = 'ley-nacional';
							class_etapa_juicio = 'juicio_oral';

							// Se revisa cada seccion si tiene datos
							if(_LN[i].solicitudes.length > 0){//## SOLICITUDES ##

								for(k = 0; k < _LN[i].solicitudes.length; k++){ //iteramos los datos de cada seccion 
									let fecha_evento = new Date( _LN[i].solicitudes[k].fecha_evento );
						
									lieventos += `<li class="list-inline-item event-list bg-soft-etapa-${class_etapa}">
																	<div class="px-4">
																		<div class="event-date bg-soft-evento-etapa-${class_etapa} text-evento-etapa-${class_etapa}">${_LN[i].solicitudes[k].fecha_evento.split('-')[2]} ${nombre_meses[fecha_evento.getMonth()]} ${fecha_evento.getFullYear()}</div>
																		<h5 class="font-size-16 text-soft-evento-etapa-${class_etapa}">${ _LN[i].solicitudes[k].tipo_evento.replaceAll('_',' ').toUpperCase() }</h5>
																		<p class="text-evento-etapa-${class_etapa}">${_LN[i].solicitudes[k].acontecimiento}</p>
																		<div>
																			<a href="#" class="btn btn-evento-etapa-${class_etapa} btn-sm" onClick="muestraDetalles('Solicitud_LN', ${_LN[i].solicitudes[k].numero_identificador})">Ver más</a>
																		</div>
																		<br>
																	</div>
																</li>`;
								}
							}
														
							if(_LN[i].acuerdos.length > 0){// ## ACUERDOS ##
								for(k = 0; k < _LN[i].acuerdos.length; k++){	
									let fecha_evento = new Date( _LN[i].acuerdos[k].fecha_evento );
									let tipo_evento = '';
									
									if(_LN[i].acuerdos[k].fecha_evento.length > 10 ){
										fecha_evento_s = _LN[i].acuerdos[k].fecha_evento.substring(0,10);
									}else{
										fecha_evento_s = _LN[i].acuerdos[k].fecha_evento;
									}

									lieventos += `<li class="list-inline-item event-list bg-soft-etapa-${class_etapa}">
																	<div class="px-4">
																		<div class="event-date bg-soft-evento-etapa-${class_etapa} text-evento-etapa-${class_etapa}">${fecha_evento_s.split('-')[2]} ${nombre_meses[fecha_evento.getMonth()]} ${fecha_evento.getFullYear()}</div>
																		<h5 class="font-size-16 text-soft-evento-etapa-${class_etapa}">${ _LN[i].acuerdos[k].tipo_evento.replaceAll('_',' ').toUpperCase() }</h5>
																		<p class="text-evento-etapa-${class_etapa}">${_LN[i].acuerdos[k].acontecimiento}</p>
																		<div>
																			<a href="#" class="btn btn-evento-etapa-${class_etapa} btn-sm" onClick="muestraDetalles('acuerdo',${_LN[i].acuerdos[k].numero_identificador})">Ver más</a>
																		</div>
																		<br>
																	</div>
																</li>`;
								}
							}
					
							if(_LN[i].audiencias.length > 0){//## AUDIENCIAS ##
								for(k = 0; k < _LN[i].audiencias.length; k++){
									if(_LN[i].audiencias[k].audiencias_juicio_oral.length > 0 ){
										let fecha_evento = new Date( _LN[i].audiencias[k].fecha_evento );
										let tipo_evento = '';
										lieventos += `<li class="list-inline-item event-list bg-soft-etapa-${class_etapa_juicio}">
																		<div class="px-4">
																			<div class="event-date bg-soft-evento-etapa-${class_etapa_juicio} text-evento-etapa-${class_etapa_juicio}">${_LN[i].audiencias[k].fecha_evento.split('-')[2]} ${nombre_meses[fecha_evento.getMonth()]} ${fecha_evento.getFullYear()}</div>
																			<h5 class="font-size-16 text-soft-evento-etapa-${class_etapa_juicio}">${ _LN[i].audiencias[k].tipo_evento.replaceAll('_',' ').toUpperCase() }</h5>
																			<p class="text-evento-etapa-${class_etapa_juicio}">${_LN[i].audiencias[k].acontecimiento}</p>
																			<div>
																				<a href="#" class="btn btn-evento-etapa-${class_etapa_juicio} btn-sm" onClick="muestraDetalles('carpeta_judicial')">Ver más</a>
																			</div>
																			<br>
																		</div>
																	</li>`;
									}

									if(_LN[i].audiencias[k].audiencias.length > 0 ){
										let fecha_evento = new Date( _LN[i].audiencias[k].fecha_evento );
										let tipo_evento = '';
										lieventos += `<li class="list-inline-item event-list bg-soft-etapa-${class_etapa}">
																		<div class="px-4">
																			<div class="event-date bg-soft-evento-etapa-${class_etapa} text-evento-etapa-${class_etapa}">${_LN[i].audiencias[k].fecha_evento.split('-')[2]} ${nombre_meses[fecha_evento.getMonth()]} ${fecha_evento.getFullYear()}</div>
																			<h5 class="font-size-16 text-soft-evento-etapa-${class_etapa}">${ _LN[i].audiencias[k].tipo_evento.replaceAll('_',' ').toUpperCase() }</h5>
																			<p class="text-evento-etapa-${class_etapa}">${_LN[i].audiencias[k].acontecimiento}</p>
																			<div>
																				<a href="#" class="btn btn-evento-etapa-${class_etapa} btn-sm" onClick="muestraDetalles('carpeta_judicial')">Ver más</a>
																			</div>
																			<br>
																		</div>
																	</li>`;
									}

								}
							}

							if(_LN[i].documentos.length > 0){//## DOCUMENTOS ##
								for(k = 0; k < _LN[i].documentos.length; k++){	
									let fecha_evento = new Date( _LN[i].documentos[k].fecha_evento );
									let tipo_evento = '';
									lieventos += `<li class="list-inline-item event-list bg-soft-etapa-${class_etapa}">
																	<div class="px-4">
																		<div class="event-date bg-soft-evento-etapa-${class_etapa} text-evento-etapa-${class_etapa}">${_LN[i].documentos[k].fecha_evento.split('-')[2]} ${nombre_meses[fecha_evento.getMonth()]} ${fecha_evento.getFullYear()}</div>
																		<h5 class="font-size-16 text-soft-evento-etapa-${class_etapa}">${ _LN[i].documentos[k].tipo_evento.replaceAll('_',' ').toUpperCase() }</h5>
																		<p class="text-evento-etapa-${class_etapa}">${_LN[i].documentos[k].acontecimiento}</p>
																		<div>
																			<a href="#" class="btn btn-evento-etapa-${class_etapa} btn-sm" onClick="muestraDetalles('documento', ${_LN[i].documentos[k].numero_identificador})">Ver más</a>
																		</div>
																		<br>
																	</div>
																</li>`;
								}
							}

							if(_LN[i].promociones.length > 0){//## PROMOCIONES ##
								for(k = 0; k < _LN[i].promociones.length; k++){	
										let fecha_evento = new Date( _LN[i].promociones[k].fecha_evento );
										let tipo_evento = '';
										lieventos += `<li class="list-inline-item event-list bg-soft-etapa-${class_etapa}">
																		<div class="px-4">
																			<div class="event-date bg-soft-evento-etapa-${class_etapa} text-evento-etapa-${class_etapa}">${_LN[i].promociones[k].fecha_evento.split('-')[2]} ${nombre_meses[fecha_evento.getMonth()]} ${fecha_evento.getFullYear()}</div>
																			<h5 class="font-size-16 text-soft-evento-etapa-${class_etapa}">${ _LN[i].promociones[k].tipo_evento.replaceAll('_',' ').toUpperCase() }</h5>
																			<p class="text-evento-etapa-${class_etapa}">${_LN[i].promociones[k].acontecimiento}</p>
																			<div>
																				<a href="#" class="btn btn-evento-etapa-${class_etapa} btn-sm" onClick="muestraDetalles('promocion', ${_LN[i].promociones[k].numero_identificador})">Ver más</a>
																			</div>
																			<br>
																		</div>
																	</li>`;
								}
							}

						}

						$("#title-VCJ").text(`Acontecimientos destacados de la ${$("#lbl-titulo-modal-administracion").text()}`);
						$("#events-list-vcj").append(lieventos);
					}else{
						if( response.message!="ERROR - sin datos asociados") modal_error(response.message+'VC','modalAdministracion');
					}
				}
			});
		}

		function muestraDetalles( index_evento, numero_identificador=null ){
			//objEvento = arrEVCJ[ index_evento ];
			//console.log("Muestra detalles :",objEvento);
			switch( index_evento ){
				case 'Solicitud_inicial' : 
					// alert("llegaste a muestra detalles solicitud inicial");
					muestraSolicitudInicial(numero_identificador,$("#tipo_solicitud").val());
				break;
				case 'Solicitud_TE' : 
					// alert("llegaste a muestra detalles solicitud inicial");
					muestraSolicitudInicialRem(numero_identificador, 'TE');
				break;
				case 'Solicitud_EJEC' : 
					// alert("llegaste a muestra detalles solicitud inicial");
					muestraSolicitudInicialRem(numero_identificador, 'EJEC');
				break;
				case 'Solicitud_LN' : 
					// alert("llegaste a muestra detalles solicitud inicial");
					muestraSolicitudInicialRem(numero_identificador, 'LN');
				break;
				case 'carpeta_judicial' : 
					// alert("llegaste a muestra detalles carpeta_judicial");
					muestraCarpetaJudicial($("#id_carpeta_judicial").val());
				break;
				case 'audiencia' : 
					// alert("llegaste a muestra detalles carpeta_judicial");
					muestraAudiencia(numero_identificador);
				break;
				case 'acuerdo' : 
					// alert("llegaste a muestra detalles acuerdo");
					muestraAcuerdo(numero_identificador);
				break;
				case 'promocion' : 
					// alert("llegaste a muestra detalles promocion");
					muestraPromocion(numero_identificador);
				break;
				case 'documento' : 
					// alert("llegaste a muestra detalles promocion");
					muestraDocumentoAsociado(numero_identificador);
				break;
				default :
					alert(`Los detalles para ${index_evento} está en desarrollo`);
				break;
			}
		}

    function muestraSolicitudInicial(id_solicitud,tipo_solicitud){
      console.log(id_solicitud,tipo_solicitud);
			$('#nav-fracciones-tab').css('display', 'none');
			$('#nav-documento_view-tab').css('display', 'none');
			
			$('#nav-documento_view-tab').addClass('active');
			$('#nav-documento_view').addClass('active');
			$('#nav-documento_view').addClass('show');

			$('#nav-fracciones-tab').removeClass('active');
			$('#nav-fracciones').removeClass('active');
			$('#nav-fracciones').removeClass('show');

			let modo = "completo";
			$.ajax({
				type:'GET',
				url:'/public/obtener_solicitudes',
				data:{
					modo:"completo",
					id_solicitud:id_solicitud,
					tipo_solicitud:tipo_solicitud,
					pagina:1,
					registros_por_pagina:10,
				},
				success:function(response) {

					if(response.status==100){

						let tabla_direcciones=[];
						let tabla_alias=[];
						let tabla_contacto=[];
						let tabla_correo=[];
						let tabla_datos=[];
						let tabla_delitos=[];
						let tabla_no_relacionados=null;

						const {id_solicitud,folio_solicitud_audiencia,personas, delitos_sin_relacionar,fecha_solicitud,carpeta_investigacion,cordinacion_territorial,situacion_carpeta,
						fecha_fenece,folio_carpeta,folio_solicitud,fecha_recepcion,hora_recepcion,tipo_audiencia,duracion_aproximada,estatus_urgente,estatus_telepresencia,
						estatus_area_resguardo,estatus_mod_testigo_protegido,estatus_mesa_evidencia,estatus_delito_grave,mp_solicitante,tipo_solicitud,fiscalia,
						materia_destino,color,curp_mp,correo_mp,tipo_solicitud_}=response.response[0];

						let listaPersona=[];
						let listaNorelacionados='';
						let listaSujetos=[];
						let acordeones=[];

						//Delitos Sin Relacionar 
						if(delitos_sin_relacionar.length){
							$(delitos_sin_relacionar).each(function(index, sin){

								const {calificativo,forma_comision,grado_realizacion,delito,nombre_modalidad}  =sin;

								if( $("#tipo_solicitud").val() != 'EXHORTO' ){

									listaNorelacionados=listaNorelacionados.concat(`
										<tr>
											<td align="center">${delito ?? ""}</td>
											<td align="center">${nombre_modalidad ?? ""}</td>
											<td align="center">${calificativo ?? " Sin datos "}</td>
											<td align="center">${grado_realizacion ?? ""}</td>
										</tr>
									`);
								}else{ 
									listaNorelacionados=listaNorelacionados.concat(`
										<tr>
											<td align="center">${delito ?? ""}</td> 
										</tr>
									`);
								}

							});  
							
							if( $("#tipo_solicitud").val() != 'EXHORTO' ){
							
								tabla_no_relacionados = `
									<tr align="center">
										<td class="td-title"> Delito </td>
										<td class="td-title">Modalidad del Delito</td>
										<td class="td-title"> Calificativo</td>
										<td class="td-title">Grado de Realizacion</td>
									</tr>

									<tr>${listaNorelacionados ?? ""}</tr>
								`;
							
							}else{ 
								tabla_no_relacionados = `
									<tr align="center">
										<td class="td-title"> Delito </td>
									</tr>

									<tr>${listaNorelacionados ?? ""}</tr>
								`;
							}

						}else{
							tabla_no_relacionados = `
								<tr align="center">
									<td class="td-title"> Sin delitos NO Relacionados </td>
								</tr>
							`;
						}

						//PERSONAS
						$(personas).each(function(index_p, persona){

							listaPersona.push(persona.info_principal);

							let tablaDireccion='';
							let tablaAlias='';
							let tablaContacto='';
							let tablaCorreo='';
							let tablaDatos='';
							let tablaDelitos='';

							$(persona.direcciones).each(function(index_d, direccion){

								const {id_persona,calle,codigo_postal,colonia,entidad_federativa,entre_calles,estado,localidad,municipio,no_exterior,
									no_interior,referencias}=direccion;

								tablaDireccion = tablaDireccion + ` 
									<tr align="center"> <th colspan="100%" class="th-title">Direcciones</th> </tr>
									<tr>
										<td class="td-title">Calle</td>
										<td>${calle ?? "Sin datos"}</td>

										<td class="td-title">Número Exterior</td>
										<td>${no_exterior ?? "Sin datos"}</td>
									</tr>

									<tr>
										<td class="td-title">Número Interior</td>
										<td>${no_interior ?? "Sin datos"}</td>

										<td class="td-title">Localidad</td>
										<td>${localidad ?? "Sin datos"}</td>
									</tr>

									<tr>
										<td class="td-title">Colonia</td>
										<td>${colonia ?? "Sin datos"}</td>

										<td class="td-title">Estado</td>
										<td>${estado ?? "Sin datos"}</td>
									</tr>

									<tr>
										<td class="td-title">Municipio</td>
										<td>${municipio ?? "Sin datos"}</td>

										<td class="td-title">Otras Referencias</td>
										<td>${referencias ?? "Sin datos"}</td>
									</tr>

									<tr>
										<td class="td-title">Entre Calles</td>
										<td>${entre_calles ?? "Sin datos"}</td>

										<td class="td-title">Codigo Postal</td>
										<td>${codigo_postal ?? "Sin datos"}</td>
									</tr>
									`;
							});  

							tabla_direcciones[index_p] = tablaDireccion;

							//DELITOS PERSONAS
							if(persona.delitos.length){
								$(persona.delitos).each(function(index_de, delitoo){

									const {calificativo,forma_comision,grado_realizacion,delito,nombre_modalidad}  =delitoo;

									tablaDelitos = tablaDelitos + `
										<tr>
											<td>${delito ?? ""}</td>
											<td>${nombre_modalidad ?? ""}</td>
											<td>${calificativo ?? ""}</td>
											<td>${grado_realizacion ?? ""}</td>
										</tr>
									`;
								});   
								
								tabla_delitos[index_p] =` 
									<tr align="center"><th colspan="4" class="tx-center" style="background:#f8f9fa">Delitos Relacionados </th></tr>
										<tr>
											<td class="tx-center" style="background:#f8f9fa">Delito</td>
											<td class="tx-center" style="background:#f8f9fa">Modalidad del Delito</td>
											<td class="tx-center" style="background:#f8f9fa">Calificativo</td>
											<td class="tx-center" style="background:#f8f9fa">Grado de Realizacion</td>
										</tr>`+  tablaDelitos;
							}else{
								tabla_delitos[index_p] = `
									<tr align="center">
										<td colspan="4" class="tx-center" style="background:#f8f9fa"> Sin delitos relacionados </td>
									</tr>
								`;
							}
					
							//DATOS PERSONAS
							$(persona.datos).each(function(index_da, datos){
								const {capacidad_diferente,capacidades_diferentes,entiende_idioma_español,grupo_etnico,idioma_traductor,
								lengua,nivel_escolaridad,nombre_poblacion,nombre_religion,requiere_interprete,requiere_traductor,
								sabe_leer_escribir} =datos;
								tablaDatos=  datos;
							});
							tabla_datos[index_p] = tablaDatos;

							// ALIAS PERSONAS
							$(persona.alias).each(function(index_a, aliases){
								const {alias} =aliases;
								tablaAlias= tablaAlias + `${alias} <br>`;
							}); 
							tabla_alias[index_p] = tablaAlias;


							// CONTACTO PERSONAS
							$(persona.contacto).each(function(index_c, contact){
								const {contacto,tipo_contacto} =contact;

								if(tipo_contacto== "correo electronico"){
									tablaCorreo = tablaCorreo + `${contacto} <br>`;
								}
								else{
									tablaContacto = tablaContacto + ` ${tipo_contacto} : ${contacto} <br> `;
								}
							}); 
							
							tabla_contacto[index_p] = tablaContacto;
							tabla_correo[index_p] = tablaCorreo;
						});

						// INFO SOLICITUD PERSONAS
						$(listaPersona).each(function(index,sujetosProcesales){


								const {id_persona,nombre,apellido_paterno,apellido_materno,calidad_juridica,cedula_profesional,curp,edad,es_mexicano,
								estado_civil,fecha_nacimiento,folio_identificacion,lugar_reclusorio,genero,nacionalidad,otra_nacionalidad,tipo_identificacion,
								tipo_persona,rfc_empresa,tipo_ocupacion,poblacion_callejera} =sujetosProcesales;

								var tablaSujeto = `
									<table class="info-principa datatable tableDatosSujeto" style="overflow-x: none; display: table">
										<tbody class="table-datos-sujeto">
											<tr>
												<td class="td-title">Calidad Juridica</td>
												<td>${calidad_juridica ?? "Sin datos"}</td>

												<td class="td-title">Sabe Leer y Escribir</td>
												<td>${tabla_datos[index].sabe_leer_escribir ?? "Sin datos"}</td>
											</tr>

											<tr>
												<td class="td-title">RFC </td>
												<td>${rfc_empresa ?? ""}</td>

												<td class="td-title">LGBTTTI</td>
												<td>${tabla_datos[index].nombre_poblacion ?? "Sin datos"}</td>
											</tr>

											<tr>
												<td class="td-title">CURP </td>
												<td>${curp ?? ""}</td>

												<td class="td-title">Poblacion</td>
												<td>${tabla_datos[index].poblacion ?? "Sin datos"}</td>
											</tr>

											<tr>
												<td class="td-title">Cédula Profesional </td>
												<td>${cedula_profesional ?? "Sin datos"}</td>

												<td class="td-title">Requiere traductor</td>
												<td>${tabla_datos[index].requiere_traductor ?? "Sin datos"}</td>
											</tr>

											<tr>
												<td class="td-title">Género </td>
												<td>${genero ?? "Sin datos"}</td>

												<td class="td-title">Requiere Interprete</td>
												<td>${tabla_datos[index].requiere_interprete ?? "Sin datos"}</td>
											</tr>

											<tr>
												<td class="td-title">Fecha de Nacimiento </td>
												<td>${fecha_nacimiento ?? "Sin datos"}</td>

												<td class="td-title">Capacidades Diferentes</td>
												<td>${tabla_datos[index].capacidad_diferente ?? "Sin datos"}</td>
											</tr>

											<tr>
												<td class="td-title">Nacionalidad </td>
												<td>${nacionalidad ?? "Sin datos"}</td>

												<td class="td-title">Poblacion Callejera</td>
												<td>${tabla_datos[index].poblacion_callejera ?? "Sin datos"}</td>
											</tr>

											<tr>
												<td class="td-title">Otra Nacionalidad </td>
												<td>${otra_nacionalidad ?? "Sin datos"}</td>

												<td class="td-title">Lengua</td>
												<td>${estado_civil ?? "Sin datos"}</td>
											</tr>

											<tr>
												<td class="td-title">Estado Civil </td>
												<td>${estado_civil ?? "Sin datos"}</td>

												<td class="td-title">Religion</td>
												<td>${tabla_datos[index].nombre_religion ?? "Sin datos"}</td>
											</tr>

											<tr>
												<td class="td-title">Tipo Persona </td>
												<td>${tipo_persona ?? "Sin datos"}</td>

												<td class="td-title">Grupo Etnico</td>
												<td>${tabla_datos[index].grupo_etnico?? "Sin datos"}</td>
											</tr>

											<tr>
												<td class="td-title">Nivel Escolaridad </td>
												<td>${tabla_datos[index].nivel_escolaridad ?? "Sin datos"}</td>

												<td class="td-title">Ocupación</td>
												<td>${tabla_datos[index].tipo_ocupacion ?? "Sin datos"}</td>
											</tr>
										</tbody>
									</table>
									<br>
									<table class="direcciones datatable tableDatosSujeto" style="overflow-x: none; display: table">
										${tabla_direcciones[index] }
									</table>
									<br>
									<table class="contactos datatable tableDatosSujeto2" style="overflow-x: none; display: table">
										<thead>
											<tr>
												<td class="tx-center">Teléfono (s)</td>
												<td class="tx-center">Correo(s) Electrónico(s)</td>
												<td class="tx-center">Alias</td>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>${tabla_contacto[index].length ? tabla_contacto[index] : "Sin datos"}</td>
												<td>${tabla_correo[index].length ? tabla_correo[index] : "Sin datos"} </td>
												<td>${tabla_alias[index].length ? tabla_alias[index] : "Sin datos"}</td>
											</tr>
										</tbody>
									</table>
									<br>
									<table class="delitos datatable tableDatosSujeto" style="overflow-x: none; display: table">
										<tbody class="table-datos-sujeto">
											${tabla_delitos[index]}
										</tbody>
									</table> 
									<br>
								`;

								var accordion = `
									<div id="accordion-VCJ-Personas-${ index }" class="accordion-one mg-b-10" role="tablist" aria-multiselectable="true" width="100%">
										<div class="card">
											<div class="card-header" role="tab" id="headingOne">
												<a id="titleAccordion-VCJ-Personas-${ index }" style="background: #848f33c7 !important; color:#fff;" data-toggle="collapse" data-parent="#accordion-VCJ-Personas-${ index }" href="#collapseOne-VCJ-Personas-${ index }" aria-expanded="true" aria-controls="collapseOne-VCJ-Personas-${ index }" class="tx-gray-800 transition collapsed tx-semibold">
													<i class="fas fa-user" style="margin-right:1%;"></i>${nombre ?? "Sin nombre"} ${apellido_paterno ?? ""} ${apellido_materno ?? ""} [ ${calidad_juridica ?? "Sin datos"} ]
												</a>
											</div><!-- card-header -->
											<div id="collapseOne-VCJ-Personas-${ index }" class="collapse" role="tabpanel" aria-labelledby="headingOne-VCJ-Personas-${ index }">
												<div class="card-body">
													<div class="mg-t-15">
														${tablaSujeto}
													</div>
												</div> <!-- CARD BODY -->
											</div> <!-- BODY COLLAPSE -->
										</div> <!-- CARD -->
									</div> <!-- ACCORDEON VCJ PARTES PROCESALES -->
								`;

								listaSujetos += tablaSujeto;
								acordeones += accordion;

						});
					
						let tbody_datos_solicitud = `
							<tr>
								<td class="td-title">Folio de Solicitud de Audiencia</td>
								<td>${folio_solicitud_audiencia ?? "Sin datos"}</td>
							</tr>

							<tr>
								<td class="td-title">Fecha de la Solicitud</td>
								<td>${fecha_solicitud ?? "Sin datos"}</td>
							</tr>

							<tr>
								<td class="td-title">Fenece a las</td>
								<td>${fecha_fenece ?? "Sin datos"}</td>
							</tr>

							<tr>
								<td class="td-title">Folio Carpeta Judicial</td>
								<td>${folio_carpeta ?? "Sin datos"}</td>
							</tr>

							<tr>
								<td class="td-title">Tipo de Carpeta </td>
								<td>Carpeta de Control</td>
							</tr>
							
							<tr>
								<td class="td-title">Situación </td>
								<td>${situacion_carpeta ?? ""}</td>
							</tr>

							<tr>
								<td class="td-title">Carpeta de Investigación</td>
								<td>${carpeta_investigacion ?? "Sin datos"}</td>
							</tr>

							<tr>
								<td class="td-title">Fecha de Recepción</td>
								<td>${fecha_recepcion ?? "Sin datos"}</td>
							</tr>

							<tr>
								<td class="td-title">Hora de Recepción</td>
								<td>${hora_recepcion ?? "Sin datos"}</td>
							</tr>


							<tr>
								<td class="td-title">Tipo de Solicitud de Audiencia</td>
								<td>${tipo_solicitud ?? "Sin datos"}</td>
							</tr>

							<tr>
								<td class="td-title">Duración Aproximada (Minutos)</td>
								<td>${duracion_aproximada ?? "Sin datos"}</td>
							</tr>


							<tr>
								<td class="td-title">Urgente</td>
								<td>${estatus_urgente ?? "Sin datos"}</td>
							</tr>


							<tr>
								<td class="td-title">Requiere Telepresencia</td>
								<td>${estatus_telepresencia ?? "Sin datos"}</td>
							</tr>


							<tr>
								<td class="td-title">Requiere Area de Resguardo</td>
								<td>${estatus_area_resguardo ?? "Sin datos"}</td>
							</tr>

							<tr>
								<td class="td-title">Requiere Modalidad Testigo Protegido</td>
								<td>${estatus_mod_testigo_protegido ?? "Sin datos"}</td>
							</tr>

							<tr>
								<td class="td-title">Requiere Mesa de Evidencia</td>
								<td>${estatus_mesa_evidencia ?? "Sin datos"}</td>
							</tr>

							<tr>
								<td class="td-title"> Prisión Preventiva Oficiosa</td>
								<td>${estatus_area_resguardo ?? "Sin datos"}</td>
							</tr>

							<tr>
								<td class="td-title">Fiscalía</td>
								<td>${fiscalia ?? "Sin datos"}</td>
							</tr>

							<tr>
								<td class="td-title">Materia Destino</td>
								<td>${materia_destino ?? "Sin datos"}</td>
							</tr>

							<tr>
								<td class="td-title">MP Solicitante</td>
								<td>${mp_solicitante ?? "Sin datos"}</td>
							</tr>

							<tr>
								<td class="td-title">Correo Electrónico del Fiscal</td>
								<td>${correo_mp ?? "Sin datos"}</td>
							</tr>
						`;

						body= ` 
							<nav>
								<div class="nav nav-tabs" id="nav-tab" role="tablist">
								<a class="nav-item nav-link active" id="nav-datos-solitiud-tab" data-toggle="tab" href="#nav-datos-solitiud" role="tab" aria-controls="nav-datos-solitiud" aria-selected="true">Datos de la Solicitud</a>
								<a class="nav-item nav-link" id="nav-personas-relacionadas-tab" data-toggle="tab" href="#nav-personas-relacionadas" role="tab" aria-controls="nav-personas-relacionadas" aria-selected="false">Personas</a>
								<a class="nav-item nav-link" id="nav-delitos-no-relacionados-tab" data-toggle="tab" href="#nav-delitos-no-relacionados" role="tab" aria-controls="nav-delitos-no-relacionados" aria-selected="false">Delitos no Relacionados</a>
								<a class="nav-item nav-link" id="nav-documentos-tab" data-toggle="tab" href="#nav-documentos" role="tab" aria-controls="nav-documentos" aria-selected="false">Documentos</a>
								</div>
							</nav>
							<br>
							<div class="tab-content" id="nav-tabContent-solicitud">
									<div class="tab-pane fade show active" id="nav-datos-solitiud" role="tabpanel" aria-labelledby="nav-datos-solitiud-tab">
										<table id="datosolicitud" class="datatables tableDatosSujeto"> 
											<tbody class="table-datos-sujeto">
												${ tbody_datos_solicitud } 
											</tbody>		
										</table>
									</div>
									<div class="tab-pane fade" id="nav-personas-relacionadas" role="tabpanel" aria-labelledby="nav-personas-relacionadas-tab">
										<div class="accordion" id="acordeon" role="tablist"> ${ acordeones } </div>
									</div>
									<div class="tab-pane fade" id="nav-delitos-no-relacionados" role="tabpanel" aria-labelledby="nav-delitos-no-relacionados-tab">
											<table id="datosno-asociados" class="datatables tableDatosSujeto"> 
												<tbody class="table-datos-sujeto">
													${ tabla_no_relacionados } 
												</tbody>
											</table>
									</div>
									<div class="tab-pane fade" id="nav-documentos" role="tabpanel" aria-labelledby="nav-documentos-tab">
										<div class="row" id="raw-nav-documentos">
										</div>
									</div>
							</div>
							<br>
						`;

						title = `CARPETA JUDICIAL: ${ folio_carpeta } > Detalle Solicitud`;
						//$("#lbl-titulo-modal-administracion").text()

						modal_detalle(title,body,'modalAdministracion');
						setTimeout(function(){muestraDocumentosSolicitudInicial(id_solicitud,tipo_solicitud);},500);
					}else{ modal_error(response.message,'modalAdministracion'); }
				}
			});
		}

		function muestraSolicitudInicialRem(id_solicitud, tipo_rem){
			console.log(id_solicitud,tipo_rem);
			$('#nav-fracciones-tab').css('display', 'none');
			$('#nav-documento_view-tab').css('display', 'none');
			
			$('#nav-documento_view-tab').addClass('active');
			$('#nav-documento_view').addClass('active');
			$('#nav-documento_view').addClass('show');

			$('#nav-fracciones-tab').removeClass('active');
			$('#nav-fracciones').removeClass('active');
			$('#nav-fracciones').removeClass('show');

			$.ajax({
				type:'GET',
				url:'/public/muestraSolicitudInicialRem',
				data:{
					id_solicitud:id_solicitud,
					tipo_solicitud:tipo_rem
				},
				success:function(response) {
					console.log(response);
					if(response.status == 100){
						let tabla_direcciones=[];
						let tabla_alias=[];
						let tabla_contacto=[];
						let tabla_correo=[];
						let tabla_datos=[];
						let tabla_delitos=[];
						
						const {autorizacion,carpeta_investigacion,carpeta_judicial,estatus_actual,fecha_registro,fecha_solicitud,folio,folio_carpeta_rem,id_carpeta_judicial,id_carpeta_judicial_rem,id_remision,id_tipo_carpeta,id_unidad,motivo_incompetencia,tipo_carpeta,tipo_remision,unidad}=response.datos_solicitud[0];

						let listaPersona=[];
						let listaNorelacionados='';
						let listaSujetos=[];
						let acordeones=[];

						//Delitos Sin Relacionar 
						if(response.delitos_sin_relacionar.length){
							$(response.delitos_sin_relacionar).each(function(index, sin){

								const {calificativo,forma_comision,grado_realizacion,delito,nombre_modalidad}  =sin;

								if( $("#tipo_solicitud").val() != 'EXHORTO' ){

									listaNorelacionados=listaNorelacionados.concat(`
										<tr>
											<td align="center">${delito ?? ""}</td>
											<td align="center">${nombre_modalidad ?? ""}</td>
											<td align="center">${calificativo ?? " Sin datos "}</td>
											<td align="center">${grado_realizacion ?? ""}</td>
										</tr>
									`);
								}else{ 
									listaNorelacionados=listaNorelacionados.concat(`
										<tr>
											<td align="center">${delito ?? ""}</td> 
										</tr>
									`);
								}

							});  
							
							if( $("#tipo_solicitud").val() != 'EXHORTO' ){
							
								tabla_no_relacionados = `
									<tr align="center">
										<td class="td-title"> Delito </td>
										<td class="td-title">Modalidad del Delito</td>
										<td class="td-title"> Calificativo</td>
										<td class="td-title">Grado de Realizacion</td>
									</tr>

									<tr>${listaNorelacionados ?? ""}</tr>
								`;
							
							}else{ 
								tabla_no_relacionados = `
									<tr align="center">
										<td class="td-title"> Delito </td>
									</tr>

									<tr>${listaNorelacionados ?? ""}</tr>
								`;
							}

						}else{
							tabla_no_relacionados = `
								<tr align="center">
									<td class="td-title"> Sin delitos NO Relacionados </td>
								</tr>
							`;
						}

						if(tipo_rem == 'TE' || tipo_rem == 'LN'){

							//PERSONAS
							$(response.personas).each(function(index_p, persona){

								listaPersona.push(persona.info_principal);

								let tablaDireccion='';
								let tablaAlias='';
								let tablaContacto='';
								let tablaCorreo='';
								let tablaDatos='';
								let tablaDelitos='';

								$(persona.direcciones).each(function(index_d, direccion){

									const {id_persona,calle,codigo_postal,colonia,entidad_federativa,entre_calles,estado,localidad,municipio,no_exterior,
										no_interior,referencias}=direccion;

									tablaDireccion = tablaDireccion + ` 
										<tr align="center"> <th colspan="100%" class="th-title">Direcciones</th> </tr>
										<tr>
											<td class="td-title">Calle</td>
											<td>${calle ?? "Sin datos"}</td>

											<td class="td-title">Número Exterior</td>
											<td>${no_exterior ?? "Sin datos"}</td>
										</tr>

										<tr>
											<td class="td-title">Número Interior</td>
											<td>${no_interior ?? "Sin datos"}</td>

											<td class="td-title">Localidad</td>
											<td>${localidad ?? "Sin datos"}</td>
										</tr>

										<tr>
											<td class="td-title">Colonia</td>
											<td>${colonia ?? "Sin datos"}</td>

											<td class="td-title">Estado</td>
											<td>${estado ?? "Sin datos"}</td>
										</tr>

										<tr>
											<td class="td-title">Municipio</td>
											<td>${municipio ?? "Sin datos"}</td>

											<td class="td-title">Otras Referencias</td>
											<td>${referencias ?? "Sin datos"}</td>
										</tr>

										<tr>
											<td class="td-title">Entre Calles</td>
											<td>${entre_calles ?? "Sin datos"}</td>

											<td class="td-title">Codigo Postal</td>
											<td>${codigo_postal ?? "Sin datos"}</td>
										</tr>
										`;
								});  

								tabla_direcciones[index_p] = tablaDireccion;

								//DELITOS PERSONAS
								if(persona.delitos.length){
									$(persona.delitos).each(function(index_de, delitoo){

										const {calificativo,forma_comision,grado_realizacion,delito,nombre_modalidad}  =delitoo;

										tablaDelitos = tablaDelitos + `
											<tr>
												<td>${delito ?? ""}</td>
												<td>${nombre_modalidad ?? ""}</td>
												<td>${calificativo ?? ""}</td>
												<td>${grado_realizacion ?? ""}</td>
											</tr>
										`;
									});   
									
									tabla_delitos[index_p] =` 
										<tr align="center"><th colspan="4" class="tx-center" style="background:#f8f9fa">Delitos Relacionados </th></tr>
											<tr>
												<td class="tx-center" style="background:#f8f9fa">Delito</td>
												<td class="tx-center" style="background:#f8f9fa">Modalidad del Delito</td>
												<td class="tx-center" style="background:#f8f9fa">Calificativo</td>
												<td class="tx-center" style="background:#f8f9fa">Grado de Realizacion</td>
											</tr>`+  tablaDelitos;
								}else{
									tabla_delitos[index_p] = `
										<tr align="center">
											<td colspan="4" class="tx-center" style="background:#f8f9fa"> Sin delitos relacionados </td>
										</tr>
									`;
								}
						
								//DATOS PERSONAS
								$(persona.datos).each(function(index_da, datos){
									const {capacidad_diferente,capacidades_diferentes,entiende_idioma_español,grupo_etnico,idioma_traductor,
									lengua,nivel_escolaridad,nombre_poblacion,nombre_religion,requiere_interprete,requiere_traductor,
									sabe_leer_escribir} =datos;
									tablaDatos=  datos;
								});
								tabla_datos[index_p] = tablaDatos;

								// ALIAS PERSONAS
								$(persona.alias).each(function(index_a, aliases){
									const {alias} =aliases;
									tablaAlias= tablaAlias + `${alias} <br>`;
								}); 
								tabla_alias[index_p] = tablaAlias;


								// CONTACTO PERSONAS
								$(persona.contacto).each(function(index_c, contact){
									const {contacto,tipo_contacto} =contact;

									if(tipo_contacto== "correo electronico"){
										tablaCorreo = tablaCorreo + `${contacto} <br>`;
									}
									else{
										tablaContacto = tablaContacto + ` ${tipo_contacto} : ${contacto} <br> `;
									}
								}); 
								
								tabla_contacto[index_p] = tablaContacto;
								tabla_correo[index_p] = tablaCorreo;
							});

							// INFO SOLICITUD PERSONAS
							$(listaPersona).each(function(index,sujetosProcesales){

								const {id_persona,nombre,apellido_paterno,apellido_materno,calidad_juridica,cedula_profesional,curp,edad,es_mexicano,
								estado_civil,fecha_nacimiento,folio_identificacion,lugar_reclusorio,genero,nacionalidad,otra_nacionalidad,tipo_identificacion,
								tipo_persona,rfc_empresa,tipo_ocupacion,poblacion_callejera} =sujetosProcesales;

								const tablaSujeto = `
									<table class="info-principa datatable tableDatosSujeto" style="overflow-x: none; display: table">
										<tbody class="table-datos-sujeto">
											<tr>
												<td class="td-title">Calidad Juridica</td>
												<td>${calidad_juridica ?? "Sin datos"}</td>

												<td class="td-title">Sabe Leer y Escribir</td>
												<td>${tabla_datos[index].sabe_leer_escribir ?? "Sin datos"}</td>
											</tr>

											<tr>
												<td class="td-title">RFC </td>
												<td>${rfc_empresa ?? ""}</td>

												<td class="td-title">LGBTTTI</td>
												<td>${tabla_datos[index].nombre_poblacion ?? "Sin datos"}</td>
											</tr>

											<tr>
												<td class="td-title">CURP </td>
												<td>${curp ?? ""}</td>

												<td class="td-title">Poblacion</td>
												<td>${tabla_datos[index].poblacion ?? "Sin datos"}</td>
											</tr>

											<tr>
												<td class="td-title">Cédula Profesional </td>
												<td>${cedula_profesional ?? "Sin datos"}</td>

												<td class="td-title">Requiere traductor</td>
												<td>${tabla_datos[index].requiere_traductor ?? "Sin datos"}</td>
											</tr>

											<tr>
												<td class="td-title">Género </td>
												<td>${genero ?? "Sin datos"}</td>

												<td class="td-title">Requiere Interprete</td>
												<td>${tabla_datos[index].requiere_interprete ?? "Sin datos"}</td>
											</tr>

											<tr>
												<td class="td-title">Fecha de Nacimiento </td>
												<td>${fecha_nacimiento ?? "Sin datos"}</td>

												<td class="td-title">Capacidades Diferentes</td>
												<td>${tabla_datos[index].capacidad_diferente ?? "Sin datos"}</td>
											</tr>

											<tr>
												<td class="td-title">Nacionalidad </td>
												<td>${nacionalidad ?? "Sin datos"}</td>

												<td class="td-title">Poblacion Callejera</td>
												<td>${tabla_datos[index].poblacion_callejera ?? "Sin datos"}</td>
											</tr>

											<tr>
												<td class="td-title">Otra Nacionalidad </td>
												<td>${otra_nacionalidad ?? "Sin datos"}</td>

												<td class="td-title">Lengua</td>
												<td>${estado_civil ?? "Sin datos"}</td>
											</tr>

											<tr>
												<td class="td-title">Estado Civil </td>
												<td>${estado_civil ?? "Sin datos"}</td>

												<td class="td-title">Religion</td>
												<td>${tabla_datos[index].nombre_religion ?? "Sin datos"}</td>
											</tr>

											<tr>
												<td class="td-title">Tipo Persona </td>
												<td>${tipo_persona ?? "Sin datos"}</td>

												<td class="td-title">Grupo Etnico</td>
												<td>${tabla_datos[index].grupo_etnico?? "Sin datos"}</td>
											</tr>

											<tr>
												<td class="td-title">Nivel Escolaridad </td>
												<td>${tabla_datos[index].nivel_escolaridad ?? "Sin datos"}</td>

												<td class="td-title">Ocupación</td>
												<td>${tabla_datos[index].tipo_ocupacion ?? "Sin datos"}</td>
											</tr>
										</tbody>
									</table>
									<br>
									<table class="direcciones datatable tableDatosSujeto" style="overflow-x: none; display: table">
										${tabla_direcciones[index] }
									</table>
									<br>
									<table class="contactos datatable tableDatosSujeto2" style="overflow-x: none; display: table">
										<thead>
											<tr>
												<td class="tx-center">Teléfono (s)</td>
												<td class="tx-center">Correo(s) Electrónico(s)</td>
												<td class="tx-center">Alias</td>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>${tabla_contacto[index].length ? tabla_contacto[index] : "Sin datos"}</td>
												<td>${tabla_correo[index].length ? tabla_correo[index] : "Sin datos"} </td>
												<td>${tabla_alias[index].length ? tabla_alias[index] : "Sin datos"}</td>
											</tr>
										</tbody>
									</table>
									<br>
									<table class="delitos datatable tableDatosSujeto" style="overflow-x: none; display: table">
										<tbody class="table-datos-sujeto">
											${tabla_delitos[index]}
										</tbody>
									</table> 
									<br>
								`;

								const accordion = `
									<div id="accordion-VCJ-Personas-${ index }" class="accordion-one mg-b-10" role="tablist" aria-multiselectable="true" width="100%">
										<div class="card">
											<div class="card-header" role="tab" id="headingOne">
												<a id="titleAccordion-VCJ-Personas-${ index }" style="background: #848f33 !important; color:#fff;" data-toggle="collapse" data-parent="#accordion-VCJ-Personas-${ index }" href="#collapseOne-VCJ-Personas-${ index }" aria-expanded="true" aria-controls="collapseOne-VCJ-Personas-${ index }" class="tx-gray-800 transition collapsed tx-semibold">
													<i class="fas fa-user" style="margin-right:1%;"></i>${nombre ?? "Sin nombre"} ${apellido_paterno ?? ""} ${apellido_materno ?? ""} [ ${calidad_juridica ?? "Sin datos"} ]
												</a>
											</div><!-- card-header -->
											<div id="collapseOne-VCJ-Personas-${ index }" class="collapse" role="tabpanel" aria-labelledby="headingOne-VCJ-Personas-${ index }">
												<div class="card-body">
													<div class="mg-t-15">
														${tablaSujeto}
													</div>
												</div> <!-- CARD BODY -->
											</div> <!-- BODY COLLAPSE -->
										</div> <!-- CARD -->
									</div> <!-- ACCORDEON VCJ PARTES PROCESALES -->
								`;

								listaSujetos=listaSujetos.concat(tablaSujeto);
								acordeones=acordeones.concat(accordion);
							});

						}else if(tipo_rem == 'EJEC'){
							$(response.personas.sentenciados).each(function(index_p, persona){

								const {apellido_materno,apellido_paterno,calidad_juridica,clave,creacion,en_libertad,estatus,genero,
									id_persona,id_reclusorio,id_rem_per,id_remision,id_unidad_centro_detencion,id_usuario_creador,monto_garantia,nombre,
									nombre_reclusorio,persona_seccion,suspension_condicional,tipo_persona,tipo_remision
								} = persona;


								const tablaSujeto = `
									<table class="table">
										<tbody class="table-datos-sujeto">
											<tr>
												<td class="td-title">Calidad Juridica</td>
												<td>${calidad_juridica ?? "Sin datos"}</td>
											</tr>

											<tr>
												<td class="td-title">Clave </td>
												<td>${clave ?? ""}</td>
											</tr>

											<tr>
												<td class="td-title">Género </td>
												<td>${genero ?? "Sin datos"}</td>
											</tr>

											<tr>
												<td class="td-title">Estatus</td>
												<td>${estatus == 1 ? 'Activo': 'Inactivo'}</td>
											</tr>

											<tr>
												<td class="td-title">Monto garantia </td>
												<td>${monto_garantia ?? "Sin datos"}</td>
											</tr>

											<tr>
												<td class="td-title">Nombre Reclusorio </td>
												<td>${nombre_reclusorio ?? "Sin datos"}</td>
											</tr>

											<tr>
												<td class="td-title">Suspensión Condicional </td>
												<td>${suspension_condicional ?? "Sin datos"}</td>
											</tr>

											<tr>
												<td class="td-title">Tipo Persona </td>
												<td>${tipo_persona ?? "Sin datos"}</td>
											</tr>
										</tbody>
									</table>
									
								`;

								const accordion = `
									<div id="accordion-VCJ-Personas-${ index_p }" class="accordion-one mg-b-10" role="tablist" aria-multiselectable="true" width="100%">
										<div class="card">
											<div class="card-header" role="tab" id="headingOne">
												<a id="titleAccordion-VCJ-Personas-${ index_p }" style="background: #848f33 !important; color:#fff;" data-toggle="collapse" data-parent="#accordion-VCJ-Personas-${ index_p }" href="#collapseOne-VCJ-Personas-${ index_p }" aria-expanded="true" aria-controls="collapseOne-VCJ-Personas-${ index_p }" class="tx-gray-800 transition collapsed tx-semibold">
													<i class="fas fa-user" style="margin-right:1%;"></i>${nombre ?? "Sin nombre"} ${apellido_paterno ?? ""} ${apellido_materno ?? ""} [ ${calidad_juridica ?? "Sin datos"} ]
												</a>
											</div><!-- card-header -->
											<div id="collapseOne-VCJ-Personas-${ index_p }" class="collapse" role="tabpanel" aria-labelledby="headingOne-VCJ-Personas-${ index_p }">
												<div class="card-body">
													<div class="mg-t-15">
													${tablaSujeto}
													</div>
												</div> <!-- CARD BODY -->
											</div> <!-- BODY COLLAPSE -->
										</div> <!-- CARD -->
									</div> <!-- ACCORDEON VCJ PARTES PROCESALES -->
								`;

								listaSujetos=listaSujetos.concat(tablaSujeto);
								acordeones=acordeones.concat(accordion);

							});

						}

						let tbody_datos_solicitud = `
							<tr>
								<td class="td-title">Fecha de la Solicitud</td>
								<td>${fecha_solicitud ?? "Sin datos"}</td>
							</tr>

							<tr>
								<td class="td-title">Folio Solicitud</td>
								<td>${folio ?? "Sin datos"}</td>
							</tr>

							<tr>
								<td class="td-title">Tipo Remision </td>
								<td>${tipo_remision ?? "Sin datos"}</td>
							</tr>

							<tr>
								<td class="td-title">Situación </td>
								<td>${estatus_actual ?? ""}</td>
							</tr>

							<tr>
								<td class="td-title">Carpeta Judicial</td>
								<td>${carpeta_judicial ?? "Sin datos"}</td>
							</tr>

							<tr>
								<td class="td-title">Tipo Carpeta</td>
								<td>${tipo_carpeta ?? "Sin datos"}</td>
							</tr>


							<tr>
								<td class="td-title">Motivo de la incompetencia</td>
								<td>${motivo_incompetencia ?? "Sin datos"}</td>
							</tr>

							<tr>
								<td class="td-title">Autorizada</td>
								<td>${autorizacion ?? "Sin datos"}</td>
							</tr>

						`;

						body= ` 
							<nav>
								<div class="nav nav-tabs" id="nav-tab" role="tablist">
								<a class="nav-item nav-link active" id="nav-datos-solitiud-tab" data-toggle="tab" href="#nav-datos-solitiud" role="tab" aria-controls="nav-datos-solitiud" aria-selected="true">Datos de la Solicitud</a>
								<a class="nav-item nav-link" id="nav-personas-relacionadas-tab" data-toggle="tab" href="#nav-personas-relacionadas" role="tab" aria-controls="nav-personas-relacionadas" aria-selected="false">Personas</a>
								<a class="nav-item nav-link" id="nav-delitos-no-relacionados-tab" data-toggle="tab" href="#nav-delitos-no-relacionados" role="tab" aria-controls="nav-delitos-no-relacionados" aria-selected="false">Delitos no Relacionados</a>
								<a class="nav-item nav-link" id="nav-documentos-tab" data-toggle="tab" href="#nav-documentos" role="tab" aria-controls="nav-documentos" aria-selected="false">Documentos</a>
								</div>
							</nav>
							<br>
							<div class="tab-content" id="nav-tabContent-solicitud">
									<div class="tab-pane fade show active" id="nav-datos-solitiud" role="tabpanel" aria-labelledby="nav-datos-solitiud-tab">
										<div class="row mb-3" style="justify-content: space-around; padding: 0 9px;">

											<div class="col-md-3" style="text-align: center; border: 1px solid #eee; padding: 4px; font-weight: bold;">
												<div style=" display: flex; justify-content: center; text-align: center; align-items: center; color: #fff; background: #848f33; padding: 4px; margin-bottom:4px;">
													<i class="fas fa-folder" style="margin-right: 3%;"></i> Folio Carpeta Remitida
												</div>
												${folio_carpeta_rem ?? "Sin datos"}
											</div>
			
											<div class="col-md-3" style="text-align: center; border: 1px solid #eee; padding: 4px; font-weight: bold;">
												<div style=" display: flex; justify-content: center; text-align: center; align-items: center; color: #fff; background: #848f33; padding: 4px; margin-bottom:4px;">
													<i class="fas fa-calendar-alt" style="margin-right: 3%;"></i> Fecha de Registro
												</div>
												${fecha_registro ?? "Sin datos"}
											</div>
											
											<div class="col-md-3" style="text-align: center; border: 1px solid #eee; padding: 4px; font-weight: bold;">
												<div style=" display: flex; justify-content: center; text-align: center; align-items: center; color: #fff; background: #848f33; padding: 4px; margin-bottom:4px;">
													<i class="fas fa-folder-open" style="margin-right: 3%;"></i> Carpeta Investigacion
												</div>
												${carpeta_investigacion ?? "Sin datos"}
											</div>
											
											<div class="col-md-3" style="text-align: center; border: 1px solid #eee; padding: 4px; font-weight: bold;">
												<div style=" display: flex; justify-content: center; text-align: center; align-items: center; color: #fff; background: #848f33; padding: 4px; margin-bottom:4px;">
													<i class="fas fa-building" style="margin-right: 3%;"></i> Unidad
												</div>
												${unidad ?? "Sin datos"}
											</div>
										
										</div>
										
										<div class="row" style="padding:2%">
											<div class="table-responsive">
												<table id="datosolicitud" class="table"> 
													<tbody class="table-datos-sujeto">
														${ tbody_datos_solicitud } 
													</tbody>		
												</table>
											</div>
										</div>

									</div>
									<div class="tab-pane fade" id="nav-personas-relacionadas" role="tabpanel" aria-labelledby="nav-personas-relacionadas-tab">
										<div class="accordion" id="acordeon" role="tablist"> ${ acordeones } </div>
									</div>
									<div class="tab-pane fade" id="nav-delitos-no-relacionados" role="tabpanel" aria-labelledby="nav-delitos-no-relacionados-tab">
											<div class="table-responsive">
												<table id="datosno-asociados" class="table"> 
													<tbody class="table-datos-sujeto">
														${ tabla_no_relacionados } 
													</tbody>
												</table>
											</div>
									</div>
									<div class="tab-pane fade" id="nav-documentos" role="tabpanel" aria-labelledby="nav-documentos-tab">
										<div class="row" id="raw-nav-documentos">
										</div>
									</div>
							</div>
							<br>
						`;

						title = `CARPETA JUDICIAL: ${ folio_carpeta_rem } > Detalle Solicitud de Remisión`;

						modal_detalle(title,body,'modalAdministracion');
						setTimeout(function(){muestraDocumentosSolicitudInicial(id_solicitud,'INICIAL');},500);
					}else{
						modal_error(response.message,'modalAdministracion');
					}
				}
			});
		}

		function muestraDocumentosSolicitudInicial(id_solicitud,tipo_solicitud = 'INICIAL', version='todas'){
			$.ajax({
				type: "GET",
        url: "public/ver_documentos/" + id_solicitud + "/" + version,
				data:{
					modo:"completo",
					id_solicitud:id_solicitud,
					tipo_solicitud:tipo_solicitud,
					pagina:1,
					registros_por_pagina:10,
				},
				success:function(response) {
					console.log('nombre_documento', response);
					if( version=='todas' ){ 

						let array_icon={
							"doc":"fas fa-file-word fa-2x",
							"docx":"fas fa-file-word fa-2x",
							"pdf":"fas fa-file-pdf fa-2x",
							"jpg":"fas fa-file-images fa-2x",
							"png":"fas fa-file-images fa-2x",
						};

						let lis = ``;

						$(response).each(function(index_d,d){
							lis = lis + `
								<li class="list-group-item" style="box-shadow: 1px 3px 3px 0px #ccc; border-radius: 13px; cursor: pointer; border:none;" onclick="muestraDocumentosSolicitudInicial('${id_solicitud}','${tipo_solicitud}','${d.id_version}')">
									<p class="mg-b-0" style="text-align:center;">
										<i class="${array_icon[d.nombre_archivo.split('.')[1]]} tx-primary mg-r-8"></i>  &nbsp; &nbsp; &nbsp; 
										<strong class="tx-inverse tx-medium"> ${d.nombre_archivo}</strong> &nbsp; &nbsp; &nbsp; 
									</p>
								</li>
							`;
						});


						$("#raw-nav-documentos").append(`
							<div class="col-lg-4" style="border-right: solid;">
								<ul class="list-group" style="margin-bottom:6px;">
									${lis}
								</ul>
							</div>
		
							<div class="col-lg-8" id="divPreviewArchivoVCJ">

							</div>	
						`);
					}else{
						$("#divPreviewArchivoVCJ").empty();
						$("#divPreviewArchivoVCJ").append(`
							<object data="/temporal.${response.extension}" width="100%" height="700px"></object>
						`);
					}
				}
			});
		}

		function muestraCarpetaJudicial(id_carpeta_judicial){
			console.log("muestra CJ id_carpeta: "+id_carpeta_judicial);
			$('#nav-fracciones-tab').css('display', 'none');
			$('#nav-documento_view-tab').css('display', 'none');

			$('#nav-documento_view-tab').addClass('active');
			$('#nav-documento_view').addClass('active');
			$('#nav-documento_view').addClass('show');

			$('#nav-fracciones-tab').removeClass('active');
			$('#nav-fracciones').removeClass('active');
			$('#nav-fracciones').removeClass('show');
				
			$.ajax({
				method:'POST',
				url:'/public/obtener_carpetas_judiciales',
				data:{
					modo:"completo",
          carpeta_judicial:id_carpeta_judicial,
          pagina:1,
				},
				success:function(response){
					console.log(response);
					if(response.status==100){
						let cj = response.response[0];
						
						let lIimputados=``;
						if(cj.imputados.length){
							lIimputados=lIimputados.concat('<h6 class="mg-b-0">Imputados</h6>');
							$(cj.imputados).each(function(index, imputado){
								lIimputados=lIimputados.concat(`<div class="b-l-2">${imputado.razon_social==null?'':imputado.razon_social}${imputado.nombre==null?'':imputado.nombre}</div>`);
							});
						}

						let lVictimas=``;
						if(cj.victimas.length){
							lVictimas=lVictimas.concat('<h6 class="mg-b-0">Víctimas</h6>');
							$(cj.victimas).each(function(index, victima){
								lVictimas=lVictimas.concat(`<div class="b-l-2">${victima.razon_social==null?'':victima.razon_social}${victima.nombre==null?'':victima.nombre}</div>`);
							});
						}

						let lDelitos=``;
						if(cj.delitos.length){
							lDelitos=lVictimas.concat('<h6 class="mg-b-0">Delitos</h6>');
							$(cj.delitos).each(function(index, delito){
								lDelitos=lDelitos.concat(`<div class="b-l-2">${delito.delito}</div>`);
							});
						}

						let tableDatosCJ = `
							<table class="datos-cj datatable tableDatosSujeto" style="overflow-x: none; display: table">
								<tbody class="table-datos-sujeto">
									<tr>
										<td class="td-title">Tipo de Carpeta </td>
										<td>${cj.nombre_tipo_carpeta ?? "Sin datos"}</td>

										<td class="td-title">Folio Carpeta Judicial</td>
										<td>${cj.folio_carpeta ?? "Sin datos"}</td>
									</tr>

									<tr>
										<td class="td-title">Situación </td>
										<td>${cj.situacion_carpeta ?? ""}</td>

										<td class="td-title">Fecha de creación</td>
										<td>${cj.fecha_creacion ?? "Sin datos"}</td>
									</tr>

									<tr>
										<td class="td-title">Tipo Solicitud</td>
										<td>${cj.tipo_solicitud_ ?? "Sin datos"}</td>
										
										<td class="td-title">Carpeta de Investigación </td>
										<td>${cj.carpeta_investigacion ?? ""}</td>
									</tr>

									<tr>
										<td class="td-title">Fecha de acusación</td>
										<td>${cj.fecha_acusacion ?? "Sin datos"}</td>
										
										<td class="td-title">Fecha Cierre de Investigación </td>
										<td>${cj.fecha_cierre_investigacion ?? "Sin datos"}</td>
									</tr>

								</tbody>
							</table>
						`;

						let title = `${ $("#lbl-titulo-modal-administracion").text() } > Detalle Carpeta Judicial`;

						let body = `
							<div class="row">
								<div class="col-md-12"> <br> ${tableDatosCJ} </div>	
								<div class="col-md"> <br> ${lIimputados} </div>
								<div class="col-md"> <br> ${lVictimas} </div>
								<div class="col-md"> <br> ${lDelitos} </div>
							</div>
						`;
						modal_detalle(title,body,'modalAdministracion');
					}else{ modal_error(response.message,'modalAdministracion');}
				}
			});
		}

		function muestraAudiencia(id_audiencia){
			console.log("muestra Audiencia id_audiencia: "+id_audiencia);
			$('#nav-fracciones-tab').css('display', 'none');
			$('#nav-documento_view-tab').css('display', 'none');

			$('#nav-documento_view-tab').addClass('active');
			$('#nav-documento_view').addClass('active');
			$('#nav-documento_view').addClass('show');

			$('#nav-fracciones-tab').removeClass('active');
			$('#nav-fracciones').removeClass('active');
			$('#nav-fracciones').removeClass('show');
				
			$.ajax({
				method:'GET',
				url:'/public/consultar_audiencias',
				data:{
          id_audiencia:id_audiencia,
					id_unidad_gestion:'',
					fecha_ini:'',
					fecha_fin:'',
          pagina:1,
					registros_por_pagina:10
				},
				success:function(response){
					console.log('Datos de la audiencia:' ,response);
					if(response.status==100){
						
						let audiencia = response.response[0];
						
						let lIimputados=``;
						if(audiencia.imputados.length){
							lIimputados=lIimputados.concat('<ul style="list-style: none; margin: 3% auto; font-size: 0.9em; font-weight: 500; color: #999;">');
							$(audiencia.imputados).each(function(index, imputado){
								lIimputados=lIimputados.concat(`<li style="border-left: 3px solid #848f33; padding: 4px; margin: 1% auto;">${imputado.razon_social==null?'':imputado.razon_social}${imputado.nombre==null?'':imputado.nombre}</li>`);
							});
							lIimputados=lIimputados.concat('</ul>');
						}

						let lVictimas=``;
						if(audiencia.victimas.length){
							lVictimas=lVictimas.concat('<ul style="list-style: none; margin: 3% auto; font-size: 0.9em; font-weight: 500; color: #999;">');
							$(audiencia.victimas).each(function(index, victima){
								lVictimas=lVictimas.concat(`<li style="border-left: 3px solid #848f33; padding: 4px; margin: 1% auto;">${victima.razon_social==null?'':victima.razon_social}${victima.nombre==null?'':victima.nombre}</li>`);
							});
							lVictimas=lVictimas.concat('</ul>');
						}

						let lDelitos=``;
						if(audiencia.delitos.length){
							lDelitos=lDelitos.concat('<ul style="list-style: none; margin: 3% auto; font-size: 0.9em; font-weight: 500; color: #999;">');
							$(audiencia.delitos).each(function(index, delito){
								lDelitos=lDelitos.concat(`<li style="border-left: 3px solid #848f33; padding: 4px; margin: 1% auto;">${delito.delito}</li>`);
							});
							lDelitos=lDelitos.concat('</ul>');
						}

						let lJueces=``;
						if(audiencia.juez != ''){
							lJueces=lJueces.concat('<ul style="list-style: none; margin: 3% auto; font-size: 0.9em; font-weight: 500; color: #999;">');
							lJueces=lJueces.concat(`<li style="border-left: 3px solid #848f33; padding: 4px; margin: 1% auto;">${audiencia.juez.nombre_usuario} [${audiencia.juez.cve_juez}]</li>`);
							lJueces=lJueces.concat('</ul>');
						}

					
						let tableDatosCJ = `
							<div class="col-md-6">
								<div class="table-responsive">
									<table class="table">
										<tbody >
											<tr>
												<td class="td-title">Estatus Audiencia </td>
												<td>${audiencia.estatus_audiencia ?? "Sin datos"}</td>
											</tr>

											<tr>
												<td class="td-title">Fecha de audiencia </td>
												<td>${audiencia.fecha_audiencia ?? "Sin datos"}</td>
											</tr>

											<tr>
												<td class="td-title">Tipo Audiencia</td>
												<td>${audiencia.tipo_audiencia ?? "Sin datos"}</td>
											</tr>

											<tr>
												<td class="td-title">Nombre Inmueble</td>
												<td>${audiencia.nombre_inmueble ?? "Sin datos"}</td>
											</tr>

											<tr>
												<td class="td-title">Nombre Unidad</td>
												<td>${audiencia.nombre_unidad ?? "Sin datos"}</td>
											</tr>

										</tbody>
									</table>
								</div>
							</div>
							<div class="col-md-6">
								<div class="table-responsive">
									<table class="table">
										<tbody >
											<tr>
												<td class="td-title">Folio Carpeta Judicial</td>
												<td>${audiencia.folio_carpeta ?? "Sin datos"}</td>
											</tr>

											<tr>
												<td class="td-title">Hora de audiencia</td>
												<td>De ${audiencia.hora_inicio_audiencia+"hrs" ?? "Sin datos"} a ${audiencia.hora_fin_audiencia+"hrs" ?? "Sin datos"} </td>
											</tr>

											<tr>
												<td class="td-title">Carpeta de Investigación </td>
												<td>${audiencia.carpeta_investigacion ?? ""}</td>
											</tr>

											<tr>
												<td class="td-title">descripcion inmueble </td>
												<td>${audiencia.descripcion_inmueble ?? "Sin datos"}</td>
											</tr>

											<tr>
												<td class="td-title">Sala </td>
												<td>${audiencia.nombre_sala ?? "Sin datos"}</td>
											</tr>

										</tbody>
									</table>
								</div>
							</div>
						`;
						

						let title = `${ $("#lbl-titulo-modal-administracion").text() } > Detalle Audiencia`;

						let body = `
							<div class="row" style="justify-content: space-around; padding: 0 9px;">

								<div class="col-md-3">
									<div style=" display: flex; justify-content: center; text-align: center; align-items: center; color: #fff; background: #848f33; padding: 4px;">
										<i class="fas fa-users" style="margin-right: 3%;"></i> Imputados
									</div>
									${lIimputados}
								</div>

								<div class="col-md-3">
									<div style=" display: flex; justify-content: center; text-align: center; align-items: center; color: #fff; background: #848f33; padding: 4px;">
										<i class="fas fa-users" style="margin-right: 3%;"></i> Victimas
									</div>
									${lVictimas}
								</div>
								
								<div class="col-md-3">
									<div style=" display: flex; justify-content: center; text-align: center; align-items: center; color: #fff; background: #848f33; padding: 4px;">
										<i class="fas fa-exclamation-triangle" style="margin-right: 3%;"></i> Delitos
									</div>
									${lDelitos}
								</div>
								
								<div class="col-md-3">
									<div style=" display: flex; justify-content: center; text-align: center; align-items: center; color: #fff; background: #848f33; padding: 4px;">
										<i class="fas fa-gavel" style="margin-right: 3%;"></i> Juez
									</div>
									${lJueces}
								</div>
							
							</div>

							<div class="row" style="justify-content: space-around; padding: 0 30px; margin-top: 3%;">
									${tableDatosCJ}
							</div>

						`;
						modal_detalle(title,body,'modalAdministracion');
					}else{ modal_error(response.message,'modalAdministracion');}
				}
			});
		}

		function muestraAcuerdo(id_acuerdo){
			console.log("muestra acuerdo id_acuerdo: "+id_acuerdo);
			$('#nav-fracciones-tab').css('display', 'block');
			$('#nav-documento_view-tab').css('display', 'block');

			$('#nav-documento_view-tab').addClass('active');
			$('#nav-documento_view').addClass('active');
			$('#nav-documento_view').addClass('show');

			$('#nav-fracciones-tab').removeClass('active');
			$('#nav-fracciones').removeClass('active');
			$('#nav-fracciones').removeClass('show');

			verFraccionesPDF(id_acuerdo, carpetaActiva.victimas);

			$.ajax({
				method:'GET',
				url:'/public/consulta_acuerdos_carpeta',
				data:{
					//modo:"completo",
          id_acuerdo:id_acuerdo,
					obtener_archivo:true,
					id_unidad:carpetaActiva.id_unidad,
          pagina:1,
					registros_por_pagina:10,
				},
				success:function(response){
					console.log(response);
					//return true;
					if(response.status==100){
						let acdo= response.response[0];

						let tableDatosAcuerdo = `
							<table class="datos-acuerdo datatable tableDatosSujeto" style="overflow-x: none; display: table">
								<tbody class="table-datos-sujeto">
									<tr>
										<td class="td-title">Carpeta Judicial </td>
										<td>${acdo.folio_carpeta ?? "Sin datos"}</td>
									</tr>

									<tr>
										<td class="td-title">Fecha de firmado</td>
										<td>${acdo.fecha_firma ?? "Sin datos"}</td>
									</tr>

									<tr>
										<td class="td-title"> Tipo Acuerdo </td>
										<td>${acdo.tipo_documento ?? "Sin datos"}</td>
									</tr>
											
									<tr>
										<td class="td-title">Estado de firmado</td>
										<td cols>${acdo.estatus_firma ?? "Sin datos"}</td>	
									</tr>

									<tr>
										<td class="td-title"> Firmado por </td>
										<td> ${acdo.tipos_usuario_juez[0].descripcion? 'El '+acdo.tipos_usuario_juez[0].descripcion+'<br>' : ''} ${acdo.nombre_juez ?? "Sin datos"}</td>
									</tr>
											
									<tr>	
										<td class="td-title">Fecha de firmado</td>
										<td>${acdo.fecha_firma?? "Sin datos"}</td>	
									</tr>
									
									<tr>
										<td class="td-title" colspan="2"> Comentarios </td>
									</tr>
											
									<tr>
										<td colspan="2">${acdo.resumen ?? "Sin comentarios"}</td>
									</tr>
								</tbody>
							</table>
						`;

						let title = `${ $("#lbl-titulo-modal-administracion").text() } > Detalle del documento  ${acdo.tipo_documento??''}`;
						let documento =`<object id="DocumentoAcuerdoVCJ" height="700px" width="100%" class="mg-t-25" data="data:application/pdf;base64,${acdo.documento.b64}"></object>`;
	
						let body = `
							<div class="row">
								<div class="col-md-4"><br> ${tableDatosAcuerdo} </div>
								<div class="col-md-8"> ${documento} </div>
							</div>
						`;
						modal_detalle(title,body,'modalAdministracion');

					}else{ modal_error(response.message,'modalAdministracion');}
				}
			});
		
		}

		function verFraccionesPDF(id_acuerdo, victimas){
      var option = '';
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

		function muestraPromocion(id_promocion){
			console.log("muestra Promocion id_promocion: "+id_promocion);
			$('#nav-fracciones-tab').css('display', 'none');
			$('#nav-documento_view-tab').css('display', 'none');

			$('#nav-documento_view-tab').addClass('active');
			$('#nav-documento_view').addClass('active');
			$('#nav-documento_view').addClass('show');

			$('#nav-fracciones-tab').removeClass('active');
			$('#nav-fracciones').removeClass('active');
			$('#nav-fracciones').removeClass('show');

			$.ajax({
				method:'GET',
				url:'/public/obtener_promociones',
				data:{
					//modo:"completo",
          id_promocion:id_promocion,
          pagina:1,
				},
				success:function(response){
					console.log(response);
					//return true;
					if(response.status==100){
						let promo= response.response[0];

						let lIpersonas=`<h6 class="mg-b-0">Personas a notificar</h6>`;
						if(promo.personas != null ){
							//lIpersonas=lIpersonas.concat('<h6 class="mg-b-0">Personas</h6>');
							$(promo.personas).each(function(index, persona){
								lIpersonas=lIpersonas.concat(`<div class="b-l-2">${persona.razon_social==null?'':persona.razon_social} ${persona.nombre==null?'':persona.nombre} ${persona.apellido_paterno==null?'':persona.apellido_paterno} ${persona.apellido_materno==null?'':persona.apellido_materno}</div>`);
							});
						}else{ lIpersonas=lIpersonas.concat(`<div class="b-l-2"> <small>Sin datos</small> </div>`);  }

						let lIpromoventes=`<h6 class="mg-b-0">Promoventes</h6>`;
						if(promo.promovente != null ){
							//lIpromoventes=lIpromoventes.concat('<h6 class="mg-b-0">Promoventes</h6>');
							//$(promo.promovente).each(function(index, promovente){
								lIpromoventes=lIpromoventes.concat(`<div class="b-l-2"> ${promo.promovente} ${promo.promovente_calidad_juridica==undefined || promo.promovente_calidad_juridica==null ? '' : '( '+ promo.promovente_calidad_juridica +' )'   }</div>`);
							//});
						}else{ lIpromoventes=lIpromoventes.concat(`<div class="b-l-2"> <small>Sin datos</small> </div>`);  }

						let tableDatosPromocion = `
							<table class="datos-promocion datatable tableDatosSujeto" style="overflow-x: none; display: table">
								<tbody class="table-datos-sujeto">
									<tr>
										<td class="td-title" style="width: 40% !important;">Folio Promoción </td>
										<td style="width: 60% !important;">${promo.folio_promocion ?? "Sin datos"}</td>
									</tr>
									
									<tr>
										<td class="td-title">Origen Promocion</td>
										<td>${promo.tipo_promocion == "unidad_usuario_sesion"? "Generada en sistema SIGJ Penal" : "Recibida por XML"}</td>
									</tr>

									<tr>
										<td class="td-title"> Tipo Requerimiento </td>
										<td>${promo.tipo_requerimiento ?? "Sin datos"}</td>
									</tr>

									<tr>
										<td class="td-title"> Tipo Audiencia </td>
										<td>${promo.tipo_audiencia ?? "Sin datos"}</td>
									</tr>
									
									<tr>
										<td class="td-title"> Resumen </td>
										<td>${promo.resumen ?? "Sin datos"}</td>
									</tr>
								</tbody>
							</table>
						`;

						let title = `${ $("#lbl-titulo-modal-administracion").text() } > Detalle de Promocion con Folio ${promo.folio_promocion}`;

						let body = `
							<div class="row">
								<div class="col-md-4"> 
									<br> ${tableDatosPromocion} 
									<br> <div class="col-md"> 
									<br> ${lIpromoventes} 
								</div>
								<div class="col-md"> <br> ${lIpersonas} </div></div>
								
								<div class="col-md-8" id="documentoPromocion">  </div>
							</div>
						`;
						modal_detalle(title,body,'modalAdministracion');
						setTimeout(function(){muestraDocumentoPromocion(id_promocion)},300);
					}else{ modal_error(response.message,'modalAdministracion');}
				}
			});
		}

		function muestraDocumentoPromocion(id_promocion){
			console.log('SE descarag el pdf de la promocion con id:'+id_promocion);
			$.ajax({
				method:'GET',
				url:'/public/descargar_pdf_promocion/'+id_promocion,
				success:function(response){
					console.log('url_doc',response.response);
					if(response.status==100){
						$("#documentoPromocion").append(`
						<object type="application/pdf"
								data="${response.response}"
								width="100%"
								height="700px">
						</object>
						`);
					}else{ modal_error(response.message,'modalAdministracion');}
				}
			});
		}

		function muestraDocumentoAsociado( id_documento ){
			$('#nav-fracciones-tab').css('display', 'none');
			$('#nav-documento_view-tab').css('display', 'none');

			$('#nav-documento_view-tab').addClass('active');
			$('#nav-documento_view').addClass('active');
			$('#nav-documento_view').addClass('show');

			$('#nav-fracciones-tab').removeClass('active');
			$('#nav-fracciones').removeClass('active');
			$('#nav-fracciones').removeClass('show');

      $.ajax({
        method:'POST',
        url:'/public/obtener_documentos_asociados_carpeta',
        data:{
          carpeta : $("#id_carpeta_judicial").val(),
          id_solicitud : $("#id_solicitud").val(),
          tipo_solicitud : $("#tipo_solicitud").val(),
          id_documento : id_documento,
          documento_nombre: 'documento',
          extension: 'pdf',
          documento_origen : 'CJ',
        },
        success:function(response){
          console.log('RESPUESTA VER DOC :',response);
          if( !response.message){
						modal_detalle('DOCUMENTO',`<object data="${response.response}"	width="100%"	height="600">	</object>`,'modalAdministracion');
            //var win = window.open(response.response, '_blank');
          }else{
            modal_error(response.message,'modalAdministracion');
          }
        } // success
      }); // ajax
    }


  </script>