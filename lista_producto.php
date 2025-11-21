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

// Consultas
$bebidas = $conexion->query("SELECT * FROM bebidas_licores");
$ensaladas = $conexion->query("SELECT * FROM ensaladas");
$platos = $conexion->query("SELECT * FROM platos_de_fondo");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listas de Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<div class="container mt-5" style="max-width: 1000px;">
    <div class="card p-4 shadow">

        <h2 class="text-center mb-4">Listas de Productos</h2>

        <!-- Botones -->
        <div class="d-flex justify-content-center mb-4 gap-3">
            <button class="btn btn-primary" onclick="mostrar('bebidas')">Bebidas y Licores</button>
            <button class="btn btn-success" onclick="mostrar('ensaladas')">Ensaladas</button>
            <button class="btn btn-warning" onclick="mostrar('platos')">Platos de Fondo</button>
        </div>

        <hr>

        <!-- ===========================
             LISTA DE BEBIDAS Y LICORES
        ============================ -->
        <div id="bebidas" class="seccion" style="display:none;">
            <h4>Bebidas y Licores</h4>

            <table class="table table-bordered table-hover mt-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                <?php while ($b = $bebidas->fetch_assoc()) : ?>
                    <tr>
                        <td><?= $b["id_bebidas"] ?></td>
                        <td><?= $b["nombre_bebidas"] ?></td>
                        <td><?= $b["descripcion"] ?></td>
                        <td>$<?= number_format($b["precio_unitario"], 0, ",", ".") ?></td>

                        <!-- Botón Eliminar -->
                        <td>
                            <a class="btn btn-danger btn-sm"
                               href="eliminar_producto.php?id=<?= $b['id_bebidas'] ?>&tipo=bebida"
                               onclick="return confirm('¿Eliminar esta bebida?');">
                                Eliminar
                            </a>
                            <a class="btn btn-danger btn-sm"
                               href="modificar_producto.php?id=<?= $b['id_bebidas'] ?>&tipo=bebida"
                               onclick="return confirm('¿Modificar esta bebida?');">
                                Modificar
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- ===========================
                 LISTA DE ENSALADAS
        ============================ -->
        <div id="ensaladas" class="seccion" style="display:none;">
            <h4>Ensaladas</h4>

            <table class="table table-bordered table-hover mt-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                <?php while ($e = $ensaladas->fetch_assoc()) : ?>
                    <tr>
                        <td><?= $e["id_ensalada"] ?></td>
                        <td><?= $e["nombre_ensaladas"] ?></td>
                        <td><?= $e["descripcion"] ?></td>
                        <td>$<?= number_format($e["precio_unitario"], 0, ",", ".") ?></td>

                        <!-- Botón Eliminar -->
                        <td>
                            <a class="btn btn-danger btn-sm"
                               href="eliminar_producto.php?id=<?= $e['id_ensalada'] ?>&tipo=ensalada"
                               onclick="return confirm('¿Eliminar esta ensalada?');">
                                Eliminar
                            </a>
                            <a class="btn btn-danger btn-sm"
                               href="modificar_producto.php?id=<?= $e['id_ensalada'] ?>&tipo=ensalada"
                               onclick="return confirm('¿Modificar esta ensalada?');">
                                Modificar
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- ===========================
                LISTA DE PLATOS DE FONDO
        ============================ -->
        <div id="platos" class="seccion" style="display:none;">
            <h4>Platos de Fondo</h4>

            <table class="table table-bordered table-hover mt-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                <?php while ($p = $platos->fetch_assoc()) : ?>
                    <tr>
                        <td><?= $p["id_plato_fondo"] ?></td>
                        <td><?= $p["nombre_plato"] ?></td>
                        <td><?= $p["descripcion"] ?></td>
                        <td>$<?= number_format($p["precio_unitario"], 0, ",", ".") ?></td>

                        <!-- Botón Eliminar -->
                        <td>
                            <a class="btn btn-danger btn-sm"
                               href="eliminar_producto.php?id=<?= $p['id_plato_fondo'] ?>&tipo=plato"
                               onclick="return confirm('¿Eliminar este plato?');">
                                Eliminar
                            </a>
                            <a class="btn btn-danger btn-sm"
                               href="modificar_producto.php?id=<?= $p['id_plato_fondo'] ?>&tipo=plato"
                               onclick="return confirm('¿Modificar este plato?');">
                                Modificar
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<script>
// Mostrar y ocultar listas
function mostrar(seccion) {
    document.querySelectorAll(".seccion").forEach(div => div.style.display = "none");
    document.getElementById(seccion).style.display = "block";
}
</script>

</body>
</html>
