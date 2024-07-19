<?php

require_once '../includes/conexion.php';

if(isset($_SESSION['user'])) {

    session_destroy();
};

header('Location: ../index.php');

?>