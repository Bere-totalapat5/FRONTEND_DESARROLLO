
const expRegFecha=/^([0-2][0-9]|3[0-1])(-)(0[1-9]|1[0-2])\2(\d{4})$/,
      expRegHora=/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/,
      unidadGestion=@php echo Session::get('id_unidad_gestion')==''?0:Session::get('id_unidad_gestion'); @endphp;
buscar(1);
setInterval(function(){
  buscar(1);
},120000);
setTimeout(function(){
    $('#modal_loading').modal('hide');
}, 2000);

function obtenerUsuariosUnidad(){
    $('#usuario').html('');
    $.ajax({
        method:'POST',
        url:'/public/obtener_usuarios_unidad',
        data:{
            uga:$('#unidad').val(),
        },
        success:function(response){
            $('#usuario').append('<option value="">Todos</option>');
            if(response.status==100){
                $(response.response).each(function(index, usuario_unidad){
                    const {usuario, id_usuario}=usuario_unidad;
                    $('#usuario').append(`<option value="${id_usuario}">${usuario}</option>`);
                });
            }
        }
    });
}

function buscar(pagina){
  $.ajax({
    method:'POST',
    url:'/public/obtener_bandeja',
    data:{
        modo:"lista",
        tipo:"tareas",
        pagina,
        uga:$('#unidad').val(),
        usuario:$('#usuario').val(),
    },
    success:function(response){
      $('#bodyTareas').html('');
      if(response.status==100){
        carpetas=response.response;
        $(response.response).each(function(index, notificacion){
          const {fecha_asignacion_bandeja,folio_solicitud,tipo_solicitud_,estatus_flujo_actual,partes_procesales,delitos,carpeta_judicial,usuario}=notificacion;

            let lPartes='',
                      lDelitos='',
                      lCarpetas='';

              $(carpeta_judicial).each(function(index, carpeta){
                  fechaAsignacion='';
                  if(carpeta.fecha_asignacion!=null){
                      const fCrea=carpeta.fecha_asignacion.split(' ')[0].split('-');
                      fechaAsignacion='<br>F.A.: '+ fCrea[2]+'-'+fCrea[1]+'-'+fCrea[0];
                  }
                  lCarpetas=lCarpetas.concat(`<div class="">${carpeta.folio_carpeta==null?'':carpeta.folio_carpeta}${fechaAsignacion}</div>`);
              });

              const tipos_partes=Object.keys(partes_procesales);
              $(tipos_partes).each(function(index, tipo_parte){
                  lPartes=lPartes.concat(`<h6 class="mg-b-0 text-capitalize">${tipo_parte}</h6>`);
                  $(partes_procesales[tipo_parte]).each(function(index, parte){
                      const {razon_social,nombre, apellido_paterno, apellido_materno} = parte;
                      lPartes=lPartes.concat(`<div class="b-l-2">${razon_social==null?'':razon_social}${nombre==null?'':nombre} ${apellido_paterno==null?'':apellido_paterno} ${apellido_materno==null?'':apellido_materno}</div>`);
                  });
              });

              $(delitos).each(function(index, delito){
                  lDelitos=lDelitos.concat(`<div class="b-l-2">${delito.delito}</div>`);
              });

            fechaAsignacion='';
            if(fecha_asignacion_bandeja!=null){
                const fCrea=fecha_asignacion_bandeja.split(' ')[0].split('-');
                fechaAsignacion=fCrea[2]+'-'+fCrea[1]+'-'+fCrea[0];
            }

            const tr=`<tr>
                        <td class="acciones"><i class="icon ion-folder" onclick="verCarpeta(${index}"></i></td>
                        <td class="usuario ${unidadGestion!=0?'d-none':''}">${usuario}</td>
                        <td class="folio">${folio_solicitud}</td>
                        <td class="tipo">${tipo_solicitud_}</td>
                        <td class="fecha">${fechaAsignacion}</td>
                        <td class="estatus_flujo">${estatus_flujo_actual}</td>
                        <td class="carpeta">${lCarpetas}</td>
                        <td class="partes">${lPartes}</td>
                        <td class="delitos">${lDelitos}</td>
                    <tr>`;
            $('#bodyTareas').append(tr);
        });

        const anterior=pagina==1?1:pagina-1,
                    totalPaginas=response.response_pag.paginas_totales,
                    siguiente=pagina+1>=totalPaginas?totalPaginas:pagina+1;

        $('.anterior').attr('onclick',`buscar(${anterior})`);
        $('.pagina').html(pagina);
        $('.total-paginas').html(totalPaginas);
        $('.siguiente').attr('onclick',`buscar(${siguiente})`);
        $('.ultima').attr('onclick',`buscar(${totalPaginas})`);

      }else{
        const tr=`<tr>
                  <td class="unidad tx-center tx-danger" colspan="8">Sin Datos Relacionados</td>
                  <td class="d-none"></td>
                  <td class="d-none"></td>
                  <td class="d-none"></td>
                  <td class="d-none"></td>
                  <td class="d-none"></td>
                  <td class="d-none"></td>
                  <td class="d-none"></td>
                <tr>`;
            $('#bodyTareas').append(tr);

            $('.anterior').attr('onclick',`buscar(1)`);
            $('.pagina').html('1');
            $('.total-paginas').html('1');
            $('.siguiente').attr('onclick',`buscar(1)`);
            $('.ultima').attr('onclick',`buscar(1)`);
      }
    }
  });
}

  