<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo strtoupper(ucfirst(str_replace(".php", "", basename($_SERVER['PHP_SELF']))));?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap');
        body { font-family: "Rubik", serif; background-color: #f9f9f9; padding: 20px; }
        .container { background-color: white; padding: 20px; border-radius: 8px; border: 1px solid #ddd; }
        h2 { color: #333; }
        p { font-size: 14px; color: #555; }
        .order-details { margin-top: 20px; }
        .order-details th, .order-details td { padding: 8px 12px; text-align: left; border: 1px solid #ddd; }
        .order-details th { background-color: #f2f2f2; }
        .footer { font-size: 12px; color: #888; margin-top: 20px; text-align: center; }
    </style>
</head>
<body>

<div class="container mt-5 pb-5">
<div class="col-lg-12 col-sm-12 mx-auto">
<h2>Nouvelle Commande de {{client_name}}</h2>
    <p><strong>Nom du client :</strong> {{client_name}}</p>
    <p><strong>Email :</strong> {{client_email}}</p>
    <p><strong>Numéro de téléphone :</strong> {{client_phone}}</p>
    <p><strong>Adresse :</strong> {{order_address}}</p>
    <p><strong>Préférences :</strong> {{order_preferences}}</p>

    <h3>Détails de la commande :</h3>
    <table class="order-details">
        <thead>
            <tr>
                <th>Nom du Plat</th>
                <th>Quantité</th>
                <th>Prix Unitaire</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            {{order_items}}
        </tbody>
    </table>

    <h3>Total : {{total_amount}} FCFA</h3>

    <div class="footer">
        <p>Merci de votre attention,</p>
        <p>L'équipe de [Nom de votre site]</p>
    </div>
  
</div>
</div>

</body>
</html>
