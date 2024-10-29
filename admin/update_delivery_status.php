<?php
// Connexion à la base de données
include_once("../database/connexion.php"); // Connexion à la base de données

$erreur = "";
$succes = "";

if (isset($_GET['delivery_uuid']) && isset($_GET['delivery_status'])) {
    $delivery_uuid = $_GET['delivery_uuid'];
    $new_status = $_GET['delivery_status'];

    // Vérification que le nouveau statut est valide
    $valid_statuses = ['en attente', 'en route', 'livré'];
    if (!in_array($new_status, $valid_statuses)) {
        $erreur = "Statut invalide sélectionné.";
    } else {
        try {
            // Récupérer le statut actuel de la livraison
            $stmt = $connexion->prepare("SELECT delivery_status FROM deliveries WHERE delivery_uuid = :delivery_uuid");
            $stmt->execute([':delivery_uuid' => $delivery_uuid]);
            $current_delivery = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$current_delivery) {
                $erreur = "La livraison spécifiée n'existe pas.";
            } else {
                $current_status = $current_delivery['delivery_status'];

                // Vérifier que le statut n'est pas déjà "livré" (donc non modifiable)
                if ($current_status === 'livré') {
                    $erreur = "La livraison est déjà marquée comme 'livré' et ne peut être modifiée.";
                } else {
                    // Mise à jour du statut de livraison
                    $update_stmt = $connexion->prepare("UPDATE deliveries SET delivery_status = :new_status WHERE delivery_uuid = :delivery_uuid");
                    $update_stmt->execute([
                        ':new_status' => $new_status,
                        ':delivery_uuid' => $delivery_uuid,
                    ]);

                    $succes = "Le statut de la livraison a été mis à jour avec succès.";
                }
            }
        } catch (PDOException $e) {
            $erreur = "Erreur lors de la mise à jour : " . $e->getMessage();
        }
    }
} else {
    $erreur = "Paramètres manquants.";
}

// Redirection avec message
header("Location: livraisons_disponibles.php?erreur=" . urlencode($erreur) . "&succes=" . urlencode($succes));
exit;
?>
