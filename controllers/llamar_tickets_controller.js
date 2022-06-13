 var minutosPerdidos = 0;
 var segundosPerdidos = 0;
 var horasPerdidas = 0;
 var direccion = 0;
 var idEmpleado = 0;
 var atendiendoFlag = false;
 var tramitesHabilitados = "";

 var modalReasignar = document.getElementById("modalReasignacion");
 var btnPausar = document.getElementById("btnPausa");
 var btnReasignar = document.getElementById("btnReasignar");
 var modalRellamado = document.getElementById("modalRellamado");
 var btnRellamar = document.getElementById("btnRellamado");
 var btnLlamarSiguiente = document.getElementById("btnSiguiente");
 var personasEsperaTxt = document.getElementById("personasEspera");
 var spanCloseModalReasignar = document.getElementsByClassName("close")[0];
 var spanCloseModalRellamado = document.getElementsByClassName("close")[1];
 var estadoTicket = document.getElementById("estadoTicket");
 var numeroLlamados = document.getElementById("llamadosRestantes");
 var tiempoRestanteTxt = document.getElementById("tiempoRestante");
 btnReasignar.disabled = true;

 //consultar el count de tickets cada 2 segundos
 $(document).ready(function() {
     //obtener datos de la jornada del empleado en cuanto cargue la pagina
     obtener_datos_sesion();
    setInterval(obtener_personas_espera, 3000);
});

function obtener_datos_sesion(){
    $.get(`obtener_valores_sesion.php`,function(data,status){
        var sesionJson = JSON.parse(data);
        obtener_empleado(sesionJson.userlogin,obtener_datos_empleado);
    });
}

function obtener_empleado(usrLogin,_callback){
    $.get(`obtener_empleado.php?usuario=${usrLogin}`,function(data,status){
        var empleadoJson = JSON.parse(data);
        console.log(empleadoJson);
        idEmpleado = empleadoJson.idEmpleado;
        _callback();
    });
}


// obtener datos de jornada 
function obtener_datos_empleado(){
    $.get(`obtener_jornada_laboral.php?idEmpleado=${idEmpleado}`,function(data,status){
        var jornadaJson = JSON.parse(data);
        if(jornadaJson == ""){
            alert("Ocurrio un error con los datos_empleado")
        }else{
            document.getElementById("numeroVentanilla").innerHTML = `<b>${jornadaJson.nombre_ventanilla} / ${jornadaJson.primerNombre} ${jornadaJson.primerApellido}</b>`;
            document.getElementById("areaTramite").innerText = `${jornadaJson.nombre_direccion} / ${jornadaJson.tramites_habilitados}`;
            minutosPerdidos = jornadaJson.minutosFueraVentanilla;
            segundosPerdidos = jornadaJson.segundosFueraVentanilla;
            horasPerdidas = jornadaJson.horasFueraVentanilla;
            direccion = jornadaJson.Direccion_idDireccion;
            idEmpleado = jornadaJson.Empleado_idEmpleado;
            tramitesHabilitados = jornadaJson.tramites_habilitados;
        }
    });
}

//funcion para obtener el numero de personas en espera
// para la cola de la direccion expecificada con la jornada
function obtener_personas_espera() { 
    $.get(`count_cola.php?direccion=${direccion}`, function(data,status){
        var countJSON = JSON.parse(data);
        //numero de ticket con zero fill
        personasEsperaTxt.innerHTML = `Personas en espera: ${countJSON}`
    });
}



//reloj
function currentTime() {
    let date = new Date();  
    let hh = date.getHours();
    let mm = date.getMinutes();
    let ss = date.getSeconds();
    let session = "AM";
  
    if(hh === 0){
        hh = 12;
    }
    if(hh > 12){
        hh = hh - 12;
        session = "PM";
     }
  
     hh = (hh < 10) ? "0" + hh : hh;
     mm = (mm < 10) ? "0" + mm : mm;
     ss = (ss < 10) ? "0" + ss : ss;
      
     let time = hh + ":" + mm + ":" + ss + " " + session;
  
    document.getElementById("clock").innerText = time; 
    let t = setTimeout(function(){ currentTime() }, 1000);
  }
  
