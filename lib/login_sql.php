<?php

require_once 'C:\wamp64\www\prog\inventario-trabajo\includes\conexion.php';

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

        $select_log = "SELECT * FROM admin WHERE email = '$email';";
        $select_query = mysqli_query($conexion, $select_log);
    
        if (mysqli_num_rows($select_query) == 1) {

            $user = mysqli_fetch_assoc($select_query);
            $verify = password_verify($password, $user['contraseña']);

            if($verify) {

                $_SESSION['user'] = $user;
            
            } else {

                $_SESSION['error_login'] = "Login incorrecto";
            }

        }

    } else {

        $_SESSION['errores_log'] = $errores_log;
    };

    header('Location: ../login.php');

};

?>
