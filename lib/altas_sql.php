<?php

require_once '../includes/conexion.php';

//--------------CONSULTAS MYSQL---------------------

$list = "SELECT f.id_funcionario, f.nombre, f.apellido, s.nombre AS nombre_sector FROM funcionarios f
         INNER JOIN sectores s ON f.sector = s.id_sector";
$list_query = mysqli_query($conexion, $list);


$list_prod = "SELECT id, marca, modelo FROM productos WHERE status = 1;";
$list_prod_query = mysqli_query($conexion, $list_prod);

//------------VALIDACIÓN DE CAMPOS-------------------


if(isset($_POST['ubic'])) {

    $equipo = isset($_POST['select_prod']) ? $_POST['select_prod'] : false;
    $funcionario = isset($_POST['select_func']) ? $_POST['select_func'] : false;
    $domicilio = isset($_POST['direc']) ? $_POST['direc'] : false;
    $plataforma = isset($_POST['box']) ? $_POST['box'] : false;
    $descripcion = isset($_POST['description']) ? $_POST['description'] : false;

    $estado = array();

    if(empty($domicilio)) {

        $estado['domicilio'] = "Ingrese el domicilio del funcionario";
    };

    if(empty($descripcion) || strlen($descripcion) < 20) {

        $estado['descripcion'] = "Ingrese una descripción mayor a 20 caracteres";
    };

 

    if(count($estado) == 0) {

        $sql_marca_prod = "SELECT modelo FROM productos WHERE id = '$equipo';";
        $select_marca_prod = mysqli_query($conexion, $sql_marca_prod);
        $marca_prod = mysqli_fetch_assoc($select_marca_prod);
        $modelo = $marca_prod['modelo'];

        $sql_nombre_func = "SELECT nombre, apellido FROM funcionarios WHERE id_funcionario = '$funcionario';";
        $select_nombre_func = mysqli_query($conexion, $sql_nombre_func);
        $nombre_func = mysqli_fetch_assoc($select_nombre_func);
        $nombre = $nombre_func['nombre'].' '.$nombre_func['apellido'];

        $user = $_SESSION['user']['nombre'].' '.$_SESSION['user']['apellido'];

        if($_POST['ubic'] == 'home') {

            $insert_alta_tt = "INSERT INTO altas_productos 
            VALUES('$funcionario', '$equipo', '$modelo', '$nombre', CURDATE(), '$domicilio', '$descripcion', '$user', 1);";

            $modify_status = "UPDATE productos SET status = 2 WHERE id = '$equipo';";
            $modify_query = mysqli_query($conexion, $modify_status);

            $insert_query = mysqli_query($conexion, $insert_alta_tt); 

            if(!$insert_query) {

            $error = mysqli_error($insert_query);
            echo $error;
            exit();

            }

        } else if($_POST['ubic'] == 'plataforma') {

            $insert_alta_tt = "INSERT INTO altas_productos 
            VALUES('$funcionario', '$equipo', '$modelo', '$nombre', CURDATE(), '$plataforma', '$descripcion', '$user', 2);";

            $modify_status = "UPDATE productos SET status = 2 WHERE id = '$equipo';";
            $modify_query = mysqli_query($conexion, $modify_status);

            $insert_query = mysqli_query($conexion, $insert_alta_tt); 

            if(!$insert_query) {

            $error = mysqli_error($insert_query);
            echo $error;
            exit();
            
            };
        };

        $estado['exito'] = "Alta generada con exito";
        $_SESSION['estados'] = $estados;
    };

    header('Location: ../pages/altas.php');
};

mysqli_close($conexion);

?>