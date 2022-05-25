@php
  use App\Http\Controllers\clases\utilidades;
@endphp

@extends('layouts.index')

{{-- Header --}}
@section('contenido-pageheader')
  <ol class="breadcrumb slim-breadcrumb">
     <li class="breadcrumb-item"><a href="javascript:void(0);">Recursos Adicionales</a></li>
     <li class="breadcrumb-item"><a href="javascript:void(0);"> Consulta Recursos Adicionales</a></li>
  </ol>
  <h6 class="slim-pagetitle"> Grupos de Jueces</h6>
@endsection

{{-- Contenido Principal --}}
@section('contenido-principal')
    <div class="section-wrapper" style="max-width: 100%;">
        <div class="form-layout justify-content-center">

          <di class="row">
            <div class="col-md-12" style="padding: 0;">
              <div class="form-group">
                  <label for="juez" class="col-sm-6 col-form-label h4">Unidad de Gestion</label>
                  <div class="col-sm-12">
                    <select class="select2" id="unidadSeleccionada" onchange="llenar_campos(this)">
                        <option selected  value="">Elige una Unidad</option>
                    </select>
                  </div>
                </div>
            </div>
          </di>

          {{--  Tabla de registros  --}}
          <div class="row">
            <div class="col-sm-12 col-md-7" id="card_jueces">
              <div class="card">
                  <div class="card-header">
                  <div class="form-group row" style="margin-bottom: 0 !important;">
                      <div class="col-sm-12 col-md-8">
                        Grupo de jueces:
                          <select class="select2" id="juez" onchange="consulta_usuarios_juez(this)">
                            <option selected  value="">Elige un Juez</option>
                            {{--  //aqui se cargan los jueces  --}}
                          </select>
                      </div>
                      <button id="agregar_users" title="Agregar usuarios" onclick="openNav()">Agregar Usuario <i class="far fa-plus-square"></i></button>
                    </div>
                  </div>
                  <div class="card-body p-2">
                    <div class="lista" id="jueces">
                    </div>
                  </div>
                  <div class="card-footer d-flex justify-content-between">
                     <button type="button" class="btn btn-secondary" id="limpiar" onclick="limpiar('boton');">Limpiar</button>
                     <button type="button" class="btn btn-success" id="botonResultado" onclick="modal_guardar_user();" style="background: #848F33 !important; border:none;">Guardar</button>
                  </div>
              </div>
            </div>

            <div class="col-sm-5 col-md-5" id="card_user">
              <div class="card">
                  <div class="card-header h5" style="text-align: center;">
                    Usuarios no Asignados
                    <button type="button" class="close">
                      <span aria-hidden="true" onclick="closeNav();">&times;</span>
                   </button>
                  </div>
                  <div class="card-body p-0">
                  <div class="lista" id="usuarios">
                    <div class="item" id="#">Selecciona un Usuario</div>
                    {{--  // aqui se cargan los usuarios  --}}
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!--TABLA RESULTADOS BUSQUEDA -->
          <div id="table-grupos" class=" table-responsive mg-b-20 mt-5">
              <table id="gruposTable" class="table" style="padding-left:0; padding-rigth:0">
                  <thead style="background-color: #EBEEF1; color: #000; text-align:center">
                      <tr>
                        <th style="cursor:pointer; font-size: 0.84em; "  name="acciones">Acciones</th>
                        <th style="cursor:pointer; font-size: 0.84em; "  name="carpeta_investigacion">Grupo</th>
                        <th style="cursor:pointer; font-size: 0.84em; "  name="unidad_gestion">Unidad</th>
                        <th style="cursor:pointer; font-size: 0.84em; " name="juez">Juez</th>
                        <th style="cursor:pointer; font-size: 0.84em; " name="usuarios">Usuarios Asignados</th>
                        <th style="cursor:pointer; font-size: 0.84em; " name="fecha_creacion">Fecha</th>
                      </tr>
                  </thead>
                  <tbody id="body-table1" style="width: 100%; text-align: center; font-size: 0.84em;">
                  </tbody>
              </table>
          </div>

          <!-- pagination-wrapper -->
          <div class="pagination-wrapper justify-content-between">
              <ul class="pagination mg-b-0">
                  <li class="page-item">
                      <a class="page-link" href="javascript:void(0);" onclick="sec_ajax('primera');" aria-label="Last">
                          <i class="fa fa-angle-double-left"></i>
                      </a>
                  </li>
                  <li class="page-item">
                      <a class="page-link" href="javascript:void(0);" onclick="sec_ajax('atras');" aria-label="Next">
                          <i class="fa fa-angle-left"></i>
                      </a>
                  </li>
              </ul>
              <div id="texto_paginator">Página <span class="pagina_actual_texto">0</span> de <span
                      class="pagina_total_texto">0</span></div>
              <ul class="pagination mg-b-0">
                  <li class="page-item">
                      <a class="page-link" href="javascript:void(0);" onclick="sec_ajax('avanzar');" aria-label="Next">
                          <i class="fa fa-angle-right"></i>
                      </a>
                  </li>
                  <li class="page-item">
                      <a class="page-link" href="javascript:void(0);" onclick="sec_ajax('ultima');" aria-label="Last">
                          <i class="fa fa-angle-double-right"></i>
                      </a>
                  </li>
              </ul>
          </div><!-- pagination-wrapper -->

        </div>

        <input type="hidden" id="pagina_actual" name="pagina_actual" value="1">
        <input type="hidden" id="paginas_totales" name="paginas_totales" value="1">
        <input type="hidden" id="numeropagina">
    </div>


@endsection

{{-- Estilos --}}
@section('seccion-estilos')
    <link href="{{asset("/lib/datatables/css/jquery.dataTables.css")}}" rel="stylesheet">
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
    <style>
        #accordion .card{
            border:none !important;
        }
        #accordion .card .card-header{
          width: 75px !important;
          border: 1px solid #dee2e6 !important;
        }
        #accordion .card .card-header a{
          padding: 10px !important;
        }
        #collapseSearchAdvance{
          border: 1px solid #eee !important;
          background: #f8f9fa;
        }
        #accordion a::before{
          top: 10px !important;
        }
        .select2-container.select2-container--default.select2-container--open{
            z-index: 1050 !important;
        }
        .page-link{
            border:none !important;
        }

        @media(min-width: 1200px){
            .modal-size{
                width: 30% !important;
            }
        }
        @media(min-width: 1024px){
            .modal-size{
                width: 50% !important;
            }
        }
        #jueces {
          background: #fff;
          min-height: 8em;
          padding: 1em;
          width:100%;
          border:2px solid #848F33;
          border-radius: 8px;
          overflow: auto;
          height: 300px;
        }
        #unidadSeleccionada{
          border: 1px solid #848F33;
        }
        #unidadSeleccionada:focus{
          outline: none;
        }
        .jueces.hovering {
          background: #b6d6fb;
          border-color: #276cbc;
        }
        #usuarios{
          overflow: auto;
          height: 422px;
          padding: 1em;
        }
        #jueces::-webkit-scrollbar,
        #usuarios::-webkit-scrollbar {
            width: 8px;
            height: 8px;
            /*display: none;*/
        }
        #jueces::-webkit-scrollbar-thumb,
        #usuarios::-webkit-scrollbar-thumb {
            background: #b4b4b4;
            border-radius: 4px;
        }

        #jueces::-webkit-scrollbar-thumb:hover,
        #usuarios::-webkit-scrollbar-thumb:hover {
            background: #b3b3b3;
            box-shadow: 0 0 2px 1px rgba(0, 0, 0, 0.2);
        }
        #jueces::-webkit-scrollbar-thumb:active,
        #usuarios::-webkit-scrollbar-thumb:active {
            background-color: #999999;
        }
        #jueces::-webkit-scrollbar-track
        #usuarios::-webkit-scrollbar-track {
            background: #e1e1e1;
            border-radius: 4px;
        }
        #jueces::-webkit-scrollbar-track:hover,
        #jueces::-webkit-scrollbar-track:active,
        #usuarios::-webkit-scrollbar-track:hover,
        #usuarios::-webkit-scrollbar-track:active {
          background: #d4d4d4;
        }
        .item {
          background: #fff;
            border: 1px solid #848F33;
            cursor: pointer;
            display: block;
            padding: 0.8em;
            border-radius: 8px;
            margin: 8px 0;
            text-align: center;
            font-size: 1em;
            color: #444;
            font-weight: bold;
            z-index: 1000;
        }
        .item_asignado{
          background: #848F33;
          border: 1px solid #848F33;
          cursor: pointer;
          display: block;
          padding: 0.8em;
          border-radius: 8px;
          margin: 8px 0;
          text-align: center;
          font-size: 1em;
          color: #fff;
          font-weight: bold;
          z-index: 1000;
        }
        #lista_vacia{
          border:5px dashed #eee;
          width: 30%;
          padding: 10px;
          border-radius: 10px;
          text-align: center;
          margin: 5% auto;
          color: #444;
        }
        .add_user{
          display: block;
          float: left;
          width: 25px;
          height: 49px;
          margin-top: -11px;
          text-align: center;
          line-height: 45px;
          margin-left: 9px;
          border-radius: 8px 0px 0px 8px;
        }
        .item:hover{
          background:#848F33;
          color: #fff;
        }
        #ver_users, #agregar_users{
          display: none;
        }
        .ver_users{
          border: none;
          border-radius: 4px;
          background: #848F33;
          text-align: center;
          color: #fff;
          padding: 9px;
          font-size: 0.95em;
          display: block;
          z-index: 1000;
        }
        .close{
          display: none;
        }
        @media (max-width: 768px) {
          #lista_vacia{
            width: 50%;
          }
          #jueces {
              height: 200px;
          }
          #agregar_users{
              width: 40%;
              border: none;
              border-radius: 4px;
              background: #848F33;
              text-align: center;
              margin-top: 10px;
              margin-left: 20px;
              color: #fff;
              padding: 4px;
              font-size: 0.95em;
              display: block;
              z-index: 1000;
          }
          #ver_users{
            width: 40%;
            border: none;
            border-radius: 4px;
            background: #848F33;
            text-align: center;
            margin-top: 10px;
            margin-left: 20px;
            color: #fff;
            padding: 4px;
            font-size: 0.95em;
            display: block;
            z-index: 1000;
          }
          .close{
            display: block;
          }
          #card_user.open{
            opacity: 1;
            display: block;
            right: 0;
          }
          #card_user{
            position: fixed;
            width: 80%;
            position: fixed;
            z-index: 1000;
            top: 20%;
            right: -80%;
            transition: all 300ms;
          }
          #ver_users2{
            display: none;
          }
        }

    </style>
