<?php

    session_start();

    //En caso de que accedamos mediante url el usuario no habra iniciado sesion por lo que le hecharemos.
    if (!isset($_SESSION['usuario_nombre'])) {
        header("Location: Login.php");
        exit();
    }

    $error="";
    $exito ="";
    //En el array asociativo comprobamos el nombre actual del usuario y lo guardamos en una variable.
    $nombre_actual = $_SESSION['usuario_nombre'];

    try {
        $pdo = new PDO("mysql:host=localhost;dbname=poli_bd;charset=utf8", "root", "");

        //Buscamos los datos actuales del usuario.
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE nombre = :nombre");
        $stmt->execute([':nombre' => $nombre_actual]);
        $datosUsuario = $stmt->fetch(PDO::FETCH_ASSOC);

        //Solo entrariamos al guardar los cambios. Esta comprobacion es porque el php se ejecuta primero y tenemos
        //  que comprobar que estamos en get ya que al pinchar en actualizar perfil estamos haciendo post.
        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            //Comprobamos el si ha esccrito el usuario al guardar los cambios sino se deja tal cual estaban en la BD.
            if (!empty($_POST['nuevo_nombre'])) {
                // Si el usuario ha escrito algo, usamos el dato nuevo del formulario
                $nuevo_nombre = $_POST['nuevo_nombre'];
            } else {
                // Si lo ha dejado vacío, recogemos el nombre que hay en la BD. Para que no se quede vacio el campo o null.
                $nuevo_nombre = $datosUsuario['nombre'];
            }

            //Comprobamos la contraseña.
            if (!empty($_POST['nueva_contrasena'])) {
                // Si ha escrito una contraseña nueva, la usamos
                $nueva_pass = $_POST['nueva_contrasena'];
            } else {
                // Si no ha escrito nada, mantenemos su contraseña actual de la BD
                $nueva_pass = $datosUsuario['contrasena'];
            }

            //Comprobamos el correo.
            if (!empty($_POST['nuevo_correo'])) {
                // Si ha puesto un correo nuevo, lo usamos
                $nuevo_correo = $_POST['nuevo_correo'];
            } else {
                // Si lo ha dejado en blanco, mantenemos el correo que ya tenía en la BD
                $nuevo_correo = $datosUsuario['correo'];
            }

            //Actualizamos los datos.
            $sql = "UPDATE usuarios SET nombre = :nuevo_nombre, contrasena = :nueva_pass, correo = :nuevo_correo WHERE correo = :correo_actual";
            $stmtUpdate = $pdo->prepare($sql);
            $stmtUpdate->execute([
            ':nuevo_nombre'  => $nuevo_nombre,
            ':nueva_pass'    => $nueva_pass,
            ':nuevo_correo'  => $nuevo_correo,
            ':correo_actual' => $datosUsuario['correo']
            ]);
            
            //Actualizamos el neuvo nombre de la sesion actual.
            $_SESSION['usuario_nombre'] = $nuevo_nombre;

            $exito = "Tus datos han sido actualizados correctamente.";

        }

    } catch (PDOException $e) {
        $error = "Error con la base de datos: " . $e->getMessage();
    }

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil Usuario</title>
    <link rel="stylesheet" href="css/cssPerfil.css">

</head>
<body>
      <nav>
        <h1><a href="index.html">Polideportivo Orihuela</a></h1>
        <ul>
            <li><a href="index.html">Inicio</a></li>
            <li><a href="pistas.html">Ver Pistas</a></li>
            <li><a href="perfil.html">Ver Perfil</a></li>
            <li><a href="Login.html">Cerrar Sesión</a></li>
        </ul>
    </nav>
    
    <div id="contenedor">
        <div id="cabecera">
            <a href="index.html"><button class="boton">VOLVER</button></a>
            <h2>Actualiza tus Datos</h2>
        </div>

        <div id="contenido">
            <div id="foto">
                <img src="imagenes/fotoPerfil.jpg" alt="Foto de perfil">
                <button class="btn">CAMBIAR FOTO</button>
            </div>
            
            <form method="post" action="perfil.php">
                <div id="informacion">
                    <h3>Datos a cambiar</h3>


                     <div class="campo">
                        <label>USUARIO</label>
                        <input type="text" name="nuevo_nombre" placeholder="Nuevo Nombre" required>
                    </div>

                    <div class="campo">
                        <label>CONTRASEÑA</label>
                        <input type="password" name="nueva_contrasena" placeholder="Nueva contraseña" required>
                    </div>
                    <div class="campo">
                        <label>CORREO</label>
                        <input type="email" name="nuevo_correo" placeholder="Nuevo tu email" required>
                    </div>
                    <button class="boton_guardar">GUARDAR CAMBIOS</button>            
                </div>
            </form>
        </div>
    </div>
    
</body>
</html>

