<?php

require_once '../includes/conexion.php';

$status_altas = "UPDATE productos p
                 INNER JOIN (
                 SELECT id_producto, MAX(id) AS ultimo_id
                 FROM altas_productos
                 WHERE status = 0
                 ) AS a ON a.id_producto = p.id
                 INNER JOIN altas_productos a2 ON a2.id = a.ultimo_id
                 SET p.status = 1;";

$status_altas_query = mysqli_query($conexion, $status_altas);


//Se genera la consulta para la BD
$sql = "SELECT p.id, p.id_prod, p.marca, p.modelo, COUNT(p.modelo) AS stock 
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