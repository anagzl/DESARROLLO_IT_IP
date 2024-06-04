<?php
/**
 * Formato conexion via LDAP 
 * 
 * @Autor: Luis Estrada 
 * @Fecha Creacion: 01/03/2022
 * @Fecha Revision:
*/

require_once("config.php");
// Desactivar toda las notificaciónes del PHP
error_reporting(0);


/*  mailboxpowerloginrd('tecnico','Pulgoso22'); */

function mailboxpowerloginrd($user,$pass){
  // Datos de acceso al servidor LDAP
    $ldaprdn = trim($user).'@'.DOMINIO; 

    if($pass != ""){
      $ldappass = trim($pass);  
    }else{
      /* Enviar contraseña invalida para detonar erorr */
      $ldappass = "Errorr";
    }
    $ds = DOMINIO; 
    $dn = DN;  
    $basedn ="dc=ip,dc=gob,dc=hn";
    $puertoldap = 389; 
    /*  */
    $group = 'SomeGroup';

    // Atributo para incorporar en la respuesta
    $displayAttr = "cn";
    // Respuesta por defecto
    $status = 1;
    $msg = "";
    $userDisplayName = "null";
    $user_n = "null";
    $name = "null";
    $description = "null";
    $group= "null";
    $level=  "null";

// Establecer la conexión con el servidor LDAP
    $ldapconn = ldap_connect($ds,$puertoldap) or die("No se pudo conectar al servidor LDAP.");

    // Autenticar contra el servidor LDAP
      ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION,3); 
      ldap_set_option($ldapconn, LDAP_OPT_REFERRALS,0); 

    /* Realiza la autenticación con un servidor LDAP
      Autentica contra un servidor LDAP tomando un RDN y contraseña especificados. 
    */
      $ldapbind = @ldap_bind($ldapconn, $ldaprdn, $ldappass); 
      /* echo "- Prueba de LDAP -"; */

    if ($ldapbind){
		    $filter="(|(SAMAccountName=".trim($user)."))";
        $fields = array('sAMAccountName','description',"OU", "dn", "cn", "givenName"); 
        /*  echo  $filter; */
        // En caso de éxito, recuperar los datos del usuario
        $sr = @ldap_search($ldapconn, $dn, $filter, $fields); 

/*         if($sr["count"]>0){
          $info = @ldap_get_entries($ldapconn, $sr);
        }else{
          $msg = "<script> alert('Usuario o clave incorrecta. Vuelva a digitarlos por favor.'); window.location.href='../user/login.php'; </script>";
        } */
        $info = @ldap_get_entries($ldapconn, $sr);

        // Si hay resultados en la búsqueda
        if($info["count"]>0){
            $status = 0;
            if (isset($info[0][$displayAttr])) {
              // Recuperar el atributo a incorporar en la respuesta
              $userDisplayName = $info[0][$displayAttr][0];
            /*  echo 'console.log('.$msg.')';*/
              /* nombre.apellido para validar con el numero de identidad*/
              $user_login = $info[0]["samaccountname"][0];
              // identificador de sesión generado por el sistema por el tuyo propio
/*               session_id($user_login); */

              // start a session
              session_start();
              // initialize session variables
              $_SESSION["userlogin"]=$user_login ;
/*               echo " -- Nombre de usuario -->". $_SESSION["userlogin"]. " "; */
              /* Nombre Completo displayname */
              $name = $info[0]["cn"][0];
              /* En la unidad adminitrativa que se ubica. */
              $dn = $info[0]["dn"][0];
/*            $description = explode(',',$info[0]["description"][0]);
            
              $group= $description[0];
              $level= $description[1]; */
              $msg = $name;
              /* Llamado de funciones para LDAP */
              /* echo  $userdn = getDN($ldapconn, $ldaprdn, $basedn); */
/*               if (checkGroupEx($ldapconn, $userdn, getDN($ldapconn, $group, $basedn))) {
              //if (checkGroup($ad, $userdn, getDN($ad, $group, $basedn))) {
                  echo "You're authorized as ".getCN($userdn);
              } else {
                  echo 'Authorization failed';
              } */
            }/* else {
                        // Si el atributo no está definido para el usuario
                        $userDisplayName = "-";
                        $msg = "Atributo no disponible ({$displayAttr})";
                } */
        }else{
          // Si no hay resultados en la búsqueda, retornar error
          $msg = "<script> alert('Usuario o clave incorrecta. Vuelva a digitarlos por favor.'); window.location.href='../user/login.php'; </script>";
        }
	  }else{ 
        $array=0;
           // Si falla la autenticación, retornar un msj de error
        $msg = "<script> alert('Usuario o clave incorrecta. Vuelva a digitarlos por favor.'); window.location.href='../user/login.php'; </script>";
      } 

  ldap_close($ldapconn); 

	return $msg;
} 



/* Funciones para verificar la membresía del grupo y algunas otras que pueden ser útiles para trabajar con LDAP (Active Directory en este ejemplo). 
https://www.php.net/manual/en/ref.ldap.php#99347
*/

/*
*Esta función busca en el árbol LDAP ($ad -Identificador de enlace LDAP)
* entrada especificada por samaccountname y devuelve su DN o epmty
* cadena en caso de falla.
*/
function getDN($ad, $samaccountname, $basedn) {
    $attributes = array('dn');
    $result = ldap_search($ad, $basedn,
        "(samaccountname={$samaccountname})", $attributes);
    if ($result === FALSE) { return ''; }
    $entries = ldap_get_entries($ad, $result);
    if ($entries['count']>0) { return $entries[0]['dn']; }
    else { return ''; };
}

/*
* Esta función recupera y devuelve CN de DN dado
*/
function getCN($dn) {
    preg_match('/[^,]*/', $dn, $matchs, PREG_OFFSET_CAPTURE, 3);
    return $matchs[0][0];
}

/*
* Esta función verifica la pertenencia al grupo del usuario, buscando solo
* en el grupo especificado (no recursivamente).
*/
function checkGroup($ad, $userdn, $groupdn) {
    $attributes = array('members');
    $result = ldap_read($ad, $userdn, "(memberof={$groupdn})", $attributes);
    if ($result === FALSE) { return FALSE; };
    $entries = ldap_get_entries($ad, $result);
    return ($entries['count'] > 0);
}

/*
* Esta función comprueba la pertenencia al grupo del usuario, buscando
* en grupo especificado y grupos que son sus miembros (recursivamente).
*/
function checkGroupEx($ad, $userdn, $groupdn) {
    $attributes = array('memberof');
    $result = ldap_read($ad, $userdn, '(objectclass=*)', $attributes);
    if ($result === FALSE) { return FALSE; };
    $entries = ldap_get_entries($ad, $result);
    if ($entries['count'] <= 0) { return FALSE; };
    if (empty($entries[0]['memberof'])) { return FALSE; } else {
        for ($i = 0; $i < $entries[0]['memberof']['count']; $i++) {
            if ($entries[0]['memberof'][$i] == $groupdn) { return TRUE; }
            elseif (checkGroupEx($ad, $entries[0]['memberof'][$i], $groupdn)) { return TRUE; };
        };
    };
    return FALSE;
}

?>
