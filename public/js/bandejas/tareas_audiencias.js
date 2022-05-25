let tipo_recursos_html,
    generarCalendarios=false,
    generarCalendarios_1=false,
    horarios_ocupados=[],
    id_event_recursos=0,
    recursos_ocupados=[];

async function resolverPorAudiencia(index_global){
    generarCalendarios=true;
    generarCalendarios_1=true;
    abreModal('modal_loading');
    let bandera_juez_excusa=
    bandera_juez_tramite=
    comentarios_excusa="-";
    id_event_recursos=0;
    recursos_adi=[];

    //se obtienen catálogos
    datosSolicitud= await obtenerDatosSolicitud_arreglo(tareaSeleccionada.id_solicitud);
    siguiente_juez_control = await obtener_siguiente_juez_control();
    inmuebles = await obtener_inmuebles();

    //const {tabla_asociada, clave_bandeja, descripcion_bandeja,id_acuerdo}=tareaSeleccionada;
    fecha_carpeta_judicial=datosSolicitud.response[0].fecha_recepcion;
    tipo_audiencia=datosSolicitud.response[0].tipo_audiencia;
    carpeta_judicial=tareaSeleccionada.carpeta_judicial[0].folio_carpeta;
    juez_asignado="["+siguiente_juez_control.response.cve_juez+"] "+siguiente_juez_control.response.nombre;
    clave_juez_asignado=siguiente_juez_control.response.cve_juez;
    id_juez_asignado=siguiente_juez_control.response.id_usuario;
    let inmmuebles_html=`<select class="form-control select2" data-placeholder="" id="select_inmueble" onchange="seleccionarInmuebleSalas()">`;
    for(i=0; i<inmuebles.response.length; i++){
        
        if( parseInt(inmueble_usu) == inmuebles.response[i].id_inmueble ){
            inmmuebles_html+=`<option value="${inmuebles.response[i].id_inmueble}" selected>${inmuebles.response[i].nombre_inmueble}</option>`;
        }else{
            inmmuebles_html+=`<option value="${inmuebles.response[i].id_inmueble}">${inmuebles.response[i].nombre_inmueble}</option>`;
        }
    }
    inmmuebles_html+=`</select>`;

    d=new Date();

    if((d.getMonth()+1) < 10){
        mes_hidden="0"+(d.getMonth()+1);
    }else{
        mes_hidden=(d.getMonth()+1);
    }

    if(d.getDate() <10){
        dia_hidden="0"+d.getDate();
    }else{
        dia_hidden=d.getDate();
    }

    fecha_audiencia_hidden=d.getFullYear()  + "-" + mes_hidden + "-" + dia_hidden

    //recursos adicionales
    //tipo de recursos
    tipo_recursos = await obtener_ver_tipos_recursos();
    tipo_recursos_html=`<select class="form-control select2-show-search" data-placeholder="" id="tipo_recurso" onchange="seleccionarNombreTiposRecursos();">`;
    for(i=0; i<tipo_recursos.response.length; i++){
        tipo_recursos_html+=`<option value="${tipo_recursos.response[i].id_tipo_recurso}">[${tipo_recursos.response[i].codigo}] ${tipo_recursos.response[i].tipo_recurso}</option>`;
    }
    tipo_recursos_html+=`</select>`;

    if(tUsuario==31){
        $('#resolucion').html(`
            <div class="card bd-0">
                <div class="card-header ">
                    <ul class="nav nav-tabs  card-header-tabs">
                        <li class="nav-item">
                        <a class="nav-link bd-0 active pd-y-8" href="#audiencia_tab_datos_generales" data-toggle="tab">Datos Generales</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link bd-0" href="#audiencia_tab_datos_calendario" data-toggle="tab" onclick="cargarCalendarios();" id="tabCalendar">Calendario</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link bd-0" href="#audiencia_tab_datos_recursos" data-toggle="tab" onclick="">Recursos adicionales</a>
                        </li>
                    </ul>
                </div><!-- card-header -->
                <div class="card-body bd bd-t-0">
                    <div class="tab-content">
                        <div class="tab-pane active" id="audiencia_tab_datos_generales">
                            <div class="form-layout">
                                <div class="row mg-b-25">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                        <label class="form-control-label">Carpeta Juicial: </label>
                                        <input class="form-control" type="text" name="" value="${carpeta_judicial}" disabled placeholder="">
                                        </div>
                                    </div><!-- col-4 -->
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                        <label class="form-control-label">Folio de Aud: </label>
                                        <input class="form-control" type="text" name="lastname" value="N/E" disabled placeholder="">
                                        </div>
                                    </div><!-- col-4 -->
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                        <label class="form-control-label">Situación de audicencia: </label>
                                        <input class="form-control" type="text" name="email" value="En espera de confirmación" placeholder="" disabled>
                                        </div>
                                    </div><!-- col-4 -->
                                    <div class="col-lg-12">
                                        <div class="form-group mg-b-10-force">
                                            <label class="form-control-label">Tipo de Audiencia: </label>
                                            <input class="form-control" type="text" name="" value="${tipo_audiencia}" disabled placeholder="">
                                        </div>
                                    </div><!-- col-4 -->
                                    <div class="col-lg-4">
                                        <label class="form-control-label">Fecha: </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control fc-datepicker" placeholder="MM/DD/YYYY" disabled value="${fecha_carpeta_judicial}">
                                        </div>
                                    </div><!-- col-4 -->
                                    <div class="col-lg-8">
                                        <label class="form-control-label">Asignar Juez: </label>
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <button class="btn bd bd-r-0 bg-white tx-gray-600" type="button"><i class="fa fa-retweet"></i></button>
                                            </span>
                                            <input type="text" class="form-control" placeholder="" value="${juez_asignado}" disabled>
                                        </div><!-- input-group -->
                                    </div><!-- col-4 -->
                                </div><!-- row -->
                            </div>
                        </div><!-- tab-pane -->
                        <div class="tab-pane" id="audiencia_tab_datos_calendario">
                            <div class="row mg-b-25">
                                <div class="col-lg-5">
                                    <div class="row mg-b-25">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="form-control-label">Juez Asignado: <span class="tx-danger">*</span></label>
                                                <input class="form-control" type="text" name="nombre_juez_asignado" id="nombre_juez_asignado" value="${juez_asignado}" disabled>
                                                <input type="hidden" value="${id_juez_asignado}" id="id_juez_asignado" name="id_juez_asignado">
                                                <input type="hidden" value="${clave_juez_asignado}" id="clave_juez_asignado" name="clave_juez_asignado">
                                                <input type="hidden" value="${bandera_juez_excusa}" id="bandera_juez_excusa" name="bandera_juez_excusa">
                                                <input type="hidden" value="${bandera_juez_tramite}" id="bandera_juez_tramite" name="bandera_juez_tramite">
                                                <input type="hidden" value="${comentarios_excusa}" id="comentarios_excusa" name="comentarios_excusa">
                                                <input type="hidden" value="${fecha_audiencia_hidden}" id="fecha_audiencia_hidden" name="fecha_audiencia_hidden" onchange="agregarHorario()">
                                            </div>
                                        </div><!-- col-4 -->
                                        <div class="col-lg-8">
                                            <div class="form-group">
                                                <label class="ckbox">
                                                    <input type="checkbox" onclick="seleccionarJuezTramite();" id="ckbox_juez_tramite"><span>Asignar Juez de Trámite</span>
                                                </label>
                                            </div>
                                        </div><!-- col-4 -->
                                        <div class="tx-right col-lg-4">
                                            <a href="#" class=" mg-l-auto btn btn-primary btn-icon" data-toggle="modal" data-target="#modaldemo3"  onclick="cargarListaJuez(5);"><div><i class="icon ion-person-stalker"></i></div></a>
                                        </div><!-- col-4 -->
                                        <div class="col-lg-2 d-none">
                                            <a href="#" class="btn btn-primary btn-icon" data-toggle="modal" data-target="#modaldemo3" onclick="cargarListaJuez(15);"><div><i class="icon ion-edit"></i></div></a>
                                        </div><!-- col-4 -->
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="form-control-label">Inmueble: <span class="tx-danger">*</span></label>
                                                ${inmmuebles_html}
                                            </div>
                                        </div><!-- col-4 -->
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="form-control-label">Sala: <span class="tx-danger">*</span></label>
                                                <select class="form-control select2" data-placeholder="" id="select_inmueble_salas" onchange="limpiaCalendar(),seleccionarHorariosSalas()">
                                                    <option value="14">Prueba</option>
                                                </select>
                                            </div>
                                        </div><!-- col-4 -->
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="form-control-label">Hora: <span class="tx-danger">*</span></label>
                                                <div class="row mg-b-25">
                                                    <div class="col-lg-6">
                                                        <div class="">
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text">
                                                                    <i class="fa fa-clock-o tx-16 lh-0 op-6"></i>
                                                                    </div><!-- input-group-text -->
                                                                </div><!-- input-group-prepend -->
                                                                <input id="tp_hora_inicio" type="text" class="form-control" placeholder="Hora de inicio" onchange="agregarHorario()">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="">
                                                            <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">
                                                                <i class="fa fa-clock-o tx-16 lh-0 op-6"></i>
                                                                </div><!-- input-group-text -->
                                                            </div><!-- input-group-prepend -->
                                                            <input id="tp_hora_final" type="text" class="form-control" placeholder="Hora de finalización"  onchange="agregarHorario()">
                                                            </div>
                                                        </div><!-- wd-150 -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- col-4 -->
                                        <div class="col-lg-12">
                                            <label class="form-control-label">Día de la audiencia: <span class="tx-danger">*</span></label>
                                            <div id="cal_here" ></div>
                                        </div><!-- col-4 -->
                                    </div>
                                </div>
                                <div class="col-lg-7" >
                                    <div class="section-wrapper " style="padding: 0px; border-top:none; height:100%;">
                                        <div id="scheduler_here" class="dhx_cal_container ht-auto" style='width:100%; height:100%;'>
                                            
                                        </div>
                                    </div><!-- section-wrapper -->
                                </div>
                            </div>
                        </div><!-- tab-pane -->
                        <div class="tab-pane" id="audiencia_tab_datos_recursos">
                            <input type="hidden" value="${fecha_audiencia_hidden}" id="fecha_recurso_adicional_hidden" name="fecha_recurso_adicional_hidden">
                            <div class="row mg-b-25">
                                <div class="col-lg-5">
                                    <div class="row mg-b-25">
                                        <div class="col-lg-12 d-none">
                                            <div id="cal_here_recursos" ></div>
                                        </div>
                                        <div class="col-lg-12">
                                            <hr>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="form-control-label">Tipo de Recurso: <span class="tx-danger">*</span></label>
                                                ${tipo_recursos_html}
                                            </div>
                                        </div><!-- col-4 -->
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="form-control-label">Nombre del Tipo de Recurso: <span class="tx-danger">*</span></label>
                                                <select class="form-control select2-show-search" data-placeholder="" id="nombre_tipo_recurso" onchange="seleccionarHorariosRecursos()">
                                                </select>
                                            </div>
                                        </div><!-- col-4 -->
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="form-control-label">Hora: <span class="tx-danger">*</span></label>
                                                <div class="row ">
                                                    <div class="col-md-6">
                                                        <div class="">
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text">
                                                                    <i class="fa fa-clock-o tx-16 lh-0 op-6"></i>
                                                                    </div><!-- input-group-text -->
                                                                </div><!-- input-group-prepend -->
                                                                <input id="rec_adicional_hora_inicio" type="text" class="form-control" placeholder="Hora de inicio" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="wd-auto ">
                                                            <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">
                                                                <i class="fa fa-clock-o tx-16 lh-0 op-6"></i>
                                                                </div><!-- input-group-text -->
                                                            </div><!-- input-group-prepend -->
                                                            <input id="rec_adicional_hora_final" type="text" class="form-control" placeholder="Hora de finalización" >
                                                            </div>
                                                        </div><!-- wd-150 -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- col-4 -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-control-label">Fecha de inicio: <span class="tx-danger">*</span></label>
                                                <div class="">
                                                    <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                        <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                                        </div>
                                                    </div>
                                                    <input type="text" class="form-control fc-datepicker" placeholder="MM/DD/YYYY" value="${fecha_audiencia_hidden}" readonly id="fecha_recurso_inicio">
                                                    </div>
                                                </div><!-- wd-200 -->
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-control-label">Fecha de finalización: <span class="tx-danger">*</span></label>
                                                <div class="">
                                                    <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                        <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                                        </div>
                                                    </div>
                                                    <input type="text" class="form-control fc-datepicker" placeholder="MM/DD/YYYY"  value="${fecha_audiencia_hidden}" readonly id="recha_recurso_final">
                                                    </div>
                                                </div><!-- wd-200 -->
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="form-control-label">Comentarios: <span class="tx-danger">*</span></label>
                                                <textarea rows="2" class="form-control" placeholder="Comentarios" id="comentarios_rue"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <button onclick="agregarHorarioRec()" class="btn btn-primary">Agregar recurso</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-7">

                                    <div class="section-wrapper " style="padding: 0px; border-top:none; height:100%;">
                                        <div id="scheduler_here_recursos" class="dhx_cal_container ht-auto" style='width:100%; height:100%;'>
                                            <div class="dhx_cal_navline">
                                                <div class="dhx_cal_prev_button">&nbsp;</div>
                                                <div class="dhx_cal_next_button">&nbsp;</div>
                                                <div class="dhx_cal_today_button"></div>
                                                <div class="dhx_cal_date"></div>
                                                <div class="dhx_cal_tab" name="day_tab" style="right:204px;"></div>
                                            </div>
                                            <div class="dhx_cal_header">
                                            </div>
                                            <div class="dhx_cal_data">
                                            </div>
                                        </div>
                                    </div><!-- section-wrapper -->

                                </div>
                            </div>
                        </div><!-- tab-pane -->
                    </div><!-- tab-content -->
                </div><!-- card-body -->
            </div><!-- card -->
            <style>
                .select2-container--open {
                    z-index: 9999999
                }
            </style>
        `);

        $(function() {
            'use strict';

            $('#tp_hora_inicio').timepicker({
                'scrollDefault': 'now',
                minTime: '0',
                maxTime: '23'
            });
            $('#tp_hora_final').timepicker({
                'scrollDefault': 'now',
                minTime: '0',
                maxTime: '23'
            });
            $('.select2').select2({minimumResultsForSearch: Infinity});
            $('.select2-show-search').select2({minimumResultsForSearch: ''});


            setTimeout(function(){
                
            },1000);
            calendarios_recursos();
            cierraLoading();
            seleccionarNombreTiposRecursos();

        });
    }
}


