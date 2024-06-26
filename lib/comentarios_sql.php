<?php

require_once '../includes/conexion.php';

if(isset($_GET)) {

    $id = isset($_GET['id']) ? $_GET['id'] : false;

    $comentarios = "SELECT c.comentarios, c.fecha, a.nombre, a.apellido FROM comentarios c
                    INNER JOIN admin a ON a.id_admin = c.id_admin
                    WHERE c.id_producto = '$id' 
                    ORDER BY c.fecha DESC;";

    $comentarios_query = mysqli_query($conexion, $comentarios);

    if($_POST) {

        $id_funcionario = isset($_GET['id']) ? $_GET['id'] : false;
        $id_producto = isset($_GET['id_prod']) ? $_GET['id_prod'] : false;
        
        $comentario = isset($_POST['coment']) ? $_POST['coment'] : false;
        
        $insert_coment = "INSERT INTO comentarios VALUES(NULL, '$id_funcionario', '$id_producto', '$comentario', NOW());";
        $insert_coment_query = mysqli_query($conexion, $insert_coment);

        header('Location: ../pages/inventario.php');
    }

};

mysqli_close($conexion);

?>