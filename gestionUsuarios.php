<?php
session_start();


// Si el usuario no ha iniciado sesion, no puede entrar.
if (!isset($_SESSION['admin_nombre']) && !isset($_SESSION['admin_usuario'])) {
    header("Location: Login.php");
    exit();
}
?>

<?php 
        try{
            $pdo = new PDO("mysql:host=localhost;dbname=poli_bd;charset=utf8", "root", "");
            
            $nombre_modificar = "";
            $contrasena_modificar = "";
            $rol_modificar = "";


            if (isset($_POST['modificar_usuario'])) {
                $correo_a_buscar = $_POST['modificar_usuario'];
            
                $stmt_buscar = $pdo->prepare("SELECT nombre, contrasena, rol FROM usuarios WHERE correo = :correo");
                $stmt_buscar->execute([':correo' => $correo_a_buscar]);
                $usuario_encontrado = $stmt_buscar->fetch(PDO::FETCH_ASSOC);
                
                if ($usuario_encontrado) {
                    $nombre_modificar = $usuario_encontrado['nombre'];
                    $contrasena_modificar = $usuario_encontrado['contrasena'];
                    $rol_modificar = $usuario_encontrado['rol'];
                }
            }

        } catch(PDOException $e) {
            echo "Error" . $e->getMessage();
        }
