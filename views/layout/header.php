<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?=base_url?>css/style.css" type="text/css" />
    <title>Inventario</title>
</head>
<body>
<?php if(isset($_SESSION['user'])) : ?> 
    <header class="header">
        <div class="user">
            <h1 class="name">Bienvenido, <?=$_SESSION['user']->nombre;?> <?=$_SESSION['user']->apellido;?></h1>
            <a href="<?=base_url?>?controller=Login&action=closeLogin"><img src="<?=base_url?>assets/close.svg" alt="Cerrar sesión" /></a>
        </div>
        <ul class="list">

        <?php if($_SESSION['user']->access == 2) :?>
                <li><a href="<?=base_url?>?controller=Inventario&action=inventario">Inventario</a></li>
                <li><a href="<?=base_url?>?controller=Registro&action=registro">Registro</a></li>
                <li><a href="<?=base_url?>?controller=AltasBajas&action=altas">Altas de equipos</a></li>
                <li><a href="<?=base_url?>?controller=AltasBajas&action=bajas">Bajas de equipos</a></li>
                <li><a href="pdf.php">PDF</a></li>
            <?php else :?>
                <li><a href="altas.php">Altas de equipos</a></li>
                <li><a href="bajas.php">Bajas de equipos</a></li>
                <li><a href="pdf.php">PDF</a></li>
            <?php endif;?>
        </ul>
    </header>
<?php endif;?>