<?php

require_once '../includes/conexion.php';
require_once '../lib/modificar_sql.php';

if(!isset($_SESSION['user'])) {

    header('Location: ../index.php');
}

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css" type="text/css" />
    <title>Modificar</title>
</head>
<body>

    <header class="header">
        <div class="user">
            <h1 class="name">Bienvenido, <?=$_SESSION['user']['nombre'];?> <?=$_SESSION['user']['apellido'];?></h1>
            <a href="../includes/cerrar_login.php"><img src="../assets/close.svg" alt="Cerrar sesión" /></a>
        </div>
        <ul class="list">
            <li><a href="inventario.php">Inventario</a></li>
            <li><a href="registro.php">Registro</a></li>
            <li><a href="altas.php">Altas de equipos</a></li>
            <li><a href="bajas.php">Bajas de equipos</a></li>
        </ul>
    </header>

    <div class="container container-regYMod">

        <a href="inventario.php"><img src="../assets/back.svg" alt="Volver" /></a>

        <?php while($product = mysqli_fetch_assoc($modificar_query)): ?>
            
            <form id="form" action="../lib/modificar_sql.php" method="POST">

                <h2>Modificar productos</h2>

                <label for="id">ID</label>
                <input type="text" name="id" value="<?=$product['id'];?>">

                <label for="marca">Marca</label>
                <input type="text" name="marca" value="<?=$product['marca'];?>">

                <label for="modelo">Modelo</label>
                <input type="text" name="modelo" value="<?=$product['modelo'];?>">

                <label for="description">Descripcion</label>
                <textarea name="descripcion"><?=$product['descripcion'];?></textarea>

                <label for="proce">Procesador</label>
                <input type="text" name="proce" value="<?=$product['procesador'];?>">
                
                <label for="ram">Ram</label>
                <input type="text" name="ram" value="<?=$product['ram'];?>">

                <label for="almace">Almacenamiento</label>
                <input type="text" name="almace" value="<?=$product['almacenamiento'];?>">
                
                <input id="submit" type="submit" value="Modificar">

            </form>

        <?php endwhile; ?>

    </div>
    <?php require_once '../includes/footer.php'; ?>
</body>
</html>