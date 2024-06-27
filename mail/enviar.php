<?php
date_default_timezone_set('America/Montevideo');  

require_once 'setMail.php';

function enviarMail($archivo, $id_func, $nombre) {

//include ('../include/lib.php');
//include ('../repo/'.$proyecto.'.php');

//OBTENGO DATOS DE MAIL A ENVIAR INGREO NOMBRE DE ARCHIVO ADJUNTO Y TIPO DE QRY A ENFVIAR 
$infomail = get_mailinfo($archivo, $id_func, $nombre);

$message 		= $infomail["cuerpomail"];
$destinatarios 	= $infomail["destinatariomail"];
$asuntomail		= $infomail["asuntomail"];
$archivoadjunto = $infomail["archivoadjunto"];


$fecha= date('d-m-Y');

function clean_text($string)
{
	$string = trim($string);
	$string = stripslashes($string);
	$string = htmlspecialchars($string);
	return $string;
}

	$nombre = "AVANZA SISTEMAS";
	//$email = "automaticos@avanzauruguay.com";
	$email = "automaticos@skytel.com.uy";

	//ruta de archivo adjunto
	//$path = '../historico/'.$archivoadjunto.'.csv';
	
	$path = $archivoadjunto;
	
//var_dump($path);

	require 'class/class.phpmailer.php';
	$mail = new PHPMailer;
	//Enable SMTP debugging
	// 0 = off (for production use)
	// 1 = client messages
	// 2 = client and server messages
	$mail->SMTPDebug = 0;
	$mail->IsSMTP();								//Sets Mailer to send message using SMTP
	//$mail->Host = 'SMTP.Office365.com';	
	$mail->Host = 'smtp.gmail.com';		
	$mail->Port = '587';								//Sets the default SMTP server port
	$mail->SMTPAuth = true;							//Sets SMTP authentication.
	$mail->Username = 'automaticos@skytel.com.uy';					//Sets SMTP username
	$mail->Password = 'automaticos-AVANZA1386';					//Sets SMTP password
	$mail->SMTPSecure = 'tls';							//Sets connection prefix. Options are "", "ssl" or "tls"
	$mail->From = $email;					//Sets the From email address for the message
	$mail->FromName = $nombre;				//Sets the From name of the message
	$mail->setFrom('automaticos@skytel.com.uy', 'AVANZA SISTEMAS');
	

	$mail->addAddress($destinatarios[0], $destinatarios[1]);
	/*
	$mail->addCC($destinatarios[2], $destinatarios[3]);
	$mail->addCC($destinatarios[4], $destinatarios[5]);
	$mail->addCC($destinatarios[6], $destinatarios[7]);
	$mail->addCC($destinatarios[8], $destinatarios[9]);
	*/

	$mail->addBCC('repoavanza2022@gmail.com', 'Avanza Skytel');
	
	$mail->WordWrap = 50;							
	$mail->IsHTML(true);							//Sets message type to HTML
	$mail->AddAttachment($path);					//Adds an attachment from a path on the filesystem
	$mail->Subject = $asuntomail;				//Sets the Subject of the message
	$mail->Body = $message;							//An HTML or plain text message body
	$mail->send();
	
	//send the message, check for errors

	/*
	if (!$mail->send()) {
	    echo "Mailer Error: " . $mail->ErrorInfo;
	    insert_log("System:enviomailreporte",$asuntomail,"Envio Mail","Fallo - ");
	    shell_exec("TASKKILL /IM chrome.exe /F");
	} else {
	    //echo "Envio ".$asuntomail." Realizado Correctamente ".$fecha." ";
	    insert_log("System:enviomailreporte",$asuntomail,"Envio Mail","Ok - ".$archivoadjunto);
	    shell_exec("TASKKILL /IM chrome.exe /F");
	}
	*/

}

?>
