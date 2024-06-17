<?php require_once '../lib/inventario_sql.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css" type="text/css" />
    <title>Inventario</title>
</head>
<body>

    <header class="header">
        <ul class="list">
        <li><a href="inventario.php">Inventario</a></li>
        <li><a href="registro.php">Registro</a></li>
        <li><a href="#">Altas de equipos</a></li>
        <li><a href="#">Bajas de equipos</a></li>
        </ul>
    </header>

    <div class="container">

        <a href="../index.php"><img src="../assets/back.svg" alt="Volver" /></a>

        <?php if(mysqli_num_rows($select) == 0) : ?>

            <h2> No hay productos guardados en el inventario</h2>
            
        <?php else : ?>

            <?php while($producto = mysqli_fetch_assoc($select)) : ?>

                <table>
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?=$producto['id']?></td>
                            <td><?=$producto['marca']?></td>
                            <td><?=$producto['modelo']?></td>
                            <td><?=$producto['stock']?></td>
                            <td>
                                <a href="producto.php?modelo=<?=$producto['modelo']?>"><img src="../assets/eye.svg" alt="Ver"/></a> 
                            </td>
                        </tr>
                    </tbody>
                </table>

            <?php endwhile;?>
            
        <?php endif; ?>

    </div>
</body>
</html>