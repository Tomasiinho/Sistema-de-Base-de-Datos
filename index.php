<?php
session_start();

// Verificar que el usuario haya iniciado sesión
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

// Recuperar datos del usuario
$nombre_usuario = $_SESSION["user_name"];
$rol = $_SESSION["user_rol"]; // 1 = admin, 2 = mesero (por ejemplo)
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Principal - Restaurante</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">🍽️ Restaurante UPLA</a>
            <div class="d-flex">
                <span class="navbar-text text-white me-3">
                    Bienvenido, <?php echo htmlspecialchars($nombre_usuario); ?>
                </span>
                <a href="logout.php" class="btn btn-outline-light btn-sm">Cerrar sesión</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2 class="text-center mb-4">Panel Principal</h2>

        <!-- Opciones del menú -->
        <div class="row">
            <?php if ($rol == 1): // ADMIN ?>
                <div class="col-md-3 mb-3">
                    <div class="card h-100 text-center">
                        <div class="card-body">
                            <h5 class="card-title">Usuarios</h5>
                            <p class="card-text">Gestionar usuarios y roles del sistema.</p>
                            <a href="usuarios.php" class="btn btn-primary">Ir</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="col-md-3 mb-3">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <h5 class="card-title">Platos de Fondo</h5>
                        <p class="card-text">Agregar o editar platos disponibles.</p>
                        <a href="platos.php" class="btn btn-primary">Ir</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <h5 class="card-title">Bebidas y Licores</h5>
                        <p class="card-text">Gestionar las bebidas del menú.</p>
                        <a href="bebidas.php" class="btn btn-primary">Ir</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <h5 class="card-title">Pedidos</h5>
                        <p class="card-text">Registrar pedidos de los clientes.</p>
                        <a href="pedidos.php" class="btn btn-success">Ir</a>
                    </div>
                </div>
            </div>

            <?php if ($rol == 1): ?>
            <div class="col-md-3 mb-3">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <h5 class="card-title">Reportes</h5>
                        <p class="card-text">Ver reportes de ventas y pedidos.</p>
                        <a href="reporte_pedidos.php" class="btn btn-secondary">Ir</a>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <footer class="text-center mt-5 text-muted">
        <hr>
        <p>Sistema de Restaurante - Universidad de Playa Ancha © 2025</p>
    </footer>
</body>
</html>
