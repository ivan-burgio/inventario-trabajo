<?php

require_once '../includes/conexion.php';


//Se genera la consulta para la BD
$sql = "SELECT *
        FROM productos 
        WHERE status != 0";

//Se inserta la consulta en la BD
$select = mysqli_query($conexion, $sql);

mysqli_close($conexion);

?>