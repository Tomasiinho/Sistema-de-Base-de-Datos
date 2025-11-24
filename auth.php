<?php

// Iniciar sesión solo si no existe una activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar login
function require_login() {
    if (!isset($_SESSION["user_id"])) {
        die("Acceso denegado. Debe iniciar sesión.");
    }
}

// Verificar permiso según rol
// $roles acepta un array de roles permitidos
function require_role($roles) {
    require_login();

    if (!in_array($_SESSION["user_role"], $roles)) {
        die("Acceso denegado. No tiene permisos para entrar aquí.");
    }
}
?>
