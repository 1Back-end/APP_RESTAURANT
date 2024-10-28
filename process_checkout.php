<?php
session_start();
require 'vendor/autoload.php';
include_once("database/connexion.php");

use Stripe\Stripe;
use Stripe\PaymentIntent;

// Définir votre clé API Stripe (remplacez par votre clé secrète)
Stripe::setApiKey('sk_test_51PvK3l08QILWwY1ztJaryXP5o5GwQLKyf6enbJr6cnbO06R1p8ld4HKqNrYzOdFUF6UH1Fz8kwj47UfS0c2n5lmi00Sijvkwu7');

if (!isset($_SESSION['user_uuid'])) {
    echo json_encode(['message' => "Erreur : utilisateur non connecté."]);
    exit;
}

$user_uuid = $_SESSION['user_uuid'];
$address = $_POST['address'] ?? '';
$phone = $_POST['phone'] ?? '';

// Récupérer les informations de la commande
$orders_stmt = $connexion->prepare("
    SELECT * FROM orders WHERE user_uuid = :user_uuid AND is_deleted = 0
");
$orders_stmt->bindValue(':user_uuid', $user_uuid);
$orders_stmt->execute();
$orders = $orders_stmt->fetchAll(PDO::FETCH_ASSOC);

// Vérifiez si les données de commande sont présentes
if (empty($orders)) {
    echo json_encode(['message' => "Erreur : aucune commande trouvée."]);
    exit;
}

// Vérifiez si l'ID de méthode de paiement est présent
if (empty($_POST['paymentMethodId'])) {
    echo json_encode(['message' => "Erreur : L'ID de méthode de paiement est manquant."]);
    exit;
}

// Calculer le total
$grandTotal = 0;
foreach ($orders as $order) {
    if (!isset($order['price'], $order['quantity'])) {
        echo json_encode(['message' => "Erreur : prix ou quantité manquant dans les données de commande."]);
        exit;
    }
    $grandTotal += $order['price'] * $order['quantity']; // Calculer le total
}

$amountInCents = $grandTotal * 100; // Montant en cents

try {
    // Créer un PaymentIntent
    $paymentIntent = PaymentIntent::create([
        'amount' => $amountInCents,
        'currency' => 'usd', // Changez cela selon votre devise
        'payment_method' => $_POST['paymentMethodId'],
        'confirm' => true,
    ]);

    // Mettez à jour les informations de l'utilisateur
    $update_stmt = $connexion->prepare("
        UPDATE users 
        SET address = :address, phone_number = :phone_number 
        WHERE user_uuid = :user_uuid
    ");
    $update_stmt->bindValue(':address', $address);
    $update_stmt->bindValue(':phone_number', $phone);
    $update_stmt->bindValue(':user_uuid', $user_uuid);
    $update_stmt->execute();

    // Enregistrer chaque article de commande dans la table order_items
    foreach ($orders as $order) {
        $orderItemUUID = generateUUID(); // Fonction pour générer un UUID
        $stmt = $connexion->prepare("
            INSERT INTO order_items (order_item_uuid, order_uuid, user_uuid, meal_uuid, quantity, price_at_order) 
            VALUES (:order_item_uuid, :order_uuid, :user_uuid, :meal_uuid, :quantity, :price_at_order)
        ");
        $stmt->bindValue(':order_item_uuid', $orderItemUUID);
        $stmt->bindValue(':order_uuid', $order['order_uuid']); // Utilisez l'UUID de la commande
        $stmt->bindValue(':user_uuid', $user_uuid);
        $stmt->bindValue(':meal_uuid', $order['meal_uuid']);
        $stmt->bindValue(':quantity', $order['quantity']);
        $stmt->bindValue(':price_at_order', $order['price']);
        $stmt->execute();
    }

    // Répondre avec un succès
    echo json_encode(['message' => 'Paiement réussi et commande enregistrée.']);
} catch (\Stripe\Exception\ApiErrorException $e) {
    // Gérer les erreurs de paiement
    echo json_encode(['message' => 'Erreur de paiement: ' . $e->getMessage()]);
}
