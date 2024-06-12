<?php
require_once 'includes/conexion.php';
require_once 'lib/login_sql.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css" type="text/css" />
    <title>Inicio</title>
</head>
<body>

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
    </header>

    <div class="container">

        <?php if($_SESSION['login'] == true) : ?>

            <?php while($user = mysqli_fetch_assoc($select_query)): ?>

                <h1>Bienvenido al inventario <?=$user['nombre']?> <?=$user['apellido']?></h1>

            <?php endwhile; ?>
        
        <?php else : ?>

            <form action="lib/login_sql.php" method="POST">
            
                <label for="user">Usuario</label>
                <input type="text" id="user" name="user" />

                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" />

                <input type="submit" value="Ingresar" />

            </form>

        <?php endif; ?>

    </div>

</body>
</html>