<?php
session_start();
require_once "auth.php";
require_role([1, 2, 3]);

// ✅ Si no existen los datos, les damos un valor por defecto
$id_rol = $_SESSION["id_rol"] ?? 0;
$id_usuario = $_SESSION["id_usuario"] ?? 0;

// ✅ Conexión
$conexion = new mysqli("localhost", "root", "", "restaurante");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// ✅ Si es mesero (rol 2), solo ve sus pedidos
if ($id_rol == 2) {
    $pedidos = $conexion->query("
        SELECT 
            p.id_pedido, 
            m.numero_mesa, 
            u.nombre_usuario AS mesero,
            p.fecha_pedido, 
            p.total, 
            p.`forma de pago`
        FROM pedidos p
        LEFT JOIN mesas m ON m.id_mesa = p.mesa
        LEFT JOIN usuarios u ON u.id_usuarios = p.mesero
        WHERE p.mesero = $id_usuario
        ORDER BY p.id_pedido DESC;
    ");
} else {
    // ✅ Otros roles ven todos
    $pedidos = $conexion->query("
        SELECT 
            p.id_pedido, 
            m.numero_mesa, 
            u.nombre_usuario AS mesero,
            p.fecha_pedido, 
            p.total, 
            p.`forma de pago`
        FROM pedidos p
        LEFT JOIN mesas m ON m.id_mesa = p.mesa
        LEFT JOIN usuarios u ON u.id_usuarios = p.mesero
        ORDER BY p.id_pedido DESC;
    ");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Pedidos</title>
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
                    <button type="submit" class="btn btn-primary">Cerrar sesión</button>
                </a>
            </div>
        </div>
    </nav>

<div class="container mt-4">
    <h2 class="text-center mb-4">Listado de Pedidos</h2>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID Pedido</th>
                <th>Mesa</th>
                <th>Mesero</th>
                <th>Fecha</th>
                <th>Total</th>
                <th>Forma de Pago</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($p = $pedidos->fetch_assoc()) : ?>
            <tr>
                <td><?= $p["id_pedido"] ?></td>
                <td><?= $p["numero_mesa"] ?></td>
                <td><?= $p["mesero"] ?></td>
                <td><?= $p["fecha_pedido"] ?></td>
                <td>$<?= number_format($p["total"], 0, ",", ".") ?></td>
                <td><?= $p["forma de pago"] ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <a href="portal_trabajador.php" class="btn btn-secondary">Volver</a>
</div>

</body>
</html>
