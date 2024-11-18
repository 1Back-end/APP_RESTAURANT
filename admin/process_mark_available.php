<?php
// Inclusion du fichier de connexion à la base de données
include_once("../database/connexion.php");

// Vérifier si le paramètre "agent_uuid" est défini dans l'URL
if (isset($_GET["agent_uuid"])) {
    // Récupérer l'UUID de l'agent depuis la requête GET
    $agent_uuid = $_GET["agent_uuid"];

    // Préparer la requête SQL pour mettre à jour la disponibilité de l'agent
    $stmt = $connexion->prepare("
        UPDATE delivery_agents 
        SET available = 1 
        WHERE agent_uuid = :agent_uuid
    ");

    // Lier le paramètre "agent_uuid" à la requête préparée
    $stmt->bindParam(':agent_uuid', $agent_uuid);

    // Exécuter la requête et rediriger avec un message approprié
    if ($stmt->execute()) {
        // Redirection en cas de succès
        header("Location: liste_livreurs.php?message=Livreur marqué disponible avec succès");
        exit();
    } else {
        // Redirection en cas d'erreur
        header("Location: liste_livreurs.php?message=Une erreur est survenue, veuillez réessayer plus tard");
        exit();
    }
}
