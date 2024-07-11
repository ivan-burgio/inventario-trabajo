<?php

require_once '../includes/conexion.php';




$select_pdf = "SELECT DISTINCT a1.id_funcionario, a1.nombre_func, a1.lugar_trabajo, a1.puesto, a1.fecha
                FROM altas_productos a1
                INNER JOIN (
                    SELECT id_funcionario, MAX(fecha) as max_fecha
                    FROM altas_productos
                    GROUP BY id_funcionario
                ) a2 ON a1.id_funcionario = a2.id_funcionario 
                WHERE a1.fecha = a2.max_fecha
                ORDER BY a1.id_funcionario";

$select_pdf_query = mysqli_query($conexion, $select_pdf);

?>