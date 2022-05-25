@php
  use App\Http\Controllers\clases\humanRelativeDate;
  use App\Http\Controllers\clases\utilidades;
  $humanRelativeDate = new humanRelativeDate();
@endphp

@extends('layouts.index')

@section('contenido-pageheader')
    <ol class="breadcrumb slim-breadcrumb">
       <li class="breadcrumb-item"><a href="#">Jueces</a></li>
       <li class="breadcrumb-item"><a href="#">Administracion de Jueces</a></li>
    </ol>
    <h6 class="slim-pagetitle">Administracion de Jueces</h6>
@endsection


@section('contenido-principal')

    <div class="section-wrapper">

        <div class="form-layout">

            <div class="row mg-b-25">

                {{--<div class="col-lg-3" >
                    <label class="form-control-label">Unidad de gestión :</label>
                    <div class="form-group" >
                        <select class="form-control-lg select2 valid" width='100%'  autocomplete="off" id="unidadSeleccionada">
                            <option selected disabled value="">Elija una opción</option>
                            <option value="">Todas</option>
                            @foreach ($unidades['response'] as $unidad)
                                <option value="{{$unidad['id_unidad_gestion']}}">{{$unidad['nombre_unidad']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div> --}}

                {{--  Campos de Filtro  --}}

                @if($request->session()->get('id_tipo_usuario') == 1 || $request->session()->get('id_tipo_usuario') == 20 || $request->session()->get('id_tipo_usuario') == 18 )
                    <div class="col-sm-12 col-md-5 col-lg-3">
                        <div class="form-group ">
                            <label class="form-control-label">Unidad de gestión : </label>
                            <select class="form-control select2-show-search valid" id="unidadSeleccionada" name="unidadSeleccionada" autocomplete="off">
                                <option selected disabled value="">Elija una opción</option>
                                <option value="">Todas</option>
                                @foreach ($unidades['response'] as $unidad)
                                    <option value="{{$unidad['id_unidad_gestion']}}">{{$unidad['nombre_unidad']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @else
                    <div class="col-sm-12 col-md-5 col-lg-3">
                        <div class="form-group ">
                            <label class="form-control-label">Unidad de gestión : </label>
                            <select class="form-control select2-show-search valid" id="unidadSeleccionada" name="unidadSeleccionada" autocomplete="off">
                                <option selected disabled value="">Elija una opción</option>
                                @foreach ($unidades['response'] as $unidad)
                                    @if($request->session()->get('id_unidad_gestion') == $unidad['id_unidad_gestion'])
                                        <option selected value="{{$unidad['id_unidad_gestion']}}">{{$unidad['nombre_unidad']}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endif
                

                <div class="col-sm-12 col-md-5 col-lg-3" >
                    <div class="form-group" >
                        <label class="form-control-label">Tipo de eventos a observar:</label>
                        <select class="form-control-lg select2 valid" width='100%'  autocomplete="off" id="tipoEvento">
                            <option selected disabled value="">Elija una opción</option>
                                <option value="">Todos</option>
                                <option value="roles_guardias" >{{'Roles de guardia'}}</option>
                                <option value="jueces_tramite" >{{'Jueces de tramite'}}</option>
                                <option value="incidencias" >{{'Incidencias de jueces'}}</option>
                                <option value="vacaciones" >{{'Vacaciones de jueces'}}</option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-12 col-md-2 col-lg-2" >
                    <label for=""></label>
                    <div class="form-group mt-2">
                        <button class="btn btn-succeess col-sm-12 col-lg-6" style="background: #848F33 !important; color: #fff !important;" onclick="buscarEventos()">Buscar</button>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div style="width: 100%;justify-content: start;display: flex;flex-wrap: wrap;margin-top: 1%;">
                        <div class="col-md-3">
                            <div style="display: flex;justify-content: start;flex-wrap: wrap;">
                                <div style="background: #848f33;width: 20px;height: 20px;margin-right: 4%;"></div>
                                Roles de Guardia
                            </div>
                            <div style="display: flex;justify-content: start;flex-wrap: wrap;">
                                <div style="background: #427a4f;width: 20px;height: 20px;margin-right: 4%;"></div>
                                Juez tramite
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div style="display: flex;justify-content: start;flex-wrap: wrap;">
                                <div style="background: #939693;width: 20px;height: 20px;margin-right: 4%;"></div>
                                Incidencias de jueces
                            </div>
                            <div style="display: flex;justify-content: start;flex-wrap: wrap;">
                                <div style="background: #ddc23f;width: 20px;height: 20px;margin-right: 4%;"></div>
                                Vacaciones de jueces
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

        {{--  Calendario  --}}
        <div id="scheduler_here" class="dhx_cal_container" style='width:100%; height:652px; display:none;'>
            <div class="dhx_cal_navline">
                <div class="dhx_cal_prev_button">&nbsp;</div>
                <div class="dhx_cal_next_button">&nbsp;</div>
                <div class="dhx_cal_today_button"></div>
                <div class="dhx_cal_date"></div>
                <div class="dhx_cal_tab" name="week_tab" ></div>
                <div class="dhx_cal_tab" name="month_tab"></div>
            </div>
            <div class="dhx_cal_header"></div>
            <div class="dhx_cal_data"></div>
        </div>

    </div>

@endsection


@section('seccion-estilos')

    <link rel="stylesheet" href="/box/scheduler/codebase/dhtmlxscheduler_material.css?v=5.3.8" type="text/css" charset="utf-8">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="/box/scheduler/samples/common/controls_styles.css?v=5.3.8">
    <link href="{{ $entorno["version_pages"]["version"] }}/lib/jt.timepicker/css/jquery.timepicker.css" rel="stylesheet">
    <link href="{{ $entorno["version_pages"]["version"] }}/lib/select2/css/select2.min.css" rel="stylesheet">
    {{--  ESTILOS  --}}
    <style>
        /*Estilos del calendario*/
        .select2-container.select2-container--default.select2-container--open{
            z-index: 1050 !important;
        }
        .dhx_cal_tab{
            border: 1px solid #848F33 !important;
            color: #848F33 !important;
        }
        .dhx_cal_tab.active{
            border: 1px solid #848F33 !important;
            background-color: #848F33;
            color:#fff !important;
            left: 0 !important;
        }
        .dhx_cal_tab.active:hover{
            background-color: #848F33;
        }
        .dhx_cal_ltitle{
            background-color: #848F33 !important;
        }
        .dhx_save_btn_set{
            background-color: #848F33 !important;
            border: 1px solid #848F33 !important;
        }
        .dhx_save_btn_set:hover{
            background-color: #848F33 !important;
            border: 1px solid #848F33 !important;
            opacity: 0.92 !important;
        }
        .dhx_btn_set, .dhx_cancel_btn_set {
            border: 1px solid #fff;
            background-color: #fff;
            float: right;
            float: left;
        }
        .dhx_cancel_btn_set{
            color: #848F33 !important;
        }
        .dhx_save_btn_set:hover div {
            background-color: #848F33 !important;
            border-color: #848F33 !important;
            transition: all .1s ease-in-out;
        }
        .dhx_month_body{
            height: 73px !important;
        }
        div[name="week_tab"]{
            display: none;
        }
        @media(max-width:700px){
            div[name="week_tab"]{
                display: none;
            }
            div[name="month_tab"]{
                left: 0 !important;
            }
            .dhx_cal_navline .dhx_cal_prev_button {
                left: 34% !important;
            }
            .dhx_cal_navline .dhx_cal_next_button{
                left: 60% !important;
            }
            .dhx_cal_navline .dhx_cal_today_button{
                right: 0 !important;
            }
            .dhx_cal_navline .dhx_cal_date{
                font-size: 17px !important;
            }

        }
        @media(max-width:480px){
            #scheduler_here{
                height: 552px;
            }
            .dhx_cal_navline .dhx_cal_prev_button {
                left: 28% !important;
                top: 11px !important;
            }
            .dhx_cal_navline .dhx_cal_next_button{
                left: 70% !important;
                top: 11px !important;
            }
            .dhx_cal_today_button{
                width: 50px !important;
            }
            div[aria-label="Lunes"]:before{
               display: block;
               content: "L";
            }
            div[aria-label="Lunes"]:before{
                display: block;
                content: "L";
            }
            div[aria-label="Martes"]:before{
               display: block;
               content: "M";
            }
            div[aria-label="Miércoles"]:before{
               display: block;
               content: "W";
            }
            div[aria-label="Jueves"]:before{
               display: block;
               content: "J";
            }
            div[aria-label="Viernes"]:before{
               display: block;
               content: "V";
            }
            div[aria-label="Sábado"]:before{
               display: block;
               content: "S";
            }
            div[aria-label="Domingo"]:before{
                display: block;
                content: "D";
            }
            .dhx_month_body{
                height: 53px !important;
            }
            .dhx_cal_header{
                height: 18px !important;
            }
            .dhx_cal_ltext {
                height: auto !important;
            }
            .dhx_cal_ltext textarea{
                height: 100px !important;
            }
            div.dhx_cal_light.dhx_cal_light_wide{
                left: 9px !important;
            }
            .dhx_cal_light{
                width: 370px !important;
            }
            .dhx_cal_navline  .dhx_cal_date {
                font-size: 14px !important;
                left: 3%;
            }
            .dhx_cal_date, .dhx_cal_next_button, .dhx_cal_prev_button, .dhx_cal_tab, .dhx_cal_today_button {
                line-height: 26px !important;
            }
            .dhx_cal_tab {
                height: 24px !important;
                width: 72px !important;
            }
        }
        @media(max-width:900px){
            div[name="month_tab"]{
                left: 0 !important;
            }
        }
        body {
            padding: 0;
            font-family: "Lucida Grande", Helvetica, Arial, Verdana, sans-serif;
        }
        span.select2-container.select2-container--default.select2-container--open{
            width:'100%';
        }
        #modalSuccess .modal-dialog {
            font-size: 18px;
            width: 100%;
            max-width:40%;
            height: 40%;
            margin: 0;
            padding: 1;
        }
        #modalSuccessModifica .modal-dialog {
            font-size: 18px;
            width: 100%;
            max-width:40%;
            height: 40%;
            margin: 0;
            padding: 1;
        }
        #modalError .modal-dialog {
            font-size: 18px;
            width: 100%;
            max-width:40%;
            height: 40%;
            margin: 0;
            padding: 1;
        }
        #modalErrorModifica .modal-dialog {
            font-size: 18px;
            width: 100%;
            max-width:40%;
            height: 40%;
            margin: 0;
            padding: 1;
        }


    </style>
