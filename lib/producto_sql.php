<?php

require_once '../includes/conexion.php';

//Se valida la existencia de GET
if(isset($_GET)) {

    $modelo_get = isset($_GET['modelo']) ? $_GET['modelo'] : false; //Se valida la existencia de datos enviados por GET

    //Se genera la consulta para la BD
    $select_pro = "SELECT 
                   p.id, p.id_prod, p.marca, p.modelo, p.procesador, p.ram, p.almacenamiento, 
                   p.alta, p.descripcion, p.usuario, 
                   c.comentarios AS ultimo_comentario
                   FROM productos p
                   LEFT JOIN 
                   (SELECT id_producto, comentarios
                   FROM comentarios c1
                   WHERE fecha = (SELECT MAX(fecha) FROM comentarios c2 WHERE c2.id_producto = c1.id_producto)
                        ) c ON p.id = c.id_producto
                   WHERE p.modelo = '$modelo_get' AND p.status = 1;";

    //Se inserta la consulta en la BD
    $select_query = mysqli_query($conexion, $select_pro);
};

mysqli_close($conexion);

?>
