<?php

class LoginModels {

    private $db;
    private $email;
    private $password;

    public function __construct() {

        $this->db = Conexion::Connect();
    }

    private function getEmail() {

        return $this->email;
    }

    private function getPassword() {
        
        return $this->password;
    }

    public function setEmail($email) {
        
        $this->email = $this->db->real_escape_string($email);
    }

    public function setPassword($password) {
        $this->password = $this->db->real_escape_string($password);
    }

    public function LoginSql() {

        $result = false;
        $email = $this->getEmail();
        $password = $this->getPassword();

        $sql = "SELECT * FROM admin WHERE email = '$email';";
        $login = $this->db->query($sql);

        if($login && $login->num_rows == 1) {

            $usuario = $login->fetch_object();

            $verify = password_verify($password, $usuario->contraseña);

            if($verify) {

                $result = $usuario;
                $_SESSION['user'] = $result; 
            }
        }

        return $result;
    }
}


?>