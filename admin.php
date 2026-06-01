<?php  
    session_start();
    $error = "";
    try {
       //En caso de que accedamos mediante url el usuario no habra iniciado sesion por lo que le hecharemos.
        if (!isset($_SESSION['usuario_nombre']) && !isset($_SESSION['admin_usuario'])) {
            header("Location: Login.php");
            exit();
        }

        $pdo = new PDO("mysql:host=localhost;dbname=poli_bd;charset=utf8", "root", "");
        
        if (isset($_POST['admin_nombre']) && isset($_POST['admin_contrasena'])) {
            $nombre = $_POST['admin_nombre'];
            $pass = $_POST['admin_contrasena'];
            
            // Buscamos al usuario por su nombre
            $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE nombre = :nombre');
            $stmt->execute([':nombre' => $nombre]);
           
            // Extrae el registro encontrado como un array asociativo (clave-valor). Si no hay coincidencia, devuelve false.
            $usuarioLogueado = $stmt->fetch(PDO::FETCH_ASSOC);

            // Si el usuario existe, la contraseña coincide Y además su rol es 'admin'
            if ($usuarioLogueado && $pass == $usuarioLogueado['contrasena'] && $usuarioLogueado['rol'] == 'admin') {
                
                // Si cumple las TRES cosas a la vez, guardamos sesión y entra
                $_SESSION['admin_nombre'] = $usuarioLogueado['nombre'];
                header("Location: gestionUsuarios.html"); 
                exit();
            } else {
                $error = "Error el usuario o la contraseña no son correctos, revise sus permisos.";
            }
        }

    //Excepción en caso de que la conexion no se realize.
    } catch (PDOException $e) {
        $error = "Error conectando con la base de datos:" . $e->getMessage();
    }
     
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
</head>
<body>
    <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Administrador</title>
    <link rel="stylesheet" href="css/cssAdminLogin.css">
</head>
<body>
    <form action="admin.php" method="POST">
        <h1>POLIDEPORTIVO ORIHUELA</h1>

        <div id="contenedor">
            <h2>ACCESO ADMINISTRADOR</h2>

            <?php if (!empty($error)) {
                    echo $error; 
                    }   
                ?>

            <div class="campo">
                <label>USUARIO:</label>
                <input type="text" name="admin_nombre" placeholder="Usuario administrador" required>
            </div>

            <div class="campo">
                <label>CONTRASEÑA:</label>
                <input type="password" name="admin_contrasena" placeholder="Contraseña" required>
            </div>

            <button type="submit" class="boton">ENTRAR AL PANEL</button>
            <a href="Login.php" class="enlace">Volver al login</a>
        </div>
    </form>

</body>
</html>