currentTime();


  
// Alternar entre pausar y reanudar
 btnPausar.onclick = function(){
    if(btnPausar.textContent === "Pausar"){
        btnPausar.innerHTML = '<i class="bi bi-play-btn-fill" style="padding-right:10px;"></i>Reanudar' //estilo del boton
        btnPausar.style.background = 'red';
        estadoTicket.textContent = "EN PAUSA";
        btnLlamarSiguiente.disabled = true; //botones de siguiente, reasignar y rellamado desactivados mientras se esta en pausa.
        btnRellamar.disabled = true;
        tiempoRestanteTxt.style.display = 'block';
        temporizador(); //iniciar temporizador de pausa
    }else
    if(btnPausar.textContent === "Reanudar"){
        btnPausar.innerHTML = '<i class="bi bi-pause-btn-fill" style="padding-right:10px;"></i>Pausar';
        btnPausar.style.background = '#88cfe1';
        tiempoRestanteTxt.style.display = 'none';
        estadoTicket.textContent = "...";
        btnLlamarSiguiente.disabled = false;
        btnRellamar.disabled = false;
        clearInterval(intervalo);       //detener temporizador
        guardar_tiempo_perdido();
    }
 }

 // temporizador que cuenta los minutos perdidos en ventanilla
var intervalo;  //declarado fuera para poder detenerlo en cualquier momento
function temporizador(){
    segundosPerdidos++;
    if(segundosPerdidos >= 60){
        minutosPerdidos++;
        guardar_tiempo_perdido();   //guardar el tiempo en pausa en la base de datos
        segundosPerdidos = 0;       //reiniciar los segundos una vez que lleguen a 60
    }
    tiempoRestanteTxt.innerHTML = "Tiempo en pausa hoy:\t" + ('00'+minutosPerdidos).slice(-2) + ":" + ('00'+segundosPerdidos).slice(-2);
    intervalo = setTimeout(temporizador,1000);
}

//guarda el minuto perdido en la jornada
function guardar_tiempo_perdido(){
    $.post(`editar_tiempo_perdido.php`,
    {
        idJornadaLaboral : 1,
        minutosFueraVentanilla : minutosPerdidos,
        segundosFueraVentanilla : segundosPerdidos
    },
    function(data,status){
        if(data==""){
            alert("Ocurrio un error actualizando el tiempo perdido.");
        }
    })
}


