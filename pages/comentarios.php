<?php

require_once '../lib/comentarios_sql.php';
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
    <title>Comentarios del producto <?=$id?></title>
</head>
<body>

    <header class="header">
        <div class="user">
            <h1 class="name">Bienvenido, <?=$_SESSION['user']['nombre'];?> <?=$_SESSION['user']['apellido'];?></h1>
            <a href="../includes/cerrar_login.php"><img src="../assets/close.svg" alt="Cerrar sesión" /></a>
        </div>l
        <ul class="list">
            <li><a href="inventario.php">Inventario</a></li>
            <li><a href="registro.php">Registro</a></li>
            <li><a href="altas.php">Altas de equipos</a></li>
            <li><a href="bajas.php">Bajas de equipos</a></li>
        </ul>
    </header>
    
    <a href="inventario.php"><img src="../assets/back.svg" alt="Volver" /></a>
    <div class="container container-comments">

        <h2>Ingrese un comentario o vea los comentarios para el equipo</h2>

        <form id="form_comments" action="../lib/comentarios_sql.php?id=<?=$_SESSION['user']['id_admin']?>&id_prod=<?=$id?>" method="POST">

            <?=mostrarErrores('error', 'comentario')?>
            <textarea name="coment" placeholder="Ingrese un comentario aqui..."></textarea>

            <input type="submit" value="Guardar" />

        </form>


        <?php if(mysqli_num_rows($comentarios_query) > 0) :?>

            <?php while($result_comment = mysqli_fetch_assoc($comentarios_query)) : ?>

                <div class="comments">
                    <h3><?=$result_comment['nombre'].' '.$result_comment['apellido']?></h3>
                    <p><?=$result_comment['comentarios']?></p>
                    <span><?=$result_comment['fecha']?></span>
                </div>

            <?php endwhile; ?>

        <?php else :?>

            <h2> No hay comentarios para este producto</h2>

        <?php endif; ?>
    </div>
    <?php require_once '../includes/footer.php'; ?>
</body>
</html>