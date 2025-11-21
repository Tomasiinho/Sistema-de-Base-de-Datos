<?php
require_once "auth.php";
require_role([1]);
session_start();

if (!isset($_SESSION["user_id"])) {
    die("Debe iniciar sesión para acceder.");
}

$conexion = new mysqli("localhost", "root", "", "restaurante");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// =============================
// Validación de parámetros GET
// =============================
if (!isset($_GET["id"]) || !isset($_GET["tipo"])) {
    die("Solicitud inválida.");
}

$id   = intval($_GET["id"]);
$tipo = $_GET["tipo"];

// =============================
// Selección de tabla según tipo
// =============================
switch ($tipo) {

    case "bebida":
        $tabla = "bebidas_licores";
        $id_col = "id_bebidas";
        $nombre_col = "nombre_bebidas";
        break;

    case "ensalada":
        $tabla = "ensaladas";
        $id_col = "id_ensalada";
        $nombre_col = "nombre_ensaladas";
        break;

    case "plato":
        $tabla = "platos_de_fondo";
        $id_col = "id_plato_fondo";
        $nombre_col = "nombre_plato";
        break;

    default:
        die("Tipo de producto no válido.");
}

// =============================
// Obtener el producto actual
// =============================
$stmt = $conexion->prepare("SELECT * FROM $tabla WHERE $id_col = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$p_result = $stmt->get_result();

if ($p_result->num_rows !== 1) {
    die("Producto no encontrado.");
}

$producto = $p_result->fetch_assoc();
$stmt->close();

// =============================
// Procesar actualización
// =============================
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nuevo_nombre      = trim($_POST["nombre"]);
    $nueva_descripcion = trim($_POST["descripcion"]);
    $nuevo_precio      = $_POST["precio"];

    if ($nuevo_nombre === "" || $nuevo_precio === "") {
        $error = "Nombre y precio son obligatorios.";
    } elseif (!is_numeric($nuevo_precio)) {
        $error = "Precio inválido.";
    } else {

        $nuevo_precio = floatval($nuevo_precio);

        $update_sql = "UPDATE $tabla SET $nombre_col = ?, descripcion = ?, precio_unitario = ? WHERE $id_col = ?";
        $update = $conexion->prepare($update_sql);

        if (!$update) {
            die("Error preparando UPDATE: " . $conexion->error);
        }

        $update->bind_param("ssdi", $nuevo_nombre, $nueva_descripcion, $nuevo_precio, $id);

        if ($update->execute()) {
            $exito = "Producto actualizado correctamente.";
        } else {
            $error = "Error al actualizar: " . $update->error;
        }

        $update->close();
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5" style="max-width: 700px;">
    <div class="card p-4 shadow">

        <h3 class="text-center mb-3">Modificar Producto</h3>
        <hr>

        <?php if (isset($error)) : ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <?php if (isset($exito)) : ?>
            <div class="alert alert-success"><?= $exito ?></div>
        <?php endif; ?>

        <form method="POST">

            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control"
                       value="<?= htmlspecialchars($producto[$nombre_col]) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <textarea name="descripcion" class="form-control" rows="3"><?= htmlspecialchars($producto["descripcion"]) ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Precio</label>
                <input type="number" step="0.01" name="precio" class="form-control"
                       value="<?= htmlspecialchars($producto["precio_unitario"]) ?>" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Guardar Cambios</button>
        </form>

        <a href="lista_producto.php" class="btn btn-secondary w-100 mt-3">Volver</a>

    </div>
</div>

</body>
</html>