// funcion para marcar un ticket para ser llamado
// posteriormente
function marcar_ticket_rellamado(){
    $.post(`marcar_rellamado_ticket.php`,
    {
        direccion : direccion,
        idTicket : idTicket,
        marcarRellamado : 1,
        idEmpleado : idEmpleado
    }, function(data,status){
        if(data == ""){

        }else{
            Swal.fire(
                'Hecho!',
                'Has marcado este ticket para rellamado.',
                'success'
              );
            btnRellamado.disabled = true;
        }
    });
}


 //leer input de escaner (solo numerico)
 let codigoEscaneado = "";
 let reading = false;

 document.addEventListener('keypress', e => {
 if (e.keyCode === 13) {    //enter
       if(codigoEscaneado.length > 0) {
        //  terminar de leer codigo
         if(codigoEscaneado == idBitacoraTicketLlamado){
            clearTimeout(timeOut);  //detener el timeout de 15 segundos de llamado de ticket
            obtenerBitacora(codigoEscaneado);
            deshabilitar_ticket(idTicket);
            btnLlamarSiguiente.disabled = false;
            btnReasignar.disabled = false;
            // codigo listo               
            codigoEscaneado = "";
         }else{
            Swal.fire({
                icon: 'error',
                title: 'Ticket Incorrecto.',
                text: 'El ticket escaneado no coincide con el ticket llamado o no has llamado un ticket.'
              });
         }
         
      }
 } else {
     codigoEscaneado += e.key;        
 }
 //timeout de 500 ms
 if(!reading) {
     reading = true;
     setTimeout(() => {
         codigoEscaneado = "";
         reading = false;
     }, 500);  //ajustar timeout
 }
 });

 //obtener bitacora
 function obtenerBitacora(bitacoraId){
    $.get(`obtener_bitacora.php?idBitacora=${bitacoraId}`, function(data,status){
        var bitacoraJSON = JSON.parse(data);
        if(bitacoraJSON == ""){
            alert("No se encontro esa bitacora.")
        }else{
            //numero de ticket con zero fill
            document.getElementById("numeroTicket").textContent = bitacoraJSON.siglas_direccion + ('000'+bitacoraJSON.numeroTicket).slice(-3);
            numeroLlamados.style.display = 'none';
            estadoTicket.textContent = "ATENDIENDO";
            editarHoraEntrada(bitacoraJSON.idBitacora);
            atendiendoFlag = true;
            btnLlamarSiguiente.innerHTML = '<i class="bi bi-stop-fill" style="padding-right:10px;"></i>Terminar' //estilo del boton
            btnPausar.disabled = true;
            btnLlamarSiguiente.style.background = 'red';
            btnRellamado.disabled = false;
            btnRellamado.style.fontSize = "22px";
            btnRellamado.innerHTML = '<i class="bi bi-check-circle" style="padding-right:10px;"></i>Marcar Rellamado' //estilo del boton para marcar rellamado
        }   
    });
 }

 //editar hora de entrada a la ventanilla 
 function editarHoraEntrada(bitacoraID){
     var currentTime = new Date();
     var datestring = ("0" + currentTime.getHours()).slice(-2) + ":" + ("0" + currentTime.getMinutes()).slice(-2);
   $.post("editar_bitacora_hora_entrada.php",
   {
     idBitacora: bitacoraID,
     horaEntrada: datestring
   }, function(data,status){
       if(data === ""){
            alert("Ocurrio un error editando hora de entrada de ticket")
       }
   });
 }

 //editar hora de salida de la ventanilla 
 function editarHoraSalida(bitacoraID){
    var currentTime = new Date();
    var datestring = ("0" + currentTime.getHours()).slice(-2) + ":" + ("0" + currentTime.getMinutes()).slice(-2);
    // alert(bitacoraID);
  $.post("editar_bitacora_hora_salida.php",
  {
    idBitacora: bitacoraID,
    horaSalida: datestring
  }, function(data,status){
      if(data === ""){
           alert("Ocurrio un error editando la hora de salida de ticket");
      }
  });
}

 
 //obtener ultimo ticket de la cola
 // enviar tramite para filtrar la cola y 
 // solo recibir los tramites que atiende
 // la ventanilla
 var idTicket = 0;  //para guardar el id de ticket obtenido
 var idBitacoraTicketLlamado = 0;   //para comparar si el idBitacora es el mismo en el ticke seleccionado y el escaneado
 var llamados = 3;  //numero de llamados para un ticket
 function obtener_ticket_cola(_callback){
    $.get(`obtener_ultimo_elemento_cola.php?tramites=${tramitesHabilitados}&direccion=${direccion}`, function(data,status){
        var ticketJSON = JSON.parse(data);
        if(ticketJSON == ""){
            Swal.fire({
                icon: 'error',
                title: 'No se encontraron tickets en cola.',
                text: 'No se encontraron tickets en cola para el trámite y área seleccionada.'
              });
        }else{
            idTicket = ticketJSON.idTicket;
            idBitacoraTicketLlamado = ticketJSON.Bitacora_idBitacora;
            document.getElementById("numeroTicket").textContent = ticketJSON.siglas + ('000'+ticketJSON.idTicket).slice(-3);
            estadoTicket.textContent = "Llamando " + ticketJSON.primerNombre + " " + ticketJSON.primerApellido;
            btnPausar.disabled = true;
            numeroLlamados.style.display = 'block';
            btnRellamar.disabled = true;
            llamados = llamados - ticketJSON.vecesLlamado;
            llamados--;
            numeroLlamados.textContent = "Llamados restantes: " + llamados;
            _callback()
        }
        
    });
 }

 //deshabilitar ticket para que no sea llamado
 function deshabilitar_ticket(){
    $.post("habilitar_deshabilitar_ticket.php",
    {
        disponibilidad : 0,
        marcarRellamado : 0,
        idTicket : idTicket,
        direccion : direccion
    }, function(data,status){
        if(data === ""){
             alert("Ocurrio un error deshabilitando el ticket")
        }
    });
 }

//aumentar en 1 el llamado del ticket cuando 
//el usuario cliente no responde al llamado
function aumentar_llamado_ticket(ticketId){
    $.post("aumentar_cuenta_ticket.php",
    {
        idTicket : ticketId,
        direccion : direccion
    }, function(data,status){
        if(data === ""){
            alert("Ocurrio un error " + data);
        }
    });
}

// llenar la tabla en el modal con los tickets que el usuario
// ha marcado para rellamar
function obtener_tickets_rellamado(){
    $.get(`obtener_tickets_rellamar.php?idEmpleado=${idEmpleado}&idDireccion=${direccion}`, function(data,status){
        var ticketJson = JSON.parse(data);
        html = ""
        for (var ticket of ticketJson){
            html += `<tr><td style="color:black;">${ticket.siglas+('000'+ticket.idTicket).slice(-3)}</td>`
            html += `<td style="color:black;">${ticket.nombreTramite}`
            html += `<td class="text-center"><a onclick="cargar_ticket(${ticket.idTicket})" class="btn btn-primary"><i class="bi bi-telephone-inbound"></i>\t\tLlamar</a></td></tr>`
        }
        document.getElementById('lista_tickets_rellamar').innerHTML = html;
    });
}

