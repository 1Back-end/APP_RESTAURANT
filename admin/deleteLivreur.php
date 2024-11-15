<?php
include_once("../database/connexion.php");

if (isset($_POST['agent_uuid'])) {
    $agent_uuid = $_POST['agent_uuid'];
    
    // Préparer la requête SQL pour la suppression
    $stmt = $connexion->prepare("UPDATE livreur SET is_deleted = 1 WHERE agent_uuid = :agent_uuid");
    $stmt->bindParam(':agent_uuid', $agent_uuid);
    
    if ($stmt->execute()) {
        // Message de succès
        header("Location: liste_livreurs.php?status=success&message=Livreur+supprimé+avec+succès");
    } else {
        // Message d'erreur
        header("Location: liste_livreurs.php?status=error&message=Erreur+de+suppression+du+livreur");
    }
    exit();
}
