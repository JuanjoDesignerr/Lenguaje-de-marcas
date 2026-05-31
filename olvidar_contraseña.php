<?php
try {
    // Conexión limpia a la base de datos (XAMPP)
    $pdo = new PDO("mysql:host=localhost;dbname=poli_bd;charset=utf8", "root", "");
    
    // Comprobamos si el usuario ha enviado los dos campos del formulario
    if (isset($_POST['usuario_nombre']) && isset($_POST['usuario_correo'])) {
        $nombre = $_POST['usuario_nombre'];
        $correo = $_POST['usuario_correo'];
        
        // Buscamos si existe un usuario que coincida con ese nombre Y ese correo
        $stmt = $pdo->prepare('SELECT contrasena FROM usuarios WHERE nombre = :nombre AND correo = :correo');
        $stmt->execute([
            ':nombre' => $nombre,
            ':correo' => $correo
        ]);
        
        //Con los datos que hemos guardado va a sql y mira si hay un registro que coincide
        // con uno de los datos que pusimos, si lo encuentra carga todos sus datos y 
        // lo transforma en un array asociativo clave valor. Si no encuentra nada devuelve false.
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($usuario) {
            // Si existe, guardamos la contraseña en la variable de mensaje
            $mensaje = "Tu contraseña es: " . $usuario['contrasena'];
        } else {
            // Si los datos no coinciden con ningún registro
            $mensaje = "Los datos introducidos no coinciden con ningún usuario.";
        }
    }
} catch (PDOException $e) {
    $mensaje = "Error de conexión: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Olvidar contraseña</title>
    <link rel="stylesheet" href="css/cssOlvidar.css">
</head>
<body>

    <form action="olvidar_contraseña.php" method="POST">
        <h1 id="nombre">POLIDEPORTIVO ORIHUELA</h1>
        <div id="contenedor"> 

            <h2>RECUPERAR CONTRASEÑA</h2>
            
            <div class="campo">
                <label>USUARIO:</label>
                <input type="text" name="usuario_nombre" placeholder="Introduce tu correo" required>
            </div>

            <div class="campo">
                <label>CORREO ELECTRONICO:</label>
                <input type="email" name="usuario_correo" placeholder="Introduce tu correo" required>
            </div>

            <?php if (!empty($mensaje)) {
                echo $mensaje; 
                }   
            ?>

            <button type="submit" class="boton">GUARDAR</button>
            <a href="Login.php" class="enlace-inicio">Volver al inicio</a>
        </div>
    </form>
</body>
</html>