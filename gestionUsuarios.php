<?php 
    $error = "";
     try{
            $pdo = new PDO("mysql:host=localhost;dbname=poli_bd;charset=utf8", "root", "");
           
            //Compruebo si ha enviado los datos y los almacenamos en variables.
            if (isset($_POST['usuario']) && isset($_POST['email']) && isset($_POST['contrasena']) && isset($_POST['rol_usuario'])) {
                $nombre = $_POST['usuario'];
                $correo = $_POST['email'];
                $pass = $_POST['contrasena'];
                $rol = $_POST['rol_usuario'];

                //Comprobamos si el correo ya existe
                $buscarCorreo = $pdo->prepare('SELECT * FROM usuarios WHERE correo = :correo');
                $buscarCorreo->execute([':correo' => $correo]);
                
                //Buscamos si por la clave correo=>'nuestrocorreo' en el cual el nuestro correo es el correo introducido
                $usuarioExistente = $buscarCorreo->fetch(PDO::FETCH_ASSOC);
                
                if($usuarioExistente) {
                    $error = "El correo ya existe prueba a introducir otro correo.";
                } else {

                    //Indicamos que hay un hueco reservado y despues en execute completamos el hueco.
                    $stmt = $pdo->prepare('INSERT INTO usuarios (nombre, correo, contrasena, rol) VALUES (:nombre, :correo, :pass, :rol);');
                    $stmt->execute([
                        ':nombre' => $_POST['usuario'],
                        ':correo' => $_POST['email'],
                        ':pass' => $_POST['contrasena'],
                        ':rol' => $_POST['rol_usuario']
                        
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
    <title>Document</title>
    <link rel="stylesheet" href="css/cssGestion.css">

</head>

<body>
        <nav>
        <h1><a href="index.html">Polideportivo Orihuela</a></h1>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="admin.php">Panel Admin</a></li>
            <li><a href="gestionUsuarios.php">Gestión Usuarios</a></li>
            <li><a href="cerrarSesion.php">Cerrar Sesión</a></li>
        </ul>
    </nav>


    <div class="pagina-titulo">
        <h2>GESTIÓN DE USUARIOS</h2>
        <p>Inserta, modifica, elimina y consulta usuarios del sistema</p>
    </div>

    <div class="contenedor-principal">

    <div class="tarjeta">
        <h3 class="tarjeta-titulo insertar-titulo">INSERTAR NUEVO USUARIO</h3>
        <form method="POST" action="gestionUsuarios.php">
                <?php if (!empty($error)) {
                    echo $error; 
                    }   
                ?>
            <div class="campo">
                <label>NOMBRE DE USUARIO:</label>
                <input type="text" name="usuario" placeholder="Nombre de usuario" required>
            </div>
            <div class="campo">
                <label>CORREO ELECTRÓNICO:</label>
                <input type="email" name="email" placeholder="ejemplo@correo.com" required>
            </div>
            <div class="campo">
                <label>CONTRASEÑA:</label>
                <input type="password" name="contrasena" placeholder="Contraseña" required>
            </div>
            <div class="campo">
                <label>ROL:</label>
                <select name="rol_usuario" required>
                    <option value="usuario">usuario</option>
                    <option value="admin">admin</option>
                </select>
            </div>
            <button type="submit" name="insertar" class="btn-insertar">INSERTAR USUARIO</button>
        </form>
    </div>

    <?php 
        $error_modificar = "";
        $exito_modificar = "";

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['actualizar'])) {
            $correo_buscar = $_POST['correo_buscar'];

            try{
                $pdo = new PDO("mysql:host=localhost;dbname=poli_bd;charset=utf8", "root", "");
                $stmtCheck = $pdo->prepare("SELECT * FROM usuarios WHERE correo = :correo");
                $stmtCheck->execute([':correo' => $correo_buscar]);
                $datosUsuario = $stmtCheck->fetch(PDO::FETCH_ASSOC);

                if (!$datosUsuario) {
                    // Si el correo no existe en la BD mandamos un mensaje.
                    $error_modificar = "Error: No se encontró ningún usuario con el correo '$correo_buscar'.";
                } else {

                    //Comprobamos que las variables estan rellenadas para sustituirlas con el 
                    // nuevo dato sino se quedan con el que habia en la BD
                    if (!empty($_POST['nuevo_nombre'])) {
                        $nuevo_nombre = $_POST['nuevo_nombre']; 
                    } else {
                        $nuevo_nombre = $datosUsuario['nombre']; 
                    }

                    if (!empty($_POST['nuevo_correo'])) {
                        $nuevo_correo = $_POST['nuevo_correo'];
                    } else {
                        $nuevo_correo = $datosUsuario['correo'];
                    }

                    if (!empty($_POST['nueva_contrasena'])) {
                         $nueva_pass = $_POST['nueva_contrasena'];
                    } else {
                        $nueva_pass = $datosUsuario['contrasena'];
                    }

                    if (!empty($_POST['nuevo_rol'])) {
                        $nuevo_rol = $_POST['nuevo_rol'];
                    } else {
                        $nuevo_rol = $datosUsuario['rol'];
                    }

                    $sql = "UPDATE usuarios SET nombre = :nombre, correo = :nuevo_correo, contrasena = :pass, rol = :rol 
                    WHERE correo = :correo_actual";

                    $stmtUpdate = $pdo->prepare($sql);
                    $stmtUpdate->execute([
                        ':nombre'        => $nuevo_nombre,
                        ':nuevo_correo'  => $nuevo_correo,
                        ':pass'          => $nueva_pass,
                        ':rol'           => $nuevo_rol,
                        ':correo_actual' => $correo_buscar
                    ]);

                    $exito_modificar = "El usuario con correo '$correo_buscar' ha sido modificado correctamente.";

                }

            } catch (PDOException $e) {
                $error_modificar="error en la base de datos". $e->getmessage();
            }


        }
    ?>

 

    <div class="tarjeta">
        <h3 class="tarjeta-titulo actualizar-titulo">MODIFICAR USUARIO</h3>
        <form method="POST" action="gestionUsuarios.php">
            <div class="campo">
                <?php if (!empty($error_modificar)) {
                    echo $error_modificar; 
                    }   
                ?>
                <label>CORREO DEL USUARIO</label>
                <input type="email" name="correo_buscar" placeholder="Introduzca el correo del usuario">
            </div>
            <div class="campo">
                <label>NUEVO NOMBRE DE USUARIO:</label>
                <input type="text" name="nuevo_nombre" placeholder="Nuevo nombre">
            </div>
            <div class="campo">
                <label>NUEVO CORREO:</label>
                <input type="email" name="nuevo_correo" placeholder="Nuevo correo">
            </div>
            <div class="campo">
                <label>NUEVA CONTRASEÑA:</label>
                <input type="password" name="nueva_contrasena" placeholder="Nueva contraseña">
            </div>
            <div class="campo">
                <label>NUEVO ROL:</label>
                <select name="nuevo_rol">
                    <option value="usuario">usuario</option>
                    <option value="admin">admin</option>
                </select>
            </div>
            <button type="submit" name="actualizar" class="btn-actualizar">MODIFICAR USUARIO</button>
        </form>
   
    </div>


        <?php 
            $error_eliminar="";
            $exito_eliminar="";
            // Comprobamos que el administrador ha pulsado el botón de eliminar y ha enviado el correo.
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['eliminar'])) {

                if (!empty($_POST['usuario_correo'])) {
                    $correo_a_borrar = $_POST['usuario_correo'];
                }
            
                try {
                    $pdo = new PDO("mysql:host=localhost;dbname=poli_bd;charset=utf8", "root", "");
                    
                    $stmtDelete = $pdo->prepare("DELETE FROM usuarios WHERE correo = :correo");
                    $stmtDelete->execute([':correo' => $correo_a_borrar]);

                    //Si las columnas afectadas son mayores que 0 se habra eliminado correctamente.
                    if ($stmtDelete->rowCount() > 0) {
                        $exito_eliminar = "El usuario con correo con .'$correo_a_borrar' ha sido eliminado correctamente.";
                    } else {
                        $error_eliminar = "El correo introducido no es correcto";
                    }

                } catch(PDOException $e) {
                    $e->getMessage();
                }

            }

        ?>


        <div class="tarjeta">
            <h3 class="tarjeta-titulo eliminar-titulo">ELIMINAR USUARIO</h3>
            <form method="POST" action="">
                <div class="campo">
                    <label>CORREO DEL USUARIO:</label>
                    <input type="email" name="usuario_correo" placeholder="ejmplo@gmail.com" required> 
                <?php if (!empty($error_eliminar)) {
                    echo $error_eliminar; 
                    } else {
                        echo $exito_eliminar;
                    }   
                ?>
                </div>
                <button type="submit" name="eliminar" class="btn-eliminar">ELIMINAR USUARIO</button>
            </form>
        </div>
    </div>

        <tbody>
    
</tbody>

    <div class="contenedor-tabla">
        <div class="tabla-cabecera">
            <h3>CONSULTAR USUARIOS</h3>
            <a href="gestionUsuarios.php" class="btn-actualizar">ACTUALIZAR</a>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>USUARIO</th>
                    <th>EMAIL</th>
                    <th>CONTRASEÑA</th>
                    <th>ROL</th>
                    <th>FECHA REGISTRO</th>
                </tr>
            </thead>
            <tbody>
                <?php
                try {
                    $pdo = new PDO("mysql:host=localhost;dbname=poli_bd;charset=utf8", "root", "");
                    
                    //Traemos todos los campos
                    $stmt = $pdo->query("SELECT * FROM usuarios");
                    
                    //El bucle recorre la BD y va pintando las celdas ordenadamente en su sitio
                    while ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>
                                <td>{$user['nombre']}</td>
                                <td>{$user['correo']}</td>
                                <td>{$user['contrasena']}</td>
                                <td>{$user['rol']}</td>
                                <td>{$user['fecha_registro']}</td>
                              </tr>";
                    }
                } catch (PDOException $e) {
                    echo "Error al consultar la tabla". $e->getMessage();
                }
                ?>
            </tbody>
        </table>
    </div>

     <footer>
        <div class="footer">
            <h3>Orihuela</h3>
            <p>Tel. 965.123.456</p>
            <p>Email: <a href="#">orihuela@polideportivo.es</a></p>
            <p>C/ Valencia, 47</p>
        </div>
        <div class="footer">
            <h3>Alicante</h3>
            <p>Tel. 965.234.567</p>
            <p>Email: <a href="#">alicante@polideportivo.es</a></p>
            <p>C/ Mayor, 12</p>
        </div>
        <div class="footer">
            <h3>Murcia</h3>
            <p>Tel. 968.345.678</p>
            <p>Email: <a href="#">murcia@polideportivo.es</a></p>
            <p>C/ Gran Vía, 8</p>
        </div>
    </footer>

</body>
</html>