<?php

require_once '../includes/conexion.php';

if(isset($_GET)) {

    //Eliminar un elemento de la lista a través de su ID

    $id_get = isset($_GET['id']) ? $_GET['id'] : false;

    $delete_pro = "DELETE FROM productos WHERE id = '$id_get';";
    $delete_query = mysqli_query($conexion, $delete_pro);
};

header('Location: ../pages/inventario.php');