<?php

require_once '../includes/conexion.php';


if($_GET) {

    $id_producto = isset($_GET['id']) ? $_GET['id'] : false;

    $modificar_pro = "SELECT * FROM productos WHERE id = '$id_producto';";
    $modificar_query = mysqli_query($conexion, $modificar_pro);
};


if($_POST) {

    $id = isset($_POST['id']) ? $_POST['id'] : false;
    $marca = isset($_POST['marca']) ? $_POST['marca'] : false;
    $modelo = isset($_POST['modelo']) ? $_POST['modelo'] : false;
    $procesador = isset($_POST['proce']) ? $_POST['proce'] : false;
    $ram = isset($_POST['ram']) ? $_POST['ram'] : false;
    $almacenamiento = isset($_POST['almace']) ? $_POST['almace'] : false;
    $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : false;

    $update = "UPDATE productos 
                SET marca = '$marca', modelo = '$modelo', procesador = '$procesador', ram = '$ram', almacenamiento = '$almacenamiento', descripcion = '$descripcion' WHERE id = '$id';";

    $update_query = mysqli_query($conexion, $update);

};

header('Location: ../pages/inventario.php');