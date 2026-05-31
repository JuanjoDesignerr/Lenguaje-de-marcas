<?php 
    $error = "";
     try{
            $pdo = new PDO("mysql:host=localhost;dbname=poli_bd;charset=utf8", "root", "");
           
            //Compruebo si ha enviado los datos y los almacenamos en variables.
            if (isset($_POST['usuario_nombre']) && isset($_POST['usuario_correo']) && isset($_POST['usuario_contraseña'])) {
                $nombre = $_POST['usuario_nombre'];
                $correo = $_POST['usuario_correo'];
                $pass = $_POST['usuario_contraseña'];

                //Comprobamos si el correo ya existe
                $buscarCorreo = $pdo->prepare('SELECT * FROM usuarios WHERE correo = :correo');
                $buscarCorreo->execute([':correo' => $correo]);
                
                //Buscamos si por la clave correo=>'nuestrocorreo' en el cual el nuestro correo es el correo introducido
                $usuarioExistente = $buscarCorreo->fetch(PDO::FETCH_ASSOC);
                
                if($usuarioExistente) {
                    $error = "El correo ya existe prueba a introducir otro correo.";
                } else {

                    //Indicamos que hay un hueco reservado y despues en execute completamos el hueco.
                    $stmt = $pdo->prepare('INSERT INTO usuarios (nombre, correo, contrasena) VALUES (:nombre, :correo, :pass);');
                    $stmt->execute([
                        ':nombre' => $_POST['usuario_nombre'],
                        ':correo' => $_POST['usuario_correo'],
                        ':pass' => $_POST['usuario_contraseña']
                    ]);
                }
            }
        //Atrapamos la excepcion si no nos llegamos a conectar a la base de datos.
        } catch(PDOException $e) {
        
        echo "error conectando con la base de datos:" . $e->getMessage();
        
        }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regristrarse</title>
    <link rel="stylesheet" href="css/cssRegistro.css">
</head>
<body>

    <form action="registrarse.php" method="POST">
        <h1 id="nombre">POLIDEPORTIVO ORIHUELA</h1>

        <div id="contenedor">
            <h2>FORMULARIO DE REGISTRO</h2>
               <?php if (!empty($error)) {
                    echo $error; 
                    }   
                ?>
            <div class="campo">
                <label>USUARIO:</label>
                <input type="text" name="usuario_nombre" placeholder="Usuario" required>
            </div>

            <div class="campo">
                <label>CONTRASEÑA:</label>
                <input type="password" name="usuario_contraseña" placeholder="Confirmar contraseña" required>
            </div>

            <div class="campo">
                <label>CORREO ELECTRONICO:</label>
                <input type="email" name="usuario_correo" placeholder="Correo electronico" required>
            </div>

            <div class="terminos">
                <input type="checkbox" id="terminos" required>
                <label for="terminos">ACEPTAR TERMINOS Y  CONDICIONES</label>
            </div>

            <button type="submit" class="boton">CREAR CUENTA</button>            
            <a href="Login.php" class="enlace-inicio">Volver al inicio</a>
        </div>
    </form>
</body>
</html>

