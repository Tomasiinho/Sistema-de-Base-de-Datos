<?php
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    // Validar datos del formulario
    if (empty($_POST['nombre']) || empty($_POST['id_rol']) || empty($_POST['email']) || empty($_POST['password'])) {
        die("Todos los campos son obligatorios.");
    }

    $nombre = trim($_POST['nombre']);
    $id_rol = $_POST['id_rol'];
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Encriptar la contraseña
    if (!empty($password)) {
        $contraseña_encriptada = password_hash($password, PASSWORD_BCRYPT);
    } else {
        die("La contraseña no puede estar vacía.");
    }

    // Conexión a la base de datos
    $db_host = "localhost";
    $db_name = "restaurante";
    $db_user = "root";
    $db_pass = "";

    $conexion = new mysqli($db_host, $db_user, $db_pass, $db_name);
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Verificar si el correo ya existe
    $query_verificar = $conexion->prepare("SELECT email FROM usuarios WHERE email = ?");
    $query_verificar->bind_param("s", $email);
    $query_verificar->execute();
    $query_verificar->store_result();

    if ($query_verificar->num_rows > 0) {
        $error = "El correo electrónico ya está registrado.";
    } else {
        // Insertar nuevo usuario
        $query = $conexion->prepare("INSERT INTO usuarios (nombre, email, password, id_rol) VALUES (?, ?, ?, ?)");
        if (!$query) {
            die("Error al preparar la consulta: " . $conexion->error);
        }
        $query->bind_param("sssi", $nombre, $email, $contraseña_encriptada, $id_rol);
        
        if ($query->execute()) {
            $exito = "✅ Datos guardados con éxito.";
        } else {
            $error = "❌ Error al ejecutar la consulta: " . $query->error;
        }
        $query->close();
    }

    $query_verificar->close();
    $conexion->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Registro de Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .texto { color: blue; }
    </style>
</head>

<body>
    <div class="container text-center">
        <div class="card text-center p-3 mx-auto my-5 shadow" style="max-width: 400px;">
            <h2 class="mb-4">Registro de Usuarios</h2>

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
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese el nombre" required>
                </div>

                <div class="mb-3">
                    <label for="id_rol" class="form-label">Rol del Usuario</label>
                    <select class="form-select" id="id_rol" name="id_rol" required>
                        <option value="">Seleccione un rol...</option>
                        <option value="1">Administrador</option>
                        <option value="2">Mesero</option>
                        <option value="3">Usuario</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Ingrese el correo" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese contraseña" required>
                </div>

                <div>
                    <button type="submit" class="btn btn-primary w-100">Registrar Usuario</button>
                </div>
            </form>

            <hr>
            <p>¿Ya tienes cuenta?</p>
            <a href="login.php" class="btn btn-outline-dark btn-sm">Iniciar Sesión</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
