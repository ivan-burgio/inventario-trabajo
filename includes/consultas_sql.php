<?php

require_once 'conexion.php';

//Validar e ingresar los datos de los productos que se ingresan a la tabla productos.

if($_POST) {

    session_unset();

    $id = isset($_POST['id']) ? $_POST['id'] : false;
    $marca = isset($_POST['marca']) ? $_POST['marca'] : false;
    $modelo = isset($_POST['modelo']) ? $_POST['modelo'] : false;
    $procesador = isset($_POST['proce']) ? $_POST['proce'] : false;
    $ram = isset($_POST['ram']) ? $_POST['ram'] : false;
    $almacenamiento = isset($_POST['almace']) ? $_POST['almace'] : false;
    $fecha = isset($_POST['fecha']) ? $_POST['fecha'] : false;
    $descripcion = isset($_POST['description']) ? $_POST['description'] : false;

    $errores = array();

    if(empty($id)) {

        $errores['id'] = "Ingrese un ID";
    };

    if(empty($marca) || preg_match("[/0-9/]", $marca)) {

        $errores['marca'] = "Ingrese una marca valida";
    };

    if(empty($modelo)) {

        $errores['modelo'] = "Ingrese un modelo";
    };

    if(empty($fecha)) {

        $errores['fecha'] = "Ingrese la fecha de alta del equipo";
    };

    if(empty($descripcion) || strlen($descripcion) < 20) {

        $errores['descripcion'] = "Ingrese una descripcion mayor a 20 caracteres";
    };

    if($_POST['select'] && $_POST['select'] == 'torre') {

        if(empty($procesador)) {

            $errores['procesador'] = "Ingrese el CPU del equipo";
        };
    
        if(empty($ram)) {
    
            $errores['ram'] = "Ingrese la RAM del equipo";
        };
    
        if(empty($almacenamiento)) {
    
            $errores['almacenamiento'] = "Ingrese el almacenamiento del equipo";
        };

        if(count($errores) == 0) {

            $id_verify = mysqli_real_escape_string($conexion, $id);
            $marca_verify = mysqli_real_escape_string($conexion, $marca);
            $modelo_verify = mysqli_real_escape_string($conexion, $modelo);
            $proce_verify = mysqli_real_escape_string($conexion, $procesador);
            $ram_verify = mysqli_real_escape_string($conexion, $ram);
            $almace_verify = mysqli_real_escape_string($conexion, $almacenamiento);
            $descripcion_verify = mysqli_real_escape_string($conexion, $descripcion);
        
            $sql2 = "INSERT INTO productos VALUES('$id_verify', '$marca_verify', '$modelo_verify', '$proce_verify', '$ram_verify', '$almace_verify', '$fecha', '$descripcion_verify');";
        
            $insert = mysqli_query($conexion, $sql2);
    
        } else {
    
            $_SESSION['errores'] = $errores;
        };

    } elseif($_POST['select'] && $_POST['select'] == 'perife') {

        if(count($errores) == 0) {

            $id_verify = mysqli_real_escape_string($conexion, $id);
            $marca_verify = mysqli_real_escape_string($conexion, $marca);
            $modelo_verify = mysqli_real_escape_string($conexion, $modelo);
            $descripcion_verify = mysqli_real_escape_string($conexion, $descripcion);
        
            $sql3 = "INSERT INTO productos VALUES('$id_verify', '$marca_verify', '$modelo_verify',NULL, NULL, NULL, '$fecha', '$descripcion_verify');";
        
            $insert = mysqli_query($conexion, $sql3);
    
        } else {
    
            $_SESSION['errores'] = $errores;
        };
    
    } else {

        $errores['select'] = "Seleccione una opcion";
    }




    header('Location: ../registro.php');
    
};

//Seleccionar los datos de la tabla productos

if(!isset($_SESSION)) {
    
    session_start();
};

$sql = "SELECT id, marca, modelo, COUNT(modelo) AS stock FROM productos GROUP BY modelo;";

$select = mysqli_query($conexion, $sql);


//Traer una lista de los elementos que se llamen al momento de seleccionar un elemento de una tabla

if(isset($_GET)) {

    $modelo_get = isset($_GET['modelo']) ? $_GET['modelo'] : false;

    $select_pro = "SELECT * FROM productos WHERE modelo = '$modelo_get';";

    $query_pro = mysqli_query($conexion, $select_pro);
}
