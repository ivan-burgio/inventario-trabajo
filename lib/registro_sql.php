<?php
require_once '../includes/conexion.php';

//Validar e ingresar los datos de los productos que se ingresan a la tabla productos.
if($_POST) {

    unset($_SESSION['estado']);

    $id = isset($_POST['id']) ? $_POST['id'] : false;                               //Se valida la existencia de datos enviados por POST
    $marca = isset($_POST['marca']) ? $_POST['marca'] : false;                      //Se valida la existencia de datos enviados por POST
    $modelo = isset($_POST['modelo']) ? $_POST['modelo'] : false;                   //Se valida la existencia de datos enviados por POST
    $procesador = isset($_POST['proce']) ? $_POST['proce'] : false;                 //Se valida la existencia de datos enviados por POST
    $ram = isset($_POST['ram']) ? $_POST['ram'] : false;                            //Se valida la existencia de datos enviados por POST
    $almacenamiento = isset($_POST['almace']) ? $_POST['almace'] : false;           //Se valida la existencia de datos enviados por POST
    $descripcion = isset($_POST['description']) ? $_POST['description'] : false;    //Se valida la existencia de datos enviados por POST
    $user = $_SESSION['user']['nombre'].' '.$_SESSION['user']['apellido'];
    $user_admin = $_SESSION['user']['id_admin'];

    $estado = array();     //Se crea array de estado

    validacionCampos($id, $marca, $modelo, $procesador, $ram, $almacenamiento, $descripcion, $user, $user_admin, $estado, $conexion);
    
    //Redirigue la ubicación de la página hacia el registro
    header('Location: ../pages/registro.php');
    exit();
};

//----------------------------------------FUNCIONES----------------------------------------


function validacionCampos($id, $marca, $modelo, $procesador, $ram, $almacenamiento, $descripcion, $user, $user_admin, $estado, $conexion) {

    //Validación de los campos
    if(empty($id)) {

        $estado['id'] = "Ingrese un ID";
    };

    if(empty($marca) || preg_match("[/0-9/]", $marca)) {

        $estado['marca'] = "Ingrese la marca del equipo";
    };

    if(empty($modelo)) {

        $estado['modelo'] = "Ingrese el modelo del equipo";
    };

    if(empty($descripcion)) {

        $estado['descripcion'] = "Ingrese una descripción generica del equipo";
    };

    validarTipoProducto($id, $marca, $modelo, $procesador, $ram, $almacenamiento, $descripcion, $user, $user_admin, $estado, $conexion);
}

function validarTipoProducto($id, $marca, $modelo, $procesador, $ram, $almacenamiento, $descripcion, $user, $user_admin, $estado, $conexion) {

    //Se valida el tipo de valor del select
    if($_POST['select'] && $_POST['select'] == 'torre') { //En caso de que sea 'torre' se validan los otros campos

        countErrorTorre($estado, $id, $marca, $modelo, $procesador, $ram, $almacenamiento, $descripcion, $conexion, $user);

    //Se valida el tipo de valor del select
    } elseif($_POST['select'] && $_POST['select'] == 'perife') { //En caso de que sea 'perife' se realiza la validación del array de estado

        countErrorPerife($estado, $id, $marca, $modelo, $descripcion, $conexion);

    } else {

        //Si no se selecciona alguno de los dos valores anteriormente mencionados, se guarda en el array de $estado
        $estado['select'] = "Seleccione una opcion";
        $_SESSION['estado'] = $estado;
    }
    
}

function countErrorTorre($estado, $id, $marca, $modelo, $procesador, $ram, $almacenamiento, $descripcion, $conexion, $user) {

    if(count($estado) == 0) { //Si el array de estado está vacio, entonces se realiza la inserción a la BD

        ingresarProducTorre($id, $marca, $modelo, $procesador, $ram, $almacenamiento, $descripcion, $conexion, $user);
        $estado['exito_torre'] = "Se registró el periferico con éxito";
        $_SESSION['estado'] = $estado;

    } else {

        $_SESSION['estado'] = $estado;
    };

}

function countErrorPerife($estado, $id, $marca, $modelo, $descripcion, $conexion) {

    if(count($estado) == 0) { //Si el array de estado está vacio, entonces se realiza la inserción a la BD

        ingresarProducPerife($id, $marca, $modelo, $descripcion, $conexion);
        $estado['exito_perife'] = "Se registró el periferico con éxito";
        $_SESSION['estado'] = $estado;

    } else {
        
        //En caso de que hayan estado, se guarda en una session el array asociativo.
        $_SESSION['estado'] = $estado;
    };
}

function ingresarProducTorre($id, $marca, $modelo, $procesador, $ram, $almacenamiento, $descripcion, $conexion, $user) {

    $id_verify = mysqli_real_escape_string($conexion, $id);                         //Se aplica función para evitar inyecciones SQL
    $marca_verify = mysqli_real_escape_string($conexion, $marca);                   //Se aplica función para evitar inyecciones SQL
    $modelo_verify = mysqli_real_escape_string($conexion, $modelo);                 //Se aplica función para evitar inyecciones SQL
    $proce_verify = mysqli_real_escape_string($conexion, $procesador);              //Se aplica función para evitar inyecciones SQL
    $ram_verify = mysqli_real_escape_string($conexion, $ram);                       //Se aplica función para evitar inyecciones SQL
    $almace_verify = mysqli_real_escape_string($conexion, $almacenamiento);         //Se aplica función para evitar inyecciones SQL
    $descripcion_verify = mysqli_real_escape_string($conexion, $descripcion);       //Se aplica función para evitar inyecciones SQL

    //Se genera la consulta para la BD
    $registro_equip = "INSERT INTO productos VALUES(NULL, '$id_verify', '$marca_verify', '$modelo_verify', '$proce_verify', '$ram_verify', '$almace_verify', CURDATE(), '$descripcion_verify', '$user', 1);";
    //Se inserta la consulta en la BD
    $insert = mysqli_query($conexion, $registro_equip);

}

function ingresarProducPerife($id, $marca, $modelo, $descripcion, $conexion) {

    $id_verify = mysqli_real_escape_string($conexion, $id);                         //Se aplica función para evitar inyecciones SQL
    $marca_verify = mysqli_real_escape_string($conexion, $marca);                   //Se aplica función para evitar inyecciones SQL
    $modelo_verify = mysqli_real_escape_string($conexion, $modelo);                 //Se aplica función para evitar inyecciones SQL
    $descripcion_verify = mysqli_real_escape_string($conexion, $descripcion);       //Se aplica función para evitar inyecciones SQL

    //Se genera la consulta para la BD
    $registro_perife = "INSERT INTO productos VALUES(NULL, '$id_verify', '$marca_verify', '$modelo_verify',NULL, NULL, NULL, CURDATE(), '$descripcion_verify', '$user', 1);";
    
    //Se inserta la consulta en la BD
    $insert = mysqli_query($conexion, $registro_perife);

}

?>