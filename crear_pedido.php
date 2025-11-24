<?php
require_once "auth.php";
require_role([3]); // Solo cajero

$conexion = new mysqli("localhost", "root", "", "restaurante");
if ($conexion->connect_error) {
    die("Error al conectar: " . $conexion->connect_error);
}

/* ===============================
   GUARDAR PEDIDO EN LA BD
   =============================== */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $mesa   = $_POST["mesa"];
    $mesero = $_POST["mesero"];
    $total  = $_POST["total"];
    $productos = json_decode($_POST["productos"], true);

    if (empty($productos)) {
        die("No se enviaron productos.");
    }

    // Insertar en pedidos
    $stmt = $conexion->prepare(
        "INSERT INTO pedidos (mesa, mesero, fecha_pedido, total, `forma de pago`)
         VALUES (?, ?, NOW(), ?, 'Efectivo')"
    );

    $stmt->bind_param("iii", $mesa, $mesero, $total);
    $stmt->execute();

    $id_pedido = $stmt->insert_id;
    $stmt->close();

    // Insertar detalle_pedidos
    $stmt = $conexion->prepare(
        "INSERT INTO detalle_pedidos (id_pedido, id_producto, cantidad, subtotal)
         VALUES (?, ?, ?, ?)"
    );

    foreach ($productos as $p) {
        $stmt->bind_param("isis", $id_pedido, $p["id"], $p["cantidad"], $p["subtotal"]);
        $stmt->execute();
    }

    $stmt->close();

    echo "<script>
            alert('Pedido registrado correctamente.');
            window.location='crear_pedido.php';
          </script>";
    exit;
}

/* ===============================
   Obtener datos para mostrar
   =============================== */

// Mesas
$mesas = $conexion->query("SELECT * FROM mesas");

// Meseros
$meseros = $conexion->query("SELECT id_usuarios AS id, nombre_usuario FROM usuarios WHERE id_rol = 2");

// Productos
$bebidas = $conexion->query("SELECT id_bebidas AS id, nombre_bebidas AS nombre, precio_unitario FROM bebidas_licores");
$ensaladas = $conexion->query("SELECT id_ensalada AS id, nombre_ensaladas AS nombre, precio_unitario FROM ensaladas");
$platos = $conexion->query("SELECT id_plato_fondo AS id, nombre_plato AS nombre, precio_unitario FROM platos_de_fondo");

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Pedido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
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
                    <button type="submit" class="btn btn-primary">Cerrar sesión</button>
                </a>
            </div>
        </div>
    </nav>
