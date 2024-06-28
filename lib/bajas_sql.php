<?php

require_once '../includes/conexion.php';

$select_altas = "SELECT MAX(a.id_producto) as id_producto, a.id_funcionario, a.id_producto, a.nombre_func, a.fecha, a.lugar_trabajo, p.id_prod
                 FROM altas_productos a
                 INNER JOIN productos p ON p.id = a.id_producto
                 WHERE a.status = 1
                 GROUP BY a.id_funcionario, a.id_producto, a.nombre_func, a.fecha, a.lugar_trabajo, p.id_prod;";

$select_altas_query = mysqli_query($conexion, $select_altas);


if($_POST) {

    $id_product = isset($_POST['select_func']) ? $_POST['select_func'] : false;
    $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : false;
    $user = $_SESSION['user']['nombre'].' '.$_SESSION['user']['apellido'];
    $user_admin = $_SESSION['user']['id_admin'];

    insertQueryBaja($id_product, $descripcion, $user, $user_admin);

    header('Location: ../pages/bajas.php');

};


//----------------------------------------FUNCIONES----------------------------------------

function insertQueryBaja($id_product, $descripcion, $user_admin, $user) {

    $update_alta = "UPDATE altas_productos 
                    SET status = 0, usuario = '$user', descripcion = '$descripcion', fecha = CURDATE() 
                    WHERE id_producto = '$id_product';";
    $comentario_inicial = "INSERT INTO comentarios VALUES(NULL, '$user_admin', '$id_product', '$descripcion', NOW());";

    $insert_comentario = mysqli_query($conexion, $comentario_inicial);
    $update_alta_query = mysqli_query($conexion, $update_alta);
};

mysqli_close($conexion);

?>