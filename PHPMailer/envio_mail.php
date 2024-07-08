<?php

date_default_timezone_set('America/Montevideo'); 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';
require 'setMail.php';

function enviarMail($fechahoy, $archivoadjunto, $id_func, $nombre) {

    // Obtener datos del mail a enviar
    $infomail = get_mailinfo($fechahoy, $archivoadjunto, $id_func, $nombre);

    $message        = $infomail["cuerpomail"];
    $destinatarios  = $infomail["destinatariomail"];
    $asuntomail     = $infomail["asuntomail"];
    $archivoadjunto = $infomail["archivoadjunto"];

    $fecha = date('d-m-Y');

    function clean_text($string) {
        $string = trim($string);
        $string = stripslashes($string);
        $string = htmlspecialchars($string);
        return $string;
    }

    $nombre = "AVANZA SISTEMAS";
    $email = "automaticos@skytel.com.uy";

    // Ruta de archivo adjunto
    $path = $archivoadjunto;

    $mail = new PHPMailer(true);

    try {

        $mail->SMTPDebug = 0; // Cambiar a 2 para ver más detalles de depuración
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';		
        $mail->Port = '587'; // Puerto SMTP
        $mail->SMTPAuth = true; // Autenticación SMTP
        $mail->Username = 'automaticos@skytel.com.uy'; // Usuario SMTP
        $mail->Password = 'automaticos-AVANZA1386'; // Contraseña SMTP
        $mail->SMTPSecure = 'tls'; // Encriptación TLS

        $mail->setFrom($email, $nombre);
        $mail->addBCC('repoavanza2022@gmail.com', 'Avanza Skytel');

        foreach ($destinatarios as $destinatario) {
            $mail->addAddress($destinatario);
        }

        $mail->WordWrap = 50;
        $mail->isHTML(true); // Establecer formato de email a HTML
        $mail->addAttachment($path); // Añadir archivo adjunto
        $mail->Subject = $asuntomail; // Asunto del mensaje
        $mail->Body = $message; // Cuerpo del mensaje
    

        // Enviar mensaje y verificar errores
        if (!$mail->send()) {
            //echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            //echo "Envio de correo realizado correctamente.";
        }

        header('Location: ../pages/altas.php');

    } catch (Exception $e) {
        //echo "El mensaje no pudo ser enviado. Error de PHPMailer: {$mail->ErrorInfo}";
    }
}
?>
