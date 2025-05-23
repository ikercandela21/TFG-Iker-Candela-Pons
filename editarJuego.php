<?php
include "conexionbd.php";
session_start();
if ($_SESSION["tipo"] !== "admin") {
    echo "<p>No tienes permiso para acceder a esta página.</p>";
    exit();
}

$id = $_GET["id"];

$sql = "SELECT * FROM juegos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();


// Procesar el formulario antes de cualquier salida
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $precio = $_POST["precio"];
    $stock = $_POST["stock"];
    $imagen = $_FILES["imagen"];
    // Si no se selecciona una nueva imagen, se mantiene la de la base de datos
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $fileName = $_FILES['image']['name'];
        $tempPath = $_FILES['image']['tmp_name'];
        $destino = "img/" . $fileName;

        $arraytipo = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (in_array($_FILES['image']['type'], $arraytipo)) {
            if (move_uploaded_file($tempPath, $destino)) {
                $imagen = $fileName;
            } else {
                // Si falla la subida, mantenemos la imagen anterior
                $imagen = $row['imagen'];
            }
        } else {
            // Si el tipo no es válido, mantenemos la imagen anterior
            $imagen = $row['imagen'];
        }
    } else {
        // No se seleccionó nueva imagen, mantenemos la anterior
        $imagen = $row['imagen'];
    }
    $insertar = "UPDATE juegos SET nombre='$nombre', descripcion='$descripcion', stock='$stock', imagen='$imagen', precio='$precio' WHERE id=$id";

    if ($conn->query($insertar)) {
        header("Location:principalAdmin.php");
        exit();
    } else {
        header("Location:principalAdmin.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/css.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="img/logo.png" type="image/png">
    <title>Compra Tu Juego</title>
</head>
<style>
    table {
        width: 90%;
        margin: 20px auto;
        border-collapse: collapse;
        font-size: 18px;
        text-align: left;
    }

    table th,
    table td {
        /* padding: 12px; */
        border: 1px solid #ddd;
    }

    table th {
        background-color: #f4f4f4;
        font-weight: bold;
    }

    table tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    table tr:hover {
        background-color: #f1f1f1;
    }

    button {
        display: block;
        margin: 20px auto;
        padding: 10px 20px;
        background-color: #3B82F6;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    button:hover {
        background-color: #3B82F6;
    }
</style>

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
                <a href="logout.php" style="float: right; margin-left: 15px;">Cerrar Sesión</a>
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

                <a href="logout.php" style="float: right; margin-left: 15px;">Cerrar Sesión</a>

            </nav>
        </div>

    </header>
    <?php

    $sql = "SELECT * FROM juegos where id=$id";
    $result = mysqli_query($conn, $sql);
    if ($result && $result->num_rows > 0) {
        echo "<form action='' method='post' enctype='multipart/form-data'>
<table>
    <tr>
        <td>ID</td>
        <td>Nombre</td>
        <td>Descripcion</td>
        <td>Stock</td>
        <td>Precio</td>
        <td>Imagen</td>
        
    </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
        <td>{$row['id']}</td>
        <td><input type='text' name='nombre' id='nombre' value='{$row['nombre']}'></td>
        <td><textarea name='descripcion' id='descripcion' rows='4' cols='50'>{$row['descripcion']}</textarea></td>
        <td><input type='number' name='stock' id='stock' value='{$row['stock']}'></td>
        <td><input type='number' step='0.01' name='precio' id='precio' value='{$row['precio']}'></td>
        <td><input type='file' name='image' id='image' accept='image/*' value='{$row['imagen']}'></td>
        </tr>
        </table>
        <button>Actualizar</button>
    </form>";
        }
    }
    ?>
</body>

</html>