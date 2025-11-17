<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: pagina_principal.php");
    exit;
}

?>