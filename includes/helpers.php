<?php

require_once 'conexion.php';
require('../FPDF/fpdf.php');

//Función creada para mostrar los errores en los campos de registro
function mostrarErrores($errores, $campo) {

    if(isset($_SESSION[$errores][$campo])) {

        echo "<div>".$_SESSION[$errores][$campo]."</div>";
    } else {

        echo '';
    }

};

function archivoTT($id_func, $nombre) {

    // Definir la clase PDF extendida de FPDF
    class PDF extends FPDF {

        function LoadData($file) {

            $lineas = file($file);
            $data = array();
            foreach($lineas as $line) {
                $data[] = explode(';', trim($line));
            }
            return $data;
        }

        function BasicTable($header, $data) {

            foreach($header as $col) {

                $this->Cell(50, 7, $col, 1);
            }
            $this->Ln();

            foreach($data as $row) {

                $this->Cell(50, 6, $col, 1);
            }
            $this->Ln();
        }
        
    }

    // Definir la ruta y nombre del archivo PDF
    $ruta = "../archivos_teletrabajo/archivo_{$id_func}_{$nombre}.pdf";
    $texto = "../FPDF/txt/altas_producto.txt";
    $tabla_nombre = "../FPDF/txt/tabla_datos.txt";
    $txt = file_get_contents($texto);

    
    // Crear una instancia de la clase PDF
    $pdf = new PDF();
    $header = array('Nombre', 'N° de funcionario', 'Fecha de entrega de activos');
    $data = $pdf->LoadData($tabla_nombre);
    $pdf->SetFont('Arial', '', 14);
    $pdf->AddPage();
    $pdf->BasicTable($header, $data);
    $pdf->MultiCell(0, 3, $txt, 0, 'L');

    // Generar y guardar el PDF en la ruta especificada
    $pdf->Output($ruta, 'F');
};
