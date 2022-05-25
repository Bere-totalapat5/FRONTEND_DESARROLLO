countBandejas();


function countBandejas(){
    countNoti();
    countTareas();
    countFirmas();
}

function countNoti(){
    $.ajax({
        method:'POST',
        url:'/public/obtener_bandeja',
        data:{
            tipo:'notificaciones',
            modo:'contador',
        },
        success:function(response){
            if(response.status==100){
                $('.countNotificaciones').html(response.response);
            }
        }
    });
}

function countTareas(){
    $.ajax({
        method:'POST',
        url:'/public/obtener_bandeja',
        data:{
            tipo:'tareas',
            modo:'contador',
        },
        success:function(response){
            if(response.status==100){
                $('.countTareas').html(response.response);
            }
        }
    });
}

function countFirmas(){
    $.ajax({
        method:'POST',
        url:'/public/obtener_bandeja',
        data:{
            tipo:'firmas',
            modo:'contador',
        },
        success:function(response){
            if(response.status==100){
                $('.countFirmas').html(response.response);
            }
        }
    });
}