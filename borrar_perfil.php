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

// Si confirman eliminación
if (isset($_POST["confirmar"])) {

    $sql = "DELETE FROM usuarios WHERE id_usuarios = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id_usuario);

    if ($stmt->execute()) {
        session_destroy();
        header("Location: login.php");
        exit();
    } else {
        $error = "Error al eliminar usuario: " . $stmt->error;
    }

    $stmt->close();
}

$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<div class="container mt-5" style="max-width: 600px;">
    <div class="card p-4 shadow">

        <h3 class="text-center text-danger">Eliminar Cuenta</h3>
        <hr>

        <p class="text-center">
            ¿Estás seguro que deseas eliminar tu cuenta?<br>
            <strong>Esta acción es permanente y no se puede deshacer.</strong>
        </p>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST">
            <button type="submit" name="confirmar" class="btn btn-danger w-100 mb-2">
                Sí, eliminar mi cuenta
            </button>

            <a href="perfil_usuario.php" class="btn btn-secondary w-100">
                Cancelar
            </a>
        </form>

    </div>
</div>
</body>
</html>
