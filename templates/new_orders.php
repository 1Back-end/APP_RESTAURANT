<?php
require 'info_app.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle Commande</title>
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
            text-transform:uppercase;
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
        .price-details .label {
            font-weight: bold;
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
            <h1>Nouvelle Commande Reçue</h1>
        </div>
        <div class="content">
            <p>Bonjour,</p>
            <p>Une nouvelle commande a été passée sur votre site. Voici les détails de la commande :</p>
            <div class="order-details">
                <h2>Détails de la Commande</h2>
                <p><strong>Numéro de commande :</strong> #{{order_id}}</p>
                <p><strong>Date :</strong> {{order_date}}</p>
                <p><strong>Nom du client :</strong> {{customer_name}}</p>
                <p><strong>Email du client :</strong> {{customer_email}}</p>
                <p><strong>Contact du client :</strong> {{customer_contact}}</p>
                <div class="price-details">
                    <div class="label">Frais de livraison :</div>
                    <div>{{shipping_cost}} FCFA</div>
                </div>
                <div class="price-details">
                    <div class="label">Total :</div>
                    <div>{{order_total}} FCFA</div>
                </div>
            </div>
            <p>Merci de vérifier cette commande dans votre tableau de bord et de prendre les mesures nécessaires.</p>
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
