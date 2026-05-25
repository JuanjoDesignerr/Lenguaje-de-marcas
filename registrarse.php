<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regristrarse</title>
    <link rel="stylesheet" href="css/cssRegistro.css">
</head>
<body>

    <h1 id="nombre">POLIDEPORTIVO ORIHUELA</h1>
    <?php

        $host = 'localhost';
        $dbname = 'bd8';
        $user = 'root';
        $pass = '';
        $port = '3306';

    ?>

    <div id="contenedor">
        <h2>FORMULARIO DE REGISTRO</h2>

        <div class="campo">
            <label>USUARIO:</label>
            <input type="text" placeholder="Usuario">
        </div>

        <div class="campo">
            <label>CONTRASEÑA:</label>
            <input type="password" placeholder="Confirmar contraseña">
        </div>

        <div class="campo">
            <label>CONFIRMAR CONTRASEÑA:</label>
            <input type="password" placeholder="Confirmar contraseña">
        </div>

        <div class="campo">
            <label>CORREO ELECTRONICO:</label>
            <input type="email" placeholder="Correo electronico">
        </div>

        <div class="terminos">
            <input type="checkbox" id="terminos">
            <label for="terminos">ACEPTAR TERMINOS Y  CONDICIONES</label>
        </div>

        <a href="Login.html"><button class="boton">CREAR CUENTA</button></a>
        <a href="Login.html" class="enlace-inicio">Volver al inicio</a>
    </div>
</body>
</html>