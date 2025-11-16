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
                    <label for="nombre" class="form-label">Quieres acceder a los platos de fondo</label>
                    <br>
                    <a href="platos_fondo.php">
                        <button type="submit" class="btn btn-primary" style="text-aling: center; text-decoration: none;">Platos de Fondo</button>
                    </a>
                </div>
                <hr>
                <div class="mb-3">
                    <label for="nombre" class="form-label">Quieres acceder a las ensaladas</label>
                    <br>
                    <a href="ensaladas.php">
                        <button type="submit" class="btn btn-primary" style="text-aling: center; text-decoration: none;">Ensaladas</button>
                    </a>
                </div>
                <hr>
                <div class="mb-3">
                    <label for="nombre" class="form-label">Quieres acceder a las bebidas y licores</label>
                    <br>
                    <a href="bebidas_licores.php">
                        <button type="submit" class="btn btn-primary" style="text-aling: center; text-decoration: none;">Bebidas y Licores</button>
                    </a>
                </div>             

            <hr>

        <div>
            <a href="logout.php">
                <button type="submit" class="btn btn-primary" style="text-aling: center; text-decoration: none;">Cerrar sesion</button>
            </a>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html> 