<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra tu Juego</title>
    <link rel="icon" href="img/logo.png" type="image/png">
    <link rel="stylesheet" href="css/css.css">
</head>


<body>
        <header class="header-inicio">
            <h1>Bienvenido a Compra Tu Juego</h1>
        </header>
        <main class="main-InicioSesion">
            <div class="container">
                <h2>Iniciar sesión</h2>
                <form action="autentificacion.php" method="post">
                    <div class="">
                        <input type="text" id="usuario" name="usuario" required placeholder="USUARIO">
                    </div>
                    <div class="">
                        <input type="password" id="contraseña" name="contraseña" required placeholder="CONTRASEÑA">
                    </div>
                    <button type="submit" class="btn">Iniciar sesión</button>
                </form>
                <p>¿No tienes una cuenta? <a href="registro.php" class="registro">Regístrate aquí</a></p>
            </div>
        </main>
        <footer>
            <p>&copy; 2023 Compra Tu Juego. Todos los derechos reservados.</p>
        </footer>
</body>

</html>