<div class="container mt-4" style="max-width: 900px;">
    <div class="card p-4 shadow">
        <h3 class="text-center mb-4">Crear Pedido</h3>

        <!-- Mesa -->
        <div class="mb-3">
            <label class="form-label">Mesa</label>
            <select class="form-select" id="mesa">
                <?php while($m = $mesas->fetch_assoc()): ?>
                    <option value="<?= $m['id_mesa'] ?>">
                        Mesa <?= $m['numero_mesa'] ?> (<?= $m['estado'] ?>)
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <!-- Mesero -->
        <div class="mb-3">
            <label class="form-label">Mesero</label>
            <select class="form-select" id="mesero">
                <?php while($ms = $meseros->fetch_assoc()): ?>
                    <option value="<?= $ms['id'] ?>">
                        <?= $ms['nombre_usuario'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <hr>

        <h4 class="mb-3">Seleccionar Productos</h4>

        <!-- Botones -->
        <div class="btn-group mb-3">
            <button class="btn btn-primary" onclick="mostrar('bebidas')">Bebidas</button>
            <button class="btn btn-success" onclick="mostrar('ensaladas')">Ensaladas</button>
            <button class="btn btn-warning" onclick="mostrar('platos')">Platos de Fondo</button>
        </div>

        <!-- Bebidas -->
        <div id="bebidas" class="seccion">
            <h5>Bebidas</h5>
            <div class="row">
                <?php while($b = $bebidas->fetch_assoc()): ?>
                    <div class="col-4 mb-3">
                        <div class="card p-2">
                            <h6><?= $b["nombre"] ?></h6>
                            <p>$<?= $b["precio_unitario"] ?></p>
                            <button class="btn btn-success"
                                onclick="agregarProducto('B<?= $b['id'] ?>','<?= $b['nombre'] ?>',<?= $b['precio_unitario'] ?>)">
                                Agregar
                            </button>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>

        <!-- Ensaladas -->
        <div id="ensaladas" class="seccion" style="display:none;">
            <h5>Ensaladas</h5>
            <div class="row">
                <?php while($e = $ensaladas->fetch_assoc()): ?>
                    <div class="col-4 mb-3">
                        <div class="card p-2">
                            <h6><?= $e["nombre"] ?></h6>
                            <p>$<?= $e["precio_unitario"] ?></p>
                            <button class="btn btn-success"
                                onclick="agregarProducto('E<?= $e['id'] ?>','<?= $e['nombre'] ?>',<?= $e['precio_unitario'] ?>)">
                                Agregar
                            </button>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>

        <!-- Platos -->
        <div id="platos" class="seccion" style="display:none;">
            <h5>Platos de Fondo</h5>
            <div class="row">
                <?php while($p = $platos->fetch_assoc()): ?>
                    <div class="col-4 mb-3">
                        <div class="card p-2">
                            <h6><?= $p["nombre"] ?></h6>
                            <p>$<?= $p["precio_unitario"] ?></p>
                            <button class="btn btn-success"
                                onclick="agregarProducto('P<?= $p['id'] ?>','<?= $p['nombre'] ?>',<?= $p['precio_unitario'] ?>)">
                                Agregar
                            </button>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>

        <hr>

        <h4>Pedido Actual</h4>

        <table class="table" id="tablaPedido">
            <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
                <th></th>
            </tr>
            </thead>
            <tbody></tbody>
        </table>

        <h3 class="text-end">Total: $<span id="total">0</span></h3>

        <!-- FORMULARIO OCULTO PARA ENVIAR -->
        <form method="POST" id="formPedido">
            <input type="hidden" name="mesa" id="inputMesa">
            <input type="hidden" name="mesero" id="inputMesero">
            <input type="hidden" name="total" id="inputTotal">
            <input type="hidden" name="productos" id="inputProductos">
            <button type="submit" href="portal_trabajador.php" class="btn btn-primary w-100 mt-3">Confirmar Pedido</button>
        </form>

    </div>
</div>

<script>
function mostrar(seccion) {
    document.querySelectorAll(".seccion").forEach(s => s.style.display = "none");
    document.getElementById(seccion).style.display = "block";
}

let pedido = [];
let total = 0;

function agregarProducto(id, nombre, precio) {
    let item = pedido.find(p => p.id === id);

    if (item) {
        item.cantidad++;
        item.subtotal = item.cantidad * item.precio;
    } else {
        pedido.push({ id, nombre, precio, cantidad: 1, subtotal: precio });
    }

    renderPedido();
}

function eliminarProducto(id) {
    pedido = pedido.filter(p => p.id !== id);
    renderPedido();
}

function renderPedido() {
    const tbody = document.querySelector("#tablaPedido tbody");
    tbody.innerHTML = "";
    total = 0;

    pedido.forEach(p => {
        total += p.subtotal;

        tbody.innerHTML += `
            <tr>
                <td>${p.nombre}</td>
                <td>${p.cantidad}</td>
                <td>$${p.subtotal}</td>
                <td><button class="btn btn-danger btn-sm" onclick="eliminarProducto('${p.id}')">X</button></td>
            </tr>
        `;
    });

    document.getElementById("total").innerText = total;
}

// Enviar al backend
document.getElementById("formPedido").onsubmit = function () {
    document.getElementById("inputMesa").value = document.getElementById("mesa").value;
    document.getElementById("inputMesero").value = document.getElementById("mesero").value;
    document.getElementById("inputTotal").value = total;
    document.getElementById("inputProductos").value = JSON.stringify(pedido);
};
</script>

</body>
</html>
