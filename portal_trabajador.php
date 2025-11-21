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
            <a href="crear_pedido.php" class="btn btn-primary w-100 mt-2">Crear Pedido</a>
            <a href="mis_pedidos.php" class="btn btn-primary w-100 mt-2">Mis Pedidos</a>
        <?php endif; ?>

        <?php if ($rol == 3): ?>
            <h4 class="mb-3">Opciones del Cajero</h4>
            <a href="ver_pedidos.php" class="btn btn-primary w-100 mt-2">Ver Pedidos</a>
            <a href="procesar_pago.php" class="btn btn-primary w-100 mt-2">Procesar Pagos</a>
        <?php endif; ?>

        <hr>

        <a href="perfil_usuario.php" class="btn btn-info w-100 mt-2">Mi Perfil</a>
        <a href="logout.php" class="btn btn-danger w-100 mt-2">Cerrar Sesión</a>

    </div>
</div>

</body>
</html>
