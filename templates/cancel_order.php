<?php
// Inclure le fichier de configuration
require 'info_app.php';

// Variables de commande pour l'exemple (remplacez-les par vos propres valeurs dynamiques)
$order_id = "12345";
$order_date = date("d/m/Y");
$order_reason = "Article en rupture de stock. Veuillez réessayer plus tard."; // Raison de l'annulation
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commande Annulée</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap');
        /* Général */
        body {
            font-family: 'Rubik', sans-serif;
            color: #333333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #dddddd;
        }
        .header h1 {
            color: #FF0000;
            font-size: 24px;
            margin: 0;
        }
        .content {
            padding: 20px 0;
            line-height: 1.6;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #888888;
            margin-top: 20px;
            border-top: 1px solid #dddddd;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Commande Annulée</h1>
        </div>
        <div class="content">
            <p>Bonjour,</p>
            <p>Nous vous informons que votre commande a été annulée. Voici les détails :</p>
            <p><strong>Date de la commande :</strong> <?= htmlspecialchars($order_date); ?></p>
            <p><strong>Raison de l'annulation :</strong> <?= htmlspecialchars($order_reason); ?></p>
            <p>Merci de votre compréhension.</p>
            <p>Cordialement,</p>
            <p>L'équipe <?= htmlspecialchars($company_name); ?></p>
        </div>
        <div class="footer">
            <p>&copy; <?= date('Y'); ?> <?= htmlspecialchars($company_name); ?>. Tous droits réservés.</p>
            <p>Adresse : <?= htmlspecialchars($company_address); ?> | Téléphone : <?= htmlspecialchars($company_phone); ?></p>
        </div>
    </div>
</body>
</html>
