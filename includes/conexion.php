<?php

session_start();

$host = 'Localhost';
$user = 'root';
$password = '';


$conexion = mysqli_connect($host, $user, $password);

if(mysqli_connect_errno()) {

    echo '<h1>La conexion tuvo un error</h1>';

} else {

    $db = mysqli_select_db($conexion, 'inventario');
};