<?php 

require_once '../includes/helpers.php'; 
require_once '../includes/conexion.php';

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
    <title>Registro</title>
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
        
        <form id="form" action="../lib/registro_sql.php" method="POST">

            <h2>Registros de productos</h2>
            
            <?=mostrarExito('estado', 'exito_perife')?>
            <?=mostrarExito('estado', 'exito_torre')?>
            <?=mostrarErrores('estado', 'id'); ?>
            <label for="id">ID</label>
            <input type="text" id="id" name="id" placeholder="Ingrese la etiqueta del equipo"/>

            <?=mostrarErrores('estado', 'marca'); ?>
            <label for="marca">Marca</label>
            <input type="text" id="marca" name="marca"  placeholder="Ingrese la marca del equipo"/>

            <?=mostrarErrores('estado', 'modelo'); ?>
            <label for="modelo">Modelo</label>
            <input type="text" id="modelo" name="modelo" placeholder="Ingrese el modelo del equipo"/>

            <?=mostrarErrores('estado', 'select'); ?>
            <label for="select">Equipo</label>
            <select id="select" name="select">

                <option value="seleccione" selected>--seleccione una opción--</option>
                <option value="torre">Torre</option>
                <option value="perife">Periferico</option>

            </select>

            <?=mostrarErrores('estado', 'descripcion'); ?>
            <label for="description">Descripcion y comentario inicial</label>
            <textarea name="description" placeholder="Descripción general del equipo..."></textarea>

            <input id="submit" type="submit" value="Registrar" />
        </form>
    </div>
    <?php require_once '../includes/footer.php'; ?>
    <script src="../js/registro.js"></script>
</body>
</html>