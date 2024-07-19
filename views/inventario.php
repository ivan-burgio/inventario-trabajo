<?php 

require_once '../lib/inventario_sql.php'; 

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
    <title>Inventario</title>
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

    <div class="search">
        <input type="text" id="search" name="search" placeholder="Buscador de productos...">
    </div>

    <div class="container">

        <?php if(mysqli_num_rows($select) == 0) : ?>

            <h2> No hay productos guardados en el inventario</h2>
            
        <?php else : ?>

            <?php while($producto = mysqli_fetch_assoc($select)) : ?>

                <table id="table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Lugar de uso</th>
                            <th>Funcionario</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?=$producto['id_prod']?></td>
                            <td><?=$producto['marca']?></td>
                            <td><?=$producto['modelo']?></td>
                            <?php if(empty($producto['lugar_trabajo'] && $producto['nombre_func'])) :?>
                                <td>Disponible</td>
                                <td>Sin asignar</td>
                            <?php else : ?>
                                <td><?=$producto['lugar_trabajo']?></td>
                                <td><a href="historico.php?id=<?=$producto['id_funcionario']?>"><?=$producto['nombre_func']?></a></td>
                            <?php endif;?>
                            <td>
                                <a href="producto.php?modelo=<?=$producto['id_prod']?>"><img src="../assets/eye.svg" alt="Ver"/></a> 
                            </td>
                        </tr>
                    </tbody>
                </table>

            <?php endwhile;?>
            
        <?php endif; ?>

    </div>
    <?php require_once '../includes/footer.php'; ?>
    <script src="../js/inventario.js"></script>
</body>
</html>