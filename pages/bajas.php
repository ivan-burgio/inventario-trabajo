<?php

require_once '../lib/bajas_sql.php';

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
            <li><a href="inventario.php">Inventario</a></li>
            <li><a href="registro.php">Registro</a></li>
            <li><a href="altas.php">Altas de equipos</a></li>
            <li><a href="bajas.php">Bajas de equipos</a></li>
        </ul>
    </header>

    <div class="container container-regYMod">

        <form id="form" action="../lib/bajas_sql.php" method="POST">

            <h2>Baja de productos para funcionarios</h2>

            <label for="label_func_altas">Funcionario</label>
            <input type="text" id="input_func_altas" name="input_func" placeholder="Ingrese al funcionario o id de equipo (Ej. N° Funcionario, ID de equipo, fecha, nombre)"/>

            <select id="select_func_altas" name="select_func">
                
                <option value="select_def">--Funcionario--</option>

                <?php if(mysqli_num_rows($select_altas_query) > 0) : ?>

                    <?php while($result = mysqli_fetch_assoc($select_altas_query)) : ?>

                        <option value="<?=$result['id_funcionario'];?>">N°<?=$result['id_funcionario'].' | '.$result['id_producto'].' | '.$result['nombre_func'].' | '.$result['fecha'].' | '.$result['lugar_del_equipo'];?></option>

                    <?php endwhile; ?>

                <?php else : ?>
                        
                        <option value="null">No hay funcionarios con los datos ingresados</option>
                
                <?php endif; ?>
            </select>

            <label id="label_area" for="descripcion">Motivo de baja</label>
            <textarea id="text_area" name="descripcion"></textarea>

            <input id="submit" type="submit" value="Registrar" />
        </form>
    </div>
    <script src="../js/bajas_func.js"></script>
    <?php require_once '../includes/footer.php'; ?>
</body>
</html>