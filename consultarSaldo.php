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
    <div class="datos">
      <h1>Consulta de Saldo</h1>
      <div class="card" onclick="window.location.href='https://stripe.com'">
        <div>
          <i class="fas fa-wallet"></i> Saldo de la Cuenta
        </div>
        <div>
          <h2 id="saldo-card">Cargando...</h2>
          <p style="margin-top:10px;">El saldo que aparece es el que hay actualmente en la cuenta, por lo que puede no reflejar compras recientes.</p>
          <p>Para mas información visita Stripe</p>
        </div>

      </div>

      <script>
        function actualizarSaldo(data) {
          document.getElementById("saldo-card").innerText = `Saldo disponible: ${data.available} ${data.currency.toUpperCase()}`;
        }

        // Funcion AJAX para cargar el saldo
        function cargarSaldo() {
          //LLama a la pagina scriptStripe.php
          fetch("scriptStripe.php")
            .then(response => {
              console.log("Response:", response);
              return response.json();
            })
            .then(data => {
              //Llama a la funcion actualizarSaldoCard 
              actualizarSaldo(data);
            })
            .catch(error => {
              console.error("Error al obtener el balance:", error);
              console.log("Error al obtener el balance:", error);
            });
        }
        // LLama a la funcion cargarSaldo para que realice todo el proceso
        cargarSaldo();
        // Llama a la funcion cargarSaldo cada 5 segundos
        setInterval(cargarSaldo, 5000);
      </script>
    </div>
  </main>
  <footer>
    &copy; 2025 Compra tu Juego. Todos los derechos reservados.
  </footer>

</body>

</html>