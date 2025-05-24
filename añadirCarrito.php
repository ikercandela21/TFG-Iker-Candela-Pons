<?php
include "conexionbd.php";
session_start();

$id = $_GET['id'];
$producto = $_SESSION['producto'];

$sql = "SELECT * FROM carrito WHERE usuario_id = ? AND juego_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $_SESSION["usuario_id"], $producto['id']);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $cantidad = $row['cantidad'] + 1;
    $sql = "UPDATE carrito SET cantidad = ? WHERE usuario_id = ? AND juego_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $cantidad, $_SESSION["usuario_id"], $producto['id']);
    $stmt->execute();
    echo "El producto se ha añadido de 1 al carrito";
    header("Location:principal.php");
    exit();
} else {

    $sql = "INSERT INTO carrito (usuario_id, juego_id, cantidad) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    $producto = $_SESSION["producto"];
    $cantidad = $_SESSION["producto"]['cantidad'] + 1;
    $stmt->bind_param("iii", $_SESSION["usuario_id"], $producto['id'], $cantidad);
    $stmt->execute();
    $result = $stmt->get_result();
    echo "El producto se ha añadido de 0 al carrito";
    header("Location:principal.php");
    exit();
}
