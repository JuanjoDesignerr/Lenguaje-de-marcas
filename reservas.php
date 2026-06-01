<?php
session_start();

// Si el usuario no ha iniciado sesion, no puede entrar.
if (!isset($_SESSION['usuario_nombre']) && !isset($_SESSION['admin_usuario'])) {
    header("Location: Login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservar Pista</title>
    <link rel="stylesheet" href="css/cssReservas.css">
</head>
<body>
    <div id="contenedor">
        <h2>COMPLETA TU RESERVA</h2>

        <form method="POST" action="">
            <div id="formulario">
                <div class="campo">
                    <label>PISTA A RESERVAR:</label>
                    <input type="text" name="pista_a_reservar" placeholder="Escribe la pista" required>
                </div>

                <div class="campo">
                    <label>FECHA Y HORA:</label>
                    <input type="text" name="fecha_y_hora" placeholder="Introduce la hora escogida" required>
                </div>

                <div class="campo">
                    <label>NUMERO DE JUGADORES:</label>
                    <input type="number" name="num_jugadores" placeholder="Numero de jugadores">
                </div>
                
                <div class="separador">DATOS DE PAGO</div>

                <div class="campo">
                    <label>TIPO DE TARJETA:</label>
                    <select class="selector-tarjeta" name="tipo_tarjeta">
                        <option value="">Selecciona tu tarjeta</option>
                        <option value="visa">Visa</option>
                        <option value="mastercard">Mastercard</option>
                    </select>
                </div>

                <div class="campo">
                    <label>NÚMERO DE TARJETA:</label>
                    <input type="text" name="n_tarjeta" placeholder="1234 5678 9012 3456">
                </div>

                <div class="campo-doble">
                    <div class="campo">
                        <label>FECHA DE CADUCIDAD:</label>
                        <input type="text" name="caducidad" placeholder="MM/AA">
                    </div>
                    <div class="campo">
                        <label>CÓDIGO DE SEGURIDAD:</label>
                        <input type="text" name="cvv" placeholder="CVV">
                    </div>
                </div>
                
                <button type="submit" class="boton">PAGAR</button>
                <a href="index.php" class="enlace-inicio">Volver atras</a>
            </div>
        </form>
    </div>
</body>
</html>