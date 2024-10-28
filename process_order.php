<?php
session_start();
include_once("database/connexion.php");
include_once("fonction/fonction.php");

// Vérifiez si les paramètres sont passés dans l'URL
if (isset($_GET['user_uuid'], $_GET['meal_uuid'], $_GET['quantity'])) {
    $user_uuid = $_GET['user_uuid'];
    $meal_uuid = $_GET['meal_uuid'];
    $quantity = (int)$_GET['quantity']; // Conversion en entier pour éviter les injections
    $order_uuid = generateUUID(); // Fonction pour générer un UUID

    // Préparer la requête d'insertion
    $stmt = $connexion->prepare("
        INSERT INTO orders (order_uuid, user_uuid, meal_uuid, quantity, order_date, status) 
        VALUES (:order_uuid, :user_uuid, :meal_uuid, :quantity, NOW(), 'pending')
    ");

    // Lier les valeurs
    $stmt->bindValue(':order_uuid', $order_uuid);
    $stmt->bindValue(':user_uuid', $user_uuid);
    $stmt->bindValue(':meal_uuid', $meal_uuid);
    $stmt->bindValue(':quantity', $quantity);

    // Exécuter la requête
    if ($stmt->execute()) {
        $success = "Commande passée avec succès !"; // Message de succès
    } else {
        $error = "Erreur lors de la passation de la commande : " . implode(", ", $stmt->errorInfo()); // Message d'erreur
    }
} else {
    $error = "Données manquantes."; // Message pour les données manquantes
}

// Redirection vers la page d'accueil ou la page souhaitée avec message dans l'URL
$redirect_url = 'menu.php';
if (isset($success)) {
    $redirect_url .= '?success=' . urlencode($success);
} elseif (isset($error)) {
    $redirect_url .= '?error=' . urlencode($error);
}

header('Location: ' . $redirect_url);
exit();
?>
