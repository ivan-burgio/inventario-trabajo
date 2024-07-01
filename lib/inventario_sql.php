<?php

require_once '../includes/conexion.php';

$status_altas = "UPDATE productos p
                 INNER JOIN (
                 SELECT id, id_producto
                 FROM altas_productos
                 WHERE status = 0
                 ORDER BY id DESC
                 LIMIT 1
                 ) a ON p.id = a.id_producto
                 SET p.status = 1;";

$status_altas_query = mysqli_query($conexion, $status_altas);


//Se genera la consulta para la BD
$sql = "SELECT *, COUNT(modelo) AS stock 
        FROM productos 
        WHERE status = 1
        GROUP BY modelo;";

//Se inserta la consulta en la BD
$select = mysqli_query($conexion, $sql);

mysqli_close($conexion);

?>