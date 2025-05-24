<?php

include "conexionbd.php";
session_start();
if ($_SESSION["tipo"] !== "admin") {
    echo "<p>No tienes permiso para acceder a esta página.</p>";
    exit();
}

$id = $_GET['id'];

$sql = "SELECT * FROM carrito WHERE juego_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Actualizar el stock del producto
    $sql = "SELECT cantidad FROM carrito WHERE juego_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $cantidad = $row['cantidad'];
    $sql = "UPDATE juegos SET stock = stock + ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $cantidad, $id);
    $stmt->execute();
    
    // Eliminar el producto del carrito
    $sql = "DELETE FROM carrito WHERE juego_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    echo "Producto eliminado del carrito.";
    header("Location: carrito.php");
    exit();
} else {
    echo "Producto no encontrado en el carrito.";
}