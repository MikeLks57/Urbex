<?php

namespace Service;


class MailerService
{

	public function sendMail($destAddress, $destName, $subject, $messageHtml, $messagePlain)
	{
		$mail = new \PHPMailer();

		$mail->isSMTP();                                      	// On va se servir de SMTP
		$mail->Host = 'smtp.gmail.com';  						// Serveur SMTP
		$mail->SMTPAuth = true;                               	// Active l'autentification SMTP
		$mail->Username = 'wf3.mailer@gmail.com';             	// SMTP username
		$mail->Password = '$NJ27^^4q7';                   		// SMTP password
		$mail->SMTPSecure = 'tls';                            	// TLS Mode
		$mail->Port = 587;                                    	// Port TCP à utiliser
		$mail->CharSet = 'UTF-8';

		// $mail->SMTPDebug = 2;

		$mail->setFrom('wf3.mail@gmail.com', 'Urbex-Nord', false);
		$mail->addAddress($destAddress, $destName);     		// Ajouter un destinataire

		$mail->isHTML(true);                                  	 // Set email format to HTML

		$mail->Subject = $subject;
		$mail->Body    = $messageHtml;
		$mail->AltBody = $messagePlain;

		$mail->send();

	}

}