<?php 

require_once 'lib/login_sql.php'; 

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

                <?=mostrarErrores('errores_log', 'email');?>
                <label for="user">Usuario</label>
                <input type="email" name="user" id="user"/>

                <?=mostrarErrores('errores_log', 'password');?>
                <?=mostrarErrores('errores_log', 'not_verify');?>
                <label for="password">Contraseña</label>
                <input type="password" name="password" id="password" />

                <input type="submit" value="Ingresar" />

            </form>

        </div>

    <?php else : ?>
        
        <?php if($_SESSION['user']['access'] == 2) : ?>

            <?php header('Location: pages/inventario.php');?>

        <?php else :?>

            <?php header('Location: pages/altas.php');?>

        <?php endif; ?>

    <?php endif; ?>
    
    <?php require_once 'includes/footer.php';?>

</body>
</html>