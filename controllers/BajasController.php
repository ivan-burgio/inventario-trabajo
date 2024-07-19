<?php

require_once '../includes/conexion.php';

date_default_timezone_set('America/Montevideo');

$select_altas = "SELECT a.id_funcionario, a.id_producto, a.nombre_func, a.fecha, a.lugar_trabajo, a.puesto, p.id_prod
                 FROM altas_productos a
                 INNER JOIN productos p ON p.id = a.id_producto
                 INNER JOIN (
                    SELECT id_funcionario, MAX(id) AS max_id
                    FROM altas_productos
                    WHERE status = 1
                    GROUP BY id_funcionario
                 ) AS latest ON a.id_funcionario = latest.id_funcionario AND a.id = latest.max_id
                 WHERE a.status = 1;

";

$select_product = "SELECT a.id_funcionario, p.id_prod, p.modelo, p.marca, a.id_producto FROM productos p
                   INNER JOIN altas_productos a ON p.id = a.id_producto
                   WHERE a.status = 1";

$select_altas_query = mysqli_query($conexion, $select_altas);
$select_product_query = mysqli_query($conexion, $select_product);


if($_POST) {


    unset($_SESSION['errores']);
    unset($_SESSION['exitoBaja']);

    // Verificar y obtener datos del formulario
    if(isset($_POST['check_baja'])) {


        $check_prod = $_POST['check_baja'];
        $descripcion = isset($_POST['description']) ? $_POST['description'] : '';
        $user = $_SESSION['user']['nombre'] . ' ' . $_SESSION['user']['apellido'];
        $user_admin = $_SESSION['user']['id_admin'];

        $estado = [];

        if(empty($descripcion)) {

            $estado['comentario'] = "Ingrese el motivo de la baja"; 
            $_SESSION['errores'] = $estado;
        };

        if(count($check_prod) == 0 ) {

            $estado['producto'] = "Seleccione un producto para la baja";
            $_SESSION['errores'] = $estado;
        }

        if(count($estado) == 0) {
             // Realizar la baja y actualizar el estado de los productos
            foreach($check_prod as $equipo) {

                if(!empty($equipo)) {

                    // Insertar la baja en la tabla altas_productos
                    insertQueryBaja($equipo, $descripcion, $user_admin, $user, $conexion);

                    // Actualizar el estado del producto en la tabla productos
                    $update_inv = "UPDATE productos SET status = 1 WHERE id = '$equipo';";
                    $update_inv_query = mysqli_query($conexion, $update_inv);

                    // Guardar mensaje de éxito en sesión
                    $estado['exito'] = "Baja realizada con éxito";
                    $_SESSION['exitoBaja'] = $estado;
                
                } 
            }

        } else {

            $_SESSION['errores'] = $estado;
        }

        // Cerrar conexión y redirigir a la página de bajas
        mysqli_close($conexion);
        header('Location: ../pages/bajas.php');
        exit();

    } else {
        // Si no hay productos seleccionados, redirigir a la página de bajas
        header('Location: ../pages/bajas.php');
        exit();

    }
}

//----------------------------------------FUNCIONES----------------------------------------

function insertQueryBaja($equipo, $descripcion, $user_admin, $user, $conexion) {

    $fecha_actual = date('Y-m-d H:i:s');

    // Actualizar la última entrada de altas_productos para el producto específico
    $update_alta = "UPDATE altas_productos
                    SET status = 0,
                        usuario = '$user',
                        descripcion = '$descripcion',
                        fecha = '$fecha_actual'
                    WHERE id_producto = '$equipo'
                    AND fecha = (
                        SELECT fecha
                        FROM altas_productos
                        WHERE id_producto = '$equipo'
                        ORDER BY fecha DESC
                        LIMIT 1
                    );";

    // Insertar comentario inicial en la tabla comentarios
    $comentario_inicial = "INSERT INTO comentarios VALUES(NULL, '$user_admin', '$equipo', '$descripcion', '$fecha_actual');";

    // Ejecutar consultas
    $insert_comentario = mysqli_query($conexion, $comentario_inicial);
    $update_alta_query = mysqli_query($conexion, $update_alta);

};

?>