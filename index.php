<?php 

require_once 'lib/login_sql.php'; 
require_once 'includes/conexion.php';

if(!isset($_SESSION)) {

    session_start();
};
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css" type="text/css" />
    <title>Inicio</title>
</head>
<body>

    

    <?php if(!isset($_SESSION['user'])) :?>

        <div class="container container-login">

            <h1>Inventario - <span class="title">Skytel</span> Avanza <span class="title">Uruguay</span></h1>

            <form id="form-login" action="lib/login_sql.php" method="POST">

                <label for="user">Usuario</label>
                <input type="email" name="user" id="user"/>

                <label for="password">Contraseña</label>
                <input type="password" name="password" id="password" />

                <input type="submit" value="Ingresar" />

            </form>

        </div>

    <?php else : ?>    

        <header class="header">
            <ul class="list">
            <li><a href="pages/inventario.php">Inventario</a></li>
            <li><a href="pages/registro.php">Registro</a></li>
            <li><a href="#">Altas de equipos</a></li>
            <li><a href="#">Bajas de equipos</a></li>
            </ul>
        </header>

        <div class="container">
            <h1>Bienvenido, <?=$_SESSION['user']['nombre'];?> <?=$_SESSION['user']['apellido'];?></h1>
            <a href="includes/cerrar_login.php">X</a>
        </div>

    <?php endif; ?>
    


</body>
</html>