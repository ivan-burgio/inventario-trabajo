<?php

require_once '../includes/conexion.php';

//--------------CONSULTAS MYSQL---------------------

$list = "SELECT f.id_funcionario, f.nombre, f.apellido, s.nombre AS nombre_sector FROM funcionarios f
         INNER JOIN sectores s ON f.sector = s.id_sector";
$list_query = mysqli_query($conexion, $list);


$list_prod = "SELECT id, marca, modelo FROM productos;";
$list_prod_query = mysqli_query($conexion, $list_prod);

//------------VALIDACIÓN DE CAMPOS-------------------


if($_POST['ubic'] == 'Tele trabajo') {

    $equipo = isset($_POST['select_prod']) ? $_POST['select_prod'] : false;
    $funcionario = isset($_POST['selec_func']) ? $_POST['select_func'] : false;
    $domicilio = isset($_POST['direc']) ? $_POST['direc'] : false;
    $descripcion = isset($_POST['description']) ? $_POST['description'] : false;

    $errores = array();

    if(empty($domicilio)) {

        $errores['domicilio'] = "Ingrese el domicilio del funcionario";
    };

    if(empty($descripcion)) {

        $errores['descripcion'] = "Ingrese una descripción mayor a 20 caracteres";
    };

    $user = $_SESSION['user']['nombre'];

    $nombre_func_query = "SELECT nombre FROM funcionarios WHERE id_funcionario = '$funcionario';";

    $insert_alta_tt = "INSERT INTO altas_productos VALUES()";
};


?>