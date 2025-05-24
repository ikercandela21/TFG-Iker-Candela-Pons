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
        <h2>Juegos mas destacados</h2>
        <div class="slider">
            <img id="slider-img" src="img/fifa.avif" alt="Slide 1" style="width:100%; height:300px;">
        </div>
        <script>
            // Array con las rutas de las imágenes y los textos alternativos
            const imagenes = [{
                    src: "img/fifa.avif",
                    alt: "Slide 1"
                },
                {
                    src: "img/gta.jpg",
                    alt: "Slide 2"
                },
                {
                    src: "img/minecraft.jpg",
                    alt: "Slide 3"
                }
            ];
            var currentIndex = 0;

            function slide() {
                currentIndex = (currentIndex + 1) % imagenes.length;
                // Creamos un nuevo objeto imagen
                var nuevaImagen = new Image();
                nuevaImagen.src = imagenes[currentIndex].src;
                nuevaImagen.alt = imagenes[currentIndex].alt;
                nuevaImagen.style.width = "100%";
                nuevaImagen.style.height = "300px";
                // Cuando la imagen esté cargada, la mostramos en el slider
                nuevaImagen.onload = function() {
                    var sliderImg = document.getElementById("slider-img");
                    sliderImg.src = nuevaImagen.src;
                    sliderImg.alt = nuevaImagen.alt;
                };
            }

            setInterval(slide, 3000);
        </script>
        
        <div class="cartas">
            <?php

            $sql = "SELECT * FROM juegos";
            $result = $conn->query($sql);
            echo '<h2>Lista de Juegos</h2>';
            if ($result->num_rows > 0) {
                echo '<div class="card-container">';
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="card">';
                    echo '<img src="img/' . $row["imagen"] . '" alt="' . $row["nombre"] . '" style="width: 100%; height: 200px;">';
                    echo '<h3>' . $row["nombre"] . '</h3>';
                    echo '<p>' . $row["descripcion"] . '</p>';
                    echo '<p>Stock: ' . $row["stock"] . '</p>';
                    echo '<form method="post" action="carrito.php">';
                    echo '<input type="hidden" name="nombre" value="' . $row["nombre"] . '">';
                    echo '<input type="hidden" name="descripcion" value="' . $row["descripcion"] . '">';
                    echo '<input type="hidden" name="stock" value="' . $row["stock"] . '">';
                    echo '<p>Precio: ' . $row["precio"] . '€</p>';
                    echo "<td><button><a href='borrarJuego.php?id={$row['id']}' class='botones-Admin'>Borrar Juego</a></button>";
                    echo "<td><button><a href='editarJuego.php?id={$row['id']}' class='botones-Admin'>Editar Juego</a></button>";
                    echo '</form>';
                    echo '</div>';
                }
                echo "</div>";
            } else {
                echo "No hay productos disponibles.";
            }
            $conn->close();
            ?>
        </div>
    </main>
    <footer>
        &copy; 2025 Compra tu Juego. Todos los derechos reservados.
    </footer>

</body>

</html>