function cargarListaJuez(tipo=5){
    $('#modalDatosTarea').modal('hide');
    url_post="";
    if(tipo==5){
        url_post='/public/obtener_jueces_unidad';
    }
    else if(tipo==15){
        url_post='/public/obtener_jueces_ejecucion';
    }

    juezFirmante=$('#id_juez_asignado').val();
    $('#modaldemo3').find('.modal-body').html('<div class="col-md-12 col-xl-12"><div class="d-flex  ht-300 pos-relative align-items-center">    <div class="sk-three-bounce">        <div class="sk-child sk-bounce1 bg-gray-800"></div>        <div class="sk-child sk-bounce2 bg-gray-800"></div>        <div class="sk-child sk-bounce3 bg-gray-800"></div>      </div> </div><!-- d-flex --></div><!-- col-4 -->');
    let jueces='';
    $.ajax({
        method:'POST',
        url:url_post,
        async:true,
        data:{

        },
        success:function(response){
            $('#modaldemo3').find('.modal-header').html(`
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Lista de Jueces</h6>
            `);

            if(response.status==100){
                $(response.response).each(function(index, juez){
                    const {id_usuario, nombres, apellido_paterno, apellido_materno, cve_juez}=juez;
                    if(juezFirmante==id_usuario){
                        jueces=jueces.concat(`<option class="text-uppercase" value="${id_usuario}" selected>[${cve_juez}] ${nombres} ${apellido_paterno} ${apellido_materno}</option>`);
                    }else{
                        jueces=jueces.concat(`<option class="text-uppercase" value="${id_usuario}">[${cve_juez}] ${nombres} ${apellido_paterno} ${apellido_materno}</option>`);
                    }
                });

                $('#modaldemo3').find('.modal-body').html(`
                    <div class="row mg-b-25">
                        <div class="col-lg-6">
                            <div class="row mg-b-25">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label">Lista de Jueces: <span class="tx-danger">*</span></label>
                                        <select class="form-control select2" data-placeholder="" id="seleccion_juez_popup">
                                            ${jueces}
                                        </select>
                                    </div>
                                </div><!-- col-4 -->
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label">Comentarios:</label>
                                <textarea class="form-control" type="text" id="comentarios" name="comentarios_excusa" autocomplete="off" value=""></textarea>
                            </div>
                        </div>
                    </div>
                `);

                $('#modaldemo3').find('.modal-footer').html(`
                    <button type="button" class="btn btn-primary" onclick="seleccionarJuez(), abreModal('modalDatosTarea',400)">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="boton_cerrar_segundo" onclick="abreModal('modalDatosTarea',400)">Cerrar</button>
                `);
                setTimeout(()=>{
                    $('#seleccion_juez_popup').select2({minimumResultsForSearch: ''});
                },100);
            }else{
                $('#modaldemo3').find('.modal-body').html(`<h4>${response.message}</h4>`);
                    $('#modaldemo3').find('.modal-footer').html(`
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="boton_cerrar_segundo" onclick="abreModal('modalDatosTarea',400)">Cerrar</button>
                `);          
            }
        }
    });

}

