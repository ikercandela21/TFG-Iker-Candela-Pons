<?php
include "conexionbd.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $usuario = $_POST["usuario"];
    $contraseña = $_POST["password"];
    $email = $_POST["email"];

    if (!empty($nombre) && !empty($usuario) && !empty($contraseña) && !empty($email)) {
        $sql = "INSERT INTO usuarios (nombre, usuario, email, contraseña, tipo) VALUES ('$nombre', '$usuario', '$email', '$contraseña', 'cliente')";

        if ($conn->query($sql) == true) {
            echo "Se ha registrado corectamente";
            header("Location:index.php");
            exit();
        } else {
            die("Error al registrar: " . $conn->error);
        }
    } else {
        die("Todos los campos son obligatorios.");
    }
    echo "Se ha registrado corectamente";
    header("Location:index.php");
    exit();
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Compra Tu Juego</title>
    <link rel="icon" href="img/logo.png" type="image/png">
    <link rel="stylesheet" href="css/css.css">
</head>

<body class="body-registro">
    <header>
        <h1>Bienvenido a Compra Tu Juego</h1>
    </header>
    <main class="main-InicioSesion">
        <div class="container">
        <h2>Formulario de Registro</h2>
        <form action="" method="post">

            
            <input type="text" id="nombre" name="nombre" required placeholder="Nombre"><br><br>

            
            <input type="text" id="usuario" name="usuario" required placeholder="Usuario"><br><br>

            
            <input type="password" id="password" name="password" required placeholder="Password"><br><br>

            
            <input type="email" id="email" name="email" required placeholder="Email"><br><br>

            <input type="submit" value="Registrar">
            <p>Ya tienes una cuenta? <a href="index.php" class="registro">Iniciar sesión</a></p>
        </form>
        </div>
    </main>
</body>

</html>