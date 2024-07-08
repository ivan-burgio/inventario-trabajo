<?php

//FUNCION QUE ME TRAE TODA LA INFORMACION PARA EL ENVIO DE MAILS
function get_mailinfo($fechahoy, $_nombrearchivoadjunto, $id_func, $nombre){
    $fecha = date('Y-m-s');
    $mail= array (
            "asuntomail" => "Alta/Baja de activos para el funcionario N°{$id_func} / {$fechahoy}", 
            "cuerpomail" => "Adjuntamos PDF del alta/baja de activos para el funcionario {$nombre} de la fecha {$fecha} <br><br>Buena Jornada",    
            "destinatariomail" => array('ivan.yang@skytel.com.uy'),
            "archivoadjunto" => $_nombrearchivoadjunto,
            "caveceraenarchivo" => true, //indico si el archivo tendra cavecera o no 
            "envioarchivovacio" => false,//indico si se envia mail en el caso q no tengamos datos
            );

    return $mail;
}


?>