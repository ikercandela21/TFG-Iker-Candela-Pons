<?php
include "conexionbd.php";
session_start();
ob_start();
if ($_SESSION["tipo"] == "admin") {
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
                <a href="principal.php">Inicio</a>
                <a href="servicio.php">Servicios</a>
                <a href="biblioteca.php">Biblioteca</a>
                <a href="logout.php">Cerrar Sesión</a>
            </div>
        </div>
        <div>
            <a href="carrito.php" style="float: right;" id="carrito"><img src="cart-shopping-solid.svg" alt=""><i class="fa-solid fa-cart-shopping"></i></a>
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
                <a href="logout.php" >Cerrar Sesión</a>
                <a href="carrito.php" style="float: right;"><i class="fa-solid fa-cart-shopping"></i></a>
            </nav>
        </div>
    </header>
    <main>
        <h2>Biblioteca de juegos</h2>
<div class="tabla-responsiva">
        <?php
        
        $usuario = $_SESSION["usuario"];
        $result = $conn->query("SELECT id FROM usuarios WHERE usuario = '$usuario'");
        $row = $result->fetch_assoc();
        $_SESSION["usuario_id"] = $row['id'];

        $result = $conn->query("SELECT pedidos.id, usuario_id, cantidad, fecha, juego_id, codigoJuego
            FROM pedidos
            JOIN juegos ON pedidos.juego_id = juegos.id 
            WHERE pedidos.usuario_id = " . intval($_SESSION["usuario_id"]) . "
            ORDER BY pedidos.id ASC");

        $result_juegos = $conn->query("SELECT id, nombre, precio FROM juegos");
        $juegos = [];
        while ($row_juego = $result_juegos->fetch_assoc()) {
            $juegos[$row_juego['id']] = [
                'nombre' => $row_juego['nombre'],
                'precio' => $row_juego['precio']
            ];
        }
        if ($result->num_rows > 0) {
            echo '<table border="1"  class="tablaBiblioteca">';
            echo '<tr>';
            echo '<th>ID Compra</th>';
            echo '<th>Juego</th>';
            echo '<th>Cantidad</th>';
            echo '<th>Precio</th>';
            echo '<th>Fecha de Compra</th>';
            echo '<th>Codigo Juego</th>';
            echo '</tr>';
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row["id"]) . '</td>';
                echo '<td>' . htmlspecialchars($juegos[$row["juego_id"]]['nombre']) . '</td>';
                echo '<td>' . htmlspecialchars($row["cantidad"]) . '</td>';
                echo '<td>' . htmlspecialchars($juegos[$row["juego_id"]]['precio']) . '€</td>';
                echo '<td>' . htmlspecialchars($row["fecha"]) . '</td>';
                echo '<td>' . htmlspecialchars($row["codigoJuego"]) . '</td>';
                echo '</tr>';
            }
            echo '</table>';
?>
</div>
<?php
            require('fpdf/fpdf.php');
            
            // Clase para generar el PDF
            class PDF extends FPDF {
                function Header() {
                    $this->SetFont('Arial', 'B', 12);
                    $this->Cell(0, 10, 'Historial de Compras', 0, 1, 'C');
                    $this->Ln(10);
                }
    
                function Footer() {
                    $this->SetY(-15);
                    $this->SetFont('Arial', 'I', 8);
                    $this->Cell(0, 10, 'Pagina ' . $this->PageNo(), 0, 0, 'C');
                }
    
                function LoadData($result) {
                    $data = [];
                    while ($row = $result->fetch_assoc()) {
                        $data[] = $row;
                    }
                    return $data;
                }
    
                function BasicTable($header, $data, $juegos) {
                    $widths = [25, 45, 20, 20, 35, 75];
                    $rowsPerPage = 3;
                    $count = 0;

                    // Header
                    for ($i = 0; $i < count($header); $i++) {
                        $this->Cell($widths[$i], 7, $header[$i], 1);
                    }
                    $this->Ln();

                    foreach ($data as $row) {
                        // Add new page and header every 3 rows (except first page)
                        if ($count > 0 && $count % $rowsPerPage == 0) {
                            $this->AddPage();
                            for ($i = 0; $i < count($header); $i++) {
                                $this->Cell($widths[$i], 7, $header[$i], 1);
                            }
                            $this->Ln();
                        }
                        $this->Cell($widths[0], 6, $row['id'], 1);
                        $this->Cell($widths[1], 6, $juegos[$row['juego_id']]['nombre'], 1);
                        $this->Cell($widths[2], 6, $row['cantidad'], 1);
                        $this->Cell($widths[3], 6, $juegos[$row['juego_id']]['precio'] . chr(128), 1);
                        $this->Cell($widths[4], 6, $row['fecha'], 1);
                        $this->Cell($widths[5], 6, $row['codigoJuego'], 1);
                        $this->Ln();
                        $count++;
                    }
                }
            }
            if (isset($_POST['download_pdf'])) {
                ob_clean();
                $pdf = new PDF();
                $header = ['ID Compra', 'Juego', 'Cantidad', 'Precio', 'Fecha de Compra', 'Codigo Juego'];
                $result = $conn->query("SELECT pedidos.id, usuario_id, cantidad, fecha, juego_id, codigoJuego
                    FROM pedidos
                    JOIN juegos ON pedidos.juego_id = juegos.id 
                    WHERE pedidos.usuario_id = " . intval($_SESSION["usuario_id"])."
                    ORDER BY pedidos.id ASC");
                $data = $pdf->LoadData($result);
                $pdf->SetFont('Arial', '', 12);
                $pdf->AddPage();
                $pdf->BasicTable($header, $data, $juegos);
                ob_end_clean();
                $pdf->Output('D', 'historial_compras.pdf');
            }
        } else {
            echo "<p>No has comprado ningún juego.</p>";
        }
        $conn->close();
        ?>
        <form method="post">
            <br>
            <button type="submit" name="download_pdf" class="botonDescargaPdf">Descargar PDF</button>
        </form>
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
        &copy; 2025 Mi Página Web. Todos los derechos reservados.
    </footer>
</body>

</html>