let id_juez_asignado_global, nombre_juez_asignado_global;
/*
*   TIPO DE RECURSOS
*/
function irRecursos(){
    if( horario_valido == "1" ){
        $('#irRecursos').removeAttr('disabled');
        $('#textRecursos').addClass('d-none')
    }else{
        $('#irRecursos').attr('disabled', true);
        $('#textRecursos').removeClass('d-none')
    }
}

function obtener_ver_tipos_recursos(){
    return new Promise(resolve => {
        $.ajax({
            method:'POST',
            url:'/public/obtener_ver_tipos_recursos',
            async:true,
            data:{

            },
            success:function(response){
                
                resolve(response);
            }
        });

    });
}


function obtener_nombre_tipos_recursos(id_tipo_recurso){
    return new Promise(resolve => {
        $.ajax({
        method:'POST',
        url:'/public/obtener_nombre_tipos_recursos',
        async:true,
        data:{
            id_tipo_recurso:id_tipo_recurso
        },
        success:function(response){
            
            resolve(response);
        }
        });
    });
}

async function seleccionarNombreTiposRecursos(){

    nombre_tipos_recursos = await obtener_nombre_tipos_recursos($('#tipo_recurso').val());
    //$('#select_inmueble_salas').val(null).trigger('change');
    $('#nombre_tipo_recurso').empty();

    if( nombre_tipos_recursos.response.length >0 ){
        
        for(i=0; i<nombre_tipos_recursos.response[0].recursos.length; i++){

            var newOption = new Option("["+nombre_tipos_recursos.response[0].recursos[i].cve_recurso+"] "+nombre_tipos_recursos.response[0].recursos[i].nombre_recurso, nombre_tipos_recursos.response[0].recursos[i].id_recurso_audiencia, false, false);
            $('#nombre_tipo_recurso').append(newOption);
        }
    
    }
    $('#nombre_tipo_recurso').trigger('change');

}