@endsection

@section('seccion-scripts-libs')

    <script src="/box/scheduler/codebase/dhtmlxscheduler.js?v=5.3.8" charset="utf-8"></script>
    <script src="/box/scheduler/codebase/ext/dhtmlxscheduler_tooltip.js" charset="utf-8"></script>
    <script src="/box/scheduler/codebase/ext/dhtmlxscheduler_limit.js?v=5.3.8" charset="utf-8"></script>
    <script src="/box/scheduler/codebase/ext/dhtmlxscheduler_agenda_view.js?v=5.3.8" charset="utf-8"></script>
    <script src='/box/scheduler/codebase/ext/dhtmlxscheduler_timeline.js?v=5.3.8' type="text/javascript" charset="utf-8"></script>
    <script src='/box/scheduler/codebase/ext/dhtmlxscheduler_treetimeline.js?v=5.3.8' type="text/javascript" charset="utf-8"></script>
    <script src="/box/scheduler/codebase/ext/dhtmlxscheduler_minical.js?v=5.3.8" type="text/javascript" charset="utf-8"></script>
    <script src="/box/scheduler/codebase/ext/dhtmlxscheduler_units.js?v=5.3.8" type="text/javascript" charset="utf-8"></script>
    <script src="/box/scheduler/codebase/ext/dhtmlxscheduler_week_agenda.js?v=5.3.8" type="text/javascript" charset="utf-8"></script>

    <script src="{{ $entorno["version_pages"]["version"] }}/lib/jt.timepicker/js/jquery.timepicker.js"></script>
    <script src="{{ $entorno["version_pages"]["version"] }}/lib/select2/js/select2.min.js"></script>
