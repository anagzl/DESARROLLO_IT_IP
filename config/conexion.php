<?php
/**
 * Formato de conexion a la BD
 * 
 * @Autor: Luis Estrada 
 * @Fecha Creacion: 01/03/2022
 * @Fecha Revision:
*/

/**
 * Definir la conexion a la BD
 */
require_once "global.php";
   $conexion = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USERNAME, DB_PASSWORD);
   $conexion1 = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USERNAME, DB_PASSWORD);

?>