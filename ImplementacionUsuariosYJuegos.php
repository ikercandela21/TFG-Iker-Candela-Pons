<?php
include "conexionbd.php";

$insertarJuegos = "INSERT INTO juegos (nombre, descripcion, stock, imagen, precio)
VALUES 
('GTA-V', 'De los mejores juegos de mundo abierto', 10, 'imagen_juego1.jpg', 29.99),
('Miecraft', 'Gran juego con ininita diversion', 10, 'imagen_juego2.jpg', 19.99),
('Fifa', 'Historico juego de futbol', 10, 'imagen_juego3.jpg', 39.99)";

$insertarAdministrador = "INSERT INTO usuarios (nombre, usuario, email, contraseña, tipo)
VALUES ('Admin', 'admin', 'admin@gmail.com', 'admin', 'admin')";

if ($conexion->query($insertarJuegos) === TRUE) {
    echo "Juegos creados correctamente.";
} else {
    if ($conexion->errno == 1050) {
        echo "Los juegos ya existen.";
    } else {
        echo "Error al insertar los juegos: " . $conexion->error;
    }
}

if ($conexion->query($insertarAdministrador) === TRUE) {
    echo "Admin creado correctamente.";
} else {
    if ($conexion->errno == 1050) {
        echo "Admin ya existe.";
    } else {
        echo "Error al crear Admin: " . $conexion->error;
    }
}

$conexion->close();
