<?php
session_start();

// Si el usuario no ha iniciado sesion, no puede entrar.
if (!isset($_SESSION['usuario_nombre']) && !isset($_SESSION['admin_usuario'])) {
    header("Location: Login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina principal</title>
    <link rel="stylesheet" href="css/cssIndex.css">
</head>
<body>
    <nav>
        <h1><a href="index.html">Polideportivo Orihuela</a></h1>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="pistas.php">Ver Pistas</a></li>
            <li><a href="reservas.php">Reservas</a></li>
            <li><a href="perfil.php">Actualizar</a></li>
            <li><a href="cerrarSesion.php">Cerrar Sesion</a></li>
        </ul>
    </nav>

    <div class="cabecera">
        <div class="cabecera-contenido">
            <h2>Bienvenido al Polideportivo Orihuela</h2>
            <p>Las mejores instalaciones deportivas de la región. Reserva tu pista favorita de forma rápida y sencilla.</p>
            <div class="cabecera-botones">
                <a href="pistas.html"><button class="btn-cabecera-principal">Ver Nuestras Pistas</button></a>
                <a href="reservas.html"><button class="btn-cabecera-secundario">Hacer una Reserva</button></a>
            </div>
        </div>
    </div>

    <section class="datos-rapidos">
        <div class="dato">
            <span class="dato-numero">5</span>
            <span class="dato-texto">Pistas disponibles</span>
        </div>
        <div class="dato">
            <span class="dato-numero">7</span>
            <span class="dato-texto">Días a la semana</span>
        </div>
        <div class="dato">
            <span class="dato-numero">09:00</span>
            <span class="dato-texto">Apertura diaria</span>
        </div>
        <div class="dato">
            <span class="dato-numero">21:00</span>
            <span class="dato-texto">Cierre diario</span>
        </div>
    </section>

     <section class="seccion-titulo">
        <h2>NUESTRAS PISTAS</h2>
        <p>Contamos con instalaciones de primer nivel para todos los deportes</p>
    </section>

    <section class="deportes">
        <img src="imagenes/pistaDeFutbol.jpg" alt="Pista de fútbol">
        <div class="texto">
            <h2>Pista de Fútbol</h2>
            <p>Espacio amplio con césped artificial de última generación y marcas reglamentarias. Iluminación nocturna, porterías con red y vallas perimetrales. Capacidad para hasta 22 jugadores.</p>
            <div class="info-pista">
                <span class="badge">22 jugadores</span>
                <span class="badge">Césped artificial</span>
                <span class="badge">Iluminación nocturna</span>
            </div>
            <div class="botones">
                <a href="pistas.html"><button>Ver más info</button></a>
                <a href="reservas.html"><button class="btn-reservar">Reservar ahora</button></a>
            </div>
        </div>
    </section>

     <section class="deportes deportes-inverso">
        <img src="imagenes/pistaBaloncesto.jpg" alt="Pista de baloncesto">
        <div class="texto">
            <h2>Pista de Baloncesto</h2>
            <p>Pista interior con parqué de alta calidad y canastas regulables. Perfecta para partidos y entrenamientos. Climatización y vestuarios incluidos.</p>
            <div class="info-pista">
                <span class="badge">10 jugadores</span>
                <span class="badge">Interior</span>
                <span class="badge">Parqué</span>
            </div>
            <div class="botones">
                <a href="pistas.html"><button>Ver más info</button></a>
                <a href="reservas.html"><button class="btn-reservar">Reservar ahora</button></a>
            </div>
        </div>
    </section>

    <section class="deportes">
        <img src="imagenes/pistaTennis.jpg" alt="Pista de tenis">
        <div class="texto">
            <h2>Pista de Tenis</h2>
            <p>Superficie de tierra batida con red reglamentaria. Disponible todo el año al aire libre con zona de descanso para los jugadores y acceso a vestuarios.</p>
            <div class="info-pista">
                <span class="badge">2-4 jugadores</span>
                <span class="badge">Tierra batida</span>
                <span class="badge">Exterior</span>
            </div>
            <div class="botones">
                <a href="pistas.html"><button>Ver más info</button></a>
                <a href="reservas.html"><button class="btn-reservar">Reservar ahora</button></a>
            </div>
        </div>
    </section>

    <div class="ver-todas">
        <a href="pistas.html"><button class="btn-ver-todas">Ver todas las pistas →</button></a>
    </div>

     <section class="como-reservar">
        <h2>¿CÓMO HACER UNA RESERVA?</h2>
        <p>Reservar una pista es muy sencillo, sigue estos 3 pasos</p>
        <div class="pasos">
            <div class="paso">
                <span class="paso-numero">1</span>
                <h3>Elige tu pista</h3>
                <p>Selecciona el deporte y la pista que más te convenga entre todas nuestras instalaciones.</p>
            </div>
            <div class="paso">
                <span class="paso-numero">2</span>
                <h3>Escoge fecha y hora</h3>
                <p>Consulta la disponibilidad y elige el día y la franja horaria que mejor se adapte a ti.</p>
            </div>
            <div class="paso">
                <span class="paso-numero">3</span>
                <h3>Confirma y paga</h3>
                <p>Introduce tus datos, realiza el pago y recibirás la confirmación de tu reserva al instante.</p>
            </div>
        </div>
        <a href="reservas.html"><button class="btn-reserva-grande">Hacer mi reserva ahora</button></a>
    </section>

      <section id="calendario">
        <h3>HORARIOS DE DISPONIBILIDAD</h3>
        <p class="calendario-sub">Haz clic en cualquier hora para reservar directamente</p>
        <table>
            <thead>
                <tr>
                    <th>LUNES</th>
                    <th>MARTES</th>
                    <th>MIÉRCOLES</th>
                    <th>JUEVES</th>
                    <th>VIERNES</th>
                    <th>SÁBADO</th>
                    <th>DOMINGO</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><a href="reservas.html"><button class="hora">09:00</button></a></td>
                    <td><a href="reservas.html"><button class="hora">09:00</button></a></td>
                    <td><a href="reservas.html"><button class="hora">09:00</button></a></td>
                    <td><a href="reservas.html"><button class="hora">09:00</button></a></td>
                    <td><a href="reservas.html"><button class="hora">09:00</button></a></td>
                    <td><a href="reservas.html"><button class="hora">09:00</button></a></td>
                    <td><a href="reservas.html"><button class="hora">09:00</button></a></td>
                </tr>
                <tr>
                    <td><a href="reservas.html"><button class="hora">11:00</button></a></td>
                    <td><a href="reservas.html"><button class="hora">11:00</button></a></td>
                    <td><a href="reservas.html"><button class="hora">11:00</button></a></td>
                    <td><a href="reservas.html"><button class="hora">11:00</button></a></td>
                    <td><a href="reservas.html"><button class="hora">11:00</button></a></td>
                    <td><a href="reservas.html"><button class="hora">11:00</button></a></td>
                    <td><a href="reservas.html"><button class="hora">11:00</button></a></td>
                </tr>
                <tr>
                    <td><a href="reservas.html"><button class="hora">19:00</button></a></td>
                    <td><a href="reservas.html"><button class="hora">19:00</button></a></td>
                    <td><a href="reservas.html"><button class="hora">19:00</button></a></td>
                    <td><a href="reservas.html"><button class="hora">19:00</button></a></td>
                    <td><a href="reservas.html"><button class="hora">19:00</button></a></td>
                    <td><a href="reservas.html"><button class="hora">19:00</button></a></td>
                    <td><a href="reservas.html"><button class="hora">19:00</button></a></td>
                </tr>
                <tr>
                    <td><a href="reservas.html"><button class="hora">21:00</button></a></td>
                    <td><a href="reservas.html"><button class="hora">21:00</button></a></td>
                    <td><a href="reservas.html"><button class="hora">21:00</button></a></td>
                    <td><a href="reservas.html"><button class="hora">21:00</button></a></td>
                    <td><a href="reservas.html"><button class="hora">21:00</button></a></td>
                    <td><a href="reservas.html"><button class="hora">21:00</button></a></td>
                    <td><a href="reservas.html"><button class="hora">21:00</button></a></td>
                </tr>
            </tbody>
        </table>
    </section>

     <section class="por-que">
        <h2>¿POR QUÉ ELEGIRNOS?</h2>
        <div class="razones">
            <div class="razon">
                <h3>Instalaciones modernas</h3>
                <p>Todas nuestras pistas están equipadas con material de primera calidad y mantenimiento diario.</p>
            </div>
            <div class="razon">
                <h3>Reserva fácil</h3>
                <p>Reserva tu pista en menos de 2 minutos desde cualquier dispositivo, sin complicaciones.</p>
            </div>
            <div class="razon">
                <h3>Tres ubicaciones</h3>
                <p>Presentes en Orihuela, Alicante y Murcia para que siempre tengas una instalación cerca.</p>
            </div>
            <div class="razon">
                <h3>Abierto todos los días</h3>
                <p>De lunes a domingo de 9:00 a 21:00. No hay excusa para no hacer deporte.</p>
            </div>
        </div>
    </section>

    <section class="panel-reservas">
        <h3>RESERVAS REGISTRADAS PARA HOY</h3>
        <p class="panel-sub">Lista en tiempo real de las pistas ocupadas</p>
        
        <div class="tabla-contenedor">
            <table class="tabla-reservas">
                <thead>
                    <tr>
                        <th>Pista / Deporte</th>
                        <th>Usuario</th>
                        <th>Horario Reservado</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Pista de Fútbol</td>
                        <td class="usuario-nombre">Carlos Gómez</td>
                        <td>09:00</td>
                    </tr>
                    <tr>
                        <td>Pista de Baloncesto</td>
                        <td class="usuario-nombre">María López</td>
                        <td>11:00</td>
                    </tr>
                    <tr>
                        <td>Pista de Tenis</td>
                        <td class="usuario-nombre">Juan Martínez</td>
                        <td>19:00</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
    
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