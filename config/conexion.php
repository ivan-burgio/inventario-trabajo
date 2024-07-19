<?php

date_default_timezone_set('America/Montevideo');

class Conexion {

    public static function Connect() {

        $db = new mysqli('Localhost', 'root', '', 'inventario');
        $db->query("SET NAMES 'utf-8'");
        return $db;
    }
}

?>