// funcion para cargar un ticket solo con el id del ticket
// asi se podar carga los tickets que han sido marcados para rellamado
// y cuya disponibilidad es falsa
function cargar_ticket(ticketId){
    $.get(`obtener_ticket.php?idTicket=${ticketId}&direccion=${direccion}`,function(data,status){
        var ticketJson = JSON.parse(data);
        idTicket = ticketJson.idTicket;
        document.getElementById("numeroTicket").textContent = ticketJson.siglas + ('000'+ticketJson.idTicket).slice(-3);
        estadoTicket.textContent = "Llamando...";
        numeroLlamados.style.display = 'block';
        idBitacoraTicketLlamado = ticketJson.Bitacora_idBitacora;
        llamados = llamados - ticketJson.vecesLlamado;
        llamados--;
        numeroLlamados.textContent = "Llamados restantes: " + llamados;
        modalRellamado.style.display = "none";
    });
}

function guardarEstadoPagina(){
    localStorage.setItem('atendiendo',atendiendoFlag);
    localStorage.setItem('idTicket',idTicket);
    localStorage.setItem();
}

var timeOut;    //timeout de 15 segundos luego de llamar un ticket
// Si luego de tres llamados no se presenta 
// el cliente pierde su turno
// el usuario de ventanilla puede hacer un llamado
// cada 15 segundos
 btnLlamarSiguiente.onclick = function(){
     if(btnLlamarSiguiente.textContent == "Terminar"){
        Swal.fire({
            title: '¿Estás seguro que quieres terminar de atender a este ticket?',
            showDenyButton: true,
            confirmButtonText: 'Si',
            denyButtonText: 'Cancelar',
          }).then((result) => {
            if (result.isConfirmed) {
                editarHoraSalida(idBitacoraTicketLlamado);
                location.reload();
            } else if (result.isDenied) {
                return;
            }
          });
     }else{
    //si el id de ticket es 0 significa que no se ha llamado 
     //ningun ticket entonces se obtiene uno
     if(idTicket === 0){
        obtener_ticket_cola(function(){
            //callback, en caso de que encuentre un ticket en cola cambiara el idTicket
            //si encuentra un ticket desactiva el boton de siguiente por 15 segundos y aumenta
            //el llamado del ticket en 1
                btnLlamarSiguiente.disabled = true;
                timeOut = setTimeout(function(){
                    btnLlamarSiguiente.disabled = false;
                }, 15000);
                aumentar_llamado_ticket(idTicket);
                if(llamados === 0)
            {
                timeOut = setTimeout(function(){
                    Swal.fire({
                        icon: 'error',
                        title: 'Ticket deshabilitado.',
                        text: 'El cliente no se presento a ventanilla.'
                    }).then(function(){
                        location.reload();
                    }
                    )
                    deshabilitar_ticket(idTicket);
                    idTicket = 0;
                    llamados = 3;
                },15000);
            }    
        });
    }else{
        aumentar_llamado_ticket(idTicket);
        llamados--;
        numeroLlamados.textContent = "Llamados restantes: " + llamados;
        btnLlamarSiguiente.disabled = true;
        timeOut = setTimeout(function(){
            btnLlamarSiguiente.disabled = false;
        }, 15000);
            if(llamados === 0)
            {
            timeOut = setTimeout(function(){
                    Swal.fire({
                        icon: 'error',
                        title: 'Ticket deshabilitado.',
                        text: 'El cliente no se presento a ventanilla.'
                    }).then(function(){
                        location.reload();
                    }
                    )
                    deshabilitar_ticket(idTicket);
                    idTicket = 0;
                    llamados = 3;
                },15000);
            }    
    }
    btnLlamarSiguiente.blur();    //quitar focus del boton para escanear el ticket sin que el usuario tenga que hacer click afuera
     }   
    }
    


 btnReasignar.onclick = function(){
     modalReasignar.style.display = "block";
 }

 btnRellamado.onclick = function(){
     if(btnRellamado.innerText == "Marcar Rellamado"){
         marcar_ticket_rellamado();
     }else{
        obtener_tickets_rellamado();
        modalRellamado.style.display = "block";
     }
 }

 //cerrar modal al presionar fuera del mismo
 window.onclick = function(){
     if(event.target == modalReasignar){
         modalReasignar.style.display = "none";
     }
     if(event.target == modalRellamado){
         modalRellamado.style.display = "none";
     }
 }

 

 spanCloseModalRellamado.onclick = function(){
     modalRellamado.style.display = "none";
 }