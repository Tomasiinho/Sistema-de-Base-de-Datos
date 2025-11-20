<?php
ini_set('display_errors', 1); // Mostrar errores
ini_set('display_startup_errors', 1); // Mostrar errores de inicio
error_reporting(E_ALL); // Reportar todos los errores

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    // Validar datos del formulario
    if (empty($_POST['email']) || empty($_POST['password'])) {
        die("Todos los campos son obligatorios.");
    }

    $email = $_POST['email'];
    $password = $_POST['password'];
    $id_rol =$_POST['id_rol'];

    if ($password) {
        $contraseña_encriptada = password_hash($password, PASSWORD_BCRYPT);
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

    // Insertar datos
    $query = $conexion->prepare("SELECT id_usuarios as id, nombre_usuario, password, id_rol from usuarios where email = ?");
    if (!$query) {
        die("Error al preparar la consulta: " . $conexion->error);
    }
    $query->bind_param("s", $email);

    $query->execute();

    $result = $query->get_result();

    if ($result->num_rows === 1) {
        $usuario = $result->fetch_assoc();

        if (password_verify($password, $usuario["password"])) {
            session_start();
            $_SESSION["user_id"] = $usuario["id"];
            $_SESSION["user_name"] = $usuario["nombre_usuario"];
            $_SESSION["user_role"] = $usuario["id_rol"];
            $exito = "Sesion Iniciada con exito!";

            // Redirección según el rol del usuario
            if ($usuario["id_rol"] == 1) {
                header("Location: dashboard.php");
                exit();
            }
            elseif ($usuario["id_rol"] == 2) {
                header("Location: inicio.php");
                exit();
            }
            elseif ($usuario["id_rol"] == 3) {
                header("Location: home.php");
                exit();
            }
            else {
                $error = "Rol no válido.";
            }
        } else {
            $error = "Error al iniciar sesión, usuario o contraseña incorrecta";
        }
    }
    else{
        $error = "Error al iniciar sesión, usuario o contraseña incorrecta";
    }


    // Cerrar conexiones
    $query->close();
    $conexion->close();
}


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <title>Login</title>
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
            <h1>Login de usuarios</h1>
            <?php
            if (isset($error)) {
                echo "<div class='alert alert-danger'>" . $error . "</div>";
            }
            if (isset($exito)) {
                echo "<div class='alert alert-success'>" . $exito . "</div>";
            }

            ?>
            <?php

            if (isset($exito)) {
                echo '
                            <p>Ir al inicio</p>
            <a href="index.php" style="color:black; text-decoration: none;"><b>Inicio</b>
            </a>
                ';
            } else {
                echo '
            <form action="login.php" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Ingrese su correo electronico." required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese su contraseña" required>
                </div>
                <button type="submit" class="btn btn-primary">Enviar datos...</button>
            </form>';
            }
            ?>

            <br>
            <p>¿No tienes Cuenta?</p>
            <a href="registro.php" style="color:black; text-decoration: none;"><b>Registrate</b>
            </a>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>