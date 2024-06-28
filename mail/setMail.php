<?php

$fechahoy = date('Y-m-d');


function get_mailinfo($id_funcionario, $fecha, $nombre){
    global $fechahoy;
    
        $_nombrearchivoadjunto = "archivos_teletrabajo_{$fecha}_{$id_funcionario}";

        $mail= array ( 
                "cuerpomail" => "Se gestiona el alta para el funcionario numero $id_funcionario $nombre<br><br>Buena Jornada",    
                "destinatariomail" => array('ivan.yang@skytel.com.uy', 'Ivan Yang'),
                "asuntomail" => 'ALTA DE PRODUCTO PARA FUNCIONARIO'.$fechahoy,
                "archivoadjunto" => $_nombrearchivoadjunto,
                "caveceraenarchivo" => true, //indico si el archivo tendra cavecera o no 
                "envioarchivovacio" => false,//indico si se envia mail en el caso q no tengamos datos
        );
    return $mail;
}

?>