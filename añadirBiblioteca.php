<?php
include "conexionbd.php";
session_start();


// Verificar que el usuario haya iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    die("Error: Usuario no autenticado.");
}

$id_usuario = $_SESSION['usuario_id'];

$sql = "SELECT * FROM carrito WHERE usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();


if ($result->num_rows > 0) {

    $fecha = date('Y-m-d H:i:s');

    while ($row = $result->fetch_assoc()) {
        $juego_id = $row['juego_id'];
        $cantidad = $row['cantidad'];

        for ($i = 0; $i < $cantidad; $i++) {
            // Generar un código único para cada juego
            $codigo = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'), 0, 20);

            $sql = "INSERT INTO pedidos (usuario_id, juego_id, cantidad, fecha, codigoJuego) 
                    VALUES (?, ?, 1, ?, ?)";
            $stmt_insert = $conn->prepare($sql);
            $stmt_insert->bind_param("iiss", $id_usuario, $juego_id, $fecha, $codigo);

            if ($stmt_insert->execute()) {
                // Opcional: guardar todos los códigos en sesión si lo necesitas
                $_SESSION['codigos'][] = $codigo;
            } else {
                echo "Error en pedidos para juego ID $juego_id: " . $stmt_insert->error . "<br>";
            }
            $stmt_insert->close();

            // Actualizar el stock en la tabla juegos
            $sql_update_stock = "UPDATE juegos SET stock = stock - 1 WHERE id = ?";
            $stmt_update = $conn->prepare($sql_update_stock);
            $stmt_update->bind_param("i", $juego_id);

            if (!$stmt_update->execute()) {
                echo "Error al actualizar el stock para juego ID $juego_id: " . $stmt_update->error . "<br>";
            }
            $stmt_update->close();
        }
    }

    $result->free();
    $stmt->close();

    include "vaciarCarrito.php";
    echo "Compra realizada con éxito. Los códigos de tus juegos son: <br>";
    foreach ($_SESSION['codigos'] as $codigo) {
        echo "<strong style='font-size: xx-large;'>$codigo</strong><br>";
    }
    header("Location:principal.php");
    exit();
} else {
    echo "El carrito está vacío.";
}
