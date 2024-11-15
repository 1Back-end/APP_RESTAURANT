<?php
session_start();
include_once("database/connexion.php");

if (!isset($_SESSION['user_uuid'])) {
    header("Location: login.php");
    exit;
}

function num_order($prefix = 'COM') {
    // Obtenir l'année actuelle
    $year = date('Y');
    // Générer un nombre aléatoire à 6 chiffres
    $randomDigits = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
    // Combiner le préfixe, l'année et les chiffres aléatoires pour former le code final
    $code = $prefix . $year . $randomDigits;
    return $code;
}

$user_uuid = $_SESSION['user_uuid'];
$address = $_POST['address'] ?? '';
$phone_number = $_POST['phone_number'] ?? '';
$preferences = $_POST['preferences'] ?? '';
$grandTotal = 0;

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    $message = "Le panier est vide.";
    header("Location: menu.php?message=" . urlencode($message));
    exit;
} else {
    try {
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

        foreach ($_SESSION['cart'] as $item) {
            $price = $item['price'] ?? 0;
            $quantity = $item['quantity'] ?? 0;
            $grandTotal += $price * $quantity;
        }

        // Générer l'UUID et le numéro de commande
        $order_uuid = bin2hex(random_bytes(16));
        $order_number = num_order(); // Génère le numéro de commande

        if (empty($order_uuid)) {
            throw new Exception("Erreur lors de la génération de l'UUID de commande.");
        }

        // Insérer la commande dans la table orders
        $stmt = $connexion->prepare("
            INSERT INTO orders (order_uuid, user_uuid, order_date, status, total_amount, address, preferences,num_order)
            VALUES (:order_uuid, :user_uuid, NOW(), 'pending', :total_amount, :address, :preferences,:num_order)
        ");
        $stmt->execute([
            ':order_uuid' => $order_uuid,
            ':user_uuid' => $user_uuid,
            ':total_amount' => $grandTotal,
            ':address' => $address,
            ':preferences' => $preferences,
            ':num_order' => $order_number, // Utiliser le numéro de commande généré
        ]);

        foreach ($_SESSION['cart'] as $item) {
            $meal_uuid = $item['meal_uuid'];
            $quantity = $item['quantity'] ?? 0;
            $unit_price = $item['price'] ?? 0;
            $total_price = $quantity * $unit_price;

            $item_id = bin2hex(random_bytes(16));

            $stmt = $connexion->prepare("
                INSERT INTO order_items (item_id, order_uuid, meal_uuid, quantity, unit_price, total_price)
                VALUES (:item_id, :order_uuid, :meal_uuid, :quantity, :unit_price, :total_price)
            ");
            $stmt->execute([
                ':item_id' => $item_id,
                ':order_uuid' => $order_uuid,
                ':meal_uuid' => $meal_uuid,
                ':quantity' => $quantity,
                ':unit_price' => $unit_price,
                ':total_price' => $total_price
            ]);
        }

        $connexion->commit();

        unset($_SESSION['cart']);

        $message = "Commande validée avec succès !";
        $messageType = 'success';

        header("Location: menu.php?message=" . urlencode($message) . "&type=" . urlencode($messageType));
        exit;

    } catch (Exception $e) {
        $connexion->rollBack();
        $message = "Erreur lors de la validation de la commande : " . $e->getMessage();
        $messageType = 'danger';
        
        header("Location: menu.php?message=" . urlencode($message) . "&type=" . urlencode($messageType));
        exit;
    }
}
?>
