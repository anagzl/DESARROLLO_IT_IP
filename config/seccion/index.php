<?php
/**
 * Estructura para el control de secciones y validacion de usuario en el sistema. 
 * 
 * @Autor: Luis Estrada 
 * @Fecha Creacion: 01/03/2022
 * @Fecha Revision: 08/03/2022
*/

/* 
Descripcion de la sentencia include_once incluye y evalúa el fichero especificado durante la ejecución del script. 
Tiene un comportamiento similar al de la sentencia include, siendo la única diferencia de que si el 
código del fichero ya ha sido incluido, no se volverá a incluir, e include_once devolverá true. 
 */
include_once 'config/user.php';
include_once 'config/user_session.php';

$userSession = new UserSession();
$user = new User();

if(isset($_SESSION['user'])){
    //echo "hay sesion";
    $user->setUser($userSession->getCurrentUser());
    include_once 'views/registrar_asistencia.php';

}else if(isset($_POST['username']) && isset($_POST['password'])){
    $userForm = $_POST['username'];
    $passForm = $_POST['password'];

    $user = new User();
    if($user->userExists($userForm, $passForm)){
       // echo "Existe el usuario";
        $userSession->setCurrentUser($userForm);
        $user->setUser($userForm);

        include_once 'views/registrar_asistencia.php';
    }else{
       // echo "No existe el usuario";
        $errorLogin = "Nombre de usuario y/o contraseña incorrecto. Favor intente de nuevo.";
        include_once 'views/login.php';
    }
}else{
    //echo "login";
    include_once 'views/login.php';
}
?>