<?php

require_once '../includes/conexion.php';

if($_POST) {

    $email = isset($_POST['user']) ? $_POST['user'] : false;
    $password = isset($_POST['password']) ? $_POST['password'] : false;

    $select_log = "SELECT * FROM admin WHERE email = '$email' AND contraseña = '$password';";
    $select_query = mysqli_query($conexion, $select_log);

    $login = false;

    if(mysqli_num_rows($select_query) == 1) {

        $login = true;
        $_SESSION['login'] = $login;

    } else {

        $login = false;
        $_SESSION['login'] = $login;
    }

    header('Location: ../index.php');
};