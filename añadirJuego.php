<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra Tu Juego</title>
    <link rel="stylesheet" href="img/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/css.css">
</head>
<?php

include "conexionbd.php";
session_start();
?>

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
                //Escribe la hora en el div con el id clock
                document.getElementById('clock').innerHTML = h + ":" + m + ":" + s;
                //Llama a la funcion ca un segundo
                setTimeout(startTime, 1000); 
            }

            //Esta funcion añade un cero a la izquierda si el numero solo tiene una cifra
            function checkTime(i) {
                if (i < 10) {
                    i = "0" + i
                };
                return i;
            }

            //Esto hace que cuando la pagina se cargue llame a la funcion startTime para que vuelva a empezar
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
        <div>
            <a href="carritoAdmin.php" style="float: right;" id="carrito"><i class="fa-solid fa-cart-shopping"></i></a>
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
                <a href="logout.php" style="float: right; margin-left: 15px;">Cerrar Sesión</a>

            </nav>
        </div>
    </header>
    <main>


        <div class="agregarJuego">
            <form method="post" action="" class="formulario-AñadirJuego" enctype="multipart/form-data">
                <h2>Añadir Juegos</h2>

                <input type="text" id="nombre" name="nombre" required placeholder="Nombre del Juego"><br><br>

                <textarea id="descripcion" name="descripcion" required placeholder="Descripción del Juego"></textarea><br><br>

                <input type="number" id="precio" name="precio" step="0.01" required placeholder="Precio del Juego"><br><br>

                <input type="number" id="stock" name="stock" required placeholder="Stock del Juego"><br><br>
                <label for="imagen">Imagen:</label><br>
                <input type="file" id="imagen" name="image" required><br><br>
                <input type="submit" value="Añadir Juego">
            </form>
        </div>

        <?php
        if ($_SESSION["tipo"] !== "admin") {
            echo "<p>No tienes permiso para acceder a esta página.</p>";
            exit();
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nombre = $_POST["nombre"];
            $descripcion = $_POST["descripcion"];
            $precio = $_POST["precio"];
            $stock = $_POST["stock"];


            // Asignacion de la imagen a la carpeta img
            if (isset($_FILES['image'])) {
                $fileName = $_FILES['image']['name'];
                $tempPath = $_FILES['image']['tmp_name'];
                $destino = "img/" . $fileName;

                $arraytipo = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                if (in_array($_FILES['image']['type'], $arraytipo)) {
                    if (move_uploaded_file($tempPath, $destino)) {
                        echo "Imagen subida correctamente.";
                        $imagen = $fileName;
                    } else {
                        echo "Error al subir la imagen.";
                        $imagen = "";
                    }
                } else {
                    echo "Tipo de archivo no permitido.";
                    $imagen = "";
                }
            } else {
                $imagen = "";
            }

            $sql = "INSERT INTO juegos (nombre, descripcion, stock, imagen, precio) VALUES ('$nombre', '$descripcion', '$stock', '$imagen', '$precio')";
            if ($conn->query($sql) === TRUE) {
                echo "Nuevo juego añadido con éxito";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        $sql = "SELECT * FROM juegos";
        $result = $conn->query($sql);

        ?>
        </div>
    </main>
    <footer>
        &copy; 2025 Compra Tu Juego. Todos los derechos reservados.
    </footer>
</body>

</html>