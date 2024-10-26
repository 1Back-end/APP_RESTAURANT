<?php
session_start();
include_once("database/connexion.php");
include_once("fonction/fonction.php");
// Vérifiez si les paramètres sont passés dans l'URL
if (isset($_GET['user_uuid']) && isset($_GET['meal_uuid'])) {
    $user_uuid = $_GET['user_uuid'];
    $meal_uuid = $_GET['meal_uuid'];
    $order_uuid = generateUUID(); // Fonction pour générer un UUID

    // Préparer la requête d'insertion
    $stmt = $connexion->prepare("
        INSERT INTO orders (order_uuid, user_uuid, meal_uuid, order_date, status) 
        VALUES (:order_uuid, :user_uuid, :meal_uuid, NOW(), 'pending')
    ");

    // Lier les valeurs
    $stmt->bindValue(':order_uuid', $order_uuid);
    $stmt->bindValue(':user_uuid', $user_uuid);
    $stmt->bindValue(':meal_uuid', $meal_uuid);

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
