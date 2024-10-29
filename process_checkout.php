<?php
session_start();
include_once("database/connexion.php");

if (!isset($_SESSION['user_uuid'])) {
    header("Location: login.php");
    exit;
}

$user_uuid = $_SESSION['user_uuid'];
$address = $_POST['address'] ?? '';
$phone_number = $_POST['phone_number'] ?? ''; // Récupérer le numéro de téléphone
$preferences = $_POST['preferences'] ?? '';
$grandTotal = 0;

// Vérifier que le panier n'est pas vide
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    $message = "Le panier est vide.";
    header("Location: menu.php?message=" . urlencode($message));
    exit;
} else {
    try {
        // Début de la transaction
        $connexion->beginTransaction();

        // Mettre à jour les informations de l'utilisateur
        $stmt = $connexion->prepare("
            UPDATE users 
            SET address = :address, phone_number = :phone_number 
            WHERE user_uuid = :user_uuid
        ");
        $stmt->execute([
            ':address' => $address,
            ':phone_number' => $phone_number,
            ':user_uuid' => $user_uuid
        ]);

        // Calculer le montant total de la commande
        foreach ($_SESSION['cart'] as $item) {
            $price = $item['price'] ?? 0; // Utiliser l'opérateur null coalescent pour un prix par défaut de 0
            $quantity = $item['quantity'] ?? 0; // Utiliser l'opérateur null coalescent pour une quantité par défaut de 0
            $grandTotal += $price * $quantity;
        }

        // Générer un UUID unique pour la commande
        $order_uuid = bin2hex(random_bytes(16));

        if (empty($order_uuid)) {
            throw new Exception("Erreur lors de la génération de l'UUID de commande.");
        }

        // Insérer la commande dans la table orders
        $stmt = $connexion->prepare("
            INSERT INTO orders (order_uuid, user_uuid, order_date, status, total_amount, address, preferences)
            VALUES (:order_uuid, :user_uuid, NOW(), 'pending', :total_amount, :address, :preferences)
        ");
        $stmt->execute([
            ':order_uuid' => $order_uuid,
            ':user_uuid' => $user_uuid,
            ':total_amount' => $grandTotal, // Assurez-vous que le total est correctement calculé
            ':address' => $address,
            ':preferences' => $preferences
        ]);

        // Insérer chaque produit du panier dans la table order_items
        foreach ($_SESSION['cart'] as $item) {
            $meal_uuid = $item['meal_uuid'];
            $quantity = $item['quantity'] ?? 0; // Utiliser l'opérateur null coalescent pour une quantité par défaut de 0
            $unit_price = $item['price'] ?? 0; // Utiliser l'opérateur null coalescent pour un prix par défaut de 0
            $total_price = $quantity * $unit_price; // Calculer le prix total

            // Générer un UUID unique pour chaque item
            $item_id = bin2hex(random_bytes(16)); // Générer un UUID pour chaque item

            // Insérer les éléments de commande
            $stmt = $connexion->prepare("
                INSERT INTO order_items (item_id, order_uuid, meal_uuid, quantity, unit_price, total_price)
                VALUES (:item_id, :order_uuid, :meal_uuid, :quantity, :unit_price, :total_price)
            ");
            $stmt->execute([
                ':item_id' => $item_id, // Utilisez l'UUID généré pour chaque item
                ':order_uuid' => $order_uuid,
                ':meal_uuid' => $meal_uuid,
                ':quantity' => $quantity,
                ':unit_price' => $unit_price,
                ':total_price' => $total_price // S'assurer que le total est correctement calculé
            ]);
        }

        // Commit de la transaction
        $connexion->commit();

        // Vider le panier après validation
        unset($_SESSION['cart']);

        // Définir le message de succès
        $message = "Commande validée avec succès !";
        $messageType = 'success';

        // Rediriger vers menu.php avec le message de succès
        header("Location: menu.php?message=" . urlencode($message) . "&type=" . urlencode($messageType));
        exit;

    } catch (Exception $e) {
        // Annuler la transaction en cas d'erreur
        $connexion->rollBack();
        $message = "Erreur lors de la validation de la commande : " . $e->getMessage();
        $messageType = 'danger';
        
        // Rediriger vers menu.php avec le message d'erreur
        header("Location: menu.php?message=" . urlencode($message) . "&type=" . urlencode($messageType));
        exit;
    }
}
?>
