<?php
require_once '../includes/conexion.php';

//Validar e ingresar los datos de los productos que se ingresan a la tabla productos.
if($_POST) {

    unset($_SESSION['errores']);

    $id = isset($_POST['id']) ? $_POST['id'] : false;                               //Se valida la existencia de datos enviados por POST
    $marca = isset($_POST['marca']) ? $_POST['marca'] : false;                      //Se valida la existencia de datos enviados por POST
    $modelo = isset($_POST['modelo']) ? $_POST['modelo'] : false;                   //Se valida la existencia de datos enviados por POST
    $procesador = isset($_POST['proce']) ? $_POST['proce'] : false;                 //Se valida la existencia de datos enviados por POST
    $ram = isset($_POST['ram']) ? $_POST['ram'] : false;                            //Se valida la existencia de datos enviados por POST
    $almacenamiento = isset($_POST['almace']) ? $_POST['almace'] : false;           //Se valida la existencia de datos enviados por POST
    $descripcion = isset($_POST['description']) ? $_POST['description'] : false;    //Se valida la existencia de datos enviados por POST
    $user = $_SESSION['user']['nombre'].' '.$_SESSION['user']['apellido'];
    $user_admin = $_SESSION['user']['id_admin'];

    $errores = array();     //Se crea array de errores

    validacionCampos($id, $marca, $modelo, $procesador, $ram, $almacenamiento, $descripcion, $user, $user_admin, $errores, $conexion);
    
    //Redirigue la ubicación de la página hacia el registro
    header('Location: ../pages/registro.php');
    exit();
};

//----------------------------------------FUNCIONES----------------------------------------


function validacionCampos($id, $marca, $modelo, $procesador, $ram, $almacenamiento, $descripcion, $user, $user_admin, $errores, $conexion) {

    //Validación de los campos
    if(empty($id)) {

        $errores['id'] = "Ingrese un ID";
    };

    if(empty($marca) || preg_match("[/0-9/]", $marca)) {

        $errores['marca'] = "Ingrese la marca del equipo";
    };

    if(empty($modelo)) {

        $errores['modelo'] = "Ingrese el modelo del equipo";
    };

    if(empty($descripcion)) {

        $errores['descripcion'] = "Ingrese una descripción generica del equipo";
    };

    if(empty($procesador)) {

        $errores['procesador'] = "Ingrese el procesador del equipo";
    };

    if(empty($ram)) {

        $errores['ram'] = "Ingrese la RAM del equipo";
    };

    if(empty($almacenamiento)) {

        $errores['almacenamiento'] = "Ingrese el almacenamiento del equipo";
    };

    validarTipoProducto($id, $marca, $modelo, $procesador, $ram, $almacenamiento, $descripcion, $user, $user_admin, $errores, $conexion);


}

function validarTipoProducto($id, $marca, $modelo, $procesador, $ram, $almacenamiento, $descripcion, $user, $user_admin, $errores, $conexion) {

    //Se valida el tipo de valor del select
    if($_POST['select'] && $_POST['select'] == 'torre') { //En caso de que sea 'torre' se validan los otros campos

        countErrorTorre($errores, $id, $marca, $modelo, $procesador, $ram, $almacenamiento, $descripcion, $conexion, $user);

    //Se valida el tipo de valor del select
    } elseif($_POST['select'] && $_POST['select'] == 'perife') { //En caso de que sea 'perife' se realiza la validación del array de errores

        countErrorPerife($errores, $id, $marca, $modelo, $descripcion, $conexion);

    } else {

        //Si no se selecciona alguno de los dos valores anteriormente mencionados, se guarda en el array de $errores
        $errores['select'] = "Seleccione una opcion";
        $_SESSION['errores'] = $errores;
    }
    
}

function countErrorTorre($errores, $id, $marca, $modelo, $procesador, $ram, $almacenamiento, $descripcion, $conexion, $user) {

    if(count($errores) == 0) { //Si el array de errores está vacio, entonces se realiza la inserción a la BD

        ingresarProducTorre($id, $marca, $modelo, $procesador, $ram, $almacenamiento, $descripcion, $conexion, $user);

    } else {

        $_SESSION['errores'] = $errores;
    };

}

function countErrorPerife($errores, $id, $marca, $modelo, $descripcion, $conexion) {

    if(count($errores) == 0) { //Si el array de errores está vacio, entonces se realiza la inserción a la BD

        ingresarProducPerife($id, $marca, $modelo, $descripcion, $conexion);

    } else {
        
        //En caso de que hayan errores, se guarda en una session el array asociativo.
        $_SESSION['errores'] = $errores;
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