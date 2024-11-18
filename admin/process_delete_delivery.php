<?php 
// Inclusion du fichier de connexion à la base de données
include_once("../database/connexion.php");

// Vérifier si le paramètre 'agent_uuid' est défini dans l'URL
if (isset($_GET['agent_uuid'])) {
    // Récupérer l'UUID de l'agent depuis la requête GET
    $agent_uuid = $_GET['agent_uuid'];

    // Vérifier si l'agent est assigné à une livraison non supprimée
    $checkQuery = "
        SELECT COUNT(*) AS delivery_count 
        FROM deliveries 
        WHERE agent_uuid = :agent_uuid AND is_deleted = 0
    ";
    $checkStmt = $connexion->prepare($checkQuery);
    $checkStmt->bindParam(':agent_uuid', $agent_uuid);
    $checkStmt->execute();
    $result = $checkStmt->fetch(PDO::FETCH_ASSOC);

    if ($result['delivery_count'] > 0) {
        // Redirection avec un message d'erreur si l'agent est assigné à une livraison
        header("Location: liste_livreurs.php?msg=L'agent ne peut pas être supprimé car il est assigné à une livraison active.");
        exit(); // Arrêter l'exécution du script après la redirection
    }

    // Préparer la requête SQL pour marquer l'agent comme supprimé
    $stmt = $connexion->prepare("
        UPDATE delivery_agents 
        SET is_deleted = 1 
        WHERE agent_uuid = :agent_uuid
    ");

    // Lier le paramètre 'agent_uuid' à la requête préparée
    $stmt->bindParam(':agent_uuid', $agent_uuid);

    // Exécuter la requête et rediriger en fonction du résultat
    if ($stmt->execute()) {
        // Redirection avec un message de succès
        header("Location: liste_livreurs.php?msg=Livreur supprimé avec succès");
        exit(); // Arrêter l'exécution du script après la redirection
    } else {
        // Redirection avec un message d'erreur
        header("Location: liste_livreurs.php?msg=Erreur de suppression du livreur");
        exit(); // Arrêter l'exécution du script après la redirection
    }
}
?>