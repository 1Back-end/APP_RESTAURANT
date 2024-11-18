<?php
require 'vendor/autoload.php';
require 'email_template.php'; // Inclut le template de l'email
include_once("database/connexion.php"); // Inclut la connexion PDO

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Variables pour les messages
$erreur_champ = "";
$erreur = "";
$success = "";

// Vérification si le formulaire est soumis
if (isset($_POST["submit"])) {
    // Récupération des données du formulaire
    $customerName = $_POST['customer_name'] ?? null;
    $customerEmail = $_POST['customer_email'] ?? null;
    $customerPhone = $_POST['customer_phone'] ?? null;
    $reservationDate = $_POST['reservation_date'] ?? null;
    $numberOfPeople = $_POST['number_of_people'] ?? null;
    $specialRequest = $_POST['special_request'] ?? ''; // Optionnel

    // Validation des champs
    if (empty($customerName) || empty($customerEmail) || empty($customerPhone) || empty($reservationDate) || empty($numberOfPeople) || empty($specialRequest)) {
        $erreur_champ = "Tous les champs sont requis !";
    } else {
        // Génération de l'UUID
        $reservationUuid = bin2hex(random_bytes(16));

        try {
            // Insertion dans la base de données
            $sql = "INSERT INTO reservations (
                reservation_uuid, customer_name, customer_email, customer_phone, reservation_date, 
                number_of_people, status, created_at, updated_at, is_deleted
            ) VALUES (
                :reservation_uuid, :customer_name, :customer_email, :customer_phone, :reservation_date, 
                :number_of_people, 'pending', NOW(), NOW(), 0
            )";

            $stmt = $connexion->prepare($sql);
            $stmt->execute([
                ':reservation_uuid' => $reservationUuid,
                ':customer_name' => $customerName,
                ':customer_email' => $customerEmail,
                ':customer_phone' => $customerPhone,
                ':reservation_date' => $reservationDate,
                ':number_of_people' => $numberOfPeople,
            ]);
            $mail = new PHPMailer(true);
            // Envoi de l'email
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Configurez selon votre SMTP
            $mail->SMTPAuth = true;
            $mail->Username = 'laurentalphonsewilfried@gmail.com'; // Remplacez par vos identifiants
            $mail->Password = 'ztgs elyg jaxy emnx';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Destinataire
            $mail->setFrom('laurentalphonsewilfried@gmail.com', 'QuickMeal');
            $mail->addAddress('laurentalphonsewilfried@gmail.com', 'QuickMeal'); 
            $mail->isHTML(true);
            $mail->Subject = 'Nouvelle réservation reçue';
            $mail->Body = getEmailTemplate($customerName, $customerEmail, $customerPhone, $reservationDate, $numberOfPeople, $specialRequest);
            $mail->CharSet = 'UTF-8';


            $mail->send();

            $success = "Réservation enregistrée et email envoyé avec succès.";
        } catch (Exception $e) {
            $erreur = "Erreur lors de l'enregistrement ou de l'envoi de l'email : " . $e->getMessage();
        }
    }
}
?>