<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre Panier</title>
    <link rel="stylesheet" href="path/to/bootstrap.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
   
    <div class="container">
        <h1>Votre Panier</h1>
        
        <?php if (empty($_SESSION['cart'])): ?>
            <p>Votre panier est vide.</p>
            <a href="menu.php" class="btn btn-primary">Commander des repas</a>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Repas</th>
                        <th>Prix</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['cart'] as $key => $meal): ?>
                        <tr>
                            <td><?= htmlspecialchars($meal['meal_name']); ?></td>
                            <td><?= number_format($meal['price'], 2, ',', ' ') . ' FCFA'; ?></td>
                            <td>
                                <button class="btn btn-danger" onclick="removeFromCart(<?= $key; ?>)">Supprimer</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <a href="commande.php" class="btn btn-success">Passer à la commande</a>
        <?php endif; ?>
    </div>

    <script>
        // Supprimer un article du panier
        function removeFromCart(mealIndex) {
            $.ajax({
                url: 'remove_from_cart.php',
                type: 'POST',
                data: { index: mealIndex },
                success: function(response) {
                    location.reload(); // Recharger la page après la suppression
                }
            });
        }
    </script>
</body>
</html>
