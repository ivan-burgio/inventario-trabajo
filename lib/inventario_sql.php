<?php

require_once '../includes/conexion.php';


//Se genera la consulta para la BD
$sql = "SELECT p.id, p.marca, p.modelo, COUNT(p.modelo) AS stock 
    FROM productos p
    LEFT JOIN altas_productos a ON p.id = a.id_producto 
    WHERE p.status = 1 AND a.id_producto IS NULL
    GROUP BY p.modelo;";

//Se inserta la consulta en la BD
$select = mysqli_query($conexion, $sql);

mysqli_close($conexion);

?>