?>

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
                <input type="email" name="correo_buscar" placeholder="Introduzca el correo del usuario" value="<?php 
                if (isset($_POST['modificar_usuario'])) { 
                    echo $_POST['modificar_usuario']; 
                } ?>">

            </div>
            <div class="campo">
                <label>NUEVO NOMBRE DE USUARIO:</label>
                <input type="text" name="nuevo_nombre" placeholder="Nuevo nombre" value="<?php 
                if (isset($_POST['modificar_usuario'])) { 
                    echo $nombre_modificar; 
                } else {
                    echo "";
                } ?>">  

            </div>
            <div class="campo">
                <label>NUEVO CORREO:</label>
                <input type="email" name="nuevo_correo" placeholder="Nuevo correo" value="<?php 
                if (isset($_POST['modificar_usuario'])) { 
                    echo $_POST['modificar_usuario']; 
                } ?>">

            </div>
            <div class="campo">
                <label>NUEVA CONTRASEÑA:</label>
                <input type="password" name="nueva_contrasena" placeholder="Nueva contraseña" value="<?php 
                if (isset($_POST['modificar_usuario'])) { 
                    echo $contrasena_modificar; 
                } else {
                    echo "";
                } ?>">

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
                    <input type="email" name="usuario_correo" placeholder="ejmplo@gmail.com" required value="
                <?php
                if (isset($_POST['eliminar_usuario'])) { 
                    echo $_POST['eliminar_usuario']; 
                } ?>">
                
                <?php 
                    if (!empty($error_eliminar)) {
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

    <?php
        // Cuántos usuarios queremos ver por página
        $limite = 3;

        // Miramos en qué página estamos (si no han pulsado nada, empezamos en la 1)
        if (isset($_POST["pagina"])) {
            $pagina = (int)$_POST["pagina"];
        } else {
            $pagina = 1;
        }

        try {
            $pdo = new PDO("mysql:host=localhost;dbname=poli_bd;charset=utf8", "root", "");

            $total_usuarios = 0;
            // Contamos los usuarios uno a uno con el bucle
            if (isset($_POST['texto_buscar']) && !empty($_POST['texto_buscar'])) {
            $buscar = $_POST['texto_buscar'];

            $sql_contar = "SELECT COUNT(*) FROM usuarios WHERE nombre LIKE :palabra OR correo LIKE :palabra OR rol LIKE :palabra";
            $stmt_contar = $pdo->prepare($sql_contar);
            $stmt_contar->execute([':palabra' => '%' . $buscar . '%']);
                
            while ($stmt_contar->fetch()) {
                $total_usuarios++; 
            }         

            } else {

                $contador_stmt = $pdo->query("SELECT * FROM usuarios");
                $total_usuarios = 0;
                while ($contador_stmt->fetch()) {
                    $total_usuarios++; 
                }
            }

            /*
            Calculamos cuántas páginas hacen falta en total.
            Si tenemos 7 usuarios y van de 3 en 3:
            7 / 3 = 2 páginas enteras. El resto % es 1 (sobra un usuario).
            Como sobra un usuario, el IF le suma 1 página más. Total = 3 páginas.
            */
            $total_paginas = (int)($total_usuarios / $limite); 
            if (($total_usuarios % $limite) > 0) {
                $total_paginas++; 
            }
            

            //Logica botones (Ahora que $total_paginas ya existe, no dará error)
            
            //Controlamos que al avanzar no nos pasemos de la última página existente
            if (isset($_POST["siguiente"]) && $pagina < $total_paginas) {
                $pagina++;
            }

            if (isset($_POST["anterior"]) && $pagina > 1) {
                $pagina--;
            }

            if (isset($_POST["primera"])) {
                $pagina = 1;
            }

            // Si pulsan ">>", asignamos directamente el total de páginas que calculamos arriba
            if (isset($_POST["ultima"])) {
                $pagina = $total_paginas;
            }

            // Ej en pág 3: (3 * 3) - 3 = 6. SQL saltará los primeros 6 registros.
            $inicio = ($pagina * $limite) - $limite;

            

        } catch (PDOException $e) {
            echo 'Error con la base de datos: ' . $e->getMessage();
        }
    ?>

    <div class="contenedor-tabla">
        <div class="tabla-cabecera">
            <h3>CONSULTAR USUARIOS</h3>

            <a href="gestionUsuarios.php" class="btn-actualizar">ACTUALIZAR</a>
        </div>

        <form method="POST" action="gestionUsuarios.php">
            <label>BUSCADOR:</label>
            <input type="text" name="texto_buscar" placeholder="texto" value="<?php 
            if (isset($_POST['texto_buscar'])) { 
                echo $_POST['texto_buscar']; 
            } ?>">
        


            <table>
                <thead>
                    <tr>
                        <th>USUARIO</th>
                        <th>EMAIL</th>
                        <th>CONTRASEÑA</th>
                        <th>ROL</th>
                        <th>FECHA REGISTRO</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    try {
                        $pdo = new PDO("mysql:host=localhost;dbname=poli_bd;charset=utf8", "root", "");
                        
                        
                        //comprobacion de que el usuario haya escrito en el filtro y no este vacio.
                        if(isset($_POST['texto_buscar']) && !empty($_POST['texto_buscar'])) {
                            $buscar = $_POST['texto_buscar'];

                            
                            $sql = "SELECT * FROM usuarios WHERE nombre LIKE :palabra OR correo LIKE :palabra OR rol LIKE :palabra LIMIT $inicio, $limite";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute([':palabra' => '%' . $buscar . '%']);

                            } else {

                            //Traemos todos los campos
                            $stmt = $pdo->query("SELECT * FROM usuarios LIMIT $inicio, $limite");

                        }
                        
                        //El bucle recorre la BD y va pintando las celdas ordenadamente en su sitio
                        while ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>
                                    <td>{$user['nombre']}</td>
                                    <td>{$user['correo']}</td>
                                    <td>{$user['contrasena']}</td>
                                    <td>{$user['rol']}</td>
                                    <td>{$user['fecha_registro']}</td>
                                    <td>
                                    <button type='submit' name='eliminar_usuario' value='{$user['correo']}' class='btn-eliminar'>Eliminar</button>
                                    </td>
                                    <td>
                                    <button type='submit' name='modificar_usuario' value='{$user['correo']}' class='btn-modificar'>Modificar</button>
                                    </td>
                                </tr>";
                        }
                    } catch (PDOException $e) {
                        echo "Error al consultar la tabla". $e->getMessage();
                    }
                    ?>
                </tbody>
            </table>
            
            <div id="paginador">
            
                    
            <input type="submit" name="primera" value="<<">
            
            <input type="submit" name="anterior" value="<">
            
            <input type="number" name="pagina" value="<?php echo $pagina; ?>">
            
            <input type="submit" name="siguiente" value=">">

            <input type="submit" name="ultima" value=">>">
        
        </form>
        </div>

      

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