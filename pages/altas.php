<?php 

require_once '../lib/altas_sql.php';

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
    <title>Altas de equipos para funcionarios</title>
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
            <li><a href="#">Bajas de equipos</a></li>
        </ul>
    </header>

    <div class="container container-regYMod">

        <form id="form" action="../lib/registro_sql.php" method="POST">

            <h2>Alta de productos para funcionarios</h2>

            <select id="ubic" name="ubic">

                <option value="default">--Seleccione la ubicación--</option>
                <option value="home">Tele-trabajo</option>
                <option value="plataforma">Plataforma</option>

            </select>

            <label for="input_func">Funcionario</label>
            <input type="text" id="input_func" name="input_func" />

            <select id="select_func" name="select_func">
                
                <option value="select_def">--Funcionario--</option>

                <?php if(mysqli_num_rows($list_query) > 0) : ?>

                    <?php while($result = mysqli_fetch_assoc($list_query)) : ?>

                        <option value="<?=$result['id_funcionario'];?>">N°<?=$result['id_funcionario'].', '.$result['nombre'].' '.$result['apellido'].', '.$result['nombre_sector'];?></option>

                    <?php endwhile; ?>

                <?php else : ?>
                        
                        <option value="null">No hay funcionarios con los datos ingresados</option>
                
                <?php endif; ?>
            </select>

            <label for="description">Descripcion</label>
            <textarea name="description"></textarea>

            <input id="submit" type="submit" value="Registrar" />
        </form>
    </div>
    <script src="../js/alta_func.js"></script>
</body>
</html>