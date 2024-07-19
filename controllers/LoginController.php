<?php

require_once __DIR__ . '/../includes/conexion.php';

if(!isset($_SESSION)) {

    session_start();
};

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    unset($_SESSION['errores_log']);

    $email = isset($_POST['user']) ? mysqli_real_escape_string($conexion, $_POST['user']) : false;
    $password = isset($_POST['password']) ? mysqli_real_escape_string($conexion, $_POST['password']) : false;

    $errores_log = array();

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $errores_log['email'] = "El email ingresado no es valido";
    };

    if (empty($password)) {

        $errores_log['password'] = "Ingrese una contraseña";
    };

    if (count($errores_log) == 0) {


        insertQuery($user, $email, $password, $conexion, $errores_log);


    } else {

        $_SESSION['errores_log'] = $errores_log;
    };

    header('Location: ../index.php');

};

mysqli_close($conexion);


//----------------------------------------FUNCIONES----------------------------------------

function insertQuery($user, $email, $password, $conexion, $errores_log) {

    $select_log = "SELECT * FROM admin WHERE email = '$email';";
    $select_query = mysqli_query($conexion, $select_log);

    if (mysqli_num_rows($select_query) == 1) {

        $user = mysqli_fetch_assoc($select_query);
        $verify = password_verify($password, $user['contraseña']);

        verifyUser($verify, $user, $errores_log);
    }

}

function verifyUser($verify, $user, $errores_log) {

    if($verify) {

        $_SESSION['user'] = $user;
    
    } else {

        $errores_log['not_verify'] = "La contraseña no coincide";
        $_SESSION['errores_log'] = $errores_log;
    }

}

//Función creada para mostrar los errores en los campos de registro
function mostrarErrores($errores, $campo) {

    if(isset($_SESSION[$errores][$campo])) {

        echo "<div class='alert alert_error'>".$_SESSION[$errores][$campo]."</div>";

    } else {

        echo '';
    }
}

?>
