<?php

require_once '../lib/bajas_sql.php';
require_once '../includes/helpers.php';

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
    <title>Baja de productos para funcionarios</title>
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

    <div class="container container-bajas">

        <div class="func">
            <input type="text" id="id_func" name="id_func" placeholder="N° de funcionario o nombre..."/>

            <h3>Funcionarios con productos</h3>
            <?php if(mysqli_num_rows($select_altas_query) > 0) : ?>
                <?php while($result = mysqli_fetch_assoc($select_altas_query)) : ?>

                    <button class="btn_func" value="<?=$result['id_funcionario'];?>">
                        <table id="table_baja">
                            <thead>
                                <tr>
                                    <th>N°Funcionario</th>
                                    <th>Nombre</th>
                                    <th>Lugar de trabajo</th>
                                    <th>Puesto</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?=$result['id_funcionario']?></td>
                                    <td><?=$result['nombre_func']?></td>
                                    <td><?=$result['lugar_trabajo']?></td>
                                    <td><?=$result['puesto']?></td>
                                </tr>
                            </tbody>
                        </table>
                    </button>

                <?php endwhile; ?>

            <?php else : ?>

                <p>No hay funcionario con productos asignados</p>

            <?php endif; ?>
        </div>
        
        <form action="../lib/bajas_sql.php" method="POST" class="product_func">

            <h3>Productos del funcionario seleccionado</h3>        

            <div class="table_prod_func">
                <?php while($result_prod = mysqli_fetch_assoc($select_product_query)) : ?>
                    <table id="table_prod" name="table_func" value="<?=$result_prod['id_funcionario'];?>">
                        <thead>
                            <tr>
                                <th>ID_Func:</th>
                                <th>ID:</th>
                                <th>Modelo:</th>
                                <th>Marca:</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td><?=$result_prod['id_funcionario'];?></td>
                                <td><?=$result_prod['id_prod'];?></td>
                                <td><?=$result_prod['modelo'];?></td>
                                <td><?=$result_prod['marca'];?></td>
                                <td><input class="check" type="checkbox" name="check_baja[]" value="<?=$result_prod['id_producto'];?>" /></td>
                            </tr>
                        </tbody>
                    </table>
                <?php endwhile; ?>

                <textarea name='description'></textarea>
                <input type="submit" id="input_baja" value="Dar de baja" />
            </div>
        </form>
    </div>
    <script src="../js/bajas_func.js"></script>
    <?php require_once '../includes/footer.php'; ?>
</body>
</html>