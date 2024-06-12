<?php
require_once 'includes/consultas_sql.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css" type="text/css" />
    <title>Producto</title>
</head>
<body>
    <?=require_once 'includes/header.php';?>

    <div class="container">

        <a href="inventario.php">Volver</a>

        <?php if(mysqli_num_rows($query_pro) > 0) : ?>

            <?php while($torre = mysqli_fetch_assoc($query_pro)) : ?>

                <?php if($torre['procesador'] == '') : ?>
                    
                    <table>
                        <thead>
                            <tr>
                                <th>
                                    ID
                                </th>
                                <th>
                                    MARCA
                                </th>
                                <th>
                                    MODELO
                                </th>
                                <th>
                                    ALTA
                                </th>
                                <th>
                                    DESCRIPCION
                                </th>
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
                                    <a href="#">Borrar</a>
                                    <a href="#">Modificar</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                <?php else : ?>

                    <table>
                        <thead>
                            <tr>
                                <th>
                                    ID
                                </th>
                                <th>
                                    MARCA
                                </th>
                                <th>
                                    MODELO
                                </th>
                                <th>
                                    PROCESADOR
                                </th>
                                <th>
                                    RAM
                                </th>
                                <th>
                                    ALMACENAMIENTO
                                </th>
                                <th>
                                    ALTA
                                </th>
                                <th>
                                    DESCRIPCION
                                </th>
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
                                    <a href="#">Borrar</a>
                                    <a href="#">Modificar</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                <?php endif; ?>

            <?php endwhile;?>

        <?php else :?>

            <?php echo "<h1>No hay torres para mostrar</h1>"; ?>

        <?php endif; ?>
        

    </div>
</body>
</html>