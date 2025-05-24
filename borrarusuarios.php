<?php

include "conexionbd.php";
if ($_SESSION["tipo"] !== "admin") {
    echo "<p>No tienes permiso para acceder a esta página.</p>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = $_GET["id"];
    $borrar = "DELETE FROM pedidos WHERE usuario_id=$id"; //si no quiero borrar el pedido del usuario , comentar esta linea
    $sql = "DELETE FROM usuarios WHERE id = $id";
    $borrado = mysqli_query($conn, $borrar);
    if ($borrado) {//si no quiero borrar el pedido del usuario , comentar esta linea
        echo "Pedidos con id: $id eliminado";
    }
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo "Usuario con id: $id eliminado";
        header("Location:clientes.php");
        exit();
    } else {
        echo "el usuaruio no se ha podido borrar";
        header("Location:clientes.php");
        exit();
    }
}
