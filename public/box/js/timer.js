var timerStart = true;
var time_aux=0;

function myTimer(time_server, time_client)
{
   // get current time
    var d = new Date();
    d.setTime(time_server.getTime());

    var d0 = new Date();
    var d_final = d0.getTime() - time_client.getTime();
    var segundos = Math.round(d_final/(1000));

    if(time_aux!=segundos){

        d.setSeconds(d.getSeconds() + segundos);
        time_aux=segundos;

        var hours = d.getHours();
        var minutes = d.getMinutes();
        var seconds = d.getSeconds();

        //var ampm = d.getHours() >= 12 ? 'pm' : 'am';
        //hours = hours % 12;

        // if number of minutes less than 10, add a leading "0"
        minutes = minutes.toString();
        if (minutes.length == 1){
            minutes = "0"+minutes;
        }
        // if number of seconds less than 10, add a leading "0"
        seconds = seconds.toString();
        if (seconds.length == 1){
            seconds = "0"+seconds;
        }

        // return output to Web Worker
        postMessage(hours+":"+minutes+":"+seconds);
    }
}
                
if (timerStart){
   time=0;
   
   addEventListener('message', (event) => {
    
    time_client=event.data['time_client'];
    time_server=event.data['time_server'];
    myVar=setInterval(function(){myTimer(time_server, time_client)},100);
  });
  
   // timer should not start anymore since it has been started
   timerStart = false;
}