@endsection

{{-- Scripts librerias --}}
@section('seccion-scripts-libs')
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/jquery-ui/js/jquery-ui.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/datatables/js/jquery.dataTables.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/datatables-responsive/js/dataTables.responsive.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/select2/js/select2.min.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/moment/js/moment.js"></script>
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
     <script src="https://cdn.datatables.net/colreorder/1.5.3/js/dataTables.colReorder.min.js"></script>
@endsection

{{-- Scripts --}}
@section('seccion-scripts-functions')
  <script>
    var usuarios_por_unidad = [];
    var usuario_asignado = [];
    var grupo_juez = [];
    var unidadSeleccionada = 0;
    var id_grupo = '';
    var id_unidad_sesion = @php echo json_encode($request->session()->get('id_unidad_gestion')); @endphp;

    $(function(){
      consulta_unidades();
      sec_ajax();

      //Loader
      setTimeout(function(){
        $('#modal_loading').modal('hide');
      }, 1000);

      $('.select2').select2();
    
      setTimeout(function(){
        $('#unidadSeleccionada').trigger('change');
      },1000)

    });

    function consulta_unidades(){
      $.ajax({
        type:'POST',
        url:'/public/consulta_unidades_gestion',
        data:{
        },
        success:function(response) {
            body = '';
            //console.log(response);
            if(response.status==100){
                var datos=response.response;
                body='<option value="0">Elija una opción</option>';
                for(i=0; i < datos.length; i++ ){
                  if(id_unidad_sesion == 0){
                    body += `<option value="${datos[i]['id_unidad_gestion']}">${datos[i]['nombre_unidad']}</option>`;
                  }else if(id_unidad_sesion == datos[i]['id_unidad_gestion']){
                    body += `<option selected value="${datos[i]['id_unidad_gestion']}">${datos[i]['nombre_unidad']}</option>`;
                  }
                }
                $("#unidadSeleccionada").html(body);
            }else{
                body = body.concat('<option  value="0">Elija una opción</option>');
                $("#unidadSeleccionada").html(body);
            }
        }
      });
    }

    function llenar_campos(obj){
      unidadSeleccionada = $(obj).val();
      if(unidadSeleccionada != 0){
        jueces_por_unidad(unidadSeleccionada);
        consulta_usuarios(unidadSeleccionada);
      }else{
        $("#jueces").html('');
        $("#juez").html(`<option selected  value="">Elige un Juez</option>`);
        $("#usuarios").html(`<div class="item" id="#">Selecciona un Usuario</div>`);
      }
    }

    function jueces_por_unidad(unidadSeleccionada){
      if(unidadSeleccionada != 0){
        $.ajax({
          type:'POST',
          url:'/public/consulta_jueces_administracion',
          data:{
            id_unidad_gestion:unidadSeleccionada
          },
          success:function(response) {
              body = '';
              //console.log(response);
              if(response.status==100){
                  var datos=response.response;
                  body = '<option selected  value="">Elige un Juez</option>';
                  for(i=0; i < datos.length; i++ ){
                    body += `<option value="${datos[i]['id_usuario']}" style="text-align:center;"> ${datos[i]['nombres']} ${datos[i]['apellido_paterno']} ${datos[i]['apellido_materno']}</option>`;
                  }
                  $("#juez").html(body);
              }else{
                  $("#juez").html(`<option selected  value="">Elige un Juez</option>`);
              }
          }
        });
      }else{
        $("#juez").html(`<option selected  value="">Elige un Juez</option>`);
      }
    }

    function consulta_usuarios(unidadSeleccionada){
      usuarios_por_unidad.length = 0

      if(unidadSeleccionada == 0){
        $("#usuarios").html(`<div class="item" id="#">Selecciona un Usuario</div>`);
      }else{

        $.ajax({
          type:'POST',
          url:'/public/consulta_usuarios_administracion',
          data:{
            id_unidad_gestion:unidadSeleccionada
          },
          success:function(response) {
            var body = "";
            if(response.status == 100){
                var datas = response.response; //usuarios no registrados

                for (var j = 0; j < datas.length; j++) {
                  usuarios_por_unidad.push({
                    "nombre_completo": datas[j].nombres+' '+datas[j].apellido_paterno+' '+datas[j].apellido_materno,
                    "id_usuario": datas[j].id_usuario,
                    "usuario": datas[j].usuario,
                    "tipo_usuario": datas[j].id_tipo_usuario,
                    "id_unidad_gestion": datas[j].id_unidad_gestion,
                    "estado":0,
                    "cve_juez":null,
                    "asignado_a_grupo":datas[j].asignado_a_grupo
                  });

                  if(datas[j].asignado_a_grupo == 0){
                    body += `<div class="item" id="user_${datas[j].id_usuario}"  onclick="agregar('${datas[j].id_usuario}','${j}')"><span class="add_user"><i class="fas fa-plus-circle"></i></span>${datas[j].usuario}<span style="font-size:0.8em; color:#aaa; margin-left:2%;">[ ${datas[j].nombres} ${datas[j].apellido_paterno} ${datas[j].apellido_materno} ]</span></div>`;
                  }
                }
              $("#usuarios").html(body);
            }else{
              $("#usuarios").html(`<div class="item" id="#">Selecciona un Usuario</div>`);
            }
          }
        });
        console.log('usuarios por unidad', usuarios_por_unidad);
      }
    }

    function agregar(id, indice){
      if($('#juez').val().length > 0 ){
        var usuario_agreagdo =  usuarios_por_unidad[indice];
        var item = `<div class="item" id="user_${id}" data-id="${id}" onclick="eliminar(${id}, ${indice})"><span class="add_user"><i class="fas fa-minus"></i></span>${usuario_agreagdo.usuario} <span style="font-size:0.8em; color:#aaa; margin-left:2%;">[ ${usuario_agreagdo.nombre_completo} ]</span></div>`;
        usuarios_por_unidad[indice].estado = 1;
        
        usuario_asignado.push({
          "id_juez" :  $('#juez').val(),
          "id_usuario":id,
          "usuario": usuario_agreagdo.usuario,
          "nombre":  usuario_agreagdo.nombre_completo,
          "id_unidad": usuario_agreagdo.id_unidad_gestion,
          "asignado_a_grupo": 1
        });

        $('#user_'+id).remove();
        $("#jueces").append(item);

        console.log('Grupo de juez', usuario_asignado)
      }else{
        error('Seleccione un Juez antes de agregar un usuario');
      }
    }

    function eliminar(id, indice){
      var usuario_removido =  usuarios_por_unidad[indice];
      var add_item = `<div class="item" id="user_${id}" data-id="${id}" onclick="agregar(${id},'${indice}')"><span class="add_user"><i class="fas fa-plus-circle"></i></span>${usuario_removido.usuario} <span style="font-size:0.8em; color:#aaa; margin-left:2%;">[ ${usuario_removido.nombre_completo} ]</span></div>`;
      usuarios_por_unidad[indice].estado = 0;

      for(i in usuario_asignado){
        if(usuario_asignado[i].id_usuario == id){
          usuario_asignado.splice( i, 1 );
        }
      }

      console.log('usuarios', usuarios_por_unidad);
      console.log('Usuario removido', usuario_asignado)
      $('#user_'+id).remove();
      $('#usuarios').prepend(add_item);
    }

    function modal_guardar_user(){

      if(!$('#jueces div').hasClass('item')){
        error('El grupo se encuentra vacio');
      }else{
        var salida = "<ul>";
        for(i in usuario_asignado){
          salida += `<li>${usuario_asignado[i].usuario} [${usuario_asignado[i].nombre}]</li>`;
        }
        salida +="</ul>"

        $('#user_asigment').html(salida);
        $('#juezAsigando').html($('#juez option:selected').text());
        $('#modalConfirmation').modal('show');
      }
    }

	  function limpiar(funcion){
      if(funcion == 'boton'){

	  	  if(!$('#jueces div').hasClass('item')){
          error('El grupo se encuentra vacio');
     	  }else{
            var add_item = '';
            usuario_asignado.length = 0; 

            for(i in usuarios_por_unidad){
              if(usuarios_por_unidad[i].estado == 1){
                add_item += `<div class="item" id="user_${usuarios_por_unidad[i].id_usuario}" data-id="${usuarios_por_unidad[i].id_usuario}" onclick="agregar(${usuarios_por_unidad[i].id_usuario},${i})"><span class="add_user"><i class="fas fa-plus-circle"></i></span>${usuarios_por_unidad[i].usuario} <span style="font-size:0.8em; color:#aaa; margin-left:2%;">[ ${usuarios_por_unidad[i].nombre_completo} ]</span></div>`;
              }
              usuarios_por_unidad[i].estado = 0;
            }

            $('#usuarios').append(add_item);
            $('#jueces div.item').each(function(index, val){
              $(this).remove();
            });
     	  }

      }else{
        var add_item = '';
        usuario_asignado.length = 0; 

        for(i in usuarios_por_unidad){
          if(usuarios_por_unidad[i].estado == 1){
            add_item += `<div class="item" id="user_${usuarios_por_unidad[i].id_usuario}" data-id="${usuarios_por_unidad[i].id_usuario}" onclick="agregar(${usuarios_por_unidad[i].id_usuario},${i})"><span class="add_user"><i class="fas fa-plus-circle"></i></span>${usuarios_por_unidad[i].usuario} <span style="font-size:0.8em; color:#aaa; margin-left:2%;">[ ${usuarios_por_unidad[i].nombre_completo} ]</span></div>`;
          }
          usuarios_por_unidad[i].estado = 0;
        }

        $('#usuarios').append(add_item);
        $('#jueces div.item').each(function(index, val){
          $(this).remove();
        });
      }
	  }

    function agregar_usuario(){
      grupo_juez = usuario_asignado;
      id_juez = $('#juez').val();

      $.ajax({
        type:'POST',
        url:'/public/insertar_usuario_jueces',
        data:{
          grupo_juez : grupo_juez
        },
        success:function(response) {
          console.log(response);
          if(response.status==100){ 
            
            $('#modalConfirmation').modal('hide');

            var exito = "<p class='mg-b-20 mg-x-20'>Los usuarios se agregaron exitosamente</p>";
            success(exito);

            consulta_usuarios(unidadSeleccionada);
            sec_ajax();
            setTimeout(function(){
              consulta_usuarios_juez(0,id_juez);
            },700);
          }else{
            $('#modalConfirmation').modal('hide');
            error(response.response);
          }
        }
      });
    }

    function consulta_usuarios_juez(obj,id){
      $("#jueces").html('');
      grupo_juez.length = 0;

      limpiar('carga');

      if(obj != 0){
        $.ajax({
          type:'POST',
          url:'/public/consulta_usuarios_x_juez',
          data:{
            id_juez: $(obj).val()
          },
          success:function(response) {
            if(response.status == 100){
                var datos=response.response;
                var items = '';
                id_grupo = datos[0].id_grupo;
                grupo_juez = datos[0].ids_usuarios;

                for(i in usuarios_por_unidad){
                  if(usuarios_por_unidad[i].asignado_a_grupo == 1){
                    if(datos[0].ids_usuarios.includes(usuarios_por_unidad[i].id_usuario)){
                      items += `<div class="item_asignado" id="user_${usuarios_por_unidad[i].id_usuario}" data-id="${usuarios_por_unidad[i].id_usuario}" onclick="desAsignar(${usuarios_por_unidad[i].id_usuario}, ${i})"><span class="add_user"><i class="fas fa-minus"></i></span>${usuarios_por_unidad[i].usuario} <span style="font-size:0.8em; color:#eee; margin-left:2%;">[ ${usuarios_por_unidad[i].nombre_completo} ]</span></div>`;
                    }
                  }
                }

                $("#jueces").html(items);
                console.log('Grupo juez', grupo_juez);
            }else{
              $("#jueces").html('');
            }
          }
        });
      }else{
        $.ajax({
          type:'POST',
          url:'/public/consulta_usuarios_x_juez',
          data:{
            id_juez: id
          },
          success:function(response) {
            if(response.status == 100){
                var datos=response.response;
                var items = '';
                id_grupo = datos[0].id_grupo;
                console.log(datos);

                console.log('ids_usuarios', datos[0].ids_usuarios);

                for(i in usuarios_por_unidad){
                  if(usuarios_por_unidad[i].asignado_a_grupo == 1){
                    if(datos[0].ids_usuarios.includes(usuarios_por_unidad[i].id_usuario)){
                      items += `<div class="item_asignado" id="user_${usuarios_por_unidad[i].id_usuario}" data-id="${usuarios_por_unidad[i].id_usuario}" onclick="desAsignar(${usuarios_por_unidad[i].id_usuario}, ${i})"><span class="add_user"><i class="fas fa-minus"></i></span>${usuarios_por_unidad[i].usuario} <span style="font-size:0.8em; color:#eee; margin-left:2%;">[ ${usuarios_por_unidad[i].nombre_completo} ]</span></div>`;
                    }
                  }
                }

                $("#jueces").html(items);
                  
            }else{
              $("#jueces").html('');
            }
          }
        });
      }
    }

    function desAsignar(id_usuario, indice){
      usuario = usuarios_por_unidad[indice].nombre_completo;
      $('#usuarioAsigando').html(usuario);
      $('#reagrupar').attr('onclick', `reagrupar(${id_usuario})`)
      $('#modalDesAsignar').modal("show");
    }

    function reagrupar(id_usuario){
      id_juez = $('#juez').val();

      console.log('usuario a retirar', id_usuario)
      console.log('Grupo al que pertenece', id_grupo)

      $.ajax({
        type:'POST',
        url:'/public/actualizar_usuarios_grupos_jueces',
        data:{
          id_grupo: id_grupo,
          id_usuario: id_usuario
        },
        success:function(response) {
          if(response.status==100){

            $('#modalDesAsignar').modal("hide");

            var exito = "<p class='mg-b-20 mg-x-20'>El Usuario Fue removido del grupo de juez exitosamente</p>";
            success(exito);
            
            consulta_usuarios(unidadSeleccionada);
            sec_ajax();
            setTimeout(function(){
              consulta_usuarios_juez(0,id_juez);
            },700);
          }
          else{
            $('#modalDesAsignar').modal("hide");
            error(response.response);
          }
        }
      });
      
    }

    function modalEliminar(id_grupo){
      $('#grupoAsignado').html(id_grupo);
      $('#eliminarG').attr('onclick', `eliminarGrupo(${id_grupo})`)
      $('#modalEliminar').modal("show");
    }

    function eliminarGrupo(id_grupo){
      id_juez = $('#juez').val();

      $.ajax({
        type:'POST',
        url:'/public/eliminarGrupo',
        data:{
          id_grupo: id_grupo,
        },
        success:function(response) {
          if(response.status==100){
            $('#modalEliminar').modal("hide");
            success(response.response);
            sec_ajax();

            if(unidadSeleccionada != 0){
              consulta_usuarios(unidadSeleccionada);
              consulta_usuarios_juez(0,id_juez);
            }else{
              consulta_usuarios(0);
            }

          }
          else{
            $('#modalEliminar').modal("hide");
            error(response.response);
          }
        }
      });
    }

    //Tabla de vista rapida
    function sec_ajax(pagina_accion) {

      let body = "";

      pagina = parseInt($('#pagina_actual').val());
      registros_por_pagina = 10;

      if (pagina_accion == "primera") {
          pagina = 1;
      } else if (pagina_accion == "avanzar") {
          pagina = pagina + 1;
      } else if (pagina_accion == "atras") {
          pagina = pagina - 1;
      } else if (pagina_accion == "ultima") {
          pagina = $('#paginas_totales').val();
      }

      if (pagina <= 0 || pagina > $('#paginas_totales').val()) {

      } else {
          $('#pagina_actual').val(pagina);
          $('#numeropagina').val(pagina);
          $('.pagina_actual_texto').html(pagina);

          unidadSeleccionada1 = (id_unidad_sesion == 0) ? '-' : id_unidad_sesion;

          console.log('unidad seleccionada', unidadSeleccionada1)
          $.ajax({
              type: 'GET',
              url: '/public/ver_grupos_jueces',
              data: {
                  id_unidad_gestion: unidadSeleccionada1,
                  pagina: $('#numeropagina').val(),
                  registros_por_pagina: 8,
              },
              success: function(response) {
                console.log(response);
                  if (response.status == 100) {
                      var datos = response.response;
                      var tabla = '';
                      console.log('Grupos Asignados',datos);
                      if(response.status == 100){
                        for(i in datos){
                          var usuarios = '';

                          for(j in datos[i].nombres_usuarios){
                            usuarios += `<li style="width:100%; padding: 4px; border-left: 2px solid #848f33;">${datos[i].nombres_usuarios[j]}</li>`;
                          }

                          tabla += `
                          <tr>
                            <td><i class="fa fa-trash" style="color: #EC7063; font-size: 1.2em; cursor:pointer;" onclick="modalEliminar(${datos[i].id_grupo})" title="Eliminar Grupo"></i></td>
                            <td>${datos[i].id_grupo}</td>
                            <td>${datos[i].nombre_unidad}</td>
                            <td>${datos[i].nombre_juez}</td>
                            <td>
                              <ul style="width:100%; list-style:none; padding: 0; overflow-y:auto; height: 40px;">
                                ${usuarios}
                              </ul>
                            </td>
                            <td>${datos[i].creacion}</td>
                          </tr>`;
                        }

                        $('#body-table1').html(tabla);

                      }else{
                        $('#body-table1').html("<tr><td colspan='6'><h5>Sin datos relacionados</h5></td><tr>");
                      }

                      $('.pagina_total_texto').html(response.response_paginacion['paginas_totales']);
                      $('#paginas_totales').val(response.response_paginacion['paginas_totales'])

                  } else {
                      let body = "<tr><td colspan='6'><h5>Sin datos relacionados</h5></td><tr>";
                      $("#body-table1").html(body);
                  }
              }
          });
          
      }
    } 

    //Funcionalidad 
    function openNav() {
        $("#card_user").toggleClass('open');
    }

    function closeNav() {
      $("#card_user").toggleClass('open');
    }

    function error(mensaje){
      $('#messageError').html(mensaje);
      $('#modalError').modal('show');
    }

    function success(mensaje){
      $('#messageExito').html(mensaje);
      $('#modalSuccess').modal('show');
    }

  </script>
