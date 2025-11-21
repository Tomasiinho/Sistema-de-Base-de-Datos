<?php
require_once "auth.php";
require_role([1]);
session_start();

// Verifica que el usuario esté logueado
if (!isset($_SESSION["user_id"])) {
    die("Debe iniciar sesión para acceder.");
}

// Verifica parámetros enviados
if (!isset($_GET["id"]) || !isset($_GET["tipo"])) {
    die("Solicitud inválida.");
}

$id = intval($_GET["id"]);
$tipo = $_GET["tipo"];

$conexion = new mysqli("localhost", "root", "", "restaurante");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Selección de tabla según categoría
switch ($tipo) {
    case "bebida":
        $tabla = "bebidas_licores";
        $campo_id = "id_bebidas";
        break;

    case "ensalada":
        $tabla = "ensaladas";
        $campo_id = "id_ensalada";
        break;

    case "plato":
        $tabla = "platos_de_fondo";
        $campo_id = "id_plato_fondo";
        break;

    default:
        die("Tipo de producto inválido.");
}

// Ejecutar DELETE
$sql = "DELETE FROM $tabla WHERE $campo_id = ?";
$stmt = $conexion->prepare($sql);

if (!$stmt) {
    die("Error al preparar la consulta: " . $conexion->error);
}

$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "<script>alert('Producto eliminado correctamente'); window.location.href='listar_productos.php';</script>";
} else {
    echo "Error al eliminar: " . $stmt->error;
}

$stmt->close();
$conexion->close();
?>
