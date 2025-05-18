<?php
include "conexionbd.php";

$sqlCreacionTablaUsuarios = "CREATE TABLE IF NOT EXISTS usuarios(
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(50) NOT NULL,
        usuario VARCHAR(50) NOT NULL,
        email VARCHAR(50) NOT NULL,
        contraseña VARCHAR(50) NOT NULL,
        tipo VARCHAR(50) NOT NULL
    )";
$sqlCreacionTablaJuegos = "CREATE TABLE IF NOT EXISTS juegos(
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(50) NOT NULL,
        descripcion TEXT NOT NULL,
        stock INT NOT NULL,
        imagen VARCHAR(50) NOT NULL,
        precio FLOAT NOT NULL
    )";
$sqlCreacionTablaPedidos = "CREATE TABLE IF NOT EXISTS pedidos(
        id INT AUTO_INCREMENT PRIMARY KEY,
        usuario_id INT NOT NULL,
        juego_id INT NOT NULL,
        cantidad INT NOT NULL,
        fecha DATE NOT NULL,
        codigoJuego VARCHAR (20) NOT NULL,
        FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
        FOREIGN KEY (juego_id) REFERENCES juegos(id)
    )";
    $sqlCreacionTablaCarrito = "CREATE TABLE IF NOT EXISTS carrito(
        id INT AUTO_INCREMENT PRIMARY KEY,
        usuario_id INT NOT NULL,
        juego_id INT NOT NULL,
        cantidad INT NOT NULL,
        FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
        FOREIGN KEY (juego_id) REFERENCES juegos(id)
        )";


if ($conexion->query($sqlCreacionTablaUsuarios) === TRUE) {
    echo "Tabla 'usuarios' creada correctamente.";
} else {
    if ($conexion->errno == 1050) {
        echo "La tabla 'usuarios' ya existe.";
    } else {
        echo "Error al crear la tabla 'usuarios': " . $conexion->error;
    }
}

if ($conexion->query($sqlCreacionTablaJuegos) === TRUE) {
    echo "Tabla 'juegos' creada correctamente.";
} else {
    if ($conexion->errno == 1050) {
        echo "La tabla 'juegos' ya existe.";
    } else {
        echo "Error al crear la tabla 'juegos': " . $conexion->error;
    }
}

if ($conexion->query($sqlCreacionTablaPedidos) === TRUE) {
    echo "Tabla 'pedidos' creada correctamente.";
} else {
    if ($conexion->errno == 1050) {
        echo "La tabla 'pedidos' ya existe.";
    } else {
        echo "Error al crear la tabla 'pedidos': " . $conexion->error;
    }
}

if ($conexion->query($sqlCreacionTablaCarrito) === TRUE) {
    echo "Tabla 'carrito' creada correctamente.";
} else {
    if ($conexion->errno == 1050) {
    echo "La tabla 'carrito' ya existe.";
    } else {
    echo "Error al crear la tabla 'carrito': " . $conexion->error;
    }
}

$conexion->close();
