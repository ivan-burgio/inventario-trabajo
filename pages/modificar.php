<?php

require_once '../includes/conexion.php';

if($_GET) {

    $id_producto = isset($_GET['id']) ? $_GET['id'] : false;

    $modificar_pro = "SELECT * FROM productos WHERE id = '$id_producto';";
    $modificar_query = mysqli_query($conexion, $modificar_pro);
};



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css" type="text/css" />
    <title>Modificar</title>
</head>
<body>

    <header class="header">
        <ul class="list">
            <a href="inventario.php">
                <img src="../assets/img-inventario.png" alt="imagen de inventario" />
            </a>
            <a href="registro.php">
                <img src="../assets/img-registro.png" alt="imagen de registro" />
            </a>
            <a href="#">
                <img src="../assets/img-inventario.png" alt="imagen de inventario" />
            </a>
            <a href="#">
                <img src="../assets/img-inventario.png" alt="imagen de inventario" />
            </a>
        </ul>
    </header>

    <div class="container">

        <a href="inventario.php">Volver</a>

        <?php while($product = mysqli_fetch_assoc($modificar_query)): ?>
            
            <form id="form" action="../includes/modificar_sql.php" method="POST">

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
    
</body>
</html>