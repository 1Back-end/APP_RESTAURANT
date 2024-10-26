<?php
include_once("database/connexion.php");
session_start();
if (isset($_GET['order_uuid']) && isset($_SESSION['user_uuid'])) {
    $order_uuid = $_GET['order_uuid'];
    $user_uuid = $_SESSION['user_uuid'];

    // Vérifiez si l'utilisateur est le propriétaire de la commande
    $stmt = $connexion->prepare("
        SELECT user_uuid FROM orders 
        WHERE order_uuid = :order_uuid
    ");
    $stmt->bindValue(':order_uuid', $order_uuid);
    $stmt->execute();
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($order && $order['user_uuid'] === $user_uuid) {
        // Préparer la requête pour mettre à jour le champ is_deleted
        $stmt = $connexion->prepare("
            UPDATE orders 
            SET is_deleted = 1 
            WHERE order_uuid = :order_uuid
        ");
        
        // Lier la valeur
        $stmt->bindValue(':order_uuid', $order_uuid);

        // Exécuter la requête
        if ($stmt->execute()) {
            $message = "Repas supprimé avec succès !"; // Message de succès
        } else {
            $message = "Erreur lors de la suppression du repas."; // Message d'erreur
        }
    } else {
        $message = "Vous n'êtes pas autorisé à supprimer cette commande.";
    }
} else {
    $message = "Identifiant de commande ou utilisateur manquant.";
}

// Rediriger vers my_orders.php avec un message en paramètre
header("Location: my_orders.php?message=" . urlencode($message));
exit();
?>
