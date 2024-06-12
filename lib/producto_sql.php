<?php

require_once '../includes/conexion.php';

//Traer una lista de los elementos que se llamen al momento de seleccionar un elemento de una tabla

if(isset($_GET)) {

    $modelo_get = isset($_GET['modelo']) ? $_GET['modelo'] : false;

    $select_pro = "SELECT * FROM productos WHERE modelo = '$modelo_get';";
    $select_query = mysqli_query($conexion, $select_pro);

};

