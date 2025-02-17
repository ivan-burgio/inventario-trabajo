<?php

require_once '../includes/conexion.php';

if(isset($_GET)) {

    unset($_SESSION['error']);

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
        
        $estado = array();

        if(empty($comentario)) {

            $estado['comentario'] = "El comentario no puede estár vacio";
        };

        if(count($estado) == 0) {

            $insert_coment = "INSERT INTO comentarios VALUES(NULL, '$id_funcionario', '$id_producto', '$comentario', NOW());";
            $insert_coment_query = mysqli_query($conexion, $insert_coment);

            $estado['exito_comment'] = "Comentario ingresado con éxito";
            $_SESSION['estado'] = $estado;
            header("Location: ../pages/comentarios.php?id=$id_producto");
            exit();
        
        } else {

            $_SESSION['estado'] = $estado;
            header("Location: ../pages/comentarios.php?id=$id_producto");
        };
    };
};

mysqli_close($conexion);

?>