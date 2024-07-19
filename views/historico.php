<?php

require_once '../includes/conexion.php';
require_once '../lib/historico_sql.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css" type="text/css" />
    <title>Historico</title>
</head>
<body>

    <header class="header">
        <div class="user">
            <h1 class="name">Bienvenido, <?=$_SESSION['user']['nombre'];?> <?=$_SESSION['user']['apellido'];?></h1>
            <a href="../includes/cerrar_login.php"><img src="../assets/close.svg" alt="Cerrar sesión" /></a>
        </div>
        <ul class="list">
        <?php if($_SESSION['user']['access'] == 2) :?>
                <li><a href="inventario.php">Inventario</a></li>
                <li><a href="registro.php">Registro</a></li>
                <li><a href="altas.php">Altas de equipos</a></li>
                <li><a href="bajas.php">Bajas de equipos</a></li>
                <li><a href="pdf.php">PDF</a></li>
            <?php else :?>
                <li><a href="altas.php">Altas de equipos</a></li>
                <li><a href="bajas.php">Bajas de equipos</a></li>
                <li><a href="pdf.php">PDF</a></li>
            <?php endif;?>
        </ul>
    </header>
    
    <div class="container">

        <a href="inventario.php"><img src="../assets/back.svg" alt="Volver" /></a>

        <div>
            <h1>Historico de altas</h1>

            <div class="select_history">
                <div>
                    <label for="historico">Vigentes</label>
                    <input type="radio" name="historico" value="historicoAll" />
                </div>
                <div>
                    <label for="historico">Historico total</label>
                    <input type="radio" name="historico" value="historicoTrue" />
                </div>
            </div>

            <?php if(mysqli_num_rows($select_altas_query) > 0) : ?>
                <?php while($result = mysqli_fetch_assoc($select_altas_query)) : ?>

                    <table>
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Producto</th>
                                <th>Comentario</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?=$result['nombre_func']?></td>
                                <td><?=$result['id_prod']?></td>
                                <td><?=$result['comentarios']?></td>
                                <td><?=$result['fecha']?></td>
                            </tr>
                        </tbody>
                    </table>
                <?php endwhile;?>
            <?php endif;?>
        </div>
    </div>

</body>
</html>