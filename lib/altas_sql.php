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


if($_POST) {



    unset($_SESSION['estado']);
    unset($_SESSION['errores']);
    unset($_SESSION['producto']);

    $checks = isset($_POST['check']) ? $_POST['check'] : false;

    if ($checks) {

        $funcionario = isset($_POST['select_func']) ? $_POST['select_func'] : false;
        $domicilio = isset($_POST['direc']) ? $_POST['direc'] : false;
        $sector = isset($_POST['sect']) ? $_POST['sect'] : false;
        $descripcion = isset($_POST['description']) ? $_POST['description'] : false;

        $estado = array();

        validarCampos($checks, $funcionario, $domicilio, $sector, $descripcion, $estado, $conexion);

        header('Location: ../pages/altas.php');
        exit();

    } else {

        $_SESSION['producto']['error'] = 'Seleccione por lo menos un producto';
        header('Location: ../pages/altas.php');
        exit();
    }

}

//----------------------------------------FUNCIONES----------------------------------------

// Funcion para validar los datos ingresados en los campos del form
function validarCampos($checks, $funcionario, $domicilio, $sector, $descripcion, $estado, $conexion) {

    if(empty($descripcion)) {

        $estado['comentario'] = "Ingrese un comentario para el alta";

    }

    countError($checks, $estado, $funcionario, $domicilio, $sector, $descripcion, $conexion);
}

// Funcion para contar los posibles errores en los campos del form
function countError($checks, $estado, $funcionario, $domicilio, $sector, $descripcion, $conexion) {

    if (count($estado) == 0) {

        createQuery($checks, $estado, $funcionario, $domicilio, $sector, $descripcion, $conexion);

    } else {

        $_SESSION['errores'] = $estado;
        header('Location: ../pages/altas.php');
        exit();
    }
}

// Funcion para crear las querys de los select y aplicar la condicional dependiendo si es teletrabajo o plataforma
function createQuery($checks, $estado, $funcionario, $domicilio, $sector, $descripcion, $conexion) {

    $equipo_one = isset($checks[0]) ? $checks[0] : false;
    $equipo_two = isset($checks[1]) ? $checks[1] : false;
    $equipo_three = isset($checks[2]) ? $checks[2] : false;
    $equipo_four = isset($checks[3]) ? $checks[3] : false;
    $equipo_five = isset($checks[4]) ? $checks[4] : false;
    $equipo_six = isset($checks[0]) ? $checks[0] : false;
    $equipo_seven = isset($checks[1]) ? $checks[1] : false;
    $equipo_eight = isset($checks[2]) ? $checks[2] : false;
    $equipo_nine = isset($checks[3]) ? $checks[3] : false;
    $equipo_ten = isset($checks[4]) ? $checks[4] : false;

    $modelos = [];

    foreach ([$equipo_one, $equipo_two, $equipo_three, $equipo_four, $equipo_five, $equipo_six, $equipo_seven, $equipo_eight, $equipo_nine, $equipo_ten] as $equipo) {

        if ($equipo != null) {
            $sql_marca_prod = "SELECT modelo FROM productos WHERE id = '" . mysqli_real_escape_string($conexion, $equipo) . "';";
            $select_marca_prod = mysqli_query($conexion, $sql_marca_prod);
            $marca_prod = mysqli_fetch_assoc($select_marca_prod);
            $modelos[] = $marca_prod['modelo'];
        } else {
            $modelos[] = false;
        }
    }

    $sql_nombre_func = "SELECT nombre, apellido FROM funcionarios WHERE id_funcionario = '" . mysqli_real_escape_string($conexion, $funcionario) . "';";
    $select_nombre_func = mysqli_query($conexion, $sql_nombre_func);
    $nombre_func = mysqli_fetch_assoc($select_nombre_func);
    $nombre = $nombre_func['nombre'] . ' ' . $nombre_func['apellido'];

    $user = $_SESSION['user']['nombre'] . ' ' . $_SESSION['user']['apellido'];
    $user_id = $_SESSION['user']['id_admin'];

    if ($_POST['ubic'] == 'home') {

        insertQueryHome($funcionario, $checks, $modelos, $nombre, $domicilio, $descripcion, $user, $user_id, $conexion);

    } elseif ($_POST['ubic'] == 'plataforma') {
        
        $puesto = isset($_POST['box']) ? $_POST['box'] : false;
        insertQueryPlat($funcionario, $checks, $modelos, $nombre, $sector, $puesto, $descripcion, $user, $user_id, $conexion);
    }
}

// Funcion para gestionar el alta para teletrabajo
function insertQueryHome($funcionario, $checks, $modelos, $nombre, $domicilio, $descripcion, $user, $user_id, $conexion) {
    
    $fecha_actual = date('Y-m-d H:i:s');

    foreach ($checks as $index => $equipo) {
        if ($equipo != null && $modelos[$index]) {
            $sql = "INSERT INTO altas_productos 
                    VALUES(NULL, '$funcionario', '$equipo', '" . mysqli_real_escape_string($conexion, $modelos[$index]) . "', '$nombre', '$fecha_actual', '$domicilio', NULL, '$descripcion', '$user', 1);";
            $insert_query = mysqli_query($conexion, $sql);

            $comentario_inicial = "INSERT INTO comentarios VALUES(NULL, '$user_id', '$equipo', '$descripcion', '$fecha_actual');";
            $insert_comentario = mysqli_query($conexion, $comentario_inicial);

            $modify_status = "UPDATE productos SET status = 2 WHERE id = '$equipo';";
            $modify_query = mysqli_query($conexion, $modify_status);
        }
    }

    $fecha = date('d-m-Y');

    if (!$insert_query) {
        $error = mysqli_error($conexion);
        echo $error;
        exit();
    } else {
        archivoTT($funcionario, $nombre, $fecha);
        $estado['exito'] = "Alta para teletrabajo generada con exito";
        $_SESSION['estado'] = $estado;
        exit();
    }
}

// Funcion para gestioanr el alta para plataforma
function insertQueryPlat($funcionario, $checks, $modelos, $nombre, $sector, $puesto, $descripcion, $user, $user_id, $conexion) {

    $fecha_actual = date('Y-m-d H:i:s');

    foreach ($checks as $index => $equipo) {
        if ($equipo != null && $modelos[$index]) {
            $sql = "INSERT INTO altas_productos 
                    VALUES(NULL, '$funcionario', '$equipo', '" . mysqli_real_escape_string($conexion, $modelos[$index]) . "', '$nombre', '$fecha_actual', '$sector', '$puesto', '$descripcion', '$user', 1);";
            $insert_query = mysqli_query($conexion, $sql);

            $comentario_inicial = "INSERT INTO comentarios VALUES(NULL, '$user_id', '$equipo', '$descripcion', '$fecha_actual');";
            $insert_comentario = mysqli_query($conexion, $comentario_inicial);

            $modify_status = "UPDATE productos SET status = 2 WHERE id = '$equipo';";
            $modify_query = mysqli_query($conexion, $modify_status);
        }
    }

    if (!$insert_query) {
        $error = mysqli_error($conexion);
        echo $error;
        exit();
    } else {
        $estado['exito'] = "Alta para plataforma generada con exito";
        $_SESSION['estado'] = $estado;
    }
}
?>
