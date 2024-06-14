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

        <div class="container-login">

            <form id="from-login" action="lib/login_sql.php" method="POST">

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
                <a href="pages/inventario.php">
                    <img src="assets/img-inventario.png" alt="imagen de inventario" />
                </a>
                <a href="pages/registro.php">
                    <img src="assets/img-registro.png" alt="imagen de registro" />
                </a>
                <a href="#">
                    <img src="assets/img-inventario.png" alt="imagen de inventario" />
                </a>
                <a href="#">
                    <img src="assets/img-inventario.png" alt="imagen de inventario" />
                </a>
            </ul>

            <div class="container-login">
                <h1>Bienvenido, <?=$_SESSION['user']['nombre'];?> <?=$_SESSION['user']['apellido'];?></h1>
                <a href="includes/cerrar_login.php">X</a>
            </div>
        </header>

    <?php endif; ?>
    


</body>
</html>