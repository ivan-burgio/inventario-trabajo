<?php 

require_once '../lib/altas_sql.php';
require_once '../includes/helpers.php';

if(!isset($_SESSION['user'])) {

    header('Location: ../index.php');
};

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css" type="text/css" />
    <title>Altas de equipos para funcionarios</title>
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

    <div class="container container-regYMod">

        <form id="form" action="../lib/altas_sql.php" method="POST">

            <h2>Alta de productos para funcionarios</h2>

            <?=mostrarExito('estado', 'exito');?>
            <label for="ubic" id="ubic_label">Lugar de trabajo</label>
            <select id="ubic" name="ubic">

                <option value="default">--Seleccione la ubicación--</option>
                <option value="home">Tele trabajo</option>
                <option value="plataforma">Plataforma</option>

            </select>

            <label for="input_prod" id="label_prod">Equipos</label>
            <?=mostrarErrores('producto', 'error');?>
            <input type="text" id="input_prod" name="input_prod"  placeholder="Ingrese el equipo (Ej. Etiqueta, marca, modelo)"/>

            <div id="select_prod" name="select_prod">

                <?php if(mysqli_num_rows($list_prod_query) > 0) : ?>

                    <?php while($result_prod = mysqli_fetch_assoc($list_prod_query)) : ?>
                        <table id="table_prod">
                            <thead>
                                <tr>
                                    <th>ID:</th>
                                    <th>Modelo:</th>
                                    <th>Marca:</th>
                                </tr>
                            </thead>

                                <tbody>
                                    <tr>
                                        <td><?=$result_prod['id_prod'];?></td>
                                        <td><?=$result_prod['modelo'];?></td>
                                        <td><?=$result_prod['marca'];?></td>
                                        <td><input class="check" type="checkbox" name="check[]" value="<?=$result_prod['id'];?>" /></td>
                                    </tr>
                                </tbody>
                        </table>
                    <?php endwhile; ?>

                <?php endif; ?>
            </div>

            <label for="input_func">Funcionario</label>
            <input type="text" id="input_func" name="input_func" placeholder="Ingrese al funcionario (Ej. N° Funcionario, nombre, sector)"/>

            <select id="select_func" name="select_func">

                <?php if(mysqli_num_rows($list_query) > 0) : ?>

                    <?php while($result = mysqli_fetch_assoc($list_query)) : ?>

                        <option value="<?=$result['id_funcionario'];?>">N°<?=$result['id_funcionario'].', '.$result['nombre'].' '.$result['apellido'].', '.$result['nombre_sector'];?></option>

                    <?php endwhile; ?>

                <?php else : ?>
                        
                        <option value="null">No hay funcionarios con los datos ingresados</option>
                
                <?php endif; ?>
            </select>
        
            <?=mostrarErrores('errores', 'sector');?>
            <?php if(mysqli_num_rows($list_sectores_query) > 0) :?>
                <select id="select_sect" name="sect">
                    <?php while($result_sector = mysqli_fetch_assoc($list_sectores_query)) : ?>
                            <option value="<?=$result_sector['nombre']?>"><?=$result_sector['nombre']?></option>
                    <?php endwhile;?>
                </select>

            <?php endif;?>

            <?=mostrarErrores('errores', 'comentario');?>
            <label id="label_area" for="description">Comentarios</label>
            <textarea id="text_area" name="description" placeholder="Comentario sobre el alta del producto..."></textarea>

            <input id="submit" type="submit" value="Registrar" />
        </form>
    </div>
    <script src="../js/alta_func.js"></script>
    <?php require_once '../includes/footer.php'; ?>
</body>
</html>