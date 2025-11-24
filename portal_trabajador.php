<?php
session_start();

// Validar sesión
if (!isset($_SESSION["user_id"])) {
    die("Debe iniciar sesión para acceder.");
}

// Si es admin, que NO entre al portal de trabajadores
if ($_SESSION["user_role"] == 1) {
    header("Location: dashboard.php");
    exit();
}

// Datos del usuario logueado
$nombre = $_SESSION["user_name"];
$rol    = $_SESSION["user_role"];

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Portal de Trabajadores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="portal_trabajador.php">Inicio</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="perfil_usuario.php">Mi Perfil</a>
                    </li>
                </ul>
                <a href="logout.php">
                    <button type="submit" class="btn btn-primary">Cerrar sesion</button>
                </a>
            </div>
        </div>
    </nav>
<div class="container mt-5">
    <div class="card shadow p-4" style="max-width: 600px; margin: auto;">

        <h2 class="text-center mb-3">Bienvenido, <?= htmlspecialchars($nombre) ?></h2>

        <h5 class="text-center text-muted">
            Rol:
            <?php
                if ($rol == 2) echo "Mesero";
                elseif ($rol == 3) echo "Cajero";
                else echo "Trabajador";
            ?>
        </h5>

        <hr>

        <!-- Opciones según rol -->
        <?php if ($rol == 2): ?>
            <h4 class="mb-3">Opciones del Mesero</h4>
            <a href="ver_mesas.php" class="btn btn-primary w-100 mt-2">Ver Mesas Disponibles</a>
            <a href="mis_pedidos.php" class="btn btn-primary w-100 mt-2">Mis Pedidos</a>
        <?php endif; ?>

        <?php if ($rol == 3): ?>
            <h4 class="mb-3">Opciones del Cajero</h4>
            <a href="mis_pedidos.php" class="btn btn-primary w-100 mt-2">Ver Pedidos</a>
            <a href="crear_pedido.php" class="btn btn-primary w-100 mt-2">Crear Pedido</a>
        <?php endif; ?>

    </div>
</div>

</body>
</html>
