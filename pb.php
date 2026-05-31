<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
  
</body>
</html>

    <?php 
     
        try{
            $pdo = new PDO("mysql:host=localhost;dbname=poli_bd;charset=utf8", "root", "");
            echo "Conectado correctamente". "<br/>";
            $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE nombre like :nombre');
            $stmt->execute(array(':nombre' => "Juan%" ));

            while( $datos = $stmt->fetch(PDO::FETCH_ASSOC) ) {
                foreach($datos as $key => $value) {
                    echo $value . ' ';
                }
            }   

        } catch(PDOException $e) {
        
        echo "error conectando con la base de datos:" . $e->getMessage();
        
        }
    ?>