async function seleccionarHorariosRecursos(){
    scheduler_1.clearAll();
    sala_horarios = await obtener_horarios_recursos(); 
    recursos_ocupados=[];
    if(sala_horarios.status == 100){
        recursos_ocupados=sala_horarios.response;
        $(sala_horarios.response).each(function(index, horario){
            const {fecha_requerido_inicio,fecha_requerido_fin, horario_requerido_inicio,horario_requerido_fin,tipo_recurso,nombre_recurso}=horario;
            
            scheduler_1.deleteEvent(fecha_requerido_inicio+fecha_requerido_fin+horario_requerido_inicio+horario_requerido_fin);
            scheduler_1.addEvent({
                id:fecha_requerido_inicio+fecha_requerido_fin+horario_requerido_inicio+horario_requerido_fin,
                start_date: fecha_requerido_inicio+' '+horario_requerido_inicio,
                end_date:  fecha_requerido_fin+' '+horario_requerido_fin,
                text:   tipo_recurso+'<br>'+nombre_recurso,
                
            })
        });
    }
}

function obtener_horarios_recursos(){

    return new Promise(resolve => {
        $.ajax({
            method:'POST',
            url:'/public/obtener_horarios_recursos',
            async:true,
            data:{
                fecha:$('#fecha_audiencia_hidden').val(),
                tipo_recurso:$('#nombre_tipo_recurso').val()
            },
            success:function(response){
                resolve(response);
            }
        });
    });
}

function seleccionar_recursos_adicionales(){

    if($('#rec_adicional_hora_inicio').val()==""){
        alert("El horario inicial es obligatorio.");
        $('#rec_adicional_hora_inicio').focus();
        return false;
    }
    else if($('#rec_adicional_hora_final').val()==""){
        alert("El horario final es obligatorio.");
        $('#rec_adicional_hora_final').focus();
        return false;
    }
    else{
        tipo_recurso_nombre = $('#tipo_recurso option:selected').text();
        tipo_recurso_id = $('#tipo_recurso').val();
        nombre_tipo_recurso_nombre = $('#nombre_tipo_recurso option:selected').text();
        nombre_tipo_recurso_id = $('#nombre_tipo_recurso').val();

        rec_adicional_hora_inicio = $('#rec_adicional_hora_inicio').val();
        rec_adicional_hora_final = $('#rec_adicional_hora_final').val();
        fecha_recurso_adicional_hidden = $('#fecha_recurso_adicional_hidden').val();

        $('#div_lista_recusos_materiales').append(`
            <div class="file-item arr_recursos_adicionales">
                <input type="hidden" id="tipo_recurso_id" name="tipo_recurso_id" value="${tipo_recurso_id}">
                <input type="hidden" id="nombre_tipo_recurso_id" name="nombre_tipo_recurso_id" value="${nombre_tipo_recurso_id}">
                <input type="hidden" id="rec_adicional_hora_inicio" name="rec_adicional_hora_inicio" value="${rec_adicional_hora_inicio}">
                <input type="hidden" id="rec_adicional_hora_final" name="rec_adicional_hora_final" value="${rec_adicional_hora_final}">
                <input type="hidden" id="fecha_recurso_adicional_hidden" name="fecha_recurso_adicional_hidden" value="${fecha_recurso_adicional_hidden}">

                <div class="row no-gutters wd-100p">
                <div class="col-9 col-sm-5 d-flex align-items-center">
                    ${tipo_recurso_nombre}<br>${nombre_tipo_recurso_nombre}
                </div><!-- col-6 -->
                <div class="col-3 col-sm-2 tx-right tx-sm-left">${fecha_recurso_adicional_hidden}</div>
                <div class="col-6 col-sm-4 mg-t-5 mg-sm-t-0">${rec_adicional_hora_inicio} a ${rec_adicional_hora_final}</div>
                <div class="col-6 col-sm-1 tx-right mg-t-5 mg-sm-t-0"><a href="javascript:void(0);" onclick="eliminar_seleccion_recursos_adicionales(this);">eliminar</a></div>
                </div><!-- row -->
            </div><!-- file-item -->`);
    }
}

function eliminar_seleccion_recursos_adicionales(obj_recursos){
    $(obj_recursos).parent().parent().parent().remove();
}

/*
*   INMUEBLE SALAS
*/
async function seleccionarInmuebleSalas(){

    inmueble_salas = await obtener_inmueble_salas($('#select_inmueble').val());
    //$('#select_inmueble_salas').val(null).trigger('change');
    $('#select_inmueble_salas').empty();

    for(i=0; i<inmueble_salas.response.length; i++){

        var newOption = new Option(inmueble_salas.response[i].nombre_sala, inmueble_salas.response[i].id_sala, false, false);
        $('#select_inmueble_salas').append(newOption);
    }

    $('#select_inmueble_salas').trigger('change');
    seleccionarHorariosSalas();
}

function limpiaCalendar(){
    scheduler.clearAll();
    $('#tp_hora_inicio').val('');
    $('#tp_hora_final').val('');
}

async function seleccionarHorariosSalas(){
    sala_horarios = await obtener_horarios_salas($('#select_inmueble_salas').val());
    horarios_ocupados=[];
    
    if(sala_horarios.estatus!=0){
        $(sala_horarios.response).each(function(index, horario){
            const {fecha_audiencia, hora_inicio_audiencia,hora_fin_audiencia,nombre_unidad,usuario_creador,juez}=horario;
            horarios_ocupados.push({inicio:hora_inicio_audiencia,fin:hora_fin_audiencia}); 
            scheduler.deleteEvent(fecha_audiencia+hora_inicio_audiencia);
            scheduler.addEvent({
                id:fecha_audiencia+hora_inicio_audiencia,
                // color: '#e0b29f',
                start_date: fecha_audiencia+' '+hora_inicio_audiencia,
                end_date:  fecha_audiencia+' '+hora_fin_audiencia,
                text:   nombre_unidad+'<br>Creador: '+usuario_creador.nombre_usuario+'<br>Juez: '+juez.nombre_usuario,
                // section_id: data.arr_json[i].secretaria, // userdata
                // id:   data.arr_json[i].folio     // userdata
            })
        });
    }
}

