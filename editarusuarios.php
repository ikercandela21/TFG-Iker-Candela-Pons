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
        $id = $_GET["id"];
        $sql = "SELECT * FROM usuarios where id=$id";
        $result = mysqli_query($conn, $sql);
        if ($result && $result->num_rows > 0) {
            echo "<div class='tabla-responsiva'>";
            echo "<form action='' method='post'>
                <table>
                <tr>
                <td>ID</td>
                <td>Nombre</td>
                <td>Usuario</td>
                <td>Email</td>
                <td>Contraseña</td>
                <td>Tipo</td>
                </tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                <td>{$row['id']}</td>
                <td><input type='text' name='nombre' id='nombre' value='{$row['nombre']}'></td>
                <td><input type='text' name='usuario' id='usuario' value='{$row['usuario']}'></td>
                <td><input type='email' name='email' id='email' value='{$row['email']}'></td>
                <td><input type='text' name='contrasena' id='contrasena' value='{$row['contraseña']}'></td>
                <td><input type='text' name='tipo' id='tipo' value='{$row['tipo']}'></td>
                </tr>
                </table>
                <button class='actualizar-Usuario'>Actualizar</button>
                </form>";
                echo "</div>";
            }
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $nombre = $_POST["nombre"];
                $usuario = $_POST["usuario"];
                $email = $_POST["email"];
                $contrasena = $_POST["contrasena"];
                $tipo = $_POST["tipo"];

                $insertar = "UPDATE usuarios SET nombre='$nombre', usuario='$usuario', email='$email', contraseña='$contrasena', tipo='$tipo' WHERE id=$id";

                if ($conn->query($insertar)) {
                    echo "El usuario se ha actualizado correctamente";
                    header("Location: clientes.php");
                    exit();
                } else {
                    echo "No se ha podido actualizar";
                }
            }
        }
        ?>
    </main>
    <footer>
        &copy; 2025 Compra tu Juego. Todos los derechos reservados.
    </footer>
</body>

</html>