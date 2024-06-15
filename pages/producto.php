<?php
require_once '../lib/producto_sql.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css" type="text/css" />
    <title>Producto</title>
</head>
<body>

    <header class="header">
        <ul class="list">
            <a href="inventario.php">Inventario</a>
            <a href="registro.php">Registro</a>
            <a href="#">Altas de equipos</a>
            <a href="#">Bajas de equipos</a>
        </ul>
    </header>


    <div class="container">

        <a href="inventario.php">Volver</a>

        <?php if(mysqli_num_rows($select_query) > 0) : ?>

            <?php while($torre = mysqli_fetch_assoc($select_query)) : ?>

                <?php if($torre['procesador'] == '') : ?>
                    
                    <table>
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Marca</th>
                                <th>Modelo</th>
                                <th>Alta</th>
                                <th>Descripcion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?=$torre['id']?></td>
                                <td><?=$torre['marca']?></td>
                                <td><?=$torre['modelo']?></td>
                                <td><?=$torre['alta']?></td>
                                <td><?=$torre['descripcion']?></td>
                                <td>
                                    <a href="producto.php?id=<?=$torre['id'];?>">Eliminar</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                <?php else : ?>

                    <table>
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Marca</th>
                                <th>Modelo</th>
                                <th>Procesador</th>
                                <th>Ram</th>
                                <th>Memoria</th>
                                <th>Alta</th>
                                <th>Descripcion</th>
                                <th>Comentarios</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?=$torre['id']?></td>
                                <td><?=$torre['marca']?></td>
                                <td><?=$torre['modelo']?></td>
                                <td><?=$torre['procesador']?></td>
                                <td><?=$torre['ram']?></td>
                                <td><?=$torre['almacenamiento']?></td>
                                <td><?=$torre['alta']?></td>
                                <td><?=$torre['descripcion']?></td>
                                <td>
                                    <a href="../lib/eliminar_sql.php?id=<?=$torre['id']?>">Eliminar</a>
                                    <a href="modificar.php?id=<?=$torre['id']?>">Modificar</a>
                                    <a href="producto.php?id=<?=$torre['id']?>">Comentarios</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                <?php endif;?>

            <?php endwhile;?>

        <?php else :?>

            <?php echo "<h1>No hay productos para mostrar</h1>"; ?>

        <?php endif; ?>
        
    </div>
</body>
</html>