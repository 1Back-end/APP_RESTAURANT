<?php
// Inclure le fichier de configuration
require 'info_app.php';

// Informations de la commande et du livreur
$order_id = '12345'; // Numéro de la commande
$order_date = date('d/m/Y'); // Date de la commande
$delivery_address = "456 Avenue des Palmiers, Yaoundé, Cameroun"; // Adresse de livraison
$customer_name = "M. Dupont"; // Nom du client (propriétaire du repas)
$meal_description = "Poulet rôti et frites"; // Description du repas
$assigned_delivery_person = "John Doe"; // Nom du livreur
$delivery_person_phone = "+237 6 78 90 12 34"; // Téléphone du livreur
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification de Livraison - Commande Assignée</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Rubik:wght@300;500&display=swap');
        body {
            font-family: 'Rubik', sans-serif;
            background-color: #f9f9f9;
            color: #333333;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
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
        .price-details {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            padding: 8px 0;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #888888;
            margin-top: 20px;
            border-top: 1px solid #dddddd;
            padding-top: 20px;
        }
        /* Responsive */
        @media (max-width: 600px) {
            .container {
                padding: 10px;
            }
            .header h1 {
                font-size: 20px;
            }
            .order-details h2 {
                font-size: 16px;
            }
            .price-details {
                flex-direction: column;
            }
            .price-details div {
                text-align: left;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Commande Assignée à un Livreur</h1>
        </div>
        <div class="content">
            <p>Bonjour,</p>
            <p>Une commande a été assignée à un livreur pour la livraison. Voici les détails :</p>
            <div class="order-details">
                <h2>Détails de la Commande</h2>
                <p><strong>Numéro de la commande :</strong> #<?= htmlspecialchars($order_id); ?></p>
                <p><strong>Date de la commande :</strong> <?= htmlspecialchars($order_date); ?></p>
                <p><strong>Nom du client :</strong> <?= htmlspecialchars($customer_name); ?></p>
                <p><strong>Adresse de livraison :</strong> <?= htmlspecialchars($delivery_address); ?></p>
                <p><strong>Description du repas :</strong> <?= htmlspecialchars($meal_description); ?></p>
            </div>
            <div class="order-details">
                <h2>Livraison Assignée</h2>
                <p><strong>Nom du livreur :</strong> <?= htmlspecialchars($assigned_delivery_person); ?></p>
                <p><strong>Téléphone du livreur :</strong> <?= htmlspecialchars($delivery_person_phone); ?></p>
            </div>
            <p>Merci de bien vouloir suivre les informations ci-dessus pour garantir une livraison réussie.</p>
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
