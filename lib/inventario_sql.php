<?php

require_once '../includes/conexion.php';

$sql = "SELECT id, marca, modelo, COUNT(modelo) AS stock FROM productos GROUP BY modelo;";

$select = mysqli_query($conexion, $sql);