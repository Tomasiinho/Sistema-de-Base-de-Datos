<?php
session_start();

// Bloqueo si no está logueado
if (!isset($_SESSION["user_id"])) {
    die("Debe iniciar sesión para acceder.");
}

// Conexión BD
$conexion = new mysqli("localhost", "root", "", "restaurante");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener ID del usuario en sesión
$id_usuario = $_SESSION["user_id"];

// Consulta del usuario con JOIN al rol
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

// Validación
if ($result->num_rows !== 1) {
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
<div class="container mt-5" style="max-width: 700px;">
    <div class="card p-4 shadow">
        <h3 class="text-center">Mi Perfil</h3>
        <hr>

        <p><strong>Nombre:</strong> <?= htmlspecialchars($usuario["nombre_usuario"]) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($usuario["email"]) ?></p>
        <p><strong>Rol:</strong> <?= htmlspecialchars($usuario["nombre_rol"]) ?></p>

        <hr>

        <!-- Botones de acción -->
        <a href="modificar_usuario.php" class="btn btn-warning w-100 mb-2">Modificar Perfil</a>
        <a href="eliminar_usuario.php" class="btn btn-danger w-100 mb-2"
           onclick="return confirm('¿Seguro que deseas eliminar tu cuenta? ¡Esta acción es irreversible!');">
            Eliminar Cuenta
        </a>

        <!-- BOTÓN VOLVER SEGÚN ROL -->
        <?php if ($_SESSION["user_role"] == 1): ?>
            <a href="dashboard.php" class="btn btn-secondary w-100 mt-2">Volver al Inicio</a>
        <?php else: ?>
            <a href="portal_trabajador.php" class="btn btn-secondary w-100 mt-2">Volver al Inicio</a>
        <?php endif; ?>

        <a href="logout.php" class="btn btn-outline-dark w-100 mt-3">Cerrar Sesión</a>
    </div>
</div>
</body>
</html>
