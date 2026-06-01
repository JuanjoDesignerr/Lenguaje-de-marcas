<?php
session_start();
session_destroy(); 

header("Location: Login.php"); // Redirigimos al usuario al Login
exit();
?>