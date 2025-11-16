<?php
session_start();

// Protección (opcional)
if (!isset($_SESSION["user_id"])) {
    die("Debe iniciar sesión para acceder.");
}

$conexion = new mysqli("localhost", "root", "", "restaurante");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $categoria = $_POST["categoria"];
    $nombre = $_POST["nombre"];
    $precio = $_POST["precio"];

    if (empty($categoria) || empty($nombre) || empty($precio)) {
        $error = "Todos los campos son obligatorios.";
    } else {
        // Elegir la tabla según categoría
        switch ($categoria) {
            case "platos":
                $tabla = "platos_fondo";
                break;

            case "ensaladas":
                $tabla = "ensaladas";
                break;

            case "bebidas":
                $tabla = "bebidas_licores";
                break;

            default:
                die("Categoría inválida.");
        }

        // Insertar datos
        $stmt = $conexion->prepare("INSERT INTO $tabla (nombre, precio) VALUES (?, ?)");
        $stmt->bind_param("sd", $nombre, $precio);

        if ($stmt->execute()) {
            $exito = "Producto agregado correctamente.";
        } else {
            $error = "Error al guardar: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<div class="container mt-5" style="max-width: 600px;">
    <div class="card p-4 shadow">
        <h3 class="text-center">Agregar Producto</h3>
        <hr>

        <?php if (isset($error)) { ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php } ?>

        <?php if (isset($exito)) { ?>
            <div class="alert alert-success"><?= $exito ?></div>
        <?php } ?>

        <form method="POST">

            <div class="mb-3">
                <label class="form-label">Categoría</label>
                <select name="categoria" class="form-select" required>
                    <option value="">Seleccione...</option>
                    <option value="platos">Plato de Fondo</option>
                    <option value="ensaladas">Ensalada</option>
                    <option value="bebidas">Bebida o Licor</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Nombre del producto</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Precio</label>
                <input type="number" step="0.01" name="precio" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Guardar Producto</button>
        </form>

        <hr>
        <a href="carta.php" class="btn btn-secondary w-100 mt-2">Volver</a>

    </div>
</div>
</body>
</html>
