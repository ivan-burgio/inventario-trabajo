<?php

require_once '../lib/comentarios_sql.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comentarios de </title>
</head>
<body>

    <header class="header">
        <ul class="list">
        <li><a href="inventario.php">Inventario</a></li>
        <li><a href="registro.php">Registro</a></li>
        <li><a href="#">Altas de equipos</a></li>
        <li><a href="#">Bajas de equipos</a></li>
        </ul>
    </header>
    
    <div class="container">

        <form action="../lib/comentarios_sql.php" method="POST">

            <label for="coment">Agregar comentario</label>
            <textarea name="coment"></textarea>

            <input type="submit" value="Guardar" />

        </form>


        <div>
            <h3>Usuario</h3>
            <p></p>
            <span></span>
        </div>

    </div>

</body>
</html>