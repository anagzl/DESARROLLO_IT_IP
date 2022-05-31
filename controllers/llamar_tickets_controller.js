 var tiempoPerdido = 15;

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

 //consultar el count de tickets cada 2 segundos
 $(document).ready(function() {
    setInterval(obtener_personas_espera_catastro, 2000);
});

function obtener_personas_espera_catastro() { 
    $.get(`count_tickets_catastro.php`, function(data,status){
        var countJSON = JSON.parse(data);
        //numero de ticket con zero fill
        personasEsperaTxt.innerHTML = `Personas en espera: ${countJSON}`
    });
}

document.getElementById("clock").onload = function(){
    currentTime()
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
     var intervaloMinuto;
    if(btnPausar.textContent === "Pausar"){
        btnPausar.innerHTML = '<i class="bi bi-play-btn-fill" style="padding-right:10px;"></i>Reanudar'
        btnPausar.style.background = 'red';
        btnLlamarSiguiente.disabled = true;
        btnRellamar.disabled = true;
        btnReasignar.disabled = true;
        tiempoRestanteTxt.style.display = 'block';
        intervaloMinuto = setInterval(function(){
            tiempoPerdido--;
            tiempoRestanteTxt.innerHTML = tiempoPerdido + " Minutos Restantes";
        },1000)
    }else
    if(btnPausar.textContent === "Reanudar"){
        btnPausar.innerHTML = '<i class="bi bi-pause-btn-fill" style="padding-right:10px;"></i>Pausar';
        btnPausar.style.background = '#88cfe1';
        tiempoRestanteTxt.style.display = 'none';
        btnLlamarSiguiente.disabled = false;
        btnRellamar.disabled = false;
        btnReasignar.disabled = false;
        clearInterval(intervaloMinuto);
    }
 }


 //leer input de escaner (solo numerico)
 let codigoEscaneado = "";
 let reading = false;

 document.addEventListener('keypress', e => {
 if (e.keyCode === 13) {
       if(codigoEscaneado.length > 0) {
         //terminar de leer codigo
         obtenerBitacora(codigoEscaneado)
         // codigo listo               
         codigoEscaneado = "";
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
        //numero de ticket con zero fill
        document.getElementById("numeroTicket").textContent = bitacoraJSON.siglas + ('000'+bitacoraJSON.numeroTicket).slice(-3);
        numeroLlamados.style.display = 'none';
        estadoTicket.textContent = "ATENDIENDO";
        editarHoraEntrada(bitacoraJSON.idBitacora)
    });
 }

 //editar hora de entrada a la ventanilla 
 function editarHoraEntrada(bitacoraID){
     var currentTime = new Date();
     var datestring = ("0" + currentTime.getHours()).slice(-2) + ":" + ("0" + currentTime.getMinutes()).slice(-2);
   $.post("editar_bitacora.php",
   {
     idBitacora: bitacoraID,
     horaEntrada: `${datestring}`
   }, function(data,status){
       if(data === ""){
            alert("Ocurrio un error")
       }
   });
 }

 //aumentar llamado de tickets
 function aumentar_llamado_ticket(){
    $.post("aumentar_cuenta_ticket.php",
    {
      idTicketCatastro : idTicket
    }, function(data,status){
        if(data === ""){
             alert("Ocurrio un error")
        }
    });
 }
 
 //obtener ultimo ticket de la cola
 // enviar tramite para filtrar la cola y 
 // solo recibir los tramites que atiende
 // la ventanilla
 var idTicket = 0;  //para guardar el id de ticket obtenido
 var llamados = 3;  //numero de llamados para un ticket
 function obtener_ticket_cola_catastro(tramite){
    $.get(`obtener_ultimo_elemento_cola_catastro.php?idTramite=${tramite}`, function(data,status){
        var ticketJSON = JSON.parse(data);
        if(ticketJSON == ""){
            Swal.fire({
                icon: 'error',
                title: 'No se encontraron tickets en cola.',
                text: 'No se encontraton tickets en cola para el trámite y área seleccionada.'
              });
        }else{
            idTicket = ticketJSON.idTicketCatastro;
            document.getElementById("numeroTicket").textContent = ticketJSON.siglas + ('000'+ticketJSON.idTicketCatastro).slice(-3);
            estadoTicket.textContent = "Llamando...";
            numeroLlamados.style.display = 'block';
            numeroLlamados.textContent = "Llamados restantes: " + llamados;
            llamados--;
        }
        
    });
 }

 //deshabilitar ticket para que no sea llamado
 function deshabilitar_ticket_catastro(){
    $.post("habilitar_deshabilitar_ticket.php",
    {
        disponibilidad : 0,
        idTicketCatastro : idTicket
    }, function(data,status){
        if(data === ""){
             alert("Ocurrio un error")
        }
    });
 }


// Si luego de tres llamados no se presenta 
// el cliente pierde su turno
// el usuario de ventanilla puede hacer un llamado
// cada 30 segundos
 btnLlamarSiguiente.onclick = function(){
    if(llamados === 0)
    {
        Swal.fire({
            icon: 'error',
            title: 'Ticket deshabilitado.',
            text: 'El cliente no se presento a ventanilla.'
          }).then(function(){
              location.reload();
          }
          )
          deshabilitar_ticket_catastro(idTicket);
          llamados = 3;
    }else{
        obtener_ticket_cola_catastro(1);
        if(idTicket ==! 0){
            btnLlamarSiguiente.disabled = true;
            const timeOut = setTimeout(function(){
                btnLlamarSiguiente.disabled = false;
            }, 30000);
        }
    }
    
 }

 btnReasignar.onclick = function(){
     modalReasignar.style.display = "block";
 }

 btnRellamado.onclick = function(){
     modalRellamado.style.display = "block";
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

 //cerrar modal con boton de X
 spanCloseModalReasignar.onclick = function() {
     modalReasignar.style.display = "none";
 }

 spanCloseModalRellamado.onclick = function(){
     modalRellamado.style.display = "none";
 }