<?php


if ($_SERVER['REQUEST_METHOD'] === "POST") {
    // Validar datos del formulario
    if (empty($_POST['nombre']) || empty($_POST['id_rol']) || empty($_POST['email']) || empty($_POST['password'])) {
        die("Todos los campos son obligatorios.");
    }

    $nombre = $_POST['nombre'];
    $id_rol = $_POST['id_rol'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($password)) {
        $contraseña_encriptada = password_hash($password, PASSWORD_BCRYPT);
    } else {
        die("La contraseña no puede estar vacía.");
    }

    $db_host = "localhost";
    $db_name = "restaurante";
    $db_user = "root";
    $db_pass = "";

    // Conexión BD
    $conexion = new mysqli($db_host, $db_user, $db_pass, $db_name);
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Verificar si el email ya existe
    $query_verificar = $conexion->prepare("SELECT email FROM usuarios WHERE email = ?");
    $query_verificar->bind_param("s", $email);
    $query_verificar->execute();
    $query_verificar->store_result();

    if ($query_verificar->num_rows > 0) {
        $error = "El correo electrónico ya está registrado.";
    } else {
        // Insertar datos
        $query = $conexion->prepare("INSERT INTO usuarios(nombre_usuario, nombre_completo, email, password) VALUES (?, ?, ?, ?)");
        if (!$query) {
            die("Error al preparar la consulta: " . $conexion->error);
        }
        $query->bind_param("ssss", $nombre_usuario, $nombre_completo, $email, $contraseña_encriptada);
        if (!$query->execute()) {
            $error = "Error al ejecutar la consulta: " . $query->error;
        } else {
            $exito = "datos guardados con exito";
        }
        $query->close();
    }



    // Cerrar conexiones
    $conexion->close();
}


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <title>Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .texto {
            color: Blue;
        }
    </style>
</head>

<body>
    <div class="container text-center">

        <div class="card text-center p-2 mx-auto my-5" style="max-width: 400px;">

            <h1>Formulario de Registro de usuarios</h1>
            <?php
            if (isset($error)) {
                echo "<div class='alert alert-danger'>" . $error . "</div>";
            }
            if (isset($exito)) {
                echo "<div class='alert alert-success'>" . $exito . "</div>";
            }

            ?>
            <form action="registro.php" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombres</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese el nombre completo" required>
                </div>
                <div class="mb-3">
                    <label for="id_rol" class="form-label">Rol del Usuario</label>
                    <input type="text" class="form-control" id="id_rol" name="id_rol" placeholder="Ingrese el rol" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Ingrese los email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese contraseña" required>
                </div>
                <div>
                    <button href="login.php" type="submit" class="btn btn-primary">Enviar datos...</button>
                </div>
            </form>
            <br>
            <p>¿Tienes Cuenta?</p>
            <a href="login.php" style="color:black; text-decoration: none;"><b>Inicia Sesión</b>
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>