@endsection

{{--  SCRIPTS  --}}
@section('seccion-scripts-functions')
    <script>
        initCalendar();
        initEvents();
        obtener_ugas_jueces();

        setTimeout(function(){
            $('#modal_loading').modal('hide');
        }, 1000);

        setTimeout(function(){
            $('#scheduler_here').css('display', 'block');
        }, 500);

        let solicitudes=[];
        let tabla_direcciones=[];
        let tabla_alias=[];
        let tabla_contacto=[];
        let tabla_correo=[];

        let tabla_datos=[];
        let tabla_delitos=[];
        let tabla_no_relacionados=[];
        let calendar="";

        let id_unidad_gestion = @php echo json_encode($request->session()->get('id_unidad_gestion')); @endphp;

        var unidadSeleccionada;
        var tipo_evento_ligthbox = '';
        var tipo_incidencia_ligthbox = '';
        var arrJueces=[];
        
        var update_select_options = function(select, options) { // helper function
	    	select.options.length = 0;
	    	for (var i=0; i<options.length; i++) {
	    		var option = options[i];
	    		select[i] = new Option(option.label, option.key);
	    	}
	    };

        function initCalendar(){
            scheduler.init("scheduler_here","","month");

            scheduler.clearAll();
            scheduler.render();
            scheduler.updateView();
        }
        
        var unidadSelected = function (){
            unidadSeleccionada = $(this).val();
            console.log(unidadSeleccionada);
            arrJueces=[];
    
            $.ajax({
                type:'POST',
                url:'/public/obtener_jueces_admon',
                data:{
                    id_unidad_gestion:unidadSeleccionada,
                },
                success:function(response){
                    console.log(response);
                    if(response.response){
                        $(response.response).each(function(index, juez){
                            var datosJueces="";
                            const {id_usuario,usuario,descripcion,cve_juez,nombres,apellido_materno,apellido_paterno}=juez;
    
                            datosJueces={
                                "key":id_usuario,
                                "label":cve_juez+" "+nombres+" "+apellido_paterno+" "+apellido_materno,
                            }
                            arrJueces.push(datosJueces);
                        });
    
                        new_child_options=arrJueces;
    
                        update_select_options(scheduler.formSection('Juez').control, new_child_options);
    
                    }
                }
            });
        };
        
        /*
        // select de tipos de evento en el lightbox
        var tipos_evento = function(){

            tipoEvento = $(this).val();
            console.log(tipoEvento, unidadSeleccionada);

            $.ajax({
                type:'POST',
                url:'/public/consulta_agenda_admon',
                data:{
                    id_unidad_gestion:unidadSeleccionada,
                    tipo:tipoEvento,
                },
                success:function(response){
                    console.log(response);

                    if(response.status==100){
                        var datosGuardia="";
                        arrGuardias =[];
                        if(response.message){
                            scheduler.clearAll();
                                $(response.message).each(function(index, incidencia){

                                    const {id_agenda,comentarios_adicionales,fecha_desde,fecha_hasta,id_unidad_gestion,nombre_juez,nombre_unidad,tipo}=incidencia;

                                    //aqui asignamos color para cada uno de los tipos de evento
                                    var roles_guardia_c= '#27AE60';
                                    var jueces_tramite_c= '#F1C40F';
                                    var incidencias_jueces_c= '#2980B9';
                                    var vacaciones_jueces_c= '#9B59B6';

                                    if(tipo == 'vacaciones'){
                                        color = vacaciones_jueces_c;
                                    }else if(tipo == 'incidencias'){
                                        color = incidencias_jueces_c;
                                    }else if(tipo == 'jueces_tramite'){
                                        color = jueces_tramite_c;
                                    }else if(tipo == 'roles_guardias'){
                                        color = roles_guardia_c;
                                    }

                                    datosGuardia={
                                        "id":id_agenda,
                                        "start_date":fecha_desde,
                                        "end_date":fecha_hasta,
                                        "text":nombre_juez+" - "+comentarios_adicionales,
                                        "descripcion":comentarios_adicionales,
                                        "nombre_unidad":nombre_unidad,
                                        "color":color
                                    }
                                    arrGuardias.push(datosGuardia);
                                });

                            scheduler.config.drag_move = false;
                            scheduler.parse(arrGuardias);
                        }
                    } else{
                        console.log(error);
                    }
                }
            });
            
        };
        */

        var tipos_evento = function(){
            tipo_evento_ligthbox = $(this).val();
            if(tipo_evento_ligthbox == 'incidencias'){
                new_child_options = [
                    { key: '', label: 'Elija una opcion' },
                    { key: 'enfermedad', label: 'Enfermedad' },
                    { key: 'permiso', label: 'Permiso' },
                    { key: 'capacitacion', label: 'Capacitación' }
                ]; 

                update_select_options(scheduler.formSection('Tipo Incidencia').control, new_child_options);
            }else{
                new_child_options = [{ key: '', label: 'No aplica' },];
                update_select_options(scheduler.formSection('Tipo Incidencia').control, new_child_options);
            }
        };

        var tipo_incidencias = function(){
            tipo_incidencia_ligthbox = $(this).val();
            console.log(tipo_incidencia_ligthbox)
        }

        var opt_ugas = [];
        function obtener_ugas_jueces (){
            $.ajax({
                type:'POST',
                url:'/public/obtener_ugas_jueces',
                data:{},
                success:function(response){
                    console.log(response);
                    if(response.status==100){
                        opt_ugas.push({
                            key : '',
                            label : 'Elige una unidad'
                        })
                        for(i = 0; i < response.unidades.response.length; i++){
                            if(id_unidad_gestion == 0){
                                opt_ugas.push({
                                    key:  response.unidades.response[i]['id_unidad_gestion'],
                                    label:  response.unidades.response[i]['nombre_unidad']
                                })
                            }else if(id_unidad_gestion == response.unidades.response[i]['id_unidad_gestion']){
                                opt_ugas.push({
                                    key:  response.unidades.response[i]['id_unidad_gestion'],
                                    label:  response.unidades.response[i]['nombre_unidad']
                                })
                            }
                        }
                    }else{
                        opt_ugas.push({
                            key : '',
                            label : 'Elige una unidad'
                        })
                    }
                }
            });  
        }

        var opts = [
            { key: '', label: 'Elija una opcion' },
            { key: 'roles_guardias', label: 'Roles de guardia' },
            { key: 'jueces_tramite', label: 'Jueces de tramite' },
            { key: 'incidencias', label: 'Incidencias de jueces' },
            { key: 'vacaciones', label: 'Vacaciones de jueces' }
        ];  

        scheduler.config.time_step = 1;

        scheduler.config.lightbox.sections=[
            {
                name:"Unidad de Gestion", height:40, map_to:"unidadSeleccionada", type:"select", options:opt_ugas, onchange:unidadSelected
            },
            {
                name:"Tipo Evento", height:40, map_to:"tipo_evento", type:"select", options:opts, onchange: tipos_evento
            },
            {
                name:"Tipo Incidencia", height:40, map_to:"tipo_incidencia", type:"select", options:scheduler.serverList("tipo_incidencias"), onchange: tipo_incidencias
            },
            { 
                name:"Juez", height:40, map_to:"juez_titular", type:"select",  options:scheduler.serverList("Juez"),
            },
            {
                name:"Motivo", height:100, map_to:"text", type:"textarea" , focus:true
            },
            {
                name:"time", height:72, type:"time", map_to:"auto"
            }
        ];

        var tipoEvento="";
        var arrGuardias=[];

        window.addEventListener("DOMContentLoaded", function(){

            //Guardar
            scheduler.attachEvent("onEventSave",function(id,ev){

                console.log(id);
                
                if (!ev.text) {
                    alert("La descripcion no puede estar vacia");
                    return false;
                }
    
                var formatFunc = scheduler.date.date_to_str("%Y-%m-%d %H:%i:%s");
    
                var start_date = formatFunc(ev.start_date);
                var end_date = formatFunc(ev.end_date);
    
                console.log(ev);
    
                $.ajax({
                    type:'POST',
                    url:'/public/inserta_agenda_admon',
                    data:{
                        id_evento: id,
                        id_juez:ev.juez_titular,
                        tipo:tipo_evento_ligthbox,
                        id_unidad_gestion:unidadSeleccionada,
                        fecha_ini:start_date,
                        fecha_fin:end_date,
                        descripcion:ev.text,
                        tipo_incidencia: tipo_incidencia_ligthbox,
                     },
                    success:function(response){
                        if(response.status==100){
                            initCalendar();
                            initEvents();
                            obtener_ugas_jueces();
                            $('#datos-respuesta-solicitud').html(`${response.message ?? "Sin datos"}`);
                            $('#modalSuccess').modal('show');
                            return true;
                        }else{
                            $('#datos-respuesta-solicitud-error').html(`${response.response ?? "Sin datos"}`);
                            $('#modalError').modal('show');
                            return false;
                        }
                        return true;
                    }
                });
    
                return true;
                
            })

            //mensaje
            scheduler.locale.labels.confirm_deleting = "Seguro que deseas borrar este elemento?";

            //Eliminar
            scheduler.attachEvent('onBeforeEventDelete', function(id, event) {

                console.log(event);

                $.ajax({
                    type:'POST',
                    url:'/public/elimina_agenda_administracion',
                    data:{
                        id_agenda:event.id,
                        estatus:"0"
                    },
                    success:function(response){
                        if(response.status==100){
                            initCalendar();
                            initEvents();
                            obtener_ugas_jueces();
                            $('#datos-respuesta-modifica').html(`${response.message ?? "Sin datos"}`);
                            $('#modalSuccessModifica').modal('show');
                            return true;
                        }else{
                            $('#datos-respuesta-modifica-error').html(`${response.response ?? "Sin datos"}`);
                            $('#modalErrorModifica').modal('show');
                            return false;
                        }
                    }
                }); 
                
                return true;

            });

            //Tooltip
            scheduler.templates.tooltip_text = function(start,end,ev){
                var evento=scheduler.getEvent(ev.id);
                //console.log(evento);
                return "<b>UGJ:</b> "+ev.nombre_unidad+
                "<br/><b>Participantes:</b> "+ev.text+
                "<br/><b>Fecha de Inicio:</b> " + scheduler.templates.tooltip_date_format(start)+
                "<br/><b>Fecha Fin:</b> "+scheduler.templates.tooltip_date_format(end)+
                "<br/><b>Descripción:</b> "+ev.descripcion+
                "<br/><b>Tipo Evento:</b> "+(ev.tipo == 'roles_guardias' ? 'Roles de guardia' : (ev.tipo == 'jueces_tramite' ? 'Jueces de tramite': ev.tipo))+
                "<br/><b>Tipo Incidencia:</b> "+(ev.tipo_incidencia == null ? '' : ev.tipo_incidencia)
            };


            //Actualizar
            /*
            scheduler.attachEvent("onEventChanged",function(event_id, event_object){
                console.log(event_object, event_id);

                /*
                var formatFunc = scheduler.date.date_to_str("%Y-%m-%d %H:%i:%s");

                var start_date = formatFunc(ev.start_date);
                var end_date = formatFunc(ev.end_date);
                
                var id_juez = event_object.juez_titular
                var tipo = tipo_evento_ligthbox
                var id_unidad_gestion = unidadSeleccionada
                var fecha_ini = start_date
                var fecha_fin = end_date
                var descripcion = event_object.text

                arr = [
                    {
                        id : id_juez,
                        tipo : tipo_evento_ligthbox,
                        id_unidad : id_unidad_gestion,
                        fecha_i : fecha_ini,
                        fecha_fin : fecha_fin,
                        descripcion : descripcion
                    }
                ]

                console.log(arr)
                    */
                /*
                $.ajax({
                    type:'POST',
                    url:'/public/modifica_agenda_administracion',
                    data:{
                        id_agenda:event.id,
                        estatus:"0"
                    },
                    success:function(response){
                        if(response.status==100){
                            initCalendar();
                            initEvents();
                            obtener_ugas_jueces();
                            $('#datos-respuesta-modifica').html(`${response.message ?? "Sin datos"}`);
                            $('#modalSuccessModifica').modal('show');
                            return true;
                        }else{
                            $('#datos-respuesta-modifica-error').html(`${response.response ?? "Sin datos"}`);
                            $('#modalErrorModifica').modal('show');
                            return false;
                        }
                    }
                }); 
                
                //return true;
            });
            */
            /*    
            scheduler.attachEvent("onDblClick", function (event_id, native_event_object){
                let  tabla="";

                var ev = scheduler.getEvent(event_id);
                console.log(ev);

                var formatFunc = scheduler.date.date_to_str("%Y-%m-%d %H:%i:%s");

                var start_date = formatFunc(ev.start_date);
                var end_date = formatFunc(ev.end_date);

                $('#datos-respuesta-solicitud').html(` <tr >
                        <input type="hidden" value="${event_id ?? "Sin datos"}" id="id_de_evento">
                        <td class="td-title" >Fecha de inicio</td>
                        <td>${start_date ?? "Sin datos"}</td>
                        <td class="td-title">Fecha de termino</td>
                        <td>${end_date ?? "Sin datos"}</td>
                    </tr>
                    <tr>
                        <td class="td-title">Descripcion del evento</td>
                        <td>${ev.text ?? "Sin datos"}</td>
                    </tr>
                    <br> 
                `);

                $('#botonEliminar').val(event_id),

                $('#modalSuccess').modal('show');
                tabla="";
                $("#datos-respuesta-solicitud").val('');
                $("#tableRespuestaSolicitud").val('');

            }); 
            */

            /*       
            scheduler.attachEvent("onClick", function (event_id, native_event_object){
                console.log("asasa");
                return true;
            }); 
            */

            /* 
            scheduler.attachEvent("onEventChanged",function(event_id, event_object){
                console.log(event_id);
                console.log(event_object);
                alert("fired");
                scheduler.clearAll();
                scheduler.load("/events/records?ts=" + (new Date()).valueOf());
                return true;
            }); 
            */

        });

        //Inicializadores
        $(function(){
            'use strict';

            // Select2
            $('.select2').select2({
               minimumResultsForSearch: Infinity
            });

            $('.fc-datepicker').datepicker({
                    showOtherMonths: true,
                    selectOtherMonths: true
            });

            $( ".fc-datepicker" ).datepicker( "option", "dd-mm-yy" );

            $.datepicker.regional['es'] = {
            closeText: 'Cerrar',
            prevText: '< Ant',
            nextText: 'Sig >',
            currentText: 'Hoy',
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
            dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
            dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
            weekHeader: 'Sm',
            dateFormat: 'dd/mm/yy',
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ''
            };
        
            $.datepicker.setDefaults($.datepicker.regional['es']);
        
            $(function () {
                $("#fc-datepicker").datepicker();
            });

            //focus textfiled
            $('.form-layout .form-control').on('focusin', function(){
                $(this).closest('.form-group').addClass('form-group-active');
            });
            $('.form-layout .form-control').on('focusout', function(){
                $(this).closest('.form-group').removeClass('form-group-active');
            });

        });

        function initEvents(){
            var gestion = @php echo json_encode($request->session()->get('id_unidad_gestion')); @endphp;

            if(gestion == 0){
                unidad_w = '';
            }else{
                unidad_w = gestion;
            }

            console.log('unidad',unidad_w);

            $.ajax({
                type:'POST',
                url:'/public/consulta_agenda_admon',
                data:{
                    id_unidad_gestion:unidad_w,
                    tipo:'',
                },
                success:function(response){
                    console.log('consulta agenda',response);

                    if(response.status==100){
                        var datosGuardia="";
                        arrGuardias =[];
                        if(response.message){
                            scheduler.clearAll();
                                $(response.message).each(function(index, incidencia){

                                    const {id_agenda,comentarios_adicionales,fecha_desde,fecha_hasta,id_unidad_gestion,nombre_juez,nombre_unidad,tipo, tipo_incidencia}=incidencia;

                                    //aqui asignamos color para cada uno de los tipos de evento
                                    var roles_guardia_c= '#848F33';
                                    var jueces_tramite_c= '#427a4f';
                                    var incidencias_jueces_c= '#939693';
                                    var vacaciones_jueces_c= '#ddc23f';
                                    var enfermedad_c= '#804000';
                                    var permiso_c= '#d79028';
                                    var capacitacion_c= '#153f59';

                                    if(tipo == 'vacaciones'){
                                        color = vacaciones_jueces_c;
                                    }else if(tipo == 'incidencias'){
                                        color = incidencias_jueces_c;
                                    }else if(tipo == 'jueces_tramite'){
                                        color = jueces_tramite_c;
                                    }else if(tipo == 'roles_guardias'){
                                        color = roles_guardia_c;
                                    }else if(tipo == 'enfermedad'){
                                        color = enfermedad_c;
                                    }else if(tipo == 'permiso'){
                                        color = permiso_c;
                                    }else if(tipo == 'capacitacion'){
                                        color = capacitacion_c;
                                    }


                                    datosGuardia={
                                        "id":id_agenda,
                                        "start_date":fecha_desde,
                                        "end_date":fecha_hasta,
                                        "text":nombre_juez+" - "+comentarios_adicionales,
                                        "descripcion":comentarios_adicionales,
                                        "nombre_unidad":nombre_unidad,
                                        "tipo_incidencia":tipo_incidencia,
                                        "color":color,
                                        "tipo":tipo,
                                        "upd":1
                                    }
                                    arrGuardias.push(datosGuardia);
                                });

                            scheduler.config.drag_move = false;
                            scheduler.parse(arrGuardias);
                        }
                    } else{
                        console.log(error);
                    }
                }
            });
        }

        function limpiarCampos(){
            $('#title').val('');//text
        }

        function cerrar_modal(valor){
            $("#"+valor).modal('hide');
            $('body').removeClass('modal-open');
        }

        function guardarEvento(){

            guardar = document.getElementById('dhx_save_btn');

            guardar.addEventListener('click', function() {
                console.log("GUARDADO");
            });
        }

        function eliminarEvento(){

            eliminar = document.getElementById('botonEliminar');

            eliminar.addEventListener('click', function() {
                console.log("eliminado");
            });
        }

        function buscarEventos(){
            tipoEvento = $("#tipoEvento").val();
            id_unidad_gestion = $("#unidadSeleccionada").val();

            $.ajax({
                type:'POST',
                url:'/public/consulta_agenda_admon',
                data:{
                    id_unidad_gestion:id_unidad_gestion,
                    tipo:tipoEvento,
                },
                success:function(response){
                    console.log(response);

                    if(response.status==100){
                        var datosGuardia="";
                        arrGuardias =[];
                        if(response.message){
                            scheduler.clearAll();
                                $(response.message).each(function(index, incidencia){

                                    const {id_agenda,comentarios_adicionales,fecha_desde,fecha_hasta,id_unidad_gestion,nombre_juez,nombre_unidad,tipo}=incidencia;

                                    //aqui asignamos color para cada uno de los tipos de evento
                                    var roles_guardia_c= '#848F33';
                                    var jueces_tramite_c= '#427a4f';
                                    var incidencias_jueces_c= '#939693';
                                    var vacaciones_jueces_c= '#ddc23f';

                                    if(tipo == 'vacaciones'){
                                        color = vacaciones_jueces_c;
                                    }else if(tipo == 'incidencias'){
                                        color = incidencias_jueces_c;
                                    }else if(tipo == 'jueces_tramite'){
                                        color = jueces_tramite_c;
                                    }else if(tipo == 'roles_guardias'){
                                        color = roles_guardia_c;
                                    }

                                    datosGuardia={
                                        "id":id_agenda,
                                        "start_date":fecha_desde,
                                        "end_date":fecha_hasta,
                                        "text":nombre_juez+" - "+comentarios_adicionales,
                                        "descripcion":comentarios_adicionales,
                                        "nombre_unidad":nombre_unidad,
                                        "color":color,
                                        "tipo":tipo
                                    }
                                    arrGuardias.push(datosGuardia);
                                });

                            scheduler.config.drag_move = false;
                            scheduler.parse(arrGuardias);
                        }
                    } else{
                        console.log(error);
                    }
                }
            });
        }

    </script>
