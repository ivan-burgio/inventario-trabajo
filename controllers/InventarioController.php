<?php

require_once '../includes/conexion.php';


//Se genera la consulta para la BD
$sql = "SELECT p.*, a.*
        FROM productos p
        LEFT JOIN altas_productos a ON p.id = a.id_producto AND a.status = 1
        WHERE p.status != 0;";

//Se inserta la consulta en la BD
$select = mysqli_query($conexion, $sql);

mysqli_close($conexion);

?>