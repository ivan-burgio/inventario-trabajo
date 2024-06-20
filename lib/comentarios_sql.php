<?php

require_once '../includes/conexion.php';

if($_POST) {

    $coment = isset($_POST['coment']) ? $_POST['coment'] : false; 
}

if(isset($_GET)) {

    $id = isset($_GET['id']) ? $_GET['id'] : false;

    $comentarios = "SELECT c.comentarios, c.fecha, a.nombre, a.apellido FROM comentarios c
                    INNER JOIN admin a ON a.id_admin = c.id_admin
                    WHERE c.id_producto = '$id';";

    $comentarios_query = mysqli_query($conexion, $comentarios);
    exit();

};

mysqli_close($conexion);

?>