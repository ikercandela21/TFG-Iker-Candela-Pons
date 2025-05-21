<?php
include "conexionbd.php";
session_start();
if ($_SESSION["tipo"] !== "admin") {
    echo "<p>No tienes permiso para acceder a esta página.</p>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra Tu Juego</title>
    <link rel="icon" href="img/logo.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/css.css">

</head>

<body>
    <header>
        <h1>Compra Tu Juego</h1>
        <p class="Usuario"><?php echo "Usuario: " . htmlspecialchars($_SESSION["usuario"]); ?></p>
        <div id="clock"></div>
        <!-- Script para que salga la hora que es en la pagina -->
        <script>
            function startTime() {
                const today = new Date();
                let h = today.getHours();
                let m = today.getMinutes();
                let s = today.getSeconds();
                m = checkTime(m);
                s = checkTime(s);
                document.getElementById('clock').innerHTML = h + ":" + m + ":" + s;
                setTimeout(startTime, 1000);
            }

            function checkTime(i) {
                if (i < 10) {
                    i = "0" + i
                };
                return i;
            }

            window.onload = function() {
                startTime();
            };
        </script>

        <!-- Menu desplegable -->
        <div class="mobile-menu">
            <div class="hamburger" onclick="toggleMenu()">
                <i class="fas fa-bars"></i>
            </div>
            <div class="mobile-menu-items">
                <a href="principalAdmin.php">Inicio</a>
                <a href="clientes.php">Clientes</a>
                <a href="añadirJuego.php">Añadir Juego</a>
                <a href="registrarUsuario.php">Registrar Usuario</a>
                <a href="consultarSaldo.php">Consultar Saldo</a>
                <a href="logout.php">Cerrar Sesión</a>
            </div>
        </div>

        <script>
            function toggleMenu() {
                const menu = document.querySelector('.mobile-menu-items');
                menu.classList.toggle('active');
            };
        </script>

        <div>
            <nav class="menu-escritorio">
                <a href="principalAdmin.php">Inicio</a>
                <a href="clientes.php">Clientes</a>
                <a href="añadirJuego.php">Añadir Juego</a>
                <a href="registrarUsuario.php">Registrar Usuario</a>
                <a href="consultarSaldo.php">Consultar Saldo</a>
                <a href="logout.php">Cerrar Sesión</a>
            </nav>
        </div>
    </header>
    <main>
        <?php

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nombre = $_POST["nombre"];
            $usuario = $_POST["usuario"];
            $contraseña = $_POST["password"];
            $email = $_POST["email"];
            $tipo = $_POST["tipo"];

            if (!empty($nombre) && !empty($usuario) && !empty($contraseña) && !empty($email)) {
                $sql = "INSERT INTO usuarios (nombre, usuario, email, contraseña, tipo) VALUES ('$nombre', '$usuario', '$email', '$contraseña', '$tipo')";

                if ($conn->query($sql) == true) {
                    echo "Se ha registrado corectamente";
                } else {
                    die("Error al registrar: " . $conexion->error);
                }
            } else {
                die("Todos los campos son obligatorios.");
            }
        }

        ?>
        <div class="formularioRegistro">
            <form action="" method="post" class="formulario-Registro-Usuario">
                <h1>Formulario de Registro</h1>
                <br><input type="text" id="nombre" name="nombre" required placeholder="Nombre"><br><br>
               
                <input type="text" id="usuario" name="usuario" required placeholder="Nombre de Usuario"><br><br>
                
                <input type="password" id="password" name="password" required placeholder="Contraseña"><br><br>
                
                <input type="email" id="email" name="email" required placeholder="Email"><br><br>
                <label for="tipo">Tipo Usuario:</label>
                <select name="tipo" id="">
                    <option value="cliente">Cliente</option>
                    <option value="admin">Admin</option>
                </select><br><br>
                <input type="submit" value="Registrar">
            </form>
        </div>
    </main>
</body>

</main>
<footer>
    &copy; 2025 Mi Página Web. Todos los derechos reservados.
</footer>
</body>

</html>