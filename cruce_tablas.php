<?php
session_start();

// Conexión
$conexion = new mysqli("localhost", "root", "", "restaurante");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Listado de tablas
$tablas = [
    "pedidos" => "Pedidos",
    "detalle_pedidos" => "Detalle Pedidos",
    "productos" => "Productos",
    "clientes" => "Clientes",
    "mesas" => "Mesas",
    "meseros" => "Meseros"
];

// Relaciones (JOINs válidos)
$joins = [
    ["pedidos", "detalle_pedidos", "pedidos.id_pedido = detalle_pedidos.id_pedido"],
    ["detalle_pedidos", "productos", "detalle_pedidos.id_producto = productos.id_producto"],
    ["pedidos", "mesas", "pedidos.mesa = mesas.id_mesa"],
    ["pedidos", "meseros", "pedidos.mesero = meseros.id_mesero"],
];

$resultado = null;
$columnas_ocultas = [];


// =======================================================
//   OCULTAR COLUMNAS
// =======================================================
if (isset($_POST["ocultar"])) {

    // Traer query anterior
    if (isset($_SESSION["ultimo_select"])) {

        $columnas_ocultas = $_POST["ocultar"];
        $sql = $_SESSION["ultimo_select"];

        $resultado = $conexion->query($sql);
    }
}


// =======================================================
//   GENERAR CRUCE DE TABLAS
// =======================================================
elseif (isset($_POST["tablas"])) {

    $seleccionadas = $_POST["tablas"];

    if (count($seleccionadas) === 0) {
        die("Debe seleccionar al menos una tabla.");
    }

    // SELECT base
    $sql = "SELECT * FROM " . $seleccionadas[0];

    // Unir con las otras tablas seleccionadas mediante joins válidos
    foreach ($joins as $rel) {
        list($t1, $t2, $cond) = $rel;

        if (in_array($t1, $seleccionadas) && in_array($t2, $seleccionadas)) {
            $sql .= " INNER JOIN $t2 ON $cond";
        }
    }

    // Guardar en sesión para el filtro luego
    $_SESSION["ultimo_select"] = $sql;

    // Ejecutar
    $resultado = $conexion->query($sql);
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cruce de Tablas Dinámico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="portal_trabajador.php">Inicio</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="perfil_usuario.php">Mi Perfil</a>
                    </li>
                </ul>
                <a href="logout.php">
                    <button type="submit" class="btn btn-primary">Cerrar sesion</button>
                </a>
            </div>
        </div>
    </nav>

<div class="container mt-5">
    <div class="card p-4 shadow">
        <h2 class="text-center">Cruce de Tablas Manual</h2>

        <!-- Selección de tablas -->
        <form method="POST">
            <h4>Seleccione las tablas que desea cruzar</h4>

            <?php foreach ($tablas as $key => $nombre): ?>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="tablas[]" value="<?= $key ?>">
                    <label class="form-check-label"><?= $nombre ?></label>
                </div>
            <?php endforeach; ?>

            <button class="btn btn-primary mt-3 w-100" type="submit">Generar Cruce</button>
        </form>

        <hr>

        <?php if ($resultado && $resultado->num_rows > 0): ?>

            <!-- Ocultar columnas -->
            <h4 class="text-center mt-3">Columnas disponibles (marque para ocultar)</h4>

            <form method="POST">
                <div class="row">
                    <?php foreach ($resultado->fetch_fields() as $campo): ?>
                        <div class="col-4">
                            <div class="form-check">
                                <input type="checkbox"
                                       class="form-check-input"
                                       name="ocultar[]"
                                       value="<?= $campo->name ?>"
                                       <?= in_array($campo->name, $columnas_ocultas) ? "checked" : "" ?>>
                                <label class="form-check-label"><?= $campo->name ?></label>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <button class="btn btn-warning w-100 mt-3" type="submit">Aplicar filtro</button>
            </form>

            <hr>

            <!-- Resultado -->
            <h4 class="text-center">Resultado del Cruce</h4>

            <div class="table-responsive">
                <table class="table table-bordered table-hover mt-3">
                    <thead class="table-dark">
                    <tr>
                        <?php foreach ($resultado->fetch_fields() as $campo): ?>
                            <?php if (!in_array($campo->name, $columnas_ocultas)): ?>
                                <th><?= $campo->name ?></th>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tr>
                    </thead>

                    <tbody>
                    <?php while ($fila = $resultado->fetch_assoc()): ?>
                        <tr>
                            <?php foreach ($fila as $col => $dato): ?>
                                <?php if (!in_array($col, $columnas_ocultas)): ?>
                                    <td><?= $dato ?></td>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

        <?php elseif (isset($_POST["tablas"])): ?>
            <div class="alert alert-danger text-center mt-3">
                No hay datos al cruzar las tablas seleccionadas.
            </div>
        <?php endif; ?>

    </div>
</div>

</body>
</html>
