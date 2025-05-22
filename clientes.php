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
<?php
ob_start();
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
            <h2>Clientes</h2>
            <p class="descripcion">Aqui apareceran todos los clientes registrados en la web</p>
            <?php
            if ($_SESSION["tipo"] !== "admin") {
                echo "<p>No tienes permiso para acceder a esta página.</p>";
                exit();
            }

            $sql = "SELECT * FROM usuarios";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table border='1'>
            <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Usuario</th>
            <th>Email</th>
            <th>Contraseña</th>
            <th>Tipo</th>
            <th>Acciones</th>
            </tr>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['nombre'] . "</td>";
                    echo "<td>" . $row['usuario'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['contraseña'] . "</td>";
                    echo "<td>" . $row['tipo'] . "</td>";
                    echo "<td><button><a href='editarusuarios.php?id={$row['id']}'>Editar</a></button>";
                    echo "<button><a href='borrarusuarios.php?id={$row['id']}'>Borrar</a></button></td>";
                    echo "</tr>";
                }
                echo "</table>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['usuario'] . "</td>";
                    echo "<td>" . $row['nombre'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['contraseña'] . "</td>";

                    echo "</tr>";
                }
                echo "</table>";
            }

            // Creacion de PDF
            require('fpdf/fpdf.php');

            class PDF extends FPDF
            {
                function Header()
                {
                    $this->SetFont('Arial', 'B', 16);
                    $this->Cell(0, 10, 'Lista de Usuarios', 0, 1, 'C');
                    $this->Ln(10);
                    // Table header
                    $header = ['ID', 'Nombre', 'Usuario', 'Email', 'Contraseña', 'Tipo'];
                    $widths = [10, 30, 30, 50, 50, 20];
                    for ($i = 0; $i < count($header); $i++) {
                        $this->Cell($widths[$i], 7, $header[$i], 1);
                    }
                    $this->Ln();
                }

                function Footer()
                {
                    $this->SetY(-15);
                    $this->SetFont('Arial', 'I', 8);
                    $this->Cell(0, 10, 'Pagina ' . $this->PageNo(), 0, 0, 'C');
                }

                function LoadData($result)
                {
                    $data = [];
                    while ($row = $result->fetch_assoc()) {
                        $data[] = $row;
                    }
                    return $data;
                }

                function BasicTable($data)
                {
                    $widths = [10, 30, 30, 50, 50, 20];
                    $count = 0;
                    foreach ($data as $row) {
                        if ($count > 0 && $count % 3 == 0) {
                            $this->AddPage();
                        }
                        $this->Cell($widths[0], 6, $row['id'], 1);
                        $this->Cell($widths[1], 6, $row['nombre'], 1);
                        $this->Cell($widths[2], 6, $row['usuario'], 1);
                        $this->Cell($widths[3], 6, $row['email'], 1);
                        $this->Cell($widths[4], 6, $row['contraseña'], 1);
                        $this->Cell($widths[5], 6, $row['tipo'], 1);
                        $this->Ln();
                        $count++;
                    }
                }
            }

            if (isset($_POST['download_pdf'])) {
                ob_clean();
                $pdf = new PDF();
                ob_start(); // Iniciar el buffer de salida
                $result = $conn->query($sql);
                $data = $pdf->LoadData($result);
                $pdf->SetFont('Arial', '', 12);
                $pdf->AddPage();
                $pdf->BasicTable($data);
                ob_end_clean(); // Limpieza de buffer
                $pdf->Output('D', 'Usuarios-CTJ.pdf');
            }
            $conn->close();
            ?>
            <form method="post">
            <br>
            <button type="submit" name="download_pdf" class="botonClientes">Descargar PDF</button>
        </form>
        </main>
        



        <footer>
            &copy; 2025 Mi Página Web. Todos los derechos reservados.
        </footer>

</body>

</html>