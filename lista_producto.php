<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    die("Debe iniciar sesión.");
}

$conexion = new mysqli("localhost", "root", "", "restaurante");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Determinar qué lista mostrar
$seccion = $_GET['ver'] ?? '';

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listas de Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<div class="container mt-4">

    <h2 class="text-center mb-4">Listas Disponibles</h2>

    <!-- BOTONES -->
    <div class="text-center mb-4">
        <a href="lista_productos.php?ver=platos" class="btn btn-primary me-2">Platos de Fondo</a>
        <a href="lista_productos.php?ver=ensaladas" class="btn btn-success me-2">Ensaladas</a>
        <a href="lista_productos.php?ver=bebidas" class="btn btn-info">Bebidas y Licores</a>
    </div>

    <hr>

    <?php if ($seccion === "platos"): ?>

        <!-- CARD PLATOS -->
        <div class="card shadow p-3">
            <h3 class="card-title text-center mb-3">Lista de Platos de Fondo</h3>

            <?php
            $sql = $conexion->query("SELECT * FROM platos_de_fondo");

            while ($fila = $sql->fetch_assoc()) {
                echo "<div class='card mb-3 p-3'>";
                echo "<h5><b>Nombre:</b> " . $fila['nombre_plato'] . "</h5>";
                echo "<h5><b>Descripción:</b> " . $fila['descripcion'] . "</h5>";
                echo "<h5><b>Precio:</b> $" . $fila['precio_unitario'] . "</h5>";
                echo "</div>";
            }
            ?>
        </div>

    <?php elseif ($seccion === "ensaladas"): ?>

        <!-- CARD ENSALADAS -->
        <div class="card shadow p-3">
            <h3 class="card-title text-center mb-3">Lista de Ensaladas</h3>

            <?php
            $sql = $conexion->query("SELECT * FROM ensaladas");

            while ($fila = $sql->fetch_assoc()) {
                echo "<div class='card mb-3 p-3'>";
                echo "<h5><b>Nombre:</b> " . $fila['nombre_ensaladas'] . "</h5>";
                echo "<h5><b>Descripción:</b> " . $fila['descripcion'] . "</h5>";
                echo "<h5><b>Precio:</b> $" . $fila['precio_unitario'] . "</h5>";
                echo "</div>";
            }
            ?>
        </div>

    <?php elseif ($seccion === "bebidas"): ?>

        <!-- CARD BEBIDAS -->
        <div class="card shadow p-3">
            <h3 class="card-title text-center mb-3">Lista de Bebidas y Licores</h3>

            <?php
            $sql = $conexion->query("SELECT * FROM bebidas_licores");

            while ($fila = $sql->fetch_assoc()) {
                echo "<div class='card mb-3 p-3'>";
                echo "<h5><b>Nombre:</b> " . $fila['nombre_bebidas'] . "</h5>";
                echo "<h5><b>Descripción:</b> " . $fila['descripcion'] . "</h5>";
                echo "<h5><b>Precio:</b> $" . $fila['precio_unitario'] . "</h5>";
                echo "</div>";
            }
            ?>
        </div>

    <?php else: ?>

        <!-- MENSAJE INICIAL -->
        <div class="alert alert-info text-center">
            Selecciona una lista para mostrarla.
        </div>

    <?php endif; ?>

</div>
</body>
</html>
