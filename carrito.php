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
                <a href="principal.php">Inicio</a>
                <a href="#">Servicios</a>
                <a href="#">Contacto</a>
                <a href="biblioteca.php">Biblioteca</a>
                <a href="logout.php" style="float: right; margin-left: 15px;">Cerrar Sesión</a>
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
                <a href="#">Servicios</a>
                <a href="#">Contacto</a>
                <a href="biblioteca.php">Biblioteca</a>
                <a href="logout.php" style="float: right; margin-left: 15px;">Cerrar Sesión</a>
                <a href="carrito.php" style="float: right;"><i class="fa-solid fa-cart-shopping"></i></a>
            </nav>
        </div>
    </header>
    <main class="main-carrito">
        <?php

        $sql="SELECT * FROM carrito WHERE usuario_id = {$_SESSION['usuario_id']}";
        $result = $conn->query($sql);
        $productos = array();
        if ($result->num_rows > 0) {
        
            while ($row = $result->fetch_assoc()) {
                $productos[] = $row;
            }
        } else {
            echo "No hay productos en el carrito.";
        }


        // Buscar los detalles de los juegos en la tabla juegos
        $juegos = array();
        foreach ($productos as $producto) {
            $juego_id = $producto['juego_id'];
            $sqlJuego = "SELECT * FROM juegos WHERE id = $juego_id";
            $resultJuego = $conn->query($sqlJuego);
            if ($resultJuego->num_rows > 0) {
                while ($rowJuego = $resultJuego->fetch_assoc()) {
                    $juegos[] = $rowJuego;
                }
            }
        }

        // Mostrar los detalles de los juegos
        echo "<h2>Detalles de los Juegos</h2>";
        echo "<div class='juegos-container'>";
        foreach ($juegos as $index => $juego) {
            echo "<div class='juego-item'>";
            echo "<img src='img/" . $juego['imagen'] . "' alt='" . $juego["nombre"] . "' width='100px' height='100px'>";
            echo "<h3>" . $juego["nombre"] . "</h3>";
            echo "<p>" . $juego["descripcion"] . "</p>";
            echo "<p>Precio: " . $juego["precio"] . "€</p>";
            echo "<p>Cantidad: " . $productos[$index]["cantidad"] . "</p>";
            echo "<a href='eliminarProducto.php?id=" . $juego['id'] . "' class='basura'><i class='fa-solid fa-trash'></i></a>";
            echo "<hr>";
            echo "</div>";
        }
        echo "</div>";
        echo "<button> <a href='vaciarcarrito.php' id='botones'>Vaciar Carrito</a></button>";

        $total = 0;
        foreach ($juegos as $juego) {
            $total += $juego['precio'];
        }
        // Calcular el total teniendo en cuenta la cantidad de cada producto
        $total = 0;
        foreach ($productos as $index => $producto) {
            $cantidad = (int)$producto['cantidad'];
            $precio = (float)$juegos[$index]['precio'];
            $total += $precio * $cantidad;
        }
        $_SESSION['total'] = $total;
        echo "<h3>Total: " . $total . "€</h3>";
        echo "<button><a href='api/form.php?total=" . $total . "' id='botones'>Comprar</a></button>";
        ?>

        </div>
        
    </main>
    <footer>
        &copy; 2025 Compra Tu Juego. Todos los derechos reservados.
    </footer>
</body>

</html>