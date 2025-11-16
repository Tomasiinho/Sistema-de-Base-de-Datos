<?php

session_start();
if(!isset($_SESSION["user_id"])) {
    die("Debe iniciar sesión para acceder.");
}


if($_SESSION["user_role"] !=1) {
    die("Acceso denegado. No tiene permisos para entrar aquí.");
}

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
    <div class="container text-center">
        <div class="card text-center p-3 mx-auto my-5 shadow" style="max-width: 1000px;">
            <h2 class="mb-4">Opciones del Administrador</h2>
            <hr>
                <div class="mb-3">
                    <label for="nombre" class="form-label">Cuantas listas son las que quieres ver en un mismo insatnte?</label>
                    <br>
                    <a href="carta.php">
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