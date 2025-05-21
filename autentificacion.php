<?php
include "conexionbd.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();    
    $usuario = $_POST["usuario"];
    $contraseña = $_POST["contraseña"];

    $_SESSION["usuario"] = $usuario;
    $_SESSION["contraseña"] = $contraseña;
    
    

    $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND contraseña = '$contraseña'";
    
    $result = $conn->query($sql);

    

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            
            $tipo= $row['tipo'];
            $_SESSION["tipo"]=$tipo;
        }


        echo "Inicio de sesión exitoso";
        if ($tipo == 'admin') {
            header("Location: principalAdmin.php");
            exit();
        } else {
            header("Location: principal.php");
            exit();
        }
    } else {
        echo "Usuario o contraseña incorrectos";
        header("Location:inicio.php");
        exit();
    }

    $conexion->close();
}