@endsection

@section('seccion-modales')
  {{-- Modal DesAsignar --}}
  <div class="modal" tabindex="-1" id="modalDesAsignar" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Desasignar</h5>
        </div>
        <div class="modal-body">
          <input type="hidden" id="idGrupo">
          <input type="hidden" id="iduser_input">
          <h5>¿Deseas remover al usuario <span id="usuarioAsigando"></span></span></span>?</h5>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary" id="reagrupar" onclick="reagrupar()">Aceptar</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal" tabindex="-1" id="modalEliminar" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Eliminar Grupo</h5>
        </div>
        <div class="modal-body">
          <input type="hidden" id="idGrupo">
          <input type="hidden" id="iduser_input">
          <h5>¿Deseas eliminar el grupo <span id="grupoAsignado"></span></span></span>?</h5>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-danger" id="eliminarG" onclick="eliminarGrupo()">Eliminar</button>
        </div>
      </div>
    </div>
  </div>

  {{--  Modal confirmation  --}}
  <div class="modal" tabindex="-1" id="modalConfirmation" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">¿Deseas asignar los siguientes usuarios al Juez <span id="juezAsigando"></span></span></span> ?</h5>
        </div>
        <div class="modal-body">
          <div id="user_asigment"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary" id="asignar_users" onclick="agregar_usuario()">Guardar</button>
        </div>
      </div>
    </div>
  </div>

  <div id="modalSuccess" class="modal fade"  data-backdrop="static" data-keyboard="false" style="display: none">
    <div class="modal-dialog" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-body tx-center pd-y-20 pd-x-20">
          <i class="icon ion-ios-checkmark-outline tx-100 tx-success lh-1 mg-t-20 d-inline-block"></i>
          <h4 class="tx-success tx-semibold mg-b-20">Hecho!</h4>
          <div id="messageExito">
          </div>
        </div><!-- modal-body -->
        <div class="modal-footer d-flex">
          <button type="button" class="btn btn-primary pd-x-25 mg-l-auto" data-dismiss="modal" aria-label="Close" >Aceptar</button>
        </div>
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
  </div>

  <div id="modalError" class="modal fade" style="display: none">
    <div class="modal-dialog" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-body tx-center pd-y-20 pd-x-20">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <i class="icon icon ion-ios-close-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block "></i>
          <div id="messageError" class="mg-b-20">
          </div>
          <button type="button" class="btn btn-danger pd-x-25" data-dismiss="modal" aria-label="Close">Aceptar</button>
        </div><!-- modal-body -->
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
  </div><!-- modal -->

@endsection