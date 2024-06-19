<?php

require_once '../includes/conexion.php';


//Se genera la consulta para la BD
$sql = "SELECT id, marca, modelo, COUNT(modelo) AS stock FROM productos WHERE status = 1 GROUP BY modelo;";

//Se inserta la consulta en la BD
$select = mysqli_query($conexion, $sql);

?>