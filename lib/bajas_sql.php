<?php

require_once '../includes/conexion.php';

date_default_timezone_set('America/Montevideo');

$select_altas = "SELECT DISTINCT a.id_funcionario, a.id_producto, a.nombre_func, a.fecha, a.lugar_trabajo, p.id_prod
                 FROM altas_productos a
                 INNER JOIN productos p ON p.id = a.id_producto
                 WHERE a.status = 1;
                 ";

$select_altas_query = mysqli_query($conexion, $select_altas);


if($_POST) {

    unset($_SESSION['errorBaja']);
    unset($_SESSION['exitoBaja']);

    $id_product = isset($_POST['select_func']) ? $_POST['select_func'] : false;
    $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : false;
    $user = $_SESSION['user']['nombre'].' '.$_SESSION['user']['apellido'];
    $user_admin = $_SESSION['user']['id_admin'];

    $estado = array();

    if(empty($descripcion)) {

        $estado['motivo'] = "Ingrese el motivo de la baja";
    };

    if(count($estado) == 0) {

        insertQueryBaja($id_product, $descripcion, $user, $user_admin, $conexion);

        $update_inv = "UPDATE productos SET status = 1 WHERE id = '$id_product';";
        $update_inv_query = mysqli_query($conexion, $update_inv);
        $estado['exito'] = "Baja realizada con éxito";
        $_SESSION['exitoBaja'] = $estado;

    } else {

        $_SESSION['errorBaja'] = $estado;
    }

    mysqli_close($conexion);
    header('Location: ../pages/bajas.php');

};


//----------------------------------------FUNCIONES----------------------------------------


function insertQueryBaja($id_product, $descripcion, $user_admin, $user, $conexion) {

    $fecha_actual = date('Y-m-d H:i:s');

    $update_alta = "UPDATE altas_productos
                    SET status = 0,
                        usuario = '$user_admin',
                        descripcion = '$descripcion',
                        fecha = '$fecha_actual'
                    WHERE id_producto = '$id_product'
                    AND fecha = (
                        SELECT fecha
                        FROM altas_productos
                        WHERE id_producto = '$id_product'
                        ORDER BY fecha DESC
                        LIMIT 1
                    );";

    $comentario_inicial = "INSERT INTO comentarios VALUES(NULL, '$user', '$id_product', '$descripcion', '$fecha_actual');";

    $insert_comentario = mysqli_query($conexion, $comentario_inicial);
    $update_alta_query = mysqli_query($conexion, $update_alta);

};

?>