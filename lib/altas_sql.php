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

    $checks = isset($_POST['check']) ? $_POST['check'] : false;

    if($checks) {

    
        $funcionario = isset($_POST['select_func']) ? $_POST['select_func'] : false;
        $domicilio = isset($_POST['direc']) ? $_POST['direc'] : false;
        $sector = isset($_POST['sect']) ? $_POST['sect'] : false;
        $descripcion = isset($_POST['description']) ? $_POST['description'] : false;
    
    
        $estado = array();
    
        validarCampos($checks, $funcionario, $domicilio, $sector, $descripcion, $estado, $conexion);
    
        header('Location: ../pages/altas.php');
        exit();
        
    } 
};


//----------------------------------------FUNCIONES----------------------------------------

//Funcion para validar los datos ingresados en los campos del form
function validarCampos($checks, $funcionario, $domicilio, $sector, $descripcion, $estado, $conexion) {

    if(empty($descripcion)) {

        $estado['comentario'] = "Ingrese un comentario para el alta";
    };

    countError($checks, $estado, $funcionario, $domicilio, $sector, $descripcion, $conexion);

}

//Funcion para contar los posibles errores en los campos del form
function countError($checks, $estado, $funcionario, $domicilio, $sector, $descripcion, $conexion) {

    if(count($estado) == 0) {

        createQuery($checks, $estado, $funcionario, $domicilio, $sector, $descripcion, $conexion);

    } else {

        $_SESSION['errores'] = $estado;
    }
}

//Funcion para crear las querys de los select y aplicar la condicional dependiendo si es teletrabajo o plataforma
function createQuery($checks, $estado, $funcionario, $domicilio, $sector, $descripcion, $conexion) {

    $equipo_one = isset($checks[0]) ? $checks[0] : false;
    $equipo_two = isset($checks[1]) ? $checks[1] : false;
    $equipo_three = isset($checks[2]) ? $checks[2] : false;
    $equipo_four = isset($checks[3]) ? $checks[3] : false;
    $equipo_five = isset($checks[4]) ? $checks[4] : false;

    if($equipo_one != null) {

        $sql_marca_prod = "SELECT modelo FROM productos WHERE id = '$equipo_one';";
        $select_marca_prod = mysqli_query($conexion, $sql_marca_prod);
        $marca_prod = mysqli_fetch_assoc($select_marca_prod);
        $modelo_one = $marca_prod['modelo'];
    }


    if($equipo_two != null) {

        $sql_marca_prod = "SELECT modelo FROM productos WHERE id = '$equipo_two';";
        $select_marca_prod = mysqli_query($conexion, $sql_marca_prod);
        $marca_prod = mysqli_fetch_assoc($select_marca_prod);
        $modelo_two = $marca_prod['modelo'];
    }

    if($equipo_three != null) {

        $sql_marca_prod = "SELECT modelo FROM productos WHERE id = '$equipo_three';";
        $select_marca_prod = mysqli_query($conexion, $sql_marca_prod);
        $marca_prod = mysqli_fetch_assoc($select_marca_prod);
        $modelo_three = $marca_prod['modelo'];
    }

    if($equipo_four != null) {

        $sql_marca_prod = "SELECT modelo FROM productos WHERE id = '$equipo_four';";
        $select_marca_prod = mysqli_query($conexion, $sql_marca_prod);
        $marca_prod = mysqli_fetch_assoc($select_marca_prod);
        $modelo_four = $marca_prod['modelo'];
    }

    if($equipo_five != null) {

        $sql_marca_prod = "SELECT modelo FROM productos WHERE id = '$equipo_five';";
        $select_marca_prod = mysqli_query($conexion, $sql_marca_prod);
        $marca_prod = mysqli_fetch_assoc($select_marca_prod);
        $modelo_five = $marca_prod['modelo'];
    }

    $sql_nombre_func = "SELECT nombre, apellido FROM funcionarios WHERE id_funcionario = '$funcionario';";
    $select_nombre_func = mysqli_query($conexion, $sql_nombre_func);
    $nombre_func = mysqli_fetch_assoc($select_nombre_func);
    $nombre = $nombre_func['nombre'].' '.$nombre_func['apellido'];

    $user = $_SESSION['user']['nombre'].' '.$_SESSION['user']['apellido'];
    $user_id = $_SESSION['user']['id_admin'];


    if($_POST['ubic'] == 'home') {

        insertQueryHome($funcionario, $checks, $modelo_one, $modelo_two, $modelo_three, $modelo_four, $modelo_five, $nombre, $domicilio, $descripcion, $user, $user_id, $conexion);

    } elseif($_POST['ubic'] == 'plataforma') {

        $puesto = isset($_POST['box']) ? $_POST['box'] : false;
        insertQueryPlat($funcionario, $checks, $modelo_one, $modelo_two, $modelo_three, $modelo_four, $modelo_five, $nombre, $sector, $puesto, $descripcion, $user, $user_id, $conexion);

    };
}

