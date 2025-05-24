<link rel="stylesheet" href="css/css.css">
<?php

include "conexionbd.php";
try {
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $id = $_GET["id"];
        $sql = "DELETE FROM juegos WHERE id = $id";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo "Juego con id: $id eliminado";
            header("Location:principalAdmin.php");
            exit();
        } else {
            echo "El juego no se ha podido borrar";
            header("Location:principalAdmin.php");
            exit();
        }
    }
} catch (Exception $e) { ?>
    <div class="errorBorrar">
        <h2>El juego no se puede borrar por que tiene alguna compra asociada</h2>
        <button><a href='principalAdmin.php'>Volver a inicio</a></button>
    </div>
<?php

}
