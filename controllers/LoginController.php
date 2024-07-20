<?php

require_once 'models/LoginModels.php';
require_once 'config/parameters.php';

class LoginController {

    public function loginview() {

        require_once 'views/login.php';
    }

    public function login() {

        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            $email = isset($_POST['email']) ? $_POST['email'] : false;
            $password = isset($_POST['password']) ? $_POST['password'] : false;

            $errores_log = array();

            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        
                $errores_log['email'] = "El email ingresado no es valido";
            };
        
            if (empty($password)) {
        
                $errores_log['password'] = "Ingrese una contraseña";
            };
        
            if (count($errores_log) == 0) {
        
        
                insertQuery($email, $password, $errores_log);
        
        
            } else {
        
                $_SESSION['errores_log'] = $errores_log;
                header('Location:'.base_url.'views/login.php');
            };
        
        }
    }

    public function closeLogin() {

        if(isset($_SESSION['user'])) {

            session_destroy();
        };
        
        header('Location:'.base_url.'?controller=Login&action=loginview');
    }
}


//----------------------------------------FUNCIONES----------------------------------------

function insertQuery($email, $password, $errores_log) {

    $usuario = new LoginModels();
    $usuario->setEmail($_POST['email']);
    $usuario->setPassword($_POST['password']);
    $identify = $usuario->LoginSql();

    if($identify) {

        header('Location:'.base_url.'?controller=Inventario&action=inventario');
    
    } else {

        $errores_log['login'] = "Login incorrecto";
        $_SESSION['errores_log'] = $errores_log;
        header('Location:'.base_url.'?controller=Login&action=loginview');
    }

}

?>
