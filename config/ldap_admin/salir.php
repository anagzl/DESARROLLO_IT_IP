<?php
    session_start();
    session_destroy();
    header("Location: ../views/user/portal.php");
?>