function obtener_horarios_salas(){
    select_inmueble_salas=0;
    if($('#select_inmueble_salas').val()!=null){
        select_inmueble_salas=$('#select_inmueble_salas').val();
    }
    return new Promise(resolve => {
        let jueces='';
        $.ajax({
            method:'POST',
            url:'/public/obtener_horarios_salas',
            async:true,
            data:{
                id_sala:select_inmueble_salas,
                fecha:$('#fecha_audiencia_hidden').val()
            },
            success:function(response){
                resolve(response);
            }
        });
    });
}

function seleccionarJuez(){
    $('#id_juez_asignado').val($('#seleccion_juez_popup').val());
    $('#nombre_juez_asignado').val($('#seleccion_juez_popup option:selected').text());
    $('#boton_cerrar_segundo').click();
}

function seleccionarJuezTramite(){
    if($('#ckbox_juez_tramite').is(":checked")){    
        id_juez_asignado_global=$('#id_juez_asignado').val();
        nombre_juez_asignado_global=$('#nombre_juez_asignado').val();

        //se pide el recurso
        $.ajax({
            method:'POST',
            url:'/public/obtener_juez_tramite',
            async:true,
            data:{

            },
            success:function(response){
                if(response.status==0){
                    alert(response.message);
                    // $('#ckbox_juez_tramite').click();
                }
                else{

                }
            }
        });

    }
    else{
        $('#id_juez_asignado').val(id_juez_asignado_global);
        $('#nombre_juez_asignado').val(nombre_juez_asignado_global);
    }

}

let init_recurso_adicional_inicial = 1;
function init_recurso_adicional(){
    $('#modalDatosTarea').modal('hide');
    $('#rec_adicional_hora_inicio').timepicker('remove')
    $('#rec_adicional_hora_final').timepicker('remove')
    if(init_recurso_adicional_inicial){
        init_recurso_adicional_inicial=0;
        const fecha_audiencia_hidden=$('#fecha_audiencia_hidden').val();
        $('#modaldemo3').find('.modal-header').html(`
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Agregar Recursos Adicionales</h6>
        `);

        $('#modaldemo3').find('.modal-body').html(`
            <input type="hidden" value="${fecha_audiencia_hidden}" id="fecha_recurso_adicional_hidden" name="fecha_recurso_adicional_hidden">
            <div class="row mg-b-25">
                <div class="col-lg-5">
                    <div class="row mg-b-25">
                        <div class="col-lg-12">
                            <div id="cal_here_recursos" ></div>
                        </div>
                        <div class="col-lg-12">
                            <hr>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-control-label">Tipo de Recurso: <span class="tx-danger">*</span></label>
                                ${tipo_recursos_html}
                            </div>
                        </div><!-- col-4 -->
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-control-label">Nombre del Tipo de Recurso: <span class="tx-danger">*</span></label>
                                <select class="form-control select2" data-placeholder="" id="nombre_tipo_recurso" onchange="seleccionarHorariosRecursos()">
                                </select>
                            </div>
                        </div><!-- col-4 -->
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-control-label">Hora: <span class="tx-danger">*</span></label>
                                <div class="row ">
                                    <div class="col-md-6">
                                        <div class="">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                    <i class="fa fa-clock-o tx-16 lh-0 op-6"></i>
                                                    </div><!-- input-group-text -->
                                                </div><!-- input-group-prepend -->
                                                <input id="rec_adicional_hora_inicio" type="text" class="form-control" placeholder="Hora de inicio" onchange="agregarHorarioRec()">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="wd-auto ">
                                            <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                <i class="fa fa-clock-o tx-16 lh-0 op-6"></i>
                                                </div><!-- input-group-text -->
                                            </div><!-- input-group-prepend -->
                                            <input id="rec_adicional_hora_final" type="text" class="form-control" placeholder="Hora de finalización" onchange="agregarHorarioRec()">
                                            </div>
                                        </div><!-- wd-150 -->
                                    </div>
                                </div>
                            </div>
                        </div><!-- col-4 -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Fecha de inicio: <span class="tx-danger">*</span></label>
                                <div class="">
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                        <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control fc-datepicker" placeholder="MM/DD/YYYY" value="${fecha_audiencia_hidden}" readonly>
                                    </div>
                                </div><!-- wd-200 -->
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Fecha de finalización: <span class="tx-danger">*</span></label>
                                <div class="">
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                        <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control fc-datepicker" placeholder="MM/DD/YYYY"  value="${fecha_audiencia_hidden}" readonly>
                                    </div>
                                </div><!-- wd-200 -->
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-control-label">Comentarios: <span class="tx-danger">*</span></label>
                                <textarea rows="3" class="form-control" placeholder="Comentarios"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">

                    <div class="section-wrapper " style="padding: 0px; border-top:none; height:100%;">
                        <div id="scheduler_here_recursos" class="dhx_cal_container ht-auto" style='width:100%; height:100%;'>
                            <div class="dhx_cal_navline">
                                <div class="dhx_cal_prev_button">&nbsp;</div>
                                <div class="dhx_cal_next_button">&nbsp;</div>
                                <div class="dhx_cal_today_button"></div>
                                <div class="dhx_cal_date"></div>
                                <div class="dhx_cal_tab" name="day_tab" style="right:204px;"></div>
                            </div>
                            <div class="dhx_cal_header">
                            </div>
                            <div class="dhx_cal_data">
                            </div>
                        </div>
                    </div><!-- section-wrapper -->

                </div>
            </div>


        `);

        $('#modaldemo3').find('.modal-footer').html(`
            <button type="button" class="btn btn-primary" onclick="seleccionar_recursos_adicionales();">Seleccionar</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="abreModal('modalDatosTarea',400)">Cerrar</button>
        `);

        'use strict';

        $('.select2').select2({minimumResultsForSearch: Infinity});
        // Datepicker
        
        
        seleccionarNombreTiposRecursos();

        $('.rec_adicional_hora_inicio').datepicker({
            showOtherMonths: true,
            selectOtherMonths: true
        });

        calendarios_recursos();
    }

    $('#rec_adicional_hora_inicio').timepicker({
        'scrollDefault': 'now',
        minTime: $('#tp_hora_inicio').val(),
        maxTime: $('#tp_hora_final').val()
    });
    $('#rec_adicional_hora_final').timepicker({
        'scrollDefault': 'now',
        minTime: $('#tp_hora_inicio').val(),
        maxTime: $('#tp_hora_final').val()
    });
}

