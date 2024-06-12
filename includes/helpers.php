<?php

require_once 'conexion.php';

//Función creada para mostrar los errores en los campos de registro
function mostrarErrores($errores, $campo) {

    if(isset($_SESSION[$errores][$campo])) {

        echo "<div>".$_SESSION[$errores][$campo]."</div>";
    } else {

        echo '';
    }

};

