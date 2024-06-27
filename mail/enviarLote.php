<?php
date_default_timezone_set('America/Montevideo');  

function enviarMailxLote($_destinatarios, $_mensaje, $_asunto, $_adjunto, $_id, $_job){
	$message 		= $_mensaje;
	$destinatarios 	= $_destinatarios;
	$asuntomail		= $_asunto;
	$archivoadjunto = $_adjunto;
	$id 			= $_id;
	$job			= $_job;

	$nombre = "AVANZA SISTEMAS";
	$email = "automaticos@skytel.com.uy";

	//ruta de archivo adjunto
	$path = '../historico/'.$archivoadjunto;
	
//var_dump($path);

	require_once 'class/class.phpmailer.php';
	$mail = new PHPMailer;
	//Enable SMTP debugging
	// 0 = off (for production use)
	// 1 = client messages
	// 2 = client and server messages
	$mail->SMTPDebug = 0;
	$mail->IsSMTP();								//Sets Mailer to send message using SMTP
	$mail->Host = 'smtp.gmail.com';		
	$mail->Port = '587';							//Sets the default SMTP server port
	$mail->SMTPAuth = true;							//Sets SMTP authentication.
	$mail->Username = 'automaticos@skytel.com.uy';	//Sets SMTP username
	$mail->Password = 'automaticos-AVANZA1386';		//Sets SMTP password
	$mail->SMTPSecure = 'tls';						//Sets connection prefix. Options are "", "ssl" or "tls"
	$mail->From = $email;							//Sets the From email address for the message
	$mail->FromName = $nombre;						//Sets the From name of the message
	$mail->setFrom('automaticos@skytel.com.uy', 'AVANZA SISTEMAS');
	

	$mail->addAddress($destinatarios[0], $destinatarios[1]);
	$mail->addCC($destinatarios[2], $destinatarios[3]);
	$mail->addCC($destinatarios[4], $destinatarios[5]);
	$mail->addCC($destinatarios[6], $destinatarios[7]);
	$mail->addCC($destinatarios[8], $destinatarios[9]);
	$mail->addCC($destinatarios[10], $destinatarios[11]);
	$mail->addCC($destinatarios[12], $destinatarios[13]);

	$mail->addBCC('repoavanza2022@gmail.com', 'Avanza Skytel');
	
	$mail->WordWrap = 50;							
	$mail->IsHTML(true);							//Sets message type to HTML
	$mail->AddAttachment($path);					//Adds an attachment from a path on the filesystem
	$mail->Subject = $asuntomail;				//Sets the Subject of the message
	$mail->Body = $message;							//An HTML or plain text message body
	
	//send the message, check for errors
	if (!$mail->send()) {
	    echo "Mailer Error: " . $mail->ErrorInfo;
	    insert_log_enviomailxlote("System:enviomailreporteLote",$job,"Envio Mail x Lote","Fallo - ".$_id." - ".$destinatarios[0].' | '.$destinatarios[2].' | '.$destinatarios[4].' | '.$destinatarios[6].' | '.$destinatarios[8]);
	    $ret = 'Fallo';
	} else {
	    //echo "Envio ".$asuntomail." Realizado Correctamente ".$fecha." ";
	    insert_log_enviomailxlote("System:enviomailreporteLote",$job,"Envio Mail x Lote","Ok - ".$_id." - ".$destinatarios[0].' | '.$destinatarios[2].' | '.$destinatarios[4].' | '.$destinatarios[6].' | '.$destinatarios[8]);
	    $ret = 'Ok';
	}
	return $ret;
}

?>
