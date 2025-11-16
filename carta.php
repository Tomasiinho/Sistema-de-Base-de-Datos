<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container text-center">
        <div class="card text-center p-3 mx-auto my-5 shadow" style="max-width: 1000px;">
            <h2 class="mb-4">Opciones de la Carta</h2>
            <hr>
            <div class="mb-3">
                <label for="nombre" class="form-label">Seccion de Platos de Fondo</label>
                <br>
                <button type="button" class="btn btn-primary me-4" onclick="window.location.href='platos_fondo.php'">Lista de Platos de Fondo</button>
                <button type="button" class="btn btn-primary" onclick="window.location.href='agregar_producto.php'">Agregar Plato de Fondo</button>
            </div>
            <hr>
            <div class="mb-3">
                <label for="nombre" class="form-label">Seccion de Ensaladas</label>
                <br>
                <button type="button" class="btn btn-primary me-4" onclick="window.location.href='ensaladas.php'">Lista de Ensaladas</button>
                <button type="button" class="btn btn-primary" onclick="window.location.href='agregar_producto.php'">Agregar Ensalada</button>
            </div>
            <hr>
            <div class="mb-3">
                <label for="nombre" class="form-label">Seccion de Bebidas y Licores</label>
                <br>
                <button type="button" class="btn btn-primary me-4" onclick="window.location.href='bebidas_licores.php'">Lista de Bebidas y Licores</button>
                <button type="button" class="btn btn-primary" onclick="window.location.href='agregar_producto.php'">Agregar Bebida y Licor</button>
            </div>
            <hr>
            <div>
                <button type="button" class="btn btn-primary" onclick="window.location.href='logout.php'">Cerrar sesion</button>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