function calendarios_recursos(date_aud=new Date()){
    if(generarCalendarios_1==false){
        scheduler_1.clearAll();
    }
    recursos_adi=[];
    generarCalendarios_1=false;
    scheduler_1  = Scheduler.getSchedulerInstance();
    var compactView = {
        xy: {
            nav_height: 50
        },
        config: {
            header: {
                rows: [
                    {
                        cols: [
                            "date"
                        ]
                    }
                ]
            }
        },
        templates: {
            month_scale_date: scheduler_1.date.date_to_str("%D"),
            week_scale_date: scheduler_1.date.date_to_str("%D, %j"),
            event_bar_date: function(start,end,ev) {
                return "";
            }

        }
    };
    settings = compactView;
    scheduler_1.utils.mixin(scheduler_1.config, settings.config, true);
    scheduler_1.utils.mixin(scheduler_1.templates, settings.templates, true);
    scheduler_1.utils.mixin(scheduler_1.xy, settings.xy, true);

    //===============
    //CONFIGURACION INICIAL
    //===============
    scheduler_1.config.multi_day = true;
    scheduler_1.config.mark_now = true;
    // scheduler_1.config.agenda_start = new Date(2019, 5, 1);
    // scheduler_1.config.agenda_end = new Date(2020,5,1);
    scheduler_1.config.readonly = true;
    scheduler_1.config.details_on_dblclick = false;
    scheduler_1.config.dblclick_create = false;
    scheduler_1.attachEvent("onBeforeDrag",function(){return false;})
    scheduler_1.locale.labels.description="Descripción";
    // scheduler_1.locale.labels.date="Día";
    scheduler_1.config.first_hour = 0;
    scheduler_1.config.last_hour = 24;
    scheduler_1.config.hour_size_px = 176;
    var format = scheduler_1.date.date_to_str("%H:%i");
    scheduler_1.templates.hour_scale = function(date){
        var step = 15;
        var html = "";
        for (var i=0; i<60/step; i++){
            html += "<div style='height:44px;line-height:44px;'>"+format(date)+"</div>";
            date = scheduler_1.date.add(date, step, "minute");
        }
        return html;
    }

    // scheduler_1.templates.event_header = function(start,end,ev){
    //     //console.log(ev);
    //     //return scheduler.templates.event_date(start)+" - ID. "+ev.id;
    //     return scheduler_1.templates.event_date(start);
    // };


    scheduler_1.attachEvent("onClick",function(id, e){
        if( e.path[1].className == 's' ){
            ide=e.path[1].attributes[2].nodeValue;
            console.log(e);
            scheduler_1.deleteEvent(id);
            n_recursos_adi=recursos_adi.filter(recurso=>{
                if( recurso.id != ide )
                    return recurso;
            });
            recursos_adi=n_recursos_adi;
        }
    })

    scheduler_1.date.agenda_start = function(date){
        
        return scheduler_1.date.month_start(date_aud);
    };

    scheduler_1.date.add_agenda = function(date, inc){
        
        return scheduler_1.date.add(date_aud, inc, "month");
    };


    //===============
    //GRUPOS
    //===============

    var types = [
                { key: "A", label: "Horarios" }
            ];

    //===============
    //FILTROS
    //===============
    var filters = {
                'A': true,
            };

    // here we are using single function for all filters but we can have different logic for each view
    scheduler_1.filter_month = scheduler_1.filter_day = scheduler_1.filter_week = scheduler_1.filter_agenda = scheduler_1.filter_week_agenda = scheduler_1.filter_unit = scheduler_1.filter_timeline = function(id, event) {

        // display event only if its type is set to true in filters obj
        // or it was not defined yet - for newly created event
        if (filters[event.section_id] || event.section_id==scheduler_1.undefined) {
            //console.log('1');
            return true;
        }
        //console.log(2);
        // default, do not display event
        return false;
    };

    //===============
    //UNITS
    //===============
    scheduler_1.createUnitsView({
        name: "unit",
        property: "section_id",
        list: types
    });
    scheduler_1.locale.labels.unit_tab = "Día";

    //===============
    //ESTILOS
    //===============
    scheduler_1.templates.event_class=function(start, end, event){
        var css = "";

        if(event.color) // if event has subject property then special class should be assigned
            css += "event_"+event.color;

        return css; // default return
    };

    fecha=$('#fecha_audiencia_hidden').val()+" 00:00:00";

    
    scheduler_1.init('scheduler_here_recursos',date_aud,"day");
    scheduler_1.parse([

    ]);

    setTimeout(function(){
        var calendar = scheduler_1.renderCalendar({
            container:"cal_here_recursos",
            navigation:true,
            handler:function(date){
                
                scheduler_1.setCurrentView(date_aud, "day");
        
                mes=(date_aud.getMonth()+1);
                if(mes<10){
                    mes='0'+mes;
                }

                dia=date_aud.getDate();
                if(dia<10){
                    dia='0'+dia;
                }
                //se actualiza el json
                
                $('#fecha_recurso_adicional_hidden').val(date_aud.getFullYear()+"-"+mes+"-"+dia);

            }
        });
        scheduler_1.linkCalendar(calendar);
        scheduler_1.setCurrentView();
    }, 100);
    
}

horario_valido=0;
function eliminaEventoRecurso(index){
    alert(index)
}

$('#resolucion').on('click', '.s', function(){
    alert('hola')
})

function validaHorario(){
    let validado=1;
    
    const start=Date.parse($('#fecha_audiencia_hidden').val()+" "+$('#tp_hora_inicio').val()+":00"),
          end=Date.parse($('#fecha_audiencia_hidden').val()+" "+$('#tp_hora_final').val()+":00");
    
    $(horarios_ocupados).each(function(index, horario){
        const {inicio, fin}=horario,
        inicio_t=Date.parse($('#fecha_audiencia_hidden').val()+" "+inicio),
        fint_t=Date.parse($('#fecha_audiencia_hidden').val()+" "+fin);

        if( (start >= inicio_t && start < fint_t) || ( end > inicio_t && end <= fint_t)  || ( start <= inicio_t && end >= fint_t )){
            alert("horario no disponible");
            validado=0;
        }
    });

    return validado;
}

