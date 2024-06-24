<?php

require_once '../includes/conexion.php';

$status_altas = "UPDATE productos p INNER JOIN altas_productos a ON p.id = a.id_producto 
                 SET p.status = 1 
                 WHERE a.status = 0";

$status_altas_query = mysqli_query($conexion, $status_altas);


//Se genera la consulta para la BD
$sql = "SELECT p.id, p.marca, p.modelo, COUNT(p.modelo) AS stock 
        FROM productos p
        LEFT JOIN (
        SELECT DISTINCT id_producto, status
        FROM altas_productos) a 
        ON p.id = a.id_producto AND (a.status IS NULL OR a.status = 0)
        WHERE p.status = 1
        GROUP BY p.modelo;";

//Se inserta la consulta en la BD
$select = mysqli_query($conexion, $sql);

mysqli_close($conexion);

?>