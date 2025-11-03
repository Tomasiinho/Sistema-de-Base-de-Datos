<?php
// Inicia la sesión
session_start();

// Destruye la sesión
session_unset();
session_destroy();

// Redirige al login
header("Location: login.php");
exit;
?>