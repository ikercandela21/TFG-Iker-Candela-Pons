<?php
include "conexionbd.php";
session_start();
if ($_SESSION["tipo"] == "admin") {
    echo "<p>No tienes permiso para acceder a esta página.</p>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra Tu Juego</title>
    <link rel="icon" href="img/logo.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/css.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                <a href="principal.php">Inicio</a>
                <a href="servicios.php">Servicios</a>
                <a href="biblioteca.php">Biblioteca</a>
                <a href="logout.php" >Cerrar Sesión</a>
            </div>
        </div>
        <div>
            <a href="carrito.php" style="float: right;" id="carrito"><i class="fa-solid fa-cart-shopping"></i></a>
        </div>
        <script>
            function toggleMenu() {
                const menu = document.querySelector('.mobile-menu-items');
                menu.classList.toggle('active');
            };
        </script>

        <div>
            <nav class="menu-escritorio">
                <a href="principal.php">Inicio</a>
                <a href="servicios.php">Servicios</a>
                <a href="biblioteca.php">Biblioteca</a>
                <a href="logout.php" style="float: right; margin-left: 15px;">Cerrar Sesión</a>
                <a href="carrito.php" style="float: right;"><i class="fa-solid fa-cart-shopping"></i></a>
            </nav>
        </div>
    </header>
    <main>
        <h1>Bienvenido a la sección de servicios</h1>
        <p>En esta sección podrás encontrar una variedad de servicios que ofrecemos y los que habra en un futuro para ir mejorando la plataforma y tu experiencia de compra.</p>
        <h2>Servicios Disponibles</h2>
        <h4>Compra de codigos de juegos</h4>
        <p>Los codigos de juegos es una manera mas sencilla y barata de conseguir los juegos a un precio reducido.</p>
        <p>Los codigos tienen una longitud de unos 20 caracteres.
            Estos los puedes canjear en las distintas pataformas de juegos, como Steam, Epic Games, etc.</p>

        <h2>Proximamente</h2>
        <h4>Compra y venta de juegos</h4>
        <p>Dale una segunda vida a ese juego que tienes en la estanteria sin darle uso durante años, vendiéndolo o intercambiándolo.</p>
        <!-- Flecha para mostrar/ocultar el contacto-->
        <i class="fa-solid fa-arrow-right" id="flecha"></i>
        <div class="contacto">
            <h3>Contactanos</h3>
            <p>602244854 <i class="fa-brands fa-whatsapp"></i></p>
            <script>
                $(document).ready(function() {
                    $('#flecha').click(function() {
                        $('.contacto').animate({
                            left: ($('.contacto').css('left') === '0px' ? '-300px' : '0px')
                        }, 500);
                    });

                    $('.contacto').css({
                        position: 'fixed',
                        left: '-300px',
                        bottom: '20px',
                        width: '250px',
                        zIndex: 1000
                    });
                });
            </script>
        </div>
    </main>
    <footer>
    <p>&copy; 2025 Mi Página Web. Todos los derechos reservados.</p>
</footer>
</body>

</html>