<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Inclure l'autoloader de Composer

function sendOrderEmail($orderDetails, $recipientEmail, $recipientName) {
    $mail = new PHPMailer(true);

    try {
        // Configuration du serveur SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Configurez selon votre SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'laurentalphonsewilfried@gmail.com'; // Remplacez par vos identifiants
        $mail->Password = 'ztgs elyg jaxy emnx';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Destinataire
        $mail->setFrom('laurentalphonsewilfried@gmail.com', 'QuickMeal');
        $mail->addAddress($recipientEmail, $recipientName); // Destinataire

        // Contenu de l'email
        $mail->isHTML(true);
        $mail->Subject = "Nouvelle Commande: " . $orderDetails['order_number'];
        $mail->CharSet = 'UTF-8';

        
        // Charger le modèle HTML et remplacer les balises
        $message = file_get_contents("templates/new_order.php");
        $message = str_replace("{{client_name}}", $orderDetails['client_name'], $message);
        $message = str_replace("{{client_email}}", $orderDetails['client_email'], $message);
        $message = str_replace("{{client_phone}}", $orderDetails['client_phone'], $message);
        $message = str_replace("{{order_address}}", $orderDetails['order_address'], $message);
        $message = str_replace("{{order_preferences}}", $orderDetails['order_preferences'], $message);

        $orderItems = '';
        foreach ($orderDetails['items'] as $item) {
            $orderItems .= "<tr>
                <td>{$item['meal_name']}</td>
                <td>{$item['quantity']}</td>
                <td>{$item['unit_price']} FCFA</td>
                <td>{$item['total_price']} FCFA</td>
            </tr>";
        }

        $message = str_replace("{{order_items}}", $orderItems, $message);
        $message = str_replace("{{total_amount}}", $orderDetails['total_amount'], $message);

        $mail->Body = $message;

        // Envoyer l'email
        $mail->send();
        return true;

    } catch (Exception $e) {
        error_log("PHPMailer Error: " . $mail->ErrorInfo);
        return false;
    }
}