function agregarHorario(){
    
    horario_valido=0;
    scheduler.deleteEvent('s');
    validacion=validaHorario();
    if( validacion != 1 )
        return 0;

    
    const fecha=$('#fecha_audiencia_hidden').val(),
        start=$('#tp_hora_inicio').val(),
        end=$('#tp_hora_final').val();
    let anio=fecha.split('-')[0],
        mes=fecha.split('-')[1],
        dia=fecha.split('-')[2];

    if (mes.length < 2) 
        mes = '0' + mes;
    if (dia.length < 2) 
        dia = '0' + dia;
    nFecha = [anio, mes, dia].join('-');
    if( start != '' && end != ''){
        if(start<end){
            scheduler.addEvent({
                id:'s',
                color: '#81C48F',
                start_date: nFecha+' '+start+":00",
                end_date:  nFecha+' '+end+":00",
                text:   "Horario seleccionado",
            });
            horario_valido=1;

            $('#rec_adicional_hora_inicio').timepicker('remove');
            $('#rec_adicional_hora_final').timepicker('remove');
            
            $('#rec_adicional_hora_inicio').val(start);
            $('#rec_adicional_hora_inicio').timepicker({
                'scrollDefault': 'now',
                minTime: $('#tp_hora_inicio').val(),
                maxTime: $('#tp_hora_final').val()
            });
            
            $('#rec_adicional_hora_final').val(end);
            $('#rec_adicional_hora_final').timepicker({
                'scrollDefault': 'now',
                minTime: $('#tp_hora_inicio').val(),
                maxTime: $('#tp_hora_final').val()
            });
            
        }else{
            alert('horario invalido')
        }
    
    }

}

id_event_recursos=0;

function validaHorarioRec(){
    let validado=1;

    if($('#tipo_recurso').val() == null || $('#tipo_recurso').val() == '' ){
        error('Datos Incompletos', 'No ha seleccionado un tipo de recurso', 'modalDatosTarea');
        $('span[aria-labelledby="select2-select_tipo_recurso-container"]').addClass('error');
        return 0;
    }

    if($('#nombre_tipo_recurso').val() == null || $('#nombre_tipo_recurso').val() == '' ){
        error('Datos Incompletos', 'No ha seleccionado el nombre del tipo de recurso', 'modalDatosTarea');
        $('span[aria-labelledby="select2-select_tipo_recurso-container"]').addClass('error');
        return 0;
    }

    if( !expRegHora.test($('#rec_adicional_hora_inicio').val()) ){
        error('Datos Incompletos', 'No ha indicado la hora de inicio para el recurso o el formato es invalido (HH:mm)', 'modalDatosTarea');
        $('#rec_adicional_hora_inicio').addClass('error');
       
        return 0;
    }

    if( !expRegHora.test($('#rec_adicional_hora_final').val()) ){
        error('Datos Incompletos', 'No ha indicado la hora final para el recurso o el formato es invalido (HH:mm)', 'modalDatosTarea');
        $('#rec_adicional_hora_final').addClass('error');
       
        return 0;
    }

    const fecha_aud=$('#fecha_audiencia_hidden').val();
          start=Date.parse(fecha_aud+" "+$('#rec_adicional_hora_inicio').val()+":00"),
          end=Date.parse(fecha_aud+" "+$('#rec_adicional_hora_final').val()+":00"),          
          start_a=Date.parse(fecha_aud+" "+$('#tp_hora_inicio').val()+":00"),
          end_a=Date.parse(fecha_aud+" "+$('#tp_hora_final').val()+":00");
    if(start < start_a || end > end_a || $('#tp_hora_inicio').val() == '' || $('#tp_hora_final').val() == ''){
        error('Datos Incompletos', 'El horario seleccionado se encuentra fuera del horario de su audiencia o no ha seleccionado el horario de la audiencia', 'modalDatosTarea');
        $('#rec_adicional_hora_final').addClass('error');
        $('#rec_adicional_hora_inicio').addClass('error');
        return 0;
    }
    
    $(recursos_adi).each(function(index, horario){
        
        const {tipo, id_tipo_recurso}=horario;

        if( tipo == $('#tipo_recurso').val() && id_tipo_recurso == $('#nombre_tipo_recurso').val() ){
            alert("Ya tiene agregado este recurso");
            validado=0;
        }
    });
    
    $(recursos_ocupados).each(function(index, horario){
        const horario_start = Date.parse(horario.fecha_requerido_inicio+' '+horario.horario_requerido_inicio),
              horario_end = Date.parse(horario.horario_requerido_fin+' '+horario.horario_requerido_inicio);
        console.log(horario_start,start,horario_end,end)
        if( ( start >= horario_start || start <= horario_end ) || (end <= horario_end && end >= horario_start) ){
            alert("Horario no disponible para este recurso");
            validado=0;
            
            return false;
        }
    });

    return validado;
}

function agregarHorarioRec(){
    
    validacion=validaHorarioRec()

    if( validacion != 1 ) return 0;

    const fecha=$('#fecha_audiencia_hidden').val(),
          start=$('#rec_adicional_hora_inicio').val(),
          end=$('#rec_adicional_hora_final').val();

    let anio=fecha.split('-')[0],
        mes=fecha.split('-')[1],
        dia=fecha.split('-')[2];

    if (mes.length < 2) mes = '0' + mes;

    if (dia.length < 2) dia = '0' + dia;

    const nFecha = [anio, mes, dia].join('-');

    if( start != '' && end != ''){
        if(start<end){
            scheduler_1.addEvent({
                id:id_event_recursos,
                color: '#81C48F',
                start_date: nFecha+' '+start+":00",
                end_date:  nFecha+' '+end+":00",
                text:  `<a href="javascript:void(0)" onlcick="eliminaEventoRecurso('${id_event_recursos}')" data-event="${id_event_recursos}" class="s"><i class="fa fa-trash tx-danger" aria-hidden="true" style="font-size:22px"></i></a><br>`+ $('#tipo_recurso option:selected').text() +"<br>"+$('#nombre_tipo_recurso option:selected').text(),
            });
            const recurso={
                "id":id_event_recursos,
                "tipo":$('#tipo_recurso').val(),
                "nombre_tipo":$('#tipo_recurso option:selected').text(),
                "id_tipo_recurso":$('#nombre_tipo_recurso').val(),
                "nombre_tipo_recurso":$('#nombre_tipo_recurso option:selected').text(),
                "fecha_inicio":$('#fecha_audiencia_hidden').val(),
                "fecha_fin":$('#fecha_audiencia_hidden').val()+":00",
                "hora_inicio":$('#rec_adicional_hora_inicio').val()+":00",
                "hora_fin":$('#rec_adicional_hora_final').val()+":00",
                "comentarios":$('#comentarios_rue').val(),
            };
            $('#comentarios_rue').val('');
            id_event_recursos++;
            recursos_adi.push(recurso);
        }else{
            alert('horario invalido')
        }
    }
}

