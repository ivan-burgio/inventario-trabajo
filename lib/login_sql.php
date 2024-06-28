<?php

require_once __DIR__ . '/../includes/conexion.php';

if(!isset($_SESSION)) {

    session_start();
};

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = isset($_POST['user']) ? mysqli_real_escape_string($conexion, $_POST['user']) : false;
    $password = isset($_POST['password']) ? mysqli_real_escape_string($conexion, $_POST['password']) : false;

    $errores_log = array();

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $errores_log['email'] = "El email ingresado no es valido";
    };

    if (empty($password)) {

        $errores_log['password'] = "Ingrese una contraseña valida";
    };

    if (count($errores_log) == 0) {


        insertQuery($verify, $user);


    } else {

        $_SESSION['errores_log'] = $errores_log;
    };

    header('Location: ../index.php');

};

mysqli_close($conexion);


//----------------------------------------FUNCIONES----------------------------------------

function insertQuery($verify, $user) {

    $select_log = "SELECT * FROM admin WHERE email = '$email';";
    $select_query = mysqli_query($conexion, $select_log);

    if (mysqli_num_rows($select_query) == 1) {

        $user = mysqli_fetch_assoc($select_query);
        $verify = password_verify($password, $user['contraseña']);

        verifyUser($verify);
    }

}

function verifyUser($verify) {

    if($verify) {

        $_SESSION['user'] = $user;
    
    } else {

        $_SESSION['error_login'] = "Login incorrecto";
    }

}

?>
