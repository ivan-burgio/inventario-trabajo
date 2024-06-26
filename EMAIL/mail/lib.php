<?php

require_once '../includes/conexion.php';

$fechahoy = date('Y-m-d');
$funcionario = $_SESSION['funcionario'];

//FUNCION QUE ME TRAE TODA LA INFORMACION PARA EL ENVIO DE MAILS
function get_mailinfo($_nombrearchivoadjunto, $id_func, $nombre){
    global $fechahoy;

    $mail= array ( 
        "cuerpomail" => "Se adjunta el PDF de alta de producto para el funcionario $id_func $nombre.<br><br>Buena Jornada",	
        "destinatariomail" => array('ivan.yang@skytel.com.uy','Ivan Yang','','','','','','','','','',''),
        //"destinatariomail" => array('christian.camacho@avanzauruguay.com','Christian Camacho','','','','','','','','','',''),
        "asuntomail" => 'ALTA DE PRODUCTO PARA FUNCIONARIO N°'.$id_func.' '.$nombre.' en la fecha '.$fechahoy,
        "archivoadjunto" => $_nombrearchivoadjunto,
        "caveceraenarchivo" => true, //indico si el archivo tendra cavecera o no 
        "envioarchivovacio" => false,//indico si se envia mail en el caso q no tengamos datos
    );
    return $mail;
};

/*GUARDAR LOGS DE LOS EVENTOS EN 128/INVENTARIO8
function insert_log($ilogusuario,$ilogsistema,$ilogaccion,$ilogconsulta){
    include "conect.inc";
    $hoy = date("Y-m-d");
    $hora = date ("H:i:s");
    // Crear sentencia SQL para Seleccionar Departamentos
    $sql = "INSERT INTO logs_aplicaciones (fecha, hora, usuario, sistema, accion, consulta)
            VALUES ('$hoy','$hora','$ilogusuario','$ilogsistema','$ilogaccion','$ilogconsulta')";     
    // Ejecutar sentencia SQL
    mysqli_query($conexion,$sql);  
    $my_error = mysqli_error($conexion);
    //    cerrar conexión
    mysqli_close($conexion);
    return $my_error;
};

*/
?>