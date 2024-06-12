<?php

require_once '../includes/conexion.php';

//Se valida la existencia de GET
if(isset($_GET)) {

    $modelo_get = isset($_GET['modelo']) ? $_GET['modelo'] : false; //Se valida la existencia de datos enviados por GET

    //Se genera la consulta para la BD
    $select_pro = "SELECT * FROM productos WHERE modelo = '$modelo_get';";

    //Se inserta la consulta en la BD
    $select_query = mysqli_query($conexion, $select_pro);

};

