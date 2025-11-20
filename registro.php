<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    // Validar
    if (empty($_POST['nombre_usuario']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['id_rol'])) {
        die("Todos los campos son obligatorios.");
    }

    $nombre = $_POST['nombre_usuario'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $id_rol = $_POST['id_rol'];

    // Encriptar la contraseña
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    // Conexión BD
    $conexion = new mysqli("localhost", "root", "", "restaurante");

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Verificar si el email ya existe
    $check = $conexion->prepare("SELECT email FROM usuarios WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $error = "El correo electrónico ya está registrado.";
    } else {

        // Insert correcto según tu BD real
        $query = $conexion->prepare("
            INSERT INTO usuarios (nombre_usuario, password, email, activo, id_rol)
            VALUES (?, ?, ?, 1, ?)
        ");

        if (!$query) {
            die("Error al preparar la consulta: " . $conexion->error);
        }

        $query->bind_param("sssi", $nombre, $password_hash, $email, $id_rol);

        if ($query->execute()) {
            $exito = "Usuario registrado con éxito.";
        } else {
            $error = "Error al ejecutar la consulta: " . $query->error;
        }

        $query->close();
    }

    $check->close();
    $conexion->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container text-center">

    <div class="card text-center p-3 mx-auto my-5" style="max-width: 400px;">
        <h1>Registro de Usuarios</h1>

        <?php
        if (isset($error)) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
        if (isset($exito)) {
            echo "<div class='alert alert-success'>$exito</div>";
        }
        ?>

        <form action="registro.php" method="post">
            <div class="mb-3">
                <label class="form-label">Nombre completo</label>
                <input type="text" class="form-control" name="nombre_usuario" placeholder="Ingrese su nombre" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Correo electrónico</label>
                <input type="email" class="form-control" name="email" placeholder="Ingrese su correo" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input type="password" class="form-control" name="password" placeholder="Ingrese una contraseña" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Rol</label>
                <select class="form-select" name="id_rol" required>
                    <option value="">Seleccione un rol...</option>
                    <option value="1">Administrador</option>
                    <option value="2">Mesero</option>
                    <option value="3">Usuario</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Registrar</button>
        </form>

        <br>
        <p>¿Ya tienes cuenta?</p>
        <a href="login.php"><b>Inicia sesión</b></a>
    </div>

</div>
</body>
</html>
