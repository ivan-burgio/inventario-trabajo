<?php

require_once '../includes/conexion.php';


//Se genera la consulta para la BD
$sql = "SELECT id, marca, modelo, COUNT(modelo) AS stock FROM productos GROUP BY modelo;";

//Se inserta la consulta en la BD
$select = mysqli_query($conexion, $sql);

?>