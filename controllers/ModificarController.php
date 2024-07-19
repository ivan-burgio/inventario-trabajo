<?php

require_once '../includes/conexion.php';

//Se valida la existencia de GET
if($_GET) {

    $id_producto = isset($_GET['id']) ? $_GET['id'] : false;    //Se valida la existencia de datos enviados por GET

    //Se genera la consulta para la BD
    $modificar_pro = "SELECT * FROM productos WHERE id = '$id_producto';";

    //Se inserta la consulta en la BD
    $modificar_query = mysqli_query($conexion, $modificar_pro);
};

//Validar e ingresar los datos de los productos que se ingresan a la tabla productos.
if($_POST) {

    $id = isset($_POST['id']) ? $_POST['id'] : false;                               //Se valida la existencia de datos enviados por POST
    $marca = isset($_POST['marca']) ? $_POST['marca'] : false;                      //Se valida la existencia de datos enviados por POST
    $modelo = isset($_POST['modelo']) ? $_POST['modelo'] : false;                   //Se valida la existencia de datos enviados por POST
    $procesador = isset($_POST['proce']) ? $_POST['proce'] : false;                 //Se valida la existencia de datos enviados por POST
    $ram = isset($_POST['ram']) ? $_POST['ram'] : false;                            //Se valida la existencia de datos enviados por POST
    $almacenamiento = isset($_POST['almace']) ? $_POST['almace'] : false;           //Se valida la existencia de datos enviados por POST
    $comentario = isset($_POST['descripcion']) ? $_POST['descripcion'] : false;    //Se valida la existencia de datos enviados por POST
    $user_admin = $_SESSION['user']['id_admin'];

    //Se genera la consulta para la BD
    $update = "UPDATE productos 
                SET marca = '$marca', modelo = '$modelo', procesador = '$procesador', ram = '$ram', almacenamiento = '$almacenamiento' WHERE id = '$id';";
    $comentario_inicial = "INSERT INTO comentarios VALUES(NULL, '$user_admin', '$id', '$comentario', NOW());";
    
    //Se inserta la consulta en la BD
    $insert_comentario = mysqli_query($conexion, $comentario_inicial);
    $update_query = mysqli_query($conexion, $update);

    //Se redirecciona a la página del inventario
    header('Location: ../pages/inventario.php');
    exit();
};

mysqli_close($conexion);

?>
