<?php
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    // Validar datos del formulario
    if (empty($_POST['nombre']) || empty($_POST['descripcion']) || empty($_POST['precio_unitario'])) {
        die("Todos los campos son obligatorios.");
    }

    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);
    $precio_unitario = $_POST['precio_unitario'];

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
    $query_verificar = $conexion->prepare("SELECT nombre FROM ensaladas WHERE nombre = ?");
    $query_verificar->bind_param("s", $nombre);
    $query_verificar->execute();
    $query_verificar->store_result();

    if ($query_verificar->num_rows > 0) {
        $error = "Este plato ya existe en la carta.";
    } else {
        // Insertar nuevo usuario
        $query = $conexion->prepare("INSERT INTO ensaladas (nombre, descripcion, precio_unitario) VALUES (?, ?, ?)");
        if (!$query) {
            die("Error al preparar la consulta: " . $conexion->error);
        }
        $query->bind_param("ssi", $nombre, $descripcion, $precio_unitario);
        
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
    <title>Ingreso de Ensalada</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .texto { color: blue; }
    </style>
</head>

<body>
    <div class="container text-center">
        <div class="card text-center p-3 mx-auto my-5 shadow" style="max-width: 400px;">
            <h2 class="mb-4">Nueva Ensalada</h2>

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
                    <label for="nombre" class="form-label">Nombre de la Ensalada</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese el nombre de la Ensalada" required>
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Ingrese una Descripcion de la Ensalada</label>
                    <input type="descripcion" class="form-control" id="descripcion" name="descripcion" placeholder="Ingrese una descripcion de la Ensalada" required>
                </div>

                <div class="mb-3">
                    <label for="precio_unitario" class="form-label">Precio Unitario de la Ensalada</label>
                    <input type="precio_unitario" class="form-control" id="precio_unitario" name="precio_unitario" placeholder="Ingrese el Precio de la Ensalada" required>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
