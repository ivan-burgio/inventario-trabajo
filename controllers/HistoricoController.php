<?php

if($_GET) {

    $id_func = isset($_GET['id']) ? $_GET['id'] : false;
    
    $select_altas = "SELECT a.*, p.id, p.id_prod, c.comentarios FROM altas_productos a 
                     INNER JOIN productos p ON a.id_producto = p.id
                     INNER JOIN comentarios c ON a.id_producto = c.id_producto 
                     WHERE id_funcionario = '$id_func'
                     ORDER BY a.fecha DESC;";
    $select_altas_query = mysqli_query($conexion, $select_altas);
}

?>