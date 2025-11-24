<?php
session_start();

// Si quieres que SOLO el admin vea las mesas, usa:
require_once "auth.php";
require_role([1, 2]); // Solo admin y mesero

// Si quieres permitir también a cajeros y meseros usa:
// require_role([1, 2, 3]);

// Conexión a la BD
$conexion = new mysqli("localhost", "root", "", "restaurante");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener las mesas
$sql = "SELECT * FROM mesas ORDER BY numero_mesa ASC";
$resultado = $conexion->query($sql);

if (!$resultado) {
    die("Error en la consulta SQL: " . $conexion->error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Mesas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
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

<div class="container mt-5">
    <div class="card p-4 shadow">

        <h2 class="text-center mb-3">Mesas del Restaurante</h2>
        <hr>

        <table class="table table-bordered table-hover text-center">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>N° Mesa</th>
                    <th>Capacidad</th>
                    <th>Estado</th>
                </tr>
            </thead>

            <tbody>
            <?php while ($mesa = $resultado->fetch_assoc()): ?>
                <tr>
                    <td><?= $mesa["id_mesa"] ?></td>
                    <td><?= $mesa["numero_mesa"] ?></td>
                    <td><?= $mesa["capacidad"] ?></td>

                    <td>
                        <?php
                        $estado = $mesa["estado"];
                        $badge = "secondary";

                        if ($estado === "Disponible") $badge = "success";
                        if ($estado === "Ocupada") $badge = "danger";
                        if ($estado === "Reservada") $badge = "warning";
                        ?>

                        <span class="badge bg-<?= $badge ?>"><?= $estado ?></span>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>

        <a href="dashboard.php" class="btn btn-secondary w-100 mt-3">Volver al Dashboard</a>

    </div>
</div>

</body>
</html>
