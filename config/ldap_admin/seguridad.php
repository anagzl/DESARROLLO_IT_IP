<?php
@session_start();
if($_SESSION["autentica"] != "SIP"){
	header("Location: ../../views/admin/login.php");
	exit();
}
?>
