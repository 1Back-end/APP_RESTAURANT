<?php
// Inclusion des fichiers de connexion à la base de données et des fonctions
include_once("../database/connexion.php"); // Utilisation de PDO pour la connexion
include_once("../fonction/fonction.php");

$erreur_champ = ""; // Message d'erreur pour les champs obligatoires
$erreur = ""; // Message d'erreur pour les requêtes échouées
$success = ""; // Message de succès pour les requêtes réussies

// Vérification si le formulaire est soumis
if (isset($_POST['submit'])) {
    // Récupération des valeurs du formulaire
    $cancellation_reason = $_POST['cancellation_reason'] ?? null;
    $order_id = $_POST['order_id'] ?? null;
    $cancel_uuid = generateUUID(); // Génération d'un UUID pour l'identifiant d'annulation
    $added_by = $_SESSION['admin_uuid'] ?? null; // Récupération de l'ID de l'utilisateur connecté

    // Vérification si le champ "raison d'annulation" est vide
    if (empty($cancellation_reason)) {
        $erreur_champ = "Le champ 'raison d'annulation' est obligatoire.";
    } else {
        try {
            // Démarrer une transaction pour s'assurer que les deux opérations réussissent ensemble
            $connexion->beginTransaction();

            // Mise à jour du statut de la commande
            $update_order = $connexion->prepare("UPDATE orders SET status='Canceled' WHERE order_uuid = :order_id");
            $update_order->bindValue(':order_id', $order_id);
            if ($update_order->execute()) {
                // Insertion dans la table order_cancel si la mise à jour est réussie
                $sqlInsert = $connexion->prepare("INSERT INTO cancel_order (cancel_uuid, order_uuid, cancellation_reason, added_by) VALUES (:cancel_uuid, :order_id, :cancellation_reason, :added_by)");
                $sqlInsert->bindValue(':cancel_uuid', $cancel_uuid);
                $sqlInsert->bindValue(':order_id', $order_id);
                $sqlInsert->bindValue(':cancellation_reason', $cancellation_reason);
                $sqlInsert->bindValue(':added_by', $added_by);

                if ($sqlInsert->execute()) {
                    // Validation de la transaction si l'insertion réussit
                    $connexion->commit();
                    $success = "La commande a été annulée avec succès.";
                } else {
                    // Annulation de la transaction si l'insertion échoue
                    $connexion->rollBack();
                    $erreur = "Erreur lors de l'ajout de l'annulation de la commande.";
                }
            } else {
                // Annulation de la transaction si la mise à jour échoue
                $connexion->rollBack();
                $erreur = "Erreur lors de la mise à jour du statut de la commande.";
            }
        } catch (Exception $e) {
            // En cas d'erreur, annuler la transaction et afficher l'erreur
            $connexion->rollBack();
            $erreur = "Erreur : " . $e->getMessage();
        }
    }
}

// Afficher les messages d'erreur ou de succès
?>
