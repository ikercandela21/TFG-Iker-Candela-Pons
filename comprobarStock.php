<?php
include "conexionbd.php";
session_start();

//Recoger los datos del producto
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $producto = [
        "id" => $_POST["id"],
        "nombre" => $_POST["nombre"],
        "descripcion" => $_POST["descripcion"],
        "stock" => $_POST["stock"],
        "imagen" => isset($_POST["imagen"]) ? $_POST["imagen"] : '',
        "precio" => $_POST["precio"],
        "cantidad" => $cantidad = 0,
    ];
}

$sql = "SELECT * FROM juegos where id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $producto['id']);
$stmt->execute();
$result = $stmt->get_result();
if (isset($_SESSION['producto']['cantidad'])) {
    $cantidad = $_SESSION['producto']['cantidad'];
} else {
    $cantidad = 0;
}
$_SESSION['producto']['cantidad'] = $cantidad;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($row['stock'] <= 0) {
        echo "<p>No hay stock disponible para este juego.</p>";
        header("Location:principal.php");
        exit();
    } else {
        $producto['stock'] = $row['stock'] - 1;
        $_SESSION['producto'] = $producto;

        $actualizar = "UPDATE juegos SET stock = ? WHERE id = ?";
        $stmt = $conn->prepare($actualizar);
        $stmt->bind_param("ii", $producto['stock'], $producto['id']);
        $stmt->execute();
        $stmt->close();

        header("Location:añadirCarrito.php?id=" . $producto['id']);
        exit();
    }
} else {
    echo "<p>No se encontró el juego.</p>";
    header("Location:principal.php");
    exit();
}