@endsection

{{--  MODALES --}}
@section('seccion-modales')

    <div id="modalSuccess" class="modal fade"  data-backdrop="static" data-keyboard="false" style="display: none">
        <div class="modal-dialog" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-body tx-center pd-y-20 pd-x-20">
            <i class="icon ion-ios-checkmark-outline tx-100 tx-success lh-1 mg-t-20 d-inline-block"></i>
            <h4 class="tx-success tx-semibold mg-b-20">Hecho!</h4>
            <div id="datos-respuesta-solicitud"></div>
            </div><!-- modal-body -->
            <div class="modal-footer d-flex">
            <button type="button" class="btn btn-primary pd-x-25 mg-l-auto" data-dismiss="modal" aria-label="Close" >Aceptar</button>
            </div>
        </div><!-- modal-content -->
        </div><!-- modal-dialog -->
    </div>

    <div id="modalError" class="modal fade"  data-backdrop="static" data-keyboard="false" style="display: none">
        <div class="modal-dialog" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-body tx-center pd-y-20 pd-x-20">
                <i class="icon icon ion-ios-close-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
                <h4 class="tx-danger tx-semibold mg-b-20">Error!</h4>
            <div id="datos-respuesta-solicitud-error"></div>
            </div><!-- modal-body -->
            <div class="modal-footer d-flex">
            <button type="button" class="btn btn-primary pd-x-25 mg-l-auto" data-dismiss="modal" aria-label="Close" >Aceptar</button>
            </div>
        </div><!-- modal-content -->
        </div><!-- modal-dialog -->
    </div>

    <div id="modalSuccessModifica" class="modal fade"  data-backdrop="static" data-keyboard="false" >
        <div class="modal-dialog" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-body tx-center pd-y-20 pd-x-20">
            <i class="icon ion-ios-checkmark-outline tx-100 tx-success lh-1 mg-t-20 d-inline-block"></i>
            <h4 class="tx-success tx-semibold mg-b-20">Hecho!</h4>
            <div id="datos-respuesta-modifica">

                    </div>
            </div><!-- modal-body -->
            <div class="modal-footer d-flex">
            <button type="button" class="btn btn-primary pd-x-25 mg-l-auto" data-dismiss="modal" aria-label="Close" >Aceptar</button>
            </div>
        </div><!-- modal-content -->
        </div><!-- modal-dialog -->
    </div>

    <div id="modalError" class="modal fade"  data-backdrop="static" data-keyboard="false" style="display: none">
        <div class="modal-dialog" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-body tx-center pd-y-20 pd-x-20">
                <i class="icon icon ion-ios-close-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
                <h4 class="tx-danger tx-semibold mg-b-20">Error!</h4>
            <div id="datos-respuesta-modifica-error">

                    </div>
            </div><!-- modal-body -->
            <div class="modal-footer d-flex">
            <button type="button" class="btn btn-primary pd-x-25 mg-l-auto" data-dismiss="modal" aria-label="Close" >Aceptar</button>
            </div>
        </div><!-- modal-content -->
        </div><!-- modal-dialog -->
    </div>

@endsection
