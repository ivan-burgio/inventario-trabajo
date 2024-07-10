<?php

require_once 'conexion.php';
require '../FPDF/fpdf.php';
require '../PHPMailer/envio_mail.php';
date_default_timezone_set('America/Montevideo');

//Función creada para mostrar los errores en los campos de registro
function mostrarErrores($errores, $campo) {

    if(isset($_SESSION[$errores][$campo])) {

        echo "<div class='alert alert_error'>".$_SESSION[$errores][$campo]."</div>";

    } else {

        echo '';
    }
}

function mostrarExito($estado, $campo) {

    if(isset($_SESSION[$estado][$campo])) {

        echo "<div class='alert alert_exito'>".$_SESSION[$estado][$campo]."</div>";
        
    } else {

        echo '';
    }
}

function archivoTT($id_func, $nombre, $fecha) { //Función para crear el PDF cuando se de de alta un producto hacia funcionario

    $fecha_y_hora = date("Y-m-d_H-i-s");

    class PDF extends FPDF {

        function Header() { //Función para crear la cabecera del PDF

            $this->SetFont('Arial','B',10);
            // Título
            $titulo = mb_convert_encoding('ENTREGA/DEVOLUCIÓN DE ACTIVOS', 'ISO-8859-1', 'UTF-8');
            $this->Cell(0, 8, $titulo, 1,0,'C');
            // Salto de línea
            $this->Ln(15);
        }

        function FuncTable($header, $data) { //Función para crear la tabla de los datos del funcionario
            // Anchura de las celdas incrementada a 60 unidades
            $cellWidth = 60;
            $cellHeight = 8;
            $cellBorder = 1; // Borde completo
    
            // Imprimir la cabecera
            foreach($header as $col) {
                $this->SetFont('Arial','B', 8);
                $this->SetFillColor(95, 114, 100);
                $this->Cell($cellWidth, $cellHeight, $col, $cellBorder, 0, 'L', true);
            }
            $this->Ln();
    
            // Imprimir los datos
            foreach($data as $row) {
                foreach($row as $col) {
                    // Verificar si el contenido se sale del margen derecho
                    if($this->GetStringWidth($col) > $cellWidth) {
                        // Dividir el texto para que se ajuste dentro de la celda
                        $this->SetFont('Arial','', 7);
                        $this->MultiCell($cellWidth, 7, $col, $cellBorder);
                    } else {
                        $this->Cell($cellWidth, 7, $col, $cellBorder);
                    }
                }
                $this->Ln();
    
                // Verificar si hay que agregar una nueva página
                if($this->GetY() + $cellHeight > $this->PageBreakTrigger) {
                    $this->AddPage();
                    // Imprimir la cabecera nuevamente
                    foreach($header as $col) {
                        $this->Cell($cellWidth, 7, $col, $cellBorder);
                    }
                    $this->Ln();
                }
            }
        }

        function ActivesTables($headerActives, $actives, $fecha) { 
            // Establecer las propiedades iniciales de las celdas
            $cellHeight = 6;
            $cellBorder = 1; // Borde completo
        
            // Calcular la anchura de cada columna basado en el contenido
            $widths = array();
            foreach($headerActives as $col) {
                $widths[] = $this->GetStringWidth($col) + 8; // Añadir un poco de padding
            }
            foreach($actives as $row) {
                foreach($row as $key => $value) {
                    $cellWidth = $this->GetStringWidth($value) + 8;
                    if ($cellWidth > $widths[$key]) {
                        $widths[$key] = $cellWidth;
                    }
                }
            }
        
            // Imprimir la cabecera
            foreach($headerActives as $key => $col) {
                $this->SetFont('Arial','B', 8);
                $this->SetFillColor(95, 114, 100);
                $this->Cell($widths[$key], $cellHeight, $col, $cellBorder, 0, 'L', true);
            }
            $this->Ln();
        
            // Imprimir los datos
            $this->SetFillColor(224, 235, 255);
            $this->SetTextColor(0);
            $this->SetFont('Arial', '', 8);
            $fill = false;
        
            // Verificar si los datos caben en una sola página
            $pageHeight = $this->GetPageHeight() - $this->GetY() - 10; // Altura de la página disponible
            $rowHeight = $cellHeight * count($actives); // Altura total de todas las filas
        
            if ($rowHeight > $pageHeight) {
                // Si no cabe, reducir el tamaño de fuente y ajustar el alto de la celda
                $this->SetFont('Arial', '', 6);
                $cellHeight = 5;
            }
        
            foreach($actives as $row) {
                foreach($row as $key => $col) {
                    $this->Cell($widths[$key], $cellHeight, $col, $cellBorder, 0, 'L', $fill);
                }
                $this->Ln();
                $fill = !$fill; // Alternar color de fondo
            }            
        }
        
        function BasesAndConditions($texto) { //Función para crear el texto de las bases y condiciones

            $this->SetFont('Arial', '', 8);
            $this->MultiCell(0, 5, $texto);
        }

        function SignatureFunc() { //Función para crear la sección de la firma

            $texto = mb_convert_encoding('FIRMA Y ACLARACIÓN DEL FUNCIONARIO', 'ISO-8859-1', 'UTF-8');;
            $this->SetFont('Arial', 'B', 11);
            $this->Cell(0, 20, $texto, 'B');
        }

        function Footer() {
            $this->SetFont('Arial', '', 6);
            $footer_text = "Avanza Uruguay; Casa central: Vazquez 1386 Montevideo - Uruguay; Telefono: (+598) 24008761 | Mail: operaciones@avanzasa.com; Web: www.avanzauruguay.com";
        
            // Dividir el texto en líneas separadas por ";"
            $lines = explode(";", $footer_text);
            
            // Establecer la posición para el texto
            $this->SetY(-25); // Establece la posición a 25 mm del final de la página
        
            // Imprimir cada línea del texto
            foreach ($lines as $line) {
                $this->Cell(0, 5, trim($line), 0, 1, 'L');
            }
        
            // Colocar la imagen a la derecha del footer y más arriba
            $image_path = '../assets/Avanza-Outsourcing.png';
            $image_width = 20; // Ancho de la imagen
            $image_height = 0; // Altura automática según la proporción
        
            // Posición X para la imagen (derecha)
            $image_x = $this->GetPageWidth() - $image_width - 10; // 10 unidades de margen
        
            // Posición Y para la imagen (más arriba)
            $image_y = $this->GetY() - 15; // Ajuste para colocar la imagen más arriba
        
            // Insertar la imagen
            $this->Image($image_path, $image_x, $image_y, $image_width);
        
            // Mover la posición Y hacia arriba para evitar superposiciones con la imagen
            $this->SetY($this->GetY() - $image_height - 10); // Ajuste para margen inferior
        
        }
    }

    $archivo = "../archivos_teletrabajo/archivo_{$fecha_y_hora}_N°{$id_func}_{$nombre}.pdf";

    // Crear PDF
    $pdf = new PDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', '', 12);
    
    $numeroFunc = mb_convert_encoding('N° de funcionario', 'ISO-8859-1', 'UTF-8');

    $header = array('Nombre', $numeroFunc, 'Fecha de entrega de activos');
    $data = array(
                array($nombre, $id_func, $fecha)
            );

            
    $headerActives = array("Lista de activos", "Entregado", "Devolucion", "Si", "No", "Observaciones");
    $actives = array(
                array('Pc (Devolucion)', '', '', '', '', ''),
                array('Monitor (Devolucion)', '', '', '', '', ''),
                array('Teclado (Devolucion)', '', '', '', '', ''),
                array('Mouse (Devolucion)', '', '', '', '', ''),
                array('(*) Silla (Devolucion)', '', '', '', '', ''),
                array('Vincha (1)', '', '', '', '', ''),
                array('Monitor', '', '', '', '', ''),
                array('Pc', '', '', '', '', ''),
                array('Pincho ADSL', '', '', '', '', ''),
                array('Teclado', '', '', '', '', ''),
                array('Mouse', '', '', '', '', ''),
                array('Cables / Adaptadores', '', '', '', '', ''),
                array('(*) Silla', '', '', '', '', '')
    );

    $texto_bases = file_get_contents("../FPDF/txt/altas_producto.txt");
    $texto_with_code = mb_convert_encoding($texto_bases, 'ISO-8859-1', 'UTF-8');


    $pdf->FuncTable($header, $data);
    $pdf->Ln(5);
    $pdf->ActivesTables($headerActives, $actives, $fecha);
    $pdf->BasesAndConditions($texto_with_code);
    $pdf->SignatureFunc();
    $pdf->Output($archivo, 'F');

    //Envio de mail con el PDF que se genera 
    enviarMail($fecha_y_hora, $archivo, $id_func, $nombre);
}