function cargarCalendarios(){
    if(generarCalendarios){
        seleccionarInmuebleSalas();
        generarCalendarios=false;
        scheduler.clearAll();
        //===============
        //RESPONSIVO
        //===============
        var compactView = {
            xy: {
                nav_height: 50
            },
            config: {
                header: {
                    rows: [
                        {
                            cols: [
                                "date"
                            ]
                        }
                    ]
                }
            },
            templates: {
                month_scale_date: scheduler.date.date_to_str("%D"),
                week_scale_date: scheduler.date.date_to_str("%D, %j"),
                event_bar_date: function(start,end,ev) {
                    return "";
                }

            }
        };
        var fullView = {
            xy: {
                nav_height: 50
            },
            config: {
                header: {
                    rows: [
                        {
                            cols: [
                                "date"
                            ]
                        }
                    ]
                }

            },
            templates: {
                month_scale_date: scheduler.date.date_to_str("%l"),
                week_scale_date: scheduler.date.date_to_str("%l, %F %j"),
                event_bar_date: function(start,end,ev) {
                    return "• <b>"+scheduler.templates.event_date(start)+"</b> ";
                }
            }
        };

        function resetConfig(){
            var settings;
            if(window.innerWidth < 1000){
                settings = compactView;
            }else{
                settings = fullView;

            }
            scheduler.utils.mixin(scheduler.config, settings.config, true);
            scheduler.utils.mixin(scheduler.templates, settings.templates, true);
            scheduler.utils.mixin(scheduler.xy, settings.xy, true);
            return true;
        }
        resetConfig();

        //===============
        //TIMELINE
        //===============
        var elements = [ // original hierarhical array to display
            {key:10, label:"Sala Familiar", open: true, children: [
                {key:1, label:"Secretaría A"},
                {key:2, label:"Secretaría B"},
                {key:3, label:"Secretaría C"}
            ]}
        ];

        //===============
        //CONFIGURACION INICIAL
        //===============
        scheduler.attachEvent("onBeforeViewChange", resetConfig);
        scheduler.attachEvent("onSchedulerResize", resetConfig);
        scheduler.config.multi_day = true;
        scheduler.config.mark_now = true;
        scheduler.config.readonly = true;
        scheduler.config.details_on_dblclick = false;
        scheduler.config.dblclick_create = false;
        scheduler.attachEvent("onBeforeDrag",function(){return false;})
        scheduler.locale.labels.description="Descripción";
        scheduler.locale.labels.date="Día";
        scheduler.config.first_hour = 0;
        scheduler.config.last_hour = 24;
        scheduler.config.hour_size_px = 176;
        var format = scheduler.date.date_to_str("%H:%i");
        scheduler.templates.hour_scale = function(date){
            var step = 15;
            var html = "";
            for (var i=0; i<60/step; i++){
                html += "<div style='height:44px;line-height:44px;'>"+format(date)+"</div>";
                date = scheduler.date.add(date, step, "minute");
            }
            return html;
        }

        scheduler.templates.event_header = function(start,end,ev){
            return scheduler.templates.event_date(start);
        };

        scheduler.attachEvent("onClick",function(id, e){
            // cargarInfoAgenda(id) 
            }
        );

        scheduler.date.agenda_start = function(date){
            return scheduler.date.month_start(new Date(date));
        };

        scheduler.date.add_agenda = function(date, inc){
            return scheduler.date.add(date, inc, "month");
        };

        //===============
        //GRUPOS
        //===============

        var types = [
                    { key: "A", label: "Horarios" }
                ];

        //===============
        //FILTROS
        //===============
        var filters = {
                    'A': true,
                };
        
        // here we are using single function for all filters but we can have different logic for each view
        scheduler.filter_month = scheduler.filter_day = scheduler.filter_week = scheduler.filter_agenda = scheduler.filter_week_agenda = scheduler.filter_unit = scheduler.filter_timeline = function(id, event) {

            // display event only if its type is set to true in filters obj
            // or it was not defined yet - for newly created event
            if (filters[event.section_id] || event.section_id==scheduler.undefined) {
                //console.log('1');
                return true;
            }
            // default, do not display event
            return false;
        };

        function updIcon(el){
            el.parentElement.classList.toggle("checked_label");

            var iconEl = el.parentElement.querySelector("i"),
                checked = "check_box",
                unchecked = "check_box_outline_blank",
                className = "icon_color";

            iconEl.textContent = iconEl.textContent==checked?unchecked:checked;
            iconEl.classList.toggle(className);
        }

        //===============
        //UNITS
        //===============
        scheduler.createUnitsView({
            name: "unit",
            property: "section_id",
            list: types
        });
        scheduler.locale.labels.unit_tab = "Día";

        //===============
        //ESTILOS
        //===============
        scheduler.templates.event_class=function(start, end, event){
            var css = "";

            if(event.color) // if event has subject property then special class should be assigned
                css += "event_"+event.color;

            return css; // default return
        };


        scheduler.init('scheduler_here','',"unit");

        scheduler.parse([

        ]);

        setTimeout( function(){
            var calendar = scheduler.renderCalendar({
                container:"cal_here",
                navigation:true,
                handler:function(date){
                    scheduler.setCurrentView(date, "unit");
                    mes=(date.getMonth()+1);
                    if(mes<10){
                        mes='0'+mes;
                    }

                    dia=date.getDate();
                    if(dia<10){
                        dia='0'+dia;
                    }
                    
                    $('#fecha_audiencia_hidden').val(date.getFullYear()+"-"+mes+"-"+dia);
                    $('#fecha_recurso_inicio').val(date.getFullYear()+"-"+mes+"-"+dia);
                    $('#recha_recurso_final').val(date.getFullYear()+"-"+mes+"-"+dia);

                    $('#select_inmueble_salas').val();
                    setTimeout(async()=>{
                        await seleccionarHorariosSalas();
                        agregarHorario();
                        calendarios_recursos(date);  
                        seleccionarHorariosRecursos();
                    },300);
                }
            });
            scheduler.linkCalendar(calendar);
            scheduler.setCurrentView();

        }, 100);                   
    }
}
