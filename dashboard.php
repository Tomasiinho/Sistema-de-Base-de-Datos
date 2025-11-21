<?php
require_once "auth.php";
require_role([1]);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
                <div class="container-fluid">
                    <a class="navbar-brand" href="dashboard.php">Inicio</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="perfil_usuario.php">Perfil del Usuario</a>
                            </li>
                        </ul>
                        <a href="logout.php">
                            <button type="submit" class="btn btn-primary">Cerrar sesion</button>
                        </a>
                    </div>
                </div>
    </nav>
    <div class="container text-center">
        <div class="card text-center p-3 mx-auto my-5 shadow" style="max-width: 1000px;">
            
            <h2 class="mb-4">Opciones del Administrador</h2>
            <hr>
                <div class="mb-3">
                    <label for="nombre" class="form-label">¿Deseas ver más de una lista?</label>
                    <br>
                    <a href="mas_listas.php">
                        <button type="submit" class="btn btn-primary" style="text-aling: center; text-decoration: none;">Carta</button>
                    </a>
                </div>
                <hr>
                <div class="mb-3">
                    <label for="nombre" class="form-label">Selecciona este boton para dirigirte a la carta</label>
                    <br>
                    <a href="carta.php">
                        <button type="submit" class="btn btn-primary" style="text-aling: center; text-decoration: none;">Carta</button>
                    </a>
                </div>
                <hr>
                <div class="mb-3">
                    <label for="nombre" class="form-label">Selecciona este boton para dirigirte a los meseros disponibles</label>
                    <br>
                    <a href="meseros.php">
                        <button type="submit" class="btn btn-primary" style="text-aling: center; text-decoration: none;">Meseros</button>
                    </a>
                </div>
                <hr>
                <div class="mb-3">
                    <label for="nombre" class="form-label">Selecciona este boton para dirigirte a los mesas disponibles</label>
                    <br>
                    <a href="mesas.php">
                        <button type="submit" class="btn btn-primary" style="text-aling: center; text-decoration: none;">Mesas</button>
                    </a>
                </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html> 