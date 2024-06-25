<?php
require_once '../includes/conexion.php';

// Se valida la existencia del parámetro 'id' en la solicitud GET
if(isset($_GET['id'])) {
    // Sanitizamos el valor de 'id' para evitar inyección SQL
    $id_get = mysqli_real_escape_string($conexion, $_GET['id']);

    // Generamos la consulta SQL para actualizar el producto
    $delete_pro = "UPDATE productos SET status = 0 WHERE id = '$id_get'";

    // Ejecutamos la consulta
    $delete_query = mysqli_query($conexion, $delete_pro);

    // Verificamos si la consulta se ejecutó correctamente
    if($delete_query) {
        // Redireccionamos solo si la consulta fue exitosa
        header('Location: ../pages/inventario.php');

    } else {
        // Manejo de error si la consulta falla (opcional)
        echo "Error al ejecutar la consulta: " . mysqli_error($conexion);
    }
} else {
    // Manejo si no se proporciona 'id' en la solicitud GET (opcional)
    echo "No se proporcionó el parámetro 'id' en la solicitud.";
}

// Cerramos la conexión a la base de datos
mysqli_close($conexion);
?>
