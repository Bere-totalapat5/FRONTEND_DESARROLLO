/*
*  RELOJ
*/
function reloj_cierre(anio, mes, dia, horas, minutos, segundos, cierre){
    var w = null;
    w = new Worker("/box/js/timer.js");

    var d = new Date();
    var d0 = new Date();

    w.postMessage({"time_server":d, "time_client":d0});
    w.onmessage = function (event) {
        var horaInicio = moment(event.data, 'h:mm:ss');
        var horaFin = moment(cierre, 'h:mm:ss');
        if(!horaInicio.isBefore(horaFin)){
            document.getElementById("clock_index").className = "reloj_vencido";
        }
        document.getElementById("clock_index").innerHTML = event.data + " hrs";
    };
}

/*
*   DIAS INABILES INDEX
*/
function diasAsueto(input_id, diasAsueto_arr){
    let $btn = $('.custom-cells'),
	    $input = $('#'+input_id),
        hoy = new Date(),
        fechaActual=hoy.getFullYear()+"-"+hoy.getMonth()+1+"-"+hoy.getDate();
        $input.val(fechaActual);
    dp=$input.datepicker({
        gotoCurrent: true,
        showOtherMonths: true,
        selectOtherMonths: true,
        format: 'mm/dd/yyyy',
        position: "bottom right",
        beforeShowDay: function( date ) {
            mes=date.getMonth()+1;
            dia=date.getDate();
            if(mes<10){
                mes="0"+mes;
            }
            if(dia<10){
                dia="0"+dia;
            }
            let dateFormat=date.getFullYear()+"-"+mes+"-"+dia;
           
            if( diasAsueto_arr.includes(dateFormat)) {
                 return [true, "dia-inhabil"];
            } else {
                 return [true, '', ''];
            }
        }
       
      });
  
    $btn.on('click', function(){
        dp.show();
        $input.focus();
    });

    
}

/*
*   DIAS INABILES INDEX
*/
function diasAsuetoListaNormal(input_id, diasAsueto_arr){
    var eventDates = diasAsueto_arr;
	$input = $('#'+input_id),
	dp = $input.datepicker({
        language: 'es',
        onRenderCell: function (date, cellType) {
            var currentDate = date.getDate();
            mes=date.getMonth()+1;
            if(mes<10){
                mes="0"+mes;
            }
            if (eventDates.indexOf(date.getFullYear()+"-"+mes+"-"+date.getDate()) != -1) {
                return {
                    html: '<span class="dp-note" style="z-index:-1;"></span>' + currentDate
                }
            }
        }
    }).data('datepicker');
    $('.datepicker--content').append('<div style="border-top:1px solid #cccccc; padding:5px;"><center><span class="dp-note-footer">sss</span> Días inhábiles TSJCDMX</center></div>');
}
 
function resetPass(){
    
    if(bandera_reset==0){
        alert('De de cumpliar con las especificaciones mínimas');
        $('#reset_pass_1').focus();
    }
    else{

        if($('#reset_pass_1').val()==""){
            alert('La contraseña es obligatoria');
            $('#reset_pass_1').focus();
        }

        else if($('#reset_pass_2').val()==""){
            alert('Debe de repetir la contraseña');
            $('#reset_pass_2').focus();
        }

        else{
            if($('#reset_pass_2').val()==$('#reset_pass_1').val()){
                if($('#reset_pass_1').val().length<=7){
                    alert('La contraseña debe de ser mayor a 8 caractéres');
                }
                else{
                    $.ajax({
                        type:'POST',
                        url:'/cambiar_reseteo',
                        data:{ reset_pass_1:$('#reset_pass_1').val() },
                        success:function(data){
                            console.log(data);
                            if(data.message=='Success'){
                                alert('Se modificó exitosamente su contraseña, puede continuar.');
                                $('#modal_reset').modal('hide');
                            }
                            else{
                                alert('La contraseña debe de ser diferente a la actual.');
                            }
                        }
                    });
                }
            }
            else{
                alert('Las contraseñas no coinciden');
                $('#reset_pass_1').focus();
            }
        }
    }
}  

function breakSesion(data){
    if(data.status==-1){
        alert('Sesion inválida');
        location="/logout";
    }
}

function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}


/*
*   CATALOGOS
*/
function acomodarTipoExpedienteTxt(tipo_expediente_clave){
    let emp = []
    emp['expediente'] = 'EXPEDIENTE';
    emp['expedientillo'] = 'EXPEDIENTILLO';
    emp['incidente'] = 'INCIDENTES';
    emp['terceria'] = 'TERCERÍA';
    emp['exhorto'] = 'EXHORTO';
    emp['amparo'] = 'AMPARO';
    emp['amparo_directo'] = 'AMPARO DIRECTO';
    emp['amparo_indirecto'] = 'AMPARO INDIRECTO';
    emp['toca'] = 'TOCA'; 
    emp['amparo_exploratorio'] = 'AMPARO EXPLORATORIO';
    emp['cumplimiento'] = 'CUMPLIMIENTO';
    emp['expedientillo_no_corresponde'] = 'EXPEDIENTILLO NO CORRESPONDE';
    emp['recusacion'] = 'RECURSACIÓN';
    emp['denuncia_incumplimiento_1_2019_v_cuad_amparo'] = "DEN. INC. 1/2019 CUAD. AMP.";
    emp['denuncia_incumplimiento_1_2019_v_toca'] = "DEN. INC. 1/2019 TOCA";
    emp['seccion_de_ejecucion'] = 'SECCION DE EJECUCION';
    emp['cuaderno_amparo_tercerista'] = 'CUAD. DE APM. TERCERISTA';
    emp['cuaderno_amparo_act'] = 'CUAD. AMP. ACT.';
    emp['cuaderno_amparo_dem'] = 'CUAD. AMP. DEM.';
    emp['expedientillo_del_cuaderno'] = 'EXPEDIENTILLO DEL CUAD. AMP.';
    emp['sentencia_definitiva'] = 'SENT. DEF.';
    emp['acuerdos_audiencia'] = 'ACDOS. AUDIENCIA';
    emp['cuadernillo'] = 'CUADERNILLO';
    emp['OTROS'] = 'OTROS';
    return emp[tipo_expediente_clave];

}

String.prototype.capitalize = function() {
    return this.charAt(0).toUpperCase() + this.slice(1);
}

/*
*   COMPRAR FECHAS
*/
function comprarFechasMomento(fecha1, fecha2){
    var date_time = fecha1;
    var isafter = moment(date_time).isAfter(fecha2);
    return isafter;
}

