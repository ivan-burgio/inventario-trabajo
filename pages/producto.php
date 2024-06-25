<?php
require_once '../lib/producto_sql.php';

if(!isset($_SESSION['user'])) {

    header('Location: ../index.php');
}
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


    <div class="container container-producto">

        <a href="inventario.php"><img src="../assets/back.svg" alt="Volver" /></a>

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
                                    <a href="../lib/eliminar_sql.php?id=<?=$torre['id'];?>"><img src="../assets/trash.svg" alt="Eliminar" /></a>
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
                                <td>No hay comentarios</td>
                                <td>
                                    <a href="../lib/eliminar_sql.php?id=<?=$torre['id']?>"><img src="../assets/trash.svg" alt="Eliminar" /></a>
                                    <a href="modificar.php?id=<?=$torre['id']?>"><img src="../assets/edit.svg" alt="Editar" /></a>
                                    <a href="comentarios.php?id=<?=$torre['id']?>"><img src="../assets/comments.svg" alt="Modificar" /></a>
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
    <?php require_once '../includes/footer.php'; ?>
</body>
</html>