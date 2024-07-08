<?php

require_once '../includes/conexion.php';
require_once '../includes/helpers.php';

//--------------CONSULTAS MYSQL---------------------

$list = "SELECT f.id_funcionario, f.nombre, f.apellido, s.nombre AS nombre_sector FROM funcionarios f
         INNER JOIN sectores s ON f.sector = s.id_sector";
$list_query = mysqli_query($conexion, $list);


$list_prod = "SELECT id, id_prod, marca, modelo FROM productos WHERE status = 1;";
$list_prod_query = mysqli_query($conexion, $list_prod);

//------------VALIDACIÓN DE CAMPOS-------------------

if(isset($_POST['ubic'])) {

    unset($_SESSION['estado']);
    unset($_SESSION['errores']);

    $equipo = isset($_POST['select_prod']) ? $_POST['select_prod'] : false;
    $funcionario = isset($_POST['select_func']) ? $_POST['select_func'] : false;
    $domicilio = isset($_POST['direc']) ? $_POST['direc'] : false;
    $sector = isset($_POST['sect']) ? $_POST['sect'] : false;
    $descripcion = isset($_POST['description']) ? $_POST['description'] : false;

    $estado = array();

    validarCampos($equipo, $funcionario, $domicilio, $sector, $descripcion, $estado, $conexion);

    header('Location: ../pages/altas.php');
    exit();
};


//----------------------------------------FUNCIONES----------------------------------------

//Funcion para validar los datos ingresados en los campos del form
function validarCampos($equipo, $funcionario, $domicilio, $sector, $descripcion, $estado, $conexion) {

    if(empty($descripcion)) {

        $estado['comentario'] = "Ingrese un comentario para el alta";
    };

    countError($equipo, $estado, $funcionario, $domicilio, $sector, $descripcion, $conexion);

}

//Funcion para contar los posibles errores en los campos del form
function countError($equipo, $estado, $funcionario, $domicilio, $sector, $descripcion, $conexion) {

    if(count($estado) == 0) {

        createQuery($equipo, $estado, $funcionario, $domicilio, $sector, $descripcion, $conexion);

    } else {

        $_SESSION['errores'] = $estado;
    }
}

//Funcion para crear las querys de los select y aplicar la condicional dependiendo si es teletrabajo o plataforma
function createQuery($equipo, $estado, $funcionario, $domicilio, $sector, $descripcion, $conexion) {


    $sql_marca_prod = "SELECT modelo FROM productos WHERE id = '$equipo';";
    $select_marca_prod = mysqli_query($conexion, $sql_marca_prod);
    $marca_prod = mysqli_fetch_assoc($select_marca_prod);
    $modelo = $marca_prod['modelo'];

    $sql_nombre_func = "SELECT nombre, apellido FROM funcionarios WHERE id_funcionario = '$funcionario';";
    $select_nombre_func = mysqli_query($conexion, $sql_nombre_func);
    $nombre_func = mysqli_fetch_assoc($select_nombre_func);
    $nombre = $nombre_func['nombre'].' '.$nombre_func['apellido'];

    $user = $_SESSION['user']['nombre'].' '.$_SESSION['user']['apellido'];
    $user_id = $_SESSION['user']['id_admin'];


    if($_POST['ubic'] == 'home') {

        insertQueryHome($funcionario, $equipo, $modelo, $nombre, $domicilio, $descripcion, $user, $user_id, $conexion);

    } elseif($_POST['ubic'] == 'plataforma') {

        $puesto = isset($_POST['box']) ? $_POST['box'] : false;
        insertQueryPlat($funcionario, $equipo, $modelo, $nombre, $sector, $puesto, $descripcion, $user, $user_id, $conexion);

    };
}

//Funcion para gestionar el alta para teletrabajo
function insertQueryHome($funcionario, $equipo, $modelo, $nombre, $domicilio, $descripcion, $user, $user_id, $conexion) {

    $fecha_actual = date('Y-m-d H:i:s');

    $insert_alta_tt = "INSERT INTO altas_productos 
    VALUES(NULL, '$funcionario', '$equipo', '$modelo', '$nombre', '$fecha_actual','$domicilio', NULL, '$descripcion', '$user', 1);";
    $insert_query = mysqli_query($conexion, $insert_alta_tt); 

    $comentario_inicial = "INSERT INTO comentarios VALUES(NULL, '$user_id', '$equipo', '$descripcion', '$fecha_actual');";
    $insert_comentario = mysqli_query($conexion, $comentario_inicial);

    $modify_status = "UPDATE productos SET status = 2 WHERE id = '$equipo';";
    $modify_query = mysqli_query($conexion, $modify_status);

    $fecha = date('d-m-Y');

    if(!$insert_query) {

        $error = mysqli_error($insert_query);
        echo $error;
        exit();

    } else {

        archivoTT($funcionario, $nombre, $fecha);
        $estado['exito'] = "Alta para teletrabajo generada con exito";
        $_SESSION['estado'] = $estado;    
    
        exit();
    }
}

//Funcion para gestioanr el alta para plataforma
function insertQueryPlat($funcionario, $equipo, $modelo, $nombre, $sector, $puesto, $descripcion, $user, $user_id, $conexion) {

    $fecha_actual = date('Y-m-d H:i:s');

    $insert_alta_plat = "INSERT INTO altas_productos 
    VALUES(NULL, '$funcionario', '$equipo', '$modelo', '$nombre', '$fecha_actual', '$sector', '$puesto', '$descripcion', '$user', 1);";
    $insert_query = mysqli_query($conexion, $insert_alta_plat); 

    $comentario_inicial = "INSERT INTO comentarios VALUES(NULL, '$user_id', '$equipo', '$descripcion', '$fecha_actual');";
    $insert_comentario = mysqli_query($conexion, $comentario_inicial);;


    $modify_status = "UPDATE productos SET status = 2 WHERE id = '$equipo';";
    $modify_query = mysqli_query($conexion, $modify_status);

    if(!$insert_query) {
    $error = mysqli_error($insert_query);
    echo $error;
    exit();
    
    } else {

        $estado['exito'] = "Alta para plataforma generada con exito";
        $_SESSION['estado'] = $estado;    
    }
}

?>