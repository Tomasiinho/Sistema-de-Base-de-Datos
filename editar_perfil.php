<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    die("Debe iniciar sesión para acceder.");
}

$conexion = new mysqli("localhost", "root", "", "restaurante");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$id_usuario = $_SESSION["user_id"];

// Obtener datos actuales
$sql = "SELECT nombre_usuario, email FROM usuarios WHERE id_usuarios = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();
$stmt->close();

// Si envían formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nuevo_nombre = trim($_POST["nombre_usuario"]);
    $nuevo_email  = trim($_POST["email"]);
    $nueva_pass   = trim($_POST["password"]);

    if (empty($nuevo_nombre) || empty($nuevo_email)) {
        $error = "Nombre y email son obligatorios.";
    } else {
        // Si la contraseña está vacía, no se actualiza
        if (!empty($nueva_pass)) {
            $pass_hash = password_hash($nueva_pass, PASSWORD_BCRYPT);
            $sql = "UPDATE usuarios SET nombre_usuario=?, email=?, password=? WHERE id_usuarios=?";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("sssi", $nuevo_nombre, $nuevo_email, $pass_hash, $id_usuario);
        } else {
            $sql = "UPDATE usuarios SET nombre_usuario=?, email=? WHERE id_usuarios=?";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("ssi", $nuevo_nombre, $nuevo_email, $id_usuario);
        }

        if ($stmt->execute()) {
            $exito = "Perfil actualizado correctamente.";
            $_SESSION["user_name"] = $nuevo_nombre;
        } else {
            $error = "Error al actualizar: " . $stmt->error;
        }

        $stmt->close();
    }
}

$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<div class="container mt-5" style="max-width: 600px;">
    <div class="card p-4 shadow">

        <h3 class="text-center">Editar Perfil</h3>
        <hr>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if (isset($exito)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($exito) ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Nombre de Usuario</label>
                <input type="text" name="nombre_usuario" class="form-control"
                       value="<?= htmlspecialchars($usuario["nombre_usuario"]) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control"
                       value="<?= htmlspecialchars($usuario["email"]) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nueva Contraseña (opcional)</label>
                <input type="password" name="password" class="form-control"
                       placeholder="Dejar vacío para no cambiar">
            </div>

            <button type="submit" class="btn btn-primary w-100">Guardar Cambios</button>
        </form>

        <hr>

        <a href="perfil_usuario.php" class="btn btn-secondary w-100">Volver</a>

    </div>
</div>
</body>
</html>
