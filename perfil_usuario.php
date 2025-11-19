<?php
session_start();

// Verificar sesión
if (!isset($_SESSION["user_id"])) {
    die("Debe iniciar sesión para acceder.");
}

// Conexión BD
$conexion = new mysqli("localhost", "root", "", "restaurante");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// ID usuario actual
$user_id = (int) $_SESSION["user_id"];

// Consulta correcta según tu BD
$sql = "SELECT u.nombre, u.email, r.nombre AS rol 
        FROM usuarios u
        INNER JOIN roles r ON u.id_rol = r.id_rol
        WHERE u.id_usuarios = ?
        LIMIT 1";

$stmt = $conexion->prepare($sql);
if (!$stmt) {
    die("Error al preparar la consulta: " . $conexion->error);
}

$stmt->bind_param("i", $user_id);

if (!$stmt->execute()) {
    die("Error al ejecutar la consulta: " . $stmt->error);
}

$result = $stmt->get_result();
if ($result->num_rows !== 1) {
    die("Usuario no encontrado.");
}

$user = $result->fetch_assoc();

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
        <h3 class="text-center mb-3">Perfil del Usuario</h3>
        <hr>

        <p><strong>Nombre:</strong> <?= htmlspecialchars($user["nombre"]) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user["email"]) ?></p>
        <p><strong>Rol:</strong> <?= htmlspecialchars($user["rol"]) ?></p>

        <hr>
        <a href="dashboard.php" class="btn btn-primary w-100 mb-2">Volver al Dashboard</a>
        <a href="logout.php" class="btn btn-danger w-100">Cerrar Sesión</a>
    </div>
</div>
</body>
</html>
