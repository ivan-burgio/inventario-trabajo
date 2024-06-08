<?php require_once 'includes/consultas_sql.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css" type="text/css" />
    <title>Inventario</title>
</head>
<body>
    <?php require_once 'includes/header.php'?>

    <div class="container">

        <?php if(mysqli_num_rows($select) == 0) : ?>

            <h2> No hay productos guardados en la base de datos</h2>
            
        <?php else : ?>

                <?php while($producto = mysqli_fetch_assoc($select)) : ?>

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
                                    STOCK
                                </th>
                                <th>
                                    ESTADO
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?=$producto['id']?></td>
                                <td><?=$producto['marca']?></td>
                                <td><?=$producto['modelo']?></td>
                                <td><?=$producto['stock']?></td>
                                <td>
                                    <a href="producto.php">X</a> 
                                    <a href="#">V</a> 
                                    <a href="#">O</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                <?php endwhile;?>
            
        <?php endif; ?>

    </div>
</body>
</html>