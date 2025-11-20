<?php
session_start();

// Protección
if (!isset($_SESSION["user_id"])) {
    die("Debe iniciar sesión para acceder.");
}

$conexion = new mysqli("localhost", "root", "", "restaurante");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $categoria   = $_POST["categoria"] ?? '';
    $nombre      = trim($_POST["nombre"] ?? '');
    $descripcion = trim($_POST["descripcion"] ?? '');
    $precio      = $_POST["precio"] ?? '';

    if (empty($categoria) || empty($nombre) || $precio === '' ) {
        $error = "Los campos categoría, nombre y precio son obligatorios.";
    } else {
        if (!is_numeric($precio)) {
            $error = "El precio debe ser un número válido.";
        } else {
            $precio = (float) $precio;

            // Elegir tabla y columnas según categoría (coincidiendo con tu .sql)
            switch ($categoria) {
                case "platos":
                    $tabla = "platos_de_fondo";
                    $col_nombre = "nombre_plato";
                    break;

                case "ensaladas":
                    $tabla = "ensaladas";
                    $col_nombre = "nombre_ensaladas";
                    break;

                case "bebidas":
                    $tabla = "bebidas_licores";
                    $col_nombre = "nombre_bebidas";
                    break;

                default:
                    $tabla = '';
            }

            if ($tabla === '') {
                $error = "Categoría inválida.";
            } else {
                // Preparar INSERT usando los nombres reales de columnas
                // INSERT INTO <tabla> (<col_nombre>, descripcion, precio_unitario) VALUES (?, ?, ?)
                $sql = "INSERT INTO `$tabla` (`$col_nombre`, `descripcion`, `precio_unitario`) VALUES (?, ?, ?)";
                $stmt = $conexion->prepare($sql);

                if (!$stmt) {
                    $error = "Error al preparar la consulta: " . $conexion->error;
                } else {
                    // bind: s = string (nombre), s = string (descripcion), d = double (precio)
                    $stmt->bind_param("ssd", $nombre, $descripcion, $precio);

                    if ($stmt->execute()) {
                        $exito = "Producto agregado correctamente.";
                        $nombre = $descripcion = $precio = '';
                    } else {
                        $error = "Error al guardar: " . $stmt->error;
                    }
                    $stmt->close();
                }
            }
        }
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
<div class="container mt-5" style="max-width: 700px;">
    <div class="card p-4 shadow">
        <h3 class="text-center">Agregar Producto</h3>
        <hr>

        <?php if (isset($error)) : ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if (isset($exito)) : ?>
            <div class="alert alert-success"><?= htmlspecialchars($exito) ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Categoría</label>
                <select name="categoria" class="form-select" required>
                    <option value="">Seleccione...</option>
                    <option value="platos" <?= (isset($categoria) && $categoria=='platos') ? 'selected' : '' ?>>Plato de Fondo</option>
                    <option value="ensaladas" <?= (isset($categoria) && $categoria=='ensaladas') ? 'selected' : '' ?>>Ensalada</option>
                    <option value="bebidas" <?= (isset($categoria) && $categoria=='bebidas') ? 'selected' : '' ?>>Bebida o Licor</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Nombre del producto</label>
                <input type="text" name="nombre" class="form-control" value="<?= isset($nombre) ? htmlspecialchars($nombre) : '' ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <textarea name="descripcion" class="form-control" rows="3"><?= isset($descripcion) ? htmlspecialchars($descripcion) : '' ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Precio</label>
                <input type="number" step="0.01" name="precio" class="form-control" value="<?= isset($precio) ? htmlspecialchars($precio) : '' ?>" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Guardar Producto</button>
        </form>

        <hr>
        <a href="carta.php" class="btn btn-secondary w-100 mt-2">Volver</a>

    </div>
</div>
</body>
</html>
