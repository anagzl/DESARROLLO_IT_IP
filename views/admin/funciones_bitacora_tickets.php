<?php 
/**
 * Formato de funcion para carga de informacion en el datetable
 * 
 * @Autor: Luis Estrada 
 * @Fecha Creacion: 30/06/2022
 * @Fecha Revision:
*/
@session_start(); 

/**
 * Funcion para obtener todos los registros para el datatable
 */
    function obtener_todos_registros_bitacora_tickets(){
        include('../../config/conexion.php');
        $stmt=$conexion->prepare("SELECT
        idBitacora,
        Sede_idSede,
        Usuario_idUsuario,
        Tramite_idTramite,
        Direccion_idDireccion,
        fecha,
        horaGeneracionTicket,
        horaEntrada,
        horaSalida,
        Observacion,
        numeroTicket
    FROM
        bitacora");
        $stmt->execute();
        $resultado = $stmt->fetchAll();

        return $stmt->rowCount();

    }


?>