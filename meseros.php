<?php
session_start();

// Conexión a la BD
$conexion = new mysqli("localhost", "root", "", "restaurante");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// CONSULTA CORRECTA: meseros son usuarios con id_rol = 2
$sql = "SELECT id_usuarios, nombre_usuario, email 
        FROM usuarios 
        WHERE id_rol = 2";

$resultado = $conexion->query($sql);

if (!$resultado) {
    die("Error en la consulta SQL: " . $conexion->error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Meseros Disponibles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">
    <div class="card p-4 shadow">

        <h2 class="text-center mb-3">Meseros Disponibles</h2>
        <hr>

        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre del Mesero</th>
                    <th>Email</th>
                </tr>
            </thead>

            <tbody>
            <?php while ($mesero = $resultado->fetch_assoc()): ?>
                <tr>
                    <td><?= $mesero["id_usuarios"] ?></td>
                    <td><?= $mesero["nombre_usuario"] ?></td>
                    <td><?= $mesero["email"] ?></td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>

        <a href="portal_trabajador.php" class="btn btn-secondary w-100 mt-3">Volver</a>

    </div>
</div>

</body>
</html>
