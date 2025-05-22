<?php
include "conexionbd.php";
session_start();
unset($_SESSION['carrito']);

$sql = "SELECT juego_id, cantidad FROM carrito WHERE usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['usuario_id']);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $updateStockSql = "UPDATE juegos SET stock = stock + ? WHERE id = ?";
    $updateStmt = $conn->prepare($updateStockSql);
    $updateStmt->bind_param("ii", $row['cantidad'], $row['juego_id']);
    $updateStmt->execute();
    $updateStmt->close();
}

$stmt->close();

$sql = "DELETE FROM carrito WHERE usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['usuario_id']);
$stmt->execute();
$stmt->close();

if (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'admin') {
    header("Location: carritoAdmin.php");
    exit();
} else {
    header("Location: carrito.php");
    exit();
}
