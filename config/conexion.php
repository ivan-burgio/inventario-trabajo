<?php

date_default_timezone_set('America/Montevideo');
session_start();

class Conexion {

    public static function Connect() {

        $db = new mysqli('Localhost', 'ivanY', '', 'inventario');
        return $db;
    }
}

?>