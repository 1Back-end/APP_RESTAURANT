<?php
// Inclure le fichier de configuration
require 'info_app.php';

// Variables de la commande
$order_id = '12345'; // Numéro de la commande
$order_date = date('d/m/Y'); // Date de la commande
$delivery_address = "456 Avenue des Palmiers, Yaoundé, Cameroun"; // Adresse de livraison
$customer_name = "M. Dupont"; // Nom du client
$meal_description = "Poulet rôti et frites"; // Description du repas
$assigned_delivery_person = "John Doe"; // Nom du livreur
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commande Assignée à un Livreur</title>
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
            color: #1F4283;
            font-size: 24px;
            margin: 0;
        }
        .content {
            padding: 20px 0;
            line-height: 1.6;
        }
        .order-details {
            margin: 20px 0;
            background-color: #f8f8f8;
            padding: 15px;
            border-radius: 8px;
            font-size: 14px;
        }
        .order-details h2 {
            font-size: 18px;
            color: #333;
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
            <h1>Nouvelle Commande Assignée</h1>
        </div>
        <div class="content">
            <p>Bonjour <?= htmlspecialchars($assigned_delivery_person); ?>,</p>
            <p>Vous avez été assigné à une nouvelle commande. Voici les détails :</p>
            <div class="order-details">
                <h2>Détails de la Commande</h2>
                <p><strong>Numéro de commande :</strong> #<?= htmlspecialchars($order_id); ?></p>
                <p><strong>Date de la commande :</strong> <?= htmlspecialchars($order_date); ?></p>
                <p><strong>Nom du client :</strong> <?= htmlspecialchars($customer_name); ?></p>
                <p><strong>Description du repas :</strong> <?= htmlspecialchars($meal_description); ?></p>
                <p><strong>Adresse de livraison :</strong> <?= htmlspecialchars($delivery_address); ?></p>
            </div>
            <p>Veuillez vérifier votre tableau de bord pour plus de détails et confirmer la prise en charge de la commande.</p>
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
