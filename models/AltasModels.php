<?php

require_once 'config/conexion.php';

$conexion = new Conexion();
$conexion::Connect();

class AltasModels {

    public function getFuncionario() {

        $lista_func = $conexion->query("SELECT f.id_funcionario, f.nombre, f.apellido, s.nombre AS nombre_sector FROM funcionarios f
                                        INNER JOIN sectores s ON f.sector = s.id_sector;");
        return $lista_func;

        require_once 'views/altas.php';

    }

    public function getProduct() {

        $lista_product = $conexion->query("SELECT id, id_prod, marca, modelo FROM productos WHERE status = 1;");
        return $lista_product;

        require_once 'views/altas.php';
    }

    public function getSector() {

        $lista_sector = $conexion->query("SELECT * FROM sectores;");
        return $lista_sector;

        require_once 'views/altas.php';
    }
};

?>