//Funcion para gestionar el alta para teletrabajo
function insertQueryHome($funcionario, $checks, $modelo_one, $modelo_two, $modelo_three, $modelo_four, $modelo_five, $nombre, $domicilio, $descripcion, $user, $user_id, $conexion) {

    $fecha_actual = date('Y-m-d H:i:s');

    $equipo_one = isset($checks[0]) ? $checks[0] : false;
    $equipo_two = isset($checks[1]) ? $checks[1] : false;
    $equipo_three = isset($checks[2]) ? $checks[2] : false;
    $equipo_four = isset($checks[3]) ? $checks[3] : false;
    $equipo_five = isset($checks[4]) ? $checks[4] : false;

    if($equipo_one != null && $modelo_one) {

        $insert_alta_tt = "INSERT INTO altas_productos 
        VALUES(NULL, '$funcionario', '$equipo_one', '$modelo_one', '$nombre', '$fecha_actual','$domicilio', NULL, '$descripcion', '$user', 1);";
        $insert_query = mysqli_query($conexion, $insert_alta_tt); 
    
        $comentario_inicial = "INSERT INTO comentarios VALUES(NULL, '$user_id', '$equipo_one', '$descripcion', '$fecha_actual');";
        $insert_comentario = mysqli_query($conexion, $comentario_inicial);
    
        $modify_status = "UPDATE productos SET status = 2 WHERE id = '$equipo_one';";
        $modify_query = mysqli_query($conexion, $modify_status);
    }

    if($equipo_two != null && $modelo_two) {

        $insert_alta_tt = "INSERT INTO altas_productos 
        VALUES(NULL, '$funcionario', '$equipo_two', '$modelo_two', '$nombre', '$fecha_actual','$domicilio', NULL, '$descripcion', '$user', 1);";
        $insert_query = mysqli_query($conexion, $insert_alta_tt); 
    
        $comentario_inicial = "INSERT INTO comentarios VALUES(NULL, '$user_id', '$equipo_two', '$descripcion', '$fecha_actual');";
        $insert_comentario = mysqli_query($conexion, $comentario_inicial);
    
        $modify_status = "UPDATE productos SET status = 2 WHERE id = '$equipo_two';";
        $modify_query = mysqli_query($conexion, $modify_status);
    }

    if($equipo_three != null && $modelo_three) {

        $insert_alta_tt = "INSERT INTO altas_productos 
        VALUES(NULL, '$funcionario', '$equipo_three', '$modelo_three', '$nombre', '$fecha_actual','$domicilio', NULL, '$descripcion', '$user', 1);";
        $insert_query = mysqli_query($conexion, $insert_alta_tt); 
    
        $comentario_inicial = "INSERT INTO comentarios VALUES(NULL, '$user_id', '$equipo_three', '$descripcion', '$fecha_actual');";
        $insert_comentario = mysqli_query($conexion, $comentario_inicial);
    
        $modify_status = "UPDATE productos SET status = 2 WHERE id = '$equipo_three';";
        $modify_query = mysqli_query($conexion, $modify_status);
    }

    if($equipo_four != null && $modelo_four) {

        $insert_alta_tt = "INSERT INTO altas_productos 
        VALUES(NULL, '$funcionario', '$equipo_four', '$modelo_four', '$nombre', '$fecha_actual','$domicilio', NULL, '$descripcion', '$user', 1);";
        $insert_query = mysqli_query($conexion, $insert_alta_tt); 
    
        $comentario_inicial = "INSERT INTO comentarios VALUES(NULL, '$user_id', '$equipo_four', '$descripcion', '$fecha_actual');";
        $insert_comentario = mysqli_query($conexion, $comentario_inicial);
    
        $modify_status = "UPDATE productos SET status = 2 WHERE id = '$equipo_four';";
        $modify_query = mysqli_query($conexion, $modify_status);
    }

    if($equipo_five != null && $modelo_five) {

        $insert_alta_tt = "INSERT INTO altas_productos 
        VALUES(NULL, '$funcionario', '$equipo_five', '$modelo_five', '$nombre', '$fecha_actual','$domicilio', NULL, '$descripcion', '$user', 1);";
        $insert_query = mysqli_query($conexion, $insert_alta_tt); 
    
        $comentario_inicial = "INSERT INTO comentarios VALUES(NULL, '$user_id', '$equipo_five', '$descripcion', '$fecha_actual');";
        $insert_comentario = mysqli_query($conexion, $comentario_inicial);
    
        $modify_status = "UPDATE productos SET status = 2 WHERE id = '$equipo_five';";
        $modify_query = mysqli_query($conexion, $modify_status);
    }


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
function insertQueryPlat($funcionario, $equipo, $modelo_one, $modelo_two, $modelo_three, $modelo_four, $modelo_five, $nombre, $sector, $puesto, $descripcion, $user, $user_id, $conexion) {

    $fecha_actual = date('Y-m-d H:i:s');

    if($equipo_one != null && $modelo_one) {

        $insert_alta_plat = "INSERT INTO altas_productos 
        VALUES(NULL, '$funcionario', '$equipo_one', '$modelo_one', '$nombre', '$fecha_actual', '$sector', '$puesto', '$descripcion', '$user', 1);";
        $insert_query = mysqli_query($conexion, $insert_alta_plat); 

        $comentario_inicial = "INSERT INTO comentarios VALUES(NULL, '$user_id', '$equipo_one', '$descripcion', '$fecha_actual');";
        $insert_comentario = mysqli_query($conexion, $comentario_inicial);;


        $modify_status = "UPDATE productos SET status = 2 WHERE id = '$equipo_one';";
        $modify_query = mysqli_query($conexion, $modify_status);
    }

    if($equipo_two != null && $modelo_two) {

        $insert_alta_plat = "INSERT INTO altas_productos 
        VALUES(NULL, '$funcionario', '$equipo_two', '$modelo_two', '$nombre', '$fecha_actual', '$sector', '$puesto', '$descripcion', '$user', 1);";
        $insert_query = mysqli_query($conexion, $insert_alta_plat); 

        $comentario_inicial = "INSERT INTO comentarios VALUES(NULL, '$user_id', '$equipo_two', '$descripcion', '$fecha_actual');";
        $insert_comentario = mysqli_query($conexion, $comentario_inicial);;


        $modify_status = "UPDATE productos SET status = 2 WHERE id = '$equipo_two';";
        $modify_query = mysqli_query($conexion, $modify_status);
    }

    if($equipo_three != null && $modelo_three) {

        $insert_alta_plat = "INSERT INTO altas_productos 
        VALUES(NULL, '$funcionario', '$equipo_three', '$modelo_three', '$nombre', '$fecha_actual', '$sector', '$puesto', '$descripcion', '$user', 1);";
        $insert_query = mysqli_query($conexion, $insert_alta_plat); 

        $comentario_inicial = "INSERT INTO comentarios VALUES(NULL, '$user_id', '$equipo_three', '$descripcion', '$fecha_actual');";
        $insert_comentario = mysqli_query($conexion, $comentario_inicial);;


        $modify_status = "UPDATE productos SET status = 2 WHERE id = '$equipo_three';";
        $modify_query = mysqli_query($conexion, $modify_status);
    }

    if($equipo_four != null && $modelo_four) {

        $insert_alta_plat = "INSERT INTO altas_productos 
        VALUES(NULL, '$funcionario', '$equipo_four', '$modelo_four', '$nombre', '$fecha_actual', '$sector', '$puesto', '$descripcion', '$user', 1);";
        $insert_query = mysqli_query($conexion, $insert_alta_plat); 

        $comentario_inicial = "INSERT INTO comentarios VALUES(NULL, '$user_id', '$equipo_four', '$descripcion', '$fecha_actual');";
        $insert_comentario = mysqli_query($conexion, $comentario_inicial);;


        $modify_status = "UPDATE productos SET status = 2 WHERE id = '$equipo_four';";
        $modify_query = mysqli_query($conexion, $modify_status);
    }

    if($equipo_five != null && $modelo_five) {

        $insert_alta_plat = "INSERT INTO altas_productos 
        VALUES(NULL, '$funcionario', '$equipo_five', '$modelo_five', '$nombre', '$fecha_actual', '$sector', '$puesto', '$descripcion', '$user', 1);";
        $insert_query = mysqli_query($conexion, $insert_alta_plat); 

        $comentario_inicial = "INSERT INTO comentarios VALUES(NULL, '$user_id', '$equipo_five', '$descripcion', '$fecha_actual');";
        $insert_comentario = mysqli_query($conexion, $comentario_inicial);;


        $modify_status = "UPDATE productos SET status = 2 WHERE id = '$equipo_five';";
        $modify_query = mysqli_query($conexion, $modify_status);
    }


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