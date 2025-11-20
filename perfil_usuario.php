<?php
session_start();

// Verificar que el usuario está logueado
if (!isset($_SESSION["user_id"])) {
    die("Debe iniciar sesión para acceder.");
}

$conexion = new mysqli("localhost", "root", "", "restaurante");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$id_usuario = $_SESSION["user_id"];

// Consulta para obtener información del usuario + nombre del rol
$sql = "SELECT u.nombre_usuario, u.email, r.nombre_rol 
        FROM usuarios u
        LEFT JOIN roles r ON u.id_rol = r.id_rol
        WHERE u.id_usuarios = ?
        LIMIT 1";

$stmt = $conexion->prepare($sql);

if (!$stmt) {
    die("Error al preparar la consulta: " . $conexion->error);
}

$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Usuario no encontrado.");
}

$usuario = $result->fetch_assoc();

$stmt->close();
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil del Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<div class="container mt-5" style="max-width: 600px;">
    <div class="card p-4 shadow">
        <h3 class="text-center">Perfil del Usuario</h3>
        <hr>

        <p><strong>Nombre de Usuario:</strong> <?= htmlspecialchars($usuario["nombre_usuario"]) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($usuario["email"]) ?></p>
        <p><strong>Rol:</strong> <?= htmlspecialchars($usuario["nombre_rol"]) ?></p>

        <hr>

        <a href="dashboard.php" class="btn btn-primary w-100">Volver al Panel</a>
        <a href="logout.php" class="btn btn-danger w-100 mt-2">Cerrar Sesión</a>
    </div>
    <div class="mt-4 d-flex flex-column gap-2">

    <!-- Botón Editar Perfil -->
    <a href="editar_perfil.php" class="btn btn-warning w-100">
        Editar Perfil
    </a>

    <!-- Botón Eliminar Perfil -->
    <a href="eliminar_perfil.php" class="btn btn-danger w-100"
       onclick="return confirm('¿Seguro que deseas eliminar tu cuenta? Esta acción es irreversible.');">
        Eliminar Perfil
    </a>

</div>
</div>
</body>
</html>
