<?php
include_once("email_template.php"); // Inclure le fichier contenant la fonction

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Charge PHPMailer

function sendOtpEmail($email, $username, $otp) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Configurez selon votre SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'laurentalphonsewilfried@gmail.com'; // Remplacez par vos identifiants
        $mail->Password = 'ztgs elyg jaxy emnx';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Destinataire
        $mail->setFrom('laurentalphonsewilfried@gmail.com', 'QuickMeal');
        $mail->addAddress($email);

        // Contenu
        $mail->isHTML(true);
        $mail->Subject = 'Votre code OTP';
        $mail->Body = emailTemplate($username, $otp);
        $mail->CharSet = 'UTF-8';


        $mail->send();
    } catch (Exception $e) {
        error_log("Erreur lors de l'envoi de l'email : {$mail->ErrorInfo}");
    }
}
