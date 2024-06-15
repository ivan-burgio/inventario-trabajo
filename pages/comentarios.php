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
            <a href="inventario.php">Inventario</a>
            <a href="registro.php">Registro</a>
            <a href="#">Altas de equipos</a>
            <a href="#">Bajas de equipos</a>
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