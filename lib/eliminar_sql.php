<?php

require_once '../includes/conexion.php';

//Se valida la existencia de GET
if(isset($_GET)) {

    //Eliminar un elemento de la lista a través de su ID

    $id_get = isset($_GET['id']) ? $_GET['id'] : false;             //Se valida la existencia de datos enviados por GET

    //Se genera la consulta para la BD
    $delete_pro = "DELETE FROM productos WHERE id = '$id_get';";
    
    //Se inserta la consulta en la BD
    $delete_query = mysqli_query($conexion, $delete_pro);
};

//Se redirecciona hacia la página de inventario
header('Location: ../pages/inventario.php');
exit();

?>