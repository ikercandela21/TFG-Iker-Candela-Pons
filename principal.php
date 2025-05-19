<?php
include "conexionbd.php";
session_start();

if ($_SESSION["tipo"] == "admin") {
    header("Location:principal.admin");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra tu Juego</title>
    <link rel="stylesheet" href="css/css.css">
    <link rel="icon" href="img/logo.png" type="image/png">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="js/fontawesome.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<?php

$sql = "SELECT * FROM usuarios WHERE usuario = ? AND contraseña = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $_SESSION["usuario"], $_SESSION["contraseña"]);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<p>Usuario o contraseña incorrectos.</p>";
    exit();
} else {
    $row = $result->fetch_assoc();
    $_SESSION["usuario_id"] = $row["id"];
    $_SESSION["usuario_nombre"] = $row["nombre"];
    $_SESSION["usuario_email"] = $row["email"];
}
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
                <a href="servicio.php">Servicios</a>
                <a href="biblioteca.php">Biblioteca</a>
                <a href="logout.php">Cerrar Sesión</a>
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
                <a href="servicio.php">Servicios</a>
                <a href="biblioteca.php">Biblioteca</a>
                <a href="logout.php" style="float: right; margin-left: 15px;">Cerrar Sesión</a>
                <a href="carrito.php" style="float: right;"><i class="fa-solid fa-cart-shopping"></i></a>
            </nav>
        </div>
    </header>
    <main>
        <h2>Juegos mas destacados</h2>
        <div class="slider">
            <div class="slides">
                <div class="slide"><img src="img/fifa.avif" alt="Slide 1"></div>
                <div class="slide"><img src="img/gta.jpg" alt="Slide 2"></div>
                <div class="slide"><img src="img/minecraft.jpg" alt="Slide 3"></div>
            </div>
        </div>

        <script>
            var currentIndex = 0;

            $(document).ready(function() {
                var imagenes = [
                    "img/fifa.avif",
                    "img/gta.jpg",
                    "img/minecraft.jpg"
                ];
                var slider = $('.slides');
                var totalSlides = imagenes.length;

                function mostrarSlide(index) {
                    slider.css('transform', 'translateX(-' + (index * 100) + '%)');
                }

                setInterval(function() {
                    currentIndex = (currentIndex + 1) % totalSlides;
                    mostrarSlide(currentIndex);
                }, 3000);
            });
        </script>

        <h2>Lista de juegos</h2>
        <div class="buscador">
            <form action="" method="post">
                <i class="fa-solid fa-magnifying-glass"></i><input type="text" name="lupa" id="lupa" placeholder="Buscar juego" onkeyup="buscarJuego()">
            </form>
            <div id="error"></div>
        </div>
        <script>
            function buscarJuego() {
                var input = document.getElementById("lupa").value;
                var errorDiv = document.getElementById("error");

                if (input.length < 1) {
                    errorDiv.innerHTML = "Introduce al menos 1 carácter.";
                    return;
                } else {
                    errorDiv.innerHTML = "";
                }
            }
        </script>

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

        <?php

        if (isset($_POST['lupa'])) {
            $lupa = $_POST['lupa'];
            $sql = "SELECT * FROM juegos WHERE nombre LIKE '%$lupa%'";

            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                echo '<div class="card-container">';
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="card">';
                    echo '<img src="img/' . $row["imagen"] . '" alt="' . $row["nombre"] . '" style="width: 100%; height: 200px;" name="imagen">';
                    echo '<h3>' . $row["nombre"] . '</h3>';
                    echo '<p>' . $row["descripcion"] . '</p>';
                    echo '<p>Stock: ' . $row["stock"] . '</p>';
                    echo '<p>Precio: ' . $row["precio"] . '€</p>';
                    echo '<form method="post" action="comprobarStock.php">';
                    echo '<input type="hidden" name="id" value="' . $row["id"] . '">';
                    echo '<input type="hidden" name="nombre" value="' . $row["nombre"] . '">';
                    echo '<input type="hidden" name="descripcion" value="' . $row["descripcion"] . '">';
                    echo '<input type="hidden" name="stock" value="' . $row["stock"] . '">';
                    echo '<input type="hidden" name="precio" value="' . $row["precio"] . '">';
                    echo '<input type="hidden" name="imagen" value="' . $row["imagen"] . '">';
                    echo '<button type="submit">Añadir al carro</button>';
                    echo '</form>';
                    echo '</div>';
                }
                echo "</div>";
            } else {
                echo "No hay productos disponibles.";
                $sql = "SELECT * FROM juegos";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    echo '<div class="card-container">';
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="card">';
                        echo '<img src="img/' . $row["imagen"] . '" alt="' . $row["nombre"] . '" style="width: 100%; height: 200px;" name="imagen">';
                        echo '<h3>' . $row["nombre"] . '</h3>';
                        echo '<p>' . $row["descripcion"] . '</p>';
                        echo '<p>Stock: ' . $row["stock"] . '</p>';
                        echo '<p>Precio: ' . $row["precio"] . '€</p>';
                        echo '<form method="post" action="comprobarStock.php">';
                        echo '<input type="hidden" name="id" value="' . $row["id"] . '">';
                        echo '<input type="hidden" name="nombre" value="' . $row["nombre"] . '">';
                        echo '<input type="hidden" name="descripcion" value="' . $row["descripcion"] . '">';
                        echo '<input type="hidden" name="stock" value="' . $row["stock"] . '">';
                        echo '<input type="hidden" name="precio" value="' . $row["precio"] . '">';
                        echo '<input type="hidden" name="imagen" value="' . $row["imagen"] . '">';
                        echo '<button type="submit">Añadir al carro</button>';
                        echo '</form>';
                        echo '</div>';
                    }
                    echo "</div>";
                } else {
                    echo "No hay productos disponibles.";
                }
            }
        } else {

            $sql = "SELECT * FROM juegos";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo '<div class="card-container">';
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="card">';
                    echo '<img src="img/' . $row["imagen"] . '" alt="' . $row["nombre"] . '" style="width: 100%; height: 200px;" name="imagen">';
                    echo '<h3>' . $row["nombre"] . '</h3>';
                    echo '<p>' . $row["descripcion"] . '</p>';
                    echo '<p>Stock: ' . $row["stock"] . '</p>';
                    echo '<p>Precio: ' . $row["precio"] . '€</p>';
                    echo '<form method="post" action="comprobarStock.php">';
                    echo '<input type="hidden" name="id" value="' . $row["id"] . '">';
                    echo '<input type="hidden" name="nombre" value="' . $row["nombre"] . '">';
                    echo '<input type="hidden" name="descripcion" value="' . $row["descripcion"] . '">';
                    echo '<input type="hidden" name="stock" value="' . $row["stock"] . '">';
                    echo '<input type="hidden" name="precio" value="' . $row["precio"] . '">';
                    echo '<input type="hidden" name="imagen" value="' . $row["imagen"] . '">';
                    echo '<button type="submit">Añadir al carro</button>';
                    echo '</form>';
                    echo '</div>';
                }
                echo "</div>";
            } else {
                echo "No hay productos disponibles.";
            }
        }
        $conn->close();
        ?>
        </div>
    </main>
    <footer>
    <p>&copy; 2025 Compra Tu Juego . Todos los derechos reservados.</p>
</footer>
</body>

</html>