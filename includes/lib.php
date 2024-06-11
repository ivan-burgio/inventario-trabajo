<?php

function mostrarErrores($errores, $campo) {

    if(isset($_SESSION[$errores][$campo])) {

        echo "<div>".$_SESSION[$errores][$campo]."</div>";
    } else {

        echo '';
    }
};