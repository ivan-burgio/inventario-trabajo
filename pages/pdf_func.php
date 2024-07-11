<?php 

require_once '../includes/conexion.php';
require_once '../lib/pdf_sql.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css" type="text/css" /> 
    <title>PDF - <?=$result?></title>
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

        <h1>Historico de los PDF</h1>
            
        <div class="container_pdf">

            <?php if(mysqli_num_rows($select_func_pdf_query) > 0) : ?>

                <?php while($result_func_pdf = mysqli_fetch_assoc($select_func_pdf_query)) : ?>

                    <table>
                        <thead>
                            <tr>
                                <th>N° Funcionario</th>
                                <th>Nombre</th>
                                <th>Ultimo registro</th>
                                <th>PDF</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?=$result_func_pdf['id_funcionario']?></td>
                                <td><?=$result_func_pdf['nombre_func']?></td>
                                <td><?=$result_func_pdf['fecha']?></td>
                                <td>Descargar</td>
                            </tr>
                        </tbody>
                    </table>

                <?php endwhile;?>
            <?php else : ?>

            <?php endif; ?>
        </div>
    </div>
    
</body>
</html>