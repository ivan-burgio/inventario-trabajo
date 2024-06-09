<?php require_once 'includes/lib.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css" type="text/css" />
    <title>Registro</title>
</head>
<body>
    <?php require_once 'includes/header.php';?>

    <div class="container">

        <a href="index.php">Volver</a>
        
        <form id="form" action="includes/consultas_sql.php" method="POST">

            <h2>Alta de productos</h2>

            <?=mostrarErrores('errores', 'id'); ?>
            <label for="id">ID</label>
            <input type="text" id="id" name="id" />

            <?=mostrarErrores('errores', 'marca'); ?>
            <label for="marca">Marca</label>
            <input type="text" id="marca" name="marca" />

            <?=mostrarErrores('errores', 'modelo'); ?>
            <label for="modelo">Modelo</label>
            <input type="text" id="modelo" name="modelo" />

            <?=mostrarErrores('errores', 'select'); ?>
            <label for="select">Equipo</label>
            <select id="select" name="select">

                <option value="seleccione" selected>--seleccione una opcion--</option>
                <option value="torre">Torre</option>
                <option value="perife">Periferico</option>

            </select>

            <?=mostrarErrores('errores', 'fecha'); ?>
            <label for="fecha">Fecha de alta</label>
            <input type="date" id="fecha" name="fecha"/>

            <?=mostrarErrores('errores', 'descripcion'); ?>
            <label for="description">Descripcion</label>
            <textarea name="description"></textarea>

            <input id="submit" type="submit" value="Registrar" />
        </form>
    </div>
    <script src="js/main.js"></script>
</body>
</html>