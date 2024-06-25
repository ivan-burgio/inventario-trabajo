<?php

require_once '../includes/conexion.php';


$select_altas = "SELECT id_funcionario, id_producto, nombre_func, fecha, lugar_trabajo 
                 FROM altas_productos
                 WHERE status = 1";

$select_altas_query = mysqli_query($conexion, $select_altas);


if($_POST) {

    $id_product = isset($_POST['select_func']) ? $_POST['select_func'] : false;
    $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : false;
    $user = $_SESSION['user']['nombre'].' '.$_SESSION['user']['apellido'];

    $update_alta = "UPDATE altas_productos 
                    SET status = 0, usuario = '$user', descripcion = '$descripcion', fecha = CURDATE() 
                    WHERE id_producto = '$id_product';";

    $update_alta_query = mysqli_query($conexion, $update_alta);

    header('Location: ../pages/bajas.php');

};

mysqli_close($conexion);

?>