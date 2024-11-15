<?php
include_once("../database/connexion.php"); // Assurez-vous d'utiliser une connexion PDO
include_once("../fonction/fonction.php");

// Initialiser les messages
$success = '';
$error = '';

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les valeurs du formulaire
    $order_uuid = $_POST['order_uuid'] ?? null; // ID de la commande sélectionnée
    $agent_uuid = $_POST['agent_uuid'] ?? null; // ID de l'agent sélectionné
    $delivery_time = $_POST['delivery_time'] ?? null; //

    if ($order_uuid && $agent_uuid && $delivery_time) {
        try {
            // Commencer une transaction
            $connexion->beginTransaction();

            // Mettre à jour le statut de la commande
            $stmt = $connexion->prepare("
                UPDATE orders 
                SET status = 'in_progress' 
                WHERE order_uuid = :order_uuid
            ");
            $stmt->execute([':order_uuid' => $order_uuid]);

            // Générer un UUID pour la livraison
            $delivery_uuid = bin2hex(random_bytes(16));

            // Insérer une nouvelle entrée dans la table deliveries
            $stmt = $connexion->prepare("
                INSERT INTO deliveries (delivery_uuid, order_uuid, agent_uuid, delivery_status,delivery_time) 
                VALUES (:delivery_uuid, :order_uuid, :agent_uuid,:delivery_time, 'en attente')
            ");
            $stmt->execute([
                ':delivery_uuid' => $delivery_uuid,
                ':order_uuid' => $order_uuid,
                ':agent_uuid' => $agent_uuid,
                ':delivery_time' => $delivery_time
            ]);

            // Mettre à jour la disponibilité de l'agent de livraison
            $stmt = $connexion->prepare("
                UPDATE delivery_agents 
                SET available = 0 
                WHERE agent_uuid = :agent_uuid
            ");
            $stmt->execute([':agent_uuid' => $agent_uuid]);

            // Valider la transaction
            $connexion->commit();

            // Message de succès
            $success = "Commande mise à jour et livraison assignée avec succès.";
        } catch (Exception $e) {
            // Annuler la transaction en cas d'erreur
            $connexion->rollBack();
            $error = "Erreur lors de la mise à jour de la commande : " . $e->getMessage();
        }
    } else {
        $error = "Veuillez sélectionner une commande et un livreur.";
    }
}

// Rediriger vers la page d'origine avec les messages
header("Location: toutes_commandes.php?success=" . urlencode($success) . "&error=" . urlencode($error));
exit;
?>
