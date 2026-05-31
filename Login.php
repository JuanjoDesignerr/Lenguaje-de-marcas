
<?php
    //Para recordar al usuario en la web
    session_start();

     try{
            $error= "";
            $pdo = new PDO("mysql:host=localhost;dbname=poli_bd;charset=utf8", "root", "");
           
            //Comprobamos si el usuario ha enviado los tres campos obligatorios
            if (isset($_POST['usuario_nombre']) && isset($_POST['usuario_correo']) && isset($_POST['usuario_contraseña'])) {
                $nombre = $_POST['usuario_nombre'];
                $correo = $_POST['usuario_correo'];
                $pass   = $_POST['usuario_contraseña'];
                //Comprobamos si el correo ya existe
                $buscarCorreo = $pdo->prepare('SELECT * FROM usuarios WHERE correo = :correo');
                $buscarCorreo->execute([':correo' => $correo]);
                
                //Buscamos en la base de datos si hay alguien con ese nombre y ese correo
                $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE nombre = :nombre AND correo = :correo');
                $stmt->execute([
                    ':nombre' => $nombre,
                    ':correo' => $correo
                ]);

                //Traducimos el resultado a un array Clave -> Valor
                $usuarioLogueado = $stmt->fetch(PDO::FETCH_ASSOC);

                //Si coinciden el usuario con el correo vamos a comprobar la contraseña
                if ($usuarioLogueado) {
                    if ($pass == $usuarioLogueado['contrasena']) {
                        //Guardamos el nombre del usuario como una sesion abierta para recordarlo
                        $_SESSION['usuario_nombre'] = $usuarioLogueado['nombre'];
                    }
                    header("Location: index.html");
                    exit();
                } else {
                    $error = "El usuario introducido no existe, revise que los datos introducidos son correctos.";
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
    <title>Login</title>
    <link rel="stylesheet" href="css/cssLog.css">
</head>

<body>
    <form method="POST" action="Login.php">
    <section id="login">

        <div id="nombre">
         <h1>POLIDEPORTIVO ORIHUELA</h1>    
        </div>

        <div id="contenedor1">
            <h2>INICIO DE SESION</h2>
            <?php if (!empty($error)) {
                echo $error;
            } ?>
            <div class="campo">
                <label>USUARIO:</label>
                <input type="text" name="usuario_nombre" placeholder="Usuario">
            </div>

            <div class="campo">
                <label>CONTRASEÑA:</label>
                <input type="password" name="usuario_contraseña" placeholder="Contraseña">
            </div>

            <div class="campo">
                <label>CORREO ELECTRÓNICO:</label>
                <input type="email" name="usuario_correo" placeholder="ejemplo@gmail.com">
            </div>

            <a href="index.html"><button class="boton_login">INICIAR SESION</button></a>

            <a href="olvidar_contraseña.html">¿Has olvidado tu contraseña?</a>
            <a href="registrarse.php">No tienes cuenta, regístrate</a>
            
            <a href="admin.html" class="enlace-admin">Acceso administrador</a>
        </div>

    </section>
    </form>
</body>
</html>
