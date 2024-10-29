<?php
include_once("../database/connexion.php"); // Connexion à la base de données

// Vérifier si l'ID du repas est fourni
if (isset($_GET['id'])) {
    $meal_uuid = $_GET['id'];

    // Préparer la requête pour effectuer la suppression logique
    $sql = "UPDATE meals SET is_deleted = 1 WHERE meal_uuid = :meal_uuid";
    
    $stmt = $connexion->prepare($sql);
    
    // Exécuter la requête avec le paramètre meal_uuid
    if ($stmt->execute([':meal_uuid' => $meal_uuid])) {
        // Redirection avec un message de succès après la suppression
        header('Location: liste_repas.php?status=deleted');
        exit;
    } else {
        // Redirection avec un message d'erreur en cas d'échec
        header('Location: liste_repas.php?status=error');
        exit;
    }
} else {
    // Redirection si l'ID est manquant ou invalide
    header('Location: liste_repas.php?status=invalid');
    exit;
}
