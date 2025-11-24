<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Inicio</title>

    <style>
        .logo-italia {
            width: 180px;
            display: block;
            margin: 20px auto;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container text-center mt-4">
        <h1 class="mb-4">Sistema de Gestión – Restaurante de Comida Italiana</h1>

    <!-- Imagen del MER -->
    <h3>Modelo Entidad Relación</h3>
    <img src="Restaurante_ITL Modelo de Datos.png" alt="Modelo ER del restaurante" class="mer-img">
    <!-- REEMPLAZA la ruta de arriba con la ruta REAL del archivo -->

    <!-- Texto de presentación -->
    <div class="presentacion">
        <p>
            Este proyecto corresponde al desarrollo completo de un sistema de gestión para un 
            <strong>Restaurante de Comida Italiana</strong>, construido utilizando PHP, MySQL y Bootstrap.
            El sistema permite manejar usuarios, roles, productos, pedidos, mesas y reportes.
        </p>

        <p>
            A partir del modelo de datos diseñado (mostrado arriba), se desarrolló el sistema paso a paso:
            gestión de usuarios, roles, perfil personal, manejo de productos (platos, ensaladas y bebidas), 
            creación y administración de pedidos, vistas separadas por tipo de trabajador 
            (administrador, cajero y mesero), y finalmente herramientas internas como 
            un <strong>cruce dinámico de tablas</strong> con filtros personalizados.
        </p>

        <p>
            El sistema fue construido asegurando autenticación por roles, navegación segura y una interfaz 
            amigable que permite tanto el uso administrativo como operativo dentro del restaurante.
        </p>
    </div>

    <hr>

    <div class="container mt-5 text-center">
        
        <h1 class="mb-3">🍝 Restaurante de Comida Italiana</h1>
        <p class="text-muted mb-4">Bienvenido a nuestra plataforma de gestión</p>

        <!-- Logo opcional (puedes cambiar la imagen) -->
        <img src="https://cdn-icons-png.flaticon.com/512/3075/3075977.png" class="logo-italia" alt="Logo">

        <div class="card shadow p-4 mt-4" style="max-width: 450px; margin: auto;">
            <h3>Acceder al Sistema</h3>

            <p class="mt-3">¿Tienes cuenta?</p>
            <a href="login.php" class="btn btn-primary w-100 mb-3">Iniciar Sesión</a>

            <p>¿No tienes cuenta?</p>
            <a href="registro.php" class="btn btn-secondary w-100">Registrarse</a>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
