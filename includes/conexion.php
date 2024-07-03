<?php

session_start();

date_default_timezone_set('America/Montevideo');

$host = 'Localhost';
$user = 'root';
$password = '';

$conexion = mysqli_connect($host, $user, $password);

if(mysqli_connect_errno()) {

    echo '<h1>La conexion tuvo un error</h1>';

} else {

    $db = mysqli_select_db($conexion, 'inventario');
};

?>